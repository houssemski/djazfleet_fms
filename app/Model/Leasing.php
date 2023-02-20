<?php

App::uses('AppModel', 'Model');

/**
 * Car Model
 *
 * @property CarStatus $CarStatus
 * @property Mark $Mark
 * @property CarType $CarType
 * @property User $User
 * @property CarCategory $CarCategory
 * @property Fuel $Fuel
 * @property Customer $Customer
 */
class Leasing extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */

    /**
     * Validation rules
     *
     * @var array
     */

    public $validate = array(
     
      
      
      
      
       
      
         'user_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
         'last_modifier_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
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
       
     
       
        'AcquisitionType' => array(
            'className' => 'AcquisitionType',
            'foreignKey' => 'acquisition_type_id',
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


 

}
