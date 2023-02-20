<?php
switch($missionCostParameter){
        case 1:
                if(!empty($parameterMissionCostDay)){
                        echo "<div class='form-group' >" . $this->Form->input('parameter_mission_cost_day', array(
                                'label' => __('Mission cost per day'),
                                'placeholder' => __('Enter cost'),
                                'class' => 'form-control',
                                'readonly' => true,
                                'value'=>$parameterMissionCostDay[0]['MissionCostParameter']['mission_cost_day'],
                                'id' => 'parameter_mission_cost_day'
                            )) . "</div>";
                }else {
                        echo "<div class='form-group' >" . $this->Form->input('parameter_mission_cost_day', array(
                                'label' => __('Mission cost per day'),
                                'placeholder' => __('Enter cost'),
                                'class' => 'form-control',
                                'id' => 'parameter_mission_cost_day'
                            )) . "</div>";
                }

        break;
        case 2:
        break;
        case 3:
                if(!empty($parameterMissionCostDay)){
                        echo "<div class='form-group'>" . $this->Form->input('parameter_mission_cost_truck_full', array(
                                'label' => __('Mission costs truck full'),
                                'placeholder' => __('Enter cost'),
                                'class' => 'form-control',
                                'value'=>$parameterMissionCostDay[0]['MissionCostParameter']['mission_cost_truck_full'],
                                'type'=>'hidden',
                                'id'=>'parameter_mission_cost_truck_full'
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('parameter_mission_cost_truck_empty', array(
                                'label' => __('Mission costs truck empty'),
                                'placeholder' => __('Enter cost'),
                                'class' => 'form-control',
                                'value'=>$parameterMissionCostDay[0]['MissionCostParameter']['mission_cost_truck_empty'],
                                'type'=>'hidden',
                                'id'=>'parameter_mission_cost_truck_empty'
                            )) . "</div>";
                }else {
                        echo "<div class='form-group'>" . $this->Form->input('parameter_mission_cost_truck_full', array(
                                'label' => __('Mission costs truck full'),
                                'placeholder' => __('Enter cost'),
                                'class' => 'form-control',
                                'type'=>'hidden',
                                'id'=>'parameter_mission_cost_truck_full'
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('parameter_mission_cost_truck_empty', array(
                                'label' => __('Mission costs truck empty'),
                                'placeholder' => __('Enter cost'),
                                'class' => 'form-control',
                                'type'=>'hidden',
                                'id'=>'parameter_mission_cost_truck_empty'
                            )) . "</div>";
                }

        break;

}
