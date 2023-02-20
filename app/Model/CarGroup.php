<?php

App::uses('AppModel', 'Model');

/**
 * Group Model
 *
 * @property Customer $Customer
 */
class CarGroup extends AppModel {

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
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'name' => array(
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
    public $hasMany = array(
        'Car' => array(
            'className' => 'Car',
            'foreignKey' => 'car_group_id',
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
     * Get all car groups
     *
     * @param int|null $recursive
     *
     * @return array $carGroups
     */
    public function getCarGroups($recursive = null)
    {
        if (isset($recursive) && !empty($recursive)) {
            $carGroups = $this->find(
                'list',
                array('order' => 'CarGroup.code ASC, CarGroup.name ASC', 'recursive' => $recursive)
            );
        } else {
            $carGroups = $this->find(
                'list',
                array('order' => 'CarGroup.code ASC, CarGroup.name ASC', 'recursive' => '-1')
            );
        }

        return $carGroups;
    }

}
