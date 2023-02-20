<?php
if($detailRideId !=0) {
    if ($displayMissionCost==2){
        switch($managementParameterMissionCost){
            case '1':
                if(!empty($missionCost)){
                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                            'label' => __('Mission cost'),
                            'placeholder' => __('Enter mission cost'),
                            'id' => 'mission_cost' ,
                            'value' => $missionCost['MissionCost']['cost_day'],
                            'readonly' => true,
                            'class' => 'form-filter'
                        )) . "</div>";
                } else {
                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                            'label' => __('Mission cost'),
                            'placeholder' => __('Enter mission cost'),
                            'id' => 'mission_cost',
                            'class' => 'form-filter'
                        )) . "</div>";
                }
                break;
            case '2':
                if(!empty($missionCost)){
                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                            'label' => __('Mission cost'),
                            'placeholder' => __('Enter mission cost'),
                            'id' => 'mission_cost' ,
                            'value' => $missionCost['MissionCost']['cost_destination'],
                            'readonly' => true,
                            'class' => 'form-filter'
                        )) . "</div>";
                }else {
                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                            'label' => __('Mission cost'),
                            'placeholder' => __('Enter mission cost'),
                            'id' => 'mission_cost',
                            'class' => 'form-filter'
                        )) . "</div>";
                }
                break;
            case '3':
                if(!empty($missionCost)){
                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                            'label' => __('Mission cost'),

                            'placeholder' => __('Enter mission cost'),
                            'id' => 'mission_cost' ,
                            'value' => $missionCost['MissionCost']['cost_truck_full'],
                            'readonly' => true,
                            'class' => 'form-filter'
                        )) . "</div>";

                } else {
                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                            'label' => __('Mission cost'),
                            'placeholder' => __('Enter mission cost'),
                            'id' => 'mission_cost' ,
                            'class' => 'form-filter'
                        )) . "</div>";
                }
                break;
        }

    }else {


        switch($managementParameterMissionCost){
            case '1':
                if(!empty($missionCost)){
                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                            'label' => __('Mission cost'),
                            'type'=>'hidden',
                            'placeholder' => __('Enter mission cost'),
                            'id' => 'mission_cost' ,
                            'value' => $missionCost['mission_cost_day'],
                            'readonly' => true,
                            'class' => 'form-filter'
                        )) . "</div>";

                } else {
                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                            'label' => __('Mission cost'),
                            'type'=>'hidden',
                            'placeholder' => __('Enter mission cost'),
                            'id' => 'mission_cost' ,
                            'class' => 'form-filter'
                        )) . "</div>";

                }

                break;

            case '2':
                if(!empty($missionCost)){
                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                            'label' => __('Mission cost'),
                            'type'=>'hidden',
                            'placeholder' => __('Enter mission cost'),
                            'id' => 'mission_cost' ,
                            'value' => $missionCost['mission_cost_mission'],
                            'readonly' => true,
                            'class' => 'form-filter'
                        )) . "</div>";

                }else {
                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                            'label' => __('Mission cost'),
                            'type'=>'hidden',
                            'placeholder' => __('Enter mission cost'),
                            'id' => 'mission_cost' ,
                            'class' => 'form-filter'
                        )) . "</div>";

                }

                break;

            case '3':
                if(!empty($missionCost)){
                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                            'label' => __('Mission cost'),
                            'type'=>'hidden',
                            'placeholder' => __('Enter mission cost'),
                            'id' => 'mission_cost',
                            'value' => $missionCost['MissionCost']['cost_truck_full'],
                            'readonly' => true,
                            'class' => 'form-filter'
                        )) . "</div>";

                }else {
                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                            'label' => __('Mission cost'),
                            'type'=>'hidden',
                            'placeholder' => __('Enter mission cost'),
                            'id' => 'mission_cost',
                            'class' => 'form-filter'
                        )) . "</div>";

                }
                break;

        }
    }
}else {
    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
            'label' => __('Mission cost'),
            'placeholder' => __('Enter mission cost'),
            'id' => 'mission_cost' ,
            'class' => 'form-filter'
        )) . "</div>";
}