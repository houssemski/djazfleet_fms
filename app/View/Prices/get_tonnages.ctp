<?php
echo "<div class='form-group' >" . $this->Form->input('Price.km_from', array(
        'label' => __('Km from'),
        'placeholder' => __(''),
        'onchange' => 'javascript: getPrice();',
        'id' => 'km_from',
        'class' => 'form-control',
    )) . "</div>";

echo "<div class='form-group' >" . $this->Form->input('Price.km_to', array(
        'label' => __('Km to'),
        'placeholder' => __(''),
        'onchange' => 'javascript: getPrice();',
        'id' => 'km_to',
        'class' => 'form-control',
    )) . "</div>";
echo " <div class='form-group'>" . $this->Form->input('Price.tonnage_id', array(
    'label' => __('Tonnage'),
    'empty' => __('Select tonnage'),
    'id' => 'tonnage',
    'onchange' => 'javascript:getPrice();',
    'class' => 'form-control select-search',
    )) . "</div>";