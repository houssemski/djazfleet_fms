<?php

App::uses('AppModel', 'Model');

class Factor extends AppModel {

    public $displayField = 'name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(

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
        'name_id' => array(
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
        'ProductPriceFactor' => array(
            'className' => 'ProductPriceFactor',
            'foreignKey' => 'factor_id',
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
        'TransportBillDetailRideFactor' => array(
            'className' => 'TransportBillDetailRideFactor',
            'foreignKey' => 'factor_id',
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
     * Get product type list
     *
     * @param string|null $typeSelect
     * @param int|null $recursive
     *
     * @return array $productTypes
     */
    public function getFactors($typeSelect = null, $recursive = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($recursive)) {
            $recursive = -1;
        }
        $factors = $this->find(
            $typeSelect,
            array(
                'order' => 'Factor.name ASC',
                'recursive' => $recursive
            )
        );

        return $factors;
    }

}