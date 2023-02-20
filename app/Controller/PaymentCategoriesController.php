<?php

App::uses('AppController', 'Controller');

/**
 * RideCategories Controller
 *
 * @property RideCategory $RideCategory
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class PaymentCategoriesController extends AppController {

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
            "PaymentCategories", null, "PaymentCategory" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :

                $conditions=null;


                break;
            case 2 :


                $conditions=array('PaymentCategory.user_id '=>$user_id);

                break;
            case 3 :

                $conditions=array('PaymentCategory.user_id !='=>$user_id);

                break;

            default:
                $conditions=null;


        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('PaymentCategory.code' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );



        //Parametrer la pagination

        $this->PaymentCategory->recursive = 0;
        $this->set('paymentCategories', $this->Paginator->paginate());
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
            'order' => array('PaymentCategory.code' => 'ASC'),
            'recursive'=>-1,
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));

            $this->set('paymentCategories', $this->Paginator->paginate('PaymentCategory', array('OR' => array(
                "LOWER(PaymentCategory.code) LIKE" => "%$keyword%",
                "LOWER(PaymentCategory.name) LIKE" => "%$keyword%"))));
        } else {
            $this->PaymentCategory->recursive = 0;
            $this->set('paymentCategories', $this->Paginator->paginate());
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

        if (!$this->PaymentCategory->exists($id)) {
            throw new NotFoundException(__('Invalid category'));
        }

        $paymentCategory = $this->RideCategory->find('first', array('conditions' => array('PaymentCategory.' . $this->PaymentCategory->primaryKey => $id),'recursive'=>-1));

        $this->set('paymentCategory',$paymentCategory );
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
            "PaymentCategories", null, "PaymentCategory" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->PaymentCategory->create();
            $this->request->data['PaymentCategory']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->PaymentCategory->save($this->request->data)) {

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
            "PaymentCategories", $id, "PaymentCategory" ,null);
        if($id != 1 && $id != 2) {
            if (!$this->PaymentCategory->exists($id)) {
                throw new NotFoundException(__('Invalid category'));
            }
            if ($this->request->is(array('post', 'put'))) {
                if (isset($this->request->data['cancel'])) {

                    $this->Flash->error(__('Changes were not saved. Category cancelled.'));
                    $this->redirect(array('action' => 'index'));
                }
                $this->request->data['PaymentCategory']['last_modifier_id'] = $this->Session->read('Auth.User.id');
                if ($this->PaymentCategory->save($this->request->data)) {

                    $this->Flash->success(__('The category has been saved.'));
                    $this->redirect(array('action' => 'index'));
                } else {

                    $this->Flash->error(__('The category could not be saved. Please, try again.'));
                    $this->redirect(array('action' => 'index'));
                }
            } else {
                $this->PaymentCategory->recursive = 0;
                $options = array('conditions' => array('PaymentCategory.' . $this->PaymentCategory->primaryKey => $id));
                $this->request->data = $this->PaymentCategory->find('first', $options);
            }
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
            "PaymentCategories", $id, "PaymentCategory" ,null);
        $this->PaymentCategory->id = $id;
        if (!$this->PaymentCategory->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($id != 1 && $id != 2) {
            $this->PaymentCategory->delete();
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
            "PaymentCategories", $id, "PaymentCategory" ,null);
        $this->PaymentCategory->id = $id;
        $this->request->allowMethod('post', 'delete');
        if($id != 1 && $id != 2){
            $this->PaymentCategory->delete();
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }

    }

    function export() {
        $this->setTimeActif();
        $categories = $this->PaymentCategory->find('all', array(
            'order' => 'PaymentCategory.name asc',
            'recursive' => 2
        ));
        $this->set('models', $categories);
    }

}
