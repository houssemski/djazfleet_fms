<?php

/**
 * Created by PhpStorm.
 * User: kahina
 * Date: 02/12/2015
 * Time: 14:27
 */
class Product extends AppModel
{
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
        'quantity_min' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => '',
            ),
        ),
        'quantity_max' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => '',
            ),
        ),


    );





    public $validate_add_product = array(
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
            ),

        )


    );

    public $validate_product_mobilisation = array(
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
            ),

        )   ,
        'nb_hours_required' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),
        ) ,
        'car_required' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),
        )


    );
    public $validate_product_location = array(
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
            ),

        )   ,
        'car_required' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),
        )


    );

    public $validateMerge = array(
     
        'product_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),

        )


    );


    public $hasMany = array(
        'Lot' => array(
            'className' => 'Lot',
            'foreignKey' => 'product_id',
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

        'BillProduct' => array(
            'className' => 'BillProduct',
            'foreignKey' => 'lot_id',
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
        'ProductCategory' => array(
            'className' => 'ProductCategory',
            'foreignKey' => 'product_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ProductFamily' => array(
            'className' => 'ProductFamily',
            'foreignKey' => 'product_family_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ProductMark' => array(
            'className' => 'ProductMark',
            'foreignKey' => 'product_mark_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Tva' => array(
            'className' => 'Tva',
            'foreignKey' => 'tva_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ProductUnit' => array(
            'className' => 'ProductUnit',
            'foreignKey' => 'product_unit_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),


    );

    public function getProducts($typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = 'list';
        }

        $products = $this->find($typeSelect,
            array(
                'recursive' => -1,
                'fields' => array('Product.id', 'Product.name')
            ));
        return $products;
    }


    public function getProductsByConditions($conditions = null, $typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = 'list';
        }

        $products = $this->find($typeSelect,
            array(
                'recursive' => -1,
                'conditions' => $conditions,
                'fields' => array('Product.id', 'Product.name')
            ));
        return $products;
    }

    /**
     * Get product by id
     *
     * @param array $productId
     *
     * @return array $product
     */
    public function getProductById($productId)
    {
        $product = $this->find(
            'first',
            array(
                'conditions' => array('Product.id' => $productId),
                'recursive' => -1,
                'fields'=>array(
                    'Tva.tva_val','Product.id','Product.quantity',
                    'Product.pmp','Product.with_lot','Product.car_required',
                    'Product.name','Product.tva_id','Product.product_unit_id',
                    'Product.product_type_id','Product.out_stock','Product.with_serial_number',
                    'ProductType.relation_with_park','Product.nb_hours','Product.nb_hours_required'),
                'joins'=>array(
                    array(
                        'table' => 'tva',
                        'type' => 'left',
                        'alias' => 'Tva',
                        'conditions' => array('Product.tva_id = Tva.id')
                    ),
                    array(
                        'table' => 'product_types',
                        'type' => 'left',
                        'alias' => 'ProductType',
                        'conditions' => array('Product.product_type_id = ProductType.id')
                    ),
                )
            )
        );

        return $product;
    }

    public function getProductMin()
    {

        $query = "select  *  From products as Product where quantity<=quantity_min";
        return $this->query($query);
    }

    public function getProductMax()
    {


        $query = "select  *  From products as Product where quantity >=quantity_max";


        return $this->query($query);
    }

    public function getQuantityProduct($quantity_id = null, $warehouse_id = null)
    {

        echo($warehouse_id);

        $query = "select * From  products as Product "
            . "LEFT JOIN product_marks as ProductMark ON ProductMark.id = Product.product_mark_id "
            . "LEFT JOIN product_types as ProductCategory ON ProductCategory.id = Product.product_category_id "
            . "LEFT JOIN warehouses as Warehouse ON Warehouse.id = Product.warehouse_id WHERE ";

        if ($warehouse_id != null) {
            $query .= "Product.warehouse_id = " . (int)$warehouse_id . "&&";
        }

        if ($quantity_id != null) {

            switch ($quantity_id) {
                case 1:
                    $query .= "Product.quantity >0 ";
                    break;
                case 2:
                    $query .= "Product.quantity <= Product.quantity_min ";
                    break;
                case 3:
                    $query .= "Product.quantity >= Product.quantity_max ";
                    break;
                case 4:
                    $query .= "Product.quantity=0 ";
                    break;
            }
            echo($quantity_id);

        }
        $results = $this->query($query);
        return $results;
    }

    /**
     * Get product by foreign key
     *
     * @param int $id
     * @param string $modelField
     *
     * @return array product
     */
    public function getProductByForeignKey($id, $modelField)
    {
        $product = $this->find(
            'first',
            array(
                'conditions' => array($modelField => $id),
                'fields' => array('Product.id'),
                'recursive' => -1
            ));
        return $product;
    }

    public function updateQuantityProduct($productId = null, $quantity = null, $type = null , $precedentQuantity= 0)
    {
        $product = $this->find('first', array('conditions' => array('Product.id' => $productId),
            'recursive' => -1));
        switch ($type) {
            case BillTypesEnum::receipt :
            case BillTypesEnum::return_customer :
            case BillTypesEnum::entry_order :
            case BillTypesEnum::reintegration_order :
                if($product['Product']['out_stock']==false){
                    $quantity = $product['Product']['quantity']- $precedentQuantity + $quantity;
                    $this->id = $productId;
                    $this->saveField('quantity', $quantity);
                }
                if($type == BillTypesEnum::receipt){
                    $pmp=$this->Lot->BillProduct->calculatePmp($productId);
                    $dataProduct['Product']['pmp']= $pmp;
                    $this->id = $product['Product']['id'];
                    $this->saveField('pmp', $pmp);
                }
                break;
            case BillTypesEnum::delivery_order :
            case BillTypesEnum::return_supplier :
            case BillTypesEnum::exit_order :
            case BillTypesEnum::renvoi_order :
                if($product['Product']['out_stock']==false) {
                    $quantity = $product['Product']['quantity'] + $precedentQuantity - $quantity;
                    $this->id = $productId;
                    $this->saveField('quantity', $quantity);
                }
                break;
            default:
                break;
        }

    }

    public function resetQuantityProduct($billProductId = null, $type = null, $productId = null)
    {
        $billProduct = $this->BillProduct->find('first', array(
            'conditions' => array('BillProduct.id' => $billProductId),
            'recursive' => -1,
        ));
        $quantity = $billProduct['BillProduct']['quantity'];
        $product = $this->find('first', array(
            'conditions' => array('Product.id' => $productId),
            'recursive' => -1));
        switch ($type) {
            case BillTypesEnum::receipt :
            case BillTypesEnum::return_customer :
            case BillTypesEnum::entry_order :
            case BillTypesEnum::reintegration_order :
                if($product['Product']['out_stock']==false) {
                    $quantity = $product['Product']['quantity'] - $quantity;
                    $this->id = $product['Product']['id'];
                    $this->saveField('quantity', $quantity);
                }
                break;
            case BillTypesEnum::delivery_order :
            case BillTypesEnum::return_supplier :
            case BillTypesEnum::exit_order :
            case BillTypesEnum::renvoi_order :
                if($product['Product']['out_stock']==false) {
                    $quantity = $product['Product']['quantity'] + $quantity;
                    $this->id = $product['Product']['id'];
                    $this->saveField('quantity', $quantity);
                }
                break;
        }

    }


}