<?php

App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
$phpExcel = new PHPExcel();
$phpExcel->getActiveSheet()->setTitle('Flotte Ald');


$phpExcel->setActiveSheetIndex(0);

$phpExcel->getActiveSheet()->setCellValue('A1', 'Marque');
$phpExcel->getActiveSheet()->setCellValue('B1', 'Modèle');
$phpExcel->getActiveSheet()->setCellValue('C1', 'Chassis');
$phpExcel->getActiveSheet()->setCellValue('D1', 'Immatriculation définitive');
$phpExcel->getActiveSheet()->setCellValue('E1', 'Date de réception');
$phpExcel->getActiveSheet()->setCellValue('F1', 'Date d\'Affectation');
$phpExcel->getActiveSheet()->setCellValue('G1', 'Fin de contrat');
$phpExcel->getActiveSheet()->setCellValue('H1', 'Compteur /Km');

$phpExcel->getActiveSheet()->setCellValue('I1', 'Departement');
$phpExcel->getActiveSheet()->setCellValue('J1', 'Conducteur');
$phpExcel->getActiveSheet()->setCellValue('K1', 'Km Annuel');
$phpExcel->getActiveSheet()->setCellValue('L1', 'Duree Contractuelle');
$phpExcel->getActiveSheet()->setCellValue('M1', 'Km Contractuel Global');
$phpExcel->getActiveSheet()->setCellValue('N1', 'Km a date');
$phpExcel->getActiveSheet()->setCellValue('O1', 'Cout Supp. Au Km HT');
$phpExcel->getActiveSheet()->setCellValue('P1', 'Duree a date / date en S1');
$phpExcel->getActiveSheet()->setCellValue('Q1', 'Duree restante a date en S1');
$phpExcel->getActiveSheet()->setCellValue('R1', 'Mois ecoule');
$phpExcel->getActiveSheet()->setCellValue('S1', 'Reste a fin de contrat/mois');

$phpExcel->getActiveSheet()->setCellValue('T1', 'Km/Mois');
$phpExcel->getActiveSheet()->setCellValue('U1', 'Km Restant au contrat');
$phpExcel->getActiveSheet()->setCellValue('V1', 'Km contractuel a date');
$phpExcel->getActiveSheet()->setCellValue('W1', 'Situation a date');
$phpExcel->getActiveSheet()->setCellValue('X1', '+/- value sur contrat dzd / km supplementaire');
$phpExcel->getActiveSheet()->setCellValue('Y1', 'montant location / mois');
$phpExcel->getActiveSheet()->setCellValue('Z1', 'Km estimé fin de contrat');
$phpExcel->getActiveSheet()->setCellValue('AA1', 'Estimation écart KM fin de contrat');
$phpExcel->getActiveSheet()->setCellValue('AB1', '+/- value sur contrat dzd / km fin de contrat');
$phpExcel->getActiveSheet()->setCellValue('AC1', 'Franchise Km Supplementaires');

$phpExcel->getActiveSheet()->setCellValue('AD1', '+/- value fin de contrat avec franchise');



$i=2;
 
foreach ($results as $result):
$mark=$result['Mark']['name'];

$model=$result['Carmodel']['name'];
$chassis =$result['Car']['chassis'];
$immatr_def = $result['Car']['immatr_def'];
$reception_date =  $this->Time->format($result['Leasing']['reception_date'], '%d-%m-%Y ');       
$start=  $this->Time->format($result['CustomerCar']['start'], '%d-%m-%Y '); 
if(!empty($result['Leasing']['reception_date'])){
if(!empty($result['Leasing']['end_date'])){

$end_date=$this->Time->format($result['Leasing']['end_date'], '%d-%m-%Y ');

}else {
$nb_year=(int)$year_contract['Parameter']['val']; 
                    $nb_days=$nb_year*365;
                $date_end = date_create($result['Leasing']['reception_date']);
                date_add($date_end, date_interval_create_from_date_string($nb_days.'days'));

      
$end_date=  $date_end->format('d-m-Y'); 
} 
} else $end_date='';
   
$reception_km =  $result['Leasing']['reception_km'];
$department = $result['Department']['name'];    
$customer =  $result['Customer']['first_name']." - ".$result['Customer']['last_name'];       
$km_year = $result['Leasing']['km_year'];              
			  $datetime1 = $result['Leasing']['reception_date'];
               if(!empty($result['Leasing']['end_date'])) {

              $datetime2 =$result['Leasing']['end_date'];
                }else {
              $datetime2 = $date_end->format('Y-m-d');
              }
			 
              $datetime1 = new DateTime ( $datetime1);
              $datetime2 = new DateTime ( $datetime2 );
              $interval = date_diff ( $datetime1, $datetime2 );
			  
              if ($interval->d>=28) {
              $mois=1;
                }else $mois=0;
$duree = $interval->y * 12 + $interval->m+ $mois ;
              
            
$km_global= $result['Leasing']['km_year']*($duree/12);
$km=$result['Car']['km'];
$cost_km= $result['Leasing']['cost_km'];
         
              $datetime1 = $result['Leasing']['reception_date'];
              $datetime2 = date('Y-m-d');
              $datetime1 = strtotime ( $datetime1);
              $datetime2 = strtotime ( $datetime2 );
              $nbJoursTimestamp = $datetime2 - $datetime1;
             
$duree_s1 = $nbJoursTimestamp/86400;
        
$duree_restante= ($duree*30)-$duree_s1; 
           
$mois_ecoulé=$duree_s1/30; ;
$rest_contrat_mois=$duree_restante/30; 
if ($duree!=0){
	$km_mois=$km_global/$duree;
} else $km_mois=0;


$km_restant=$km_global-$result['Car']['km'];  
$rest_mois_j=$km_mois*$rest_contrat_mois;
if($duree!=0)  {
	
$km_contractuel_date=($km_global/$duree)*$mois_ecoulé; 	
}else $km_contractuel_date=0;
 
$situation_date=$result['Car']['km']-$km_contractuel_date;  
         
if ($situation_date<0) {$value=0; } else { $value=$situation_date*$result['Leasing']['cost_km'];  $value;}
$amont_month= $result['Leasing']['amont_month'];
 $km_estimé=($result['Car']['km']/$mois_ecoulé)*$duree; 
 $estimation_ecart=$km_estimé-$km_global;


    $phpExcel->getActiveSheet()->setCellValue('A'.$i,$mark);
    $phpExcel->getActiveSheet()->setCellValue('B'.$i,$model);
    $phpExcel->getActiveSheet()->setCellValue('C'.$i,$chassis);
    $phpExcel->getActiveSheet()->setCellValue('D'.$i,$immatr_def);
    $phpExcel->getActiveSheet()->setCellValue('E'.$i,$reception_date);
    $phpExcel->getActiveSheet()->setCellValue('F'.$i,$start);
    $phpExcel->getActiveSheet()->setCellValue('G'.$i,$end_date);
    $phpExcel->getActiveSheet()->setCellValue('H'.$i,$reception_km);
	
    $phpExcel->getActiveSheet()->setCellValue('I'.$i,$department);
	
	$phpExcel->getActiveSheet()->setCellValue('J'.$i,$customer);
    $phpExcel->getActiveSheet()->setCellValue('K'.$i,$km_year);
    $phpExcel->getActiveSheet()->setCellValue('L'.$i,number_format($duree, 2, ",", "."));
    $phpExcel->getActiveSheet()->setCellValue('M'.$i,number_format($km_global, 2, ",", "."));
    $phpExcel->getActiveSheet()->setCellValue('N'.$i,$km);
    $phpExcel->getActiveSheet()->setCellValue('O'.$i,number_format($cost_km, 2, ",", "."));
    $phpExcel->getActiveSheet()->setCellValue('P'.$i,number_format($duree_s1, 2, ",", "."));
    $phpExcel->getActiveSheet()->setCellValue('Q'.$i,number_format($duree_restante, 2, ",", "."));
    $phpExcel->getActiveSheet()->setCellValue('R'.$i,number_format($mois_ecoulé, 2, ",", "."));
	
	$phpExcel->getActiveSheet()->setCellValue('S'.$i,number_format($rest_contrat_mois, 2, ",", "."));
    $phpExcel->getActiveSheet()->setCellValue('T'.$i,number_format($km_mois, 2, ",", "."));
    $phpExcel->getActiveSheet()->setCellValue('U'.$i,number_format($km_restant, 2, ",", "."));
    $phpExcel->getActiveSheet()->setCellValue('V'.$i,number_format($rest_mois_j, 2, ",", "."));
    $phpExcel->getActiveSheet()->setCellValue('W'.$i,number_format($km_contractuel_date, 2, ",", "."));
    $phpExcel->getActiveSheet()->setCellValue('X'.$i,number_format($value, 2, ",", "."));
    $phpExcel->getActiveSheet()->setCellValue('Y'.$i,number_format($amont_month, 2, ",", "."));
    $phpExcel->getActiveSheet()->setCellValue('Z'.$i,number_format($km_estimé, 2, ",", "."));
    $phpExcel->getActiveSheet()->setCellValue('AA'.$i,number_format($estimation_ecart, 2, ",", "."));
     


   
$i++;
endforeach;

header("Content-Type: application/vnd.ms-excel");
$filename = 'Flotte_Ald_'.date('d_m_Y');
header("Content-Disposition: attachment; filename=\"$filename.xls\"");


$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
$objWriter->save("php://output");
exit;

