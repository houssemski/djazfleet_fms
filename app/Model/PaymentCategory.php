<?php

App::uses('AppModel', 'Model');

/**
 * RideCategory Model
 *
 * @property Ride $Ride
 */
class PaymentCategory extends AppModel {

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
        'Payment' => array(
            'className' => 'Payment',
            'foreignKey' => 'payment_category_id',
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

    public function getPaymentCategories($typeSelect = null){
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
            $paymentCategories = $this->find(
                $typeSelect,

                array(
                    'order' => 'PaymentCategory.code ASC, PaymentCategory.name ASC',
                    'recursive' => -1,
                    'fields' => array('PaymentCategory.id', 'PaymentCategory.name')
                )
            );

        return $paymentCategories;
    }

}
