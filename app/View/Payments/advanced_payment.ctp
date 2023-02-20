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
<?php echo $this->Form->create('Payment', array('onsubmit'=> 'javascript:disable();')); ?>
<div id ='table_advanced'>
<p><?php echo __('Non-associated financial transactions')?></p>
<table id="datatable-responsive2" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th style="width: 10px">
                <button type="button" id ='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
            </th>
            <th><?php echo  __('Date'); ?></th>
            <th><?php echo  __('Amount'); ?></th>
            <th><?php echo  __('Payment type'); ?></th>
            <th><?php echo  __('Rest'); ?></th>
            <th><?php echo  __('Wording'); ?></th>
</tr>
</thead>
<tbody>
<?php
echo "<div class='form-group'>" . $this->Form->input('ids', array(
        'type'=>'hidden',
        'id'=>'ids',
        'class' => 'form-control',
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('billIds', array(
        'type'=>'hidden',
        'id'=>'billIds',
        'value'=>$billIds,
        'class' => 'form-control',
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('model', array(
        'type'=>'hidden',
        'id'=>'model',
        'value'=>$model,
        'class' => 'form-control',
    )) . "</div>";

foreach ($advancedPayments as $advancedPayment){
    ?>
 <tr>
     <td>
         <input id="idCheck"type="checkbox" class = 'id2' value=<?php echo $advancedPayment['Payment']['id'] ?> >
     </td>
     <td><?php echo h($this->Time->format($advancedPayment['Payment']['receipt_date'], '%d-%m-%Y')); ?></td>
     <td><?php echo number_format($advancedPayment['Payment']['amount'], 2, ",", $separatorAmount);?></td>
     <td><?php  switch($advancedPayment['Payment']['payment_type']){
									case 1:
                                        echo __('Espèce');
                                        break;
                                    case 2:
                                        echo __('Virement');
                                        break;
                                    case 3:
                                        echo __('Chèque de banque');
                                        break;
									
									case 4:
                                        echo __('Chèque');
                                        break;
										
									case 5:
                                        echo __('Traite');
                                        break;
										
									case 6:
                                        echo __('Fictif');
                                        break;

         } ?></td>
     <td>   <?php echo number_format($advancedPayment['Payment']['amount'], 2, ",", $separatorAmount);?></td>
     <td><?php echo h($advancedPayment['Payment']['wording']); ?></td>

 </tr>
<?php }
foreach ($remainingPayments as $remainingPayment){
    ?>
<tr>
    <td>
        <input id="idCheck"type="checkbox" class = 'id2' value=<?php echo $remainingPayment['Payment']['id'] ?> >
    </td>
    <td><?php echo h($this->Time->format($remainingPayment['Payment']['receipt_date'], '%d-%m-%Y')); ?></td>
    <td><?php echo number_format($remainingPayment['Payment']['amount'], 2, ",", $separatorAmount);?></td>
    <td><?php  switch($remainingPayment['Payment']['payment_type']){
									case 1:
                                        echo __('Espèce');
                                        break;
                                    case 2:
                                        echo __('Virement');
                                        break;
                                    case 3:
                                        echo __('Chèque de banque');
                                        break;
									
									case 4:
                                        echo __('Chèque');
                                        break;
										
									case 5:
                                        echo __('Traite');
                                        break;
										
									case 6:
                                        echo __('Fictif');
                                        break;

        } ?></td>
    <td> <?php $amountRemaining  = $remainingPayment['Payment']['amount'] - $remainingPayment[0]['sum_payroll_amount'];
        echo number_format($amountRemaining, 2, ",", $separatorAmount);?>
    </td>
    <td><?php echo h($remainingPayment['Payment']['wording']); ?></td>

</tr>
<?php } ?>

</tbody>
</table>
<br><br>
<p><?php echo __('Financial transactions associated with the current bill')?></p>
<table id="datatable-responsive3" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th style="width: 10px">
            <button type="button" id ='checkbox' class="btn btn-default btn-sm checkbox-toggle3"><i class="fa fa-square-o"></i></button>
        </th>
        <th><?php echo  __('Date'); ?></th>
        <th><?php echo  __('Amount'); ?></th>
        <th><?php echo  __('Tranche'); ?></th>
        <th><?php echo  __('Payment type'); ?></th>
        <th><?php echo  __('Wording'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($paymentParts as $paymentPart){
        ?>
        <tr>
            <td>
                <input id="idCheck"type="checkbox" class = 'id3' value=<?php echo $paymentPart['Payment']['id'] ?> >
            </td>
            <td><?php echo h($this->Time->format($paymentPart['Payment']['receipt_date'], '%d-%m-%Y')); ?></td>
            <td><?php echo number_format($paymentPart['Payment']['amount'], 2, ",", $separatorAmount);?></td>
            <td><?php echo number_format($paymentPart['DetailPayment']['payroll_amount'], 2, ",", $separatorAmount);?></td>
            <td><?php  switch($paymentPart['Payment']['payment_type']){
									case 1:
                                        echo __('Espèce');
                                        break;
                                    case 2:
                                        echo __('Virement');
                                        break;
                                    case 3:
                                        echo __('Chèque de banque');
                                        break;
									
									case 4:
                                        echo __('Chèque');
                                        break;
										
									case 5:
                                        echo __('Traite');
                                        break;
										
									case 6:
                                        echo __('Fictif');
                                        break;

                } ?></td>
            <td><?php echo h($paymentPart['Payment']['wording']); ?></td>

        </tr>
    <?php } ?>

    </tbody>
</table>


</div>

<br><br>
<div id="total">
    <?php $regulation = $totalAmount - $totalAmountRemaining;?>
    <span ><strong><?php echo  __('Règlement: '); ?></strong></span> <span > <?= number_format($regulation, 2, ",", $separatorAmount).' '. $this->Session->read("currency");?></span><br>
    <span ><strong><?php echo  __('Left to pay: '); ?></strong></span> <span > <?= number_format($totalAmountRemaining, 2, ",", $separatorAmount).' '. $this->Session->read("currency");?></span><br>
</div>

<br><br>
<div class="box-footer">
<?php
echo $this->Form->submit(__('Associate'), array(
    'name' => 'ok',
    'class' => 'btn btn-primary m-r-10',
    'label' => __('Save'),
    'type' => 'submit',
    'id'=>'boutonValider',
    'disabled' => 'true',
    'id' => 'associate',
    'div' => false
));

echo $this->Form->submit(__('Dissociate'), array(
    'name' => 'ok',
    'class' => 'btn btn-primary',
    'label' => __('Save'),
    'onclick'=>'javascript : dissociatePayments();',
    'type' => 'button',
    'id'=>'boutonValider',
    'disabled' => 'true',
    'id' => 'dissociate',
    'div' => false
));
echo $this->Form->end();
echo $this->Js->writeBuffer(); //assuming this view is rendered without the default layout, make sure you write out the JS buffer at the bottom of the page
?>
</div>
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

 $('#datatable-responsive2').DataTable({
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
 $('#datatable-responsive3').DataTable({
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

$('#datatable-responsive3 input[type="checkbox"]').iCheck({
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

$(".checkbox-toggle3").click(function () {
    var clicks = $(this).data('clicks');
    if (clicks) {
        //Uncheck all checkboxes
        $("#datatable-responsive3 input[type='checkbox']").iCheck("uncheck");
        $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
        jQuery("#dissociate").attr("disabled", "true");
        var myCheckboxes = new Array();
        jQuery('.id3:checked').each(function(){
            myCheckboxes.push(jQuery(this).val());
        });
        jQuery('#ids').val(myCheckboxes);
    } else
    {
        //Check all checkboxes
        $("#datatable-responsive3 input[type='checkbox']").iCheck("check");
        $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
        jQuery("#dissociate").removeAttr("disabled");
        var myCheckboxes = new Array();
        jQuery('.id3:checked').each(function(){
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

$('#datatable-responsive3').on('ifChecked', 'input', function()
{
    jQuery("#dissociate").removeAttr("disabled");
    var myCheckboxes = new Array();
    jQuery('.id3:checked').each(function(){
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

$('#datatable-responsive3').on('ifUnchecked', 'input', function()
{
    var myCheckboxes = new Array();
    jQuery('.id3:checked').each(function(){
        myCheckboxes.push(jQuery(this).val());
    });
    jQuery('#ids').val(myCheckboxes);
    var ischecked = false;
    jQuery(":checkbox.id3").each(function () {
        if (jQuery(this).prop('checked'))
            ischecked = true;
    });
    if(!ischecked){
        jQuery("#dissociate").attr("disabled", "true");
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

jQuery('input.id3').on('ifUnchecked', function (event) {
    var myCheckboxes = new Array();
    jQuery('.id3:checked').each(function(){
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

jQuery('input.id2').on('ifChecked', function (event) {

    jQuery("#associate").removeAttr("disabled");
    var myCheckboxes = new Array();
    jQuery('.id2:checked').each(function(){
        myCheckboxes.push(jQuery(this).val());
    });
    jQuery('#ids').val(myCheckboxes);

});

jQuery('input.id3').on('ifChecked', function (event) {

    jQuery("#dissociate").removeAttr("disabled");
    var myCheckboxes = new Array();
    jQuery('.id3:checked').each(function(){
        myCheckboxes.push(jQuery(this).val());
    });
    jQuery('#ids').val(myCheckboxes);
});
    function dissociatePayments (){
        var link= '<?php echo $this->Html->url('/payments/dissociatePayments/')?>' ;
        var myCheckboxes = new Array();
        jQuery('.id3:checked').each(function(){
            myCheckboxes.push(jQuery(this).val());
        });
        var billIds = jQuery('#billIds').val();
        var model = jQuery('#model').val();
        jQuery.ajax({
            type: "GET",
            url: link,
            data: {ids: JSON.stringify(myCheckboxes), billIds: JSON.stringify(billIds), model: model},
            dataType: "json",
            success: function (json) {
                if (json.response === true)
                {
                   // var billIds = json.billIds;
                    var model = jQuery('#model').val();
                    jQuery('#table_advanced').load('<?php echo $this->Html->url('/payments/getRegulationsByBillIds/')?>'+billIds+'/'+model, function(){
                        jQuery('#total').load('<?php echo $this->Html->url('/payments/getTotalsByIds/')?>'+billIds+'/'+model);
                    });
                }
            }
        });

    }

</script>


