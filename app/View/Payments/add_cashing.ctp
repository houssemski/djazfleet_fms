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
echo "<div class='form-group'>" . $this->Form->input('compte_id', array(
        'label' => __('Compte'),
        'empty' => '',
        'class' => 'form-control select-popup',
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('transact_type_id', array(
        'label' => __('Compte'),
        'type'=>'hidden',
        'value'=>1,
        'empty' => '',
        'class' => 'form-control',
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('payment_association_id', array(
        'label' => __('Compte'),
        'type'=>'hidden',
        'value'=>7,
        'empty' => '',
        'class' => 'form-control',
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('wording', array(
        'label' => __('Wording'),
        'class' => 'form-control',
        'id'=>'wording',
        'required'=>true,
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('amount', array(
        'label' => __('Amount'),
        'placeholder' => __('Enter amount'),
        'type' => 'number',
		'step'=>'0.01',
        'class' => 'form-control',
    )) . "</div>";


$options=array('4'=>'Chèque' , '1'=>'Espèce', '3'=>'Chèque de banque', '2'=>'Virement', '5'=>'Traite', '6'=>'Fictif');


echo "<div class='form-group'>" . $this->Form->input('payment_type', array(
        'label' => __('Payment type'),
        'empty' => '',
        'type' =>'select',
        'options' =>$options,
        'id'=>'type_paiement',
		'onchange'=>'javascript : getPaymentEtatByPaymentType(); setNumberPaymentRequired();',
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
        'id'=>'payment_category',
        'class' => 'form-control select-popup',
    )) . "</div>";
echo "<div class='form-group'>" . $this->Form->input('number_payment', array(
        'label' => __('Check number'),
        'id'=>'number_payment',
        'placeholder' => __('Enter number'),
        'class' => 'form-control',
    )) . "</div>";
?>


</div>

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
 <?php   echo "<div class='form-group'>" . $this->Form->input('supplier_id', array(
        'label' => __('Third'),
        'empty' => '',
        'class' => 'form-control select-popup',
        'id'=>'third',
        'required'=>true,
    )) . "</div>";


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
<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>
<?= $this->Html->script('maskedinput'); ?>
    <script type="text/javascript">
        $(document).ready(function() {
            jQuery('#deadline_date_div').css('display','none');
            $(".select-popup").select2({

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
            //$('.select2-container').css('z-index','10000');
            jQuery('#third').parent('.input.select').addClass('required');
            jQuery('#wording').parent('.input.text').addClass('required');
            jQuery("#receipt_date").inputmask("date", {"placeholder": "dd/mm/yyyy"});
            jQuery("#operation_date").inputmask("date", {"placeholder": "dd/mm/yyyy"});
            jQuery("#value_date").inputmask("date", {"placeholder": "dd/mm/yyyy"});
            jQuery("#deadline_date").inputmask("date", {"placeholder": "dd/mm/yyyy"});
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
            if(jQuery('#type_paiement').val()=='4' || jQuery('#type_paiement').val()== '3' ){
                jQuery('#number_payment').parent('.input').addClass('required');
                jQuery('#number_payment').prop('required','required');
            }else {
                jQuery('#number_payment').parent('.input').removeClass('required');
                jQuery('#number_payment').prop('required',false);
            }
        }




    </script>
<?php die(); ?>