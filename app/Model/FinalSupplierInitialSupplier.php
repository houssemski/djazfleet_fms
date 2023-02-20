<?php

App::uses('AppModel', 'Model');

/**
 * Fuel Model
 *
 * @property Car $Car
 */
class FinalSupplierInitialSupplier extends AppModel {

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

        'final_supplier_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

      /*  'initial_supplier_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),*/
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $belongsTo = array(




        'FinalSupplier' => array(
            'className' => 'Supplier',
            'foreignKey' => 'final_supplier_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

        'initialSupplier' => array(
            'className' => 'Supplier',
            'foreignKey' => 'initial_supplier_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

    );

}
