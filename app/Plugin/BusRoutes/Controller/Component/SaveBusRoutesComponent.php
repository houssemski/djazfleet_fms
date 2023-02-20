<?php
App::uses('Component', 'Controller');

/**
 * Class SaveBusRoutesComponent
 * @property BusRoute $BusRoute
 * @property BusStop $BusStop
 * @property SaveBusStopsGeoFencesComponent $SaveBusStopsGeoFences
 * @property Car $Car
 */
class SaveBusRoutesComponent extends Component {

    public $uses = array(
        'Car',
        'Parameter',
        'Customer',
        'Destination'
    );

    public $components = array('BusRoutes.SaveBusStopsGeoFences');

    public function handleSaveBusRoute($data){
        $this->BusRoute = ClassRegistry::init('BusRoutes.BusRoute');
        $this->BusRoute->create();
        $result = $this->BusRoute->save($data);
        if ($result){
            $busRouteId = $result['BusRoute']['id'];
            $busStopsSaved = $this->saveBusStops($data, $busRouteId);
            $busRouteSaved = true;
        }else{
            $busRouteSaved = false;
            $busStopsSaved = false;
        }
        return array(
            'busRouteSaved' => $busRouteSaved,
            'busStopsSaved' => $busStopsSaved
        );
    }

    public function saveBusStops($data, $busRouteId){
        $this->BusStop = ClassRegistry::init('BusRoutes.BusStop');
        $this->Car = ClassRegistry::init('Car');
        $geoFencesIds = array();
        $result = false;
        foreach ($data['BusStop'] as $key => $value){
            $dataToSave = array();
            $data['BusStop'][$key]['bus_route_id'] = $busRouteId;
            $dataToSave['BusStop'] = $data['BusStop'][$key];
            $this->BusStop->create();
            $result = $this->BusStop->save($dataToSave);
            array_push($geoFencesIds, $data['BusStop'][$key]['geo_fence_id']);
        }
        $car = $this->Car->find('first',array(
            'conditions' => array('Car.id' => $data['BusRoute']['car_id'])
        ));
        $this->SaveBusStopsGeoFences->createGeoFenceInOutAlert($geoFencesIds, $car['Car']['tracker_id']);
        return $result ? true : false;
    }

    public function handleEditBusRoute($data){
        $this->BusRoute = ClassRegistry::init('BusRoutes.BusRoute');
        $this->BusRoute->id = $data['BusRoute']['id'];
        $result = $this->BusRoute->save($data);
        if ($result){
            $busRouteId = $result['BusRoute']['id'];
            $busStopsSaved = $this->editBusStops($data, $busRouteId);
            $busRouteSaved = true;
        }else{
            $busRouteSaved = false;
            $busStopsSaved = false;
        }
        return array(
            'busRouteSaved' => $busRouteSaved,
            'busStopsSaved' => $busStopsSaved
        );
    }

    public function editBusStops($data, $busRouteId){
        $this->BusStop = ClassRegistry::init('BusRoutes.BusStop');
        $result = false;
        foreach ($data['BusStop'] as $key => $value){
            if (isset($value['id'])){
                $this->BusStop->id = $value['id'];
                $dataToSave['BusStop'] = $value;
                $result = $this->BusStop->save($dataToSave);
                unset($data['BusStop'][$key]);
            }
        }
        if (!empty($data['BusStop'])){
            $result = $this->saveBusStops($data, $busRouteId);
        }
        if(isset($data['stops_to_delete'])){
            foreach ($data['stops_to_delete'] as $id){
                $this->BusStop->delete($id);
            }
        }
        return $result ? true : false;
    }
}