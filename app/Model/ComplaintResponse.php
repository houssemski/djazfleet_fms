<?php

App::uses('AppModel', 'Model');

/**
 * ComplaintResponse Model
 *
 * @property ComplaintResponse $ComplaintResponse
 */
class ComplaintResponse extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'reference';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'reference' => array(
            'unique' => array(
                'rule' => 'isUnique',
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

        'response_date' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),


        'complaint_id' => array(
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

        'Complaint' => array(
            'className' => 'Complaint',
            'foreignKey' => 'complaint_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Treatment' => array(
            'className' => 'Treatment',
            'foreignKey' => 'treatment_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'modified_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

    );



}
