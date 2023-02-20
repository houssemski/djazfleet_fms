<?php

App::uses('AppController', 'Controller');

/**
 * Interferings Controller
 *
 * @property Interfering $Interfering
 * @property InterferingType $InterferingType
 * @property EventCategoryInterfering $EventCategoryInterfering
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class InterferingsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session','Security');
    public $uses = array('Interfering', 'InterferingType');
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
        $result =  $this->verifyUserPermission(SectionsEnum::intervenant, $user_id, ActionsEnum::view, "Interferings",
            null, "Interfering",null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();


        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                    $conditions=array('Interfering.user_id '=>$user_id);

                break;
            case 3 :
                    $conditions=array('Interfering.user_id !='=>$user_id);
                break;

            default:
                $conditions=null;
        }
        //Parametrer la pagination
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Interfering.code' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );
        $this->Interfering->recursive = 0;
        $this->set('interferings', $this->Paginator->paginate());
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
            'order' => array('Interfering.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('interferings', $this->Paginator->paginate('Interfering', array('OR' => array(
                            "LOWER(Interfering.code) LIKE" => "%$keyword%",
                            "LOWER(Interfering.name) LIKE" => "%$keyword%"))));
        } else {
            $this->InterferingType->recursive = 0;
            $this->set('interferings', $this->Paginator->paginate());
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
        if (!$this->Interfering->exists($id)) {
            throw new NotFoundException(__('Invalid interfering'));
        }
        $options = array('conditions' => array('Interfering.' . $this->Interfering->primaryKey => $id));
        $this->set('interfering', $this->Interfering->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::intervenant, $user_id, ActionsEnum::add, "Interferings",
            null, "Interfering" ,null);

        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->Interfering->create();
            $this->request->data['Interfering']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Interfering->save($this->request->data)) {
                if (Configure::read("cafyb") == '1') {
                    $thirdPartyType= 0;
                    $thirdPartyId = $this->Cafyb->addThirdParty($this->request->data['Interfering']['name'],$thirdPartyType);
                    $this->Interfering->id= $this->Interfering->getInsertID();
                    $this->Interfering->saveField('third_party_id', $thirdPartyId);
                }
                $this->Flash->success(__('The interfering has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The interfering could not be saved. Please, try again.'));
            }
        }
        $interferingTypes = $this->InterferingType->getInterferingTypes();
        $this->set(compact('interferingTypes'));
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
        $this->verifyUserPermission(SectionsEnum::intervenant, $user_id, ActionsEnum::edit, "Interferings",
            $id, "Interfering" ,null);

        if (!$this->Interfering->exists($id)) {
            throw new NotFoundException(__('Invalid interfering'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Interfering cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Interfering']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Interfering->save($this->request->data)) {
                $this->Flash->success(__('The interfering has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The interfering could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Interfering.' . $this->Interfering->primaryKey => $id));
            $this->request->data = $this->Interfering->find('first', $options);
            //$this->is_opened("Interfering",'Interferings','interfering',$id);
        }
        $interferingTypes = $this->InterferingType->getInterferingTypes();
        $this->set(compact('interferingTypes'));
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
        $this->verifyUserPermission(SectionsEnum::intervenant, $user_id, ActionsEnum::delete, "Interferings",
            $id, "Interfering" ,null);
        $this->Interfering->id = $id;
        if (!$this->Interfering->exists()) {
            throw new NotFoundException(__('Invalid interfering'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Interfering->delete()) {
            $this->Flash->success(__('The interfering has been deleted.'));
        } else {
            $this->Flash->error(__('The interfering could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }
    public function deleteinterferings() {
     $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
       
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::intervenant, $user_id, ActionsEnum::delete, "Interferings",
            $id, "Interfering" ,null);
            $this->Interfering->id = $id;
            $this->verifyDependences($id);
            
            $this->request->allowMethod('post', 'delete');
            $this->Interfering->id = $id;
            if($this->Interfering->delete()){
                echo json_encode(array("response" => "true"));
            }else{
                echo json_encode(array("response" => "false"));
            }
    }
    
    private function verifyDependences($id){
        $this->loadModel('EventCategoryInterfering');
        $result = $this->EventCategoryInterfering->getItemsByInterfering($id);
        if (!empty($result)) {
            $this->Flash->error(__('The interfering could not be deleted. '
                . 'Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        } 
    }


}
