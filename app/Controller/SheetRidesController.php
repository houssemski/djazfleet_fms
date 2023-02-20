<?php
App::uses('AppController', 'Controller');
App::uses('BarcodeHelper', 'Vendor');
include("Enum.php");
include("PaymentAssociationsEnum.php");
/**
 * SheetRides Controller
 *
 * @property CarType $CarType
 * @property TravelReason $TravelReason
 * @property Service $Service
 * @property SheetRideCarState $SheetRideCarState
 * @property CarState $CarState
 * @property Complaint $Complaint
 * @property SheetRide $SheetRide
 * @property FuelCard $FuelCard
 * @property Fuel $Fuel
 * @property Payment $Payment
 * @property DetailPayment $DetailPayment
 * @property Ride $Ride
 * @property Tva $Tva
 * @property Lot $Lot
 * @property Bill $Bill
 * @property BillProduct $BillProduct
 * @property Marchandise $Marchandise
 * @property Carmodel $Carmodel
 * @property CancelCause $CancelCause
 * @property Zone $Zone
 * @property EventType $EventType
 * @property Customer $Customer
 * @property Attachment $Attachment
 * @property ParameterAttachmentType $ParameterAttachmentType
 * @property Observation $Observation
 * @property Company $Company
 * @property FuelCardMouvement $FuelCardMouvement
 * @property Supplier $Supplier
 * @property Destination $Destination
 * @property AttachmentType $AttachmentType
 * @property Contract $Contract
 * @property Tank $Tank
 * @property Compte $Compte
 * @property Parc $Parc
 * @property DetailRide $DetailRide
 * @property Profile $Profile
 * @property CustomerCar $CustomerCar
 * @property Reservation $Reservation
 * @property RideCategory $RideCategory
 * @property Consumption $Consumption
 * @property ContractCarType $ContractCarType
 * @property TransportBillDetailRides $TransportBillDetailRides
 * @property SheetRideDetailRideMarchandise $SheetRideDetailRideMarchandise
 * @property SheetRideConveyor $SheetRideConveyor
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 * @property TransportBillDetailedRides $TransportBillDetailedRides
 */
class SheetRidesController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Security', 'RequestHandler','SheetRideManagement');
    public $uses = array(
        'SheetRide',
        'TravelReason',
        'SheetRideCarState',
        'FuelCard',
        'Ride',
        'Carmodel',
        'Service',
        'Zone',
        'Bill',
        'BillProduct',
        'EventType',
        'CarType',
        'Tank',
        'Parc',
        'Complaint',
        'Lot',
        'SheetRideDetailRideMarchandise',
        'ParameterAttachmentType',
        'Marchandise',
        'Customer',
        'Company',
        'TransportBillDetailRides',
        'Fuel',
        'Destination',
        'AttachmentType',
        'Attachment',
        'Reservation',
        'Contract',
        'FuelCardMouvement',
        'Profile',
        'CustomerCar',
        'Consumption',
        'Coupon',
        'FuelCard',
        'Observation',
        'SheetRideConveyor',
        'ContractCarType',
        'DetailRide',
        'RideCategory',
        'CancelCause',
        'Payment',
        'Compte',
        'DetailPayment',
        'TransportBillDetailRides'
    );

    var $helpers = array('Xls');

    public function index()
    {

        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            $this->redirect('/');
        }
        $offShore = $this->hasModuleOffShore();
        $searchConditions ='';
        if ($this->request->is('post')) {
            if (
                isset($this->request->data['SheetRides']['car_id']) ||
                isset($this->request->data['SheetRides']['customer_id']) ||
                isset($this->request->data['SheetRides']['parc_id']) ||
                isset($this->request->data['SheetRides']['detail_ride_id']) ||
                isset($this->request->data['SheetRides']['supplier_initial_id']) ||
                isset($this->request->data['SheetRides']['status_id']) ||
                isset($this->request->data['SheetRides']['supplier_id']) ||
                isset($this->request->data['SheetRides']['order_type']) ||
                isset($this->request->data['SheetRides']['start_date1']) ||
                isset($this->request->data['SheetRides']['start_date2'])||
                isset($this->request->data['SheetRides']['end_date1']) ||
                isset($this->request->data['SheetRides']['end_date2'])||
                isset($this->request->data['SheetRides']['user_id'])||
                isset($this->request->data['SheetRides']['created'])||
                isset($this->request->data['SheetRides']['created1'])||
                isset($this->request->data['SheetRides']['modified_id'])||
                isset($this->request->data['SheetRides']['modified'])||
                isset($this->request->data['SheetRides']['modified1'])
            ) {
                if(isset($this->request->data['SheetRides']['car_id'])) {
                    $car = $this->request->data['SheetRides']['car_id'];
                }
                if(isset($this->request->data['SheetRides']['customer_id'])){
                    $customer = $this->request->data['SheetRides']['customer_id'];
                }
                if(isset($this->request->data['SheetRides']['parc_id'])) {
                    $parc = $this->request->data['SheetRides']['parc_id'];
                }
                if(isset($this->request->data['SheetRides']['detail_ride_id'])){
                    $detailRide = $this->request->data['SheetRides']['detail_ride_id'];
                }

                if(isset($this->request->data['SheetRides']['supplier_initial_id'])) {
                    $supplier = $this->request->data['SheetRides']['supplier_initial_id'];
                }
                if(isset($this->request->data['SheetRides']['status_id'])){
                    $status = $this->request->data['SheetRides']['status_id'];
                }
                if(isset($this->request->data['SheetRides']['supplier_id'])){
                    $subcontractor = $this->request->data['SheetRides']['supplier_id'];
                }
                if(isset($this->request->data['SheetRides']['order_type'])){
                    $orderType = $this->request->data['SheetRides']['order_type'];
                }
                if(isset($this->request->data['SheetRides']['status_id'])){
                    $status = $this->request->data['SheetRides']['status_id'];
                }
                if(isset($this->request->data['SheetRides']['user_id'])){
                    $user = $this->request->data['SheetRides']['user_id'];
                }
                if(isset($this->request->data['SheetRides']['modified_id'])){
                    $modifier = $this->request->data['SheetRides']['modified_id'];
                }
                $start_date_from = str_replace("/", "-", $this->request->data['SheetRides']['start_date1']);
                $start_date_to = str_replace("/", "-", $this->request->data['SheetRides']['start_date2']);
                $end_date_from = str_replace("/", "-", $this->request->data['SheetRides']['end_date1']);
                $end_date_to = str_replace("/", "-", $this->request->data['SheetRides']['end_date2']);
                if(isset($this->request->data['SheetRides']['created'])) {
                    $created_from = str_replace("/", "-", $this->request->data['SheetRides']['created']);
                }
                if(isset($this->request->data['SheetRides']['created1'])) {
                    $created_to = str_replace("/", "-", $this->request->data['SheetRides']['created1']);
                }
                if(isset($this->request->data['SheetRides']['modified'])) {
                    $modified_from = str_replace("/", "-", $this->request->data['SheetRides']['modified']);
                }
                if(isset($this->request->data['SheetRides']['modified1'])) {
                    $modified_to = str_replace("/", "-", $this->request->data['SheetRides']['modified1']);
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
                    $searchConditions .= " && SheetRide.status_id = $status  ";
                }

                if (isset($user)&& !empty($user)) {
                    $searchConditions .= " && SheetRide.user_id = $user  ";
                }

                if (isset($modifier)&& !empty($modifier)) {
                    $searchConditions .= " && SheetRide.modified_id = $modifier  ";
                }
                if (isset($start_date_from)&& !empty($start_date_from)) {
                    $start = str_replace("-", "/", $start_date_from);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $startdtm = $startdtm->format('Y-m-d 00:00:00');
                    $searchConditions .= " && SheetRide.start_date >= '$startdtm' ";
                }
                if (isset($start_date_to)&& !empty($start_date_to)) {
                    $end = str_replace("-", "/", $start_date_to);
                    $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                    $enddtm = $enddtm->format('Y-m-d 23:59:00');
                    $searchConditions .= " && SheetRide.start_date <= '$enddtm' ";
                }

                if (isset($end_date_from)&& !empty($end_date_from)) {
                    $start = str_replace("-", "/", $end_date_from);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $startdtm = $startdtm->format('Y-m-d 00:00:00');
                    $searchConditions .= " && SheetRide.end_date >= '$startdtm' ";
                }
                if (isset($end_date_to)&& !empty($end_date_to)) {
                    $end = str_replace("-", "/", $end_date_to);
                    $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                    $enddtm = $enddtm->format('Y-m-d 23:59:00');
                    $searchConditions .= " && SheetRide.end_date <= '$enddtm' ";
                }
                if (isset($created_from)&& !empty($created_from)) {
                    $start = str_replace("-", "/", $created_from);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $startdtm = $startdtm->format('Y-m-d 00:00:00');
                    $searchConditions .= " && SheetRide.created >= '$startdtm' ";
                }
                if (isset($created_to)&& !empty($created_to)) {
                    $end = str_replace("-", "/", $created_to);
                    $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                    $enddtm = $enddtm->format('Y-m-d 23:59:00');
                    $searchConditions .= " && SheetRide.created <= '$enddtm' ";
                }
                if (isset($modified_from)&&  !empty($modified_from)) {
                    $start = str_replace("-", "/", $modified_from);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $startdtm = $startdtm->format('Y-m-d 00:00:00');
                    $searchConditions .= " && SheetRide.modified >= '$startdtm' ";
                }
                if (isset($modified_to)&&  !empty($modified_to)) {
                    $end = str_replace("-", "/", $modified_to);
                    $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                    $enddtm = $enddtm->format('Y-m-d 23:59:00');
                    $searchConditions .= " && SheetRide.modified <= '$enddtm' ";
                }
            }

        }else {
            $searchConditions = '';
        }
        $this->setTimeActif();
        $isAgent = $this->isAgent();
        $this->Session->write('isAgent', $isAgent);
        $cond = $this->getConditionsForIndexSheetRide();
        $conditions = $cond[0];

        if($offShore==1){
            $query['count'] = " SELECT COUNT(*) AS `count`, CONCAT(`Customer`.`first_name`,' - ', `Customer`.`last_name`) as full_name,
                           CONCAT(`Car`.`code` ,' / ', `Carmodel`.`name`) as car_name FROM `sheet_rides` AS `SheetRide` 
                            left JOIN `car` AS `Car` ON (`SheetRide`.`car_id` = `Car`.`id`) 
                            left JOIN `car_types` AS `CarType` ON (`SheetRide`.`car_type_id` = `CarType`.`id`) 
                            left JOIN `customers` AS `Customer` ON (`SheetRide`.`customer_id` = `Customer`.`id`) 
                            left JOIN `carmodels` AS `Carmodel` ON (`Car`.`carmodel_id` = `Carmodel`.`id`) 
                            left JOIN `suppliers` AS `Supplier` ON (`SheetRide`.`supplier_id` = `Supplier`.`id`) 
                            left JOIN `cancel_causes` AS `CancelCause` ON (`SheetRide`.`cancel_cause_id` = `CancelCause`.`id`) 
                            left JOIN `destinations` AS `Destination` ON (`SheetRide`.`destination_id` = `Destination`.`id`) ";
            if (!empty($detailRide) || !empty($supplier) || !empty($orderType)) {
                $query['count'] = $query['count'] .
                    "
                    left JOIN `sheet_ride_detail_rides` AS `SheetRideDetailRides` ON (`SheetRide`.`id` = `SheetRideDetailRides`.`sheet_ride_id`)      
                
                " ;
            }
            if(!empty($orderType)){
                $query['count'] = $query['count'].
                    "
                    left JOIN `transport_bill_detail_rides` AS `TransportBillDetailRides` ON (`SheetRideDetailRides`.`transport_bill_detail_ride_id` = `TransportBillDetailRides`.`id`) 
	                left JOIN `transport_bills` AS `TransportBill` ON (`TransportBillDetailRides`.`transport_bill_id` = `TransportBill`.`id`)       
                    ";
            }


            $query['count'] = $query['count'] . " WHERE 1 = 1 " ;
            $query['detail'] =
                "SELECT ";
            if (Configure::read("reclamation") == '1') {
                $query['detail'] =  $query['detail']. "	`SheetRide`.`nb_complaints_by_missions`,`SheetRide`.`nb_complaints_by_orders`,";
            }
            $query['detail'] =  $query['detail']." `SheetRide`.`reference`, `SheetRide`.`status_id`,`SheetRide`.`created`, 
                            `SheetRide`.`id`,  `SheetRide`.`car_id`, 
                          `SheetRide`.`car_subcontracting`, `SheetRide`.`car_name`, `SheetRide`.`remorque_name`, 
                          `SheetRide`.`customer_name`,`Supplier`.`name`, `SheetRide`.`start_date`, `SheetRide`.`real_start_date`,`Destination`.`name`, 
                          `SheetRide`.`end_date`, `SheetRide`.`real_end_date`, CONCAT(`Customer`.`first_name`,' - ', `Customer`.`last_name`) as full_name,
                           CONCAT(`Car`.`code` ,' / ', `Carmodel`.`name`) as car_name,
                          `Car`.`immatr_def`, `Carmodel`.`name`,  `CancelCause`.`name` FROM `sheet_rides` AS `SheetRide` 
                          left JOIN `car` AS `Car` ON (`SheetRide`.`car_id` = `Car`.`id`) 
                          left JOIN `car_types` AS `CarType` ON (`SheetRide`.`car_type_id` = `CarType`.`id`) 
                          left JOIN `customers` AS `Customer` ON (`SheetRide`.`customer_id` = `Customer`.`id`) 
                          left JOIN `carmodels` AS `Carmodel` ON (`Car`.`carmodel_id` = `Carmodel`.`id`) 
                          left JOIN `suppliers` AS `Supplier` ON (`SheetRide`.`supplier_id` = `Supplier`.`id`) 
                          left JOIN `cancel_causes` AS `CancelCause` ON (`SheetRide`.`cancel_cause_id` = `CancelCause`.`id`) 
                          left JOIN `destinations` AS `Destination` ON (`SheetRide`.`destination_id` = `Destination`.`id`) ";

                 if (!empty($detailRide) || !empty($supplier)) {
                     $query['detail'] =  $query['detail']. "
                     left JOIN `sheet_ride_detail_rides` AS `SheetRideDetailRides` ON (`SheetRide`.`id` = `SheetRideDetailRides`.`sheet_ride_id`) 
          
                     ";
                 }
            if(!empty($orderType)){
                $query['count'] = $query['count'].
                    "
                    left JOIN `sheet_ride_detail_rides` AS `SheetRideDetailRides` ON (`SheetRide`.`id` = `SheetRideDetailRides`.`sheet_ride_id`)      
                    left JOIN `transport_bill_detail_rides` AS `TransportBillDetailRides` ON (`SheetRideDetailRides`.`transport_bill_detail_ride_id` = `TransportBillDetailRides`.`id`) 
	                left JOIN `transport_bills` AS `TransportBill` ON (`TransportBillDetailRides`.`transport_bill_id` = `TransportBill`.`id`)       
                    ";
            }
                $query['detail'] =   $query['detail'] .    "   WHERE 1 = 1  " ;

        }else {
            $query['count'] = " SELECT COUNT(*) AS `count`, CONCAT(`Customer`.`first_name`,' - ', `Customer`.`last_name`) as full_name,
                           CONCAT(`Car`.`code` ,' / ', `Carmodel`.`name`) as car_name FROM `sheet_rides` AS `SheetRide` 
                            left JOIN `car` AS `Car` ON (`SheetRide`.`car_id` = `Car`.`id`) 
                            left JOIN `car_types` AS `CarType` ON (`SheetRide`.`car_type_id` = `CarType`.`id`) 
                            left JOIN `customers` AS `Customer` ON (`SheetRide`.`customer_id` = `Customer`.`id`) 
                            left JOIN `carmodels` AS `Carmodel` ON (`Car`.`carmodel_id` = `Carmodel`.`id`) 
                            left JOIN `cancel_causes` AS `CancelCause` ON (`SheetRide`.`cancel_cause_id` = `CancelCause`.`id`) 
                            left JOIN `destinations` AS `Destination` ON (`SheetRide`.`destination_id` = `Destination`.`id`) ";
                            if (!empty($detailRide) || !empty($supplier)) {
                $query['count'] = $query['count'] .
                    "
                    left JOIN `sheet_ride_detail_rides` AS `SheetRideDetailRides` ON (`SheetRide`.`id` = `SheetRideDetailRides`.`sheet_ride_id`) 
                           
                " ;
            }

            $query['count'] = $query['count'] . " WHERE 1 = 1 " ;
            $query['detail'] =
                "SELECT ";
            if (Configure::read("reclamation") == '1') {
                $query['detail'] =  $query['detail']. "	`SheetRide`.`nb_complaints_by_missions`,`SheetRide`.`nb_complaints_by_orders`,";
            }
            $query['detail'] =  $query['detail']."`SheetRide`.`reference`, `SheetRide`.`status_id`,
                           `SheetRide`.`created`, `SheetRide`.`id`,  `SheetRide`.`car_id`, 
                          `SheetRide`.`car_subcontracting`, `SheetRide`.`car_name`, `SheetRide`.`remorque_name`, 
                          `SheetRide`.`customer_name`, `SheetRide`.`start_date`, `SheetRide`.`real_start_date`,`Destination`.`name`, 
                          `SheetRide`.`end_date`, `SheetRide`.`real_end_date`, CONCAT(`Customer`.`first_name`,' - ', `Customer`.`last_name`) as full_name,
                           CONCAT(`Car`.`code` ,' / ', `Carmodel`.`name`) as car_name,
                          `Car`.`immatr_def`, `Carmodel`.`name`,  `CancelCause`.`name` FROM `sheet_rides` AS `SheetRide` 
                          left JOIN `car` AS `Car` ON (`SheetRide`.`car_id` = `Car`.`id`) 
                          left JOIN `car_types` AS `CarType` ON (`SheetRide`.`car_type_id` = `CarType`.`id`) 
                          left JOIN `customers` AS `Customer` ON (`SheetRide`.`customer_id` = `Customer`.`id`) 
                          left JOIN `carmodels` AS `Carmodel` ON (`Car`.`carmodel_id` = `Carmodel`.`id`) 
                          left JOIN `cancel_causes` AS `CancelCause` ON (`SheetRide`.`cancel_cause_id` = `CancelCause`.`id`) 
                          left JOIN `destinations` AS `Destination` ON (`SheetRide`.`destination_id` = `Destination`.`id`) ";
                            if (!empty($detailRide) || !empty($supplier)) {
                     $query['detail'] =  $query['detail']. "
                     left JOIN `sheet_ride_detail_rides` AS `SheetRideDetailRides` ON (`SheetRide`.`id` = `SheetRideDetailRides`.`sheet_ride_id`) 
          
                     ";
                 }

                      $query['detail'] =   $query['detail'] .    "   WHERE 1 = 1  " ;
        }


        if(!empty($conditions)){
            $query['conditions'] = '&& '.$conditions.$searchConditions;
        }else {
            $query['conditions'] = $conditions.$searchConditions;
        }
        $sheetRideWithMission = $this->Parameter->getCodesParameterVal('sheet_ride_with_mission');
        $paramNameCar = $this->Parameter->getCodesParameterVal('name_car');
        if($offShore==1){
            if($sheetRideWithMission==1 || $sheetRideWithMission==3) {
                if($paramNameCar ==1) {
                    if (Configure::read("reclamation") == '1') {
                        $query['columns'] = array(
                            0 => array('SheetRide.reference','SheetRide', 'reference', 'Reference', 'string',''),
                            1 => array('Carmodel.name','0', 'car_name',  'Car', 'string','CONCAT','Carmodel.name','Car.code', 'SheetRide.car_name', 'SheetRide.car_name'),
                            2 => array('Customer.first_name','0', 'full_name','Customer', 'string','CONCAT', 'Customer.first_name','Customer.last_name', 'SheetRide.customer_name', 'SheetRide.customer_name'),
                            3 => array('Supplier.name','Supplier', 'name',  'Supplier', 'string',''),
                            4 => array('SheetRide.start_date','SheetRide', 'start_date', 'Start date', 'datetime',''),
                            5 => array('SheetRide.real_start_date','SheetRide', 'real_start_date', 'Real Departure date', 'datetime',''),
                            6 => array('SheetRide.real_end_date','SheetRide', 'real_end_date', 'Real end date', 'datetime',''),
                            7 => array('SheetRide.status_id','SheetRide', 'status_id', 'Status', 'number',''),
                            8 => array('SheetRide.id','SheetRide', 'nb_complaints_by_missions', 'Nb complaints missions', 'number',''),
                            9 => array('SheetRide.id','SheetRide', 'nb_complaints_by_orders', 'Nb complaints orders', 'number',''),
                        );
                    }else {
                        $query['columns'] = array(
                            0 => array('SheetRide.reference','SheetRide', 'reference', 'Reference', 'string',''),
                            1 => array('Carmodel.name','0', 'car_name',  'Car', 'string','CONCAT','Carmodel.name','Car.code', 'SheetRide.car_name', 'SheetRide.car_name'),
                            2 => array('Customer.first_name','0', 'full_name','Customer', 'string','CONCAT', 'Customer.first_name','Customer.last_name', 'SheetRide.customer_name', 'SheetRide.customer_name'),
                            3 => array('Supplier.name','Supplier', 'name',  'Supplier', 'string',''),
                            4 => array('SheetRide.start_date','SheetRide', 'start_date', 'Start date', 'datetime',''),
                            5 => array('SheetRide.real_start_date','SheetRide', 'real_start_date', 'Real Departure date', 'datetime',''),
                            6 => array('SheetRide.real_end_date','SheetRide', 'real_end_date', 'Real end date', 'datetime',''),
                            7 => array('SheetRide.status_id','SheetRide', 'status_id', 'Status', 'number',''),
                        );
                    }

                }else {
                    if (Configure::read("reclamation") == '1') {
                        $query['columns'] = array(
                            0 => array('SheetRide.reference','SheetRide', 'reference', 'Reference', 'string',''),
                            1 => array('Carmodel.name','0', 'car_name',  'Car', 'string','CONCAT','Carmodel.name','Car.immatr_def', 'SheetRide.car_name', 'SheetRide.car_name'),
                            2 => array('Customer.first_name','0', 'full_name','Customer', 'string','CONCAT', 'Customer.first_name','Customer.last_name', 'SheetRide.customer_name', 'SheetRide.customer_name'),
                            3 => array('Supplier.name','Supplier', 'name',  'Supplier', 'string',''),
                            4 => array('SheetRide.start_date','SheetRide', 'start_date', 'Start date', 'datetime',''),
                            5 => array('SheetRide.real_start_date','SheetRide', 'real_start_date', 'Real Departure date', 'datetime',''),
                            6 => array('SheetRide.real_end_date','SheetRide', 'real_end_date', 'Real end date', 'datetime',''),
                            7 => array('SheetRide.status_id','SheetRide', 'status_id', 'Status', 'number',''),
                            8 => array('SheetRide.id','SheetRide', 'nb_complaints_by_missions', 'Nb complaints missions', 'number',''),
                            9 => array('SheetRide.id','SheetRide', 'nb_complaints_by_orders', 'Nb complaints orders', 'number',''),

                        );
                    }else {
                        $query['columns'] = array(
                            0 => array('SheetRide.reference','SheetRide', 'reference', 'Reference', 'string',''),
                            1 => array('Carmodel.name','0', 'car_name',  'Car', 'string','CONCAT','Carmodel.name','Car.immatr_def', 'SheetRide.car_name', 'SheetRide.car_name'),
                            2 => array('Customer.first_name','0', 'full_name','Customer', 'string','CONCAT', 'Customer.first_name','Customer.last_name', 'SheetRide.customer_name', 'SheetRide.customer_name'),
                            3 => array('Supplier.name','Supplier', 'name',  'Supplier', 'string',''),
                            4 => array('SheetRide.start_date','SheetRide', 'start_date', 'Start date', 'datetime',''),
                            5 => array('SheetRide.real_start_date','SheetRide', 'real_start_date', 'Real Departure date', 'datetime',''),
                            6 => array('SheetRide.real_end_date','SheetRide', 'real_end_date', 'Real end date', 'datetime',''),
                            7 => array('SheetRide.status_id','SheetRide', 'status_id', 'Status', 'number',''),
                           );
                    }

                }

            }else {
                if($paramNameCar ==1){
                    $query['columns'] = array(
                        0 => array('SheetRide.reference','SheetRide', 'reference', 'Reference', 'string',''),
                        1 => array('Carmodel.name','0', 'car_name',  'Car', 'string','CONCAT','Carmodel.name','Car.code', 'SheetRide.car_name', 'SheetRide.car_name'),
                        2 => array('Customer.first_name','0', 'full_name','Customer', 'string','CONCAT', 'Customer.first_name','Customer.last_name', 'SheetRide.customer_name', 'SheetRide.customer_name'),
                        3 => array('Supplier.name','Supplier', 'name',  'Supplier', 'string',''),
                        4 => array('SheetRide.real_start_date','SheetRide', 'real_start_date', 'Real Departure date', 'datetime',''),
                        5 => array('SheetRide.real_end_date','SheetRide', 'real_end_date', 'Real end date', 'datetime',''),
                        6 => array('Destination.name','Destination', 'name','Destination', 'string',''),
                        7 => array('SheetRide.created','SheetRide', 'created', 'Created', 'datetime',''),
                    );
                }else {
                    $query['columns'] = array(
                        0 => array('SheetRide.reference','SheetRide', 'reference', 'Reference', 'string',''),
                        1 => array('Carmodel.name','0', 'car_name',  'Car', 'string','CONCAT','Carmodel.name','Car.immatr_def', 'SheetRide.car_name', 'SheetRide.car_name'),
                        2 => array('Customer.first_name','0', 'full_name','Customer', 'string','CONCAT', 'Customer.first_name','Customer.last_name', 'SheetRide.customer_name', 'SheetRide.customer_name'),
                        3 => array('Supplier.name','Supplier', 'name',  'Supplier', 'string',''),
                        4 => array('SheetRide.real_start_date','SheetRide', 'real_start_date', 'Real Departure date', 'datetime',''),
                        5 => array('SheetRide.real_end_date','SheetRide', 'real_end_date', 'Real end date', 'datetime',''),
                        6 => array('Destination.name','Destination', 'name','Destination', 'string',''),
                        7 => array('SheetRide.created','SheetRide', 'created', 'Created', 'datetime',''),
                    );
                }

            }
        }else {
            if($sheetRideWithMission==1 || $sheetRideWithMission==3){
                if($paramNameCar ==1){
                    if (Configure::read("reclamation") == '1') {
                        $query['columns'] = array(
                            0 => array('SheetRide.reference','SheetRide', 'reference', 'Reference', 'string',''),
                            1 => array('Carmodel.name','0', 'car_name',  'Car', 'string','CONCAT','Carmodel.name','Car.code', 'SheetRide.car_name', 'SheetRide.car_name'),
                            2 => array('Customer.first_name','0', 'full_name','Customer', 'string','CONCAT', 'Customer.first_name','Customer.last_name', 'SheetRide.customer_name', 'SheetRide.customer_name'),
                            3 => array('SheetRide.start_date','SheetRide', 'start_date', 'Start date', 'datetime',''),
                            4 => array('SheetRide.real_start_date','SheetRide', 'real_start_date', 'Real Departure date', 'datetime',''),
                            5 => array('SheetRide.real_end_date','SheetRide', 'real_end_date', 'Real end date', 'datetime',''),
                            6 => array('SheetRide.status_id','SheetRide', 'status_id', 'Status', 'number',''),
                            8 => array('SheetRide.id','SheetRide', 'nb_complaints_by_missions', 'Nb complaints missions', 'number',''),
                            9 => array('SheetRide.id','SheetRide', 'nb_complaints_by_orders', 'Nb complaints orders', 'number',''),

                        );
                    }else {
                        $query['columns'] = array(
                            0 => array('SheetRide.reference','SheetRide', 'reference', 'Reference', 'string',''),
                            1 => array('Carmodel.name','0', 'car_name',  'Car', 'string','CONCAT','Carmodel.name','Car.code', 'SheetRide.car_name', 'SheetRide.car_name'),
                            2 => array('Customer.first_name','0', 'full_name','Customer', 'string','CONCAT', 'Customer.first_name','Customer.last_name', 'SheetRide.customer_name', 'SheetRide.customer_name'),
                            3 => array('SheetRide.start_date','SheetRide', 'start_date', 'Start date', 'datetime',''),
                            4 => array('SheetRide.real_start_date','SheetRide', 'real_start_date', 'Real Departure date', 'datetime',''),
                            5 => array('SheetRide.real_end_date','SheetRide', 'real_end_date', 'Real end date', 'datetime',''),
                            6 => array('SheetRide.status_id','SheetRide', 'status_id', 'Status', 'number',''),
                           );
                    }

                }else {
                    if (Configure::read("reclamation") == '1') {
                        $query['columns'] = array(
                            0 => array('SheetRide.reference','SheetRide', 'reference', 'Reference', 'string',''),
                            1 => array('Carmodel.name','0', 'car_name',  'Car', 'string','CONCAT','Carmodel.name','Car.immatr_def', 'SheetRide.car_name', 'SheetRide.car_name'),
                            2 => array('Customer.first_name','0', 'full_name','Customer', 'string','CONCAT', 'Customer.first_name','Customer.last_name', 'SheetRide.customer_name', 'SheetRide.customer_name'),
                            3 => array('SheetRide.start_date','SheetRide', 'start_date', 'Start date', 'datetime',''),
                            4 => array('SheetRide.real_start_date','SheetRide', 'real_start_date', 'Real Departure date', 'datetime',''),
                            5 => array('SheetRide.real_end_date','SheetRide', 'real_end_date', 'Real end date', 'datetime',''),
                            6 => array('SheetRide.status_id','SheetRide', 'status_id', 'Status', 'number',''),
                            8 => array('SheetRide.id','SheetRide', 'nb_complaints_by_missions', 'Nb complaints missions', 'number',''),
                            9 => array('SheetRide.id','SheetRide', 'nb_complaints_by_orders', 'Nb complaints orders', 'number',''),

                        );
                    }else {
                        $query['columns'] = array(
                            0 => array('SheetRide.reference','SheetRide', 'reference', 'Reference', 'string',''),
                            1 => array('Carmodel.name','0', 'car_name',  'Car', 'string','CONCAT','Carmodel.name','Car.immatr_def', 'SheetRide.car_name', 'SheetRide.car_name'),
                            2 => array('Customer.first_name','0', 'full_name','Customer', 'string','CONCAT', 'Customer.first_name','Customer.last_name', 'SheetRide.customer_name', 'SheetRide.customer_name'),
                            3 => array('SheetRide.start_date','SheetRide', 'start_date', 'Start date', 'datetime',''),
                            4 => array('SheetRide.real_start_date','SheetRide', 'real_start_date', 'Real Departure date', 'datetime',''),
                            5 => array('SheetRide.real_end_date','SheetRide', 'real_end_date', 'Real end date', 'datetime',''),
                            6 => array('SheetRide.status_id','SheetRide', 'status_id', 'Status', 'number',''),
                            );
                    }

                }

            }else {
                if($paramNameCar ==1){
                    $query['columns'] = array(
                        0 => array('SheetRide.reference','SheetRide', 'reference', 'Reference', 'string',''),
                        1 => array('Carmodel.name','0', 'car_name',  'Car', 'string','CONCAT','Carmodel.name','Car.code', 'SheetRide.car_name', 'SheetRide.car_name'),
                        2 => array('Customer.first_name','0', 'full_name','Customer', 'string','CONCAT', 'Customer.first_name','Customer.last_name', 'SheetRide.customer_name', 'SheetRide.customer_name'),
                        3 => array('SheetRide.real_start_date','SheetRide', 'real_start_date', 'Real Departure date', 'datetime',''),
                        4 => array('SheetRide.real_end_date','SheetRide', 'real_end_date', 'Real end date', 'datetime',''),
                        5 => array('Destination.name','Destination', 'name','Destination', 'string',''),
                        6 => array('SheetRide.created','SheetRide', 'created', 'Created', 'datetime',''),
                    );
                }else {
                    $query['columns'] = array(
                        0 => array('SheetRide.reference','SheetRide', 'reference', 'Reference', 'string',''),
                        1 => array('Carmodel.name','0', 'car_name',  'Car', 'string','CONCAT','Carmodel.name','Car.immatr_def', 'SheetRide.car_name', 'SheetRide.car_name'),
                        2 => array('Customer.first_name','0', 'full_name','Customer', 'string','CONCAT', 'Customer.first_name','Customer.last_name', 'SheetRide.customer_name', 'SheetRide.customer_name'),
                        3 => array('SheetRide.real_start_date','SheetRide', 'real_start_date', 'Real Departure date', 'datetime',''),
                        4 => array('SheetRide.real_end_date','SheetRide', 'real_end_date', 'Real end date', 'datetime',''),
                        5 => array('Destination.name','Destination', 'name','Destination', 'string',''),
                        6 => array('SheetRide.created','SheetRide', 'created', 'Created', 'datetime',''),
                    );
                }

            }
        }


        $query['order'] = ' SheetRide.id desc';
        $query['group'] = ' SheetRide.id ';
        $query['tableName'] = 'SheetRide';
        $query['entityName'] = 'SheetRide';
        $query['controller'] = 'sheetRides';
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
        $sumCost = $this->SheetRide->getSumCost($conditions);
        $sumConsumption = $this->SheetRide->getSumConsumption($conditions);
        $sumKm = $this->SheetRide->getSumKm($conditions);



        $this->set(compact('sumCost', 'sumConsumption', 'sumKm'));
        //Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set(compact( 'param'));
        $users = $this->User->getUsers();
        $profiles = $this->Profile->getUserProfiles();
        $rideCategories = $this->RideCategory->getRideCategories();
        $reportingChoosed = $this->reportingChoosed();
        $this->Session->write('reportingChoosed', $reportingChoosed);
        if ($reportingChoosed == 3) {
            $informationJasperReport = $this->Parameter->getInformationJasperReport();
            $this->set('informationJasperReport', $informationJasperReport);
            $this->Session->write('informationJasperReport', $informationJasperReport);
        }
        $useRideCategory = $this->useRideCategory();
        $client_i2b = $this->isCustomerI2B();
        $hasSaleModule = $this->hasSaleModule();
        $isSuperAdmin = $this->isSuperAdmin();
        $parcs = $this->Parc->getParcs('list');
        $roleId = $this->Auth->user('role_id');
        $profileId = $this->Auth->user('profile_id');
        $permissionCancel = $this->AccessPermission->getPermissionWithParams(SectionsEnum::annuler_commande_client,
            ActionsEnum::view, $profileId, $roleId);
        $permissionTurnover = $this->AccessPermission->getPermissionWithParams(SectionsEnum::chiffre_affaire_feuille_de_route,
            ActionsEnum::view, $profileId, $roleId);
        $controller =  'sheetRides';
        $action = 'index';
        $deleteFonction =  'deleteSheetRides';
      //  var_dump($customer); die();
        $this->set(compact('profiles', 'users', 'rideCategories', 'isAgent',
            'reportingChoosed', 'useRideCategory','sheetRideWithMission','customer','permissionTurnover',
            'client_i2b', 'hasSaleModule', 'isSuperAdmin', 'coupons','searchConditions',
            'parcs','permissionCancel','controller','action','deleteFonction'));

    }

    public function viewSumCost($conditions){
        if(!empty($conditions)) {
            $conditions =  " 1=1 ".unserialize(base64_decode($conditions));
            $sumCostClient = $this->SheetRide->getSumCostClient($conditions);
            $sumCostSupplier = $this->SheetRide->getSumCostSupplier($conditions);
            $this->set(compact('sumCostClient','sumCostSupplier'));
        }

        }
    public function sheetRidesWithConsumption()
    {
        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            $this->redirect('/');
        }
        $searchConditions ='';
        if ($this->request->is('post')) {

            if (
                isset($this->request->data['SheetRides']['car_id']) ||
                isset($this->request->data['SheetRides']['customer_id']) ||
                isset($this->request->data['SheetRides']['parc_id']) ||
                isset($this->request->data['SheetRides']['detail_ride_id']) ||
                isset($this->request->data['SheetRides']['supplier_id']) ||
                isset($this->request->data['SheetRides']['status_id']) ||
                isset($this->request->data['SheetRides']['start_date1']) ||
                isset($this->request->data['SheetRides']['start_date2'])||
                isset($this->request->data['SheetRides']['end_date1']) ||
                isset($this->request->data['SheetRides']['end_date2'])||
                isset($this->request->data['SheetRides']['user_id'])||
                isset($this->request->data['SheetRides']['created'])||
                isset($this->request->data['SheetRides']['created1'])||
                isset($this->request->data['SheetRides']['modified_id'])||
                isset($this->request->data['SheetRides']['modified'])||
                isset($this->request->data['SheetRides']['modified1'])

            ) {
                if(isset($this->request->data['SheetRides']['car_id'])) {
                    $car = $this->request->data['SheetRides']['car_id'];
                }
                if(isset($this->request->data['SheetRides']['customer_id'])){
                    $customer = $this->request->data['SheetRides']['customer_id'];
                }

                if(isset($this->request->data['SheetRides']['parc_id'])) {
                    $parc = $this->request->data['SheetRides']['parc_id'];
                }
                if(isset($this->request->data['SheetRides']['detail_ride_id'])){
                    $detailRide = $this->request->data['SheetRides']['detail_ride_id'];
                }

                if(isset($this->request->data['SheetRides']['supplier_id'])) {
                    $supplier = $this->request->data['SheetRides']['supplier_id'];
                }
                if(isset($this->request->data['SheetRides']['status_id'])){
                    $status = $this->request->data['SheetRides']['status_id'];
                }
                if(isset($this->request->data['SheetRides']['user_id'])){
                    $user = $this->request->data['SheetRides']['user_id'];
                }
                if(isset($this->request->data['SheetRides']['modified_id'])){
                    $modifier = $this->request->data['SheetRides']['modified_id'];
                }


                $start_date_from = str_replace("/", "-", $this->request->data['SheetRides']['start_date1']);
                $start_date_to = str_replace("/", "-", $this->request->data['SheetRides']['start_date2']);
                $end_date_from = str_replace("/", "-", $this->request->data['SheetRides']['end_date1']);
                $end_date_to = str_replace("/", "-", $this->request->data['SheetRides']['end_date2']);
                if(isset($this->request->data['SheetRides']['created'])) {
                    $created_from = str_replace("/", "-", $this->request->data['SheetRides']['created']);
                }
                if(isset($this->request->data['SheetRides']['created1'])) {
                    $created_to = str_replace("/", "-", $this->request->data['SheetRides']['created1']);
                }
                if(isset($this->request->data['SheetRides']['modified'])) {
                    $modified_from = str_replace("/", "-", $this->request->data['SheetRides']['modified']);
                }
                if(isset($this->request->data['SheetRides']['modified1'])) {
                    $modified_to = str_replace("/", "-", $this->request->data['SheetRides']['modified1']);
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

                if (!empty($status)) {
                    $searchConditions .= " && SheetRide.status_id = $status  ";
                }

                if (isset($user)&& !empty($user)) {
                    $searchConditions .= " && SheetRide.user_id = $user  ";
                }

                if (isset($modifier)&& !empty($modifier)) {
                    $searchConditions .= " && SheetRide.modified_id = $modifier  ";
                }



                if (isset($start_date_from)&& !empty($start_date_from)) {
                    $start = str_replace("-", "/", $start_date_from);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $startdtm = $startdtm->format('Y-m-d 00:00:00');
                    $searchConditions .= " && SheetRide.start_date >= '$startdtm' ";
                }
                if (isset($start_date_to)&& !empty($start_date_to)) {
                    $end = str_replace("-", "/", $start_date_to);
                    $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                    $enddtm = $enddtm->format('Y-m-d 23:59:00');
                    $searchConditions .= " && SheetRide.start_date <= '$enddtm' ";
                }

                if (isset($end_date_from)&& !empty($end_date_from)) {
                    $start = str_replace("-", "/", $end_date_from);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $startdtm = $startdtm->format('Y-m-d 00:00:00');
                    $searchConditions .= " && SheetRide.end_date >= '$startdtm' ";
                }
                if (isset($end_date_to)&& !empty($end_date_to)) {
                    $end = str_replace("-", "/", $end_date_to);
                    $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                    $enddtm = $enddtm->format('Y-m-d 23:59:00');
                    $searchConditions .= " && SheetRide.end_date <= '$enddtm' ";
                }
                if (isset($created_from)&& !empty($created_from)) {
                    $start = str_replace("-", "/", $created_from);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $startdtm = $startdtm->format('Y-m-d 00:00:00');
                    $searchConditions .= " && SheetRide.created >= '$startdtm' ";
                }
                if (isset($created_to)&& !empty($created_to)) {
                    $end = str_replace("-", "/", $created_to);
                    $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                    $enddtm = $enddtm->format('Y-m-d 23:59:00');
                    $searchConditions .= " && SheetRide.created <= '$enddtm' ";
                }
                if (isset($modified_from)&&  !empty($modified_from)) {
                    $start = str_replace("-", "/", $modified_from);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $startdtm = $startdtm->format('Y-m-d 00:00:00');
                    $searchConditions .= " && SheetRide.modified >= '$startdtm' ";
                }
                if (isset($modified_to)&&  !empty($modified_to)) {
                    $end = str_replace("-", "/", $modified_to);
                    $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                    $enddtm = $enddtm->format('Y-m-d 23:59:00');
                    $searchConditions .= " && SheetRide.modified <= '$enddtm' ";
                }


            }
        }else {
            $searchConditions = '';
        }
        $this->setTimeActif();
        $isAgent = $this->isAgent();
        $this->Session->write('isAgent', $isAgent);
        $cond = $this->getConditionsForIndexSheetRide();
        $conditions = $cond[0];
        $query['count'] = " SELECT COUNT(*) AS `count`, CONCAT(`Customer`.`first_name`,' - ', `Customer`.`last_name`) as full_name,
                           CONCAT(`Car`.`code` ,' - ', `Carmodel`.`name`) as car_name FROM `sheet_rides` AS `SheetRide` 
                            left JOIN `car` AS `Car` ON (`SheetRide`.`car_id` = `Car`.`id`) 
                            left JOIN `car_types` AS `CarType` ON (`SheetRide`.`car_type_id` = `CarType`.`id`) 
                            left JOIN `customers` AS `Customer` ON (`SheetRide`.`customer_id` = `Customer`.`id`) 
                            left JOIN `carmodels` AS `Carmodel` ON (`Car`.`carmodel_id` = `Carmodel`.`id`) 
                            left JOIN `cancel_causes` AS `CancelCause` ON (`SheetRide`.`cancel_cause_id` = `CancelCause`.`id`) 
                             left JOIN `sheet_ride_detail_rides` AS `SheetRideDetailRides` ON (`SheetRide`.`id` = `SheetRideDetailRides`.`sheet_ride_id`) 
                            WHERE estimated_cost > cost " ;
        $query['detail'] =
                        "SELECT `SheetRide`.`reference`, `SheetRide`.`status_id`, `SheetRide`.`id`,  `SheetRide`.`car_id`, 
                          `SheetRide`.`car_subcontracting`, `SheetRide`.`car_name`, `SheetRide`.`remorque_name`, 
                          `SheetRide`.`customer_name`, `SheetRide`.`start_date`, `SheetRide`.`real_start_date`, 
                          `SheetRide`.`end_date`, `SheetRide`.`real_end_date`, CONCAT(`Customer`.`first_name`,' - ', `Customer`.`last_name`) as full_name,
                           CONCAT(`Car`.`code` ,' / ', `Carmodel`.`name`) as car_name,
                          `Car`.`immatr_def`, `Carmodel`.`name`,  `CancelCause`.`name` FROM `sheet_rides` AS `SheetRide` 
                          left JOIN `car` AS `Car` ON (`SheetRide`.`car_id` = `Car`.`id`) 
                          left JOIN `car_types` AS `CarType` ON (`SheetRide`.`car_type_id` = `CarType`.`id`) 
                          left JOIN `customers` AS `Customer` ON (`SheetRide`.`customer_id` = `Customer`.`id`) 
                          left JOIN `carmodels` AS `Carmodel` ON (`Car`.`carmodel_id` = `Carmodel`.`id`) 
                          left JOIN `cancel_causes` AS `CancelCause` ON (`SheetRide`.`cancel_cause_id` = `CancelCause`.`id`) 
                          left JOIN `sheet_ride_detail_rides` AS `SheetRideDetailRides` ON (`SheetRide`.`id` = `SheetRideDetailRides`.`sheet_ride_id`) 
                          WHERE estimated_cost > cost  " ;

        $query['conditions'] = $conditions.$searchConditions;
        $query['columns'] = array(
            0 => array('SheetRide.reference','SheetRide', 'reference', 'Reference', 'string',''),
            1 => array('Carmodel.name','0', 'car_name',  'Car', 'string','CONCAT','Carmodel.name','Car.code', 'SheetRide.car_name', 'SheetRide.car_name'),
            2 => array('Customer.first_name','0', 'full_name','Customer', 'string','CONCAT', 'Customer.first_name','Customer.last_name', 'SheetRide.customer_name', 'SheetRide.customer_name'),
            3 => array('SheetRide.start_date','SheetRide', 'start_date', 'Start date', 'datetime',''),
            4 => array('SheetRide.real_start_date','SheetRide', 'real_start_date', 'Real start date', 'datetime',''),
            5 => array('SheetRide.real_end_date','SheetRide', 'real_end_date', 'Real end date', 'datetime',''),
            6 => array('SheetRide.status_id','SheetRide', 'status_id', 'Status', 'number',''),
        );
        $query['order'] = ' SheetRide.id desc';
        $query['group'] = ' SheetRide.id ';
        $query['tableName'] = 'SheetRide';
        $query['entityName'] = 'SheetRide';
        $query['controller'] = 'sheetRides';
        $query['action'] = 'sheetRidesWithConsumption';
        $query['itemName'] = array('reference');
        $this->Session->write('query', $query);
        //get default user limit value
        $defaultLimit =  $this->getLimit();
        if (isset($defaultLimit) && $defaultLimit > 0) {
            $this->set('defaultLimit', $defaultLimit);
        } else {
            $this->set('defaultLimit', 20);
        }

        //Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set(compact( 'param'));
        $users = $this->User->getUsers();
        $profiles = $this->Profile->getUserProfiles();
        $rideCategories = $this->RideCategory->getRideCategories();
        $reportingChoosed = $this->reportingChoosed();
        $this->Session->write('reportingChoosed', $reportingChoosed);
        if ($reportingChoosed == 3) {
            $informationJasperReport = $this->Parameter->getInformationJasperReport();
            $this->set('informationJasperReport', $informationJasperReport);
            $this->Session->write('informationJasperReport', $informationJasperReport);
        }
        $useRideCategory = $this->useRideCategory();
        $client_i2b = $this->isCustomerI2B();
        $hasSaleModule = $this->hasSaleModule();
        $isSuperAdmin = $this->isSuperAdmin();
        $parcs = $this->Parc->getParcs('list');

        $controller =  'sheetRides';
        $action = 'sheetRidesWithConsumption';
        $deleteFonction =  'deleteSheetRides';
        $this->set(compact('profiles', 'users', 'rideCategories', 'isAgent', 'reportingChoosed', 'useRideCategory',
            'client_i2b', 'hasSaleModule', 'isSuperAdmin', 'coupons', 'parcs','controller','action','deleteFonction'));

    }

    /**
     * @param null $params
     * @return array
     */

    public function getOrder($params = null , $orderType = null)
    {
        if($orderType == null){
            $orderType = 'DESC';
        }
        if (isset($params) && is_numeric($params)) {
            switch ($params) {
                case 1 :
                    $order = array('SheetRide.reference' => $orderType);
                    break;
                case 2 :
                    $order = array('SheetRide.id' => $orderType);
                    break;
                case 3 :
                    $order = array('SheetRide.real_start_date' => $orderType);
                    break;
                case 4 :
                    $order = array('SheetRide.real_end_date' => $orderType);
                    break;

                default :
                    $order = array('SheetRide.real_start_date' => $orderType);
            }
            return $order;
        } else {
            $order = array('SheetRide.id' => $orderType);

            return $order;
        }
    }

    /**
     * index method
     *
     * @return void
     */
    public function search()
    {
        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();

        if (isset($this->request->data['keyword']) || isset($this->request->data['SheetRides']['user_id']) ||
            isset($this->request->data['SheetRides']['modified_id']) || isset($this->request->data['SheetRides']['status_id'])
            || isset($this->request->data['SheetRides']['created']) || isset($this->request->data['SheetRides']['created1'])
            || isset($this->request->data['SheetRides']['modified']) || isset($this->request->data['SheetRides']['modified1'])
            || isset($this->request->data['SheetRides']['start_date1']) || isset($this->request->data['SheetRides']['start_date2'])
            || isset($this->request->data['SheetRides']['end_date1']) || isset($this->request->data['SheetRides']['end_date2'])
            || isset($this->request->data['SheetRides']['date2']) || isset($this->request->data['SheetRides']['detail_ride_id'])
            || isset($this->request->data['SheetRides']['ride_category_id']) || isset($this->request->data['SheetRides']['parc_id'])
            || isset($this->request->data['SheetRides']['car_id']) || isset($this->request->data['SheetRides']['supplier_id'])
            || isset($this->request->data['SheetRides']['customer_id']) || isset($this->request->data['SheetRides']['profile_id'])

        ) {
            $this->filterUrl();
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('SheetRide.reference' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword']) || isset($this->params['named']['user']) || isset($this->params['named']['customer'])
            || isset($this->params['named']['created']) || isset($this->params['named']['created1'])
            || isset($this->params['named']['ride']) || isset($this->params['named']['car'])
            || isset($this->params['named']['category']) || isset($this->params['named']['parc'])
            || isset($this->params['named']['supplier']) || isset($this->params['named']['status']) || isset($this->params['named']['profile'])
            || isset($this->params['named']['modified_id']) || isset($this->params['named']['type'])
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
                'group' => array('SheetRide.id'),
                'fields' => array(
                    'reference',
                    'status_id',
                    'SheetRide.id',
                    'SheetRide.car_subcontracting',
                    'SheetRide.car_name',
                    'SheetRide.remorque_name',
                    'SheetRide.customer_name',
                    'start_date',
                    'real_start_date',
                    'end_date',
                    'real_end_date',
                    'car_id',
                    'customer_id',
                    'CarType.name',
                    'Car.code',
                    'Customer.first_name',
                    'Customer.last_name',
                    'Car.immatr_def',
                    'Carmodel.name',
                    'CancelCause.name'
                ),
                'joins' => array(
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
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('SheetRide.customer_id = Customer.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),
                    array(
                        'table' => 'sheet_ride_detail_rides',
                        'type' => 'left',
                        'alias' => 'SheetRideDetailRides',
                        'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                    ),
                    array(
                        'table' => 'attachments',
                        'type' => 'left',
                        'alias' => 'Attachment',
                        'conditions' => array('Attachment.article_id = SheetRideDetailRides.id')
                    ),
                    array(
                        'table' => 'bills',
                        'type' => 'left',
                        'alias' => 'Bill',
                        'conditions' => array('Bill.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
                    ),
                    array(
                        'table' => 'bill_products',
                        'type' => 'left',
                        'alias' => 'BillProduct',
                        'conditions' => array('Bill.id = BillProduct.bill_id')
                    ),
                    array(
                        'table' => 'lots',
                        'type' => 'left',
                        'alias' => 'Lot',
                        'conditions' => array('Lot.id = BillProduct.lot_id')
                    ),
                    array(
                        'table' => 'detail_rides',
                        'type' => 'left',
                        'alias' => 'DetailRide',
                        'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('SheetRideDetailRides.supplier_id = Supplier.id')
                    ),
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('SheetRide.user_id = User.id')
                    ),
                    array(
                        'table' => 'cancel_causes',
                        'type' => 'left',
                        'alias' => 'CancelCause',
                        'conditions' => array('SheetRide.cancel_cause_id = CancelCause.id')
                    )
                )
            );
            $this->set('sheetRides', $this->Paginator->paginate('SheetRide'));
        } else {
            $this->SheetRide->recursive = 0;
            $this->set('sheetRides', $this->Paginator->paginate('SheetRide'));
        }
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set(compact('limit', 'param', 'order'));

        $users = $this->User->getUsers();
        $profiles = $this->Profile->getUserProfiles();
        $rideCategories = $this->RideCategory->getRideCategories();
        $isAgent = $this->isAgent();
        $useRideCategory = $this->useRideCategory();
        $hasSaleModule = $this->hasSaleModule();
        $reportingChoosed = $this->reportingChoosed();
        if ($reportingChoosed == 3) {
            $informationJasperReport = $this->Parameter->getInformationJasperReport();
            $this->set('informationJasperReport', $informationJasperReport);
        }
        $client_i2b = $this->isCustomerI2B();
        $isSuperAdmin = $this->isSuperAdmin();
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
        $parcs = $this->Parc->getParcs('list');
        $sumCost = $this->SheetRide->getSumCost($conditions);
        $sumConsumption = $this->SheetRide->getSumConsumption($conditions);
        $sumKm = $this->SheetRide->getSumKm($conditions);
        $this->set(compact(
            'sumCost', 'sumConsumption', 'sumKm',
            'profiles',
            'users',
            'rideCategories',
            'isAgent',
            'useRideCategory',
            'hasSaleModule',
            'reportingChoosed',
            'client_i2b',
            'isSuperAdmin',
            'coupons', 'parcs'
        ));
    }

    private function filterUrl()
    {
        $filter_url['controller'] = $this->request->params['controller'];
        $filter_url['action'] = $this->request->params['action'];
        $filter_url['page'] = 1;
        $filter_url['keyword'] = $this->request->data['keyword'];
        $filter_url['keyword'] = str_replace('/', '-', $filter_url['keyword']);

        if(isset($this->params['pass']['0'])){
            $filter_url[0] = $this->params['pass']['0'];
        }
        if(isset($this->params['pass']['1'])){
            $filter_url[1] = $this->params['pass']['1'];
        }
        if (isset($this->request->data['SheetRides']['status_id']) && !empty($this->request->data['SheetRides']['status_id'])) {
            $filter_url['status'] = $this->request->data['SheetRides']['status_id'];
        }
        if (isset($this->request->data['SheetRides']['car_id']) && !empty($this->request->data['SheetRides']['car_id'])) {
            $filter_url['car'] = $this->request->data['SheetRides']['car_id'];
        }

        if (isset($this->request->data['SheetRides']['parc_id']) && !empty($this->request->data['SheetRides']['parc_id'])) {
            $filter_url['parc'] = $this->request->data['SheetRides']['parc_id'];
        }

        if (isset($this->request->data['SheetRides']['customer_id']) && !empty($this->request->data['SheetRides']['customer_id'])) {
            $filter_url['customer'] = $this->request->data['SheetRides']['customer_id'];
        }

        if (isset($this->request->data['SheetRides']['detail_ride_id']) && !empty($this->request->data['SheetRides']['detail_ride_id'])) {
            $filter_url['ride'] = $this->request->data['SheetRides']['detail_ride_id'];
        }
        if (isset($this->request->data['SheetRides']['ride_category_id']) && !empty($this->request->data['SheetRides']['ride_category_id'])) {
            $filter_url['category'] = $this->request->data['SheetRides']['ride_category_id'];
        }

        if (isset($this->request->data['SheetRides']['supplier_id']) && !empty($this->request->data['SheetRides']['supplier_id'])) {
            $filter_url['supplier'] = $this->request->data['SheetRides']['supplier_id'];
        }
        if (isset($this->request->data['SheetRides']['user_id']) && !empty($this->request->data['SheetRides']['user_id'])) {
            $filter_url['user'] = $this->request->data['SheetRides']['user_id'];
        }

        if (isset($this->request->data['SheetRides']['profile_id']) && !empty($this->request->data['SheetRides']['profile_id'])) {
            $filter_url['profile'] = $this->request->data['SheetRides']['profile_id'];
        }

        if (isset($this->request->data['SheetRides']['created']) && !empty($this->request->data['SheetRides']['created'])) {
            $filter_url['created'] = str_replace("/", "-", $this->request->data['SheetRides']['created']);
        }
        if (isset($this->request->data['SheetRides']['created1']) && !empty($this->request->data['SheetRides']['created1'])) {
            $filter_url['created1'] = str_replace("/", "-", $this->request->data['SheetRides']['created1']);
        }
        if (isset($this->request->data['SheetRides']['modified_id']) && !empty($this->request->data['SheetRides']['modified_id'])) {
            $filter_url['modified_id'] = $this->request->data['SheetRides']['modified_id'];
        }
        if (isset($this->request->data['SheetRides']['modified']) && !empty($this->request->data['SheetRides']['modified'])) {
            $filter_url['modified'] = str_replace("/", "-", $this->request->data['SheetRides']['modified']);
        }
        if (isset($this->request->data['SheetRides']['modified1']) && !empty($this->request->data['SheetRides']['modified1'])) {
            $filter_url['modified1'] = str_replace("/", "-", $this->request->data['SheetRides']['modified1']);
        }
        if (isset($this->request->data['SheetRides']['start_date1']) && !empty($this->request->data['SheetRides']['start_date1'])) {
            $filter_url['start_date1'] = str_replace("/", "-", $this->request->data['SheetRides']['start_date1']);
        }
        if (isset($this->request->data['SheetRides']['start_date2']) && !empty($this->request->data['SheetRides']['start_date2'])) {
            $filter_url['start_date2'] = str_replace("/", "-", $this->request->data['SheetRides']['start_date2']);
        }
        if (isset($this->request->data['SheetRides']['end_date1']) && !empty($this->request->data['SheetRides']['end_date1'])) {
            $filter_url['end_date1'] = str_replace("/", "-", $this->request->data['SheetRides']['end_date1']);
        }
        if (isset($this->request->data['SheetRides']['end_date2']) && !empty($this->request->data['SheetRides']['end_date2'])) {
            $filter_url['end_date2'] = str_replace("/", "-", $this->request->data['SheetRides']['end_date2']);
        }

        if (isset($this->request->data['SheetRides']['coupons_from']) && !empty($this->request->data['SheetRides']['coupons_from'])) {
            $filter_url['coupons_from'] = $this->request->data['SheetRides']['coupons_from'];
        }
        if (isset($this->request->data['SheetRides']['coupons_to']) && !empty($this->request->data['SheetRides']['coupons_to'])) {
            $filter_url['coupons_to'] = $this->request->data['SheetRides']['coupons_to'];
        }

        if (isset($this->request->data['SheetRides']['payment_mode']) && !empty($this->request->data['SheetRides']['payment_mode'])) {
            $filter_url['payment_mode'] = $this->request->data['SheetRides']['payment_mode'];
        }
        $this->redirect($filter_url);
    }

    private function getConds()
    {
        if (!empty($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $keyword = str_replace('-', '/', $keyword);
            $conds = array(
                'OR' => array(
                    "LOWER(SheetRide.reference) LIKE" => "%$keyword%",
                    "LOWER(Car.code) LIKE" => "%$keyword%",
                    "LOWER(Car.immatr_def) LIKE" => "%$keyword%",
                    "LOWER(Carmodel.name) LIKE" => "%$keyword%",
                    "LOWER(Customer.first_name) LIKE" => "%$keyword%",
                    "LOWER(Customer.last_name) LIKE" => "%$keyword%",
                    "LOWER(Attachment.attachment_number) LIKE" => "%$keyword%",
                    "LOWER(Lot.number) LIKE" => "%$keyword%",
                    "LOWER(Lot.label) LIKE" => "%$keyword%",
                )
            );
        } else {
            $conds = array();
        }

        if (isset($this->params['named']['status']) && !empty($this->params['named']['status'])) {
            $conds["SheetRide.status_id = "] = $this->params['named']['status'];
            $this->request->data['SheetRides']['status_id'] = $this->params['named']['status'];
        }
        if (isset($this->params['named']['car']) && !empty($this->params['named']['car'])) {
            $conds["SheetRide.car_id = "] = $this->params['named']['car'];
            $this->request->data['SheetRides']['car_id'] = $this->params['named']['car'];
        }

        if (isset($this->params['named']['parc']) && !empty($this->params['named']['parc'])) {
            $conds["Car.parc_id = "] = $this->params['named']['parc'];
            $this->request->data['SheetRides']['parc_id'] = $this->params['named']['parc'];
        }

        if (isset($this->params['named']['customer']) && !empty($this->params['named']['customer'])) {
            $conds["SheetRide.customer_id = "] = $this->params['named']['customer'];
            $this->request->data['SheetRides']['customer_id'] = $this->params['named']['customer'];
        }

        if (isset($this->params['named']['ride']) && !empty($this->params['named']['ride'])) {
            $conds["SheetRideDetailRides.detail_ride_id = "] = $this->params['named']['ride'];
            $this->request->data['SheetRides']['detail_ride_id'] = $this->params['named']['ride'];
        }

        if (isset($this->params['named']['supplier']) && !empty($this->params['named']['supplier'])) {
            $conds["SheetRideDetailRides.supplier_id = "] = $this->params['named']['supplier'];
            $this->request->data['SheetRides']['supplier_id'] = $this->params['named']['supplier'];
        }

        if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
            $conds["SheetRideDetailRides.ride_category_id = "] = $this->params['named']['category'];
            $this->request->data['SheetRides']['ride_category_id'] = $this->params['named']['category'];
        }

        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $conds["SheetRide.user_id = "] = $this->params['named']['user'];
            $this->request->data['SheetRides']['user_id'] = $this->params['named']['user'];
        }

        if (isset($this->params['named']['profile']) && !empty($this->params['named']['profile'])) {
            $conds["User.profile_id = "] = $this->params['named']['profile'];
            $this->request->data['SheetRides']['profile_id'] = $this->params['named']['profile'];
        }


        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $creat = str_replace("-", "/", $this->params['named']['created']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRide.created >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['SheetRides']['created'] = $creat;
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $creat = str_replace("-", "/", $this->params['named']['created1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRide.created <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['SheetRides']['created1'] = $creat;
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $conds["SheetRide.modified_id = "] = $this->params['named']['modified_id'];
            $this->request->data['SheetRides']['modified_id'] = $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRide.modified >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['SheetRides']['modified'] = $creat;
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRide.modified <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['SheetRides']['modified1'] = $creat;
        }
        if (isset($this->params['named']['start_date1']) && !empty($this->params['named']['start_date1'])) {
            $creat = str_replace("-", "/", $this->params['named']['start_date1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRide.start_date >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['SheetRides']['start_date1'] = $creat;
        }
        if (isset($this->params['named']['start_date2']) && !empty($this->params['named']['start_date2'])) {
            $creat = str_replace("-", "/", $this->params['named']['start_date2']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRide.start_date <= "] = $startdtm->format('Y-m-d 23:59:00');
            $this->request->data['SheetRides']['start_date2'] = $creat;
        }
        if (isset($this->params['named']['end_date1']) && !empty($this->params['named']['end_date1'])) {
            $creat = str_replace("-", "/", $this->params['named']['end_date1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRide.end_date >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['SheetRides']['end_date1'] = $creat;
        }
        if (isset($this->params['named']['end_date2']) && !empty($this->params['named']['end_date2'])) {
            $creat = str_replace("-", "/", $this->params['named']['end_date2']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["SheetRide.end_date <= "] = $startdtm->format('Y-m-d 23:59:00');
            $this->request->data['SheetRides']['end_date2'] = $creat;
        }

        if (isset($this->params['named']['payment_mode']) && !empty($this->params['named']['payment_mode'])) {
            switch ($this->params['named']['payment_mode']) {
                case 1:
                    $conds["SheetRides.coupons_number > "] = 0;
                    break;

                case 2:
                    $conds["SheetRides.species > "] = 0;
                    break;

                case 3:
                    $conds["SheetRides.card_id > "] = 0;
                    break;

                case 4:
                    $conds["SheetRides.consumption_liter > "] = 0;
                    break;
            }
            $this->request->data['SheetRides']['payment_mode'] = $this->params['named']['payment_mode'];


        }
        if (isset($this->params['named']['coupons_from']) && !empty($this->params['named']['coupons_from'])) {
            $conds["Coupon.id >= "] = $this->params['named']['coupons_from'];
            $this->request->data['SheetRides']['coupons_from'] = $this->params['named']['coupons_from'];
        }
        if (isset($this->params['named']['coupons_to']) && !empty($this->params['named']['coupons_to'])) {
            $conds["Coupon.id <= "] = $this->params['named']['coupons_to'];
            $this->request->data['SheetRides']['coupons_to'] = $this->params['named']['coupons_to'];
        }
		
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
        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            $this->redirect('/');
        }

        $this->setTimeActif();
        if (!$this->SheetRide->exists($id)) {
            throw new NotFoundException(__('Invalid sheet ride'));
        }
        $options = array(
            'conditions' => array('SheetRide.' . $this->SheetRide->primaryKey => $id),
            'recursive' => -1,
            'fields' => array(
                'CarType.name',
                'SheetRide.reference',
                'SheetRide.created',
                'SheetRide.modified',
                'SheetRide.id',
                'Carmodel.name',
                'Car.code',
                'Car.immatr_def',
                'SheetRide.start_date',
                'SheetRide.real_start_date',
                'SheetRide.end_date',
                'SheetRide.real_end_date',
                'SheetRide.status_id',
                'SheetRide.km_departure',
                'SheetRide.km_arrival',
                'Customer.first_name',
                'Customer.last_name',
                'User.first_name',
                'User.last_name',
                'Modifier.first_name',
                'Modifier.last_name',

            ),
            'joins' => array(
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
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('SheetRide.customer_id = Customer.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('SheetRide.car_type_id = CarType.id')
                ),

                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'User',
                    'conditions' => array('SheetRide.user_id = User.id')
                ),
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'Modifier',
                    'conditions' => array('SheetRide.modified_id = Modifier.id')
                ),

            )
        );

        $sheetRide = $this->SheetRide->find('first', $options);

        $this->set('sheetRide', $sheetRide);


        $sheetRideDetailRides = $this->SheetRideDetailRides->find('all', array(

            'recursive' => -1, // should be used with joins
            'order' => array('SheetRideDetailRides.id' => 'ASC'),
            'conditions' => array('SheetRideDetailRides.sheet_ride_id' => $id),
            'fields' => array(
                'SheetRideDetailRides.reference',
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.created',
                'SheetRideDetailRides.modified',
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
                'SheetRideDetailRides.invoiced_ride',
                'SheetRideDetailRides.transport_bill_detail_ride_id',
                'CarType.name',
                'Supplier.name',
                'SupplierFinal.name',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'User.first_name',
                'User.last_name',
                'Modifier.first_name',
                'Modifier.last_name',


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
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'SupplierFinal',
                    'conditions' => array('SheetRideDetailRides.supplier_final_id = SupplierFinal.id')
                ),
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'User',
                    'conditions' => array('SheetRideDetailRides.user_id = User.id')
                ),
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'Modifier',
                    'conditions' => array('SheetRideDetailRides.modified_id = Modifier.id')
                )

            )
        ));

        $consumptions = $this->Consumption->getConsumptionsBySheetRideId($id, 1);
        $this->set('consumptions', $consumptions);

        $company = $this->Company->find('first');
        $wilayaId = $company['Company']['wilaya'];
        $destination = $this->Destination->find('first', array('conditions' => array('Destination.id' => $wilayaId)));
        $wilayaName = $destination['Destination']['name'];
        if (!empty($sheetRideDetailRides)) {

        $detailRideId = $sheetRideDetailRides[0]['SheetRideDetailRides']['detail_ride_id'];
        $detailRide = $this->SheetRideDetailRides->find('first', array(
            'recursive' => -1,
            'fields' => array('DepartureDestination.id', 'DepartureDestination.name', 'CarType.id', 'CarType.name'),
            'conditions' => array('DetailRide.id' => $detailRideId),
            'joins' => array(
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('DetailRide.id = SheetRideDetailRides.detail_ride_id')
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
            )
        ));
        $departureDestinationId = $detailRide['DepartureDestination']['id'];
        $departureDestinationName = $detailRide['DepartureDestination']['name'];
        $carTypeName = $detailRide['CarType']['name'];

        $rides = array();
        if ($departureDestinationId != $wilayaId) {
            $rides[0]['reference'] = '';
            $rides[0]['departureDestinationName'] = $wilayaName;
            $rides[0]['arrivalDestinationName'] = $departureDestinationName;
            $rides[0]['carTypeName'] = $carTypeName;
            $rides[0]['status_id'] = '';
            $rides[0]['invoiced_ride'] = 0;
            $rides[0]['Supplier'] = '';
            $rides[0]['SupplierFinal'] = '';
            $rides[0]['real_start_date'] = $sheetRide['SheetRide']['real_start_date'];
            $rides[0]['real_end_date'] = $sheetRideDetailRides[0]['SheetRideDetailRides']['real_start_date'];
            $rides[0]['planned_start_date'] = '';
            $rides[0]['planned_end_date'] = '';
            $rides[0]['km_departure'] = $sheetRideDetailRides[0]['SheetRideDetailRides']['km_departure'];
            $rides[0]['km_arrival'] = $sheetRideDetailRides[0]['SheetRideDetailRides']['km_arrival'];
            $rides[0]['user'] = '';
            $rides[0]['modifier'] = '';
            $rides[0]['created'] = '';
            $rides[0]['modified'] = '';
        }
        $nbSheetRideDetailRides = count($sheetRideDetailRides);
        $j = 1;
        for ($i = 0; $i < $nbSheetRideDetailRides; $i++) {
            $rides[$j]['reference'] = $sheetRideDetailRides[$i]['SheetRideDetailRides']['reference'];
            $rides[$j]['departureDestinationName'] = $sheetRideDetailRides[$i]['DepartureDestination']['name'];
            $rides[$j]['arrivalDestinationName'] = $sheetRideDetailRides[$i]['ArrivalDestination']['name'];
            $rides[$j]['carTypeName'] = $sheetRideDetailRides[$i]['CarType']['name'];
            $rides[$j]['status_id'] = $sheetRideDetailRides[$i]['SheetRideDetailRides']['status_id'];
            $rides[$j]['invoiced_ride'] = $sheetRideDetailRides[$i]['SheetRideDetailRides']['invoiced_ride'];
            $rides[$j]['real_start_date'] = $sheetRideDetailRides[$i]['SheetRideDetailRides']['real_start_date'];
            $rides[$j]['real_end_date'] = $sheetRideDetailRides[$i]['SheetRideDetailRides']['real_end_date'];
            $rides[$j]['planned_start_date'] = $sheetRideDetailRides[$i]['SheetRideDetailRides']['planned_start_date'];
            $rides[$j]['planned_end_date'] = $sheetRideDetailRides[$i]['SheetRideDetailRides']['planned_end_date'];
            $rides[$j]['km_departure'] = $sheetRideDetailRides[$i]['SheetRideDetailRides']['km_departure'];
            $rides[$j]['km_arrival'] = $sheetRideDetailRides[$i]['SheetRideDetailRides']['km_arrival'];
            $rides[$j]['Supplier'] = $sheetRideDetailRides[$i]['Supplier']['name'];
            $rides[$j]['SupplierFinal'] = $sheetRideDetailRides[$i]['SupplierFinal']['name'];
            $rides[$j]['user'] = $sheetRideDetailRides[$i]['User']['first_name'] . '-' . $sheetRideDetailRides[$i]['User']['last_name'];
            $rides[$j]['modifier'] = $sheetRideDetailRides[$i]['Modifier']['first_name'] . '-' . $sheetRideDetailRides[$i]['Modifier']['last_name'];
            $rides[$j]['created'] = $sheetRideDetailRides[$i]['SheetRideDetailRides']['created'];
            $rides[$j]['modified'] = $sheetRideDetailRides[$i]['SheetRideDetailRides']['modified'];
            $j++;
            if ($i != $nbSheetRideDetailRides - 1) {
                $detailRideArrival = $this->SheetRideDetailRides->find('first', array(
                    'recursive' => -1,
                    'fields' => array('ArrivalDestination.id', 'ArrivalDestination.name', 'CarType.id', 'CarType.name'),
                    'conditions' => array('DetailRide.id' => $sheetRideDetailRides[$i]['SheetRideDetailRides']['detail_ride_id']),
                    'joins' => array(
                        array(
                            'table' => 'detail_rides',
                            'type' => 'left',
                            'alias' => 'DetailRide',
                            'conditions' => array('DetailRide.id = SheetRideDetailRides.detail_ride_id')
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
                            'alias' => 'ArrivalDestination',
                            'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                        ),
                    )
                ));
                $arrivalDestinationId = $detailRideArrival['ArrivalDestination']['id'];
                $arrivalDestinationName = $detailRideArrival['ArrivalDestination']['name'];

                $detailRideDeparture = $this->SheetRideDetailRides->find('first', array(
                    'recursive' => -1,
                    'fields' => array(
                        'DepartureDestination.id',
                        'DepartureDestination.name',
                        'CarType.id',
                        'CarType.name'
                    ),
                    'conditions' => array('DetailRide.id' => $sheetRideDetailRides[$i + 1]['SheetRideDetailRides']['detail_ride_id']),
                    'joins' => array(
                        array(
                            'table' => 'detail_rides',
                            'type' => 'left',
                            'alias' => 'DetailRide',
                            'conditions' => array('DetailRide.id = SheetRideDetailRides.detail_ride_id')
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
                    )
                ));
                $departureDestinationId = $detailRideDeparture['DepartureDestination']['id'];
                $departureDestinationName = $detailRideDeparture['DepartureDestination']['name'];
                if ($departureDestinationId != $arrivalDestinationId) {
                    $rides[$j]['reference'] = '';
                    $rides[$j]['departureDestinationName'] = $arrivalDestinationName;
                    $rides[$j]['arrivalDestinationName'] = $departureDestinationName;
                    $rides[$j]['carTypeName'] = $carTypeName;
                    $rides[$j]['status_id'] = '';
                    $rides[$j]['invoiced_ride'] = 0;
                    $rides[$j]['Supplier'] = '';
                    $rides[$j]['SupplierFinal'] = '';
                    $rides[$j]['real_start_date'] = $sheetRideDetailRides[$i]['SheetRideDetailRides']['real_end_date'];
                    $rides[$j]['real_end_date'] = $sheetRideDetailRides[$i + 1]['SheetRideDetailRides']['real_start_date'];
                    $rides[$j]['planned_start_date'] = '';
                    $rides[$j]['planned_end_date'] = '';
                    $rides[$j]['km_departure'] = $sheetRideDetailRides[$i]['SheetRideDetailRides']['km_arrival'];
                    $rides[$j]['km_arrival'] = $sheetRideDetailRides[$i + 1]['SheetRideDetailRides']['km_departure'];
                    $rides[$j]['user'] = '';
                    $rides[$j]['modifier'] = '';
                    $rides[$j]['created'] = '';
                    $rides[$j]['modified'] = '';
                    $j++;
                }
            }
        }
        $detailRideId = $sheetRideDetailRides[$nbSheetRideDetailRides - 1]['SheetRideDetailRides']['detail_ride_id'];
        $detailRide = $this->SheetRideDetailRides->find('first', array(
            'recursive' => -1,
            'fields' => array('ArrivalDestination.id', 'ArrivalDestination.name', 'CarType.id', 'CarType.name'),
            'conditions' => array('DetailRide.id' => $detailRideId),
            'joins' => array(
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('DetailRide.id = SheetRideDetailRides.detail_ride_id')
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
                    'alias' => 'ArrivalDestination',
                    'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                ),
            )
        ));
        $arrivalDestinationId = $detailRide['ArrivalDestination']['id'];
        $arrivalDestinationName = $detailRide['ArrivalDestination']['name'];
        $carTypeName = $detailRide['CarType']['name'];
        if ($arrivalDestinationId != $wilayaId) {
            $rides[$j]['reference'] = '';
            $rides[$j]['departureDestinationName'] = $arrivalDestinationName;
            $rides[$j]['arrivalDestinationName'] = $wilayaName;
            $rides[$j]['carTypeName'] = $carTypeName;
            $rides[$j]['status_id'] = '';
            $rides[$j]['invoiced_ride'] = 0;
            $rides[$j]['Supplier'] = '';
            $rides[$j]['SupplierFinal'] = '';
            $rides[$j]['real_start_date'] = $sheetRideDetailRides[$nbSheetRideDetailRides - 1]['SheetRideDetailRides']['real_end_date'];
            $rides[$j]['real_end_date'] = $sheetRide['SheetRide']['real_end_date'];
            $rides[$j]['planned_start_date'] = '';
            $rides[$j]['planned_end_date'] = '';
            $rides[$j]['km_departure'] = $sheetRideDetailRides[$nbSheetRideDetailRides - 1]['SheetRideDetailRides']['km_arrival'];
            $rides[$j]['km_arrival'] = $sheetRide['SheetRide']['km_arrival'];
            $rides[$j]['user'] = '';
            $rides[$j]['modifier'] = '';
            $rides[$j]['created'] = '';
            $rides[$j]['modified'] = '';
        }
        $this->set('rides', $rides);
    }
        $attachments = $this->Attachment->getAttachmentsBySheetRideId($id);

        $path = dirname(__DIR__) . DS . "webroot";
        $this->set('path', $path);
        $this->set('attachments', $attachments);
        $this->set('sheetRideDetailRides', $sheetRideDetailRides);
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set('param', $param);

    }

    public function getDetailRideBetweenTwoRide(
        $i = null,
        $departureDetailRideId = null,
        $arrivalDetailRideId = null,
        $departureFromCustomerOrder = 0,
        $arrivalFromCustomerOrder = 0
    )
    {

        if ($departureFromCustomerOrder == 1) {
            $detailRide = $this->TransportBillDetailRides->find('first', array(
                'conditions' => array('TransportBillDetailRides.id' => $departureDetailRideId),
                'fields' => array('TransportBillDetailRides.detail_ride_id',
                    'TransportBillDetailRides.type_ride',
                    'TransportBillDetailRides.departure_destination_id',
                    'TransportBillDetailRides.arrival_destination_id',
                    'TransportBillDetailRides.car_type_id',
                )
            ));
            if ($detailRide['TransportBillDetailRides']['type_ride'] == 2) {
                $departureDestinationId = $detailRide['TransportBillDetailRides']['arrival_destination_id'];
            } else {
                $departureDetailRideId = $detailRide['TransportBillDetailRides']['detail_ride_id'];
                $departureDetailRide = $this->DetailRide->find('first', array(
                    'recursive' => -1,
                    'fields' => array(
                        'ArrivalDestination.id',
                        'ArrivalDestination.name',
                        'ArrivalDestination.latlng',
                        'CarType.id'
                    ),
                    'conditions' => array('DetailRide.id' => $departureDetailRideId),
                    'joins' => array(
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
                        )
                    )
                ));
                $departureDestinationId = $departureDetailRide['ArrivalDestination']['id'];
            }

        } else {
            $departureDetailRide = $this->SheetRideDetailRides->DetailRide->find('first', array(
                'recursive' => -1,
                'fields' => array(
                    'ArrivalDestination.id',
                    'ArrivalDestination.name',
                    'ArrivalDestination.latlng',
                    'CarType.id'
                ),
                'conditions' => array('DetailRide.id' => $departureDetailRideId),
                'joins' => array(
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
                    )
                )
            ));
            if(!empty($departureDetailRide)){
                $departureDestinationId = $departureDetailRide['ArrivalDestination']['id'];
            }else {
                $departureDestinationId ='';
            }

        }


        if ($arrivalFromCustomerOrder == 1) {
            $detailRide = $this->TransportBillDetailRides->find('first', array(
                'conditions' => array('TransportBillDetailRides.id' => $arrivalDetailRideId),
                'fields' => array('TransportBillDetailRides.detail_ride_id',
                    'TransportBillDetailRides.type_ride',
                    'TransportBillDetailRides.departure_destination_id',
                    'TransportBillDetailRides.arrival_destination_id',
                    'TransportBillDetailRides.car_type_id',
                )));
            if ($detailRide['TransportBillDetailRides']['type_ride'] == 2) {
                if (!empty($detailRide)) {
                    $arrivalDestinationId = $detailRide['TransportBillDetailRides']['departure_destination_id'];
                } else {
                    $arrivalDestinationId = '';
                }
            } else {
                $arrivalDetailRideId = $detailRide['TransportBillDetailRides']['detail_ride_id'];
                $arrivalDetailRide = $this->DetailRide->find('first', array(
                    'recursive' => -1,
                    'fields' => array(
                        'DepartureDestination.id',
                        'DepartureDestination.name',
                        'DepartureDestination.latlng',
                        'CarType.id'
                    ),
                    'conditions' => array('DetailRide.id' => $arrivalDetailRideId),
                    'joins' => array(
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
                        )
                    )
                ));
                if (!empty($arrivalDetailRide)) {
                    $arrivalDestinationId = $arrivalDetailRide['DepartureDestination']['id'];
                } else {
                    $arrivalDestinationId = '';
                }
            }

        } else {
            $arrivalDetailRide = $this->SheetRideDetailRides->DetailRide->find('first', array(
                'recursive' => -1,
                'fields' => array(
                    'DepartureDestination.id',
                    'DepartureDestination.name',
                    'DepartureDestination.latlng',
                    'CarType.id'
                ),
                'conditions' => array('DetailRide.id' => $arrivalDetailRideId),
                'joins' => array(
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
                    )
                )
            ));
            if (!empty($arrivalDetailRide)) {
                $arrivalDestinationId = $arrivalDetailRide['DepartureDestination']['id'];
            } else {
                $arrivalDestinationId = '';
            }
        }

        $detailRide = $this->DetailRide->find('first', array(
            'conditions' => array(
                'OR' => array(
                    array(
                        'Ride.departure_destination_id' => $departureDestinationId,
                        'Ride.arrival_destination_id' => $arrivalDestinationId
                    ),
                    array(
                        'Ride.arrival_destination_id' => $departureDestinationId,
                        'Ride.departure_destination_id' => $arrivalDestinationId
                    )
                )
            ),
            'recursive' => -1,
            'fields' => array(
                'Ride.distance',
                'DetailRide.real_duration_hour',
                'DetailRide.real_duration_day',
                'DetailRide.real_duration_minute'
            ),
            'joins' => array(
                array(
                    'table' => 'rides',
                    'type' => 'left',
                    'alias' => 'Ride',
                    'conditions' => array('DetailRide.ride_id = Ride.id')
                )
            )
        ));
        if (empty($detailRide)) {
            $this->loadModel('Destination');
            $departure = $this->Destination->find('first', array(
                'conditions' => array('Destination.id' => $arrivalDestinationId),
                'recursive' => -1,
                'fields' => array('name', 'latlng')
            ));
            if (!empty($departure)) {
                $departureDestinationName = $departure['Destination']['name'];
                $departureDestinationLatlng = $departure['Destination']['latlng'];
            } else {
                $departureDestinationName = '';
                $departureDestinationLatlng = '';
            }
            $arrival = $this->Destination->find('first', array(
                'conditions' => array('Destination.id' => $departureDestinationId),
                'recursive' => -1,
                'fields' => array('name', 'latlng')
            ));

            if (!empty($arrival)) {
                $arrivalDestinationName = $arrival['Destination']['name'];
                $arrivalDestinationLatlng = $arrival['Destination']['latlng'];
            } else {
                $arrivalDestinationName = '';
                $arrivalDestinationLatlng = '';
            }

            $this->set(compact('departureDestinationName', 'arrivalDestinationName', 'departureDestinationLatlng',
                'arrivalDestinationLatlng'));
        }
        $this->set(compact('detailRide', 'i'));
    }

    public function getCouponPrice()
    {
        $parameter = $this->Parameter->find('all', array(
            'recursive' => -1,
            'conditions' => array('code' => array(10)),
            'order' => array('code' => 'ASC')
        ));
        $couponPrice = $parameter[0]['Parameter']['val'];
        $this->set('couponPrice', $couponPrice);
    }

    function getFuelPrice($carId = null)
    {
        $this->loadModel('Fuel');
        $result = $this->Car->find('first', array('conditions' => array('Car.id' => $carId)));
        $fuelPrice = $result['Fuel']['price'];
        $this->set('fuelPrice', $fuelPrice);

    }

    public function add($transportBillDetailRideId = null, $observationId = null, $controller= null,
                        $url= null , $page = null, $transportBillDetailedRideId = null)
    {
        if(!empty($controller) && $controller == 'null'){
            $controller = null;
        }
        if(!empty($url) && $url == 'null'){
            $url = null;
        }
        if(!empty($page) && $page == 'null'){
            $page = null;
        }
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
        if(!empty($url)){
            $url = unserialize(base64_decode($url));
            $url =  explode($controller, $url);
            $url = '/'.$controller.$url[1].'?page='.$page;
        } else {
            $url =  array('controller' => 'sheetRides', 'action' => 'index');
        }
        if(isset($transportBillDetailRideId) && !empty($transportBillDetailRideId)){
            $this->isOpenedByOtherUser("TransportBillDetailRides", 'SheetRides', 'transport bill',
                $transportBillDetailRideId);
        }
        $this->setTimeActif();
        date_default_timezone_set("Africa/Algiers");
        $user_id = $this->Auth->user('id');
        // Verify access rights for user's profile : add sheeet ride
        $this->verifyUserPermission(SectionsEnum::feuille_de_route, $user_id, ActionsEnum::add,
            "SheetRides", null, "SheetRide", null);
        // Get necessary params, param_marchandise : has marchandises ?; param_price : may be paid in prefacture
        $reference = $this->getNextTransportReference(TransportBillTypesEnum::sheet_ride);
        $this->set('reference', $reference);
        // Get reference mission automatic parameter reference_mi_auto
        $isReferenceMissionAutomatic = $this->Parameter->getCodesParameterVal('reference_mi_auto');
        $this->set('isReferenceMissionAutomatic', $isReferenceMissionAutomatic);
        //Verify if we have single or multiple choices in consumption
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                if (isset($transportBillDetailRideId) && !empty($transportBillDetailRideId)) {
                    $this->TransportBillDetailRides->id = $transportBillDetailRideId;
                    $this->TransportBillDetailRides->saveField('is_open', 0);
                }
                $this->redirect($url);
            }
            // calculate diff between date open and date submit if diff > 15 min redirect to index dont save modification
            $currentDateAdd = $this->request->data['SheetRide']['currentDateAdd'];
            $currentDateSubmit = date('Y-m-d H:i');
            $currentDateAdd = new DateTime ($currentDateAdd);
            $currentDateSubmit = new DateTime ($currentDateSubmit);
            $interval = date_diff($currentDateAdd, $currentDateSubmit);
            $total = $interval->y * 526600 + $interval->m * 43800 + $interval->d * 1440 + $interval->h * 60 + $interval->i;
            if ($total > 15) {
                $this->Flash->error(__('The sheet ride could not be saved4. Please, try again.'));
                $this->redirect($url);
            }
            $this->SheetRide->create();
            $reference = $this->getNextTransportReference(TransportBillTypesEnum::sheet_ride);
            if ($reference != 0) {
                $this->request->data['SheetRide']['reference'] = $reference;
            }
            $this->createDatetimeFromDatetime('SheetRide', 'end_date');
            $this->createDatetimeFromDatetime('SheetRide', 'start_date');
            $this->createDatetimeFromDatetime('SheetRide', 'real_start_date');
            $this->createDatetimeFromDatetime('SheetRide', 'real_end_date');
            $this->request->data['SheetRide']['user_id'] = $this->Session->read('Auth.User.id');
            if (isset($this->request->data['SheetRide']['car_subcontracting']) && ($this->request->data['SheetRide']['car_subcontracting'] == 1)) {
                if(Configure::read('car_required')=='1'){
                    $this->SheetRide->validate = $this->SheetRide->validateSubcontractingRequired;
                }else {
                    $this->SheetRide->validate = $this->SheetRide->validateSubcontracting;
                }
            }
           /* var_dump($this->SheetRide->save($this->request->data));
            var_dump($this->SheetRide->validationErrors);die();*/
            if ($this->SheetRide->save($this->request->data)) {
                if (isset($this->request->data['SheetRide']['transport_bill_detailed_ride_id'])){
                    $insertedId = $this->SheetRide->getInsertID();
                    $this->TransportBillDetailedRides->id = $this->request->data['SheetRide']['transport_bill_detailed_ride_id'];
                    $this->TransportBillDetailedRides->saveField('sheet_ride_id',$insertedId);
                }
                $this->Parameter->setNextTransportReferenceNumber(TransportBillTypesEnum::sheet_ride);
                $sheetRideId = $this->SheetRide->getInsertID();
                if(!empty($this->request->data['SheetRideDepartureCarState'])){
                    $this->addSheetRideCarStates($this->request->data['SheetRideDepartureCarState'],$sheetRideId);
                }
                if(!empty($this->request->data['SheetRideArrivalCarState'])){
                    $this->addSheetRideCarStates($this->request->data['SheetRideArrivalCarState'],$sheetRideId);
                }
                if (isset($this->request->data['SheetRideDetailRides']) &&
                    !empty($this->request->data['SheetRideDetailRides'])) {
                    if (isset($this->request->data['SheetRide']['car_id'])) {
                        $carId = $this->request->data['SheetRide']['car_id'];
                        $carOffshore = $this->isCarOffshore($this->request->data['SheetRide']['car_id']);
                        $save = $this->add_Rides_sheetRide($this->request->data['SheetRideDetailRides'], $reference, $sheetRideId, $carId, $carOffshore,null,$transportBillDetailedRideId);
                          //  var_dump($save); die();
                        if ($save == false) {
                            $this->SheetRide->deleteAll(array('SheetRide.id' => $sheetRideId),
                                false);
                            $this->Flash->error(__('The sheet ride could not be saved. Please, try again.'));
                            $this->redirect(array('action' => 'index'));
                        }
                    } else {
                        if(isset($this->request->data['SheetRide']['supplier_id'])){
                            $subcontractorId = $this->request->data['SheetRide']['supplier_id'];
                            $save = $this->add_Rides_sheetRide($this->request->data['SheetRideDetailRides'],
                                $reference, $sheetRideId, null, null , $subcontractorId, $transportBillDetailedRideId );
                        }else {
                            $save = $this->add_Rides_sheetRide($this->request->data['SheetRideDetailRides'], $reference, $sheetRideId,
                                null, null, null, $transportBillDetailedRideId);
                        }
                         if ($save == false) {
                            $this->SheetRide->deleteAll(array('SheetRide.id' => $sheetRideId),
                                false);
                            $this->Flash->error(__('The sheet ride could not be saved. Please, try again.'));
                            $this->redirect($url);
                        }
                    }
                }
                $consumptions = $this->request->data['Consumption'];
                $this->saveConsumptions($consumptions, $sheetRideId);
                if (isset($this->request->data['SheetRide']['car_id'])) {
                    $this->updateCarReservoir($this->request->data['SheetRide']['car_id']);
                    $this->updateCarKm($this->request->data['SheetRide']['car_id']);
                    $this->updateCarMission($this->request->data['SheetRide']['car_id']);
                }
                if (isset($this->request->data['SheetRide']['customer_id'])) {
                    $this->updateCustomerMission($this->request->data['SheetRide']['customer_id']);
                    $this->Customer->setLastDateMission($this->request->data['SheetRide']['customer_id'],
                        $this->request->data['SheetRide']['end_date'],$this->request->data['SheetRide']['real_end_date'],
                        $this->request->data['SheetRide']['start_date'],$this->request->data['SheetRide']['real_start_date']
                        );
                }
                    $this->SheetRideManagement->updateStatusSheetRideByDefaultStatus($sheetRideId);
                if (!empty($this->request->data['SheetRideConveyor'])) {
                    $sheetRideConveyors = $this->request->data['SheetRideConveyor'];
                    $this->SheetRideConveyor->addSheetRideConveyors($sheetRideConveyors, $sheetRideId);
                }
                $this->saveUserAction(SectionsEnum::feuille_de_route,
                    $sheetRideId, $this->Session->read('Auth.User.id'), ActionsEnum::add);

                $this->Flash->success(__('The sheet ride has been saved.'));
            } else {
                $this->Flash->error(__('The sheet ride could not be saved. Please, try again.'));
            }
            $sheetRideWithMission = $this->Parameter->getCodesParameterVal('sheet_ride_with_mission');
            if(isset($this->request->data['SheetRideDetailRides'][1]['transport_bill_detail_ride'])
            && !empty($this->request->data['SheetRideDetailRides'][1]['transport_bill_detail_ride'])){
                $this->redirect(array('controller'=>'transportBills','action' => 'addFromCustomerOrderDetail'));
            }else{
                if($sheetRideWithMission==3){
                    $this->redirect(array('controller'=>'SheetRideDetailRides','action' => 'index'));
                }else {
                    $this->redirect($url);
                }
            }

        }


        $permissionAddCarState = $this->verifyUserPermission(SectionsEnum::etat_vehicule, $user_id, ActionsEnum::add,
            "CarStates", null, "CarState", null,1);
        $this->set('permissionAddCarState',$permissionAddCarState);
        $isAgent = $this->isAgent();
        if($permissionAddCarState || $isAgent){
            $this->loadModel('CarState');
            $carStates = $this->CarState->getCarStates('all');
            $this->set('carStates',$carStates);
        }
        $marchandises = array();
        $carTypes = $this->CarType->getCarTypes();
        $firstRide = null;

        if ($transportBillDetailRideId != null) {
            $transportBillDetailRide = $this->TransportBillDetailRides->find('first', array(
                'recursive' => -1,
                'conditions' => array(
                    'TransportBillDetailRides.id' => $transportBillDetailRideId,
                ),
                'fields' => array(
                    'TransportBill.date',
                    'TransportBill.order_type',
                    'CarType.name',
                    'CarType.id',
                    'TransportBillDetailRides.car_id',
                    'RideCategory.name',
                    'TransportBillDetailRides.type_ride',
                    'TransportBillDetailRides.unit_price',

                    'TransportBillDetailRides.type_pricing',
                    'TransportBillDetailRides.tonnage_id',
                    'TransportBillDetailRides.type_price',
                    'TransportBillDetailRides.reference',
                    'TransportBillDetailRides.is_open',
                    'TransportBillDetailRides.id',
                    'TransportBillDetailRides.detail_ride_id',
                    'TransportBillDetailRides.ride_category_id',
                    'TransportBillDetailRides.nb_trucks',
                    'TransportBillDetailRides.id',
                    'TransportBillDetailRides.status_id',
                    'TransportBillDetailRides.programming_date',
                    'TransportBillDetailRides.delivery_with_return',
                    'DepartureDestination.id',
                    'DepartureDestination.name',
                    'ArrivalDestination.name',
                    'Supplier.name',
                    'Supplier.id',
                    'Service.name',
                    'Service.id',
                    'SupplierFinal.name',
                    'SupplierFinal.id',
                    'DetailRide.real_duration_hour',
                    'DetailRide.real_duration_day',
                    'DetailRide.real_duration_minute',
                    'DetailRide.duration_hour',
                    'DetailRide.duration_day',
                    'DetailRide.duration_minute',
                    'DetailRides.real_duration_hour',
                    'DetailRides.real_duration_day',
                    'DetailRides.real_duration_minute',
                    'DetailRides.duration_hour',
                    'DetailRides.duration_day',
                    'DetailRides.duration_minute',
                    'DetailRides.id',
                    'Ride.distance',
                    'Rides.distance',
                    'Observation.id',
                    'Observation.customer_observation',
                    'Departure.id',
                    'Departure.name',
                    'Arrival.id',
                    'Arrival.name',
                    'Type.id',
                    'Type.name',
                    'Product.product_type_id',

                ),
                'joins' => array(

                    array(
                        'table' => 'transport_bills',
                        'type' => 'left',
                        'alias' => 'TransportBill',
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
                        'table' => 'ride_categories',
                        'type' => 'left',
                        'alias' => 'RideCategory',
                        'conditions' => array('TransportBillDetailRides.ride_category_id = RideCategory.id')
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
                        'table' => 'services',
                        'type' => 'left',
                        'alias' => 'Service',
                        'conditions' => array('TransportBill.service_id = Service.id')
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
                        'conditions' => array('TransportBillDetailRides.supplier_final_id = SupplierFinal.id')
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
                        'table' => 'tva',
                        'type' => 'left',
                        'alias' => 'Tva',
                        'conditions' => array('TransportBillDetailRides.tva_id = Tva.id')
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
                        'table' => 'rides',
                        'type' => 'left',
                        'alias' => 'Rides',
                        'conditions' => array('Departure.id = Rides.departure_destination_id', 'Arrival.id = Rides.arrival_destination_id')
                    ),
                    array(
                        'table' => 'detail_rides',
                        'type' => 'left',
                        'alias' => 'DetailRides',
                        'conditions' => array('Rides.id = DetailRides.ride_id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'Type',
                        'conditions' => array('TransportBillDetailRides.car_type_id = Type.id')
                    ),
                    array(
                        'table' => 'lots',
                        'type' => 'left',
                        'alias' => 'Lot',
                        'conditions' => array('TransportBillDetailRides.lot_id = Lot.id')
                    ),
                    array(
                        'table' => 'products',
                        'type' => 'left',
                        'alias' => 'Product',
                        'conditions' => array('Lot.product_id = Product.id')
                    ),

                )
            ));

            $carId = $transportBillDetailRide['TransportBillDetailRides']['car_id'];
            if(!empty($carId)){
            $conditions =array('Car.id'=>$carId);

            $param = $this->Parameter->getCodesParameterVal('name_car');
            $cars = $this->Car->getCarsByCondition($param,$conditions );
            $this->set('cars',$cars);
            }
            $detailRideId = $transportBillDetailRide['TransportBillDetailRides']['detail_ride_id'];
            $supplierId = $transportBillDetailRide['Supplier']['id'];
            $supplierFinalId = $transportBillDetailRide['SupplierFinal']['id'];
            $rideCategoryId = $transportBillDetailRide['TransportBillDetailRides']['ride_category_id'];
            $managementParameterMissionCost = $this->getManagementParameterMissionCost();
            $missionCost = $this->getMissionCost($detailRideId, 0, 0, $rideCategoryId);
            $this->SheetRideDetailRides->DetailRide->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(TransportBillDetailRides.reference,''),' - ', DepartureDestination.name, ' - ', ArrivalDestination.name, ' - ',CarType.name, ' - ', IFNULL(RideCategory.name,'') )"
            );
            $detailRides = $this->SheetRideDetailRides->DetailRide->find('list', array(
                'order' => 'DetailRide.wording ASC',
                'recursive' => -1,
                'fields' => 'cnames',
                'conditions' => array('DetailRide.id' => $detailRideId),
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
            $departures = $this->Destination->getDestinationsByConditions(array('Destination.id' => $transportBillDetailRide['Departure']['id']), 'list');
            $arrivals = $this->Destination->getDestinationsByConditions(array('Destination.id' => $transportBillDetailRide['Arrival']['id']), 'list');


            $suppliers = $this->Supplier->getSuppliersByParams(1, 1, null, array(2, 3), null, $supplierId);
            if(!empty($supplierId)){
                $finalSuppliers = $this->Supplier->getFinalSuppliersByInitialSupplier($supplierId, $supplierFinalId);
            }else {
                $finalSuppliers = array();
            }

            $this->set(compact('detailRides', 'suppliers', 'finalSuppliers', 'departures', 'arrivals'));
            $marchandises = $this->Marchandise->find('list',
                array(
                    'recursive' => -1,
                    'order' => 'name ASC',
                    'conditions' => array('Marchandise.supplier_id' => $transportBillDetailRide['Supplier']['id'])
                ));

            if ($transportBillDetailRide['TransportBillDetailRides']['type_ride'] == 2) {

                $firstRide = $this->getDetailRideCompanyToFirstRide($transportBillDetailRide['Departure']['id'],
                    $transportBillDetailRide['Departure']['name'], $transportBillDetailRide['Type']['id']);
            } else {
                $firstRide = $this->getDetailRideCompanyToFirstRide($transportBillDetailRide['DepartureDestination']['id'],
                    $transportBillDetailRide['DepartureDestination']['name'], $transportBillDetailRide['CarType']['id']);
            }
        }
        $paramConsumption = $this->consumptionManagement();
        $parameter = $this->Parameter->find('all', array(
            'recursive' => -1,
            'conditions' => array('code' => array(10, 23))
        ));

        $this->request->data['SheetRide']['coupon_price'] = $parameter[0]['Parameter']['val'];
        $this->request->data['SheetRide']['difference_allowed'] = $parameter[1]['Parameter']['val'];
        // Get method of selecting coupons
        $selectingCouponsMethod = $this->Parameter->getCodesParameterVal('select_coupon');
        // Get car's tank state on new mission's start
        $departureTankStateMethod = $this->Parameter->getCodesParameterVal('departure_tank_state');
        $arrivalTankStateMethod = $this->Parameter->getCodesParameterVal('arrival_tank_state');
        // Take into account tank state when estimate sheet ride's consumption
        $wilaya = $this->getWilayaCompany();
        $displayMissionCost = $this->isDisplayMissionCost();
        $useRideCategory = $this->useRideCategory();
        $timeParameters = $this->getTimeParametersToCalculateArrivalDate();
        $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
        $calculByMaps = $this->Parameter->getCodesParameterVal('calcul_by_maps');
        $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
        $addCarSubcontracting = $this->Parameter->getCodesParameterVal('car_subcontracting');
        $fieldMarchandiseRequired = $this->Parameter->getCodesParameterVal('marchandise_required');
        $negativeAccount = $this->Parameter->getCodesParameterVal('negative_account');
        $services = $this->Service->getServices('list');
        $isDestinationRequired = $this->isDestinationRequired();
        $sheetRideWithMission = $this->Parameter->getCodesParameterVal('sheet_ride_with_mission');
        $defaultConsumptionMethod = $this->Parameter->getCodesParameterVal('default_consumption_method');
        $subcontractorCostPercentage = $this->Parameter->getCodesParameterVal('subcontractor_cost_percentage');
        if($sheetRideWithMission == 2){
            $travelReasons = $this->TravelReason->getTravelReasons('list');
            $this->set(compact('travelReasons'));
        }
        if (empty($carId)){
            $param = $this->Parameter->getCodesParameterVal('name_car');
            $conditions = array();
            $cars = $this->Car->getCarsByCondition($param,$conditions );
            $this->set('cars',$cars);
        }
        $this->set(compact('missionCost', 'managementParameterMissionCost',
            'displayMissionCost', 'wilaya', 'firstRide', 'marchandises', 'priority',
            'departureTankStateMethod', 'arrivalTankStateMethod','sheetRideWithMission',
            'tvas', 'carTypes', 'transportBillDetailRide', 'paramConsumption','defaultConsumptionMethod',
            'addCarSubcontracting', 'selectingCouponsMethod', 'useRideCategory',
            'timeParameters', 'paramPriceNight','services','isDestinationRequired','subcontractorCostPercentage',
            'calculByMaps', 'usePurchaseBill','fieldMarchandiseRequired','negativeAccount','transportBillDetailedRideId'));

    }


   public function addSheetWithoutMission(){

   }

    /** enregistrement de plusieurs consommations
     * @param null $consumptions
     * @param null $sheetRideId
     * @throws Exception
     */
    public function saveConsumptions($consumptions = null, $sheetRideId = null)
    {

        foreach ($consumptions as $consumption) {
            if (!empty($consumption['consumption_date']) && !empty($consumption['type_consumption_used'])) {
                $data = array();

                $this->request->data['Consumption']['consumption_date'] = $consumption['consumption_date'];
                if (Configure::read("cafyb") == '1') {
                    $this->request->data['Consumption']['consumption_date_cafyb'] = $this->request->data['Consumption']['consumption_date'];
                    $this->createDateFromDatetime('Consumption', 'consumption_date_cafyb');
                    $consumptionDate = $this->request->data['Consumption']['consumption_date_cafyb'];
                }

                $this->createDatetimeFromDatetime('Consumption', 'consumption_date');
                $data['Consumption']['consumption_date'] = $this->request->data['Consumption']['consumption_date'];

                $data['Consumption']['type_consumption_used'] = $consumption['type_consumption_used'];
                $data['Consumption']['cost'] = $consumption['cost'];
                $data['Consumption']['sheet_ride_id'] = $sheetRideId;
                switch ($consumption['type_consumption_used']) {
                    case ConsumptionTypesEnum::coupon:
                        $selectingCouponsMethod = $this->Parameter->getCodesParameterVal('select_coupon');
                        if($selectingCouponsMethod==1){
                            if ((!empty($consumption['nb_coupon']) && !empty($consumption['serial_numbers']))
                            ) {
                                $data['Consumption']['nb_coupon'] = $consumption['nb_coupon'];
                                $this->Consumption->create();
                                $this->Consumption->save($data);
                                $consumptionId = $this->Consumption->getLastInsertId();
                                if (!empty($consumption['serial_numbers'])) {
                                    $usedCouponsNumbers = $consumption['serial_numbers'];
                                } else {
                                    $usedCouponsNumbers = '';
                                }
                                if (!empty($usedCouponsNumbers)) {
                                    $this->Coupon->updateCouponsConsumption($usedCouponsNumbers, $consumptionId);
                                }
                            }
                        }else {
                            if (!empty($consumption['nb_coupon']) && !empty($consumption['first_number_coupon'])
                                && !empty($consumption['last_number_coupon']) && !empty($consumption['serial_numbers'])
                            ) {

                                $data['Consumption']['nb_coupon'] = $consumption['nb_coupon'];
                                $data['Consumption']['first_number_coupon'] = $consumption['first_number_coupon'];
                                $data['Consumption']['last_number_coupon'] = $consumption['last_number_coupon'];

                                $this->Consumption->create();
                                $this->Consumption->save($data);
                                $consumptionId = $this->Consumption->getLastInsertId();
                                if (!empty($consumption['serial_numbers'])) {
                                    $usedCouponsNumbers = $consumption['serial_numbers'];
                                } else {
                                    $usedCouponsNumbers = '';
                                }

                                if (!empty($usedCouponsNumbers)) {
                                    $this->Coupon->updateCouponsConsumption($usedCouponsNumbers, $consumptionId);
                                }

                            }
                        }

                        break;
                    case ConsumptionTypesEnum::species:
                        if (!empty($consumption['species'])) {
                            $data['Consumption']['species'] = $consumption['species'];
                            if (Configure::read("gestion_commercial") == '1'  &&
                                Configure::read("tresorerie") == '1') {
                                $data['Consumption']['compte_id'] = $consumption['compte_id'];
                            }

                            $this->Consumption->create();
                            $this->Consumption->save($data);
                            $consumptionId = $this->Consumption->getInsertID();
                            if (Configure::read("gestion_commercial") == '1'  &&
                                Configure::read("tresorerie") == '1') {
                                if (Configure::read("cafyb") == '1') {
                                    $this->addPaymentConsumptionSpecies($consumption['compte_id'],
                                        $consumption['species'], $consumptionId,
                                        $consumptionDate);
                                } else {
                                    $this->addPaymentConsumptionSpecies($consumption['compte_id'],
                                        $consumption['species'], $consumptionId,
                                        $this->request->data['Consumption']['consumption_date']);
                                }
                            }

                        }
                        break;
                    case ConsumptionTypesEnum::tank:
                        if (!empty($consumption['consumption_liter']) && !empty($consumption['tank_id'])) {
                            $data['Consumption']['consumption_liter'] = $consumption['consumption_liter'];
                            $data['Consumption']['tank_id'] = $consumption['tank_id'];
                            $this->Consumption->create();
                            $this->Consumption->save($data);
                            $this->Tank->decreaseLiterTank($consumption['tank_id'], $consumption['consumption_liter']);
                        }
                        break;
                    case ConsumptionTypesEnum::card:
                        $cardAmountVerification = $this->Parameter->getCodesParameterVal('card_amount_verification');
                        if($cardAmountVerification == 2){
                            if (!empty($consumption['species_card']) && !empty($consumption['fuel_card_id'])) {
                                $data['Consumption']['species_card'] = $consumption['species_card'];
                                $data['Consumption']['fuel_card_id'] = $consumption['fuel_card_id'];
                                $this->Consumption->create();
                                $this->Consumption->save($data);
                                $this->FuelCard->decreaseSpeciesCard($consumption['fuel_card_id'], $consumption['species_card']);
                            }
                        }else {
                            if (!empty($consumption['fuel_card_id'])) {
                                $data['Consumption']['species_card'] = $consumption['species_card'];
                                $data['Consumption']['fuel_card_id'] = $consumption['fuel_card_id'];
                                $this->Consumption->create();
                                $this->Consumption->save($data);
                                $this->FuelCard->decreaseSpeciesCard($consumption['fuel_card_id'], $consumption['species_card']);
                                }
                        }

                        break;
                }
            }
        }

    }

    /** ajouter une consommation
     * @param null $consumption
     * @param null $sheetRideId
     * @throws Exception
     */
    public function addConsumption($consumption = null, $sheetRideId = null)
    {
        if (!empty($consumption['consumption_date']) && !empty($consumption['type_consumption_used'])) {
            $data = array();
            $this->request->data['Consumption']['consumption_date'] = $consumption['consumption_date'];
            $consumptionDate = $this->request->data['Consumption']['consumption_date'];
            $this->createDatetimeFromDatetime('Consumption', 'consumption_date');
            $data['Consumption']['consumption_date'] = $this->request->data['Consumption']['consumption_date'];
            $data['Consumption']['type_consumption_used'] = $consumption['type_consumption_used'];
            $data['Consumption']['cost'] = $consumption['cost'];
            $data['Consumption']['sheet_ride_id'] = $sheetRideId;
            switch ($consumption['type_consumption_used']) {
                case ConsumptionTypesEnum::coupon:
                    $selectingCouponsMethod = $this->Parameter->getCodesParameterVal('select_coupon');
                    if($selectingCouponsMethod==1){
                        if ((!empty($consumption['nb_coupon']) && !empty($consumption['serial_numbers']))
                        ) {
                            $data['Consumption']['nb_coupon'] = $consumption['nb_coupon'];
                            $this->Consumption->create();
                            $this->Consumption->save($data);
                            $consumptionId = $this->Consumption->getLastInsertId();
                            if (!empty($consumption['serial_numbers'])) {
                                $usedCouponsNumbers = $consumption['serial_numbers'];
                            } else {
                                $usedCouponsNumbers = '';
                            }
                            if (!empty($usedCouponsNumbers)) {
                                $this->Coupon->updateCouponsConsumption($usedCouponsNumbers, $consumptionId);
                            }
                        }
                    }else {
                        if ((!empty($consumption['nb_coupon']) && !empty($consumption['first_number_coupon'])
                            && !empty($consumption['last_number_coupon']) && !empty($consumption['serial_numbers']))
                        ) {
                            $data['Consumption']['nb_coupon'] = $consumption['nb_coupon'];
                            $data['Consumption']['first_number_coupon'] = $consumption['first_number_coupon'];
                            $data['Consumption']['last_number_coupon'] = $consumption['last_number_coupon'];
                            $this->Consumption->create();
                            $this->Consumption->save($data);
                            $consumptionId = $this->Consumption->getLastInsertId();
                            if (!empty($consumption['serial_numbers'])) {
                                $usedCouponsNumbers = $consumption['serial_numbers'];
                            } else {
                                $usedCouponsNumbers = '';
                            }
                            if (!empty($usedCouponsNumbers)) {
                                $this->Coupon->updateCouponsConsumption($usedCouponsNumbers, $consumptionId);
                            }
                        }
                    }
                    break;
                case ConsumptionTypesEnum::species:
                    if (!empty($consumption['species'])) {
                        $data['Consumption']['species'] = $consumption['species'];
                        if (Configure::read("gestion_commercial") == '1'  &&
                            Configure::read("tresorerie") == '1') {
                            $data['Consumption']['compte_id'] = $consumption['compte_id'];
                        }
                        $this->Consumption->create();
                        $this->Consumption->save($data);
                        $consumptionId = $this->Consumption->getInsertID();
                        if (Configure::read("gestion_commercial") == '1'  &&
                            Configure::read("tresorerie") == '1') {
                            if (Configure::read("cafyb") == '1') {
                                $this->addPaymentConsumptionSpecies($consumption['compte_id'],
                                    $consumption['species'], $consumptionId,
                                    $consumptionDate);
                            } else {
                                $this->addPaymentConsumptionSpecies($consumption['compte_id'],
                                    $consumption['species'], $consumptionId,
                                    $this->request->data['Consumption']['consumption_date']);
                            }
                        }
                    }
                    break;
                case ConsumptionTypesEnum::tank:
                    if (!empty($consumption['consumption_liter']) && !empty($consumption['tank_id'])) {
                        $data['Consumption']['consumption_liter'] = $consumption['consumption_liter'];
                        $data['Consumption']['tank_id'] = $consumption['tank_id'];
                        $this->Consumption->create();
                        $this->Consumption->save($data);
                        $this->Tank->decreaseLiterTank($consumption['tank_id'],
                            $consumption['consumption_liter']);
                    }
                    break;
                case ConsumptionTypesEnum::card:
                    $cardAmountVerification = $this->Parameter->getCodesParameterVal('card_amount_verification');
                    if($cardAmountVerification == 2) {
                        if (!empty($consumption['species_card']) && !empty($consumption['fuel_card_id'])) {
                            $data['Consumption']['species_card'] = $consumption['species_card'];
                            $data['Consumption']['fuel_card_id'] = $consumption['fuel_card_id'];
                            $this->Consumption->create();
                            $this->Consumption->save($data);
                            $this->FuelCard->decreaseSpeciesCard($consumption['fuel_card_id'], $consumption['species_card']);
                        }
                    }else {
                        if (!empty($consumption['fuel_card_id'])) {
                            $data['Consumption']['species_card'] = $consumption['species_card'];
                            $data['Consumption']['fuel_card_id'] = $consumption['fuel_card_id'];
                            $this->Consumption->create();
                            $this->Consumption->save($data);
                        }
                    }
                    break;
            }
        }
    }

    /** edit consommation
     * @param null $consumption
     * @param null $sheetRideId
     * @throws Exception
     */
    public function updateConsumption($consumption = null, $sheetRideId = null)
    {
        if (!empty($consumption['consumption_date']) && !empty($consumption['type_consumption_used'])) {
            $data = array();
            $this->request->data['Consumption']['consumption_date'] = $consumption['consumption_date'];
            $consumptionDate = $this->request->data['Consumption']['consumption_date'];
            $this->createDatetimeFromDatetime('Consumption', 'consumption_date');
            $data['Consumption']['consumption_date'] = $this->request->data['Consumption']['consumption_date'];
            $data['Consumption']['type_consumption_used'] = $consumption['type_consumption_used'];
            $data['Consumption']['cost'] = $consumption['cost'];
            $data['Consumption']['sheet_ride_id'] = $sheetRideId;
            $data['Consumption']['id'] = $consumption['id'];

            switch ($consumption['type_consumption_used']) {
                case ConsumptionTypesEnum::coupon:

                    if (!empty($consumption['nb_coupon']) && !empty($consumption['first_number_coupon'])
                        && !empty($consumption['last_number_coupon']) && !empty($consumption['serial_numbers'])
                    ) {

                        $data['Consumption']['nb_coupon'] = $consumption['nb_coupon'];
                        $data['Consumption']['first_number_coupon'] = $consumption['first_number_coupon'];
                        $data['Consumption']['last_number_coupon'] = $consumption['last_number_coupon'];

                        $this->Consumption->save($data);
                        $consumptionId = $this->Consumption->getLastInsertId();
                        if (!empty($consumption['serial_numbers'])) {
                            $usedCouponsNumbers = $consumption['serial_numbers'];
                        } else {
                            $usedCouponsNumbers = '';
                        }
                        if (!empty($usedCouponsNumbers)) {
                            $this->Coupon->updateCouponsConsumption($usedCouponsNumbers, $consumptionId);
                        }

                    }
                    break;
                case ConsumptionTypesEnum::species:
                    if (!empty($consumption['species'])) {
                        $data['Consumption']['species'] = $consumption['species'];
                        if (Configure::read("gestion_commercial") == '1'  &&
                            Configure::read("tresorerie") == '1') {
                            $data['Consumption']['compte_id'] = $consumption['compte_id'];
                        }

                        $this->Consumption->save($data);
                        if (Configure::read("gestion_commercial") == '1'  &&
                            Configure::read("tresorerie") == '1') {
                            if (Configure::read("cafyb") == '1') {
                                $this->addPaymentConsumptionSpecies($consumption['compte_id'],
                                    $consumption['species'], $consumption['id'],
                                    $consumptionDate);
                            } else {
                                $this->addPaymentConsumptionSpecies($consumption['compte_id'],
                                    $consumption['species'], $consumption['id'],
                                    $this->request->data['Consumption']['consumption_date']);
                            }
                        }

                    }
                    break;
                case ConsumptionTypesEnum::tank:
                    if (!empty($consumption['consumption_liter']) && !empty($consumption['tank_id'])) {
                        $data['Consumption']['consumption_liter'] = $consumption['consumption_liter'];
                        $data['Consumption']['tank_id'] = $consumption['tank_id'];

                        $this->Consumption->save($data);
                        $this->Tank->decreaseLiterTank($consumption['tank_id'], $consumption['consumption_liter']);
                    }
                    break;
                case ConsumptionTypesEnum::card:
                    $cardAmountVerification = $this->Parameter->getCodesParameterVal('card_amount_verification');
                    if($cardAmountVerification ==2){
                        if (!empty($consumption['species_card']) && !empty($consumption['fuel_card_id'])) {
                            $data['Consumption']['species_card'] = $consumption['species_card'];
                            $data['Consumption']['fuel_card_id'] = $consumption['fuel_card_id'];
                            $this->Consumption->save($data);
                            $this->FuelCard->decreaseSpeciesCard($consumption['fuel_card_id'], $consumption['species_card']);
                        }
                    }else {
                        if ( !empty($consumption['fuel_card_id'])) {
                            $data['Consumption']['species_card'] = $consumption['species_card'];
                            $data['Consumption']['fuel_card_id'] = $consumption['fuel_card_id'];
                            $this->Consumption->save($data);
                             }
                    }

                    break;
            }
        }


    }

    /** reinitialiser les differentes valeur de la consommation par rapport au type de consommation utilisé
     * @param null $consumptionId
     * @param null $typeConsumptionUsed
     * @throws Exception
     */
    public function resetConsumption($consumptionId = null, $typeConsumptionUsed = null)
    {
        switch ($typeConsumptionUsed) {
            case 1:
                $data['Consumption']['id'] = $consumptionId;
                $data['Consumption']['nb_coupon'] = 0;
                $data['Consumption']['first_number_coupon'] = null;
                $data['Consumption']['last_number_coupon'] = null;
                $this->Consumption->save($data);
                $this->initializeCouponsConsumption($consumptionId);
                break;
            case 2:
                $data['Consumption']['id'] = $consumptionId;
                $data['Consumption']['species'] = 0;
                $this->deletePaymentConsumptionSpecies($consumptionId);
                $this->Consumption->save($data);

                break;
            case 3:
                $fields = array('consumption_liter', 'tank_id');
                $consumption = $this->Consumption->getConsumptionById($consumptionId, $fields);
                $data['Consumption']['id'] = $consumptionId;
                $data['Consumption']['consumption_liter'] = 0;
                $data['Consumption']['tank_id'] = null;

                $this->Consumption->save($data);
                $this->Tank->increaseLiterTank($consumption['Consumption']['tank_id'], $consumption['Consumption']['consumption_liter']);

                break;
            case 4:
                $fields = array('species_card', 'fuel_card_id');
                $consumption = $this->Consumption->getConsumptionById($consumptionId, $fields);
                $data['Consumption']['id'] = $consumptionId;
                $data['Consumption']['species_card'] = 0;
                $data['Consumption']['fuel_card_id'] = null;

                $this->Consumption->save($data);
                $this->FuelCard->increaseSpeciesCard($consumption['Consumption']['fuel_card_id'], $consumption['Consumption']['species_card']);


                break;
        }
    }

    public function deleteConsumption($consumptionId = null)
    {

        $fields = array('type_consumption_used', 'tank_id', 'consumption_liter', 'fuel_card_id', 'species_card');
        $consumption = $this->Consumption->getConsumptionById($consumptionId, $fields);
        $typeConsumptionUsed = $consumption['Consumption']['type_consumption_used'];
        switch ($typeConsumptionUsed) {
            case 1:
                $this->initializeCouponsConsumption($consumptionId);
                break;
            case 2:
                $this->deletePaymentConsumptionSpecies($consumptionId);
                break;
            case 3:
                $this->Tank->increaseLiterTank($consumption['Consumption']['tank_id'], $consumption['Consumption']['consumption_liter']);

                break;
            case 4:
                $this->FuelCard->increaseSpeciesCard($consumption['Consumption']['fuel_card_id'], $consumption['Consumption']['species_card']);
                break;
        }
        $this->Consumption->id = $consumptionId;
        $this->Consumption->delete();

    }

    /*
 *  get distance and duration between company and first departure destination
 */

    public function isCarOffshore($carId = null)
    {
        $car = $this->Car->find('first', array(
            'conditions' => array('Car.id' => $carId),
            'recursive' => -1,
            'fields' => array('Car.id', 'Car.car_parc')
        ));
        $carOffshore = $car['Car']['car_parc'];
        return $carOffshore;

    }

    /*
     * return wilaya of company
     */

    function add_Rides_sheetRide(
        $sheetRideDetailRides = null,
        $reference = null,
        $sheetRideId = null,
        $carId = null,
        $carOffshore = null,
        $subcontractorId = null,
        $transportBillDetailedRideId = null
    )
    {
        // Get reference mission automatic parameter reference_mi_auto
        $referenceMission = $this->Parameter->getCodesParameterVal('reference_mi_auto');
        $j = 1;
        $i = 1;
        $save = false;
        $nbMissions = count($sheetRideDetailRides);
        //var_dump($sheetRideDetailRides); die();
        foreach ($sheetRideDetailRides as $sheetRideDetailRide) {

            if (isset($sheetRideDetailRide['Attachment'])) {
                $attachments = $sheetRideDetailRide['Attachment'];
            } else {
                $attachments = array();
            }

            if (isset($sheetRideDetailRide['lots'])) {
                $lots = $sheetRideDetailRide['lots'];
            } else {
                $lots = array();
            }
            if (isset($sheetRideDetailRide['SheetRideDetailRideMarchandise'])) {
                $sheetRideDetailRideMarchandises = $sheetRideDetailRide['SheetRideDetailRideMarchandise'];
            } else {
                $sheetRideDetailRideMarchandises = array();
            }
            if ($referenceMission == '1') {
                $data['SheetRideDetailRides']['reference'] = isset($sheetRideDetailRide['reference']) ? $sheetRideDetailRide['reference'] : '';
            } else {
                if ($reference != null) {
                    $orderMission = isset($sheetRideDetailRide['order_mission']) ? $sheetRideDetailRide['order_mission'] : '';
                    $data['SheetRideDetailRides']['reference'] = $reference . '/' . $orderMission;
                }
            }
            $data['SheetRideDetailRides']['order_mission'] = isset($sheetRideDetailRide['order_mission']) ? $sheetRideDetailRide['order_mission'] : '';
            $this->request->data['SheetRideDetailRides']['planned_start_date'] = isset($sheetRideDetailRide['planned_start_date']) ? $sheetRideDetailRide['planned_start_date'] : '';
            $this->createDatetimeFromDatetime('SheetRideDetailRides', 'planned_start_date');
            $sheetRideDetailRide['planned_start_date'] = isset($this->request->data['SheetRideDetailRides']['planned_start_date']) ? $this->request->data['SheetRideDetailRides']['planned_start_date'] : '';
            $this->request->data['SheetRideDetailRides']['real_start_date'] = isset($sheetRideDetailRide['real_start_date']) ? $sheetRideDetailRide['real_start_date'] : '';
            $this->createDatetimeFromDatetime('SheetRideDetailRides', 'real_start_date');
            $sheetRideDetailRide['real_start_date'] = $this->request->data['SheetRideDetailRides']['real_start_date'];
            $this->request->data['SheetRideDetailRides']['planned_end_date'] = isset($sheetRideDetailRide['planned_end_date']) ? $sheetRideDetailRide['planned_end_date'] : '';
            $this->createDatetimeFromDatetime('SheetRideDetailRides', 'planned_end_date');
            $sheetRideDetailRide['planned_end_date'] = $this->request->data['SheetRideDetailRides']['planned_end_date'];
            $this->request->data['SheetRideDetailRides']['real_end_date'] = isset($sheetRideDetailRide['real_end_date']) ? $sheetRideDetailRide['real_end_date'] : '';
            $this->createDatetimeFromDatetime('SheetRideDetailRides', 'real_end_date');
            $sheetRideDetailRide['real_end_date'] = $this->request->data['SheetRideDetailRides']['real_end_date'];
            if (isset($sheetRideDetailRide['observation_id'])) {
                $data['SheetRideDetailRides']['observation_id'] = $sheetRideDetailRide['observation_id'];
            } else {
                $data['SheetRideDetailRides']['observation_id'] = null;
            }
            if (isset($sheetRideDetailRide['transport_bill_detail_ride'])) {
                $data['SheetRideDetailRides']['transport_bill_detail_ride_id'] =
                    $sheetRideDetailRide['transport_bill_detail_ride'];
            } else {
                if (isset($sheetRideDetailRide['from_customer_order'])
                    && $sheetRideDetailRide['from_customer_order'] == '1') {
                    $data['SheetRideDetailRides']['transport_bill_detail_ride_id'] = $sheetRideDetailRide['detail_ride_id'];
                }
            }
            if (isset($sheetRideDetailRide['from_customer_order'])
                && $sheetRideDetailRide['from_customer_order'] == '1') {
                if (isset($sheetRideDetailRide['type_ride'])) {
                    if ($sheetRideDetailRide['type_ride'] == '1') {
                        $detail_ride = $this->TransportBillDetailRides->find('first', array(
                            'conditions' => array('TransportBillDetailRides.id' => $sheetRideDetailRide['detail_ride_id']),
                            'fields' => array('TransportBillDetailRides.detail_ride_id')
                        ));
                        $sheetRideDetailRide['detail_ride_id'] = $detail_ride['TransportBillDetailRides']['detail_ride_id'];
                        $sheetRideDetailRide['departure_destination_id'] = NULL;
                        $sheetRideDetailRide['arrival_destination_id'] = NULL;
                    } elseif ($sheetRideDetailRide['type_ride'] == '2') {
                        $detail_ride = $this->TransportBillDetailRides->find('first', array(
                            'conditions' => array('TransportBillDetailRides.id' => $sheetRideDetailRide['detail_ride_id']),
                            'fields' => array('TransportBillDetailRides.departure_destination_id',
                                'TransportBillDetailRides.arrival_destination_id',
                                'TransportBillDetailRides.lot_id'
                            )
                        ));
                        if($detail_ride['TransportBillDetailRides']['lot_id']==1){
                            $sheetRideDetailRide['departure_destination_id'] = $detail_ride['TransportBillDetailRides']['departure_destination_id'];
                            if(empty($sheetRideDetailRide['arrival_destination_id'])) {
                                $sheetRideDetailRide['arrival_destination_id'] = $detail_ride['TransportBillDetailRides']['arrival_destination_id'];
                            }
                            $sheetRideDetailRide['detail_ride_id'] = Null;
                        }
                    }
                }
            }
            if (isset($sheetRideDetailRide['from_customer_order'])) {
                $data['SheetRideDetailRides']['from_customer_order'] = $sheetRideDetailRide['from_customer_order'];
            }else {
                $data['SheetRideDetailRides']['from_customer_order']  =2;
            }

            if (isset($sheetRideDetailRide['type_ride'])) {
                $data['SheetRideDetailRides']['type_ride'] = $sheetRideDetailRide['type_ride'];
            }else {
                $data['SheetRideDetailRides']['type_ride'] =  2;
            }

            if (isset($sheetRideDetailRide['type_pricing'])) {
                $data['SheetRideDetailRides']['type_pricing'] = $sheetRideDetailRide['type_pricing'];
            } else {
                $data['SheetRideDetailRides']['type_pricing'] = 1;
            }
            if (isset($sheetRideDetailRide['price_recovered'])) {
                $data['SheetRideDetailRides']['price_recovered'] = $sheetRideDetailRide['price_recovered'];
            } else {
                $data['SheetRideDetailRides']['price_recovered'] = 2;
            }

            if (isset($sheetRideDetailRide['tonnage_id'])) {
                $data['SheetRideDetailRides']['tonnage_id'] = $sheetRideDetailRide['tonnage_id'];
            } else {
                $data['SheetRideDetailRides']['tonnage_id'] = NULL;
            }

            if (isset($sheetRideDetailRide['source'])) {
                $data['SheetRideDetailRides']['source'] = $sheetRideDetailRide['source'];
            }
            if (isset($sheetRideDetailRide['invoiced_ride'])) {
                $data['SheetRideDetailRides']['invoiced_ride'] = $sheetRideDetailRide['invoiced_ride'];
            }else {
                $data['SheetRideDetailRides']['invoiced_ride'] = 2 ;
            }
            if (isset($sheetRideDetailRide['invoiced_ride'])) {
                $data['SheetRideDetailRides']['truck_full'] = $sheetRideDetailRide['truck_full'];
            }else {
                $data['SheetRideDetailRides']['truck_full'] = 2;
            }

            if (isset($sheetRideDetailRide['return_mission'])) {
                $data['SheetRideDetailRides']['return_mission'] = $sheetRideDetailRide['return_mission'];
            } else {
                $data['SheetRideDetailRides']['return_mission'] = 2;
            }
            if (isset($sheetRideDetailRide['type_price'])) {
                $data['SheetRideDetailRides']['type_price'] = $sheetRideDetailRide['type_price'];
            } else {
                $data['SheetRideDetailRides']['type_price'] = 1;
            }
            if (isset($sheetRideDetailRide['remaining_time'])) {
                $data['SheetRideDetailRides']['remaining_time'] = $sheetRideDetailRide['remaining_time'];
            } else {
                $data['SheetRideDetailRides']['remaining_time'] = 0;
            }

            if (isset($sheetRideDetailRide['note'])) {
                $data['SheetRideDetailRides']['note'] = $sheetRideDetailRide['note'];
            }
            $data['SheetRideDetailRides']['sheet_ride_id'] = $sheetRideId;
            if (isset($sheetRideDetailRide['ride_category_id'])) {
                $data['SheetRideDetailRides']['ride_category_id'] = $sheetRideDetailRide['ride_category_id'];
            }
            if (isset($sheetRideDetailRide['detail_ride_id'])) {
                $data['SheetRideDetailRides']['detail_ride_id'] = $sheetRideDetailRide['detail_ride_id'];
            }
            if (isset($sheetRideDetailRide['departure_destination_id'])) {
                $data['SheetRideDetailRides']['departure_destination_id'] = $sheetRideDetailRide['departure_destination_id'];
            }

            if (isset($sheetRideDetailRide['arrival_destination_id'])) {

                $data['SheetRideDetailRides']['arrival_destination_id'] = $sheetRideDetailRide['arrival_destination_id'];
            }
            if (isset($sheetRideDetailRide['price'])) {
                $data['SheetRideDetailRides']['price'] = $sheetRideDetailRide['price'];
            }
            if (isset($sheetRideDetailRide['supplier_id'])) {
                $data['SheetRideDetailRides']['supplier_id'] = $sheetRideDetailRide['supplier_id'];
            }
            if (isset($sheetRideDetailRide['supplier_final_id'])) {
                $data['SheetRideDetailRides']['supplier_final_id'] = $sheetRideDetailRide['supplier_final_id'];
                $clientId = $sheetRideDetailRide['supplier_final_id'];
            } else {
                $clientId = NUll;
            }
            $data['SheetRideDetailRides']['planned_start_date'] = isset($sheetRideDetailRide['planned_start_date']) ? $sheetRideDetailRide['planned_start_date'] : '';
            $data['SheetRideDetailRides']['real_start_date'] = isset($sheetRideDetailRide['real_start_date']) ? $sheetRideDetailRide['real_start_date'] : '';
            $data['SheetRideDetailRides']['planned_end_date'] = isset($sheetRideDetailRide['planned_end_date']) ? $sheetRideDetailRide['planned_end_date'] : '';
            $data['SheetRideDetailRides']['real_end_date'] = isset($sheetRideDetailRide['real_end_date']) ? $sheetRideDetailRide['real_end_date'] : '';
            $data['SheetRideDetailRides']['km_departure'] = isset($sheetRideDetailRide['km_departure']) ? $sheetRideDetailRide['km_departure'] : '';
            $data['SheetRideDetailRides']['km_arrival_estimated'] = isset($sheetRideDetailRide['km_arrival_estimated']) ? $sheetRideDetailRide['km_arrival_estimated'] : '';
            $data['SheetRideDetailRides']['km_arrival'] = isset($sheetRideDetailRide['km_arrival']) ? $sheetRideDetailRide['km_arrival'] : '';
            $start_date = isset($data['SheetRideDetailRides']['real_start_date']) ? $data['SheetRideDetailRides']['real_start_date'] : '';
            $end_date = isset($data['SheetRideDetailRides']['real_end_date']) ? $data['SheetRideDetailRides']['real_end_date'] : '';
            if (isset($sheetRideDetailRide['mission_cost'])) {
                $data['SheetRideDetailRides']['mission_cost'] = isset($sheetRideDetailRide['mission_cost']) ? $sheetRideDetailRide['mission_cost'] : '';
                $data['SheetRideDetailRides']['amount_remaining'] = isset($sheetRideDetailRide['mission_cost']) ? $sheetRideDetailRide['mission_cost'] : '';
            }else {
                $data['SheetRideDetailRides']['mission_cost'] = 0;
                $data['SheetRideDetailRides']['amount_remaining'] = 0;
            }
            if (isset($sheetRideDetailRide['mission_cost'])) {
                $data['SheetRideDetailRides']['toll'] = $sheetRideDetailRide['toll'];
            }else {
                $data['SheetRideDetailRides']['toll'] = '';
            }
            $data['SheetRideDetailRides']['status_id'] = $this->updateStatusSheet($start_date, $end_date, 0);
            if (!isset($data['SheetRideDetailRides']['detail_ride_id'])) {


                if(Configure::read("transport_personnel") == '1'){
                    $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validateWithoutCommercial;
                }else {
                    $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validatePersonalizedRide;
                }
            }
            $data['SheetRideDetailRides']['user_id'] = $this->Session->read('Auth.User.id');
           // var_dump($data); die();
            $this->SheetRideDetailRides->create();
            /*var_dump($this->SheetRideDetailRides->save($data));
            var_dump($this->SheetRideDetailRides->validationErrors);
            die();*/
            if ($this->SheetRideDetailRides->save($data)) {
                if ($save == false) {
                    $save = true;
                }
                $sheetRideDetailRideId = $this->SheetRideDetailRides->getInsertID();
                if (isset($sheetRideDetailRide['reservation_cost'])) {
                    $reservationCost = $sheetRideDetailRide['reservation_cost'];
                }else {
                    $reservationCost = 0 ;
                }
                if (isset($sheetRideDetailRide['price_recovered'])) {
                    $priceRecovered = $sheetRideDetailRide['price_recovered'];
                }else {
                    $priceRecovered = 2 ;
                }
                $userId = $this->Session->read('Auth.User.id');
                if ($carOffshore == 2 && $carId != NULL) {
                        $this->Reservation->addReservation($carId, $sheetRideDetailRideId, $reservationCost, null, $userId,$priceRecovered,
                            $transportBillDetailedRideId);
                }
                if($subcontractorId !=null){
                    $this->Reservation->addReservation(null, $sheetRideDetailRideId, $reservationCost, $subcontractorId, $userId,$priceRecovered,
                        $transportBillDetailedRideId);
                }
                if (!empty($attachments)) {
                    $supplierId = $sheetRideDetailRide['supplier_id'];
                    $this->saveAttachments($attachments, $sheetRideDetailRideId, $supplierId);
                }
                if (!empty($lots)) {
                    $typeBill = BillTypesEnum::exit_order;
                    $referenceBill = $this->Parameter->getNextBillReferenceSaved($typeBill);
                    $userId = $this->Session->read('Auth.User.id');
                    $this->Bill->addExitBill($lots, $sheetRideDetailRideId, $clientId,$referenceBill,$userId);
                }
                if (!empty($sheetRideDetailRideMarchandises)) {
                    $this->SheetRideDetailRideMarchandise->saveMarchandises($sheetRideDetailRideMarchandises, $sheetRideDetailRideId);
                }
                if (!empty($sheetRideDetailRide['transport_bill_detail_ride'])) {
                    $this->TransportBillDetailRides->updateStatusTransportBillDetailRide($sheetRideDetailRide['transport_bill_detail_ride']);
                }
                $j++;
                if (($i == $nbMissions) && (isset($sheetRideDetailRide['detail_ride_id']))) {
                    $this->saveLastArrivalDestination($sheetRideDetailRide['detail_ride_id'], $sheetRideId);
                }
                /*
                 * modified : 20/03/2019
                 * */

                $synchronizationFrBc = $this->Parameter->getCodesParameterVal('synchronization_fr_bc');

                if ($synchronizationFrBc == 1) {
                    $transportBillDetailRide = $this->TransportBillDetailRides->getTransportBillDetailRideBySheetRideDetailRideId($sheetRideDetailRideId);
                    if (!empty($transportBillDetailRide)) {
                        $sheetRideDetailRide = $this->SheetRideDetailRides->getSheetRideDetailRideById($sheetRideDetailRideId);
                        if ($transportBillDetailRide['TransportBillDetailRides']['nb_trucks'] == 1) {
                            $this->TransportBillDetailRides->updateTransportBillDetailRideInformations($sheetRideDetailRide, $transportBillDetailRide);
                        }

                    }
                }
            }

            $i++;
        }

        return $save;
    }

    public function getAttachmentsByClient($clientId = null, $i = null, $sheetRideDetailRideId = null)
    {

        $attachmentTypes = $this->AttachmentType->getAttachmentTypeByParameter($clientId);




        if ($sheetRideDetailRideId != null) {
            $attachments = $this->Attachment->getAttachmentsBySheetRideDetailRideId($sheetRideDetailRideId);
            $this->set(compact('attachments'));
        }

        $this->set(compact('attachmentTypes', 'i', 'sheetRideDetailRideId'));
        return $attachmentTypes;
    }














    public function getLots($i = null, $sheetRideDetailRideId = null)
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

            $this->set(compact('lots', 'i', 'lotIds', 'sheetRideDetailRideId'));
        }
    }



    public function saveLastArrivalDestination($detailRideId, $sheetRideId)
    {
        $detailRide = $this->SheetRideDetailRides->DetailRide->find('first', array(
            'recursive' => -1,
            'fields' => array('ArrivalDestination.id', 'ArrivalZone.id'),
            'conditions' => array('DetailRide.id' => $detailRideId),
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
                    'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'ArrivalDestination',
                    'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                ),
                array(
                    'table' => 'wilayas',
                    'type' => 'left',
                    'alias' => 'ArrivalWilaya',
                    'conditions' => array('ArrivalDestination.wilaya_id = ArrivalWilaya.id')
                ),
                array(
                    'table' => 'zones',
                    'type' => 'left',
                    'alias' => 'ArrivalZone',
                    'conditions' => array('ArrivalWilaya.zone_id = ArrivalZone.id')
                )
            )
        ));
        if (!empty($detailRide)) {
            $this->SheetRide->id = $sheetRideId;
            $this->SheetRide->saveField('last_arrival_destination_id', $detailRide['ArrivalDestination']['id']);
            $this->SheetRide->saveField('last_zone_id', $detailRide['ArrivalZone']['id']);
        }

    }

    private function updateCarReservoir($carId)
    {


        $this->setTimeActif();
        $car = $this->Car->find('first', array(
            'recursive' => -1,
            'conditions' => array('id' => $carId)
        ));
        if (!empty($car)) {


            $sheetRide = $this->SheetRide->find('first', array(
                'recursive' => -1,
                'conditions' => array('car_id' => $carId),
                'order' => array('real_end_date' => 'DESC')
            ));

            if (!empty($sheetRide)) {
                $reservoirValue = $sheetRide['SheetRide']['tank_arrival'];
                $this->Car->id = $carId;

                $this->Car->saveField('reservoir_state', $reservoirValue);
            }


        }
    }

    private function updateCarKm($car_id)
    {

        $this->setTimeActif();
        $car = $this->Car->find('all', array(
            'recursive' => -1,
            'conditions' => array('id' => $car_id),
            'fields' => array('Car.id', 'Car.km')
        ));
        if (!empty($car)) {


            $sheetRideDetailRides = $this->SheetRideDetailRides->find('first', array(
                'recursive' => -1,
                'conditions' => array('SheetRide.car_id' => $car_id),
                'joins' => array(
                    array(
                        'table' => 'sheet_rides',
                        'type' => 'left',
                        'alias' => 'SheetRide',
                        'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                    )
                ),
                'order' => array('km_arrival' => 'DESC')
            ));
            if (!empty($sheetRideDetailRides)) {
                $this->Car->id = $car_id;

                $this->Car->saveField('km', $sheetRideDetailRides['SheetRideDetailRides']['km_arrival']);

            }


        }
    }

    private function updateCarMission($carId)
    {

        $sheetRidesMission = $this->SheetRide->find('all',
            array('conditions' => array('SheetRide.car_id' => $carId, 'SheetRide.status_id ' => 2)));

        if (!empty($sheetRidesMission)) {
            $this->Car->id = $carId;
            $this->Car->saveField('in_mission', 1);

        } else {
            $sheetRidesRetourParc = $this->SheetRide->find('all',
                array('conditions' => array('SheetRide.car_id' => $carId, 'SheetRide.status_id ' => 3)));
            if(!empty($sheetRidesRetourParc)){
                $this->Car->id = $carId;
                $this->Car->saveField('in_mission', 2);
            }else {
                $this->Car->id = $carId;
                $this->Car->saveField('in_mission', 0);
            }
        }
    }

    private function updateCustomerMission($customerId)
    {
        $sheetRidesMission = $this->SheetRide->find('all',
            array('conditions' => array('SheetRide.customer_id' => $customerId, 'SheetRide.status_id ' => 2)));

        if (!empty($sheetRidesMission)) {
            $this->Customer->id = $customerId;
            $this->Customer->saveField('in_mission', 1);

        } else {
            $sheetRidesRetourParc = $this->SheetRide->find('all',
                array('conditions' => array('SheetRide.customer_id' => $customerId, 'SheetRide.status_id ' => 3)));
            if(!empty($sheetRidesRetourParc)){
                $this->Customer->id = $customerId;
                $this->Customer->saveField('in_mission', 2);
            }else {
                $this->Customer->id = $customerId;
                $this->Customer->saveField('in_mission', 0);
            }
        }


    }

    /**
     * @param null $detailRideId
     * @param null $i
     * @param null $fromCustomerOrder
     * @param null $rideCategoryId
     * @return array|null
     * definir les ordre de mission selon les parametres de gestion
     */
    public function getMissionCost($detailRideId = null, $i = null, $fromCustomerOrder = null, $rideCategoryId = null)
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
                    $missionCost = $this->getMissionCostByDay($detailRideId);
                    break;
                case '2':
                    $missionCost = $this->getMissionCostByDestination($detailRideId);
                    break;
                case '3':
                    $missionCost = $this->getMissionCostByDistance($detailRideId, $rideCategoryId);
                    break;
            }
            $displayMissionCost = $this->isDisplayMissionCost();
            $this->set(compact('missionCost', 'i', 'displayMissionCost', 'managementParameterMissionCost', 'detailRideId'));
            return $missionCost;
        }
        $this->set(compact('detailRideId', 'i'));

    }

    function getMissionCostByDay($detailRideId)
    {
        $missionCosts = $this->SheetRideDetailRides->DetailRide->MissionCost->find('first', array(
            'recursive' => -1,
            'fields' => array('cost_day'),
            'conditions' => array('detail_ride_id' => $detailRideId)
        ));
        if (!empty($missionCosts)) {
            return $missionCosts;
        } else {
            $missionCosts = array();
            return $missionCosts;
        }

    }

    function getMissionCostByDestination($detailRideId)
    {
        $missionCosts = $this->SheetRideDetailRides->DetailRide->MissionCost->find('first', array(
            'recursive' => -1,
            'fields' => array('cost_destination'),
            'conditions' => array('detail_ride_id' => $detailRideId)
        ));
        if (!empty($missionCosts)) {
            return $missionCosts;
        } else {
            $missionCosts = array();
            return $missionCosts;
        }

    }

    function getMissionCostByDistance($detailRideId = null, $rideCategoryId = null)
    {
        $missionCosts = $this->SheetRideDetailRides->DetailRide->MissionCost->find('first', array(
            'recursive' => -1,
            'fields' => array('cost_truck_full', 'cost_truck_empty'),
            'conditions' => array('detail_ride_id' => $detailRideId, 'ride_category_id' => $rideCategoryId)
        ));


        if (!empty($missionCosts)) {
            return $missionCosts;

        } else {
            $missionCosts = array();
            return $missionCosts;

        }
    }

    private function getDetailRideCompanyToFirstRide(
        $departureDestinationId = null,
        $departureDestinationName = null,
        $carTypeId = null
    )
    {
        $firstRide = array();
        $firstRide["departureDestinationName"] = $departureDestinationName;
        $company = $this->Company->find('first');
        $wilayaId = $company['Company']['wilaya'];
        $departureDestination = $this->Destination->find('first', array(
            'recursive' => -1,
            'fields' => array(
                'Destination.id',
                'Destination.name',
                'Destination.latlng',

            ),
            'conditions' => array('Destination.id' => $departureDestinationId),

        ));

        if (!empty($departureDestination)) {
            $departureDestinationLatlng = $departureDestination['Destination']['latlng'];
            $firstRide["departureDestinationLatlng"] = $departureDestinationLatlng;
        }
        if (!empty($wilayaId)) {
            $firstRide['detailRide'] = $this->SheetRideDetailRides->DetailRide->find('first', array(
                'conditions' => array(
                    'OR' => array(
                        array(
                            'Ride.departure_destination_id' => $departureDestinationId,
                            'Ride.arrival_destination_id' => $wilayaId,
                            'DetailRide.car_type_id' => $carTypeId
                        ),
                        array(
                            'Ride.arrival_destination_id' => $departureDestinationId,
                            'Ride.departure_destination_id' => $wilayaId,
                            'DetailRide.car_type_id' => $carTypeId
                        )
                    )
                ),
                'recursive' => -1,
                'fields' => array(
                    'Ride.distance',
                    'DetailRide.real_duration_hour',
                    'DetailRide.real_duration_day',
                    'DetailRide.real_duration_minute'
                ),
                'joins' => array(
                    array(
                        'table' => 'rides',
                        'type' => 'left',
                        'alias' => 'Ride',
                        'conditions' => array('DetailRide.ride_id = Ride.id')
                    )
                )
            ));

            $wilaya = $this->getWilayaCompany();
            $firstRide["wilayaName"] = $wilaya['wilayaName'];
            $firstRide["wilayaLatlng"] = $wilaya['wilayaLatlng'];

        }
        return $firstRide;


    }

    public function getWilayaCompany()
    {

        $wilaya = array();
        $company = $this->Company->find('first');
        if (isset($company['Company'])){
            $wilayaId = $company['Company']['wilaya'];
            $wilayaLatlng = $company['Company']['latlng'];
        }else{
            $wilayaId = null;
            $wilayaLatlng = null;
        }

        $wilaya["wilayaLatlng"] = $wilayaLatlng;
        if (!empty($wilayaId)) {
            $this->loadModel('Destination');
            $wilaya = $this->Destination->find('first', array(
                'conditions' => array('Destination.id' => $wilayaId),
                'recursive' => -1,
                'fields' => array('name')
            ));
            $wilayaName = $wilaya['Destination']['name'];
            $wilaya["wilayaName"] = $wilayaName;
            $wilaya["wilayaLatlng"] = $wilayaLatlng;
        }

        return $wilaya;

    }


    /*pour avoir la possibilité d'ajouter un trajet dans view add et edit*/

    /**
     * @param null $id
     * @param null $transportBillDetailRideId
     * @param null $observationId
     * @param null $url
     * @param null $page
     * @param null $controller
     * @throws Exception
     */
    public function edit($id = null, $transportBillDetailRideId = null, $observationId = null)
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

        if(isset($transportBillDetailRideId) && !empty($transportBillDetailRideId)){
            $this->isOpenedByOtherUser("TransportBillDetailRides", 'SheetRides', 'transport bill',
                $transportBillDetailRideId);
        }
        $isAgent = $this->isAgent();
        $this->set('isAgent', $isAgent);

        if (!$isAgent) {
            $this->verifyUserPermission(SectionsEnum::feuille_de_route, $user_id,
                ActionsEnum::edit, "SheetRides", $id, "SheetRide", null);
        }
        $reference = $this->getNextTransportReference(TransportBillTypesEnum::sheet_ride);
        $this->set('reference', $reference);
        // Get reference mission automatic parameter reference_mi_auto
        $isReferenceMissionAutomatic = $this->Parameter->getCodesParameterVal('reference_mi_auto');
        $this->set('referenceMission', $isReferenceMissionAutomatic);
        if (!$this->SheetRide->exists($id)) {
            throw new NotFoundException(__('Invalid sheet ride'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->closeItemOpened('SheetRide', $id);
                $this->Flash->error(__('Changes were not saved. Sheet ride cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            // calculate diff between date open and date submit if diff > 15 min redirect to index dont save modification
            $currentDateAdd = $this->request->data['SheetRide']['currentDateAdd'];
            $currentDateSubmit = date('Y-m-d H:i');
            $currentDateAdd = new DateTime ($currentDateAdd);
            $currentDateSubmit = new DateTime ($currentDateSubmit);
            $interval = date_diff($currentDateAdd, $currentDateSubmit);
            $total = $interval->y * 526600 + $interval->m * 43800 + $interval->d * 1440 + $interval->h * 60 + $interval->i;
            if ($total > 100) {
                $this->Flash->error(__('The sheet ride could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->createDatetimeFromDatetime('SheetRide', 'end_date');
            $this->createDatetimeFromDatetime('SheetRide', 'start_date');
            $this->createDatetimeFromDatetime('SheetRide', 'real_start_date');
            $this->createDatetimeFromDatetime('SheetRide', 'real_end_date');
            $this->request->data['SheetRide']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            $this->closeItemOpened('SheetRide', $id);
            if (isset($this->request->data['SheetRide']['car_subcontracting']) && ($this->request->data['SheetRide']['car_subcontracting'] == 1)) {
                $this->request->data['SheetRide']['car_id']=null;
                $this->request->data['SheetRide']['customer_id']=null;
                $this->request->data['SheetRide']['remorque_id']=null;
                if(Configure::read('car_required')=='1'){
                    $this->SheetRide->validate = $this->SheetRide->validateSubcontractingRequired;
                }else {
                    $this->SheetRide->validate = $this->SheetRide->validateSubcontracting;
                }
            }else {
                $this->request->data['SheetRide']['car_name']=null;
                $this->request->data['SheetRide']['customer_name']=null;
                $this->request->data['SheetRide']['remorque_name']=null;
                $this->request->data['SheetRide']['supplier_id']=null;
            }
            $sheetRide = $this->SheetRide->find('first',
                array('recursive' => -1, 'conditions' => array('SheetRide.id' => $id)));
            $previousCarId = $sheetRide['SheetRide']['car_id'];
            $previousSubcontractorId = $sheetRide['SheetRide']['supplier_id'];
            $this->request->data['SheetRide']['modified_id'] = $this->Session->read('Auth.User.id');
            if ($this->SheetRide->save($this->request->data)) {
                if (isset($this->request->data['SheetRide']['car_id'])) {
                    $carId = $this->request->data['SheetRide']['car_id'];
                    $balance = $this->request->data['SheetRide']['difference_real'];
                    if (!empty($balance)) {
                        $this->saveBalanceCar($carId, $balance);
                    }
                }
                if (isset($this->request->data['SheetRideDetailRides'])&&
                    !empty($this->request->data['SheetRideDetailRides'])) {
                    $i = 1;
                    $nbMissions = count($this->request->data['SheetRideDetailRides']);
                    foreach ($this->request->data['SheetRideDetailRides'] as $sheetRideDetailRides) {
                        if (!empty($sheetRideDetailRides['id'])) {
                            $sheet_ride_detail_ride = $sheetRideDetailRides['id'];
                            if ($previousCarId != NULL) {
                                $previousCarOffshore = $this->isCarOffshore($previousCarId);
                            } else {
                                $previousCarOffshore = null;
                            }
                            if (isset($this->request->data['SheetRide']['car_id'])) {
                                $carOffshore = $this->isCarOffshore($this->request->data['SheetRide']['car_id']);
                                $this->update_Ride_sheetRide($sheetRideDetailRides, $reference, $id, $sheet_ride_detail_ride,
                                    $previousCarOffshore, $carOffshore, $this->request->data['SheetRide']['car_id'],
                                    $previousSubcontractorId);
                            } else {
                                if(isset($this->request->data['SheetRide']['supplier_id'])){
                                    $subcontractorId = $this->request->data['SheetRide']['supplier_id'];
                                    $this->update_Ride_sheetRide($sheetRideDetailRides, $reference, $id,
                                        $sheet_ride_detail_ride, $previousCarOffshore,
                                        null, null, $previousSubcontractorId, $subcontractorId);
                                }else {
                                    $this->update_Ride_sheetRide($sheetRideDetailRides, $reference, $id,
                                        $sheet_ride_detail_ride, $previousCarOffshore,
                                        null, null, $previousSubcontractorId);
                                }
                            }
                        } else {
                            if (isset($this->request->data['SheetRide']['car_id'])) {
                                $carOffshore = $this->isCarOffshore($this->request->data['SheetRide']['car_id']);
                                $this->add_Ride_sheetRide($sheetRideDetailRides,
                                    $this->request->data['SheetRide']['reference'], $id, $carId, $carOffshore);
                            } else {
                                if(isset($this->request->data['SheetRide']['supplier_id'])){
                                    $subcontractorId = $this->request->data['SheetRide']['supplier_id'];
                                    $this->add_Ride_sheetRide($sheetRideDetailRides,
                                        $this->request->data['SheetRide']['reference'], $id,
                                        null, null, $subcontractorId);
                                }else {
                                    $this->add_Ride_sheetRide($sheetRideDetailRides,
                                        $this->request->data['SheetRide']['reference'], $id);
                                }
                            }
                        }
                        if (($i == $nbMissions) && (isset($this->request->data['SheetRideDetailRides'][$i]['detail_ride_id']))) {
                            $this->updateLastArrivalDestination($this->request->data['SheetRideDetailRides'][$i]['from_customer_order'],
                                $this->request->data['SheetRideDetailRides'][$i]['detail_ride_id'], $id);
                        }
                        $i++;
                    }
                    if (isset($this->request->data['Missions']['deleted_id']) && !empty($this->request->data['Missions']['deleted_id'])) {
                        $sheetRideDetailRidesDeletedId = $this->request->data['Missions']['deleted_id'];
                        $sheetRideDetailRideIds = explode(",", $sheetRideDetailRidesDeletedId);
                        foreach ($sheetRideDetailRideIds as $sheetRideDetailRideId) {
                            $this->deleteSheetRideDetailRide($sheetRideDetailRideId);
                        }
                    }
                }
                if (isset($this->request->data['Consumption']['deleted_id']) &&
                    !empty($this->request->data['Consumption']['deleted_id'])) {
                    $consumptionDeletedId = $this->request->data['Consumption']['deleted_id'];
                    $consumptionIds = explode(",", $consumptionDeletedId);
                    foreach ($consumptionIds as $consumptionId) {
                        $this->deleteConsumption($consumptionId);
                    }
                }
                if (isset($this->request->data['Consumption'])
                    && !empty($this->request->data['Consumption'])
                ) {
                    $consumptions = $this->request->data['Consumption'];
                    foreach ($consumptions as $consumption) {
                        if (!empty($consumption['id'])) {
                            $this->resetConsumption($consumption['id'],
                                $consumption['type_consumption_used']);
                            $this->updateConsumption($consumption, $id);
                        } else {
                            $this->addConsumption($consumption, $id);
                        }
                    }
                }
                if (!empty($this->request->data['SheetRideConveyor'])) {
                    $sheetRideConveyors = $this->request->data['SheetRideConveyor'];
                    foreach ($sheetRideConveyors as $sheetRideConveyor) {
                        if (!empty($sheetRideConveyor['id'])) {
                            $this->SheetRideConveyor->updateSheetRideConveyor($sheetRideConveyor, $id);
                        } else {
                            $this->SheetRideConveyor->addSheetRideConveyor($sheetRideConveyor, $id);
                        }
                    }
                }
                if (isset($this->request->data['SheetRideDepartureCarState'])) {
                    $sheetRideDepartureCarStates = $this->request->data['SheetRideDepartureCarState'];

                }else {
                    $sheetRideDepartureCarStates =null;
                }
                if (!empty($sheetRideDepartureCarStates)) {

                foreach ($sheetRideDepartureCarStates as $sheetRideDepartureCarState) {
                    if (isset($sheetRideDepartureCarState['id']) &&
                        !empty($sheetRideDepartureCarState['id'])) {
                        $this->updateSheetRideCarState($sheetRideDepartureCarState, $id);
                    } else {
                        $this->addSheetRideCarState($sheetRideDepartureCarState, $id);
                    }
                }
            }
               if(isset($this->request->data['SheetRideArrivalCarState'])){
                   $sheetRideArrivalCarStates = $this->request->data['SheetRideArrivalCarState'];
               } else {
                   $sheetRideArrivalCarStates = null;
               }
            if(!empty($sheetRideArrivalCarStates)){
                foreach ($sheetRideArrivalCarStates as $sheetRideArrivalCarState){
                    if(isset($sheetRideArrivalCarState['id'])&&
                        !empty($sheetRideArrivalCarState['id'])){
                        $this->updateSheetRideCarState($sheetRideArrivalCarState,$id);
                    }else {
                        $this->addSheetRideCarState($sheetRideArrivalCarState,$id);
                    }
                }
            }
                $this->SheetRideManagement->updateStatusSheetRideByDefaultStatus($id);

                if (isset($this->request->data['SheetRide']['car_id'])) {
                    $this->updateCarKm($this->request->data['SheetRide']['car_id']);
                    $this->updateCarMission($this->request->data['SheetRide']['car_id']);
                }
                if (isset($this->request->data['SheetRide']['customer_id'])) {
                    $this->updateCustomerMission($this->request->data['SheetRide']['customer_id']);
                    $this->Customer->setLastDateMission($this->request->data['SheetRide']['customer_id'],
                        $this->request->data['SheetRide']['end_date'],$this->request->data['SheetRide']['real_end_date'],
                        $this->request->data['SheetRide']['start_date'],$this->request->data['SheetRide']['real_start_date']
                    );
                }
                $this->saveUserAction(SectionsEnum::feuille_de_route,
                    $id, $this->Session->read('Auth.User.id'), ActionsEnum::edit);

                $this->Flash->success(__('The sheet ride has been saved.'));
            } else {
                $this->Flash->error(__('The sheet ride could not be saved. Please, try again.'));
            }
            $sheetRideWithMission = $this->Parameter->getCodesParameterVal('sheet_ride_with_mission');
            if($sheetRideWithMission==3){
                $this->redirect(array('controller'=>'SheetRideDetailRides','action' => 'index'));
            }else {
                $this->redirect($url);
            }
        } else {
            $this->isOpenedByOtherUser("SheetRide", 'SheetRides', 'sheet ride', $id);
            $options = array('conditions' => array('SheetRide.' . $this->SheetRide->primaryKey => $id));
            $this->request->data = $this->SheetRide->find('first', $options);
            $sheetRideWithMission = $this->Parameter->getCodesParameterVal('sheet_ride_with_mission');
            if($sheetRideWithMission == 2){
                $travelReasons = $this->TravelReason->getTravelReasons('list');
                $conditions = array('Destination.id'=>$this->request->data['SheetRide']['destination_id']);
                $destinations = $this->Destination->getDestinations('list',$conditions);
                $this->set(compact('travelReasons','destinations'));
                $this->set('nb_rides', 0);
                $wilaya['wilayaName'] ="";
                $this->set('wilaya', $wilaya);
            }else {
                $rides_sheet_rides = $this->SheetRideDetailRides->find('all', array(
                    'order' => array('SheetRideDetailRides.order_mission ASC, SheetRideDetailRides.id ASC'),
                    'group' => 'SheetRideDetailRides.id',
                    'recursive' => -1,
                    'fields' => array(
                        'SheetRideDetailRides.id',
                        'SheetRideDetailRides.order_mission',
                        'SheetRideDetailRides.detail_ride_id',
                        'SheetRideDetailRides.ride_category_id',
                        'SheetRideDetailRides.transport_bill_detail_ride_id',
                        'SheetRideDetailRides.observation_id',
                        'SheetRideDetailRides.invoiced_ride',
                        'SheetRideDetailRides.from_customer_order',
                        'SheetRideDetailRides.truck_full',
                        'SheetRideDetailRides.return_mission',
                        'SheetRideDetailRides.type_price',
                        'SheetRideDetailRides.planned_start_date',
                        'SheetRideDetailRides.real_start_date',
                        'SheetRideDetailRides.km_departure',
                        'SheetRideDetailRides.planned_end_date',
                        'SheetRideDetailRides.real_end_date',
                        'SheetRideDetailRides.km_arrival_estimated',
                        'SheetRideDetailRides.km_arrival',
                        'SheetRideDetailRides.supplier_id',
                        'SheetRideDetailRides.supplier_final_id',
                        'SheetRideDetailRides.mission_cost',
                        'SheetRideDetailRides.toll',
                        'SheetRideDetailRides.remaining_time',
                        'SheetRideDetailRides.departure_destination_id',
                        'SheetRideDetailRides.arrival_destination_id',
                        'SheetRideDetailRides.price',
                        'SheetRideDetailRides.status_id',
                        'SheetRideDetailRides.type_ride',
                        'SheetRideDetailRides.source',
                        'Supplier.id',
                        'SupplierFinal.id',
                        'SheetRideDetailRides.attachment1',
                        'SheetRideDetailRides.attachment2',
                        'SheetRideDetailRides.attachment3',
                        'SheetRideDetailRides.attachment4',
                        'SheetRideDetailRides.attachment5',
                        'SheetRideDetailRides.note',
                        'DetailRide.real_duration_hour',
                        'DetailRide.real_duration_day',
                        'DetailRide.real_duration_minute',
                        'DetailRide.id',
                        'Ride.distance',
                        'DetailRides.real_duration_hour',
                        'DetailRides.real_duration_day',
                        'DetailRides.real_duration_minute',
                        'DetailRides.id',
                        'Rides.distance',
                        'DepartureDestination.id',
                        'DepartureDestination.name',
                        'ArrivalDestination.id',
                        'ArrivalDestination.name',
                        'Departure.id',
                        'Departure.name',
                        'Arrival.id',
                        'Arrival.name',
                        'CarType.id',
                        'RideCategory.id',
                        'RideCategory.name',
                    ),
                    'conditions' => array('SheetRideDetailRides.sheet_ride_id' => $id),
                    'joins' => array(
                        array(
                            'table' => 'detail_rides',
                            'type' => 'left',
                            'alias' => 'DetailRide',
                            'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
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
                            'table' => 'rides',
                            'type' => 'left',
                            'alias' => 'Rides',
                            'conditions' => array('Departure.id = Rides.departure_destination_id', 'Arrival.id = Rides.arrival_destination_id')
                        ),
                        array(
                            'table' => 'detail_rides',
                            'type' => 'left',
                            'alias' => 'DetailRides',
                            'conditions' => array('Rides.id = DetailRides.ride_id')
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
                            'conditions' => array('SheetRideDetailRides.ride_category_id = RideCategory.id')
                        ),
                    )
                ));

                $detailRideIds = array();
                $supplierIds = array();
                $finalSupplierIds = array();
                $destinationId = array();
                $sheetRideDetailRideIds = array();
                foreach ($rides_sheet_rides as $rides_sheet_ride) {
                    $detailRideIds[] = $rides_sheet_ride['DetailRide']['id'];
                    $supplierIds[] = $rides_sheet_ride['Supplier']['id'];
                    $finalSupplierIds[] = $rides_sheet_ride['SupplierFinal']['id'];
                    $destinationId[] = $rides_sheet_ride['SheetRideDetailRides']['departure_destination_id'];
                    $destinationId[] = $rides_sheet_ride['SheetRideDetailRides']['arrival_destination_id'];
                    $sheetRideDetailRideIds[] = $rides_sheet_ride['SheetRideDetailRides']['id'];
                }

                $this->SheetRideDetailRides->DetailRide->virtualFields = array(
                    'cnames' => "CONCAT(IFNULL(TransportBillDetailRides.reference,''),' - ', DepartureDestination.name, ' - ', ArrivalDestination.name, ' - ',CarType.name, ' - ', IFNULL(RideCategory.name,'') )"
                );
                $detailRides = $this->SheetRideDetailRides->DetailRide->find('list', array(
                    'order' => 'DetailRide.wording ASC',
                    'conditions' => array('DetailRide.id' => $detailRideIds),
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
                $suppliers = $this->Supplier->getSuppliersByParams(1, 1, null, array(2, 3), null, $supplierIds);
                $i = 0;
                $finalSuppliers = array();

                if(!empty($supplierIds)){

                    foreach ($supplierIds as $supplierId) {
                        if($supplierId!=NULL){
                            $finalSuppliers[] = $this->Supplier->getFinalSuppliersByInitialSupplier($supplierId, $finalSupplierIds[$i]);
                            $i++;
                        }
                    }
                }
                $conditions = array('Destination.id' => $destinationId);
                $destinations = $this->Destination->getDestinationsByConditions($conditions, 'list');

                $this->set(compact('detailRides', 'suppliers', 'finalSuppliers',
                    'destinations', 'conveyors', 'sheetRideConveyors'));
                $managementParameterMissionCost = $this->getManagementParameterMissionCost();
                switch ($managementParameterMissionCost) {
                    case '1':
                        $i = 1;
                        foreach ($rides_sheet_rides as $rides_sheet_ride) {
                            $detailRideId = $rides_sheet_ride['SheetRideDetailRides']['detail_ride_id'];
                            $cost = $this->getMissionCostByDay($detailRideId);
                            $missionCost[$i] = $cost;
                            $i++;
                        }
                        break;

                    case '2':
                        $i = 1;
                        foreach ($rides_sheet_rides as $rides_sheet_ride) {
                            $detailRideId = $rides_sheet_ride['SheetRideDetailRides']['detail_ride_id'];
                            $cost = $this->getMissionCostByDestination($detailRideId);
                            $missionCost[$i] = $cost;
                            $i++;
                        }
                        break;

                    case '3':
                        $missionCost = array();
                        $i = 1;
                        foreach ($rides_sheet_rides as $rides_sheet_ride) {
                            $detailRideId = $rides_sheet_ride['SheetRideDetailRides']['detail_ride_id'];
                            $rideCategoryId = $rides_sheet_ride['SheetRideDetailRides']['ride_category_id'];
                            $cost = $this->getMissionCostByDistance($detailRideId, $rideCategoryId);
                            $missionCost[$i] = $cost;
                            $i++;
                        }
                        break;
                }
                $this->set('missionCost', $missionCost);
                $this->set('rides_sheet_rides', $rides_sheet_rides);
                if ($rides_sheet_rides[0]['SheetRideDetailRides']['type_ride'] == 2) {
                    $firstRide = $this->getDetailRideCompanyToFirstRide($rides_sheet_rides[0]['Departure']['id'],
                        $rides_sheet_rides[0]['Departure']['name'], $this->request->data['SheetRide']['car_type_id']);
                } else {
                    $firstRide = $this->getDetailRideCompanyToFirstRide($rides_sheet_rides[0]['DepartureDestination']['id'],
                        $rides_sheet_rides[0]['DepartureDestination']['name'], $rides_sheet_rides[0]['CarType']['id']);
                }

                $nb_rides = $this->SheetRideDetailRides->find('count',
                    array('conditions' => array('SheetRideDetailRides.sheet_ride_id' => $id)));
                $this->set('nb_rides', $nb_rides);

                if ($rides_sheet_rides[$nb_rides-1]['SheetRideDetailRides']['type_ride'] == 2) {
                    $retourParc = $this->getDetailRideCompanyToFirstRide($rides_sheet_rides[$nb_rides-1]['Arrival']['id'],
                        $rides_sheet_rides[$nb_rides-1]['Arrival']['name'], $this->request->data['SheetRide']['car_type_id']);
                } else {
                    $retourParc = $this->getDetailRideCompanyToFirstRide($rides_sheet_rides[$nb_rides-1]['ArrivalDestination']['id'],
                        $rides_sheet_rides[$nb_rides-1]['ArrivalDestination']['name'], $rides_sheet_rides[$nb_rides-1]['CarType']['id']);
                }

                $this->set('retourParc',$retourParc);
            }

            if ($this->request->data['SheetRide']['car_subcontracting'] == 1) {
                if(Configure::read('car_required')=='1'){
                    $this->SheetRide->validate = $this->SheetRide->validateSubcontractingRequired;
                }else {
                    $this->SheetRide->validate = $this->SheetRide->validateSubcontracting;
                }
                $conditionsSubcontractor = array('Supplier.id' => $this->request->data['SheetRide']['supplier_id']);
                $subcontractor = $this->Supplier->getSuppliersByParams(0, 1, null, null, 'list', null, $conditionsSubcontractor);
                $this->set('subcontractor', $subcontractor);

            } else {
                $param = $this->Parameter->getCodesParameterVal('name_car');
                if ($param == 1) {
                    $this->SheetRide->Car->virtualFields = array(
                        'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name, ' - ', IFNULL(Customer.first_name,''), ' ', IFNULL(Customer.last_name,''))"
                    );
                } elseif ($param == 2) {
                    $this->SheetRide->Car->virtualFields = array(
                        'cnames' => "CONCAT(IFNULL(Car.immatr_def,Car.immatr_prov), ' - ', Carmodel.name, ' - ', IFNULL(Customer.first_name,''), ' ', IFNULL(Customer.last_name,''))"
                    );
                }
                $cars = $this->SheetRide->Car->find('list', array(
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
                    ),
                    'conditions' => array('Car.id' => $this->request->data['SheetRide']['car_id'])

                ));
                $remorques = $this->SheetRide->Car->find('list', array(
                    'fields' => 'cnames',
                    'recursive' => -1,
                    'order' => array('Car.code asc', 'Carmodel.name asc'),
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
                    ),
                    'conditions' => array('Car.id' => $this->request->data['SheetRide']['remorque_id']),
                ));
                $fields = "names";
                $conditionsCustomer = array('Customer.id' => $this->request->data['SheetRide']['customer_id']);
                $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditionsCustomer);

                $sheetRideConveyors = $this->SheetRideConveyor->getConveyorsBySheetRideId($id);
                $conveyorIds = array();
                foreach ($sheetRideConveyors as $sheetRideConveyor) {
                    $conveyorIds[] = $sheetRideConveyor['SheetRideConveyor']['conveyor_id'];
                }
                if (!empty($conveyorIds)) {
                    $conditionsConveyor = array('Customer.id' => $conveyorIds);
                    $conveyors = $this->Customer->getCustomersByFieldsAndConds($fields, $conditionsConveyor);
                    $this->set('conveyors',$conveyors);
                }
            }

            $permissionEditCarState = $this->verifyUserPermission(SectionsEnum::etat_vehicule, $user_id, ActionsEnum::edit,
                "CarStates", null, "CarState", null,1);
            $this->set('permissionEditCarState',$permissionEditCarState);
            if($permissionEditCarState || $isAgent){
                $this->loadModel('CarState');
                $sheetRideDepartureCarStates = $this->SheetRideCarState->getSheetRideCarStatesBySheetRideId($id,1);
                $sheetRideArrivalCarStates = $this->SheetRideCarState->getSheetRideCarStatesBySheetRideId($id,2);
                $departureCarStateId  = array();
                if(!empty($sheetRideDepartureCarStates)){
                foreach ($sheetRideDepartureCarStates as $sheetRideDepartureCarState){
                    $departureCarStateId[]=$sheetRideDepartureCarState['SheetRideCarState']['car_state_id'];
                }}

                if(!empty($departureCarStateId)){
                    $conditions = array("CarState.id NOT IN  ( '" . implode( "', '" , $departureCarStateId ) . "' )");
                    $departureCarStates = $this->CarState->getCarStatesByConditions('all',$conditions);
                }else {
                    $departureCarStates = $this->CarState->getCarStatesByConditions('all');
                }
                $arrivalCarStateId  = array();
                if(!empty($sheetRideArrivalCarStates)){
                foreach ($sheetRideArrivalCarStates as $sheetRideArrivalCarState){
                    $arrivalCarStateId[]=$sheetRideArrivalCarState['SheetRideCarState']['car_state_id'];
                }}
                if(!empty($arrivalCarStateId)){
                    $conditions = array("CarState.id NOT IN  ( '" . implode( "', '" , $arrivalCarStateId ) . "' )");
                    $arrivalCarStates = $this->CarState->getCarStatesByConditions('all',$conditions);
                }else {
                    $arrivalCarStates = $this->CarState->getCarStatesByConditions('all');
                }

                $this->set(compact('carStates','sheetRideDepartureCarStates',
                    'sheetRideArrivalCarStates','departureCarStates','arrivalCarStates'));
            }


            if ($transportBillDetailRideId != null) {

                $this->isOpenedByOtherUser("TransportBillDetailRides", 'SheetRides', 'transport bill',
                    $transportBillDetailRideId);
                $transportBillDetailRide = $this->TransportBillDetailRides->find('first', array(
                    'recursive' => -1,
                    'conditions' => array(
                        'TransportBillDetailRides.id' => $transportBillDetailRideId,
                        'Observation.id' => $observationId,
                        'TransportBill.type' => 2
                    ),
                    'fields' => array(
                        'TransportBill.date',
                        'CarType.name',
                        'CarType.id',
                        'RideCategory.name',
                        'TransportBillDetailRides.type_ride',
                        'TransportBillDetailRides.type_pricing',
                        'TransportBillDetailRides.tonnage_id',
                        'TransportBillDetailRides.type_price',
                        'TransportBillDetailRides.reference',
                        'TransportBillDetailRides.is_open',
                        'TransportBillDetailRides.id',
                        'TransportBillDetailRides.detail_ride_id',
                        'TransportBillDetailRides.ride_category_id',
                        'TransportBillDetailRides.nb_trucks',
                        'TransportBillDetailRides.id',
                        'TransportBillDetailRides.status_id',
                        'DepartureDestination.id',
                        'DepartureDestination.name',
                        'ArrivalDestination.name',
                        'Supplier.name',
                        'Supplier.id',
                        'Service.name',
                        'Service.id',
                        'SupplierFinal.name',
                        'SupplierFinal.id',
                        'DetailRide.real_duration_hour',
                        'DetailRide.real_duration_day',
                        'DetailRide.real_duration_minute',
                        'DetailRide.duration_hour',
                        'DetailRide.duration_day',
                        'DetailRide.duration_minute',
                        'DetailRides.real_duration_hour',
                        'DetailRides.real_duration_day',
                        'DetailRides.real_duration_minute',
                        'DetailRides.duration_hour',
                        'DetailRides.duration_day',
                        'DetailRides.duration_minute',
                        'DetailRides.id',
                        'Ride.distance',
                        'Rides.distance',
                        'Observation.id',
                        'Observation.customer_observation',
                        'Departure.id',
                        'Departure.name',
                        'Arrival.id',
                        'Arrival.name',
                        'Type.id',
                        'Type.name',

                    ),
                    'joins' => array(

                        array(
                            'table' => 'transport_bills',
                            'type' => 'left',
                            'alias' => 'TransportBill',
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
                            'table' => 'ride_categories',
                            'type' => 'left',
                            'alias' => 'RideCategory',
                            'conditions' => array('TransportBillDetailRides.ride_category_id = RideCategory.id')
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
                            'table' => 'services',
                            'type' => 'left',
                            'alias' => 'Service',
                            'conditions' => array('TransportBill.service_id = Service.id')
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
                            'conditions' => array('TransportBillDetailRides.supplier_final_id = SupplierFinal.id')
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
                            'table' => 'tva',
                            'type' => 'left',
                            'alias' => 'Tva',
                            'conditions' => array('TransportBillDetailRides.tva_id = Tva.id')
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
                            'table' => 'rides',
                            'type' => 'left',
                            'alias' => 'Rides',
                            'conditions' => array('Departure.id = Rides.departure_destination_id', 'Arrival.id = Rides.arrival_destination_id')
                        ),
                        array(
                            'table' => 'detail_rides',
                            'type' => 'left',
                            'alias' => 'DetailRides',
                            'conditions' => array('Rides.id = DetailRides.ride_id')
                        ),
                        array(
                            'table' => 'car_types',
                            'type' => 'left',
                            'alias' => 'Type',
                            'conditions' => array('TransportBillDetailRides.car_type_id = Type.id')
                        ),

                    )
                ));
                $this->set('transportBillDetailRide', $transportBillDetailRide);
                // Get reference mission automatic parameter reference_mi_auto
                $isReferenceMissionAutomatic = $this->Parameter->getCodesParameterVal('reference_mi_auto');
                $this->set('isReferenceMissionAutomatic', $isReferenceMissionAutomatic);
                $detailRideId = $transportBillDetailRide['TransportBillDetailRides']['detail_ride_id'];
                $supplierId = $transportBillDetailRide['Supplier']['id'];
                $supplierFinalId = $transportBillDetailRide['SupplierFinal']['id'];
                $rideCategoryId = $transportBillDetailRide['TransportBillDetailRides']['ride_category_id'];
                $managementParameterMissionCost = $this->getManagementParameterMissionCost();
                $missionCost = $this->getMissionCost($detailRideId, 0, 0, $rideCategoryId);
                $this->set('missionCost', $missionCost);
                $this->SheetRideDetailRides->DetailRide->virtualFields = array(
                    'cnames' => "CONCAT(IFNULL(TransportBillDetailRides.reference,''),' - ', DepartureDestination.name, ' - ', ArrivalDestination.name, ' - ',CarType.name, ' - ', IFNULL(RideCategory.name,'') )"
                );
                $detailRide = $this->SheetRideDetailRides->DetailRide->find('list', array(
                    'order' => 'DetailRide.wording ASC',
                    'recursive' => -1,
                    'fields' => 'cnames',
                    'conditions' => array('DetailRide.id' => $detailRideId),
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
                $departure = $this->Destination->getDestinationsByConditions(array('Destination.id' => $transportBillDetailRide['Departure']['id']), 'list');
                $arrival = $this->Destination->getDestinationsByConditions(array('Destination.id' => $transportBillDetailRide['Arrival']['id']), 'list');
                $supplier = $this->Supplier->getSuppliersByParams(1, 1, null, array(2, 3), null, $supplierId);
                if(!empty($supplierId)){
                    $finalSupplier = $this->Supplier->getFinalSuppliersByInitialSupplier($supplierId, $supplierFinalId);

                }else {
                    $finalSupplier = array();
                }
                $this->set(compact('detailRide', 'supplier', 'finalSupplier', 'departure', 'arrival'));
                $marchandises = $this->Marchandise->find('list',
                    array(
                        'recursive' => -1,
                        'order' => 'name ASC',
                        'conditions' => array('Marchandise.supplier_id' => $transportBillDetailRide['Supplier']['id'])
                    ));
                $this->set('marchandises', $marchandises);
                $this->isOpenedByOtherUser("TransportBillDetailRides", 'SheetRides', 'transport bill',
                    $transportBillDetailRideId);
                if ($transportBillDetailRide['TransportBillDetailRides']['type_ride'] == 2) {
                    $firstRide = $this->getDetailRideCompanyToFirstRide($transportBillDetailRide['Departure']['id'],
                        $transportBillDetailRide['Departure']['name'], $transportBillDetailRide['Type']['id']);
                } else {
                    $firstRide = $this->getDetailRideCompanyToFirstRide($transportBillDetailRide['DepartureDestination']['id'],
                        $transportBillDetailRide['DepartureDestination']['name'], $transportBillDetailRide['CarType']['id']);
                }
            }
            $useRideCategory = $this->useRideCategory();
            $this->set('useRideCategory', $useRideCategory);
        }
        $carTypes = $this->CarType->getCarTypes();
        $rideCategories = $this->TransportBill->RideCategory->find('list', array(
            'order' => 'RideCategory.name ASC',
            'recursive' => -1,
            'fields' => 'name'
        ));
        $consumptions = $this->Consumption->getConsumptionsBySheetRideId($id);
        $consumptionIds = array();
        $cardIds = array();
        $tankIds = array();
        if (!empty($consumptions)) {
            foreach ($consumptions as $consumption) {
                $consumptionIds[] = $consumption['Consumption']['id'];
                $cardIds[] = $consumption['Consumption']['fuel_card_id'];
                $tankIds[] = $consumption['Consumption']['tank_id'];
                if (Configure::read("gestion_commercial") == '1'  &&
                    Configure::read("tresorerie") == '1') {
                    $compteIds[] = $consumption['Consumption']['compte_id'];
                }
            }

            if (!empty($consumptionIds)) {
                $coupons = $this->Coupon->find('list',
                    array('conditions' => array('Coupon.consumption_id' => $consumptionIds)));
                $coupons_numbers = $this->Coupon->find('all',
                    array('conditions' => array('Coupon.consumption_id' => $consumptionIds), 'fields' => array('Coupon.id')));
                $couponsSelected = array();
                foreach ($coupons_numbers as $coupons_number) {
                    $couponsSelected[] = $coupons_number['Coupon']['id'];
                }
                $cards = $this->FuelCard->find(
                    'list',
                    array(
                        'order' => 'reference ASC',
                        'conditions' => array('FuelCard.id' => $cardIds)
                    )
                );
                $tanks = $this->Tank->find(
                    'list',
                    array(
                        'order' => 'name ASC',
                        'conditions' => array('Tank.id' => $tankIds)
                    )
                );
                if (Configure::read("gestion_commercial") == '1'  &&
                    Configure::read("tresorerie") == '1') {
                    if (Configure::read("cafyb") == '1') {
                        $comptes = $this->Cafyb->getComptesByIds($compteIds);
                    } else {
                        $comptes = $this->Compte->find(
                            'list',
                            array(
                                'order' => 'num_compte ASC',
                                'conditions' => array('Compte.id' => $compteIds)
                            )
                        );
                    }
                }
            }
        }

        $paramConsumption = $this->consumptionManagement();
        // Get method of selecting coupons
        $selectingCouponsMethod = $this->Parameter->getCodesParameterVal('select_coupon');
        // Get car's tank state on new mission's start
        $departureTankStateMethod = $this->Parameter->getCodesParameterVal('departure_tank_state');
        $arrivalTankStateMethod = $this->Parameter->getCodesParameterVal('arrival_tank_state');

        $displayMissionCost = $this->isDisplayMissionCost();

        $timeParameters = $this->getTimeParametersToCalculateArrivalDate();
        $parameter = $this->Parameter->find('all', array(
            'recursive' => -1,
            'conditions' => array('code' => array(10, 23))
        ));

        $this->request->data['SheetRide']['coupon_price'] = $parameter[0]['Parameter']['val'];
        $this->request->data['SheetRide']['difference_allowed'] = $parameter[1]['Parameter']['val'];
        $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
        $calculByMaps = $this->Parameter->getCodesParameterVal('calcul_by_maps');

        $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
		$addCarSubcontracting = $this->Parameter->getCodesParameterVal('car_subcontracting');
        $fieldMarchandiseRequired = $this->Parameter->getCodesParameterVal('marchandise_required');
        $negativeAccount = $this->Parameter->getCodesParameterVal('negative_account');
        $services = $this->Service->getServices('list');
        $isDestinationRequired = $this->isDestinationRequired();
        $cardAmountVerification = $this->Parameter->getCodesParameterVal('card_amount_verification');
        $defaultConsumptionMethod = $this->Parameter->getCodesParameterVal('default_consumption_method');

        $this->set(compact('addCarSubcontracting','managementParameterMissionCost',
            'displayMissionCost', 'rideCategories', 'cards', 'selectingCouponsMethod','comptes',
            'negativeAccount', 'departureTankStateMethod', 'arrivalTankStateMethod', 'coupons',
            'detailRides', 'cars', 'customers', 'suppliers', 'carTypes', 'remorques',
            'paramConsumption', 'priority', 'firstRide', 'couponsSelected', 'coupons_numbers',
            'fieldMarchandiseRequired', 'timeParameters', 'consumptions', 'tanks','isDestinationRequired',
            'paramPriceNight', 'calculByMaps', 'usePurchaseBill', 'lots','services','defaultConsumptionMethod',
            'sheetRideWithMission','cardAmountVerification'));
    }

    public function editAgent($id = null, $transportBillDetailRideId = null, $observationId = null)
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

        if(isset($transportBillDetailRideId) && !empty($transportBillDetailRideId)){
            $this->isOpenedByOtherUser("TransportBillDetailRides", 'SheetRides', 'transport bill',
                $transportBillDetailRideId);
        }
        $isAgent = $this->isAgent();
        $this->set('isAgent', $isAgent);

        if (!$isAgent) {
            $this->verifyUserPermission(SectionsEnum::feuille_de_route, $user_id,
                ActionsEnum::edit, "SheetRides", $id, "SheetRide", null);
        }
        $reference = $this->getNextTransportReference(TransportBillTypesEnum::sheet_ride);
        $this->set('reference', $reference);
        // Get reference mission automatic parameter reference_mi_auto
        $isReferenceMissionAutomatic = $this->Parameter->getCodesParameterVal('reference_mi_auto');
        $this->set('referenceMission', $isReferenceMissionAutomatic);
        if (!$this->SheetRide->exists($id)) {
            throw new NotFoundException(__('Invalid sheet ride'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->closeItemOpened('SheetRide', $id);
                $this->Flash->error(__('Changes were not saved. Sheet ride cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            // calculate diff between date open and date submit if diff > 15 min redirect to index dont save modification
            $currentDateAdd = $this->request->data['SheetRide']['currentDateAdd'];
            $currentDateSubmit = date('Y-m-d H:i');
            $currentDateAdd = new DateTime ($currentDateAdd);
            $currentDateSubmit = new DateTime ($currentDateSubmit);
            $interval = date_diff($currentDateAdd, $currentDateSubmit);
            $total = $interval->y * 526600 + $interval->m * 43800 + $interval->d * 1440 + $interval->h * 60 + $interval->i;
            if ($total > 100) {
                $this->Flash->error(__('The sheet ride could not be saved2. Please, try again.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->createDatetimeFromDatetime('SheetRide', 'end_date');
            $this->createDatetimeFromDatetime('SheetRide', 'start_date');
            $this->createDatetimeFromDatetime('SheetRide', 'real_start_date');
            $this->createDatetimeFromDatetime('SheetRide', 'real_end_date');
            $this->request->data['SheetRide']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            $this->closeItemOpened('SheetRide', $id);
            if (isset($this->request->data['SheetRide']['car_subcontracting']) && ($this->request->data['SheetRide']['car_subcontracting'] == 1)) {
                if(Configure::read('car_required')=='1'){
                    $this->SheetRide->validate = $this->SheetRide->validateSubcontractingRequired;
                }else {
                    $this->SheetRide->validate = $this->SheetRide->validateSubcontracting;
                }
            }


            $this->request->data['SheetRide']['modified_id'] = $this->Session->read('Auth.User.id');
            if ($this->SheetRide->save($this->request->data)) {

                if (isset($this->request->data['Consumption']['deleted_id']) &&
                    !empty($this->request->data['Consumption']['deleted_id'])) {
                    $consumptionDeletedId = $this->request->data['Consumption']['deleted_id'];
                    $consumptionIds = explode(",", $consumptionDeletedId);
                    foreach ($consumptionIds as $consumptionId) {
                        $this->deleteConsumption($consumptionId);
                    }
                }
                if (isset($this->request->data['Consumption'])
                    && !empty($this->request->data['Consumption'])
                ) {
                    $consumptions = $this->request->data['Consumption'];
                    foreach ($consumptions as $consumption) {
                        if (!empty($consumption['id'])) {
                            $this->resetConsumption($consumption['id'],
                                $consumption['type_consumption_used']);
                            $this->updateConsumption($consumption, $id);
                        } else {
                            $this->addConsumption($consumption, $id);
                        }
                    }
                }

                if (isset($this->request->data['SheetRideDepartureCarState'])) {
                    $sheetRideDepartureCarStates = $this->request->data['SheetRideDepartureCarState'];

                }else {
                    $sheetRideDepartureCarStates =null;
                }
                if (!empty($sheetRideDepartureCarStates)) {

                foreach ($sheetRideDepartureCarStates as $sheetRideDepartureCarState) {
                    if (isset($sheetRideDepartureCarState['id']) &&
                        !empty($sheetRideDepartureCarState['id'])) {
                        $this->updateSheetRideCarState($sheetRideDepartureCarState, $id);
                    } else {
                        $this->addSheetRideCarState($sheetRideDepartureCarState, $id);
                    }
                }
            }
               if(isset($this->request->data['SheetRideArrivalCarState'])){
                   $sheetRideArrivalCarStates = $this->request->data['SheetRideArrivalCarState'];
               } else {
                   $sheetRideArrivalCarStates = null;
               }
            if(!empty($sheetRideArrivalCarStates)){
                foreach ($sheetRideArrivalCarStates as $sheetRideArrivalCarState){
                    if(isset($sheetRideArrivalCarState['id'])&&
                        !empty($sheetRideArrivalCarState['id'])){
                        $this->updateSheetRideCarState($sheetRideArrivalCarState,$id);
                    }else {
                        $this->addSheetRideCarState($sheetRideArrivalCarState,$id);
                    }
                }
            }
                $this->SheetRideManagement->updateStatusSheetRideByDefaultStatus($id);

                $this->saveUserAction(SectionsEnum::feuille_de_route,
                    $id, $this->Session->read('Auth.User.id'), ActionsEnum::edit);

                $this->Flash->success(__('The sheet ride has been saved.'));
                $this->redirect($url);
            } else {
                $this->Flash->error(__('The sheet ride could not be saved3. Please, try again.'));
            }
        } else {
            $this->isOpenedByOtherUser("SheetRide", 'SheetRides', 'sheet ride', $id);
            $options = array('conditions' => array('SheetRide.' . $this->SheetRide->primaryKey => $id));
            $this->request->data = $this->SheetRide->find('first', $options);



            $permissionEditCarState = $this->verifyUserPermission(SectionsEnum::etat_vehicule, $user_id, ActionsEnum::edit,
                "CarStates", null, "CarState", null,1);
            $this->set('permissionEditCarState',$permissionEditCarState);
            if($permissionEditCarState || $isAgent){
                $this->loadModel('CarState');
                $sheetRideDepartureCarStates = $this->SheetRideCarState->getSheetRideCarStatesBySheetRideId($id,1);
                $sheetRideArrivalCarStates = $this->SheetRideCarState->getSheetRideCarStatesBySheetRideId($id,2);
                $departureCarStateId  = array();
                if(!empty($sheetRideDepartureCarStates)){
                foreach ($sheetRideDepartureCarStates as $sheetRideDepartureCarState){
                    $departureCarStateId[]=$sheetRideDepartureCarState['SheetRideCarState']['car_state_id'];
                }}

                if(!empty($departureCarStateId)){
                    $conditions = array("CarState.id NOT IN  ( '" . implode( "', '" , $departureCarStateId ) . "' )");
                    $departureCarStates = $this->CarState->getCarStatesByConditions('all',$conditions);
                }else {
                    $departureCarStates = $this->CarState->getCarStatesByConditions('all');
                }
                $arrivalCarStateId  = array();
                if(!empty($sheetRideArrivalCarStates)){
                foreach ($sheetRideArrivalCarStates as $sheetRideArrivalCarState){
                    $arrivalCarStateId[]=$sheetRideArrivalCarState['SheetRideCarState']['car_state_id'];
                }}
                if(!empty($arrivalCarStateId)){
                    $conditions = array("CarState.id NOT IN  ( '" . implode( "', '" , $arrivalCarStateId ) . "' )");
                    $arrivalCarStates = $this->CarState->getCarStatesByConditions('all',$conditions);
                }else {
                    $arrivalCarStates = $this->CarState->getCarStatesByConditions('all');
                }

                $this->set(compact('carStates','sheetRideDepartureCarStates',
                    'sheetRideArrivalCarStates','departureCarStates','arrivalCarStates'));
            }

        }

        $consumptions = $this->Consumption->getConsumptionsBySheetRideId($id);
        $consumptionIds = array();
        $cardIds = array();
        $tankIds = array();
        if (!empty($consumptions)) {
            foreach ($consumptions as $consumption) {
                $consumptionIds[] = $consumption['Consumption']['id'];
                $cardIds[] = $consumption['Consumption']['fuel_card_id'];
                $tankIds[] = $consumption['Consumption']['tank_id'];
                if (Configure::read("gestion_commercial") == '1'  &&
                    Configure::read("tresorerie") == '1') {
                    $compteIds[] = $consumption['Consumption']['compte_id'];
                }
            }

            if (!empty($consumptionIds)) {
                $coupons = $this->Coupon->find('list',
                    array('conditions' => array('Coupon.consumption_id' => $consumptionIds)));
                $coupons_numbers = $this->Coupon->find('all',
                    array('conditions' => array('Coupon.consumption_id' => $consumptionIds), 'fields' => array('Coupon.id')));
                $couponsSelected = array();
                foreach ($coupons_numbers as $coupons_number) {
                    $couponsSelected[] = $coupons_number['Coupon']['id'];
                }
                $cards = $this->FuelCard->find(
                    'list',
                    array(
                        'order' => 'reference ASC',
                        'conditions' => array('FuelCard.id' => $cardIds)
                    )
                );
                $tanks = $this->Tank->find(
                    'list',
                    array(
                        'order' => 'name ASC',
                        'conditions' => array('Tank.id' => $tankIds)
                    )
                );
                if (Configure::read("gestion_commercial") == '1'  &&
                    Configure::read("tresorerie") == '1') {
                    if (Configure::read("cafyb") == '1') {
                        $comptes = $this->Cafyb->getComptesByIds($compteIds);
                    } else {
                        $comptes = $this->Compte->find(
                            'list',
                            array(
                                'order' => 'num_compte ASC',
                                'conditions' => array('Compte.id' => $compteIds)
                            )
                        );
                    }
                }
            }
        }

        if ($this->request->data['SheetRide']['car_subcontracting'] == 1) {
            if(Configure::read('car_required')=='1'){
                $this->SheetRide->validate = $this->SheetRide->validateSubcontractingRequired;
            }else {
                $this->SheetRide->validate = $this->SheetRide->validateSubcontracting;
            }
            $conditionsSubcontractor = array('Supplier.id' => $this->request->data['SheetRide']['supplier_id']);
            $subcontractor = $this->Supplier->getSuppliersByParams(0, 1, null, null, 'list', null, $conditionsSubcontractor);
            $this->set('subcontractor', $subcontractor);

        } else {
            $param = $this->Parameter->getCodesParameterVal('name_car');
            if ($param == 1) {
                $this->SheetRide->Car->virtualFields = array(
                    'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name, ' - ', IFNULL(Customer.first_name,''), ' ', IFNULL(Customer.last_name,''))"
                );
            } elseif ($param == 2) {
                $this->SheetRide->Car->virtualFields = array(
                    'cnames' => "CONCAT(IFNULL(Car.immatr_def,Car.immatr_prov), ' - ', Carmodel.name, ' - ', IFNULL(Customer.first_name,''), ' ', IFNULL(Customer.last_name,''))"
                );
            }
            $cars = $this->SheetRide->Car->find('list', array(
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
                ),
                'conditions' => array('Car.id' => $this->request->data['SheetRide']['car_id'])

            ));
            $remorques = $this->SheetRide->Car->find('list', array(
                'fields' => 'cnames',
                'recursive' => -1,
                'order' => array('Car.code asc', 'Carmodel.name asc'),
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
                ),
                'conditions' => array('Car.id' => $this->request->data['SheetRide']['remorque_id']),
            ));
            $fields = "names";
            $conditionsCustomer = array('Customer.id' => $this->request->data['SheetRide']['customer_id']);
            $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditionsCustomer);

            $this->set(compact('remorques','cars','customers'));
            $sheetRideConveyors = $this->SheetRideConveyor->getConveyorsBySheetRideId($id);
            $conveyorIds = array();
            foreach ($sheetRideConveyors as $sheetRideConveyor) {
                $conveyorIds[] = $sheetRideConveyor['SheetRideConveyor']['conveyor_id'];
            }
            if (!empty($conveyorIds)) {
                $conditionsConveyor = array('Customer.id' => $conveyorIds);
                $conveyors = $this->Customer->getCustomersByFieldsAndConds($fields, $conditionsConveyor);
                $this->set('conveyors',$conveyors);
            }
        }
        $paramConsumption = $this->consumptionManagement();
        // Get method of selecting coupons
        $selectingCouponsMethod = $this->Parameter->getCodesParameterVal('select_coupon');
        // Get car's tank state on new mission's start
        $departureTankStateMethod = $this->Parameter->getCodesParameterVal('departure_tank_state');
        $arrivalTankStateMethod = $this->Parameter->getCodesParameterVal('arrival_tank_state');

        $displayMissionCost = $this->isDisplayMissionCost();

        $timeParameters = $this->getTimeParametersToCalculateArrivalDate();
        $parameter = $this->Parameter->find('all', array(
            'recursive' => -1,
            'conditions' => array('code' => array(10, 23))
        ));

        $this->request->data['SheetRide']['coupon_price'] = $parameter[0]['Parameter']['val'];
        $this->request->data['SheetRide']['difference_allowed'] = $parameter[1]['Parameter']['val'];
        $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
        $calculByMaps = $this->Parameter->getCodesParameterVal('calcul_by_maps');
        $negativeAccount = $this->Parameter->getCodesParameterVal('negative_account');
        $isDestinationRequired = $this->isDestinationRequired();
        $cardAmountVerification = $this->Parameter->getCodesParameterVal('card_amount_verification');
        $defaultConsumptionMethod = $this->Parameter->getCodesParameterVal('default_consumption_method');
        $addCarSubcontracting = $this->Parameter->getCodesParameterVal('car_subcontracting');
        $this->set(compact('managementParameterMissionCost','addCarSubcontracting',
            'displayMissionCost', 'rideCategories', 'cards', 'selectingCouponsMethod','comptes',
            'negativeAccount', 'departureTankStateMethod', 'arrivalTankStateMethod', 'coupons',
            'paramConsumption', 'priority', 'firstRide', 'couponsSelected', 'coupons_numbers',
            'fieldMarchandiseRequired', 'timeParameters', 'consumptions', 'tanks','isDestinationRequired',
            'paramPriceNight', 'calculByMaps', 'defaultConsumptionMethod',
            'sheetRideWithMission','cardAmountVerification'));
    }



    public function duplicate($id = null)
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
            $this->verifyUserPermission(SectionsEnum::feuille_de_route, $user_id,
                ActionsEnum::add, "SheetRides", $id, "SheetRide", null);
        }
        $reference = $this->getNextTransportReference(TransportBillTypesEnum::sheet_ride);
        $this->set('reference', $reference);
        // Get reference mission automatic parameter reference_mi_auto
        $isReferenceMissionAutomatic = $this->Parameter->getCodesParameterVal('reference_mi_auto');
        $this->set('referenceMission', $isReferenceMissionAutomatic);
        if (!$this->SheetRide->exists($id)) {
            throw new NotFoundException(__('Invalid sheet ride'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                if (isset($transportBillDetailRideId) && !empty($transportBillDetailRideId)) {
                    $this->TransportBillDetailRides->id = $transportBillDetailRideId;
                    $this->TransportBillDetailRides->saveField('is_open', 0);
                }
                $this->redirect($url);
            }
            // calculate diff between date open and date submit if diff > 15 min redirect to index dont save modification
            $currentDateAdd = $this->request->data['SheetRide']['currentDateAdd'];
            $currentDateSubmit = date('Y-m-d H:i');
            $currentDateAdd = new DateTime ($currentDateAdd);
            $currentDateSubmit = new DateTime ($currentDateSubmit);
            $interval = date_diff($currentDateAdd, $currentDateSubmit);
            $total = $interval->y * 526600 + $interval->m * 43800 + $interval->d * 1440 + $interval->h * 60 + $interval->i;
            if ($total > 15) {
                $this->Flash->error(__('The sheet ride could not be saved. Please, try again.'));
                $this->redirect($url);
            }
            $this->SheetRide->create();
            $reference = $this->getNextTransportReference(TransportBillTypesEnum::sheet_ride);
            if ($reference != 0) {
                $this->request->data['SheetRide']['reference'] = $reference;
            }
            $this->createDatetimeFromDatetime('SheetRide', 'end_date');
            $this->createDatetimeFromDatetime('SheetRide', 'start_date');
            $this->createDatetimeFromDatetime('SheetRide', 'real_start_date');
            $this->createDatetimeFromDatetime('SheetRide', 'real_end_date');
            $this->request->data['SheetRide']['user_id'] = $this->Session->read('Auth.User.id');
            if (isset($this->request->data['SheetRide']['car_subcontracting']) && ($this->request->data['SheetRide']['car_subcontracting'] == 1)) {
                if(Configure::read('car_required')=='1'){
                    $this->SheetRide->validate = $this->SheetRide->validateSubcontractingRequired;
                }else {
                    $this->SheetRide->validate = $this->SheetRide->validateSubcontracting;
                }
            }
            /* var_dump($this->SheetRide->save($this->request->data));
             var_dump($this->SheetRide->validationErrors);die();*/
            if ($this->SheetRide->save($this->request->data)) {
                $this->Parameter->setNextTransportReferenceNumber(TransportBillTypesEnum::sheet_ride);
                $sheetRideId = $this->SheetRide->getInsertID();
                if(!empty($this->request->data['SheetRideDepartureCarState'])){
                    $this->addSheetRideCarStates($this->request->data['SheetRideDepartureCarState'],$sheetRideId);
                }
                if(!empty($this->request->data['SheetRideArrivalCarState'])){
                    $this->addSheetRideCarStates($this->request->data['SheetRideArrivalCarState'],$sheetRideId);
                }
                if (isset($this->request->data['SheetRideDetailRides']) &&
                    !empty($this->request->data['SheetRideDetailRides'])) {
                    if (isset($this->request->data['SheetRide']['car_id'])) {
                        $carId = $this->request->data['SheetRide']['car_id'];
                        $carOffshore = $this->isCarOffshore($this->request->data['SheetRide']['car_id']);
                        $save = $this->add_Rides_sheetRide($this->request->data['SheetRideDetailRides'], $reference, $sheetRideId, $carId, $carOffshore);
                        //  var_dump($save); die();
                        if ($save == false) {
                            $this->SheetRide->deleteAll(array('SheetRide.id' => $sheetRideId),
                                false);
                            $this->Flash->error(__('The sheet ride could not be saved. Please, try again.'));
                            $this->redirect(array('action' => 'index'));
                        }
                    } else {
                        if(isset($this->request->data['SheetRide']['supplier_id'])){
                            $subcontractorId = $this->request->data['SheetRide']['supplier_id'];
                            $save = $this->add_Rides_sheetRide($this->request->data['SheetRideDetailRides'],
                                $reference, $sheetRideId, null, null, $subcontractorId);

                        }else {
                            $save = $this->add_Rides_sheetRide($this->request->data['SheetRideDetailRides'], $reference, $sheetRideId);

                        }
                        if ($save == false) {
                            $this->SheetRide->deleteAll(array('SheetRide.id' => $sheetRideId),
                                false);
                            $this->Flash->error(__('The sheet ride could not be saved. Please, try again.'));
                            $this->redirect($url);
                        }
                    }
                }
                $consumptions = $this->request->data['Consumption'];

                $this->saveConsumptions($consumptions, $sheetRideId);
                if (isset($this->request->data['SheetRide']['car_id'])) {
                    $this->updateCarReservoir($this->request->data['SheetRide']['car_id']);
                    $this->updateCarKm($this->request->data['SheetRide']['car_id']);
                    $this->updateCarMission($this->request->data['SheetRide']['car_id']);
                }
                if (isset($this->request->data['SheetRide']['customer_id'])) {
                    $this->updateCustomerMission($this->request->data['SheetRide']['customer_id']);
                    $this->Customer->setLastDateMission($this->request->data['SheetRide']['customer_id'],
                        $this->request->data['SheetRide']['end_date'],$this->request->data['SheetRide']['real_end_date'],
                        $this->request->data['SheetRide']['start_date'],$this->request->data['SheetRide']['real_start_date']
                    );
                }
                $this->SheetRideManagement->updateStatusSheetRideByDefaultStatus($sheetRideId);

                if (!empty($this->request->data['SheetRideConveyor'])) {
                    $sheetRideConveyors = $this->request->data['SheetRideConveyor'];
                    $this->SheetRideConveyor->addSheetRideConveyors($sheetRideConveyors, $sheetRideId);
                }
                $this->saveUserAction(SectionsEnum::feuille_de_route,
                    $sheetRideId, $this->Session->read('Auth.User.id'), ActionsEnum::add);
                $this->Flash->success(__('The sheet ride has been saved.'));
                $this->redirect($url);
            } else {
                $this->Flash->error(__('The sheet ride could not be saved1. Please, try again.'));
                $this->redirect($url);
            }
        }
        else {
            $this->isOpenedByOtherUser("SheetRide", 'SheetRides', 'sheet ride', $id);
            $options = array('conditions' => array('SheetRide.' . $this->SheetRide->primaryKey => $id));
            $this->request->data = $this->SheetRide->find('first', $options);
            $sheetRideWithMission = $this->Parameter->getCodesParameterVal('sheet_ride_with_mission');
            if($sheetRideWithMission == 2){
                $travelReasons = $this->TravelReason->getTravelReasons('list');
                $conditions = array('Destination.id'=>$this->request->data['SheetRide']['destination_id']);
                $destinations = $this->Destination->getDestinations('list',$conditions);
                $this->set(compact('travelReasons','destinations'));
                $this->set('nb_rides', 0);
                $wilaya['wilayaName'] ="";
                $this->set('wilaya', $wilaya);
            }else {
                $rides_sheet_rides = $this->SheetRideDetailRides->find('all', array(
                    'order' => array('SheetRideDetailRides.order_mission ASC, SheetRideDetailRides.id ASC'),
                    'group' => 'SheetRideDetailRides.id',
                    'recursive' => -1,
                    'fields' => array(
                        'SheetRideDetailRides.id',
                        'SheetRideDetailRides.order_mission',
                        'SheetRideDetailRides.detail_ride_id',
                        'SheetRideDetailRides.ride_category_id',
                        'SheetRideDetailRides.transport_bill_detail_ride_id',
                        'SheetRideDetailRides.observation_id',
                        'SheetRideDetailRides.invoiced_ride',
                        'SheetRideDetailRides.from_customer_order',
                        'SheetRideDetailRides.truck_full',
                        'SheetRideDetailRides.return_mission',
                        'SheetRideDetailRides.type_price',
                        'SheetRideDetailRides.planned_start_date',
                        'SheetRideDetailRides.real_start_date',
                        'SheetRideDetailRides.km_departure',
                        'SheetRideDetailRides.planned_end_date',
                        'SheetRideDetailRides.real_end_date',
                        'SheetRideDetailRides.km_arrival_estimated',
                        'SheetRideDetailRides.km_arrival',
                        'SheetRideDetailRides.supplier_id',
                        'SheetRideDetailRides.supplier_final_id',
                        'SheetRideDetailRides.mission_cost',
                        'SheetRideDetailRides.toll',
                        'SheetRideDetailRides.remaining_time',
                        'SheetRideDetailRides.departure_destination_id',
                        'SheetRideDetailRides.arrival_destination_id',
                        'SheetRideDetailRides.price',
                        'SheetRideDetailRides.status_id',
                        'SheetRideDetailRides.type_ride',
                        'SheetRideDetailRides.source',
                        'Supplier.id',
                        'SupplierFinal.id',
                        'SheetRideDetailRides.attachment1',
                        'SheetRideDetailRides.attachment2',
                        'SheetRideDetailRides.attachment3',
                        'SheetRideDetailRides.attachment4',
                        'SheetRideDetailRides.attachment5',
                        'SheetRideDetailRides.note',
                        'DetailRide.real_duration_hour',
                        'DetailRide.real_duration_day',
                        'DetailRide.real_duration_minute',
                        'DetailRide.id',
                        'Ride.distance',
                        'DetailRides.real_duration_hour',
                        'DetailRides.real_duration_day',
                        'DetailRides.real_duration_minute',
                        'DetailRides.id',
                        'Rides.distance',
                        'DepartureDestination.id',
                        'DepartureDestination.name',
                        'ArrivalDestination.id',
                        'ArrivalDestination.name',
                        'Departure.id',
                        'Departure.name',
                        'Arrival.id',
                        'Arrival.name',
                        'CarType.id',
                        'RideCategory.id',
                        'RideCategory.name',
                    ),
                    'conditions' => array('SheetRideDetailRides.sheet_ride_id' => $id),
                    'joins' => array(
                        array(
                            'table' => 'detail_rides',
                            'type' => 'left',
                            'alias' => 'DetailRide',
                            'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
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
                            'table' => 'rides',
                            'type' => 'left',
                            'alias' => 'Rides',
                            'conditions' => array('Departure.id = Rides.departure_destination_id', 'Arrival.id = Rides.arrival_destination_id')
                        ),
                        array(
                            'table' => 'detail_rides',
                            'type' => 'left',
                            'alias' => 'DetailRides',
                            'conditions' => array('Rides.id = DetailRides.ride_id')
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
                            'conditions' => array('SheetRideDetailRides.ride_category_id = RideCategory.id')
                        ),
                    )
                ));

                $detailRideIds = array();
                $supplierIds = array();
                $finalSupplierIds = array();
                $destinationId = array();
                $sheetRideDetailRideIds = array();
                foreach ($rides_sheet_rides as $rides_sheet_ride) {
                    $detailRideIds[] = $rides_sheet_ride['DetailRide']['id'];
                    $supplierIds[] = $rides_sheet_ride['Supplier']['id'];
                    $finalSupplierIds[] = $rides_sheet_ride['SupplierFinal']['id'];
                    $destinationId[] = $rides_sheet_ride['SheetRideDetailRides']['departure_destination_id'];
                    $destinationId[] = $rides_sheet_ride['SheetRideDetailRides']['arrival_destination_id'];
                    $sheetRideDetailRideIds[] = $rides_sheet_ride['SheetRideDetailRides']['id'];
                }

                $this->SheetRideDetailRides->DetailRide->virtualFields = array(
                    'cnames' => "CONCAT(IFNULL(TransportBillDetailRides.reference,''),' - ', DepartureDestination.name, ' - ', ArrivalDestination.name, ' - ',CarType.name, ' - ', IFNULL(RideCategory.name,'') )"
                );
                $detailRides = $this->SheetRideDetailRides->DetailRide->find('list', array(
                    'order' => 'DetailRide.wording ASC',
                    'conditions' => array('DetailRide.id' => $detailRideIds),
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
                $suppliers = $this->Supplier->getSuppliersByParams(1, 1, null, array(2, 3), null, $supplierIds);
                $i = 0;
                $finalSuppliers = array();

                if(!empty($supplierIds)){

                    foreach ($supplierIds as $supplierId) {
                        if($supplierId!=NULL){
                            $finalSuppliers[] = $this->Supplier->getFinalSuppliersByInitialSupplier($supplierId, $finalSupplierIds[$i]);
                            $i++;
                        }
                    }
                }
                $conditions = array('Destination.id' => $destinationId);
                $destinations = $this->Destination->getDestinationsByConditions($conditions, 'list');

                $this->set(compact('detailRides', 'suppliers', 'finalSuppliers',
                    'destinations', 'conveyors', 'sheetRideConveyors'));
                $managementParameterMissionCost = $this->getManagementParameterMissionCost();
                switch ($managementParameterMissionCost) {
                    case '1':
                        $i = 1;
                        foreach ($rides_sheet_rides as $rides_sheet_ride) {
                            $detailRideId = $rides_sheet_ride['SheetRideDetailRides']['detail_ride_id'];
                            $cost = $this->getMissionCostByDay($detailRideId);
                            $missionCost[$i] = $cost;
                            $i++;
                        }
                        break;

                    case '2':
                        $i = 1;
                        foreach ($rides_sheet_rides as $rides_sheet_ride) {
                            $detailRideId = $rides_sheet_ride['SheetRideDetailRides']['detail_ride_id'];
                            $cost = $this->getMissionCostByDestination($detailRideId);
                            $missionCost[$i] = $cost;
                            $i++;
                        }
                        break;

                    case '3':
                        $missionCost = array();
                        $i = 1;
                        foreach ($rides_sheet_rides as $rides_sheet_ride) {
                            $detailRideId = $rides_sheet_ride['SheetRideDetailRides']['detail_ride_id'];
                            $rideCategoryId = $rides_sheet_ride['SheetRideDetailRides']['ride_category_id'];
                            $cost = $this->getMissionCostByDistance($detailRideId, $rideCategoryId);
                            $missionCost[$i] = $cost;
                            $i++;
                        }
                        break;
                }
                $this->set('missionCost', $missionCost);
                $this->set('rides_sheet_rides', $rides_sheet_rides);
                if ($rides_sheet_rides[0]['SheetRideDetailRides']['type_ride'] == 2) {
                    $firstRide = $this->getDetailRideCompanyToFirstRide($rides_sheet_rides[0]['Departure']['id'],
                        $rides_sheet_rides[0]['Departure']['name'], $this->request->data['SheetRide']['car_type_id']);
                } else {
                    $firstRide = $this->getDetailRideCompanyToFirstRide($rides_sheet_rides[0]['DepartureDestination']['id'],
                        $rides_sheet_rides[0]['DepartureDestination']['name'], $rides_sheet_rides[0]['CarType']['id']);
                }

                $nb_rides = $this->SheetRideDetailRides->find('count',
                    array('conditions' => array('SheetRideDetailRides.sheet_ride_id' => $id)));
                $this->set('nb_rides', $nb_rides);

                if ($rides_sheet_rides[$nb_rides-1]['SheetRideDetailRides']['type_ride'] == 2) {
                    $retourParc = $this->getDetailRideCompanyToFirstRide($rides_sheet_rides[$nb_rides-1]['Arrival']['id'],
                        $rides_sheet_rides[$nb_rides-1]['Arrival']['name'], $this->request->data['SheetRide']['car_type_id']);
                } else {
                    $retourParc = $this->getDetailRideCompanyToFirstRide($rides_sheet_rides[$nb_rides-1]['ArrivalDestination']['id'],
                        $rides_sheet_rides[$nb_rides-1]['ArrivalDestination']['name'], $rides_sheet_rides[$nb_rides-1]['CarType']['id']);
                }

                $this->set('retourParc',$retourParc);
            }

            if ($this->request->data['SheetRide']['car_subcontracting'] == 1) {
                if(Configure::read('car_required')=='1'){
                    $this->SheetRide->validate = $this->SheetRide->validateSubcontractingRequired;
                }else {
                    $this->SheetRide->validate = $this->SheetRide->validateSubcontracting;
                }
                $conditionsSubcontractor = array('Supplier.id' => $this->request->data['SheetRide']['supplier_id']);
                $subcontractor = $this->Supplier->getSuppliersByParams(0, 1, null, null, 'list', null, $conditionsSubcontractor);
                $this->set('subcontractor', $subcontractor);

            } else {
                $param = $this->Parameter->getCodesParameterVal('name_car');
                if ($param == 1) {
                    $this->SheetRide->Car->virtualFields = array(
                        'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name, ' - ', IFNULL(Customer.first_name,''), ' ', IFNULL(Customer.last_name,''))"
                    );
                } elseif ($param == 2) {
                    $this->SheetRide->Car->virtualFields = array(
                        'cnames' => "CONCAT(IFNULL(Car.immatr_def,Car.immatr_prov), ' - ', Carmodel.name, ' - ', IFNULL(Customer.first_name,''), ' ', IFNULL(Customer.last_name,''))"
                    );
                }
                $cars = $this->SheetRide->Car->find('list', array(
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
                    ),
                    'conditions' => array('Car.id' => $this->request->data['SheetRide']['car_id'])

                ));
                $remorques = $this->SheetRide->Car->find('list', array(
                    'fields' => 'cnames',
                    'recursive' => -1,
                    'order' => array('Car.code asc', 'Carmodel.name asc'),
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
                    ),
                    'conditions' => array('Car.id' => $this->request->data['SheetRide']['remorque_id']),
                ));
                $fields = "names";
                $conditionsCustomer = array('Customer.id' => $this->request->data['SheetRide']['customer_id']);
                $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditionsCustomer);

                $sheetRideConveyors = $this->SheetRideConveyor->getConveyorsBySheetRideId($id);
                $conveyorIds = array();
                foreach ($sheetRideConveyors as $sheetRideConveyor) {
                    $conveyorIds[] = $sheetRideConveyor['SheetRideConveyor']['conveyor_id'];
                }
                if (!empty($conveyorIds)) {
                    $conditionsConveyor = array('Customer.id' => $conveyorIds);
                    $conveyors = $this->Customer->getCustomersByFieldsAndConds($fields, $conditionsConveyor);
                    $this->set('conveyors',$conveyors);
                }
            }

            $permissionEditCarState = $this->verifyUserPermission(SectionsEnum::etat_vehicule, $user_id, ActionsEnum::edit,
                "CarStates", null, "CarState", null,1);
            $this->set('permissionEditCarState',$permissionEditCarState);
            if($permissionEditCarState || $isAgent){
                $this->loadModel('CarState');
                $sheetRideDepartureCarStates = $this->SheetRideCarState->getSheetRideCarStatesBySheetRideId($id,1);
                $sheetRideArrivalCarStates = $this->SheetRideCarState->getSheetRideCarStatesBySheetRideId($id,2);
                $departureCarStateId  = array();
                if(!empty($sheetRideDepartureCarStates)){
                foreach ($sheetRideDepartureCarStates as $sheetRideDepartureCarState){
                    $departureCarStateId[]=$sheetRideDepartureCarState['SheetRideCarState']['car_state_id'];
                }}
                if(!empty($departureCarStateId)){
                    $conditions = array('CarState.id NOT IN '=>$departureCarStateId);
                    $departureCarStates = $this->CarState->getCarStatesByConditions('all',$conditions);
                }else {
                    $departureCarStates = $this->CarState->getCarStatesByConditions('all');
                }
                $arrivalCarStateId  = array();
                if(!empty($sheetRideArrivalCarStates)){
                foreach ($sheetRideArrivalCarStates as $sheetRideArrivalCarState){
                    $arrivalCarStateId[]=$sheetRideArrivalCarState['SheetRideCarState']['car_state_id'];
                }}
                if(!empty($arrivalCarStateId)){
                    $conditions = array('CarState.id NOT IN '=>$arrivalCarStateId);
                    $arrivalCarStates = $this->CarState->getCarStatesByConditions('all',$conditions);
                }else {
                    $arrivalCarStates = $this->CarState->getCarStatesByConditions('all');
                }

                $this->set(compact('carStates','sheetRideDepartureCarStates',
                    'sheetRideArrivalCarStates','departureCarStates','arrivalCarStates'));
            }

            $useRideCategory = $this->useRideCategory();
            $this->set('useRideCategory', $useRideCategory);
        }
        $carTypes = $this->CarType->getCarTypes();
        $rideCategories = $this->TransportBill->RideCategory->find('list', array(
            'order' => 'RideCategory.name ASC',
            'recursive' => -1,
            'fields' => 'name'
        ));



        $paramConsumption = $this->consumptionManagement();
        // Get method of selecting coupons
        $selectingCouponsMethod = $this->Parameter->getCodesParameterVal('select_coupon');
        // Get car's tank state on new mission's start
        $departureTankStateMethod = $this->Parameter->getCodesParameterVal('departure_tank_state');
        $arrivalTankStateMethod = $this->Parameter->getCodesParameterVal('arrival_tank_state');

        $displayMissionCost = $this->isDisplayMissionCost();

        $timeParameters = $this->getTimeParametersToCalculateArrivalDate();
        $parameter = $this->Parameter->find('all', array(
            'recursive' => -1,
            'conditions' => array('code' => array(10, 23))
        ));

        $this->request->data['SheetRide']['coupon_price'] = $parameter[0]['Parameter']['val'];
        $this->request->data['SheetRide']['difference_allowed'] = $parameter[1]['Parameter']['val'];
        $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
        $calculByMaps = $this->Parameter->getCodesParameterVal('calcul_by_maps');

        $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
		$addCarSubcontracting = $this->Parameter->getCodesParameterVal('car_subcontracting');
        $fieldMarchandiseRequired = $this->Parameter->getCodesParameterVal('marchandise_required');
        $negativeAccount = $this->Parameter->getCodesParameterVal('negative_account');
        $services = $this->Service->getServices('list');
        $isDestinationRequired = $this->isDestinationRequired();
        $cardAmountVerification = $this->Parameter->getCodesParameterVal('card_amount_verification');
        $defaultConsumptionMethod = $this->Parameter->getCodesParameterVal('default_consumption_method');
        $this->set(compact('addCarSubcontracting','managementParameterMissionCost','defaultConsumptionMethod',
            'displayMissionCost', 'rideCategories', 'cards', 'selectingCouponsMethod','comptes',
            'negativeAccount', 'departureTankStateMethod', 'arrivalTankStateMethod', 'coupons',
            'detailRides', 'cars', 'customers', 'suppliers', 'carTypes', 'remorques',
            'paramConsumption', 'priority', 'firstRide', 'couponsSelected', 'coupons_numbers',
            'fieldMarchandiseRequired', 'timeParameters', 'consumptions', 'tanks','isDestinationRequired',
            'paramPriceNight', 'calculByMaps', 'usePurchaseBill', 'lots','services',
            'sheetRideWithMission','cardAmountVerification'));
    }



    public function saveBalanceCar($carId = null, $balance = null)
    {
        $this->Car->id = $carId;
        $this->Car->saveField('balance', $balance);
    }

    /**
     * add method
     *
     * @return void
     */
    private function getCouponsUsed($couponsNumbers = null)
    {
        // cette fonction pour avoir juste les coupon utilise
        foreach ($couponsNumbers as $couponsNumber) {
            $usedCouponsNumbers[] = $couponsNumber;
        }
        return $usedCouponsNumbers;
    }

    public function getReferenceSheetRideDetailRide($id = null, $reference = null)
    {
        $countSheetRideDetailRide = $this->SheetRideDetailRides->find('count', array(
            'order' => array('SheetRideDetailRides.reference' => 'DESC'),
            'conditions' => array('SheetRideDetailRides.reference !=' => null, 'SheetRideDetailRides.sheet_ride_id' => $id),
            'recursive' => -1,
            'fields' => array('reference')
        ));

        $lastReference = (int)$countSheetRideDetailRide + 1;
        $nextReference = $reference . '/' . $lastReference;

        return $nextReference;
    }

    public function updateLastArrivalDestination($fromCustomerOrder, $detailRideId, $sheetRideId)
    {

        if ($fromCustomerOrder == '1') {
            $detail_ride = $this->TransportBillDetailRides->find('first', array(
                'conditions' => array('TransportBillDetailRides.id' => $detailRideId),
                'fields' => array('TransportBillDetailRides.detail_ride_id')
            ));

        }
        if(!empty($detail_ride)){
            $detailRideId = $detail_ride['TransportBillDetailRides']['detail_ride_id'];
            if(!empty($detailRideId)){
                $detailRide = $this->SheetRideDetailRides->DetailRide->find('first', array(
                    'recursive' => -1,
                    'fields' => array('ArrivalDestination.id', 'ArrivalZone.id'),
                    'conditions' => array('DetailRide.id' => $detailRideId),
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
                            'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                        ),
                        array(
                            'table' => 'destinations',
                            'type' => 'left',
                            'alias' => 'ArrivalDestination',
                            'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                        ),
                        array(
                            'table' => 'wilayas',
                            'type' => 'left',
                            'alias' => 'ArrivalWilaya',
                            'conditions' => array('ArrivalDestination.wilaya_id = ArrivalWilaya.id')
                        ),
                        array(
                            'table' => 'zones',
                            'type' => 'left',
                            'alias' => 'ArrivalZone',
                            'conditions' => array('ArrivalWilaya.zone_id = ArrivalZone.id')
                        )
                    )
                ));
                if (!empty($detailRide)) {
                    $this->SheetRide->id = $sheetRideId;
                    $this->SheetRide->saveField('last_arrival_destination_id', $detailRide['ArrivalDestination']['id']);
                    $this->SheetRide->saveField('last_zone_id', $detailRide['ArrivalZone']['id']);
                }
            }

        }


    }

    /**
     * @param $sheetRideDetailRideId
     */
    public function deleteSheetRideDetailRide($sheetRideDetailRideId)
    {
        $sheetRideDetailRide = $this->SheetRideDetailRides->find('first', array(
            'conditions' => array('SheetRideDetailRides.id' => $sheetRideDetailRideId),
            'recursive' => -1,
            'fields' => array('SheetRideDetailRides.transport_bill_detail_ride_id')));
        $transport_bill_detail_ride_id = $sheetRideDetailRide['SheetRideDetailRides']['transport_bill_detail_ride_id'];
        $this->SheetRideDetailRides->id = $sheetRideDetailRideId;
        $attachments = $this->Attachment->getAttachmentsBySheetRideDetailRideId($sheetRideDetailRideId);
        if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                $this->Attachment->deleteAttachmentByType('attachments/missions/' . $attachment['Attachment']['attachment_type_id'] . '/',
                    $attachment['Attachment']['id']);
            }
        }
        $this->Attachment->deleteAll(array('Attachment.article_id' => $sheetRideDetailRideId), false);
        $this->Reservation->deleteAll(array('Reservation.sheet_ride_detail_ride_id' => $sheetRideDetailRideId),
            false);
        $this->loadModel('SheetRideDetailRideMarchandise');
        $this->SheetRideDetailRideMarchandise->deleteAll(array('SheetRideDetailRideMarchandise.sheet_ride_detail_ride_id' => $sheetRideDetailRideId),
            false);


        $this->SheetRideDetailRides->delete();
        $this->TransportBillDetailRides->updateStatusTransportBillDetailRide($transport_bill_detail_ride_id);
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
        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::feuille_de_route, $user_id, ActionsEnum::delete,
            "SheetRides", $id, "SheetRide", null);
        $this->SheetRide->id = $id;
        $sheetRide = $this->SheetRide->find('first', array('conditions' => array('SheetRide.id' => $id)));
        if (!$this->SheetRide->exists()) {
            throw new NotFoundException(__('Invalid sheet ride'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->SheetRide->delete()) {
            $this->saveUserAction(SectionsEnum::feuille_de_route,
                $id, $this->Session->read('Auth.User.id'), ActionsEnum::delete);
            $this->updateCarKm($sheetRide['SheetRide']['car_id']);
            $this->updateCarMission($sheetRide['SheetRide']['car_id']);
            $this->updateCustomerMission($sheetRide['SheetRide']['customer_id']);
            $this->Flash->success(__('The sheet ride has been deleted.'));
        } else {
            $this->Flash->error(__('The sheet ride could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $sheetRideDetailRides = $this->SheetRideDetailRides->find('all',
            array("conditions" => array("SheetRideDetailRides.sheet_ride_id =" => $id)));
        $sheetRideDetailRideIds = array();
        foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
            $sheetRideDetailRideIds[] = $sheetRideDetailRide['SheetRideDetailRides']['id'];
        }
        if (!empty($sheetRideDetailRideIds)) {
            $result = $this->TransportBillDetailRides->find('all',
                array("conditions" => array("TransportBillDetailRides.sheet_ride_detail_ride_id " => $sheetRideDetailRideIds),
                    'recursive' => -1
                ));
        } else {
            $result = array();
        }

        if (!empty($result)) {
            $this->Flash->error(__('The sheet ride could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        } else {
            foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
                $sheetRideDetailRideId = $sheetRideDetailRide['SheetRideDetailRides']['id'];
                $transport_bill_detail_ride_id = $sheetRideDetailRide['SheetRideDetailRides']['transport_bill_detail_ride_id'];

                $this->SheetRideDetailRides->id = $sheetRideDetailRideId;
                $attachments = $this->Attachment->getAttachmentsBySheetRideDetailRideId($sheetRideDetailRideId);
                if (!empty($attachments)) {
                    foreach ($attachments as $attachment) {
                        $this->Attachment->deleteAttachmentByType('attachments/missions/' . $attachment['Attachment']['attachment_type_id'] . '/',
                            $attachment['Attachment']['id']);
                    }
                }
                $this->Attachment->deleteAll(array('Attachment.article_id' => $sheetRideDetailRideId), false);
                $this->Reservation->deleteAll(array('Reservation.sheet_ride_detail_ride_id' => $sheetRideDetailRideId),
                    false);
                $this->loadModel('SheetRideDetailRideMarchandise');
                $this->SheetRideDetailRideMarchandise->deleteAll(array('SheetRideDetailRideMarchandise.sheet_ride_detail_ride_id' => $sheetRideDetailRideId),
                    false);


                $this->SheetRideDetailRides->delete();
                $this->TransportBillDetailRides->updateStatusTransportBillDetailRide($transport_bill_detail_ride_id);
            }
            $consumptions = $this->Consumption->getConsumptionsBySheetRideId($id);
            foreach ($consumptions as $consumption) {
                $consumptionId = $consumption['Consumption']['id'];
                $this->deleteConsumption($consumptionId);
            }
            //$this->Consumption->deleteAll(array('Consumption.sheet_ride_id' => $id), false);
            $this->SheetRideCarState->deleteAll(array('SheetRideCarState.sheet_ride_id' => $id), false);

        }
    }

    public function deleteSheetRides()
    {
        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        $this->autoRender = false;
        $userId = $this->Auth->user('id');
        $id = filter_input(INPUT_POST, "id");
        $this->verifyUserPermission(SectionsEnum::feuille_de_route, $userId, ActionsEnum::delete,
            "SheetRides", $id, "SheetRide", null);
        $this->SheetRide->id = $id;
        $sheetRide = $this->SheetRide->find('first', array('conditions' => array('SheetRide.id' => $id)));
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->SheetRide->delete()) {
            $this->saveUserAction(SectionsEnum::feuille_de_route,
                $id, $this->Session->read('Auth.User.id'), ActionsEnum::delete);
            $this->updateCarKm($sheetRide['SheetRide']['car_id']);
            $this->updateCarMission($sheetRide['SheetRide']['car_id']);
            $this->updateCustomerMission($sheetRide['SheetRide']['customer_id']);
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }
    }

    function export()
    {
        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        $sheetRides = $this->SheetRide->find('all', array(
            'order' => 'SheetRide.name asc',
            'recursive' => 2
        ));
        $this->set('models', $sheetRides);
    }


    public function viewPdf($id = null)
    {
        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            $this->redirect('/');
        }

        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        if (!$this->SheetRide->exists($id)) {
            throw new NotFoundException(__('Invalid sheet ride'));
        }
        $options = array(
            'conditions' => array('SheetRide.' . $this->SheetRide->primaryKey => $id),
            'recursive' => -1,
            'fields' => array(
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'DetailRide.wording',
                'Ride.distance',
                'CarType.name',
                'SheetRide.reference',
                'SheetRide.id',
                'DetailRide.premium',
                'Carmodel.name',
                'Car.code',
                'SheetRide.status_id',
                'Customer.first_name',
                'Customer.last_name',
                'Customer.tel',
                'Supplier.name',
                'Supplier.adress',
                'Supplier.tel',
                'Car.immatr_def',
                'Mark.name',
            ),
            'joins' => array(
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
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('SheetRide.customer_id = Customer.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('DetailRide.car_type_id = CarType.id')
                ),


            )
        );

        $sheetRide = $this->SheetRide->find('first', $options);

        $this->set('sheetRide', $sheetRide);


        $rides = $this->SheetRideDetailRides->find('all', array(
            'order' => 'DetailRide.wording ASC',
            'recursive' => -1,
            'fields' => array(
                'ArrivalDestination.name',
                'DepartureDestination.name',
                'CarType.name',
                'DetailRide.duration_hour',
                'DetailRide.duration_day',
                'DetailRide.duration_minute',
                'DetailRide.id',
                'SheetRideDetailRides.real_start_date',
                'SheetRideDetailRides.real_end_date',

            ),
            'conditions' => array('SheetRideDetailRides.sheet_ride_id' => $id),
            'joins' => array(
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


            )
        ));

        $this->set('rides', $rides);
        $this->loadModel('Company');
        $company = $this->Company->find('first');
        $this->set('company', $company);


    }

    public function view_pdf($id = null)
    {

        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        if (!$this->SheetRide->exists($id)) {
            throw new NotFoundException(__('Invalid sheet ride'));
        }
        $options = array(
            'conditions' => array('SheetRide.' . $this->SheetRide->primaryKey => $id),
            'recursive' => -1,
            'fields' => array(

                'CarType.name',
                'SheetRide.reference',
                'SheetRide.id',
                'Carmodel.name',
                'Car.code',
                'SheetRide.status_id',
                'Customer.first_name',
                'Customer.last_name',
                'Customer.tel',
                'Car.immatr_def',
                'Mark.name',
            ),
            'joins' => array(
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
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('SheetRide.customer_id = Customer.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('SheetRide.car_type_id = CarType.id')
                ),


            )
        );

        $sheetRide = $this->SheetRide->find('first', $options);
        $data_to_encode = $sheetRide['SheetRide']['reference'];
        $barcode = new BarcodeHelper();
// Generate Barcode data
        $barcode->barcode();
        $barcode->setType('C39');
        $barcode->setCode($data_to_encode);
        $barcode->setSize(80, 200);

// Generate filename
        $data_to_encode = str_replace('/', '-', $data_to_encode);
        $this->set('data_to_encode', $data_to_encode);
        $file = 'img/barcode/' . $data_to_encode . '.png';

// Generates image file on server
        $barcode->writeBarcodeFile($file);

        $this->set('sheetRide', $sheetRide);


        $rides = $this->SheetRideDetailRides->find('all', array(
            'order' => 'DetailRide.wording ASC',
            'recursive' => -1,
            'fields' => array(
                'ArrivalDestination.name',
                'DepartureDestination.name',
                'CarType.name',
                'Arrival.name',
                'Departure.name',
                'SheetRideDetailRides.type_ride ',
                'SheetRideDetailRides.source ',
                'DetailRide.duration_hour',
                'DetailRide.duration_day',
                'DetailRide.duration_minute',
                'DetailRide.id',
                'SheetRideDetailRides.real_start_date',
                'SheetRideDetailRides.real_end_date'
            ),
            'conditions' => array('SheetRideDetailRides.sheet_ride_id' => $id),
            'joins' => array(
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
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('SheetRide.id = SheetRideDetailRides.sheet_ride_id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('SheetRide.car_type_id = CarType.id')
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
                )
            )
        ));
        $this->set('rides', $rides);
        $this->loadModel('Company');
        $company = $this->Company->find('first');
        $this->set('company', $company);
        $entete_pdf = $this->Parameter->getCodesParameterVal('entete_pdf');
        // get signature of mission order
        $signature_mission_order = $this->Parameter->getCodesParameterVal('signature_mission_order');

        $this->set('signature_mission_order', $signature_mission_order);
        $this->set('entete_pdf', $entete_pdf);

    }

    /** return customer affected to carId
     * @param null $carId
     */

    function getCustomersByCar($carId = null)
    {

        $this->setTimeActif();
        $this->layout = 'ajax';

        $current_date = date("Y-m-d H:i:s");
        if (isset($carId) && !empty($carId)) {
            $result = $this->CustomerCar->find('first', array(
                'conditions' => array(
                    'CustomerCar.car_id' => $carId,
                    'OR' => array(
                        array('CustomerCar.start <=' => $current_date, 'CustomerCar.end_real >' => $current_date),
                        array('CustomerCar.start <=' => $current_date, 'CustomerCar.end_real' => null),
                        array('CustomerCar.start' => null, 'CustomerCar.end_real' => null),
                        array('CustomerCar.start' => null, 'CustomerCar.end_real >' => $current_date),

                    )
                ),
                'fields' => array('Customer.id', 'Customer.first_name', 'Customer.last_name', 'Customer.company')
            ));
            if (!empty($result)) {
                $selected_id = $result['Customer']['id'];
                $fields = "names";
                $conditions = array('Customer.id' => $selected_id);
                $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions);
                $this->set(compact('selected_id', 'customers'));
            } else {
                $this->set('selected_id', 0);
                $this->set('customers', array());
            }
        } else {
            $this->set('selected_id', 0);
            $this->set('customers', array());
        }

    }



    /* public function verifyStatusCar( )
     {
         $this->setTimeActif();
         $this->autoRender = false;
         $car_id = filter_input(INPUT_POST, "car_id");

         $car_id=96;
         $real_start_date = filter_input(INPUT_POST, "real_start_date");
         $real_end_date = filter_input(INPUT_POST, "real_end_date");
         $real_start_date='25/09/2017 03:00';
         $real_end_date ='27/09/2017 08:00';



         $this->request->data['SheetRide']['real_start_date'] = $real_start_date;
         $this->createDatetimeFromDatetime('SheetRide', 'real_start_date');

         $this->request->data['SheetRide']['real_end_date'] = $real_end_date;
         $this->createDatetimeFromDatetime('SheetRide', 'real_end_date');


         $sheetRides = $this->SheetRide->find('all', array('recursive'=>-1,
             'fields'=>array('SheetRide.car_id','SheetRide.real_start_date', 'SheetRide.real_end_date' ),
             'conditions' => array('SheetRide.car_id' => $car_id,


                 'OR'=>array(
                     array( 'real_start_date <=' => $this->request->data['SheetRide']['real_start_date'],
                     'real_end_date >=' => $this->request->data['SheetRide']['real_start_date'],
                     'real_start_date <=' => $this->request->data['SheetRide']['real_end_date'] ,
                     'real_end_date >=' => $this->request->data['SheetRide']['real_end_date']),
                     array('real_start_date <=' => $this->request->data['SheetRide']['real_start_date'],
                          'real_end_date >=' => $this->request->data['SheetRide']['real_start_date'],
                         'real_end_date <=' => $this->request->data['SheetRide']['real_end_date']),
                     array('real_start_date >=' => $this->request->data['SheetRide']['real_start_date'],
                         'real_start_date <=' => $this->request->data['SheetRide']['real_end_date'],
                         'real_end_date >=' => $this->request->data['SheetRide']['real_end_date']),
                     array('real_start_date >=' => $this->request->data['SheetRide']['real_start_date'],
                         'real_end_date >=' => $this->request->data['SheetRide']['real_end_date'])

             ))));

         $sheetRides1 = $this->SheetRide->find('all', array('recursive'=>-1,'fields'=>array('SheetRide.car_id','SheetRide.real_start_date'),
             'conditions' => array('SheetRide.car_id' => $car_id,
                 'real_start_date <=' => $this->request->data['SheetRide']['real_start_date'],
                 'real_end_date >=' => $this->request->data['SheetRide']['real_start_date'],
                 'real_start_date <=' => $this->request->data['SheetRide']['real_end_date'] ,
                 'real_end_date >=' => $this->request->data['SheetRide']['real_end_date'])));

         echo '</br></br></br>';

         $sheetRides2 = $this->SheetRide->find('all', array('recursive'=>-1,'fields'=>array('SheetRide.car_id','SheetRide.real_start_date'),
             'conditions' => array('SheetRide.car_id' => $car_id,
                 'real_start_date <=' => $this->request->data['SheetRide']['real_start_date'],
                 'real_end_date >=' => $this->request->data['SheetRide']['real_start_date'],
                 'real_end_date <=' => $this->request->data['SheetRide']['real_end_date'])));

         echo '</br></br></br>';

         $sheetRides3 = $this->SheetRide->find('all', array('recursive'=>-1,'fields'=>array('SheetRide.car_id','SheetRide.real_start_date'),
             'conditions' => array('SheetRide.car_id' => $car_id,
                 'real_start_date >=' => $this->request->data['SheetRide']['real_start_date'],
                 'real_start_date <=' => $this->request->data['SheetRide']['real_end_date'],
                 'real_end_date >=' => $this->request->data['SheetRide']['real_end_date'])));

         echo '</br></br></br>';

        /* $sheetRides4 = $this->SheetRide->find('all', array('recursive'=>-1,'fields'=>array('SheetRide.car_id','SheetRide.real_start_date'),
             'conditions' => array('SheetRide.car_id' => $car_id,
                 'real_start_date >=' => $this->request->data['SheetRide']['real_start_date'],
                 'real_start_date <=' => $this->request->data['SheetRide']['real_start_date'],
                 'real_end_date >=' => $this->request->data['SheetRide']['real_end_date'],
                 'real_end_date >=' => $this->request->data['SheetRide']['real_end_date'])));


      $CarReserved1 = $this->SheetRide->find('all', array('recursive'=>-1,'fields'=>array('SheetRide.car_id','SheetRide.real_start_date'),'conditions' => array('SheetRide.car_id' => $car_id, array('OR' => array(
          'SheetRide.real_start_date <=' => $this->request->data['SheetRide']['real_start_date'],

      )), 'SheetRide.real_end_date IS NULL')));


      echo '</br></br></br>';

      die();
      if (empty($CarReserved1) && empty($customerCars1) ) {

          return true;
      } else {

          return false;
      }


      if(!empty($sheetRides)) {
          echo json_encode(array("response" => "false"));
      }else {
          echo json_encode(array("response" => "true"));


      }


     /* $sheetRide = $this->SheetRide->find('all', array('recursive'=>-1,'fields'=>array('SheetRide.car_id','SheetRide.real_start_date', 'SheetRide.real_end_date' ),'conditions' => array('SheetRide.car_id' => $car_id, 'real_start_date <=' => $this->request->data['SheetRide']['real_start_date'], 'OR'=>array('real_end_date >=' => $this->request->data['SheetRide']['real_start_date'], 'real_end_date ' =>null))));


          if (empty($sheetRide)) {


              echo json_encode(array("response" => "true"));
          } else {


              echo json_encode(array("response" => "false"));
          }*/


    //}

    function getRemorquesByCar($carId = null, $i = null, $mode = 0)
    {

        $this->setTimeActif();
        $this->layout = 'ajax';
        $this->set('i', $i);
        $this->set('mode', $mode);
        $param = $this->Parameter->getCodesParameterVal('name_car');

        if ($param == 1) {
            $this->SheetRide->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name, ' - ', IFNULL(Customer.first_name,''), ' ', IFNULL(Customer.last_name,''))"
            );

        } elseif ($param == 2) {

            $this->SheetRide->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(Car.immatr_def,Car.immatr_prov), ' - ', Carmodel.name, ' - ', IFNULL(Customer.first_name,''), ' ', IFNULL(Customer.last_name,''))"
            );
        }


        if (isset($carId) && !empty($carId)) {

            $result = $this->CustomerCar->find('first', array(
                'conditions' => array('CustomerCar.car_id' => $carId, 'CustomerCar.request' => 0),
                'fields' => array(
                    'Customer.id',
                    'Customer.first_name',
                    'Customer.last_name',
                    'Customer.company',
                    'CustomerCar.remorque_id'
                )
            ));

            if (!empty($result)) {
                $selected_id = $result['CustomerCar']['remorque_id'];

                $remorques = $this->SheetRide->Car->find('list', array(
                    'fields' => 'cnames',
                    'recursive' => -1,
                    'order' => array('Car.code asc', 'Carmodel.name asc'),
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
                    ),
                    'conditions' => array('Car.car_category_id' => 3, 'Car.id' => $selected_id),
                ));

                $this->set(compact('selected_id', 'remorques'));
            } else {
                $this->set('selected_id', 0);
                $this->set('remorques', array());
            }
        } else {
            $this->set('selected_id', 0);
            $this->set('remorques', array());
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

    public function view_mission($id = null)
    {
        $missionOrderModel = $this->Parameter->getCodesParameterVal('mission_order_model');
        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        if (!$this->SheetRide->exists($id)) {
            throw new NotFoundException(__('Invalid sheet ride'));
        }
       // $this->SheetRide->recursive = 2;
        $sheetRide = $this->SheetRide->find('first', array(
            'recursive'=>-1,
            'conditions'=>array('SheetRide.id'=>$id),
            'fields'=>array(
                'SheetRide.car_subcontracting',
                'SheetRide.reference',
                'SheetRide.created',
                'Customer.first_name',
                'Customer.last_name',
                'Customer.tel',
                'Car.immatr_def',
                'Remorque.immatr_def',
                'SheetRide.customer_name',
                'SheetRide.car_name',
                'CustomerCategory.name',
                'Destination.name',
                'TravelReason.name',
                'Carmodel.name',
                'RemorqueModel.name',
                'SheetRide.real_start_date',
                'SheetRide.real_end_date',
                'SheetRide.remorque_id',
            ),
            'joins' => array(
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
                    'alias' => 'RemorqueModel',
                    'conditions' => array('Remorque.carmodel_id = RemorqueModel.id')
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
                    'table' => 'travel_reasons',
                    'type' => 'left',
                    'alias' => 'TravelReason',
                    'conditions' => array('SheetRide.travel_reason_id = TravelReason.id')
                ),
                array(
                    'table' => 'customer_categories',
                    'type' => 'left',
                    'alias' => 'CustomerCategory',
                    'conditions' => array('Customer.customer_category_id = CustomerCategory.id')
                ),
            )
        ));
        $remorque = $this->SheetRide->Car->find('first',
            array('recursive' => 1, 'conditions' => array('Car.id' => $sheetRide['SheetRide']['remorque_id'])));

        $this->set('remorque', $remorque);
        $this->set('sheetRide', $sheetRide);
        $consumptions = $this->Consumption->find('all',array(
            'recursive'=>-1,
            'conditions'=>array('Consumption.sheet_ride_id'=>$id),
            'limit'=>3,
            'fields'=>array(
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
                'Coupon.serial_number'
            ),
            'joins'=>array(
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
                )
            )
        ));
        $company = $this->Company->find('first');
        $wilayaId = $company['Company']['wilaya'];
        $destination = $this->Destination->find('first', array('conditions' => array('Destination.id' => $wilayaId)));
        $wilayaName = $destination['Destination']['name'];
        $paramConsumption = $this->consumptionManagement();
        $this->set(compact('company', 'wilayaName','consumptions','paramConsumption'));
        // get method of header pdf
        $entete_pdf = $this->Parameter->getCodesParameterVal('entete_pdf');
        // get signature of mission order
        $signature_mission_order = $this->Parameter->getCodesParameterVal('signature_mission_order');
        $audits = $this->Audit->find('all',array(
            'recursive' => -1,
            'limit' => 5,
            'fields' => array(
                'User.id',
                'User.first_name',
                'User.last_name',
                'Action.name',
                'Audit.created'
            ),
            'joins' => array(
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'User',
                    'conditions' => array('Audit.user_id = User.id')
                ) ,
                array(
                    'table' => 'actions',
                    'type' => 'left',
                    'alias' => 'Action',
                    'conditions' => array('Audit.action_id = Action.id')
                )
            ),
            'conditions' => array('article_id' => $id, 'rubric_id' => SectionsEnum::feuille_de_route),
        ));
        $this->set('audits',$audits);
        $this->set('missionOrderModel', $missionOrderModel);
        $this->set('signature_mission_order', $signature_mission_order);
        $this->set('entete_pdf', $entete_pdf);
    }

    public function viewMissions(){
        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            $this->redirect('/');
        }
        ini_set('memory_limit', '512M');
        $ids = filter_input(INPUT_POST, "chkids");
        $array_ids = explode(",", $ids);
        $sheetRides = $this->SheetRide->find('all', array(
            'recursive'=>-1,
            'conditions'=>array('SheetRide.id'=>$array_ids),
            'fields'=>array(
                'SheetRide.car_subcontracting',
                'SheetRide.reference',
                'SheetRide.id',
                'SheetRide.created',
                'Customer.first_name',
                'Customer.last_name',
                'Customer.tel',
                'Car.immatr_def',
                'Remorque.immatr_def',
                'SheetRide.customer_name',
                'SheetRide.car_name',
                'CustomerCategory.name',
                'Destination.name',
                'TravelReason.name',
                'Carmodel.name',
                'RemorqueModel.name',
                'SheetRide.real_start_date',
                'SheetRide.real_end_date',
                'SheetRide.remorque_id',
            ),
            'joins' => array(
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
                    'alias' => 'RemorqueModel',
                    'conditions' => array('Remorque.carmodel_id = RemorqueModel.id')
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
                    'table' => 'travel_reasons',
                    'type' => 'left',
                    'alias' => 'TravelReason',
                    'conditions' => array('SheetRide.travel_reason_id = TravelReason.id')
                ),
                array(
                    'table' => 'customer_categories',
                    'type' => 'left',
                    'alias' => 'CustomerCategory',
                    'conditions' => array('Customer.customer_category_id = CustomerCategory.id')
                ),
            )
        ));
        $this->set('sheetRides',$sheetRides);
        $consumptionArray = array();
        foreach ($array_ids as $array_id){
            $consumptions = $this->Consumption->find('all',array(
                'recursive'=>-1,
                'conditions'=>array('Consumption.sheet_ride_id'=>$array_id),
                'limit'=>3,
                'fields'=>array(
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
                    'Coupon.serial_number'
                ),
                'joins'=>array(
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
                    )
                )
            ));
            $consumptionArray[$array_id] = $consumptions;

        }

        $auditArray = array();
        foreach ($array_ids as $id) {
            $audits = $this->Audit->find('all', array(
                'recursive' => -1,
                'limit' => 5,

                'fields' => array(
                    'User.id',
                    'User.first_name',
                    'User.last_name',
                    'Action.name',
                    'Audit.created'
                ),
                'joins' => array(
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('Audit.user_id = User.id')
                    ),
                    array(
                        'table' => 'actions',
                        'type' => 'left',
                        'alias' => 'Action',
                        'conditions' => array('Audit.action_id = Action.id')
                    )
                ),
                'conditions' => array('article_id' => $id, 'rubric_id' => SectionsEnum::feuille_de_route),
            ));

            $auditArray[$id] = $audits;
            $this->set('auditArray', $auditArray);
        }


        $company = $this->Company->find('first');
        $wilayaId = $company['Company']['wilaya'];
        $destination = $this->Destination->find('first', array('conditions' => array('Destination.id' => $wilayaId)));
        $wilayaName = $destination['Destination']['name'];
        $paramConsumption = $this->consumptionManagement();
        $this->set(compact('company', 'wilayaName','consumptions','paramConsumption','consumptionArray'));
        // get method of header pdf
        $entete_pdf = $this->Parameter->getCodesParameterVal('entete_pdf');
        // get signature of mission order
        $signature_mission_order = $this->Parameter->getCodesParameterVal('signature_mission_order');


        $this->set('signature_mission_order', $signature_mission_order);
        $this->set('entete_pdf', $entete_pdf);

    }


    function getRidesByType($i = null, $type = null, $detailRideId = null, $rideCategoryId = null)
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
        $this->set(compact('rideCategories', 'detailRides', 'i', 'useRideCategory', 'type'));
    }

    public function saveSheetRide()
    {

        $this->setTimeActif();
        $this->autoRender = false;
        $transport_bill_detail_ride_id = filter_input(INPUT_POST, "transport_bill_detail_ride_id");
        $car_id = filter_input(INPUT_POST, "car_id");
        $remorque_id = filter_input(INPUT_POST, "remorque_id");
        $customer_id = filter_input(INPUT_POST, "customer_id");
        $customer_help = filter_input(INPUT_POST, "customer_help");
        $planned_start_date = filter_input(INPUT_POST, "planned_start_date");
        $planned_end_date = filter_input(INPUT_POST, "planned_end_date");
        $real_start_date = filter_input(INPUT_POST, "real_start_date");
        $real_end_date = filter_input(INPUT_POST, "real_end_date");
        $km_departure = filter_input(INPUT_POST, "km_departure");
        $km_arrival_estimated = filter_input(INPUT_POST, "km_arrival_estimated");
        $km_arrival = filter_input(INPUT_POST, "km_arrival");
        $detail_ride_id = filter_input(INPUT_POST, "detail_ride_id");
        $supplier_id = filter_input(INPUT_POST, "supplier_id");
        $supplier_final_id = filter_input(INPUT_POST, "supplier_final_id");
        $car_type_id = filter_input(INPUT_POST, "car_type_id");
        $this->SheetRide->create();
        $this->request->data['SheetRide']['planned_start_date'] = $planned_start_date;
        $this->createDatetimeFromDatetime('SheetRide', 'planned_start_date');

        $this->request->data['SheetRide']['real_start_date'] = $real_start_date;
        $this->createDatetimeFromDatetime('SheetRide', 'real_start_date');

        $this->request->data['SheetRide']['planned_end_date'] = $planned_end_date;
        $this->createDatetimeFromDatetime('SheetRide', 'planned_end_date');

        $this->request->data['SheetRide']['real_end_date'] = $real_end_date;
        $this->createDatetimeFromDatetime('SheetRide', 'real_end_date');

        $reference = $this->getNextTransportReference(TransportBillTypesEnum::sheet_ride);
        $data = array();
        $data['SheetRide']['reference'] = $reference;
        $data['SheetRide']['car_type_id'] = $car_type_id;
        $data['SheetRide']['start_date'] = $this->request->data['SheetRide']['planned_start_date'];
        $data['SheetRide']['real_start_date'] = $this->request->data['SheetRide']['real_start_date'];
        $data['SheetRide']['end_date'] = $this->request->data['SheetRide']['planned_end_date'];
        $data['SheetRide']['real_end_date'] = $this->request->data['SheetRide']['real_end_date'];
        $data['SheetRide']['car_id'] = $car_id;
        $data['SheetRide']['remorque_id'] = $remorque_id;
        $data['SheetRide']['customer_id'] = $customer_id;
        $data['SheetRide']['customer_help'] = $customer_help;
        $data['SheetRide']['user_id'] = $this->Session->read('Auth.User.id');
        $start_date = $data['SheetRide']['real_start_date'];
        $end_date = $data['SheetRide']['real_end_date'];

        $data['SheetRide']['status_id'] = $this->updateStatusSheet($start_date, $end_date, 1);

        if ($this->SheetRide->save($data)) {

            $sheet_ride_id = $this->SheetRide->getInsertID();
            $this->SheetRideDetailRides->create();
            $data['SheetRideDetailRides']['sheet_ride_id'] = $sheet_ride_id;
            $data['SheetRideDetailRides']['detail_ride_id'] = $detail_ride_id;
            $data['SheetRideDetailRides']['supplier_id'] = $supplier_id;
            $data['SheetRideDetailRides']['supplier_final_id'] = $supplier_final_id;
            $data['SheetRideDetailRides']['planned_start_date'] = $this->request->data['SheetRide']['planned_start_date'];
            $data['SheetRideDetailRides']['real_start_date'] = $this->request->data['SheetRide']['real_start_date'];
            $data['SheetRideDetailRides']['planned_end_date'] = $this->request->data['SheetRide']['planned_end_date'];
            $data['SheetRideDetailRides']['real_end_date'] = $this->request->data['SheetRide']['real_end_date'];
            $data['SheetRideDetailRides']['km_departure'] = $km_departure;
            $data['SheetRideDetailRides']['km_arrival_estimated'] = $km_arrival_estimated;
            $data['SheetRideDetailRides']['km_arrival'] = $km_arrival;
            $data['SheetRideDetailRides']['transport_bill_detail_ride_id'] = $transport_bill_detail_ride_id;
            $data['SheetRideDetailRides']['user_id'] = $this->Session->read('Auth.User.id');
            $start_date = $data['SheetRide']['real_start_date'];
            $end_date = $data['SheetRide']['real_end_date'];

            $data['SheetRideDetailRides']['status_id'] = $this->updateStatusSheet($start_date, $end_date, 0);
            if ($this->SheetRideDetailRides->save($data)) {
                $sheet_ride_detail_ride_id = $this->SheetRideDetailRides->getInsertID();

                $this->TransportBillDetailRides->updateStatusTransportBillDetailRide($transport_bill_detail_ride_id);

                //$this->updateCarMission($car_id);
                echo json_encode(array(
                    "response" => "true",
                    'sheet_ride_id' => $sheet_ride_id,
                    'sheet_ride_detail_ride_id' => $sheet_ride_detail_ride_id
                ));


            } else {

                echo json_encode(array("response" => "false"));

            }


        } else {

            echo json_encode(array("response" => "false"));
        };


    }

    public function getRidesFromCustomerOrder(
        $i = null,
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
        $this->set('i', $i);


    }

    public function getPersonalizedRidesFromCustomerOrder($i = null, $type = '0', $transportBillDetailRideId = null, $statusMission = null
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
                //var_dump($transportBillDetailRideId); die();
                $transportBillDetailRide = $this->TransportBillDetailRides->getTransportBillDetailRidesById($transportBillDetailRideId);
                $departures = $this->Destination->getDestinationsByConditions(
                    array('Destination.id' =>
                        $transportBillDetailRide['TransportBillDetailRides']['departure_destination_id']), 'list');
                $arrivals = $this->Destination->getDestinationsByConditions(
                    array('Destination.id' => $transportBillDetailRide['TransportBillDetailRides']['arrival_destination_id']), 'list');
            }
            $this->set(compact('transportBillDetailRide','departures', 'arrivals','detailRides'));
        }

        $this->set('i', $i);

    }

// get rides of conductors  by date

    public function getClientInitialFromCustomerOrder($rideId = null, $i = null)
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
        $this->set('i', $i);
    }


// get rides of conductors by km 

    public function getClientFinalFromCustomerOrder($rideId = null, $i = null)
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
        $this->set('i', $i);
    }

    public function addDepartRide($i = null)
    {

        if(Configure::read("transport_personnel") == '1'){
            $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validateWithoutCommercial;
        }else {
            if (Configure::read("gestion_commercial") == '1' ) {
                $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validate;
            }else {
                $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validatePersonalizedRide;
            }
        }


        $this->set('i', $i);
        // Get reference mission automatic parameter reference_mi_auto
        $referenceMission = $this->Parameter->getCodesParameterVal('reference_mi_auto');
        $displayMissionCost = $this->isDisplayMissionCost();
        $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
        $this->set(compact('referenceMission', 'displayMissionCost', 'paramPriceNight'));
    }

    public function addArriveRide($i = null)
    {
        $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
        $this->set(compact('i', 'usePurchaseBill'));
    }

    public function getClientInitial($i = null)
    {
        if (Configure::read("gestion_commercial") == '1') {
            $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validate;
        }else {
            $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validatePersonalizedRide;
        }

        $this->set('i', $i);
    }

    public function getClientFinal($i = null)
    {
        $this->set('i', $i);
    }

    public function getDistanceReturnToParc($detail_ride = null, $from_customer_order = 0,
                                            $arrivalDestinationId = 0, $carTypeId=0)
    {
        if ($detail_ride > 0) {
            $departure_destination_id = null;
            $car_type_id = null;
            $wilaya_id = null;
            if ($from_customer_order == 1) {
                $detailRide = $this->TransportBillDetailRides->find('first', array(
                    'conditions' => array('TransportBillDetailRides.id' => $detail_ride),
                    'fields' => array('TransportBillDetailRides.detail_ride_id',
                        'TransportBillDetailRides.type_ride',
                        'TransportBillDetailRides.departure_destination_id',
                        'TransportBillDetailRides.arrival_destination_id',
                        'TransportBillDetailRides.car_type_id',

                    )
                ));

                if ($detailRide['TransportBillDetailRides']['type_ride'] == 1) {

                    $detail_ride = $detailRide['TransportBillDetailRides']['detail_ride_id'];
                    $detailRides = $this->SheetRideDetailRides->DetailRide->find('first', array(
                        'recursive' => -1,
                        'fields' => array(
                            'ArrivalDestination.id',
                            'ArrivalDestination.name',
                            'ArrivalDestination.latlng',
                            'CarType.id'
                        ),
                        'conditions' => array('DetailRide.id' => $detail_ride),
                        'joins' => array(
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
                            )
                        )
                    ));
                    if (!empty($detailRides)) {
                        $departure_destination_id = $detailRides['ArrivalDestination']['id'];
                        $car_type_id = $detailRides['CarType']['id'];
                    }

                } else {
                    $departure_destination_id = $detailRide['TransportBillDetailRides']['arrival_destination_id'];
                    $car_type_id = $detailRide['TransportBillDetailRides']['car_type_id'];
                }

            } else {
                $detailRides = $this->SheetRideDetailRides->DetailRide->find('first', array(
                    'recursive' => -1,
                    'fields' => array(
                        'ArrivalDestination.id',
                        'ArrivalDestination.name',
                        'ArrivalDestination.latlng',
                        'CarType.id'
                    ),
                    'conditions' => array('DetailRide.id' => $detail_ride),
                    'joins' => array(
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
                        )
                    )
                ));
                if (!empty($detailRides)) {
                    $departure_destination_id = $detailRides['ArrivalDestination']['id'];
                    $car_type_id = $detailRides['CarType']['id'];
                }
            }
            $company = $this->Company->find('first');
            $wilaya_id = $company['Company']['wilaya'];
            $wilayaLatlng = $company['Company']['latlng'];
            $detail_ride_retour = array();
            if (!empty($departure_destination_id) && !empty($wilaya_id) && !empty($car_type_id)) {
                $detail_ride_retour = $this->SheetRideDetailRides->DetailRide->find('first', array(
                    'conditions' => array(
                        'OR' => array(
                            array(
                                'Ride.departure_destination_id' => $departure_destination_id,
                                'Ride.arrival_destination_id' => $wilaya_id,
                                'DetailRide.car_type_id' => $car_type_id
                            ),
                            array(
                                'Ride.arrival_destination_id' => $departure_destination_id,
                                'Ride.departure_destination_id' => $wilaya_id,
                                'DetailRide.car_type_id' => $car_type_id
                            )
                        )
                    ),
                    'recursive' => -1,
                    'fields' => array(
                        'Ride.distance',
                    ),
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
            $wilayaName = '';
            if (empty($detail_ride_retour)) {
                if (!empty($departure_destination_id)) {
                    $departure_destination = $this->Destination->find('first', array(
                        'conditions' => array('Destination.id' => $departure_destination_id),
                        'recursive' => -1,
                        'fields' => array('name', 'latlng')
                    ));
                    $departure_destination_name = $departure_destination['Destination']['name'];
                    $departureDestinationLatlng = $departure_destination['Destination']['latlng'];
                } else {
                    $departure_destination_name = '';
                    $departureDestinationLatlng = '';
                }
                if (!empty($wilaya_id)) {
                    $this->loadModel('Destination');
                    $wilaya = $this->Destination->find('first', array(
                        'conditions' => array('Destination.id' => $wilaya_id),
                        'recursive' => -1,
                        'fields' => array('name', 'latlng')
                    ));
                    $wilayaName = $wilaya['Destination']['name'];
                    $wilayaLatlng = $wilaya['Destination']['latlng'];
                }
            } else {
                $departure_destination_name = '';
                $wilayaName = '';
                $departureDestinationLatlng = '';
                $wilayaLatlng = '';
            }

        } else {
            if ($from_customer_order == 3) {
                $company = $this->Company->find('first');
                $wilaya_id = $company['Company']['wilaya'];
                $wilayaLatlng = $company['Company']['latlng'];
                $this->loadModel('Destination');
                $wilaya = $this->Destination->find('first', array(
                    'conditions' => array('Destination.id' => $wilaya_id),
                    'recursive' => -1,
                    'fields' => array('name', 'latlng')
                ));
                $wilayaName = $wilaya['Destination']['name'];
                if (empty($wilayaLatlng)) {
                    $wilayaLatlng = $wilaya['Destination']['latlng'];
                }
                if ($arrivalDestinationId > 0) {
                    $conds = array('Destination.id' => $arrivalDestinationId);
                    $departureDestination = $this->Destination->getDestinationsByConditions($conds, 'first');
                    $departure_destination_name = $departureDestination['Destination']['name'];
                    $departureDestinationLatlng = $departureDestination['Destination']['latlng'];
                } else {
                    $departure_destination_name = '';
                    $departureDestinationLatlng = '';
                }

            } else {
                $company = $this->Company->find('first');
                $wilaya_id = $company['Company']['wilaya'];
                $wilayaLatlng = $company['Company']['latlng'];
                $detail_ride_retour = array();
                if (!empty($arrivalDestinationId) && !empty($wilaya_id) && !empty($carTypeId)) {
                    $detail_ride_retour = $this->SheetRideDetailRides->DetailRide->find('first', array(
                        'conditions' => array(
                            'OR' => array(
                                array(
                                    'Ride.departure_destination_id' => $arrivalDestinationId,
                                    'Ride.arrival_destination_id' => $wilaya_id,
                                    'DetailRide.car_type_id' => $carTypeId
                                ),
                                array(
                                    'Ride.arrival_destination_id' => $arrivalDestinationId,
                                    'Ride.departure_destination_id' => $wilaya_id,
                                    'DetailRide.car_type_id' => $carTypeId
                                )
                            )
                        ),
                        'recursive' => -1,
                        'fields' => array(
                            'Ride.distance',
                        ),
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
                $wilayaName = '';
                if (empty($detail_ride_retour)) {
                    if (!empty($arrivalDestinationId)) {
                        $departure_destination = $this->Destination->find('first', array(
                            'conditions' => array('Destination.id' => $arrivalDestinationId),
                            'recursive' => -1,
                            'fields' => array('name', 'latlng')
                        ));
                        if(!empty($departure_destination)){

                            $departure_destination_name = $departure_destination['Destination']['name'];
                            $departureDestinationLatlng = $departure_destination['Destination']['latlng'];
                        }else {
                            $departure_destination_name = '';
                            $departureDestinationLatlng = '';
                        }
                    } else {
                        $departure_destination_name = '';
                        $departureDestinationLatlng = '';
                    }
                    if (!empty($wilaya_id)) {
                        $this->loadModel('Destination');
                        $wilaya = $this->Destination->find('first', array(
                            'conditions' => array('Destination.id' => $wilaya_id),
                            'recursive' => -1,
                            'fields' => array('name', 'latlng')
                        ));
                        $wilayaName = $wilaya['Destination']['name'];
                        $wilayaLatlng = $wilaya['Destination']['latlng'];
                    }
                } else {
                    $departure_destination_name = '';
                    $wilayaName = '';
                    $departureDestinationLatlng = '';
                    $wilayaLatlng = '';
                }
            }

        }
        $this->set(compact('departure_destination_name', 'wilayaName', 'departureDestinationLatlng', 'wilayaLatlng', 'detail_ride_retour'));


    }

    public function getDurationReturnToParc($detail_ride = null, $from_customer_order = 0, $arrivalDestinationId = 0)
    {
        $departure_destination_id = null;
        $car_type_id = null;
        $wilaya_id = null;
        if ($detail_ride > 0) {
            if ($from_customer_order == 1) {
                $detailRide = $this->TransportBillDetailRides->find('first', array(
                    'conditions' => array('TransportBillDetailRides.id' => $detail_ride),
                    'fields' => array('TransportBillDetailRides.detail_ride_id',
                        'TransportBillDetailRides.type_ride',
                        'TransportBillDetailRides.departure_destination_id',
                        'TransportBillDetailRides.arrival_destination_id',
                        'TransportBillDetailRides.car_type_id',

                    )
                ));

                if ($detailRide['TransportBillDetailRides']['type_ride'] == 1) {

                    $detail_ride = $detailRide['TransportBillDetailRides']['detail_ride_id'];
                    $detailRides = $this->SheetRideDetailRides->DetailRide->find('first', array(
                        'recursive' => -1,
                        'fields' => array(
                            'ArrivalDestination.id',
                            'ArrivalDestination.name',
                            'ArrivalDestination.latlng',
                            'CarType.id'
                        ),
                        'conditions' => array('DetailRide.id' => $detail_ride),
                        'joins' => array(
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
                            )
                        )
                    ));
                    if (!empty($detailRides)) {
                        $departure_destination_id = $detailRides['ArrivalDestination']['id'];
                        $car_type_id = $detailRides['CarType']['id'];
                    }

                } else {
                    $departure_destination_id = $detailRide['TransportBillDetailRides']['arrival_destination_id'];
                    $car_type_id = $detailRide['TransportBillDetailRides']['car_type_id'];
                }

            } else {
                $detailRides = $this->SheetRideDetailRides->DetailRide->find('first', array(
                    'recursive' => -1,
                    'fields' => array(
                        'ArrivalDestination.id',
                        'ArrivalDestination.name',
                        'ArrivalDestination.latlng',
                        'CarType.id'
                    ),
                    'conditions' => array('DetailRide.id' => $detail_ride),
                    'joins' => array(
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
                        )
                    )
                ));
                if (!empty($detailRides)) {
                    $departure_destination_id = $detailRides['ArrivalDestination']['id'];
                    $car_type_id = $detailRides['CarType']['id'];
                }
            }
            $company = $this->Company->find('first');
            $wilaya_id = $company['Company']['wilaya'];
            $wilayaLatlng = $company['Company']['latlng'];
            $detail_ride_retour = array();
            if (!empty($departure_destination_id) && !empty($wilaya_id) && !empty($car_type_id)) {
                $detail_ride_retour = $this->SheetRideDetailRides->DetailRide->find('first', array(
                    'conditions' => array(
                        'OR' => array(
                            array(
                                'Ride.departure_destination_id' => $departure_destination_id,
                                'Ride.arrival_destination_id' => $wilaya_id,
                                'DetailRide.car_type_id' => $car_type_id
                            ),
                            array(
                                'Ride.arrival_destination_id' => $departure_destination_id,
                                'Ride.departure_destination_id' => $wilaya_id,
                                'DetailRide.car_type_id' => $car_type_id
                            )
                        )
                    ),
                    'recursive' => -1,
                    'fields' => array(
                        'DetailRide.duration_hour',
                        'DetailRide.duration_day',
                        'DetailRide.duration_minute'
                    ),
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
            $wilayaName = '';
            if (empty($detail_ride_retour)) {
                if (!empty($departure_destination_id)) {
                    $departure_destination = $this->Destination->find('first', array(
                        'conditions' => array('Destination.id' => $departure_destination_id),
                        'recursive' => -1,
                        'fields' => array('name', 'latlng')
                    ));
                    $departure_destination_name = $departure_destination['Destination']['name'];
                    $departureDestinationLatlng = $departure_destination['Destination']['latlng'];
                } else {
                    $departure_destination_name = '';
                    $departureDestinationLatlng = '';
                }
                if (!empty($wilaya_id)) {
                    $this->loadModel('Destination');
                    $wilaya = $this->Destination->find('first', array(
                        'conditions' => array('Destination.id' => $wilaya_id),
                        'recursive' => -1,
                        'fields' => array('name', 'latlng')
                    ));
                    $wilayaName = $wilaya['Destination']['name'];
                    $wilayaLatlng = $wilaya['Destination']['latlng'];
                }
            } else {
                $departure_destination_name = '';
                $wilayaName = '';
                $departureDestinationLatlng = '';
                $wilayaLatlng = '';
            }

        } else {
            if ($from_customer_order == 3) {
                $company = $this->Company->find('first');
                $wilaya_id = $company['Company']['wilaya'];
                $wilayaLatlng = $company['Company']['latlng'];
                $this->loadModel('Destination');
                $wilaya = $this->Destination->find('first', array(
                    'conditions' => array('Destination.id' => $wilaya_id),
                    'recursive' => -1,
                    'fields' => array('name', 'latlng')
                ));
                $wilayaName = $wilaya['Destination']['name'];
                if (empty($wilayaLatlng)) {
                    $wilayaLatlng = $wilaya['Destination']['latlng'];
                }
                if ($arrivalDestinationId > 0) {
                    $conds = array('Destination.id' => $arrivalDestinationId);
                    $departureDestination = $this->Destination->getDestinationsByConditions($conds, 'first');
                    $departure_destination_name = $departureDestination['Destination']['name'];
                    $departureDestinationLatlng = $departureDestination['Destination']['latlng'];
                } else {
                    $departure_destination_name = '';
                    $departureDestinationLatlng = '';
                }

            } else {
                $departure_destination_name = '';
                $wilayaName = '';
                $departureDestinationLatlng = '';
                $wilayaLatlng = '';
                $detail_ride_retour = '';
            }

        }
        $this->set(compact('departure_destination_name', 'wilayaName', 'departureDestinationLatlng', 'wilayaLatlng', 'detail_ride_retour'));


    }

    public function conductorsRidesByDate()
    {
        if ($this->request->is('post')) {


            if (
                isset($this->request->data['SheetRides']['car_id']) ||
                isset($this->request->data['SheetRides']['customer_id']) ||
                isset($this->request->data['SheetRides']['date_from']) ||
                isset($this->request->data['SheetRides']['date_to'])
            ) {

                $car = $this->request->data['SheetRides']['car_id'];
                $customer = $this->request->data['SheetRides']['customer_id'];
                $date_from = str_replace("/", "-", $this->request->data['SheetRides']['date_from']);
                $date_to = str_replace("/", "-", $this->request->data['SheetRides']['date_to']);
                $start = str_replace("-", "/", $date_from);
                $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                $end = str_replace("-", "/", $date_to);
                $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            }

            $conditions = array();
            if (!empty($car)) {
                $conditions["SheetRide.car_id"] = $car;

            }
            if (!empty($customer)) {
                $conditions["SheetRide.customer_id"] = $customer;

            }
            if (!empty($date_from)) {

                $conditions["SheetRideDetailRides.real_start_date >="] = $startdtm->format('Y-m-d 00:00:00');
            }

            if (!empty($date_to)) {

                $conditions["SheetRideDetailRides.real_end_date <="] = $enddtm->format('Y-m-d 00:00:00');
            }
            $conditions['SheetRideDetailRides.real_start_date !='] = null;
            $conditions['SheetRideDetailRides.real_end_date != '] = null;


            $ridesSheetRides = $this->SheetRideDetailRides->find('all', array(
                'order' => 'SheetRideDetailRides.id ASC',
                'recursive' => -1,
                'fields' => array(

                    'SheetRideDetailRides.detail_ride_id',
                    'SheetRideDetailRides.real_start_date',
                    'SheetRideDetailRides.real_end_date',
                    'DepartureDestination.name',
                    'ArrivalDestination.name',
                    'CarType.name',
                    'Customer.first_name',
                    'Customer.last_name',
                    'Car.code',
                    'Car.immatr_def',
                    'Carmodel.name',
                ),
                'conditions' => $conditions,
                'joins' => array(

                    array(
                        'table' => 'sheet_rides',
                        'type' => 'left',
                        'alias' => 'SheetRide',
                        'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                    ),
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('SheetRide.customer_id = Customer.id')
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
                    )

                )
            ));


        } else {


            $ridesSheetRides = $this->SheetRideDetailRides->find('all', array(
                'order' => 'SheetRideDetailRides.id ASC',
                'recursive' => -1,
                'fields' => array(

                    'SheetRideDetailRides.detail_ride_id',
                    'SheetRideDetailRides.real_start_date',
                    'SheetRideDetailRides.real_end_date',
                    'DepartureDestination.name',
                    'ArrivalDestination.name',
                    'CarType.name',
                    'Customer.first_name',
                    'Customer.last_name',
                    'Car.code',
                    'Car.immatr_def',
                    'Carmodel.name',
                ),
                'conditions' => array(
                    'SheetRideDetailRides.real_start_date != ' => null,
                    'SheetRideDetailRides.real_end_date != ' => null,
                    'Customer.id != ' => null,
                    'SheetRideDetailRides.real_start_date >=' => date('Y-m-00'),
                    'SheetRideDetailRides.real_end_date <=' => date('Y-m-31')
                ),
                'joins' => array(

                    array(
                        'table' => 'sheet_rides',
                        'type' => 'left',
                        'alias' => 'SheetRide',
                        'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                    ),
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('SheetRide.customer_id = Customer.id')
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
                    )

                )
            ));


        }
        $param = $this->Parameter->getCodesParameterVal('name_car');

        if (!empty($ridesSheetRides)) {
            $i = 0;
            foreach ($ridesSheetRides as $ridesSheetRide) {


                $customer = $ridesSheetRide['Customer']['first_name'] . ' ' . $ridesSheetRide['Customer']['last_name'];


                if ($param == 1) {
                    $car = $ridesSheetRide['Car']['code'] . ' ' . $ridesSheetRide['Carmodel']['name'];
                } elseif ($param == 2) {

                    $car = $ridesSheetRide['Car']['immatr_def'] . ' ' . $ridesSheetRide['Carmodel']['name'];
                }

                $dateStart = $ridesSheetRide['SheetRideDetailRides']['real_start_date'];
                $dateEnd = $ridesSheetRide['SheetRideDetailRides']['real_end_date'];
                $s_arr = preg_split(" /\-|\s|:/", $ridesSheetRide['SheetRideDetailRides']['real_start_date']);


                $e_arr = preg_split("/\-|\s|:/", $ridesSheetRide['SheetRideDetailRides']['real_end_date']);
                $date_end = Date($e_arr[0] + "," + $e_arr[1] + "," + $e_arr[2] + "," + $e_arr[3] + ":" + $e_arr[4] + ":00");
                $rideName = $ridesSheetRide['DepartureDestination']['name'] . '-' . $ridesSheetRide['ArrivalDestination']['name'];

                $rides[$i][0] = $car . '-' . $customer;
                $rides[$i][1] = $rideName;
                $rides[$i][2] = $s_arr[0];
                $rides[$i][3] = $s_arr[1];
                $rides[$i][4] = $s_arr[2];
                $rides[$i][5] = $s_arr[3];
                $rides[$i][6] = $s_arr[4];

                $rides[$i][7] = $e_arr[0];
                $rides[$i][8] = $e_arr[1];
                $rides[$i][9] = $e_arr[2];
                $rides[$i][10] = $e_arr[3];
                $rides[$i][11] = $e_arr[4];


                $i++;
            }
        }


        if ($param == 1) {
            $this->SheetRide->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->SheetRide->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(Car.immatr_def,Car.immatr_prov), ' - ',Carmodel.name )"
            );
        }


        $cars = $this->SheetRide->Car->find('list', array(
            'fields' => 'cnames',
            'conditions' => array('Car.car_category_id !=' => 3),
            'recursive' => 1,
            'order' => 'Carmodel.name asc'
        ));

        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);

        $this->set(compact('rides', 'cars', 'customers'));
    }


    /*
     * get list of coupons: coupons not selected
     * param  $ids : id coupon
     * return array coupons
     */

    public function conductorsRidesByKm()
    {

        $ridesSheetRides = $this->SheetRideDetailRides->find('all', array(
            'order' => 'SheetRideDetailRides.id ASC',
            'recursive' => -1,
            'fields' => array(
                'SheetRideDetailRides.detail_ride_id',
                'SheetRideDetailRides.km_departure',
                'SheetRideDetailRides.km_arrival',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'CarType.name',
                'Customer.first_name',
                'Customer.last_name',
            ),
            'conditions' => array(
                'SheetRideDetailRides.km_departure != ' => null,
                'SheetRideDetailRides.km_arrival != ' => null,
                'Customer.id != ' => null
            ),
            'joins' => array(

                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('SheetRide.customer_id = Customer.id')
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
                )

            )
        ));

        $i = 0;
        $rides = array();
        foreach ($ridesSheetRides as $ridesSheetRide) {


            $customer = $ridesSheetRide['Customer']['first_name'] . ' ' . $ridesSheetRide['Customer']['last_name'];
            $kmDeparture = $ridesSheetRide['SheetRideDetailRides']['km_departure'];
            $kmArrival = $ridesSheetRide['SheetRideDetailRides']['km_arrival'];
            $diffKm = $kmArrival - $kmDeparture;
            $rides[$i][0] = $customer;
            $rides[$i][1] = $diffKm;

            $i++;
        }

        $this->set('rides', $rides);
    }

    public function getKmAndTank($carId = null)
    {
        // Get car's tank state on new mission's start
        $tankStateMethod = $this->Parameter->getCodesParameterVal('departure_tank_state');
        if (!empty($carId)) {
            $car = $this->SheetRide->Car->find('first', array(
                'conditions' => array('Car.id' => $carId),
                'recursive' => -1,
                'fields' => array('id', 'km_initial', 'code', 'km', 'reservoir_state', 'reservoir '),
            ));

            $km = $car['Car']['km'];

            if ($tankStateMethod == 2) {
                $reservoir = $car['Car']['reservoir_state'];
            } else {
                $reservoir = $car['Car']['reservoir'];
            }
        } else {
            $reservoir = '';
            $km = '';
        }
        $this->set('reservoir', $reservoir);

        $this->set('km', $km);

        $this->set('tankStateMethod', $tankStateMethod);

    }

    function getCoupons($i = null, $sheetRideId = null)
    {
        // Get method of reading coupons from parameters
        $this->set('i', $i);
        $param_coupon = $this->Parameter->getCodesParameterVal('param_coupon');
        if ($param_coupon == 1) {
            $this->layout = 'ajax';
            $this->loadModel('Coupon');

            if ($sheetRideId == null) {
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
                    'fields' => array('id', 'serial_number'),
                    'order' => array('FuelLog.date' => 'ASC', 'Coupon.serial_number ASC' => 'ASC')
                ));

            } else {
                $coupons = $this->Coupon->find('list', array(

                    'joins' => array(
                        array(
                            'table' => 'fuel_logs',
                            'type' => 'left',
                            'alias' => 'FuelLog',
                            'conditions' => array('Coupon.fuel_log_id = FuelLog.id')
                        )
                    ),
                    'conditions' => array(
                        'OR' => array(
                            array('Coupon.used' => 0),
                            array('Coupon.sheet_ride_id' => $sheetRideId)
                        )
                    ),
                    'fields' => array('id', 'serial_number'),
                    'order' => array('FuelLog.date' => 'ASC', 'Coupon.serial_number ASC' => 'ASC')
                ));
            }
            $this->set('selectbox', $coupons);
        }

        $this->set('param_coupon', $param_coupon);
    }

    function getReturnedCoupons($coupons_id = null)
    {


        if (!isset($coupons_id) || empty($coupons_id)) {
            $coupons_id = 0;
        }
        $this->layout = 'ajax';
        $this->loadModel('Coupon');
        $coupons_id = explode(",", $coupons_id);
        $coupons_returned = $this->Coupon->find('list', array(
            'joins' => array(
                array(
                    'table' => 'fuel_logs',
                    'type' => 'left',
                    'alias' => 'FuelLog',
                    'conditions' => array('Coupon.fuel_log_id = FuelLog.id')
                )
            ),
            'conditions' => array('Coupon.id' => $coupons_id),
            'fields' => array('id', 'serial_number'),
            'order' => array('FuelLog.date' => 'ASC', 'Coupon.serial_number ASC' => 'ASC')
        ));

        $this->set('selectbox', $coupons_returned);
        // Get method of reading coupons from parameters
        $param_coupon = $this->Parameter->getCodesParameterVal('param_coupon');
        $this->set('param_coupon', $param_coupon);
    }

    function getConsumptions($carId = null)
    {
        $this->layout = 'ajax';
        $this->loadModel('Fuel');
        if (!empty($carId)) {
            $result = $this->Car->find('first', array('conditions' => array('Car.id' => $carId)));
            if(!empty($result['Fuel']['code'])){
                $consumptionPrice = 'consumption_' . $result['Fuel']['code'];
                $consumptionModel = $result['Carmodel'][$consumptionPrice];
            }else {
                $consumptionPrice ='';
                $consumptionModel = '';
            }
            $minConsumption = $result['Car']['min_consumption'];
            $maxConsumption = $result['Car']['max_consumption'];
            $reservoir = $result['Car']['reservoir'];
            $minConsumptionGpl = $result['Car']['min_consumption_gpl'];
            $maxConsumptionGpl = $result['Car']['max_consumption_gpl'];
            $reservoirGpl = $result['Car']['reservoir_gpl'];
            $fuelGpl = $result['Car']['fuel_gpl'];
            $averageSpeed = $result['Car']['average_speed'];
            $chargeUtile = $result['Car']['charge_utile'];
            $volumePalette = $result['Car']['volume_palette'];
            $nbPalette = $result['Car']['nb_palette'];
            $balance = $result['Car']['balance'];
            $carContractor = $result['Car']['car_parc'];
            if (empty($averageSpeed)) {
                $carType = $this->CarType->getCarTypeById($result['Car']['car_type_id']);
                if (!empty($carType)) {
                    $averageSpeed = $carType['CarType']['average_speed'];
                } else {
                    $averageSpeed = '';
                }
            }

            if ($fuelGpl) {
                $consumptionModelGpl = $result['Carmodel']['consumption_05'];
                $fuel = $this->Fuel->getFuelByCode('05');
                $priceGpl = $fuel['Fuel']['price'];
                $this->set(compact('consumptionModelGpl', 'priceGpl'));
            }
            $fuelPrice = $result['Fuel']['price'];

            switch ($result['Fuel']['name']) {
                case 'Gazoil' :
                    $fuelName = 1;
                    break;
                case  'Sans plomb':
                    $fuelName = 2;
                    break;
                case 'Super' :
                    $fuelName = 3;
                    break;
                default:
                    $fuelName = '';
            }
        } else {
            $fuelName = '';
            $minConsumption = '';
            $maxConsumption = '';
            $minConsumptionGpl = '';
            $maxConsumptionGpl = '';
            $reservoir = '';
            $reservoirGpl = '';
            $fuelPrice = '';
            $consumptionPrice = '';
            $consumptionModel = '';
            $fuelGpl = '';
            $averageSpeed = '';
            $chargeUtile = '';
            $volumePalette = '';
            $nbPalette = '';
            $balance = '';
            $carContractor = '';


        }

        $balanceCar = $this->isBalanceCarUsed();
        $this->set(compact('fuelName', 'minConsumption', 'maxConsumption', 'minConsumptionGpl', 'maxConsumptionGpl',
            'balanceCar', 'balance', 'nbPalette', 'carContractor',
            'reservoir', 'reservoirGpl', 'fuelPrice', 'consumptionPrice', 'consumptionModel', 'fuelGpl', 'averageSpeed',
            'chargeUtile', 'volumePalette'));
    }

    function verifyMissionCar($carId = null)
    {
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $car = $this->Car->getCarsByFieldsAndConds($param, array('Car.id', 'Car.in_mission'), array('Car.id' => $carId), 'first');
        $this->set('car', $car);
    }

    function verifyMissionCustomer($customerId = null)
    {
        $customer = $this->Customer->getCustomersByFieldsAndConds(array('Customer.id', 'Customer.in_mission'), array('Customer.id' => $customerId), 'first');
        $this->set('customer', $customer);
    }

    function getPossibleAlertsDuringSheetRide($carId = null, $distance = null, $duration = null)
    {
        $eventTypes = $this->EventType->getEventTypes(
            'all',
            null,
            array('EventType.id', 'EventType.with_km', 'EventType.with_date'),
            array('EventType.maintenance_activate' => 1)
        );

        $allEvents = array();

        foreach ($eventTypes as $eventType) {
            $eventTypeId = $eventType['EventType']['id'];
            $eventTypeWithDate = $eventType['EventType']['with_date'];
            $eventTypeWithKm = $eventType['EventType']['with_km'];

            if ($eventTypeWithDate == 1) {
                $events = $this->getDateAlerts($carId, $eventTypeId, $duration);
                $allEvents[] = $events;
            }
            if ($eventTypeWithKm == 1) {
                $events = $this->getKmAlerts($carId, $eventTypeId, $distance);
                $allEvents[] = $events;
            }
        }
        $this->set('events', $allEvents);
    }

    /*
     * verify if number of coupon inserted by user is <=  number of coupons exist
     */

    function getDateAlerts($carId = null, $eventTypeId = null, $duration = null)
    {

        $duration = date('Y-m-d H:i:s', strtotime('+' . $duration . ' days'));

        $conditions = array();
        $conditions["Event.car_id"] = $carId;
        $conditions['Event.next_date <= '] = $duration;
        $conditions['EventEventType.event_type_id'] = $eventTypeId;
        $conditions['EventType.alert_activate'] = 1;
        $conditions['Event.alert != '] = 2;
        $conditions['Car.car_status_id != '] = 27;
        $dateEvents = $this->Event->find('all', array(
            'conditions' => $conditions,
            'recursive' => -1,
            'fields' => array(
                'Car.code',
                'Car.immatr_def',
                'Event.next_date',
                'EventEventType.event_type_id',
                'EventType.alert_activate',
                'EventType.with_date',
                'EventType.with_km',
                'Event.alert',
                'Carmodel.name',
                'Car.id',
                'EventType.name',
                'Event.send_mail',
                'Event.id',
            ),
            'joins' => array(

                array(
                    'table' => 'event_event_types',
                    'type' => 'left',
                    'alias' => 'EventEventType',
                    'conditions' => array('EventEventType.event_id = Event.id')
                ),
                array(
                    'table' => 'event_types',
                    'type' => 'left',
                    'alias' => 'EventType',
                    'conditions' => array('EventEventType.event_type_id = EventType.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Event.car_id = Car.id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Event.customer_id = Customer.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),

            )
        ));
        return $dateEvents;
    }

    /*
    * verify if liter inserted by user is <= liter exist in tank
    */

    function getKmAlerts($carId = null, $eventTypeId = null, $distance = null)
    {


        $car = $this->Car->find("first", array('conditions' => array('Car.id' => $carId), 'fields' => array('Car.km')));
        $kmCar = $car['Car']['km'];
        $conditions = array();
        $conditions["Event.car_id"] = $carId;
        $conditions['Event.next_km <= '] = $kmCar + $distance;
        $conditions['EventEventType.event_type_id'] = $eventTypeId;
        $conditions['EventType.alert_activate'] = 1;
        $conditions['Event.alert != '] = 2;
        $conditions['Car.car_status_id != '] = 27;
        $kmEvents = $this->Event->find('all', array(
            'conditions' => $conditions,
            'recursive' => -1,
            'fields' => array(
                'Car.code',
                'Car.immatr_def',
                'Event.next_date',
                'EventEventType.event_type_id',
                'EventType.alert_activate',
                'EventType.with_km',
                'EventType.with_date',
                'Event.alert',
                'Carmodel.name',
                'Car.id',
                'Car.km',
                'EventType.name',
                'Event.send_mail',
                'Event.next_km',
                'Event.id',
            ),
            'joins' => array(

                array(
                    'table' => 'event_event_types',
                    'type' => 'left',
                    'alias' => 'EventEventType',
                    'conditions' => array('EventEventType.event_id = Event.id')
                ),
                array(
                    'table' => 'event_types',
                    'type' => 'left',
                    'alias' => 'EventType',
                    'conditions' => array('EventEventType.event_type_id = EventType.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Event.car_id = Car.id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Event.customer_id = Customer.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),

            )
        ));
        return $kmEvents;

    }


    public function verifyNbCoupon($nbCoupon = null, $i = null)
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
        $this->set(compact('selectingCouponsMethod', 'i'));

    }

    /*
     * get sereal number of coupon from first serial number not used
     */

    public function verifyConsumptionLiter($liter = null, $name = null, $capacityReservoir = null)
    {

        $this->layout = 'ajax';
        $nbCode = 15 + $name;
        $parameter = $this->Parameter->find('first', array(
            'recursive' => -1,
            'conditions' => array('code' => array($nbCode)),
            'order' => array('code' => 'ASC')
        ));
        if (!empty($parameter)) {
            if ((float)$liter <= (float)$parameter['Parameter']['quantity_liter']) {

                $quantity = $liter;
                if ($quantity > $capacityReservoir) {
                    $this->set('quantity', $capacityReservoir);

                } else {

                    $this->set('quantity', $quantity);
                }

            } else {
                $quantity = $parameter['Parameter']['quantity_liter'];
                //echo json_encode(array("response" => "false", "quantity" =>$quantity));

                if ($quantity > $capacityReservoir) {
                    $this->set('quantity', $capacityReservoir);
                } else {
                    $this->set('quantity', $quantity);
                }
            }
        }
        $this->set('liter', $liter);
    }

    /*
     * verify if exist cards with amount > $price
     */

    public function getCouponsSelected($couponsSelectedId = null)
    {

    }

    public function getCouponsSelectedFromFirstNumber($nbCoupon = null, $sheetRideId = 0, $i = null, $firstNumber = null)
    {
        $this->set(compact('nbCoupon', 'i'));
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

    public function verifyAmountCards($price = null, $i = null, $carId = null)
    {
        $this->set('i', $i);
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

    public function verifySpecieComptes($price = null, $i = null)
    {
        $this->set('i', $i);
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

    public function verifyLiterTanks($liter = null, $i = null, $carId = null)
    {


        $this->set('i', $i);
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


    public function addConsumptionDiv($i = null)
    {
        $paramConsumption = $this->consumptionManagement();
        $defaultConsumptionMethod = $this->Parameter->getCodesParameterVal('default_consumption_method');

        $this->set(compact('i', 'paramConsumption','defaultConsumptionMethod'));
    }

    public function getDivCoupon()
    {
        // Get method of selecting coupons
        $selectingCouponsMethod = $this->Parameter->getCodesParameterVal('select_coupon');
        $this->set('selectingCouponsMethod', $selectingCouponsMethod);
    }

    public function getDivCard($carId = null)
    {
        if ($carId != null) {
            $cards = $this->FuelCard->find('list', array(
                'order' => 'reference ASC',
                'recursive' => -1,
                'conditions' => array('FuelCardCar.car_id' => $carId),
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
                'order' => 'reference ASC'
            ));
        }

        $this->set('cards', $cards);
    }

    /**
     * verify if code bar checked exist
     * if yes update km departure and real date départure
     */
    public function verifyBarCodeDeparture()
    {

        if ($this->request->is('post')) {
            $barcode = $this->request->data['SheetRide']['barcode_departure'];

            $sheetRide = $this->SheetRide->find("first", array(
                "conditions" => array('SheetRide.reference' => $barcode),
                'recursive' => -1,
                'fields' => array('id', 'reference', 'status_id', 'car_id')
            ));

            $filter_url['action'] = 'index';
            $filter_url['barcode_departure'] = 'barcode_departure';
            if (!empty($sheetRide)) {
                $sheetRideId = $sheetRide['SheetRide']['id'];
                $statusId = $sheetRide['SheetRide']['status_id'];
                $carId = $sheetRide['SheetRide']['car_id'];

                if ($statusId == StatusEnum::mission_planned) {
                    $response = $this->updateDateDepartureSheetRide($sheetRideId);
                    $this->updateKmDepartureSheetRide($sheetRideId, $carId);

                    if ($response) {
                        $this->SheetRideManagement->updateStatusSheetRideByDefaultStatus($sheetRideId);
                        $this->Flash->success(__('Departure date has been saved.'));

                        return $this->redirect($filter_url);

                    } else {
                        $this->Flash->error(__('Departure date could not be saved, please try again.'));
                        return $this->redirect($filter_url);
                    }

                } else {
                    $this->Flash->error(__('Sheet ride is not planned.'));
                    $this->redirect($filter_url);
                }

            } else {
                $this->Flash->error(__('Reference do not exist.'));
                $this->redirect($filter_url);

            }


        }


    }

    /** update real date departure of $sheetRideId
     * @param null $sheetRideId
     * @return bool
     */
    public function updateDateDepartureSheetRide($sheetRideId = null)
    {
        $this->SheetRide->id = $sheetRideId;
        date_default_timezone_set("Africa/Algiers");
        $currentDate = date("Y-m-d H:i:s");

        if ($this->SheetRide->saveField('real_start_date', $currentDate)) {

            return true;

        } else {

            return false;
        }
    }

    /**
     * @param null $sheetRideId
     * @param $carId
     */
    //bejaia logistique
    public function updateKmDepartureSheetRide($sheetRideId = null, $carId)
    {
        $synchronizationKm = $this->Parameter->getCodesParameterVal('synchronization_km');
        $car = $this->Car->getCarById($carId, array('Car.code','Car.km'));

        $code = $car['Car']['code'];

        $code = substr($code, 1);
        if($synchronizationKm == 1){
            $headerSynchronization = $this->Parameter->getCodesParameterVal('header_synchronization');
            $urlSynchronization = $this->Parameter->getCodesParameterVal('url_synchronization');
            $headers = array(".$headerSynchronization.");
            //$url = 'http://41.106.3.11/api/LiveTracking?code=' . $code;
            $url = $urlSynchronization . $code;
            $chaine = $this->cUrlGetData($url, null, $headers);

            if (!empty($chaine)) {
                $km = $chaine[0]['Odometer'];
                if (!empty($km)) {
                    $this->SheetRide->id = $sheetRideId;
                    $this->SheetRide->saveField('km_departure', $km);
                }
            }
        }else {
            $km = $car['Car']['km'];
            if (!empty($km)) {
                $this->SheetRide->id = $sheetRideId;
                $this->SheetRide->saveField('km_departure', $km);
            }
        }

        /*$headers = array("Content-Type:application/json",
            "Autentication:CF714E72186F3A8E90A3641CB7EBC65C920450725F1447E82BEEAD0112E8D4C317A829502B69BBBA0011F38DB7E4F42E8B6D987E881ECD73B1F58BB0C2192D7A969261F35591782D90E3509727A2C221A20346686D19CDC9E91BFDA0B73CCED927C1C17F2099E2F67DEF40380FEFBF157BB2522518F68D88786BF02D29155F77C33EE6B10F4FF5DBB44A87A935FD0B9DEDF83ABDC22B41301186A533AAC541C5BB26A6123992803CDAC4F989C2D32C6E5E0AEF975F2BF722BFBF00A6A5AB97E38C84DD046414C7AE20B43614D518F681D0C63F7E74A0E96FBD4BA0F76E0EB86C\r\n");

        */




    }



    /**
     * @param null $sheetRideId
     * @param $carId
     */
    // algeofleet
    /*public function updateKmDepartureSheetRide($sheetRideId = null, $carId)
    {
        $headers = array("Content-Type:application/json");

        $car = $this->Car->getCarById($carId, array('Car.code'));

        $code = $car['Car']['code'];

        //$code = substr($code, 1);

        $url = 'http://www.activegps.net/rest/intellix/vehicleInfos/tr405053ans925786inv920/'.$code;


        $chaine = $this->cUrlGetData($url, null, $headers);


        if (!empty($chaine)) {
            $km = $chaine['odometer'];
            if (!empty($km)) {
                $this->SheetRide->id = $sheetRideId;
                $this->SheetRide->saveField('km_departure', $km);
            }
        }
    }*/





    /**
     * verify if code bar checked exist
     * if yes update km departure and real date départure
     */
    public function verifyBarCodeArrival()
    {
        if ($this->request->is('post')) {
            $barcode = $this->request->data['SheetRide']['barcode_arrival'];
            $sheetRide = $this->SheetRide->find("first", array(
                "conditions" => array('SheetRide.reference' => $barcode),
                'recursive' => -1,
                'fields' => array('id', 'reference', 'car_id', 'status_id')
            ));

            $filter_url['action'] = 'index';
            $filter_url['barcode_arrival'] = 'barcode_arrival';
            if (!empty($sheetRide)) {

                $sheetRideId = $sheetRide['SheetRide']['id'];
                $carId = $sheetRide['SheetRide']['car_id'];
                $statusId = $sheetRide['SheetRide']['status_id'];

                if ($statusId == StatusEnum::sheetride_back_to_parc || $statusId == StatusEnum::sheetride_ongoing) {
                    $response = $this->updateDateArrivalSheetRide($sheetRideId, $carId);
                    $this->updateKmArrivalSheetRide($sheetRideId, $carId);
                    if ($response) {
                        $this->SheetRideManagement->updateStatusSheetRideByDefaultStatus($sheetRideId);
                        $this->Flash->success(__('Arrival date has been saved.'));
                        $this->redirect($filter_url);
                    } else {
                        $this->Flash->error(__('Arrival date could not be saved, please try again.'));
                        $this->redirect($filter_url);
                    }


                } else {
                    $this->Flash->error(__('Sheet ride is not in progress.'));
                    $this->redirect($filter_url);

                }


            } else {
                $this->Flash->error(__('Reference do not exist.'));
                $this->redirect($filter_url);

            }

        }


    }

    /** update  real date arrival of $sheetRideId
     * @param null $sheetRideId
     * @return bool
     */
    public function updateDateArrivalSheetRide($sheetRideId = null)
    {
        $this->SheetRide->id = $sheetRideId;
        date_default_timezone_set("Africa/Algiers");
        $currentDate = date("Y-m-d H:i:s");

        if ($this->SheetRide->saveField('real_end_date', $currentDate)) {

            return true;

        } else {

            return false;
        }
    }
// bejaia logistique
    public function updateKmArrivalSheetRide($sheetRideId = null, $carId)
    {

        /*$headers = array("Content-Type:application/json",
                   "Autentication:CF714E72186F3A8E90A3641CB7EBC65C920450725F1447E82BEEAD0112E8D4C317A829502B69BBBA0011F38DB7E4F42E8B6D987E881ECD73B1F58BB0C2192D7A969261F35591782D90E3509727A2C221A20346686D19CDC9E91BFDA0B73CCED927C1C17F2099E2F67DEF40380FEFBF157BB2522518F68D88786BF02D29155F77C33EE6B10F4FF5DBB44A87A935FD0B9DEDF83ABDC22B41301186A533AAC541C5BB26A6123992803CDAC4F989C2D32C6E5E0AEF975F2BF722BFBF00A6A5AB97E38C84DD046414C7AE20B43614D518F681D0C63F7E74A0E96FBD4BA0F76E0EB86C\r\n");

               */
        $synchronizationKm = $this->Parameter->getCodesParameterVal('synchronization_km');
       // var_dump($synchronizationKm); die();

        $car = $this->Car->getCarById($carId, array('Car.code','Car.km'));

        $code = $car['Car']['code'];

        $code = substr($code, 1);
        if($synchronizationKm == '1'){
            $headerSynchronization = $this->Parameter->getCodesParameterVal('header_synchronization');
            $urlSynchronization = $this->Parameter->getCodesParameterVal('url_synchronization');
            $headers = array("$headerSynchronization");
            //var_dump($headers); die();
            //$url = 'http://41.106.3.11/api/LiveTracking?code=' . $code;
            $url = $urlSynchronization . $code;
            $chaine = $this->cUrlGetData($url, null, $headers);
            //var_dump($chaine); die();
            if (!empty($chaine)) {
                $km = $chaine[0]['Odometer'];
                if (!empty($km)) {
                    $this->SheetRide->id = $sheetRideId;
                    $this->SheetRide->saveField('km_arrival', $km);
                }
            }
        }else {
            $km = $car['Car']['km'];

            if (!empty($km)) {
                $this->SheetRide->id = $sheetRideId;
                $this->SheetRide->saveField('km_arrival', $km);
            }
        }

    }

   // algeofleet
 /*   public function updateKmArrivalSheetRide($sheetRideId = null, $carId)
    {
        $headers = array("Content-Type:application/json");
        $car = $this->Car->getCarById($carId, array('Car.code'));

        $code = $car['Car']['code'];

        //$code = substr($code, 1);

        $url = ': http://www.activegps.net/rest/intellix/vehicleInfos/tr405053ans925786inv920/' . $code;

        $chaine = $this->cUrlGetData($url, null, $headers);


        if (!empty($chaine)) {
            $km = $chaine['odometer'];
            if (!empty($km)) {
                $this->SheetRide->id = $sheetRideId;
                $this->SheetRide->saveField('km_arrival', $km);
            }
        }
    }*/



    /**
     *
     *  get real km of carId with geolocalisation bejaialogistique
     */
 /*   public function getKmCar($carId = null)
    {

        $car = $this->SheetRide->Car->find('first',
            array('conditions' => array('Car.id' => $carId), 'recursive' => -1, ''));
        $codeCar = $car['Car']['code'];
        $headers = array(
            'http' => array(
                'method' => "GET",
                'header' => "Content-Type:application/json\r\n" .
                    "Autentication:CF714E72186F3A8E90A3641CB7EBC65C920450725F1447E82BEEAD0112E8D4C317A829502B69BBBA0011F38DB7E4F42E8B6D987E881ECD73B1F58BB0C2192D7A969261F35591782D90E3509727A2C221A20346686D19CDC9E91BFDA0B73CCED927C1C17F2099E2F67DEF40380FEFBF157BB2522518F68D88786BF02D29155F77C33EE6B10F4FF5DBB44A87A935FD0B9DEDF83ABDC22B41301186A533AAC541C5BB26A6123992803CDAC4F989C2D32C6E5E0AEF975F2BF722BFBF00A6A5AB97E38C84DD046414C7AE20B43614D518F681D0C63F7E74A0E96FBD4BA0F76E0EB86C\r\n"
            )
        );
        $context = stream_context_create($headers);
        $chaine = file_get_contents('http://41.106.3.11/api/LiveTracking', false, $context);

        $chaine = utf8_encode($chaine);
        $chaines = json_decode($chaine, JSON_UNESCAPED_UNICODE);
        foreach ($chaines as $chaine) {
            $code = utf8_decode($chaine['Code']);
            if ($code == $codeCar) {
                $km = $chaine['Odometer'];
                return $km;
            }
        }

    } */
    /**
     * @param null $carId
     * @return mixed
     * km synchronisation algeofleet
     */

 public function getKmCar($carId = null)
    {

        $car = $this->SheetRide->Car->find('first',
            array('conditions' => array('Car.id' => $carId), 'recursive' => -1, ''));
        $codeCar = $car['Car']['code'];

        $link = "http://www.activegps.net/rest/intellix/vehicleInfos/tr405053ans925786inv920/".$codeCar;
        $headers = array("Content-Type:application/json");
        $chaine = $this->cUrlGetData($link, null, $headers);
                $km = $chaine['odometer'];
                return $km;

    }

    /**
     *
     *  view real position of  carId with geolocalisation
     */
    public function ViewPosition($id = null)
    {
        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            $this->redirect('/');
        }

        $sheetRide = $this->SheetRide->find("first", array(
            "conditions" => array('SheetRide.id' => $id),
            'recursive' => -1,
            'fields' => array('id', 'reference', 'car_id', 'status_id', 'Car.code', 'CarModel.name'),
            'joins' => array(
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
        if (!empty($sheetRide)) {

            $code = $sheetRide['Car']['code'] . ' - ' . $sheetRide['CarModel']['name'];
            $carId = $sheetRide['SheetRide']['car_id'];
            $position = $this->getPositionCar($carId);


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
    public function getPositionCar($carId = null)
    {

        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            return $this->redirect('/');
        }
        $car = $this->SheetRide->Car->find('first',
            array('conditions' => array('Car.id' => $carId), 'recursive' => -1));
        $codeCar = $car['Car']['code'];

        $headers = array(
            'http' => array(
                'method' => "GET",
                'header' => "Content-Type:application/json\r\n" .
                    "Autentication:CF714E72186F3A8E90A3641CB7EBC65C920450725F1447E82BEEAD0112E8D4C317A829502B69BBBA0011F38DB7E4F42E8B6D987E881ECD73B1F58BB0C2192D7A969261F35591782D90E3509727A2C221A20346686D19CDC9E91BFDA0B73CCED927C1C17F2099E2F67DEF40380FEFBF157BB2522518F68D88786BF02D29155F77C33EE6B10F4FF5DBB44A87A935FD0B9DEDF83ABDC22B41301186A533AAC541C5BB26A6123992803CDAC4F989C2D32C6E5E0AEF975F2BF722BFBF00A6A5AB97E38C84DD046414C7AE20B43614D518F681D0C63F7E74A0E96FBD4BA0F76E0EB86C\r\n"
            )
        );
        $context = stream_context_create($headers);
        $chaine = file_get_contents('http://41.106.3.11/api/LiveTracking', false, $context);

        $chaine = utf8_encode($chaine);
        $chaines = json_decode($chaine, JSON_UNESCAPED_UNICODE);

        foreach ($chaines as $chaine) {

            $code = utf8_decode($chaine['Code']);

            if ($code == $codeCar) {

                if ($chaine['IsOutOfService'] == false) {

                    $position = $chaine['Position'];


                } else {
                    $position = null;
                }

                return $position;
            }
        }

    }

    public function kmCars()
    {
        $carId = 97;
        $car = $this->SheetRide->Car->find('first',
            array('conditions' => array('Car.id' => $carId), 'recursive' => -1));
        $codeCar = $car['Car']['code'];

        $headers = array(
            'http' => array(
                'method' => "GET",
                'header' => "Content-Type:application/json\r\n" .
                    "Autentication:CF714E72186F3A8E90A3641CB7EBC65C920450725F1447E82BEEAD0112E8D4C317A829502B69BBBA0011F38DB7E4F42E8B6D987E881ECD73B1F58BB0C2192D7A969261F35591782D90E3509727A2C221A20346686D19CDC9E91BFDA0B73CCED927C1C17F2099E2F67DEF40380FEFBF157BB2522518F68D88786BF02D29155F77C33EE6B10F4FF5DBB44A87A935FD0B9DEDF83ABDC22B41301186A533AAC541C5BB26A6123992803CDAC4F989C2D32C6E5E0AEF975F2BF722BFBF00A6A5AB97E38C84DD046414C7AE20B43614D518F681D0C63F7E74A0E96FBD4BA0F76E0EB86C\r\n"
            )
        );
        $context = stream_context_create($headers);

        $chaine = file_get_contents('http://41.106.3.11/api/LiveTracking', false, $context);
        $chaine = utf8_encode($chaine);
        $chaines = json_decode($chaine, JSON_UNESCAPED_UNICODE);
        foreach ($chaines as $chaine) {
            $code = utf8_decode($chaine['Code']);
            if ($code == $codeCar) {
                $km = $chaine['Odometer'];

                $this->Car->id = $carId;
                $this->Car->saveField('km', $km);
            }
        }


    }

    public function pdfReports()
    {
        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            return $this->redirect('/');
        }
        $my_report = "C:\\xampp\\htdocs\\transport\\utranx\\app\\webroot\\attachments\\rpt\\rapport10.rpt";
        $my_pdf = "C:\\xampp\\htdocs\\transport\\utranx\\app\\webroot\\attachments\\rpt\\rapport10.pdf";
        $ObjectFactory = new COM("CrystalRuntime.Application") or die ("Error on load"); // call COM port
        $creport = $ObjectFactory->OpenReport($my_report, 1); // call rpt report
        $creport->Database->Tables(1)->SetLogOnInfo("ANSIDS", "utranx_demo2", "root", "");
        //------ Suppress the Parameter field prompt or else report will hang ------
        $creport->EnableParameterPrompting = 0;
//------ DiscardSavedData make a Refresh in your data -------
        $creport->DiscardSavedData;  //remove die saved Datei
//------ Pass parameter fields --------
        // $creport->ParameterFields(1)->SetCurrentValue (1);
        $creport->ReadRecords(); //hangs here
//- export to PDF process
        $creport->ExportOptions->DiskFileName = $my_pdf; //export to pdf
        $creport->ExportOptions->PDFExportAllPages = true;
        $creport->ExportOptions->DestinationType = 1; // export to file
        $creport->ExportOptions->FormatType = 31; // PDF type | 29 Excel Type
        // $creport->Export(false);
        $this->set('my_pdf', $my_pdf);
    }

    public function jasperReports($id = null)
    {
        $parameter = $this->Parameter->getInformationJasperReport();
        $reportsPathJasper = $parameter['Parameter']['reports_path_jasper'];
        $usernameJasper = $parameter['Parameter']['username_jasper'];
        $passwordJasper = $parameter['Parameter']['password_jasper'];
        $link = $reportsPathJasper . '?sheetid=' . $id . '&j_username=' . $usernameJasper . '&j_password=' . $passwordJasper;
        $this->set('link', $link);
    }

    public function getMarchandisesByClient($clientId = null, $num = null, $nbMarchandise = null)
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

        $this->set(compact('num', 'marchandises','fieldMarchandiseRequired'));
    }

    public function addOtherMarchandises($clientId = null, $num = null, $i = null)
    {
        $this->set('i', $i);
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
        $this->set(compact('num', 'marchandises','fieldMarchandiseRequired'));
    }

    public function getWeightByMarchandise($marchandiseId = null, $num = null, $i = null)
    {
        $marchandise = $this->Marchandise->find('first', array(
            'recursive' => -1,
            'fields' => array('Marchandise.weight_palette', 'Marchandise.weight'),
            'conditions' => array('Marchandise.id' => $marchandiseId)
        ));
        $this->set(compact('marchandise', 'num', 'i'));
    }

    public function getSavedMarchandises($clientId = null, $num = null, $sheetRideDetailRideId = null)
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

        $this->set(compact('selectedMarchandises', 'marchandises', 'num', 'nbMarchandise','fieldMarchandiseRequired'));
    }


    public function searchCarMoreNear($transportBillDetailRideId = null)
    {

        if (
            isset($this->request->data['SheetRides']['zone_id']) || isset($this->request->data['SheetRides']['transport_bill_detail_ride_d'])

        ) {
            $transportBillDetailRideId = $this->request->data['SheetRides']['transport_bill_detail_ride_d'];
            $zoneId = $this->request->data['SheetRides']['zone_id'];

        }

        $transportBillDetailRide = $this->TransportBillDetailRides->find('first', array(
            'recursive' => -1,
            'conditions' => array('TransportBillDetailRides.id' => $transportBillDetailRideId),
            'fields' => array(
                'DepartureDestination.name',
                'DepartureDestination.latlng',
                'ArrivalDestination.name',
                'ArrivalDestination.latlng',
                'Zone.id',
                'CarType.id'
            ),
            'joins' => array(

                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('TransportBill.id = TransportBillDetailRides.transport_bill_id')
                ),
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('DetailRide.id = TransportBillDetailRides.detail_ride_id')
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
                    'table' => 'wilayas',
                    'type' => 'left',
                    'alias' => 'Wilaya',
                    'conditions' => array('DepartureDestination.wilaya_id = Wilaya.id')
                ),
                array(
                    'table' => 'zones',
                    'type' => 'left',
                    'alias' => 'Zone',
                    'conditions' => array('Zone.id = Wilaya.zone_id')
                ),
            )
        ));
        $company = $this->Company->find('first');
        $companyLatlng = $company['Company']['latlng'];
        $companyAdress = $company['Company']['adress'];
        if (empty($wilayaLatlng)) {
            $wilayaId = $company['Company']['wilaya'];
            if (!empty($wilayaId)) {
                $this->loadModel('Destination');
                $wilaya = $this->Destination->find('first', array(
                    'conditions' => array('Destination.id' => $wilayaId),
                    'recursive' => -1,
                    'fields' => array('name', 'latlng')
                ));
                if (!empty($wilaya)) {
                    $wilayaLatlng = $wilaya['Destination']['latlng'];
                    if (empty($wilayaLatlng)) {
                        $wilayaName = $wilaya['Destination']['name'];
                    }
                }
            }
        }
        $this->set(compact('companyLatlng', 'wilayaLatlng', 'wilayaName', 'companyAdress'));
        if (!empty($transportBillDetailRide)) {
            $departureDestinationName = $transportBillDetailRide['DepartureDestination']['name'];
            $departureDestinationLatlng = $transportBillDetailRide['DepartureDestination']['latlng'];
            if (empty($zoneId)) {
                $zoneId = $transportBillDetailRide['Zone']['id'];
            }


            $carTypeId = $transportBillDetailRide['CarType']['id'];
            $sheetRides = $this->SheetRide->find('all', array(
                'recursive' => -1,
                'fields' => array(
                    'LastArrivalDestination.name',
                    'LastArrivalDestination.latlng',
                    'Car.immatr_def',
                    'Carmodel.name',
                    'SheetRide.id'
                ),
                'conditions' => array(
                    'SheetRide.status_id' => 3,
                    'SheetRide.last_zone_id' => $zoneId,
                    'SheetRide.car_type_id' => $carTypeId
                ),
                'joins' => array(
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
                        'table' => 'zones',
                        'type' => 'left',
                        'alias' => 'LastZone',
                        'conditions' => array('LastZone.id = SheetRide.last_zone_id')
                    ),
                    array(
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'LastArrivalDestination',
                        'conditions' => array('LastArrivalDestination.id = SheetRide.last_arrival_destination_id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'CarType',
                        'conditions' => array('CarType.id = SheetRide.car_type_id')
                    ),
                )
            ));

            $zones = $this->Zone->getZones();

            $this->set(compact('departureDestinationName', 'departureDestinationLatlng', 'sheetRides',
                'transportBillDetailRideId', 'zones'));
        }

    }

    function addType()
    {
        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            $this->redirect('/');
        }
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->CarType->create();
            if ($this->CarType->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $type_id = $this->CarType->getLastInsertId();
                $this->set('type_id', $type_id);
            }
        }
    }

    function getTypes()
    {
        $this->settimeactif();
        $this->layout = 'ajax';
        $types = $this->CarType->getCarTypes();
        $this->set('selectbox', $types);
        $this->set('selectedid', $this->params['pass']['0']);
    }


    public function calendar()
    {
        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            $this->redirect('/');
        }

        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::feuille_de_route, $user_id, ActionsEnum::view,
            "SheetRides", null, "SheetRide", null);
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
                'reference',
                'status_id',
                'SheetRide.id',
                'real_start_date',
                'start_date',
                'real_end_date',
                'end_date',
                'car_id',
                'customer_id',
                'CarType.name',
                'Car.code',
                'Customer.first_name',
                'Customer.last_name',
                'Car.immatr_def',
                'Carmodel.name',
            ),
            'joins' => array(
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
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('SheetRide.customer_id = Customer.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                )
            )
        );
        $sheetRides = $this->Paginator->paginate('SheetRide');
        $this->set('sheetRides', $sheetRides);
    }

    public function liste($id = null, $keyword = null, 
	$currentAction = null, $transportBillDetailRideId = null, $observationId = null)
    {
        $planification = $this->hasModulePlanification();
        if ($planification == 0) {
            $this->redirect('/');
        }
        $keyword = str_replace('espace', ' ', $keyword);
        $keyword = str_replace('slash', '/', $keyword);
        $keyword = str_replace('tiret', '-', $keyword);
        $keyword = strtolower($keyword);
        $this->layout = 'ajax';
        $limit = $this->getLimit();
        $order = $this->getOrder();
        switch ($id) {
            case 2 :

                $conditions = array("LOWER(SheetRide.reference) LIKE" => "%$keyword%");
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
                $conditions = array(
                    'OR' => array(
                        "LOWER(Customer.first_name) LIKE" => "%$keyword%",
                        "LOWER(Customer.last_name) LIKE" => "%$keyword%",
                    )
                );
                break;
            case 5 :
                if(!empty($keyword)){
                    $keyword = str_replace("/", "-", $keyword);
                    $start = str_replace("-", "/", $keyword);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $conditions = array("SheetRide.start_date >=" => $startdtm->format('Y-m-d 00:00:00'));
                }else {
                    $conditions = array();
                }

                break;
            case 6 :
                if(!empty($keyword)){
                    $keyword = str_replace("/", "-", $keyword);
                    $start = str_replace("-", "/", $keyword);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $conditions = array("SheetRide.real_start_date >=" => $startdtm->format('Y-m-d 00:00:00'));
                }else {
                    $conditions = array();
                }

                break;  
				
				case 7 :
                    if(!empty($keyword)){
                        $keyword = str_replace("/", "-", $keyword);
                        $start = str_replace("-", "/", $keyword);
                        $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                        $conditions = array("SheetRide.real_end_date >=" => $startdtm->format('Y-m-d 00:00:00'));
                    }else {
                        $conditions = array();
                    }

                break;
            case 8 :
                $conditions = array("LOWER(SheetRide.status_id) LIKE" => "%$keyword%");
                break;


            default:
                $conditions = array("LOWER(SheetRide.reference) LIKE" => "%$keyword%");
        }
		if($currentAction == 'getSheetsToEdit'){
			$generalConditions["SheetRide.status_id"] = array(1,2);
			$conditions = array_merge($generalConditions, $conditions);
		}
        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'order'=>$order,
            'limit' => $limit,
            'conditions' => $conditions,
            'fields' => array(
                'reference',
                'status_id',
                'SheetRide.id',
                'SheetRide.car_subcontracting',
                'SheetRide.car_name',
                'SheetRide.remorque_name',
                'SheetRide.customer_name',
                'start_date',
                'real_start_date',
                'end_date',
                'real_end_date',
                'car_id',
                'customer_id',
                'CarType.name',
                'Car.code',
                'Customer.first_name',
                'Customer.last_name',
                'Car.immatr_def',
                'Carmodel.name',
                'Car.parc_id',
                'CancelCause.name',

            ),
            'joins' => array(
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
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('SheetRide.customer_id = Customer.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'cancel_causes',
                    'type' => 'left',
                    'alias' => 'CancelCause',
                    'conditions' => array('SheetRide.cancel_cause_id = CancelCause.id')
                )
            )
        );

        $sheetRides = $this->Paginator->paginate('SheetRide');

        $this->set('sheetRides', $sheetRides);

        $param = $this->Parameter->getCodesParameterVal('name_car');
        $client_i2b = $this->isCustomerI2B();
        $isAgent = $this->isAgent();
        $reportingChoosed = $this->reportingChoosed();
        if ($reportingChoosed == 3) {
            $informationJasperReport = $this->Parameter->getInformationJasperReport();
            $this->set('informationJasperReport', $informationJasperReport);
        }
        $this->set(compact('param', 'client_i2b', 'isAgent', 
		'reportingChoosed', 'currentAction', 'transportBillDetailRideId','observationId'));
    }


    public function consumptionAlert()
    {
        $consumptionAlert = $this->Parameter->find('first', array('conditions' => array('Parameter.id = ' => 13)));
        $limiteconsumption = $consumptionAlert['Parameter']['val'];

        $this->SheetRide->recursive = 2;
        $consumptionEvents = $this->SheetRide->getConsumptionAlert($limiteconsumption);
        $consumptionCoupons = $this->SheetRide->getCarsWithCouponConsumptionAlerts();
        $this->SheetRide->Car->virtualFields = array(
            'cnames' => "CONCAT(Carmodel.name, ' ', Car.code)"
        );
        $cars = $this->SheetRide->Car->find('list', array(
            'fields' => 'cnames',
            'recursive' => 1,
            'order' => 'Carmodel.name asc'
        ));

        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);
        $users = $this->User->getUsers();
        $parcs = $this->Parc->getParcs('list');
        $hasParc = $this->verifyUserParcPermission(SectionsEnum::feuille_de_route);
        $this->set('consumptions', $consumptionEvents);
        $this->set('consumptioncoupons', $consumptionCoupons);
        $this->set(compact('cars', 'customers', 'users', 'limit', 'parcs', 'hasParc'));
    }

    public function getFinalSupplierByInitialSupplier($supplierId = null, $i = null, $supplierFinalId=null)
    {

        $finalSuppliers = $this->Supplier->getFinalSuppliersByInitialSupplier($supplierId);
        $this->set(compact('finalSuppliers', 'i', 'supplierId','supplierFinalId'));
    }


    public function verifyDriverLicenseExpirationDate($customerId = null)
    {
        $driverLicenseExpParam = $this->Parameter->getParamValByCode(ParametersEnum::expiration_permis, array('val'));;
        $driverLicenseLimitValue = date(
            'Y-m-d H:i:s',
            strtotime('+' . $driverLicenseExpParam['Parameter']['val'] . ' days')
        );
        $customer = $this->Customer->getCustomerWithDriverLicenseExpireDate($driverLicenseLimitValue, $customerId);
        $this->set('driverLicenseLimitValue',$driverLicenseLimitValue);
        if (!empty($customer)) {
            $this->set('customer', $customer);
        }
    }

    public function verifyStatusCar()
    {

        $this->autoRender = false;

        $carId = filter_input(INPUT_POST, "carId");
        $car = $this->CustomerCar->Car->find("first", array(

            "conditions" => array("Car.id" => $carId, 'Car.car_status_id' => CarStatusesEnum::en_panne),
            'recursive' => -1,
            'fields' => array('Car.id', 'Car.car_status_id')
        ));

        if (!empty($car)) {

            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }


    }

    /** afficher les missions d'une feuille de route $id
     * @param $id
     */
    public function viewDetail($id)
    {
        $sheetRideDetailRides = $this->SheetRideDetailRides->getSheetRideDetailRidesBySheetRideId($id);

        $observationIdsWithMissions = array();
        foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
            $observationIdsWithMissions[] = $sheetRideDetailRide['SheetRideDetailRides']['observation_id'];
        }
        $countComplaintObservations = $this->SheetRideDetailRides->find('all', array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'order' => array('SheetRideDetailRides.id' => 'ASC'),
            'conditions' => array('SheetRideDetailRides.observation_id' => $observationIdsWithMissions),
            'fields' => array(
                'COUNT(Complaint.id) AS complaint_count_order',
                'SheetRideDetailRides.id',
                'Observation.id',
            ),
            'group'=>'SheetRideDetailRides.id',
            'joins' => array(

                array(
                    'table' => 'observations',
                    'type' => 'left',
                    'alias' => 'Observation',
                    'conditions' => array('Observation.id = SheetRideDetailRides.observation_id')
                )  ,
                array(
                    'table' => 'complaints',
                    'type' => 'left',
                    'alias' => 'Complaint',
                    'conditions' => array('Observation.id = Complaint.observation_id')
                )  ,

            )
        ));

        $roleId = $this->Auth->user('role_id');
        $profileId = $this->Auth->user('profile_id');
        $permissionCancel = $this->AccessPermission->getPermissionWithParams(SectionsEnum::annuler_commande_client,
            ActionsEnum::add, $profileId, $roleId);
        $permissionComplaint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::reclamation,
            ActionsEnum::add, $profileId, $roleId);

        $this->set(compact('sheetRideDetailRides','permissionCancel',
            'permissionComplaint','countComplaintObservations'));
    }

    /** fonction pour ajouter le div dd'un trajet personnalisé
     * @param null $i
     */
    public function getPersonalizedRide($i = null)
    {
        $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validatePersonalizedRide;
        $this->set('i', $i);
    }

    public function addConsumptionMethod($typeConsumption = null, $i = null, $carId= null)
    {
        switch ($typeConsumption) {
            case ConsumptionTypesEnum::coupon :
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
                $this->set(compact('coupons', 'selectingCouponsMethod', 'typeConsumption', 'i'));
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


                $this->set(compact('typeConsumption', 'i','comptes','negativeAccount'));
                break;

            case ConsumptionTypesEnum::tank :
                $this->loadModel('Tank');
                $tanks = $this->Tank->find('list', array('order' => 'code ASC'));
                $this->set(compact('tanks', 'typeConsumption', 'i'));
                break;

            case ConsumptionTypesEnum::card :
                $cardAmountVerification = $this->Parameter->getCodesParameterVal('card_amount_verification');
                if($cardAmountVerification ==1){
                    $this->loadModel('FuelCard');
                    $automaticCardAssignment = $this->Parameter->getCodesParameterVal('automatic_card_assignment');
                    if ($carId != null && $automaticCardAssignment==1) {
                        $cards = $this->FuelCard->find('list', array(
                            'order' => 'reference ASC',
                            'recursive' => -1,
                            'conditions' => array( 'FuelCardCar.car_id' => $carId),
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
                    }else {
                        $cards = $this->FuelCard->find('list', array('order' => 'reference ASC'));
                    }

                }else {
                    $cards = array();
                }

                $this->set(compact('cards', 'typeConsumption',
                    'i' ,'cardAmountVerification','automaticCardAssignment'));
                break;
        }
    }

    public function addConveyor($i = null)
    {
        $this->set('i', $i);
    }

    public function getCarTypeByCar($carId = null)
    {
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $car = $this->Car->getCarsByFieldsAndConds($param, array('Car.car_type_id'), array('Car.id' => $carId), 'first');
        $carTypeId = $car['Car']['car_type_id'];
        $carTypes = $this->CarType->getCarTypeByConditions(array('CarType.id' => $carTypeId));
        $this->set(compact('carTypes', 'carTypeId'));

    }

    public function getContractCostByDetailRide($detailRideId = null, $i = null, $fromCustomerOrder = null, $carId = null)
    {
        $this->set('i', $i);
        $orderType = null;
        if ($fromCustomerOrder == '1') {
            $transportBillDetailRide = $this->TransportBillDetailRides->find('first', array(
                'recursive'=>-1,
                'conditions' => array('TransportBillDetailRides.id' => $detailRideId),
                'fields' => array('TransportBillDetailRides.detail_ride_id',
                    'TransportBillDetailRides.price_ht',
                    'TransportBillDetailRides.nb_trucks',
                    'TransportBill.order_type'),
                'joins' => array(
                    array(
                        'table' => 'transport_bills',
                        'type' => 'left',
                        'alias' => 'TransportBill',
                        'conditions' => array('TransportBill.id = TransportBillDetailRides.transport_bill_id')
                    ),
                )
            ));
            $orderType = $transportBillDetailRide['TransportBill']['order_type'];
            $detailRideId = $transportBillDetailRide['TransportBillDetailRides']['detail_ride_id'];
        }
        $contract =null;
        if(!empty($carId)&& ($carId!='undefined') && ($carId!=null) ){
        $car = $this->Car->getCarById($carId, array('Car.supplier_id', 'Car.car_type_id'));
        $supplierId = $car['Car']['supplier_id'];
        $conditions = array(
            'Contract.supplier_id' => $supplierId,
            'ContractCarType.detail_ride_id' => $detailRideId
        );
        $contract = $this->ContractCarType->findContractCarTypeByParams('first', $conditions);

        }

        $subcontractorCost =null;
        if(empty($contract)&& ($fromCustomerOrder =='1')){
            $subcontractorCostPercentage = $this->Parameter->getCodesParameterVal('subcontractor_cost_percentage');
            if(isset($transportBillDetailRide)){
                $unitPrice = $transportBillDetailRide['TransportBillDetailRides']['price_ht']
                / $transportBillDetailRide['TransportBillDetailRides']['nb_trucks'];
                $subcontractorCost = ($unitPrice*$subcontractorCostPercentage)/100;
            }
        }
        $this->set('subcontractorCost', $subcontractorCost);
        $this->set('contract', $contract);
        $this->set('orderType', $orderType);


    }
    public function getSubcontractorCostBySheetRideDetailRide($sheetRideDetailRideId = null, $i=null)
    {
        $this->set('i', $i);
        $reservation = $this->Reservation->getReservationBySheetRideDetailRideId($sheetRideDetailRideId);
        $subcontractorCost =null;
        if(!empty($reservation)){
                $subcontractorCost = $reservation['Reservation']['cost'];
        }
        $this->set('subcontractorCost',$subcontractorCost);


    }





    function addCustomer()
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::employe, $user_id, ActionsEnum::add, "Customers", null,
            "Customer", null, 1);
        $this->set('result', $result);
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->Customer->create();
            if ($this->Customer->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $customerId = $this->Customer->getLastInsertId();
                $this->set('customerId', $customerId);
            }
        }
        $this->loadModel('CustomerCategory');
        $customerCategories = $this->CustomerCategory->getCustomerCategories();
        $this->set('customerCategories', $customerCategories);
    }

    function getCustomers()
    {
        $this->settimeactif();
        $this->layout = 'ajax';
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);
        $this->set('customers', $customers);
        $this->set('selectedid', $this->params['pass']['0']);
    }




    function getInformationCarBySubcontracting($id = null)
    {
        $this->set('id', $id);
        if ($id == 'car_subcontracting1') {
            if(Configure::read('car_required')=='1'){
                $this->SheetRide->validate = $this->SheetRide->validateSubcontractingRequired;
            }else {
                $this->SheetRide->validate = $this->SheetRide->validateSubcontracting;
            }

        }
    }

    function getSheetsToEdit($transportBillDetailRideId = null, $observationId = null)
    {

        $this->Session->write('transportBillDetailRideId', $transportBillDetailRideId);
        $this->Session->write('observationId', $observationId);
        $this->isOpenedByOtherUser("TransportBillDetailRides", 'SheetRides', 'transport bill',
            $transportBillDetailRideId);

        $cond = $this->getConditionsForIndexSheetRide();
        $generalConditions = $cond[0];
        $useRideCategory = $this->useRideCategory();

        $query['count'] = " SELECT COUNT(*) AS `count`, CONCAT(`Customer`.`first_name`,' - ', `Customer`.`last_name`) as full_name,
                            CONCAT(`Car`.`code` ,' - ', `Carmodel`.`name`) as car_name FROM `sheet_rides` AS `SheetRide` 
                            left JOIN `car` AS `Car` ON (`SheetRide`.`car_id` = `Car`.`id`) 
                            left JOIN `car_types` AS `CarType` ON (`SheetRide`.`car_type_id` = `CarType`.`id`) 
                            left JOIN `customers` AS `Customer` ON (`SheetRide`.`customer_id` = `Customer`.`id`) 
                            left JOIN `carmodels` AS `Carmodel` ON (`Car`.`carmodel_id` = `Carmodel`.`id`) 
                            WHERE 1=1 && " ;
        $query['detail'] =
            " SELECT `SheetRide`.`reference`, `SheetRide`.`status_id`, `SheetRide`.`id`, `SheetRide`.`car_subcontracting`, 
            `SheetRide`.`car_name`, `SheetRide`.`remorque_name`, `SheetRide`.`customer_name`, `SheetRide`.`start_date`, 
            `SheetRide`.`real_start_date`, `SheetRide`.`end_date`, `SheetRide`.`real_end_date`, `SheetRide`.`car_id`, 
            `SheetRide`.`customer_id`, `CarType`.`name`, `Car`.`code`, `Customer`.`first_name`, `Customer`.`last_name`, 
            CONCAT(`Customer`.`first_name`,' - ', `Customer`.`last_name`) as full_name,
                           CONCAT(`Car`.`code` ,' - ', `Carmodel`.`name`) as car_name,
            `Car`.`immatr_def`, `Carmodel`.`name`, `Car`.`parc_id` 
            FROM `sheet_rides` AS `SheetRide` 
            left JOIN `car` AS `Car` ON (`SheetRide`.`car_id` = `Car`.`id`) 
            left JOIN `car_types` AS `CarType` ON (`SheetRide`.`car_type_id` = `CarType`.`id`) 
            left JOIN `customers` AS `Customer` ON (`SheetRide`.`customer_id` = `Customer`.`id`) 
            left JOIN `carmodels` AS `Carmodel` ON (`Car`.`carmodel_id` = `Carmodel`.`id`) 
            WHERE  1=1 &&  " ;

        $conditions =' `SheetRide`.`status_id` IN (1, 2, 3) ';

        if (!empty($generalConditions)) {
            $conditions = $conditions .' && '.$generalConditions;
        }

        $query['conditions'] = $conditions;
        $query['columns'] = array(
            0 => array('SheetRide.reference','SheetRide', 'reference', 'Reference', 'string',''),
            1 => array('Carmodel.name','0', 'car_name',  'Car', 'string','CONCAT','Carmodel.name','Car.code', 'SheetRide.car_name', 'SheetRide.car_name'),
            2 => array('Customer.first_name','0', 'full_name','Customer', 'string','CONCAT', 'Customer.first_name','Customer.last_name', 'SheetRide.customer_name', 'SheetRide.customer_name'),
            3 => array('SheetRide.start_date','SheetRide', 'start_date', 'Start date', 'datetime',''),
            4 => array('SheetRide.real_start_date','SheetRide', 'real_start_date', 'Real start date', 'datetime',''),
            5 => array('SheetRide.real_end_date','SheetRide', 'real_end_date', 'Real end date', 'datetime',''),
            6 => array('SheetRide.status_id','SheetRide', 'status_id', 'Status', 'number',''),
        );
        $query['order'] = ' SheetRide.id desc';
        $query['tableName'] = 'SheetRide';
        $query['entityName'] = 'SheetRide';
        $query['controller'] = 'sheetRides';
        /*$query['transportBillDetailRideId'] = $transportBillDetailRideId;
        $query['observationId'] = $observationId;*/
        $query['action'] = 'getSheetsToEdit';
        $query['itemName'] = array('reference');

        $this->Session->write('query', $query);


        //get default user limit value
        $defaultLimit =  $this->getLimit();;
        if (isset($defaultLimit) && $defaultLimit > 0) {
            $this->set('defaultLimit', $defaultLimit);
        } else {
            $this->set('defaultLimit', 20);
        }
        $this->set(compact( 'transportBillDetailRideId', 'observationId'));
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set(compact('limit', 'param', 'order'));
        $profiles = $this->Profile->getUserProfiles();
        $rideCategories = $this->RideCategory->getRideCategories();
        $reportingChoosed = $this->reportingChoosed();
        if ($reportingChoosed == 3) {
            $informationJasperReport = $this->Parameter->getInformationJasperReport();
            $this->set('informationJasperReport', $informationJasperReport);
        }

        $client_i2b = $this->isCustomerI2B();
        $hasSaleModule = $this->hasSaleModule();
        $parcs = $this->Parc->getParcs('list');
        $controller =  'sheetRides';
        $action =  'getSheetsToEdit';
        $deleteFonction =  'deleteSheetRides';
        $this->set(compact('profiles', 'rideCategories', 'reportingChoosed', 'useRideCategory','observationId',
            'client_i2b', 'hasSaleModule', 'parcs','controller','deleteFonction','action','transportBillDetailRideId'));
    }

    function cancelCustomerOrders($ids = null, $model = null)
    {

        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validateCancelCauses;
        $arrayIds = explode(",", $ids);

        if (!empty($this->request->data)) {

            switch ($model) {
                case 'SheetRideDetailRides':
                    $conditions = array('SheetRideDetailRides.id' => $arrayIds, 'SheetRideDetailRides.status_id'=>array(StatusEnum::sheetride_planned, StatusEnum::canceled));
                    $sheetRideDetailRides = $this->SheetRideDetailRides->getSheetRideDetailRidesByConditions($conditions);
                    $status = TransportBillDetailRideStatusesEnum::canceled;
                    if (!empty($sheetRideDetailRides)) {
                        foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
                            $this->SheetRideDetailRides->id = $sheetRideDetailRide['SheetRideDetailRides']['id'];
                            $this->SheetRideDetailRides->saveField('cancel_cause_id', $this->request->data['SheetRideDetailRides']['cancel_cause_id']);
                            $this->SheetRideDetailRides->saveField('status_id', $status);
                            $transportBillDetailRideId = $sheetRideDetailRide['SheetRideDetailRides']['transport_bill_detail_ride_id'];
                            $this->SheetRideDetailRides->saveField('transport_bill_detail_ride_id', NULL);
                            if(!empty($transportBillDetailRideId)){
                                $this->TransportBillDetailRides->updateStatusTransportBillDetailRide($transportBillDetailRideId);
                            }
                        }
                    }
                    break;
                case 'SheetRide':
                    $conditions = array('SheetRide.id' => $arrayIds , 'SheetRideDetailRides.status_id'=>array(StatusEnum::sheetride_planned, StatusEnum::canceled));
                    $sheetRides = $this->SheetRide->getSheetRidesByConditions($conditions);
                    $status = TransportBillDetailRideStatusesEnum::canceled;
                    if (!empty($sheetRides)) {
                        foreach ($sheetRides as $sheetRide) {
                            $this->SheetRide->id = $sheetRide['SheetRide']['id'];
                            $this->SheetRide->saveField('cancel_cause_id', $this->request->data['SheetRideDetailRides']['cancel_cause_id']);
                            $this->SheetRide->saveField('status_id', $status);
                        }
                        $conditions = array('SheetRideDetailRides.sheet_ride_id' => $arrayIds);
                        $sheetRideDetailRides = $this->SheetRideDetailRides->getSheetRideDetailRidesByConditions($conditions);
                        if (!empty($sheetRideDetailRides)) {
                            foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
                                $this->SheetRideDetailRides->id = $sheetRideDetailRide['SheetRideDetailRides']['id'];
                                $this->SheetRideDetailRides->saveField('cancel_cause_id', $this->request->data['SheetRideDetailRides']['cancel_cause_id']);
                                $this->SheetRideDetailRides->saveField('status_id', $status);
                                $transportBillDetailRideId = $sheetRideDetailRide['SheetRideDetailRides']['transport_bill_detail_ride_id'];
                                $this->SheetRideDetailRides->saveField('transport_bill_detail_ride_id', NULL);
                                if(!empty($transportBillDetailRideId)){
                                    $this->TransportBillDetailRides->updateStatusTransportBillDetailRide($transportBillDetailRideId);
                                }
                            }
                        }
                    }
                    break;
            }
            $this->Flash->success(__('The missions has been canceled.'));

            $this->redirect(array('action' => 'index'));
        }
        $cancelCauses = $this->CancelCause->getCancelCauses('list');

        $this->set('cancelCauses', $cancelCauses);
    }

    function addComplaint($ids = null)
    {

        $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validateComplaints;
        $arrayIds = explode(",", $ids);
        $conditions = array('SheetRideDetailRides.id' => $arrayIds);
        $sheetRideDetailRides = $this->SheetRideDetailRides->getSheetRideDetailRidesByConditions($conditions);
        $sheetRideId = $sheetRideDetailRides[0]['SheetRideDetailRides']['sheet_ride_id'];

        if (!empty($this->request->data)) {

                    if (!empty($sheetRideDetailRides)) {
                        foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
                            $this->request->data['Complaint']['sheet_ride_detail_ride_id'] = $sheetRideDetailRide['SheetRideDetailRides']['id'];

                            $this->Complaint->create();
                            $this->createDateFromDate('Complaint', 'complaint_date');
                            $this->request->data['Complaint']['user_id'] = $this->Session->read('Auth.User.id');
                            $this->Complaint->save($this->request->data);
                            $countComplaintMission = $this->Complaint->getNbComplaintsByMission($this->request->data['Complaint']['sheet_ride_detail_ride_id']);
                           // var_dump($countComplaintMission); die();
                            $this->SheetRideDetailRides->updateNbComplaints($this->request->data['Complaint']['sheet_ride_detail_ride_id'],$countComplaintMission);
                            $userId = $this->Auth->user('id');
                            $actionId = ActionsEnum::add;
                            $sectionId = SectionsEnum::nouvelle_reclamation;
                            $complaintId = $this->Complaint->getInsertID();
                                $this->Notification->addNotification($complaintId, $userId, $actionId,$sectionId,'Mission');
                                $this->getNbNotificationsByUser();

                        }
                        $countComplaintSheetRides = $this->Complaint->getNbComplaintsBySheetRide($sheetRideId);
                        $this->SheetRide->updateNbComplaintsByMissions($sheetRideId,$countComplaintSheetRides);


                    }



            $this->Flash->success(__('The complaint has been saved.'));

            $this->redirect(array('action' => 'index'));
        }
        $this->loadModel('ComplaintCause');
        $complaintCauses = $this->ComplaintCause->find('list');

        $this->set('complaintCauses', $complaintCauses);
    }


    /**
     * enlever lannulation des commandes annulées
     */
        public function removeCancellation()
    {
        $ids = filter_input(INPUT_POST, "chkids");
        $model = filter_input(INPUT_POST, "model");
        $arrayIds = explode(",", $ids);

        /*recuperer toutes les commandes qui ont été tchecked et avec le statut annulé  */
        $status = StatusEnum::sheetride_planned;
            switch ($model) {
                case 'SheetRideDetailRides':
                    $conditions = array('SheetRideDetailRides.id' => $arrayIds, 'SheetRideDetailRides.status_id'=>StatusEnum::canceled);
                    $sheetRideDetailRides = $this->SheetRideDetailRides->getSheetRideDetailRidesByConditions($conditions);

                    if (!empty($sheetRideDetailRides)) {
                        foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
                            $this->SheetRideDetailRides->id = $sheetRideDetailRide['SheetRideDetailRides']['id'];
                            $this->SheetRideDetailRides->saveField('cancel_cause_id', Null);
                            $this->SheetRideDetailRides->saveField('status_id', $status);

                        }
                    }
                    break;
                case 'SheetRide':
                    $conditions = array('SheetRide.id' => $arrayIds , 'SheetRide.status_id'=>StatusEnum::canceled);
                    $sheetRides = $this->SheetRide->getSheetRidesByConditions($conditions);

                    if (!empty($sheetRides)) {
                        foreach ($sheetRides as $sheetRide) {
                            $this->SheetRide->id = $sheetRide['SheetRide']['id'];
                            $this->SheetRide->saveField('cancel_cause_id', Null);
                            $this->SheetRide->saveField('status_id', $status);
                        }
                        $conditions = array('SheetRideDetailRides.sheet_ride_id' => $arrayIds);
                        $sheetRideDetailRides = $this->SheetRideDetailRides->getSheetRideDetailRidesByConditions($conditions);
                        if (!empty($sheetRideDetailRides)) {
                            foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
                                $this->SheetRideDetailRides->id = $sheetRideDetailRide['SheetRideDetailRides']['id'];
                                $this->SheetRideDetailRides->saveField('cancel_cause_id', Null);
                                $this->SheetRideDetailRides->saveField('status_id', $status);

                            }
                        }
                    }
                    break;
            }

        $type = TransportBillTypesEnum::order;

        $this->redirect(array('action' => 'index', $type));
    }

    public function downloadAttachement()
    {
        $file= $_GET['file'];
        $filename= $_GET['filename'];
        $file_path =dirname(__DIR__) . DS . "webroot" . DS . $file;
        $this->response->file($file_path, array(
            'download' => true,
            'name' => $filename,
        ));
        return $this->response;
    }

    public function saveValidations(){
        $this->autoRender = false;
        $attachmentIds = json_decode($_POST['attachmentIds']);
        $validations = json_decode($_POST['validations']);
        $i = 0;
        $save = true;
        foreach ($attachmentIds as $attachmentId){
            $this->Attachment->id = $attachmentId;
            if(!$this->Attachment->saveField('validation', $validations[$i])){
                $save = false;
                echo json_encode(array("response" => "false"));
            };
            $i++;
        }
        if($save == true){
            echo json_encode(array("response" => "true"));
        }

    }

    public function updateInformationLeavingPark()
    {
        $id = $_POST['id'];
        $kmDeparture= $_POST['km_departure'];
        $statusId = $_POST['status_id'];
        $realStartDate = $_POST['real_start_date'];
        $this->SheetRide->id = $id;
        $this->SheetRide->saveField('km_departure', $kmDeparture);
        $this->SheetRide->saveField('real_start_date', $realStartDate);
        $this->SheetRide->saveField('status_id', $statusId);

    }
    public function updateInformationReturnPark()
    {
        $id = $_POST['id'];
        $kmArrival= $_POST['km_arrival'];
        $statusId = $_POST['status_id'];
        $realEndDate = $_POST['real_end_date'];
        $this->SheetRide->id = $id;
        $this->SheetRide->saveField('km_arrival', $kmArrival);
        $this->SheetRide->saveField('real_end_date', $realEndDate);
        $this->SheetRide->saveField('status_id', $statusId);

    }

    public function addPaymentConsumptionSpecies($compteId=null, $species=null,
                                                 $consumptionId = null, $consumptionDate=null)

    {

        $consumption = $this->Consumption->find('first', array(
            'conditions' => array('Consumption.id' => $consumptionId),
            'recursive' => -1,
            'fields' => array(
                'SheetRide.customer_id',
                'Consumption.species',
                'Consumption.id',
                'SheetRide.reference',
            ),
            'order' => array('Consumption.consumption_date' => 'ASC'),
            'joins' => array(
                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('SheetRide.id = Consumption.sheet_ride_id')
                )
            )
        ));
        $amount = $consumption['Consumption']['species'];
        $customerId = $consumption['SheetRide']['customer_id'];
        $customer = $this->Customer->find('first', array(
            'conditions' => array('Customer.id' => $customerId),
            'recursive' => -1,
            'fields' => array('Customer.balance')
        ));
        if (!empty($customer)) {
            $balance = $customer['Customer']['balance'];
        } else {
            $balance = 0;
        }

        /*
         * payment_type_id = 1 credit
         * payment_type_id = 2 debit
         */
        if (Configure::read("cafyb") == '1') {
            $thirdPartyId = $this->Customer->getThirdPartyIdByCustomerId($customerId);
            $payment['amount'] = $amount;
            $payment['receipt_date'] = $consumptionDate;
            $payment['value_date'] = '';
            $payment['deadline_date'] = '';
            $payment['account_id'] = $compteId;
            $payment['third_party_id'] = $thirdPartyId;
            $payment['payment_type_id'] = 2;
            $payment['payment_method_id'] = 1;
            $payment['payment_status_id'] = 1;
            $payment['payment_category_id'] = '';
            $payment['label'] = 'Consommation '.$consumption['SheetRide']['reference'];
            $this->Cafyb->addPayment($payment);

        }else {
            $this->Payment->create();
            $this->request->data['Payment']['amount'] = $amount;
            $payrollAmount = $this->request->data['Payment']['amount'];
            $payrollAmount = $payrollAmount + $balance;

            $this->request->data['Payment']['receipt_date'] = $consumptionDate;
            $this->request->data['Payment']['payment_association_id'] = PaymentAssociationsEnum::consumption_species;
            $this->request->data['Payment']['compte_id'] = $compteId;
            $this->request->data['Payment']['customer_id'] = $customerId;
            $this->request->data['Payment']['transact_type_id'] = 2;
            $this->request->data['Payment']['payment_type'] = 1;
            $this->request->data['Payment']['payment_etat'] = 4;
            $this->request->data['Payment']['wording'] = $consumption['SheetRide']['reference'];

            if ($this->Payment->save($this->request->data)) {
                $paymentId = $this->Payment->getInsertID();

                $this->loadModel('DetailPayment');
                $this->DetailPayment->create();

                $data['DetailPayment']['payment_id'] = $paymentId;
                $data['DetailPayment']['consumption_id'] = $consumptionId;
                if ($payrollAmount > $species) {
                    $data['DetailPayment']['payroll_amount'] = $species;
                    $payrollAmount = $payrollAmount - $species;
                    $balance = $payrollAmount;

                } else {

                    $data['DetailPayment']['payroll_amount'] = $payrollAmount;
                    $data['DetailPayment']['amount_remaining'] = 0;
                    $balance = 0;
                }

                if ($this->DetailPayment->save($data)) {
                    $save = true;
                } else {
                    $save = false;
                }


                if ($balance > 0) {

                    $this->Customer->id = $customerId;
                    $this->Customer->saveField('balance', $balance);
                }
                if ($save == true) {

                    $this->Compte->updateCompteDebit($compteId, $amount);
                }
            }
        }

    }



    public function updatePaymentConsumptionSpecies($compteId=null, $species=null,
                                                    $consumptionId = null, $consumptionDate=null){

        $detailPayments = $this->DetailPayment->getDetailPaymentByConsumptionId($consumptionId);
        $balanceConductor =  $detailPayments[0]['Payment']['amount'] - $detailPayments[0][0]['total_payroll_amount'];
        //$balanceConductor = $this->DetailPayment->getBalance($id);
        //$payment = $this->Payment->getPaymentWithCustomerById($id);
        $paymentId = $detailPayments[0]['Payment']['id'];
        $precedentCompteId = $detailPayments[0]['Payment']['compte_id'];
        $precedentAmount = $detailPayments[0]['Payment']['amount'];
        $amount = $species;
        $customerId = $detailPayments[0]['Customer']['id'];
        $this->request->data['Payment']['id'] = $paymentId;
        $this->request->data['Payment']['payment_association_id'] = PaymentAssociationsEnum::consumption_species;
        $this->request->data['Payment']['customer_id'] = $customerId;
        $this->request->data['Payment']['receipt_date'] = $consumptionDate;
        $this->request->data['Payment']['compte_id'] = $compteId;
        if ($this->Payment->save($this->request->data)) {
            if($precedentAmount != $amount){
                $this->DetailPayment->deleteAll(array('DetailPayment.payment_id' => $paymentId), false);
                $this->Compte->updateCompteDebit($compteId, $amount, $precedentCompteId, $precedentAmount);
                $this->Customer->updateBalanceConductor($customerId, $amount, $balanceConductor);
            }

        }
    }

    public function deletePaymentConsumptionSpecies($consumptionId = null)
    {

        $detailPayments = $this->DetailPayment->getDetailPaymentByConsumptionId($consumptionId);
        $lastBalance = $detailPayments[0]['Payment']['amount'] - $detailPayments[0][0]['total_payroll_amount'];
        $paymentId = $detailPayments[0]['Payment']['id'];
        $precedentCompteId = $detailPayments[0]['Payment']['compte_id'];
        $precedentAmount = $detailPayments[0]['Payment']['amount'];
        $compteId = $detailPayments[0]['Payment']['compte_id'];
        $customerId = $detailPayments[0]['Customer']['id'];
        $this->DetailPayment->deleteAll(array('DetailPayment.payment_id' => $paymentId), false);
        $this->Payment->delete();
        $this->Compte->updateCompteDebit($compteId, 0, $precedentCompteId, $precedentAmount);
        $this->Customer->updateBalanceConductor($customerId, 0, $lastBalance);


    }


    /**
     * add Sheet Ride Car States
     *
     * @param array $sheetRideCarStates
     * @param id $sheetRideId
     *
     * @return
     */
    public function addSheetRideCarStates($sheetRideCarStates = null,$sheetRideId = null)
    {

        foreach ($sheetRideCarStates as $sheetRideCarState){

            $this->SheetRideCarState->create();
            $data['SheetRideCarState']['sheet_ride_id'] = $sheetRideId;
            $data['SheetRideCarState']['car_state_id'] = $sheetRideCarState['car_state_id'];
            $data['SheetRideCarState']['car_state_value'] = $sheetRideCarState['car_state_value'];
            $data['SheetRideCarState']['note'] = $sheetRideCarState['note'];
            $this->request->data['SheetRideCarState']['attachment'] =$sheetRideCarState['attachment'];
            $this->request->data['SheetRideCarState']['attachment'] = $this->verifyAttachmentByType('SheetRideCarState', 'attachment', 'attachments/car_states/', 'add', 0, 0, null);

            $data['SheetRideCarState']['attachment'] = $this->request->data['SheetRideCarState']['name'] ;



            $data['SheetRideCarState']['departure_arrival'] = $sheetRideCarState['departure_arrival'];
            $data['SheetRideCarState']['user_id'] =$this->Session->read('Auth.User.id');
            $this->SheetRideCarState->save($data);
        }

    }

    public function addSheetRideCarState($sheetRideCarState = null,$sheetRideId = null)
    {
            $this->SheetRideCarState->create();
            $data['SheetRideCarState']['sheet_ride_id'] = $sheetRideId;
            $data['SheetRideCarState']['car_state_id'] = $sheetRideCarState['car_state_id'];
            $data['SheetRideCarState']['car_state_value'] = $sheetRideCarState['car_state_value'];
            $data['SheetRideCarState']['note'] = $sheetRideCarState['note'];
            $this->request->data['SheetRideCarState']['attachment'] =$sheetRideCarState['attachment'];
            $this->request->data['SheetRideCarState']['attachment'] = $this->verifyAttachmentByType('SheetRideCarState', 'attachment', 'attachments/car_states/', 'add', 0, 0, null);
            $data['SheetRideCarState']['attachment'] = $this->request->data['SheetRideCarState']['name'] ;
            $data['SheetRideCarState']['departure_arrival'] = $sheetRideCarState['departure_arrival'];
            $data['SheetRideCarState']['user_id'] =$this->Session->read('Auth.User.id');
            $this->SheetRideCarState->save($data);
    }
    public function updateSheetRideCarState($sheetRideCarState = null,$sheetRideId = null)
    {
            $data['SheetRideCarState']['sheet_ride_id'] = $sheetRideId;
            $data['SheetRideCarState']['id'] = $sheetRideCarState['id'];
            $data['SheetRideCarState']['car_state_id'] = $sheetRideCarState['car_state_id'];
            $data['SheetRideCarState']['car_state_value'] = $sheetRideCarState['car_state_value'];
            $data['SheetRideCarState']['note'] = $sheetRideCarState['note'];
            $this->request->data['SheetRideCarState']['attachment'] =$sheetRideCarState['attachment'];
            $this->request->data['SheetRideCarState']['attachment'] = $this->verifyAttachmentByType('SheetRideCarState', 'attachment', 'attachments/car_states/', 'add', 0, 0, null);
            $data['SheetRideCarState']['attachment'] = $this->request->data['SheetRideCarState']['name'] ;
            $data['SheetRideCarState']['departure_arrival'] = $sheetRideCarState['departure_arrival'];
            $data['SheetRideCarState']['user_id'] =$this->Session->read('Auth.User.id');
            $this->SheetRideCarState->save($data);
    }

    public function getSheetRideCarStatesBySheetRideId($sheetRideId=null)
    {

        $conditions ='1 = 1';
        if(isset($sheetRideId) && $sheetRideId!=null ){
            $conditions = $conditions."  and  `SheetRide`.`id` = ".$sheetRideId;
        }

        $sqlSheetRideCarStates =" SELECT 
                        `SheetRide`.`id`, `SheetRide`.`reference`,`SheetRideCarState`.`car_state_value`,
                        `CarState`.`name`, `SheetRideCarState`.`departure_arrival`, `SheetRideCarState`.`note`
                                                                   
                                        FROM  `sheet_rides` AS `SheetRide` 
                                        left JOIN `sheet_ride_car_states` AS `SheetRideCarState` ON (`SheetRide`.`id` = `SheetRideCarState`.`sheet_ride_id`) 
                                        left JOIN `car_states` AS `CarState` ON (`CarState`.`id` = `SheetRideCarState`.`car_state_id`) 
										 
                                    WHERE ".$conditions."
                                      order by `SheetRideCarState`.`id` ASC ";

        $conn = ConnectionManager::getDataSource('default');
        $sheetRideCarStates = $conn->fetchAll($sqlSheetRideCarStates);
        $sheetRideCarStatesArray= array();
        $i=0;
        if(!empty($sheetRideCarStates))
        {
            foreach ($sheetRideCarStates  as $sheetRideCarState){
                $sheetRideCarStatesArray[$i]['reference_feuille_route']=$sheetRideCarState['SheetRide']['reference'];
                $sheetRideCarStatesArray[$i]['etat_vehicule']=$sheetRideCarState['CarState']['name'];
                if($sheetRideCarState['SheetRideCarState']['car_state_value'] == 1){
                    $sheetRideCarStatesArray[$i]['valeur_etat']='OUI';

                }else {
                    $sheetRideCarStatesArray[$i]['valeur_etat']='NON';
                }
                $sheetRideCarStatesArray[$i]['note']=$sheetRideCarState['SheetRideCarState']['note'];
                if($sheetRideCarState['SheetRideCarState']['car_state_value'] == 1){
                    $sheetRideCarStatesArray[$i]['depart_arrivee']='Depart';

                }else {
                    $sheetRideCarStatesArray[$i]['depart_arrivee']='Arrivee';
                }
                $i++;
            }
            $sheetRideCarStatesArray = json_encode($sheetRideCarStatesArray);
            $this->response->type('json');
            $this->response->body($sheetRideCarStatesArray);
            return $this->response;
        }
        else {
            echo 0; die();
        }
    }


    public function saveSheetRideCarState (){
        $attachment = $_POST['attachment'];
        $tmpName = $_POST['tmp_name'];
        $tmpName = base64_decode($tmpName);
        $note  = $_POST['note'];
        $sheetRideId  = $_POST['sheet_ride_id'];
        if(isset($_POST['id'])){
            $id  = $_POST['id'];
        }

        $carStateId  = $_POST['car_state_id'];
        $carStateValue  = $_POST['car_state_value'];
        $this->request->data['SheetRideCarState']['attachment'] = $attachment;
        $this->request->data['SheetRideCarState']['tmp_name'] = $tmpName;

        /*$this->verifyAttachmentByType('Attachment', $attachmentTypeId,
            'attachments/missions/' . $attachmentTypeId . '/', 'add', 0, 0, null);*/
        $root=dirname(__DIR__) . DS . "webroot" . DS . '/attachments/car_states/';
        // echo $root;
        file_put_contents($root, $tmpName);

        $sheetRideCarState = array();
        if(isset($id)){
            $sheetRideCarState['SheetRideCarState']['id'] = $id;
        }
        $sheetRideCarState['SheetRideCarState']['attachment'] = $attachment;
        $sheetRideCarState['SheetRideCarState']['note'] = $note;
        $sheetRideCarState['SheetRideCarState']['sheet_ride_id'] = $sheetRideId;
        $sheetRideCarState['SheetRideCarState']['car_state_id'] = $carStateId;
        $sheetRideCarState['SheetRideCarState']['car_state_value'] = $carStateValue;
        $this->SheetRideCarState->save($sheetRideCarState);

    }

    public function deleteSheetRideCarState($id){
        $this->SheetRideCarState->deleteAll(array('SheetRideCarState.id' => $id), false);

    }

    /**
     * retourner une destination à partir d'un mot clé
     */
    public function getSheetRidesByKeyWord()
    {
        $this->autoRender = false;
        $term = $this->request->query['q'];
        $term = trim(strtolower(($term)));
        $conds = array(
            " CONVERT(SheetRide.reference USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term%",
        );
        $sheetRides = $this->SheetRide->find('all',array('recursive'=>-1,
            'conditions'=>$conds, 'fields'=>array('id','reference')));
        $data = array();
        $i = 0;
        $data[$i]['id'] = "";
        $data[$i]['text'] = "";
        $i++;
        foreach ($sheetRides as $sheetRide) {
            $data[$i]['id'] = $sheetRide['SheetRide']['id'];
            $data[$i]['text'] = $sheetRide['SheetRide']['reference'] ;
            $i++;
        }

        echo json_encode($data);
    }

    public function printDeliveryProgram()
    {

        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        $array = filter_input(INPUT_POST, "printDeliveryProgram");

        $arrayConditions = explode(",", $array);

        $startDate = $arrayConditions[0];
        $endDate = $arrayConditions[1];
        $conditions = array();
        if (!empty($startDate)) {
            $date_from = str_replace("/", "-", $startDate);
            $start = str_replace("-", "/", $date_from);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $conditions["SheetRide.real_start_date >="] = $startdtm->format('Y-m-d 00:00:00');
        }
        if (!empty($endDate)) {
            $date_to = str_replace("/", "-", $endDate);
            $end = str_replace("-", "/", $date_to);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $conditions["SheetRide.real_start_date <="] = $enddtm->format('Y-m-d 23:59:00');
        }
        $ids = filter_input(INPUT_POST, "chkids");

        if (!empty($ids)) {


            $array_ids = explode(",", $ids);
            if (!empty($array_ids)) {
                $conditions["SheetRide.id"] = $array_ids;
            }
        }

        $sheetRides = $this->SheetRide->find('all', array(
            'recursive' => -1,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'group' => 'SheetRide.id',
            'fields' => array(
                'SheetRide.real_start_date',
                'SheetRide.id',
                'Car.code',
                'Car.immatr_def',
                'CarModels.name',
                'Suppliers.name',
                'Merchandises.name',
                'MerchandisesUnits.name',
                'MerchandisesUnits.name',
                'SheetRideDetailRideMarchandises.quantity',
                'Depart.name',
                'Arrival.name',
            ),
            'joins' => array(
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('SheetRide.car_id = Car.id')
                ),
                array(
                    'table' => 'sheet_ride_detail_rides',
                    'type' => 'left',
                    'alias' => 'SheetRidesDetailRides',
                    'conditions' => array('SheetRide.id = SheetRidesDetailRides.sheet_ride_id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Suppliers',
                    'conditions' => array('Suppliers.id = SheetRidesDetailRides.supplier_id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'CarModels',
                    'conditions' => array('CarModels.id = Car.carmodel_id')
                ),
                array(
                    'table' => 'sheet_ride_detail_ride_marchandises',
                    'type' => 'left',
                    'alias' => 'SheetRideDetailRideMarchandises',
                    'conditions' => array('SheetRideDetailRideMarchandises.sheet_ride_detail_ride_id = SheetRidesDetailRides.id')
                ),
                array(
                    'table' => 'marchandises',
                    'type' => 'left',
                    'alias' => 'Merchandises',
                    'conditions' => array('SheetRideDetailRideMarchandises.marchandise_id = Merchandises.id')
                ),
                array(
                    'table' => 'marchandise_units',
                    'type' => 'left',
                    'alias' => 'MerchandisesUnits',
                    'conditions' => array('MerchandisesUnits.id = Merchandises.marchandise_unit_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Depart',
                    'conditions' => array('Depart.id = SheetRidesDetailRides.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Arrival',
                    'conditions' => array('Arrival.id = SheetRidesDetailRides.arrival_destination_id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('SheetRide.customer_id = Customer.id')
                ),
            )
        ));
        $company = $this->Company->find('first');

        $this->set(compact('sheetRides','startDate','company'));

    }

    public function printDriverState()
    {

        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        $array = filter_input(INPUT_POST, "printDriverState");
        $conditions = filter_input(INPUT_POST, "conditions");
        if(!empty($conditions)){
            $conditions = '1 = 1 '.unserialize(base64_decode($conditions));
        }else {
            $arrayConditions = explode(",", $array);

            $carId = $arrayConditions[0] ;
            $customerId = $arrayConditions[1] ;
            $parcId = $arrayConditions[2] ;
            $rideId = $arrayConditions[3] ;
            $clientId = $arrayConditions[4] ;
            $statusId = $arrayConditions[5];
            $dateStart1 = $arrayConditions[8] ;
            $dateStart2 = $arrayConditions[9] ;
            $dateEnd1 = $arrayConditions[10] ;
            $dateEnd2 = $arrayConditions[11] ;

            $conditions = array();

            if (!empty($carId)) {
                $conditions["  SheetRide.car_id "] = $carId;
            }

            if (!empty($customerId)) {
                $conditions["SheetRide.customer_id "] = $customerId;
            }

            if (!empty($parcId)) {
                $conditions[" Car.parc_id "] = $parcId;
            }

            if (!empty($rideId)) {
                $conditions[" SheetRideDetailRides.detail_ride_id "] =  $rideId  ;
            }

            if (!empty($clientId)) {
                $conditions[" SheetRideDetailRides.supplier_id  "] = $clientId;
            }

            if (!empty($statusId)) {
                $conditions[" SheetRide.status_id "] = $statusId;
            }
            if (!empty($dateStart1)) {
                $date_from = str_replace("/", "-", $dateStart1);
                $start = str_replace("-", "/", $date_from);
                $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                $conditions["SheetRide.real_start_date >="] = $startdtm->format('Y-m-d 00:00:00');
            }
            if (!empty($dateStart2)) {
                $date_from = str_replace("/", "-", $dateStart2);
                $start = str_replace("-", "/", $date_from);
                $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                $conditions["SheetRide.real_start_date <="] = $startdtm->format('Y-m-d 00:00:00');
            }
            if (!empty($dateEnd1)) {
                $date_to = str_replace("/", "-", $dateEnd1);
                $end = str_replace("-", "/", $date_to);
                $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                $conditions["SheetRide.real_end_date >="] = $enddtm->format('Y-m-d 23:59:00');
            }
            if (!empty($dateEnd2)) {
                $date_to = str_replace("/", "-", $dateEnd2);
                $end = str_replace("-", "/", $date_to);
                $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                $conditions["SheetRide.real_end_date <="] = $enddtm->format('Y-m-d 23:59:00');
            }
        }

        $ids = filter_input(INPUT_POST, "chkids");

        if (!empty($ids)) {


            $array_ids = explode(",", $ids);
            if (!empty($array_ids)) {
                $conditions["SheetRide.id"] = $array_ids;
            }
        }

        $sheetRideDetailRides = $this->SheetRideDetailRides->find('all', array(
            'recursive' => -1,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'fields' => array(
                'SheetRideDetailRides.real_start_date',
                'Reservation.cost',
                'Customer.first_name',
                'Customer.last_name',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'CarType.name',
                'Supplier.code',
                'Supplier.name',
                'TransportBillDetailRides.unit_price',
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
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('SheetRide.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'parcs',
                    'type' => 'left',
                    'alias' => 'Parc',
                    'conditions' => array('Car.parc_id = Parc.id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('SheetRide.customer_id = Customer.id')
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
                    'table' => 'reservations',
                    'type' => 'left',
                    'alias' => 'Reservation',
                    'conditions' => array('Reservation.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
                ),
            )
        ));

        $separatorAmount = $this->getSeparatorAmount();

        $this->set(compact('sheetRideDetailRides','separatorAmount'));

    }


    public function printMissionOrder(){
        $this->setTimeActif();
        ini_set('memory_limit', '512M');

        $ids = filter_input(INPUT_POST, "chkids");

        if (!empty($ids)) {


            $array_ids = explode(",", $ids);
            if (!empty($array_ids)) {
                $conditions["SheetRide.id"] = $array_ids;
            }
        }
    }



    public function cancelSheetRides($ids = null , $model = null){
        $cancelCauses = $this->CancelCause->find('list');
        if ($this->request->is('post')){
            $sheetRidesIds = explode(',', $this->request->data['SheetRides']['sheet_rides_ids']);
            foreach ($sheetRidesIds as $id){
                $this->SheetRide->id = $id;
                $data['SheetRide']['status_id'] = StatusEnum::canceled;
                $data['SheetRide']['cancel_cause_id'] = $this->request->data['SheetRides']['cancel_cause_id'];
                $this->SheetRide->save($data);
            }
            $this->redirect(array('action' => 'index'));
        }
        $this->set(compact('cancelCauses','ids'));
    }






}
