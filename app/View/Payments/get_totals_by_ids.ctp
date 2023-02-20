<?php

$reglement = $totalAmount - $totalAmountRemaining;?>
<span ><strong><?php echo  __('Règlement : '); ?></strong></span> <span > <?= number_format($reglement, 2, ",", $separatorAmount).' '. $this->Session->read("currency");?></span><br>
<br>
<span ><strong><?php echo  __('Left to pay : '); ?></strong></span> <span > <?= number_format($totalAmountRemaining, 2, ",", $separatorAmount).' '. $this->Session->read("currency");?></span><br>
