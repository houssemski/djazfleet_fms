<?php
App::uses('Component', 'Controller');

/**
 * Class SaveBusRoutesComponent
 * @property BusRoute $BusRoute
 * @property BusStop $BusStop
 * @property Destination $Destination
 */
class GetGeoFencesAlertsComponent extends Component {

    public $uses = array(
        'Car',
        'Parameter',
        'Customer',
        'Destination'
    );

    public function getAlerts(){
        $this->Destination = ClassRegistry::init('Destination');
        $headers = array("Content-Type:application/json");
        $url = 'https://djazfleet-dz.com/api/login';
        $data = array('email' => 'test.test@garminalgerie.com', 'password' => '1234');
        // utilisez 'http' même si vous envoyez la requête sur https:// ...
        $content = json_encode($data);
        $result = $this->cUrlGetData($url, $content, $headers);


        if (!empty($result)) {
            if ($result['status'] == 1) {
                $user_api_hash = $result['user_api_hash'];
                $url = 'https://djazfleet-dz.com/api/get_alerts?lang=en&user_api_hash=' . $user_api_hash;
                $result = $this->cUrlGetData($url, null, $headers);
            }
        }
    }

    public function getEvents($busRoute){
        $this->Destination = ClassRegistry::init('Destination');
        $headers = array("Content-Type:application/json");
        $url = 'https://djazfleet-dz.com/api/login';
        $data = array('email' => 'test.test@garminalgerie.com', 'password' => '1234');
        // utilisez 'http' même si vous envoyez la requête sur https:// ...
        $content = json_encode($data);
        $result = $this->cUrlGetData($url, $content, $headers);


        if (!empty($result)) {
            if ($result['status'] == 1) {
                $user_api_hash = $result['user_api_hash'];
                $url = 'https://djazfleet-dz.com/api/get_events?lang=en&user_api_hash=' . $user_api_hash.'&device_id='.
                $busRoute['Car']['tracker_id'];
                $result = $this->cUrlGetData($url, null, $headers);
                debug($result);
                die();
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