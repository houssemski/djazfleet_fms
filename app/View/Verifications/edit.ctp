<?php
$this->request->data['Verification']['date_verif'] = $this->Time->format($this->request->data['Verification']['date_verif'], '%d-%m-%Y');
?><h4 class="page-title"> <?=__('Edit verification'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('Verification', array('onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">
	<?php
         echo $this->Form->input('id');
        echo "<div class='form-group'>".$this->Form->input('reference', array(
                    'label' => __('Reference'),
                    'placeholder' => __('Enter reference'),
                    'class' => 'form-control',
                    'error' => array('attributes' => array('escape' => false),
                                     'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>'. 
                                                     __("The reference must be unique") . '</label></div>', true)
                    ))."</div>";
                     echo "<div class='form-group'>".$this->Form->input('tire_id', array(
                    'label' => __('Tire'),
                    'class' => 'form-control select2',
                    'empty'=>'',
                    ))."</div>";
         echo "<div class='form-group'>" . $this->Form->input('date_verif', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Verification date') . '</label><div class="input-group date"><label for="VerificationDateVerif"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'date_verif',
                            )) . "</div>";



		echo "<div class='form-group'>".$this->Form->input('bande', array(
                    'label' => __('Tread'),
                    'class' => 'form-control',
                    'placeholder'=>__('Enter tread'),
                   ))."</div>";

        echo "<div class='form-group'>".$this->Form->input('wear', array(
                    'label' => __('Wear'),
                    'class' => 'form-control',
                    'placeholder'=>__('Enter wear'),
                   ))."</div>";
        echo "<div class='form-group'>".$this->Form->input('km', array(
                    'label' => __('Km'),
                    'class' => 'form-control',
                    'placeholder'=>__('Enter km'),
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
<?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<script type="text/javascript">

    $(document).ready(function() {
        jQuery("#date_verif").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

    });

     


</script>

<?php $this->end(); ?>