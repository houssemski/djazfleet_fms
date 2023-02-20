<?php

App::uses('AppModel', 'Model');

/**
 *
 *
 * @property Car $Car
 */
class Consumption extends AppModel
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


        'date_consumption' => array(
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
        'Tank' => array(
            'className' => 'Tank',
            'foreignKey' => 'tank_id'
        ),
        'FuelCard' => array(
            'className' => 'FuelCard',
            'foreignKey' => 'fuel_card_id'
        ),
        'SheetRide' => array(
            'className' => 'SheetRide',
            'foreignKey' => 'sheet_ride_id'
        ),


    );

    public $hasMany = array(


    );


    /**
     * Get consumption by foreign key
     *
     * @param int $id
     * @param string $modelField
     *
     * @return array $consumption
     */
    public function getConsumptionByForeignKey($id, $modelField)
    {
        $consumption = $this->find(
            'first',
            array(
                'conditions' => array($modelField => $id),
                'fields' => array('Consumption.id'),
                'recursive' => -1
            ));
        return $consumption;
    }

    /**
     * @param null $sheetRideId
     * @param null $recursive
     * @return array|null
     */
	public function getConsumptionsBySheetRideId($sheetRideId = null, $recursive=null){
		if(empty($recursive)){
            $recursive= -1;
        }
        $consumptions = $this->find('all',array(
				'conditions'=>array('Consumption.sheet_ride_id'=>$sheetRideId),
				'recursive'=>$recursive));
				
		return $consumptions ;		
	}
	/**
     * @param null $id
     * @param null $recursive
     * @return array|null
     */
	public function getConsumptionsById($id = null, $recursive=null){
		if(empty($recursive)){
            $recursive= -1;
        }
        $consumption = $this->find('first',array(
				'conditions'=>array('Consumption.id'=>$id),
				'recursive'=>$recursive));


		return $consumption ;
	}

    public function getConsumptionsByCarId($carId = null, $recursive=null){
		if(empty($recursive)){
            $recursive= -1;
        }
        $consumptions = $this->find('all',array(
				'conditions'=>array('SheetRide.car_id'=>$carId),
				'recursive'=>$recursive));

		return $consumptions ;
	}

    /**
     * @param null $consumptionId
     * @param null $fields
     * @return array|null
     */
	public function getConsumptionById($consumptionId = null, $fields= null){
		$consumption = $this->find('first',array(
				'conditions'=>array('Consumption.id'=>$consumptionId),
				'fields'=>$fields,
				'recursive'=>-1));
				
		return $consumption ;		
	}

    public function getSumCost($conditions = null)
    {
        $sumCost = 0;

        if ($conditions != null) {
            $consumptions = $this->find('all', array(
                'conditions' => $conditions,
                'paramType' => 'querystring',
                'recursive' => -1, // should be used with joins
                'fields' => array('cost'),
                'group'=>array('Consumption.id'),
                'joins' => array(
                    array(
                        'table' => 'sheet_rides',
                        'type' => 'left',
                        'alias' => 'SheetRide',
                        'conditions' => array('Consumption.sheet_ride_id = SheetRide.id')
                    ),
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
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('Customer.id = SheetRide.customer_id')
                    ),
                    array(
                        'table' => 'tanks',
                        'type' => 'left',
                        'alias' => 'Tank',
                        'conditions' => array('Consumption.tank_id = Tank.id')
                    ),
                    array(
                        'table' => 'fuel_cards',
                        'type' => 'left',
                        'alias' => 'FuelCard',
                        'conditions' => array('Consumption.fuel_card_id = FuelCard.id')
                    ),
                    array(
                        'table' => 'coupons',
                        'type' => 'left',
                        'alias' => 'Coupon',
                        'conditions' => array('Consumption.id = Coupon.consumption_id')
                    ),
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('SheetRide.user_id = User.id')
                    ),

                )

            ));


            foreach ($consumptions as $consumption) {
                $sumCost = $sumCost + $consumption['Consumption']['cost'];
            }
        } else {
            $consumptions = $this->query("SELECT cost FROM consumptions as Consumption");
            foreach ($consumptions as $consumption) {
                $sumCost = $sumCost + $consumption['Consumption']['cost'];
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
                        'SheetRide.km_liter'
                    ),
                    'group'=>array('SheetRide.id'),
                    'joins' => array(
                        array(
                            'table' => 'sheet_rides',
                            'type' => 'left',
                            'alias' => 'SheetRide',
                            'conditions' => array('Consumption.sheet_ride_id = SheetRide.id')
                        ),
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
                            'table' => 'tanks',
                            'type' => 'left',
                            'alias' => 'Tank',
                            'conditions' => array('Consumption.tank_id = Tank.id')
                        ),
                        array(
                            'table' => 'fuel_cards',
                            'type' => 'left',
                            'alias' => 'FuelCard',
                            'conditions' => array('Consumption.fuel_card_id = FuelCard.id')
                        ),
                        array(
                            'table' => 'coupons',
                            'type' => 'left',
                            'alias' => 'Coupon',
                            'conditions' => array('Consumption.id = Coupon.consumption_id')
                        ),
                        array(
                            'table' => 'users',
                            'type' => 'left',
                            'alias' => 'User',
                            'conditions' => array('SheetRide.user_id = User.id')
                        ),

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
                    'fields' => array('SheetRide.km_arrival', 'SheetRide.km_departure'),
                    'group'=>array('SheetRide.id'),
                    'joins' => array(
                        array(
                            'table' => 'sheet_rides',
                            'type' => 'left',
                            'alias' => 'SheetRide',
                            'conditions' => array('Consumption.sheet_ride_id = SheetRide.id')
                        ),
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
                            'table' => 'carmodels',
                            'type' => 'left',
                            'alias' => 'Carmodel',
                            'conditions' => array('Car.carmodel_id = Carmodel.id')
                        ),
                        array(
                            'table' => 'customers',
                            'type' => 'left',
                            'alias' => 'Customer',
                            'conditions' => array('Customer.id = SheetRide.customer_id')
                        ),
                        array(
                            'table' => 'tanks',
                            'type' => 'left',
                            'alias' => 'Tank',
                            'conditions' => array('Consumption.tank_id = Tank.id')
                        ),
                        array(
                            'table' => 'fuel_cards',
                            'type' => 'left',
                            'alias' => 'FuelCard',
                            'conditions' => array('Consumption.fuel_card_id = FuelCard.id')
                        ),

                        array(
                            'table' => 'users',
                            'type' => 'left',
                            'alias' => 'User',
                            'conditions' => array('SheetRide.user_id = User.id')
                        ),
                        array(
                            'table' => 'coupons',
                            'type' => 'left',
                            'alias' => 'Coupon',
                            'conditions' => array('Consumption.id = Coupon.consumption_id')
                        ),

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


}
