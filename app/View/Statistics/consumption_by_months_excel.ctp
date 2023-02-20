<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
$phpExcel = new PHPExcel();
$phpExcel->getActiveSheet()->setTitle('Produits');
$phpExcel->setActiveSheetIndex(0);

$phpExcel->getActiveSheet()->setCellValue('A1', __('Month'));
$phpExcel->getActiveSheet()->setCellValue('B1', __('Coupons Nbr'));
$phpExcel->getActiveSheet()->setCellValue('C1', __('Liter/Coupon'));
$phpExcel->getActiveSheet()->setCellValue('D1', __('Total liter coupon'));
$phpExcel->getActiveSheet()->setCellValue('E1', __('Coupon price'));
$phpExcel->getActiveSheet()->setCellValue('F1', __('Total price coupon'));
$phpExcel->getActiveSheet()->setCellValue('G1', __('Species'));
$phpExcel->getActiveSheet()->setCellValue('H1', __('Consumption liter'));
$phpExcel->getActiveSheet()->setCellValue('I1', __('Species card'));
$phpExcel->getActiveSheet()->setCellValue('J1', __('Total consumption liter'));
$phpExcel->getActiveSheet()->setCellValue('K1', __('Total'));
$phpExcel->getActiveSheet()->setCellValue('L1', __('Departure km'));
$phpExcel->getActiveSheet()->setCellValue('M1', __('Arrival km'));
$phpExcel->getActiveSheet()->setCellValue('N1', __('Kms / Month'));
$phpExcel->getActiveSheet()->setCellValue('O1', __('Cons / 100kms'));




$all_total = 0;
$all_coupon = 0;
$all_tank = 0;
$all_species = 0;
$all_species_card = 0;
$total_car = 0;
$total_car_1 = 0;
$j=3;

foreach ($cars as $key => $value){
    if($results){
        foreach ($results as $result){
            if ($result['car'] == $key){
                for ($i = 1; $i <= 12; $i++) {
                    switch ($i) {
                        case 1 :
                            $label = __("January");
                            break;
                        case 2 :
                            $label = __("February");
                            break;
                        case 3 :
                            $label = __("March");
                            break;
                        case 4 :
                            $label = __("April");
                            break;
                        case 5 :
                            $label = __("May");
                            break;
                        case 6 :
                            $label = __("June");
                            break;
                        case 7 :
                            $label = __("July");
                            break;
                        case 8 :
                            $label = __("August");
                            break;
                        case 9 :
                            $label = __("September");
                            break;
                        case 10 :
                            $label = __("October");
                            break;
                        case 11 :
                            $label = __("November");
                            break;
                        case 12 :
                            $label = __("December");
                            break;
                    }
                    if (isset($result[$i]['month']) && $result[$i]['month'] == $i) {
                        $litersByCoupon = $coupon_price / $result[$i]['price'];
                        $totalLitersCoupon = $result[$i]['coupons_number'] * $litersByCoupon;
                        $totalLitersSpecies = $result[$i]['species'] / $result[$i]['price'];
                        $totalLitersSpeciesCard = $result[$i]['species_card'] / $result[$i]['price'];
                        $totalPriceCoupon = $coupon_price * $result[$i]['coupons_number'];
                        $totalPricetank = $result[$i]['liter_tank'] * $result[$i]['price'];
                        $total = $totalPriceCoupon + $totalPricetank + $result[$i]['species']+ $result[$i]['species_card'];
                        $totalLiters = $totalLitersCoupon + $totalLitersSpecies + $result[$i]['liter_tank']+$totalLitersSpeciesCard;
                        $diffKm = $result[$i]['arrivalKm'] - $result[$i]['departureKm'];
                        if ($diffKm <= 0) {
                            $diffKm = 0;
                            $consumptionPer100km = 0;
                        } else {
                            $consumptionPer100km = ($totalLiters * 100) / $diffKm;
                        }
                        $phpExcel->getActiveSheet()->setCellValue('A'.$j, $value);
                        $j++;
                        $phpExcel->getActiveSheet()->setCellValue('A'.$j, $label);
                        $phpExcel->getActiveSheet()->setCellValue('B'.$j, $result[$i]['coupons_number']);
                        $phpExcel->getActiveSheet()->setCellValue('C'.$j, number_format($litersByCoupon, 2, ",", "."));
                        $phpExcel->getActiveSheet()->setCellValue('D'.$j, number_format($totalLitersCoupon, 2, ",", "."));
                        $phpExcel->getActiveSheet()->setCellValue('E'.$j, number_format($coupon_price, 2, ",", "."));
                        $phpExcel->getActiveSheet()->setCellValue('F'.$j, number_format($totalPriceCoupon, 2, ",", "."));
                        $phpExcel->getActiveSheet()->setCellValue('G'.$j, number_format($result[$i]['species'], 2, ",", "."));
                        $phpExcel->getActiveSheet()->setCellValue('H'.$j, number_format($result[$i]['liter_tank'], 2, ",", "."));
                        $phpExcel->getActiveSheet()->setCellValue('I'.$j, number_format($result[$i]['species_card'], 2, ",", "."));
                        $phpExcel->getActiveSheet()->setCellValue('J'.$j, number_format($totalPricetank, 2, ",", "."));
                        $phpExcel->getActiveSheet()->setCellValue('K'.$j, number_format($total, 2, ",", "."));
                        $phpExcel->getActiveSheet()->setCellValue('L'.$j, number_format($result[$i]['departureKm'], 0, ",", "."));
                        $phpExcel->getActiveSheet()->setCellValue('M'.$j, number_format($result[$i]['arrivalKm'], 0, ",", "."));
                        $phpExcel->getActiveSheet()->setCellValue('N'.$j, number_format($diffKm, 0, ",", "."));
                        $phpExcel->getActiveSheet()->setCellValue('O'.$j, number_format($consumptionPer100km, 2, ",", "."));

                        $all_coupon = $all_coupon + $result[$i]['coupons_number'];
                        $all_tank = $all_tank + $result[$i]['liter_tank'];
                        $all_species = $all_species + $result[$i]['species'];
                        $all_species = $all_species + $result[$i]['species_card'];
                        $all_total = $all_total + $total;
                        $total_car = $total_car + $total;
                        $j++;
                        $phpExcel->getActiveSheet()->setCellValue('A'.$j, __('Total'));
                        $phpExcel->getActiveSheet()->setCellValue('B'.$j, $total_car);
                        $j= $j+2;
                    }
                }

            }
        }
    }
}



header("Content-Type: application/vnd.ms-excel");
$filename = 'Consommation_mensuelle_par_véhicule_'.date('Y_m_d');
header("Content-Disposition: attachment; filename=\"$filename.xls\"");


$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
$objWriter->save("php://output");
exit;

