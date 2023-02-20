<style>
    .flot-x-axis div {
        max-width: 100% !important;
        width: auto !important;
        transform: rotate(-90deg) !important;
        top: 340px !important;
    }

    .content {
        overflow: hidden;
    }
</style>
<?php

?><h4 class="page-title"> <?= __('Monthly consumption per car'); ?></h4>
<div class="box-body">
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-20">
                <?php echo $this->Form->create('Statistic', array(
                    'url' => array(
                        'action' => 'consumptionByMonth'
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
                    echo $this->Form->input('year', array(
                        'label' => '',
                        'type' => 'text',
                        'class' => 'form-control',
                        'before' => '<label class="dte">' . __('Year') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                        'after' => '</div>',
                        'id' => 'year',
                    ));
                    ?>
                    <div style='clear:both; padding-top: 10px;'></div>
                    <?php
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
                    <button style="float: right;" class="btn btn-success btn-trans waves-effect w-md waves-success"
                            type="submit"><?= __('Search') ?></button>
                    <div style='clear:both; padding-top: 10px;'></div>
                </div>
                <?php echo $this->Form->end(); ?>

                <div class="row" style="clear: both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
                            <div class="btn-group">
                                <?= $this->Html->link('<i class="glyphicon glyphicon-export"></i>' . __('Export Excel'),

                                    'javascript:exportDataExcel();',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'export_excel')) ?>


                            </div>
                            <div class="btn-group">
                                <?= $this->Html->link('<i class="glyphicon glyphicon-export"></i>' . __('Export Pdf'),
                                    'javascript:exportDataPdf();',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'export')) ?>
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
                <table class="table table-striped table-bordered" id='table_consumption'>
                    <thead style="width: auto">
                    <th><?= __('Month') ?></th>
                    <th><?= __('Coupons Nbr') ?></th>
                    <th><?= __('Liter/Coupon') ?></th>
                    <th><?= __('Total liter coupon') ?></th>
                    <th><?= __('Coupon price') ?></th>
                    <th><?= __('Total price coupon') ?></th>
                    <th><?= __('Species') ?></th>
                    <th><?= __('Consumption liter') ?></th>
                    <th><?= __('Species card') ?></th>
                    <th><?= __('Total consumption liter') ?></th>
                    <th><?= __('Total') ?></th>
                    <th><?= __('Departure km') ?></th>
                    <th><?= __('Arrival km') ?></th>
                    <th><?= __('Kms / Month') ?></th>
                    <th><?= __('Cons / 100kms') ?></th>
                    </thead>
                    <tbody>
                    <?php
                    $all_total = 0;
                    $all_coupon = 0;
                    $all_tank = 0;
                    $all_species = 0;
                    $all_species_card = 0;
                    $total_car = 0;
                    $total_car_1 = 0;
                    $graphe = array();
                    foreach ($cars as $key => $value) {
                        if ($results) {
                            foreach ($results as $result) {
                                if ($result['car'] == $key) {
                                    echo "<tr style='width: auto;'>" .
                                        "<td colspan='15' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
background-color: rgba(16, 196, 105, 0.15) !important;
color: #10c469 !important;font-weight:bold;'>"
                                        . $value . "</td></tr>";
                                    for ($i = 1; $i <= 12; $i++) {
                                        switch ($i) {
                                            case 1 :
                                                $label = __("January");
                                                break;
                                            case 2 :
                                                $label = __("February");
                                                break;
                                            case 3 :
                                                $label = __("March");
                                                break;
                                            case 4 :
                                                $label = __("April");
                                                break;
                                            case 5 :
                                                $label = __("May");
                                                break;
                                            case 6 :
                                                $label = __("June");
                                                break;
                                            case 7 :
                                                $label = __("July");
                                                break;
                                            case 8 :
                                                $label = __("August");
                                                break;
                                            case 9 :
                                                $label = __("September");
                                                break;
                                            case 10 :
                                                $label = __("October");
                                                break;
                                            case 11 :
                                                $label = __("November");
                                                break;
                                            case 12 :
                                                $label = __("December");
                                                break;
                                        }
                                        if (isset($result[$i]['month']) && $result[$i]['month'] == $i) {
                                            $litersByCoupon = $coupon_price / $result[$i]['price'];
                                            $totalLitersCoupon = $result[$i]['coupons_number'] * $litersByCoupon;
                                            $totalLitersSpecies = $result[$i]['species'] / $result[$i]['price'];
                                            $totalLitersSpeciesCard = $result[$i]['species_card'] / $result[$i]['price'];
                                            $totalPriceCoupon = $coupon_price * $result[$i]['coupons_number'];
                                            $totalPricetank = $result[$i]['liter_tank'] * $result[$i]['price'];
                                            $total = $totalPriceCoupon + $totalPricetank + $result[$i]['species']+ $result[$i]['species_card'];
                                            $totalLiters = $totalLitersCoupon + $totalLitersSpecies + $result[$i]['liter_tank']+$totalLitersSpeciesCard;
                                            $diffKm = $result[$i]['arrivalKm'] - $result[$i]['departureKm'];
                                            if ($diffKm <= 0) {
                                                $diffKm = 0;
                                                $consumptionPer100km = 0;
                                            } else {
                                                $consumptionPer100km = ($totalLiters * 100) / $diffKm;
                                            }
                                            echo "<tr><td>" . $label . "</td>";
                                            echo "<td class='right'>" . $result[$i]['coupons_number'] . "</td>";
                                            echo "<td class='right'>" . number_format($litersByCoupon, 2, ",", ".") . "</td>";
                                            echo "<td class='right'>" . number_format($totalLitersCoupon, 2, ",", ".") . "</td>";
                                            echo "<td class='right'>" . number_format($coupon_price, 2, ",", ".") . "</td>";
                                            echo "<td class='right'>" . number_format($totalPriceCoupon, 2, ",", ".") . "</td>";
                                            echo "<td class='right'>" . number_format($result[$i]['species'], 2, ",", ".") . "</td>";
                                            echo "<td class='right'>" . number_format($result[$i]['liter_tank'], 2, ",", ".") . "</td>";
                                            echo "<td class='right'>" . number_format($result[$i]['species_card'], 2, ",", ".") . "</td>";
                                            echo "<td class='right'>" . number_format($totalPricetank, 2, ",", ".") . "</td>";
                                            echo "<td class='right'>" . number_format($total, 2, ",", ".") . "</td>";
                                            echo "<td class='right'>" . number_format($result[$i]['departureKm'], 0, ",", ".") . "</td>";
                                            echo "<td class='right'>" . number_format($result[$i]['arrivalKm'], 0, ",", ".") . "</td>";
                                            echo "<td class='right'>" . number_format($diffKm, 0, ",", ".") . "</td>";
                                            echo "<td class='right'>" . number_format($consumptionPer100km, 2, ",", ".") . "</td></tr>";

                                            $all_coupon = $all_coupon + $result[$i]['coupons_number'];
                                            $all_tank = $all_tank + $result[$i]['liter_tank'];
                                            $all_species = $all_species + $result[$i]['species'];
                                            $all_species = $all_species + $result[$i]['species_card'];
                                            $all_total = $all_total + $total;
                                            $total_car = $total_car + $total;

                                        }
                                    }




                                    ?>

                                    <tr style='width: auto;'>
                                        <td colspan='15'
                                            style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total') . "</span>" . $total_car . " " . $this->Session->read("currency"); ?></td>
                                    </tr>

                                    <?php
                                    $graphe[$total_car] = $value;

                                    $total_car = 0;


                                }


                            }


                        }
                    }
                    ?>

                    </tbody>
                </table>
                <br/><br/>
                <?php echo "<b style='float:left ; line-height:35px'>" . __('Total consumed coupons :  ') . "</b> &nbsp <b style='color:#10c469; ; line-height:35px'>" . number_format($all_coupon, 2, ",", ".") . " " . __('Coupons') . "</b> "; ?>
                <br/>
                <?php echo "<b style='float:left ; line-height:35px'>" . __('Total species : ') . "</b>  &nbsp <b style='color:#10c469; line-height:35px'>" . number_format($all_species, 2, ",", ".") . " " . $this->Session->read("currency") . "</b> "; ?>
                <br/>
                <?php echo "<b style='float:left ; line-height:35px'>" . __('Total liters :  ') . "</b>  &nbsp <b style='color:#10c469 ; line-height:35px'>" . number_format($all_tank, 2, ",", ".") . " " . __('Liter') . "</b> "; ?>
                <br/>
                <?php echo "<b style='float:left ; line-height:35px'>" . __('Total species cards :  ') . "</b>  &nbsp <b style='color:#10c469 ; line-height:35px'>" . number_format($all_species_card, 2, ",", ".") . " " . __('Liter') . "</b> "; ?>
                <br/>
                <?php echo "<b style='float:left ; line-height:35px'>" . __('Consumptions sum :  ') . "</b>  &nbsp <b style='color:#10c469 ; line-height:35px'>" . number_format($all_total, 2, ",", ".") . " " . $this->Session->read("currency") . "</b> "; ?>
            </div>
        </div>
    </div>

    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-bar-chart-o"></i>

            <h3 class="box-title"><?php __('Histogram') ?></h3>
        </div>
        <div class="box-body">
            <div id="bar-chart" style="height: 300px;"></div>
        </div>
        <!-- /.box-body-->
    </div>
    <!-- /.box -->


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
<!-- Page script -->
<script type="text/javascript">


    $(document).ready(function () {

        jQuery("#startdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#min_month").inputmask("m", {"placeholder": "mm"});
        jQuery("#max_month").inputmask("m", {"placeholder": "mm"});


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

        let url = '<?php echo $this->Html->url('/statistics/consumptionByMonthsExcel/')?>';
        let carId = jQuery('#car').val();
        let year = jQuery('#year').val();
        let minMonth = jQuery('#min_month').val();
        let maxMonth = jQuery('#max_month').val();
        let form = jQuery('<form action="' + url + '" method="post">' +
            '<input type="text" name="car_id" value="' + carId + '" />' +
            '<input type="text" name="year" value="' + year + '" />' +
            '<input type="text" name="min_month" value="' + minMonth + '" />' +
            '<input type="text" name="max_month" value="' + maxMonth + '" />' +
            '</form>');
        jQuery('body').append(form);
        form.submit();

    }


    /*
     * BAR CHART
     * ---------
     */

    var bar_data = {
        data: [
            <?php
            $a=count($graphe);
            $i=0;
            foreach($graphe as $key => $value){
            $i++;
            if($i==$a){
            echo "['$value', $key]";
            }else{
            echo "['$value', $key],";
            }


            }
            ?>
        ],
        color: "#3c8dbc"
    };
    $.plot("#bar-chart", [bar_data], {
        grid: {
            borderWidth: 1,
            borderColor: "#f3f3f3",
            tickColor: "#f3f3f3"
        },
        series: {
            bars: {
                show: true,
                barWidth: 0.5,
                align: "center"
            }
        },
        xaxis: {
            mode: "categories",
            tickLength: 0
        }
    });
    /* END BAR CHART */


</script>
<?php $this->end(); ?>