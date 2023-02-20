<?php

$this->request->data['Compte']['creation_date'] = $this->Time->format($this->request->data['Compte']['creation_date'], '%d-%m-%Y');

?><h4 class="page-title"> <?=__('Edit compte'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('Compte' , array('onsubmit'=> 'javascript:disable();')); ?>
	<div class="box-body">
	<?php
		echo $this->Form->input('id');
                echo "<div class='form-group'>".$this->Form->input('num_compte', array(
                    'label' => __('Compte'),
                    'class' => 'form-control',
                    'error' => array('attributes' => array('escape' => false),
                                     'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>'. 
                                                     __("The code must be unique") . '</label></div>', true)
                    ))."</div>";


    $options = array('1' => __('Bank'), '2' => __('Species'));
    echo "<div class='form-group ' >" . $this->Form->input('type_id', array(
            'label' => __('Type'),
            'empty' => '',
            'id' => 'type',
            'onchange' => 'javascript:getInformationsByType();',
            'class' => 'form-control select2',
            'options' => $options
        )) . "</div>";

    echo "<div id='bank-div'>";
    echo "<div class='form-group ' >" . $this->Form->input('rib', array(
            'label' => __('RIB'),
            'class' => 'form-control ',
        )) . "</div>";

    echo "<div class='form-group ' >" . $this->Form->input('agency', array(
            'label' => __('Agency'),
            'class' => 'form-control ',
        )) . "</div>";

    echo "<div class='form-group '>" . $this->Form->input('creation_date', array(
            'label' => '',
            'placeholder' => 'dd/mm/yyyy',
            'type' => 'text',
            'class' => 'form-control datemask',
            'before' => '<label>' . __('Creation date') .
                '</label><div class="input-group date"><label for="CompteCreationDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
            'after' => '</div>',
            'id' => 'creation_date',
        )) . "</div>";
    echo "</div>";
    echo "<div class='form-group ' >" . $this->Form->input('amount', array(
            'label' => __('Balance'),
            'class' => 'form-control ',
        )) . "</div>";


    ?>
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
    $(document).ready(function () {
        jQuery("#creation_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        if(jQuery('#type').val()>0){
            if(jQuery('#type').val()==1){
                jQuery('#bank-div').css('display','block');
            }else {
                jQuery('#bank-div').css('display','none');
            }
        }
    });

    function getInformationsByType() {
        var type = jQuery('#type').val();
        if (type == 1) {
            jQuery('#bank-div').css('display','block');
        }else {
            jQuery('#bank-div').css('display','none');
        }

    }

</script>

<?php $this->end(); ?>
