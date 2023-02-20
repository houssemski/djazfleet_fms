<?php

App::uses('AppController', 'Controller');
/**
 * ProductMark Controller
 *
 * @property ProductMark $ProductMark
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class ProductMarksController extends AppController {


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
        $result= $this->verifyUserPermission(SectionsEnum::marque_produit, $user_id, ActionsEnum::view,
            "ProductMarks", null, "ProductMark" ,null);

        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        //Parametrer la pagination
        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                    $conditions=array('ProductMark.user_id '=>$user_id);
                break;
            case 3 :
                    $conditions=array('ProductMark.user_id !='=>$user_id);
                break;
            default:
                $conditions=null;
        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('ProductMark.name' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );
        $this->ProductMark->recursive = 0;
        $this->set('productmarks', $this->Paginator->paginate('ProductMark'));
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
            'order' => array('ProductMark.code' => 'ASC', 'ProductMark.name' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('productmarks', $this->Paginator->paginate('ProductMark', array('OR' => array(
                            "LOWER(ProductMark.code) LIKE" => "%$keyword%",
                            "LOWER(ProductMark.name) LIKE" => "%$keyword%"))));
        } else {
            $this->ProductMark->recursive = 0;
            $this->set('productmarks', $this->Paginator->paginate('ProductMark'));
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
        if (!$this->ProductMark->exists($id)) {
            throw new NotFoundException(__('Invalid mark'));
        }
        $options = array('conditions' => array('ProductMark.' . $this->ProductMark->primaryKey => $id));
        $this->set('productmark', $this->ProductMark->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::marque_produit, $user_id, ActionsEnum::add,
            "ProductMarks", null, "ProductMark" ,null);
        if (isset($this->request->data['cancel'])) {

            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->verifyAttachment('ProductMark', 'logo', 'productmark/', 'add',1,null, true);
            $this->ProductMark->create();
            $this->request->data['ProductMark']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->ProductMark->save($this->request->data)) {

                $this->Flash->success(__('The mark has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The mark could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::marque_produit, $user_id, ActionsEnum::edit,
            "ProductMarks", $id, "ProductMark" ,null);
        if (!$this->ProductMark->exists($id)) {
            throw new NotFoundException(__('Invalid product mark'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Mark cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            
            $this->request->data['ProductMark']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->ProductMark->save($this->request->data)) {

                $this->Flash->success(__('The mark has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The mark could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ProductMark.' . $this->ProductMark->primaryKey => $id));
            $this->request->data = $this->ProductMark->find('first', $options);
            //$this->is_opened("ProductMark",'ProductMarks','mark',$id);
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
        $this->verifyUserPermission(SectionsEnum::marque_produit, $user_id, ActionsEnum::delete,
            "ProductMarks", $id, "ProductMark" ,null);
        $this->ProductMark->id = $id;
        if (!$this->ProductMark->exists()) {
            throw new NotFoundException(__('Invalid mark'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->ProductMark->delete()) {
            $this->Flash->success(__('The mark has been deleted.'));
        } else {
            $this->Flash->error(__('The mark could not be deleted. Please, try again.'));
        }

        $this->redirect(array('action' => 'index'));
    }
    public function deleteproductmarks() {
        $this->setTimeActif();
        $this->autoRender = false;
        //if ($this->isSuperAdmin()) {
            $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::marque_produit, $user_id, ActionsEnum::delete,
            "ProductMarks", $id, "ProductMark" ,null);
            $this->verifyDependences($id);
            $this->ProductMark->id = $id;
            $this->request->allowMethod('post', 'delete');
            if($this->ProductMark->delete()){
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
        $this->loadModel('Product');
        $result = $this->Product->getProductByForeignKey($id, "product_mark_id");
        if (!empty($result)) {
            $this->Flash->error(__('The mark could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        } 
    }
    

}