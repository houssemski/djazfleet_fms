<?php
echo " <div class='form-group'>" . $this->Form->input('Price.detail_ride_id', array(
        'label' => __('Ride'),
        'empty' => __('Select ride'),
        'id' => 'ride',
        'onchange' => 'javascript:getPrice();',
        'class' => 'form-control select-search-detail-ride',
    )) . "</div>";