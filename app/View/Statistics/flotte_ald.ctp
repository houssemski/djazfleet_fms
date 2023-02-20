<?php
$this->request->data['Statistic']['date'] = $this->Time->format($date, '%d-%m-%Y');
?><h4 class="page-title"> <?=__('Flotte Ald'); ?></h4>
<div class="box-body">
    <div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
    <div class="card-box p-b-20">
         <?php echo $this->Form->create('Statistic', array(
             'url'=> array(
                 'action' => 'flotteAld'
             ),
             'novalidate' => true
         )); ?>
    <div class="filters" id='filters' style='display: block;'>
        <?php
        echo $this->Form->input('car_id', array(
                    'label' => __('Car'),
                    'class' => 'form-filter select2',
                    'id'=>'car',
                    'empty' => ''
                    ));
         echo $this->Form->input('date', array(
                'label' => '',
                'type' => 'text',
                'class' => 'form-control datemask',
                'before' => '<label class="dte">' . __('Date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                'after' => '</div>',
                'id' => 'date',
            ));
       
  
        ?>
        <div style='clear:both; padding-top: 5px;'></div>
        <button style="float: right;" class="btn btn-success btn-trans waves-effect w-md waves-success" type="submit"><?= __('Search') ?></button>
        <div style='clear:both; padding-top: 10px;'></div>
   </div>
        <?php echo $this->Form->end(); ?>
    


    <div class="row" style="clear: both">
        <div class="btn-group pull-left">
            <div class="header_actions">

                <div class="btn-group">
                    <?= $this->Html->link('<i class="glyphicon glyphicon-export"></i>' . __('Export Excel'),
                       
                        'javascript:exportData();',
                         array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id'=>'export_excel')) ?>


                </div>
                 

            </div>

        </div>
    </div>

    </div>
    </div>
    </div>
    <div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
    <div class="card-box p-b-20">
        <div class="table-responsive">
            <table class="table table-striped table-bordered dt-responsive nowrap"
                   cellspacing="0" width="100%" id='table_flotte_ald'>
            <thead style="width: auto">
            <th><?= __('Mark') ?></th>
            <th><?= __('Model') ?></th>
            <th><?= __('Chassis') ?></th>
            <th><?= __('Final registration') ?></th>
            <th><?= __('Reception date') ?></th>
            <th><?= __('Date d\'Affectation') ?></th>
            <th><?= __('End of contract') ?></th>
            <th><?= __('Counter / Km') ?></th>
            <th><?= __('Department') ?></th>
            <th><?= __('Customer') ?></th>
            <th><?= __('Km annual') ?></th>
            <th><?= __('Contract duration') ?></th>
            <th><?= __('Km Global Contract') ?></th>
            <th><?= __('Km Date') ?></th>
            <th><?= __('Additional cost. At Km HT') ?></th>
            <th><?= __('Time for date / time in S1') ?></th>
            <th><?= __('Remaining time to time in S1') ?></th>
            <th><?= __('Past month') ?></th>
            <th><?= __('Rest termination / month') ?></th>
            <th><?= __('Km/Month') ?></th>
            <th><?= __('Km Remaining contract') ?></th>
            <th><?= __('Remaining xx Month / D') ?></th>
            <th><?= __('Contractual km to Date') ?></th>
            
            <th><?= __('Situation to date') ?></th>
            <th><?= __('+/- Value of contract dzd / km additional') ?></th>
            <th><?= __('Amount leasing / month') ?></th>
            <th><?= __('Km estimated contract termination') ?></th>
            <th><?= __('Estimated distance KM termination') ?></th>
            
            </thead>
            <tbody>
            
 
            
       

         <?php

         foreach ($results as $result) { ?>

         <tr>
         <td><?php echo $result['Mark']['name'] ?></td>
         <td><?php echo $result['Carmodel']['name'] ?></td>
         <td><?php echo $result['Car']['chassis'] ?></td>
         <td><?php echo $result['Car']['immatr_def']?></td>
         <td><?php echo $this->Time->format($result['Leasing']['reception_date'], '%d-%m-%Y ')?></td>
         <td><?php echo $this->Time->format($result['CustomerCar']['start'], '%d-%m-%Y ')?></td>
            <?php  $date_end= '';    ?>
         <td><?php if(!empty($result['Leasing']['reception_date'])){
                    if(!empty($result['Leasing']['end_date'])) {
                    echo $this->Time->format($result['Leasing']['end_date'], '%d-%m-%Y ');
                    }else {
                    $nb_year=(int)$year_contract['Parameter']['val']; 
                    $nb_days=$nb_year*365;
                $date_end = date_create($result['Leasing']['reception_date']);
                date_add($date_end, date_interval_create_from_date_string($nb_days.'days'));
                echo $this->Time->format($date_end, '%d-%m-%Y');
                }
                }
            ?></td>
         <td><?php echo $result['Leasing']['reception_km']?></td>
         <td><?php echo $result['Department']['name']?></td>
         <td><?php echo $result['Customer']['first_name']." - ".$result['Customer']['last_name']?></td>
         <td><?php echo $result['Leasing']['km_year']?></td>
         <td><?php   
              
			  $datetime1 = $result['Leasing']['reception_date'];



              if($result['Leasing']['end_date']!=null) {

              $datetime2 =$result['Leasing']['end_date'];
                }else {

                  if(!empty($date_end)){
              $datetime2 = $date_end->format('Y-m-d');
                  }else {
                      $datetime2='';
                  }
              }

              $datetime1 = new DateTime ( $datetime1);
              $datetime2 = new DateTime ( $datetime2 );
              $interval = date_diff ( $datetime1, $datetime2 );
              if ($interval->d>=28) {
              $mois=1;
                }else $mois=0;
              $duree = $interval->y * 12 + $interval->m+ $mois ;
              echo $duree;  echo __('Month');
            ?> </td>
         <td><?php $km_global= $result['Leasing']['km_year']*($duree/12); echo number_format($km_global, 2, ",", ".");?></td>
         <td><?php echo h($result['Car']['km']);?></td>
         <td><?php echo h($result['Leasing']['cost_km']);?></td>
         <td><?php 
              $datetime1 = $result['Leasing']['reception_date'];
              $datetime2 = date('Y-m-d');
              $datetime1 = strtotime ( $datetime1);
              $datetime2 = strtotime ( $datetime2 );
              $nbJoursTimestamp = $datetime2 - $datetime1;
             
             $duree_s1 = $nbJoursTimestamp/86400;
              echo number_format($duree_s1, 2, ",", ".");
            
            ?></td>
         <td><?php 
                $duree_restante= ($duree*30)-$duree_s1; echo number_format($duree_restante, 2, ",", ".");
            ?></td>
         <td><?php $mois_ecoule=$duree_s1/30; echo number_format($mois_ecoule, 2, ",", ".");?></td>
         <td><?php $rest_contrat_mois=$duree_restante/30; echo number_format($rest_contrat_mois, 2, ",", ".");?></td>
         <td><?php if ($duree!=0){
	                    $km_mois=$km_global/$duree;
                            } else $km_mois=0;

                      echo number_format($km_mois, 2, ",", ".");?></td>
         <td><?php $km_restant=$km_global-$result['Car']['km'];  echo number_format($km_restant, 2, ",", ".");?></td>
         <td><?php $rest_mois_j=$km_mois*$rest_contrat_mois;  echo number_format($rest_mois_j, 2, ",", ".");?></td>
         <td><?php 

                        if($duree!=0)  {
	
                            $km_contractuel_date=($km_global/$duree)*$mois_ecoule;
                                }else $km_contractuel_date=0;
                            echo number_format($km_contractuel_date, 2, ",", ".");?></td>
         <td><?php $situation_date=$result['Car']['km']-$km_contractuel_date;  echo number_format($situation_date, 2, ",", ".");?></td>
         
         <td><?php if ($situation_date<0) {echo  0; } else { $value=$situation_date*$result['Leasing']['cost_km']; echo number_format($value, 2, ",", ".");}?></td>
         <td><?php echo h($result['Leasing']['amont_month']);?></td>
         <td><?php $km_estime=($result['Car']['km']/$mois_ecoule)*$duree; echo number_format($km_estime, 2, ",", ".");?></td>
         <td><?php $estimation_ecart=$km_estime-$km_global; echo number_format($estimation_ecart, 2, ",", ".");?></td>
         


         </tr>

        <?php } ?>




        
        
            
               
                
                    
          
                   
      
               
             
                    
                
           
            
        </tbody>
    </table>
            </div>
    </div>
    </div>
    </div>
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

            jQuery("#date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
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
           if(jQuery('#date').val()){
			  flotte_ald[0] = jQuery('#date').val(); 
			   
		   }else flotte_ald[0]= null;
            if(jQuery('#car').val()) {
				 flotte_ald[1] = jQuery('#car').val();
				
			}else {
				flotte_ald[1]= null;
			}
           
            //alert(flotte_ald[1]);
            
            var url = '<?php echo $this->Html->url(array('action' => 'exportFlotteAld'))?>';
            var form = jQuery('<form action="' + url + '" method="post" >' +
            '<input type="text" name="flotteald" value="' + flotte_ald + '" />' +
            '</form>');
            jQuery('body').append(form);
            form.submit();

       

    }
   

</script>
<?php $this->end(); ?>