
<style>
    .flot-x-axis div{max-width: 100% !important;width: auto !important;transform: rotate(-90deg) !important;top: 340px !important;}
    .content {
        overflow: hidden;
    }
</style>
<?php
$this->start('css');


echo $this->Html->css('select2/select2.min');
$this->end();

?>

<h4 class="page-title"> <?=__('Creance by supplier'); ?></h4>
<div class="box-body">

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-20">
                <?php echo $this->Form->create('Statistic', array(
                    'url'=> array(
                        'action' => 'creanceBySupplier'
                    ),
                    'novalidate' => true
                )); ?>
                <div class="filters" id='filters' style='display: block;'>
                    <?php
                    echo $this->Form->input('supplier_id', array(
                        'label' => __('Client'),
                        'class' => 'form-filter select2',
                        'id' => 'client',
                        'empty' => ''
                    ));?>

                    <div style='clear:both; padding-top: 5px;'></div>
                    <button style="float: right;" class="btn btn-success btn-trans waves-effect w-md waves-success " type="submit"><?= __('Search') ?></button>

                </div>
                <?php echo $this->Form->end(); ?>

            </div>
        </div>
    </div>

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
			   <?php
                echo "<b  id='totalB' >".__('Total :  ')."</b> <br> ";
                echo "<b  id='reglementB'>".__('Règlement :  ')."</b> <br> ";
                echo "<b  id='resteB'>".__('Reste à payer :  ')."</b>  "; ?>
                <table class="table table-striped table-bordered dt-responsive nowrap"
                       cellspacing="0" width="100%" id='table_consumption'>
                    <thead style="width: auto">
                    <th><?= __('Price') ?></th>
                    <th><?= __('Payment') ?></th>
                    <th><?= __('Amount remaining') ?></th>


                    </thead>
                    <tbody>

                    <?php
                    $sumPrice=0;
                    $sumReglement = 0;
                    $sumAmountRemaining =0;
                    if(!empty($supplierId)){



                        echo "<tr style='width: auto;'>" .
                            "<td colspan='14' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
background-color: rgba(16, 196, 105, 0.15) !important;
color: #10c469 !important;font-weight:bold;'>"
                            . $prices[$supplierId]['supplier_name'] . "</td></tr>";
                        if(isset($prices[$supplierId]['price'])){
                            echo "<tr><td>" . number_format($prices[$supplierId]['price'], 2, ",", "."). " " . $this->Session->read("currency") ."</td>";
                        }else {
                            echo "<tr><td>" . number_format(0, 2, ",", "."). " " . $this->Session->read("currency") ."</td>";
                            $prices[$supplierId]['price'] =0;
                        }
                        if(isset($reglements[$supplierId]['amount'])){
                            echo "<td>" . number_format($reglements[$supplierId]['amount'], 2, ",", "."). " " . $this->Session->read("currency") ."</td>";
                        }else {
                            echo "<td>" . number_format(0, 2, ",", "."). " " . $this->Session->read("currency") ."</td>";
                            $reglements[$supplierId]['amount'] = 0;
                        }
                        $amountRemaining = $prices[$supplierId]['price'] - $reglements[$supplierId]['amount'];
                        echo "<td>" . number_format($amountRemaining, 2, ",", "."). " " . $this->Session->read("currency") ."</td></tr>";
                        $sumPrice = $sumPrice+  $prices[$supplierId]['price'];
                        $sumReglement = $sumReglement+  $reglements[$supplierId]['amount'];
                        $sumAmountRemaining = $sumAmountRemaining+  $amountRemaining;


                    }else {


                    foreach ($arraySuppliers as $supplier) {
                        $supplierId = $supplier['Supplier']['id'];


                                    echo "<tr style='width: auto;'>" .
                                        "<td colspan='14' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
background-color: rgba(16, 196, 105, 0.15) !important;
color: #10c469 !important;font-weight:bold;'>"
                                        . $supplier['Supplier']['name'] . "</td></tr>";
                        if(isset($prices[$supplierId]['price'])){
                            echo "<tr><td>" . number_format($prices[$supplierId]['price'], 2, ",", "."). " " . $this->Session->read("currency") ."</td>";
                        }else {
                        echo "<tr><td>" . number_format(0, 2, ",", "."). " " . $this->Session->read("currency") ."</td>";
                            $prices[$supplierId]['price'] = 0;
                        }
                        if(isset($reglements[$supplierId]['amount'])){
                            echo "<td>" . number_format($reglements[$supplierId]['amount'], 2, ",", "."). " " . $this->Session->read("currency") ."</td>";
                        }else {
                            echo "<td>" . number_format(0, 2, ",", "."). " " . $this->Session->read("currency") ."</td>";
                            $reglements[$supplierId]['amount'] = 0;
                        }
                        $amountRemaining = $prices[$supplierId]['price'] - $reglements[$supplierId]['amount'];
                        echo "<td>" . number_format($amountRemaining, 2, ",", "."). " " . $this->Session->read("currency") ."</td></tr>";
                        $sumPrice = $sumPrice+  $prices[$supplierId]['price'];
                        $sumReglement = $sumReglement+  $reglements[$supplierId]['amount'];
                        $sumAmountRemaining = $sumAmountRemaining+  $amountRemaining;
                    }

                    }
                    ?>



                    </tbody>
                </table>
                <br/><br/>
                <?php

                echo "<b style='float:left ; line-height:35px'>".__('Total :  ')."</b> &nbsp <b style='color:#10c469; ; line-height:35px'>"  .number_format($sumPrice, 2, ",", "."). " " .$this->Session->read("currency")."</b><br> ";
                echo "<b style='float:left ; line-height:35px'>".__('Règlement :  ')."</b> &nbsp <b style='color:#10c469; ; line-height:35px'>"  .number_format($sumReglement, 2, ",", "."). " " .$this->Session->read("currency")."</b><br> ";
                echo "<b style='float:left ; line-height:35px'>".__('Reste à payer :  ')."</b> &nbsp <b style='color:#10c469; ; line-height:35px'>"  .number_format($sumAmountRemaining, 2, ",", "."). " " .$this->Session->read("currency")."</b> ";
				 echo "<div class='form-group'>".$this->Form->input('total', array(          
                    'type'=>'hidden',
                    'value'=>$sumPrice,
                    'class' => 'form-control',
					'id'=>'total'
                    ))."</div>";
					
					 echo "<div class='form-group'>".$this->Form->input('reglement', array(
                    'type'=>'hidden',
                    'value'=>$sumReglement,
                    'class' => 'form-control',
					'id'=>'reglement'
                    ))."</div>";
					
					 echo "<div class='form-group'>".$this->Form->input('reste', array(
                    'type'=>'hidden',
                    'value'=>$sumAmountRemaining,
                    'class' => 'form-control',
					'id'=>'reste'
                    ))."</div>";
				
				?>

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

<!-- Bootstrap -->

<!-- FLOT CHARTS -->
<?= $this->Html->script('plugins/flot/jquery.flot.min'); ?>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<?= $this->Html->script('plugins/flot/jquery.flot.resize.min'); ?>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<?= $this->Html->script('plugins/flot/jquery.flot.pie.min'); ?>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<?= $this->Html->script('plugins/flot/jquery.flot.categories.min'); ?>
<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>
<!-- Page script -->
<script type="text/javascript">


    $(document).ready(function() {

        jQuery("#startdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#min_month").inputmask("m", {"placeholder": "mm"});
        jQuery("#max_month").inputmask("m", {"placeholder": "mm"});
        $(".select2").select2({
            sorter: function (data) {
                /* Sort data using lowercase comparison */
                return data.sort(function (a, b) {
                    a = a.text.toLowerCase();
                    b = b.text.toLowerCase();
                    if (a > b) {
                        return 1;
                    } else if (a < b) {
                        return -1;
                    }
                    return 0;
                });
            },
            allowDuplicates: true

        });
		var sumPrice = jQuery('#total').val();
		var reglement = jQuery('#reglement').val();
		var reste = jQuery('#reste').val();
		jQuery('#totalB').html( "<b style='float:left ; line-height:35px' id='totalB' ><?php echo __('Total :  ')?></b><b style='color:#10c469; ; line-height:35px'> " + sumPrice + "<?php echo $this->Session->read("currency") ?></b>");
		jQuery('#reglementB').html( "<b style='float:left ; line-height:35px' id='reglementB' ><?php echo ('Règlement :  ')?></b><b style='color:#10c469; ; line-height:35px'> " + reglement + "<?php echo $this->Session->read("currency") ?></b>");
		jQuery('#resteB').html( "<b style='float:left ; line-height:35px' id='resteB' ><?php echo __('Reste à payer :  ')?></b><b style='color:#10c469; ; line-height:35px'> " + reste + "<?php echo $this->Session->read("currency") ?></b><br>");

    });

    function exportDataPdf() {
        var consumption_month = new Array();
        consumption_month[0] = jQuery('#car').val();
        consumption_month[1] = jQuery('#year').val();
        consumption_month[2] = jQuery('#min_month').val();
        consumption_month[3] = jQuery('#max_month').val();

        var url = '<?php echo $this->Html->url(array('action' => 'consumptionbymonth_pdf', 'ext' => 'pdf'))?>';
        var form = jQuery('<form action="' + url + '" method="post" >' +
        '<input type="text" name="consumptionmonth" value="' + consumption_month + '" />' +
        '</form>');
        jQuery('body').append(form);
        form.submit();



    }

    function exportDataExcel() {

        $('#table_consumption').tableExport({

            type: 'excel',
            espace: 'false',
            htmlContent:'false'
        });

    }








</script>
<?php $this->end(); ?>