<?php


App::uses('AppController', 'Controller');

/**
 * CarTypes Controller
 *
 * @property CarType $CarType
 * @property DetailRide $DetailRide
 * @property Ride $Ride
 * @property Profile $Profile
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class DetailRidesController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Security');
    public $uses = array('DetailRide', 'CarType', 'Ride', 'Profile','Parameter','MissionCostParameter');
    var $helpers = array('Xls');

    /**
     * @param null $params
     * @param null $orderType
     * @return array
     */
    public function getOrder($params = null , $orderType = null)
    {
        if($orderType == null){
            $orderType = 'DESC';
        }

        if (isset($params) && is_numeric($params)) {
            switch ($params) {
                case 1 :
                    $order = array('DetailRide.wording' => $orderType);
                    break;
                case 2 :
                    $order = array('DepartureDestination.name' => $orderType);
                    break;
                case 3 :
                    $order = array('ArrivalDestination.name' => $orderType);
                    break;
                case 4 :
                    $order = array('CarType.name' => $orderType);
                    break;
                case 5 :
                    $order = array('DetailRide.id' => $orderType);
                    break;


                default :
                    $order = array('DetailRide.id' => $orderType);
            }
            return $order;
        } else {
            $order = array('DetailRide.id' => $orderType);

            return $order;
        }
    }

    public function index()
    {
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::detail_trajet, $user_id, ActionsEnum::view, "DetailRides", null, "DetailRide", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();
        switch ($result) {
            case 1 :
                $conditions = null;
                break;
            case 2 :
                $conditions = array('DetailRide.user_id ' => $user_id);

                break;
            case 3 :
                $conditions = array('DetailRide.user_id !=' => $user_id);

                break;
            default:
                $conditions = null;
        }
        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => $limit,
            'order' => $order,
            'conditions' => $conditions,
            'fields' => array(
                'DetailRide.wording',
                'DetailRide.id',
                'CarType.name',
                'premium',
                'cost_truck_full',
                'cost_truck_empty',
                'DetailRide.duration_day',
                'DetailRide.duration_hour',
                'DetailRide.duration_minute',
                'DetailRide.real_duration_day',
                'DetailRide.real_duration_hour',
                'DetailRide.real_duration_minute',
                'DepartureDestination.name',
                'ArrivalDestination.name'
            ),
            'joins' => array(

                array(
                    'table' => 'rides',
                    'type' => 'left',
                    'alias' => 'Ride',
                    'conditions' => array('DetailRide.ride_id = Ride.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('DetailRide.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'DepartureDestination',
                    'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'ArrivalDestination',
                    'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                )


            )
        );

        $detailRides = $this->Paginator->paginate('DetailRide');

        $this->set('detailRides', $detailRides);
        $separatorAmount = $this->getSeparatorAmount();
        $carTypes = $this->CarType->getCarTypes();
        $users = $this->User->find('list', array('conditions' => 'User.id != 1'));
        $profiles = $this->Profile->getUserProfiles();
        $destinations = $this->DetailRide->Ride->DepartureDestination->find('list');
        $isSuperAdmin = $this->isSuperAdmin();
        $this->set(compact('profiles', 'limit', 'separatorAmount', 'carTypes', 'users', 'destinations', 'order', 'isSuperAdmin'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function search()
    {

        $this->setTimeActif();

        if (isset($this->request->data['keyword']) || isset($this->request->data['DetailRides']['user_id']) ||
            isset($this->request->data['DetailRides']['modified_id'])
            || isset($this->request->data['DetailRides']['created']) || isset($this->request->data['DetailRides']['created1'])
            || isset($this->request->data['DetailRides']['modified']) || isset($this->request->data['DetailRides']['modified1'])
            || isset($this->request->data['DetailRides']['arrival_destination_id'])
            || isset($this->request->data['DetailRides']['departure_destination_id'])
            || isset($this->request->data['DetailRides']['car_type_id']) || isset($this->request->data['DetailRides']['profile_id'])

        ) {
            $this->filterUrl();
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('DetailRide.id' => 'DESC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword']) || isset($this->params['named']['user']) || isset($this->params['named']['profile'])
            || isset($this->params['named']['created']) || isset($this->params['named']['created1'])
            || isset($this->params['named']['car_type']) || isset($this->params['named']['modified_id'])
            || isset($this->params['named']['departure_destination']) || isset($this->params['named']['arrival_destination'])
            || isset($this->params['named']['modified']) || isset($this->params['named']['modified1'])

        ) {
            $conditions = $this->getConds();

            $this->paginate = array(
                'paramType' => 'querystring',
                'recursive' => -1, // should be used with joins
                'limit' => $limit,
                'conditions' => $conditions,
                'order' => $order,

                //'conditions'=>array('OR' => array(" CONVERT(Ride.wording USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$keyword%", " CONVERT(DepartureDestination.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$keyword% ", "CONVERT(ArrivalDestination.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$keyword%")),
                'fields' => array(
                    'DetailRide.wording',
                    'DetailRide.id',
                    'CarType.name',
                    'premium',
                    'cost_truck_full',
                    'cost_truck_empty',
                    'DetailRide.duration_day',
                    'DetailRide.duration_hour',
                    'DetailRide.duration_minute',
                    'DepartureDestination.name',
                    'ArrivalDestination.name'
                ),
                'joins' => array(

                    array(
                        'table' => 'rides',
                        'type' => 'left',
                        'alias' => 'Ride',
                        'conditions' => array('DetailRide.ride_id = Ride.id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'CarType',
                        'conditions' => array('DetailRide.car_type_id = CarType.id')
                    ),
                    array(
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'DepartureDestination',
                        'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                    ),
                    array(
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'ArrivalDestination',
                        'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                    ),

                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('User.id = DetailRide.user_id')
                    )


                )
            );

            $detailRides = $this->Paginator->paginate('DetailRide');

            $this->set('detailRides', $detailRides);

        } else {
            $this->DetailRide->recursive = 0;
            $this->set('detailRides', $this->Paginator->paginate());
        }
        $users = $this->User->find('list', array('conditions' => 'User.id != 1'));
        $profiles = $this->Profile->getUserProfiles();
        $destinations = $this->DetailRide->Ride->DepartureDestination->find('list');
        $carTypes = $this->CarType->getCarTypes();
        $isSuperAdmin = $this->isSuperAdmin();
        $this->set(compact('profiles', 'limit', 'users', 'destinations', 'carTypes', 'order', 'isSuperAdmin'));
        $this->render();
    }

    private function filterUrl()
    {


        $filter_url['controller'] = $this->request->params['controller'];
        $filter_url['action'] = $this->request->params['action'];
        $filter_url['page'] = 1;
        $filter_url['keyword'] = $this->request->data['keyword'];
        //$filter_url['keyword'] = str_replace('/', '-', $filter_url['keyword']);

        if (isset($this->request->data['DetailRides']['departure_destination_id']) && !empty($this->request->data['DetailRides']['departure_destination_id'])) {
            $filter_url['departure_destination'] = $this->request->data['DetailRides']['departure_destination_id'];
        }
        if (isset($this->request->data['DetailRides']['arrival_destination_id']) && !empty($this->request->data['DetailRides']['arrival_destination_id'])) {
            $filter_url['arrival_destination'] = $this->request->data['DetailRides']['arrival_destination_id'];
        }

        if (isset($this->request->data['DetailRides']['car_type_id']) && !empty($this->request->data['DetailRides']['car_type_id'])) {
            $filter_url['car_type'] = $this->request->data['DetailRides']['car_type_id'];
        }

        if (isset($this->request->data['DetailRides']['user_id']) && !empty($this->request->data['DetailRides']['user_id'])) {
            $filter_url['user'] = $this->request->data['DetailRides']['user_id'];
        }

        if (isset($this->request->data['DetailRides']['profile_id']) && !empty($this->request->data['DetailRides']['profile_id'])) {
            $filter_url['profile'] = $this->request->data['DetailRides']['profile_id'];
        }

        if (isset($this->request->data['DetailRides']['created']) && !empty($this->request->data['DetailRides']['created'])) {
            $filter_url['created'] = str_replace("/", "-", $this->request->data['DetailRides']['created']);
        }
        if (isset($this->request->data['DetailRides']['created1']) && !empty($this->request->data['DetailRides']['created1'])) {
            $filter_url['created1'] = str_replace("/", "-", $this->request->data['DetailRides']['created1']);
        }
        if (isset($this->request->data['DetailRides']['modified_id']) && !empty($this->request->data['DetailRides']['modified_id'])) {
            $filter_url['modified_id'] = $this->request->data['DetailRides']['modified_id'];
        }
        if (isset($this->request->data['DetailRides']['modified']) && !empty($this->request->data['DetailRides']['modified'])) {
            $filter_url['modified'] = str_replace("/", "-", $this->request->data['DetailRides']['modified']);
        }


        return $this->redirect($filter_url);
    }

    private function getConds()
    {
        if (!empty($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));


            $conds = array('OR' => array(" CONVERT(Ride.wording USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$keyword%", " CONVERT(DepartureDestination.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$keyword% ", "CONVERT(ArrivalDestination.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$keyword%",

            ));
        } else {
            $conds = array();
        }


        if (isset($this->params['named']['departure_destination']) && !empty($this->params['named']['departure_destination'])) {


            $conds["Ride.departure_destination_id = "] = $this->params['named']['departure_destination'];
            $this->request->data['DetailRides']['departure_destination_id'] = $this->params['named']['departure_destination'];

        }

        if (isset($this->params['named']['arrival_destination']) && !empty($this->params['named']['arrival_destination'])) {


            $conds["Ride.arrival_destination_id = "] = $this->params['named']['arrival_destination'];
            $this->request->data['DetailRides']['arrival_destination_id'] = $this->params['named']['arrival_destination'];

        }

        if (isset($this->params['named']['car_type']) && !empty($this->params['named']['car_type'])) {


            $conds["DetailRide.car_type_id = "] = $this->params['named']['car_type'];
            $this->request->data['DetailRides']['car_type_id'] = $this->params['named']['car_type'];

        }


        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $conds["DetailRide.user_id = "] = $this->params['named']['user'];
            $this->request->data['DetailRides']['user_id'] = $this->params['named']['user'];
        }
        if (isset($this->params['named']['profile']) && !empty($this->params['named']['profile'])) {
            $conds["User.profile_id = "] = $this->params['named']['profile'];
            $this->request->data['DetailRides']['profile_id'] = $this->params['named']['profile'];
        }
        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $creat = str_replace("-", "/", $this->params['named']['created']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["DetailRide.created >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['DetailRides']['created'] = $creat;
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $creat = str_replace("-", "/", $this->params['named']['created1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["DetailRide.created <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['DetailRides']['created1'] = $creat;
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $conds["DetailRide.modified_id = "] = $this->params['named']['modified_id'];
            $this->request->data['DetailRides']['modified_id'] = $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["DetailRide.modified >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['DetailRides']['modified'] = $creat;
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["DetailRide.modified <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['DetailRides']['modified1'] = $creat;
        }


        return $conds;
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null)
    {
        $this->setTimeActif();
        if (!$this->DetailRide->exists($id)) {
            throw new NotFoundException(__('Invalid detail ride'));
        }
        $options = array('conditions' => array('DetailRide.' . $this->DetailRide->primaryKey => $id),
            'recursive' => -1,
            'fields' => array(
                'DetailRide.wording',
                'DetailRide.id',
                'CarType.name',
                'premium',

                'DetailRide.duration_day',
                'DetailRide.duration_hour',
                'DetailRide.duration_minute',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'DetailRide.description'
            ),
            'joins' => array(

                array(
                    'table' => 'rides',
                    'type' => 'left',
                    'alias' => 'Ride',
                    'conditions' => array('DetailRide.ride_id = Ride.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('DetailRide.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'DepartureDestination',
                    'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'ArrivalDestination',
                    'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                )


            ));

        $this->set('detailRide', $this->DetailRide->find('first', $options));
        $missionCosts = $this->DetailRide->MissionCost->find('all', array('conditions' => array('detail_ride_id' => $id)));

        $this->set('missionCosts', $missionCosts);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {

        $this->setTimeActif();

        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::detail_trajet, $user_id, ActionsEnum::add, "DetailRides", null, "DetailRide", null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->layout = 'ajax';
                $this->redirect(array('action' => 'index'));
            }

            // verify if detail ride exist already
            $exist = $this->verifyRideExist($this->request->data['DetailRide']['ride_id'], $this->request->data['DetailRide']['car_type_id']);
            if (!$exist) {
                $this->DetailRide->create();
                $this->request->data['DetailRide']['user_id'] = $this->Session->read('Auth.User.id');

                if ($this->DetailRide->save($this->request->data)) {


                    $detailRideId = $this->DetailRide->getInsertID();


                    $this->saveMissionCosts($this->request->data['MissionCost'], $detailRideId);

                    $this->Flash->success(__('The detail ride has been saved.'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->error(__('The detail ride could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('The detail ride could not be saved. This detail ride exist already.'));
                $this->redirect(array('action' => 'index'));
            }


        }

        $carTypes = $this->CarType->getCarTypes();
        $rideCategories = $this->DetailRide->MissionCost->RideCategory->find('list', array('order' => 'name ASC'));



        $managementParameterMissionCost = $this->Parameter->getCodesParameterVal('param_mission_cost');

        $useRideCategory = $this->useRideCategory();
        $timeParameters = $this->getTimeParametersToCalculateArrivalDate();
        $this->set(compact( 'carTypes', 'rideCategories', 'managementParameterMissionCost', 'useRideCategory', 'timeParameters'));


    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null)
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::detail_trajet, $user_id, ActionsEnum::edit, "DetailRides", $id, "DetailRide", null);
        if (!$this->DetailRide->exists($id)) {
            throw new NotFoundException(__('Invalid detail ride'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Detail ride cancelled.'));
                $this->redirect(array('action' => 'index'));
            }

            $this->request->data['DetailRide']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->DetailRide->save($this->request->data)) {


                $this->saveMissionCosts($this->request->data['MissionCost'], $id);

                $this->Flash->success(__('The detail ride has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The detail ride could not be saved. Please, try again.'));
            }

        } else {
            $options = array('conditions' => array('DetailRide.' . $this->DetailRide->primaryKey => $id));
            $this->request->data = $this->DetailRide->find('first', $options);

            $this->DetailRide->Ride->virtualFields = array('cnames' => "CONCAT(DepartureDestination.name, ' - ', ArrivalDestination.name)");

            $rides = $this->DetailRide->Ride->find('list', array(
                    'fields' => 'cnames',
                    'conditions'=>array('Ride.id'=>$this->request->data['DetailRide']['ride_id']),
                    'joins' => array(
                        array(
                            'table' => 'destinations',
                            'type' => 'left',
                            'alias' => 'DepartureDestination',
                            'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                        ),
                        array(
                            'table' => 'destinations',
                            'type' => 'left',
                            'alias' => 'ArrivalDestination',
                            'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                        )
                    )
                )
            );

        }

        $carTypes = $this->CarType->getCarTypes();
        $rideCategories = $this->DetailRide->MissionCost->RideCategory->find('list', array('order' => 'name ASC'));
        $missionCosts = $this->DetailRide->MissionCost->find('all', array('conditions' => array('detail_ride_id' => $id)));

        $nbMissionCosts = $this->DetailRide->MissionCost->find('count', array('conditions' => array('detail_ride_id' => $id)));

        $paramMissionCost = $this->getParamMissionCostByDistance();

        $managementParameterMissionCost = $this->Parameter->getCodesParameterVal('param_mission_cost');

        $useRideCategory = $this->useRideCategory();
        $timeParameters = $this->getTimeParametersToCalculateArrivalDate();
        $this->set(compact('rides', 'carTypes', 'rideCategories', 'missionCosts', 'nbMissionCosts',
            'managementParameterMissionCost', 'useRideCategory', 'timeParameters'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null)
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::detail_trajet, $user_id, ActionsEnum::delete, "DetailRides", $id, "DetailRide", null);
        $this->DetailRide->id = $id;
        if (!$this->DetailRide->exists()) {
            throw new NotFoundException(__('Invalid detail ride'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->DetailRide->delete()) {
            $this->Flash->success(__('The detail ride has been deleted.'));
        } else {
            $this->Flash->error(__('The detail ride could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteDetailRides()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $user_id = $this->Auth->user('id');
        $id = filter_input(INPUT_POST, "id");
        $this->verifyUserPermission(SectionsEnum::detail_trajet, $user_id, ActionsEnum::delete, "DetailRides", $id, "DetailRide", null);
        $this->DetailRide->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->DetailRide->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }
    }

    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $result = $this->DetailRide->SheetRideDetailRides->find('first', array("conditions" => array("SheetRideDetailRides.detail_ride_id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The detail ride could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        $result = $this->DetailRide->TransportBillDetailRides->find('first', array("conditions" => array("TransportBillDetailRides.detail_ride_id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The detail ride could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        $result = $this->DetailRide->Price->find('first', array("conditions" => array("Price.detail_ride_id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The detail ride could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        $this->loadModel('MissionCost');
        $missionCosts = $this->MissionCost->find('first', array("conditions" => array("MissionCost.detail_ride_id =" => $id)));
        if(!empty($missionCosts)){
            $this->MissionCost->deleteAll(array('MissionCost.detail_ride_id' => $id), false);
        }


    }

    function export()
    {
        $this->setTimeActif();
        $detailRides = $this->DetailRide->find('all', array(
            'order' => 'DetailRide.name asc',
            'recursive' => 2
        ));
        $this->set('models', $detailRides);
    }

    public function getNameRide($ride_id = null)
    {


        $this->layout = 'ajax';
        $ride = $this->DetailRide->Ride->find('first', array(
            'conditions' => array('Ride.id' => $ride_id),
            'recursive' => -1,
            'fields' => array('DepartureDestination.name', 'DepartureDestination.latlng', 'ArrivalDestination.name', 'ArrivalDestination.latlng'),
            'joins' => array(


                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'DepartureDestination',
                    'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'ArrivalDestination',
                    'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                )
            )));
        $this->set('ride', $ride);
    }


    /**
     * verify if ride exist already
     *
     **/

    private function verifyRideExist($rideId = null, $carTypeId = null, $id = null)
    {

        $exist = false;

        $ride = $this->DetailRide->find('first', array('conditions' => array('DetailRide.ride_id' => $rideId, 'DetailRide.car_type_id' => $carTypeId, 'DetailRide.id !=' => $id)));

        if (!empty($ride)) {

            $exist = true;
        }

        return $exist;

    }

    /*
     *  return value of mission cost when truck is full and when is empty
     *  return array
     */

    private function getParamMissionCostByDistance()
    {
        $param = $this->Parameter->find('first', array('conditions' => array('code' => 12), 'fields' => array('mission_cost_truck_full', 'mission_cost_truck_empty')));
        $paramMissionCost = array();
        $paramMissionCost['mission_cost_truck_full'] = $param['Parameter']['mission_cost_truck_full'];
        $paramMissionCost['mission_cost_truck_empty'] = $param['Parameter']['mission_cost_truck_empty'];
        return $paramMissionCost;

    }


    public function getMissionCost($i)
    {
        $this->layout = 'ajax';
        $rideCategories = $this->DetailRide->MissionCost->RideCategory->find('list', array('order' => 'name ASC'));
        $this->set('rideCategories', $rideCategories);
        $i++;
        $this->set('i', $i);

    }

    private function saveMissionCosts($missionCosts = null, $detailRideId = null)
    {


        $this->loadModel('MissionCost');
        $this->MissionCost->deleteAll(['MissionCost.detail_ride_id' => $detailRideId]);
        $managementParameterMissionCost = $this->Parameter->getCodesParameterVal('param_mission_cost');
        switch ($managementParameterMissionCost) {
            case 1:
                $this->MissionCost->create();
                $data['MissionCost']['detail_ride_id'] = $detailRideId;
                $data['MissionCost']['cost_day'] = $missionCosts[0]['cost_day'];
                $this->MissionCost->save($data);
                break;

            case 2:
                $this->MissionCost->create();
                $data['MissionCost']['detail_ride_id'] = $detailRideId;
                $data['MissionCost']['cost_destination'] = $missionCosts[0]['cost_destination'];
                $this->MissionCost->save($data);
                break;
            case 3:
                foreach ($missionCosts as $missionCost) {
                    $this->MissionCost->create();
                    $data['MissionCost']['detail_ride_id'] = $detailRideId;
                    if (isset($missionCost['ride_category_id'])) {
                        $data['MissionCost']['ride_category_id'] = $missionCost['ride_category_id'];
                    }
                    $data['MissionCost']['cost_truck_full'] = $missionCost['cost_truck_full'];
                    $data['MissionCost']['cost_truck_empty'] = $missionCost['cost_truck_empty'];

                    $this->MissionCost->save($data);

                }
                break;

        }

    }

    public function getCodeByRideAndCarType($rideId = null, $carTypeId = null)
    {
        $this->layout = 'ajax';
        $code = '';
        $ride = $this->DetailRide->Ride->find('first', array('conditions' => array('Ride.id' => $rideId),
            'recursive' => -1, 'fields' => array('Ride.wording')));
        $carType = $this->CarType->getCarTypeById($carTypeId);
        if (!empty($ride) && !empty($carType)) {
            $code = $ride['Ride']['wording'] . '/' . $carType['CarType']['code'];
        }
        $this->set('code', $code);

    }

    public function getAverageSpeedByCarType($carTypeId = null)
    {
        $this->layout = 'ajax';
        $carType = $this->CarType->getCarTypeById($carTypeId);

        if (!empty($carType)) {
            $averageSpeed = $carType['CarType']['average_speed'];
            if (empty($averageSpeed)) {
                // Get average speed by car type
                $averageSpeed = $this->Car->getAverageSpeedByCarType($carTypeId);
            }
            $this->set('averageSpeed', $averageSpeed);
        } else {
            $this->set('averageSpeed', NULL);
        }
    }


    public function import()
    {
        if (!empty($this->request->data['DetailRide']['file_csv']['tmp_name'])) {

            if (is_uploaded_file($this->request->data['DetailRide']['file_csv']['tmp_name'])) {
                $fichier = $this->request->data['DetailRide']['file_csv']['name'];
                $ext = substr(strtolower(strrchr($fichier, '.')), 1);
                if ($ext == 'csv') {
                    if ($fichier) {
                        $fp = fopen($this->request->data['DetailRide']['file_csv']['tmp_name'], "r");

                    } else {

                        echo('fichier introuvable');
                        exit();
                    }
                    $cpt = 0;
                    while (!feof($fp)) {

                        $ligne = fgets($fp, 4096);
                        if (count(explode(";", $ligne)) > 1) {

                            $liste = explode(";", $ligne);
                        } else {

                            $liste = explode(",", $ligne);
                        }
                        filter_input(INPUT_POST, 'file_csv');
                        $liste[0] = (isset($liste[0])) ? $liste[0] : Null;
                        $liste[1] = (isset($liste[1])) ? $liste[1] : Null;
                        $liste[2] = (isset($liste[2])) ? $liste[2] : Null;
                        $liste[3] = (isset($liste[3])) ? $liste[3] : Null;
                        $liste[4] = (isset($liste[4])) ? $liste[4] : Null;
                        $liste[5] = (isset($liste[5])) ? $liste[5] : Null;
                        $liste[6] = (isset($liste[6])) ? $liste[6] : Null;
                        $liste[7] = (isset($liste[7])) ? $liste[7] : Null;
                        $rideCode = $liste[0];
                        $carTypeCode = $liste[1];
                        $durationDay = $liste[2];
                        $durationHour = $liste[3];
                        $durationMinute = $liste[4];
                        $realDurationDay = $liste[5];
                        $realDurationHour = $liste[6];
                        $realDurationMinute = $liste[7];
                        $rideId = $this->getRideId($rideCode);
                        $carTypeId = $this->getCarTypeId($carTypeCode);

                        $code = $rideCode . '/' . $carTypeCode;

                        if ($cpt > 0) {

                            $this->DetailRide->create();
                            if (!empty($code)) {
                                $this->request->data['DetailRide']['wording'] = $code;
                            }
                            $this->request->data['DetailRide']['ride_id'] = $rideId;
                            $this->request->data['DetailRide']['car_type_id'] = $carTypeId;
                            $this->request->data['DetailRide']['duration_day'] = $durationDay;
                            $this->request->data['DetailRide']['duration_hour'] = $durationHour;
                            $this->request->data['DetailRide']['duration_minute'] = $durationMinute;
                            $this->request->data['DetailRide']['real_duration_day'] = $realDurationDay;
                            $this->request->data['DetailRide']['real_duration_hour'] = $realDurationHour;
                            $this->request->data['DetailRide']['real_duration_minute'] = $realDurationMinute;
                            $this->request->data['DetailRide']['user_id'] = $this->Session->read('Auth.User.id');

                            if ($rideId > 0 && $carTypeId > 0 &&
                                $durationDay > 0 && $durationHour > 0 && $durationMinute > 0 &&
                                $realDurationDay > 0 && $realDurationHour > 0 && $realDurationMinute > 0
                            ) {
                                $this->DetailRide->save($this->request->data);
                            }

                        }
                        $cpt++;
                    }

                    fclose($fp);
                    echo json_encode(array("response" => "true"));
                    $this->Flash->success(__('The file has been successfully imported'));

                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->error(__('The file must be in csv format'));
                    $this->redirect(array('action' => 'index'));

                }

            }

        }

    }

    public function getRideId($rideImport)
    {
        $rideImport = trim($rideImport);
        $rideImport = strtolower($rideImport);
        $rideId = 0;
        $rides = $this->DetailRide->Ride->find('all', array('recursive' => -1));
        foreach ($rides as $ride) {
            $rideCode = strtolower($ride['Ride']['wording']);
            if ($rideImport == $rideCode) {
                $rideId = $ride['Ride']['id'];
            }
        }
        return $rideId;
    }

    public function getCarTypeId($carTypeImport)
    {
        $carTypeImport = trim($carTypeImport);
        $carTypeImport = strtolower($carTypeImport);
        $carTypeId = 0;
        $carTypes = $this->CarType->getCarTypes();
        foreach ($carTypes as $carType) {
            $carTypeCode = strtolower($carType['CarType']['code']);
            if ($carTypeImport == $carTypeCode) {
                $carTypeId = $carType['CarType']['id'];
            }
        }
        return $carTypeId;
    }

    public function liste($id = null, $keyword = null)
    {
        $keyword = str_replace('espace', ' ', $keyword);
        $keyword = str_replace('slash', '/', $keyword);
        $keyword = strtolower($keyword);
        $this->layout = 'ajax';
        $limit = $this->getLimit();
        switch ($id) {
            case 2 :
                $conditions = array("LOWER(DetailRide.wording) LIKE" => "%$keyword%");
                break;
            case 3 :
                $conditions = array('OR' => array(
                    "LOWER(DepartureDestination.name) LIKE" => "%$keyword%",
                    "LOWER(ArrivalDestination.name) LIKE" => "%$keyword%",
                ));
                break;
            case 4 :
                $conditions = array("LOWER(CarType.name) LIKE" => "%$keyword%",);
                break;

            case 5 :

                $conditions = array('OR' => array(
                    "LOWER(DetailRide.duration_day) LIKE" => "%$keyword%",
                    "LOWER(DetailRide.duration_hour) LIKE" => "%$keyword%",
                    "LOWER(DetailRide.duration_minute) LIKE" => "%$keyword%",
                ));
                break;

            case 6 :

                $conditions = array('OR' => array(
                    "LOWER(DetailRide.real_duration_day) LIKE" => "%$keyword%",
                    "LOWER(DetailRide.real_duration_hour) LIKE" => "%$keyword%",
                    "LOWER(DetailRide.real_duration_minute) LIKE" => "%$keyword%",
                ));
                break;


            default:
                $conditions = array("LOWER(Ride.wording) LIKE" => "%$keyword%");
        }

        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit'=>$limit,
            'conditions' => $conditions,
            'fields' => array(
                'DetailRide.wording',
                'DetailRide.id',
                'CarType.name',
                'premium',
                'cost_truck_full',
                'cost_truck_empty',
                'DetailRide.duration_day',
                'DetailRide.duration_hour',
                'DetailRide.duration_minute',
                'DetailRide.real_duration_day',
                'DetailRide.real_duration_hour',
                'DetailRide.real_duration_minute',
                'DepartureDestination.name',
                'ArrivalDestination.name'
            ),
            'joins' => array(

                array(
                    'table' => 'rides',
                    'type' => 'left',
                    'alias' => 'Ride',
                    'conditions' => array('DetailRide.ride_id = Ride.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('DetailRide.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'DepartureDestination',
                    'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'ArrivalDestination',
                    'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                )


            )
        );

        $detailRides = $this->Paginator->paginate('DetailRide');
        $this->set('detailRides', $detailRides);


    }

    public function addMultiple()
    {


        $rides = $this->DetailRide->Ride->find('all', array(

            'fields' => array('DepartureDestination.name', 'DepartureDestination.latlng',
                'ArrivalDestination.name', 'ArrivalDestination.latlng', 'Ride.id'),
            'recursive' => -1,
            'conditions' => array('Ride.id >=' => 21, 'Ride.id <=' => 30),
            'joins' => array(
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'DepartureDestination',
                    'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'ArrivalDestination',
                    'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                )
            )));
        $this->set(compact('rides'));
    }

    public function getDetailRidesByKeyWord()
    {
        $this->autoRender = false;
        $term = $this->request->query['q'];
        $term = explode('-',$term);
        $term[0] = trim(strtolower(($term[0])));
        if(isset($term[1])){
            $term[1] = trim(strtolower(($term[1])));
        }
        if(isset($_GET['carTypeId'])){
            $carTypeId = $_GET['carTypeId'];
        }

        if (isset($carTypeId )&& !empty($carTypeId)){
            $carTypeCondition = array('CarType.id'=>$carTypeId);
        }
        if(count($term)>1){
              $conds = array(
                  "CONVERT(DepartureDestination.name USING utf8)  COLLATE utf8_general_ci  LIKE " => "%$term[0]%",
                  "CONVERT(ArrivalDestination.name USING utf8)  COLLATE utf8_general_ci LIKE " => "%$term[1]%"

              );
          }else {
        $conds = array(
            'OR' => array(
                " CONVERT(DepartureDestination.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term[0]%",
                "CONVERT(ArrivalDestination.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term[0]%",
            )
        );
         }

        if (isset($carTypeCondition)) {
            $conds = array_merge($carTypeCondition, $conds);
        }



        $detailRides = $this->DetailRide->find(
            'all',
            array(
            'order' =>array('DetailRide.wording ASC', 'DepartureDestination.name ASC','ArrivalDestination.name ASC' ),
            'recursive' => -1,
            'conditions' => $conds,
            'fields' => array(
                'DetailRide.id',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'CarType.name'
            ),
            'joins' => array(
                array(
                    'table' => 'rides',
                    'type' => 'left',
                    'alias' => 'Ride',
                    'conditions' => array('DetailRide.ride_id = Ride.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('DetailRide.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'DepartureDestination',
                    'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'ArrivalDestination',
                    'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                )


            )
        ));

        $data = array();
        $i = 0;
		 $data[$i]['id'] = "";
         $data[$i]['text'] = "";
		 $i++;
        foreach ($detailRides as $detailRide) {
            $data[$i]['id'] = $detailRide['DetailRide']['id'];
            $data[$i]['text'] = $detailRide['DepartureDestination']['name'] . ' - ' . $detailRide['ArrivalDestination']['name'] . ' - ' . $detailRide['CarType']['name'];
            $i++;
        }
        echo json_encode($data);
    }

    public function getMissionCostParameterByCarType($missionCostParameter, $carTypeId = null){
        $this->layout = 'ajax';
        $parameterMissionCostDay = $this->MissionCostParameter ->getMissionCostParameters($missionCostParameter,$carTypeId);
        $this->set(compact('parameterMissionCostDay','missionCostParameter'));
    }




}

?>