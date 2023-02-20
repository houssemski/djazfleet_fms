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
class FuelsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session','Security');
    var $helpers = array('Xls');
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::carburant, $user_id, ActionsEnum::view, "Fuels", null,
            "Fuel",null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        switch($result) {
            case 1 :
                $conditions = 'Fuel.id != 0';
                break;
            case 2 :
                    $conditions=array('Fuel.user_id '=>$user_id, 'Fuel.id !=' => 0);

                break;
            case 3 :
                    $conditions=array('Fuel.user_id !='=>$user_id, 'Fuel.id !=' => 0);
                break;
            default:
                $conditions = 'Fuel.id != 0';
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Fuel.code' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );

        $this->Fuel->recursive = 0;
        $this->set('fuels', $this->Paginator->paginate());
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
            'order' => array('Fuel.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('fuels', $this->Paginator->paginate('Fuel', array('OR' => array(
                            "LOWER(Fuel.code) LIKE" => "%$keyword%",
                            "LOWER(Fuel.name) LIKE" => "%$keyword%"), 'AND' => array("Fuel.id !=" => 0))));
        } else {
            $this->Fuel->recursive = 0;
            $this->set('fuels', $this->Paginator->paginate('Fuel', array("Fuel.id !=" => 0)));
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
        if (!$this->Fuel->exists($id)) {
            throw new NotFoundException(__('Invalid fuel'));
        }
        $options = array('conditions' => array('Fuel.' . $this->Fuel->primaryKey => $id));
        $this->set('fuel', $this->Fuel->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::carburant, $user_id, ActionsEnum::add, "Fuels", null, "Fuel" ,null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->Fuel->create();
            $this->request->data['Fuel']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Fuel->save($this->request->data)) {
                $this->Flash->success(__('The fuel has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The fuel could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::carburant, $user_id, ActionsEnum::edit, "Fuels", $id, "Fuel" ,null);
        if (!$this->Fuel->exists($id)) {
            throw new NotFoundException(__('Invalid fuel'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Fuel cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Fuel']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Fuel->save($this->request->data)) {
                $this->Flash->success(__('The fuel has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The fuel could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Fuel.' . $this->Fuel->primaryKey => $id));
            $this->request->data = $this->Fuel->find('first', $options);
            //$this->is_opened("Fuel",'Fuels','fuel',$id);
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
        $this->verifyUserPermission(SectionsEnum::carburant, $user_id, ActionsEnum::delete, "Fuels", $id, "Fuel" ,null);
        $this->Fuel->id = $id;
        if (!$this->Fuel->exists()) {
            throw new NotFoundException(__('Invalid fuel'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Fuel->delete()) {
                $this->Flash->success(__('The fuel has been deleted.'));
        } else {
                $this->Flash->error(__('The fuel could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }
    public function deletefuels() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
            $this->Fuel->id = $id;
            $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::carburant, $user_id, ActionsEnum::delete, "Fuels", $id, "Fuel" ,null);
            $this->verifyDependences($id);
            $this->request->allowMethod('post', 'delete');
            if($this->Fuel->delete()){
                echo json_encode(array("response" => "true"));
            }else{
                echo json_encode(array("response" => "false"));
            }

    }
    
    private function verifyDependences($id){
        $this->setTimeActif();
        $result = $this->Car->getCarByForeignKey($id, 'fuel_id');
        if (!empty($result)) {
            $this->Flash->error(__('The fuel could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        } 
    }

}
