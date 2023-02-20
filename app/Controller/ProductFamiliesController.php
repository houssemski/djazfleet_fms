<?php

App::uses('AppController', 'Controller');
class ProductFamiliesController extends AppController {


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
        $result = $this->verifyUserPermission(SectionsEnum::famille_produit, $user_id, ActionsEnum::view,
            "ProductFamilies", null, "ProductFamily" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :

                $conditions=null;


                break;
            case 2 :


                $conditions=array('ProductFamily.user_id '=>$user_id);

                break;
            case 3 :

                $conditions=array('ProductFamily.user_id !='=>$user_id);

                break;

            default:
                $conditions=null;


        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('ProductFamily.code' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );



        //Parametrer la pagination

        $this->ProductFamily->recursive = 0;
        $this->set('productFamilies', $this->Paginator->paginate());
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
            'order' => array('ProductFamily.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('productFamilies', $this->Paginator->paginate('ProductFamily', array('OR' => array(
                "LOWER(ProductFamily.code) LIKE" => "%$keyword%",
                "LOWER(ProductFamily.name) LIKE" => "%$keyword%"))));
        } else {
            $this->ProductFamily->recursive = 0;
            $this->set('productFamilies', $this->Paginator->paginate());
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

        if (!$this->ProductFamily->exists($id)) {
            throw new NotFoundException(__('Invalid product family'));
        }
        $options = array('conditions' => array('ProductFamily.' . $this->ProductFamily->primaryKey => $id));
        $this->set('productFamily', $this->ProductFamily->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::famille_produit, $user_id, ActionsEnum::add, "ProductFamilies",
            null, "ProductFamily" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->ProductFamily->create();
            $this->request->data['ProductFamily']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->ProductFamily->save($this->request->data)) {

                $this->Flash->success(__('The product family has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The product family could not be saved. Please, try again.'));
            }
        }
        $productFamilies = $this->ProductFamily->getProductFamilies();
        $this->set(compact('productFamilies'));
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
        $this->verifyUserPermission(SectionsEnum::famille_produit, $user_id, ActionsEnum::edit,
            "ProductFamilies", $id, "ProductFamily" ,null);
        if (!$this->ProductFamily->exists($id)) {
            throw new NotFoundException(__('Invalid product family'));
        }

        if($id==1 ||$id==2){
          $this->Flash->success(__('This family can not be modified.'));
          $this->redirect(array('action' => 'index'));
      }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Product family cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['ProductFamily']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->ProductFamily->save($this->request->data)) {
                $this->Flash->success(__('The product family has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The product family could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ProductFamily.' . $this->ProductFamily->primaryKey => $id));
            $this->request->data = $this->ProductFamily->find('first', $options);
        }
        $productFamilies = $this->ProductFamily->getProductFamilies();
        $this->set(compact('productFamilies'));
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
        $this->verifyUserPermission(SectionsEnum::famille_produit, $user_id, ActionsEnum::delete,
            "ProductFamilies", $id, "ProductFamily" ,null);
        $this->ProductFamily->id = $id;
        if (!$this->ProductFamily->exists()) {
            throw new NotFoundException(__('Invalid product family'));
        }
        if($id==1 ||$id==2){
            $this->Flash->success(__('This product family can not be deleted.'));
            $this->redirect(array('action' => 'index'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->ProductFamily->delete()) {

            $this->Flash->success(__('The product family has been deleted.'));
        } else {

            $this->Flash->error(__('The product family could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteFamilies() {
        $this->setTimeActif();
        $this->autoRender = false;

        $id = filter_input(INPUT_POST, "id");
        if($id==1 ||$id==2){
            $this->Flash->success(__('This product family can not be deleted.'));
            $this->redirect(array('action' => 'index'));
        }
        $user_id=$this->Auth->user('id');

        $this->verifyUserPermission(SectionsEnum::famille_produit, $user_id, ActionsEnum::delete,
            "ProductFamilies", $id, "ProductFamily" ,null);
        $this->ProductFamily->id = $id;
        // $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->ProductFamily->delete()){
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
        $result = $this->ProductFamily->Product->find('first', array("conditions" => array("product_family_id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The product family could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }
    function export() {
        $this->setTimeActif();
        $families = $this->ProductFamily->find('all', array(
            'order' => 'ProductFamily.name asc',
            'recursive' => 2
        ));
        $this->set('models', $families);
    }


}