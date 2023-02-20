<?php

App::uses('AppModel', 'Model');

/**
 * Verification Model
 *
 
 */
class Verification extends AppModel {

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
        'reference' => array(
            'unique' => array(
                'rule' => 'isUnique',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
            ),
        ),
        'km' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
                'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
         'tire_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

         'date_verif' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        )
      
      
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
       
      
        
       'Tire' => array(
            'className' => 'Tire',
            'foreignKey' => 'tire_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    /**
     * Get verification by foreign key
     *
     * @param int $id
     * @param string $modelField
     *
     * @return array $verification
     */
    public function getVerificationByForeignKey($id, $modelField)
    {
        $verification = $this->find(
            'first',
            array(
                'conditions'=>array($modelField => $id),
                'fields' => array('Verification.id'),
                'recursive'=>-1
            ));
        return $verification;
    }

}
