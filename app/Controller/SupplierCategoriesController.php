<?php

App::uses('AppController', 'Controller');

/**
 * SupplierCategories Controller
 *
 * @property SupplierCategory $SupplierCategory
 * @property Supplier $Supplier
 * @property AttachmentType $AttachmentType
 * @property SupplierCategoryAttachmentType $SupplierCategoryAttachmentType
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class SupplierCategoriesController extends AppController {

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
        $result = $this->verifyUserPermission(SectionsEnum::categorie_client, $user_id, ActionsEnum::view,
            "SupplierCategories", null, "SupplierCategory" ,null);

        $limit = isset($this->params['pass']['1']) ? $this->getLimit($this->params['pass']['1']) : $this->getLimit();
        $type=$this->params['pass']['0'];
        switch($result) {
            case 1 :
                $conditions=array('SupplierCategory.type '=>$type, 'SupplierCategory.id != '=>1);
                break;
            case 2 :
                $conditions=array('SupplierCategory.type '=>$type,'SupplierCategory.user_id '=>$user_id , 'SupplierCategory.id != '=>1);
                break;
            case 3 :
                $conditions=array('SupplierCategory.type '=>$type,'SupplierCategory.user_id !='=>$user_id , 'SupplierCategory.id != '=>1);
                break;
            default:
                $conditions=array('SupplierCategory.type '=>$type , 'SupplierCategory.id != '=>1);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('SupplierCategory.code' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );
        //Parametrer la pagination

        $this->SupplierCategory->recursive = 0;
        $this->set('supplierCategories', $this->Paginator->paginate());
        $this->set(compact('limit','type'));
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
            'order' => array('SupplierCategory.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('supplierCategories', $this->Paginator->paginate('SupplierCategory', array('OR' => array(
                "LOWER(SupplierCategory.code) LIKE" => "%$keyword%",
                "LOWER(SupplierCategory.name) LIKE" => "%$keyword%"))));
        } else {
            $this->SupplierCategory->recursive = 0;
            $this->set('supplierCategories', $this->Paginator->paginate());
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

        if (!$this->SupplierCategory->exists($id)) {
            throw new NotFoundException(__('Invalid supplier category'));
        }
        $options = array('conditions' => array('SupplierCategory.' . $this->SupplierCategory->primaryKey => $id));
        $this->set('supplierCategory', $this->SupplierCategory->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::categorie_client, $user_id, ActionsEnum::add,
            "SupplierCategories", null, "SupplierCategory" ,null);

        if ($this->request->is('post')) {
            $type=$this->request->data['SupplierCategory']['type'];
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index', $type));
            }
            $this->SupplierCategory->create();
            $this->request->data['SupplierCategory']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->SupplierCategory->save($this->request->data)) {
                $supplierCategoryId = $this->SupplierCategory->getInsertID();
                if (!empty($this->request->data['SupplierCategoryAttachmentType'])) {
                    $this->addSupplierCategoryAttachmentTypes($this->request->data['SupplierCategoryAttachmentType'], $supplierCategoryId);
                }

                $this->Flash->success(__('The Supplier category has been saved.'));
                $this->redirect(array('action' => 'index',$type));
            } else {

                $this->Flash->error(__('The supplier category could not be saved. Please, try again.'));
            }
        }
        $type = $this->params['pass']['0'];
        if ($type == SupplierCategoriesEnum::CUSTOMER_TYPE) {
            $this->loadModel('AttachmentType');
            $attachmentTypes = $this->AttachmentType->getAttachmentTypeBySectionId(SectionsEnum::mission, "all");
        } else {
            $attachmentTypes = null;
        }
        $this->set(compact('attachmentTypes'));

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
        $this->verifyUserPermission(SectionsEnum::categorie_client, $user_id, ActionsEnum::edit,
            "SupplierCategories", $id, "SupplierCategory" ,null);
        if (!$this->SupplierCategory->exists($id)) {
            throw new NotFoundException(__('Invalid supplier category'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $type=$this->request->data['SupplierCategory']['type'];
            if (isset($this->request->data['cancel'])) {

                $this->Flash->success(__('Changes were not saved. Supplier Category cancelled.'));
                $this->redirect(array('action' => 'index',$type));
            }
            $this->request->data['SupplierCategory']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if (($id != 1 || $id != 2) && $this->SupplierCategory->save($this->request->data)) {

                if (!empty($this->request->data['SupplierCategoryAttachmentType'])) {
                    $this->addSupplierCategoryAttachmentTypes($this->request->data['SupplierCategoryAttachmentType'], $id);
                }

                $this->Flash->success(__('The Supplier category has been saved.'));
                $this->redirect(array('action' => 'index', $type));
            } else {

                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('SupplierCategory.' . $this->SupplierCategory->primaryKey => $id));
            $this->request->data = $this->SupplierCategory->find('first', $options);
            //$this->is_opened("SupplierCategory",'SupplierCategories','Supplier category',$id);
            $type = $this->request->data['SupplierCategory']['type'];
            if ($type == SupplierCategoriesEnum::CUSTOMER_TYPE) {
                $this->loadModel('AttachmentType');
                $this->loadModel('SupplierCategoryAttachmentType');
                $attachmentTypes = $this->AttachmentType->getAttachmentTypeBySectionId(SectionsEnum::mission, "all");
                $supplierCategoryAttachmentTypes = $this->SupplierCategoryAttachmentType->getSupplierCategoryAttachmentTypesBySupplierId($id);

            } else {
                $attachmentTypes = null;
                $supplierCategoryAttachmentTypes = null;
            }
            $this->set(compact('attachmentTypes','supplierCategoryAttachmentTypes'));
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
        $type=$this->params['pass']['1'];
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::categorie_client, $user_id, ActionsEnum::delete,
            "SupplierCategories", $id, "SupplierCategory" ,null);
        $this->SupplierCategory->id = $id;
        if (!$this->SupplierCategory->exists()) {
            throw new NotFoundException(__('Invalid supplier category'));
        }
        $this->verifyDependences($id, $type);
        $this->request->allowMethod('post', 'delete');
        if (($id != 1 || $id != 2) && $this->SupplierCategory->delete()) {

            $this->Flash->success(__('The supplier category has been deleted.'));
        } else {

            $this->Flash->error(__('The Supplier category could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index', $type));
    }

    public function deletecategories() {
        $this->setTimeActif();
        $this->autoRender = false;

        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::categorie_client, $user_id, ActionsEnum::delete,
            "SupplierCategories", $id, "SupplierCategory" ,null);
        $this->SupplierCategory->id = $id;
        $this->verifyDependences($id );
        $this->request->allowMethod('post', 'delete');
        if($id != 1 && $this->SupplierCategory->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }
        /*}else{
            echo json_encode(array("response" => "false"));
        }*/
    }
    private function verifyDependences($id, $type=null){
        $this->setTimeActif();
        $result = $this->Supplier->getSuppliersByParams(null, null, array($id), null, 'first');
        if (!empty($result)) {
            $this->Flash->error(__('The supplier category could not be deleted. '
                . 'Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index', $type));
        }
        $this->loadModel('SupplierCategoryAttachmentType');
        $results = $this->SupplierCategoryAttachmentType->find('first',
            array(
                "conditions" => array(
                    "SupplierCategoryAttachmentType.supplier_category_id =" => $id
                )
            )
        );
        if (!empty($results)) {
            $this->SupplierCategoryAttachmentType->deleteAll(array('SupplierCategoryAttachmentType.supplier_category_id' => $id),
                false);
        }
    }

    function addCategory()
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::categorie_client, $user_id, ActionsEnum::add,
            "SupplierCategories", null, "SupplierCategory", 1, 1);
        //type of category 0 : supplier, 1 : client
        $type = $this->params['pass']['0'];

        $this->set(compact('result', 'type'));
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened

        if (!empty($this->request->data)) {
            if ($this->SupplierCategory->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $supplierCategoryId = $this->SupplierCategory->getLastInsertId();
                $this->set('supplierCategoryId', $supplierCategoryId);
            }
        }
    }

    function editCategory()
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::categorie_client, $user_id, ActionsEnum::edit,
            "SupplierCategories", null, "SupplierCategory", 1, 1);
        $supplierCategoryId = $this->params['pass']['0'];
        //type of category 0 : supplier, 1 : client
        $type = $this->params['pass']['1'];
        $this->set(compact('result', 'type', 'supplierCategoryId'));
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened

        if (!empty($this->request->data)) {
            if ($this->SupplierCategory->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $supplierCategoryId = $this->request->data['SupplierCategory']['id'];
                $this->set('supplierCategoryId', $supplierCategoryId);
            }
        }else{
            $options = array('conditions' => array('SupplierCategory.' . $this->SupplierCategory->primaryKey => $supplierCategoryId));
            $this->request->data = $this->SupplierCategory->find('first', $options);
        }
    }

    function getCategories($supplierCategoryId){
        $this->layout = 'ajax';
        $categories = $this->SupplierCategory->getSupplierCategories(null,'all');

        $this->set('selectBox', $categories);
        $this->set('selectedId', $supplierCategoryId);
    }


    public function addSupplierCategoryAttachmentTypes($supplierCategoryAttachmentTypes, $supplierCategoryId)
    {
        $this->loadModel('SupplierCategoryAttachmentType');
        $this->SupplierCategoryAttachmentType->deleteAll(array('SupplierCategoryAttachmentType.supplier_category_id' => $supplierCategoryId), false);
        $this->loadModel('AttachmentType');
        $attachmentTypes = $this->AttachmentType->getAttachmentTypeBySectionId(SectionsEnum::mission, "all");
        foreach ($attachmentTypes as $attachmentType) {
            if (($supplierCategoryAttachmentTypes[$attachmentType['AttachmentType']['id']] == 1)) {

                $this->SupplierCategoryAttachmentType->create();
                $attachment = array();
                $attachment['SupplierCategoryAttachmentType']['supplier_category_id'] = $supplierCategoryId;
                $attachment['SupplierCategoryAttachmentType']['attachment_type_id'] = $attachmentType['AttachmentType']['id'];
                $attachment['SupplierCategoryAttachmentType']['user_id'] = $this->Session->read('Auth.User.id');
                $this->SupplierCategoryAttachmentType->save($attachment);
            }
        }

    }
}
