<?php
?><h4 class="page-title"> <?=__('Edit Zone'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('Zone', array('onsubmit'=> 'javascript:disable();')); ?>
	<div class="box-body">
            <?php
		echo $this->Form->input('id');
                echo "<div class='form-group'>".$this->Form->input('code', array(
                    'label' => __('Code'),
                     'placeholder'=>__('Enter code'),
                    'class' => 'form-control',
                    'error' => array('attributes' => array('escape' => false),
                                     'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>'. 
                                                     __("The code must be unique") . '</label></div>', true)
                    ))."</div>";
                echo "<div class='form-group'>".$this->Form->input('name', array(
                    'label' => __('Name'),
                    'placeholder'=>__('Enter name'),
                    'class' => 'form-control',
                    ))."</div>";
                  echo "<div class='form-group'>" . $this->Form->input('cost', array(
                    'label' => __('Mission costs'),
                    'placeholder' => __('Enter')." ".Configure::read("Cost"),
                    'class' => 'form-control',
                    'id' => 'cost',
                    'empty' => ''
                )) . "</div>";
            echo "<div class='form-group'>".$this->Form->input('rotation_number', array(
                    'label' => __('Rotation number'),
                    'class' => 'form-control',
                ))."</div>";
            $options=array('1'=>__('day'),'2'=>__('week'));
            $attributes=array('legend'=>false);
            echo  $this->Form->radio('rotation_number_type',$options,$attributes);
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
