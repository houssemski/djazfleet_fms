<?php

echo  $this->Form->input('transportBills.service_id', array(
        'label' => __('Service'),
        'class' => 'form-filter select3',
        'id' => 'service',
        'options'=>$services,
        'empty' => ''
    ));