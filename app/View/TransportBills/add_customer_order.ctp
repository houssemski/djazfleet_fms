<?php
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
$this->end();
?>
<h4 class="page-title"> <?= __('Add customer order'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-10">
<?php echo $this->Form->create('TransportBill', array('onsubmit' => 'javascript:disable();')); ?>
        <div class="box-body" >
            <?php
$current_date = date("Y-m-d");
echo "<div class='form-group'>" . $this->Form->input('date', array(
        'label' => '',
        'placeholder' => 'dd/mm/yyyy',
        'type' => 'text',
        'value' => $this->Time->format($current_date, '%d/%m/%Y'),
        'class' => 'form-control datemask',
        'before' => '<label>' . __('Date') . '</label><div class="input-group date"><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
        'after' => '</div>',
        'id' => 'date',
    )) . "</div>";

echo '<div style="clear:both"></div>';
if ($profileId == ProfilesEnum::client) {
    echo "<div class='form-group'>" . $this->Form->input('supplier_id', array(
            'label' => __('Initial customer'),
            'empty' => '',
            'id' => 'client',
            'value' => $supplierId,
            'type' => 'hidden',
            //'onchange'=>'javascript : getFinalSupplierByInitialSupplier();',
            'class' => 'form-control',
        )) . "</div>";
} else {
    echo "<div class='form-group'>" . $this->Form->input('supplier_id', array(
            'label' => __('Initial customer'),
            'empty' => '',
            'id' => 'client',
            //'onchange'=>'javascript : getFinalSupplierByInitialSupplier();',
            'class' => 'form-control select-search-client-initial',
        )) . "</div>";
}

echo '<div style="clear:both"></div>';

echo "<div class='form-group' id ='supplier_final_div'>" . $this->Form->input('supplier_final_id', array(
        'label' => __('Final customer'),
        'empty' => '',
        'id' => 'client_final',
        // 'options' => $suppliers,
        'class' => 'form-control select-search-client-final',
    )) . "</div>";


echo "<div class='form-group'>" . $this->Form->input('ride_id', array(
        'label' => __('Ride'),
        'empty' => '',
        'id' => 'ride',
        'class' => 'form-control',
    )) . "</div>";
echo '<div style="clear:both"></div>';


echo "<div class='form-group'>" . $this->Form->input('car_type_id', array(
        'label' => __('Transportation'),
        'empty' => '',
        'id' => 'car_type',
        'class' => 'form-control select-search'
    )) . "</div>";

if ($useRideCategory == 2) {
    echo "<div class='form-group'>" . $this->Form->input('ride_category_id', array(
            'label' => __('Ride category'),
            'empty' => '',
            'id' => 'ride_category',
            'class' => 'form-control select-search',
        )) . "</div>";
}
echo '<div style="clear:both"></div>';


echo "<div class='form-group'>" . $this->Form->input('nb_trucks', array(
        'label' => __('Number of trucks'),
        'value' => 1,
        'type' => 'number',
        'placeholder' => __('Enter number of trucks'),
        'class' => 'form-control '
    )) . "</div>";
echo "<div id='interval2'>";
echo '<div class="lbl4">' . __("Delivery with return");
echo "</div>";
            $options = array('1' => __('Simple delivery'), '2' => __('Simple return'), '3' => __('Delivery / Return'));

$attributes = array('legend' => false, 'value' => '2');
echo $this->Form->radio('delivery_with_return', $options, $attributes) . "</div><br/>";


?>
						</br>
  <div style='clear:both;'></div>

                 <?php  echo "<div  class='form-group'>" . $this->Form->input('note', array(
        'label' => __('Note'),

        'class' => 'form-control',


    )) . "</div>";
?>

	

				</div>
             
                
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
			 
<div style="clear:both;"></div>

    </div>

</div>
<?php $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('maskedinput'); ?>
<script type="text/javascript">

$(document).ready(function() {
       jQuery("#date").inputmask("date", {"placeholder": "dd/mm/yyyy"});

       if(jQuery('#client').val()>0){
      // getFinalSupplierByInitialSupplier();
       }

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