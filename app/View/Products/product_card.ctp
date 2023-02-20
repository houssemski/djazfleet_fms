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

$this->start('css');
echo $this->Html->css('select2/select2.min');
$this->end();
?>

<h4 class="page-title"> <?= __('Product card') . ' ' . $product['Product']['name']; ?></h4>
<div class="box-body">
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">



                <div class="nav-tabs-custom pdg_btm">

                            <table class="table table-striped table-bordered dt-responsive nowrap"
                                   cellspacing="0" width="100%" id='table_consumption'>
                                <thead style="width: auto">
                                <th><?= __('Reference') ?></th>
                                <th><?= __('Date'); ?></th>
                                <th><?= __('Quatity'); ?></th>
                                <th><?= __('Unit price'); ?></th>
                                <th><?= __('Price HT'); ?></th>
                                <th><?= __('Price TTC') ?></th>

                                </thead>
                                <tbody>
                                <?php


                                $previousMonth = null;

                                $sumPriceMonth = 0;
                                $sumAmountRemainingMonth = 0;
                                $sumPrice = 0;
                                $sumAmountRemaining = 0;

                                foreach ($billProducts as $billProduct) {

                                    $date = date_parse($billProduct['Bill']['date']);
                                    $currentMonth = $date['month'];
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

                                        if ($date['month'] == $i) {
                                            if ($currentMonth != $previousMonth) {
                                                if ($previousMonth != null) { ?>

                                                    <tr style='width: auto;'>
                                                        <td colspan='14'
                                                            style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total TTC par mois ') . "</span>" . number_format($sumPriceMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                                    </tr>


                                                    <?php
                                                    $sumPriceMonth = 0;
                                                }
                                                echo "<tr style='width: auto;'>" .
                                                    "<td colspan='14' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
													background-color: rgba(16, 196, 105, 0.15) !important;
													color: #10c469 !important;font-weight:bold;'>"
                                                    . $label . "</td></tr>";

                                                echo "<td>" . $billProduct['Bill']['reference'] . "</td>";

                                                echo "<td>" . $this->Time->format($billProduct['Bill']['date'], '%d-%m-%Y') . "</td>";
                                                echo "<td>" . $billProduct['BillProduct']['quantity'] . "</td>";

                                                echo "<td class='right'>" . number_format($billProduct['BillProduct']['unit_price'], 2, ",", ".") . "</td>";
                                                echo "<td class='right'>" . number_format($billProduct['BillProduct']['price_ht'], 2, ",", ".") . "</td></tr>";
                                                $sumPriceMonth = $sumPriceMonth + $billProduct['BillProduct']['price_ttc'];
                                                $sumPrice = $sumPrice + $billProduct['BillProduct']['price_ttc'];
                                            } else {

                                                echo "<td>" . $billProduct['Bill']['reference'] . "</td>";

                                                echo "<td>" . $this->Time->format($billProduct['Bill']['date'], '%d-%m-%Y') . "</td>";

                                                echo "<td>" . $billProduct['BillProduct']['quantity'] . "</td>";

                                                echo "<td class='right'>" . number_format($billProduct['BillProduct']['unit_price'], 2, ",", ".") . "</td>";
                                                echo "<td class='right'>" . number_format($billProduct['BillProduct']['price_ht'], 2, ",", ".") . "</td></tr>";
                                                $sumPriceMonth = $sumPriceMonth + $billProduct['BillProduct']['price_ttc'];
                                                $sumPrice = $sumPrice + $billProduct['BillProduct']['price_ttc'];


                                            }
                                            $previousMonth = $currentMonth;
                                        }
                                    }
                                }
                                ?>
                                <tr style='width: auto;'>
                                    <td colspan='14'
                                        style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total TTC par mois ') . "</span>" . number_format($sumPriceMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                </tr>

                                <tr style='width: auto;'>
                                    <td colspan='14'
                                        style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total') . "</span>" . number_format($sumPrice, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                </tr>



                                </tbody>
                            </table>





                </div>


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


    $(document).ready(function () {

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
            htmlContent: 'false'
        });

    }


</script>
<?php $this->end(); ?>