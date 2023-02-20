<?php

App::uses('AppModel', 'Model');

/**
 * Fuel Model
 *
 
 */
class Extinguisher extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'extinguisher_number';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'extinguisher_number' => array(
            'unique' => array(
                'rule' => 'isUnique',
                //'message' => 'Your custom message here',
                'allowEmpty' => false,
                'required' => true,
                'last' => true, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'validity_day_date' => array(
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
       
        'Location' => array(
            'className' => 'Location',
            'foreignKey' => 'location_id',
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
        'Moving' => array(
            'className' => 'Moving',
            'foreignKey' => 'extinguisher_id',
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
          'Recharge' => array(
            'className' => 'Recharge',
            'foreignKey' => 'extinguisher_id',
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

    /**
     * Get extinguisher by foreign key
     *
     * @param int $id
     * @param string $modelField
     *
     * @return array $extinguisher
     */
    public function getExtinguisherByForeignKey($id, $modelField)
    {
        $extinguisher = $this->find(
            'first',
            array(
                'conditions'=>array($modelField => $id),
                'fields' => array('Extinguisher.id'),
                'recursive'=>-1
            ));
        return $extinguisher;
    }

}
