<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
$phpExcel = new PHPExcel();
$phpExcel->getActiveSheet()->setTitle('Produits');
$phpExcel->setActiveSheetIndex(0);

$phpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$phpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$phpExcel->getActiveSheet()->setCellValue('A1', __('Car'));
$phpExcel->getActiveSheet()->setCellValue('B1', __("Conductor") . __(' /Group'));





$i=2;
foreach ($results as $result):


    if ($param == 1) {
        $phpExcel->getActiveSheet()->setCellValue('A'.$i, $result['car']['code'] . " - " . $result['carmodels']['name']);
    } else if ($param == 2) {
        $phpExcel->getActiveSheet()->setCellValue('A'.$i, $result['car']['immatr_def'] . " - " . $result['carmodels']['name']);
    }
    if (isset($result['customers']['first_name']) && !empty($result['customers']['first_name'])) {
        $phpExcel->getActiveSheet()->setCellValue('B'.$i, $result['customers']['first_name'].' '.$result['customers']['last_name']);
    }else{
        $phpExcel->getActiveSheet()->setCellValue('B'.$i, $result['customer_groups']['name']);
    }


    $i++;
endforeach;

header("Content-Type: application/vnd.ms-excel");
$filename = 'Vhécules_réservéss_'.date('Y_m_d');
header("Content-Disposition: attachment; filename=\"$filename.xls\"");


$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
$objWriter->save("php://output");
exit;

