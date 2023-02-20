<?php

App::uses('AppController', 'Controller');

/**
 * CustomerCategories Controller
 *
 * @property ComplaintCause $ComplaintCause
 * @property Complaint $Complaint
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class ComplaintCausesController extends AppController {
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
        $result = $this->verifyUserPermission(SectionsEnum::causes_reclamation, $userId, ActionsEnum::view, "ComplaintCauses", null, "ComplaintCause" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                $conditions=array('ComplaintCause.user_id '=>$userId);
                break;
            case 3 :
                $conditions=array('ComplaintCause.user_id !='=>$userId);
                break;

            default:
                $conditions=null;
        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('ComplaintCause.code' => 'ASC', 'ComplaintCause.name' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );



        //Parametrer la pagination

        $this->ComplaintCause->recursive = 0;
        $this->set('complaintCauses', $this->Paginator->paginate());
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
            'order' => array('ComplaintCause.code' => 'ASC', 'ComplaintCause.name' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('complaintCauses', $this->Paginator->paginate('ComplaintCause', array(
                'OR' => array(
                "LOWER(ComplaintCause.code) LIKE" => "%$keyword%",
                "LOWER(ComplaintCause.name) LIKE" => "%$keyword%"))));
        } else {
            $this->ComplaintCause->recursive = 0;
            $this->set('complaintCauses', $this->Paginator->paginate());
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

        if (!$this->ComplaintCause->exists($id)) {
            throw new NotFoundException(__('Invalid complaint cause.'));
        }
        $options = array('conditions' => array('ComplaintCause.' . $this->ComplaintCause->primaryKey => $id));
        $this->set('complaintCause', $this->ComplaintCause->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::causes_reclamation, $user_id, ActionsEnum::add, "ComplaintCauses", null, "CancelCause" ,null);

        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->ComplaintCause->create();
            $this->request->data['ComplaintCause']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->ComplaintCause->save($this->request->data)) {

                $this->Flash->success(__('The complaint cause has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The complaint cause could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::causes_reclamation, $user_id, ActionsEnum::edit, "ComplaintCauses", $id, "CancelCause" ,null);
        if (!$this->ComplaintCause->exists($id)) {
            throw new NotFoundException(__('Invalid complaint cause'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Complaint cause cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['ComplaintCause']['modified_id'] = $this->Session->read('Auth.User.id');
            if ($this->ComplaintCause->save($this->request->data)) {

                $this->Flash->success(__('The complaint cause has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The complaint cause could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ComplaintCause.' . $this->ComplaintCause->primaryKey => $id));
            $this->request->data = $this->ComplaintCause->find('first', $options);

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
        $this->verifyUserPermission(SectionsEnum::causes_reclamation, $user_id, ActionsEnum::delete, "ComplaintCauses", $id, "ComplaintCause" ,null);
        $this->ComplaintCause->id = $id;
        if (!$this->ComplaintCause->exists()) {
            throw new NotFoundException(__('Invalid complaint cause'));
        }
        //$this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->ComplaintCause->delete()) {

            $this->Flash->success(__('The complaint cause has been deleted.'));
        } else {

            $this->Flash->error(__('The complaint cause could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteCauses() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::causes_reclamation, $user_id, ActionsEnum::delete, "ComplaintCauses", $id, "ComplaintCause" ,null);
        $this->ComplaintCause->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->ComplaintCause->delete()){
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
        $this->loadModel('Complaint');
        $result = $this->Complaint->getCustomerByForeignKey($id, 'complaint_cause_id');
        if (!empty($result)) {
            $this->Flash->error(__('The complaint cause could not be deleted. '
                . 'Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }

}
