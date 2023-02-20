<?php

App::uses('AppController', 'Controller');

/**
 * Zones Controller
 *
 * @property Zone $Zone
 * @property CustomerCar $CustomerCar
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class ZonesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
var $helpers = array('Xls');
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::zone_affectation, $user_id, ActionsEnum::view,
            "Zones", null, "Zone" , null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                    $conditions=array('Zone.user_id '=>$user_id);
                break;
            case 3 :
                    $conditions=array('Zone.user_id !='=>$user_id);
                break;

            default:
                $conditions=null;
        }
        //Parametrer la pagination
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Zone.code' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );
        $this->Zone->recursive = 0;
        $this->set('zones', $this->Paginator->paginate());
        $this->set(compact('limit'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function search() {
        $this->setTimeActif();
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'], 
                    $this->request->params['action'], $this->request->data['keyword']);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Zone.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('zones', $this->Paginator->paginate('Zone', array('OR' => array(
                            "LOWER(Zone.code) LIKE" => "%$keyword%",
                            "LOWER(Zone.name) LIKE" => "%$keyword%"))));
        } else {
            $this->Zone->recursive = 0;
            $this->set('zones', $this->Paginator->paginate());
        }
        $this->set(compact('limit'));
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
        if (!$this->Zone->exists($id)) {
            throw new NotFoundException(__('Invalid zone'));
        }
        $options = array('conditions' => array('Zone.' . $this->Zone->primaryKey => $id));
        $this->set('zone', $this->Zone->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::zone_affectation, $user_id, ActionsEnum::add,
            "Zones", null, "Zone" , null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Zone->create();
            $this->request->data['Zone']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Zone->save($this->request->data)) {
                $this->Flash->success(__('The zone has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The zone could not be saved. Please, try again.'));
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
    public function edit($id = null) {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::zone_affectation, $user_id, ActionsEnum::edit,
            "Zones", $id, "Zone" , null);
        if (!$this->Zone->exists($id)) {
            throw new NotFoundException(__('Invalid zone'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. zone cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Zone']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Zone->save($this->request->data)) {
                $this->Flash->success(__('The zone has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The zone could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Zone.' . $this->Zone->primaryKey => $id));
            $this->request->data = $this->Zone->find('first', $options);
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::zone_affectation, $user_id, ActionsEnum::delete,
            "Zones", $id, "Zone" , null);
        $this->Zone->id = $id;
        if (!$this->Zone->exists()) {
            throw new NotFoundException(__('Invalid zone'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Zone->delete()) {
                $this->Flash->success(__('The zone has been deleted.'));
        } else {
                $this->Flash->error(__('The zone could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteZones() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::zone_affectation, $user_id, ActionsEnum::delete,
            "Zones", $id, "Zone" , null);
            $this->Zone->id = $id;
            $this->verifyDependences($id);
            $this->request->allowMethod('post', 'delete');
            if($this->Zone->delete()){
                echo json_encode(array("response" => "true"));
            }else{
                echo json_encode(array("response" => "false"));
            }
    }
    private function verifyDependences($id){
        $this->setTimeActif();
        $this->loadModel('CustomerCar');
        $result = $this->CustomerCar->getCustomerCarByForeignKey($id, "zone_id");
        if (!empty($result)) {
            $this->Flash->error(__('The zone could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        } 
    }

}