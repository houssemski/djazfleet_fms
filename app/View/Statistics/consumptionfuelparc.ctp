<?php

?><h4 class="page-title"> <?=__('Consumption parcs, fuels'); ?></h4>
<div class="box-body">
    <div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
    <div class="card-box p-b-20">
    <?php echo $this->Form->create('Statistic', array(
        'url'=> array(
            'action' => 'consumptionfuelparc'
        ),
        'novalidate' => true
    )); ?>
    <div class="filters" id='filters' style='display: block;'>
        <?php
        echo $this->Form->input('fuel_id', array(
                    'label' => __('Fuel'),
                    'class' => 'form-filter select2',
                    'id'=>'fuel',
                    'empty' => ''
                    ));
        echo $this->Form->input('parc_id', array(
                    'label' =>('Parc'),
                    'class' => 'form-filter select2',
                    'id'=>'parc',
                    'empty' => ''
                    ));
        ?>
         <div style='clear:both; padding-top: 10px;'></div>
        <?php
        echo $this->Form->input('date', array(
                 'label' => '',
                 'type' => 'text',
                 'class' => 'form-control datemask',
                 'before' => '<label class="dte">'.__('Start').'</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                 'after' => '</div>',
                 'id' => 'startdate',
                 ));
        echo $this->Form->input('next_date', array(
                    'label' => '',
                    'type' => 'text',
                    'class' => 'form-control datemask',
                    'before' => '<label class="dte">'.__('End').'</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'enddate',
                    ));
        
        ?>
        <div style='clear:both; padding-top: 5px;'></div>
        <button style="float: right;" class="btn btn-success btn-trans waves-effect w-md waves-success" type="submit"><?= __('Search') ?></button>
        <div style='clear: both; padding-top: 10px;'></div>
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
                         /*array('action' => 'listcarparcsupplier_pdf', 'ext'=>'pdf'),*/
                        'javascript:exportDataPdf(); ',
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

            <table class="table table-striped table-bordered" id='table_fuel_parc'>
            <thead style="width: auto">
            <th><?= __('Fuel') ?></th>
            <th><?= __('Tank ') ?></th>
            <th><?= __('Cost tank') ?></th>
            
            </thead>
            <tbody>
            <?php
            foreach ($parcs as $key => $value) {
                if ($results) {
                    foreach ($results as $result) {
                        if ($result['parcs'] == $key) {
                            echo "<tr style='width: auto;'>" .
                            "<td colspan='10' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
background-color: rgba(16, 196, 105, 0.15) !important;
color: #10c469 !important;font-weight:bold;'>"
                            . $value . "</td></tr>";
                            $totalcostTank=0;
                            for ($i = 1; $i <= 6; $i++) {
                              
                                if (isset($result[$i]['fuelid']) && $result[$i]['fuelid'] == $i) {
                                   
                                    $totalcostTank=$totalcostTank+$result[$i]['costTank'];
                                    
                                    echo "<tr><td>" . $result[$i]['fuels'] . "</td>";
                                    
                                    echo "<td class='right'>" . number_format($result[$i]['sumTank'], 2, ",", ".") .
                                    "</td>";
                                    echo "<td class='right'>" . number_format($result[$i]['costTank'], 2, ",", ".") .
                                    
                                    "</td></tr>";
                                }
                            } ?>
                           <tr style='width: auto;'> <td colspan='10' style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>".__('Total Cost tank  ')."</span>" .$totalcostTank; ?></td></tr>
                          <?php  
                           
                        }
                    }
                }
            }
            ?>
            </tbody>
        </table>

    </div>
    </div>
    </div>
  <!---  <table class="table stats table-bordered">

        
        <thead>

            <th><?= __('Parc') ?></th>
           
            <th><?= __('Fuel') ?></th>
            <th><?= __('Cost') ?></th>
        </thead>
        <tbody>
            
                <?php 
                foreach ($results as $result){?>
                <tr>

               
                <td><?php echo  $result['parcs']['name']?></td>
                    
                <td><?php echo  $result['fuels']['name']?></td>
                <td><?php echo  $result[0]['depenses']?></td>

</tr>
                <?php     }
                
                
                
                
                ?>
            
        </tbody>
    </table>  --->

    <?php $this->start('script'); ?>
    <!-- InputMask -->
    <?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
    <?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
    <?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
     <?= $this->Html->script('tableExport/tableExport'); ?>
    <?= $this->Html->script('tableExport/jquery.base64'); ?>

    <?= $this->Html->script('tableExport/html2canvas'); ?>
    <?= $this->Html->script('tableExport/jspdf/jspdf'); ?>
    <?= $this->Html->script('tableExport/jspdf/libs/sprintf'); ?>
    <?= $this->Html->script('tableExport/jspdf/libs/base64'); ?>
    <!-- Page script -->
    <script type="text/javascript">

        $(document).ready(function() {

            jQuery("#startdate").inputmask("dd/mm/yyyy", { "placeholder": "dd/mm/yyyy" });
            jQuery("#enddate").inputmask("dd/mm/yyyy", { "placeholder": "dd/mm/yyyy" });


        });
        


        function exportDataPdf() {
            var parc_fuel = new Array();
            parc_fuel[0] = jQuery('#parc').val();
            parc_fuel[1] = jQuery('#fuel').val();
            parc_fuel[2] = jQuery('#startdate').val();
            parc_fuel[3] = jQuery('#enddate').val();
            var url = '<?php echo $this->Html->url(array('action' => 'consumptionfuelparc_pdf', 'ext' => 'pdf'))?>';
            var form = jQuery('<form action="' + url + '" method="post" >' +
            '<input type="text" name="parcfuel" value="' + parc_fuel + '" />' +
            '</form>');
            jQuery('body').append(form);
            form.submit();

       

    }
  function exportDataExcel() {

    $('#table_fuel_parc').tableExport({

        type: 'excel',
        espace: 'false',
        htmlContent:'false'
});
 }  
</script>
<?php $this->end(); ?>