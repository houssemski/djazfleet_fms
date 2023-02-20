<?php

App::uses('AppController', 'Controller');
/**
 *
 * /**
 * Transport Bill Detail Rides Controller
 *
 * @property TransportBillDetailRides $TransportBillDetailRides
 * @property DetailRide $DetailRide
 * @property CarType $CarType
 * @property Company $Company
 * @property Ride $Ride
 * @property Customer $Customer
 * @property Profile $Profile
 * @property Carmodel $Carmodel
 * @property Supplier $Supplier
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class TransportBillDetailRidesController extends AppController
{

    public $components = array('Paginator', 'Session', 'Security', 'RequestHandler');
    public $uses = array(
        'TransportBillDetailRides',
        'TransportBillDetailedRides',
        'Ride',
        'CarType',
        'Carmodel',
        'MarchandisesSheetRide',
        'Customer',
        'Company',
        'Profile'
    );
    var $helpers = array('Xls', 'Tinymce');

    public function getOrder($params = null , $orderType = null)
    {
        if($orderType == null){
            $orderType = 'DESC';
        }
        if (isset($params) && is_numeric($params)) {
            switch ($params) {
                case 1 :
                    $order = array('TransportBillDetailRides.reference' => $orderType);
                    break;
                case 2 :
                    $order = array('TransportBillDetailRides.id' => $orderType);
                    break;
                case 3 :
                    $order = array('TransportBillDetailRides.date' => $orderType);
                    break;
                    break;
                default :
                    $order = array('TransportBillDetailRides.reference' => $orderType);
            }
            return $order;
        } else {
            $order = array('TransportBillDetailRides.reference' => $orderType);
            return $order;
        }
    }

    public function index()
    {
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::detail_commande_client, $user_id, ActionsEnum::view,
            "TransportBillDetailRides", null, "TransportBillDetailRides", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['2']) ? $this->getOrder($this->params['pass']['2'],$this->params['pass']['3']) : $this->getOrder();
        switch ($result) {
            case 1 :
                $conditions = array('TransportBill.type ' => 2);
                break;
            case 2 :
                $conditions = array('TransportBill.user_id ' => $user_id, 'TransportBill.type ' => 2);
                break;
            case 3 :
                $conditions = array('TransportBill.user_id !=' => $user_id, 'TransportBill.type ' => 2);
                break;
            default:
                $conditions = array('TransportBill.type ' => 2);
        }
        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'order' =>
                'TransportBillDetailedRides.id desc,TransportBill.date desc',
            'group' => array('TransportBillDetailedRides.id'),
            'conditions' => $conditions,
            'fields' => array(
                'TransportBill.reference',
                'TransportBill.id',
                'TransportBill.type',
                'TransportBill.supplier_id',
                'TransportBill.date',
                'TransportBill.order_type',
                'CarType.name',
                'TransportBillDetailedRides.type_ride',
                'TransportBill.order_type',
                'TransportBillDetailedRides.id',
                'TransportBillDetailedRides.reference',
                'TransportBillDetailedRides.detail_ride_id',
                'TransportBillDetailedRides.unit_price',
                'TransportBillDetailedRides.nb_trucks_validated',
                'TransportBillDetailedRides.nb_trucks',
                'TransportBillDetailedRides.price_ht',
                'TransportBillDetailedRides.tva_id',
                'TransportBillDetailedRides.price_ttc',
                'TransportBillDetailedRides.ristourne_%',
                'TransportBillDetailedRides.ristourne_val',
                'TransportBillDetailedRides.id',
                'TransportBillDetailedRides.status_id',
                'TransportBillDetailedRides.nb_hours',
                'TransportBillDetailedRides.start_date',
                'TransportBillDetailedRides.programming_date',
                'TransportBillDetailedRides.charging_time',
                'TransportBillDetailedRides.unloading_date',
                'TransportBillDetailedRides.observation_order',
                'TransportBillDetailedRides.delivery_with_return',
                'TransportBillDetailedRides.designation',
                'TransportBillDetailRides.id',
                'TransportBillDetailRides.reference',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Departure.name',
                'Arrival.name',
                'Type.name',
                'Supplier.name',
                'SupplierFinal.name',
                'Observation.id',
                'Observation.customer_observation',
                'Observation.cancel_cause_id',
                'Car.immatr_def',
                'User.first_name',
                'User.last_name',
                'Subcontractor.name',
            ),
            'joins' => array(
                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('TransportBillDetailedRides.transport_bill_id = TransportBill.id')
                ),
                array(
                    'table' => 'transport_bill_detail_rides',
                    'type' => 'left',
                    'alias' => 'TransportBillDetailRides',
                    'conditions' => array('TransportBillDetailRides.transport_bill_id = TransportBill.id')
                ),
                array(
                    'table' => 'observations',
                    'type' => 'left',
                    'alias' => 'Observation',
                    'conditions' => array('TransportBillDetailRides.id = Observation.transport_bill_detail_ride_id')
                ),
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('TransportBillDetailRides.detail_ride_id = DetailRide.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('DetailRide.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('TransportBillDetailedRides.car_id = Car.id')
                ),
                array(
                    'table' => 'rides',
                    'type' => 'left',
                    'alias' => 'Ride',
                    'conditions' => array('DetailRide.ride_id = Ride.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('TransportBill.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'SupplierFinal',
                    'conditions' => array('TransportBillDetailedRides.supplier_final_id = SupplierFinal.id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'DepartureDestination',
                    'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'ArrivalDestination',
                    'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Departure',
                    'conditions' => array('Departure.id = TransportBillDetailedRides.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Arrival',
                    'conditions' => array('Arrival.id = TransportBillDetailedRides.arrival_destination_id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'Type',
                    'conditions' => array('TransportBillDetailedRides.car_type_id = Type.id')
                ),
                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('TransportBillDetailedRides.sheet_ride_id = SheetRide.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Subcontractor',
                    'conditions' => array('SheetRide.supplier_id = Subcontractor.id')
                ),
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'User',
                    'conditions' => array('User.id = TransportBill.user_id')
                ),
            )
        );

        $transportBillDetailRides = $this->Paginator->paginate('TransportBillDetailedRides');
        $this->set('transportBillDetailRides', $transportBillDetailRides);

        $this->set(compact('limit', 'order'));

        $users = $this->User->find('list', array('conditions' => 'User.id != 1'));
        $profiles = $this->Profile->getUserProfiles();
        $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
        $this->TransportBillDetailRides->DetailRide->Ride->virtualFields = array(
            'cnames' => "CONCAT(DepartureDestination.name, ' - ', ArrivalDestination.name)"
        );


        $rides = $this->TransportBillDetailRides->DetailRide->Ride->find('list', array(
            'recursive' => -1,
            'fields' => 'cnames',
            'joins' => array(

                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'DepartureDestination',
                    'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'ArrivalDestination',
                    'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                )
            )
        ));
        $carTypes = $this->CarType->getCarTypes();
        $separatorAmount = $this->getSeparatorAmount();
        $isSuperAdmin = $this->isSuperAdmin();
        $profileId = $this->Auth->user('profile_id');
        $this->set(compact('profiles', 'users', 'suppliers', 'rides', 'carTypes',
            'separatorAmount','isSuperAdmin','profileId'));

    }

    public function view_mission($id)
    {
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        if (!$this->SheetRideDetailRides->exists($id)) {
            throw new NotFoundException(__('Invalid sheet ride'));
        }

        $sheetRideDetailRide = $this->SheetRideDetailRides->find('first', array(
            'recursive' => -1,
            'conditions' => array('SheetRideDetailRides.' . $this->SheetRideDetailRides->primaryKey => $id),
            'fields' => array(

                'SheetRideDetailRides.id',
                'SheetRide.id',
                'SheetRide.reference',
                'SheetRideDetailRides.detail_ride_id',
                'SheetRideDetailRides.planned_start_date',
                'SheetRideDetailRides.real_start_date',
                'SheetRideDetailRides.km_departure',
                'SheetRideDetailRides.planned_end_date',
                'SheetRideDetailRides.real_end_date',
                'SheetRideDetailRides.km_arrival',
                'SheetRideDetailRides.supplier_id',
                'SheetRideDetailRides.supplier_final_id',
                'SheetRideDetailRides.status_id',
                'SheetRide.car_id',
                'SheetRide.customer_id',
                'CarType.name',
                'Supplier.name',
                'SupplierFinal.name',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Car.code',
                'Customer.first_name',
                'Customer.last_name',
                'Car.immatr_def',
                'Carmodel.name',
                'CarmodelRemorque.name',
                'Customer.image',
                'Customer.tel',
                'CustomerCategory.name',
                'Remorque.immatr_def',
                'CustomerHelp.first_name',
                'CustomerHelp.last_name'
            ),
            'joins' => array(

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
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Remorque',
                    'conditions' => array('SheetRide.remorque_id = Remorque.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'CarmodelRemorque',
                    'conditions' => array('Remorque.carmodel_id = CarmodelRemorque.id')
                ),
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('DetailRide.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'rides',
                    'type' => 'left',
                    'alias' => 'Ride',
                    'conditions' => array('DetailRide.ride_id = Ride.id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'DepartureDestination',
                    'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'ArrivalDestination',
                    'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('SheetRide.customer_id = Customer.id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'CustomerHelp',
                    'conditions' => array('SheetRide.customer_help = CustomerHelp.id')
                ),
                array(
                    'table' => 'customer_categories',
                    'type' => 'left',
                    'alias' => 'CustomerCategory',
                    'conditions' => array('Customer.customer_category_id = CustomerCategory.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('SheetRideDetailRides.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'SupplierFinal',
                    'conditions' => array('SheetRideDetailRides.supplier_final_id = SupplierFinal.id')
                ),


            )

        ));
        /*$remorque=$this->SheetRide->Car->find('first',array('recursive'=>1,'conditions'=>array('Car.id'=>$sheetRide['SheetRide']['remorque_id'])));
        
        $customer_help=$this->SheetRide->Customer->find('first',array('recursive'=>1,'conditions'=>array('Customer.id'=>$sheetRide['SheetRide']['customer_help'])));                                                                                                                 
        $this->set('remorque',$remorque);
        $this->set('customer_help',$customer_help);*/
        $this->set('sheetRideDetailRide', $sheetRideDetailRide);
        $company = $this->Company->find('first');
        $this->set('company', $company);
        // get method of header pdf
        $entete_pdf = $this->Parameter->getCodesParameterVal('entete_pdf');
        // get signature of mission order
        $signature_mission_order = $this->Parameter->getCodesParameterVal('signature_mission_order');

        $this->set('signature_mission_order', $signature_mission_order);
        $this->set('entete_pdf', $entete_pdf);
    }


    public function search()
    {
        $this->setTimeActif();

        if (isset($this->request->data['keyword']) || isset($this->request->data['TransportBillDetailRides']['user_id']) ||
            isset($this->request->data['TransportBillDetailRides']['modified_id'])
            || isset($this->request->data['TransportBillDetailRides']['created']) || isset($this->request->data['TransportBillDetailRides']['created1'])
            || isset($this->request->data['TransportBillDetailRides']['modified']) || isset($this->request->data['TransportBillDetailRides']['modified1'])
            || isset($this->request->data['TransportBillDetailRides']['detail_ride_id']) || isset($this->request->data['TransportBillDetailRides']['ride_id'])
            || isset($this->request->data['TransportBillDetailRides']['car_type_id'])
            || isset($this->request->data['TransportBillDetailRides']['supplier_id'])
            || isset($this->request->data['TransportBillDetailRides']['order_type'])
            || isset($this->request->data['TransportBillDetailRides']['profile_id'])
        ) {
            $this->filterUrl();
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $this->paginate = array(
            'limit' => $limit,
            'order' => 'TransportBillDetailedRides.id desc,TransportBill.date desc',
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword']) || isset($this->params['named']['user'])
            || isset($this->params['named']['profile'])
            || isset($this->params['named']['created']) || isset($this->params['named']['created1'])
            || isset($this->params['named']['ride']) || isset($this->params['named']['modified_id'])
            || isset($this->params['named']['supplier']) || isset($this->params['named']['type'])
            || isset($this->params['named']['car_type'])|| isset($this->params['named']['order_type'])
            || isset($this->params['named']['modified']) || isset($this->params['named']['modified1'])
            || isset($this->params['named']['date1']) || isset($this->params['named']['date2'])
        ) {
            $conditions = $this->getConds();
            $this->paginate = array(
                'paramType' => 'querystring',
                'recursive' => -1, // should be used with joins
                'limit' => $limit,
                'conditions' => $conditions,
                'order' => 'TransportBillDetailedRides.id desc,TransportBill.date desc',
                'fields' => array(
                    'TransportBillDetailedRides.id',
                    'TransportBillDetailedRides.unit_price',
                    'TransportBillDetailedRides.status_id',
                    'TransportBillDetailedRides.nb_trucks',
                    'TransportBillDetailedRides.price_ht',
                    'TransportBillDetailedRides.price_ttc',
                    'TransportBillDetailedRides.tva_id',
                    'TransportBillDetailedRides.ristourne_%',
                    'TransportBillDetailedRides.ristourne_val',
                    'TransportBillDetailedRides.detail_ride_id',
                    'TransportBillDetailedRides.nb_trucks_validated',
                    'TransportBillDetailedRides.reference',
                    'TransportBillDetailedRides.observation_order',
                    'TransportBillDetailedRides.id',
                    'TransportBillDetailedRides.type_ride',
                    'TransportBillDetailedRides.programming_date',
                    'TransportBillDetailedRides.charging_time',
                    'TransportBillDetailedRides.unloading_date',
                    'TransportBillDetailedRides.delivery_with_return',
                    'TransportBillDetailedRides.designation',
                    'TransportBill.reference',
                    'TransportBill.id',
                    'TransportBill.order_type',
                    'DetailRide.id',
                    'Supplier.name',
                    'SupplierFinal.name',
                    'Supplier.code',
                    'SupplierFinal.code',
                    'DepartureDestination.name',
                    'ArrivalDestination.name',
                    'CarType.name',
                    'Departure.name',
                    'Arrival.name',
                    'Type.name',
                    'TransportBill.supplier_id',
                    'TransportBill.supplier_final_id',
                    'TransportBill.date',
                    'Tva.name',
                    'User.first_name',
                    'User.last_name',
                    'Subcontractor.name',
                ),
                'joins' => array(
                    array(
                        'table' => 'detail_rides',
                        'type' => 'left',
                        'alias' => 'DetailRide',
                        'conditions' => array('TransportBillDetailedRides.detail_ride_id = DetailRide.id')
                    ),
                    array(
                        'table' => 'transport_bills',
                        'type' => 'left',
                        'alias' => 'TransportBill',
                        'conditions' => array('TransportBillDetailedRides.transport_bill_id = TransportBill.id')
                    ),
                    array(
                        'table' => 'transport_bill_detail_rides',
                        'type' => 'left',
                        'alias' => 'TransportBillDetailRides',
                        'conditions' => array('TransportBillDetailedRides.transport_bill_detail_ride_id = TransportBillDetailRides.id')
                    ),
                    array(
                        'table' => 'rides',
                        'type' => 'left',
                        'alias' => 'Ride',
                        'conditions' => array('DetailRide.ride_id = Ride.id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'CarType',
                        'conditions' => array('DetailRide.car_type_id = CarType.id')
                    ),
                    array(
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'DepartureDestination',
                        'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                    ),
                    array(
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'ArrivalDestination',
                        'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'Type',
                        'conditions' => array('TransportBillDetailedRides.car_type_id = Type.id')
                    ),
                    array(
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'Departure',
                        'conditions' => array('Departure.id = TransportBillDetailedRides.departure_destination_id')
                    ),
                    array(
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'Arrival',
                        'conditions' => array('Arrival.id = TransportBillDetailedRides.arrival_destination_id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('Supplier.id = TransportBill.supplier_id')
                    ),
                    array(
                        'table' => 'tva',
                        'type' => 'left',
                        'alias' => 'Tva',
                        'conditions' => array('Tva.id = TransportBillDetailedRides.tva_id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'SupplierFinal',
                        'conditions' => array('SupplierFinal.id = TransportBill.supplier_final_id')
                    ),
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('User.id = TransportBill.user_id')
                    ),

                    array(
                        'table' => 'sheet_rides',
                        'type' => 'left',
                        'alias' => 'SheetRide',
                        'conditions' => array('SheetRide.id = TransportBillDetailedRides.sheet_ride_id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Subcontractor',
                        'conditions' => array('SheetRide.supplier_id = Subcontractor.id')
                    ),

                )
            );
            $transportBillDetailRides = $this->Paginator->paginate('TransportBillDetailedRides');
            $this->set('transportBillDetailRides', $transportBillDetailRides);
            $this->set(compact('limit', 'order'));
        }
        $users = $this->User->find('list', array('conditions' => 'User.id != 1'));
        $profiles = $this->Profile->getUserProfiles();
        $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
        $this->TransportBillDetailRides->DetailRide->Ride->virtualFields = array(
            'cnames' => "CONCAT(DepartureDestination.name, ' - ', ArrivalDestination.name)"
        );
        $rides = $this->TransportBillDetailRides->DetailRide->Ride->find('list', array(
            'recursive' => -1,
            'fields' => 'cnames',
            'joins' => array(
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'DepartureDestination',
                    'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'ArrivalDestination',
                    'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                )
            )
        ));
        $carTypes = $this->CarType->getCarTypes();
        $separatorAmount = $this->getSeparatorAmount();
        $isSuperAdmin = $this->isSuperAdmin();
        $profileId = $this->Auth->user('profile_id');
        $this->set(compact('profiles', 'users', 'suppliers', 'rides', 'carTypes',
            'separatorAmount','isSuperAdmin','profileId'));
        $this->render();

    }

    private function filterUrl()
    {


        $filter_url['controller'] = $this->request->params['controller'];
        $filter_url['action'] = $this->request->params['action'];
        $filter_url['page'] = 1;
        $filter_url['keyword'] = $this->request->data['keyword'];
        $filter_url['keyword'] = str_replace('/', '-', $filter_url['keyword']);

        if (isset($this->request->data['TransportBillDetailRides']['supplier_id']) && !empty($this->request->data['TransportBillDetailRides']['supplier_id'])) {
            $filter_url['supplier'] = $this->request->data['TransportBillDetailRides']['supplier_id'];
        }
        if (isset($this->request->data['TransportBillDetailRides']['order_type']) && !empty($this->request->data['TransportBillDetailRides']['order_type'])) {
            $filter_url['order_type'] = $this->request->data['TransportBillDetailRides']['order_type'];
        }

        if (isset($this->request->data['TransportBillDetailRides']['car_type_id']) && !empty($this->request->data['TransportBillDetailRides']['car_type_id'])) {
            $filter_url['car_type'] = $this->request->data['TransportBillDetailRides']['car_type_id'];
        }
        if (isset($this->request->data['TransportBillDetailRides']['ride_id']) && !empty($this->request->data['TransportBillDetailRides']['ride_id'])) {
            $filter_url['ride'] = $this->request->data['TransportBillDetailRides']['ride_id'];
        }
        if (isset($this->request->data['TransportBillDetailRides']['user_id']) && !empty($this->request->data['TransportBillDetailRides']['user_id'])) {
            $filter_url['user'] = $this->request->data['TransportBillDetailRides']['user_id'];
        }

        if (isset($this->request->data['TransportBillDetailRides']['profile_id']) && !empty($this->request->data['TransportBillDetailRides']['profile_id'])) {
            $filter_url['profile'] = $this->request->data['TransportBillDetailRides']['profile_id'];
        }
        if (isset($this->request->data['TransportBillDetailRides']['created']) && !empty($this->request->data['TransportBillDetailRides']['created'])) {
            $filter_url['created'] = str_replace("/", "-", $this->request->data['TransportBillDetailRides']['created']);
        }
        if (isset($this->request->data['TransportBillDetailRides']['created1']) && !empty($this->request->data['TransportBillDetailRides']['created1'])) {
            $filter_url['created1'] = str_replace("/", "-",
                $this->request->data['TransportBillDetailRides']['created1']);
        }
        if (isset($this->request->data['TransportBillDetailRides']['modified_id']) && !empty($this->request->data['TransportBillDetailRides']['modified_id'])) {
            $filter_url['modified_id'] = $this->request->data['TransportBillDetailRides']['modified_id'];
        }
        if (isset($this->request->data['TransportBillDetailRides']['modified']) && !empty($this->request->data['TransportBillDetailRides']['modified'])) {
            $filter_url['modified'] = str_replace("/", "-",
                $this->request->data['TransportBillDetailRides']['modified']);
        }
        if (isset($this->request->data['TransportBillDetailRides']['modified1']) && !empty($this->request->data['TransportBillDetailRides']['modified1'])) {
            $filter_url['modified1'] = str_replace("/", "-",
                $this->request->data['TransportBillDetailRides']['modified1']);
        }

        if (isset($this->request->data['TransportBillDetailRides']['date1']) && !empty($this->request->data['TransportBillDetailRides']['date1'])) {
            $filter_url['date1'] = str_replace("/", "-", $this->request->data['TransportBillDetailRides']['date1']);
        }
        if (isset($this->request->data['TransportBillDetailRides']['date2']) && !empty($this->request->data['TransportBillDetailRides']['date2'])) {
            $filter_url['date2'] = str_replace("/", "-", $this->request->data['TransportBillDetailRides']['date2']);
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
                    "LOWER(TransportBillDetailedRides.reference) LIKE" => "%$keyword%",
                    "LOWER(Supplier.name) LIKE" => "%$keyword%",
                    "LOWER(DepartureDestination.name) LIKE" => "%$keyword%",
                    "LOWER(Departure.name) LIKE" => "%$keyword%",
                    "LOWER(ArrivalDestination.name) LIKE" => "%$keyword%",
                    "LOWER(Arrival.name) LIKE" => "%$keyword%",
                    "LOWER(Type.name) LIKE" => "%$keyword%",
                    "LOWER(CarType.name) LIKE" => "%$keyword%",
                    "LOWER(User.first_name) LIKE" => "%$keyword%",
                    "LOWER(User.last_name) LIKE" => "%$keyword%",
                    "LOWER(Subcontractor.name) LIKE" => "%$keyword%",
                    "LOWER(TransportBillDetailedRides.observation_order) LIKE" => "%$keyword%",
                    "LOWER(TransportBillDetailedRides.unit_price) LIKE" => "%$keyword%",
                )
            );
        } else {
            $conds = array();
        }


        $conds['TransportBill.type '] = 2;
        if (isset($this->params['named']['ride']) && !empty($this->params['named']['ride'])) {
            $conds["DetailRide.ride_id = "] = $this->params['named']['ride'];
            $this->request->data['TransportBillDetailRides']['ride_id'] = $this->params['named']['ride'];
        }

        if (isset($this->params['named']['supplier']) && !empty($this->params['named']['supplier'])) {
            $conds["TransportBill.supplier_id = "] = $this->params['named']['supplier'];
            $this->request->data['TransportBillDetailRides']['supplier_id'] = $this->params['named']['supplier'];
        }

        if (isset($this->params['named']['order_type']) && !empty($this->params['named']['order_type'])) {
            $conds["TransportBill.order_type = "] = $this->params['named']['order_type'];
            $this->request->data['TransportBillDetailRides']['order_type'] = $this->params['named']['order_type'];
        }

        if (isset($this->params['named']['car_type']) && !empty($this->params['named']['car_type'])) {
            $conds["TransportBillDetailedRides.car_type_id = "] = $this->params['named']['car_type'];
            $this->request->data['TransportBillDetailRides']['car_type_id'] = $this->params['named']['car_type'];
        }

        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $conds["TransportBill.user_id = "] = $this->params['named']['user'];
            $this->request->data['TransportBillDetailRides']['user_id'] = $this->params['named']['user'];
        }

        if (isset($this->params['named']['profile']) && !empty($this->params['named']['profile'])) {
            $conds["User.profile_id = "] = $this->params['named']['profile'];
            $this->request->data['TransportBillDetailRides']['profile_id'] = $this->params['named']['profile'];
        }

        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $creat = str_replace("-", "/", $this->params['named']['created']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["TransportBillDetailRides.created >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['TransportBillDetailedRides']['created'] = $creat;
        }

        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $creat = str_replace("-", "/", $this->params['named']['created1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["TransportBillDetailRides.created <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['TransportBillDetailRides']['created1'] = $creat;
        }

        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $conds["TransportBill.modified_id = "] = $this->params['named']['modified_id'];
            $this->request->data['TransportBillDetailRides']['modified_id'] = $this->params['named']['modified_id'];
        }

        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["TransportBillDetailedRides.modified >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['TransportBillDetailRides']['modified'] = $creat;
        }

        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["TransportBillDetailRides.modified <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['TransportBillDetailRides']['modified1'] = $creat;
        }
        if (isset($this->params['named']['date1']) && !empty($this->params['named']['date1'])) {
            $creat = str_replace("-", "/", $this->params['named']['date1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["TransportBillDetailRides.programming_date >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['TransportBillDetailRides']['date1'] = $creat;
        }
        if (isset($this->params['named']['date2']) && !empty($this->params['named']['date2'])) {
            $creat = str_replace("-", "/", $this->params['named']['date2']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["TransportBillDetailRides.programming_date <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['TransportBillDetailRides']['date2'] = $creat;
        }
        return $conds;
    }


    public function viewDetail($transportBillDetailRideId = null, $nbTrucks = null)
    {
        $this->set('nbTrucks', $nbTrucks);
        $this->layout = 'ajax';
        $sheetRideDetailRides = $this->SheetRideDetailRides->find('all', array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'order' => array('SheetRideDetailRides.id' => 'DESC'),
            'conditions' => array('SheetRideDetailRides.transport_bill_detail_ride_id' => $transportBillDetailRideId),
            'fields' => array(
                'SheetRideDetailRides.reference',
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.detail_ride_id',
                'SheetRideDetailRides.planned_start_date',
                'SheetRideDetailRides.real_start_date',
                'SheetRideDetailRides.km_departure',
                'SheetRideDetailRides.planned_end_date',
                'SheetRideDetailRides.real_end_date',
                'SheetRideDetailRides.km_arrival',
                'SheetRideDetailRides.supplier_id',
                'SheetRideDetailRides.supplier_final_id',
                'SheetRideDetailRides.status_id',
                'SheetRideDetailRides.note',
                'SheetRide.car_id',
                'SheetRide.customer_id',
                'CarType.name',
                'Supplier.name',
                'SupplierFinal.name',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Car.code',
                'Customer.first_name',
                'Customer.last_name',
                'Customer.mobile',
                'Car.immatr_def',
                'Carmodel.name',
                'TransportBill.note'


            ),
            'joins' => array(

                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('SheetRide.id = SheetRideDetailRides.sheet_ride_id')
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
                    'conditions' => array('TransportBill.id = TransportBillDetailRides.transport_bill_id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('SheetRide.car_id = Car.id')
                ),
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('DetailRide.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'rides',
                    'type' => 'left',
                    'alias' => 'Ride',
                    'conditions' => array('DetailRide.ride_id = Ride.id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'DepartureDestination',
                    'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'ArrivalDestination',
                    'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('SheetRide.customer_id = Customer.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('SheetRideDetailRides.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'SupplierFinal',
                    'conditions' => array('SheetRideDetailRides.supplier_final_id = SupplierFinal.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),


            )
        ));
        //Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set(compact('sheetRideDetailRides', 'param'));
    }


    public function viewPrice($transportBillDetailRideId = null)
    {

        $transportBillDetailRide = $this->TransportBillDetailRides->find('first', array(

            'recursive' => -1, // should be used with joins

            'order' => array('TransportBillDetailRides.id' => 'DESC'),
            'conditions' => array('TransportBillDetailRides.id' => $transportBillDetailRideId),
            'fields' => array(
                'TransportBillDetailRides.unit_price',
                'TransportBillDetailRides.status_id',
                'TransportBillDetailRides.nb_trucks',
                'TransportBillDetailRides.price_ht',
                'TransportBillDetailRides.price_ttc',
                'TransportBillDetailRides.tva_id',
                'TransportBillDetailRides.ristourne_%',
                'TransportBillDetailRides.ristourne_val',
                'TransportBillDetailRides.detail_ride_id',
                'TransportBillDetailRides.nb_trucks_validated',
                'TransportBillDetailRides.reference',
                'TransportBillDetailRides.id',
                'DetailRide.id',
                'Supplier.name',
                'SupplierFinal.name',
                'Supplier.code',
                'SupplierFinal.code',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'CarType.name',
                'TransportBill.supplier_id',
                'TransportBill.supplier_final_id',
                'TransportBill.date',
                'Tva.name',
            ),
            'joins' => array(
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('TransportBillDetailRides.detail_ride_id = DetailRide.id')
                ),
                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('TransportBillDetailRides.transport_bill_id = TransportBill.id')
                ),
                array(
                    'table' => 'rides',
                    'type' => 'left',
                    'alias' => 'Ride',
                    'conditions' => array('DetailRide.ride_id = Ride.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('DetailRide.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'DepartureDestination',
                    'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'ArrivalDestination',
                    'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Supplier.id = TransportBill.supplier_id')
                ),
                array(
                    'table' => 'tva',
                    'type' => 'left',
                    'alias' => 'Tva',
                    'conditions' => array('Tva.id = TransportBillDetailRides.tva_id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'SupplierFinal',
                    'conditions' => array('SupplierFinal.id = TransportBill.supplier_final_id')
                ),

            )
        ));
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('transportBillDetailRide', 'separatorAmount'));
    }

    public function liste( $id = null, $keyword = null)
    {

        $keyword = str_replace('espace', ' ', $keyword);
        $keyword = str_replace('slash', '/', $keyword);
        $keyword = str_replace('tiret', '-', $keyword);

        $keyword = strtolower($keyword);
        $this->layout = 'ajax';
        $limit = $this->getLimit();
        switch ($id) {
            case 2 :
                $conditions = array("LOWER(TransportBillDetailRides.reference) LIKE" => "%$keyword%");
                break;
            case 3 :
                $keyword = str_replace("/", "-", $keyword);
                $start = str_replace("-", "/", $keyword);
                $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                $conditions = array("TransportBillDetailRides.date >=" => $startdtm->format('Y-m-d 00:00:00'));
                break;
            case 4 :
                $conditions = array("LOWER(Supplier.code) LIKE" => "%$keyword%");
                break;
            case 5 :
                $conditions = array("LOWER(Supplier.name) LIKE" => "%$keyword%");
                break;
            case 6 :
                $conditions = array("LOWER(DepartureDestination.name) LIKE" => "%$keyword%");
                break;

            case 7 :
                $conditions = array("LOWER(SupplierFinal.code) LIKE" => "%$keyword%");
                break;
            case 8 :
                $conditions = array("LOWER(SupplierFinal.name) LIKE" => "%$keyword%");
                break;
            case 9 :
                $conditions = array("LOWER(ArrivalDestination.name) LIKE" => "%$keyword%");
                break;

            case 10 :
                $conditions = array("LOWER(TransportBillDetailRides.nb_trucks) LIKE" => "%$keyword%");
                break;

            case 11 :
                $conditions = array("LOWER(TransportBillDetailRides.nb_trucks_validated) LIKE" => "%$keyword%");
                break;

            case 12 :
                $conditions = array("LOWER(TransportBillDetailRides.nb_trucks) LIKE" => "%$keyword%");
                break;

            default:
                $conditions = array("LOWER(TransportBillDetailRides.reference) LIKE" => "%$keyword%");
        }

        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins

            'order' => array('TransportBillDetailRides.id' => 'DESC'),
            'conditions' => $conditions,
            'limit'=>$limit,
            'fields' => array(
                'TransportBillDetailRides.unit_price',
                'TransportBillDetailRides.status_id',
                'TransportBillDetailRides.nb_trucks',
                'TransportBillDetailRides.price_ht',
                'TransportBillDetailRides.price_ttc',
                'TransportBillDetailRides.tva_id',
                'TransportBillDetailRides.ristourne_%',
                'TransportBillDetailRides.ristourne_val',
                'TransportBillDetailRides.detail_ride_id',
                'TransportBillDetailRides.nb_trucks_validated',
                'TransportBillDetailRides.reference',
                'TransportBillDetailRides.id',
                'DetailRide.id',
                'Supplier.name',
                'SupplierFinal.name',
                'Supplier.code',
                'SupplierFinal.code',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'CarType.name',
                'TransportBill.supplier_id',
                'TransportBill.supplier_final_id',
                'TransportBill.date',
                'Tva.name',
            ),
            'joins' => array(
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('TransportBillDetailRides.detail_ride_id = DetailRide.id')
                ),
                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('TransportBillDetailRides.transport_bill_id = TransportBill.id')
                ),
                array(
                    'table' => 'rides',
                    'type' => 'left',
                    'alias' => 'Ride',
                    'conditions' => array('DetailRide.ride_id = Ride.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('DetailRide.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'DepartureDestination',
                    'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'ArrivalDestination',
                    'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Supplier.id = TransportBill.supplier_id')
                ),
                array(
                    'table' => 'tva',
                    'type' => 'left',
                    'alias' => 'Tva',
                    'conditions' => array('Tva.id = TransportBillDetailRides.tva_id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'SupplierFinal',
                    'conditions' => array('SupplierFinal.id = TransportBill.supplier_final_id')
                ),

            )
        );


        $transportBillDetailRides = $this->Paginator->paginate('TransportBillDetailRides');

        $this->set('transportBillDetailRides', $transportBillDetailRides);

        //Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $client_i2b = $this->isCustomerI2B();
        $isAgent = $this->isAgent();
        $this->set(compact('param', 'client_i2b', 'isAgent'));
    }

    public function printSimplifiedJournal()
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }

        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        $array = filter_input(INPUT_POST, "printSimplifiedJournal");

        $arrayConditions = explode(",", $array);

        $supplierId = $arrayConditions[0];
        $startDate = $arrayConditions[1];
        $endDate = $arrayConditions[2];
        $conditions = array();
        $type = filter_input(INPUT_POST, "typePiece");
        $conditions["TransportBill.type = "] = $type;
        if (!empty($supplierId)) {
            $conditions["Supplier.id"] = $supplierId;
        }
        if (!empty($startDate)) {
            $creat = str_replace("-", "/", $startDate);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conditions["TransportBill.date >= "] = $startdtm->format('Y-m-d 00:00:00');
        }
        if (!empty($endDate)) {

            $creat = str_replace("-", "/", $endDate);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conditions["TransportBill.date <= "] = $startdtm->format('Y-m-d 00:00:00');
        }
        $ids = filter_input(INPUT_POST, "chkids");

        if (!empty($ids)) {


            $arrayIds = explode(",", $ids);
            if (!empty($arrayIds)) {
                $conditions["TransportBillDetailedRides.id"] = $arrayIds;
            }
        }

        $transportBillDetailRides = $this->TransportBillDetailedRides->find('all', array(
            'recursive' => -1,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'group' => 'TransportBillDetailedRides.id',
            'order' => 'TransportBillDetailedRides.programming_date asc',
            'fields' => array(
                'TransportBill.date',
                'TransportBill.order_type',
                'TransportBillDetailedRides.id',
                'TransportBillDetailedRides.unit_price',
                'TransportBillDetailedRides.type_ride',
                'TransportBillDetailedRides.nb_trucks',
                'TransportBillDetailedRides.delivery_with_return',
                'TransportBillDetailedRides.programming_date',
                'TransportBillDetailedRides.designation',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Departure.name',
                'Arrival.name',
                'CarType.name',
                'Type.name',
                'Supplier.name',
                'Supplier.code',
                'Subcontractor.name',
            ),
            'joins' => array(

                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('TransportBillDetailedRides.transport_bill_id = TransportBill.id')
                ),
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('TransportBillDetailedRides.detail_ride_id = DetailRide.id')
                ),
                array(
                    'table' => 'rides',
                    'type' => 'left',
                    'alias' => 'Ride',
                    'conditions' => array('DetailRide.ride_id = Ride.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('DetailRide.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'DepartureDestination',
                    'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'ArrivalDestination',
                    'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'Type',
                    'conditions' => array('TransportBillDetailedRides.car_type_id = Type.id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Departure',
                    'conditions' => array('Departure.id = TransportBillDetailedRides.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Arrival',
                    'conditions' => array('Arrival.id = TransportBillDetailedRides.arrival_destination_id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('TransportBill.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('TransportBillDetailedRides.sheet_ride_id = SheetRide.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Subcontractor',
                    'conditions' => array('SheetRide.supplier_id = Subcontractor.id')
                ),
            )
        ));
        $company = $this->Company->find('first');
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('transportBillDetailRides', 'company', 'separatorAmount','startDate','endDate'));

    }

}
