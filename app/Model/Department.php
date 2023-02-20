<?php
/**
 * Created by PhpStorm.
 * User: kahina
 * Date: 29/12/2015
 * Time: 15:15
 */
App::uses('AppModel', 'Model');
class Department extends AppModel {
    public $displayField = 'name';

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
    public $hasMany = array(

        'Car' => array(
            'className' => 'Car',
            'foreignKey' => 'department_id',
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

    /**
     * Get departments
     *
     * @param string|null $typeSelect
     *
     * @return array $departments
     */
    public function getDepartments($typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        $departments = $this->find(
            $typeSelect,
            array(
                'order' => array('Department.code ASC, Department.name ASC'),
                'recursive' => -1
            )
        );
        return $departments;
    }

}