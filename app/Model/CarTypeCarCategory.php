<?php

App::uses('AppModel', 'Model');

/**
 * CarCategory Model
 *
 * @property Car $Car
 */
class CarTypeCarCategory extends AppModel {

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

        'car_category_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'car_type_id' => array(
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
    public $belongsTo = array(


        'CarCategory' => array(
            'className' => 'CarCategory',
            'foreignKey' => 'car_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'CarType' => array(
            'className' => 'CarType',
            'foreignKey' => 'car_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    /**
     * Get Car Type Car Categories by params
     *
     * @param int $carTypeId
     *
     * @return array $carTypeCarCategories
     */
    public function getCarTypeCarCategories($carTypeId = null)
    {
        $carTypeCarCategories = $this->find('list', array(
            'recursive' => -1,
            'fields' => array('CarTypeCarCategory.car_category_id'),
            'conditions' => array('CarTypeCarCategory.car_type_id' => $carTypeId)
        ));
        return $carTypeCarCategories;
    }
}
