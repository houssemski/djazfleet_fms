<?php

App::uses('AppController', 'Controller');
/**
*@property ProductType $ProductType
*@property Factor $Factor
*@property ProductTypeFactor $ProductTypeFactor
 *
 **/
class ProductTypesController extends AppController {
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    var $helpers = array('Xls');
    public $uses = array('ProductType', 'Factor','ProductTypeFactor');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::categorie_produit, $user_id, ActionsEnum::view,
            "ProductTypes", null, "ProductType" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :

                $conditions=null;


                break;
            case 2 :


                $conditions=array('ProductType.user_id '=>$user_id);

                break;
            case 3 :

                $conditions=array('ProductType.user_id !='=>$user_id);

                break;

            default:
                $conditions=null;


        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('ProductType.name' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );



        //Parametrer la pagination

        $this->ProductType->recursive = 0;
        $this->set('productTypes', $this->Paginator->paginate());
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
            'order' => array('ProductType.name' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('productTypes', $this->Paginator->paginate('ProductType', array('OR' => array(

                "LOWER(ProductType.name) LIKE" => "%$keyword%"))));
        } else {
            $this->ProductType->recursive = 0;
            $this->set('productTypes', $this->Paginator->paginate());
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

        if (!$this->ProductType->exists($id)) {
            throw new NotFoundException(__('Invalid type'));
        }
        $options = array('conditions' => array('ProductType.' . $this->ProductType->primaryKey => $id));
        $this->set('productType', $this->ProductType->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::categorie_produit, $user_id,
            ActionsEnum::add, "ProductTypes",
            null, "ProductType" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->ProductType->create();
            $this->request->data['ProductType']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->ProductType->save($this->request->data)) {
                $productTypeId = $this->ProductType->getInsertID();
                $productTypeFactors = $this->request->data['ProductTypeFactor']['factor_id'];

                if(!empty($productTypeFactors)){
                    $data = array();
                    foreach ($productTypeFactors as $productTypeFactor){

                        $data['ProductTypeFactor']['product_type_id'] = $productTypeId;
                        $data['ProductTypeFactor']['factor_id'] = $productTypeFactor;
                        $this->ProductTypeFactor->create();
                        $this->ProductTypeFactor->save($data);


                    }
                }

                $this->Flash->success(__('The type has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The type could not be saved. Please, try again.'));
            }
        }
        $factors = $this->Factor->getFactors('list');
        $this->set('factors',$factors);
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
        if($id ==1 || $id == 2|| $id ==3){
            $this->Flash->error(__('The type could not be modified.'));
            $this->redirect(array('action' => 'index'));
        }
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::categorie_produit, $user_id, ActionsEnum::edit,
            "ProductTypes", $id, "ProductType" ,null);
        if (!$this->ProductType->exists($id)) {
            throw new NotFoundException(__('Invalid type'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Type cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['ProductType']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->ProductType->save($this->request->data)) {
                $this->ProductTypeFactor->deleteAll(array('ProductTypeFactor.product_type_id' => $id), false);
                $productTypeFactors = $this->request->data['ProductTypeFactor']['factor_id'];
                if(!empty($productTypeFactors)){
                    $data = array();
                    foreach ($productTypeFactors as $productTypeFactor){
                        $data['ProductTypeFactor']['product_type_id'] = $id;
                        $data['ProductTypeFactor']['factor_id'] = $productTypeFactor;
                        $this->ProductTypeFactor->create();
                        $this->ProductTypeFactor->save($data);


                    }
                }

                $this->Flash->success(__('The type has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ProductType.' . $this->ProductType->primaryKey => $id));
            $this->request->data = $this->ProductType->find('first', $options);
            $productTypeFactors = $this->ProductTypeFactor->find('all',array(
                'recursive'=>'-1',
                'conditions'=>array("ProductTypeFactor.product_type_id"=>$id),
                'fields'=>array('ProductTypeFactor.factor_id')
            ));
            $selectedProductTypeFactorIds= array();
            foreach ($productTypeFactors as $productTypeFactor){
                $selectedProductTypeFactorIds[]= $productTypeFactor['ProductTypeFactor']['factor_id'];
            }
            $this->set('selectedProductTypeFactorIds',$selectedProductTypeFactorIds);
        }
        $factors = $this->Factor->getFactors('list');
        $this->set('factors',$factors);
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
            "ProductTypes", $id, "ProductType" ,null);
        $this->ProductType->id = $id;
        if (!$this->ProductType->exists()) {
            throw new NotFoundException(__('Invalid type'));
        }
        $this->verifyDependences($id);
        if($id ==1 || $id == 2|| $id ==3){
            $this->Flash->error(__('The type could not be deleted. Please, try again.'));
        }else {
            $this->request->allowMethod('post', 'delete');
            if ($this->ProductType->delete()) {
                $this->ProductTypeFactor->deleteAll(array('ProductTypeFactor.product_type_id' => $id), false);


                $this->Flash->success(__('The type has been deleted.'));
            } else {

                $this->Flash->error(__('The type could not be deleted. Please, try again.'));
            }
        }

        $this->redirect(array('action' => 'index'));
    }

    public function deleteTypes() {
        $this->setTimeActif();
        $this->autoRender = false;

        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');

        $this->verifyUserPermission(SectionsEnum::categorie_produit, $user_id, ActionsEnum::delete,
            "ProductTypes", $id, "ProductType" ,null);
        $this->ProductType->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->ProductType->delete()){
            $this->ProductTypeFactor->deleteAll(array('ProductTypeFactor.product_type_id' => $id), false);

            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }

    }
    private function verifyDependences($id){
        $result = $this->ProductType->Product->find('first', array("conditions" => array("product_type_id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The type could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }

    }
    function export() {
        $this->setTimeActif();
        $types = $this->ProductType->find('all', array(
            'order' => 'ProductType.name asc',
            'recursive' => 2
        ));
        $this->set('models', $types);
    }


}