<?php

?><h4 class="page-title"> <?=__('Add recharge'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('Recharge' , array('onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">
	<?php
        echo "<div class='form-group'>".$this->Form->input('code', array(
                    'label' => __('Code'),
                    'placeholder' => __('Enter code'),
                    'class' => 'form-control',
                    'error' => array('attributes' => array('escape' => false),
                                     'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>'. 
                                                     __("The code must be unique") . '</label></div>', true)
                    ))."</div>";
                     echo "<div class='form-group'>".$this->Form->input('extinguisher_id', array(
                    'label' => __('Extinguisher'),
                    'class' => 'form-control select2',
                    'empty'=>__('Select extinguisher'),
                    ))."</div>";
         echo "<div class='form-group'>" . $this->Form->input('recharge_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Recharge date') . '</label><div class="input-group date"><label for="RechargeRechargeDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'recharge_date',
                            )) . "</div>";



       
        
 
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
        jQuery("#recharge_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    });

     


</script>

<?php $this->end(); ?>