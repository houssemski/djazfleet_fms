<?php

/**
 * Created by PhpStorm.
 * User: Bilal
 * Date: 27/01/2019
 * Time: 14:27
 */
class Lot extends AppModel
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

        'quantity' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => '',
            ),
        ),
		
		  'label' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),

        ),

		
		'product_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),

        ) , 
		
		'tva_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),

        )



    );

    public $validate_add_lot = array(
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


    public $hasAndBelongsToMany = array(
        'Bill' => array(
            'className' => 'Bill',
            'joinTable' => 'bill_product',
            'foreignKey' => 'lot_id',
            'associationForeignKey' => 'bill_id',
            'with' => 'BillProduct',
        )
    );
    public $hasMany = array(
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
        'ProductUnit' => array(
            'className' => 'ProductUnit',
            'foreignKey' => 'product_unit_id',
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
        'LotType' => array(
            'className' => 'LotType',
            'foreignKey' => 'lot_type_id',
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


    );

    public function getLots()
    {
        $lots = $this->find('list',
            array(
                'recursive' => -1,
                'fields' => array('Lot.id', 'Lot.label'),
                'joins'=>array(
                    array(
                        'table' => 'products',
                        'type' => 'left',
                        'alias' => 'Product',
                        'conditions' => array('Lot.product_id = Product.id')
                    ),
                )
            ));

        return $lots;
    }

    /**
     * @param null $conditions
     * @param null $typeSelect
     * @return array|null
     */
	public function getLotsByConditions($conditions = null, $typeSelect = null)
    {
         if(empty($typeSelect)){
            $typeSelect ='list' ;
        }
        $this->virtualFields = array(
            'cnames' => "CONCAT(Lot.number, ' - ', Lot.label)"
        );
		if($typeSelect == 'list'){
            $fields = 'cnames';
        }else {
            $fields = array('Lot.id', 'Lot.label');
        }
		$lots = $this->find($typeSelect,
            array(
                'recursive' => -1,
                'fields' => $fields,
				'conditions'=>$conditions,
                'order'=>array('Lot.id ASC'),
                'joins'=>array(
                    array(
                        'table' => 'products',
                        'type' => 'left',
                        'alias' => 'Product',
                        'conditions' => array('Lot.product_id = Product.id')
                    ),
                )
            ));

        return $lots;
    }

    public function getLotsBySheetRideDetailRideId($sheetRideDetailRideId = null,$typeSelect = null )
    {
         if(empty($typeSelect)){
            $typeSelect ='list' ;
        }
		$lots = $this->find($typeSelect,
            array(
                'recursive' => -1,
                'fields' => array('Lot.id', 'Lot.label'),
				'conditions'=>array('Bill.sheet_ride_detail_ride_id'=>$sheetRideDetailRideId),
                'joins'=>array(
                    array(
                        'table' => 'bill_products',
                        'type' => 'left',
                        'alias' => 'BillProduct',
                        'conditions' => array('BillProduct.lot_id = Lot.id')
                    ),
                    array(
                        'table' => 'bills',
                        'type' => 'left',
                        'alias' => 'Bill',
                        'conditions' => array('BillProduct.bill_id = Bill.id')
                    ),
                )
            ));

        return $lots;
    }
	
	
    /**
     * Get lots by id
     *
     * @param array $lotId
     *
     * @return array $lot
     */
    public function getLotById($lotId)
    {
        $lot = $this->find(
            'first',
            array(
                'conditions' => array('Lot.id' => $lotId),
                'recursive' => -1
            )
        );

        return $lot;
    }


    public function getQuantityLot($quantity_id = null, $warehouse_id = null)
    {

        echo($warehouse_id);

        $query = "select * From  lots as Lot "
            . "LEFT JOIN lot_types as LotType ON LotType.id = Lot.lot_type_id"
            . "LEFT JOIN warehouses as Warehouse ON Warehouse.id = Lot.warehouse_id WHERE ";

        if ($warehouse_id != null) {
            $query .= "Lot.warehouse_id = " . (int)$warehouse_id . "&&";
        }

        if ($quantity_id != null) {

            switch ($quantity_id) {
                case 1:
                    $query .= "Lot.quantity >0 ";
                    break;
                case 2:
                    $query .= "Lot.quantity <= Lot.quantity_min ";
                    break;
                case 3:
                    $query .= "Lot.quantity >= Lot.quantity_max ";
                    break;
                case 4:
                    $query .= "Lot.quantity=0 ";
                    break;
            }
            echo($quantity_id);

        }
        $results = $this->query($query);
        return $results;
    }

    /**
     * Get lots by foreign key
     *
     * @param int $id
     * @param string $modelField
     *
     * @return array lots
     */
    public function getLotByForeignKey($id, $modelField)
    {
        $lots = $this->find(
            'first',
            array(
                'conditions' => array($modelField => $id),
                'fields' => array('Lot.id'),
                'recursive' => -1
            ));
        return $lots;
    }

    /**
     * @param null $lotId
     * @param null $quantity
     * @param null $type
     * @param int $precedentQuantity
     */
    public function updateQuantityLot($lotId = null, $quantity= null, $type= null, $precedentQuantity= 0){
        $lot = $this->find('first',array (
                                    'conditions' => array('Lot.id' => $lotId),
                                    'recursive' =>-1,
                        ));
        switch ($type) {

            case BillTypesEnum::receipt :
            case BillTypesEnum::return_customer :
            case BillTypesEnum::entry_order :
            case BillTypesEnum::reintegration_order :
                if (!empty($lot)){
                    if($lot['Lot']['out_stock']==false) {
                        $quantity=$lot['Lot']['quantity']- $precedentQuantity +$quantity;
                        $this->id = $lotId;
                        $this->saveField('quantity', $quantity);
                    }
                }
                break;

            case BillTypesEnum::delivery_order :
            case BillTypesEnum::return_supplier :
            case BillTypesEnum::exit_order :
            case BillTypesEnum::renvoi_order :
                if (!empty($lot)){
                    if($lot['Lot']['out_stock']==false) {
                        $quantity=$lot['Lot']['quantity']+$precedentQuantity - $quantity;
                        $this->id = $lotId;
                        $this->saveField('quantity', $quantity);
                    }
                }
                break;

            default:
                break;
        }
    }

    /**
     * @param null $billProductId
     * @param null $type
     * @param null $lotId
     */
    public function resetQuantityLot($billProductId = null, $type = null, $lotId = null){
        $billProduct = $this->BillProduct->find('first', array(
            'conditions'=>array('BillProduct.id'=>$billProductId),
            'recursive'=>-1,
        ));
        $quantity = $billProduct['BillProduct']['quantity'];
        $lot = $this->find('first',array (
			'conditions' => array('Lot.id' => $lotId),
			'recursive'=>-1));

        switch ($type) {

            case BillTypesEnum::receipt :
            case BillTypesEnum::return_customer :
            case BillTypesEnum::entry_order :
            case BillTypesEnum::reintegration_order :
                if($lot['Lot']['out_stock']==false) {
                    $quantity = $lot['Lot']['quantity'] - $quantity;
                    $this->id = $lot['Lot']['id'];
                    $this->saveField('quantity', $quantity);
                }
                break;


            case BillTypesEnum::delivery_order :
            case BillTypesEnum::return_supplier :
            case BillTypesEnum::exit_order :
            case BillTypesEnum::renvoi_order :
                if($lot['Lot']['out_stock']==false) {
                    $quantity = $lot['Lot']['quantity'] + $quantity;
                    $this->id = $lot['Lot']['id'];
                    $this->saveField('quantity', $quantity);
                }
                break;




        }

    }

    /** ajouter un lot
     * @param null $productId
     * @throws Exception
     */
    public function insertLot($productId = null ){
        $product = $this->Product->getProductById($productId);
        $data = array();
        $data['Lot']['id'] =$productId;
        $data['Lot']['number'] = '__';
        $data['Lot']['quantity'] = 0;
        $data['Lot']['tva_id'] = 1;
        $data['Lot']['label'] = '__';
        $data['Lot']['product_id'] = $productId;
        $data['Lot']['tva_id'] = $product['Product']['tva_id'];
        $data['Lot']['out_stock'] = $product['Product']['out_stock'];
        $data['Lot']['product_unit_id'] = $product['Product']['product_unit_id'];
        $this->create();
        $this->save($data);
    }

    /** ajouter un lot
     * @param null $productId
     * @throws Exception
     */
    public function updateLot($productId = null ){
        $lot = $this->getLotsByProductId($productId);

        $product = $this->Product->getProductById($productId);
        $data = array();
        $data['Lot']['id'] = $lot['Lot']['id'];
        $data['Lot']['number'] = '__';
        $data['Lot']['quantity'] = 0;
        $data['Lot']['tva_id'] = 1;
        $data['Lot']['label'] = '__';
        $data['Lot']['product_id'] = $productId;
        $data['Lot']['tva_id'] = $product['Product']['tva_id'];
        $data['Lot']['product_unit_id'] = $product['Product']['product_unit_id'];
        $this->save($data);
    }

    public function getLotsByProductId($productId = null, $typeSelect = null){
        if(empty($typeSelect)){
            $typeSelect ='first' ;
        }
        $lots = $this->find($typeSelect,array(
            'recursive'=>-1,
            'conditions'=>array('Lot.product_id'=>$productId),
            'fields'=>array(
                'Lot.id',
                'Lot.label',
            )
        ));
        return $lots;
    }

    public function getLastId(){
        $lot = $this->find('first',array('fields'=>'Lot.id', 'order'=>'id DESC'));
        $lotId = $lot['Lot']['id'];
        return $lotId;
    }
}