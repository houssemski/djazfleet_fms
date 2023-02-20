<?php

switch ($paramMissionCost){
    case 1 :
        echo "<div class='form-group'>" . $this->Form->input('MissionCostParameter.'.$i.'.mission_cost_day', array(
                'label' => __('Mission cost per day'),
                'class' => 'form-size',
                'empty' => ''
            )) . "</div>";
        break;
    case 2:
        break;
    case 3 :
        echo "<div class='form-group'>" . $this->Form->input('MissionCostParameter.'.$i.'.mission_cost_truck_full', array(
                'label' => __('Coefficient mission cost truck full'),
                'class' => 'form-size',
                'empty' => ''
            )) . "</div>";
        echo "<div class='form-group'>" . $this->Form->input('MissionCostParameter.'.$i.'.mission_cost_truck_empty', array(
                'label' => __('Coefficient mission cost truck empty'),
                'class' => 'form-size'
            )) . "</div>";
        break;
}