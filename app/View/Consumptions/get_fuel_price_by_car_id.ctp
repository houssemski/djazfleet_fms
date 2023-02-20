<?php
/**
 * @var array $fuel
 */

echo $this->Form->input('fuel_price', array(
        'label' => '',
        'type' => 'hidden',
        'value' => isset($fuel['Fuel']) && isset($fuel['Fuel']['price']) ? $fuel['Fuel']['price'] : '',
        'id' => 'fuel_price'
    )) ;