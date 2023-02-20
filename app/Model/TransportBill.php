<?php
App::uses('AppModel', 'Model');

/**
 * TransportBill Model
 *
 * @property TransportBillDetailRides $TransportBillDetailRides
 */
class TransportBill extends AppModel
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
        'Marchandise' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),

        ),
        'detail_ride_id' => array(
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
        'Marchandise' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),

        ),
        'detail_ride_id' => array(
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


    public $validate_request = array(
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
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'ride_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'car_type_id' => array(
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


    public $validateCancelCauses = array(
        'cancel_cause_id' => array(
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
    public $hasMany = array(

        'TransportBillDetailRides' => array(
            'className' => 'TransportBillDetailRides',
            'foreignKey' => 'transport_bill_id',
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
        'TransportBillDetailedRides' => array(
            'className' => 'TransportBillDetailedRides',
            'foreignKey' => 'transport_bill_id',
            'dependent' => true,
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
        'SupplierFinal' => array(
            'className' => 'Supplier',
            'foreignKey' => 'supplier_final_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'DetailRide' => array(
            'className' => 'DetailRide',
            'foreignKey' => 'detail_ride_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'RideCategory' => array(
            'className' => 'RideCategory',
            'foreignKey' => 'ride_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

        'TransportBillCategory' => array(
            'className' => 'TransportBillCategory',
            'foreignKey' => 'transport_bill_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Ride' => array(
            'className' => 'Ride',
            'foreignKey' => 'ride_id'
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),


    );


    public function getTotals($conditions = null)
    {
        $totals = array();
        if($conditions !=null){
            $conditions = '1=1 AND '.$conditions;
        }

        if ($conditions != null) {
            $transportBills = $this->find('all', array(
                'conditions' => $conditions,
                'paramType' => 'querystring',
                'recursive' => -1, // should be used with joins
                'fields' => array(
                    'sum(TransportBill.total_ht) as total_ht',
                    'sum(TransportBill.total_ttc) as total_ttc',
                    'sum(TransportBill.total_tva) as total_tva',
                ),
                'joins' => array(
                    array(
                        'table' => 'detail_rides',
                        'type' => 'left',
                        'alias' => 'DetailRide',
                        'conditions' => array('TransportBill.detail_ride_id = DetailRide.id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('TransportBill.supplier_id = Supplier.id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'SupplierFinal',
                        'conditions' => array('TransportBill.supplier_final_id = SupplierFinal.id')
                    ),
                    array(
                        'table' => 'rides',
                        'type' => 'left',
                        'alias' => 'Ride',
                        'conditions' => array('DetailRide.ride_id = Ride.id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'CarType',
                        'conditions' => array('DetailRide.car_type_id = CarType.id')
                    ),
                    array(
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'DepartureDestination',
                        'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                    ),
                    array(
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'ArrivalDestination',
                        'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                    ),
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('TransportBill.user_id = User.id')
                    ), array(
                        'table' => 'services',
                        'type' => 'left',
                        'alias' => 'Service',
                        'conditions' => array('TransportBill.service_id = Service.id')
                    )
                )

            ));

            $totals['total_ht'] = $transportBills[0][0]['total_ht'];
            $totals['total_ttc'] = $transportBills[0][0]['total_ttc'];
            $totals['total_tva'] = $transportBills[0][0]['total_tva'];

        } else {
            $transportBills = $this->find('all', array(

                'paramType' => 'querystring',
                'recursive' => -1, // should be used with joins
                'fields' => array(
                    'sum(TransportBill.total_ht) as total_ht',
                    'sum(TransportBill.total_ttc) as total_ttc',
                    'sum(TransportBill.total_tva) as total_tva',
                ),


            ));

            $totals['total_ht'] = $transportBills[0][0]['total_ht'];
            $totals['total_ttc'] = $transportBills[0][0]['total_ttc'];
            $totals['total_tva'] = $transportBills[0][0]['total_tva'];

        }
        return $totals;
    }


    /** get all transport bills with is_open = 1
     * @return array|null
     */
    public function getAllOpenedTransportBills()
    {
        $transportBills = $this->find('all', array(
            'recursive' => -1,
            'conditions' => array('is_open' => 1),
            'fields' => array('id')
        ));
        return $transportBills;
    }

    /** get amount remaining and total tcc by transport bill id
     * @param $id
     * @return mixed array
     */
    public function getTransportBillById($id)
    {
        $transportBill = $this->find('first', array(
            'conditions' => array('TransportBill.id' => $id),
            'recursive' => -1,
            'fields' => array(
                'TransportBill.id',
                'TransportBill.supplier_id',
                'TransportBill.reference',
                'TransportBill.date',
                'TransportBill.payment_method',
                'TransportBill.order_type',
                'TransportBill.amount_remaining',
                'TransportBill.total_ht',
                'TransportBill.ristourne_val',
                'TransportBill.ristourne_percentage',
                'TransportBill.total_tva',
                'TransportBill.total_ttc',
                'TransportBill.stamp',
                'TransportBill.with_penalty',
                'TransportBill.invoice_id',
                'TransportBill.credit_note_type',
                'Supplier.name',
                'Supplier.adress',
                'Supplier.code',
                'Supplier.ai',
                'Supplier.if',
                'Supplier.rc'
            ),
            'joins' => array(
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('TransportBill.supplier_id = Supplier.id')
                ),
            )
        ));


        return $transportBill;

    }


    public function getBillById($id = null)
    {
        $bill = $this->find('first', array(
            'recursive' => -1,
            'conditions' => array('id'=>$id),
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
            'conditions' => array('id'=>$ids),
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


    /**
     * Get transport bill by foreign key
     *
     * @param int $id
     * @param string $modelField
     *
     * @return array $transportBill
     */
    public function getTransportBillByForeignKey($id, $modelField)
    {
        $transportBill = $this->find(
            'first',
            array(
                'conditions'=>array($modelField => $id),
                'fields' => array('TransportBill.id'),
                'recursive'=>-1
            ));
        return $transportBill;
    }

    /**
     * Update customers orders statuses method
     *
     * @return void
     */

    public function updateStatusCustomerOrders()
    {
        $transportBills = $this->find('all', array(
            'conditions' => array('TransportBill.type' => 2,
                'TransportBill.status !=' => array(TransportBillDetailRideStatusesEnum::not_transmitted, TransportBillDetailRideStatusesEnum::canceled)),
            'fields' => array('status', 'id'),
            'recursive' => -1
        ));
        foreach ($transportBills as $transportBill) {
            $transportBillId = $transportBill['TransportBill']['id'];
            $transportBillDetailRides = $this->TransportBillDetailRides->find('all', array(
                'conditions' => array('TransportBillDetailRides.transport_bill_id' => $transportBillId),
                'fields' => array(
                    'sum(nb_trucks)   AS total_nb_trucks',
                    'sum(nb_trucks_validated)   AS total_nb_trucks_validated',
                    'transport_bill_id'
                ),
                'recursive' => -1
            ));
            $totalNbTrucks = $transportBillDetailRides[0][0]['total_nb_trucks'];
            $totalNbTrucksValidated = $transportBillDetailRides[0][0]['total_nb_trucks_validated'];
            if ($totalNbTrucksValidated == 0) {
                $status = TransportBillDetailRideStatusesEnum:: not_validated;
            } else {
                if ($totalNbTrucks > $totalNbTrucksValidated) {
                    $status = TransportBillDetailRideStatusesEnum:: partially_validated;
                } else {
                    $status = TransportBillDetailRideStatusesEnum:: validated;
                }
            }
            $this->id = $transportBillId;
            $this->saveField('status', $status);
        }

    }
    public function updateStatusCustomerOrder($transportBillId)
    {


            $transportBillDetailRides = $this->TransportBillDetailRides->find('all', array(
                'conditions' => array('TransportBillDetailRides.transport_bill_id' => $transportBillId),
                'fields' => array(
                    'status_id',
                    'transport_bill_id'
                ),
                'recursive' => -1
            ));
            $nbTransportBillDetailRides = count ($transportBillDetailRides);
            $nbNotValidated = 0;
            $nbValidated = 0;

            foreach ($transportBillDetailRides as $transportBillDetailRide){
                if($transportBillDetailRide['TransportBillDetailRides']['status_id']==
                    TransportBillDetailRideStatusesEnum:: not_validated) {
                    $nbNotValidated ++;
                }else {
                    if($transportBillDetailRide['TransportBillDetailRides']['status_id']==
                        TransportBillDetailRideStatusesEnum:: validated){
                        $nbValidated ++;
                    }
                }

            }

            if ($nbValidated == 0 && $nbTransportBillDetailRides== $nbNotValidated) {
                $status = TransportBillDetailRideStatusesEnum:: not_validated;
            } else {
                if ($nbTransportBillDetailRides > $nbValidated) {
                    $status = TransportBillDetailRideStatusesEnum:: partially_validated;
                } else {
                    if($nbTransportBillDetailRides == $nbValidated ){
                        $status = TransportBillDetailRideStatusesEnum:: validated;
                    }

                }
            }
            $this->id = $transportBillId;
            $this->saveField('status', $status);


    }

    /**
     * @param null $conditions
     * @param null $typeSelect
     * @param null $order
     * @return array|null
     */
    public function getTransportBillsByConditions($conditions = null, $typeSelect = null, $order = null)
    {
        if(empty($order)){
            $order = 'TransportBill.id ASC';
        }

        $transportBills = $this->find($typeSelect, array(

            'recursive' => -1,
            'conditions' => $conditions,
            'order' => $order,
            'paramType' => 'querystring',
            'fields' => array(

                'TransportBill.reference',
                'TransportBill.id',
                'TransportBill.date',
                'TransportBill.total_ttc',
                'TransportBill.total_ht',
                'TransportBill.total_tva',
                'TransportBill.supplier_id',
                'Supplier.name',
                'TransportBill.date',
                'TransportBill.type',
                'TransportBill.status',
                'TransportBill.user_id',
                'TransportBill.modified_id'

            ),
            'joins' => array(

                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('TransportBill.supplier_id = Supplier.id')
                ),
            )
        ));
        return $transportBills;
    }

    public function updateNbComplaintsByObservations($transportBillId = null, $nbComplaints = null)
    {

        $this->id = $transportBillId;
        $this->saveField('nb_complaints_by_orders', $nbComplaints);
    }


    public function getInvoices($typeSelect = null, $supplierId = null){
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        $invoices = $this->find($typeSelect,
            array(
                'conditions'=>array('TransportBill.type'=>TransportBillTypesEnum::invoice,
                                    'TransportBill.supplier_id'=>$supplierId
                    ),
                'recursive'=>-1,
                'fields'=>array('TransportBill.id', 'TransportBill.reference')
            ));
        return $invoices;
    }

    public function getInvoicesWithoutCreditNote($typeSelect = null, $supplierId = null){
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        $invoices = $this->find($typeSelect,
            array(
                'conditions'=>array('TransportBill.type'=>TransportBillTypesEnum::invoice,
                    'TransportBill.supplier_id'=>$supplierId,
                    'TransportBill.has_credit_note' => 0,
                ),
                'recursive'=>-1,
                'fields'=>array('TransportBill.id', 'TransportBill.reference')
            ));
        return $invoices;
    }


}