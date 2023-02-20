
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

?><h4 class="page-title"> <?=__('Invoiced turnover per month'); ?></h4>
<div class="box-body">

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-20">
    <?php echo $this->Form->create('Statistic', array(
        'url'=> array(
            'action' => 'invoicedTurnoverByMonth'
        ),
        'novalidate' => true
    )); ?>
    <div class="filters" id='filters' style='display: block;'>
        <?php
        if(Configure::read('utranx_trm' ) != '1'){
            echo $this->Form->input('car_id', array(
                'label' => __('Car'),
                'class' => 'form-filter select2',
                'id' => 'car',
                'empty' => ''
            ));
            echo $this->Form->input('customer_id', array(
                'label' => __('Customer'),
                'class' => 'form-filter select2',
                'id' => 'customer',
                'empty' => ''
            ));
        }
        echo $this->Form->input('supplier_id', array(
            'label' => __('Client'),
            'class' => 'form-filter select2',
            'id' => 'client',
            'empty' => ''
        ));?>
        <div style='clear:both; padding-top: 10px;'></div>
     <?php   echo $this->Form->input('date', array(
         'label' => '',
         'type' => 'text',
         'class' => 'form-control datemask',
         'before' => '<label class="dte">'.__('From').'</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
         'after' => '</div>',
         'id' => 'startdate',
     ));
     echo $this->Form->input('next_date', array(
         'label' => '',
         'type' => 'text',
         'class' => 'form-control datemask',
         'before' => '<label class="dte">'.__('To').'</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
         'after' => '</div>',
         'id' => 'enddate',
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
            <div class="card-box p-b-20">

                <div class="row" style="clear: both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
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
            <div class="card-box p-b-0">
    <table class="table table-striped table-bordered dt-responsive nowrap"
           cellspacing="0" width="100%" id='table_consumption'>
        <thead style="width: auto">
        <?php
        if (Configure::read('utranx_trm') !='1'){
        ?>
        <th><?= __('Car') ?></th>
        <th><?= __('Customer') ?></th>
        <?php
        }
        ?>
        <th><?= __('Client') ?></th>
        <th><?= __('Price HT') ?></th>
        <th><?= __('Price TTC') ?></th>

        </thead>
        <tbody>
        <?php
        if (Configure::read('utranx_trm') !='1') {
            $colspanMonth = 5;
            $colspanTotal= 3;
        }else{
            $colspanMonth = 3;
            $colspanTotal= 1;
        }
       $previous=null;
        $sumPriceMonth=0;
        $sumPrice=0;
        $sumHtPriceMonth=0;
        $sumHtPrice=0;
        foreach ($results as $result) {

            $currentMonth= $result[0]['month'];
          for($i=1; $i<=12; $i++){
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
            if (  $result[0]['month'] == $i) {
            if($currentMonth!=$previous) {
                if($previous!=null){ ?>

                    <tr style='width: auto;'>
                        <td colspan='<?= $colspanTotal ?>' style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>".__('Total')."</span>" ; ?></td>
                        <td style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'>
                            <?= number_format($sumHtPriceMonth, 2, ",", "."). " " . $this->Session->read("currency") ?>
                        </td>
                        <td style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'>
                            <?= number_format($sumPriceMonth, 2, ",", "."). " " . $this->Session->read("currency") ?>
                        </td>
                    </tr>
              <?php
                    $sumPriceMonth=0;
                    $sumHtPriceMonth=0;
                }
                echo "<tr style='width: auto;'>" .
                    "<td colspan='".$colspanMonth."' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
background-color: rgba(16, 196, 105, 0.15) !important;
color: #10c469 !important;font-weight:bold;'>"
                    . $label . "</td></tr>";

                echo "<tr>";
                if (Configure::read('utranx_trm') !='1') {
                    echo "<td>" . $result['car']['immatr_def'] . ' ' . $result['carmodels']['name'] . "</td>";
                    echo "<td>" . $result['customers']['first_name'] . ' ' . $result['customers']['last_name'] . "</td>";
                }
                echo "<td>" . $result['suppliers']['name'] . "</td>";
                echo "<td class='right'>" . number_format($result[0]['sum_ht_price'], 2, ",", ".") ."</td>";
                echo "<td class='right'>" . number_format($result[0]['sum_ttc_price'], 2, ",", ".") ."</td></tr>";
                $sumPriceMonth= $sumPriceMonth+$result[0]['sum_ttc_price'];
                $sumPrice= $sumPrice+$result[0]['sum_ttc_price'];
                $sumHtPriceMonth= $sumHtPriceMonth+$result[0]['sum_ht_price'];
                $sumHtPrice= $sumHtPrice+$result[0]['sum_ht_price'];
            }
                else{

                    echo "<tr>";
                    if (Configure::read('utranx_trm') !='1') {
                        echo "<td>" . $result['car']['immatr_def'] . ' ' . $result['carmodels']['name'] . "</td>";
                        echo "<td>" . $result['customers']['first_name'] . ' ' . $result['customers']['last_name'] . "</td>";
                    }
                    echo "<td>" . $result['suppliers']['name'] ."</td>";
                    echo "<td class='right'>" . number_format($result[0]['sum_ht_price'], 2, ",", ".") ."</td>";
                    echo "<td class='right'>" . number_format($result[0]['sum_ttc_price'], 2, ",", ".") ."</td></tr>";
                    $sumPriceMonth= $sumPriceMonth+$result[0]['sum_ttc_price'];
                    $sumPrice= $sumPrice+$result[0]['sum_ttc_price'];
                    $sumHtPriceMonth= $sumHtPriceMonth+$result[0]['sum_ht_price'];
                    $sumHtPrice= $sumHtPrice+$result[0]['sum_ht_price'];
                }
                $previous=$currentMonth;
            }
          }







        } ?>
              <tr style='width: auto;'>
                  <td colspan='<?= $colspanTotal ?>' style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>".__('Total')."</span>" ; ?></td>
                  <td style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'>
                      <?= number_format($sumHtPriceMonth, 2, ",", "."). " " . $this->Session->read("currency") ?>
                  </td>
                  <td style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'>
                      <?= number_format($sumPriceMonth, 2, ",", "."). " " . $this->Session->read("currency") ?>
                  </td>
              </tr>



        </tbody>
    </table>
    <br/><br/>
    <?php echo "<b style='float:left ; line-height:35px'>".__('Total :  ')."</b> &nbsp <b style='color:#10c469; ; line-height:35px'>"  .number_format($sumPrice, 2, ",", "."). " " .$this->Session->read("currency")."</b> "; ?>

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
        var car_workshop = new Array();
        let carId = jQuery('#car').val();
        let customerId = jQuery('#customer').val();
        let supplierId = jQuery('#client').val();
        let date = jQuery('#startdate').val();
        let endDate = jQuery('#enddate').val();

        var url = '<?php echo $this->Html->url(array('action' => 'exportInvoicedTurnoverByMonthPdf', 'ext' => 'pdf'))?>';
        var form = jQuery('<form action="' + url + '" method="post" >' +
            '<input type="text" name="Statistic[car_id]" value="' + carId + '" />' +
            '<input type="text" name="Statistic[customer_id]" value="' + customerId + '" />' +
            '<input type="text" name="Statistic[supplier_id]" value="' + supplierId + '" />' +
            '<input type="text" name="Statistic[date]" value="' + date + '" />' +
            '<input type="text" name="Statistic[next_date]" value="' + endDate + '" />' +
            '</form>');
        form.css('display','none');
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