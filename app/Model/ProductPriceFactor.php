<?php

App::uses('AppModel', 'Model');

class ProductPriceFactor extends AppModel {



    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(

        'factor_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'factor_value' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'product_price_id' => array(
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


    /**
     * Get product by foreign key
     *
     * @param int $id
     * @param string $modelField
     *
     * @return array product
     */
    public function getProductPriceFactorByForeignKey($id, $modelField)
    {
        $productPriceFactor = $this->find(
            'first',
            array(
                'conditions' => array($modelField => $id),
                'fields' => array('ProductPriceFactor.id'),
                'recursive' => -1
            ));
        return $productPriceFactor;
    }

}