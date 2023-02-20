<?php
/**
 * Created by PhpStorm.
 * User: kahina
 * Date: 29/12/2015
 * Time: 15:21
 */


App::uses('AppController', 'Controller');

/**
 * Services Controller
 *
 * @property Service $Service
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ServicesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session','Security');
    public $uses = array('Service','Department');
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
        $result = $this->verifyUserPermission(SectionsEnum::service, $user_id, ActionsEnum::view,
            "Services", null, "Service" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :

                $conditions=null;


                break;
            case 2 :


                $conditions=array('Service.user_id '=>$user_id);

                break;
            case 3 :

                $conditions=array('Service.user_id !='=>$user_id);

                break;

            default:
                $conditions=null;


        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Service.code' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );



        //Parametrer la pagination

        $this->Service->recursive = 0;
        $this->set('services', $this->Paginator->paginate());
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
            'order' => array('Service.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('services', $this->Paginator->paginate('Service', array('OR' => array(
                "LOWER(Service.code) LIKE" => "%$keyword%",
                "LOWER(Service.name) LIKE" => "%$keyword%"))));
        } else {
            $this->Service->recursive = 0;
            $this->set('services', $this->Paginator->paginate());
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

        if (!$this->Service->exists($id)) {
            throw new NotFoundException(__('Invalid customer service'));
        }
        $options = array('conditions' => array('Service.' . $this->Service->primaryKey => $id));
        $this->set('service', $this->Service->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::service, $user_id, ActionsEnum::add,
            "Services", null, "Service" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error( __('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Service->create();
            $this->request->data['Service']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Service->save($this->request->data)) {

                $this->Flash->success(__('The service has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The service could not be saved. Please, try again.'));
            }
        }
        $departments = $this->Department->find('list');
        $this->set(compact('departments'));
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
        $this->verifyUserPermission(SectionsEnum::service, $user_id, ActionsEnum::edit,
            "Services", $id, "Service" ,null);
        if (!$this->Service->exists($id)) {
            throw new NotFoundException(__('Invalid service'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Service cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Service']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Service->save($this->request->data)) {

                $this->Flash->success(__('The service has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The service could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Service.' . $this->Service->primaryKey => $id));
            $this->request->data = $this->Service->find('first', $options);

            $departments = $this->Department->find('list');
            $suppliers = $this->Supplier->getSuppliersByParams(1, 1, null, array(2, 3), null, $this->request->data['Service']['supplier_id']);
            $supplierId = $this->request->data['Service']['supplier_id'];

            $this->set(compact('departments','suppliers','supplierId'));
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
        $this->verifyUserPermission(SectionsEnum::service, $user_id, ActionsEnum::delete,
            "Services", $id, "Service" ,null);
        $this->Service->id = $id;
        if (!$this->Service->exists()) {
            throw new NotFoundException(__('Invalid Service'));
        }

        $this->request->allowMethod('post', 'delete');
        if ($this->Service->delete()) {

            $this->Flash->success(__('The service has been deleted.'));
        } else {

            $this->Flash->error(__('The service could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteservices() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::service, $user_id, ActionsEnum::delete,
            "Services", $id, "Service" ,null);
        $this->Service->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->Service->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }

    }
    private function verifyDependences($id){
        $this->setTimeActif();
        $result = $this->Service->Customer->find('first', array("conditions" => array("Service.id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The Service could not be deleted. '
                . 'Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        $this->loadModel('User');
        $result = $this->User->find('first', array("conditions" => array("User.service_id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The Service could not be deleted. '
                . 'Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }
    function export() {
        $this->setTimeActif();
        $services = $this->Service->find('all', array(
            'order' => 'Service.name asc',
            'recursive' => 2
        ));
        $this->set('models', $services);
    }

    /**
     * @param null $supplierId
     */
    public function getServicesBySupplier($supplierId = null){
        $this->layout = 'ajax';
        $services = $this->Service->getServicesBySupplierId('list', $supplierId);
        $this->set('services', $services);

    }


}
