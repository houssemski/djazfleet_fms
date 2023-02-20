<?php
?><h4 class="page-title"> <?=__('Ajouter région'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('Wilaya', array('onsubmit'=> 'javascript:disable();')); ?>
	<div class="box-body">
	<?php
        echo "<div class='form-group'>".$this->Form->input('code', array(
                    'label' => __('Code').' '.__('Région'),
                    'class' => 'form-control',
                    'placeholder'=>__('Enter code'),
                    'error' => array('attributes' => array('escape' => false),
                                     'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>'. 
                                                     __("The code must be unique") . '</label></div>', true)
                    ))."</div>";
		echo "<div class='form-group'>".$this->Form->input('name', array(
                    'label' => __('Name').' '.__('Région'),
                    'placeholder'=>__('Enter name'),
                    'class' => 'form-control',
                    ))."</div>";


            echo "<div class='form-group'>".$this->Form->input('zone_id', array(
                    'label' => __('Name').' '.__('Zone'),
                    'empty'=>'',
                    'class' => 'form-control select2',
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