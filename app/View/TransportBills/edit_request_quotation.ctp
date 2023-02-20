<?= $this->Form->input('controller', array(
    'id' => 'controller',
    'value' => $this->request->params['controller'],
    'type' => 'hidden'
)); ?>
<?= $this->Form->input('current_action', array(
    'id' => 'current_action',
    'value' => $this->request->params['action'],
    'type' => 'hidden'
)); ?>


<?php

?><h4 class="page-title"> <?= __('Edit request quotation'); ?></h4>


  <style>
 .select label {

 display: block;
 }
    </style>
	
<?php $this->request->data['TransportBill']['date'] = $this->Time->format($this->request->data['TransportBill']['date'], '%d-%m-%Y'); ?>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('TransportBill', array('onsubmit' => 'javascript:disable();')); ?>
        <div class="box-body" >
            <?php
echo $this->Form->input('id');

if ($reference != '0') {
    echo "<div class='form-group'>" . $this->Form->input('reference', array(
            'label' => __('Reference'),
            'class' => 'form-control',

            'readonly' => true,
            'placeholder' => __('Enter reference'),
        )) . "</div>";
} else {
    echo "<div class='form-group'>" . $this->Form->input('reference', array(
            'label' => __('Reference'),
            'class' => 'form-control',

            'placeholder' => __('Enter reference'),
        )) . "</div>";

}

echo "<div class='form-group'>" . $this->Form->input('date', array(
        'label' => '',
        'placeholder' => 'dd/mm/yyyy',
        'type' => 'text',

        'class' => 'form-control datemask',
        'before' => '<label>' . __('Date') . '</label><div class="input-group date "><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
        'after' => '</div>',
        'id' => 'date',
    )) . "</div>";

echo "<div class='form-group input-button' id='categories'>" . $this->Form->input('transport_bill_category_id', array(
        'label' => __('Category'),
        'empty' => '',
        'id' => 'category',
        'class' => 'form-control select-search',
    )) . "</div>"; ?>


<!-- overlayed element -->
            <div id="dialogModalCategory">
                <!-- the external content is loaded inside this tag -->
                <div id="contentWrapCategory"></div>
            </div>
            <div class="popupactions">

                <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
    array("controller" => "transportBills", "action" => "addCategory"),
    array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayCategory", 'escape' => false, "title" => __("Add Category"))); ?>

            </div>
            <div style="clear:both"></div>

<?php
if ($profileId == ProfilesEnum::client) {
    echo "<div class='form-group'>" . $this->Form->input('supplier_id', array(
            'label' => __('Initial customer'),
            'empty' => '',
            'id' => 'client',
            'value' => $supplierId,
            'type' => 'hidden',
            //'onchange'=>'javascript : getFinalSupplierByInitialSupplier();',
            'class' => 'form-control ',
        )) . "</div>";
} else {
    echo "<div class='form-group'>" . $this->Form->input('supplier_id', array(
            'label' => __('Initial customer'),
            'empty' => '',
            'id' => 'client',
            // 'onchange'=>'javascript : getFinalSupplierByInitialSupplier();',
            'class' => 'form-control select-search-client-initial',
        )) . "</div>";
}

echo "<div class='form-group' id='supplier_final_div'>" . $this->Form->input('supplier_final_id', array(
        'label' => __('Final customer'),
        'empty' => '',
        'id' => 'client_final',
        'options' => $finalSuppliers,
        'class' => 'form-control select-search-client-final',
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('product_id', array(
        'type' => 'hidden',
        'id' => 'product',
    )) . "</div>";
echo "<div class='form-group'>" . $this->Form->input('ride_id', array(
        'label' => __('Ride'),
        'empty' => '',
        'id' => 'ride',
        'class' => 'form-control',
    )) . "</div>";


echo "<div class='form-group'>" . $this->Form->input('car_type_id', array(
        'label' => __('Transportation'),
        'empty' => '',
        'id' => 'car_type',
        'class' => 'form-control select-search',
    )) . "</div>";
if ($useRideCategory == 2) {
    echo "<div class='form-group'>" . $this->Form->input('ride_category_id', array(
            'label' => __('Ride category'),
            'empty' => '',
            'id' => 'ride_category',
            'class' => 'form-control select-search',
        )) . "</div>";
}
echo "<div id='interval2'>";
echo '<div class="lbl4">' . __("Simple delivery / return");
echo "</div>";
$options = array('1' => __('Simple delivery'), '2' => __('Simple return'), '3' => __('Delivery / Return'));
$attributes = array('legend' => false);
echo $this->Form->radio('delivery_with_return', $options, $attributes) . "</div><br/>";


echo "<div class='form-group'>" . $this->Form->input('nb_trucks', array(
        'label' => __('Number of trucks'),

        'type' => 'number',
        'placeholder' => __('Enter number of trucks'),
        'class' => 'form-control',
    )) . "</div>";
echo "<div class='form-group'>" . $this->Form->input('total_weight', array(
        'label' => __('Total weight'),
        'placeholder' => __('Poids total ou maximal'),
        'class' => 'form-control',
    )) . "</div>";


echo "<div class='form-group' >" . $this->Form->input('customer_id', array(
        'label' => __('Commercial'),
        'empty' => '',
        'id' => 'commercial',
        'class' => 'form-control select-search-customer',
    )) . "</div>";
?>

						</br>
                        <div style='clear:both;'></div>

                 <?php  echo "<div  class='form-group'>" . $this->Form->input('note', array(
        'label' => __('Note'),

        'class' => 'form-control',


    )) . "</div>";
?>
	
<div style="clear:both;"></div>
        <div class="box-footer">
            <?php echo $this->Form->submit(__('Submit'), array(
    'name' => 'ok',
    'class' => 'btn btn-primary btn-bordred  m-b-5',
    'label' => __('Submit'),
    'type' => 'submit',
    'id' => 'boutonValider',
    'div' => false
)); ?>
<?php echo $this->Form->submit(__('Cancel'), array(
    'name' => 'cancel',
    'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
    'label' => __('Cancel'),
    'type' => 'submit',
    'div' => false,
    'formnovalidate' => true
)); ?>
        </div>
				</div>

       
             </div>
			 

    </div>

</div>
<?php $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>

<script type="text/javascript">

$(document).ready(function() {
        jQuery("#date").inputmask("date", {"placeholder": "dd/mm/yyyy"});

          if (jQuery('#commercial').val()) {
            var customerId = jQuery('#commercial').val();
        } else {
            var customerId = '';
        }

        $('.select-search-customer').select2({
            ajax: {
                url: "<?php echo $this->Html->url('/customers/getCustomersByKeyWord') ?>",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: $.trim(params.term),
                        controller: jQuery('#controller').val(),
                        action: jQuery('#current_action').val(),
                        customerId: customerId
                    };
                },
                processResults: function (data, page) {
                    return {results: data};
                },
                cache: true
            },
            minimumInputLength: 2
        });

                jQuery("#dialogModalCategory").dialog({
            autoOpen: false,
            height: 320,
            width: 400,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery(".overlayCategory").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapCategory').load(jQuery(this).attr("href"));
            jQuery('#dialogModalCategory').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalCategory').dialog('open');
        });

    });

  function getFinalSupplierByInitialSupplier(){
   var supplierId = jQuery('#client').val();
   jQuery("#supplier_final_div").load('<?php echo $this->Html->url('/transportBills/getFinalSupplierByInitialSupplier/') ?>'+ supplierId, function() {
                 $(".select-search").select2({
                sorter: function (data) {

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
                allowDuplicates: true,
                placeholder: "Sélectionner"

            });
        });
   }










</script>

<?php $this->end(); ?>