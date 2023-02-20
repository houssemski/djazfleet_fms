<?php

App::uses('AppModel', 'Model');

/**
 * Moving Model
 *
 
 */
class Moving extends AppModel {

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
       

       
       
        'car_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
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
        'Car' => array(
            'className' => 'Car',
            'foreignKey' => 'car_id',
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
     * Get moving by foreign key
     *
     * @param int $id
     * @param string $modelField
     *
     * @return array $moving
     */
    public function getMovingByForeignKey($id, $modelField)
    {
        $moving = $this->find(
            'first',
            array(
                'conditions'=>array($modelField => $id),
                'fields' => array('Moving.id'),
                'recursive'=>-1
            ));
        return $moving;
    }

}
