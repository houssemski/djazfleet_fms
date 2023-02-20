<?php

?><h4 class="page-title"> <?=__('Add bill Fuel log'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('FuelLog' , array('onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">
	<?php
        echo "<div class='form-group'>".$this->Form->input('num_bill', array(
                    'label' => __('Num bill'),
                    'class' => 'form-control',
                 
                    ))."</div>";

        echo "<div class='form-group'>".$this->Form->input('nb_fuellog', array(
                    'label' => __('Number fuellog'),
                    'class' => 'form-control',
                    ))."</div>";

        echo "<div class='form-group'>".$this->Form->input('num_fuellog', array(
                    'label' => __('Num fuellog'),
                    'class' => 'form-control',
                    ))."</div>";
          echo "<div class='form-group'>".$this->Form->input('price_coupon', array(
                    'label' => __('Coupon price'),
                    'class' => 'form-control',
                    ))."</div>";
        echo "<div class='form-group'>" . $this->Form->input('date', array(
                                'label' =>'',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Date') .
                                    '</label><div class="input-group date"><label for="CarPurchasingDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                'after' => '</div>',
                                'id' => 'date',
                            )) . "</div>";
		echo "<div class='form-group'>".$this->Form->input('first_number_coupon', array(
                    'label' => __('First number coupon'),
                    'class' => 'form-control',
                    ))."</div>";
       echo "<div class='form-group'>".$this->Form->input('last_number_coupon', array(
                    'label' => __('Last number coupon'),
                    'class' => 'form-control',
                    ))."</div>";

    echo "<div class='form-group'>".$this->Form->input('price', array(
            'label' => __('Price'),
            'class' => 'form-control',
        ))."</div>";
         
	?>
             </div>
        <div class="box-footer">
            <?php echo $this->Form->submit(__('Submit'), array(
                'name' => 'ok',
                'class' => 'btn btn-primary btn-bordred  m-b-5',
                'label' => __('Submit'),
                'type' => 'submit',
                'id'=>'boutonValider',
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
<?php $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
<?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<script type="text/javascript">     $(document).ready(function() {

        jQuery("#date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    });

</script>
<?php $this->end(); ?>