<?php

foreach ($events as $event ){

    if(!empty($event)){

        if($event[0]['EventType']['with_km']==1){ ?>
            <p style='color: #a94442;'>       <?php  echo __('This car wil have').' '.$event[0]['EventType']['name'].' '.__('at').' '. $event[0]['Event']['next_km'].' '.__('Km')?> </p>
        <?php   }
        if($event[0]['EventType']['with_date']==1 && !empty($event[0]['Event']['next_date'])){ ?>
            <p style='color: #a94442;'>       <?php  echo $event[0]['EventType']['name'].' '.__('of this car expires on').' '. h($this->Time->format($event[0]['Event']['next_date'], '%d-%m-%Y'))?> </p>
        <?php }
    }

}
