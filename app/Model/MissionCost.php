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
class MissionCost extends AppModel {

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

    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */

    public $belongsTo = array(




        'DetailRide' => array(
            'className' => 'DetailRide',
            'foreignKey' => 'detail_ride_id',
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
