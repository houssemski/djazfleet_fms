<?php
App::uses('AppController', 'Controller');
/**
 * CustomerGroups Controller
 *
 * @property CarGroup $CustomerGroup
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CarGroupsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
	public $components = array('Paginator', 'Session','Security');
    public $uses = array('Car','CarGroup');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
         $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $result=$this->verifyUserPermission(SectionsEnum::groupe_vehicule, $user_id, ActionsEnum::view, "CarGroups", null, "CarGroup" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                $conditions=array('CarGroup.user_id '=>$user_id);
                break;
            case 3 :
                $conditions=array('CarGroup.user_id !='=>$user_id);
                break;

            default:
                $conditions=null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('CarGroup.code' => 'ASC', 'CarGroup.name' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );


        $this->CarGroup->recursive = 0;
        $this->set('carGroups', $this->Paginator->paginate('CarGroup'));
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
            'order' => array('CarGroup.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('carGroups', $this->Paginator->paginate('CarGroup', array('OR' => array(
                "LOWER(CarGroup.code) LIKE" => "%$keyword%",
                "LOWER(CarGroup.name) LIKE" => "%$keyword%"))));
        } else {
            $this->CarGroup->recursive = 0;
            $this->set('carGroups', $this->Paginator->paginate());
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
        if (!$this->CarGroup->exists($id)) {
            throw new NotFoundException(__('Invalid CarGroup'));
        }
        $options = array('conditions' => array('CarGroup.' . $this->CarGroup->primaryKey => $id));
        $this->set('carGroup', $this->CarGroup->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::groupe_vehicule, $user_id, ActionsEnum::add, "CarGroups", null, "CarGroup" ,null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->CarGroup->create();
            $this->request->data['CarGroup']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->CarGroup->save($this->request->data)) {
                $this->Flash->success(__('The Group has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The Group could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::groupe_vehicule, $user_id, ActionsEnum::edit, "CarGroups", $id, "CarGroup" ,null);
        if (!$this->CarGroup->exists($id)) {
            throw new NotFoundException(__('Invalid Group'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Group cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['CarGroup']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->CarGroup->save($this->request->data)) {
                $this->Flash->success(__('The Group has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The Group could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CarGroup.' . $this->CarGroup->primaryKey => $id));
            $this->request->data = $this->CarGroup->find('first', $options);
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
        $this->verifyUserPermission(SectionsEnum::groupe_vehicule, $user_id, ActionsEnum::delete, "CarGroups", $id, "CarGroup" ,null);
        $this->CarGroup->id = $id;
        if (!$this->CarGroup->exists()) {
            throw new NotFoundException(__('Invalid Group'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->CarGroup->delete()) {
            $this->Flash->success(__('The Group has been deleted.'));
        } else {
            $this->Flash->error(__('The Group could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }
    public function deleteCarGroups() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::groupe_vehicule, $user_id, ActionsEnum::delete, "CarGroups", $id, "CarGroup" ,null);

        $this->CarGroup->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->CarGroup->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }

    }

    private function verifyDependences($id){
        $this->setTimeActif();

        $result = $this->Car->find('first', array("conditions" => array("Car.car_group_id" => $id)));

        if (!empty($result)) {
            $this->Flash->error(__('The Group could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        
    }
   
}
