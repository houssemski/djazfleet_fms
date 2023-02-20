<?php

App::uses('AppController', 'Controller');

/**
 * RideCategories Controller
 *
 * @property RideCategory $RideCategory
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class TransportBillCategoriesController extends AppController {

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

        $result = $this->verifyUserPermission(SectionsEnum::categorie_piece, $user_id, ActionsEnum::view,
            "TransportBillCategories", null, "TransportBillCategory" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :

                $conditions=null;


                break;
            case 2 :


                $conditions=array('TransportBillCategory.user_id '=>$user_id);

                break;
            case 3 :

                $conditions=array('TransportBillCategory.user_id !='=>$user_id);

                break;

            default:
                $conditions=null;


        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('TransportBillCategory.code' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );



        //Parametrer la pagination

        $this->TransportBillCategory->recursive = 0;
        $this->set('TransportBillCategories', $this->Paginator->paginate());
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
            'order' => array('TransportBillCategory.code' => 'ASC'),
            'recursive'=>-1,
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));

            $this->set('TransportBillCategories', $this->Paginator->paginate('TransportBillCategory', array('OR' => array(
                "LOWER(TransportBillCategory.code) LIKE" => "%$keyword%",
                "LOWER(TransportBillCategory.name) LIKE" => "%$keyword%"))));
        } else {
            $this->TransportBillCategory->recursive = 0;
            $this->set('TransportBillCategories', $this->Paginator->paginate());
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

        if (!$this->TransportBillCategory->exists($id)) {
            throw new NotFoundException(__('Invalid category'));
        }

        $transportBillCategory = $this->RideCategory->find('first', array('conditions' => array('TransportBillCategory.' . $this->TransportBillCategory->primaryKey => $id),'recursive'=>-1));

        $this->set('TransportBillCategory',$transportBillCategory );
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::categorie_piece, $user_id, ActionsEnum::add,
            "TransportBillCategories", null, "TransportBillCategory" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->TransportBillCategory->create();
            $this->request->data['TransportBillCategory']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->TransportBillCategory->save($this->request->data)) {

                $this->Flash->success(__('The category has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The category could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::categorie_trajet, $user_id, ActionsEnum::edit,
            "TransportBillCategories", $id, "TransportBillCategory" ,null);
        if($id != 1 && $id != 2 && $id != 3){
            if (!$this->TransportBillCategory->exists($id)) {
                throw new NotFoundException(__('Invalid category'));
            }
            if ($this->request->is(array('post', 'put'))) {
                if (isset($this->request->data['cancel'])) {

                    $this->Flash->error(__('Changes were not saved. Category cancelled.'));
                    $this->redirect(array('action' => 'index'));
                }
                $this->request->data['TransportBillCategory']['last_modifier_id'] = $this->Session->read('Auth.User.id');
                if ($this->TransportBillCategory->save($this->request->data)) {

                    $this->Flash->success(__('The category has been saved.'));
                    $this->redirect(array('action' => 'index'));
                } else {

                    $this->Flash->error(__('The category could not be saved. Please, try again.'));
                    $this->redirect(array('action' => 'index'));
                }
            }
            $this->TransportBillCategory->recursive = 0;
            $options = array('conditions' => array('TransportBillCategory.' . $this->TransportBillCategory->primaryKey => $id));
            $this->request->data = $this->TransportBillCategory->find('first', $options);

        }else {
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
            $this->redirect(array('action' => 'index'));
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
        $this->verifyUserPermission(SectionsEnum::categorie_piece, $user_id, ActionsEnum::delete,
            "TransportBillCategories", $id, "TransportBillCategory" ,null);
        $this->TransportBillCategory->id = $id;
        if (!$this->TransportBillCategory->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if (($id != 1 && $id != 2 && $id != 3) ) {
             $this->TransportBillCategory->delete();
            $this->Flash->success(__('The category has been deleted.'));
        } else {

            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deletecategories() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::categorie_piece, $user_id, ActionsEnum::delete,
            "TransportBillCategories", $id, "TransportBillCategory" ,null);
        $this->verifyDependences($id);
        $this->TransportBillCategory->id = $id;
        $this->request->allowMethod('post', 'delete');
        if(($id != 1 && $id != 2 && $id != 3)  ){
            $this->TransportBillCategory->delete();
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }

    }

    private function verifyDependences($id)
    {
        $transportBill = $this->TransportBill->find('first', array("conditions" => array("TransportBill.transport_bill_category_id =" => $id)));

        if (!empty($transportBill)) {
            $this->Flash->error(__('The category could not be deleted. '
                . 'Please remove dependencies with cars in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        $bill = $this->Bill->find('first', array("conditions" => array("Bill.transport_bill_category_id =" => $id)));
        if (!empty($bill)) {
            $this->Flash->error(__('The category could not be deleted. '
                . 'Please remove dependencies with customers in advance.'));
            $this->redirect(array('action' => 'index'));
        }

    }



    function export() {
        $this->setTimeActif();
        $categories = $this->TransportBillCategory->find('all', array(
            'order' => 'TransportBillCategory.name asc',
            'recursive' => 2
        ));
        $this->set('models', $categories);
    }

}
