<style>
    .select2-container{
        z-index: 10000;
    }
</style>
<?php

$this->start('css');
echo $this->Html->css('select2/select2.min');

$this->end();

echo $this->Form->create('TransportBill', array('onsubmit'=> 'javascript:disable();'));
?>
    <br>
    <p style="font-weight: bold;"><?php echo __('Method of transformation')?></p>

    <input style="position: relative;top: 2px;" type="radio" name="method_transform"  <?php if(count($arrayIds)==1){?> checked='checked' <?php }?> value="1">
    <span style="padding-left: 10px;"><?php echo __('Create a single overall part')?></span><br>
    <input style="position: relative;top: 2px;margin-top: 10px;" type="radio" name="method_transform" <?php if(count($arrayIds)>1){?> checked='checked' <?php }?> value="2">
    <span style="padding-left: 10px;"> <?php echo __('Transforming piece by piece')?></span><br>
    <br>
<?php
$current_date=date("Y-m-d");
echo "<div class='form-group'>" . $this->Form->input('date', array(
        'label' => '',
        'placeholder' => 'dd/mm/yyyy',
        'type' => 'text',
        'value'=>$this->Time->format($current_date, '%d/%m/%Y'),
        'class' => 'form-control datemask',
        'before' => '<label>' . __('Date') . '</label><div class="input-group date "><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
        'after' => '</div>',
        'id' => 'date',
    )) . "</div>";
?>
    <br>

<?php
echo "<div  class='form-group'>".$this->Form->input('tva_id', array(
        'label' => __('TVA'),
        'empty' =>'',
        'id'=>'supplier',
        'type'=>'select',
        'options'=>$tvas,
        'value'=>1,
        'class' => 'form-control',
        'style'=> 'color: #222;font-size: 14px;'
    ))."</div>";
if(TransportBillTypesEnum::invoice){

$options = array(   '1' => __('A terme'),
                    '2' => __('Chèque'),
                    '3' => __('Chèque-banque'),
                    '4' => __('Virement'),
                    '5' => __('Avoir'),
                    '6' => __('Espèce'),
                    '7' => __('Traite'),
                    '8' => __('Fictif'));

echo "<div  class='form-group'>" . $this->Form->input('payment_method', array(
        'label' => __('Payment method'),
        'class' => 'form-control select-search ',
        'options' => $options,
        'id' => 'payment_method',
        'empty'=>'',
        'style'=> 'color: #222;font-size: 14px;',
    )) . "</div>";


echo "<div  class='form-group'>" . $this->Form->input('discount_percentage', array(
        'label' => __('Discount') . ' ' . ('%'),
        'class' => 'form-control',
        'id' => 'discount_percentage',
        'style'=> 'color: #222;font-size: 14px;'
    )) . "</div>";
?>
<div style="clear: both"></div><br/><br/>
    <?php } ?>
    <p style="font-weight: bold;"><?php echo __('Affectation client')?></p>

    <input style="position: relative;top: 2px;" type="radio" name="affectation_client" <?php if(count($arrayIds)==1){?> checked='checked' <?php }?>value="1">
    <span style="padding-left: 10px;"><?php echo __('Keep origin client')?></span><br>
    <input style="position: relative;top: 2px;margin-top: 10px;" type="radio" name="affectation_client" <?php if(count($arrayIds)>1){?> checked='checked' <?php }?>value="2">
    <span style="padding-left: 10px;"> <?php echo __('Affect this client')?></span>
    <br><br>

<?php

echo "<div id='suppliers' class='form-group'>".$this->Form->input('supplier_id', array(
        'label' => __('Client'),
        'empty' =>'',
        'id'=>'client_to_affect',
        'type'=>'select',
        'options'=>$suppliers,
        'class' => 'form-control select3',
        'style'=> 'color: #222;font-size: 14px;'
    ))."</div>";

?>

<?php echo $this->Form->submit(__('Save'), array(
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
            $('.select3').select2();
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
                jQuery("#client_to_affect").attr("required", "required");
                jQuery('#client_to_affect').parent('.input.select').addClass('required');
            }else {
                jQuery("#suppliers").css( "display", "none" );
                jQuery('#client_to_affect').parent('.input.select').removeClass('required');
                $('#client_to_affect').removeAttr("required");
            }
            jQuery('input[name=affectation_client]').change(function () {
                if(jQuery('input[name=affectation_client]:checked').val()=='2'){
                    jQuery("#suppliers").css( "display", "block" );
                    jQuery('#client_to_affect').parent('.input.select').addClass('required');
                    jQuery("#client_to_affect").attr("required", "required");
                }else {
                    jQuery("#suppliers").css( "display", "none" );
                    jQuery('#client_to_affect').parent('.input.select').removeClass('required');
                    $('#client_to_affect').removeAttr("required");

                }
            });


        });





    </script>
<?php die(); ?>