<?php

App::uses('AppController', 'Controller');

/**
 * CarCategories Controller
 *
 * @property CarCategory $CarCategory
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class CarCategoriesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Security');
    var $helpers = array('Xls');
    public function beforeFilter() {
        parent::beforeFilter();
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::categorie_vehicule, $user_id, ActionsEnum::view, "CarCategories", null, "CarCategory" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        switch($result) {
            case 1 :


                $conditions=null;

                break;
            case 2 :

                    $conditions=array('CarCategory.user_id '=>$user_id);

                break;
            case 3 :
                
                    $conditions=array('CarCategory.user_id !='=>$user_id);

                break;
            default:
                $conditions=null;


        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('CarCategory.code' => 'ASC'),
            'CarCategory.name' => 'ASC',
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );

        $this->CarCategory->recursive = 0;
        $this->set('carCategories', $this->Paginator->paginate());
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
            'order' => array('CarCategory.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('carCategories', $this->Paginator->paginate('CarCategory', array('OR' => array(
                            "LOWER(CarCategory.code) LIKE" => "%$keyword%",
                            "LOWER(CarCategory.name) LIKE" => "%$keyword%"))));
        } else {
            $this->CarCategory->recursive = 0;
            $this->set('carCategories', $this->Paginator->paginate());
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
        if (!$this->CarCategory->exists($id)) {
            throw new NotFoundException(__('Invalid car category'));
        }
        $options = array('conditions' => array('CarCategory.' . $this->CarCategory->primaryKey => $id));
        $this->set('carCategory', $this->CarCategory->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::categorie_vehicule, $user_id, ActionsEnum::add, "CarCategories", null, "CarCategory" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->CarCategory->create();
            $this->request->data['CarCategory']['user_id'] = $this->Session->read('Auth.User.id');

             unlink('./attachments/events/12507125_1688681898071856_1697416636133022940_n.jpg');

            if ($this->CarCategory->save($this->request->data)) {
                $this->Flash->success(__('The car category has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The car category could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::categorie_vehicule, $user_id, ActionsEnum::edit, "CarCategories", $id, "CarCategory" ,null);
        if (!$this->CarCategory->exists($id)) {
            throw new NotFoundException(__('Invalid car category'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['CarCategory']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($id!=1 && $id!=2 && $id!=3 && $this->CarCategory->save($this->request->data)) {
                $this->Flash->success(__('The car category has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The car category could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CarCategory.' . $this->CarCategory->primaryKey => $id));
            $this->request->data = $this->CarCategory->find('first', $options);
              //$this->is_opened("CarCategory",'CarCategories','car category',$id);
        
       
    
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
        $this->verifyUserPermission(SectionsEnum::categorie_vehicule, $user_id, ActionsEnum::delete, "CarCategories", $id, "CarCategory" ,null);
        $this->CarCategory->id = $id;
        if (!$this->CarCategory->exists()) {
            throw new NotFoundException(__('Invalid car category'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($id!=1 && $id!=2 && $id!=3 &&  $this->CarCategory->delete()) {
                $this->Flash->success(__('The car category has been deleted.'));
        } else {
            $this->Flash->error(__('The car category could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }
    
    public function deletecategories() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::categorie_vehicule, $user_id, ActionsEnum::delete, "CarCategories", $id, "CarCategory" ,null);
            $this->CarCategory->id = $id;
            $this->verifyDependences($id);
            $this->request->allowMethod('post', 'delete');
            if($id!=3 && $this->CarCategory->delete()){
                echo json_encode(array("response" => "true"));
            }else{
                echo json_encode(array("response" => "false"));
            }

    }
    
    private function verifyDependences($id){
        $this->setTimeActif();
        $result = $this->CarCategory->Car->find('first', array("conditions" => array("CarCategory.id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The car category could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        } 
    }

}
