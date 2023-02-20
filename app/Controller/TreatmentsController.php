<?php
/**
 * Created by PhpStorm.
 * User: kahina
 * Date: 29/12/2015
 * Time: 15:21
 */


App::uses('AppController', 'Controller');

/**
 * CustomerCategories Controller
 *
 * @property  Treatment $Treatment
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class TreatmentsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session','Security');
    public $uses = array('Treatment','Department');
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
        $result = $this->verifyUserPermission(SectionsEnum::traitement, $user_id, ActionsEnum::view,
            "Treatments", null, "Treatment" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :

                $conditions=null;


                break;
            case 2 :


                $conditions=array('Treatment.user_id '=>$user_id);

                break;
            case 3 :

                $conditions=array('Treatment.user_id !='=>$user_id);

                break;

            default:
                $conditions=null;


        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Treatment.code' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );



        //Parametrer la pagination

        $this->Treatment->recursive = 0;
        $this->set('treatments', $this->Paginator->paginate());
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
            'order' => array('Treatment.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('treatments', $this->Paginator->paginate('Treatment', array('OR' => array(
                "LOWER(Treatment.code) LIKE" => "%$keyword%",
                "LOWER(Treatment.name) LIKE" => "%$keyword%"))));
        } else {
            $this->Treatment->recursive = 0;
            $this->set('treatments', $this->Paginator->paginate());
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

        if (!$this->Treatment->exists($id)) {
            throw new NotFoundException(__('Invalid treatment'));
        }
        $options = array('conditions' => array('Treatment.' . $this->Treatment->primaryKey => $id));
        $this->set('treatment', $this->Treatment->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::traitement, $user_id, ActionsEnum::add,
            "Treatments", null, "Treatment" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error( __('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Treatment->create();
            $this->request->data['Treatment']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Treatment->save($this->request->data)) {

                $this->Flash->success(__('The treatment has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The treatment could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::traitement, $user_id, ActionsEnum::edit,
            "Treatments", $id, "Treatment" ,null);
        if (!$this->Treatment->exists($id)) {
            throw new NotFoundException(__('Invalid treatment'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Treatment cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Treatment']['modified_id'] = $this->Session->read('Auth.User.id');
            if ($this->Treatment->save($this->request->data)) {

                $this->Flash->success(__('The treatment has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The treatment could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Treatment.' . $this->Treatment->primaryKey => $id));
            $this->request->data = $this->Treatment->find('first', $options);


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
        $this->verifyUserPermission(SectionsEnum::traitement, $user_id, ActionsEnum::delete,
            "Treatments", $id, "Treatment" ,null);
        $this->Treatment->id = $id;
        if (!$this->Treatment->exists()) {
            throw new NotFoundException(__('Invalid treatment'));
        }

        $this->request->allowMethod('post', 'delete');
        if ($this->Treatment->delete()) {

            $this->Flash->success(__('The treatment has been deleted.'));
        } else {

            $this->Flash->error(__('The treatment could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteTreatments() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::traitement, $user_id, ActionsEnum::delete,
            "Treatments", $id, "Treatment" ,null);
        $this->Treatment->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->Treatment->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }

    }
    private function verifyDependences($id){
        $this->setTimeActif();
        $result = $this->Treatment->ComplaintResponse->find('first', array("conditions" => array("Treatment.id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The treatment could not be deleted. '
                . 'Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }

    }
    function export() {
        $this->setTimeActif();
        $treatments = $this->Treatment->find('all', array(
            'order' => 'Treatment.name asc',
            'recursive' => 2
        ));
        $this->set('models', $treatments);
    }

}
