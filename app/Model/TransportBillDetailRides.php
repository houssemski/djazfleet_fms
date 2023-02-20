<?php



App::uses('AppModel', 'Model');

/**
 * OptionReservation Model
 *
 */
class TransportBillDetailRides extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'transport_bill_detail_rides';

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

            'transport_bill_id' => array(
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
               'nb_trucks' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
               'unit_price' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
          

            'price_ht' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
            'tva_id' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),

            'price_ttc' => array(
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

	public $validatePersonalizedRide = array(


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

            'transport_bill_id' => array(
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

		'car_type_id' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),

		/*'arrival_destination_id' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*/
               'nb_trucks' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
               'unit_price' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),


            'price_ht' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
            'tva_id' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),

            'price_ttc' => array(
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
	public $validateProvision = array(


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

            'transport_bill_id' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),


		'car_type_id' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'start_date' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),

		/*'arrival_destination_id' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*/
               'nb_trucks' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
               'unit_price' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),


            'price_ht' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
            'tva_id' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),

            'price_ttc' => array(
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
	public $validateLocation = array(


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

            'transport_bill_id' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),


		'car_id' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),


		/*'arrival_destination_id' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*/
               'nb_trucks' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
               'unit_price' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),


            'price_ht' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
            'tva_id' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),

            'price_ttc' => array(
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


	public $validateProduct = array(


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

            'transport_bill_id' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),

               'nb_trucks' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
               'unit_price' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),


            'price_ht' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
            'tva_id' => array(
			    'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),

            'price_ttc' => array(
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

   public $belongsTo = array(
        'DetailRide' => array(
            'className' => 'DetailRide',
            'foreignKey' => 'detail_ride_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'TransportBill' => array(
            'className' => 'TransportBill',
            'foreignKey' => 'transport_bill_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'SheetRideDetailRides' => array(
            'className' => 'SheetRideDetailRides',
            'foreignKey' => 'sheet_ride_detail_ride_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

	/** get all transport bill detail rides with is_open = 1
	 * @return array|null
	 */
	public function getAllOpenedTransportBillDetailRides(){
		$transportBillDetailRides = $this->find('all', array(
			'recursive'=>-1,
			'conditions'=>array('is_open'=>1),
			'fields'=>array('id')
		));
		return $transportBillDetailRides;
	}

	/**
	 * @param null $transportBillId
	 * @return array|null
	 */
	public function getTransportBillDetailRidesByTransportBillId ($transportBillId = null){


        $transportBillDetailRides = $this->find('all', array(
            'conditions' => array('TransportBillDetailRides.transport_bill_id' => $transportBillId),
            'recursive' => -1,
            'order' => 'TransportBillDetailRides.programming_date asc',
            'Group' => 'TransportBillDetailRides.id',
            'fields' => array(
                'TransportBillDetailRides.id',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'CarType.name',
                'Departure.name',
                'Arrival.name',
                'Type.name',
                'Product.name',
                'Product.id',
                'Product.code',
                'TransportBillDetailRides.designation',
                'TransportBillDetailRides.description',
                'TransportBillDetailRides.unit_price',
                'TransportBillDetailRides.type_ride',
                'TransportBillDetailRides.price_ht',
                'TransportBillDetailRides.price_ttc',
                'TransportBillDetailRides.nb_trucks',
                'TransportBillDetailRides.ristourne_%',
                'TransportBillDetailRides.ristourne_val',
                'TransportBillDetailRides.delivery_with_return',
                'TransportBillDetailRides.programming_date',
                'TransportBillDetailRides.marchandise_unit_id',
                'MarchandiseUnits.name',
                'SheetRideDetailRides.real_start_date',
                'SheetRideDetailRides.real_end_date','Tva.name'
            ),
            'joins' => array(
                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('TransportBillDetailRides.transport_bill_id = TransportBill.id')
                ),
                array(
                    'table' => 'sheet_ride_detail_rides',
                    'type' => 'left',
                    'alias' => 'SheetRideDetailRides',
                    'conditions' => array('TransportBillDetailRides.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
                ),
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('TransportBillDetailRides.detail_ride_id = DetailRide.id')
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
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Departure',
                    'conditions' => array('Departure.id = TransportBillDetailRides.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Arrival',
                    'conditions' => array('Arrival.id = TransportBillDetailRides.arrival_destination_id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'Type',
                    'conditions' => array('TransportBillDetailRides.car_type_id = Type.id')
                ),
                array(
                    'table' => 'lots',
                    'type' => 'left',
                    'alias' => 'Lot',
                    'conditions' => array('TransportBillDetailRides.lot_id = Lot.id')
                ),
                array(
                    'table' => 'products',
                    'type' => 'left',
                    'alias' => 'Product',
                    'conditions' => array('Lot.product_id = Product.id')
                ),
                array(
                    'table' => 'tva',
                    'type' => 'left',
                    'alias' => 'Tva',
                    'conditions' => array('TransportBillDetailRides.tva_id = Tva.id')
                ),
                array(
                    'table' => 'marchandise_units',
                    'type' => 'left',
                    'alias' => 'MarchandiseUnits',
                    'conditions' => array('TransportBillDetailRides.marchandise_unit_id = MarchandiseUnits.id')
                ),
            )
        ));
		return $transportBillDetailRides;
	}

	public function getTransportBillDetailRidesByLotId($lotId = null){
		$transportBillDetailRides = $this->find(
			'first',
			array(
				'conditions' => array('TransportBillDetailRides.lot_id' => $lotId),
				'fields' => array('TransportBillDetailRides.id'),
				'recursive' => -1
			)
		);
		return $transportBillDetailRides;
	}

	/**
	 * @param null $transportBillId
	 * @return array|null
	 */
	public function geDetailedTBDRByTransportBillId ($transportBillId = null){
		$transportBillDetailRides = $this->find('all', array(
			'order' => 'TransportBillDetailRides.id ASC',
			'recursive' => -1,
			'fields' => array(
				'TransportBillDetailRides.id',
				'TransportBillDetailRides.type_ride',
				'TransportBillDetailRides.designation',
				'TransportBillDetailRides.description',
				'TransportBillDetailRides.observation_order',
				'TransportBillDetailRides.type_pricing',
				'TransportBillDetailRides.tonnage_id',
				'TransportBillDetailRides.reference',
				'TransportBillDetailRides.unit_price',
				'TransportBillDetailRides.delivery_with_return',
				'TransportBillDetailRides.ride_category_id',
				'TransportBillDetailRides.status_id',
				'TransportBillDetailRides.approved',
				'TransportBillDetailRides.nb_trucks',
				'TransportBillDetailRides.price_ht',
				'TransportBillDetailRides.type_price',
				'TransportBillDetailRides.price_ttc',
				'TransportBillDetailRides.tva_id',
				'TransportBillDetailRides.ristourne_%',
				'TransportBillDetailRides.ristourne_val',
				'TransportBillDetailRides.detail_ride_id',
				'TransportBillDetailRides.supplier_final_id',
				'TransportBillDetailRides.id',
				'TransportBillDetailRides.start_date',
				'TransportBillDetailRides.end_date',
				'TransportBillDetailRides.nb_hours',
				'TransportBillDetailRides.car_id',
				'TransportBillDetailRides.programming_date',
				'TransportBillDetailRides.charging_time',
				'TransportBillDetailRides.unloading_date',
				'TransportBillDetailRides.marchandise_unit_id',
				'SheetRideDetailRides.id',
				'SheetRideDetailRides.reference',
				'DetailRide.id',
				'Departure.id',
				'Departure.name',
				'Arrival.id',
				'Arrival.name',
				'Type.id',
				'Type.name',
				'DepartureDestination.id',
				'DepartureDestination.name',
				'ArrivalDestination.id',
				'ArrivalDestination.name',
				'CarType.id',
				'CarType.name',
				'TransportBillDetailRides.lot_id',
				'Product.name',
				'Product.car_required',
				'Product.nb_hours_required',
				'ProductType.id',
				'ProductType.relation_with_park',
			),
			'conditions' => array('TransportBillDetailRides.transport_bill_id' => $transportBillId),
			'joins' => array(
				array(
					'table' => 'detail_rides',
					'type' => 'left',
					'alias' => 'DetailRide',
					'conditions' => array('TransportBillDetailRides.detail_ride_id = DetailRide.id')
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
					'table' => 'suppliers',
					'type' => 'left',
					'alias' => 'SupplierFinal',
					'conditions' => array('TransportBillDetailRides.supplier_final_id = SupplierFinal.id')
				),
				array(
					'table' => 'ride_categories',
					'type' => 'left',
					'alias' => 'RideCategory',
					'conditions' => array('TransportBillDetailRides.ride_category_id = RideCategory.id')
				),
				array(
					'table' => 'sheet_ride_detail_rides',
					'type' => 'left',
					'alias' => 'SheetRideDetailRides',
					'conditions' => array('TransportBillDetailRides.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
				),
				array(
					'table' => 'destinations',
					'type' => 'left',
					'alias' => 'Departure',
					'conditions' => array('Departure.id = TransportBillDetailRides.departure_destination_id')
				),
				array(
					'table' => 'destinations',
					'type' => 'left',
					'alias' => 'Arrival',
					'conditions' => array('Arrival.id = TransportBillDetailRides.arrival_destination_id')
				),
				array(
					'table' => 'car_types',
					'type' => 'left',
					'alias' => 'Type',
					'conditions' => array('TransportBillDetailRides.car_type_id = Type.id')
				),
				array(
					'table' => 'lots',
					'type' => 'left',
					'alias' => 'Lot',
					'conditions' => array('TransportBillDetailRides.lot_id = Lot.id')
				),
				array(
					'table' => 'products',
					'type' => 'left',
					'alias' => 'Product',
					'conditions' => array('Lot.product_id = Product.id')
				),
                array(
					'table' => 'product_types',
					'type' => 'left',
					'alias' => 'ProductType',
					'conditions' => array('ProductType.id = Product.product_type_id')
				),
			)
		));
		return $transportBillDetailRides;
	}

    /**
     * @param null $conditions
     * @return array|null
     */
	public function geDetailedTBDRByConditions ($conditions = null){
		$transportBillDetailRides = $this->find('all', array(
			'order' => 'TransportBillDetailRides.id ASC',
			'recursive' => -1,
			'fields' => array(
				'TransportBillDetailRides.type_ride',
				'TransportBillDetailRides.designation',
				'TransportBillDetailRides.description',
				'TransportBillDetailRides.type_pricing',
				'TransportBillDetailRides.tonnage_id',
				'TransportBillDetailRides.reference',
				'TransportBillDetailRides.unit_price',
				'TransportBillDetailRides.delivery_with_return',
				'TransportBillDetailRides.ride_category_id',
				'TransportBillDetailRides.status_id',
				'TransportBillDetailRides.approved',
				'TransportBillDetailRides.nb_trucks',
				'TransportBillDetailRides.price_ht',
				'TransportBillDetailRides.type_price',
				'TransportBillDetailRides.price_ttc',
				'TransportBillDetailRides.tva_id',
				'TransportBillDetailRides.ristourne_%',
				'TransportBillDetailRides.ristourne_val',
				'TransportBillDetailRides.detail_ride_id',
				'TransportBillDetailRides.supplier_final_id',
				'TransportBillDetailRides.id',
				'SheetRideDetailRides.id',
				'SheetRideDetailRides.reference',
				'DetailRide.id',
				'Departure.id',
				'Arrival.id',
				'Type.id',
				'TransportBillDetailRides.lot_id',
				'Product.name',
				'ProductType.id',
			),
			'conditions' => $conditions,
			'joins' => array(
				array(
					'table' => 'detail_rides',
					'type' => 'left',
					'alias' => 'DetailRide',
					'conditions' => array('TransportBillDetailRides.detail_ride_id = DetailRide.id')
				),
				array(
					'table' => 'suppliers',
					'type' => 'left',
					'alias' => 'SupplierFinal',
					'conditions' => array('TransportBillDetailRides.supplier_final_id = SupplierFinal.id')
				),
				array(
					'table' => 'ride_categories',
					'type' => 'left',
					'alias' => 'RideCategory',
					'conditions' => array('TransportBillDetailRides.ride_category_id = RideCategory.id')
				),
				array(
					'table' => 'sheet_ride_detail_rides',
					'type' => 'left',
					'alias' => 'SheetRideDetailRides',
					'conditions' => array('TransportBillDetailRides.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
				),
				array(
					'table' => 'destinations',
					'type' => 'left',
					'alias' => 'Departure',
					'conditions' => array('Departure.id = TransportBillDetailRides.departure_destination_id')
				),
				array(
					'table' => 'destinations',
					'type' => 'left',
					'alias' => 'Arrival',
					'conditions' => array('Arrival.id = TransportBillDetailRides.arrival_destination_id')
				),
				array(
					'table' => 'car_types',
					'type' => 'left',
					'alias' => 'Type',
					'conditions' => array('TransportBillDetailRides.car_type_id = Type.id')
				),
				array(
					'table' => 'lots',
					'type' => 'left',
					'alias' => 'Lot',
					'conditions' => array('TransportBillDetailRides.lot_id = Lot.id')
				),
				array(
					'table' => 'products',
					'type' => 'left',
					'alias' => 'Product',
					'conditions' => array('Lot.product_id = Product.id')
				),
                array(
					'table' => 'product_types',
					'type' => 'left',
					'alias' => 'ProductType',
					'conditions' => array('ProductType.id = Product.product_type_id')
				),
			)
		));
		return $transportBillDetailRides;
	}

	public function getTransportBillDetailRidesById($transportBillDetailRideId){
		$transportBillDetailRide =  $this->find('first',
			array(
				'recursive' => -1,
				'fields' => array('TransportBillDetailRides.id',
				'TransportBillDetailRides.type_ride',
				'TransportBillDetailRides.detail_ride_id',
				'TransportBillDetailRides.departure_destination_id',
				'TransportBillDetailRides.arrival_destination_id',
				'TransportBillDetailRides.car_type_id',
				'TransportBillDetailRides.delivery_with_return',
				'TransportBillDetailRides.type_price',
				'TransportBillDetailRides.ride_category_id',
				'TransportBillDetailRides.nb_trucks',
				'TransportBillDetailRides.nb_trucks_validated',
				'TransportBill.supplier_id',
				'TransportBillDetailRides.supplier_final_id',
				'TransportBill.id',
				),
				'conditions' => array(
					'TransportBillDetailRides.id' => $transportBillDetailRideId
				),
				'joins' => array(
					array(
						'table' => 'transport_bills',
						'type' => 'left',
						'alias' => 'TransportBill',
						'conditions' => array('TransportBill.id = TransportBillDetailRides.transport_bill_id')
					),
				)
			));
		return $transportBillDetailRide;
	}

    /**
     * @param $sheetRideDetailRideId
     * @return array|null
     * created : 20/03/2019
     */
	public function getTransportBillDetailRideBySheetRideDetailRideId($sheetRideDetailRideId){
        $transportBillDetailRide =  $this->find('first',
            array(
                'recursive' => -1,
                'fields' => array('TransportBillDetailRides.id',
                    'TransportBillDetailRides.type_ride',
                    'TransportBillDetailRides.detail_ride_id',
                    'TransportBillDetailRides.departure_destination_id',
                    'TransportBillDetailRides.arrival_destination_id',
                    'TransportBillDetailRides.car_type_id',
                    'TransportBillDetailRides.delivery_with_return',
                    'TransportBillDetailRides.type_price',
                    'TransportBillDetailRides.ride_category_id',
                    'TransportBillDetailRides.nb_trucks',
                ),
                'conditions' => array(
                    'SheetRideDetailRides.id' => $sheetRideDetailRideId
                ),
                'joins' => array(
                    array(
                        'table' => 'sheet_ride_detail_rides',
                        'type' => 'left',
                        'alias' => 'SheetRideDetailRides',
                        'conditions' => array('SheetRideDetailRides.transport_bill_detail_ride_id = TransportBillDetailRides.id')
                    ),
                )
            ));
        return $transportBillDetailRide;
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

    public function updateStatusTransportBillDetailRide($transportBillDetailRideId)
    {

        $nb_trucks_validated = $this->SheetRideDetailRides->find('count',
            array('conditions' => array('SheetRideDetailRides.transport_bill_detail_ride_id' => $transportBillDetailRideId)));

        $transportBillDetailRide = $this->find('first', array(
            'conditions' => array('TransportBillDetailRides.id' => $transportBillDetailRideId),
            'fields' => array('nb_trucks', 'transport_bill_id'),
            'recursive' => -1
        ));

        if (!empty($transportBillDetailRide)) {
            $transportBillId = $transportBillDetailRide['TransportBillDetailRides']['transport_bill_id'];
            $nb_trucks = $transportBillDetailRide['TransportBillDetailRides']['nb_trucks'];
            if ($nb_trucks_validated == 0) {
                $this->id = $transportBillDetailRideId;
                $this->saveField('nb_trucks_validated', $nb_trucks_validated);
                $this->saveField('status_id', 1);
                $this->saveField('is_open', 0);

            } elseif (($nb_trucks_validated > 0) && ($nb_trucks > $nb_trucks_validated)) {

                $this->id = $transportBillDetailRideId;
                $this->saveField('nb_trucks_validated', $nb_trucks_validated);
                $this->saveField('status_id', 2);
                $this->saveField('is_open', 0);
            } elseif ($nb_trucks == $nb_trucks_validated) {
                $this->id = $transportBillDetailRideId;
                $this->saveField('nb_trucks_validated', $nb_trucks_validated);
                $this->saveField('status_id', 3);
                $this->saveField('is_open', 0);
            }
            $this->updateStatusCustomerOrder($transportBillId);
        }

    }

    /**
     * @param null $sheetRideDetailRide
     * @param null $transportBillDetailRide
     * @throws Exception
     * created : 20/03/2019
     */
    public function updateTransportBillDetailRideInformations($sheetRideDetailRide = null, $transportBillDetailRide = null)
    {
        $data['TransportBillDetailRides']['id'] = $transportBillDetailRide['TransportBillDetailRides']['id'];
        if ($sheetRideDetailRide['SheetRideDetailRides']['type_ride'] == 2) {
            $this->validate = $this->validatePersonalizedRide;
            $data['TransportBillDetailRides']['departure_destination_id'] = $sheetRideDetailRide['SheetRideDetailRides']['departure_destination_id'];
            $data['TransportBillDetailRides']['arrival_destination_id'] = $sheetRideDetailRide['SheetRideDetailRides']['arrival_destination_id'];
        } else {
            $data['TransportBillDetailRides']['detail_ride_id'] = $sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'];
        }
        $data['TransportBillDetailRides']['supplier_final_id'] = $sheetRideDetailRide['SheetRideDetailRides']['supplier_final_id'];

        $this->save($data);


    }

    public function updateStatusCustomerOrder($transportBillId)
    {
        $transportBillDetailRides = $this->find('all', array(
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
        $this->TransportBill->id = $transportBillId;
        $this->TransportBill->saveField('status', $status);

    }


}

