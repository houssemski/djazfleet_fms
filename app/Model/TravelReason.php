<?php

App::uses('AppModel', 'Model');

/**
 * CustomerCategory Model
 *
 * @property Customer $Customer
 */
class TravelReason extends AppModel {
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
          'SheetRide' => array(
              'className' => 'SheetRide',
              'foreignKey' => 'travel_reason_id',
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
     * Get customer categories
     *
     * @param string $typeSelect
     * @param string $conditions
     *
     * @return array $cancelCauses
     */
    public function getTravelReasons($typeSelect = null, $conditions = null) {
        if(empty($typeSelect)){
            $typeSelect = 'list';
        }
        $travelReasons = $this->find(
            $typeSelect,
            array(
                'order' => array('TravelReason.code ASC, TravelReason.name ASC'),
                'conditions'=>$conditions,
                'recursive' => -1
            )
        );
        return $travelReasons;
    }

}
