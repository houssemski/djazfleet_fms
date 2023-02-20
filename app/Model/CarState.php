<?php

App::uses('AppModel', 'Model');

/**
 * CarStatus Model
 *
 * @property Car $Car
 */
class CarState extends AppModel {

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

        'name' => array(
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
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'SheetRideCarState' => array(
            'className' => 'SheetRideCarState',
            'foreignKey' => 'car_state_id',
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
     * Get all car state
     *
     * @param int|null $selectType
     *
     * @return array $carStates
     */
    public function getCarStates($selectType = null)
    {
        if (isset($selectType) && !empty($selectType)) {
            $carStates = $this->find(
                $selectType,
                array(
                    'order' => 'CarState.id ASC',
                    'fields' => array('CarState.id','CarState.name'),
                    'recursive' => -1
                )
            );
        } else {
            $carStates = $this->find(
                'list',
                array(
                      'order' => 'CarState.id ASC',
                    'fields' => array('CarState.id','CarState.name'),
                      'recursive' => -1
                )
            );
        }
        return $carStates;
    }

    public function getCarStatesByConditions($selectType = null, $conditions = null)
    {
        if (isset($selectType) && !empty($selectType)) {
            $carStates = $this->find(
                $selectType,
                array(
                    'conditions'=>$conditions,
                    'order' => 'CarState.id ASC',
                    'fields' => array('CarState.id','CarState.name'),
                    'recursive' => -1
                )
            );
        } else {
            $carStates = $this->find(
                'list',
                array(
                    'conditions'=>$conditions,
                    'order' => 'CarState.id ASC',
                    'fields' => array('CarState.id','CarState.name'),
                      'recursive' => -1
                )
            );
        }
        return $carStates;
    }

}
