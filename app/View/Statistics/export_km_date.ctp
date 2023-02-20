<?php

App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
$phpExcel = new PHPExcel();
$phpExcel->getActiveSheet()->setTitle('Suivi km');

$year_1=$year-1;
$phpExcel->setActiveSheetIndex(0);

$phpExcel->getActiveSheet()->setCellValue('A1', 'Marque');
$phpExcel->getActiveSheet()->setCellValue('B1', 'Modele');
 if($acquisition_type_id=='1'){ 
$phpExcel->getActiveSheet()->setCellValue('C1', 'N de Serie');
$phpExcel->getActiveSheet()->setCellValue('D1', 'Immatriculation');
$phpExcel->getActiveSheet()->setCellValue('E1', 'Date mise en service');
$phpExcel->getActiveSheet()->setCellValue('F1', 'Val Acquis');
        
$phpExcel->getActiveSheet()->setCellValue('G1', 'Departement');
$phpExcel->getActiveSheet()->setCellValue('H1', 'Conducteur');
$phpExcel->getActiveSheet()->setCellValue('I1', 'Zone');
$phpExcel->getActiveSheet()->setCellValue('J1', 'Km Annuel');
$phpExcel->getActiveSheet()->setCellValue('K1', 'Total '.$year_1);
$phpExcel->getActiveSheet()->setCellValue('L1', 'Janvier');
$phpExcel->getActiveSheet()->setCellValue('M1', 'Fevrier');
$phpExcel->getActiveSheet()->setCellValue('N1', 'Mars');
$phpExcel->getActiveSheet()->setCellValue('O1', 'Avril');
$phpExcel->getActiveSheet()->setCellValue('P1', 'Mai');
$phpExcel->getActiveSheet()->setCellValue('Q1', 'Juin');
$phpExcel->getActiveSheet()->setCellValue('R1', 'Juillet');

$phpExcel->getActiveSheet()->setCellValue('S1', 'Aout');
$phpExcel->getActiveSheet()->setCellValue('T1', 'Septembre');
$phpExcel->getActiveSheet()->setCellValue('U1', 'Octobre');
$phpExcel->getActiveSheet()->setCellValue('V1', 'Novembre');
$phpExcel->getActiveSheet()->setCellValue('W1', 'Decembre');
$phpExcel->getActiveSheet()->setCellValue('X1', 'Total');
$phpExcel->getActiveSheet()->setCellValue('Y1', 'Moyenne a jour');
$phpExcel->getActiveSheet()->setCellValue('Z1', 'Moyenne / mois');
$phpExcel->getActiveSheet()->setCellValue('AA1', 'Km '.$year);
$phpExcel->getActiveSheet()->setCellValue('AB1', '-----');
} else {

$phpExcel->getActiveSheet()->setCellValue('C1', 'Departement');
$phpExcel->getActiveSheet()->setCellValue('D1', 'Conducteur');
$phpExcel->getActiveSheet()->setCellValue('E1', 'Zone');
$phpExcel->getActiveSheet()->setCellValue('F1', 'Km Annuel');
$phpExcel->getActiveSheet()->setCellValue('G1', 'Total '.$year_1);
$phpExcel->getActiveSheet()->setCellValue('H1', 'Janvier');
$phpExcel->getActiveSheet()->setCellValue('I1', 'Fevrier');
$phpExcel->getActiveSheet()->setCellValue('J1', 'Mars');
$phpExcel->getActiveSheet()->setCellValue('K1', 'Avril');
$phpExcel->getActiveSheet()->setCellValue('L1', 'Mai');
$phpExcel->getActiveSheet()->setCellValue('M1', 'Juin');
$phpExcel->getActiveSheet()->setCellValue('N1', 'Juillet');

$phpExcel->getActiveSheet()->setCellValue('O1', 'Aout');
$phpExcel->getActiveSheet()->setCellValue('P1', 'Septembre');
$phpExcel->getActiveSheet()->setCellValue('Q1', 'Octobre');
$phpExcel->getActiveSheet()->setCellValue('R1', 'Novembre');
$phpExcel->getActiveSheet()->setCellValue('S1', 'Decembre');
$phpExcel->getActiveSheet()->setCellValue('T1', 'Total');
$phpExcel->getActiveSheet()->setCellValue('U1', 'Moyenne a jour');
$phpExcel->getActiveSheet()->setCellValue('v1', 'Moyenne / mois');
$phpExcel->getActiveSheet()->setCellValue('w1', 'Km '.$year);
$phpExcel->getActiveSheet()->setCellValue('x1', '-----');



}
 $j=2;
            
       

            $lenght=count($results);
           
            for ($i=0; $i<$lenght; $i++) { 
           
            if(!empty($results[$i+1]['Car']['id']) && ($results[$i]['Car']['id']==$results[$i+1]['Car']['id'])){
                
               $mark= $results[$i]['Mark']['name'];
              $model=$results[$i]['Carmodel']['name'];

                if($acquisition_type_id=='1'){ 

             $chassis=$results[$i]['Car']['chassis'];
             $immatr_def=$results[$i]['Car']['immatr_def'] ;
             $reception_date=$results[$i]['Car']['reception_date'];
            
             $purchasing_price=$results[$i]['Car']['purchasing_price'];
            }



    
                $dep= $results[$i]['Department']['name'];
         $customer= $results[$i]['Customer']['first_name']." - ".$results[$i]['Customer']['last_name'];
         $zone= $results[$i]['Zone']['name'];
         $km_year= $results[$i]['Leasing']['km_year'];
            
                $total_year_1=0;
                for($k=1; $k<=12; $k++){
                
              $total_year_1=  $total_year_1+$results[$i]['Monthlykm']['km_'.$k];
			  }
               

            $total_year=0;
            $total=0;
            $m=0;
            for($k=1; $k<=12; $k++){
         
                 if($results[$i+1]['Monthlykm']['km_'.$k]!=0) $m++; 
                
                $total_year=$total_year+$results[$i+1]['Monthlykm']['km_'.$k];

           
                
          }
            $total=$total_year+$total_year_1; 
            $moy_d=0;
          if($m>0) {$moy_d=$total_year/$m; }
          $moy_m=0;
          if($total>0) {$moy_m=$total/12; }
             $phpExcel->getActiveSheet()->setCellValue('A'.$j,$mark);
            $phpExcel->getActiveSheet()->setCellValue('B'.$j,$model);
             if($acquisition_type_id=='1'){ 
              $phpExcel->getActiveSheet()->setCellValue('C'.$j,$chassis);
            $phpExcel->getActiveSheet()->setCellValue('D'.$j,$immatr_def);
            $phpExcel->getActiveSheet()->setCellValue('E'.$j,$reception_date);
            $phpExcel->getActiveSheet()->setCellValue('F'.$j,$purchasing_price);


            $phpExcel->getActiveSheet()->setCellValue('G'.$j,$dep);
            $phpExcel->getActiveSheet()->setCellValue('H'.$j,$customer);
            $phpExcel->getActiveSheet()->setCellValue('I'.$j,$zone);
            $phpExcel->getActiveSheet()->setCellValue('J'.$j,$km_year);
            $phpExcel->getActiveSheet()->setCellValue('K'.$j,$total_year_1);
            $phpExcel->getActiveSheet()->setCellValue('L'.$j,$results[$i+1]['Monthlykm']['km_1']);
	
            $phpExcel->getActiveSheet()->setCellValue('M'.$j,$results[$i+1]['Monthlykm']['km_2']);
	
	        $phpExcel->getActiveSheet()->setCellValue('N'.$j,$results[$i+1]['Monthlykm']['km_3']);
            $phpExcel->getActiveSheet()->setCellValue('O'.$j,$results[$i+1]['Monthlykm']['km_4']);
            $phpExcel->getActiveSheet()->setCellValue('P'.$j,$results[$i+1]['Monthlykm']['km_5']);
            $phpExcel->getActiveSheet()->setCellValue('Q'.$j,$results[$i+1]['Monthlykm']['km_6']);
            $phpExcel->getActiveSheet()->setCellValue('R'.$j,$results[$i+1]['Monthlykm']['km_7']);
            $phpExcel->getActiveSheet()->setCellValue('S'.$j,$results[$i+1]['Monthlykm']['km_8']);
            $phpExcel->getActiveSheet()->setCellValue('T'.$j,$results[$i+1]['Monthlykm']['km_9']);
            $phpExcel->getActiveSheet()->setCellValue('U'.$j,$results[$i+1]['Monthlykm']['km_10']);
            $phpExcel->getActiveSheet()->setCellValue('V'.$j,$results[$i+1]['Monthlykm']['km_11']);
	
	        $phpExcel->getActiveSheet()->setCellValue('W'.$j,$results[$i+1]['Monthlykm']['km_12']);
            $phpExcel->getActiveSheet()->setCellValue('X'.$j,$total);
            $phpExcel->getActiveSheet()->setCellValue('Y'.$j,number_format($moy_d, 2, ",", "."));
            $phpExcel->getActiveSheet()->setCellValue('Z'.$j,number_format($moy_m, 2, ",", "."));
            
            $phpExcel->getActiveSheet()->setCellValue('AA'.$j,$total_year);
            $phpExcel->getActiveSheet()->setCellValue('AB'.$j,(0-$total));
    
            }else {
            $phpExcel->getActiveSheet()->setCellValue('C'.$j,$dep);
            $phpExcel->getActiveSheet()->setCellValue('D'.$j,$customer);
            $phpExcel->getActiveSheet()->setCellValue('E'.$j,$zone);
            $phpExcel->getActiveSheet()->setCellValue('F'.$j,$km_year);
            $phpExcel->getActiveSheet()->setCellValue('G'.$j,$total_year_1);
            $phpExcel->getActiveSheet()->setCellValue('H'.$j,$results[$i+1]['Monthlykm']['km_1']);
	
            $phpExcel->getActiveSheet()->setCellValue('I'.$j,$results[$i+1]['Monthlykm']['km_2']);
	
	        $phpExcel->getActiveSheet()->setCellValue('J'.$j,$results[$i+1]['Monthlykm']['km_3']);
            $phpExcel->getActiveSheet()->setCellValue('K'.$j,$results[$i+1]['Monthlykm']['km_4']);
            $phpExcel->getActiveSheet()->setCellValue('L'.$j,$results[$i+1]['Monthlykm']['km_5']);
            $phpExcel->getActiveSheet()->setCellValue('M'.$j,$results[$i+1]['Monthlykm']['km_6']);
            $phpExcel->getActiveSheet()->setCellValue('N'.$j,$results[$i+1]['Monthlykm']['km_7']);
            $phpExcel->getActiveSheet()->setCellValue('O'.$j,$results[$i+1]['Monthlykm']['km_8']);
            $phpExcel->getActiveSheet()->setCellValue('P'.$j,$results[$i+1]['Monthlykm']['km_9']);
            $phpExcel->getActiveSheet()->setCellValue('Q'.$j,$results[$i+1]['Monthlykm']['km_10']);
            $phpExcel->getActiveSheet()->setCellValue('R'.$j,$results[$i+1]['Monthlykm']['km_11']);
	
	        $phpExcel->getActiveSheet()->setCellValue('S'.$j,$results[$i+1]['Monthlykm']['km_12']);
            $phpExcel->getActiveSheet()->setCellValue('T'.$j,$total);
            $phpExcel->getActiveSheet()->setCellValue('U'.$j,number_format($moy_d, 2, ",", "."));
            $phpExcel->getActiveSheet()->setCellValue('v'.$j,number_format($moy_m, 2, ",", "."));
            
            $phpExcel->getActiveSheet()->setCellValue('w'.$j,$total_year);
            $phpExcel->getActiveSheet()->setCellValue('x'.$j,(0-$total));



            }






         $i++; }

        else {
       if ($results[$i]['Monthlykm']['year']==$year){
       
        
         $mark= $results[$i]['Mark']['name'] ;
         $model= $results[$i]['Carmodel']['name'];
              if($acquisition_type_id=='1'){ 

             $chassis=$results[$i]['Car']['chassis'];
             $immatr_def=$results[$i]['Car']['immatr_def'] ;
             $reception_date=$results[$i]['Car']['reception_date'];
            
             $purchasing_price=$results[$i]['Car']['purchasing_price'];
            }
         $dep= $results[$i]['Department']['name'];
         $customer= $results[$i]['Customer']['first_name']." - ".$results[$i]['Customer']['last_name'];
         $zone=$results[$i]['Zone']['name'];
         $km_year = $results[$i]['Leasing']['km_year'];
            
                $total_year_1=0;
           
            $total_year=0;
            $total=0;
            $m=0;
            
            for($k=1; $k<=12; $k++){
                 if($results[$i]['Monthlykm']['km_'.$k]!=0) $m++; 
                 
                $total_year=$total_year+$results[$i]['Monthlykm']['km_'.$k];
             }
          $total=$total_year+$total_year_1; 
           $moy_d=0;
          if($m>0) {$moy_d=$total_year/$m; }
          $moy_m=0;
          if($total>0) {$moy_m=$total/12; }
        
          $phpExcel->getActiveSheet()->setCellValue('A'.$j,$mark);
            $phpExcel->getActiveSheet()->setCellValue('B'.$j,$model);
            if($acquisition_type_id=='1'){ 
              $phpExcel->getActiveSheet()->setCellValue('C'.$j,$chassis);
            $phpExcel->getActiveSheet()->setCellValue('D'.$j,$immatr_def);
            $phpExcel->getActiveSheet()->setCellValue('E'.$j,$reception_date);
            $phpExcel->getActiveSheet()->setCellValue('F'.$j,$purchasing_price);
            $phpExcel->getActiveSheet()->setCellValue('G'.$j,$dep);
            $phpExcel->getActiveSheet()->setCellValue('H'.$j,$customer);
            $phpExcel->getActiveSheet()->setCellValue('I'.$j,$zone);
            $phpExcel->getActiveSheet()->setCellValue('J'.$j,$km_year);
            $phpExcel->getActiveSheet()->setCellValue('K'.$j,$total_year_1);
            $phpExcel->getActiveSheet()->setCellValue('L'.$j,$results[$i]['Monthlykm']['km_1']);
	
            $phpExcel->getActiveSheet()->setCellValue('M'.$j,$results[$i]['Monthlykm']['km_2']);
	
	        $phpExcel->getActiveSheet()->setCellValue('N'.$j,$results[$i]['Monthlykm']['km_3']);
            $phpExcel->getActiveSheet()->setCellValue('O'.$j,$results[$i]['Monthlykm']['km_4']);
            $phpExcel->getActiveSheet()->setCellValue('P'.$j,$results[$i]['Monthlykm']['km_5']);
            $phpExcel->getActiveSheet()->setCellValue('Q'.$j,$results[$i]['Monthlykm']['km_6']);
            $phpExcel->getActiveSheet()->setCellValue('R'.$j,$results[$i]['Monthlykm']['km_7']);
            $phpExcel->getActiveSheet()->setCellValue('S'.$j,$results[$i]['Monthlykm']['km_8']);
            $phpExcel->getActiveSheet()->setCellValue('T'.$j,$results[$i]['Monthlykm']['km_9']);
            $phpExcel->getActiveSheet()->setCellValue('U'.$j,$results[$i]['Monthlykm']['km_10']);
            $phpExcel->getActiveSheet()->setCellValue('V'.$j,$results[$i]['Monthlykm']['km_11']);
	
	        $phpExcel->getActiveSheet()->setCellValue('W'.$j,$results[$i]['Monthlykm']['km_12']);
            $phpExcel->getActiveSheet()->setCellValue('X'.$j,$total);
            $phpExcel->getActiveSheet()->setCellValue('Y'.$j,number_format($moy_d, 2, ",", "."));
            $phpExcel->getActiveSheet()->setCellValue('Z'.$j,number_format($moy_m, 2, ",", "."));
            $phpExcel->getActiveSheet()->setCellValue('AA'.$j,$total_year);
            $phpExcel->getActiveSheet()->setCellValue('AB'.$j,(0-$total));
            } else {

             $phpExcel->getActiveSheet()->setCellValue('C'.$j,$dep);
            $phpExcel->getActiveSheet()->setCellValue('D'.$j,$customer);
            $phpExcel->getActiveSheet()->setCellValue('E'.$j,$zone);
            $phpExcel->getActiveSheet()->setCellValue('F'.$j,$km_year);
            $phpExcel->getActiveSheet()->setCellValue('G'.$j,$total_year_1);
            $phpExcel->getActiveSheet()->setCellValue('H'.$j,$results[$i]['Monthlykm']['km_1']);
	
            $phpExcel->getActiveSheet()->setCellValue('I'.$j,$results[$i]['Monthlykm']['km_2']);
	
	        $phpExcel->getActiveSheet()->setCellValue('J'.$j,$results[$i]['Monthlykm']['km_3']);
            $phpExcel->getActiveSheet()->setCellValue('K'.$j,$results[$i]['Monthlykm']['km_4']);
            $phpExcel->getActiveSheet()->setCellValue('L'.$j,$results[$i]['Monthlykm']['km_5']);
            $phpExcel->getActiveSheet()->setCellValue('M'.$j,$results[$i]['Monthlykm']['km_6']);
            $phpExcel->getActiveSheet()->setCellValue('N'.$j,$results[$i]['Monthlykm']['km_7']);
            $phpExcel->getActiveSheet()->setCellValue('O'.$j,$results[$i]['Monthlykm']['km_8']);
            $phpExcel->getActiveSheet()->setCellValue('P'.$j,$results[$i]['Monthlykm']['km_9']);
            $phpExcel->getActiveSheet()->setCellValue('Q'.$j,$results[$i]['Monthlykm']['km_10']);
            $phpExcel->getActiveSheet()->setCellValue('R'.$j,$results[$i]['Monthlykm']['km_11']);
	
	        $phpExcel->getActiveSheet()->setCellValue('S'.$j,$results[$i]['Monthlykm']['km_12']);
            $phpExcel->getActiveSheet()->setCellValue('T'.$j,$total);
            $phpExcel->getActiveSheet()->setCellValue('U'.$j,number_format($moy_d, 2, ",", "."));
            $phpExcel->getActiveSheet()->setCellValue('v'.$j,number_format($moy_m, 2, ",", "."));
            $phpExcel->getActiveSheet()->setCellValue('w'.$j,$total_year);
            $phpExcel->getActiveSheet()->setCellValue('x'.$j,(0-$total));






        }
       

                } else if($results[$i]['Monthlykm']['year']==$year_1) {

                 $mark= $results[$i]['Mark']['name'];
                $model= $results[$i]['Carmodel']['name'] ;
                      if($acquisition_type_id=='1'){ 

             $chassis=$results[$i]['Car']['chassis'];
             $immatr_def=$results[$i]['Car']['immatr_def'] ;
             $reception_date=$results[$i]['Car']['reception_date'];
            
             $purchasing_price=$results[$i]['Car']['purchasing_price'];
            }
         $dep=$results[$i]['Department']['name'];
         $customer=$results[$i]['Customer']['first_name']." - ".$results[$i]['Customer']['last_name'];
         $zone= $results[$i]['Zone']['name'];
         $km_year= $results[$i]['Leasing']['km_year'];
            
                $total_year_1=0;
                for($k=1; $k<=12; $k++){
                
              $total_year_1=  $total_year_1+$results[$i]['Monthlykm']['km_'.$k];
			  }
              
            $total_year=0;
            $total=0;
            $m=0;
          
            
         $total=$total_year+$total_year_1; 
           $moy_d=0;
          if($m>0) {$moy_d=$total_year/$m; }
          $moy_m=0;
          if($total>0) {$moy_m=$total/12; }
       
         
            $phpExcel->getActiveSheet()->setCellValue('A'.$j,$mark);
            $phpExcel->getActiveSheet()->setCellValue('B'.$j,$model);

            if($acquisition_type_id=='1'){
            $phpExcel->getActiveSheet()->setCellValue('C'.$j,$chassis);
            $phpExcel->getActiveSheet()->setCellValue('D'.$j,$immatr_def);
            $phpExcel->getActiveSheet()->setCellValue('E'.$j,$reception_date);
            $phpExcel->getActiveSheet()->setCellValue('F'.$j,$purchasing_price);
            $phpExcel->getActiveSheet()->setCellValue('G'.$j,$dep);
            $phpExcel->getActiveSheet()->setCellValue('H'.$j,$customer);
            $phpExcel->getActiveSheet()->setCellValue('I'.$j,$zone);
            $phpExcel->getActiveSheet()->setCellValue('J'.$j,$km_year);
            $phpExcel->getActiveSheet()->setCellValue('K'.$j,$total_year_1);
            $phpExcel->getActiveSheet()->setCellValue('L'.$j,0);
	
            $phpExcel->getActiveSheet()->setCellValue('M'.$j,0);
	
	        $phpExcel->getActiveSheet()->setCellValue('N'.$j,0);
            $phpExcel->getActiveSheet()->setCellValue('O'.$j,0);
            $phpExcel->getActiveSheet()->setCellValue('P'.$j,0);
            $phpExcel->getActiveSheet()->setCellValue('Q'.$j,0);
            $phpExcel->getActiveSheet()->setCellValue('R'.$j,0);
            $phpExcel->getActiveSheet()->setCellValue('S'.$j,0);
            $phpExcel->getActiveSheet()->setCellValue('T'.$j,0);
            $phpExcel->getActiveSheet()->setCellValue('U'.$j,0);
            $phpExcel->getActiveSheet()->setCellValue('V'.$j,0);


	        $phpExcel->getActiveSheet()->setCellValue('W'.$j,0);
            $phpExcel->getActiveSheet()->setCellValue('X'.$j,$total);
            $phpExcel->getActiveSheet()->setCellValue('Y'.$j,number_format($moy_d, 2, ",", "."));
            $phpExcel->getActiveSheet()->setCellValue('Z'.$j,number_format($moy_m, 2, ",", "."));
            $phpExcel->getActiveSheet()->setCellValue('AA'.$j,$total_year);
            $phpExcel->getActiveSheet()->setCellValue('AB'.$j,(0-$total));

            } else {


            $phpExcel->getActiveSheet()->setCellValue('C'.$j,$dep);
            $phpExcel->getActiveSheet()->setCellValue('D'.$j,$customer);
            $phpExcel->getActiveSheet()->setCellValue('E'.$j,$zone);
            $phpExcel->getActiveSheet()->setCellValue('F'.$j,$km_year);
            $phpExcel->getActiveSheet()->setCellValue('G'.$j,$total_year_1);
            $phpExcel->getActiveSheet()->setCellValue('H'.$j,0);
	
            $phpExcel->getActiveSheet()->setCellValue('I'.$j,0);
	
	        $phpExcel->getActiveSheet()->setCellValue('J'.$j,0);
            $phpExcel->getActiveSheet()->setCellValue('K'.$j,0);
            $phpExcel->getActiveSheet()->setCellValue('L'.$j,0);
            $phpExcel->getActiveSheet()->setCellValue('M'.$j,0);
            $phpExcel->getActiveSheet()->setCellValue('N'.$j,0);
            $phpExcel->getActiveSheet()->setCellValue('O'.$j,0);
            $phpExcel->getActiveSheet()->setCellValue('P'.$j,0);
            $phpExcel->getActiveSheet()->setCellValue('Q'.$j,0);
            $phpExcel->getActiveSheet()->setCellValue('R'.$j,0);


	        $phpExcel->getActiveSheet()->setCellValue('S'.$j,0);
            $phpExcel->getActiveSheet()->setCellValue('T'.$j,$total);
            $phpExcel->getActiveSheet()->setCellValue('U'.$j,number_format($moy_d, 2, ",", "."));
            $phpExcel->getActiveSheet()->setCellValue('v'.$j,number_format($moy_m, 2, ",", "."));
            $phpExcel->getActiveSheet()->setCellValue('w'.$j,$total_year);
            $phpExcel->getActiveSheet()->setCellValue('x'.$j,(0-$total));



}




}

        }
                



$j++;
}

header("Content-Type: application/vnd.ms-excel");
$filename = 'Suivi_Km_'.date('d_m_Y');
header("Content-Disposition: attachment; filename=\"$filename.xls\"");


$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
$objWriter->save("php://output");
exit;
?>




        
        
            
               
                
                    
          
                   
      
               
             
                    
                
           
            
        </tbody>
    </table> 

<?php $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>

<?= $this->Html->script('plugins/flot/jquery.flot.min'); ?>
<?= $this->Html->script('plugins/flot/jquery.flot.resize.min'); ?>
<?= $this->Html->script('plugins/flot/jquery.flot.pie.min'); ?>
<?= $this->Html->script('plugins/flot/jquery.flot.categories.min'); ?>
<?= $this->Html->script('tableExport/tableExport'); ?>
<?= $this->Html->script('tableExport/jquery.base64'); ?>

<?= $this->Html->script('tableExport/html2canvas'); ?>
<?= $this->Html->script('tableExport/jspdf/jspdf'); ?>
<?= $this->Html->script('tableExport/jspdf/libs/sprintf'); ?>
<?= $this->Html->script('tableExport/jspdf/libs/base64'); ?>

<!-- Page script -->

    <!-- Page script -->
    <script type="text/javascript">     $(document).ready(function() {
            jQuery("#date").inputmask("yyyy", {"placeholder": "dd/mm/yyyy"});

        });


      




        function exportDataPdf() {
            var car_year = new Array();
            car_year[0] = jQuery('#car').val();
            car_year[1] = jQuery('#year').val();
            
            var url = '<?php echo $this->Html->url(array('action' => 'carinsurance_pdf', 'ext' => 'pdf'))?>';
            var form = jQuery('<form action="' + url + '" method="post" >' +
            '<input type="text" name="caryear" value="' + car_year + '" />' +
            '</form>');
            jQuery('body').append(form);
            form.submit();

       

    }


    function exportDataExcel() {

    $('#table_flotte_ald').tableExport({

        type: 'excel',
        espace: 'false',
        htmlContent:'false'
});


}

 function exportData() {
            var flotte_ald = new Array();
           if(jQuery('#year').val()){
			  km_date[0] = jQuery('#year').val(); 
			   
		   }else km_date[0]= null;
            if(jQuery('#car').val()) {
				 km_date[1] = jQuery('#car').val();
				
			}else {
				km_date[1]= null;
			}
           
            //alert(flotte_ald[1]);
            
            var url = '<?php echo $this->Html->url(array('action' => 'exportKmDate'))?>';
            var form = jQuery('<form action="' + url + '" method="post" >' +
            '<input type="text" name="kmdate" value="' + km_date + '" />' +
            '</form>');
            jQuery('body').append(form);
            form.submit();

       

    }
   

</script>
<?php $this->end(); ?>