<?php

App::uses('AppController', 'Controller');

/**
 * CustomerCategories Controller
 *
 * @property GeofencesAlert $GeofencesAlert
 */
class DjazfleetAlertsSynchronizationController extends AppController {
    public $uses = array(
        'BusRoutes.GeofencesAlert'
    );
    public function synchronizeGeoFencesAlerts(){
        $data = array(
            'GeofencesAlert' => array(
                'tracker_id' => 1,
                'geo_fence_id' => 1,
                'type' => 'in',
                'created_at' => '2022-12-05 00:00:00',
                'lat' => '3.86666',
                'lng' => '2.5846554',
                'alert_id' => 1,
            )
        );
        $this->GeofencesAlert->create();
        $result = $this->GeofencesAlert->save($data);
    }
}
