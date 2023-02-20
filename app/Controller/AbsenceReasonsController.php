<?php

App::uses('AppController', 'Controller');
class AbsenceReasonsController extends AppController {


    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    var $helpers = array('Xls');


    public function getOrder ($params = null , $orderType = null){

        if($orderType == null){
            $orderType = 'DESC';
        }
        if (isset($params) && is_numeric($params)) {
            switch($params){
                case 1 :
                    $order = array('AbsenceReason.code' => $orderType);
                    break;
                case 2 :
                    $order = array('AbsenceReason.name' => $orderType);
                    break;
                case 3 :
                    $order = array('AbsenceReason.id' => $orderType);
                    break;


                default : $order = array('AbsenceReason.id' => $orderType);
            }
            return $order;
        } else {
            $order = array('AbsenceReason.id' => $orderType);

            return $order;
        }
    }
    public function index() {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $result =  $this->verifyUserPermission(SectionsEnum::raison_absence , $user_id, ActionsEnum::view,
            "AbsenceReasons", null, "AbsenceReason" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();

        switch($result) {
            case 1 :

                $conditions=null;


                break;
            case 2 :


                $conditions=array('AbsenceReason.user_id '=>$user_id);

                break;
            case 3 :

                $conditions=array('AbsenceReason.user_id !='=>$user_id);

                break;

            default:
                $conditions=null;


        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => $order,
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );



        //Parametrer la pagination

        $this->AbsenceReason->recursive = 0;
        $this->set('absenceReasons', $this->Paginator->paginate());
        $this->set(compact('limit','order'));
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
            'order' => array('AbsenceReason.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('absenceReasons', $this->Paginator->paginate('AbsenceReason', array('OR' => array(
                "LOWER(AbsenceReason.code) LIKE" => "%$keyword%",
                "LOWER(AbsenceReason.name) LIKE" => "%$keyword%"))));
        } else {
            $this->AbsenceReason->recursive = 0;
            $this->set('absenceReasons', $this->Paginator->paginate());
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

        if (!$this->AbsenceReason->exists($id)) {
            throw new NotFoundException(__('Invalid reason.'));
        }
        $options = array('conditions' => array('AbsenceReason.' . $this->AbsenceReason->primaryKey => $id));
        $this->set('absenceReason', $this->AbsenceReason->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();
        //$this->verifyAuditor("CustomerCategories");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::raison_absence, $user_id, ActionsEnum::add,
            "AbsenceReasons", null, "AbsenceReason" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->AbsenceReason->create();
            $this->request->data['AbsenceReason']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->AbsenceReason->save($this->request->data)) {

                $this->Flash->success(__('The reason has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The type could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::raison_absence, $user_id, ActionsEnum::edit,
            "AbsenceReasons", $id, "AbsenceReason" ,null);
        if (!$this->AbsenceReason->exists($id)) {
            throw new NotFoundException(__('Invalid reason.'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Reason cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['AbsenceReason']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->AbsenceReason->save($this->request->data)) {

                $this->Flash->success(__('The reason has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The reason could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('AbsenceReason.' . $this->AbsenceReason->primaryKey => $id));
            $this->request->data = $this->AbsenceReason->find('first', $options);
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
        $this->verifyUserPermission(SectionsEnum::raison_absence, $user_id, ActionsEnum::delete,
            "AbsenceReasons", $id, "AbsenceReason" ,null);
        $this->AbsenceReason->id = $id;
        if (!$this->AbsenceReason->exists()) {
            throw new NotFoundException(__('Invalid reason.'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->AbsenceReason->delete()) {

            $this->Flash->success(__('The reason has been deleted.'));
        } else {

            $this->Flash->error(__('The reason could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteReasons() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');

        $this->verifyUserPermission(SectionsEnum::raison_absence, $user_id, ActionsEnum::delete,
            "AbsenceReasons", $id, "AbsenceReason" ,null);
        $this->AbsenceReason->id = $id;
        $this->request->allowMethod('post', 'delete');
        if($this->AbsenceReason->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }

    }
    private function verifyDependences($id){
        $this->setTimeActif();
        $result = $this->AbsenceReason->Absence->find('first', array("conditions" => array("absence_reason_id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The reason could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }
    function export() {
        $this->setTimeActif();
        $types = $this->WarningType->find('all', array(
            'order' => 'WarningType.name asc',
            'recursive' => 2
        ));
        $this->set('models', $types);
    }


    function addReason()
    {
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::raison_absence, $userId, ActionsEnum::add,
            "AbsenceReasons", null, "AbsenceReason", 1, 1);


        $this->set(compact('result'));
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened

        if (!empty($this->request->data)) {
            if ($this->AbsenceReason->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $absenceReasonId = $this->AbsenceReason->getLastInsertId();
                $this->set('absenceReasonId', $absenceReasonId);
            }
        }
    }

    function editReason()
    {
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::type_avertissement, $userId, ActionsEnum::edit,
            "AbsenceReasons", null, "AbsenceReason", 1, 1);
        $absenceReasonId = $this->params['pass']['0'];
        $this->set(compact('result', 'type', 'absenceReasonId'));
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened

        if (!empty($this->request->data)) {
            if ($this->AbsenceReason->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $absenceReasonId = $this->request->data['AbsenceReason']['id'];
                $this->set('absenceReasonId', $absenceReasonId);
            }
        }else{
            $options = array('conditions' => array('AbsenceReason.' . $this->AbsenceReason->primaryKey => $absenceReasonId));
            $this->request->data = $this->AbsenceReason->find('first', $options);
        }
    }

    function getReasons($absenceReasonId){
        $this->layout = 'ajax';
        $reasons = $this->AbsenceReason->getAbsenceReasons('list');

        $this->set('selectBox', $reasons);
        $this->set('selectedId', $absenceReasonId);
    }


}