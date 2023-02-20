<?php

App::uses('AppController', 'Controller');

/**
 * PriceCategories Controller
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
class PriceCategoriesController extends AppController {
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
        $result = $this->verifyUserPermission(SectionsEnum::categorie_prix, $user_id, ActionsEnum::view, "PriceCategories", null, "PriceCategory" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                $conditions=array('PriceCategory.user_id '=>$user_id);
                break;
            case 3 :
                $conditions=array('PriceCategory.user_id !='=>$user_id);
                break;

            default:
                $conditions=null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('PriceCategory.code' => 'ASC', 'PriceCategory.name' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );
        //Parametrer la pagination

        $this->PriceCategory->recursive = 0;
        $this->set('priceCategories', $this->Paginator->paginate());
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
            'order' => array('PriceCategory.code' => 'ASC', 'PriceCategory.name' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('priceCategories', $this->Paginator->paginate('PriceCategory', array('OR' => array(
                "LOWER(PriceCategory.code) LIKE" => "%$keyword%",
                "LOWER(PriceCategory.name) LIKE" => "%$keyword%"))));
        } else {
            $this->PriceCategory->recursive = 0;
            $this->set('priceCategories', $this->Paginator->paginate());
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

        if (!$this->PriceCategory->exists($id)) {
            throw new NotFoundException(__('Invalid tariff'));
        }
        $options = array('conditions' => array('PriceCategory.' . $this->PriceCategory->primaryKey => $id));
        $this->set('priceCategory', $this->PriceCategory->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::categorie_prix, $user_id, ActionsEnum::add, "PriceCategories", null, "PriceCategory" ,null);

        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->PriceCategory->create();
            $this->request->data['PriceCategory']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->PriceCategory->save($this->request->data)) {

                $this->Flash->success(__('The tariff has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The tariff could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::categorie_prix, $user_id, ActionsEnum::edit, "PriceCategories", $id, "PriceCategory" ,null);
        if (!$this->PriceCategory->exists($id)) {
            throw new NotFoundException(__('Invalid tariff'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Tariff cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['PriceCategory']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->PriceCategory->save($this->request->data)) {

                $this->Flash->success(__('The tariff has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The tariff could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('PriceCategory.' . $this->PriceCategory->primaryKey => $id));
            $this->request->data = $this->PriceCategory->find('first', $options);



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
        $this->verifyUserPermission(SectionsEnum::categorie_prix, $user_id, ActionsEnum::delete, "PriceCategories", $id, "PriceCategory" ,null);
        $this->PriceCategory->id = $id;
        if (!$this->PriceCategory->exists()) {
            throw new NotFoundException(__('Invalid tariff'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->PriceCategory->delete()) {

            $this->Flash->success(__('The tariff has been deleted.'));
        } else {

            $this->Flash->error(__('The tariff could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteCategories() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::categorie_prix, $user_id, ActionsEnum::delete, "PriceCategories", $id, "PriceCategory" ,null);
        $this->PriceCategory->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->PriceCategory->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }

    }
    private function verifyDependences($id){
        $this->setTimeActif();
        $this->loadModel('Product');
        $result = $this->Product->getProductByForeignKey($id, 'price_category_id');
        if (!empty($result)) {
            $this->Flash->error(__('The tariff could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }

}
