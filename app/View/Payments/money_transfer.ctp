<style>
    .select2-container{
        z-index: 10000;
    }
#boutonValider {
max-width: 120px;
}
label {
    max-width: 30% !important;
    width: 30% !important;
}

.select2 {
 width: 60% !important;
}

input {
 width: 60% !important;
 display: inline;
}
.select2-search__field {
    width: 100% !important;
}
.datemask {
    width: 83% !important;
}
    .form-date-transfer .date {
    float: right !important;
    padding-bottom: 15px !important;
        width: 70% !important;
}
.form-date-transfer input label {
    float: left !important;
    padding-top: 12px !important;
}
</style>
<?php
if($result){

include("ctp/script.ctp");
include("ctp/index.ctp");
echo $this->Form->create('Payment', array('onsubmit'=> 'javascript:disable();')); ?>

<?php
echo "<div class='form-group'>" . $this->Form->input('origin_compte_id', array(
        'label' => __('From'),
        'empty' => '',
		'options'=>$comptes,
        'class' => 'form-control select2',
    )) . "</div>";
	
echo "<div class='form-group'>" . $this->Form->input('destination_compte_id', array(
        'label' => __('Towards'),
        'empty' => '',
		'options'=>$comptes,
        'class' => 'form-control select2',
    )) . "</div>";	 ?>
	


<?php	
echo "<div class='form-group'>" . $this->Form->input('wording', array(
        'label' => __('Wording'),
        'class' => 'form-control',
        'id'=>'wording',
		'style'=>"display: inline"
    )) . "</div>";	
$current_date=date("Y-m-d");

echo "<div class='form-group form-date-transfer'>" . $this->Form->input('receipt_date', array(
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

echo "<div class='form-group'>" . $this->Form->input('amount', array(
        'label' => __('Amount'),
        'placeholder' => __('Enter amount'),
        'type' => 'number',
		'step'=>'0.01',
        'class' => 'form-control',
		'style'=>"display: inline"
    )) . "</div>";

$options=array('4'=>'Chèque' , '1'=>'Espèce', '3'=>'Chèque de banque', '2'=>'Virement', '5'=>'Traite', '6'=>'Fictif');


//$options=array('1'=>__('Species'),'2'=>__('Transfer'),'3'=>__('Bank check'));
echo "<div class='form-group'>" . $this->Form->input('payment_type', array(
        'label' => __('Payment type'),
        'empty' => '',
        'type' =>'select',
        'options' =>$options,
        'id'=>'payment_type',
        'class' => 'form-control select2',
    )) . "</div>";
	
    echo "<div class='form-group'>" . $this->Form->input('number_payment', array(
           'label' => __('Number payment'),
           'placeholder' => __('Enter number'),
           'class' => 'form-control',
		   'style'=>"display: inline"
       )) . "</div>";	
	
echo "<div class='form-group'>" . $this->Form->input('supplier_id', array(
        'label' => __('Third'),
        'empty' => '',
        'class' => 'form-control select2',
        'id'=>'third',
    )) . "</div>";	
	
echo "<div class='form-group'>" . $this->Form->input('payment_category_id', array(
        'label' => __('Category'),
        'empty' => '',
        'type' =>'select',
        'id'=>'payment_category',
        'class' => 'form-control select2',
    )) . "</div>";	 ?>
	
	
	

<?php
$options=array('1'=>'Non défini' , '2'=>'Chez nous', '3'=>'En circulation', '4'=>'Payé', '5'=>'Impayé', '6'=>'Annulé');

echo "<div class='form-group'>" . $this->Form->input('payment_etat', array(
        'label' => __('Payment etat'),
        'empty' => '',
        'type' =>'select',
        'id'=>'payment_etat',
        'options' =>$options,
        'class' => 'form-control select2',
    )) . "</div>";

	
	

	   
echo "<div class='form-group form-date-transfer'>" . $this->Form->input('value_date', array(
        'label' => '',
        'placeholder' => 'dd/mm/yyyy',
        'type' => 'text',
        'class' => 'form-control datemask',
        'before' => '<label>' . __('Value date') . '</label><div class="input-group date "><label for="PaymentDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
        'after' => '</div>',
        'id' => 'value_date',
    )) . "</div><br/><br/><br/>";



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
}else {
    ?>
    <div id="flashMessage" class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo __("You don't have permission to add.") ?>
    </div>
    <?php  die();
}

?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('maskedinput'); ?>
<script type="text/javascript">

    $(document).ready(function() {
        jQuery("#receipt_date").inputmask("date", {"placeholder": "dd/mm/yyyy"});
        jQuery("#value_date").inputmask("date", {"placeholder": "dd/mm/yyyy"});
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




</script>
<?php die(); ?>