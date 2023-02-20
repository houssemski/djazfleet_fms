<?php

App::uses('AppModel', 'Model');

/**
 * RideCategory Model
 *
 * @property Ride $Ride
 */
class RideCategory extends AppModel {

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
        'DetailRide' => array(
            'className' => 'DetailRide',
            'foreignKey' => 'ride_category_id',
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
          'CarType' => array(
            'className' => 'CarType',
            'foreignKey' => 'car_type_id',
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

    /**
     * Get price categories
     *
     * @param string $typeSelect
     *
     * @return array $priceCategories
     */
    public function getRideCategories($typeSelect = null) {
        if(empty($typeSelect)){
            $typeSelect = 'list';
        }
        $rideCategories = $this->find(
            $typeSelect,
            array(
                'order' => array('RideCategory.code ASC, RideCategory.name ASC'),
                'conditions'=> array("id >" => 0),
                'recursive' => -1
            )
        );
        return $rideCategories;
    }

}
