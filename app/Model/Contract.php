<?php

App::uses('AppModel', 'Model');

/**
 * Event Model
 *
 * @property User $User
 * @property Interfering $Interfering
 * @property EventType $EventType
 */
class Contract extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $displayField = 'name';

    /**
     * Display field
     *
     * @var string
     */
    //public $displayField = 'event_type_id';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'reference' => array(
            'unique' => array(
                'rule' => 'isUnique',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
            ),
        ),
        'supplier_id' => array(
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
            'foreignKey' => 'last_modifier_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

        'Supplier' => array(
            'className' => 'Supplier',
            'foreignKey' => 'supplier_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),


    );

    public $hasMany = array(

        'ContractCarType' => array(
            'className' => 'ContractCarType',
            'foreignKey' => 'contract_id',
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


















}
