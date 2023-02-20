<?php

App::uses('AppModel', 'Model');

class ProductMark extends AppModel {

  public $displayField = 'name';

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
            'foreignKey' => 'product_mark_id',
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
     * Get product mark list
     *
     * @param string|null $typeSelect
     * @param int|null $recursive
     *
     * @return array $productMarks
     */
    public function getProductMarks($typeSelect = null, $recursive = null)
    {

        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($recursive)) {
            $recursive = -1;
        }
        $productMarks = $this->find(
            $typeSelect,
            array(
                'order' => 'ProductMark.code ASC, ProductMark.name ASC',
                'recursive' => $recursive
            )
        );

        return $productMarks;
    }

}