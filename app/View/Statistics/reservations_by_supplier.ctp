
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

<h4 class="page-title"> <?=__('Reservation per supplier'); ?></h4>
<div class="box-body">

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-20">
                <?php echo $this->Form->create('Statistic', array(
                    'url'=> array(
                        'action' => 'reservationsBySupplier'
                    ),
                    'novalidate' => true
                )); ?>
                <div class="filters" id='filters' style='display: block;'>
                    <?php
                    echo $this->Form->input('car_id', array(
                        'label' => __('Car'),
                        'class' => 'form-filter select2',
                        'id' => 'car',
                        'empty' => ''
                    ));

                    echo $this->Form->input('supplier_id', array(
                        'label' => __('Client'),
                        'class' => 'form-filter select2',
                        'id' => 'client',
                        'empty' => ''
                    ));?>
                    <div style='clear:both; padding-top: 10px;'></div>
                    <?php   echo $this->Form->input('year', array(
                        'label' => '',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'before' => '<label class="dte">' . __('Year') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                        'after' => '</div>',
                        'id' => 'year',
                    ));

                    echo $this->Form->input('min_month', array(
                        'label' => '',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'before' => '<label class="dte">' . __('From') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                        'after' => '</div>',
                        'id' => 'min_month',
                    ));
                    echo $this->Form->input('max_month', array(
                        'label' => '',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'before' => '<label class="dte">' . __('To') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                        'after' => '</div>',
                        'id' => 'max_month',
                    ));
                    ?>
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
                <table class="table table-striped table-bordered dt-responsive nowrap"
                       cellspacing="0" width="100%" id='table_consumption'>
                    <thead style="width: auto">
                    <th><?php echo __('Reference'); ?></th>
                    <th><?php echo __('Supplier'); ?></th>
                    <th><?php echo __('Car'); ?></th>
                    <th><?php echo __('Cost'); ?></th>
                    <th><?php echo __('Amount remaining'); ?></th>
                    <th><?php echo __('Start date'); ?></th>
                    <th><?php echo __('End date'); ?></th>

                    </thead>
                    <tbody>
                    <?php
                    $totalCost=null;
                    $totalAmountRemaining=null;

                 foreach ($results as $result): ?>
                        <tr >

                            <td><?php echo h($result['sheet_ride_detail_rides']['reference']); ?></td>
                            <td><?php echo h($result['suppliers']['name']); ?>&nbsp;</td>
                            <td><?php if ($param == 1) {
                                    echo $result['car']['code'] . " - " . $result['carmodels']['name'];
                                } else if ($param == 2) {
                                    echo $result['car']['immatr_def'] . " - " . $result['carmodels']['name'];
                                } ?></td>
                            <td><?php echo h(number_format($result['reservations']['cost'], 2, ",", $separatorAmount)) ?></td>
                            <td><?php echo h(number_format($result['reservations']['amount_remaining'], 2, ",", $separatorAmount)) ?></td>


                            <td><?php if (!empty($result['sheet_ride_detail_rides']['real_start_date'])) {
                                    echo h($this->Time->format($result['sheet_ride_detail_rides']['real_start_date'], '%d-%m-%Y %H:%M'));
                                } else {
                                    echo h($this->Time->format($result['sheet_ride_detail_rides']['planned_start_date'], '%d-%m-%Y %H:%M'));
                                } ?>&nbsp;</td>
                            <td><?php if (!empty($result['sheet_ride_detail_rides']['real_end_date'])) {
                                    echo h($this->Time->format($result['sheet_ride_detail_rides']['real_end_date'], '%d-%m-%Y %H:%M'));
                                } else {
                                    echo h($this->Time->format($result['sheet_ride_detail_rides']['planned_end_date'], '%d-%m-%Y %H:%M'));
                                } ?>&nbsp;</td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
                <br/><br/>
                <?php echo "<b style='float:left ; line-height:35px'>".__('Total :  ')."</b> &nbsp <b style='color:#10c469; ; line-height:35px'>"  .number_format($totalCost, 2, ",", "."). " " .$this->Session->read("currency")."</b> "; ?><br/>
                <?php echo "<b style='float:left ; line-height:35px'>".__('Reste à payer :  ')."</b> &nbsp <b style='color:#10c469; ; line-height:35px'>"  .number_format($totalAmountRemaining, 2, ",", "."). " " .$this->Session->read("currency")."</b> "; ?>
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