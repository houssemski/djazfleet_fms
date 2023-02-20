<?php
/**
 * Created by PhpStorm.
 * User: Kahina
 * Date: 14-05-2020
 * Time: 14:43
 */


App::uses('AppController', 'Controller');

/**
 * Penalties Controller
 *
 * @property Penalty $Penalty
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class PenaltiesController extends AppController {
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
        $result = $this->verifyUserPermission(SectionsEnum::penalite, $userId, ActionsEnum::view, "Penalties", null, "Penalty" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                $conditions=array('Penalty.user_id '=>$userId);
                break;
            case 3 :
                $conditions=array('Penalty.user_id !='=>$userId);
                break;

            default:
                $conditions=null;
        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Penalty.code' => 'ASC', 'Penalty.name' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );



        //Parametrer la pagination

        $this->Penalty->recursive = 0;
        $this->set('penalties', $this->Paginator->paginate());
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
            'order' => array('Penalty.code' => 'ASC', 'Penalty.name' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('penalties', $this->Paginator->paginate('Penalty', array(
                'OR' => array(
                    "LOWER(Penalty.code) LIKE" => "%$keyword%",
                    "LOWER(Penalty.name) LIKE" => "%$keyword%"))));
        } else {
            $this->Penalty->recursive = 0;
            $this->set('Penalties', $this->Paginator->paginate());
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

        if (!$this->Penalty->exists($id)) {
            throw new NotFoundException(__('Invalid penalty.'));
        }
        $options = array('conditions' => array('Penalty.' . $this->Penalty->primaryKey => $id));
        $this->set('penalty', $this->Penalty->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::penalite, $user_id, ActionsEnum::add, "Penalties", null, "Penalty" ,null);

        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Penalty->create();
            $this->request->data['Penalty']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Penalty->save($this->request->data)) {

                $this->Flash->success(__('The penalty has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The penalty could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::penalite, $user_id, ActionsEnum::edit, "Penalties", $id, "Penalty" ,null);
        if (!$this->Penalty->exists($id)) {
            throw new NotFoundException(__('Invalid penalty'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Penalty cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Penalty']['modified_id'] = $this->Session->read('Auth.User.id');
            if ($this->Penalty->save($this->request->data)) {

                $this->Flash->success(__('The penalty has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The penalty could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Penalty.' . $this->Penalty->primaryKey => $id));
            $this->request->data = $this->Penalty->find('first', $options);

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
        $this->verifyUserPermission(SectionsEnum::penalite, $user_id, ActionsEnum::delete, "Penalties", $id, "Penalty" ,null);
        $this->Penalty->id = $id;
        if (!$this->Penalty->exists()) {
            throw new NotFoundException(__('Invalid penalty'));
        }
        //$this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Penalty->delete()) {

            $this->Flash->success(__('The penalty has been deleted.'));
        } else {

            $this->Flash->error(__('The penalty could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteCauses() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::penalite, $user_id, ActionsEnum::delete, "Penalties", $id, "Penalty" ,null);
        $this->Penalty->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->Penalty->delete()){
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
        $this->loadModel('TransportBill');
        $result = $this->Complaint->getCustomerByForeignKey($id, 'complaint_cause_id');
        if (!empty($result)) {
            $this->Flash->error(__('The complaint cause could not be deleted. '
                . 'Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }

}
