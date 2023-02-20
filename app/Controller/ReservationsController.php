<?php


App::uses('AppController', 'Controller');

/**
 * Reservation Controller
 *
 * @property Reservation $Reservation
 * @property Supplier $Supplier
 * @property Company $Company
 * @property Profile $Profile
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class ReservationsController extends AppController {
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Security','RequestHandler');
    public $uses = array('Reservation','Supplier','Company', 'Profile');
    var $helpers = array('Xls');
    /**
     * @param null $params
     * @param $
     * @param null $orderType
     * @return array
     */
    public function getOrder ($params = null  , $orderType = null){

        if($orderType == null){
            $orderType = 'DESC';
        }
        if (isset($params) && is_numeric($params)) {
            switch ($params) {
                case 1 :
                    $order = array('Reservation.created' => $orderType);
                    break;
                case 2 :
                    $order = array('Reservation.id' => $orderType);
                    break;
                default : $order = array('Reservation.id' => $orderType);
            }
            return $order;
        } else {
            $order = array('Reservation.id' => $orderType);
            return $order;
        }
    }
    public function index() {
            $offShore = $this->hasModuleOffShore();
            if($offShore==0){
                return $this->redirect('/');
            }
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::reservation_affretement, $user_id,
            ActionsEnum::view, "Reservations", null, "Reservation", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();
        switch ($result) {
            case 1 :
                $conditions = null;
                break;
            case 2 :
                $conditions = array('Reservation.user_id ' => $user_id);
                break;
            case 3 :
                $conditions = array('Reservation.user_id !=' => $user_id);
                break;
            default:
                $conditions = null;
        }
        $this->paginate = array(
            'recursive' => -1,
            'limit' => $limit,
            'order' => $order,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'group' => 'Reservation.id',
            'fields' => array(
                'Reservation.id',
                'Reservation.cost',
                'Reservation.amount_remaining',
                'Reservation.advanced_amount',
                'Reservation.status',
                'SheetRideDetailRides.reference',
                'SheetRideDetailRides.planned_start_date',
                'SheetRideDetailRides.real_start_date',
                'SheetRideDetailRides.planned_end_date',
                'SheetRideDetailRides.real_end_date',
                'SheetRideDetailRides.price_recovered',
                'TransportBillDetailRides.price_ht',
                'TransportBillDetailRides.nb_trucks',
                'Car.code',
                'Car.immatr_def',
                'Carmodel.name',
                'Supplier.id',
                'Supplier.name',
                'Payments.receipt_date',
            ),
            'joins' => array(
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Reservation.car_id = Car.id')
                ),
                array(
                    'table' => 'sheet_ride_detail_rides',
                    'type' => 'left',
                    'alias' => 'SheetRideDetailRides',
                    'conditions' => array('Reservation.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
                ),
                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                ),
                array(
                    'table' => 'transport_bill_detail_rides',
                    'type' => 'left',
                    'alias' => 'TransportBillDetailRides',
                    'conditions' => array('SheetRideDetailRides.transport_bill_detail_ride_id = TransportBillDetailRides.id')
                ),
                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('TransportBill.id = TransportBillDetailRides.transport_bill_id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Reservation.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'detail_payments',
                    'type' => 'left',
                    'alias' => 'DetailPayments',
                    'conditions' => array('DetailPayments.reservation_id = Reservation.id')
                ),
                array(
                    'table' => 'payments',
                    'type' => 'left',
                    'alias' => 'Payments',
                    'conditions' => array('DetailPayments.payment_id = Payments.id')
                )
            )
        );
        $this->set('reservations', $this->Paginator->paginate('Reservation'));
        //Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $separatorAmount = $this->getSeparatorAmount();
        $users = $this->User->find('list', array('conditions' => 'User.id != 1'));
        $profiles = $this->Profile->getUserProfiles();
        $suppliers = $this->Supplier->getSuppliersByParams(0, 1, array(1));
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name )"
            );
        } elseif ($param == 2) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(Car.immatr_def,Car.immatr_prov), ' - ', Carmodel.name)"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames',
            'recursive' => -1,
            'order' => 'Car.code ASC',
            'conditions'=>array('Car.car_parc'=>2),
            'joins' => array(
                array(
                    'table' => 'marks',
                    'type' => 'left',
                    'alias' => 'Mark',
                    'conditions' => array('Car.mark_id = Mark.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'customer_car',
                    'type' => 'left',
                    'alias' => 'CustomerCar',
                    'conditions' => array('Car.id = CustomerCar.car_id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('CustomerCar.customer_id = Customer.id')
                )
            )));
        $isSuperAdmin = $this->isSuperAdmin();
        $this->set(compact('limit','order','param','separatorAmount','suppliers','users','profiles','cars','isSuperAdmin'));
    }

    /**
     * index method
     *
     * @return void
     */

    public function search()
    {
        $offShore = $this->hasModuleOffShore();
        if($offShore==0){
            return $this->redirect('/');
        }
        $this->settimeactif();
        if (isset($this->request->data['keyword']) || isset($this->request->data['Reservations']['car_id'])
            || isset($this->request->data['Reservations']['cost']) || isset($this->request->data['Reservations']['supplier_id'])
            || isset($this->request->data['Reservations']['user_id']) || isset($this->request->data['Reservations']['modified_id'])
            || isset($this->request->data['Reservations']['created']) || isset($this->request->data['Reservations']['created1'])
            || isset($this->request->data['Reservations']['modified']) || isset($this->request->data['Reservations']['modified1'])
            || isset($this->request->data['Reservations']['date1']) || isset($this->request->data['Reservations']['date2'])
            || isset($this->request->data['Reservations']['profile_id'])|| isset($this->request->data['Reservations']['order_type'])
            || isset($this->request->data['Reservations']['status'])
        ) {
            $this->filterUrl();
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Reservation.id' => 'DESC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword']) || isset($this->params['named']['car'])
            || isset($this->params['named']['supplier']) || isset($this->params['named']['cost'])
            || isset($this->params['named']['user']) || isset($this->params['named']['modified_id'])
            || isset($this->params['named']['created']) || isset($this->params['named']['created1'])
            || isset($this->params['named']['modified']) || isset($this->params['named']['modified1'])
            || isset($this->params['named']['profile'])|| isset($this->params['named']['order_type'])
            || isset($this->params['named']['status'])
            || isset($this->params['named']['date1']) || isset($this->params['named']['date2'])
        ) {
            $conditions = $this->getConds();
            $this->paginate = array(
                'recursive' => -1,
                'limit' => $limit,
                'order' => $order,
                'conditions' => $conditions,
                'paramType' => 'querystring',
                'fields' => array(
                    'Reservation.id',
                    'Reservation.cost',
                    'Reservation.amount_remaining',
                    'Reservation.advanced_amount',
                    'Reservation.status',
                    'SheetRideDetailRides.reference',
                    'SheetRideDetailRides.planned_start_date',
                    'SheetRideDetailRides.real_start_date',
                    'SheetRideDetailRides.planned_end_date',
                    'SheetRideDetailRides.real_end_date',
                    'SheetRideDetailRides.price_recovered',
                    'TransportBillDetailRides.unit_price',
                    'Car.code',
                    'Car.immatr_def',
                    'Carmodel.name',
                    'Supplier.name',
                    'Supplier.id',
                    'Payments.receipt_date',
                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('Reservation.car_id = Car.id')
                    ),
                    array(
                        'table' => 'sheet_ride_detail_rides',
                        'type' => 'left',
                        'alias' => 'SheetRideDetailRides',
                        'conditions' => array('Reservation.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
                    ),
                    array(
                        'table' => 'sheet_rides',
                        'type' => 'left',
                        'alias' => 'SheetRide',
                        'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                    ),
                    array(
                        'table' => 'transport_bill_detail_rides',
                        'type' => 'left',
                        'alias' => 'TransportBillDetailRides',
                        'conditions' => array('SheetRideDetailRides.transport_bill_detail_ride_id = TransportBillDetailRides.id')
                    ),
                    array(
                        'table' => 'transport_bills',
                        'type' => 'left',
                        'alias' => 'TransportBill',
                        'conditions' => array('TransportBill.id = TransportBillDetailRides.transport_bill_id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('Reservation.supplier_id = Supplier.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),
                    array(
                        'table' => 'detail_payments',
                        'type' => 'left',
                        'alias' => 'DetailPayments',
                        'conditions' => array('DetailPayments.reservation_id = Reservation.id')
                    ),
                    array(
                        'table' => 'payments',
                        'type' => 'left',
                        'alias' => 'Payments',
                        'conditions' => array('DetailPayments.payment_id = Payments.id')
                    )
                )
            );
            $this->set('reservations', $this->Paginator->paginate('Reservation'));
        } else {
            $this->paginate = array(
                'recursive' => -1,
                'limit' => $limit,
                'order' => $order,
                'paramType' => 'querystring',
                'fields' => array(
                    'Reservation.id',
                    'Reservation.cost',
                    'Reservation.amount_remaining',
                    'Reservation.advanced_amount',
                    'Reservation.status',
                    'SheetRideDetailRides.reference',
                    'SheetRideDetailRides.planned_start_date',
                    'SheetRideDetailRides.real_start_date',
                    'SheetRideDetailRides.planned_end_date',
                    'SheetRideDetailRides.real_end_date',
                    'SheetRideDetailRides.price_recovered',
                    'TransportBillDetailRides.unit_price',
                    'Car.code',
                    'Car.immatr_def',
                    'Carmodel.name',
                    'Supplier.id',
                    'Supplier.name',
                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('Reservation.car_id = Car.id')
                    ),
                    array(
                        'table' => 'sheet_ride_detail_rides',
                        'type' => 'left',
                        'alias' => 'SheetRideDetailRides',
                        'conditions' => array('Reservation.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
                    ),
                    array(
                        'table' => 'sheet_rides',
                        'type' => 'left',
                        'alias' => 'SheetRide',
                        'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                    ),
                    array(
                        'table' => 'transport_bill_detail_rides',
                        'type' => 'left',
                        'alias' => 'TransportBillDetailRides',
                        'conditions' => array('SheetRideDetailRides.transport_bill_detail_ride_id = TransportBillDetailRides.id')
                    ),
                    array(
                        'table' => 'transport_bills',
                        'type' => 'left',
                        'alias' => 'TransportBill',
                        'conditions' => array('TransportBill.id = TransportBillDetailRides.transport_bill_id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('SheetRide.supplier_id = Supplier.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    )
                )
            );
            $this->set('reservations', $this->Paginator->paginate('Reservation'));
        }
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $separatorAmount = $this->getSeparatorAmount();
        $users = $this->User->find('list', array('conditions' => 'User.id != 1'));
        $profiles = $this->Profile->getUserProfiles();
        $suppliers = $this->Supplier->getSuppliersByParams(0, 1, array(1));
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name )"
            );
        } elseif ($param == 2) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(Car.immatr_def,Car.immatr_prov), ' - ', Carmodel.name)"
            );
        }
        $cars = $this->Car->find('list', array(
            'fields' => 'cnames',
            'recursive' => -1,
            'order' => 'Car.code ASC',
            'conditions' => array('Car.car_parc' => 2),
            'joins' => array(
                array(
                    'table' => 'marks',
                    'type' => 'left',
                    'alias' => 'Mark',
                    'conditions' => array('Car.mark_id = Mark.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'customer_car',
                    'type' => 'left',
                    'alias' => 'CustomerCar',
                    'conditions' => array('Car.id = CustomerCar.car_id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('CustomerCar.customer_id = Customer.id')
                )
            )
        ));
        $isSuperAdmin = $this->isSuperAdmin();
        $this->set(compact('limit', 'order', 'param', 'separatorAmount',
            'suppliers', 'users', 'profiles', 'cars','isSuperAdmin'));
        $this->render();
    }

    private function filterUrl()
    {
        $filter_url['controller'] = $this->request->params['controller'];
        $filter_url['action'] = $this->request->params['action'];
        $filter_url['page'] = 1;
        $filter_url['keyword'] = $this->request->data['keyword'];
        if (isset($this->request->data['Reservations']['car_id']) && !empty($this->request->data['Reservations']['car_id'])) {
            $filter_url['car'] = $this->request->data['Reservations']['car_id'];
        }
        if (isset($this->request->data['Reservations']['supplier_id']) && !empty($this->request->data['Reservations']['supplier_id'])) {
            $filter_url['supplier'] = $this->request->data['Reservations']['supplier_id'];
        }
        if (isset($this->request->data['Reservations']['cost']) && !empty($this->request->data['Reservations']['cost'])) {
            $filter_url['cost'] = $this->request->data['Reservations']['cost'];
        }
        if (isset($this->request->data['Reservations']['order_type']) && !empty($this->request->data['Reservations']['order_type'])) {
            $filter_url['order_type'] = $this->request->data['Reservations']['order_type'];
        }
        if (isset($this->request->data['Reservations']['status']) && !empty($this->request->data['Reservations']['status'])) {
            $filter_url['status'] = $this->request->data['Reservations']['status'];
        }
        if (isset($this->request->data['Reservations']['user_id']) && !empty($this->request->data['Reservations']['user_id'])) {
            $filter_url['user'] = $this->request->data['Reservations']['user_id'];
        }
        if (isset($this->request->data['Reservations']['profile_id']) && !empty($this->request->data['Reservations']['profile_id'])) {
            $filter_url['profile'] = $this->request->data['Reservations']['profile_id'];
        }
        if (isset($this->request->data['Reservations']['created']) && !empty($this->request->data['Reservations']['created'])) {
            $filter_url['created'] = str_replace("/", "-", $this->request->data['Reservations']['created']);
        }
        if (isset($this->request->data['Reservations']['created1']) && !empty($this->request->data['Reservations']['created1'])) {
            $filter_url['created1'] = str_replace("/", "-", $this->request->data['Reservations']['created1']);
        }
        if (isset($this->request->data['Reservations']['modified_id']) && !empty($this->request->data['Reservations']['modified_id'])) {
            $filter_url['modified_id'] = $this->request->data['Reservations']['modified_id'];
        }
        if (isset($this->request->data['Reservations']['modified']) && !empty($this->request->data['Reservations']['modified'])) {
            $filter_url['modified'] = str_replace("/", "-", $this->request->data['Reservations']['modified']);
        }
        if (isset($this->request->data['Reservations']['modified1']) && !empty($this->request->data['Reservations']['modified1'])) {
            $filter_url['modified1'] = str_replace("/", "-", $this->request->data['Reservations']['modified1']);
        }
        if (isset($this->request->data['Reservations']['date1']) && !empty($this->request->data['Reservations']['date1'])) {
            $filter_url['date1'] = str_replace("/", "-", $this->request->data['Reservations']['date1']);
        }
        if (isset($this->request->data['Reservations']['date2']) && !empty($this->request->data['Reservations']['date2'])) {
            $filter_url['date2'] = str_replace("/", "-", $this->request->data['Reservations']['date2']);
        }
        return $this->redirect($filter_url);
    }

    private function getConds()
    {
        if (!empty($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $conds = array(
                'OR' => array(
                    "LOWER(Reservation.cost) LIKE" => "%$keyword%",
                    "LOWER(Supplier.name) LIKE" => "%$keyword%",
                    "LOWER(Car.immatr_def) LIKE" => "%$keyword%",
                    "LOWER(Car.code) LIKE" => "%$keyword%",
                    "LOWER(Carmodel.name) LIKE" => "%$keyword%",
                )
            );
        } else {
            $conds = array();
        }
        if (isset($this->params['named']['car']) && !empty($this->params['named']['car'])) {
            $conds["Car.id = "] = $this->params['named']['car'];
            $this->request->data['Reservations']['car_id'] = $this->params['named']['car'];
        }
        if (isset($this->params['named']['supplier']) && !empty($this->params['named']['supplier'])) {
            $conds["Supplier.id = "] = $this->params['named']['supplier'];
            $this->request->data['Reservations']['supplier_id'] = $this->params['named']['supplier'];
        }
        if (isset($this->params['named']['order_type']) && !empty($this->params['named']['order_type'])) {
            $conds["TransportBill.order_type = "] = $this->params['named']['order_type'];
            $this->request->data['Reservations']['order_type'] = $this->params['named']['order_type'];
        }
        if (isset($this->params['named']['status']) && !empty($this->params['named']['status'])) {
            $conds["Reservation.status = "] = $this->params['named']['status'];
            $this->request->data['Reservations']['status'] = $this->params['named']['status'];
        }
        if (isset($this->params['named']['cost']) && !empty($this->params['named']['cost'])) {
            $conds["Reservation.cost >= "] = $this->params['named']['cost'];
            $this->request->data['Reservations']['cost'] = $this->params['named']['cost'];
        }

        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $conds["Reservation.user_id = "] = $this->params['named']['user'];
            $this->request->data['Reservations']['user_id'] = $this->params['named']['user'];
        }
        if (isset($this->params['named']['profile']) && !empty($this->params['named']['profile'])) {
            $conds["User.profile_id = "] = $this->params['named']['profile'];
            $this->request->data['Reservations']['profile_id'] = $this->params['named']['profile'];
        }
        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $creat = str_replace("-", "/", $this->params['named']['created']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Reservation.created >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Reservations']['created'] = $creat;
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $creat = str_replace("-", "/", $this->params['named']['created1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Reservation.created <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Reservations']['created1'] = $creat;
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $conds["Reservation.last_modifier_id = "] = $this->params['named']['modified_id'];
            $this->request->data['Reservations']['modified_id'] = $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Reservation.modified >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Reservations']['modified'] = $creat;
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Reservation.modified <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Reservations']['modified1'] = $creat;
        }
        if (isset($this->params['named']['date1']) && !empty($this->params['named']['date1'])) {
            $creat = str_replace("-", "/", $this->params['named']['date1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRideDetailRides.real_start_date >= "] = $startdtm->format('Y-m-d');
            $this->request->data['Reservations']['date1'] = $creat;
        }

        if (isset($this->params['named']['date2']) && !empty($this->params['named']['date2'])) {
            $creat = str_replace("-", "/", $this->params['named']['date2']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRideDetailRides.real_start_date <= "] = $startdtm->format('Y-m-d');

            if (!empty($condsDate2)) {
                array_push($conds,$condsDate2);
            }
            $this->request->data['Reservations']['date2'] = $creat;
        }

       // var_dump($conds); die();
        return $conds;
    }
    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null)
    {
        $offShore = $this->hasModuleOffShore();
        if($offShore==0){
            return $this->redirect('/');
        }
        $this->setTimeActif();
        if (!$this->Reservation->exists($id)) {
            throw new NotFoundException(__('Invalid reservation'));
        }
        $options = array('conditions' => array('Reservation.' . $this->Reservation->primaryKey => $id));
        $this->set('reservation', $this->Reservation->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {

        $offShore = $this->hasModuleOffShore();
        if($offShore==0){
            return $this->redirect('/');
        }
        $this->setTimeActif();

        //$this->verifyAuditor("CarTypes");
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::reservation_affretement, $user_id, ActionsEnum::add,
            "Reservations", null, "Reservation", null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->layout = 'ajax';
                $this->redirect(array('action' => 'index'));
            }

            $this->Reservation->create();
            $this->request->data['Reservation']['user_id'] = $this->Session->read('Auth.User.id');


            if ($this->Reservation->save($this->request->data)) {

                $this->Flash->success(__('The reservation has been saved.'));
                $this->redirect(array('action' => 'index'));

            } else {
                $this->Flash->error(__('The reservation could not be saved. Please, try again.'));
            }


        }


    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null)
    {

        $offShore = $this->hasModuleOffShore();
        if($offShore==0){
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::reservation_affretement, $user_id, ActionsEnum::edit,
            "Reservations", $id, "Reservation", null);
        if (!$this->Reservation->exists($id)) {
            throw new NotFoundException(__('Invalid reservation'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Reservation cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Reservation']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Marchandise->save($this->request->data)) {
                $this->Flash->success(__('The reservation has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The reservation could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Reservation.' . $this->Reservation->primaryKey => $id));
            $this->request->data = $this->Reservation->find('first', $options);

        }

    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null)
    {
        $offShore = $this->hasModuleOffShore();
        if($offShore==0){
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::reservation_affretement, $user_id, ActionsEnum::delete,
            "Reservations", $id, "Reservation", null);
        $this->Reservation->id = $id;
        if (!$this->Reservation->exists()) {
            throw new NotFoundException(__('Invalid reservation'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Reservation->delete()) {
            $this->Flash->success(__('The reservation has been deleted.'));
        } else {
            $this->Flash->error(__('The reservation could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteReservations()
    {
        $offShore = $this->hasModuleOffShore();
        if($offShore==0){
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $this->autoRender = false;
        $user_id = $this->Auth->user('id');

        $id = filter_input(INPUT_POST, "id");
        $this->verifyUserPermission(SectionsEnum::reservation_affretement, $user_id, ActionsEnum::delete,
            "Reservations", $id, "Reservation", null);
        $this->Reservation->id = $id;
        // $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Reservation->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }        /*}else{
            echo json_encode(array("response" => "false"));
        }*/
    }

    function export()
    {
        $this->setTimeActif();
        $Marchandises = $this->Marchandise->find('all', array(
            'order' => 'Marchandise.name asc',
            'recursive' => 2
        ));
        $this->set('models', $Marchandises);
    }

    // update cell
    function update()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $value = filter_input(INPUT_POST, "value");
        $crypto = $this->decrypt(filter_input(INPUT_POST, "crypto"));
        $explode = explode('|', $crypto);
        $id = $explode[1];

        $reservation = $this->Reservation->find('first', array(
            'recursive' => -1,
            'conditions' => array('Reservation.id' => $id),
            'fields' => array('Reservation.id', 'Car.supplier_id', 'Reservation.cost'),
            'joins' => array(
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Reservation.car_id = Car.id')
                ),
            )
        ));
        $supplierId = $reservation['Car']['supplier_id'];
        $precedentCost = $reservation['Reservation']['cost'];

        if (!empty($reservation)) {
            $reservation['Reservation']['cost'] = $value;
            $reservation['Reservation']['amount_remaining'] = $value;
            $this->Reservation->save($reservation);
            $supplier = $this->Supplier->getSuppliersById($supplierId);
            $newBalance = $supplier['Supplier']['balance'] + $precedentCost + (-$value);
            $this->Supplier->id = $supplierId;
            $this->Supplier->saveField('balance', $newBalance);
        }
    }

	public function printReservationPerSupplier()
    {
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        $array = filter_input(INPUT_POST, "printReservationPerSupplier");
        $arrayConditions = explode(",", $array);
        $carId = $arrayConditions[0];
        $supplierId = $arrayConditions[1];
        $startDate = $arrayConditions[2];
        $endDate = $arrayConditions[3];
        $conditions = array();
        if (!empty($carId)) {
            $conditions["Reservation.car_id"] = $carId;
        }
        if (!empty($supplierId)) {
            $conditions["Supplier.id"] = $supplierId;
        }
        if (!empty($startDate)) {
            $start = str_replace("-", "/", $startDate);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $conditions["SheetRide.start_date"] = $startdtm->format('Y-m-d 00:00:00');
        }
        if (!empty($endDate)) {
            $end = str_replace("-", "/", $endDate);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $conditions["SheetRide.end_date"] = $enddtm->format('Y-m-d 00:00:00');;
        }
        $ids = filter_input(INPUT_POST, "chkids");
        if (!empty($ids)) {
            $array_ids = explode(",", $ids);
            if (!empty($array_ids)) {
                $conditions["Reservation.id"] = $array_ids;
            }
        }

        $reservations = $this->Reservation->find('all', array(
                'recursive' => -1,
                'conditions' => $conditions,
                'order' => 'Supplier.id DESC',
                'paramType' => 'querystring',
                'fields' => array(
                    'Reservation.id',
                    'Reservation.cost',
                    'Reservation.amount_remaining',
                    'Reservation.advanced_amount',
                    'Reservation.status',
                    'SheetRideDetailRide.reference',
                    'SheetRideDetailRide.planned_start_date',
                    'SheetRideDetailRide.real_start_date',
                    'SheetRideDetailRide.planned_end_date',
                    'SheetRideDetailRide.real_end_date',
                    'Reservation.car_id',
                    'Car.code',
                    'Car.immatr_def',
                    'Carmodel.name',
                    'Supplier.id',
                    'Supplier.name'
                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('Reservation.car_id = Car.id')
                    ),
                    array(
                        'table' => 'sheet_ride_detail_rides',
                        'type' => 'left',
                        'alias' => 'SheetRideDetailRide',
                        'conditions' => array('Reservation.sheet_ride_detail_ride_id = SheetRideDetailRide.id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('Car.supplier_id = Supplier.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    )
                )
            )
        );

        $param = $this->Parameter->getCodesParameterVal('name_car');
        $company = $this->Company->find('first');
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('reservations', 'param', 'company', 'separatorAmount'));

    }

    public function printReservationPerCar()
    {
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        $array = filter_input(INPUT_POST, "printReservationPerCar");

        $arrayConditions = explode(",", $array);
        $carId = $arrayConditions[0];
        $supplierId = $arrayConditions[1];
        $startDate = $arrayConditions[2];
        $endDate = $arrayConditions[3];
        $conditions = array();
        if (!empty($carId)) {
            $conditions["Reservation.car_id"] = $carId;
        }

        if (!empty($supplierId)) {
            $conditions["Supplier.id"] = $supplierId;
        }
        if (!empty($startDate)) {
            $date_from = str_replace("/", "-", $startDate);
            $start = str_replace("-", "/", $date_from);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $conditions["SheetRide.start_date"] = $startdtm->format('Y-m-d H:i:s');
        }
        if (!empty($endDate)) {
            $date_to = str_replace("/", "-", $endDate);
            $end = str_replace("-", "/", $date_to);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $conditions["SheetRide.end_date"] = $enddtm->format('Y-m-d H:i:s');
        }
        $ids = filter_input(INPUT_POST, "chkids");
        if (!empty($ids)) {
            $array_ids = explode(",", $ids);
            if (!empty($array_ids)) {
                $conditions["Reservation.id"] = $array_ids;
            }
        }

        $reservations = $this->Reservation->find('all', array(
                'recursive' => -1,
                'conditions' => $conditions,
                'order' => 'Car.id DESC',
                'paramType' => 'querystring',
                'fields' => array(
                    'Reservation.id',
                    'Reservation.cost',
                    'Reservation.amount_remaining',
                    'Reservation.status',
                    'SheetRideDetailRide.reference',
                    'SheetRideDetailRide.planned_start_date',
                    'SheetRideDetailRide.real_start_date',
                    'SheetRideDetailRide.planned_end_date',
                    'SheetRideDetailRide.real_end_date',
                    'Reservation.car_id',
                    'Car.code',
                    'Car.immatr_def',
                    'Car.id',
                    'Carmodel.name',
                    'Supplier.id',
                    'Supplier.name'
                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('Reservation.car_id = Car.id')
                    ),
                    array(
                        'table' => 'sheet_ride_detail_rides',
                        'type' => 'left',
                        'alias' => 'SheetRideDetailRide',
                        'conditions' => array('Reservation.sheet_ride_detail_ride_id = SheetRideDetailRide.id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('Car.supplier_id = Supplier.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    )
                )
            )
        );

        $param = $this->Parameter->getCodesParameterVal('name_car');
        $company = $this->Company->find('first');
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('reservations', 'param', 'company', 'separatorAmount'));

    }


    public function printSubcontractorState()
    {
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        $array = filter_input(INPUT_POST, "printSubcontractorState"); 
        $conditions = filter_input(INPUT_POST, "conditions");
        $explodedArray = explode(",", $array);
        if(!empty($conditions)){
            $conditions = '1 = 1 '.unserialize(base64_decode($conditions));
        }else {
            $arrayConditions = explode(",", $array);
            $supplierId = $arrayConditions[0];
            $suppliersIds = array_filter(explode("**", $explodedArray[0]));
            $carId = $arrayConditions[1] ;
            $orderType = $arrayConditions[2] ;
            $cost = $arrayConditions[3] ;
            $date1 = $arrayConditions[4] ;
            $date2 = $arrayConditions[5] ;
            $conditions = array();
            if (!empty($carId)) {
                $conditions["Reservation.car_id "] = $carId;
            }
            if (!empty($suppliersIds)) {
                $conditions["Reservation.supplier_id IN"] = $suppliersIds;
            }
            if (!empty($cost)) {
                $conditions["Reservation.cost >= "] = $cost;
            }
            if (!empty($orderType)) {
                $conditions["TransportBillDetailRides.order_type "] = $orderType;
            }
            if (!empty($date1)) {
                $date_from = str_replace("/", "-", $date1);
                $start = str_replace("-", "/", $date_from);
                $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                $conditions["SheetRideDetailRides.real_start_date >= "] = $startdtm->format('Y-m-d 00:00:00');
            }
            if (!empty($date2)) {
                $date_from = str_replace("/", "-", $date2);
                $start = str_replace("-", "/", $date_from);
                $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                $conditions["SheetRideDetailRides.real_start_date <= "] = $startdtm->format('Y-m-d 00:00:00');
            }
        }

        $ids = filter_input(INPUT_POST, "chkids");

        if (!empty($ids)) {
            $array_ids = explode(",", $ids);
            if (!empty($array_ids)) {
                $conditions["Reservation.id"] = $array_ids;
            }
        }
        $reservations = $this->Reservation->find('all', array(
            'recursive' => -1,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'group' => 'Reservation.id',
            'fields' => array(
                'SheetRideDetailRides.real_start_date',
                'SheetRideDetailRides.price_recovered',
                'Reservation.cost',
                'Reservation.amount_remaining',
                'Reservation.advanced_amount',
                'Supplier.code',
                'Supplier.name',
                'Subcontractor.name',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'CarType.name',
                'TransportBillDetailRides.unit_price',
                'TransportBillDetailRides.delivery_with_return',
                'TransportBillDetailedRides.price_ttc',
                'TransportBillDetailedRides.designation',
                'TransportBill.order_type',
                'TransportBill.payment_method',
                'Payments.receipt_date',
                'Payments.amount',
                'DetailPayments.payroll_amount',
            ),
            'joins' => array(
                array(
                    'table' => 'sheet_ride_detail_rides',
                    'type' => 'left',
                    'alias' => 'SheetRideDetailRides',
                    'conditions' => array('SheetRideDetailRides.id = Reservation.sheet_ride_detail_ride_id')
                ),
                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('SheetRide.id = SheetRideDetailRides.sheet_ride_id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('SheetRide.car_id = Car.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('SheetRide.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Subcontractor',
                    'conditions' => array('Reservation.supplier_id = Subcontractor.id')
                ),

                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'DepartureDestination',
                    'conditions' => array('DepartureDestination.id = SheetRideDetailRides.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'ArrivalDestination',
                    'conditions' => array('ArrivalDestination.id = SheetRideDetailRides.arrival_destination_id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Supplier.id = SheetRideDetailRides.supplier_id')
                ),
                array(
                    'table' => 'transport_bill_detail_rides',
                    'type' => 'left',
                    'alias' => 'TransportBillDetailRides',
                    'conditions' => array('TransportBillDetailRides.id = SheetRideDetailRides.transport_bill_detail_ride_id')
                ),
                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('TransportBillDetailRides.transport_bill_id = TransportBill.id')
                ),
                array(
                    'table' => 'transport_bill_detailed_rides',
                    'type' => 'left',
                    'alias' => 'TransportBillDetailedRides',
                    'conditions' => array('TransportBillDetailRides.id = TransportBillDetailedRides.transport_bill_detail_ride_id')
                ),
                array(
                    'table' => 'detail_payments',
                    'type' => 'left',
                    'alias' => 'DetailPayments',
                    'conditions' => array('DetailPayments.reservation_id = Reservation.id')
                ),
                array(
                    'table' => 'payments',
                    'type' => 'left',
                    'alias' => 'Payments',
                    'conditions' => array('DetailPayments.payment_id = Payments.id')
                )
            )
        ));
        $allReservations = array();
        foreach($reservations as $reservation){
            $allReservations[$reservation['Subcontractor']['name']][] = $reservation;
         }
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('allReservations','separatorAmount'));

    }

    public function liste( $id = null, $keyword = null)
    {
        $keyword = str_replace('espace', ' ', $keyword);
        $keyword = str_replace('slash', '/', $keyword);
        $keyword = strtolower($keyword);
        $this->layout = 'ajax';
        $limit = $this->getLimit();
        switch ($id) {
            case 2 :
                $conditions = array("LOWER(SheetRideDetailRides.reference) LIKE" => "%$keyword%");
                break;
            case 3 :
                $conditions = array(
                    'OR' => array(
                        "LOWER(Car.immatr_def) LIKE" => "%$keyword%",
                        "LOWER(Car.code) LIKE" => "%$keyword%",
                        "LOWER(Carmodel.name) LIKE" => "%$keyword%",
                    )
                );
                break;
            case 4 :
                $conditions = array("LOWER(Supplier.name) LIKE" => "%$keyword%");
                break;

            case 5 :
                $conditions = array("LOWER(Reservation.cost) LIKE" => "%$keyword%");
                break;

            case 6 :
                $conditions = array("LOWER(Reservation.amount_remaining) LIKE" => "%$keyword%");
                break;

            case 7 :
                $keyword = str_replace("/", "-", $keyword);
                $start = str_replace("-", "/", $keyword);
                $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                $conditions = array("SheetRideDetailRides.real_start_date >=" => $startdtm->format('Y-m-d 00:00:00'));
                break;

            case 8 :
                $keyword = str_replace("/", "-", $keyword);
                $start = str_replace("-", "/", $keyword);
                $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                $conditions = array("heetRideDetailRides.real_end_date >=" => $startdtm->format('Y-m-d 00:00:00'));
                break;


            default:
                $conditions = array("LOWER(Ride.wording) LIKE" => "%$keyword%");
        }

        $this->paginate = array(
            'recursive' => -1,
            'conditions' => $conditions,
            'limit'=>$limit,
            'paramType' => 'querystring',
            'fields' => array(
                'Reservation.id',
                'Reservation.cost',
                'Reservation.amount_remaining',
                'Reservation.status',
                'SheetRideDetailRides.reference',
                'SheetRideDetailRides.planned_start_date',
                'SheetRideDetailRides.real_start_date',
                'SheetRideDetailRides.planned_end_date',
                'SheetRideDetailRides.real_end_date',
                'Car.code',
                'Car.immatr_def',
                'Carmodel.name',
                'Supplier.name'
            ),
            'joins' => array(
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Reservation.car_id = Car.id')
                ),
                array(
                    'table' => 'sheet_ride_detail_rides',
                    'type' => 'left',
                    'alias' => 'SheetRideDetailRides',
                    'conditions' => array('Reservation.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Car.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                )
            )
        );
        $this->set('reservations', $this->Paginator->paginate('Reservation'));
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $separatorAmount = $this->getSeparatorAmount();

        $this->set(compact('param', 'separatorAmount'));


    }


}
