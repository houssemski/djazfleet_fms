<?php

?><h4 class="page-title"> <?=__('Edit Car Type'); ?></h4>

<div class="box">
    <div class="edit form card-box p-b-0">

<?php echo $this->Form->create('CarType', array('enctype' => 'multipart/form-data', 'onsubmit'=> 'javascript:disable();')); ?>
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
                echo "<div class='form-group'>".$this->Form->input('CarTypeCarCategory.car_category_id', array(
                    'label' => __('Category'),
                     'class' => 'form-control select2',
                     'multiple'=>true,
                    'empty'=>'',
                    'id'=>'category',
                        'value'=>$carCategoriesSelected,
                    ))."</div>";

                echo "<div class='form-group'>".$this->Form->input('average_speed', array(
                    'label' => __('Average speed').' '._('(Km/h)'),
                    'class' => 'form-control',
                    'multiple'=>true,
                    'placeholder'=>__('Enter average speed'),
                    'id'=>'category',
                ))."</div>";
            echo  $this->Form->input('picture', array(
                    'label' => __('Picture'),
                    'id' => 'picture1',
                    'type' => 'file',
                    'onchange' => 'javascript:verif_ext_attachment(1,this.id)',
                    'class' => 'form-control',


                )) ;

            echo "<div class='form-group audiv1'>" . $this->Form->input('display_model_mission_order', array(
                    'label' => __('Display model in mission order'),
                    'id' => 'display_model_mission_order',
                )) . "</div>";
	?>
        <div class="clear:both"></div>
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
<?= $this->Html->script('jquery-2.1.1.min.js'); ?>
<?= $this->Html->script('jquery.form.min.js'); ?>


<?php $this->end(); ?>
