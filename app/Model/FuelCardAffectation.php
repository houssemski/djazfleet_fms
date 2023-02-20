<?php

App::uses('AppModel', 'Model');

/**
 * AcquisitionType Model
 *
 *
 */
class FuelCardAffectation extends AppModel {

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

        'fuel_card_id' => array(
            '
            ' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        /*  'car_id' => array(
              '
              ' => array(
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
    public $hasMany = array(
        'FuelCardCar' => array(
            'className' => 'FuelCardCar',
            'foreignKey' => 'fuel_card_affectation_id',
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

    public $belongsTo = array(
        'FuelCard' => array(
            'className' => 'FuelCard',
            'foreignKey' => 'fuel_card_id',
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
