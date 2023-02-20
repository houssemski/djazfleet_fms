<?php
App::uses('AppModel', 'Model');

class Bill extends AppModel
{


    public $validate = array(
        'reference' => array(
            'unique' => array(
                'rule' => 'isUnique',
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'supplier_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),

        ),
        'date' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),

        ),
        'price' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => '',
            ),
        ),
        'Product' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),
        ),
    );

    public $validateProcurement = array(
        'reference' => array(
            'unique' => array(
                'rule' => 'isUnique',
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

        'date' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),

        ),
        'customer_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),

        ),
        'price' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => '',
            ),
        ),
        'Product' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),

        ),


    );

    public $validateTransfer = array(
        'reference' => array(
            'unique' => array(
                'rule' => 'isUnique',
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

        'date' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),

        ),
        'warehouse_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),
        ),
        'warehouse_destination_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),
        ),
        'price' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => '',
            ),
        ),
        'Product' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),

        ),


    );


	    public $validate_transform = array(
        'reference' => array(
            'unique' => array(
                'rule' => 'isUnique',
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
   
     
     


    );

    public $hasMany = array(
        'BillProduct' => array(
            'className' => 'BillProduct',
            'foreignKey' => 'bill_id',
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
        'Supplier' => array(
            'className' => 'Supplier',
            'foreignKey' => 'supplier_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'modified_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

    );





    public function getBillsByConditions($conditions = null, $typeSelect = null, $order = null)
    {
		if(empty($order)){
			$order = 'Bill.id ASC';
		}

        $bills = $this->find($typeSelect, array(

            'recursive' => -1,
            'conditions' => $conditions,
            'order' => $order,
            'paramType' => 'querystring',
            'fields' => array(

                'Bill.reference',
                'Bill.id',
                'Bill.date',
                'Bill.total_ttc',
                'Bill.amount_remaining',
                'Bill.total_ht',
                'Bill.total_tva',
                'Bill.supplier_id',
                'Bill.customer_id',
                'Supplier.name',
				'Bill.date',
                'Bill.type',
				 'Bill.status',
                 'Bill.user_id',
                 'Bill.modified_id'

            ),
            'joins' => array(

                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Bill.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Bill.customer_id = Customer.id')
                ),
            )
        ));
        return $bills;
    }





	public function getBillById($id = null)
    {
        $bill = $this->find('first', array(
            'recursive' => -1,
            'conditions' => array('Bill.id'=>$id),
            'paramType' => 'querystring',
             'fields' => array(
                            'id',
                            'reference',
                            'date',
                            'type',
                            'total_ht',
                            'total_ttc',
                            'total_tva',
                            'supplier_id',
                            'warehouse_id',
                            'warehouse_destination_id',
                            'status',
                            'user_id',
                            'modified_id'
                        )
           
        ));
        return $bill;
    }

    public function getBillByIds($ids = null)
    {
        $bill = $this->find('all', array(
            'recursive' => -1,
            'conditions' => array('Bill.id'=>$ids),
            'paramType' => 'querystring',
             'fields' => array(
                            'id',
                            'reference',
                            'date',
                            'type',
                            'total_ht',
                            'total_ttc',
                            'total_tva',
                            'amount_remaining',
                            'supplier_id',
                            'status',
                            'user_id',
                            'modified_id'
                        )

        ));
        return $bill;
    }




	public function getDetailedBillById($id)
    {

        $bill = $this->find("first", array(
            'recursive' => -1,
            'conditions' => array('Bill.id' => $id),
            'paramType' => 'querystring',
            'fields' => array(
                'Bill.reference',
                'Bill.id',
                'Bill.type',
                'Bill.date',
                'Bill.note',
                'Bill.total_ttc',
                'Bill.total_ht',
                'Bill.total_tva',
                'Bill.ristourne_val',
                'Bill.payment_method',
                'Bill.stamp',
                'Supplier.name',
                'Supplier.adress',
                'Supplier.code',
                'Supplier.rc',
                'Supplier.ai',
                'Supplier.if',


            ),
            'joins' => array(

                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Bill.supplier_id = Supplier.id')
                ),


            )
        ));
        return $bill;
    }






    public function getTotals($conditions = null)
    {
        $totals = array();
        if ($conditions != null) {
            $bills = $this->find(
                'all',
                array(
                    'conditions' => $conditions,
                    'paramType' => 'querystring',
                    'recursive' => -1, // should be used with joins
                    'fields' => array(
                        'sum(Bill.total_ht) as total_ht',
                        'sum(Bill.total_ttc) as total_ttc',
                        'sum(Bill.total_tva) as total_tva',
                    )
                )
            );
            $totals['total_ht'] = $bills[0][0]['total_ht'];
            $totals['total_ttc'] = $bills[0][0]['total_ttc'];
            $totals['total_tva'] = $bills[0][0]['total_tva'];

        } else {
            $bills = $this->find('all', array(

                'paramType' => 'querystring',
                'recursive' => -1, // should be used with joins
                'fields' => array(
                    'sum(TransportBill.total_ht) as total_ht',
                    'sum(TransportBill.total_ttc) as total_ttc',
                    'sum(TransportBill.total_tva) as total_tva',
                ),


            ));

            $totals['total_ht'] = $bills[0][0]['total_ht'];
            $totals['total_ttc'] = $bills[0][0]['total_ttc'];
            $totals['total_tva'] = $bills[0][0]['total_tva'];

        }
        return $totals;
    }

    /** ajouter un bon
     * @param null $bill
     * @param null $lots
     * @param null $type
     * @throws Exception
     */
    function addBill($bill = null, $lots = null, $type = null)
    {
        $this->create();
        if ($this->save($bill)) {
            $billId = $this->getInsertID();
            $billProduct = array();
            foreach ($lots as $lot) {
                $lotId = $lot;
                $billProduct['lot_id'] = $lot;
                $billProduct['quantity'] = 1;
                $billProduct['unit_price'] = 0;
                $billProduct['price_ht'] = 0;
                $billProduct['price_ttc'] = 0;
                $billProduct['price_tva'] = 0;
                $billProduct['ristourne_val'] = NULL;
                $billProduct['ristourne_%'] = NULL;
                $billProduct['tva_id'] = 1;

                $this->BillProduct->addBillProduct($billProduct, $billId, $lotId);
                $lot = $this->BillProduct->Lot->getLotById($lotId);
                $productId = $lot['Lot']['product_id'];
                $this->BillProduct->Lot->updateQuantityLot($lotId, 1, $type);
                $this->BillProduct->Lot->Product->updateQuantityProduct($productId, 1, $type);

            }


        }


    }

    /**
     * @param null $bill
     * @param null $lots
     * @param null $type
     * @param null $billId
     * @throws Exception
     */
    function editBill($bill = null, $lots = null, $type = null, $billId = null)
    {

        if ($this->save($bill)) {
            $billProduct = array();
            foreach ($lots as $lot) {
                $lotId = $lot;
                $billProduct['lot_id'] = $lot;
                $billProduct['quantity'] = 1;
                $billProduct['unit_price'] = 0;
                $billProduct['price_ht'] = 0;
                $billProduct['price_ttc'] = 0;
                $billProduct['price_tva'] = 0;
                $billProduct['ristourne_val'] = NULL;
                $billProduct['ristourne_%'] = NULL;
                $billProduct['tva_id'] = 1;

                $this->BillProduct->addBillProduct($billProduct, $billId, $lotId);
                $lot = $this->BillProduct->Lot->getLotById($lotId);
                $productId = $lot['Lot']['product_id'];
                $this->BillProduct->Lot->updateQuantityLot($lotId, 1, $type);
                $this->BillProduct->Lot->Product->updateQuantityProduct($productId, 1, $type);

            }


        }


    }
	
	 /**
     * created : 09/04/2019
     * @param null $billId
     * @throws Exception
     */
	function getTypeBill($billId = null){
		
		$type = null;
		$bill = $this->find('first',array(
											'recursive'=>-1, 
											'conditions'=>array('Bill.id'=>$billId),
											'fields'=>array('Bill.type')
											));
		if(!empty($bill))	
		{
			$type = $bill['Bill']['type'];
		}	
		return $type;	
	}
	
	 /**
     * created : 18/04/2019
     * @param null $type
     * @param null $conditions
     * @throws Exception
     */
	public function getPaymentTotals($conditions= null , $type= null){
	
		 
		 
		 
		 $paymentTotals= $this->find('all',  array(
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'recursive' => -1,
            'fields' => array( 	'sum(Bill.amount_remaining) AS total_amount_remaining ',
								'sum(Bill.total_ht) AS total_total_ht', 
								'sum(Bill.total_ttc) AS total_total_ttc', 
								'sum(Bill.total_tva) AS total_total_tva',
								'sum(Bill.stamp) AS total_stamp',
								'sum(Bill.ristourne_val) AS total_ristourne'),
            'joins' => array(
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Bill.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Event',
                    'conditions' => array('Bill.event_id = Event.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Event.car_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'event_event_types',
                    'type' => 'left',
                    'alias' => 'EventEventType',
                    'conditions' => array('EventEventType.event_id = Event.id')
                ),
                array(
                    'table' => 'event_types',
                    'type' => 'left',
                    'alias' => 'EventType',
                    'conditions' => array('EventEventType.event_type_id = EventType.id')
                )

            )
        ));
	}

		public function updateStatusBill($billId = null)
    {
        $this->id = $billId;
        $this->saveField('status', 2);
    }

    /** created : 16/05/2019
     * @param $id
     * @param $modelField
     * @return array|null
     */
    public function getBillByForeignKey($id, $modelField)
    {
        $bill = $this->find(
            'first',
            array(
                'conditions'=>array($modelField => $id),
                'fields' => array('Bill.id'),
                'recursive'=>-1
            ));
        return $bill;
    }

    /**
     * @param null $conditions
     * @param null $type
     * @return array
     */
	public function getBillTotals($conditions= null, $type= null){
		
		$bills = $this->find('all',array(
								'recursive'=>-1,
                                'group' => 'Bill.id',
								'conditions'=>$conditions,
								 'fields' => array( 'Bill.amount_remaining',
								 'Bill.type','Bill.total_ht', 'Bill.total_ttc', 
								 'Bill.total_tva','Bill.stamp','Bill.ristourne_val'),
            'joins' => array(
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Bill.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'bill_products',
                    'type' => 'left',
                    'alias' => 'BillProduct',
                    'conditions' => array('Bill.id = BillProduct.bill_id')
                ),
                array(
                    'table' => 'lots',
                    'type' => 'left',
                    'alias' => 'Lot',
                    'conditions' => array('BillProduct.lot_id = Lot.id')
                ),
                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Event',
                    'conditions' => array('Bill.event_id = Event.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Event.car_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'event_event_types',
                    'type' => 'left',
                    'alias' => 'EventEventType',
                    'conditions' => array('EventEventType.event_id = Event.id')
                ),
                array(
                    'table' => 'event_types',
                    'type' => 'left',
                    'alias' => 'EventType',
                    'conditions' => array('EventEventType.event_type_id = EventType.id')
                )

            )
		
		));
		
						$total= array();
						$totalHt =  0;
						$totalTtc = 0;
						$totalRistourne = 0;
						$stamp = 0;
						$totalTva = 0;
						$amountRemaining = 0;
						$totalRest = 0;
		
		foreach ($bills as $bill){
			 
		 switch ($type) {
            case BillTypesEnum::supplier_order :
				$totalHt =  $totalHt + $bill['Bill']['total_ht'];
				$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
				$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
				$stamp = $stamp + $bill['Bill']['stamp'];
				$totalTva = $totalTva + $bill['Bill']['total_tva'];
				$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
				$totalRest = $totalTtc - $amountRemaining;
                break;
            case BillTypesEnum::receipt :
				$totalHt =  $totalHt + $bill['Bill']['total_ht'];
				$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
				$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
				$stamp = $stamp + $bill['Bill']['stamp'];
				$totalTva = $totalTva + $bill['Bill']['total_tva'];
				$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
				$totalRest = $totalTtc - $amountRemaining;
				break;

            case BillTypesEnum::return_supplier :
				$totalHt =  $totalHt + $bill['Bill']['total_ht'];
				$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
				$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
				$stamp = $stamp + $bill['Bill']['stamp'];
				$totalTva = $totalTva + $bill['Bill']['total_tva'];
				$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
				$totalRest = $totalTtc - $amountRemaining;
				break;
            case BillTypesEnum::purchase_invoice :
			
				$totalHt =  $totalHt + $bill['Bill']['total_ht'];
				$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
				$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
				$stamp = $stamp + $bill['Bill']['stamp'];
				$totalTva = $totalTva + $bill['Bill']['total_tva'];
				$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
				$totalRest = $totalTtc - $amountRemaining;
				break;

            case BillTypesEnum::credit_note :
				$totalHt =  $totalHt + $bill['Bill']['total_ht'];
				$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
				$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
				$stamp = $stamp + $bill['Bill']['stamp'];
				$totalTva = $totalTva + $bill['Bill']['total_tva'];
				$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
				$totalRest = $totalTtc - $amountRemaining;
				break;

            case BillTypesEnum::delivery_order :
				$totalHt =  $totalHt + $bill['Bill']['total_ht'];
				$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
				$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
				$stamp = $stamp + $bill['Bill']['stamp'];
				$totalTva = $totalTva + $bill['Bill']['total_tva'];
				$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
				$totalRest = $totalTtc - $amountRemaining;
				break;

            case BillTypesEnum::return_customer :
				$totalHt =  $totalHt + $bill['Bill']['total_ht'];
				$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
				$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
				$stamp = $stamp + $bill['Bill']['stamp'];
				$totalTva = $totalTva + $bill['Bill']['total_tva'];
				$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
				$totalRest = $totalTtc - $amountRemaining;
				break;

            case BillTypesEnum::entry_order :
				$totalHt =  $totalHt + $bill['Bill']['total_ht'];
				$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
				$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
				$stamp = $stamp + $bill['Bill']['stamp'];
				$totalTva = $totalTva + $bill['Bill']['total_tva'];
				$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
				$totalRest = $totalTtc - $amountRemaining;
				break;

            case BillTypesEnum::exit_order :
				$totalHt =  $totalHt + $bill['Bill']['total_ht'];
				$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
				$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
				$stamp = $stamp + $bill['Bill']['stamp'];
				$totalTva = $totalTva + $bill['Bill']['total_tva'];
				$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
				$totalRest = $totalTtc - $amountRemaining;
				break;

            case BillTypesEnum::renvoi_order :
				$totalHt =  $totalHt + $bill['Bill']['total_ht'];
				$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
				$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
				$stamp = $stamp + $bill['Bill']['stamp'];
				$totalTva = $totalTva + $bill['Bill']['total_tva'];
				$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
				$totalRest = $totalTtc - $amountRemaining;
				break;

            case BillTypesEnum::reintegration_order :
				$totalHt =  $totalHt + $bill['Bill']['total_ht'];
				$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
				$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
				$stamp = $stamp + $bill['Bill']['stamp'];
				$totalTva = $totalTva + $bill['Bill']['total_tva'];
				$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
				$totalRest = $totalTtc - $amountRemaining;
				break;

            case BillTypesEnum::commercial_bills_list :
				switch ($bill['Bill']['type']) {
					case  BillTypesEnum::receipt :
						$totalHt =  $totalHt - $bill['Bill']['total_ht'];
						$totalTtc = $totalTtc - $bill['Bill']['total_ttc'];
						$totalRistourne = $totalRistourne - $bill['Bill']['ristourne_val'];
						$stamp = $stamp - $bill['Bill']['stamp'];
						$totalTva = $totalTva - $bill['Bill']['total_tva'];
						$amountRemaining =  $amountRemaining - $bill['Bill']['amount_remaining'];
						$totalRest = $totalTtc - $amountRemaining;
						
					break;
					case  BillTypesEnum::delivery_order :
						$totalHt =  $totalHt + $bill['Bill']['total_ht'];
						$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
						$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
						$stamp = $stamp + $bill['Bill']['stamp'];
						$totalTva = $totalTva + $bill['Bill']['total_tva'];
						$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
						$totalRest = $totalTtc - $amountRemaining;
					break;
					case  BillTypesEnum::return_customer :
						$totalHt =  $totalHt - $bill['Bill']['total_ht'];
						$totalTtc = $totalTtc - $bill['Bill']['total_ttc'];
						$totalRistourne = $totalRistourne - $bill['Bill']['ristourne_val'];
						$stamp = $stamp - $bill['Bill']['stamp'];
						$totalTva = $totalTva - $bill['Bill']['total_tva'];
						$amountRemaining =  $amountRemaining - $bill['Bill']['amount_remaining'];
						$totalRest = $totalTtc - $amountRemaining;
					break;
					case  BillTypesEnum::return_supplier :
						$totalHt =  $totalHt + $bill['Bill']['total_ht'];
						$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
						$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
						$stamp = $stamp + $bill['Bill']['stamp'];
						$totalTva = $totalTva + $bill['Bill']['total_tva'];
						$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
						$totalRest = $totalTtc - $amountRemaining;
					break;
				}
				
				break;

            case BillTypesEnum::special_bills_list :
			
				switch ($bill['Bill']['type']) {
					case  BillTypesEnum::entry_order :
						$totalHt =  $totalHt - $bill['Bill']['total_ht'];
						$totalTtc = $totalTtc - $bill['Bill']['total_ttc'];
						$totalRistourne = $totalRistourne - $bill['Bill']['ristourne_val'];
						$stamp = $stamp - $bill['Bill']['stamp'];
						$totalTva = $totalTva - $bill['Bill']['total_tva'];
						$amountRemaining =  $amountRemaining - $bill['Bill']['amount_remaining'];
						$totalRest = $totalTtc - $amountRemaining;
					break;
					case  BillTypesEnum::exit_order :
						$totalHt =  $totalHt + $bill['Bill']['total_ht'];
						$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
						$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
						$stamp = $stamp + $bill['Bill']['stamp'];
						$totalTva = $totalTva + $bill['Bill']['total_tva'];
						$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
						$totalRest = $totalTtc - $amountRemaining;
					break;
					case  BillTypesEnum::renvoi_order :
						$totalHt =  $totalHt + $bill['Bill']['total_ht'];
						$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
						$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
						$stamp = $stamp + $bill['Bill']['stamp'];
						$totalTva = $totalTva + $bill['Bill']['total_tva'];
						$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
						$totalRest = $totalTtc - $amountRemaining;
					break;
					case  BillTypesEnum::reintegration_order :
						$totalHt =  $totalHt + $bill['Bill']['total_ht'];
						$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
						$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
						$stamp = $stamp + $bill['Bill']['stamp'];
						$totalTva = $totalTva + $bill['Bill']['total_tva'];
						$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
						$totalRest = $totalTtc - $amountRemaining;
					break;
				}
                break;

            case BillTypesEnum::purchase_invoices_list :
				switch ($bill['Bill']['type']) {
					case  BillTypesEnum::purchase_invoice :
						$totalHt =  $totalHt - $bill['Bill']['total_ht'];
						$totalTtc = $totalTtc - $bill['Bill']['total_ttc'];
						$totalRistourne = $totalRistourne - $bill['Bill']['ristourne_val'];
						$stamp = $stamp - $bill['Bill']['stamp'];
						$totalTva = $totalTva - $bill['Bill']['total_tva'];
						$amountRemaining =  $amountRemaining - $bill['Bill']['amount_remaining'];
						$totalRest = $totalTtc - $amountRemaining;
					break;
					case  BillTypesEnum::credit_note :
						$totalHt =  $totalHt + $bill['Bill']['total_ht'];
						$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
						$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
						$stamp = $stamp + $bill['Bill']['stamp'];
						$totalTva = $totalTva + $bill['Bill']['total_tva'];
						$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
						$totalRest = $totalTtc - $amountRemaining;
						
					break;
				}
                break;
				
			case BillTypesEnum::quote :
				$totalHt =  $totalHt + $bill['Bill']['total_ht'];
				$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
				$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
				$stamp = $stamp + $bill['Bill']['stamp'];
				$totalTva = $totalTva + $bill['Bill']['total_tva'];
				$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
				$totalRest = $totalTtc - $amountRemaining;
				break; 
				
			case BillTypesEnum::customer_order :
				$totalHt =  $totalHt + $bill['Bill']['total_ht'];
				$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
				$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
				$stamp = $stamp + $bill['Bill']['stamp'];
				$totalTva = $totalTva + $bill['Bill']['total_tva'];
				$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
				$totalRest = $totalTtc - $amountRemaining;
				break;
				
			case BillTypesEnum::sales_invoice :
				$totalHt =  $totalHt + $bill['Bill']['total_ht'];
				$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
				$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
				$stamp = $stamp + $bill['Bill']['stamp'];
				$totalTva = $totalTva + $bill['Bill']['total_tva'];
				$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
				$totalRest = $totalTtc - $amountRemaining;
				break;	
				
			case BillTypesEnum::sale_credit_note :
				$totalHt =  $totalHt + $bill['Bill']['total_ht'];
				$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
				$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
				$stamp = $stamp + $bill['Bill']['stamp'];
				$totalTva = $totalTva + $bill['Bill']['total_tva'];
				$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
				$totalRest = $totalTtc - $amountRemaining;
				break;	
				
			case BillTypesEnum::sale_invoices_list :
			
				switch ($bill['Bill']['type']) {
					case  BillTypesEnum::sales_invoice :
						$totalHt =  $totalHt + $bill['Bill']['total_ht'];
						$totalTtc = $totalTtc + $bill['Bill']['total_ttc'];
						$totalRistourne = $totalRistourne + $bill['Bill']['ristourne_val'];
						$stamp = $stamp + $bill['Bill']['stamp'];
						$totalTva = $totalTva + $bill['Bill']['total_tva'];
						$amountRemaining =  $amountRemaining + $bill['Bill']['amount_remaining'];
						$totalRest = $totalTtc - $amountRemaining;
					break;
					case  BillTypesEnum::sale_credit_note :
						$totalHt =  $totalHt - $bill['Bill']['total_ht'];
						$totalTtc = $totalTtc - $bill['Bill']['total_ttc'];
						$totalRistourne = $totalRistourne - $bill['Bill']['ristourne_val'];
						$stamp = $stamp - $bill['Bill']['stamp'];
						$totalTva = $totalTva - $bill['Bill']['total_tva'];
						$amountRemaining =  $amountRemaining - $bill['Bill']['amount_remaining'];
						$totalRest = $totalTtc - $amountRemaining;
					break;
				}
				break;	

            default :
               
				break;
				
			
        } 
	
		}
		
		    
		$total['totalHt']	= $totalHt;			
		$total['totalTtc']	= $totalTtc;
		$total['totalRistourne']	= $totalRistourne;
		$total['stamp']	= $stamp;
		$total['totalTva']	= $totalTva;
		$total['amountRemaining']	= $amountRemaining;
		$total['totalRest']	= $totalRest;
		return 	$total;	
		
		
		
		
	}

    public function updateExitBill($lots = null, $sheetRideDetailRideId = null, $clientId = null, $billId = null)
    {
        $type = BillTypesEnum::exit_order;
        $bill['Bill']['id'] = $billId;
        $bill['Bill']['user_id'] = $this->Session->read('Auth.User.id');
        $bill['Bill']['sheet_ride_detail_ride_id'] = $sheetRideDetailRideId;
        if (!empty($clientId)) {
            $bill['Bill']['supplier_id'] = $clientId;
        } else {
            $bill['Bill']['supplier_id'] = 2;
        }
        $bill['Bill']['date'] = date('Y-m-d');
        $bill['Bill']['type'] = $type;
        $this->BillProduct->deleteBillProducts($type, $billId);
        $this->editBill($bill, $lots, $type, $billId);

    }


    public function deleteExitBill($billId = null)
    {
        $type = BillTypesEnum::exit_order;
        $this->BillProduct->deleteBillProducts($type, $billId);
        $this->delete($billId);
    }

    public function addExitBill($lots = null, $sheetRideDetailRideId = null, $clientId = null ,$reference,$userId)
    {


        if ($reference != '0') {
            $bill['Bill']['reference'] = $reference;
        }
        $bill['Bill']['user_id'] = $userId;
        $bill['Bill']['sheet_ride_detail_ride_id'] = $sheetRideDetailRideId;
        if (!empty($clientId)) {
            $bill['Bill']['supplier_id'] = $clientId;
        } else {
            $bill['Bill']['supplier_id'] = 2;
        }
        $bill['Bill']['date'] = date('Y-m-d');
        $bill['Bill']['type'] =  BillTypesEnum::exit_order;;
        $this->addBill($bill, $lots,  BillTypesEnum::exit_order);

    }

}