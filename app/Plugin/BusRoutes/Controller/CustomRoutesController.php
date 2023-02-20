<?php
App::uses('BusRoutesAppController', 'BusRoutes.Controller');
/**
 * CustomRoutes Controller
 * @property SaveBusRoutesComponent $SaveBusRoutes
 * @property SaveBusStopsGeoFencesComponent $SaveBusStopsGeoFences
 * @property GetGeoFencesAlertsComponent $GetGeoFencesAlerts
 * @property BusRoute $BusRoute
 * @property BusStop $BusStop
 * @property PaginatorComponent $paginate
 * @property GeofencesAlert $GeofencesAlert
 * @property BusRouteStop $BusRouteStop
 * @property BusRouteRotation $BusRouteRotation
 * @property SaveBusRoutesRotationsComponent $SaveBusRoutesRotations
 * @property BusRotation $BusRotation
 * @property BusRotationSchedule $BusRotationSchedule
 * @property BusRotationsWeekDay $BusRotationsWeekDay
 * @property ViewLiveBusRotationsComponent $ViewLiveBusRotations
 */
class CustomRoutesController extends BusRoutesAppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;

    public $uses = array(
        'Car',
        'Parameter',
        'Customer',
        'Destination',
        'BusRoute',
        'BusRoutes.BusStop',
        'BusRoutes.GeofencesAlert',
        'BusRoutes.BusRouteStop',
        'BusRoutes.BusRouteRotation',
        'BusRoutes.BusRotation',
        'BusRoutes.BusRotationSchedule',
        'BusRoutes.BusRotationsWeekDay'
    );

    public $components = array(
        'BusRoutes.SaveBusRoutes',
        'BusRoutes.GetGeoFencesAlerts',
        'BusRoutes.SaveBusStopsGeoFences',
        'BusRoutes.SaveBusRoutesRotations',
        'BusRoutes.ViewLiveBusRotations',
        'Paginator'
    );


    public function index(){
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('BusRoute.route_title' => 'ASC'),
            'paramType' => 'querystring',
            'fields' => array(
                'BusRoute.id',
                'BusRoute.route_title',
                'Car.immatr_def',
                'CarModel.name',
                'Customers.first_name',
                'Customers.last_name',
            ),
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('BusRoute.car_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'CarModel',
                    'conditions' => array('Car.carmodel_id = CarModel.id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customers',
                    'conditions' => array('BusRoute.customer_id = Customers.id')
                )
            )
        );

        //Parametrer la pagination


        $this->set('busRoutes', $this->Paginator->paginate('BusRoute'));
        $this->set(compact('limit'));
    }

    public function view($id = null) {
        $this->setTimeActif();

        if (!$this->BusRoute->exists($id)) {
            throw new NotFoundException(__('Invalid bus route.'));
        }
        $options = array(
            'conditions' => array('BusRoute.' . $this->BusRoute->primaryKey => $id),
            'fields' => array(
                'BusRoute.id',
                'BusRoute.route_title',
                'BusRoute.route_type',
                'Car.immatr_def',
                'Car.tracker_id',
                'CarModel.name',
                'Customers.first_name',
                'Customers.last_name'
            ),
            'joins' => array(
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('BusRoute.car_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'CarModel',
                    'conditions' => array('Car.carmodel_id = CarModel.id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customers',
                    'conditions' => array('BusRoute.customer_id = Customers.id')
                )
            )
        );
        $busRoute = $this->BusRoute->find('first', $options);
        $busStops = $this->BusStop->getRouteBusStops($id, $busRoute['BusRoute']['route_type']);
        $geoFencesEvents = $this->GeofencesAlert->find('all',array(
            'conditions' => array(
                'DATE(GeofencesAlert.created_at) >' => date('Y-m-d',strtotime("-1 days")),
                'GeofencesAlert.tracker_id' => $busRoute['Car']['tracker_id']
            ),
            'fields' => array(
                'GeofencesAlert.id',
                'GeofencesAlert.geo_fence_event_id',
                'GeofencesAlert.tracker_id',
                'GeofencesAlert.geo_fence_id',
                'GeofencesAlert.type_name',
                'GeofencesAlert.created_at',
                'GeofencesAlert.lat',
                'GeofencesAlert.lng',
                'GeofencesAlert.alert_id',
                'GeofencesAlert.seen',
                'BusRouteStop.name',
            ),
            'joins' => array(
                array(
                    'table' => 'bus_route_stops',
                    'type' => 'left',
                    'alias' => 'BusRouteStop',
                    'conditions' => array('GeofencesAlert.geo_fence_id = BusRouteStop.geo_fence_id')
                )
            ),
            'order' => array(
                'GeofencesAlert.created_at' => 'ASC',
                'GeofencesAlert.type_name' => 'ASC',
                'BusRouteStop.name' => 'ASC',
                )
        ));
        $busRouteRotations = $this->ViewLiveBusRotations->getBusRouteRotations($id, $busRoute['BusRoute']['route_type']);
        $checkPointsArray = $this->ViewLiveBusRotations->generateCheckPointsArray($busStops, $busRouteRotations, $geoFencesEvents);
        $this->set(compact('busStops','busRoute','checkPointsArray'));
    }

    public function add(){

        if ($this->request->is('post')){
            $result = $this->SaveBusRoutes->handleSaveBusRoute($this->request->data);
            if ($result['busRouteSaved']){
                $this->Flash->success(__('The bus route has been saved.'));
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Flash->error(__('The bus route could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index'));
            }
        }
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $conditions = array();
        $cars = $this->Car->getCarsByCondition($param,$conditions );
        $fields = "names";
        $conditionsCustomer = array();
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditionsCustomer);
        $busRouteStops = $this->BusRouteStop->find('list');
        $this->set(compact('cars','customers','departure','busRouteStops'));
    }

    public function addStop($stopNumber){
        $this->layout = 'ajax';
        $busRouteStops = $this->BusRouteStop->find('list');
        $this->set(compact('busRouteStops','stopNumber'));
    }

    public function edit($id){
        if ($this->request->is(array('post', 'put'))){
            $result = $this->SaveBusRoutes->handleEditBusRoute($this->request->data);
            if (isset($this->request->data['BusRouteRotation']) && !empty($this->request->data['BusRouteRotation'])){
                $this->SaveBusRoutesRotations->SaveBusRouteRotations($this->request->data['BusRouteRotation'], $id);
            }
            if ($result['busRouteSaved']){
                $this->Flash->success(__('The bus route has been saved.'));
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Flash->error(__('The bus route could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index'));
            }
        }
        $busRoute = $this->BusRoute->find('first', array(
            'conditions' => array('BusRoute.id' => $id)
        ));
        $busStops = $this->BusStop->find('all' , array(
            'conditions' => array(
                'BusStop.bus_route_id' => $busRoute['BusRoute']['id']
            ),
            'order' => 'BusStop.stop_order ASC'
        ));
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $conditions = array();
        $this->request->data = $busRoute;
        $cars = $this->Car->getCarsByCondition($param,$conditions );
        $fields = "names";
        $conditionsCustomer = array();
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditionsCustomer);
        $busRouteStops = $this->BusRouteStop->find('list');
        $busRouteRotations = $this->BusRotation->getRouteRotations($id);
        $busRouteRotations = $this->BusRotationsWeekDay->getRotationsWeekDays($busRouteRotations);
        $busRouteRotationsSchedule = $this->BusRouteRotation->getRotationsSchedules($busRouteRotations);
        $this->set(compact('cars','customers','busRouteStops','busStops','busRoute','busRouteRotationsSchedule'));
    }


    public function delete($id = null) {
        $this->setTimeActif();

        $this->BusRoute->id = $id;
        if (!$this->BusRoute->exists()) {
            throw new NotFoundException(__('Invalid bus route'));
        }
        //$this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->BusRoute->delete($id, true)) {
            $this->BusStop->deleteAll(array('BusStop.bus_route_id' => $id));
            $this->Flash->success(__('The bus route has been deleted.'));
        } else {

            $this->Flash->error(__('The bus route could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteRoutes() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->BusRoute->id = $id;
        $this->request->allowMethod('post', 'delete');
        if($this->BusRoute->delete($id,true)){
            $this->BusStop->deleteAll(array('BusStop.bus_route_id' => $id));
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }
    }

    public function addRotationsAjax($rotationNumber, $busRouteId, $rotationsToGenerate){
        $this->layout = 'ajax';
        $busRoute = $this->BusRoute->find('first', array(
            'conditions' => array(
                'BusRoute.id' => $busRouteId
            )
        ));
        $busRouteType = $busRoute['BusRoute']['route_type'];
        $busStops = $this->BusStop->find('all', array(
            'conditions' => array('BusStop.bus_route_id' => $busRouteId ),
            'fields' => array(
                'BusRouteStop.id',
                'BusRouteStop.name',
                'BusStop.stop_order',
            ),
            'order' => array(
                'BusStop.stop_order' => 'ASC'
            ),

        ));
        $this->set(compact('busStops','rotationNumber','rotationsToGenerate','busRouteId','busRouteType'));
    }

    public function addRotationAjax($rotationNumber, $busRouteId){
        $this->layout = 'ajax';
        $this->set(compact('rotationNumber','busRouteId'));
    }

    public function generateReport($trackerId){
        $this->autoRender = false;
        $headers = array("Content-Type:application/json");
        $url = 'https://djazfleet-dz.com/api/login';
        $data = array('email' => 'test.test@garminalgerie.com', 'password' => '1234');
        // utilisez 'http' même si vous envoyez la requête sur https:// ...
        $content = json_encode($data);
        $result = $this->cUrlGetData($url, $content, $headers);


        if (!empty($result)) {
            if ($result['status'] == 1) {
                $user_api_hash = $result['user_api_hash'];
                $url = 'https://djazfleet-dz.com/api/generate_report?lang=en&user_api_hash=' . $user_api_hash;
                $data = array(
                    'title' => 'route',
                    'type' => 43,
                    'format' => 'html',
                    'devices' => array_values(array($trackerId)),
                    'date_from' => date('Y-m-d') ,
                    'date_to' => date('Y-m-d', strtotime("+1 day")) ,
                );
                $content = json_encode($data);
                $result = $this->cUrlGetData($url, $content, $headers);
                if (isset($result['url'])){
                    $url = $result['url'];

                    $agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_VERBOSE, true);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
                    curl_setopt($ch, CURLOPT_URL,$url);
                    $result = curl_exec($ch);
                    echo $result;
                }
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
