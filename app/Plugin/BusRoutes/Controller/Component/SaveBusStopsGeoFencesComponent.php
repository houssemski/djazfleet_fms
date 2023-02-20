<?php
App::uses('Component', 'Controller');

/**
 * Class SaveBusRoutesComponent
 * @property BusRoute $BusRoute
 * @property BusRouteStop $BusRouteStop
 * @property Destination $Destination
 * @property Car $Car
 */
class SaveBusStopsGeoFencesComponent extends Component {

    public $uses = array(
        'Car',
        'Parameter',
        'Customer',
        'Destination'
    );

    public function addBusStopsGeoFencesInDjazFleet($busStop, $busStopId){
        $this->BusRouteStop = ClassRegistry::init('BusRouteStop');
        $headers = array("Content-Type:application/json");
        $url = 'https://djazfleet-dz.com/api/login';
        $data = array('email' => 'houssem.test@garminalgerie.com', 'password' => '1234');
        // utilisez 'http' même si vous envoyez la requête sur https:// ...
        $content = json_encode($data);
        $result = $this->cUrlGetData($url, $content, $headers);
        $addedGeoFencesIds = array();
        if (!empty($result)) {
            if ($result['status'] == 1) {
                $user_api_hash = $result['user_api_hash'];
                $url = 'https://djazfleet-dz.com/api/add_geofence?lang=en&user_api_hash=' . $user_api_hash;
                $data = array(
                    'name' => $busStop['BusRouteStop']['name'],
                    'polygon_color' => '#d000df',
                    'polygon' => array(
                        array(
                            'lat' => $busStop['BusRouteStop']['lat'],
                            'lng' => $busStop['BusRouteStop']['lng'],
                        )
                    ),
                    'type' => 'circle',
                    'center' => array(
                        'lat' => $busStop['BusRouteStop']['lat'],
                        'lng' => $busStop['BusRouteStop']['lng']
                    ),
                    'radius' => 100
                );
                $content = json_encode($data);
                $result = $this->cUrlGetData($url, $content, $headers);
                if (isset($result['status']) && $result['status'] == 1){
                    $this->BusRouteStop->id = $busStopId;
                    $this->BusRouteStop->saveField('geo_fence_id' , $result['item']['id']);
                    array_push($addedGeoFencesIds,$result['item']['id']);
                }
            }
        }
        return $addedGeoFencesIds;
    }

    public function editBusStopsGeoFencesInDjazFleet($busStop){
        $headers = array("Content-Type:application/json");
        $url = 'https://djazfleet-dz.com/api/login';
        $data = array('email' => 'houssem.test@garminalgerie.com', 'password' => '1234');
        // utilisez 'http' même si vous envoyez la requête sur https:// ...
        $content = json_encode($data);
        $result = $this->cUrlGetData($url, $content, $headers);


        if (!empty($result)) {
            if ($result['status'] == 1) {
                $user_api_hash = $result['user_api_hash'];
                $url = 'https://djazfleet-dz.com/api/edit_geofence?lang=en&user_api_hash=' . $user_api_hash;
                $data = array(
                    'id' => $busStop['BusRouteStop']['geo_fence_id'],
                    'name' => $busStop['BusRouteStop']['name'],
                    'polygon_color' => '#d000df',
                    'polygon' => array(
                        array(
                            'lat' => $busStop['BusRouteStop']['lat'],
                            'lng' => $busStop['BusRouteStop']['lng'],
                        )
                    ),
                    'type' => 'circle',
                    'center' => array(
                        'lat' => $busStop['BusRouteStop']['lat'],
                        'lng' => $busStop['BusRouteStop']['lng']
                    ),
                    'radius' => 100
                );
                $content = json_encode($data);
                $result = $this->cUrlGetData($url, $content, $headers);
            }
        }
    }

    public function destroyBusStopGeoFenceInDjazFleet($geoFenceId){
        $headers = array("Content-Type:application/json");
        $url = 'https://djazfleet-dz.com/api/login';
        $data = array('email' => 'houssem.test@garminalgerie.com', 'password' => '1234');
        // utilisez 'http' même si vous envoyez la requête sur https:// ...
        $content = json_encode($data);
        $result = $this->cUrlGetData($url, $content, $headers);


        if (!empty($result)) {
            if ($result['status'] == 1) {
                $user_api_hash = $result['user_api_hash'];
                $url = 'https://djazfleet-dz.com/api/destroy_geofence?lang=en&user_api_hash=' . $user_api_hash.
                    '&geofence_id='.$geoFenceId;
                $result = $this->cUrlGetData($url, null, $headers);
            }
        }
    }

    public function createGeoFenceInOutAlert($geoFencesIds,$deviceId){
        $this->Car = ClassRegistry::init('Car');
        $headers = array("Content-Type:application/json");
        $url = 'https://djazfleet-dz.com/api/login';
        $data = array('email' => 'houssem.test@garminalgerie.com', 'password' => '1234');
        // utilisez 'http' même si vous envoyez la requête sur https:// ...
        $content = json_encode($data);
        $result = $this->cUrlGetData($url, $content, $headers);

        if (!empty($result)) {
            if ($result['status'] == 1) {
                $user_api_hash = $result['user_api_hash'];
                $url = 'https://djazfleet-dz.com/api/add_alert?lang=en&user_api_hash=' . $user_api_hash;
                    $data = array(
                        'name' => 'alert in/out',
                        'type' => 'geofence_inout',
                        'devices' =>
                            array(
                                $deviceId
                            )
                       ,
                        'geofences' => array_values($geoFencesIds)
                    );
                    $content = json_encode($data);
                    $result = $this->cUrlGetData($url, $content, $headers);
            }
        }
    }


    function cUrlGetData($url, $post_fields = null, $headers = null)
    {
        $ch = curl_init();
        $timeout = 3000;
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($post_fields && !empty($post_fields)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        }
        if ($headers && !empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $data = utf8_encode($data);
        $data = json_decode($data, JSON_UNESCAPED_UNICODE);
        return $data;
    }

}