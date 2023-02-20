<?php

?><h4 class="page-title"> <?=__('Edit Mark'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0">

<?php echo $this->Form->create('Mark', array('enctype' => 'multipart/form-data', 'onsubmit'=> 'javascript:disable();')); ?>
	<div class="box-body">
	<?php
		echo $this->Form->input('id');
                echo "<div class='form-group'>".$this->Form->input('code', array(
                    'label' => __('Code'),
                    'class' => 'form-control',
                    'error' => array('attributes' => array('escape' => false),
                                     'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>'. 
                                                     __("The code must be unique") . '</label></div>', true)
                    ))."</div>";
		echo "<div class='form-group'>".$this->Form->input('name', array(
                    'label' => __('Name'),
                    'class' => 'form-control',
                    ))."</div>";
    echo "<div class='form-group'>" . $this->Form->input('logo', array(
            'label' => __('Logo'),
            'class' => 'form-control',
            'type' => 'file',
            'empty' => ''
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
