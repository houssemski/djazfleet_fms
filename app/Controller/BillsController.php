<?php

App::uses('AppController', 'Controller');

/**
 * Bills Controller
 *
 * @property Bill $Bill
 * @property Company $Company
 * @property Supplier $Supplier
 * @property SheetRide $SheetRide
 * @property TransportBillCategory $TransportBillCategory
 * @property BillProduct $BillProduct
 * @property BillService $BillService
 * @property Product $Product
 * @property ProductWarehouse $ProductWarehouse
 * @property ProductPrice $ProductPrice
 * @property PriceCategory $PriceCategory
 * @property Lot $Lot
 * @property Payment $Payment
 * @property DetailPayment $DetailPayment
 * @property ProductFamily $ProductFamily
 * @property Transformation $Transformation
 * @property Tva $Tva
 * @property Warehouse $Warehouse
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class BillsController extends AppController
{
    var $helpers = array('Xls', 'Js', 'Tinymce');
    public $components = array('Paginator', 'Session', 'RequestHandler',
        'Security','SerialNumberManagement','BillManagement');
    public $uses = array('Bill', 'Company', 'Supplier', 'BillProduct','BillService', 'Tva','DetailPayment','Payment',
        'TransportBillCategory', 'Product', 'Lot', 'PriceCategory', 'ProductPrice', 'Transformation',
        'Service','Customer','Destination','Warehouse','ProductWarehouse');

	
	/***
     * @param null $type
     * @return void
     */
    public function index($type = null)
    {

        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        $userId = $this->Auth->user('id');
        $this->Security->blackHoleCallback = 'blackhole';
        $profileId = intval($this->Auth->user('profile_id'));
        $roleId = intval($this->Auth->user('role_id'));
        switch ($type) {
            case BillTypesEnum::supplier_order :
                $result = $this->verifyUserPermission(SectionsEnum::commande_fournisseur, $userId, ActionsEnum::view, "Bills", null, "Bill", $type);
                $permissionPrint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::commande_fournisseur,
                    ActionsEnum::printing, $profileId, $roleId);

                break;
            case BillTypesEnum::receipt :
                $result = $this->verifyUserPermission(SectionsEnum::bon_reception, $userId, ActionsEnum::view, "Bills", null, "Bill", $type);
                $permissionPrint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::bon_reception,
                    ActionsEnum::printing, $profileId, $roleId);
                break;

            case BillTypesEnum::return_supplier :
                $result = $this->verifyUserPermission(SectionsEnum::retour_fournisseur, $userId, ActionsEnum::view, "Bills", null, "Bill", $type);
                $permissionPrint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::retour_fournisseur,
                    ActionsEnum::printing, $profileId, $roleId);

                break;
            case BillTypesEnum::purchase_invoice :
                $result = $this->verifyUserPermission(SectionsEnum::facture_achat, $userId, ActionsEnum::view, "Bills", null, "Bill", $type);
                $permissionPrint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::facture_achat,
                    ActionsEnum::printing, $profileId, $roleId);
                break;

            case BillTypesEnum::credit_note :
                $result = $this->verifyUserPermission(SectionsEnum::avoir, $userId, ActionsEnum::view, "Bills", null, "Bill", $type);
                $permissionPrint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::avoir,
                    ActionsEnum::printing, $profileId, $roleId);
                break;

            case BillTypesEnum::delivery_order :
                $result = $this->verifyUserPermission(SectionsEnum::bon_livraison, $userId, ActionsEnum::view, "Bills", null, "Bill", $type);
                $permissionPrint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::bon_livraison,
                    ActionsEnum::printing, $profileId, $roleId);
                break;

            case BillTypesEnum::return_customer :
                $result = $this->verifyUserPermission(SectionsEnum::retour_client, $userId, ActionsEnum::view, "Bills", null, "Bill", $type);
                $permissionPrint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::retour_client,
                    ActionsEnum::printing, $profileId, $roleId);
                break;

            case BillTypesEnum::entry_order :
                $result = $this->verifyUserPermission(SectionsEnum::bon_entree, $userId, ActionsEnum::view, "Bills", null, "Bill", $type);
                $permissionPrint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::bon_entree,
                    ActionsEnum::printing, $profileId, $roleId);
                break;

            case BillTypesEnum::exit_order :
                $result = $this->verifyUserPermission(SectionsEnum::bon_sortie, $userId, ActionsEnum::view, "Bills", null, "Bill", $type);
                $permissionPrint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::bon_sortie,
                    ActionsEnum::printing, $profileId, $roleId);
                break;

            case BillTypesEnum::renvoi_order :
                $result = $this->verifyUserPermission(SectionsEnum::bon_renvoi, $userId, ActionsEnum::view, "Bills", null, "Bill", $type);
                $permissionPrint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::bon_renvoi,
                    ActionsEnum::printing, $profileId, $roleId);
                break;

            case BillTypesEnum::reintegration_order :
                $result = $this->verifyUserPermission(SectionsEnum::bon_reintegration, $userId, ActionsEnum::view, "Bills", null, "Bill", $type);
                $permissionPrint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::bon_reintegration,
                    ActionsEnum::printing, $profileId, $roleId);
                break;

            case BillTypesEnum::commercial_bills_list :
                $resultReceipt = $this->verifyUserPermission(SectionsEnum::bon_reception, $userId, ActionsEnum::view, "Bills", null, "Bill", $type,1);
                $resultDelivery = $this->verifyUserPermission(SectionsEnum::bon_livraison, $userId, ActionsEnum::view, "Bills", null, "Bill", $type,1);
                $type = array(BillTypesEnum::receipt, BillTypesEnum::delivery_order);
                break;

            case BillTypesEnum::special_bills_list :
                $resultEntry = $this->verifyUserPermission(SectionsEnum::bon_entree, $userId, ActionsEnum::view, "Bills", null, "Bill", $type,1);
                $resultExit = $this->verifyUserPermission(SectionsEnum::bon_sortie, $userId, ActionsEnum::view, "Bills", null, "Bill", $type,1);
                $type = array(BillTypesEnum::entry_order, BillTypesEnum::exit_order);
                break;

            case BillTypesEnum::purchase_invoices_list :
                $resultInvoice = $this->verifyUserPermission(SectionsEnum::facture_achat, $userId, ActionsEnum::view, "Bills", null, "Bill", $type,1);
                $resultCredit = $this->verifyUserPermission(SectionsEnum::avoir, $userId, ActionsEnum::view, "Bills", null, "Bill", $type,1);
                $type = array(BillTypesEnum::purchase_invoice, BillTypesEnum::credit_note);
                break;
				
			case BillTypesEnum::quote :
                $result = $this->verifyUserPermission(SectionsEnum::devis, $userId, ActionsEnum::view, "Bills", null, "Bill", $type);
                $permissionPrint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::devis,
                    ActionsEnum::printing, $profileId, $roleId);
                break;
				
			case BillTypesEnum::customer_order :
                $result = $this->verifyUserPermission(SectionsEnum::commande_client, $userId, ActionsEnum::view, "Bills", null, "Bill", $type);
                $permissionPrint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::commande_client,
                    ActionsEnum::printing, $profileId, $roleId);
                break;
				
			case BillTypesEnum::sales_invoice :
                $result = $this->verifyUserPermission(SectionsEnum::facture, $userId, ActionsEnum::view, "Bills", null, "Bill", $type);
                $permissionPrint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::facture,
                    ActionsEnum::printing, $profileId, $roleId);
                break;
				
			case BillTypesEnum::sale_credit_note :
                $result = $this->verifyUserPermission(SectionsEnum::avoir_vente, $userId, ActionsEnum::view, "Bills", null, "Bill", $type);
                $permissionPrint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::avoir_vente,
                    ActionsEnum::printing, $profileId, $roleId);
                break;
				
			case BillTypesEnum::sale_invoices_list :
                $resultInvoice = $this->verifyUserPermission(SectionsEnum::facture, $userId, ActionsEnum::view, "Bills", null, "Bill", $type,1);
                $resultCredit = $this->verifyUserPermission(SectionsEnum::avoir_vente, $userId, ActionsEnum::view, "Bills", null, "Bill", $type,1);
                $type = array(BillTypesEnum::sales_invoice, BillTypesEnum::sale_credit_note);
                break;

            case BillTypesEnum::product_request :
                $result = $this->verifyUserPermission(SectionsEnum::demande_produit, $userId, ActionsEnum::view, "Bills", null, "Bill", $type);
                $permissionPrint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::demande_produit,
                    ActionsEnum::printing, $profileId, $roleId);
                break;

             case BillTypesEnum::purchase_request :
                $result = $this->verifyUserPermission(SectionsEnum::demande_achat, $userId, ActionsEnum::view, "Bills", null, "Bill", $type);
                 $permissionPrint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::demande_achat,
                     ActionsEnum::printing, $profileId, $roleId);
                break;
                case BillTypesEnum::transfer_receipt :
                $result = $this->verifyUserPermission(SectionsEnum::bon_transfert, $userId, ActionsEnum::view, "Bills", null, "Bill", $type);
                 $permissionPrint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::bon_transfert,
                     ActionsEnum::printing, $profileId, $roleId);
                break;

            default :
                $result = $this->verifyUserPermission(SectionsEnum::bon_sortie, $userId, ActionsEnum::view, "Bills", null, "Bill", $type);
                $type = array(BillTypesEnum::receipt, BillTypesEnum::delivery_order);
                $this->redirect(array('controller'=>'bills','action' => 'index',19));
                break;
				
			
        }

		$limit = isset($this->params['pass']['1']) ? $this->getLimit($this->params['pass']['1']) : $this->getLimit();
		$order = isset($this->params['pass']['2']) ? $this->getOrder($this->params['pass']['2'],$this->params['pass']['3']) : $this->getOrder();

        $this->set('order',$order);
        $conditions = array();

        if ($type == array(BillTypesEnum::receipt, BillTypesEnum::delivery_order)) {
            if(isset($resultReceipt) && $resultReceipt ==0 && isset($resultDelivery) && $resultDelivery == 0 ){
                $this->Flash->error(__("You don't have permission to consult."));
                 $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
            }else {
                if(isset($resultReceipt) && $resultReceipt ==0){
                    if(isset($resultDelivery)) {
                        switch ($resultDelivery) {
                            case 1 :
                                $conditions = array('Bill.type ' => BillTypesEnum::delivery_order);

                                break;
                            case 2 :
                                $conditions = array('Bill.user_id ' => $userId, 'Bill.type ' => BillTypesEnum::delivery_order);

                                break;
                            case 3 :
                                $conditions = array('Bill.user_id !=' => $userId, 'Bill.type ' => BillTypesEnum::delivery_order);

                                break;
                            default:
                                $conditions = array('Bill.type ' => BillTypesEnum::delivery_order);
                        }
                    }


                }elseif(isset($resultDelivery) && $resultDelivery == 0){

                    if(isset($resultReceipt)){
                        switch ($resultReceipt) {
                            case 1 :
                                $conditions = array('Bill.type ' => BillTypesEnum::receipt);

                                break;
                            case 2 :
                                $conditions = array('Bill.user_id ' => $userId, 'Bill.type ' => BillTypesEnum::receipt);

                                break;
                            case 3 :
                                $conditions = array('Bill.user_id !=' => $userId, 'Bill.type ' => BillTypesEnum::receipt);

                                break;
                            default:
                                $conditions = array('Bill.type ' => BillTypesEnum::receipt);
                        }
                    }

                }else {
                    if(isset($resultReceipt)){
                        switch ($resultReceipt) {
                            case 1 :
                                $conditions = array('Bill.type ' => $type);

                                break;
                            case 2 :
                                $conditions = array('Bill.user_id ' => $userId, 'Bill.type ' => $type);

                                break;
                            case 3 :
                                $conditions = array('Bill.user_id !=' => $userId, 'Bill.type ' => $type);

                                break;
                            default:
                                $conditions = array('Bill.type ' => $type);
                        }
                    }

                }

            }
            $type = BillTypesEnum::commercial_bills_list;
        }
        elseif ($type == array(BillTypesEnum::entry_order, BillTypesEnum::exit_order)) {

            if(isset($resultEntry) && $resultEntry ==0 && isset($resultExit) && $resultExit == 0 ){
                $this->Flash->error(__("You don't have permission to consult."));
                 $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
            }else {
                if( isset($resultEntry) && $resultEntry ==0){
                    if(isset($resultExit)) {
                        switch ($resultExit) {
                            case 1 :
                                $conditions = array('Bill.type ' => BillTypesEnum::exit_order);

                                break;
                            case 2 :
                                $conditions = array('Bill.user_id ' => $userId, 'Bill.type ' => BillTypesEnum::exit_order);

                                break;
                            case 3 :
                                $conditions = array('Bill.user_id !=' => $userId, 'Bill.type ' => BillTypesEnum::exit_order);

                                break;
                            default:
                                $conditions = array('Bill.type ' => BillTypesEnum::exit_order);
                        }
                    }

                }elseif(isset($resultExit) && $resultExit == 0){
                    if(isset($resultEntry)) {
                        switch ($resultEntry) {
                            case 1 :
                                $conditions = array('Bill.type ' => BillTypesEnum::entry_order);

                                break;
                            case 2 :
                                $conditions = array('Bill.user_id ' => $userId, 'Bill.type ' => BillTypesEnum::entry_order);

                                break;
                            case 3 :
                                $conditions = array('Bill.user_id !=' => $userId, 'Bill.type ' => BillTypesEnum::entry_order);

                                break;
                            default:
                                $conditions = array('Bill.type ' => BillTypesEnum::entry_order);
                        }
                    }

                }else {
                    if(isset($resultEntry)){
                        switch ($resultEntry) {
                            case 1 :
                                $conditions = array('Bill.type ' => $type);

                                break;
                            case 2 :
                                $conditions = array('Bill.user_id ' => $userId, 'Bill.type ' => $type);

                                break;
                            case 3 :
                                $conditions = array('Bill.user_id !=' => $userId, 'Bill.type ' => $type);

                                break;
                            default:
                                $conditions = array('Bill.type ' => $type);
                        }
                    }

                }

            }

            $type = BillTypesEnum::special_bills_list;
        }
        elseif($type == array(BillTypesEnum::purchase_invoice, BillTypesEnum::credit_note)){

            if(isset($resultInvoice) && $resultInvoice ==0 && isset($resultCredit) && $resultCredit == 0 ){
                $this->Flash->error(__("You don't have permission to consult."));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
            }else {
                if(isset($resultInvoice) && $resultInvoice ==0){
                    if(isset($resultCredit)) {
                        switch ($resultCredit) {
                            case 1 :
                                $conditions = array('Bill.type ' => BillTypesEnum::credit_note);

                                break;
                            case 2 :
                                $conditions = array('Bill.user_id ' => $userId, 'Bill.type ' => BillTypesEnum::credit_note);

                                break;
                            case 3 :
                                $conditions = array('Bill.user_id !=' => $userId, 'Bill.type ' => BillTypesEnum::credit_note);

                                break;
                            default:
                                $conditions = array('Bill.type ' => BillTypesEnum::credit_note);
                        }
                    }
                } elseif(isset($resultCredit) && $resultCredit == 0){
                    if(isset($resultInvoice)) {
                        switch ($resultInvoice) {
                            case 1 :
                                $conditions = array('Bill.type ' => BillTypesEnum::purchase_invoice);

                                break;
                            case 2 :
                                $conditions = array('Bill.user_id ' => $userId, 'Bill.type ' => BillTypesEnum::purchase_invoice);

                                break;
                            case 3 :
                                $conditions = array('Bill.user_id !=' => $userId, 'Bill.type ' => BillTypesEnum::purchase_invoice);

                                break;
                            default:
                                $conditions = array('Bill.type ' => BillTypesEnum::purchase_invoice);
                        }
                    }
                } else {
                    if(isset($resultInvoice)) {
                        switch ($resultInvoice) {
                            case 1 :
                                $conditions = array('Bill.type ' => $type);

                                break;
                            case 2 :
                                $conditions = array('Bill.user_id ' => $userId, 'Bill.type ' => $type);

                                break;
                            case 3 :
                                $conditions = array('Bill.user_id !=' => $userId, 'Bill.type ' => $type);

                                break;
                            default:
                                $conditions = array('Bill.type ' => $type);
                        }
                    }
                }
            }
            $type = BillTypesEnum::purchase_invoices_list;
        }
        elseif($type == array(BillTypesEnum::sales_invoice, BillTypesEnum::sale_credit_note)) {
            if(isset($resultInvoice) && $resultInvoice ==0 && isset($resultCredit) && $resultCredit == 0 ){
                $this->Flash->error(__("You don't have permission to consult."));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
            }else {
                if(isset($resultInvoice) && $resultInvoice ==0){
                    if(isset($resultCredit)) {
                        switch ($resultCredit) {
                            case 1 :
                                $conditions = array('Bill.type ' => BillTypesEnum::sale_credit_note);

                                break;
                            case 2 :
                                $conditions = array('Bill.user_id ' => $userId, 'Bill.type ' => BillTypesEnum::sale_credit_note);

                                break;
                            case 3 :
                                $conditions = array('Bill.user_id !=' => $userId, 'Bill.type ' => BillTypesEnum::sale_credit_note);

                                break;
                            default:
                                $conditions = array('Bill.type ' => BillTypesEnum::sale_credit_note);
                        }
                    }
                }elseif(isset($resultCredit) && $resultCredit == 0){
                    if(isset($resultInvoice)) {
                        switch ($resultInvoice) {
                            case 1 :
                                $conditions = array('Bill.type ' => BillTypesEnum::invoice);

                                break;
                            case 2 :
                                $conditions = array('Bill.user_id ' => $userId, 'Bill.type ' => BillTypesEnum::invoice);

                                break;
                            case 3 :
                                $conditions = array('Bill.user_id !=' => $userId, 'Bill.type ' => BillTypesEnum::invoice);

                                break;
                            default:
                                $conditions = array('Bill.type ' => BillTypesEnum::invoice);
                        }
                    }
                }else {
                    if(isset($resultInvoice)) {
                        switch ($resultInvoice) {
                            case 1 :
                                $conditions = array('Bill.type ' => $type);

                                break;
                            case 2 :
                                $conditions = array('Bill.user_id ' => $userId, 'Bill.type ' => $type);

                                break;
                            case 3 :
                                $conditions = array('Bill.user_id !=' => $userId, 'Bill.type ' => $type);

                                break;
                            default:
                                $conditions = array('Bill.type ' => $type);
                        }
                    }
                }
            }
            $type = BillTypesEnum::sale_invoices_list;
        }
		else {
            if (isset($result)) {
                switch ($result) {
                    case 1 :
                        $conditions = array('Bill.type ' => $type);

                        break;
                    case 2 :
                        $conditions = array('Bill.user_id ' => $userId, 'Bill.type ' => $type);

                        break;
                    case 3 :
                        $conditions = array('Bill.user_id !=' => $userId, 'Bill.type ' => $type);

                        break;
                    default:
                        $conditions = array('Bill.type ' => $type);
                }
            }
        }


        if( $type == BillTypesEnum::purchase_request||
            $type == BillTypesEnum::product_request){
            $profileId = $this->Auth->user('profile_id');
            $roleId = $this->Auth->user('role_id');

            $permissionValidationPurchaseRequest = $this->AccessPermission->getPermissionWithParams(SectionsEnum::valider_demande_achat,
                ActionsEnum::view, $profileId, $roleId);
            $this->set('permissionValidationPurchaseRequest', $permissionValidationPurchaseRequest);

            $permissionValidationProductRequest = $this->AccessPermission->getPermissionWithParams(SectionsEnum::valider_demande_produit,
                ActionsEnum::view, $profileId, $roleId);
            $this->set('permissionValidationProductRequest', $permissionValidationProductRequest);

            $permissionTransformationPurchaseRequest = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transformer_demande_achat,
                ActionsEnum::view, $profileId, $roleId);
            $this->set('permissionTransformationPurchaseRequest', $permissionTransformationPurchaseRequest);

            $permissionTransformationProductRequest = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transformer_demande_produit,
                ActionsEnum::view, $profileId, $roleId);
            $this->set('permissionTransformationProductRequest', $permissionTransformationProductRequest);

            $this->paginate = array(
                'limit' => $limit,
                'order' => $order,
                'conditions' => $conditions,
                'paramType' => 'querystring',
                'recursive' => -1,
                'fields' => array( 'Bill.amount_remaining',
                     'Bill.id', 'Bill.type', 'Bill.status',  'Bill.reference',
                    'Bill.date', 'Bill.total_ht', 'Bill.total_ttc', 'Bill.total_tva',
                    'Bill.stamp','Bill.ristourne_val','Service.name',
                    'Customer.first_name','Customer.last_name'),
                'joins' => array(
                    array(
                        'table' => 'services',
                        'type' => 'left',
                        'alias' => 'Service',
                        'conditions' => array('BillService.service_id = Service.id')
                    ),
                    array(
                        'table' => 'bills',
                        'type' => 'left',
                        'alias' => 'Bill',
                        'conditions' => array('BillService.bill_id = Bill.id')
                    ),
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('Bill.customer_id = Customer.id')
                    ),



                )
            );
            $bills = $this->Paginator->paginate('BillService');
        }else {
            if($type == BillTypesEnum::supplier_order){
                $permissionTransformationSupplierOrder = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transformer_commande_fournisseur,
                    ActionsEnum::view, $profileId, $roleId);
                $this->set('permissionTransformationSupplierOrder', $permissionTransformationSupplierOrder);

            }
            $this->paginate = array(
                'limit' => $limit,
                'order' => $order,
                'conditions' => $conditions,
                'paramType' => 'querystring',
                'recursive' => -1,
                'fields' => array('Supplier.name', 'Car.code', 'Car.immatr_def', 'Carmodel.name',
                    'Bill.supplier_id', 'Bill.amount_remaining',
                    'Bill.event_id', 'Bill.id', 'Bill.type', 'EventType.name', 'Bill.reference',
                    'Bill.date', 'Bill.total_ht', 'Bill.total_ttc', 'Bill.total_tva',
                    'Bill.stamp','Bill.ristourne_val'),
                'joins' => array(
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('Bill.supplier_id = Supplier.id')
                    ),
                    array(
                        'table' => 'event',
                        'type' => 'left',
                        'alias' => 'Event',
                        'conditions' => array('Bill.event_id = Event.id')
                    ),
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('Event.car_id = Car.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),
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
                    )
                )
            );
            $bills = $this->Paginator->paginate();
        }




        // Get the structure of the car name from parameters
        $carNameStructure = $this->Parameter->getCodesParameterVal('name_car');
        $this->set('bills', $bills);
        $separatorAmount = $this->getSeparatorAmount();
        $users = $this->User->find('list', array('conditions' => 'User.id != 1'));
        $isSuperAdmin = $this->isSuperAdmin();
        $suppliers = $this->Supplier->getSuppliersByParams(0, 1);
        $clients = $this->Supplier->getSuppliersByParams(1, 1, null, 2);
        $transportBillCategories = $this->TransportBillCategory->getTransportBillCategories();
        $hasTreasuryModule = $this->hasModuleTresorerie();
		$totalArray = $this->Bill->getBillTotals($conditions, $type);
        $products = $this->Product->getProducts();
        $this->set(compact('limit', 'order','type', 'carNameStructure', 'separatorAmount', 'users', 'customers',
            'suppliers', 'clients', 'isSuperAdmin', 'transportBillCategories','hasTreasuryModule','totalArray','products'));
    }

    /**
     * @return void
     */
    public function search()
    {
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        if (isset($this->request->data['keyword']) || isset($this->request->data['type']) || isset($this->request->data['Bills']['user_id']) ||
            isset($this->request->data['Bills']['modified_id']) || isset($this->request->data['Bills']['profile_id'])
            || isset($this->request->data['Bills']['created']) || isset($this->request->data['Bills']['created1'])
            || isset($this->request->data['Bills']['modified']) || isset($this->request->data['Bills']['modified1'])
            || isset($this->request->data['Bills']['date1']) || isset($this->request->data['Bills']['date2'])
            || isset($this->request->data['Bills']['supplier_id']) || isset($this->request->data['Bills']['client_id'])
            || isset($this->request->data['Bills']['customer_id']) || isset($this->request->data['Bills']['product_id'])
            || isset($this->request->data['Bills']['transport_bill_category_id']) || isset($this->request->data['Bills']['type'])
            || isset($this->request->data['Bills']['reglement_id'])
        ) {
            $this->filterUrl();
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();
        $this->paginate = array(
            'limit' => $limit,
            'order' => $order,
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword']) || isset($this->params['named']['type']) || isset($this->params['named']['user'])
            || isset($this->params['named']['profile']) || isset($this->params['named']['created'])
            || isset($this->params['named']['created1']) || isset($this->params['named']['ride'])
            || isset($this->params['named']['category']) || isset($this->params['named']['supplier'])
            || isset($this->params['named']['type']) || isset($this->params['named']['client'])|| isset($this->params['named']['product'])
            || isset($this->params['named']['modified']) || isset($this->params['named']['modified1'])
            || isset($this->params['named']['date1']) || isset($this->params['named']['date2'])|| isset($this->params['named']['reglement'])
        ) {
            $type = $this->params['named']['type'];
            $conditions = $this->getConds();
            $profileId = $this->Auth->user('profile_id');
            $roleId = $this->Auth->user('role_id');
            if( $type == BillTypesEnum::purchase_request||
                $type == BillTypesEnum::product_request){


                $permissionValidationPurchaseRequest = $this->AccessPermission->getPermissionWithParams(SectionsEnum::valider_demande_achat,
                    ActionsEnum::view, $profileId, $roleId);
                $this->set('permissionValidationPurchaseRequest', $permissionValidationPurchaseRequest);

                $permissionValidationProductRequest = $this->AccessPermission->getPermissionWithParams(SectionsEnum::valider_demande_produit,
                    ActionsEnum::view, $profileId, $roleId);
                $this->set('permissionValidationProductRequest', $permissionValidationProductRequest);

                $permissionTransformationPurchaseRequest = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transformer_demande_achat,
                    ActionsEnum::view, $profileId, $roleId);
                $this->set('permissionTransformationPurchaseRequest', $permissionTransformationPurchaseRequest);

                $permissionTransformationProductRequest = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transformer_demande_produit,
                    ActionsEnum::view, $profileId, $roleId);
                $this->set('permissionTransformationProductRequest', $permissionTransformationProductRequest);

                $this->paginate = array(
                    'limit' => $limit,
                    'order' => $order,
                    'conditions' => $conditions,
                    'paramType' => 'querystring',
                    'recursive' => -1,
                    'fields' => array( 'Bill.amount_remaining',
                        'Bill.id', 'Bill.type', 'Bill.status',  'Bill.reference',
                        'Bill.date', 'Bill.total_ht', 'Bill.total_ttc', 'Bill.total_tva',
                        'Bill.stamp','Bill.ristourne_val','Service.name','Customer.first_name','Customer.last_name'),
                    'joins' => array(
                        array(
                            'table' => 'services',
                            'type' => 'left',
                            'alias' => 'Service',
                            'conditions' => array('BillService.service_id = Service.id')
                        ),
                        array(
                            'table' => 'bills',
                            'type' => 'left',
                            'alias' => 'Bill',
                            'conditions' => array('BillService.bill_id = Bill.id')
                        ),
                        array(
                            'table' => 'customers',
                            'type' => 'left',
                            'alias' => 'Customer',
                            'conditions' => array('Bill.customer_id = Customer.id')
                        ),
                        array(
                            'table' => 'suppliers',
                            'type' => 'left',
                            'alias' => 'Supplier',
                            'conditions' => array('Bill.supplier_id = Supplier.id')
                        ),



                    )
                );
                $bills = $this->Paginator->paginate('BillService');
            }else {

                if($type == BillTypesEnum::supplier_order){
                    $permissionTransformationSupplierOrder = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transformer_commande_fournisseur,
                        ActionsEnum::view, $profileId, $roleId);
                    $this->set('permissionTransformationSupplierOrder', $permissionTransformationSupplierOrder);

                }
                $this->paginate = array(
                    'limit' => $limit,
                    'order' => $order,
                    'group' => 'Bill.id',
                    'recursive' => -1,
                    'conditions' => $conditions,
                    'paramType' => 'querystring',
                    'fields' => array('Supplier.name', 'Car.code', 'Car.immatr_def',
                        'Carmodel.name', 'Bill.supplier_id', 'Bill.event_id', 'Bill.amount_remaining',
                        'Bill.id', 'Bill.type', 'EventType.name', 'Bill.reference',
                        'Bill.date', 'Bill.total_ht', 'Bill.total_ttc', 'Bill.total_tva',
                        'Bill.stamp', 'Bill.ristourne_val'
                    ),
                    'joins' => array(
                        array(
                            'table' => 'suppliers',
                            'type' => 'left',
                            'alias' => 'Supplier',
                            'conditions' => array('Bill.supplier_id = Supplier.id')
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
                            'conditions' => array('BillProduct.lot_id = Lot.id')
                        ),
                        array(
                            'table' => 'event',
                            'type' => 'left',
                            'alias' => 'Event',
                            'conditions' => array('Bill.event_id = Event.id')
                        ),
                        array(
                            'table' => 'car',
                            'type' => 'left',
                            'alias' => 'Car',
                            'conditions' => array('Event.car_id = Car.id')
                        ),
                        array(
                            'table' => 'carmodels',
                            'type' => 'left',
                            'alias' => 'Carmodel',
                            'conditions' => array('Car.carmodel_id = Carmodel.id')
                        ),
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
                        )

                    )
                );

                $bills = $this->Paginator->paginate('Bill');
            }
            $totalArray = $this->Bill->getBillTotals($conditions, $type);

            $this->set(compact('bills', 'totalArray'));


        } else {
            $this->Bill->recursive = 0;
            $this->set('bills', $this->Paginator->paginate('Bill'));
        }
        $carNameStructure = $this->Parameter->getCodesParameterVal('name_car');
        $separatorAmount = $this->getSeparatorAmount();
        $users = $this->User->find('list', array('conditions' => 'User.id != 1'));
        $isSuperAdmin = $this->isSuperAdmin();
        $suppliers = $this->Supplier->getSuppliersByParams(0, 1);
        $clients = $this->Supplier->getSuppliersByParams(1, 1, null, 2);
        $transportBillCategories = $this->TransportBillCategory->getTransportBillCategories();
		$hasTreasuryModule = $this->hasModuleTresorerie();
        $products = $this->Product->getProducts();
        $this->set(compact('limit', 'order','type', 'separatorAmount', 'users', 'customers',
            'suppliers', 'clients', 'isSuperAdmin', 'transportBillCategories', 
			'carNameStructure', 'type','hasTreasuryModule','products'));
        $this->render();
    }

    private function filterUrl()
    {
        $filter_url['controller'] = $this->request->params['controller'];
        $filter_url['action'] = $this->request->params['action'];
        $filter_url['page'] = 1;
        $filter_url['keyword'] = $this->request->data['keyword'];
        $filter_url['keyword'] = str_replace('/', '-', $filter_url['keyword']);
        if (isset($this->request->data['Bills']['type']) && !empty($this->request->data['Bills']['type'])) {
            $filter_url['type'] = $this->request->data['Bills']['type'];
        }

        if (isset($this->request->data['Bills']['reglement_id']) && !empty($this->request->data['Bills']['reglement_id'])) {
            $filter_url['reglement'] = $this->request->data['Bills']['reglement_id'];
        }
        if (isset($this->request->data['Bills']['product_id']) && !empty($this->request->data['Bills']['product_id'])) {
            $filter_url['product'] = $this->request->data['Bills']['product_id'];
        }
        if (isset($this->request->data['Bills']['supplier_id']) && !empty($this->request->data['Bills']['supplier_id'])) {
            $filter_url['supplier'] = $this->request->data['Bills']['supplier_id'];
        }
        if (isset($this->request->data['Bills']['client_id']) && !empty($this->request->data['Bills']['client_id'])) {
            $filter_url['client'] = $this->request->data['Bills']['client_id'];
        }

        if (isset($this->request->data['Bills']['transport_bill_category_id']) && !empty($this->request->data['Bills']['transport_bill_category_id'])) {
            $filter_url['category'] = $this->request->data['Bills']['transport_bill_category_id'];
        }
        if (isset($this->request->data['Bills']['user_id']) && !empty($this->request->data['Bills']['user_id'])) {
            $filter_url['user'] = $this->request->data['Bills']['user_id'];
        }
        if (isset($this->request->data['Bills']['modified_id']) && !empty($this->request->data['Bills']['modified_id'])) {
            $filter_url['modified_id'] = $this->request->data['Bills']['modified_id'];
        }
        if (isset($this->request->data['Bills']['date1']) && !empty($this->request->data['Bills']['date1'])) {
            $filter_url['date1'] = str_replace("/", "-", $this->request->data['Bills']['date1']);
        }
        if (isset($this->request->data['Bills']['date2']) && !empty($this->request->data['Bills']['date2'])) {
            $filter_url['date2'] = str_replace("/", "-", $this->request->data['Bills']['date2']);
        }

        return $this->redirect($filter_url);
    }

    /**
     * @param null $params
     * @param null $orderType
     * @return array
     */

    public function getOrder($params = null, $orderType = null)
    {

        if($orderType == null){
            $orderType = 'DESC';
        }
        if (isset($params) && is_numeric($params)) {
            switch ($params) {
                case 1 :
                    $order = array('Bill.reference' => $orderType);
                    break;
                case 2 :
                    $order = array('Bill.id' => $orderType);
                    break;
                case 3 :
                    $order = array('Bill.date' => $orderType);
                    break;
                default :
                    $order = array('Bill.reference' => $orderType);
                    break;
            }

            return $order;
        } else {
            $order = array('Bill.reference' => $orderType);
            return $order;
        }

    }

    private function getConds()
    {
        if (!empty($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $keyword = str_replace('-', '/', $keyword);
            $conds = array(
                'OR' => array(
                    "LOWER(Bill.reference) LIKE" => "%$keyword%",
                    "LOWER(Supplier.name) LIKE" => "%$keyword%",
                )
            );
        } else {
            $conds = array();
        }

        if (isset($this->params['named']['type']) && !empty($this->params['named']['type'])) {
            switch ($this->params['named']['type']){
				case BillTypesEnum::commercial_bills_list :
                $conds["Bill.type = "]  = array(BillTypesEnum::receipt, BillTypesEnum::delivery_order,
							BillTypesEnum::return_supplier, BillTypesEnum::return_customer
				);
                break;

            case BillTypesEnum::special_bills_list :
               $conds["Bill.type = "] = array(BillTypesEnum::entry_order, BillTypesEnum::exit_order,
							BillTypesEnum::renvoi_order, BillTypesEnum::reintegration_order
				);
                break;

            case BillTypesEnum::purchase_invoices_list :
                $conds["Bill.type = "] = array(BillTypesEnum::purchase_invoice, BillTypesEnum::credit_note);
                break;    
				
			case BillTypesEnum::sale_invoices_list :
                $conds["Bill.type = "] = array(BillTypesEnum::sales_invoice, BillTypesEnum::sale_credit_note);
                break;
				
			default : 
				$conds["Bill.type = "] = $this->params['named']['type'];
			
			}
			
            $this->request->data['Bills']['type'] = $this->params['named']['type'];
        }


        if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
            if($this->params['named']['category'] == 2) {

                $transportBillCategories = $this->TransportBillCategory->getTransportBillCategories('all');
                $categories = array('NULL');

                foreach ($transportBillCategories as $transportBillCategory) {
                    $categories[] = $transportBillCategory['TransportBillCategory']['id'];
                }

                $conds["Bill.transport_bill_category_id is NULL || Bill.transport_bill_category_id = "] =$categories;
            }else {
                if($this->params['named']['category'] == 3){
                    $conds["Bill.transport_bill_category_id = "] = NULL;
                }else {
                    $conds["Bill.transport_bill_category_id = "] = $this->params['named']['category'];
                }

            }

            $this->request->data['Bills']['transport_bill_category_id'] = $this->params['named']['category'];
        }

        if (isset($this->params['named']['product']) && !empty($this->params['named']['product'])) {
            $conds["Lot.product_id = "] = $this->params['named']['product'];
            $this->request->data['Bills']['product_id'] = $this->params['named']['product'];
        }

        if (isset($this->params['named']['reglement']) && !empty($this->params['named']['reglement'])) {
            switch($this->params['named']['reglement']){
                case 1 :
                    $conds["Bill.total_ttc = Bill.amount_remaining &&  Bill.total_ttc > "] =0;
                    break;
                case 2 :
                    $conds["Bill.total_ttc > Bill.amount_remaining && Bill.amount_remaining > "] = 0;
                    break;

                case 3 :
                    $conds["Bill.amount_remaining "] =0;
                    break;
            }


            $this->request->data['Bills']['reglement_id'] = $this->params['named']['reglement'];
        }

        if (isset($this->params['named']['supplier']) && !empty($this->params['named']['supplier'])) {
            $conds["Bill.supplier_id = "] = $this->params['named']['supplier'];
            $this->request->data['Bills']['supplier_id'] = $this->params['named']['supplier'];
        }


        if (isset($this->params['named']['client']) && !empty($this->params['named']['client'])) {
            $conds["Bill.supplier_id = "] = $this->params['named']['client'];
            $this->request->data['Bills']['client_id'] = $this->params['named']['client'];
        }


        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $conds["Bill.user_id = "] = $this->params['named']['user'];
            $this->request->data['Bills']['user_id'] = $this->params['named']['user'];
        }

        if (isset($this->params['named']['profile']) && !empty($this->params['named']['profile'])) {
            $conds["User.profile_id = "] = $this->params['named']['profile'];
            $this->request->data['Bills']['profile_id'] = $this->params['named']['profile'];
        }


        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $creat = str_replace("-", "/", $this->params['named']['created']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Bill.created >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Bills']['created'] = $creat;
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $creat = str_replace("-", "/", $this->params['named']['created1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Bill.created <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Bills']['created1'] = $creat;
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $conds["Bill.modified_id = "] = $this->params['named']['modified_id'];
            $this->request->data['Bills']['modified_id'] = $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Bill.modified >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Bills']['modified'] = $creat;
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Bill.modified <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Bills']['modified1'] = $creat;
        }
        if (isset($this->params['named']['date1']) && !empty($this->params['named']['date1'])) {
            $creat = str_replace("-", "/", $this->params['named']['date1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Bill.date >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Bills']['date1'] = $creat;
        }
        if (isset($this->params['named']['date2']) && !empty($this->params['named']['date2'])) {
            $creat = str_replace("-", "/", $this->params['named']['date2']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Bill.date <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Bills']['date2'] = $creat;
        }
        return $conds;
    }

    /**
     * @param null $type
     * @param null $id
     * @return void
     */
    public function view($type = null, $id = null)
    {

        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            $this->redirect('/');
        }
        $this->set('type', $type);
        $this->setTimeActif();

        if (!$this->Bill->exists($id)) {
            throw new NotFoundException(__('Invalid bill'));
        }

        $options = array('conditions' => array('Bill.' . $this->Bill->primaryKey => $id),
            'recursive'=>-1,
            'fields'=>array(
                'Bill.reference',
                'Bill.type',
                'Bill.id',
                'Bill.date',
                'Bill.total_ht',
                'Bill.total_ttc',
                'Bill.total_tva',
                'Bill.created',
                'Bill.modified',
                'User.first_name',
                'User.last_name',
                'Modifier.first_name',
                'Modifier.last_name',
            ),
            'joins' => array(
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'User',
                    'conditions' => array('Bill.user_id = User.id')
                ),
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'Modifier',
                    'conditions' => array('Bill.modified_id = Modifier.id')
                ),
            )
            );
        $bill = $this->Bill->find('first', $options);
        $billProducts = $this->BillProduct->getBillProductsByBillId($id);

        $this->set(compact('bill', 'billProducts'));

    }

    /**
     * @param null $type
     * @return void
     * @throws Exception
     */
    public function add($type = null)
    {
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        $userId = $this->Auth->user('id');
        switch ($type) {
            case BillTypesEnum::supplier_order :
                $this->verifyUserPermission(SectionsEnum::commande_fournisseur, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);
                break;
            case BillTypesEnum::receipt :
                $this->verifyUserPermission(SectionsEnum::bon_reception, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::return_supplier :
                $this->verifyUserPermission(SectionsEnum::retour_fournisseur, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);
                break;
            case BillTypesEnum::purchase_invoice :
                $this->verifyUserPermission(SectionsEnum::facture_achat, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::credit_note :
                $this->verifyUserPermission(SectionsEnum::avoir, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::delivery_order :
                $this->verifyUserPermission(SectionsEnum::bon_livraison, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::return_customer :
                $this->verifyUserPermission(SectionsEnum::retour_client, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::entry_order :
                $this->verifyUserPermission(SectionsEnum::bon_entree, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::exit_order :
                $this->verifyUserPermission(SectionsEnum::bon_sortie, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::renvoi_order :
                $this->verifyUserPermission(SectionsEnum::bon_renvoi, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::reintegration_order :
                $this->verifyUserPermission(SectionsEnum::bon_reintegration, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::commercial_bills_list :
                $this->verifyUserPermission(SectionsEnum::bon_sortie, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);

                break;

            case BillTypesEnum::special_bills_list :
                $this->verifyUserPermission(SectionsEnum::bon_sortie, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);

                break;

            case BillTypesEnum::purchase_invoices_list :
                $this->verifyUserPermission(SectionsEnum::bon_sortie, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);

                break;
				
			case BillTypesEnum::quote :
                $this->verifyUserPermission(SectionsEnum::devis, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);
                break;
				
			case BillTypesEnum::customer_order :
                $this->verifyUserPermission(SectionsEnum::commande_client, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);
                break;
				
			case BillTypesEnum::sales_invoice :
                $this->verifyUserPermission(SectionsEnum::facture, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);
                break;
				
			case BillTypesEnum::sale_credit_note :
                $this->verifyUserPermission(SectionsEnum::avoir_vente, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::product_request :
                $this->Bill->validate = $this->Bill->validateProcurement;
                $this->verifyUserPermission(SectionsEnum::demande_produit, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::purchase_request :
                $this->Bill->validate = $this->Bill->validateProcurement;
                $this->verifyUserPermission(SectionsEnum::demande_achat, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::transfer_receipt :
                $this->Bill->validate = $this->Bill->validateTransfer;
                $this->verifyUserPermission(SectionsEnum::bon_transfert, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);
                break;

            default :
                $this->verifyUserPermission(SectionsEnum::bon_sortie, $userId, ActionsEnum::add, "Bills", null, "Bill", $type);

                break;
        }
        $reference = $this->getNextBillReference($type);
        $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
        $this->set(compact('reference', 'usePurchaseBill'));
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index', $type));
            }
            $this->Bill->create();
            $reference = $this->getNextBillReference($type);
            if ($reference != '0') {
                $this->request->data['Bill']['reference'] = $reference;
            }
            $this->request->data['Bill']['user_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['Bill']['amount_remaining'] = $this->request->data['Bill']['total_ttc'];
            $this->createDatetimeFromDate('Bill', 'date');
            $this->request->data['Bill']['type'] = $type;
            if( $type == BillTypesEnum::purchase_request||
                $type == BillTypesEnum::product_request) {
                $this->request->data['Bill']['supplier_id']=null;
            }
            switch ($type) {
                case BillTypesEnum::supplier_order :
                    $redirectType = BillTypesEnum::supplier_order;
                    break;
                case BillTypesEnum::receipt :
                case BillTypesEnum::delivery_order :
                case BillTypesEnum::return_customer :
                case BillTypesEnum::return_supplier :
                    $redirectType = BillTypesEnum::commercial_bills_list;
                    break;
                case BillTypesEnum::purchase_invoice :
                    $redirectType = BillTypesEnum::purchase_invoices_list;
                    break;
                case BillTypesEnum::credit_note :
                    $redirectType = BillTypesEnum::purchase_invoices_list;
                    break;
                case BillTypesEnum::entry_order :
                case BillTypesEnum::exit_order :
                case BillTypesEnum::renvoi_order :
                case BillTypesEnum::reintegration_order :
                    $redirectType = BillTypesEnum::special_bills_list;
                    break;
                case BillTypesEnum::quote :
                    $redirectType = BillTypesEnum::quote;
                    break;
                case BillTypesEnum::customer_order :
                    $redirectType = BillTypesEnum::customer_order;
                    break;
                case BillTypesEnum::product_request :
                    $redirectType = BillTypesEnum::product_request;
                    break;
                case BillTypesEnum::purchase_request :
                    $redirectType = BillTypesEnum::purchase_request;
                    break;
                 case BillTypesEnum::transfer_receipt :
                    $redirectType = BillTypesEnum::transfer_receipt;
                    break;
                case BillTypesEnum::sales_invoice :
                case BillTypesEnum::sale_credit_note :
                    $redirectType = BillTypesEnum::sale_invoices_list;
                    break;
                default:
                    $redirectType = BillTypesEnum::commercial_bills_list;
                    break;
            }
            if ($this->Bill->save($this->request->data['Bill'])) {
                $this->Parameter->setNextBillReferenceNumber($type);
                $billId = $this->Bill->getInsertID();
                $billProducts = $this->request->data['BillProduct'];

                $isMultiWarehouses = $this->Parameter->getCodesParameterVal('is_multi_warehouses');
                if (!empty($billProducts)) {
                    $orderBillProduct = 1;
                    foreach ($billProducts as $billProduct) {
                        $productId = $billProduct['product_id'];

                        if(isset($billProduct['SerialNumber'])){
                            $serialNumbers = $billProduct['SerialNumber'];
                        }
                        if ($usePurchaseBill == 1) {
                            $product = $this->Product->getProductById($productId);
                            $productWithLot = $product['Product']['with_lot'];
                            if ($productWithLot == 1) {
                                $lotId = $billProduct['lot_id'];
                            } else {
                                $lotId = $billProduct['product_id'];
                            }
                        } else {
                            $lotId = $billProduct['product_id'];
                        }
                        $billProductId = $this->BillProduct->addBillProduct($billProduct, $billId, $lotId, $orderBillProduct);
                        if(isset($serialNumbers)){
                            $this->SerialNumberManagement->handleProductsTraceability(
                                $billProductId,
                                $productId,
                                $type,
                                false,
                                $serialNumbers
                            );
                        }

                        $quantity = $billProduct['quantity'];
                        switch ($type) {
                            case BillTypesEnum::receipt :
                            case BillTypesEnum::delivery_order :
                            case BillTypesEnum::return_customer :
                            case BillTypesEnum::return_supplier :
                            case BillTypesEnum::entry_order :
                            case BillTypesEnum::exit_order :
                            case BillTypesEnum::renvoi_order :
                            case BillTypesEnum::reintegration_order :

                                $this->Lot->updateQuantityLot($lotId, $quantity, $type);
                                $this->Product->updateQuantityProduct($productId, $quantity, $type);
                                if($isMultiWarehouses==2 &&
                                    isset($this->request->data['Bill']['warehouse_id'])&&
                                    !empty($this->request->data['Bill']['warehouse_id'])
                                ){
                                    $warehouseId = $this->request->data['Bill']['warehouse_id'];
                                    $this->ProductWarehouse->updateQuantityProductWarehouse($productId,$warehouseId, $quantity, $type);
                                }
                                break;
                            case BillTypesEnum::transfer_receipt:
                                if(   isset($this->request->data['Bill']['warehouse_id'])&&
                                    !empty($this->request->data['Bill']['warehouse_id']) &&
                                    isset($this->request->data['Bill']['warehouse_destination_id'])&&
                                    !empty($this->request->data['Bill']['warehouse_destination_id'])){
                                    $warehouseId = $this->request->data['Bill']['warehouse_id'];
                                    $typeBill =  BillTypesEnum::exit_order ;
                                    $this->ProductWarehouse->updateQuantityProductWarehouse($productId,$warehouseId, $quantity, $typeBill);
                                    $warehouseId = $this->request->data['Bill']['warehouse_destination_id'];
                                    $typeBill =  BillTypesEnum::entry_order ;
                                    $this->ProductWarehouse->updateQuantityProductWarehouse($productId,$warehouseId, $quantity, $typeBill);

                                }
                            break;
                        }
                        $orderBillProduct ++;
                    }
                }
                if( $type == BillTypesEnum::purchase_request||
                    $type == BillTypesEnum::product_request) {
                    $services = $this->request->data['BillService']['service_id'];
                    foreach ($services as $service) {
                        $this->BillService->addBillService($service, $billId);
                    }
                }
                    $actionId = ActionsEnum::add;
                    switch ($type){
                        case BillTypesEnum::supplier_order :
                            $sectionId = SectionsEnum::nouvelle_commande_achat;
                            break;
                        case BillTypesEnum::receipt :
                            $sectionId = SectionsEnum::nouveau_bon_réception;
                            break;
                        case BillTypesEnum::return_supplier :
                            $sectionId = SectionsEnum::nouveau_retour_fournisseur;
                            break;
                        case BillTypesEnum::purchase_invoice :
                            $sectionId = SectionsEnum::nouvelle_facture_achat;
                            break;
                        case BillTypesEnum::credit_note :
                            $sectionId = SectionsEnum::nouvel_avoir_achat;
                            break;
                        case BillTypesEnum::delivery_order :
                            $sectionId = SectionsEnum::nouveau_bon_livraison;
                            break;
                        case BillTypesEnum::return_customer :
                            $sectionId = SectionsEnum::nouveau_retour_client;
                            break;
                        case BillTypesEnum::entry_order :
                            $sectionId = SectionsEnum::nouveau_bon_entrée;
                            break;
                        case BillTypesEnum::exit_order :
                            $sectionId = SectionsEnum::nouveau_bon_sortie;
                            break;
                        case BillTypesEnum::renvoi_order:
                            $sectionId = SectionsEnum::nouveau_bon_renvoi;
                            break;
                        case BillTypesEnum::reintegration_order :
                            $sectionId = SectionsEnum::nouveau_bon_réintegration;
                            break;
                        case BillTypesEnum::product_request :
                            $sectionId = SectionsEnum::nouvelle_demande_achat;
                            break;
                        case BillTypesEnum::purchase_request :
                            $sectionId = SectionsEnum::nouvelle_demande_produit;
                            break;
                        default :
                            $sectionId = SectionsEnum::nouvelle_commande_achat;
                            break;
                    }
                    $userId = $this->Auth->user('id');
                        $this->Notification->addNotification($billId, $userId, $actionId,$sectionId,'Bill');
                        $this->getNbNotificationsByUser();
                switch ($type){
                    case BillTypesEnum::supplier_order :
                        $sectionId = SectionsEnum::commande_fournisseur;
                        break;
                    case BillTypesEnum::receipt :
                        $sectionId = SectionsEnum::bon_reception;
                        break;
                    case BillTypesEnum::return_supplier :
                        $sectionId = SectionsEnum::retour_fournisseur;
                        break;
                    case BillTypesEnum::purchase_invoice :
                        $sectionId = SectionsEnum::facture_achat;
                        break;
                    case BillTypesEnum::credit_note :
                        $sectionId = SectionsEnum::avoir;
                        break;
                    case BillTypesEnum::delivery_order :
                        $sectionId = SectionsEnum::bon_livraison;
                        break;
                    case BillTypesEnum::return_customer :
                        $sectionId = SectionsEnum::retour_client;
                        break;
                    case BillTypesEnum::entry_order :
                        $sectionId = SectionsEnum::bon_entree;
                        break;
                    case BillTypesEnum::exit_order :
                        $sectionId = SectionsEnum::bon_sortie;
                        break;
                    case BillTypesEnum::renvoi_order:
                        $sectionId = SectionsEnum::bon_renvoi;
                        break;
                    case BillTypesEnum::reintegration_order :
                        $sectionId = SectionsEnum::bon_reintegration;
                        break;
                    case BillTypesEnum::product_request :
                        $sectionId = SectionsEnum::demande_produit;
                        break;
                    case BillTypesEnum::purchase_request :
                        $sectionId = SectionsEnum::demande_achat;
                        break;
                    default :
                        $sectionId = SectionsEnum::commande_fournisseur;
                        break;
                }

                $this->saveUserAction($sectionId, $billId, $userId, $actionId);
                //$this->setProductQuantitySessionAlerts();
                $this->Flash->success(__('The bill has been saved.'));
                $this->redirect(array('action' => 'index', $redirectType));
            } else {
                $this->Flash->error(__('The bill could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index', $redirectType));
            }
        }

        $products = $this->Product->getProducts();

        switch ($type) {
            case BillTypesEnum::supplier_order :
            case BillTypesEnum::receipt :
            case BillTypesEnum::return_supplier :
            case BillTypesEnum::purchase_invoice :
            case BillTypesEnum::credit_note :
                $suppliers = $this->Supplier->getSuppliersByParams(0, 1);
                break;

            case BillTypesEnum::delivery_order :
            case BillTypesEnum::return_customer :
            case BillTypesEnum::quote :
            case BillTypesEnum::customer_order :
            case BillTypesEnum::sales_invoice :
            case BillTypesEnum::sale_credit_note :
                $suppliers = $this->Supplier->getSuppliersByParams(1, 1, null, 2);
                break;

            case BillTypesEnum::entry_order :
            case BillTypesEnum::renvoi_order :
                $suppliers = $this->Supplier->getSuppliersByParams(0, 1, null, null);
                break;

            case BillTypesEnum::exit_order :
            case BillTypesEnum::reintegration_order :
                $suppliers = $this->Supplier->getSuppliersByParams(1, 1, null, array(2, 3), null, null, null, array(2, 3));
                break;

            case BillTypesEnum::product_request :
            case BillTypesEnum::purchase_request :
            $services = $this->Service->getServices('list');
                break;
        }

        $tvas = $this->Tva->getTvas(null, 'list', null);
        $transportBillCategories = $this->TransportBillCategory->getTransportBillCategories();
        $priceCategories = $this->PriceCategory->getPriceCategories('list');
        $isMultiWarehouses = $this->Parameter->getCodesParameterVal('is_multi_warehouses');
       if($isMultiWarehouses== 2){
           $warehouses = $this->Warehouse->getWarehouses('list');
           $this->set(compact('warehouses'));
       }
        $this->set(compact('suppliers', 'products', 'type', 'tvas',
            'transportBillCategories', 'priceCategories','services','isMultiWarehouses'));
    }

    /**
     * @param null $type
     * @param null $id
     * @return void
     * @throws Exception
     */
    public function edit($type = null, $id = null)
    {
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        $userId = $this->Auth->user('id');
        switch ($type) {
            case BillTypesEnum::supplier_order :
                $this->verifyUserPermission(SectionsEnum::commande_fournisseur, $userId, ActionsEnum::edit, "Bills", null, "Bill", $type);
                break;
            case BillTypesEnum::receipt :
                $this->verifyUserPermission(SectionsEnum::bon_reception, $userId, ActionsEnum::edit, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::return_supplier :
                $this->verifyUserPermission(SectionsEnum::retour_fournisseur, $userId, ActionsEnum::edit, "Bills", $id, "Bill", $type);
                break;
            case BillTypesEnum::purchase_invoice :
                $this->verifyUserPermission(SectionsEnum::facture_achat, $userId, ActionsEnum::edit, "Bills", $id, "Bill", $type);
                break;

            case BillTypesEnum::credit_note :
                $this->verifyUserPermission(SectionsEnum::avoir, $userId, ActionsEnum::edit, "Bills", $id, "Bill", $type);
                break;

            case BillTypesEnum::delivery_order :
                $this->verifyUserPermission(SectionsEnum::bon_livraison, $userId, ActionsEnum::edit, "Bills", $id, "Bill", $type);
                break;

            case BillTypesEnum::return_customer :
                $this->verifyUserPermission(SectionsEnum::retour_client, $userId, ActionsEnum::edit, "Bills", $id, "Bill", $type);
                break;

            case BillTypesEnum::entry_order :
                $this->verifyUserPermission(SectionsEnum::bon_entree, $userId, ActionsEnum::edit, "Bills", $id, "Bill", $type);
                break;

            case BillTypesEnum::exit_order :
                $this->verifyUserPermission(SectionsEnum::bon_sortie, $userId, ActionsEnum::edit, "Bills", $id, "Bill", $type);
                break;

            case BillTypesEnum::renvoi_order :
                $this->verifyUserPermission(SectionsEnum::bon_renvoi, $userId, ActionsEnum::edit, "Bills", $id, "Bill", $type);
                break;

            case BillTypesEnum::reintegration_order :
                $this->verifyUserPermission(SectionsEnum::bon_reintegration, $userId, ActionsEnum::edit, "Bills", $id, "Bill", $type);
                break;

            case BillTypesEnum::commercial_bills_list :
                $this->verifyUserPermission(SectionsEnum::bon_sortie, $userId, ActionsEnum::edit, "Bills", $id, "Bill", $type);

                break;

            case BillTypesEnum::special_bills_list :
                $this->verifyUserPermission(SectionsEnum::bon_sortie, $userId, ActionsEnum::edit, "Bills", $id, "Bill", $type);

                break;

            case BillTypesEnum::purchase_invoices_list :
                $this->verifyUserPermission(SectionsEnum::bon_sortie, $userId, ActionsEnum::edit, "Bills", $id, "Bill", $type);
                break;
				
			case BillTypesEnum::quote :
                $this->verifyUserPermission(SectionsEnum::devis, $userId, ActionsEnum::edit, "Bills", $id, "Bill", $type);
                break;
				
			case BillTypesEnum::customer_order :
                $this->verifyUserPermission(SectionsEnum::commande_client, $userId, ActionsEnum::edit, "Bills", $id, "Bill", $type);
                break;
				
			case BillTypesEnum::sales_invoice :
                $this->verifyUserPermission(SectionsEnum::facture, $userId, ActionsEnum::edit, "Bills", $id, "Bill", $type);
                break;
				
			case BillTypesEnum::sale_credit_note :
                $this->verifyUserPermission(SectionsEnum::avoir_vente, $userId, ActionsEnum::edit, "Bills", $id, "Bill", $type);
                break;

            case BillTypesEnum::product_request :
                $this->Bill->validate = $this->Bill->validateProcurement;
                $this->verifyUserPermission(SectionsEnum::demande_produit, $userId, ActionsEnum::edit, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::purchase_request :
                $this->Bill->validate = $this->Bill->validateProcurement;
                $this->verifyUserPermission(SectionsEnum::demande_achat, $userId, ActionsEnum::edit, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::transfer_receipt :
                $this->Bill->validate = $this->Bill->validateTransfer;
                $this->verifyUserPermission(SectionsEnum::bon_transfert, $userId, ActionsEnum::edit, "Bills", null, "Bill", $type);
                break;

            default :
                $this->verifyUserPermission(SectionsEnum::bon_sortie, $userId, ActionsEnum::edit, "Bills", $id, "Bill", $type);
                break;
        }
        if (!$this->Bill->exists($id)) {
            throw new NotFoundException(__('Invalid bill'));
        }
        $reference = $this->getNextBillReference($type);
        $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
        $this->set('reference', $reference);
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index', $type));
            }
			$precedentBill = $this->Bill->getBillById($id);
            $this->request->data['Bill']['modified_id'] = $this->Session->read('Auth.User.id');
            $this->createDatetimeFromDate('Bill', 'date');
            $this->request->data['Bill']['type'] = $type;
            if( $type == BillTypesEnum::purchase_request||
                $type == BillTypesEnum::product_request ||
                $type == BillTypesEnum::transfer_receipt
            ){
                $this->request->data['Bill']['supplier_id']=null;
            }
            switch ($type) {
                case BillTypesEnum::supplier_order :
                    $redirectType = BillTypesEnum::supplier_order;
                    break;
                case BillTypesEnum::receipt :
                case BillTypesEnum::delivery_order :
                case BillTypesEnum::return_customer :
                case BillTypesEnum::return_supplier :
                    $redirectType = BillTypesEnum::commercial_bills_list;
                    break;
                case BillTypesEnum::purchase_invoice :
                    $redirectType = BillTypesEnum::purchase_invoices_list;
                    break;
                case BillTypesEnum::credit_note :
                    $redirectType = BillTypesEnum::purchase_invoices_list;
                    break;
                case BillTypesEnum::entry_order :
                case BillTypesEnum::exit_order :
                case BillTypesEnum::renvoi_order :
                case BillTypesEnum::reintegration_order :
                    $redirectType = BillTypesEnum::special_bills_list;
                    break;

                case BillTypesEnum::quote :
                    $redirectType = BillTypesEnum::quote;
                    break;
                case BillTypesEnum::customer_order :
                    $redirectType = BillTypesEnum::customer_order;
                    break;
                case BillTypesEnum::product_request :
                    $redirectType = BillTypesEnum::product_request;
                    break;
                case BillTypesEnum::purchase_request :
                    $redirectType = BillTypesEnum::purchase_request;
                    break;
                case BillTypesEnum::transfer_receipt :
                    $redirectType = BillTypesEnum::transfer_receipt;
                    break;
                case BillTypesEnum::sales_invoice :
                case BillTypesEnum::sale_credit_note :
                    $redirectType = BillTypesEnum::sale_invoices_list;
                    break;
                default:
                    $redirectType = BillTypesEnum::commercial_bills_list;
                    break;
            }

            if ($this->Bill->save($this->request->data['Bill'])) {
                if (isset($this->request->data['Bill']['deleted_id']) &&
                    !empty($this->request->data['Bill']['deleted_id'])) {
                    $billProductDeletedId = $this->request->data['Bill']['deleted_id'];
                    $billProductIds = explode(",", $billProductDeletedId);
                    foreach ($billProductIds as $billProductId) {
                        $this->BillProduct->id = $billProductId;
                        $this->BillProduct->delete();
                        $this->SerialNumberManagement->deleteSerialNumbers(
                            $billProductId,
                            $type
                        );
                    }
                }
				if(($this->request->data['Bill']['total_ttc'] != $precedentBill['Bill']['total_ttc']) ||
					($this->request->data['Bill']['supplier_id'] != $precedentBill['Bill']['supplier_id'])
				){
					$this->Bill->id = $id;
					$this->Bill->saveField('amount_remaining', $this->request->data['Bill']['total_ttc']);
					$payments = $this->Payment->getPaymentsByBillId($id);
					$this->DetailPayment->deleteAll(array('DetailPayment.bill_id' => $id), false);
                    foreach($payments as $payment) {
						$this->Payment->createAssociationPaymentBills($payment['Payment']['id']);
					}
				}
                $isMultiWarehouses = $this->Parameter->getCodesParameterVal('is_multi_warehouses');
                $billProducts = $this->request->data['BillProduct'];
                if (!empty($billProducts)) {
                    $orderBillProduct = 1;
                    foreach ($billProducts as $billProduct) {
                        $productId = $billProduct['product_id'];
                        if ($usePurchaseBill == 1) {
                            $product = $this->Product->getProductById($productId);
                            $productWithLot = $product['Product']['with_lot'];
                            if ($productWithLot == 1) {
                                $lotId = $billProduct['lot_id'];
                            } else {
                                $lotId = $billProduct['product_id'];
                            }
                        } else {
                            $lotId = $billProduct['product_id'];
                        }
                        if (!empty($billProduct['id'])) {
                            /*recuperer la quantite precedente de la commande */
                            //$precedentQuantity= $this->BillProduct->getQuantityBillProduct($billProduct['id']);
                            $BillProductBeforeSave= $this->BillProduct->getBillProductById($billProduct['id']);
                            $precedentQuantity = $BillProductBeforeSave['BillProduct']['quantity'];
                            $precedentLotId = $BillProductBeforeSave['BillProduct']['lot_id'];
                            $precedentProductId = $BillProductBeforeSave['BillProduct']['lot_id'];
                            $this->Lot->resetQuantityLot($billProduct['id'], $type, $precedentLotId);
                            $this->Product->resetQuantityProduct($billProduct['id'], $type, $precedentProductId);
                            $precedentWarehouseId = $precedentBill['Bill']['warehouse_id'];
                            $precedentWarehouseDestinationId = $precedentBill['Bill']['warehouse_destination_id'];
                            if($isMultiWarehouses==2 &&
                                !empty($precedentWarehouseId)
                            ) {
                                $this->ProductWarehouse->resetQuantityProductWarehouse($precedentQuantity, $type,
                                    $precedentProductId, $precedentWarehouseId);
                            }
                            if($isMultiWarehouses == 2 &&
                                !empty($precedentWarehouseId)&& !empty($precedentWarehouseDestinationId)){
                                $typeTransfer = BillTypesEnum::exit_order;
                                $this->ProductWarehouse->resetQuantityProductWarehouse($precedentQuantity, $typeTransfer,
                                    $precedentProductId, $precedentWarehouseId);
                                $typeTransfer = BillTypesEnum::entry_order;
                                $this->ProductWarehouse->resetQuantityProductWarehouse($precedentQuantity, $typeTransfer,
                                    $precedentProductId, $precedentWarehouseDestinationId);
                            }
                            if(isset($billProduct["SerialNumber"])){
                                $serialNumbers = $billProduct["SerialNumber"];
                            }
                            $this->BillProduct->updateBillProduct($billProduct, $id, $lotId , $orderBillProduct);
                            if(isset($serialNumbers)){
                                $billProductId = $billProduct['id'];
                                $this->SerialNumberManagement->handleProductsTraceability(
                                    $billProductId,
                                    $productId,
                                    $type,
                                    true,
                                    $serialNumbers
                                );
                            }
                        } else {
                            if(isset($billProduct["SerialNumber"])){
                                $serialNumbers = $billProduct["SerialNumber"];
                            }
                            $billProductId = $this->BillProduct->addBillProduct($billProduct, $id, $lotId, $orderBillProduct);
                            if(isset($serialNumbers)){
                                $this->SerialNumberManagement->handleProductsTraceability(
                                    $billProductId,
                                    $productId,
                                    $type,
                                    false,
                                    $serialNumbers
                                );
                            }
                        }

                        $quantity = $billProduct['quantity'];
                        switch ($type) {
                            case BillTypesEnum::receipt :
                            case BillTypesEnum::delivery_order :
                            case BillTypesEnum::return_customer :
                            case BillTypesEnum::return_supplier :
                            case BillTypesEnum::entry_order :
                            case BillTypesEnum::exit_order :
                            case BillTypesEnum::renvoi_order :
                            case BillTypesEnum::reintegration_order :
                                $this->Lot->updateQuantityLot($lotId, $quantity, $type);
                                $this->Product->updateQuantityProduct($productId, $quantity, $type);
                            if($isMultiWarehouses==2 &&
                                isset($this->request->data['Bill']['warehouse_id'])&&
                                !empty($this->request->data['Bill']['warehouse_id'])
                            ){
                                $warehouseId = $this->request->data['Bill']['warehouse_id'];
                                $this->ProductWarehouse->updateQuantityProductWarehouse($productId,$warehouseId, $quantity, $type);
                            }
                                break;
                            case BillTypesEnum::transfer_receipt:
                                if(   isset($this->request->data['Bill']['warehouse_id'])&&
                                    !empty($this->request->data['Bill']['warehouse_id']) &&
                                    isset($this->request->data['Bill']['warehouse_destination_id'])&&
                                    !empty($this->request->data['Bill']['warehouse_destination_id'])){
                                    $warehouseId = $this->request->data['Bill']['warehouse_id'];
                                    $typeBill =  BillTypesEnum::exit_order ;
                                    $this->ProductWarehouse->updateQuantityProductWarehouse($productId,$warehouseId, $quantity, $typeBill);
                                    $warehouseId = $this->request->data['Bill']['warehouse_destination_id'];
                                    $typeBill =  BillTypesEnum::entry_order ;
                                    $this->ProductWarehouse->updateQuantityProductWarehouse($productId,$warehouseId, $quantity, $typeBill);

                                }
                                break;
                        }
                        $orderBillProduct ++;
                    }
                }

                if( $type == BillTypesEnum::purchase_request||
                    $type == BillTypesEnum::product_request){
                    $this->BillService->deleteBillServices($id);
                    $services= $this->request->data['BillService']['service_id'];
                    foreach ($services as $service){
                        $this->BillService->addBillService($service,$id);
                    }
                }
                $actionId = ActionsEnum::edit;
                switch ($type){
                    case BillTypesEnum::supplier_order :
                        $sectionId = SectionsEnum::commande_fournisseur;
                        break;
                    case BillTypesEnum::receipt :
                        $sectionId = SectionsEnum::bon_reception;
                        break;
                    case BillTypesEnum::return_supplier :
                        $sectionId = SectionsEnum::retour_fournisseur;
                        break;
                    case BillTypesEnum::purchase_invoice :
                        $sectionId = SectionsEnum::facture_achat;
                        break;
                    case BillTypesEnum::credit_note :
                        $sectionId = SectionsEnum::avoir;
                        break;
                    case BillTypesEnum::delivery_order :
                        $sectionId = SectionsEnum::bon_livraison;
                        break;
                    case BillTypesEnum::return_customer :
                        $sectionId = SectionsEnum::retour_client;
                        break;
                    case BillTypesEnum::entry_order :
                        $sectionId = SectionsEnum::bon_entree;
                        break;
                    case BillTypesEnum::exit_order :
                        $sectionId = SectionsEnum::bon_sortie;
                        break;
                    case BillTypesEnum::renvoi_order:
                        $sectionId = SectionsEnum::bon_renvoi;
                        break;
                    case BillTypesEnum::reintegration_order :
                        $sectionId = SectionsEnum::bon_reintegration;
                        break;
                    case BillTypesEnum::product_request :
                        $sectionId = SectionsEnum::demande_produit;
                        break;
                    case BillTypesEnum::purchase_request :
                        $sectionId = SectionsEnum::demande_achat;
                        break;

                     case BillTypesEnum::transfer_receipt :
                        $sectionId = SectionsEnum::transfer_receipt;
                        break;
                    default :
                        $sectionId = SectionsEnum::commande_fournisseur;
                        break;
                }
                $this->saveUserAction($sectionId, $id, $userId, $actionId);
                //$this->setProductQuantitySessionAlerts();
                $this->Flash->success(__('The bill has been saved.'));
                    $this->redirect(array('action' => 'index', $redirectType));
            } else {
                $this->Flash->error(__('The bill could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index', $redirectType));

            }
        } else {
            $options = array('conditions' => array('Bill.' . $this->Bill->primaryKey => $id));
            $this->request->data = $this->Bill->find('first', $options);
            $nb_products = $this->BillProduct->find('count', array('conditions' => array('BillProduct.bill_id' => $id)));
            $billProducts = $this->BillProduct->getBillProductsByBillId($id);
            $usedProductIds = array();
            if ($usePurchaseBill == 1) {
                $i = 1;
                foreach ($billProducts as $billProduct) {
                    $lot = $this->Lot->getLotById($billProduct['BillProduct']['lot_id']);
                    $productId = $lot['Lot']['product_id'];
                    $product = $this->Product->getProductById($productId);
                    $usedProductIds[$i]['id'] = $productId;
                    $usedProductIds[$i]['with_lot'] = $product['Product']['with_lot'];
                    $i++;
                }
                $this->set('usedProductIds', $usedProductIds);
            }
            $billServices = $this->BillService->getBillServicesByBillId($id);
            $selectedServiceIds= array();
            foreach ($billServices as $billService){
                $selectedServiceIds[]= $billService['BillService']['service_id'];
            }

            $this->set(compact('selectedServiceIds','billProducts', 'nb_products', 'usePurchaseBill','billServices'));
        }
        $products = $this->Product->getProducts();
        switch ($type) {
            case BillTypesEnum::supplier_order :
            case BillTypesEnum::receipt :
            case BillTypesEnum::return_supplier :
            case BillTypesEnum::purchase_invoice :
            case BillTypesEnum::credit_note :
                $suppliers = $this->Supplier->getSuppliersByParams(0, 1);
                break;

            case BillTypesEnum::delivery_order :
            case BillTypesEnum::return_customer :
            case BillTypesEnum::quote :
            case BillTypesEnum::customer_order :
            case BillTypesEnum::sales_invoice :
            case BillTypesEnum::sale_credit_note :
                $suppliers = $this->Supplier->getSuppliersByParams(1, 1, null, 2);
                break;

            case BillTypesEnum::entry_order :
            case BillTypesEnum::renvoi_order :
                $suppliers = $this->Supplier->getSuppliersByParams(0, 1, null, null, null, null, null, array(2, 3));
                break;

            case BillTypesEnum::exit_order :
            case BillTypesEnum::reintegration_order :
                $suppliers = $this->Supplier->getSuppliersByParams(1, 1, null, array(2, 3), null, null, null, array(2, 3));
                break;
            case BillTypesEnum::product_request :
            case BillTypesEnum::purchase_request :
                $services = $this->Service->getServices('list');
            $fields = "names";
            $conditions = array('Customer.id'=>$this->request->data['Bill']['customer_id']);
            $customers = $this->Customer->getCustomersByFieldsAndConds($fields,$conditions);
        }
        $tvas = $this->Tva->getTvas(null, 'list', null);
        $transportBillCategories = $this->TransportBillCategory->getTransportBillCategories();
        $priceCategories = $this->PriceCategory->getPriceCategories('list');
        $lots = $this->Lot->getLots();
        $isMultiWarehouses = $this->Parameter->getCodesParameterVal('is_multi_warehouses');
        if($isMultiWarehouses== 2){
            $warehouses = $this->Warehouse->getWarehouses('list');
            $this->set(compact('warehouses'));
        }
        $this->set(compact('lots', 'services','suppliers', 'products', 'type',
            'tvas', 'transportBillCategories', 'clients', 'priceCategories','customers','isMultiWarehouses'));
    }

    /**
     * @return void
     */
    public function printSimplifiedJournal()
    {
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            $this->redirect('/');
        }

        $this->setTimeActif();
        ini_set('memory_limit', '512M');


        $conditions = array();
        if (!empty($supplierId)) {
            $conditions["Supplier.id"] = $supplierId;
        }
        if (!empty($startDate)) {
            $date_from = str_replace("/", "-", $startDate);
            $start = str_replace("-", "/", $date_from);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $conditions["Bill.date >="] = $startdtm->format('Y-m-d H:i:s');
        }
        if (!empty($endDate)) {
            $date_to = str_replace("/", "-", $endDate);
            $end = str_replace("-", "/", $date_to);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $conditions["Bill.date <="] = $enddtm->format('Y-m-d H:i:s');
        }
        $ids = filter_input(INPUT_POST, "chkids");
        $type = filter_input(INPUT_POST, "typePiece");
		switch($type){
			case BillTypesEnum::commercial_bills_list :
                $type = array(BillTypesEnum::receipt, BillTypesEnum::delivery_order,
							BillTypesEnum::return_supplier, BillTypesEnum::return_customer
				);
                break;

            case BillTypesEnum::special_bills_list :
                $type = array(BillTypesEnum::entry_order, BillTypesEnum::exit_order,
							BillTypesEnum::renvoi_order, BillTypesEnum::reintegration_order
				);
                break;

            case BillTypesEnum::purchase_invoices_list :
                $type = array(BillTypesEnum::purchase_invoice, BillTypesEnum::credit_note);
                break;    
				
			case BillTypesEnum::sale_invoices_list :
                $type = array(BillTypesEnum::sales_invoice, BillTypesEnum::sale_credit_note);
                break;
		}
        
		
		if (!empty($ids)) {
            $array_ids = explode(",", $ids);
            if (!empty($array_ids)) {
                $conditions["Bill.id"] = $array_ids;
            }
        }
		if(!empty($type)){
			 $conditions["Bill.type"] = $type;
		}
        $bills = $this->Bill->getBillsByConditions($conditions, 'all');

        $company = $this->Company->find('first');
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('bills', 'company', 'separatorAmount'));

    }

    
	/** created : 16/04/2019
     * @return void
     */
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
		switch($type){
			case BillTypesEnum::commercial_bills_list :
                $type = array(BillTypesEnum::receipt, BillTypesEnum::delivery_order,
							BillTypesEnum::return_supplier, BillTypesEnum::return_customer
				);
                break;

            case BillTypesEnum::special_bills_list :
                $type = array(BillTypesEnum::entry_order, BillTypesEnum::exit_order,
							BillTypesEnum::renvoi_order, BillTypesEnum::reintegration_order
				);
                break;

            case BillTypesEnum::purchase_invoices_list :
                $type = array(BillTypesEnum::purchase_invoice, BillTypesEnum::credit_note);
                break;    
				
			case BillTypesEnum::sale_invoices_list :
                $type = array(BillTypesEnum::sales_invoice, BillTypesEnum::sale_credit_note);
                break;
		}
        
		
		
		
		
        $conditions["Bill.type = "] = $type;
        if (!empty($supplierId)) {
            $conditions["Supplier.id"] = $supplierId;
        }
        if (!empty($startDate)) {
            $date_from = str_replace("/", "-", $startDate);
            $start = str_replace("-", "/", $date_from);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $conditions["Bill.date >="] = $startdtm->format('Y-m-d H:i:s');
        }
        if (!empty($endDate)) {
            $date_to = str_replace("/", "-", $endDate);
            $end = str_replace("-", "/", $date_to);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $conditions["Bill.date <="] = $enddtm->format('Y-m-d H:i:s');
        }
        $ids = filter_input(INPUT_POST, "chkids");
        if (!empty($ids)) {
            $array_ids = explode(",", $ids);
            if (!empty($array_ids)) {
                $conditions["Bill.id"] = $array_ids;
            }
        }
        $bills = $this->Bill->find('all', array(
            'recursive' => -1,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'fields' => array(
                'Bill.reference',
                'Bill.id',
                'Bill.date',
                'Bill.total_ttc',
                'Bill.total_ht',
                'Bill.total_tva',
                'Bill.amount_remaining',
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
                    'conditions' => array('DetailPayment.bill_id = Bill.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Bill.supplier_id = Supplier.id')
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
        $this->set(compact('bills', 'company', 'separatorAmount'));

    }
	
	
	/** created : 16/04/2019
     * @return void
     */
	public function printSimplifiedJournalWithDetailBill()
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        $array = filter_input(INPUT_POST, "printSimplifiedJournalWithDetailBill");

        $arrayConditions = explode(",", $array);

        $supplierId = $arrayConditions[0];
        $startDate = $arrayConditions[1];
        $endDate = $arrayConditions[2];

        $conditions = array();
        $type = filter_input(INPUT_POST, "typePiece");
		
		switch($type){
			case BillTypesEnum::commercial_bills_list :
                $type = array(BillTypesEnum::receipt, BillTypesEnum::delivery_order,
							BillTypesEnum::return_supplier, BillTypesEnum::return_customer
				);
                break;

            case BillTypesEnum::special_bills_list :
                $type = array(BillTypesEnum::entry_order, BillTypesEnum::exit_order,
							BillTypesEnum::renvoi_order, BillTypesEnum::reintegration_order
				);
                break;

            case BillTypesEnum::purchase_invoices_list :
                $type = array(BillTypesEnum::purchase_invoice, BillTypesEnum::credit_note);
                break;    
				
			case BillTypesEnum::sale_invoices_list :
                $type = array(BillTypesEnum::sales_invoice, BillTypesEnum::sale_credit_note);
                break;
		}
        
		
		
        $conditions["Bill.type = "] = $type;
        if (!empty($supplierId)) {
            $conditions["Supplier.id"] = $supplierId;
        }
        if (!empty($startDate)) {
            $date_from = str_replace("/", "-", $startDate);
            $start = str_replace("-", "/", $date_from);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $conditions["Bill.date >="] = $startdtm->format('Y-m-d H:i:s');
        }
        if (!empty($endDate)) {
            $date_to = str_replace("/", "-", $endDate);
            $end = str_replace("-", "/", $date_to);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $conditions["Bill.date <="] = $enddtm->format('Y-m-d H:i:s');
        }
        $ids = filter_input(INPUT_POST, "chkids");

        if (!empty($ids)) {
            $array_ids = explode(",", $ids);
            if (!empty($array_ids)) {
                $conditions["Bill.id"] = $array_ids;
            }
        }

        $billProducts = $this->BillProduct->getDetailedBillProductsByConditions($conditions);


        $company = $this->Company->find('first');
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact( 'billProducts', 'company', 'separatorAmount'));

    }

   




    
	
	
	
	
	/**
     * @return void
     */
    public function printSimplifiedJournalBySupplier()
    {
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
		$conditions = array();
		$type = filter_input(INPUT_POST, "typePiece");
		
		switch($type){
			case BillTypesEnum::commercial_bills_list :
                $type = array(BillTypesEnum::receipt, BillTypesEnum::delivery_order,
							BillTypesEnum::return_supplier, BillTypesEnum::return_customer
				);
                break;
            case BillTypesEnum::special_bills_list :
                $type = array(BillTypesEnum::entry_order, BillTypesEnum::exit_order,
							BillTypesEnum::renvoi_order, BillTypesEnum::reintegration_order
				);
                break;
            case BillTypesEnum::purchase_invoices_list :
                $type = array(BillTypesEnum::purchase_invoice, BillTypesEnum::credit_note);
                break;    
				
			case BillTypesEnum::sale_invoices_list :
                $type = array(BillTypesEnum::sales_invoice, BillTypesEnum::sale_credit_note);
                break;
		}
        
		
		
        $conditions["Bill.type = "] = $type;
        if (!empty($supplierId)) {
            $conditions["Supplier.id"] = $supplierId;
        }
        if (!empty($startDate)) {
            $date_from = str_replace("/", "-", $startDate);
            $start = str_replace("-", "/", $date_from);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $conditions["Bill.date >="] = $startdtm->format('Y-m-d H:i:s');
        }
        if (!empty($endDate)) {
            $date_to = str_replace("/", "-", $endDate);
            $end = str_replace("-", "/", $date_to);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $conditions["Bill.date <="] = $enddtm->format('Y-m-d H:i:s');
        }
        $ids = filter_input(INPUT_POST, "chkids");

        if (!empty($ids)) {
            $array_ids = explode(",", $ids);
            if (!empty($array_ids)) {
                $conditions["Bill.id"] = $array_ids;
            }
        }


        $order = array('Supplier.id ASC');
        $bills = $this->Bill->getBillsByConditions($conditions, 'all', $order);

        $company = $this->Company->find('first');
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('bills', 'company', 'separatorAmount'));

    }

    public function view_bill($id)
    {

        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        if (!$this->Bill->exists($id)) {
            throw new NotFoundException(__('Invalid bill'));
        }
        $bill = $this->Bill->getDetailedBillById($id);
        $billProducts = $this->BillProduct->getBillProductsByBillId($id);

        $company = $this->Company->find('first');
        $wilayaId = $company['Company']['wilaya'];
        $destination = $this->Destination->find('first', array('conditions' => array('Destination.id' => $wilayaId)));
        $wilayaName = $destination['Destination']['name'];
        // get method of header pdf
        $entete_pdf = $this->Parameter->getCodesParameterVal('entete_pdf');
        // get signature of mission order
        $signature_mission_order = $this->Parameter->getCodesParameterVal('signature_mission_order');

        $separatorAmount = $this->getSeparatorAmount();
        $this->set('signature_mission_order', $signature_mission_order);
        $this->set('entete_pdf', $entete_pdf);

        $commercialDocumentModel = $this->Parameter->getCodesParameterVal('commercial_document_model');
        $billServices = $this->BillService->getBillServicesByBillId($id);

        $this->set(compact('bill', 'company', 'separatorAmount',
            'billProducts','wilayaName','commercialDocumentModel','billServices'));

    }

   
 public function viewBillWithAudit($id)
    {

        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        if (!$this->Bill->exists($id)) {
            throw new NotFoundException(__('Invalid bill'));
        }
        $bill = $this->Bill->getDetailedBillById($id);
        $billProducts = $this->BillProduct->getBillProductsByBillId($id);

        $company = $this->Company->find('first');
        $wilayaId = $company['Company']['wilaya'];
        $destination = $this->Destination->find('first', array('conditions' => array('Destination.id' => $wilayaId)));
        $wilayaName = $destination['Destination']['name'];
        // get method of header pdf
        $entete_pdf = $this->Parameter->getCodesParameterVal('entete_pdf');
        // get signature of mission order
        $signature_mission_order = $this->Parameter->getCodesParameterVal('signature_mission_order');

        $separatorAmount = $this->getSeparatorAmount();
        $this->set('signature_mission_order', $signature_mission_order);
        $this->set('entete_pdf', $entete_pdf);
        $type = $bill['Bill']['type'];
        switch ($type){
            case BillTypesEnum::supplier_order :
                $sectionId = SectionsEnum::commande_fournisseur;
                break;
            case BillTypesEnum::receipt :
                $sectionId = SectionsEnum::bon_reception;
                break;
            case BillTypesEnum::return_supplier :
                $sectionId = SectionsEnum::retour_fournisseur;
                break;
            case BillTypesEnum::purchase_invoice :
                $sectionId = SectionsEnum::facture_achat;
                break;
            case BillTypesEnum::credit_note :
                $sectionId = SectionsEnum::avoir;
                break;
            case BillTypesEnum::delivery_order :
                $sectionId = SectionsEnum::bon_livraison;
                break;
            case BillTypesEnum::return_customer :
                $sectionId = SectionsEnum::retour_client;
                break;
            case BillTypesEnum::entry_order :
                $sectionId = SectionsEnum::bon_entree;
                break;
            case BillTypesEnum::exit_order :
                $sectionId = SectionsEnum::bon_sortie;
                break;
            case BillTypesEnum::renvoi_order:
                $sectionId = SectionsEnum::bon_renvoi;
                break;
            case BillTypesEnum::reintegration_order :
                $sectionId = SectionsEnum::bon_reintegration;
                break;
            case BillTypesEnum::product_request :
                $sectionId = SectionsEnum::demande_produit;
                break;
            case BillTypesEnum::purchase_request :
                $sectionId = SectionsEnum::demande_achat;
                break;
            default :
                $sectionId = SectionsEnum::commande_fournisseur;
                break;
        }
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
            'conditions' => array('article_id' => $id, 'rubric_id' =>$sectionId),


        ));
        $this->set(compact('bill', 'company', 'separatorAmount',
            'billProducts','wilayaName','audits'));

    }






      function printDetailedBill($id = null, $type = null)
    {

        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();

        ini_set('memory_limit', '512M');
        $this->set('type', $type);
		$bill = $this->Bill->getDetailedBillById($id);
        $billProducts = $this->BillProduct->getBillProductsByBillId($id);
        $company = $this->Company->find('first');

        $this->set(compact('company', 'bill', 'billProducts'));
        $entete_pdf = $this->Parameter->getCodesParameterVal('entete_pdf');
        $this->set('entete_pdf', $entete_pdf);

    }

    function printBillWithRegulationDetails($id = null, $type = null){
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        if (!$this->Bill->exists($id)) {
            throw new NotFoundException(__('Invalid bill'));
        }
        $bill = $this->Bill->getDetailedBillById($id);
        $billProducts = $this->BillProduct->getBillProductsByBillId($id);

        $company = $this->Company->find('first');

        // get method of header pdf
        $entete_pdf = $this->Parameter->getCodesParameterVal('entete_pdf');
        // get signature of mission order
        $signature_mission_order = $this->Parameter->getCodesParameterVal('signature_mission_order');

        $separatorAmount = $this->getSeparatorAmount();
        $this->set('company', $company);
        $this->set('signature_mission_order', $signature_mission_order);
        $this->set('entete_pdf', $entete_pdf);
        $payments = $this->Payment->getPaymentPartsByBillIds($id);

        $this->set(compact('bill', 'company', 'separatorAmount', 'billProducts','payments'));
    }








   /**
     * @param null $type
     * @param null $id
     * @return void
     */
    public function Delete($type = null, $id = null)
    {
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        $userId = $this->Auth->user('id');
        $bill = $this->Bill->getBillById($id);
        $typeBill = $bill['Bill']['type'];
        switch ($type) {
            case BillTypesEnum::supplier_order :
                $this->verifyUserPermission(SectionsEnum::commande_fournisseur, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;
            case BillTypesEnum::receipt :
                $this->verifyUserPermission(SectionsEnum::bon_reception, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::return_supplier :
                $this->verifyUserPermission(SectionsEnum::retour_fournisseur, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;
            case BillTypesEnum::purchase_invoice :
                $this->verifyUserPermission(SectionsEnum::facture_achat, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::credit_note :
                $this->verifyUserPermission(SectionsEnum::avoir, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::delivery_order :
                $this->verifyUserPermission(SectionsEnum::bon_livraison, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::return_customer :
                $this->verifyUserPermission(SectionsEnum::retour_client, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::entry_order :
                $this->verifyUserPermission(SectionsEnum::bon_entree, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::exit_order :
                $this->verifyUserPermission(SectionsEnum::bon_sortie, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::renvoi_order :
                $this->verifyUserPermission(SectionsEnum::bon_renvoi, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::reintegration_order :
                $this->verifyUserPermission(SectionsEnum::bon_reintegration, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::quote :
                $this->verifyUserPermission(SectionsEnum::devis, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::customer_order :
                $this->verifyUserPermission(SectionsEnum::commande_client, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::sales_invoice :
                $this->verifyUserPermission(SectionsEnum::facture, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::sale_credit_note :
                $this->verifyUserPermission(SectionsEnum::avoir_vente, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

             case BillTypesEnum::product_request :
                $this->verifyUserPermission(SectionsEnum::demande_produit, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

             case BillTypesEnum::purchase_request :
                $this->verifyUserPermission(SectionsEnum::demande_achat, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::commercial_bills_list :

                switch ($typeBill){
                    case BillTypesEnum::receipt:
                        $section = SectionsEnum :: bon_reception;
                        break;

                    case BillTypesEnum::delivery_order:
                        $section = SectionsEnum :: bon_livraison;
                        break;

                    case BillTypesEnum::return_supplier:
                        $section = SectionsEnum :: retour_fournisseur;
                        break;

                     case BillTypesEnum::return_customer:
                        $section = SectionsEnum :: retour_client;
                        break;

                    default :
                        $section = SectionsEnum :: bon_reception;
                        break;
                }

                $this->verifyUserPermission($section, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);

                break;

            case BillTypesEnum::special_bills_list :
                switch ($typeBill){
                    case BillTypesEnum::entry_order:
                        $section = SectionsEnum :: bon_entree;
                        break;

                    case BillTypesEnum::exit_order:
                        $section = SectionsEnum :: bon_sortie;
                        break;
                    case BillTypesEnum::renvoi_order:
                        $section = SectionsEnum :: bon_renvoi;
                        break;
                    case BillTypesEnum::reintegration_order:
                        $section = SectionsEnum :: bon_reintegration;
                        break;
                    default :
                        $section = SectionsEnum :: bon_reception;
                        break;
                }
                $this->verifyUserPermission($section, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);

                break;

            case BillTypesEnum::purchase_invoices_list :

                switch ($typeBill){
                    case BillTypesEnum::purchase_invoice:
                        $section = SectionsEnum :: facture_achat;
                        break;
                    case BillTypesEnum::credit_note:
                        $section = SectionsEnum :: avoir;
                        break;
                    default :
                        $section = SectionsEnum :: facture_achat;
                        break;
                }
                $this->verifyUserPermission($section, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);

                break;
                case BillTypesEnum::sale_invoices_list :
                switch ($typeBill){
                    case BillTypesEnum::sales_invoice :
                        $section = SectionsEnum :: facture;
                        break;
                    case BillTypesEnum::sale_credit_note:
                        $section = SectionsEnum :: avoir_vente;
                        break;
                    default :
                        $section = SectionsEnum :: facture;
                        break;
                }
                $this->verifyUserPermission($section, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);

                break;

            default :
                $this->verifyUserPermission(SectionsEnum::bon_sortie, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);

                break;
        }
        $this->Bill->id = $id;
        if (!$this->Bill->exists()) {
            throw new NotFoundException(__('Invalid bill'));
        }
        $bill= $this->Bill->getBillById($id);
        $typeBill = $bill['Bill']['type'];
        $this->verifyDependences($id, $typeBill);
        $this->request->allowMethod('post', 'delete');

        if ($this->Bill->delete()) {
            //$this->setProductQuantitySessionAlerts();

            switch ($type) {
                case BillTypesEnum::supplier_order :
                    $redirectType = BillTypesEnum::supplier_order;
                    break;

                case BillTypesEnum::quote :
                    $redirectType = BillTypesEnum::quote;
                    break;

                case BillTypesEnum::customer_order :
                    $redirectType = BillTypesEnum::customer_order;
                    break;

                case BillTypesEnum::product_request :
                    $redirectType = BillTypesEnum::product_request;
                    break;

                 case BillTypesEnum::purchase_request :
                    $redirectType = BillTypesEnum::purchase_request;
                    break;

                case BillTypesEnum::receipt :
                case BillTypesEnum::delivery_order :
                case BillTypesEnum::return_customer :
                case BillTypesEnum::return_supplier :
                case BillTypesEnum::commercial_bills_list :
                    $redirectType = BillTypesEnum::commercial_bills_list;
                    break;

                case BillTypesEnum::purchase_invoice :
                case BillTypesEnum::credit_note :
                case BillTypesEnum::purchase_invoices_list :
                    $redirectType = BillTypesEnum::purchase_invoices_list;
                    break;

                case BillTypesEnum::sales_invoice :
                case BillTypesEnum::sale_credit_note :
                case BillTypesEnum::sale_invoices_list :
                    $redirectType = BillTypesEnum::sale_invoices_list;
                    break;

                case BillTypesEnum::entry_order :
                case BillTypesEnum::exit_order :
                case BillTypesEnum::renvoi_order :
                case BillTypesEnum::reintegration_order :
                case BillTypesEnum::special_bills_list :
                    $redirectType = BillTypesEnum::special_bills_list;
                    break;

                default:
                    $redirectType = BillTypesEnum::commercial_bills_list;
                    break;
            }
            $this->Flash->success(__('The bill has been deleted.'));
        } else {
            $this->Flash->error(__('The bill could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index', $redirectType));
    }

    public function verifyDependences($id, $type)
    {
        $this->setTimeActif();
        $isMultiWarehouses = $this->Parameter->getCodesParameterVal('is_multi_warehouses');
        if($isMultiWarehouses==2){
            $bill= $this->Bill->getBillById($id);
            $warehouseId = $bill['Bill']['warehouse_id'];
            $warehouseDestinationId = $bill['Bill']['warehouse_destination_id'];
        }

        $billProducts = $this->BillProduct->getBillProductsByBillId($id);
        foreach ($billProducts as $billProduct) {
            $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
            if ($usePurchaseBill == 1) {
                $lot = $this->Lot->getLotById($billProduct['BillProduct']['lot_id']);
                $productId = $lot['Lot']['product_id'];
                $product = $this->Product->getProductById($productId);
                $productWithLot = $product['Product']['with_lot'];
                if ($productWithLot == 1) {
                    $lotId = $billProduct['BillProduct']['lot_id'];
                } else {
                    $lotId = $billProduct['BillProduct']['lot_id'];
                    $productId = $billProduct['BillProduct']['lot_id'];
                }
            } else {
                $lotId = $billProduct['BillProduct']['lot_id'];
                $productId = $billProduct['BillProduct']['lot_id'];
            }
            $this->Lot->resetQuantityLot($billProduct['BillProduct']['id'], $type, $lotId);
            $this->Product->resetQuantityProduct($billProduct['BillProduct']['id'], $type, $productId);
            if($isMultiWarehouses==2 &&
                !empty($warehouseId)
            ) {
                $this->ProductWarehouse->resetQuantityProductWarehouse($billProduct['BillProduct']['quantity'], $type,
                    $productId, $warehouseId);
            }
            if($isMultiWarehouses == 2 &&
                !empty($warehouseId)&& !empty($warehouseDestinationId)){
                $typeTransfer = BillTypesEnum::exit_order;
                $this->ProductWarehouse->resetQuantityProductWarehouse($billProduct['BillProduct']['quantity'],
                    $typeTransfer, $productId, $warehouseId);
                $typeTransfer = BillTypesEnum::entry_order;
                $this->ProductWarehouse->resetQuantityProductWarehouse($billProduct['BillProduct']['quantity'],
                    $typeTransfer, $productId, $warehouseDestinationId);
            }
        }
        $this->BillProduct->deleteAll(array('BillProduct.bill_id' => $id), false);
        if($type == BillTypesEnum::purchase_request ||
           $type == BillTypesEnum::product_request){
            $this->BillService->deleteAll(array('BillService.bill_id' => $id), false);
            $this->Notification->deleteAll(array('Notification.bill_id' => $id), false);
        }


    }

    /**
     * @return void
     */
    public function deletebills()
    {

        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        $userId = $this->Auth->user('id');
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $bill = $this->Bill->getDetailedBillById($id);
        $type = $bill['Bill']['type'];
        switch ($type) {
            case BillTypesEnum::supplier_order :
                $this->verifyUserPermission(SectionsEnum::commande_fournisseur, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;
            case BillTypesEnum::receipt :
                $this->verifyUserPermission(SectionsEnum::bon_reception, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::return_supplier :
                $this->verifyUserPermission(SectionsEnum::retour_fournisseur, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;
            case BillTypesEnum::purchase_invoice :
                $this->verifyUserPermission(SectionsEnum::facture_achat, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::credit_note :
                $this->verifyUserPermission(SectionsEnum::avoir, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::delivery_order :
                $this->verifyUserPermission(SectionsEnum::bon_livraison, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::return_customer :
                $this->verifyUserPermission(SectionsEnum::retour_client, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::entry_order :
                $this->verifyUserPermission(SectionsEnum::bon_entree, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::exit_order :
                $this->verifyUserPermission(SectionsEnum::bon_sortie, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::renvoi_order :
                $this->verifyUserPermission(SectionsEnum::bon_renvoi, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::reintegration_order :
                $this->verifyUserPermission(SectionsEnum::bon_reintegration, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;

            case BillTypesEnum::commercial_bills_list :
                $this->verifyUserPermission(SectionsEnum::bon_sortie, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);

                break;

            case BillTypesEnum::special_bills_list :
                $this->verifyUserPermission(SectionsEnum::bon_sortie, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);

                break;

            case BillTypesEnum::purchase_invoices_list :
                $this->verifyUserPermission(SectionsEnum::bon_sortie, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);

                break;

            default :
                $this->verifyUserPermission(SectionsEnum::bon_sortie, $userId, ActionsEnum::delete, "Bills", null, "Bill", $type);
                break;
        }

        $this->Bill->id = $id;
        $bill= $this->Bill->getBillById($id);
        $typeBill = $bill['Bill']['type'];
        $this->verifyDependences($id, $typeBill);
        $this->request->allowMethod('post', 'delete');
        if ($this->Bill->delete()) {
            //$this->setProductQuantitySessionAlerts();
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }
    }

    function addProductBill($nbProduct = null, $type = null)
    {
        $this->layout = 'ajax';
        $products = $this->Product->getProducts();
        $this->set('i', $nbProduct);
        $tvas = $this->Tva->getTvas(null, 'list', null);
        $priceCategories = $this->PriceCategory->getPriceCategories('list');
        $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
        $this->set(compact('products', 'type', 'tvas', 'priceCategories', 'usePurchaseBill'));
    }

    function getQuantityMaxByProduct($num = null, $productId = null, $quantity = null, $typeBill = null)
    {
        $this->layout = 'ajax';
        $product = $this->Product->getProductById($productId);
        $this->set(compact('product', 'num', 'quantity', 'typeBill'));
    }

    /** modified : 29/04/2019
     * @param null $i
     * @param null $type
     * @throws Exception
     * ajout rapide de produit
     */
    function addProduct($i = null, $type=null)
    {
        $this->loadModel('ProductFamily');

        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::produit, $user_id, ActionsEnum::add, "Products",
            null, "Product", null, 1);
        $this->set('result', $result);
		$code = $this->getNextProductCode();
        $this->set('code', $code);
        $this->Product->validate = $this->Product->validate_add_product;
        $this->setTimeActif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->Product->create();

            $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
            if($usePurchaseBill ==1){
                $lotId = $this->Lot->getLastId();
                $this->request->data['Product']['id'] = $lotId + 1;
            }
            if ($this->Product->save($this->request->data)) {
                $this->Parameter->setNextProductCodeNumber();
                $this->set('saved', true); //only set true if data saves OK
                if($usePurchaseBill==1){
                    $productId = $lotId + 1;
                }else {
                    $productId = $this->Product->getLastInsertId();
                }
                $this->Lot->InsertLot($productId);
                $this->set(compact('productId','type'));
            }
        }
        $tvas = $this->Tva->getTvas(null, 'list', null);
        $productFamilies = $this->ProductFamily->getProductFamilies();
        $this->set(compact('tvas', 'productFamilies', 'i','type'));

    }

    function getProducts()
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        $products = $this->Product->getProducts();
        $this->set('selectBox', $products);
        $this->set('selectedId', $this->params['pass']['0']);
        $this->set('i', $this->params['pass']['1']);
        $type = $this->params['pass']['2'];
        $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
        $this->set(compact('usePurchaseBill','type'));

    }

    function addLot()
    {
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::produit, $userId, ActionsEnum::add, "Lots", null, "Lot", null, 1);
        $this->set('result', $result);
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('i', $this->params['pass']['1']);
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->request->data['Lot']['product_id'] = $this->params['pass']['0'];
            $this->Lot->create();
            if ($this->Lot->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $lotId = $this->Lot->getLastInsertId();
                $this->set('lotId', $lotId);
                $this->set('productId', $this->params['pass']['0']);

            }
        }
        $tvas = $this->Tva->getTvas(null, 'list', null);
        $this->set(compact('tvas'));
    }

    function getLots($productId = null, $lotId = null, $i = null)
    {
        $this->layout = 'ajax';
        if (isset($this->params['pass']['0']) || $productId != null) {
            if ($productId == null) {
                $productId = $this->params['pass']['0'];
            }
            $this->set('selectBox', $this->Lot->getLotsByProductId($productId, 'list'));
            if (isset($this->params['pass']['1']) || $lotId != null) {
                $this->set('selectedId', $this->params['pass']['1']);
            }
            if (isset($this->params['pass']['2']) || $i != null) {
                $this->set('i', $this->params['pass']['2']);
            }
        } else {
            $this->set('selectBox', null);
        }
    }


    function addOtherProduct($num = null)
    {
        $products = $this->Product->getProducts();
        $this->set(compact('num', 'products'));

    }


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

    public function updateLot()
    {
        $products = $this->Product->getProducts('all');

        foreach ($products as $product) {
            $this->Lot->InsertLot($product['Product']['id']);
        }
    }


    function getPriceLot($lotId = null, $i = null, $priceCategoryId = null)
    {
        $lot = $this->Lot->getLotById($lotId);
        $productId = $lot['Lot']['id'];
        if ($priceCategoryId == 0) {
            $product = $this->Product->getProductById($productId);
            $price['ProductPrice']['price_ht'] = $product['Product']['pmp'];
        } else {

            $conditions = array('ProductPrice.product_id' => $productId, 'ProductPrice.price_category_id' => $priceCategoryId);

            $price = $this->ProductPrice->getProductPricesByConditions($conditions, 'first');
        }


        $this->set(compact('i', 'price'));
    }

    function getLotsByProduct($productId = null, $i = null)
    {
        $this->layout = 'ajax';
        $product = $this->Product->getProductById($productId);
        $productWithLot = $product['Product']['with_lot'];
        $this->set(compact('productWithLot', 'i'));
        if ($productWithLot == 1) {
            $lots = $this->Lot->getLotsByProductId($productId, 'all');
            $this->set('lots', $lots);
        }
    }

    function getProductById(){
        $this->autoRender = false;
        $productId = filter_input(INPUT_POST, "productId");
        $product = $this->Product->getProductById($productId);
        echo json_encode(array("withSerialNumber"=>$product['Product']['with_serial_number']));


    }

    function getCurrentProductQty($productId = null, $rowNumber = null)
    {
        $this->layout = 'ajax';
        $product = $this->Product->getProductById($productId);
        $currentProductQty = $product['Product']['quantity'];
        $outStock = $product['Product']['out_stock'];
        $this->set(compact('currentProductQty', 'rowNumber','outStock'));
    }

    function getDesignationProduct($i = null , $productId = null){
        $product = $this->Product->getProductById($productId);
        $this->set(compact('product','i'));
    }

    /** created : 07/07/2019
     * @param null $i
     * @param null $productId
     * @param null $billProductId
     */
    function getDescriptionProduct($i = null , $productId = null, $billProductId= null){
        $description = '';
        if(!empty($billProductId)){
            $billProduct = $this->BillProduct->getBillProductById($billProductId);
            if(!empty($billProduct)){
                $description = $billProduct['BillProduct']['description'];
            }
        }else {
            $product = $this->Product->getProductById($productId);
            if(!empty($product)){
                $description =  $product['Product']['description'];
            }
        }

        $this->set(compact('description','i'));
    }

    function getAvoidDescription($i = null){
        $this->set(compact('i'));
    }
	
	function getTvaProduct($i = null , $productId = null, $type = null){
        $product = $this->Product->getProductById($productId);
		$tvas = $this->Tva->getTvas(null, 'list', null);
        $this->set(compact('product','i','tvas','type'));
    }
	
	
	/** created : 14/04/2019
     * Transformer des bons d'un type a un autre 
     * @param array|null $ids
     *
     * @return void
     */
    public function transformBills($ids = null)
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        /*if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }*/
        $destinationType = $this->params['pass']['1'];

        $originType = $this->params['pass']['2'];
        $this->set('originType',$originType);
        $this->Bill->validate = $this->Bill->validate_transform;
        $array_ids = explode(",", $ids);
        if (!empty($this->request->data)) {
            if ($this->request->data['method_transform'] == 2) {
                foreach ($array_ids as $id) {
                  if($originType == BillTypesEnum::purchase_request
                      || $originType == BillTypesEnum::product_request
                  ){
                      $conditions = array('Bill.id'=>$id, 'Bill.status'=>3);
                  }else {
                      $conditions = array('Bill.id'=>$id, 'Bill.status'=>1);
                  }

					$bill = $this->Bill->getBillsByConditions($conditions,'first');
                    if (!empty($bill)) {
                        $billProducts = $this->BillProduct->getBillProductsByBillId($id);
                        if($originType == BillTypesEnum::purchase_request
                            || $originType == BillTypesEnum::product_request
                        ) {
                            $billServices = $this->BillService->getBillServicesByBillId($id);
                            $selectedServiceIds= array();
                            foreach ($billServices as $billService){
                                $selectedServiceIds[]= $billService['BillService']['service_id'];
                            }
                        }else {
                            $selectedServiceIds = array();
                        }
                        // pour le bon deroulement de la fonction on etait obligé de faire un foreach 1 fois pour le tableau $data1['TransportBill']
                        $date = date("Y-m-d");
                        if ($this->request->data['date'] != 1) {
                            $date = $bill['Bill']['date'];
                        }
                        if ($this->request->data['affectation_client'] == 1) {
                            $supplierId = null;
                        } else {
                            $supplierId = $this->request->data['Bill']['supplier_id'];
                        }
                        $billIds = array();
                        $billIds[] = $id;
                        // is a transformation (may be duplication or relance)
                        $transformationCategory = 2;
                        $newBillId = $this->addBillProducts($bill,$billProducts,$destinationType, $originType, $date, $supplierId, $billIds, $transformationCategory);
                        if( $destinationType == BillTypesEnum::purchase_request||
                            $destinationType == BillTypesEnum::product_request) {
                            foreach ($selectedServiceIds as $selectedServiceId) {
                                $this->BillService->addBillService($selectedServiceId, $newBillId);
                            }
                        }
                        $actionId = ActionsEnum::transform;
                        $userId = $this->Auth->user('id');
                        switch ($originType){
                            case BillTypesEnum::supplier_order :
                                $sectionId = SectionsEnum::commande_fournisseur;
                                break;
                            case BillTypesEnum::receipt :
                                $sectionId = SectionsEnum::bon_reception;
                                break;
                            case BillTypesEnum::return_supplier :
                                $sectionId = SectionsEnum::retour_fournisseur;
                                break;
                            case BillTypesEnum::purchase_invoice :
                                $sectionId = SectionsEnum::facture_achat;
                                break;
                            case BillTypesEnum::credit_note :
                                $sectionId = SectionsEnum::avoir;
                                break;
                            case BillTypesEnum::delivery_order :
                                $sectionId = SectionsEnum::bon_livraison;
                                break;
                            case BillTypesEnum::return_customer :
                                $sectionId = SectionsEnum::retour_client;
                                break;
                            case BillTypesEnum::entry_order :
                                $sectionId = SectionsEnum::bon_entree;
                                break;
                            case BillTypesEnum::exit_order :
                                $sectionId = SectionsEnum::bon_sortie;
                                break;
                            case BillTypesEnum::renvoi_order:
                                $sectionId = SectionsEnum::bon_renvoi;
                                break;
                            case BillTypesEnum::reintegration_order :
                                $sectionId = SectionsEnum::bon_reintegration;
                                break;
                            case BillTypesEnum::product_request :
                                $sectionId = SectionsEnum::demande_produit;
                                break;
                            case BillTypesEnum::purchase_request :
                                $sectionId = SectionsEnum::demande_achat;
                                break;
                            default :
                                $sectionId = SectionsEnum::commande_fournisseur;
                                break;
                        }
                        $this->saveUserAction($sectionId, $id, $userId, $actionId);
                        if($destinationType == BillTypesEnum::purchase_request){
                            $this->redirect(array('action' => 'index', $destinationType));
                        }else {
                            $this->redirect(array('action' => 'edit', $destinationType, $newBillId));
                        }
                    } else {
                        if($originType == BillTypesEnum::purchase_request
                            || $originType == BillTypesEnum::product_request
                        ){
                            $this->Flash->error(__('The bill is already transformed or not validated.'));
                        }else {
                            $this->Flash->error(__('The bill is already transformed.'));
                        }

                        $this->redirect(array('action' => 'index', $originType));
                    }
                }
            } else {
                if($originType == BillTypesEnum::purchase_request
                    || $originType == BillTypesEnum::product_request
                ){
                    $conditions = array('Bill.id' => $array_ids,'Bill.status'=>3);
                }else {
                    $conditions = array('Bill.id' => $array_ids,'Bill.status'=>1);
                }

                $bills = $this->Bill->getBillsByConditions($conditions,'all');

                if (!empty($bills)) {
                    $data1['Bill']['total_ht'] = 0;
                    $data1['Bill']['total_ttc'] = 0;
                    $data1['Bill']['total_tva'] = 0;
                    foreach ($bills as $bill) {
                        $data1['Bill']['date'] = $bill['Bill']['date'];
                        $data1['Bill']['total_ht'] = $data1['Bill']['total_ht'] + $bill['Bill']['total_ht'];
                        $data1['Bill']['total_ttc'] = $data1['Bill']['total_ttc'] + $bill['Bill']['total_ttc'];
                        $data1['Bill']['total_tva'] = $data1['Bill']['total_tva'] + $bill['Bill']['total_tva'];
                        $data1['Bill']['supplier_id'] = $bill['Bill']['supplier_id'];
                        $data1['Bill']['customer_id'] = $bill['Bill']['customer_id'];

					}
                    $billProducts = $this->BillProduct->getBillProductsByBillId($array_ids);
                    if($originType == BillTypesEnum::purchase_request
                        || $originType == BillTypesEnum::product_request
                    ) {
                        $billServices = $this->BillService->getBillServicesByBillId($array_ids);
                        $selectedServiceIds= array();
                        foreach ($billServices as $billService){
                            $selectedServiceIds[]= $billService['BillService']['service_id'];
                        }
                    }else {
                        $selectedServiceIds = array();
                    }
                    // on recupère la date sans faire un foreach sur le tableau $data1['TransportBill']
                    if ($this->request->data['date'] == 1) {
                        $date = date("Y-m-d");
                    } else {
                        $date = $data1['Bill']['date'];
                    }
                    if (isset($this->request->data['affectation_client'])){
                        if ($this->request->data['affectation_client'] == 1) {
                            $supplierId = null;
                        } else {
                            $supplierId = $this->request->data['Bill']['supplier_id'];
                        }
                    }else{
                        $supplierId = null;
                    }
                    $billIds = $array_ids;
                    $transformationCategory = 2;
                    $newBillId = $this->addBillProducts($data1['Bill'],
                        $billProducts, $destinationType, $originType, $date, $supplierId,
                        $billIds, $transformationCategory);

                    if( $destinationType == BillTypesEnum::purchase_request||
                        $destinationType == BillTypesEnum::product_request) {
                        foreach ($selectedServiceIds as $selectedServiceId) {
                            $this->BillService->addBillService($selectedServiceId, $newBillId);
                        }
                    }

                    $actionId = ActionsEnum::transform;
                    $userId = $this->Auth->user('id');
                    switch ($originType){
                        case BillTypesEnum::supplier_order :
                            $sectionId = SectionsEnum::commande_fournisseur;
                            break;
                        case BillTypesEnum::receipt :
                            $sectionId = SectionsEnum::bon_reception;
                            break;
                        case BillTypesEnum::return_supplier :
                            $sectionId = SectionsEnum::retour_fournisseur;
                            break;
                        case BillTypesEnum::purchase_invoice :
                            $sectionId = SectionsEnum::facture_achat;
                            break;
                        case BillTypesEnum::credit_note :
                            $sectionId = SectionsEnum::avoir;
                            break;
                        case BillTypesEnum::delivery_order :
                            $sectionId = SectionsEnum::bon_livraison;
                            break;
                        case BillTypesEnum::return_customer :
                            $sectionId = SectionsEnum::retour_client;
                            break;
                        case BillTypesEnum::entry_order :
                            $sectionId = SectionsEnum::bon_entree;
                            break;
                        case BillTypesEnum::exit_order :
                            $sectionId = SectionsEnum::bon_sortie;
                            break;
                        case BillTypesEnum::renvoi_order:
                            $sectionId = SectionsEnum::bon_renvoi;
                            break;
                        case BillTypesEnum::reintegration_order :
                            $sectionId = SectionsEnum::bon_reintegration;
                            break;
                        case BillTypesEnum::product_request :
                            $sectionId = SectionsEnum::demande_produit;
                            break;
                        case BillTypesEnum::purchase_request :
                            $sectionId = SectionsEnum::demande_achat;
                            break;
                        default :
                            $sectionId = SectionsEnum::commande_fournisseur;
                            break;
                    }
                    foreach ($billIds as $billId){
                        $this->saveUserAction($sectionId, $billId, $userId, $actionId);
                    }


                    if($destinationType == BillTypesEnum::purchase_request){
                        $this->redirect(array('action' => 'index', $destinationType));
                    }else {
                        $this->redirect(array('action' => 'edit', $destinationType, $newBillId));
                    }
                    


                } else {
                    if($originType == BillTypesEnum::purchase_request
                        || $originType == BillTypesEnum::product_request
                    ){
                        $this->Flash->error(__('The bill is already transformed or not validated.'));
                    }else {
                        $this->Flash->error(__('The bill is already transformed.'));
                    }

                    $this->redirect(array('action' => 'index', $originType));
                }
            }
        }

        switch ($destinationType) {
            case BillTypesEnum::supplier_order :
            case BillTypesEnum::purchase_request :
            case BillTypesEnum::receipt :
            case BillTypesEnum::return_supplier :
            case BillTypesEnum::purchase_invoice :
            case BillTypesEnum::credit_note :
                $suppliers = $this->Supplier->getSuppliersByParams(0, 1);
                break;

            case BillTypesEnum::delivery_order :
            case BillTypesEnum::return_customer :
            case BillTypesEnum::quote :
            case BillTypesEnum::customer_order :
            case BillTypesEnum::sales_invoice :
            case BillTypesEnum::sale_credit_note :
                $suppliers = $this->Supplier->getSuppliersByParams(1, 1, null, 2);
                break;

            case BillTypesEnum::entry_order :
            case BillTypesEnum::renvoi_order :
                $suppliers = $this->Supplier->getSuppliersByParams(0, 1, null, null, null, null, null, array(2, 3));
                break;

            case BillTypesEnum::exit_order :
            case BillTypesEnum::reintegration_order :
                $suppliers = $this->Supplier->getSuppliersByParams(1, 1, null, array(2, 3), null, null, null, array(2, 3));
                break;

            case BillTypesEnum::product_request :
            case BillTypesEnum::purchase_request :
                $services = $this->Service->getServices('list');
                break;
        }

        $this->set(compact('suppliers', 'array_ids'));
    }

    /** created : 14/04/2019
     * @param null $bill
     * @param null $billProducts
     * @param null $newType
     * @param null $originType
     * @param null $date
     * @param null $supplier
     * @param null $billIds
     * @param null $transformationCategory
     * @return mixed|null
     * @throws Exception
     */
	
    function addBillProducts(
        $bill = null,
        $billProducts = null,
        $newType = null,
        $originType = null,
        $date = null,
        $supplier = null,
        $billIds = null,
        $transformationCategory = null
    )
    {

        $products = array();
        $i = 0;
       
       

            foreach ($billProducts as $billProduct) {
                
              
                if (isset($billProduct['BillProduct']['lot_id'])) {
                    $products[$i]['lot_id'] = $billProduct['BillProduct']['lot_id'];
                   
                }
                if (isset($billProduct['BillProduct']['designation'])) {
                    $products[$i]['designation'] = $billProduct['BillProduct']['designation'];
                }
                if (isset($billProduct['BillProduct']['description'])) {
                    $products[$i]['description'] = $billProduct['BillProduct']['description'];
                }

                $products[$i]['quantity'] = $billProduct['BillProduct']['quantity'];
                $products[$i]['unit_price'] = $billProduct['BillProduct']['unit_price'];
               
                $products[$i]['price_ht'] = $billProduct['BillProduct']['price_ht'];
                $products[$i]['tva_id'] = $billProduct['BillProduct']['tva_id'];
                $products[$i]['price_ttc'] = $billProduct['BillProduct']['price_ttc'];
                $products[$i]['ristourne_%'] = $billProduct['BillProduct']['ristourne_%'];
                $products[$i]['ristourne_val'] = $billProduct['BillProduct']['ristourne_val'];
               
                $i++;
            }
       
        $this->Bill->create();
        $reference = $this->getNextBillReference($newType);
		
        if ($reference != '0') {
            $data['Bill']['reference'] = $reference;
        }
        $data['Bill']['date'] = $date;
        
            $data['Bill']['total_ht'] = $bill['total_ht'];
            $data['Bill']['total_ttc'] = $bill['total_ttc'];
            $data['Bill']['amount_remaining'] = $bill['total_ttc'];
            $data['Bill']['total_tva'] = $bill['total_tva'];


        if ($supplier == null) {
            $data['Bill']['supplier_id'] = $bill['supplier_id'];
        } else {
            $data['Bill']['supplier_id'] = $supplier;
        }
        $data['Bill']['customer_id'] = $bill['customer_id'];
        $data['Bill']['type'] = $newType;
        $data['Bill']['user_id'] = $this->Session->read('Auth.User.id');
        if ($this->Bill->save($data)) {
            $this->Parameter->setNextBillReferenceNumber($newType);
            $id = $this->Bill->getInsertID();
            /*
             1:relance;
             2:transformation;
             3:duplication;
             4:Duplication et relance;
             */
            if (!empty($billIds)) {
                foreach ($billIds as $billId) {
                    $this->Transformation->create();
                    $data['Transformation']['origin_transport_bill_id'] = $billId;
                    $data['Transformation']['new_transport_bill_id'] = $id;
                    $data['Transformation']['origin_type'] = $originType;
                    $data['Transformation']['new_type'] = $newType;
                    $data['Transformation']['category'] = $transformationCategory;
                    $data['Transformation']['date'] = Date('Y-m-d');
                    $this->Transformation->save($data);
					$this->Bill->updateStatusBill($billId);
                }
            }
			foreach($products as $product){
				$save = $this->BillProduct->addBillProduct($product, $id , $product['lot_id']);

			 if($save == false ){
                $this->Bill->deleteAll(array('Bill.id' => $id),
                    false);
                $this->Flash->error(__('The bill could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index', $newType));
            }else {

                 $quantity = $product['quantity'];
                 $lotId = $product['lot_id'];
                 $productId = $product['lot_id'];
                 switch ($newType) {
                     case BillTypesEnum::receipt :
                     case BillTypesEnum::delivery_order :
                     case BillTypesEnum::return_customer :
                     case BillTypesEnum::return_supplier :
                         $this->Lot->updateQuantityLot($lotId, $quantity, $newType);
                         $this->Product->updateQuantityProduct($productId, $quantity, $newType);
                         break;

                     case BillTypesEnum::entry_order :
                     case BillTypesEnum::exit_order :
                     case BillTypesEnum::renvoi_order :
                     case BillTypesEnum::reintegration_order :
                         $this->Lot->updateQuantityLot($lotId, $quantity, $newType);
                         $this->Product->updateQuantityProduct($productId, $quantity, $newType);
                         break;

                 }
             }
			}
            
            $this->Flash->success(__('The bill has been transformed'));
                
            return $id;
        } else {
            $this->Flash->error(__('The bill could not be saved. Please, try again.'));
            return null;
        }

    }

    /**
     * @param null $productId
     * @param null $i
     * @param null $billProductId
     */

   public function editDescription($productId = null, $i = null , $billProductId =null )
    {
        $this->set('saved', false);
        if(!empty($billProductId)){
            $billProduct = $this->BillProduct->getBillProductById($billProductId);
            if(!empty($billProduct)){
                $description = $billProduct['BillProduct']['description'];
                if(empty($description)){
                    $product = $this->Product->getProductById($productId);
                    if(!empty($product)){
                        $description = $product['Product']['description'];
                    }
                }
            }

        }else {
            $product = $this->Product->getProductById($productId);
            if(!empty($product)){
                $description = $product['Product']['description'];
            }
        }

        $this->set(compact('product', 'i','productId','description'));
    }

    public function saveDescription (){
        $this->autoRender = false;
       // $description = filter_input(INPUT_POST, "description");
        $description = json_decode($_POST['description']);
        $productId = json_decode($_POST['productId']);
        $this->Product->id =  $productId ;
        $this->Product->saveField('description2',$description);
		
        if (isset($description) && ($this->Product->saveField('description2',$description))) {
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


    public function liste($type = null, $id = null, $keyword = null)
    {

        $keyword = str_replace('espace', ' ', $keyword);
        $keyword = str_replace('slash', '/', $keyword);
        $keyword = str_replace('tiret', '-', $keyword);
        $keyword = str_replace('bouton_num', '°', $keyword);
        $keyword = strtolower($keyword);

        $this->layout = 'ajax';
        $limit = $this->getLimit();
        $order =  $this->getOrder();

        $this->set('order',$order);
        switch ($type){
            case BillTypesEnum::sale_invoices_list :
                $type = array(BillTypesEnum::sales_invoice, BillTypesEnum::sale_credit_note);
                break;

                case BillTypesEnum::purchase_invoices_list :
                $type = array(BillTypesEnum::purchase_invoice, BillTypesEnum::credit_note);
                break;

            case BillTypesEnum::commercial_bills_list :
                $type = array(BillTypesEnum::receipt, BillTypesEnum::delivery_order);
                break;

            case BillTypesEnum::special_bills_list :
                $type = array(BillTypesEnum::entry_order, BillTypesEnum::exit_order);
                break;
        }
        switch ($id) {
            case 2 :
                $conditions = array("LOWER(Bill.reference) LIKE" => "%$keyword%" , 'Bill.type'=>$type);

                break;
            case 3 :
                if(!empty($keyword)){
                    $keyword = str_replace("/", "-", $keyword);
                    $start = str_replace("-", "/", $keyword);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $conditions = array("Bill.date >=" => $startdtm->format('Y-m-d'), 'Bill.type'=>$type);
                } else {
                    $conditions = array('Bill.type'=>$type);
                }

                break;
            case 4 :
                $conditions = array("LOWER(Bill.type) LIKE" => "%$keyword%", 'Bill.type'=>$type);
                break;

            case 5 :
                $conditions = array("LOWER(Supplier.name) LIKE" => "%$keyword%", 'Bill.type'=>$type);

                break;

            case 6 :
                $keyword = str_replace(" ", "", $keyword);
                $keywordExploded = explode(",", $keyword);
                if(!empty($keywordExploded[0])){
                    $keyword =  $keywordExploded[0];
                }
                $conditions = array("LOWER(Bill.total_ht) LIKE" => "%$keyword%", 'Bill.type'=>$type);
                break;

            case 7 :
                $keyword = str_replace(" ", "", $keyword);
                $keywordExploded = explode(",", $keyword);
                if(!empty($keywordExploded[0])){
                    $keyword =  $keywordExploded[0];
                }
                $conditions = array("LOWER(Bill.ristourne_val) LIKE" => "%$keyword%", 'Bill.type'=>$type);
                break;
            case 8 :
                $keyword = str_replace(" ", "", $keyword);
                $keywordExploded = explode(",", $keyword);
                if(!empty($keywordExploded[0])){
                    $keyword =  $keywordExploded[0];
                }
                $conditions = array("LOWER(Bill.total_tva) LIKE" => "%$keyword%", 'Bill.type'=>$type);
                break;

            case 9 :
                $keyword = str_replace(" ", "", $keyword);
                $keywordExploded = explode(",", $keyword);
                if(!empty($keywordExploded[0])){
                    $keyword =  $keywordExploded[0];
                }
                $conditions = array("LOWER(Bill.total_ttc) LIKE" => "%$keyword%", 'Bill.type'=>$type);
                break;

            case 10 :
                $keyword = str_replace(" ", "", $keyword);
                $keywordExploded = explode(",", $keyword);
                if(!empty($keywordExploded[0])){
                    $keyword =  $keywordExploded[0];
                }
                $conditions = array("LOWER(Bill.amount_remaining) LIKE" => "%$keyword%", 'Bill.type'=>$type);
                break;

            default:
                $conditions = array("LOWER(Bill.reference) LIKE" => "%$keyword%", 'Bill.type'=>$type);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => $order,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'recursive' => -1,
            'fields' => array('Supplier.name', 'Car.code', 'Car.immatr_def', 'Carmodel.name',
                'Bill.supplier_id', 'Bill.amount_remaining',
                'Bill.event_id', 'Bill.id', 'Bill.type', 'EventType.name', 'Bill.reference',
                'Bill.date', 'Bill.total_ht', 'Bill.total_ttc', 'Bill.total_tva',
                'Bill.stamp','Bill.ristourne_val'),
            'joins' => array(
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Bill.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Event',
                    'conditions' => array('Bill.event_id = Event.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Event.car_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
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
                )

            )
        );

        $bills = $this->Paginator->paginate();

        $separatorAmount = $this->getSeparatorAmount();

        $this->set(compact('separatorAmount', 'bills'));


    }

    function export()
    {

        $this->settimeactif();

        if (isset($this->params['pass']['0']) && $this->params['pass']['0'] == "all_search" &&
            isset($this->params['named']['keyword']) || isset($this->params['named']['type']) || isset($this->params['named']['user'])
            || isset($this->params['named']['created'])|| isset($this->params['named']['reglement'])
            || isset($this->params['named']['created1']) || isset($this->params['named']['ride'])
            || isset($this->params['named']['category']) || isset($this->params['named']['supplier'])
            || isset($this->params['named']['type']) || isset($this->params['named']['client'])|| isset($this->params['named']['product'])
            || isset($this->params['named']['modified']) || isset($this->params['named']['modified1'])
            || isset($this->params['named']['date1']) || isset($this->params['named']['date2'])
        ) {


            $conditions = $this->getConds();
            $bills = $this->Bill->find('all', array(
                'conditions' => $conditions,
                'Group' => 'Bill.id',

                'order' => 'Bill.id asc',
                'recursive' => -1,
                'fields' => array('Supplier.name', 'Car.code', 'Car.immatr_def', 'Carmodel.name',
                    'Bill.supplier_id', 'Bill.amount_remaining',
                    'Bill.event_id', 'Bill.id', 'Bill.type', 'EventType.name', 'Bill.reference',
                    'Bill.date', 'Bill.total_ht', 'Bill.total_ttc', 'Bill.total_tva',
                    'Bill.stamp','Bill.ristourne_val'),
                'joins' => array(
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('Bill.supplier_id = Supplier.id')
                    ),
                    array(
                        'table' => 'event',
                        'type' => 'left',
                        'alias' => 'Event',
                        'conditions' => array('Bill.event_id = Event.id')
                    ),
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('Event.car_id = Car.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),
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
                    )

                )
            ));


        } else {

            if (isset($this->params['pass']['0']) && $this->params['pass']['0'] == "all") {

                $type = $this->params['pass']['1'];
                switch ($type){
                    case BillTypesEnum::sale_invoices_list :
                        $type = array(BillTypesEnum::sales_invoice, BillTypesEnum::sale_credit_note);
                        break;
                    case BillTypesEnum::purchase_invoices_list :
                        $type = array(BillTypesEnum::purchase_invoice, BillTypesEnum::credit_note);
                        break;

                    case BillTypesEnum::commercial_bills_list :
                        $type = array(BillTypesEnum::receipt, BillTypesEnum::delivery_order);
                        break;

                    case BillTypesEnum::special_bills_list :
                        $type = array(BillTypesEnum::entry_order, BillTypesEnum::exit_order);
                        break;
                }
                $bills = $this->Bill->find('all', array(
                    'order' => 'Bill.id asc',
                    'recursive' => -1,
                    'conditions'=>array('Bill.type'=>$type),
                    'Group' => 'Bill.id',
                    'fields' => array('Supplier.name', 'Car.code', 'Car.immatr_def', 'Carmodel.name',
                        'Bill.supplier_id', 'Bill.amount_remaining',
                        'Bill.event_id', 'Bill.id', 'Bill.type', 'EventType.name', 'Bill.reference',
                        'Bill.date', 'Bill.total_ht', 'Bill.total_ttc', 'Bill.total_tva',
                        'Bill.stamp','Bill.ristourne_val'),
                    'joins' => array(
                        array(
                            'table' => 'suppliers',
                            'type' => 'left',
                            'alias' => 'Supplier',
                            'conditions' => array('Bill.supplier_id = Supplier.id')
                        ),
                        array(
                            'table' => 'event',
                            'type' => 'left',
                            'alias' => 'Event',
                            'conditions' => array('Bill.event_id = Event.id')
                        ),
                        array(
                            'table' => 'car',
                            'type' => 'left',
                            'alias' => 'Car',
                            'conditions' => array('Event.car_id = Car.id')
                        ),
                        array(
                            'table' => 'carmodels',
                            'type' => 'left',
                            'alias' => 'Carmodel',
                            'conditions' => array('Car.carmodel_id = Carmodel.id')
                        ),
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
                        )
                    )
                ));

            } else {
                $ids = filter_input(INPUT_POST, "chkids");
                $type = filter_input(INPUT_POST, "type");
                switch ($type){
                    case BillTypesEnum::sale_invoices_list :
                        $type = array(BillTypesEnum::sales_invoice, BillTypesEnum::sale_credit_note);
                        break;

                    case BillTypesEnum::commercial_bills_list :
                        $type = array(BillTypesEnum::receipt, BillTypesEnum::delivery_order);
                        break;

                    case BillTypesEnum::special_bills_list :
                        $type = array(BillTypesEnum::entry_order, BillTypesEnum::exit_order);
                        break;
                }
                $array_ids = explode(",", $ids);
                $bills = $this->Bill->find('all', array(
                    'conditions' => array(
                        "Bill.id" => $array_ids,
                        "Bill.type" => $type,
                    ),
                    'Group' => 'Bill.id',

                    'order' => 'Bill.id asc',
                    'recursive' => -1,
                    'fields' => array('Supplier.name', 'Car.code', 'Car.immatr_def', 'Carmodel.name',
                        'Bill.supplier_id', 'Bill.amount_remaining',
                        'Bill.event_id', 'Bill.id', 'Bill.type', 'EventType.name', 'Bill.reference',
                        'Bill.date', 'Bill.total_ht', 'Bill.total_ttc', 'Bill.total_tva',
                        'Bill.stamp','Bill.ristourne_val'),
                    'joins' => array(
                        array(
                            'table' => 'suppliers',
                            'type' => 'left',
                            'alias' => 'Supplier',
                            'conditions' => array('Bill.supplier_id = Supplier.id')
                        ),
                        array(
                            'table' => 'event',
                            'type' => 'left',
                            'alias' => 'Event',
                            'conditions' => array('Bill.event_id = Event.id')
                        ),
                        array(
                            'table' => 'car',
                            'type' => 'left',
                            'alias' => 'Car',
                            'conditions' => array('Event.car_id = Car.id')
                        ),
                        array(
                            'table' => 'carmodels',
                            'type' => 'left',
                            'alias' => 'Carmodel',
                            'conditions' => array('Car.carmodel_id = Carmodel.id')
                        ),
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
                        )
                    )
                ));
            }
        }
        $carNameStructure = $this->Parameter->getCodesParameterVal('name_car');
        $this->set('carNameStructure',$carNameStructure);
        $this->set('models', $bills);
    }




    /**
     * fonction pour valider les bons non validées ()
     */
    public function validateBills()
    {
        $ids = filter_input(INPUT_POST, "chkids");
        $type = filter_input(INPUT_POST, "type");
        $arrayIds = explode(",", $ids);
        /*recuperer toutes les commandes qui ont été tchecked et avec le statut non transmis  */
        $status = TransportBillDetailRideStatusesEnum::validated;


                $bills = $this->Bill->find('all',
                    array(
                        'recursive' => -1,
                        'conditions' => array(
                            'Bill.status' => TransportBillDetailRideStatusesEnum::not_validated,
                            'Bill.id' => $arrayIds
                        ),
                        'fields' => array('Bill.id', 'Bill.status', 'Bill.user_id')
                    ));

                if (!empty($bills)) {
                    foreach ($bills as $bill) {
                        $this->Bill->id = $bill['Bill']['id'];
                        $this->Bill->saveField('status', $status);
                        if($type == BillTypesEnum::purchase_request){
                            $actionId = ActionsEnum::validate;
                            $sectionId = SectionsEnum::validation_demande_achat;
                        }else {
                            $actionId = ActionsEnum::validate;
                            $sectionId = SectionsEnum::validation_demande_produit;
                        }

                        $userId = $this->Auth->user('id');
                        $billId = $bill['Bill']['id'];

                            $this->Notification->addNotification($billId,$userId, $actionId,$sectionId,'Bill');
                            $this->getNbNotificationsByUser();
                        switch ($type){
                            case BillTypesEnum::supplier_order :
                                $sectionId = SectionsEnum::commande_fournisseur;
                                break;
                            case BillTypesEnum::receipt :
                                $sectionId = SectionsEnum::bon_reception;
                                break;
                            case BillTypesEnum::return_supplier :
                                $sectionId = SectionsEnum::retour_fournisseur;
                                break;
                            case BillTypesEnum::purchase_invoice :
                                $sectionId = SectionsEnum::facture_achat;
                                break;
                            case BillTypesEnum::credit_note :
                                $sectionId = SectionsEnum::avoir;
                                break;
                            case BillTypesEnum::delivery_order :
                                $sectionId = SectionsEnum::bon_livraison;
                                break;
                            case BillTypesEnum::return_customer :
                                $sectionId = SectionsEnum::retour_client;
                                break;
                            case BillTypesEnum::entry_order :
                                $sectionId = SectionsEnum::bon_entree;
                                break;
                            case BillTypesEnum::exit_order :
                                $sectionId = SectionsEnum::bon_sortie;
                                break;
                            case BillTypesEnum::renvoi_order:
                                $sectionId = SectionsEnum::bon_renvoi;
                                break;
                            case BillTypesEnum::reintegration_order :
                                $sectionId = SectionsEnum::bon_reintegration;
                                break;
                            case BillTypesEnum::product_request :
                                $sectionId = SectionsEnum::demande_produit;
                                break;
                            case BillTypesEnum::purchase_request :
                                $sectionId = SectionsEnum::demande_achat;
                                break;
                            default :
                                $sectionId = SectionsEnum::commande_fournisseur;
                                break;
                        }
                        $this->saveUserAction($sectionId, $billId, $userId, $actionId);

                    }
                }

        $this->redirect(array('action' => 'index', $type));
    }


    /**
     * @param $productQuantity
     * @param $lineNumber
     * @param $isComposedProduct
     * @param $serialNumbers
     * @param $serialNumberIds
     * @param $serialNumberLabels
     * @param $snExpirationDates
     */
    public function ajaxAddSerialNumbers(
        $productQuantity,
        $lineNumber,
        $serialNumbers = null,
        $serialNumberIds = null,
        $serialNumberLabels = null,
        $snExpirationDates = null
    ) {
        if (!empty($serialNumbers) && ($serialNumbers != 'null')) {
            $serialNumbers = explode(",", $serialNumbers);
        } else {
            $serialNumbers = array();
        }
        if (!empty($serialNumberIds) && ($serialNumberIds != 'null')) {
            $serialNumberIds = explode(",", $serialNumberIds);
        } else {
            $serialNumberIds = array();
        }
        if (!empty($serialNumberLabels) && ($serialNumberLabels != 'null')) {
            $serialNumberLabels = explode(",", $serialNumberLabels);
        } else {
            $serialNumberLabels = array();
        }

        if (!empty($snExpirationDates) && ($snExpirationDates != 'null')) {
            $expirationDates = explode(",", $snExpirationDates);

        } else {
            $expirationDates = array();
        }
        $this->set(compact(
            'productQuantity',
            'lineNumber',
            'serialNumbers',
            'serialNumberIds',
            'serialNumberLabels',
            'expirationDates'
        ));
    }

    public function ajaxEditSerialNumbers(
        $productQuantity,
        $lineNumber,
        $billProductId,
        $newSerialNumbers  = null,
        $serialNumberIds  = null,
        $newSerialNumberLabels  = null,
        $snExpirationDates = null
    ) {
        $this->loadModel('BillProductSerialNumber');
        $serialNumbers = $this->BillProductSerialNumber->getSerialNumbersByBillProductId($billProductId);
        if (!empty($newSerialNumbers) && ($newSerialNumbers != 'null')) {
            $newSerialNumbers = explode(",", $newSerialNumbers);
        } else {
            $newSerialNumbers = array();
        }
        if (!empty($newSerialNumberLabels) && ($newSerialNumberLabels != 'null')) {
            $newSerialNumberLabels = explode(",", $newSerialNumberLabels);
        } else {
            $newSerialNumberLabels = array();
        }
        if (!empty($serialNumberIds) && ($serialNumberIds != 'null')) {
            $serialNumberIds = explode(",", $serialNumberIds);
        } else {
            $serialNumberIds = array();
        }
        if (!empty($snExpirationDates) && ($snExpirationDates != 'null')) {
            $newExpirationDates = explode(",", $snExpirationDates);

        } else {
            $newExpirationDates = array();
        }
        $this->set(compact(
            'productQuantity',
            'lineNumber',
            'serialNumbers',
            'newSerialNumbers',
            'newSerialNumberLabels',
            'serialNumberIds','newExpirationDates'
        ));
    }

    public function loadSerialNumberInputs(
        $lineNumber,
        $serialNumbers = null,
        $serialNumberIds  = null,
        $serialNumberLabels = null,
        $snExpirationDates = null
    ) {
        if (!empty($serialNumbers) && ($serialNumbers != 'null')) {
            $serialNumbers = explode(",", $serialNumbers);
        } else {
            $serialNumbers = array();
        }
        //var_dump($serialNumbers);
        if (!empty($serialNumberIds) && ($serialNumberIds != 'null')) {
            $serialNumberIds = explode(",", $serialNumberIds);
        } else {
            $serialNumberIds = array();
        }

        if (!empty($serialNumberLabels) && ($serialNumberLabels != 'null')) {
            $labels = explode(",", $serialNumberLabels);
        } else {
            $labels = array();
        }
        if (!empty($snExpirationDates) && ($snExpirationDates != 'null')) {
            $expirationDates = explode(",", $snExpirationDates);

        } else {
            $expirationDates = array();
        }
        $this->set(compact("serialNumbers", 'lineNumber', 'serialNumberIds', 'labels','expirationDates'));
    }


    public function checkIfSerialNumberIsDeliveredToSupplierAjax()
    {
        $serialNumberId = filter_input(INPUT_GET, "serialNumberId");
        $thirdPartyId = filter_input(INPUT_GET, "thirdPartyId");
        $conditions = array(
            'BillProductsSerialNumbers.serial_number_id' => $serialNumberId,
            'Bills.supplier_id' => $thirdPartyId
        );
        $bill  = $this->Bill->getBillByConditions($conditions);
        if (!empty($bill)) {

            $billDate = $bill['Bill']['date'];
            $json_data = array('billDate' => $billDate, "response" => "true");
        } else {
            $json_data = array("response" => "false");
        }
        echo json_encode($json_data);

        exit;
    }

    public function checkProductGuaranteeAjax()
    {
        $productId = filter_input(INPUT_GET, "productId");
        $bill = $this->Bill->getLastDeliveryNoteByProduct($productId);

        if (!empty($bill)) {

            $billDate = $bill['Bill']['date'];
            $json_data = array('billDate' => $billDate, "response" => "true");
        } else {
            $json_data = array("response" => "false");
        }
        echo json_encode($json_data);

        exit;
    }











}