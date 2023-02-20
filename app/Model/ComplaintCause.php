<?php

App::uses('AppModel', 'Model');

/**
 * CustomerCategory Model
 *
 * @property Customer $Customer
 */
class ComplaintCause extends AppModel {

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
         'Complaint' => array(
              'className' => 'Complaint',
              'foreignKey' => 'complaint_cause_id',
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
     * Get complaint Causes
     *
     * @param string $typeSelect
     * @param string $conditions
     *
     * @return array $cancelCauses
     */
    public function getComplaintCauses($typeSelect = null, $conditions = null) {
        if(empty($typeSelect)){
            $typeSelect = 'list';
        }

        $complaintCauses = $this->find(
            $typeSelect,
            array(
                'order' => array('ComplaintCause.code ASC, ComplaintCause.name ASC'),
                'conditions'=>$conditions,
                'recursive' => -1
            )
        );
        return $complaintCauses;
    }

}
