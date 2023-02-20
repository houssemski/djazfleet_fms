<?php
App::uses('AppModel', 'Model');
/**
 * Parc Model
 *
 */
class ProductWarehouse extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
    public $useTable = 'products_warehouses';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(

		'product_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'warehouse_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'quantity' => array(
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

    public $hasMany = array(
        'ProductWarehouse' => array(
            'className' => 'ProductWarehouse',
            'foreignKey' => 'warehouse_id',
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
        'ProductWarehouse' => array(
            'className' => 'ProductWarehouse',
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
        )
         
      
    );

    /**
     * @param null $productId
     * @param null $warehouseId
     * @return array|null
     */
    public function getProductsWarehouses($productId = null, $warehouseId = null)
    {

        $productWarehouse = $this->find('first',

            array(
                'conditions'=>array('product_id'=>$productId,'warehouse_id'=>$warehouseId),
                'recursive' => -1
            )
        );
        return $productWarehouse;
    }

    /**
     * @param null $productId
     * @param null $warehouseId
     * @param null $quantity
     * @param null $type
     * @param int $precedentQuantity
     * @throws Exception
     */
    public function updateQuantityProductWarehouse($productId=null,$warehouseId=null, $quantity=null, $type=null, $precedentQuantity=0){
        $productWarehouse = $this->getProductsWarehouses($productId,$warehouseId);
        switch ($type) {
            case BillTypesEnum::receipt :
            case BillTypesEnum::return_customer :
            case BillTypesEnum::entry_order :
            case BillTypesEnum::reintegration_order :
                if(!empty($productWarehouse)){
                    $quantity = $productWarehouse['ProductWarehouse']['quantity']- $precedentQuantity + $quantity;
                    $this->id = $productWarehouse['ProductWarehouse']['id'];
                    $this->saveField('quantity', $quantity);
                }else {
                    $this->create();
                    $data['ProductWarehouse']['product_id'] = $productId;
                    $data['ProductWarehouse']['warehouse_id'] = $warehouseId;
                    $data['ProductWarehouse']['quantity'] = $quantity;
                    $this->save($data);

                }

                break;
            case BillTypesEnum::delivery_order :
            case BillTypesEnum::return_supplier :
            case BillTypesEnum::exit_order :
            case BillTypesEnum::renvoi_order :
            if(!empty($productWarehouse)){
                $quantity = $productWarehouse['ProductWarehouse']['quantity'] + $precedentQuantity - $quantity;
                $this->id = $productWarehouse['ProductWarehouse']['id'];
                $this->saveField('quantity', $quantity);
            }else {
                $this->create();
                $data['ProductWarehouse']['product_id'] = $productId;
                $data['ProductWarehouse']['warehouse_id'] = $warehouseId;
                $data['ProductWarehouse']['quantity'] = $quantity;
                $this->save($data);

            }
                break;
            default:
                break;
        }
    }
    public function resetQuantityProductWarehouse($precedentQuantity, $type,
                                                  $precedentProductId,$precedentWarehouseId)
    {
        $productWarehouse = $this->getProductsWarehouses($precedentProductId,$precedentWarehouseId);


        switch ($type) {
            case BillTypesEnum::receipt :
            case BillTypesEnum::return_customer :
            case BillTypesEnum::entry_order :
            case BillTypesEnum::reintegration_order :

                    $quantity = $productWarehouse['ProductWarehouse']['quantity'] - $precedentQuantity;
                    $this->id = $productWarehouse['ProductWarehouse']['id'];
                    $this->saveField('quantity', $quantity);

                break;
            case BillTypesEnum::delivery_order :
            case BillTypesEnum::return_supplier :
            case BillTypesEnum::exit_order :
            case BillTypesEnum::renvoi_order :
                    $quantity = $productWarehouse['ProductWarehouse']['quantity'] + $precedentQuantity;
                    $this->id = $productWarehouse['ProductWarehouse']['id'];
                    $this->saveField('quantity', $quantity);

                break;
        }

    }

}
