<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'HTML2PDF');
App::uses('CakeTime', 'Utility');
App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'autoload.inc.php'));
use Dompdf\Dompdf;

/**
 *
 * /**
 * Transport Bill Controller
 *
 * @property CarType $CarType
 * @property ProductTypeFactor $ProductTypeFactor
 * @property Complaint $Complaint
 * @property TransportBillPenalty $TransportBillPenalty
 * @property Price $Price
 * @property Marchandise $Marchandise
 * @property ProductPrice $ProductPrice
 * @property dompdf $dompdf
 * @property Tva $Tva
 * @property Tonnage $Tonnage
 * @property User $User
 * @property Service $Service
 * @property RideCategory $RideCategory
 * @property TransportBill $TransportBill
 * @property Ride $Ride
 * @property Observation $Observation
 * @property Lot $Lot
 * @property Profile $Profile
 * @property DetailRide $DetailRide
 * @property Carmodel $Carmodel
 * @property Supplier $Supplier
 * @property Company $Company
 * @property TransportBillDetailRides $TransportBillDetailRides
 * @property Transformation $Transformation
 * @property PriceRideCategory $PriceRideCategory
 * @property DetailPayment $DetailPayment
 * @property Promotion $Promotion
 * @property Payment $Payment
 * @property Deadline $Deadline
 * @property PriceCategory $PriceCategory
 * @property Notification $Notification
 * @property Customer $Customer
 * @property Alert $Alert
 * @property Destination $Destination
 * @property CustomerCategory $CustomerCategory
 * @property SupplierContact $SupplierContact
 * @property TransportBillCategory $TransportBillCategory
 * @property SheetRideDetailRides $SheetRideDetailRides
 * @property CancelCause $CancelCause
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 * @property TransportBillDetailedRidesManagementComponent $TransportBillDetailedRidesManagement
 * @property TransportBillDetailedRides $TransportBillDetailedRides
 * @property SheetRideDetailRidesTransportBills $SheetRideDetailRidesTransportBills
 * @property DeleteTransportBillsManagementComponent $DeleteTransportBillsManagement
 * @property SaveTransportBillsComponent $SaveTransportBills
 */
class TransportBillsController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Security', 'RequestHandler');
    public $uses = array(
        'TransportBill',
        'Ride',
        'Complaint',
        'DetailRide',
        'Carmodel',
        'Tva',
        'ProductTypeFactor',
        'TransportBillPenalty',
        'TransportBillDetailRideFactor',
        'Tonnage',
        'Supplier',
        'Company',
        'CarType',
        'TransportBillDetailRides',
        'TransportBillDetailedRides',
        'Transformation',
        'Profile',
        'RideCategory',
        'Price',
        'PriceRideCategory',
        'DetailPayment',
        'SupplierContact',
        'Promotion',
        'Payment',
        'Observation',
        'TransportBillCategory',
        'Notification',
        'Deadline',
        'Customer',
        'Alert',
        'Destination',
        'CustomerCategory',
        'SheetRideDetailRides',
        'Lot',
        'PriceCategory',
        'ProductPrice',
        'Service',
        'CancelCause',
        'SheetRideDetailRidesTransportBills'
    );
    var $helpers = array('Xls', 'Tinymce');

    /**
     * index method
     *
     * @param int|null $type
     * @return void
     */

    public function index($type = null)
    {

        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        $searchConditions ='';
        if ($this->request->is('post')) {
            if (
                isset($this->request->data['transportBills']['supplier_id']) ||
                isset($this->request->data['transportBills']['service_id']) ||
                isset($this->request->data['transportBills']['status_id']) ||
                isset($this->request->data['transportBills']['order_type']) ||
                isset($this->request->data['transportBills']['date1']) ||
                isset($this->request->data['transportBills']['date2'])||
                isset($this->request->data['transportBills']['user_id'])||
                isset($this->request->data['transportBills']['created'])||
                isset($this->request->data['transportBills']['created1'])||
                isset($this->request->data['transportBills']['modified_id'])||
                isset($this->request->data['transportBills']['modified'])||
                isset($this->request->data['transportBills']['modified1'])
            ) {
                $supplier = $this->request->data['transportBills']['supplier_id'];
                if(isset($this->request->data['transportBills']['service_id'])){
                    $service = $this->request->data['transportBills']['service_id'];
                }
                if(isset($this->request->data['transportBills']['status_id'])){
                    $status = $this->request->data['transportBills']['status_id'];
                }
                if(isset($this->request->data['transportBills']['order_type'])){
                    $orderType = $this->request->data['transportBills']['order_type'];
                }
                if(isset($this->request->data['transportBills']['user_id'])){
                    $user = $this->request->data['transportBills']['user_id'];
                }
                if(isset($this->request->data['transportBills']['modified_id'])){
                    $modifier = $this->request->data['transportBills']['modified_id'];
                }
                $date_from = str_replace("/", "-", $this->request->data['transportBills']['date1']);
                $date_to = str_replace("/", "-", $this->request->data['transportBills']['date2']);
                if(isset($this->request->data['transportBills']['created'])) {
                    $created_from = str_replace("/", "-", $this->request->data['transportBills']['created']);
                }
                if(isset($this->request->data['transportBills']['created1'])) {
                    $created_to = str_replace("/", "-", $this->request->data['transportBills']['created1']);
                }
                if(isset($this->request->data['transportBills']['modified'])) {
                    $modified_from = str_replace("/", "-", $this->request->data['transportBills']['modified']);
                }
                if(isset($this->request->data['transportBills']['modified1'])) {
                    $modified_to = str_replace("/", "-", $this->request->data['transportBills']['modified1']);
                }
                if (!empty($supplier)) {
                    $searchConditions .= " && TransportBill.supplier_id = $supplier  ";
                }
                if (isset($user)&& !empty($user)) {
                    $searchConditions .= " && TransportBill.user_id = $user  ";
                }
                if (isset($modifier)&& !empty($modifier)) {
                    $searchConditions .= " && TransportBill.modified_id = $modifier  ";
                }
                if (isset($service)&&!empty($service)) {
                    $searchConditions .= " && Service.id = $service  ";
                }
                if (isset($status)&&!empty($status)) {
                    switch ($type){
                        case TransportBillTypesEnum::quote:
                        case TransportBillTypesEnum::quote_request:
                        case TransportBillTypesEnum::order:
                            $searchConditions .= " && TransportBill.status = $status  ";
                            break;
                        case TransportBillTypesEnum::pre_invoice:
                        case TransportBillTypesEnum::invoice:
                        case TransportBillTypesEnum::credit_note:
                            $searchConditions .= " && TransportBill.status_payment = $status  ";
                            break;
                        default:
                            $searchConditions .= " && TransportBill.status = $status  ";
                            break;
                    }
                }
                if (isset($orderType)&&!empty($orderType)) {
                    $searchConditions .= " && TransportBill.order_type = $orderType  ";
                }
                if (isset($date_from)&& !empty($date_from)) {
                    $start = str_replace("-", "/", $date_from);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $startdtm = $startdtm->format('Y-m-d 00:00:00');
                    $searchConditions .= " && TransportBill.date >= '$startdtm' ";
                }
                if (isset($date_to)&& !empty($date_to)) {
                    $end = str_replace("-", "/", $date_to);
                    $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                    $enddtm = $enddtm->format('Y-m-d 23:59:00');
                    $searchConditions .= " && TransportBill.date <= '$enddtm' ";
                }
                if (isset($created_from)&& !empty($created_from)) {
                    $start = str_replace("-", "/", $created_from);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $startdtm = $startdtm->format('Y-m-d 00:00:00');
                    $searchConditions .= " && TransportBill.created >= '$startdtm' ";
                }
                if (isset($created_to)&& !empty($created_to)) {
                    $end = str_replace("-", "/", $created_to);
                    $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                    $enddtm = $enddtm->format('Y-m-d 23:59:00');
                    $searchConditions .= " && TransportBill.created <= '$enddtm' ";
                }
                if (isset($modified_from)&&  !empty($modified_from)) {
                    $start = str_replace("-", "/", $modified_from);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $startdtm = $startdtm->format('Y-m-d 00:00:00');
                    $searchConditions .= " && TransportBill.modified >= '$startdtm' ";
                }
                if (isset($modified_to)&&  !empty($modified_to)) {
                    $end = str_replace("-", "/", $modified_to);
                    $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                    $enddtm = $enddtm->format('Y-m-d 23:59:00');
                    $searchConditions .= " && TransportBill.modified <= '$enddtm' ";
                }
            }
        }else {
            $searchConditions = '';
        }
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        $userId = $this->Auth->user('id');
        $this->Notification->updateInterIndexNotifications($type, $userId);
        $query = array();
        if ($type == TransportBillTypesEnum::quote_request) {
            $result = $this->verifyUserPermission(SectionsEnum::demande_de_devis, $userId, ActionsEnum::view, "TransportBills",
                null, "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::quote) {
            $result = $this->verifyUserPermission(SectionsEnum::devis, $userId, ActionsEnum::view, "TransportBills", null,
                "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::order) {
            $result = $this->verifyUserPermission(SectionsEnum::commande_client, $userId, ActionsEnum::view, "TransportBills",
                null, "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::pre_invoice) {
            $result = $this->verifyUserPermission(SectionsEnum::prefacture, $userId, ActionsEnum::view, "TransportBills", null,
                "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::invoice) {
            $result = $this->verifyUserPermission(SectionsEnum::facture, $userId, ActionsEnum::view, "TransportBills", null,
                "TransportBill", $type);
        }elseif ($type == TransportBillTypesEnum::credit_note) {
            $result = $this->verifyUserPermission(SectionsEnum::avoir_vente, $userId, ActionsEnum::view, "TransportBills", null,
                "TransportBill", $type);
        }
        if ($type == TransportBillTypesEnum::quote_request) {
            $permissionQuoteRequest = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transformer_demande_devis,
                ActionsEnum::view, $profileId, $roleId);
            $this->set('permissionQuoteRequest', $permissionQuoteRequest);
            $query['count'] =
                "SELECT COUNT(*) AS count FROM `transport_bills` AS `TransportBill` 
                  left JOIN `rides` AS `Ride` ON (`TransportBill`.`ride_id` = `Ride`.`id`) 
                  left JOIN `suppliers` AS `Supplier` ON (`TransportBill`.`supplier_id` = `Supplier`.`id`) 
                  left JOIN `suppliers` AS `SupplierFinal` ON (`TransportBill`.`supplier_final_id` = `SupplierFinal`.`id`) 
                  left JOIN `car_types` AS `CarType` ON (`TransportBill`.`car_type_id` = `CarType`.`id`) 
                  left JOIN `destinations` AS `DepartureDestination` ON (`DepartureDestination`.`id` = `Ride`.`departure_destination_id`) 
                  left JOIN `destinations` AS `ArrivalDestination` ON (`ArrivalDestination`.`id` = `Ride`.`arrival_destination_id`) 
                  left JOIN `transport_bill_detail_rides` AS `transportBillDetailRides` ON (`transportBillDetailRides`.`transport_bill_id` = `TransportBill`.`id`) 
                  left JOIN `users` AS `User` ON (`TransportBill`.`user_id` = `User`.`id`) 
                  left JOIN `services` AS `Service` ON (`Service`.`id` = `TransportBill`.`service_id`) 
                  WHERE 1=1 && " ;
            $query['detail'] =
                " SELECT `DepartureDestination`.`name`, `ArrivalDestination`.`name`, `Ride`.`wording`, 
                `Ride`.`distance`, `CarType`.`name`, `transportBillDetailRides`.`nb_trucks`, 
                 `TransportBill`.`nb_trucks`, `TransportBill`.`reference`, 
                `TransportBill`.`id`,`Ride`.`id`, `TransportBill`.`date`, `TransportBill`.`total_ttc`, 
                `TransportBill`.`total_ht`, 
                `TransportBill`.`total_tva`, `TransportBill`.`type`, `TransportBill`.`status`, 
                `TransportBill`.`locked`, `Supplier`.`name`, `SupplierFinal`.`name`,  
                `TransportBill`.`service_id`, `Service`.`name` FROM `transport_bills` AS `TransportBill` 
                left JOIN `rides` AS `Ride` ON (`TransportBill`.`ride_id` = `Ride`.`id`) 
                left JOIN `suppliers` AS `Supplier` ON (`TransportBill`.`supplier_id` = `Supplier`.`id`) 
                left JOIN `suppliers` AS `SupplierFinal` ON (`TransportBill`.`supplier_final_id` = `SupplierFinal`.`id`) 
                left JOIN `car_types` AS `CarType` ON (`TransportBill`.`car_type_id` = `CarType`.`id`) 
                left JOIN `destinations` AS `DepartureDestination` ON (`DepartureDestination`.`id` = `Ride`.`departure_destination_id`) 
                left JOIN `destinations` AS `ArrivalDestination` ON (`ArrivalDestination`.`id` = `Ride`.`arrival_destination_id`) 
                left JOIN `transport_bill_detail_rides` AS `transportBillDetailRides` ON (`transportBillDetailRides`.`transport_bill_id` = `TransportBill`.`id`) 
                left JOIN `users` AS `User` ON (`TransportBill`.`user_id` = `User`.`id`) 
                left JOIN `services` AS `Service` ON (`Service`.`id` = `TransportBill`.`service_id`) WHERE 1=1 && ";
            if($profileId == ProfilesEnum::client){
                $query['columns'] = array(
                    0 => array('TransportBill.reference','TransportBill', 'reference', 'Reference', 'string',''),
                    1 => array('TransportBill.date','TransportBill', 'date', 'Date', 'date',''),
                    2 => array('TransportBill.status','TransportBill', 'status', 'Status', 'number',''),
                );
            } else {
                $query['columns'] = array(
                    0 => array('TransportBill.reference','TransportBill', 'reference', 'Reference', 'string',''),
                    1 => array('TransportBill.date','TransportBill', 'date', 'Date', 'date',''),
                    2 => array('Supplier.name','Supplier', 'name','Initial customer', 'string',''),
                    3 => array('Service.name','Service', 'name', 'Service', 'string',''),
                    4 => array('SupplierFinal.name','SupplierFinal', 'name','Final customer', 'string',''),
                    5 => array('Ride.id','Ride', 'id','Ride', 'string','CONCAT','DepartureDestination.name','ArrivalDestination.name'),
                    6 => array('TransportBill.total_ht','TransportBill', 'total_ht', 'Total Ht', 'number',''),
                    7=> array('TransportBill.total_tva','TransportBill', 'total_tva', 'Total Tva', 'number',''),
                    8 => array('TransportBill.total_ttc','TransportBill', 'total_ttc', 'Total Ttc', 'number',''),
                    9 => array('TransportBill.status','TransportBill', 'status', 'Status', 'number',''),
                     );
            }
            $query['order'] = ' TransportBill.reference desc , TransportBill.date desc';
        } else {
            switch ($type) {
                case TransportBillTypesEnum::quote :
                    $permissionQuote = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transformer_devis,
                        ActionsEnum::view, $profileId, $roleId);

                    $printQuote = $this->AccessPermission->getPermissionWithParams(SectionsEnum::devis,
                        ActionsEnum::printing, $profileId, $roleId);

                    $this->set(compact('permissionQuote', 'printQuote'));
                    break;
                case TransportBillTypesEnum::order :
                    $permissionOrder = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transmettre_commande_client,
                        ActionsEnum::view, $profileId, $roleId);

                    $permissionCancel = $this->AccessPermission->getPermissionWithParams(SectionsEnum::annuler_commande_client,
                        ActionsEnum::view, $profileId, $roleId);

                    $printOrder = $this->AccessPermission->getPermissionWithParams(SectionsEnum::commande_client,
                        ActionsEnum::printing, $profileId, $roleId);

                    //$this->TransportBill->updateStatusCustomerOrders();
                    $this->set(compact('permissionOrder', 'permissionCancel','printOrder'));
                    break;
                case TransportBillTypesEnum::pre_invoice :
                    $permissionPreinvoice = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transformer_prefacture,
                        ActionsEnum::view, $profileId, $roleId);
                    $printPreinvoice = $this->AccessPermission->getPermissionWithParams(SectionsEnum::prefacture,
                        ActionsEnum::printing, $profileId, $roleId);
                    $this->set(compact('permissionPreinvoice', 'printPreinvoice'));
                    break;
                case TransportBillTypesEnum::invoice :
                    $permissionPayment = $this->AccessPermission->getPermissionWithParams(SectionsEnum::paiement,
                        ActionsEnum::view, $profileId, $roleId);
                    $printInvoice = $this->AccessPermission->getPermissionWithParams(SectionsEnum::facture,
                        ActionsEnum::printing, $profileId, $roleId);
                    $this->set(compact('permissionPayment', 'printInvoice'));
                    break;
                case TransportBillTypesEnum::credit_note :
                    $permissionPayment = $this->AccessPermission->getPermissionWithParams(SectionsEnum::paiement,
                        ActionsEnum::view, $profileId, $roleId);
                    $this->set(compact('permissionPayment'));
                    break;
            }
            $query['count'] =
                "SELECT COUNT(*) AS count FROM `transport_bills` AS `TransportBill` 
                left JOIN `detail_rides` AS `DetailRide` ON (`TransportBill`.`detail_ride_id` = `DetailRide`.`id`) 
                left JOIN `suppliers` AS `Supplier` ON (`TransportBill`.`supplier_id` = `Supplier`.`id`) 
                left JOIN `suppliers` AS `SupplierFinal` ON (`TransportBill`.`supplier_final_id` = `SupplierFinal`.`id`) 
                left JOIN `rides` AS `Ride` ON (`DetailRide`.`ride_id` = `Ride`.`id`) 
                left JOIN `car_types` AS `CarType` ON (`DetailRide`.`car_type_id` = `CarType`.`id`) 
                left JOIN `destinations` AS `DepartureDestination` ON (`DepartureDestination`.`id` = `Ride`.`departure_destination_id`) 
                left JOIN `destinations` AS `ArrivalDestination` ON (`ArrivalDestination`.`id` = `Ride`.`arrival_destination_id`) 
                left JOIN `users` AS `User` ON (`TransportBill`.`user_id` = `User`.`id`) 
                left JOIN `services` AS `Service` ON (`Service`.`id` = `TransportBill`.`service_id`) 
                left JOIN `cancel_causes` AS `CancelCause` ON (`TransportBill`.`cancel_cause_id` = `CancelCause`.`id`) 
                WHERE  1=1 && " ;
            $query['detail'] =
                "SELECT ";
            if($type ==TransportBillTypesEnum::order &&
                configure::read("reclamation")=='1'){
                    $query['detail'] =  $query['detail']. "	`TransportBill`.`nb_complaints_by_missions`,
                    `TransportBill`.`nb_complaints_by_orders`,";
            }
            $query['detail'] =  $query['detail']." `TransportBill`.`reference`, `TransportBill`.`id`, `TransportBill`.`date`, `TransportBill`.`total_ttc`, 
                    `TransportBill`.`total_ht`, `TransportBill`.`status_payment`, `TransportBill`.`locked`,
                    `TransportBill`.`total_tva`, `TransportBill`.`amount_remaining`, `TransportBill`.`type`, `TransportBill`.`status`, 
                    `CancelCause`.`name`, `Supplier`.`name`,  `Service`.`name` FROM `transport_bills` AS `TransportBill` 
                    left JOIN `detail_rides` AS `DetailRide` ON (`TransportBill`.`detail_ride_id` = `DetailRide`.`id`) 
                    left JOIN `suppliers` AS `Supplier` ON (`TransportBill`.`supplier_id` = `Supplier`.`id`) 
                    left JOIN `suppliers` AS `SupplierFinal` ON (`TransportBill`.`supplier_final_id` = `SupplierFinal`.`id`)                   
                    left JOIN `users` AS `User` ON (`TransportBill`.`user_id` = `User`.`id`) 
                    left JOIN `services` AS `Service` ON (`Service`.`id` = `TransportBill`.`service_id`) 
                    left JOIN `cancel_causes` AS `CancelCause` ON (`TransportBill`.`cancel_cause_id` = `CancelCause`.`id`) 
                    WHERE 1=1 && ";
            $query['order'] = ' TransportBill.reference desc ,TransportBill.date desc';
            if($profileId == ProfilesEnum::client){
                $query['columns'] = array(
                    0 => array('TransportBill.reference','TransportBill', 'reference', 'Reference', 'string',''),
                    1 => array('TransportBill.date','TransportBill', 'date', 'Date', 'date',''),
                    2 => array('TransportBill.status','TransportBill', 'status', 'Status', 'number',''),
                );
            }else {
                if($type==TransportBillTypesEnum::order){
                    if (Configure::read("reclamation") == '1') {
                        $query['columns'] = array(
                            0 => array('TransportBill.reference','TransportBill', 'reference', 'Reference', 'string',''),
                            1 => array('TransportBill.date','TransportBill', 'date', 'Date', 'date',''),
                            2 => array('Supplier.name','Supplier', 'name','Initial customer', 'string',''),
                            3 => array('Service.name','Service', 'name', 'Service', 'string',''),
                            4 => array('TransportBill.total_ht','TransportBill', 'total_ht', 'Total Ht', 'number',''),
                            5 => array('TransportBill.total_tva','TransportBill', 'total_tva', 'Total Tva', 'number',''),
                            6 => array('TransportBill.total_ttc','TransportBill', 'total_ttc', 'Total Ttc', 'number',''),
                            7 => array('TransportBill.status','TransportBill', 'status', 'Status', 'number',''),
                            8 => array('TransportBill.nb_complaints_by_orders','TransportBill', 'nb_complaints_by_orders', 'Nb complaints orders', 'number',''),
                            9 => array('TransportBill.nb_complaints_by_missions','TransportBill', 'nb_complaints_by_missions', 'Nb complaints missions', 'number',''),

                        );
                    }else {
                        $query['columns'] = array(
                            0 => array('TransportBill.reference','TransportBill', 'reference', 'Reference', 'string',''),
                            1 => array('TransportBill.date','TransportBill', 'date', 'Date', 'date',''),
                            2 => array('Supplier.name','Supplier', 'name','Initial customer', 'string',''),
                            3 => array('Service.name','Service', 'name', 'Service', 'string',''),
                            4 => array('TransportBill.total_ht','TransportBill', 'total_ht', 'Total Ht', 'number',''),
                            5 => array('TransportBill.total_tva','TransportBill', 'total_tva', 'Total Tva', 'number',''),
                            6 => array('TransportBill.total_ttc','TransportBill', 'total_ttc', 'Total Ttc', 'number',''),
                            7 => array('TransportBill.status','TransportBill', 'status', 'Status', 'number',''),

                        );
                    }

                }else {
                    $query['columns'] = array(
                        0 => array('TransportBill.reference','TransportBill', 'reference', 'Reference', 'string',''),
                        1 => array('TransportBill.date','TransportBill', 'date', 'Date', 'date',''),
                        2 => array('Supplier.name','Supplier', 'name','Initial customer', 'string',''),
                        3 => array('Service.name','Service', 'name', 'Service', 'string',''),
                        4 => array('TransportBill.total_ht','TransportBill', 'total_ht', 'Total Ht', 'number',''),
                        5 => array('TransportBill.total_tva','TransportBill', 'total_tva', 'Total Tva', 'number',''),
                        6 => array('TransportBill.total_ttc','TransportBill', 'total_ttc', 'Total Ttc', 'number',''),
                        7 => array('TransportBill.status','TransportBill', 'status', 'Status', 'number',''),
                          );
                }

            }

        }
        $query['conditions'] = $searchConditions;
        $query['tableName'] = 'TransportBill';
        $query['controller'] = 'transportBills';
        $query['itemName'] = array('reference');
        $query['action'] = 'index';
       // $query['type'] = $this->params['pass']['0'];

        $this->Session->write('query', $query);
        //get default user limit value
        $defaultLimit =  $this->getLimit();;
        if (isset($defaultLimit) && $defaultLimit > 0) {
            $this->set('defaultLimit', $defaultLimit);
               } else {
            $this->set('defaultLimit', 20);
            }
        $controller =  'transportBills';
        $action = 'index';
        $deleteFonction =  'deleteTransportBills/'.$type.'/';
        $profileId = $this->Auth->user('profile_id');
        $isSuperAdmin = $this->isSuperAdmin();
        $hasTreasuryModule = $this->hasModuleTresorerie();
        $reportingChoosed = $this->reportingChoosed();
        $this->Session->write('reportingChoosed', $reportingChoosed);
        if ($reportingChoosed == 3) {
            $informationJasperReport = $this->Parameter->getInformationJasperReport();
            $this->set('informationJasperReport', $informationJasperReport);
            $this->Session->write('informationJasperReport', $informationJasperReport);
        }
        $settleMissions = $this->abilityToSettleMissions();
        $users = $this->User->getUsers();
        if ($profileId == ProfilesEnum::client) {
            $supplierId = intval($this->Auth->user('supplier_id'));
            $this->set('supplierId', $supplierId);
        }
        $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
        $this->set(compact('type','profileId','isSuperAdmin','controller','deleteFonction',
            'hasTreasuryModule','settleMissions','action','users','totals','suppliers'));
    }


    public function getOrder($params = null , $orderType = null)
    {
        if($orderType == null){
            $orderType = 'DESC';
        }
        if (isset($params) && is_numeric($params)) {
            switch ($params) {
                case 1 :
                    $order = array('TransportBill.reference' => $orderType);
                    break;
                case 2 :
                    $order = array('TransportBill.id' => $orderType);
                    break;
                case 3 :
                    $order = array('TransportBill.date' => $orderType);
                    break;
                default :
                    $order = array('TransportBill.reference' => $orderType);
            }
            return $order;
        } else {
            $order = array('TransportBill.reference' => $orderType);
            return $order;
        }
    }

    /**
     * search method
     *
     * @return void
     */
    public function search()
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        $profileId = $this->Auth->user('profile_id');
        if (isset($this->request->data['keyword']) || isset($this->request->data['TransportBills']['user_id']) ||
            isset($this->request->data['TransportBills']['modified_id'])
            || isset($this->request->data['TransportBills']['created'])
            || isset($this->request->data['TransportBills']['created1'])
            || isset($this->request->data['TransportBills']['modified'])
            || isset($this->request->data['TransportBills']['modified1'])
            || isset($this->request->data['TransportBills']['date1'])
            || isset($this->request->data['TransportBills']['date2'])
            || isset($this->request->data['TransportBills']['detail_ride_id'])
            || isset($this->request->data['TransportBills']['ride_id'])
            || isset($this->request->data['TransportBills']['car_type_id'])
            || isset($this->request->data['TransportBills']['service_id'])
            || isset($this->request->data['TransportBills']['supplier_id'])
            || isset($this->request->data['TransportBills']['type'])
        ) {
            $this->filterUrl();
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('TransportBill.reference' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword']) || isset($this->params['named']['user'])
            || isset($this->params['named']['service']) || isset($this->params['named']['created'])
            || isset($this->params['named']['created1']) || isset($this->params['named']['ride'])
            || isset($this->params['named']['modified_id']) || isset($this->params['named']['supplier'])
            || isset($this->params['named']['type']) || isset($this->params['named']['car_type'])
            || isset($this->params['named']['modified']) || isset($this->params['named']['modified1'])
            || isset($this->params['named']['date1']) || isset($this->params['named']['date2'])
        ) {
            $this->Security->blackHoleCallback = 'blackhole';
            $type = $this->params['named']['type'];
            $userId = $this->Auth->user('id');
            $this->Notification->updateInterIndexNotifications($type, $userId);
            $generalConditions = $this->getTransportBillGeneralConditions($type);
            $conditions = $this->getConds();
            if ($conditions != null) {
                $conditions = array_merge($conditions, $generalConditions);
            } else {
                $conditions = $generalConditions;
            }
            $roleId = $this->Auth->user('role_id');
            if ($type == TransportBillTypesEnum::quote_request) {

                $permissionQuoteRequest = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transformer_demande_devis,
                    ActionsEnum::view, $profileId);
                $this->set('permissionQuoteRequest', $permissionQuoteRequest);
                $this->paginate = array(
                    'limit' => $limit,
                    'order' => $order,
                    'recursive' => -1,
                    'conditions' => $conditions,
                    'paramType' => 'querystring',
                    'fields' => array(
                        'DepartureDestination.name',
                        'ArrivalDestination.name',
                        'Ride.wording',
                        'Ride.distance',
                        'CarType.name',
                        'transportBillDetailRides.nb_trucks',
                        'TransportBill.total_weight',
                        'TransportBill.nb_trucks',
                        'TransportBill.reference',
                        'TransportBill.id',
                        'TransportBill.date',
                        'TransportBill.total_ttc',
                        'TransportBill.total_ht',
                        'TransportBill.total_tva',
                        'TransportBill.type',
                        'TransportBill.status',
                        'TransportBill.status_payment',
                        'TransportBill.payment_type',
                        'TransportBill.payment_date',
                        'TransportBill.amount_remaining',
                        'Supplier.name',
                        'Supplier.adress',
                        'Supplier.tel',
                        'Supplier.contact',
                        'Supplier.email',
                        'SupplierFinal.name',
                        'SupplierFinal.adress',
                        'SupplierFinal.tel',
                        'SupplierFinal.contact',
                        'SupplierFinal.email',
                        'TransportBill.service_id',
                        'Service.name',

                    ),
                    'joins' => array(
                        array(
                            'table' => 'rides',
                            'type' => 'left',
                            'alias' => 'Ride',
                            'conditions' => array('TransportBill.ride_id = Ride.id')
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
                            'conditions' => array('TransportBill.supplier_final_id = SupplierFinal.id')
                        ),
                        array(
                            'table' => 'car_types',
                            'type' => 'left',
                            'alias' => 'CarType',
                            'conditions' => array('TransportBill.car_type_id = CarType.id')
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
                            'table' => 'transport_bill_detail_rides',
                            'type' => 'left',
                            'alias' => 'transportBillDetailRides',
                            'conditions' => array('transportBillDetailRides.transport_bill_id = TransportBill.id')
                        ),
                        array(
                            'table' => 'users',
                            'type' => 'left',
                            'alias' => 'User',
                            'conditions' => array('TransportBill.user_id = User.id')
                        ),
                        array(
                            'table' => 'services',
                            'type' => 'left',
                            'alias' => 'Service',
                            'conditions' => array('Service.id = TransportBill.service_id')
                        )

                    )
                );
            } else {
                switch ($type) {
                    case TransportBillTypesEnum::quote :
                        $permissionQuote = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transformer_devis,
                            ActionsEnum::view, $profileId, $roleId);
                        $this->set('permissionQuote', $permissionQuote);
                        break;
                    case TransportBillTypesEnum::order :
                        $permissionOrder = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transmettre_commande_client,
                            ActionsEnum::view, $profileId, $roleId);

                        $permissionCancel = $this->AccessPermission->getPermissionWithParams(SectionsEnum::annuler_commande_client,
                            ActionsEnum::view, $profileId, $roleId);
                        $this->set(compact('permissionOrder', 'permissionCancel'));
                        break;
                    case TransportBillTypesEnum::pre_invoice :
                        $permissionPreinvoice = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transformer_prefacture,
                            ActionsEnum::view, $profileId, $roleId);
                        $this->set('permissionPreinvoice', $permissionPreinvoice);
                        break;
                }

                $this->paginate = array(
                    'limit' => $limit,
                    'order' => $order,
                    'recursive' => -1,
                    'conditions' => $conditions,
                    'paramType' => 'querystring',
                    'fields' => array(
                        'DepartureDestination.name',
                        'ArrivalDestination.name',
                        'Ride.wording',
                        'Ride.distance',
                        'CarType.name',
                        'TransportBill.id',
                        'TransportBill.reference',
                        'TransportBill.id',
                        'TransportBill.date',
                        'TransportBill.total_ttc',
                        'TransportBill.total_ht',
                        'TransportBill.total_tva',
                        'TransportBill.amount_remaining',
                        'TransportBill.type',
                        'TransportBill.status',
                        'TransportBill.status_payment',
                        'TransportBill.payment_type',
                        'TransportBill.payment_date',
                        'Supplier.name',
                        'Supplier.adress',
                        'Supplier.tel',
                        'Supplier.contact',
                        'Supplier.email',
                        'SupplierFinal.name',
                        'SupplierFinal.adress',
                        'SupplierFinal.tel',
                        'SupplierFinal.contact',
                        'SupplierFinal.email',
                        'TransportBill.service_id',
                        'Service.name',
                    ),
                    'joins' => array(
                        array(
                            'table' => 'detail_rides',
                            'type' => 'left',
                            'alias' => 'DetailRide',
                            'conditions' => array('TransportBill.detail_ride_id = DetailRide.id')
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
                            'conditions' => array('TransportBill.supplier_final_id = SupplierFinal.id')
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
                            'table' => 'users',
                            'type' => 'left',
                            'alias' => 'User',
                            'conditions' => array('TransportBill.user_id = User.id')
                        ),
                        array(
                            'table' => 'services',
                            'type' => 'left',
                            'alias' => 'Service',
                            'conditions' => array('Service.id = TransportBill.service_id')
                        )
                    )
                );

            }

            $settleMissions = $this->abilityToSettleMissions();
            $transportBills = $this->Paginator->paginate('TransportBill');

            $this->set(compact('transportBills', 'settleMissions', 'totals'));


        } else {
            $this->TransportBill->recursive = 0;
            $this->set('transportBills', $this->Paginator->paginate('TransportBill'));
            $settleMissions = $this->abilityToSettleMissions();
            $this->set('settleMissions', $settleMissions);
        }


        $users = $this->User->getUsers();
        $profiles = $this->Profile->getUserProfiles();
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        if ($profileId == ProfilesEnum::client) {
            $supplierId = intval($this->Auth->user('supplier_id'));
            $this->set('supplierId', $supplierId);
        }
        $carTypes = $this->CarType->getCarTypes();
        $this->set(compact('users', 'carTypes', 'rides'));
        $separatorAmount = $this->getSeparatorAmount();
        $hasTreasuryModule = $this->hasModuleTresorerie();
        $isSuperAdmin = $this->isSuperAdmin();
        $reportingChoosed = $this->reportingChoosed();
        if ($reportingChoosed == 3) {
            $informationJasperReport = $this->Parameter->getInformationJasperReport();
            $this->set('informationJasperReport', $informationJasperReport);
        }
        $services = $this->Service->getServices('list');
        $this->set(compact('profiles', 'limit', 'type', 'separatorAmount', 'services',
            'order', 'hasTreasuryModule', 'isSuperAdmin', 'reportingChoosed'));
        $this->render();
    }

    private function filterUrl()
    {
        $filter_url['controller'] = $this->request->params['controller'];
        $filter_url['action'] = $this->request->params['action'];
        $filter_url['page'] = 1;
        if(isset($this->request->data['TransportBills']['type'])){
            $filter_url['type'] = $this->request->data['TransportBills']['type'];
        }
        if(isset($this->request->data['keyword'])){
            $filter_url['keyword'] = $this->request->data['keyword'];
            $filter_url['keyword'] = str_replace('/', '-', $filter_url['keyword']);
        }
        if (isset($this->request->data['TransportBills']['supplier_id']) && !empty($this->request->data['TransportBills']['supplier_id'])) {
            $filter_url['supplier'] = $this->request->data['TransportBills']['supplier_id'];
        }

        if (isset($this->request->data['TransportBills']['car_type_id']) && !empty($this->request->data['TransportBills']['car_type_id'])) {
            $filter_url['car_type'] = $this->request->data['TransportBills']['car_type_id'];
        }
        if (isset($this->request->data['TransportBills']['ride_id']) && !empty($this->request->data['TransportBills']['ride_id'])) {
            $filter_url['ride'] = $this->request->data['TransportBills']['ride_id'];
        }
        if (isset($this->request->data['TransportBills']['user_id']) && !empty($this->request->data['TransportBills']['user_id'])) {
            $filter_url['user'] = $this->request->data['TransportBills']['user_id'];
        }
        if (isset($this->request->data['TransportBills']['service_id']) && !empty($this->request->data['TransportBills']['service_id'])) {
            $filter_url['service'] = $this->request->data['TransportBills']['service_id'];
        }
        if (isset($this->request->data['TransportBills']['created']) && !empty($this->request->data['TransportBills']['created'])) {
            $filter_url['created'] = str_replace("/", "-", $this->request->data['TransportBills']['created']);
        }
        if (isset($this->request->data['TransportBills']['created1']) && !empty($this->request->data['TransportBills']['created1'])) {
            $filter_url['created1'] = str_replace("/", "-", $this->request->data['TransportBills']['created1']);
        }
        if (isset($this->request->data['TransportBills']['modified_id']) && !empty($this->request->data['TransportBills']['modified_id'])) {
            $filter_url['modified_id'] = $this->request->data['TransportBills']['modified_id'];
        }
        if (isset($this->request->data['TransportBills']['modified']) && !empty($this->request->data['TransportBills']['modified'])) {
            $filter_url['modified'] = str_replace("/", "-", $this->request->data['TransportBills']['modified']);
        }
        if (isset($this->request->data['TransportBills']['modified1']) && !empty($this->request->data['TransportBills']['modified1'])) {
            $filter_url['modified1'] = str_replace("/", "-", $this->request->data['TransportBills']['modified1']);
        }
        if (isset($this->request->data['TransportBills']['date1']) && !empty($this->request->data['TransportBills']['date1'])) {
            $filter_url['date1'] = str_replace("/", "-", $this->request->data['TransportBills']['date1']);
        }
        if (isset($this->request->data['TransportBills']['date2']) && !empty($this->request->data['TransportBills']['date2'])) {
            $filter_url['date2'] = str_replace("/", "-", $this->request->data['TransportBills']['date2']);
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
                    "LOWER(TransportBill.reference) LIKE" => "%$keyword%"
                )
            );
        } else {
            $conds = array();
        }
        if(isset($this->params['named']['type'])){
            $conds["TransportBill.type = "] = $this->params['named']['type'];
            $this->request->data['TransportBills']['type'] = $this->params['named']['type'];
        }
        if (isset($this->params['named']['ride']) && !empty($this->params['named']['ride'])) {
            if ($this->params['named']['type'] == 0) {
                $conds["TransportBill.ride_id = "] = $this->params['named']['ride'];
            } else {
                $conds["DetailRide.ride_id = "] = $this->params['named']['ride'];
            }
            $this->request->data['TransportBills']['ride_id'] = $this->params['named']['ride'];
        }
        $profileId = $this->Auth->user('profile_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        if ($profileId == ProfilesEnum::client) {
            if (isset($this->params['named']['supplier']) && !empty($this->params['named']['supplier'])) {
                $conds["TransportBill.supplier_final_id = "] = $this->params['named']['supplier'];
                $this->request->data['TransportBills']['supplier_id'] = $this->params['named']['supplier'];
            }
        } else {
            if (isset($this->params['named']['supplier']) && !empty($this->params['named']['supplier'])) {
                $conds["TransportBill.supplier_id = "] = $this->params['named']['supplier'];
                $this->request->data['TransportBills']['supplier_id'] = $this->params['named']['supplier'];
            }
        }

        if (isset($this->params['named']['car_type']) && !empty($this->params['named']['car_type'])) {
            $conds["TransportBill.car_type_id = "] = $this->params['named']['car_type'];
            $this->request->data['TransportBills']['car_type_id'] = $this->params['named']['car_type'];
        }

        if (isset($this->params['named']['service']) && !empty($this->params['named']['service'])) {
            $conds["TransportBill.service_id = "] = $this->params['named']['service'];
            $this->request->data['TransportBills']['service_id'] = $this->params['named']['service'];
        }

        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $conds["TransportBill.user_id = "] = $this->params['named']['user'];
            $this->request->data['TransportBills']['user_id'] = $this->params['named']['user'];
        }

        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $creat = str_replace("-", "/", $this->params['named']['created']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["TransportBill.created >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['TransportBills']['created'] = $creat;
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $creat = str_replace("-", "/", $this->params['named']['created1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["TransportBill.created <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['TransportBills']['created1'] = $creat;
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $conds["TransportBill.modified_id = "] = $this->params['named']['modified_id'];
            $this->request->data['TransportBills']['modified_id'] = $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["TransportBill.modified >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['TransportBills']['modified'] = $creat;
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["TransportBill.modified <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['TransportBills']['modified1'] = $creat;
        }
        if (isset($this->params['named']['date1']) && !empty($this->params['named']['date1'])) {
            $creat = str_replace("-", "/", $this->params['named']['date1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["TransportBill.date >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['TransportBills']['date1'] = $creat;
        }
        if (isset($this->params['named']['date2']) && !empty($this->params['named']['date2'])) {
            $creat = str_replace("-", "/", $this->params['named']['date2']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["TransportBill.date <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['TransportBills']['date2'] = $creat;
        }

        return $conds;
    }

    /**
     * view method
     *
     * @param int|null $type
     * @param int|null $id
     * @return void
     */
    public function view($type = null, $id = null)
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        if (!$this->TransportBill->exists($id)) {
            throw new NotFoundException(__('Invalid transport bill'));
        }
        $conditions = array('Notification.transport_bill_id' => $id);
        $this->Notification->UpdateStatusNotifications($conditions);
        $this->getNbNotificationsByUser();
        $profileId = $this->Auth->user('profile_id');
        $this->set('profileId', $profileId);
        if ($type == TransportBillTypesEnum::quote_request) {
            $roleId = $this->Auth->user('role_id');
            $permissionQuoteRequest = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transformer_demande_devis,
                ActionsEnum::view, $profileId, $roleId);
            $this->set('permissionQuoteRequest', $permissionQuoteRequest);
            $options = array(
                'conditions' => array('TransportBill.' . $this->TransportBill->primaryKey => $id),
                'recursive' => -1,
                'fields' => array(
                    'DepartureDestination.name',
                    'ArrivalDestination.name',
                    'Departure.name',
                    'Arrival.name',
                    'Ride.wording',
                    'Ride.distance',
                    'CarType.name',
                    'Type.name',
                    'TransportBill.reference',
                    'TransportBill.date',
                    'TransportBill.created',
                    'TransportBill.modified',
                    'TransportBill.id',
                    'TransportBill.nb_trucks',
                    'TransportBill.total_weight',
                    'TransportBill.type',
                    'Supplier.name',
                    'SupplierFinal.name',
                    'Supplier.adress',
                    'Supplier.tel',
                    'User.first_name',
                    'User.last_name',
                    'Modifier.first_name',
                    'Modifier.last_name',
                ),
                'joins' => array(
                    array(
                        'table' => 'rides',
                        'type' => 'left',
                        'alias' => 'Ride',
                        'conditions' => array('TransportBill.ride_id = Ride.id')
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
                        'conditions' => array('TransportBill.supplier_final_id = SupplierFinal.id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'CarType',
                        'conditions' => array('TransportBill.car_type_id = CarType.id')
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
                        'table' => 'transport_bill_detail_rides',
                        'type' => 'left',
                        'alias' => 'TransportBillDetailRides',
                        'conditions' => array('TransportBillDetailRides.transport_bill_id =TransportBill.id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'Type',
                        'conditions' => array('TransportBillDetailRides.car_type_id =Type.id')
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
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('TransportBill.user_id = User.id')
                    ),
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'Modifier',
                        'conditions' => array('TransportBill.modified_id = Modifier.id')
                    ),


                )
            );

            $newTransportBill = $this->Transformation->find('first',
                array(
                    'conditions' => array('Transformation.origin_transport_bill_id' => $id),
                    'recursive' => -1,
                    'fields' => array(

                        'TransportBill.reference',

                    ),
                    'joins' => array(
                        array(
                            'table' => 'transport_bills',
                            'type' => 'left',
                            'alias' => 'TransportBill',
                            'conditions' => array('TransportBill.id = Transformation.new_transport_bill_id')
                        )
                    )
                )
            );

            $this->set('newTransportBill', $newTransportBill);

        } else {
            $options = array(
                'conditions' => array('TransportBill.' . $this->TransportBill->primaryKey => $id),
                'recursive' => -1,
                'fields' => array(
                    'DepartureDestination.name',
                    'ArrivalDestination.name',
                    'Ride.wording',
                    'Ride.distance',
                    'CarType.name',
                    'TransportBill.reference',
                    'TransportBill.date',
                    'TransportBill.created',
                    'TransportBill.modified',
                    'TransportBill.id',
                    'TransportBill.type',
                    'TransportBill.total_ht',
                    'TransportBill.total_tva',
                    'TransportBill.total_ttc',
                    'TransportBill.status',
                    'TransportBill.payment_type',
                    'TransportBill.payment_date',
                    'Supplier.name',
                    'SupplierFinal.name',
                    'Supplier.adress',
                    'Supplier.tel',
                    'User.first_name',
                    'User.last_name',
                    'Modifier.first_name',
                    'Modifier.last_name',
                ),
                'joins' => array(
                    array(
                        'table' => 'detail_rides',
                        'type' => 'left',
                        'alias' => 'DetailRide',
                        'conditions' => array('TransportBill.detail_ride_id = DetailRide.id')
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
                        'conditions' => array('TransportBill.supplier_final_id = SupplierFinal.id')
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
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('TransportBill.user_id = User.id')
                    ),
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'Modifier',
                        'conditions' => array('TransportBill.modified_id = Modifier.id')
                    ),
                )
            );
            $roleId = $this->Auth->user('role_id');
            switch ($type) {
                case $type == TransportBillTypesEnum::quote :
                    $permissionQuote = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transformer_devis,
                        ActionsEnum::view, $profileId, $roleId);

                    $this->set('permissionQuote', $permissionQuote);
                    $originTransportBill = $this->Transformation->find('first',
                        array(
                            'conditions' => array('Transformation.new_transport_bill_id' => $id),
                            'recursive' => -1,
                            'fields' => array(

                                'TransportBill.reference',

                            ),
                            'joins' => array(
                                array(
                                    'table' => 'transport_bills',
                                    'type' => 'left',
                                    'alias' => 'TransportBill',
                                    'conditions' => array('TransportBill.id = Transformation.origin_transport_bill_id')
                                )
                            )
                        )
                    );
                    $this->set('originTransportBill', $originTransportBill);
                    $newTransportBill = $this->Transformation->find('first',
                        array(
                            'conditions' => array('Transformation.origin_transport_bill_id' => $id),
                            'recursive' => -1,
                            'fields' => array(

                                'TransportBill.reference',

                            ),
                            'joins' => array(
                                array(
                                    'table' => 'transport_bills',
                                    'type' => 'left',
                                    'alias' => 'TransportBill',
                                    'conditions' => array('TransportBill.id = Transformation.new_transport_bill_id')
                                )
                            )
                        )
                    );
                    $this->set('newTransportBill', $newTransportBill);
                    break;

                case $type == TransportBillTypesEnum::order :
                    $permissionOrder = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transmettre_commande_client,
                        ActionsEnum::view, $profileId, $roleId);
                    $permissionCancel = $this->AccessPermission->getPermissionWithParams(SectionsEnum::annuler_commande_client,
                        ActionsEnum::view, $profileId, $roleId);
                    $this->set(compact('permissionOrder', 'permissionCancel'));
                    $originTransportBill = $this->Transformation->find('first',
                        array(
                            'conditions' => array('Transformation.new_transport_bill_id' => $id),
                            'recursive' => -1,
                            'fields' => array(
                                'TransportBill.reference',
                            ),
                            'joins' => array(
                                array(
                                    'table' => 'transport_bills',
                                    'type' => 'left',
                                    'alias' => 'TransportBill',
                                    'conditions' => array('TransportBill.id = Transformation.origin_transport_bill_id')
                                )
                            )
                        )
                    );

                    $this->set('originTransportBill', $originTransportBill);


                    break;

                case $type == TransportBillTypesEnum::pre_invoice :

                    $newTransportBill = $this->Transformation->find('first',
                        array(
                            'conditions' => array('Transformation.origin_transport_bill_id' => $id),
                            'recursive' => -1,
                            'fields' => array(

                                'TransportBill.reference',

                            ),
                            'joins' => array(
                                array(
                                    'table' => 'transport_bills',
                                    'type' => 'left',
                                    'alias' => 'TransportBill',
                                    'conditions' => array('TransportBill.id = Transformation.new_transport_bill_id')
                                )
                            )
                        )
                    );

                    $this->set('newTransportBill', $newTransportBill);

                    break;

                case $type == TransportBillTypesEnum::invoice :


                    $originTransportBill = $this->Transformation->find('first',
                        array(
                            'conditions' => array('Transformation.new_transport_bill_id' => $id),
                            'recursive' => -1,
                            'fields' => array(
                                'TransportBill.reference',
                            ),
                            'joins' => array(
                                array(
                                    'table' => 'transport_bills',
                                    'type' => 'left',
                                    'alias' => 'TransportBill',
                                    'conditions' => array('TransportBill.id = Transformation.origin_transport_bill_id')
                                )
                            )
                        )
                    );

                    $this->set('originTransportBill', $originTransportBill);
                    break;


            }
            if ($type == TransportBillTypesEnum::invoice) {
                $detailPayments = $this->DetailPayment->find('all', array(
                    'recursive' => -1,
                    'order' => 'Payment.id ASC',
                    'conditions' => array('DetailPayment.transport_bill_id' => $id),
                    'fields' => array(
                        'DetailPayment.payroll_amount',
                        'Payment.receipt_date',
                        'Payment.payment_type',
                        'Payment.number_payment',
                    ),
                    'joins' => array(
                        array(
                            'table' => 'payments',
                            'type' => 'left',
                            'alias' => 'Payment',
                            'conditions' => array('DetailPayment.payment_id = Payment.id')
                        )
                    )
                ));
                $this->set('detailPayments', $detailPayments);
            }
        }
        $transportBill = $this->TransportBill->find('first', $options);

        $this->set('transportBill', $transportBill);

        if ($type == TransportBillTypesEnum::pre_invoice || $type == TransportBillTypesEnum::invoice) {
            $rides = $this->TransportBillDetailRides->find('all', array(
                'conditions' => array('TransportBillDetailRides.transport_bill_id' => $id),
                'recursive' => -1,
                'fields' => array(
                    'CarType.name',
                    'DepartureDestination.name',
                    'ArrivalDestination.name',
                    'Type.name',
                    'Departure.name',
                    'Arrival.name',
                    'Ride.wording',
                    'Ride.distance',
                    'TransportBillDetailRides.reference',
                    'TransportBillDetailRides.type_ride',
                    'SheetRide.reference',
                    'TransportBillDetailRides.unit_price',
                    'TransportBillDetailRides.nb_trucks',
                    'TransportBillDetailRides.price_ht',
                    'TransportBillDetailRides.price_ttc',
                    'TransportBillDetailRides.status_id',
                    'SheetRideDetailRides.reference',
                    'Car.code',
                    'SheetRide.real_start_date',
                    'SheetRide.real_end_date',
                    'Customer.first_name',
                    'Customer.last_name',
                    'Car.immatr_def',
                    'Carmodel.name',
                    'DetailRide.id',
                    'Departure.id',
                    'Arrival.id',
                    'Type.id',
                    'TransportBillDetailRides.lot_id',
                    'Product.name',

                ),
                'joins' => array(
                    array(
                        'table' => 'detail_rides',
                        'type' => 'left',
                        'alias' => 'DetailRide',
                        'conditions' => array('TransportBillDetailRides.detail_ride_id = DetailRide.id')
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
                        'table' => 'sheet_ride_detail_rides',
                        'type' => 'left',
                        'alias' => 'SheetRideDetailRides',
                        'conditions' => array('TransportBillDetailRides.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
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
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('Customer.id = SheetRide.customer_id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
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
                    )
                )
            ));
            //Get the structure of the car name from parameters
            $param = $this->Parameter->getCodesParameterVal('name_car');
            $this->set('param', $param);
        } else {
            $rides = $this->TransportBillDetailRides->geDetailedTBDRByTransportBillId($id);
        }

        $this->set('rides', $rides);


    }


    /**
     * add method
     *
     * @param null $type
     * @return void
     */
    public function add($type = null)
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        $userId = $this->Auth->user('id');
        $serviceId = $this->Auth->user('service_id');
        $this->set('serviceId',$serviceId);
        if ($type == TransportBillTypesEnum::quote_request) {
            $this->verifyUserPermission(SectionsEnum::demande_de_devis, $userId, ActionsEnum::add, "TransportBills",
                null, "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::quote) {
            $this->verifyUserPermission(SectionsEnum::devis, $userId, ActionsEnum::add, "TransportBills", null,
                "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::order) {
            $this->verifyUserPermission(SectionsEnum::commande_client, $userId, ActionsEnum::add, "TransportBills",
                null, "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::pre_invoice) {
            $this->verifyUserPermission(SectionsEnum::prefacture, $userId, ActionsEnum::add, "TransportBills", null,
                "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::invoice) {
            $this->verifyUserPermission(SectionsEnum::facture, $userId, ActionsEnum::add, "TransportBills", null,
                "TransportBill", $type);
        }elseif ($type == TransportBillTypesEnum::credit_note) {
            $this->verifyUserPermission(SectionsEnum::avoir_vente, $userId, ActionsEnum::add, "TransportBills", null,
                "TransportBill", $type);
        }
        $this->TransportBillDetailedRidesManagement = $this->Components->load('TransportBillDetailedRidesManagement');
        $reference = $this->getNextTransportReference( $type);
        $this->set('reference', $reference);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->layout = 'ajax';
                $this->redirect(array('action' => 'index', $type));
            }
            $this->TransportBill->create();
            $this->createDateFromDate('TransportBill', 'date');
            $this->request->data['TransportBill']['type'] = $type;
            $this->request->data['TransportBill']['user_id'] = $this->Session->read('Auth.User.id');
            if ($type == TransportBillTypesEnum::invoice || $type == TransportBillTypesEnum::pre_invoice) {
                $this->request->data['TransportBill']['amount_remaining'] = $this->request->data['TransportBill']['total_ttc'];
            }
            if (empty($this->request->data['TransportBillDetailRides'])) {
                $this->Flash->error(__('The bill must contain at least one ride.'));
                $this->redirect(array('action' => 'add', $type));
            }
            $supplierId = $this->request->data['TransportBill']['supplier_id'];
            $customerOrderValidationMethod = null;
            if ($type == TransportBillTypesEnum::order) {
                $customerOrderValidationMethod = $this->Supplier->getCustomerOrderValidationMethod($supplierId);
                if ($customerOrderValidationMethod == 1) {
                    //$this->request->data['TransportBill']['status'] = TransportBillDetailRideStatusesEnum::not_validated;
                } else {
                    $this->request->data['TransportBill']['status'] = TransportBillDetailRideStatusesEnum::not_transmitted;
                }
            }
            //var_dump($this->TransportBill->save($this->request->data));
            //var_dump($this->TransportBill->validationErrors);die();
            $reference = $this->getNextTransportReference( $type);

            if(!empty($reference)){
                $this->request->data['TransportBill']['reference'] = $reference;
            }
            if(!isset($this->request->data['TransportBill']['amount_remaining'])){
                $this->request->data['TransportBill']['amount_remaining'] =
                    $this->request->data['TransportBill']['total_ttc'];
            }
            if ($this->TransportBill->save($this->request->data)) {
                $transportBillId = $this->TransportBill->getInsertID();
                if (!empty($this->request->data['TransportBillDetailRides'])) {
                    $save = $this->add_Rides_transportBill($this->request->data['TransportBillDetailRides'], $reference,
                        $transportBillId, $userId, $type, null, $customerOrderValidationMethod);
                    if($save == false ){
                        $this->TransportBill->deleteAll(array('TransportBill.id' => $transportBillId),
                            false);
                        $this->Flash->error(__('The transport bill could not be saved. Please, try again5.'));
                        $this->redirect(array('action' => 'index', $type));
                    } else {
                        if(isset($this->request->data['TransportBill']['with_penalty'])){
                            if($this->request->data['TransportBill']['with_penalty']==1 &&
                                $type == TransportBillTypesEnum::invoice
                            ){
                                $penalties = $this->request->data['TransportBillPenalty'];
                                $this->TransportBillPenalty->addPenalties($transportBillId,$penalties);
                            }
                        }
                        if($type == TransportBillTypesEnum::order){
                            $this->TransportBillDetailedRidesManagement->addTransportBillDetailedRides($this->request->data['TransportBillDetailRides']
                                ,$reference, $transportBillId, $userId, $type, null, $customerOrderValidationMethod);
                        }
                    }
                    $this->Parameter->setNextTransportReferenceNumber($type);
                }
                if ($customerOrderValidationMethod == 1 && $type == TransportBillTypesEnum::order) {
                    $this->TransportBill->updateStatusCustomerOrder($transportBillId);
                }
                switch ($type) {
                    case TransportBillTypesEnum::quote :
                        $this->Flash->success(__('The quotation has been saved.'));
                        break;
                    case TransportBillTypesEnum::order :
                        $this->Flash->success(__('The customer order has been saved.'));
                        break;
                    case TransportBillTypesEnum::pre_invoice :
                        $this->Flash->success(__('The preinvoice has been saved.'));
                        break;
                    case TransportBillTypesEnum::invoice :
                        $this->Supplier->updateBalanceClient($supplierId , 0 , -$this->request->data['TransportBill']['total_ttc']);
                        $this->Flash->success(__('The invoice has been saved.'));
                        break;
                    case TransportBillTypesEnum::credit_note :
                        $this->Supplier->updateBalanceClient($supplierId , 0 , $this->request->data['TransportBill']['total_ttc']);

                        $this->Flash->success(__('The credit note has been saved.'));
                        break;
                }
                if ($type == TransportBillTypesEnum::credit_note ){
                    $this->TransportBill->id =$this->request->data['TransportBill']['invoice_id'];
                    $this->TransportBill->saveField('has_credit_note',1);
                }
                //$this->SaveTransportBills = $this->Components->load('SaveTransportBills');
                /*$this->SaveTransportBills
                    ->cutCreditNoteTTCAmountFromInvoiceAmountRemaining($this->request->data['TransportBill']['invoice_id'],
                        $this->request->data['TransportBill']['total_ttc']);*/
                if(isset($this->params['pass']['1']) && $this->params['pass']['1']=='TransportBillDetailRides'){
                    $this->redirect(array('controller'=>'TransportBillDetailRides','action' => 'index'));
                }else {
                    $this->redirect(array('action' => 'index', $type));
                }

            } else {
                $this->Flash->error(__('The transport bill could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index', $type));
            }
        }


        $product = $this->Product->getProductById(1);
        $relationWithPark = $product['ProductType']['relation_with_park'];
        $this->set('relationWithPark',$relationWithPark);
        $tvas = $this->Tva->getTvas();
        $transportBillCategories = $this->TransportBillCategory->getTransportBillCategories();
        $useRideCategory = $this->useRideCategory();
        if ($useRideCategory == 2) {
            $rideCategories = $this->RideCategory->getRideCategories();
            $this->set(compact('rideCategories'));
        }
        $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
        $typeRide = $this->Parameter->getCodesParameterVal('type_ride');
        $typeRideUsedFirst = $this->Parameter->getCodesParameterVal('type_ride_used_first');
        if ($typeRideUsedFirst != 1) {
            $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validatePersonalizedRide;
        }
        $nbTrucksModifiable = $this->Parameter->getCodesParameterVal('nb_trucks_modifiable');
        $defaultNbTrucks = $this->Parameter->getCodesParameterVal('default_nb_trucks');
        $profileId = $this->Auth->user('profile_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        $this->set('profileId', $profileId);
        if ($type == TransportBillTypesEnum::order) {

            if ($profileId == ProfilesEnum::client) {
                $supplierId = $this->Auth->user('supplier_id');

                $this->set(compact('supplierId'));
            }
        }

        $carTypes = $this->CarType->getCarTypes();
        $products = $this->Product->getProducts('list');
        $typePricing = $this->Parameter->getCodesParameterVal('type_pricing');
        if ($typePricing == 2 || $typePricing == 3) {
            $tonnages = $this->Tonnage->getTonnages();
            $this->set(compact('tonnages'));
        }
        $priceCategories = $this->PriceCategory->getPriceCategories('list');
        $services = $this->Service->getServices('list');
        $marchandiseUnits = $this->Marchandise->MarchandiseUnit->find('list', array('order' => 'name ASC'));
        $this->set(compact('tvas', 'type', 'useRideCategory', 'transportBillCategories',
            'products', 'priceCategories','services',
            'paramPriceNight', 'typeRide', 'typeRideUsedFirst', 'carTypes', 'nbTrucksModifiable',
            'defaultNbTrucks', 'typePricing','marchandiseUnits'));
    }

    function add_Rides_transportBill(
        $transportBillDetailRides = null,
        $reference = null,
        $transportBillId = null,
        $userId = null,
        $type = null,
        $supplierFinal = null,
        $customerOrderValidationMethod = null
    )
    {
        $i = 1;
        $save = false ;
        $data = array();
        foreach ($transportBillDetailRides as $transportBillDetailRide) {
            if(isset($transportBillDetailRide['product_id'])){
                $product = $this->Product->getProductById($transportBillDetailRide['product_id']);
                $productTypeId = $product['Product']['product_type_id'];
                $relationWithPark = $product['ProductType']['relation_with_park'];
                switch ($productTypeId){
                    case 1 :
                        if (isset($transportBillDetailRide['detail_ride_id'])) {
                            $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validate;
                        } else {
                            $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validatePersonalizedRide;
                        }
                        break;
                    case 3 :
                        $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validateProvision;
                        break;
                    default :
                        $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validateProduct;
                        break;
                }
            }


            $this->TransportBillDetailRides->create();
            if ($reference != null) {
                $data[$i]['TransportBillDetailRides']['reference'] = $reference . '/' . $i;
            }
            $data[$i]['TransportBillDetailRides']['transport_bill_id'] = $transportBillId;
            if (isset($transportBillDetailRide['type_ride'])) {
                $data[$i]['TransportBillDetailRides']['type_ride'] = $transportBillDetailRide['type_ride'];
            }else {
                if($relationWithPark==1){
                    $data[$i]['TransportBillDetailRides']['type_ride'] = 2;
                }
            }
            if (isset($transportBillDetailRide['type_pricing'])) {
                $data[$i]['TransportBillDetailRides']['type_pricing'] = $transportBillDetailRide['type_pricing'];
            }
            if (isset($transportBillDetailRide['tonnage_id'])) {
                $data[$i]['TransportBillDetailRides']['tonnage_id'] = $transportBillDetailRide['tonnage_id'];
            }
            if (isset($transportBillDetailRide['detail_ride_id'])) {
                $data[$i]['TransportBillDetailRides']['detail_ride_id'] = $transportBillDetailRide['detail_ride_id'];
            } else {
                $data[$i]['TransportBillDetailRides']['detail_ride_id'] = NULL;
            }
            if (isset($transportBillDetailRide['from_customer_order'])) {
                $data[$i]['TransportBillDetailRides']['from_customer_order'] = $transportBillDetailRide['from_customer_order'];
            }
            if (isset($transportBillDetailRide['departure_destination_id'])) {
                $data[$i]['TransportBillDetailRides']['departure_destination_id'] = $transportBillDetailRide['departure_destination_id'];
            } else {
                $data[$i]['TransportBillDetailRides']['departure_destination_id'] = NULL;
            }
            if (isset($transportBillDetailRide['arrival_destination_id'])) {
                $data[$i]['TransportBillDetailRides']['arrival_destination_id'] = $transportBillDetailRide['arrival_destination_id'];
            } else {
                $data[$i]['TransportBillDetailRides']['arrival_destination_id'] = NULL;
            }
            if (isset($transportBillDetailRide['car_type_id'])) {
                $data[$i]['TransportBillDetailRides']['car_type_id'] = $transportBillDetailRide['car_type_id'];
            } else {
                $data[$i]['TransportBillDetailRides']['car_type_id'] = NULL;
            }

            if (isset($transportBillDetailRide['product_id'])) {
                $productId = $transportBillDetailRide['product_id'];
                $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
                if ($usePurchaseBill == 1) {
                    $product = $this->Product->getProductById($productId);
                    $productWithLot = $product['Product']['with_lot'];
                    if ($productWithLot == 1) {
                        $lotId = $transportBillDetailRide['lot_id'];
                    } else {
                        $lotId = $transportBillDetailRide['product_id'];
                    }
                } else {
                    $lotId = $transportBillDetailRide['product_id'];
                }
                $data[$i]['TransportBillDetailRides']['lot_id'] = $lotId;
            } else {
                $data[$i]['TransportBillDetailRides']['lot_id'] = NULL;
            }
            if (isset($transportBillDetailRide['designation'])) {
                $data[$i]['TransportBillDetailRides']['designation'] = $transportBillDetailRide['designation'];
            } else {
                $data[$i]['TransportBillDetailRides']['designation'] = NULL;
            }

            if (isset($transportBillDetailRide['description'])) {
                $data[$i]['TransportBillDetailRides']['description'] = $transportBillDetailRide['description'];
            } else {
                $data[$i]['TransportBillDetailRides']['description'] = NULL;
            }
            if (isset($transportBillDetailRide['observation_order'])) {
                $data[$i]['TransportBillDetailRides']['observation_order'] = $transportBillDetailRide['observation_order'];
            } else {
                $data[$i]['TransportBillDetailRides']['observation_order'] = NULL;
            }
            if (isset($transportBillDetailRide['supplier_final_id'])) {
                $data[$i]['TransportBillDetailRides']['supplier_final_id'] = $transportBillDetailRide['supplier_final_id'];
            } else {
                $data[$i]['TransportBillDetailRides']['supplier_final_id'] = $supplierFinal;
            }
            if(isset($transportBillDetailRide['programming_date'])){
                if (DateTime::createFromFormat('Y-m-d', $transportBillDetailRide['programming_date']) !== false) {
                    $data[$i]['TransportBillDetailRides']['programming_date'] = $transportBillDetailRide['programming_date'];
                }else{
                    $this->request->data['TransportBillDetailRides']['programming_date'] = $transportBillDetailRide['programming_date'];
                    $this->createDateFromDate('TransportBillDetailRides', 'programming_date');
                    $transportBillDetailRide['programming_date'] = $this->request->data['TransportBillDetailRides']['programming_date'];
                    $data[$i]['TransportBillDetailRides']['programming_date'] = $transportBillDetailRide['programming_date'];
                }
            }
            if(isset($transportBillDetailRide['charging_time'])){
                $data[$i]['TransportBillDetailRides']['charging_time'] = $transportBillDetailRide['charging_time'];
            }

            if(isset($transportBillDetailRide['unloading_date'])){
                if (DateTime::createFromFormat('Y-m-d H:i:s', $transportBillDetailRide['unloading_date']) !== false) {
                    $data[$i]['TransportBillDetailRides']['unloading_date'] = $transportBillDetailRide['unloading_date'];
                }else{
                    $this->request->data['TransportBillDetailRides']['unloading_date'] = $transportBillDetailRide['unloading_date'];
                    $this->createDatetimeFromDatetime('TransportBillDetailRides', 'unloading_date');
                    $transportBillDetailRide['unloading_date'] = $this->request->data['TransportBillDetailRides']['unloading_date'];
                    $data[$i]['TransportBillDetailRides']['unloading_date'] = $transportBillDetailRide['unloading_date'];
                }
            }
            if(isset($transportBillDetailRide['start_date'])){
                $this->request->data['TransportBillDetailRides']['start_date'] = $transportBillDetailRide['start_date'];
                $this->createDatetimeFromDatetime('TransportBillDetailRides', 'start_date');
                $transportBillDetailRide['start_date'] = $this->request->data['TransportBillDetailRides']['start_date'];
                $data[$i]['TransportBillDetailRides']['start_date'] = $transportBillDetailRide['start_date'];
            }
            if(isset($transportBillDetailRide['end_date'])){
                $this->request->data['TransportBillDetailRides']['end_date'] = $transportBillDetailRide['end_date'];
                $this->createDatetimeFromDatetime('TransportBillDetailRides', 'end_date');
                $transportBillDetailRide['end_date'] = $this->request->data['TransportBillDetailRides']['end_date'];
                $data[$i]['TransportBillDetailRides']['end_date'] = $transportBillDetailRide['end_date'];
            }
            if (isset($transportBillDetailRide['car_id'])) {
                $data[$i]['TransportBillDetailRides']['car_id'] = $transportBillDetailRide['car_id'];
            } else {
                $data[$i]['TransportBillDetailRides']['car_id'] = NULL;
            }
            if (isset($transportBillDetailRide['nb_hours'])) {
                $data[$i]['TransportBillDetailRides']['nb_hours'] = $transportBillDetailRide['nb_hours'];
            } else {
                $data[$i]['TransportBillDetailRides']['nb_hours'] = NULL;
            }
            $data[$i]['TransportBillDetailRides']['unit_price'] = $transportBillDetailRide['unit_price'];
            if (isset($transportBillDetailRide['delivery_with_return'])) {
                $data[$i]['TransportBillDetailRides']['delivery_with_return'] = $transportBillDetailRide['delivery_with_return'];
            }
            if (isset($transportBillDetailRide['ride_category_id'])) {
                $data[$i]['TransportBillDetailRides']['ride_category_id'] = $transportBillDetailRide['ride_category_id'];
            }
            if (isset($transportBillDetailRide['type_price'])) {
                $data[$i]['TransportBillDetailRides']['type_price'] = $transportBillDetailRide['type_price'];
            } else {
                $data[$i]['TransportBillDetailRides']['type_price'] = 1;
            }
            $data[$i]['TransportBillDetailRides']['nb_trucks'] = $transportBillDetailRide['nb_trucks'];
            $data[$i]['TransportBillDetailRides']['price_ht'] = $transportBillDetailRide['price_ht'];
            $data[$i]['TransportBillDetailRides']['price_ttc'] = $transportBillDetailRide['price_ttc'];
            if(isset($transportBillDetailRide['tva_id'])){
                $data[$i]['TransportBillDetailRides']['tva_id'] = $transportBillDetailRide['tva_id'];
            }
            if (isset($transportBillDetailRide['ristourne_val'])) {
                $data[$i]['TransportBillDetailRides']['ristourne_val'] = $transportBillDetailRide['ristourne_val'];
            }
            if (isset($transportBillDetailRide['ristourne_%'])) {
                $data[$i]['TransportBillDetailRides']['ristourne_%'] = $transportBillDetailRide['ristourne_%'];
            }
               // var_dump($type); die();
                switch ($type) {
                    case TransportBillTypesEnum::quote_request :
                        $data[$i]['TransportBillDetailRides']['status_id'] = StatusEnum::quotation;
                        break;
                    case TransportBillTypesEnum::quote :
                        $data[$i]['TransportBillDetailRides']['status_id'] = StatusEnum::quotation;
                        break;
                    case TransportBillTypesEnum::order :
                        if($relationWithPark==1){
                            if ($customerOrderValidationMethod == 1) {
                                $data[$i]['TransportBillDetailRides']['status_id'] = TransportBillDetailRideStatusesEnum::not_validated;
                            } else {
                                $data[$i]['TransportBillDetailRides']['status_id'] = TransportBillDetailRideStatusesEnum::not_transmitted;
                            }
                        }else {
                            $data[$i]['TransportBillDetailRides']['status_id'] = $transportBillDetailRide['status_id'];
                        }

                        break;
                    case TransportBillTypesEnum::pre_invoice :
                        $data[$i]['TransportBillDetailRides']['status_id'] = TransportBillTypesEnum::pre_invoice;
                        break;
                    case TransportBillTypesEnum::invoice :
                        $data[$i]['TransportBillDetailRides']['status_id'] = TransportBillTypesEnum::invoice;
                        break;

                     case TransportBillTypesEnum::credit_note :
                        $data[$i]['TransportBillDetailRides']['status_id'] = TransportBillTypesEnum::credit_note;
                        break;
                }

            if (isset($transportBillDetailRide['sheet_ride_detail_ride_id'])) {
                $data[$i]['TransportBillDetailRides']['sheet_ride_detail_ride_id'] = $transportBillDetailRide['sheet_ride_detail_ride_id'];
            }
            if (isset($transportBillDetailRide['marchandise_unit_id'])) {
                $data[$i]['TransportBillDetailRides']['marchandise_unit_id'] = $transportBillDetailRide['marchandise_unit_id'];
            }
            if ($type == TransportBillTypesEnum::pre_invoice) {
                $data[$i]['TransportBillDetailRides']['approved'] = $transportBillDetailRide['approved'];
            }
            $data[$i]['TransportBillDetailRides']['user_id'] = $userId;

                //var_dump($this->TransportBillDetailRides->save($data[$i]));
                //var_dump($this->TransportBillDetailRides->validationErrors);die();
               if($this->TransportBillDetailRides->save($data[$i]) ) {

                   if( $save == false) {
                       $save = true ;
                   }
                      if($relationWithPark == 1) {
                          $transportBillDetailRideId = $this->TransportBillDetailRides->getInsertID();

                          if($type == TransportBillTypesEnum::order ){
                          if (isset($transportBillDetailRide['customer_observation'])) {
                              $customerObservation = $transportBillDetailRide['customer_observation'];
                              $this->Observation->addObservations($transportBillDetailRideId,
                                  $data[$i]['TransportBillDetailRides']['nb_trucks'], $customerObservation);
                          } else {
                              $this->Observation->addObservations($transportBillDetailRideId,
                                  $data[$i]['TransportBillDetailRides']['nb_trucks']);
                          }
                          }
                      }
                      if(isset($transportBillDetailRide['TransportBillDetailRideFactor'])){
                          $this->request->data['TransportBillDetailRides'][$i]['TransportBillDetailRideFactor'] =
                              $transportBillDetailRide['TransportBillDetailRideFactor'];

                      }


                       $transportBillDetailRideId = $this->TransportBillDetailRides->getInsertID();
                       if(
                               (
                                 isset($this->request->data['TransportBillDetailRides'][$i]['TransportBillDetailRideFactor'])&&
                                !empty($this->request->data['TransportBillDetailRides'][$i]['TransportBillDetailRideFactor'])
                               )
                       ){
                           $productPriceFactors = $this->request->data['TransportBillDetailRides'][$i]['TransportBillDetailRideFactor'];
                           foreach ($productPriceFactors as $productPriceFactor){
                               $data2 = array();
                               $data2['TransportBillDetailRideFactor']['transport_bill_detail_ride_id'] = $transportBillDetailRideId;
                               $data2['TransportBillDetailRideFactor']['factor_id'] = $productPriceFactor['factor_id'];
                               $data2['TransportBillDetailRideFactor']['factor_value'] = $productPriceFactor['factor_value'];
                               $this->TransportBillDetailRideFactor->create();
                               $this->TransportBillDetailRideFactor->save($data2);
                           }
                       }
           }
            $i++;
        }


        /*if($type != TransportBillTypesEnum::order){

            if($this->TransportBillDetailRides->saveAll($data) ) {
                $save = true;
            }

        }*/
        return $save;
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $type
     * @param string $id
     * @param string $controller
     * @param string $url
     * @param string $page
     * @return void
     */
    public function edit($type = null, $id = null, $controller= null, $url= null, $page=null)
    { 
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        if(!empty($url)){
            $url = unserialize(base64_decode($url));
            $url =  explode($controller, $url);
            $url = '/'.$controller.$url[1].'?page='.$page;;
        } else {
            $url =  array('controller' => 'transportBills', 'action' => 'index',$type);
        }
        $this->TransportBillDetailedRidesManagement = $this->Components->load('TransportBillDetailedRidesManagement');
        ini_set('max_input_vars', '5000');
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        if ($type == TransportBillTypesEnum::quote_request) {
            $this->verifyUserPermission(SectionsEnum::demande_de_devis, $user_id, ActionsEnum::edit, "TransportBills",
                $id, "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::quote) {
            $this->verifyUserPermission(SectionsEnum::devis, $user_id, ActionsEnum::edit, "TransportBills", $id,
                "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::order) {
            $this->verifyUserPermission(SectionsEnum::commande_client, $user_id, ActionsEnum::edit, "TransportBills",
                $id, "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::pre_invoice) {
            $this->verifyUserPermission(SectionsEnum::prefacture, $user_id, ActionsEnum::edit, "TransportBills", $id,
                "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::invoice) {
            $this->verifyUserPermission(SectionsEnum::facture, $user_id, ActionsEnum::edit, "TransportBills", $id,
                "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::credit_note) {
            $this->verifyUserPermission(SectionsEnum::avoir_vente, $user_id, ActionsEnum::edit, "TransportBills", $id,
                "TransportBill", $type);
        }
        $reference = $this->getNextTransportReference( $type);
        $this->set('reference', $reference);
        if (!$this->TransportBill->exists($id)) {
            throw new NotFoundException(__('Invalid transport bill'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $requestData = $this->request->data;  
            if (isset($this->request->data['cancel'])) {
                $this->closeItemOpened('TransportBill', $id);
                $this->Flash->error(__('Changes were not saved. Transport bill cancelled.'));
                if(isset($this->params['pass']['2']) && $this->params['pass']['2']=='TransportBillDetailRides'){
                    $this->redirect(array('controller'=>'TransportBillDetailRides','action' => 'index'));
                }else {
                    $this->redirect(array('action' => 'index', $type));
                }

            }
            if (empty($this->request->data['TransportBillDetailRides'])) {
                $this->Flash->error(__('The bill must contain at least one ride.'));
                $this->redirect(array('action' => 'edit', $type, $id));
            }
            $this->createDateFromDate('TransportBill', 'date');
            $this->request->data['TransportBill']['type'] = $type;
            $this->request->data['TransportBill']['modified_id'] = $this->Session->read('Auth.User.id');
            $this->closeItemOpened('TransportBill', $id);
            $supplierId = $this->request->data['TransportBill']['supplier_id'];
            $customerOrderValidationMethod = $this->Supplier->getCustomerOrderValidationMethod($supplierId);
            $existedTransportBill =  $this->TransportBill->find('first',
                array(
                    'recursive' => -1,
                    'conditions' => array(
                        'TransportBill.id' => $id
                    ),
                    'fields' => array(
                        'TransportBill.id',
                        'TransportBill.invoice_id',
                        'TransportBill.total_ttc',
                        'TransportBill.status'
                    )
                ));
            $existedTotalTtc = $existedTransportBill['TransportBill']['total_ttc'];
            $existedStatus = $existedTransportBill['TransportBill']['status'];
            if ($this->TransportBill->save($this->request->data)) {
                switch ($type){
                    case TransportBillTypesEnum::invoice :
                        $this->Supplier->updateBalanceClient($supplierId ,  0, $existedTotalTtc);
                        break;
                    case TransportBillTypesEnum::credit_note :
                        $this->Supplier->updateBalanceClient($supplierId ,  0, -$existedTotalTtc);
                        break;
                }
                $this->updateAmountRemaining($id);
                $transportBillDetailRides = $this->TransportBillDetailRides->find('all',
                    array(
                        'recursive' => -1,
                        'fields' => array('TransportBillDetailRides.id'),
                        'conditions' => array(
                            'TransportBillDetailRides.transport_bill_id' => $id
                        )));
                foreach ($transportBillDetailRides as $transportBillDetailRide) {
                    $transportBillDetailRideIds[] = $transportBillDetailRide['TransportBillDetailRides']['id'];
                }
                if (!empty($this->request->data['TransportBillDetailRides'])) {
                    foreach ($this->request->data['TransportBillDetailRides'] as $this->request->data['TransportBillDetailRides']) {
                        // pour editer les trajet qui existe deja
                        if (!empty($this->request->data['TransportBillDetailRides']['id'])) {
                            $transportBillDetailRideId = $this->request->data['TransportBillDetailRides']['id'];
                            $this->update_Ride_transportBill($this->request->data['TransportBillDetailRides'], $id,
                                $transportBillDetailRideId, $type);
                            if ($type == TransportBillTypesEnum::pre_invoice) {
                                $TransportBillDetailRide = $this->TransportBillDetailRides->find('first',
                                    array(
                                        'conditions' => array(
                                            'TransportBillDetailRides.id' => $transportBillDetailRideId
                                        ),
                                        'fields' => array(
                                            'TransportBillDetailRides.sheet_ride_detail_ride_id',
                                            'TransportBillDetailRides.approved'
                                        )
                                    )
                                );
                                $sheet_ride_detail_ride_id = $TransportBillDetailRide['TransportBillDetailRides']['sheet_ride_detail_ride_id'];
                                if ($TransportBillDetailRide['TransportBillDetailRides']['approved'] == 1) {
                                    $approved = 5;
                                } else {
                                    $approved = 6;
                                }
                                $this->SheetRideDetailRides->updateStatusSheetRideDetailRide($sheet_ride_detail_ride_id, $approved);

                            }
                            if (isset($transportBillDetailRideIds) && !empty($transportBillDetailRideIds)) {
                                if (in_array($transportBillDetailRideId, $transportBillDetailRideIds)) {
                                    unset($transportBillDetailRideIds[array_search($transportBillDetailRideId,
                                            $transportBillDetailRideIds)]);
                                }
                            }
                        } else {
                            $save = $this->add_Ride_transportBill($this->request->data['TransportBillDetailRides'],
                                $this->request->data['TransportBill']['reference'], $id, $type, null, $customerOrderValidationMethod);
                            if($save == false ){

                                $this->Flash->error(__('The transport bill could not be saved. Please, try again1.'));
                                $this->redirect(array('action' => 'index', $type));
                            }
                        }
                    }
                    if (isset($transportBillDetailRideIds) && !empty($transportBillDetailRideIds)) {
						
                        $this->Observation->deleteAll(array('Observation.transport_bill_detail_ride_id' => $transportBillDetailRideIds),
                            false);
							
							$this->TransportBillDetailRides->deleteAll(array('TransportBillDetailRides.id' => $transportBillDetailRideIds),
                            false);
                    }
                }

                if (($customerOrderValidationMethod == 1 ||$existedStatus!=TransportBillDetailRideStatusesEnum::not_transmitted) && $type == TransportBillTypesEnum::order) {
                    $this->TransportBill->updateStatusCustomerOrder($id);
                }
                if (isset($this->request->data['Deadlines']['deleted_id']) && !empty($this->request->data['Deadlines']['deleted_id'])) {
                    $deadlineDeletedId = $this->request->data['Deadlines']['deleted_id'];
                    $deadlineIds = explode(",", $deadlineDeletedId);
                    $this->Deadline->deleteDeadlines($deadlineIds);
                    $this->Alert->deleteAll(array('Alert.object_id' => $id), false);
                }
                if (!empty($this->request->data['Deadline'])) {
                    $deadlines = $this->request->data['Deadline'];
                    if(!empty($deadlines)){
                        foreach ($deadlines as $deadline) {
                            if (!empty($deadline['id'])) {
                                $this->request->data['Deadline']['deadline_date'] = $deadline['deadline_date'];
                                $this->createDateFromDate('Deadline', 'deadline_date');
                                $deadline['deadline_date'] = $this->request->data['Deadline']['deadline_date'];
                                $this->Deadline->updateDeadline($deadline, $id);
                                $this->Alert->deleteAll(array('Alert.object_id' => $id), false);
                                $this->setDeadlineAlerts($id);
                            } else {
                                $this->request->data['Deadline']['deadline_date'] = $deadline['deadline_date'];
                                $this->createDateFromDate('Deadline', 'deadline_date');
                                $deadline['deadline_date'] = $this->request->data['Deadline']['deadline_date'];
                                $this->Deadline->addDeadline($deadline, $id);
                                $this->setDeadlineAlerts($id);
                            }
                        }
                    } else {
                        $this->Alert->deleteAll(array('Alert.object_id' => $id), false);
                    }
                }
                switch ($type) {
                    case TransportBillTypesEnum::quote :
                        $this->saveUserAction(SectionsEnum::devis, $id, $this->Session->read('Auth.User.id'), ActionsEnum::edit);
                        $this->Flash->success(__('The quotation has been saved.'));
                        break;
                    case TransportBillTypesEnum::order :
                        $this->saveUserAction(SectionsEnum::commande_client, $id, $this->Session->read('Auth.User.id'), ActionsEnum::edit);
                        $this->Flash->success(__('The customer order has been saved.'));
                        break;
                    case TransportBillTypesEnum::pre_invoice :
                        $this->saveUserAction(SectionsEnum::prefacture, $id, $this->Session->read('Auth.User.id'), ActionsEnum::edit);
                        $this->Flash->success(__('The preinvoice has been saved.'));
                        break;
                    case TransportBillTypesEnum::invoice :
                        if($this->request->data['TransportBill']['with_penalty']==1){
                             $penalties = $this->request->data['TransportBillPenalty'];
                            foreach ($penalties as $penalty){
                                if(isset($penalty['id'])){
                                    $this->TransportBillPenalty->updatePenalty($id,$penalty);
                                }else {
                                    $this->TransportBillPenalty->addPenalty($id,$penalty);
                                }
                            }
                            if(isset($this->request->data['TransportBill']['penalty_deleted_id'])){
                                $penaltyDeletedIds = $this->request->data['TransportBill']['penalty_deleted_id'];
                                $penaltyDeletedIds = explode(",", $penaltyDeletedIds);
                                $this->TransportBillPenalty->deletePenalties($penaltyDeletedIds);
                            }else {
                                $this->TransportBillPenalty->deletePenaltiesByTransportBillId($id);
                            }



                        }else {


                            $this->TransportBillPenalty->deletePenaltiesByTransportBillId($id);
                        }
                        $this->saveUserAction(SectionsEnum::facture, $id, $this->Session->read('Auth.User.id'), ActionsEnum::edit);
                        $this->Supplier->updateBalanceClient($supplierId , 0 , -$this->request->data['TransportBill']['total_ttc']);
                        $this->Flash->success(__('The invoice has been saved.'));
                        break;

                    case TransportBillTypesEnum::credit_note :
                        /*$this->SaveTransportBills = $this->Components->load('SaveTransportBills');
                        $this->SaveTransportBills
                            ->cutCreditNoteAfterEditTTCAmountFromInvoiceAmountRemaining($existedTransportBill, $requestData);*/
                        $this->saveUserAction(SectionsEnum::avoir_vente, $id, $this->Session->read('Auth.User.id'), ActionsEnum::edit);
                        $this->Supplier->updateBalanceClient($supplierId , 0 , $this->request->data['TransportBill']['total_ttc']);
                        $this->Flash->success(__('The credit note has been saved.'));
                        break;
                }
            } else {
                switch ($type) {
                    case TransportBillTypesEnum::quote :
                        $this->Flash->error(__('The quotation could not be saved. Please, try again.'));
                        break;
                    case TransportBillTypesEnum::order :
                        $this->Flash->error(__('The customer order could not be saved. Please, try again.'));
                        break;
                    case TransportBillTypesEnum::pre_invoice :

                        $this->Flash->error(__('The preinvoice could not be saved. Please, try again.'));
                        break;
                    case TransportBillTypesEnum::invoice :
                        $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
                        break;
                }
            }
            if (isset($this->request->data['duplicate'])) {
                $this->duplicate_relance(3, $type, $id);
            } elseif (isset($this->request->data['duplicate_revive'])) {
                $transport_bill_id = $this->duplicate_relance(4, $type, $id);
                $this->sendMail($type, $transport_bill_id, 0);
            } else {
                if(isset($this->params['pass']['2']) && $this->params['pass']['2']=='TransportBillDetailRides'){
                    $this->redirect(array('controller'=>'TransportBillDetailRides','action' => 'index'));
                }else {
                    $this->redirect($url);
                }

            }
        } else {
            $options = array('conditions' => array('TransportBill.' . $this->TransportBill->primaryKey => $id));
            $this->request->data = $this->TransportBill->find('first', $options);
            if($type == TransportBillTypesEnum::credit_note){
                $invoices = $this->TransportBill->getInvoices('list',$this->request->data['TransportBill']['supplier_id']);
                $this->set(compact('invoices'));
            }
            if ($this->request->data['TransportBill']['locked'] == 1) {
                $this->Flash->error(__('You must first unlock the bill.'));

                if(isset($this->params['pass']['2']) && $this->params['pass']['2']=='TransportBillDetailRides'){
                    $this->redirect(array('controller'=>'TransportBillDetailRides','action' => 'index'));
                }else {
                    $this->redirect($url);
                }
            }
            $this->isOpenedByOtherUser("TransportBill", 'TransportBills', 'bill', $id, $type);
            $transportBillRides = $this->TransportBillDetailRides->geDetailedTBDRByTransportBillId($id);
            $transportBillRideIds =array();
            $detailRideIds = array();
            $departureIds = array();
            $arrivalIds = array();
            $supplierFinalIds = array();
            $carIds = array();
            $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
            if ($usePurchaseBill == 1) {
                $usedProductIds = array();
                $i = 1;
                foreach ($transportBillRides as $transportBillRide) {
                    $transportBillRideIds[] = $transportBillRide['TransportBillDetailRides']['id'];
                    $detailRideIds[] = $transportBillRide['DetailRide']['id'];
                    $departureIds[] = $transportBillRide['Departure']['id'];
                    $arrivalIds[] = $transportBillRide['Arrival']['id'];
                    $supplierFinalIds[] = $transportBillRide['TransportBillDetailRides']['supplier_final_id'];
                    $carIds[] = $transportBillRide['TransportBillDetailRides']['car_id'];
                    $lot = $this->Lot->getLotById($transportBillRide['TransportBillDetailRides']['lot_id']);
                    $productId = $lot['Lot']['product_id'];
                    $product = $this->Product->getProductById($productId);
                    $usedProductIds[$i]['id'] = $productId;
                    $usedProductIds[$i]['with_lot'] = $product['Product']['with_lot'];
                    $i++;
                }
                $this->set('usedProductIds', $usedProductIds);
            } else {
                foreach ($transportBillRides as $transportBillRide) {
                    $transportBillRideIds[] = $transportBillRide['TransportBillDetailRides']['id'];
                    $detailRideIds[] = $transportBillRide['DetailRide']['id'];
                    $departureIds[] = $transportBillRide['Departure']['id'];
                    $arrivalIds[] = $transportBillRide['Arrival']['id'];
                    $supplierFinalIds[] = $transportBillRide['TransportBillDetailRides']['supplier_final_id'];
                    $carIds[] = $transportBillRide['TransportBillDetailRides']['car_id'];
                }


            }

            $transportBillDetailRideInputFactors = $this->TransportBillDetailRideFactor->find('all',
                array('conditions'=>array(
                        'TransportBillDetailRideFactor.transport_bill_detail_ride_id'=>$transportBillRideIds,
                         'Factor.factor_type = 1'
                        ),
                    'recursive'=>-1,
                    'order'=>array('TransportBillDetailRideFactor.transport_bill_detail_ride_id ASC'),
                    'fields'=>array('TransportBillDetailRideFactor.transport_bill_detail_ride_id',
                        'TransportBillDetailRideFactor.factor_id',
                        'TransportBillDetailRideFactor.id',
                        'TransportBillDetailRideFactor.factor_value',
                        'Factor.name',
                        'Factor.factor_type',
                    ),
                    'joins'=>array(
                        array(
                            'table' => 'factors',
                            'type' => 'left',
                            'alias' => 'Factor',
                            'conditions' => array('TransportBillDetailRideFactor.factor_id = Factor.id')
                        ),
                    )
                )
            );
            $transportBillDetailRideSelectFactors = $this->TransportBillDetailRideFactor->find('all',
                array('conditions'=>array(
                        'TransportBillDetailRideFactor.transport_bill_detail_ride_id'=>$transportBillRideIds,
                         'Factor.factor_type = 2'
                        ),
                    'recursive'=>-1,
                    'order'=>array('TransportBillDetailRideFactor.transport_bill_detail_ride_id ASC'),
                    'fields'=>array('TransportBillDetailRideFactor.transport_bill_detail_ride_id',
                        'TransportBillDetailRideFactor.factor_id',
                        'TransportBillDetailRideFactor.id',
                        'TransportBillDetailRideFactor.factor_value',
                        'Factor.name',
                        'Factor.factor_type',
                    ),
                    'joins'=>array(
                        array(
                            'table' => 'factors',
                            'type' => 'left',
                            'alias' => 'Factor',
                            'conditions' => array('TransportBillDetailRideFactor.factor_id = Factor.id')
                        ),
                    )
                )
            );

            if(!empty($transportBillDetailRideSelectFactors)){
                    $i=0;
                    foreach ($transportBillDetailRideSelectFactors as $factor){
                        $this->loadModel($factor['Factor']['name']);
                        $model = $factor['Factor']['name'];
                        $transportBillDetailRideSelectFactors[$i]['Factor']['options'] = $this->$model->find('list');
                        $i  ++;
                    }
            }
            $this->set(compact('transportBillDetailRideInputFactors','transportBillDetailRideSelectFactors'));
            $virtualFields = array('cnames' => "CONCAT(DepartureDestination.name, ' - ', ArrivalDestination.name,' - ', CarType.name)");
            $detailRideConditions = array('DetailRide.id' => $detailRideIds);
            $detailRides = $this->DetailRide->getDetailRideByConditions($detailRideConditions, "list", $virtualFields);
            $departures = $this->Destination->getDestinationsByConditions(array('Destination.id' => $departureIds), 'list');
            $arrivals = $this->Destination->getDestinationsByConditions(array('Destination.id' => $arrivalIds), 'list');
            $suppliers = $this->Supplier->getSuppliersByParams(1, 1, null, array(2, 3), null, $this->request->data['TransportBill']['supplier_id']);
            $supplierId = $this->request->data['TransportBill']['supplier_id'];
            $finalSuppliers = $this->Supplier->getFinalSuppliersByInitialSupplier($supplierId, $supplierFinalIds);
            $nbRides = $this->TransportBillDetailRides->find('count',
                array('conditions' => array('TransportBillDetailRides.transport_bill_id' => $id)));
            $tvas = $this->Tva->getTvas();
            $supplierId = $this->request->data['TransportBill']['supplier_id'];
            $isVariousSupplier = $this->Supplier->isVariousSupplier($supplierId);

            $advancedPayments = $this->Payment->getAdvancedPaymentsBySupplierId($supplierId);
            $remainingPayments = $this->Payment->getPaymentsWithOverAmountBySupplierId($supplierId);
            $paymentParts = $this->Payment->getPaymentPartsByTransportBillIds($id);
            $separatorAmount = $this->getSeparatorAmount();
            $deadlines = $this->Deadline->getDeadlinesByTransportBillId($id);
            $conditionsCustomer = array('Customer.id' => $this->request->data['TransportBill']['customer_id']);
            $fields = "names";
            $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditionsCustomer);
            $typeRide = $this->Parameter->getCodesParameterVal('type_ride');
            $typeRideUsedFirst = $this->Parameter->getCodesParameterVal('type_ride_used_first');
            if ($typeRideUsedFirst != 1) {
                $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validatePersonalizedRide;
            }
            $carTypes = $this->CarType->getCarTypes();
            $conditions =array('Car.id'=>$carIds);
            $param = $this->Parameter->getCodesParameterVal('name_car');
            $cars = $this->Car->getCarsByCondition($param,$conditions );

            $lots = $this->Lot->getLots();
            $priceCategories = $this->PriceCategory->getPriceCategories('list');
            $products = $this->Product->getProducts('list');
            $typePricing = $this->Parameter->getCodesParameterVal('type_pricing');
            if ($typePricing == 2 || $typePricing == 3) {
                $tonnages = $this->Tonnage->getTonnages();
                $this->set(compact('tonnages'));
            }
            $this->set(compact('advancedPayments', 'remainingPayments', 'separatorAmount',
                'paymentParts', 'tvas', 'transportBillRides','cars',
                'totalAmountRemaining', 'totalAmount', 'deadlines', 'customers', 'typeRide',
                'typeRideUsedFirst', 'products', 'typePricing','isVariousSupplier',
                'carTypes', 'departures', 'arrivals', 'lots', 'detailRides', 'suppliers',
                'finalSuppliers', 'nbRides', 'priceCategories', 'usePurchaseBill'));
        }
        $useRideCategory = $this->  useRideCategory();
        if ($useRideCategory == 2) {
            $rideCategories = $this->RideCategory->getRideCategories();
            $this->set(compact('rideCategories'));
        }
        $transportBillCategories = $this->TransportBillCategory->getTransportBillCategories();
        $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
        $profileId = $this->Auth->user('profile_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        $this->set('profileId', $profileId);
        if ($type == TransportBillTypesEnum::order) {

            if ($profileId == ProfilesEnum::client) {
                $supplierId = $this->Auth->user('supplier_id');

                $this->set(compact('supplierId'));
            }
        }
        $nbTrucksModifiable = $this->Parameter->getCodesParameterVal('nb_trucks_modifiable');
        $defaultNbTrucks = $this->Parameter->getCodesParameterVal('default_nb_trucks');
        $roleId = $this->Auth->user('role_id');
        $permissionEditInputLocked = $this->AccessPermission->getPermissionWithParams(SectionsEnum::commande_client,
            ActionsEnum::edit_input_locked, $profileId, $roleId);

        if($this->request->data['TransportBill']['with_penalty']==1
            && $type== TransportBillTypesEnum::invoice){
           $penalties = $this->TransportBillPenalty->getPenaltiesByTransportBillId($id);

        }else {
            $penalties = array();
        }
        $services = $this->Service->getServices('list');
        $marchandiseUnits = $this->Marchandise->MarchandiseUnit->find('list', array('order' => 'name ASC'));
        $this->set(compact('type', 'useRideCategory',
            'transportBillCategories','penalties','services',
            'paramPriceNight', 'nbTrucksModifiable',
            'defaultNbTrucks', 'permissionEditInputLocked','marchandiseUnits'));
    }





    public function updateAmountRemaining($transportBillId = null)
    {
        $detailPayments = $this->DetailPayment->find('all', array(
            'recursive' => -1,
            'conditions' => array('DetailPayment.transport_bill_id' => $transportBillId),
            'fields' => array(
                'sum(DetailPayment.payroll_amount) as total_payroll_amount'
            ),
        ));
        $transportBill = $this->TransportBill->find('first',
            array(
                'recursive' => -1,
                'conditions' => array(
                    'TransportBill.id' => $transportBillId
                ),
                'fields' => array(
                    'TransportBill.total_ttc',
                    'TransportBill.supplier_id'
                )
            ));
        $totalPayrolAmount = $detailPayments[0][0]['total_payroll_amount'];

        if ($totalPayrolAmount > 0) {
            $amountRemaining = $transportBill['TransportBill']['total_ttc'] - $totalPayrolAmount;
        } else {
            $amountRemaining = $transportBill['TransportBill']['total_ttc'];
        }

        if ($amountRemaining > 0) {
            $this->TransportBill->id = $transportBillId;
            $this->TransportBill->saveField('amount_remaining', $amountRemaining);
        } else {
            $this->TransportBill->id = $transportBillId;
            $this->TransportBill->saveField('amount_remaining', 0);
        }
        $this->updateStatusBill($transportBillId);
        $supplierId = $transportBill['TransportBill']['supplier_id'];
        $totalTtc = $transportBill['TransportBill']['total_ttc'];
        $this->Supplier->updateBalanceClient($supplierId , -$totalTtc , -$amountRemaining);

    }

    public function updateStatusBill($articleId)
    {
        $invoice = $this->TransportBill->find('first', array(
            'conditions' => array('TransportBill.id' => $articleId),
            'fields' => array('TransportBill.id', 'TransportBill.total_ttc', 'TransportBill.amount_remaining')
        ));
        if (!empty($invoice)) {
            if ($invoice['TransportBill']['amount_remaining'] > 0) {
                if ($invoice['TransportBill']['amount_remaining'] == $invoice['TransportBill']['total_ttc']) {
                    $payed = 1;
                } else {
                    $payed = 3;
                }
            } else {
                $payed = 2;
            }
            $this->TransportBill->id = $invoice['TransportBill']['id'];
            $this->TransportBill->saveField('status_payment', $payed);
        }
    }


    function getStatusPayment($amountRemaining,$totalTtc){

        if ($amountRemaining > 0) {
            if ($amountRemaining == $totalTtc) {
                $payed = 1;
            } else {
                $payed = 3;
            }
        } else {
            $payed = 2;
        }
        return $payed;

    }
    function update_Ride_transportBill(
        $transportBillDetailRide = null,
        $transportBillId = null,
        $transportBillDetailRideId = null,
        $type = null,
        $clientFinalId = null
    )
    {


        $product = $this->Product->getProductById($transportBillDetailRide['product_id']);
        $productTypeId = $product['Product']['product_type_id'];
        $relationWithPark = $product['ProductType']['relation_with_park'];
        switch ($productTypeId){
            case 1 :
                if (isset($transportBillDetailRide['detail_ride_id'])) {
                    $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validate;
                } else {
                    $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validatePersonalizedRide;
                }
                break;
            case 3 :
                $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validateProvision;

                break;
            default :
                $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validateProduct;

                break;
        } 

        $possibilityToSave = 1;


        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        $permissionEditInputLocked = $this->AccessPermission->getPermissionWithParams(SectionsEnum::commande_client,
            ActionsEnum::edit_input_locked, $profileId, $roleId);
        if($permissionEditInputLocked ==1 && $type == TransportBillTypesEnum::order){
            $sheetRideDetailRides = $this->SheetRideDetailRides->getSheetRideDetailRidesByTransportBillDetailRideId($transportBillDetailRideId);
            $sheetRideDetailRideInvoiced= 0;
            foreach ($sheetRideDetailRides as $sheetRideDetailRide){
                if($sheetRideDetailRideInvoiced == 0 &&
                    (   $sheetRideDetailRide['SheetRideDetailRides']['status_id']==StatusEnum::mission_invoiced ||
                        $sheetRideDetailRide['SheetRideDetailRides']['status_id']==StatusEnum::mission_pre_invoiced||
                        $sheetRideDetailRide['SheetRideDetailRides']['status_id']==StatusEnum::mission_not_approved ||
                        $sheetRideDetailRide['SheetRideDetailRides']['status_id']==StatusEnum::mission_approved
                    )){
                    $sheetRideDetailRideInvoiced =1;
                }
            }
            if($sheetRideDetailRideInvoiced ==1){
                $possibilityToSave = 0;
            }


        }
        if( $possibilityToSave ==1){
            $data['TransportBillDetailRides']['id'] = $transportBillDetailRideId;
            $data['TransportBillDetailRides']['transport_bill_id'] = $transportBillId;

            if (isset($transportBillDetailRide['from_customer_order'])) {
                $data['TransportBillDetailRides']['from_customer_order'] = $transportBillDetailRide['from_customer_order'];
            }

            if (isset($transportBillDetailRide['type_ride'])) {
                $data['TransportBillDetailRides']['type_ride'] = $transportBillDetailRide['type_ride'];
            }else {
                if($relationWithPark==1){
                    $data['TransportBillDetailRides']['type_ride'] = 2;
                }
            }

            if (isset($transportBillDetailRide['type_pricing'])) {
                $data['TransportBillDetailRides']['type_pricing'] = $transportBillDetailRide['type_pricing'];
            }

            if (isset($transportBillDetailRide['detail_ride_id'])) {
                $data['TransportBillDetailRides']['detail_ride_id'] = $transportBillDetailRide['detail_ride_id'];
            } else {
                $data['TransportBillDetailRides']['detail_ride_id'] = NULL;
            }
            if (isset($transportBillDetailRide['departure_destination_id'])) {
                $data['TransportBillDetailRides']['departure_destination_id'] = $transportBillDetailRide['departure_destination_id'];
            } else {
                $data['TransportBillDetailRides']['departure_destination_id'] = NULL;
            }
            if (isset($transportBillDetailRide['arrival_destination_id'])) {
                $data['TransportBillDetailRides']['arrival_destination_id'] = $transportBillDetailRide['arrival_destination_id'];
            } else {
                $data['TransportBillDetailRides']['arrival_destination_id'] = NULL;
            }
            if (isset($transportBillDetailRide['car_type_id'])) {
                $data['TransportBillDetailRides']['car_type_id'] = $transportBillDetailRide['car_type_id'];
            } else {
                $data['TransportBillDetailRides']['car_type_id'] = NULL;
            }
            if (isset($transportBillDetailRide['product_id'])) {
                $productId = $transportBillDetailRide['product_id'];
                $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
                if ($usePurchaseBill == 1) {
                    $product = $this->Product->getProductById($productId);
                    $productWithLot = $product['Product']['with_lot'];
                    if ($productWithLot == 1) {
                        $lotId = $transportBillDetailRide['lot_id'];
                    } else {
                        $lotId = $transportBillDetailRide['product_id'];
                    }
                } else {
                    $lotId = $transportBillDetailRide['product_id'];
                }
                $data['TransportBillDetailRides']['lot_id'] = $lotId;
            } else {
                $data['TransportBillDetailRides']['lot_id'] = NULL;
            }

            if (isset($transportBillDetailRide['designation'])) {
                $data['TransportBillDetailRides']['designation'] = $transportBillDetailRide['designation'];
            } else {
                $data['TransportBillDetailRides']['designation'] = NULL;
            }

            if (isset($transportBillDetailRide['description'])) {
                $data['TransportBillDetailRides']['description'] = $transportBillDetailRide['description'];
            } else {
                $data['TransportBillDetailRides']['description'] = NULL;
            }

            if (isset($transportBillDetailRide['observation_order'])) {
                $data['TransportBillDetailRides']['observation_order'] = $transportBillDetailRide['observation_order'];
            } else {
                $data['TransportBillDetailRides']['observation_order'] = NULL;
            }

            if (isset($transportBillDetailRide['supplier_final_id'])) {
                $data['TransportBillDetailRides']['supplier_final_id'] = $transportBillDetailRide['supplier_final_id'];
            } else {
                $data['TransportBillDetailRides']['supplier_final_id'] = $clientFinalId;
            }

            if(isset($transportBillDetailRide['programming_date'])){
                $this->request->data['TransportBillDetailRides']['programming_date'] = $transportBillDetailRide['programming_date'];
                $this->createDateFromDate('TransportBillDetailRides', 'programming_date');
                $transportBillDetailRide['programming_date'] = $this->request->data['TransportBillDetailRides']['programming_date'];

                $data['TransportBillDetailRides']['programming_date'] = $transportBillDetailRide['programming_date'];
            }

            if(isset($transportBillDetailRide['charging_time'])){
                $data['TransportBillDetailRides']['charging_time'] = $transportBillDetailRide['charging_time'];
            }


            if(isset($transportBillDetailRide['unloading_date'])){
                $this->request->data['TransportBillDetailRides']['unloading_date'] = $transportBillDetailRide['unloading_date'];
                $this->createDatetimeFromDatetime('TransportBillDetailRides', 'unloading_date');
                $transportBillDetailRide['unloading_date'] = $this->request->data['TransportBillDetailRides']['unloading_date'];

                $data['TransportBillDetailRides']['unloading_date'] = $transportBillDetailRide['unloading_date'];
            }

            if(isset($transportBillDetailRide['start_date'])){
                $this->request->data['TransportBillDetailRides']['start_date'] = $transportBillDetailRide['start_date'];
                $this->createDatetimeFromDatetime('TransportBillDetailRides', 'start_date');
                $transportBillDetailRide['start_date'] = $this->request->data['TransportBillDetailRides']['start_date'];

                $data['TransportBillDetailRides']['start_date'] = $transportBillDetailRide['start_date'];
            }
            if(isset($transportBillDetailRide['end_date'])){
                $this->request->data['TransportBillDetailRides']['end_date'] = $transportBillDetailRide['end_date'];
                $this->createDatetimeFromDatetime('TransportBillDetailRides', 'end_date');
                $transportBillDetailRide['end_date'] = $this->request->data['TransportBillDetailRides']['end_date'];
                $data['TransportBillDetailRides']['end_date'] = $transportBillDetailRide['end_date'];
            }


            if (isset($transportBillDetailRide['car_id'])) {
                $data['TransportBillDetailRides']['car_id'] = $transportBillDetailRide['car_id'];
            } else {
                $data['TransportBillDetailRides']['car_id'] = NULL;
            }
            if (isset($transportBillDetailRide['nb_hours'])) {
                $data['TransportBillDetailRides']['nb_hours'] = $transportBillDetailRide['nb_hours'];
            } else {
                $data['TransportBillDetailRides']['nb_hours'] = NULL;
            }

            if (isset($transportBillDetailRide['ride_category_id'])) {
                $data['TransportBillDetailRides']['ride_category_id'] = $transportBillDetailRide['ride_category_id'];
            }
            if (isset($transportBillDetailRide['type_price'])) {
                $data['TransportBillDetailRides']['type_price'] = $transportBillDetailRide['type_price'];
            } else {
                $data['TransportBillDetailRides']['type_price'] = 1;
            }
            $data['TransportBillDetailRides']['unit_price'] = $transportBillDetailRide['unit_price'];
            $data['TransportBillDetailRides']['nb_trucks'] = $transportBillDetailRide['nb_trucks'];
            $data['TransportBillDetailRides']['price_ht'] = $transportBillDetailRide['price_ht'];
            $data['TransportBillDetailRides']['price_ttc'] = $transportBillDetailRide['price_ttc'];
            $data['TransportBillDetailRides']['tva_id'] = $transportBillDetailRide['tva_id'];
            if (isset($transportBillDetailRide['ristourne_val'])) {
                $data['TransportBillDetailRides']['ristourne_val'] = $transportBillDetailRide['ristourne_val'];
            } else {
                $data['TransportBillDetailRides']['ristourne_val'] = 0;
            }
            if (isset($transportBillDetailRide['ristourne_%'])) {
                $data['TransportBillDetailRides']['ristourne_%'] = $transportBillDetailRide['ristourne_%'];
            } else {
                $data['TransportBillDetailRides']['ristourne_%'] = 0;
            }
            if (isset($transportBillDetailRide['sheet_ride_detail_ride_id'])) {
                $data['TransportBillDetailRides']['sheet_ride_detail_ride_id'] = $transportBillDetailRide['sheet_ride_detail_ride_id'];
            }
            if (isset($transportBillDetailRide['delivery_with_return'])) {
                $data['TransportBillDetailRides']['delivery_with_return'] = $transportBillDetailRide['delivery_with_return'];
            }
            if (isset($transportBillDetailRide['marchandise_unit_id'])) {
                $data['TransportBillDetailRides']['marchandise_unit_id'] = $transportBillDetailRide['marchandise_unit_id'];
            }
            $savedTransportBillDetailRide = $this->TransportBillDetailRides->find('first',array(
                    'conditions' => array(
                            'TransportBillDetailRides.id' => $data['TransportBillDetailRides']['id']
                    )
            ));
            /*$data['TransportBillDetailRides']['departure_destination_id'] =
                $savedTransportBillDetailRide['TransportBillDetailRides']['departure_destination_id'];
            $data['TransportBillDetailRides']['arrival_destination_id'] =
                $savedTransportBillDetailRide['TransportBillDetailRides']['arrival_destination_id'];
            $data['TransportBillDetailRides']['car_type_id'] =
                $savedTransportBillDetailRide['TransportBillDetailRides']['car_type_id'];*/
             if($relationWithPark !=1 && $type == TransportBillTypesEnum::order) {
                $data['TransportBillDetailRides']['status_id'] = $transportBillDetailRide['status_id'];
            }
            if ($type == TransportBillTypesEnum::pre_invoice) {
                $data['TransportBillDetailRides']['approved'] = $transportBillDetailRide['approved'];

            }
            $this->TransportBillDetailRides->save($data);
            $this->TransportBillDetailedRidesManagement->editDetailedRide($data['TransportBillDetailRides'],$transportBillId);
            $userId = $this->Auth->user('id');
            $this->TransportBillDetailedRidesManagement->addDifferenceTransportBillDetailedRides($transportBillDetailRide,$transportBillId,$type, $userId);
            if ($type == TransportBillTypesEnum::order && $relationWithPark == 1) {
                $observations = $this->Observation->getObservationsByTransportBillDetailRideId($transportBillDetailRideId);
                $nbObservations = count($observations);
                if ($nbObservations > $data['TransportBillDetailRides']['nb_trucks']) {
                    $this->Observation->deleteAll(array('Observation.transport_bill_detail_ride_id' => $transportBillDetailRideId),
                        false);
                    $this->Observation->addObservations($transportBillDetailRideId,
                        $data['TransportBillDetailRides']['nb_trucks']);
                } else {
                    $differenceNbTruck = $data['TransportBillDetailRides']['nb_trucks'] - $nbObservations;
                    $this->Observation->addObservations($transportBillDetailRideId, $differenceNbTruck);
                }
                $synchronizationFrBc = $this->Parameter->getCodesParameterVal('synchronization_fr_bc');

                if ($synchronizationFrBc == 1) {
                    $sheetRideDetailRides = $this->SheetRideDetailRides->getSheetRideDetailRidesByTransportBillDetailRideId($transportBillDetailRideId);
                    if (!empty($sheetRideDetailRides)) {
                        $transportBillDetailRide = $this->TransportBillDetailRides->getTransportBillDetailRidesById($transportBillDetailRideId);

                        $this->updateSheetRideDetailRidesInformations($sheetRideDetailRides, $transportBillDetailRide);
                    }
                }

            }

                if(isset($transportBillDetailRide['TransportBillDetailRideFactor'])&&
                !empty($transportBillDetailRide['TransportBillDetailRideFactor'])){
                    $productPriceFactors = $transportBillDetailRide['TransportBillDetailRideFactor'];
                    foreach ($productPriceFactors as $productPriceFactor){
                        $data2 = array();
                        $data2['TransportBillDetailRideFactor']['transport_bill_detail_ride_id'] = $transportBillDetailRideId;
                        $data2['TransportBillDetailRideFactor']['factor_id'] = $productPriceFactor['factor_id'];
                        $data2['TransportBillDetailRideFactor']['factor_value'] = $productPriceFactor['factor_value'];
                        if(isset($productPriceFactor['id'])){
                            $data2['TransportBillDetailRideFactor']['id'] = $productPriceFactor['id'];

                        }else {
                            $this->TransportBillDetailRideFactor->create();
                        }

                        $this->TransportBillDetailRideFactor->save($data2);
                    }
                }




        }


    }

    public function updateSheetRideDetailRidesInformations($sheetRideDetailRides = null, $transportBillDetailRide = null)
    {


        foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
            $data['SheetRideDetailRides']['id'] = $sheetRideDetailRide['SheetRideDetailRides']['id'];
            if ($transportBillDetailRide['TransportBillDetailRides']['type_ride'] == 2) {
                $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validatePersonalizedRide;
                $data['SheetRideDetailRides']['departure_destination_id'] = $transportBillDetailRide['TransportBillDetailRides']['departure_destination_id'];
                $data['SheetRideDetailRides']['arrival_destination_id'] = $transportBillDetailRide['TransportBillDetailRides']['arrival_destination_id'];
            } else {
                $data['SheetRideDetailRides']['detail_ride_id'] = $transportBillDetailRide['TransportBillDetailRides']['detail_ride_id'];
            }
            $data['SheetRideDetailRides']['supplier_id'] = $transportBillDetailRide['TransportBill']['supplier_id'];
            $data['SheetRideDetailRides']['supplier_final_id'] = $transportBillDetailRide['TransportBillDetailRides']['supplier_final_id'];


            $this->SheetRideDetailRides->save($data);

        }

    }

    function add_Ride_transportBill(
        $transportBillDetailRide = null,
        $reference = null,
        $transportBillId = null,
        $type = null,
        $clientFinalId = null,
        $customerOrderValidationMethod = null
    )
    {


        $save = false;
        $product = $this->Product->getProductById($transportBillDetailRide['product_id']);
        $productTypeId = $product['Product']['product_type_id'];
        $relationWithPark = $product['ProductType']['relation_with_park'];
        switch ($productTypeId){
            case 1 :
                if (isset($transportBillDetailRide['detail_ride_id'])) {
                    $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validate;
                } else {
                    $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validatePersonalizedRide;
                }
                break;
            case 3 :
                $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validateProvision;

                break;
            default :
                $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validateProduct;

                break;
        }

        $this->TransportBillDetailRides->create();
        if ($reference != null) {
            $referenceTransportBillDetailRide = $this->getReferenceTransportBillDetailRide($transportBillId,
                $reference);
            $data['TransportBillDetailRides']['reference'] = $referenceTransportBillDetailRide;
        }
        $data['TransportBillDetailRides']['transport_bill_id'] = $transportBillId;
        if (isset($transportBillDetailRide['from_customer_order'])) {
            $data['TransportBillDetailRides']['from_customer_order'] = $transportBillDetailRide['from_customer_order'];
        }
        if (isset($transportBillDetailRide['type_ride'])) {
            $data['TransportBillDetailRides']['type_ride'] = $transportBillDetailRide['type_ride'];
        }else {
            if($relationWithPark==1){
                $data['TransportBillDetailRides']['type_ride'] = 2;
            }
        }

        if (isset($transportBillDetailRide['type_pricing'])) {
            $data['TransportBillDetailRides']['type_pricing'] = $transportBillDetailRide['type_pricing'];
        }

        if (isset($transportBillDetailRide['detail_ride_id'])) {
            $data['TransportBillDetailRides']['detail_ride_id'] = $transportBillDetailRide['detail_ride_id'];
        }
        if (isset($transportBillDetailRide['departure_destination_id'])) {
            $data['TransportBillDetailRides']['departure_destination_id'] = $transportBillDetailRide['departure_destination_id'];
        } else {
            $data['TransportBillDetailRides']['departure_destination_id'] = NULL;
        }
        if (isset($transportBillDetailRide['arrival_destination_id'])) {
            $data['TransportBillDetailRides']['arrival_destination_id'] = $transportBillDetailRide['arrival_destination_id'];
        } else {
            $data['TransportBillDetailRides']['arrival_destination_id'] = NULL;
        }

        if (isset($transportBillDetailRide['car_type_id'])) {
            $data['TransportBillDetailRides']['car_type_id'] = $transportBillDetailRide['car_type_id'];
        } else {
            $data['TransportBillDetailRides']['car_type_id'] = NULL;
        }

        if (isset($transportBillDetailRide['product_id'])) {
            $productId = $transportBillDetailRide['product_id'];
            $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
            if ($usePurchaseBill == 1) {
                $product = $this->Product->getProductById($productId);
                $productWithLot = $product['Product']['with_lot'];
                if ($productWithLot == 1) {
                    $lotId = $transportBillDetailRide['lot_id'];
                } else {
                    $lotId = $transportBillDetailRide['product_id'];
                }
            } else {
                $lotId = $transportBillDetailRide['product_id'];
            }
            $data['TransportBillDetailRides']['lot_id'] = $lotId;
        } else {
            $data['TransportBillDetailRides']['lot_id'] = NULL;
        }

        if (isset($transportBillDetailRide['designation'])) {
            $data['TransportBillDetailRides']['designation'] = $transportBillDetailRide['designation'];
        } else {
            $data['TransportBillDetailRides']['designation'] = NULL;
        }

        if (isset($transportBillDetailRide['description'])) {
            $data['TransportBillDetailRides']['description'] = $transportBillDetailRide['description'];
        } else {
            $data['TransportBillDetailRides']['description'] = NULL;
        }

        if (isset($transportBillDetailRide['observation_order'])) {
            $data['TransportBillDetailRides']['observation_order'] = $transportBillDetailRide['observation_order'];
        } else {
            $data['TransportBillDetailRides']['observation_order'] = NULL;
        }

        if (isset($transportBillDetailRide['supplier_final_id'])) {
            $data['TransportBillDetailRides']['supplier_final_id'] = $transportBillDetailRide['supplier_final_id'];
        } else {
            $data['TransportBillDetailRides']['supplier_final_id'] = $clientFinalId;
        }

        if(isset($transportBillDetailRide['programming_date'])){
            $this->request->data['TransportBillDetailRides']['programming_date'] = $transportBillDetailRide['programming_date'];
            $this->createDateFromDate('TransportBillDetailRides', 'programming_date');
            $transportBillDetailRide['programming_date'] = $this->request->data['TransportBillDetailRides']['programming_date'];

            $data['TransportBillDetailRides']['programming_date'] = $transportBillDetailRide['programming_date'];
        }

        if(isset($transportBillDetailRide['charging_time'])){
            $data['TransportBillDetailRides']['charging_time'] = $transportBillDetailRide['charging_time'];
        }

        if(isset($transportBillDetailRide['unloading_date'])){
            $this->request->data['TransportBillDetailRides']['unloading_date'] = $transportBillDetailRide['unloading_date'];
            $this->createDatetimeFromDatetime('TransportBillDetailRides', 'unloading_date');
            $transportBillDetailRide['unloading_date'] = $this->request->data['TransportBillDetailRides']['unloading_date'];

            $data['TransportBillDetailRides']['unloading_date'] = $transportBillDetailRide['unloading_date'];
        }
        if(isset($transportBillDetailRide['start_date'])){
            $this->request->data['TransportBillDetailRides']['start_date'] = $transportBillDetailRide['start_date'];
            $this->createDatetimeFromDatetime('TransportBillDetailRides', 'start_date');
            $transportBillDetailRide['start_date'] = $this->request->data['TransportBillDetailRides']['start_date'];

            $data['TransportBillDetailRides']['start_date'] = $transportBillDetailRide['start_date'];
        }
        if(isset($transportBillDetailRide['end_date'])){
            $this->request->data['TransportBillDetailRides']['end_date'] = $transportBillDetailRide['end_date'];
            $this->createDatetimeFromDatetime('TransportBillDetailRides', 'end_date');
            $transportBillDetailRide['end_date'] = $this->request->data['TransportBillDetailRides']['end_date'];
            $data['TransportBillDetailRides']['end_date'] = $transportBillDetailRide['end_date'];
        }

        if (isset($transportBillDetailRide['car_id'])) {
            $data['TransportBillDetailRides']['car_id'] = $transportBillDetailRide['car_id'];
        } else {
            $data['TransportBillDetailRides']['car_id'] = NULL;
        }
        if (isset($transportBillDetailRide['nb_hours'])) {
            $data['TransportBillDetailRides']['nb_hours'] = $transportBillDetailRide['nb_hours'];
        } else {
            $data['TransportBillDetailRides']['nb_hours'] = NULL;
        }
        if (isset($transportBillDetailRide['ride_category_id'])) {
            $data['TransportBillDetailRides']['ride_category_id'] = $transportBillDetailRide['ride_category_id'];
        }
        if (isset($transportBillDetailRide['type_price'])) {
            $data['TransportBillDetailRides']['type_price'] = $transportBillDetailRide['type_price'];
        } else {
            $data['TransportBillDetailRides']['type_price'] = 1;
        }
        $data['TransportBillDetailRides']['unit_price'] = $transportBillDetailRide['unit_price'];
        $data['TransportBillDetailRides']['nb_trucks'] = $transportBillDetailRide['nb_trucks'];
        $data['TransportBillDetailRides']['price_ht'] = $transportBillDetailRide['price_ht'];
        $data['TransportBillDetailRides']['price_ttc'] = $transportBillDetailRide['price_ttc'];

        $data['TransportBillDetailRides']['tva_id'] = $transportBillDetailRide['tva_id'];
        if (isset($transportBillDetailRide['ristourne_val'])) {
            $data['TransportBillDetailRides']['ristourne_val'] = $transportBillDetailRide['ristourne_val'];
        }
        if (isset($transportBillDetailRide['ristourne_%'])) {
            $data['TransportBillDetailRides']['ristourne_%'] = $transportBillDetailRide['ristourne_%'];
        }



            switch ($type) {
                case TransportBillTypesEnum::quote_request :
                    $data['TransportBillDetailRides']['status_id'] = StatusEnum::quotation;
                    break;
                case TransportBillTypesEnum::quote :
                    $data['TransportBillDetailRides']['status_id'] = StatusEnum::quotation;
                    break;
                case TransportBillTypesEnum::order :
                    if($relationWithPark !=1)
                    {
                    $data['TransportBillDetailRides']['status_id'] = $transportBillDetailRide['status_id'];
                    }else {
                        if ($customerOrderValidationMethod == 1) {
                            $data['TransportBillDetailRides']['status_id'] = TransportBillDetailRideStatusesEnum::not_validated;
                        } else {
                            $data['TransportBillDetailRides']['status_id'] = TransportBillDetailRideStatusesEnum::not_transmitted;
                        }
                    }

                    break;
                case TransportBillTypesEnum::pre_invoice :
                    $data['TransportBillDetailRides']['status_id'] = TransportBillTypesEnum::pre_invoice;;
                    break;
                case TransportBillTypesEnum::invoice :
                    $data['TransportBillDetailRides']['status_id'] = TransportBillTypesEnum::invoice;;
                    break;
                case TransportBillTypesEnum::credit_note :
                    $data['TransportBillDetailRides']['status_id'] = TransportBillTypesEnum::credit_note;;
                    break;
            }


        if (isset($transportBillDetailRide['sheet_ride_detail_ride_id'])) {
            $data['TransportBillDetailRides']['sheet_ride_detail_ride_id'] = $transportBillDetailRide['sheet_ride_detail_ride_id'];
        }
        if ($type == TransportBillTypesEnum::pre_invoice) {
            $data['TransportBillDetailRides']['approved'] = $transportBillDetailRide['approved'];

        }

        if($this->TransportBillDetailRides->save($data)){
            $save = true;
            if ($type == TransportBillTypesEnum::order && $data['TransportBillDetailRides']['lot_id'] == 1) {
                $transportBillDetailRideId = $this->TransportBillDetailRides->getInsertID();
                $this->Observation->addObservations($transportBillDetailRideId,
                    $data['TransportBillDetailRides']['nb_trucks']);
            }

                $transportBillDetailRideId = $this->TransportBillDetailRides->getInsertID();
                if(isset($transportBillDetailRide['TransportBillDetailRideFactor'])&&
                !empty($transportBillDetailRide['TransportBillDetailRideFactor'])){
                    $productPriceFactors =$transportBillDetailRide['TransportBillDetailRideFactor'];
                    foreach ($productPriceFactors as $productPriceFactor){
                        $data2 = array();
                        $data2['TransportBillDetailRideFactor']['transport_bill_detail_ride_id'] = $transportBillDetailRideId;
                        $data2['TransportBillDetailRideFactor']['factor_id'] = $productPriceFactor['factor_id'];
                        $data2['TransportBillDetailRideFactor']['factor_value'] = $productPriceFactor['factor_value'];
                        $this->TransportBillDetailRideFactor->create();
                        $this->TransportBillDetailRideFactor->save($data2);
                    }
                }


        }

        return $save;

    }

    public function getReferenceTransportBillDetailRide($transportBillId = null, $reference = null)
    {

        $countTransportBillDetailRide = $this->TransportBillDetailRides->find('count', array(
            'order' => array('TransportBillDetailRides.reference' => ' DESC'),
            'conditions' => array('TransportBillDetailRides.reference !=' => null, 'TransportBillDetailRides.transport_bill_id' => $transportBillId),
            'recursive' => -1,
            'fields' => array('reference')
        ));

        $lastReference = (int)$countTransportBillDetailRide + 1;
        $nextReference = $reference . '/' . $lastReference;


        return $nextReference;
    }

    public function duplicate_relance($relance_duplicate = null, $type = null, $id = null)
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            return $this->redirect('/');
        }

        $TransportBill = $this->TransportBill->find('first', array(
            'conditions' => array('TransportBill.' . $this->TransportBill->primaryKey => $id),
            'recursive' => -1,
            'fields' => array(
                'TransportBill.id',
                'TransportBill.type',
                'TransportBill.total_ht',
                'TransportBill.total_ttc',
                'TransportBill.total_tva',
                'TransportBill.supplier_id',
            ),
        ));
        $rides_transport_bills = $this->TransportBillDetailRides->find('all', array(
            'order' => 'TransportBillDetailRides.id ASC',
            'recursive' => -1,
            'fields' => array(
                'TransportBillDetailRides.unit_price',
                'TransportBillDetailRides.price_ht',
                'TransportBillDetailRides.price_ttc',
                'TransportBillDetailRides.tva_id',
                'TransportBillDetailRides.ride_category_id',
                'TransportBillDetailRides.delivery_with_return',
                'TransportBillDetailRides.ristourne_%',
                'TransportBillDetailRides.ristourne_val',
                'TransportBillDetailRides.detail_ride_id',
                'TransportBillDetailRides.supplier_final_id',
                'TransportBillDetailRides.nb_trucks',
            ),
            'conditions' => array('TransportBillDetailRides.transport_bill_id' => $id),
        ));
        $transport_bill_id_array = array();
        $transport_bill_id_array[] = $id;
        $date = date("Y-m-d");
        $supplier = null;
        $new_type = $type;
        $origin_type = $type;
        $r_t_d = $relance_duplicate;
        $transport_bill_id = $this->add_transport_bill_detail_rides($TransportBill['TransportBill'],
            $rides_transport_bills, $new_type, $origin_type, $date, $supplier, $transport_bill_id_array, $r_t_d);
        if ($relance_duplicate == '1' || $relance_duplicate == '4') {
            $this->Flash->success(__('The article has been revived'));
        } else {
            $this->Flash->success(__('The article has been duplicated'));
            $this->redirect(array('action' => 'edit', $new_type, $transport_bill_id));
        }
        return $transport_bill_id;
    }

    function add_transport_bill_detail_rides(
        $transportBill = null,
        $transportBillDetailRides = null,
        $newType = null,
        $originType = null,
        $date = null,
        $supplier = null,
        $transportBillIdsArray = null,
        $r_t_d = null,
        $rideFactors= null
    )
    {
        $rides = array();
        $i = 0;
        $totalTtc = 0;
        $totalHt = 0;
        $totalTva = 0;

        if ($originType == 0) {
            foreach ($transportBillDetailRides as $transportBillDetailRide) {
                if ($transportBillDetailRide['TransportBillDetailRides']['unit_price'] == 0) {
                    $detailRideId = $transportBillDetailRide['TransportBillDetailRides']['detail_ride_id'];
                    $clientId = $transportBill['supplier_id'];
                    if (isset($transportBillDetailRide['TransportBillDetailRides']['delivery_with_return'])) {
                        $deliveryWithReturn = $transportBillDetailRide['TransportBillDetailRides']['delivery_with_return'];
                    } else {
                        $deliveryWithReturn = 1;
                    }
                    if (isset($transportBillDetailRide['TransportBillDetailRides']['ride_category_id'])) {
                        $rideCategoryId = $transportBillDetailRide['TransportBillDetailRides']['ride_category_id'];
                    } else {
                        $rideCategoryId = 0;
                    }
                    $price = $this->getPriceRide($detailRideId, 0, $clientId, $deliveryWithReturn, 1, $rideCategoryId);
                    if (!empty($price)) {
                        $unitPriceDeliverySimple = $price[0];
                        $priceReturn = $price[2];
                    } else {
                        $unitPriceDeliverySimple = 0;
                        $priceReturn = 0;
                    }
                    $nbTrucks = $transportBillDetailRide['TransportBillDetailRides']['nb_trucks'];
                    if ($transportBillDetailRide['TransportBillDetailRides']['delivery_with_return'] == 1) {
                        $unitPrice = $unitPriceDeliverySimple;
                    } else {
                        $unitPrice = $priceReturn;
                    }
                    $priceHt = ($unitPrice * $nbTrucks);
                    $priceTtc = $priceHt + ($priceHt * 0.19);
                    $transportBillDetailRide['TransportBillDetailRides']['unit_price'] = $unitPrice;
                    $transportBillDetailRide['TransportBillDetailRides']['price_ht'] = $priceHt;
                    $transportBillDetailRide['TransportBillDetailRides']['price_ttc'] = $priceTtc;
                }
                $totalHt = $totalHt + $transportBillDetailRide['TransportBillDetailRides']['price_ht'];
                $totalTtc = $totalTtc + $transportBillDetailRide['TransportBillDetailRides']['price_ttc'];
                $rides[$i]['detail_ride_id'] = $transportBillDetailRide['TransportBillDetailRides']['detail_ride_id'];
                $rides[$i]['supplier_final_id'] = $transportBillDetailRide['TransportBillDetailRides']['supplier_final_id'];
                $rides[$i]['nb_trucks'] = $transportBillDetailRide['TransportBillDetailRides']['nb_trucks'];
                $rides[$i]['unit_price'] = $transportBillDetailRide['TransportBillDetailRides']['unit_price'];
                if (isset($transportBillDetailRide['TransportBillDetailRides']['delivery_with_return'])) {
                    $rides[$i]['delivery_with_return'] = $transportBillDetailRide['TransportBillDetailRides']['delivery_with_return'];
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['programming_date'])) {
                    $rides[$i]['programming_date'] = $transportBillDetailRide['TransportBillDetailRides']['programming_date'];
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['charging_time'])) {
                    $rides[$i]['charging_time'] = $transportBillDetailRide['TransportBillDetailRides']['charging_time'];
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['unloading_date'])) {
                    $rides[$i]['unloading_date'] = $transportBillDetailRide['TransportBillDetailRides']['unloading_date'];
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['ride_category_id'])) {
                    $rides[$i]['ride_category_id'] = $transportBillDetailRide['TransportBillDetailRides']['ride_category_id'];
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['type_price'])) {
                    $rides[$i]['type_price'] = $transportBillDetailRide['TransportBillDetailRides']['type_price'];
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['lot_id'])) {
                    $rides[$i]['lot_id'] = $transportBillDetailRide['TransportBillDetailRides']['lot_id'];
                    $lot = $this->Lot->getLotById($transportBillDetailRide['TransportBillDetailRides']['lot_id']);
                    if (!empty($lot)) {
                        $rides[$i]['product_id'] = $lot['Lot']['product_id'];
                    } else {
                        $rides[$i]['product_id'] = NULL;
                    }
                }
                $rides[$i]['price_ht'] = $transportBillDetailRide['TransportBillDetailRides']['price_ht'];
                $rides[$i]['tva_id'] = $transportBillDetailRide['TransportBillDetailRides']['tva_id'];
                $rides[$i]['price_ttc'] = $transportBillDetailRide['TransportBillDetailRides']['price_ttc'];
                $rides[$i]['ristourne_%'] = $transportBillDetailRide['TransportBillDetailRides']['ristourne_%'];
                $rides[$i]['ristourne_val'] = $transportBillDetailRide['TransportBillDetailRides']['ristourne_val'];
                if (isset($transportBillDetailRide['TransportBillDetailRides']['sheet_ride_detail_ride_id'])) {
                    $rides[$i]['sheet_ride_detail_ride_id'] = $transportBillDetailRide['TransportBillDetailRides']['sheet_ride_detail_ride_id'];
                }
                if ($newType == TransportBillTypesEnum::invoice) {
                    $rides[$i]['approved'] = $newType;
                }
                $i++;
            }
            $totalTva = $totalTtc - $totalHt;

        } else {
            foreach ($transportBillDetailRides as $transportBillDetailRide) {
                if (isset($transportBillDetailRide['TransportBillDetailRides']['from_customer_order'])) {
                    $rides[$i]['from_customer_order'] = $transportBillDetailRide['TransportBillDetailRides']['from_customer_order'];
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['type_ride'])) {
                    $rides[$i]['type_ride'] = $transportBillDetailRide['TransportBillDetailRides']['type_ride'];
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['type_pricing'])) {
                    $rides[$i]['type_pricing'] = $transportBillDetailRide['TransportBillDetailRides']['type_pricing'];
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['tonnage_id'])) {
                    $rides[$i]['tonnage_id'] = $transportBillDetailRide['TransportBillDetailRides']['tonnage_id'];
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['lot_id'])) {
                    $rides[$i]['lot_id'] = $transportBillDetailRide['TransportBillDetailRides']['lot_id'];
                    $lot = $this->Lot->getLotById($transportBillDetailRide['TransportBillDetailRides']['lot_id']);
                    if (!empty($lot)) {
                        $rides[$i]['product_id'] = $lot['Lot']['product_id'];
                    } else {
                        $rides[$i]['product_id'] = NULL;
                    }
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['designation'])) {
                    $rides[$i]['designation'] = $transportBillDetailRide['TransportBillDetailRides']['designation'];
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['description'])) {
                    $rides[$i]['description'] = $transportBillDetailRide['TransportBillDetailRides']['description'];
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['car_type_id'])) {
                    $rides[$i]['car_type_id'] = $transportBillDetailRide['TransportBillDetailRides']['car_type_id'];
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['detail_ride_id'])) {
                    $rides[$i]['detail_ride_id'] = $transportBillDetailRide['TransportBillDetailRides']['detail_ride_id'];
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['departure_destination_id'])) {
                    $rides[$i]['departure_destination_id'] = $transportBillDetailRide['TransportBillDetailRides']['departure_destination_id'];
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['arrival_destination_id'])) {
                    $rides[$i]['arrival_destination_id'] = $transportBillDetailRide['TransportBillDetailRides']['arrival_destination_id'];
                }
                $rides[$i]['supplier_final_id'] = $transportBillDetailRide['TransportBillDetailRides']['supplier_final_id'];
                $rides[$i]['nb_trucks'] = $transportBillDetailRide['TransportBillDetailRides']['nb_trucks'];
                $rides[$i]['unit_price'] = $transportBillDetailRide['TransportBillDetailRides']['unit_price'];
                if (isset($transportBillDetailRide['TransportBillDetailRides']['delivery_with_return'])) {
                    $rides[$i]['delivery_with_return'] = $transportBillDetailRide['TransportBillDetailRides']['delivery_with_return'];
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['programming_date'])) {
                    $rides[$i]['programming_date'] = $transportBillDetailRide['TransportBillDetailRides']['programming_date'];
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['charging_time'])) {
                    $rides[$i]['charging_time'] = $transportBillDetailRide['TransportBillDetailRides']['charging_time'];
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['unloading_date'])) {
                    $rides[$i]['unloading_date'] = $transportBillDetailRide['TransportBillDetailRides']['unloading_date'];
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['ride_category_id'])) {
                    $rides[$i]['ride_category_id'] = $transportBillDetailRide['TransportBillDetailRides']['ride_category_id'];
                }
                if (isset($transportBillDetailRide['TransportBillDetailRides']['type_price'])) {
                    $rides[$i]['type_price'] = $transportBillDetailRide['TransportBillDetailRides']['type_price'];
                }
                $rides[$i]['price_ht'] = $transportBillDetailRide['TransportBillDetailRides']['price_ht'];
                $rides[$i]['tva_id'] = $transportBillDetailRide['TransportBillDetailRides']['tva_id'];
                $rides[$i]['price_ttc'] = $transportBillDetailRide['TransportBillDetailRides']['price_ttc'];
                $rides[$i]['ristourne_%'] = $transportBillDetailRide['TransportBillDetailRides']['ristourne_%'];
                $rides[$i]['ristourne_val'] = $transportBillDetailRide['TransportBillDetailRides']['ristourne_val'];
                if (isset($transportBillDetailRide['TransportBillDetailRides']['sheet_ride_detail_ride_id'])) {
                    $rides[$i]['sheet_ride_detail_ride_id'] = $transportBillDetailRide['TransportBillDetailRides']['sheet_ride_detail_ride_id'];
                }
                if ($newType == TransportBillTypesEnum::invoice) {
                    $rides[$i]['approved'] = $newType;
                }
                if(isset($rideFactors)){
                    $rides[$i]['TransportBillDetailRideFactor']=
                        $rideFactors[ $transportBillDetailRide['TransportBillDetailRides']['id']];
                }
                $i++;
            }
        }
        $this->TransportBill->create();
        $this->createDateFromDate('TransportBill', 'date');
        $reference = $this->getNextTransportReference( $newType);
        if ($reference != '0') {
            $data['TransportBill']['reference'] = $reference;
        }
        $data['TransportBill']['date'] = $date;
        if ($originType == 0) {
            $data['TransportBill']['total_ht'] = $totalHt;
            $data['TransportBill']['total_ttc'] = $totalTtc;
            $data['TransportBill']['amount_remaining'] = $totalTtc;
            $data['TransportBill']['total_tva'] = $totalTva;
            $data['TransportBill']['status_payment'] = 1;
        } else {
            $data['TransportBill']['total_ht'] = $transportBill['total_ht'];
            $data['TransportBill']['total_ttc'] = $transportBill['total_ttc'];
            $data['TransportBill']['amount_remaining'] = $transportBill['amount_remaining'];
            $data['TransportBill']['total_tva'] = $transportBill['total_tva'];
            $data['TransportBill']['status_payment'] = $transportBill['status_payment'];
        }
        if ($supplier == null) {
            $data['TransportBill']['supplier_id'] = $transportBill['supplier_id'];
        } else {
            $data['TransportBill']['supplier_id'] = $supplier;
        }
        $data['TransportBill']['type'] = $newType;
        $data['TransportBill']['user_id'] = $this->Session->read('Auth.User.id');

        switch ($newType) {
            case TransportBillTypesEnum::quote_request :
                $data['TransportBill']['status'] = StatusEnum::quotation;
                break;
            case TransportBillTypesEnum::quote :
                $data['TransportBill']['status'] = StatusEnum::quotation;
                break;
            case TransportBillTypesEnum::order :
                $supplierId = $data['TransportBill']['supplier_id'];
                $customerOrderValidationMethod = $this->Supplier->getCustomerOrderValidationMethod($supplierId);

                if ($customerOrderValidationMethod == 1) {
                        $data['TransportBill']['status'] = TransportBillDetailRideStatusesEnum::not_validated;
                    } else {
                        $data['TransportBill']['status'] = TransportBillDetailRideStatusesEnum::not_transmitted;
                    }




                break;
            case TransportBillTypesEnum::pre_invoice :
                $data['TransportBill']['status'] = TransportBillTypesEnum::pre_invoice;
                break;
            case TransportBillTypesEnum::invoice :
                $data['TransportBill']['status'] = TransportBillTypesEnum::invoice;
                break;

            case TransportBillTypesEnum::credit_note :
                $data['TransportBill']['status'] = TransportBillTypesEnum::credit_note;
                break;
        }



        if ($this->TransportBill->save($data)) {
            $this->Parameter->setNextTransportReferenceNumber($newType);
            $transportBillId = $this->TransportBill->getInsertID();
            /*
             1:relance;
             2:transformation;
             3:duplication;
             4:Duplication et relance;
             */
            if (!empty($transportBillIdsArray)) {
                foreach ($transportBillIdsArray as $transportBillIdArray) {
                    $this->Transformation->create();
                    $data['Transformation']['origin_transport_bill_id'] = $transportBillIdArray;
                    $data['Transformation']['new_transport_bill_id'] = $transportBillId;
                    $data['Transformation']['origin_type'] = $originType;
                    $data['Transformation']['new_type'] = $newType;
                    $data['Transformation']['category'] = $r_t_d;
                    $data['Transformation']['date'] = Date('Y-m-d');
                    $this->Transformation->save($data);
                }
            }
            $userId = $this->Auth->user('id');
            $save = $this->add_Rides_transportBill($rides, $reference, $transportBillId, $userId, $newType);
            if ($newType == TransportBillTypesEnum::order) {
                $customerOrderValidationMethod = $this->Supplier->getCustomerOrderValidationMethod($supplierId);
                $this->TransportBillDetailedRidesManagement = $this->Components->load('TransportBillDetailedRidesManagement');
                $this->TransportBillDetailedRidesManagement->addTransportBillDetailedRidesFromTransformation($rides
                    ,$reference, $transportBillId, $userId, $newType, null, $customerOrderValidationMethod);
            }
            if($save == false ){
                $this->TransportBill->deleteAll(array('TransportBill.id' => $transportBillId),
                    false);

                $this->Flash->error(__('The transport bill could not be saved. Please, try again2.'));
                $this->redirect(array('action' => 'index', $newType));
            }

            switch ($newType) {
                case TransportBillTypesEnum::quote :
                    $this->Flash->success(__('La demande de devis a été transformé a un devis'));
                    break;
                case TransportBillTypesEnum::order :
                    $this->Flash->success(__('Le devis a été transformé a une commande client'));
                    break;
                case TransportBillTypesEnum::sheet_ride :
                    $this->Flash->success(__('La commande a été transformé a une fiche trajet'));
                    break;
                case TransportBillTypesEnum::pre_invoice :
                    $this->Flash->success(__('La fiche trajet a été transformé a une pre facture'));
                    break;
                case TransportBillTypesEnum::invoice :
                    $this->Flash->success(__('La préfacture a été transformé a une facture'));
                    break;
            }

            return $transportBillId;
        } else {
            $this->Flash->error(__('The transport bill could not be saved. Please, try again3.'));
            return null;
        }

    }

    /**
     * @param null $rideId
     * @param null $num
     * @param null $clientId
     * @param int $deliveryWithReturn
     * @param int $typePrice nuit / jour
     * @param null $rideCategoryId
     * @param int $typeRide
     * @param null $departureId
     * @param null $arrivalId
     * @param null $carTypeId
     * @param int $typePricing tarification par trajet / par distance
     * @param int $tonnageId
     * @return array|null
     */
    function getPriceRide(
        $rideId = null,
        $num = null,
        $clientId = null,
        $deliveryWithReturn = 1,
        $typePrice = 1,
        $rideCategoryId = null,
        $typeRide = 1,
        $departureId = null, $arrivalId = null, $carTypeId = null,
        $typePricing = 1, $tonnageId = 0
    )
    {
        $this->set('i', $num);
        $this->set('deliveryWithReturn', $deliveryWithReturn);
        $this->set('typePrice', $typePrice);
        $profileId = $this->Auth->user('profile_id');
        $serviceId = $this->Auth->user('service_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        $this->set('profileId', $profileId);
        $this->layout = 'ajax';
        $this->loadModel('Price');
        $price = array();
        if ($rideCategoryId == null) {
            $rideCategoryId = 0;
        }
        if ($clientId == 'null') {
            $clientId = null;
        }
        if ($typePricing == 1) {
            if ($typeRide == 1) {
                $price = $this->Price->getPriceByParams($rideId, $clientId, $rideCategoryId, null, $typePricing,0,null,$serviceId);
            } else {
                $conditions = array('Ride.departure_destination_id' => $departureId, 'Ride.arrival_destination_id' => $arrivalId, 'DetailRide.car_type_id' => $carTypeId);
                $detailRide = $this->DetailRide->getDetailRideByConditions($conditions, 'first');
                if (!empty($detailRide)) {
                    $rideId = $detailRide['DetailRide']['id'];
                    $price = $this->Price->getPriceByParams($rideId, $clientId, $rideCategoryId, null, $typePricing, 0, null, $serviceId);
                }
            }
        } else {
            if ($typeRide == 1) {
                $conditions = array('DetailRide.id' => $rideId);
                $detailRide = $this->DetailRide->getDetailRideByConditions($conditions, 'first');
                if (!empty($detailRide)) {
                    $distance = $detailRide['Ride']['distance'];
                    $price = $this->Price->getPriceByParams($rideId, $clientId, $rideCategoryId, null, $typePricing, $distance, $tonnageId, $serviceId);
                }

            } else {
                $conditions = array('Ride.departure_destination_id' => $departureId, 'Ride.arrival_destination_id' => $arrivalId, 'DetailRide.car_type_id' => $carTypeId);
                $detailRide = $this->DetailRide->getDetailRideByConditions($conditions, 'first');
                if (!empty($detailRide)) {
                    $distance = $detailRide['Ride']['distance'];

                    $price = $this->Price->getPriceByParams($rideId, $clientId, $rideCategoryId, null, $typePricing, $distance, $tonnageId, $serviceId);
                }
            }
        }
        if (!empty($price)) {
            $priceId = $price['Price']['id'];
            $promotion = $this->Promotion->getCurrentPromotionWithPriceId($priceId);
            if (!empty($promotion)) {

                $price[0] = $promotion['Promotion']['promotion_val'];
                $price[2] = $promotion['Promotion']['promotion_return'];

            } else {
                if ($typePrice == 2) {
                    $price[0] = $price['PriceRideCategory']['price_ht_night'];
                } else {
                    $price[0] = $price['PriceRideCategory']['price_ht'];
                }
                $price[1] = $price['PriceRideCategory']['id'];
                $price[2] = $price['PriceRideCategory']['price_return'];
                $price[3] = $price['Price']['id'];
            }
            //return $price;

            $this->set('price', $price);
        } else {
            $supplier = $this->Supplier->getSuppliersById($clientId);
            if (!empty($supplier)) {
                $categoryId = $supplier['Supplier']['supplier_category_id'];
                if ($typePricing == 1) {
                    if ($typeRide == 1) {
                        $price = $this->Price->getPriceByParams($rideId, null, $rideCategoryId, $categoryId, $typePricing, 0, null, $serviceId);
                    } else {
                        $conditions = array('Ride.departure_destination_id' => $departureId, 'Ride.arrival_destination_id' => $arrivalId, 'DetailRide.car_type_id' => $carTypeId);
                        $detailRide = $this->DetailRide->getDetailRideByConditions($conditions, 'first');

                        if (!empty($detailRide)) {
                            $rideId = $detailRide['DetailRide']['id'];
                            $price = $this->Price->getPriceByParams($rideId, null, $rideCategoryId, $categoryId, $typePricing, 0, null , $serviceId);
                        }
                    }
                } else {
                    if ($typeRide == 1) {
                        $conditions = array('DetailRide.id' => $rideId);
                        $detailRide = $this->DetailRide->getDetailRideByConditions($conditions, 'first');
                        if (!empty($detailRide)) {
                            $distance = $detailRide['Ride']['distance'];
                            $price = $this->Price->getPriceByParams($rideId, null, $rideCategoryId, $categoryId, $typePricing, $distance, $tonnageId , $serviceId);
                        }

                    } else {
                        $conditions = array('Ride.departure_destination_id' => $departureId, 'Ride.arrival_destination_id' => $arrivalId, 'DetailRide.car_type_id' => $carTypeId);
                        $detailRide = $this->DetailRide->getDetailRideByConditions($conditions, 'first');
                        if (!empty($detailRide)) {
                            $distance = $detailRide['Ride']['distance'];
                            $price = $this->Price->getPriceByParams($rideId, null, $rideCategoryId, $categoryId, $typePricing, $distance, $tonnageId, $serviceId);
                        }
                    }
                }


                if (!empty($price)) {
                    $priceId = $price['Price']['id'];
                    $promotion = $this->Promotion->getCurrentPromotionWithPriceId($priceId);

                    if (!empty($promotion)) {

                        $price[0] = $promotion['Promotion']['promotion_val'];
                        $price[2] = $promotion['Promotion']['promotion_return'];

                    } else {
                        if ($typePrice == 2) {
                            $price[0] = $price['PriceRideCategory']['price_ht_night'];
                        } else {
                            $price[0] = $price['PriceRideCategory']['price_ht'];
                        }
                        $price[1] = $price['PriceRideCategory']['id'];
                        $price[2] = $price['PriceRideCategory']['price_return'];
                        $price[3] = $price['Price']['id'];
                    }
                    $this->set('price', $price);
                } else {

                    if ($typePricing == 1) {
                        if ($typeRide == 1) {
                            $price = $this->Price->getPriceByParams($rideId, null, $rideCategoryId, null, $typePricing, 0, null, $serviceId);
                        } else {
                            $conditions = array('Ride.departure_destination_id' => $departureId, 'Ride.arrival_destination_id' => $arrivalId, 'DetailRide.car_type_id' => $carTypeId);
                            $detailRide = $this->DetailRide->getDetailRideByConditions($conditions, 'first');
                            if (!empty($detailRide)) {
                                $rideId = $detailRide['DetailRide']['id'];
                                $price = $this->Price->getPriceByParams($rideId, null, $rideCategoryId, null, $typePricing, 0, null , $serviceId);
                            }
                        }
                    } else {
                        if ($typeRide == 1) {
                            $conditions = array('DetailRide.id' => $rideId);
                            $detailRide = $this->DetailRide->getDetailRideByConditions($conditions, 'first');
                            if (!empty($detailRide)) {
                                $distance = $detailRide['Ride']['distance'];
                                $price = $this->Price->getPriceByParams($rideId, null, $rideCategoryId, null, $typePricing, $distance, $tonnageId, $serviceId);
                            }
                        } else {
                            $conditions = array('Ride.departure_destination_id' => $departureId, 'Ride.arrival_destination_id' => $arrivalId, 'DetailRide.car_type_id' => $carTypeId);
                            $detailRide = $this->DetailRide->getDetailRideByConditions($conditions, 'first');
                            if (!empty($detailRide)) {
                                $distance = $detailRide['Ride']['distance'];
                                $price = $this->Price->getPriceByParams($rideId, null, $rideCategoryId, null, $typePricing, $distance, $tonnageId, $serviceId);
                            }
                        }
                    }
                    if (!empty($price)) {
                        $priceId = $price['Price']['id'];
                        $promotion = $this->Promotion->getCurrentPromotionWithPriceId($priceId);
                        if (!empty($promotion)) {

                            $price[0] = $promotion['Promotion']['promotion_val'];
                            $price[2] = $promotion['Promotion']['promotion_return'];

                        } else {
                            if ($typePrice == 2) {
                                $price[0] = $price['PriceRideCategory']['price_ht_night'];
                            } else {
                                $price[0] = $price['PriceRideCategory']['price_ht'];
                            }
                            $price[1] = $price['PriceRideCategory']['id'];
                            $price[2] = $price['PriceRideCategory']['price_return'];
                            $price[3] = $price['Price']['id'];
                        }
                    }
                }
                $this->set('price', $price);
            }
        }

        return $price;
    }

    /**
     * @param null|int $type
     * @param null|int $id
     * @param null|int $relance
     * @throws Exception
     *
     * @return void
     */
    public function sendMail($type = null, $id = null, $relance = null)
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $senderMailIsNotSpecified = false;
        $this->setTimeActif();
        $supplierContacts = $this->SupplierContact->find('all',
            array(
                'conditions' => array(
                    'TransportBill.id' => $id,
                    'SupplierContact.email1 != '=>''
                ),
                'recursive' => -1,
                'fields' => array(
                    'SupplierContact.email1',
                    'TransportBill.reference',
                ),
                'joins' => array(
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('SupplierContact.supplier_id = Supplier.id')
                    ),
                    array(
                        'table' => 'transport_bills',
                        'type' => 'left',
                        'alias' => 'TransportBill',
                        'conditions' => array('TransportBill.supplier_id = Supplier.id')
                    ),
                )
            ));
        if (!empty($supplierContacts)) {
            foreach ($supplierContacts as $supplierContact) {

                if(!empty($supplierContact['SupplierContact']['email'])){}

                switch ($type) {
                    case TransportBillTypesEnum::quote :
                        $name = 'devis' . '_' . $supplierContact['TransportBill']['reference'] . '.pdf';
                        break;
                    case TransportBillTypesEnum::order :
                        $name = 'commande_client' . '_' . $supplierContact['TransportBill']['reference'] . '.pdf';
                        break;
                    case TransportBillTypesEnum::pre_invoice :
                        $name = 'prefacture' . '_' . $supplierContact['TransportBill']['reference'] . '.pdf';
                        break;
                    case TransportBillTypesEnum::invoice :
                        $name = 'facture' . '_' . $supplierContact['TransportBill']['reference'] . '.pdf';
                        break;
                    case TransportBillTypesEnum::credit_note :
                        $name = 'avoir' . '_' . $supplierContact['TransportBill']['reference'] . '.pdf';
                        break;
                    default :
                        $name = "";

                }

                $name = str_replace('/', '-', $name);

                if ($relance == '1') {
                    $this->Transformation->create();
                    $data['Transformation']['origin_transport_bill_id'] = $id;
                    $data['Transformation']['new_transport_bill_id'] = $id;
                    $data['Transformation']['origin_type'] = $type;
                    $data['Transformation']['new_type'] = $type;
                    $data['Transformation']['category'] = 1;
                    $data['Transformation']['date'] = Date("Y-m-d");
                    $this->Transformation->save($data);
                } else {
                    $this->piecePdf($type, $id);
                }

                $Email = new CakeEmail('default');
                $emailSender = $this->Auth->user('email');
                $userName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
                $Email->sender($emailSender, $userName);
                if (empty($emailSender)){
                    $company = $this->Company->find('first');
                    $emailSender = $company['Company']['email'];
                    if (empty($emailSender)){
                        $senderMailIsNotSpecified = true;
                    }
                }
                $Email->addTo($supplierContact['SupplierContact']['email1']);
                switch ($type) {
                    case TransportBillTypesEnum::quote :
                        $subject = __('Quotation');
                        break;
                    case TransportBillTypesEnum::order :
                        $subject = __('Customer order');
                        break;
                    case TransportBillTypesEnum::pre_invoice :
                        $subject = __('Preinvoice');
                        break;
                    case TransportBillTypesEnum::invoice :
                        $subject = __('Invoice');
                        break;
                    default :
                        $subject = "";
                }
                $msg = __("Please find attached copy of your ") . $subject . __(' ') . __('number ') . $supplierContact['TransportBill']['reference'];
                $Email->template('welcome', 'default')
                    ->emailFormat('html')
                    ->subject($subject)
                    ->attachments(array('./document_transport/' . $name));
                if (!$senderMailIsNotSpecified){
                    $Email->from($emailSender);
                    if ($Email->send($msg)) {
                        $this->Flash->success(__('Your Email has been sent.'));
                        if(isset($this->params['pass']['3']) && $this->params['pass']['3']=='TransportBillDetailRides'){
                            $this->redirect(array('controller'=>'TransportBillDetailRides','action' => 'index'));
                        }else {
                            $this->redirect(array('action' => 'index', $type));
                        }
                    } else {
                        $this->Flash->error(__('Your Email has not been sent. Try again.'));
                        if(isset($this->params['pass']['3']) && $this->params['pass']['3']=='TransportBillDetailRides'){
                            $this->redirect(array('controller'=>'TransportBillDetailRides','action' => 'index'));
                        }else {
                            $this->redirect(array('action' => 'index', $type));
                        }
                    }
                }else{
                    $this->Flash->error(__("Your email has not been sent, please fill the user email or company email"));
                    if(isset($this->params['pass']['3']) && $this->params['pass']['3']=='TransportBillDetailRides'){
                        $this->redirect(array('controller'=>'TransportBillDetailRides','action' => 'index'));
                    }else {
                        $this->redirect(array('action' => 'index', $type));
                    }
                }

            }
        } else {
            $this->Flash->error(__('The email customer is empty'));

            if(isset($this->params['pass']['3']) && $this->params['pass']['3']=='TransportBillDetailRides'){
                $this->redirect(array('controller'=>'TransportBillDetailRides','action' => 'index'));
            }else {
                $this->redirect(array('action' => 'index', $type));
            }

        }

    }


    function piecePdf($type = null, $id = null)
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();

        $facture = $this->TransportBill->getTransportBillById($id);

        if($type == TransportBillTypesEnum::credit_note){
            $invoice = $this->TransportBill->getTransportBillById($facture['TransportBill']['invoice_id']);
            $this->set('invoice',$invoice);
        }

        $rides = $this->TransportBillDetailRides->getTransportBillDetailRidesByTransportBillId($id);
        $rideIds = array();
        $rideFactors = array();
        $missionFactors= array();
        foreach ($rides as $ride){
            $rideIds[] = $ride['TransportBillDetailRides']['id'];
            $transportBillDetailRideFactors = $this->TransportBillDetailRideFactor->find('all',
                array('conditions'=>array('TransportBillDetailRideFactor.transport_bill_detail_ride_id'=>$ride['TransportBillDetailRides']['id']),
                    'recursive'=>-1,
                    'fields'=>array(
                        'TransportBillDetailRideFactor.factor_value',
                        'TransportBillDetailRideFactor.factor_id',
                    ),

                )
            );
            foreach ($transportBillDetailRideFactors as $transportBillDetailRideFactor){
                $missionFactors[$transportBillDetailRideFactor['TransportBillDetailRideFactor']['factor_id']]=
                    $transportBillDetailRideFactor['TransportBillDetailRideFactor']['factor_value'];
            }
            $rideFactors[$ride['TransportBillDetailRides']['id']] = $missionFactors;
            $missionFactors= array();
        }
        $factors = $this->TransportBillDetailRideFactor->find('all',
            array('conditions'=>array('TransportBillDetailRideFactor.transport_bill_detail_ride_id'=>$rideIds,
            ),
                'recursive'=>-1,
                'order'=>array('TransportBillDetailRideFactor.transport_bill_detail_ride_id ASC'),
                'fields'=>array(
                    'DISTINCT Factor.id',
                    'Factor.name',
                ),
                'joins'=>array(
                    array(
                        'table' => 'factors',
                        'type' => 'left',
                        'alias' => 'Factor',
                        'conditions' => array('TransportBillDetailRideFactor.factor_id = Factor.id')
                    ),
                )
            )
        );
        $company = $this->Company->find('first');
        $wilayaId = $company['Company']['wilaya'];
        if(!empty($wilayaId)){
            $destination = $this->Destination->find('first', array('conditions' => array('Destination.id' => $wilayaId)));
            $wilayaName = $destination['Destination']['name'];
        }else {
            $wilayaName ='';
        }
        $commercialDocumentModel = $this->Parameter->getCodesParameterVal('commercial_document_model');
        $entete_pdf = $this->Parameter->getCodesParameterVal('entete_pdf');
        $penalties =array();
        if($facture['TransportBill']['with_penalty']==1
            && $type== TransportBillTypesEnum::invoice){
            $penalties = $this->TransportBillPenalty->getPenaltiesByTransportBillId($id);
            if(!empty($penalties)){
                $penaltyAmounts = $this->TransportBillPenalty->find('all', array(
                    'recursive' => -1,
                    'conditions' => array('TransportBillPenalty.transport_bill_id' => $id),
                    'fields' => array(
                        'sum(TransportBillPenalty.penalty_amount) as total_penalty_amount'
                    ),
                ));
                $totalPenaltyAmount = $penaltyAmounts[0][0]['total_penalty_amount'];
            }
        }








        switch ($commercialDocumentModel){
            case 1 :
                ob_start();
                ?>

                <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
                    <style type="text/css">
                        @page {
                            margin: 90px 0px 150px 0px;
                        }

                        #header { position: fixed; left: 0; top: -90px; right: 0; height: 165px; border-bottom: 1px solid #000;}
                        #header table{width:100%;}
                        #header td.logo{vertical-align: top;padding-left:25px;padding-top:20px; width:270px;}
                        #header td.company{ width: 500px;vertical-align: top; font-weight: bold; font-size: 16px;padding-right:50px; padding-top:20px;}
                        #header td.company span{padding-left: 25px ;display: block; font-size: 22px; padding-bottom: 2px;padding-top: 2px;}

                        .copyright {
                            font-size: 10px;
                            text-align: center;

                        }

                        .uv {
                            font-size: 10px;
                        }

                        .signature {
                            font-size: 13px;
                            margin-left: 600px;
                            margin-top: 50px;
                            font-weight: bold;
                            width: 1000px;
                            height: 100px;
                            text-decoration: underline;

                        }

                        .info_company {
                            width: 600px;
                            font-size: 12px;
                            line-height: 18px;
                        }

                        .info_fiscal {
                            width: 200px;
                            font-size: 12px;
                            padding-top: 60px;
                            line-height: 18px;
                            padding-right: 35px;
                        }

                        .adr {
                            font-weight: normal;
                            font-size: 12px;
                        }

                        .date {
                            padding-top: 15px;
                            text-align: right;
                            padding-right: 25px;
                        }

                        .box-body {
                            padding: 0px 25px;
                            position: relative;
                        }

                        .bloc-center {
                            margin-top: 65px;
                            width: 100%;
                        }

                        .facture {
                            font-size: 18px;
                            font-weight: bold;
                        }

                        .date {
                            font-size: 16px;
                            font-weight: bold;
                            text-align: right;
                        }

                        .modepayment, .droit {
                            padding-top: 30px;
                        }

                        .modepayment {
                            font-size: 12px;
                            width: 350px;
                        }

                        .main-table > thead > tr > th,
                        .main-table > tbody > tr > th,
                        .main-table > tfoot > tr > th,
                        .main-table > thead > tr > td,
                        .main-table > tfoot > tr > td {
                        / / border: 1 px solid #000;
                        }

                        .main-table td {
                            vertical-align: top;
                            border-left: 0;
                            border-right: 1px solid #C0C0C0;
                            border-collapse: collapse;
                            border-top: 0;
                            border-bottom: 0;
                        }

                        .main-table th {
                            border-right: 1px solid black;
                            border-bottom: 1px solid black;
                            padding-left: 5px;
                            text-align: left;
                            border-collapse: collapse;
                            font-size: 11px
                        }

                        .main-table {

                            width: 100%;
                            border-collapse: collapse;
                            margin: 30px 0;
                            border: 1px solid black !important;
                        }

                        .main-table td {
                            text-align: left;
                            padding: 3px 5px;;
                            font-size: 11px
                        }

                        .footer-table td {
                            vertical-align: top;
                            border-left: 0;
                            border-right: 1px solid #FFF;
                            border-collapse: collapse;
                            border-top: 0;
                            border-bottom: 0;
                        }
                        .footer-table th {
                            border-right: 1px solid white;
                            border-bottom: 1px solid white;
                            padding-left: 5px;
                            text-align: left;
                            border-collapse: collapse;
                            font-size: 11px
                        }



                        .footer-table {

                            width: 100%;
                            border-collapse: collapse;
                            margin: 30px 0;
                            border: 1px solid white !important;
                        }

                        .total {
                            width: 200px;
                            height: 50px;
                            float: right;
                            line-height: 10px;

                        }

                        .total-div span {
                            padding: 5px 5px;
                            line-height: 10px;
                            font-size: 10px;
                        }



                        .footer-table td {
                            text-align: left;
                            padding: 3px 5px;;
                            font-size: 10px
                        }

                        .nombre-lettre {
                            width: 400px;
                            height: 60px;
                            float: left;
                            margin-left: 50px;
                            font-size: 12px;
                            font-weight: bold;
                            line-height: 20px;
                        }

                        #footer {
                            position: fixed;
                            left: 0;
                            bottom: -100px;
                            right: 0;
                            height: 350px;
                        }

                        .left {
                            width: 120px;
                            height: 8px;
                            text-align: left;
                            display: inline-block;
                            padding-left: 5px;
                            font-size: 10px;
                            line-height: 10px;
                        }

                        .right {
                            width: 70px;
                            height: 8px;
                            text-align: right;
                            display: inline-block;
                            font-size: 10px;
                            line-height: 10px;
                        }

                        .client {
                            font-size: 16px;
                            font-weight: bold;
                            margin-bottom: 10px;
                            display: inline;
                        / / padding-top: 10 px;
                        }

                        .info_client {
                            font-size: 11px;
                        }

                        .address_client {
                            font-size: 11px;
                            display: block;
                            margin-bottom: 15px;
                        }

                        .line {
                            border-top: 2px solid #000;
                        }
                    </style>


                </head>
                <body class='body'>
                <div id="header">
                    <?php if($entete_pdf=='1') {?>
                        <table>
                            <tr >

                                <td class="company">
                                    <span><?= Configure::read("nameCompany") ?></span>
                                    <span style="font-size: 12px !important; font-weight: normal">
                        <strong><?= $company['Company']['category_company'] ?></strong>
                    </span>
                                    <span style="font-size: 12px !important; font-weight: normal">
                        <strong><?= $company['Company']['adress'] ?></strong>
                    </span>
                                    <span style="font-size: 12px !important; font-weight: normal">
                        <strong>Tel. :<?= $company['Company']['phone'] ?></strong>
                    </span>
                                    <span style="font-size: 12px !important; font-weight: normal">
                            <strong>RC :<?= $company['Company']['rc'] ?> - AI :<?= $company['Company']['ai'] ?> - IF :<?= $company['Company']['nif'] ?></strong>
                    </span>


                                    <span style="font-size: 12px !important; font-weight: normal">
                            <strong>Compte :<?= $company['Company']['cb'] ?></strong>
                        </span>
                                    <span style="font-size: 12px !important; font-weight: normal">
                            <strong>Email :<?= $company['Company']['email'] ?></strong>
                        </span>
                                </td>
                                <td class="logo">
                                    <?php

                                    if(!empty($company['Company']['logo']) && file_exists( WWW_ROOT .'/logo/'. $company['Company']['logo'])) {?>
                                        <img src="<?= WWW_ROOT ?>/logo/<?= $company['Company']['logo'] ?>" width="180px" height="120px">
                                    <?php } else { ?>
                                        <img  width="180px" height="120px">
                                    <?php } ?>


                                </td>
                                <td  class="date" ></td>
                            </tr>
                        </table>
                    <?php }?>

                </div>
                <div class="box-body">
                    <table class="bloc-center">
                        <tr>
                            <td>
                                <?php switch ($type) {
                                    case TransportBillTypesEnum::quote :
                                        ?>
                                        <span class="facture">Devis <?= $facture['TransportBill']['reference']; ?></span>
                                        <?php break;
                                    case TransportBillTypesEnum::order :
                                        ?>
                                        <span class="facture">Bon de commande <?= $facture['TransportBill']['reference'] ?></span>
                                        <?php break;
                                    case TransportBillTypesEnum::pre_invoice :
                                        ?>
                                        <span class="facture">Pr&eacute;facture <?= $facture['TransportBill']['reference'] ?></span>
                                        <?php break;
                                    case TransportBillTypesEnum::invoice :
                                        ?>
                                        <span class="facture">Facture <?= $facture['TransportBill']['reference'] ?></span>
                                        <?php break;
                                }
                                ?>
                            </td>
                            <td class="date">
                                <?= $wilayaName;?>
                                <span>Le : <?php

                                    $timestamp = strtotime($facture['TransportBill']['date']);
                                    $newDate = date("d/m/Y", $timestamp);
                                    echo $newDate;
                                    ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="modepayment">
                                <?php if ($type == TransportBillTypesEnum::invoice) {
                                    switch ($facture['TransportBill']['payment_method']) {
                                        case 1 :
                                            $paymentMethod = __('A terme');
                                            break;
                                        case 2 :
                                            $paymentMethod = __('Chèque');
                                            break;
                                        case 3 :
                                            $paymentMethod = __('Chèque-banque');
                                            break;
                                        case 4 :
                                            $paymentMethod = __('Virement');
                                            break;
                                        case 5 :
                                            $paymentMethod = __('Avoir');
                                            break;
                                        case 6 :
                                            $paymentMethod = __('Espèce');
                                            break;
                                        case 7 :
                                            $paymentMethod = __('Traite');
                                            break;
                                        case 8 :
                                            $paymentMethod = __('Fictif');
                                            break;
                                        default :

                                            $paymentMethod = __('');

                                    }
                                    ?>
                                    <span>Mode de paiement : <?php echo $paymentMethod ?> </span>
                                <?php } ?>
                            </td>

                            <td class="droit">

                                <span class="client"><strong>Doit :  </strong><?= $facture['Supplier']['name'] ?></span><br>
                                <span class="address_client"><?= $facture['Supplier']['adress'] ?></span><br>
                                <span class='info_client'><?php if(!empty($facture['Supplier']['if'])) {?>IF :<?= $facture['Supplier']['if'] . ' ' ?> <?php } ?>
                                    <?php if(!empty($facture['Supplier']['ai'])) {?>     AI :<?= $facture['Supplier']['ai'] . ' ' ?><?php } ?> <?php if(!empty($facture['Supplier']['rc'])) {?> RC :<?= $facture['Supplier']['rc'] . ' ' ?><?php } ?></span>

                            </td>">
                            <thead>
                            <tr>
                                <th><?php echo 'N&deg;'; ?></th>
                                <th><?php echo __('Code'); ?></th>
                                <th><?php echo __('Designation'); ?></th>
                                <?php if ($type == TransportBillTypesEnum::pre_invoice) { ?>
                                    <th><?php echo __('Departure date'); ?></th>
                                    <th><?php echo __('Arrival date'); ?></th>
                                <?php } ?>
                                <?php if ( !empty($factors)){ ?>
                                    <?php foreach($factors as $factor){ ?>
                                        <th><?php echo $factor['Factor']['name'] ; ?></th>
                                    <?php } ?>
                                <?php } ?>
                                <?php if ($type == TransportBillTypesEnum::invoice ||
                                    $type == TransportBillTypesEnum::quote ||
                                    $type == TransportBillTypesEnum::order
                                ) {
                                    ?>
                                    <th><?php echo __('Unit price'); ?></th>
                                <?php } ?>
                                <th><?php echo __('Quantity'); ?></th>

                                <?php if ($type == TransportBillTypesEnum::invoice ||
                                    $type == TransportBillTypesEnum::quote ||
                                    $type == TransportBillTypesEnum::order
                                ) {
                                    ?>
                                    <th><?php echo __('Price HT'); ?></th>
                                    <th><?php echo __('TVA'); ?></th>
                                <?php } ?>


                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1;
                            $uv = 0;
                            foreach ($rides as $ride) { ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $ride['Product']['code'] ?></td>
                                    <?php if ($ride['Product']['id'] == 1) { ?>
                                        <td><?= $ride['Product']['name'] . '(' . $ride['TransportBillDetailRides']['designation'] . ')' ?></td>

                                    <?php } else { ?>
                                        <td>
                                            <?= $ride['TransportBillDetailRides']['designation'] ?>

                                        </td>
                                    <?php } ?>

                                    <?php if ($type == TransportBillTypesEnum::pre_invoice) { ?>
                                        <td><?php
                                            $timestamp = strtotime($ride['SheetRideDetailRides']['real_start_date']);
                                            $newDate = date("d/m/Y", $timestamp);
                                            echo $newDate;
                                            ?>
                                            &nbsp;
                                        </td>
                                        <td><?php

                                            $timestamp = strtotime($ride['SheetRideDetailRides']['real_end_date']);
                                            $newDate = date("d/m/Y", $timestamp);
                                            echo $newDate;
                                             ?>
                                            &nbsp;
                                        </td>
                                    <?php } ?>
                                    <?php

                                    if(!empty($factors)){

                                        $factorValues = $rideFactors[$ride['TransportBillDetailRides']['id']] ;

                                        foreach ($factors as $factor){
                                            if(isset($factorValues[$factor['Factor']['id']])){ ?>
                                                <td><?php echo h($factorValues[$factor['Factor']['id']]) ?></td>

                                            <?php }else {?>
                                                <td></td>
                                            <?php  }



                                        }





                                    } ?>
                                    <?php if ($type == TransportBillTypesEnum::invoice ||
                                        $type == TransportBillTypesEnum::quote ||
                                        $type == TransportBillTypesEnum::order
                                    ) {
                                        ?>
                                        <td><?= number_format($ride['TransportBillDetailRides']['unit_price'], 2, ",", "."); ?></td>
                                    <?php } ?>
                                    <?php $uv = $uv + $ride['TransportBillDetailRides']['nb_trucks']; ?>
                                    <td><?= $ride['TransportBillDetailRides']['nb_trucks']; ?></td>
                                    <?php if ($type == TransportBillTypesEnum::invoice ||
                                        $type == TransportBillTypesEnum::quote ||
                                        $type == TransportBillTypesEnum::order
                                    ) {
                                        ?>
                                        <td><?= number_format($ride['TransportBillDetailRides']['price_ht'], 2, ",", "."); ?></td>
                                        <td><?= $ride['Tva']['name']; ?></td>

                                    <?php } ?>
                                </tr>
                                <?php $i++;
                            }
                            ?>


                            </tbody>
                    </table>


                    <p class="uv">NB. UV : <?php echo number_format($uv, 2, ",", "."); ?></p>
                </div>
                <div id="footer">

                    <table class="footer-table">
                        <tr>

                            <td class='nombre-lettre'>
                                <?php
                                $fmt = new NumberFormatter('fr', NumberFormatter::SPELLOUT);
                                switch ($type) {
                                    case  TransportBillTypesEnum::quote:
                                        $text = 'Arrêtée le présent devis à la somme de : ';
                                        break;
                                    case  TransportBillTypesEnum::order:
                                        $text = 'Arrêtée la présente commande à la somme de : ';
                                        break;
                                    case
                                    TransportBillTypesEnum::pre_invoice:
                                        $text = 'Arrêtée la présente préfacture à la somme de : ';
                                        break;

                                    case
                                    TransportBillTypesEnum::invoice:
                                        $text = 'Arrêtée la présente facture à la somme de : ';
                                        break;
                                } ?>
                                <p style='padding-left:20px'> <?php echo $text . strtoupper($fmt->format($facture['TransportBill']['total_ttc']) . ' ' . $this->Session->read("currencyName")); ?>
                                </p>
                            </td>
                            <td style='width:20px;'>
                            </td>
                            <?php if($facture['TransportBill']['ristourne_val']>0 ) { ?>
                                <td class="total">
                                    <?php $countPenalties = count($penalties) ;
                                    if(!empty($penalties)){
                                        $height = 100+ ($countPenalties * 17)+20;
                                    }else {
                                        $height = 100;
                                    }
                                    $paddingTop =45-( $countPenalties *25 );
                                    ?>
                                    <div class='total-div'
                                         style=' border:2px solid #000;border-radius: 10px;padding:5px 5px;font-size:10px; height:<?php echo $height ?>px;'>
                                        <?php $totalHt = $facture['TransportBill']['total_ht'] + $facture['TransportBill']['ristourne_val'] ;
                                        $netHt = $facture['TransportBill']['total_ht']+ $facture['TransportBill']['ristourne_val'];

                                        if(!empty($penalties)) {
                                            $totalHt = $facture['TransportBill']['total_ht'] + $totalPenaltyAmount + $facture['TransportBill']['ristourne_val'];

                                        }
                                        ?>



                                        <span class="left"><strong><?php echo __('Total HT '); ?></strong></span>
                                        <span class="right"> <?= number_format($totalHt, 2, ",", "."); ?></span><br>
                                        <span class="left"><strong><?php echo __('TVA '); ?></strong></span>
                                        <?php if($facture['TransportBill']['total_tva']==0 ) { ?>
                                            <span class="right"> <?php echo 'EXO'; ?></span><br>
                                        <?php } else { ?>
                                            <span class="right"> <?= number_format($facture['TransportBill']['total_tva'], 2, ",", "."); ?></span><br>
                                        <?php }?>

                                        <?php
                                        if(!empty($penalties)) {
                                            foreach ($penalties as $penalty) {?>
                                                <span class="left"><strong><?php echo $penalty['TransportBillPenalty']['penalty_value']; ?></strong></span>
                                                <span class="right"> <?= number_format($penalty['TransportBillPenalty']['penalty_amount'], 2, ",", "."); ?></span><br>

                                            <?php }  ?>
                                            <span class="left"><strong><?php echo __('Total Général  '); ?></strong></span>
                                            <span class="right"> <?= number_format($netHt, 2, ",", "."); ?></span><br>
                                        <?php } ?>

                                        <span class="left"><strong><?php echo __('Garantie ').' '.$facture['TransportBill']['ristourne_percentage'] .__('%');  ?></strong></span>
                                        <span class="right"> <?= number_format($facture['TransportBill']['ristourne_val'], 2, ",", "."); ?></span><br>
                                        <span class="left"><strong><?php echo __('Net HT '); ?></strong></span>
                                        <span class="right"> <?= number_format($facture['TransportBill']['total_ht'], 2, ",", "."); ?></span><br>

                                        <?php if($facture['TransportBill']['stamp']>0 ) { ?>
                                            <span class="left"><strong><?php echo __('TIMBRE '); ?></strong></span>
                                            <span class="right"> <?= number_format($facture['TransportBill']['stamp'], 2, ",", "."); ?></span><br>
                                        <?php } ?>
                                        <span class="left "><strong><?php echo __('NET A PAYER '); ?></strong></span>
                                        <span class="right "> <?= number_format($facture['TransportBill']['total_ttc'], 2, ",", "."); ?></span><br>
                                    </div>
                                </td>
                            <?php } else { ?>
                                <td class="total">
                                    <?php $countPenalties = count($penalties) ;
                                    if(!empty($penalties)){
                                        $height = 72+ ($countPenalties * 17)+20;
                                    }else {
                                        $height = 72;
                                    }
                                    $paddingTop =75-( $countPenalties *30 );
                                    ?>
                                    <div class='total-div'
                                         style=' border:2px solid #000;border-radius: 10px;padding:5px 5px;font-size:10px; height:<?php echo $height?> px;'>
                                        <?php

                                        if(!empty($penalties)) {
                                            $total = $facture['TransportBill']['total_ht'] + $totalPenaltyAmount;
                                        }else {
                                            $total =  $facture['TransportBill']['total_ht'];
                                        }
                                        ?>
                                        <span class="left"><strong><?php echo __('Total HT '); ?></strong></span>
                                        <span class="right"> <?= number_format($total, 2, ",", "."); ?></span><br>
                                        <span class="left"><strong><?php echo __('TVA '); ?></strong></span>
                                        <?php if($facture['TransportBill']['total_tva']==0 ) { ?>
                                            <span class="right"> <?php echo 'EXO'; ?></span><br>
                                        <?php } else { ?>
                                            <span class="right"> <?= number_format($facture['TransportBill']['total_tva'], 2, ",", "."); ?></span><br>
                                        <?php }?>

                                        <?php
                                        if(!empty($penalties)) {
                                            foreach ($penalties as $penalty) {?>
                                                <span class="left"><strong><?php echo $penalty['TransportBillPenalty']['penalty_value']; ?></strong></span>
                                                <span class="right"> <?= number_format($penalty['TransportBillPenalty']['penalty_amount'], 2, ",", "."); ?></span><br>

                                            <?php }  ?>
                                            <span class="left"><strong><?php echo __('Total Géneral  '); ?></strong></span>
                                            <span class="right"> <?= number_format($facture['TransportBill']['total_ht'], 2, ",", "."); ?></span><br>
                                        <?php } ?>
                                        <?php if($facture['TransportBill']['stamp']>0 ) { ?>
                                            <span class="left"><strong><?php echo __('TIMBRE '); ?></strong></span>
                                            <span class="right"> <?= number_format($facture['TransportBill']['stamp'], 2, ",", "."); ?></span><br>
                                        <?php }  ?>
                                        <span class="left "><strong><?php echo __('NET A PAYER '); ?></strong></span>
                                        <span class="right "> <?= number_format($facture['TransportBill']['total_ttc'], 2, ",", "."); ?></span><br>


                                    </div>
                                </td>
                            <?php } ?>
                            <td style='width:20px;'>
                            </td>

                        </tr>
                    </table>

                    <table>
                        <tr>
                            <td>
                <span class="signature">Service Commercial<span>
                            </td>
                        </tr>
                    </table>
                    <div class='copyright' style='padding-top:<?php echo $paddingTop ?>px;'>
                        <p style='border-top :1px solid #000; margin-top: 115px;  padding-top: 5px;'>Logiciel : UtranX |
                            www.intellixweb.com</p>
                    </div>
                </div>

                </body>


                </html>

                <?php
                $html = ob_get_clean();
                break;
            case 2 :
                ob_start();
                ?>
                <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
                    <style type="text/css">
                        @page {
                            margin: 10px 25px 75px 25px;
                        }

                    </style>
                    <link type="text/css" href="<?= WWW_ROOT ?>/css/pdf/invoice_style.css" rel="stylesheet" />
                    <link type="text/css" href="<?= WWW_ROOT ?>/css/font-awesome.min.css" rel="stylesheet" />
                </head>
                <body>
                <?php
                /** @var array $company */
                if(!empty($company['logo'])){
                    $infoCompanyWidth = '50%';
                }else{
                    $infoCompanyWidth = '80%';
                }
                ?>
                <div id="header">
                    <table>
                        <tr>
                            <td class='info_company' valign="top" style="width: <?= $infoCompanyWidth ?>;">
                                <span class="company"><?= Configure::read("nameCompany")  ?></span>
                                <?php
                                $nameCompany =$company['Company']['name'];
                                if(!empty($nameCompany)){ ?>
                                    <br>
                                    <span id="slogan"><?= Configure::read("nameCompany")  ?></span>
                                    <?php
                                }
                                if (isset($company['Company']['address']) && !empty($company['Company']['adress'])) {
                                    echo "<br><br><span class='adr'> {$company['Company']['adress']}</span>";
                                }
                                if (isset($company['Company']['phone']) && !empty($company['Company']['phone'])) {
                                    echo "<br><span><strong>Tél. : </strong>{$company['Company']['phone']}</span>";
                                }
                                if (isset($company['Company']['fax']) && !empty($company['Company']['fax'])) {
                                    echo " / <span><strong>Fax  : </strong>{$company['Company']['fax']}</span>";
                                }
                                if (isset($company['Company']['mobile']) && !empty($company['Company']['mobile'])) {
                                    echo "<br><span><strong>Mobile : </strong>{$company['Company']['mobile']}</span>";
                                }
                                if (isset($company['Company']['rib']) && !empty($company['Company']['rib'])) {
                                    echo "<br><span><strong>RIB : </strong>{$company['Company']['rib']}</span>";
                                }elseif (isset($company['Company']['cb']) && !empty($company['Company']['cb'])) {
                                    echo "<br><span><strong>CB : </strong>{$company['Company']['cb']}</span>";
                                }
                                ?>

                            </td>
                            <td class="info_fiscal" valign="top">
                                <div>
                                    <?php
                                    if (isset($company['rc']) && !empty($company['rc'])) {
                                        echo "<span><strong>RC : </strong>{$company['rc']}</span><br>";
                                    }
                                    if (isset($company['ai']) && !empty($company['ai'])) {
                                        echo "<span><strong>AI : </strong>{$company['ai']}</span><br>";
                                    }
                                    if (isset($company['nif']) && !empty($company['nif'])) {
                                        echo "<span><strong>NIF : </strong>{$company['nif']}</span><br>";
                                    }
                                    ?>
                                </div>
                            </td>
                            <?php
                            if(!empty($company['logo']) &&
                                file_exists(WWW_ROOT . "/logo/{$company['logo']}")){ ?>
                                <td valign="top" align="right">


                                <img class="logo-print" alt="Logo" src="<?= WWW_ROOT ?>/logo/<?=rawurlencode($company['logo'])?>">

                                </td>;
                           <?php }

                            ?>
                        </tr>
                    </table>
                </div>
                <?php



                switch ($type) {
                    case TransportBillTypesEnum::quote :

                        $printName ='Devis' ;
                        break;
                    case TransportBillTypesEnum::order :
                        $printName =' Bon de commande';
                        break;
                    case TransportBillTypesEnum::pre_invoice :
                        $printName ='Pr&eacute;facture';
                        break;
                    case TransportBillTypesEnum::invoice :

                        $printName ='Facture';
                        break;
                }

                switch ($facture['TransportBill']['payment_method']) {
                    case 1 :
                        $paymentMethod = __('A terme');
                        break;
                    case 2 :
                        $paymentMethod = __('Chèque');
                        break;
                    case 3 :
                        $paymentMethod = __('Chèque-banque');
                        break;
                    case 4 :
                        $paymentMethod = __('Virement');
                        break;
                    case 5 :
                        $paymentMethod = __('Avoir');
                        break;
                    case 6 :
                        $paymentMethod = __('Espèce');
                        break;
                    case 7 :
                        $paymentMethod = __('Traite');
                        break;
                    case 8 :
                        $paymentMethod = __('Fictif');
                        break;
                    default :

                        $paymentMethod = __('');

                }


                ?>

                <div class="box-body">

                    <table class="bloc-center">

                        <tr>
                            <td class="document_reference" style="vertical-align:top;">
                                <div class="facture">
                                    <?= $printName ?> N° <?= $facture['TransportBill']['reference']; ?></div>
                                <br/>
                                <div class="date">Date : <?php
                                    $timestamp = strtotime($facture['TransportBill']['date']);
                                    $newDate = date("d/m/Y", $timestamp);
                                    echo $newDate;
                                     ?></div>
                                <div class="mode-payment">
                                    <?php if (isset($paymentMethod) && !empty($paymentMethod)) { ?>
                                        <span>Mode de paiement : </span> <?= $paymentMethod ?>
                                    <?php } ?>
                                </div>
                            </td>
                            <td class="doit" style="vertical-align:top;">
                                <span><strong>Doit</strong> <?= $facture['Supplier']['code'] ?></span><br>
                                <span class="client"><?= $facture['Supplier']['name'] ?></span><br>
                                <span class='info_client'>
                    <?php if (!empty($facture['Supplier']['adress'])) {
                        echo 'Adresse : ' . $facture['Supplier']['adress'];
                    } ?><br>
                                    <?php if (!empty($facture['Supplier']['tel'])) {
                                        echo 'Téléphone : ' . $facture['Supplier']['name'] . '<br>';
                                    } ?>
                                    <?php
                                    if (!empty($facture['Supplier']['if']) && !empty($facture['Supplier']['ai']) &&
                                        !empty($facture['Supplier']['rc'])) {
                                        echo 'RC : ' . $facture['Supplier']['rc'] . '<br/>';
                                        echo 'AI : ' . trim($facture['Supplier']['ai']) . ' NIF : ' . trim($facture['Supplier']['if']);
                                    } else {
                                        if (!empty($facture['Supplier']['rc'])) echo 'RC : ' . $facture['Supplier']['rc'] . ' ';
                                        if (!empty($facture['Supplier']['ai'])) echo 'AI : ' . $facture['Supplier']['ai'] . ' ';
                                        if (!empty($facture['Supplier']['if'])) echo 'NIF : ' . $facture['Supplier']['if'] . ' ';
                                    }
                                    ?>
                </span>
                            </td>
                        </tr>
                    </table>


                    <br/>


                    <table class="items" width="100%" style="font-size: 9pt;
    border-collapse: collapse; " cellpadding="8">
                        <thead>
                        <tr>
                            <th><?php echo 'N&deg;'; ?></th>
                            <th><?php echo __('Code'); ?></th>
                            <th><?php echo __('Designation'); ?></th>
                            <?php if ($type == TransportBillTypesEnum::pre_invoice) { ?>
                                <th><?php echo __('Departure date'); ?></th>
                                <th><?php echo __('Arrival date'); ?></th>
                            <?php } ?>
                            <?php if ( !empty($factors)){ ?>
                                <?php foreach($factors as $factor){ ?>
                                    <th><?php echo $factor['Factor']['name'] ; ?></th>
                                <?php } ?>
                            <?php } ?>
                            <?php if ($type == TransportBillTypesEnum::invoice ||
                                $type == TransportBillTypesEnum::quote ||
                                $type == TransportBillTypesEnum::order
                            ) {
                                ?>
                                <th><?php echo __('Unit price'); ?></th>
                            <?php } ?>
                            <th><?php echo __('Quantity'); ?></th>

                            <?php if ($type == TransportBillTypesEnum::invoice ||
                                $type == TransportBillTypesEnum::quote ||
                                $type == TransportBillTypesEnum::order
                            ) {
                                ?>
                                <th><?php echo __('Price HT'); ?></th>
                                <th><?php echo __('Price TTC'); ?></th>
                            <?php } ?>


                        </tr>
                        </thead>
                        <tbody class="items" >
                        <?php
                        /** @var ride $ride */
                        $i = 1;
                        $uv = 0;
                        foreach ($rides as $ride) { ?>
                            <tr style="margin-top: -10px !important;">
                                <td align="center"><?= $i ?></td>
                                <td align="center"><?= $ride['Product']['code'] ?></td>
                                <?php if ($ride['Product']['id'] == 1) { ?>
                                    <td align="left"><?= $ride['Product']['name'] . '(' . $ride['TransportBillDetailRides']['designation'] . ')' ?></td>
                                <?php } else { ?>
                                    <td align="left">
                                        <?= $ride['TransportBillDetailRides']['designation'] ?>
                                    </td>
                                <?php } ?>
                                <?php if ($type == TransportBillTypesEnum::pre_invoice) { ?>
                                    <td align="center"><?php
                                        $timestamp = strtotime($ride['SheetRideDetailRides']['real_start_date']);
                                        $newDate = date("d/m/Y", $timestamp);
                                        echo $newDate;


                                        ?>
                                        &nbsp;
                                    </td>
                                    <td align="center"><?php
                                        $timestamp = strtotime($ride['SheetRideDetailRides']['real_end_date']);
                                        $newDate = date("d/m/Y", $timestamp);
                                        echo $newDate;

                                        ?>
                                        &nbsp;
                                    </td>
                                <?php } ?>
                                <?php
                                if(!empty($factors)){
                                    $factorValues = $rideFactors[$ride['TransportBillDetailRides']['id']] ;

                                    foreach ($factors as $factor){
                                        if(isset($factorValues[$factor['Factor']['id']])){ ?>
                                            <td align="center"><?php echo h($factorValues[$factor['Factor']['id']]) ?></td>

                                        <?php }else {?>
                                            <td></td>
                                        <?php  }



                                    }





                                } ?>
                                <?php if ($type == TransportBillTypesEnum::invoice ||
                                    $type == TransportBillTypesEnum::quote ||
                                    $type == TransportBillTypesEnum::order
                                ) {
                                    ?>
                                    <td align="right"><?= number_format($ride['TransportBillDetailRides']['unit_price'], 2, ",", "."); ?></td>
                                <?php } ?>
                                <?php $uv = $uv + $ride['TransportBillDetailRides']['nb_trucks']; ?>
                                <td align="center"><?= $ride['TransportBillDetailRides']['nb_trucks']; ?></td>
                                <?php if ($type == TransportBillTypesEnum::invoice ||
                                    $type == TransportBillTypesEnum::quote ||
                                    $type == TransportBillTypesEnum::order
                                ) {
                                    ?>
                                    <td align="right"><?= number_format($ride['TransportBillDetailRides']['price_ht'], 2, ",", "."); ?></td>
                                    <td align="right"><?= number_format($ride['TransportBillDetailRides']['price_ttc'], 2, ",", "."); ?></td>

                                    <?php

                                } ?>
                            </tr>



                            <?php  $i++; } ?>



                        <?php
                        $fmt = new NumberFormatter('fr', NumberFormatter::SPELLOUT);
                        switch ($type) {
                            case  TransportBillTypesEnum::quote:
                                $ttcToLettersLabel = 'Arrêtée le présent devis à la somme de : ';
                                break;
                            case  TransportBillTypesEnum::order:
                                $ttcToLettersLabel = 'Arrêtée la présente commande à la somme de : ';
                                break;
                            case
                            TransportBillTypesEnum::pre_invoice:
                                $ttcToLettersLabel = 'Arrêtée la présente préfacture à la somme de : ';
                                break;

                            case
                            TransportBillTypesEnum::invoice:
                                $ttcToLettersLabel = 'Arrêtée la présente facture à la somme de : ';
                                break;
                        }


                        if (!empty($facture['TransportBill']['ristourne_val']) && !empty($facture['TransportBill']['stamp'])) {
                            $rowSpan = '6';
                        } elseif (!empty($facture['TransportBill']['ristourne_val'])) {
                            $rowSpan = '5';
                        } elseif (!empty($facture['TransportBill']['stamp'])) {
                            $rowSpan = '4';
                        }else{
                            $rowSpan = '3';
                        }
                        ?>
                        <tr>
                            <td class="blanktotal" colspan="7" rowspan="<?= $rowSpan ?>">
                                <span class="left toletters"><strong><?= $ttcToLettersLabel ?> :</strong> <?= strtoupper($fmt->format($facture['TransportBill']['total_ttc']) . ' ' . $this->Session->read("currencyName")) ?></span>
                            </td>
                            <?php
                            if(!empty($penalties)) {
                                $total = $facture['TransportBill']['total_ht'] + $totalPenaltyAmount;
                            }else {
                                $total =  $facture['TransportBill']['total_ht'];
                            }
                            ?>
                            <td class="totals"><strong><?= __('Total HT'); ?></strong></td>
                            <td class="totals cost">
                                <?= number_format($total, 2, ",", ".") ?> <?= 'DA' ?>
                            </td>
                        </tr>
                        <?php
                        if (!empty($facture['TransportBill']['ristourne_val'])) { ?>
                            <tr>
                                <td class="totals"><strong><?= __('Discount'); ?></strong></td>
                                <td class="totals cost">
                                    <?php
                                    echo number_format($facture['TransportBill']['ristourne_val'], 2, ",", ".") . $this->Session->read("currencyName") ;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="totals"><strong><?= __('Percentage discount'); ?></strong></td>
                                <td class="totals cost">
                                    <?php
                                    if($facture['TransportBill']['total_ht'] != 0){
                                        echo $facture['TransportBill']['ristourne_percentage']. " %";
                                    }else{
                                        echo 0 . "%";
                                    }

                                    ?>
                                </td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <td class="totals"><strong><?= __('TVA'); ?></strong></td>
                            <td class="totals cost">
                                <?php if(!empty($facture['TransportBill']['total_tva'])) {
                                    echo number_format($facture['TransportBill']['total_tva'], 2, ",", ".").'DA';
                                }else {
                                    echo 'EXO';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                        if(!empty($penalties)) {

                            foreach ($penalties as $penalty) {?>
                                <tr>
                                    <td class="totals"><strong><?php echo $penalty['TransportBillPenalty']['penalty_value']; ?></strong></td>
                                    <td class="totals cost"> <?= number_format($penalty['TransportBillPenalty']['penalty_amount'], 2, ",", "."); ?></td>
                                </tr>
                            <?php }  ?>
                            <tr>
                                <td class="totals"><strong><?php echo __('Total Géneral  '); ?></strong></td>
                                <td class="totals cost"><?= number_format($facture['TransportBill']['total_ht'], 2, ",", "."); ?></td>
                            </tr>

                        <?php    }
                        if (!empty($facture['TransportBill']['stamp'])) { ?>
                            <tr>
                                <td class="totals"><strong><?= __('Stamp'); ?></strong></td>
                                <td class="totals cost">
                                    <?php
                                    echo number_format($facture['TransportBill']['stamp'], 2, ",", ".") ?>. <?=  'DA' ?>;

                                    ?>
                                </td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <td class="totals"><strong><?= __('Net a payer'); ?></strong></td>
                            <td class="totals cost">
                                <?= number_format($facture['TransportBill']['total_ttc'], 2, ",", ".") ?>. <?= 'DA' ?>
                            </td>
                        </tr>


                        </tbody>



                    </table>

                    <?php
                    $stampToDisplay = $company['Company']['stamp_image'];
                    if (
                        isset($stampToDisplay) && !empty($stampToDisplay) &&
                        file_exists(WWW_ROOT . "/cachet/{$stampToDisplay}")
                    ) { ?>
                       <div valign="top" align="right">
                           <img class="stamp-print" alt="Stamp" src="<?= WWW_ROOT ?>/cachet/<?=rawurlencode($stampToDisplay)?>">

                       </div>;
                    <?php }
                    ?>










                    <table id="footer" style='border-top: 1px solid #000;' width='100%'>
                        <tr>
                            <td width='33%'><?php echo date("d-m-Y")  ?></td>
                            <td width='33%' align='center'></td>
                            <td width='33%' style='text-align: right'>UTRANX</td>
                        </tr>
                    </table>
                </body>
                </html>

                <?php
                $html = ob_get_clean();
                break ;
            case 3 :

                ob_start();
                ?>
                <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
                    <style type="text/css">
                        @page {
                            margin: 10px 25px 75px 25px;
                        }

                    </style>
                    <link type="text/css" href="<?= WWW_ROOT ?>/css/pdf/invoice_style.css" rel="stylesheet" />
                    <link type="text/css" href="<?= WWW_ROOT ?>/css/font-awesome.min.css" rel="stylesheet" />
                </head>
                <body>
                <?php
                /** @var array $company */
                if(!empty($company['logo'])){
                    $infoCompanyWidth = '50%';
                }else{
                    $infoCompanyWidth = '80%';
                }
                ?>
                <div id="header">
                    <?php if($entete_pdf=='1') { ?>
                        <table>
                            <tr>
                                <td class='info_company' valign="top" style="width: <?= $infoCompanyWidth ?>;">
                                    <span class="company"><?= Configure::read("nameCompany")  ?></span>
                                    <?php
                                    $nameCompany =$company['Company']['name'];
                                    if(!empty($nameCompany)){ ?>
                                        <span id="slogan"><?= Configure::read("nameCompany")  ?></span>
                                        <br>
                                        <?php
                                    }
                                    if (isset($company['Company']['address']) && !empty($company['Company']['adress'])) {
                                        echo "<br><br><span class='adr'> {$company['Company']['adress']}</span>";
                                    }
                                    if (isset($company['Company']['phone']) && !empty($company['Company']['phone'])) {
                                        echo "<br><span><strong>Tél. : </strong>{$company['Company']['phone']}</span>";
                                    }
                                    if (isset($company['Company']['fax']) && !empty($company['Company']['fax'])) {
                                        echo " / <span><strong>Fax  : </strong>{$company['Company']['fax']}</span>";
                                    }
                                    if (isset($company['Company']['mobile']) && !empty($company['Company']['mobile'])) {
                                        echo "<br><span><strong>Mobile : </strong>{$company['Company']['mobile']}</span>";
                                    }
                                    if (isset($company['Company']['rib']) && !empty($company['Company']['rib'])) {
                                        echo "<br><span><strong>RIB : </strong>{$company['Company']['rib']}</span>";
                                    }elseif (isset($company['Company']['cb']) && !empty($company['Company']['cb'])) {
                                        echo "<br><span><strong>CB : </strong>{$company['Company']['cb']}</span>";
                                    }
                                    ?>

                                </td>
                                <td class="info_fiscal" valign="top">
                                    <div>
                                        <?php
                                        if (isset($company['rc']) && !empty($company['rc'])) {
                                            echo "<span><strong>RC : </strong>{$company['rc']}</span><br>";
                                        }
                                        if (isset($company['ai']) && !empty($company['ai'])) {
                                            echo "<span><strong>AI : </strong>{$company['ai']}</span><br>";
                                        }
                                        if (isset($company['nif']) && !empty($company['nif'])) {
                                            echo "<span><strong>NIF : </strong>{$company['nif']}</span><br>";
                                        }
                                        ?>
                                    </div>
                                </td>
                                <?php
                                if(!empty($company['logo']) &&
                                    file_exists(WWW_ROOT . "/logo/{$company['logo']}")){ ?>
                                    <td valign="top" align="right">
                                        <img class="logo-print" alt="Logo" src="<?= WWW_ROOT ?>/logo/<?= rawurlencode($company['logo'])?>">


                                    </td>
                                <?php }

                                ?>
                            </tr>
                        </table>
                    <?php } ?>

                </div>
                <?php
                $quantity = 0;
                $printedProductsHeight = 0;
                $remainingHeightForTable = 0;
                $remainingPrintableHeight = 0;
                $currentPage = 1;

                switch ($type) {
                    case TransportBillTypesEnum::quote :

                        $printName ='Devis' ;
                        break;
                    case TransportBillTypesEnum::order :
                        $printName =' Bon de commande';
                        break;
                    case TransportBillTypesEnum::pre_invoice :
                        $printName ='Pr&eacute;facture';
                        break;
                    case TransportBillTypesEnum::invoice :

                        $printName ='Facture';
                        break;
                    case TransportBillTypesEnum::credit_note :

                        $printName ='Avoir de vente';
                        break;
                }

                switch ($facture['TransportBill']['payment_method']) {
                    case 1 :
                        $paymentMethod = __('A terme');
                        break;
                    case 2 :
                        $paymentMethod = __('Chèque');
                        break;
                    case 3 :
                        $paymentMethod = __('Chèque-banque');
                        break;
                    case 4 :
                        $paymentMethod = __('Virement');
                        break;
                    case 5 :
                        $paymentMethod = __('Avoir');
                        break;
                    case 6 :
                        $paymentMethod = __('Espèce');
                        break;
                    case 7 :
                        $paymentMethod = __('Traite');
                        break;
                    case 8 :
                        $paymentMethod = __('Fictif');
                        break;
                    default :

                        $paymentMethod = __('');

                }
                $transportBillDetailRideRistourne = false;
                foreach ($rides as $ride){
                    if (!empty($ride['TransportBillDetailRides']['ristourne_%'])){
                        $transportBillDetailRideRistourne = true;
                        break;
                    }
                }


                ?>

                <div class="box-body">

                    <table class="items" width="100%" style="border-collapse: collapse;">

                        <tr >
                            <td class=" bloc-info" style="vertical-align:top;">
                                <table class="border-colapse" width="100%">
                                    <tr>
                                        <td id="print-name" class="facture facture-center" colspan="2">
                                            <?= $printName ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold padding">
                                            N° :
                                        </td>
                                        <td class="padding">
                                            <?= $facture['TransportBill']['reference']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold padding">
                                            <?php if($type == TransportBillTypesEnum::credit_note){  ?>
                                                Date : <br/>Code client : <br/> N° Facture :
                                            <?php  }else { ?>
                                                Date : <br/>Code client :
                                            <?php } ?>
                                        </td>
                                        <td class="padding">
                                            <?php
                                            $timestamp = strtotime($facture['TransportBill']['date']);
                                            $newDate = date("d/m/Y", $timestamp);
                                            echo $newDate;
                                            ?>
                                            <br/>
                                            <?= $facture['Supplier']['code'] ?>

                                            <?php if($type == TransportBillTypesEnum::credit_note &&
                                                !empty($invoice)
                                            ){  ?>
                                                <br/>
                                                <?= $invoice['TransportBill']['reference'] ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class=" bloc-client" style="vertical-align:top;">
                                <span class="client" style="text-align: center; margin-bottom: 0px!important;"><?= $facture['Supplier']['name'] ?></span><br>
                                <span class='adr-client' >
                    <?php if (!empty($facture['Supplier']['adress'])) {
                        echo  $facture['Supplier']['adress'];
                    } ?></span><br>
                                <div class='info_client'>
                                    <?php
                                    if (!empty($facture['Supplier']['if']) && !empty($facture['Supplier']['ai']) &&
                                        !empty($facture['Supplier']['rc'])) {
                                        echo '<span style="margin-left: 200px">'.'N° RC : ' . $facture['Supplier']['rc'] . '</span><br/>';
                                        echo '<span style="margin-left: 200px">'.'N° Article : ' . trim($facture['Supplier']['ai']) . '</span><br/>';
                                        echo '<span style="margin-left: 200px">'.' N°IF : ' . trim($facture['Supplier']['if']).'</span>';
                                    } else {
                                        if (!empty($facture['Supplier']['rc'])) echo 'RC : ' . $facture['Supplier']['rc'] . ' ';
                                        if (!empty($facture['Supplier']['ai'])) echo 'AI : ' . $facture['Supplier']['ai'] . ' ';
                                        if (!empty($facture['Supplier']['if'])) echo 'NIF : ' . $facture['Supplier']['if'] . ' ';
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <br/>
                    <table class="items" width="100%" style="font-size: 9pt;
    border-collapse: collapse; " cellpadding="8">
                        <thead>
                        <tr>
                            <?php if ($type != TransportBillTypesEnum::quote) { ?>
                                <th><?php echo __('Date'); ?></th>
                            <?php } ?>
                            <th><?php
                                if ($type == TransportBillTypesEnum::credit_note){
                                    echo __('Designation');
                                }else{
                                    echo __('Destination');
                                }
                                ?></th>
                            <?php if($type !=TransportBillTypesEnum::credit_note ||
                                $facture['TransportBill']['credit_note_type']!=2){ ?>
                                <th><?php echo __('Car type'); ?></th>
                                <th><?php echo __('Mission Type'); ?></th>
                            <?php } ?>
                            <?php if ( !empty($factors)){ ?>
                                <?php foreach($factors as $factor){ ?>
                                    <th><?php echo $factor['Factor']['name'] ; ?></th>
                                <?php } ?>
                            <?php } ?>
                            <th><?php echo __('Quantity'); ?></th>
                            <?php if ($type == TransportBillTypesEnum::invoice ||
                                $type == TransportBillTypesEnum::quote ||
                                $type == TransportBillTypesEnum::order ||
                                $type == TransportBillTypesEnum::pre_invoice ||
                                $type == TransportBillTypesEnum::credit_note
                            ) {
                                ?>
                                <th><?php echo __('PU HT'); ?></th>
                            <?php } ?>

                            <?php if ($transportBillDetailRideRistourne) {
                                ?>
                                <th><?php echo __('Ristourne %'); ?></th>
                                <th><?php echo __('Ristourne value'); ?></th>
                            <?php } ?>

                            <?php if ($type == TransportBillTypesEnum::invoice ||
                                $type == TransportBillTypesEnum::quote ||
                                $type == TransportBillTypesEnum::order ||
                                $type == TransportBillTypesEnum::credit_note
                            ) {
                                ?>
                                <th><?php echo __('Price HT'); ?></th>
                            <?php } ?>


                        </tr>
                        </thead>
                        <tbody class="items" >
                        <?php
                        /** @var ride $ride */
                        $i = 1;
                        $uv = 0;
                        foreach ($rides as $ride) { ?>
                            <tr style="margin-top: -10px !important;">
                                <?php if ($type != TransportBillTypesEnum::quote) { ?>
                                    <td align="center"><?php
                                        $timestamp = strtotime($ride['TransportBillDetailRides']['programming_date']);
                                        $newDate = date("d/m/Y", $timestamp);
                                        echo $newDate; ?>
                                    </td>
                                <?php }?>
                                <?php

                                if ($ride['Product']['id'] == 1 ) {
                                    if($type ==TransportBillTypesEnum::credit_note
                                        || $type == TransportBillTypesEnum::invoice ){
                                        $destination = $ride['TransportBillDetailRides']['designation'];
                                    }else {
                                        if($ride['TransportBillDetailRides']['type_ride']==2){
                                            $destination = $ride['Departure']['name'].' - '.$ride['Arrival']['name'];
                                        } else {
                                            $destination = $ride['DepartureDestination']['name'].' - '.$ride['ArrivalDestination']['name'];
                                        }
                                    }

                                    ?>
                                    <td align="left"><?= $destination ?></td>
                                <?php } else { ?>
                                    <td align="left">
                                        <?= $ride['TransportBillDetailRides']['designation'] ?>
                                    </td>
                                <?php } ?>
                                <?php if($type !=TransportBillTypesEnum::credit_note ||
                                    $facture['TransportBill']['credit_note_type']!=2){ ?>
                                    <td>
                                        <?php if($ride['TransportBillDetailRides']['type_ride']==2){
                                            echo $ride['Type']['name'];
                                        }else {
                                            echo $ride['CarType']['name'];
                                        }?>
                                    </td>
                                    <td>
                                        <?php
                                        switch ($ride['TransportBillDetailRides']['delivery_with_return']) {
                                            case 1:
                                                echo __('Simple delivery');
                                                break;
                                            case 2:
                                                echo __('Simple return');
                                                break;
                                            case 3:
                                                echo __('Delivery / Return');
                                                break;
                                            default;
                                        }
                                        ?>
                                    </td>
                                <?php } ?>

                                <?php
                                if(!empty($factors)){
                                    $factorValues = $rideFactors[$ride['TransportBillDetailRides']['id']] ;

                                    foreach ($factors as $factor){
                                        if(isset($factorValues[$factor['Factor']['id']])){ ?>
                                            <td align="center"><?php echo h($factorValues[$factor['Factor']['id']]) ?></td>

                                        <?php }else {?>
                                            <td></td>
                                        <?php  }
                                    }
                                } ?>
                                <td align="center"><?= $ride['TransportBillDetailRides']['nb_trucks']; ?></td>
                                <?php if ($type == TransportBillTypesEnum::invoice ||
                                    $type == TransportBillTypesEnum::quote ||
                                    $type == TransportBillTypesEnum::order ||
                                    $type == TransportBillTypesEnum::pre_invoice ||
                                    $type == TransportBillTypesEnum::credit_note
                                ) {
                                    ?>


                                    <td align="right"><?= number_format($ride['TransportBillDetailRides']['unit_price'], 2, ",", "."); ?></td>
                                <?php } ?>
                                <?php $uv = $uv + $ride['TransportBillDetailRides']['nb_trucks']; ?>

                                <?php if ($transportBillDetailRideRistourne) {
                                    ?>
                                    <td align="right"><?= $ride['TransportBillDetailRides']['ristourne_%']; ?></td>
                                    <td align="right"><?= number_format($ride['TransportBillDetailRides']['ristourne_val'], 2, ",", "."); ?></td>
                                <?php } ?>
                                <?php if ($type == TransportBillTypesEnum::invoice ||
                                    $type == TransportBillTypesEnum::quote ||
                                    $type == TransportBillTypesEnum::order ||
                                    $type == TransportBillTypesEnum::credit_note
                                ) {
                                    ?>
                                    <td align="right"><?= number_format($ride['TransportBillDetailRides']['price_ht'], 2, ",", "."); ?></td>

                                    <?php

                                } ?>
                            </tr>



                            <?php  $i++; } ?>
                        <?php
                        $fmt = new NumberFormatter('fr', NumberFormatter::SPELLOUT);
                        switch ($type) {
                            case  TransportBillTypesEnum::quote:
                                $ttcToLettersLabel = 'Arrêtée le présent devis à la somme de : ';
                                break;
                            case  TransportBillTypesEnum::order:
                                $ttcToLettersLabel = 'Arrêtée la présente commande à la somme de : ';
                                break;
                            case
                            TransportBillTypesEnum::pre_invoice:
                                $ttcToLettersLabel = 'Arrêtée la présente préfacture à la somme de : ';
                                break;

                            case
                            TransportBillTypesEnum::invoice:
                                $ttcToLettersLabel = 'Arrêtée la présente facture à la somme de : ';
                                break;

                            case
                            TransportBillTypesEnum::credit_note:
                                $ttcToLettersLabel = "Arrêtée la présente facture d'avoir à la somme de : ";
                                break;
                        }


                        if (!empty($facture['TransportBill']['ristourne_val']) && !empty($facture['TransportBill']['stamp'])) {
                            $rowSpan = '8';
                        } elseif (!empty($facture['TransportBill']['ristourne_val'])) {
                            $rowSpan = '7';
                        } elseif (!empty($facture['TransportBill']['stamp'])) {
                            $rowSpan = '5';
                        }else{
                            $rowSpan = '4';
                        }
                        if($type==TransportBillTypesEnum::quote ||
                            $facture['TransportBill']['credit_note_type']==2
                        ){
                            if ($transportBillDetailRideRistourne){
                                $colSpan = '6';
                            }else{
                                $colSpan = '4';
                            }
                        }else {
                            if($type==TransportBillTypesEnum::pre_invoice){
                                if ($transportBillDetailRideRistourne){
                                    $colSpan ='6';
                                }else{
                                    $colSpan ='4';
                                }
                            }else {
                                if ($transportBillDetailRideRistourne){
                                    $colSpan ='7';
                                }else{
                                    $colSpan ='5';
                                }
                            }
                        }
                        ?>
                        <tr>
                            <td valign=bottom class="blanktotal" colspan="<?= $colSpan ?>" rowspan="<?= $rowSpan ?>">
                                <span class="left toletters"><strong><?= $ttcToLettersLabel ?> </strong> </span>
                            </td>
                            <?php
                            if(!empty($penalties)) {
                                $total = $facture['TransportBill']['total_ht'] + $totalPenaltyAmount;
                            }else {
                                $total =  $facture['TransportBill']['total_ht'];
                            }
                            if(!empty($facture['TransportBill']['ristourne_val'])){
                                $total = $total +$facture['TransportBill']['ristourne_val'];
                            }
                            ?>

                            <td class="totals"><strong><?= __('Total HT'); ?></strong></td>
                            <td class="totals cost">
                                <?= number_format($total, 2, ",", ".") ?>
                            </td>
                        </tr>
                        <?php
                        if (!empty($facture['TransportBill']['ristourne_val'])) { ?>
                            <tr>
                                <td class="totals"><strong><?= __('Discount'); ?></strong></td>
                                <td class="totals cost">
                                    <?php
                                    if($facture['TransportBill']['total_ht'] != 0){
                                        echo $facture['TransportBill']['ristourne_percentage']. " %";
                                    }else{
                                        echo 0 . "%";
                                    }

                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="totals"><strong><?= __('Discount amount'); ?></strong></td>
                                <td class="totals cost">
                                    <?php
                                    echo number_format($facture['TransportBill']['ristourne_val'], 2, ",", ".") ;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="totals"><strong><?= __('Total HT Net'); ?></strong></td>
                                <td class="totals cost">
                                    <?php
                                    echo number_format($facture['TransportBill']['total_ht'], 2, ",", ".") ;
                                    ?>
                                </td>
                            </tr>

                        <?php } ?>

                        <tr>
                            <td class="totals"><strong><?= __('TVA'); ?></strong></td>
                            <td class="totals cost">
                                <?php if(!empty($facture['TransportBill']['total_tva'])) {
                                    echo number_format($facture['TransportBill']['total_tva'], 2, ",", ".");
                                }else {
                                    echo 'EXO';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                        if(!empty($penalties)) {

                            foreach ($penalties as $penalty) {?>
                                <tr>
                                    <td class="totals"><strong><?php echo $penalty['TransportBillPenalty']['penalty_value']; ?></strong></td>
                                    <td class="totals cost"> <?= number_format($penalty['TransportBillPenalty']['penalty_amount'], 2, ",", "."); ?></td>
                                </tr>
                            <?php }  ?>
                            <tr>
                                <td class="totals"><strong><?php echo __('Total Géneral  '); ?></strong></td>
                                <td class="totals cost"><?= number_format($facture['TransportBill']['total_ht'], 2, ",", "."); ?></td>
                            </tr>

                        <?php    }
                        if (!empty($facture['TransportBill']['stamp'])) { ?>
                            <tr>
                                <td class="totals"><strong><?= __('Stamp'); ?></strong></td>
                                <td class="totals cost">
                                    <?php
                                    echo number_format($facture['TransportBill']['stamp'], 2, ",", ".") ?>

                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td class="totals"><strong><?= __('Total TTC'); ?></strong></td>
                            <td class="totals cost">
                                <?= number_format($facture['TransportBill']['total_ttc'], 2, ",", ".") ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="totals"><strong><?= __('Net a payer'); ?></strong></td>
                            <td class="totals cost">
                                <strong> <?= number_format($facture['TransportBill']['total_ttc'], 2, ",", ".") ?></strong>
                            </td>
                        </tr>
                        <tr>
                            <?php if($type==TransportBillTypesEnum::quote ||
                                $facture['TransportBill']['credit_note_type']==2

                            ){
                                if ($transportBillDetailRideRistourne){
                                    $colSpan ='8';
                                }else{
                                    $colSpan ='6';
                                }
                            }else {
                                if($type==TransportBillTypesEnum::pre_invoice){
                                    if ($transportBillDetailRideRistourne){
                                        $colSpan ='8';
                                    }else{
                                        $colSpan ='6';
                                    }
                                }else {
                                    if ($transportBillDetailRideRistourne){
                                        $colSpan ='9';
                                    }else{
                                        $colSpan ='7';
                                    }
                                }
                            }
                            ?>
                            <td  class="blanktotal" colspan="<?= $colSpan ?>" >

                <span class="left toletters">
                    <?php
                    $f = new NumberFormatter("fr", NumberFormatter::SPELLOUT);
                    $temporaryTtc = explode('.', number_format($facture['TransportBill']['total_ttc'], 2, '.', ' '));
                    if (isset($temporaryTtc[1]) && $temporaryTtc[1] > 0) {
                        $ttcToLetters =
                            $f->format(str_replace(' ', '', $temporaryTtc[0])) . ' ' . 'Dinars ' . ' ' .
                            __('and') . ' ' . ucwords($f->format(str_replace(' ', '', $temporaryTtc[1]))) .
                            ' ' . __('cents');
                    } else {
                        $ttcToLetters = $f->format(str_replace(' ', '', $temporaryTtc[0])) . ' ' . 'Dinars ';
                    }
                    ?>
                    <?= $ttcToLetters ; ?>
                </span>
                            </td>
                        </tr>


                        </tbody>



                    </table>

                    <?php
                    $stampToDisplay = $company['Company']['stamp_image'];

                    if (
                        isset($stampToDisplay) && !empty($stampToDisplay) &&
                        file_exists(WWW_ROOT . "cachet/{$stampToDisplay}")
                    ) {
                        echo '<div valign="top" align="right">'; ?>
                        <img class="stamp-print" alt="Stamp" src="<?= WWW_ROOT ?>/cachet/<?=rawurlencode($stampToDisplay)?>">
                        <?php
                        echo '</div>';
                    }
                    ?>

                    <table id="footer" style='border-top: 1px solid #000;' width='100%'>
                        <tr>
                            <td width='33%'><?php echo date("d-m-Y")  ?></td>
                            <td width='33%' align='center'></td>
                            <td width='33%' style='text-align: right'>UTRANX</td>
                        </tr>
                    </table>
                </body>
                </html>

                <?php
                $html = ob_get_clean();
                break ;
            default :
                ob_start();
                ?>

                <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
                    <style type="text/css">
                        @page {
                            margin: 10px 25px 75px 25px;
                        }

                    </style>
                    <link type="text/css" href="<?= WWW_ROOT ?>/css/pdf/invoice_style.css" rel="stylesheet" />
                    <link type="text/css" href="<?= WWW_ROOT ?>/css/font-awesome.min.css" rel="stylesheet" />
                </head>
                <body>
                <?php
                /** @var array $company */
                if(!empty($company['logo'])){
                    $infoCompanyWidth = '50%';
                }else{
                    $infoCompanyWidth = '80%';
                }
                ?>
                <div id="header">
                    <table>
                        <tr>
                            <td class='info_company' valign="top" style="width: <?= $infoCompanyWidth ?>;">
                                <span class="company"><?= Configure::read("nameCompany")  ?></span>
                                <?php
                                $nameCompany =$company['Company']['name'];
                                if(!empty($nameCompany)){ ?>
                                    <br>
                                    <span id="slogan"><?= Configure::read("nameCompany")  ?></span>
                                    <?php
                                }
                                if (isset($company['Company']['address']) && !empty($company['Company']['adress'])) {
                                    echo "<br><br><span class='adr'> {$company['Company']['adress']}</span>";
                                }
                                if (isset($company['Company']['phone']) && !empty($company['Company']['phone'])) {
                                    echo "<br><span><strong>Tél. : </strong>{$company['Company']['phone']}</span>";
                                }
                                if (isset($company['Company']['fax']) && !empty($company['Company']['fax'])) {
                                    echo " / <span><strong>Fax  : </strong>{$company['Company']['fax']}</span>";
                                }
                                if (isset($company['Company']['mobile']) && !empty($company['Company']['mobile'])) {
                                    echo "<br><span><strong>Mobile : </strong>{$company['Company']['mobile']}</span>";
                                }
                                if (isset($company['Company']['rib']) && !empty($company['Company']['rib'])) {
                                    echo "<br><span><strong>RIB : </strong>{$company['Company']['rib']}</span>";
                                }elseif (isset($company['Company']['cb']) && !empty($company['Company']['cb'])) {
                                    echo "<br><span><strong>CB : </strong>{$company['Company']['cb']}</span>";
                                }
                                ?>

                            </td>
                            <td class="info_fiscal" valign="top">
                                <div>
                                    <?php
                                    if (isset($company['rc']) && !empty($company['rc'])) {
                                        echo "<span><strong>RC : </strong>{$company['rc']}</span><br>";
                                    }
                                    if (isset($company['ai']) && !empty($company['ai'])) {
                                        echo "<span><strong>AI : </strong>{$company['ai']}</span><br>";
                                    }
                                    if (isset($company['nif']) && !empty($company['nif'])) {
                                        echo "<span><strong>NIF : </strong>{$company['nif']}</span><br>";
                                    }
                                    ?>
                                </div>
                            </td>
                            <?php
                            if(!empty($company['logo']) &&
                                file_exists(WWW_ROOT . "/logo/{$company['logo']}")){ ?>
                                <td valign="top" align="right">


                                <img class="logo-print" alt="Logo" src="<?= WWW_ROOT ?>/logo/<?=rawurlencode($company['logo'])?>">

                                </td>;
                           <?php }

                            ?>
                        </tr>
                    </table>
                </div>
                <?php




                switch ($type) {
                    case TransportBillTypesEnum::quote :

                        $printName ='Devis' ;
                        break;
                    case TransportBillTypesEnum::order :
                        $printName =' Bon de commande';
                        break;
                    case TransportBillTypesEnum::pre_invoice :
                        $printName ='Pr&eacute;facture';
                        break;
                    case TransportBillTypesEnum::invoice :

                        $printName ='Facture';
                        break;
                }

                switch ($facture['TransportBill']['payment_method']) {
                    case 1 :
                        $paymentMethod = __('A terme');
                        break;
                    case 2 :
                        $paymentMethod = __('Chèque');
                        break;
                    case 3 :
                        $paymentMethod = __('Chèque-banque');
                        break;
                    case 4 :
                        $paymentMethod = __('Virement');
                        break;
                    case 5 :
                        $paymentMethod = __('Avoir');
                        break;
                    case 6 :
                        $paymentMethod = __('Espèce');
                        break;
                    case 7 :
                        $paymentMethod = __('Traite');
                        break;
                    case 8 :
                        $paymentMethod = __('Fictif');
                        break;
                    default :

                        $paymentMethod = __('');

                }


                ?>

                <div class="box-body">

                    <table class="bloc-center">

                        <tr>
                            <td class="document_reference" style="vertical-align:top;">
                                <div class="facture">
                                    <?= $printName ?> N° <?= $facture['TransportBill']['reference']; ?></div>
                                <br/>
                                <div class="date">Date : <?php
                                    $timestamp = strtotime($facture['TransportBill']['date']);
                                    $newDate = date("d/m/Y", $timestamp);
                                    echo $newDate;


                                    ?></div>
                                <div class="mode-payment">
                                    <?php if (isset($paymentMethod) && !empty($paymentMethod)) { ?>
                                        <span>Mode de paiement : </span> <?= $paymentMethod ?>
                                    <?php } ?>
                                </div>
                            </td>
                            <td class="doit" style="vertical-align:top;">
                                <span><strong>Doit</strong> <?= $facture['Supplier']['code'] ?></span><br>
                                <span class="client"><?= $facture['Supplier']['name'] ?></span><br>
                                <span class='info_client'>
                    <?php if (!empty($facture['Supplier']['adress'])) {
                        echo 'Adresse : ' . $facture['Supplier']['adress'];
                    } ?><br>
                                    <?php if (!empty($facture['Supplier']['tel'])) {
                                        echo 'Téléphone : ' . $facture['Supplier']['name'] . '<br>';
                                    } ?>
                                    <?php
                                    if (!empty($facture['Supplier']['if']) && !empty($facture['Supplier']['ai']) &&
                                        !empty($facture['Supplier']['rc'])) {
                                        echo 'RC : ' . $facture['Supplier']['rc'] . '<br/>';
                                        echo 'AI : ' . trim($facture['Supplier']['ai']) . ' NIF : ' . trim($facture['Supplier']['if']);
                                    } else {
                                        if (!empty($facture['Supplier']['rc'])) echo 'RC : ' . $facture['Supplier']['rc'] . ' ';
                                        if (!empty($facture['Supplier']['ai'])) echo 'AI : ' . $facture['Supplier']['ai'] . ' ';
                                        if (!empty($facture['Supplier']['if'])) echo 'NIF : ' . $facture['Supplier']['if'] . ' ';
                                    }
                                    ?>
                </span>
                            </td>
                        </tr>
                    </table>


                    <br/>


                    <table class="items" width="100%" style="font-size: 9pt;
    border-collapse: collapse; " cellpadding="8">
                        <thead>
                        <tr>
                            <th><?php echo 'N&deg;'; ?></th>
                            <th><?php echo __('Code'); ?></th>
                            <th><?php echo __('Designation'); ?></th>
                            <?php if ($type == TransportBillTypesEnum::pre_invoice) { ?>
                                <th><?php echo __('Departure date'); ?></th>
                                <th><?php echo __('Arrival date'); ?></th>
                            <?php } ?>
                            <?php if ( !empty($factors)){ ?>
                                <?php foreach($factors as $factor){ ?>
                                    <th><?php echo $factor['Factor']['name'] ; ?></th>
                                <?php } ?>
                            <?php } ?>
                            <?php if ($type == TransportBillTypesEnum::invoice ||
                                $type == TransportBillTypesEnum::quote ||
                                $type == TransportBillTypesEnum::order
                            ) {
                                ?>
                                <th><?php echo __('Unit price'); ?></th>
                            <?php } ?>
                            <th><?php echo __('Quantity'); ?></th>

                            <?php if ($type == TransportBillTypesEnum::invoice ||
                                $type == TransportBillTypesEnum::quote ||
                                $type == TransportBillTypesEnum::order
                            ) {
                                ?>
                                <th><?php echo __('Price HT'); ?></th>
                                <th><?php echo __('Price TTC'); ?></th>
                            <?php } ?>


                        </tr>
                        </thead>
                        <tbody class="items" >
                        <?php
                        /** @var ride $ride */
                        $i = 1;
                        $uv = 0;
                        foreach ($rides as $ride) { ?>
                            <tr style="margin-top: -10px !important;">
                                <td align="center"><?= $i ?></td>
                                <td align="center"><?= $ride['Product']['code'] ?></td>
                                <?php if ($ride['Product']['id'] == 1) { ?>
                                    <td align="left"><?= $ride['Product']['name'] . '(' . $ride['TransportBillDetailRides']['designation'] . ')' ?></td>
                                <?php } else { ?>
                                    <td align="left">
                                        <?= $ride['TransportBillDetailRides']['designation'] ?>
                                    </td>
                                <?php } ?>
                                <?php if ($type == TransportBillTypesEnum::pre_invoice) { ?>
                                    <td align="center"><?php
                                        $timestamp = strtotime($ride['SheetRideDetailRides']['real_start_date']);
                                        $newDate = date("d/m/Y", $timestamp);
                                        echo $newDate;

                                        ?>
                                        &nbsp;
                                    </td>
                                    <td align="center"><?php
                                        $timestamp = strtotime($ride['SheetRideDetailRides']['real_end_date']);
                                        $newDate = date("d/m/Y", $timestamp);
                                        echo $newDate;

                                        ?>
                                        &nbsp;
                                    </td>
                                <?php } ?>
                                <?php
                                if(!empty($factors)){
                                    $factorValues = $rideFactors[$ride['TransportBillDetailRides']['id']] ;

                                    foreach ($factors as $factor){
                                        if(isset($factorValues[$factor['Factor']['id']])){ ?>
                                            <td align="center"><?php echo h($factorValues[$factor['Factor']['id']]) ?></td>

                                        <?php }else {?>
                                            <td></td>
                                        <?php  }



                                    }





                                } ?>
                                <?php if ($type == TransportBillTypesEnum::invoice ||
                                    $type == TransportBillTypesEnum::quote ||
                                    $type == TransportBillTypesEnum::order
                                ) {
                                    ?>
                                    <td align="right"><?= number_format($ride['TransportBillDetailRides']['unit_price'], 2, ",", "."); ?></td>
                                <?php } ?>
                                <?php $uv = $uv + $ride['TransportBillDetailRides']['nb_trucks']; ?>
                                <td align="center"><?= $ride['TransportBillDetailRides']['nb_trucks']; ?></td>
                                <?php if ($type == TransportBillTypesEnum::invoice ||
                                    $type == TransportBillTypesEnum::quote ||
                                    $type == TransportBillTypesEnum::order
                                ) {
                                    ?>
                                    <td align="right"><?= number_format($ride['TransportBillDetailRides']['price_ht'], 2, ",", "."); ?></td>
                                    <td align="right"><?= number_format($ride['TransportBillDetailRides']['price_ttc'], 2, ",", "."); ?></td>

                                    <?php

                                } ?>
                            </tr>



                            <?php  $i++; } ?>



                        <?php
                        $fmt = new NumberFormatter('fr', NumberFormatter::SPELLOUT);
                        switch ($type) {
                            case  TransportBillTypesEnum::quote:
                                $ttcToLettersLabel = 'Arrêtée le présent devis à la somme de : ';
                                break;
                            case  TransportBillTypesEnum::order:
                                $ttcToLettersLabel = 'Arrêtée la présente commande à la somme de : ';
                                break;
                            case
                            TransportBillTypesEnum::pre_invoice:
                                $ttcToLettersLabel = 'Arrêtée la présente préfacture à la somme de : ';
                                break;

                            case
                            TransportBillTypesEnum::invoice:
                                $ttcToLettersLabel = 'Arrêtée la présente facture à la somme de : ';
                                break;
                        }


                        if (!empty($facture['TransportBill']['ristourne_val']) && !empty($facture['TransportBill']['stamp'])) {
                            $rowSpan = '6';
                        } elseif (!empty($facture['TransportBill']['ristourne_val'])) {
                            $rowSpan = '5';
                        } elseif (!empty($facture['TransportBill']['stamp'])) {
                            $rowSpan = '4';
                        }else{
                            $rowSpan = '3';
                        }
                        ?>
                        <tr>
                            <td class="blanktotal" colspan="5" rowspan="<?= $rowSpan ?>">
                                <span class="left toletters"><strong><?= $ttcToLettersLabel ?> :</strong> <?= strtoupper($fmt->format($facture['TransportBill']['total_ttc']) . ' ' . $this->Session->read("currencyName")) ?></span>
                            </td>
                            <?php
                            if(!empty($penalties)) {
                                $total = $facture['TransportBill']['total_ht'] + $totalPenaltyAmount;
                            }else {
                                $total =  $facture['TransportBill']['total_ht'];
                            }
                            ?>
                            <td class="totals"><strong><?= __('Total HT'); ?></strong></td>
                            <td class="totals cost">
                                <?= number_format($total, 2, ",", ".") ?> <?= 'DA' ?>
                            </td>
                        </tr>
                        <?php
                        if (!empty($facture['TransportBill']['ristourne_val'])) { ?>
                            <tr>
                                <td class="totals"><strong><?= __('Discount'); ?></strong></td>
                                <td class="totals cost">
                                    <?php
                                    echo number_format($facture['TransportBill']['ristourne_val'], 2, ",", ".") . $this->Session->read("currencyName") ;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="totals"><strong><?= __('Percentage discount'); ?></strong></td>
                                <td class="totals cost">
                                    <?php
                                    if($facture['TransportBill']['total_ht'] != 0){
                                        echo $facture['TransportBill']['ristourne_percentage']. " %";
                                    }else{
                                        echo 0 . "%";
                                    }

                                    ?>
                                </td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <td class="totals"><strong><?= __('TVA'); ?></strong></td>
                            <td class="totals cost">
                                <?php if(!empty($facture['TransportBill']['total_tva'])) {
                                    echo number_format($facture['TransportBill']['total_tva'], 2, ",", ".").'DA';
                                }else {
                                    echo 'EXO';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                        if(!empty($penalties)) {

                            foreach ($penalties as $penalty) {?>
                                <tr>
                                    <td class="totals"><strong><?php echo $penalty['TransportBillPenalty']['penalty_value']; ?></strong></td>
                                    <td class="totals cost"> <?= number_format($penalty['TransportBillPenalty']['penalty_amount'], 2, ",", "."); ?></td>
                                </tr>
                            <?php }  ?>
                            <tr>
                                <td class="totals"><strong><?php echo __('Total Géneral  '); ?></strong></td>
                                <td class="totals cost"><?= number_format($facture['TransportBill']['total_ht'], 2, ",", "."); ?></td>
                            </tr>

                        <?php    }
                        if (!empty($facture['TransportBill']['stamp'])) { ?>
                            <tr>
                                <td class="totals"><strong><?= __('Stamp'); ?></strong></td>
                                <td class="totals cost">
                                    <?php
                                    echo number_format($facture['TransportBill']['stamp'], 2, ",", ".") ?>. <?=  'DA' ?>;
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td class="totals"><strong><?= __('Net a payer'); ?></strong></td>
                            <td class="totals cost">
                                <?= number_format($facture['TransportBill']['total_ttc'], 2, ",", ".") ?>. <?= 'DA' ?>
                            </td>
                        </tr>



                        </tbody>



                    </table>

                    <?php
                    $stampToDisplay = $company['Company']['stamp_image'];
                    if (
                        isset($stampToDisplay) && !empty($stampToDisplay) &&
                        file_exists(WWW_ROOT . "/cachet/{$stampToDisplay}")
                    ) { ?>
                        <div valign="top" align="right">
                           <img class="stamp-print" alt="Stamp" src="<?= WWW_ROOT ?>/cachet/<?=rawurlencode($stampToDisplay)?>">

                       </div>;
                    <?php }
                    ?>









                    <table id="footer" style='border-top: 1px solid #000;' width='100%'>
                        <tr>
                            <td width='33%'><?php echo date("d-m-Y")  ?></td>
                            <td width='33%' align='center'></td>
                            <td width='33%' style='text-align: right'>UTRANX</td>
                        </tr>
                    </table>
                </body>
                </html>

                <?php
                $html = ob_get_clean();
        }



        $this->dompdf = new Dompdf(array('chroot' => WWW_ROOT));
        $papersize = "A4";
        $orientation = 'portrait';
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper($papersize, $orientation);
        $this->dompdf->render();
        $output = $this->dompdf->output();
        switch ($type) {
            case TransportBillTypesEnum::quote :
                $name = 'devis' . '_' . $facture['TransportBill']['reference'] . '.pdf';
                break;
            case TransportBillTypesEnum::order :
                $name = 'commande_client' . '_' . $facture['TransportBill']['reference'] . '.pdf';
                break;
            case TransportBillTypesEnum::pre_invoice :
                $name = 'prefacture' . '_' . $facture['TransportBill']['reference'] . '.pdf';
                break;
            case TransportBillTypesEnum::invoice :
                $name = 'facture' . '_' . $facture['TransportBill']['reference'] . '.pdf';
                break;
            case TransportBillTypesEnum::credit_note :
                $name = 'avoir' . '_' . $facture['TransportBill']['reference'] . '.pdf';
                break;
            default :
                $name = "";
        }

        $name = str_replace('/', '-', $name);

        file_put_contents('./document_transport/' . $name, $output);


        $this->set('name', $name);


    }

    function getPriceProduct($productId = null, $i = null, $priceCategoryId = null, $clientId = null)
    {


        if ($priceCategoryId == 0 || $priceCategoryId == null) {

            $price = $this->ProductPrice->getPriceByParams($productId, $clientId);

        } else {

            $conditions = array('ProductPrice.product_id' => $productId, 'ProductPrice.price_category_id' => $priceCategoryId);

            $price = $this->ProductPrice->getProductPricesByConditions($conditions, 'first');
        }

        $profileId = $this->Auth->user('profile_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        $this->set(compact('profileId', 'i', 'price'));
    }

    /**
     * delete method
     * @param null|int $type
     * @param string $id
     *
     * @return void
     */
    public function delete($type = null, $id = null)
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        if ($type == TransportBillTypesEnum::quote_request) {
            $this->verifyUserPermission(SectionsEnum::demande_de_devis, $user_id, ActionsEnum::delete, "TransportBills",
                $id, "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::quote) {
            $this->verifyUserPermission(SectionsEnum::devis, $user_id, ActionsEnum::delete, "TransportBills", $id,
                "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::order) {
            $this->verifyUserPermission(SectionsEnum::commande_client, $user_id, ActionsEnum::delete, "TransportBills",
                $id, "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::pre_invoice) {
            $this->verifyUserPermission(SectionsEnum::prefacture, $user_id, ActionsEnum::delete, "TransportBills", $id,
                "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::invoice) {
            $this->verifyUserPermission(SectionsEnum::facture, $user_id, ActionsEnum::delete, "TransportBills", $id,
                "TransportBill", $type);
        }

        $this->TransportBill->id = $id;
        if (!$this->TransportBill->exists()) {
            throw new NotFoundException(__('Invalid transport bill'));
        }
        $current = $this->TransportBill->find("first", array("conditions" => array("TransportBill.id" => $id)));
        if ($current['TransportBill']['locked']) {
            $this->Flash->error(__('You must first unlock the bill.'));
            $this->redirect(array('action' => 'index', $type));
        }
        $this->verifyDependences($id, $type);


       // $this->request->allowMethod('post', 'delete');
        //var_dump($type); die();

        if ($this->TransportBill->delete()) {

            switch ($type) {
                case TransportBillTypesEnum:: quote_request:
                    $this->saveUserAction(SectionsEnum::demande_de_devis, $id, $this->Session->read('Auth.User.id'), ActionsEnum::delete);
                    $this->Flash->success(__('The quotation has been saved.'));
                    break;
                case TransportBillTypesEnum:: quote:
                    $this->saveUserAction(SectionsEnum::devis, $id, $this->Session->read('Auth.User.id'), ActionsEnum::delete);
                    $this->Flash->success(__('The quotation has been saved.'));
                    break;
                case TransportBillTypesEnum::order :
                    $this->saveUserAction(SectionsEnum::commande_client, $id, $this->Session->read('Auth.User.id'), ActionsEnum::delete);
                    $this->Flash->success(__('The customer order has been saved.'));
                    break;
                case TransportBillTypesEnum::pre_invoice :
                    $this->saveUserAction(SectionsEnum::prefacture, $id, $this->Session->read('Auth.User.id'), ActionsEnum::delete);
                    $this->Flash->success(__('The preinvoice has been saved.'));
                    break;
                case TransportBillTypesEnum::invoice :
                    $this->saveUserAction(SectionsEnum::facture, $id, $this->Session->read('Auth.User.id'), ActionsEnum::delete);
                    $this->Flash->success(__('The invoice has been saved.'));
                    break;


            }
            if ($type == TransportBillTypesEnum::credit_note ){
                if($this->TransportBill->exists($current['TransportBill']['invoice_id'])){
                    /*$this->SaveTransportBills = $this->Components->load('SaveTransportBills');
                    $this->SaveTransportBills->updateRelatedInvoiceAmountRemaining($current);*/
                }
            }

            $this->Flash->success(__('The transport bill has been deleted.'));
        } else {
            $this->Flash->error(__('The transport bill could not be deleted. Please, try again.'));
        }

        if(isset($this->params['pass']['2']) && $this->params['pass']['2']=='TransportBillDetailRides'){
            $this->redirect(array('controller'=>'TransportBillDetailRides','action' => 'index'));
        }else {
            $this->redirect(array('action' => 'index', $type));
        }

    }

    private function verifyDependences($id, $type = null,$ajax = false)
    {
        $this->setTimeActif();
        if ($type == TransportBillTypesEnum::quote_request ||
            $type == TransportBillTypesEnum::quote || $type == TransportBillTypesEnum::pre_invoice
        ) {
            $transportBill = $this->TransportBill->find('first', array(
                'conditions' => array('TransportBill.id' => $id),
                'fields' => array('TransportBill.status'),
                'recursive' => -1
            ));
            if ($transportBill['TransportBill']['status'] == 2) {
                $this->Flash->error(__('The bill could not be deleted. This bill is already transformed.'));
                if ($ajax){
                    return false;
                }else{
                    $this->redirect(array('action' => 'index', $type));
                }
            }
        }
        $transportBillDetailRides = $this->TransportBillDetailRides->find('all', array(
            "conditions" => array(
                "TransportBillDetailRides.transport_bill_id  =" => $id,
                'TransportBillDetailRides.status_id' => array(2, 3)
            )
        ));
        if (!empty($transportBillDetailRides)) {
            $this->Flash->error(__('The bill could not be deleted. Please remove dependencies in advance.'));
            if ($ajax){
                return false;
            }else{
                $this->redirect(array('action' => 'index', $type));
            }
        } else {
            $transportBillDetailRides = $this->TransportBillDetailRides->find('all', array(
                "conditions" => array(
                    "TransportBillDetailRides.transport_bill_id  =" => $id,
                    'TransportBillDetailRides.status_id' => array(4)
                )
            ));
            if (!empty($transportBillDetailRides)) {
                foreach ($transportBillDetailRides as $transportBillDetailRide) {
                    $sheet_ride_detail_ride_id = $transportBillDetailRide['TransportBillDetailRides']['sheet_ride_detail_ride_id'];
                    $status = 3;
                    $transportBillDetailRideId = $transportBillDetailRide['TransportBillDetailRides']['id'];
                    $this->TransportBillDetailRides->id = $transportBillDetailRideId;
                    $this->TransportBillDetailRides->delete();
                    $this->SheetRideDetailRides->updateStatusSheetRideDetailRide($sheet_ride_detail_ride_id, $status);
                }
            } else {


                $transportBillDetailRides = $this->TransportBillDetailRides->find('all', array(
                    "conditions" => array(
                        "TransportBillDetailRides.transport_bill_id  =" => $id,
                        'TransportBillDetailRides.status_id' => array(7)
                    )
                ));
                if (!empty($transportBillDetailRides)) {
                    $transformations = $this->Transformation->find('all',
                        array(
                            'recursive' => -1,
                            'conditions' => array('Transformation.new_transport_bill_id' => $id),
                            'fields' => array(
                                'Transformation.origin_transport_bill_id',
                                'Transformation.new_transport_bill_id'
                            )
                        )
                    );
                    if (!empty($transformations)) {
                        foreach ($transformations as $transformation) {
                            $originTransportBillId = $transformation['Transformation']['origin_transport_bill_id'];
                            $this->Transformation->deleteAll(array('Transformation.origin_transport_bill_id' => $originTransportBillId),
                                false);
                            $this->TransportBill->id = $originTransportBillId;
                            $this->TransportBill->saveField('status', 1);
                        }
                    }

                    $this->TransportBill->id = $id;
                    foreach ($transportBillDetailRides as $transportBillDetailRide) {
                        $sheet_ride_detail_ride_id = $transportBillDetailRide['TransportBillDetailRides']['sheet_ride_detail_ride_id'];
                        $transportBill = $this->TransportBill->getTransportBillById($id);
                        if($transportBill['TransportBill']['order_type']==1){
                            $status = 3;
                        }else {
                            $status = 5;
                        }



                        $transportBillDetailRideId = $transportBillDetailRide['TransportBillDetailRides']['id'];
                        $this->TransportBillDetailRides->id = $transportBillDetailRideId;
                        $this->TransportBillDetailRides->delete();
                        if ($sheet_ride_detail_ride_id != null) {
                            $this->SheetRideDetailRides->updateStatusSheetRideDetailRide($sheet_ride_detail_ride_id, $status);
                        }
                    }
                } else {


                    $transportBillDetailRides = $this->TransportBillDetailRides->find('all', array(
                        "conditions" => array(
                            "TransportBillDetailRides.transport_bill_id  =" => $id,
                            'TransportBillDetailRides.status_id' => array(10)
                        )
                    ));
                    if (!empty($transportBillDetailRides)) {


                        $this->TransportBill->id = $id;
                        foreach ($transportBillDetailRides as $transportBillDetailRide) {
                            $sheet_ride_detail_ride_id = $transportBillDetailRide['TransportBillDetailRides']['sheet_ride_detail_ride_id'];

                            $transportBillDetailRideId = $transportBillDetailRide['TransportBillDetailRides']['id'];
                            $this->TransportBillDetailRides->id = $transportBillDetailRideId;
                            $this->TransportBillDetailRides->delete();
                            $status = StatusEnum::mission_invoiced;
                            if ($sheet_ride_detail_ride_id != null) {

                                $this->SheetRideDetailRides->updateStatusSheetRideDetailRide($sheet_ride_detail_ride_id, $status);
                            }
                        }
                    }
                   else  {
                    $transportBillDetailRides = $this->TransportBillDetailRides->find('all',
                        array('recursive' => -1,
                            "conditions" => array("TransportBillDetailRides.transport_bill_id  =" => $id)));
                    if (!empty($transportBillDetailRides)) {
                        foreach ($transportBillDetailRides as $transportBillDetailRide) {
                            $transportBillDetailRideIds[] = $transportBillDetailRide['TransportBillDetailRides']['id'];
                        }
                        if (isset($transportBillDetailRideIds) && !empty($transportBillDetailRideIds)) {
                            $this->Observation->deleteAll(array('Observation.transport_bill_detail_ride_id' => $transportBillDetailRideIds),
                                false);
                        }

                        $transformations = $this->Transformation->find('all',
                            array(
                                'recursive' => -1,
                                'conditions' => array('Transformation.new_transport_bill_id' => $id),
                                'fields' => array('Transformation.origin_transport_bill_id')
                            ));
                        if (!empty($transformations)) {
                            foreach ($transformations as $transformation) {
                                $originTransportBillId = $transformation['Transformation']['origin_transport_bill_id'];
                                $this->Transformation->deleteAll(array('Transformation.origin_transport_bill_id' => $originTransportBillId),
                                    false);
                                $this->TransportBill->id = $originTransportBillId;
                                $this->TransportBill->saveField('status', 1);
                            }
                        }
                        $this->TransportBill->id = $id;
                        $this->TransportBillDetailRides->deleteAll(array('TransportBillDetailRides.transport_bill_id' => $id),
                            false);
                    }


                }


                }
                $this->Notification->deleteAll(array('Notification.transport_bill_id' => $id),
                    false);
            }
        }

        $this->TransportBillPenalty->deletePenaltiesByTransportBillId($id);
        return true;
    }


    public function deleteTransportBills($type = null)
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $user_id = $this->Auth->user('id');
        $id = filter_input(INPUT_POST, "id");
        $this->DeleteTransportBillsManagement = $this->Components->load('DeleteTransportBillsManagement');
        if ($type == TransportBillTypesEnum::quote_request) {
            $this->verifyUserPermission(SectionsEnum::demande_de_devis, $user_id, ActionsEnum::delete, "TransportBills",
                $id, "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::quote) {
            $this->verifyUserPermission(SectionsEnum::devis, $user_id, ActionsEnum::delete, "TransportBills", $id,
                "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::order) {
            $this->verifyUserPermission(SectionsEnum::commande_client, $user_id, ActionsEnum::delete, "TransportBills",
                $id, "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::pre_invoice) {
            $this->verifyUserPermission(SectionsEnum::prefacture, $user_id, ActionsEnum::delete, "TransportBills", $id,
                "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::invoice) {
            $this->verifyUserPermission(SectionsEnum::facture, $user_id, ActionsEnum::delete, "TransportBills", $id,
                "TransportBill", $type);
        }
        $this->TransportBill->id = $id;
        $current = $this->TransportBill->find("first", array("conditions" => array("TransportBill.id" => $id)));
        $response = $this->verifyDependences($id, $type,true);
        if (!$response){
            echo json_encode(array("response" => "false"));
            exit;
        }
        //$this->request->allowMethod('post', 'delete');


        if ($this->TransportBill->delete()) {
            switch ($type) {
                case TransportBillTypesEnum:: quote_request:
                    $this->saveUserAction(SectionsEnum::demande_de_devis, $id, $this->Session->read('Auth.User.id'), ActionsEnum::delete);
                    $this->Flash->success(__('The quotation has been deleted.'));
                    break;
                case TransportBillTypesEnum:: quote:
                    $this->saveUserAction(SectionsEnum::devis, $id, $this->Session->read('Auth.User.id'), ActionsEnum::delete);
                    $this->Flash->success(__('The quotation has been deleted.'));
                    break;
                case TransportBillTypesEnum::order :
                    $this->saveUserAction(SectionsEnum::commande_client, $id, $this->Session->read('Auth.User.id'), ActionsEnum::delete);
                    $this->Flash->success(__('The customer order has been deleted.'));
                    break;
                case TransportBillTypesEnum::pre_invoice :
                    $this->saveUserAction(SectionsEnum::prefacture, $id, $this->Session->read('Auth.User.id'), ActionsEnum::delete);
                    $this->Flash->success(__('The preinvoice has been deleted.'));
                    break;
                case TransportBillTypesEnum::invoice :
                    $this->saveUserAction(SectionsEnum::facture, $id, $this->Session->read('Auth.User.id'), ActionsEnum::delete);
                    $this->Flash->success(__('The invoice has been deleted.'));
                    break;

            }
            if ($type == TransportBillTypesEnum::credit_note ){
                if($this->TransportBill->exists($current['TransportBill']['invoice_id'])){
                    /*$this->SaveTransportBills = $this->Components->load('SaveTransportBills');
                    $this->SaveTransportBills->updateRelatedInvoiceAmountRemaining($current);*/
                }
            }
            if ($type == TransportBillTypesEnum::credit_note ||
                $type == TransportBillTypesEnum::invoice){
                $this->DeleteTransportBillsManagement->updateSheetRideDetailRideStatusId($id,$type);
            }
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }
    }

    function export()
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }

        $this->setTimeActif();
        $TransportBills = $this->TransportBill->find('all', array(
            'order' => 'TransportBill.name asc',
            'recursive' => 2
        ));
        $this->set('models', $TransportBills);
    }

    function getInformationMarchandise($marchandise_id = null, $ride_id = null, $num = null)
    {

        $this->setTimeActif();
        $this->layout = 'ajax';
        $this->loadModel('Price');
        $price = $this->Price->find('first', array(
            'conditions' => array(
                'Price.marchandise_id' => $marchandise_id,
                'Price.detail_ride_id' => $ride_id
            )
        ));


        if (!empty($price)) {
            $quantity_min = $price['Price']['quantity_min'];
            $price_ht = $price['Price']['price_ht'];
            $this->set('quantity_min', $quantity_min);
            $this->set('price_ht', $price_ht);
        }
        $this->set('num', $num);
    }

    function print_facture($id = null, $type = null)
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        $this->set('type', $type);
        $facture = $this->TransportBill->find('first', array(
            'conditions' => array('TransportBill.id' => $id),
            'recursive' => -1,
            'fields' => array(
                'TransportBill.reference',
                'TransportBill.date',
                'TransportBill.payment_method',
                'TransportBill.total_ht',
                'TransportBill.ristourne_val',
                'TransportBill.ristourne_percentage',
                'TransportBill.total_tva',
                'TransportBill.total_ttc',
                'TransportBill.stamp',
                'TransportBill.with_penalty',
                'TransportBill.invoice_id',
                'TransportBill.credit_note_type',
                'TransportBill.amount_remaining',
                'TransportBill.has_credit_note',
                'Supplier.name',
                'Supplier.adress',
                'Supplier.code',
                'Supplier.ai',
                'Supplier.if',
                'Supplier.rc'
            ),
            'joins' => array(
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('TransportBill.supplier_id = Supplier.id')
                ),
            )
        ));
        $this->set('facture', $facture);
        if($type == TransportBillTypesEnum::credit_note){
            $invoice = $this->TransportBill->getTransportBillById($facture['TransportBill']['invoice_id']);

            $this->set('invoice',$invoice);
        }
        $rides = $this->TransportBillDetailRides->find('all', array(
            'conditions' => array('TransportBillDetailRides.transport_bill_id' => $id),
            'recursive' => -1,
            'order' => 'TransportBillDetailRides.programming_date asc',
            'Group' => 'TransportBillDetailRides.id',
            'fields' => array(
                'TransportBillDetailRides.id',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'CarType.name',
                'Departure.name',
                'Arrival.name',
                'Type.name',
                'Product.name',
                'Product.id',
                'Product.code',
                'TransportBillDetailRides.designation',
                'TransportBillDetailRides.description',
                'TransportBillDetailRides.unit_price',
                'TransportBillDetailRides.type_ride',
                'TransportBillDetailRides.price_ht',
                'TransportBillDetailRides.price_ttc',
                'TransportBillDetailRides.nb_trucks',
                'TransportBillDetailRides.ristourne_%',
                'TransportBillDetailRides.ristourne_val',
                'TransportBillDetailRides.delivery_with_return',
                'TransportBillDetailRides.programming_date',
                'TransportBillDetailRides.designation',
                'TransportBillDetailRides.marchandise_unit_id',
                'MarchandiseUnits.name',
                'SheetRideDetailRides.real_start_date',
                'SheetRideDetailRides.real_end_date',
                'SheetRideDetailRides.real_end_date',
                'Tva.name'
            ),
            'joins' => array(
                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('TransportBillDetailRides.transport_bill_id = TransportBill.id')
                ),
                array(
                    'table' => 'sheet_ride_detail_rides',
                    'type' => 'left',
                    'alias' => 'SheetRideDetailRides',
                    'conditions' => array('TransportBillDetailRides.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
                ),
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('TransportBillDetailRides.detail_ride_id = DetailRide.id')
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
                array(
                    'table' => 'tva',
                    'type' => 'left',
                    'alias' => 'Tva',
                    'conditions' => array('TransportBillDetailRides.tva_id = Tva.id')
                ),
                array(
                    'table' => 'marchandise_units',
                    'type' => 'left',
                    'alias' => 'MarchandiseUnits',
                    'conditions' => array('TransportBillDetailRides.marchandise_unit_id = MarchandiseUnits.id')
                ),
            )
        ));
        $this->set('rides', $rides);
        $rideIds = array();
        $rideFactors = array();
        $missionFactors= array();
        foreach ($rides as $ride){
            $rideIds[] = $ride['TransportBillDetailRides']['id'];
            $transportBillDetailRideFactors = $this->TransportBillDetailRideFactor->find('all',
                array('conditions'=>array('TransportBillDetailRideFactor.transport_bill_detail_ride_id'=>$ride['TransportBillDetailRides']['id']),
                    'recursive'=>-1,
                    'fields'=>array(
                        'TransportBillDetailRideFactor.factor_value',
                        'TransportBillDetailRideFactor.factor_id',
                    ),

                )
            );
            foreach ($transportBillDetailRideFactors as $transportBillDetailRideFactor){
                $missionFactors[$transportBillDetailRideFactor['TransportBillDetailRideFactor']['factor_id']]=
                    $transportBillDetailRideFactor['TransportBillDetailRideFactor']['factor_value'];
            }
            $rideFactors[$ride['TransportBillDetailRides']['id']] = $missionFactors;
            $missionFactors= array();
        }
        $this->set('rideFactors',$rideFactors);
        $factors = $this->TransportBillDetailRideFactor->find('all',
            array('conditions'=>array('TransportBillDetailRideFactor.transport_bill_detail_ride_id'=>$rideIds,
                ),
                'recursive'=>-1,
                'order'=>array('TransportBillDetailRideFactor.transport_bill_detail_ride_id ASC'),
                'fields'=>array(
                        'DISTINCT Factor.id',
                    'Factor.name',
                ),
                'joins'=>array(
                    array(
                        'table' => 'factors',
                        'type' => 'left',
                        'alias' => 'Factor',
                        'conditions' => array('TransportBillDetailRideFactor.factor_id = Factor.id')
                    ),
                )
            )
        );
        $this->set('factors', $factors);
        $company = $this->Company->find('first');
        $wilayaId = $company['Company']['wilaya'];
        if(!empty($wilayaId)){
            $destination = $this->Destination->find('first', array('conditions' => array('Destination.id' => $wilayaId)));
            $wilayaName = $destination['Destination']['name'];
        }else {
            $wilayaName ='';
        }
        $commercialDocumentModel = $this->Parameter->getCodesParameterVal('commercial_document_model');
        $this->set(compact('company', 'wilayaName','commercialDocumentModel'));
        $entete_pdf = $this->Parameter->getCodesParameterVal('entete_pdf');
        $this->set('entete_pdf', $entete_pdf);
        $penalties =array();
        if($facture['TransportBill']['with_penalty']==1
            && $type== TransportBillTypesEnum::invoice){
            $penalties = $this->TransportBillPenalty->getPenaltiesByTransportBillId($id);
            if(!empty($penalties)){
                $penaltyAmounts = $this->TransportBillPenalty->find('all', array(
                    'recursive' => -1,
                    'conditions' => array('TransportBillPenalty.transport_bill_id' => $id),
                    'fields' => array(
                        'sum(TransportBillPenalty.penalty_amount) as total_penalty_amount'
                    ),
                ));
                $totalPenaltyAmount = $penaltyAmounts[0][0]['total_penalty_amount'];
                $this->set('totalPenaltyAmount', $totalPenaltyAmount);
            }
        }
        $this->set('penalties', $penalties);

    }

    function printInvoiceWithPayment($id = null, $type = null)
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        $this->set('type', $type);
        $invoice = $this->TransportBill->find('first', array(
            'conditions' => array('TransportBill.id' => $id),
            'recursive' => -1,
            'fields' => array(
                'TransportBill.id',
                'TransportBill.reference',
                'TransportBill.date',
                'TransportBill.payment_method',
                'TransportBill.total_ht',
                'TransportBill.ristourne_val',
                'TransportBill.ristourne_percentage',
                'TransportBill.total_tva',
                'TransportBill.total_ttc',
                'TransportBill.amount_remaining',
                'TransportBill.stamp',
                'TransportBill.with_penalty',
                'TransportBill.invoice_id',
                'TransportBill.credit_note_type',
                'TransportBill.has_credit_note',
                'Supplier.name',
                'Supplier.adress',
                'Supplier.code',
                'Supplier.ai',
                'Supplier.if',
                'Supplier.rc'
            ),
            'joins' => array(
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('TransportBill.supplier_id = Supplier.id')
                ),
            )
        ));
        $this->set('invoice', $invoice);
        $rides = $this->TransportBillDetailRides->getTransportBillDetailRidesByTransportBillId($id);

        $this->set('rides', $rides);
        $paymentParts = $this->Payment->getPaymentPartsByTransportBillIds($id);
        $this->set('paymentParts', $paymentParts);
        $company = $this->Company->find('first');
        $wilayaId = $company['Company']['wilaya'];
        if(!empty($wilayaId)){
            $destination = $this->Destination->find('first', array('conditions' => array('Destination.id' => $wilayaId)));
            $wilayaName = $destination['Destination']['name'];
        }else {
            $wilayaName ='';
        }
        $creditNote = array();
        if ($invoice['TransportBill']['has_credit_note'] == 1){
            $creditNote = $this->TransportBill->find('first',array(
                'conditions' => array(
                    'TransportBill.invoice_id' => $id
                )
            ));
        }
        $commercialDocumentModel = $this->Parameter->getCodesParameterVal('commercial_document_model');
        $this->set(compact('company', 'wilayaName','commercialDocumentModel','creditNote'));
        $entete_pdf = $this->Parameter->getCodesParameterVal('entete_pdf');
        $this->set('entete_pdf', $entete_pdf);


    }


    function print_detailed_facture($id = null, $type = null)
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();

        ini_set('memory_limit', '512M');
        $this->set('type', $type);
        $facture = $this->TransportBill->find('first', array(
            'conditions' => array('TransportBill.id' => $id),
            'recursive' => -1,
            'fields' => array(
                'TransportBill.reference',
                'TransportBill.date',
                'TransportBill.payment_method',
                'TransportBill.total_ht',
                'TransportBill.ristourne_val',
                'TransportBill.stamp',
                'TransportBill.total_tva',
                'TransportBill.total_ttc',
                'Supplier.name',
                'Supplier.adress',
                'Supplier.code',
                'Supplier.ai',
                'Supplier.if',
                'Supplier.rc'
            ),
            'joins' => array(
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('TransportBill.supplier_id = Supplier.id')
                ),
            )
        ));


        $this->set('facture', $facture);


        $rides = $this->TransportBillDetailRides->find('all', array(
            'conditions' => array('TransportBillDetailRides.transport_bill_id' => $id),
            'recursive' => -1,
            'Group' => 'TransportBillDetailRides.id',
            'fields' => array(
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'CarType.name',
                'Departure.name',
                'Arrival.name',
                'Type.name',
                'Product.name',
                'Product.id',
                'Product.code',
                'Product.description',
                'TransportBillDetailRides.designation',
                'TransportBillDetailRides.description',
                'TransportBillDetailRides.unit_price',
                'TransportBillDetailRides.type_ride',
                'TransportBillDetailRides.price_ht',
                'TransportBillDetailRides.price_ttc',
                'TransportBillDetailRides.nb_trucks',
                'TransportBillDetailRides.ristourne_%',
                'TransportBillDetailRides.ristourne_val',
                'SheetRideDetailRides.real_start_date',
                'SheetRideDetailRides.real_end_date',
                'Tva.name',
            ),
            'joins' => array(
                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('TransportBillDetailRides.transport_bill_id = TransportBill.id')
                ),
                array(
                    'table' => 'sheet_ride_detail_rides',
                    'type' => 'left',
                    'alias' => 'SheetRideDetailRides',
                    'conditions' => array('TransportBillDetailRides.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
                ),
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('TransportBillDetailRides.detail_ride_id = DetailRide.id')
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
                ), array(
                    'table' => 'products',
                    'type' => 'left',
                    'alias' => 'Product',
                    'conditions' => array('Lot.product_id = Product.id')
                ),
                array(
                    'table' => 'tva',
                    'type' => 'left',
                    'alias' => 'Tva',
                    'conditions' => array('TransportBillDetailRides.tva_id = Tva.id')
                ),
            )
        ));

        $this->set('rides', $rides);
        $company = $this->Company->find('first');

        $this->set('company', $company);
        $entete_pdf = $this->Parameter->getCodesParameterVal('entete_pdf');
        $this->set('entete_pdf', $entete_pdf);

    }








    function addRideTransportBill($num = null, $type = null)
    {
        $this->setTimeActif();
        $this->layout = 'popup';
        $this->set('saved', false);

        if (!empty($this->request->data['TransportBillDetailRides'][$num]['detail_ride_id']) && !empty($this->request->data['TransportBillDetailRides'][$num]['unit_price'])
            && !empty($this->request->data['TransportBillDetailRides'][$num]['price_ht']) && !empty($this->request->data['TransportBillDetailRides'][$num]['tva_id'])
            && !empty($this->request->data['TransportBillDetailRides'][$num]['price_ttc']) && !empty($this->request->data['TransportBillDetailRides'][$num]['nb_trucks'])
        ) {
            $this->set('saved', true); //only set true if data saves OK
            $this->set('TransportBillDetailRides', $this->request->data['TransportBillDetailRides']);
        }
        $this->TransportBill->DetailRide->virtualFields = array('cnames' => "CONCAT(DepartureDestination.name, ' - ', ArrivalDestination.name, ' - ',CarType.name)");
        $detailRides = $this->TransportBill->DetailRide->find('list', array(
            'order' => 'DetailRide.wording ASC',
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

        $this->set('num', $num);
        $this->set('type', $type);
        $this->set('detailRides', $detailRides);
        $rideCategories = $this->TransportBill->RideCategory->find('list');
        $this->set('rideCategories', $rideCategories);
        $tvas = $this->Tva->getTvas();
        $this->set('tvas', $tvas);
        $useRideCategory = $this->useRideCategory();
        $this->set('useRideCategory', $useRideCategory);

    }

    function getRide($TransportBillDetailRides, $num, $mode)
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        $TransportBillDetailRides = unserialize(base64_decode($TransportBillDetailRides));


        $this->set('TransportBillDetailRides', $TransportBillDetailRides);
        $this->set('num', $num);
        $this->set('mode', $mode);
        $this->TransportBill->DetailRide->virtualFields = array('cnames' => "CONCAT(DepartureDestination.name, ' - ', ArrivalDestination.name, ' - ',CarType.name)");
        $detailRides = $this->TransportBill->DetailRide->find('list', array(
            'order' => 'DetailRide.wording ASC',
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
        $this->set('detailRides', $detailRides);
        $rideCategories = $this->RideCategory->getRideCategories();
        $this->set('rideCategories', $rideCategories);
        $tvas = $this->Tva->getTvas();
        $this->set('tvas', $tvas);
        $useRideCategory = $this->useRideCategory();
        $this->set('useRideCategory', $useRideCategory);
    }

    function editRideTransportBill($transportBillDetailRides = null, $num = null)
    {
        $this->setTimeActif();
        $this->layout = 'popup';
        $this->set('saved', false);
        $transportBillDetailRides = unserialize(base64_decode($transportBillDetailRides));

        $this->set('transportBillDetailRides', $transportBillDetailRides);
        //$rides = $this->SheetRide->DetailRide->find('list');

        if (!empty($this->request->data)) {
            $this->set('saved', true); //only set true if data saves OK
            $transportBillDetailRides = $this->request->data['TransportBillDetailRides'];

            $this->set('transportBillDetailRides', $transportBillDetailRides);
        }
        $this->TransportBill->DetailRide->virtualFields = array('cnames' => "CONCAT(DepartureDestination.name, ' - ', ArrivalDestination.name, ' - ',CarType.name)");

        $detailRides = $this->TransportBill->DetailRide->find('list', array(
            'order' => 'DetailRide.wording ASC',
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

        $this->set('num', $num);

        $this->set('detailRides', $detailRides);

        $tvas = $this->Tva->getTvas();
        $this->set('tvas', $tvas);
        $rideCategories = $this->RideCategory->getRideCategories();
        $this->set('rideCategories', $rideCategories);
        $useRideCategory = $this->useRideCategory();
        $this->set('useRideCategory', $useRideCategory);

    }

    /**
     * Transform quotation request to quote and quote to order
     * @param array|null $ids
     *
     * @return void
     */
    public function transformFromQuotationRequestToOrder($ids = null)
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $destinationType = $this->params['pass']['1'];
        $OriginType = $this->params['pass']['2'];
        $this->TransportBill->validate = $this->TransportBill->validate_transform;
        $arrayIds = explode(",", $ids);
        if (!empty($this->request->data)) {
            if ($this->request->data['method_transform'] == 2) {
                foreach ($arrayIds as $id) {
                    $options = array(
                        'conditions' => array(
                            'TransportBill.' . $this->TransportBill->primaryKey => $id,
                            'TransportBill.status' => 1
                        ),
                        'recursive' => -1,
                        'fields' => array(
                            'id',
                            'reference',
                            'date',
                            'type',
                            'total_ht',
                            'total_ttc',
                            'total_tva',
                            'supplier_id',
                            'supplier_final_id',
                            'detail_ride_id',
                            'status',
                            'payment_type',
                            'user_id',
                            'modified_id',
                            'amount_remaining',
                            'status_payment',
                        )
                    );
                    $data1 = $this->TransportBill->find('first', $options);
                    if (!empty($data1['TransportBill'])) {
                        $data['TransportBillDetailRides'] = $this->TransportBillDetailRides->find('all',
                            array(
                                'conditions' => array('TransportBillDetailRides.transport_bill_id' => $id),
                                'recursive' => -1,
                                'fields' => array(
                                    'detail_ride_id',
                                    'departure_destination_id',
                                    'arrival_destination_id',
                                    'car_type_id',
                                    'type_ride',
                                    'type_pricing',
                                    'tonnage_id',
                                    'supplier_final_id',
                                    'transport_bill_id',
                                    'unit_price',
                                    'delivery_with_return',
                                    'programming_date',
                                    'charging_time',
                                    'unloading_date',
                                    'delivery_with_return',
                                    'ride_category_id',
                                    'type_price',
                                    'nb_trucks',
                                    'price_ht',
                                    'price_ttc',
                                    'tva_id',
                                    'lot_id',
                                    'ristourne_%',
                                    'ristourne_val'
                                )
                            ));
                        // pour le bon deroulement de la fonction on etait obligé de faire un foreach 1 fois pour le tableau $data1['TransportBill']
                        $date = date("Y-m-d");
                        if ($this->request->data['date'] != 1) {
                            $date = $data1['TransportBill']['date'];
                        }

                        if ($this->request->data['affectation_client'] == 1) {
                            $supplierId = null;

                        } else {

                            $supplierId = $this->request->data['TransportBill']['supplier_id'];
                        }
                        $transportBillIds = array();
                        $transportBillIds[] = $id;
                        // is a transformation (may be duplication or relance)
                        $transformationCategory = 2;

                        $new_transport_bill_id = $this->add_transport_bill_detail_rides($data1['TransportBill'],
                            $data['TransportBillDetailRides'],
                            $destinationType, $OriginType, $date, $supplierId, $transportBillIds, $transformationCategory);


                        $this->updateStatusTransportBill($data1['TransportBill']);

                               if ($OriginType == TransportBillTypesEnum::quote || $OriginType == TransportBillTypesEnum::quote_request) {
                            /*$profileId = $this->Auth->user('profile_id');
                            $parentId = $this->Profile->getParentProfileByProfileId($profileId);
                            if ($parentId != Null) {
                                $profileId = $parentId;
                            }
                            if ($profileId == ProfilesEnum::client) {
                                $receivers = $this->User->getUsersReceiverClientNotifications();
                            } else {
                                $supplierId = $data1['TransportBill']['supplier_id'];
                                $receivers = $this->User->getUsersReceiverCommercialNotifications($supplierId);
                            }*/
                            $actionId = ActionsEnum::transform;
                            $sectionId = SectionsEnum::transformation;
                            $transportBillId = $id;
                            $userId = $this->Auth->user('id');
                                $this->Notification->addNotification($transportBillId,$userId, $actionId,$sectionId);
                                $this->getNbNotificationsByUser();


                        }

                        if ($destinationType != 2) {
                            $this->redirect(array('action' => 'edit', $destinationType, $new_transport_bill_id));
                        } else {
                            $this->redirect(array('action' => 'index', $destinationType));
                        }
                    } else {
                        $this->Flash->error(__('The bill is already transformed.'));
                        $this->redirect(array('action' => 'index', $OriginType));
                    }
                }
            } else {

                $TransportBills = $this->TransportBill->find('all', array(
                    'conditions' => array(
                        'TransportBill.id' => $arrayIds,
                        'TransportBill.status' => 1
                    ),
                    'recursive' => -1,
                    'fields' => array(
                        'id',
                        'reference',
                        'date',
                        'type',
                        'total_ht',
                        'total_ttc',
                        'total_tva',
                        'supplier_id',
                        'supplier_final_id',
                        'amount_remaining',
                        'status_payment',
                    )
                ));

                if (!empty($TransportBills)) {
                    $data1['TransportBill']['total_ht'] = 0;
                    $data1['TransportBill']['total_ttc'] = 0;
                    $data1['TransportBill']['total_tva'] = 0;
                    $data1['TransportBill']['amount_remaining'] = 0;
                    foreach ($TransportBills as $TransportBill) {
                        $this->updateStatusTransportBill($TransportBill['TransportBill']);
                        $data1['TransportBill']['date'] = $TransportBill['TransportBill']['date'];
                        $data1['TransportBill']['total_ht'] = $data1['TransportBill']['total_ht'] + $TransportBill['TransportBill']['total_ht'];
                        $data1['TransportBill']['total_ttc'] = $data1['TransportBill']['total_ttc'] + $TransportBill['TransportBill']['total_ttc'];
                        $data1['TransportBill']['total_tva'] = $data1['TransportBill']['total_tva'] + $TransportBill['TransportBill']['total_tva'];
                        $data1['TransportBill']['amount_remaining'] = $data1['TransportBill']['amount_remaining'] + $TransportBill['TransportBill']['amount_remaining'];
                        $data1['TransportBill']['supplier_id'] = $TransportBill['TransportBill']['supplier_id'];
                        $data1['TransportBill']['supplier_final_id'] = $TransportBill['TransportBill']['supplier_final_id'];
                    }
                    if ($data1['TransportBill']['amount_remaining'] > 0) {
                        if ($data1['TransportBill']['amount_remaining'] == $data1['TransportBill']['total_ttc']) {
                            $payed = 1;
                        } else {
                            $payed = 3;
                        }
                    } else {
                        $payed = 2;
                    }
                    $data1['TransportBill']['status_payment'] = $payed;
                     $data['TransportBillDetailRides'] = $this->TransportBillDetailRides->find('all',
                        array(
                            'conditions' =>
                                array(
                                    'TransportBillDetailRides.transport_bill_id' => $arrayIds,
                                ),
                            'recursive' => -1,
                            'fields' =>
                                array(
                                    'detail_ride_id',
                                    'departure_destination_id',
                                    'arrival_destination_id',
                                    'car_type_id',
                                    'type_ride',
                                    'type_pricing',
                                    'tonnage_id',
                                    'supplier_final_id',
                                    'transport_bill_id',
                                    'unit_price',
                                    'delivery_with_return',
                                    'programming_date',
                                    'charging_time',
                                    'unloading_date',
                                    'ride_category_id',
                                    'type_price',
                                    'nb_trucks',
                                    'price_ht',
                                    'price_ttc',
                                    'tva_id',
                                    'lot_id',
                                    'ristourne_%',
                                    'ristourne_val'
                                )
                        )
                    );

                    // on recupère la date sans faire un foreach sur le tableau $data1['TransportBill']
                    if ($this->request->data['date'] == 1) {
                        $date = date("Y-m-d");
                    } else {
                        $date = $data1['TransportBill']['date'];
                    }

                    if ($this->request->data['affectation_client'] == 1) {
                        $supplierId = null;
                    } else {
                        $supplierId = $this->request->data['TransportBill']['supplier_id'];
                    }
                    $transportBillIds = $arrayIds;
                    $transformationCategory = 2;
                    $new_transport_bill_id = $this->add_transport_bill_detail_rides($data1['TransportBill'],
                        $data['TransportBillDetailRides'], $destinationType, $OriginType, $date, $supplierId,
                        $transportBillIds, $transformationCategory);


                    if ($OriginType == TransportBillTypesEnum::quote || $OriginType == TransportBillTypesEnum::quote_request) {


                            $actionId = ActionsEnum::transform;
                            $sectionId = SectionsEnum::transformation;
                            $userId = $this->Auth->user('id');

                                foreach ($arrayIds as $array_id) {
                                    $this->Notification->addNotification($array_id, $userId,$actionId,$sectionId);
                                    $this->getNbNotificationsByUser();
                                }




                    }
                    if ($destinationType != 2) {
                        $this->redirect(array('action' => 'edit', $destinationType, $new_transport_bill_id));
                    } else {
                        $this->redirect(array('action' => 'index', $destinationType));
                    }


                } else {
                    $this->Flash->error(__('The bill is already transformed.'));
                    $this->redirect(array('action' => 'index', $OriginType));
                }
            }
        }

        $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
        $this->set(compact('suppliers', 'arrayIds'));
    }
    public function transformFromOrderToInvoice($ids = null)
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $destinationType = $this->params['pass']['1'];
        $OriginType = $this->params['pass']['2'];
        $this->TransportBill->validate = $this->TransportBill->validate_transform;
        $arrayIds = explode(",", $ids);
        if (!empty($this->request->data)) {
            if ($this->request->data['method_transform'] == 2) {
                foreach ($arrayIds as $id) {
                    $options = array(
                        'conditions' => array(
                            'TransportBill.' . $this->TransportBill->primaryKey => $id,
                            'TransportBill.status_transform' => 1,
                            //'TransportBill.status' => TransportBillDetailRideStatusesEnum::validated,
                        ),
                        'recursive' => -1,
                        'fields' => array(
                            'id',
                            'reference',
                            'date',
                            'type',
                            'total_ht',
                            'total_ttc',
                            'total_tva',
                            'supplier_id',
                            'supplier_final_id',
                            'detail_ride_id',
                            'status',
                            'payment_type',
                            'amount_remaining',
                            'status_payment',
                            'user_id',
                            'modified_id'
                        )
                    );
                    $data1 = $this->TransportBill->find('first', $options);
                    if (!empty($data1['TransportBill'])) {
                        $data['TransportBillDetailRides'] = $this->TransportBillDetailRides->find('all',
                            array(
                                'conditions' => array(
                                        'TransportBillDetailRides.transport_bill_id' => $id,
                                           'ProductType.relation_with_park'=>1

                                    ),
                                'recursive' => -1,
                                'fields' => array(
                                    'TransportBillDetailRides.id',
                                    'detail_ride_id',
                                    'departure_destination_id',
                                    'arrival_destination_id',
                                    'car_type_id',
                                    'type_ride',
                                    'type_pricing',
                                    'tonnage_id',
                                    'supplier_final_id',
                                    'transport_bill_id',
                                    'unit_price',
                                    'delivery_with_return',
                                    'programming_date',
                                    'charging_time',
                                    'unloading_date',
                                    'ride_category_id',
                                    'type_price',
                                    'nb_trucks',
                                    'price_ht',
                                    'price_ttc',
                                    'tva_id',
                                    'lot_id',
                                    'ristourne_%',
                                    'ristourne_val',
                                    'Product.product_type_id'
                                ),
                                'joins'=>array(
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
                                    array(
                                        'table' => 'product_types',
                                        'type' => 'left',
                                        'alias' => 'ProductType',
                                        'conditions' => array('Product.product_type_id = ProductType.id')
                                    ),

                                )
                            ));
                        $rides = $data['TransportBillDetailRides'];
                        $rideIds = array();
                        $rideFactors = array();
                        $missionFactors= array();
                        foreach ($rides as $ride){
                            $rideIds[] = $ride['TransportBillDetailRides']['id'];
                            $transportBillDetailRideFactors = $this->TransportBillDetailRideFactor->find('all',
                                array('conditions'=>array('TransportBillDetailRideFactor.transport_bill_detail_ride_id'=>$ride['TransportBillDetailRides']['id']),
                                    'recursive'=>-1,
                                    'fields'=>array(
                                        'TransportBillDetailRideFactor.factor_value',
                                        'TransportBillDetailRideFactor.factor_id',
                                    ),

                                )
                            );
                            if(!empty($transportBillDetailRideFactors)){
                                $i= 1;
                                foreach ($transportBillDetailRideFactors as $transportBillDetailRideFactor){
                                    $missionFactors[$transportBillDetailRideFactor['TransportBillDetailRideFactor']['factor_id']]= $transportBillDetailRideFactor['TransportBillDetailRideFactor']['factor_value'];
                                    $rideFactors[$ride['TransportBillDetailRides']['id']][$i]['factor_id']= $transportBillDetailRideFactor['TransportBillDetailRideFactor']['factor_id'];
                                    $rideFactors[$ride['TransportBillDetailRides']['id']][$i]['factor_value']= $transportBillDetailRideFactor['TransportBillDetailRideFactor']['factor_value'];
                                $i ++;
                                }
                            }else {
                                $rideFactors[$ride['TransportBillDetailRides']['id']] = array();
                            }

                            //$rideFactors[$ride['TransportBillDetailRides']['id']] = $missionFactors;
                            //$missionFactors= array();

                        }


                        // pour le bon deroulement de la fonction on etait obligé de faire un foreach 1 fois pour le tableau $data1['TransportBill']
                        $date = date("Y-m-d");
                        if ($this->request->data['date'] != 1) {
                            $date = $data1['TransportBill']['date'];
                        }

                        if ($this->request->data['affectation_client'] == 1) {
                            $supplierId = null;

                        } else {

                            $supplierId = $this->request->data['TransportBill']['supplier_id'];
                        }
                        $transportBillIds = array();
                        $transportBillIds[] = $id;
                        // is a transformation (may be duplication or relance)
                        $transformationCategory = 2;

                        $new_transport_bill_id = $this->add_transport_bill_detail_rides(
                                $data1['TransportBill'],
                            $data['TransportBillDetailRides'],
                            $destinationType, $OriginType, $date, $supplierId,
                                $transportBillIds, $transformationCategory,$rideFactors );
                        $this->updateStatusTransportBill($data1['TransportBill'],'status_transform');

                               if ($OriginType == TransportBillTypesEnum::quote || $OriginType == TransportBillTypesEnum::quote_request) {

                            $actionId = ActionsEnum::transform;
                            $sectionId = SectionsEnum::transformation;
                            $transportBillId = $id;
                            $userId = $this->Auth->user('id');
                            $this->Notification->addNotification($transportBillId,$userId, $actionId , $sectionId);
                                   $this->getNbNotificationsByUser();
                        }

                        if ($destinationType != 2) {
                            $this->redirect(array('action' => 'edit', $destinationType, $new_transport_bill_id));
                        } else {
                            $this->redirect(array('action' => 'index', $destinationType));
                        }
                    } else {
                        $this->Flash->error(__('The bill is already transformed.'));
                        $this->redirect(array('action' => 'index', $OriginType));
                    }
                }
            } else {

                $TransportBills = $this->TransportBill->find('all', array(
                    'conditions' => array(
                        'TransportBill.id' => $arrayIds,
                        'TransportBill.status_transform' => 1,
                        //'TransportBill.status' => TransportBillDetailRideStatusesEnum::validated,
                    ),
                    'recursive' => -1,
                    'fields' => array(
                        'id',
                        'reference',
                        'date',
                        'type',
                        'total_ht',
                        'total_ttc',
                        'total_tva',
                        'supplier_id',
                        'supplier_final_id',
                        'amount_remaining',
                        'status_payment',
                    )
                ));

                if (!empty($TransportBills)) {
                    $data1['TransportBill']['total_ht'] = 0;
                    $data1['TransportBill']['total_ttc'] = 0;
                    $data1['TransportBill']['total_tva'] = 0;
                    foreach ($TransportBills as $TransportBill) {
                        $this->updateStatusTransportBill($TransportBill['TransportBill'],'status_transform');
                        $data1['TransportBill']['date'] = $TransportBill['TransportBill']['date'];
                        $data1['TransportBill']['total_ht'] = $data1['TransportBill']['total_ht'] + $TransportBill['TransportBill']['total_ht'];
                        $data1['TransportBill']['total_ttc'] = $data1['TransportBill']['total_ttc'] + $TransportBill['TransportBill']['total_ttc'];
                        $data1['TransportBill']['total_tva'] = $data1['TransportBill']['total_tva'] + $TransportBill['TransportBill']['total_tva'];
                        $data1['TransportBill']['supplier_id'] = $TransportBill['TransportBill']['supplier_id'];
                        $data1['TransportBill']['supplier_final_id'] = $TransportBill['TransportBill']['supplier_final_id'];
                        $data1['TransportBill']['amount_remaining'] = $TransportBill['TransportBill']['supplier_final_id'];
                        $data1['TransportBill']['amount_remaining'] = $data1['TransportBill']['amount_remaining'] + $TransportBill['TransportBill']['amount_remaining'];

                    }
                    $data1['TransportBill']['status_payment'] = 1;
                    $data['TransportBillDetailRides'] = $this->TransportBillDetailRides->find('all',
                        array(
                            'conditions' =>
                                array(
                                    'TransportBillDetailRides.transport_bill_id' => $arrayIds,
                                    'ProductType.relation_with_park '=>1

                                ),
                            'recursive' => -1,
                            'fields' =>
                                array(
                                        'TransportBillDetailRides.id',
                                    'detail_ride_id',
                                    'departure_destination_id',
                                    'arrival_destination_id',
                                    'car_type_id',
                                    'type_ride',
                                    'type_pricing',
                                    'tonnage_id',
                                    'supplier_final_id',
                                    'transport_bill_id',
                                    'unit_price',
                                    'delivery_with_return',
                                    'programming_date',
                                    'charging_time',
                                    'unloading_date',
                                    'ride_category_id',
                                    'type_price',
                                    'nb_trucks',
                                    'price_ht',
                                    'price_ttc',
                                    'tva_id',
                                    'lot_id',
                                    'ristourne_%',
                                    'ristourne_val',
                                    'Product.product_type_id'
                                ),
                            'joins'=>array(
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
                                array(
                                    'table' => 'product_types',
                                    'type' => 'left',
                                    'alias' => 'ProductType',
                                    'conditions' => array('Product.product_type_id = ProductType.id')
                                ),


                            )
                        )
                    );
                    $rides = $data['TransportBillDetailRides'];
                    $rideIds = array();
                    $rideFactors = array();
                    $missionFactors= array();
                    foreach ($rides as $ride){
                        $rideIds[] = $ride['TransportBillDetailRides']['id'];
                        $transportBillDetailRideFactors = $this->TransportBillDetailRideFactor->find('all',
                            array('conditions'=>array('TransportBillDetailRideFactor.transport_bill_detail_ride_id'=>$ride['TransportBillDetailRides']['id']),
                                'recursive'=>-1,
                                'fields'=>array(
                                    'TransportBillDetailRideFactor.factor_value',
                                    'TransportBillDetailRideFactor.factor_id',
                                ),

                            )
                        );
                        if(!empty($transportBillDetailRideFactors)){
                            $i= 1;
                            foreach ($transportBillDetailRideFactors as $transportBillDetailRideFactor){
                                $missionFactors[$transportBillDetailRideFactor['TransportBillDetailRideFactor']['factor_id']]= $transportBillDetailRideFactor['TransportBillDetailRideFactor']['factor_value'];
                                $rideFactors[$ride['TransportBillDetailRides']['id']][$i]['factor_id']= $transportBillDetailRideFactor['TransportBillDetailRideFactor']['factor_id'];
                                $rideFactors[$ride['TransportBillDetailRides']['id']][$i]['factor_value']= $transportBillDetailRideFactor['TransportBillDetailRideFactor']['factor_value'];
                                $i ++;
                            }
                        }else {
                            $rideFactors[$ride['TransportBillDetailRides']['id']] = array();
                        }

                    }

                    // on recupère la date sans faire un foreach sur le tableau $data1['TransportBill']
                    if ($this->request->data['date'] == 1) {
                        $date = date("Y-m-d");
                    } else {
                        $date = $data1['TransportBill']['date'];
                    }

                    if ($this->request->data['affectation_client'] == 1) {
                        $supplierId = null;
                    } else {
                        $supplierId = $this->request->data['TransportBill']['supplier_id'];
                    }
                    $transportBillIds = $arrayIds;
                    $transformationCategory = 2;
                    $new_transport_bill_id = $this->add_transport_bill_detail_rides($data1['TransportBill'],
                        $data['TransportBillDetailRides'], $destinationType, $OriginType, $date, $supplierId,
                        $transportBillIds, $transformationCategory,$rideFactors);

                    if ($OriginType == TransportBillTypesEnum::quote || $OriginType == TransportBillTypesEnum::quote_request) {


                            $actionId = ActionsEnum::transform;
                            $sectionId = SectionsEnum::transformation;
                            $userId = $this->Auth->user('id');
                                foreach ($arrayIds as $array_id) {
                                    $this->Notification->addNotification($array_id,$userId, $actionId,$sectionId );
                                }
                            $this->getNbNotificationsByUser();



                    }
                    if ($destinationType != 2) {
                        $this->redirect(array('action' => 'edit', $destinationType, $new_transport_bill_id));
                    } else {
                        $this->redirect(array('action' => 'index', $destinationType));
                    }


                } else {
                    $this->Flash->error(__('The bill is already transformed.'));
                    $this->redirect(array('action' => 'index', $OriginType));
                }
            }
        }

        $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
        $this->set(compact('suppliers', 'arrayIds'));
    }

	public function updateStatusTransportBill($transportBill = null, $statusInput='status')
    {
        $this->TransportBill->id = $transportBill['id'];
        $this->TransportBill->saveField($statusInput, 2);
    }

    public function transformPreinvoiceToInvoice($ids = null)
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $new_type = $this->params['pass']['1'];
        $origin_type = $this->params['pass']['2'];
        $this->TransportBill->validate = $this->TransportBill->validate_transform;
        $arrayIds = explode(",", $ids);

        if (!empty($this->request->data)) {
            if ($this->request->data['method_transform'] == 2) {
                foreach ($arrayIds as $id) {
                    $options = array(
                        'conditions' => array(
                            'TransportBill.' . $this->TransportBill->primaryKey => $id,
                            'TransportBill.status' => 1,
                            'approved' => 1
                        ),
                        'recursive' => -1,
                        'fields' => array(
                            'id',
                            'reference',
                            'date',
                            'type',
                            'total_ht',
                            'total_ttc',
                            'total_tva',
                            'amount_remaining',
                            'status_payment',
                            'supplier_id',
                            'detail_ride_id',
                            'status',
                            'user_id',
                            'modified_id',
                        ),
                        'joins' => array(
                            array(
                                'table' => 'transport_bill_detail_rides',
                                'type' => 'left',
                                'alias' => 'TransportBillDetailRides',
                                'conditions' => array('TransportBillDetailRides.transport_bill_id = TransportBill.id')
                            )
                        )
                    );
                    $data1 = $this->TransportBill->find('first', $options);

                    if (!empty($data1['TransportBill'])) {
                        $data['TransportBillDetailRides'] = $this->TransportBillDetailRides->find(
                            'all',
                            array(
                                'conditions' => array(
                                    'TransportBillDetailRides.transport_bill_id' => $id,
                                    'approved' => 1
                                ),
                                'recursive' => -1,
                                'fields' => array(
                                    'from_customer_order',
                                    'detail_ride_id',
                                    'designation',
                                    'description',
                                    'car_type_id',
                                    'departure_destination_id',
                                    'arrival_destination_id',
                                    'supplier_final_id',
                                    'transport_bill_id',
                                    'unit_price',
                                    'delivery_with_return',
                                    'programming_date',
                                    'charging_time',
                                    'unloading_date',
                                    'ride_category_id',
                                    'type_price',
                                    'nb_trucks',
                                    'price_ht',
                                    'price_ttc',
                                    'tva_id',
                                    'ristourne_%',
                                    'ristourne_val',
                                    'approved',
                                    'type_ride',
                                    'type_pricing',
                                    'lot_id',
                                    'type_pricing',
                                    'tonnage_id',
                                    'SheetRideDetailRides.id',
                                    'TransportBillDetailRides.sheet_ride_detail_ride_id',
                                    'SheetRideDetailRides.reference'
                                ),
                                'joins' => array(
                                    array(
                                        'table' => 'sheet_ride_detail_rides',
                                        'type' => 'left',
                                        'alias' => 'SheetRideDetailRides',
                                        'conditions' => array('TransportBillDetailRides.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
                                    )
                                )
                            )
                        );
                        $transportBillDetailRides = $data['TransportBillDetailRides'];
                        // pour le bon deroulement de la fonction on etait obligé de faire un foreach 1 fois pour le tableau $data1['TransportBill']
                        $date = date("Y-m-d");
                        if ($this->request->data['date'] != 1) {
                            $date = $data1['TransportBill'][0]['date'];
                        }
                        if ($this->request->data['affectation_client'] == 1) {
                            $supplier_id = null;

                        } else {
                            $supplier_id = $this->request->data['TransportBill']['supplier_id'];
                        }
                        $transport_bill_id_array = array();
                        $transport_bill_id_array[] = $id;
                        $r_t_d = 2;
                        $this->add_transport_bill_detail_rides($data1['TransportBill'],
                            $data['TransportBillDetailRides'],
                            $new_type, $origin_type, $date, $supplier_id, $transport_bill_id_array, $r_t_d);
                        $this->updateStatusTransportBill($data1['TransportBill']);
                        foreach ($transportBillDetailRides as $transportBillDetailRide){
                            $sheetRideDetailRideId = $transportBillDetailRide['TransportBillDetailRides']['sheet_ride_detail_ride_id'];
                            $status = 7;
                            $this->SheetRideDetailRides->updateStatusSheetRideDetailRide($sheetRideDetailRideId, $status);
                        }

                    }
                }
                $this->redirect(array('action' => 'index', $new_type));

            } else {
                $transportBills = $this->TransportBill->find('all',
                    array(
                        'conditions' =>
                            array(
                                'TransportBill.id' => $arrayIds,
                                'TransportBill.status' => 1,
                                'TransportBillDetailRides.approved' => 1
                            ),
                        'recursive' => -1,
                        'fields' => array(
                            'id',
                            'reference',
                            'date',
                            'type',
                            'total_ht',
                            'total_ttc',
                            'total_tva',
                            'amount_remaining',
                            'status_payment',
                            'TransportBillDetailRides.price_ht',
                            'TransportBillDetailRides.price_ttc',
                            'TransportBill.supplier_id',
                            'TransportBill.status',
                        ),
                        'joins' => array(
                            array(
                                'table' => 'transport_bill_detail_rides',
                                'type' => 'left',
                                'alias' => 'TransportBillDetailRides',
                                'conditions' => array('TransportBillDetailRides.transport_bill_id = TransportBill.id')
                            ),
                        )

                    ));

                if (!empty($transportBills)) {
                    $data1['TransportBill']['total_ht'] = 0;
                    $data1['TransportBill']['total_ttc'] = 0;
                    $data1['TransportBill']['total_tva'] = 0;
                    $data1['TransportBill']['amount_remaining'] = 0;
                    foreach ($transportBills as $transportBill) {
                        $data1['TransportBill']['date'] = $transportBill['TransportBill']['date'];
                        $data1['TransportBill']['total_ht'] = $data1['TransportBill']['total_ht'] +
                                                            $transportBill['TransportBillDetailRides']['price_ht'];
                        $data1['TransportBill']['total_ttc'] = $data1['TransportBill']['total_ttc'] +
                                                            $transportBill['TransportBillDetailRides']['price_ttc'];
                        //$data1['TransportBill']['amount_remaining'] = $data1['TransportBill']['amount_remaining'] +
                                                           // $transportBill['TransportBill']['amount_remaining'];
                        $data1['TransportBill']['supplier_id'] = $transportBill['TransportBill']['supplier_id'];
                    }
                    $data1['TransportBill']['total_tva'] = $data1['TransportBill']['total_ttc'] -
                        $transportBill['TransportBill']['total_ht'];
                    $data1['TransportBill']['status_payment']= $this->getStatusPayment($data1['TransportBill']['amount_remaining'],
                        $data1['TransportBill']['total_ttc']);
                    $data['TransportBillDetailRides'] = $this->TransportBillDetailRides->find('all',
                        array(
                            'conditions' => array(
                                'TransportBillDetailRides.transport_bill_id' => $arrayIds,
                                'TransportBill.status' => 1,
                                'TransportBillDetailRides.approved' => 1
                            ),
                            'recursive' => -1,
                            'fields' => array(
                                'from_customer_order',
                                'type_ride',
                                'type_pricing',
                                'tonnage_id',
                                'designation',
                                'description',
                                'lot_id',
                                'detail_ride_id',
                                'car_type_id',
                                'departure_destination_id',
                                'arrival_destination_id',
                                'supplier_final_id',
                                'TransportBill.status',
                                'transport_bill_id',
                                'unit_price',
                                'delivery_with_return',
                                'programming_date',
                                'charging_time',
                                'unloading_date',
                                'ride_category_id',
                                'type_price',
                                'nb_trucks',
                                'price_ht',
                                'price_ttc',
                                'TransportBillDetailRides.approved',
                                'TransportBill.supplier_id',
                                'TransportBill.status',
                                'tva_id',
                                'ristourne_%',
                                'ristourne_val',
                                'SheetRideDetailRides.id',
                                'TransportBillDetailRides.sheet_ride_detail_ride_id',
                                'SheetRideDetailRides.reference'
                            ),
                            'joins' => array(
                                array(
                                    'table' => 'transport_bills',
                                    'type' => 'left',
                                    'alias' => 'TransportBill',
                                    'conditions' => array('TransportBillDetailRides.transport_bill_id = TransportBill.id')
                                ),
                                array(
                                    'table' => 'sheet_ride_detail_rides',
                                    'type' => 'left',
                                    'alias' => 'SheetRideDetailRides',
                                    'conditions' => array('TransportBillDetailRides.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
                                ),
                            )
                        ));
                    $transportBillDetailRides = $data['TransportBillDetailRides'];
                    // on recupère la date sans faire un foreach sur le tableau $data1['TransportBill']
                    if ($this->request->data['date'] == 1) {
                        $date = date("Y-m-d");
                    } else {
                        $date = $data1['TransportBill']['date'];
                    }
                    if ($this->request->data['affectation_client'] == 1) {
                        $supplier_id = null;
                    } else {
                        $supplier_id = $this->request->data['TransportBill']['supplier_id'];
                    }
                    $transport_bill_id_array = $arrayIds;
                    $r_t_d = 2;
                    $this->add_transport_bill_detail_rides($data1['TransportBill'], $data['TransportBillDetailRides'],
                        $new_type, $origin_type, $date, $supplier_id, $transport_bill_id_array, $r_t_d);
                    foreach ($transportBills as $transportBill) {
                        $this->updateStatusTransportBill($transportBill['TransportBill']);
                    }
                    foreach ($transportBillDetailRides as $transportBillDetailRide){
                        $sheetRideDetailRideId = $transportBillDetailRide['TransportBillDetailRides']['sheet_ride_detail_ride_id'];
                        $status = 7;
                        $this->SheetRideDetailRides->updateStatusSheetRideDetailRide($sheetRideDetailRideId, $status);
                    }

                    $this->redirect(array('action' => 'index', $new_type));

                } else {

                    $transportBills = $this->TransportBill->find('all',
                        array(
                            'conditions' => array('TransportBill.id' => $arrayIds, 'TransportBill.status' => 1),
                            'recursive' => -1,
                            'fields' => array(
                                'id',
                                'reference',
                                'date',
                                'type',
                                'total_ht',
                                'total_ttc',
                                'total_tva',
                                'TransportBill.supplier_id',
                                'TransportBill.supplier_final_id',
                                'TransportBill.status',
                            ),
                            'joins' => array(
                                array(
                                    'table' => 'transport_bill_detail_rides',
                                    'type' => 'left',
                                    'alias' => 'TransportBillDetailRides',
                                    'conditions' => array('TransportBillDetailRides.transport_bill_id = TransportBill.id')
                                ),
                            )

                        ));
                    if (empty($transportBills)) {
                        $this->Flash->error(__('The bill is already transformed.'));
                        $this->redirect(array('action' => 'index', $origin_type));
                    } else {
                        $this->Flash->error(__('You must first approve missions of the selected préfectures.'));
                        $this->redirect(array('action' => 'index', $origin_type));

                    }

                }
            }
        }

        $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
        $this->set(compact('suppliers', 'arrayIds'));
    }

    public function addRequestQuotation()
    {

        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            return $this->redirect('/');
        }
        $this->TransportBill->validate = $this->TransportBill->validate_request;
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');

        $type = 0;
        $this->verifyUserPermission(SectionsEnum::demande_de_devis, $user_id, ActionsEnum::add, "TransportBills", null,
            "TransportBill", $type);

        $reference = $this->getNextTransportReference( $type);

        $this->set('reference', $reference);

        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index', 0));
            }

            $this->TransportBill->create();
            $reference = $this->getNextTransportReference($type);
            if ($reference != '0') {

            $this->request->data['TransportBill']['reference'] = $reference;
        }
            $this->createDateFromDate('TransportBill', 'date');
            $type = 0;
            $this->request->data['TransportBill']['type'] = $type;
            $this->request->data['TransportBill']['status'] = 1;
            $this->request->data['TransportBill']['user_id'] = $this->Session->read('Auth.User.id');
            $rideId = $this->request->data['TransportBill']['ride_id'];
            $carTypeId = $this->request->data['TransportBill']['car_type_id'];
            $clientId = $this->request->data['TransportBill']['supplier_id'];
            $clientFinalId = $this->request->data['TransportBill']['supplier_final_id'];
            $deliveryWithReturn = $this->request->data['TransportBill']['delivery_with_return'];
            if (isset($this->request->data['TransportBill']['ride_category_id'])) {
                $rideCategoryId = $this->request->data['TransportBill']['ride_category_id'];
            } else {
                $rideCategoryId = null;
            }
            $detailRideId = $this->getDetailRide($rideId, $carTypeId);
            $price = $this->getPriceRide($detailRideId, 0, $clientId, $deliveryWithReturn, 1, $rideCategoryId);

            if (!empty($price)) {
                $unitPriceDeliverySimple = $price[0];
                $priceReturn = $price[2];
            } else {
                $unitPriceDeliverySimple = 0;
                $priceReturn = 0;
            }

            $nbTrucks = $this->request->data['TransportBill']['nb_trucks'];

            if ($this->request->data['TransportBill']['delivery_with_return'] == 1) {
                $unitPrice = $unitPriceDeliverySimple;

            } else {
                $unitPrice = $priceReturn;
            }
            $priceHt = ($unitPrice * $nbTrucks);
            $priceTtc = $priceHt + ($priceHt * 0.19);
            $priceTva = $priceTtc - $priceHt;
            $this->request->data['TransportBill']['total_ht'] = $priceHt;
            $this->request->data['TransportBill']['total_ttc'] = $priceTtc;
            $this->request->data['TransportBill']['total_tva'] = $priceTva;
            if ($this->TransportBill->save($this->request->data)) {
                $this->Parameter->setNextTransportReferenceNumber($type);
                $transportBillDetailRide = $this->calculPrice($detailRideId, $unitPrice, $nbTrucks, $deliveryWithReturn,
                    $rideCategoryId);
                $transportBillId = $this->TransportBill->getInsertID();
                $save = $this->add_Rides_transportBill($transportBillDetailRide, $reference, $transportBillId, $userId, $type, $clientFinalId);
                if($save == false ){
                    $this->TransportBill->deleteAll(array('TransportBill.id' => $transportBillId),
                        false);
                    $this->Flash->error(__('The request quotation could not be saved. Please, try again.'));
                    $this->redirect(array('action' => 'index', $type));
                }
                $profileId = $this->Auth->user('profile_id');
                $parentId = $this->Profile->getParentProfileByProfileId($profileId);
                if ($parentId != Null) {
                    $profileId = $parentId;
                }
                if ($profileId == ProfilesEnum::client) {
                    $actionId = ActionsEnum::add;
                    $sectionId = SectionsEnum::nouveau_devis;
                    $userId = $this->Auth->user('id');
                        $this->Notification->addNotification($transportBillId, $userId, $actionId, $sectionId);
                        $this->getNbNotificationsByUser();

                }
                $this->Flash->success(__('The request quotation has been saved.'));
                $this->redirect(array('action' => 'index', $type));
            } else {
                $this->Flash->error(__('The request quotation could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index', $type));
            }
        }
        $carTypes = $this->CarType->getCarTypes();
        $rideCategories = $this->RideCategory->getRideCategories();
        $transportBillCategories = $this->TransportBillCategory->getTransportBillCategories();
        $profileId = $this->Auth->user('profile_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        $this->set('profileId', $profileId);

        if ($profileId == ProfilesEnum::client) {
            $supplierId = $this->Auth->user('supplier_id');

            $suppliers = $this->Supplier->getSuppliersByParams(1, 1, null, array(2, 3), null, $supplierId);
            $this->set(compact('supplierId', 'suppliers'));
        }
        $tvas = $this->Tva->getTvas();

        $useRideCategory = $this->useRideCategory();
        $this->set(compact('tvas', 'type', 'carTypes', 'rides', 'rideCategories',
            'useRideCategory', 'transportBillCategories'));

    }

    public function getDetailRide($ride_id, $car_type_id)
    {
        $detailRide = $this->TransportBill->DetailRide->find('first', array(
            'recursive' => -1,
            'fields' => array('DetailRide.id',),
            'conditions' => array(
                'DetailRide.ride_id' => $ride_id,
                'DetailRide.car_type_id' => $car_type_id
            )
        ));

        if (!empty($detailRide)) {
            $detail_ride_id = $detailRide['DetailRide']['id'];

        } else {

            $this->DetailRide->create();
            $data['DetailRide']['ride_id'] = $this->request->data['TransportBill']['ride_id'];
            $data['DetailRide']['car_type_id'] = $this->request->data['TransportBill']['car_type_id'];
            $this->DetailRide->save($data);
            $detail_ride_id = $this->DetailRide->getInsertID();

        }
        return $detail_ride_id;


    }

    public function calculPrice(
        $detailRideId = null,
        $unitPrice = null,
        $nbTrucks = null,
        $deliveryWithReturn = null,
        $rideCategoryId = null
    )
    {
        $priceHt = $unitPrice * $nbTrucks;
        $priceTtc = $priceHt + ($priceHt * 0.19);
        $transportBillDetailRide = array();
        $transportBillDetailRide['TransportBillDetailRides']['detail_ride_id'] = $detailRideId;
        $transportBillDetailRide['TransportBillDetailRides']['unit_price'] = $unitPrice;
        $transportBillDetailRide['TransportBillDetailRides']['delivery_with_return'] = $deliveryWithReturn;
        $transportBillDetailRide['TransportBillDetailRides']['nb_trucks'] = $nbTrucks;
        $transportBillDetailRide['TransportBillDetailRides']['price_ht'] = $priceHt;
        $transportBillDetailRide['TransportBillDetailRides']['tva_id'] = 1;
        $transportBillDetailRide['TransportBillDetailRides']['product_id'] = 1;
        $transportBillDetailRide['TransportBillDetailRides']['price_ttc'] = $priceTtc;
        $transportBillDetailRide['TransportBillDetailRides']['ristourne_val'] = 0;
        $transportBillDetailRide['TransportBillDetailRides']['ristourne_%'] = 0;
        $transportBillDetailRide['TransportBillDetailRides']['ride_category_id'] = $rideCategoryId;
        return $transportBillDetailRide;
    }

    public function editRequestQuotation($id)
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            return $this->redirect('/');
        }
        $this->TransportBill->validate = $this->TransportBill->validate_request;
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $profileId = $this->Auth->user('profile_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        $this->set('profileId', $profileId);
        if ($profileId == ProfilesEnum::client) {
            $supplierId = $this->Auth->user('supplier_id');
            $this->set('supplierId', $supplierId);
        }
        $type = 0;
        $this->verifyUserPermission(SectionsEnum::demande_de_devis, $user_id, ActionsEnum::edit, "TransportBills", $id,
            "TransportBill", $type);

        $reference = $this->getNextTransportReference( $type);
        $this->set('reference', $reference);
        if ($this->request->is(array('post', 'put'))) {

            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index', 0));
            }
            $this->createDateFromDate('TransportBill', 'date');
            $type = 0;
            $this->request->data['TransportBill']['type'] = $type;
            $this->request->data['TransportBill']['modified_id'] = $this->Session->read('Auth.User.id');
            $transportBill = $this->TransportBill->find('first',
                array(
                    'recursive' => -1,
                    'fields' =>
                        array(
                            'TransportBill.user_id'
                        ),
                    'conditions' =>
                        array(
                            'TransportBill.id' => $id
                        )
                )
            );
            $this->request->data['TransportBill']['user_id'] = $transportBill['TransportBill']['user_id'];
            $rideId = $this->request->data['TransportBill']['ride_id'];
            $carTypeId = $this->request->data['TransportBill']['car_type_id'];
            $clientId = $this->request->data['TransportBill']['supplier_id'];
            $clientFinalId = $this->request->data['TransportBill']['supplier_final_id'];
            $detailRideId = $this->getDetailRide($rideId, $carTypeId);
            if (isset($this->request->data['TransportBill']['delivery_with_return'])) {
                $deliveryWithReturn = $this->request->data['TransportBill']['delivery_with_return'];
            } else {
                $deliveryWithReturn = 1;
            }

            if (isset($this->request->data['TransportBill']['ride_category_id'])) {
                $rideCategoryId = $this->request->data['TransportBill']['ride_category_id'];
            } else {
                $rideCategoryId = null;
            }

            $price = $this->getPriceRide($detailRideId, 0, $clientId, $deliveryWithReturn, 1, $rideCategoryId);
            if (!empty($price)) {
                $unitPriceDeliverySimple = $price[0];
                $priceReturn = $price[2];
            } else {
                $unitPriceDeliverySimple = 0;
                $priceReturn = 0;
            }


            $nbTrucks = $this->request->data['TransportBill']['nb_trucks'];

            if ($this->request->data['TransportBill']['delivery_with_return'] == 1) {
                $unitPrice = $unitPriceDeliverySimple;

            } else {
                $unitPrice = $priceReturn;
            }
            $priceHt = $unitPrice * $nbTrucks;
            $priceTtc = $priceHt + ($priceHt * 0.19);
            $priceTva = $priceTtc - $priceHt;
            $this->request->data['TransportBill']['total_ht'] = $priceHt;
            $this->request->data['TransportBill']['total_ttc'] = $priceTtc;
            $this->request->data['TransportBill']['total_tva'] = $priceTva;

            if ($this->TransportBill->save($this->request->data)) {

                $this->Parameter->setNextTransportReferenceNumber($type);
                $transportBillDetailRide = $this->calculPrice($detailRideId, $unitPrice, $nbTrucks, $deliveryWithReturn,
                    $rideCategoryId);

                $this->TransportBillDetailRides->deleteAll(array('TransportBillDetailRides.transport_bill_id' => $id),
                    false);
                $save = $this->add_Rides_transportBill($transportBillDetailRide, $reference, $id, $userId, $type, $clientFinalId);

                if($save == false ){
                    $this->TransportBill->deleteAll(array('TransportBill.id' => $id),
                        false);
                    $this->Flash->error(__('The request quotation could not be saved. Please, try again.'));
                    $this->redirect(array('action' => 'index', $type));
                }

                $this->saveUserAction(SectionsEnum::demande_de_devis, $id, $this->Session->read('Auth.User.id'), ActionsEnum::edit);
                $profileId = $this->Auth->user('profile_id');
                $parentId = $this->Profile->getParentProfileByProfileId($profileId);
                if ($parentId != Null) {
                    $profileId = $parentId;
                }
                if ($profileId == ProfilesEnum::client) {
                    $userId = $this->Auth->user('id');
                    $receivers = $this->User->getUsersReceiverClientNotifications();
                    $actionId = ActionsEnum::edit;
                    if (!empty($receivers)) {
                        $this->Notification->updateNotification($id, $userId, $receivers, $actionId);
                        $this->getNbNotificationsByUser();
                    }
                }
                $this->Flash->success(__('The request quotation has been saved.'));
                $this->redirect(array('action' => 'index', $type));
            } else {
                $this->Flash->error(__('The request quotation could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index', $type));
            }

        } else {
            $this->isOpenedByOtherUser("TransportBill", 'TransportBills', 'bill', $id, $type);
            $options = array('conditions' => array('TransportBill.' . $this->TransportBill->primaryKey => $id));
            $this->request->data = $this->TransportBill->find('first', $options);
            $this->TransportBill->Ride->virtualFields = array('cnames' => "CONCAT(DepartureDestination.name, ' - ', ArrivalDestination.name)");
            $rides = $this->TransportBill->Ride->find('list',
                array(
                    'fields' => 'cnames',
                    'conditions' => array('Ride.id' => $this->request->data['TransportBill']['ride_id']),
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
            $suppliers = $this->Supplier->getSuppliersByParams(1, 1, null, array(2, 3), null, $this->request->data['TransportBill']['supplier_id']);
            $finalSuppliers = $this->Supplier->getFinalSuppliersByInitialSupplier($this->request->data['TransportBill']['supplier_id'], $this->request->data['TransportBill']['supplier_final_id']);
            $conditionsCustomer = array('Customer.id' => $this->request->data['TransportBill']['customer_id']);
            $fields = "names";
            $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditionsCustomer);

            $this->set(compact('rides', 'suppliers', 'finalSuppliers', 'customers'));
        }

        $carTypes = $this->CarType->getCarTypes();
        $rideCategories = $this->RideCategory->getRideCategories();

        $transportBillCategories = $this->TransportBillCategory->getTransportBillCategories();
        $tvas = $this->Tva->getTvas();
        $useRideCategory = $this->useRideCategory();

        $this->set(compact('tvas', 'type', 'carTypes', 'rides', 'rideCategories',
            'useRideCategory', 'transportBillCategories'));

    }

    public function addFromCustomerOrder()
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        $userId = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::feuille_de_route, $userId, ActionsEnum::add, "SheetRides", null,
            "SheetRide", null);
        $this->updateIsOpen();
        $query['count'] =
            "SELECT COUNT(*) AS `count` FROM `transport_bill_detail_rides` AS `TransportBillDetailRides` 
            left JOIN `transport_bills` AS `TransportBill` ON (`TransportBillDetailRides`.`transport_bill_id` = `TransportBill`.`id`) 
            left JOIN `detail_rides` AS `DetailRide` ON (`TransportBillDetailRides`.`detail_ride_id` = `DetailRide`.`id`) 
            left JOIN `ride_categories` AS `RideCategory` ON (`TransportBillDetailRides`.`ride_category_id` = `RideCategory`.`id`) 
            left JOIN `car_types` AS `CarType` ON (`DetailRide`.`car_type_id` = `CarType`.`id`) 
            left JOIN `car` AS `Car` ON (`TransportBillDetailRides`.`car_id` = `Car`.`id`) 
            left JOIN `carmodels` AS `Carmodel` ON (`Car`.`carmodel_id` = `Carmodel`.`id`) 
            left JOIN `rides` AS `Ride` ON (`DetailRide`.`ride_id` = `Ride`.`id`) 
            left JOIN `suppliers` AS `Supplier` ON (`TransportBill`.`supplier_id` = `Supplier`.`id`) 
            left JOIN `suppliers` AS `SupplierFinal` ON (`TransportBillDetailRides`.`supplier_final_id` = `SupplierFinal`.`id`) 
            left JOIN `destinations` AS `DepartureDestination` ON (`DepartureDestination`.`id` = `Ride`.`departure_destination_id`) 
            left JOIN `destinations` AS `ArrivalDestination` ON (`ArrivalDestination`.`id` = `Ride`.`arrival_destination_id`) 
            left JOIN `destinations` AS `Departure` ON (`Departure`.`id` = `TransportBillDetailRides`.`departure_destination_id`) 
            left JOIN `destinations` AS `Arrival` ON (`Arrival`.`id` = `TransportBillDetailRides`.`arrival_destination_id`) 
            left JOIN `car_types` AS `Type` ON (`TransportBillDetailRides`.`car_type_id` = `Type`.`id`) 
            left JOIN `users` AS `User` ON (`TransportBill`.`user_id` = `User`.`id`) 
            left JOIN `services` AS `Service` ON (`TransportBill`.`service_id` = `Service`.`id`) 
            left JOIN `lots` AS `Lot` ON (`TransportBillDetailRides`.`lot_id` = `Lot`.`id`) 
            left JOIN `products` AS `Product` ON (`Product`.`id` = `Lot`.`product_id`) 
            left JOIN `product_types` AS `ProductType` ON (`Product`.`product_type_id` = `ProductType`.`id`) 
            
            WHERE `TransportBill`.`type` = 2 
            AND `TransportBillDetailRides`.`status_id` IN (1, 2)
            AND `ProductType`.`relation_with_park` = 1  " ;

        $query['detail'] =
            "SELECT  `TransportBill`.`id`, `TransportBill`.`date`, `CarType`.`name`, `RideCategory`.`name`, 
            `ProductType`.`id`, `User`.`first_name`, `User`.`last_name`, 
            `TransportBillDetailRides`.`type_ride`, `TransportBillDetailRides`.`reference`, `TransportBillDetailRides`.`nb_trucks_validated`, 
            `TransportBillDetailRides`.`nb_trucks`, `TransportBillDetailRides`.`id`, `TransportBillDetailRides`.`status_id`,
            `TransportBillDetailRides`.`start_date`,`TransportBillDetailRides`.`end_date`,`TransportBillDetailRides`.`nb_hours`,`TransportBillDetailRides`.`car_id`,
             `DepartureDestination`.`name`, `ArrivalDestination`.`name`, `Supplier`.`name`, `SupplierFinal`.`name`, `Departure`.`name`, 
            `Arrival`.`name`, `Type`.`name`,`CarType`.`name`, `Service`.`name` ,`Product`.`name` , `Car`.`immatr_def` , `Carmodel`.`name` , 
            CONCAT(`DepartureDestination`.`name` ,' - ', `ArrivalDestination`.`name`) as trajet
            FROM `transport_bill_detail_rides` AS `TransportBillDetailRides` 
            left JOIN `transport_bills` AS `TransportBill` ON (`TransportBillDetailRides`.`transport_bill_id` = `TransportBill`.`id`) 
            left JOIN `detail_rides` AS `DetailRide` ON (`TransportBillDetailRides`.`detail_ride_id` = `DetailRide`.`id`) 
            left JOIN `ride_categories` AS `RideCategory` ON (`TransportBillDetailRides`.`ride_category_id` = `RideCategory`.`id`) 
            left JOIN `car_types` AS `CarType` ON (`DetailRide`.`car_type_id` = `CarType`.`id`) 
            left JOIN `car` AS `Car` ON (`TransportBillDetailRides`.`car_id` = `Car`.`id`) 
            left JOIN `carmodels` AS `Carmodel` ON (`Car`.`carmodel_id` = `Carmodel`.`id`) 
            left JOIN `rides` AS `Ride` ON (`DetailRide`.`ride_id` = `Ride`.`id`) 
            left JOIN `suppliers` AS `Supplier` ON (`TransportBill`.`supplier_id` = `Supplier`.`id`) 
            left JOIN `suppliers` AS `SupplierFinal` ON (`TransportBillDetailRides`.`supplier_final_id` = `SupplierFinal`.`id`) 
            left JOIN `destinations` AS `DepartureDestination` ON (`DepartureDestination`.`id` = `Ride`.`departure_destination_id`) 
            left JOIN `destinations` AS `ArrivalDestination` ON (`ArrivalDestination`.`id` = `Ride`.`arrival_destination_id`)  
            left JOIN `destinations` AS `Departure` ON (`Departure`.`id` = `TransportBillDetailRides`.`departure_destination_id`) 
            left JOIN `destinations` AS `Arrival` ON (`Arrival`.`id` = `TransportBillDetailRides`.`arrival_destination_id`) 
            left JOIN `car_types` AS `Type` ON (`TransportBillDetailRides`.`car_type_id` = `Type`.`id`) 
            left JOIN `users` AS `User` ON (`TransportBill`.`user_id` = `User`.`id`) 
            left JOIN `services` AS `Service` ON (`TransportBill`.`service_id` = `Service`.`id`) 
            left JOIN `lots` AS `Lot` ON (`TransportBillDetailRides`.`lot_id` = `Lot`.`id`) 
            left JOIN `products` AS `Product` ON (`Product`.`id` = `Lot`.`product_id`) 
            left JOIN `product_types` AS `ProductType` ON (`Product`.`product_type_id` = `ProductType`.`id`) 
            WHERE `TransportBill`.`type` = 2 
            AND `TransportBillDetailRides`.`status_id` IN (1, 2) 
            AND `ProductType`.`relation_with_park` = 1 ";



        $useRideCategory = $this->useRideCategory();
        $this->Session->write('useRideCategory', $useRideCategory);
        if ($useRideCategory == '2') {
            $query['columns'] = array(
                0 => array('TransportBillDetailRides.reference','TransportBillDetailRides', 'reference', 'Reference', 'string',''),
                1 => array('DepartureDestination.name','0', 'trajet',  'Ride', 'string','CONCAT','DepartureDestination.name','ArrivalDestination.name','Departure.name','Arrival.name'),
                2 => array('CarType.name','CarType', 'name', 'Transportation', 'string','CONCAT','CarType.name','Type.name'),
                3 => array('RideCategory.name','RideCategory', 'name', 'Ride category', 'string',''),
                4 => array('TransportBill.date','TransportBill', 'date', 'Date', 'date',''),
                5 => array('User.first_name','User', 'first_name',  'Creator', 'string','CONCAT','User.first_name','User.last_name'),
                6 => array('Supplier.name','Supplier', 'name','Initial customer', 'string',''),
                7 => array('Service.name','Service', 'name', 'Service', 'string',''),
                8 => array('SupplierFinal.name','SupplierFinal', 'name', 'Final customer', 'string',''),
                9 => array('TransportBillDetailRides.nb_trucks','TransportBillDetailRides', 'nb_trucks', 'Number of trucks', 'number',''),
                10 => array('TransportBillDetailRides.nb_trucks_validated','TransportBillDetailRides', 'nb_trucks_validated', 'Number of trucks validated', 'number',''),
                11 => array('TransportBillDetailRides.status_id','TransportBillDetailRides', 'status_id', 'Status', 'number',''),
            );
        }else {
            $query['columns'] = array(
                0 => array('TransportBillDetailRides.reference','TransportBillDetailRides', 'reference', 'Reference', 'string',''),
                1 => array('DepartureDestination.name','0', 'trajet',  'Ride', 'string','CONCAT','DepartureDestination.name','ArrivalDestination.name','Departure.name','Arrival.name'),
                2 => array('CarType.name','CarType', 'name', 'Transportation', 'string','CONCAT','CarType.name','Type.name'),
                3 => array('TransportBill.date','TransportBill', 'date', 'Date', 'date',''),
                4 => array('User.first_name','User', 'first_name',  'Creator', 'string','CONCAT','User.first_name','User.last_name'),
                5 => array('Supplier.name','Supplier', 'name','Initial customer', 'string',''),
                6 => array('Service.name','Service', 'name', 'Service', 'string',''),
                7 => array('SupplierFinal.name','SupplierFinal', 'name', 'Final customer', 'string',''),
                8 => array('TransportBillDetailRides.nb_trucks','TransportBillDetailRides', 'nb_trucks', 'Number of trucks', 'number',''),
                9 => array('TransportBillDetailRides.nb_trucks_validated','TransportBillDetailRides', 'nb_trucks_validated', 'Number of trucks validated', 'number',''),
                10 => array('TransportBillDetailRides.status_id','TransportBillDetailRides', 'status_id', 'Status', 'number',''),
            );
        }
        $query['order'] = ' TransportBillDetailRides.id desc';
        $query['conditions'] = '';
        $query['tableName'] = 'TransportBillDetailRides';
        $query['controller'] = 'transportBillDetailRides';
        $query['action'] = 'addFromCustomerOrder';
        $query['itemName'] = array('reference');

        $this->Session->write('query', $query);
        //get default user limit value
        $defaultLimit =  $this->getLimit();;
        if (isset($defaultLimit) && $defaultLimit > 0) {
            $this->set('defaultLimit', $defaultLimit);
        } else {
            $this->set('defaultLimit', 20);
        }
        $controller =  'transportBillDetailRides';
        $action = 'addFromCustomerOrder';
        $deleteFonction =  'deleteTransportBillDetailRides/';

        $reportingChoosed = $this->reportingChoosed();
        $this->Session->write('reportingChoosed', $reportingChoosed);
        if ($reportingChoosed == 3) {
            $informationJasperReport = $this->Parameter->getInformationJasperReport();
            $this->set('informationJasperReport', $informationJasperReport);
            $this->Session->write('informationJasperReport', $informationJasperReport);
        }

        $carTypes = $this->CarType->getCarTypes();
        $services = $this->Service->getServices('list');
        $this->set(compact('carTypes', 'type', 'param', 'limit',
            'useRideCategory', 'services',
            'controller','deleteFonction','action'));


    }

    public function addFromCustomerOrderDetail()
    {
        $observationIdsWithMissions = array();
        $sheetRideDetailRides = $this->SheetRideDetailRides->find('all', array(
            'recursive' => -1, // should be used with joins
            'conditions' => array('SheetRideDetailRides.observation_id !='=>NULL),
            'fields' => array('SheetRideDetailRides.observation_id')
        ));

        foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
            $observationIdsWithMissions[] = $sheetRideDetailRide['SheetRideDetailRides']['observation_id'];
        }
        if (!empty($observationIdsWithMissions)) {
            $conditions = array('TransportBillDetailedRides.status_id' => array(1, 2),
                'TransportBill.type' => 2,
                'Observation.id !=' => $observationIdsWithMissions);
        } else {
            $conditions = array('TransportBillDetailedRides.status_id' => array(1, 2),
                'TransportBill.type' => 2,);
        }
        $condition = array('TransportBillDetailedRides.sheet_ride_id IS NULL');
        if ($this->request->is('post')) {
            if (
            isset($this->request->data['keyword'])&&
            !empty($this->request->data['keyword'])){
                $keyword = $this->request->data['keyword'];
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
                        "LOWER(TransportBillDetailedRides.observation_order) LIKE" => "%$keyword%",
                        "LOWER(TransportBillDetailedRides.unit_price) LIKE" => "%$keyword%",
                    )
                );

                $condition = array_merge($condition,$conds);
            }
        }

        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'conditions' => $condition,
            'order' => 'TransportBillDetailedRides.id DESC',
            'group' => array('TransportBillDetailedRides.id', 'TransportBill.id'),
            'fields' => array(
                'TransportBill.reference',
                'TransportBill.id',
                'TransportBill.type',
                'TransportBill.supplier_id',
                'TransportBill.date',
                'TransportBill.order_type',
                'CarType.name',
                'RideCategory.name',
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
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Departure.name',
                'Arrival.name',
                'Type.name',
                'Supplier.name',
                'SupplierFinal.name',
                'Tva.name',
                'Observation.id',
                'Observation.customer_observation',
                'Observation.cancel_cause_id',
                'CancelCause.name',
                'Product.name',
                'ProductType.id',
                'Carmodel.name',
                'Car.immatr_def',
                'User.first_name',
                'User.last_name',
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
                    'conditions' => array('TransportBillDetailRides.id = TransportBillDetailedRides.transport_bill_detail_ride_id')
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
                    'conditions' => array('TransportBillDetailedRides.detail_ride_id = DetailRide.id')
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
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'ride_categories',
                    'type' => 'left',
                    'alias' => 'RideCategory',
                    'conditions' => array('TransportBillDetailedRides.ride_category_id = RideCategory.id')
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
                    'table' => 'tva',
                    'type' => 'left',
                    'alias' => 'Tva',
                    'conditions' => array('TransportBillDetailedRides.tva_id = Tva.id')
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
                    'table' => 'cancel_causes',
                    'type' => 'left',
                    'alias' => 'CancelCause',
                    'conditions' => array('Observation.cancel_cause_id = CancelCause.id')
                ),
                array(
                    'table' => 'lots',
                    'type' => 'left',
                    'alias' => 'Lot',
                    'conditions' => array('TransportBillDetailedRides.lot_id = Lot.id')
                ),
                array(
                    'table' => 'products',
                    'type' => 'left',
                    'alias' => 'Product',
                    'conditions' => array('Product.id = Lot.product_id')
                ),
                array(
                    'table' => 'product_types',
                    'type' => 'left',
                    'alias' => 'ProductType',
                    'conditions' => array('ProductType.id = Product.product_type_id')
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
        $this->set(compact('transportBillDetailRides'));
        $this->set('controllerName', 'TransportBills');
        $this->set('actionName', 'addFromCustomerOrderDetail');

    }

    public function updateIsOpen()
    {
        date_default_timezone_set("Africa/Algiers");
        $transportBillDetailRides = $this->TransportBillDetailRides->find('all', array(
                'recursive'=>-1,'fields'=>array('TransportBillDetailRides.id','TransportBillDetailRides.is_open',
                'TransportBillDetailRides.date_open'),
            'conditions' => array('TransportBillDetailRides.is_open ' => 1)
        ));
        
        foreach ($transportBillDetailRides as $transportBillDetailRide) {
            $datetime1 = $transportBillDetailRide['TransportBillDetailRides']['date_open'];
            $datetime2 = date('Y-m-d H:i');
            $datetime1 = new DateTime ($datetime1);
            $datetime2 = new DateTime ($datetime2);
            $interval = date_diff($datetime1, $datetime2);
            $total = $interval->y * 526600 + $interval->m * 43800 + $interval->d * 1440 + $interval->h * 60 + $interval->i;
            if ($total > 15) {
                $this->TransportBillDetailRides->id = $transportBillDetailRide['TransportBillDetailRides']['id'];
                $this->TransportBillDetailRides->saveField('is_open', 0);
            }
        }
    }

    public function savePrice()
    {
        $clientId = filter_input(INPUT_POST, "client_id");
        $rideId = filter_input(INPUT_POST, "ride_id");
        $unitPrice = filter_input(INPUT_POST, "unit_price");
        $deliveryWithReturn = filter_input(INPUT_POST, "deliveryWithReturn");
        $rideCategoryId = filter_input(INPUT_POST, "rideCategoryId");
        $typePrice = filter_input(INPUT_POST, "typePrice");
        $price = $this->getPriceRide($rideId, 0, $clientId, $deliveryWithReturn, $typePrice, $rideCategoryId);
        if (empty($price)) {
            $this->Price->create();
            $data['Price']['detail_ride_id'] = $rideId;
            $data['Price']['supplier_id'] = $clientId;
            $this->Price->save($data);
            $priceId = $this->Price->getInsertID();
            $this->PriceRideCategory->create();
            $data['PriceRideCategory']['price_id'] = $priceId;
            $data['PriceRideCategory']['ride_category_id'] = $rideCategoryId;
            if ($deliveryWithReturn == 1) {
                $data['PriceRideCategory']['price_return'] = $unitPrice;
            } else {
                if ($typePrice == 2) {
                    $data['PriceRideCategory']['price_ht_night'] = $unitPrice;
                } else {
                    $data['PriceRideCategory']['price_ht'] = $unitPrice;
                }
            }

            if ($this->PriceRideCategory->save($data)) {
                echo json_encode(array("response" => "true"));

            }
        }

        /* if (!empty($price)) {
             $this->Price->id = $price[1];
             $priceRideCategory= $this->Price->PriceRideCategory->find('first',array('conditions'=>array('PriceRideCategory.price_id'=>$price[1])));
             $this->PriceRideCategory->id =$priceRideCategory['PriceRideCategory']['id'];
             if ($deliveryWithReturn == 1) {
                 $this->PriceRideCategory->saveField('price_return', $unitPrice);
             } else {
                 $this->PriceRideCategory->saveField('price_ht', $unitPrice);
             }
         }*/
    }

    public function addFromSheetRide($type=null)
    {

        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSprintSimplifiedJournalaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        $conditions = '';
        if ($this->request->is('post')) {
            if (
                isset($this->request->data['transportBills']['supplier_id']) ||
                isset($this->request->data['transportBills']['subcontractor_id']) ||
                isset($this->request->data['transportBills']['order_type']) ||
                isset($this->request->data['transportBills']['service_id']) ||
                isset($this->request->data['transportBills']['detail_ride_id']) ||
                isset($this->request->data['transportBills']['date_from_mission']) ||
                isset($this->request->data['transportBills']['date_to_mission']) ||
                isset($this->request->data['transportBills']['date_from_sheet']) ||
                isset($this->request->data['transportBills']['date_to_sheet']) ||
                isset($this->request->data['transportBills']['date_from_order']) ||
                isset($this->request->data['transportBills']['date_to_order'])
            ) {
                $supplier = $this->request->data['transportBills']['supplier_id'];
                $service = $this->request->data['transportBills']['service_id'];
                $detailRide = $this->request->data['transportBills']['detail_ride_id'];
                $subcontractor = $this->request->data['transportBills']['subcontractor_id'];
                $orderType = $this->request->data['transportBills']['order_type'];
                $date_from_mission = str_replace("/", "-", $this->request->data['transportBills']['date_from_mission']);
                $date_to_mission = str_replace("/", "-", $this->request->data['transportBills']['date_to_mission']);
                $date_from_sheet = str_replace("/", "-", $this->request->data['transportBills']['date_from_sheet']);
                $date_to_sheet = str_replace("/", "-", $this->request->data['transportBills']['date_to_sheet']);
                $date_from_order = str_replace("/", "-", $this->request->data['transportBills']['date_from_order']);
                $date_to_order = str_replace("/", "-", $this->request->data['transportBills']['date_to_order']);
                if (!empty($supplier)) {
                    $conditions .= " && SheetRideDetailRides.supplier_id = $supplier  ";
                }
                if (!empty($service)) {
                    $conditions .= " && Service.id = $service  ";
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
                if (!empty($date_from_mission)) {
                    $start_mission = str_replace("-", "/", $date_from_mission);
                    $startdtm_mission = DateTime::createFromFormat('d/m/Y', $start_mission);
                    $startdtm_mission = $startdtm_mission->format('Y-m-d 00:00:00');
                    $conditions .= " && SheetRideDetailRides.real_start_date >= '$startdtm_mission' ";
                }
                if (!empty($date_to_mission)) {
                    $end_mission = str_replace("-", "/", $date_to_mission);
                    $enddtm_mission = DateTime::createFromFormat('d/m/Y', $end_mission);
                    $enddtm_mission = $enddtm_mission->format('Y-m-d 23:59:00');
                    $conditions .= " && SheetRideDetailRides.real_start_date <= '$enddtm_mission' ";
                }
                if (!empty($date_from_sheet)) {
                    $start_sheet = str_replace("-", "/", $date_from_sheet);
                    $startdtm_sheet = DateTime::createFromFormat('d/m/Y', $start_sheet);
                    $startdtm_sheet = $startdtm_sheet->format('Y-m-d 00:00:00');
                    $conditions .= " && SheetRide.real_start_date >= '$startdtm_sheet' ";
                }
                if (!empty($date_to_sheet)) {
                    $end_sheet = str_replace("-", "/", $date_to_sheet);
                    $enddtm_sheet = DateTime::createFromFormat('d/m/Y', $end_sheet);
                    $enddtm_sheet = $enddtm_sheet->format('Y-m-d 23:59:00');
                    $conditions .= " && SheetRide.real_start_date <= '$enddtm_sheet' ";
                }
                if (!empty($date_from_order)) {
                    $start_order = str_replace("-", "/", $date_from_order);
                    $startdtm_order = DateTime::createFromFormat('d/m/Y', $start_order);
                    $startdtm_order = $startdtm_order->format('Y-m-d 00:00:00');
                    $conditions .= " && TransportBill.date >= '$startdtm_order' ";
                }
                if (!empty($date_to_order)) {
                    $end_order = str_replace("-", "/", $date_to_order);
                    $enddtm_order = DateTime::createFromFormat('d/m/Y', $end_order);
                    $enddtm_order = $enddtm_order->format('Y-m-d 23:59:00');
                    $conditions .= " && TransportBill.date <= '$enddtm_order' ";
                }
                $query['conditions'] =  $conditions;
            }
        }else {
            $query['conditions'] = '';
        }
        $this->Session->write('addFromSheetRideConditions', $conditions);
        $query['count'] =
            "SELECT COUNT(*) AS `count` FROM `sheet_ride_detail_rides` AS `SheetRideDetailRides` 
            left JOIN `sheet_rides` AS `SheetRide` ON (`SheetRideDetailRides`.`sheet_ride_id` = `SheetRide`.`id`) 
            left JOIN `car` AS `Car` ON (`SheetRide`.`car_id` = `Car`.`id`) 
            left JOIN `carmodels` AS `Carmodel` ON (`Carmodel`.`id` = `Car`.`carmodel_id`) 
            left JOIN `customers` AS `Customer` ON (`SheetRide`.`customer_id` = `Customer`.`id`) 
            left JOIN `detail_rides` AS `DetailRide` ON (`SheetRideDetailRides`.`detail_ride_id` = `DetailRide`.`id`) 
            left JOIN `car_types` AS `CarType` ON (`SheetRide`.`car_type_id` = `CarType`.`id`) 
            left JOIN `rides` AS `Ride` ON (`DetailRide`.`ride_id` = `Ride`.`id`) 
            left JOIN `suppliers` AS `Supplier` ON (`SheetRideDetailRides`.`supplier_id` = `Supplier`.`id`) 
            left JOIN `suppliers` AS `SupplierFinal` ON (`SheetRideDetailRides`.`supplier_final_id` = `SupplierFinal`.`id`) 
            left JOIN `suppliers` AS `Subcontractor` ON (`SheetRide`.`supplier_id` = `Subcontractor`.`id`) 
            left JOIN `destinations` AS `DepartureDestination` ON (`DepartureDestination`.`id` = `Ride`.`departure_destination_id`) 
            left JOIN `destinations` AS `ArrivalDestination` ON (`ArrivalDestination`.`id` = `Ride`.`arrival_destination_id`) 
            left JOIN `destinations` AS `Departure` ON (`Departure`.`id` = `SheetRideDetailRides`.`departure_destination_id`) 
            left JOIN `destinations` AS `Arrival` ON (`Arrival`.`id` = `SheetRideDetailRides`.`arrival_destination_id`) 
            left JOIN `transport_bill_detail_rides` AS `TransportBillDetailRides` ON (`SheetRideDetailRides`.`transport_bill_detail_ride_id` = `TransportBillDetailRides`.`id`) 
            left JOIN `transport_bills` AS `TransportBill` ON (`TransportBill`.`id` = `TransportBillDetailRides`.`transport_bill_id`) 
            left JOIN `users` AS `User` ON (`TransportBill`.`user_id` = `User`.`id`) 
            left JOIN `services` AS `Service` ON (`TransportBill`.`service_id` = `Service`.`id`) 
            left JOIN `transport_bill_detailed_rides` AS `TransportBillDetailedRides` ON (`TransportBillDetailedRides`.`sheet_ride_id` = `SheetRide`.`id`) 
            WHERE `SheetRideDetailRides`.`status_id` IN (2, 3) AND `SheetRideDetailRides`.`invoiced_ride` = 1  " ;

        $query['detail'] =
            "SELECT `SheetRide`.`reference`, `SheetRide`.`real_start_date`, `SheetRide`.`id`, 
              `SheetRide`.`car_id`,`SheetRide`.`car_name`, `SheetRide`.`car_subcontracting`, 
              `SheetRideDetailRides`.`status_id`, `Subcontractor`.`name`,
            `SheetRideDetailRides`.`reference`, `SheetRideDetailRides`.`type_ride`, 
            `SheetRideDetailRides`.`supplier_id`, `SheetRideDetailRides`.`detail_ride_id`, 
            `SheetRideDetailRides`.`planned_start_date`, `SheetRideDetailRides`.`real_start_date`, 
            `SheetRideDetailRides`.`planned_end_date`, `SheetRideDetailRides`.`real_end_date`, 
            `SheetRideDetailRides`.`id`, `SheetRideDetailRides`.`status_id`, `DepartureDestination`.`name`, 
            `ArrivalDestination`.`name`, `Departure`.`name`, `Arrival`.`name`, `Supplier`.`name`, 
            `SupplierFinal`.`name`, `CarType`.`name`, `Car`.`code`, `Car`.`immatr_def`, `Carmodel`.`name`, 
            `Customer`.`first_name`, `Customer`.`last_name`, `Service`.`name`, `TransportBill`.`date` ,
             CONCAT(`Customer`.`first_name`,' - ', `Customer`.`last_name`) as full_name,
             CONCAT(`Car`.`code` ,' - ', `Carmodel`.`name`) as car_name,
             CONCAT(`DepartureDestination`.`name` ,' - ', `ArrivalDestination`.`name`) as trajet,
             `TransportBillDetailedRides`.`price_ht`,`TransportBill`.`order_type`,`TransportBillDetailedRides`.`delivery_with_return`,
             `TransportBillDetailedRides`.`programming_date`,`TransportBillDetailedRides`.`charging_time`,
             `TransportBillDetailedRides`.`unloading_date`
            FROM `sheet_ride_detail_rides` AS `SheetRideDetailRides` 
            left JOIN `sheet_rides` AS `SheetRide` ON (`SheetRideDetailRides`.`sheet_ride_id` = `SheetRide`.`id`) 
            left JOIN `car` AS `Car` ON (`SheetRide`.`car_id` = `Car`.`id`) 
            left JOIN `carmodels` AS `Carmodel` ON (`Carmodel`.`id` = `Car`.`carmodel_id`) 
            left JOIN `customers` AS `Customer` ON (`SheetRide`.`customer_id` = `Customer`.`id`) 
            left JOIN `detail_rides` AS `DetailRide` ON (`SheetRideDetailRides`.`detail_ride_id` = `DetailRide`.`id`) 
            left JOIN `car_types` AS `CarType` ON (`SheetRide`.`car_type_id` = `CarType`.`id`) 
            left JOIN `rides` AS `Ride` ON (`DetailRide`.`ride_id` = `Ride`.`id`) 
            left JOIN `suppliers` AS `Supplier` ON (`SheetRideDetailRides`.`supplier_id` = `Supplier`.`id`) 
            left JOIN `suppliers` AS `SupplierFinal` ON (`SheetRideDetailRides`.`supplier_final_id` = `SupplierFinal`.`id`) 
            left JOIN `suppliers` AS `Subcontractor` ON (`SheetRide`.`supplier_id` = `Subcontractor`.`id`) 
            left JOIN `destinations` AS `DepartureDestination` ON (`DepartureDestination`.`id` = `Ride`.`departure_destination_id`) 
            left JOIN `destinations` AS `ArrivalDestination` ON (`ArrivalDestination`.`id` = `Ride`.`arrival_destination_id`) 
            left JOIN `destinations` AS `Departure` ON (`Departure`.`id` = `SheetRideDetailRides`.`departure_destination_id`) 
            left JOIN `destinations` AS `Arrival` ON (`Arrival`.`id` = `SheetRideDetailRides`.`arrival_destination_id`) 
            left JOIN `transport_bill_detail_rides` AS `TransportBillDetailRides` ON (`SheetRideDetailRides`.`transport_bill_detail_ride_id` = `TransportBillDetailRides`.`id`) 
            left JOIN `transport_bills` AS `TransportBill` ON (`TransportBill`.`id` = `TransportBillDetailRides`.`transport_bill_id`) 
            left JOIN `users` AS `User` ON (`TransportBill`.`user_id` = `User`.`id`) 
            left JOIN `services` AS `Service` ON (`TransportBill`.`service_id` = `Service`.`id`) 
            left JOIN `transport_bill_detailed_rides` AS `TransportBillDetailedRides` ON (`TransportBillDetailedRides`.`sheet_ride_id` = `SheetRide`.`id`) 
            WHERE `SheetRideDetailRides`.`status_id` IN (2, 3) AND `SheetRideDetailRides`.`invoiced_ride` = 1  ";

        $query['columns'] = array(
                0 => array('SheetRideDetailRides.reference','SheetRideDetailRides', 'reference', 'Reference', 'string',''),
                1 => array('Carmodel.name','0', 'car_name',  'Car', 'string','CONCAT','Carmodel.name','Car.code'),
                2 => array('Customer.first_name','0', 'full_name','Customer', 'string','CONCAT', 'Customer.first_name','Customer.last_name'),
                3 => array('DepartureDestination.name','0', 'trajet',  'Ride', 'string','CONCAT','DepartureDestination.name','ArrivalDestination.name'),
                4 => array('TransportBill.order_type','TransportBill', 'order_type','Order type', 'string',''),
                5 => array('TransportBillDetailedRides.delivery_with_return','TransportBillDetailedRides', 'delivery_with_return','Mission type', 'string',''),
                6 => array('Subcontractor.name','Subcontractor', 'name','Subcontractor', 'string',''),
                7 => array('TransportBillDetailedRides.price_ht','TransportBillDetailedRides', 'price_ht','Price', 'number',''),
                8 => array('Supplier.name','Supplier', 'name','Initial customer', 'string',''),
                9 => array('Service.name','Service', 'name', 'Service', 'string',''),
                10 => array('SheetRideDetailRides.real_start_date','SheetRideDetailRides', 'real_start_date', 'Real Departure date', 'datetime',''),
                11 => array('SheetRide.real_start_date','SheetRide', 'real_start_date', 'SheetRide date', 'datetime',''),
                12 => array('TransportBill.date','TransportBill', 'date', 'Order date', 'datetime',''),
                13 => array('TransportBillDetailedRides.programming_date','TransportBillDetailedRides', 'programming_date', __('Charging date').' / '.__('Unloading date'), 'string','50px'),
                14 => array('SheetRideDetailRides.status_id','SheetRideDetailRides', 'status_id', 'Status', 'number',''),
                );
        $query['order'] = ' SheetRideDetailRides.id desc ';
        $query['tableName'] = 'SheetRideDetailRides';
        $query['controller'] = 'sheetRideDetailRides';
        $query['action'] = 'addFromSheetRide';
        $query['itemName'] = array('reference');
        $this->Session->write('query', $query);
        //get default user limit value
        $defaultLimit =  $this->getLimit();;
        if (isset($defaultLimit) && $defaultLimit > 0) {
            $this->set('defaultLimit', $defaultLimit);
        } else {
            $this->set('defaultLimit', 20);
        }
        $controller =  'transportBillDetailRides';
        $action =  'addFromSheetRide';
        $deleteFonction =  'deleteSheetRideDetailRides/';
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $services = $this->Service->getServices('list');

        $this->set(compact( 'type', 'param','services','controller',
            'deleteFonction','action','conditions'));
    }

    public function listeAddFromSheet($id = null, $keyword = null){

        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $keyword = str_replace('espace', ' ', $keyword);
        $keyword = str_replace('slash', '/', $keyword);
        $keyword = str_replace('tiret', '-', $keyword);
        $keyword = strtolower($keyword);
        switch ($id) {
            case 2 :
                $conditions = array(
                    'SheetRideDetailRides.status_id' => array(2, 3),
                    'SheetRideDetailRides.invoiced_ride' => 1,
                    "LOWER(SheetRideDetailRides.reference) LIKE" => "%$keyword%"
                );
                break;
            case 3 :
                $conditions = array(
                    'SheetRideDetailRides.status_id' => array(2, 3),
                    'SheetRideDetailRides.invoiced_ride' => 1,
                    array(
                        'OR' => array(
                            "LOWER(Car.code) LIKE" => "%$keyword%",
                            "LOWER(Car.immatr_def) LIKE" => "%$keyword%",
                            "LOWER(Carmodel.name) LIKE" => "%$keyword%",
                        )
                    )
                );
                break;
            case 4 :
                $conditions = array(
                    'SheetRideDetailRides.status_id' => array(2, 3),
                    'SheetRideDetailRides.invoiced_ride' => 1,
                    'OR' => array(
                        "LOWER(Customer.first_name) LIKE" => "%$keyword%",
                        "LOWER(Customer.last_name) LIKE" => "%$keyword%",
                    )
                );
                break;
            case 5 :
                $conditions = array(
                    'SheetRideDetailRides.status_id' => array(2, 3),
                    'SheetRideDetailRides.invoiced_ride' => 1,
                    'OR' => array(
                        "LOWER(DepartureDestination.name) LIKE" => "%$keyword%",
                        "LOWER(ArrivalDestination.name) LIKE" => "%$keyword%",
                        "LOWER(Departure.name) LIKE" => "%$keyword%",
                        "LOWER(Arrival.name) LIKE" => "%$keyword%",
                    ));
                break;

            case 6 :
                $conditions = array(
                    'SheetRideDetailRides.status_id' => array(2, 3),
                    'SheetRideDetailRides.invoiced_ride' => 1,
                    "LOWER(Supplier.name) LIKE" => "%$keyword%");
                break;

            case 7 :
                $conditions = array(
                    'SheetRideDetailRides.status_id' => array(2, 3),
                    'SheetRideDetailRides.invoiced_ride' => 1,
                    "LOWER(Service.name) LIKE" => "%$keyword%");
                break;

            case 8 :
                if(!empty($keyword)){
                    $keyword = str_replace("/", "-", $keyword);
                    $start = str_replace("-", "/", $keyword);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $conditions = array(
                        'SheetRideDetailRides.status_id' => array(2, 3),
                        'SheetRideDetailRides.invoiced_ride' => 1,
                        "SheetRideDetailRides.real_start_date >=" => $startdtm->format('Y-m-d 00:00:00'));
                }else {
                    $conditions = array(
                        'SheetRideDetailRides.status_id' => array(2, 3),
                        'SheetRideDetailRides.invoiced_ride' => 1);
                }
                break;
            case 9 :
                $conditions = array(
                    'SheetRideDetailRides.status_id' => array(2, 3),
                    'SheetRideDetailRides.invoiced_ride' => 1,
                    "LOWER(SupplierFinal.name) LIKE" => "%$keyword%");
                break;
            case 10 :
                if(!empty($keyword)){
                    $keyword = str_replace("/", "-", $keyword);
                    $start = str_replace("-", "/", $keyword);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $conditions = array(
                        'SheetRideDetailRides.status_id' => array(2, 3),
                        'SheetRideDetailRides.invoiced_ride' => 1,
                        "SheetRide.real_start_date >=" => $startdtm->format('Y-m-d 00:00:00'));
                }else {
                    $conditions = array(
                        'SheetRideDetailRides.status_id' => array(2, 3),
                        'SheetRideDetailRides.invoiced_ride' => 1);
                }
                break;
            case 11 :
                if(!empty($keyword)){
                    $keyword = str_replace("/", "-", $keyword);
                    $start = str_replace("-", "/", $keyword);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $conditions = array(
                        'SheetRideDetailRides.status_id' => array(2, 3),
                        'SheetRideDetailRides.invoiced_ride' => 1,
                        "TransportBill.date >=" => $startdtm->format('Y-m-d 00:00:00'));
                }else {
                    $conditions = array(
                        'SheetRideDetailRides.status_id' => array(2, 3),
                        'SheetRideDetailRides.invoiced_ride' => 1);
                }

                break;
            default:
                $conditions = array(
                    'SheetRideDetailRides.status_id' => array(2, 3),
                    'SheetRideDetailRides.invoiced_ride' => 1,
                    "LOWER(SheetRideDetailRides.reference) LIKE" => "%$keyword%"
                );
        }

        $sheetRideDetailRides = $this->SheetRideDetailRides->find('all', array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'order' => array(
                'SheetRideDetailRides.real_start_date' => 'ASC',
                'SheetRideDetailRides.id' => 'asc'
            ),
            'conditions' => $conditions,
            'fields' => array(
                'SheetRide.reference',
                'SheetRide.id',
                'SheetRide.real_start_date',
                'SheetRideDetailRides.reference',
                'SheetRideDetailRides.type_ride',
                'SheetRideDetailRides.supplier_id',
                'SheetRideDetailRides.detail_ride_id',
                'SheetRideDetailRides.planned_start_date',
                'SheetRideDetailRides.real_start_date',
                'SheetRideDetailRides.planned_end_date',
                'SheetRideDetailRides.real_end_date',
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.status_id',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Departure.name',
                'Arrival.name',
                'Supplier.name',
                'SupplierFinal.name',
                'CarType.name',
                'Car.code',
                'Car.immatr_def',
                'Carmodel.name',
                'Customer.first_name',
                'Customer.last_name',
                'Service.name',
                'TransportBill.date',
            ),
            'joins' => array(

                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
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
                    'conditions' => array('Carmodel.id = Car.carmodel_id')
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
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('SheetRide.car_type_id = CarType.id')
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
                    'conditions' => array('SheetRideDetailRides.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'SupplierFinal',
                    'conditions' => array('SheetRideDetailRides.supplier_final_id = SupplierFinal.id')
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
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'User',
                    'conditions' => array('TransportBill.user_id = User.id')
                ),


                array(
                    'table' => 'services',
                    'type' => 'left',
                    'alias' => 'Service',
                    'conditions' => array('TransportBill.service_id = Service.id')
                ),
            )
        ));
        $this->set('sheetRideDetailRides', $sheetRideDetailRides);
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set(compact('param'));
    }


    public function addPreinvoice($type = null ,$selectWithPagination = null, $ids = null, $orderType=null )
    {


        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            return $this->redirect('/');
        }
        $conditions = '';
        if($selectWithPagination ==1){
            $addFromSheetRideConditions = $this->Session->read('addFromSheetRideConditions');
            if($type ==  TransportBillTypesEnum::credit_note ){
                $conditions = 'SheetRideDetailRides.status_id = 7 AND SheetRideDetailRides.invoiced_ride = 1  ';
            } else {
                $conditions = 'SheetRideDetailRides.status_id IN (2, 3) AND SheetRideDetailRides.invoiced_ride = 1  ';
            }
            $conditions = $conditions.$addFromSheetRideConditions;
        }
        $arrayIds = explode(",", $ids);
        $this->TransportBill->validate = $this->TransportBill->validate_transform;
        if (!empty($this->request->data)) {
            if ($type == TransportBillTypesEnum::pre_invoice ||
                $type == TransportBillTypesEnum::invoice ||
                $type == TransportBillTypesEnum::credit_note
            ) {
                if($selectWithPagination == 1) {
                    $sheetRideDetailRides = $this->SheetRideDetailRides->getSheetRideDetailRidesByConditions($conditions);
                } else {
                    $conditions = array('SheetRideDetailRides.id' => $arrayIds);
                    $sheetRideDetailRides = $this->SheetRideDetailRides->getSheetRideDetailRidesByConditions($conditions);
                }

                if (!empty($this->request->data['TransportBill']['tva_id'])) {
                    $tvaId = $this->request->data['TransportBill']['tva_id'];
                }else {
                    $tvaId = null;
                }
                if (!empty($this->request->data['TransportBill']['payment_method'])) {
                    $paymentMethod = $this->request->data['TransportBill']['payment_method'];
                }
                if (!empty($this->request->data['TransportBill']['discount_percentage'])) {
                    $discountPercentage = $this->request->data['TransportBill']['discount_percentage'];
                }
                $sheetRideDetailRideIds = array();

                $invoiceIds = array();

                if ($this->request->data['method_transform'] == 2) {

                    foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
                        $sheetRideDetailRideIds[] = $sheetRideDetailRide['SheetRideDetailRides']['id'];
                        $invoiceIds[] = $sheetRideDetailRide['Invoice']['id'];
                        if ($this->request->data['affectation_client'] == 1) {
                            $supplierId = $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'];
                        } else {
                            $supplierId = $this->request->data['TransportBill']['supplier_id'];
                        }
                        $data1[0]['from_customer_order'] = $sheetRideDetailRide['SheetRideDetailRides']['from_customer_order'];

                        if ($sheetRideDetailRide['SheetRideDetailRides']['type_ride'] == 2) {
                            $sheetRide = $this->SheetRide->getSheetRideBySheetRideDetailRideId($sheetRideDetailRide['SheetRideDetailRides']['id']);

                            if($sheetRideDetailRide['SheetRideDetailRides']['source'] == 4){
                                if($sheetRideDetailRide['SheetRideDetailRides']['price']==NULL){
                                    $data1[0]['unit_price'] = 0;
                                } else {
                                    $data1[0]['unit_price'] = $sheetRideDetailRide['SheetRideDetailRides']['price'];
                                }
                               }else {
                                if (!empty($sheetRideDetailRide['TransportBillDetailRides']['unit_price']) && ($sheetRideDetailRide['TransportBillDetailRides']['unit_price'] != 0)) {
                                    $data1[0]['unit_price'] = $sheetRideDetailRide['TransportBillDetailRides']['unit_price'];
                                } else {
                                    $typePricing = $sheetRideDetailRide['SheetRideDetailRides']['type_pricing'];
                                    if ($typePricing == 1) {
                                        $price = $this->getPriceRide(0, 0,
                                            $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['return_mission'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['type_price'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'],
                                            2, $sheetRideDetailRide['SheetRideDetailRides']['departure_destination_id'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['arrival_destination_id'],
                                            $sheetRide['SheetRide']['car_type_id'], $typePricing
                                        );
                                    } else {
                                        $price = $this->getPriceRide(0, 0,
                                            $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['return_mission'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['type_price'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'],
                                            2, $sheetRideDetailRide['SheetRideDetailRides']['departure_destination_id'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['arrival_destination_id'],
                                            $sheetRide['SheetRide']['car_type_id'], $typePricing, $sheetRideDetailRide['SheetRideDetailRides']['tonnage_id']
                                        );
                                    }
                                    if (!empty($price)) {
                                        if ($sheetRideDetailRide['SheetRideDetailRides']['return_mission'] == 1) {
                                            $data1[0]['unit_price'] = $price[0];
                                        } else {
                                            $data1[0]['unit_price'] = $price[2];
                                        }
                                    } else {
                                        $data1[0]['unit_price'] = 0;
                                    }
                                }
                            }
                            $data1[0]['nb_trucks'] = 1;
                            $data1[0]['departure_destination_id'] = $sheetRideDetailRide['SheetRideDetailRides']['departure_destination_id'];
                            $data1[0]['arrival_destination_id'] = $sheetRideDetailRide['SheetRideDetailRides']['arrival_destination_id'];
                            $data1[0]['car_type_id'] = $sheetRide['SheetRide']['car_type_id'];
                            $data1[0]['designation'] = $sheetRideDetailRide['Departure']['name'] . '-' . $sheetRideDetailRide['Arrival']['name'] . '-' . $sheetRide['CarType']['name'];
                            $data1[0]['type_ride'] = 2;
                            $data1[0]['type_pricing'] = $sheetRideDetailRide['SheetRideDetailRides']['type_pricing'];
                            $data1[0]['tonnage_id'] = $sheetRideDetailRide['SheetRideDetailRides']['tonnage_id'];


                            $data1[0]['programming_date'] = date("d/m/Y", strtotime($sheetRideDetailRide['TransportBillDetailRides']['programming_date']) );
                            $data1[0]['charging_time'] = $sheetRideDetailRide['TransportBillDetailRides']['charging_time'];
                            $data1[0]['designation'] = $sheetRideDetailRide['TransportBillDetailRides']['designation'];

                            $data1[0]['unloading_date'] = date("d/m/Y H:i", strtotime($sheetRideDetailRide['TransportBillDetailRides']['unloading_date']) );
                            $data1[0]['product_id'] = 1;
                            $data1[0]['supplier_final_id'] = $sheetRideDetailRide['SheetRideDetailRides']['supplier_final_id'];
                            $data1[0]['ride_category_id'] = $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'];
                            $data1[0]['delivery_with_return'] = $sheetRideDetailRide['SheetRideDetailRides']['return_mission'];
                            $data1[0]['price_ht'] = $data1[0]['unit_price'];
                            if (isset($tvaId) && !empty($tvaId)) {
                                $data1[0]['tva_id'] = $tvaId;
                                $data1[0]['price_ttc'] = $data1[0]['price_ht'] + ($data1[0]['price_ht'] * $this->Tva->getTvaValueById($tvaId));
                            } else {
                                $data1[0]['tva_id'] = 1;
                                $data1[0]['price_ttc'] = $data1[0]['price_ht'] + ($data1[0]['price_ht'] * 0.19);
                            }
                            $data1[0]['sheet_ride_detail_ride_id'] = $sheetRideDetailRide['SheetRideDetailRides']['id'];
                            if($orderType == 2){
                                $data1[0]['approved'] = 1;
                            }else {
                                $data1[0]['approved'] = $type;
                            }
                        } else {
                            if (!empty($sheetRideDetailRide['TransportBillDetailRides']['unit_price']) && ($sheetRideDetailRide['TransportBillDetailRides']['unit_price'] != 0)) {
                                $data1[0]['unit_price'] = $sheetRideDetailRide['TransportBillDetailRides']['unit_price'];
                            } else {
                                $typePricing = $sheetRideDetailRide['SheetRideDetailRides']['type_pricing'];
                                if ($typePricing == 1) {
                                    $price = $this->getPriceRide($sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'], 0,
                                        $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'],
                                        $sheetRideDetailRide['SheetRideDetailRides']['return_mission'],
                                        $sheetRideDetailRide['SheetRideDetailRides']['type_price'],
                                        $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'], 1, null, null, null, $typePricing);
                                } else {
                                    $price = $this->getPriceRide($sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'], 0,
                                        $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'],
                                        $sheetRideDetailRide['SheetRideDetailRides']['return_mission'],
                                        $sheetRideDetailRide['SheetRideDetailRides']['type_price'],
                                        $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'], 1,
                                        null, null, null, $typePricing, $sheetRideDetailRide['SheetRideDetailRides']['tonnage_id']
                                    );
                                }
                                if (!empty($price)) {
                                    if ($sheetRideDetailRide['SheetRideDetailRides']['return_mission'] == 1) {
                                        $data1[0]['unit_price'] = $price[0];
                                    } else {
                                        $data1[0]['unit_price'] = $price[2];
                                    }
                                } else {
                                    $data1[0]['unit_price'] = 0;
                                }
                            }
                            $data1[0]['nb_trucks'] = 1;
                            $data1[0]['detail_ride_id'] = $sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'];
                            $data1[0]['designation'] = $sheetRideDetailRide['DepartureDestination']['name'] . '-' . $sheetRideDetailRide['ArrivalDestination']['name'] . '-' . $sheetRideDetailRide['CarType']['name'];
                            $data1[0]['type_ride'] = 1;
                            $data1[0]['type_pricing'] = $sheetRideDetailRide['SheetRideDetailRides']['type_pricing'];
                            $data1[0]['programming_date'] = date("d/m/Y", strtotime($sheetRideDetailRide['TransportBillDetailRides']['programming_date']) );
                            $data1[0]['charging_time'] = $sheetRideDetailRide['TransportBillDetailRides']['charging_time'];

                            $data1[0]['unloading_date'] = date("d/m/Y H:i", strtotime($sheetRideDetailRide['TransportBillDetailRides']['unloading_date']) );

                            $data1[0]['product_id'] = 1;
                            $data1[0]['supplier_final_id'] = $sheetRideDetailRide['SheetRideDetailRides']['supplier_final_id'];
                            $data1[0]['ride_category_id'] = $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'];
                            $data1[0]['delivery_with_return'] = $sheetRideDetailRide['SheetRideDetailRides']['return_mission'];
                            $data1[0]['ristourne_%'] = $sheetRideDetailRide['TransportBillDetailRides']['ristourne_%'];
                            $data1[0]['designation'] = $sheetRideDetailRide['TransportBillDetailRides']['designation'];
                            if (!empty($sheetRideDetailRide['TransportBillDetailRides']['ristourne_%'])) {
                                $data1[0]['ristourne_val'] = ($sheetRideDetailRide['TransportBillDetailRides']['unit_price'] * $sheetRideDetailRide['TransportBillDetailRides']['ristourne_%']) / 100;
                                $data1[0]['price_ht'] = $sheetRideDetailRide['TransportBillDetailRides']['unit_price'] - $data1[0]['ristourne_val'];
                            } else {
                                $data1[0]['ristourne_val'] = null;
                                $data1[0]['price_ht'] = $data1[0]['unit_price'];
                            }
                            if (!empty($sheetRideDetailRide['TransportBillDetailRides']['tva_id'])) {
                                if (isset($tvaId) && !empty($tvaId)) {
                                    $data1[0]['tva_id'] = $tvaId;
                                    $data1[0]['price_ttc'] = $data1[0]['price_ht'] + ($data1[0]['price_ht'] * $this->Tva->getTvaValueById($tvaId));
                                } else {
                                    $data1[0]['tva_id'] = $sheetRideDetailRide['TransportBillDetailRides']['tva_id'];
                                    $data1[0]['price_ttc'] = $data1[0]['price_ht'] + ($data1[0]['price_ht'] * $this->Tva->getTvaValueById($sheetRideDetailRide['TransportBillDetailRides']['tva_id']));
                                }
                            } else {
                                if (isset($tvaId) && !empty($tvaId)) {
                                    $data1[0]['tva_id'] = $tvaId;
                                    $data1[0]['price_ttc'] = $data1[0]['price_ht'] + ($data1[0]['price_ht'] * $this->Tva->getTvaValueById($tvaId));
                                } else {
                                    $data1[0]['tva_id'] = 1;
                                    $data1[0]['price_ttc'] = $data1[0]['price_ht'] + ($data1[0]['price_ht'] * 0.19);
                                }
                            }
                            $data1[0]['sheet_ride_detail_ride_id'] = $sheetRideDetailRide['SheetRideDetailRides']['id'];
                            if($orderType== 2 ) {
                                $data1[0]['approved'] = 1;
                            } else {
                                $data1[0]['approved'] = $type;
                            }
                        }
                        $totalTva = $data1[0]['price_ttc'] - $data1[0]['price_ht'];
                        $reference = $this->getNextTransportReference( $type);
                        if ($reference != '0') {
                            $data['TransportBill']['reference'] = $reference;
                        }
                        $this->createDateFromDate('TransportBill', 'date');
                        $date = $this->request->data['TransportBill']['date'];
                        if (!empty($date)) {
                            $data['TransportBill']['date'] = $date;
                        } else {
                            $data['TransportBill']['date'] = date("Y-m-d");
                        }
                        $data['TransportBill']['total_ht'] = $data1[0]['price_ht'];
                        $data['TransportBill']['total_ttc'] = $data1[0]['price_ttc'];
                        $data['TransportBill']['total_tva'] = $totalTva;
                        $data['TransportBill']['supplier_id'] = $supplierId;
                        $data['TransportBill']['order_type'] = $orderType;
                        $data['TransportBill']['type'] = $type;
                        $data['TransportBill']['user_id'] = $this->Session->read('Auth.User.id');
                        if($orderType == 2) {
                            $data['TransportBill']['amount_remaining'] = 0;
                            $data['TransportBill']['status_payment'] = 2;
                        } else {
                            $data['TransportBill']['amount_remaining'] = $data['TransportBill']['total_ttc'];
                        }

                        if($type == TransportBillTypesEnum::credit_note){
                            if (count($invoiceIds)== 1){
                                $data['TransportBill']['invoice_id'] = $invoiceIds[0];
                            }
                        }
                        if(isset($discountPercentage)&&!empty($discountPercentage)){
                            $discountValue = $this->calculateDiscountValue($discountPercentage, $data['TransportBill']['total_ht']);
                            $discountTva = $this->calculateDiscountTva($discountPercentage, $data['TransportBill']['total_tva']);
                            $data['TransportBill']['ristourne_val'] = $discountValue;
                            $data['TransportBill']['ristourne_percentage'] = $discountPercentage;
                            $data['TransportBill']['total_ht'] = $data['TransportBill']['total_ht'] - $discountValue;
                            $data['TransportBill']['total_tva'] = $data['TransportBill']['total_tva'] - $discountTva;
                            $data['TransportBill']['total_ttc'] = $data['TransportBill']['total_ht'] + $data['TransportBill']['total_tva'];
                        }
                        if(isset($paymentMethod)&&!empty($paymentMethod)){
                            $stamp = $this->calculateStampValue($paymentMethod, $data['TransportBill']['total_ttc']);
                            $data['TransportBill']['stamp'] = $stamp;
                            $data['TransportBill']['payment_method'] = $paymentMethod;
                            $data['TransportBill']['total_ttc'] = $data['TransportBill']['total_ttc'] + $stamp;
                        }
                        $data['TransportBill']['order_type'] = 1;
                        $this->TransportBill->create();
                        $this->TransportBill->save($data);
                        $transportBillId = $this->TransportBill->getInsertID();
                        // link sheetRide detail to transport bill for deletion purposes
                            $dataToBeSaved['SheetRideDetailRidesTransportBills']
                            ['sheet_ride_detail_ride_id'] = $sheetRideDetailRide['SheetRideDetailRides']['id'];
                            $dataToBeSaved['SheetRideDetailRidesTransportBills']
                            ['transport_bill_id'] = $transportBillId;
                            $this->SheetRideDetailRidesTransportBills->create();
                            $this->SheetRideDetailRidesTransportBills->save($dataToBeSaved);
                        $userId = $this->Auth->user('id');
                        $save = $this->add_Rides_transportBill($data1, $reference, $transportBillId, $userId,
                            $type, null,null);
                        if($save == false ){
                            $this->TransportBill->deleteAll(array('TransportBill.id' => $transportBillId),
                                false);
                            $this->Flash->error(__('The bill could not be saved. Please, try again.'));
                            $this->redirect(array('action' => 'index', $type));
                        }
                        $this->Parameter->setNextTransportReferenceNumber($type);
                        if($type== TransportBillTypesEnum::credit_note){
                            $status = StatusEnum::sheetride_closed;
                            $this->updateMissionsStatusFromBills($sheetRideDetailRideIds, $status);
                        } else {
                            if($orderType == 2){
                               $status =  StatusEnum::mission_invoiced;
                            }else {
                                $status = $type;
                            }
                            $this->updateMissionsStatusFromBills($sheetRideDetailRideIds, $status);
                        }
                    }
                    switch ($type){
                        case TransportBillTypesEnum::pre_invoice :
                            $this->Flash->success(__('The preinvoice has been saved'));
                            break;
                        case TransportBillTypesEnum::invoice :
                            $this->Flash->success(__('The invoice has been saved'));
                            break;
                        case TransportBillTypesEnum::credit_note :
                            $this->Flash->success(__('The credit note has been saved'));
                            break;
                    }

                    $this->redirect(array('action' => 'index', $type));


                }
                else {

                    $total_ht = 0;
                    $total_ttc = 0;
                    $i = 0;
                    $sheetRideDetailRideIds = array();
                    foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
                        $sheetRideDetailRideIds[] = $sheetRideDetailRide['SheetRideDetailRides']['id'];
                        $invoiceIds[] = $sheetRideDetailRide['Invoice']['id'];
                        $unitPriceSheetRideDetailRide =  $this->getUnitPriceByTypeRide($sheetRideDetailRide);
                        $data1[$i] = $this->constructTransportBillDetailRide($sheetRideDetailRide,
                                                                $unitPriceSheetRideDetailRide,$tvaId, $orderType, $type);

                        $total_ht = $total_ht + $data1[$i]['price_ht'];
                        $total_ttc = $total_ttc + $data1[$i]['price_ttc'];
                        $i++;
                    }

                    // die();
                    $totalTva = $total_ttc - $total_ht;
                    if ($this->request->data['affectation_client'] == 1) {
                        $supplierId = $sheetRideDetailRides[0]['SheetRideDetailRides']['supplier_id'];
                    } else {
                        $supplierId = $this->request->data['TransportBill']['supplier_id'];
                    }
                    $supplierFinalId = $sheetRideDetailRides[0]['SheetRideDetailRides']['supplier_final_id'];
                    $reference = $this->getNextTransportReference( $type);
                    if ($reference != '0') {
                        $data['TransportBill']['reference'] = $reference;
                    }
                    $this->createDateFromDate('TransportBill', 'date');
                    $date = $this->request->data['TransportBill']['date'];
                    if (!empty($date)) {
                        $data['TransportBill']['date'] = $date;
                    } else {
                        $data['TransportBill']['date'] = date("Y-m-d");
                    }
                    $data['TransportBill']['total_ht'] = $total_ht;
                    $data['TransportBill']['total_ttc'] = $total_ttc;
                    $data['TransportBill']['total_tva'] = $totalTva;
                    $data['TransportBill']['supplier_id'] = $supplierId;
                    $data['TransportBill']['supplier_final_id'] = $supplierFinalId;
                    $data['TransportBill']['type'] = $type;
                    $data['TransportBill']['order_type'] = $orderType;
                    $data['TransportBill']['user_id'] = $this->Session->read('Auth.User.id');


                    if($type == TransportBillTypesEnum::credit_note){
                        if (count($invoiceIds)== 1){
                            $data['TransportBill']['invoice_id'] = $invoiceIds[0];
                        }
                    }
                    if(isset($discountPercentage)&&!empty($discountPercentage)){
                        $discountValue = $this->calculateDiscountValue($discountPercentage, $data['TransportBill']['total_ht']);
                        $discountTva = $this->calculateDiscountTva($discountPercentage, $data['TransportBill']['total_tva']);
                        $data['TransportBill']['ristourne_val'] = $discountValue;
                        $data['TransportBill']['ristourne_percentage'] = $discountPercentage;
                        $data['TransportBill']['total_ht'] = $data['TransportBill']['total_ht'] - $discountValue;
                        $data['TransportBill']['total_tva'] = $data['TransportBill']['total_tva'] - $discountTva;
                        $data['TransportBill']['total_ttc'] = $data['TransportBill']['total_ht'] + $data['TransportBill']['total_tva'];
                    }
                    if(isset($paymentMethod)&&!empty($paymentMethod)){
                        $stamp = $this->calculateStampValue($paymentMethod, $data['TransportBill']['total_ttc']);
                        $data['TransportBill']['stamp'] = $stamp;
                        $data['TransportBill']['payment_method'] = $paymentMethod;
                        $data['TransportBill']['total_ttc'] = $data['TransportBill']['total_ttc'] + $stamp;
                        $data['TransportBill']['amount_remaining'] = $data['TransportBill']['total_ttc'];
                    }else{
                        $data['TransportBill']['amount_remaining'] = $data['TransportBill']['total_ttc'];
                    }
                    $data['TransportBill']['order_type'] = 1;
                    $this->TransportBill->create();

                    $this->TransportBill->save($data);
                    $transportBillId = $this->TransportBill->getInsertID();

                    foreach ($sheetRideDetailRideIds as $detailRideId){
                        $dataToBeSaved['SheetRideDetailRidesTransportBills']
                        ['sheet_ride_detail_ride_id'] = $detailRideId;
                        $dataToBeSaved['SheetRideDetailRidesTransportBills']
                        ['transport_bill_id'] = $transportBillId;
                        $this->SheetRideDetailRidesTransportBills->create();
                        $this->SheetRideDetailRidesTransportBills->save($dataToBeSaved);
                    }
                    $transportBillDetailRidesOrganized= $this->organiseTransportBillDetailRides($data1, $this->request->data['affectation_client']);
                    $userId = $this->Auth->user('id');
                    $save = $this->add_Rides_transportBill($transportBillDetailRidesOrganized, $reference, $transportBillId, $userId, $type);
                    if($save == false ){
                        $this->TransportBill->deleteAll(array('TransportBill.id' => $transportBillId),
                            false);
                        $this->Flash->error(__('The bill could not be saved. Please, try again.'));
                        $this->redirect(array('action' => 'index', $type));
                    }
                    $this->Parameter->setNextTransportReferenceNumber($type);
                    $this->updateMissionsStatusFromBills($sheetRideDetailRideIds, $type);
                    switch ($type){
                        case TransportBillTypesEnum::pre_invoice :
                            $this->Flash->success(__('The preinvoice has been saved'));
                            break;
                        case TransportBillTypesEnum::invoice :
                            $this->Flash->success(__('The invoice has been saved'));
                            break;
                        case TransportBillTypesEnum::credit_note :
                            $this->Flash->success(__('The credit note has been saved'));
                            break;
                    }
                    $this->redirect(array('action' => 'index', $type));
                }
            }
        }
        $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
        $tvas = $this->Tva->getTvas();
        $this->set(compact('suppliers', 'arrayIds', 'tvas'));


    }
    public function addCreditNote($type = null ,$selectWithPagination = null, $ids = null )
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            return $this->redirect('/');
        }
        $conditions = '';
        if($selectWithPagination ==1){
            $addFromMissionsInvoicedConditions = $this->Session->read('addFromMissionsInvoiceConditions');
            $conditions = 'SheetRideDetailRides.status_id =7 AND SheetRideDetailRides.invoiced_ride = 1  ';
            $conditions = $conditions.$addFromMissionsInvoicedConditions;
        }
        $arrayIds = explode(",", $ids);
        $this->TransportBill->validate = $this->TransportBill->validate_transform;
        if (!empty($this->request->data)) {
            if ($type == TransportBillTypesEnum::pre_invoice || $type == TransportBillTypesEnum::invoice) {

                if($selectWithPagination == 1) {
                    $sheetRideDetailRides = $this->SheetRideDetailRides->find('all', array(
                        'order' => array('SheetRideDetailRides.reference' => 'DESC'),
                        'recursive' => -1,
                        'conditions' => $conditions,
                        'fields' => array(
                            'SheetRideDetailRides.id',
                            'SheetRideDetailRides.from_customer_order',
                            'SheetRideDetailRides.type_ride',
                            'SheetRideDetailRides.type_pricing',
                            'SheetRideDetailRides.tonnage_id',
                            'SheetRideDetailRides.supplier_id',
                            'SheetRideDetailRides.supplier_final_id',
                            'SheetRideDetailRides.return_mission',
                            'SheetRideDetailRides.type_price',
                            'SheetRideDetailRides.detail_ride_id',
                            'SheetRideDetailRides.departure_destination_id',
                            'SheetRideDetailRides.arrival_destination_id',
                            'SheetRideDetailRides.price',
                            'SheetRideDetailRides.source',
                            'SheetRideDetailRides.status_id',
                            'SheetRideDetailRides.ride_category_id',
                            'TransportBillDetailRides.id',
                            'TransportBillDetailRides.unit_price',
                            'TransportBillDetailRides.tva_id',
                            'TransportBillDetailRides.ristourne_%',
                            'TransportBillDetailRides.ristourne_val',
                            'DepartureDestination.name',
                            'ArrivalDestination.name',
                            'Departure.name',
                            'Arrival.name',
                            'CarType.name',
                        ),
                        'joins' => array(
                            array(
                                'table' => 'transport_bill_detail_rides',
                                'type' => 'left',
                                'alias' => 'TransportBillDetailRides',
                                'conditions' => array('SheetRideDetailRides.transport_bill_detail_ride_id = TransportBillDetailRides.id')
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
                                'table' => 'car_types',
                                'type' => 'left',
                                'alias' => 'CarType',
                                'conditions' => array('DetailRide.car_type_id = CarType.id')
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
                                'table' => 'transport_bills',
                                'type' => 'left',
                                'alias' => 'TransportBill',
                                'conditions' => array('TransportBill.id = TransportBillDetailRides.transport_bill_id')
                            ),
                            array(
                                'table' => 'users',
                                'type' => 'left',
                                'alias' => 'User',
                                'conditions' => array('TransportBill.user_id = User.id')
                            ),

                            array(
                                'table' => 'services',
                                'type' => 'left',
                                'alias' => 'Service',
                                'conditions' => array('TransportBill.service_id = Service.id')
                            ),
                        ),

                    ));


                } else {
                    $sheetRideDetailRides = $this->SheetRideDetailRides->find('all', array(
                        'order' => array('SheetRideDetailRides.reference' => 'DESC'),
                        'recursive' => -1,
                        'conditions' => array('SheetRideDetailRides.id' => $arrayIds),
                        'fields' => array(
                            'SheetRideDetailRides.id',
                            'SheetRideDetailRides.from_customer_order',
                            'SheetRideDetailRides.type_ride',
                            'SheetRideDetailRides.type_pricing',
                            'SheetRideDetailRides.tonnage_id',
                            'SheetRideDetailRides.supplier_id',
                            'SheetRideDetailRides.supplier_final_id',
                            'SheetRideDetailRides.return_mission',
                            'SheetRideDetailRides.type_price',
                            'SheetRideDetailRides.detail_ride_id',
                            'SheetRideDetailRides.departure_destination_id',
                            'SheetRideDetailRides.arrival_destination_id',
                            'SheetRideDetailRides.price',
                            'SheetRideDetailRides.source',
                            'SheetRideDetailRides.id',
                            'SheetRideDetailRides.status_id',
                            'SheetRideDetailRides.ride_category_id',
                            'TransportBillDetailRides.id',
                            'TransportBillDetailRides.unit_price',
                            'TransportBillDetailRides.tva_id',
                            'TransportBillDetailRides.ristourne_%',
                            'TransportBillDetailRides.ristourne_val',
                            'DepartureDestination.name',
                            'ArrivalDestination.name',
                            'Departure.name',
                            'Arrival.name',
                            'CarType.name',

                        ),
                        'joins' => array(
                            array(
                                'table' => 'transport_bill_detail_rides',
                                'type' => 'left',
                                'alias' => 'TransportBillDetailRides',
                                'conditions' => array('SheetRideDetailRides.transport_bill_detail_ride_id = TransportBillDetailRides.id')
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
                                'table' => 'car_types',
                                'type' => 'left',
                                'alias' => 'CarType',
                                'conditions' => array('DetailRide.car_type_id = CarType.id')
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
                        ),

                    ));
                }

                if (!empty($this->request->data['TransportBill']['tva_id'])) {
                    $tvaId = $this->request->data['TransportBill']['tva_id'];
                }
                $sheetRideDetailRideIds = array();
                if ($this->request->data['method_transform'] == 2) {
                    foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
                        $sheetRideDetailRideIds[] = $sheetRideDetailRide['SheetRideDetailRides']['id'];
                        if ($this->request->data['affectation_client'] == 1) {
                            $supplierId = $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'];
                        } else {
                            $supplierId = $this->request->data['TransportBill']['supplier_id'];
                        }
                        $data1[0]['from_customer_order'] = $sheetRideDetailRide['SheetRideDetailRides']['from_customer_order'];
                        if ($sheetRideDetailRide['SheetRideDetailRides']['type_ride'] == 2) {
                            $sheetRide = $this->SheetRide->find('first',
                                array(
                                    'recursive' => -1,
                                    'fields' => array('SheetRide.car_type_id', 'CarType.name'),
                                    'conditions' => array('SheetRideDetailRides.id' => $sheetRideDetailRide['SheetRideDetailRides']['id']),
                                    'joins' => array(
                                        array(
                                            'table' => 'sheet_ride_detail_rides',
                                            'type' => 'left',
                                            'alias' => 'SheetRideDetailRides',
                                            'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                                        ),
                                        array(
                                            'table' => 'car_types',
                                            'type' => 'left',
                                            'alias' => 'CarType',
                                            'conditions' => array('SheetRide.car_type_id = CarType.id')
                                        ),
                                    )
                                ));
                            if($sheetRideDetailRide['SheetRideDetailRides']['source'] == 4){
                                if($sheetRideDetailRide['SheetRideDetailRides']['price']==NULL){
                                    $data1[0]['unit_price'] = 0;
                                } else {
                                    $data1[0]['unit_price'] = $sheetRideDetailRide['SheetRideDetailRides']['price'];
                                }
                               }else {

                                if (!empty($sheetRideDetailRide['TransportBillDetailRides']['unit_price']) && ($sheetRideDetailRide['TransportBillDetailRides']['unit_price'] != 0)) {
                                    $data1[0]['unit_price'] = $sheetRideDetailRide['TransportBillDetailRides']['unit_price'];
                                } else {
                                    $typePricing = $sheetRideDetailRide['SheetRideDetailRides']['type_pricing'];
                                    if ($typePricing == 1) {
                                        $price = $this->getPriceRide(0, 0,
                                            $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['return_mission'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['type_price'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'],
                                            2, $sheetRideDetailRide['SheetRideDetailRides']['departure_destination_id'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['arrival_destination_id'],
                                            $sheetRide['SheetRide']['car_type_id'], $typePricing
                                        );
                                    } else {
                                        $price = $this->getPriceRide(0, 0,
                                            $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['return_mission'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['type_price'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'],
                                            2, $sheetRideDetailRide['SheetRideDetailRides']['departure_destination_id'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['arrival_destination_id'],
                                            $sheetRide['SheetRide']['car_type_id'], $typePricing, $sheetRideDetailRide['SheetRideDetailRides']['tonnage_id']
                                        );
                                    }
                                    if (!empty($price)) {
                                        if ($sheetRideDetailRide['SheetRideDetailRides']['return_mission'] == 1) {
                                            $data1[0]['unit_price'] = $price[0];
                                        } else {
                                            $data1[0]['unit_price'] = $price[2];
                                        }
                                    } else {
                                        $data1[0]['unit_price'] = 0;
                                    }
                                }

                            }

                            $data1[0]['nb_trucks'] = 1;
                            $data1[0]['departure_destination_id'] = $sheetRideDetailRide['SheetRideDetailRides']['departure_destination_id'];
                            $data1[0]['arrival_destination_id'] = $sheetRideDetailRide['SheetRideDetailRides']['arrival_destination_id'];
                            $data1[0]['car_type_id'] = $sheetRide['SheetRide']['car_type_id'];
                            $data1[0]['designation'] = $sheetRideDetailRide['Departure']['name'] . '-' . $sheetRideDetailRide['Arrival']['name'] . '-' . $sheetRide['CarType']['name'];
                            $data1[0]['type_ride'] = 2;
                            $data1[0]['type_pricing'] = $sheetRideDetailRide['SheetRideDetailRides']['type_pricing'];
                            $data1[0]['tonnage_id'] = $sheetRideDetailRide['SheetRideDetailRides']['tonnage_id'];
                            $data1[0]['product_id'] = 1;
                            $data1[0]['supplier_final_id'] = $sheetRideDetailRide['SheetRideDetailRides']['supplier_final_id'];
                            $data1[0]['ride_category_id'] = $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'];
                            $data1[0]['delivery_with_return'] = $sheetRideDetailRide['SheetRideDetailRides']['return_mission'];
                            $data1[0]['price_ht'] = $data1[0]['unit_price'];
                            if (isset($tvaId) && !empty($tvaId)) {
                                $data1[0]['tva_id'] = $tvaId;
                                $data1[0]['price_ttc'] = $data1[0]['price_ht'] + ($data1[0]['price_ht'] * $this->Tva->getTvaValueById($tvaId));
                            } else {
                                $data1[0]['tva_id'] = 1;
                                $data1[0]['price_ttc'] = $data1[0]['price_ht'] + ($data1[0]['price_ht'] * 0.19);
                            }
                            $data1[0]['sheet_ride_detail_ride_id'] = $sheetRideDetailRide['SheetRideDetailRides']['id'];
                            $data1[0]['approved'] = $type;

                        } else {
                            if (!empty($sheetRideDetailRide['TransportBillDetailRides']['unit_price']) && ($sheetRideDetailRide['TransportBillDetailRides']['unit_price'] != 0)) {
                                $data1[0]['unit_price'] = $sheetRideDetailRide['TransportBillDetailRides']['unit_price'];
                            } else {
                                $typePricing = $sheetRideDetailRide['SheetRideDetailRides']['type_pricing'];

                                if ($typePricing == 1) {
                                    $price = $this->getPriceRide($sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'], 0,
                                        $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'],
                                        $sheetRideDetailRide['SheetRideDetailRides']['return_mission'],
                                        $sheetRideDetailRide['SheetRideDetailRides']['type_price'],
                                        $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'], 1, null, null, null, $typePricing);
                                } else {
                                    $price = $this->getPriceRide($sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'], 0,
                                        $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'],
                                        $sheetRideDetailRide['SheetRideDetailRides']['return_mission'],
                                        $sheetRideDetailRide['SheetRideDetailRides']['type_price'],
                                        $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'], 1,
                                        null, null, null, $typePricing, $sheetRideDetailRide['SheetRideDetailRides']['tonnage_id']
                                    );
                                }
                                if (!empty($price)) {
                                    if ($sheetRideDetailRide['SheetRideDetailRides']['return_mission'] == 1) {
                                        $data1[0]['unit_price'] = $price[0];
                                    } else {
                                        $data1[0]['unit_price'] = $price[2];
                                    }
                                } else {
                                    $data1[0]['unit_price'] = 0;
                                }
                            }
                            $data1[0]['nb_trucks'] = 1;
                            $data1[0]['detail_ride_id'] = $sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'];
                            $data1[0]['designation'] = $sheetRideDetailRide['DepartureDestination']['name'] . '-' . $sheetRideDetailRide['ArrivalDestination']['name'] . '-' . $sheetRideDetailRide['CarType']['name'];
                            $data1[0]['type_ride'] = 1;
                            $data1[0]['type_pricing'] = $sheetRideDetailRide['SheetRideDetailRides']['type_pricing'];
                            $data1[0]['product_id'] = 1;
                            $data1[0]['supplier_final_id'] = $sheetRideDetailRide['SheetRideDetailRides']['supplier_final_id'];
                            $data1[0]['ride_category_id'] = $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'];
                            $data1[0]['delivery_with_return'] = $sheetRideDetailRide['SheetRideDetailRides']['return_mission'];
                            $data1[0]['ristourne_%'] = $sheetRideDetailRide['TransportBillDetailRides']['ristourne_%'];
                            if (!empty($sheetRideDetailRide['TransportBillDetailRides']['ristourne_%'])) {
                                $data1[0]['ristourne_val'] = ($sheetRideDetailRide['TransportBillDetailRides']['unit_price'] * $sheetRideDetailRide['TransportBillDetailRides']['ristourne_%']) / 100;
                                $data1[0]['price_ht'] = $sheetRideDetailRide['TransportBillDetailRides']['unit_price'] - $data1[0]['ristourne_val'];
                            } else {
                                $data1[0]['ristourne_val'] = null;
                                $data1[0]['price_ht'] = $data1[0]['unit_price'];
                            }
                            if (!empty($sheetRideDetailRide['TransportBillDetailRides']['tva_id'])) {
                                if (isset($tvaId) && !empty($tvaId)) {
                                    $data1[0]['tva_id'] = $tvaId;
                                    $data1[0]['price_ttc'] = $data1[0]['price_ht'] + ($data1[0]['price_ht'] * $this->Tva->getTvaValueById($tvaId));
                                } else {
                                    $data1[0]['tva_id'] = $sheetRideDetailRide['TransportBillDetailRides']['tva_id'];
                                    $data1[0]['price_ttc'] = $data1[0]['price_ht'] + ($data1[0]['price_ht'] * $this->Tva->getTvaValueById($sheetRideDetailRide['TransportBillDetailRides']['tva_id']));
                                }
                            } else {
                                if (isset($tvaId) && !empty($tvaId)) {
                                    $data1[0]['tva_id'] = $tvaId;
                                    $data1[0]['price_ttc'] = $data1[0]['price_ht'] + ($data1[0]['price_ht'] * $this->Tva->getTvaValueById($tvaId));
                                } else {
                                    $data1[0]['tva_id'] = 1;
                                    $data1[0]['price_ttc'] = $data1[0]['price_ht'] + ($data1[0]['price_ht'] * 0.19);
                                }
                            }
                            $data1[0]['sheet_ride_detail_ride_id'] = $sheetRideDetailRide['SheetRideDetailRides']['id'];
                            $data1[0]['approved'] = $type;
                        }
                        $totalTva = $data1[0]['price_ttc'] - $data1[0]['price_ht'];
                        $reference = $this->getNextTransportReference( $type);
                        if ($reference != '0') {
                            $data['TransportBill']['reference'] = $reference;
                        }
                        $this->createDateFromDate('TransportBill', 'date');
                        $date = $this->request->data['TransportBill']['date'];
                        if (!empty($date)) {
                            $data['TransportBill']['date'] = $date;
                        } else {
                            $data['TransportBill']['date'] = date("Y-m-d");
                        }
                        $data['TransportBill']['total_ht'] = $data1[0]['price_ht'];
                        $data['TransportBill']['total_ttc'] = $data1[0]['price_ttc'];
                        $data['TransportBill']['total_tva'] = $totalTva;
                        $data['TransportBill']['supplier_id'] = $supplierId;
                        $data['TransportBill']['type'] = $type;
                        $data['TransportBill']['user_id'] = $this->Session->read('Auth.User.id');
                        $data['TransportBill']['amount_remaining'] = $data['TransportBill']['total_ttc'];
                        $this->TransportBill->create();
                        $this->TransportBill->save($data);

                        $transportBillId = $this->TransportBill->getInsertID();
                        $userId = $this->Auth->user('id');
                        $save = $this->add_Rides_transportBill($data1, $reference, $transportBillId, $userId, $type);
                        if($save == false ){
                            $this->TransportBill->deleteAll(array('TransportBill.id' => $transportBillId),
                                false);
                            $this->Flash->error(__('The bill could not be saved. Please, try again.'));
                            $this->redirect(array('action' => 'index', $type));
                        }
                        $this->Parameter->setNextTransportReferenceNumber($type);
                        $this->updateMissionsStatusFromBills($sheetRideDetailRideIds, $type);
                    }
                    if ($type == 4) {
                        $this->Flash->success(__('The preinvoice has been saved'));
                    } else {
                        $this->Flash->success(__('The invoice has been saved'));
                    }
                    $this->redirect(array('action' => 'index', $type));


                }
                else {
                    $total_ht = 0;
                    $total_ttc = 0;
                    $i = 0;
                    $sheetRideDetailRideIds = array();
                    foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
                        $sheetRideDetailRideIds[] = $sheetRideDetailRide['SheetRideDetailRides']['id'];
                        $data1[$i]['from_customer_order'] = $sheetRideDetailRide['SheetRideDetailRides']['from_customer_order'];
                        if ($sheetRideDetailRide['SheetRideDetailRides']['type_ride'] == 2) {
                            $sheetRide = $this->SheetRide->find('first',
                                array(
                                    'recursive' => -1,
                                    'fields' => array('SheetRide.car_type_id', 'CarType.name'),
                                    'conditions' => array('SheetRideDetailRides.id' => $sheetRideDetailRide['SheetRideDetailRides']['id']),
                                    'joins' => array(
                                        array(
                                            'table' => 'sheet_ride_detail_rides',
                                            'type' => 'left',
                                            'alias' => 'SheetRideDetailRides',
                                            'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                                        ),
                                        array(
                                            'table' => 'car_types',
                                            'type' => 'left',
                                            'alias' => 'CarType',
                                            'conditions' => array('SheetRide.car_type_id = CarType.id')
                                        ),
                                    )
                                ));
                            if ($sheetRideDetailRide['SheetRideDetailRides']['source'] == 4) {
                                if($sheetRideDetailRide['SheetRideDetailRides']['price']==NULL){
                                    $data1[0]['unit_price'] = 0;
                                } else {
                                    $data1[0]['unit_price'] = $sheetRideDetailRide['SheetRideDetailRides']['price'];
                                }
                            }else {
                                if (!empty($sheetRideDetailRide['TransportBillDetailRides']['unit_price']) && ($sheetRideDetailRide['TransportBillDetailRides']['unit_price'] != 0)) {
                                    $data1[$i]['unit_price'] = $sheetRideDetailRide['TransportBillDetailRides']['unit_price'];
                                } else {

                                    $typePricing = $sheetRideDetailRide['SheetRideDetailRides']['type_pricing'];

                                    if ($typePricing == 1) {
                                        $price = $this->getPriceRide(0, 0,
                                            $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['return_mission'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['type_price'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'],
                                            2, $sheetRideDetailRide['SheetRideDetailRides']['departure_destination_id'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['arrival_destination_id'],
                                            $sheetRide['SheetRide']['car_type_id'], 1
                                        );
                                    } else {
                                        $price = $this->getPriceRide(0, 0,
                                            $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['return_mission'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['type_price'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'],
                                            2, $sheetRideDetailRide['SheetRideDetailRides']['departure_destination_id'],
                                            $sheetRideDetailRide['SheetRideDetailRides']['arrival_destination_id'],
                                            $sheetRide['SheetRide']['car_type_id'], 2, $sheetRideDetailRide['SheetRideDetailRides']['tonnage_id']
                                        );
                                    }

                                    if (!empty($price)) {
                                        if ($sheetRideDetailRide['SheetRideDetailRides']['return_mission'] == 1) {

                                            $data1[$i]['unit_price'] = $price[0];
                                        } else {

                                            $data1[$i]['unit_price'] = $price[2];
                                        }

                                    } else {
                                        $data1[$i]['unit_price'] = 0;
                                    }
                                }
                            }

                            $data1[$i]['nb_trucks'] = 1;
                            $data1[$i]['departure_destination_id'] = $sheetRideDetailRide['SheetRideDetailRides']['departure_destination_id'];
                            $data1[$i]['arrival_destination_id'] = $sheetRideDetailRide['SheetRideDetailRides']['arrival_destination_id'];
                            $data1[$i]['car_type_id'] = $sheetRide['SheetRide']['car_type_id'];
                            $data1[$i]['designation'] = $sheetRideDetailRide['Departure']['name'] . '-' . $sheetRideDetailRide['Arrival']['name'] . '-' . $sheetRide['CarType']['name'];
                            $data1[$i]['type_ride'] = 2;
                            $data1[$i]['type_pricing'] = $sheetRideDetailRide['SheetRideDetailRides']['type_pricing'];
                            $data1[$i]['tonnage_id'] = $sheetRideDetailRide['SheetRideDetailRides']['tonnage_id'];
                            $data1[$i]['product_id'] = 1;
                            $data1[$i]['supplier_final_id'] = $sheetRideDetailRide['SheetRideDetailRides']['supplier_final_id'];
                            $data1[$i]['ride_category_id'] = $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'];
                            $data1[$i]['delivery_with_return'] = $sheetRideDetailRide['SheetRideDetailRides']['return_mission'];
                            $data1[$i]['price_ht'] = $data1[$i]['unit_price'];
                            if (isset($tvaId) && !empty($tvaId)) {
                                $data1[$i]['tva_id'] = $tvaId;
                            } else {
                                $data1[$i]['tva_id'] = 1;
                            }
                            $data1[$i]['price_ttc'] = $data1[$i]['price_ht'] + ($data1[$i]['price_ht'] * $this->Tva->getTvaValueById($data1[$i]['tva_id']));
                            $data1[$i]['sheet_ride_detail_ride_id'] = $sheetRideDetailRide['SheetRideDetailRides']['id'];
                            if (TransportBillTypesEnum::pre_invoice) {
                                $data1[$i]['approved'] = $type;
                            }
                        } else {

                            if (!empty($sheetRideDetailRide['TransportBillDetailRides']['unit_price']) && ($sheetRideDetailRide['TransportBillDetailRides']['unit_price'] != 0)) {
                                $data1[$i]['unit_price'] = $sheetRideDetailRide['TransportBillDetailRides']['unit_price'];
                            } else {
                                $typePricing = $sheetRideDetailRide['SheetRideDetailRides']['type_pricing'];

                                if ($typePricing == 1) {
                                    $price = $this->getPriceRide($sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'],
                                        0,
                                        $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'],
                                        $sheetRideDetailRide['SheetRideDetailRides']['return_mission'],
                                        $sheetRideDetailRide['SheetRideDetailRides']['type_price'],
                                        $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'],
                                        null, null, null, 1);
                                } else {
                                    $price = $this->getPriceRide($sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'],
                                        0,
                                        $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'],
                                        $sheetRideDetailRide['SheetRideDetailRides']['return_mission'],
                                        $sheetRideDetailRide['SheetRideDetailRides']['type_price'],
                                        $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'],
                                        null, null, null, 2, $sheetRideDetailRide['SheetRideDetailRides']['tonnage_id']
                                    );
                                }
                                if (!empty($price)) {
                                    if ($sheetRideDetailRide['SheetRideDetailRides']['return_mission'] == 1) {

                                        $data1[$i]['unit_price'] = $price[0];
                                    } else {

                                        $data1[$i]['unit_price'] = $price[2];
                                    }

                                } else {
                                    $data1[$i]['unit_price'] = 0;
                                }
                            }
                            $data1[$i]['nb_trucks'] = 1;
                            $data1[$i]['type_ride'] = 1;
                            $data1[$i]['type_pricing'] = $sheetRideDetailRide['SheetRideDetailRides']['type_pricing'];
                            $data1[$i]['tonnage_id'] = $sheetRideDetailRide['SheetRideDetailRides']['tonnage_id'];
                            $data1[$i]['product_id'] = 1;
                            $data1[$i]['detail_ride_id'] = $sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'];
                            $data1[$i]['designation'] = $sheetRideDetailRide['DepartureDestination']['name'] . '-' . $sheetRideDetailRide['ArrivalDestination']['name'] . '-' . $sheetRideDetailRide['CarType']['name'];
                            $data1[$i]['supplier_final_id'] = $sheetRideDetailRide['SheetRideDetailRides']['supplier_final_id'];
                            $data1[$i]['ride_category_id'] = $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'];
                            $data1[$i]['delivery_with_return'] = $sheetRideDetailRide['SheetRideDetailRides']['return_mission'];
                            $data1[$i]['ristourne_%'] = $sheetRideDetailRide['TransportBillDetailRides']['ristourne_%'];
                            if (!empty($sheetRideDetailRide['TransportBillDetailRides']['ristourne_%'])) {
                                $data1[$i]['ristourne_val'] = ($sheetRideDetailRide['TransportBillDetailRides']['unit_price'] * $sheetRideDetailRide['TransportBillDetailRides']['ristourne_%']) / 100;
                                $data1[$i]['price_ht'] = $sheetRideDetailRide['TransportBillDetailRides']['unit_price'] - $data1[$i]['ristourne_val'];

                            } else {
                                $data1[$i]['ristourne_val'] = null;
                                $data1[$i]['price_ht'] = $data1[$i]['unit_price'];
                            }

                            if (!empty($sheetRideDetailRide['TransportBillDetailRides']['tva_id'])) {
                                if (isset($tvaId) && !empty($tvaId)) {
                                    $data1[$i]['tva_id'] = $tvaId;
                                } else {
                                    $data1[$i]['tva_id'] = $sheetRideDetailRide['TransportBillDetailRides']['tva_id'];
                                }

                                $data1[$i]['price_ttc'] = $data1[$i]['price_ht'] + ($data1[$i]['price_ht'] * $this->Tva->getTvaValueById($data1[$i]['tva_id']));
                            } else {
                                if (isset($tvaId) && !empty($tvaId)) {

                                    $data1[$i]['tva_id'] = $tvaId;

                                } else {
                                    $data1[$i]['tva_id'] = 1;
                                }

                                $data1[$i]['price_ttc'] = $data1[$i]['price_ht'] + ($data1[$i]['price_ht'] * $this->Tva->getTvaValueById($data1[$i]['tva_id']));
                            }
                            $data1[$i]['sheet_ride_detail_ride_id'] = $sheetRideDetailRide['SheetRideDetailRides']['id'];

                            if (TransportBillTypesEnum::pre_invoice) {
                                $data1[$i]['approved'] = $type;
                            }
                        }
                        $total_ht = $total_ht + $data1[$i]['price_ht'];
                        $total_ttc = $total_ttc + $data1[$i]['price_ttc'];
                        $i++;
                    }

                    // die();
                    $totalTva = $total_ttc - $total_ht;
                    if ($this->request->data['affectation_client'] == 1) {
                        $supplierId = $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'];
                    } else {
                        $supplierId = $this->request->data['TransportBill']['supplier_id'];
                    }
                    $supplierFinalId = $sheetRideDetailRide['SheetRideDetailRides']['supplier_final_id'];
                    $reference = $this->getNextTransportReference( $type);
                    if ($reference != '0') {
                        $data['TransportBill']['reference'] = $reference;
                    }
                    $this->createDateFromDate('TransportBill', 'date');
                    $date = $this->request->data['TransportBill']['date'];
                    if (!empty($date)) {
                        $data['TransportBill']['date'] = $date;
                    } else {
                        $data['TransportBill']['date'] = date("Y-m-d");
                    }
                    $data['TransportBill']['total_ht'] = $total_ht;
                    $data['TransportBill']['total_ttc'] = $total_ttc;
                    $data['TransportBill']['total_tva'] = $totalTva;
                    $data['TransportBill']['supplier_id'] = $supplierId;
                    $data['TransportBill']['supplier_final_id'] = $supplierFinalId;
                    $data['TransportBill']['type'] = $type;
                    $data['TransportBill']['user_id'] = $this->Session->read('Auth.User.id');
                    $data['TransportBill']['amount_remaining'] = $data['TransportBill']['total_ttc'];
                    $this->TransportBill->create();
                    $this->TransportBill->save($data);
                    $transportBillId = $this->TransportBill->getInsertID();
                    $save = $this->add_Rides_transportBill($data1, $reference, $transportBillId, $userId, $type);
                    if($save == false ){
                        $this->TransportBill->deleteAll(array('TransportBill.id' => $transportBillId),
                            false);
                        $this->Flash->error(__('The bill could not be saved. Please, try again.'));
                        $this->redirect(array('action' => 'index', $type));
                    }
                    $this->Parameter->setNextTransportReferenceNumber($type);

                    $this->updateMissionsStatusFromBills($sheetRideDetailRideIds, $type);

                    if ($type == 4) {
                        $this->Flash->success(__('The preinvoice has been saved'));
                    } else {
                        $this->Flash->success(__('The invoice has been saved'));
                    }


                    $this->redirect(array('action' => 'index', $type));
                }
            }
        }
        $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
        $tvas = $this->Tva->getTvas();
        $this->set(compact('suppliers', 'arrayIds', 'tvas'));


    }




    public function updateMissionsStatusFromBills($sheetRideDetailRideIds = null, $type = null)
    {

    $this->SheetRideDetailRides->updateAll(
            array('SheetRideDetailRides.status_id' => $type),
            array('SheetRideDetailRides.id' => $sheetRideDetailRideIds)
        );
    }

    public function addFromPreinvoice()
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();

        $conditions = '';
        if ($this->request->is('post')) {
            if (
                isset($this->request->data['transportBills']['supplier_id']) ||
                isset($this->request->data['transportBills']['detail_ride_id']) ||
                isset($this->request->data['transportBills']['date_from']) ||
                isset($this->request->data['transportBills']['date_to'])
            ) {

                $supplier = $this->request->data['transportBills']['supplier_id'];
                $detailRide = $this->request->data['transportBills']['detail_ride_id'];

                $date_from_mission = str_replace("/", "-", $this->request->data['transportBills']['date_from']);
                $date_to_mission = str_replace("/", "-", $this->request->data['transportBills']['date_to']);

                if (!empty($supplier)) {
                    $conditions .= " && SheetRideDetailRides.supplier_id = $supplier  ";
                }

                if (!empty($detailRide)) {
                    $conditions .= " && SheetRideDetailRides.detail_ride_id = $detailRide  ";
                }
                if (!empty($date_from_mission)) {
                    $start_mission = str_replace("-", "/", $date_from_mission);
                    $startdtm_mission = DateTime::createFromFormat('d/m/Y', $start_mission);
                    $startdtm_mission = $startdtm_mission->format('Y-m-d 00:00:00');
                    $conditions .= " && SheetRideDetailRides.real_start_date >= '$startdtm_mission' ";
                }
                if (!empty($date_to_mission)) {
                    $end_mission = str_replace("-", "/", $date_to_mission);
                    $enddtm_mission = DateTime::createFromFormat('d/m/Y', $end_mission);
                    $enddtm_mission = $enddtm_mission->format('Y-m-d 23:59:00');
                    $conditions .= " && SheetRideDetailRides.real_start_date <= '$enddtm_mission' ";
                }
                $query['conditions'] =  $conditions;

            }
        }else {
            $query['conditions'] = '';
        }


        $this->Session->write('addFromPreinvoiceConditions', $conditions);

        $query['count'] =
            "SELECT COUNT(*) AS `count`  FROM `sheet_ride_detail_rides` AS `SheetRideDetailRides` 
            left JOIN `sheet_rides` AS `SheetRide` ON (`SheetRideDetailRides`.`sheet_ride_id` = `SheetRide`.`id`) 
            left JOIN `detail_rides` AS `DetailRide` ON (`SheetRideDetailRides`.`detail_ride_id` = `DetailRide`.`id`) 
            left JOIN `car_types` AS `CarType` ON (`SheetRide`.`car_type_id` = `CarType`.`id`) 
            left JOIN `rides` AS `Ride` ON (`DetailRide`.`ride_id` = `Ride`.`id`) 
            left JOIN `suppliers` AS `Supplier` ON (`SheetRideDetailRides`.`supplier_id` = `Supplier`.`id`) 
            left JOIN `suppliers` AS `SupplierFinal` ON (`SheetRideDetailRides`.`supplier_final_id` = `SupplierFinal`.`id`) 
            left JOIN `destinations` AS `DepartureDestination` ON (`DepartureDestination`.`id` = `Ride`.`departure_destination_id`) 
            left JOIN `destinations` AS `ArrivalDestination` ON (`ArrivalDestination`.`id` = `Ride`.`arrival_destination_id`) 
            left JOIN `destinations` AS `Departure` ON (`Departure`.`id` = `SheetRideDetailRides`.`departure_destination_id`) 
            left JOIN `destinations` AS `Arrival` ON (`Arrival`.`id` = `SheetRideDetailRides`.`arrival_destination_id`) 
            WHERE `SheetRideDetailRides`.`status_id` = 5 AND `SheetRideDetailRides`.`invoiced_ride` = 1  " ;

        $query['detail'] =
            "SELECT `SheetRide`.`reference`, `SheetRide`.`id`, `SheetRideDetailRides`.`reference`, 
            `SheetRideDetailRides`.`type_ride`, `SheetRideDetailRides`.`supplier_id`, `SheetRideDetailRides`.`detail_ride_id`, 
            `SheetRideDetailRides`.`planned_start_date`, `SheetRideDetailRides`.`real_start_date`, 
            `SheetRideDetailRides`.`planned_end_date`, `SheetRideDetailRides`.`real_end_date`, 
            `SheetRideDetailRides`.`id`, `SheetRideDetailRides`.`status_id`, `DepartureDestination`.`name`, 
            `ArrivalDestination`.`name`, `Departure`.`name`, `Arrival`.`name`, `Supplier`.`name`, `SupplierFinal`.`name`, 
            `CarType`.`name` 
            FROM `sheet_ride_detail_rides` AS `SheetRideDetailRides` 
            left JOIN `sheet_rides` AS `SheetRide` ON (`SheetRideDetailRides`.`sheet_ride_id` = `SheetRide`.`id`) 
            left JOIN `detail_rides` AS `DetailRide` ON (`SheetRideDetailRides`.`detail_ride_id` = `DetailRide`.`id`) 
            left JOIN `car_types` AS `CarType` ON (`SheetRide`.`car_type_id` = `CarType`.`id`) 
            left JOIN `rides` AS `Ride` ON (`DetailRide`.`ride_id` = `Ride`.`id`) 
            left JOIN `suppliers` AS `Supplier` ON (`SheetRideDetailRides`.`supplier_id` = `Supplier`.`id`) 
            left JOIN `suppliers` AS `SupplierFinal` ON (`SheetRideDetailRides`.`supplier_final_id` = `SupplierFinal`.`id`) 
            left JOIN `destinations` AS `DepartureDestination` ON (`DepartureDestination`.`id` = `Ride`.`departure_destination_id`) 
            left JOIN `destinations` AS `ArrivalDestination` ON (`ArrivalDestination`.`id` = `Ride`.`arrival_destination_id`) 
            left JOIN `destinations` AS `Departure` ON (`Departure`.`id` = `SheetRideDetailRides`.`departure_destination_id`) 
            left JOIN `destinations` AS `Arrival` ON (`Arrival`.`id` = `SheetRideDetailRides`.`arrival_destination_id`) 
            WHERE `SheetRideDetailRides`.`status_id` = 5 AND `SheetRideDetailRides`.`invoiced_ride` = 1  ";

        $query['columns'] = array(
            0 => array('SheetRideDetailRides.reference','SheetRideDetailRides', 'reference', 'Reference', 'string',''),
            1 => array('DepartureDestination.name','0', 'trajet',  'Ride', 'string','CONCAT','DepartureDestination.name','ArrivalDestination.name'),
            2 => array('Supplier.name','Supplier', 'name','Initial customer', 'string',''),
            3 => array('SheetRideDetailRides.planned_start_date','SheetRideDetailRides', 'planned_start_date', 'Planned Departure date', 'datetime',''),
            4 => array('SheetRideDetailRides.real_start_date','SheetRideDetailRides', 'real_start_date', 'Real Departure date', 'datetime',''),
            5 => array('SupplierFinal.name','SupplierFinal', 'name', 'Final customer', 'string',''),
            6 => array('SheetRideDetailRides.planned_end_date','SheetRideDetailRides', 'planned_end_date', 'Planned Arrival date ', 'datetime',''),
            7 => array('SheetRideDetailRides.real_end_date','SheetRideDetailRides', 'real_end_date', 'Real Arrival date', 'datetime',''),
            8 => array('SheetRideDetailRides.status_id','SheetRideDetailRides', 'status_id', 'Status', 'number',''),
        );
        $query['order'] = ' SheetRideDetailRides.id desc ';
        $query['tableName'] = 'SheetRideDetailRides';
        $query['controller'] = 'sheetRideDetailRides';
        $query['action'] = 'addFromPreinvoice';
        $query['itemName'] = array('reference');
        $this->Session->write('query', $query);
        //get default user limit value
        $defaultLimit =  $this->getLimit();;
        if (isset($defaultLimit) && $defaultLimit > 0) {
            $this->set('defaultLimit', $defaultLimit);
        } else {
            $this->set('defaultLimit', 20);
        }
        $controller =  'sheetRideDetailRides';
        $action =  'addFromPreinvoice';
        $deleteFonction =  'deleteSheetRideDetailRides/';

        $this->set(compact('type', 'param','controller','action','deleteFonction'));

    }


    public function addFromMissionsInvoiced()
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();

        $conditions = '';
        if ($this->request->is('post')) {
            if (
                isset($this->request->data['transportBills']['supplier_id']) ||
                isset($this->request->data['transportBills']['detail_ride_id']) ||
                isset($this->request->data['transportBills']['date_from']) ||
                isset($this->request->data['transportBills']['date_to'])
            ) {

                $supplier = $this->request->data['transportBills']['supplier_id'];
                $detailRide = $this->request->data['transportBills']['detail_ride_id'];

                $date_from_mission = str_replace("/", "-", $this->request->data['transportBills']['date_from']);
                $date_to_mission = str_replace("/", "-", $this->request->data['transportBills']['date_to']);

                if (!empty($supplier)) {
                    $conditions .= " && SheetRideDetailRides.supplier_id = $supplier  ";
                }

                if (!empty($detailRide)) {
                    $conditions .= " && SheetRideDetailRides.detail_ride_id = $detailRide  ";
                }
                if (!empty($date_from_mission)) {
                    $start_mission = str_replace("-", "/", $date_from_mission);
                    $startdtm_mission = DateTime::createFromFormat('d/m/Y', $start_mission);
                    $startdtm_mission = $startdtm_mission->format('Y-m-d 00:00:00');
                    $conditions .= " && SheetRideDetailRides.real_start_date >= '$startdtm_mission' ";
                }
                if (!empty($date_to_mission)) {
                    $end_mission = str_replace("-", "/", $date_to_mission);
                    $enddtm_mission = DateTime::createFromFormat('d/m/Y', $end_mission);
                    $enddtm_mission = $enddtm_mission->format('Y-m-d 23:59:00');
                    $conditions .= " && SheetRideDetailRides.real_start_date <= '$enddtm_mission' ";
                }
                $query['conditions'] =  $conditions;

            }
        }else {
            $query['conditions'] = '';
        }


        $this->Session->write('addFromMissionsInvoicedConditions', $conditions);

        $query['count'] =
            "SELECT COUNT(*) AS `count`  FROM `sheet_ride_detail_rides` AS `SheetRideDetailRides` 
            left JOIN `sheet_rides` AS `SheetRide` ON (`SheetRideDetailRides`.`sheet_ride_id` = `SheetRide`.`id`) 
            left JOIN `detail_rides` AS `DetailRide` ON (`SheetRideDetailRides`.`detail_ride_id` = `DetailRide`.`id`) 
            left JOIN `car_types` AS `CarType` ON (`SheetRide`.`car_type_id` = `CarType`.`id`) 
            left JOIN `rides` AS `Ride` ON (`DetailRide`.`ride_id` = `Ride`.`id`) 
            left JOIN `suppliers` AS `Supplier` ON (`SheetRideDetailRides`.`supplier_id` = `Supplier`.`id`) 
            left JOIN `suppliers` AS `SupplierFinal` ON (`SheetRideDetailRides`.`supplier_final_id` = `SupplierFinal`.`id`) 
            left JOIN `suppliers` AS `Subcontractor` ON (`SheetRide`.`supplier_id` = `Subcontractor`.`id`)
            left JOIN `destinations` AS `DepartureDestination` ON (`DepartureDestination`.`id` = `Ride`.`departure_destination_id`) 
            left JOIN `destinations` AS `ArrivalDestination` ON (`ArrivalDestination`.`id` = `Ride`.`arrival_destination_id`) 
            left JOIN `destinations` AS `Departure` ON (`Departure`.`id` = `SheetRideDetailRides`.`departure_destination_id`) 
            left JOIN `destinations` AS `Arrival` ON (`Arrival`.`id` = `SheetRideDetailRides`.`arrival_destination_id`) 
            left JOIN `transport_bill_detailed_rides` AS `TransportBillDetailedRides` ON (`TransportBillDetailedRides`.`sheet_ride_id` = `SheetRide`.`id`) 
            left JOIN `transport_bills` AS `TransportBill` ON (`TransportBillDetailedRides`.`transport_bill_id` = `TransportBill`.`id`)
            WHERE `SheetRideDetailRides`.`status_id` = 7 AND `SheetRideDetailRides`.`invoiced_ride` = 1  " ;

        $query['detail'] =
            "SELECT `SheetRide`.`reference`, `SheetRide`.`id`, `SheetRideDetailRides`.`reference`, 
            `SheetRideDetailRides`.`type_ride`, `SheetRideDetailRides`.`supplier_id`, `SheetRideDetailRides`.`detail_ride_id`, 
            `SheetRideDetailRides`.`planned_start_date`, `SheetRideDetailRides`.`real_start_date`, 
            `SheetRideDetailRides`.`planned_end_date`, `SheetRideDetailRides`.`real_end_date`, 
            `SheetRideDetailRides`.`id`, `SheetRideDetailRides`.`status_id`, `DepartureDestination`.`name`, 
            `ArrivalDestination`.`name`, `Departure`.`name`, `Arrival`.`name`, `Supplier`.`name`, `SupplierFinal`.`name`, 
            `CarType`.`name`,`Subcontractor`.`name` ,`TransportBillDetailedRides`.`price_ht`,
            `TransportBillDetailedRides`.`delivery_with_return`,`TransportBill`.`order_type`,
            `TransportBillDetailedRides`.`programming_date`,`TransportBillDetailedRides`.`charging_time`,
             `TransportBillDetailedRides`.`unloading_date`
            FROM `sheet_ride_detail_rides` AS `SheetRideDetailRides` 
            left JOIN `sheet_rides` AS `SheetRide` ON (`SheetRideDetailRides`.`sheet_ride_id` = `SheetRide`.`id`) 
            left JOIN `detail_rides` AS `DetailRide` ON (`SheetRideDetailRides`.`detail_ride_id` = `DetailRide`.`id`) 
            left JOIN `car_types` AS `CarType` ON (`SheetRide`.`car_type_id` = `CarType`.`id`) 
            left JOIN `rides` AS `Ride` ON (`DetailRide`.`ride_id` = `Ride`.`id`) 
            left JOIN `suppliers` AS `Supplier` ON (`SheetRideDetailRides`.`supplier_id` = `Supplier`.`id`) 
            left JOIN `suppliers` AS `SupplierFinal` ON (`SheetRideDetailRides`.`supplier_final_id` = `SupplierFinal`.`id`) 
            left JOIN `suppliers` AS `Subcontractor` ON (`SheetRide`.`supplier_id` = `Subcontractor`.`id`)
            left JOIN `destinations` AS `DepartureDestination` ON (`DepartureDestination`.`id` = `Ride`.`departure_destination_id`) 
            left JOIN `destinations` AS `ArrivalDestination` ON (`ArrivalDestination`.`id` = `Ride`.`arrival_destination_id`) 
            left JOIN `destinations` AS `Departure` ON (`Departure`.`id` = `SheetRideDetailRides`.`departure_destination_id`) 
            left JOIN `destinations` AS `Arrival` ON (`Arrival`.`id` = `SheetRideDetailRides`.`arrival_destination_id`) 
            left JOIN `transport_bill_detailed_rides` AS `TransportBillDetailedRides` ON (`TransportBillDetailedRides`.`sheet_ride_id` = `SheetRide`.`id`) 
            left JOIN `transport_bills` AS `TransportBill` ON (`TransportBillDetailedRides`.`transport_bill_id` = `TransportBill`.`id`) 
            WHERE `SheetRideDetailRides`.`status_id` = 7 AND `SheetRideDetailRides`.`invoiced_ride` = 1  
           
            ";

        $query['columns'] = array(
            0 => array('SheetRideDetailRides.reference','SheetRideDetailRides', 'reference', 'Reference', 'string',''),
            1 => array('DepartureDestination.name','0', 'trajet',  'Ride', 'string','CONCAT','DepartureDestination.name','ArrivalDestination.name'),
            2 => array('Supplier.name','Supplier', 'name','Initial customer', 'string',''),
            3 => array('TransportBill.order_type','TransportBill', 'order_type','Order type', 'string',''),
            4 => array('TransportBillDetailedRides.delivery_with_return','TransportBillDetailedRides', 'delivery_with_return','Mission type', 'string',''),
            5 => array('Subcontractor.name','Subcontractor', 'name','Subcontractor', 'string',''),
            6 => array('TransportBillDetailedRides.price_ht','TransportBillDetailedRides', 'price_ht','Price', 'number',''),
            7 => array('SheetRideDetailRides.planned_start_date','SheetRideDetailRides', 'planned_start_date', 'Planned Departure date', 'datetime',''),
            8 => array('SheetRideDetailRides.real_start_date','SheetRideDetailRides', 'real_start_date', 'Real Departure date', 'datetime',''),
            9 => array('SupplierFinal.name','SupplierFinal', 'name', 'Final customer', 'string',''),
            10 => array('SheetRideDetailRides.planned_end_date','SheetRideDetailRides', 'planned_end_date', 'Planned Arrival date ', 'datetime',''),
            11 => array('SheetRideDetailRides.real_end_date','SheetRideDetailRides', 'real_end_date', 'Real Arrival date', 'datetime',''),
            12 => array('TransportBillDetailedRides.programming_date','TransportBillDetailedRides', 'programming_date', __('Charging date').' / '.__('Unloading date'), 'string','50px'),
            13 => array('SheetRideDetailRides.status_id','SheetRideDetailRides', 'status_id', 'Status', 'number',''),
        );
        $query['order'] = ' SheetRideDetailRides.reference desc , SheetRideDetailRides.id desc ';
        $query['tableName'] = 'SheetRideDetailRides';
        $query['controller'] = 'sheetRideDetailRides';
        $query['action'] = 'addFromMissionsInvoiced';
        $query['itemName'] = array('reference');
        $this->Session->write('query', $query);
        //get default user limit value
        $defaultLimit =  $this->getLimit();;
        if (isset($defaultLimit) && $defaultLimit > 0) {
            $this->set('defaultLimit', $defaultLimit);
        } else {
            $this->set('defaultLimit', 20);
        }
        $controller =  'sheetRideDetailRides';
        $action =  'addFromMissionsInvoiced';
        $deleteFonction =  'deleteSheetRideDetailRides/';

        $this->set(compact('type', 'param','controller','action','deleteFonction'));

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
            $date_from = str_replace("/", "-", $startDate);
            $start = str_replace("-", "/", $date_from);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $conditions["TransportBill.date >="] = $startdtm->format('Y-m-d H:i:s');
        }
        if (!empty($endDate)) {
            $date_to = str_replace("/", "-", $endDate);
            $end = str_replace("-", "/", $date_to);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $conditions["TransportBill.date <="] = $enddtm->format('Y-m-d H:i:s');
        }
        $ids = filter_input(INPUT_POST, "chkids");

        if (!empty($ids)) {


            $arrayIds = explode(",", $ids);
            if (!empty($arrayIds)) {
                $conditions["TransportBill.id"] = $arrayIds;
            }
        }

        $transportBills = $this->TransportBill->find('all', array(
            'recursive' => -1,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'group' => 'TransportBillDetailRides.id',
            'order' => 'TransportBillDetailRides.programming_date ASC',
            'fields' => array(

                'TransportBill.reference',
                'TransportBill.id',
                'TransportBill.date',
                'TransportBill.total_ttc',
                'TransportBill.total_ht',
                'TransportBill.total_tva',
                'TransportBill.amount_remaining',
                'TransportBill.amount_remaining',
                'TransportBill.stamp',
                'TransportBill.order_type',
                'TransportBillDetailRides.delivery_with_return',
                'TransportBillDetailRides.nb_trucks',
                'TransportBillDetailRides.price_ht',
                'TransportBillDetailRides.price_ttc',
                'TransportBillDetailRides.programming_date',
                'TransportBillDetailRides.charging_time',
                'TransportBillDetailRides.unloading_date',
                'Type.name',
                'Supplier.name',
                'Supplier.code',
                'Arrival.name',
                'Departure.name',

            ),
            'joins' => array(

                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('TransportBill.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'transport_bill_detail_rides',
                    'type' => 'left',
                    'alias' => 'TransportBillDetailRides',
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
            )
        ));
        $transportBills = $this->setMissionsDates($transportBills);

        $company = $this->Company->find('first');
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('transportBills', 'company', 'separatorAmount','startDate','endDate'));

    }

    public function printDetailedJournal()
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        $array = filter_input(INPUT_POST, "printDetailedJournal");
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
            $date_from = str_replace("/", "-", $startDate);
            $start = str_replace("-", "/", $date_from);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $conditions["TransportBill.date >="] = $startdtm->format('Y-m-d H:i:s');
        }
        if (!empty($endDate)) {
            $date_to = str_replace("/", "-", $endDate);
            $end = str_replace("-", "/", $date_to);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $conditions["TransportBill.date <="] = $enddtm->format('Y-m-d H:i:s');
        }
        $ids = filter_input(INPUT_POST, "chkids");
        if (!empty($ids)) {
            $arrayIds = explode(",", $ids);
            if (!empty($arrayIds)) {
                $conditions["TransportBill.id"] = $arrayIds;
            }
        }
        $transportBills = $this->TransportBill->find('all', array(
            'recursive' => -1,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'fields' => array(
                'TransportBill.reference',
                'TransportBill.id',
                'TransportBill.date',
                'TransportBill.total_ttc',
                'TransportBill.total_ht',
                'TransportBill.total_tva',
                'TransportBill.amount_remaining',
                'Supplier.name',
                'Supplier.code',
                'DetailPayment.payroll_amount',
                'DetailPayment.amount_remaining',
                'Payment.receipt_date',
                'Payment.payment_type'
            ),
            'joins' => array(
                array(
                    'table' => 'detail_payments',
                    'type' => 'left',
                    'alias' => 'DetailPayment',
                    'conditions' => array('DetailPayment.transport_bill_id = TransportBill.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('TransportBill.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'payments',
                    'type' => 'left',
                    'alias' => 'Payment',
                    'conditions' => array('DetailPayment.payment_id = Payment.id')
                )
            )
        ));
        $company = $this->Company->find('first');
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('transportBills', 'company', 'separatorAmount'));

    }

    
	
	
	public function printDetailedJournalPerMission()
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        $array = filter_input(INPUT_POST, "printDetailedJournalPerMission");

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
            $date_from = str_replace("/", "-", $startDate);
            $start = str_replace("-", "/", $date_from);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $conditions["TransportBill.date >="] = $startdtm->format('Y-m-d H:i:s');
        }
        if (!empty($endDate)) {
            $date_to = str_replace("/", "-", $endDate);
            $end = str_replace("-", "/", $date_to);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $conditions["TransportBill.date <="] = $enddtm->format('Y-m-d H:i:s');
        }
        $ids = filter_input(INPUT_POST, "chkids");

        if (!empty($ids)) {
            $arrayIds = explode(",", $ids);
            if (!empty($arrayIds)) {
                $conditions["TransportBill.id"] = $arrayIds;
            }
        }

        $rides = $this->TransportBillDetailRides->find('all', array(
            'order' => array('TransportBill.id ASC', 'TransportBillDetailRides.id ASC'),
            'recursive' => -1,
            'fields' => array(
                'TransportBillDetailRides.reference',
                'TransportBillDetailRides.unit_price',
                'TransportBillDetailRides.price_ht',
                'TransportBillDetailRides.price_ttc',
                'TransportBillDetailRides.tva_id',
                'TransportBillDetailRides.ristourne_%',
                'TransportBillDetailRides.ristourne_val',
                'TransportBillDetailRides.id',
                'CarType.name',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'TransportBill.reference',
                'TransportBill.id',
                'TransportBill.date',
                'TransportBill.total_ttc',
                'TransportBill.total_ht',
                'TransportBill.total_tva',
                'Supplier.name',
                'Supplier.code',
                'TransportBill.reference',
                'TransportBill.date',
                'Tva.name'
            ),
            'conditions' => $conditions,
            'joins' => array(
                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('TransportBillDetailRides.transport_bill_id = TransportBill.id')
                ),
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('TransportBillDetailRides.detail_ride_id = DetailRide.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('TransportBill.supplier_id = Supplier.id')
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
                    'table' => 'tva',
                    'type' => 'left',
                    'alias' => 'Tva',
                    'conditions' => array('Tva.id = TransportBillDetailRides.tva_id')
                ),
            )
        ));


        $company = $this->Company->find('first');
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('transportBills', 'rides', 'company', 'separatorAmount'));

    }
	public function printJournalPerClient()
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        ini_set('memory_limit', '1024M');
        $array = filter_input(INPUT_POST, "printJournalPerClient");

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

        $transportBills = $this->TransportBill->find('all', array(
            'recursive' => -1,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'group' => 'Supplier.id,TransportBillDetailedRides.id',
            'order' => 'Supplier.id ASC, TransportBillDetailedRides.programming_date',
            'fields' => array(

                'TransportBill.reference',
                'TransportBill.id',
                'TransportBill.date',
                'TransportBill.total_ttc',
                'TransportBill.total_ht',
                'TransportBill.total_tva',
                'TransportBill.amount_remaining',
                'TransportBill.stamp',
                'TransportBill.order_type',
                'Supplier.id',
                'Supplier.name',
                'Supplier.code',
                'TransportBillDetailedRides.id',
                'TransportBillDetailedRides.unit_price',
                'TransportBillDetailedRides.type_ride',
                'COUNT(TransportBillDetailedRides.nb_trucks) as nb_trucks',
                'TransportBillDetailedRides.delivery_with_return',
                'TransportBillDetailedRides.programming_date',
                'TransportBillDetailedRides.unloading_date',
                'TransportBillDetailedRides.arrival_destination_id',
                'TransportBillDetailedRides.departure_destination_id',
                'TransportBillDetailedRides.designation',
                'Departure.name',
                'Arrival.name',
                'Subcontractor.id',
                'Subcontractor.name',
                'Type.name',

            ),
            'joins' => array(
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('TransportBill.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'transport_bill_detailed_rides',
                    'type' => 'left',
                    'alias' => 'TransportBillDetailedRides',
                    'conditions' => array('TransportBill.id = TransportBillDetailedRides.transport_bill_id')
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
        $this->set(compact('transportBills', 'company', 'separatorAmount','startDate','endDate'));

    }

   /**  get amount remaining and total tcc by transport bill id
     * @param null $transportBillId
     */
    public function getTotalsById($transportBillId = null)
    {
        $transportBill = $this->TransportBill->getTransportBillById($transportBillId);
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('transportBill', 'separatorAmount'));
    }

    public function liste($type = null, $id = null, $keyword = null)
    {


        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $keyword = str_replace('espace', ' ', $keyword);
        $keyword = str_replace('slash', '/', $keyword);
        $keyword = str_replace('tiret', '-', $keyword);

        $keyword = strtolower($keyword);
        $profileId = $this->Auth->user('profile_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        $limit = $this->getLimit();
        $order = $this->getOrder();
        $this->layout = 'ajax';
        if (($type == TransportBillTypesEnum::quote_request)
        ) {
            if ($profileId == ProfilesEnum::client) {
                switch ($id) {
                    case 2 :
                        $conditions = array(
                            'TransportBill.type' => $type,
                            "LOWER(TransportBill.reference) LIKE" => "%$keyword%"
                        );
                        break;
                    case 3 :
                        if(!empty($keyword)){
                            $keyword = str_replace("/", "-", $keyword);
                            $start = str_replace("-", "/", $keyword);
                            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                            $conditions = array(
                                'TransportBill.type' => $type,
                                "TransportBill.date >=" => $startdtm->format('Y-m-d 00:00:00'));
                        }else {
                            $conditions = array(
                                'TransportBill.type' => $type);
                        }

                        break;
                    case 4 :
                        $conditions = array('TransportBill.type' => $type, "LOWER(SupplierFinal.name) LIKE" => "%$keyword%");
                        break;
                    case 5 :
                        $conditions = array(
                            'TransportBill.type' => $type,
                            array(
                                'OR' => array(
                                    "LOWER(DepartureDestination.name) LIKE" => "%$keyword%",
                                    "LOWER(ArrivalDestination.name) LIKE" => "%$keyword%",
                                )));
                        break;
                    case 6 :
                        $conditions = array('TransportBill.type' => $type, "LOWER(CarType.name) LIKE" => "%$keyword%");
                        break;
                    case 7 :
                        $conditions = array(
                            'TransportBill.type' => $type,
                            "LOWER(TransportBill.nb_trancks) LIKE" => "%$keyword%"
                        );
                        break;
                    case 8 :
                        $conditions = array(
                            'TransportBill.type' => $type,
                            "LOWER(TransportBill.status_id) LIKE" => "%$keyword%"
                        );
                        break;
                    default:
                        $conditions = array(
                            'TransportBill.type' => $type,
                            "LOWER(TransportBill.reference) LIKE" => "%$keyword%"
                        );
                }


            } else {
                switch ($id) {
                    case 2 :
                        $conditions = array(
                            'TransportBill.type' => $type,
                            "LOWER(TransportBill.reference) LIKE" => "%$keyword%"
                        );
                        break;
                    case 3 :
                        if(!empty($keyword)){
                            $keyword = str_replace("/", "-", $keyword);
                            $start = str_replace("-", "/", $keyword);
                            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                            $conditions = array("TransportBill.date >=" => $startdtm->format('Y-m-d 00:00:00'),'TransportBill.type' => $type);

                        }else {
                            $conditions = array('TransportBill.type' => $type,);
                        }

                        break;
                    case 4 :
                        $conditions = array('TransportBill.type' => $type, "LOWER(SupplierInitial.name) LIKE" => "%$keyword%");
                        break;
                    case 5 :
                        $conditions = array('TransportBill.type' => $type, "LOWER(Service.name) LIKE" => "%$keyword%");
                        break;
                    case 6 :
                        $conditions = array('TransportBill.type' => $type, "LOWER(SupplierFinal.name) LIKE" => "%$keyword%");
                        break;
                    case 7 :
                        $conditions = array(
                            'TransportBill.type' => $type,
                            array(
                                'OR' => array(
                                    "LOWER(DepartureDestination.name) LIKE" => "%$keyword%",
                                    "LOWER(ArrivalDestination.name) LIKE" => "%$keyword%",
                                )
                            )
                        );
                        break;
                    case 8 :
                        $conditions = array('TransportBill.type' => $type, "LOWER(CarType.name) LIKE" => "%$keyword%");
                        break;
                    case 9 :
                        $conditions = array(
                            'TransportBill.type' => $type,
                            "LOWER(TransportBill.nb_trancks) LIKE" => "%$keyword%"
                        );
                        break;
                    case 10 :
                        $conditions = array(
                            'TransportBill.type' => $type,
                            "LOWER(TransportBill.status_id) LIKE" => "%$keyword%"
                        );
                        break;


                    default:
                        $conditions = array(
                            'TransportBill.type' => $type,
                            "LOWER(TransportBill.reference) LIKE" => "%$keyword%"
                        );
                }
            }

        } else {

            if ($profileId == ProfilesEnum::client) {

                switch ($id) {
                    case 2 :
                        $conditions = array(
                            'TransportBill.type' => $type,
                            "LOWER(TransportBill.reference) LIKE" => "%$keyword%"
                        );
                        break;
                    case 3 :
                        if(!empty($keyword)){
                            $keyword = str_replace("/", "-", $keyword);
                            $start = str_replace("-", "/", $keyword);
                            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                            $conditions = array(
                                'TransportBill.type' => $type,
                                "TransportBill.date >=" => $startdtm->format('Y-m-d 00:00:00')
                            );
                        }else {
                            $conditions = array(
                                'TransportBill.type' => $type
                            );
                        }

                        break;

                    case 4 :
                        $keyword = str_replace(" ", "", $keyword);
                        $keywordExploded = explode(",", $keyword);
                        if(!empty($keywordExploded[0])){
                            $keyword =  $keywordExploded[0];
                        }
                        $conditions = array(
                            'TransportBill.type' => $type,
                            "LOWER(TransportBill.total_ht) LIKE" => "%$keyword%"
                        );
                        break;
                    case 5 :
                        $keyword = str_replace(" ", "", $keyword);
                        $keywordExploded = explode(",", $keyword);
                        if(!empty($keywordExploded[0])){
                            $keyword =  $keywordExploded[0];
                        }
                        $conditions = array(
                            'TransportBill.type' => $type,
                            "LOWER(TransportBill.total_tva) LIKE" => "%$keyword%"
                        );
                        break;
                    case 6 :
                        $keyword = str_replace(" ", "", $keyword);
                        $keywordExploded = explode(",", $keyword);
                        if(!empty($keywordExploded[0])){
                            $keyword =  $keywordExploded[0];
                        }
                        $conditions = array(
                            'TransportBill.type' => $type,
                            "LOWER(TransportBill.total_ttc) LIKE" => "%$keyword%"
                        );
                        break;
                    case 7 :
                        $conditions = array(
                            'TransportBill.type' => $type,
                            "LOWER(TransportBill.status_id) LIKE" => "%$keyword%"
                        );
                        break;

                    default:
                        $conditions = array(
                            'TransportBill.type' => $type,
                            "LOWER(TransportBill.reference) LIKE" => "%$keyword%"
                        );
                }

            } else {


                switch ($id) {
                    case 2 :
                        $conditions = array(
                            'TransportBill.type' => $type,
                            "LOWER(TransportBill.reference) LIKE" => "%$keyword%"
                        );
                        break;
                    case 3 :
                        if(!empty($keyword)){
                            $keyword = str_replace("/", "-", $keyword);
                            $start = str_replace("-", "/", $keyword);
                            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                            $conditions = array(
                                'TransportBill.type' => $type,
                                "TransportBill.date >=" => $startdtm->format('Y-m-d 00:00:00')
                            );
                        } else {
                            $conditions = array(
                                'TransportBill.type' => $type
                            );
                        }


                        break;
                    case 4 :
                        $conditions = array('TransportBill.type' => $type, "LOWER(Supplier.name) LIKE" => "%$keyword%");
                        break;

                    case 5 :
                        $conditions = array('TransportBill.type' => $type, "LOWER(Service.name) LIKE" => "%$keyword%");
                        break;

                    case 6 :
                        $keyword = str_replace(" ", "", $keyword);
                        $keywordExploded = explode(",", $keyword);
                        if(!empty($keywordExploded[0])){
                            $keyword =  $keywordExploded[0];
                        }
                        $conditions = array(
                            'TransportBill.type' => $type,
                            "LOWER(TransportBill.total_ht) LIKE" => "%$keyword%"
                        );
                        break;
                    case 7 :
                        $keyword = str_replace(" ", "", $keyword);
                        $keywordExploded = explode(",", $keyword);
                        if(!empty($keywordExploded[0])){
                            $keyword =  $keywordExploded[0];
                        }
                        $conditions = array(
                            'TransportBill.type' => $type,
                            "LOWER(TransportBill.total_tva) LIKE" => "%$keyword%"
                        );
                        break;
                    case 8 :
                        $keyword = str_replace(" ", "", $keyword);
                        $keywordExploded = explode(",", $keyword);
                        if(!empty($keywordExploded[0])){
                            $keyword =  $keywordExploded[0];
                        }
                        $conditions = array(
                            'TransportBill.type' => $type,
                            "LOWER(TransportBill.total_ttc) LIKE" => "%$keyword%"
                        );
                        break;
                    case 9 :
                        $conditions = array(
                            'TransportBill.type' => $type,
                            "LOWER(TransportBill.status_id) LIKE" => "%$keyword%"
                        );
                        break;

                    default:
                        $conditions = array(
                            'TransportBill.type' => $type,
                            "LOWER(TransportBill.reference) LIKE" => "%$keyword%"
                        );
                }
            }
        }

        $generalConditions = $this->getTransportBillGeneralConditions($type);

        if (!empty($conditions)) {
            $conditions = array_merge($conditions, $generalConditions);

        } else {
            $conditions = $generalConditions;
        }
        if ($type == TransportBillTypesEnum::quote_request) {
            $this->paginate = array(
                'limit' => $limit,
                'order' => $order,
                'recursive' => -1,
                'conditions' => $conditions,
                'paramType' => 'querystring',
                'fields' => array(
                    'DepartureDestination.name',
                    'ArrivalDestination.name',
                    'Ride.wording',
                    'Ride.distance',
                    'CarType.name',
                    'transportBillDetailRides.nb_trucks',
                    'TransportBill.total_weight',
                    'TransportBill.nb_trucks',
                    'TransportBill.reference',
                    'TransportBill.id',
                    'TransportBill.date',
                    'TransportBill.total_ttc',
                    'TransportBill.total_ht',
                    'TransportBill.total_tva',
                    'TransportBill.type',
                    'TransportBill.status',
                    'TransportBill.status_payment',
                    'TransportBill.payment_type',
                    'TransportBill.payment_date',
                    'Supplier.name',
                    'Supplier.adress',
                    'Supplier.tel',
                    'Supplier.contact',
                    'Supplier.email',
                    'SupplierFinal.name',
                    'SupplierFinal.adress',
                    'SupplierFinal.tel',
                    'SupplierFinal.contact',
                    'SupplierFinal.email',
                    'Service.name'

                ),
                'joins' => array(
                    array(
                        'table' => 'rides',
                        'type' => 'left',
                        'alias' => 'Ride',
                        'conditions' => array('TransportBill.ride_id = Ride.id')
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
                        'conditions' => array('TransportBill.supplier_final_id = SupplierFinal.id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'CarType',
                        'conditions' => array('TransportBill.car_type_id = CarType.id')
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
                        'table' => 'transport_bill_detail_rides',
                        'type' => 'left',
                        'alias' => 'transportBillDetailRides',
                        'conditions' => array('transportBillDetailRides.transport_bill_id = TransportBill.id')
                    ),
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('TransportBill.user_id = User.id')
                    ),
                    array(
                        'table' => 'services',
                        'type' => 'left',
                        'alias' => 'Service',
                        'conditions' => array('Service.id = TransportBill.service_id')
                    )
                )
            );
        } else {
            $this->paginate = array(
                'limit' => $limit,
                'order' => $order,
                'recursive' => -1,
                'conditions' => $conditions,
                'paramType' => 'querystring',
                'fields' => array(
                    'DepartureDestination.name',
                    'ArrivalDestination.name',
                    'Ride.wording',
                    'Ride.distance',
                    'CarType.name',
                    'TransportBill.reference',
                    'TransportBill.id',
                    'TransportBill.date',
                    'TransportBill.total_ttc',
                    'TransportBill.total_ht',
                    'TransportBill.total_tva',
                    'TransportBill.amount_remaining',
                    'TransportBill.type',
                    'TransportBill.status',
                    'TransportBill.status_payment',
                    'TransportBill.payment_type',
                    'TransportBill.payment_date',
                    'Supplier.name',
                    'Supplier.adress',
                    'Supplier.tel',
                    'Supplier.contact',
                    'Supplier.email',
                    'SupplierFinal.name',
                    'SupplierFinal.adress',
                    'SupplierFinal.tel',
                    'SupplierFinal.contact',
                    'SupplierFinal.email',
                    'Service.name'
                ),
                'joins' => array(
                    array(
                        'table' => 'detail_rides',
                        'type' => 'left',
                        'alias' => 'DetailRide',
                        'conditions' => array('TransportBill.detail_ride_id = DetailRide.id')
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
                        'conditions' => array('TransportBill.supplier_final_id = SupplierFinal.id')
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
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('TransportBill.user_id = User.id')
                    ),
                    array(
                        'table' => 'services',
                        'type' => 'left',
                        'alias' => 'Service',
                        'conditions' => array('Service.id = TransportBill.service_id')
                    )
                )
            );


        }


        $transportBills = $this->Paginator->paginate('TransportBill');

        $this->set('transportBills', $transportBills);

        //Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $client_i2b = $this->isCustomerI2B();
        $isAgent = $this->isAgent();
        $separatorAmount = $this->getSeparatorAmount();

        $reportingChoosed = $this->reportingChoosed();
        if ($reportingChoosed == 3) {
            $informationJasperReport = $this->Parameter->getInformationJasperReport();
            $this->set('informationJasperReport', $informationJasperReport);
        }
        $settleMissions = $this->abilityToSettleMissions();
        $this->set(compact('param', 'client_i2b', 'isAgent', 'separatorAmount', 'type', 'profileId', 'reportingChoosed', 'settleMissions'));
    }

    public function listeAddFromCustomerOrder($id = null, $keyword = null)
    {


        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $keyword = str_replace('espace', ' ', $keyword);
        $keyword = str_replace('slash', '/', $keyword);
        $keyword = str_replace('tiret', '-', $keyword);
        $keyword = strtolower($keyword);
        $profileId = $this->Auth->user('profile_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        $this->layout = 'ajax';

        $useRideCategory = $this->useRideCategory();
        if($useRideCategory == 2) {
            switch ($id) {
                case 2 :
                    $conditions = array(
                        'TransportBill.type' => 2,
                        'TransportBillDetailRides.status_id' => array(1, 2),
                        "LOWER(TransportBill.reference) LIKE" => "%$keyword%"
                    );
                    break;
                case 3 :
                    $conditions = array(
                        'TransportBill.type' => 2,
                        'TransportBillDetailRides.status_id' => array(1, 2),
                        array(
                            'OR' => array(
                                "LOWER(DepartureDestination.name) LIKE" => "%$keyword%",
                                "LOWER(ArrivalDestination.name) LIKE" => "%$keyword%",
                                "LOWER(Departure.name) LIKE" => "%$keyword%",
                                "LOWER(Arrival.name) LIKE" => "%$keyword%",
                            )
                        )
                    );

                    break;
                case 4 :
                    $conditions = array(
                        'TransportBill.type' => 2,
                        'TransportBillDetailRides.status_id' => array(1, 2),
                        'OR' => array(
                            "LOWER(CarType.name) LIKE" => "%$keyword%",
                            "LOWER(Type.name) LIKE" => "%$keyword%",
                        )
                        );


                    break;

                case 5 :
                    $conditions = array(
                        'TransportBill.type' => 2,
                        'TransportBillDetailRides.status_id' => array(1, 2),
                        "LOWER(RideCategory.name) LIKE" => "%$keyword%");


                    break;

                case 6 :
                    if(!empty($keyword)){
                        $keyword = str_replace("/", "-", $keyword);
                        $start = str_replace("-", "/", $keyword);
                        $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                        $conditions = array(
                            'TransportBill.type' => 2,
                            'TransportBillDetailRides.status_id' => array(1, 2),
                            "TransportBill.date >=" => $startdtm->format('Y-m-d 00:00:00'));
                    }else {
                        $conditions = array(
                            'TransportBill.type' => 2,
                            'TransportBillDetailRides.status_id' => array(1, 2));
                    }
                    break;
                case 7 :
                    $conditions = array(
                        'TransportBill.type' => 2,
                        'TransportBillDetailRides.status_id' => array(1, 2),
                        "LOWER(SupplierInitial.name) LIKE" => "%$keyword%");
                    break;
                case 8 :

                    $conditions = array(
                        'TransportBill.type' => 2,
                        'TransportBillDetailRides.status_id' => array(1, 2),
                        "LOWER(Service.name) LIKE" => "%$keyword%");
                    break;
                case 9 :

                    $conditions = array(
                        'TransportBill.type' => 2,
                        'TransportBillDetailRides.status_id' => array(1, 2),
                        "LOWER(SupplierFinal.name) LIKE" => "%$keyword%");

                    break;
                case 10 :
                    $conditions = array(
                        'TransportBill.type' => 2,
                        'TransportBillDetailRides.status_id' => array(1, 2),
                        "LOWER(TransportBillDetailRides.nb_trucks) LIKE" => "%$keyword%"
                    );
                    break;

                case 11 :
                    $conditions = array(
                        'TransportBill.type' => 2,
                        'TransportBillDetailRides.status_id' => array(1, 2),
                        "LOWER(TransportBillDetailRides.nb_trucks_validated) LIKE" => "%$keyword%"
                    );
                    break;


                default:
                    $conditions = array(
                        'TransportBill.type' => 2,
                        'TransportBillDetailRides.status_id' => array(1, 2),
                        "LOWER(TransportBill.reference) LIKE" => "%$keyword%"
                    );
            }

        } else {
            switch ($id) {

                case 2 :
                    $conditions = array(
                        'TransportBill.type' => 2,
                        'TransportBillDetailRides.status_id' => array(1, 2),
                        "LOWER(TransportBillDetailRides.reference) LIKE" => "%$keyword%"
                    );
                    break;
                case 3 :
                    $conditions = array(
                        'TransportBill.type' => 2,
                        'TransportBillDetailRides.status_id' => array(1, 2),
                        array(
                            'OR' => array(
                                "LOWER(DepartureDestination.name) LIKE" => "%$keyword%",
                                "LOWER(ArrivalDestination.name) LIKE" => "%$keyword%",
                                "LOWER(Departure.name) LIKE" => "%$keyword%",
                                "LOWER(Arrival.name) LIKE" => "%$keyword%",
                            )
                        )
                    );

                    break;
                case 4 :
                    $conditions = array(
                        'TransportBill.type' => 2,
                        'TransportBillDetailRides.status_id' => array(1, 2),
                        'OR' => array(
                            "LOWER(CarType.name) LIKE" => "%$keyword%",
                            "LOWER(Type.name) LIKE" => "%$keyword%"
                        ));
                    break;
                case 5 :
                    if(!empty($keyword)){
                        $keyword = str_replace("/", "-", $keyword);
                        $start = str_replace("-", "/", $keyword);
                        $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                        $conditions = array(
                            'TransportBill.type' => 2,
                            'TransportBillDetailRides.status_id' => array(1, 2),
                            "TransportBill.date >=" => $startdtm->format('Y-m-d 00:00:00'));
                    }else {
                        $conditions = array(
                            'TransportBill.type' => 2,
                            'TransportBillDetailRides.status_id' => array(1, 2));
                    }
                    break;
                case 6 :
                    $conditions = array(
                        'TransportBill.type' => 2,
                        'TransportBillDetailRides.status_id' => array(1, 2),
                        "LOWER(SupplierInitial.name) LIKE" => "%$keyword%");
                    break;
                case 7 :

                    $conditions = array(
                        'TransportBill.type' => 2,
                        'TransportBillDetailRides.status_id' => array(1, 2),
                        "LOWER(Service.name) LIKE" => "%$keyword%");
                    break;
                case 8 :
                    $conditions = array(
                        'TransportBill.type' => 2,
                        'TransportBillDetailRides.status_id' => array(1, 2),
                        "LOWER(SupplierFinal.name) LIKE" => "%$keyword%");

                    break;
                case 9 :
                    $conditions = array(
                        'TransportBill.type' => 2,
                        'TransportBillDetailRides.status_id' => array(1, 2),
                        "LOWER(TransportBillDetailRides.nb_trucks) LIKE" => "%$keyword%"
                    );
                    break;

                case 10 :
                    $conditions = array(
                        'TransportBill.type' => 2,
                        'TransportBillDetailRides.status_id' => array(1, 2),
                        "LOWER(TransportBillDetailRides.nb_trucks_validated) LIKE" => "%$keyword%"
                    );
                    break;


                default:
                    $conditions = array(
                        'TransportBill.type' => 2,
                        'TransportBillDetailRides.status_id' => array(1, 2),
                        "LOWER(TransportBillDetailRides.reference) LIKE" => "%$keyword%"
                    );
            }
        }


        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'order' => array('TransportBill.id' => 'DESC'),
            'conditions' => $conditions,
            'fields' => array(
                'TransportBill.reference',
                'TransportBill.id',
                'TransportBill.type',
                'TransportBill.supplier_id',
                'TransportBill.date',
                'CarType.name',
                'RideCategory.name',
                'TransportBillDetailRides.type_ride',
                'TransportBillDetailRides.reference',
                'TransportBillDetailRides.detail_ride_id',
                'TransportBillDetailRides.ride_category_id',
                'TransportBillDetailRides.unit_price',
                'TransportBillDetailRides.nb_trucks_validated',
                'TransportBillDetailRides.nb_trucks',
                'TransportBillDetailRides.price_ht',
                'TransportBillDetailRides.tva_id',
                'TransportBillDetailRides.price_ttc',
                'TransportBillDetailRides.ristourne_%',
                'TransportBillDetailRides.ristourne_val',
                'TransportBillDetailRides.id',
                'TransportBillDetailRides.status_id',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Supplier.name',
                'SupplierFinal.name',
                'Tva.name',
                'Departure.name',
                'Arrival.name',
                'Type.name',
                'Service.name'
            ),
            'joins' => array(

                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('TransportBillDetailRides.transport_bill_id = TransportBill.id')
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
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('TransportBill.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'SupplierFinal',
                    'conditions' => array('TransportBill.supplier_final_id = SupplierFinal.id')
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
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'Type',
                    'conditions' => array('TransportBillDetailRides.car_type_id = Type.id')
                ),
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'User',
                    'conditions' => array('TransportBill.user_id = User.id')
                ),

                array(
                    'table' => 'services',
                    'type' => 'left',
                    'alias' => 'Service',
                    'conditions' => array('TransportBill.service_id = Service.id')
                ),

            )
        );
        $transportBillDetailRides = $this->Paginator->paginate('TransportBillDetailRides');

        $this->set(compact('transportBillDetailRides', 'useRideCategory'));


        $this->set(compact('param', 'client_i2b', 'isAgent', 'separatorAmount', 'type', 'profileId', 'reportingChoosed', 'settleMissions'));
    }

    public function getFinalSupplierByInitialSupplier($supplierId = null)
    {
        $finalSuppliers = $this->Supplier->getFinalSuppliersByInitialSupplier($supplierId);

        $this->set('finalSuppliers', $finalSuppliers);
    }

    public function addDetailRide($i = null, $type = null)
    {
        $this->layout = 'ajax';
        $tvas = $this->Tva->getTvas();
        $useRideCategory = $this->useRideCategory();
        if ($useRideCategory == 2) {
            $rideCategories = $this->RideCategory->getRideCategories();
            $this->set('rideCategories', $rideCategories);
        }
        $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
        $profileId = $this->Auth->user('profile_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        $typeRide = 1;
        $nbTrucksModifiable = $this->Parameter->getCodesParameterVal('nb_trucks_modifiable');
        $defaultNbTrucks = $this->Parameter->getCodesParameterVal('default_nb_trucks');
        $this->set(compact('tvas', 'type', 'useRideCategory', 'i', 'paramPriceNight',
            'profileId', 'typeRide', 'nbTrucksModifiable', 'defaultNbTrucks'));
    }

    public function addPersonalizedRide($i = null, $type = null)
    {
        $this->layout = 'ajax';
        $tvas = $this->Tva->getTvas();
        $useRideCategory = $this->useRideCategory();
        if ($useRideCategory == 2) {
            $rideCategories = $this->RideCategory->getRideCategories();
            $this->set('rideCategories', $rideCategories);
        }
        $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validatePersonalizedRide;

        $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
        $profileId = $this->Auth->user('profile_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        $typeRide = 2;
        $carTypes = $this->CarType->getCarTypes();
        $nbTrucksModifiable = $this->Parameter->getCodesParameterVal('nb_trucks_modifiable');
        $defaultNbTrucks = $this->Parameter->getCodesParameterVal('default_nb_trucks');
        $this->set(compact('tvas', 'type', 'useRideCategory', 'i',  'paramPriceNight',
            'profileId', 'typeRide', 'carTypes', 'nbTrucksModifiable', 'defaultNbTrucks'));
    }

    function addProduct($i = null, $type = null)
    {
        $this->layout = 'ajax';
        $products = $this->Product->getProducts();
        $tvas = $this->Tva->getTvas(null, 'list', null);
        $profileId = $this->Auth->user('profile_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
        $priceCategories = $this->PriceCategory->getPriceCategories('list');
        $typeRide = $this->Parameter->getCodesParameterVal('type_ride');
        $typeRideUsedFirst = $this->Parameter->getCodesParameterVal('type_ride_used_first');

        if ($typeRideUsedFirst != 1) {
            $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validatePersonalizedRide;
        }
        $carTypes = $this->CarType->getCarTypes();
        $typePricing = $this->Parameter->getCodesParameterVal('type_pricing');
        if ($typePricing == 2 || $typePricing == 3) {
            $tonnages = $this->Tonnage->getTonnages();
            $this->set(compact('tonnages'));
        }
        $reference = $this->getNextTransportReference( $type);
        $nbTrucksModifiable = $this->Parameter->getCodesParameterVal('nb_trucks_modifiable');
        $defaultNbTrucks = $this->Parameter->getCodesParameterVal('default_nb_trucks');
        $marchandiseUnits = $this->Marchandise->MarchandiseUnit->find('list', array('order' => 'name ASC'));
        $this->set(compact('products', 'type', 'tvas', 'i',  'profileId', 'typePricing','reference','defaultNbTrucks',
            'paramPriceNight', 'priceCategories', 'typeRide', 'typeRideUsedFirst', 'carTypes','nbTrucksModifiable','marchandiseUnits'));
    }


    public function getSimulation($typeRide = null, $departureId = null, $arrivalId = null, $carTypeId = null, $clientFinalId = null, $nbTrucks = null, $type = null, $detailRideId = null)
    {
        if ($typeRide == 2) {
            $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validatePersonalizedRide;
            $departures = $this->Destination->getDestinationsByConditions(array('Destination.id' => $departureId), 'list');
            $arrivals = $this->Destination->getDestinationsByConditions(array('Destination.id' => $arrivalId), 'list');
            $finalSuppliers = $this->Supplier->getSuppliersByParams(1, 1, null, array(1, 3), null, $clientFinalId);
            $carTypes = $this->CarType->getCarTypes();
            $this->set(compact('departureId', 'arrivalId', 'carTypeId', 'clientFinalId', 'nbTrucks', 'departures', 'arrivals', 'finalSuppliers', 'carTypes', 'type'));
        } else {
            $this->DetailRide->virtualFields = array('cnames' => "CONCAT(DepartureDestination.name, ' - ', ArrivalDestination.name,' - ', CarType.name)");
            $detailRides = $this->TransportBill->DetailRide->find('list', array(
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

            $finalSuppliers = $this->Supplier->getSuppliersByParams(1, 1, null, array(1, 3), null, $clientFinalId);
            $this->set(compact('detailRides', 'type', 'nbTrucks', 'finalSuppliers', 'clientFinalId', 'detailRideId'));
        }
        $useRideCategory = $this->useRideCategory();
        $profileId = $this->Auth->user('profile_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
        $nbTrucksModifiable = $this->Parameter->getCodesParameterVal('nb_trucks_modifiable');
        $defaultNbTrucks = $this->Parameter->getCodesParameterVal('default_nb_trucks');
        $tvas = $this->Tva->getTvas();
        $typeRideUsed = $this->Parameter->getCodesParameterVal('type_ride');
        $products = $this->Product->getProducts();
        $reference = $this->getNextTransportReference( $type);
        $typePricing = $this->Parameter->getCodesParameterVal('type_pricing');
        $this->set(compact( 'useRideCategory', 'profileId', 'paramPriceNight', 'tvas','reference',
            'typeRide', 'nbTrucksModifiable', 'defaultNbTrucks', 'typeRideUsed', 'products','typePricing'));
    }


    public function getInformationInvoice($invoiceId = null){
        $this->layout = 'ajax';
        if(!empty($invoiceId)){
            $transportBillRides = $this->TransportBillDetailRides->geDetailedTBDRByTransportBillId($invoiceId);
        }else {
            $transportBillRides= array();
        }

        $invoice = $this->TransportBill->getTransportBillById($invoiceId);
        $this->set('transportBillRides',$transportBillRides);
        $reference = $this->getNextTransportReference( TransportBillTypesEnum::invoice);
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        $useRideCategory = $this->useRideCategory();
        $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
        $permissionEditInputLocked = $this->AccessPermission->getPermissionWithParams(SectionsEnum::commande_client,
            ActionsEnum::edit_input_locked, $profileId, $roleId);
        $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
        if ($usePurchaseBill == 1) {
            $usedProductIds = array();
            $i = 1;
            $transportBillRideIds = array();
            $detailRideIds = array();
            $departureIds = array();
            $arrivalIds = array();
            $supplierFinalIds = array();
            $carIds = array();
            if(!empty($transportBillRides)){
            foreach ($transportBillRides as $transportBillRide) {
                $transportBillRideIds[] = $transportBillRide['TransportBillDetailRides']['id'];
                $detailRideIds[] = $transportBillRide['DetailRide']['id'];
                $departureIds[] = $transportBillRide['Departure']['id'];
                $arrivalIds[] = $transportBillRide['Arrival']['id'];
                $supplierFinalIds[] = $transportBillRide['TransportBillDetailRides']['supplier_final_id'];
                $carIds[] = $transportBillRide['TransportBillDetailRides']['car_id'];
                $lot = $this->Lot->getLotById($transportBillRide['TransportBillDetailRides']['lot_id']);
                $productId = $lot['Lot']['product_id'];
                $product = $this->Product->getProductById($productId);
                $usedProductIds[$i]['id'] = $productId;
                $usedProductIds[$i]['with_lot'] = $product['Product']['with_lot'];
                $i++;
            }
            }
            $this->set('usedProductIds', $usedProductIds);
        } else {
            if(!empty($transportBillRides)) {
                foreach ($transportBillRides as $transportBillRide) {
                    $transportBillRideIds[] = $transportBillRide['TransportBillDetailRides']['id'];
                    $detailRideIds[] = $transportBillRide['DetailRide']['id'];
                    $departureIds[] = $transportBillRide['Departure']['id'];
                    $arrivalIds[] = $transportBillRide['Arrival']['id'];
                    $supplierFinalIds[] = $transportBillRide['TransportBillDetailRides']['supplier_final_id'];
                    $carIds[] = $transportBillRide['TransportBillDetailRides']['car_id'];
                }
            }
        }
        $typeRide = $this->Parameter->getCodesParameterVal('type_ride');
        $typePricing = $this->Parameter->getCodesParameterVal('type_pricing');
        $departures = $this->Destination->getDestinationsByConditions(array('Destination.id' => $departureIds), 'list');
        $arrivals = $this->Destination->getDestinationsByConditions(array('Destination.id' => $arrivalIds), 'list');
        $conditions =array('Car.id'=>$carIds);
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $cars = $this->Car->getCarsByCondition($param,$conditions );
        $transportBillDetailRideInputFactors = $this->TransportBillDetailRideFactor->find('all',
            array('conditions'=>array(
                'TransportBillDetailRideFactor.transport_bill_detail_ride_id'=>$transportBillRideIds,
                'Factor.factor_type = 1'
            ),
                'recursive'=>-1,
                'order'=>array('TransportBillDetailRideFactor.transport_bill_detail_ride_id ASC'),
                'fields'=>array('TransportBillDetailRideFactor.transport_bill_detail_ride_id',
                    'TransportBillDetailRideFactor.factor_id',
                    'TransportBillDetailRideFactor.id',
                    'TransportBillDetailRideFactor.factor_value',
                    'Factor.name',
                    'Factor.factor_type',
                ),
                'joins'=>array(
                    array(
                        'table' => 'factors',
                        'type' => 'left',
                        'alias' => 'Factor',
                        'conditions' => array('TransportBillDetailRideFactor.factor_id = Factor.id')
                    ),
                )
            )
        );
        $transportBillDetailRideSelectFactors = $this->TransportBillDetailRideFactor->find('all',
            array('conditions'=>array(
                'TransportBillDetailRideFactor.transport_bill_detail_ride_id'=>$transportBillRideIds,
                'Factor.factor_type = 2'
            ),
                'recursive'=>-1,
                'order'=>array('TransportBillDetailRideFactor.transport_bill_detail_ride_id ASC'),
                'fields'=>array('TransportBillDetailRideFactor.transport_bill_detail_ride_id',
                    'TransportBillDetailRideFactor.factor_id',
                    'TransportBillDetailRideFactor.id',
                    'TransportBillDetailRideFactor.factor_value',
                    'Factor.name',
                    'Factor.factor_type',
                ),
                'joins'=>array(
                    array(
                        'table' => 'factors',
                        'type' => 'left',
                        'alias' => 'Factor',
                        'conditions' => array('TransportBillDetailRideFactor.factor_id = Factor.id')
                    ),
                )
            )
        );

        if(!empty($transportBillDetailRideSelectFactors)){
            $i=0;
            foreach ($transportBillDetailRideSelectFactors as $factor){
                $this->loadModel($factor['Factor']['name']);
                $model = $factor['Factor']['name'];
                $transportBillDetailRideSelectFactors[$i]['Factor']['options'] = $this->$model->find('list');
                $i  ++;
            }
        }
        $this->set(compact('transportBillDetailRideInputFactors','transportBillDetailRideSelectFactors'));
       if(!empty($invoice)){
           $supplierId = $invoice['TransportBill']['supplier_id'];
           $finalSuppliers = $this->Supplier->getFinalSuppliersByInitialSupplier($supplierId, $supplierFinalIds);
       }else {
           $supplierId = null;
           $finalSuppliers = array();
       }

        $nbTrucksModifiable = $this->Parameter->getCodesParameterVal('nb_trucks_modifiable');
        $defaultNbTrucks = $this->Parameter->getCodesParameterVal('default_nb_trucks');
        $tvas = $this->Tva->getTvas();
        $type=TransportBillTypesEnum::invoice;
        $priceCategories = $this->PriceCategory->getPriceCategories('list');
        $products = $this->Product->getProducts('list');
        $carTypes = $this->CarType->getCarTypes();
        $this->set(compact('reference','useRideCategory','paramPriceNight','permissionEditInputLocked',
            'typeRide', 'typePricing','departures','arrivals','cars','finalSuppliers','nbTrucksModifiable',
            'defaultNbTrucks','tvas','profileId','type','usePurchaseBill','priceCategories','products','carTypes'));

    }

   public function getCustomerInvoices($supplierId = null){
       $this->layout = 'ajax';
       $invoices = $this->TransportBill->getInvoicesWithoutCreditNote('list',$supplierId);
       $this->set(compact('invoices'));
   }

    public function getTotalPriceInvoice($invoiceId = null){
       $this->layout = 'ajax';
       if(!empty($invoiceId)){
           $invoice = $this->TransportBill->getTransportBillById($invoiceId);
       }else {
           $invoice = array();
       }

       $profileId = $this->Auth->user('profile_id');
       $type = TransportBillTypesEnum::invoice;
       $this->set(compact('invoice','profileId','type'));
   }

    public function getSimulationByTypeRide($typeRide = null)
    {
        $carTypes = $this->CarType->getCarTypes();
        $this->set(compact('typeRide', 'carTypes'));
    }

    public function viewDetail($transportBillId = null, $type = null)
    {

        $this->layout = 'ajax';
        $this->set('type', $type);
        $profileId = $this->Auth->user('profile_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        $this->set('profileId', $profileId);
        $this->set('transportBillId', $transportBillId);

        //Get the structure of the car name from parameters
        $paramCarName = $this->Parameter->getCodesParameterVal('name_car');
        $this->set('paramCarName', $paramCarName);
        if ($type == TransportBillTypesEnum::pre_invoice ||
            $type == TransportBillTypesEnum::invoice ||
        $type == TransportBillTypesEnum::credit_note
        ) {


            $query['count'] = " SELECT COUNT(*) AS `count` FROM `transport_bill_detail_rides` AS `TransportBillDetailRides` 
                                left JOIN `detail_rides` AS `DetailRide` ON (`TransportBillDetailRides`.`detail_ride_id` = `DetailRide`.`id`) 
                                left JOIN `rides` AS `Ride` ON (`DetailRide`.`ride_id` = `Ride`.`id`) 
                                left JOIN `suppliers` AS `SupplierFinal` ON (`TransportBillDetailRides`.`supplier_final_id` = `SupplierFinal`.`id`) 
                                left JOIN `car_types` AS `CarType` ON (`DetailRide`.`car_type_id` = `CarType`.`id`) 
                                left JOIN `destinations` AS `DepartureDestination` ON (`DepartureDestination`.`id` = `Ride`.`departure_destination_id`) 
                                left JOIN `destinations` AS `ArrivalDestination` ON (`ArrivalDestination`.`id` = `Ride`.`arrival_destination_id`) 
                                left JOIN `destinations` AS `Departure` ON (`Departure`.`id` = `TransportBillDetailRides`.`departure_destination_id`) 
                                left JOIN `destinations` AS `Arrival` ON (`Arrival`.`id` = `TransportBillDetailRides`.`arrival_destination_id`) 
                                left JOIN `car_types` AS `Type` ON (`TransportBillDetailRides`.`car_type_id` = `Type`.`id`) 
                                left JOIN `sheet_ride_detail_rides` AS `SheetRideDetailRides` ON (`TransportBillDetailRides`.`sheet_ride_detail_ride_id` = `SheetRideDetailRides`.`id`) 
                                left JOIN `transport_bill_detail_rides` AS `OrderDetails` ON (`OrderDetails`.`id` = `SheetRideDetailRides`.`transport_bill_detail_ride_id`) 
                                left JOIN `transport_bills` AS `TransportBill` ON (`TransportBill`.`id` = `OrderDetails`.`transport_bill_id`) 
                                left JOIN `sheet_rides` AS `SheetRide` ON (`SheetRide`.`id` = `SheetRideDetailRides`.`sheet_ride_id`) 
                                left JOIN `car` AS `Car` ON (`SheetRide`.`car_id` = `Car`.`id`) 
                                left JOIN `customers` AS `Customer` ON (`Customer`.`id` = `SheetRide`.`customer_id`) 
                                left JOIN `carmodels` AS `Carmodel` ON (`Car`.`carmodel_id` = `Carmodel`.`id`) 
                                left JOIN `lots` AS `Lot` ON (`TransportBillDetailRides`.`lot_id` = `Lot`.`id`) 
                                left JOIN `products` AS `Product` ON (`Lot`.`product_id` = `Product`.`id`) 
                                WHERE `TransportBillDetailRides`.`transport_bill_id` =  ". $transportBillId;
            $query['detail'] =
                " SELECT `CarType`.`name`, `DepartureDestination`.`name`, `ArrivalDestination`.`name`, 
                  `Departure`.`name`, `Arrival`.`name`, `Type`.`name`, `Ride`.`wording`, `Ride`.`distance`, 
                  `TransportBillDetailRides`.`reference`, `TransportBillDetailRides`.`id`, 
                  `TransportBillDetailRides`.`lot_id`, `TransportBillDetailRides`.`from_customer_order`, 
                  `TransportBillDetailRides`.`type_ride`, `TransportBillDetailRides`.`type_pricing`, 
                  `TransportBillDetailRides`.`approved`, `SheetRide`.`reference`, `TransportBillDetailRides`.`unit_price`,
                   `TransportBillDetailRides`.`nb_trucks`, `TransportBillDetailRides`.`price_ht`, 
                   `TransportBillDetailRides`.`price_ttc`, `TransportBillDetailRides`.`status_id`, 
                   `SheetRideDetailRides`.`reference`, `SheetRide`.`car_subcontracting`, `SheetRide`.`car_name`, 
                   `SheetRide`.`remorque_name`, `SheetRide`.`customer_name`, `Car`.`code`, 
                   `SheetRideDetailRides`.`real_start_date`, `SheetRideDetailRides`.`real_end_date`, `Customer`.`first_name`, 
                   `Customer`.`last_name`, `Car`.`immatr_def`, `Carmodel`.`name`, `SupplierFinal`.`name`, 
                   `Product`.`name`, `TransportBill`.`date`,
                   CONCAT(`Customer`.`first_name`,' - ', `Customer`.`last_name`) as full_name,
                   CONCAT(`Car`.`code` ,' - ', `Carmodel`.`name`) as car_name ,
                   CONCAT(`DepartureDestination`.`name` ,' - ', `ArrivalDestination`.`name`) as trajet
                   FROM `transport_bill_detail_rides` AS `TransportBillDetailRides` 
                   left JOIN `detail_rides` AS `DetailRide` ON (`TransportBillDetailRides`.`detail_ride_id` = `DetailRide`.`id`) 
                   left JOIN `rides` AS `Ride` ON (`DetailRide`.`ride_id` = `Ride`.`id`) 
                   left JOIN `suppliers` AS `SupplierFinal` ON (`TransportBillDetailRides`.`supplier_final_id` = `SupplierFinal`.`id`) 
                   left JOIN `car_types` AS `CarType` ON (`DetailRide`.`car_type_id` = `CarType`.`id`) 
                   left JOIN `destinations` AS `DepartureDestination` ON (`DepartureDestination`.`id` = `Ride`.`departure_destination_id`) 
                   left JOIN `destinations` AS `ArrivalDestination` ON (`ArrivalDestination`.`id` = `Ride`.`arrival_destination_id`) 
                   left JOIN `destinations` AS `Departure` ON (`Departure`.`id` = `TransportBillDetailRides`.`departure_destination_id`) 
                   left JOIN `destinations` AS `Arrival` ON (`Arrival`.`id` = `TransportBillDetailRides`.`arrival_destination_id`) 
                   left JOIN `car_types` AS `Type` ON (`TransportBillDetailRides`.`car_type_id` = `Type`.`id`) 
                   left JOIN `sheet_ride_detail_rides` AS `SheetRideDetailRides` ON (`TransportBillDetailRides`.`sheet_ride_detail_ride_id` = `SheetRideDetailRides`.`id`) 
                   left JOIN `transport_bill_detail_rides` AS `OrderDetails` ON (`OrderDetails`.`id` = `SheetRideDetailRides`.`transport_bill_detail_ride_id`) 
                   left JOIN `transport_bills` AS `TransportBill` ON (`TransportBill`.`id` = `OrderDetails`.`transport_bill_id`) 
                   left JOIN `sheet_rides` AS `SheetRide` ON (`SheetRide`.`id` = `SheetRideDetailRides`.`sheet_ride_id`) 
                   left JOIN `car` AS `Car` ON (`SheetRide`.`car_id` = `Car`.`id`) 
                   left JOIN `customers` AS `Customer` ON (`Customer`.`id` = `SheetRide`.`customer_id`) 
                   left JOIN `carmodels` AS `Carmodel` ON (`Car`.`carmodel_id` = `Carmodel`.`id`) 
                   left JOIN `lots` AS `Lot` ON (`TransportBillDetailRides`.`lot_id` = `Lot`.`id`) 
                   left JOIN `products` AS `Product` ON (`Lot`.`product_id` = `Product`.`id`) 
                   WHERE `TransportBillDetailRides`.`transport_bill_id` =   ".$transportBillId ;

            $query['conditions'] = '';
            if($type == TransportBillTypesEnum::pre_invoice){
                $query['columns'] = array(
                    0 => array('TransportBillDetailRides.reference','TransportBillDetailRides', 'reference', 'Reference', 'string',''),
                    1 => array('DepartureDestination.name','0', 'trajet',  'Ride', 'string','CONCAT','DepartureDestination.name','ArrivalDestination.name'),
                    2 => array('SupplierFinal.name','SupplierFinal', 'name', 'Supplier final', 'string',''),
                    3 => array('TransportBillDetailRides.unit_price','TransportBillDetailRides', 'unit_price', 'Unit price', 'int',''),
                    4 => array('TransportBillDetailRides.price_ht','TransportBillDetailRides', 'price_ht', 'Price Ht', 'int',''),
                    5 => array('TransportBillDetailRides.price_ttc','TransportBillDetailRides', 'price_ttc', 'Price ttc', 'int',''),
                    6 => array('SheetRideDetailRides.reference','SheetRideDetailRides', 'reference', 'Reference mission', 'string',''),
                    7 => array('SheetRide.reference','SheetRide', 'reference', 'Reference sheet ride', 'string',''),
                    8 => array('Carmodel.name','0', 'car_name',  'Car', 'string','CONCAT','Carmodel.name','Car.code'),
                    9 => array('Customer.first_name','0', 'full_name','Customer', 'string','CONCAT', 'Customer.first_name','Customer.last_name'),
                    10 => array('SheetRideDetailRides.real_start_date','SheetRideDetailRides', 'real_start_date', 'Real Departure date', 'date',''),
                    11 => array('SheetRideDetailRides.real_end_date','SheetRideDetailRides', 'real_end_date', 'Real end date', 'date',''),
                    12 => array('TransportBill.date','TransportBill', 'date', 'Order date', 'date',''),
                    13 => array('TransportBillDetailRides.approved','TransportBillDetailRides', 'approved', 'Approved', 'int',''),
                );
            }else {
                $query['columns'] = array(
                    0 => array('TransportBillDetailRides.reference','TransportBillDetailRides', 'reference', 'Reference', 'string',''),
                    1 => array('DepartureDestination.name','0', 'trajet',  'Ride', 'string','CONCAT','DepartureDestination.name','ArrivalDestination.name'),
                    2 => array('SupplierFinal.name','SupplierFinal', 'name', 'Supplier final', 'string',''),
                    3 => array('TransportBillDetailRides.unit_price','TransportBillDetailRides', 'unit_price', 'Unit price', 'int',''),
                    4 => array('TransportBillDetailRides.price_ht','TransportBillDetailRides', 'price_ht', 'Price Ht', 'int',''),
                    5 => array('TransportBillDetailRides.price_ttc','TransportBillDetailRides', 'price_ttc', 'Price ttc', 'int',''),
                    6 => array('SheetRideDetailRides.reference','SheetRideDetailRides', 'reference', 'Reference mission', 'string',''),
                    7 => array('SheetRide.reference','SheetRide', 'reference', 'Reference sheet ride', 'string',''),
                    8 => array('Carmodel.name','0', 'car_name',  'Car', 'string','CONCAT','Carmodel.name','Car.code'),
                    9 => array('Customer.first_name','0', 'full_name','Customer', 'string','CONCAT', 'Customer.first_name','Customer.last_name'),
                    10 => array('SheetRideDetailRides.real_start_date','SheetRideDetailRides', 'real_start_date', 'Real Departure date', 'date',''),
                    11 => array('SheetRideDetailRides.real_end_date','SheetRideDetailRides', 'real_end_date', 'Real end date', 'date',''),
                    12 => array('TransportBill.date','TransportBill', 'date', 'Order date', 'date',''),
                );
            }

            $query['order'] = ' TransportBillDetailRides.id desc';
            $query['tableName'] = 'TransportBillDetailRides';
            $query['entityName'] = 'TransportBillDetailRides';
            $query['controller'] = 'transportBillDetailRides';
            $query['action'] = 'viewDetail';
            $query['itemName'] = array('reference');
            $query['type'] = $type;
            $this->Session->write('query', $query);
            //get default user limit value
            $defaultLimit =  $this->getLimit();
            if (isset($defaultLimit) && $defaultLimit > 0) {
                $this->set('defaultLimit', $defaultLimit);
            } else {
                $this->set('defaultLimit', 20);
            }


            $action = 'viewDetail';
            $controller =  'transportBillDetailRides';
            $deleteFonction =  'deleteTransportBillDetailRides/';

            $this->set(compact('action','controller','deleteFonction','type'));

           /* $rides = $this->TransportBillDetailRides->find('all',
                array(
                    'conditions' => array(
                        'TransportBillDetailRides.transport_bill_id' => $transportBillId
                    ),
                    'recursive' => -1,
                    'fields' => array(
                        'CarType.name',
                        'DepartureDestination.name',
                        'ArrivalDestination.name',
                        'Departure.name',
                        'Arrival.name',
                        'Type.name',
                        'Ride.wording',
                        'Ride.distance',
                        'TransportBillDetailRides.reference',
                        'TransportBillDetailRides.id',
                        'TransportBillDetailRides.lot_id',
                        'TransportBillDetailRides.from_customer_order',
                        'TransportBillDetailRides.type_ride',
                        'TransportBillDetailRides.type_pricing',
                        'TransportBillDetailRides.approved',
                        'SheetRide.reference',
                        'TransportBillDetailRides.unit_price',
                        'TransportBillDetailRides.nb_trucks',
                        'TransportBillDetailRides.price_ht',
                        'TransportBillDetailRides.price_ttc',
                        'TransportBillDetailRides.status_id',
                        'SheetRideDetailRides.reference',
                        'SheetRide.car_subcontracting',
                        'SheetRide.car_name',
                        'SheetRide.remorque_name',
                        'SheetRide.customer_name',
                        'Car.code',
                        'SheetRide.real_start_date',
                        'SheetRide.real_end_date',
                        'Customer.first_name',
                        'Customer.last_name',
                        'Car.immatr_def',
                        'Carmodel.name',
                        'SupplierFinal.name',
                        'Product.name',
                        'TransportBill.date',
                    ),
                    'joins' => array(
                        array(
                            'table' => 'detail_rides',
                            'type' => 'left',
                            'alias' => 'DetailRide',
                            'conditions' => array('TransportBillDetailRides.detail_ride_id = DetailRide.id')
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
                            'alias' => 'SupplierFinal',
                            'conditions' => array('TransportBillDetailRides.supplier_final_id = SupplierFinal.id')
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
                            'table' => 'car_types',
                            'type' => 'left',
                            'alias' => 'Type',
                            'conditions' => array('TransportBillDetailRides.car_type_id = Type.id')
                        ),
                        array(
                            'table' => 'sheet_ride_detail_rides',
                            'type' => 'left',
                            'alias' => 'SheetRideDetailRides',
                            'conditions' => array('TransportBillDetailRides.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
                        ),

                        array(
                            'table' => 'transport_bill_detail_rides',
                            'type' => 'left',
                            'alias' => 'OrderDetails',
                            'conditions' => array('OrderDetails.id = SheetRideDetailRides.transport_bill_detail_ride_id')
                        ),

                        array(
                            'table' => 'transport_bills',
                            'type' => 'left',
                            'alias' => 'TransportBill',
                            'conditions' => array('TransportBill.id = OrderDetails.transport_bill_id')
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
                            'table' => 'customers',
                            'type' => 'left',
                            'alias' => 'Customer',
                            'conditions' => array('Customer.id = SheetRide.customer_id')
                        ),
                        array(
                            'table' => 'carmodels',
                            'type' => 'left',
                            'alias' => 'Carmodel',
                            'conditions' => array('Car.carmodel_id = Carmodel.id')
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

                ));*/

        }
        else {

            if ($type == TransportBillTypesEnum::quote ||
                $type == TransportBillTypesEnum::quote_request
            ) {
                $rides = $this->TransportBillDetailRides->find('all',
                    array(
                        'conditions' => array('TransportBillDetailRides.transport_bill_id' => $transportBillId),
                        'recursive' => -1,
                        'fields' => array(
                            'Departure.name',
                            'Arrival.name',
                            'Type.name',
                            'TransportBillDetailRides.reference',
                            'TransportBillDetailRides.from_customer_order',
                            'TransportBillDetailRides.type_ride',
                            'TransportBillDetailRides.type_pricing',
                            'CarType.name',
                            'DepartureDestination.name',
                            'ArrivalDestination.name',
                            'Ride.wording',
                            'Ride.distance',
                            'TransportBillDetailRides.id',
                            'TransportBillDetailRides.lot_id',
                            'TransportBillDetailRides.unit_price',
                            'TransportBillDetailRides.nb_trucks',
                            'TransportBillDetailRides.price_ht',
                            'TransportBillDetailRides.price_ttc',
                            'TransportBillDetailRides.status_id',
                            'SupplierFinal.name',
                            'Product.name',
                        ),
                        'joins' => array(
                            array(
                                'table' => 'detail_rides',
                                'type' => 'left',
                                'alias' => 'DetailRide',
                                'conditions' => array('TransportBillDetailRides.detail_ride_id = DetailRide.id')
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
            } else {
                $roleId = $this->Auth->user('role_id');
                $permissionCancel = $this->AccessPermission->getPermissionWithParams(SectionsEnum::annuler_commande_client,
                    ActionsEnum::view, $profileId, $roleId);
                $this->set('permissionCancel', $permissionCancel);
                $permissionOrder = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transmettre_commande_client,
                    ActionsEnum::view, $profileId, $roleId);
                $this->set('permissionOrder', $permissionOrder);
                $permissionComplaint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::reclamation,
                    ActionsEnum::view, $profileId, $roleId);
                $this->set('permissionComplaint', $permissionComplaint);
                $rides = $this->TransportBillDetailRides->find('all',
                    array(
                        'conditions' => array(
                            'TransportBillDetailRides.transport_bill_id' => $transportBillId,
                            'TransportBillDetailRides.lot_id =1',
                        ),
                        'recursive' => -1,
                        'fields' => array(
                            'TransportBillDetailRides.id',
                        )
                    ));

                $transportBillLots = $this->TransportBillDetailRides->find('all',
                    array(
                        'conditions' => array(
                            'TransportBillDetailRides.transport_bill_id' => $transportBillId,
                            'TransportBillDetailRides.lot_id != 1',
                        ),
                        'recursive' => -1,
                        'fields' => array(
                            'TransportBillDetailRides.id',
                            'TransportBillDetailRides.lot_id',
                            'TransportBillDetailRides.reference',
                            'TransportBillDetailRides.unit_price',
                            'TransportBillDetailRides.nb_trucks',
                            'TransportBillDetailRides.price_ht',
                            'TransportBillDetailRides.price_ttc',
                            'TransportBillDetailRides.status_id',
                            'TransportBillDetailRides.start_date',
                            'TransportBillDetailRides.end_date',
                            'TransportBillDetailRides.nb_hours',
                            'Car.immatr_def',
                            'Carmodel.name',
                            'CarType.name',
                            'Product.name',
                            'Product.name',
                            'ProductType.id',
                            'SupplierFinal.name',
                        ),
                        'joins' => array(
                            array(
                                'table' => 'suppliers',
                                'type' => 'left',
                                'alias' => 'SupplierFinal',
                                'conditions' => array('TransportBillDetailRides.supplier_final_id = SupplierFinal.id')
                            ),
                            array(
                                'table' => 'lots',
                                'type' => 'left',
                                'alias' => 'Lot',
                                'conditions' => array('TransportBillDetailRides.lot_id = Lot.id')
                            ),
                            array(
                                'table' => 'car_types',
                                'type' => 'left',
                                'alias' => 'CarType',
                                'conditions' => array('TransportBillDetailRides.car_type_id = CarType.id')
                            ),
                            array(
                                'table' => 'car',
                                'type' => 'left',
                                'alias' => 'Car',
                                'conditions' => array('TransportBillDetailRides.car_id = Car.id')
                            ),
                            array(
                                'table' => 'carmodels',
                                'type' => 'left',
                                'alias' => 'Carmodel',
                                'conditions' => array('Carmodel.id = Car.carmodel_id')
                            ),
                            array(
                                'table' => 'products',
                                'type' => 'left',
                                'alias' => 'Product',
                                'conditions' => array('Lot.product_id = Product.id')
                            ),
                            array(
                                'table' => 'product_types',
                                'type' => 'left',
                                'alias' => 'ProductType',
                                'conditions' => array('ProductType.id = Product.product_type_id')
                            ),
                        )
                    ));

                $this->set('transportBillLots', $transportBillLots);
                $transportBillDetailRideIds = array();
                foreach ($rides as $ride) {
                    $transportBillDetailRideIds[] = $ride['TransportBillDetailRides']['id'];
                }

                $sheetRideDetailRides = $this->SheetRideDetailRides->find('all', array(
                    'paramType' => 'querystring',
                    'recursive' => -1, // should be used with joins
                    'order' => array('SheetRideDetailRides.id' => 'ASC'),
                    'conditions' => array('TransportBillDetailRides.transport_bill_id' => $transportBillId),
                    'fields' => array(
                        'TransportBill.nb_trucks',
                        'SheetRideDetailRides.reference',
                        'SheetRideDetailRides.id',
                        'TransportBillDetailRides.id',
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
                        'SheetRideDetailRides.type_ride',
                        'SheetRideDetailRides.note',
                        'TransportBillDetailRides.id',
                        'TransportBillDetailRides.unit_price',
                        'TransportBillDetailRides.nb_trucks',
                        'TransportBillDetailRides.price_ht',
                        'TransportBillDetailRides.price_ttc',
                        'TransportBillDetailRides.status_id',
                        'TransportBillDetailRides.reference',
                        'SheetRide.car_subcontracting',
                        'SheetRide.car_name',
                        'SheetRide.remorque_name',
                        'SheetRide.customer_name',
                        'SheetRide.car_id',
                        'SheetRide.customer_id',
                        'Supplier.name',
                        'SupplierFinal.name',
                        'DepartureDestination.name',
                        'ArrivalDestination.name',
                        'CarType.name',
                        'Departure.name',
                        'Arrival.name',
                        'Car.code',
                        'Customer.first_name',
                        'Customer.last_name',
                        'Customer.mobile',
                        'Car.immatr_def',
                        'Carmodel.name',
                        'TransportBill.note',
                        'SheetRideDetailRides.observation_id',
                        'SheetRideDetailRides.id',
                        'Observation.id',
                        'Observation.customer_observation',
                        'COUNT(Complaint.id) AS complaint_count_mission',
                    ),
                    'group'=>'SheetRideDetailRides.id',
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
                            'table' => 'observations',
                            'type' => 'left',
                            'alias' => 'Observation',
                            'conditions' => array('Observation.id = SheetRideDetailRides.observation_id')
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
                            'conditions' => array('SheetRide.car_type_id = CarType.id')
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
                            'conditions' => array('TransportBill.supplier_id = Supplier.id')
                        ),
                        array(
                            'table' => 'suppliers',
                            'type' => 'left',
                            'alias' => 'SupplierFinal',
                            'conditions' => array('TransportBillDetailRides.supplier_final_id = SupplierFinal.id')
                        ),
                        array(
                            'table' => 'carmodels',
                            'type' => 'left',
                            'alias' => 'Carmodel',
                            'conditions' => array('Car.carmodel_id = Carmodel.id')
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
                            'table' => 'complaints',
                            'type' => 'left',
                            'alias' => 'Complaint',
                            'conditions' => array('SheetRideDetailRides.id = Complaint.sheet_ride_detail_ride_id')
                        )  ,


                    )
                ));


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
                        'Complaint.id',
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

                if (!empty($observationIdsWithMissions)) {
                    $conditions = array('Observation.transport_bill_detail_ride_id' => $transportBillDetailRideIds,
                        'Observation.id !=' => $observationIdsWithMissions
                    );
                } else {
                    $conditions = array('Observation.transport_bill_detail_ride_id' => $transportBillDetailRideIds
                    );
                }
                $observations = $this->Observation->getObservationsByConditions($conditions);
                $destinationId = array();
                foreach ($observations as $observation) {
                    $destinationId[] = $observation['TransportBillDetailRides']['departure_destination_id'];
                    $destinationId[] = $observation['TransportBillDetailRides']['arrival_destination_id'];
                }
                $carTypes = $this->CarType->getCarTypes();
                $destinations = $this->Destination->getDestinationsByConditions(array('Destination.id' => $destinationId), 'list');
                $this->set(compact('observations', 'sheetRideDetailRides',
                    'carTypes', 'destinations','countComplaintObservations'));

            }
        }
        $options = array(
            'conditions' => array(
                'TransportBill.' . $this->TransportBill->primaryKey => $transportBillId
            ),
            'recursive' => -1,
            'fields' => array(
                'TransportBill.id',
                'TransportBill.type',
            ),
        );

        $transportBill = $this->TransportBill->find('first', $options);

        $this->set(compact('rides', 'transportBill'));
    }

    public function approveMissions()
    {
        $this->autoRender = false;
        $transportBillId = $_POST['transportBillId'];
        //$transportBillId = 12675;
        $transportBillDetailRides = $this->TransportBillDetailRides->find('all',  array(
            'recursive'=>-1,
            'conditions' => array(

                'TransportBillDetailRides.transport_bill_id' => $transportBillId
            ),
            'fields' => array(
                'TransportBillDetailRides.id',
            )
        ));
        $missionIds = array();
        foreach ($transportBillDetailRides as $transportBillDetailRide){
            $missionIds[] = $transportBillDetailRide['TransportBillDetailRides']['id'];
        }
       // $missionIds = json_decode($_POST['missionIds']);
       // $approvedMissions= array(53829,53828,53827,53826,53825,53824,53823,53822,53821,53820,53819,53818,53817,53816,53815,53814,53813,53812,53811,53810,53809,53808,53807,53806,53805);
        $approvedMissions = json_decode($_POST['approvedMissions']);
        $notApprovedMissions = array_diff($missionIds, $approvedMissions);
        $this->TransportBillDetailRides->updateAll(
            array('TransportBillDetailRides.approved' => 1),
            array('TransportBillDetailRides.id ' => $approvedMissions)
        );
        $transportBillDetailRides = $this->TransportBillDetailRides->find('all',
            array(
                'recursive'=>-1,
                'conditions' => array(
                    'TransportBillDetailRides.id' => $approvedMissions
                ),
                'fields' => array(
                    'TransportBillDetailRides.sheet_ride_detail_ride_id',
                    'TransportBillDetailRides.approved'
                )
            )
        );
        $sheetRideDetailRideIds = array();
        foreach ($transportBillDetailRides as $transportBillDetailRide){
            $sheetRideDetailRideIds[] = $transportBillDetailRide['TransportBillDetailRides']['sheet_ride_detail_ride_id'];
        }
        $this->SheetRideDetailRides->updateAll(
            array('SheetRideDetailRides.status_id' => 5),
            array('SheetRideDetailRides.id ' => $sheetRideDetailRideIds)
        );
        $this->TransportBillDetailRides->updateAll(
            array('TransportBillDetailRides.approved' => 0),
            array('TransportBillDetailRides.id ' => $notApprovedMissions)
        );
        $transportBillDetailRides = $this->TransportBillDetailRides->find('all',
            array(
                'recursive'=>-1,
                'conditions' => array(
                    'TransportBillDetailRides.id' => $notApprovedMissions
                ),
                'fields' => array(
                    'TransportBillDetailRides.sheet_ride_detail_ride_id',
                    'TransportBillDetailRides.approved'
                )
            )
        );
        $sheetRideDetailRideIds = array();
        foreach ($transportBillDetailRides as $transportBillDetailRide){
            $sheetRideDetailRideIds[] = $transportBillDetailRide['TransportBillDetailRides']['sheet_ride_detail_ride_id'];
        }
        $this->SheetRideDetailRides->updateAll(
            array('SheetRideDetailRides.status_id' => 6),
            array('SheetRideDetailRides.id ' => $sheetRideDetailRideIds)
        );
        echo json_encode(array("response" => "true"));
    }


    public function loadAddFromCustomerOrder()
    {
        /*$conditions["TransportBill.type"] = 2;
        $conditions['TransportBillDetailRides.status_id'] = array(1, 2);
        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'order' => array('TransportBill.id' => 'DESC'),
            'conditions' => $conditions,
            'fields' => array(
                'TransportBill.reference',
                'TransportBill.id',
                'TransportBill.type',
                'TransportBill.supplier_id',
                'TransportBill.date',
                'CarType.name',
                'RideCategory.name',
                'TransportBillDetailRides.type_ride',
                'TransportBillDetailRides.reference',
                'TransportBillDetailRides.detail_ride_id',
                'TransportBillDetailRides.ride_category_id',
                'TransportBillDetailRides.unit_price',
                'TransportBillDetailRides.nb_trucks_validated',
                'TransportBillDetailRides.nb_trucks',
                'TransportBillDetailRides.price_ht',
                'TransportBillDetailRides.tva_id',
                'TransportBillDetailRides.price_ttc',
                'TransportBillDetailRides.ristourne_%',
                'TransportBillDetailRides.ristourne_val',
                'TransportBillDetailRides.id',
                'TransportBillDetailRides.status_id',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Supplier.name',
                'SupplierFinal.name',
                'Tva.name',
                'Departure.name',
                'Arrival.name',
                'Type.name',
                'Service.name'
            ),
            'joins' => array(

                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('TransportBillDetailRides.transport_bill_id = TransportBill.id')
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
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('TransportBill.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'SupplierFinal',
                    'conditions' => array('TransportBill.supplier_final_id = SupplierFinal.id')
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
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'Type',
                    'conditions' => array('TransportBillDetailRides.car_type_id = Type.id')
                ),
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'User',
                    'conditions' => array('TransportBill.user_id = User.id')
                ),

                array(
                    'table' => 'services',
                    'type' => 'left',
                    'alias' => 'Service',
                    'conditions' => array('User.service_id = Service.id')
                ),

            )
        );
        $transportBillDetailRides = $this->Paginator->paginate('TransportBillDetailRides');
        $this->set('transportBillDetailRides', $transportBillDetailRides);*/
        $this->updateIsOpen();
        $query['count'] =
            "SELECT COUNT(*) AS `count` FROM `transport_bill_detail_rides` AS `TransportBillDetailRides` 
            left JOIN `transport_bills` AS `TransportBill` ON (`TransportBillDetailRides`.`transport_bill_id` = `TransportBill`.`id`) 
            left JOIN `detail_rides` AS `DetailRide` ON (`TransportBillDetailRides`.`detail_ride_id` = `DetailRide`.`id`) 
            left JOIN `ride_categories` AS `RideCategory` ON (`TransportBillDetailRides`.`ride_category_id` = `RideCategory`.`id`) 
            left JOIN `car_types` AS `CarType` ON (`DetailRide`.`car_type_id` = `CarType`.`id`) 
            left JOIN `rides` AS `Ride` ON (`DetailRide`.`ride_id` = `Ride`.`id`) 
            left JOIN `suppliers` AS `Supplier` ON (`TransportBill`.`supplier_id` = `Supplier`.`id`) 
            left JOIN `suppliers` AS `SupplierFinal` ON (`TransportBillDetailRides`.`supplier_final_id` = `SupplierFinal`.`id`) 
            left JOIN `destinations` AS `DepartureDestination` ON (`DepartureDestination`.`id` = `Ride`.`departure_destination_id`) 
            left JOIN `destinations` AS `ArrivalDestination` ON (`ArrivalDestination`.`id` = `Ride`.`arrival_destination_id`) 
            left JOIN `destinations` AS `Departure` ON (`Departure`.`id` = `TransportBillDetailRides`.`departure_destination_id`) 
            left JOIN `destinations` AS `Arrival` ON (`Arrival`.`id` = `TransportBillDetailRides`.`arrival_destination_id`) 
            left JOIN `car_types` AS `Type` ON (`TransportBillDetailRides`.`car_type_id` = `Type`.`id`) 
            left JOIN `users` AS `User` ON (`TransportBill`.`user_id` = `User`.`id`) 
            left JOIN `services` AS `Service` ON (`TransportBill`.`service_id` = `Service`.`id`) 
            WHERE `TransportBill`.`type` = 2 AND `TransportBillDetailRides`.`status_id` IN (1, 2)  " ;

        $query['detail'] =
            "SELECT  `TransportBill`.`id`, `TransportBill`.`date`, `CarType`.`name`, `RideCategory`.`name`, 
            `TransportBillDetailRides`.`type_ride`, `TransportBillDetailRides`.`reference`, `TransportBillDetailRides`.`nb_trucks_validated`, 
            `TransportBillDetailRides`.`nb_trucks`, `TransportBillDetailRides`.`id`, `TransportBillDetailRides`.`status_id`,
             `DepartureDestination`.`name`, `ArrivalDestination`.`name`, `Supplier`.`name`, `SupplierFinal`.`name`, `Departure`.`name`, 
            `Arrival`.`name`, `Type`.`name`,`CarType`.`name`, `Service`.`name` , 
            CONCAT(`DepartureDestination`.`name` ,' - ', `ArrivalDestination`.`name`) as trajet
            FROM `transport_bill_detail_rides` AS `TransportBillDetailRides` 
            left JOIN `transport_bills` AS `TransportBill` ON (`TransportBillDetailRides`.`transport_bill_id` = `TransportBill`.`id`) 
            left JOIN `detail_rides` AS `DetailRide` ON (`TransportBillDetailRides`.`detail_ride_id` = `DetailRide`.`id`) 
            left JOIN `ride_categories` AS `RideCategory` ON (`TransportBillDetailRides`.`ride_category_id` = `RideCategory`.`id`) 
            left JOIN `car_types` AS `CarType` ON (`DetailRide`.`car_type_id` = `CarType`.`id`) 
            left JOIN `rides` AS `Ride` ON (`DetailRide`.`ride_id` = `Ride`.`id`) 
            left JOIN `suppliers` AS `Supplier` ON (`TransportBill`.`supplier_id` = `Supplier`.`id`) 
            left JOIN `suppliers` AS `SupplierFinal` ON (`TransportBillDetailRides`.`supplier_final_id` = `SupplierFinal`.`id`) 
            left JOIN `destinations` AS `DepartureDestination` ON (`DepartureDestination`.`id` = `Ride`.`departure_destination_id`) 
            left JOIN `destinations` AS `ArrivalDestination` ON (`ArrivalDestination`.`id` = `Ride`.`arrival_destination_id`)  
            left JOIN `destinations` AS `Departure` ON (`Departure`.`id` = `TransportBillDetailRides`.`departure_destination_id`) 
            left JOIN `destinations` AS `Arrival` ON (`Arrival`.`id` = `TransportBillDetailRides`.`arrival_destination_id`) 
            left JOIN `car_types` AS `Type` ON (`TransportBillDetailRides`.`car_type_id` = `Type`.`id`) 
            left JOIN `users` AS `User` ON (`TransportBill`.`user_id` = `User`.`id`) 
            left JOIN `services` AS `Service` ON (`TransportBill`.`service_id` = `Service`.`id`) 
            WHERE `TransportBill`.`type` = 2 AND `TransportBillDetailRides`.`status_id` IN (1, 2)  ";

        $useRideCategory = $this->useRideCategory();
        $this->Session->write('useRideCategory', $useRideCategory);
        if ($useRideCategory == '2') {
            $query['columns'] = array(
                0 => array('TransportBillDetailRides.reference','TransportBillDetailRides', 'reference', 'Reference', 'string',''),
                1 => array('DepartureDestination.name','0', 'trajet',  'Ride', 'string','CONCAT','DepartureDestination.name','ArrivalDestination.name','Departure.name','Arrival.name'),
                2 => array('CarType.name','CarType', 'name', 'Transportation', 'string','CONCAT','CarType.name','Type.name'),
                3 => array('RideCategory.name','RideCategory', 'name', 'Ride category', 'string',''),
                4 => array('TransportBill.date','TransportBill', 'date', 'Date', 'date',''),
                5 => array('Supplier.name','Supplier', 'name','Initial customer', 'string',''),
                6 => array('Service.name','Service', 'name', 'Service', 'string',''),
                7 => array('SupplierFinal.name','SupplierFinal', 'name', 'Final customer', 'string',''),
                8 => array('TransportBillDetailRides.nb_trucks','TransportBillDetailRides', 'nb_trucks', 'Number of trucks', 'number',''),
                9 => array('TransportBillDetailRides.nb_trucks_validated','TransportBillDetailRides', 'nb_trucks_validated', 'Number of trucks validated', 'number',''),
                10 => array('TransportBillDetailRides.status_id','TransportBillDetailRides', 'status_id', 'Status', 'number',''),
            );
        }else {
            $query['columns'] = array(
                0 => array('TransportBillDetailRides.reference','TransportBillDetailRides', 'reference', 'Reference', 'string',''),
                1 => array('DepartureDestination.name','0', 'trajet',  'Ride', 'string','CONCAT','DepartureDestination.name','ArrivalDestination.name','Departure.name','Arrival.name'),
                2 => array('CarType.name','CarType', 'name', 'Transportation', 'string','CONCAT','CarType.name','Type.name'),
                3 => array('TransportBill.date','TransportBill', 'date', 'Date', 'date',''),
                4 => array('Supplier.name','Supplier', 'name','Initial customer', 'string',''),
                5 => array('Service.name','Service', 'name', 'Service', 'string',''),
                6 => array('SupplierFinal.name','SupplierFinal', 'name', 'Final customer', 'string',''),
                7 => array('TransportBillDetailRides.nb_trucks','TransportBillDetailRides', 'nb_trucks', 'Number of trucks', 'number',''),
                8 => array('TransportBillDetailRides.nb_trucks_validated','TransportBillDetailRides', 'nb_trucks_validated', 'Number of trucks validated', 'number',''),
                9 => array('TransportBillDetailRides.status_id','TransportBillDetailRides', 'status_id', 'Status', 'number',''),
            );
        }
        $query['order'] = ' TransportBillDetailRides.id desc';
        $query['conditions'] = '';
        $query['tableName'] = 'TransportBillDetailRides';
        $query['controller'] = 'transportBillDetailRides';
        $query['itemName'] = array('reference');
        $query['action'] = 'addFromCustomerOrder';
        $this->Session->write('query', $query);
        //get default user limit value
        $defaultLimit =  $this->getLimit();;
        if (isset($defaultLimit) && $defaultLimit > 0) {
            $this->set('defaultLimit', $defaultLimit);
        } else {
            $this->set('defaultLimit', 20);
        }

        $controller =  'transportBillDetailRides';
        $action = 'addFromCustomerOrder';
        $deleteFonction =  'deleteTransportBillDetailRides/';
        $useRideCategory = $this->useRideCategory();
        $this->set(compact('useRideCategory','controller','deleteFonction','action'));
    }


    /**
     * ajouter une commande client : c le client lui meme qui va ajouter sa commande
     */
    public function addCustomerOrder()
    {

        $this->TransportBill->validate = $this->TransportBill->validate_request;
        $profileId = $this->Auth->user('profile_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        $this->set('profileId', $profileId);
        $supplierId = $this->Auth->user('supplier_id');
        if ($profileId == ProfilesEnum::client) {
            $this->set('supplierId', $supplierId);
        }
        $type = TransportBillTypesEnum::order;


        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index', $type));
            }

            $this->TransportBill->create();
            $this->createDateFromDate('TransportBill', 'date');
            $reference = $this->getNextTransportReference( $type);
            if($reference!='0'){
                $this->request->data['TransportBill']['reference'] = $reference;
            }
            $this->request->data['TransportBill']['type'] = $type;
            $customerOrderValidationMethod = $this->Supplier->getCustomerOrderValidationMethod($supplierId);
            if ($customerOrderValidationMethod == 1) {
                $this->request->data['TransportBill']['status'] = TransportBillDetailRideStatusesEnum::not_validated;
            } else {
                $this->request->data['TransportBill']['status'] = TransportBillDetailRideStatusesEnum::not_transmitted;
            }
            $this->request->data['TransportBill']['user_id'] = $this->Session->read('Auth.User.id');
            $rideId = $this->request->data['TransportBill']['ride_id'];
            $carTypeId = $this->request->data['TransportBill']['car_type_id'];
            $clientId = $this->request->data['TransportBill']['supplier_id'];
            $clientFinalId = $this->request->data['TransportBill']['supplier_final_id'];
            $deliveryWithReturn = $this->request->data['TransportBill']['delivery_with_return'];
            if (isset($this->request->data['TransportBill']['ride_category_id'])) {
                $rideCategoryId = $this->request->data['TransportBill']['ride_category_id'];
            } else {
                $rideCategoryId = null;
            }
            $detailRideId = $this->getDetailRide($rideId, $carTypeId);
            $price = $this->getPriceRide($detailRideId, 0, $clientId, $deliveryWithReturn, 1, $rideCategoryId);
            if (!empty($price)) {
                $unitPriceDeliverySimple = $price[0];
                $priceReturn = $price[2];
            } else {
                $unitPriceDeliverySimple = 0;
                $priceReturn = 0;
            }
            $nbTrucks = $this->request->data['TransportBill']['nb_trucks'];
            if ($this->request->data['TransportBill']['delivery_with_return'] == 1) {
                $unitPrice = $unitPriceDeliverySimple;
            } else {
                $unitPrice = $priceReturn;
            }
            $priceHt = ($unitPrice * $nbTrucks);
            $priceTtc = $priceHt + ($priceHt * 0.19);
            $priceTva = $priceTtc - $priceHt;
            $this->request->data['TransportBill']['total_ht'] = $priceHt;
            $this->request->data['TransportBill']['total_ttc'] = $priceTtc;
            $this->request->data['TransportBill']['total_tva'] = $priceTva;

            if ($this->TransportBill->save($this->request->data)) {
                $transportBillDetailRide = $this->calculPrice($detailRideId, $unitPrice, $nbTrucks, $deliveryWithReturn,
                    $rideCategoryId);
                $transportBillId = $this->TransportBill->getInsertID();
                $rideTransportBill = $transportBillDetailRide['TransportBillDetailRides'];

                $save = $this->add_Ride_transportBill($rideTransportBill, $reference, $transportBillId, $type, $clientFinalId, $customerOrderValidationMethod);
                if($save == false ){

                    $this->Flash->error(__('The transport bill could not be saved. Please, try again4.'));
                    $this->redirect(array('action' => 'index', $type));
                }
                $profileId = $this->Auth->user('profile_id');
                $parentId = $this->Profile->getParentProfileByProfileId($profileId);
                if ($parentId != Null) {
                    $profileId = $parentId;
                }
                if ($profileId == ProfilesEnum::client) {
                    $actionId = ActionsEnum::add;
                    $sectionId = SectionsEnum::nouvelle_commande;
                    $userId = $this->Auth->user('id');
                        $this->Notification->addNotification($transportBillId, $userId, $actionId, $sectionId);
                        $this->getNbNotificationsByUser();

                }
                $this->Flash->success(__('The customer order has been saved.'));
                $this->redirect(array('action' => 'index', $type));
            } else {
                $this->Flash->error(__('The customer order could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index', $type));
            }
        }
        $carTypes = $this->CarType->getCarTypes();
        $useRideCategory = $this->useRideCategory();
        if ($useRideCategory == '2') {
            $rideCategories = $this->RideCategory->getRideCategories();
        }


        $this->set(compact('carTypes', 'useRideCategory', 'rideCategories'));
    }

    public function editCustomerOrder($id)
    {
        $this->TransportBill->validate = $this->TransportBill->validate_request;
        $profileId = $this->Auth->user('profile_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        $this->set('profileId', $profileId);
        $supplierId = $this->Auth->user('supplier_id');
        if ($profileId == ProfilesEnum::client) {
            $this->set('supplierId', $supplierId);
        }
        $type = TransportBillTypesEnum::order;


        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index', $type));
            }

            $this->TransportBill->create();
            $this->createDateFromDate('TransportBill', 'date');
            $reference = $this->getNextTransportReference( $type);
            $this->request->data['TransportBill']['reference'] = $reference;
            $this->request->data['TransportBill']['type'] = $type;
            $customerOrderValidationMethod = $this->Supplier->getCustomerOrderValidationMethod($supplierId);
            if ($customerOrderValidationMethod == 1) {
                $this->request->data['TransportBill']['status'] = TransportBillDetailRideStatusesEnum::not_validated;
            } else {
                $this->request->data['TransportBill']['status'] = TransportBillDetailRideStatusesEnum::not_transmitted;
            }
            $this->request->data['TransportBill']['user_id'] = $this->Session->read('Auth.User.id');
            $rideId = $this->request->data['TransportBill']['ride_id'];
            $carTypeId = $this->request->data['TransportBill']['car_type_id'];
            $clientId = $this->request->data['TransportBill']['supplier_final_id'];
            $clientFinalId = $this->request->data['TransportBill']['supplier_id'];
            $deliveryWithReturn = $this->request->data['TransportBill']['delivery_with_return'];
            if (isset($this->request->data['TransportBill']['ride_category_id'])) {
                $rideCategoryId = $this->request->data['TransportBill']['ride_category_id'];
            } else {
                $rideCategoryId = null;
            }
            $detailRideId = $this->getDetailRide($rideId, $carTypeId);
            $price = $this->getPriceRide($detailRideId, 0, $clientId, $deliveryWithReturn, 1, $rideCategoryId);
            if (!empty($price)) {
                $unitPriceDeliverySimple = $price[0];
                $priceReturn = $price[2];
            } else {
                $unitPriceDeliverySimple = 0;
                $priceReturn = 0;
            }
            $nbTrucks = $this->request->data['TransportBill']['nb_trucks'];
            if ($this->request->data['TransportBill']['delivery_with_return'] == 1) {
                $unitPrice = $unitPriceDeliverySimple;
            } else {
                $unitPrice = $priceReturn;
            }
            $priceHt = ($unitPrice * $nbTrucks);
            $priceTtc = $priceHt + ($priceHt * 0.19);
            $priceTva = $priceTtc - $priceHt;
            $this->request->data['TransportBill']['total_ht'] = $priceHt;
            $this->request->data['TransportBill']['total_ttc'] = $priceTtc;
            $this->request->data['TransportBill']['total_tva'] = $priceTva;

            if ($this->TransportBill->save($this->request->data)) {
                $transportBillDetailRide = $this->TransportBillDetailRides->find('first', array(
                    'recursive' => -1,
                    'conditions' => array('TransportBillDetailRides.transport_bill_id' => $id),
                    'fields' => array('TransportBillDetailRides.id')
                ));
                $transportBillDetailRideId = $transportBillDetailRide['TransportBillDetailRides']['id'];
                $transportBillDetailRide = $this->calculPrice($detailRideId, $unitPrice, $nbTrucks, $deliveryWithReturn,
                    $rideCategoryId);
                $rideTransportBill = $transportBillDetailRide['TransportBillDetailRides'];
                $this->update_Ride_transportBill($rideTransportBill, $id, $transportBillDetailRideId, $type, $clientFinalId);
                $profileId = $this->Auth->user('profile_id');
                $parentId = $this->Profile->getParentProfileByProfileId($profileId);
                if ($parentId != Null) {
                    $profileId = $parentId;
                }
                if ($profileId == ProfilesEnum::client) {
                    $userId = $this->Auth->user('id');
                    $receivers = $this->User->getUsersReceiverClientNotifications();
                    $actionId = ActionsEnum::edit;
                    if (!empty($receivers)) {
                        $this->Notification->updateNotification($id, $userId, $receivers, $actionId);
                        $this->getNbNotificationsByUser();
                    }
                }
                $this->Flash->success(__('The customer order has been saved.'));
                $this->redirect(array('action' => 'index', $type));
            } else {
                $this->Flash->error(__('The customer order could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index', $type));
            }
        } else {
            $this->isOpenedByOtherUser("TransportBill", 'TransportBills', 'bill', $id, $type);
            $options = array('conditions' => array('TransportBill.' . $this->TransportBill->primaryKey => $id));
            $this->request->data = $this->TransportBill->find('first', $options);
            $this->TransportBill->Ride->virtualFields = array('cnames' => "CONCAT(DepartureDestination.name, ' - ', ArrivalDestination.name)");
            $rides = $this->TransportBill->Ride->find('list',
                array(
                    'fields' => 'cnames',
                    'conditions' => array('Ride.id' => $this->request->data['TransportBill']['ride_id']),
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
            $suppliers = $this->Supplier->getSuppliersByParams(1, 1, null, array(2, 3), null, $this->request->data['TransportBill']['supplier_id']);
            $finalSuppliers = $this->Supplier->getFinalSuppliersByInitialSupplier($this->request->data['TransportBill']['supplier_id'], $this->request->data['TransportBill']['supplier_final_id']);
            $this->set(compact('rides', 'suppliers', 'finalSuppliers'));
        }
        $carTypes = $this->CarType->getCarTypes();
        $useRideCategory = $this->useRideCategory();
        if ($useRideCategory == '2') {
            $rideCategories = $this->RideCategory->getRideCategories();
        }
        $this->set(compact('carTypes', 'useRideCategory', 'rideCategories', 'rides'));
    }

    /**
     * fonction pour valider les commande client non transmis ()
     */
    public function validateCustomerOrder()
    {
        $ids = filter_input(INPUT_POST, "chkids");
        $model = filter_input(INPUT_POST, "model");
        $arrayIds = explode(",", $ids);
        /*recuperer toutes les commandes qui ont été tchecked et avec le statut non transmis  */
        $status = TransportBillDetailRideStatusesEnum::not_validated;
        switch ($model){
            case 'TransportBill':
                $transportBills = $this->TransportBill->find('all',
                    array(
                        'recursive' => -1,
                        'conditions' => array(
                            'TransportBill.status' => TransportBillDetailRideStatusesEnum::not_transmitted,
                            'TransportBill.id' => $arrayIds
                        ),
                        'fields' => array('TransportBill.id', 'TransportBill.status', 'TransportBill.supplier_id')
                    ));

                if (!empty($transportBills)) {
                    foreach ($transportBills as $transportBill) {
                        $this->TransportBill->id = $transportBill['TransportBill']['id'];
                        $this->TransportBill->saveField('status', $status);

                        $actionId = ActionsEnum::transmit;
                        $sectionId = SectionsEnum::transmission_commande;
                        $userId = $this->Auth->user('id');
                        $transportBillId = $transportBill['TransportBill']['id'];
                            $this->Notification->addNotification($transportBillId,$userId, $actionId, $sectionId);
                            $this->getNbNotificationsByUser();
                        $actionId = ActionsEnum::add;
                        $sectionId = SectionsEnum::nouvelle_commande;
                        $transportBillId = $transportBill['TransportBill']['id'];

                            $this->Notification->addNotification($transportBillId, $userId, $actionId, $sectionId);
                            $this->getNbNotificationsByUser();



                    }
                }
                $transportBillDetailRides = $this->TransportBillDetailRides->find('all', array(
                    'conditions' => array('TransportBillDetailRides.transport_bill_id' => $arrayIds,
                        'TransportBillDetailRides.status_id' => TransportBillDetailRideStatusesEnum::not_transmitted,
                    ),
                    'fields' => array('TransportBillDetailRides.id', 'TransportBillDetailRides.status_id'),
                    'recursive' => -1
                ));
                if (!empty($transportBillDetailRides)) {
                    foreach ($transportBillDetailRides as $transportBillDetailRide) {
                        $this->TransportBillDetailRides->id = $transportBillDetailRide['TransportBillDetailRides']['id'];
                        $this->TransportBillDetailRides->saveField('status_id', $status);
                    }
                }


                break;

            case 'Observation':
                $observations = $this->Observation->find('all', array(
                    'conditions' => array('Observation.id' => $arrayIds,
                        'Observation.cancel_cause_id is NULL'),
                    'fields' => array('Observation.id','Observation.transport_bill_detail_ride_id'),
                    'recursive' => -1
                ));
                if (!empty($observations)) {
                    foreach ($observations as $observation) {

                        $transportBillDetailRideId = $observation['Observation']['transport_bill_detail_ride_id'];
                        $transportBillDetailRide = $this->TransportBillDetailRides->find('first', array(
                            'conditions' => array('TransportBillDetailRides.id' => $transportBillDetailRideId,
                                'TransportBillDetailRides.nb_trucks' => 1,
                            ),
                            'fields' => array('TransportBillDetailRides.id', 'TransportBillDetailRides.status_id'),
                            'recursive' => -1
                        ));
                        if(!empty($transportBillDetailRide)){
                            $this->TransportBillDetailRides->id = $transportBillDetailRideId;
                            $this->TransportBillDetailRides->saveField('status_id', $status);
                            
                        }
                    }
                }

                break;
        }


        $type = TransportBillTypesEnum::order;

        $this->redirect(array('action' => 'index', $type));
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
        $status = TransportBillDetailRideStatusesEnum::not_validated;
        switch ($model){
            case 'TransportBill':
                $transportBills = $this->TransportBill->find('all',
                    array(
                        'recursive' => -1,
                        'conditions' => array(
                            'TransportBill.status' => TransportBillDetailRideStatusesEnum::canceled,
                            'TransportBill.id' => $arrayIds
                        ),
                        'fields' => array('TransportBill.id', 'TransportBill.status', 'TransportBill.supplier_id')
                    ));

                if (!empty($transportBills)) {
                    foreach ($transportBills as $transportBill) {
                        $this->TransportBill->id = $transportBill['TransportBill']['id'];
                        $this->TransportBill->saveField('status', $status);
                        $this->TransportBill->saveField('cancel_cause_id', NULL);



                    }
                }
                $transportBillDetailRides = $this->TransportBillDetailRides->find('all', array(
                    'conditions' => array('TransportBillDetailRides.transport_bill_id' => $arrayIds,
                        'TransportBillDetailRides.status_id' => TransportBillDetailRideStatusesEnum::canceled,
                    ),
                    'fields' => array('TransportBillDetailRides.id', 'TransportBillDetailRides.status_id'),
                    'recursive' => -1
                ));

                if (!empty($transportBillDetailRides)) {
                    foreach ($transportBillDetailRides as $transportBillDetailRide) {
                        $this->TransportBillDetailRides->id = $transportBillDetailRide['TransportBillDetailRides']['id'];
                        $this->TransportBillDetailRides->saveField('status_id', $status);
                        $this->TransportBillDetailRides->saveField('cancel_cause_id', Null);

                        $observations = $this->Observation->find('all', array(
                            'conditions' => array('Observation.transport_bill_detail_ride_id' => $transportBillDetailRide['TransportBillDetailRides']['id']
                            ),
                            'fields' => array('Observation.id'),
                            'recursive' => -1
                        ));
                        if (!empty($observations)) {
                            foreach ($observations as $observation) {
                                $this->Observation->id = $observation['Observation']['id'];
                                $this->Observation->saveField('cancel_cause_id', Null);
                            }
                        }

                    }
                }


                break;

            case 'Observation':
                $observations = $this->Observation->find('all', array(
                    'conditions' => array('Observation.id' => $arrayIds),
                    'fields' => array('Observation.id','Observation.transport_bill_detail_ride_id'),
                    'recursive' => -1
                ));
                if (!empty($observations)) {
                    foreach ($observations as $observation) {
                        $this->Observation->id = $observation['Observation']['id'];
                        $this->Observation->saveField('cancel_cause_id', Null);
                        $transportBillDetailRideId = $observation['Observation']['transport_bill_detail_ride_id'];
                        $transportBillDetailRide = $this->TransportBillDetailRides->find('first', array(
                            'conditions' => array('TransportBillDetailRides.id' => $transportBillDetailRideId,
                                'TransportBillDetailRides.nb_trucks' => 1,
                            ),
                            'fields' => array('TransportBillDetailRides.id', 'TransportBillDetailRides.status_id'),
                            'recursive' => -1
                        ));
                        if(!empty($transportBillDetailRide)){
                            $this->TransportBillDetailRides->id = $transportBillDetailRideId;
                            $this->TransportBillDetailRides->saveField('status_id', $status);
                            $this->TransportBillDetailRides->saveField('cancel_cause_id', Null);

                        }
                    }
                }

                break;
        }

        $type = TransportBillTypesEnum::order;

        $this->redirect(array('action' => 'index', $type));
    }




    function cancelCustomerOrders($ids = null, $model = null)
    {

        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $this->TransportBill->validate = $this->TransportBill->validateCancelCauses;
        $arrayIds = explode(",", $ids);
        if (!empty($this->request->data)) {
            $status = TransportBillDetailRideStatusesEnum::canceled;
                switch ($model){
                    case 'TransportBill' :
                        /*recuperer toutes les commandes qui ont été tchecked et avec le statut non transmis  et non validée*/
                        $transportBills = $this->TransportBill->find('all',
                            array(
                                'recursive' => -1,
                                'conditions' => array(
                                    'TransportBill.status' => array(TransportBillDetailRideStatusesEnum::not_transmitted, TransportBillDetailRideStatusesEnum::not_validated),
                                    'TransportBill.id' => $arrayIds
                                ),
                                'fields' => array('TransportBill.id', 'TransportBill.status', 'TransportBill.supplier_id')
                            ));

                        if (!empty($transportBills)) {
                            foreach ($transportBills as $transportBill) {
                                $this->TransportBill->id = $transportBill['TransportBill']['id'];
                                $this->TransportBill->saveField('status', $status);
                                $this->TransportBill->saveField('cancel_cause_id', $this->request->data['TransportBill']['cancel_cause_id']);

                                $actionId = ActionsEnum::cancel;
                                $sectionId = SectionsEnum::annulation_commande;
                                $transportBillId = $transportBill['TransportBill']['id'];
                                $userId = $this->Auth->user('id');
                                    $this->Notification->addNotification($transportBillId, $userId,$actionId,$sectionId);
                                    $this->getNbNotificationsByUser();


                            }
                        }
                        $transportBillDetailRides = $this->TransportBillDetailRides->find('all', array(
                            'conditions' => array('TransportBillDetailRides.transport_bill_id' => $arrayIds,
                                'TransportBillDetailRides.status_id' => array(TransportBillDetailRideStatusesEnum::not_transmitted, TransportBillDetailRideStatusesEnum::not_validated),
                            ),
                            'fields' => array('TransportBillDetailRides.id', 'TransportBillDetailRides.status_id'),
                            'recursive' => -1
                        ));
                        if (!empty($transportBillDetailRides)) {
                            foreach ($transportBillDetailRides as $transportBillDetailRide) {
                                $this->TransportBillDetailRides->id = $transportBillDetailRide['TransportBillDetailRides']['id'];
                                $this->TransportBillDetailRides->saveField('status_id', $status);
                                $this->TransportBillDetailRides->saveField('cancel_cause_id', $this->request->data['TransportBill']['cancel_cause_id']);

                                $observations = $this->Observation->find('all', array(
                                    'conditions' => array('Observation.transport_bill_detail_ride_id' => $transportBillDetailRide['TransportBillDetailRides']['id']
                                    ),
                                    'fields' => array('Observation.id'),
                                    'recursive' => -1
                                ));
                                if (!empty($observations)) {
                                    foreach ($observations as $observation) {
                                        $this->Observation->id = $observation['Observation']['id'];
                                        $this->Observation->saveField('cancel_cause_id', $this->request->data['TransportBill']['cancel_cause_id']);
                                    }
                                }

                            }
                        }

                        break;
                    case 'Observation' ;

                        $observations = $this->Observation->find('all', array(
                            'conditions' => array('Observation.id' => $arrayIds,
                                'Observation.cancel_cause_id is NULL'),
                            'fields' => array('Observation.id','Observation.transport_bill_detail_ride_id'),
                            'recursive' => -1
                        ));
                        if (!empty($observations)) {
                            foreach ($observations as $observation) {
                                $this->Observation->id = $observation['Observation']['id'];
                                $this->Observation->saveField('cancel_cause_id', $this->request->data['TransportBill']['cancel_cause_id']);
                                $transportBillDetailRideId = $observation['Observation']['transport_bill_detail_ride_id'];
                                $transportBillDetailRide = $this->TransportBillDetailRides->find('first', array(
                                    'conditions' => array('TransportBillDetailRides.id' => $transportBillDetailRideId,
                                        'TransportBillDetailRides.nb_trucks' => 1,
                                    ),
                                    'fields' => array('TransportBillDetailRides.id', 'TransportBillDetailRides.status_id'),
                                    'recursive' => -1
                                ));
                                if(!empty($transportBillDetailRide)){
                                    $this->TransportBillDetailRides->id = $transportBillDetailRideId;
                                    $this->TransportBillDetailRides->saveField('status_id', $status);
                                    $this->TransportBillDetailRides->saveField('cancel_cause_id', $this->request->data['TransportBill']['cancel_cause_id']);

                                }
                            }
                        }
                        break;
                }

            $type = TransportBillTypesEnum::order;
            $this->Flash->success(__('The orders has been canceled.'));
            $this->redirect(array('action' => 'index', $type));
        }
        $cancelCauses = $this->CancelCause->getCancelCauses('list');

        $this->set('cancelCauses', $cancelCauses);
    }




    function addComplaint($ids = null)
    {

        $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validateComplaints;
        $arrayIds = explode(",", $ids);
        $observations = $this->Observation->find('all', array(
            'conditions' => array('Observation.id' => $arrayIds),
            'fields' => array('Observation.id',
                              'Observation.transport_bill_detail_ride_id',
                                'TransportBill.supplier_id',
                                'TransportBill.id',
                ),
            'joins' => array(
                array(
                    'table' => 'transport_bill_detail_rides',
                    'type' => 'left',
                    'alias' => 'TransportBillDetailRides',
                    'conditions' => array('TransportBillDetailRides.id = Observation.transport_bill_detail_ride_id')
                ),
                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('TransportBillDetailRides.transport_bill_id = TransportBill.id')
                ),
            ),
            'recursive' => -1
        ));
        $transportBillId = $observations[0]['TransportBill']['id'];

        if (!empty($this->request->data)) {

            if (!empty($observations)) {
                foreach ($observations as $observation) {
                    $this->request->data['Complaint']['observation_id'] = $observation['Observation']['id'];

                    $this->Complaint->create();
                    $this->createDateFromDate('Complaint', 'complaint_date');
                    $this->request->data['Complaint']['user_id'] = $this->Session->read('Auth.User.id');
                    $this->Complaint->save($this->request->data);
                    $countComplaintObservation = $this->Complaint->getNbComplaintsByObservation($this->request->data['Complaint']['observation_id']);
                    // var_dump($countComplaintMission); die();
                    $this->Observation->updateNbComplaints($this->request->data['Complaint']['observation_id'],$countComplaintObservation);

                    $actionId = ActionsEnum::add;
                    $sectionId = SectionsEnum::nouvelle_reclamation;
                    $complaintId = $this->Complaint->getInsertID();
                    $userId = $this->Auth->user('id');
                        $this->Notification->addNotification($complaintId, $userId,$actionId,$sectionId,'Mission');
                        $this->getNbNotificationsByUser();


                }
                $countComplaintOrders = $this->Complaint->getNbComplaintsByOrder($transportBillId);
                $this->TransportBill->updateNbComplaintsByObservations($transportBillId,$countComplaintOrders);

            }
            $this->Flash->success(__('The complaint has been saved.'));
            $type = TransportBillTypesEnum::order;
            $this->redirect(array('action' => 'index', $type));
        }
        $this->loadModel('ComplaintCause');
        $complaintCauses = $this->ComplaintCause->find('list');

        $this->set('complaintCauses', $complaintCauses);
    }




    /**
     * Show order detail client
     * @param null|int $id
     * @param null|int $nbTrucks
     * @param null|string $transportBillDetailRides
     */
    public function viewDetailCustomerOrder($id = null, $nbTrucks = null, $transportBillDetailRides = null)
    {
        if ($transportBillDetailRides == "TransportBillDetailRides") {
            $transportBillDetailRideId = $id;
        } else {
            $transportBillDetailRide = $this->TransportBillDetailRides->find('first', array(
                'recursive' => -1,
                'conditions' => array('TransportBillDetailRides.transport_bill_id' => $id),
                'fields' => array('TransportBillDetailRides.id')
            ));
            $transportBillDetailRideId = $transportBillDetailRide['TransportBillDetailRides']['id'];
        }
        $observations = $this->Observation->getObservationsByTransportBillDetailRideId($transportBillDetailRideId);
        $this->set('observations', $observations);

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
                'TransportBill.note',
                'SheetRideDetailRides.observation_id',
                'Observation.customer_observation'


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
                    'table' => 'observations',
                    'type' => 'left',
                    'alias' => 'Observation',
                    'conditions' => array('Observation.id = SheetRideDetailRides.observation_id')
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
        $observationIdsWithMissions = array();
        foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
            $observationIdsWithMissions[] = $sheetRideDetailRide['SheetRideDetailRides']['observation_id'];
        }
        if ($transportBillDetailRides == "TransportBillDetailRides") {
            if (!empty($observationIdsWithMissions)) {
                $conditions = array('Observation.transport_bill_detail_ride_id' => $transportBillDetailRideId,
                    'Observation.id !=' => $observationIdsWithMissions
                );
            } else {
                $conditions = array('Observation.transport_bill_detail_ride_id' => $transportBillDetailRideId
                );
            }

            $observations = $this->Observation->getObservationsByConditions($conditions);
            $this->set('observations', $observations);
        }

        //Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set(compact('sheetRideDetailRides', 'param'));
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

        $this->Observation->id = $id;
        $this->Observation->saveField('customer_observation', $value);


    }

    function updateDeparture()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $value = filter_input(INPUT_POST, "value");
        $crypto = $this->decrypt(filter_input(INPUT_POST, "crypto"));
        $explode = explode('|', $crypto);
        $id = $explode[1];

        $this->TransportBillDetailRides->id = $id;
        $this->TransportBillDetailRides->saveField('departure_destination_id', $value);
        $this->updatePrice($id);


    }

    function updatePrice($id)
    {
        $transportBillDetailRide = $this->TransportBillDetailRides->getTransportBillDetailRidesById($id);

        $price = $this->getPriceRide(0, 0,
            $transportBillDetailRide['TransportBill']['supplier_id'],
            $transportBillDetailRide['TransportBillDetailRides']['delivery_with_return'],
            $transportBillDetailRide['TransportBillDetailRides']['type_price'],
            $transportBillDetailRide['TransportBillDetailRides']['ride_category_id'],
            2, $transportBillDetailRide['TransportBillDetailRides']['departure_destination_id'],
            $transportBillDetailRide['TransportBillDetailRides']['arrival_destination_id'],
            $transportBillDetailRide['TransportBillDetailRides']['car_type_id']
        );
        if (!empty($price)) {
            $unitPriceDeliverySimple = $price[0];
            $priceReturn = $price[2];
        } else {
            $unitPriceDeliverySimple = 0;
            $priceReturn = 0;
        }
        $nbTrucks = $transportBillDetailRide['TransportBillDetailRides']['nb_trucks'];

        if ($transportBillDetailRide['TransportBillDetailRides']['delivery_with_return'] == 1) {
            $unitPrice = $unitPriceDeliverySimple;

        } else {
            $unitPrice = $priceReturn;
        }
        $priceHt = ($unitPrice * $nbTrucks);
        $priceTtc = $priceHt + ($priceHt * 0.19);
        $this->TransportBillDetailRides->id = $id;
        $this->TransportBillDetailRides->saveField('unit_price', $unitPrice);
        $this->TransportBillDetailRides->saveField('price_ht', $priceHt);
        $this->TransportBillDetailRides->saveField('price_ttc', $priceTtc);
        $transportBillId = $transportBillDetailRide['TransportBill']['id'];
        $transportBillDetailRides = $this->TransportBillDetailRides->getTransportBillDetailRidesByTransportBillId($transportBillId);

        if (!empty($transportBillDetailRides)) {
            $totalHt = 0;
            $totalTtc = 0;
            foreach ($transportBillDetailRides as $transportBillDetailRide) {
                $totalHt = $totalHt + $transportBillDetailRide['TransportBillDetailRides']['price_ht'];
                $totalTtc = $totalTtc + $transportBillDetailRide['TransportBillDetailRides']['price_ttc'];
            }
            $totalTva = $totalTtc - $totalHt;
            $this->TransportBill->id = $transportBillId;
            $this->TransportBill->saveField('total_ht', $totalHt);
            $this->TransportBill->saveField('total_ttc', $totalTtc);
            $this->TransportBill->saveField('total_tva', $totalTva);

        }
    }

    function updateArrival()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $value = filter_input(INPUT_POST, "value");
        $crypto = $this->decrypt(filter_input(INPUT_POST, "crypto"));
        $explode = explode('|', $crypto);
        $id = $explode[1];

        $this->TransportBillDetailRides->id = $id;
        $this->TransportBillDetailRides->saveField('arrival_destination_id', $value);

        $this->updatePrice($id);
    }

    function updateCarType()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $value = filter_input(INPUT_POST, "value");
        $crypto = $this->decrypt(filter_input(INPUT_POST, "crypto"));
        $explode = explode('|', $crypto);
        $id = $explode[1];

        $this->TransportBillDetailRides->id = $id;
        $this->TransportBillDetailRides->saveField('car_type_id', $value);
        $this->updatePrice($id);

    }

    /**
     * @param null $transportBillDetailRideId
     * @param null $controller
     * @param null $url
     * @param null $page
     */
    public function viewTransportBillDetailRideObservations($transportBillDetailRideId = null, $controller = null, $url = null , $page = null)
    {

        $this->set(compact('controller','url','page'));
        $observationIdsWithMissions = array();
        $sheetRideDetailRides = $this->SheetRideDetailRides->find('all', array(
            'recursive' => -1, // should be used with joins
            'conditions' => array('SheetRideDetailRides.transport_bill_detail_ride_id' => $transportBillDetailRideId),
            'fields' => array('SheetRideDetailRides.observation_id')
        ));

        foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
            $observationIdsWithMissions[] = $sheetRideDetailRide['SheetRideDetailRides']['observation_id'];
        }
        if (!empty($observationIdsWithMissions)) {
            $conditions = array('TransportBillDetailRides.status_id' => array(1, 2),
                'TransportBill.type' => 2,
                'Observation.transport_bill_detail_ride_id' => $transportBillDetailRideId,
                'Observation.id !=' => $observationIdsWithMissions);
        } else {
            $conditions = array('TransportBillDetailRides.status_id' => array(1, 2),
                'TransportBill.type' => 2,
                'Observation.transport_bill_detail_ride_id' => $transportBillDetailRideId);
        }

        $transportBillDetailRideInputFactors = $this->TransportBillDetailRideFactor->find('all',
            array('conditions'=>array(
                'TransportBillDetailRideFactor.transport_bill_detail_ride_id'=>$transportBillDetailRideId,
                'Factor.factor_type = 1'
            ),
                'recursive'=>-1,
                'fields'=>array(
                    'TransportBillDetailRideFactor.factor_value',
                    'Factor.name',
                ),
                'joins'=>array(
                    array(
                        'table' => 'factors',
                        'type' => 'left',
                        'alias' => 'Factor',
                        'conditions' => array('TransportBillDetailRideFactor.factor_id = Factor.id')
                    ),
                )

            )
        );
        $transportBillDetailRideSelectFactors = $this->TransportBillDetailRideFactor->find('all',
            array('conditions'=>array(
                'TransportBillDetailRideFactor.transport_bill_detail_ride_id'=>$transportBillDetailRideId,
                'Factor.factor_type = 2'
            ),
                'recursive'=>-1,
                'fields'=>array(
                    'TransportBillDetailRideFactor.factor_value',
                    'Factor.name',
                ),
                'joins'=>array(
                    array(
                        'table' => 'factors',
                        'type' => 'left',
                        'alias' => 'Factor',
                        'conditions' => array('TransportBillDetailRideFactor.factor_id = Factor.id')
                    ),
                )

            )
        );
        if(!empty($transportBillDetailRideSelectFactors)){

            $i=0;
            foreach ($transportBillDetailRideSelectFactors as $factor){
                $this->loadModel($factor['Factor']['name']);
                $model = $factor['Factor']['name'];
                $option= $this->$model->find('first',
                    array('conditions'=>array('id'=>$factor['TransportBillDetailRideFactor']['factor_value']),
                        'recursive'=>-1,
                        'fields'=>array('name')
                    ));
                $transportBillDetailRideSelectFactors[$i]['Factor']['options'] = $option[$model]['name'];
                $i  ++;
            }

        }
        $this->set(compact('transportBillDetailRideInputFactors','transportBillDetailRideSelectFactors'));
        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'order' => array('TransportBill.id' => 'DESC'),
            'conditions' => $conditions,
            'fields' => array(
                'TransportBill.reference',
                'TransportBill.id',
                'TransportBill.type',
                'TransportBill.supplier_id',
                'TransportBill.date',
                'CarType.name',
                'RideCategory.name',
                'TransportBillDetailRides.type_ride',
                'TransportBill.order_type',
                'TransportBillDetailRides.reference',
                'TransportBillDetailRides.detail_ride_id',
                'TransportBillDetailRides.unit_price',
                'TransportBillDetailRides.nb_trucks_validated',
                'TransportBillDetailRides.nb_trucks',
                'TransportBillDetailRides.price_ht',
                'TransportBillDetailRides.tva_id',
                'TransportBillDetailRides.price_ttc',
                'TransportBillDetailRides.ristourne_%',
                'TransportBillDetailRides.ristourne_val',
                'TransportBillDetailRides.id',
                'TransportBillDetailRides.status_id',
                'TransportBillDetailRides.nb_hours',
                'TransportBillDetailRides.start_date',
                'TransportBillDetailRides.programming_date',
                'TransportBillDetailRides.charging_time',
                'TransportBillDetailRides.unloading_date',
                'TransportBillDetailRides.observation_order',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Departure.name',
                'Arrival.name',
                'Type.name',
                'Supplier.name',
                'SupplierFinal.name',
                'Tva.name',
                'Observation.id',
                'Observation.customer_observation',
                'Observation.cancel_cause_id',
                'CancelCause.name',
                'Product.name',
                'ProductType.id',
                'Carmodel.name',
                'Car.immatr_def',
                'User.first_name',
                'User.last_name',
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
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('DetailRide.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('TransportBillDetailRides.car_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'ride_categories',
                    'type' => 'left',
                    'alias' => 'RideCategory',
                    'conditions' => array('TransportBillDetailRides.ride_category_id = RideCategory.id')
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
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'Type',
                    'conditions' => array('TransportBillDetailRides.car_type_id = Type.id')
                ),
                array(
                    'table' => 'cancel_causes',
                    'type' => 'left',
                    'alias' => 'CancelCause',
                    'conditions' => array('Observation.cancel_cause_id = CancelCause.id')
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
                    'conditions' => array('Product.id = Lot.product_id')
                ),
                array(
                    'table' => 'product_types',
                    'type' => 'left',
                    'alias' => 'ProductType',
                    'conditions' => array('ProductType.id = Product.product_type_id')
                ),
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'User',
                    'conditions' => array('User.id = TransportBill.user_id')
                ),
            )
        );

        $transportBillDetailRides = $this->Paginator->paginate('TransportBillDetailRides');

        $useRideCategory = $this->useRideCategory();
        $this->set(compact('transportBillDetailRides', 'useRideCategory'));


    }

    /**
     *
     */
    function addCategory()
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::categorie_piece, $user_id, ActionsEnum::add, "TransportBillCategories", null,
            "TransportBillCategory", null, 1);
        $this->set('result', $result);
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->TransportBillCategory->create();
            if ($this->TransportBillCategory->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $categoryId = $this->TransportBillCategory->getLastInsertId();
                $this->set('categoryId', $categoryId);
            }
        }
    }

    function getCategories()
    {
        $this->settimeactif();
        $this->layout = 'ajax';
        $categories = $this->TransportBillCategory->getTransportBillCategories('all');

        $this->set('selectbox', $categories);
        $this->set('selectedid', $this->params['pass']['0']);
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
        $customerCategories = $this->CustomerCategory->getCustomerCategories();
        $autocode = $this->getNextCode("Customer", 'conductor');
        $this->set(compact('customerCategories', 'autocode'));
        if (!empty($this->request->data)) {
            $this->Customer->create();
            if ($this->Customer->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $customerId = $this->Customer->getLastInsertId();
                $this->set('customerId', $customerId);
            }
        }
    }

    function getCustomers()
    {
        $this->settimeactif();
        $this->layout = 'ajax';
        $customers = $this->Customer->getCustomersByParams('all');

        $this->set('selectbox', $customers);
        $this->set('selectedid', $this->params['pass']['0']);
    }

    public function dissociate($type = null, $id = null)
    {
        switch ($type) {
            case TransportBillTypesEnum::quote_request:

                $transformations = $this->Transformation->find('all',
                    array(
                        'recursive' => -1,
                        'conditions' => array('Transformation.origin_transport_bill_id' => $id),
                        'fields' => array('Transformation.origin_transport_bill_id')
                    ));
                if (!empty($transformations)) {
                    $this->Transformation->deleteAll(array('Transformation.origin_transport_bill_id' => $id),
                        false);
                    $this->TransportBill->id = $id;
                    $this->TransportBill->saveField('status', 1);
                }

                break;

            case TransportBillTypesEnum::quote:
                $transformations = $this->Transformation->find('all',
                    array(
                        'recursive' => -1,
                        'conditions' => array('Transformation.origin_transport_bill_id' => $id),
                        'fields' => array('Transformation.origin_transport_bill_id')
                    ));
                if (!empty($transformations)) {
                    $this->Transformation->deleteAll(array('Transformation.origin_transport_bill_id' => $id),
                        false);
                    $this->TransportBill->id = $id;
                    $this->TransportBill->saveField('status', 1);
                }
                break;

            case TransportBillTypesEnum::order:
                $transportBillDetailRides = $this->TransportBillDetailRides->getTransportBillDetailRidesByTransportBillId($id);
                foreach ($transportBillDetailRides as $transportBillDetailRide) {
                    $transportBillDetailRideId = $transportBillDetailRide['TransportBillDetailRides']['id'];
                    $sheetRideDetailRides = $this->SheetRideDetailRides->getSheetRideDetailRidesByTransportBillDetailRideId($transportBillDetailRideId);
                    if (!empty($sheetRideDetailRides)) {
                        foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
                            $this->SheetRideDetailRides->id = $sheetRideDetailRide['SheetRideDetailRides']['id'];
                            $this->SheetRideDetailRides->saveField('transport_bill_detail_ride_id', NULL);
                        }
                    }
                    $this->TransportBillDetailRides->id = $transportBillDetailRideId;
                    $this->TransportBillDetailRides->saveField('nb_trucks_validated', 0);
                }
                $this->TransportBill->id = $id;
                $this->TransportBill->saveField('status', 1);
                break;

            case TransportBillTypesEnum::pre_invoice:
                $transformations = $this->Transformation->find('all',
                    array(
                        'recursive' => -1,
                        'conditions' => array('Transformation.origin_transport_bill_id' => $id),
                        'fields' => array('Transformation.origin_transport_bill_id')
                    ));
                if (!empty($transformations)) {
                    $this->Transformation->deleteAll(array('Transformation.origin_transport_bill_id' => $id),
                        false);
                    $this->TransportBill->id = $id;
                    $this->TransportBill->saveField('status', 1);
                }
                break;
        }
        $this->Flash->success(__('The bill has been dissociated.'));
        $this->redirect(array('action' => 'index', $type));
    }

    public function addDeadlineDiv($i = null)
    {
        $this->set(compact('i'));
    }

    public function getInformationProduct($i = null, $type = null, $typeRide = null, $productId = null)
    {
        $this->layout = 'ajax';
        $this->set('productId', $productId);
        $this->set('i', $i);

        $product = $this->Product->getProductById($productId);
        $productTypeId = $product['Product']['product_type_id'];
        $this->set('productTypeId', $productTypeId);
        switch ($productTypeId){
            case 1 :
                if ($typeRide == 1) {
                    $tvas = $this->Tva->getTvas();
                    $useRideCategory = $this->useRideCategory();
                    if ($useRideCategory == 2) {
                        $rideCategories = $this->RideCategory->getRideCategories();
                        $this->set('rideCategories', $rideCategories);
                    }
                    $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
                    $profileId = $this->Auth->user('profile_id');
                    $parentId = $this->Profile->getParentProfileByProfileId($profileId);
                    if ($parentId != Null) {
                        $profileId = $parentId;
                    }
                    $typeRide = 1;
                    $nbTrucksModifiable = $this->Parameter->getCodesParameterVal('nb_trucks_modifiable');
                    $defaultNbTrucks = $this->Parameter->getCodesParameterVal('default_nb_trucks');
                    $this->set(compact('tvas', 'type', 'useRideCategory', 'i', 'reference', 'paramPriceNight',
                        'profileId', 'typeRide', 'nbTrucksModifiable', 'defaultNbTrucks'));
                } else {
                    $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validatePersonalizedRide;
                    $tvas = $this->Tva->getTvas();
                    $useRideCategory = $this->useRideCategory();
                    if ($useRideCategory == 2) {
                        $rideCategories = $this->RideCategory->getRideCategories();
                        $this->set('rideCategories', $rideCategories);
                    }
                    $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
                    $profileId = $this->Auth->user('profile_id');
                    $parentId = $this->Profile->getParentProfileByProfileId($profileId);
                    if ($parentId != Null) {
                        $profileId = $parentId;
                    }
                    $typeRide = 2;
                    $nbTrucksModifiable = $this->Parameter->getCodesParameterVal('nb_trucks_modifiable');
                    $defaultNbTrucks = $this->Parameter->getCodesParameterVal('default_nb_trucks');
                    $carTypes = $this->CarType->getCarTypes();
                    $this->set(compact('tvas', 'type', 'useRideCategory', 'i',  'paramPriceNight',
                        'profileId', 'typeRide', 'nbTrucksModifiable', 'defaultNbTrucks', 'carTypes'));
                }
                break;
            case 2 :

                $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validateProvision;
                $tvas = $this->Tva->getTvas();
                $carTypes = $this->CarType->getCarTypes();
                $profileId = $this->Auth->user('profile_id');
                $parentId = $this->Profile->getParentProfileByProfileId($profileId);
                if ($parentId != Null) {
                    $profileId = $parentId;
                }
                $factors = $this->ProductTypeFactor->getInputFactorsByProductTypeId($productTypeId);

                $carRequired = $product['Product']['car_required'];

                $this->set(compact('tvas','carTypes','profileId','factors',
                    'i','carRequired'));

                break;
                case 3 :
                $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validateProvision;
                $tvas = $this->Tva->getTvas();
                $carTypes = $this->CarType->getCarTypes();
                $profileId = $this->Auth->user('profile_id');
                $parentId = $this->Profile->getParentProfileByProfileId($profileId);
                if ($parentId != Null) {
                    $profileId = $parentId;
                }
                $factors = $this->ProductTypeFactor->getInputFactorsByProductTypeId($productTypeId);

                $carRequired = $product['Product']['car_required'];
                $nbHours = $product['Product']['nb_hours'];
                $nbHoursRequired = $product['Product']['nb_hours_required'];

                $this->set(compact('tvas','carTypes','profileId','factors',
                    'i','nbHours','carRequired','nbHoursRequired'));
                break;
            default :
                $factors = $this->ProductTypeFactor->getInputFactorsByProductTypeId($productTypeId);
                $selectFactors = $this->ProductTypeFactor->getSelectFactorsByProductTypeId($productTypeId);
                if(!empty($selectFactors)){
                    $i=0;
                    foreach ($selectFactors as $factor){
                        $this->loadModel($factor['Factor']['name']);
                        $model = $factor['Factor']['name'];
                        $selectFactors[$i]['Factor']['options'] = $this->$model->find('list');
                        $i  ++;
                    }
                }
                $this->set(compact('factors','selectFactors'));
                $this->TransportBillDetailRides->validate = $this->TransportBillDetailRides->validateProduct;

                $product = $this->Product->getProductById($productId);
                $productWithLot = $product['Product']['with_lot'];
                $this->set(compact('productWithLot', 'i'));
                if ($productWithLot == 1) {
                    $lots = $this->Lot->getLotsByProductId($productId, 'all');
                    $this->set('lots', $lots);
                }
                break ;
        }

    }

    public function getArrivalDestination($i = null, $typeRide = null, $productId = null)
    {
        $product = $this->Product->getProductById($productId);
        $productTypeId = $product['Product']['product_type_id'];
        $this->set(compact('i', 'typeRide', 'productId','productTypeId'));
    }

    public function getTypeRide($i = null, $productId = null, $typeRide = null)
    {
        $typeRideParameter = $this->Parameter->getCodesParameterVal('type_ride');
        $typeRideUsedFirst = $this->Parameter->getCodesParameterVal('type_ride_used_first');
        $this->set(compact('i', 'productId', 'typeRide', 'typeRideParameter', 'typeRideUsedFirst'));
    }

    public function getDeliveryReturn($i = null, $productId = null, $deliveryWithReturn = null)
    {
        $this->set(compact('i', 'productId', 'deliveryWithReturn'));
    }

    public function getTypePricing($i = null, $productId = null)
    {
        $typePricing = $this->Parameter->getCodesParameterVal('type_pricing');
        $this->set(compact('i', 'productId', 'typePricing'));
    }

    public function getInformationPricing($i = null, $productId = null, $typePricing = null)
    {
        if ($typePricing == 2) {
            $tonnages = $this->Tonnage->getTonnages();
            $this->set(compact('tonnages'));
        }
        $this->set(compact('i', 'typePricing', 'productId'));
    }

    public function getDesignationProduct($i = null, $productId = null , $typeRide =null, $detailRideId = null ,
                                          $departureDestinationId= null , $arrivalDestinationId = null, $carTypeId= null){

        if ($productId !=1){
            $product = $this->Product->getProductById($productId);
            $this->set('product',$product);
        }else {
            if($typeRide==1){
                $detailRide = $this->DetailRide->getDetailRideByConditions(array('DetailRide.id'=>$detailRideId), "first",
                    array('DepartureDestination.name','ArrivalDestination.name','CarType.name'));

                $this->set('detailRide',$detailRide);
            }else {
                $departure = $this->Destination->getDestinationsByConditions(array('Destination.id' => $departureDestinationId), 'first');

                $arrival = $this->Destination->getDestinationsByConditions(array('Destination.id' => $arrivalDestinationId), 'first');
                $carType = $this->CarType->getCarTypeById($carTypeId);
                $this->set(compact('departure','arrival','carType'));
            }
        }
        $this->set(compact('i','productId','typeRide'));
    }


    public function editDescription($productId = null, $i = null , $description = null)
    {
        $this->set('saved', false);
        if (!empty($this->request->data['TransportBillDetailRides']['description'])
        ) {
            $this->set('newDescription', $this->request->data['TransportBillDetailRides']['description']);
            $this->set('i', $i);
            $this->set('saved', true);
        }
        $product = $this->Product->getProductById($productId);
        $this->set(compact('product', 'i', 'description','productId'));
    }

    public function saveDescription (){
        $this->autoRender = false;
       // $description = filter_input(INPUT_POST, "description");

        $description = json_decode($_POST['description']);
        $productId = json_decode($_POST['productId']);
        $this->Product->id=$productId ;
        $this->Product->saveField('description2',$description);
        if (isset($description)) {
            $response = true;
        } else {
            $response = false;
        }

        echo json_encode(array("response" => $response, 'data'=>$description,'product'=>$productId));
    }

    public function getDescription($productId= null, $i=null){

        $product = $this->Product->getProductById($productId);
        $description = $product['Product']['description2'];
        $this->set(compact('description','i'));
    }

    
	
	function lock()
    {
        $this->settimeactif();
        $userId = $this->Auth->user('id');
        $type =  $this->params['pass']['1'];
        if ($type == TransportBillTypesEnum::quote_request) {
            $this->verifyUserPermission(SectionsEnum::demande_de_devis, $userId, ActionsEnum::lock, "TransportBills",
                null, "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::quote) {
            $this->verifyUserPermission(SectionsEnum::devis, $userId, ActionsEnum::lock, "TransportBills", null,
                "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::order) {
            $this->verifyUserPermission(SectionsEnum::commande_client, $userId, ActionsEnum::lock, "TransportBills",
                null, "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::pre_invoice) {
            $this->verifyUserPermission(SectionsEnum::prefacture, $userId, ActionsEnum::lock, "TransportBills", null,
                "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::invoice) {
            $this->verifyUserPermission(SectionsEnum::facture, $userId, ActionsEnum::lock, "TransportBills", null,
                "TransportBill", $type);
        }

        $result = $this->setLocked('TransportBill', $this->params['pass']['0'], 1);
        if ($result) {
            $this->Flash->success(__('The bill has been locked.'));
        } else {
            $this->Flash->error(__('The bill could not be locked.'));
        }
        $this->redirect(array('action' => 'index',$type));
    }

    function unlock()
    {
        $this->settimeactif();
        $userId = $this->Auth->user('id');

        $type =  $this->params['pass']['1'];
        if ($type == TransportBillTypesEnum::quote_request) {
            $this->verifyUserPermission(SectionsEnum::demande_de_devis, $userId, ActionsEnum::lock, "TransportBills",
                null, "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::quote) {
            $this->verifyUserPermission(SectionsEnum::devis, $userId, ActionsEnum::lock, "TransportBills", null,
                "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::order) {
            $this->verifyUserPermission(SectionsEnum::commande_client, $userId, ActionsEnum::lock, "TransportBills",
                null, "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::pre_invoice) {
            $this->verifyUserPermission(SectionsEnum::prefacture, $userId, ActionsEnum::lock, "TransportBills", null,
                "TransportBill", $type);
        } elseif ($type == TransportBillTypesEnum::invoice) {
            $this->verifyUserPermission(SectionsEnum::facture, $userId, ActionsEnum::lock, "TransportBills", null,
                "TransportBill", $type);
        }

        $result = $this->setLocked('TransportBill', $this->params['pass']['0'], 0);
        if ($result) {
            $this->Flash->success(__('The bill has been unlocked.'));
        } else {
            $this->Flash->error(__('The bill could not be unlocked.'));
        }
        $this->redirect(array('action' => 'index',$type ));
    }

    function getStatusDiv($productId = null, $num = null , $statusId = null){
        $this->layout = 'ajax';
        $product = $this->Product->getProductById($productId);
        $relationWithPark = $product['ProductType']['relation_with_park'];
        $this->set('relationWithPark',$relationWithPark);
        $this->set(compact('num','statusId','relationWithPark'));
    }
    function getPenalties($withPenalty=null){
        $this->set('withPenalty',$withPenalty);
    }


    public function addRowPenalty($item = null)
    {
        $this->layout = 'ajax';
        $this->set(compact('item'));
    }

    public function getInputSupplierVarious($response = null){
        $this->layout = 'ajax';
        $this->set('response',$response);

    }

    public function getUnitPriceByTypeRide($sheetRideDetailRide = null){

        if ($sheetRideDetailRide['SheetRideDetailRides']['type_ride'] == 2) {
            $sheetRide = $this->SheetRide->getSheetRideBySheetRideDetailRideId($sheetRideDetailRide['SheetRideDetailRides']['id']);
            if ($sheetRideDetailRide['SheetRideDetailRides']['source'] == 4) {
                if($sheetRideDetailRide['SheetRideDetailRides']['price']==NULL){
                    $unitPrice = 0;
                } else {
                    $unitPrice = $sheetRideDetailRide['SheetRideDetailRides']['price'];
                }
            }else {
                if (!empty($sheetRideDetailRide['TransportBillDetailRides']['unit_price']) && ($sheetRideDetailRide['TransportBillDetailRides']['unit_price'] != 0)) {
                    $unitPrice = $sheetRideDetailRide['TransportBillDetailRides']['unit_price'];
                } else {
                    $typePricing = $sheetRideDetailRide['SheetRideDetailRides']['type_pricing'];
                    if ($typePricing == 1) {
                        $price = $this->getPriceRide(0, 0,
                            $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'],
                            $sheetRideDetailRide['SheetRideDetailRides']['return_mission'],
                            $sheetRideDetailRide['SheetRideDetailRides']['type_price'],
                            $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'],
                            2, $sheetRideDetailRide['SheetRideDetailRides']['departure_destination_id'],
                            $sheetRideDetailRide['SheetRideDetailRides']['arrival_destination_id'],
                            $sheetRide['SheetRide']['car_type_id'], 1
                        );
                    } else {
                        $price = $this->getPriceRide(0, 0,
                            $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'],
                            $sheetRideDetailRide['SheetRideDetailRides']['return_mission'],
                            $sheetRideDetailRide['SheetRideDetailRides']['type_price'],
                            $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'],
                            2, $sheetRideDetailRide['SheetRideDetailRides']['departure_destination_id'],
                            $sheetRideDetailRide['SheetRideDetailRides']['arrival_destination_id'],
                            $sheetRide['SheetRide']['car_type_id'], 2, $sheetRideDetailRide['SheetRideDetailRides']['tonnage_id']
                        );
                    }
                    if (!empty($price)) {
                        if ($sheetRideDetailRide['SheetRideDetailRides']['return_mission'] == 1) {
                            $unitPrice = $price[0];
                        } else {
                            $unitPrice = $price[2];
                        }
                    } else {
                        $unitPrice = 0;
                    }
                }
            }
        }else {
            if (!empty($sheetRideDetailRide['TransportBillDetailRides']['unit_price']) && ($sheetRideDetailRide['TransportBillDetailRides']['unit_price'] != 0)) {
                $unitPrice = $sheetRideDetailRide['TransportBillDetailRides']['unit_price'];
            } else {
                $typePricing = $sheetRideDetailRide['SheetRideDetailRides']['type_pricing'];

                if ($typePricing == 1) {
                    $price = $this->getPriceRide($sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'],
                        0,
                        $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'],
                        $sheetRideDetailRide['SheetRideDetailRides']['return_mission'],
                        $sheetRideDetailRide['SheetRideDetailRides']['type_price'],
                        $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'],
                        null, null, null, 1);
                } else {
                    $price = $this->getPriceRide($sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'],
                        0,
                        $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'],
                        $sheetRideDetailRide['SheetRideDetailRides']['return_mission'],
                        $sheetRideDetailRide['SheetRideDetailRides']['type_price'],
                        $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'],
                        null, null, null, 2, $sheetRideDetailRide['SheetRideDetailRides']['tonnage_id']
                    );
                }
                if (!empty($price)) {
                    if ($sheetRideDetailRide['SheetRideDetailRides']['return_mission'] == 1) {

                        $unitPrice = $price[0];
                    } else {

                        $unitPrice = $price[2];
                    }

                } else {
                    $unitPrice = 0;
                }
            }
        }

        return $unitPrice;
    }
    public function constructTransportBillDetailRide($sheetRideDetailRide=null,
                                                     $unitPriceSheetRideDetailRide=null,$tvaId=null,
                                                        $orderType = null, $type=null){
        if ($sheetRideDetailRide['SheetRideDetailRides']['type_ride'] == 2) {
            $sheetRide = $this->SheetRide->getSheetRideBySheetRideDetailRideId($sheetRideDetailRide['SheetRideDetailRides']['id']);
            $data1['departure_destination_id'] = $sheetRideDetailRide['SheetRideDetailRides']['departure_destination_id'];
            $data1['arrival_destination_id'] = $sheetRideDetailRide['SheetRideDetailRides']['arrival_destination_id'];
            $data1['car_type_id'] = $sheetRide['SheetRide']['car_type_id'];
            $data1['designation'] = $sheetRideDetailRide['Departure']['name'] . '-' . $sheetRideDetailRide['Arrival']['name'] . '-' . $sheetRideDetailRide['CarType']['name'];

        } else {
            $data1['detail_ride_id'] = $sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'];
            $data1['designation'] = $sheetRideDetailRide['DepartureDestination']['name'] . '-' . $sheetRideDetailRide['ArrivalDestination']['name'] . '-' . $sheetRideDetailRide['CarType']['name'];

        }
        $data1['from_customer_order'] = $sheetRideDetailRide['SheetRideDetailRides']['from_customer_order'];
        $data1['type_ride'] = $sheetRideDetailRide['SheetRideDetailRides']['type_ride'];
        $data1['unit_price'] = $unitPriceSheetRideDetailRide;
        $data1['nb_trucks'] = 1;
        $data1['type_pricing'] = $sheetRideDetailRide['SheetRideDetailRides']['type_pricing'];
        $data1['tonnage_id'] = $sheetRideDetailRide['SheetRideDetailRides']['tonnage_id'];
        $data1['programming_date'] = date("d/m/Y", strtotime($sheetRideDetailRide['TransportBillDetailRides']['programming_date']) );
        $data1['charging_time'] = $sheetRideDetailRide['TransportBillDetailRides']['charging_time'];
        $data1['unloading_date'] = date("d/m/Y H:i", strtotime($sheetRideDetailRide['TransportBillDetailRides']['unloading_date']) );
        $data1['product_id'] = 1;
        $data1['supplier_final_id'] = $sheetRideDetailRide['SheetRideDetailRides']['supplier_final_id'];
        $data1['supplier_id'] = $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'];
        $data1['ride_category_id'] = $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'];
        $data1['delivery_with_return'] = $sheetRideDetailRide['SheetRideDetailRides']['return_mission'];
        $data1['ristourne_%'] = $sheetRideDetailRide['TransportBillDetailRides']['ristourne_%'];
        $data1['designation'] = $sheetRideDetailRide['TransportBillDetailRides']['designation'];
        if (!empty($sheetRideDetailRide['TransportBillDetailRides']['ristourne_%'])) {
            $data1['ristourne_val'] = ($sheetRideDetailRide['TransportBillDetailRides']['unit_price'] * $sheetRideDetailRide['TransportBillDetailRides']['ristourne_%']) / 100;
            $data1['price_ht'] = $sheetRideDetailRide['TransportBillDetailRides']['unit_price'] - $data1['ristourne_val'];
        } else {
            $data1['ristourne_val'] = null;
            $data1['price_ht'] = $data1['unit_price'];
        }

        if (!empty($sheetRideDetailRide['TransportBillDetailRides']['tva_id'])) {
            if (isset($tvaId) && !empty($tvaId)) {
                $data1['tva_id'] = $tvaId;
            } else {
                $data1['tva_id'] = $sheetRideDetailRide['TransportBillDetailRides']['tva_id'];
            }
            $data1['price_ttc'] = $data1['price_ht'] + ($data1['price_ht'] * $this->Tva->getTvaValueById($data1['tva_id']));
        } else {
            if (isset($tvaId) && !empty($tvaId)) {
                $data1['tva_id'] = $tvaId;
            } else {
                $data1['tva_id'] = 1;
            }
            $data1['price_ttc'] = $data1['price_ht'] + ($data1['price_ht'] * $this->Tva->getTvaValueById($data1['tva_id']));
        }
        $data1['sheet_ride_detail_ride_id'] = $sheetRideDetailRide['SheetRideDetailRides']['id'];
        if (TransportBillTypesEnum::pre_invoice) {
            if($orderType ==2){
                $data1['approved'] = 1;
            }else {
                $data1['approved'] = $type;
            }
        }

        return $data1;
    }

    public function organiseTransportBillDetailRides($rides=null, $affectationClient){
        $transportBillDetailRidesOrganized = array();
        $transportBillDetailRidesOrganizedFinal = array();
        foreach ($rides as $ride ){
            $rideIndex = $ride['departure_destination_id'].$ride['arrival_destination_id'].
                $ride['programming_date'].$ride['unloading_date'].$ride['unit_price'];
            if(isset($transportBillDetailRidesOrganized[$rideIndex])){
                $transportBillDetailRidesOrganized[$rideIndex]['nb_trucks'] =
                    intval($transportBillDetailRidesOrganized[$rideIndex]['nb_trucks']) +1;
                $transportBillDetailRidesOrganized[$rideIndex]['price_ttc'] =
                    floatval($transportBillDetailRidesOrganized[$rideIndex]['price_ttc']) +
                    floatval($ride['price_ttc']);
                $transportBillDetailRidesOrganized[$rideIndex]['price_ht'] =
                    floatval($transportBillDetailRidesOrganized[$rideIndex]['price_ht']) +
                    floatval($ride['price_ht']);
            }else{
                $transportBillDetailRidesOrganized[$rideIndex] = $ride;
            }
        }
        foreach ($transportBillDetailRidesOrganized as $ride){
            array_push($transportBillDetailRidesOrganizedFinal,$ride);
        }

        return $transportBillDetailRidesOrganizedFinal;
    }

    public function printTransportBillsJournalPerClient()
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        ini_set('memory_limit', '1024M');
        $array = filter_input(INPUT_POST, "printJournalPerClient");

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
            $date_from = str_replace("/", "-", $startDate);
            $start = str_replace("-", "/", $date_from);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $conditions["TransportBill.date >="] = $startdtm->format('Y-m-d H:i:s');
        }
        if (!empty($endDate)) {
            $date_to = str_replace("/", "-", $endDate);
            $end = str_replace("-", "/", $date_to);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $conditions["TransportBill.date <="] = $enddtm->format('Y-m-d H:i:s');
        }
        $ids = filter_input(INPUT_POST, "chkids");
        if (!empty($ids)) {
            $arrayIds = explode(",", $ids);
            if (!empty($arrayIds)) {
                $conditions["TransportBill.id"] = $arrayIds;
            }
        }

        $transportBills = $this->TransportBill->find('all', array(
            'recursive' => -1,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'group' => 'Supplier.id,TransportBill.id',
            'order' => 'Supplier.id ASC,TransportBill.date ASC',
            'fields' => array(
                'TransportBill.reference',
                'TransportBill.id',
                'TransportBill.date',
                'TransportBill.total_ttc',
                'TransportBill.total_ht',
                'TransportBill.total_tva',
                'TransportBill.amount_remaining',
                'TransportBill.stamp',
                'TransportBill.order_type',
                'TransportBill.total_ht',
                'TransportBill.total_ttc',
                'Arrival.name',
                'Departure.name',
                'Supplier.id',
                'Supplier.name',
                'Supplier.code',
                'Type.name'
            ),
            'joins' => array(

                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('TransportBill.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'transport_bill_detail_rides',
                    'type' => 'left',
                    'alias' => 'TransportBillDetailRides',
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
            )
        ));
        foreach ($transportBills as $key => $value){
            if (is_null($value['TransportBill']['amount_remaining'])){
                $transportBills[$key]['TransportBill']['amount_remaining'] = $value['TransportBill']['total_ttc'];
            }
            if (is_null($value['TransportBill']['stamp'])){
                $transportBills[$key]['TransportBill']['stamp'] = '0';
            }
        }
        $company = $this->Company->find('first');
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('transportBills', 'company', 'separatorAmount'));
    }


    public function getThirdPartyNumberAjax()
    {
        $data = $this->request->data;
        $supplier = $this->Supplier->find('first',array(
                'conditions' => array(
                        'Supplier.id' => $data['supplierId']
                )
        ));
        echo json_encode($supplier);
        exit;
    }

}

