<?php

App::uses('AppModel', 'Model');

/**
 * Event Model
 *
 * @property User $User
 * @property Interfering $Interfering
 * @property EventType $EventType
 */
class Event extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable ='event';
   
    /**
     * Display field
     *
     * @var string
     */

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'code' => array(
            'unique' => array(
                'rule' => 'isUnique',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
            ),
        ),
        'km' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
                'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'next_km' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
                'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'cost' => array(
            'decimal' => array(
                'rule' => array('decimal'),
                'allowEmpty' => true,
                'required' => false,
            ),
        ),
        'user_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
        'interfering_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
                'required' => false,
                'message' => '',
            ),
        ),
        'event_type_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => '',
            ),
        ), 'car_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
            ),
        ), 'customer_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
                'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

         'event_types' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => '',
            ),
        ),
            'internal_external' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'service_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
                'required' => false,
                'message' => '',
            ),
        ),

        
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'UserModifier' => array(
            'className' => 'User',
            'foreignKey' => 'modified_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Car' => array(
            'className' => 'Car',
            'foreignKey' => 'car_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Customer' => array(
            'className' => 'Customer',
            'foreignKey' => 'customer_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Interfering' => array(
            'className' => 'Interfering',
            'foreignKey' => 'interfering_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Structures' => array(
            'className' => 'Structures',
            'foreignKey' => 'structure_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
      
    );

       public $hasMany = array(
        
        'EventCategoryInterfering' => array(
            'className' => 'EventCategoryInterfering',
            'foreignKey' => 'event_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'EventEventType' => array(
            'className' => 'EventEventType',
            'foreignKey' => 'event_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
           'EventProduct' => array(
               'className' => 'EventProduct',
               'foreignKey' => 'event_id',
               'dependent' => true,
               'conditions' => '',
               'fields' => '',
               'order' => '',
               'limit' => '',
               'offset' => '',
               'exclusive' => '',
               'finderQuery' => '',
               'counterQuery' => ''
           )

    );




    public function getSumCost($conditions = null) {
        $sumcost = 0;
        
        if ($conditions != null) {
            $events = $this->find('all', array(
        'conditions' => $conditions,
        'recursive'=>-1,
        'fields'=> array('Event.cost','EventType.transact_type_id'),
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
                    )
                )
                    ));
                    
                    
            foreach ($events as $event) {
                if ($event['EventType']['transact_type_id'] == 2) {
                    $sumcost = $sumcost - $event['Event']['cost'];
                } elseif ($event['EventType']['transact_type_id'] == 1) {
                    $sumcost = $sumcost + $event['Event']['cost'];
                }
            }
        } else {
            $events = $this->query("SELECT cost, transact_type_id FROM event "

                . "LEFT JOIN event_event_types ON event_event_types.event_id = event.id "
                . "LEFT JOIN event_types ON event_event_types.event_type_id = event_types.id ;");
            foreach ($events as $event) {
                if ($event['event_types']['transact_type_id'] == 2) {
                    $sumcost = $sumcost - $event['event']['cost'];
                } elseif ($event['event_types']['transact_type_id'] == 1) {
                    $sumcost = $sumcost + $event['event']['cost'];
                }
            }
        }
        
        return $sumcost;
    }


    public function getSumCost2($conditions = null) {
        $sumcost = 0;

        if ($conditions != null) {
            $events = $this->find('all', array(
        'conditions' => $conditions,
        'recursive'=>-1,
        'group'=>'Event.id',
        'fields'=> array('Event.cost','EventType.transact_type_id','Event.interfering_id'),
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
                        'alias' => 'Interfering3',
                        'conditions' => array('Event.interfering_id = Interfering3.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
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
                    ));
                    
                    
            foreach ($events as $event) {
                if ($event['EventType']['transact_type_id'] == 2) {
                    $sumcost = $sumcost - $event['Event']['cost'];
                } elseif ($event['EventType']['transact_type_id'] == 1) {
                    $sumcost = $sumcost + $event['Event']['cost'];
                }
            }
        } else {
            $events = $this->query("SELECT cost, transact_type_id FROM event "
                    . "LEFT JOIN event_event_types ON event_event_types.event_id = event.id "
                    . "LEFT JOIN event_types ON event_event_types.event_type_id = event_types.id ;"
);
            foreach ($events as $event) {
                if ($event['event_types']['transact_type_id'] == 2) {
                    $sumcost = $sumcost - $event['event']['cost'];
                } elseif ($event['event_types']['transact_type_id'] == 1) {
                    $sumcost = $sumcost + $event['event']['cost'];
                }
            }
        }
        
        return $sumcost;
    }
    
    public function getKmAlert($limitedKm, $carId=null , $type_id = null, $eventId = null) {
        
        $query = "SELECT Event.id, Event.km, Event.next_km, Event.alert, EventType.alert_activate, "
                . "EventEventType.event_type_id, Event.car_id, Event.customer_id, Event.send_mail, "
                . "Car.id, Car.code, Car.carmodel_id, Car.km, Carmodel.name, EventType.id, EventType.name "
                . "FROM event AS Event "
                . "LEFT JOIN car AS Car ON (Event.car_id = Car.id) "
                . "LEFT JOIN carmodels AS Carmodel ON (Car.carmodel_id = Carmodel.id) "
                . "LEFT JOIN event_event_types AS EventEventType ON (EventEventType.event_id = Event.id) "
                . "LEFT JOIN event_types AS EventType ON (EventEventType.event_type_id = EventType.id) "
                . "WHERE Event.next_km <= ".(int)$limitedKm." + Car.km AND Event.alert != 2 AND EventType.alert_activate =1 AND car_status_id !=27";
        if($type_id != null){
            $query.= " AND EventEventType.event_type_id = ".(int) $type_id;
        }else{
            $query.= " AND EventEventType.event_type_id != 1";
        }
        if($carId != null){
            $query.= " AND Car.id = ".(int) $carId;
        }
        if($eventId != null){
            $query.= " AND Event.id = ".(int) $eventId;
        }
        return $this->query($query);
    }


        public function getHourAlert($limitedHour,$carId=null) {
        
        $query = "SELECT Event.id, Event.km, Event.next_km, Event.alert, EventType.alert_activate, "
                . "EventEventType.event_type_id, Event.car_id, Event.customer_id, Event.send_mail, "
                . "Car.id, Car.code, Car.carmodel_id, Car.hours, Carmodel.name, EventType.id, EventType.name "
                . "FROM event AS Event "
                . "LEFT JOIN car AS Car ON (Event.car_id = Car.id) "
                . "LEFT JOIN carmodels AS Carmodel ON (Car.carmodel_id = Carmodel.id) "
                . "LEFT JOIN event_event_types AS EventEventType ON (EventEventType.event_id = Event.id) "
                . "LEFT JOIN event_types AS EventType ON (EventEventType.event_type_id = EventType.id) "
                . "WHERE Event.next_km <= ".(int)$limitedHour." + Car.hours AND Event.alert != 2 AND EventType.alert_activate =1 AND car_status_id !=27 AND EventEventType.event_type_id = 10";
            if($carId != null){
                $query.= " AND Car.id = ".(int) $carId;
            }
        return $this->query($query);
    }

    // Function for encryption
    function encrypt($data) {
        return base64_encode(base64_encode(base64_encode(strrev($data))));
    }

// Function for decryption
    function decrypt($data) {
        return strrev(base64_decode(base64_decode(base64_decode($data))));
    }
    /** get all events with is_open = 1
     * @return array|null
     */
    public function getAllOpenedEvents(){
        $events = $this->find('all', array(
            'recursive'=>-1,
            'conditions'=>array('is_open'=>1),
            'fields'=>array('id')
        ));
        return $events;
    }

    /** recuperer les assurances avec alertes
     * @param $limitedDate
     * @param null $carId
     * @return array|null
     */

    public function getAssuranceAlerts($limitedDate, $carId = null){

        $conditions = array();
        if (!empty($carId)) {
            $conditions["Event.car_id"] = $carId;
        }
        $conditions['Event.next_date <= '] = $limitedDate;
        $conditions['EventEventType.event_type_id'] = 2;
        $conditions['EventType.alert_activate'] = 1;
        $conditions['Event.alert != '] = 2;
        $conditions['Car.car_status_id != '] = 27;
        $assuranceEvents = $this->find('all', array(
                'conditions' => $conditions,
                'recursive' => -1,
                'fields' => array(
                    'Car.code',
                    'Event.next_date',
                    'EventEventType.event_type_id',
                    'EventType.alert_activate',
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
            )

        );
        return $assuranceEvents;

    }

    /** recuperer les controles techniques avec alertes
     * @param $limitedDate
     * @param null $carId
     * @return array|null
     */

    public function getControlAlerts($limitedDate, $carId = null){
        $conditions = array();
        if (!empty($carId)) {
            $conditions["Event.car_id"] = $carId;

        }
        $conditions['Event.next_date <= '] = $limitedDate;
        $conditions['EventEventType.event_type_id'] = 3;
        $conditions['EventType.alert_activate'] = 1;
        $conditions['Event.alert != '] = 2;
        $conditions['Car.car_status_id != '] = 27;
        $controlEvents = $this->find('all', array(
            'conditions' => $conditions,
            'recursive' => -1,
            'fields' => array(
                'Car.code',
                'Event.next_date',
                'EventEventType.event_type_id',
                'EventType.alert_activate',
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

        return $controlEvents;
    }

    /** recuperer les vignettes avec alertes
     * @param $limitedDate
     * @param null $carId
     * @return array|null
     */
    public function getVignetteAlerts($limitedDate, $carId = null){
        $conditions = array();
        if (!empty($carId)) {
            $conditions["Event.car_id"] = $carId;
        }
        $conditions['Event.next_date <= '] = $limitedDate;
        $conditions['EventEventType.event_type_id'] = 5;
        $conditions['EventType.alert_activate'] = 1;
        $conditions['Event.alert != '] = 2;
        $conditions['Car.car_status_id != '] = 27;
        $vignetteEvents = $this->find('all', array(
            'conditions' => $conditions,
            'recursive' => -1,
            'fields' => array(
                'Car.code',
                'Event.next_date',
                'EventEventType.event_type_id',
                'EventType.alert_activate',
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

        return $vignetteEvents;
    }

    /** recuperer les evenements  avec date avec alertes
     * @param $limitedDate
     * @param null $carId
     * @param null $eventId
     * @return array|null
     */

    public function getDateAlerts($limitedDate, $carId = null , $eventId = null){

        $conditions = array();
        if (!empty($carId)) {
            $conditions["Event.car_id"] = $carId;
        }
        if (!empty($eventId)) {
            $conditions["Event.id"] = $eventId;
        }
        $conditions['Event.next_date <= '] = $limitedDate;
        $conditions['EventType.with_date'] = 1;
        $conditions['EventType.alert_activate'] = 1;
        $conditions['Event.alert != '] = 2;
        $conditions['Car.car_status_id != '] = 27;
        $dateEvents = $this->find('first', array(
            'conditions' => $conditions,
            'recursive' => -1,
            'fields' => array(
                'Car.code',
                'Car.km',
                'Event.next_date',
                'Event.next_km',
                'Event.km',
                'EventEventType.event_type_id',
                'EventType.alert_activate',
                'EventType.name',
                'Event.alert',
                'Carmodel.name',
                'Car.id',
                'EventType.name',
                'Event.send_mail',
                'Event.id',
                'EventType.with_date'
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
}
