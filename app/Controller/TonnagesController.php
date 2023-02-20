<?php
/**
 * Created by PhpStorm.
 * User: kahina
 * Date: 29/12/2015
 * Time: 15:21
 */


App::uses('AppController', 'Controller');

/**
 * Department Controller
 *
 * @property Department $Department
 * @property Service $Service
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class TonnagesController extends AppController {

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
        $result = $this->verifyUserPermission(SectionsEnum::departement, $user_id, ActionsEnum::view, "Tonnages", null, "Tonnage" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :

                $conditions=null;


                break;
            case 2 :


                $conditions=array('Tonnage.user_id '=>$user_id);

                break;
            case 3 :

                $conditions=array('Tonnage.user_id !='=>$user_id);

                break;

            default:
                $conditions=null;


        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Tonnage.code' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );



        //Parametrer la pagination

        $this->Tonnage->recursive = 0;
        $this->set('tonnages', $this->Paginator->paginate());
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
            'order' => array('Tonnage.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('tonnages', $this->Paginator->paginate('Tonnage', array('OR' => array(
                "LOWER(Tonnage.code) LIKE" => "%$keyword%",
                "LOWER(Tonnage.name) LIKE" => "%$keyword%"))));
        } else {
            $this->Tonnage->recursive = 0;
            $this->set('tonnages', $this->Paginator->paginate());
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

        if (!$this->Tonnage->exists($id)) {
            throw new NotFoundException(__('Invalid customer tonnage'));
        }
        $options = array('conditions' => array('Tonnage.' . $this->Tonnage->primaryKey => $id));
        $this->set('tonnage', $this->Tonnage->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::departement, $user_id, ActionsEnum::add, "Tonnages", null, "Tonnage" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Tonnage->create();
            $this->request->data['Tonnage']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Tonnage->save($this->request->data)) {

                $this->Flash->success(__('The tonnage has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The tonnage could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::departement, $user_id, ActionsEnum::edit, "Tonnages", $id, "Tonnage" ,null);
        if (!$this->Tonnage->exists($id)) {
            throw new NotFoundException(__('Invalid tonnage'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Tonnage cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Tonnage']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Tonnage->save($this->request->data)) {

                $this->Flash->success(__('The tonnage has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The tonnage could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Tonnage.' . $this->Tonnage->primaryKey => $id));
            $this->request->data = $this->Tonnage->find('first', $options);
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
        $this->verifyUserPermission(SectionsEnum::departement, $user_id, ActionsEnum::delete, "Tonnages", $id, "Tonnage" ,null);
        $this->Tonnage->id = $id;
        if (!$this->Tonnage->exists()) {
            throw new NotFoundException(__('Invalid tonnage'));
        }

        $this->request->allowMethod('post', 'delete');
        if ($this->Tonnage->delete()) {

            $this->Flash->success(__('The tonnage has been deleted.'));
        } else {

            $this->Flash->error(__('The tonnage could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteTonnages() {
        $this->setTimeActif();
        $this->autoRender = false;
        // if ($this->isSuperAdmin()) {
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::departement, $user_id, ActionsEnum::delete, "Tonnages", $id, "Tonnage" ,null);
        $this->Tonnage->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->Tonnage->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }

    }
    private function verifyDependences($id){
        $this->setTimeActif();
       /* $result = $this->Service->getServiceByForeignKey($id, "department_id");
        if (!empty($result)) {
            $this->Flash->error(__('The Department could not be deleted. '
                . 'Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }*/
    }

}
