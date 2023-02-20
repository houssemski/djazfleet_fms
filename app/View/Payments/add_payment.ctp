<style>
    .select2-container{
        z-index: 10000;
    }
</style>
<?php
$this->start('css');
echo $this->Html->css('select2/select2.min');
$this->end();
echo $this->Form->create('Payment', array('onsubmit'=> 'javascript:disable();'));
echo '<br/>';
$current_date=date("Y-m-d");
echo "<div class='form-group'>" . $this->Form->input('receipt_date', array(
        'label' => '',
        'placeholder' => 'dd/mm/yyyy',
        'type' => 'text',
        'value'=>$this->Time->format($current_date, '%d/%m/%Y'),
        'class' => 'form-control datemask',
        'before' => '<label>' . __('Receipt date') . '</label><div class="input-group date "><label for="ReceiptDate"></label><div class="input-group-addon">
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

$options=array('4'=>'Chèque' , '1'=>'Espèce', '3'=>'Chèque de banque', '2'=>'Virement', '5'=>'Traite', '6'=>'Fictif');


//$options=array('1'=>__('Species'),'2'=>__('Transfer'),'3'=>__('Bank check'));
echo "<div class='form-group'>" . $this->Form->input('payment_type', array(
        'label' => __('Payment type'),
        'empty' => __('Select payment type'),
        'type' =>'select',
        'options' =>$options,
        'id'=>'type_paiement',
		'onchange'=>'javascript : getPaymentEtatByPaymentType(); setNumberPaymentRequired();setOperationDateRequired();',
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
           'label' => __('Check number'),
           'id'=>'number_payment',
           'placeholder' => __('Enter number'),
           'class' => 'form-control',
       )) . "</div>";
	   
	   if(isset($type)){
		  echo "<div class='form-group'>" . $this->Form->input('type', array(
           'type' => 'hidden',
           'value' => $type,
		)) . "</div>";  
	   }
   

echo "<div class='form-group'>" . $this->Form->input('amount', array(
        'label' => __('Amount'),
        'placeholder' => __('Enter amount'),
        'type' => 'number',
        'value' =>$amount,
		'step'=>'0.0001',
        'class' => 'form-control',
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('compte_id', array(
        'label' => __('Compte'),
        'empty' => __('Select compte'),

        'class' => 'form-control select-popup',
    )) . "</div>"; ?>

<div  id ='deadline_date_div'>
   <?php

   echo "<div class='form-group'>" . $this->Form->input('deadline_date', array(
           'label' => '',
           'placeholder' => 'dd/mm/yyyy',
           'type' => 'text',
           'class' => 'form-control datemask',
           'before' => '<label>' . __('Deadline date') . '</label><div class="input-group date "><label for="DeadlineDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
           'after' => '</div>',
           'id' => 'deadline_date',
       )) . "</div>";
?>

</div>

<?php
echo "<div class='form-group'>" . $this->Form->input('note', array(
        'label' => __('Note'),
        'rows'=>'6',
        'cols'=>'30',
        'placeholder' => __('Enter note'),
        'class' => 'form-control',
    )) . "</div>";


echo $this->Form->submit(__('Save'), array(
    'name' => 'ok',
    'class' => 'btn btn-primary',
    'label' => __('Save'),
    'type' => 'submit',
    'id'=>'boutonValider',
    'div' => false
));



echo $this->Form->end();
echo $this->Js->writeBuffer(); //assuming this view is rendered without the default layout, make sure you write out the JS buffer at the bottom of the page
?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('maskedinput'); ?>
<script type="text/javascript">

    $(document).ready(function() {
        jQuery('#num_payment_div').css('display','none');
        jQuery('#deadline_date_div').css('display','none');
        jQuery("#receipt_date").inputmask("date", {"placeholder": "dd/mm/yyyy"});
        jQuery("#operation_date").inputmask("date", {"placeholder": "dd/mm/yyyy"});
        jQuery("#value_date").inputmask("date", {"placeholder": "dd/mm/yyyy"});
        jQuery("#deadline_date").inputmask("date", {"placeholder": "dd/mm/yyyy"});
        jQuery(".select2").select2();
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
                jQuery('#deadline_date_div').css('display','block');
            }
            else {
                jQuery('#num_payment_div').css('display','none');
                jQuery('#deadline_date_div').css('display','none');
            }
        });
    });
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
            if(jQuery('#type_paiement').val()=='4' || jQuery('#type_paiement').val()=='3'){
                jQuery('#number_payment').parent('.input').addClass('required');
                jQuery('#number_payment').prop('required','required');
            }else {
                jQuery('#number_payment').parent('.input').removeClass('required');
                jQuery('#number_payment').prop('required',false);
            }
        }

    function setOperationDateRequired(){
        if(jQuery('#type_paiement').val()=='4' || jQuery('#type_paiement').val()=='3'){
            jQuery('#operation_date').parent().parent('.input').addClass('required');
            jQuery('#operation_date').prop('required','required');
        }else {
            jQuery('#operation_date').parent().parent('.input').removeClass('required');
            jQuery('#operation_date').prop('required',false);
        }
    }






</script>
<?php die(); ?>