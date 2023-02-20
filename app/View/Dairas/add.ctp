<?php

?><h4 class="page-title"> <?=__('Ajouter province');?></h4>

<?php
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
$this->end();
?>

<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('Daira' , array('onsubmit'=> 'javascript:disable();')); ?>
	<div class="box-body">
	<?php
        echo "<div class='form-group'>".$this->Form->input('code', array(
                    'label' => __('Code').' '.__('Daira'),
                    'class' => 'form-control',
                    'placeholder'=>__('Enter code'),
                    'error' => array('attributes' => array('escape' => false),
                                     'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>'. 
                                                     __("The code must be unique") . '</label></div>', true)
                    ))."</div>";
		echo "<div class='form-group'>".$this->Form->input('name', array(
                    'label' => __('Name').' '.__('Province'),
                    'placeholder'=>__('Enter name'),
                    'class' => 'form-control',
                    ))."</div>";
    echo "<div class='form-group input-button' id='wilayas'>".$this->Form->input('wilaya_id', array(
            'label' => __('Name').' '.__('Région'),
            'empty'=>__('Select région'),
            'class' => 'form-control select2',
        ))."</div>";

	?>

        <!-- overlayed element -->
        <div id="dialogModalWilaya">
            <!-- the external content is loaded inside this tag -->
            <div id="contentWrapWilaya"></div>
        </div>
        <div class="popupactions">

            <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                array("controller" => "dairas", "action" => "addWilaya"),
                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayWilaya",'escape' => false, "title" => __("Add Wilaya"))); ?>

        </div>
        <div style="clear:both"></div>

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
<?= $this->Html->script('jquery-2.1.1.min.js'); ?>
<?= $this->Html->script('jquery.form.min.js'); ?>

<script type="text/javascript">
    $( document ).ready(function(){
jQuery("#dialogModalWilaya").dialog({
autoOpen: false,
height: 320,
width: 400,
show: {
effect: "blind",
duration: 400
},
hide: {
effect: "blind",
duration: 500
},
modal: true
});
jQuery(".overlayWilaya").click(function (event) {
event.preventDefault();
jQuery('#contentWrapWilaya').load(jQuery(this).attr("href"));
jQuery('#dialogModalWilaya').dialog('option', 'title', jQuery(this).attr("title"));
jQuery('#dialogModalWilaya').dialog('open');
});
    });

</script>

<?php $this->end(); ?>