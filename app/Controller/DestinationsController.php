<?php

App::uses('AppController', 'Controller');

/**
 * Destination Controller
 *
 * @property Destination $Destination
 * @property Daira $Daira
 * @property Wilaya $Wilaya
 * @property Ride $Ride
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class DestinationsController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    var $helpers = array('Xls');
    public $uses = array('Destination', 'Daira', 'Wilaya', 'Ride');

    public function index()
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::villes_trajet, $user_id, ActionsEnum::view, "Destinations", null, "Destination", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'], $this->params['pass']['2']) : $this->getOrder();

        switch ($result) {
            case 1 :
                $conditions = null;
                break;
            case 2 :
                $conditions = array('Destination.user_id ' => $user_id);
                break;
            case 3 :
                $conditions = array('Destination.user_id !=' => $user_id);
                break;

            default:
                $conditions = null;
        }
        //Parametrer la pagination
        $this->paginate = array(
            'limit' => $limit,
            'order' => $order,
            'conditions' => $conditions,
            'paramType' => 'querystring'
        );
        $this->Destination->recursive = 0;
        $destinations = $this->Paginator->paginate();

        $this->set('destinations', $destinations);
        $this->set(compact('limit', 'order'));
    }

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
                    $order = array('Destination.code' => $orderType);
                    break;
                case 2 :
                    $order = array('Destination.name' => $orderType);
                    break;
                case 3 :
                    $order = array('Destination.daira_id' => $orderType);
                    break;
                case 4 :
                    $order = array('Destination.wilaya_id' => $orderType);
                    break;

                default :
                    $order = array('Destination.code' => $orderType);
            }
            return $order;
        } else {
            $order = array('Destination.code' => $orderType);

            return $order;
        }
    }

    /**
     * index method
     *
     * @return void
     */
    public function search()
    {
        $this->setTimeActif();
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'],
                $this->request->params['action'], $this->request->data['keyword']);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => $order,
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('destinations', $this->Paginator->paginate('Destination', array('OR' => array(
                "LOWER(Destination.code) LIKE" => "%$keyword%",
                "LOWER(Destination.name) LIKE" => "%$keyword%"))));
        } else {
            $conds = array();
            if (isset($this->request->data['Destinations']['date']) && !empty($this->request->data['Destinations']['date'])){
                $start = str_replace("-", "/", $this->params['data']['Destinations']['date']);
                $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                $conds["Destination.modified >= "] = $startdtm->format('Y-m-d 00:00:00');
                $this->request->data['Destinations']['date'] = $start;

            }
            if (isset($this->request->data['Destinations']['next_date']) && !empty($this->request->data['Destinations']['next_date'])){
                $start = str_replace("-", "/", $this->params['data']['Destinations']['next_date']);
                $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                $conds["Destination.modified <= "] = $startdtm->format('Y-m-d 00:00:00');
                $this->request->data['Destinations']['next_date'] = $start;
            }

            $this->Destination->recursive = 0;
            $this->set('destinations', $this->Paginator->paginate('Destination',$conds));
        }
        $this->set(compact('limit', 'order'));
        $this->render();
    }

    private function filterUrl(){
        $filterUrl['date'] = $this->params['data']['date'];
        $filterUrl['next_date'] = $this->params['data']['next_date'];
        $this->redirect($filterUrl);
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
        if (!$this->Destination->exists($id)) {
            throw new NotFoundException(__('Invalid destination'));
        }
        $options = array('conditions' => array('Destination.' . $this->Destination->primaryKey => $id));
        $this->set('destination', $this->Destination->find('first', $options));
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
        $this->verifyUserPermission(SectionsEnum::villes_trajet, $user_id, ActionsEnum::add, "Destinations", null, "Destination", null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Destination->create();
            $this->request->data['Destination']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Destination->save($this->request->data)) {
                $this->Flash->success(__('The destination has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The destination could not be saved. Please, try again.'));
            }
        }
        $wilayas = $this->Wilaya->getWilayaList();
        $this->set(compact('dairas', 'wilayas'));
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
        $this->verifyUserPermission(SectionsEnum::villes_trajet, $user_id, ActionsEnum::edit, "Destinations", $id, "Destination", null);
        if (!$this->Destination->exists($id)) {
            throw new NotFoundException(__('Invalid destination'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Destination cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Destination']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Destination->save($this->request->data)) {
                $this->Flash->success(__('The destination has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The destination could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Destination.' . $this->Destination->primaryKey => $id));
            $this->request->data = $this->Destination->find('first', $options);
            $dairas = $this->Daira->getDairaByWilayaId($this->request->data['Destination']['wilaya_id']);
        }

        $wilayas = $this->Wilaya->getWilayaList();
        $this->set(compact('dairas', 'wilayas'));

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
        $this->verifyUserPermission(SectionsEnum::villes_trajet, $user_id, ActionsEnum::delete, "Destinations", $id, "Destination", null);
        $this->Destination->id = $id;
        if (!$this->Destination->exists()) {
            throw new NotFoundException(__('Invalid destination'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Destination->delete()) {
            $this->Flash->success(__('The destination has been deleted.'));
        } else {
            $this->Flash->error(__('The destination could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $result = $this->Ride->getRideByForeignKey($id, "Ride.departure_destination_id");
        if (!empty($result)) {
            $this->Flash->error(__('The destination could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }

        $result = $this->Ride->getRideByForeignKey($id, "Ride.arrival_destination_id");
        if (!empty($result)) {
            $this->Flash->error(__('The destination could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }

    public function deleteDestinations()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::villes_trajet, $user_id, ActionsEnum::delete, "Destinations", $id, "Destination", null);

        $this->Destination->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Destination->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }

    }

    function export()
    {
        $this->setTimeActif();
        $destinations = $this->Destination->find('all', array(
            'order' => 'Destination.name asc',
            'recursive' => 2
        ));
        $this->set('models', $destinations);
    }

    public function getDairasByWilaya($wilayaId = null)
    {

        $this->layout = 'ajax';
        $dairas = $this->Daira->getDairaByWilayaId($wilayaId);
        $this->set('dairas', $dairas);
    }

    public function import()
    {
        if (!empty($this->request->data['Destination']['file_csv']['tmp_name'])) {

            if (is_uploaded_file($this->request->data['Destination']['file_csv']['tmp_name'])) {
                $fichier = $this->request->data['Destination']['file_csv']['name'];
                $ext = substr(strtolower(strrchr($fichier, '.')), 1);
                if ($ext == 'csv') {
                    if ($fichier) {
                        $fp = fopen($this->request->data['Destination']['file_csv']['tmp_name'], "r");

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
                        $liste[2] = (isset($liste[2])) ? $liste[2] : Null;

                        $villeCode = $liste[0];
                        $villeName = $liste[1];
                        $wilayaName = $liste[2];
                        $dairaName = $liste[3];

                        if ($cpt > 0) {
                            $wilayaId = $this->getWilayaIdByName($wilayaName);

                            $dairaId = $this->getDairaIdByName($dairaName, $wilayaId);

                            if ($wilayaId > 0 && $dairaId > 0) {
                                $this->Destination->create();
                                if (!empty($villeCode)) {
                                    $this->request->data['Destination']['code'] = $villeCode;
                                }
                                $this->request->data['Destination']['name'] = $villeName;
                                $this->request->data['Destination']['wilaya_id'] = $wilayaId;
                                $this->request->data['Destination']['daira_id'] = $dairaId;
                                $this->request->data['Destination']['user_id'] = $this->Session->read('Auth.User.id');
                                $this->Destination->save($this->request->data);
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

    public function getWilayaIdByName($wilayaNameImported)
    {
        $wilayaId = 0;
        $wilayaNameImported = trim($wilayaNameImported);
        $wilayaNameImported = strtolower($wilayaNameImported);
        $wilayas = $this->Wilaya->getWilayaList(array('Wilaya.id, Wilaya.name'), 'all');
        foreach ($wilayas as $wilaya) {
            $wilayaName = strtolower($wilaya['Wilaya']['name']);
            if ($wilayaNameImported == $wilayaName) {
                $wilayaId = $wilaya['Wilaya']['id'];
                return $wilayaId;
            }
        }
        return $wilayaId;
    }

    public function getDairaIdByName($dairaNameImported, $wilayaId)
    {

        $dairaId = 0;
        $dairaNameImported = trim($dairaNameImported);
        $dairaNameImported = strtolower($dairaNameImported);

        $dairas = $this->Daira->getDairaByWilayaId($wilayaId, 'all');
        foreach ($dairas as $daira) {
            $dairaName = strtolower($daira['Daira']['name']);

            if ($dairaNameImported == $dairaName) {
                $dairaId = $daira['Daira']['id'];

                return $dairaId;
            }
        }
        return $dairaId;
    }

    function addWilaya()
    {
        $this->settimeactif();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::wilaya, $user_id, ActionsEnum::add, "Wilayas", null, "Wilaya", null,1);
        $this->set('result',$result);

            $this->layout = 'popup';
            $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
            if (!empty($this->request->data)) {
                $this->Wilaya->create();
                if ($this->Wilaya->save($this->request->data)) {
                    $this->set('saved', true); //only set true if data saves OK
                    $wilaya_id = $this->Wilaya->getLastInsertId();
                    $this->set('wilaya_id', $wilaya_id);
                }
            }

    }

    function getWilayas()
    {
        $this->settimeactif();
        $this->layout = 'ajax';
        $wilayas = $this->Wilaya->getWilayaList(null, 'all');
        $this->set('selectbox', $wilayas);
        $this->set('selectedid', $this->params['pass']['0']);
    }


    function addDaira()
    {
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->request->data['Daira']['wilaya_id'] = $this->params['pass']['0'];
            $this->Daira->create();
            if ($this->Daira->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $daira_id = $this->Daira->getLastInsertId();
                $this->set('daira_id', $daira_id);
                $this->set('wilaya_id', $this->params['pass']['0']);
            }
        }
    }

    function getDairas($wilayaId = null)
    {

        $this->layout = 'ajax';
        if (isset($this->params['pass']['0']) || $wilayaId != null) {
            if ($wilayaId == null) {
                $wilayaId = $this->params['pass']['0'];
            }
            $this->layout = 'ajax';
            $this->set('selectbox', $this->Daira->getDairaByWilayaId($wilayaId));
            if (isset($this->params['pass']['1'])) {
                $this->set('selectedid', $this->params['pass']['1']);
            }
        } else {
            $this->set('selectbox', null);
        }
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
                $conditions = array("LOWER(Destination.code) LIKE" => "%$keyword%");
                break;
            case 3 :
                $conditions = array("LOWER(Destination.name) LIKE" => "%$keyword%");
                break;
            case 4 :
                $conditions = array("LOWER(Daira.name) LIKE" => "%$keyword%");
                break;

            case 5 :
                $conditions = array("LOWER(Wilaya.name) LIKE" => "%$keyword%");
                break;


            default:
                $conditions = array("LOWER(Destination.code) LIKE" => "%$keyword%");
        }


        $this->paginate = array(

            'conditions' => $conditions,
            'limit'=>$limit,
            'paramType' => 'querystring'
        );
        $this->Destination->recursive = 0;
        $destinations = $this->Paginator->paginate();

        $this->set('destinations', $destinations);


    }

    /**
     * retourner une destination à partir d'un mot clé
     */
    public function getDestinationsByKeyWord()
    {
        $this->autoRender = false;
        $term = $this->request->query['q'];
        $term = trim(strtolower(($term)));
            $conds = array(
                    " CONVERT(Destination.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term%",
            );
        $destinations = $this->Destination->getDestinationsByConditions($conds, 'all');
        $data = array();
        $i = 0;
        $data[$i]['id'] = "";
        $data[$i]['text'] = "";
        $i++;
        foreach ($destinations as $destination) {
            $data[$i]['id'] = $destination['Destination']['id'];
            $data[$i]['text'] = $destination['Destination']['name'] ;
            $i++;
        }

        echo json_encode($data);
    }


}
