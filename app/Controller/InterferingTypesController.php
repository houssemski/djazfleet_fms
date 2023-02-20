<?php

App::uses('AppController', 'Controller');

/**
 * InterferingTypes Controller
 *
 * @property InterferingType $InterferingType
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class InterferingTypesController extends AppController {

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
        $result =  $this->verifyUserPermission(SectionsEnum::type_intervenant, $user_id, ActionsEnum::view,
            "InterferingTypes", null, "InterferingType" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        //Parametrer la pagination
        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                    $conditions=array('InterferingType.user_id '=>$user_id);

                break;
            case 3 :
                    $conditions=array('InterferingType.user_id !='=>$user_id);
                break;

            default:
                $conditions=null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('InterferingType.code' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );


        $this->InterferingType->recursive = 0;
        $this->set('interferingTypes', $this->Paginator->paginate());
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
            'order' => array('InterferingType.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('interferingTypes', $this->Paginator->paginate('InterferingType', array('OR' => array(
                            "LOWER(InterferingType.code) LIKE" => "%$keyword%",
                            "LOWER(InterferingType.name) LIKE" => "%$keyword%"))));
        } else {
            $this->InterferingType->recursive = 0;
            $this->set('interferingTypes', $this->Paginator->paginate());
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
        if (!$this->InterferingType->exists($id)) {
            throw new NotFoundException(__('Invalid interfering type'));
        }
        $options = array('conditions' => array('InterferingType.' . $this->InterferingType->primaryKey => $id));
        $this->set('interferingType', $this->InterferingType->find('first', $options));
    }
    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::type_intervenant, $user_id, ActionsEnum::add,
            "InterferingTypes", null, "InterferingType" ,null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->InterferingType->create();
            $this->request->data['InterferingType']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->InterferingType->save($this->request->data)) {
                $this->Flash->success(__('The interfering type has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The interfering type could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::type_intervenant, $user_id, ActionsEnum::edit,
            "InterferingTypes", $id, "InterferingType" ,null);
        if (!$this->InterferingType->exists($id)) {
            throw new NotFoundException(__('Invalid interfering type'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Interfering type cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['InterferingType']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->InterferingType->save($this->request->data)) {
                $this->Flash->success(__('The interfering type has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The interfering type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('InterferingType.' . $this->InterferingType->primaryKey => $id));
            $this->request->data = $this->InterferingType->find('first', $options);
           // $this->is_opened("InterferingType",'InterferingTypes','interfering type',$id);
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
        $this->verifyUserPermission(SectionsEnum::type_intervenant, $user_id, ActionsEnum::delete,
            "InterferingTypes", $id, "InterferingType" ,null);
        $this->InterferingType->id = $id;
        if (!$this->InterferingType->exists()) {
            throw new NotFoundException(__('Invalid interfering type'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->InterferingType->delete()) {
            $this->Flash->success(__('The interfering type has been deleted.'));
        } else {
            $this->Flash->error(__('The interfering type could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }
    public function deleteinterferingtypes() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id=filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::type_intervenant, $user_id, ActionsEnum::delete,
            "InterferingTypes", $id, "InterferingType" ,null);

            $this->InterferingType->id = $id;
            $this->request->allowMethod('post', 'delete');
            if($this->InterferingType->delete()){
                echo json_encode(array("response" => "true"));
            }else{
                echo json_encode(array("response" => "false"));
            }

    }

}
