<?php

App::uses('AppModel', 'Model');

/**
 *
 *
 * @property Car $Car
 */
class SheetRide extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */


    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'reference' => array(
            'unique' => array(
                'rule' => 'isUnique',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
            ),
        ),

        'car_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'customer_id' => array(
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
    public $validateSubcontractingRequired = array(

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
        'car_name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'customer_name' => array(
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
    public $validateSubcontracting = array(

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



    );
    public $validate_transformation = array(
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
            'foreignKey' => 'car_id'
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
        'Customer' => array(
            'className' => 'Customer',
            'foreignKey' => 'customer_id'
        ),


    );
    public $hasMany = array(

        'SheetRideDetailRide' => array(
            'className' => 'SheetRideDetailRide',
            'foreignKey' => 'sheet_ride_id',
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
    public function getSumCost($conditions = null)
    {
        $sumCost = 0;
        if ($conditions != null) {
            $consumptions = $this->find('all', array(
                'conditions' => $conditions,
                'paramType' => 'querystring',
                'recursive' => -1, // should be used with joins
                'fields' => array('cost'),
                'group'=>array('SheetRide.id'),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('SheetRide.car_id = Car.id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'CarType',
                        'conditions' => array('SheetRide.car_type_id = CarType.id')
                    ),
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('SheetRide.customer_id = Customer.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),
                    array(
                        'table' => 'sheet_ride_detail_rides',
                        'type' => 'left',
                        'alias' => 'SheetRideDetailRides',
                        'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                    ),
                    array(
                        'table' => 'attachments',
                        'type' => 'left',
                        'alias' => 'Attachment',
                        'conditions' => array('Attachment.article_id = SheetRideDetailRides.id')
                    ),
                    array(
                        'table' => 'bills',
                        'type' => 'left',
                        'alias' => 'Bill',
                        'conditions' => array('Bill.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
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
                        'conditions' => array('Lot.id = BillProduct.lot_id')
                    ),
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
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('SheetRide.user_id = User.id')
                    )

                )

            ));


            foreach ($consumptions as $consumption) {
                $sumCost = $sumCost + $consumption['SheetRide']['cost'];
            }
        } else {
            $consumptions = $this->query("SELECT cost FROM sheet_rides");
            foreach ($consumptions as $consumption) {
                $sumCost = $sumCost + $consumption['sheet_rides']['cost'];
            }
        }
        return $sumCost;
    }


    public function getSumConsumption($conditions = null)
    {
        $sumConsumption = 0;
        if ($conditions != null) {
            $consumptions = $this->find('all',
                array(
                    'conditions' => $conditions,
                    'paramType' => 'querystring',
                    'recursive' => -1, // should be used with joins
                    'fields' => array(
                        'km_liter'
                    ),
                    'group'=>array('SheetRide.id'),
                    'joins' => array(
                        array(
                            'table' => 'car',
                            'type' => 'left',
                            'alias' => 'Car',
                            'conditions' => array('SheetRide.car_id = Car.id')
                        ),
                        array(
                            'table' => 'car_types',
                            'type' => 'left',
                            'alias' => 'CarType',
                            'conditions' => array('SheetRide.car_type_id = CarType.id')
                        ),
                        array(
                            'table' => 'customers',
                            'type' => 'left',
                            'alias' => 'Customer',
                            'conditions' => array('SheetRide.customer_id = Customer.id')
                        ),
                        array(
                            'table' => 'carmodels',
                            'type' => 'left',
                            'alias' => 'Carmodel',
                            'conditions' => array('Car.carmodel_id = Carmodel.id')
                        ),
                        array(
                            'table' => 'sheet_ride_detail_rides',
                            'type' => 'left',
                            'alias' => 'SheetRideDetailRides',
                            'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                        ),
                        array(
                            'table' => 'attachments',
                            'type' => 'left',
                            'alias' => 'Attachment',
                            'conditions' => array('Attachment.article_id = SheetRideDetailRides.id')
                        ),
                        array(
                            'table' => 'bills',
                            'type' => 'left',
                            'alias' => 'Bill',
                            'conditions' => array('Bill.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
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
                            'conditions' => array('Lot.id = BillProduct.lot_id')
                        ),
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
                            'table' => 'users',
                            'type' => 'left',
                            'alias' => 'User',
                            'conditions' => array('SheetRide.user_id = User.id')
                        )
                    )
                ));
            foreach ($consumptions as $consumption) {
                $sumConsumption = $sumConsumption + $consumption['SheetRide']['km_liter'];
            }
        } else {
            $consumptions = $this->query("SELECT km_liter FROM sheet_rides");
            foreach ($consumptions as $consumption) {
                $sumConsumption = $sumConsumption + $consumption['sheet_rides']['km_liter'];
            }
        }
        return $sumConsumption;
    }

    public function getSumKm($conditions = null)
    {
        $sumKm = 0;
        if ($conditions != null) {
            $consumptions = $this->find('all',
                array(
                    'conditions' => $conditions,
                    'paramType' => 'querystring',
                    'recursive' => -1,
                    'fields' => array('km_arrival', 'km_departure'),
                    'group'=>array('SheetRide.id'),
                    'joins' => array(
                        array(
                            'table' => 'car',
                            'type' => 'left',
                            'alias' => 'Car',
                            'conditions' => array('SheetRide.car_id = Car.id')
                        ),
                        array(
                            'table' => 'car_types',
                            'type' => 'left',
                            'alias' => 'CarType',
                            'conditions' => array('SheetRide.car_type_id = CarType.id')
                        ),
                        array(
                            'table' => 'customers',
                            'type' => 'left',
                            'alias' => 'Customer',
                            'conditions' => array('SheetRide.customer_id = Customer.id')
                        ),
                        array(
                            'table' => 'carmodels',
                            'type' => 'left',
                            'alias' => 'Carmodel',
                            'conditions' => array('Car.carmodel_id = Carmodel.id')
                        ),
                        array(
                            'table' => 'sheet_ride_detail_rides',
                            'type' => 'left',
                            'alias' => 'SheetRideDetailRides',
                            'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                        ),
                        array(
                            'table' => 'attachments',
                            'type' => 'left',
                            'alias' => 'Attachment',
                            'conditions' => array('Attachment.article_id = SheetRideDetailRides.id')
                        ),
                        array(
                            'table' => 'bills',
                            'type' => 'left',
                            'alias' => 'Bill',
                            'conditions' => array('Bill.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
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
                            'conditions' => array('Lot.id = BillProduct.lot_id')
                        ),
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
                            'table' => 'users',
                            'type' => 'left',
                            'alias' => 'User',
                            'conditions' => array('SheetRide.user_id = User.id')
                        )

                    )
                ));
            foreach ($consumptions as $consumption) {
                if (($consumption['SheetRide']['km_departure'] != null) && ($consumption['SheetRide']['km_arrival'] != null)) {
                    $sumKm = $sumKm + ($consumption['SheetRide']['km_arrival'] - $consumption['SheetRide']['km_departure']);
                }
            }
        } else {
            $consumptions = $this->query("SELECT km_departure, km_arrival FROM sheet_rides");
            foreach ($consumptions as $consumption) {
                if (($consumption['sheet_rides']['km_departure'] != null) && ($consumption['sheet_rides']['km_arrival'] != null)) {
                    $sumKm = $sumKm + ($consumption['sheet_rides']['km_arrival'] - $consumption['sheet_rides']['km_departure']);
                }
            }

        }

        return $sumKm;
    }
    public function getSumCostClient($conditions = null)
    {
        $sumCostClient = 0;
            $sheetRides = $this->find('all',
                array(
                    'conditions' => $conditions,
                    'paramType' => 'querystring',
                    'recursive' => -1,
                    'fields' => array('TransportBillDetailRides.unit_price'),
                    'group'=>array('SheetRide.id'),
                    'joins' => array(
                        array(
                            'table' => 'car',
                            'type' => 'left',
                            'alias' => 'Car',
                            'conditions' => array('SheetRide.car_id = Car.id')
                        ),
                        array(
                            'table' => 'car_types',
                            'type' => 'left',
                            'alias' => 'CarType',
                            'conditions' => array('SheetRide.car_type_id = CarType.id')
                        ),
                        array(
                            'table' => 'customers',
                            'type' => 'left',
                            'alias' => 'Customer',
                            'conditions' => array('SheetRide.customer_id = Customer.id')
                        ),
                        array(
                            'table' => 'carmodels',
                            'type' => 'left',
                            'alias' => 'Carmodel',
                            'conditions' => array('Car.carmodel_id = Carmodel.id')
                        ),
                        array(
                            'table' => 'sheet_ride_detail_rides',
                            'type' => 'left',
                            'alias' => 'SheetRideDetailRides',
                            'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                        ),
                        array(
                            'table' => 'transport_bill_detail_rides',
                            'type' => 'left',
                            'alias' => 'TransportBillDetailRides',
                            'conditions' => array('SheetRideDetailRides.transport_bill_detail_ride_id = TransportBillDetailRides.id')
                        ),
                        array(
                            'table' => 'attachments',
                            'type' => 'left',
                            'alias' => 'Attachment',
                            'conditions' => array('Attachment.article_id = SheetRideDetailRides.id')
                        ),
                        array(
                            'table' => 'bills',
                            'type' => 'left',
                            'alias' => 'Bill',
                            'conditions' => array('Bill.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
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
                            'conditions' => array('Lot.id = BillProduct.lot_id')
                        ),
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
                            'table' => 'users',
                            'type' => 'left',
                            'alias' => 'User',
                            'conditions' => array('SheetRide.user_id = User.id')
                        )
                    )
                ));
            foreach ($sheetRides as $sheetRide) {
                    $sumCostClient = $sumCostClient + $sheetRide['TransportBillDetailRides']['unit_price'] ;
            }
        return $sumCostClient;
    }
    public function getSumCostSupplier($conditions = null)
    {
        $sumCostSupplier = 0;
            $sheetRides = $this->find('all',
                array(
                    'conditions' => $conditions,
                    'paramType' => 'querystring',
                    'recursive' => -1,
                    'fields' => array('Reservation.cost'),
                    'group'=>array('SheetRide.id'),
                    'joins' => array(
                        array(
                            'table' => 'car',
                            'type' => 'left',
                            'alias' => 'Car',
                            'conditions' => array('SheetRide.car_id = Car.id')
                        ),
                        array(
                            'table' => 'car_types',
                            'type' => 'left',
                            'alias' => 'CarType',
                            'conditions' => array('SheetRide.car_type_id = CarType.id')
                        ),
                        array(
                            'table' => 'customers',
                            'type' => 'left',
                            'alias' => 'Customer',
                            'conditions' => array('SheetRide.customer_id = Customer.id')
                        ),
                        array(
                            'table' => 'carmodels',
                            'type' => 'left',
                            'alias' => 'Carmodel',
                            'conditions' => array('Car.carmodel_id = Carmodel.id')
                        ),
                        array(
                            'table' => 'sheet_ride_detail_rides',
                            'type' => 'left',
                            'alias' => 'SheetRideDetailRides',
                            'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                        ),
                        array(
                            'table' => 'reservations',
                            'type' => 'left',
                            'alias' => 'Reservation',
                            'conditions' => array('SheetRideDetailRides.id = Reservation.sheet_ride_detail_ride_id')
                        ),
                        array(
                            'table' => 'attachments',
                            'type' => 'left',
                            'alias' => 'Attachment',
                            'conditions' => array('Attachment.article_id = SheetRideDetailRides.id')
                        ),
                        array(
                            'table' => 'bills',
                            'type' => 'left',
                            'alias' => 'Bill',
                            'conditions' => array('Bill.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
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
                            'conditions' => array('Lot.id = BillProduct.lot_id')
                        ),
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
                            'table' => 'users',
                            'type' => 'left',
                            'alias' => 'User',
                            'conditions' => array('SheetRide.user_id = User.id')
                        )

                    )
                ));
            foreach ($sheetRides as $sheetRide) {
                $sumCostSupplier = $sumCostSupplier + $sheetRide['Reservation']['cost'] ;
            }
        return $sumCostSupplier;
    }


    public function getSumCoupon($conditions = null)
    {
        $sumCoupon = 0;
        if ($conditions != null) {
            $consumptions = $this->find('all', array(
                'conditions' => $conditions,
                'paramType' => 'querystring',
                'recursive' => -1,
                'fields' => array('coupons_number', 'Car.parc_id'),
                'group' => ('SheetRide.id'),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('SheetRide.car_id = Car.id')
                    ),
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('SheetRide.customer_id = Customer.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),
                    array(
                        'table' => 'coupons',
                        'type' => 'left',
                        'alias' => 'Coupon',
                        'conditions' => array('SheetRide.id = Coupon.sheet_ride_id')
                    ),
                    array(
                        'table' => 'parcs',
                        'type' => 'left',
                        'alias' => 'Parc',
                        'conditions' => array('Car.parc_id = Parc.id')
                    ),
                    array(
                        'table' => 'customer_groups',
                        'type' => 'left',
                        'alias' => 'CustomerGroup',
                        'conditions' => array('Customer.customer_group_id = CustomerGroup.id')
                    )


                )
            ));
            foreach ($consumptions as $consumption) {
                if (($consumption['SheetRide']['coupons_number'] != null)) {
                    $sumCoupon = $sumCoupon + $consumption['SheetRide']['coupons_number'];
                }
            }
        } else {
            $consumptions = $this->query("SELECT coupons_number FROM sheet_rides");
            foreach ($consumptions as $consumption) {
                if (($consumption['sheet_rides']['coupons_number'] != null)) {
                    $sumCoupon = $sumCoupon + $consumption['consumption']['coupons_number'];
                }
            }

        }

        return $sumCoupon;
    }


    public function getConsumptionAlerts($limitedConsumption = null, $carId = null )
    {


        if ($limitedConsumption != null) {


                $query = "select month(real_end_date) as Month,(max(km_arrival)-min(km_departure)) as diffKm, SheetRide.car_id, Car.km, Carmodel.name, Car.code,Car.send_mail "
                    . " From Sheet_rides as SheetRide "
                    . " LEFT JOIN car as Car ON (SheetRide.car_id = Car.id) "
                    . " LEFT JOIN carmodels AS Carmodel ON (Carmodel.id = Car.carmodel_id) "
                    . " WHERE month()= moreal_end_datenth(now()) && year(real_end_date)= year(now()) && Car.alert != 2 ";
                     if($carId != null){
                         $query.= " AND Car.id = ".(int) $carId;
                     }
                $query.=  " group by car_id, month(real_end_date) "
                    . " having diffKm >= " . $limitedConsumption;


                return $this->query($query);



        } else {


                $query = "select month(real_end_date) as Month,(max(km_arrival)-min(km_departure)) as diffKm, SheetRide.car_id, Car.km,Car.limit_consumption, Carmodel.name, Car.code,Car.send_mail "
                    . " From sheet_rides as SheetRide "
                    . " LEFT JOIN car as Car ON (SheetRide.car_id = Car.id) "
                    . " LEFT JOIN carmodels AS Carmodel ON (Carmodel.id = Car.carmodel_id) "
                    . " WHERE month(real_end_date)= month(now()) && year(real_end_date)= year(now()) && Car.alert != 2 && Car.limit_consumption IS NOT NULL " ;
            if($carId != null){
                $query.= " AND Car.id = ".(int) $carId;
            }
            $query.=  " group by car_id, month(real_end_date), Car.limit_consumption "
                    . " having diffKm >= Car.limit_consumption";


                return $this->query($query);



        }
    }

    public function getConsumptionAlertbyCar()
    {

        $query = "select month(real_end_date) as Month,(max(km_arrival)-min(km_departure)) as diffKm, SheetRide.car_id, Car.id, Car.km, Car.limit_consumption, Carmodel.name, Car.code, Car.send_mail "
            . " From sheet_rides as SheetRide "
            . " LEFT JOIN car as Car ON (SheetRide.car_id = Car.id) "
            . " LEFT JOIN carmodels AS Carmodel ON (Carmodel.id = Car.carmodel_id) "
            . " WHERE month(real_end_date)= month(now()) && year(real_end_date)= year(now()) && Car.alert != 2 "
            . " group by car_id, month(real_end_date), Car.limit_consumption "
            . " having diffKm >= Car.limit_consumption";


        return $this->query($query);
    }

    /**
     * Get
     * @param null $carId
     * @return array $activatedAlertCars
     */
    public function getCarsWithCouponConsumptionAlerts($carId = null)
    {



        $query = "select month(real_end_date) as Month,SUM(coupons_number) as nb_coupons, SheetRide.car_id, Car.id,  Carmodel.name, Car.code,Car.send_mail, Car.coupon_consumption "
            . " From sheet_rides as SheetRide "
            . " LEFT JOIN car as Car ON (SheetRide.car_id = Car.id) "
            . " LEFT JOIN carmodels AS Carmodel ON (Carmodel.id = Car.carmodel_id) "
            . " WHERE month(real_end_date)= month(now()) && year(real_end_date)= year(now()) && Car.alert != 2 ";
        if (!empty($carId)) {
            $query .= "&& Car.id = " . $carId;
        }
        $query .= " group by car_id, month(real_end_date), Car.coupon_consumption "
            . " having nb_coupons >= Car.coupon_consumption";

        $activatedAlertCars = $this->query($query);

        return $activatedAlertCars;

    }

    public function getMinCouponAlert($minCoupon = null)
    {

        $query = "select SUM(coupons_number) as nb_coupons  "
            . " From sheet_rides as SheetRide "
            . " having nb_coupons >= " . $minCoupon;

        return $this->query($query);

    }

    public function getAllOpenedSheetRides()
    {
        $sheetRides = $this->find('all', array(
            'recursive' => -1,
            'conditions' => array('is_open' => 1),
            'fields' => array('id')
        ));
        return $sheetRides;
    }

    /**
     * Get sheet rides by cars
     *
     * @param int $carId
     *
     * @return array|null
     */
    public function getSheetRidesByCar($carId)
    {
        $sheetRides = $this->find(
            'all',
            array(
                'recursive' => -1,
                'conditions' => array("SheetRide.car_id =" => $carId),
                'fields' => array('id')
            ));
        return $sheetRides;
    }

    public function  getSheetRidesByConditions ($conditions = null){
        $sheetRides = $this->find('all', array(
            'recursive' => -1, // should be used with joins
            'order' => array('SheetRide.id' => 'ASC'),
            'conditions' => $conditions,
            'fields' => array(
                'SheetRide.id',
                'SheetRideDetailRides.status_id',
            ),
            'joins'=>array(
                array(
                    'table' => 'sheet_ride_detail_rides',
                    'type' => 'left',
                    'alias' => 'SheetRideDetailRides',
                    'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                ),
            )
        ));
        return $sheetRides;

    }
	
	
	public function getSheetRidesOfCurrentMonth($customerId = null){
		$currentMonth=date("m");
		
		$query = "select sheet_rides.real_start_date, sheet_rides.real_end_date,
                 sheet_rides.km_departure, sheet_rides.km_arrival "
           . "FROM sheet_rides "
           . " WHERE 1 =1 ";


       if ($customerId != null) {
           $query .= " && sheet_rides.customer_id = " . $customerId;
       }
      
           $query .= " && MONTH(sheet_rides.real_start_date) = " . $currentMonth;

           $query .= " && MONTH(sheet_rides.real_end_date) = " . $currentMonth;
     

       $results = $this->query($query);
	

       return $results;
		
	}	
	public function getSheetRidesOfCurrentYear($customerId = null){
		$currentMonth=date("m");
		
		$query = "select sheet_rides.real_start_date, sheet_rides.real_end_date,
                 sheet_rides.km_departure, sheet_rides.km_arrival "
           . "FROM sheet_rides "
           . " WHERE 1 =1 ";


       if ($customerId != null) {
           $query .= " && sheet_rides.customer_id = " . $customerId;
       }
      
           $query .= " && year(sheet_rides.real_start_date) = YEAR(CURDATE())  " ;

           $query .= " && year(sheet_rides.real_start_date) = YEAR(CURDATE())   " ;
     

       $results = $this->query($query);
	

       return $results;
		
	}	
	
	public function getSheetRidesOfConductor($customerId = null){
	
		
		$query = "select sheet_rides.real_start_date, sheet_rides.real_end_date,
                 sheet_rides.km_departure, sheet_rides.km_arrival "
           . "FROM sheet_rides "
           . " WHERE 1 =1 ";

       if ($customerId != null) {
           $query .= " && sheet_rides.customer_id = " . $customerId;
       }
    

       $results = $this->query($query);
	

       return $results;
		
	}


	public function getReferenceSheetRide($sheetRideId=null){
        $sheetRide = $this->find('first',
                array(
                    'recursive'=>-1,
                    'conditions'=>array('SheetRide.id'=>$sheetRideId),
                    'fields'=>array('SheetRide.reference')));
        if(!empty($sheetRide)){
            $reference = $sheetRide['SheetRide']['reference'];
        }else {
            $reference ='';
        }
        return $reference;



    }

    public function updateNbComplaintsByMissions($sheetRideId,$countComplaintSheetRides){
        $this->id = $sheetRideId;
        $this->saveField('nb_complaints_by_missions', $countComplaintSheetRides);
    }

    public function getSheetRideBySheetRideDetailRideId($sheetRideDetailRideId =null){
        $sheetRide = $this->find('first',
            array(
                'recursive' => -1,
                'fields' => array('SheetRide.car_type_id', 'CarType.name'),
                'conditions' => array('SheetRideDetailRides.id' => $sheetRideDetailRideId),
                'joins' => array(
                    array(
                        'table' => 'sheet_ride_detail_rides',
                        'type' => 'left',
                        'alias' => 'SheetRideDetailRides',
                        'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'CarType',
                        'conditions' => array('SheetRide.car_type_id = CarType.id')
                    ),
                )
            ));
        return $sheetRide;
    }

}
