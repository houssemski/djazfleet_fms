<?php
switch ($missionOrderModel){
    case 1 :
        echo  $this->element('pdf/view_mission_sheet_ride_1');
        break;
    case 2 :
        echo  $this->element('pdf/view_mission_sheet_ride_2');
        break ;
    case 3 :
        echo  $this->element('pdf/view_mission_sheet_ride_3');
        break ;
    default :
        echo  $this->element('pdf/view_mission_sheet_ride_1');
}