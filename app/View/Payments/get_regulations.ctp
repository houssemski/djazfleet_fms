<?php

$this->start('css');
echo $this->Html->css('datatables/jquery.dataTables.min');
echo $this->Html->css('datatables/buttons.bootstrap.min');
echo $this->Html->css('datatables/fixedHeader.bootstrap.min');
echo $this->Html->css('datatables/responsive.bootstrap.min');
echo $this->Html->css('datatables/scroller.bootstrap.min');
echo $this->Html->css('iCheck/flat/red');

echo $this->Html->css('iCheck/all');

$this->end();
?>

<p style ='font-weight: bold'><?php echo __('Non-associated financial transactions') ?></p>

<?=  $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Associate'),
    'javascript:associateAdvancedPaymentToTransportBill(' . $transportBillId . ',' . 4 . ');',
    array('escape' => false, 'class' => 'btn btn-primary btn-bordred waves-effect waves-light m-b-5',
        'disabled' => 'true', 'id' => 'associate'));

?>

                            <table id="datatable-responsive2"
                                   class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th style="width: 10px">
                                        <button type="button" id='checkbox'
                                                class="btn btn-default btn-sm checkbox-toggle">
                                            <i class="fa fa-square-o"></i></button>
                                    </th>
                                    <th><?php echo __('Date'); ?></th>
                                    <th><?php echo __('Amount'); ?></th>
                                    <th><?php echo __('Payment type'); ?></th>
                                    <th><?php echo __('Rest'); ?></th>
                                    <th><?php echo __('Wording'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                echo "<div class='form-group'>" . $this->Form->input('ids', array(
                                        'type' => 'hidden',
                                        'id' => 'ids',
                                        'class' => 'form-control',
                                    )) . "</div>";


                                foreach ($advancedPayments as $advancedPayment) {
                                    ?>
                                    <tr>
                                        <td>
                                            <input id="idCheck" type="checkbox" class='id2'
                                                   value=<?php echo $advancedPayment['Payment']['id'] ?>>
                                        </td>
                                        <td><?php echo h($this->Time->format($advancedPayment['Payment']['receipt_date'], '%d-%m-%Y')); ?></td>
                                        <td><?php echo number_format($advancedPayment['Payment']['amount'], 2, ",", $separatorAmount); ?></td>
                                        <td><?php  switch ($advancedPayment['Payment']['payment_type']) {
                                                case 1:
                                                    echo __('Species');
                                                    break;
                                                case 2:
                                                    echo __('Transfer');
                                                    break;
                                                case 3:
                                                    echo __('Bank check');
                                                    break;

                                            } ?></td>
                                        <td>   <?php echo number_format($advancedPayment['Payment']['amount'], 2, ",", $separatorAmount); ?></td>
                                        <td><?php echo h($advancedPayment['Payment']['wording']); ?></td>

                                    </tr>
                                <?php
                                }
                                foreach ($remainingPayments as $remainingPayment) {
                                    ?>
                                    <tr>
                                        <td>
                                            <input id="idCheck" type="checkbox" class='id2'
                                                   value=<?php echo $remainingPayment['Payment']['id'] ?>>
                                        </td>
                                        <td><?php echo h($this->Time->format($remainingPayment['Payment']['receipt_date'], '%d-%m-%Y')); ?></td>
                                        <td><?php echo number_format($remainingPayment['Payment']['amount'], 2, ",", $separatorAmount); ?></td>
                                        <td><?php  switch ($remainingPayment['Payment']['payment_type']) {
                                                case 1:
                                                    echo __('Species');
                                                    break;
                                                case 2:
                                                    echo __('Transfer');
                                                    break;
                                                case 3:
                                                    echo __('Bank check');
                                                    break;

                                            } ?></td>
                                        <td> <?php $amountRemaining = $remainingPayment['Payment']['amount'] - $remainingPayment[0]['sum_payroll_amount'];
                                            echo number_format($amountRemaining, 2, ",", $separatorAmount);?>
                                        </td>
                                        <td><?php echo h($remainingPayment['Payment']['wording']); ?></td>

                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>
                            <br><br>

                            <p style ='font-weight: bold'><?php echo __('Financial transactions associated with the current bill') ?></p>

<?= $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Dissociate'),
    'javascript:dissociatePaymentsToTransportBill(' . $transportBillId.');',
    array('escape' => false, 'class' => 'btn btn-primary btn-bordred waves-effect waves-light m-b-5',
        'disabled' => 'true', 'id' => 'dissociate'));
?>
<br><br>


                            <table id="datatable-responsive3" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th style="width: 10px">
                                        <button type="button" id='checkbox'
                                                class="btn btn-default btn-sm checkbox-toggle">
                                            <i class="fa fa-square-o"></i></button>
                                    </th>
                                    <th><?php echo __('Date'); ?></th>
                                    <th><?php echo __('Amount'); ?></th>
                                    <th><?php echo __('Tranche'); ?></th>
                                    <th><?php echo __('Payment type'); ?></th>
                                    <th><?php echo __('Wording'); ?></th>
                                    <th><?php echo __('Actions'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($paymentParts as $paymentPart) {
                                    ?>
                                    <tr>
                                        <td>
                                            <input id="idCheck" type="checkbox" class='id3'
                                                   value=<?php echo $paymentPart['Payment']['id'] ?>>
                                        </td>
                                        <td><?php echo h($this->Time->format($paymentPart['Payment']['receipt_date'], '%d-%m-%Y')); ?></td>
                                        <td><?php echo number_format($paymentPart['Payment']['amount'], 2, ",", $separatorAmount); ?></td>
                                        <td><?php echo number_format($paymentPart['DetailPayment']['payroll_amount'], 2, ",", $separatorAmount); ?></td>
                                        <td><?php  switch ($paymentPart['Payment']['payment_type']) {
                                                case 1:
                                                    echo __('Species');
                                                    break;
                                                case 2:
                                                    echo __('Transfer');
                                                    break;
                                                case 3:
                                                    echo __('Bank check');
                                                    break;

                                            } ?></td>
                                        <td><?php echo h($paymentPart['Payment']['wording']); ?></td>
                                        <td> <?= $this->Html->link(
                                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                'javascript:editPayment(' . $paymentPart['Payment']['id'] . ',' . $paymentPart['Payment']['payment_association_id'] . ');',
                                                array('escape' => false, 'class' => 'btn btn-primary')
                                            ); ?></td>

                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>

                            <br><br>

 <!-- InputMask -->
 <?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
 <?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
 <?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
 <?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
 <?= $this->Html->script('bootstrap-filestyle'); ?>

 <!-- Datatables-->
 <?= $this->Html->script('plugins/datatables/jquery.dataTables.min'); ?>
 <?= $this->Html->script('plugins/datatables/dataTables.bootstrap'); ?>
 <?= $this->Html->script('plugins/datatables/dataTables.buttons.min'); ?>
 <?= $this->Html->script('plugins/datatables/buttons.bootstrap.min'); ?>
 <?= $this->Html->script('plugins/datatables/jszip.min'); ?>
 <?= $this->Html->script('plugins/datatables/pdfmake.min'); ?>
 <?= $this->Html->script('plugins/datatables/vfs_fonts'); ?>
 <?= $this->Html->script('plugins/datatables/buttons.html5.min'); ?>
 <?= $this->Html->script('plugins/datatables/buttons.print.min'); ?>
 <?= $this->Html->script('plugins/datatables/dataTables.fixedHeader.min'); ?>
 <?= $this->Html->script('plugins/datatables/dataTables.keyTable.min'); ?>
 <?= $this->Html->script('plugins/datatables/dataTables.responsive.min'); ?>
 <?= $this->Html->script('plugins/datatables/responsive.bootstrap.min'); ?>
 <?= $this->Html->script('plugins/datatables/dataTables.scroller.min'); ?>
 <?= $this->Html->script('plugins/iCheck/icheck.min'); ?>

 <!-- Datatable init js -->
 <?= $this->Html->script('datatables.init'); ?>
 <script type="text/javascript">

     var table2 = $('#datatable-responsive2').DataTable({
             'drawCallback': function(settings){
                 $('input[type="checkbox"]').iCheck(
                     {
                         handle: 'checkbox',
                         checkboxClass: 'icheckbox_flat-red'
                     });
             },
             "bPaginate": false,
             ordering: false,
             fixedHeader: true

         }
     );

     //Enable iCheck plugin for checkboxes
     //iCheck for checkbox and radio inputs
     $('#datatable-responsive2 input[type="checkbox"]').iCheck({
         checkboxClass: 'icheckbox_flat-red',
         radioClass: 'iradio_flat-red'
     });

     $(".checkbox-toggle").click(function () {

         var clicks = $(this).data('clicks');
         if (clicks) {
             //Uncheck all checkboxes
             $("#datatable-responsive2 input[type='checkbox']").iCheck("uncheck");
             $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
             jQuery("#associate").attr("disabled", "true");
             var myCheckboxes = new Array();
             jQuery('.id2:checked').each(function(){
                 myCheckboxes.push(jQuery(this).val());
             });
             jQuery('#ids').val(myCheckboxes);


         } else
         {
             //Check all checkboxes
             $("#datatable-responsive2 input[type='checkbox']").iCheck("check");
             $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
             jQuery("#associate").removeAttr("disabled");
             var myCheckboxes = new Array();
             jQuery('.id2:checked').each(function(){
                 myCheckboxes.push(jQuery(this).val());
             });
             jQuery('#ids').val(myCheckboxes);

         }
         $(this).data("clicks", !clicks);
     });


     $('#datatable-responsive2').on('ifChecked', 'input', function()
     {
         jQuery("#associate").removeAttr("disabled");
         var myCheckboxes = new Array();
         jQuery('.id2:checked').each(function(){
             myCheckboxes.push(jQuery(this).val());
         });
         jQuery('#ids').val(myCheckboxes);
     });

     $('#datatable-responsive2').on('ifUnchecked', 'input', function()
     {
         var myCheckboxes = new Array();
         jQuery('.id2:checked').each(function(){
             myCheckboxes.push(jQuery(this).val());
         });
         jQuery('#ids').val(myCheckboxes);
         var ischecked = false;
         jQuery(":checkbox.id2").each(function () {
             if (jQuery(this).prop('checked'))
                 ischecked = true;
         });
         if(!ischecked){
             jQuery("#associate").attr("disabled", "true");
         }
     });

     jQuery('input.id2').on('ifUnchecked', function (event) {

         var myCheckboxes = new Array();
         jQuery('.id2:checked').each(function(){
             myCheckboxes.push(jQuery(this).val());
         });
         jQuery('#ids').val(myCheckboxes);
         var ischecked = false;
         jQuery(":checkbox.id2").each(function () {
             if (jQuery(this).prop('checked'))
                 ischecked = true;
         });

         if (!ischecked) {
             jQuery("#associate").attr("disabled", "true");


         }
     });
     jQuery('input.id2').on('ifChecked', function (event) {

         jQuery("#associate").removeAttr("disabled");
         var myCheckboxes = new Array();
         jQuery('.id2:checked').each(function(){
             myCheckboxes.push(jQuery(this).val());
         });
         jQuery('#ids').val(myCheckboxes);

     });


     $('#datatable-responsive3 input[type="checkbox"]').iCheck({
         checkboxClass: 'icheckbox_flat-red',
         radioClass: 'iradio_flat-red'
     });

     $(".checkbox-toggle").click(function () {

         var clicks = $(this).data('clicks');
         if (clicks) {
             //Uncheck all checkboxes
             $("#datatable-responsive3 input[type='checkbox']").iCheck("uncheck");
             $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
             jQuery("#associate").attr("disabled", "true");
             var myCheckboxes = new Array();
             jQuery('.id3:checked').each(function () {
                 myCheckboxes.push(jQuery(this).val());
             });
             jQuery('#ids').val(myCheckboxes);


         } else {
             //Check all checkboxes
             $("#datatable-responsive3 input[type='checkbox']").iCheck("check");
             $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
             jQuery("#dissociate").removeAttr("disabled");
             var myCheckboxes = new Array();
             jQuery('.id3:checked').each(function () {
                 myCheckboxes.push(jQuery(this).val());
             });
             jQuery('#ids').val(myCheckboxes);

         }
         $(this).data("clicks", !clicks);
     });


     $('#datatable-responsive3').on('ifChecked', 'input', function () {
         jQuery("#dissociate").removeAttr("disabled");
         var myCheckboxes = new Array();
         jQuery('.id3:checked').each(function () {
             myCheckboxes.push(jQuery(this).val());
         });
         jQuery('#ids').val(myCheckboxes);
     });

     $('#datatable-responsive3').on('ifUnchecked', 'input', function () {
         var myCheckboxes = new Array();
         jQuery('.id3:checked').each(function () {
             myCheckboxes.push(jQuery(this).val());
         });
         jQuery('#ids').val(myCheckboxes);
         var ischecked = false;
         jQuery(":checkbox.id3").each(function () {
             if (jQuery(this).prop('checked'))
                 ischecked = true;
         });
         if (!ischecked) {
             jQuery("#dissociate").attr("disabled", "true");
         }
     });

     jQuery('input.id2').on('ifUnchecked', function (event) {

         var myCheckboxes = new Array();
         jQuery('.id2:checked').each(function () {
             myCheckboxes.push(jQuery(this).val());
         });
         jQuery('#ids').val(myCheckboxes);
         var ischecked = false;
         jQuery(":checkbox.id2").each(function () {
             if (jQuery(this).prop('checked'))
                 ischecked = true;
         });

         if (!ischecked) {
             jQuery("#associate").attr("disabled", "true");


         }
     });
     $('input.id2').on('ifChecked', function (event) {

         jQuery("#associate").removeAttr("disabled");
         var myCheckboxes = new Array();
         jQuery('.id2:checked').each(function () {
             myCheckboxes.push(jQuery(this).val());
         });
         jQuery('#ids').val(myCheckboxes);

     });

     jQuery('input.id3').on('ifUnchecked', function (event) {

         var myCheckboxes = new Array();
         jQuery('.id3:checked').each(function () {
             myCheckboxes.push(jQuery(this).val());
         });
         jQuery('#ids').val(myCheckboxes);
         var ischecked = false;
         jQuery(":checkbox.id3").each(function () {
             if (jQuery(this).prop('checked'))
                 ischecked = true;
         });

         if (!ischecked) {
             jQuery("#dissociate").attr("disabled", "true");


         }
     });
     $('input.id3').on('ifChecked', function (event) {

         jQuery("#dissociate").removeAttr("disabled");
         var myCheckboxes = new Array();
         jQuery('.id3:checked').each(function () {
             myCheckboxes.push(jQuery(this).val());
         });
         jQuery('#ids').val(myCheckboxes);

     });

 </script>


