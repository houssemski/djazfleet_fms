<?php

    ?><h4 class="page-title"> <?=__('Sales turnover per conductor and per year');?></h4>
 ?>
<div class="box-body">
    <div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
        <div class="card-box p-b-20">
    <?php echo $this->Form->create('Statistic', array(
    'url'=> array(
        'action' => 'salesturnover'
    ),
    'novalidate' => true
)); ?>
    <div class="filters" id='filters' style='display: block;'>
        <?php
        echo $this->Form->input('customer_id', array(
                    'label' => __("Conductor"),
                    'class' => 'form-filter select2',
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
		<div class="btn-group pull-left">
            <div class="header_actions">
                  <div class="btn-group">
                    <?= $this->Html->link('<i class="glyphicon glyphicon-export"></i>' . __('Export Excel'),
                       
                        'javascript:exportDataExcel();',
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
        <table class="table table-striped stats table-bordered" id='table_sales'>
            <thead style="width: auto">
            <th><?= __("Conductor") . " " . __('/ Year') ?></th>
         <?php 
             for($j=0; $j<count($lines); $j++){
                 echo "<th>" . $lines[$j]['customers']['first_name'] . " " . $lines[$j]['customers']['last_name'] 
                         . " " . $lines[$j]['customers']['company']  . "</th>";
             }
         ?>
            </thead>
            <tbody>
             <?php 
             for($j=0; $j<count($columns); $j++){
                 echo "<tr style='width: auto'><td>" . $columns[$j][0]['year']  . "</td>";
                 for($i=0; $i<count($lines); $i++){
                     $found = false;
                     foreach ($results as $result){
                         if($result[0]['year'] == $columns[$j][0]['year'] && 
                                 $result['customer_car']['customer_id'] == $lines[$i]['customer_car']['customer_id']){
                             echo "<td class='right'>" . $result[0]['sumcost'] . "</td>";
                             $found = true;
                         }
                     }
                     if(!$found){
                             echo "<td>0</td>";
                         }
                }
                echo "</tr>";
             }
            ?>
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
<?= $this->Html->script('tableExport/tableExport'); ?>
    <?= $this->Html->script('tableExport/jquery.base64'); ?>
    <?= $this->Html->script('tableExport/html2canvas'); ?>
    <?= $this->Html->script('tableExport/jspdf/jspdf'); ?>
    <?= $this->Html->script('tableExport/jspdf/libs/sprintf'); ?>
    <?= $this->Html->script('tableExport/jspdf/libs/base64'); ?>
<!-- Page script -->
<script type="text/javascript">

$(document).ready(function() {
   jQuery("#year").inputmask("y", {"placeholder": "yyyy"});
   });


     function exportDataExcel() {

    $('#table_sales').tableExport({

        type: 'excel',
        espace: 'false',
        htmlContent:'false'
});
}
</script>
<?php $this->end(); ?>