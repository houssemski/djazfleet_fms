<?php
switch ($missionOrderModel){
    case 1 :
        echo  $this->element('pdf/view_mission_1');
        break;
    case 2 :
        echo  $this->element('pdf/view_mission_2');
        break ;
    default :
        echo  $this->element('pdf/view_mission_1');
}

