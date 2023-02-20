<?php

App::uses('AppController', 'Controller');
class MarchandiseTypesController extends AppController {


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

    public function getOrder ($params = null, $orderType = null ){

        if($orderType == null){
            $orderType = 'DESC';
        }
        if (isset($params) && is_numeric($params)) {
            switch($params){
                case 1 :
                    $order = array('MarchandiseType.code' => $orderType);
                    break;
                case 2 :
                    $order = array('MarchandiseType.name' => $orderType);
                    break;
                case 3 :
                    $order = array('MarchandiseType.id' => $orderType);
                    break;


                default : $order = array('MarchandiseType.id' => $orderType);
            }
            return $order;
        } else {
            $order = array('MarchandiseType.id' => $orderType);

            return $order;
        }
    }
    public function index() {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $result =  $this->verifyUserPermission(SectionsEnum::type_marchandise, $user_id, ActionsEnum::view,
            "MarchandiseTypes", null, "MarchandiseType" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'], $this->params['pass']['2']) : $this->getOrder();

        switch($result) {
            case 1 :

                $conditions=null;


                break;
            case 2 :


                    $conditions=array('MarchandiseType.user_id '=>$user_id);

                break;
            case 3 :

                    $conditions=array('MarchandiseType.user_id !='=>$user_id);

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

        $this->MarchandiseType->recursive = 0;
        $this->set('marchandisetypes', $this->Paginator->paginate());
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
            'order' => array('MarchandiseType.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('marchandiseTypes', $this->Paginator->paginate('MarchandiseType', array('OR' => array(
                            "LOWER(MarchandiseType.code) LIKE" => "%$keyword%",
                            "LOWER(MarchandiseType.name) LIKE" => "%$keyword%"))));
        } else {
            $this->MarchandiseType->recursive = 0;
            $this->set('marchandiseTypes', $this->Paginator->paginate());
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

        if (!$this->MarchandiseType->exists($id)) {
            throw new NotFoundException(__('Invalid Marchandise type'));
        }
        $options = array('conditions' => array('MarchandiseType.' . $this->MarchandiseType->primaryKey => $id));
        $this->set('marchandiseType', $this->MarchandiseType->find('first', $options));
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
        $this->verifyUserPermission(SectionsEnum::type_marchandise, $user_id, ActionsEnum::add,
            "MarchandiseTypes", null, "MarchandiseType" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->MarchandiseType->create();
            $this->request->data['MarchandiseType']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->MarchandiseType->save($this->request->data)) {

                $this->Flash->success(__('The Marchandise type has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The Marchandise type could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::type_marchandise, $user_id, ActionsEnum::edit,
            "MarchandiseTypes", $id, "MarchandiseType" ,null);
        if (!$this->MarchandiseType->exists($id)) {
            throw new NotFoundException(__('Invalid Marchandise type'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Marchandise type cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['MarchandiseType']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->MarchandiseType->save($this->request->data)) {

                $this->Flash->success(__('The Marchandise type has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The Marchandise type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('MarchandiseType.' . $this->MarchandiseType->primaryKey => $id));
            $this->request->data = $this->MarchandiseType->find('first', $options);
            //$this->is_opened("MarchandiseType",'MarchandiseTypes','Marchandise type',$id);
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
        $this->verifyUserPermission(SectionsEnum::type_marchandise, $user_id, ActionsEnum::delete,
            "MarchandiseTypes", $id, "MarchandiseType" ,null);
        $this->MarchandiseType->id = $id;
        if (!$this->MarchandiseType->exists()) {
            throw new NotFoundException(__('Invalid customer category'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->MarchandiseType->delete()) {

            $this->Flash->success(__('The Marchandise type has been deleted.'));
        } else {

            $this->Flash->error(__('The Marchandise type could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deletetypes() {
        $this->setTimeActif();
        $this->autoRender = false;
            $id = filter_input(INPUT_POST, "id");
            $user_id=$this->Auth->user('id');

        $this->verifyUserPermission(SectionsEnum::type_marchandise, $user_id, ActionsEnum::delete,
            "MarchandiseTypes", $id, "MarchandiseType" ,null);
            $this->MarchandiseType->id = $id;
            $this->request->allowMethod('post', 'delete');
            if($this->MarchandiseType->delete()){
                echo json_encode(array("response" => "true"));
            }else{
                echo json_encode(array("response" => "false"));
            }

    }
    private function verifyDependences($id){
        $this->setTimeActif();
        $result = $this->MarchandiseType->Marchandise->find('first', array("conditions" => array("marchandise_type_id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The Marchandise type could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        } 
    }
    function export() {
        $this->setTimeActif();
            $types = $this->MarchandiseType->find('all', array(
                'order' => 'MarchandiseType.name asc',
                'recursive' => 2
            ));
        $this->set('models', $types);
    }


}