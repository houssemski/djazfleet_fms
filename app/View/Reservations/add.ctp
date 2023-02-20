<?php

?><h4 class="page-title"> <?=__('Add Marchandise'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('Marchandise'); ?>
        <div class="box-body">
            <?php
            echo "<div class='form-group'>".$this->Form->input('wording', array(
                    'label' => __('Code'),
                    'class' => 'form-control',
                    'placeholder' =>__('Enter code'),
                    ))."</div>";

                     echo "<div class='form-group'>".$this->Form->input('name', array(
                    'label' => __('Name'),
                    'class' => 'form-control',
                    'placeholder' =>__('Enter name'),
                    ))."</div>";
                    
                    
		            echo "<div class='form-group'>".$this->Form->input('marchandise_type_id', array(
                    'label' => __('Type'),
                    
                    'empty' =>__('Select type'),
                    'class' => 'form-control select2',
                    ))."</div>";
            
                      
                    echo "<div class='form-group'>".$this->Form->input('marchandise_unit_id', array(
                    'label' => __('Unit'),
                    'empty' =>__('Select unit'),
                    'class' => 'form-control select2',
                    ))."</div>";

                    echo "<div class='form-group'>".$this->Form->input('supplier_id', array(
                    'label' => __('Client'),
                    'empty' =>__('Select client'),
                    'class' => 'form-control select2',
                    ))."</div>";

                     echo "<div class='form-group'>".$this->Form->input('quantity_stock', array(
                    'label' => __('Quantity').__(' ')  .__('stock'),
                    'placeholder' =>__('Enter').__(' ')  .__('quantity').__(' ')  .__('stock'),
                    'class' => 'form-control',
                    ))."</div>";

                    echo "<div class='form-group'>".$this->Form->input('quantity_min', array(
                    'label' => __('Quantity min'),
                    'placeholder' =>__('Enter').__(' ')  .__('quantity').__(' ')  .__('min'),
                    'class' => 'form-control',
                    ))."</div>";

            echo "<div class='form-group'>".$this->Form->input('quantity_max', array(
                    'label' => __('Quantity max'),
                    'placeholder' =>__('Enter').__(' ')  .__('quantity').__(' ')  .__('max'),
                    'class' => 'form-control',
                ))."</div>";

            echo "<div class='form-group'>".$this->Form->input('weight', array(
                    'label' => __('Weight').__(' (Kg)'),
                    'placeholder' =>__('Enter weight'),
                    'class' => 'form-control',
                ))."</div>";





                    echo "<div class='form-group'>".$this->Form->input('description', array(
                    'label' => __('Description'),
                    'placeholder' =>__('Enter description'),
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

