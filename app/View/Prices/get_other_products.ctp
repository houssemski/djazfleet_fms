<?php
echo "<div class='form-group' >" . $this->Form->input('ProductPrice.product_id', array(
        'label' => __('Product'),
        'empty' => __('Select product'),
        'id' => 'product',
        'class' => 'form-control select-search',
        'onchange' => 'javascript: getFactors();',
    )) . "</div>";

echo "<div id='factor-div' ></div>";


