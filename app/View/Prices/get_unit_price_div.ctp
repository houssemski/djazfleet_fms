

<?php

echo "<div class='form-group' >" . $this->Form->input('ProductPrice.price_ht', array(
    'label' => __('Price HT') ,
    'placeholder' => __('Entrer price HT'),
    'onchange' => 'javascript: calculatePriceReturn();',
    'id' => 'price_ht',
    'class' => 'form-control',
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('ProductPrice.start_date', array(
    'label' => '',
    'placeholder' => 'dd/mm/yyyy',
    'type' => 'text',
    'class' => 'form-control datemask',
    'before' => '<label>' . __('Start date') . '</label><div class="input-group date" ><label for="PriceStartDate"></label><div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>',
        'after' => '</div>',
    'id' => 'start_date'
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('ProductPrice.end_date', array(
    'label' => '',
    'placeholder' => 'dd/mm/yyyy',
    'type' => 'text',
    'class' => 'form-control datemask',
    'before' => '<label>' . __('End date') . '</label><div class="input-group date" ><label for="PriceEndDate"></label><div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>',
        'after' => '</div>',
    'id' => 'end_date'
    )) . "</div>";
