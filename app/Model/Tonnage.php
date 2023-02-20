<?php
/**
 * Created by PhpStorm.
 * User: kahina
 * Date: 29/12/2015
 * Time: 15:15
 */
App::uses('AppModel', 'Model');
class Tonnage extends AppModel {
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

       /* 'Car' => array(
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
        ),*/
    );

    /**
     * Get tonnages
     *
     * @param string|null $typeSelect
     *
     * @return array $tonnages
     */
    public function getTonnages($typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        $tonnages = $this->find(
            $typeSelect,
            array(
                'order' => array('Tonnage.code ASC, Tonnage.name ASC'),
                'recursive' => -1
            )
        );
        return $tonnages;
    }

}