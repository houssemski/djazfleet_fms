<?php
echo "<div class='form-group input-button ' >" . $this->Form->input('Customer.service_id', array(
        'label' => __('Service'),
        'class' => 'form-control select3',
        'options'=>$services,
        'empty' => ''
    )) . "</div>"; ?>
	 