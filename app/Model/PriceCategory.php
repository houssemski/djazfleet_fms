<?php

App::uses('AppModel', 'Model');

/**
 * CustomerCategory Model
 *
 * @property Customer $Customer
 */
class PriceCategory extends AppModel {

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
        'ProductPrice' => array(
            'className' => 'ProductPrice',
            'foreignKey' => 'price_category_id',
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
     * Get price categories
     *
     * @param string $typeSelect
     *
     * @param null $conditions
     * @return array $priceCategories
     */
    public function getPriceCategories($typeSelect = null, $conditions = null) {
        if(empty($typeSelect)){
            $typeSelect = 'list';
        }

        $priceCategories = $this->find(
            $typeSelect,
            array(
                'order' => array('PriceCategory.id ASC', 'PriceCategory.code ASC', 'PriceCategory.name ASC'),
                'conditions'=>$conditions,
                'recursive' => -1
            )
        );
        return $priceCategories;
    }

}
