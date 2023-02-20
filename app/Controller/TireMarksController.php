<?php

App::uses('AppController', 'Controller');

/**
 * TireMarks Controller
 *
 * @property TireMark $TireMark
 * @property Tire $Tire
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class TireMarksController extends AppController {


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

        $result= $this->verifyUserPermission(SectionsEnum::marque_pneu, $user_id, ActionsEnum::view,
            "TireMarks", null, "TireMark" , null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        //Parametrer la pagination
        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                    $conditions=array('TireMark.user_id '=>$user_id);
                break;
            case 3 :
                    $conditions=array('TireMark.user_id !='=>$user_id);
                break;
            default:
                $conditions=null;
        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('TireMark.name' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );
        $this->TireMark->recursive = 0;
        $this->set('tiremarks', $this->Paginator->paginate('TireMark'));
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
            'order' => array('TireMark.code' => 'ASC', 'TireMark.name' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('tiremarks', $this->Paginator->paginate('TireMark', array('OR' => array(
                            "LOWER(TireMark.code) LIKE" => "%$keyword%",
                            "LOWER(TireMark.name) LIKE" => "%$keyword%"))));
        } else {
            $this->TireMark->recursive = 0;
            $this->set('tiremarks', $this->Paginator->paginate('TireMark'));
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
        if (!$this->TireMark->exists($id)) {
            throw new NotFoundException(__('Invalid mark'));
        }
        $options = array('conditions' => array('TireMark.' . $this->TireMark->primaryKey => $id));
        $this->set('tiremark', $this->TireMark->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();
        
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::marque_pneu, $user_id, ActionsEnum::add,
            "TireMarks", null, "TireMark" , null);
        if (isset($this->request->data['cancel'])) {

            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
           
            $this->TireMark->create();
            $this->request->data['TireMark']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->TireMark->save($this->request->data)) {

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
        $this->verifyUserPermission(SectionsEnum::marque_pneu, $user_id, ActionsEnum::edit,
            "TireMarks", $id, "TireMark" , null);
        if (!$this->TireMark->exists($id)) {
            throw new NotFoundException(__('Invalid Tire mark'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->success(__('Changes were not saved. Mark cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            
            $this->request->data['TireMark']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->TireMark->save($this->request->data)) {

                $this->Flash->success(__('The mark has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->success(__('The mark could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('TireMark.' . $this->TireMark->primaryKey => $id));
            $this->request->data = $this->TireMark->find('first', $options);
            //$this->is_opened("TireMark",'TireMarks','mark',$id);
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
        $this->verifyUserPermission(SectionsEnum::marque_pneu, $user_id, ActionsEnum::delete,
            "TireMarks", $id, "TireMark" , null);
        $this->TireMark->id = $id;
        if (!$this->TireMark->exists()) {
            throw new NotFoundException(__('Invalid mark'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->TireMark->delete()) {
            $this->Flash->success(__('The mark has been deleted.'));
        } else {
            $this->Flash->error(__('The mark could not be deleted. Please, try again.'));
        }

        $this->redirect(array('action' => 'index'));
    }
    public function deletetiremarks() {
        $this->setTimeActif();
        $this->autoRender = false;
            $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::marque_pneu, $user_id, ActionsEnum::delete,
            "TireMarks", $id, "TireMark" , null);
            $this->verifyDependences($id);
            $this->TireMark->id = $id;
            $this->request->allowMethod('post', 'delete');
            if($this->TireMark->delete()){
                echo json_encode(array("response" => "true"));
            }else{
                echo json_encode(array("response" => "false"));
            }

    }
    private function verifyDependences($id){
        $this->setTimeActif();
        $this->loadModel('Tire');
        $result = $this->Tire->getTireByForeignKey($id, "tire_mark_id");
        if (!empty($result)) {
            $this->Flash->error(__('The mark could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        } 
    }

}