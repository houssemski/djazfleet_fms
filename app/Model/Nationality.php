<?php

App::uses('AppModel', 'Model');

/**
 * Nationality Model
 *
 * @property Nationality $Nationality
 */
class Nationality extends AppModel {

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
        'Customer' => array(
            'className' => 'Customer',
            'foreignKey' => 'nationality_id',
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
     * Get nationalities
     *
     * @param string $typeSelect
     *
     * @return array $nationalities
     */
    public function getNationalities($typeSelect = null) {
        if(empty($typeSelect)){
            $typeSelect = 'list';
        }

        $nationalities = $this->find(
            $typeSelect,
            array(
                'order' => array('Nationality.name ASC'),
                'recursive' => -1
            )
        );
        return $nationalities;
    }

}
