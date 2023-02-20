<?php

App::uses('AppController', 'Controller');

/**
 * Fuels Controller
 *
 * @property Fuel $Fuel
 * @property Car $Car
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class TanksController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session','Security');
    var $helpers = array('Xls');
    public $uses = array('Tank','Fuel','Consumption','TankOperation');
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::citerne, $user_id, ActionsEnum::view, "Tanks", null,
            "Tank",null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        switch($result) {
            case 1 :
                $conditions = 'Tank.id != 0';
                break;
            case 2 :
                $conditions=array('Tank.user_id '=>$user_id, 'Tank.id !=' => 0);

                break;
            case 3 :
                $conditions=array('Tank.user_id !='=>$user_id, 'Tank.id !=' => 0);
                break;
            default:
                $conditions = 'Tank.id != 0';
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Tank.code' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );

        $this->Tank->recursive = 0;
        $this->set('tanks', $this->Paginator->paginate());
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
            'order' => array('Tank.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('tanks', $this->Paginator->paginate('Tank', array('OR' => array(
                "LOWER(Tank.code) LIKE" => "%$keyword%",
                "LOWER(Tank.name) LIKE" => "%$keyword%"), 'AND' => array("Tank.id !=" => 0))));
        } else {
            $this->Tank->recursive = 0;
            $this->set('tanks', $this->Paginator->paginate('Tank', array("Tank.id !=" => 0)));
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
        if (!$this->Tank->exists($id)) {
            throw new NotFoundException(__('Invalid tank'));
        }
        $options = array('conditions' => array('Tank.' . $this->Tank->primaryKey => $id));
        $this->set('tank', $this->Tank->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::citerne, $user_id, ActionsEnum::add, "Tanks", null, "Tank" ,null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->Tank->create();
            $this->request->data['Tank']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Tank->save($this->request->data)) {
                $this->Flash->success(__('The tank has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The tank could not be saved. Please, try again.'));
            }
        }
        $fuels = $this->Fuel->getFuels('list');
        $this->set(compact('fuels'));
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
        $this->verifyUserPermission(SectionsEnum::citerne, $user_id, ActionsEnum::edit, "Tanks", $id, "Tank" ,null);
        if (!$this->Tank->exists($id)) {
            throw new NotFoundException(__('Invalid tank'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Tank cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Tank']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Tank->save($this->request->data)) {
                $this->Flash->success(__('The tank has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The tank could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Tank.' . $this->Tank->primaryKey => $id));
            $this->request->data = $this->Tank->find('first', $options);
            $fuels = $this->Fuel->getFuels('list');
            $this->set(compact('fuels'));
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
        $this->verifyUserPermission(SectionsEnum::citerne, $user_id, ActionsEnum::delete, "Tanks", $id, "Tank" ,null);
        $this->Tank->id = $id;
        if (!$this->Tank->exists()) {
            throw new NotFoundException(__('Invalid tank'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Tank->delete()) {
            $this->Flash->success(__('The tank has been deleted.'));
        } else {
            $this->Flash->error(__('The tank could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }
    public function deletetanks() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $this->Tank->id = $id;
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::citerne, $user_id, ActionsEnum::delete, "Tanks", $id, "Tank" ,null);
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->Tank->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }

    }

    private function verifyDependences($id){
        $this->setTimeActif();
        $result = $this->Consumption->getConsumptionByForeignKey($id, 'tank_id');
        if (!empty($result)) {
            $this->Flash->error(__('The tank could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        $result = $this->TankOperation->getTankOperationByForeignKey($id, 'tank_id');
        if (!empty($result)) {
            $this->Flash->error(__('The tank could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }

}
