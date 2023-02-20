<?php

App::uses('AppModel', 'Model');

/**
 * Shifting Model
 *
 
 */
class Shifting extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable ='shifting';
   
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
         'shifting_date' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            //'allowEmpty' => false,
            //'required' => false,
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
        'position_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
                'required' => false,
                'message' => '',
            ),
        ),
       'location_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
                'required' => false,
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
        'Location' => array(
            'className' => 'Location',
            'foreignKey' => 'location_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Position' => array(
            'className' => 'Position',
            'foreignKey' => 'position_id',
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
     * Get shifting by foreign key
     *
     * @param int $id
     * @param string $modelField
     *
     * @return array $shifting
     */
    public function getShiftingByForeignKey($id, $modelField)
    {
        $shifting = $this->find(
            'first',
            array(
                'conditions'=>array($modelField => $id),
                'fields' => array('Shifting.id'),
                'recursive'=>-1
            ));
        return $shifting;
    }

}
