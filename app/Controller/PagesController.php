<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = array(
        'Customer',
        'CustomerCar',
        'EventEventType',
        'SheetRide',
        'Consumption',
        'Payment'
    );

    /**
     * Displays a view
     *
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     **/

    public function maps()
    {

    }

    public function personalTransportDashboard(){

    }
    public function display()
    {

        if (Configure::read("cafyb") == '1') {
            $userId = filter_input(INPUT_POST, "user_id");
            $user = $this->Cafyb->getInformationUser($userId);

            $this->Cafyb->writeInformationUser($user);
        }
        if(Configure::read("transport_personnel") == '1'){
            $this->redirect(array('controller'=>'sheetRides','action' => 'index'));
        }else {
            if ($this->isCustomer()) {
                $this->redirect(array('controller'=>'transportBills','action' => 'index',2));
            }elseif($this->isAgent()) {
                $this->redirect(array('controller'=>'sheetRides','action' => 'index'));
            }else {


                $this->setTimeActif();
                $path = func_get_args();
                $count = count($path);
                if (!$count) {
                    return $this->redirect('/');
                }
                $page = $subpage = $title_for_layout = null;

                if (!empty($path[0])) {
                    $page = $path[0];
                }
                if (!empty($path[1])) {
                    $subpage = $path[1];
                }
                if (!empty($path[$count - 1])) {
                    $title_for_layout = Inflector::humanize($path[$count - 1]);
                }

                $userId = $this->Auth->user('id');
                $resultEvent = $this->verifyUserPermission(SectionsEnum::evenements_tableau_bord, $userId, ActionsEnum::view,"Pages", null, "Page", null,1);
                if($resultEvent) {
                    $events = $this->getEvents();

                    $this->set(compact('events'));

                }
                $sheetRides = $this->getSheetRides();
                $this->set(compact('sheetRides'));

                $costMaintenances = $this->getTotalMaintenanceForThisMonth();
                $costMaintenancesPrecedentMonth = $this->getTotalMaintenanceForPrecedentMonth();
                $costMaintenancesPrecedentMonth2 = $this->getTotalMaintenanceForPrecedentMonth2();
                $costAdministratifs = $this->getTotalAdministratifForThisMonth();
                $costAdministratifsPrecedentMonth = $this->getTotalAdministratifForPrecedentMonth();
                $costAdministratifsPrecedentMonth2 = $this->getTotalAdministratifForPrecedentMonth2();
                $costFuels = $this->getTotalFuelCostForThisMonth();
                $costFuelsPrecedentMonth = $this->getTotalFuelCostForPrecedentMonth();
                $costFuelsPrecedentMonth2 = $this->getTotalFuelCostForPrecedentMonth2();
                $this->set(compact('costMaintenances','costMaintenancesPrecedentMonth','costMaintenancesPrecedentMonth2',
                        'costAdministratifs','costAdministratifsPrecedentMonth','costAdministratifsPrecedentMonth2',
                        'costFuels','costFuelsPrecedentMonth','costFuelsPrecedentMonth2'
                    )
                );
                $resultCommercial = $this->verifyUserPermission(SectionsEnum::commercial_tableau_bord, $userId, ActionsEnum::view,"Pages", null, "Page", null,1);
                if($resultCommercial){
                    if(Configure::read("gestion_commercial") == '1') {
                        $sumDemandeDevisNotTransformed = $this->getSumDemandeDevisNotTransformed();
                        $sumDevisNotTransformed = $this->getSumDevisNotTransformed();
                        $sumDevisRelance = $this->getSumDevisRelance();
                        $sumCustomerOrderNotValidated = $this->getSumCustomerOrderNotValidated();
                        $sumCustomerOrderNotTransmitted = $this->getSumCustomerOrderNotTransmitted();
                        $sumInvoiceNotPayed = $this->getSumInvoicesNotPayed();
                        $this->set(compact(
                            'sumDemandeDevisNotTransformed',
                            'sumDevisNotTransformed',
                            'sumCustomerOrderNotValidated',
                            'sumCustomerOrderNotTransmitted',
                            'sumInvoiceNotPayed',
                            'sumDevisRelance'
                        ));
                    }else {
                        $sumDevisNotTransformed = $this->getSumDevisNotTransformed();
                        $sumCustomerOrderNotValidated = $this->getSumCustomerOrderNotValidated();
                        $sumInvoiceNotPayed = $this->getSumInvoicesNotPayed();
                        $sumDeliveryOrderNotPayed = $this->getSumDeliveryOrdersNotPayed();
                        $sumDeadlineNotPayed = $this->getSumDeadlinesNotPayed();
                        $this->set(compact(

                            'sumDevisNotTransformed',
                            'sumCustomerOrderNotValidated',
                            'sumInvoiceNotPayed',
                            'sumDeliveryOrderNotPayed',
                            'sumDeadlineNotPayed'
                        ));
                    }

                }
                $resultPlanning = $this->verifyUserPermission(SectionsEnum::planification_tableau_bord, $userId, ActionsEnum::view,"Pages", null, "Page", null,1);

                if($resultPlanning){
                    $sumMissionsPlanned = $this->getSumMissionsPlanned();
                    $sumMissionsInProgress = $this->getSumMissionsInProgress();
                    $sumMissionsClosed = $this->getSumMissionsClosed();
                    $sumMissionsApproved = $this->getSumMissionsApproved();
                    $sumMissionsNotApproved = $this->getSumMissionsNotApproved();


                    $this->set(compact(
                        'sumMissionsPlanned',
                        'sumMissionsInProgress',
                        'sumMissionsClosed',
                        'sumMissionsApproved',
                        'sumMissionsNotApproved'
                    ));

                }

                $resultFinance = $this->verifyUserPermission(SectionsEnum::finance_tableau_bord, $userId, ActionsEnum::view,"Pages", null, "Page", null,1);

                if($resultFinance){
                    $sumPreinvoicedTurnover = $this->getSumPreinvoicedTurnover();
                    $sumInvoicedTurnover = $this->getSumInvoicedTurnover();
                    $sumPayedTurnover = $this->getSumPayedTurnover();
                    $sumNotPayedTurnover = $this->getSumNotPayedTurnover();
                    $sumCostConsumptionMission = $this->getSumConsumptionMissionCost();
                    $sumCostMission = $this->getSumMissionCost();
                    $sumCostConsumption = $this->getSumConsumptionCost();
                    $sumCostMaintenance = $this->getSumMaintenanceCost();
                    $sumCostPiece = $this->getSumPieceCost();



                    $this->set(compact(
                        'sumRealizedTurnover',
                        'sumPreinvoicedTurnover',
                        'sumInvoicedTurnover',
                        'sumPayedTurnover',
                        'sumNotPayedTurnover',
                        'sumCost',
                        'sumCostMission',
                        'sumCostConsumption',
                        'sumCostConsumptionMission',
                        'sumCostMaintenance',
                        'sumCostPiece'
                    ));
                }

                $resultParc = $this->verifyUserPermission(SectionsEnum::parc_tableau_bord, $userId, ActionsEnum::view,"Pages", null, "Page", null,1);
                if($resultParc) {
                    $nbCarsInMission = $this->getNbCarsInMission();
                    $nbCarsInParc = $this->getNbCarsInParc();
                    $nbRemorquesInParc = $this->getNbRemorquesInParc();
                    $nbCarsInPanne = $this->getNbCarsInPanne();
                    $nbRemorquesInPanne = $this->getNbRemorquesInPanne();
                    $nbCarsInReparation = $this->getNbCarsInReparation();
                    $nbRemorquesInReparation = $this->getNbRemorquesInReparation();
                    $nbCustomers = $this->getNbCustomers();

                    $this->set(compact(
                        'nbCarsInMission',
                        'nbCarsInParc',
                        'nbRemorquesInParc',
                        'nbCarsInPanne',
                        'nbRemorquesInPanne',
                        'nbCarsInReparation',
                        'nbRemorquesInReparation',
                        'nbCustomers'
                    ));
                }

                $resultAlerts = $this->verifyUserPermission(SectionsEnum::alertes_tableau_bord, $userId, ActionsEnum::view,"Pages", null, "Page", null,1);
                if($resultAlerts) {
                    $profileId = $this->Auth->user('profile_id');
                    $roleId = $this->Auth->user('role_id');
                    $permissionsAlertCommerciales = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_commerciales,  ActionsEnum::view, $profileId , $roleId);
                    $permissionsAlertAdministratives = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_administratives_juridiques,  ActionsEnum::view, $profileId , $roleId);
                    $permissionsAlertMaintenances = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_maintenances,  ActionsEnum::view, $profileId , $roleId);
                    $permissionsAlertConsommations = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_consommations,  ActionsEnum::view, $profileId , $roleId);
                    $permissionsAlertParcs = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_parcs,  ActionsEnum::view, $profileId , $roleId);
                    $permissionsAlertStock = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_stock,  ActionsEnum::view, $profileId , $roleId);

                    $nbAssuranceAlerts = 0;
                    $nbControlAlerts = 0;
                    $nbVidangeAlerts = 0;
                    $nbKmAlerts = 0;
                    $nbVignetteAlerts = 0;
                    $nbDateAlerts = 0;
                    $nbVidangeHourAlerts = 0;
                    $nbKmContractAlerts = 0;
                    $nbDateContractAlerts = 0;
                    $nbDriverLicenseAlerts = 0;
                    $nbConsumptionAlerts = 0;
                    $nbCouponConsumptionAlerts = 0;
                    $minCouponAlerts = 0;
                    $nbAmortissementAlerts = 0;
                    $nbProductMinAlerts = 0;
                    $nbProductMaxAlerts = 0;
                    if($permissionsAlertCommerciales){
                        $nbDeadlineAlerts= $this->getNbDeadlineAlerts();
                    }
                    $authenticatedUserId = $this->Auth->user('id');
                    if (!$this->IsAdministrator){
                        $userParcsIds = $this->getParcsUserIdsArray($authenticatedUserId);
                    }else{
                        $userParcsIds = array();
                    }
                    if($permissionsAlertAdministratives){
                        $nbAssuranceAlerts= $this->getNbAssuranceAlerts( $userParcsIds);
                        $nbVignetteAlerts= $this->getNbVignetteAlerts($userParcsIds);
                        $nbControlAlerts= $this->getNbControlAlerts($userParcsIds);
                        $nbDriverLicenseAlerts= $this->getNbDriverLicenseAlerts();
                    }
                    if($permissionsAlertMaintenances){
                        $nbVidangeAlerts = $this->getNbVidangeAlerts($userParcsIds);
                        $nbKmAlerts= $this->getNbKmAlerts($userParcsIds);
                        $nbDateAlerts = $this->getNbDateAlerts($userParcsIds);
                        $nbVidangeHourAlerts = $this->getNbVidangeHourAlerts();
                    }
                    if($permissionsAlertConsommations){
                        $nbConsumptionAlerts = $this->getNbKmConsumptionAlerts();
                        $nbCouponConsumptionAlerts = $this->getNbCouponConsumptionAlerts();
                        $minCouponAlerts = $this->getMinCouponAlerts();
                    }
                    if($permissionsAlertParcs){
                        $nbKmContractAlerts = $this->getNbKmContractAlerts();
                        $nbDateContractAlerts = $this->getNbDateContractAlerts();
                        $nbAmortissementAlerts = $this->getNbAmortissementAlerts();
                    }
                    if($permissionsAlertStock){
                        $nbProductMinAlerts = $this->getNbProductMinAlerts();
                        $nbProductMaxAlerts = $this->getNbProductMaxAlerts();
                    }
                    $this->set(compact(
                        'nbAssuranceAlerts',
                        'nbControlAlerts',
                        'nbVidangeAlerts',
                        'nbKmAlerts',
                        'nbVignetteAlerts',
                        'nbDateAlerts',
                        'nbVidangeHourAlerts',
                        'nbKmContractAlerts',
                        'nbDateContractAlerts',
                        'nbDriverLicenseAlerts',
                        'nbConsumptionAlerts',
                        'nbCouponConsumptionAlerts',
                        'minCouponAlerts',
                        'nbAmortissementAlerts',
                        'nbProductMinAlerts',
                        'nbProductMaxAlerts',
                        'nbDeadlineAlerts'));

                }
                $client_i2b = $this->isCustomerI2B();
                $hidden_information = $this->Parameter->getFieldsToHide();
                $password = $this->getPassword();

                $resultQuickLink = $this->verifyUserPermission(SectionsEnum::liens_tableau_bord, $userId, ActionsEnum::view,"Pages", null, "Page", null,1);
                $this->set(compact('page',
                    'subpage',
                    'resultCommercial',
                    'resultPlanning',
                    'resultFinance',
                    'resultParc',
                    'resultAlerts',
                    'resultQuickLink',
                    'resultEvent',
                    'title_for_layout',
                    'client_i2b',
                    'hidden_information',
                    'password'));

                try {
                    $this->render(implode('/', $path));
                } catch (MissingViewException $e) {
                    if (Configure::read('debug')) {
                        throw $e;
                    }
                    throw new NotFoundException();
                }
            }
        }


    }
    public function homeCafyb($userId=null){
        if (Configure::read("cafyb") == '1') {
            $user = $this->Cafyb->getInformationUser($userId);
            $this->Cafyb->writeInformationUser($user);
            $this->redirect(array('controller'=>'pages','action' => 'home'));
        }
    }

    public function home(){

        if(Configure::read("transport_personnel") == '1'){
            $this->redirect(array('controller'=>'sheetRides','action' => 'index'));
        }else {
            if ($this->isCustomer()) {
                $this->redirect(array('controller'=>'transportBills','action' => 'index',2));
            }elseif($this->isAgent()) {
                $this->redirect(array('controller'=>'sheetRides','action' => 'index'));
            }else {

                $this->redirect(array('controller'=>'pages','action' => 'display'));
            }
        }

    }

    private function getSheetRides(){
        $sheetRides= $this->SheetRide->find('all',array(
            'recursive' => -1, // should be used with joins
            'limit' => 5,
            'order' => array('SheetRide.id' => 'DESC'),
            'fields' => array(
                'SheetRide.id',
                'SheetRide.reference',
                'Car.code',
                'Carmodel.name',
                'Customer.first_name',
                'Customer.last_name',
                'SheetRide.start_date',
                'SheetRide.real_start_date',
                'SheetRide.status_id',
            ),
            'joins' => array(
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
                    'conditions' => array('SheetRide.customer_id = Customer.id')
                ),

                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),

            ))
        );

        return $sheetRides;
    }

    private function getTotalMaintenanceForThisMonth(){
        $month =  date('m');
        $year =  date('Y');
        $cost = 0;
        $events = $this->Event->find('all',
            array(
                'recursive'=>-1,
                'conditions'=>array('EventType.with_km'=>1, 'month(Event.date)'=>$month, 'year(Event.date)'=>$year),
                'fields'=>array('Event.cost'),
                'joins'=>array(
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
                )
                ));

        foreach ($events as $event){
            $cost = $cost + $event['Event']['cost'];
        }

        return $cost;


    }



    private function getTotalMaintenanceForPrecedentMonth(){
        $month =  date('m');
        if($month ==1){
            $month= 12;
        }else {
            $month = $month-1;
        }


        $year =  date('Y');
        if($year ==1){
            $year= $year-1;
        }
        $cost = 0;
        $events = $this->Event->find('all',
            array(
                'recursive'=>-1,
                'conditions'=>array('EventType.with_km'=>1, 'month(Event.date)'=>$month, 'year(Event.date)'=>$year),
                'fields'=>array('Event.cost'),
                'joins'=>array(
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
                )
            ));

        foreach ($events as $event){
            $cost = $cost + $event['Event']['cost'];
        }

        return $cost;

    }
    private function getTotalMaintenanceForPrecedentMonth2(){
        $month =  date('m');
        switch ($month){
            case 1:
                $month =11;
                break;
            case 2:
                $month =10;
                break;
            case 3:
                $month =9;
                break;
            case 4:
                $month =8;
                break;
            default:
                $month= $month-2;
                break;
        }
        $year =  date('Y');
        if($year ==1 || $year ==2 || $year ==3 || $year ==4){
            $year= $year-1;
        }
        $cost = 0;
        $events = $this->Event->find('all',
            array(
                'recursive'=>-1,
                'conditions'=>array('EventType.with_km'=>1, 'month(Event.date)'=>$month, 'year(Event.date)'=>$year),
                'fields'=>array('Event.cost'),
                'joins'=>array(
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
                )
            ));

        foreach ($events as $event){
            $cost = $cost + $event['Event']['cost'];
        }

        return $cost;

    }
    private function getTotalAdministratifForThisMonth(){
        $month =  date('m');
        $year =  date('Y');
        $cost = 0;
        $events = $this->Event->find('all',
            array(
                'recursive'=>-1,
                'conditions'=>array('EventType.with_km'=>0,'EventType.with_date'=>1, 'month(Event.date)'=>$month, 'year(Event.date)'=>$year),
                'fields'=>array('Event.cost'),
                'joins'=>array(
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
                )
                ));

        foreach ($events as $event){
            $cost = $cost + $event['Event']['cost'];
        }

        return $cost;


    }
    private function getTotalAdministratifForPrecedentMonth(){
        $month =  date('m');
        if($month ==1){
            $month= 12;
        }else {
            $month = $month-1;
        }


        $year =  date('Y');
        if($year ==1){
            $year= $year-1;
        }
        $cost = 0;
        $events = $this->Event->find('all',
            array(
                'recursive'=>-1,
                'conditions'=>array('EventType.with_km'=>0,'EventType.with_date'=>1, 'month(Event.date)'=>$month, 'year(Event.date)'=>$year),
                'fields'=>array('Event.cost'),
                'joins'=>array(
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
                )
            ));

        foreach ($events as $event){
            $cost = $cost + $event['Event']['cost'];
        }

        return $cost;

    }
    private function getTotalAdministratifForPrecedentMonth2(){
        $month =  date('m');
        switch ($month){
            case 1:
                $month =11;
            break;
            case 2:
                $month =10;
            break;
            case 3:
                $month =9;
            break;
            case 4:
                $month =8;
            break;
            default:
                $month= $month-2;
                break;
        }
        $year =  date('Y');
        if($year ==1 || $year ==2 || $year ==3 || $year ==4){
            $year= $year-1;
        }
        $cost = 0;
        $events = $this->Event->find('all',
            array(
                'recursive'=>-1,
                'conditions'=>array('EventType.with_km'=>0,'EventType.with_date'=>1, 'month(Event.date)'=>$month, 'year(Event.date)'=>$year),
                'fields'=>array('Event.cost'),
                'joins'=>array(
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
                )
            ));

        foreach ($events as $event){
            $cost = $cost + $event['Event']['cost'];
        }

        return $cost;

    }



    private function getTotalFuelCostForThisMonth(){
        $month =  date('m');
        $year =  date('Y');
        $cost = 0;
        $consumptions = $this->Consumption->find('all',
            array(
                'recursive'=>-1,
                'conditions'=>array( 'month(Consumption.consumption_date)'=>$month, 'year(Consumption.consumption_date)'=>$year),
                'fields'=>array('Consumption.cost'),

            ));

        foreach ($consumptions as $consumption){
            $cost = $cost + $consumption['Consumption']['cost'];
        }

        return $cost;

    }
    private function getTotalFuelCostForPrecedentMonth(){

        $month =  date('m');
        if($month ==1){
            $month= 12;
        }else {
            $month = $month-1;
        }


        $year =  date('Y');
        if($year ==1){
            $year= $year-1;
        }
        $cost = 0;
        $consumptions = $this->Consumption->find('all',
            array(
                'recursive'=>-1,
                'conditions'=>array( 'month(Consumption.consumption_date)'=>$month, 'year(Consumption.consumption_date)'=>$year),
                'fields'=>array('Consumption.cost'),

            ));

        foreach ($consumptions as $consumption){
            $cost = $cost + $consumption['Consumption']['cost'];
        }

        return $cost;

    }
    private function getTotalFuelCostForPrecedentMonth2(){

        $month =  date('m');
        switch ($month){
            case 1:
                $month =11;
                break;
            case 2:
                $month =10;
                break;
            case 3:
                $month =9;
                break;
            case 4:
                $month =8;
                break;
            default:
                $month= $month-2;
                break;
        }
        $year =  date('Y');
        if($year ==1 || $year ==2 || $year ==3 || $year ==4){
            $year= $year-1;
        }
        $cost = 0;
        $consumptions = $this->Consumption->find('all',
            array(
                'recursive'=>-1,
                'conditions'=>array( 'month(Consumption.consumption_date)'=>$month, 'year(Consumption.consumption_date)'=>$year),
                'fields'=>array('Consumption.cost'),

            ));

        foreach ($consumptions as $consumption){
            $cost = $cost + $consumption['Consumption']['cost'];
        }

        return $cost;

    }
    private function getEvents()
    {
        $this->setTimeActif();
        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => 5,
            'order' => array('Event.id' => 'DESC'),
            'fields' => array(
                'Event.id',
                'Car.code',
                'Carmodel.name',
                'EventType.name',
                'Event.modified',
                'Event.date',
                'Event.km',
            ),
            'joins' => array(
                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Event',
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
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),

            )
        );

        return $this->paginate('EventEventType');
    }


    private function getSumDevisNotTransformed()
    {
        if(Configure::read("gestion_commercial") == '1') {

            $nbDevis = $this->TransportBill->find('count', array(
                'recursive' => -1,
                'fields' => array('TransportBill.reference'),
                'conditions' => array('TransportBill.status' => 1, 'TransportBill.type' => 1)
            ));
        } else {
            $nbDevis = $this->Bill->find('count', array(
                'recursive' => -1,
                'fields' => array('Bill.reference'),
                'conditions' => array('Bill.status' => 1, 'Bill.type' => BillTypesEnum::quote)
            ));
        }
        return $nbDevis;
    }

    private function getSumDemandeDevisNotTransformed()
    {
        $nbDemandeDevis = $this->TransportBill->find('count', array(
            'recursive' => -1,
            'fields' => array('TransportBill.reference'),
            'conditions' => array('TransportBill.status' => 1, 'TransportBill.type' => 0)
        ));

        return $nbDemandeDevis;
    }

    private function getSumDevisRelance()
    {
        $nbDevis = $this->TransportBill->find('count', array(
            'recursive' => -1,
            'fields' => array('TransportBill.reference'),
            'conditions' => array('TransportBill.status' => 1, 'TransportBill.type' => 0)
        ));
        return $nbDevis;
    }

    private function getSumCustomerOrderNotValidated()
    {
        if(Configure::read("gestion_commercial") == '1') {
            $nbCommandes = $this->TransportBillDetailRides->find('count', array(
                'recursive' => -1,
                'conditions' => array('TransportBill.type' => 2, 'TransportBillDetailRides.status_id' => 1),
                //'fields' =>array('sum(TransportBillDetailRides.nb_trucks - TransportBillDetailRides.nb_trucks_validated)   AS total'),
                'joins' => array(
                    array(
                        'table' => 'transport_bills',
                        'type' => 'left',
                        'alias' => 'TransportBill',
                        'conditions' => array('TransportBillDetailRides.transport_bill_id = TransportBill.id')
                    ),
                )
            ));
        } else {
            $nbCommandes = $this->Bill->find('count', array(
                'recursive' => -1,
                'conditions' => array('Bill.type' => BillTypesEnum::customer_order, 'Bill.status' => 1),
                //'fields' =>array('sum(TransportBillDetailRides.nb_trucks - TransportBillDetailRides.nb_trucks_validated)   AS total'),
            ));
        }


        return $nbCommandes;

    }

    private function getSumCustomerOrderNotTransmitted()
    {

        $nbCommandes = $this->TransportBillDetailRides->find('count', array(
            'recursive' => -1,
            'conditions' => array('TransportBill.type' => 2, 'TransportBillDetailRides.status_id' => 8),
            //'fields' =>array('sum(TransportBillDetailRides.nb_trucks - TransportBillDetailRides.nb_trucks_validated)   AS total'),
            'joins' => array(
                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('TransportBillDetailRides.transport_bill_id = TransportBill.id')
                ),
            )
        ));


        return $nbCommandes;

    }

    private function getSumInvoicesNotPayed()
    {
        if(Configure::read("gestion_commercial") == '1') {
            $nbInvoices = $this->TransportBill->find('count', array(
                'recursive' => -1,
                'fields' => array('TransportBill.reference'),
                'conditions' => array('TransportBill.status_payment' => 1, 'TransportBill.type' => 7)
            ));
        } else {
            $nbInvoices = $this->Bill->find('count', array(
                'recursive' => -1,
                'fields' => array('Bill.reference'),
                'conditions' => array('Bill.amount_remaining >' => 0, 'Bill.type' => BillTypesEnum::sales_invoice)
            ));
        }

        return $nbInvoices;
    }

    private function getSumDeliveryOrdersNotPayed(){
        $nbDeliveryOrders = $this->Bill->find('count', array(
            'recursive' => -1,
            'fields' => array('Bill.reference'),
            'conditions' => array('Bill.status_payment' => 1, 'Bill.type' => BillTypesEnum::delivery_order)
        ));
        return  $nbDeliveryOrders;
    }

    private function getSumDeadlinesNotPayed(){
        $currentDate= date("Y-m-d");
        $nbDeadlines = $this->Payment->find('count', array(
            'recursive' => -1,
            'fields' => array('Payment.wording'),
            'conditions' => array('Payment.payment_etat' => 5, 'Payment.deadline_date <=' =>$currentDate, 'Payment.deadline_date !=' =>'0000-00-00' )
        ));
        return  $nbDeadlines;
    }

    private function getSumMissionsPlanned()
    {
        $nbMissions = $this->SheetRideDetailRides->find('count', array(
            'recursive' => -1,
            'conditions' => array('SheetRideDetailRides.status_id' => 1)
        ));

        return $nbMissions;
    }

    private function getSumMissionsInProgress()
    {
        $nbMissions = $this->SheetRideDetailRides->find('count', array(
            'recursive' => -1,
            'conditions' => array('SheetRideDetailRides.status_id' => 2)
        ));
        return $nbMissions;
    }

    private function getSumMissionsClosed()
    {
        $nbMissions = $this->SheetRideDetailRides->find('count', array(
            'recursive' => -1,
            'conditions' => array('SheetRideDetailRides.status_id' => 3)
        ));


        return $nbMissions;
    }

    private function getSumMissionsApproved()
    {
        $nbMissions = $this->SheetRideDetailRides->find('count', array(
            'recursive' => -1,
            'conditions' => array('SheetRideDetailRides.status_id' => 5)
        ));

        return $nbMissions;
    }

    private function getSumMissionsNotApproved()
    {
        $nbMissions = $this->SheetRideDetailRides->find('count', array(
            'recursive' => -1,
            'conditions' => array('SheetRideDetailRides.status_id' => array(4,6))
        ));
        return $nbMissions;
    }

    private function getNbCarsInMission()
    {
        $nbCarsInMission = $this->Car->find('count', array(
            'recursive' => -1,
            'conditions' => array('Car.in_mission' => 1, 'Car.car_category_id !='=> 3)
        ));
        return $nbCarsInMission;
    }

    private function getNbCarsInParc()
    {
        $nbCarsInParc = $this->Car->find('count', array(
            'recursive' => -1,
            'conditions' => array('Car.in_mission' => 0 , 'Car.car_category_id !='=> 3)
        ));
        return $nbCarsInParc;
    }  
	
	private function getNbRemorquesInParc()
    {
        $nbRemorquesInParc = $this->Car->find('count', array(
            'recursive' => -1,
            'conditions' => array('Car.in_mission' => 0 , 'Car.car_category_id '=> 3)
        ));
        return $nbRemorquesInParc;
    }

    private function getNbCarsInPanne()
    {
        $nbCarsInPanne = $this->Car->find('count', array(
            'recursive' => -1,
            'conditions' => array('Car.car_status_id' => 8 , 'Car.car_category_id !='=> 3)
        ));
        return $nbCarsInPanne;
    }    
	
	private function getNbRemorquesInPanne()
    {
        $nbCarsInPanne = $this->Car->find('count', array(
            'recursive' => -1,
            'conditions' => array('Car.car_status_id' => 8 , 'Car.car_category_id '=> 3)
        ));
        return $nbCarsInPanne;
    }

    private function getNbCarsInReparation()
    {
        $nbCarsInReparation = $this->Car->find('count', array(
            'recursive' => -1,
            'conditions' => array('Car.car_status_id' => 25 , 'Car.car_category_id !='=> 3)
        ));
        return $nbCarsInReparation;
    }   
	
	private function getNbRemorquesInReparation()
    {
        $nbRemorquesInReparation = $this->Car->find('count', array(
            'recursive' => -1,
            'conditions' => array('Car.car_status_id' => 25 , 'Car.car_category_id '=> 3)
        ));
        return $nbRemorquesInReparation;
    }

    private function getNbCustomers()
    {
        $nbCustomers = $this->Customer->find('count',
            array(
            'recursive' => -1,
            'conditions' => array('Customer.customer_category_id' => 1)
        ));
        return $nbCustomers;
    }

    private function getSumPreinvoicedTurnover()
    {
        $preinvoices = $this->TransportBill->find('all', array(
            'recursive' => -1,
            'conditions' => array('TransportBill.type' => 7),
            'fields' => array('sum(TransportBill.total_ttc )   AS total'),
        ));
        $total = $preinvoices[0][0]["total"];
        return $total;
    }

    private function getSumInvoicedTurnover()
    {
        if(Configure::read("gestion_commercial") == '1') {
            $invoices = $this->TransportBill->find('all', array(
                'recursive' => -1,
                'conditions' => array('TransportBill.type' => 7),
                'fields' => array('sum(TransportBill.total_ttc )   AS total'),
            ));
        } else {
            $invoices = $this->Bill->find('all', array(
                'recursive' => -1,
                'conditions' => array('Bill.type' => BillTypesEnum::sales_invoice),
                'fields' => array('sum(Bill.total_ttc )   AS total'),
            ));
        }
        $total = $invoices[0][0]["total"];

        return $total;
    }


    private function getSumPayedTurnover()
    {
        if(Configure::read("gestion_commercial") == '1') {
            $payments = $this->Payment->find('all', array(
                'recursive' => -1,
                'conditions' => array('Payment.payment_association_id' => 4),
                'fields' => array('sum(Payment.amount)   AS total'),

            ));
            $total = $payments[0][0]["total"];
        } else {
            $invoices = $this->Bill->find('all', array(
                'recursive' => -1,
                'conditions' => array('Bill.type' => BillTypesEnum::sales_invoice),
                'fields' => array('sum(Bill.total_ttc ) AS total_ttc', 'sum(Bill.amount_remaining ) AS total_amount_remaining' ),
            ));
            $total = $invoices[0][0]["total_ttc"] - $invoices[0][0]["total_amount_remaining"];
        }

        return $total;
    }

    private function getSumNotPayedTurnover()
    {
        if(Configure::read("gestion_commercial") == '1') {
            $invoices = $this->TransportBill->find('all', array(
                'recursive' => -1,
                'conditions' => array('TransportBill.type' => 7),
                'fields' => array('sum(TransportBill.amount_remaining )   AS total'),
            ));
        } else {
            $invoices = $this->Bill->find('all', array(
                'recursive' => -1,
                'conditions' => array('Bill.type' => BillTypesEnum::sales_invoice),
                'fields' => array('sum(Bill.amount_remaining )   AS total'),
            ));
        }
        $total = $invoices[0][0]["total"];
        return $total;
    }

    private function getSumConsumptionMissionCost()
    {
        $sheetRides = $this->SheetRide->find('all', array(
            'recursive' => -1,
            'fields' => array('sum(SheetRide.cost)   AS total'),
        ));
        $consumption = $sheetRides[0][0]["total"];

        $missions = $this->SheetRideDetailRides->find('all', array(
            'recursive' => -1,
            'fields' => array('sum(SheetRideDetailRides.mission_cost )   AS total'),
        ));
        $missionCost = $missions[0][0]["total"];
        $total = $consumption + $missionCost;
        return $total;
    }
    private function getSumMissionCost()
    {


        $missions = $this->SheetRideDetailRides->find('all', array(
            'recursive' => -1,
            'fields' => array('sum(SheetRideDetailRides.mission_cost )   AS total'),
        ));
        $missionCost = $missions[0][0]["total"];
        $total =  $missionCost;
        return $total;
    }
    private function getSumConsumptionCost()
    {
        $sheetRides = $this->SheetRide->find('all', array(
            'recursive' => -1,
            'fields' => array('sum(SheetRide.cost)   AS total'),
        ));
        $consumption = $sheetRides[0][0]["total"];

        $total = $consumption ;
        return $total;
    }


    private function getSumMaintenanceCost(){

        $cost = 0;
        $events = $this->Event->find('all',
            array(
                'recursive'=>-1,
                'conditions'=>array('EventType.with_km'=>1),
                'fields'=>array('Event.cost'),
                'joins'=>array(
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
                )
            ));

        foreach ($events as $event){
            $cost = $cost + $event['Event']['cost'];
        }

        return $cost;


    }

    private function getSumPieceCost()
    {

            $invoices = $this->Bill->find('all', array(
                'recursive' => -1,
                'conditions' => array('Bill.type' => BillTypesEnum::entry_order),
                'fields' => array('sum(Bill.total_ttc )   AS total'),
            ));

        $total = $invoices[0][0]["total"];

        return $total;
    }




    private function getNbAssuranceAlerts($parcsIds = null)
    {
        $conditions = array('Alert.alert_type_id'=>ParametersEnum::assurance);
        if (!empty($parcsIds)){
            $conditions = array(
                'Alert.alert_type_id'=>ParametersEnum::assurance,
                'Cars.parc_id' => $parcsIds
            );
        }
        $assuranceAlerts = $this->Alert->find('count', array(
            'conditions' => $conditions ,
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Events',
                    'conditions' => array('Events.id = Alert.object_id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Cars',
                    'conditions' => array('Cars.id = Events.car_id')
                ),
            )
            ));
        return $assuranceAlerts;
    }

    public function getNbControlAlerts($parcsIds = null){
        $conditions = array('Alert.alert_type_id'=>ParametersEnum::controle_technique);
        if (!empty($parcsIds)){
            $conditions = array(
                'Alert.alert_type_id'=>ParametersEnum::controle_technique,
                'Cars.parc_id' => $parcsIds
            );
        }
        $controlAlerts = $this->Alert->find('count', array(
            'conditions' => $conditions,
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Events',
                    'conditions' => array('Events.id = Alert.object_id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Cars',
                    'conditions' => array('Cars.id = Events.car_id')
                ),
            )

        ));
        return $controlAlerts;
    }

    public function getNbVidangeAlerts($parcsIds = null){
        $conditions = array('Alert.alert_type_id'=>ParametersEnum::vidange);
        if (!empty($parcsIds)){
            $conditions = array(
                'Alert.alert_type_id'=>ParametersEnum::vidange,
                'Cars.parc_id' => $parcsIds
            );
        }
        $vidangeAlerts = $this->Alert->find('count', array(
            'conditions' => $conditions,
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Events',
                    'conditions' => array('Events.id = Alert.object_id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Cars',
                    'conditions' => array('Cars.id = Events.car_id')
                ),
            )
        ));
        return $vidangeAlerts;
    }

    public function getNbKmAlerts($parcsIds = null){
        $conditions = array('Alert.alert_type_id'=>ParametersEnum::avec_km);
        if (!empty($parcsIds)){
            $conditions = array(
                'Alert.alert_type_id'=>ParametersEnum::avec_km,
                'Cars.parc_id' => $parcsIds
            );
        }
        $kmAlerts = $this->Alert->find('count', array(
            'conditions' => $conditions,
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Events',
                    'conditions' => array('Events.id = Alert.object_id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Cars',
                    'conditions' => array('Cars.id = Events.car_id')
                ),
            )
        ));
        return $kmAlerts;
    }

    public function getNbVignetteAlerts($parcsIds = null){
        $conditions = array('Alert.alert_type_id'=>ParametersEnum::vignette);
        if (!empty($parcsIds)){
            $conditions = array(
                'Alert.alert_type_id'=>ParametersEnum::vignette,
                'Cars.parc_id' => $parcsIds
            );
        }
        $vignetteAlerts = $this->Alert->find('count', array(
            'conditions' => $conditions,
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Events',
                    'conditions' => array('Events.id = Alert.object_id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Cars',
                    'conditions' => array('Cars.id = Events.car_id')
                ),
            )
           ));
        return $vignetteAlerts;
    }

    public function getNbDateAlerts( $parcsIds = null){
        $conditions = array('Alert.alert_type_id'=>ParametersEnum::avec_date);
        if (!empty($parcsIds)){
            $conditions = array(
                'Alert.alert_type_id'=>ParametersEnum::avec_date,
                'Cars.parc_id' => $parcsIds
            );
        }
        $dateAlerts = $this->Alert->find('count', array(
            'conditions' => $conditions,
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Events',
                    'conditions' => array('Events.id = Alert.object_id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Cars',
                    'conditions' => array('Cars.id = Events.car_id')
                ),
            )
           ));
        return $dateAlerts;
    }

    public function getNbVidangeHourAlerts(){
        $vidangeHourAlerts = $this->Alert->find('count', array(
            'conditions' => array('Alert.alert_type_id'=>ParametersEnum::vidange_engins),
            'recursive' => -1,
        ));
        return $vidangeHourAlerts;
    }

    public function getNbKmContractAlerts(){
        $kmContractAlerts=$this->Alert->find('count',array(
                'conditions' => array('Alert.alert_type_id'=>ParametersEnum::km_restant_contrat),
                'recursive' => -1,

            )
        );
        return $kmContractAlerts;
    }

    public function getNbDateContractAlerts(){
        $dateContractAlerts=$this->Alert->find('count',array(
                'conditions' => array('Alert.alert_type_id'=>ParametersEnum::contrat_vehicule),
                'recursive' => -1,

            )
        );
        return $dateContractAlerts;
    }

    public function getNbDriverLicenseAlerts(){
        $driverLicenseAlerts = $this->Alert->find('count', array(
            'conditions' => array('Alert.alert_type_id'=>ParametersEnum::expiration_permis),
            'recursive' => -1,

        ));

        return $driverLicenseAlerts;
    }

    public function getNbKmConsumptionAlerts(){
        $consumptionAlerts = $this->Alert->find('count',array(
            'conditions' => array('Alert.alert_type_id'=>ParametersEnum::limite_mensuelle_consommation),
            'recursive' => -1,
        ));

        return $consumptionAlerts;
    }

    public function getNbCouponConsumptionAlerts(){
        $couponConsumptionAlerts = $this->Alert->find('count',array(
            'conditions' => array('Alert.alert_type_id'=>ParametersEnum::coupon_consumption),
            'recursive' => -1,

        ));

        return $couponConsumptionAlerts;
    }

    public function getMinCouponAlerts(){
        $minCouponAlerts = $this->Alert->find('count',array(
            'conditions' => array('Alert.alert_type_id'=>ParametersEnum::nb_minimum_bons),
            'recursive' => -1,
        ))  ;

        return $minCouponAlerts;

    }

    public function getNbAmortissementAlerts(){
        $amortissementAlerts = $this->Alert->find('count',array(
            'conditions' => array('Alert.alert_type_id'=>ParametersEnum::amortissement),
            'recursive' => -1,

        ));

        return $amortissementAlerts;
    }

    public function getNbProductMinAlerts(){
        $productMinAlerts = $this->Alert->find('count',array(
            'conditions' => array('Alert.alert_type_id'=>ParametersEnum::product_min),
            'recursive' => -1,

        ));

        return $productMinAlerts;
    }

    public function getNbProductMaxAlerts(){
        $productMaxAlerts = $this->Alert->find('count',array(
            'conditions' => array('Alert.alert_type_id'=>ParametersEnum::product_max),
            'recursive' => -1,
        ));

        return $productMaxAlerts;
    }

    public function getNbDeadlineAlerts(){
        $deadlineAlerts = $this->Alert->find('count',array(
            'conditions' => array('Alert.alert_type_id'=>ParametersEnum::echeance),
            'recursive' => -1,
        ));

        return $deadlineAlerts;
    }
}
