<h4 class="page-title"> <?=__('Add Event type'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('EventType' , array('onsubmit'=> 'javascript:disable();')); ?>
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
                echo "<div class='form-group'>".$this->Form->input('event_type_categories', array(
                    'label' => __('Category'),
                    'class' => 'form-control',
                     'type' => 'select',
                    'empty' => '',
                        'id'=>'type'
                    ))."</div>";
                echo "<div class='form-group'>".$this->Form->input('name', array(
                    'label' => __('Name'),
                    'class' => 'form-control',
                    ))."</div>";
                echo "<div class='form-group'>".$this->Form->input('transact_type_id', array(
                    'label' => __('Transaction type'),
                    'class' => 'form-control',
                    'options' => array(1 => __('Encasement'), 2 => __('Disbursement')),
                    'empty' => ''
                    ))."</div>";
                   

                  echo "<div class='form-group'>".$this->Form->input('alert_activate', array(
                    'label' => __('Alert activate'),
                     'checked' => 'checked',
                    'class' => 'form-control',
                    ))."</div>";
                echo "<div class='form-group mdiv'>".$this->Form->input('with_km', array(
                    'label' => __('With km'),
                    'class' => 'mchkbx',
                     'id' => 'type_km',
                    ))."</div>";
                echo "<div class='form-group mdiv'>".$this->Form->input('with_date', array(
                    'label' => __('With date'),
                    'class' => 'mchkbx',
                     'id' => 'type_date',
                    ))."</div>";

                echo "<div id='alert_km'></div>";
                echo "<div id='alert_date'></div>";
                echo "<div class='form-group'>".$this->Form->input('many_interferings', array(
                    'label' => __('Sereval interfering'),
                    'class' => 'form-control',
                    ))."</div>";

                echo "<div class='form-group'>".$this->Form->input('maintenance_activate', array(
                    'label' => __('Maintenance activate'),
                     'class' => 'form-control',
                    ))."</div>";



    echo "<div id='interval'></div>";
    echo "<div id='interval1'></div>";

    echo "<div class='form-group'>" . $this->Form->input('interfering_types', array(
            'label' => __('Interfering types'),
            'class' => 'form-control',
            'type' => 'select',
            'multiple' => true,
            'id' => 'interfering_types',
            'empty' => true,
        )) . "</div>";
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
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<script type="text/javascript">

    $(document).ready(function() {




        $("#type_km").change(function() {
            jQuery('#interval1').load('<?php echo $this->Html->url('/eventTypes/getNamekms/')?>');
            if(this.checked) {
                jQuery('#interval1').css( "display", "block" );
                jQuery('#alert_km').load('<?php echo $this->Html->url('/eventTypes/getInputAlert/km')?>');
            } else {
                jQuery('#interval1').css( "display", "none" );
                jQuery('#alert_km').html('');
            }

        });

        $("#type_date").change(function() {
            jQuery('#interval').load('<?php echo $this->Html->url('/eventTypes/getNamedates/')?>');
            if(this.checked) {
                jQuery('#interval').css( "display", "block" );
                jQuery('#alert_date').load('<?php echo $this->Html->url('/eventTypes/getInputAlert/date')?>');
            } else {
                jQuery('#interval').css( "display", "none" );
                jQuery('#alert_date').html('');
            }
        });

        jQuery('#date1').change(function () {
            var date= jQuery(this).val();


        });

    });
  









</script>
<?php $this->end(); ?>