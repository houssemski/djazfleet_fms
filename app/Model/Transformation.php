<?php

App::uses('AppModel', 'Model');

/**
 * Affiliate Model
 *
 * 
 */
class Transformation extends AppModel {

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
      
        'origin_transport_bill_id' => array(
            '
			' => array(
                'rule' => array('notBlank'),
            'message' => '',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
		 'new_transport_bill_id' => array(
            '
			' => array(
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
  

}
