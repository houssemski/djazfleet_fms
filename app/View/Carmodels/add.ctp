<?php

?><h4 class="page-title"> <?=__('Add model'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('Carmodel' , array('onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">
	<?php
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
                echo "<div class='form-group'>".$this->Form->input('mark_id', array(
                    'label' => __('Mark'),
                    'class' => 'form-control select2',
                    'empty' => ''
                    ))."</div>";
					
					foreach ($fuels as $fuel){
						
						 echo "<div class='form-group'>".$this->Form->input('consumption_'.$fuel['Fuel']['code'], array(
                    'label' => __('Nb Km for 1 coupon of ').$fuel['Fuel']['name'],
                    'class' => 'form-control',
                    ))."</div>";
					
					}
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
