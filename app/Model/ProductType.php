<?php

class ProductType extends AppModel {

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
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'product_type_id',
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
     * Get product category list
     *
     * @param string|null $typeSelect
     * @param int|null $recursive
     *
     * @return array $productTypes
     */
    public function getProductTypes($typeSelect = null, $recursive = null)
    {

        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($recursive)) {
            $recursive = -1;
        }
        $productTypes = $this->find(
            $typeSelect,
            array(
                'order' => 'ProductType.name ASC',
                'recursive' => $recursive
            )
        );

        return $productTypes;
    }

}