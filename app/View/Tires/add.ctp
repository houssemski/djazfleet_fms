<?php

?><h4 class="page-title"> <?=__('Add tire');?></h4>
<?php
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
$this->end();


?>
<div class="box">
    <div class="edit form card-box p-b-0">

<?php echo $this->Form->create('Tire', array('enctype' => 'multipart/form-data', 'onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">
		<div class="nav-tabs-custom pdg_btm">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
                    <li><a href="#tab_2" data-toggle="tab"><?= __('Purchase') ?></a></li>
                    
                </ul>
				<div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
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
                echo "<div class='form-group'>".$this->Form->input('model', array(
                    'label' => __('Model'),
                    'placeholder' => __('Enter model'),
                    'class' => 'form-control',
                    ))."</div>";
                echo "<div class='form-group'>".$this->Form->input('tire_mark_id', array(
                    'label' => __('Mark'),
                    'class' => 'form-control select2',
                    'empty' => ''
                    ))."</div>";
                    

                     
                      echo "<div class='form-group'>".$this->Form->input('note', array(
                    'label' => __('Note'),
                    'class' => 'form-control',
                    'placeholder' => __('Enter note'),
                    ))."</div>";
					
				
	?>
			</div>
			<div class="tab-pane " id="tab_2">
            <?php
                 echo "<div class='form-group'>".$this->Form->input('supplier_id', array(
                    'label' => __('Supplier'),
                    'class' => 'form-control select2',
                    'empty' => __('Select supplier'),
                    ))."</div>";
                     echo "<div class='form-group'>" . $this->Form->input('purchase_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Purchase date') . '</label><div class="input-group date"><label for="TirePurchaseDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'purchasedate',
                            )) . "</div>";
                        echo "<div class='form-group'>".$this->Form->input('cost', array(
                    'label' => __('Cost'),
                    'class' => 'form-control',
                    'placeholder' => __('Enter cost'),
                    ))."</div>";
                        echo "<div class='form-group'>".$this->Form->input('attachment', array(
                    'label' => __('Attachment'),
                    'class' => 'form-control',
                    'type'=>'file',
                    'empty' => ''
                    ))."</div>";

                    ?>
			</div>
			</div>
			
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
        jQuery("#purchasedate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

    });


</script>

<?php $this->end(); ?>
