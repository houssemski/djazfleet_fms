<?php

?><h4 class="page-title"> <?=__('Km date'); ?></h4>
<div class="box-body">
    <div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
    <div class="card-box p-b-20">
         <?php echo $this->Form->create('Statistic', array(
             'url'=> array(
                 'action' => 'kmDate'
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
         echo $this->Form->input('year', array(
                'label' => '',
                'type' => 'text',
                'class' => 'form-control datemask',
                'before' => '<label class="dte">' . __('Year') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                'after' => '</div>',
                'id' => 'year',
            )); ?>

            <div style='clear:both; padding-top: 10px;'></div>
            <?php
         echo $this->Form->input('acquisition_type_id', array(
                    'label' => __('Acquisition type'),
                    'class' => 'form-filter select2',
                    'type' =>'select',
                   
                    'options'=> array('2'=>__('Rental'), '1'=>__('Purchase')),
                    'id'=>'acquisition',
                    'empty' => ''
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
    
            <table class="table table-bordered" id='table_flotte_ald'>
            <thead style="width: auto">
            <?php $year_1=$year-1;?>
            <th><?= __('Mark') ?></th>
            <th><?= __('Model') ?></th>
         <?php if($acquisition_type_id=='1'){ ?>

            <th><?= __('Chassis') ?></th>
            <th><?= __('Final registration') ?></th>
            <th><?= __('Reception date') ?></th>
            
            <th><?= __('Purchasing price') ?></th>
            <?php }?>
           
            <th><?= __('Department') ?></th>
            <th><?= __('Customer') ?></th>
            <th><?= __('Zone') ?></th>
            <th><?= __('Km annual') ?></th>
            <th><?= __('Total ').  $year_1?></th>
            <th><?= __("January") ?></th>
            <th><?= __("February") ?></th>
            <th><?= __("March") ?></th>
            <th><?= __("April") ?></th>
            <th><?= __("May") ?></th>
            <th><?= __("June") ?></th>
            <th><?= __("July") ?></th>
            <th><?= __("August")?></th>
            <th><?= __("September") ?></th>
            <th><?= __("October") ?></th>
            <th><?= __("November") ?></th>
            
            <th><?= __("December") ?></th>
            <th><?= __('Total') ?></th>
            <th><?= __('Average daily') ?></th>
            <th><?= __('Average/ Month') ?></th>
            <th><?= __('Km ').$year ?></th>
            <th><?= __('----') ?></th>
            <th><?= __('Rental/ Purchase') ?></th>
            </thead>
            <tbody>
            
 
            
       

         <?php 

            $lenght=count($results);
           
            for ($i=0; $i<$lenght; $i++) { 
           
            if(!empty($results[$i+1]['Car']['id']) && ($results[$i]['Car']['id']==$results[$i+1]['Car']['id'])){
                
                ?>

         <tr>
         <td><?php echo $results[$i]['Mark']['name'] ?></td>
         <td><?php echo $results[$i]['Carmodel']['name'] ?></td>
           <?php if($acquisition_type_id=='1'){ ?>

            <th><?= $results[$i]['Car']['chassis'] ?></th>
            <th><?= $results[$i]['Car']['immatr_def'] ?></th>
            <th><?= $results[$i]['Car']['reception_date']?></th>
            
            <th><?= $results[$i]['Car']['purchasing_price']?></th>
            <?php }?>
    
         <td><?php echo $results[$i]['Department']['name']?></td>
         <td><?php echo $results[$i]['Customer']['first_name']." - ".$results[$i]['Customer']['last_name']?></td>
         <td><?php echo $results[$i]['Zone']['name']?></td>
         <td><?php echo $results[$i]['Leasing']['km_year']?></td>
         <td><?php   
                $total_year_1=0;
                for($k=1; $k<=12; $k++){
                
              $total_year_1=  $total_year_1+$results[$i]['Monthlykm']['km_'.$k];
			  }
              echo $total_year_1;
            ?> </td>
            <?php  

            $total_year=0;
            $total=0;
            $m=0;
            for($k=1; $k<=12; $k++){?>
         <td><?php echo $results[$i+1]['Monthlykm']['km_'.$k];
                 if($results[$i+1]['Monthlykm']['km_'.$k]!=0) $m++; 
                
                $total_year=$total_year+$results[$i+1]['Monthlykm']['km_'.$k];

            ?></td>
                
         <?php }?>
         <td><?php $total=$total_year+$total_year_1; echo h($total);?></td>
         <td><?php if($m>0) {$moy_d=$total_year/$m; echo number_format($moy_d, 2, ",", ".");}?></td>
         <td><?php if($total>0) {$moy_m=$total/12; echo number_format($moy_m, 2, ",", ".");}?></td>
         <td><?php  echo ($total_year);?></td>
        <td><?php  echo (0-$total);?></td>
        <td> <?php if ($results[$i]['Leasing']['acquisition_type_id']==2 ||$results[$i]['Leasing']['acquisition_type_id']==3) echo __('Rental');

                     if ($results[$i]['Car']['acquisition_type_id']==1 ) echo __('Purchase');

                ?></td>


         </tr>

        <?php $i++; }

        else {
       if ($results[$i]['Monthlykm']['year']==$year){
       
        ?>

         <tr>
         <td><?php echo $results[$i]['Mark']['name'] ?></td>
         <td><?php echo $results[$i]['Carmodel']['name'] ?></td>
          <?php if($acquisition_type_id=='1'){ ?>

            <th><?= $results[$i]['Car']['chassis'] ?></th>
            <th><?= $results[$i]['Car']['immatr_def'] ?></th>
            <th><?= $results[$i]['Car']['reception_date']?></th>
            
            <th><?= $results[$i]['Car']['purchasing_price']?></th>
            <?php }?>
         <td><?php echo $results[$i]['Department']['name']?></td>
         <td><?php echo $results[$i]['Customer']['first_name']." - ".$results[$i]['Customer']['last_name']?></td>
         <td><?php echo $results[$i]['Zone']['name']?></td>
         <td><?php echo $results[$i]['Leasing']['km_year']?></td>
         <td><?php   
                $total_year_1=0;
                
              echo $total_year_1;
            ?> </td>
            <?php  

            $total_year=0;
            $total=0;
            $m=0;
            for($k=1; $k<=12; $k++){?>
         <td><?php echo $results[$i]['Monthlykm']['km_'.$k];
                 if($results[$i]['Monthlykm']['km_'.$k]!=0) $m++; 
                 
                $total_year=$total_year+$results[$i]['Monthlykm']['km_'.$k];

            ?></td>
                
         <?php }?>
         <td><?php $total=$total_year+$total_year_1; echo h($total);?></td>
         <td><?php if($m>0) {$moy_d=$total_year/$m; echo number_format($moy_d, 2, ",", ".");}?></td>
         <td><?php if($total>0) {$moy_m=$total/12; echo number_format($moy_m, 2, ",", ".");}?></td>
         <td><?php  echo ($total_year);?></td>
        <td><?php  echo (0-$total);?></td>
          <td> <?php if ($results[$i]['Leasing']['acquisition_type_id']==2 ||$results[$i]['Leasing']['acquisition_type_id']==3) echo __('Rental');

                     if ($results[$i]['Car']['acquisition_type_id']==1 ) echo __('Purchase');

                ?></td>


         </tr>

         <?php
       

                } else if($results[$i]['Monthlykm']['year']==$year_1) {


                 ?>
    <tr>
         <td><?php echo $results[$i]['Mark']['name'] ?></td>
         <td><?php echo $results[$i]['Carmodel']['name'] ?></td>
      <?php if($acquisition_type_id=='1'){ ?>

            <th><?= $results[$i]['Car']['chassis'] ?></th>
            <th><?= $results[$i]['Car']['immatr_def'] ?></th>
            <th><?= $results[$i]['Car']['reception_date']?></th>
            
            <th><?= $results[$i]['Car']['purchasing_price']?></th>
            <?php }?>
         <td><?php echo $results[$i]['Department']['name']?></td>
         <td><?php echo $results[$i]['Customer']['first_name']." - ".$results[$i]['Customer']['last_name']?></td>
         <td><?php echo $results[$i]['Zone']['name']?></td>
         <td><?php echo $results[$i]['Leasing']['km_year']?></td>
         <td><?php   
                $total_year_1=0;
                for($k=1; $k<=12; $k++){
                
              $total_year_1=  $total_year_1+$results[$i]['Monthlykm']['km_'.$k];
			  }
              echo $total_year_1;
            ?> </td>
            <?php  

            $total_year=0;
            $total=0;
            $m=0;
          
             for($k=1; $k<=12; $k++){
            ?>
         <td><?php 

                
                echo 0; 

               
            ?></td>
                
         <?php } ?>
         <td><?php $total=$total_year+$total_year_1; echo h($total);?></td>
         <td><?php if($m>0) {$moy_d=$total_year/$m; echo number_format($moy_d, 2, ",", ".");}?></td>
         <td><?php if($total>0) {$moy_m=$total/12; echo number_format($moy_m, 2, ",", ".");}?></td>
         <td><?php  echo ($total_year);?></td>
        <td><?php  echo (0-$total);?></td>
          <td> <?php if ($results[$i]['Leasing']['acquisition_type_id']==2 ||$results[$i]['Leasing']['acquisition_type_id']==3) echo __('Rental');

                     if ($results[$i]['Car']['acquisition_type_id']==1 ) echo __('Purchase');

                ?></td>


         </tr>
  

         <?php




}

        }
                }

?>




        
        
            
               
                
                    
          
                   
      
               
             
                    
                
           
            
        </tbody>
    </table> 
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
    <script type="text/javascript">

        $(document).ready(function() {

            jQuery("#year").inputmask("y", {"placeholder": "yyyy"});
        });

    





        function exportDataPdf() {
            var car_year = new Array();
            car_year[0] = jQuery('#year').val();
            car_year[1] = jQuery('#car').val();
            car_year[2] = jQuery('#car').val();
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
            var km_date = new Array();
           if(jQuery('#year').val()){
			  km_date[0] = jQuery('#year').val(); 
			   
		   }else km_date[0]= null;

            if(jQuery('#car').val()) {
				 km_date[1] = jQuery('#car').val();
				
			}else {
				km_date[1]= null;
			}

            if(jQuery('#acquisition').val()) {
				 km_date[2] = jQuery('#acquisition').val();
				
			}else {
				km_date[2]= null;
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