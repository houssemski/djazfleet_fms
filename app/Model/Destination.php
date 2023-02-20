<?php

App::uses('AppModel', 'Model');

/**
 * Zone Model
 *
 * @property Car $Car
 */
class Destination extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'code' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'unique' => array(
                'rule' => 'isUnique',
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            'message' => '',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'daira_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'wilaya_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(

          'Ride' => array(
            'className' => 'Ride',
            'foreignKey' => 'departure_destination_id',
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
          'ArrivalRide' => array(
            'className' => 'Ride',
            'foreignKey' => 'arrival_destination_id',
            'dependent' => false,
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
    public $belongsTo = array(
        'Daira' => array(
            'className' => 'Daira',
            'foreignKey' => 'daira_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Wilaya' => array(
            'className' => 'Wilaya',
            'foreignKey' => 'wilaya_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

    );

    /**
     * Get destinations
     *
     * @param int $dairaId
     * @param string|null $typeSelect
     * @param int|null $recursive
     *
     * @return array $destinations
     */
    public function getDestinationsByDaira($dairaId, $typeSelect = null, $recursive = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($recursive)) {
            $recursive = -1;
        }
        $destinations = $this->find(
            $typeSelect,
            array(
                "conditions" => array("Destination.daira_id =" => $dairaId),
                'order' => 'Destination.code ASC, Destination.name ASC',
                'recursive' => $recursive,
            )

        );
        return $destinations;
    }

    /** return destination by conditions
     * @param null $conditions
     * @param null $typeSelect
     * @return mixed
     */
    public function getDestinationsByConditions($conditions = null, $typeSelect = null){

        if($typeSelect=='list'){
            $fields = array('Destination.id','Destination.name');
        }else {
            $fields = array('Destination.latlng','Destination.name','Destination.id');
        }
        $destinations = $this->find(
            $typeSelect,
            array(
                "conditions" => $conditions,
                'order' => 'Destination.code ASC, Destination.name ASC',
                'fields'=>$fields,
                'recursive' => -1
            )
        );

        return $destinations;

    }

    public function getDestinations($typeSelect = null , $conditions = null) {
        if(empty($typeSelect)){
            $typeSelect = 'list';
        }
        $destinations = $this->find(
            $typeSelect,
            array(
                'order' => array('Destination.code ASC, Destination.name ASC'),
                'conditions'=>$conditions,
                'recursive' => -1
            )
        );
        return $destinations;
    }

}
