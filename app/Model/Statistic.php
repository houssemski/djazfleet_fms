<?php

App::uses('AppModel', 'Model');

/**
 * Parameter Model
 *
 */
class Statistic extends AppModel
{

    public function getKmByMonth($car_id, $year)
    {
        $stats = array();
        $query = "select car.id, car.code, car.immatr_def, car.immatr_prov, carmodels.name, color FROM car "
            . "LEFT JOIN carmodels ON car.carmodel_id = carmodels.id";
        if ($car_id != null) {
            $query .= " WHERE car.id = " . (int)$car_id;
        }
        $cars = $this->query($query);
        foreach ($cars as $car) {
            $query = "select month(real_end_date) as Month, max(km_arrival) as LastKm, car_id from sheet_rides WHERE car_id = " . (int)$car['car']['id'] . " " ;
            // if ($car_id != null) {
            //     $query .= "car_id = " . (int)$car_id . " && ";
            // }
            if ($year != null) {
                $query .= " AND year(real_end_date) = " . $year;
            } else {
                $query .= "AND year(real_end_date) = YEAR(CURDATE())";
            }
            $query .= " group by car_id, month(real_end_date) "
                . "order by car_id asc, Month asc";
            $results = $this->query($query); 

            if (!empty($results)) {
                $lastKm = 0;
                $existCarInConsumption = false;
                foreach ($results as $result) {
                    if ($result['sheet_rides']['car_id'] == $car['car']['id']) {
                        $existCarInConsumption = true;
                        for ($i = 1; $i < 13; $i++) {
                            if ($result[0]['Month'] == $i) {
                                $stats[$car['car']['id']][$i] = (int)$result[0]['LastKm'];
                                $lastKm = (int)$result[0]['LastKm'];
                            } else {
                                $stats[$car['car']['id']][$i] = $lastKm;
                            }
                        }
                    }
                    if (!$existCarInConsumption) {
                        for ($i = 1; $i < 13; $i++) {
                            $stats[$car['car']['id']][$i] = 0;
                        }
                    }
                }
            } else {
                for ($i = 1; $i < 13; $i++) {
                    $stats[$car['car']['id']][$i] = 0;
                }
            }
            if ($car['car']['color'] == "#ffffff" || empty($car['car']['color'])) {
                $stats[$car['car']['id']]['color'] = $this->rand_color();
            } else {
                $stats[$car['car']['id']]['color'] = $car['car']['color'];
            }
            $stats[$car['car']['id']]['name'] = $car['car']['code'] . " " . $car['carmodels']['name'];
        } 
        
        return $stats;
    }

    function rand_color() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    public function getListKmByMonth($car_id, $year, $min_month, $max_month)
    {
        $stats = array();
        $query = "select car.id, car.code, car.immatr_def, car.immatr_prov, carmodels.name, color FROM car "
            . "LEFT JOIN carmodels ON car.carmodel_id = carmodels.id";
        if ($car_id != null) {
            $query .= " WHERE car.id = " . (int)$car_id;
        }
        $cars = $this->query($query);
        foreach ($cars as $car) {
            $query = "select month(real_end_date ) as Month, max(km_arrival) as LastKm, car_id from sheet_rides WHERE ";
            if ($car_id != null) {
                $query .= "car_id = " . (int)$car_id . " && ";
            }
            if ($year != null) {
                $query .= "year(real_end_date) = " . $year;
            } else {
                $query .= "year(real_end_date) = YEAR(CURDATE())";
            }
            if($min_month != null){
                $query .= " && month(real_end_date) >= " . $min_month;
            }
            if($max_month != null){
                $query .= " && month(real_end_date) <= " . $max_month;
            }
            $query .= " group by car_id, month(real_end_date) "
                . "order by car_id asc, Month asc";
            $results = $this->query($query);
            if (!empty($results)) {
                $lastKm = 0;
                $existCarInConsumption = false;
                foreach ($results as $result) {
                    if ($result['sheet_rides']['car_id'] == $car['car']['id']) {
                        $existCarInConsumption = true;
                        for ($i = 1; $i < 13; $i++) {
                            if ($result[0]['Month'] == $i) {
                                $stats[$car['car']['id']][$i] = (int)$result[0]['LastKm'];
                                //$lastKm = (int)$result[0]['LastKm'];
                            } else {
                                $stats[$car['car']['id']][$i] = 0;
                            }
                        }
                    }
                    if (!$existCarInConsumption) {
                        for ($i = 1; $i < 13; $i++) {
                            $stats[$car['car']['id']][$i] = 0;
                        }
                    }
                }
            } else {
                for ($i = 1; $i < 13; $i++) {
                    $stats[$car['car']['id']][$i] = 0;
                }
            }
            if ($car['car']['color'] == "#ffffff" || empty($car['car']['color'])) {
                $stats[$car['car']['id']]['color'] = "#c9c9c9";
            } else {
                $stats[$car['car']['id']]['color'] = $car['car']['color'];
            }
            $stats[$car['car']['id']]['name'] = $car['car']['code'] . " " . $car['carmodels']['name'];
            $stats[$car['car']['id']]['id'] = $car['car']['id'];
        }
        return $stats;
    }

    public function getListCostEventByMonth($type_id,$car_id, $year, $min_month, $max_month) 
    {
         
           
            $query = "select event.id, event_event_types.event_type_id, SUM(event.cost) as sum_cost, month(event.date) as month  FROM event"
                      ." LEFT JOIN event_event_types ON event.id = event_event_types.event_id  "
                    ." LEFT JOIN event_types ON event_event_types.event_type_id = event_types.id   WHERE ";
            
            if ($type_id != null) {
                $query .= "event_event_types.event_type_id = " . (int)$type_id . " && ";
            }
             if ($car_id != null) {
                $query .= "event.car_id = " . (int)$car_id . " && ";
            }
            if ($year != null) {
                $query .= "  year(event.date) = " . $year;
            } else {
                $query .= " year(event.date) = YEAR(CURDATE())";
            }
            if($min_month != null){
                $query .= " && month(event.date) >= " . $min_month;
            }
            if($max_month != null){
                $query .= " && month(event.date) <= " . $max_month;
            }
            $query .= " group by event_type_id, month(event.date) "
                . "order by event_type_id asc, month(event.date) asc";
            $results = $this->query($query);
        return $results;
            }

    public function getConsumptionByMonth($car_id, $year, $min_month, $max_month)
    {
        $query = "SELECT car.id,  car.code, car.immatr_def, car.immatr_prov, carmodels.name, car.color FROM sheet_rides "
            . "LEFT JOIN car ON sheet_rides.car_id = car.id "
            . "LEFT JOIN carmodels ON car.carmodel_id = carmodels.id";
        if ($car_id != null) {
            $query .= " WHERE sheet_rides.car_id = " . (int)$car_id;
        }
        $query .= " Group by sheet_rides.car_id";
        $cars = $this->query($query);

        if(!empty($cars)){
            foreach ($cars as $car) {
                $query = "select month(sheet_rides.real_start_date ) as Month, min(sheet_rides.km_departure) as sumDepartureKm, SUM(consumptions.species) as sumSpecies,
                    SUM(consumptions.consumption_liter) as sumLiter, SUM(consumptions.species_card) as sumSpeciesCard,
                    max(sheet_rides.km_arrival) as sumArrivalKm, sheet_rides.car_id, car.immatr_def, fuels.price, SUM(consumptions.nb_coupon) as sumNbCoupon
                      From sheet_rides  "
                    ." LEFT JOIN consumptions ON consumptions.sheet_ride_id = sheet_rides.id "
                    ." LEFT JOIN car ON sheet_rides.car_id = car.id "
                    ." LEFT JOIN fuels ON car.fuel_id = fuels.id WHERE ";
                if ($car_id != null) {
                    $query .= "car_id = " . (int)$car_id . " && ";
                }
                if ($year != null) {
                    $query .= "YEAR(real_start_date) = " . $year;
                } else {
                    $query .= "YEAR(real_start_date) = YEAR(CURDATE())";
                }
                if ($min_month != null) {
                    $query .= " && MONTH(real_start_date) >= " . $min_month;
                }
                if ($max_month != null) {
                    $query .= " && MONTH(real_start_date ) <= " . $max_month;
                }
                $query .= " group by car_id, month(real_start_date ) "
                    . "order by car_id asc, Month asc";

                $results = $this->query($query);

                if (!empty($results)) {
                    foreach ($results as $result) {
                        if ($result['sheet_rides']['car_id'] == $car['car']['id']) {
                            for ($i = 1; $i < 13; $i++) {
                                if ($result[0]['Month'] == $i) {
                                    $stats[$car['car']['id']][$i]['departureKm'] = (int)$result[0]['sumDepartureKm'];
                                    $stats[$car['car']['id']][$i]['arrivalKm'] = (int)$result[0]['sumArrivalKm'];
                                    $stats[$car['car']['id']][$i]['price'] = (int)$result['fuels']['price'];
                                    $stats[$car['car']['id']][$i]['coupons_number'] = (int)$result[0]['sumNbCoupon'];
                                    $stats[$car['car']['id']][$i]['species'] = (int)$result[0]['sumSpecies'];
                                    $stats[$car['car']['id']][$i]['species_card'] = (int)$result[0]['sumSpeciesCard'];
                                    $stats[$car['car']['id']][$i]['liter_tank'] = (int)$result[0]['sumLiter'];
                                    $stats[$car['car']['id']][$i]['month'] = $i;
                                }
                            }
                        }
                    }
                }
                $stats[$car['car']['id']]['name'] = $car['carmodels']['name'] . " " . $car['car']['code'];
                $stats[$car['car']['id']]['car'] = (int)$car['car']['id'];
            }
        }else{
            $stats = array();
        }
        return $stats;
    }
	
	public function getConsumptionByWeek($car_id, $year, $month, $week)
    {
        $query = "SELECT car.id,  car.code, car.immatr_def, car.immatr_prov, carmodels.name, car.color FROM sheet_rides "
            . "LEFT JOIN car ON sheet_rides.car_id = car.id "
            . "LEFT JOIN carmodels ON car.carmodel_id = carmodels.id 
                WHERE car.id IS NOT NULL 
            ";
        
        if ($car_id != null) {
            $query .= " AND sheet_rides.car_id = " . (int)$car_id;
        }
        $query .= " Group by car.id "
		. "order by car.id asc";
        $cars = $this->query($query);
        foreach ($cars as $car) {
			
            $query = "select MONTH(sheet_rides.real_start_date) as Month, day(sheet_rides.real_start_date) as day, min(sheet_rides.km_departure) as sumDepartureKm , SUM(species) as sumSpecies,
                      SUM(consumption_liter) as sumLiter, SUM(species_card) as sumSpeciesCard,
                    max(sheet_rides.km_arrival) as sumArrivalKm, sheet_rides.car_id, car.immatr_def, fuels.price, SUM(consumptions.nb_coupon) as sumNbCoupon
                      From sheet_rides  "
                ."LEFT JOIN consumptions ON sheet_rides.id = consumptions.sheet_ride_id"
                ." LEFT JOIN car ON sheet_rides.car_id = car.id"
                ." LEFT JOIN fuels ON car.fuel_id = fuels.id  WHERE ";
                $query .= "sheet_rides.car_id = " . (int)$car['car']['id'] . " && ";
            if ($year != null) {
                $query .= "YEAR(real_start_date) = " . $year;
            } else {
                $query .= "YEAR(real_start_date) = YEAR(CURDATE())";
            }
            if ($month != null) {
                $query .= " && MONTH(real_start_date) = " . $month;
            }
            if ($week != null) {
				switch($week) {
					case 1 :$query .= " && day(real_start_date) in (1,2,3,4,5,6,7,8) ";break;
					case 2 :$query .= " && day(real_start_date) in (9,10,11,12,13,14,15,16) ";break;
					case 3 :$query .= " && day(real_start_date) in (17,18,19,20,21,22,23,24) ";break;
					case 4 :$query .= " && day(real_start_date) in (25,26,27,28,29,30,31) ";break;
				}
                
            }
            $query .= " group by sheet_rides.car_id, MONTH(sheet_rides.real_start_date), day(sheet_rides.real_start_date) order by car_id asc, Month asc, day asc";

			
            $results = $this->query($query);
			$departure1=array();
			$arrival1=array();
			$nb_coupon1=0;
            $species1=0;
            $speciesCard1=0;
            $liter1=0;
			$departure2=array();
			$arrival2=array();
			$nb_coupon2=0;
            $speciesCard2=0;
            $species2=0;
            $liter2=0;
			$departure3=array();
			$arrival3=array();
			$nb_coupon3=0;
            $species3=0;
            $speciesCard3=0;
            $liter3=0;
			$departure4=array();
			$arrival4=array();
			$nb_coupon4=0;
            $species4=0;
            $speciesCard4=0;
            $liter4=0;
			$endmonth=0;
			$array1=array(1,2,3,4,5,6,7,8);
			$array2=array(9,10,11,12,13,14,15,16);
			$array3=array(17,18,19,20,21,22,23,24);
			$array4=array(25,26,27,28,29,30,31);
			
            if (!empty($results)) {
                foreach ($results as $result) {
                    
                        for ($i = 1; $i < 13; $i++) {
                            if ($result[0]['Month'] == $i) {
								if($result[0]['Month']!=$endmonth){
									$departure1=array();
			$arrival1=array();
			$nb_coupon1=0;
            $species1=0;
            $speciesCard1=0;
            $liter1=0;
			$departure2=array();
			$arrival2=array();
			$nb_coupon2=0;
            $species2=0;
            $speciesCard2=0;
            $liter2=0;
			$departure3=array();
			$arrival3=array();
			$nb_coupon3=0;
            $species3=0;
            $speciesCard3=0;
            $liter3=0;
			$departure4=array();
			$arrival4=array();
			$nb_coupon4=0;
            $species4=0;
            $speciesCard4=0;
            $liter4=0;
			
								}
								$endmonth = $result[0]['Month'];
							
								if(@in_array($result[0]['day'],$array1)){
									$departure1[]=(int)$result[0]['sumDepartureKm'];
									$arrival1[]=(int)$result[0]['sumArrivalKm'];
									$nb_coupon1=$nb_coupon1+(int)$result[0]['sumNbCoupon']; 
                                    $species1=$species1+(int)$result[0]['sumSpecies'];
                                    $speciesCard1=$speciesCard1+(int)$result[0]['sumSpeciesCard'];
                                    $liter1=$liter1+(int)$result[0]['sumLiter'];
									}
								if(@in_array($result[0]['day'],$array2)){
									$departure2[]=(int)$result[0]['sumDepartureKm'];
									$arrival2[]=(int)$result[0]['sumArrivalKm'];
									$nb_coupon2=$nb_coupon2+(int)$result[0]['sumNbCoupon']; 
                                    $species2=$species2+(int)$result[0]['sumSpecies'];
                                    $speciesCard2=$speciesCard2+(int)$result[0]['sumSpeciesCard'];
                                    $liter2=$liter2+(int)$result[0]['sumLiter'];
									}
								if(@in_array($result[0]['day'],$array3)){
									$departure3[]=(int)$result[0]['sumDepartureKm'];
									$arrival3[]=(int)$result[0]['sumArrivalKm'];
									$nb_coupon3=$nb_coupon3+(int)$result[0]['sumNbCoupon']; 
                                    $species3=$species3+(int)$result[0]['sumSpecies'];
                                    $speciesCard3=$speciesCard3+(int)$result[0]['sumSpeciesCard'];
                                    $liter3=$liter3+(int)$result[0]['sumLiter'];
									}
								if(@in_array($result[0]['day'],$array4)){
									$departure4[]=(int)$result[0]['sumDepartureKm'];
									$arrival4[]=(int)$result[0]['sumArrivalKm'];
									$nb_coupon4=$nb_coupon4+(int)$result[0]['sumNbCoupon']; 
                                    $species4=$species4+(int)$result[0]['sumSpecies'];
                                    $speciesCard4=$speciesCard4+(int)$result[0]['sumSpeciesCard'];
                                    $liter4=$liter4+(int)$result[0]['sumLiter'];
									}
									
								$stats[$car['car']['id']][$i]['month'] = $i;
								if(!empty($departure1)){
								$stats[$car['car']['id']][$i]['departureKm1'] = $departure1[0];
								
                                $stats[$car['car']['id']][$i]['arrivalKm1'] = $arrival1[count($arrival1)-1];
								$stats[$car['car']['id']][$i]['coupons_number1'] = $nb_coupon1;
                                $stats[$car['car']['id']][$i]['species1'] = $species1;
                                $stats[$car['car']['id']][$i]['speciesCard1'] = $speciesCard1;
                                $stats[$car['car']['id']][$i]['liter_tank1'] = $liter1;
								$stats[$car['car']['id']][$i]['week1'] = 1;
                                }
								if(!empty($departure2)){
                                $stats[$car['car']['id']][$i]['coupons_number2'] = $nb_coupon2;
                                $stats[$car['car']['id']][$i]['species2'] = $species2;
                                $stats[$car['car']['id']][$i]['speciesCard2'] = $speciesCard2;
                                $stats[$car['car']['id']][$i]['liter_tank2'] = $liter2;
								$stats[$car['car']['id']][$i]['departureKm2'] = $departure2[0];
                                $stats[$car['car']['id']][$i]['arrivalKm2'] = $arrival2[count($arrival2)-1];
								$stats[$car['car']['id']][$i]['week2'] = 2;
								}
								if(!empty($departure3)){
                                $stats[$car['car']['id']][$i]['coupons_number3'] = $nb_coupon3;
                                $stats[$car['car']['id']][$i]['species3'] = $species3;
                                $stats[$car['car']['id']][$i]['speciesCard3'] = $speciesCard3;
                                $stats[$car['car']['id']][$i]['liter_tank3'] = $liter3;
								$stats[$car['car']['id']][$i]['departureKm3'] = $departure3[0];
                                $stats[$car['car']['id']][$i]['arrivalKm3'] = $arrival3[count($arrival3)-1];
								$stats[$car['car']['id']][$i]['week3'] = 3;
                                }
								if(!empty($departure4)){
                                $stats[$car['car']['id']][$i]['coupons_number4'] = $nb_coupon4;
                                $stats[$car['car']['id']][$i]['species4'] = $species4;
                                $stats[$car['car']['id']][$i]['speciesCard4'] = $speciesCard4;
                                $stats[$car['car']['id']][$i]['liter_tank4'] = $liter4;
								$stats[$car['car']['id']][$i]['departureKm4'] = $departure4[0];
                                $stats[$car['car']['id']][$i]['arrivalKm4'] = $arrival4[count($arrival4)-1];
								$stats[$car['car']['id']][$i]['week4'] = 4;
                                }
                                
                            }
                        }
                    
					$stats[$car['car']['id']]['price'] = (int)$result['fuels']['price'];
                }
            }
            $stats[$car['car']['id']]['name'] = $car['carmodels']['name'] . " " . $car['car']['code'];
			
            $stats[$car['car']['id']]['car'] = (int)$car['car']['id'];
            
        }
		
        return $stats;
    }

    public function getConsumptionsDetails($car_id, $start_date, $end_date)
    {
        $query = "SELECT car.id, car.code, car.immatr_def, car.immatr_prov, carmodels.name, sheet_rides.id, sheet_rides.real_start_date, sheet_rides.real_end_date, fuels.price,
                  sheet_rides.km_departure, sheet_rides.km_arrival, consumptions.nb_coupon,consumptions.species,consumptions.consumption_liter, tanks.name, consumptions.species_card ,fuel_cards.reference ,
                  customers.first_name, coupons.serial_number,
                  customers.last_name FROM  sheet_rides "
            . "LEFT JOIN consumptions  ON consumptions.sheet_ride_id = sheet_rides.id "
            . "LEFT JOIN car ON sheet_rides.car_id = car.id "
			. "LEFT JOIN fuels ON car.fuel_id = fuels.id "
            . "LEFT JOIN carmodels ON car.carmodel_id = carmodels.id "
            . "LEFT JOIN coupons ON consumptions.id = coupons.consumption_id "
            . "LEFT JOIN tanks ON tanks.id = consumptions.tank_id "
            . "LEFT JOIN fuel_cards ON fuel_cards.id = consumptions.fuel_card_id "
            . "LEFT JOIN customers ON sheet_rides.customer_id = customers.id WHERE 1 = 1";
        if ($car_id != null) {
            $query .= " && sheet_rides.car_id = " . (int)$car_id;
        }
        if ($start_date != null) {
            $query .= " && sheet_rides.real_start_date  >= '" . $start_date . "'";
        }
        if ($end_date != null) {
            $query .= " && sheet_rides.real_start_date  <= '" . $end_date . "'";
        }
        $query .= " Order by sheet_rides.car_id ASC, sheet_rides.id ASC,  consumptions.id ASC";
        $consumptions = $this->query($query);
                    
        return $consumptions;
    }

    public function getCostByCar($car_id, $customer_id, $start_date, $end_date,$parcId)
    {
        $query = "select CONCAT(IFNULL(Customers.first_name,''), ' ' , IFNULL(Customers.last_name,'')) as driver,
            CONCAT(Carmodels.name, ' / ' , Car.immatr_def) as carName,
            SUM(Events.cost) as sumcost
FROM event Events
            LEFT JOIN car Car ON car.id = Events.car_id
            LEFT JOIN carmodels Carmodels ON Car.carmodel_id = Carmodels.id
            LEFT JOIN customers Customers ON Events.customer_id = Customers.id
            LEFT JOIN event_event_types EventEventTypes ON EventEventTypes.event_id = Events.id
            LEFT JOIN event_types EventTypes ON EventEventTypes.event_type_id = EventTypes.id

WHERE EventTypes.transact_type_id = 2 AND Events.car_id IS NOT NULL AND Events.customer_id IS NOT NULL
";
        if ($car_id != null) {
            $query .= " && Events.car_id = " . (int)$car_id;
        }
        if ($customer_id != null) {
            $query .= " && Events.customer_id = " . (int)$customer_id;
        }
        if ($start_date != null) {
            $query .= " && Events.date >= '" . $start_date . "'";
        }
        if ($end_date != null) {
            $query .= " && Events.date <= '" . $end_date . "'";
        }
        if ($parcId != null) {
            $query .= " && Car.parc_id = " . (int)$parcId;
        }
        $query .= " GROUP BY Car.id,Customers.id "
            . "ORDER BY Customers.first_name asc";
        $results = $this->query($query);

        return $results;
    }

    public function getDistinctCarFromEvent($car_id, $parcId)
    {
        $query = "select car.code, car.immatr_def, car.immatr_prov, carmodels.name, event.car_id "
            . "FROM event LEFT JOIN car ON car.id = event.car_id "
            . "LEFT JOIN carmodels ON car.carmodel_id = carmodels.id "
            . "WHERE event.car_id IS NOT NULL ";
        if ($car_id != null) {
            $query .= " && event.car_id = " . (int)$car_id;
        }
        if ($parcId != null) {
            $query .= " && car.parc_id = " . (int)$parcId;
        }
        $query .= " GROUP BY event.car_id "
            . "ORDER BY carmodels.name asc, car.code asc";
        $results = $this->query($query);

        return $results;
    }

    public function getDistinctCustomerFromEvent($customer_id)
    {
        $query = "select customers.first_name, customers.last_name, customers.company, event.customer_id "
            . "FROM event LEFT JOIN customers ON event.customer_id = customers.id "
            . "WHERE event.customer_id IS NOT NULL ";
        if ($customer_id != null) {
            $query .= " && event.customer_id = " . (int)$customer_id;
        }
        $query .= " GROUP BY event.customer_id "
            . "ORDER BY customers.company asc, customers.first_name asc";
        $results = $this->query($query);

        return $results;
    }

    public function getSalesTurnover($customer_id, $year)
    {
        $query = "select customer_car.id, customer_car.customer_id, "
            . "customers.company, customers.first_name, customers.last_name, "
            . "SUM(cost) as sumcost, year(date_payment) as year"
            . " FROM customer_car "
            . "LEFT JOIN customers ON customer_car.customer_id = customers.id "
            . "WHERE customer_car.date_payment IS NOT NULL AND customer_car.customer_id IS NOT NULL";
        if ($year != null) {
            $query .= " && year(date_payment) = " . $year;
        }
        if ($customer_id != null) {
            $query .= " && customer_car.customer_id = " . (int)$customer_id;
        }
        $query .= " GROUP BY customer_car.customer_id, year(date_payment) "
            . "ORDER BY customers.company asc, customers.first_name asc, year(date_payment) asc";
        $results = $this->query($query);

        return $results;
    }

    public function getDistinctCustomerFromReservation($customer_id)
    {
        $query = "select customers.first_name, customers.last_name, customers.company, customer_car.customer_id "
            . "FROM customer_car LEFT JOIN customers ON customer_car.customer_id = customers.id "
            . "WHERE customer_car.customer_id IS NOT NULL ";
        if ($customer_id != null) {
            $query .= " && customer_car.customer_id = " . (int)$customer_id;
        }
        $query .= " GROUP BY customer_car.customer_id "
            . "ORDER BY customers.company asc, customers.first_name asc";
        $results = $this->query($query);

        return $results;
    }

    public function getDistinctYearFromReservation($year)
    {
        $query = "select year(date_payment) as year "
            . "FROM customer_car "
            . "WHERE customer_car.date_payment IS NOT NULL ";
        if ($year != null) {
            $query .= " && year(date_payment) = " . $year;
        }
        $query .= " GROUP BY year(date_payment) "
            . "ORDER BY year(date_payment) asc";
        $results = $this->query($query);

        return $results;
    }

    public function getCustomerFlot($car_id, $customer_id, $start_date, $end_date,$parcId)
    {
        $query = "select CONCAT(Carmodels.name,' ',Car.immatr_def) as carName,
            CONCAT(Customers.first_name,' ', Customers.last_name) as driver, CustomerCar.start,
       CustomerCar.end
            FROM customer_car CustomerCar
            LEFT JOIN car Car ON Car.id = CustomerCar.car_id
            LEFT JOIN carmodels Carmodels ON Car.carmodel_id = Carmodels.id
            LEFT JOIN customers Customers ON CustomerCar.customer_id = Customers.id
            WHERE CustomerCar.car_id IS NOT NULL AND CustomerCar.customer_id IS NOT NULL";
        if ($car_id != null) {
            $query .= " && CustomerCar.car_id = " . (int)$car_id;
        }
        if ($customer_id != null) {
            $query .= " && CustomerCar.customer_id = " . (int)$customer_id;
        }
        if ($parcId != null) {
            $query .= " && Car.parc_id = " . (int)$parcId;
        }
        if ($start_date != null) {
            $query .= " && ( CustomerCar.start >= '" . $start_date . "' "
                . "|| CustomerCar.end >= '" . $start_date . "' )";
        }
        if ($end_date != null) {
            $query .= " && ( CustomerCar.end <= '" . $end_date . "'";
            if ($start_date != null) {
                $query .= " || ( CustomerCar.end >= '" . $start_date . "' )";
            } else {
                $query .= " )";
            }
        }
        $query .= " GROUP BY CustomerCar.car_id, CustomerCar.customer_id "
            . "ORDER BY carmodels.name asc, car.code asc, customers.company asc, customers.first_name asc";
        $results = $this->query($query);

        return $results;
    }

    public function getDistinctCarFromReservation($car_id)
    {
        $query = "select customer_car.car_id, carmodels.name, car.code, car.immatr_def, car.immatr_prov "
            . "FROM customer_car "
            . "LEFT JOIN car ON car.id = customer_car.car_id "
            . "LEFT JOIN carmodels ON car.carmodel_id = carmodels.id "
            . "WHERE customer_car.car_id IS NOT NULL ";
        if ($car_id != null) {
            $query .= " && customer_car.car_id = " . (int)$car_id;
        }
        $query .= " GROUP BY customer_car.car_id "
            . "ORDER BY carmodels.name asc, car.code asc";
        $results = $this->query($query);

        return $results;
    }

    public function getMaintenanceProportion($car_id, $event_type_id, $start_date, $end_date,$parc, $eventTypeCatCostQuery)
    {
        $query = "select CONCAT(Carmodels.name,' / ',Car.immatr_def) as Car_name,
       $eventTypeCatCostQuery
       SUM(Events.cost) as sumcost_global
FROM event Events
            LEFT JOIN car Car ON Car.id = Events.car_id
            LEFT JOIN carmodels Carmodels ON Car.carmodel_id = Carmodels.id
            LEFT JOIN event_event_types EventEventTypes  ON EventEventTypes.event_id = Events.id
            LEFT JOIN event_types EventTypes  ON EventEventTypes.event_type_id = EventTypes.id
            LEFT JOIN event_type_categories EventTypeCategories ON EventTypes.event_type_category_id = EventTypeCategories.id
            WHERE EventTypes.transact_type_id = 2 AND Events.car_id IS NOT NULL ";
        if ($car_id != null) {
            $query .= " && event.car_id = " . (int)$car_id;
        }
        if ($event_type_id != null) {
            $query .= " && event.event_type_id = " . (int)$event_type_id;
        }
        if ($start_date != null) {
            $query .= " && event.date >= '" . $start_date . "'";
        }
        if ($end_date != null) {
            $query .= " && event.date <= '" . $end_date . "'";
        }
        if ($parc != null) {
            $query .= " && car.parc_id = " . $parc ;
        }
        $query .= " GROUP BY Events.car_id "
            . "ORDER BY Carmodels.name asc";
        $results = $this->query($query);
        return $results;
    }

    public function getDistinctTypeFromEvent($event_type_id)
    {
        $query = "select event_types.name, event_types.id "
            . "FROM event "
            . "LEFT JOIN event_event_types  ON event_event_types.event_id = event.id "
            . "LEFT JOIN event_types  ON event_event_types.event_type_id = event_types.id "
            . "WHERE event.event_type_id IS NOT NULL ";
        if ($event_type_id != null) {
            $query .= " && event.event_type_id = " . (int)$event_type_id;
        }
        $query .= " GROUP BY event.event_type_id "
            . "ORDER BY event_types.name asc";
        $results = $this->query($query);

        return $results;
    }

    public function getDistinctTypeCategoryFromEvent($event_type_id)
    {
        $query = "select event_type_categories.name, event_type_categories.id "
            . "FROM event "
            . "LEFT JOIN event_event_types  ON event_event_types.event_id = event.id "
            . "LEFT JOIN event_types  ON event_event_types.event_type_id = event_types.id "
            . "LEFT JOIN event_type_categories ON event_types.event_type_category_id = event_type_categories.id "
            . "WHERE event.event_type_id IS NOT NULL ";
        if ($event_type_id != null) {
            $query .= " && event_type_categories.id = " . (int)$event_type_id;
        }
        $query .= " GROUP BY event_type_categories.id "
            . "ORDER BY event_type_categories.name asc";
        $results = $this->query($query);

        return $results;
    }

    public function getGlobalCostByCar($car_id, $start_date, $end_date,$parcId)
    {
        $query = "select event.car_id, carmodels.name,car.id, SUM(cost) as sumcost "
            . "FROM event "
            . "LEFT JOIN car ON car.id = event.car_id "
            . "LEFT JOIN carmodels ON car.carmodel_id = carmodels.id "
            . "LEFT JOIN event_event_types  ON event_event_types.event_id = event.id "
            . "LEFT JOIN event_types  ON event_event_types.event_type_id = event_types.id "
            . "WHERE transact_type_id = 2 AND event.car_id IS NOT NULL AND event.customer_id IS NOT NULL";
        if ($car_id != null) {
        
            $query .= " && event.car_id = " . (int)$car_id;
        }
        if ($start_date != null) {
            $query .= " && event.date >= '" . $start_date . "'";
        }
        if ($end_date != null) {
            $query .= " && event.date <= '" . $end_date . "'";
        }
        if ($parcId != null) {
            $query .= " && car.parc_id = " . (int)$parcId;
        }
        $query .= " GROUP BY event.car_id "
            . "ORDER BY carmodels.name asc, car.code asc";
        $results = $this->query($query);
        
        return $results;
    }

    public function getSalesByCar($car_id, $start_date, $end_date , $parcId)
    {
        $query = "select customer_car.car_id as car_id, SUM(cost) as sumcost "
            . "FROM customer_car "
            . "LEFT JOIN car ON car.id = customer_car.car_id "
            . "LEFT JOIN carmodels ON car.carmodel_id = carmodels.id "
            . "WHERE customer_car.cost > 0";
        if ($car_id != null) {
            $query .= " && customer_car.car_id = " . (int)$car_id;
        }
        if ($start_date != null) {
            $query .= " && customer_car.date_payment >= '" . $start_date . "'";
        }
        if ($end_date != null) {
            $query .= " && customer_car.date_payment <= '" . $end_date . "'";
        }
        if ($parcId != null) {
            $query .= " && car.parc_id = " . $parcId ;
        }
        $query .= " GROUP BY customer_car.car_id "
            . "ORDER BY carmodels.name asc, car.code asc";
        $results = $this->query($query);

        return $results;
    }
    public function getListCarParcSupplier($parc_ids, $supplier_id){
        $query = "select * "
            . "FROM car "
            . "LEFT JOIN parcs ON car.parc_id = parcs.id "
            . "LEFT JOIN suppliers ON car.supplier_id = suppliers.id "
            . "LEFT JOIN carmodels ON car.carmodel_id = carmodels.id WHERE 1=1 ";


            
        if (!empty($parc_ids)) {
            $parc_ids = implode(',',$parc_ids);
            $query .= " && car.parc_id IN (" . $parc_ids.") ";
        }
        if ($supplier_id != null) {
            $query .= " && car.supplier_id = " . $supplier_id;;
        }
        
      //  $query .=  "ORDER BY carmodels.name asc, car.code asc";

        $results = $this->query($query);

        return $results;
    }
    public function getCarsReservations(){
    
        $query = "select customer_car.car_id, carmodels.name, customer_car.id, customer_car.validated, "
            . "car.code, car.immatr_def, car.immatr_prov, customer_car.customer_id, "
            . " customers.first_name, customers.last_name, "
            . "customer_groups.name "
            . "FROM customer_car "
            . "LEFT JOIN car ON customer_car.car_id = car.id "
            . "LEFT JOIN customers ON customer_car.customer_id = customers.id "
            . "LEFT JOIN customer_groups ON customer_car.customer_group_id = customer_groups.id "
            . "LEFT JOIN carmodels ON car.carmodel_id = carmodels.id "
            . "WHERE car.car_status_id=6 and customer_car.validated=1";
        
        
      /*if ($date != null) {
            $query .= " || customer_car.end < " . $date;
        }*/
        
       // $query .= " GROUP BY customer_car.car_id "
          // . "ORDER BY carmodels.name asc, car.code asc";
        $results = $this->query($query);

        return $results;
    }
    public function getCarInsurance($car_id,$year){
        $query = "select event.car_id, carmodels.name, car.id, car.code, car.immatr_def, car.immatr_prov,"
            . "event.date, event.next_date, event.assurance_number, event.cost "
           
            . "FROM event "
            . "LEFT JOIN car ON event.car_id = car.id "
            . "LEFT JOIN event_event_types  ON event_event_types.event_id = event.id "
            . "LEFT JOIN event_types  ON event_event_types.event_type_id = event_types.id "
            . "LEFT JOIN carmodels ON car.carmodel_id = carmodels.id "
            . "WHERE event.event_type_id = 2";
        
        
        if ($car_id != null) {
            $query .= " && event.car_id = " . $car_id;
        }
        if ($year != null) {
            $query .= " && YEAR(event.next_date) <= " . $year;
        }
        
         $query .=  " ORDER BY year(event.date) asc";
        $results = $this->query($query);

        return $results;
    }
    public function getNemberCarsParc($parc_id,$year,$min_month,$max_month){
        $query = "select COUNT(car.parc_id) as countcar,"
            . "parcs.name "
            . "FROM parcs "
            . "LEFT JOIN car ON car.parc_id = parcs.id "
            . "WHERE car.parc_id IS NOT NULL";
        
        if ($parc_id != null) {
            $query .= " && car.parc_id = " . $parc_id;
        }
        
        $query .= " GROUP BY parcs.name ";
        $results = $this->query($query);

        return $results;
    }
    public function getConsumptionCarsParc($parc_id,$year,$min_month,$max_month){

        $query ="SELECT  month(real_end_date) as Month, parcs.name, COALESCE( COUNT( DISTINCT car.id ), 0 ) AS nbCars, "
            ." (max(km_arrival)-min(km_departure)) as sumKm "
            ." FROM parcs"
            ." INNER JOIN car ON parcs.id = car.parc_id "
            ." INNER JOIN sheet_rides ON car.id = sheet_rides.car_id"
        . " WHERE car.parc_id IS NOT NULL ";
        if ($parc_id != null) {
            $query .= " && parcs.id = " . $parc_id;
        }
        if ($year != null) {
            $query .= " && YEAR(real_end_date) = " . $year;
        } else {
            $query .= " && YEAR(real_end_date) = YEAR(CURDATE())";
        }
        if ($min_month != null) {
            $query .= " && MONTH(real_end_date) >= " . $min_month;
        }
        if ($max_month != null) {
            $query .= " && MONTH(real_end_date) <= " . $max_month;
        }
        $query .= " GROUP BY  month(real_end_date) , parcs.id "
         ." order by parcs.name asc,month(real_end_date) asc ";
        
        $results = $this->query($query);

        return $results;
    }
    public function getConsumptionFuelParc($parc_id,$fuel_id){

        $query ="SELECT  parcs.name, fuels.name, carmodels.name, sum(tank_departure-tank_arrival) as sumtank,(sum(tank_departure-tank_arrival)*fuels.price) as depenses "
            
            ." FROM sheet_rides"
            ."  LEFT JOIN car ON car.id = sheet_rides.car_id "
            ." LEFT JOIN parcs ON car.parc_id = parcs.id "
            ." LEFT JOIN fuels ON car.fuel_id=fuels.id "
            ." LEFT JOIN carmodels ON car.carmodel_id=carmodels.id" 
        . " WHERE car.parc_id IS NOT NULL ";
        if ($parc_id != null) {
            $query .= " && parcs.id = " . $parc_id;
        }
        if ($fuel_id != null) {
            $query .= " && fuels.id = " . $fuel_id;
        } 
        
        $query .= " GROUP BY fuels.id"
        ." order by parcs.name asc ";
        
        $results = $this->query($query);
        return $results;

    }

    public function getConsumptionParcByMonth($parc_id, $year, $min_month, $max_month)
    {
        $query = "SELECT parcs.id, parcs.name FROM sheet_rides "
            . "LEFT JOIN car ON sheet_rides.car_id = car.id "
            . "LEFT JOIN parcs ON car.parc_id = parcs.id";
        if ($parc_id != null) {
            $query .= " WHERE car.parc_id = " . (int)$parc_id;
        }
        $query .= " Group by parcs.id";
        $parcs = $this->query($query);
        $stats = array();
        foreach ($parcs as $parc) {
            $query =  "SELECT  month(real_end_date ) as Month, parcs.name,parcs.id, COALESCE( COUNT( DISTINCT car.id ), 0 ) AS nbCars, "
            ." (max(km_arrival)-min(km_departure)) as sumKm "
                     . " From sheet_rides LEFT JOIN car ON sheet_rides.car_id = car.id"
              .  " LEFT JOIN parcs ON car.parc_id = parcs.id WHERE ";
            if ($parc_id != null) {
                $query .= "parc_id = " . (int)$parc_id . " && ";
            }
            if ($year != null) {
                $query .= "YEAR(real_end_date) = " . $year;
            } else {
                $query .= "YEAR(real_end_date) = YEAR(CURDATE())";
            }
            if ($min_month != null) {
                $query .= " && MONTH(real_end_date) >= " . $min_month;
            }
            if ($max_month != null) {
                $query .= " && MONTH(real_end_date) <= " . $max_month;
            }
            $query .= " group by parc_id, month(real_end_date) "
                . "order by parc_id asc, Month asc";
            $results = $this->query($query);

            if (!empty($results)) {
                foreach ($results as $result) {
                    if ($result['parcs']['id'] == $parc['parcs']['id']) {
                        for ($i = 1; $i < 13; $i++) {
                            if ($result[0]['Month'] == $i) {
                                $stats[$parc['parcs']['id']][$i]['nbCars'] = (int)$result[0]['nbCars'];

                                $stats[$parc['parcs']['id']][$i]['sumKm'] = (int)$result[0]['sumKm'];
                                $stats[$parc['parcs']['id']][$i]['month'] = $i;
                            }
                        }
                    }
                }
            }
            $stats[$parc['parcs']['id']]['name'] = $parc['parcs']['name'] ;
            $stats[$parc['parcs']['id']]['parcs'] = (int)$parc['parcs']['id'];
        }

        return $stats;
    }


    public function getConsumptionParcByFuel($parc_id, $fuel_id,$start_date,$end_date)
    {
        $query = "SELECT parcs.id, parcs.name FROM sheet_rides "
            . "LEFT JOIN car ON sheet_rides.car_id = car.id "
            . "LEFT JOIN parcs ON car.parc_id = parcs.id";
        if ($parc_id != null) {
            $query .= " WHERE car.parc_id = " . (int)$parc_id;
        }
        $query .= " Group by parcs.id";
        $parcs = $this->query($query);
        foreach ($parcs as $parc) {
            $query ="SELECT  parcs.name, parcs.id, fuels.name, fuels.id, sum(tank_departure-tank_arrival) as sumTank,(sum(tank_departure-tank_arrival)*fuels.price) as costTank "
           ." FROM sheet_rides"
           ."  LEFT JOIN car ON car.id = sheet_rides.car_id "
           ." LEFT JOIN parcs ON car.parc_id = parcs.id "
           ." LEFT JOIN fuels ON car.fuel_id=fuels.id "
           ." LEFT JOIN carmodels ON car.carmodel_id=carmodels.id "
            . " WHERE car.parc_id IS NOT NULL ";
            if ($parc_id != null) {
                $query .= " && parcs.id = " . (int)$parc_id ;
            }
            if ($fuel_id != null) {
                $query .= " && fuels.id = " . $fuel_id;
            } 

            if ($start_date != null) {
                $query .= " && sheet_rides.real_start_date >= '" . $start_date . "'";
            }

            if ($end_date != null) {
                $query .= " && sheet_rides.real_end_date <= '" . $end_date . "'";
            }
            
            $query .= " group by fuels.id"
                . " order by parcs.id asc";
            $results = $this->query($query);
            if (!empty($results)) {
                foreach ($results as $result) {
                    if ($result['parcs']['id'] == $parc['parcs']['id']) {
                       
                        for ($i = 1; $i < 6; $i++) {
                            if ($result['fuels']['id'] == $i) {
                                
                                $stats[$parc['parcs']['id']][$i]['sumTank'] = (float)$result[0]['sumTank'];

                                $stats[$parc['parcs']['id']][$i]['costTank'] = (float)$result[0]['costTank'];

                                $stats[$parc['parcs']['id']][$i]['fuels'] = $result['fuels']['name'] ;
                                $stats[$parc['parcs']['id']][$i]['fuelid'] = $result['fuels']['id'] ;

                            }
                        }
                               
                            
                        
                    }
                }
            }
            $stats[$parc['parcs']['id']]['name'] = $parc['parcs']['name'] ;
            $stats[$parc['parcs']['id']]['parcs'] = (int)$parc['parcs']['id'];
        }
        return $stats;
    }

        public function getStockFuellog($num_bill, $start_date, $end_date)
    {
        $query = "SELECT sheet_rides.id, coupons.id, coupons.serial_number, fuel_logs.num_bill, fuel_logs.nb_fuellog, fuel_logs.first_number_coupon,
                  fuel_logs.last_number_coupon, fuel_logs.date, sheet_rides.real_start_date, consumptions.nb_coupon
                   FROM coupons "
            . "LEFT JOIN fuel_logs ON coupons.fuel_log_id = fuel_logs.id "
            . "LEFT JOIN consumptions ON coupons.consumption_id = consumptions.id "
            . "LEFT JOIN sheet_rides ON sheet_rides.id = consumptions.sheet_ride_id  WHERE coupons.used =1";
        if ($num_bill != null) {
            $query .= " && fuel_logs.num_bill = " . (int)$num_bill;
        }
        if ($start_date != null) {
            $query .= " && sheet_rides.real_start_date >= '" . $start_date . "'";
        }
        if ($end_date != null) {
            $query .= " && sheet_rides.real_start_date <= '" . $end_date . "'";
        }
        $query .= " Group by fuel_logs.num_bill, fuel_logs.first_number_coupon, sheet_rides.id";
        $query .= " Order by  fuel_logs.num_bill ASC, fuel_logs.date ASC,  sheet_rides.real_start_date ASC";
        $consumptions = $this->query($query);
        
        return $consumptions;
    }

   public function getReservationByMonth($year, $month,$customer_id = null,$group_id = null) {
	   
     $query = "select customer_car.car_id, carmodels.name, marks.name, customer_car.id, customer_car.reference, customer_car.cost_day, customer_car.cost, customer_groups.name, "
            . "car.code, car.immatr_def, car.immatr_prov, customer_car.customer_id, customer_car.start, customer_car.end, TO_DAYS(if(customer_car.end_real is not null, customer_car.end_real,customer_car.end))-TO_DAYS(customer_car.start) as diff_date,"
            . " customers.first_name, customers.last_name, if(customer_car.end_real is not null, customer_car.end_real,customer_car.end) as date_end "
            . "FROM customer_car "
            . "LEFT JOIN car ON customer_car.car_id = car.id "
            . "LEFT JOIN customers ON customer_car.customer_id = customers.id "
            . "LEFT JOIN carmodels ON car.carmodel_id = carmodels.id "
            . "LEFT JOIN customer_groups ON customers.customer_group_id = customer_groups.id "
            . "LEFT JOIN marks ON car.mark_id = marks.id "
            . " WHERE customer_car.request=0  ";

             if ($customer_id != null) {
                $query .= " && customers.id = " . (int)$customer_id ;
            }
            if ($group_id != null) {
                $query .= " && customer_groups.id = " . $group_id;
            }
            if ($year != null) {
                $query .= " having year(date_end) = " . $year ;
            } else {
                $query .= " Having year(date_end) = YEAR(CURDATE()) ";
            }
            
            if($month != null){

            
                $query .= " && month(date_end) = " . $month;
            }
        $query .= " Order by  customer_car.start";
        $reservations = $this->query($query);
return $reservations;
        }

 public function getCarMission() {

  $query = "select Car.id, Car.code, Mark.name, Carmodel.name,  Car.car_status_id, Consumption.date_arrival "
            . "FROM car as Car "
            
            . "LEFT JOIN consumption as Consumption ON consumption.car_id = car.id "
            . "LEFT JOIN carmodels as Carmodel ON car.carmodel_id = Carmodel.id "
            
            . "LEFT JOIN marks as Mark ON car.mark_id = Mark.id "
            . " WHERE Car.car_status_id=6  ";


            $query .= " Order by  Car.id";
        $missions = $this->query($query);
return $missions;


}


public function getFlotteAld($car_id,$date){

  $query = "select Car.id, Car.code, Mark.name, Carmodel.name, Car.chassis, Car.immatr_def, Leasing.reception_date, CustomerCar.start, Leasing.end_date, "
            . "Department.name, Customer.first_name, Customer.last_name, Leasing.km_year, Car.km, Leasing.reception_km, Leasing.cost_km, Leasing.amont_month "
            . "FROM car as Car "
            . "LEFT JOIN customer_car as CustomerCar ON CustomerCar.car_id = Car.id "
            . "LEFT JOIN carmodels as Carmodel ON Car.carmodel_id = Carmodel.id "
            . "LEFT JOIN customers as Customer ON Customer.id = CustomerCar.customer_id " 
            . "LEFT JOIN marks as Mark ON Car.mark_id = Mark.id "
            . "LEFT JOIN leasings as Leasing ON Leasing.car_id = Car.id "
            . "LEFT JOIN departments as Department ON Department.id = Customer.department_id "
			. "WHERE 1=1"; 
            
              if ($date != null) {
                $query .= " &&   Leasing.end_date <= '" . $date . "'" ;
            }
			 if ($car_id != null) {
                $query .= " && Car.id = " . (int)$car_id ;
            }

            $query .= " Order by  Car.id";
        $flottes = $this->query($query);
       
return $flottes;



}

    public function getInvoicedTurnoverByMonth($customer_id, $car_id, $supplier_id,$startDate, $endDate) {
        $query = "select sheet_rides.car_id, sheet_rides.customer_id, carmodels.name, marks.name, sheet_ride_detail_rides.supplier_id,  transport_bill_detail_rides.id, Sum(transport_bill_detail_rides.price_ht) as sum_ht_price, Sum(transport_bill_detail_rides.price_ttc) as sum_ttc_price, customers.first_name, customers.last_name, "
            . "car.code, car.immatr_def, transport_bills.type, sheet_ride_detail_rides.status_id, transport_bill_detail_rides.status_id, sheet_ride_detail_rides.id, suppliers.name, MONTH(sheet_ride_detail_rides.real_start_date) as month "

            . "FROM sheet_ride_detail_rides "
            . "LEFT JOIN sheet_rides ON sheet_ride_detail_rides.sheet_ride_id = sheet_rides.id "
            . "LEFT JOIN transport_bill_detail_rides ON transport_bill_detail_rides.sheet_ride_detail_ride_id = sheet_ride_detail_rides.id "
            . "LEFT JOIN transport_bills ON transport_bill_detail_rides.transport_bill_id = transport_bills.id "
            . "LEFT JOIN customers ON sheet_rides.customer_id = customers.id "
            . "LEFT JOIN car ON sheet_rides.car_id = car.id "
            . "LEFT JOIN suppliers ON sheet_ride_detail_rides.supplier_id = suppliers.id "
            . "LEFT JOIN carmodels ON car.carmodel_id = carmodels.id "

            . "LEFT JOIN marks ON car.mark_id = marks.id "
            . " WHERE transport_bills.type = 7 && transport_bill_detail_rides.status_id=7  && sheet_ride_detail_rides.status_id=7 ";

        if ($customer_id != null) {
            $query .= " && customers.id = " . (int)$customer_id ;
        }
        if ($car_id != null) {
            $query .= " && car.id = " . $car_id;
        }
        if ($supplier_id != null) {
            $query .= " && suppliers.id = " . $supplier_id;
        }

        if ($startDate != null) {
            $query .= " && sheet_ride_detail_rides.real_start_date >= '" . $startDate."'";
        }
        if ($endDate != null) {
            $query .= " && sheet_ride_detail_rides.real_start_date <= '" . $endDate."'";
        }
        $query .= " group by car.id, customers.id, suppliers.id , MONTH( sheet_ride_detail_rides.real_start_date ) "
            . "order by  MONTH( sheet_ride_detail_rides.real_start_date ) asc, sheet_ride_detail_rides.id asc";

        $results = $this->query($query);

        return $results;

    }


    public function getPreinvoicedTurnoverByMonth($customer_id, $car_id, $supplier_id, $startDate, $endDate) {

        $query = "select sheet_rides.car_id, sheet_rides.customer_id, carmodels.name, marks.name, sheet_ride_detail_rides.supplier_id, transport_bill_detail_rides.id,Sum(transport_bill_detail_rides.price_ht) as sum_ht_price, Sum(transport_bill_detail_rides.price_ttc) as sum_price, customers.first_name, customers.last_name, "
            . "car.code, car.immatr_def,transport_bills.type,  sheet_ride_detail_rides.status_id,transport_bill_detail_rides.status_id, sheet_ride_detail_rides.id, suppliers.name, MONTH(sheet_ride_detail_rides.real_start_date) as month "
            . "FROM sheet_ride_detail_rides "
            . "LEFT JOIN sheet_rides ON sheet_ride_detail_rides.sheet_ride_id = sheet_rides.id "
            . "LEFT JOIN transport_bill_detail_rides ON transport_bill_detail_rides.sheet_ride_detail_ride_id = sheet_ride_detail_rides.id "
            . "LEFT JOIN transport_bills ON transport_bill_detail_rides.transport_bill_id = transport_bills.id "
            . "LEFT JOIN customers ON sheet_rides.customer_id = customers.id "
            . "LEFT JOIN car ON sheet_rides.car_id = car.id "
            . "LEFT JOIN suppliers ON sheet_ride_detail_rides.supplier_id = suppliers.id "
            . "LEFT JOIN carmodels ON car.carmodel_id = carmodels.id "
            . "LEFT JOIN marks ON car.mark_id = marks.id "
            . " WHERE (transport_bills.type = 4 &&  transport_bill_detail_rides.status_id =4 && sheet_ride_detail_rides.status_id in(4,5,6) )  ";

        if ($customer_id != null) {
            $query .= " && customers.id = " . (int)$customer_id ;
        }
        if ($car_id != null) {
            $query .= " && car.id = " . $car_id;
        }
        if ($supplier_id != null) {
            $query .= " && suppliers.id = " . $supplier_id;
        }

        if ($startDate != null) {
            $query .= " && sheet_ride_detail_rides.real_start_date >= '" . $startDate."'";
        }
        if ($endDate != null) {
            $query .= " && sheet_ride_detail_rides.real_start_date <= '" . $endDate."'";
        }
        $query .= " group by car.id, customers.id, suppliers.id , MONTH( sheet_ride_detail_rides.real_start_date ) "
            . "order by  MONTH( sheet_ride_detail_rides.real_start_date ) asc , sheet_ride_detail_rides.id asc";

        $results = $this->query($query);


        return $results;



    }

   public function getReservationsBySupplier($supplierId, $carId, $year, $minMonth, $maxMonth){

       $query = "select reservations.id, reservations.cost, reservations.amount_remaining, sheet_ride_detail_rides.reference, sheet_ride_detail_rides.planned_start_date,
                sheet_ride_detail_rides.real_start_date, sheet_ride_detail_rides.planned_end_date, sheet_ride_detail_rides.real_end_date, car.code, car.immatr_def,
                carmodels.name, suppliers.name "
           . "FROM reservations "
           . "LEFT JOIN sheet_ride_detail_rides ON reservations.sheet_ride_detail_ride_id = sheet_ride_detail_rides.id "
           . "LEFT JOIN sheet_rides ON sheet_ride_detail_rides.sheet_ride_id = sheet_rides.id "
           . "LEFT JOIN car ON sheet_rides.car_id = car.id "
           . "LEFT JOIN suppliers ON car.supplier_id = suppliers.id "
           . "LEFT JOIN carmodels ON car.carmodel_id = carmodels.id "
           . "LEFT JOIN marks ON car.mark_id = marks.id "
           . " WHERE 1 =1 ";


       if ($carId != null) {
           $query .= " && car.id = " . $carId;
       }
       if ($supplierId != null) {
           $query .= " && suppliers.id = " . $supplierId;
       }

       if ($year != null) {
           $query .= " && year(sheet_ride_detail_rides.real_start_date) = " . $year ;
       } else {
           $query .= "  && year(sheet_ride_detail_rides.real_start_date) = YEAR(CURDATE())  ";
       }

       if ($minMonth != null) {
           $query .= " && MONTH(sheet_ride_detail_rides.real_start_date) >= " . $minMonth;
       }
       if ($maxMonth != null) {
           $query .= " && MONTH(sheet_ride_detail_rides.real_start_date) <= " . $maxMonth;
       }
       $query .= " group by car.id, suppliers.id, suppliers.id , MONTH( sheet_ride_detail_rides.real_start_date ) "
           . "order by   suppliers.id asc";

       $results = $this->query($query);

       return $results;

   }

   public function getProductsByInterventions($carId, $customerId, $eventTypeId,
                                              $supplierId, $structureId, $productId, $startDate, $endDate, $parcId){


       $query = "select event.id, event.code, event_types.name, "
           ." event.intervention_date , car.code, car.immatr_def, car.immatr_prov, "
           ." carmodels.name , products.name , event_products.quantity, event_products.price, structures.name , customers.first_name , customers.last_name , "
           ." suppliers.name  FROM event "

           . "LEFT JOIN customers ON event.customer_id = customers.id "
           . "LEFT JOIN structures ON event.structure_id = structures.id "
           . "LEFT JOIN car ON event.car_id = car.id "
           . "LEFT JOIN carmodels ON car.carmodel_id = carmodels.id "
           ." LEFT JOIN event_products ON event.id = event_products.event_id  "
           ." LEFT JOIN products ON products.id = event_products.product_id  "
           ." LEFT JOIN suppliers ON suppliers.id = event_products.supplier_id  "
           ." LEFT JOIN event_event_types ON event.id = event_event_types.event_id  "
           ." LEFT JOIN event_types ON event_event_types.event_type_id = event_types.id   WHERE 1= 1 ";

       if ($eventTypeId != null) {
           $query .= "&&  event_event_types.event_type_id = " . (int)$eventTypeId ;
       }
       if ($carId != null) {
           $query .= "&&  event.car_id = " . (int)$carId ;
       }
       if ($customerId != null) {
           $query .= "&&  event.car_id = " . (int)$customerId ;
       }
       if ($supplierId != null) {
           $query .= "&&  event_products.supplier_id = " . (int)$supplierId ;
       }
       if ($structureId != null) {
           $query .= "&&  event.structure_id = " . (int)$structureId ;
       }
       if ($productId != null) {
           $query .= "&&  event_products.product_id = " . (int)$productId ;
       }
       if ($startDate != null) {
           $query .= " && event.intervention_date  >= '" . $startDate . "'";
       }
       if ($endDate != null) {
           $query .= " && event.intervention_date  <= '" . $endDate . "'";
       }
       if ($parcId != null) {
           $query .= " && car.parc_id  = " . (int)$parcId ;
       }
       $query .=   " order by event.id asc, event.intervention_date asc";
       $results = $this->query($query);

       return $results;

   }

 public function getCarByWorkshops($carId, $mechanicId, $workshopId, $startDate, $endDate){


       $query = "select event.id, car.id ,  "
           ."  car.code, car.immatr_def, car.immatr_prov, "
           ." carmodels.name , workshops.name , customers.first_name, customers.last_name, "
           ." event.workshop_entry_date, event.workshop_exit_date  FROM event "

           . "LEFT JOIN customers ON event.mechanician_id = customers.id "
           . "LEFT JOIN workshops ON event.workshop_id = workshops.id "
           . "LEFT JOIN car ON event.car_id = car.id "
           . "LEFT JOIN carmodels ON car.carmodel_id = carmodels.id "
           ."    WHERE 1= 1 && event.workshop_id is not null";


       if ($carId != null) {
           $query .= "&&  event.car_id = " . (int)$carId ;
       }
       if ($mechanicId != null) {
           $query .= "&&  event.mechanician_id = " . (int)$mechanicId ;
       }

       if ($workshopId != null) {
           $query .= "&&  event.workshop_id = " . (int)$workshopId ;
       }

       if ($startDate != null) {
           $query .= " && event.workshop_entry_date  >= '" . $startDate . "'";
       }
       if ($endDate != null) {
           $query .= " && event.workshop_exit_date  <= '" . $endDate . "'";
       }
       $query .=   " order by car.id asc, event.workshop_entry_date asc";
       $results = $this->query($query);

       return $results;

   }




}
