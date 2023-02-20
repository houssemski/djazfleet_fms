
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

<h4 class="page-title"> <?=__('Debt by customer'); ?></h4>
<div class="box-body">

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-20">
                <?php echo $this->Form->create('Statistic', array(
                    'url'=> array(
                        'action' => 'debtByCustomer'
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
                    ));
                    echo "<div style='clear:both; padding-top: 10px;'></div>";
                    echo $this->Form->input('date', array(
                        'label' => '',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'before' => '<label class="dte">' . __('Start') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                        'after' => '</div>',
                        'id' => 'startdate',
                    ));
                    echo $this->Form->input('next_date', array(
                        'label' => '',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'before' => '<label class="dte">' . __('End') . '</label><div class="input-group date"><div class="input-group-addon">
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
                <div class="row" style="clear: both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">

                            <div class="btn-group">
                                <?= $this->Html->link('<i class="glyphicon glyphicon-export"></i>' . __('Export Pdf'),
                                    /* array('action' => 'listcarparcsupplier_pdf', 'ext'=>'pdf'),*/
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

                <?php

       $countTransportBills = 0;
       if(!empty($transportBills)){
       $supplierId = $transportBills[0]['Supplier']['id'];
       $supplier = $transportBills[0]['Supplier']['code'].' : '.$transportBills[0]['Supplier']['name'];
       $countTransportBills = count($transportBills);

       ?>
        <div style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
background-color: rgba(16, 196, 105, 0.15) !important;
color: #10c469 !important;font-weight:bold;'><?= $supplier?></div>
           <?php } ?>
          <table class="table table-striped table-bordered dt-responsive nowrap"
                 cellspacing="0" width="100%" id='table_consumption' >
            <thead style="width: auto">
            <tr>
                <th ><strong><?php echo __('Reference'); ?></strong></th>
                <th ><strong><?php echo __('Date'); ?></strong></th>
                <th><strong><?php echo  __('Total amount'); ?></strong></th>
                <th><strong><?php echo  __('Payroll amount'); ?></strong></th>
                <th ><strong><?php echo  __('Amount remaining') ?></strong></th>
            </tr>
            </thead>
            <tbody>
       <?php
       $totalAmount = 0;
       $totalAmountRemaining = 0;
       $totalPayrollAmount = 0;
       for ($i =0 ;$i<$countTransportBills ; $i++ ){ ?>

            <?php
           if($supplierId == $transportBills[$i]['Supplier']['id']){
               if($transportBills[$i]['TransportBill']['type']==TransportBillTypesEnum::invoice ){
                   $totalAmount = $totalAmount +$transportBills[$i]['TransportBill']['total_ttc'] ;
                   $totalAmountRemaining = $totalAmountRemaining + $transportBills[$i]['TransportBill']['amount_remaining'];

               }else {
                   $totalAmount = $totalAmount - $transportBills[$i]['TransportBill']['total_ttc'] ;
                   $totalAmountRemaining = $totalAmountRemaining - $transportBills[$i]['TransportBill']['amount_remaining'];

               }

               ?>
               <tr>
                   <td><?php echo h($transportBills[$i]['TransportBill']['reference']); ?>&nbsp;</td>
                   <td><?php echo h($this->Time->format($transportBills[$i]['TransportBill']['date'], '%d-%m-%Y')); ?>&nbsp;</td>
                   <td><?php echo number_format($transportBills[$i]['TransportBill']['total_ttc'], 2, ",", $separatorAmount) ?>&nbsp;</td>
                   <td><?php
                       $payrollAmount = $transportBills[$i]['TransportBill']['total_ttc'] - $transportBills[$i]['TransportBill']['amount_remaining'];
                       if($transportBills[$i]['TransportBill']['type']==TransportBillTypesEnum::invoice ){
                           $totalPayrollAmount = $totalPayrollAmount + $payrollAmount;
                       }else {
                           $totalPayrollAmount = $totalPayrollAmount - $payrollAmount;
                       }
                       echo number_format($payrollAmount, 2, ",", $separatorAmount) ?>&nbsp;</td>
                   <td><?php echo number_format($transportBills[$i]['TransportBill']['amount_remaining'], 2, ",", $separatorAmount) ?>&nbsp;</td>
               </tr>

           <?php
           if($i==$countTransportBills-1){ ?>
       <tr>
           <td colspan=2><?php echo __('Total pour : ').' '.$supplier?></td>
           <td><?php echo number_format($totalAmount, 2, ",", $separatorAmount) ?>&nbsp;</td>
           <td><?php echo number_format($totalPayrollAmount, 2, ",", $separatorAmount) ?>&nbsp;</td>
           <td><?php echo number_format($totalAmountRemaining, 2, ",", $separatorAmount) ?>&nbsp;</td>

       </tr>
            </tbody>
          </table>
        <?php
           }
           } else { ?>
                     <tr>
                <td colspan=2><?php echo __('Total pour : ').' '.$supplier ?></td>
                <td><?php echo number_format($totalAmount, 2, ",", $separatorAmount) ?>&nbsp;</td>
                <td><?php echo number_format($totalPayrollAmount, 2, ",", $separatorAmount) ?>&nbsp;</td>
                <td><?php echo number_format($totalAmountRemaining, 2, ",", $separatorAmount) ?>&nbsp;</td>

            </tr>
            </tbody>
        </table>

         <?php


         $totalAmount = 0;
         $totalAmountRemaining = 0;
         $totalPayrollAmount = 0;

           if($i < $countTransportBills){
                $supplierId = $transportBills[$i]['Supplier']['id'];
                $supplier = $transportBills[$i]['Supplier']['code'].' : '.$transportBills[$i]['Supplier']['name'];
               ?>
        <div style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
background-color: rgba(16, 196, 105, 0.15) !important;
color: #10c469 !important;font-weight:bold;'><?=  $supplier ?></div>
        <table class="table table-striped table-bordered dt-responsive nowrap"
               cellspacing="0" width="100%" id='table_consumption' >
            <thead >
            <tr>
                <th ><strong><?php echo __('Reference'); ?></strong></th>
                <th ><strong><?php echo __('Date'); ?></strong></th>
                <th><strong><?php echo  __('Total amount'); ?></strong></th>
                <th><strong><?php echo  __('Payroll amount'); ?></strong></th>
                <th ><strong><?php echo  __('Amount remaining') ?></strong></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if($transportBills[$i]['TransportBill']['type']==TransportBillTypesEnum::invoice ){
                $totalAmount = $totalAmount +$transportBills[$i]['TransportBill']['total_ttc'] ;
                $totalAmountRemaining = $totalAmountRemaining + $transportBills[$i]['TransportBill']['amount_remaining'];

            }else {
                $totalAmount = $totalAmount - $transportBills[$i]['TransportBill']['total_ttc'] ;
                $totalAmountRemaining = $totalAmountRemaining - $transportBills[$i]['TransportBill']['amount_remaining'];

            }
            ?>

                 <tr>
                   <td><?php echo h($transportBills[$i]['TransportBill']['reference']); ?>&nbsp;</td>
                   <td><?php echo h($this->Time->format($transportBills[$i]['TransportBill']['date'], '%d-%m-%Y')); ?>&nbsp;</td>
                     <td><?php echo number_format($transportBills[$i]['TransportBill']['total_ttc'], 2, ",", $separatorAmount) ?>&nbsp;</td>
                     <td><?php
                       $payrollAmount = $transportBills[$i]['TransportBill']['total_ttc'] - $transportBills[$i]['TransportBill']['amount_remaining'];
                       if($transportBills[$i]['TransportBill']['type']==TransportBillTypesEnum::invoice ){
                           $totalPayrollAmount = $totalPayrollAmount + $payrollAmount;
                       }else {
                           $totalPayrollAmount = $totalPayrollAmount - $payrollAmount;
                       }
                       echo number_format($payrollAmount, 2, ",", $separatorAmount) ?>&nbsp;</td>
                   <td><?php echo number_format($transportBills[$i]['TransportBill']['amount_remaining'], 2, ",", $separatorAmount) ?>&nbsp;</td>
               </tr>
          <?php }

           }

       }
       if($transportBills[0]['Supplier']['id']!=$supplierId){
       ?>

            <tr>
                <td colspan=2><?php echo __('Total pour : ').' '.$supplier?></td>
                <td><?php echo number_format($totalAmount, 2, ",", $separatorAmount) ?>&nbsp;</td>
                <td><?php echo number_format($totalPayrollAmount, 2, ",", $separatorAmount) ?>&nbsp;</td>
                <td><?php echo number_format($totalAmountRemaining, 2, ",", $separatorAmount) ?>&nbsp;</td>

            </tr>
            <?php } ?>
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
        var debt_customer = new Array();
        debt_customer[0] = jQuery('#client').val();
        debt_customer[1] = jQuery('#startdate').val();
        debt_customer[2] = jQuery('#enddate').val();

        var url = '<?php echo $this->Html->url(array('action' => 'debtByCustomerPdf', 'ext' => 'pdf'))?>';
        var form = jQuery('<form action="' + url + '" method="post" >' +
            '<input type="text" name="debtCustomer" value="' + debt_customer + '" />' +
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