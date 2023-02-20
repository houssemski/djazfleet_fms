<?php

echo "<div class='form-group col-sm-6' style='padding: 0px;'>" . $this->Form->input('MissionCostParameter.'.$i.'.car_type_id', array(
        'label' => __('Car type'),
        'class' => 'form-size ',
        'options' => $carTypes,
        'id' => 'car_type'.$i,
        'onchange' => 'javascript : getMissionCostParameters(this.id)',
        'empty' => ''
    )) . "</div>";
?>

<div id ='mission_cost<?php echo $i?>'>

</div>