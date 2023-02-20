<?php

App::uses('AppController', 'Controller');

/**
 * CustomerCategories Controller
 *
 * @property CancelCause $CancelCause
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class CancelCausesController extends AppController {
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
        $userId=$this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::causes_annulation, $userId, ActionsEnum::view, "CancelCauses", null, "CancelCause" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                $conditions=array('CancelCause.userId '=>$userId);
                break;
            case 3 :
                $conditions=array('CancelCause.userId !='=>$userId);
                break;

            default:
                $conditions=null;
        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('CancelCause.code' => 'ASC', 'CancelCause.name' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );



        //Parametrer la pagination

        $this->CancelCause->recursive = 0;
        $this->set('cancelCauses', $this->Paginator->paginate());
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
            'order' => array('CancelCause.code' => 'ASC', 'CancelCause.name' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('cancelCauses', $this->Paginator->paginate('CancelCause', array('OR' => array(
                "LOWER(CancelCause.code) LIKE" => "%$keyword%",
                "LOWER(CancelCause.name) LIKE" => "%$keyword%"))));
        } else {
            $this->CancelCause->recursive = 0;
            $this->set('cancelCauses', $this->Paginator->paginate());
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

        if (!$this->CancelCause->exists($id)) {
            throw new NotFoundException(__('Invalid cancel cause.'));
        }
        $options = array('conditions' => array('CancelCause.' . $this->CancelCause->primaryKey => $id));
        $this->set('cancelCause', $this->CancelCause->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::causes_annulation, $user_id, ActionsEnum::add, "CancelCauses", null, "CancelCause" ,null);

        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->CancelCause->create();
            $this->request->data['CancelCause']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->CancelCause->save($this->request->data)) {

                $this->Flash->success(__('The cancel cause has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The cancel cause could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::causes_annulation, $user_id, ActionsEnum::edit, "CancelCauses", $id, "CancelCause" ,null);
        if (!$this->CancelCause->exists($id)) {
            throw new NotFoundException(__('Invalid cancel cause'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Cancel cause cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['CancelCause']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->CancelCause->save($this->request->data)) {

                $this->Flash->success(__('The cancel cause has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The cancel cause could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CancelCause.' . $this->CancelCause->primaryKey => $id));
            $this->request->data = $this->CancelCause->find('first', $options);

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
        $this->verifyUserPermission(SectionsEnum::causes_annulation, $user_id, ActionsEnum::delete, "CancelCauses", $id, "CancelCause" ,null);
        $this->CancelCause->id = $id;
        if (!$this->CancelCause->exists()) {
            throw new NotFoundException(__('Invalid cancel cause'));
        }
        //$this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->CancelCause->delete()) {

            $this->Flash->success(__('The cancel cause has been deleted.'));
        } else {

            $this->Flash->error(__('The cancel cause could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteCauses() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::causes_annulation, $user_id, ActionsEnum::delete, "CancelCauses", $id, "CancelCause" ,null);
        $this->CancelCause->id = $id;
        //$this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->CancelCause->delete()){
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
        $this->loadModel('SheetRideDetailRides');
        $result = $this->SheetRideDetailRides->getCustomerByForeignKey($id, 'cancel_cause_id');
        if (!empty($result)) {
            $this->Flash->error(__('The cancel cause could not be deleted. '
                . 'Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }

}
