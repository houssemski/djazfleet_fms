<?php

App::uses('AppModel', 'Model');

/**
 * Car Model
 *
 * @property CarStatus $CarStatus
 * @property Mark $Mark
 * @property CarType $CarType
 * @property User $User
 * @property CarCategory $CarCategory
 * @property Fuel $Fuel
 * @property Customer $Customer
 */
class DetailPayment extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */

    /**
     * Validation rules
     *
     * @var array
     */

    public $validate = array(

        'payment_id ' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'sheet_ride_detail_ride_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'payroll_amount' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'amount_remaining' => array(
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

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */

    public $belongsTo = array(
        'SheetRideDetailRides' => array(
            'className' => 'SheetRideDetailRides',
            'foreignKey' => 'sheet_ride_detail_ride_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Payment' => array(
            'className' => 'Payment',
            'foreignKey' => 'payment_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )


    );
	/**
     * created : 18/04/2019
     *
     * @var array
     */
	
	function getDetailPaymentsByBillId ($billId = null){
		
		$detailPayments = $this->find('all', array(
            'conditions' => array('DetailPayment.bill_id' => $billId),
            'fields' => array('DetailPayment.bill_id', 'DetailPayment.id'),
            'recursive' => -1,
        ));
		
		return $detailPayments ; 
		
	}

    /**
     * @param null $paymentId
     * get balance of conductor which corresponds to a payment $paymentId,
     * @return int balance
     */
    public function getBalance($paymentId = null)
    {
        $detailPayments = $this->find('all', array(
            'conditions' => array('Payment.id' => $paymentId),
            'recursive' => -1,
            'fields' => array(
                'Payment.id',
                'Payment.amount',
                'Payment.compte_id',
                'sum(DetailPayment.payroll_amount)   AS total_payroll_amount'
            ),
            'joins' => array(

                array(
                    'table' => 'payments',
                    'type' => 'left',
                    'alias' => 'Payment',
                    'conditions' => array('DetailPayment.payment_id = Payment.id')
                )

            )
        ));

        $balance = $detailPayments[0]['Payment']['amount'] - $detailPayments[0][0]['total_payroll_amount'];

        if ($balance > 0) {
            return $balance;
        } else {
            return 0;
        }


    }


    public function getDetailPaymentByConsumptionId($consumptionId= null){
        $detailPayments = $this->find('all', array(
            'conditions' => array('DetailPayment.consumption_id' => $consumptionId),
            'recursive' => -1,
            'fields' => array(
                'Payment.id',
                'Customer.id',
                'Payment.amount',
                'Payment.compte_id',
                'sum(DetailPayment.payroll_amount)   AS total_payroll_amount'
            ),
            'joins' => array(

                array(
                    'table' => 'payments',
                    'type' => 'left',
                    'alias' => 'Payment',
                    'conditions' => array('DetailPayment.payment_id = Payment.id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Customer.id = Payment.customer_id')
                ),
            )
        ));
        return $detailPayments;
    }


    /**
     * @param $billId
     * get amount payroll for bill $billId
     * @return mixed
     */
    public function getTotalPayrollAmountBill($billId)
    {
        $totalPayrollAmount = 0;
        $detailPayments = $this->find('all', array(
            'conditions' => array('DetailPayment.bill_id' => $billId),
            'recursive' => -1,
            'fields' => array('sum(DetailPayment.payroll_amount)   AS total_payroll_amount'),
        ));
        if($totalPayrollAmount != null){
            $totalPayrollAmount = $detailPayments[0][0]['total_payroll_amount'];
        }


        return $totalPayrollAmount;

    }
}
