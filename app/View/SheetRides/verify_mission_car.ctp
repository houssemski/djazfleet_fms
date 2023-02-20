<?php
if(!empty($car)){
    if($car['Car']['in_mission']!=0){ ?>
<p style='color: #a94442;'>       <?php  echo __('The car is already out of the park') ?> </p>
   <?php }
}