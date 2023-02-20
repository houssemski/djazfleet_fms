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
class DepartmentsController extends AppController {

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
        $result = $this->verifyUserPermission(SectionsEnum::departement, $user_id, ActionsEnum::view, "Departments", null, "Department" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :

                $conditions=null;


                break;
            case 2 :


                $conditions=array('Department.user_id '=>$user_id);

                break;
            case 3 :

                $conditions=array('Department.user_id !='=>$user_id);

                break;

            default:
                $conditions=null;


        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Department.code' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );



        //Parametrer la pagination

        $this->Department->recursive = 0;
        $this->set('departments', $this->Paginator->paginate());
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
            'order' => array('Department.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('departments', $this->Paginator->paginate('Department', array('OR' => array(
                "LOWER(Department.code) LIKE" => "%$keyword%",
                "LOWER(Department.name) LIKE" => "%$keyword%"))));
        } else {
            $this->Department->recursive = 0;
            $this->set('departments', $this->Paginator->paginate());
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

        if (!$this->Department->exists($id)) {
            throw new NotFoundException(__('Invalid customer department'));
        }
        $options = array('conditions' => array('Department.' . $this->Department->primaryKey => $id));
        $this->set('department', $this->Department->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::departement, $user_id, ActionsEnum::add, "Departments", null, "Department" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Department->create();
            $this->request->data['Department']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Department->save($this->request->data)) {

                $this->Flash->success(__('The department has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The department could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::departement, $user_id, ActionsEnum::edit, "Departments", $id, "Department" ,null);
        if (!$this->Department->exists($id)) {
            throw new NotFoundException(__('Invalid department'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. department cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Department']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Department->save($this->request->data)) {

                $this->Flash->success(__('The department has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The department could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Department.' . $this->Department->primaryKey => $id));
            $this->request->data = $this->Department->find('first', $options);
            //$this->is_opened("Department",'Departments','department',$id);
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
        $this->verifyUserPermission(SectionsEnum::departement, $user_id, ActionsEnum::delete, "Departments", $id, "Department" ,null);
        $this->Department->id = $id;
        if (!$this->Department->exists()) {
            throw new NotFoundException(__('Invalid Department'));
        }

        $this->request->allowMethod('post', 'delete');
        if ($this->Department->delete()) {

            $this->Flash->success(__('The department has been deleted.'));
        } else {

            $this->Flash->error(__('The department could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deletedepartments() {
        $this->setTimeActif();
        $this->autoRender = false;
        // if ($this->isSuperAdmin()) {
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::departement, $user_id, ActionsEnum::delete, "Departments", $id, "Department" ,null);
        $this->Department->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->Department->delete()){
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
        $result = $this->Service->getServiceByForeignKey($id, "department_id");
        if (!empty($result)) {
            $this->Flash->error(__('The Department could not be deleted. '
                . 'Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }

}
