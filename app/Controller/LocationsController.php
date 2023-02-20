<?php
App::uses('AppController', 'Controller');
/**
 * Locations Controller
 *
 * @property Location $Location
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class LocationsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
	public $components = array('Paginator', 'Session','Security');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
         $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $result =  $this->verifyUserPermission(SectionsEnum::emplacement_pneu, $user_id, ActionsEnum::view,
            "Locations", null, "Location",null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                $conditions=array('Location.user_id '=>$user_id);
                break;
            case 3 :
                $conditions=array('Location.user_id !='=>$user_id);
                break;

            default:
                $conditions=null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Location.code' => 'ASC', 'Location.name' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );


        $this->Location->recursive = 0;
        $this->set('locations', $this->Paginator->paginate());
        $this->set(compact('limit'));
    }

    public function search() {
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'],
                $this->request->params['action'], $this->request->data['keyword']);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Location.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('locations', $this->Paginator->paginate('Location', array('OR' => array(
                "LOWER(Location.code) LIKE" => "%$keyword%",
                "LOWER(Location.name) LIKE" => "%$keyword%"))));
        } else {
            $this->Location->recursive = 0;
            $this->set('locations', $this->Paginator->paginate());
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
        if (!$this->Location->exists($id)) {
            throw new NotFoundException(__('Invalid location'));
        }
        $options = array('conditions' => array('Location.' . $this->Location->primaryKey => $id));
        $this->set('location', $this->Location->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::emplacement_pneu, $user_id, ActionsEnum::add, "Locations", null,
            "Location" ,null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->Location->create();
            $this->request->data['Location']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Location->save($this->request->data)) {
                $this->Flash->success(__('The location has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The location could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::emplacement_pneu, $user_id, ActionsEnum::edit, "Locations", $id,
            "Location" ,null);
        if (!$this->Location->exists($id)) {
            throw new NotFoundException(__('Invalid Location'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Location cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Location']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Location->save($this->request->data)) {
                $this->Flash->success(__('The location has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The location could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Location.' . $this->Location->primaryKey => $id));
            $this->request->data = $this->Location->find('first', $options);
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
        $this->verifyUserPermission(SectionsEnum::emplacement_pneu, $user_id, ActionsEnum::delete, "Locations", $id,
            "Location" ,null);
        $this->Location->id = $id;
        if (!$this->Location->exists()) {
            throw new NotFoundException(__('Invalid Location'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Location->delete()) {
            $this->Flash->success(__('The location has been deleted.'));
        } else {
            $this->Flash->error(__('The location could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }
    public function deletelocations() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::emplacement_pneu, $user_id, ActionsEnum::delete, "Locations", $id,
            "Location" ,null);

        $this->Location->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->Location->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }

    }

    private function verifyDependences($id){
        $this->setTimeActif();
        $result = $this->Location->Shifting->find('first', array("conditions" => array("Location.id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The location could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        
    }
   
}
