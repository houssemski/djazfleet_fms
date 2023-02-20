<?php
if(__("Conductor") == "Customer"){
    ?><h4 class="page-title"> <?=__('Cost per car, customer and date'); ?></h4>
<?php }else{
    ?><h4 class="page-title"> <?=__('Cost per car, conductor and date');?></h4>
<?php }
?>
<div class="box-body">
    <div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
    <div class="card-box p-b-20">
    <?php echo $this->Form->create('Statistic', array(
        'url'=> array(
            'action' => 'costbycar'
        ),
        'novalidate' => true
    )); ?>
    <div class="filters" id='filters' style='display: block;'>
        <?php
        echo $this->Form->input('car_id', array(
                    'label' => __('Car'),
                    'class' => 'form-filter select2',
                    'empty' => '',
            'id' => 'car',
                    ));
        echo $this->Form->input('customer_id', array(
                    'label' => __("Conductor"),
                    'class' => 'form-filter select2',
                    'empty' => '',
            'id' => 'customer'
                    ));
        echo $this->Form->input('parc_id', array(
            'label' => __('Parc'),
            'class' => 'form-filter',
            'id' => 'parc',
            'type' => 'select',
            'options' => $parcs,
            'empty' => ''
        ));
        echo "<div style='clear:both; padding-top: 10px;'></div>";
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
                        /* array('action' => 'listcarparcsupplier_pdf', 'ext'=>'pdf'),*/
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
        <table class="table table-striped stats table-bordered" id='table_cost_car'>
            <thead style="width: auto">
            <th><?= __("Conductor") ?></th>
            <th><?= __('Car') ?></th>
            <th><?= __('Cost') ?></th>
            </thead>
            <tbody>
             <?php 
             foreach ($results as $result){
                 echo '<tr>';
                 echo '<td>';
                 echo $result[0]['driver'];
                 echo '</td>';
                 echo '<td>';
                 echo $result[0]['carName'];
                 echo '</td>';
                 echo '<td>';
                 echo $result[0]['sumcost'];
                 echo '</td>';
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

        jQuery("#startdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});


    });
    function exportDataPdf() {
        var costByCar = new Array();
        costByCar[0] = jQuery('#car').val();
        costByCar[1] = jQuery('#customer').val();
        costByCar[2] = jQuery('#startdate').val();
        costByCar[3] = jQuery('#enddate').val();
        costByCar[4] = jQuery('#parc').val();

        var url = '<?php echo $this->Html->url(array('action' => 'costByCarPdf', 'ext' => 'pdf'))?>';
        var form = jQuery('<form action="' + url + '" method="post" >' +
            '<input type="text" name="costByCar" value="' + costByCar + '" />' +
            '</form>');
        jQuery('body').append(form);
        form.submit();



    }

  function exportDataExcel() {

    $('#table_cost_car').tableExport({

        type: 'excel',
        espace: 'false',
        htmlContent:'false'
});
}
</script>
<?php $this->end(); ?>