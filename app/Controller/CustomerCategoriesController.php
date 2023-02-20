<?php

App::uses('AppController', 'Controller');

/**
 * CustomerCategories Controller
 *
 * @property CustomerCategory $CustomerCategory
 * @property Customer $Customer
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class CustomerCategoriesController extends AppController {
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
        $result = $this->verifyUserPermission(SectionsEnum::categorie_employee, $user_id, ActionsEnum::view, "CustomerCategories", null, "CustomerCategory" ,null);

        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                $conditions=array('CustomerCategory.user_id '=>$user_id);
                break;
            case 3 :
                $conditions=array('CustomerCategory.user_id !='=>$user_id);
                break;

            default:
                $conditions=null;
        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('CustomerCategory.code' => 'ASC', 'CustomerCategory.name' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );



        //Parametrer la pagination

        $this->CustomerCategory->recursive = 0;
        $this->set('customerCategories', $this->Paginator->paginate());
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
            'order' => array('CustomerCategory.code' => 'ASC', 'CustomerCategory.name' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('customerCategories', $this->Paginator->paginate('CustomerCategory', array('OR' => array(
                            "LOWER(CustomerCategory.code) LIKE" => "%$keyword%",
                            "LOWER(CustomerCategory.name) LIKE" => "%$keyword%"))));
        } else {
            $this->CustomerCategory->recursive = 0;
            $this->set('customerCategories', $this->Paginator->paginate());
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

        if (!$this->CustomerCategory->exists($id)) {
            throw new NotFoundException(__('Invalid customer category'));
        }
        $options = array('conditions' => array('CustomerCategory.' . $this->CustomerCategory->primaryKey => $id));
        $this->set('customerCategory', $this->CustomerCategory->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::categorie_employee, $user_id, ActionsEnum::add, "CustomerCategories", null, "CustomerCategory" ,null);

        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->CustomerCategory->create();
            $this->request->data['CustomerCategory']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->CustomerCategory->save($this->request->data)) {

                $this->Flash->success(__('The customer category has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The customer category could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::categorie_employee, $user_id, ActionsEnum::edit, "CustomerCategories", $id, "CustomerCategory" ,null);
        if (!$this->CustomerCategory->exists($id)) {
            throw new NotFoundException(__('Invalid customer category'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Customer Category cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['CustomerCategory']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->CustomerCategory->save($this->request->data)) {

                $this->Flash->success(__('The customer category has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The customer category could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CustomerCategory.' . $this->CustomerCategory->primaryKey => $id));
            $this->request->data = $this->CustomerCategory->find('first', $options);

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
        $this->verifyUserPermission(SectionsEnum::categorie_employee, $user_id, ActionsEnum::delete, "CustomerCategories", $id, "CustomerCategory" ,null);
        $this->CustomerCategory->id = $id;
        if (!$this->CustomerCategory->exists()) {
            throw new NotFoundException(__('Invalid customer category'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->CustomerCategory->delete()) {

            $this->Flash->success(__('The customer category has been deleted.'));
        } else {

            $this->Flash->error(__('The customer category could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deletecategories() {
        $this->setTimeActif();
        $this->autoRender = false;
            $id = filter_input(INPUT_POST, "id");
            $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::categorie_employee, $user_id, ActionsEnum::delete, "CustomerCategories", $id, "CustomerCategory" ,null);
            $this->CustomerCategory->id = $id;
            $this->verifyDependences($id);
            $this->request->allowMethod('post', 'delete');
            if($this->CustomerCategory->delete()){
                echo json_encode(array("response" => "true"));
            }else{
                echo json_encode(array("response" => "false"));
            }
        /*}else{
            echo json_encode(array("response" => "false"));
        }*/
    }
    private function verifyDependences($id){
        $this->setTimeActif();
        $this->loadModel('Customer');
        $result = $this->Customer->getCustomerByForeignKey($id, 'customer_category_id');
        if (!empty($result)) {
            $this->Flash->error(__('The customer category could not be deleted. '
                . 'Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        } 
    }

}
