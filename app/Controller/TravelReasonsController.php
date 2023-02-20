<?php

App::uses('AppController', 'Controller');

/**
 * CustomerCategories Controller
 *
 * @property TravelReason $TravelReason
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class TravelReasonsController extends AppController {
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
        $result = $this->verifyUserPermission(SectionsEnum::motif_livraison, $userId,
            ActionsEnum::view, "TravelReasons", null, "TravelReason" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                $conditions=array('TravelReason.user_id '=>$userId);
                break;
            case 3 :
                $conditions=array('TravelReason.user_id !='=>$userId);
                break;
            default:
                $conditions=null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('TravelReason.code' => 'ASC', 'TravelReason.name' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );
        //Parametrer la pagination
        $this->TravelReason->recursive = 0;
        $this->set('travelReasons', $this->Paginator->paginate());
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
            'order' => array('TravelReason.code' => 'ASC', 'TravelReason.name' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('travelReasons', $this->Paginator->paginate('TravelReason', array(
                'OR' => array(
                    "LOWER(TravelReason.code) LIKE" => "%$keyword%",
                    "LOWER(TravelReason.name) LIKE" => "%$keyword%"))));
        } else {
            $this->TravelReason->recursive = 0;
            $this->set('travelReasons', $this->Paginator->paginate());
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
        if (!$this->TravelReason->exists($id)) {
            throw new NotFoundException(__('Invalid travel reason.'));
        }
        $options = array('conditions' => array('TravelReason.' . $this->TravelReason->primaryKey => $id));
        $this->set('travelReason', $this->TravelReason->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::motif_livraison, $user_id, ActionsEnum::add,
            "TravelReasons", null, "TravelReason" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->TravelReason->create();
            $this->request->data['TravelReason']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->TravelReason->save($this->request->data)) {

                $this->Flash->success(__('The travel reason has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The travel reason could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::motif_livraison, $user_id, ActionsEnum::edit,
            "TravelReasons", $id, "TravelReason" ,null);
        if (!$this->TravelReason->exists($id)) {
            throw new NotFoundException(__('Invalid travel reason'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Travel reason cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['TravelReason']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->TravelReason->save($this->request->data)) {

                $this->Flash->success(__('The travel reason has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The travel reason could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('TravelReason.' . $this->TravelReason->primaryKey => $id));
            $this->request->data = $this->TravelReason->find('first', $options);

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
        $this->verifyUserPermission(SectionsEnum::motif_livraison, $user_id, ActionsEnum::delete,
            "TravelReasons", $id, "TravelReason" ,null);
        $this->TravelReason->id = $id;
        if (!$this->TravelReason->exists()) {
            throw new NotFoundException(__('Invalid travel reason'));
        }
        //$this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->TravelReason->delete()) {

            $this->Flash->success(__('The travel reason has been deleted.'));
        } else {

            $this->Flash->error(__('The travel reason could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteReasons() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::motif_livraison, $user_id, ActionsEnum::delete,
            "TravelReasons", $id, "TravelReason" ,null);
        $this->TravelReason->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->TravelReason->delete()){
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
        $this->loadModel('SheetRide');
        $result = $this->SheetRide->find('first',array(
            'recursive'=>-1,
            'conditions'=>array('SheetRide.travel_reason_id'=>$id)
        ));
        if (!empty($result)) {
            $this->Flash->error(__('The travel reason could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }

}
