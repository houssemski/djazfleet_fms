<?php



App::uses('AppModel', 'Model');

/**
 * SheetRideDetailRides Model
 *
 */
class SheetRideDetailRides extends AppModel
{

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'sheet_ride_detail_rides';

    public $validate = array(
            'sheet_ride_id' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
           'supplier_id' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),


             'detail_ride_id' => array(
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
    public $validateSearch = array(
           'supplier_id' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
    );

    public $validatePersonalizedRide = array(
            'sheet_ride_id' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        /*  'supplier_id' => array(
               'notBlank' => array(
               'rule' => array('notBlank'),
               //'message' => 'Your custom message here',
               //'allowEmpty' => false,
               //'required' => false,
               //'last' => false, // Stop validation after this rule
               //'on' => 'create', // Limit validation to 'create' or 'update' operations
           ),
       ),


            'departure_destination_id' => array(
               'notBlank' => array(
               'rule' => array('notBlank'),
               //'message' => 'Your custom message here',
               //'allowEmpty' => false,
               //'required' => false,
               //'last' => false, // Stop validation after this rule
               //'on' => 'create', // Limit validation to 'create' or 'update' operations
           ),
       ), */



    );

    public $validateWithoutCommercial = array(
            'sheet_ride_id' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
             'departure_destination_id' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),

            'arrival_destination_id' => array(
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

    public $validateComplaints = array(
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

        'complaint_cause_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'complaint_date' => array(
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

    public $belongsTo = array(
        'DetailRide' => array(
            'className' => 'DetailRide',
            'foreignKey' => 'detail_ride_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'SheetRide' => array(
            'className' => 'SheetRide',
            'foreignKey' => 'sheet_ride_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),


        'Supplier' => array(
            'className' => 'Supplier',
            'foreignKey' => 'supplier_id'
        ),
    );

    // Function for encryption
    function encrypt($data) {
        return base64_encode(base64_encode(base64_encode(strrev($data))));
    }

// Function for decryption
    function decrypt($data) {
        return strrev(base64_decode(base64_decode(base64_decode($data))));
    }
    /**
     * Get status of the last mission of a sheet ride
     * @param int $sheetRideId sheet ride id
     * @return int|null $missionStatusId
     */
    public function getLastMissionStatus($sheetRideId)
    {
        $missionStatusId = null;
        $mission = $this->find(
            'first',
            array(
                'recursive' => -1,
                'conditions' => array( 'SheetRideDetailRides.sheet_ride_id' => $sheetRideId),
                'order' => 'SheetRideDetailRides.id DESC',
                'fields' => 'SheetRideDetailRides.status_id'
            )
        );
        if(!empty($mission)){
            $missionStatusId  = $mission['SheetRideDetailRides']['status_id'];
        }
        return($missionStatusId);
    }

    /** recuperer toutes les missions d'une feuille de route $sheetRideId
     * @param null $sheetRideId
     * @return array|null
     */
    public function getSheetRideDetailRidesBySheetRideId ($sheetRideId = null){
        $sheetRideDetailRides = $this->find('all', array(

            'recursive' => -1, // should be used with joins
            'order' => array('SheetRideDetailRides.id' => 'ASC'),
            'conditions' => array('SheetRideDetailRides.sheet_ride_id' => $sheetRideId),
            'fields' => array(
                'SheetRideDetailRides.reference',
                'TransportBillDetailRides.reference',
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.nb_complaints',
                'SheetRideDetailRides.type_ride',
                'SheetRideDetailRides.from_customer_order',
                'SheetRideDetailRides.detail_ride_id',
                'SheetRideDetailRides.departure_destination_id',
                'SheetRideDetailRides.arrival_destination_id',
                'SheetRideDetailRides.planned_start_date',
                'SheetRideDetailRides.real_start_date',
                'SheetRideDetailRides.km_departure',
                'SheetRideDetailRides.planned_end_date',
                'SheetRideDetailRides.real_end_date',
                'SheetRideDetailRides.km_arrival',
                'SheetRideDetailRides.supplier_id',
                'SheetRideDetailRides.supplier_final_id',
                'SheetRideDetailRides.status_id',
                'SheetRideDetailRides.invoiced_ride',
                'SheetRideDetailRides.transport_bill_detail_ride_id',
                'CarType.name',
                'Supplier.name',
                'SupplierFinal.name',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Departure.name',
                'Arrival.name',
                'CancelCause.name',
                'SheetRideDetailRides.observation_id',
                'Observation.nb_complaints',
            ),
            'group'=>'SheetRideDetailRides.id',
            'joins' => array(
                array(
                    'table' => 'transport_bill_detail_rides',
                    'type' => 'left',
                    'alias' => 'TransportBillDetailRides',
                    'conditions' => array('SheetRideDetailRides.transport_bill_detail_ride_id = TransportBillDetailRides.id')
                ),

                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('SheetRide.id = SheetRideDetailRides.sheet_ride_id')
                ),
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('SheetRide.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'rides',
                    'type' => 'left',
                    'alias' => 'Ride',
                    'conditions' => array('DetailRide.ride_id = Ride.id')
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
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Departure',
                    'conditions' => array('Departure.id = SheetRideDetailRides.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Arrival',
                    'conditions' => array('Arrival.id = SheetRideDetailRides.arrival_destination_id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('SheetRideDetailRides.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'SupplierFinal',
                    'conditions' => array('SheetRideDetailRides.supplier_final_id = SupplierFinal.id')
                ) ,

                array(
                    'table' => 'cancel_causes',
                    'type' => 'left',
                    'alias' => 'CancelCause',
                    'conditions' => array('SheetRideDetailRides.cancel_cause_id = CancelCause.id')
                ) ,
                array(
                    'table' => 'complaints',
                    'type' => 'left',
                    'alias' => 'Complaint',
                    'conditions' => array('SheetRideDetailRides.id = Complaint.sheet_ride_detail_ride_id')
                ) ,
                array(
                    'table' => 'observations',
                    'type' => 'left',
                    'alias' => 'Observation',
                    'conditions' => array('Observation.id = SheetRideDetailRides.observation_id')
                )  ,
                array(
                    'table' => 'complaints',
                    'type' => 'left',
                    'alias' => 'ComplaintObservation',
                    'conditions' => array('Observation.id = ComplaintObservation.observation_id')
                )  ,
            )
        ));

        return $sheetRideDetailRides;

    }

    /**
     * @param null $conditions
     * @return array|null
     * created : 21/03/2019
     */
    public function  getSheetRideDetailRidesByConditions ($conditions = null){


        $sheetRideDetailRides = $this->find('all', array(
            'order' => array('SheetRideDetailRides.supplier_id' => 'ASC',
                             'SheetRideDetailRides.type_ride' => 'ASC',
                             'SheetRide.car_type_id' => 'ASC',
                             'SheetRideDetailRides.departure_destination_id' => 'ASC',
                             'SheetRideDetailRides.arrival_destination_id' => 'ASC',
                             'SheetRideDetailRides.detail_ride_id' => 'ASC',
                ),
            'recursive' => -1,
            'conditions' => $conditions,
            'fields' => array(
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.sheet_ride_id',
                'SheetRideDetailRides.transport_bill_detail_ride_id',
                'SheetRideDetailRides.from_customer_order',
                'SheetRideDetailRides.type_ride',
                'SheetRideDetailRides.type_pricing',
                'SheetRideDetailRides.tonnage_id',
                'SheetRideDetailRides.supplier_id',
                'SheetRideDetailRides.supplier_final_id',
                'SheetRideDetailRides.return_mission',
                'SheetRideDetailRides.type_price',
                'SheetRideDetailRides.detail_ride_id',
                'SheetRideDetailRides.departure_destination_id',
                'SheetRideDetailRides.arrival_destination_id',
                'SheetRide.car_type_id',
                'SheetRideDetailRides.price',
                'SheetRideDetailRides.source',
                'SheetRideDetailRides.status_id',
                'SheetRideDetailRides.ride_category_id',
                'TransportBillDetailRides.id',
                'TransportBillDetailRides.unit_price',
                'TransportBillDetailRides.programming_date',
                'TransportBillDetailRides.charging_time',
                'TransportBillDetailRides.unloading_date',
                'TransportBillDetailRides.tva_id',
                'TransportBillDetailRides.ristourne_%',
                'TransportBillDetailRides.ristourne_val',
                'TransportBillDetailRides.designation',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Departure.name',
                'Arrival.name',
                'CarType.name',
                'Service.id',
                'Invoice.id',
            ),
            'joins' => array(
                array(
                    'table' => 'transport_bill_detail_rides',
                    'type' => 'left',
                    'alias' => 'TransportBillDetailRides',
                    'conditions' => array('SheetRideDetailRides.transport_bill_detail_ride_id = TransportBillDetailRides.id')
                ),
                array(
                    'table' => 'transport_bill_detail_rides',
                    'type' => 'left',
                    'alias' => 'InvoiceDetailRides',
                    'conditions' => array('SheetRideDetailRides.id = InvoiceDetailRides.sheet_ride_detail_ride_id')
                ),
                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'Invoice',
                    'conditions' => array('Invoice.id = InvoiceDetailRides.transport_bill_id')
                ),
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
                ),
                array(
                    'table' => 'rides',
                    'type' => 'left',
                    'alias' => 'Ride',
                    'conditions' => array('DetailRide.ride_id = Ride.id')
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
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('SheetRide.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Departure',
                    'conditions' => array('Departure.id = SheetRideDetailRides.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Arrival',
                    'conditions' => array('Arrival.id = SheetRideDetailRides.arrival_destination_id')
                ),
                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('TransportBill.id = TransportBillDetailRides.transport_bill_id')
                ),
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'User',
                    'conditions' => array('TransportBill.user_id = User.id')
                ),

                array(
                    'table' => 'services',
                    'type' => 'left',
                    'alias' => 'Service',
                    'conditions' => array('TransportBill.service_id = Service.id')
                ),
            ),

        ));
        return $sheetRideDetailRides;

    }

    /**
     * @param null $sheetRideDetailRideId
     * @return array|null
     * created : 20/03/2019
     */
    public function getSheetRideDetailRideById ($sheetRideDetailRideId = null){
        $sheetRideDetailRide = $this->find('first', array(

            'recursive' => -1, // should be used with joins
            'order' => array('SheetRideDetailRides.id' => 'ASC'),
            'conditions' => array('SheetRideDetailRides.id' => $sheetRideDetailRideId),
            'fields' => array(
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.order_mission',
                'SheetRideDetailRides.detail_ride_id',
                'SheetRideDetailRides.ride_category_id',
                'SheetRideDetailRides.transport_bill_detail_ride_id',
                'SheetRideDetailRides.observation_id',
                'SheetRideDetailRides.invoiced_ride',
                'SheetRideDetailRides.from_customer_order',
                'SheetRideDetailRides.truck_full',
                'SheetRideDetailRides.return_mission',
                'SheetRideDetailRides.type_price',
                'SheetRideDetailRides.planned_start_date',
                'SheetRideDetailRides.real_start_date',
                'SheetRideDetailRides.km_departure',
                'SheetRideDetailRides.planned_end_date',
                'SheetRideDetailRides.real_end_date',
                'SheetRideDetailRides.km_arrival_estimated',
                'SheetRideDetailRides.km_arrival',
                'SheetRideDetailRides.supplier_id',
                'SheetRideDetailRides.supplier_final_id',
                'SheetRideDetailRides.mission_cost',
                'SheetRideDetailRides.toll',
                'SheetRideDetailRides.remaining_time',
                'SheetRideDetailRides.departure_destination_id',
                'SheetRideDetailRides.arrival_destination_id',
                'SheetRideDetailRides.price',
                'SheetRideDetailRides.status_id',
                'SheetRideDetailRides.type_ride',
                'SheetRideDetailRides.source',
                'Supplier.id',
                'SupplierFinal.id',
                'SheetRideDetailRides.attachment1',
                'SheetRideDetailRides.attachment2',
                'SheetRideDetailRides.attachment3',
                'SheetRideDetailRides.attachment4',
                'SheetRideDetailRides.attachment5',
                'SheetRideDetailRides.note',
                'DetailRide.real_duration_hour',
                'DetailRide.real_duration_day',
                'DetailRide.real_duration_minute',
                'DetailRide.id',
                'Ride.distance',
                'DetailRides.real_duration_hour',
                'DetailRides.real_duration_day',
                'DetailRides.real_duration_minute',
                'DetailRides.id',
                'Rides.distance',
                'DepartureDestination.id',
                'DepartureDestination.name',
                'ArrivalDestination.id',
                'ArrivalDestination.name',
                'Departure.id',
                'Departure.name',
                'Arrival.id',
                'Arrival.name',
                'CarType.id',
                'RideCategory.id',
                'RideCategory.name',
                'SheetRide.id',
                'SheetRide.reference',
            ),
            'joins' => array(
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('SheetRideDetailRides.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'SupplierFinal',
                    'conditions' => array('SheetRideDetailRides.supplier_final_id = SupplierFinal.id')
                ),
                array(
                    'table' => 'rides',
                    'type' => 'left',
                    'alias' => 'Ride',
                    'conditions' => array('DetailRide.ride_id = Ride.id')
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
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Departure',
                    'conditions' => array('Departure.id = SheetRideDetailRides.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Arrival',
                    'conditions' => array('Arrival.id = SheetRideDetailRides.arrival_destination_id')
                ),
                array(
                    'table' => 'rides',
                    'type' => 'left',
                    'alias' => 'Rides',
                    'conditions' => array('Departure.id = Rides.departure_destination_id', 'Arrival.id = Rides.arrival_destination_id')
                ),
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRides',
                    'conditions' => array('Rides.id = DetailRides.ride_id')
                ),
                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('SheetRide.car_type_id = CarType.id')
                ),

                array(
                    'table' => 'ride_categories',
                    'type' => 'left',
                    'alias' => 'RideCategory',
                    'conditions' => array('SheetRideDetailRides.ride_category_id = RideCategory.id')
                ),
            )
        ));




        return $sheetRideDetailRide;

    }

/**
     * Get mission by foreign key
     *
     * @param int $id
     * @param string $modelField
     *
     * @return array $mission
     */
    public function getTransportBillByForeignKey($id, $modelField)
    {
        $mission = $this->find(
            'first',
            array(
                'conditions'=>array($modelField => $id),
                'fields' => array('SheetRideDetailRides.id'),
                'recursive'=>-1
            ));
        return $mission;
    }

    public function getSheetRideDetailRidesByTransportBillDetailRideId($transportBillDetailRideId= null){
        $sheetRideDetailRides = $this->find('all', array(
            'recursive' => -1, // should be used with joins
            'order' => array('SheetRideDetailRides.id' => 'ASC'),
            'conditions' => array('SheetRideDetailRides.transport_bill_detail_ride_id' => $transportBillDetailRideId),

        ));

        return $sheetRideDetailRides;
    }

    /**
     * Update sheet ride detail rides (missions) statuses
     *
     * @param int|null $sheet_ride_detail_ride_id
     * @param int|null $status
     */
    public function updateStatusSheetRideDetailRide($sheetRideDetailRideId = null, $status = null)
    {

        $this->id = $sheetRideDetailRideId;
        $this->saveField('status_id', $status);
    }

    public function updateNbComplaints($sheetRideDetailRideId = null, $nbComplaints = null)
    {

        $this->id = $sheetRideDetailRideId;
        $this->saveField('nb_complaints', $nbComplaints);
    }

    public function updateSlipIdField($sheetRideDetailRideIds= null, $slipId=null){
        foreach ($sheetRideDetailRideIds as $sheetRideDetailRideId){
            $this->id = $sheetRideDetailRideId;
            $this->saveField('slip_id', $slipId);

        }

    }
    public function getSheetRideDetailRidesBySlipId($slipId= null){
        $missions = $this->find('all',array(
            'conditions'=>array('SheetRideDetailRides.slip_id'=>$slipId),
            'fields'=>array(
                'SheetRideDetailRides.real_start_date',
                'SheetRideDetailRides.final_customer',
                'SheetRideDetailRides.note',
                'SheetRideDetailRides.number_delivery_note',
                'SheetRideDetailRides.number_invoice',
                'SheetRideDetailRides.type_ride',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Departure.name',
                'Arrival.name',
            ),
            'recursive'=>-1,
            'joins' => array(

                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
                ),

                array(
                    'table' => 'rides',
                    'type' => 'left',
                    'alias' => 'Ride',
                    'conditions' => array('DetailRide.ride_id = Ride.id')
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
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Departure',
                    'conditions' => array('Departure.id = SheetRideDetailRides.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Arrival',
                    'conditions' => array('Arrival.id = SheetRideDetailRides.arrival_destination_id')
                ),

            )
        ));
        return $missions;


}
    
}
