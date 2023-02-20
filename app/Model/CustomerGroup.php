<?php

App::uses('AppModel', 'Model');

/**
 * Group Model
 *
 * @property Customer $Customer
 */
class CustomerGroup extends AppModel {

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
        'Customer' => array(
            'className' => 'Customer',
            'foreignKey' => 'customer_group_id',
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
        'CustomerCar' => array(
            'className' => 'CustomerCar',
            'foreignKey' => 'customer_group_id',
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
     * Get customer groups
     *
     * @param string $typeSelect
     *
     * @return array $customerGroups
     */
    public function getCustomerGroups($typeSelect = null) {
        if(empty($typeSelect)){
            $typeSelect = 'list';
        }

        $customerGroups = $this->find(
            $typeSelect,
            array(
                'order' => array('CustomerGroup.code ASC, CustomerGroup.name ASC'),
                'recursive' => -1
            )
        );
        return $customerGroups;
    }

}
