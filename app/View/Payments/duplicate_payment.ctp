<?php

echo $this->Form->create('Payment', array('onsubmit'=> 'javascript:disable();'));
echo '<br/>';

echo "<div class='form-group'>" . $this->Form->input('number_duplication', array(
        'label' => __('Number of duplication'),
        'class' => 'form-control',
    )) . "</div>";


echo $this->Form->submit(__('Save'), array(
    'name' => 'ok',
    'class' => 'btn btn-primary',
    'label' => __('Save'),
    'type' => 'submit',
    'id'=>'boutonValider',
    'div' => false
));



echo $this->Form->end();
echo $this->Js->writeBuffer(); //assuming this view is rendered without the default layout, make sure you write out the JS buffer at the bottom of the page
?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('maskedinput'); ?>
    <script type="text/javascript">

        $(document).ready(function() {

		
		});




    </script>
<?php die(); ?>