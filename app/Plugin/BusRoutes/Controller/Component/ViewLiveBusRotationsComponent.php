<?php
App::uses('Component', 'Controller');

/**
 * Class SaveBusRoutesComponent
 * @property BusRoute $BusRoute
 * @property BusStop $BusStop
 * @property Destination $Destination
 * @property GeofencesAlert $GeofencesAlert
 * @property BusRotationsWeekDay $BusRotationsWeekDay
 * @property BusRotation $BusRotation
 * @property BusRotationSchedule $BusRotationSchedule
 * @property BusRouteRotation $BusRouteRotation
 */
class ViewLiveBusRotationsComponent extends Component {

    public function getBusRouteRotations($busRouteId, $routeType){
        $this->BusRotation = ClassRegistry::init('BusRoutes.BusRotation');
        $this->BusRotationSchedule = ClassRegistry::init('BusRoutes.BusRotationSchedule');
        $this->BusRouteRotation = ClassRegistry::init('BusRoutes.BusRouteRotation');
        $busRouteRotationId = $this->BusRotation->getTodayRouteRotation($busRouteId);
        if (!empty($busRouteRotationId)){
            $todayRotationSchedules = $this->BusRotationSchedule->getRotationSchedules($busRouteRotationId);
            $todayRotationSchedules = $this->BusRouteRotation->getSchedulesRotations($todayRotationSchedules, $routeType);
        }else{
            $todayRotationSchedules = array();
        }

        return $todayRotationSchedules;
    }

    public function generateCheckPointsArray($busStops, $rotationsSchedule, $geoFencesAlerts){
        $geoFencesAlertsIndex2 = 0;
        $checkPointsArray = array();
        $firstStopGeoFenceId = $busStops[0]['BusStop']['geo_fence_id'];
        $lastStopGeoFenceId = end($busStops)['BusStop']['geo_fence_id'];
        $endOfGeoFencesArray = false;
        $busRotationsScheduleIndex = 0;
        foreach ($rotationsSchedule as $item){
            $busStopsIndex = 0;
            foreach ($item['BusRouteRotation'] as $value ){
                if (isset($geoFencesAlerts[$geoFencesAlertsIndex2]) && isset($geoFencesAlerts[$geoFencesAlertsIndex2 +1])){


                    if (($value['BusRouteStop']['geo_fence_id'] ==
                            $geoFencesAlerts[$geoFencesAlertsIndex2]['GeofencesAlert']['geo_fence_id'] ||
                            $value['BusRouteStop']['geo_fence_id'] ==
                            $geoFencesAlerts[$geoFencesAlertsIndex2 + 1]['GeofencesAlert']['geo_fence_id'])
                        && ($geoFencesAlerts[$geoFencesAlertsIndex2]['GeofencesAlert']['type_name'] == 'zone_in'
                            || $geoFencesAlerts[$geoFencesAlertsIndex2]['GeofencesAlert']['type_name'] == 'zone_out')
                    ){
                        $stop = array(
                            'stop_name' => $value['BusRouteStop']['name'],
                            'arrival_time' => $geoFencesAlerts[$geoFencesAlertsIndex2]['GeofencesAlert']['created_at'],
                            'active' => true,
                            'on_route' => true,
                            'expected_arrival_time' => $value['BusRouteRotation']['time'],
                        );


                    }else{
                        while(isset($geoFencesAlerts[$geoFencesAlertsIndex2]) && $geoFencesAlerts[$geoFencesAlertsIndex2]['GeofencesAlert']['geo_fence_id'] != $lastStopGeoFenceId){
                            $stop = array(
                                'stop_name' => $geoFencesAlerts[$geoFencesAlertsIndex2]['BusRouteStop']['name'],
                                'arrival_time' => $geoFencesAlerts[$geoFencesAlertsIndex2]['GeofencesAlert']['created_at'],
                                'active' => false,
                                'on_route' => false
                            );
                            $checkPointsArray[$busRotationsScheduleIndex][] = $stop;
                            $geoFencesAlertsIndex2 = $geoFencesAlertsIndex2 + 2;
                        }
                        $geoFencesAlertsIndex2 = $geoFencesAlertsIndex2 + 2;
                        break;
                    }


                }else{
                    $endOfGeoFencesArray = true;
                    $stop = array(
                        'stop_name' => $value['BusRouteStop']['name'],
                        'arrival_time' => null,
                        'active' => false,
                        'on_route' => true
                    );
                }
                $checkPointsArray[$busRotationsScheduleIndex][] = $stop;
                $geoFencesAlertsIndex2 = $geoFencesAlertsIndex2 + 2;
                $busStopsIndex++;
            }
            $busRotationsScheduleIndex++;
        }

        while (!$endOfGeoFencesArray){
            foreach ($busStops as $busStop){
                if (isset($geoFencesAlerts[$geoFencesAlertsIndex2]) && isset($geoFencesAlerts[$geoFencesAlertsIndex2 +1])){


                    if (($busStop['BusRouteStop']['geo_fence_id'] ==
                            $geoFencesAlerts[$geoFencesAlertsIndex2]['GeofencesAlert']['geo_fence_id'] ||
                            $busStop['BusRouteStop']['geo_fence_id'] ==
                            $geoFencesAlerts[$geoFencesAlertsIndex2 + 1]['GeofencesAlert']['geo_fence_id'])
                        && ($geoFencesAlerts[$geoFencesAlertsIndex2]['GeofencesAlert']['type_name'] == 'zone_in'
                            || $geoFencesAlerts[$geoFencesAlertsIndex2]['GeofencesAlert']['type_name'] == 'zone_out')
                    ){
                        $stop = array(
                            'stop_name' => $busStop['BusRouteStop']['name'],
                            'arrival_time' => $geoFencesAlerts[$geoFencesAlertsIndex2]['GeofencesAlert']['created_at'],
                            'active' => true,
                            'on_route' => true,
                        );


                    }else{
                        while(isset($geoFencesAlerts[$geoFencesAlertsIndex2]) && $geoFencesAlerts[$geoFencesAlertsIndex2]['GeofencesAlert']['geo_fence_id'] != $lastStopGeoFenceId){
                            $stop = array(
                                'stop_name' => $geoFencesAlerts[$geoFencesAlertsIndex2]['BusRouteStop']['name'],
                                'arrival_time' => $geoFencesAlerts[$geoFencesAlertsIndex2]['GeofencesAlert']['created_at'],
                                'active' => false,
                                'on_route' => false
                            );
                            $checkPointsArray[$busRotationsScheduleIndex][] = $stop;
                            $geoFencesAlertsIndex2 = $geoFencesAlertsIndex2 + 2;
                        }
                        $geoFencesAlertsIndex2 = $geoFencesAlertsIndex2 + 2;
                        break;
                    }


                }else{
                    $endOfGeoFencesArray = true;
                    $stop = array(
                        'stop_name' => $busStop['BusRouteStop']['name'],
                        'arrival_time' => null,
                        'active' => false,
                        'on_route' => true
                    );
                }
                $checkPointsArray[$busRotationsScheduleIndex][] = $stop;
                $geoFencesAlertsIndex2 = $geoFencesAlertsIndex2 + 2;
            }
            $busRotationsScheduleIndex++;
        }

        return $checkPointsArray;

    }







}