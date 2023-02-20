<?php

App::uses('AppModel', 'Model');

/**
 * CustomerCategory Model
 *
 * @property Customer $Customer
 */
class ProductPrice extends AppModel {

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
        'product_id' => array(
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
        'PriceCategory' => array(
            'className' => 'PriceCategory',
            'foreignKey' => 'price_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'product_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    /**
     * Get price categories
     *
     * @param string $typeSelect
     *
     * @return array $priceCategories
     */
    public function getPriceCategories($typeSelect = null, $conditions = null) {
        if(empty($typeSelect)){
            $typeSelect = 'list';
        }
        $priceCategories = $this->find(
            $typeSelect,
            array(
                'order' => array('PriceCategory.code ASC, PriceCategory.name ASC'),
                'conditions'=>$conditions,
                'recursive' => -1
            )
        );
        return $priceCategories;
    }

    /**
     * @param null $productPrice
     * @param null $productId
     * @throws Exception
     */
    public function addProductPrice($productPrice = null, $productId = null){
        $data = array();
        $data['ProductPrice']['product_id']=$productId;
        $data['ProductPrice']['price_category_id']=$productPrice['price_category_id'];
        $data['ProductPrice']['price_ht']=$productPrice['price_ht'];
        $this->create();
        $this->save($data);
    }

    /**
     * @param null $productPrice
     * @param null $productId
     * @throws Exception
     */
    public function updateProductPrice($productPrice = null, $productId = null){
        $data = array();
        $data['ProductPrice']['id']=$productPrice['id'];;
        $data['ProductPrice']['product_id']=$productId;
        $data['ProductPrice']['price_category_id']=$productPrice['price_category_id'];
        $data['ProductPrice']['price_ht']=$productPrice['price_ht'];
        $this->save($data);
    }

    /**
     * @param null $productId
     * @return array|null
     */
    public function getProductPricesByProductId($productId = null){
        $productPrices= $this->find('all',
            array(
                'conditions'=>array('ProductPrice.product_id'=>$productId),
                'order'=>array('PriceCategory.id ASC'),
                'recursive'=>-1,
                'fields'=>array('ProductPrice.id','ProductPrice.product_id', 'ProductPrice.price_category_id','PriceCategory.name','ProductPrice.price_ht '),
                'joins'=>array(
                    array(
                        'table' => 'price_categories',
                        'type' => 'left',
                        'alias' => 'PriceCategory',
                        'conditions' => array('ProductPrice.price_category_id = PriceCategory.id')
                    ),
                )

            )
            );
        return $productPrices;
    }

    /**
     * @param null $conditions
     * @param null $typeSelect
     * @return array|null
     */
    public function getProductPricesByConditions($conditions = null, $typeSelect = null){
        if(empty($typeSelect)){
            $typeSelect = 'all';
        }

        $productPrices= $this->find($typeSelect,
            array(
                'conditions'=>$conditions,
                'order'=>array('PriceCategory.id ASC'),
                'recursive'=>-1,
                'fields'=>array('ProductPrice.id','ProductPrice.product_id', 'ProductPrice.price_category_id','PriceCategory.name','ProductPrice.price_ht'),
                'joins'=>array(
                    array(
                        'table' => 'price_categories',
                        'type' => 'left',
                        'alias' => 'PriceCategory',
                        'conditions' => array('ProductPrice.price_category_id = PriceCategory.id')
                    ),
                )

            )
            );
        return $productPrices;
    }


    public function getPriceByParams($productId=null, $clientId=null, $supplierCategoryId = null)
    {


        date_default_timezone_set("Africa/Algiers");
        $currentDate = date("Y-m-d");

            $conditions =  array(
                'ProductPrice.product_id' => $productId,
                'ProductPrice.price_category_id' => 0,
                'OR'=>array(
                    array(
                        'ProductPrice.start_date <= '=>$currentDate,
                        'ProductPrice.end_date >= '=>$currentDate,
                    ),
                    array(
                        'ProductPrice.start_date <= '=>$currentDate,
                        'ProductPrice.end_date is NULL ',
                    ),
                    array(
                        'ProductPrice.start_date is NULL ',
                        'ProductPrice.end_date >= '=>$currentDate,
                    ),
                    array(
                        'ProductPrice.start_date is NULL ',
                        'ProductPrice.end_date IS null ',
                    )
                ),
            );

        if(!empty($clientId)){
            $conditions['Price.supplier_id'] = $clientId;
        }

        if(!empty($supplierCategoryId)){
            $conditions ['Price.supplier_category_id'] = $supplierCategoryId;
        }

        $price = $this->find('first',
            array(
                'conditions' => $conditions,
                'joins' => array(
                    array(
                        'table' => 'prices',
                        'type' => 'left',
                        'alias' => 'Price',
                        'conditions' => array('ProductPrice.price_id = Price.id')
                    ),
                ),
                'recursive' => -1,
                'fields' => array(
                    'ProductPrice.price_ht',
                    'ProductPrice.id',
                    'ProductPrice.start_date',
                    'ProductPrice.end_date',
                    'Price.id',
                )
            ));
        return $price;

    }



}
