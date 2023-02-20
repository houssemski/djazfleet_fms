<?php

App::uses('AppModel', 'Model');

/**
 * Verification Model
 *
 
 */
class Recharge extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    
   
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
        'code' => array(
            'unique' => array(
                'rule' => 'isUnique',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
            ),
        ),
     
         'extinguisher_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
               'recharge_date' => array(
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
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'UserModifier' => array(
            'className' => 'User',
            'foreignKey' => 'modified_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
       
       'Extinguisher' => array(
            'className' => 'Extinguisher',
            'foreignKey' => 'extinguisher_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    /**
     * Get recharge by foreign key
     *
     * @param int $id
     * @param string $modelField
     *
     * @return array $recharge
     */
    public function getRechargeByForeignKey($id, $modelField)
    {
        $recharge = $this->find(
            'first',
            array(
                'conditions'=>array($modelField => $id),
                'fields' => array('Recharge.id'),
                'recursive'=>-1
            ));
        return $recharge;
    }

}
