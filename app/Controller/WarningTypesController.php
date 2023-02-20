<?php

App::uses('AppController', 'Controller');
class WarningTypesController extends AppController {


    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    var $helpers = array('Xls');

    /**
     * @param null $params
     * @param null $orderType
     * @return array
     */

    public function getOrder ($params = null, $orderType = null){

        if($orderType == null){
            $orderType = 'DESC';
        }
        if (isset($params) && is_numeric($params)) {
            switch($params){
                case 1 :
                    $order = array('WarningType.code' => $orderType);
                    break;
                case 2 :
                    $order = array('WarningType.name' => $orderType);
                    break;
                case 3 :
                    $order = array('WarningType.id' => $orderType);
                    break;


                default : $order = array('WarningType.id' => $orderType);
            }
            return $order;
        } else {
            $order = array('WarningType.id' => $orderType);

            return $order;
        }
    }
    public function index() {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $result =  $this->verifyUserPermission(SectionsEnum::type_avertissement , $user_id, ActionsEnum::view,
            "WarningTypes", null, "WarningType" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();

        switch($result) {
            case 1 :

                $conditions=null;


                break;
            case 2 :


                $conditions=array('WarningType.user_id '=>$user_id);

                break;
            case 3 :

                $conditions=array('WarningType.user_id !='=>$user_id);

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

        $this->WarningType->recursive = 0;
        $this->set('warningTypes', $this->Paginator->paginate());
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
            'order' => array('WarningType.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('warningTypes', $this->Paginator->paginate('WarningType', array('OR' => array(
                "LOWER(WarningType.code) LIKE" => "%$keyword%",
                "LOWER(WarningType.name) LIKE" => "%$keyword%"))));
        } else {
            $this->WarningType->recursive = 0;
            $this->set('warningTypes', $this->Paginator->paginate());
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

        if (!$this->WarningType->exists($id)) {
            throw new NotFoundException(__('Invalid type'));
        }
        $options = array('conditions' => array('WarningType.' . $this->WarningType->primaryKey => $id));
        $this->set('warningType', $this->WarningType->find('first', $options));
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
        $this->verifyUserPermission(SectionsEnum::type_avertissement, $user_id, ActionsEnum::add,
            "WarningTypes", null, "WarningType" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->WarningType->create();
            $this->request->data['WarningType']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->WarningType->save($this->request->data)) {

                $this->Flash->success(__('The type has been saved.'));
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
        $this->verifyUserPermission(SectionsEnum::type_avertissement, $user_id, ActionsEnum::edit,
            "WarningTypes", $id, "WarningType" ,null);
        if (!$this->WarningType->exists($id)) {
            throw new NotFoundException(__('Invalid type'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Type cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['WarningType']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->WarningType->save($this->request->data)) {

                $this->Flash->success(__('The type has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('WarningType.' . $this->WarningType->primaryKey => $id));
            $this->request->data = $this->WarningType->find('first', $options);
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
        $this->verifyUserPermission(SectionsEnum::type_avertissement, $user_id, ActionsEnum::delete,
            "WarningTypes", $id, "WarningType" ,null);
        $this->WarningType->id = $id;
        if (!$this->WarningType->exists()) {
            throw new NotFoundException(__('Invalid type'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->WarningType->delete()) {

            $this->Flash->success(__('The type has been deleted.'));
        } else {

            $this->Flash->error(__('The type could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteTypes() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');

        $this->verifyUserPermission(SectionsEnum::type_avertissement, $user_id, ActionsEnum::delete,
            "WarningTypes", $id, "WarningType" ,null);
        $this->WarningType->id = $id;
        $this->request->allowMethod('post', 'delete');
        if($this->WarningType->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }

    }
    private function verifyDependences($id){
        $this->setTimeActif();
        $result = $this->WarningType->Warning->find('first', array("conditions" => array("warning_type_id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The type could not be deleted. Please remove dependencies in advance.'));
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


    function addType()
    {
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::type_avertissement, $userId, ActionsEnum::add,
            "WarningTypes", null, "WarningType", 1, 1);


        $this->set(compact('result'));
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened

        if (!empty($this->request->data)) {
            if ($this->WarningType->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $warningTypeId = $this->WarningType->getLastInsertId();
                $this->set('warningTypeId', $warningTypeId);
            }
        }
    }

    function editType()
    {
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::type_avertissement, $userId, ActionsEnum::edit,
            "WarningTypes", null, "WarningType", 1, 1);
        $warningTypeId = $this->params['pass']['0'];
        $this->set(compact('result', 'type', 'warningTypeId'));
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened

        if (!empty($this->request->data)) {
            if ($this->WarningType->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $warningTypeId = $this->request->data['WarningType']['id'];
                $this->set('warningTypeId', $warningTypeId);
            }
        }else{
            $options = array('conditions' => array('WarningType.' . $this->WarningType->primaryKey => $warningTypeId));
            $this->request->data = $this->WarningType->find('first', $options);
        }
    }

    function getTypes($warningTypeId){
        $this->layout = 'ajax';
        $types = $this->WarningType->getWarningTypes('list');

        $this->set('selectBox', $types);
        $this->set('selectedId', $warningTypeId);
    }


}