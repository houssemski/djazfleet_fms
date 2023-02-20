<?php
if(!empty($customer)){
    if($customer['Customer']['in_mission']!=0){ ?>
        <p style='color: #a94442;'>       <?php  echo __('The conductor is already out of the park') ?> </p>
    <?php }
}