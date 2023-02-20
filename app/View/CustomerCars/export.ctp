<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
$phpExcel = new PHPExcel();
$phpExcel->getActiveSheet()->setTitle('Réservations');


$phpExcel->setActiveSheetIndex(0);

$phpExcel->getActiveSheet()->setCellValue('A1', 'Véhicule');
$phpExcel->getActiveSheet()->setCellValue('B1', __("Conductor"));
$phpExcel->getActiveSheet()->setCellValue('C1', 'Début');
$phpExcel->getActiveSheet()->setCellValue('D1', 'Fin');

$i=2;
foreach ($models as $model):
   
     if ($param==1){
                         $car= $model['Car']['code']." - ".$model['Carmodel']['name']; 
                         } else if ($param==2) {
                         $car= $model['Car']['immatr_def']." - ".$model['Carmodel']['name']; 
                            }
    

        $customer = $model['Customer']['first_name']." ".$model['Customer']['last_name'];
    $start=$this->Time->format($model['CustomerCar']['start'], '%d-%m-%Y %H:%M');
    $end=$this->Time->format($model['CustomerCar']['end'], '%d-%m-%Y %H:%M');
    $phpExcel->getActiveSheet()->setCellValue('A'.$i, $car);
    $phpExcel->getActiveSheet()->setCellValue('B'.$i, $customer);
    $phpExcel->getActiveSheet()->setCellValue('C'.$i, $start);
    $phpExcel->getActiveSheet()->setCellValue('D'.$i, $end);

    $i++;
endforeach;

header("Content-Type: application/vnd.ms-excel");
$filename = 'Affectations_'.date('Y_m_d');
header("Content-Disposition: attachment; filename=\"$filename.xls\"");


$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
$objWriter->save("php://output");
exit;

