<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));


header('Content-Type: application/vnd.ms-excel');
$filename = 'synthese_'.date('Y_m_d');
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
			<th>Vehicule</th>
            <th>Nb Km/Bon </th>
            </thead>
            <tbody>";
            if(!empty($results)){
                $indKm = 0;
                $couponNbr = 0;
               
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
								
                         
                            if ($couponNbr==0){
                            $couponNbr=$result['consumption']['coupons_number']-$result['consumption']['returned_coupons'];
                           }
                                        } else {
                        if($result['consumption']['km_departure'] > 0 && $result['consumption']['km_arrival'] > 0){
                        
                            $indKm += $result['consumption']['km_arrival'] - $result['consumption']['km_departure'];
							
                        }
						
						
                                        $couponNbr += $result['consumption']['coupons_number']-$result['consumption']['returned_coupons'];
                                        
                                          $currentconsumption=$result['consumption']['id'];
                
                                    }


                    }else
                    {
                        $j++;
                        
                       
                         $currentconsumption=$result['consumption']['id'];
                        echo "<tr '><td style='text-align:center;vertical-align:middle;border: 1px solid #006699;'>". $car_name . "</td>";
                        
                      
					
                        
                        
						if($indKm>0){
						$km_coupon=$indKm/$couponNbr;
						$liter_km=($liter_coupon*100)/$indKm;
						} else {
						$km_coupon= 0;
						$liter_km=0;
						}
						echo "<td style='text-align:center;vertical-align:middle;border: 1px solid #006699;'>" . number_format($km_coupon,2,",",".") . "</td></tr>";
						
                        // Next item
                        $couponNbr = 0;
                        $indKm = 0;
						$km_coupon=0;
				        $liter_coupon=0;
				        $liter_km=0;
                      
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

                             
                                        } else {
                                         
                                          $currentconsumption=$result['consumption']['id'];
                
                                    }
                         
                        
                        $currentCar = $result['car']['id'];
                    }


                    if($i == count($results))
                    {
                         
                         $currentconsumption=$result['consumption']['id'];

                                $j++;
           
                                if ($param==1){
                        echo "<tr ><td style='text-align:center;vertical-align:middle;border: 1px solid #006699;'>".  $result['car']['code']." - ".$result['carmodels']['name']. "</td>"; 
                         } else if ($param==2) {
                         echo "<tr ><td style='text-align:center;vertical-align:middle;border: 1px solid #006699;'>". $result['car']['immatr_def']." - ".$result['carmodels']['name']. "</td>"; 
                            }
                        
                       
                       
						
						if($indKm >0){
						$km_coupon=$indKm/$couponNbr;
						$liter_km=($liter_coupon*100)/$indKm;
						} else {
							$km_coupon=0;
							$liter_km=0;
						}
						echo "<td style='text-align:center;vertical-align:middle;border: 1px solid #006699;'>" . number_format($km_coupon,2,",",".") . "</td></tr>";
						
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







