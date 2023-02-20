<?php
if($outStock == 0) {
    echo $this->Form->input('current-qty'.$rowNumber, array(
        'id' => 'current-qty'.$rowNumber,
        'value' => $currentProductQty,
        'type' => 'hidden'
    ));
}

echo $this->Form->input('out_stock'.$rowNumber, array(
    'id' => 'out_stock'.$rowNumber,
    'value' => $outStock,
    'type' => 'hidden'
));
  



                