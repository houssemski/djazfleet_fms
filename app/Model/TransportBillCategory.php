<?php

App::uses('AppModel', 'Model');

/**
 * RideCategory Model
 *
 * @property Ride $Ride
 */
class TransportBillCategory extends AppModel {

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
        'TransportBill' => array(
            'className' => 'TransportBill',
            'foreignKey' => 'transport_bill_category_id',
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

    public function getTransportBillCategories($typeSelect = null){
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if($typeSelect =='all'){
            $fields =  array('TransportBillCategory.id');
        }else {
            $fields =  array('TransportBillCategory.id', 'TransportBillCategory.name');
        }
            $transportBillCategories = $this->find(
                $typeSelect,

                array(
                    'order' => 'TransportBillCategory.code ASC, TransportBillCategory.name ASC',
                    'recursive' => -1,
                    'fields' => $fields
                )
            );

        return $transportBillCategories;
    }

}
