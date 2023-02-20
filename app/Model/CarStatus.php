<?php

App::uses('AppModel', 'Model');

/**
 * CarStatus Model
 *
 * @property Car $Car
 */
class CarStatus extends AppModel {

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
                'allowEmpty' => false,
                'required' => true,
                'last' => true, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
           
        ),
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
        
         'color' => array(
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
        'Car' => array(
            'className' => 'Car',
            'foreignKey' => 'car_status_id',
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
     * Get all car status
     *
     * @param int|null $recursive
     *
     * @return array $carStatus
     */
    public function getCarStatus($recursive = null)
    {
        if (isset($recursive) && !empty($recursive)) {
            $carStatus = $this->find(
                'list',
                array('order' => 'CarStatus.code ASC, CarStatus.name ASC', 'recursive' => $recursive)
            );
        } else {
            $carStatus = $this->find(
                'list',
                array('order' => 'CarStatus.code ASC, CarStatus.name ASC', 'recursive' => '-1')
            );
        }
        return $carStatus;
    }

}
