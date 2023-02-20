<?php

?><h4 class="page-title"> <?=__('Edit Service')." ".lcfirst(Configure::read("Service")); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0">
        <?php echo $this->Form->create('Service' , array('onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">
            <?php
            echo $this->Form->input('id');

            echo "<div class='form-group'>".$this->Form->input('name', array(
                    'label' => __('Name'),
                    'class' => 'form-control',
                ))."</div>";

            echo "<div class='form-group'>".$this->Form->input('department_id', array(
                    'label' => __('Department'),
                    'empty' => __('Select department'),
                    'class' => 'form-control',
                ))."</div>";

            echo "<div class='form-group'>".$this->Form->input('supplier_id', array(
                    'label' => __('Client'),
                    'empty' => __('Select client'),
                    'class' => 'form-control select-search-client-initial',
                    'options'=>$suppliers,
                    'value'=>$supplierId,
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
