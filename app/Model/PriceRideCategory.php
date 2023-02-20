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
class PriceRideCategory extends AppModel {

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

        'price_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

        'price_ht' => array(
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


        'Price' => array(
            'className' => 'Price',
            'foreignKey' => 'price_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

        'RideCategory' => array(
            'className' => 'RideCategory',
            'foreignKey' => 'ride_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

    );



}
