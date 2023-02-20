<?php
App::uses('AppController', 'Controller');
/**
 * CustomerGroups Controller
 *
 * @property CustomerGroup $CustomerGroup
 * @property Customer $Customer
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class CustomerGroupsController extends AppController {

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
        $result = $this->verifyUserPermission(SectionsEnum::groupe_employe, $user_id, ActionsEnum::view, "CustomerGroups", null, "CustomerGroup" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                $conditions=array('CustomerGroup.user_id '=>$user_id);
                break;
            case 3 :
                $conditions=array('CustomerGroup.user_id !='=>$user_id);
                break;

            default:
                $conditions=null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('CustomerGroup.code' => 'ASC', 'CustomerGroup.name' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );

        $this->CustomerGroup->recursive = 0;
        $this->set('customerGroups', $this->Paginator->paginate());
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
            'order' => array('CustomerGroup.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('CustomerGroups', $this->Paginator->paginate('CustomerGroup', array('OR' => array(
                "LOWER(CustomerGroup.code) LIKE" => "%$keyword%",
                "LOWER(CustomerGroup.name) LIKE" => "%$keyword%"))));
        } else {
            $this->CustomerGroup->recursive = 0;
            $this->set('CustomerGroups', $this->Paginator->paginate());
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
        if (!$this->CustomerGroup->exists($id)) {
            throw new NotFoundException(__('Invalid CustomerGroup'));
        }
        $options = array('conditions' => array('CustomerGroup.' . $this->CustomerGroup->primaryKey => $id));
        $this->set('customerGroup', $this->CustomerGroup->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::groupe_employe, $user_id, ActionsEnum::add, "CustomerGroups", null, "CustomerGroup" ,null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->CustomerGroup->create();
            $this->request->data['CustomerGroup']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->CustomerGroup->save($this->request->data)) {
                $this->Flash->success(__('The CustomerGroup has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The CustomerGroup could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::groupe_employe, $user_id, ActionsEnum::edit, "CustomerGroups", $id, "CustomerGroup" ,null);
        if (!$this->CustomerGroup->exists($id)) {
            throw new NotFoundException(__('Invalid CustomerGroup'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. CustomerGroup cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['CustomerGroup']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->CustomerGroup->save($this->request->data)) {
                $this->Flash->success(__('The CustomerGroup has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The CustomerGroup could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CustomerGroup.' . $this->CustomerGroup->primaryKey => $id));
            $this->request->data = $this->CustomerGroup->find('first', $options);
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
        $this->verifyUserPermission(SectionsEnum::groupe_employe, $user_id, ActionsEnum::delete, "CustomerGroups", $id, "CustomerGroup" ,null);
        $this->CustomerGroup->id = $id;
        if (!$this->CustomerGroup->exists()) {
            throw new NotFoundException(__('Invalid CustomerGroup'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->CustomerGroup->delete()) {
            $this->Flash->success(__('The CustomerGroup has been deleted.'));
        } else {
            $this->Flash->error(__('The CustomerGroup could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }
    public function deleteCustomerGroups() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::groupe_employe, $user_id, ActionsEnum::delete, "CustomerGroups", $id, "CustomerGroup" ,null);

        $this->CustomerGroup->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->CustomerGroup->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }

    }

    private function verifyDependences($id){
        $this->setTimeActif();
        $this->loadModel('Customer');
        $result = $this->Customer->getCustomerByForeignKey($id, 'customer_group_id');
        if (!empty($result)) {
            $this->Flash->error(__('The CustomerGroup could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        
    }
   
}
