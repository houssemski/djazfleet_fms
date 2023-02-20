<?php

App::uses('AppModel', 'Model');

/**
 * ProductsBill Model
 *
 */
class BillProduct extends AppModel
{

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    // public $useTable = 'product_bill';

    public $validate = array(
        'product_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),
        ),
        'quantity' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),
        ),
        'unit_price' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),
        ),
        'price_ht' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),
        ),
        'price_ttc' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),
        ),

        'price_tva' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),
        ),

        'tva_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),
        ),

    );

    public $belongsTo = array(
        'Lot' => array(
            'className' => 'Lot',
            'foreignKey' => 'lot_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Bill' => array(
            'className' => 'Bill',
            'foreignKey' => 'bill_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * Get products bill by lot
     *
     * @param int $lotId
     *
     * @return array $productsBill
     */
    public function getBillProductsByLotId($lotId)
    {
        $billProducts = $this->find(
            'first',
            array(
                'conditions' => array('BillProduct.lot_id' => $lotId),
                'fields' => array('BillProduct.id'),
                'recursive' => -1
            ));
        return $billProducts;
    }

    public function getBillProductsByBillId($billId)
    {
        $billProducts = $this->find(
            'all',
            array(
                'order'=>array('BillProduct.order_bill_product ASC','BillProduct.id ASC'),
                'conditions' => array('BillProduct.bill_id' => $billId),
                'fields' => array(
                    'BillProduct.id',
                    'BillProduct.lot_id',
                    'BillProduct.quantity',
                    'BillProduct.unit_price',
                    'BillProduct.price_ht',
                    'BillProduct.price_ttc',
                    'BillProduct.price_tva',
                    'BillProduct.ristourne_val',
                    'BillProduct.ristourne_%',
                    'BillProduct.tva_id',
                    'BillProduct.designation',
                    'BillProduct.description',
                    'Product.description',
                    'Product.with_serial_number',
                    'Product.last_purchase_price',
                    'Product.name',
                    'Product.code',
                    'Product.description',
                    'Tva.name',
                ),
                'recursive' => -1,
                'joins' => array(
                    array(
                        'table' => 'lots',
                        'type' => 'left',
                        'alias' => 'Lot',
                        'conditions' => array('BillProduct.lot_id = Lot.id')
                    ),
                    array(
                        'table' => 'products',
                        'type' => 'left',
                        'alias' => 'Product',
                        'conditions' => array('Product.id = Lot.product_id')
                    ),
					array(
                        'table' => 'tva',
                        'type' => 'left',
                        'alias' => 'Tva',
                        'conditions' => array('BillProduct.tva_id = Tva.id')
                    ),
                )
            )
        );
        return $billProducts;
    }    
	
	
	public function getDetailedBillProductsByConditions($conditions = null)
    {
         $billProducts = $this->find('all', array(
            'order' => array('Bill.id ASC', 'BillProduct.id ASC'),
            'recursive' => -1,
            'fields' => array(
                'BillProduct.unit_price',
                'BillProduct.price_ht',
                'BillProduct.price_ttc',
                'BillProduct.tva_id',
                'BillProduct.ristourne_%',
                'BillProduct.ristourne_val',
                'BillProduct.id',
                'Bill.reference',
                'Bill.id',
                'Bill.date',
                'Bill.total_ttc',
                'Bill.total_ht',
                'Bill.total_tva',
                'Supplier.name',
                'Supplier.code',
                'Tva.name',
                'Product.id',
                'Product.name',
                'Product.code',
            ),
            'conditions' => $conditions,
            'joins' => array(
                array(
                    'table' => 'bills',
                    'type' => 'left',
                    'alias' => 'Bill',
                    'conditions' => array('BillProduct.bill_id = Bill.id')
                ),
                  array(
                        'table' => 'lots',
                        'type' => 'left',
                        'alias' => 'Lot',
                        'conditions' => array('BillProduct.lot_id = Lot.id')
                    ),
                    array(
                        'table' => 'products',
                        'type' => 'left',
                        'alias' => 'Product',
                        'conditions' => array('Product.id = Lot.product_id')
                    ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Bill.supplier_id = Supplier.id')
                ),
              
                array(
                    'table' => 'tva',
                    'type' => 'left',
                    'alias' => 'Tva',
                    'conditions' => array('Tva.id = BillProduct.tva_id')
                ),
            )
        ));
        return $billProducts;
    }

    /**
     * @param null $billProductId
     */
    public function getBillProductById($billProductId = null) {
       $billProduct =  $this->find(
           'first',
           array(
               'conditions' => array('BillProduct.id' => $billProductId),
               'fields' => array('BillProduct.id',
                   'BillProduct.lot_id','BillProduct.quantity',
                   'BillProduct.description'),
               'recursive' => -1
           ));
       return $billProduct;
    }

    /**
     * @param null $billProduct
     * @param null $billId
     * @param null $lotId
     * @param null $orderBillProduct
     * @return bool
     * @throws Exception
     */
    public function addBillProduct($billProduct = null, $billId = null, $lotId = null, $orderBillProduct= null)
    {
		$save = false;
        $this->create();
        $data['BillProduct']['bill_id'] = $billId;
        $data['BillProduct']['lot_id'] = $lotId;
        $data['BillProduct']['quantity'] = $billProduct['quantity'];
        $data['BillProduct']['unit_price'] = $billProduct['unit_price'];
        $data['BillProduct']['price_ht'] = $billProduct['price_ht'];
        $data['BillProduct']['price_ttc'] = $billProduct['price_ttc'];
        $data['BillProduct']['price_tva'] = $billProduct['price_ttc'] - $billProduct['price_ht'];
        $data['BillProduct']['ristourne_val'] = $billProduct['ristourne_val'];
        $data['BillProduct']['ristourne_%'] = $billProduct['ristourne_%'];
        $data['BillProduct']['tva_id'] = $billProduct['tva_id'];
        $data['BillProduct']['designation'] = $billProduct['designation'];
        if(isset($billProduct['description']) && !empty($billProduct['description'])){
            $data['BillProduct']['description'] = $billProduct['description'];
        }
        $data['BillProduct']['order_bill_product'] = $orderBillProduct;
        if($this->save($data)){
            $billProductId = $this->getInsertID();
		}
		return $billProductId;
		
    }

    /**
     * @param null $billProduct
     * @param null $billId
     * @param null $lotId
     * @param null $orderBillProduct
     * @throws Exception
     */
    public function updateBillProduct($billProduct = null, $billId = null , $lotId= null, $orderBillProduct=null)
    {
        $data = array();
        $data['BillProduct']['id'] = $billProduct['id'];
        $data['BillProduct']['bill_id'] = $billId;
        $data['BillProduct']['lot_id'] = $lotId;
        $data['BillProduct']['quantity'] = $billProduct['quantity'];
        $data['BillProduct']['unit_price'] = $billProduct['unit_price'];
        $data['BillProduct']['price_ht'] = $billProduct['price_ht'];
        $data['BillProduct']['price_ttc'] = $billProduct['price_ttc'];
        $data['BillProduct']['price_tva'] = $billProduct['price_ttc'] - $billProduct['price_ht'];
        $data['BillProduct']['ristourne_val'] = $billProduct['ristourne_val'];
        $data['BillProduct']['ristourne_%'] = $billProduct['ristourne_%'];
        $data['BillProduct']['tva_id'] = $billProduct['tva_id'];
        $data['BillProduct']['designation'] = $billProduct['designation'];
		$data['BillProduct']['description'] = $billProduct['description'];
		$data['BillProduct']['order_bill_product'] = $orderBillProduct;
        $this->save($data);
    }

    public function getQuantityBillProduct($billProductId = null){
        $billProduct = $this->find('first', array(
            'conditions' => array('BillProduct.id' => $billProductId),
            'recursive' => -1,
        ));
        $quantity = $billProduct['BillProduct']['quantity'];
        return $quantity;
    }


    public function calculatePmp($productId = null)
    {
        $pmp = 0;
        $lots = $this->Lot->getLotsByProductId($productId,'all');
        $lotIds = array();
        foreach($lots as $lot){
            $lotIds = $lot['Lot']['id'];
        }
        $billProducts = $this->find('all', array(
            'conditions' => array('BillProduct.lot_id' => $lotIds, 'Bill.type' => 2),
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'bills',
                    'type' => 'left',
                    'alias' => 'Bill',
                    'conditions' => array('Bill.id = BillProduct.bill_id')
                ),
            )

        ));
        if (!empty($billProducts)) {
            $quantity = 0;
            $price_quantity = 0;
            foreach ($billProducts as $billProduct) {
                $quantity = $quantity + $billProduct['BillProduct']['quantity'];
                $price_quantity = $price_quantity + $billProduct['BillProduct']['price_ht'];


            }
            $pmp = $price_quantity / $quantity;
            $pmp = round($pmp, 2);

        }
        return $pmp;

    }

    function deleteBillProducts($type= null, $billId = null){
        $billProducts = $this->getBillProductsByBillId($billId);
        foreach ($billProducts as $billProduct) {
            $lotId = $billProduct['BillProduct']['lot_id'];
            $lot = $this->Lot->getLotById($billProduct['BillProduct']['lot_id']);
            $productId = $lot['Lot']['product_id'];
            $this->Lot->resetQuantityLot($billProduct['BillProduct']['id'], $type, $lotId);
            $this->Lot->Product->resetQuantityProduct($billProduct['BillProduct']['id'], $type, $productId);
        }
        $this->deleteAll(array('BillProduct.bill_id' => $billId), false);


    }


    public function getDetailedBillsByConditions($conditions = null, $typeSelect = null, $order = null)
    {

        if(empty($order)){
            $order = 'Bill.id ASC';
        }

        $billProducts = $this->find($typeSelect, array(
            'recursive' => -1,
            'conditions' => $conditions,
            'order' => $order,
            'paramType' => 'querystring',
            'fields' => array(
                'Bill.reference',
                'Bill.id',
                'Bill.type',
                'Bill.date',
                'Bill.note',
                'BillProduct.quantity',
                'BillProduct.unit_price',
                'BillProduct.price_ht',
                'BillProduct.price_ttc',
                'Supplier.name',
                'Supplier.type'


            ),
            'joins' => array(


                array(
                    'table' => 'bills',
                    'type' => 'left',
                    'alias' => 'Bill',
                    'conditions' => array('Bill.id = BillProduct.bill_id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Bill.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'lots',
                    'type' => 'left',
                    'alias' => 'Lot',
                    'conditions' => array('BillProduct.lot_id = Lot.id')
                ),


            )
        ));

        return $billProducts;
    }


		
}