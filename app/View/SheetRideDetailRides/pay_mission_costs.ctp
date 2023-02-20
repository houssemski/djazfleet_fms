
<?php

echo $this->Form->create('MissionCostPayment');
echo "<div class='form-group'>" . $this->Form->input('reference', array(
        'label' => __('Reference'),
        'placeholder' => __('Enter reference'),
        'class' => 'form-control',
    )) . "</div>";
$current_date=date("Y-m-d");
echo "<div class='form-group'>" . $this->Form->input('receipt_date', array(
        'label' => '',
        'placeholder' => 'dd/mm/yyyy',
        'type' => 'text',
        'value'=>$this->Time->format($current_date, '%d/%m/%Y'),
        'class' => 'form-control datemask',
        'before' => '<label>' . __('Date') . '</label><div class="input-group date "><label for="PaymentDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
        'after' => '</div>',
        'id' => 'date',
    )) . "</div>";
$options=array('1'=>__('Species'),'2'=>__('Transfer'),'3'=>__('Bank check'));
echo "<div class='form-group'>" . $this->Form->input('payment_type', array(
        'label' => __('Payment type'),
        'empty' => __('Select payment type'),
        'type' =>'select',
        'options' =>$options,
        'class' => 'form-control',
    )) . "</div>";


echo "<div class='form-group'>" . $this->Form->input('amount', array(
        'label' => __('Amount'),
        'placeholder' => __('Enter amount'),
        'type' => 'number',
        'class' => 'form-control',
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
            jQuery("#date").inputmask("date", {"placeholder": "dd/mm/yyyy"});
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


            if(jQuery('input[name=affectation_client]:checked').val()=='2'){

                jQuery("#suppliers").css( "display", "block" );
            }else {
                jQuery("#suppliers").css( "display", "none" );
            }
            jQuery('input[name=affectation_client]').change(function () {
                if(jQuery('input[name=affectation_client]:checked').val()=='2'){
                    jQuery("#suppliers").css( "display", "block" );
                    jQuery('#suppliers').attr('required',true);
                }else {
                    jQuery("#suppliers").css( "display", "none" );

                    jQuery('#suppliers').attr('required',false);

                }

            });


        });



    </script>
<?php die(); ?>