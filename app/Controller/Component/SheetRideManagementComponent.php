<?php
class SheetRideManagementComponent extends Component {

    function updateStatusSheetRideByDefaultStatus($sheetRideId){
        $parameter = ClassRegistry::init('Parameter');
        $defaultStatus = $parameter->getCodesParameterVal('default_status');

            $this->updateStatusSheetRide($sheetRideId, $defaultStatus);

    }

    /**
     * update sheet ride status, used after checking barre code by parc agent (departure and arrival)
     *
     * @param int $sheetId sheetride's id
     * @param int $defaultStatusId  id
     */
    public function updateStatusSheetRide($sheetId, $defaultStatusId)
    {
        $sheetRideModel = ClassRegistry::init('SheetRide');
        $sheetRideDetailRidesModel = ClassRegistry::init('SheetRideDetailRides');
        if($defaultStatusId == StatusEnum::status_by_date){
            date_default_timezone_set("Africa/Algiers");
            $current_date = date("Y-m-d H:i:s");
            $start_date = null;
            $end_date = null;

            $sheetRide = $sheetRideModel->find('first', array(
                'recursive' => -1,
                'conditions' => array('id' => $sheetId),
                'fields' => array('id', 'real_start_date', 'real_end_date')
            ));
            $start_date = $sheetRide['SheetRide']['real_start_date'];
            $end_date = $sheetRide['SheetRide']['real_end_date'];

            if (empty($start_date) || $start_date > $current_date) {
                $statusSheetId = StatusEnum::sheetride_planned;
            } else {
                if (!empty($end_date) && $end_date <= $current_date) {
                    $statusSheetId = StatusEnum::sheetride_closed;

                    $sheetRideDetailRides = $sheetRideDetailRidesModel->getSheetRideDetailRidesBySheetRideId($sheetId);
                    $statusMission = StatusEnum::mission_closed;
                    foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
                        $sheetRideDetailRidesModel->updateStatusSheetRideDetailRide($sheetRideDetailRide['SheetRideDetailRides']['id'], $statusMission);
                    }

                } else {
                    $missionStatusId = $sheetRideDetailRidesModel->getLastMissionStatus($sheetId);

                    if ($missionStatusId == StatusEnum::mission_closed) {
                        $statusSheetId = StatusEnum::sheetride_back_to_parc;
                    } else {
                        $statusSheetId = StatusEnum::sheetride_ongoing;
                    }
                }
            }

            $sheetRideModel->id = $sheetRide['SheetRide']['id'];
            $sheetRideModel->saveField('status_id', $statusSheetId);
        }else {

            $sheetRideModel->id = $sheetId;
            $statusSheetId  = StatusEnum::sheetride_closed;
            $sheetRideModel->saveField('status_id', $statusSheetId);
            if($defaultStatusId == StatusEnum::status_closed){
                $sheetRideDetailRides = $sheetRideDetailRidesModel->getSheetRideDetailRidesBySheetRideId($sheetId);
                $statusMission = StatusEnum::mission_closed;
                foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
                    $sheetRideDetailRidesModel->updateStatusSheetRideDetailRide($sheetRideDetailRide['SheetRideDetailRides']['id'], $statusMission);
                }
            }

        }



    }


}