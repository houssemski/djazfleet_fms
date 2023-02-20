<?php

App::uses('AppController', 'Controller');

/**
 * Consumptions Controller
 *
 * @property Consumption $Consumption
 * @property Fuel $Fuel
 * @property Tank $Tank
 * @property Compte $Compte
 * @property Card $Card
 * @property Customer $Customer
 * @property FuelCard $FuelCard
 * @property Parc $Parc
 * @property Coupon $Coupon
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */

class ConsumptionsController extends AppController {


    public $components = array('Paginator', 'Session','Security','RequestHandler');

    public $uses = array(
        'Consumption',
        'FuelCard',
        'Tank',
        'Parc',
        'Customer',
        'Car',
        'Fuel',
        'Compte',
        'Coupon',
        'Card'
    );

    var $helpers = array('Xls');
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            return $this->redirect('/');
        }
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::feuille_de_route, $user_id, ActionsEnum::view, "Consumptions", null, "Consumption" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                $conditions=array('SheetRide.user_id '=>$user_id);
                break;
            case 3 :
                $conditions=array('SheetRide.user_id !='=>$user_id);
                break;
            default:
                $conditions=null;
        }
        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => $limit,
            'order'=>array('SheetRide.reference'=>'DESC'),
            'conditions' => $conditions,
            'fields' => array(
                'SheetRide.reference',
                'Consumption.consumption_date',
                'Consumption.id',
                'Consumption.type_consumption_used',
                'Consumption.nb_coupon',
                'Consumption.first_number_coupon',
                'Consumption.last_number_coupon',
                'Consumption.species',
                'Consumption.consumption_liter',
                'Consumption.species_card',
                'Tank.name',
                'FuelCard.reference',
                'Coupon.serial_number',
                'Car.code',
                'SheetRideCar.code',
                'Carmodel.name',
                'SheetRideCarmodel.name',
                'Car.immatr_def',
                'SheetRideCar.immatr_def',
                'Customer.first_name',
                'SheetRideCustomer.first_name',
                'Customer.last_name',
                'SheetRideCustomer.last_name',

            ),
            'joins' => array(
                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('Consumption.sheet_ride_id = SheetRide.id')
                ),
                array(
                    'table' => 'tanks',
                    'type' => 'left',
                    'alias' => 'Tank',
                    'conditions' => array('Consumption.tank_id = Tank.id')
                ),
                array(
                    'table' => 'fuel_cards',
                    'type' => 'left',
                    'alias' => 'FuelCard',
                    'conditions' => array('Consumption.fuel_card_id = FuelCard.id')
                ),
                array(
                    'table' => 'coupons',
                    'type' => 'left',
                    'alias' => 'Coupon',
                    'conditions' => array('Consumption.id = Coupon.consumption_id')
                ),

                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Customer.id = Consumption.customer_id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Car.id = Consumption.car_id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Carmodel.id = Car.carmodel_id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'SheetRideCar',
                    'conditions' => array('SheetRideCar.id = SheetRide.car_id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'SheetRideCarmodel',
                    'conditions' => array('SheetRideCarmodel.id = SheetRideCar.carmodel_id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'SheetRideCustomer',
                    'conditions' => array('SheetRideCustomer.id = SheetRide.customer_id')
                ),
            )
        );
        $consumptions = $this->Paginator->paginate('Consumption');
        $this->set('consumptions', $consumptions);
        $this->loadModel('Parc');
        $parcs = $this->Parc->getParcs('list');
        $this->set(compact('limit','parcs'));
        $sumCost = $this->Consumption->getSumCost($conditions);
        $sumConsumption = $this->Consumption->getSumConsumption($conditions);
        $sumKm = $this->Consumption->getSumKm($conditions);
        $paramConsumption = $this->consumptionManagement();
        //Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');

        $this->set('param', $param);
        $this->set(compact('sumCost', 'sumConsumption', 'sumKm','paramConsumption'));
    }

    public function view($id){
        $consumption = $this->Consumption->getConsumptionsById($id,-2);
        $this->set(compact('consumption'));
    }

    public function search()
    {
        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();

        if (isset($this->request->data['keyword']) || isset($this->request->data['Consumptions']['payment_mode'])
            || isset($this->request->data['Consumptions']['car_id']) ||  isset($this->request->data['Consumptions']['customer_id'])
            ||  isset($this->request->data['Consumptions']['parc_id']) ||  isset($this->request->data['Consumptions']['compte_id'])
            ||  isset($this->request->data['Consumptions']['fuel_card_id']) ||  isset($this->request->data['Consumptions']['tank_id'])
            || isset($this->request->data['Consumptions']['coupons_from']) || isset($this->request->data['Consumptions']['coupons_to'])
            || isset($this->request->data['Consumptions']['consumption_date1'])|| isset($this->request->data['Consumptions']['consumption_date2'])
            || isset($this->request->data['Consumptions']['start_date1'])|| isset($this->request->data['Consumptions']['start_date2'])
            || isset($this->request->data['Consumptions']['end_date1'])|| isset($this->request->data['Consumptions']['end_date2'])
        ) {
            $this->filterUrl();
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        if (isset($this->params['named']['keyword']) || isset($this->params['named']['payment_mode'])
            || isset($this->params['named']['car']) || isset($this->params['named']['customer'])
            || isset($this->params['named']['parc'])|| isset($this->params['named']['compte'])
            || isset($this->params['named']['tank'])|| isset($this->params['named']['card'])
            || isset($this->params['named']['coupons_from'])|| isset($this->params['named']['coupons_to'])
            || isset($this->params['named']['consumption_date1'])|| isset($this->params['named']['consumption_date2'])
            || isset($this->params['named']['start_date1'])|| isset($this->params['named']['start_date2'])
            || isset($this->params['named']['end_date1'])|| isset($this->params['named']['end_date2'])
        ) {
            $conditions = $this->getConds();
            $this->paginate = array(
                'paramType' => 'querystring',
                'recursive' => -1, // should be used with joins
                'limit' => $limit,
                'order'=>array('SheetRide.reference'=> 'DESC'),
                'conditions' => $conditions,
                'fields' => array(
                    'SheetRide.reference',
                    'Consumption.consumption_date',
                    'Consumption.type_consumption_used',
                    'Consumption.nb_coupon',
                    'Consumption.id',
                    'Consumption.first_number_coupon',
                    'Consumption.last_number_coupon',
                    'Consumption.species',
                    'Consumption.consumption_liter',
                    'Consumption.species_card',
                    'Tank.name',
                    'FuelCard.reference',
                    'Coupon.serial_number',
                    'Car.code',
                    'SheetRideCar.code',
                    'Carmodel.name',
                    'SheetRideCarmodel.name',
                    'Car.immatr_def',
                    'SheetRideCar.immatr_def',
                    'Customer.first_name',
                    'SheetRideCustomer.first_name',
                    'Customer.last_name',
                    'SheetRideCustomer.last_name',

                ),
                'joins' => array(
                    array(
                        'table' => 'sheet_rides',
                        'type' => 'left',
                        'alias' => 'SheetRide',
                        'conditions' => array('Consumption.sheet_ride_id = SheetRide.id')
                    ),
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('Car.id = Consumption.car_id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),

                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('Customer.id = Consumption.customer_id')
                    ),
                    array(
                        'table' => 'tanks',
                        'type' => 'left',
                        'alias' => 'Tank',
                        'conditions' => array('Consumption.tank_id = Tank.id')
                    ),
                    array(
                        'table' => 'fuel_cards',
                        'type' => 'left',
                        'alias' => 'FuelCard',
                        'conditions' => array('Consumption.fuel_card_id = FuelCard.id')
                    ),
                    array(
                        'table' => 'coupons',
                        'type' => 'left',
                        'alias' => 'Coupon',
                        'conditions' => array('Consumption.id = Coupon.consumption_id')
                    ),
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'SheetRideCar',
                        'conditions' => array('SheetRideCar.id = SheetRide.car_id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'SheetRideCarmodel',
                        'conditions' => array('SheetRideCarmodel.id = SheetRideCar.carmodel_id')
                    ),
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'SheetRideCustomer',
                        'conditions' => array('SheetRideCustomer.id = SheetRide.customer_id')
                    ),
                )
            );
            $consumptions = $this->Paginator->paginate('Consumption');
            $this->set('consumptions', $consumptions);
        } else {
            $this->Consumption->recursive = 0;
            $this->set('consumptions', $this->Paginator->paginate('Consumption'));
        }
        $this->loadModel('Coupon');
        $coupons = $this->Coupon->find('list', array(
            'joins' => array(
                array(
                    'table' => 'fuel_logs',
                    'type' => 'left',
                    'alias' => 'FuelLog',
                    'conditions' => array('Coupon.fuel_log_id = FuelLog.id')
                )),
            'conditions' => array('Coupon.used' => 1),

            'order' => array('FuelLog.date ASC' => 'ASC', 'Coupon.serial_number' => 'ASC')));
        $this->loadModel('Parc');
        $parcs = $this->Parc->getParcs('list');
        $this->set(compact('limit','coupons','parcs'));
        $sumCost = $this->Consumption->getSumCost($conditions);
        $sumConsumption = $this->Consumption->getSumConsumption($conditions);
        $sumKm = $this->Consumption->getSumKm($conditions);
        $paramConsumption = $this->consumptionManagement();
        //Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set('param', $param);
        $this->set(compact('sumCost', 'sumConsumption', 'sumKm','paramConsumption','conditions'));


    }

    private function filterUrl()
    {
        $filter_url['controller'] = $this->request->params['controller'];
        $filter_url['action'] = $this->request->params['action'];
        $filter_url['page'] = 1;
        $filter_url['keyword'] = $this->request->data['keyword'];
        $filter_url['keyword'] = str_replace('/', '-', $filter_url['keyword']);
        if (isset($this->request->data['Consumptions']['coupons_from']) && !empty($this->request->data['Consumptions']['coupons_from'])) {
            $filter_url['coupons_from'] = $this->request->data['Consumptions']['coupons_from'];
        }
        if (isset($this->request->data['Consumptions']['coupons_to']) && !empty($this->request->data['Consumptions']['coupons_to'])) {
            $filter_url['coupons_to'] = $this->request->data['Consumptions']['coupons_to'];
        }
        if (isset($this->request->data['Consumptions']['payment_mode']) && !empty($this->request->data['Consumptions']['payment_mode'])) {
            $filter_url['payment_mode'] = $this->request->data['Consumptions']['payment_mode'];
        }
        if (isset($this->request->data['Consumptions']['car_id']) && !empty($this->request->data['Consumptions']['car_id'])) {
            $filter_url['car'] = $this->request->data['Consumptions']['car_id'];
        }
        if (isset($this->request->data['Consumptions']['customer_id']) && !empty($this->request->data['Consumptions']['customer_id'])) {
            $filter_url['customer'] = $this->request->data['Consumptions']['customer_id'];
        }
        if (isset($this->request->data['Consumptions']['parc_id']) && !empty($this->request->data['Consumptions']['parc_id'])) {
            $filter_url['parc'] = $this->request->data['Consumptions']['parc_id'];
        }
        if (isset($this->request->data['Consumptions']['compte_id']) && !empty($this->request->data['Consumptions']['compte_id'])) {
            $filter_url['compte'] = $this->request->data['Consumptions']['compte_id'];
        }
        if (isset($this->request->data['Consumptions']['tank_id']) && !empty($this->request->data['Consumptions']['tank_id'])) {
            $filter_url['tank'] = $this->request->data['Consumptions']['tank_id'];
        }
        if (isset($this->request->data['Consumptions']['fuel_card_id']) && !empty($this->request->data['Consumptions']['fuel_card_id'])) {
            $filter_url['card'] = $this->request->data['Consumptions']['fuel_card_id'];
        }
        if (isset($this->request->data['Consumptions']['consumption_date1']) && !empty($this->request->data['Consumptions']['consumption_date1'])) {
            $filter_url['consumption_date1'] = str_replace("/", "-", $this->request->data['Consumptions']['consumption_date1']);
        }
        if (isset($this->request->data['Consumptions']['consumption_date2']) && !empty($this->request->data['Consumptions']['consumption_date2'])) {
            $filter_url['consumption_date2'] = str_replace("/", "-", $this->request->data['Consumptions']['consumption_date2']);
        }

        if (isset($this->request->data['Consumptions']['start_date1']) && !empty($this->request->data['Consumptions']['start_date1'])) {
            $filter_url['start_date1'] = str_replace("/", "-", $this->request->data['Consumptions']['start_date1']);
        }
        if (isset($this->request->data['Consumptions']['start_date2']) && !empty($this->request->data['Consumptions']['start_date2'])) {
            $filter_url['start_date2'] = str_replace("/", "-", $this->request->data['Consumptions']['start_date2']);
        }

        if (isset($this->request->data['Consumptions']['end_date1']) && !empty($this->request->data['Consumptions']['end_date1'])) {
            $filter_url['end_date1'] = str_replace("/", "-", $this->request->data['Consumptions']['end_date1']);
        }
        if (isset($this->request->data['Consumptions']['end_date2']) && !empty($this->request->data['Consumptions']['end_date2'])) {
            $filter_url['end_date2'] = str_replace("/", "-", $this->request->data['Consumptions']['end_date2']);
        }
        return $this->redirect($filter_url);
    }

    private function getConds()
    {
        if (!empty($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $keyword = str_replace('-', '/', $keyword);
            $conds = array(
                'OR' => array(
                    "LOWER(SheetRide.reference) LIKE" => "%$keyword%",
                    "LOWER(FuelCard.reference) LIKE" => "%$keyword%",
                    "LOWER(Car.code) LIKE" => "%$keyword%",
                    "LOWER(Car.immatr_def) LIKE" => "%$keyword%",
                    "LOWER(Carmodel.name) LIKE" => "%$keyword%",
                    "LOWER(Customer.first_name) LIKE" => "%$keyword%",
                    "LOWER(Customer.last_name) LIKE" => "%$keyword%",
                    "LOWER(Coupon.serial_number) LIKE" => "%$keyword%",
                )
            );
        } else {
            $conds = array();
        }

        if (isset($this->params['named']['payment_mode']) && !empty($this->params['named']['payment_mode'])) {
            switch ($this->params['named']['payment_mode']) {
                case 1:
                    $conds["Consumption.nb_coupon > "] = 0;
                    break;
                case 2:
                    $conds["Consumption.species > "] = 0;
                    break;
                case 3:
                    $conds["Consumption.tank_id > "] = 0;

                    break;
                case 4:
                    $conds["Consumption.fuel_card_id > "] = 0;
                    break;
            }
            $this->request->data['Consumptions']['payment_mode'] = $this->params['named']['payment_mode'];
        }
        if (isset($this->params['named']['coupons_from']) && !empty($this->params['named']['coupons_from'])) {
            $conds["Coupon.id >= "] = $this->params['named']['coupons_from'];
            $this->request->data['Consumptions']['coupons_from'] = $this->params['named']['coupons_from'];
        }
        if (isset($this->params['named']['coupons_to']) && !empty($this->params['named']['coupons_to'])) {
            $conds["Coupon.id <= "] = $this->params['named']['coupons_to'];
            $this->request->data['Consumptions']['coupons_to'] = $this->params['named']['coupons_to'];
        }
        if (isset($this->params['named']['compte']) && !empty($this->params['named']['compte'])) {
            $conds["Consumption.compte_id  "] = $this->params['named']['compte'];
            $this->request->data['Consumptions']['compte_id'] = $this->params['named']['compte'];
        }
        if (isset($this->params['named']['tank']) && !empty($this->params['named']['tank'])) {
            $conds["Consumption.tank_id  "] = $this->params['named']['tank'];
            $this->request->data['Consumptions']['tank_id'] = $this->params['named']['tank'];
        }
        if (isset($this->params['named']['card']) && !empty($this->params['named']['card'])) {
            $conds["Consumption.fuel_card_id  "] = $this->params['named']['card'];
            $this->request->data['Consumptions']['fuel_card_id'] = $this->params['named']['card'];
        }

        if (isset($this->params['named']['car']) && !empty($this->params['named']['car'])) {
            $conds["Consumption.car_id  "] = $this->params['named']['car'];
            $this->request->data['Consumptions']['car_id'] = $this->params['named']['car'];
            $this->request->data['Consumptions']['carId'] = $this->params['named']['car'];
        }
        if (isset($this->params['named']['customer']) && !empty($this->params['named']['customer'])) {
            $conds["Consumption.customer_id  "] = $this->params['named']['customer'];
            $this->request->data['Consumptions']['customer_id'] = $this->params['named']['customer'];
        }
        if (isset($this->params['named']['parc']) && !empty($this->params['named']['parc'])) {
            $conds["Car.parc_id  "] = $this->params['named']['parc'];
            $this->request->data['Consumptions']['parc_id'] = $this->params['named']['parc'];
        }

        if (isset($this->params['named']['consumption_date1']) && !empty($this->params['named']['consumption_date1'])) {
            $creat = str_replace("-", "/", $this->params['named']['consumption_date1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Consumption.consumption_date >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Consumptions']['consumption_date1'] = $creat;
        }
        if (isset($this->params['named']['consumption_date2']) && !empty($this->params['named']['consumption_date2'])) {
            $creat = str_replace("-", "/", $this->params['named']['consumption_date2']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Consumption.consumption_date <= "] = $startdtm->format('Y-m-d 23:59:00');
            $this->request->data['Consumptions']['consumption_date2'] = $creat;
        }

        if (isset($this->params['named']['start_date1']) && !empty($this->params['named']['start_date1'])) {
            $creat = str_replace("-", "/", $this->params['named']['start_date1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRide.start_date >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Consumptions']['start_date1'] = $creat;
        }
        if (isset($this->params['named']['start_date2']) && !empty($this->params['named']['start_date2'])) {
            $creat = str_replace("-", "/", $this->params['named']['start_date2']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRide.start_date <= "] = $startdtm->format('Y-m-d 23:59:00');
            $this->request->data['Consumptions']['start_date2'] = $creat;
        }

        if (isset($this->params['named']['end_date1']) && !empty($this->params['named']['end_date1'])) {
            $creat = str_replace("-", "/", $this->params['named']['end_date1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRide.end_date >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Consumptions']['end_date1'] = $creat;
        }
        if (isset($this->params['named']['end_date2']) && !empty($this->params['named']['end_date2'])) {
            $creat = str_replace("-", "/", $this->params['named']['end_date2']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRide.end_date <= "] = $startdtm->format('Y-m-d 23:59:00');
            $this->request->data['Consumptions']['end_date2'] = $creat;
        }
        return $conds;
    }

    public function add() {

        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::consommation, $user_id,
            ActionsEnum::add, "Consumptions", null, "Consumption" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Consumption']['user_id'] = $this->Session->read('Auth.User.id');
            $save = false ;
                if (!empty($this->request->data['Consumption']['consumption_date']) && !empty($this->request->data['Consumption']['type_consumption_used'])) {
                    $data = array();
                    $this->createDatetimeFromDatetime('Consumption', 'consumption_date');
                    $consumptionDate = $this->request->data['Consumption']['consumption_date'];
                    $data['Consumption']['consumption_date'] = $this->request->data['Consumption']['consumption_date'];
                    $data['Consumption']['type_consumption_used'] = $this->request->data['Consumption']['type_consumption_used'];
                    $data['Consumption']['cost'] = $this->request->data['Consumption']['cost'];
                    $data['Consumption']['sheet_ride_id'] = $this->request->data['Consumption']['sheet_ride_id'];
                    switch ($this->request->data['Consumption']['type_consumption_used']) {
                        case ConsumptionTypesEnum::coupon:
                            $selectingCouponsMethod = $this->Parameter->getCodesParameterVal('select_coupon');
                            if($selectingCouponsMethod==1){
                                if ((!empty($this->request->data['Consumption']['nb_coupon']) && !empty($this->request->data['Consumption']['serial_numbers']))
                                ) {
                                    $data['Consumption']['nb_coupon'] = $this->request->data['Consumption']['nb_coupon'];
                                    $this->Consumption->create();
                                    if($this->Consumption->save($data)){
                                        $save = true;
                                    }
                                    $consumptionId = $this->Consumption->getLastInsertId();
                                    if (!empty($this->request->data['Consumption']['serial_numbers'])) {
                                        $usedCouponsNumbers = $this->request->data['Consumption']['serial_numbers'];
                                    } else {
                                        $usedCouponsNumbers = '';
                                    }
                                    if (!empty($usedCouponsNumbers)) {
                                        $this->Coupon->updateCouponsConsumption($usedCouponsNumbers, $consumptionId);
                                    }
                                }
                            }else {
                                if (!empty($this->request->data['Consumption']['nb_coupon']) && !empty($this->request->data['Consumption']['first_number_coupon'])
                                    && !empty($this->request->data['Consumption']['last_number_coupon']) && !empty($this->request->data['Consumption']['serial_numbers'])
                                ) {

                                    $data['Consumption']['nb_coupon'] = $this->request->data['Consumption']['nb_coupon'];
                                    $data['Consumption']['first_number_coupon'] = $this->request->data['Consumption']['first_number_coupon'];
                                    $data['Consumption']['last_number_coupon'] = $this->request->data['Consumption']['last_number_coupon'];

                                    $this->Consumption->create();
                                    if($this->Consumption->save($data)){
                                        $save = true;
                                    }
                                    $consumptionId = $this->Consumption->getLastInsertId();
                                    if (!empty($this->request->data['Consumption']['serial_numbers'])) {
                                        $usedCouponsNumbers = $this->request->data['Consumption']['serial_numbers'];
                                    } else {
                                        $usedCouponsNumbers = '';
                                    }
                                    //var_dump($usedCouponsNumbers); die();
                                    if (!empty($usedCouponsNumbers)) {
                                        $this->Coupon->updateCouponsConsumption($usedCouponsNumbers, $consumptionId);
                                    }



                                }
                            }

                            break;
                        case ConsumptionTypesEnum::species:
                            if (!empty($this->request->data['Consumption']['species'])) {
                                $data['Consumption']['species'] = $this->request->data['Consumption']['species'];
                                if (Configure::read("gestion_commercial") == '1'  &&
                                    Configure::read("tresorerie") == '1') {
                                    $data['Consumption']['compte_id'] = $this->request->data['Consumption']['compte_id'];
                                }
                                $this->Consumption->create();
                                if($this->Consumption->save($data)){
                                    $save = true;
                                }
                                $consumptionId = $this->Consumption->getInsertID();
                                if (Configure::read("gestion_commercial") == '1'  &&
                                    Configure::read("tresorerie") == '1') {
                                    if (Configure::read("cafyb") == '1') {
                                        $this->addPaymentConsumptionSpecies($this->request->data['Consumption']['compte_id'],
                                            $this->request->data['Consumption']['species'], $consumptionId,
                                            $consumptionDate);
                                    } else {
                                        $this->addPaymentConsumptionSpecies($this->request->data['Consumption']['compte_id'],
                                            $this->request->data['Consumption']['species'], $consumptionId,
                                            $this->request->data['Consumption']['consumption_date']);
                                    }
                                }

                            }
                            break;
                        case ConsumptionTypesEnum::tank:
                            if (!empty($this->request->data['Consumption']['consumption_liter']) && !empty($this->request->data['Consumption']['tank_id'])) {
                                $data['Consumption']['consumption_liter'] = $this->request->data['Consumption']['consumption_liter'];
                                $data['Consumption']['tank_id'] = $this->request->data['Consumption']['tank_id'];
                                $data['Consumption']['customer_id'] = $this->request->data['Consumption']['customer_id'];
                                $data['Consumption']['car_id'] = $this->request->data['Consumption']['car_id'];
                                $this->Consumption->create();
                                if($this->Consumption->save($data)){
                                    $save = true;
                                }
                                $this->Tank->decreaseLiterTank($this->request->data['Consumption']['tank_id'], $this->request->data['Consumption']['consumption_liter']);
                            }
                            break;
                        case ConsumptionTypesEnum::card:
                            if (!empty($this->request->data['Consumption']['species_card']) && !empty($this->request->data['Consumption']['fuel_card_id'])) {

                                $data['Consumption']['species_card'] = $this->request->data['Consumption']['species_card'];
                                $data['Consumption']['fuel_card_id'] = $this->request->data['Consumption']['fuel_card_id'];
                                $this->Consumption->create();
                                if($this->Consumption->save($data)){
                                    $save = true;
                                }
                                $this->FuelCard->decreaseSpeciesCard($this->request->data['Consumption']['fuel_card_id'], $this->request->data['Consumption']['species_card']);
                            }

                            break;
                    }
                }



            if ($save==true) {

                $this->Flash->success(__('The consumption has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The consumption could not be saved. Please, try again.'));
            }
        }
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);
        $paramConsumption = $this->consumptionManagement();
        $parameter = $this->Parameter->find('all', array(
            'recursive' => -1,
            'conditions' => array('code' => array(10, 23))
        ));
        $isSheetRideRequiredForConsumption = $this->Parameter->getCodesParameterVal('is_sheet_ride_required_for_consumption');
        $this->request->data['Consumption']['coupon_price'] = $parameter[0]['Parameter']['val'];
        $this->request->data['Consumption']['difference_allowed'] = $parameter[1]['Parameter']['val'];
        $defaultConsumptionMethod = $this->Parameter->getCodesParameterVal('default_consumption_method');
        $this->set(compact('paramConsumption','defaultConsumptionMethod','isSheetRideRequiredForConsumption'
        ,'customers'));
    }

    public function edit($id){

        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $consumption = $this->Consumption->find('first',array(
            'conditions' => array(
                'Consumption.id' => $id
            )
        ));
        $this->verifyUserPermission(SectionsEnum::consommation, $user_id, ActionsEnum::edit, "Consumptions", $id, "Consumption" ,null);
        if (!$this->Consumption->exists($id)) {
            throw new NotFoundException(__('Invalid consumption'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Consumption cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Consumption']['modified_id'] = $this->Session->read('Auth.User.id');

            $save = false ;
            if (!empty($this->request->data['Consumption']['consumption_date'])
                && !empty($this->request->data['Consumption']['type_consumption_used'])) {
                $data = array();

                $data['Consumption']['id'] = $this->request->data['Consumption']['id'];
                $consumptionDate = $this->request->data['Consumption']['consumption_date'];

                $this->createDatetimeFromDatetime('Consumption', 'consumption_date');
                $data['Consumption']['consumption_date'] = $this->request->data['Consumption']['consumption_date'];
                $data['Consumption']['type_consumption_used'] = $this->request->data['Consumption']['type_consumption_used'];
                $data['Consumption']['cost'] = $this->request->data['Consumption']['cost'];
                $data['Consumption']['sheet_ride_id'] = $this->request->data['Consumption']['sheet_ride_id'];


                switch ($this->request->data['Consumption']['type_consumption_used']) {
                    case ConsumptionTypesEnum::coupon:

                        if (!empty($this->request->data['Consumption']['nb_coupon'])
                            && !empty($this->request->data['Consumption']['first_number_coupon'])
                            && !empty($this->request->data['Consumption']['last_number_coupon'])
                            && !empty($this->request->data['Consumption']['serial_numbers'])
                        ) {

                            $data['Consumption']['nb_coupon'] = $this->request->data['Consumption']['nb_coupon'];
                            $data['Consumption']['first_number_coupon'] = $this->request->data['Consumption']['first_number_coupon'];
                            $data['Consumption']['last_number_coupon'] = $this->request->data['Consumption']['last_number_coupon'];

                            if($this->Consumption->save($data)){
                                $save = true;
                            }
                            if (!empty($this->request->data['Consumption']['serial_numbers'])) {
                                $usedCouponsNumbers = $this->request->data['Consumption']['serial_numbers'];
                            } else {
                                $usedCouponsNumbers = '';
                            }
                            if (!empty($usedCouponsNumbers)) {
                                $this->Coupon->updateCouponsConsumption($usedCouponsNumbers, $id);
                            }

                        }
                        break;
                    case ConsumptionTypesEnum::species:
                        if (!empty($this->request->data['Consumption']['species'])) {
                            $data['Consumption']['species'] = $this->request->data['Consumption']['species'];
                            if (Configure::read("gestion_commercial") == '1'  &&
                                Configure::read("tresorerie") == '1') {
                                $data['Consumption']['compte_id'] = $this->request->data['Consumption']['compte_id'];
                            }

                            if($this->Consumption->save($data)){
                                $save = true;
                            }
                            if (Configure::read("gestion_commercial") == '1'  &&
                                Configure::read("tresorerie") == '1') {
                                if (Configure::read("cafyb") == '1') {
                                    $this->addPaymentConsumptionSpecies($this->request->data['Consumption']['compte_id'],
                                        $this->request->data['Consumption']['species'], $id,
                                        $consumptionDate);
                                } else {
                                    $this->addPaymentConsumptionSpecies($this->request->data['Consumption']['compte_id'],
                                        $this->request->data['Consumption']['species'], $id,
                                        $this->request->data['Consumption']['consumption_date']);
                                }
                            }

                        }
                        break;
                    case ConsumptionTypesEnum::tank:
                        if (!empty($this->request->data['Consumption']['consumption_liter'])
                            && !empty($this->request->data['Consumption']['tank_id'])) {
                            $data['Consumption']['consumption_liter'] = $this->request->data['Consumption']['consumption_liter'];
                            $data['Consumption']['tank_id'] = $this->request->data['Consumption']['tank_id'];
                            $data['Consumption']['customer_id'] = $this->request->data['Consumption']['customer_id'];
                            $data['Consumption']['car_id'] = $this->request->data['Consumption']['car_id'];

                            if($this->Consumption->save($data)){
                                $save = true;
                            }
                            $this->Tank->decreaseLiterTankInEditConsumption($this->request->data['Consumption']['tank_id'],
                                $this->request->data['Consumption']['consumption_liter'] ,
                                $consumption['Consumption']['consumption_liter']);
                        }
                        break;
                    case ConsumptionTypesEnum::card:
                        if (!empty($this->request->data['Consumption']['species_card'])
                            && !empty($this->request->data['Consumption']['fuel_card_id'])) {
                            $data['Consumption']['species_card'] = $this->request->data['Consumption']['species_card'];
                            $data['Consumption']['fuel_card_id'] = $this->request->data['Consumption']['fuel_card_id'];

                            if($this->Consumption->save($data)){
                                $save = true;
                            }
                            $this->FuelCard->decreaseSpeciesCard($this->request->data['Consumption']['fuel_card_id'], $this->request->data['Consumption']['species_card']);
                        }

                        break;
                }
            }



            if ($save== true) {

                $this->Flash->success(__('The consumption has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The consumption could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index'));
            }
        } else {
            $this->request->data = $this->Consumption->getConsumptionsById($id);



                $cardId = $this->request->data['Consumption']['fuel_card_id'];
                $tankId = $this->request->data['Consumption']['tank_id'];
            if (Configure::read("gestion_commercial") == '1'  &&
                Configure::read("tresorerie") == '1') {
                $compteId = $this->request->data['Consumption']['compte_id'];
            }
                $sheetRideId = $this->request->data['Consumption']['sheet_ride_id'];

                $sheetRide = $this->SheetRide->find('first', array(
                'recursive'=>-1,
                'conditions' => array(
                    'SheetRide.id' => $sheetRideId,
                ),

                'fields' => array('SheetRide.customer_id', 'SheetRide.car_id')
            ));
            $sheetRides = $this->SheetRide->find('list', array(
                'recursive'=>-1,
                'conditions' => array(
                    'SheetRide.id' => $sheetRideId,
                ),

                'fields' => array('SheetRide.id', 'SheetRide.reference')
            ));
            $fields = "names";



            $customers = $this->Customer->getCustomersByFieldsAndConds($fields, array(
                'Customer.id'=>!empty($consumption['Consumption']['customer_id']) ? $consumption['Consumption']['customer_id'] : $sheetRide['SheetRide']['customer_id']
            ));
            $param = $this->Parameter->getCodesParameterVal('name_car');
            $cars = $this->Car->getCarsByFieldsAndConds($param, null, array(
                'Car.id' => !empty($consumption['Consumption']['car_id']) ? $consumption['Consumption']['car_id'] : $sheetRide['SheetRide']['car_id']
            ), 'list');



            $coupons = $this->Coupon->find('list',
                        array('conditions' => array('Coupon.consumption_id' => $id)));
                    $coupons_numbers = $this->Coupon->find('all',
                        array('conditions' => array('Coupon.consumption_id' => $id), 'fields' => array('Coupon.id')));
                    $couponsSelected = array();
                    foreach ($coupons_numbers as $coupons_number) {
                        $couponsSelected[] = $coupons_number['Coupon']['id'];
                    }
                    if(!empty($cardId)){
                    $cards = $this->FuelCard->find(
                        'list',
                        array(
                            'order' => 'reference ASC',
                            'conditions' => array('FuelCard.id' => $cardId)
                        )
                    );
                    }
                    if(!empty($tankId)){
                        $tanks = $this->Tank->find(
                            'list',
                            array(
                                'order' => 'name ASC',
                                'conditions' => array('Tank.id' => $tankId)
                            )
                        );
                    }
            if (Configure::read("gestion_commercial") == '1'  &&
                Configure::read("tresorerie") == '1') {
                if (!empty($compteId)) {
                    if (Configure::read("cafyb") == '1') {
                        $comptes = $this->Cafyb->getComptesByIds($compteId);
                    } else {
                        $comptes = $this->Compte->find(
                            'list',
                            array(
                                'order' => 'num_compte ASC',
                                'conditions' => array('Compte.id' => $compteId)
                            )
                        );
                    }
                }
            }
            $paramConsumption = $this->consumptionManagement();
            $selectingCouponsMethod = $this->Parameter->getCodesParameterVal('select_coupon');
            $cardAmountVerification = $this->Parameter->getCodesParameterVal('card_amount_verification');
            $parameter = $this->Parameter->find('all', array(
                'recursive' => -1,
                'conditions' => array('code' => array(10, 23))
            ));

            $this->request->data['Consumption']['coupon_price'] = $parameter[0]['Parameter']['val'];
            $this->request->data['Consumption']['difference_allowed'] = $parameter[1]['Parameter']['val'];
            $this->set(compact('sheetRides','cars',
                'customers','couponsSelected',
                'cards','coupons','comptes','tanks',
                'paramConsumption','selectingCouponsMethod',
                'cardAmountVerification','sheetRide'));
        }


    }

    public function addConsumptionMethod($typeConsumption = null)
    {
        $this->layout = 'ajax';
        switch ($typeConsumption) {
            case ConsumptionTypesEnum::coupon:
                $this->loadModel('Coupon');
                $coupons = $this->Coupon->find('list', array(
                    'joins' => array(
                        array(
                            'table' => 'fuel_logs',
                            'type' => 'left',
                            'alias' => 'FuelLog',
                            'conditions' => array('Coupon.fuel_log_id = FuelLog.id')
                        )
                    ),
                    'conditions' => array('Coupon.used' => 0),
                    'order' => array('FuelLog.date ASC' => 'ASC', 'Coupon.serial_number ASC' => 'ASC')
                ));
                $selectingCouponsMethod = $this->Parameter->getCodesParameterVal('select_coupon');
                $this->set(compact('coupons', 'selectingCouponsMethod', 'typeConsumption'));
                break;

            case ConsumptionTypesEnum::species :
                if (Configure::read("cafyb") == '1') {
                    $conditions = array('account_type'=>2);
                    $comptes = $this->Cafyb->getAccountsByConditions($conditions);
                }else {
                    $this->loadModel('Compte');
                    $comptes = $this->Compte->find('list', array('order' => 'num_compte ASC',
                        'conditions'=>array('Compte.type_id'=>2)));
                }


                $this->set(compact('typeConsumption','comptes','negativeAccount'));
                break;

            case ConsumptionTypesEnum::tank :
                $this->loadModel('Tank');
                $tanks = $this->Tank->find('list', array('order' => 'code ASC'));
                $this->set(compact('tanks', 'typeConsumption'));
                break;

            case ConsumptionTypesEnum::card :
                $cardAmountVerification = $this->Parameter->getCodesParameterVal('card_amount_verification');
                if($cardAmountVerification ==1){
                    $this->loadModel('FuelCard');
                    $cards = $this->FuelCard->find('list', array('order' => 'reference ASC'));
                }else {
                    $cards = array();
                }

                $this->set(compact('cards', 'typeConsumption','cardAmountVerification'));
                break;
        }
    }
    public function getInformationConsumptionMethod($typeConsumption = null)
    {
        $this->layout = 'ajax';
        switch ($typeConsumption) {
            case ConsumptionTypesEnum::coupon:
                $this->loadModel('Coupon');
                $coupons = $this->Coupon->find('list', array(
                    'joins' => array(
                        array(
                            'table' => 'fuel_logs',
                            'type' => 'left',
                            'alias' => 'FuelLog',
                            'conditions' => array('Coupon.fuel_log_id = FuelLog.id')
                        )),
                    'conditions' => array('Coupon.used' => 1),

                    'order' => array('FuelLog.date ASC' => 'ASC', 'Coupon.serial_number' => 'ASC')));
                $this->set(compact('coupons', 'typeConsumption'));
                break;

            case ConsumptionTypesEnum::species :
                if (Configure::read("cafyb") == '1') {
                    $conditions = array('account_type'=>2);
                    $comptes = $this->Cafyb->getAccountsByConditions($conditions);
                }else {
                    $this->loadModel('Compte');
                    $comptes = $this->Compte->find('list', array('order' => 'num_compte ASC',
                        'conditions'=>array('Compte.type_id'=>2)));
                }


                $this->set(compact('typeConsumption','comptes','negativeAccount'));
                break;

            case ConsumptionTypesEnum::tank :
                $this->loadModel('Tank');
                $tanks = $this->Tank->find('list', array('order' => 'code ASC'));
                $this->set(compact('tanks', 'typeConsumption'));
                break;

            case ConsumptionTypesEnum::card :

                    $this->loadModel('FuelCard');
                    $cards = $this->FuelCard->find('list', array('order' => 'reference ASC'));


                $this->set(compact('cards', 'typeConsumption'));
                break;
        }
    }

    public function verifyNbCoupon($nbCoupon = null)
    {
        $this->layout = 'ajax';
        $this->set('nbCoupon', $nbCoupon);
        $this->loadModel('Coupon');

        $nbCouponExist = $this->Coupon->find('count', array('conditions' => array('Coupon.used !=' => 1)));

        if ($nbCoupon <= $nbCouponExist) {
            $this->set('nbCouponExist', $nbCoupon);
        } else {
            $this->set('nbCouponExist', $nbCouponExist);
        }
// Get method of selecting coupons
        $selectingCouponsMethod = $this->Parameter->getCodesParameterVal('select_coupon');
        $this->set(compact('selectingCouponsMethod'));

    }

    public function getCouponsSelectedFromFirstNumber($nbCoupon = null, $sheetRideId = 0, $firstNumber = null)
    {
        $this->layout = 'ajax';
        $this->set(compact('nbCoupon'));
        $conditions['Coupon.used  '] = 0;
        $firstNumber = trim($firstNumber);
        if ($firstNumber != null) {
            $coupon = $this->Coupon->find('first', array(
                'recursive' => -1,
                'conditions' => array('Coupon.used' => 0, 'Coupon.serial_number' => $firstNumber),
                'fields' => array('id', 'serial_number'),
            ));
            if (!empty($coupon)) {
                $couponId = $coupon['Coupon']['id'];

                $conditions['Coupon.id  >=  '] = $couponId;
                $this->set('couponId', $couponId);
            }

            $this->set('firstNumber', $firstNumber);
        }
        if ($sheetRideId == '0') {
            if ($nbCoupon > 0) {
                $coupons = $this->Coupon->find('all', array(
                    'limit' => $nbCoupon,
                    'recursive' => -1,
                    'joins' => array(
                        array(
                            'table' => 'fuel_logs',
                            'type' => 'left',
                            'alias' => 'FuelLog',
                            'conditions' => array('Coupon.fuel_log_id = FuelLog.id')
                        )
                    ),
                    'conditions' => $conditions,
                    'fields' => array('id', 'serial_number'),
                    'order' => array('FuelLog.date' => 'ASC', 'Coupon.serial_number ASC' => 'ASC')
                ));

            }
        } else {
            if ($nbCoupon > 0) {
                if (isset($couponId) && !empty($couponId)) {
                    $conditions = array('Coupon.used' => 0, 'Coupon.id  >=' => $couponId);
                } else {
                    $conditions = array('Coupon.used' => 0);
                }
                $coupons = $this->Coupon->find('all', array(
                    'limit' => $nbCoupon,
                    'recursive' => -1,
                    'joins' => array(
                        array(
                            'table' => 'fuel_logs',
                            'type' => 'left',
                            'alias' => 'FuelLog',
                            'conditions' => array('Coupon.fuel_log_id = FuelLog.id')
                        )
                    ),
                    'conditions' => $conditions,
                    'fields' => array('id', 'serial_number'),
                    'order' => array('FuelLog.date' => 'ASC', 'Coupon.serial_number ASC' => 'ASC')
                ));
            }
        }
        if (!empty($coupons)) {
            $countCoupons = count($coupons);
            $firstCoupon = $coupons[0]['Coupon']['serial_number'];
            if($countCoupons<$nbCoupon){
                $nbCoupon = $countCoupons;
            }
            $lastCoupon = $coupons[$nbCoupon - 1]['Coupon']['serial_number'];
            if ($sheetRideId == '0') {

                if (isset($couponId) && !empty($couponId)) {
                    $conditions = array(
                        'OR' => array(
                            array('Coupon.used' => 0),
                        ),
                        'Coupon.id  >=' => $couponId
                    );
                } else {
                    $conditions = array(
                        'OR' => array(
                            array('Coupon.used' => 0),
                        )
                    );
                }

                $couponsSelected = $coupons;
                $coupons = $this->Coupon->find('list', array(
                    'limit' => $nbCoupon,
                    'recursive' => -1,
                    'joins' => array(
                        array(
                            'table' => 'fuel_logs',
                            'type' => 'left',
                            'alias' => 'FuelLog',
                            'conditions' => array('Coupon.fuel_log_id = FuelLog.id')
                        )
                    ),
                    'conditions' => $conditions,
                    'fields' => array('id', 'serial_number'),
                    'order' => array('FuelLog.date' => 'ASC', 'Coupon.serial_number ASC' => 'ASC')
                ));


                $this->set('coupons', $coupons);
                $this->set('couponsSelected', $couponsSelected);
                $this->set(compact('firstCoupon', 'lastCoupon', 'coupons', 'couponsSelected','nbCoupon'));

            } else {

                if (isset($couponId) && !empty($couponId)) {
                    $conditions = array(
                        'OR' => array(
                            array('Coupon.used' => 0),
                            array('Coupon.sheet_ride_id' => $sheetRideId)
                        ),
                        'Coupon.id  >=' => $couponId
                    );
                } else {
                    $conditions = array(
                        'OR' => array(
                            array('Coupon.used' => 0),
                            array('Coupon.sheet_ride_id' => $sheetRideId)
                        )
                    );
                }
                $couponsSelected = $coupons;
                $coupons = $this->Coupon->find('list', array(
                    'limit' => $nbCoupon,
                    'recursive' => -1,
                    'joins' => array(
                        array(
                            'table' => 'fuel_logs',
                            'type' => 'left',
                            'alias' => 'FuelLog',
                            'conditions' => array('Coupon.fuel_log_id = FuelLog.id')
                        )
                    ),
                    'conditions' => $conditions,
                    'fields' => array('id', 'serial_number'),
                    'order' => array('FuelLog.date' => 'ASC', 'Coupon.serial_number ASC' => 'ASC')
                ));


                $this->set('coupons', $coupons);
                $this->set('couponsSelected', $couponsSelected);
                $this->set(compact('firstCoupon', 'lastCoupon', 'coupons', 'couponsSelected'));
            }

        }
    }

    public function verifyAmountCards($price = null, $carId = null)
    {

        $this->layout = 'ajax';
        $this->loadModel('FuelCard');
        if ($carId != null) {
            $cards = $this->FuelCard->find('list', array(
                'order' => 'reference ASC',
                'recursive' => -1,
                'conditions' => array('amount >=' => $price, 'FuelCardCar.car_id' => $carId),
                'joins' => array(
                    array(
                        'table' => 'fuel_card_affectations',
                        'type' => 'left',
                        'alias' => 'fuelCardAffectation',
                        'conditions' => array('fuelCardAffectation.fuel_card_id = FuelCard.id')
                    ),
                    array(
                        'table' => 'fuel_card_cars',
                        'type' => 'left',
                        'alias' => 'fuelCardCar',
                        'conditions' => array('fuelCardAffectation.id = fuelCardCar.fuel_card_affectation_id')
                    ),
                )
            ));
        } else {
            $cards = $this->FuelCard->find('list', array(
                'order' => 'reference ASC',
                'conditions' => array('amount >=' => $price)
            ));
        }
        if (empty($cards)) {
            if ($carId != null) {
                $card = $this->FuelCard->find('first', array(
                    'order' => 'amount DESC',
                    'recursive' => -1,
                    'conditions' => array('FuelCardCar.car_id' => $carId),
                    'fields' => array('FuelCard.amount'),
                    'joins' => array(
                        array(
                            'table' => 'fuel_card_affectations',
                            'type' => 'left',
                            'alias' => 'fuelCardAffectation',
                            'conditions' => array('fuelCardAffectation.fuel_card_id = FuelCard.id')
                        ),
                        array(
                            'table' => 'fuel_card_cars',
                            'type' => 'left',
                            'alias' => 'fuelCardCar',
                            'conditions' => array('fuelCardAffectation.id = fuelCardCar.fuel_card_affectation_id')
                        ),
                    )
                ));

            } else {
                $card = $this->FuelCard->find('first', array(
                    'order' => 'amount DESC'
                ));
            }


            if (!empty($card)) {
                $amount = $card['FuelCard']['amount'];
            } else {
                $amount = 0;
            }

            if ($carId != null) {
                $cards = $this->FuelCard->find('list', array(
                    'order' => 'reference ASC',
                    'recursive' => -1,
                    'conditions' => array('amount >=' => $amount, 'FuelCardCar.car_id' => $carId),
                    'joins' => array(
                        array(
                            'table' => 'fuel_card_affectations',
                            'type' => 'left',
                            'alias' => 'fuelCardAffectation',
                            'conditions' => array('fuelCardAffectation.fuel_card_id = FuelCard.id')
                        ),
                        array(
                            'table' => 'fuel_card_cars',
                            'type' => 'left',
                            'alias' => 'fuelCardCar',
                            'conditions' => array('fuelCardAffectation.id = fuelCardCar.fuel_card_affectation_id')
                        ),
                    )
                ));
            } else {
                $cards = $this->FuelCard->find('list', array(
                    'order' => 'reference ASC',
                    'conditions' => array('amount >=' => $amount)
                ));
            }
            $this->set('amount', $amount);
        }

        $this->set(compact('cards', 'price'));
    }

    public function verifySpecieComptes($price = null)
    {
        $this->layout = 'ajax';
        $this->loadModel('Compte');
        if (Configure::read("cafyb") == '1') {
            $conditions = array('balance >=' => $price, 'account_type'=>2);

            $comptes = $this->Cafyb->getAccountsByConditions($conditions);
        }else {
            $comptes = $this->Compte->find('list', array(
                'order' => 'num_compte ASC',
                'conditions' => array('amount >=' => $price, 'type_id'=>2)
            ));
        }

        if (empty($comptes)) {
            if (Configure::read("cafyb") == '1') {
                $conditions = array( 'account_type'=>2);
                $compte = $this->Cafyb->getAccountByConditions($conditions);
            }else {
                $compte = $this->Compte->find('first', array(
                    'order' => 'amount DESC',
                    'conditions' => array( 'type_id'=>2)
                ));
            }
            if (!empty($compte)) {
                $amount = $compte['Compte']['amount'];
            } else {
                $amount = 0;
            }
            if (Configure::read("cafyb") == '1') {
                $conditions = array('balance >=' => $amount, 'account_type'=>2);
                $comptes = $this->Cafyb->getAccountsByConditions($conditions);
            }else {
                $comptes = $this->Compte->find('list', array(
                    'order' => 'num_compte ASC',
                    'conditions' => array('amount >=' => $amount, 'type_id'=>2)
                ));
            }



            $this->set('amount', $amount);
        }

        $this->set(compact('comptes', 'price'));
    }

    public function verifyLiterTanks($liter = null,  $carId = null)
    {
        $this->layout = 'ajax';
        $fuelId = $this->Car->getFuelIdOfCar($carId);
        $conditions = array('Tank.fuel_id' => $fuelId, 'Tank.liter >=' => $liter);
        $tanks = $this->Tank->getTanksByConditions('list', $conditions);

        if (empty($tanks)) {
            $order = 'liter DESC';
            $conditions = array('Tank.fuel_id' => $fuelId);
            $tank = $this->Tank->getTanksByConditions('first', $conditions, $order);
            if (!empty($tank)) {

                $literExisted = $tank['Tank']['liter'];
                $this->set(compact('tank', 'literExisted'));
            } else {
                $literExisted = 0;
                $this->set(compact('tank', 'literExisted'));
            }


        }
        $this->set(compact('tanks', 'liter'));

    }

    function getCarsByCustomer($customerId = null)
    {

        $this->setTimeActif();
        $this->layout = 'ajax';

        $current_date = date("Y-m-d h:i");
        if (isset($customerId) && !empty($customerId)) {
            $result = $this->CustomerCar->find('first', array(
                'recursive'=>-1,
                'conditions' => array(
                    'CustomerCar.customer_id' => $customerId,
                    'OR' => array(
                        array('CustomerCar.start <=' => $current_date, 'CustomerCar.end_real >' => $current_date),
                        array('CustomerCar.start <=' => $current_date, 'CustomerCar.end_real' => null),
                        array('CustomerCar.start' => null, 'CustomerCar.end_real' => null),
                        array('CustomerCar.start' => null, 'CustomerCar.end_real >' => $current_date),

                    ),

                ),
                'joins'=>array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.car_id = Car.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),
                ),

                'fields' => array('Car.id', 'Car.code', 'Car.immatr_def', 'Carmodel.name')
            ));
            if (!empty($result)) {
                $selectedId = $result['Car']['id'];
                $param = $this->Parameter->getCodesParameterVal('name_car');
                $cars = $this->Car->getCarsByFieldsAndConds($param, null, array('Car.id' => $selectedId), 'list');

                $this->set(compact('selectedId', 'cars'));
            } else {
                $this->set('selectedId', 0);
                $this->set('cArs', array());
            }
        } else {
            $this->set('selectedId', 0);
            $this->set('cars', array());
        }

    }

    function getCarsBySheetRide($sheetRideId = null){

        $this->setTimeActif();
        $this->layout = 'ajax';

        if (isset($sheetRideId) && !empty($sheetRideId)) {
            $result = $this->SheetRide->find('first', array(
                'recursive'=>-1,
                'conditions' => array(
                    'SheetRide.id' => $sheetRideId,


                ),
                'joins'=>array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('SheetRide.car_id = Car.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),
                ),

                'fields' => array('Car.id', 'Car.code', 'Car.immatr_def', 'Carmodel.name')
            ));
            if (!empty($result)) {
                $selectedId = $result['Car']['id'];
                $param = $this->Parameter->getCodesParameterVal('name_car');
                $cars = $this->Car->getCarsByFieldsAndConds($param, null, array('Car.id' => $selectedId), 'list');

                $this->set(compact('selectedId', 'cars'));
            } else {
                $this->set('selectedId', 0);
                $this->set('cars', array());
            }
        } else {
            $this->set('selectedId', 0);
            $this->set('cars', array());
        }


    }
    function getCustomersBySheetRide($sheetRideId = null){

        $this->setTimeActif();
        $this->layout = 'ajax';

        if (isset($sheetRideId) && !empty($sheetRideId)) {
            $result = $this->SheetRide->find('first', array(
                'recursive'=>-1,
                'conditions' => array(
                    'SheetRide.id' => $sheetRideId,
                ),
                'joins'=>array(
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('SheetRide.customer_id = Customer.id')
                    )
                ),

                'fields' => array('Customer.id', 'Customer.first_name', 'Customer.last_name')
            ));
            if (!empty($result)) {
                $selectedId = $result['Customer']['id'];
                $fields = "names";
                $customers = $this->Customer->getCustomersByFieldsAndConds($fields, array('Customer.id'=>$selectedId));
                $this->set(compact('selectedId', 'customers'));
            } else {
                $this->set('selectedId', 0);
                $this->set('customers', array());
            }
        } else {
            $this->set('selectedId', 0);
            $this->set('customers', array());
        }
    }

    public function printConsumptionState()
    {
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        $array = filter_input(INPUT_POST, "printConsumptionState");
        $conditions = filter_input(INPUT_POST, "conditions");
        if(!empty($conditions)){
                $conditions = unserialize(base64_decode($conditions));
                $carId = filter_input(INPUT_POST, "carId");
                $typeConsumption = filter_input(INPUT_POST, "typeConsumption");
                $startDate = filter_input(INPUT_POST, "startDate");
                $endDate = filter_input(INPUT_POST, "endDate");
        } else {
            $arrayConditions = explode(",", $array);
            $startDate = $arrayConditions[0];
            $endDate = $arrayConditions[1];
            $carId = $arrayConditions[2];
            $customerId = $arrayConditions[3];
            $parcId = $arrayConditions[4];
            $tankId = $arrayConditions[5];
            $cardId = $arrayConditions[6];
            $compteId = $arrayConditions[7];
            $couponsFrom = $arrayConditions[8];
            $couponsTo = $arrayConditions[9];
            $typeConsumption = $arrayConditions[10];
            $conditions = array();
            if (!empty($startDate)) {
                $date_from = str_replace("/", "-", $startDate);
                $start = str_replace("-", "/", $date_from);
                $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                $conditions["Consumption.consumption_date >="] = $startdtm->format('Y-m-d 00:00:00');
            }
            if (!empty($endDate)) {
                $date_to = str_replace("/", "-", $endDate);
                $end = str_replace("-", "/", $date_to);
                $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                $conditions["Consumption.consumption_date <="] = $enddtm->format('Y-m-d 23:59:00');
            }
            if (!empty($carId)) {
                $conditions["SheetRide.car_id"] = $carId;
            }
                if (!empty($customerId)) {
                    $conditions["SheetRide.customer_id"] = $customerId;
                }
                if (!empty($parcId)) {
                    $conditions["Car.parc_id"] = $parcId;
                }
                if (!empty($typeConsumption)) {
                    switch ($typeConsumption) {
                        case ConsumptionTypesEnum::coupon :
                            if (!empty($couponsFrom)) {
                                $conditions["Coupon.id >="] = $couponsFrom;
                            }
                            if (!empty($couponsTo)) {
                                $conditions["Coupon.id <="] = $couponsTo;
                            }
                            break;
                        case ConsumptionTypesEnum::species :
                            if (!empty($compteId)) {
                                $conditions["Compte.id"] = $compteId;
                            }
                            break;
                        case ConsumptionTypesEnum::tank :
                            if (!empty($tankId)) {
                                $conditions["Tank.id"] = $tankId;
                            }
                            break;
                        case ConsumptionTypesEnum::card:
                            if (!empty($cardId)) {
                                $conditions["FuelCard.id"] = $cardId;
                            }
                            break;
                    }

                }


        }
        $ids = filter_input(INPUT_POST, "chkids");

        if (!empty($ids)) {
            $array_ids = explode(",", $ids);
            if (!empty($array_ids)) {
                $conditions["Consumption.id"] = $array_ids;
            }
        }
        $consumptions = $this->Consumption->find('all', array(
            'recursive' => -1, // should be used with joins
            'order'=>array('SheetRide.reference DESC'),
            'conditions' => $conditions,
            'fields' => array(
                'Consumption.consumption_date',
                'Consumption.type_consumption_used',
                'Consumption.nb_coupon',
                'Consumption.id',
                'Consumption.first_number_coupon',
                'Consumption.last_number_coupon',
                'Consumption.species',
                'Consumption.consumption_liter',
                'Consumption.species_card',
                'Consumption.cost',
                'Tank.name',
                'Compte.num_compte',
                'FuelCard.reference',
                'Coupon.serial_number',
                'Car.immatr_def',
                'Customer.first_name',
                'Customer.last_name',
                'Destination.name',

            ),
            'joins' => array(
                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('Consumption.sheet_ride_id = SheetRide.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Car.id = SheetRide.car_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Destination',
                    'conditions' => array('SheetRide.destination_id = Destination.id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('SheetRide.customer_id = Customer.id')
                ),
                array(
                    'table' => 'tanks',
                    'type' => 'left',
                    'alias' => 'Tank',
                    'conditions' => array('Consumption.tank_id = Tank.id')
                ),
                array(
                    'table' => 'fuel_cards',
                    'type' => 'left',
                    'alias' => 'FuelCard',
                    'conditions' => array('Consumption.fuel_card_id = FuelCard.id')
                ),
                array(
                    'table' => 'comptes',
                    'type' => 'left',
                    'alias' => 'Compte',
                    'conditions' => array('Consumption.compte_id = Compte.id')
                ),
                array(
                    'table' => 'coupons',
                    'type' => 'left',
                    'alias' => 'Coupon',
                    'conditions' => array('Consumption.id = Coupon.consumption_id')
                ),
            )
        ));
        //var_dump($consumptions); die();
        $car = $this->Car->getCarById($carId);

        $this->set(compact('consumptions','startDate',
            'endDate','car','typeConsumption','carId'));

    }

    public function delete($id = null)
    {
        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        if (empty($id)){
            $id = $this->request->data['id'];
        }
        $this->verifyUserPermission(SectionsEnum::consommation, $user_id, ActionsEnum::delete,
            "Consumptions", $id, "Consumption", null);
        $consumption = $this->Consumption->find('first',array(
            'conditions' => array(
                'Consumption.id' => $id
            )
        ));
        $this->Consumption->id = $id;
         if (!$this->Consumption->exists()) {
            throw new NotFoundException(__('Invalid Consumption'));
        }
        //$this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Consumption->delete()) {
            $this->saveUserAction(SectionsEnum::consommation,
                $id, $this->Session->read('Auth.User.id'), ActionsEnum::delete);
            if ($consumption['Consumption']['type_consumption_used'] == ConsumptionTypesEnum::tank){
                $this->restoreDeletedConsumptionLitersToTank($consumption);
            }
            if (!empty($id)){
                $this->Flash->success(__('The consumption has been deleted.'));
            }
            $response = "true";
        } else {
            if (!empty($id)){
                $this->Flash->error(__('The consumption could not be deleted. Please, try again.'));
            }
            $response = "false";
        }
        if (isset($this->request->data['id']) && !empty($this->request->data['id'])){
            echo json_encode(array('response' => $response));
            exit;
        }else{
            $this->redirect(array('action' => 'index'));
        }
    }

    public function getFuelPriceByCarId($carId)
    {
        $fuelId = $this->Car->getFuelIdOfCar($carId);
        $fuel = $this->Fuel->getFuelById($fuelId);
        $this->set(compact('fuel'));
    }

    public function restoreDeletedConsumptionLitersToTank($consumption){
        $tank = $this->Tank->find('first',array(
            'conditions' => array('Tank.id' => $consumption['Tank']['id'])
        ));
        $this->Tank->id = $tank['Tank']['id'];
        $this->Tank->set(array('liter' => $tank['Tank']['liter'] + $consumption['Consumption']['consumption_liter'] ));
        $this->Tank->save();
    }

    public function deleteConsumptions()
    {
        $this->autoRender = false;
        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $id = $this->request->data['id'];
        $this->verifyUserPermission(SectionsEnum::consommation, $user_id, ActionsEnum::delete,
            "Consumptions", $id, "Consumption", null);
        $consumption = $this->Consumption->find('first',array(
            'conditions' => array(
                'Consumption.id' => $id
            )
        ));
        $this->Consumption->id = $id;
        if (!$this->Consumption->exists()) {
            throw new NotFoundException(__('Invalid Consumption'));
        }
        //$this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Consumption->delete()) {
            $this->saveUserAction(SectionsEnum::consommation,
                $id, $this->Session->read('Auth.User.id'), ActionsEnum::delete);
            if ($consumption['Consumption']['type_consumption_used'] == ConsumptionTypesEnum::tank){
                $this->restoreDeletedConsumptionLitersToTank($consumption);
            }
            $response = "true";
        } else {
            $response = "false";
        }
        echo json_encode(array('response' => $response));
        exit;
    }



}