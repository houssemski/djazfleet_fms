<?php

App::uses('AppController', 'Controller');
class ProductCategoriesController extends AppController {


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
        $result = $this->verifyUserPermission(SectionsEnum::categorie_produit, $user_id, ActionsEnum::view,
            "ProductCategories", null, "ProductCategory" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :

                $conditions=null;


                break;
            case 2 :


                    $conditions=array('ProductCategory.user_id '=>$user_id);

                break;
            case 3 :

                    $conditions=array('ProductCategory.user_id !='=>$user_id);

                break;

            default:
                $conditions=null;


        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('ProductCategory.code' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );



        //Parametrer la pagination

        $this->ProductCategory->recursive = 0;
        $this->set('productCategories', $this->Paginator->paginate());
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
            'order' => array('ProductCategory.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('productCategories', $this->Paginator->paginate('ProductCategory', array('OR' => array(
                            "LOWER(ProductCategory.code) LIKE" => "%$keyword%",
                            "LOWER(ProductCategory.name) LIKE" => "%$keyword%"))));
        } else {
            $this->ProductCategory->recursive = 0;
            $this->set('productCategories', $this->Paginator->paginate());
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

        if (!$this->ProductCategory->exists($id)) {
            throw new NotFoundException(__('Invalid product category'));
        }
        $options = array('conditions' => array('ProductCategory.' . $this->ProductCategory->primaryKey => $id));
        $this->set('productCategory', $this->ProductCategory->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::categorie_produit, $user_id, ActionsEnum::add, "ProductCategories",
            null, "ProductCategory" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->ProductCategory->create();
            $this->request->data['ProductCategory']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->ProductCategory->save($this->request->data)) {

                $this->Flash->success(__('The product category has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The product category could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::categorie_produit, $user_id, ActionsEnum::edit,
            "ProductCategories", $id, "ProductCategory" ,null);
        if (!$this->ProductCategory->exists($id)) {
            throw new NotFoundException(__('Invalid product category'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Product category cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['ProductCategory']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->ProductCategory->save($this->request->data)) {

                $this->Flash->success(__('The product category has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The product category could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ProductCategory.' . $this->ProductCategory->primaryKey => $id));
            $this->request->data = $this->ProductCategory->find('first', $options);
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
        $this->verifyUserPermission(SectionsEnum::categorie_produit, $user_id, ActionsEnum::delete,
            "ProductCategories", $id, "ProductCategory" ,null);
        $this->ProductCategory->id = $id;
        if (!$this->ProductCategory->exists()) {
            throw new NotFoundException(__('Invalid product category'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->ProductCategory->delete()) {

            $this->Flash->success(__('The product category has been deleted.'));
        } else {

            $this->Flash->error(__('The product category could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteCategories() {
        $this->setTimeActif();
        $this->autoRender = false;

            $id = filter_input(INPUT_POST, "id");
            $user_id=$this->Auth->user('id');

        $this->verifyUserPermission(SectionsEnum::categorie_produit, $user_id, ActionsEnum::delete,
            "ProductCategories", $id, "ProductCategory" ,null);
            $this->ProductCategory->id = $id;
           $this->verifyDependences($id);
            $this->request->allowMethod('post', 'delete');
            if($this->ProductCategory->delete()){
                echo json_encode(array("response" => "true"));
            }else{
                echo json_encode(array("response" => "false"));
            }

    }
    private function verifyDependences($id){
        $result = $this->ProductCategory->Product->find('first', array("conditions" => array("product_category_id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The product category could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        } 
    }
    function export() {
        $this->setTimeActif();
            $categories = $this->ProductCategory->find('all', array(
                'order' => 'ProductCategory.name asc',
                'recursive' => 2
            ));
        $this->set('models', $categories);
    }


}