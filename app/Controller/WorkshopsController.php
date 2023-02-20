<?php

App::uses('AppController', 'Controller');

/**
 * Workshop Controller
 *
 * @property Workshop $Workshop
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class WorkshopsController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    var $helpers = array('Xls');
    public $uses = array('Workshop');

    public function index()
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::atelier, $user_id, ActionsEnum::view,
            "Workshops", null, "Workshop", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'], $this->params['pass']['2']) : $this->getOrder();

        switch ($result) {
            case 1 :
                $conditions = null;
                break;
            case 2 :
                $conditions = array('Workshop.user_id ' => $user_id);
                break;
            case 3 :
                $conditions = array('Workshop.user_id !=' => $user_id);
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
        $this->Workshop->recursive = 0;
        $workshops = $this->Paginator->paginate();

        $this->set('workshops', $workshops);
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
                    $order = array('Workshop.code' => $orderType);
                    break;
                case 2 :
                    $order = array('Workshop.name' => $orderType);
                    break;
                    break;

                default :
                    $order = array('Workshop.code' => $orderType);
            }
            return $order;
        } else {
            $order = array('Workshop.code' => $orderType);

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
            $this->set('workshops', $this->Paginator->paginate('Workshop', array('OR' => array(
                "LOWER(Workshop.code) LIKE" => "%$keyword%",
                "LOWER(Workshop.name) LIKE" => "%$keyword%"))));
        } else {
            $this->Workshop->recursive = 0;
            $this->set('destinations', $this->Paginator->paginate());
        }
        $this->set(compact('limit', 'order'));
        $this->render();
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
        if (!$this->Workshop->exists($id)) {
            throw new NotFoundException(__('Invalid workshop'));
        }
        $options = array('conditions' => array('Workshop.' . $this->Workshop->primaryKey => $id));
        $this->set('workshop', $this->Workshop->find('first', $options));
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
        $this->verifyUserPermission(SectionsEnum::atelier, $user_id, ActionsEnum::add,
            "Workshops", null, "Workshop", null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Workshop->create();
            $this->request->data['Workshop']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Workshop->save($this->request->data)) {
                $this->Flash->success(__('The workshop has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The workshop could not be saved. Please, try again.'));
            }
        }
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
        $this->verifyUserPermission(SectionsEnum::atelier, $user_id, ActionsEnum::edit,
            "Workshops", $id, "Workshop", null);
        if (!$this->Workshop->exists($id)) {
            throw new NotFoundException(__('Invalid workshop'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Workshop cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Workshop']['modified_id'] = $this->Session->read('Auth.User.id');
            if ($this->Workshop->save($this->request->data)) {
                $this->Flash->success(__('The workshop has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The workshop could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Workshop.' . $this->Workshop->primaryKey => $id));
            $this->request->data = $this->Workshop->find('first', $options);
        }


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
        $this->verifyUserPermission(SectionsEnum::atelier, $user_id,
            ActionsEnum::delete, "Workshops", $id, "Workshop", null);
        $this->Workshop->id = $id;
        if (!$this->Workshop->exists()) {
            throw new NotFoundException(__('Invalid workshop'));
        }
        //$this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Workshop->delete()) {
            $this->Flash->success(__('The workshop has been deleted.'));
        } else {
            $this->Flash->error(__('The workshop could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $result = $this->Ride->getRideByForeignKey($id, "Ride.departure_destination_id");
        if (!empty($result)) {
            $this->Flash->error(__('The workshop could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }

        $result = $this->Ride->getRideByForeignKey($id, "Ride.arrival_destination_id");
        if (!empty($result)) {
            $this->Flash->error(__('The workshop could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }

    public function deleteWorkshops()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::atelier, $user_id,
            ActionsEnum::delete, "Workshops", $id, "Workshop", null);

        $this->Workshop->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Workshop->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }

    }

    function export()
    {
        $this->setTimeActif();
        $destinations = $this->Workshop->find('all', array(
            'order' => 'Workshop.name asc',
            'recursive' => 2
        ));
        $this->set('models', $destinations);
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





    public function liste($id = null, $keyword = null)
    {
        $keyword = str_replace('espace', ' ', $keyword);
        $keyword = str_replace('slash', '/', $keyword);
        $keyword = strtolower($keyword);
        $this->layout = 'ajax';
        $limit = $this->getLimit();
        switch ($id) {
            case 2 :
                $conditions = array("LOWER(Workshop.code) LIKE" => "%$keyword%");
                break;
            case 3 :
                $conditions = array("LOWER(Workshop.name) LIKE" => "%$keyword%");
                break;


            default:
                $conditions = array("LOWER(Workshop.code) LIKE" => "%$keyword%");
        }


        $this->paginate = array(

            'conditions' => $conditions,
            'limit'=>$limit,
            'paramType' => 'querystring'
        );
        $this->Workshop->recursive = 0;
        $workshops = $this->Paginator->paginate();

        $this->set('workshops', $workshops);


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
