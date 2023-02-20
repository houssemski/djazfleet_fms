<?php
App::uses('Component', 'Controller');

/**
 * Class SaveBusRoutesComponent
 * @property BusRoute $BusRoute
 * @property BusStop $BusStop
 * @property Destination $Destination
 * @property BusRouteRotation $BusRouteRotation
 * @property BusRotation $BusRotation
 * @property BusRotationSchedule $BusRotationSchedule
 * @property BusRotationsWeekDay $BusRotationsWeekDay
 */
class SaveBusRoutesRotationsComponent extends Component {


    public function SaveBusRouteRotations($data, $busRouteId){
        $this->BusRouteRotation = ClassRegistry::init('BusRouteRotation');
        $this->BusRotation = ClassRegistry::init('BusRotation');
        $this->BusRotationSchedule = ClassRegistry::init('BusRotationSchedule');
        $dataToSave = array();
        $dataRotationToSave = array();
        $dataScheduleToSave = array();
        $busRouteRotationsToDelete = array();
        if (isset($data['RotationToDelete']) && !empty($data['RotationToDelete'])){
            $this->deleteRotations($data['RotationToDelete'], $busRouteId);
            unset($data['RotationToDelete']);
        }
        if (isset($data['BusRotationToDelete']) && !empty($data['BusRotationToDelete'])){
            $busRouteRotationsToDelete = $data['BusRotationToDelete'];
            unset($data['BusRotationToDelete']);
        }
        if (!empty($busRouteRotationsToDelete)){
            foreach ($busRouteRotationsToDelete as $item){
                $this->BusRouteRotation->delete($item);
            }
        }
        foreach ($data as $datum){
            $dataRotationToSave['BusRotation']['bus_route_id'] = $datum['bus_route_id'];
            $dataRotationToSave['BusRotation']['rotation_number'] = $datum['rotation_number'];
            if (isset($datum['id']) && !empty($datum['id'])){
                $this->BusRotation->id = $datum['id'];
                $busRotationId = $datum['id'];
                unset($datum['id']);
            }else{
                $this->BusRotation->create();
            }
            $resultRotation = $this->BusRotation->save($dataRotationToSave);
            unset($datum['bus_route_id']);
            unset($datum['rotation_number']);
            if ($resultRotation){
                if (isset($resultRotation['BusRotation']['id'])){
                    $busRotationId = $resultRotation['BusRotation']['id'];
                }
                if (isset($datum['WeekDays'])){
                    $this->saveRotationsWeekDays($datum['WeekDays'], $busRotationId);
                    unset($datum['WeekDays']);
                }
                foreach ($datum as $rotation){
                    $dataScheduleToSave['BusRotationSchedule']['bus_rotation_id'] = $busRotationId;
                    $dataScheduleToSave['BusRotationSchedule']['schedule_number'] = $rotation['schedule_number'];
                    if (isset($rotation['id']) && !empty($rotation['id'])){
                        $this->BusRotationSchedule->id = $rotation['id'];
                        $rotationScheduleId = $rotation['id'];
                        unset($rotation['id']);
                    }else{
                        $this->BusRotationSchedule->create();
                    }
                    $resultSchedule = $this->BusRotationSchedule->save($dataScheduleToSave);
                    if ($resultSchedule){
                        if (isset($resultSchedule['BusRotationSchedule']['id'])){
                            $rotationScheduleId = $resultSchedule['BusRotationSchedule']['id'];
                        }
                        unset($rotation['schedule_number']);
                        foreach ($rotation as $direction){
                            foreach ($direction as $schedule){
                                $schedule['bus_rotation_schedule_id'] = $rotationScheduleId;
                                $dataToSave['BusRouteRotation'] = $schedule;
                                if(isset($schedule['id']) && !empty($schedule['id'])){
                                    $this->BusRouteRotation->id = $schedule['id'];
                                }else{
                                    $this->BusRouteRotation->create();
                                }
                                $this->BusRouteRotation->save($schedule);
                            }
                        }
                    }
                }
            }
        }
    }

    public function deleteRotations($ids, $busRouteId){
        $this->BusRouteRotation = ClassRegistry::init('BusRouteRotation');
        $this->BusRotation = ClassRegistry::init('BusRotation');
        $this->BusRotationSchedule = ClassRegistry::init('BusRotationSchedule');
        $rotationSchedules = $this->BusRotationSchedule->find('all',array(
            'conditions' => array(
                'BusRotationSchedule.bus_rotation_id IN' => $ids
            ),
            'fields' => array(
                'BusRotationSchedule.id'
            )
        ));
        $schedulesIdsArray = $this->generateSchedulesIdsArray($rotationSchedules);
        $this->fixRotationsOrder($busRouteId);
        $this->BusRotation->deleteAll(array(
            'BusRotation.id IN' => $ids,
        ));
        $this->BusRotationSchedule->deleteAll(array(
            'BusRotationSchedule.bus_rotation_id IN' => $ids
        ));
        $this->BusRouteRotation->deleteAll(array(
            'BusRouteRotation.bus_rotation_schedule_id IN' => $schedulesIdsArray
        ));
        $this->fixRotationsOrder($busRouteId);
    }

    private function generateSchedulesIdsArray($data){
        $schedulesIdsArray = array();
        if (!empty($data)){
            foreach ($data as $datum){
                array_push($schedulesIdsArray, $datum['BusRotationSchedule']['id']);
            }
        }
        return$schedulesIdsArray;
    }

    public function fixRotationsOrder($busRouteId){
        $rotations = $this->BusRotation->find('all',array(
            'BusRotation.bus_route_id' => $busRouteId
        ));
        if (!empty($rotations)){
            $i = 1;
            foreach ($rotations as $rotation){
                $this->BusRotation->id = $rotation['BusRotation']['id'];
                $this->BusRotation->saveField('rotation_number',$i);
                $i++;
            }
        }
    }

    public function saveRotationsWeekDays($data, $busRotationId){
        $this->BusRotationsWeekDay = ClassRegistry::init('BusRotationsWeekDay');
        $weekDaysArray = array();
        foreach ($data as $key => $datum){
            array_push($weekDaysArray, $key);
        }
        $this->BusRotationsWeekDay->deleteAll(array(
            'bus_rotation_id' => $busRotationId,
        ));
        foreach ($weekDaysArray as $item){
            $dataToSave = array(
                'bus_rotation_id' => $busRotationId,
                'week_day' => $item
            );
            $this->BusRotationsWeekDay->create();
            $this->BusRotationsWeekDay->save($dataToSave);
        }

    }

}