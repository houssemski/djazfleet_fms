<?php

?><h4 class="page-title"> <?= __('Edit tank'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0">
        <?php echo $this->Form->create('Tank', array('onsubmit' => 'javascript:disable();')); ?>
        <div class="box-body">
            <?php
            echo $this->Form->input('id');
            echo "<div class='form-group'>" . $this->Form->input('code', array(
                    'label' => __('Code'),
                    'class' => 'form-control',
                    'error' => array('attributes' => array('escape' => false),
                        'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                            __("The code must be unique") . '</label></div>', true)
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('name', array(
                    'label' => __('Name'),
                    'class' => 'form-control',
                )) . "</div>";

            echo "<div class='form-group'>" . $this->Form->input('fuel_id', array(
                    'label' => __('Fuel'),
                    'class' => 'form-control select2',
                )) . "</div>";

            echo "<div class='form-group'>" . $this->Form->input('capacity', array(
                    'label' => __('Capacity'),
                    'class' => 'form-control',
                )) . "</div>";

            echo "<div class='form-group'>" . $this->Form->input('localisation', array(
                    'label' => __('Localisation'),
                    'class' => 'form-control',
                )) . "</div>";
            ?>
        </div>
        <div class="box-footer">
            <?php echo $this->Form->submit(__('Submit'), array(
                'name' => 'ok',
                'class' => 'btn btn-primary btn-bordred  m-b-5',
                'label' => __('Submit'),
                'type' => 'submit',
                'id' => 'boutonValider',
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
