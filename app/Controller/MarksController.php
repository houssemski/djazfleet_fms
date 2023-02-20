<?php

App::uses('AppController', 'Controller');

/**
 * Marks Controller
 *
 * @property Mark $Mark
 * @property Carmodel $Carmodel
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class MarksController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session','Security');
    public $uses = array('Mark', 'Carmodel');
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

        $result = $this->verifyUserPermission(SectionsEnum::marque_pneu, $user_id, ActionsEnum::view,
            "Marks", null, "Mark" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        //Parametrer la pagination
        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                    $conditions=array('Mark.user_id '=>$user_id);
                break;
            case 3 :
                    $conditions=array('Mark.user_id !='=>$user_id);
                break;
            default:
                $conditions=null;
        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Mark.code' => 'ASC', 'Mark.name' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );
        $this->Mark->recursive = 0;
        $this->set('marks', $this->Paginator->paginate('Mark'));
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
            'order' => array('Mark.code' => 'ASC', 'Mark.name' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('marks', $this->Paginator->paginate('Mark', array('OR' => array(
                            "LOWER(Mark.code) LIKE" => "%$keyword%",
                            "LOWER(Mark.name) LIKE" => "%$keyword%"))));
        } else {
            $this->Mark->recursive = 0;
            $this->set('marks', $this->Paginator->paginate('Mark'));
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
        if (!$this->Mark->exists($id)) {
            throw new NotFoundException(__('Invalid mark'));
        }
        $options = array('conditions' => array('Mark.' . $this->Mark->primaryKey => $id));
        $this->set('mark', $this->Mark->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::marque_pneu, $user_id, ActionsEnum::add, "Marks", null,
            "Mark" ,null);
        if (isset($this->request->data['cancel'])) {

            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->verifyAttachment('Mark', 'logo', 'mark/', 'add',1,0,null, true);
            $this->Mark->create();
            $this->request->data['Mark']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Mark->save($this->request->data)) {

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
        $this->verifyUserPermission(SectionsEnum::marque_pneu, $user_id, ActionsEnum::edit, "Marks", $id,
            "Mark" ,null);
        if (!$this->Mark->exists($id)) {
            throw new NotFoundException(__('Invalid mark'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Mark cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->verifyAttachment('Mark', 'logo', 'mark/', 'edit',1,0,null, true);
            $this->request->data['Mark']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Mark->save($this->request->data)) {

                $this->Flash->success(__('The mark has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The mark could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Mark.' . $this->Mark->primaryKey => $id));
            $this->request->data = $this->Mark->find('first', $options);
             //$this->is_opened("Mark",'Marks','mark',$id);
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
        $this->verifyUserPermission(SectionsEnum::marque_pneu, $user_id, ActionsEnum::delete, "Marks", $id,
            "Mark" ,null);
        $this->Mark->id = $id;
        if (!$this->Mark->exists()) {
            throw new NotFoundException(__('Invalid mark'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Mark->delete()) {
            $this->Flash->success(__('The mark has been deleted.'));
        } else {
            $this->Flash->error(__('The mark could not be deleted. Please, try again.'));
        }

        $this->redirect(array('action' => 'index'));
    }
    public function deletemarks() {
        $this->setTimeActif();
        $this->autoRender = false;
            $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::marque_pneu, $user_id, ActionsEnum::delete, "Marks", $id,
            "Mark" ,null);
            $this->verifyDependences($id);
            $this->Mark->id = $id;
            $this->request->allowMethod('post', 'delete');
            if($this->Mark->delete()){
                echo json_encode(array("response" => "true"));
            }else{
                echo json_encode(array("response" => "false"));
            }
    }
    private function verifyDependences($id){
        $this->setTimeActif();
        $result = $this->Carmodel->getCarModelsByMark($id);
        if (!empty($result)) {
            $this->Flash->error(__('The mark could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $result = $this->Car->getCarsByFieldsAndConds($param, null, array('Car.mark_id'=>$id), 'all');
        if (!empty($result)) {
            $this->Flash->error(__('The mark could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }
    
    function export() {
        $this->setTimeActif();
        if(isset($this->params['pass']['0']) && $this->params['pass']['0'] == "all"){
            $marks = $this->Mark->getCarMarks('2', 'all');
        }else{
            $ids = filter_input(INPUT_POST, "chkids");
            $array_ids = explode(",", $ids);
            $marks = $this->Mark->getCarMarksByIds($array_ids, '2', 'all');
        }
        $this->set('models', $marks);
    }

}
