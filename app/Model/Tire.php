<?php

App::uses('AppModel', 'Model');

/**
 * Fuel Model
 *
 
 */
class Tire extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'model';

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
        'model' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
          'tire_mark_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
     
        'user_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
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
       
        'TireMark' => array(
            'className' => 'TireMark',
            'foreignKey' => 'tire_mark_id',
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
        'Supplier' => array(
            'className' => 'Supplier',
            'foreignKey' => 'supplier_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
     
      
    );

        public $hasMany = array(
        'Shifting' => array(
            'className' => 'Shifting',
            'foreignKey' => 'tire_id',
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
      'Verification' => array(
            'className' => 'Verification',
            'foreignKey' => 'tire_id',
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
     * Get tire list
     *
     * @param array|null $fields
     * @param string|null $typeSelect
     * @param int|null $recursive
     *
     * @return array $tires
     */
    public function getTires($fields = null, $typeSelect = null, $recursive = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($fields)) {
            $fields = array('Tire.id', 'Tire.model');
        }
        if (empty($recursive)) {
            $recursive = -1;
        }
        $tires = $this->find(
            $typeSelect,
            array(
                'fields' => $fields,
                'order' => 'Tire.code ASC, Tire.model ASC',
                'recursive' => $recursive
            )
        );
        return $tires;
    }

    /**
     * Get tire by foreign key
     *
     * @param int $id
     * @param string $modelField
     *
     * @return array $tire
     */
    public function getTireByForeignKey($id, $modelField)
    {
        $tire = $this->find(
            'first',
            array(
                'conditions'=>array($modelField => $id),
                'fields' => array('Tire.id'),
                'recursive'=>-1
            ));
        return $tire;
    }

}
