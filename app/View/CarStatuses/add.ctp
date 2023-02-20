
<?php

?><h4 class="page-title"> <?=__('Add Car status');?></h4>
<?php
$this->start('css');
echo $this->Html->css('colorpicker/css/colorpicker');
echo $this->Html->css('colorpicker/css/layout');
$this->end();
 ?>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('CarStatus' , array('onsubmit'=> 'javascript:disable();')); ?>
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

    echo "<div class='form-group my-colorpicker colorpicker-element color'>" . $this->Form->input('color', array(
            'label' => __('Color'),
            'id'=>'color',
            'placeholder' => __('Select color'),
            'class' => 'form-control',
        )) . "<div id='colorSelector'><div style='background-color: #0000ff'></div></div></div>";
                echo "<div class='form-group chk ' style='padding-top: 15px; '>".$this->Form->input('bookable', array(
                    'label' => __('Bookable'),
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
<?php $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
<?= $this->Html->script('plugins/colorpicker/js/colorpicker'); ?>
<?= $this->Html->script('plugins/colorpicker/js/layout.js?ver=1.0.2'); ?>
<?= $this->Html->script('plugins/colorpicker/js/eye'); ?>
<?= $this->Html->script('plugins/colorpicker/js/utils'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        jQuery('#colorSelector').ColorPicker({
            color: '#0000ff',
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#colorSelector div').css('backgroundColor', '#' + hex);
                $('#color').val('#' +hex);
            }

        });
    });

</script>

<?php $this->end(); ?>
