<?php
App::uses('AppModel', 'Model');

/**
 * EventType Model
 *

 */
class CodeLog extends AppModel
{

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
        /*   'code' => array(
               'unique' => array(
                   'rule' => 'isUnique',
                   //'message' => 'Your custom message here',
                   'allowEmpty' => true,
                   'required' => false,
                   'last' => true, // Stop validation after this rule
                   //'on' => 'create', // Limit validation to 'create' or 'update' operations
               ),
           ),*/
        'supplier_id' => array(
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

        'Supplier' => array(
            'className' => 'Supplier',
            'foreignKey' => 'supplier_id',
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




    function insertCodeLog($codeLog = null){
        $this->create();
        $this->save($codeLog);
    }




}
