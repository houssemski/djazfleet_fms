<?php

?><h4 class="page-title"> <?=__('Add extinquisher');?></h4>
<?php
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
$this->end();


?>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('Extinguisher' , array('onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">
		
                

                    
			<?php
		        echo "<div class='form-group'>".$this->Form->input('extinguisher_number', array(
                    'label' => __('Extinguisher number'),
                    'placeholder' => __('Enter extinguisher number'),
                    'class' => 'form-control',
                    'error' => array('attributes' => array('escape' => false),
                                     'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>'. 
                                                     __("The extinguisher number must be unique") . '</label></div>', true)
                    ))."</div>";
                   echo "<div class='form-group'>" . $this->Form->input('validity_day_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Validity day date') . '</label><div class="input-group date"><label for="ExtinguisherValidityDayDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'validity_date',
                            )) . "</div>";
                
                    

                      echo "<div class='form-group'>".$this->Form->input('volume', array(
                    'label' => __('Volume'),
                    'class' => 'form-control',
                    'placeholder' => __('Enter volume'),
                    ))."</div>";
                      echo "<div class='form-group'>".$this->Form->input('price', array(
                    'label' => __('Amount'),
                    'class' => 'form-control',
                    'placeholder' => __('Enter amount'),
                    ))."</div>";
                       echo "<div class='form-group'>".$this->Form->input('supplier_id', array(
                    'label' => __('Supplier'),
                    'class' => 'form-control select2',
                    'empty' => ''
                    ))."</div>";
                       echo "<div class='form-group'>".$this->Form->input('location_id', array(
                    'label' => __('Location'),
                    'class' => 'form-control select2',
                    'empty' =>''
                    ))."</div>";
					
				
	?>



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
        jQuery("#validity_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    });


</script>

<?php $this->end(); ?>
