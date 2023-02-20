<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));


header('Content-Type: application/vnd.ms-excel');
$filename = 'consommations_'.date('Y_m_d');
header("Content-Disposition: attachment; filename=\"$filename.xls\"");

echo "
<html>
<head>
 <meta charset='UTF-8'> 
<style>
.datagrid table { border-collapse: collapse; text-align: left; width: 100%; } 
.datagrid {font: normal 12px/150% Arial, Helvetica, sans-serif; background: #fff; overflow: hidden; border: 1px solid #006699; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; }
.datagrid table td, .datagrid table th { padding: 3px 10px; }
.datagrid table td table td{border: 1px solid #006699; }
.datagrid table thead th {background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #006699), color-stop(1, #00557F) );background:-moz-linear-gradient( center top, #006699 5%, #00557F 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#006699', endColorstr='#00557F');background-color:#006699; color:#FFFFFF; font-size: 15px; font-weight: bold;} 
.datagrid table thead th:first-child { border: none; }
</style>
</head>
<body>
<div class='datagrid'>";


echo "<table class='table table-striped table-bordered' style='table-layout: fixed;' >
            <thead style='width: auto'>
			<th>N�</th>
            <th>numero de serie </th>
            <th>Date de sortie</th>
			<th>km de depart</th>
			<th>km d'arrivee</th>
			<th>Km parcouru</th>
			<th>Total km parcouru</th>
            <th>Conducteur</th>
            <th>Nb bons</th>
			<th>Nb Km/bon</th>
			<th>Litre/bon</th>
			<th>Nb Litre/100 km</th>
            </thead>
            <tbody>";
            if(!empty($results)){
                $indKm = 0;
                $couponNbr = 0;
                $serialNumbers = array();
                $releaseDates = array();
				$kmDepartures = array();
				$kmArrivals = array();
				$kmTraveleds = array();
                $customers = array();
                $num_coupon='';
				$date='';
				$km1='';
				$km2='';
				$km3='';
				$km_coupon=0;
				$liter_coupon=0;
				$liter_km=0;
                $i=0;
                $j=0;
                $currentCar = $results[0]['car']['id'];
                $currentconsumption=$results[0]['consumption']['id']; 
               
                foreach ($results as $result) {
                    $i++;
                    if($result['car']['id'] == $currentCar)
                    {
                        if ($param==1){
                         $car_name = $result['car']['code']." - ".$result['carmodels']['name']; 
                         } else if ($param==2) {
                         $car_name = $result['car']['immatr_def']." - ".$result['carmodels']['name']; 
                            }
                            if ($currentconsumption==$result['consumption']['id']) {
								
								$liter_coupon=((float)$coupon_price/(float)$result['fuels']['price']);
								
                            if($num_coupon=='') {
                            $num_coupon=$result['coupons']['serial_number'];
							$date=$result['consumption']['date_departure'];
							$km1=$result['consumption']['km_departure'];
							$km2=$result['consumption']['km_arrival'];
							if($result['consumption']['km_departure'] > 0 && $result['consumption']['km_arrival'] > 0){
							$km3=$result['consumption']['km_arrival']- $result['consumption']['km_departure'];
							}  else $km3=0;
                                }else {
                            $num_coupon=$num_coupon.' , '.$result['coupons']['serial_number'];
                            }
                            $date_departure=$result['consumption']['date_departure'];
							$km_departure=$result['consumption']['km_departure'];
							$km_arrival=$result['consumption']['km_arrival'];
							if($result['consumption']['km_departure'] > 0 && $result['consumption']['km_arrival'] > 0){
							$km_traveled=$result['consumption']['km_arrival']- $result['consumption']['km_departure'];
							}  else $km_traveled=0;
                            if ($couponNbr==0){
                            $couponNbr=$result['consumption']['coupons_number']-$result['consumption']['returned_coupons'];
                           }
                                        } else {
                        if($result['consumption']['km_departure'] > 0 && $result['consumption']['km_arrival'] > 0){
                        
                            $indKm += $result['consumption']['km_arrival'] - $result['consumption']['km_departure'];
							
                        }
						
						
                                        $couponNbr += $result['consumption']['coupons_number']-$result['consumption']['returned_coupons'];
                                         $serialNumbers[] =$num_coupon;
                                         $releaseDates[] = $date;
										 $kmDepartures[] = $km1;
										 $kmArrivals[] = $km2;
										 $kmTraveleds[] = $km3;
                                          $num_coupon=$result['coupons']['serial_number'];
										  $date=$result['consumption']['date_departure'];
										  $km1=$result['consumption']['km_departure'];
										  $km2=$result['consumption']['km_arrival'];
										  if($result['consumption']['km_departure'] > 0 && $result['consumption']['km_arrival'] > 0){
											$km3=$result['consumption']['km_arrival']- $result['consumption']['km_departure'];
										}  else $km3=0;
                                          $currentconsumption=$result['consumption']['id'];
                
                                    }


                       

                        $customers[] = $result['customers']['first_name']." ".$result['customers']['last_name'];
                    }else
                    {
                        $j++;
                        
                         $serialNumbers[] =$num_coupon;
						 
                         $releaseDates[] = $date;
						 $kmDepartures[] = $km1;
						 $kmArrivals[] = $km2;
						 $kmTraveleds[] = $km3;
                         $num_coupon='';
						 $date='';
						 $km1='';
						 $km2='';
						 $km3='';
                         $currentconsumption=$result['consumption']['id'];
                        echo "<tr style='width: auto;'>" .
                            "<td colspan='12' style='background-color: #10c469 !important; color: #fff;font-weight:bold;'>"
                            . $car_name . "</td></tr>";
                        echo "<tr><td class='right'>" . $j . "</td>";
                        echo "<td><table>";

                        foreach($serialNumbers as $serialNumber){
                            echo "<tr ><td style='max-height'>".$serialNumber."</td></tr>";
                        }


                        echo "</table></td>";
                        echo "<td><table>";
                        foreach($releaseDates as $releaseDate){
                       /* echo "<tr><td style='overflow-x: scroll; display: block; width: auto;'>".$this->Time->format($releaseDate, '%d-%m-%Y %H:%M')."</td></tr>";*/
                            echo "<tr><td >".$this->Time->format($releaseDate, '%d-%m-%Y %H:%M')."</td></tr>";
                        }
                        echo "</table></td>";
						
						 echo "<td><table>";
                        foreach($kmDepartures as $kmDeparture){
                       /* echo "<tr><td style='overflow-x: scroll; display: block; width: auto;'>".$this->Time->format($releaseDate, '%d-%m-%Y %H:%M')."</td></tr>";*/
                            echo "<tr><td >".number_format($kmDeparture,0,",",".") ."</td></tr>";
                        }
                        echo "</table></td>";
						
						 echo "<td><table>";
                        foreach($kmArrivals as $kmArrival){
                       /* echo "<tr><td style='overflow-x: scroll; display: block; width: auto;'>".$this->Time->format($releaseDate, '%d-%m-%Y %H:%M')."</td></tr>";*/
                            echo "<tr><td >".number_format($kmArrival,0,",",".") ."</td></tr>";
                        }
                        echo "</table></td>";
						echo "<td><table>";
                        foreach($kmTraveleds as $kmTraveled){
                       /* echo "<tr><td style='overflow-x: scroll; display: block; width: auto;'>".$this->Time->format($releaseDate, '%d-%m-%Y %H:%M')."</td></tr>";*/
                            echo "<tr><td >".number_format($kmTraveled,0,",",".") ."</td></tr>";
                        }
                        echo "</table></td>";
                        echo "<td style='text-align:center;vertical-align:middle;border: 1px solid #006699;'>" . number_format($indKm,0,",",".")  . "</td>";
                        echo "<td><table>";
                        $currentCustomer = null;
                        foreach($customers as $customer){
                            if($customer != $currentCustomer){
                                echo "<tr><td>".$customer."</td></tr>";
                            }
                            $currentCustomer = $customer;
                        }
                        echo "</table></td>";
                        echo "<td style='text-align:center;vertical-align:middle;border: 1px solid #006699;'>" . number_format($couponNbr,0,",",".") . "</td>";
						if($indKm>0){
						$km_coupon=$indKm/$couponNbr;
						$liter_km=($liter_coupon*100)/$indKm;
						} else {
						$km_coupon= 0;
						$liter_km=0;
						}
						echo "<td style='text-align:center;vertical-align:middle;border: 1px solid #006699;'>" . number_format($km_coupon,2,",",".") . "</td>";
						echo "<td style='text-align:center;vertical-align:middle;border: 1px solid #006699;'>" . number_format($liter_coupon,2,",",".") . "</td>";
						echo "<td style='text-align:center;vertical-align:middle;border: 1px solid #006699;'>" . number_format($liter_km,2,",",".") . "</td></tr>";
                        // Next item
                        $couponNbr = 0;
                        $indKm = 0;
						$km_coupon=0;
				        $liter_coupon=0;
				        $liter_km=0;
                        $serialNumbers = array();
                        $releaseDates = array();
						$kmDepartures = array();
						$kmArrivals = array();
						$kmTraveleds = array();
                        $customers = array();
                       if ($param==1){
                         $car_name = $result['car']['code']." - ".$result['carmodels']['name']; 
                         } else if ($param==2) {
                         $car_name = $result['car']['immatr_def']." - ".$result['carmodels']['name']; 
                            }
							$liter_coupon=$coupon_price/(float)$result['fuels']['price'];
                        if($result['consumption']['km_departure'] > 0 && $result['consumption']['km_arrival'] > 0){
                            $indKm += $result['consumption']['km_arrival'] - $result['consumption']['km_departure'];
                        }
						
                        $couponNbr += $result['consumption']['coupons_number']-$result['consumption']['returned_coupons'];
                       
                        if ($currentconsumption==$result['consumption']['id']) {

                             if($num_coupon=='') {
                            $num_coupon=$result['coupons']['serial_number'];
							$date=$result['consumption']['date_departure'];
							$km1=$result['consumption']['km_departure'];
							$km2=$result['consumption']['km_arrival'];
							if($result['consumption']['km_arrival']>0 && $result['consumption']['km_departure']>0){
							$km3=$result['consumption']['km_arrival']- $result['consumption']['km_departure'];
							}  else $km3=0;
                                }else {
                            $num_coupon=$num_coupon.' , '.$result['coupons']['serial_number'];
                            }
							$date_departure=$result['consumption']['date_departure'];
							$km_departure=$result['consumption']['km_departure'];
							$km_arrival=$result['consumption']['km_arrival'];
							
							if($result['consumption']['km_arrival']>0 && $result['consumption']['km_departure']>0){
							$km_traveled=$result['consumption']['km_arrival']- $result['consumption']['km_departure'];
							}  else $km_traveled=0;
                                        } else {
                                         $serialNumbers[] =$num_coupon;
                                          $num_coupon='';
										  $releaseDates[] = $date;
										  $kmDepartures[] = $km1;
										  $kmArrivals[] = $km2;
										  $kmTraveleds[] = $km3;
										  $date='';
										  $km1='';
										  $km2='';
										  $km3='';
                                          $currentconsumption=$result['consumption']['id'];
                
                                    }
                         
                        $customers[] = $result['customers']['first_name']." ".$result['customers']['last_name'];
                        $currentCar = $result['car']['id'];
                    }


                    if($i == count($results))
                    {
                         $serialNumbers[] =$num_coupon;
                         $releaseDates[] = $result['consumption']['date_departure'];
						 $kmDepartures[] = $result['consumption']['km_departure'];
						 $kmArrivals[] = $result['consumption']['km_arrival'];
						 if($result['consumption']['km_arrival']>0  && $result['consumption']['km_departure']>0 ){
						 $kmTraveleds[] =$result['consumption']['km_arrival']-$result['consumption']['km_departure'];
						 }else $kmTraveleds[]=0;
                         $num_coupon=$result['coupons']['serial_number'];
                         $currentconsumption=$result['consumption']['id'];

                                $j++;
           
                                if ($param==1){
                        echo "<tr style='width: auto;'>" .
                            "<td colspan='12' style='background-color: #10c469 !important; color: #fff;font-weight: bold;'>". $car_name = $result['car']['code']." - ".$result['carmodels']['name']. "</td></tr>";
                         } else if ($param==2) {
                         echo "<tr style='width: auto;'>" .
                            "<td colspan='12' style='background-color: #10c469 !important; color: #fff;font-weight: bold;'>". $result['car']['immatr_def']." - ".$result['carmodels']['name']. "</td></tr>";
                            }
                        echo "<tr><td style='text-align:center;vertical-align:middle;border: 1px solid #006699;'>" . $j . "</td>";
                        echo "<td><table>";
                        foreach($serialNumbers as $serialNumber){
                            echo "<tr><td >".$serialNumber."</td></tr>";
                        }
                        echo "</table></td>";
                        echo "<td><table>";
                        foreach($releaseDates as $releaseDate){
                            echo "<tr><td >".$this->Time->format($releaseDate, '%d-%m-%Y %H:%M')."</td></tr>";
                        }
                        echo "</table></td>";
						echo "<td><table>";
                        foreach($kmDepartures as $kmDeparture){
                            echo "<tr><td >".number_format($kmDeparture,0,",",".")  ."</td></tr>";
                        }
                        echo "</table></td>";
						echo "<td><table>";
                        foreach($kmArrivals as $kmArrival){
                            echo "<tr><td >".number_format($kmArrival,0,",",".")  ."</td></tr>";
                        }
                        echo "</table></td>";
						
						echo "<td><table>";
                        foreach($kmTraveleds as $kmTraveled){
                            echo "<tr><td >".number_format($kmTraveled,0,",",".")  ."</td></tr>";
                        }
                        echo "</table></td>";
						
                        echo "<td style='text-align:center;vertical-align:middle;border: 1px solid #006699;'>" . number_format($indKm,0,",",".")  . "</td>";
                        echo "<td><table>";
                        $currentCustomer = "";
                        foreach($customers as $customer){
                            if($customer != $currentCustomer){
                                echo "<tr><td>".$customer."</td></tr>";
                            }
                            $currentCustomer = $customer;
                        }
                        echo "</table></td>";
                        echo "<td style='text-align:center;vertical-align:middle;border: 1px solid #006699;'>" . number_format($couponNbr,0,",",".") . "</td>";
						if($indKm >0){
						$km_coupon=$indKm/$couponNbr;
						$liter_km=($liter_coupon*100)/$indKm;
						} else {
							$km_coupon=0;
							$liter_km=0;
						}
						echo "<td style='text-align:center;vertical-align:middle;border: 1px solid #006699;'>" . number_format($km_coupon,2,",",".") . "</td>";
						echo "<td style='text-align:center;vertical-align:middle;border: 1px solid #006699;'>" . number_format($liter_coupon,2,",",".") . "</td>";
						echo "<td style='text-align:center;vertical-align:middle;border: 1px solid #006699;'>" . number_format($liter_km,2,",",".") . "</td></tr>";
                    }


                }
            }
			
			
            
          echo "  </tbody>
        </table>";

echo "</div></body></html>";

$phpExcel = new PHPExcel();
$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
$objWriter->save("php://output");
exit;







