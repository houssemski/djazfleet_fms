<?php

App::uses('AppController', 'Controller');

App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'HTML2PDF');
App::uses('CakeTime', 'Utility');
App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'autoload.inc.php'));
use Dompdf\Dompdf;

/**
 * Slips Controller
 *
 * @property Slip $Slip
 * @property SupplierContact $SupplierContact
 * @property Company $Company
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class SlipsController extends AppController {
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session','Security', 'RequestHandler');
    var $helpers = array('Xls');
    public $uses = array(
        'Slip',
        'Parameter',
        'Company',
        'SupplierContact'
    );
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $userId=$this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::bordereau, $userId,
            ActionsEnum::view, "Slips", null, "Slip" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                $conditions=array('Slip.user_id '=>$userId);
                break;
            case 3 :
                $conditions=array('Slip.user_id !='=>$userId);
                break;

            default:
                $conditions=null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Slip.reference' => 'DESC'),
            'conditions'=>$conditions,
            'recursive'=>-1,
            'fields'=>array(
                'Slip.reference',
                'Slip.date_slip',
                'Supplier.name',
                'Slip.id',
                'User.first_name',
                'User.last_name',
            ),
            'joins'=>array(
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Supplier.id = Slip.supplier_id')
                ),
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'User',
                    'conditions' => array('User.id = Slip.user_id')
                ),
            ),
            'paramType' => 'querystring'
        );
        //Parametrer la pagination

        $slips = $this->Paginator->paginate();

        $this->set('slips', $slips);
        $this->set(compact('limit'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function search() {
        $this->setTimeActif();
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'],
                $this->request->params['action'], $this->request->data['keyword']);
        }

        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $conditions = array(
                'OR' => array(
                    "LOWER(Slip.reference) LIKE" => "%$keyword%",
                    "LOWER(Supplier.name) LIKE" => "%$keyword%"));
            $this->paginate = array(
                'limit' => $limit,
                'order' => array('Slip.date_slip' => 'DESC'),
                'conditions'=>$conditions,
                'recursive'=>-1,
                'fields'=>array(
                    'Slip.reference',
                    'Slip.date_slip',
                    'Supplier.name',
                    'Slip.id',
                    'User.first_name',
                    'User.last_name',
                ),
                'joins'=>array(
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('Supplier.id = Slip.supplier_id')
                    ),
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('User.id = Slip.user_id')
                    ),
                ),
                'paramType' => 'querystring'
            );
            //Parametrer la pagination

            $slips = $this->Paginator->paginate();

            $this->set('slips', $slips);

        } else {
            $this->paginate = array(
                'limit' => $limit,
                'order' => array('Slip.date_slip' => 'DESC'),
                'recursive'=>-1,
                'fields'=>array(
                    'Slip.reference',
                    'Slip.date_slip',
                    'Supplier.name',
                    'Slip.id',
                    'User.first_name',
                    'User.last_name',
                ),
                'joins'=>array(
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('Supplier.id = Slip.supplier_id')
                    ),
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('User.id = Slip.user_id')
                    ),
                ),
                'paramType' => 'querystring'
            );
            //Parametrer la pagination

            $slips = $this->Paginator->paginate();

            $this->set('slips', $slips);
        }
        $this->set(compact('limit'));
        $this->render();
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->setTimeActif();
        if (!$this->Slip->exists($id)) {
            throw new NotFoundException(__('Invalid slip.'));
        }
        $missions = $this->SheetRideDetailRides->getSheetRideDetailRidesBySlipId($id);
        $options = array('conditions' => array('Slip.' . $this->Slip->primaryKey => $id));
        $slip = $this->Slip->find('first', $options);
        $this->set(compact('slip','missions'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::bordereau, $user_id,
            ActionsEnum::add, "Slips", null, "Slip" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Slip->create();
            $this->createDateFromDate('Slip', 'date_slip');
            $this->request->data['Slip']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Slip->save($this->request->data)) {
                $this->Flash->success(__('The slip has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The slip could not be saved. Please, try again.'));
            }
        }
        $this->loadModel('Supplier');
        $suppliers = $this->Supplier->getSuppliersByParams(1);
        $this->set(compact('suppliers'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::bordereau, $user_id, ActionsEnum::edit,
            "Slips", $id, "Slip" ,null);
        if (!$this->Slip->exists($id)) {
            throw new NotFoundException(__('Invalid slip'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Slip cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->createDateFromDate('Slip', 'date_slip');
            $this->request->data['Slip']['modified_id'] = $this->Session->read('Auth.User.id');
            if ($this->Slip->save($this->request->data)) {

                $this->Flash->success(__('The slip has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The slip could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Slip.' . $this->Slip->primaryKey => $id));
            $this->request->data = $this->Slip->find('first', $options);

        }
        $this->loadModel('Supplier');
        $suppliers = $this->Supplier->getSuppliersByParams(1);


        $this->set(compact('suppliers'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::bordereau, $user_id, ActionsEnum::delete,
            "Slips", $id, "Slip" ,null);
        $this->Slip->id = $id;
        if (!$this->Slip->exists()) {
            throw new NotFoundException(__('Invalid slip'));
        }
        //$this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Slip->delete()) {

            $this->Flash->success(__('The slip has been deleted.'));
        } else {

            $this->Flash->error(__('The slip could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteSlips() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::bordereau, $user_id, ActionsEnum::delete,
            "Slips", $id, "Slip" ,null);
        $this->Slip->id = $id;
        //$this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->Slip->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }
        /*}else{
            echo json_encode(array("response" => "false"));
        }*/
    }
    private function verifyDependences($id){
        $this->setTimeActif();
        $this->loadModel('Slip');
        $result = $this->Slip->getCustomerByForeignKey($id, 'complaint_cause_id');
        if (!empty($result)) {
            $this->Flash->error(__('The complaint cause could not be deleted. '
                . 'Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }

    public function generateDispatchSlip() {
        $ids = filter_input(INPUT_POST, "chkids");
        $supplierId = filter_input(INPUT_POST, "supplier_id");
        $sheetRideDetailRideIds = explode(",", $ids);
        $reference = $this->getNextTransportReference( TransportBillTypesEnum::dispatch_slip);
           
        $userId = $this->Auth->user('id');
        $slipId = $this->Slip->addSlip($reference,$supplierId,$userId);
        if(!empty($slipId)){
            $this->SheetRideDetailRides->updateSlipIdField($sheetRideDetailRideIds, $slipId);
            $this->Parameter->setNextTransportReferenceNumber(TransportBillTypesEnum::dispatch_slip);
        }
        $this->Flash->success(__('The slip has been saved.'));
        $this->redirect(array('action' => 'index'));
    }

    public function printSlip($id){
        $slip = $this->Slip->getSlipById($id);
        $missions = $this->SheetRideDetailRides->getSheetRideDetailRidesBySlipId($id);
        $company = $this->Company->find('first');
        $entete_pdf = $this->Parameter->getCodesParameterVal('entete_pdf');
        $this->set(compact('slip','missions','company','entete_pdf'));


    }


    public function sendMail( $id = null)
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        $supplierContacts = $this->SupplierContact->find('all',
            array(
                'conditions' => array(
                    'Slip.id' => $id,
                    'SupplierContact.email1 != '=>''
                ),
                'recursive' => -1,
                'fields' => array(
                    'SupplierContact.email1',
                    'Slip.reference',
                ),
                'joins' => array(
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('SupplierContact.supplier_id = Supplier.id')
                    ),
                    array(
                        'table' => 'slips',
                        'type' => 'left',
                        'alias' => 'Slip',
                        'conditions' => array('Slip.supplier_id = Supplier.id')
                    ),
                )
            ));

        if (!empty($supplierContacts)) {
            foreach ($supplierContacts as $supplierContact) {

                if(!empty($supplierContact['SupplierContact']['email1'])){}

                        $name = 'bordereau' . '_' . $supplierContact['Slip']['reference'] . '.pdf';


                $name = str_replace('/', '-', $name);

                    $this->piecePdf( $id);

                $Email = new CakeEmail('smtp');
                $Email->addTo($supplierContact['SupplierContact']['email1']);

                        $subject = __('Dispatch slip');

                $msg = __("Please find attached copy of your ") . $subject . __(' ') . __('number ') . $supplierContact['Slip']['reference'];
                $Email->template('welcome', 'default')
                    ->emailFormat('html')
                    ->from('k.ouabou@intellixweb.com')
                    ->subject($subject)
                    ->attachments(array('./document_transport/' . $name));
                try {
                    if ($Email->send($msg)) {
                        $this->Flash->success(__('Your Email has been sent.'));

                            $this->redirect(array('action' => 'index'));

                    } else {
                        $this->Flash->error(__('Your Email has not been sent. Try again.'));
                        $this->redirect(array('action' => 'index'));
                    }
                } catch (Exception $ex) {
                    $this->redirect(array('action' => 'index'));
                }
            }
        } else {
            $this->Flash->error(__('The email customer is empty'));

            $this->redirect(array('action' => 'index'));

        }

    }


    function piecePdf( $id = null)
    {
        $slip = $this->Slip->getSlipById($id);
        $missions = $this->SheetRideDetailRides->getSheetRideDetailRidesBySlipId($id);
        $company = $this->Company->find('first');






ob_start(); ?>



  <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <style type="text/css">

            @page {
                margin: 10px 25px 75px 25px;
            }
            .copyright{font-size:10px; text-align:center;}
            .title{
                font-weight: bold;
                font-size: 18px;
                text-align: center;
                padding-top: 5px;
                width: 300px;
                margin: 0 auto 10px;
            }
            .div-title{
                border: solid 5px;
                width: 300px;
                text-align: center;
                display: block;
                margin-left: 230px;
                margin-bottom: 50px;
            }
            .date_slip {
                padding-top: 15px;
                text-align: right;
                padding-right: 25px;
                font-weight: bold;
            }
            .ref_slip {
                padding-top: 15px;
                text-align: left;
                padding-left: 25px;
                font-weight: bold;
            }
            .customer table {
                border-collapse: collapse;
                width: 100%;
                font-size: 14px;
                padding-top: 5px;
                margin-left: 40px;
                margin-right: 40px;
            }
            .table-bordered {
                width:90%;
                margin: 0px auto;
                border-collapse: collapse;
                position:relative;
            }
            .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th,
            .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
                border: 1px solid #000;
                font-size:11px;
            }
            .table-bordered th {
                font-weight:normal;
                padding:5px 13.4px 5px 13.4px;
                font-size:11px;
            }
            .tab_cons th{
                padding:5px 31px 5px 31px;
            }
            .tab_total th{
                padding:5px 19.4px 5px 19.4px;

            }

            .table-bordered td {
                text-align:center;
                font-size:13px;
            }
            .customer tr td:first-child{
                width: 250px !important;
                padding-bottom: 2px;
            }
            table.bottom td{padding-top: 5px; font-size: 18px;}
            table.footer td.first{width: 50%; text-align: left}
            table.footer td.second{width: 50%; text-align: left;}
            table.conditions td{
                border: 1px solid grey;
            }
            table.conditions td{
                vertical-align: top;
                padding: 5px 5px 5px 10px;
                line-height: 19px;
            }
            table.conditions_bottom td.first{width: 420px}
            table.conditions_bottom td{padding-top: 5px}
            .note span{display: block;text-decoration: underline;padding-bottom: 5px;}

            .total span{padding:10px 10px;line-height:10px;font-size:13px;}

            .box-body{padding: 0; margin: 0; width: 100%; position: relative !important;}


            .tab_{
                margin-bottom:40px;
                margin-top:20px;
            }
            .tab_ thead{
                padding:5px;
                background:#c0c0c0;
            }
            .tab_ tbody td{
                padding:5px;
            }

            #header {
                left: 25px;
                right: 25px;
                border-bottom: 3px solid #000;
                margin-bottom: 5px;
                width: 100%;
            }

            .toletters {
                font-size: 10px;
            }

            #header table {
                width: 100%;
            }

            #slogan{
                vertical-align: -100%;
            }
            #header td.logo {
                vertical-align: top;
                padding-left: 25px;
                padding-top: 15px;
            }

            .company {
                font-weight: bold;
                display: block;
                font-size: 20px;
            }

            .copyright {
                font-size: 10px;
                text-align: center;
            }

            .info_company {
                font-size: 11px !important;
                line-height: 18px;
                text-align: left;
                float: left !important;
            }

            .info_fiscal {
                width: 20%;
                padding-top: 35px;
                font-size: 11px;
                line-height: 18px;
                text-align: left !important;
            }

            .info_fiscal > div {
                font-size: 11px !important;
                text-align: left;
            }

            .adr {
                font-weight: normal;
                font-size: 12px;
            }

            .date {
                text-align: left;
                padding-bottom: 20px;
                font-size: 13px;
                font-weight: normal;
            }

            .box-body {
                padding: 0;
                position: relative;
            }

            .bloc-center {
                width: 90%;
            }

            .document_reference {
                width: 60%;
            }

            .facture {
                font-size: 18px;
                font-weight: bold;
            }

            .doit {
                width: 40%;
                margin-right: 25px;
            }


            .mode-payment {
                font-size: 12px;
                width: 350px;
            }

            .main-table {
                width: 100%;
                border-collapse: collapse;
                margin: 30px 0;
                border: 1px solid #000;
            }

            .payment-table {
                border: 1px solid #000;
                width: 70%;
                margin: 30px 0;
            }

            .main-table th {
                border: 1px solid #777;
                padding-left: 3px;
                text-align: left;
                font-size: 10px;
            }

            .main-table td {
                text-align: left;
                padding: 3px;
                font-size: 11px;
            }

            .payment-table th {
                border: 1px solid #000;
                padding-left: 5px;
                text-align: left;
                font-size: 10px;
            }

            .payment-table td {
                text-align: left;
                padding: 3px 5px;
                font-size: 11px;
                border: 0.1mm solid #000000;
            }

            .total {
                page-break-inside: avoid !important;
                width: 250px;
                bottom: 150px;
                float: right;
                right: 25px;
                border: 2px solid #000;
                border-radius: 10px;
                padding: 10px 10px 0 10px;
            }

            .total-left {
                page-break-inside: avoid !important;
                width: 250px;
                bottom: 150px;
                float: left;
                right: 25px;
                border: 2px solid #000;
                border-radius: 10px;
                padding: 0;
            }

            .total-global {
                page-break-inside: avoid !important;
                width: 250px;
                bottom: 150px;
                float: right;
                padding: 10px;
            }

            .nombre-lettre {
                width: 450px;
                bottom: 200px;
                float: left;
                left: 20px;
                font-size: 10px;
                line-height: 20px;
            }

            .total span {
                page-break-inside: avoid !important;
                padding: 0 10px;
                line-height: 10px;
                font-size: 13px;
                margin: 0;
            }

            #footer {
                font-size: 10px;
                position: fixed;
                left: 0;
                bottom: -90px;
                right: 0;
                height: 45px;
            }

            .total div.left {
                width: 40%;
                float: left;
                padding-bottom: 10px;
            }

            .total div.right {
                width: 60%;
                float: right;
                text-align: right;
            }

            .ttc {
                border-top: 1px solid #000;
                padding-bottom: 0;
            }

            .client {
                font-size: 14px;
                font-weight: bold;
                margin-bottom: 30px;
                display: block;
                padding-top: 10px;
            }
            .adr-client {
                font-size: 10px;
                display: block;
                text-align: center;
                margin-bottom: 0px !important;
            }

            .info_client {
                font-size: 10px;
                white-space: nowrap;
            }

            .balance {
                width: 250px;
                position: absolute;
                bottom: 150px;
                float: right;
                right: 25px;
                border: 2px solid #000;
                border-radius: 10px;
                padding: 10px;
            }

            .barcode_table {
                font-size: 12px;
            }

            .barcode_table .barcode_tr {
                padding-top: 20px;
            }

            .barcode_table th {
                text-align: left;
                vertical-align: top;
            }

            .delivery th td {
                width: 150px;
            }


            body {
                font-family: Tahoma, sans-serif;
                font-size: 10pt;
            }

            p {	margin: 0; }


            table.items {
                border: 0.1mm solid #000000;
            }
            table.items th{
                font-size: 10px;
            }
            table.items td{
                font-size: 10px;
            }
            td { vertical-align: top; }
            .items td {
                border-left: 0.1mm solid #000000;
                border-right: 0.1mm solid #000000;
            }
            table thead th { background-color: #EEEEEE;
                text-align: center;
                border: 0.1mm solid #000000;

            }
            .items td.blanktotal {
                background-color: #fff;
                border: 0 none #000000;
                border-top: 0.1mm solid #000000;
                border-right: 0.1mm solid #000000;
            }
            .items td.totals {
                text-align: left;
                border: 0.1mm solid #000000;
            }
            .items td.cost {
                text-align:  right;
                font-size: small;
                font-size: 10px;
            }
            .items td{
                font-size: small;
            }
            .logo-print{
                width: 100px;
                height: 100px;
                padding: 0;
                margin: 0;
            }
            .bold{font-weight: bold !important;}

            .totals-table{
                width: 50%;
                float: left;
                text-align: right;
                border-collapse: collapse;
            }
            .totals-table td{
                padding: .75rem;
                vertical-align: top;
                border-top: 1px solid #bcbebf;
            }
            .last-td{
                border-bottom: 0.1mm solid #000000;
            }

            tbody.items{
                height: 1200px !important;
            }
            .payment-date{
                text-align: center;
            }

            .blank{
                color: #ffffff;
            }
            .payment-th{
                background-color: #EEEEEE;
                text-align: center;
                border: 0.1mm solid #000000;
            }
            .concatenated{
                padding-top: 0;
                padding-bottom: 0;
            }
            .first-row-concatenated{
                padding-bottom: 0;
            }
            .stamp-print{
                width: 120px;
                height: 120px;
                padding: 0;
                margin: 0 20px 0 0;
            }
            .bloc-info{
                width: 25%;
                margin-bottom: 0px!important;
                padding-bottom: 0px!important;
                border: 0.1mm solid #000000;
            }
            .bloc-client{
                width: 75% !important;
                margin-right: 0px !important;
            }
            .facture-center{
                text-align: center;
                border-bottom: 0.1mm solid #000000;
                padding: 10px
            }

            .ref{
                border-bottom: 0.1mm solid #000000;
                padding: 0px;
                font-size: 10px;
                font-weight: bold
            }
            .ref-left{
                width:35%;
                display: inline-block;
                padding: 5px;
                font-weight: bold
            }
            .ref-right{
                width:50%;
                border-left: 0.1mm solid #000000;
                text-align: right;
                display: inline-block;
                padding: 5px;
            }
            .date-client{
                margin-bottom: 0px;
                font-size: 10px;
                padding-bottom:0px ;
            }

            .payment-table {
                border: 1px solid #000;
                width: 70%;
                margin: 30px 0;
            }

            .payment-table th {
                border: 1px solid #000;
                padding-left: 5px;
                text-align: left;
                font-size: 10px;
            }

            .payment-table td {
                text-align: left;
                padding: 3px 5px;
                font-size: 11px;
                border: 0.1mm solid #000000;
            }

        </style>
    </head>
    <body style="page-break-inside:avoid;">
    <div id="header">
        <table>
            <tr>
                <?php
                if(!empty($company['Company']['logo'])){
                    $infoCompanyWidth = '50%';
                }else{
                    $infoCompanyWidth = '80%';
                }
                ?>
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
                <td>
                    <?php

                    if(!empty($company['Company']['logo']) && file_exists( WWW_ROOT .'/logo/'. $company['Company']['logo'])) {?>
                        <img src="<?= WWW_ROOT ?>/logo/<?= $company['Company']['logo'] ?>" width="180px" height="120px">
                    <?php } else { ?>
                        <img  width="180px" height="120px">
                    <?php } ?>
                </td>
            </tr>
        </table>
</div>
    <div class="box-body">
        <?php
        $timestamp = strtotime($slip['Slip']['date_slip']);
        $newDate = date("d/m/Y", $timestamp);
        ?>
        <div class="date_slip" style="font-size: 14px !important; "><?php echo $company['Company']['adress'].' LE '.$newDate ?></div>
        <div class="ref_slip"><?php echo 'Réf : '.' '.$slip['Slip']['reference']; ?></div>
    </div>
<div class="div-title">
    <div class="title"><?php echo __('Dispatch slip') ?></div>
    <div class="title"><?php echo $slip['Supplier']['name']; ?></div>
</div>

<div class="box-body">
    <table class='bon table-bordered tab_' >
        <thead >
        <tr>
            <th ><strong><?php echo __('Date'); ?></strong></th>
            <th ><strong><?php echo __('Client'); ?></strong></th>
            <th ><strong><?php echo  __('Destination'); ?></strong></th>
            <th ><strong><?php echo  __('N° BL'); ?></strong></th>
            <th ><strong><?php echo  __('N° Facture'); ?></strong></th>
            <th ><strong><?php echo  __('Obs'); ?></strong></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($missions as $mission){ ?>
            <tr>
                <td><?php
                    $timestamp = strtotime($mission['SheetRideDetailRides']['real_start_date']);
                    $newDate = date("d/m/Y", $timestamp);

                    echo $newDate ; ?>&nbsp;</td>
                <td><?php
                    echo h($mission['SheetRideDetailRides']['final_customer']); ?>&nbsp;</td>
                <td><?php
                    if($mission['SheetRideDetailRides']['type_ride']==2){
                        echo h($mission['Departure']['name'].' - '.$mission['Arrival']['name']);
                    }else {
                        echo h($mission['DepartureDestination']['name'].' - '.$mission['ArrivalDestination']['name']);
                    }
                    ?>&nbsp;</td>

                <td><?php echo h($mission['SheetRideDetailRides']['number_delivery_note']); ?>&nbsp;</td>
                <td><?php echo h($mission['SheetRideDetailRides']['number_invoice']); ?>&nbsp;</td>
                <td><?php echo h($mission['SheetRideDetailRides']['note']); ?>&nbsp;</td>



            </tr>
        <?php }
        ?>

        </tbody>
    </table>
    <div style="clear:both;"></div>
    <table class='tab-admin '>
        <tr >
            <td style="padding-left: 50px; font-size: 14px">
                <?php echo  'Veuillez nous accuser réception' ?>
            </td>
            <td style="padding-left: 350px; font-size: 14px">
                <?php echo  'Sce/ administrative  ' ?>
            </td>
        </tr>
        <tr>
            <td style="padding-left: 50px; font-size: 14px; padding-top: 20px">
                <?php echo  'Reçu le ' ?>
            </td>

        </tr>
    </table>
</div>

<div id="footer">
    <p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
</div>
</body>
</html>
<?php
$html = ob_get_clean();
        $this->dompdf = new Dompdf(array('chroot' => WWW_ROOT));
        $papersize = "A4";
        $orientation = 'portrait';
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper($papersize, $orientation);
        $this->dompdf->render();
        $output = $this->dompdf->output();

                $name = 'bordereau' . '_' . $slip['Slip']['reference'] . '.pdf';


        $name = str_replace('/', '-', $name);

        file_put_contents('./document_transport/' . $name, $output);


        $this->set('name', $name);


    }


}
