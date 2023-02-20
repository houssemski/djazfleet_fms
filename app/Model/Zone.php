<?php

App::uses('AppModel', 'Model');

/**
 * Zone Model
 *
 * @property Car $Car
 */
class Zone extends AppModel {

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
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'CustomerCar' => array(
            'className' => 'CustomerCar',
            'foreignKey' => 'zone_id',
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
        'Customer' => array(
            'className' => 'Customer',
            'foreignKey' => 'zone_id',
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
        'Wilaya' => array(
            'className' => 'Wilaya',
            'foreignKey' => 'zone_id',
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
    );

    /**
     * Get zones
     *
     * @param string $typeSelect
     *
     * @return array $zones
     */
    public function getZones($typeSelect = null) {
        if(empty($typeSelect)){
            $typeSelect = 'list';
        }

        $zones = $this->find(
            $typeSelect,
            array(
                'order' => array('Zone.code ASC, Zone.name ASC'),
                'recursive' => -1
            )
        );
        return $zones;
    }

}
