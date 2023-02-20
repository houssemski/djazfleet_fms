<?php

?><h4 class="page-title"> <?=__('Add shifting'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('Shifting', array('onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">
	<?php
        echo "<div class='form-group'>".$this->Form->input('reference', array(
                    'label' => __('Reference'),
                    'placeholder' => __('Enter reference'),
                    'class' => 'form-control',
                    'error' => array('attributes' => array('escape' => false),
                                     'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>'. 
                                                     __("The code must be unique") . '</label></div>', true)
                    ))."</div>";
         echo "<div class='form-group'>" . $this->Form->input('shifting_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Shifting date') . '</label><div class="input-group date"><label for="ShiftingShiftingDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'shifting_date',
                            )) . "</div>";

                             echo "<div class='form-group'>".$this->Form->input('car_id', array(
                    'label' => __('Car'),
                    'class' => 'form-control select2',
                    'empty'=>__('Select car'),
                    ))."</div>";
 echo "<div class='form-group'>".$this->Form->input('tire_id', array(
                    'label' => __('Tire'),
                    'class' => 'form-control select2',
                    'empty'=>__('Select tire'),
                    ))."</div>";

		echo "<div class='form-group'>".$this->Form->input('installed', array(
                    'label' => __('Installed'),
                    'class' => 'form-control',
                    'id'=> 'installed'
                   ))."</div>";
  

         echo "<div class='form-group'>".$this->Form->input('position_id', array(
                    'label' => __('Position'),
                    'empty'=>__('Select position'),
                    'class' => 'form-control select2',
                    ))."</div>";

       
        echo "<div class='form-group'>".$this->Form->input('km', array(
                    'label' => __('Km'),
                    'placeholder' => __('Enter km'),
                    'class' => 'form-control',
                    ))."</div>";
        echo "<div class='form-group'>".$this->Form->input('note', array(
                    'label' => __('Note'),
                    'placeholder' => __('Enter note'),
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
<script type="text/javascript">
    $(document).ready(function() {
        jQuery("#shifting_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

    });

     


</script>

<?php $this->end(); ?>