<?php
   echo "<div  >" . $this->Form->input('SheetRide.car_id', array(
                    'label' => __('Car'),
                    'class' => 'form-filter select-search-car',
                    'empty' => '',
                    'type'=>'select',
                    //'options'=>$cars,
                    'onchange'=>'javascript: carChanged(this.id);',
                    'id' => 'cars',
                )) . "</div>";
?>