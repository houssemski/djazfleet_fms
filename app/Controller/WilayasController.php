<?php

App::uses('AppController', 'Controller');

/**
 * Wilaya Controller
 *
 * @property Wilaya $Wilaya
 * @property Daira $Daira
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class WilayasController extends AppController {

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
        $result = $this->verifyUserPermission(SectionsEnum::wilaya, $user_id, ActionsEnum::view,
            "Wilayas", null, "Wilaya" , null);

        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                    $conditions=array('Wilaya.user_id '=>$user_id);
                break;
            case 3 :
                    $conditions=array('Wilaya.user_id !='=>$user_id);
                break;

            default:
                $conditions=null;
        }
        //Parametrer la pagination
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Wilaya.code' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );
        $this->Wilaya->recursive = 0;
        $this->set('wilayas', $this->Paginator->paginate());
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

        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('wilayas', $this->Paginator->paginate('Wilaya', array('OR' => array(
                            "LOWER(Wilaya.code) LIKE" => "%$keyword%",
                            "LOWER(Wilaya.name) LIKE" => "%$keyword%"))));
        } else {
            $this->Wilaya->recursive = 0;
            $this->set('wilayas', $this->Paginator->paginate());
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
        if (!$this->Wilaya->exists($id)) {
            throw new NotFoundException(__('Invalid Wilaya'));
        }
        $options = array('conditions' => array('Wilaya.' . $this->Wilaya->primaryKey => $id));
        $this->set('wilaya', $this->Wilaya->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::wilaya, $user_id, ActionsEnum::add, "Wilayas", null,
            "Wilaya" , null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Wilaya->create();
            $this->request->data['Wilaya']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Wilaya->save($this->request->data)) {
                $this->Flash->success(__('The wilaya has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The wilaya could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::wilaya, $user_id, ActionsEnum::edit, "Wilayas", $id,
            "Wilaya" , null);
        if (!$this->Wilaya->exists($id)) {
            throw new NotFoundException(__('Invalid wilaya'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Wilaya cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Wilaya']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Wilaya->save($this->request->data)) {
                $this->Flash->success(__('The wilaya has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The wilaya could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Wilaya.' . $this->Wilaya->primaryKey => $id));
            $this->request->data = $this->Wilaya->find('first', $options);
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
        $this->verifyUserPermission(SectionsEnum::wilaya, $user_id, ActionsEnum::delete, "Wilayas", $id,
            "Wilaya" , null);
        $this->Wilaya->id = $id;
        if (!$this->Wilaya->exists()) {
            throw new NotFoundException(__('Invalid wilaya'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Wilaya->delete()) {
                $this->Flash->success(__('The wilaya has been deleted.'));
        } else {
                $this->Flash->error(__('The wilaya could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteDestinations() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::wilaya, $user_id, ActionsEnum::delete, "Wilayas", $id,
            "Wilaya" , null);
       // if () {
            $this->Wilaya->id = $id;
            $this->verifyDependences($id);
            $this->request->allowMethod('post', 'delete');
            if($this->Wilaya->delete()){
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
        $this->loadModel('Daira');
        $result = $this->Daira->getDairaByWilayaId($id, 'first');
        if (!empty($result)) {
            $this->Flash->error(__('The wilaya could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        } 
    }

}