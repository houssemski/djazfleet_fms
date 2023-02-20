<?php
?><h4 class="page-title"> <?=__('Cars insurances'); ?></h4>
<div class="box-body">
    <div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
    <div class="card-box p-b-20">
         <?php echo $this->Form->create('Statistic', array(
             'url'=> array(
                 'action' => 'carinsurance'
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
                   'before' => '<label class="dte">'.__('Year').'</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                   'after' => '</div>',
                   'id' => 'year',
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
                       
                        'javascript:exportDataExcel();',
                         array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id'=>'export_excel')) ?>


                </div>
                 <div class="btn-group">
                    <?= $this->Html->link('<i class="glyphicon glyphicon-export"></i>' . __('Export Pdf'),

                        'javascript:exportDataPdf();',
                         array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id'=>'export')) ?>


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
    
            <table class="table table-striped table-bordered" id='table_assurance'>
            <thead style="width: auto">
            <th><?= __('Assurance number') ?></th>
            <th><?= __('Star date') ?></th>
            <th><?= __('End date') ?></th>
            <th><?= __('Cost') ?></th>
            </thead>
            <tbody>
            <?php
            if(!empty($results)){
                
                $nbAssurance = array ();
                $starDates = array();
                $endDates = array();
                $cost = array();
                $i=0; 
                $j=0;
                $currentCar = $results[0]['car']['id'];
                foreach ($results as $result) {
                    $i++;
                    if($result['car']['id'] == $currentCar)


                    {

                      if ($param==1){
                         $car_name = $result['car']['code']." - ".$result['carmodels']['name']; 
                         } else if ($param==2) {
                         $car_name = $result['car']['immatr_def']." - ".$result['carmodels']['name']; 
                            } 

                        
                        
                       if (isset($result['event']['assurance_number']) && !empty($result['event']['assurance_number'])){
                       $nbAssurance[] = $result['event']['assurance_number'];
                        }else $nbAssurance[] ='/';
                        
                        if (isset($result['event']['date']) && !empty($result['event']['date'])){
                        $starDates[] = $result['event']['date'];
                        }else $starDates[] ='/';

                        if (isset($result['event']['next_date']) && !empty($result['event']['next_date'])){
                        $endDates[] = $result['event']['next_date'];
                        }else $endDates[] ='/';
                        if (isset($result['event']['cost']) && !empty($result['event']['cost'])){
                        $cost[] = $result['event']['cost'];
                        } else $cost[] ='/';
                        
                    }else
                    {
                        $j++;
                        echo "<tr style='width: auto;'>" .
                        "<td colspan='6' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
background-color: rgba(16, 196, 105, 0.15) !important;
color: #10c469 !important;font-weight:bold;'>"
                        . $car_name . "</td></tr>";
                        
                        echo "<td><table>";
                        foreach($nbAssurance as $nbAssurance){
                            echo "<tr><td>".$nbAssurance."</td></tr>";
                        }
                        echo "</table></td>";
                        
                        echo "<td><table>";
                        foreach($starDates as $stardate){
                            echo "<tr><td>".$this->Time->format($stardate, '%d-%m-%Y ')."</td></tr>";
                        }
                        echo "</table></td>";
                        echo "<td><table>";
                        foreach($endDates as $enddate){
                            echo "<tr><td>".$this->Time->format($enddate, '%d-%m-%Y ')."</td></tr>";
                        }
                        echo "</table></td>";
                       
                        echo "<td><table>";
                        foreach($cost as $cost){
                            echo "<tr><td>".$cost."</td></tr>";
                        }
                        echo "</table></td>";
                        
                        // Next item
                        
                        
                        $nbAssurance = array ();
                        $starDates = array();
                        $endDates = array();
                        $cost = array();
                        
                          if ($param==1){
                         $car_name = $result['car']['code']." - ".$result['carmodels']['name']; 
                         } else if ($param==2) {
                         $car_name = $result['car']['immatr_def']." - ".$result['carmodels']['name']; 
                            } 
                        
                        
                        if (isset($result['event']['assurance_number']) && !empty($result['event']['assurance_number'])){
                       $nbAssurance[] = $result['event']['assurance_number'];
                        }else $nbAssurance[] ='/';
                        
                        if (isset($result['event']['date']) && !empty($result['event']['date'])){
                        $starDates[] = $result['event']['date'];
                        }else $starDates[] ='/';

                        if (isset($result['event']['next_date']) && !empty($result['event']['next_date'])){
                        $endDates[] = $result['event']['next_date'];
                        }else $endDates[] ='/';
                        if (isset($result['event']['cost']) && !empty($result['event']['cost'])){
                        $cost[] = $result['event']['cost'];
                        }else $cost[] ='/';
                        $currentCar = $result['car']['id'];
                    }
                    if($i == count($results))
                    {
                        $j++;
                        echo "<tr style='width: auto;'>" .
                        "<td colspan='6' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
background-color: rgba(16, 196, 105, 0.15) !important;
color: #10c469 !important;font-weight: bold;'>"
                        . $result['carmodels']['name'] . "</td></tr>";
                        
                        echo "<td><table>";
                        foreach($nbAssurance as $nbAssurance){
                            echo "<tr><td>".$nbAssurance."</td></tr>";
                        }
                        echo "</table></td>";
                        
                        echo "<td><table>";
                        foreach($starDates as $stardate){
                            echo "<tr><td>".$this->Time->format($stardate, '%d-%m-%Y ')."</td></tr>";
                        }
                        echo "</table></td>";
                        echo "<td><table>";
                        foreach($endDates as $enddate){
                            echo "<tr><td>".$this->Time->format($enddate, '%d-%m-%Y ')."</td></tr>";
                        }
                        echo "</table></td>";

                        echo "<td><table>";
                        foreach($cost as $cost){
                            echo "<tr><td>".$cost."</td></tr>";
                        }
                        echo "</table></td>";



                        
                      
                    }
                }
            }
            ?>
            </tbody>
        </table>

      </div>
      </div>
      </div>



<!--    <table class="table stats table-bordered">

        
        <thead>

            <th><?= __('Car') ?></th>
            <th><?= __('Start date ')?></th>
            <th><?= __('End date')?></th>
            
        </thead>
        <tbody>
            
               
                
                    
          
                        <tr>

                        <td> <?php if ($param==1){
                         echo $result['car']['code']." - ".$result['carmodels']['name']; 
                         } else if ($param==2) {
                         echo $result['car']['immatr_def']." - ".$result['carmodels']['name']; 
                            } ?></td>
                            
                            <td> <?php echo $datestar ?></td>
                            <td> <?php echo $dateend ?></td>

      
               
             
                    
                
           
            
        </tbody>
    </table> ---->

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

            jQuery("#year").inputmask("y", { "placeholder": "yyyy" });
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

    $('#table_assurance').tableExport({

        type: 'excel',
        espace: 'false',
        htmlContent:'false'
});


}
   

</script>
<?php $this->end(); ?>