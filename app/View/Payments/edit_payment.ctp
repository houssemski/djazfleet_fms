<style>
    .select2-container{
        z-index: 10000;
    }
</style>

<?php

if($controller == 'payments'){
    echo $this->Form->create('Payment' ,  array( 'onsubmit' => 'javascript: return  submitJs();'));
}else {
    echo $this->Form->create('Payment');
}

$this->request->data['Payment']['receipt_date'] = $this->Time->format($this->request->data['Payment']['receipt_date'], '%d-%m-%Y');
$this->request->data['Payment']['operation_date'] = $this->Time->format($this->request->data['Payment']['operation_date'], '%d-%m-%Y');
$this->request->data['Payment']['value_date'] = $this->Time->format($this->request->data['Payment']['value_date'], '%d-%m-%Y');
echo $this->Form->input('id');
echo '<br/>';
echo "<div class='form-group'>" . $this->Form->input('receipt_date', array(
        'label' => '',
        'placeholder' => 'dd/mm/yyyy',
        'type' => 'text',

        'class' => 'form-control datemask',
        'before' => '<label>' . __('Receipt date') . '</label><div class="input-group date "><label for="PaymentDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
        'after' => '</div>',
        'id' => 'receipt_date',
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('operation_date', array(
        'label' => '',
        'placeholder' => 'dd/mm/yyyy',
        'type' => 'text',

        'class' => 'form-control datemask',
        'before' => '<label>' . __('Operation date') . '</label><div class="input-group date "><label for="PaymentDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
        'after' => '</div>',
        'id' => 'operation_date',
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('value_date', array(
        'label' => '',
        'placeholder' => 'dd/mm/yyyy',
        'type' => 'text',

        'class' => 'form-control datemask',
        'before' => '<label>' . __('Value date') . '</label><div class="input-group date "><label for="PaymentDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
        'after' => '</div>',
        'id' => 'value_date',
    )) . "</div>";

    echo "<div class='form-group'>" . $this->Form->input('wording', array(
            'label' => __('Wording'),
            'class' => 'form-control',
            'id'=>'wording',
            'required'=>true,
        )) . "</div>";

$options=array('4'=>'Chèque' , '1'=>'Espèce', '3'=>'Chèque de banque', '2'=>'Virement', '5'=>'Traite', '6'=>'Fictif');
//$options=array('1'=>__('Species'),'2'=>__('Transfer'),'3'=>__('Bank check'));
echo "<div class='form-group'>" . $this->Form->input('payment_type', array(
        'label' => __('Payment type'),
        'empty' => __('Select payment type'),
        'type' =>'select',
        'id'=>'type_paiement',
		'onchange'=>'javascript : getPaymentEtatByPaymentType(); setNumberPaymentRequired();',
        'options' =>$options,
        'class' => 'form-control select-popup',
    )) . "</div>";
	
$options=array('1'=>'Non défini' , '2'=>'Chez nous', '3'=>'En circulation', '4'=>'Payé', '5'=>'Impayé', '6'=>'Annulé');

echo "<div class='form-group'>" . $this->Form->input('payment_etat', array(
        'label' => __('Payment etat'),
        'empty' => '',
        'type' =>'select',
        'id'=>'payment_etat',
        'options' =>$options,
        'class' => 'form-control select-popup',
    )) . "</div>";
	
echo "<div class='form-group'>" . $this->Form->input('payment_category_id', array(
        'label' => __('Category'),
        'empty' => '',
        'type' =>'select',
        'id'=>'payment_category',
        'class' => 'form-control select-popup',
    )) . "</div>";	

echo "<div class='form-group'>" . $this->Form->input('number_payment', array(
        'label' => __('Number payment'),
        'id'=>'number_payment',
        'placeholder' => __('Enter number'),
        'class' => 'form-control',
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('amount', array(
        'label' => __('Amount'),
        'placeholder' => __('Enter amount'),
        'type' => 'number',
        'id'=>'amount',
		'step'=>'0.01',
        'class' => 'form-control',
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('previous_amount', array(
        'value'=>$this->request->data['Payment']['amount'],
        'type' => 'number',
        'type' => 'hidden',
        'id'=>'previous_amount'
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('type', array(
        'value'=>$type,
        'type' => 'hidden',
        'id'=>'type'
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('payment_association_id', array(
        'value'=>$paymentAssociationId,
        'type' => 'number',
        'type' => 'hidden',
        'id'=>'payment_association_id'
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('transact_type_id', array(
        'value'=>$this->request->data['Payment']['transact_type_id'],
        'type' => 'number',
        'type' => 'hidden',
        'id'=>'transact_type_id'
    )) . "</div>";
echo "<div class='form-group'>" . $this->Form->input('compte_id', array(
        'label' => __('Compte'),
        'id'=>'compte',
        'empty' => __('Select compte'),
        'class' => 'form-control select-popup',
    )) . "</div>";
if($paymentAssociationId == 7 || $paymentAssociationId == 8){
    echo "<div class='form-group'>" . $this->Form->input('supplier_id', array(
            'label' => __('Third'),
            'empty' => __('Select third'),
            'class' => 'form-control select-popup',
            'id'=>'third',
            'required'=>true,
        )) . "</div>";
}
echo "<div class='form-group'>" . $this->Form->input('note', array(
        'label' => __('Note'),
        'rows'=>'6',
        'cols'=>'30',
        'placeholder' => __('Enter note'),
        'class' => 'form-control',
    )) . "</div>";


if($controller == 'payments'){
    echo $this->Form->submit(__('Save'), array(
        'name' => 'ok',
        'class' => 'btn btn-primary',
        'label' => __('Save'),
        //'type' => 'submit',
       // 'onclick'=>'javascript: submitJs()',
        //'id'=>'boutonValider',
        'div' => false
    ));
} else {
 /*echo $this->Js->submit(__('Save'), array(  //create 'ajax' save button
    'update' => '#dialogModalPayments',  //id of DOM element to update with selector
    'class' => 'btn btn-primary',

    
    ));*/

    echo $this->Form->submit(__('Save'), array(
        'name' => 'ok',
        'class' => 'btn btn-primary',
        'label' => __('Save'),
        'type' => 'button',
		'id'=>'boutonValider',
        'onclick'=>'javascript:  submitJsEditPaymentFromTransportBill();',
        'div' => false
    ));

 

if (false != $saved){ //will only be true if saved OK in controller from ajax save above
    $url = '/payments/getRegulations/'.$transportBillId;
    $urlTotal = '/transportBills/getTotalsById/'.$transportBillId;
    echo "<script>
        jQuery('#dialogModalPayments').dialog('close');  //close containing dialog         
       jQuery('#reglement').load('".$this->Html->url($url)."', function () {

           jQuery('#total').load('".$this->Html->url($urlTotal)."');
        });
    </script>";
    }
}
?>


<?php
echo $this->Form->end();
echo $this->Js->writeBuffer(); //assuming this view is rendered without the default layout, make sure you write out the JS buffer at the bottom of the page
?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('maskedinput'); ?>
    <script type="text/javascript">

        jQuery('#third').parent('.input.select').addClass('required');
        jQuery('#wording').parent('.input.text').addClass('required');
        $(document).ready(function() {
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
            jQuery('#num_payment_div').css('display','none');
            jQuery("#receipt_date").inputmask("date", {"placeholder": "dd/mm/yyyy"});
            jQuery("#operation_date").inputmask("date", {"placeholder": "dd/mm/yyyy"});
            jQuery("#value_date").inputmask("date", {"placeholder": "dd/mm/yyyy"});
            jQuery(".date").datetimepicker({

                format:'DD/MM/YYYY',
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                }

            });

            $('.date').click(function(){
                var popup =$(this).offset();
                var popupTop = popup.bottom;
                $('.bootstrap-datetimepicker-widget').css({
                    'bottom' : 10,
                    'left' : 10,
                    'height' : 250

                });
            });

            jQuery('#payment_type').change(function () {
                if (jQuery('#payment_type').val()== 2 || jQuery('#payment_type').val()== 3) {
                    jQuery('#num_payment_div').css('display','block');
                }
                else {
                    jQuery('#num_payment_div').css('display','none');
                }

            });

           if( jQuery('#payment_type').val()>0) {
                if (jQuery('#payment_type').val()== 2 || jQuery('#payment_type').val()== 3) {
                    jQuery('#num_payment_div').css('display','block');
                }
                else {
                    jQuery('#num_payment_div').css('display','none');
                }
            };

        });

        function submitJs(){
                if(parseFloat($('#amount').val()) != parseFloat($('#previous_amount').val())) {
                    var msg = '<?php echo __('The bills associated with this payment will be deleted')?>';
                    if (confirm(msg)) {
						return true ;
						 disable();
                        $('form#PaymentEditPaymentForm').submit();
						
                    } else {
                         return false ;
                    }
                } else {
					disable();
                    $('form#PaymentEditPaymentForm').submit();
					
                }
        };
        function submitJsEditPaymentFromTransportBill(){

                if(parseFloat($('#amount').val()) != parseFloat($('#previous_amount').val())) {
                    var msg = '<?php echo __('The bills associated with this payment will be deleted')?>';
                    if (confirm(msg)) {
						return true ;
                        editPaymentAjax();
                    } else {
                         return false ;
                    }
                } else {
                    editPaymentAjax();
                }
        };

        function editPaymentAjax (){

            var PaymentId = jQuery('#PaymentId').val();
            var paymentAssociationId = jQuery('#payment_association_id').val();
            var link= '<?php echo $this->Html->url('/payments/editPaymentFromTransportBill/')?>'+PaymentId+'/'+paymentAssociationId;


          jQuery.ajax({
                type: "POST",
                url: link,
              data : {  receipt_date: jQuery("#receipt_date").val(),
                        operation_date: jQuery("#operation_date").val(),
                        value_date: jQuery("#value_date").val(),
                        payment_type: jQuery("#payment_type").val(),
                        number_payment: jQuery("#number_payment").val(),
                        amount: jQuery("#amount").val(),
                        compte_id: jQuery("#compte").val(),
                        note: jQuery("#PaymentNote").val()
                },
                dataType: "json",
                success: function (json) {
                    if (json.response === true)
                    {
                        jQuery('#dialogModalPayments').dialog('close');  //close containing dialog
                        var transportBillId = json.transportBillId;
                        jQuery('#reglement').load('<?php echo $this->Html->url('/payments/getRegulations/')?>'+transportBillId, function(){
                            jQuery('#total').load('<?php echo $this->Html->url('/transportBills/getTotalsById/')?>'+transportBillId);
                        });

                    } else {

                    }
                }
            });
        }

    
			
		function getPaymentEtatByPaymentType(){
			if(jQuery('#type_paiement').val()=='1'){
				jQuery('#payment_etat').val('4');
				$("#payment_etat option[value=4]").attr('selected', 'selected');
				$("#select2-payment_etat-container").prop('title', 'payé');
				$("#select2-payment_etat-container").html('Payé');
			}else {
				jQuery('#payment_etat').val('');
				$("#payment_etat option[value='4']").removeAttr('selected');
				$("#select2-payment_etat-container").prop('title', '');
				$("#select2-payment_etat-container").html('');
			}
		}

        function setNumberPaymentRequired(){
            if(jQuery('#type_paiement').val()=='4'){
                jQuery('#number_payment').parent('.input').addClass('required');
                jQuery('#number_payment').prop('required','required');
            }else {
                jQuery('#number_payment').parent('.input').removeClass('required');
                jQuery('#number_payment').prop('required',false);
            }
        }
	
	</script>
<?php die(); ?>