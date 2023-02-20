<?php
echo "<div class='form-group'>".$this->Form->input('Destination.daira_id', array(
        'label' => __('Name').' '.__('Daira') ,
        'empty'=>__('Select daira'),
        'required'=>true,
        'class' => 'form-control select2',
    ))."</div>";