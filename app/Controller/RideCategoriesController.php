<?php

App::uses('AppController', 'Controller');

/**
 * RideCategories Controller
 *
 * @property RideCategory $RideCategory
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class RideCategoriesController extends AppController {

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

        $result = $this->verifyUserPermission(SectionsEnum::categorie_trajet, $user_id, ActionsEnum::view,
            "RideCategories", null, "RideCategory" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :

                $conditions=null;


                break;
            case 2 :


                    $conditions=array('RideCategory.user_id '=>$user_id);

                break;
            case 3 :

                    $conditions=array('RideCategory.user_id !='=>$user_id);

                break;

            default:
                $conditions=null;


        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('RideCategory.code' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );



        //Parametrer la pagination

        $this->RideCategory->recursive = 0;
        $this->set('RideCategories', $this->Paginator->paginate());
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
            'order' => array('RideCategory.code' => 'ASC'),
            'recursive'=>-1,
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));

            $this->set('RideCategories', $this->Paginator->paginate('RideCategory', array('OR' => array(
                            "LOWER(RideCategory.code) LIKE" => "%$keyword%",
                            "LOWER(RideCategory.name) LIKE" => "%$keyword%"))));
        } else {
            $this->RideCategory->recursive = 0;
            $this->set('RideCategories', $this->Paginator->paginate());
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

        if (!$this->RideCategory->exists($id)) {
            throw new NotFoundException(__('Invalid Ride category'));
        }

        $rideCategory = $this->RideCategory->find('first', array('conditions' => array('RideCategory.' . $this->RideCategory->primaryKey => $id),'recursive'=>-1));

        $this->set('RideCategory',$rideCategory );
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();
        //$this->verifyAuditor("RideCategories");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::categorie_trajet, $user_id, ActionsEnum::add,
            "RideCategories", null, "RideCategory" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->RideCategory->create();
            $this->request->data['RideCategory']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->RideCategory->save($this->request->data)) {

                $this->Flash->success(__('The Ride category has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The Ride category could not be saved. Please, try again.'));
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
            "RideCategories", $id, "RideCategory" ,null);
        if (!$this->RideCategory->exists($id)) {
            throw new NotFoundException(__('Invalid Ride category'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Ride Category cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['RideCategory']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->RideCategory->save($this->request->data)) {

                $this->Flash->success(__('The Ride category has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The Ride category could not be saved. Please, try again.'));
            }
        } else {
            $this->RideCategory->recursive = 0;
            $options = array('conditions' => array('RideCategory.' . $this->RideCategory->primaryKey => $id));
            $this->request->data = $this->RideCategory->find('first', $options);
            //$this->is_opened("RideCategory",'RideCategories','Ride category',$id);
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
        $this->verifyUserPermission(SectionsEnum::categorie_trajet, $user_id, ActionsEnum::delete,
            "RideCategories", $id, "RideCategory" ,null);
        $this->RideCategory->id = $id;
        if (!$this->RideCategory->exists()) {
            throw new NotFoundException(__('Invalid Ride category'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->RideCategory->delete()) {

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
        $this->verifyUserPermission(SectionsEnum::categorie_trajet, $user_id, ActionsEnum::delete,
            "RideCategories", $id, "RideCategory" ,null);
            $this->RideCategory->id = $id;
            $this->request->allowMethod('post', 'delete');
            if($this->RideCategory->delete()){
                echo json_encode(array("response" => "true"));
            }else{
                echo json_encode(array("response" => "false"));
            }

    }

    function export() {
        $this->setTimeActif();
            $categories = $this->RideCategory->find('all', array(
                'order' => 'RideCategory.name asc',
                'recursive' => 2
            ));
        $this->set('models', $categories);
    }

}
