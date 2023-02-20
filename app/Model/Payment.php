<?php

App::uses('AppModel', 'Model');

/**
 * AcquisitionType Model
 *
 * 
 */
class Payment extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'reference';

    /**
     * Validation rules
     *
     * @var array
     */
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
        'receipt_date' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),


        'amount' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'payment_type' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'compte_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        )
      

       
    );
    public $validate_car = array(
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


    public $validatePaymentEtat = array(
        'payment_etat' => array(
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

    public $validatePaymentCategory = array(
        'payment_category_id' => array(
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
        'Car' => array(
            'className' => 'Car',
            'foreignKey' => 'car_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Event' => array(
            'className' => 'Event',
            'foreignKey' => 'event_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Supplier' => array(
            'className' => 'Supplier',
            'foreignKey' => 'supplier_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Interfering' => array(
            'className' => 'Interfering',
            'foreignKey' => 'interfering_id',
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
        'UserModifier' => array(
            'className' => 'User',
            'foreignKey' => 'modified_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
      
        'Supplier' => array(
            'className' => 'Supplier',
            'foreignKey' => 'supplier_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Compte' => array(
            'className' => 'Compte',
            'foreignKey' => 'compte_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    
     
    );
    public $hasMany = array(
        'DetailPayment' => array(
            'className' => 'DetailPayment',
            'foreignKey' => 'payment_id',
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
    );

    /** get detail payments (les tranches de paiement) by transport bill ids
     * @param $transportBillIds
     * @return array|null
     */
    public function getPaymentPartsByTransportBillIds($transportBillIds= null){
        $paymentParts = $this->find('all', array(
            'recursive' => -1,
            'conditions' => array('DetailPayment.transport_bill_id' => $transportBillIds),
            'fields' => array(
                'Payment.id',
                'Payment.receipt_date',
                'Payment.operation_date',
                'Payment.amount',
                'Payment.wording',
                'Payment.payment_type',
                'Payment.number_payment',
                'Payment.payment_association_id',
                'DetailPayment.payroll_amount',
                'Compte.num_compte'
            ),
            'joins' => array(
                array(
                    'table' => 'detail_payments',
                    'type' => 'left',
                    'alias' => 'DetailPayment',
                    'conditions' => array('DetailPayment.payment_id = Payment.id')
                ),
                array(
                    'table' => 'comptes',
                    'type' => 'left',
                    'alias' => 'Compte',
                    'conditions' => array('Payment.compte_id = Compte.id')
                ),

            )
        ));
        return $paymentParts;
    }
	 /** get detail payments (les tranches de paiement) by  bill ids
     * @param $billIds
     * @return array|null
	 * created : 24/04/2019
     */
    public function getPaymentPartsByBillIds($billIds){
        $paymentParts = $this->find('all', array(
            'recursive' => -1,
            'conditions' => array('DetailPayment.bill_id' => $billIds),
            'fields' => array(
                'Payment.id',
                'Payment.receipt_date',
                'Payment.amount',
                'Payment.number_payment',
                'Payment.wording',
                'Payment.payment_type',
                'Payment.payment_association_id',
                'DetailPayment.payroll_amount'
            ),
            'joins' => array(
                array(
                    'table' => 'detail_payments',
                    'type' => 'left',
                    'alias' => 'DetailPayment',
                    'conditions' => array('DetailPayment.payment_id = Payment.id')
                ),
            )
        ));
        return $paymentParts;
    }

    
	
	
	
	
	
	/** get advanced payment by supplier id
     * @param null $supplierId
     * @return array|null
     */
    public function getAdvancedPaymentsBySupplierId($supplierId = null){
        $advancedPayments = $this->find('all', array(
            'recursive' => -1,
            'conditions' => array('Payment.supplier_id' => $supplierId, 'DetailPayment.payment_id IS NULL'),
            'fields' => array(
                'Payment.id',
                'Payment.receipt_date',
                'Payment.amount',
                'Payment.wording',
                'Payment.payment_type',
                'DetailPayment.payment_id',
            ),
            'joins' => array(
                array(
                    'table' => 'detail_payments',
                    'type' => 'left',
                    'alias' => 'DetailPayment',
                    'conditions' => array('DetailPayment.payment_id = Payment.id')
                ),
            )
        ));
        return $advancedPayments;
    }

    /** get payments with over amount by supplier id
     * @param null $supplierId
     * @return array|null
     */
    public function getPaymentsWithOverAmountBySupplierId($supplierId = null ){
        $remainingPayments = $this->find('all', array(
            'recursive' => -1,
            'conditions' => array('Payment.supplier_id' => $supplierId ,'DetailPayment.payroll_amount >0' ),
            'fields' => array(
                'Payment.id',
                'Payment.receipt_date',
                'Payment.amount',
                'Payment.wording',
                'Payment.payment_type',
                'DetailPayment.payment_id',
                'SUM(DetailPayment.payroll_amount) as sum_payroll_amount'
            ),
            'group' => array(
                'Payment.id HAVING ( sum_payroll_amount < Payment.amount)'
            ),
            'joins' => array(
                array(
                    'table' => 'detail_payments',
                    'type' => 'left',
                    'alias' => 'DetailPayment',
                    'conditions' => array('DetailPayment.payment_id = Payment.id')
                )
            )
        ));
        return $remainingPayments;
    }

    /** get payment by id (this payment is join to supplier)
     * @param null $id
     * @return array|null
     */
    public function getPaymentWithSupplierById($id = null){
        $payment = $this->find('first', array(
            'conditions' => array('Payment.id' => $id),
            'recursive' => -1,
            'fields' => array('Payment.id', 'Payment.amount', 'Payment.compte_id', 'Supplier.id'),
            'joins' => array(
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Supplier.id = Payment.supplier_id')
                ),
            )
        ));
        return $payment;
    }

    /**  get payment by id (this payment is join to customer)
     * @param null $id
     * @return mixed
     */
    public  function getPaymentWithCustomerById($id = null){
        $payment = $this->Payment->find('first', array(
            'conditions' => array('Payment.id' => $id),
            'recursive' => -1,
            'fields' => array('Payment.id', 'Payment.amount', 'Payment.compte_id', 'Customer.id'),
            'joins' => array(
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Customer.id = Payment.customer_id')
                ),
            )
        ));

        return $payment;
    }

		/**  
		* get payments by conditions
		 * @param null|array $conditions
		 * @return array $payments
		 */
		public  function getPaymentsByConditions($conditions = null){

			$payments = $this->find('all', array(

				'recursive' => -1,
				'conditions' => $conditions,
				'paramType' => 'querystring',
				'fields' => array(

					'Payment.wording',
					'Payment.receipt_date',
					'Payment.payment_type',
					'Payment.customer_id',
					'Association.name',
					'Payment.amount',
					'Payment.compte_id',
					'Supplier.name',
					'Compte.num_compte',
					'Payment.number_payment',
					'Payment.deadline_date'
				),
				'joins' => array(

					array(
						'table' => 'suppliers',
						'type' => 'left',
						'alias' => 'Supplier',
						'conditions' => array('Payment.supplier_id = Supplier.id')
					),
					array(
						'table' => 'comptes',
						'type' => 'left',
						'alias' => 'Compte',
						'conditions' => array('Payment.compte_id = Compte.id')
					),
					array(
						'table' => 'payment_associations',
						'type' => 'left',
						'alias' => 'Association',
						'conditions' => array('Payment.payment_association_id = Association.id')
					),
				)
			));
			return $payments;
		}

		
   /**  created : 14/04/2019	
	* get payment by id
     * @param null|array $conditions
     * @return array $payments
     */
    public  function getPaymentById($id = null){

		$payment = $this->find('first', array(
            'recursive' => -1,
            'conditions' => array('Payment.id'=>$id),
            'paramType' => 'querystring',
            'fields' => array(
                'Payment.receipt_date',
                'Payment.operation_date',
                'Payment.value_date',
                'Payment.payment_type',
                'Payment.customer_id',
				'Payment.amount',
				'Payment.compte_id',
				'Payment.number_payment',
				'Payment.deadline_date',
				'Payment.transact_type_id',
				'Payment.payment_association_id',
				'Payment.note',
				'Payment.car_id',
				'Payment.event_id',
				'Payment.supplier_id',
				'Payment.interfering_id',
            )
        ));
		return $payment;
	}

    /**
     * @param null $billId
     * @return array|null
     */


	public function getPaymentsByBillId($billId = null){
		 
		$payments = $this->find('all', array(
            'recursive' => -1,
            'conditions' => array('DetailPayment.bill_id' => $billId),
            'fields' => array(
                'Payment.id',
                'Payment.receipt_date',
                'Payment.amount',
                'Payment.wording',
                'Payment.payment_type',
            ),
            'joins' => array(
                array(
                    'table' => 'detail_payments',
                    'type' => 'left',
                    'alias' => 'DetailPayment',
                    'conditions' => array('DetailPayment.payment_id = Payment.id')
                )
            )
        ));
		
		return $payments ; 
		
	}





    /**
     * @param $paymentId
     */
	public function createAssociationPaymentBills($paymentId)
    {

        $detailPayments = $this->DetailPayment->find('all', array(
            'conditions' => array('DetailPayment.payment_id' => $paymentId),
            'fields' => array('Bill.reference'),
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'bills',
                    'type' => 'left',
                    'alias' => 'Bill',
                    'conditions' => array('DetailPayment.bill_id = Bill.id')
                )

            )
        ));
        $wording = '';
        foreach ($detailPayments as $detailPayment) {

            if ($wording == '') {
                $wording = $detailPayment['Bill']['reference'];
            } else {
                $wording = $wording . ',' . $detailPayment['Bill']['reference'];
            }
        }
        $this->id = $paymentId;
        $this->saveField('wording', $wording);
    }
	
	    // Function for encryption
    function encrypt($data)
    {
        return base64_encode(base64_encode(base64_encode(strrev($data))));
    }

// Function for decryption
    function decrypt($data)
    {
        return strrev(base64_decode(base64_decode(base64_decode($data))));
    }

    /** created : 29/04/2019
     * @param null $conditions
     * @return array
     */

   function getPaymentTotals($conditions=null){
       $payments = $this->find('all', array(
           'recursive' => -1,
           'conditions' => $conditions,
           'paramType' => 'querystring',
           'fields' => array(
               'Payment.id',
               'Payment.deadline_date',
               'Payment.transact_type_id',
               'Payment.amount',
               'Payment.payment_etat',

           ),
           'joins' => array(
               array(
                   'table' => 'comptes',
                   'type' => 'left',
                   'alias' => 'Compte',
                   'conditions' => array('Compte.id = Payment.compte_id')
               ),
               array(
                   'table' => 'customers',
                   'type' => 'left',
                   'alias' => 'Customer',
                   'conditions' => array('Customer.id = Payment.customer_id')
               ),
               array(
                   'table' => 'car',
                   'type' => 'left',
                   'alias' => 'Car',
                   'conditions' => array('Car.id = Payment.car_id')
               ),
               array(
                   'table' => 'suppliers',
                   'type' => 'left',
                   'alias' => 'Supplier',
                   'conditions' => array('Supplier.id = Payment.supplier_id')
               ),
               array(
                   'table' => 'event',
                   'type' => 'left',
                   'alias' => 'Event',
                   'conditions' => array('Event.id = Payment.event_id')
               ),
               array(
                   'table' => 'interferings',
                   'type' => 'left',
                   'alias' => 'Interfering',
                   'conditions' => array('Interfering.id = Payment.interfering_id')
               ),
               array(
                   'table' => 'payment_associations',
                   'type' => 'left',
                   'alias' => 'PaymentAssociation',
                   'conditions' => array('PaymentAssociation.id = Payment.payment_association_id')
               ),
               array(
                   'table' => 'users',
                   'type' => 'left',
                   'alias' => 'User',
                   'conditions' => array('User.id = Payment.user_id')
               ),
               array(
                   'table' => 'profiles',
                   'type' => 'left',
                   'alias' => 'Profile',
                   'conditions' => array('Profile.id = User.profile_id')
               ),
           )
       ));

       $total= array();
       $debitGeneral = 0;
       $creditGeneral = 0;
       $debitDeadline = 0;
       $creditDeadline = 0;
       $debitTransaction = 0;
       $creditTransaction = 0;
       $debitCirculation = 0;
       $creditCirculation = 0;

       foreach ($payments as $payment){

           $currentDate=date("Y-m-d");
           if(!empty($payment['Payment']['deadline_date']) && ($payment['Payment']['deadline_date']!= '0000-00-00') &&
               ($currentDate > $payment['Payment']['deadline_date'])){
               if($payment['Payment']['transact_type_id']== 1){
                   $creditDeadline = $creditDeadline + $payment['Payment']['amount'];
               }else {
                   $debitDeadline = $debitDeadline + $payment['Payment']['amount'];
               }

           }

           switch($payment['Payment']['payment_etat']){
               case 1:
                   if($payment['Payment']['transact_type_id']== 1){
                       $creditGeneral = $creditGeneral + $payment['Payment']['amount'];
                   }else {
                       $debitGeneral = $debitGeneral + $payment['Payment']['amount'];
                   }

                   break;
               case 4:
                   if($payment['Payment']['transact_type_id']== 1){
                       $creditGeneral = $creditGeneral + $payment['Payment']['amount'];
                       $creditTransaction = $creditTransaction + $payment['Payment']['amount'];
                   }else {
                       $debitGeneral = $debitGeneral + $payment['Payment']['amount'];
                       $debitTransaction = $debitTransaction + $payment['Payment']['amount'];
                   }



                   break;
               case 2:
               case 3:
                   if($payment['Payment']['transact_type_id']== 1){
                       $creditGeneral = $creditGeneral + $payment['Payment']['amount'];
                       $creditCirculation = $creditCirculation + $payment['Payment']['amount'];

                   }else {
                       $debitCirculation = $debitCirculation + $payment['Payment']['amount'];
                       $debitGeneral = $debitGeneral + $payment['Payment']['amount'];
                   }

                   break;

               default:

                   if($payment['Payment']['transact_type_id']== 1){
                       $creditGeneral = $creditGeneral + $payment['Payment']['amount'];

                   }else {
                       $debitGeneral = $debitGeneral + $payment['Payment']['amount'];
                   }
                   break;
           }

       }
       $soldeGeneral = $creditGeneral - $debitGeneral;
       $soldeTransaction = $creditTransaction - $debitTransaction;
       $soldeCirculation = $creditCirculation - $debitCirculation;
       $soldeDeadline = $creditDeadline - $debitDeadline;
       $total['debitGeneral'] = $debitGeneral ;
       $total['creditGeneral'] = $creditGeneral ;
       $total['soldeGeneral'] = $soldeGeneral ;
       $total['debitDeadline'] = $debitDeadline ;
       $total['creditDeadline'] = $creditDeadline ;
       $total['soldeDeadline'] = $soldeDeadline ;
       $total['debitTransaction'] = $debitTransaction ;
       $total['creditTransaction'] = $creditTransaction ;
       $total['soldeTransaction'] = $soldeTransaction ;
       $total['debitCirculation'] = $debitCirculation ;
       $total['creditCirculation'] = $creditCirculation ;
       $total['soldeCirculation'] = $soldeCirculation  ;
	    return $total;
	}


}
