<?php

App::uses('AppModel', 'Model');

/**
 * Location Model
 *
 * @property Customer $Customer
 */
class Location extends AppModel {

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
        'Shifting' => array(
            'className' => 'Shifting',
            'foreignKey' => 'location_id',
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
            'Extinguisher' => array(
            'className' => 'Extinguisher',
            'foreignKey' => 'location_id',
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
     * Get locations
     *
     * @param array|null $fields
     * @param string|null $typeSelect
     * @param int|null $recursive
     *
     * @return array $locations
     */
    public function getLocations($fields = null, $typeSelect = null, $recursive = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($fields)) {
            $fields = array('Location.id', 'Location.name');
        }
        if (empty($recursive)) {
            $recursive = -1;
        }
        $locations = $this->find(
            $typeSelect,
            array(
                'fields' => $fields,
                'order' => 'Location.code ASC, Location.name ASC',
                'recursive' => $recursive
            )
        );
        return $locations;
    }

}
