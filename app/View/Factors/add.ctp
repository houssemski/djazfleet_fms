<?php

?><h4 class="page-title"> <?=__('Add factor'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('Factor', array('onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">
	<?php

		echo "<div class='form-group'>".$this->Form->input('factor_type', array(
                    'label' => __('Type'),
                    'options'=>array('1'=>__('input'),'2'=>__('select'),'3'=>__('Date')),
                    //'onchange'=>'javascript:getFactorType(this.id)',
                    'id'=>'type',
                    'class' => 'form-control',
                    ))."</div>";
		echo "<div id='div-type-factor'>";
		echo "<div class='form-group'>".$this->Form->input('name', array(
                    'label' => __('Name'),
                    'class' => 'form-control',
                    ))."</div>";
        echo "<div class='form-group'>".$this->Form->input('Factor.name_id', array(
            'type' => 'hidden',
            'value' => 0,
        ))."</div>";
		echo "</div>";
               
	?>
             </div>
        <div class="box-footer">
            <?php
            echo $this->Form->submit(__('Submit'), array(
                'name' => 'ok',
                'class' => 'btn btn-primary btn-bordred  m-b-5',
                'label' => __('Submit'),
                'type' => 'submit',
                'id'=>'boutonValider',
                'div' => false
            ));
            echo $this->Form->submit(__('Cancel'), array(
                'name' => 'cancel',
                'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                'label' => __('Cancel'),
                'type' => 'submit',
                'div' => false,
                'formnovalidate' => true
            ));
            ?>
        </div>
    </div>

</div>
<?php $this->start('script'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        jQuery('#type').change(function () {

            if (jQuery('#type').val() > 0) {

                jQuery('#div-type-factor').load('<?php echo $this->Html->url('/factors/getFactorType/')?>' + jQuery(this).val(), function () {

                });
            }
        });

        });
    function getModelName(){
        jQuery('#name').val(jQuery('#nameId option:selected').text());
    }
</script>
<?php $this->end(); ?>