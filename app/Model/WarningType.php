<?php

App::uses('AppModel', 'Model');

class WarningType extends AppModel {

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
        'Warning' => array(
            'className' => 'Warning',
            'foreignKey' => 'warning_type_id',
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

    public function getWarningTypes($typeSelect = null)
    {

        if (empty($typeSelect)) {
            $typeSelect = "list";
        }

        $warningTypes = $this->find(
            $typeSelect,
            array(
                'order' => 'WarningType.name ASC',
                'recursive' => -1,
                'fields' => array('WarningType.id','WarningType.name'),
            )
        );


        return $warningTypes;
    }

}