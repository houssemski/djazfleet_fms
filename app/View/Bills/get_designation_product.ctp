<?php

echo "<div >" . $this->Form->input('BillProduct.'.$i.'.designation',
        array(
            'label' => '',
            'value' => $product['Product']['name'],
            'id' => 'designation'.$i,
            'class' => 'form-control',
        )) . "</div>";