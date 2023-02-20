<?php


App::uses('AppController', 'Controller');

/**
 * Ride Controller
 *
 * @property Ride $Ride
 * @property Destination $Destination
 * @property Profile $Profile
 * @property Wilaya $Wilaya
 * @property Daira $Daira
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class RidesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session','Security');
    
    var $helpers = array('Xls');
    public $uses = array('Ride','Destination','Daira', 'Wilaya', 'Profile');

    /**
     * @param null $params
     * @param null $orderType
     * @return array
     */
    public function getOrder ($params = null, $orderType = null){

        if($orderType == null){
            $orderType = 'DESC';
        }
        if (isset($params) && is_numeric($params)) {
            switch($params){
                case 1 :
                    $order = array('Ride.wording' => $orderType);
                    break;
                case 2 :
                    $order = array('DepartureDestination.name' => $orderType);
                    break;
                case 3 :
                    $order = array('ArrivalDestination.name' => $orderType);
                    break;
                case 4 :
                    $order = array('Ride.id' => $orderType);
                    break;


                default : $order = array('Ride.id' => $orderType);
            }
            return $order;
        } else {
            $order = array('Ride.id' => $orderType);

            return $order;
        }
    }
    public function index() {
        
        $this->setTimeActif();


        $user_id = $this->Auth->user('id');

        $result = $this->verifyUserPermission(SectionsEnum::trajet, $user_id, ActionsEnum::view,
            "Rides", null, "Ride", null);

        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();
        switch ($result) {
            case 1 :
                $conditions = null;
                break;
            case 2 :
                $conditions = array('Ride.user_id ' => $user_id);
                break;
            case 3 :
                $conditions = array('Ride.user_id !=' => $user_id);
                break;

            default:
                $conditions = null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => $order,
            'conditions' => $conditions,
            'paramType' => 'querystring'
        );


        $this->Ride->recursive = 0;
        $rides = $this->Paginator->paginate();

        $this->set('rides',$rides );
        $users = $this->TransportBill->User->find('list' , array('conditions' => 'User.id != 1'));
        $profiles = $this->Profile->getUserProfiles();
        $destinations = $this->Ride->DepartureDestination->find('list');
        $isSuperAdmin = $this->isSuperAdmin();
        $this->set(compact('limit','destinations','users','profiles','order','isSuperAdmin'));

    }

    /**
     * index method
     *
     * @return void
     */
    public function search() {

        $this->setTimeActif();

        if (isset($this->request->data['keyword']) || isset($this->request->data['Rides']['user_id']) ||
            isset($this->request->data['Rides']['modified_id'])
            || isset($this->request->data['Rides']['created']) || isset($this->request->data['Rides']['created1'])
            || isset($this->request->data['Rides']['modified']) || isset($this->request->data['Rides']['modified1'])
            || isset($this->request->data['Rides']['arrival_destination_id'])
            || isset($this->request->data['Rides']['departure_destination_id'])

        ) {
            $this->filterUrl();
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Ride.id' => 'DESC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword']) || isset($this->params['named']['user'])
            || isset($this->params['named']['created']) || isset($this->params['named']['created1'])
            || isset($this->params['named']['ride']) || isset($this->params['named']['modified_id'])
            || isset($this->params['named']['departure_destination']) || isset($this->params['named']['arrival_destination'])
            || isset($this->params['named']['modified']) || isset($this->params['named']['modified1'])

        ){
            $conditions = $this->getConds();
            $this->paginate = array(
                'paramType' => 'querystring',
                'recursive' => -1, // should be used with joins
                'limit' => $limit,
                'conditions'=>$conditions,
                'order' => array('Ride.id' => 'DESC'),

                //'conditions'=>array('OR' => array(" CONVERT(Ride.wording USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$keyword%", " CONVERT(DepartureDestination.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$keyword% ", "CONVERT(ArrivalDestination.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$keyword%")),
                'fields' => array(
                    'Ride.id',
                    'Ride.wording',
                    'DepartureDestination.name',
                    'ArrivalDestination.name',
                    'Ride.distance'

                ),
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
                    ),
                )
            );
            $rides = $this->Paginator->paginate('Ride');
            $this->set('rides', $rides);

        } else {
            $this->Ride->recursive = 0;
            $this->set('rides', $this->Paginator->paginate());
        }
        $users = $this->TransportBill->User->find('list' , array('conditions' => 'User.id != 1'));
        $profiles = $this->Profile->getUserProfiles();
        $destinations = $this->Ride->DepartureDestination->find('list');
        $isSuperAdmin = $this->isSuperAdmin();
        $this->set(compact('limit','users','destinations','profiles','isSuperAdmin'));
        $this->render();
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->setTimeActif();
        if (!$this->Ride->exists($id)) {
            throw new NotFoundException(__('Invalid ride'));
        }
        $options = array('conditions' => array('Ride.' . $this->Ride->primaryKey => $id));
        $this->set('ride', $this->Ride->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
   
        $this->setTimeActif();

        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::trajet, $user_id, ActionsEnum::add,
            "Rides", null, "Ride", null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                 $this->layout = 'ajax';
                $this->redirect(array('action' => 'index'));
            }
            // verify if ride exist already
            $exist = $this->verifyRideExist($this->request->data['Ride']['departure_destination_id'],
                $this->request->data['Ride']['arrival_destination_id']);
            if (!$exist) {
                $this->Ride->create();
                $this->request->data['Ride']['user_id'] = $this->Session->read('Auth.User.id');


                if ($this->Ride->save($this->request->data)) {

                $this->Flash->success(__('The ride has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The ride could not be saved. Please, try again.'));
            }
				} else {
					 $this->Flash->error(__('The ride could not be saved. This ride exist already.'));
					$this->redirect(array('action' => 'index'));
				}
        }
        $this->Ride->DepartureDestination->virtualFields = array(
            'cnames' => "CONCAT(DepartureDestination.code, ' - ', DepartureDestination.name ,' - ', Daira.code, ' - ', Daira.name  ,' - ', Wilaya.code, ' - ', Wilaya.name  )"
        );
        $destinations = $this->Ride->DepartureDestination->find('list', array(
            'fields' => 'cnames',
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'dairas',
                    'type' => 'left',
                    'alias' => 'Daira',
                    'conditions' => array('DepartureDestination.daira_id = Daira.id')
                ),
                array(
                    'table' => 'wilayas',
                    'type' => 'left',
                    'alias' => 'Wilaya',
                    'conditions' => array('DepartureDestination.wilaya_id = Wilaya.id')
                ),


            )
        ));
        $this->set(compact('destinations'));

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
        $this->verifyUserPermission(SectionsEnum::trajet, $user_id, ActionsEnum::edit, "Rides", $id, "Ride", null);
        if (!$this->Ride->exists($id)) {
            throw new NotFoundException(__('Invalid ride'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Ride cancelled.'));
                return $this->redirect(array('action' => 'index'));
            }
            // verify if ride exist already
            $exist = $this->verifyRideExist($this->request->data['Ride']['departure_destination_id'],
                $this->request->data['Ride']['arrival_destination_id'], $id);
            if (!$exist) {
                $this->request->data['Ride']['last_modifier_id'] = $this->Session->read('Auth.User.id');
                if ($this->Ride->save($this->request->data)) {
                    $this->Flash->success(__('The ride has been saved.'));
                     $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->error(__('The ride could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('The ride could not be saved. This ride exist already.'));
                 $this->redirect(array('action' => 'index'));

            }
        } else {
            $options = array('conditions' => array('Ride.' . $this->Ride->primaryKey => $id));
            $this->request->data = $this->Ride->find('first', $options);

            $this->set(compact('departureDairas', 'arrivalDairas', 'departureWilayas', 'arrivalWilayas'));


        }
        $this->Ride->DepartureDestination->virtualFields = array(
            'cnames' => "CONCAT(DepartureDestination.code, ' - ', DepartureDestination.name ,' - ', Daira.code, ' - ', Daira.name  ,' - ', Wilaya.code, ' - ', Wilaya.name  )"
        );
        $destinations = $this->Ride->DepartureDestination->find('list', array(
            'fields' => 'cnames',
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'dairas',
                    'type' => 'left',
                    'alias' => 'Daira',
                    'conditions' => array('DepartureDestination.daira_id = Daira.id')
                ),
                array(
                    'table' => 'wilayas',
                    'type' => 'left',
                    'alias' => 'Wilaya',
                    'conditions' => array('DepartureDestination.wilaya_id = Wilaya.id')
                ),


            )
        ));
        $this->set(compact('destinations'));

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
        $this->verifyUserPermission(SectionsEnum::trajet, $user_id, ActionsEnum::delete, "Rides", $id, "Ride", null);
        $this->Ride->id = $id;
        if (!$this->Ride->exists()) {
            throw new NotFoundException(__('Invalid ride'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Ride->delete()) {
            $this->Flash->success(__('The ride has been deleted.'));
        } else {
            $this->Flash->error(__('The ride could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleterides()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $user_id = $this->Auth->user('id');
        $id = filter_input(INPUT_POST, "id");
        $this->verifyUserPermission(SectionsEnum::trajet, $user_id, ActionsEnum::delete, "Rides", $id, "Ride", null);
        $this->Ride->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Ride->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }        /*}else{
            echo json_encode(array("response" => "false"));
        }*/
    }

    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $result = $this->Ride->DetailRide->find('first', array("conditions" => array("DetailRide.ride_id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The ride could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        } 


    }

    function export()
    {
        $this->setTimeActif();
        $rides = $this->Ride->find('all', array(
            'order' => 'Ride.name asc',
            'recursive' => 2
        ));
        $this->set('models', $rides);
    }

    function getNameDestination($destination_id = null, $id = null)
    {
        $this->setTimeActif();
        $this->layout = 'ajax';

        $destination = $this->Ride->DepartureDestination->find('first',
            array('conditions' => array("DepartureDestination.id" => $destination_id)));
        if ($id == 'departure_destination') {

            $idInput = 'origin';
        } else {

            $idInput = 'destination';

        }
        $this->set(compact('destination', 'idInput'));

    }

    /**
     *  recuperer la daira et la xilaya d'une ville $destinationId
     *
     **/
    function getDairaAndWilayaByDestination($destinationId = null, $id = null)
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        $this->set("id", $id);
        $destination = $this->Ride->DepartureDestination->find('first', array(
            'conditions' => array("DepartureDestination.id" => $destinationId),
            'recursive' => -1,
            'fields' => array('DepartureDestination.daira_id', 'DepartureDestination.wilaya_id')
        ));
        if (!empty($destination)) {
            $dairaId = $destination['DepartureDestination']['daira_id'];
            if (!empty($dairaId)) {

                $dairas = $this->Daira->getDairaById($dairaId);
            }
            $wilayaId = $destination['DepartureDestination']['wilaya_id'];

            if (!empty($wilayaId)) {
                $wilayas = $this->Wilaya->getWilayaById($wilayaId);
            }
            $this->set(compact('dairaId', 'dairas', 'wilayaId', 'wilayas'));
        }


    }

    /**
     * verify if ride exist already
     *
     **/

    private function verifyRideExist($departureDestinationId = null, $arrivalDestinationId = null, $id = null)
    {

        $exist = false;

        $ride = $this->Ride->find('first', array(
                'conditions' => array(
                    'Ride.departure_destination_id' => $departureDestinationId,
                    'Ride.arrival_destination_id' => $arrivalDestinationId,
                    'Ride.id !=' => $id
                )
            ));

        if (!empty($ride)) {

            $exist = true;
        }

        return $exist;

    }


    private function filterUrl()
    {


        $filter_url['controller'] = $this->request->params['controller'];
        $filter_url['action'] = $this->request->params['action'];
        $filter_url['page'] = 1;
        $filter_url['keyword'] = $this->request->data['keyword'];
        //$filter_url['keyword'] = str_replace('/', '-', $filter_url['keyword']);

        if (isset($this->request->data['Rides']['departure_destination_id']) && !empty($this->request->data['Rides']['departure_destination_id'])) {
            $filter_url['departure_destination'] = $this->request->data['Rides']['departure_destination_id'];
        }
        if (isset($this->request->data['Rides']['arrival_destination_id']) && !empty($this->request->data['Rides']['arrival_destination_id'])) {
            $filter_url['arrival_destination'] = $this->request->data['Rides']['arrival_destination_id'];
        }

        if (isset($this->request->data['Rides']['user_id']) && !empty($this->request->data['Rides']['user_id'])) {
            $filter_url['user'] = $this->request->data['Rides']['user_id'];
        }
        if (isset($this->request->data['Rides']['created']) && !empty($this->request->data['Rides']['created'])) {
            $filter_url['created'] = str_replace("/", "-", $this->request->data['Rides']['created']);
        }
        if (isset($this->request->data['Rides']['created1']) && !empty($this->request->data['Rides']['created1'])) {
            $filter_url['created1'] = str_replace("/", "-", $this->request->data['Rides']['created1']);
        }
        if (isset($this->request->data['Rides']['modified_id']) && !empty($this->request->data['Rides']['modified_id'])) {
            $filter_url['modified_id'] = $this->request->data['Rides']['modified_id'];
        }
        if (isset($this->request->data['Rides']['modified']) && !empty($this->request->data['Rides']['modified'])) {
            $filter_url['modified'] = str_replace("/", "-", $this->request->data['Rides']['modified']);
        }


        return $this->redirect($filter_url);
    }

    private function getConds()
    {
        if (!empty($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));


            $conds = array(
                'OR' => array(
                    " CONVERT(Ride.wording USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$keyword%",
                    " CONVERT(DepartureDestination.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$keyword% ",
                    "CONVERT(ArrivalDestination.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$keyword%",

                )
            );
        } else {
            $conds = array();
        }


        if (isset($this->params['named']['departure_destination']) && !empty($this->params['named']['departure_destination'])) {


            $conds["Ride.departure_destination_id = "] = $this->params['named']['departure_destination'];
            $this->request->data['Rides']['departure_destination_id'] = $this->params['named']['departure_destination'];

        }

        if (isset($this->params['named']['arrival_destination']) && !empty($this->params['named']['arrival_destination'])) {


            $conds["Ride.arrival_destination_id = "] = $this->params['named']['arrival_destination'];
            $this->request->data['Rides']['arrival_destination_id'] = $this->params['named']['arrival_destination'];

        }


        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $conds["Ride.user_id = "] = $this->params['named']['user'];
            $this->request->data['Rides']['user_id'] = $this->params['named']['user'];
        }
        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $creat = str_replace("-", "/", $this->params['named']['created']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Ride.created >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Rides']['created'] = $creat;
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $creat = str_replace("-", "/", $this->params['named']['created1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Ride.created <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Ride']['created1'] = $creat;
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $conds["Ride.modified_id = "] = $this->params['named']['modified_id'];
            $this->request->data['Rides']['modified_id'] = $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Ride.modified >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Rides']['modified'] = $creat;
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Ride.modified <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Rides']['modified1'] = $creat;
        }


        return $conds;
    }


    public function getCodeByDestination($departureDestinationId = null, $arrivalDestinationId = null)
    {
        $this->layout = 'ajax';
        $code = '';
        $departureDestination = $this->Destination->find('first', array(
            'conditions' => array('Destination.id' => $departureDestinationId),
            'recursive' => -1,
            'fields' => array('Destination.id', 'Destination.code')
        ));
        $arrivalDestination = $this->Destination->find('first', array(
            'conditions' => array('Destination.id' => $arrivalDestinationId),
            'recursive' => -1,
            'fields' => array('Destination.id', 'Destination.code')
        ));


        if (!empty($departureDestination)) {
            $departureDestinationCode = $departureDestination['Destination']['code'];
        }

        if (!empty($arrivalDestination)) {
            $arrivalDestinationCode = $arrivalDestination['Destination']['code'];
        }


        if (!empty($departureDestinationCode) && !empty($arrivalDestinationCode)) {
            $code = $departureDestinationCode . '/' . $arrivalDestinationCode;
        }


        $this->set('code', $code);
        return $code;

    }

    public function import()
    {
        if (!empty($this->request->data['Ride']['file_csv']['tmp_name'])) {

            if (is_uploaded_file($this->request->data['Ride']['file_csv']['tmp_name'])) {
                $fichier = $this->request->data['Ride']['file_csv']['name'];
                $ext = substr(strtolower(strrchr($fichier, '.')), 1);
                if ($ext == 'csv') {
                    if ($fichier) {
                        $fp = fopen($this->request->data['Ride']['file_csv']['tmp_name'], "r");

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
                        $liste[0] = (isset($liste[0])) ? $liste[0] : null;
                        $liste[1] = (isset($liste[1])) ? $liste[1] : null;
                        $liste[2] = (isset($liste[2])) ? $liste[2] : null;
                        $departureDestination = $liste[0];
                        $arrivalDestination = $liste[1];
                        $distance = $liste[2];
                        $departureDestinationId = $this->getDestinationId($departureDestination);
                        $arrivalDestinationId = $this->getDestinationId($arrivalDestination);
                        $code = $departureDestination . '/' . $arrivalDestination;
                        if ($cpt > 0) {
                            $this->Ride->create();
                            if (!empty($code)) {
                                $this->request->data['Ride']['wording'] = $code;
                            }
                            $this->request->data['Ride']['departure_destination_id'] = $departureDestinationId;
                            $this->request->data['Ride']['arrival_destination_id'] = $arrivalDestinationId;
                            $this->request->data['Ride']['distance'] = $distance;
                            $this->request->data['Ride']['user_id'] = $this->Session->read('Auth.User.id');

                            $this->Ride->save($this->request->data);
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

    public function getDestinationId($destinationImport)
    {
        $destinationImport = trim($destinationImport);
        $destinationImport = strtolower($destinationImport);
        $destinationId = 0;
        $destinations = $this->Destination->find('all', array('recursive' => -1));
        foreach ($destinations as $destination) {
            $destinationCode = strtolower($destination['Destination']['code']);
            if ($destinationImport == $destinationCode) {
                $destinationId = $destination['Destination']['id'];
            }
        }
        return $destinationId;
    }

    public function liste( $id = null, $keyword = null)
    {
        $keyword = str_replace('espace', ' ', $keyword);
        $keyword = str_replace('slash', '/', $keyword);
        $keyword = strtolower($keyword);
        $this->layout = 'ajax';
        $limit = $this->getLimit();
        switch ($id) {
            case 2 :
                $conditions = array("LOWER(Ride.wording) LIKE" => "%$keyword%");
                break;
            case 3 :
                $conditions = array("LOWER(DepartureDestination.name) LIKE" => "%$keyword%");
                break;
            case 4 :
                $conditions = array("LOWER(ArrivalDestination.name) LIKE" => "%$keyword%");
                break;

            case 5 :
                $conditions = array("LOWER(Ride.distance) LIKE" => "%$keyword%");
                break;


            default:
                $conditions = array("LOWER(Ride.wording) LIKE" => "%$keyword%");
        }


        $this->paginate = array(

            'conditions' => $conditions,
            'limit'=>$limit,
            'paramType' => 'querystring'
        );


        $this->Ride->recursive = 0;
        $rides = $this->Paginator->paginate();

        $this->set('rides', $rides);


    }



    public function getRidesByKeyWord(){

        $this->autoRender = false;

        // get the search term from URL
        $term = $this->request->query['q'];

        $term = explode('-',$term);
        $term[0] = trim(strtolower(($term[0])));
        if(isset($term[1])){
            $term[1] = trim(strtolower(($term[1])));
        }



        if(count($term)>1){
            $conds = array(
                "CONVERT(DepartureDestination.name USING utf8)  COLLATE utf8_general_ci  LIKE " => "%$term[0]%",
                "CONVERT(ArrivalDestination.name USING utf8)  COLLATE utf8_general_ci LIKE " => "%$term[1]%"

            );
        }else {
            $conds = array(
                'OR' => array(
                    " CONVERT(Ride.wording USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term[0]%",
                    " CONVERT(DepartureDestination.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term[0]%",
                    "CONVERT(ArrivalDestination.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term[0]%",

                )
            );
        }


        $rides = $this->Ride->find('all',array(
            'fields'=>array(
                'Ride.id',
                'DepartureDestination.name',
                'ArrivalDestination.name'
            ),
            'recursive'=>-1,
			'order'=>array(
				'Ride.wording',
				'DepartureDestination.name ASC', 
				'ArrivalDestination.name ASC'),
            'conditions' =>$conds,
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
        ));
		
		
        $data= array();
        $i = 0;
        foreach($rides as $ride){
            $data[$i]['id'] = $ride['Ride']['id'];
            $data[$i]['text'] = $ride['DepartureDestination']['name'].' - '.$ride['ArrivalDestination']['name'];
            $i++;
        }

        echo json_encode($data);
    }


    public function personalTransportDashboard(){
        $destinations = $this->Ride->DepartureDestination->find('all',
            array(
                'recursive'=>-1,
                'fields'=>array('name','lat','lng'),
            ));
        $this->set(compact('destinations'));
    }

    public function breakpointByArrivalId(){
        $this->autoRender = false;


        $destinationId = filter_input(INPUT_POST, "destinationId");
        $sheetRideDetailRide = $this->SheetRideDetailRides->find('first',array(
            'recursive'=>-1,
            'conditions'=>array('SheetRideDetailRides.arrival_destination_id'=>$destinationId),
            'fields'=>array(
                'SheetRideDetailRides.sheet_ride_id',
                'SheetRideDetailRides.id',
                )

        ));
        if(!empty($sheetRideDetailRide)){
            $sheetRideId = $sheetRideDetailRide['SheetRideDetailRides']['sheet_ride_id'];
            $sheetRideDetailRideId = $sheetRideDetailRide['SheetRideDetailRides']['id'];
            $sheetRideDetailRides = $this->SheetRideDetailRides->find('all',array(
                'recursive'=>-1,
                'order'=>array('SheetRideDetailRides.id DESC'),
                'conditions'=>array(
                    'SheetRideDetailRides.sheet_ride_id'=>$sheetRideId,
                    'SheetRideDetailRides.id <='=>$sheetRideDetailRideId,
                    ),
                'fields'=>array(
                    'SheetRideDetailRides.departure_destination_id',
                )
            ));
            $destinationIds = array();
            foreach ($sheetRideDetailRides as $sheetRideDetailRide){
                $destinationIds[] = $sheetRideDetailRide['SheetRideDetailRides']['departure_destination_id'];
            }

            $destinations = $this->Destination->find('all',
                array(
                    'recursive'=>-1,
                    'order'=>array('Destination.id ASC'),
                    'fields'=>array('name','lat','lng','id'),
                    'conditions'=>array('Destination.id'=>$destinationIds)
                ));
        }else {
            $destinations = array();
        }


        $data = array();
        $i = 0;
        foreach ($destinations as $destination) {
            $data[$i][0] = $destination['Destination']['name'];
            $data[$i][1] = $destination['Destination']['lat'] ;
            $data[$i][2] = $destination['Destination']['lng'] ;
            $data[$i][3] = $destination['Destination']['id'] ;
            $i++;
        }

      //  echo json_encode($data);
        echo json_encode(array("response" => true, 'destinations' => $data));

    }
    public function getBreakpointByBetweenClosestMarkerIdAndArrivalId($destinationId=null,$closestMarkerId=null,$sheetRideId=null){

        $this->layout = 'ajax';
        //$this->autoRender = false;
        //$destinationId = filter_input(INPUT_POST, "destinationId");
       // $closestMarkerId = filter_input(INPUT_POST, "closestMarkerId");
        $sheetRideDetailRideArrival = $this->SheetRideDetailRides->find('first',array(
            'recursive'=>-1,
            'conditions'=>array(
                'SheetRideDetailRides.arrival_destination_id'=>$destinationId,
                'SheetRideDetailRides.sheet_ride_id'=>$sheetRideId,
            ),
            'fields'=>array(
                'SheetRideDetailRides.sheet_ride_id',
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.planned_end_date',
                'Destination.name',
            ),
            'joins'=>array(
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Destination',
                    'conditions' => array('Destination.id = SheetRideDetailRides.arrival_destination_id')
                )
                ),

        ));
        $sheetRideDetailRideDeparture = $this->SheetRideDetailRides->find('first',array(
            'recursive'=>-1,
            'conditions'=>array(
                'SheetRideDetailRides.departure_destination_id'=>$closestMarkerId,
                'SheetRideDetailRides.sheet_ride_id'=>$sheetRideId,
            ),
            'fields'=>array(
                'SheetRideDetailRides.sheet_ride_id',
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.planned_start_date',
                'Destination.name',
                'SheetRide.reference',
                ),
                'joins'=>array(
            array(
                'table' => 'destinations',
                'type' => 'left',
                'alias' => 'Destination',
                'conditions' => array('Destination.id = SheetRideDetailRides.departure_destination_id')
            ),
                    array(
                'table' => 'sheet_rides',
                'type' => 'left',
                'alias' => 'SheetRide',
                'conditions' => array('SheetRide.id = SheetRideDetailRides.sheet_ride_id')
            ),
        )

        ));
        if(!empty($sheetRideDetailRideArrival) && !empty($sheetRideDetailRideDeparture)){
            $sheetRideId = $sheetRideDetailRideArrival['SheetRideDetailRides']['sheet_ride_id'];
            $sheetRideDetailRideArrivalId = $sheetRideDetailRideArrival['SheetRideDetailRides']['id'];
            $sheetRideDetailRideDepartureId = $sheetRideDetailRideDeparture['SheetRideDetailRides']['id'];
            $sheetRideDetailRides = $this->SheetRideDetailRides->find('all',array(
                'recursive'=>-1,
                'order'=>array('SheetRideDetailRides.id ASC'),
                'conditions'=>array(
                    'SheetRideDetailRides.sheet_ride_id'=>$sheetRideId,
                    'SheetRideDetailRides.id <='=>$sheetRideDetailRideArrivalId,
                    'SheetRideDetailRides.id >'=>$sheetRideDetailRideDepartureId,
                    ),
                'fields'=>array(
                    'SheetRideDetailRides.departure_destination_id',
                    'SheetRideDetailRides.planned_start_date',
                    'SheetRideDetailRides.planned_end_date',
                    'Destination.name',
                ),
                'joins'=>array(
                    array(
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'Destination',
                        'conditions' => array('Destination.id = SheetRideDetailRides.departure_destination_id')
                    ),
                )
            ));
           /* $destinationIds = array();
            foreach ($sheetRideDetailRides as $sheetRideDetailRide){
                $destinationIds[] = $sheetRideDetailRide['SheetRideDetailRides']['departure_destination_id'];
            }

            $destinations = $this->Destination->find('all',
                array(
                    'recursive'=>-1,
                    'fields'=>array('name','lat','lng','id'),
                    'conditions'=>array('Destination.id'=>$destinationIds)
                ));
            $departureDestination = $this->Destination->find('first',
                array(
                    'recursive'=>-1,
                    'fields'=>array('name','lat','lng','id'),
                    'conditions'=>array('Destination.id'=>$closestMarkerId)
                ));
            $arrivalDestination = $this->Destination->find('first',
                array(
                    'recursive'=>-1,
                    'fields'=>array('name','lat','lng','id'),
                    'conditions'=>array('Destination.id'=>$destinationId)
                ));*/
        }else {
            $destinations = array();
            $departureDestination = array();
            $arrivalDestination = array();
        }


$this->set(compact('destinations','departureDestination','arrivalDestination',
    'sheetRideDetailRideDeparture','sheetRideDetailRideArrival','sheetRideDetailRides'));
       /* $data = array();
        $i = 0;
        foreach ($destinations as $destination) {
            $data[$i][0] = $destination['Destination']['name'];
            $data[$i][1] = $destination['Destination']['lat'] ;
            $data[$i][2] = $destination['Destination']['lng'] ;
            $i++;
        }

      //  echo json_encode($data);
        echo json_encode(array("response" => true, 'destinations' => $data));*/

    }


    public function getSheetRidesByClosestMarkerIdAndArrivalId($destinationId=null,$closestMarkerId=null){

        $this->layout = 'ajax';
        //$this->autoRender = false;
        //$destinationId = filter_input(INPUT_POST, "destinationId");
       // $closestMarkerId = filter_input(INPUT_POST, "closestMarkerId");
        $sheetRideIds = array();


        $currentDate = date('Y-m-d H:i');
        $endDateDay = date('Y-m-d 23:59');

        $sheetRideDetailRideDepartures = $this->SheetRideDetailRides->find('all',array(
            'recursive'=>-1,
            'conditions'=>array(
                'SheetRideDetailRides.departure_destination_id'=>$closestMarkerId,
                'SheetRideDetailRides.planned_start_date >'=>$currentDate,
                'SheetRideDetailRides.planned_start_date <='=>$endDateDay
                ),
            'order'=>array('SheetRideDetailRides.id ASC'),
            'fields'=>array(
                'SheetRideDetailRides.sheet_ride_id',
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.planned_start_date',
                'Destination.name',
                'SheetRide.reference',
                ),
                'joins'=>array(
            array(
                'table' => 'destinations',
                'type' => 'left',
                'alias' => 'Destination',
                'conditions' => array('Destination.id = SheetRideDetailRides.departure_destination_id')
            ),
                    array(
                'table' => 'sheet_rides',
                'type' => 'left',
                'alias' => 'SheetRide',
                'conditions' => array('SheetRide.id = SheetRideDetailRides.sheet_ride_id')
            ),
        )

        ));

        foreach ($sheetRideDetailRideDepartures as $sheetRideDetailRideDeparture){
            $sheetRideIds[]= $sheetRideDetailRideDeparture['SheetRideDetailRides']['sheet_ride_id'];
        }
        $countSheetRideDetailRideDepartures = count($sheetRideDetailRideDepartures);

        $sheetRideDetailRideArrivals = $this->SheetRideDetailRides->find('all',array(
            'recursive'=>-1,
            'conditions'=>array(
                'SheetRideDetailRides.arrival_destination_id'=>$destinationId,
                'SheetRideDetailRides.sheet_ride_id'=>$sheetRideIds
                ),
            'order'=>array('SheetRideDetailRides.id ASC'),
            'fields'=>array(
                'SheetRideDetailRides.sheet_ride_id',
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.planned_end_date',
                'Destination.name',
            ),
            'joins'=>array(
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Destination',
                    'conditions' => array('Destination.id = SheetRideDetailRides.arrival_destination_id')
                )
            ),

        ));
        $countSheetRideDetailRideArrivals = count($sheetRideDetailRideArrivals);
        foreach ($sheetRideDetailRideArrivals as $sheetRideDetailRideArrival){
            // $sheetRideIds[]= $sheetRideDetailRideArrival['SheetRideDetailRides']['sheet_ride_id'];
        }


        $sheetRides =array();
        if(!empty($sheetRideDetailRideArrivals) && !empty($sheetRideDetailRideDepartures)){



            for($i =0 ; $i< $countSheetRideDetailRideDepartures; $i++){

                $sheetRide = $this->SheetRide->find('first',array(
                    'recursive'=>-1,
                    'order'=>array('SheetRide.id ASC', 'SheetRideDetailRideDepartures.id ASC' ),
                    'conditions'=>array(
                        'SheetRideDetailRideDepartures.sheet_ride_id'=>$sheetRideIds[$i],
                        'SheetRideDetailRideArrivals.id '=>$sheetRideDetailRideArrivals[$i]['SheetRideDetailRides']['id'],
                        'SheetRideDetailRideDepartures.id '=>$sheetRideDetailRideDepartures[$i]['SheetRideDetailRides']['id'],
                    ),
                    'fields'=>array(
                        'SheetRideDetailRideDepartures.departure_destination_id',
                        'SheetRideDetailRideDepartures.id',
                        'SheetRideDetailRideArrivals.id',
                        'SheetRideDetailRideDepartures.planned_start_date',
                        'SheetRideDetailRideArrivals.planned_end_date',
                        'DestinationDeparture.name',
                        'DestinationArrival.name',
                        'SheetRide.reference',
                        'SheetRide.id',
                    ),
                    'joins'=>array(

                        array(
                            'table' => 'sheet_ride_detail_rides',
                            'type' => 'left',
                            'alias' => 'SheetRideDetailRideDepartures',
                            'conditions' => array('SheetRide.id = SheetRideDetailRideDepartures.sheet_ride_id')
                        ),  array(
                            'table' => 'sheet_ride_detail_rides',
                            'type' => 'left',
                            'alias' => 'SheetRideDetailRideArrivals',
                            'conditions' => array('SheetRide.id = SheetRideDetailRideArrivals.sheet_ride_id')
                        ),
                        array(
                            'table' => 'destinations',
                            'type' => 'left',
                            'alias' => 'DestinationDeparture',
                            'conditions' => array('DestinationDeparture.id = SheetRideDetailRideDepartures.departure_destination_id')
                        ),
                        array(
                            'table' => 'destinations',
                            'type' => 'left',
                            'alias' => 'DestinationArrival',
                            'conditions' => array('DestinationArrival.id = SheetRideDetailRideArrivals.arrival_destination_id')
                        ),
                    )
                ));

                $sheetRides[$i] = $sheetRide;

            }


           /* $destinationIds = array();
            foreach ($sheetRideDetailRides as $sheetRideDetailRide){
                $destinationIds[] = $sheetRideDetailRide['SheetRideDetailRides']['departure_destination_id'];
            }

            $destinations = $this->Destination->find('all',
                array(
                    'recursive'=>-1,
                    'fields'=>array('name','lat','lng','id'),
                    'conditions'=>array('Destination.id'=>$destinationIds)
                ));
            $departureDestination = $this->Destination->find('first',
                array(
                    'recursive'=>-1,
                    'fields'=>array('name','lat','lng','id'),
                    'conditions'=>array('Destination.id'=>$closestMarkerId)
                ));
            $arrivalDestination = $this->Destination->find('first',
                array(
                    'recursive'=>-1,
                    'fields'=>array('name','lat','lng','id'),
                    'conditions'=>array('Destination.id'=>$destinationId)
                ));*/
        }else {
            $destinations = array();
            $departureDestination = array();
            $arrivalDestination = array();
            $sheetRides = array();
        }


$this->set(compact('destinations','departureDestination','arrivalDestination',
    'sheetRideDetailRideDeparture','sheetRideDetailRideArrival','sheetRideDetailRides','sheetRides'));
       /* $data = array();
        $i = 0;
        foreach ($destinations as $destination) {
            $data[$i][0] = $destination['Destination']['name'];
            $data[$i][1] = $destination['Destination']['lat'] ;
            $data[$i][2] = $destination['Destination']['lng'] ;
            $i++;
        }

      //  echo json_encode($data);
        echo json_encode(array("response" => true, 'destinations' => $data));*/

    }



     function getItinerary($destinationId= null, $locations=null){
       $this->set(compact('destinationId','locations')) ;
    }
}

?>