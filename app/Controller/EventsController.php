<?php

App::uses('AppController', 'Controller');

/**
 * Events Controller
 *
 * @property Event $Event
 * @property InterferingType $InterferingType
 * @property EventType $EventType
 * @property Company $Company
 * @property BillProduct $BillProduct
 * @property Interfering $Interfering
 * @property InterferingTypeEventType $InterferingTypeEventType
 * @property Carmodel $Carmodel
 * @property Car $Car
 * @property Product $Product
 * @property Lot $Lot
 * @property Customer $Customer
 * @property EventTypeCategory $EvengetEventProductstTypeCategory
 * @property EventTypeCategoryEventType $EventTypeCategoryEventType
 * @property EventCategoryInterfering $EventCategoryInterfering
 * @property Payment $Payment
 * @property Parc $Parc
 * @property Workshop $Workshop
 * @property Profile $Profile
 * @property DetailPayment $DetailPayment
 * @property EventEventType $EventEventType
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 * @property Service $Service
 * @property EventTypeProduct $EventTypeProduct
 * @property EventProduct $EventProduct
 */
class EventsController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Security', 'RequestHandler');
    public $uses = array(
        'Event',
        'EventType',
        'Interfering',
        'InterferingTypeEventType',
        'Carmodel',
        'Customer',
        'EventTypeCategory',
        'EventTypeCategoryEventType',
        'EventCategoryInterfering',
        'Payment',
        'EventEventType',
        'Parc',
        'Workshop',
        'Profile',
        'BillProduct',
        'Product',
        'Lot',
        'DetailPayment',
        'Company',
        'EventTypeProduct'
    );

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->setTimeActif();
            $userId = $this->Auth->user('id');

            $cond = $this->getConditions();
            $conditions = $cond[0];
            $conditions_car = $cond[1];
            $conditions_customer = $cond[2];

        
        $parcIds = $this->getParcsUserIdsArray($userId);
        if (!empty($parcIds) && !$this->IsAdministrator) {
            $conditions = array_merge($conditions, array('Car.parc_id' => $parcIds));
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
         $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => $limit,
            'order' => array('Event.id' => 'DESC'),
            'conditions' => $conditions,
            'fields' => array(
                'Event.code',
                'Event.id',
                'Event.date',
                'Event.next_date',
                'Event.km',
                'Event.next_km',
                'Event.cost',
                'Event.locked',
                'Event.transferred',
                'Event.made_event',
                'Customer.id',
                'Customer.first_name',
                'Customer.last_name',
                'Customer.company',
                'Interfering.name',
                'Car.code',
                'Car.immatr_def',
                'Event.user_id',
                'Car.parc_id',
                'Carmodel.name',
                'EventType.name',
                'Event.alert',
                'Event.status_id',
                'Event.multiple_event',
                'Event.attachment1',
                'Event.attachment2',
                'Event.attachment3',
                'Event.attachment4',
                'Event.attachment5'
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
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Event.customer_id = Customer.id')
                ),
                array(
                    'table' => 'event_category_interfering',
                    'type' => 'left',
                    'alias' => 'EventCategoryInterfering',
                    'conditions' => array('EventCategoryInterfering.event_id = EventEventType.event_id')
                ),
                array(
                    'table' => 'interferings',
                    'type' => 'left',
                    'alias' => 'Interfering',
                    'conditions' => array('EventCategoryInterfering.interfering_id0 = Interfering.id')
                ),
                array(
                    'table' => 'interferings',
                    'type' => 'left',
                    'alias' => 'Interfering1',
                    'conditions' => array('EventCategoryInterfering.interfering_id1 = Interfering1.id')
                ),
                array(
                    'table' => 'interferings',
                    'type' => 'left',
                    'alias' => 'Interfering2',
                    'conditions' => array('EventCategoryInterfering.interfering_id2 = Interfering2.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'parcs',
                    'type' => 'left',
                    'alias' => 'Parc',
                    'conditions' => array('Car.parc_id = Parc.id')
                ),
                array(
                    'table' => 'event_type_category_event_type',
                    'type' => 'left',
                    'alias' => 'EventTypeCategoryEventType',
                    'conditions' => array('EventTypeCategoryEventType.event_type_id = EventType.id')
                ),
            )
        );

        $events = $this->Paginator->paginate("EventEventType");

        $this->set('events', $events);
        $sumCost = $this->Event->getSumCost2($conditions);

        $interferings = $this->Interfering->getInterferingList();
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        if ($roleId != 3) {
            $administratifEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::administratif_evenement,
                ActionsEnum::view, $profileId, $roleId);
            $maintenanceEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::maintenance_evenement,
                ActionsEnum::view, $profileId, $roleId);
            if(($administratifEventPermission == 1) && ($maintenanceEventPermission == 1)){
                $eventTypes = $this->EventType->getEventTypes();
            }elseif(($administratifEventPermission == 1) && ($maintenanceEventPermission == 0)){
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id' => 8);
                $eventTypes = $this->EventType->getEventTypes('list', null , null , $eventTypeConditions);
            }elseif(($administratifEventPermission == 0) && ($maintenanceEventPermission == 1)){
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id !=' => 8);
                $eventTypes = $this->EventType->getEventTypes('list', null , null , $eventTypeConditions);
            }
        }else {
            $eventTypes = $this->EventType->getEventTypes();
        }
        //Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if (!empty($parcIds)) {
            $conditions_car = array_merge($conditions_car, array('Car.parc_id' => $parcIds));
        }
        $cars = $this->Car->getCarsByCondition($param, $conditions_car);

        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions_customer);
        $users = $this->Event->User->find('list', array('conditions' => array('User.id !=' => 1)));
        $profiles = $this->Profile->getUserProfiles();
        $parcs = $this->getUserParcs();
        $nb_parcs = count($parcIds);
        $hasParc = $this->verifyUserParcPermission(SectionsEnum::evenement);
        $isSuperAdmin = $this->isSuperAdmin();
        $printInterventionRequest = $this->AccessPermission->getPermissionWithParams(SectionsEnum::demande_intervention,
            ActionsEnum::printing, $profileId, $roleId);
        $statuses = array(
            '1' => __('Planned'),
            '2' => __('Ongoing'),
            '3' => __('Finished'),
            '4' => __('Canceled'),
        );
        $controllerName = 'Events';
        $actionName = 'index';
        $this->set(compact('profiles', 'cars', 'customers', 'users',
            'interferings', 'eventTypes', 'sumCost', 'limit','printInterventionRequest',
            'parcs', 'hasParc', 'nb_parcs', 'param', 'conditions',
            'conditions_car', 'conditions_customer','isSuperAdmin','statuses','controllerName','actionName'));
    }
    public function getEntryExitWorkshops()
    {
        $this->setTimeActif();






        $searchConditions =array();
        if ($this->request->is('post')) {

            if (
                isset($this->request->data['Events']['car_id']) ||
                isset($this->request->data['Events']['mechanician_id']) ||
                isset($this->request->data['Events']['parc_id']) ||
                isset($this->request->data['Events']['workshop_id']) ||
                isset($this->request->data['Events']['event_type_id']) ||
                isset($this->request->data['Events']['workshop_entry_date']) ||
                isset($this->request->data['Events']['workshop_exit_date']) ||
                isset($this->request->data['Events']['profile_id'])||
                isset($this->request->data['Events']['user_id'])||
                isset($this->request->data['Events']['created'])||
                isset($this->request->data['Events']['created1'])||
                isset($this->request->data['Events']['modified_id'])||
                isset($this->request->data['Events']['modified'])||
                isset($this->request->data['Events']['modified1'])

            ) {
                if(isset($this->request->data['Events']['car_id'])) {
                    $car = $this->request->data['Events']['car_id'];
                }
                if(isset($this->request->data['Events']['mechanician_id'])){
                    $mechanic = $this->request->data['Events']['mechanician_id'];
                }

                if(isset($this->request->data['Events']['parc_id'])) {
                    $parc = $this->request->data['Events']['parc_id'];
                }
                if(isset($this->request->data['Events']['workshop_id'])){
                    $workshop = $this->request->data['Events']['workshop_id'];
                }

                if(isset($this->request->data['Events']['event_type_id'])) {
                    $eventType = $this->request->data['Events']['event_type_id'];
                }

                if(isset($this->request->data['Events']['user_id'])){
                    $user = $this->request->data['Events']['user_id'];
                }
                if(isset($this->request->data['Events']['modified_id'])){
                    $modifier = $this->request->data['Events']['modified_id'];
                }
                $start_date_from = str_replace("/", "-", $this->request->data['Events']['workshop_entry_date']);
                $start_date_to = str_replace("/", "-", $this->request->data['Events']['workshop_entry_date']);

                if(isset($this->request->data['Events']['created'])) {
                    $created_from = str_replace("/", "-", $this->request->data['Events']['created']);
                }
                if(isset($this->request->data['Events']['created1'])) {
                    $created_to = str_replace("/", "-", $this->request->data['Events']['created1']);
                }
                if(isset($this->request->data['Events']['modified'])) {
                    $modified_from = str_replace("/", "-", $this->request->data['Events']['modified']);
                }
                if(isset($this->request->data['Events']['modified1'])) {
                    $modified_to = str_replace("/", "-", $this->request->data['Events']['modified1']);
                }

                if (!empty($car)) {
                    $searchConditions[" Event.car_id  = "] = $car;
                   // $searchConditions .= " && Event.car_id = $car  ";
                }

                if (!empty($mechanic)) {
                    $searchConditions[" Event.mechanician_id = "]= $mechanic  ;
                }

                if (!empty($parc)) {
                    $searchConditions [ " Car.parc_id = "]= $parc  ;
                }

                if (!empty($workshop)) {
                    $searchConditions [ "  Event.workshop_id = "]= $workshop  ;
                }

                if (!empty($eventType)) {
                    $searchConditions [" EventEventType.event_type_id = "]= $eventType  ;
                }



                if (isset($user)&& !empty($user)) {
                    $searchConditions[ " Event.user_id = "]= $user  ;
                }

                if (isset($modifier)&& !empty($modifier)) {
                    $searchConditions [" Event.modified_id = "]= $modifier  ;
                }



                if (isset($start_date_from)&& !empty($start_date_from)) {
                    $start = str_replace("-", "/", $start_date_from);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $startdtm = $startdtm->format('Y-m-d 00:00:00');
                    $searchConditions [ "  Event.workshop_entry_date >=  "]=$startdtm ;
                }
                if (isset($start_date_to)&& !empty($start_date_to)) {
                    $end = str_replace("-", "/", $start_date_to);
                    $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                    $enddtm = $enddtm->format('Y-m-d 23:59:00');
                    $searchConditions [ " Event.workshop_exit_date <= "]=$enddtm ;
                }


                if (isset($created_from)&& !empty($created_from)) {
                    $start = str_replace("-", "/", $created_from);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $startdtm = $startdtm->format('Y-m-d 00:00:00');
                    $searchConditions [ " Event.created >= "]=$startdtm ;
                }
                if (isset($created_to)&& !empty($created_to)) {
                    $end = str_replace("-", "/", $created_to);
                    $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                    $enddtm = $enddtm->format('Y-m-d 23:59:00');
                    $searchConditions [ " Event.created <= "]=$enddtm;
                }
                if (isset($modified_from)&&  !empty($modified_from)) {
                    $start = str_replace("-", "/", $modified_from);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $startdtm = $startdtm->format('Y-m-d 00:00:00');
                    $searchConditions [ " && Event.modified >= "]=$startdtm;
                }
                if (isset($modified_to)&&  !empty($modified_to)) {
                    $end = str_replace("-", "/", $modified_to);
                    $enddtm = DateTime::createFromFormat('d/m/Y', $end);
                    $enddtm = $enddtm->format('Y-m-d 23:59:00');
                    $searchConditions [ " && Event.modified <= "]=$enddtm;
                }


            }
        }else {
            $searchConditions =array();
        }
        $cond = $this->getConditions();
        $conditions = $cond[0];
        $conditions_car = $cond[1];
        $conditions_customer = $cond[2];

        $conditionWorkshop = array(' (
            Event.workshop_id is not null 
            OR Event.workshop_entry_date is not null
            OR Event.workshop_exit_date is not null )
            ');
        if($conditions != null) {
            $conditions = array_merge($conditions, $conditionWorkshop);
        }

        if($searchConditions != '' && $conditions != null ) {
            $conditions = array_merge($conditions, $searchConditions);
           // var_dump($conditions); die();
        }


        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
         $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => $limit,
            'order' => array('Event.id' => 'DESC'),
            'conditions' => $conditions,
            'fields' => array(
                'Event.code',
                'Event.id',
               'Workshop.name',
               'Event.workshop_entry_date',
               'Event.workshop_exit_date',
               'Customer.first_name',
               'Customer.last_name',
                'Car.code',
                'Car.immatr_def',
                'Carmodel.name',
                'EventType.name',
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
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Event.mechanician_id = Customer.id')
                ),
                array(
                    'table' => 'workshops',
                    'type' => 'left',
                    'alias' => 'Workshop',
                    'conditions' => array('Event.workshop_id = Workshop.id')
                ),


            )
        );

        $events = $this->Paginator->paginate("EventEventType");

        $this->set('events', $events);
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        if ($roleId != 3) {
            $administratifEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::administratif_evenement,
                ActionsEnum::view, $profileId, $roleId);
            $maintenanceEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::maintenance_evenement,
                ActionsEnum::view, $profileId, $roleId);
            if(($administratifEventPermission == 1) && ($maintenanceEventPermission == 1)){
                $eventTypes = $this->EventType->getEventTypes();
            }elseif(($administratifEventPermission == 1) && ($maintenanceEventPermission == 0)){
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id' => 8);
                $eventTypes = $this->EventType->getEventTypes('list', null , null , $eventTypeConditions);
            }elseif(($administratifEventPermission == 0) && ($maintenanceEventPermission == 1)){
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id !=' => 8);
                $eventTypes = $this->EventType->getEventTypes('list', null , null , $eventTypeConditions);
            }
        }else {
            $eventTypes = $this->EventType->getEventTypes();
        }
        //Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $cars = $this->Car->getCarsByCondition($param, $conditions_car);

        $fields = "names";
        $conditionMechanic = array('CustomerCategory.mechanician'=>1);
        $mechanicians = $this->Customer->getCustomersByFieldsAndConds($fields,$conditionMechanic);
        $workshops = $this->Workshop->getWorkshops('list');
        $users = $this->Event->User->find('list', array('conditions' => array('User.id !=' => 1)));
        $profiles = $this->Profile->getUserProfiles();
        $isSuperAdmin = $this->isSuperAdmin();
        $hasParc = $this->verifyUserParcPermission(SectionsEnum::evenement);
        $this->set(compact('profiles', 'cars', 'mechanicians', 'users',
            'interferings', 'eventTypes', 'sumCost', 'limit','hasParc','workshops',
            'parcs', 'hasParc', 'nb_parcs', 'param', 'conditions',
            'conditions_car', 'conditions_customer','isSuperAdmin'));
    }





    public function alerts()
    {
        $this->setTimeActif();
        $ids = array();

        $alerts = $this->Alert->find('all',array('conditions'=>array('Alert.model'=>'Event'),'fields'=>array('Alert.object_id')));
        foreach ($alerts as $alert){
            $ids[]  =$alert['Alert']['object_id'];
        }
        if (empty($ids)) {
            $ids = 0;
        }
        $this->redirect(array("controller" => "events", "action" => "search", "ids" => $ids));
    }

    public function getIdFromAlert($alerts, $name, $ids)
    {

        foreach ($alerts as $alert) {
            $ids[] = $alert[$name][0];
        }
        return $ids;
    }

    public function disablealert($id = null)
    {

        if (!$this->Event->exists($id)) {
            throw new NotFoundException(__('Invalid event'));
        }
        $event = $this->Event->find('all', array(
            'conditions' => array(
                "Event.id" => $id,
                "Event.alert" => 1
            )
        ));


        if (!empty($event)) {
            $this->Event->id = $id;
            $this->Event->saveField('alert', 2);
        }

        $this->Flash->success(__('The alert has been disabled.'));
        $this->redirect(array('action' => 'view', $id));
    }


    /**
     * search method
     *
     * @return void
     */
    public function search()
    {
        $this->setTimeActif();
        if (isset($this->request->data['keyword']) || isset($this->request->data['Events']['event_type_id'])
            || isset($this->request->data['Events']['car_id']) || isset($this->request->data['Events']['customer_id'])
            || isset($this->request->data['Events']['interfering_id']) || isset($this->request->data['Events']['user_id'])
            || isset($this->request->data['Events']['date']) || isset($this->request->data['Events']['next_date'])
            || isset($this->request->data['Events']['created']) || isset($this->request->data['Events']['created1'])
            || isset($this->request->data['Events']['parc_id']) || isset($this->request->data['Events']['modified_id'])
            || isset($this->request->data['Events']['modified']) || isset($this->request->data['Events']['modified1'])
            || isset($this->request->data['Events']['pay_customer']) || isset($this->request->data['Events']['refund'])
            || isset($this->request->data['Events']['validated']) || isset($this->request->data['Events']['request'])
            || isset($this->request->data['Events']['severity_incident']) || isset($this->params['data']['conditions'])
            || isset($this->params['data']['conditions_car']) || isset($this->params['data']['conditions_customer'])
            || isset($this->request->data['Events']['profile_id']) || isset($this->request->data['Events']['status_id'])
            || isset($this->request->data['named']['km'] )
            || isset($this->request->data['named']['km_to'] ) || isset($this->request->data['named']['next_km'] )
            || isset($this->request->data['named']['next_km_to'] ) || isset($this->request->data['named']['cost'] )
            || isset($this->request->data['named']['cost_to'])
        ) {
            $this->filterUrl();
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->params['named']['keyword']) || isset($this->params['named']['type'])
            || isset($this->params['named']['car']) || isset($this->params['named']['user'])
            || isset($this->params['named']['customer']) || isset($this->params['named']['interfering'])
            || isset($this->params['named']['date']) || isset($this->params['named']['nextdate'])
            || isset($this->params['named']['created']) || isset($this->params['named']['created1'])
            || isset($this->params['named']['ids']) || isset($this->params['named']['parc'])
            || isset($this->params['named']['modified_id']) || isset($this->params['named']['profile_id'])
            || isset($this->params['named']['modified']) || isset($this->params['named']['modified1'])
            || isset($this->params['named']['pay_customer']) || isset($this->params['named']['refund'])
            || isset($this->request->data['named']['validated']) || isset($this->request->data['named']['request'])
            || isset($this->request->data['named']['severity']) || isset($this->params['named']['conditions'])
            || isset($this->params['named']['conditions_car']) || isset($this->params['named']['conditions_customer'])
            || isset($this->params['named']['status'] ) || isset($this->params['named']['km'] )
            || isset($this->params['named']['km_to'] ) || isset($this->params['named']['next_km'] )
            || isset($this->params['named']['next_km_to'] ) || isset($this->params['named']['cost'] )
            || isset($this->params['named']['cost_to'] )
        ) {
            $conditions = $this->getConds();

            if (isset($this->params['named']['conditions'])) {
                $conditions_index = unserialize(base64_decode($this->params['named']['conditions']));
                if($conditions_index!=null){
                    $conditions = array_merge($conditions, $conditions_index);
                }

                $conditions = array_merge($conditions, $conditions_index);
            } else {
                $conditions_index = null;
            }
            $this->paginate = array(
                'paramType' => 'querystring',
                'recursive' => -1, // should be used with joins
                'limit' => $limit,
                'conditions'=>$conditions,
                'fields' => array(
                    'Event.code',
                    'Event.id',
                    'Event.date',
                    'Event.next_date',
                    'Event.date3',
                    'Event.km',
                    'Event.next_km',
                    'Event.cost',
                    'Event.locked',
                    'Event.validated',
                    'Event.request',
                    'Event.made_event',
                    'Event.pay_customer',
                    'Event.refund',
                    'Customer.id',
                    'Customer.first_name',
                    'Customer.last_name',
                    'Customer.company',
                    'Car.code',
                    'Interfering.name',
                    'Carmodel.name',
                    'EventType.name',
                    'Car.immatr_def',
                    'Event.alert',
                    'Event.status_id',
                    'Event.multiple_event',
                    'Event.severity_incident',
                    'Event.attachment1',
                    'Event.attachment2',
                    'Event.attachment3',
                    'Event.attachment4',
                    'Event.attachment5'
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
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('Event.customer_id = Customer.id')
                    ),
                    array(
                        'table' => 'event_category_interfering',
                        'type' => 'left',
                        'alias' => 'EventCategoryInterfering',
                        'conditions' => array('EventCategoryInterfering.event_id = EventEventType.event_id')
                    ),
                    array(
                        'table' => 'interferings',
                        'type' => 'left',
                        'alias' => 'Interfering',
                        'conditions' => array('EventCategoryInterfering.interfering_id0 = Interfering.id')
                    ),
                    array(
                        'table' => 'interferings',
                        'type' => 'left',
                        'alias' => 'Interfering1',
                        'conditions' => array('EventCategoryInterfering.interfering_id1 = Interfering1.id')
                    ),
                    array(
                        'table' => 'interferings',
                        'type' => 'left',
                        'alias' => 'Interfering2',
                        'conditions' => array('EventCategoryInterfering.interfering_id2 = Interfering2.id')
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
                        'conditions' => array('Event.user_id = User.id')
                    ),
                    array(
                        'table' => 'event_type_category_event_type',
                        'type' => 'left',
                        'alias' => 'EventTypeCategoryEventType',
                        'conditions' => array('EventTypeCategoryEventType.event_type_id = EventType.id')
                    ),
                ),
            );
            $events = $this->Paginator->paginate("EventEventType");

            $this->set('events', $events);
            $sumCost = $this->Event->getSumCost2($conditions);
        } else {
            $this->paginate = array(
                'paramType' => 'querystring',
                'recursive' => -1, // should be used with joins
                'limit' => $limit,
                'fields' => array(
                    'Event.code',
                    'Event.id',
                    'Event.date',
                    'Event.next_date',
                    'Event.date3',
                    'Event.km',
                    'Event.next_km',
                    'Event.cost',
                    'Event.locked',
                    'Event.validated',
                    'Event.request',
                    'Event.pay_customer',
                    'Event.refund',
                    'Car.immatr_def',
                    'Customer.id',
                    'Customer.first_name',
                    'Customer.last_name',
                    'Customer.company',
                    'Car.code',
                    'Interfering.name',
                    'Carmodel.name',
                    'EventType.name',
                    'Event.alert'
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
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('Event.customer_id = Customer.id')
                    ),
                    array(
                        'table' => 'interferings',
                        'type' => 'left',
                        'alias' => 'Interfering',
                        'conditions' => array('Event.interfering_id = Interfering.id')
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
                        'conditions' => array('Event.user_id = User.id')
                    ),
                    array(
                        'table' => 'event_type_category_event_type',
                        'type' => 'left',
                        'alias' => 'EventTypeCategoryEventType',
                        'conditions' => array('EventTypeCategoryEventType.event_type_id = EventType.id')
                    ),
                )
            );
            $this->set('events', $this->paginate('EventEventType'));
            $sumCost = $this->Event->getSumCost2();
        }
        $interferings = $this->Interfering->getInterferingList();
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        if ($roleId != 3) {
            $administratifEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::administratif_evenement,
                ActionsEnum::view, $profileId, $roleId);
            $maintenanceEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::maintenance_evenement,
                ActionsEnum::view, $profileId, $roleId);
            if(($administratifEventPermission == 1) && ($maintenanceEventPermission == 1)){
                $eventTypes = $this->EventType->getEventTypes();
            }elseif(($administratifEventPermission == 1) && ($maintenanceEventPermission == 0)){
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id' => 8);
                $eventTypes = $this->EventType->getEventTypes('list', null , null , $eventTypeConditions);
            }elseif(($administratifEventPermission == 0) && ($maintenanceEventPermission == 1)){
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id !=' => 8);
                $eventTypes = $this->EventType->getEventTypes('list', null , null , $eventTypeConditions);
            }
        }else {
            $eventTypes = $this->EventType->getEventTypes();
        }
        $param = $this->Parameter->getCodesParameterVal('name_car');

        if (isset($this->params['named']['conditions_car'])) {
            $conditions_car = unserialize(base64_decode($this->params['named']['conditions_car']));
        } else {
            $conditions_car = null;
        }
        $cars = $this->Car->getCarsByFieldsAndConds($param, null, $conditions_car, null);

        $fields = "names";

        if (isset($this->params['named']['conditions_customer'])) {
            $conditions_customer = unserialize(base64_decode($this->params['named']['conditions_customer']));
        } else {
            $conditions_customer = null;

        }
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions_customer);

        $users = $this->Event->User->find('list', array('conditions' => array('User.id !=' => 1)));
        $profiles = $this->Profile->getUserProfiles();
        $userId = intval($this->Auth->user('id'));
        $parcIds = $this->getParcsUserIdsArray($userId);
        $statuses = array(
            '1' => __('Planned'),
            '2' => __('Ongoing'),
            '3' => __('Finished'),
            '4' => __('Canceled'),
        );
        $parcs = $this->getUserParcs();
        $nb_parcs = count($parcIds);
        $hasParc = $this->verifyUserParcPermission(SectionsEnum::evenement);
        $isSuperAdmin = $this->isSuperAdmin();
        $this->set(compact('profiles', 'cars', 'customers', 'users', 'interferings', 'eventTypes', 'sumCost', 'limit',
            'parcs', 'hasParc', 'nb_parcs', 'param', 'conditions_index', 'conditions_car', 'conditions_customer', 'isSuperAdmin'
        ,'statuses'));
        $this->render();
    }
  public function searchRequest()
    {


        $this->setTimeActif();
        if (isset($this->request->data['keyword']) || isset($this->request->data['Events']['event_type_id'])
            || isset($this->request->data['Events']['car_id']) || isset($this->request->data['Events']['customer_id'])
            || isset($this->request->data['Events']['interfering_id']) || isset($this->request->data['Events']['user_id'])
            || isset($this->request->data['Events']['date']) || isset($this->request->data['Events']['next_date'])
            || isset($this->request->data['Events']['created']) || isset($this->request->data['Events']['created1'])
            || isset($this->request->data['Events']['parc_id']) || isset($this->request->data['Events']['modified_id'])
            || isset($this->request->data['Events']['modified']) || isset($this->request->data['Events']['modified1'])
            || isset($this->request->data['Events']['pay_customer']) || isset($this->request->data['Events']['refund'])
            || isset($this->request->data['Events']['validated']) || isset($this->request->data['Events']['request'])
            || isset($this->request->data['Events']['severity_incident']) || isset($this->params['data']['conditions'])
            || isset($this->params['data']['conditions_car']) || isset($this->params['data']['conditions_customer'])
            || isset($this->request->data['Events']['profile_id'])
        ) {
            $this->filterUrl();
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->params['named']['keyword']) || isset($this->params['named']['type'])
            || isset($this->params['named']['car']) || isset($this->params['named']['user'])
            || isset($this->params['named']['customer']) || isset($this->params['named']['interfering'])
            || isset($this->params['named']['date']) || isset($this->params['named']['nextdate'])
            || isset($this->params['named']['created']) || isset($this->params['named']['created1'])
            || isset($this->params['named']['ids']) || isset($this->params['named']['parc'])
            || isset($this->params['named']['modified_id']) || isset($this->params['named']['profile_id'])
            || isset($this->params['named']['modified']) || isset($this->params['named']['modified1'])
            || isset($this->params['named']['pay_customer']) || isset($this->params['named']['refund'])
            || isset($this->request->data['named']['validated']) || isset($this->request->data['named']['request'])
            || isset($this->request->data['named']['severity']) || isset($this->params['named']['conditions'])
            || isset($this->params['named']['conditions_car']) || isset($this->params['named']['conditions_customer'])
        ) {
            $conditions = $this->getConds();
            if (isset($this->params['named']['conditions'])) {
                $conditions_index = unserialize(base64_decode($this->params['named']['conditions']));

                $conditions = array_merge($conditions, $conditions_index);
            } else {
                $conditions_index = null;
            }
            $this->paginate = array(
                'paramType' => 'querystring',
                'recursive' => -1, // should be used with joins
                'limit' => $limit,
                'order' => array('Event.id' => 'DESC'),
                'conditions' => $conditions,
                'fields' => array(
                    'Event.code',
                    'Event.id',
                    'Event.date',
                    'Event.next_date',
                    'Event.km',
                    'Event.next_km',
                    'Event.cost',
                    'Event.locked',
                    'Event.transferred',
                    'Event.validated',
                    'Event.canceled',
                    'Event.made_event',
                    'Event.interfering_id',
                    'Customer.id',
                    'Customer.first_name',
                    'Customer.last_name',
                    'Customer.company',
                    'Interfering.name',
                    'Car.code',
                    'Car.immatr_def',
                    'Event.user_id',
                    'Car.parc_id',
                    'Carmodel.name',
                    'EventType.name',
                    'Event.alert',
                    'Event.multiple_event',
                    'Event.attachment1',
                    'Event.attachment2',
                    'Event.attachment3',
                    'Event.attachment4',
                    'Event.attachment5'
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
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('Event.customer_id = Customer.id')
                    ),
                    array(
                        'table' => 'event_category_interfering',
                        'type' => 'left',
                        'alias' => 'EventCategoryInterfering',
                        'conditions' => array('EventCategoryInterfering.event_id = EventEventType.event_id')
                    ),
                    array(
                        'table' => 'interferings',
                        'type' => 'left',
                        'alias' => 'Interfering',
                        'conditions' => array('EventCategoryInterfering.interfering_id0 = Interfering.id')
                    ),
                    array(
                        'table' => 'interferings',
                        'type' => 'left',
                        'alias' => 'Interfering1',
                        'conditions' => array('EventCategoryInterfering.interfering_id1 = Interfering1.id')
                    ),
                    array(
                        'table' => 'interferings',
                        'type' => 'left',
                        'alias' => 'Interfering2',
                        'conditions' => array('EventCategoryInterfering.interfering_id2 = Interfering2.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),
                    array(
                        'table' => 'parcs',
                        'type' => 'left',
                        'alias' => 'Parc',
                        'conditions' => array('Car.parc_id = Parc.id')
                    )
                )
            );
            $events = $this->Paginator->paginate('EventEventType');
            $this->set('events', $events);
            $sumCost = $this->Event->getSumCost2($conditions);
        } else {
            $this->paginate = array(
                'paramType' => 'querystring',
                'recursive' => -1, // should be used with joins
                'limit' => $limit,
                'order' => array('Event.id' => 'DESC'),
                'fields' => array(
                    'Event.code',
                    'Event.id',
                    'Event.date',
                    'Event.next_date',
                    'Event.km',
                    'Event.next_km',
                    'Event.cost',
                    'Event.locked',
                    'Event.transferred',
                    'Event.validated',
                    'Event.canceled',
                    'Event.made_event',
                    'Customer.id',
                    'Customer.first_name',
                    'Customer.last_name',
                    'Customer.company',
                    'Interfering.name',
                    'Car.code',
                    'Car.immatr_def',
                    'Event.user_id',
                    'Car.parc_id',
                    'Carmodel.name',
                    'EventType.name',
                    'Event.alert',
                    'Event.multiple_event',
                    'Event.attachment1',
                    'Event.attachment2',
                    'Event.attachment3',
                    'Event.attachment4',
                    'Event.attachment5'
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
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('Event.customer_id = Customer.id')
                    ),
                    array(
                        'table' => 'event_category_interfering',
                        'type' => 'left',
                        'alias' => 'EventCategoryInterfering',
                        'conditions' => array('EventCategoryInterfering.event_id = EventEventType.event_id')
                    ),
                    array(
                        'table' => 'interferings',
                        'type' => 'left',
                        'alias' => 'Interfering',
                        'conditions' => array('EventCategoryInterfering.interfering_id0 = Interfering.id')
                    ),
                    array(
                        'table' => 'interferings',
                        'type' => 'left',
                        'alias' => 'Interfering1',
                        'conditions' => array('EventCategoryInterfering.interfering_id1 = Interfering1.id')
                    ),
                    array(
                        'table' => 'interferings',
                        'type' => 'left',
                        'alias' => 'Interfering2',
                        'conditions' => array('EventCategoryInterfering.interfering_id2 = Interfering2.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),
                    array(
                        'table' => 'parcs',
                        'type' => 'left',
                        'alias' => 'Parc',
                        'conditions' => array('Car.parc_id = Parc.id')
                    )
                )
            );
            $events = $this->Paginator->paginate('EventEventType');
            $this->set('events', $events);
            $sumCost = $this->Event->getSumCost2();
        }
        $interferings = $this->Interfering->getInterferingList();
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        if ($roleId != 3) {
            $administratifEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::administratif_evenement,
                ActionsEnum::view, $profileId, $roleId);
            $maintenanceEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::maintenance_evenement,
                ActionsEnum::view, $profileId, $roleId);
            if(($administratifEventPermission == 1) && ($maintenanceEventPermission == 1)){
                $eventTypes = $this->EventType->getEventTypes();
            }elseif(($administratifEventPermission == 1) && ($maintenanceEventPermission == 0)){
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id' => 8);
                $eventTypes = $this->EventType->getEventTypes('list', null , null , $eventTypeConditions);
            }elseif(($administratifEventPermission == 0) && ($maintenanceEventPermission == 1)){
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id !=' => 8);
                $eventTypes = $this->EventType->getEventTypes('list', null , null , $eventTypeConditions);
            }
        }else {
            $eventTypes = $this->EventType->getEventTypes();
        }
        $param = $this->Parameter->getCodesParameterVal('name_car');

        if (isset($this->params['named']['conditions_car'])) {
            $conditions_car = unserialize(base64_decode($this->params['named']['conditions_car']));
        } else {
            $conditions_car = null;
        }
        $cars = $this->Car->getCarsByFieldsAndConds($param, null, $conditions_car, null);

        $fields = "names";

        if (isset($this->params['named']['conditions_customer'])) {
            $conditions_customer = unserialize(base64_decode($this->params['named']['conditions_customer']));
        } else {
            $conditions_customer = null;

        }
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions_customer);

        $users = $this->Event->User->find('list', array('conditions' => array('User.id !=' => 1)));
        $profiles = $this->Profile->getUserProfiles();
        $userId = intval($this->Auth->user('id'));
        $parcIds = $this->getParcsUserIdsArray($userId);
        if (!empty($parcIds)) {
            $parcs = $this->Parc->getParcByIds($parcIds);
        } else {
            $parcs = $this->Parc->getParcs('list');
        }
        $nb_parcs = count($parcIds);
        $hasParc = $this->verifyUserParcPermission(SectionsEnum::demande_intervention);
        $isSuperAdmin = $this->isSuperAdmin();
        $permissionValidate = $this->AccessPermission->getPermissionWithParams(SectionsEnum::valider_demande_intervention,
            ActionsEnum::view, $profileId, $roleId);
        $permissionCancel = $this->AccessPermission->getPermissionWithParams(SectionsEnum::annuler_demande_intervention,
            ActionsEnum::view, $profileId, $roleId);
        $permissionTransfer = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transferer_demande_intervention,
            ActionsEnum::view, $profileId, $roleId);
        $permissionMakeEvent = $this->AccessPermission->getPermissionWithParams(SectionsEnum::rendre_demande_intervention_evenement,
            ActionsEnum::view, $profileId, $roleId);
        $printInterventionRequest = $this->AccessPermission->getPermissionWithParams(SectionsEnum::demande_intervention,
            ActionsEnum::printing, $profileId, $roleId);
        $editKmDate = $this->AccessPermission->getPermissionWithParams(SectionsEnum::modification_km_date,
            ActionsEnum::view, $profileId, $roleId);
        $this->set(compact('profiles', 'cars', 'customers', 'users',
            'interferings', 'eventTypes', 'sumCost', 'limit','editKmDate',
            'parcs', 'hasParc', 'nb_parcs', 'param', 'conditions_index',
            'conditions_car', 'conditions_customer', 'isSuperAdmin', 'conditions_index',
        'permissionValidate','permissionCancel','permissionTransfer','permissionMakeEvent','printInterventionRequest'
            ));
        $this->render();
    }

    private function filterUrl()
    {
        $filter_url['controller'] = $this->request->params['controller'];
        $filter_url['action'] = $this->request->params['action'];
        $filter_url['page'] = 1;
        $filter_url['keyword'] = $this->request->data['keyword'];
        $filter_url['keyword'] = str_replace('/', '-', $filter_url['keyword']);
        $filter_url['conditions'] = $this->params['data']['conditions'];
        $filter_url['conditions_car'] = $this->params['data']['conditions_car'];
        $filter_url['conditions_customer'] = $this->params['data']['conditions_customer'];
        if (isset($this->request->data['Events']['event_type_id']) && !empty($this->request->data['Events']['event_type_id'])) {
            $filter_url['type'] = $this->request->data['Events']['event_type_id'];
        }
        if (isset($this->request->data['Events']['car_id']) && !empty($this->request->data['Events']['car_id'])) {
            $filter_url['car'] = $this->request->data['Events']['car_id'];
        }
        if (isset($this->request->data['Events']['customer_id']) && !empty($this->request->data['Events']['customer_id'])) {
            $filter_url['customer'] = $this->request->data['Events']['customer_id'];
        }
        if (isset($this->request->data['Events']['interfering_id']) && !empty($this->request->data['Events']['interfering_id'])) {
            $filter_url['interfering'] = $this->request->data['Events']['interfering_id'];
        }
        if (isset($this->request->data['Events']['parc_id']) && !empty($this->request->data['Events']['parc_id'])) {
            $filter_url['parc'] = $this->request->data['Events']['parc_id'];
        }
        if (isset($this->request->data['Events']['user_id']) && !empty($this->request->data['Events']['user_id'])) {
            $filter_url['user'] = $this->request->data['Events']['user_id'];
        }
        if (isset($this->request->data['Events']['profile_id']) && !empty($this->request->data['Events']['profile_id'])) {
            $filter_url['profile'] = $this->request->data['Events']['profile_id'];
        }
        if (isset($this->request->data['Events']['date']) && !empty($this->request->data['Events']['date'])) {
            $filter_url['date'] = str_replace("/", "-", $this->request->data['Events']['date']);
        }
        if (isset($this->request->data['Events']['next_date']) && !empty($this->request->data['Events']['next_date'])) {
            $filter_url['nextdate'] = str_replace("/", "-", $this->request->data['Events']['next_date']);
        }
        if (isset($this->request->data['Events']['date3']) && !empty($this->request->data['Events']['date3'])) {
            $filter_url['date3'] = str_replace("/", "-", $this->request->data['Events']['date3']);
        }
        if (isset($this->request->data['Events']['created']) && !empty($this->request->data['Events']['created'])) {
            $filter_url['created'] = str_replace("/", "-", $this->request->data['Events']['created']);
        }
        if (isset($this->request->data['Events']['created1']) && !empty($this->request->data['Events']['created1'])) {
            $filter_url['created1'] = str_replace("/", "-", $this->request->data['Events']['created1']);
        }
        if (isset($this->request->data['Events']['modified_id']) && !empty($this->request->data['Events']['modified_id'])) {
            $filter_url['modified_id'] = $this->request->data['Events']['modified_id'];
        }
        if (isset($this->request->data['Events']['modified']) && !empty($this->request->data['Events']['modified'])) {
            $filter_url['modified'] = str_replace("/", "-", $this->request->data['Events']['modified']);
        }
        if (isset($this->request->data['Events']['modified1']) && !empty($this->request->data['Events']['modified1'])) {
            $filter_url['modified1'] = str_replace("/", "-", $this->request->data['Events']['modified1']);
        }
        if (isset($this->request->data['Events']['pay_customer']) && !empty($this->request->data['Events']['pay_customer'])) {
            $filter_url['pay_customer'] = $this->request->data['Events']['pay_customer'];
        }
        if (isset($this->request->data['Events']['refund']) && !empty($this->request->data['Events']['refund'])) {
            $filter_url['refund'] = $this->request->data['Events']['refund'];
        }
        if (isset($this->request->data['Events']['validated']) && !empty($this->request->data['Events']['validated'])) {
            $filter_url['validated'] = $this->request->data['Events']['validated'];
        }
        if (isset($this->request->data['Events']['request']) && !empty($this->request->data['Events']['request'])) {
            $filter_url['request'] = $this->request->data['Events']['request'];
        }
        if (isset($this->request->data['Events']['severity_incident']) && !empty($this->request->data['Events']['severity_incident'])) {
            $filter_url['severity'] = $this->request->data['Events']['severity_incident'];
        }
        if (isset($this->request->data['Events']['status_id']) && !empty($this->request->data['Events']['status_id'])) {
            $filter_url['status'] = $this->request->data['Events']['status_id'];
        }
        if (isset($this->request->data['Events']['km']) && !empty($this->request->data['Events']['km'])) {
            $filter_url['km'] = $this->request->data['Events']['km'];
        }
        if (isset($this->request->data['Events']['km_to']) && !empty($this->request->data['Events']['km_to'])) {
            $filter_url['km_to'] = $this->request->data['Events']['km_to'];
        }
        if (isset($this->request->data['Events']['next_km']) && !empty($this->request->data['Events']['next_km'])) {
            $filter_url['next_km'] = $this->request->data['Events']['next_km'];
        }
        if (isset($this->request->data['Events']['next_km_to']) && !empty($this->request->data['Events']['next_km_to'])) {
            $filter_url['next_km_to'] = $this->request->data['Events']['next_km_to'];
        }
        if (isset($this->request->data['Events']['cost']) && !empty($this->request->data['Events']['cost'])) {
            $filter_url['cost'] = $this->request->data['Events']['cost'];
        }
        if (isset($this->request->data['Events']['cost_to']) && !empty($this->request->data['Events']['cost_to'])) {
            $filter_url['cost_to'] = $this->request->data['Events']['cost_to'];
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
                    "LOWER(Customer.first_name) LIKE" => "%$keyword%",
                    "LOWER(Event.code) LIKE" => "%$keyword%",
                    "LOWER(Customer.last_name) LIKE" => "%$keyword%",
                    "LOWER(Car.immatr_def) LIKE" => "%$keyword%",
                    "LOWER(Car.code) LIKE" => "%$keyword%",
                    "LOWER(Interfering.name) LIKE" => "%$keyword%",
                    "LOWER(EventType.name) LIKE" => "%$keyword%",
                    "LOWER(Carmodel.name) LIKE" => "%$keyword%"
                )
            );
        } else {
            $conds = array();
        }
        if (isset($this->params['named']['ids'])) {
            if ($this->params['named']['ids'] === 0) {
                $conds["Event.id = "] = 0;
            } else {
                $conds["Event.id "] = $this->params['named']['ids'];
            }
        }
        if (isset($this->params['named']['type']) && !empty($this->params['named']['type'])) {
            $conds["EventEventType.event_type_id = "] = $this->params['named']['type'];
            $this->request->data['Events']['event_type_id'] = $this->params['named']['type'];
        }
        if (isset($this->params['named']['car']) && !empty($this->params['named']['car'])) {
            $conds["Event.car_id = "] = $this->params['named']['car'];
            $this->request->data['Events']['car_id'] = $this->params['named']['car'];
        }
        if (isset($this->params['named']['customer']) && !empty($this->params['named']['customer'])) {
            $conds["Event.customer_id = "] = $this->params['named']['customer'];
            $this->request->data['Events']['customer_id'] = $this->params['named']['customer'];
        }
        if (isset($this->params['named']['interfering']) && !empty($this->params['named']['interfering'])) {
            $conds = array(
                'OR' => array(
                    "EventCategoryInterfering.interfering_id0 = " => $this->params['named']['interfering'],
                    "EventCategoryInterfering.interfering_id1 = " => $this->params['named']['interfering'],
                    "EventCategoryInterfering.interfering_id2 = " => $this->params['named']['interfering'],
                    "Event.interfering_id = " => $this->params['named']['interfering'],
                )
            );
            $this->request->data['Events']['interfering_id'] = $this->params['named']['interfering'];
        }
        if (isset($this->params['named']['parc']) && !empty($this->params['named']['parc'])) {
            $conds["Car.parc_id = "] = $this->params['named']['parc'];
            $this->request->data['Events']['parc_id'] = $this->params['named']['parc'];
        }
        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $conds["Event.user_id = "] = $this->params['named']['user'];
            $this->request->data['Events']['user_id'] = $this->params['named']['user'];
        }

        if (isset($this->params['named']['profile']) && !empty($this->params['named']['profile'])) {
            $conds["User.profile_id = "] = $this->params['named']['profile'];
            $this->request->data['Events']['profile_id'] = $this->params['named']['profile'];
        }

        if (isset($this->params['named']['date']) && !empty($this->params['named']['date'])) {
            $start = str_replace("-", "/", $this->params['named']['date']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $conds["Event.date >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Events']['date'] = $start;
        }
        if (isset($this->params['named']['nextdate']) && !empty($this->params['named']['nextdate'])) {
            $end = str_replace("-", "/", $this->params['named']['nextdate']);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $conds["Event.next_date <= "] = $enddtm->format('Y-m-d 00:00:00');
            $this->request->data['Events']['next_date'] = $end;
        }
        if (isset($this->params['named']['date3']) && !empty($this->params['named']['date3'])) {
            $start3 = str_replace("-", "/", $this->params['named']['date3']);
            $startdtm3 = DateTime::createFromFormat('d/m/Y', $start3);
            $conds["Event.date3 <= "] = $startdtm3->format('Y-m-d 00:00:00');
            $this->request->data['Events']['date3'] = $start3;
        }
        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $creat = str_replace("-", "/", $this->params['named']['created']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Event.created >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Events']['created'] = $creat;
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $creat = str_replace("-", "/", $this->params['named']['created1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Event.created <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Events']['created1'] = $creat;
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $conds["Event.modified_id = "] = $this->params['named']['modified_id'];
            $this->request->data['Events']['modified_id'] = $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Event.modified >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Events']['modified'] = $creat;
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Event.modified <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Events']['modified1'] = $creat;
        }
        if (isset($this->params['named']['pay_customer']) && !empty($this->params['named']['pay_customer'])) {
            if ($this->params['named']['pay_customer'] == 2) {
                $conds["Event.pay_customer = "] = 0;
                $this->request->data['Events']['pay_customer'] = 2;

            }
            if ($this->params['named']['pay_customer'] == 1) {
                $conds["Event.pay_customer = "] = 1;
                $this->request->data['Events']['pay_customer'] = 1;

            }


        }
        if (isset($this->params['named']['refund']) && !empty($this->params['named']['refund'])) {

            if ($this->params['named']['refund'] == 2) {

                $conds["Event.refund = "] = 0;
                $this->request->data['Events']['refund'] = 2;
            }
            if ($this->params['named']['refund'] == 1) {

                $conds["Event.refund = "] = 1;
                $this->request->data['Events']['refund'] = 1;
            }
        }
        if (isset($this->params['named']['validated']) && !empty($this->params['named']['validated'])) {
            $conds["Event.validated = "] = $this->params['named']['validated'];
            $this->request->data['Events']['validated'] = $this->params['named']['validated'];
        }
        if (isset($this->params['named']['request']) && !empty($this->params['named']['request'])) {
            $conds["Event.request = "] = $this->params['named']['request'];
            $this->request->data['Events']['request'] = $this->params['named']['request'];
        }
        if (isset($this->params['named']['severity']) && !empty($this->params['named']['severity'])) {
            $conds["Event.severity_incident = "] = $this->params['named']['severity'];
            $this->request->data['Events']['severity_incident'] = $this->params['named']['severity'];
        }
        if (isset($this->params['named']['status']) && !empty($this->params['named']['status'])) {
            $conds["Event.status_id = "] = $this->params['named']['status'];
            $this->request->data['Events']['status_id'] = $this->params['named']['status'];
        }
        if (isset($this->params['named']['km']) && !empty($this->params['named']['km'])) {
            $conds["Event.km >= "] = $this->params['named']['km'];
            $this->request->data['Events']['km'] = $this->params['named']['km'];
        }

        if (isset($this->params['named']['km_to']) && !empty($this->params['named']['km_to'])) {
            $conds["Event.km <= "] = $this->params['named']['km_to'];
            $this->request->data['Events']['km_to'] = $this->params['named']['km_to'];
        }

        if (isset($this->params['named']['next_km']) && !empty($this->params['named']['next_km'])) {
            $conds["Event.next_km >= "] = $this->params['named']['next_km'];
            $this->request->data['Events']['next_km'] = $this->params['named']['next_km'];
        }

        if (isset($this->params['named']['next_km_to']) && !empty($this->params['named']['next_km_to'])) {
            $conds["Event.next_km <= "] = $this->params['named']['next_km_to'];
            $this->request->data['Events']['next_km_to'] = $this->params['named']['next_km_to'];
        }

        if (isset($this->params['named']['cost']) && !empty($this->params['named']['cost'])) {
            $conds["Event.cost >= "] = $this->params['named']['cost'];
            $this->request->data['Events']['cost'] = $this->params['named']['cost'];
        }

        if (isset($this->params['named']['cost_to']) && !empty($this->params['named']['cost_to'])) {
            $conds["Event.cost <= "] = $this->params['named']['cost_to'];
            $this->request->data['Events']['cost_to'] = $this->params['named']['cost_to'];
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
        $this->setTimeActif();
        if (!$this->Event->exists($id)) {
            throw new NotFoundException(__('Invalid event'));
        }
        $event = $this->Event->find('first',
            array(
                'recursive' => -1,
                'paramType' => 'querystring',
                'conditions' => array('Event.' . $this->Event->primaryKey => $id),
                'fields' => array(
                    'Event.code',
                    'Event.id',
                    'Event.date',
                    'Event.next_date',
                    'Event.date3',
                    'Event.km',
                    'Event.next_km',
                    'Event.cost',
                    'Event.locked',
                    'Event.transferred',
                    'Event.car_id',
                    'Event.customer_id',
                    'Customer.id',
                    'Customer.first_name',
                    'Customer.last_name',
                    'Customer.company',
                    'Interfering.name',
                    'Car.code',
                    'Event.validated',
                    'Car.km',
                    'Car.immatr_def',
                    'Event.user_id',
                    'Car.parc_id',
                    'Carmodel.name',
                    'EventType.name',
                    'Event.alert',
                    'Car.vidange_hour',
                    'Car.hours',
                    'Event.multiple_event',
                    'Event.attachment1',
                    'Event.attachment2',
                    'Event.attachment3',
                    'Event.attachment4',
                    'Event.attachment5',
                    'Event.date_refund',
                    'EventEventType.event_type_id',
                    'EventType.with_km',
                    'EventType.with_date',
                    'EventType.code',
                    'Event.request',
                    'Event.transferred',
                    'Event.created',
                    'Event.modified',
                    'Event.dommages_corporels',
                    'Event.sinistre_type',
                    'Event.severity_incident',
                    'Event.payed',
                    'Event.contravention_type_id',
                    'Event.place',
                    'Event.date_refund',
                    'Event.refund',
                    'Event.pay_customer',
                    'User.first_name',
                    'UserModifier.first_name',
                    'User.last_name',
                    'UserModifier.last_name'
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
                        'table' => 'interferings',
                        'type' => 'left',
                        'alias' => 'Interfering',
                        'conditions' => array('Event.interfering_id = Interfering.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),
                    array(
                        'table' => 'parcs',
                        'type' => 'left',
                        'alias' => 'Parc',
                        'conditions' => array('Car.parc_id = Parc.id')
                    ),
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('Event.user_id = User.id')
                    ),
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'UserModifier',
                        'conditions' => array('Event.modified_id = UserModifier.id')
                    )
                )
            ));
        $this->set('event', $event);
        $this->Bill->recursive = 2;
        $bill = $this->Bill->find('first', array('conditions' => array('Bill.event_id' => $id)));
        if (!empty($bill)) {
            $bill_id = $bill['Bill']['id'];
            $billProducts = $this->BillProduct->find('all',
                array('conditions' => array('BillProduct.bill_id' => $bill_id), 'recursive' => 2));
        }
        if (Configure::read("gestion_commercial") == '1'  &&
            Configure::read("tresorerie") == '1') {
            $payments = $this->Payment->find('all',
                array('conditions' => array('Payment.event_id' => $id), 'recursive' => 1));

            $this->set('payments', $payments);
        }
        $haspermission = $this->verifyAudit(SectionsEnum::evenement);

        if ($event ['Event']['request'] == 0) {

            $this->Audit->recursive = 2;
            $this->paginate = array(
                'recursive' => -1,
                'limit' => 5,
                'fields' => array(
                    'User.id',
                    'User.first_name',
                    'User.last_name',
                    'Audit.created'
                ),
                'joins' => array(
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('Audit.user_id = User.id')
                    )
                ),
                'conditions' => array('article_id' => $id, 'rubric_id' => 6),
                'paramType' => 'querystring',

            );


            $audits = $this->Paginator->paginate('Audit', "Audit.user_id != 1");

            $this->set('audits', $audits);

        }
        $eventCategoryInterferings = $this->EventCategoryInterfering->find('all', array(
            'conditions' => array('event_id' => $id),
            'recursive' => -1,
            'fields' => array(
                'EventCategoryInterfering.interfering_id1',
                'EventCategoryInterfering.interfering_id2',
                'EventCategoryInterfering.interfering_id0',
                'EventTypeCategory.name',
                'Interfering.name',
                'EventTypeCategory.name',
                'EventCategoryInterfering.cost'
            ),
            'joins' => array(
                array(
                    'table' => 'event_type_categories',
                    'type' => 'left',
                    'alias' => 'EventTypeCategory',
                    'conditions' => array('EventCategoryInterfering.event_type_category_id = EventTypeCategory.id')
                ),
                array(
                    'table' => 'interferings',
                    'type' => 'left',
                    'alias' => 'Interfering',
                    'conditions' => array('EventCategoryInterfering.interfering_id0 = Interfering.id')
                ),
                array(
                    'table' => 'interferings',
                    'type' => 'left',
                    'alias' => 'Interfering1',
                    'conditions' => array('EventCategoryInterfering.interfering_id1 = Interfering1.id')
                ),
                array(
                    'table' => 'interferings',
                    'type' => 'left',
                    'alias' => 'Interfering2',
                    'conditions' => array('EventCategoryInterfering.interfering_id2 = Interfering2.id')
                )
            )
        ));
        $this->set('eventcategoryinterferings', $eventCategoryInterferings);
        $this->set(compact('haspermission', 'bill', 'billProducts'));
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set('param', $param);
    }    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function printRequest($id = null)
    {
        $this->setTimeActif();
        if (!$this->Event->exists($id)) {
            throw new NotFoundException(__('Invalid event'));
        }
        $event = $this->Event->find('first',
            array(
                'recursive' => -1,
                'paramType' => 'querystring',
                'conditions' => array('Event.' . $this->Event->primaryKey => $id),
                'fields' => array(
                    'Event.code',
                    'Event.id',
                    'Event.date',
                    'Event.next_date',
                    'Event.date3',
                    'Event.km',
                    'Event.next_km',
                    'Event.cost',
                    'Event.obs',
                    'Interfering.name',
                    'Interfering.adress',
                    'Car.code',
                    'Car.km',
                    'Car.immatr_def',
                    'Carmodel.name',
                    'EventType.name',
                    'Car.vidange_hour',
                    'Car.hours',
                    'EventType.with_km',
                    'EventType.with_date',
                    'EventType.code',
                    'Event.request',
                    'Event.transferred',
                    'Event.validated',
                    'Event.canceled',
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
                        'table' => 'interferings',
                        'type' => 'left',
                        'alias' => 'Interfering',
                        'conditions' => array('Event.interfering_id = Interfering.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    )
                )
            ));
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
            'conditions' => array('article_id' => $id, 'rubric_id' => SectionsEnum::demande_intervention),


        ));
        $event['Event']['date'] = DateTime::createFromFormat('Y-m-d H:i:s',$event['Event']['date']);
        $event['Event']['date'] = $event['Event']['date']->format('d/m/Y');
        $this->set('event', $event);
        $company = $this->Company->find('first');

        $wilayaId = $company['Company']['wilaya'];
        if(!empty($wilayaId)){
            $this->loadModel('Destination');
            $destination = $this->Destination->find('first', array('conditions' => array('Destination.id' => $wilayaId)));
            $wilayaName = $destination['Destination']['name'];
        }else {
            $wilayaName ='';
        }
        $entete_pdf = $this->Parameter->getCodesParameterVal('entete_pdf');
        $this->set(compact('company','entete_pdf','wilayaName','audits'));


    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        $this->setTimeActif();
        $this->Payment->validate = $this->Payment->validate_car;
        // get user id
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        $administratifEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::administratif_evenement,
            ActionsEnum::add, $profileId, $roleId);
        if($administratifEventPermission==0){
            $maintenanceEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::maintenance_evenement,
                ActionsEnum::add, $profileId, $roleId);
            if($maintenanceEventPermission==0){
                $this->Flash->error(__("You don't have permission to add."));
                $this->redirect(array('action' => 'index'));
            }
        }
        $userId = intval($this->Auth->user('id'));
        $parcIds = $this->getParcsUserIdsArray($userId);

        // if the call is from cancel button
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        $version_of_app = $this->getVersionOfApp();
        if ($this->request->is('post')) {

            $this->Event->create();
            $this->createDatetimeFromDate('Event', 'date');
            $this->createDatetimeFromDate('Event', 'next_date');
            $this->createDatetimeFromDate('Event', 'date3');
            $this->createDatetimeFromDatetime('Event', 'workshop_entry_date');
            $this->createDatetimeFromDatetime('Event', 'workshop_exit_date');
            $this->createDateFromDate('Event', 'reception_date');
            $this->createDateFromDate('Event', 'intervention_date');

            if(isset($this->request->data['Event']['alert_type'])){
                if ($this->request->data['Event']['alert_type'] == '0'){
                    $this->createDatetimeFromDate('Event', 'last_event_date');
                }
            }
            $this->request->data['Event']['user_id'] = $this->Session->read('Auth.User.id');
            $i = 1;
            foreach ($this->request->data['Event']['attachment'] as $attachment) {
                $this->request->data['Event']['attachment' . $i] = $attachment;
                $this->verifyAttachment('Event', 'attachment' . $i, 'attachments/events/', 'add', 0, 0, null);
                $i++;
            }
            if ($version_of_app == 'web') {
                if ($this->request->data['Event']['attachment1'] == '') {
                    if (isset($this->request->data['Event']['attachment1_dir'])) {
                        $this->request->data['Event']['attachment1'] = $this->request->data['Event']['attachment1_dir'];
                    }
                }
                if (isset($this->request->data['Event']['attachment2']) && $this->request->data['Event']['attachment2'] == '') {
                    if (isset($this->request->data['Event']['attachment2_dir'])) {
                        $this->request->data['Event']['attachment2'] = $this->request->data['Event']['attachment2_dir'];
                    }
                }
                if (isset($this->request->data['Event']['attachment3']) && $this->request->data['Event']['attachment3'] == '') {
                    if (isset($this->request->data['Event']['attachment3_dir'])) {
                        $this->request->data['Event']['attachment3'] = $this->request->data['Event']['attachment3_dir'];
                    }
                }
                if (isset($this->request->data['Event']['attachment4']) && $this->request->data['Event']['attachment4'] == '') {
                    if (isset($this->request->data['Event']['attachment4_dir'])) {
                        $this->request->data['Event']['attachment4'] = $this->request->data['Event']['attachment4_dir'];
                    }
                }
                if (isset($this->request->data['Event']['attachment5']) && $this->request->data['Event']['attachment5'] == '') {
                    if (isset($this->request->data['Event']['attachment5_dir'])) {
                        $this->request->data['Event']['attachment5'] = $this->request->data['Event']['attachment5_dir'];
                    }
                }
            }
            $this->request->data['Event']['request'] = 0;
            $this->request->data['Event']['multiple_event'] = 0;
            $this->request->data['Event']['validated'] = 1;
            $this->request->data['Event']['transferred'] = 1;
            $this->request->data['Event']['made_event'] = 1;
            if ($this->request->data['Event']['pay_customer'] == 0) {
                $this->request->data['Event']['refund'] = 0;
            }
            if((isset($this->request->data['Event']['workshop_entry_date'])&&
                !empty($this->request->data['Event']['workshop_entry_date'])) ||
                (isset($this->request->data['Event']['workshop_exit_date'])&&
                    !empty($this->request->data['Event']['workshop_exit_date']))
            ){
                $entryDate = $this->request->data['Event']['workshop_entry_date'];
                $exitDate = $this->request->data['Event']['workshop_exit_date'];
                $this->request->data['Event']['status_id'] = $this->getStatusEvent($entryDate, $exitDate);
            }

            // Save the event
           /* unset($this->request->data['Bill']);
            unset($this->request->data['BillProduct']);*/

            if ($this->Event->save($this->request->data)) {
                $this->Parameter->setNextEventReferenceNumber('event');
                $event_id = $this->Event->getInsertID();
                if((isset($entryDate)&& !empty($entryDate)) ||
                    (isset($exitDate)&& !empty($exitDate))
                )
                    {
                    $entryDate = $this->request->data['Event']['workshop_entry_date'];
                    $exitDate = $this->request->data['Event']['workshop_exit_date'];
                    $carStatusId = $this->getStatusCar($this->request->data['Event']['car_id'], $entryDate, $exitDate);
                    $statusRepairId = 25;
                    $this->addCarCarStatus($this->request->data['Event']['car_id'], $statusRepairId, $entryDate,$exitDate,$event_id);
                    if($carStatusId==$statusRepairId){
                        $this->updateStatusCar($this->request->data['Event']['car_id'],$carStatusId,$entryDate,$exitDate);
                    }
                }
                $this->loadModel('EventProduct');
                if (isset($this->request->data['EventTypeProduct'])) {

                foreach ($this->request->data['EventTypeProduct'] as $product) {
                    if ($product['quantity'] == '0' && isset($product['id']) && !empty($product['id'])) {
                        $this->EventTypeProduct->delete($product['id']);
                    } else {
                        $this->EventTypeProduct->create();
                        $this->EventProduct->create();
                        $product['event_type_id'] = $this->request->data['Event']['event_types'];
                        $this->EventTypeProduct->save($product);
                        unset($product['id']);
                        unset($product['event_type_id']);
                        $product['event_id'] = $event_id;
                        $this->EventProduct->save($product);
                        $repairProduct = $this->Product->find('all', array('conditions' => array('Product.id' => $product['product_id'])));
                        $newQuantity = intval($repairProduct[0]['Product']['quantity']) - intval($product['quantity']);
                        $this->Product->id = $product['product_id'];
                        $this->Product->saveField('quantity', $newQuantity);
                    }
                }
            }
                $this->EventEventType->create();
                $data = array();
                $data['EventEventType']['event_id'] = $event_id;
                $data['EventEventType']['event_type_id'] = $this->request->data['Event']['event_types'];
                $this->EventEventType->save($data);
                if (Configure::read("gestion_commercial") == '1'  &&
                    Configure::read("tresorerie") == '1') {
                    $type_event = $this->request->data['Event']['event_types'];
                    $event_type = $this->EventType->getEventTypeById($type_event);
                    $transact_type_id = $event_type['EventType']['transact_type_id'];
                    $nb_payment = $this->request->data['Event']['nb_payment'];
                    if ($nb_payment == 0) {
                        if (!empty ($this->request->data['Payment'][0]['interfering_id']) && !empty ($this->request->data['Payment'][0]['compte_id']) &&
                            !empty($this->request->data['Payment'][0]['amount']) && !empty($this->request->data['Payment'][0]['receipt_date']) &&
                            !empty($this->request->data['Payment'][0]['payment_type'])
                        ) {
                            $this->request->data['Payment']['receipt_date'] = $this->request->data['Payment'][0]['receipt_date'];
                            $this->createDateFromDate('Payment', 'receipt_date');
                            if (Configure::read("cafyb") == '1') {
                                $thirdPartyId = $this->Interfering->getThirdPartyIdByInterferingId($this->request->data['Payment'][0]['interfering_id']);
                                $payment['event_id'] = $event_id;
                                $payment['third_party_id'] = $thirdPartyId;
                                $payment['account_id'] = $this->request->data['Payment'][0]['compte_id'];
                                $payment['label'] = 'Evenement ' . $this->request->data['Payment'][0]['reference'];
                                $payment['receipt_date'] = $this->request->data['Payment']['receipt_date'];
                                $payment['amount'] = $this->request->data['Payment'][0]['amount'];
                                $payment['payment_method_id'] = $this->request->data['Payment'][0]['payment_type'];
                                $payment['payment_type_id'] = $transact_type_id;
                                if ($payment['payment_method_id'] == '1') {
                                    $payment['payment_status_id'] = 1;
                                } else {
                                    $payment['payment_status_id'] = '';
                                }
                                $payment['payment_category_id'] = '';
                                $payment['note'] = $this->request->data['Payment'][0]['note'];
                                $this->Cafyb->addPayment($payment);
                            } else {
                                $this->Payment->create();
                                $data['Payment']['event_id'] = $event_id;
                                $data['Payment']['interfering_id'] = $this->request->data['Payment'][0]['interfering_id'];
                                $data['Payment']['compte_id'] = $this->request->data['Payment'][0]['compte_id'];
                                $data['Payment']['wording'] = $this->request->data['Payment'][0]['reference'];
                                $data['Payment']['user_id'] = $this->Session->read('Auth.User.id');
                                $data['Payment']['receipt_date'] = $this->request->data['Payment']['receipt_date'];
                                $data['Payment']['amount'] = $this->request->data['Payment'][0]['amount'];
                                $data['Payment']['payment_type'] = $this->request->data['Payment'][0]['payment_type'];
                                $data['Payment']['transact_type_id'] = $transact_type_id;
                                $data['Payment']['payment_association_id'] = 2;
                                $data['Payment']['note'] = $this->request->data['Payment'][0]['note'];
                                $this->Payment->save($data);
                            }
                        }
                    } else {
                        for ($i = 0; $i <= $nb_payment; $i++) {
                            if ($this->request->data['Payment'][$i]) {
                                if (!empty ($this->request->data['Payment'][$i]['interfering_id']) && !empty ($this->request->data['Payment'][$i]['compte_id']) &&
                                    !empty($this->request->data['Payment'][$i]['amount']) && !empty($this->request->data['Payment'][$i]['receipt_date']) &&
                                    !empty($this->request->data['Payment'][$i]['payment_type'])
                                ) {
                                    $this->request->data['Payment']['receipt_date'] = $this->request->data['Payment'][0]['receipt_date'];
                                    $this->createDateFromDate('Payment', 'receipt_date');
                                    if (Configure::read("cafyb") == '1') {
                                        $thirdPartyId = $this->Interfering->getThirdPartyIdByInterferingId($this->request->data['Payment'][0]['interfering_id']);
                                        $payment['event_id'] = $event_id;
                                        $payment['third_party_id'] = $thirdPartyId;
                                        $payment['account_id'] = $this->request->data['Payment'][$i]['compte_id'];
                                        $payment['label'] = 'Evenement ' . $this->request->data['Payment'][$i]['reference'];
                                        $payment['receipt_date'] = $this->request->data['Payment']['receipt_date'];
                                        $payment['amount'] = $this->request->data['Payment'][$i]['amount'];
                                        $payment['payment_method_id'] = $this->request->data['Payment'][$i]['payment_type'];
                                        $payment['payment_type_id'] = $transact_type_id;
                                        if ($payment['payment_method_id'] == '1') {
                                            $payment['payment_status_id'] = 1;
                                        } else {
                                            $payment['payment_status_id'] = '';
                                        }
                                        $payment['payment_category_id'] = '';
                                        $payment['note'] = $this->request->data['Payment'][$i]['note'];
                                        $this->Cafyb->addPayment($payment);
                                    } else {
                                        $this->Payment->create();
                                        $data['Payment']['event_id'] = $event_id;
                                        $data['Payment']['interfering_id'] = $this->request->data['Payment'][$i]['interfering_id'];
                                        $data['Payment']['compte_id'] = $this->request->data['Payment'][$i]['compte_id'];
                                        $data['Payment']['wording'] = $this->request->data['Payment'][$i]['reference'];
                                        $data['Payment']['user_id'] = $this->Session->read('Auth.User.id');
                                        $data['Payment']['receipt_date'] = $this->request->data['Payment']['receipt_date'];
                                        $data['Payment']['amount'] = $this->request->data['Payment'][$i]['amount'];
                                        $data['Payment']['payment_type'] = $this->request->data['Payment'][$i]['payment_type'];
                                        $data['Payment']['transact_type_id'] = $transact_type_id;
                                        $data['Payment']['payment_association_id'] = 2;
                                        $data['Payment']['note'] = $this->request->data['Payment'][$i]['note'];
                                        $this->Payment->save($data);
                                    }
                                }
                            }
                        }
                    }
                }
                $interferingId = null;
                if (!empty($this->request->data['EventCategoryInterfering'])) {
                    $EventCategoryInterfering = $this->request->data['EventCategoryInterfering'][0];
                         $this->EventCategoryInterfering->create();
                        $data = array();
                        $data['EventCategoryInterfering']['event_id'] = $event_id;
                        $data['EventCategoryInterfering']['interfering_id0'] = $EventCategoryInterfering['interfering_id0'];
                        if (isset($EventCategoryInterfering['interfering_id1'])) {
                            $data['EventCategoryInterfering']['interfering_id1'] = $EventCategoryInterfering['interfering_id1'];
                        }
                        if (isset($EventCategoryInterfering['interfering_id2'])) {
                            $data['EventCategoryInterfering']['interfering_id2'] = $EventCategoryInterfering['interfering_id2'];
                        }
                        $data['EventCategoryInterfering']['event_type_category_id'] = $EventCategoryInterfering['event_type_category'];
                        $data['EventCategoryInterfering']['cost'] = $EventCategoryInterfering['cost'];
                        $this->EventCategoryInterfering->save($data);
                    $interferingId = $EventCategoryInterfering['interfering_id0'];
                }
                $event_id = $this->Event->getInsertID();
                if (isset($this->request->data['Bill'])) {
                    $internalExternal = $this->request->data['Event']['internal_external'];
                    if($internalExternal==1){
                        $mechanicianId =  $this->request->data['Event']['mechanician_id'];
                        if(!empty($mechanicianId)){
                            $thirdPartyId = $this->Customer->getThirdPartyIdByCustomerId($mechanicianId);
                        }else {
                            $thirdPartyId =null;
                        }
                    }else {
                        if(!empty($interferingId)){
                            $thirdPartyId = $this->Interfering->getThirdPartyIdByInterferingId($interferingId);
                        }else{
                            $thirdPartyId = null;
                        }
                    }
                    $this->addProductEvent($this->request->data['Bill'], $this->request->data['Product'], $event_id, $internalExternal, $thirdPartyId );
                }
                $this->setCarPersistence($this->request->data['Event']['car_id']);
                $this->Flash->success(__('The event has been saved.'));
                // Trigger alerts
                $this->setSessionAlerts($this->request->data['Event']['car_id'],$this->request->data['Event']['event_types'] , $event_id);
                $this->getTotalNbAlerts();
                // Disable old event alert with the same car and type event
                //$this->disableAlerts($this->request->data['Event']['car_id'],$this->request->data['Event']['event_types']);

                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The event could not be saved. Please, try again.'));
            }
        }
        $interferings = $this->Interfering->getInterferingList();
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        if ($roleId != 3) {
            $administratifEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::administratif_evenement,
                ActionsEnum::view, $profileId, $roleId);
            $maintenanceEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::maintenance_evenement,
                ActionsEnum::view, $profileId, $roleId);
            if(($administratifEventPermission == 1) && ($maintenanceEventPermission == 1)){
                $eventTypes = $this->EventType->getEventTypes();
            }elseif(($administratifEventPermission == 1) && ($maintenanceEventPermission == 0)){
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id' => 8);
                $eventTypes = $this->EventType->getEventTypes('list', null , null , $eventTypeConditions);
            }elseif(($administratifEventPermission == 0) && ($maintenanceEventPermission == 1)){
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id !=' => 8);
                $eventTypes = $this->EventType->getEventTypes('list', null , null , $eventTypeConditions);
            }
        }else {
            $eventTypes = $this->EventType->getEventTypes();
        }
        $cond = $this->getConditions();
        $conditions_car = $cond[1];
        $conditions_customer = $cond[2];
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $conditions_car = $this->getCarConditionsUserParcs($conditions_car);
        if (Configure::read('logistia') == '1'){
            $cars = $this->Car->getCarsByFieldsAndConds('2', null, $conditions_car);
        }else{
            $cars = $this->Car->getCarsByFieldsAndConds($param, null, $conditions_car);
        }
        /*$userCar = $this->getCarPersistence();
        if (!empty($userCar)) {
            $this->request->data['Event']['car_id'] = $userCar;
        }*/
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions_customer);
        // get all products
        $this->Product->virtualFields = array('cnames' => "Product.name");
        $products = $this->Product->find('list', array(
            'recursive' => -1,
            'fields' => 'cnames',
            'joins' => array(
                array(
                    'table' => 'product_categories',
                    'type' => 'left',
                    'alias' => 'ProductCategory',
                    'conditions' => array('Product.product_category_id = ProductCategory.id')
                ),
            )
        ));

        //generate automatic reference
        $reference = $this->getNextEventReference( 'event');
        if (Configure::read("cafyb") == '1') {
            $comptes = $this->Cafyb->getAccounts();
            $paymentMethods = $this->Cafyb->getPaymentMethods();
        }else {
            $comptes = $this->Payment->Compte->find('list');
        }
        if (Configure::read('logistia') == '1') {
            $structures = $this->Structures->find('list');
        }
        $stock = $this->hasModuleStock();
        $this->set(compact('users', 'interferings', 'eventTypes', 'cars', 'customers', 'products', 'version_of_app',
            'reference','comptes','stock','paymentMethods', 'structures'));
    }


    public function addProductEvent($bills = null, $products = null, $eventId = null, $internalExternal = null, $thirdPartyId=null)
    {
        //var_dump($bills); die();
        if (Configure::read("cafyb") == '1') {
            $typeDoc = 15;

            $totalQuantity =0;
            $i = 0;
            $arrayProducts = array();
            foreach ($products as $product){
                $arrayProducts[$i]['id'] = $product['product'];
                $arrayProducts[$i]["_joinData"]['designation'] = $product['name'];
                $arrayProducts[$i]["_joinData"]['unit_price'] = 0;
                $arrayProducts[$i]["_joinData"]['discount_percentage'] = 0;
                $arrayProducts[$i]["_joinData"]['discount_value'] = 0;
                $arrayProducts[$i]["_joinData"]['quantity'] = $product['quantity'];
                $arrayProducts[$i]['_joinData']['total_ht'] = 0;
                $arrayProducts[$i]['_joinData']['total_taxes'] = 0;
                $arrayProducts[$i]['_joinData']['total_ttc'] = 0;
                $arrayProducts[$i]['_joinData']['description'] = '';
                $totalQuantity = $totalQuantity+ $product['quantity'];
                $i ++;
            }
            $arrayBill = array();
            $arrayBill['total_quantity']= $typeDoc;

            if($internalExternal == 2){
                $arrayBill['third_party_id']= $thirdPartyId;
            }
            $save= $this->Cafyb->addDocument(base64_encode(serialize($arrayBill)),base64_encode(serialize($arrayProducts)), $typeDoc, $internalExternal, $thirdPartyId);
        } else {

            if (!empty($products) &&
                !empty($bills['total_ht']) &&
                !empty($bills['total_ttc']) &&
                !empty($bills['total_tva'])
            ) {
                $type = BillTypesEnum::exit_order;
                $this->Bill->create();
                $reference = $this->getNextBillReference($type);
                $this->request->data['Bill']['reference'] = $reference;
                $this->request->data['Bill']['user_id'] = $this->Session->read('Auth.User.id');
                $this->request->data['Bill']['event_id'] = $eventId;
                $this->request->data['Bill']['type'] = $type;
                $this->request->data['Bill']['date'] = date("Y-m-d H:i");
                $this->request->data['Bill']['total_ht'] = 0;
                $this->request->data['Bill']['total_tva'] = 0;
                $this->request->data['Bill']['total_ttc'] = 0;
                if ($this->Bill->save($this->request->data['Bill'])) {
                    $billId = $this->Bill->getInsertID();
                    $this->Parameter->setNextBillReferenceNumber($type);
                    $nb_product = $bills['nb_product'];
                    for ($i = 0; $i <= $nb_product; $i++) {
                        $this->BillProduct->create();
                        $data = array();
                        $productId = $products[$i]['product'];
                        $lotId = $products[$i]['product'];
                        $quantity = $products[$i]['quantity'];
                        $data['BillProduct']['bill_id'] = $billId;
                        $data['BillProduct']['lot_id'] = $productId;
                        $data['BillProduct']['quantity'] = $products[$i]['quantity'];
                        $data['BillProduct']['tva_id'] = 3;
                        $data['BillProduct']['price_ht'] = 0;
                        $data['BillProduct']['price_ttc'] = 0;
                        $data['BillProduct']['price_tva'] = 0;
                        $this->BillProduct->save($data);
                        //var_dump($data); die();
                        $this->Lot->updateQuantityLot($lotId, $quantity, $type);
                        $this->Product->updateQuantityProduct($productId, $quantity, $type);
                    }
                    $this->setProductQuantitySessionAlerts();
                }
                $profileIds = array(ProfilesEnum::chef_parc);
                $receivers = $this->User->getUsersReceiverNotificationsByProfileId($profileIds);
                $userId = $this->Auth->user('id');
                $actionId = ActionsEnum::add;
                if (!empty($receivers)) {
                    $this->Notification->addNotification($billId, $userId, $receivers, $actionId,'Bill');
                    $this->getNbNotificationsByUser();
                }
            }
        }


    }


    public function editProductEvent($bills = null, $products = null, $event_id = null)
    {

        if ($this->request->data['Bill']['total_ht'] > 0) {

            $bill = $this->Bill->find('first', array('conditions' => array('event_id' => $event_id)));

            $billId = $bill['Bill']['id'];

            $billProducts = $this->BillProduct->find('all',
                array('conditions' => array('BillProduct.bill_id' => $billId)));
            $type = BillTypesEnum::entry_order;
            if (!empty($billProducts)) {
                foreach ($billProducts as $billProduct) {
                    $productId = $billProduct['BillProduct']['product_id'];
                    $lotId = $billProduct['BillProduct']['product_id'];
                    $quantity= $billProduct['BillProduct']['quantity'];

                    $this->Lot->updateQuantityLot($lotId, $quantity, $type);
                    $this->Product->updateQuantityProduct($productId, $quantity, $type);


                }
            }


            $this->BillProduct->deleteAll(array('BillProduct.bill_id' => $billId), false);

            $dataBill = array();
            $type = BillTypesEnum::exit_order;

            $dataBill['Bill']['id'] = $billId;
            $dataBill['Bill']['type'] = $type;
            $dataBill['Bill']['total_ht'] = 0;
            $dataBill['Bill']['total_ttc'] = 0;
            $dataBill['Bill']['total_tva'] = 0;
            $dataBill['Bill']['event_id'] = $event_id;
            $dataBill['Bill']['date'] = date("Y-m-d H:i");
            $dataBill['Bill']['modified_id'] = $this->Session->read('Auth.User.id');

            if ($this->Bill->save($dataBill)) {

                $nbProduct = $bills['nb_product'];


                for ($i = 0; $i <= $nbProduct; $i++) {
                    if ($this->request->data['BillProduct'][$i]['price_ht'] > 0) {
                        $this->BillProduct->create();
                        $data = array();
                        $productId = $products[$i]['product'];
                        $lotId = $products[$i]['product'];
                        $quantity = $products[$i]['quantity'];
                        $data['BillProduct']['bill_id'] = $billId;
                        $data['BillProduct']['lot_id'] = $productId;
                        $data['BillProduct']['quantity'] = $products[$i]['quantity'];
                        $data['BillProduct']['tva_id'] = 3;
                        $data['BillProduct']['price_ht'] = 0;
                        $data['BillProduct']['price_ttc'] = 0;
                        $data['BillProduct']['price_tva'] = 0;
                        $this->BillProduct->save($data);
                        $this->Lot->updateQuantityLot($lotId, $quantity, $type);
                        $this->Product->updateQuantityProduct($productId, $quantity, $type);

                    }
                }

                $this->setProductQuantitySessionAlerts();


            }

        }
    }

    public function add_request()
    {
        $this->setTimeActif();
        $this->Payment->validate = $this->Payment->validate_car;
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::demande_intervention, $user_id, ActionsEnum::add, "Events", null,
            "Event", null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index_request'));
        }
        if ($this->request->is('post')) {
            $this->Event->create();
            $date = $this->request->data['Event']['date'];

           foreach ($this->request->data['Event']['event_type_id'] as $event_type_id) {

               // $event_type_id = $this->request->data['Event']['event_type_id'];
                $this->Event->create();
                $data = array();
                $reference = $this->getNextEventReference( 'intervention_request');
               $data['Event']['code'] = $reference;
                $data['Event']['event_type_id'] = $event_type_id;
                $data['Event']['car_id'] = $this->request->data['Event']['car_id'];
                $data['Event']['customer_id'] = $this->request->data['Event']['customer_id'];
                $data['Event']['interfering_id'] = $this->request->data['Event']['interfering_id'];
                $data['Event']['cost'] = $this->request->data['Event']['cost'];
                $data['Event']['obs'] = $this->request->data['Event']['obs'];

                $data['Event']['user_id'] = $this->Session->read('Auth.User.id');
                $data['Event']['request'] = 1;
                $data['Event']['validated'] = 0;
                $data['Event']['transferred'] = 0;
                $data['Event']['canceled'] = 0;

               if (Configure::read('logistia') == '1') {
                   $this->createDatetimeFromDate('Event', 'intervention_request_date');
                   $this->createDatetimeFromDate('Event', 'wished_intervention_date');
                   $data['Event']['intervention_request_date'] = $this->request->data['Event']['intervention_request_date'];
                   $data['Event']['wished_intervention_date'] = $this->request->data['Event']['wished_intervention_date'];
                   $data['Event']['boss_id'] = $this->request->data['Event']['boss_id'];
                   $data['Event']['structure_id'] = $this->request->data['Event']['structure_id'];
                   $data['Event']['intervention_for'] = $this->request->data['Event']['intervention_for'];
                   $data['Event']['other'] = $this->request->data['Event']['other'];
               }
		        $data['Event']['km'] = $this->request->data['Event']['km'];
                $data['Event']['next_km'] = $this->request->data['Event']['next_km'];
                $this->request->data['Event']['date'] = $date;
                $this->createDatetimeFromDate('Event', 'date');
                $data['Event']['date'] = $this->request->data['Event']['date'];


                $this->Event->save($data);
              // debug($this->Event->validationErrors); die();

                $this->Parameter->setNextEventReferenceNumber('intervention_request');
                $event_id = $this->Event->getInsertID();

                $this->EventEventType->create();
                $data = array();
                $data['EventEventType']['event_id'] = $event_id;
                $data['EventEventType']['event_type_id'] = $event_type_id;
                $this->EventEventType->save($data);
               $userId = $this->Auth->user('id');
               $actionId = ActionsEnum::add;
               $sectionId = SectionsEnum::nouvelle_demande_intervention;
               $this->Notification->addNotification($event_id, $userId, $actionId,$sectionId,'Event');
               $this->getNbNotificationsByUser();
               $this->saveUserAction(SectionsEnum::demande_intervention, $event_id, $this->Session->read('Auth.User.id'), ActionsEnum::add);

           }



            $this->setCarPersistence($this->request->data['Event']['car_id']);
            $this->Flash->success(__('The request event has been saved.'));
            $this->redirect(array('action' => 'index_request'));

        }
        $interventionsTypes = array( 1 => __('Repair') , 2 => 'Entretien périodique');
        $eventTypes = $this->EventType->getEventTypeByIdsNegation(array(1, 2, 3, 4, 5, 11, 12, 13, 23));
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $cond = $this->getConditionsRequest();
        $conditions_car = $cond[1];
        $conditions_customer = $cond[2];

        $cars = $this->Car->getCarsByFieldsAndConds($param, null, $conditions_car);
        $user_car = $this->getCarPersistence();
        if (!empty($user_car)) {
            $this->request->data['Event']['car_id'] = $user_car;
        }

        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions_customer);
        $interferings = $this->Interfering->getInterferingList();
        $reference = $this->getNextEventReference( 'intervention_request');
        if (Configure::read('logistia') == '1') {
            $structures = $this->Structures->find('list');
        }
	$profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        $editKmDate = $this->AccessPermission->getPermissionWithParams(SectionsEnum::modification_km_date,
            ActionsEnum::view, $profileId, $roleId);

        $this->set(compact('users', 'interferings', 'eventTypes',
            'cars', 'customers','interferings','reference','editKmDate', 'interventionsTypes','services','structures'));
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
        $this->setTimeActif();
        $this->Payment->validate = $this->Payment->validate_car;
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        $administratifEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::administratif_evenement,
            ActionsEnum::edit, $profileId, $roleId);
        if($administratifEventPermission==0){
            $maintenanceEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::maintenance_evenement,
                ActionsEnum::edit, $profileId, $roleId);
            if($maintenanceEventPermission==0){
                $this->Flash->error(__("You don't have permission to do this action."));
                $this->redirect(array('action' => 'index'));
            }
        }
        if (!$this->Event->exists($id)) {
            throw new NotFoundException(__('Invalid event'));
        }
        $version_of_app = $this->getVersionOfApp();

        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->closeItemOpened('Event', $id);

                $this->Flash->error(__('Changes were not saved. Event cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->createDatetimeFromDate('Event', 'date');
            $this->createDatetimeFromDate('Event', 'next_date');
            $this->createDatetimeFromDate('Event', 'date3');
            $this->createDatetimeFromDatetime('Event', 'workshop_entry_date');
            $this->createDatetimeFromDatetime('Event', 'workshop_exit_date');
            $this->createDateFromDate('Event', 'reception_date');
            $this->createDateFromDate('Event', 'intervention_date');
            if ($this->request->data['Event']['alert_type'] == '0'){
                $this->createDatetimeFromDate('Event', 'last_event_date');
            }
            if (!$this->isWithDate($this->request->data['Event']['event_types'])) {

                $this->request->data['Event']['next_date'] = null;
            }
            $this->request->data['Event']['user_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['Event']['alert'] = 0;

            if ($this->request->data['Event']['file1'] == '') {
                $this->deleteAttachment('Event', 'attachment1', 'attachments/events/', $id);
                $this->verifyAttachment('Event', 'attachment1', 'attachments/events/', 'add', 0, 0, $id);
            } else {
                $this->verifyAttachment('Event', 'attachment1', 'attachments/events/', 'edit', 0, 0, $id);
            }

            if ($this->request->data['Event']['file2'] == '') {
                $this->deleteAttachment('Event', 'attachment2', 'attachments/events/', $id);
                $this->verifyAttachment('Event', 'attachment2', 'attachments/events/', 'add', 0, 0, $id);
            } else {
                $this->verifyAttachment('Event', 'attachment2', 'attachments/events/', 'edit', 0, 0, $id);
            }

            if ($this->request->data['Event']['file3'] == '') {
                $this->deleteAttachment('Event', 'attachment3', 'attachments/events/', $id);
                $this->verifyAttachment('Event', 'attachment3', 'attachments/events/', 'add', 0, 0, $id);
            } else {
                $this->verifyAttachment('Event', 'attachment3', 'attachments/events/', 'edit', 0, 0, $id);
            }

            if ($this->request->data['Event']['file4'] == '') {
                $this->deleteAttachment('Event', 'attachment4', 'attachments/events/', $id);
                $this->verifyAttachment('Event', 'attachment4', 'attachments/events/', 'add', 0, 0, $id);
            } else {
                $this->verifyAttachment('Event', 'attachment4', 'attachments/events/', 'edit', 0, 0, $id);
            }

            if ($this->request->data['Event']['file5'] == '') {
                $this->deleteAttachment('Event', 'attachment5', 'attachments/events/', $id);
                $this->verifyAttachment('Event', 'attachment5', 'attachments/events/', 'add', 0, 0, $id);
            } else {
                $this->verifyAttachment('Event', 'attachment5', 'attachments/events/', 'edit', 0, 0, $id);
            }

            $i = $this->request->data['Event']['nb_attachment'] + 1;;
            foreach ($this->request->data['Event']['attachment'] as $attachment) {
                $this->request->data['Event']['attachment' . $i] = $attachment;

                $this->verifyAttachment('Event', 'attachment' . $i, 'attachments/events/', 'add', 0, 0, null);
                $i++;

            }
            if ($version_of_app == 'web') {
                if (isset($this->request->data['Event']['attachment1_dir']) && $this->request->data['Event']['attachment1_dir'] != '') {
                    $this->request->data['Event']['attachment1'] = $this->request->data['Event']['attachment1_dir'];
                }

                if (isset($this->request->data['Event']['attachment2_dir']) && $this->request->data['Event']['attachment2_dir'] != '') {

                    $this->request->data['Event']['attachment2'] = $this->request->data['Event']['attachment2_dir'];
                }
                if (isset($this->request->data['Event']['attachment3_dir']) && $this->request->data['Event']['attachment3_dir'] != '') {

                    $this->request->data['Event']['attachment3'] = $this->request->data['Event']['attachment3_dir'];
                }
                if (isset($this->request->data['Event']['attachment4_dir']) && $this->request->data['Event']['attachment4_dir'] != '') {

                    $this->request->data['Event']['attachment4'] = $this->request->data['Event']['attachment4_dir'];
                }
                if (isset($this->request->data['Event']['attachment5_dir']) && $this->request->data['Event']['attachment5_dir'] != '') {

                    $this->request->data['Event']['attachment5'] = $this->request->data['Event']['attachment5_dir'];
                }
            }
            $this->request->data['Event']['modified_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['Event']['request'] = 0;
            $this->request->data['Event']['validated'] = 1;
            $this->request->data['Event']['transferred'] = 1;
            $this->request->data['Event']['made_event'] = 1;
            $this->closeItemOpened('Event', $id);
            $this->request->data['Event']['multiple_event'] = 0;
            if ($this->request->data['Event']['pay_customer'] == 0) {
                $this->request->data['Event']['refund'] = 0;
            }
            if((isset($this->request->data['Event']['workshop_entry_date'])&&
                    !empty($this->request->data['Event']['workshop_entry_date'])) ||
                (isset($this->request->data['Event']['workshop_exit_date'])&&
                    !empty($this->request->data['Event']['workshop_exit_date']))
            ){
                $entryDate = $this->request->data['Event']['workshop_entry_date'];
                $exitDate = $this->request->data['Event']['workshop_exit_date'];
                $this->request->data['Event']['status_id'] = $this->getStatusEvent($entryDate, $exitDate);
            }
            if ($this->Event->save($this->request->data)) {

                if((isset($entryDate)&& !empty($entryDate)) ||
                    (isset($exitDate)&& !empty($exitDate))
                ) {
                    $entryDate = $this->request->data['Event']['workshop_entry_date'];
                    $exitDate = $this->request->data['Event']['workshop_exit_date'];

                    $carStatusId = $this->getStatusCar($this->request->data['Event']['car_id'], $entryDate, $exitDate);

                    $statusRepairId = 25;
                    $this->addCarCarStatus($this->request->data['Event']['car_id'], $statusRepairId, $entryDate,$exitDate,$id);
                    if($carStatusId==$statusRepairId){
                        $this->updateStatusCar($this->request->data['Event']['car_id'],$carStatusId,$entryDate,$exitDate);
                    }

                }
                $this->EventEventType->deleteAll(array('EventEventType.event_id' => $id), false);
                $this->EventEventType->create();
                $data = array();
                $data['EventEventType']['event_id'] = $id;
                $data['EventEventType']['event_type_id'] = $this->request->data['Event']['event_types'];
                $this->EventEventType->save($data);
                if (Configure::read("gestion_commercial") == '1'  &&
                    Configure::read("tresorerie") == '1') {
                    $payments = $this->Payment->find('all', array('conditions' => array('Payment.event_id' => $id)));
                    if (!empty($payments)) {

                        $this->Payment->deleteAll(array('Payment.event_id' => $id), false);
                    }

                    $nb_payment = $this->request->data['Event']['nb_payment'];
                    $eventTypeId = $this->request->data['Event']['event_types'];
                    $eventType = $this->EventType->getEventTypeById($eventTypeId);
                    $transact_type_id = $eventType['EventType']['transact_type_id'];
                    if ($nb_payment == 0) {
                        if (!empty ($this->request->data['Payment'][0]['interfering_id']) && !empty ($this->request->data['Payment'][0]['compte_id']) &&
                            !empty($this->request->data['Payment'][0]['amount']) && !empty($this->request->data['Payment'][0]['receipt_date']) &&
                            !empty($this->request->data['Payment'][0]['payment_type'])
                        ) {

                            $this->Payment->create();
                            $this->request->data['Payment']['receipt_date'] = $this->request->data['Payment'][0]['receipt_date'];
                            $this->createDateFromDate('Payment', 'receipt_date');
                            $data['Payment']['event_id'] = $id;
                            $data['Payment']['interfering_id'] = $this->request->data['Payment'][0]['interfering_id'];
                            $data['Payment']['compte_id'] = $this->request->data['Payment'][0]['compte_id'];
                            $data['Payment']['wording'] = $this->request->data['Payment'][0]['reference'];
                            $data['Payment']['modified_id'] = $this->Session->read('Auth.User.id');
                            $data['Payment']['receipt_date'] = $this->request->data['Payment']['receipt_date'];
                            $data['Payment']['amount'] = $this->request->data['Payment'][0]['amount'];
                            $data['Payment']['payment_type'] = $this->request->data['Payment'][0]['payment_type'];
                            $data['Payment']['transact_type_id'] = $transact_type_id;
                            $data['Payment']['payment_association_id'] = 2;
                            $data['Payment']['note'] = $this->request->data['Payment'][0]['note'];

                            $this->Payment->save($data);
                        }
                    } else {
                        for ($i = 0; $i < $nb_payment; $i++) {
                            if ($this->request->data['Payment'][$i]) {
                                if (!empty ($this->request->data['Payment'][$i]['interfering_id']) && !empty ($this->request->data['Payment'][$i]['compte_id']) &&
                                    !empty($this->request->data['Payment'][$i]['amount']) && !empty($this->request->data['Payment'][$i]['receipt_date']) &&
                                    !empty($this->request->data['Payment'][$i]['payment_type'])
                                ) {
                                    $this->Payment->create();
                                    $this->request->data['Payment']['receipt_date'] = $this->request->data['Payment'][$i]['receipt_date'];
                                    $this->createDateFromDate('Payment', 'receipt_date');
                                    $data['Payment']['event_id'] = $id;
                                    $data['Payment']['interfering_id'] = $this->request->data['Payment'][$i]['interfering_id'];
                                    $data['Payment']['compte_id'] = $this->request->data['Payment'][$i]['compte_id'];
                                    $data['Payment']['wording'] = $this->request->data['Payment'][$i]['reference'];
                                    $data['Payment']['modified_id'] = $this->Session->read('Auth.User.id');
                                    $data['Payment']['receipt_date'] = $this->request->data['Payment']['receipt_date'];
                                    $data['Payment']['amount'] = $this->request->data['Payment'][$i]['amount'];
                                    $data['Payment']['payment_type'] = $this->request->data['Payment'][$i]['payment_type'];
                                    $data['Payment']['transact_type_id'] = $transact_type_id;
                                    $data['Payment']['payment_association_id'] = 2;
                                    $data['Payment']['note'] = $this->request->data['Payment'][$i]['note'];
                                    $this->Payment->save($data);
                                }
                            }
                        }
                    }
                }
                $this->saveUserAction(SectionsEnum::evenement, $id, $this->Session->read('Auth.User.id') , ActionsEnum::edit);
                $this->EventCategoryInterfering->deleteAll(array('EventCategoryInterfering.event_id' => $id), false);
                if (!empty($this->request->data['EventCategoryInterfering'])) {
                    foreach ($this->request->data['EventCategoryInterfering'] as $EventCategoryInterfering) {
                        $this->EventCategoryInterfering->create();
                        $data = array();
                        $data['EventCategoryInterfering']['event_id'] = $id;
                        $data['EventCategoryInterfering']['interfering_id0'] = $EventCategoryInterfering['interfering_id0'];
                        if (isset($EventCategoryInterfering['interfering_id1'])) {
                            $data['EventCategoryInterfering']['interfering_id1'] = $EventCategoryInterfering['interfering_id1'];
                        }
                        if (isset($EventCategoryInterfering['interfering_id2'])) {
                            $data['EventCategoryInterfering']['interfering_id2'] = $EventCategoryInterfering['interfering_id2'];
                        }
                        $data['EventCategoryInterfering']['event_type_category_id'] = $EventCategoryInterfering['event_type_category'];
                        $data['EventCategoryInterfering']['cost'] = $EventCategoryInterfering['cost'];
                        $this->EventCategoryInterfering->save($data);
                    }
                }

                if (isset ($this->request->data['Bill'])) {
                    $this->addProductEvent($this->request->data['Bill'], $this->request->data['Product'], $id);
                }
                $this->setCarPersistence($this->request->data['Event']['car_id']);
                $this->Flash->success(__('The event has been saved.'));
                // Set alerts messages
                $this->Alert->deleteAll(array('Alert.object_id' => $id), false);
                $this->setSessionAlerts($this->request->data['Event']['car_id'],
                    $this->request->data['Event']['event_types']);
                $this->disableAlerts($this->request->data['Event']['car_id'],
                    $this->request->data['Event']['event_types']);
                $this->getTotalNbAlerts();
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The event could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Event->find('first',
                array(
                    'recursive' => -1,
                    'paramType' => 'querystring',
                    'conditions' => array('Event.' . $this->Event->primaryKey => $id),
                    'fields' => array(
                        'Event.code',
                        'Event.id',
                        'Event.pay_customer',
                        'Event.refund',
                        'Event.date',
                        'Event.next_date',
                        'Event.date3',
                        'Event.assurance_number',
                        'Event.assurance_type',
                        'Event.km',
                        'Event.next_km',
                        'Event.cost',
                        'Event.locked',
                        'Event.transferred',
                        'Event.car_id',
                        'Event.customer_id',
                        'Customer.id',
                        'Customer.first_name',
                        'Customer.last_name',
                        'Customer.company',
                        'Interfering.name',
                        'Car.code',
                        'Car.immatr_def',
                        'Event.user_id',
                        'Car.parc_id',
                        'Carmodel.name',
                        'EventType.name',
                        'Event.alert',
                        'Event.internal_external',
                        'Event.mechanician_id',
                        'Event.multiple_event',
                        'Event.attachment1',
                        'Event.attachment2',
                        'Event.attachment3',
                        'Event.attachment4',
                        'Event.attachment5',
                        'Event.date_refund',
                        'Event.sinistre_type',
                        'Event.dommages_corporels',
                        'EventEventType.event_type_id',
                        'Event.workshop_id',
                        'Event.workshop_entry_date',
                        'Event.workshop_exit_date',
                        'Event.reception_date',
                        'Event.diagnostic',
                        'Event.event_time',
                        'Event.obs',
                        'Event.intervention_date',
                        'Event.structure_id',
                        'Event.boss_id',
                        'Event.intervention_for',
                        'Event.other',
                        'Event.alert_activate',
                        'Event.last_event_date',
                        'Event.date_interval',
                        'Event.alert_before_days',
                        'Event.last_event_km',
                        'Event.km_interval',
                        'Event.alert_before_km',
                        'Event.renew_after_expiration',
                        'Event.alert_type',
                        'EventType.with_km',
                        'EventType.with_date',
                        'EventType.code',
                        'EventType.many_interferings',
                        'EventTypeCategoryEventType.event_type_category_id'

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
                            'table' => 'event_category_interfering',
                            'type' => 'left',
                            'alias' => 'EventCategoryInterfering',
                            'conditions' => array('EventCategoryInterfering.event_id = EventEventType.event_id')
                        ),
                        array(
                            'table' => 'interferings',
                            'type' => 'left',
                            'alias' => 'Interfering',
                            'conditions' => array('EventCategoryInterfering.interfering_id0 = Interfering.id')
                        ),
                        array(
                            'table' => 'interferings',
                            'type' => 'left',
                            'alias' => 'Interfering1',
                            'conditions' => array('EventCategoryInterfering.interfering_id1 = Interfering1.id')
                        ),
                        array(
                            'table' => 'interferings',
                            'type' => 'left',
                            'alias' => 'Interfering2',
                            'conditions' => array('EventCategoryInterfering.interfering_id2 = Interfering2.id')
                        ),
                        array(
                            'table' => 'carmodels',
                            'type' => 'left',
                            'alias' => 'Carmodel',
                            'conditions' => array('Car.carmodel_id = Carmodel.id')
                        ),
                        array(
                            'table' => 'parcs',
                            'type' => 'left',
                            'alias' => 'Parc',
                            'conditions' => array('Car.parc_id = Parc.id')
                        ),
                        array(
                            'table' => 'event_type_category_event_type',
                            'type' => 'left',
                            'alias' => 'EventTypeCategoryEventType',
                            'conditions' => array('EventTypeCategoryEventType.event_type_id = EventType.id')
                        ),
                        array(
                            'table' => 'event_products',
                            'type' => 'left',
                            'alias' => 'EventProducts',
                            'conditions' => array('EventProducts.event_id = EventType.id')
                        ),
                    )
                ));
            if($this->request->data['Event']['internal_external']==2){
                $eventCategoryInterferings = $this->EventCategoryInterfering->find('all',
                    array('conditions' => array('event_id' => $id)));

                $this->set('eventCategoryInterferings', $eventCategoryInterferings);
            }else {
                $fields = "names";
                $conditions = array('CustomerCategory.mechanician'=>1);
                $mechanicians = $this->Customer->getCustomersByFieldsAndConds($fields,$conditions);
                $workshops = $this->Workshop->getWorkshops('list');
                $this->set(compact('mechanicians', 'workshops'));

            }


            $bill = $this->Bill->find('first', array('conditions' => array('event_id' => $id)));
            if (!empty($bill)) {
                $bill_id = $bill['Bill']['id'];
                $nb_products = $this->BillProduct->find('count',
                    array('conditions' => array('BillProduct.bill_id' => $bill_id)));

                $billProducts = $this->BillProduct->find('all',
                    array('conditions' => array('BillProduct.bill_id' => $bill_id), 'recursive' => 2));
                $this->Product->virtualFields = array('cnames' => "Product.name");
                $products = $this->Product->find('list', array(
                    'recursive' => -1,
                    'fields' => 'cnames',
                    'joins' => array(
                        array(
                            'table' => 'product_categories',
                            'type' => 'left',
                            'alias' => 'ProductCategory',
                            'conditions' => array('Product.product_category_id = ProductCategory.id')
                        ),
                    )
                ));


                $this->set(compact('billProducts', 'nb_products', 'bill', 'products'));


            }
            if (Configure::read("gestion_commercial") == '1'  &&
                Configure::read("tresorerie") == '1') {
                if (Configure::read("cafyb") == '1') {
                    $payments = $this->Cafyb->getPaymentsByEventId($id);
                    $nb_payment = count($payments);
                } else {
                    $nb_payment = $this->Payment->find('count', array(
                        'conditions' => array('Payment.event_id' => $id)
                    ));
                    $payments = $this->Payment->find('all', array(
                        'recursive' => -1,
                        'conditions' => array('Payment.event_id' => $id)
                    ));
                }
                $this->set(compact('nb_payment', 'payments'));
            }
            if ($this->request->data['Event']['locked'] == 1) {
                $this->Flash->error(__('You must first unlock the event.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->isOpenedByOtherUser("Event", 'Events', 'event', $id);

        }
        $interferings = $this->Interfering->getInterferingList();
        if ($roleId != 3) {
            $administratifEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::administratif_evenement,
                ActionsEnum::view, $profileId, $roleId);
            $maintenanceEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::maintenance_evenement,
                ActionsEnum::view, $profileId, $roleId);
            if(($administratifEventPermission == 1) && ($maintenanceEventPermission == 1)){
                $eventTypes = $this->EventType->getEventTypes();
            }elseif(($administratifEventPermission == 1) && ($maintenanceEventPermission == 0)){
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id' => 8);
                $eventTypes = $this->EventType->getEventTypes('list', null , null , $eventTypeConditions);
            }elseif(($administratifEventPermission == 0) && ($maintenanceEventPermission == 1)){
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id !=' => 8);
                $eventTypes = $this->EventType->getEventTypes('list', null , null , $eventTypeConditions);
            }
        }else {
            $eventTypes = $this->EventType->getEventTypes();
        }
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $cond = $this->getConditions();
        $conditions_car = $cond[1];
        $conditions_customer = $cond[2];
        $conditions_car = $this->getCarConditionsUserParcs($conditions_car);
        $cars = $this->Car->getCarsByFieldsAndConds($param, null, $conditions_car);
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions_customer);
        $this->Product->virtualFields = array('cnames' => "Product.name");
        $products = $this->Product->find('list', array(
            'recursive' => -1,
            'fields' => 'cnames',
            'joins' => array(
                array(
                    'table' => 'product_categories',
                    'type' => 'left',
                    'alias' => 'ProductCategory',
                    'conditions' => array('Product.product_category_id = ProductCategory.id')
                ),
            )
        ));
        $eventTypesSelected = $this->EventEventType->getEventTypeIds($id);
        if (Configure::read("cafyb") == '1') {
            $comptes = $this->Cafyb->getAccounts();
            $paymentMethods = $this->Cafyb->getPaymentMethods();
        }else {
            $comptes = $this->Payment->Compte->find('list');
        }
        $stock = $this->hasModuleStock();
        if (Configure::read('logistia') == '1') {
            $structures = $this->Structures->find('list');
        }
        $this->set(compact('users', 'interferings', 'eventTypes'
            , 'cars', 'customers', 'products','editKmDate', 'structures',
            'version_of_app', 'eventTypesSelected','comptes','stock','paymentMethods'));
    }

    public function edit_request($id = null)
    {
        $this->setTimeActif();
        $this->Payment->validate = $this->Payment->validate_car;
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::demande_intervention, $user_id, ActionsEnum::edit, "Events", null,
            "Event", null);
        if (!$this->Event->exists($id)) {
            throw new NotFoundException(__('Invalid event'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Event cancelled.'));
                $this->redirect(array('action' => 'index_request'));
            }
            $this->createDatetimeFromDate('Event', 'wished_intervention_date');
            $this->createDatetimeFromDate('Event', 'intervention_request_date');
	    $this->createDatetimeFromDate('Event', 'date');
            $this->createDatetimeFromDate('Event', 'next_date');
            $this->createDatetimeFromDate('Event', 'date3');
           /* if (!$this->isWithDate($this->request->data['Event']['event_type_id'])) {
                $this->request->data['Event']['date'] = null;
                $this->request->data['Event']['next_date'] = null;
            }*/
            $this->request->data['Event']['user_id'] = $this->Session->read('Auth.User.id');
            $this->verifyAttachment('Event', 'attachment1', 'attachments/events/', 'edit', 0, $id);
            $this->request->data['Event']['modified_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['Event']['request'] = 1;
            $this->request->data['Event']['validated'] = 0;
            $this->request->data['Event']['transferred'] = 0;
            $this->request->data['Event']['is_open'] = 0;
           /* var_dump($this->Event->save($this->request->data));
            var_dump($this->Event->validationErrors);die();*/
            if ($this->Event->save($this->request->data)) {
                $this->EventEventType->deleteAll(array('EventEventType.event_id' => $id), false);
                $this->EventEventType->create();
                $data = array();
                $data['EventEventType']['event_id'] = $id;
                $data['EventEventType']['event_type_id'] = $this->request->data['Event']['event_type_id'];
                $this->EventEventType->save($data);
                $this->setCarPersistence($this->request->data['Event']['car_id']);
                $this->Flash->success(__('The request event has been saved.'));
                $this->redirect(array('action' => 'index_request'));
            } else {
                $this->Flash->error(__('The request event could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
            $this->request->data = $this->Event->find('first', $options);
            $eventcategoryinterferings = $this->EventCategoryInterfering->find('all',
                array('conditions' => array('event_id' => $id)));
            $this->set('eventcategoryinterferings', $eventcategoryinterferings);
            $EventTypeCategories = $this->EventTypeCategoryEventType->find('all', array(
                'recursive' => 2,
                'fields' => array('event_type_category_id'),
                'conditions' => array('EventTypeCategoryEventType.event_type_id' => $this->request->data ['Event']['event_type_id'])
            ));
            $this->set('EventTypeCategories', $EventTypeCategories);
            if ($this->request->data['Event']['locked'] == 1) {
                $this->Flash->error(__('You must first unlock the event.'));
                $this->redirect(array('action' => 'index_request'));
            }
            $this->isOpenedByOtherUser("Event", 'Events', 'event', $id);
        }
        $interferings = $this->Interfering->getInterferingList();
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        if ($roleId != 3) {
            $administratifEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::administratif_evenement,
                ActionsEnum::view, $profileId, $roleId);
            $maintenanceEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::maintenance_evenement,
                ActionsEnum::view, $profileId, $roleId);
            if(($administratifEventPermission == 1) && ($maintenanceEventPermission == 1)){
                $eventTypes = $this->EventType->getEventTypes();
            }elseif(($administratifEventPermission == 1) && ($maintenanceEventPermission == 0)){
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id' => 8);
                $eventTypes = $this->EventType->getEventTypes('list', null , null , $eventTypeConditions);
            }elseif(($administratifEventPermission == 0) && ($maintenanceEventPermission == 1)){
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id !=' => 8);
                $eventTypes = $this->EventType->getEventTypes('list', null , null , $eventTypeConditions);
            }
        }else {
            $eventTypes = $this->EventType->getEventTypes();
        }
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $cond = $this->getConditions();
        $conditions_car = $cond[1];
        $conditions_customer = $cond[2];
        $cars = $this->Car->getCarsByFieldsAndConds($param, null, $conditions_car);
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions_customer);
        $reference = $this->getNextEventReference( 'intervention_request');
        if (Configure::read('logistia') == '1') {
            $interventionsTypes = array(1 => __('Repair'), 2 => 'Entretien periodique');
            $structures = $this->Structures->find('list');
        }
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        $editKmDate = $this->AccessPermission->getPermissionWithParams(SectionsEnum::modification_km_date,
            ActionsEnum::view, $profileId, $roleId);
        $this->set(compact('users', 'interferings', 'eventTypes',
            'cars', 'customers','reference','editKmDate','interventionsTypes','services','structures'));
    }

    public function addAllCars()
    {
        $this->setTimeActif();

        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::evenement, $user_id, ActionsEnum::add, "Events", null, "Event", null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $param = $this->Parameter->getCodesParameterVal('name_car');
            $cars = $this->Car->getCarsByFieldsAndConds($param, array('Car.id'), null, 'all');
            $this->createDatetimeFromDate('Event', 'date');
            $this->createDatetimeFromDate('Event', 'next_date');
            $this->createDatetimeFromDate('Event', 'date3');
            foreach ($cars as $car) {
                $this->request->data['Event']['car_id'] = $car['Car']['id'];
                $this->Event->create();
                $this->request->data['Event']['user_id'] = $this->Session->read('Auth.User.id');
                $this->request->data['Event']['request'] = 0;
                $this->request->data['Event']['validated'] = 1;
                $this->request->data['Event']['transferred'] = 1;
                $this->request->data['Event']['made_event'] = 1;
                if ($this->Event->save($this->request->data)) {
                    $event_id = $this->Event->getInsertID();
                    $this->EventEventType->create();
                    $data = array();
                    $data['EventEventType']['event_id'] = $event_id;
                    $data['EventEventType']['event_type_id'] = $this->request->data['Event']['event_type_id'];
                    $this->EventEventType->save($data);
                    if (!empty($this->request->data['EventCategoryInterfering'])) {
                        foreach ($this->request->data['EventCategoryInterfering'] as $EventCategoryInterfering) {
                            $this->EventCategoryInterfering->create();
                            $data = array();
                            $data['EventCategoryInterfering']['event_id'] = $event_id;
                            $data['EventCategoryInterfering']['interfering_id0'] = $EventCategoryInterfering['interfering_id0'];
                            if (isset($EventCategoryInterfering['interfering_id1'])) {
                                $data['EventCategoryInterfering']['interfering_id1'] = $EventCategoryInterfering['interfering_id1'];
                            }
                            if (isset($EventCategoryInterfering['interfering_id2'])) {
                                $data['EventCategoryInterfering']['interfering_id2'] = $EventCategoryInterfering['interfering_id2'];
                            }
                            $data['EventCategoryInterfering']['event_type_category_id'] = $EventCategoryInterfering['event_type_category'];
                            $data['EventCategoryInterfering']['cost'] = $EventCategoryInterfering['cost'];
                            $this->EventCategoryInterfering->save($data);

                        }

                    }
                    $this->Flash->success(__('The event has been saved.'));
                } else {
                    $this->Flash->error(__('The event could not be saved. Please, try again.'));
                }
            }
            $this->redirect(array('action' => 'index'));
        }
        $interferings = $this->Interfering->getInterferingList();
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        if ($roleId != 3) {
            $administratifEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::administratif_evenement,
                ActionsEnum::view, $profileId, $roleId);

            if ($administratifEventPermission == 1) {
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id' => 8);
            } else {
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id !=' => 8);
            }
            $eventTypes = $this->EventType->getEventTypes('list', null , null , $eventTypeConditions);
        }else {
            $eventTypes = $this->EventType->getEventTypes();
        }
        $this->set(compact('users', 'interferings', 'eventTypes'));
    }


    public function addMultipleEvent($checkBoxes = null)
    {
        $this->setTimeActif();
        $carId = $checkBoxes;
        $userId = intval($this->Auth->user('id'));
        $this->verifyUserPermission(SectionsEnum::evenement, $userId, ActionsEnum::add, "Events", null, "Event", null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {


            if (isset($this->params['pass']['0']) && $this->params['pass']['0'] == "all") {

                if (isset($this->params['named']['keyword']) || isset($this->params['named']['mark'])
                    || isset($this->params['named']['model']) || isset($this->params['named']['category'])
                    || isset($this->params['named']['type']) || isset($this->params['named']['fuel'])
                    || isset($this->params['named']['status']) || isset($this->params['named']['user']) || isset($this->params['named']['modified_id'])
                    || isset($this->params['named']['created']) || isset($this->params['named']['created1'])
                    || isset($this->params['named']['modified']) || isset($this->params['named']['modified1'])
                    || isset($this->params['named']['parc']) || isset($this->params['pass']['0'])
                ) {
                    $conditions = $this->getCarConds();
                    $param = $this->Parameter->getCodesParameterVal('name_car');
                    $cars = $this->Car->getCarsByFieldsAndConds($param, array('Car.id'), $conditions, 'all');

                }

            } else {

                $ids = $this->params['pass']['0'];
                $array_ids = explode(",", $ids);
                $param = $this->Parameter->getCodesParameterVal('name_car');
                $cars = $this->Car->getCarsByFieldsAndConds($param, array('Car.id'), array("Car.id" => $array_ids),
                    'all');

            }


            $this->createDatetimeFromDate('Event', 'date');
            $this->createDatetimeFromDate('Event', 'next_date');
            $this->createDatetimeFromDate('Event', 'date3');
            $this->verifyAttachment('Event', 'attachment1', 'attachments/events/', 'add', 0, 0, null);
            $event_types = $this->request->data['Event']['event_type_id'];
            if (!empty($cars)) {
                foreach ($cars as $car) {
                    foreach ($event_types as $event_type_id) {
                        $this->request->data['Event']['car_id'] = $car['Car']['id'];
                        $this->Event->create();
                        $this->request->data['Event']['user_id'] = $this->Session->read('Auth.User.id');
                        $this->request->data['Event']['request'] = 0;
                        $this->request->data['Event']['validated'] = 1;
                        $this->request->data['Event']['transferred'] = 1;
                        $this->request->data['Event']['made_event'] = 1;

                        $this->request->data['Event']['event_type_id'] = 0;
                        if ($this->Event->save($this->request->data)) {
                            $event_id = $this->Event->getInsertID();
                            $this->EventEventType->create();
                            $data = array();
                            $data['EventEventType']['event_id'] = $event_id;
                            $data['EventEventType']['event_type_id'] = $event_type_id;
                            $this->EventEventType->save($data);
                            if (!empty($this->request->data['EventCategoryInterfering'])) {
                                foreach ($this->request->data['EventCategoryInterfering'] as $EventCategoryInterfering) {
                                    $this->EventCategoryInterfering->create();
                                    $data = array();
                                    $data['EventCategoryInterfering']['event_id'] = $event_id;
                                    $data['EventCategoryInterfering']['interfering_id0'] = $EventCategoryInterfering['interfering_id0'];
                                    if (isset($EventCategoryInterfering['interfering_id1'])) {
                                        $data['EventCategoryInterfering']['interfering_id1'] = $EventCategoryInterfering['interfering_id1'];
                                    }
                                    if (isset($EventCategoryInterfering['interfering_id2'])) {
                                        $data['EventCategoryInterfering']['interfering_id2'] = $EventCategoryInterfering['interfering_id2'];
                                    }
                                    $data['EventCategoryInterfering']['event_type_category_id'] = $EventCategoryInterfering['event_type_category'];
                                    $data['EventCategoryInterfering']['cost'] = $EventCategoryInterfering['cost'];
                                    $this->EventCategoryInterfering->save($data);

                                }

                            }
                            $this->Flash->success(__('The event has been saved.'));
                        } else {
                            $this->Flash->error(__('The event could not be saved. Please, try again.'));
                        }
                    }


                }
            }
            $this->redirect(array('action' => 'index'));
        }
        $interferings = $this->Interfering->getInterferingList();
        $eventTypes = $this->EventType->getEventTypes();
        $this->set(compact('users', 'interferings', 'eventTypes','carId'));
    }


    private function getCarConds()
    {
        if (!empty($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $conds = array(
                'OR' => array(
                    "LOWER(Car.code) LIKE" => "%$keyword%",
                    "LOWER(Car.immatr_def) LIKE" => "%$keyword%",
                    "LOWER(Car.immatr_prov) LIKE" => "%$keyword%",
                    "LOWER(Car.chassis) LIKE" => "%$keyword%",
                    "LOWER(Carmodel.name) LIKE" => "%$keyword%",
                    "LOWER(Mark.name) LIKE" => "%$keyword%"
                )
            );
        } else {
            $conds = array();
        }
        if (isset($this->params['named']['mark']) && !empty($this->params['named']['mark'])) {
            $conds["Mark.id = "] = $this->params['named']['mark'];
            $this->request->data['Cars']['mark_id'] = $this->params['named']['mark'];
        }
        if (isset($this->params['named']['model']) && !empty($this->params['named']['model'])) {
            $conds["Carmodel.id = "] = $this->params['named']['model'];
            $this->request->data['Cars']['carmodel_id'] = $this->params['named']['model'];
        }
        if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
            $conds["CarCategory.id = "] = $this->params['named']['category'];
            $this->request->data['Cars']['car_category_id'] = $this->params['named']['category'];
        }
        if (isset($this->params['named']['type']) && !empty($this->params['named']['type'])) {
            $conds["CarType.id = "] = $this->params['named']['type'];
            $this->request->data['Cars']['car_type_id'] = $this->params['named']['type'];
        }
        if (isset($this->params['named']['fuel']) && !empty($this->params['named']['fuel'])) {
            $conds["Fuel.id = "] = $this->params['named']['fuel'];
            $this->request->data['Cars']['fuel_id'] = $this->params['named']['fuel'];
        }
        if (isset($this->params['named']['status']) && !empty($this->params['named']['status'])) {
            $conds["CarStatus.id = "] = $this->params['named']['status'];
            $this->request->data['Cars']['car_status_id'] = $this->params['named']['status'];
        }
        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $conds["User.id = "] = $this->params['named']['user'];
            $this->request->data['Cars']['user_id'] = $this->params['named']['user'];
        }
        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $creat = str_replace("-", "/", $this->params['named']['created']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Car.created >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Cars']['created'] = $creat;
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $creat = str_replace("-", "/", $this->params['named']['created1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Car.created <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Cars']['created1'] = $creat;
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $conds["Car.modified_id = "] = $this->params['named']['modified_id'];
            $this->request->data['Cars']['modified_id'] = $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Car.modified >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Cars']['modified'] = $creat;
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Car.modified <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Cars']['modified1'] = $creat;
        }
        if (isset($this->params['named']['parc']) && !empty($this->params['named']['parc'])) {
            $conds["Parc.id = "] = $this->params['named']['parc'];
            $this->request->data['Cars']['parc_id'] = $this->params['named']['parc'];
        }
        if (isset($this->params['named']['mission']) && !empty($this->params['named']['mission'])) {

            if ($this->params['named']['mission'] == 2) {
                $conds["Car.in_mission = "] = 0;

                $this->request->data['Cars']['mission'] = 2;
            }
            if ($this->params['named']['mission'] == 1) {
                $conds["Car.in_mission = "] = 1;

                $this->request->data['Cars']['mission'] = 1;
            }
        }
        return $conds;

    }


    function getIntervals($typeId = null,$carId = null)
    {
        if (isset($typeId) && !empty($typeId)) {
            $this->layout = 'ajax';
            $this->Event->recursive = 2;
            $results = $this->EventType->getEventTypeByIds($typeId);
            $this->set(compact('results'));
        } else {
            $this->layout = 'ajax';
            $this->set('result', null);
        }
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        $editKmDate = $this->AccessPermission->getPermissionWithParams(SectionsEnum::modification_km_date,
            ActionsEnum::view, $profileId, $roleId);
        $this->set('editKmDate',$editKmDate);
        $km = '';
        if(!empty($carId)){
            $km = $this->getKmCar($carId, false);

        }
        $this->set('km',$km);
    }

    /**
     * @param null $carId
     */
    function getIntervalsRequest($carId = null)
    {
        $this->layout = 'ajax';
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        $editKmDate = $this->AccessPermission->getPermissionWithParams(SectionsEnum::modification_km_date,
            ActionsEnum::view, $profileId, $roleId);
        $this->set('editKmDate',$editKmDate);
        $km = '';
        if(!empty($carId)){
            $km = $this->getKmCar($carId, false);

        }
        $this->set('km',$km);
    }

    function getCategoryEvent($typeId = null)
    {
        $this->setTimeActif();
        $this->loadModel('EventTypeCategoryEventType');
        if (isset($typeId) && !empty($typeId)) {
            $this->layout = 'ajax';
            $this->Event->recursive = 2;
            // Get Event categories which can have products
            $result = $this->EventTypeCategoryEventType->getEventCategoriesByEventType($typeId);

            if (Configure::read("cafyb") == '1') {
                $products = $this->Cafyb->getProducts();
            }else {
                $this->Product->virtualFields = array('cnames' => "Product.name");
                $products = $this->Product->find('list', array(
                    'recursive' => -1,
                    'fields' => 'cnames',
                    'joins' => array(
                        array(
                            'table' => 'product_categories',
                            'type' => 'left',
                            'alias' => 'ProductCategory',
                            'conditions' => array('Product.product_category_id = ProductCategory.id')
                        ),
                    )
                ));
            }

            $this->set(compact('result', 'products'));
        } else {
            $this->layout = 'ajax';
            $this->set('result', null);
            $this->set('products', null);
        }
    }

    function getCustomersByCar($carId = null)
    {
        $this->setTimeActif();
        $this->layout = 'ajax';

        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);
        $this->set(compact('customers'));
        $current_date = date("Y-m-d H:i:s");
        if (isset($carId) && !empty($carId)) {
            $this->loadModel('CustomerCar');
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
                $this->set(compact('selected_id'));
            } else {
                $this->set('selected_id', 0);
            }
            $car = $this->Car->getCarById($carId, array('Car.vidange_hour'));
            $isVidangePerHour = $car['Car']['vidange_hour'];
            $this->set('vidange_hour', $isVidangePerHour);
        } else {
            $this->set('selected_id', 0);

            $this->set('vidange_hour', 0);
        }


    }

    /**
     * @param null $carId
     * @param null $ajax
     * @return mixed
     * km synchronisation algeofleet
     */

    public function getKmCar($carId = null, $ajax = true)
    {
        if($ajax){
            $this->autoRender = false;
            $carId = filter_input(INPUT_POST, "carId");
        }
        $car = $this->SheetRide->Car->find('first',
            array('conditions' => array('Car.id' => $carId), 'recursive' => -1, ''));

        $codeCar = $car['Car']['code'];

        $link = "https://www.activegps.net/rest/intellix/vehicleInfos/tr405053ans925786inv920/".$codeCar;
        $headers = array("Content-Type:application/json");
        $chaine = $this->cUrlGetData($link, null, $headers);

        if(!empty($chaine)){
            if (isset($chaine['odometer']) && !empty($chaine['odometer'])){
                $km = $chaine['odometer'];
            }else{
                $km = $car['Car']['km'];
            }
        }else {
            $km = $car['Car']['km'];
        }


        if($ajax){
            echo json_encode(array("response"=>true,"km" => intval($km)));
        }else {
            return $km;
        }


    }
    function getNumAssurance($carId = null)
    {
        $this->setTimeActif();
        $this->layout = 'ajax';

        //$this->Event->recursive = 2;
        $current_date = date("Y-m-d");
        $event_assurance = $this->Event->find('first', array(
            'conditions' => array(
                'Event.car_id' => $carId,
                'Event.date <= ' => $current_date,
                'Event.next_date >= ' => $current_date,
                'EventEventType.event_type_id' => 2
            ),
            'recursive' => -1,
            'fields' => array(
                'Event.id',
                'EventEventType.event_type_id',
                'date',
                'next_date',
                'cost',
                'assurance_number',
                'assurance_type',
                'Interfering.name'

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
                    'table' => 'event_category_interfering',
                    'type' => 'left',
                    'alias' => 'EventCategoryInterfering',
                    'conditions' => array('EventCategoryInterfering.event_id = Event.id')
                ),
                array(
                    'table' => 'interferings',
                    'type' => 'left',
                    'alias' => 'Interfering',
                    'conditions' => array('EventCategoryInterfering.interfering_id0 = Interfering.id')
                ),
            ),
        ));
        $this->set('event_assurance', $event_assurance);
    }


    function addEventType($typeAdd=null)
    {

        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::type_evenement, $user_id, ActionsEnum::add, "EventTypes", null, "EventType", null,1);
        $this->set('result',$result);
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->EventType->create();
            if ($this->EventType->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $type_id = $this->EventType->getLastInsertId();
                $this->set('type_id', $type_id);
            }
        } else {
            $eventTypeCategories = $this->EventTypeCategory->getEventTypeCategories();
            $this->set('eventTypeCategories', $eventTypeCategories);
        }
        $this->set('typeAdd', $typeAdd);
    }

    function getEventTypes()
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        if ($roleId != 3) {
            $administratifEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::administratif_evenement,
                ActionsEnum::view, $profileId, $roleId);
            $maintenanceEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::maintenance_evenement,
                ActionsEnum::view, $profileId, $roleId);
            if(($administratifEventPermission == 1) && ($maintenanceEventPermission == 1)){
                $types = $this->EventType->getEventTypes();
            }elseif(($administratifEventPermission == 1) && ($maintenanceEventPermission == 0)){
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id' => 8);
                $types = $this->EventType->getEventTypes('all', null , null , $eventTypeConditions);
            }elseif(($administratifEventPermission == 0) && ($maintenanceEventPermission == 1)){
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id !=' => 8);
                $types = $this->EventType->getEventTypes('all', null , null , $eventTypeConditions);
            }
        }else {
            $types = $this->EventType->getEventTypes('all',null,null,null);
        }
        $this->set('selectbox', $types);
        $this->set('selectedid', $this->params['pass']['0']);
        $this->set('typeAdd', $this->params['pass']['1']);
    }


    function addInterfering()
    {
        $this->loadModel('InterferingType');
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        $idInterval = $this->params['pass']['0'];
        $itemNumber = $this->params['pass']['1'];
        $eventTypeId = $this->params['pass']['2'];
        $this->set('idInterval', $idInterval);
        $this->set('itemNumber', $itemNumber);
        if (!empty($this->request->data)) {
            $this->Interfering->create();
            if ($this->Interfering->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $interfering_id = $this->Interfering->getLastInsertId();
                $this->set('interfering_id', $interfering_id);
            }
        } else {
            $interferingTypes = $this->InterferingType->getInterferingTypesByEventType($eventTypeId);
            $this->set(compact('interferingTypes'));
        }
        $this->set('typeEventId', $eventTypeId);
    }

    function getInterferings()
    {

        $this->layout = 'ajax';
        $i = $this->params['pass']['1'];
        $id_int = $this->params['pass']['2'];
        $typeEvent = $this->params['pass']['3'];

        $Interferings = $this->Interfering->getInterferingList('all');
        $this->set('selectbox', $Interferings);
        $this->set('selectedid', $this->params['pass']['0']);
        $this->set('i', $i);
        $this->set('id_int', $id_int);
        $this->set('typeEvent', $typeEvent);
    }

    function getInterferingsByType()
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        $request = (isset($this->params['pass']) && !empty($this->params['pass']) && isset($this->params['pass']['1'])) ? $this->params['pass']['1'] : 0;
        $eventTypeId = intval($this->params['pass']['0']);
        $eventTypes = $this->EventType->getEventTypeById($eventTypeId);

        $this->set('eventTypes', $eventTypes);

        $interferingTypes = $this->InterferingTypeEventType->getInterferingTypeByEventType($eventTypeId);

        $EventTypeCategories = $this->EventTypeCategoryEventType->getEventTypeCategoryByEventType($eventTypeId);

        if ($request == 0) {
            $interferings = $this->Interfering->getInterferingsByTypes($interferingTypes);
        } else {
            $interferings = $this->Interfering->getInterferingList('all');
        }
        $this->set('selectbox', $interferings);
        $this->set('request', $request);
        $this->set('EventTypeCategories', $EventTypeCategories);
        $this->set('typeEvent', $this->params['pass']['0']);

    }


    function getMechaniciansAndWorkshops(){
        $this->layout = 'ajax';
        $fields = "names";
        $conditions = array('CustomerCategory.mechanician'=>1);
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields,$conditions);
        $workshops = $this->Workshop->getWorkshops('list');
        $this->set(compact('customers','workshops'));
    }

    function getInterferingsByCategory()
    {
        $this->setTimeActif();
        $this->layout = 'ajax';


        $type_id = $this->params['pass']['0'];
        $this->set('type_id', $type_id);
        $i = $this->params['pass']['1'];
        $id_int = $this->params['pass']['2'];

        $interferingTypes = $this->InterferingTypeEventType->find('list', array(
            'recursive' => 2,
            'fields' => array('interfering_type_id'),
            'conditions' => array('InterferingTypeEventType.event_type_id' => $type_id)
        ));


        $interferings = $this->Interfering->getInterferingsByTypes($interferingTypes);

        $this->set('selectbox', $interferings);

        $this->set('i', $i);
        $this->set('id_int', $id_int);

    }

    private function isWithDate($eventTypeId)
    {
        $this->setTimeActif();
        $eventType = $this->EventType->getEventTypeById($eventTypeId, 'all');
        return $eventType[0]['EventType']['with_date'];
    }

    function export()
    {
        $this->setTimeActif();

        if (isset($this->params['pass']['0']) && $this->params['pass']['0'] == "all_search" && ((isset($this->params['named']['keyword']) || isset($this->params['named']['type'])
                || isset($this->params['named']['car']) || isset($this->params['named']['user'])
                || isset($this->params['named']['customer']) || isset($this->params['named']['interfering'])
                || isset($this->params['named']['date']) || isset($this->params['named']['nextdate'])
                || isset($this->params['named']['created']) || isset($this->params['named']['created1'])
                || isset($this->params['named']['parc'])
                || isset($this->params['named']['modified_id'])
                || isset($this->params['named']['modified']) || isset($this->params['named']['modified1'])
                || isset($this->params['named']['pay_customer']) || isset($this->params['named']['refund'])
                || isset($this->request->data['named']['validated']) || isset($this->request->data['named']['request'])
            ))
        ) {

            $conditions = $this->getConds();
            $events = $this->EventEventType->getEventsByCond($conditions);

        } else {
            if (isset($this->params['pass']['0']) && $this->params['pass']['0'] == "all") {

                $events = $this->EventEventType->getEventsByCond(array("Event.request" => 0));

            } else {
                if (isset($this->params['pass']['0']) && $this->params['pass']['0'] == "all_request") {
                    $events = $this->EventEventType->getEventsByCond(array("Event.request" => 1));


                } else {
                    $ids = filter_input(INPUT_POST, "chkids");
                    $array_ids = explode(",", $ids);
                    $events = $this->EventEventType->getEventsByCond(array("Event.id" => $array_ids));
                }

            }
        }
        $this->set('models', $events);

        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set('param', $param);
    }


    // update cell
    function update()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $value = filter_input(INPUT_POST, "value");
        $crypto = $this->decrypt(filter_input(INPUT_POST, "crypto"));
        $explode = explode('|', $crypto);
        $columnName = $explode[0];
        $id = $explode[1];
        $event = $this->Event->find('all', array(
            'recursive' => -1,
            'conditions' => array('id' => $id)
        ));
        if ($columnName == "date" || $columnName == "next_date") {
            $value = $this->getDatetimeFromDate($value);
        }
        if (!empty($event)) {
            $event[0]['Event'][$columnName] = $value;
            $this->Event->save($event[0]);
        }
    }


    // update cell
    function updateKm()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $value = filter_input(INPUT_POST, "value");
        $crypto = $this->decrypt(filter_input(INPUT_POST, "crypto"));
        $explode = explode('|', $crypto);
        $id = $explode[1];


            $this->Event->id = $id;
            if ($this->Event->saveField('km', $value)){
                echo json_encode(array("response" => true));
            }else {
                echo json_encode(array("response" => false));
            }




    }

    // update cell
    function updateDate()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $value = filter_input(INPUT_POST, "value");
        $crypto = $this->decrypt(filter_input(INPUT_POST, "crypto"));
        $explode = explode('|', $crypto);
        $id = $explode[1];

            $this->request->data['Event']['date']= $value;
            $this->createDateFromDate('Event', 'date');
            $this->Event->id = $id;
            if ( $this->Event->saveField('date', $this->request->data['Event']['date'])){
                echo json_encode(array("response" => true));
            } else {
                echo json_encode(array("response" => false));
            }



    }



    function lock()
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $current = $this->Event->find("first", array("conditions" => array("Event.id" => $this->params['pass']['0'])));
        $this->verifyUserPermission(SectionsEnum::evenement, $user_id, ActionsEnum::lock, "Events",
            $this->params['pass']['0'], "Event", null);
        $result = $this->setLocked('Event', $this->params['pass']['0'], 1);
        if ($result) {
            $this->Flash->success(__('The event has been locked.'));
        } else {
            $this->Flash->success(__('The event could not be locked.'));
        }

        if ($current ['Event']['request'] == 1) {
            $this->redirect(array('action' => 'index_request'));
        } else {
            $this->redirect(array('action' => 'index'));
        }
    }

    function unlock()
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $current = $this->Event->find("first", array("conditions" => array("Event.id" => $this->params['pass']['0'])));
        $this->verifyUserPermission(SectionsEnum::evenement, $user_id, ActionsEnum::lock, "Events",
            $this->params['pass']['0'], "Event", null);
        $result = $this->setLocked('Event', $this->params['pass']['0'], 0);
        if ($result) {
            $this->Flash->success(__('The event has been unlocked.'));
        } else {
            $this->Flash->error(__('The event could not be unlocked.'));
        }

        if ($current ['Event']['request'] == 1) {
            $this->redirect(array('action' => 'index_request'));
        } else {
            $this->redirect(array('action' => 'index'));
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
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::evenement, $user_id, ActionsEnum::delete, "Events", $id, "Event",
            null);
        $this->Event->id = $id;
        if (!$this->Event->exists()) {
            throw new NotFoundException(__('Invalid event'));
        }
        $current = $this->Event->find('first',
            array(
                'recursive' => -1,
                'paramType' => 'querystring',
                'conditions' => array('Event.id' => $id),
                'fields' => array(
                    'Event.car_id',
                    'Event.id',
                    'Event.locked',
                    'Event.request',
                    'EventEventType.event_type_id'

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
                )
            ));

        $this->request->allowMethod('post', 'delete');
        if ($current['Event']['locked']) {
            $this->Flash->error(__('You must first unlock the event.'));
            $this->redirect(array('action' => 'index'));
        }
        $this->verifyDependences($id);

        if ($this->Event->delete()) {
            $this->saveUserAction(SectionsEnum::evenement, $id, $this->Session->read('Auth.User.id') , ActionsEnum::delete);
            $this->setSessionAlerts($current['Event']['car_id'], $current['EventEventType']['event_type_id']);
            $this->getTotalNbAlerts();
            $eventNotifications = $this->Notification->find('all',array('conditions' =>
                array('Notification.event_id' => $id)));
            $nbNotifications = $this->Session->read("nbNotifications");
            foreach ($eventNotifications as $eventNotification){
                if ($this->Notification->delete($eventNotification['Notification']['id'])){
                    $nbNotifications = intval($nbNotifications) - 1;
                }
            }
            $this->Session->write("nbNotifications" , $nbNotifications);
            $this->Flash->success(__('The event has been deleted.'));
        } else {
            $this->Flash->error(__('The event could not be deleted. Please, try again.'));
        }

        if ($current ['Event']['request'] == 1) {
            $this->redirect(array('action' => 'index_request'));
        } else {
            $this->redirect(array('action' => 'index'));
        }
    }

    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $bill = $this->Bill->find("first", array(
                    "conditions" => array("Bill.event_id" => $id),
                    'recursive' =>-1
        ));
        $this->EventCategoryInterfering->deleteAll(array('EventCategoryInterfering.event_id' => $id), false);
        $event_event_types = $this->EventEventType->find('all',
            array(
                "conditions" => array("EventEventType.event_id" => $id),
                'recursive' =>-1
                ));
        if (!empty($event_event_types)) {
            $this->EventEventType->deleteAll(array('EventEventType.event_id' => $id), false);
        }
        if (Configure::read("gestion_commercial") == '1'  &&
            Configure::read("tresorerie") == '1') {
            $payments = $this->Payment->find('all',
                array(
                    "conditions" => array("Payment.event_id" => $id),
                    'recursive' => -1
                ));
            $paymentIds = array();
            foreach ($payments as $payment) {
                $paymentIds = $payment['Payment']['id'];
            }
            if (!empty($payments)) {
                $detailPayments = $this->DetailPayment->find('all',
                    array(
                        "conditions" => array("DetailPayment.payment_id" => $paymentIds),
                        'recursive' => -1
                    ));
            }

            if (!empty($detailPayments)) {
                $this->DetailPayment->deleteAll(array('DetailPayment.payment_id' => $paymentIds), false);
            }

            if (!empty($payments)) {
                $this->Payment->deleteAll(array('Payment.event_id' => $id), false);
            }
        }
        $this->loadModel('Alert');
        $alerts = $this->Alert->find('all',array(
            'conditions'=>array('Alert.object_id'=>$id),
            'recursive'=>-1
        ));
        if(!empty($alerts)){
            $this->Alert->deleteAll(array('Alert.object_id' => $id), false);
        }
        if (!empty($bill)) {
            $billId = $bill['Bill']['id'];
            $billProducts = $this->BillProduct->find('all',
                array("conditions" => array("BillProduct.bill_id =" => $billId)));
            if (!empty($billProducts)) {
                foreach ($billProducts as $billProduct) {
                    $productId = $billProduct['BillProduct']['product_id'];
                    $product = $this->Product->getProductById($productId);
                    $dataProduct = array();
                    $dataProduct['Product']['id'] = $product['Product']['id'];
                    $billProduct = $this->BillProduct->find('first', array(
                        'conditions' => array(
                            'BillProduct.bill_id' => $id,
                            'BillProduct.product_id' => $productId
                        )));
                    if (!empty($billProduct)) {
                        $dataProduct['Product']['quantity'] = $product['Product']['quantity'] + $billProduct['BillProduct']['quantity'];
                    }
                    $this->Product->save($dataProduct);
                }
                $this->BillProduct->deleteAll(array('BillProduct.bill_id' => $id), false);
            }
            $this->Bill->delete($billId);
            $this->setProductQuantitySessionAlerts();
        }

    }

    public function deleteevents()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::evenement, $user_id, ActionsEnum::delete, "Events", $id, "Event",
            null);
        $this->Event->id = $id;
        $this->request->allowMethod('post', 'delete');
        $current = $this->Event->find('first',
            array(
                'recursive' => -1,
                'paramType' => 'querystring',
                'conditions' => array('Event.id' => $id),
                'fields' => array(
                    'Event.car_id',
                    'Event.id',
                    'Event.locked',
                    'EventEventType.event_type_id'

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


                )

            ));
        if (!$current['Event']['locked']) {
            $this->verifyDependences($id);
            if ($this->Event->delete()) {

                $this->setSessionAlerts($current['Event']['car_id'], $current['EventEventType']['event_type_id']);
                $this->getTotalNbAlerts();
                echo json_encode(array("response" => "true"));
            } else {
                echo json_encode(array("response" => "false"));
            }
        } else {
            echo json_encode(array("response" => "false"));
        }
        /* }else{
            echo json_encode(array("response" => "false"));
        }*/
    }

    public function index_request()
    {

        $this->setTimeActif();
        $userId = intval($this->Auth->user('id'));
        $parcIds = $this->getParcsUserIdsArray($userId);

        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $cond = $this->getConditionsRequest();
        $conditions = $cond[0];
        $conditions_car = $cond[1];
        $conditions_customer = $cond[2];
        if (!$this->IsAdministrator && !empty($parcIds)) {
            $conditions = array_merge($conditions, array('Car.parc_id' => $parcIds));
        }
        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => $limit,
            'order' => array('Event.id' => 'DESC'),
            'conditions' => $conditions,
            'fields' => array(
                'Event.code',
                'Event.id',
                'Event.date',
                'Event.next_date',
                'Event.km',
                'Event.next_km',
                'Event.cost',
                'Event.locked',
                'Event.transferred',
                'Event.validated',
                'Event.canceled',
                'Event.made_event',
                'Customer.id',
                'Customer.first_name',
                'Customer.last_name',
                'Customer.company',
                'Interfering.name',
                'Car.code',
                'Car.immatr_def',
                'Event.user_id',
                'Car.parc_id',
                'Carmodel.name',
                'EventType.name',
                'Event.alert',
                'Event.multiple_event',
                'Event.attachment1',
                'Event.attachment2',
                'Event.attachment3',
                'Event.attachment4',
                'Event.attachment5'
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
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Event.customer_id = Customer.id')
                ),
                array(
                    'table' => 'event_category_interfering',
                    'type' => 'left',
                    'alias' => 'EventCategoryInterfering',
                    'conditions' => array('EventCategoryInterfering.event_id = EventEventType.event_id')
                ),
                array(
                    'table' => 'interferings',
                    'type' => 'left',
                    'alias' => 'Interfering',
                    'conditions' => array('EventCategoryInterfering.interfering_id0 = Interfering.id')
                ),
                array(
                    'table' => 'interferings',
                    'type' => 'left',
                    'alias' => 'Interfering1',
                    'conditions' => array('EventCategoryInterfering.interfering_id1 = Interfering1.id')
                ),
                array(
                    'table' => 'interferings',
                    'type' => 'left',
                    'alias' => 'Interfering2',
                    'conditions' => array('EventCategoryInterfering.interfering_id2 = Interfering2.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'parcs',
                    'type' => 'left',
                    'alias' => 'Parc',
                    'conditions' => array('Car.parc_id = Parc.id')
                )
            )
        );
        $events = $this->Paginator->paginate('EventEventType');
        $this->set('events', $events);
        $interferings = $this->Interfering->getInterferingList();
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        if ($roleId != 3) {
            $administratifEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::administratif_evenement,
                ActionsEnum::view, $profileId, $roleId);
            $maintenanceEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::maintenance_evenement,
                ActionsEnum::view, $profileId, $roleId);
            if(($administratifEventPermission == 1) && ($maintenanceEventPermission == 1)){
                $eventTypes = $this->EventType->getEventTypes();
            }elseif(($administratifEventPermission == 1) && ($maintenanceEventPermission == 0)){
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id' => 8);
                $eventTypes = $this->EventType->getEventTypes('list', null , null , $eventTypeConditions);
            }elseif(($administratifEventPermission == 0) && ($maintenanceEventPermission == 1)){
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id !=' => 8);
                $eventTypes = $this->EventType->getEventTypes('list', null , null , $eventTypeConditions);
            }
        }else {
            $eventTypes = $this->EventType->getEventTypes();
        }
        $sumCost = $this->Event->getSumCost($conditions);
        $param = $this->Parameter->getCodesParameterVal('name_car');

        if (!empty($parcIds)) {
            if(!empty($conditions_car)){
                $conditions_car = array_merge($conditions_car, array('Car.parc_id' => $parcIds));
            }else{
                $conditions_car = array('Car.parc_id' => $parcIds);
            }
        }
        $cars = $this->Car->getCarsByFieldsAndConds($param, null, $conditions_car);

        $fields = "names";

        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions_customer);
        $users = $this->Event->User->find('list', array('conditions' => array('User.id !=' => 1)));
        $profiles = $this->Profile->getUserProfiles();
        if (!empty($parcIds)) {
            $parcs = $this->Parc->getParcByIds($parcIds);
        } else {
            $parcs = $this->Parc->getParcs('list');
        }
        $nb_parcs = count($parcIds);
        $hasParc = $this->verifyUserParcPermission(SectionsEnum::evenement);
        $permissionValidate = $this->AccessPermission->getPermissionWithParams(SectionsEnum::valider_demande_intervention,
            ActionsEnum::view, $profileId, $roleId);
        $permissionCancel = $this->AccessPermission->getPermissionWithParams(SectionsEnum::annuler_demande_intervention,
            ActionsEnum::view, $profileId, $roleId);
        $permissionTransfer = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transferer_demande_intervention,
            ActionsEnum::view, $profileId, $roleId);
        $permissionMakeEvent = $this->AccessPermission->getPermissionWithParams(SectionsEnum::rendre_demande_intervention_evenement,
            ActionsEnum::view, $profileId, $roleId);
        $printInterventionRequest = $this->AccessPermission->getPermissionWithParams(SectionsEnum::demande_intervention,
            ActionsEnum::printing, $profileId, $roleId);
        $editKmDate = $this->AccessPermission->getPermissionWithParams(SectionsEnum::modification_km_date,
            ActionsEnum::view, $profileId, $roleId);
        $isSuperAdmin = $this->isSuperAdmin();
        $this->set(compact('profiles', 'cars', 'customers', 'users',
            'interferings', 'eventTypes', 'sumCost', 'limit','editKmDate',
            'parcs', 'hasParc', 'nb_parcs', 'param', 'conditions',
            'conditions_car', 'conditions_customer','permissionMakeEvent','isSuperAdmin',
            'permissionValidate','permissionCancel','permissionTransfer','printInterventionRequest'
            ));
    }

    public function validateRequest()
    {
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        $permissionValidate = $this->AccessPermission->getPermissionWithParams(SectionsEnum::valider_demande_intervention,
            ActionsEnum::view, $profileId, $roleId);
        if ($permissionValidate != 1) {
            $this->Flash->error(__("You don't have permission to do this action."));
            $this->redirect(array('action' => 'index_request'));
        } else {
            $ids = filter_input(INPUT_POST, "chkids");
            $arrayIds = explode(",", $ids);
            foreach ($arrayIds as $id){
            $this->Event->id = $id;
            $this->Event->saveField('validated', 1);
                $userId = $this->Auth->user('id');
                $actionId = ActionsEnum::validate;
                $sectionId = SectionsEnum::validation_demande_intervention;
                $this->Notification->addNotification($id, $userId, $actionId,$sectionId,'Event');
                $this->getNbNotificationsByUser();
                $this->saveUserAction(SectionsEnum::demande_intervention, $id, $userId, $actionId);
            }

            $this->Flash->success(__('The request has been validated.'));
            $this->redirect(array('action' => 'index_request'));

        }
    }
    public function cancelRequest()
    {
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        $permissionCancel = $this->AccessPermission->getPermissionWithParams(SectionsEnum::annuler_demande_intervention,
            ActionsEnum::view, $profileId, $roleId);
        if ($permissionCancel != 1) {
            $this->Flash->error(__("You don't have permission to do this action."));
            $this->redirect(array('action' => 'index_request'));
        } else {
            $ids = filter_input(INPUT_POST, "chkids");
            $arrayIds = explode(",", $ids);
            foreach ($arrayIds as $id) {
                $this->Event->id = $id;
                $this->Event->saveField('canceled', 1);
                $userId = $this->Auth->user('id');
                $actionId = ActionsEnum::cancel;
                $sectionId = SectionsEnum::annulation_demande_intervention;
                $this->Notification->addNotification($id, $userId, $actionId,$sectionId,'Event');
                $this->getNbNotificationsByUser();
                $this->saveUserAction(SectionsEnum::demande_intervention, $id, $userId, $actionId);
            }
            $this->Flash->success(__('The request has been canceled.'));
            $this->redirect(array('action' => 'index_request'));

        }
    }

    public function transferRequest()
    {
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        $permissionTransfer = $this->AccessPermission->getPermissionWithParams(SectionsEnum::transferer_demande_intervention,
            ActionsEnum::view, $profileId, $roleId);
        if ($permissionTransfer != 1) {
            $this->Flash->error(__("You don't have permission to do this action."));
            $this->redirect(array('action' => 'index_request'));
        } else {
            $ids = filter_input(INPUT_POST, "chkids");
            $arrayIds = explode(",", $ids);
            foreach ($arrayIds as $id) {
                $this->Event->id = $id;
                $event = $this->Event->find('first',array('recursive'=>-1,
                    'conditions'=>array('Event.id'=>$id),'fields'=>array('validated','canceled')));
                if($event['Event']['validated']==1 && $event['Event']['canceled']==0){

                    $this->Event->saveField('transferred', 1);
                    $userId = $this->Auth->user('id');
                    $actionId = ActionsEnum::transfer;
                    $sectionId = SectionsEnum::transfert_demande_intervention;
                    $this->Notification->addNotification($id, $userId, $actionId,$sectionId,'Event');
                    $this->getNbNotificationsByUser();
                    $this->saveUserAction(SectionsEnum::demande_intervention, $id, $userId, $actionId);
                    $this->Flash->success(__('The request has been transferred.'));
                }else {
                    $this->Flash->error(__('The request could be validated and not canceled.'));
                }
            }

            $this->redirect(array('action' => 'index_request'));
        }

    }
    public function makeEvent()
    {
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        $permissionMakeEvent = $this->AccessPermission->getPermissionWithParams(SectionsEnum::rendre_demande_intervention_evenement,
            ActionsEnum::view, $profileId, $roleId);
        if ($permissionMakeEvent != 1) {
            $this->Flash->error(__("You don't have permission to do this action."));
            $this->redirect(array('action' => 'index_request'));
        } else {
            $ids = filter_input(INPUT_POST, "chkids");
            $arrayIds = explode(",", $ids);
            foreach ($arrayIds as $id) {
                $this->Event->id = $id;
                $event = $this->Event->find('first',array('recursive'=>-1,
                    'conditions'=>array('Event.id'=>$id),'fields'=>array('validated','canceled','transferred')));
                if($event['Event']['validated']==1 &&
                    $event['Event']['canceled']==0 &&
                    $event['Event']['transferred']==1
                ){

                    $this->Event->saveField('made_event', 1);
                    $userId = $this->Auth->user('id');
                    $actionId = ActionsEnum::made_event;
                    $sectionId = SectionsEnum::rendre_demande_intervention_evenement;
                    $this->Notification->addNotification($id, $userId, $actionId,$sectionId,'Event');
                    $this->getNbNotificationsByUser();
                    $this->saveUserAction(SectionsEnum::demande_intervention, $id, $userId, $actionId);
                    $this->Flash->success(__('The request has been made event.'));
                }else {
                    $this->Flash->error(__('The request could be validated and transferred.'));
                }
            }

            $this->redirect(array('action' => 'index_request'));
        }

    }

    function addProductBill($nb_product = null)
    {
        $this->layout = 'ajax';
        // die ($product_id);
        if (Configure::read("cafyb") == '1') {
            $products = $this->Cafyb->getProducts();
        }else {
            $this->Product->virtualFields = array('cnames' => "Product.name");
            $products = $this->Product->find('list', array(
                'recursive' => -1,
                'fields' => 'cnames',
                'joins' => array(
                    array(
                        'table' => 'product_categories',
                        'type' => 'left',
                        'alias' => 'ProductCategory',
                        'conditions' => array('Product.product_category_id = ProductCategory.id')
                    ),
                )
            ));
        }

        $suppliers = $this->Supplier->getSuppliersByParams(0, 1);
        $this->set('num_product', $nb_product);
        $this->set(compact('products','suppliers'));

    }

    function quantityProduct($num = null, $productId = null)
    {
        $this->layout = 'ajax';

        if (Configure::read("cafyb") == '1') {
            $product = $this->Cafyb->getProductById($productId);
        }else {
            $product = $this->Product->getProductById($productId);
        }

        $this->set(compact('product', 'num'));
    }

    public function import()
    {
        if (!empty($this->request->data['Event']['file_csv']['tmp_name'])) {

            if (is_uploaded_file($this->request->data['Event']['file_csv']['tmp_name'])) {
                $fichier = $this->request->data['Event']['file_csv']['name'];
                $ext = substr(strtolower(strrchr($fichier, '.')), 1);
                if ($ext == 'csv') {
                    if ($fichier) {
                        $fp = fopen($this->request->data['Event']['file_csv']['tmp_name'], "r");

                    } else {

                        echo('fichier introuvable');
                        exit();
                    }
                    $cpt = 0;
                    while (!feof($fp)) {

                        $ligne = fgets($fp, 4096);
                        $liste = explode(";", $ligne);
                        filter_input(INPUT_POST, 'file_csv');
                        $liste[0] = (isset($liste[0])) ? $liste[0] : '';
                        $liste[1] = (isset($liste[1])) ? $liste[1] : null;
                        $liste[2] = (isset($liste[2])) ? $liste[2] : null;
                        $liste[3] = (isset($liste[3])) ? $liste[3] : null;
                        $liste[4] = (isset($liste[4])) ? $liste[4] : null;
                        $liste[5] = (isset($liste[5])) ? $liste[5] : null;
                        $liste[6] = (isset($liste[6])) ? $liste[6] : null;
                        $liste[7] = (isset($liste[7])) ? $liste[7] : null;
                        $liste[8] = (isset($liste[8])) ? $liste[8] : null;
                        $liste[9] = (isset($liste[9])) ? $liste[9] : null;
                        $liste[10] = (isset($liste[10])) ? $liste[10] : null;
                        $liste[11] = (isset($liste[11])) ? $liste[11] : null;
                        $code_event = $liste[0];
                        $type_event = $liste[1];
                        $immatr_car = $liste[2];
                        $interfering = $liste[4];
                        $date_start = $liste[5];
                        $date_end = $liste[6];
                        $km_start = $liste[7];
                        $km_end = $liste[8];
                        $cout = $liste[9];

                        $num_assur = $liste[10];

                        $obs = $liste[11];

                        $type_event = $this->Id_Type_Event($type_event);

                        $car = $this->Id_Car($immatr_car);

                        $interfering = $this->ID_Interfering($interfering);


                        if (($cpt > 0) && ($type_event != 0)) {
                            $this->Event->create();
                            $this->request->data['Event']['code'] = $code_event;
                            $this->request->data['Event']['car_id'] = $car;
                            $this->request->data['Event']['customer_id'] = null;
                            $this->request->data['Event']['event_type_id'] = $type_event;
                            $this->request->data['Event']['interfering_id'] = $interfering;
                            $this->request->data['Event']['date'] = $date_start;
                            $this->request->data['Event']['next_date'] = $date_end;
                            $this->createDatetimeFromDate('Event', 'date');
                            $this->createDatetimeFromDate('Event', 'next_date');
                            $this->request->data['Event']['km'] = $km_start;
                            $this->request->data['Event']['km_end'] = $km_end;
                            $this->request->data['Event']['cost'] = $cout;
                            $this->request->data['Event']['obs'] = $obs;
                            $this->request->data['Event']['request'] = 0;
                            $this->request->data['Event']['validated'] = 1;
                            $this->request->data['Event']['transferred'] = 1;
                            $this->request->data['Event']['made_event'] = 1;
                            $this->request->data['Event']['assurance_number'] = $num_assur;


                            $this->request->data['Event']['user_id'] = $this->Session->read('Auth.User.id');

                            if ($this->Event->save($this->request->data)){
                                $event_id = $this->Event->getInsertID();
                                $this->EventEventType->create();
                                $data = array();
                                $data['EventEventType']['event_id'] = $event_id;
                                $data['EventEventType']['event_type_id'] = $type_event;
                                $this->EventEventType->save($data);
                            }

                        }

                        $cpt++;

                    }
                    fclose($fp);

                    $this->Flash->success(__('The file has been successfully imported'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->error(__('The file must be in csv format'));
                    $this->redirect(array('action' => 'index'));

                }

            }

        }

    }

    public function ID_Type_Event($type_event_name_import)
    {

        $type_event_name_import = trim($type_event_name_import);
        $type_event_name_import = strtolower($type_event_name_import);
        $type_event_id = 0;
        $eventTypes = $this->EventType->getEventTypes('all');
        foreach ($eventTypes as $eventType) {
            $type_event_name = strtolower($eventType['EventType']['name']);

            if ($type_event_name_import == $type_event_name) {
                $type_event_id = $eventType['EventType']['id'];
            }
        }
        return $type_event_id;
    }

    public function ID_Car($immatr_car_import)
    {
        $immatr_car_import = trim($immatr_car_import);
        $immatr_car_import = strtolower($immatr_car_import);
        $car_id = 0;
        $cars = $this->Car->find('all', array('recursive' => -1));
        foreach ($cars as $car) {
            $car_immatr = strtolower($car['Car']['immatr_def']);

            if ($immatr_car_import == $car_immatr) {
                $car_id = $car['Car']['id'];

            }
        }
        return $car_id;

    }

    public function ID_Customer($customer_name_import)
    {
        $customer_name_import = trim($customer_name_import);
        $customer_name_import = strtolower($customer_name_import);
        $customer_id = 0;
        $customers = $this->Customer->find('all', array('recursive' => -1));
        foreach ($customers as $customer) {
            $customer_name = strtolower($customer['Customer']['last_name']);

            if ($customer_name_import == $customer_name) {
                $customer_id = $customer['Customer']['id'];

            }
        }
        return $customer_id;

    }

    public function ID_Interfering($interfering_name_import)
    {
        $interfering_name_import = trim($interfering_name_import);
        $interfering_name_import = strtolower($interfering_name_import);
        $interfering_id = 0;
        $interferings = $this->Interfering->getInterferingList('all');
        foreach ($interferings as $interfering) {
            $interfering_name = strtolower($interfering['Interfering']['name']);

            if ($interfering_name_import == $interfering_name) {
                $interfering_id = $interfering['Interfering']['id'];
            }
        }
        return $interfering_id;

    }

    public function openDir()
    {
        $dir = $this->params['pass']['0'];
        $id_dialog = $this->params['pass']['1'];
        $id_input = $this->params['pass']['2'];

        $this->layout = 'ajax';


        //$this->verifAttachment('Car', 'file', 'attachments/yellowcards/', 'add',1,0,null);

        if (!empty($this->request->data['Event']['file']['tmp_name'])) {


        }

        $array_fichier = array();
        $i = 0;

        if ($dossier = opendir('./attachments/' . $dir)) {
            while (false !== ($fichier = readdir($dossier))) {
                if ($fichier != '.' && $fichier != '..' && $fichier != 'index.php') {
                    $array_fichier[$i] = $fichier;
                    $i++;

                } // On ferme le if (qui permet de ne pas afficher index.php, etc.)

            }

            closedir($dossier);
        } else {
            echo 'Le dossier n\' a pas pu etre ouvert';
        }


        $this->set('array_fichier', $array_fichier);
        $this->set('dir', $dir);
        $this->set('id_dialog', $id_dialog);
        $this->set('id_input', $id_input);
    }

    function uploadPicture()
    {


        $this->layout = 'ajax';


        $this->set('file_name', $this->params['pass']['0']);
        $this->set('Dir', $this->params['pass']['1']);

    }

    private function disableAlerts($car_id = null, $event_type_id = null)
    {


        $this->Event->recursive = -1;
        $Events = $this->EventEventType->find('all',
            array(
                'recursive' => -1,
                'conditions' => array(

                    'EventEventType.event_type_id = ' => $event_type_id,
                    'Event.alert = ' => 0,
                    'Event.car_id = ' => $car_id
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
                ),
                'order' => 'Event.id DESC, Event.date DESC'
            ));


        if (!empty($Events)) {

            $AlertEvents = $this->Event->find('all',

                array(
                    'recursive' => -1,
                    'conditions' => array(

                        'EventEventType.event_type_id = ' => $event_type_id,
                        'Event.alert = ' => 1,
                        'Event.car_id = ' => $car_id
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
                        )
                    ),
                    'order' => 'Event.date DESC'
                ));


            if (!empty($AlertEvents)) {

                foreach ($AlertEvents as $AlertEvent) {

                    $this->Event->id = $AlertEvent['Event']['id'];

                    $this->Event->saveField('alert', 2);

                }

            }

        }


    }

    /*private function activateAlerts($car_id=null, $event_type_id=null) {


        $this->Event->recursive = -1;
        $Events = $this->Event->find('all', array('conditions' => array(
            
            'Event.event_type_id = ' => $event_type_id,
            'Event.alert = ' => 0,
            'Event.car_id = '=>$car_id
            ),
            'order'=>'Event.next_date DESC'));
            


        if(empty($Events)){
        if ($event_type_id==1) {
        $vidangeAlert = $this->Parameter->find('first', array('conditions' => array('Parameter.id = ' => 4)));
        $limitedKm = $vidangeAlert['Parameter']['val'];
        $this->Event->recursive = 2;
        $AlertEvents = $this->Event->getKmAlert($limitedKm, 1);

        }
        if ($event_type_id==2) {

            $assuranceAlert = $this->Parameter->find('first', array('conditions' => array('Parameter.id = ' => 1)));
        $limitedDate = date('Y-m-d H:i:s', strtotime('+' . $assuranceAlert['Parameter']['val'] . ' days'));
        $this->Event->recursive = 2;
        $AlertEvents = $this->Event->find('all', array('conditions' => array(
            'Event.next_date <= ' => $limitedDate,
            'Event.event_type_id = ' => 2,
            'EventType.alert_activate' =>1,
            'Event.alert != ' => 2)

        ));


        }

        if ()
        


            if (!empty($AlertEvents)) {

            foreach($AlertEvents as $AlertEvent) {

            $this->Event->id = $AlertEvent['Event']['id'] ;
              $this->Event->saveField('alert',1);
            }

            }

        }


}*/


    public function getLocalisation($id = null)
    {
        $this->layout = 'ajax';
        if ($id != null) {

            $localisation = $this->Event->find('first', array(
                'conditions' => array('Event.id' => $id),
                'fields' => array('place', 'latlng', 'payed', 'contravention_type_id','driving_licence_withdrawal'),
                'recursive' => -1
            ));

            $this->set('localisation', $localisation);

        }
        $this->set('id', $id);

    }

    public function addPayment()
    {
        $this->layout = 'ajax';
        $this->set('nb_payment', $this->params['pass']['0']);

        $interferings = $this->Interfering->getInterferingList();
        if (Configure::read("cafyb") == '1') {
            $comptes = $this->Cafyb->getAccounts();
            $paymentMethods = $this->Cafyb->getPaymentMethods();
        }else {
            $comptes = $this->Payment->Compte->find('list');
        }
        $this->set(compact('interferings', 'comptes','paymentMethods'));
    }


    public function getConditions()
    {

        $userId = intval($this->Auth->user('id'));
        $parcIds = $this->getParcsUser($userId);
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        if ($roleId != 3) {
            $administratifEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::administratif_evenement,
                ActionsEnum::view, $profileId, $roleId);
            $maintenanceEventPermission = $this->AccessPermission->getPermissionWithParams(SectionsEnum::maintenance_evenement,
                ActionsEnum::view, $profileId, $roleId);
        }else {
                $administratifEventPermission =1;
                $maintenanceEventPermission = 1;
            }

            if(($administratifEventPermission==1) &&($maintenanceEventPermission==0)){
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id' => 8);
                $result = $this->verifyUserPermission(SectionsEnum::administratif_evenement, $userId , ActionsEnum::view, "Events", null, "Event", null);
                if (!$this->verifyUserParcPermission(SectionsEnum::administratif_evenement)) {
                    switch ($result) {
                        case 1 :
                            if($parcIds !=''){
                                $conditions = array('Car.parc_id IN ' . $parcIds, 'Event.made_event' => 1);
                                $conditions_car = array('Car.parc_id IN ' . $parcIds, 'Car.car_status_id !=' => 27);
                                $conditions_customer = array('Customer.parc_id IN ' . $parcIds);
                            }else {
                                $conditions = array('Car.parc_id' => $parcIds, 'Event.made_event' => 1);
                                $conditions_car = array('Car.parc_id' => $parcIds, 'Car.car_status_id !=' => 27);
                                $conditions_customer = array('Customer.parc_id' => $parcIds);
                            }

                            break;
                        case 2 :
                            if($parcIds !=''){
                                $conditions = array(
                                    'Event.user_id' => $userId,
                                    'Car.parc_id  IN ' . $parcIds,
                                    'Event.made_event' => 1
                                );
                                $conditions_car = array(
                                    'Car.user_id' => $userId,
                                    'Car.parc_id  IN ' . $parcIds,
                                    'Car.car_status_id !=' => 27
                                );
                                $conditions_customer = array('Customer.user_id' => $userId,
                                    'Customer.parc_id IN ' . $parcIds);
                            }else {
                                $conditions = array(
                                    'Event.user_id' => $userId,
                                    'Car.parc_id' => $parcIds,
                                    'Event.made_event' => 1
                                );
                                $conditions_car = array(
                                    'Car.user_id' => $userId,
                                    'Car.parc_id' => $parcIds,
                                    'Car.car_status_id !=' => 27
                                );
                                $conditions_customer = array('Customer.user_id' => $userId, 'Customer.parc_id' => $parcIds);
                            }


                            break;
                        case 3 :
                            if($parcIds !=''){
                                $conditions = array(
                                    'Event.user_id !=' => $userId,
                                    'Car.parc_id IN ' . $parcIds,
                                    'Event.made_event' => 1
                                );
                                $conditions_car = array(
                                    'Car.user_id !=' => $userId,
                                    'Car.parc_id IN ' . $parcIds,
                                    'Car.car_status_id !=' => 27
                                );
                                $conditions_customer = array('Customer.user_id' => $userId, 'Customer.parc_id IN ' . $parcIds);
                            }else {
                                $conditions = array(
                                    'Event.user_id !=' => $userId,
                                    'Car.parc_id' => $parcIds,
                                    'Event.made_event' => 1
                                );
                                $conditions_car = array(
                                    'Car.user_id !=' => $userId,
                                    'Car.parc_id' => $parcIds,
                                    'Car.car_status_id !=' => 27
                                );
                                $conditions_customer = array('Customer.user_id' => $userId, 'Customer.parc_id' => $parcIds);
                            }

                            break;
                        default:
                            if($parcIds !=''){
                                $conditions = array('Car.parc_id IN ' . $parcIds, 'Event.made_event' => 1);
                                $conditions_car = array('Car.parc_id IN ' . $parcIds, 'Car.car_status_id !=' => 27);
                                $conditions_customer = array('Customer.parc_id IN ' . $parcIds);
                            }else {
                                $conditions = array('Car.parc_id' => $parcIds, 'Event.made_event' => 1);
                                $conditions_car = array('Car.parc_id' => $parcIds, 'Car.car_status_id !=' => 27);
                                $conditions_customer = array('Customer.parc_id' => $parcIds);
                            }

                    }


                } else {
                    switch ($result) {
                        case 1 :
                            $conditions = array('Event.made_event' => 1);
                            $conditions_car = array('Car.car_status_id !=' => 27);
                            $conditions_customer = null;
                            break;
                        case 2 :
                            $conditions = array('Event.user_id' => $userId, 'Event.made_event' => 1);
                            $conditions_car = array('Car.user_id' => $userId, 'Car.car_status_id !=' => 27);
                            $conditions_customer = array('Customer.user_id' => $userId);
                            break;
                        case 3 :
                            $conditions = array('Event.user_id !=' => $userId, 'Event.made_event' => 1);
                            $conditions_car = array('Car.user_id !=' => $userId, 'Car.car_status_id !=' => 27);
                            $conditions_customer = array('Customer.user_id' => $userId);
                            break;
                        default:
                            $conditions = array('Event.made_event' => 1);
                            $conditions_car = array('Car.car_status_id !=' => 27);
                            $conditions_customer = null;

                    }

                }
                if($conditions!= null){
                    $conditions = array_merge($conditions, $eventTypeConditions);

                } else {
                    $conditions = $eventTypeConditions;
                }

            }elseif(($administratifEventPermission==0) &&($maintenanceEventPermission==1)) {
                $eventTypeConditions = array('EventTypeCategoryEventType.event_type_category_id !=' => 8);
                $result = $this->verifyUserPermission(SectionsEnum::maintenance_evenement, $userId , ActionsEnum::view, "Events", null, "Event", null);
                if (!$this->verifyUserParcPermission(SectionsEnum::maintenance_evenement)) {
                    switch ($result) {
                        case 1 :
                            if($parcIds !=''){
                                $conditions = array('Car.parc_id IN ' . $parcIds, 'Event.made_event' => 1);
                                $conditions_car = array('Car.parc_id IN ' . $parcIds, 'Car.car_status_id !=' => 27);
                                $conditions_customer = array('Customer.parc_id IN ' . $parcIds);
                            }else {
                                $conditions = array('Car.parc_id' => $parcIds, 'Event.made_event' => 1);
                                $conditions_car = array('Car.parc_id' => $parcIds, 'Car.car_status_id !=' => 27);
                                $conditions_customer = array('Customer.parc_id' => $parcIds);
                            }
                            break;
                        case 2 :
                            if($parcIds !=''){
                                $conditions = array(
                                    'Event.user_id' => $userId,
                                    'Car.parc_id IN ' . $parcIds,
                                    'Event.made_event' => 1
                                );
                                $conditions_car = array(
                                    'Car.user_id' => $userId,
                                    'Car.parc_id IN ' . $parcIds,
                                    'Car.car_status_id !=' => 27
                                );
                                $conditions_customer = array('Customer.user_id' => $userId, 'Customer.parc_id IN ' . $parcIds);
                            }else {
                                $conditions = array(
                                    'Event.user_id' => $userId,
                                    'Car.parc_id' => $parcIds,
                                    'Event.made_event' => 1
                                );
                                $conditions_car = array(
                                    'Car.user_id' => $userId,
                                    'Car.parc_id' => $parcIds,
                                    'Car.car_status_id !=' => 27
                                );
                                $conditions_customer = array('Customer.user_id' => $userId, 'Customer.parc_id' => $parcIds);
                            }

                            break;
                        case 3 :
                            if($parcIds !=''){
                                $conditions = array(
                                    'Event.user_id !=' => $userId,
                                    'Car.parc_id IN ' . $parcIds,
                                    'Event.made_event' => 1
                                );
                                $conditions_car = array(
                                    'Car.user_id !=' => $userId,
                                    'Car.parc_id IN ' . $parcIds,
                                    'Car.car_status_id !=' => 27
                                );
                                $conditions_customer = array('Customer.user_id' => $userId, 'Customer.parc_id IN ' . $parcIds);
                            }else {
                                $conditions = array(
                                    'Event.user_id !=' => $userId,
                                    'Car.parc_id IN ' . $parcIds,
                                    'Event.made_event' => 1
                                );
                                $conditions_car = array(
                                    'Car.user_id !=' => $userId,
                                    'Car.parc_id IN ' . $parcIds,
                                    'Car.car_status_id !=' => 27
                                );
                                $conditions_customer = array('Customer.user_id' => $userId, 'Customer.parc_id IN ' . $parcIds);
                            }

                            break;
                        default:
                            if($parcIds !=''){
                                $conditions = array('Car.parc_id' => $parcIds, 'Event.made_event' => 1);
                                $conditions_car = array('Car.parc_id' => $parcIds, 'Car.car_status_id !=' => 27);
                                $conditions_customer = array('Customer.parc_id' => $parcIds);
                            }else {
                                $conditions = array('Car.parc_id' => $parcIds, 'Event.made_event' => 1);
                                $conditions_car = array('Car.parc_id' => $parcIds, 'Car.car_status_id !=' => 27);
                                $conditions_customer = array('Customer.parc_id' => $parcIds);
                            }
                    }
                } else {
                    switch ($result) {
                        case 1 :
                            $conditions = array('Event.made_event' => 1);
                            $conditions_car = array('Car.car_status_id !=' => 27);
                            $conditions_customer = null;
                            break;
                        case 2 :
                            $conditions = array('Event.user_id' => $userId, 'Event.made_event' => 1);
                            $conditions_car = array('Car.user_id' => $userId, 'Car.car_status_id !=' => 27);
                            $conditions_customer = array('Customer.user_id' => $userId);
                            break;
                        case 3 :
                            $conditions = array('Event.user_id !=' => $userId, 'Event.made_event' => 1);
                            $conditions_car = array('Car.user_id !=' => $userId, 'Car.car_status_id !=' => 27);
                            $conditions_customer = array('Customer.user_id' => $userId);
                            break;
                        default:
                            $conditions = array('Event.made_event' => 1);
                            $conditions_car = array('Car.car_status_id !=' => 27);
                            $conditions_customer = null;

                    }

                }
                if($conditions!= null){
                    $conditions = array_merge($conditions, $eventTypeConditions);

                } else {
                    $conditions = $eventTypeConditions;
                }
            }elseif(($administratifEventPermission==1) &&($maintenanceEventPermission==1)){
                $eventTypeConditions= null;
                $result = $this->verifyUserPermission(SectionsEnum::administratif_evenement, $userId , ActionsEnum::view, "Events", null, "Event", null);
                if (!$this->verifyUserParcPermission(SectionsEnum::administratif_evenement)) {
                    switch ($result) {
                        case 1 :
                            if($parcIds !=''){
                                $conditions = array('Car.parc_id IN '. $parcIds, 'Event.made_event' => 1);
                                $conditions_car = array('Car.parc_id IN '. $parcIds, 'Car.car_status_id !=' => 27);
                                $conditions_customer = array('Customer.parc_id IN '.  $parcIds);
                            }else {
                                $conditions = array('Car.parc_id' => $parcIds, 'Event.made_event' => 1);
                                $conditions_car = array('Car.parc_id' => $parcIds, 'Car.car_status_id !=' => 27);
                                $conditions_customer = array('Customer.parc_id' => $parcIds);
                            }

                            break;
                        case 2 :
                            if($parcIds !=''){
                                $conditions = array(
                                    'Event.user_id' => $userId,
                                    'Car.parc_id IN '. $parcIds,
                                    'Event.made_event' => 1
                                );
                                $conditions_car = array(
                                    'Car.user_id' => $userId,
                                    'Car.parc_id IN '. $parcIds,
                                    'Car.car_status_id !=' => 27
                                );
                                $conditions_customer = array('Customer.user_id' => $userId, 'Customer.parc_id IN '. $parcIds);
                            }else {
                                $conditions = array(
                                    'Event.user_id' => $userId,
                                    'Car.parc_id' => $parcIds,
                                    'Event.made_event' => 1
                                );
                                $conditions_car = array(
                                    'Car.user_id' => $userId,
                                    'Car.parc_id' => $parcIds,
                                    'Car.car_status_id !=' => 27
                                );
                                $conditions_customer = array('Customer.user_id' => $userId, 'Customer.parc_id' => $parcIds);
                            }


                            break;
                        case 3 :
                            if($parcIds !=''){
                                $conditions = array(
                                    'Event.user_id !=' => $userId,
                                    'Car.parc_id IN '. $parcIds,
                                    'Event.made_event' => 1
                                );
                                $conditions_car = array(
                                    'Car.user_id !=' => $userId,
                                    'Car.parc_id IN '. $parcIds,
                                    'Car.car_status_id !=' => 27
                                );
                                $conditions_customer = array('Customer.user_id' => $userId, 'Customer.parc_id IN '. $parcIds);
                            }else {
                                $conditions = array(
                                    'Event.user_id !=' => $userId,
                                    'Car.parc_id' => $parcIds,
                                    'Event.made_event' => 1
                                );
                                $conditions_car = array(
                                    'Car.user_id !=' => $userId,
                                    'Car.parc_id' => $parcIds,
                                    'Car.car_status_id !=' => 27
                                );
                                $conditions_customer = array('Customer.user_id' => $userId, 'Customer.parc_id' => $parcIds);
                            }

                            break;
                        default:
                            if($parcIds !=''){
                                $conditions = array('Car.parc_id IN '. $parcIds, 'Event.made_event' => 1);
                                $conditions_car = array('Car.parc_id IN '. $parcIds, 'Car.car_status_id !=' => 27);
                                $conditions_customer = array('Customer.parc_id IN '. $parcIds);
                            }else {
                                $conditions = array('Car.parc_id IN '. $parcIds, 'Event.made_event' => 1);
                                $conditions_car = array('Car.parc_id IN '. $parcIds , 'Car.car_status_id !=' => 27);
                                $conditions_customer = array('Customer.parc_id IN '. $parcIds);
                            }

                    }


                } else {
                    switch ($result) {
                        case 1 :
                            $conditions = array('Event.made_event' => 1);
                            $conditions_car = array('Car.car_status_id !=' => 27);
                            $conditions_customer = null;
                            break;
                        case 2 :
                            $conditions = array('Event.user_id' => $userId, 'Event.made_event' => 1);
                            $conditions_car = array('Car.user_id' => $userId, 'Car.car_status_id !=' => 27);
                            $conditions_customer = array('Customer.user_id' => $userId);
                            break;
                        case 3 :
                            $conditions = array('Event.user_id !=' => $userId, 'Event.made_event' => 1);
                            $conditions_car = array('Car.user_id !=' => $userId, 'Car.car_status_id !=' => 27);
                            $conditions_customer = array('Customer.user_id' => $userId);
                            break;
                        default:
                            $conditions = array('Event.made_event' => 1);
                            $conditions_car = array('Car.car_status_id !=' => 27);
                            $conditions_customer = null;

                    }

                }
            }else {
                $this->verifyUserPermission(SectionsEnum::administratif_evenement, $userId , ActionsEnum::view, "Events", null, "Event", null);

            }

        $cond = array();
        $cond[0] = $conditions;
        $cond[1] = $conditions_car;
        $cond[2] = $conditions_customer;
        return $cond;

    }


    public function getConditionsRequest()
    {

        $userId = intval($this->Auth->user('id'));
        $parc_id = $this->getParcsUser($userId);
        $result = $this->verifyUserPermission(SectionsEnum::demande_intervention, $userId, ActionsEnum::view,
            "Events", null, "Event", null);
        if (!$this->verifyUserParcPermission(SectionsEnum::demande_intervention)) {
            switch ($result) {
                case 1 :
                    if($parc_id != ''){
                        $conditions = array('Car.parc_id IN '. $parc_id  , 'Event.request' => 1);
                        $conditions_car = array('Car.parc_id IN '.  $parc_id);
                        $conditions_customer = array('Customer.parc_id IN '.   $parc_id);
                    }else {
                        $conditions = array('Car.parc_id  '=> $parc_id  , 'Event.request' => 1);
                        $conditions_car = array('Car.parc_id  '=> $parc_id);
                        $conditions_customer = array('Customer.parc_id   '=>  $parc_id);
                    }

                    break;
                case 2 :
                    if($parc_id != ''){
                        $conditions = array('Event.user_id' => $userId, 'Car.parc_id  '=> $parc_id, 'Event.request' => 1);
                        $conditions_car = array('Car.user_id' => $userId, 'Car.parc_id  '=> $parc_id);
                        $conditions_customer = array('Customer.user_id' => $userId, 'Customer.parc_id  '=> $parc_id);
                    }else {
                        $conditions = array('Event.user_id' => $userId, 'Car.parc_id IN ' . $parc_id, 'Event.request' => 1);
                        $conditions_car = array('Car.user_id' => $userId, 'Car.parc_id IN '. $parc_id);
                        $conditions_customer = array('Customer.user_id' => $userId, 'Customer.parc_id IN ' . $parc_id);
                    }

                    break;
                case 3 :
                    if($parc_id != ''){
                        $conditions = array(
                            'Event.user_id !=' => $userId,
                            'Car.parc_id '=> $parc_id,
                            'Event.request' => 1
                        );
                        $conditions_car = array('Car.user_id' => $userId, 'Car.parc_id  '=> $parc_id);
                        $conditions_customer = array('Customer.user_id' => $userId, 'Customer.parc_id  '=> $parc_id);
                    }else {
                        $conditions = array(
                            'Event.user_id !=' => $userId,
                            'Car.parc_id IN ' . $parc_id,
                            'Event.request' => 1
                        );
                        $conditions_car = array('Car.user_id' => $userId, 'Car.parc_id IN '. $parc_id);
                        $conditions_customer = array('Customer.user_id' => $userId, 'Customer.parc_id IN '. $parc_id);
                    }

                    break;
                default:
                    if($parc_id != ''){
                        $conditions = array('Car.parc_id  ' => $parc_id, 'Event.request' => 1);
                        $conditions_car = array('Car.parc_id  ' => $parc_id);
                        $conditions_customer = array('Customer.parc_id  ' => $parc_id);
                    }else {
                        $conditions = array('Car.parc_id IN ' . $parc_id, 'Event.request' => 1);
                        $conditions_car = array('Car.parc_id IN ' . $parc_id);
                        $conditions_customer = array('Customer.parc_id IN ' . $parc_id);
                    }

            }

        } else {
            switch ($result) {
                case 1 :
                    $conditions = array('Event.request' => 1);
                    $conditions_car = null;
                    $conditions_customer = null;
                    break;
                case 2 :
                    $conditions = array('Event.user_id' => $userId, 'Event.request' => 1);
                    $conditions_car = array('Car.user_id !=' => $userId);
                    $conditions_customer = array('Customer.user_id !=' => $userId);
                    break;
                case 3 :
                    $conditions = array('Event.user_id !=' => $userId, 'Event.request' => 1);
                    $conditions_car = array('Car.user_id !=' => $userId);
                    $conditions_customer = array('Customer.user_id !=' => $userId);
                    break;
                default:
                    $conditions = array('Event.request' => 1);
                    $conditions_car = null;
                    $conditions_customer = null;
            }
        }

        $cond = array();
        $cond[0] = $conditions;
        $cond[1] = $conditions_car;
        $cond[2] = $conditions_customer;
        return $cond;

    }

    public function addMultipleEvents()
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::evenement, $user_id, ActionsEnum::add, "Events", null,
            "Event", null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index_request'));
        }
        if ($this->request->is('post')) {

            if (isset($this->request->data['Event']['date'])) {
                $date = $this->request->data['Event']['date'];
            }else{
                $date = null;
            }

            $this->Event->create();
            $data = array();
            $data['Event']['car_id'] = $this->request->data['Event']['car_id'];
            $data['Event']['customer_id'] = $this->request->data['Event']['customer_id'];
            $data['Event']['user_id'] = $this->Session->read('Auth.User.id');
            $data['Event']['request'] = 0;
            $data['Event']['validated'] = 1;
            $data['Event']['transferred'] = 1;
            $data['Event']['made_event'] = 1;
            if (isset($this->request->data['Event']['km'])) {
                $data['Event']['km'] = $this->request->data['Event']['km'];
            }
            if (isset($this->request->data['Event']['next_km'])) {
                $data['Event']['next_km'] = $this->request->data['Event']['next_km'];
            }
            $data['Event']['cost'] = $this->request->data['Event']['cost'];
            $this->request->data['Event']['date'] = $date;
            $this->createDatetimeFromDate('Event', 'date');
            $data['Event']['date'] = $this->request->data['Event']['date'];


            $this->Event->save($data);


            $event_id = $this->Event->getInsertID();

            foreach ($this->request->data['Event']['event_types'] as $event_type_id) {

                $this->EventEventType->create();
                $data = array();
                $data['EventEventType']['event_id'] = $event_id;
                $data['EventEventType']['event_type_id'] = $event_type_id;
                $this->EventEventType->save($data);
            }


            if (!empty($this->request->data['EventCategoryInterfering'])) {
                foreach ($this->request->data['EventCategoryInterfering'] as $EventCategoryInterfering) {
                    $this->EventCategoryInterfering->create();
                    $data = array();
                    $data['EventCategoryInterfering']['event_id'] = $event_id;
                    $data['EventCategoryInterfering']['interfering_id'] = $EventCategoryInterfering['interfering_id'];
                    $data['EventCategoryInterfering']['event_type_category_id'] = $EventCategoryInterfering['event_type_category'];
                    $data['EventCategoryInterfering']['cost'] = $EventCategoryInterfering['cost'];
                    $this->EventCategoryInterfering->save($data);

                }

            }

            $this->setCarPersistence($this->request->data['Event']['car_id']);
            $this->Flash->success(__('The event has been saved.'));

            $this->redirect(array('action' => 'index'));


        }
        $eventTypes = $this->EventType->getEventTypeByIdsNegation(array(1, 2, 3, 5, 11, 12, 13, 23));
        $param = $this->Parameter->getCodesParameterVal('name_car');

        $cond = $this->getConditions();
        $conditions_car = $cond[1];
        $conditions_customer = $cond[2];

        $cars = $this->Car->getCarsByFieldsAndConds($param, null, $conditions_car);
        $user_car = $this->getCarPersistence();
        if (!empty($user_car)) {
            $this->request->data['Event']['car_id'] = $user_car;
        }

        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions_customer);
        $this->set(compact('users', 'interferings', 'eventTypes', 'cars', 'customers'));

    }

    public function editMultipleEvents($id)
    {


        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::evenement, $user_id, ActionsEnum::edit, "Events", $id,
            "Event", null);
        if (!$this->Event->exists($id)) {
            throw new NotFoundException(__('Invalid event'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Event cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->createDatetimeFromDate('Event', 'date');
            $this->createDatetimeFromDate('Event', 'next_date');
            $this->createDatetimeFromDate('Event', 'date3');

            $this->request->data['Event']['user_id'] = $this->Session->read('Auth.User.id');
            $this->verifyAttachment('Event', 'attachment1', 'attachments/events/', 'edit', 0, $id);
            $this->request->data['Event']['modified_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['Event']['request'] = 0;
            $this->request->data['Event']['validated'] = 1;
            $this->request->data['Event']['transferred'] = 1;
            $this->request->data['Event']['made_event'] = 1;
            $this->request->data['Event']['is_open'] = 0;
            $this->request->data['Event']['multiple_event'] = 1;
            if ($this->Event->save($this->request->data)) {

                $this->EventEventType->deleteAll(array('EventEventType.event_id' => $id), false);

                foreach ($this->request->data['Event']['event_types'] as $event_type_id) {

                    $this->EventEventType->create();
                    $data = array();
                    $data['EventEventType']['event_id'] = $id;
                    $data['EventEventType']['event_type_id'] = $event_type_id;
                    $this->EventEventType->save($data);
                }
                $this->EventCategoryInterfering->deleteAll(array('EventCategoryInterfering.event_id' => $id), false);
                if (!empty($this->request->data['EventCategoryInterfering'])) {
                    foreach ($this->request->data['EventCategoryInterfering'] as $EventCategoryInterfering) {
                        $this->EventCategoryInterfering->create();
                        $data = array();
                        $data['EventCategoryInterfering']['event_id'] = $id;
                        $data['EventCategoryInterfering']['interfering_id'] = $EventCategoryInterfering['interfering_id'];
                        $data['EventCategoryInterfering']['event_type_category_id'] = $EventCategoryInterfering['event_type_category'];
                        $data['EventCategoryInterfering']['cost'] = $EventCategoryInterfering['cost'];
                        $this->EventCategoryInterfering->save($data);

                    }

                }
                $this->setCarPersistence($this->request->data['Event']['car_id']);
                $this->Flash->success(__('The request event has been saved.'));
                // Set alerts messages
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The request event could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
            $this->request->data = $this->Event->find('first', $options);
            $eventcategoryinterferings = $this->EventCategoryInterfering->find('all',
                array('conditions' => array('event_id' => $id)));
            $this->set('eventcategoryinterferings', $eventcategoryinterferings);
            $EventTypeCategories = $this->EventTypeCategoryEventType->find('all', array(
                'recursive' => 2,
                'fields' => array('event_type_category_id'),
                'conditions' => array('EventTypeCategoryEventType.event_type_id' => $this->request->data ['Event']['event_type_id'])
            ));
            $this->set('EventTypeCategories', $EventTypeCategories);
            if ($this->request->data['Event']['locked'] == 1) {
                $this->Flash->error(__('You must first unlock the event.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->isOpenedByOtherUser("Event", 'Events', 'event', $id);

        }
        $interferings = $this->Interfering->getInterferingList();
        $eventTypes = $this->EventType->getEventTypeByIdsNegation(array(1, 2, 3, 5, 11, 12, 13, 23));

        $eventTypesSelected = $this->EventEventType->getEventTypeIds($id);
        $param = $this->Parameter->getCodesParameterVal('name_car');

        $cond = $this->getConditions();
        $conditions_car = $cond[1];
        $conditions_customer = $cond[2];


        $cars = $this->Car->getCarsByFieldsAndConds($param, null, $conditions_car);

        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions_customer);
        $this->set(compact('users', 'interferings', 'eventTypes', 'cars', 'customers', 'eventTypesSelected'));

    }


    public function liste($id = null, $keyword = null)
    {
        $keyword = str_replace('espace', ' ', $keyword);
        $keyword = str_replace('slash', '/', $keyword);
        $keyword = strtolower($keyword);
        $this->layout = 'ajax';
        $limit = $this->getLimit();
        switch ($id) {
            case 2 :
                $conditions = array("LOWER(EventType.name) LIKE" => "%$keyword%");
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
                    $conditions = array("Event.date >=" => $startdtm->format('Y-m-d 00:00:00'));
                }else {
                    $conditions = array();
                }

                break;

            case 6 :
                if(!empty($keyword)){
                    $keyword = str_replace("/", "-", $keyword);
                    $start = str_replace("-", "/", $keyword);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $conditions = array("Event.next_date >=" => $startdtm->format('Y-m-d 00:00:00'));
                }else {
                    $conditions = array();
                }
                break;
            case 7 :
                $conditions = array("LOWER(Event.km) LIKE" => "%$keyword%");
                break;

            case 8 :
                $conditions = array("LOWER(Event.next_km) LIKE" => "%$keyword%");
                break;

            case 9 :
                $conditions = array("LOWER(Event.cost) LIKE" => "%$keyword%");
                break;

            default:
                $conditions = array("LOWER(EventType.name) LIKE" => "%$keyword%");
        }


        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins

            'order' => array('Event.id' => 'DESC'),
            'conditions' => $conditions,
            'limit'=>$limit,
            'fields' => array(
                'Event.code',
                'Event.id',
                'Event.date',
                'Event.next_date',
                'Event.km',
                'Event.next_km',
                'Event.cost',
                'Event.locked',
                'Event.transferred',
                'Customer.id',
                'Customer.first_name',
                'Customer.last_name',
                'Customer.company',
                'Interfering.name',
                'Car.code',
                'Car.immatr_def',
                'Event.user_id',
                'Car.parc_id',
                'Carmodel.name',
                'EventType.name',
                'Event.alert',
                'Event.multiple_event',
                ' Event.attachment1',
                ' Event.attachment2',
                ' Event.attachment3',
                ' Event.attachment4',
                ' Event.attachment5'
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
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Event.customer_id = Customer.id')
                ),
                array(
                    'table' => 'event_category_interfering',
                    'type' => 'left',
                    'alias' => 'EventCategoryInterfering',
                    'conditions' => array('EventCategoryInterfering.event_id = EventEventType.event_id')
                ),
                array(
                    'table' => 'interferings',
                    'type' => 'left',
                    'alias' => 'Interfering',
                    'conditions' => array('EventCategoryInterfering.interfering_id0 = Interfering.id')
                ),
                array(
                    'table' => 'interferings',
                    'type' => 'left',
                    'alias' => 'Interfering1',
                    'conditions' => array('EventCategoryInterfering.interfering_id1 = Interfering1.id')
                ),
                array(
                    'table' => 'interferings',
                    'type' => 'left',
                    'alias' => 'Interfering2',
                    'conditions' => array('EventCategoryInterfering.interfering_id2 = Interfering2.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'parcs',
                    'type' => 'left',
                    'alias' => 'Parc',
                    'conditions' => array('Car.parc_id = Parc.id')
                )
            )
        );

        $events = $this->Paginator->paginate("EventEventType");

        $this->set('events', $events);
        $param = $this->Parameter->getCodesParameterVal('name_car');

        $this->set(compact('param'));


    }

    function getEventProducts($typeId = null)
    {
        /**
         * @var EventTypeProduct $eventTypeProducts
         */
        $this->setTimeActif();
        $this->loadModel('EventTypeCategoryEventType');
        if (isset($typeId) && !empty($typeId)) {
            $this->layout = 'ajax';
            $this->Event->recursive = 2;
            // Get Event categories which can have products
            $this->loadModel('EventTypeProduct');

            $eventProducts = $this->EventTypeProduct->find('all',array('conditions' => array('EventTypeProduct.event_type_id' => $typeId)));
            $suppliers = $this->Supplier->getSuppliersByParams(0, 1);

            if (Configure::read("cafyb") == '1') {
                $products = $this->Cafyb->getProducts();
            }else {
                $this->Product->virtualFields = array('cnames' => "Product.name");
                $products = $this->Product->find('list', array(
                    'recursive' => -1,
                    'fields' => 'cnames',
                    'joins' => array(
                        array(
                            'table' => 'product_categories',
                            'type' => 'left',
                            'alias' => 'ProductCategory',
                            'conditions' => array('Product.product_category_id = ProductCategory.id')
                        ),
                    )
                ));
            }

            $this->set(compact('eventProducts', 'products','suppliers'));
        } else {
            $this->layout = 'ajax';
            $this->set('result', null);
            $this->set('products', null);
        }
    }

    public function getProduct($productId){
        $this->autoRender = false;
        $product = $this->Product->find('first', array(
            'conditions' => array('Product.id' => $productId)
        ));
        echo json_encode($product['Product']);
    }

    public function transformIntervention($id){
        $intervention = $this->Event->find('first',array('conditions' => array('Event.id' => $id)));
        $this->request->data['Event']['event_types'] = $intervention['Event']['event_type_id'] ;
        $this->request->data['Event']['car_id'] = $intervention['Car']['id'] ;
        $this->request->data['Event']['customer_id'] = $intervention['Customer']['id'] ;
        $this->request->data['Event']['structure_id'] = $intervention['Event']['structure_id'] ;
        $this->request->data['Event']['boss_id'] = $intervention['Event']['boss_id'] ;

        $this->Session->write('addRequestBol', true);
        $this->Session->write('addRequest', $this->request->data);
        $this->redirect(array("controller" => "events", "action" => "add"));
    }

    public function view_event($id){
        $this->setTimeActif();
        ini_set('memory_limit', '1024M');
        if (!$this->Event->exists($id)) {
            throw new NotFoundException(__('Invalid event'));
        }
        $this->loadModel('EventProduct');
        $this->Event->recursive = 2;
        $event = $this->Event->find('all' , array('conditions' => array('Event.id' => $id)));
        $boss = $this->Customer->find('all',array('conditions' => array('Customer.id'
        => $event[0]['Event']['boss_id'])));
        $eventProducts = $this->EventProduct->find('all',array('conditions' => array('EventProduct.event_id' => $id)));
        $eventProductsIds = array();
        $eventProductsSuppliersIds = array();
        foreach ($eventProducts as $eventProduct){
            array_push($eventProductsIds,$eventProduct['EventProduct']['product_id']);
            array_push($eventProductsSuppliersIds,$eventProduct['EventProduct']['supplier_id']);
        }
        $products = $this->Product->find('all',array('conditions' => array('Product.id' => $eventProductsIds)));
        $company = $this->Company->find('first');
        $carModel = $this->Carmodel->find('all',array('conditions' => array('Carmodel.id' => $event[0]['Car']['carmodel_id'])));
        $workShop = $this->Workshop->find('all',array('conditions' => array('Workshop.id' =>$event[0]['Event']['workshop_id'] )));
        $eventType = $this->EventType->find('all',array('conditions' => array('EventType.id' => $event[0]['EventEventType'][0]['event_type_id'])));
        if (!empty($boss)){
            $this->set('boss',$boss[0]['Customer']);
        }else{
            $this->set('boss',$boss);
        }
        $this->set(compact('event', 'company', 'eventProducts','products','carModel','workShop','eventType'));
    }

    public function getExternalEventFields(){
        $this->setTimeActif();
        $this->layout = 'ajax';

    }

    public function view_request($id){
        $this->setTimeActif();
        ini_set('memory_limit', '1024M');
        if (!$this->Event->exists($id)) {
            throw new NotFoundException(__('Invalid event'));
        }
        $this->Event->recursive = 2;
        $event = $this->Event->find('all' , array('conditions' => array('Event.id' => $id)));
        $boss = $this->Customer->find('all',array('conditions' => array('Customer.id'
        => $event[0]['Event']['boss_id'])));
        if(!empty($boss)){
            $boss = $boss[0]['Customer'];
        }
        $carModel = $this->Carmodel->find('all',array('conditions' => array('Carmodel.id' => $event[0]['Car']['carmodel_id'])));
        $requestDate = $event[0]['Event']['intervention_request_date'];
        $wishedInterventionDate = $event[0]['Event']['wished_intervention_date'];
        $requestDate = strtotime($requestDate);
        $wishedInterventionDate = strtotime($wishedInterventionDate);
        $diff = abs($wishedInterventionDate - $requestDate);
        $diffInDays = floor($diff / (24 * 3600));
        $eventType = $this->EventType->find('all',
            array('conditions' => array('EventType.id' => $event[0]['EventEventType'][0]['event_type_id'])));
        $this->set('boss',$boss);
        $this->set(compact('event','eventType','carModel','diffInDays'));
    }

    public function getDateInputs(){
        $this->layout = 'ajax';
    }

    public function getKmInputs(){
        $this->layout = 'ajax';
    }








    public function checkIfRequestWithSameDate(){
        $this->autoRender = false;
        //$ids = filter_input(INPUT_POST, "requestIds");
        $ids = json_decode($_GET['requestIds']);
        if(!empty($ids)){

            $events = $this->Event->find('all',
                array(
                    'recursive' => -1,
                    'paramType' => 'querystring',
                    'conditions' => array('Event.' . $this->Event->primaryKey => $ids),
                    'fields' => array(
                        'Event.id',
                        'Event.car_id',
                        'Event.date'
                    )
                ));
            if(!empty($events)){
                $dateEvent = $events[0]['Event']['date'];
                $carId = $events[0]['Event']['car_id'];
                $same = true ;
                foreach ($events as $event){
                    if( $dateEvent!= $event['Event']['date']){
                        $same = false;
                    }
                    if( $carId!= $event['Event']['car_id']){
                        $same = false;
                    }
                }
                echo json_encode(array("response" => $same));
            }else {
                echo json_encode(array("response" => false));
            }

        }else {
            echo json_encode(array("response" => false));
        }

    }


    public function printRequests()
    {
        $ids = filter_input(INPUT_POST, "chkids");
        $arrayIds = explode(",", $ids);
        $events = $this->Event->find('all',
            array(
                'recursive' => -1,
                'paramType' => 'querystring',
                'conditions' => array('Event.' . $this->Event->primaryKey => $arrayIds),
                'fields' => array(
                    'Event.code',
                    'Event.id',
                    'Event.date',
                    'Event.next_date',
                    'Event.date3',
                    'Event.km',
                    'Event.next_km',
                    'Event.cost',
                    'Event.obs',
                    'Interfering.name',
                    'Interfering.adress',
                    'Car.code',
                    'Car.km',
                    'Car.immatr_def',
                    'Carmodel.name',
                    'EventType.name',
                    'Car.vidange_hour',
                    'Car.hours',
                    'EventType.with_km',
                    'EventType.with_date',
                    'EventType.code',
                    'Event.request',
                    'Event.transferred',
                    'Event.validated',
                    'Event.canceled',
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
                        'table' => 'interferings',
                        'type' => 'left',
                        'alias' => 'Interfering',
                        'conditions' => array('Event.interfering_id = Interfering.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    )
                )
            ));
        $this->set('events', $events);
        $company = $this->Company->find('first');
        $wilayaId = $company['Company']['wilaya'];
        if(!empty($wilayaId)){
            $this->loadModel('Destination');
            $destination = $this->Destination->find('first', array('conditions' => array('Destination.id' => $wilayaId)));
            $wilayaName = $destination['Destination']['name'];
        }else {
            $wilayaName ='';
        }

        $entete_pdf = $this->Parameter->getCodesParameterVal('entete_pdf');
        $this->set(compact('company','entete_pdf','wilayaName'));


    }

    public function eventsAlertsCron(){
        $this->Alert->deleteAll(array('Alert.id >'=>0), false);
        $this->setDriverLicenseAlerts();

        $this->setAssuranceAlerts();

        $this->setControlAlerts();

        $this->setVignetteAlerts();

        $this->setVidangeHoursAlerts();

        $this->setKmAlerts();

        $this->setVidangeAlerts();

        $this->setDateAlerts();

    }

    public function checkIfMechanicIsAvailable(){
        $this->autoRender = false;
        $mechanicId = filter_input(INPUT_GET, "mechanicId");
        $workshopEntryDate = filter_input(INPUT_GET, "workshopEntryDate");
        $workshopExitDate = filter_input(INPUT_GET, "workshopExitDate");
        $eventId = filter_input(INPUT_GET, "eventId");

        $this->request->data['Event']['workshop_entry_date'] = $workshopEntryDate;
        $this->request->data['Event']['workshop_exit_date'] = $workshopExitDate;
        $this->createDatetimeFromDatetime('Event', 'workshop_entry_date');
        $this->createDatetimeFromDatetime('Event', 'workshop_exit_date');
        $workshopEntryDate =  $this->request->data['Event']['workshop_entry_date'];
        $workshopExitDate =  $this->request->data['Event']['workshop_exit_date'];

        if(!empty($mechanicId)){
            if(empty($eventId)){
                $event = $this->Event->find('first', array(
                    'conditions' => array(
                        'Event.mechanician_id' => $mechanicId,
                        'OR'=>array(
                            array(
                                'workshop_entry_date <=' => $workshopEntryDate,
                                'workshop_exit_date >= '=>$workshopEntryDate
                            ),
                            array(
                                'workshop_entry_date <=' => $workshopEntryDate,
                                'workshop_exit_date is NULL '
                            ),
                        )

                    )));
            }else {
                $event = $this->Event->find('first', array(
                    'conditions' => array(
                        'Event.mechanician_id' => $mechanicId,
                        'Event.id !='=>$eventId,
                        'OR'=>array(
                            array(
                                'workshop_entry_date <=' => $workshopEntryDate,
                                'workshop_exit_date >= '=>$workshopEntryDate
                            ),
                            array(
                                'workshop_entry_date <=' => $workshopEntryDate,
                                'workshop_exit_date is NULL '
                            ),
                        )

                    )));
            }

            if(!empty($event)){
                echo json_encode(array("response"=>false));
            }else {
                if(!empty($eventId)){
                    $event = $this->Event->find('first', array(
                        'conditions' => array(
                            'Event.mechanician_id' => $mechanicId,
                            'workshop_entry_date <=' => $workshopExitDate,
                            'workshop_exit_date >= '=>$workshopExitDate,
                            'Event.id !='=>$eventId
                        )));
                }else {
                    $event = $this->Event->find('first', array(
                        'conditions' => array(
                            'Event.mechanician_id' => $mechanicId,
                            'workshop_entry_date <=' => $workshopExitDate,
                            'workshop_exit_date >= '=>$workshopExitDate,
                        )));
                }
                if(!empty($event)){
                    echo json_encode(array("response"=>false));
                }else {
                    echo json_encode(array("response"=>true));
                }
            }
        }
    }

    /**
     * @param null $entryDate
     * @param null $exitDate
     * @return int
     */
    public function getStatusEvent($entryDate = null, $exitDate = null){
        date_default_timezone_set("Africa/Algiers");
        $currentDate = date("d/m/Y H:i");
        $this->request->data['Event']['current_date'] = $currentDate;
        $this->createDatetimeFromDatetime('Event', 'current_date');
        $currentDate = $this->request->data['Event']['current_date'];
        if (!empty($exitDate)) {
            if ($exitDate <= $currentDate) {
                    $statusId =  StatusEnum::intervention_finished;
            } else {
                if (!empty($entryDate)) {
                    if ($entryDate <= $currentDate) {
                        $statusId = StatusEnum::intervention_ongoing ;
                    } else {
                        $statusId = StatusEnum::intervention_planned;
                    }
                } else {
                    $statusId = StatusEnum::intervention_planned;
                }
            }
        } else {
            if (!empty($entryDate)) {
                if ($entryDate <= $currentDate) {
                    $statusId =StatusEnum::intervention_ongoing ;
                } else {
                    $statusId =  StatusEnum::intervention_planned;
                }
            } else {
                $statusId =  StatusEnum::intervention_planned;
            }

        }

        return $statusId;
    }

    /**
     * @param null $carId
     * @param null $entryDate
     * @param null $exitDate
     * @return string
     */
    public function getStatusCar($carId = null, $entryDate = null, $exitDate = null){
        $car = $this->Car->find('first',array('conditions'=>array('Car.id'=>$carId),'recursive'=>-1));
        $carStatusId = $car['Car']['car_status_id'];
        date_default_timezone_set("Africa/Algiers");
        $currentDate = date("d/m/Y H:i");
        $this->request->data['Event']['current_date'] = $currentDate;
        $this->createDatetimeFromDatetime('Event', 'current_date');
        $currentDate = $this->request->data['Event']['current_date'];
        if (!empty($exitDate)) {
            if ($exitDate <= $currentDate) {
                    $statusId =  $carStatusId;
            } else {
                if (!empty($entryDate)) {
                    if ($entryDate <= $currentDate) {
                        $statusId = 25 ;
                    } else {
                        $statusId = $carStatusId;
                    }
                } else {
                    $statusId = $carStatusId;
                }
            }
        } else {
            if (!empty($entryDate)) {
                if ($entryDate <= $currentDate) {
                    $statusId =25 ;
                } else {
                    $statusId = $carStatusId;
                }
            } else {
                $statusId =  $carStatusId;
            }

        }

        return $statusId;
    }



    public function updateStatusCar($carId = null, $carStatusId=null , $entryDate = null,$exitDate = null){
            $this->Car->id = $carId;
            $this->Car->saveField('car_status_id',$carStatusId);
            $this->Car->saveField('start_date',$entryDate);
            $this->Car->saveField('end_date',$exitDate);
    }


}
