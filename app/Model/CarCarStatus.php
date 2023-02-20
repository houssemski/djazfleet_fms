<?php

App::uses('AppModel', 'Model');

/**
 * CarStatus Model
 *
 * @property Car $Car
 */
class CarCarStatus extends AppModel {

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

        'car_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

        'car_status_id' => array(
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



    public $belongsTo = array(
        'CarStatus' => array(
            'className' => 'CarStatus',
            'foreignKey' => 'car_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

        'Car' => array(
            'className' => 'Car',
            'foreignKey' => 'car_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    /** recuperer le id du dernier status pour un car car id
     * @param $carId
     * @return array|null
     */

    function getLastCarCarStatusByCarId($carId){
        $carCarStatus = $this->find('first',array(
            'recursive'=>-1,
            'conditions'=>array(
                'CarCarStatus.car_id'=>$carId,
                'CarCarStatus.end_date is NULL'
            ),
            'fields'=>array(
                'CarCarStatus.id'
            )
        ));
        return $carCarStatus;
    }

    function getCarCarStatusesByCarId ($carId){
        $carCarStatuses = $this->find('all',array(
            'recursive'=>-1,
            'conditions'=>array(
                'CarCarStatus.car_id'=>$carId,

            ),
            'fields'=>array(
                'CarStatus.name',
                'CarCarStatus.start_date',
                'CarCarStatus.end_date',
            ),
            'joins' => array(
                array(
                    'table' => 'car_statuses',
                    'type' => 'left',
                    'alias' => 'CarStatus',
                    'conditions' => array('CarCarStatus.car_status_id = CarStatus.id')
                )
            ),
        ));
        return $carCarStatuses;
    }

}
