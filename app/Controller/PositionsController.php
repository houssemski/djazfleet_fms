<?php
App::uses('AppController', 'Controller');
/**
 * Positions Controller
 *
 * @property Position $Position
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class PositionsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
	public $components = array('Paginator', 'Session','Security');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
         $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::position_pneu, $user_id, ActionsEnum::view,
            "Positions", null, "Position" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                $conditions=array('Position.user_id '=>$user_id);
                break;
            case 3 :
                $conditions=array('Position.user_id !='=>$user_id);
                break;

            default:
                $conditions=null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Position.code' => 'ASC', 'Position.name' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );


        $this->Position->recursive = 0;
        $this->set('positions', $this->Paginator->paginate());
        $this->set(compact('limit'));
    }

    public function search() {
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'],
                $this->request->params['action'], $this->request->data['keyword']);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Position.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('positions', $this->Paginator->paginate('Position', array('OR' => array(
                "LOWER(Position.code) LIKE" => "%$keyword%",
                "LOWER(Position.name) LIKE" => "%$keyword%"))));
        } else {
            $this->Position->recursive = 0;
            $this->set('Positions', $this->Paginator->paginate());
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
        if (!$this->Position->exists($id)) {
            throw new NotFoundException(__('Invalid position'));
        }
        $options = array('conditions' => array('Position.' . $this->Position->primaryKey => $id));
        $this->set('position', $this->Position->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::position_pneu, $user_id, ActionsEnum::add, "Positions",
            null, "Position" ,null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->Position->create();
            $this->request->data['Position']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Position->save($this->request->data)) {
                $this->Flash->success(__('The position has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The position could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::position_pneu, $user_id, ActionsEnum::edit, "Positions",
            $id, "Position" ,null);
        if (!$this->Position->exists($id)) {
            throw new NotFoundException(__('Invalid Position'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Position cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Position']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Position->save($this->request->data)) {
                $this->Flash->success(__('The position has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The position could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Position.' . $this->Position->primaryKey => $id));
            $this->request->data = $this->Position->find('first', $options);
          
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
        $this->verifyUserPermission(SectionsEnum::position_pneu, $user_id, ActionsEnum::delete, "Positions",
            $id, "Position" ,null);
        $this->Position->id = $id;
        if (!$this->Position->exists()) {
            throw new NotFoundException(__('Invalid Position'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Position->delete()) {
            $this->Flash->success(__('The position has been deleted.'));
        } else {
            $this->Flash->error(__('The position could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }
    public function deletePositions() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::position_pneu, $user_id, ActionsEnum::delete, "Positions",
            $id, "Position" ,null);

        $this->Position->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->Position->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }

    }

    private function verifyDependences($id){
        $this->setTimeActif();
        $result = $this->Position->Shifting->find('first', array("conditions" => array("Position.id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The position could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        
    }
   
}
