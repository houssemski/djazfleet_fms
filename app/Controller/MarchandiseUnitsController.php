<?php

App::uses('AppController', 'Controller');
class MarchandiseUnitsController extends AppController {


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
                    $order = array('MarchandiseUnit.code' => $orderType);
                    break;
                case 2 :
                    $order = array('MarchandiseUnit.name' => $orderType);
                    break;
                case 3 :
                    $order = array('MarchandiseUnit.id' => $orderType);
                    break;


                default : $order = array('MarchandiseUnit.id' => $orderType);
            }
            return $order;
        } else {
            $order = array('MarchandiseUnit.id' => $orderType);

            return $order;
        }
    }
    public function index() {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $result =  $this->verifyUserPermission(SectionsEnum::unite_marchandise, $user_id, ActionsEnum::view,
            "MarchandiseUnits", null, "MarchandiseUnit" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();
        switch($result) {
            case 1 :

                $conditions=null;


                break;
            case 2 :


                    $conditions=array('MarchandiseUnit.user_id '=>$user_id);

                break;
            case 3 :

                    $conditions=array('MarchandiseUnit.user_id !='=>$user_id);

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

        $this->MarchandiseUnit->recursive = 0;
        $this->set('marchandiseUnits', $this->Paginator->paginate());
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
            'order' => array('MarchandiseUnit.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('marchandiseUnits', $this->Paginator->paginate('MarchandiseUnit', array('OR' => array(
                            "LOWER(MarchandiseUnit.code) LIKE" => "%$keyword%",
                            "LOWER(MarchandiseUnit.name) LIKE" => "%$keyword%"))));
        } else {
            $this->MarchandiseUnit->recursive = 0;
            $this->set('marchandiseUnits', $this->Paginator->paginate());
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

        if (!$this->MarchandiseUnit->exists($id)) {
            throw new NotFoundException(__('Invalid Marchandise Unit'));
        }
        $options = array('conditions' => array('MarchandiseUnit.' . $this->MarchandiseUnit->primaryKey => $id));
        $this->set('marchandiseUnit', $this->MarchandiseUnit->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::unite_marchandise, $user_id, ActionsEnum::add,
            "MarchandiseUnits", null, "MarchandiseUnit" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->success(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->MarchandiseUnit->create();
            $this->request->data['MarchandiseUnit']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->MarchandiseUnit->save($this->request->data)) {

                $this->Flash->success(__('The Marchandise Unit has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->success(__('The Marchandise Unit could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::unite_marchandise, $user_id, ActionsEnum::edit,
            "MarchandiseUnits", $id, "MarchandiseUnit" ,null);
        if (!$this->MarchandiseUnit->exists($id)) {
            throw new NotFoundException(__('Invalid Marchandise Unit'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Marchandise Unit cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['MarchandiseUnit']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->MarchandiseUnit->save($this->request->data)) {

                $this->Flash->success(__('The Marchandise Unit has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The Marchandise Unit could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('MarchandiseUnit.' . $this->MarchandiseUnit->primaryKey => $id));
            $this->request->data = $this->MarchandiseUnit->find('first', $options);
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
        $this->verifyUserPermission(SectionsEnum::unite_marchandise, $user_id, ActionsEnum::delete,
            "MarchandiseUnits", $id, "MarchandiseUnit" ,null);
        $this->MarchandiseUnit->id = $id;
        if (!$this->MarchandiseUnit->exists()) {
            throw new NotFoundException(__('Invalid unit'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->MarchandiseUnit->delete()) {

            $this->Flash->success(__('The Marchandise Unit has been deleted.'));
        } else {

            $this->Flash->error(__('The Marchandise Unit could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteUnits() {
        $this->setTimeActif();
        $this->autoRender = false;
            $id = filter_input(INPUT_POST, "id");
            $user_id=$this->Auth->user('id');

        $this->verifyUserPermission(SectionsEnum::unite_marchandise, $user_id, ActionsEnum::delete,
            "MarchandiseUnits", $id, "MarchandiseUnit" ,null);
            $this->MarchandiseUnit->id = $id;
           // $this->verifyDependences($id);
            $this->request->allowMethod('post', 'delete');
            if($this->MarchandiseUnit->delete()){
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
        $result = $this->MarchandiseUnit->Marchandise->find('first', array("conditions" => array("marchandise_unit_id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The Marchandise Unit could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        } 
    }
    function export() {
        $this->setTimeActif();
            $Units = $this->MarchandiseUnit->find('all', array(
                'order' => 'MarchandiseUnit.name asc',
                'recursive' => 2
            ));
        $this->set('models', $Units);
    }


}