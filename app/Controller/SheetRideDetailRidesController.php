<?php

App::uses('AppController', 'Controller');

/**
 * SheetRideDetailRides Controller
 *
 * @property SheetRideDetailRides $SheetRideDetailRides
 * @property Ride $Ride
 * @property Carmodel $Carmodel
 * @property Profile $Profile
 * @property Supplier $Supplier
 * @property CarType $CarType
 * @property Customer $Customer
 * @property Company $Company
 * @property Tva $Tva
 * @property Lot $Lot
 * @property Parameter $Parameter
 * @property Marchandise $Marchandise
 * @property MarchandisesSheetRide $MarchandisesSheetRide
 * @property SheetRideDetailRideMarchandise, $SheetRideDetailRideMarchandise,
 * @property AttachmentType, $AttachmentType,
 * @property ParameterAttachmentType, $ParameterAttachmentType,
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class SheetRideDetailRidesController extends AppController
{
    public $components = array('Paginator', 'Session', 'Security', 'RequestHandler');
    public $uses = array(
        'Ride',
        'Attachment',
        'Carmodel',
        'MarchandisesSheetRide',
        'SheetRideDetailRideMarchandise',
        'Customer',
        'CarType',
        'Company',
        'Parc',
        'Lot',
        'Destination',
        'Marchandise',
        'AttachmentType',
        'ParameterAttachmentType',
        'SheetRideDetailRides',
        'SheetRideConveyor',
        'Profile'
    );
    var $helpers = array('Xls');

    public function getOrder($params = null , $orderType = null)
    {
        if($orderType == null){
            $orderType = 'DESC';
        }
        if (isset($params) && is_numeric($params)) {
            switch ($params) {
                case 1 :
                    $order = array('SheetRideDetailRides.reference' => $orderType);
                    break;
                case 2 :
                    $order = array('SheetRideDetailRides.id' => $orderType);
                    break;
                case 3 :
                    $order = array('SheetRideDetailRides.real_start_date' => $orderType);
                    break;
                case 4 :
                    $order = array('SheetRideDetailRides.real_end_date' => $orderType);
                    break;

                default :
                    $order = array('SheetRideDetailRides.real_start_date' => $orderType);
            }
            return $order;
        } else {
            $order = array('SheetRideDetailRides.real_start_date' => $orderType);

            return $order;
        }
    }

    public function index()
    {
        $planification = $this->hasModulePlanification();
        if($planification==0){
            return $this->redirect('/');
        }
        $searchConditions ='';
        if ($this->request->is('post')) {

            if (
                isset($this->request->data['SheetRideDetailRide']['car_id']) ||
                isset($this->request->data['SheetRideDetailRide']['customer_id']) ||
                isset($this->request->data['SheetRideDetailRide']['car_type_id']) ||
                isset($this->request->data['SheetRideDetailRide']['ride_id']) ||
                isset($this->request->data['SheetRideDetailRide']['supplier_initial_id']) ||
                isset($this->request->data['SheetRideDetailRide']['status_id']) ||
                isset($this->request->data['SheetRideDetailRide']['supplier_id']) ||
                isset($this->request->data['SheetRideDetailRide']['order_type']) ||
                isset($this->request->data['SheetRideDetailRide']['start_date1']) ||
                isset($this->request->data['SheetRideDetailRide']['start_date2'])||
                isset($this->request->data['SheetRideDetailRide']['end_date1']) ||
                isset($this->request->data['SheetRideDetailRide']['end_date2'])||
                isset($this->request->data['SheetRideDetailRide']['user_id'])||
                isset($this->request->data['SheetRideDetailRide']['created'])||
                isset($this->request->data['SheetRideDetailRide']['created1'])||
                isset($this->request->data['SheetRideDetailRide']['modified_id'])||
                isset($this->request->data['SheetRideDetailRide']['modified'])||
                isset($this->request->data['SheetRideDetailRide']['modified1'])

            ) {
                if(isset($this->request->data['SheetRideDetailRide']['car_id'])) {
                    $car = $this->request->data['SheetRideDetailRide']['car_id'];
                }
                if(isset($this->request->data['SheetRideDetailRide']['customer_id'])){
                    $customer = $this->request->data['SheetRideDetailRide']['customer_id'];
                }

                if(isset($this->request->data['SheetRideDetailRide']['parc_id'])) {
                    $parc = $this->request->data['SheetRideDetailRide']['parc_id'];
                }
                if(isset($this->request->data['SheetRideDetailRide']['detail_ride_id'])){
                    $detailRide = $this->request->data['SheetRideDetailRide']['detail_ride_id'];
                }

                if(isset($this->request->data['SheetRideDetailRide']['supplier_initial_id'])) {
                    $supplier = $this->request->data['SheetRideDetailRide']['supplier_initial_id'];
                }
                if(isset($this->request->data['SheetRideDetailRide']['status_id'])){
                    $status = $this->request->data['SheetRideDetailRide']['status_id'];
                }
                if(isset($this->request->data['SheetRideDetailRide']['supplier_id'])){
                    $subcontractor = $this->request->data['SheetRideDetailRide']['supplier_id'];
                }
                if(isset($this->request->data['SheetRideDetailRide']['order_type'])){
                    $orderType = $this->request->data['SheetRideDetailRide']['order_type'];
                }
                if(isset($this->request->data['SheetRideDetailRide']['user_id'])){
                    $user = $this->request->data['SheetRideDetailRide']['user_id'];
                }
                if(isset($this->request->data['SheetRideDetailRide']['modified_id'])){
                    $modifier = $this->request->data['SheetRideDetailRide']['modified_id'];
                }
                $start_date_from = str_replace("/", "-", $this->request->data['SheetRideDetailRide']['start_date1']);
                $start_date_to = str_replace("/", "-", $this->request->data['SheetRideDetailRide']['start_date2']);
                $end_date_from = str_replace("/", "-", $this->request->data['SheetRideDetailRide']['end_date1']);
                $end_date_to = str_replace("/", "-", $this->request->data['SheetRideDetailRide']['end_date2']);
                if(isset($this->request->data['SheetRideDetailRide']['created'])) {
                    $created_from = str_replace("/", "-", $this->request->data['SheetRideDetailRide']['created']);
                }
                if(isset($this->request->data['SheetRideDetailRide']['created1'])) {
                    $created_to = str_replace("/", "-", $this->request->data['SheetRideDetailRide']['created1']);
                }
                if(isset($this->request->data['SheetRideDetailRide']['modified'])) {
                    $modified_from = str_replace("/", "-", $this->request->data['SheetRideDetailRide']['modified']);
                }
                if(isset($this->request->data['SheetRideDetailRide']['modified1'])) {
                    $modified_to = str_replace("/", "-", $this->request->data['SheetRideDetailRide']['modified1']);
                }
                if (!empty($car)) {
                    $searchConditions .= " && SheetRide.car_id = $car  ";
                }
                if (!empty($customer)) {
                    $searchConditions .= " && SheetRide.customer_id = $customer  ";
                }
                if (!empty($parc)) {
                    $searchConditions .= " && Car.parc_id = $parc  ";
                }

                if (!empty($detailRide)) {
                    $searchConditions .= " && SheetRideDetailRides.detail_ride_id  = $detailRide  ";
                }

                if (!empty($supplier)) {
                    $searchConditions .= " && SheetRideDetailRides.supplier_id = $supplier  ";
                }

                if (!empty($subcontractor)) {
                    $searchConditions .= " && SheetRide.supplier_id = $subcontractor  ";
                }
                if (!empty($orderType)) {
                    $searchConditions .= " && TransportBill.order_type = $orderType  ";
                }

                if (!empty($status)) {
                    $searchConditions .= " && SheetRideDetailRides.status_id = $status  ";
                }

                if (isset($user)&& !empty($user)) {
                    $searchConditions .= " && SheetRideDetailRides.user_id = $user  ";
                }
                if (isset($modifier)&& !empty($modifier)) {
                    $searchConditions .= " && SheetRideDetailRides.modified_id = $modifier  ";
                }
                if (isset($start_date_from)&& !empty($start_date_from)) {
                    $start = str_replace("-", "/", $start_date_from);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $startdtm = $startdtm->format('Y-m-d 00:00:00');
                    $searchConditions .= " && SheetRideDetailRides.start_date >= '$startdtm' ";
                }
                if (isset($start_date_to)&& !empty($start_date_to)) {
                    $end = str_replace("-", "/", $start_date_to);
                    $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                    $enddtm = $enddtm->format('Y-m-d 23:59:00');
                    $searchConditions .= " && SheetRideDetailRides.start_date <= '$enddtm' ";
                }

                if (isset($end_date_from)&& !empty($end_date_from)) {
                    $start = str_replace("-", "/", $end_date_from);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $startdtm = $startdtm->format('Y-m-d 00:00:00');
                    $searchConditions .= " && SheetRideDetailRides.end_date >= '$startdtm' ";
                }
                if (isset($end_date_to)&& !empty($end_date_to)) {
                    $end = str_replace("-", "/", $end_date_to);
                    $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                    $enddtm = $enddtm->format('Y-m-d 23:59:00');
                    $searchConditions .= " && SheetRideDetailRides.end_date <= '$enddtm' ";
                }
                if (isset($created_from)&& !empty($created_from)) {
                    $start = str_replace("-", "/", $created_from);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $startdtm = $startdtm->format('Y-m-d 00:00:00');
                    $searchConditions .= " && SheetRideDetailRides.created >= '$startdtm' ";
                }
                if (isset($created_to)&& !empty($created_to)) {
                    $end = str_replace("-", "/", $created_to);
                    $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                    $enddtm = $enddtm->format('Y-m-d 23:59:00');
                    $searchConditions .= " && SheetRideDetailRides.created <= '$enddtm' ";
                }
                if (isset($modified_from)&&  !empty($modified_from)) {
                    $start = str_replace("-", "/", $modified_from);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $startdtm = $startdtm->format('Y-m-d 00:00:00');
                    $searchConditions .= " && SheetRideDetailRides.modified >= '$startdtm' ";
                }
                if (isset($modified_to)&&  !empty($modified_to)) {
                    $end = str_replace("-", "/", $modified_to);
                    $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                    $enddtm = $enddtm->format('Y-m-d 23:59:00');
                    $searchConditions .= " && SheetRideDetailRides.modified <= '$enddtm' ";
                }


            }
        }else {
            $searchConditions = '';
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::mission, $user_id, ActionsEnum::view,
            "SheetRideDetailRides", null, "SheetRideDetailRide", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();
        switch ($result) {
            case 1 :
                $conditions = null;
                break;
            case 2 :
                $conditions = array('SheetRide.user_id ' => $user_id);

                break;
            case 3 :
                $conditions = array('SheetRide.user_id !=' => $user_id);
                break;

            default:
                $conditions = null;
        }
        $query['count'] = " SELECT COUNT(*) AS `count` FROM  `sheet_ride_detail_rides` AS `SheetRideDetailRides` 
	                        left JOIN `sheet_rides` AS `SheetRide` ON (`SheetRide`.`id` = `SheetRideDetailRides`.`sheet_ride_id`) 
	                        left JOIN `car` AS `Car` ON (`SheetRide`.`car_id` = `Car`.`id`) 
	                        left JOIN `detail_rides` AS `DetailRide` ON (`SheetRideDetailRides`.`detail_ride_id` = `DetailRide`.`id`) 
	                        left JOIN `car_types` AS `CarType` ON (`DetailRide`.`car_type_id` = `CarType`.`id`) 
	                        left JOIN `rides` AS `Ride` ON (`DetailRide`.`ride_id` = `Ride`.`id`) 
	                        left JOIN `destinations` AS `DepartureDestination` ON (`DepartureDestination`.`id` = `Ride`.`departure_destination_id`) 
	                        left JOIN `destinations` AS `ArrivalDestination` ON (`ArrivalDestination`.`id` = `Ride`.`arrival_destination_id`) 
	                        left JOIN `destinations` AS `Departure` ON (`Departure`.`id` = `SheetRideDetailRides`.`departure_destination_id`) 
	                        left JOIN `destinations` AS `Arrival` ON (`Arrival`.`id` = `SheetRideDetailRides`.`arrival_destination_id`) 
	                        left JOIN `reservations` AS `Reservation` ON (`SheetRideDetailRides`.`id` = `Reservation`.`sheet_ride_detail_ride_id`) 
	                      
	                        left JOIN `customers` AS `Customer` ON (`SheetRide`.`customer_id` = `Customer`.`id`) 
	                        left JOIN `suppliers` AS `Supplier` ON (`SheetRide`.`supplier_id` = `Supplier`.`id`) 
	                        left JOIN `suppliers` AS `SupplierInitial` ON (`SheetRideDetailRides`.`supplier_id` = `SupplierInitial`.`id`) 
	                        left JOIN `suppliers` AS `SupplierFinal` ON (`SheetRideDetailRides`.`supplier_final_id` = `SupplierFinal`.`id`) 
	                        left JOIN `carmodels` AS `Carmodel` ON (`Car`.`carmodel_id` = `Carmodel`.`id`) 
	                        left JOIN `cancel_causes` AS `CancelCause` ON (`SheetRideDetailRides`.`cancel_cause_id` = `CancelCause`.`id`) 
	                        left JOIN `transport_bill_detail_rides` AS `TransportBillDetailRides` ON (`SheetRideDetailRides`.`transport_bill_detail_ride_id` = `TransportBillDetailRides`.`id`) 
	                        left JOIN `transport_bill_detailed_rides` AS `TransportBillDetailedRides` ON (`SheetRide`.`id` = `TransportBillDetailedRides`.`sheet_ride_id`)
	                        left JOIN `transport_bills` AS `TransportBill` ON (`TransportBillDetailRides`.`transport_bill_id` = `TransportBill`.`id`) 
	                         left JOIN `users` AS `User` ON (`TransportBillDetailRides`.`user_id` = `User`.`id`) 
	                      
	                        WHERE 1 = 1 " ;

        $query['detail'] = "SELECT `SheetRideDetailRides`.`reference`, `SheetRideDetailRides`.`id`, `SheetRideDetailRides`.`type_ride`, 
                             `SheetRide`.`car_id`,`SheetRide`.`car_name`,`SheetRide`.`car_subcontracting`,  `SheetRide`.`customer_id`,`SheetRide`.`customer_name`,
	                        `SheetRideDetailRides`.`planned_start_date`, `SheetRideDetailRides`.`real_start_date`, `SheetRideDetailRides`.`km_departure`, 
	                        `SheetRideDetailRides`.`planned_end_date`, `SheetRideDetailRides`.`real_end_date`, `SheetRideDetailRides`.`km_arrival`, 
	                        `SheetRideDetailRides`.`status_id`, `SheetRideDetailRides`.`mission_cost`,
	                        `CancelCause`.`name`,   `Reservation`.`cost`,CONCAT(`User`.`first_name`,' - ',`User`.`last_name`) as user_full_name,
	                        `CarType`.`name`,`TransportBill`.`order_type`,`TransportBillDetailRides`.`observation_order`,`TransportBillDetailRides`.`unit_price`, 
	                        `Supplier`.`name`,`SupplierInitial`.`name`, `SupplierFinal`.`name`, `DepartureDestination`.`name`, `ArrivalDestination`.`name`, `Departure`.`name`, `Arrival`.`name`, 
	                        `Car`.`code`, `Customer`.`first_name`, `Customer`.`last_name`, `Car`.`immatr_def`, `Carmodel`.`name`, 
	                        `SheetRideDetailRides`.`amount_remaining` , CONCAT(`Customer`.`first_name`,' - ', `Customer`.`last_name`) as full_name,
                            CONCAT(`Car`.`code` ,' - ', `Carmodel`.`name`) as car_name,
                            `TransportBill`.`order_type`,`TransportBillDetailedRides`.`delivery_with_return`,
                            `TransportBillDetailedRides`.`programming_date`,`TransportBillDetailedRides`.`charging_time`,
                            `TransportBillDetailedRides`.`unloading_date`
	                        FROM  `sheet_ride_detail_rides` AS `SheetRideDetailRides` 
	                        left JOIN `sheet_rides` AS `SheetRide` ON (`SheetRide`.`id` = `SheetRideDetailRides`.`sheet_ride_id`) 
	                        left JOIN `car` AS `Car` ON (`SheetRide`.`car_id` = `Car`.`id`) 
	                        left JOIN `suppliers` AS `Supplier` ON (`SheetRide`.`supplier_id` = `Supplier`.`id`) 
	                        left JOIN `detail_rides` AS `DetailRide` ON (`SheetRideDetailRides`.`detail_ride_id` = `DetailRide`.`id`) 
	                        left JOIN `car_types` AS `CarType` ON (`DetailRide`.`car_type_id` = `CarType`.`id`) 
	                        left JOIN `rides` AS `Ride` ON (`DetailRide`.`ride_id` = `Ride`.`id`) 
	                        left JOIN `destinations` AS `DepartureDestination` ON (`DepartureDestination`.`id` = `Ride`.`departure_destination_id`) 
	                        left JOIN `destinations` AS `ArrivalDestination` ON (`ArrivalDestination`.`id` = `Ride`.`arrival_destination_id`) 
	                        left JOIN `destinations` AS `Departure` ON (`Departure`.`id` = `SheetRideDetailRides`.`departure_destination_id`) 
	                        left JOIN `destinations` AS `Arrival` ON (`Arrival`.`id` = `SheetRideDetailRides`.`arrival_destination_id`) 
	                        left JOIN `customers` AS `Customer` ON (`SheetRide`.`customer_id` = `Customer`.`id`) 
	                        left JOIN `suppliers` AS `SupplierInitial` ON (`SheetRideDetailRides`.`supplier_id` = `SupplierInitial`.`id`) 
	                        left JOIN `suppliers` AS `SupplierFinal` ON (`SheetRideDetailRides`.`supplier_final_id` = `SupplierFinal`.`id`) 
	                        left JOIN `reservations` AS `Reservation` ON (`SheetRideDetailRides`.`id` = `Reservation`.`sheet_ride_detail_ride_id`) 
	                        left JOIN `carmodels` AS `Carmodel` ON (`Car`.`carmodel_id` = `Carmodel`.`id`) 
	                        left JOIN `cancel_causes` AS `CancelCause` ON (`SheetRideDetailRides`.`cancel_cause_id` = `CancelCause`.`id`) 
	                        left JOIN `transport_bill_detail_rides` AS `TransportBillDetailRides` ON (`SheetRideDetailRides`.`transport_bill_detail_ride_id` = `TransportBillDetailRides`.`id`) 
	                        left JOIN `transport_bill_detailed_rides` AS `TransportBillDetailedRides` ON (`SheetRide`.`id` = `TransportBillDetailedRides`.`sheet_ride_id`) 
	                        left JOIN `transport_bills` AS `TransportBill` ON (`TransportBillDetailRides`.`transport_bill_id` = `TransportBill`.`id`) 
	                        left JOIN `users` AS `User` ON (`TransportBill`.`user_id` = `User`.`id`) 
	                      
	                        WHERE 1 = 1 " ;

        if(!empty($conditions)){
            $query['conditions'] = '&& '.$conditions.$searchConditions;
        }else {
            $query['conditions'] = $conditions.$searchConditions;
        }
        $query['columns'] = array(

            0 => array('User.first_name','0', 'user_full_name','User', 'string','CONCAT', 'User.first_name','User.last_name'),
            1 => array('SheetRideDetailRides.reference','SheetRideDetailRides', 'reference', 'Reference', 'string',''),
            2 => array('DepartureDestination.name','0', 'trajet',  'Ride', 'string','CONCAT','DepartureDestination.name','ArrivalDestination.name'),
            3 => array('Carmodel.name','0', 'car_name',  'Car', 'string','CONCAT','Carmodel.name','Car.code', 'SheetRide.car_name', 'SheetRide.car_name'),
            4 => array('Customer.first_name','0', 'full_name','Customer', 'string','CONCAT', 'Customer.first_name','Customer.last_name', 'SheetRide.customer_name', 'SheetRide.customer_name'),
            5 => array('TransportBillDetailedRides.delivery_with_return','TransportBillDetailedRides', 'delivery_with_return', 'Mission type', 'string',''),
            6 => array('TransportBill.order_type','TransportBill', 'order_type', 'Order Type', 'string',''),
            7 => array('Supplier.name','Supplier', 'name',  'Supplier', 'string',''),
            8 => array('SupplierInitial.name','SupplierInitial', 'name', 'Initial customer', 'string',''),
            9 => array('SheetRideDetailRides.real_start_date','SheetRideDetailRides', 'real_start_date', 'Real Departure date', 'datetime',''),
            10=> array('SheetRideDetailRides.real_end_date','SheetRideDetailRides', 'real_end_date', 'Real Arrival date', 'datetime',''),
            11=> array('TransportBillDetailRides.unit_price','TransportBillDetailRides', 'unit_price', 'Unit price', 'number',''),
            12 => array('Reservation.cost','Reservation', 'cost', 'Subcontractor cost', 'number',''),
            13 => array('TransportBillDetailRides.observation_order','TransportBillDetailRides', 'observation_order', 'Observation', 'string',''),
            14 => array('TransportBillDetailedRides.programming_date','TransportBillDetailedRides', 'programming_date', __('Charging date').' / '.__('Unloading date'), 'string','50px'),
            15 => array('SheetRideDetailRides.status_id','SheetRideDetailRides', 'status_id', 'Status', 'number',''),


        );
        $query['order'] = ' SheetRideDetailRides.id desc';
        $query['group'] = ' SheetRideDetailRides.id ';
        $query['tableName'] = 'SheetRideDetailRides';
        $query['entityName'] = 'SheetRideDetailRides';
        $query['controller'] = 'sheetRideDetailRides';
        $query['action'] = 'index';
        $query['itemName'] = array('reference');
        $this->Session->write('query', $query);
        //get default user limit value
        $defaultLimit =  $this->getLimit();
        if (isset($defaultLimit) && $defaultLimit > 0) {
            $this->set('defaultLimit', $defaultLimit);
        } else {
            $this->set('defaultLimit', 20);
        }

        $sumMissionCost = $this->getSumMissionCost($conditions);
        $sumAmountRemaining = $this->getSumAmountRemaining($conditions);
        //Get the structure of the car name from parameters
        $this->set(compact('limit', 'sumMissionCost', 'sumAmountRemaining', 'order'));
        $users = $this->SheetRide->User->find('list', array('conditions' => 'User.id != 1'));
        $profiles = $this->Profile->getUserProfiles();
        $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
        $subcontractors = $this->Supplier->getSuppliersByParams(0, 1,SupplierCategoriesEnum::SUBCONTRACTOR);
        $separatorAmount = $this->getSeparatorAmount();
        $client_i2b = $this->isCustomerI2B();
        $settleMissions = $this->abilityToSettleMissions();
        $isSuperAdmin = $this->isSuperAdmin();
        $parcs = $this->Parc->getParcs('list');
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $controller =  'sheetRideDetailRides';
        $action = 'index';
        $deleteFonction =  'deleteSheetRideDetailRides';
        $isAgent = $this->isAgent();
        $this->set(compact('profiles', 'users', 'suppliers','subcontractors',
            'parcs', 'param','deleteFonction', 'separatorAmount', 'client_i2b',
            'settleMissions','isSuperAdmin' ,'controller','action','isAgent'));

    }

    public function view_mission($id)
    {

        $planification = $this->hasModulePlanification();
        if($planification==0){
            return $this->redirect('/');
        }
        $this->setTimeActif();
        ini_set('memory_limit', '1024M');
        if (!$this->SheetRideDetailRides->exists($id)) {
            throw new NotFoundException(__('Invalid sheet ride'));
        }

        $sheetRideDetailRide = $this->SheetRideDetailRides->find('first', array(
            'recursive' => -1,
            'conditions' => array('SheetRideDetailRides.' . $this->SheetRideDetailRides->primaryKey => $id),
            'fields' => array(

                'SheetRideDetailRides.id',
                'SheetRide.id',
                'SheetRide.car_subcontracting',
                'SheetRide.car_name',
                'SheetRide.remorque_name',
                'SheetRide.customer_name',
                'SheetRide.reference',
                'SheetRide.created',
                'SheetRideDetailRides.reference',
                'SheetRideDetailRides.type_ride',
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
                'CarTypeRemorque.name',
                'CarTypeRemorque.display_model_mission_order',
                'Supplier.name',
                'SupplierFinal.name',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Departure.name',
                'Arrival.name',
                'Car.code',
                'Customer.first_name',
                'Customer.last_name',
                'Car.immatr_def',
                'Carmodel.name',
                'Mark.name',
                'CarmodelRemorque.name',
                'Customer.image',
                'Customer.tel',
                'CustomerCategory.name',
                'Remorque.immatr_def',
                'TransportBillDetailRides.designation',
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
                    'table' => 'marks',
                    'type' => 'left',
                    'alias' => 'Mark',
                    'conditions' => array('Car.mark_id = Mark.id')
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
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarTypeRemorque',
                    'conditions' => array('Remorque.car_type_id = CarTypeRemorque.id')
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
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Departure',
                    'conditions' => array('Departure.id = SheetRideDetailRides.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Arrival',
                    'conditions' => array('Arrival.id = SheetRideDetailRides.arrival_destination_id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('SheetRide.customer_id = Customer.id')
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
                array(
                    'table' => 'transport_bill_detail_rides',
                    'type' => 'left',
                    'alias' => 'TransportBillDetailRides',
                    'conditions' => array('SheetRideDetailRides.transport_bill_detail_ride_id = TransportBillDetailRides.id')
                ),


            )

        ));
        /*$remorque=$this->SheetRide->Car->find('first',array('recursive'=>1,
        'conditions'=>array('Car.id'=>$sheetRide['SheetRide']['remorque_id'])));
           $this->set('remorque',$remorque);
        */

        $conveyors=$this->SheetRideConveyor->find('all',array(
            'recursive'=>-1,
            'conditions'=>array('SheetRideConveyor.sheet_ride_id'=>$sheetRideDetailRide['SheetRide']['id']),
            'joins'=>array(
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Customer.id = SheetRideConveyor.conveyor_id')
                )
            ),
            'fields'=>array('Customer.first_name','Customer.last_name')
        ));

        $this->set('conveyors',$conveyors);
        $this->set('sheetRideDetailRide', $sheetRideDetailRide);

        $company = $this->Company->find('first');
        $wilayaId = $company['Company']['wilaya'];
        $destination = $this->Destination->find('first', array('conditions' => array('Destination.id' => $wilayaId)));
        $wilayaName = $destination['Destination']['name'];

        $this->set(compact('company', 'wilayaName'));
        // get method of header pdf
        $entete_pdf = $this->Parameter->getCodesParameterVal('entete_pdf');
        // get signature of mission order
        $signature_mission_order = $this->Parameter->getCodesParameterVal('signature_mission_order');
        $missionOrderModel = $this->Parameter->getCodesParameterVal('mission_order_model');

        $this->set(compact('signature_mission_order', 'entete_pdf','missionOrderModel'));

    }


    public function search()
    {

        $planification = $this->hasModulePlanification();
        if($planification==0){
            return $this->redirect('/');
        }
        $this->setTimeActif();

        if (isset($this->request->data['keyword']) || isset($this->request->data['SheetRideDetailRide']['user_id']) ||
            isset($this->request->data['SheetRideDetailRide']['modified_id']) || isset($this->request->data['SheetRideDetailRide']['status_id'])
            || isset($this->request->data['SheetRideDetailRide']['created']) || isset($this->request->data['SheetRideDetailRide']['created1'])
            || isset($this->request->data['SheetRideDetailRide']['modified']) || isset($this->request->data['SheetRideDetailRide']['modified1'])
            || isset($this->request->data['SheetRideDetailRide']['ride_id']) || isset($this->request->data['SheetRideDetailRide']['ride_id']) || isset($this->request->data['SheetRideDetailRide']['car_id']) || isset($this->request->data['SheetRideDetailRide']['customer_id']) || isset($this->request->data['SheetRideDetailRide']['start_date1']) || isset($this->request->data['SheetRideDetailRide']['start_date2']) || isset($this->request->data['SheetRideDetailRide']['end_date1']) || isset($this->request->data['SheetRideDetailRide']['end_date2'])
            || isset($this->request->data['SheetRideDetailRide']['car_type_id']) || isset($this->request->data['SheetRideDetailRide']['profile_id'])
            || isset($this->request->data['SheetRideDetailRide']['supplier_id'])
        ) {
            $this->filterUrl();
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'], $this->params['pass']['2']) : $this->getOrder();
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('TransportBill.reference' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword']) || isset($this->params['named']['user']) || isset($this->params['named']['status'])
            || isset($this->params['named']['created']) || isset($this->params['named']['created1'])
            || isset($this->params['named']['ride']) || isset($this->params['named']['modified_id'])
            || isset($this->params['named']['supplier']) || isset($this->params['named']['car_type']) || isset($this->params['named']['profile'])
            || isset($this->params['named']['modified']) || isset($this->params['named']['modified1'])
            || isset($this->params['named']['start_date1']) || isset($this->params['named']['start_date2'])
            || isset($this->params['named']['end_date1']) || isset($this->params['named']['end_date2'])
        ) {

            $conditions = $this->getConds();


            $this->paginate = array(
                'paramType' => 'querystring',
                'recursive' => -1, // should be used with joins
                'limit' => $limit,
                'order' => $order,
                'conditions' => $conditions,
                'fields' => array(
                    'SheetRideDetailRides.reference',
                    'SheetRideDetailRides.id',
                    'SheetRideDetailRides.from_customer_order',
                    'SheetRideDetailRides.detail_ride_id',
                    'SheetRideDetailRides.planned_start_date',
                    'SheetRideDetailRides.real_start_date',
                    'SheetRideDetailRides.km_departure',
                    'SheetRideDetailRides.planned_end_date',
                    'SheetRideDetailRides.real_end_date',
                    'SheetRideDetailRides.km_arrival',
                    'SheetRideDetailRides.supplier_id',
                    'SheetRideDetailRides.supplier_final_id',
                    'SheetRideDetailRides.mission_cost',
                    'SheetRideDetailRides.status_id',
                    'SheetRide.car_id',
                    'SheetRide.customer_id',
                    'CarType.name',
                    'Supplier.name',
                    'SupplierFinal.name',
                    'DepartureDestination.name',
                    'ArrivalDestination.name',
                    'Departure.name',
                    'Arrival.name',
                    'Car.code',
                    'Customer.first_name',
                    'Customer.last_name',
                    'Car.immatr_def',
                    'Carmodel.name',
                    'SheetRideDetailRides.amount_remaining'

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
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'Departure',
                        'conditions' => array('Departure.id = SheetRideDetailRides.departure_destination_id')
                    ),
                    array(
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'Arrival',
                        'conditions' => array('Arrival.id = SheetRideDetailRides.arrival_destination_id')
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
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('SheetRide.user_id = User.id')
                    ),
                )
            );

            $sumMissionCost = $this->getSumMissionCost($conditions);
            $sumAmountRemaining = $this->getSumAmountRemaining($conditions);
            $this->set(compact('sumMissionCost', 'sumAmountRemaining'));
            $sheetRideDetailRides = $this->Paginator->paginate('SheetRideDetailRides');
            $this->set('sheetRideDetailRides', $sheetRideDetailRides);
            $users = $this->User->find('list', array('conditions' => 'User.id != 1'));
            $profiles = $this->Profile->getUserProfiles();
            $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
            $this->SheetRideDetailRides->DetailRide->Ride->virtualFields = array(
                'cnames' => "CONCAT(DepartureDestination.name, ' - ', ArrivalDestination.name)"
            );
            $rides = $this->SheetRideDetailRides->DetailRide->Ride->find('list', array(
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
            $param = $this->Parameter->getCodesParameterVal('name_car');

            if ($param == 1) {
                $this->SheetRide->Car->virtualFields = array(
                    'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name )"
                );

            } elseif ($param == 2) {

                $this->SheetRide->Car->virtualFields = array(
                    'cnames' => "CONCAT(IFNULL(Car.immatr_def,Car.immatr_prov), ' - ', Carmodel.name)"
                );
            }
            $cars = $this->SheetRideDetailRides->SheetRide->Car->find('list', array(
                'fields' => 'cnames',
                'recursive' => -1,
                'order' => 'Car.code ASC',
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

            $fields = "names";
            $customers = $this->Customer->getCustomersByFieldsAndConds($fields);
            $separatorAmount = $this->getSeparatorAmount();
            $client_i2b = $this->isCustomerI2B();
            $isSuperAdmin = $this->isSuperAdmin();
            $this->set(compact('profiles', 'users', 'suppliers', 'rides', 'carTypes', 'cars', 'customers', 'param',
                    'separatorAmount','isSuperAdmin','limit', 'type', 'client_i2b'));
            $this->render();
        }

    }


    private function filterUrl()
    {

        $filter_url['controller'] = $this->request->params['controller'];
        $filter_url['action'] = $this->request->params['action'];
        $filter_url['page'] = 1;
        $filter_url['keyword'] = $this->request->data['keyword'];
        $filter_url['keyword'] = str_replace('/', '-', $filter_url['keyword']);

        if (isset($this->request->data['sheet_ride_detail_rides']['status_id']) && !empty($this->request->data['sheet_ride_detail_rides']['status_id'])) {
            $filter_url['status'] = $this->request->data['sheet_ride_detail_rides']['status_id'];
        }
        if (isset($this->request->data['sheet_ride_detail_rides']['car_id']) && !empty($this->request->data['sheet_ride_detail_rides']['car_id'])) {
            $filter_url['car'] = $this->request->data['sheet_ride_detail_rides']['car_id'];
        }

        if (isset($this->request->data['sheet_ride_detail_rides']['customer_id']) && !empty($this->request->data['sheet_ride_detail_rides']['customer_id'])) {
            $filter_url['customer'] = $this->request->data['sheet_ride_detail_rides']['customer_id'];
        }

        if (isset($this->request->data['sheet_ride_detail_rides']['supplier_id']) && !empty($this->request->data['sheet_ride_detail_rides']['supplier_id'])) {
            $filter_url['supplier'] = $this->request->data['sheet_ride_detail_rides']['supplier_id'];
        }

        if (isset($this->request->data['sheet_ride_detail_rides']['subcontractor_id']) && !empty($this->request->data['sheet_ride_detail_rides']['subcontractor_id'])) {
            $filter_url['subcontractor'] = $this->request->data['sheet_ride_detail_rides']['subcontractor_id'];
        }

        if (isset($this->request->data['sheet_ride_detail_rides']['order_type']) && !empty($this->request->data['sheet_ride_detail_rides']['order_type'])) {
            $filter_url['order_type'] = $this->request->data['sheet_ride_detail_rides']['order_type'];
        }

        if (isset($this->request->data['sheet_ride_detail_rides']['car_type_id']) && !empty($this->request->data['sheet_ride_detail_rides']['car_type_id'])) {
            $filter_url['car_type'] = $this->request->data['sheet_ride_detail_rides']['car_type_id'];
        }
        if (isset($this->request->data['sheet_ride_detail_rides']['ride_id']) && !empty($this->request->data['sheet_ride_detail_rides']['ride_id'])) {
            $filter_url['ride'] = $this->request->data['sheet_ride_detail_rides']['ride_id'];
        }

        if (isset($this->request->data['sheet_ride_detail_rides']['detail_ride_id']) && !empty($this->request->data['sheet_ride_detail_rides']['detail_ride_id'])) {
            $filter_url['detail_ride'] = $this->request->data['sheet_ride_detail_rides']['detail_ride_id'];
        }
        if (isset($this->request->data['sheet_ride_detail_rides']['user_id']) && !empty($this->request->data['sheet_ride_detail_rides']['user_id'])) {
            $filter_url['user'] = $this->request->data['sheet_ride_detail_rides']['user_id'];
        }
        if (isset($this->request->data['sheet_ride_detail_rides']['profile_id']) && !empty($this->request->data['sheet_ride_detail_rides']['profile_id'])) {
            $filter_url['profile'] = $this->request->data['sheet_ride_detail_rides']['profile_id'];
        }
        if (isset($this->request->data['sheet_ride_detail_rides']['created']) && !empty($this->request->data['sheet_ride_detail_rides']['created'])) {
            $filter_url['created'] = str_replace("/", "-", $this->request->data['sheet_ride_detail_rides']['created']);
        }
        if (isset($this->request->data['sheet_ride_detail_rides']['created1']) && !empty($this->request->data['sheet_ride_detail_rides']['created1'])) {
            $filter_url['created1'] = str_replace("/", "-", $this->request->data['sheet_ride_detail_rides']['created1']);
        }
        if (isset($this->request->data['sheet_ride_detail_rides']['modified_id']) && !empty($this->request->data['sheet_ride_detail_rides']['modified_id'])) {
            $filter_url['modified_id'] = $this->request->data['sheet_ride_detail_rides']['modified_id'];
        }
        if (isset($this->request->data['sheet_ride_detail_rides']['modified']) && !empty($this->request->data['sheet_ride_detail_rides']['modified'])) {
            $filter_url['modified'] = str_replace("/", "-", $this->request->data['sheet_ride_detail_rides']['modified']);
        }
        if (isset($this->request->data['sheet_ride_detail_rides']['modified1']) && !empty($this->request->data['sheet_ride_detail_rides']['modified1'])) {
            $filter_url['modified1'] = str_replace("/", "-", $this->request->data['sheet_ride_detail_rides']['modified1']);
        }
        if (isset($this->request->data['sheet_ride_detail_rides']['start_date1']) && !empty($this->request->data['sheet_ride_detail_rides']['start_date1'])) {
            $filter_url['start_date1'] = str_replace("/", "-",
                $this->request->data['sheet_ride_detail_rides']['start_date1']);
        }
        if (isset($this->request->data['sheet_ride_detail_rides']['start_date2']) && !empty($this->request->data['sheet_ride_detail_rides']['start_date2'])) {
            $filter_url['start_date2'] = str_replace("/", "-",
                $this->request->data['sheet_ride_detail_rides']['start_date2']);
        }
        if (isset($this->request->data['sheet_ride_detail_rides']['end_date1']) && !empty($this->request->data['sheet_ride_detail_rides']['end_date1'])) {
            $filter_url['end_date1'] = str_replace("/", "-", $this->request->data['sheet_ride_detail_rides']['end_date1']);
        }
        if (isset($this->request->data['sheet_ride_detail_rides']['end_date2']) && !empty($this->request->data['sheet_ride_detail_rides']['end_date2'])) {
            $filter_url['end_date2'] = str_replace("/", "-", $this->request->data['sheet_ride_detail_rides']['end_date2']);
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
                    "LOWER(SheetRideDetailRides.reference) LIKE" => "%$keyword%"
                )
            );
        } else {
            $conds = array();
        }
        if (isset($this->params['named']['status']) && !empty($this->params['named']['status'])) {
            $conds["SheetRideDetailRides.status_id = "] = $this->params['named']['status'];


            $this->request->data['SheetRideDetailRide']['status_id'] = $this->params['named']['status'];
        }

        if (isset($this->params['named']['ride']) && !empty($this->params['named']['ride'])) {
            $conds["DetailRide.ride_id = "] = $this->params['named']['ride'];


            $this->request->data['SheetRideDetailRide']['ride_id'] = $this->params['named']['ride'];
        }


        if (isset($this->params['named']['car']) && !empty($this->params['named']['car'])) {
            $conds["SheetRide.car_id = "] = $this->params['named']['car'];


            $this->request->data['SheetRideDetailRide']['car_id'] = $this->params['named']['car'];
        }

        if (isset($this->params['named']['customer']) && !empty($this->params['named']['customer'])) {
            $conds["SheetRide.customer_id = "] = $this->params['named']['customer'];


            $this->request->data['SheetRideDetailRide']['customer_id'] = $this->params['named']['customer'];
        }

        if (isset($this->params['named']['supplier']) && !empty($this->params['named']['supplier'])) {
            $conds["SheetRideDetailRides.supplier_id = "] = $this->params['named']['supplier'];
            $this->request->data['SheetRideDetailRide']['supplier_id'] = $this->params['named']['supplier'];
        }

        if (isset($this->params['named']['car_type']) && !empty($this->params['named']['car_type'])) {
            $conds["DetailRide.car_type_id = "] = $this->params['named']['car_type'];
            $this->request->data['SheetRideDetailRide']['car_type_id'] = $this->params['named']['car_type'];
        }


        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $conds["SheetRide.user_id = "] = $this->params['named']['user'];
            $this->request->data['SheetRideDetailRide']['user_id'] = $this->params['named']['user'];
        }

        if (isset($this->params['named']['profile']) && !empty($this->params['named']['profile'])) {
            $conds["User.profile_id = "] = $this->params['named']['profile'];
            $this->request->data['SheetRideDetailRide']['profile_id'] = $this->params['named']['profile'];
        }


        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $creat = str_replace("-", "/", $this->params['named']['created']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRideDetailRides.created >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['SheetRideDetailRide']['created'] = $creat;
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $creat = str_replace("-", "/", $this->params['named']['created1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRideDetailRides.created <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['SheetRideDetailRide']['created1'] = $creat;
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $conds["SheetRideDetailRides.modified_id = "] = $this->params['named']['modified_id'];
            $this->request->data['SheetRideDetailRide']['modified_id'] = $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRideDetailRides.modified >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['SheetRideDetailRide']['modified'] = $creat;
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRideDetailRides.modified <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['SheetRideDetailRide']['modified1'] = $creat;
        }

        if (isset($this->params['named']['start_date1']) && !empty($this->params['named']['start_date1'])) {
            $creat = str_replace("-", "/", $this->params['named']['start_date1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRideDetailRides.real_start_date  >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['SheetRideDetailRide']['start_date1'] = $creat;
        }
        if (isset($this->params['named']['start_date2']) && !empty($this->params['named']['start_date2'])) {
            $creat = str_replace("-", "/", $this->params['named']['start_date2']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRideDetailRides.real_start_date  <= "] = $startdtm->format('Y-m-d 23:59:00');
            $this->request->data['SheetRideDetailRide']['start_date2'] = $creat;
        }

        if (isset($this->params['named']['end_date1']) && !empty($this->params['named']['end_date1'])) {
            $creat = str_replace("-", "/", $this->params['named']['end_date1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRideDetailRides.real_end_date  >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['SheetRideDetailRide']['end_date1'] = $creat;
        }
        if (isset($this->params['named']['end_date2']) && !empty($this->params['named']['end_date2'])) {
            $creat = str_replace("-", "/", $this->params['named']['end_date2']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRideDetailRides.real_end_date  <= "] = $startdtm->format('Y-m-d 23:59:00');
            $this->request->data['SheetRideDetailRide']['end_date2'] = $creat;
        }


        return $conds;
    }

    public function getSumMissionCost($conditions = null)
    {

        $sheetRideDetailRides = $this->SheetRideDetailRides->find('all',
            array(

                'recursive' => -1, // should be used with joins

                'conditions' => $conditions,
                'fields' => array(

                    'sum(SheetRideDetailRides.mission_cost) AS total',

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
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('SheetRide.user_id = User.id')
                    ),


                )

            )
        );

        $sumMissionCost = $sheetRideDetailRides[0][0]['total'];
        return $sumMissionCost;

    }

    public function getSumAmountRemaining($conditions = null)
    {

        $sheetRideDetailRides = $this->SheetRideDetailRides->find('all',
            array(

                'recursive' => -1, // should be used with joins

                'conditions' => $conditions,
                'fields' => array(
                    'sum(SheetRideDetailRides.amount_remaining) AS total',
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
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('SheetRide.user_id = User.id')
                    ),

                )

            )
        );

        $sumAmountRemaining = $sheetRideDetailRides[0][0]['total'];
        return $sumAmountRemaining;

    }

    public function add($sheetRideId = null)
    {
        // Verify accessibility to planification module
        $planification = $this->hasModulePlanification();
        if(Configure::read("transport_personnel") == '1'){
            $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validateWithoutCommercial;
        }else {
            if (Configure::read("gestion_commercial") == '1' ) {
                $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validate;
            }else {
                $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validatePersonalizedRide;
            }
        }

        if ($planification == 0) {
            $this->redirect('/');
        }

        $this->setTimeActif();
        date_default_timezone_set("Africa/Algiers");
        $user_id = $this->Auth->user('id');
        // Verify access rights for user's profile : add sheeet ride
        $this->verifyUserPermission(SectionsEnum::mission, $user_id, ActionsEnum::add,
            "SheetRideDetailRides", null, "SheetRideDetailRides", null);

        // Get reference mission automatic parameter reference_mi_auto
        $isReferenceMissionAutomatic = $this->Parameter->getCodesParameterVal('reference_mi_auto');
        $this->set('isReferenceMissionAutomatic', $isReferenceMissionAutomatic);
        //Verify if we have single or multiple choices in consumption
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));

                $this->redirect(array('controller'=>'SheetRides','action' => 'index'));
            }


            $this->createDatetimeFromDatetime('SheetRideDetailRides', 'planned_start_date');
            $this->createDatetimeFromDatetime('SheetRideDetailRides', 'real_start_date');
            $this->createDatetimeFromDatetime('SheetRideDetailRides', 'planned_end_date');
            $this->createDatetimeFromDatetime('SheetRideDetailRides', 'real_end_date');
            $this->request->data['SheetRideDetailRides']['user_id'] = $this->Session->read('Auth.User.id');
            $sheetRide = $this->SheetRide->find('first', array('conditions' => array('SheetRide.id' => $sheetRideId)));
            $reference = $sheetRide['SheetRide']['reference'];
            $carId = $sheetRide['SheetRide']['car_id'];
                if (isset($this->request->data['SheetRideDetailRides']) &&
                    !empty($this->request->data['SheetRideDetailRides'])) {
                    if (!empty($carId)) {
                        $carOffshore = $this->isCarOffshore($carId);
                        $this->add_Ride_sheetRide($this->request->data['SheetRideDetailRides'][1], $reference, $sheetRideId, $carId, $carOffshore);
                    } else {
                           $this->add_Ride_sheetRide($this->request->data['SheetRideDetailRides'][1], $reference, $sheetRideId);
                    }
                }
                $this->saveUserAction(SectionsEnum::mission,
                    $sheetRideId, $this->Session->read('Auth.User.id'), ActionsEnum::add);

                $this->Flash->success(__('The mission has been saved.'));
                $this->redirect(array('controller'=>'SheetRides','action' => 'index'));

        }
        $marchandises = array();

        // Take into account tank state when estimate sheet ride's consumption

        $displayMissionCost = $this->isDisplayMissionCost();
        $useRideCategory = $this->useRideCategory();
        $timeParameters = $this->getTimeParametersToCalculateArrivalDate();
        $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
        $calculByMaps = $this->Parameter->getCodesParameterVal('calcul_by_maps');
        $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
        $fieldMarchandiseRequired = $this->Parameter->getCodesParameterVal('marchandise_required');

        $isDestinationRequired = $this->isDestinationRequired();
        $sheetRideWithMission = $this->Parameter->getCodesParameterVal('sheet_ride_with_mission');
        $orderMission = $this->SheetRideDetailRides->find('count',
            array('conditions' => array('SheetRideDetailRides.sheet_ride_id' => $sheetRideId)));


        $this->set(compact('missionCost', 'managementParameterMissionCost',
            'displayMissionCost', 'marchandises', 'priority','sheetRideWithMission',
            'tvas', 'orderMission', 'useRideCategory',
            'timeParameters', 'paramPriceNight','isDestinationRequired',
            'calculByMaps', 'usePurchaseBill','fieldMarchandiseRequired','negativeAccount'));

    }



    public function edit($id = null)
    {
        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            $this->redirect('/');
        }
        $url =  array('controller' => 'sheetRides', 'action' => 'index');
        if(Configure::read("transport_personnel") == '1'){
            $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validateWithoutCommercial;
        }else {
            if (Configure::read("gestion_commercial") == '1' ) {
                $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validate;
            }else {
                $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validatePersonalizedRide;
            }
        }
        $this->setTimeActif();
        date_default_timezone_set("Africa/Algiers");
        $user_id = $this->Auth->user('id');


        $isAgent = $this->isAgent();
        $this->set('isAgent', $isAgent);

        if (!$isAgent) {
            $this->verifyUserPermission(SectionsEnum::mission, $user_id,
                ActionsEnum::edit, "SheetRideDetailRides", $id, "SheetRideDetailRides", null);
        }
        // Get reference mission automatic parameter reference_mi_auto
        $isReferenceMissionAutomatic = $this->Parameter->getCodesParameterVal('reference_mi_auto');
        $this->set('referenceMission', $isReferenceMissionAutomatic);
        if (!$this->SheetRideDetailRides->exists($id)) {
            throw new NotFoundException(__('Invalid sheet ride'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->closeItemOpened('SheetRideDetailRides', $id);
                $this->Flash->error(__('Changes were not saved. Mission cancelled.'));
                $this->redirect(array('controller'=>'SheetRide','action' => 'index'));
            }
            // calculate diff between date open and date submit if diff > 15 min redirect to index dont save modification
            $currentDateAdd = $this->request->data['SheetRideDetailRides']['currentDateAdd'];
            $currentDateSubmit = date('Y-m-d H:i');
            $currentDateAdd = new DateTime ($currentDateAdd);
            $currentDateSubmit = new DateTime ($currentDateSubmit);
            $interval = date_diff($currentDateAdd, $currentDateSubmit);
            $total = $interval->y * 526600 + $interval->m * 43800 + $interval->d * 1440 + $interval->h * 60 + $interval->i;
            if ($total > 100) {
                $this->Flash->error(__('The mission could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->createDatetimeFromDatetime('SheetRideDetailRides', 'planned_start_date');
            $this->createDatetimeFromDatetime('SheetRideDetailRides', 'real_start_date');
            $this->createDatetimeFromDatetime('SheetRideDetailRides', 'planned_end_date');
            $this->createDatetimeFromDatetime('SheetRideDetailRides', 'real_end_date');
            $this->request->data['SheetRideDetailRides']['modified_id'] = $this->Session->read('Auth.User.id');
            $this->closeItemOpened('SheetRideDetailRides', $id);
                if (isset($this->request->data['SheetRideDetailRides'])&&
                    !empty($this->request->data['SheetRideDetailRides'])) {
                            $sheetRideDetailRide = $this->request->data['SheetRideDetailRides'];
                            $sheetRideDetailRideId = $sheetRideDetailRide['id'];
                            $sheetRideId = $sheetRideDetailRide['sheet_ride_id'];
                            $reference = $sheetRideDetailRide['reference_sheet_ride'];
                            $save = $this->update_Ride_sheetRide($sheetRideDetailRide, $reference, $sheetRideId,
                                        $sheetRideDetailRideId, null,
                                        null, null, null);

                }
                $this->saveUserAction(SectionsEnum::mission, $id, $this->Session->read('Auth.User.id'), ActionsEnum::edit);
            if ($save) {
                $this->Flash->success(__('The mission has been saved.'));
                $this->redirect($url);
            } else {
                $this->Flash->error(__('The mission could not be saved. Please, try again.'));
            }
        } else {
            $this->isOpenedByOtherUser("SheetRideDetailRides", 'SheetRideDetailRides', 'mission', $id);
            $rides_sheet_ride = $this->SheetRideDetailRides->getSheetRideDetailRideById($id);
           // var_dump($rides_sheet_ride); die();
                    $detailRideId = $rides_sheet_ride['DetailRide']['id'];
                    $supplierId = $rides_sheet_ride['Supplier']['id'];
                    $finalSupplierId = $rides_sheet_ride['SupplierFinal']['id'];
                    $destinationId[] = $rides_sheet_ride['SheetRideDetailRides']['departure_destination_id'];
                    $destinationId[] = $rides_sheet_ride['SheetRideDetailRides']['arrival_destination_id'];



                $this->SheetRideDetailRides->DetailRide->virtualFields = array(
                    'cnames' => "CONCAT(IFNULL(TransportBillDetailRides.reference,''),' - ', DepartureDestination.name, ' - ', ArrivalDestination.name, ' - ',CarType.name, ' - ', IFNULL(RideCategory.name,'') )"
                );
                $detailRides = $this->SheetRideDetailRides->DetailRide->find('list', array(
                    'order' => 'DetailRide.wording ASC',
                    'conditions' => array('DetailRide.id' => $detailRideId),
                    'recursive' => -1,
                    'fields' => 'cnames',
                    'joins' => array(
                        array(
                            'table' => 'rides',
                            'type' => 'left',
                            'alias' => 'Ride',
                            'conditions' => array('DetailRide.ride_id = Ride.id')
                        ),
                        array(
                            'table' => 'transport_bill_detail_rides',
                            'type' => 'left',
                            'alias' => 'TransportBillDetailRides',
                            'conditions' => array('TransportBillDetailRides.detail_ride_id = DetailRide.id')
                        ),
                        array(
                            'table' => 'car_types',
                            'type' => 'left',
                            'alias' => 'CarType',
                            'conditions' => array('DetailRide.car_type_id = CarType.id')
                        ),
                        array(
                            'table' => 'ride_categories',
                            'type' => 'left',
                            'alias' => 'RideCategory',
                            'conditions' => array('TransportBillDetailRides.ride_category_id = RideCategory.id')
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
                        )
                    )
                ));
                $suppliers = $this->Supplier->getSuppliersByParams(1, 1, null, array(2, 3), null, $supplierId);

                $finalSuppliers = array();

                if(!empty($supplierId)){
                        if($supplierId!=NULL){
                            $finalSuppliers[] = $this->Supplier->getFinalSuppliersByInitialSupplier($supplierId, $finalSupplierId);

                        }

                }
                $conditions = array('Destination.id' => $destinationId);
                $destinations = $this->Destination->getDestinationsByConditions($conditions, 'list');

                $this->set(compact('detailRides', 'suppliers', 'finalSuppliers',
                    'destinations'));
                $managementParameterMissionCost = $this->getManagementParameterMissionCost();
                $missionCost = 0;
                switch ($managementParameterMissionCost) {
                    case '1':
                            $detailRideId = $rides_sheet_ride['SheetRideDetailRides']['detail_ride_id'];
                         if(!empty($detailRideId)){
                             $cost = $this->SheetRide->getMissionCostByDay($detailRideId);
                             $missionCost = $cost;
                         }

                        break;

                    case '2':
                            $detailRideId = $rides_sheet_ride['SheetRideDetailRides']['detail_ride_id'];
                        if(!empty($detailRideId)) {
                            $cost = $this->SheetRide->getMissionCostByDestination($detailRideId);
                            $missionCost = $cost;
                        }
                        break;

                    case '3':
                            $detailRideId = $rides_sheet_ride['SheetRideDetailRides']['detail_ride_id'];
                            $rideCategoryId = $rides_sheet_ride['SheetRideDetailRides']['ride_category_id'];
                        if(!empty($detailRideId)&& !empty($rideCategoryId)) {
                            $cost = $this->SheetRide->getMissionCostByDistance($detailRideId, $rideCategoryId);
                            $missionCost = $cost;
                        }
                        break;

                }
                $this->set('missionCost', $missionCost);
                $this->set('rides_sheet_ride', $rides_sheet_ride);
            $useRideCategory = $this->useRideCategory();
            $this->set('useRideCategory', $useRideCategory);
        }
        $displayMissionCost = $this->isDisplayMissionCost();
        $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
        $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
        $calculByMaps = $this->Parameter->getCodesParameterVal('calcul_by_maps');

        $this->set(compact('managementParameterMissionCost', 'displayMissionCost', 'rideCategories',
            'detailRides', 'suppliers', 'paramPriceNight', 'usePurchaseBill','paramPriceNight','calculByMaps'));
    }



    /**
     *
     *  view real position of  carId with geolocalisation
     */
    public function ViewPosition($id = null)
    {

        $planification = $this->hasModulePlanification();
        if($planification==0){
            return $this->redirect('/');
        }
        $car = $this->getCarFromSheetRideDetailRide($id);
        $code = null;
        if (!empty($car)) {

            $code = $car['code'];
            $carModel = $car['CarModel'];
            $position = $this->getPositionCar($code);
            $code = $code . ' - ' . $carModel;


        } else {
            $position = null;
        }
        $this->set('code', $code);
        $this->set('position', $position);
    }


    /**
     *
     *  get real position of carId with geolocalisation
     */
    public function getPositionCar($codeCar = null)
    {

        $planification = $this->hasModulePlanification();
        if($planification==0){
            return $this->redirect('/');
        }
        $headers = array(
            'http' => array(
                'method' => "GET",
                'header' => "Content-Type:application/json\r\n" .
                    "Autentication:CF714E72186F3A8E90A3641CB7EBC65C920450725F1447E82BEEAD0112E8D4C317A829502B69BBBA0011F38DB7E4F42E8B6D987E881ECD73B1F58BB0C2192D7A969261F35591782D90E3509727A2C221A20346686D19CDC9E91BFDA0B73CCED927C1C17F2099E2F67DEF40380FEFBF157BB2522518F68D88786BF02D29155F77C33EE6B10F4FF5DBB44A87A935FD0B9DEDF83ABDC22B41301186A533AAC541C5BB26A6123992803CDAC4F989C2D32C6E5E0AEF975F2BF722BFBF00A6A5AB97E38C84DD046414C7AE20B43614D518F681D0C63F7E74A0E96FBD4BA0F76E0EB86C\r\n"
            )
        );
        $context = stream_context_create($headers);
        $url = 'http://41.106.3.11/api/LiveTracking?code=' . $codeCar;
        $chaine = file_get_contents($url, false, $context);

        $chaine = utf8_encode($chaine);
        $chaine = json_decode($chaine, JSON_UNESCAPED_UNICODE);


        if (!empty($chaine)) {

            $code = utf8_decode($chaine[0]['Code']);

            if ($code == $codeCar) {

                if ($chaine[0]['IsOutOfService'] == false) {

                    $position = $chaine[0]['Position'];


                } else {
                    $position = null;
                }
            }
        } else {
            $position = null;
        }

        return $position;


    }

    public function synchronisationMissions()
    {
        $planification = $this->hasModulePlanification();
        if($planification==0){
            return $this->redirect('/');
        }
        $sheetRideDetailRides = $this->SheetRideDetailRides->find('all', array(
            'fields' => array('SheetRideDetailRides.id'),
            'recursive' => -1,
            'conditions' => array('SheetRideDetailRides.status_id' => array(1, 2))
        ));

        if (!empty($sheetRideDetailRides)) {
            foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
                $this->synchronisationMission($sheetRideDetailRide['SheetRideDetailRides']['id']);
            }
        }
    }

    public function  synchronisationMission($id = null)
    {
        $sheetRideDetailRide = $this->SheetRideDetailRides->find('first', array(
            'recursive' => -1,
            'conditions' => array('SheetRideDetailRides.id' => $id),
            'fields' => array(
                'SheetRideDetailRides.status_id',
                'SheetRideDetailRides.real_start_date',
                'SheetRideDetailRides.real_end_date'
            )
        ));

        $statusId = $sheetRideDetailRide['SheetRideDetailRides']['status_id'];
        $realStartDate = $sheetRideDetailRide['SheetRideDetailRides']['real_start_date'];
        $realEndDate = $sheetRideDetailRide['SheetRideDetailRides']['real_end_date'];

        if ($statusId == 1) {
            $car = $this->getCarFromSheetRideDetailRide($id);
            $client = $this->getCustomerFromSheetRideDetailRide($id);
            if (!empty($car)) {
                $codeCar = $car['code'];
                $clientInitial = $client['clientInitial'];
                $clientFinal = $client['clientFinal'];
                $date = $this->getDepartureDateMission($codeCar, $clientInitial);

                if (!empty($date)) {

                    $startDate = $date['departureDate'];
                    $startDate = str_replace('T', '-', $startDate);
                    $startDate = str_replace(':', '-', $startDate);


                    $this->SheetRideDetailRides->id = $id;
                    if (empty($realStartDate)) {
                        $this->SheetRideDetailRides->saveField('real_start_date', $startDate);

                    } else {
                        $startDate = $realStartDate;

                    }

                    if (!empty($startDate)) {
                        $statusId = $this->updateStatusSheet($startDate);
                        $this->SheetRideDetailRides->saveField('status_id', $statusId);
                        if ($statusId == 2) {
                            $date = $this->getArrivalDateMission($codeCar, $clientFinal);
                            if (!empty($date)) {

                                $endDate = $date['arrivalDate'];
                                $endDate = str_replace('T', '-', $endDate);
                                $endDate = str_replace(':', '-', $endDate);


                                $this->SheetRideDetailRides->id = $id;
                                if (empty($realEndDate) && ($startDate < $endDate)) {
                                    $this->SheetRideDetailRides->saveField('real_end_date', $endDate);
                                }

                                if (!empty($startDate)) {
                                    $statusId = $this->updateStatusSheet($startDate, $endDate);
                                    $this->SheetRideDetailRides->saveField('status_id', $statusId);
                                }


                            }

                        }
                    }

                }

            }

        } else {
            if ($statusId == 2) {

                $car = $this->getCarFromSheetRideDetailRide($id);
                $client = $this->getCustomerFromSheetRideDetailRide($id);
                if (!empty($car)) {
                    $codeCar = $car['code'];

                    $clientFinal = $client['clientFinal'];


                    $date = $this->getArrivalDateMission($codeCar, $clientFinal);
                    if (!empty($date)) {

                        $endDate = $date['arrivalDate'];
                        $endDate = str_replace('T', '-', $endDate);
                        $endDate = str_replace(':', '-', $endDate);


                        $this->SheetRideDetailRides->id = $id;
                        if (empty($realEndDate) && ($realStartDate < $endDate)) {
                            $this->SheetRideDetailRides->saveField('real_end_date', $endDate);
                        }

                        if (!empty($realStartDate)) {
                            $statusId = $this->updateStatusSheet($realStartDate, $endDate);
                            $this->SheetRideDetailRides->saveField('status_id', $statusId);
                        }

                    }

                }

            }
        }


    }

    public function getDepartureDateMission($codeCar = null, $clientInitial = null)
    {

        $planification = $this->hasModulePlanification();
        if($planification==0){
            return $this->redirect('/');
        }
        $headers = array(
            'http' => array(
                'method' => "GET",
                'header' => "Content-Type:application/json\r\n" .
                    "Autentication:CF714E72186F3A8E90A3641CB7EBC65C920450725F1447E82BEEAD0112E8D4C317A829502B69BBBA0011F38DB7E4F42E8B6D987E881ECD73B1F58BB0C2192D7A969261F35591782D90E3509727A2C221A20346686D19CDC9E91BFDA0B73CCED927C1C17F2099E2F67DEF40380FEFBF157BB2522518F68D88786BF02D29155F77C33EE6B10F4FF5DBB44A87A935FD0B9DEDF83ABDC22B41301186A533AAC541C5BB26A6123992803CDAC4F989C2D32C6E5E0AEF975F2BF722BFBF00A6A5AB97E38C84DD046414C7AE20B43614D518F681D0C63F7E74A0E96FBD4BA0F76E0EB86C\r\n"
            )
        );
        $context = stream_context_create($headers);

        $currentDate = date("Y-m-d");
        $url = 'http://41.106.3.11/api/Alerts?type=GeofenceIn&code=' . $codeCar . '&date=' . $currentDate;

        //$url = 'http://41.106.3.11/api/Alerts?type=GeofenceIn&date=' . $currentDate;
        $chaine = file_get_contents($url, false, $context);

        $chaine = utf8_encode($chaine);
        $chaines = json_decode($chaine, JSON_UNESCAPED_UNICODE);


        $date = array();
        if (!empty($chaines)) {
            foreach ($chaines as $chaine) {
                $codeClient = utf8_decode($chaine['Description']);

                if ($codeClient == $clientInitial) {


                    if ($chaine['AlertType'] == 4) {

                        //$startDate = $chaine['StartDate'];

                        $departureDate = $chaine['EndDate'];
                        $date['departureDate'] = $departureDate;
                        return $date;

                    } else {
                        // $startDate = null;
                        $departureDate = null;
                    }


                }


            }
            return $date;


        } else {
            return null;
        }


    }


    public function getArrivalDateMission($codeCar = null, $clientFinal = null)
    {

        $planification = $this->hasModulePlanification();
        if($planification==0){
            return $this->redirect('/');
        }
        $headers = array(
            'http' => array(
                'method' => "GET",
                'header' => "Content-Type:application/json\r\n" .
                    "Autentication:CF714E72186F3A8E90A3641CB7EBC65C920450725F1447E82BEEAD0112E8D4C317A829502B69BBBA0011F38DB7E4F42E8B6D987E881ECD73B1F58BB0C2192D7A969261F35591782D90E3509727A2C221A20346686D19CDC9E91BFDA0B73CCED927C1C17F2099E2F67DEF40380FEFBF157BB2522518F68D88786BF02D29155F77C33EE6B10F4FF5DBB44A87A935FD0B9DEDF83ABDC22B41301186A533AAC541C5BB26A6123992803CDAC4F989C2D32C6E5E0AEF975F2BF722BFBF00A6A5AB97E38C84DD046414C7AE20B43614D518F681D0C63F7E74A0E96FBD4BA0F76E0EB86C\r\n"
            )
        );
        $context = stream_context_create($headers);

        $currentDate = date("Y-m-d");
        $url = 'http://41.106.3.11/api/Alerts?type=GeofenceIn&code=' . $codeCar . '&date=' . $currentDate;

        //$url = 'http://41.106.3.11/api/Alerts?type=GeofenceIn&code=081&date=' . $currentDate;
        $chaine = file_get_contents($url, false, $context);

        $chaine = utf8_encode($chaine);
        $chaines = json_decode($chaine, JSON_UNESCAPED_UNICODE);


        if (!empty($chaines)) {

            foreach ($chaines as $chaine) {
                $codeClient = utf8_decode($chaine['Description']);

                $date = array();


                if ($codeClient == $clientFinal) {


                    if ($chaine['AlertType'] == 4) {

                        $arrivalDate = $chaine['StartDate'];
                        $date['arrivalDate'] = $arrivalDate;
                        return $date;
                        //$endDate = $chaine['EndDate'];

                    } else {
                        $arrivalDate = null;
                        // $endDate = null;
                    }


                }


            }

            return $date;

        }


    }

    public function getCarFromSheetRideDetailRide($id = null)
    {

        $sheetRideDetailRide = $this->SheetRideDetailRides->find("first", array(
            "conditions" => array('SheetRideDetailRides.id' => $id),
            'recursive' => -1,
            'fields' => array(
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.reference',
                'SheetRide.car_id',
                'SheetRideDetailRides.status_id',
                'Car.code',
                'CarModel.name'
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
                    'alias' => 'CarModel',
                    'conditions' => array('Car.carmodel_id = CarModel.id')
                )

            )

        ));
        $code = null;
        if (!empty($sheetRideDetailRide)) {

            $code = $sheetRideDetailRide['Car']['code'];
            $carModel = $sheetRideDetailRide['CarModel']['name'];
            $carId = $sheetRideDetailRide['SheetRide']['car_id'];
        }

        $car = array();
        $car['code'] = $code;
        $car['CarModel'] = $carModel;
        $car ['id'] = $carId;

        return $car;
    }

    public function getCustomerFromSheetRideDetailRide($id = null)
    {

        $sheetRideDetailRide = $this->SheetRideDetailRides->find("first", array(
            "conditions" => array('SheetRideDetailRides.id' => $id),
            'recursive' => -1,
            'fields' => array(
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.reference',
                'SheetRide.car_id',
                'SheetRideDetailRides.status_id',
                'Car.code',
                'CarModel.name',
                'Supplier.id',
                'Supplier.code',
                'SupplierFinal.id',
                'SupplierFinal.code'
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
                    'alias' => 'CarModel',
                    'conditions' => array('Car.carmodel_id = CarModel.id')
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
        $code = null;
        if (!empty($sheetRideDetailRide)) {

            $clientInitial = $sheetRideDetailRide['Supplier']['code'];
            $clientFinal = $sheetRideDetailRide['SupplierFinal']['code'];
        }

        $client = array();
        $client['clientInitial'] = $clientInitial;
        $client ['clientFinal'] = $clientFinal;

        return $client;
    }

    public function sendSms($id = null)
    {

        $sheetRideDetailRide = $this->SheetRideDetailRides->find('first', array(
            'conditions' => array('SheetRideDetailRides.id' => $id),
            'recursive' => -1,
            'fields' => array(
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.planned_start_date',
                'Supplier.name',
                'SupplierFinal.name',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Customer.first_name',
                'Customer.last_name',
                'Customer.mobile',

            ),
            'joins' => array(

                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('SheetRide.id = SheetRideDetailRides.sheet_ride_id')
                ),
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
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
            )
        ));

        if (!empty($sheetRideDetailRide)) {

            if ($this->saveSms($sheetRideDetailRide)) {
                $this->Flash->success(__('The SMS is being sent.'));

                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The SMS is being sent.'));

                $this->redirect(array('action' => 'index'));
            }
        }
    }

    public function saveSms($sheetRideDetailRide = null)
    {

        /* $body = 'Mr '.$sheetRideDetailRide['Customer']['first_name'].' '.$sheetRideDetailRide['Customer']['last_name'].' Vous avez une mission a effectué le '.$sheetRideDetailRide['SheetRideDetailRides']['planned_start_date'].' de '.$sheetRideDetailRide['DepartureDestination']['name'].' (client : '.$sheetRideDetailRide['Supplier']['name'].') à '.$sheetRideDetailRide['ArrivalDestination']['name'].'(client : '.$sheetRideDetailRide['SupplierFinal']['name']. ')';
         $this->Message->create();
         $data = array();
         $data['Message']['mobile'] = $sheetRideDetailRide['Customer']['mobile'];
         $data['Message']['body'] = $body;
         $data['Message']['status_id'] = 2;
         $data['Message']['sheet_ride_detail_ride_id'] = $sheetRideDetailRide['SheetRideDetailRides']['id'];
         $data['Message']['user_id'] = $this->Session->read('Auth.User.id');
         if($this->Message->save($data)){
             return true;
         }else return false;*/
        return true;
    }

    public function paymentMissions()
    {
        $planification = $this->hasModulePlanification();
        if($planification==0){
            return $this->redirect('/');
        }
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::mission, $user_id, ActionsEnum::view,
            "SheetRideDetailRides", null, "SheetRideDetailRide", null);
        $this->loadModel('Tva');
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();
        switch ($result) {
            case 1 :
                $conditions = null;
                break;
            case 2 :
                $conditions = array('SheetRide.user_id ' => $user_id);

                break;
            case 3 :
                $conditions = array('SheetRide.user_id !=' => $user_id);
                break;

            default:
                $conditions = null;
        }

        $sheetRideDetailRides = $this->SheetRideDetailRides->find('all', array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => $limit,
            'order' => $order,
            'conditions' => $conditions,
            'fields' => array(
                'SheetRideDetailRides.reference',
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.status_id',
                'CarType.name',
                'Supplier.name',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'SheetRideDetailRides.amount_remaining',
                'SheetRideDetailRides.supplier_id',
                'SheetRideDetailRides.detail_ride_id',
                'SheetRideDetailRides.return_mission',
                'SheetRideDetailRides.type_price',
                'SheetRideDetailRides.ride_category_id',
                'TransportBillDetailRides.id',
                'TransportBillDetailRides.unit_price',
                'TransportBillDetailRides.tva_id',
                'TransportBillDetailRides.ristourne_%',
                'TransportBillDetailRides.ristourne_val',

            ),
            'joins' => array(

                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('SheetRide.id = SheetRideDetailRides.sheet_ride_id')
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
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('SheetRideDetailRides.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'transport_bill_detail_rides',
                    'type' => 'left',
                    'alias' => 'TransportBillDetailRides',
                    'conditions' => array('SheetRideDetailRides.transport_bill_detail_ride_id = TransportBillDetailRides.id')
                ),
            )
        ));
        $i = 0;
        $missions = array();
        foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
            $missions[$i]['reference'] = $sheetRideDetailRide['SheetRideDetailRides']['reference'];
            $missions[$i]['id'] = $sheetRideDetailRide['SheetRideDetailRides']['id'];
            $missions[$i]['DepartureDestination'] = $sheetRideDetailRide['DepartureDestination']['name'];
            $missions[$i]['ArrivalDestination'] = $sheetRideDetailRide['ArrivalDestination']['name'];
            $missions[$i]['CarType'] = $sheetRideDetailRide['CarType']['name'];
            $missions[$i]['Supplier'] = $sheetRideDetailRide['Supplier']['name'];
            $missions[$i]['status'] = $sheetRideDetailRide['SheetRideDetailRides']['status_id'];

            if (!empty($sheetRideDetailRide['TransportBillDetailRides']['unit_price'])) {
                $missions[$i]['unit_price'] = $sheetRideDetailRide['TransportBillDetailRides']['unit_price'];
            } else {
                $price = $this->getPriceRide($sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'], 0,
                    $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'],
                    $sheetRideDetailRide['SheetRideDetailRides']['return_mission'],
                    $sheetRideDetailRide['SheetRideDetailRides']['type_price'],
                    $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id']);
                if (!empty($price)) {
                    if ($sheetRideDetailRide['SheetRideDetailRides']['return_mission'] == 1) {
                        $missions[$i]['unit_price'] = $price[0] + $price[2];
                    } else {
                        $missions[$i]['unit_price'] = $price[0];
                    }
                } else {
                    $missions[$i]['unit_price'] = 0;
                }
            }
            if (!empty($sheetRideDetailRide['TransportBillDetailRides']['ristourne_%'])) {
                $missions[$i]['ristourne_val'] = ($missions[$i]['unit_price'] * $sheetRideDetailRide['TransportBillDetailRides']['ristourne_%']) / 100;
                $missions[$i]['price_ht'] = $missions[$i]['unit_price'] - $missions[$i]['ristourne_val'];
            } else {
                $missions[$i]['ristourne_val'] = null;
                $missions[$i]['price_ht'] = $missions[$i]['unit_price'];
            }
            if (!empty($SheetRideDetailRide['TransportBillDetailRides']['tva_id'])) {
                $missions[$i]['tva_id'] = $SheetRideDetailRide['TransportBillDetailRides']['tva_id'];
                $missions[$i]['price_ttc'] = $missions[$i]['price_ht'] + ($missions[$i]['price_ht'] * $this->Tva->getTvaValueById($missions[$i]['tva_id']));
            } else {
                $missions[$i]['tva_id'] = 1;
                $missions[$i]['price_ttc'] = $missions[$i]['price_ht'] + ($missions[$i]['price_ht'] * 0.19);
            }
            $i++;
        }

        $this->set('missions', $missions);

        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set(compact('limit', 'param', 'sumMissionCost', 'sumAmountRemaining', 'order'));
        $users = $this->SheetRideDetailRides->User->find('list', array('conditions' => 'User.id != 1'));
        $profiles = $this->Profile->getUserProfiles();
        $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
        $this->SheetRideDetailRides->DetailRide->Ride->virtualFields = array(
            'cnames' => "CONCAT(DepartureDestination.name, ' - ', ArrivalDestination.name)"
        );
        $rides = $this->SheetRideDetailRides->DetailRide->Ride->find('list', array(
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
        $param = $this->Parameter->getCodesParameterVal('name_car');

        if ($param == 1) {
            $this->SheetRide->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name )"
            );

        } elseif ($param == 2) {

            $this->SheetRide->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(Car.immatr_def,Car.immatr_prov), ' - ', Carmodel.name)"
            );
        }
        $cars = $this->SheetRideDetailRides->SheetRide->Car->find('list', array(
            'fields' => 'cnames',
            'recursive' => -1,
            'order' => 'Car.code ASC',
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
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);
        $separatorAmount = $this->getSeparatorAmount();
        $client_i2b = $this->isCustomerI2B();
        $this->set(compact('profiles', 'users', 'suppliers', 'rides', 'cars', 'customers',
                'carTypes', 'separatorAmount', 'client_i2b'));
    }

    function getPriceRide(
        $rideId = null,
        $num = null,
        $clientId = null,
        $deliveryWithReturn = 2,
        $typePrice = 1,
        $rideCategoryId = null
    ) {

        $this->set('num', $num);
        $this->set('deliveryWithReturn', $deliveryWithReturn);
        $this->set('typePrice', $typePrice);

        $this->loadModel('Price');

        if ($rideCategoryId == null) {
            $rideCategoryId = 0;
        }
        $price = $this->Price->find('first',
            array(
                'conditions' => array(
                    'Price.detail_ride_id' => $rideId,
                    'Price.supplier_id' => $clientId,
                    'PriceRideCategory.ride_category_id' => $rideCategoryId
                ),
                'joins' => array(

                    array(
                        'table' => 'price_ride_categories',
                        'type' => 'left',
                        'alias' => 'PriceRideCategory',
                        'conditions' => array('PriceRideCategory.price_id = Price.id')
                    ),
                ),
                'recursive' => -1,
                'fields' => array(
                    'PriceRideCategory.price_ht',
                    'PriceRideCategory.price_ht_night',
                    'PriceRideCategory.id',
                    'PriceRideCategory.price_return'
                )
            ));

        if (!empty($price)) {
            if ($typePrice == 2) {
                $price[0] = $price['PriceRideCategory']['price_ht_night'];
            } else {
                $price[0] = $price['PriceRideCategory']['price_ht'];
            }
            $price[1] = $price['PriceRideCategory']['id'];
            $price[2] = $price['PriceRideCategory']['price_return'];

        } else {
            $supplier = $this->Supplier->getSuppliersById($clientId);
            if (!empty($supplier)) {
                $categoryId = $supplier['Supplier']['supplier_category_id'];

                $price = $this->Price->find('first',
                    array(
                        'conditions' => array(
                            'Price.detail_ride_id' => $rideId,
                            'Price.supplier_category_id' => $categoryId,
                            'PriceRideCategory.ride_category_id' => $rideCategoryId
                        ),
                        'recursive' => -1,
                        'joins' => array(
                            array(
                                'table' => 'price_ride_categories',
                                'type' => 'left',
                                'alias' => 'PriceRideCategory',
                                'conditions' => array('PriceRideCategory.price_id = Price.id')
                            ),
                        ),
                        'recursive' => -1,
                        'fields' => array(
                            'PriceRideCategory.price_ht',
                            'PriceRideCategory.price_ht_night',
                            'PriceRideCategory.id',
                            'PriceRideCategory.price_return'
                        )
                    ));
                if (!empty($price)) {
                    if ($typePrice == 2) {
                        $price[0] = $price['PriceRideCategory']['price_ht_night'];
                    } else {
                        $price[0] = $price['PriceRideCategory']['price_ht'];
                    }
                    $price[1] = $price['PriceRideCategory']['id'];
                    $price[2] = $price['PriceRideCategory']['price_return'];

                } else {
                    $price = $this->Price->find('first',
                        array(
                            'conditions' => array(
                                'Price.detail_ride_id' => $rideId,
                                'Price.supplier_category_id' => null,
                                'Price.supplier_id' => null,
                                'PriceRideCategory.ride_category_id' => $rideCategoryId
                            ),
                            'recursive' => -1,
                            'joins' => array(
                                array(
                                    'table' => 'price_ride_categories',
                                    'type' => 'left',
                                    'alias' => 'PriceRideCategory',
                                    'conditions' => array('PriceRideCategory.price_id = Price.id')
                                ),
                            ),
                            'recursive' => -1,
                            'fields' => array(
                                'PriceRideCategory.price_ht',
                                'PriceRideCategory.price_ht_night',
                                'PriceRideCategory.id',
                                'PriceRideCategory.price_return'
                            )
                        ));

                    if (!empty($price)) {
                        if ($typePrice == 2) {
                            $price[0] = $price['PriceRideCategory']['price_ht_night'];
                        } else {
                            $price[0] = $price['PriceRideCategory']['price_ht'];
                        }
                        $price[1] = $price['PriceRideCategory']['id'];
                        $price[2] = $price['PriceRideCategory']['price_return'];

                    }
                }
            }
        }

        return $price;
    }

    public function calendar()
    {
         $planification = $this->hasModulePlanification();
        if($planification==0){
            return $this->redirect('/');
        }
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::mission, $user_id, ActionsEnum::view,
            "SheetRideDetailRides", null, "SheetRideDetailRide", null);
        switch ($result) {
            case 1 :
                $conditions = null;
                break;
            case 2 :
                $conditions = array('SheetRide.user_id ' => $user_id);

                break;
            case 3 :
                $conditions = array('SheetRide.user_id !=' => $user_id);
                break;

            default:
                $conditions = null;
        }
        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'conditions' => $conditions,
            'fields' => array(
                'SheetRideDetailRides.reference',
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.detail_ride_id',
                'SheetRideDetailRides.planned_start_date',
                'SheetRideDetailRides.real_start_date',
                'SheetRideDetailRides.planned_end_date',
                'SheetRideDetailRides.real_end_date',
                'SheetRide.car_id',
                'SheetRide.id',
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
                'SheetRideDetailRides.amount_remaining',


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
                )

            )
        );
        $sheetRideDetailRides = $this->Paginator->paginate('SheetRideDetailRides');

        $this->set('sheetRideDetailRides', $sheetRideDetailRides);
        $this->set(compact('profiles', 'users', 'suppliers', 'rides', 'cars', 'customers',
                'carTypes', 'separatorAmount', 'client_i2b', 'settleMissions'));

    }

    public function liste( $id = null, $keyword = null)
    {
        $planification = $this->hasModulePlanification();
        if($planification==0){
            return $this->redirect('/');
        }
        $keyword = str_replace('espace', ' ', $keyword);
        $keyword = str_replace('slash', '/', $keyword);
        $keyword = str_replace('tiret', '-', $keyword);

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
                        "LOWER(CarType.name) LIKE" => "%$keyword%",
                        "LOWER(DepartureDestination.name) LIKE" => "%$keyword%",
                        "LOWER(ArrivalDestination.name) LIKE" => "%$keyword%",
                    )
                );
                break;
            case 4 :
                $conditions = array(
                    'OR' => array(
                        "LOWER(Car.immatr_def) LIKE" => "%$keyword%",
                        "LOWER(Carmodel.name) LIKE" => "%$keyword%",
                    )
                );
                break;
            case 5 :
                $conditions = array(
                    'OR' => array(
                        "LOWER(Customer.first_name) LIKE" => "%$keyword%",
                        "LOWER(Customer.last_name) LIKE" => "%$keyword%",
                    )
                );
                break;
            case 6 :
                $conditions = array("LOWER(Supplier.name) LIKE" => "%$keyword%");
                break;
            case 7 :
                $keyword = str_replace("/", "-", $keyword);
                $start = str_replace("-", "/", $keyword);
                $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                $conditions = array("SheetRideDetailRides.real_start_date >=" => $startdtm->format('Y-m-d 00:00:00'));
                break;
            case 8 :
                $conditions = array("LOWER(SupplierFinal.name) LIKE" => "%$keyword%");
                break;
            case 9 :
                $keyword = str_replace("/", "-", $keyword);
                $start = str_replace("-", "/", $keyword);
                $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                $conditions = array("SheetRideDetailRides.real_end_date >=" => $startdtm->format('Y-m-d 00:00:00'));
                break;
            case 10 :
                $conditions = array("LOWER(SheetRideDetailRides.status_id) LIKE" => "%$keyword%");
                break;
            default:
                $conditions = array("LOWER(SheetRideDetailRides.reference) LIKE" => "%$keyword%");
        }

        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'conditions' => $conditions,
            'limit'=>$limit,
            'fields' => array(
                'SheetRideDetailRides.reference',
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.from_customer_order',
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
                'SheetRideDetailRides.mission_cost',
                'SheetRide.car_id',
                'SheetRide.customer_id',
                'CarType.name',
                'Supplier.name',
                'SupplierFinal.name',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Departure.name',
                'Arrival.name',
                'Car.code',
                'Customer.first_name',
                'Customer.last_name',
                'Car.immatr_def',
                'Carmodel.name',
                'SheetRideDetailRides.amount_remaining',
                //'Message.status_id'

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
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Departure',
                    'conditions' => array('Departure.id = SheetRideDetailRides.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Arrival',
                    'conditions' => array('ArrivalDestination.id = SheetRideDetailRides.arrival_destination_id')
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
                /*  array(
                      'table' => 'messages',
                      'type' => 'left',
                      'alias' => 'Message',
                      'conditions' => array('Message.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
                  ),*/

            )
        );
        $sheetRideDetailRides = $this->Paginator->paginate('SheetRideDetailRides');
        $this->set('sheetRideDetailRides', $sheetRideDetailRides);
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $client_i2b = $this->isCustomerI2B();
        $isAgent = $this->isAgent();
        $this->set(compact('param', 'client_i2b', 'isAgent'));

    }


    public function getSheetRideDetailRidesByStatusId($statusId= null, $customerId=null, $reference=null){
        $conditions = '1=1';
        if(isset($statusId) && $statusId!='null'){
            $conditions = $conditions." && `SheetRide`.`status_id` in ".$statusId;
        }
        if(isset($customerId) && $customerId!='null'){
            $conditions = $conditions." && `Customer`.`id` = ".$customerId;
        }
        if(isset($reference) && $reference!='null'){
            $conditions = $conditions." && ( `SheetRide`.`reference` = '".$reference."' or `SheetRide`.`id` = '".$reference."')";
        }
        if(($statusId=='null' && $customerId=='null' && $reference=='null' )|| (!isset($statusId) && !isset($customerId) && !isset($reference))) {
            $missions = json_encode(array("data"=>"noresults"));
            $this->response->type('json');
            $this->response->body($missions);
            return $this->response;
        }
        $sqlSheetRideDetailRides =" SELECT 
										`SheetRideDetailRides`.`reference`, 
										`SheetRideDetailRides`.`return_mission`, 
										`SheetRideDetailRides`.`id`,
										`SheetRideDetailRides`.`real_start_date`,
										`TransportBill`.`date`, 
										`SheetRideDetailRides`.`type_ride`, 
										`DepartureDestination`.`name`, 
										`ArrivalDestination`.`name`, 
										`Departure`.`name`, 
										`Arrival`.`name`,
										`Supplier`.`name`, 
										`Supplier`.`id`, 
										`SupplierFinal`.`name`, 
										`SheetRide`.`car_subcontracting`,
										`SheetRide`.`customer_id`,
										`SheetRide`.`customer_name`, 
										`Customer`.`first_name`, 
										`Customer`.`last_name`,
										`Customer`.`mobile`,
										`SheetRide`.`car_id`,
										`SheetRide`.`car_name`, 
										`Car`.`code`,  `Car`.`immatr_def`, 
										`Carmodel`.`name`, 
										`SheetRide`.`status_id` , 
										`SheetRideDetailRides`.`note`                                             
									FROM  
										`sheet_ride_detail_rides` AS `SheetRideDetailRides` 
										left JOIN `sheet_rides` AS `SheetRide` ON (`SheetRide`.`id` = `SheetRideDetailRides`.`sheet_ride_id`) 
										left JOIN `car` AS `Car` ON (`SheetRide`.`car_id` = `Car`.`id`) 
										left JOIN `detail_rides` AS `DetailRide` ON (`SheetRideDetailRides`.`detail_ride_id` = `DetailRide`.`id`) 
										left JOIN `car_types` AS `CarType` ON (`DetailRide`.`car_type_id` = `CarType`.`id`) 
										left JOIN `rides` AS `Ride` ON (`DetailRide`.`ride_id` = `Ride`.`id`) 
										left JOIN `destinations` AS `DepartureDestination` ON (`DepartureDestination`.`id` = `Ride`.`departure_destination_id`) 
										left JOIN `destinations` AS `ArrivalDestination` ON (`ArrivalDestination`.`id` = `Ride`.`arrival_destination_id`) 
										left JOIN `destinations` AS `Departure` ON (`Departure`.`id` = `SheetRideDetailRides`.`departure_destination_id`) 
										left JOIN `destinations` AS `Arrival` ON (`Arrival`.`id` = `SheetRideDetailRides`.`arrival_destination_id`) 
										left JOIN `customers` AS `Customer` ON (`SheetRide`.`customer_id` = `Customer`.`id`) 
										left JOIN `suppliers` AS `Supplier` ON (`SheetRideDetailRides`.`supplier_id` = `Supplier`.`id`) 
										left JOIN `suppliers` AS `SupplierFinal` ON (`SheetRideDetailRides`.`supplier_final_id` = `SupplierFinal`.`id`) 
										left JOIN `carmodels` AS `Carmodel` ON (`Car`.`carmodel_id` = `Carmodel`.`id`) 
										left JOIN `transport_bill_detail_rides` AS `TransportBillDetailRides` ON (`SheetRideDetailRides`.`transport_bill_detail_ride_id` = `TransportBillDetailRides`.`id`) 
										left JOIN `transport_bills` AS `TransportBill` ON (`TransportBill`.`id` = `TransportBillDetailRides`.`transport_bill_id`) 
									WHERE  ".$conditions." 
									order by `SheetRideDetailRides`.`id` ASC  limit 0,100";



        $conn = ConnectionManager::getDataSource('default');


        $sheetRideDetailRides = $conn->fetchAll($sqlSheetRideDetailRides);
        $missions = array();

        $i=0;
        $j=0;

        foreach ($sheetRideDetailRides  as $sheetRideDetailRide)
        {
            $retMission=$sheetRideDetailRide['SheetRideDetailRides']['return_mission'];
            $missions[$i]['reference']=$sheetRideDetailRide['SheetRideDetailRides']['reference'];
            $missions[$i]['id']=$sheetRideDetailRide['SheetRideDetailRides']['id'];
            $missions[$i]['datefr']=$sheetRideDetailRide['SheetRideDetailRides']['real_start_date'];
            $missions[$i]['datecmd']=$sheetRideDetailRide['TransportBill']['date'];
            if($sheetRideDetailRide['SheetRideDetailRides']['type_ride']==1){
                $missions[$i]['villedep']=$sheetRideDetailRide['DepartureDestination']['name'];
                $missions[$i]['villearriv']=$sheetRideDetailRide['ArrivalDestination']['name'];
            }
            else {
                $missions[$i]['villedep']=$sheetRideDetailRide['Departure']['name'];
                $missions[$i]['villearriv']=$sheetRideDetailRide['Arrival']['name'];
            }
            $missions[$i]['clientinit']=$sheetRideDetailRide['Supplier']['name'];
            $missions[$i]['clientinit_id']=$sheetRideDetailRide['Supplier']['id'];
            $missions[$i]['clientfin']=$sheetRideDetailRide['SupplierFinal']['name'];
            $missions[$i]['nomchauffeur']=$sheetRideDetailRide['Customer']['first_name'].' - '.$sheetRideDetailRide['Customer']['last_name'];
            $missions[$i]['idchauffeur']=$sheetRideDetailRide['SheetRide']['customer_id'];
            $missions[$i]['numtelchauffeur']=$sheetRideDetailRide['Customer']['mobile'];
            $missions[$i]['numveh']=$sheetRideDetailRide['Car']['code'];
            $missions[$i]['description']=$sheetRideDetailRide['SheetRideDetailRides']['note'];

            switch ($sheetRideDetailRide['SheetRide']['status_id']) {
                case 1:  $missions[$i]['statut'] = __('Planned') ;break;
                case 2:  $missions[$i]['statut'] =  __('In progress') ;break;
                case 3:  $missions[$i]['statut'] =  __('Back to the park') ;break;
                case 4:  $missions[$i]['statut'] =  __('Closed') ;break;
                case 9:  $missions[$i]['statut'] = __('Canceled') ;break;
                default: $missions[$i]['statut'] = __($missions[$i]['statut']) ; break;
            }

            $sqlAttachments = "SELECT
									`sat`.`supplier_id`,
									`at`.`id`,
									`at`.`name`
								FROM `supplier_attachment_types` AS `sat` JOIN `attachment_types` AS `at` ON(`sat`.`attachment_type_id` = `at`.`id`)
								WHERE sat.supplier_id='".$sheetRideDetailRide['Supplier']['id']."'";

            $attachments = $conn->fetchAll($sqlAttachments);
            $countAttach= count($attachments);
            $documents = array();
            for ($a= $j; $a<$countAttach ; $a++){
                if(($attachments[$a]['at']['id']==26 and $retMission==2) or ($attachments[$a]['at']['id']!=26)){
                    $documents[$a]['docname']= $attachments[$a]['at']['name'];
                    $documents[$a]['docnid']= $attachments[$a]['at']['id'];
                    $documents[$a]['clientinit_id']= $attachments[$a]['sat']['supplier_id'];
                }
            }
            $missions[$i]['DOCUMENT']=$documents;


            //***************attachement-----------------
            $sqlAttachments = "SELECT 
								`Attachment`.`article_id` ,                        
								`Attachment`.`attachment_type_id`,                        
								`Attachment`.`id`,
								`Attachment`.`name`,                         
								`Attachment`.`attachment_number`,
								`Attachment`.`validation`                        
	                        FROM  `attachments` AS `Attachment`  
	                        WHERE  Attachment.article_id = '".$missions[$i]['id']."'";

            $attachmentScannes = $conn->fetchAll($sqlAttachments);
            $atts = array();
            $x=0;
            foreach ($attachmentScannes  as $attachmentSC){
                $atts[$x]['attachment_id']= $attachmentSC['Attachment']['id'];
                $atts[$x]['mission_id']= $attachmentSC['Attachment']['article_id'];
                $atts[$x]['docname']= $attachmentSC['Attachment']['name'];
                $atts[$x]['attachment_number']= $attachmentSC['Attachment']['attachment_number'];
                $atts[$x]['attachment_type_id']= $attachmentSC['Attachment']['attachment_type_id'];
                $atts[$x]['validation']= $attachmentSC['Attachment']['validation'];
                $x++;
            }
            $missions[$i]['ATTACHMENT']=$atts;
            //****************************************

            $i++;
        }
        $missions = json_encode($missions);
        $this->response->type('json');
        $this->response->body($missions);
        return $this->response;

    }



    public function getAttachments( $customerId=null, $missionId= null){
        $conditions = '1=1 ';
        if(isset($missionId) && $missionId!='null'){
            $conditions = $conditions." && `SheetRideDetailRides`.`id` = ".$missionId;
        }
        if(isset($customerId) && $customerId!='null'){
            $conditions = $conditions." && `Customer`.`id` = ".$customerId;
        }





    $sqlAttachments = "SELECT 
                            `SheetRideDetailRides`.`id`,                        
                            `Attachment`.`attachment_type_id`,                        
                            `Attachment`.`id`,`Attachment`.`name`,                         
                            `Attachment`.`attachment_number`,`Attachment`.`validation`                        
                                        FROM  `attachments` AS `Attachment`  
                                        left JOIN `sheet_ride_detail_rides` AS `SheetRideDetailRides` ON (`SheetRideDetailRides`.`id` = `Attachment`.`article_id`) 
                                        left JOIN `sheet_rides` AS `SheetRide` ON (`SheetRide`.`id` = `SheetRideDetailRides`.`sheet_ride_id`) 
                                        left JOIN `customers` AS `Customer` ON (`SheetRide`.`customer_id` = `Customer`.`id`) 
                                        
                                        
                                        WHERE  ".$conditions." order by `SheetRideDetailRides`.`id` ASC     ";

        $conn = ConnectionManager::getDataSource('default');


        $attachments = $conn->fetchAll($sqlAttachments);

        $documents = array();
        $i=0;
        foreach ($attachments  as $attachment){
            $documents[$i]['attachment_id']= $attachment['Attachment']['id'];
            $documents[$i]['mission_id']= $attachment['SheetRideDetailRides']['id'];
            $documents[$i]['docname']= $attachment['Attachment']['name'];
            $documents[$i]['attachment_number']= $attachment['Attachment']['attachment_number'];
            $documents[$i]['attachment_type_id']= $attachment['Attachment']['attachment_type_id'];
            $documents[$i]['validation']= $attachment['Attachment']['validation'];


            $i++;

        }

         $documents = json_encode($documents);
                                $this->response->type('json');
         $this->response->body($documents);
         return $this->response;
    }
    public function getSheetRideDetailRidesByReference($reference=null)
    {

        if($reference==null){
            $feuilleRoute = json_encode(array());
            $this->response->type('json');
            $this->response->body($feuilleRoute);
            return $this->response;
        }
        $sheetRides =" SELECT SheetRides.*,customer.first_name,customer.last_name,Car.code,CarType.name                                           
						  FROM  
										`sheet_rides`  as SheetRides
										left JOIN `car` AS `Car` ON (`SheetRides`.`car_id` = `Car`.`id`) 
										left JOIN `car_types` AS `CarType` ON (`SheetRides`.`car_type_id` = `CarType`.`id`) 
										left JOIN `customers` AS `Customer` ON (`SheetRides`.`customer_id` = `Customer`.`id`) 
  						  WHERE   ( `SheetRides`.`reference` = '".$reference."' or `SheetRides`.`id` = '".$reference."') limit 0,1";


        $conn = ConnectionManager::getDataSource('default');


        $sheetRides = $conn->fetchAll($sheetRides);
        $feuilleRoute = array();

        $i=0;
        $j=0;

        foreach ($sheetRides  as $sheetRide)
        {
            $feuilleRoute[$i]['reference']=$sheetRide['SheetRides']['reference'];
            $id=$sheetRide['SheetRides']['id'];
            $feuilleRoute[$i]['id']=$id;
            $feuilleRoute[$i]['status_id']=$sheetRide['SheetRides']['status_id'];;
            $feuilleRoute[$i]['real_start_date']=$sheetRide['SheetRides']['real_start_date'];
            $feuilleRoute[$i]['real_end_date']=$sheetRide['SheetRides']['real_end_date'];
            $feuilleRoute[$i]['km_departure']=$sheetRide['SheetRides']['km_departure'];
            $feuilleRoute[$i]['km_arrival']=$sheetRide['SheetRides']['km_arrival'];
            $feuilleRoute[$i]['nomchauffeur']=$sheetRide['Customer']['first_name'].' - '.$sheetRide['Customer']['last_name'];
            $feuilleRoute[$i]['idchauffeur']=$sheetRide['SheetRides']['customer_id'];
            $feuilleRoute[$i]['typeVehicule']=$sheetRide['CarType']['name'];
            $feuilleRoute[$i]['numveh']=$sheetRide['Car']['code'];
            switch ($sheetRide['SheetRides']['status_id']) {
                case 1:  $feuilleRoute[$i]['statut'] = __('Planned') ;break;
                case 2:  $feuilleRoute[$i]['statut'] =  __('In progress') ;break;
                case 3:  $feuilleRoute[$i]['statut'] =  __('Back to the park') ;break;
                case 4:  $feuilleRoute[$i]['statut'] =  __('Closed') ;break;
                case 9:  $feuilleRoute[$i]['statut'] = __('Canceled') ;break;
                default: $feuilleRoute[$i]['statut'] = __($feuilleRoute[$i]['statut']) ; break;
            }
            $feuilleRoute[$i]['chauffeurAffrete'] =$sheetRide['SheetRides']['customer_name'];
            $feuilleRoute[$i]['vehiculeAffrete'] =$sheetRide['SheetRides']['car_subcontracting'];
            $sqlSheetRideDetailRides =" SELECT 
										`SheetRideDetailRides`.`reference`, 
										`SheetRideDetailRides`.`return_mission`, 
										`SheetRideDetailRides`.`id`,
										`SheetRideDetailRides`.`real_start_date`,
										`SheetRideDetailRides`.`real_end_date`,
										`TransportBill`.`date`, 
										`SheetRideDetailRides`.`type_ride`, 
										`DepartureDestination`.`name`, 
										`ArrivalDestination`.`name`, 
										`Departure`.`name`, 
										`Arrival`.`name`,
										`Supplier`.`name`, 
										`Supplier`.`id`, 
										`SupplierFinal`.`name`, 
										`SupplierFinal`.`id`, 
										`SheetRideDetailRides`.`note`  ,
										`SheetRideDetailRides`.`status_id`  ,
										`SheetRideDetailRides`.`km_departure`  ,
										`SheetRideDetailRides`.`km_arrival`  										
									FROM  
										`sheet_ride_detail_rides` AS `SheetRideDetailRides` 
										left JOIN `detail_rides` AS `DetailRide` ON (`SheetRideDetailRides`.`detail_ride_id` = `DetailRide`.`id`) 
										left JOIN `rides` AS `Ride` ON (`DetailRide`.`ride_id` = `Ride`.`id`) 
										left JOIN `destinations` AS `DepartureDestination` ON (`DepartureDestination`.`id` = `SheetRideDetailRides`.`departure_destination_id`) 
										left JOIN `destinations` AS `ArrivalDestination` ON (`ArrivalDestination`.`id` = `Ride`.`arrival_destination_id`) 
										left JOIN `destinations` AS `Departure` ON (`Departure`.`id` = `SheetRideDetailRides`.`departure_destination_id`) 
										left JOIN `destinations` AS `Arrival` ON (`Arrival`.`id` = `SheetRideDetailRides`.`arrival_destination_id`) 
										left JOIN `suppliers` AS `Supplier` ON (`SheetRideDetailRides`.`supplier_id` = `Supplier`.`id`) 
										left JOIN `suppliers` AS `SupplierFinal` ON (`SheetRideDetailRides`.`supplier_final_id` = `SupplierFinal`.`id`) 
										left JOIN `transport_bill_detail_rides` AS `TransportBillDetailRides` ON (`SheetRideDetailRides`.`transport_bill_detail_ride_id` = `TransportBillDetailRides`.`id`) 
										left JOIN `transport_bills` AS `TransportBill` ON (`TransportBill`.`id` = `TransportBillDetailRides`.`transport_bill_id`) 
									WHERE SheetRideDetailRides.sheet_ride_id='".$id."' order by `SheetRideDetailRides`.`reference`";



            $SheetRideDetailRides = $conn->fetchAll($sqlSheetRideDetailRides);
            $countMiss= count($SheetRideDetailRides);
            $missions = array();
            for ($a= $j; $a<$countMiss ; $a++){
                $missions[$a]['reference']= $SheetRideDetailRides[$a]['SheetRideDetailRides']['reference'];
                $missions[$a]['return_mission']= $SheetRideDetailRides[$a]['SheetRideDetailRides']['return_mission'];
                $missions[$a]['id']= $SheetRideDetailRides[$a]['SheetRideDetailRides']['id'];
                $missions[$a]['real_start_date']= $SheetRideDetailRides[$a]['SheetRideDetailRides']['real_start_date'];
                $missions[$a]['real_end_date']= $SheetRideDetailRides[$a]['SheetRideDetailRides']['real_end_date'];
                $missions[$a]['datecmd']= $SheetRideDetailRides[$a]['TransportBill']['date'];
                $missions[$a]['villedepart']= $SheetRideDetailRides[$a]['DepartureDestination']['name'];
                if($missions[$a]['villedepart']==null)$missions[$a]['villedepart']= $SheetRideDetailRides[$a]['Departure']['name'];
                $missions[$a]['villearrive']= $SheetRideDetailRides[$a]['ArrivalDestination']['name'];
                if($missions[$a]['villearrive']==null)$missions[$a]['villearrive']= $SheetRideDetailRides[$a]['Arrival']['name'];
                $missions[$a]['clientInit']= $SheetRideDetailRides[$a]['Supplier']['name'];
                $missions[$a]['clientinit_id']= $SheetRideDetailRides[$a]['Supplier']['id'];
                $missions[$a]['clientFin']= $SheetRideDetailRides[$a]['SupplierFinal']['name'];
                $missions[$a]['clientfin_id']= $SheetRideDetailRides[$a]['SupplierFinal']['id'];
                $missions[$a]['note']= $SheetRideDetailRides[$a]['SheetRideDetailRides']['note'];
                $missions[$a]['status_id']= $SheetRideDetailRides[$a]['SheetRideDetailRides']['status_id'];
                $missions[$a]['km_departure']= $SheetRideDetailRides[$a]['SheetRideDetailRides']['km_departure'];
                $missions[$a]['km_arrival']= $SheetRideDetailRides[$a]['SheetRideDetailRides']['km_arrival'];
            }
            $feuilleRoute[$i]['missions']=$missions;

            $i++;
        }
        $feuilleRoute = json_encode($feuilleRoute);
        $this->response->type('json');
        $this->response->body($feuilleRoute);
        return $this->response;

    }




    public function saveAttachment (){
        $attachmentName = $_POST['attachment_name'];
        $tmpName = $_POST['tmp_name'];
        $tmpName = base64_decode($tmpName);
        $attachmentNumber  = $_POST['attachment_number'];
        $missionId  = $_POST['mission_id'];
        $attachmentTypeId  = $_POST['attachment_type_id'];
        $this->request->data['Attachment'][$attachmentTypeId]['name'] = $attachmentName;
        $this->request->data['Attachment'][$attachmentTypeId]['tmp_name'] = $tmpName;

        /*$this->verifyAttachmentByType('Attachment', $attachmentTypeId,
            'attachments/missions/' . $attachmentTypeId . '/', 'add', 0, 0, null);*/
        $root=dirname(__DIR__) . DS . "webroot" . DS . '/attachments/missions/'. $attachmentTypeId . '/'.$attachmentName;
        // echo $root;
        file_put_contents($root, $tmpName);

        $attachment = array();
        $attachment['Attachment']['attachment_number'] = $attachmentNumber;
        $attachment['Attachment']['name'] = $attachmentName;
        $attachment['Attachment']['article_id'] = $missionId;
        $attachment['Attachment']['attachment_type_id'] = $attachmentTypeId;
        $this->Attachment->save($attachment);
        die();
    }

    public function getMissionsByKeyWord(){
        $this->autoRender = false;

        // get the search term from URL
        $term = $this->request->query['q'];

        //$term = '001';

            $conds = array(
                " CONVERT(SheetRideDetailRides.reference USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term%",
            );


        $sheetRideDetailRides = $this->SheetRideDetailRides->find('all',
            array(
                'recursive'=>-1,
                'fields'=>array('SheetRideDetailRides.id','SheetRideDetailRides.reference'),
                'conditions'=>$conds
            ));

        $data = array();
        $i = 0;
        $data[$i]['id'] = "";
        $data[$i]['text'] = "";
        $i++;
        foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
            $data[$i]['id'] = $sheetRideDetailRide['SheetRideDetailRides']['id'];
            $data[$i]['text'] = $sheetRideDetailRide['SheetRideDetailRides']['reference'];
            $i++;
        }

        echo json_encode($data);
    }

    public function getRidesFromCustomerOrder(
        $type = '0',
        $transportBillDetailRideId = null,
        $detailRideId = null,
        $statusMission = null
    )
    {
        $this->layout = 'ajax';
        $this->set('detail_ride_id', $detailRideId);
        $this->set('statusMission', $statusMission);
        $this->set('transport_bill_detail_ride_id', $transportBillDetailRideId);

        if ($type != '0') {

            $conditions = array(
                'AND' => array(
                    'OR' => array(

                        'TransportBillDetailRides.is_open' => 0,
                        array('TransportBillDetailRides.is_open ' => 1, 'TransportBillDetailRides.last_opener' => $this->Auth->user('id'))
                    ),
                ),
                'OR' => array(
                    'TransportBillDetailRides.status_id' => array(1, 2),
                    'TransportBillDetailRides.id' => $transportBillDetailRideId
                ),
                'TransportBill.type' => 2,
                "DetailRide.car_type_id" => $type
            );

        } else {

            $conditions = array(
                'AND' => array(
                    'OR' => array(

                        'TransportBillDetailRides.is_open' => 0,
                        array('TransportBillDetailRides.is_open ' => 1, 'TransportBillDetailRides.last_opener' => $this->Auth->user('id'))
                    ),
                ),
                'OR' => array(
                    'TransportBillDetailRides.status_id' => array(1, 2),
                    'TransportBillDetailRides.id' => $transportBillDetailRideId
                ),
                'TransportBill.type' => 2,
                "DetailRide.car_type_id" => $type
            );

        }


        $this->TransportBillDetailRides->DetailRide->virtualFields = array(
            'cnames' => "IFNULL(CONCAT(TransportBillDetailRides.reference, ' - ',DepartureDestination.name, ' - ', ArrivalDestination.name, ' - ',CarType.name, ' - ',Supplier.name ),CONCAT(DepartureDestination.name, ' - ', ArrivalDestination.name, ' - ',CarType.name , ' - ', Supplier.name ))"
        );

        $detailRides = $this->TransportBillDetailRides->DetailRide->find('list', array(
            'recursive' => -1,
            'conditions' => $conditions,
            'fields' => array('TransportBillDetailRides.id', 'cnames'),
            'joins' => array(
                array(
                    'table' => 'transport_bill_detail_rides',
                    'type' => 'left',
                    'alias' => 'TransportBillDetailRides',
                    'conditions' => array('TransportBillDetailRides.detail_ride_id = DetailRide.id')
                ),
                array(
                    'table' => 'observations',
                    'type' => 'left',
                    'alias' => 'Observation',
                    'conditions' => array('TransportBillDetailRides.id = Observation.transport_bill_detail_ride_id')
                ),
                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('TransportBillDetailRides.transport_bill_id = TransportBill.id')
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
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Supplier.id = TransportBill.supplier_id')
                )
            )
        ));

        $this->set('detailRides', $detailRides);


    }

    public function getPersonalizedRidesFromCustomerOrder( $type = '0', $transportBillDetailRideId = null, $statusMission = null
    )
    {

        $this->layout = 'ajax';
        $this->set('statusMission', $statusMission);
        $this->set('transport_bill_detail_ride_id', $transportBillDetailRideId);

        if ($type != '0') {

            $conditions = array(
                'AND' => array(
                    'OR' => array(

                        'TransportBillDetailRides.is_open' => 0,
                        array('TransportBillDetailRides.is_open ' => 1, 'TransportBillDetailRides.last_opener' => $this->Auth->user('id'))
                    ),
                ),
                'OR' => array(
                    'TransportBillDetailRides.status_id' => array(1, 2),
                    'TransportBillDetailRides.id' => $transportBillDetailRideId
                ),
                'TransportBill.type' => 2,
                "TransportBillDetailRides.car_type_id" => $type,
                "TransportBillDetailRides.type_ride" => 2
            );

        } else {

            $conditions = array(
                'AND' => array(
                    'OR' => array(
                        'TransportBillDetailRides.is_open' => 0,
                        array('TransportBillDetailRides.is_open ' => 1, 'TransportBillDetailRides.last_opener' => $this->Auth->user('id'))
                    ),
                ),
                'OR' => array(
                    'TransportBillDetailRides.status_id' => array(1, 2),
                    'TransportBillDetailRides.id' => $transportBillDetailRideId
                ),
                'TransportBill.type' => 2,
                "TransportBillDetailRides.car_type_id" => $type,
                "TransportBillDetailRides.type_ride" => 2
            );

        }

        if(isset($statusMission) && ($statusMission>7)){
            $this->TransportBillDetailRides->virtualFields = array(
                'cnames' => "IFNULL(CONCAT(TransportBillDetailRides.reference, ' - ',Departure.name, ' - ', IFNULL(Arrival.name,''), ' - ',Type.name , ' - ',Supplier.name),CONCAT(Departure.name, ' - ', IFNULL(Arrival.name,''), ' - ',Type.name, ' - ',Supplier.name ))"
            );
            $detailRides = $this->TransportBillDetailRides->find('list', array(
                'recursive' => -1,
                'conditions' => $conditions,
                'fields' => array('TransportBillDetailRides.id', 'cnames'),
                'joins' => array(
                    array(
                        'table' => 'observations',
                        'type' => 'left',
                        'alias' => 'Observation',
                        'conditions' => array('TransportBillDetailRides.id = Observation.transport_bill_detail_ride_id')
                    ),
                    array(
                        'table' => 'transport_bills',
                        'type' => 'left',
                        'alias' => 'TransportBill',
                        'conditions' => array('TransportBillDetailRides.transport_bill_id = TransportBill.id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'Type',
                        'conditions' => array('TransportBillDetailRides.car_type_id = Type.id')
                    ),

                    array(
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'Departure',
                        'conditions' => array('Departure.id = TransportBillDetailRides.departure_destination_id')
                    ),
                    array(
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'Arrival',
                        'conditions' => array('Arrival.id = TransportBillDetailRides.arrival_destination_id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('Supplier.id = TransportBill.supplier_id')
                    ),
                )
            ));
            $this->set('detailRides', $detailRides);

        } else {


            $this->TransportBillDetailRides->virtualFields = array(
                'cnames' => "IFNULL(CONCAT(TransportBillDetailRides.reference, ' - ',Departure.name, ' - ', IFNULL(Arrival.name,''), ' - ',Type.name , ' - ',Supplier.name),CONCAT(Departure.name, ' - ', IFNULL(Arrival.name,''), ' - ',Type.name, ' - ',Supplier.name ))"
            );
            $detailRides = $this->TransportBillDetailRides->find('list', array(
                'recursive' => -1,
                'conditions' => $conditions,
                'fields' => array('TransportBillDetailRides.id', 'cnames'),
                'joins' => array(
                    array(
                        'table' => 'observations',
                        'type' => 'left',
                        'alias' => 'Observation',
                        'conditions' => array('TransportBillDetailRides.id = Observation.transport_bill_detail_ride_id')
                    ),
                    array(
                        'table' => 'transport_bills',
                        'type' => 'left',
                        'alias' => 'TransportBill',
                        'conditions' => array('TransportBillDetailRides.transport_bill_id = TransportBill.id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'Type',
                        'conditions' => array('TransportBillDetailRides.car_type_id = Type.id')
                    ),

                    array(
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'Departure',
                        'conditions' => array('Departure.id = TransportBillDetailRides.departure_destination_id')
                    ),
                    array(
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'Arrival',
                        'conditions' => array('Arrival.id = TransportBillDetailRides.arrival_destination_id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('Supplier.id = TransportBill.supplier_id')
                    ),
                )
            ));
            if(!empty($transportBillDetailRideId)){
                $transportBillDetailRide = $this->TransportBillDetailRides->getTransportBillDetailRidesById($transportBillDetailRideId);
                $departures = $this->Destination->getDestinationsByConditions(array('Destination.id' => $transportBillDetailRide['TransportBillDetailRides']['departure_destination_id']), 'list');
                $arrivals = $this->Destination->getDestinationsByConditions(array('Destination.id' => $transportBillDetailRide['TransportBillDetailRides']['arrival_destination_id']), 'list');

            }

            $this->set(compact('transportBillDetailRide','departures', 'arrivals','detailRides'));
        }

    }


    function getInformationRide(
        $rideId = null,
        $i = null,
        $from_customer_order = null,
        $truckFull = null,
        $rideCategoryId = null,
        $departureDestinationId = null,
        $arrivalDestinationId = null,
        $carTypeId= null
    )
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        /*if $from_customer_order==1 : the ride will be recover from customer order
		$rideId = id of customer order (TransportBillDetailRide);
		*/
        $this->set('truckFull', $truckFull);
        $this->set('rideCategoryId', $rideCategoryId);
        if ($rideId != '0' && $rideId != 'undefined') {
            if ($from_customer_order == 1) {
                $transportBillDetailRideId = $rideId;
                $this->set('transportBillDetailRideId', $transportBillDetailRideId);
                $sheetRideDetailRides = $this->SheetRideDetailRides->find('all', array(
                    'recursive' => -1, // should be used with joins
                    'conditions' => array('SheetRideDetailRides.transport_bill_detail_ride_id' => $rideId),
                    'fields' => array('SheetRideDetailRides.observation_id')
                ));
                $observationIdsWithMissions = array();
                foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
                    $observationIdsWithMissions[] = $sheetRideDetailRide['SheetRideDetailRides']['observation_id'];
                }
                if (!empty($observationIdsWithMissions)) {
                    $conditions = array('Observation.transport_bill_detail_ride_id' => $rideId,
                        'Observation.id !=' => $observationIdsWithMissions
                    );
                } else {
                    $conditions = array('Observation.transport_bill_detail_ride_id' => $rideId);
                }
                $observations = $this->Observation->getObservationsByConditions($conditions, 'list');

                $this->set('observations', $observations);
                // detail ride of customer order selected
                $detail_ride = $this->TransportBillDetailRides->find('first', array(
                    'conditions' => array('TransportBillDetailRides.id' => $rideId),
                    'fields' => array('TransportBillDetailRides.type_ride',
                        'TransportBillDetailRides.detail_ride_id',
                        'TransportBillDetailRides.departure_destination_id',
                        'TransportBillDetailRides.arrival_destination_id',
                        'TransportBillDetailRides.car_type_id',
                    )
                ));
                // modifier status od is_open
                $this->isOpenedByOtherUser("TransportBillDetailRides", 'SheetRides', 'transport bill',
                    $rideId);
                if ($detail_ride['TransportBillDetailRides']['type_ride'] == 2) {
                    $departureId = $detail_ride['TransportBillDetailRides']['departure_destination_id'];
                    $arrivalId = $detail_ride['TransportBillDetailRides']['arrival_destination_id'];
                    $carTypeId = $detail_ride['TransportBillDetailRides']['car_type_id'];

                    $ride = $this->SheetRideDetailRides->DetailRide->find('first',
                        array(
                            'conditions' => array(
                                'OR' => array(
                                    array(
                                        'DepartureDestination.id' => $departureId,
                                        'ArrivalDestination.id' => $arrivalId,
                                        'DetailRide.car_type_id' => $carTypeId,
                                    ),
                                    array(
                                        'DepartureDestination.id' => $arrivalId,
                                        'ArrivalDestination.id' => $departureId ,
                                        'DetailRide.car_type_id' => $carTypeId,
                                    )
                                )
                            ),
                            'recursive' => -1,
                            'fields' => array(
                                'DetailRide.real_duration_hour',
                                'DetailRide.real_duration_day',
                                'DetailRide.real_duration_minute',
                                'DetailRide.duration_hour',
                                'DetailRide.duration_day',
                                'DetailRide.duration_minute',
                                'DepartureDestination.name',
                                'DepartureDestination.latlng'
                            ),
                            'joins' => array(
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
                                    'conditions' => array('Ride.departure_destination_id = DepartureDestination.id')
                                ),
                                array(
                                    'table' => 'destinations',
                                    'type' => 'left',
                                    'alias' => 'ArrivalDestination',
                                    'conditions' => array('Ride.arrival_destination_id = ArrivalDestination.id')
                                ),

                            )
                        )
                    );
                    $distance_ride = $this->SheetRideDetailRides->DetailRide->find('first', array(
                        'conditions' => array(
                            'OR' => array(
                                array(
                                    'DepartureDestination.id' => $departureId,
                                    'ArrivalDestination.id' => $arrivalId,
                                    'DetailRide.car_type_id' => $carTypeId,
                                ),
                                array(
                                    'DepartureDestination.id' => $arrivalId,
                                    'ArrivalDestination.id' => $departureId ,
                                    'DetailRide.car_type_id' => $carTypeId,
                                )
                            )
                        ),
                        'recursive' => -1,
                        'fields' => array('Ride.distance'),
                        'joins' => array(
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
                                'conditions' => array('Ride.departure_destination_id = DepartureDestination.id')
                            ),
                            array(
                                'table' => 'destinations',
                                'type' => 'left',
                                'alias' => 'ArrivalDestination',
                                'conditions' => array('Ride.arrival_destination_id = ArrivalDestination.id')
                            ),
                        )
                    ));
                } else {
                    $rideId = $detail_ride['TransportBillDetailRides']['detail_ride_id'];

                    $ride = $this->SheetRideDetailRides->DetailRide->find('first',
                        array(
                            'conditions' => array('DetailRide.id' => $rideId),
                            'recursive' => -1,
                            'fields' => array(
                                'DetailRide.real_duration_hour',
                                'DetailRide.real_duration_day',
                                'DetailRide.real_duration_minute',
                                'DetailRide.duration_hour',
                                'DetailRide.duration_day',
                                'DetailRide.duration_minute',
                                'DepartureDestination.name',
                                'DepartureDestination.latlng'
                            ),
                            'joins' => array(
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
                                    'conditions' => array('Ride.departure_destination_id = DepartureDestination.id')
                                ),

                            )
                        )
                    );
                    $distance_ride = $this->SheetRideDetailRides->DetailRide->find('first', array(
                        'conditions' => array('DetailRide.id' => $rideId),
                        'recursive' => -1,
                        'fields' => array('Ride.distance'),
                        'joins' => array(
                            array(
                                'table' => 'rides',
                                'type' => 'left',
                                'alias' => 'Ride',
                                'conditions' => array('DetailRide.ride_id = Ride.id')
                            )
                        )
                    ));
                }

            } else {
                $ride = $this->SheetRideDetailRides->DetailRide->find('first',
                    array(
                        'conditions' => array('DetailRide.id' => $rideId),
                        'recursive' => -1,
                        'fields' => array(
                            'DetailRide.real_duration_hour',
                            'DetailRide.real_duration_day',
                            'DetailRide.real_duration_minute',
                            'DetailRide.duration_hour',
                            'DetailRide.duration_day',
                            'DetailRide.duration_minute',
                            'DepartureDestination.name',
                            'DepartureDestination.latlng'
                        ),
                        'joins' => array(
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
                                'conditions' => array('Ride.departure_destination_id = DepartureDestination.id')
                            ),

                        )
                    )
                );
                $distance_ride = $this->SheetRideDetailRides->DetailRide->find('first', array(
                    'conditions' => array('DetailRide.id' => $rideId),
                    'recursive' => -1,
                    'fields' => array('Ride.distance'),
                    'joins' => array(
                        array(
                            'table' => 'rides',
                            'type' => 'left',
                            'alias' => 'Ride',
                            'conditions' => array('DetailRide.ride_id = Ride.id')
                        )
                    )
                ));
            }
            if (!empty($ride)) {
                $this->set('ride', $ride);
            }
            if (!empty($distance_ride)) {
                $this->set('distance_ride', $distance_ride);
            }
        } else {

            $conds = array('Destination.id' => $departureDestinationId);
            $departureDestination = $this->Destination->getDestinationsByConditions($conds, 'first');
            $conds = array('Destination.id' => $arrivalDestinationId);
            $arrivalDestination = $this->Destination->getDestinationsByConditions($conds, 'first');

            $ride = $this->SheetRideDetailRides->DetailRide->find('first',
                array(
                    'conditions' => array(
                        'OR' => array(
                            array(
                                'DepartureDestination.id' => $departureDestinationId,
                                'ArrivalDestination.id' => $arrivalDestinationId,
                                'DetailRide.car_type_id' => $carTypeId,
                            ),
                            array(
                                'DepartureDestination.id' => $arrivalDestinationId,
                                'ArrivalDestination.id' => $departureDestinationId ,
                                'DetailRide.car_type_id' => $carTypeId,
                            )
                        )
                    ),
                    'recursive' => -1,
                    'fields' => array(
                        'DetailRide.real_duration_hour',
                        'DetailRide.real_duration_day',
                        'DetailRide.real_duration_minute',
                        'DetailRide.duration_hour',
                        'DetailRide.duration_day',
                        'DetailRide.duration_minute',
                        'DepartureDestination.name',
                        'DepartureDestination.latlng'
                    ),
                    'joins' => array(
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
                            'conditions' => array('Ride.departure_destination_id = DepartureDestination.id')
                        ),
                        array(
                            'table' => 'destinations',
                            'type' => 'left',
                            'alias' => 'ArrivalDestination',
                            'conditions' => array('Ride.arrival_destination_id = ArrivalDestination.id')
                        ),

                    )
                )
            );
            $distance_ride = $this->SheetRideDetailRides->DetailRide->find('first', array(
                'conditions' => array(
                    'OR' => array(
                        array(
                            'DepartureDestination.id' => $departureDestinationId,
                            'ArrivalDestination.id' => $arrivalDestinationId,
                            'DetailRide.car_type_id' => $carTypeId,
                        ),
                        array(
                            'DepartureDestination.id' => $arrivalDestinationId,
                            'ArrivalDestination.id' => $departureDestinationId ,
                            'DetailRide.car_type_id' => $carTypeId,
                        )
                    )
                ),
                'recursive' => -1,
                'fields' => array('Ride.distance'),
                'joins' => array(
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
                        'conditions' => array('Ride.departure_destination_id = DepartureDestination.id')
                    ),
                    array(
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'ArrivalDestination',
                        'conditions' => array('Ride.arrival_destination_id = ArrivalDestination.id')
                    )
                )
            ));
            $this->set(compact('departureDestination', 'arrivalDestination','ride','distance_ride'));
        }

        $this->set(compact('i', 'rideId'));

    }

    // get rides of conductors  by date

    public function getClientInitialFromCustomerOrder($rideId = null)
    {

// $ride_id c'est le id du transportBillDetailRide
        $supplier_initials = $this->Supplier->find('first', array(
            'recursive' => -1,
            'conditions' => array('TransportBillDetailRides.id' => $rideId),
            'fields' => array('Supplier.id'),
            'joins' => array(


                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('Supplier.id = TransportBill.supplier_id')
                ),
                array(
                    'table' => 'transport_bill_detail_rides',
                    'type' => 'left',
                    'alias' => 'TransportBillDetailRides',
                    'conditions' => array('TransportBill.id = TransportBillDetailRides.transport_bill_id')
                ),
            )
        ));


        $suppliers = $this->Supplier->getSuppliersByParams(1, 1);

        $this->set(compact('supplier_initials', 'supplier_finals', 'suppliers'));

    }


// get rides of conductors by km

    public function getClientFinalFromCustomerOrder($rideId = null)
    {

        $supplier_finals = $this->Supplier->find('first', array(
            'recursive' => -1,
            'conditions' => array('TransportBillDetailRides.id' => $rideId),
            'fields' => array('Supplier.id'),
            'joins' => array(
                array(
                    'table' => 'transport_bill_detail_rides',
                    'type' => 'left',
                    'alias' => 'TransportBillDetailRides',
                    'conditions' => array('Supplier.id = TransportBillDetailRides.supplier_final_id')
                )
            )
        ));
        $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
        $this->set(compact('supplier_finals', 'suppliers'));

    }


    public function getClientInitial()
    {
        if (Configure::read("gestion_commercial") == '1') {
            $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validate;
        }else {
            $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validatePersonalizedRide;
        }

    }

    public function getClientFinal()
    {
    }
    public function getMissionCost($detailRideId = null, $fromCustomerOrder = null, $rideCategoryId = null)
    {
        $missionCost = null;
        if ($detailRideId != 0) {
            $managementParameterMissionCost = $this->getManagementParameterMissionCost();
            if ($fromCustomerOrder == 1) {
                // detail ride of customer order selected
                $detailRide = $this->TransportBillDetailRides->find('first', array(
                    'conditions' => array('TransportBillDetailRides.id' => $detailRideId),
                    'fields' => array('TransportBillDetailRides.detail_ride_id')));
                // modifier status od is_open
                $detailRideId = $detailRide['TransportBillDetailRides']['detail_ride_id'];
            }
            switch ($managementParameterMissionCost) {
                case '1':
                    $missionCost = $this->SheetRide->getMissionCostByDay($detailRideId);
                    break;
                case '2':
                    $missionCost = $this->SheetRide->getMissionCostByDestination($detailRideId);
                    break;
                case '3':
                    $missionCost = $this->SheetRide->getMissionCostByDistance($detailRideId, $rideCategoryId);
                    break;
            }
            $displayMissionCost = $this->isDisplayMissionCost();
            $this->set(compact('missionCost', 'displayMissionCost', 'managementParameterMissionCost', 'detailRideId'));
            return $missionCost;
        }
        $this->set(compact('detailRideId'));

    }

    function getRidesByType( $type = null, $detailRideId = null, $rideCategoryId = null)
    {
        if (Configure::read("gestion_commercial") != '1') {
            $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validatePersonalizedRide;
        }

        $this->setTimeActif();
        $this->layout = 'ajax';
        $this->set('detail_ride_id', $detailRideId);
        $this->set('ride_category_id', $rideCategoryId);
        $this->SheetRideDetailRides->DetailRide->virtualFields = array('cnames' => "CONCAT(DepartureDestination.name, ' - ', ArrivalDestination.name,' - ',CarType.name)");
        $detailRides = array();

        $rideCategories = $this->RideCategory->getRideCategories();

        $useRideCategory = $this->useRideCategory();
        $this->set(compact('rideCategories', 'detailRides', 'useRideCategory', 'type'));
    }

    public function getPersonalizedRide()
    {
        $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validatePersonalizedRide;

    }

    public function getSavedMarchandises($clientId = null,  $sheetRideDetailRideId = null)
    {
        if ($sheetRideDetailRideId != null) {
            $selectedMarchandises = $this->SheetRideDetailRideMarchandise->find('all', array(
                'recursive' => -1,
                'fields' => array(
                    'SheetRideDetailRideMarchandise.id',
                    'SheetRideDetailRideMarchandise.marchandise_id',
                    'SheetRideDetailRideMarchandise.quantity',
                    'Marchandise.name',
                    'Marchandise.weight',
                    'Marchandise.weight_palette'
                ),
                'conditions' => array('SheetRideDetailRideMarchandise.sheet_ride_detail_ride_id' => $sheetRideDetailRideId),
                'joins' => array(
                    array(
                        'table' => 'marchandises',
                        'type' => 'left',
                        'alias' => 'Marchandise',
                        'conditions' => array('Marchandise.id = SheetRideDetailRideMarchandise.marchandise_id')
                    ),
                )
            ));
            $nbMarchandise = $this->SheetRideDetailRideMarchandise->find('count', array(
                'recursive' => -1,
                'conditions' => array('SheetRideDetailRideMarchandise.sheet_ride_detail_ride_id' => $sheetRideDetailRideId),
            ));
        }
        $marchandises = $this->Marchandise->find('list',
            array(
                'recursive' => -1,
                'order' => 'name ASC',
                'conditions' => array('Marchandise.supplier_id' => $clientId)
            ));
        if (empty($marchandises)) {
            $marchandises = $this->Marchandise->find('list', array('recursive' => -1, 'order' => 'name ASC'));
        }

        $fieldMarchandiseRequired = $this->Parameter->getCodesParameterVal('marchandise_required');

        $this->set(compact('selectedMarchandises', 'marchandises', 'nbMarchandise','fieldMarchandiseRequired'));
    }

    public function getAttachmentsByClient($clientId = null, $sheetRideDetailRideId = null)
    {

        $attachmentDisplaySheetRide = $this->Parameter->getCodesParameterVal('attachment_display_sheet_ride');
        if($attachmentDisplaySheetRide==1){
            $attachmentTypes = $this->AttachmentType->getAttachmentTypeBySupplierId($clientId, 'all');
            if(empty($attachmentTypes)){
                $client =$this->Supplier->getSuppliersById($clientId,'first');
                $supplierCategoryId = $client['Supplier']['supplier_category_id'];
                if(!empty($supplierCategoryId)){
                    $attachmentTypes = $this->AttachmentType->getAttachmentTypeBySupplierCategoryId($supplierCategoryId, 'all');

                }
            }
        }else {
            $this->loadModel('ParameterAttachmentType');
            $attachmentTypes = $this->ParameterAttachmentType->getParameterAttachmentTypes();

        }

        if ($sheetRideDetailRideId != null) {
            $attachments = $this->Attachment->getAttachmentsBySheetRideDetailRideId($sheetRideDetailRideId);
            $this->set(compact('attachments'));
        }

        $this->set(compact('attachmentTypes', 'sheetRideDetailRideId'));
        return $attachmentTypes;
    }

    public function getLots( $sheetRideDetailRideId = null)
    {
        $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
        if ($usePurchaseBill == 1) {
            if ($sheetRideDetailRideId != null) {
                $selectedLots = $this->Lot->getLotsBySheetRideDetailRideId($sheetRideDetailRideId, 'all');
                $lotIds = array();
                if (!empty($selectedLots)) {
                    foreach ($selectedLots as $selectedLot) {
                        $lotIds [] = $selectedLot['Lot']['id'];
                    }
                }
                if (!empty($lotIds)) {

                    $lotConditions = array('Product.with_lot' => 1,
                        'OR' => array(
                            array('Lot.quantity >=' => 1),
                            array('Lot.id' => $lotIds),
                        ));
                } else {
                    $lotConditions = array('Product.with_lot' => 1, 'Lot.quantity >=' => 1);
                }
                $lots = $this->Lot->getLotsByConditions($lotConditions);
            } else {
                $lotConditions = array('Product.with_lot' => 1, 'Lot.quantity >=' => 1);
                $lots = $this->Lot->getLotsByConditions($lotConditions);
            }
            $this->set(compact('lots', 'lotIds', 'sheetRideDetailRideId'));
        }
    }

    public function addOtherMarchandises($clientId = null, $i = null)
    {
        $marchandises = $this->Marchandise->find('list',
            array(
                'recursive' => -1,
                'order' => 'name ASC',
                'conditions' => array('Marchandise.supplier_id' => $clientId)
            ));
        if (empty($marchandises)) {
            $marchandises = $this->Marchandise->find('list', array('recursive' => -1, 'order' => 'name ASC'));
        }
        $fieldMarchandiseRequired = $this->Parameter->getCodesParameterVal('marchandise_required');
        $this->set(compact('i', 'marchandises','fieldMarchandiseRequired'));
    }

    public function getWeightByMarchandise($marchandiseId = null,  $i = null)
    {
        $marchandise = $this->Marchandise->find('first', array(
            'recursive' => -1,
            'fields' => array('Marchandise.weight_palette', 'Marchandise.weight'),
            'conditions' => array('Marchandise.id' => $marchandiseId)
        ));
        $this->set(compact('marchandise', 'i'));
    }

    public function getFinalSupplierByInitialSupplier($supplierId = null, $supplierFinalId=null)
    {
        $finalSuppliers = $this->Supplier->getFinalSuppliersByInitialSupplier($supplierId);
        $this->set(compact('finalSuppliers',  'supplierId','supplierFinalId'));
    }

    public function getMarchandisesByClient($clientId = null, $nbMarchandise = null)
    {
        $this->set('i', $nbMarchandise);
        $marchandises = $this->Marchandise->find('list',
            array(
                'recursive' => -1,
                'order' => 'name ASC',
                'conditions' => array('Marchandise.supplier_id' => $clientId)
            ));
        if (empty($marchandises)) {
            $marchandises = $this->Marchandise->find('list', array('recursive' => -1, 'order' => 'name ASC'));
        }
        $fieldMarchandiseRequired = $this->Parameter->getCodesParameterVal('marchandise_required');
        $this->set(compact( 'marchandises','fieldMarchandiseRequired'));
    }

    public function closedMissions()
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validateSearch;
        $conditions = ' slip_id is  NULL ';
        $supplier = '';
        if ($this->request->is('post')) {
            if (
                isset($this->request->data['sheet_ride_detail_rides']['supplier_id']) ||
                isset($this->request->data['sheet_ride_detail_rides']['subcontractor_id']) ||
                isset($this->request->data['sheet_ride_detail_rides']['order_type']) ||
                isset($this->request->data['sheet_ride_detail_rides']['detail_ride_id'])
            ) {
               // $this->filterUrl();
               // var_dump($this->request->data); die();
                $supplier = $this->request->data['sheet_ride_detail_rides']['supplier_id'];
                $detailRide = $this->request->data['sheet_ride_detail_rides']['detail_ride_id'];
                $subcontractor = $this->request->data['sheet_ride_detail_rides']['subcontractor_id'];
                $orderType = $this->request->data['sheet_ride_detail_rides']['order_type'];
                if (!empty($supplier)) {
                    $conditions .= " && SheetRideDetailRides.supplier_id = $supplier  ";
                }
                if (!empty($detailRide)) {
                    $conditions .= " && SheetRideDetailRides.detail_ride_id = $detailRide  ";
                }
                if (!empty($subcontractor)) {
                    $conditions .= " && SheetRide.supplier_id = $subcontractor  ";
                }
                if (!empty($orderType)) {
                    $conditions .= " && TransportBill.order_type = $orderType  ";
                }
            }
        }

        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'conditions' => $conditions,
            'order'=>array('SheetRideDetailRides.id DESC'),
            'fields' => array(
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.real_start_date',
                'SheetRideDetailRides.planned_start_date',
                'SheetRideDetailRides.type_ride',
                'SheetRideDetailRides.note',
                'SheetRideDetailRides.final_customer',
                'SheetRideDetailRides.number_delivery_note',
                'SheetRideDetailRides.number_invoice',
                'SheetRide.car_subcontracting',
                'SheetRide.car_name',
                'SheetRide.customer_name',
                'CarType.name',
                'Supplier.name',
                'SupplierFinal.name',
                'Subcontractor.name',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Departure.name',
                'Arrival.name',
                'Car.code',
                'Customer.first_name',
                'Customer.last_name',
                'Car.immatr_def',
                'Carmodel.name',
            ),
            'joins' => array(
                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('SheetRide.id = SheetRideDetailRides.sheet_ride_id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Subcontractor',
                    'conditions' => array('SheetRide.supplier_id = Subcontractor.id')
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
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Departure',
                    'conditions' => array('Departure.id = SheetRideDetailRides.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Arrival',
                    'conditions' => array('Arrival.id = SheetRideDetailRides.arrival_destination_id')
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
                array(
                    'table' => 'transport_bill_detailed_rides',
                    'type' => 'left',
                    'alias' => 'TransportBillDetailedRides',
                    'conditions' => array('TransportBillDetailedRides.sheet_ride_id = SheetRide.id')
                ),
                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('TransportBillDetailedRides.transport_bill_id = TransportBill.id')
                ),
            )
        );
        $closedMissions = $this->Paginator->paginate('SheetRideDetailRides');
        $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
        $subcontractors = $this->Supplier->getSuppliersByParams(0, 1,SupplierCategoriesEnum::SUBCONTRACTOR);
        //get default user limit value

        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set(compact( 'type', 'param','conditions','closedMissions','supplier','suppliers','subcontractors'));
        $this->render();
    }


    function updateFinalCustomer()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $value = filter_input(INPUT_POST, "value");
        $crypto = $this->decrypt(filter_input(INPUT_POST, "crypto"));
        $explode = explode('|', $crypto);
        $id = $explode[1];
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::mission, $userId, ActionsEnum::edit, "SheetRideDetailRides",
            $id, "SheetRideDetailRides", null,1);
        if($result){
            $this->SheetRideDetailRides->id = $id;
            if ($this->SheetRideDetailRides->saveField('final_customer', $value)){
                echo json_encode(array("response" => true));
            }else {
                echo json_encode(array("response" => false));
            }
        }else {
            echo json_encode(array("response" => false));
        }



    }

    function updateNumberDeliveryNote()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $value = filter_input(INPUT_POST, "value");
        $crypto = $this->decrypt(filter_input(INPUT_POST, "crypto"));
        $explode = explode('|', $crypto);
        $id = $explode[1];
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::mission, $userId, ActionsEnum::edit, "SheetRideDetailRides",
            $id, "SheetRideDetailRides", null,1);
        if($result){
            $this->SheetRideDetailRides->id = $id;
            if ($this->SheetRideDetailRides->saveField('number_delivery_note', $value)){
                echo json_encode(array("response" => true));
            }else {
                echo json_encode(array("response" => false));
            }
        }else {
            echo json_encode(array("response" => false));
        }



    }

    function updateNumberInvoice()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $value = filter_input(INPUT_POST, "value");
        $crypto = $this->decrypt(filter_input(INPUT_POST, "crypto"));
        $explode = explode('|', $crypto);
        $id = $explode[1];
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::mission, $userId, ActionsEnum::edit, "SheetRideDetailRides",
            $id, "SheetRideDetailRides", null,1);
        if($result){
            $this->SheetRideDetailRides->id = $id;
            if ($this->SheetRideDetailRides->saveField('number_invoice', $value)){
                echo json_encode(array("response" => true));
            }else {
                echo json_encode(array("response" => false));
            }
        }else {
            echo json_encode(array("response" => false));
        }



    }

    function updateNote()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $value = filter_input(INPUT_POST, "value");
        $crypto = $this->decrypt(filter_input(INPUT_POST, "crypto"));
        $explode = explode('|', $crypto);
        $id = $explode[1];
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::mission, $userId, ActionsEnum::edit, "SheetRideDetailRides",
            $id, "SheetRideDetailRides", null,1);
        if($result){
            $this->SheetRideDetailRides->id = $id;
            if ($this->SheetRideDetailRides->saveField('note', $value)){
                echo json_encode(array("response" => true));
            }else {
                echo json_encode(array("response" => false));
            }
        }else {
            echo json_encode(array("response" => false));
        }

    }


    public function printDispatchSlip()
    {
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        $array = filter_input(INPUT_POST, "printDispatchSlip");
        $conditions = filter_input(INPUT_POST, "conditions");
        if(!empty($conditions)){
            $conditions = '1 = 1 '.unserialize(base64_decode($conditions));
        }else {
            $arrayConditions = explode(",", $array);
            $detailRideId = $arrayConditions[0] ;
            $clientId = $arrayConditions[1] ;
            $subcontractorId = $arrayConditions[2] ;
            $orderType = $arrayConditions[3] ;
            $conditions = array();
            if (!empty($detailRideId)) {
                $conditions["SheetRideDetailRides.detail_ride_id "] = $detailRideId;
            }
            if (!empty($clientId)) {
                $conditions["SheetRideDetailRides.supplier_id "] = $clientId;
            }
            if (!empty($subcontractorId)) {
                $conditions["SheetRide.supplier_id  "] = $subcontractorId;
            }
            if (!empty($orderType)) {
                $conditions["TransportBillDetailRides.order_type "] = $orderType;
            }
        }

        $ids = filter_input(INPUT_POST, "chkids");

        if (!empty($ids)) {
            $array_ids = explode(",", $ids);
            if (!empty($array_ids)) {
                $conditions["SheetRideDetailRides.id"] = $array_ids;
            }
        }
        $sheetRideDetailRides = $this->SheetRideDetailRides->find('all', array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'conditions' => $conditions,
            'order'=>array('SheetRideDetailRides.id DESC'),
            'fields' => array(
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.real_start_date',
                'SheetRideDetailRides.planned_start_date',
                'SheetRideDetailRides.type_ride',
                'SheetRideDetailRides.note',
                'SheetRideDetailRides.final_customer',
                'SheetRideDetailRides.number_delivery_note',
                'SheetRideDetailRides.number_invoice',
                'Supplier.name',
                'SupplierFinal.name',
                'Subcontractor.name',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Departure.name',
                'Arrival.name',
            ),
            'joins' => array(
                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('SheetRide.id = SheetRideDetailRides.sheet_ride_id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Subcontractor',
                    'conditions' => array('SheetRide.supplier_id = Subcontractor.id')
                ),
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
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
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Departure',
                    'conditions' => array('Departure.id = SheetRideDetailRides.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Arrival',
                    'conditions' => array('Arrival.id = SheetRideDetailRides.arrival_destination_id')
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
                )
            )
        ));
        $reference = $this->getNextTransportReference(TransportBillTypesEnum::dispatch_slip);

        $this->set(compact('sheetRideDetailRides','reference'));

    }














}
