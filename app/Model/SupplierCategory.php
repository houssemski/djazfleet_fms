<?php

App::uses('AppModel', 'Model');

/**
 * SupplierCategory Model
 *
 * @property Car $Car
 */
class SupplierCategory extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
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
        'Supplier' => array(
            'className' => 'Supplier',
            'foreignKey' => 'supplier_category_id',
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
         'Price' => array(
            'className' => 'Price',
            'foreignKey' => 'supplier_category_id',
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
     * Get supplier categories
     *
     * @param array|null $fields
     * @param string|null $typeSelect
     * @param int|null $recursive
     *
     * @return array $supplierCategories
     */
    public function getSupplierCategories($fields = null, $typeSelect = null, $recursive = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($fields)) {
            $fields = array('SupplierCategory.id', 'SupplierCategory.name');
        }
        if (empty($recursive)) {
            $recursive = -1;
        }
        $supplierCategories = $this->find(
            $typeSelect,
            array(
                'fields' => $fields,
                'order' => 'SupplierCategory.code ASC, SupplierCategory.name ASC',
                'recursive' => $recursive
            )
        );
        return $supplierCategories;
    }

    /**
     * Get supplier categories by typz
     *
     * @param int $supplierCategoryType
     * @param string|null $typeSelect
     *
     * @return array $supplierCategories
     */
    public function getSupplierCategoriesByType($supplierCategoryType, $typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }

        $supplierCategories = $this->find(
            $typeSelect,
            array(
                'fields' => array('id','name', 'code',  'type'),
                'order' => 'SupplierCategory.code ASC, SupplierCategory.name ASC',
                'conditions'=> array('SupplierCategory.type'=> $supplierCategoryType),
                'recursive' => -1
            )
        );
        return $supplierCategories;
    }

}
