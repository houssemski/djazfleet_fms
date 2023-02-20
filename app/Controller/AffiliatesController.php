<?php

App::uses('AppController', 'Controller');

/**
 * Affiliate Controller
 *
 * @property Affiliate $Affiliate
 * @property Customer $Customer
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class AffiliatesController extends AppController {

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
        $this->setTimeActif();
        $this->Security->blackHoleCallback = 'blackhole';
        $user_id=$this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::affiliation_employe, $user_id, ActionsEnum::view, "Affiliates", null, "Affiliate" , null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        switch($result) {
            case 1 :


                $conditions=null;

                break;
            case 2 :


                    $conditions=array('Affiliate.user_id '=>$user_id);

                break;
            case 3 :


                    $conditions=array('Affiliate.user_id !='=>$user_id);

                break;

            default:
                $conditions=null;


        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Affiliate.code' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );



        $this->Affiliate->recursive = 0;
        $this->set('affiliates', $this->Paginator->paginate());
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
            'order' => array('Affiliate.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('acquisitionTypes', $this->Paginator->paginate('Affiliate', array('OR' => array(
                            "LOWER(Affiliate.code) LIKE" => "%$keyword%",
                            "LOWER(Affiliate.name) LIKE" => "%$keyword%"))));
        } else {
            $this->Affiliate->recursive = 0;
            $this->set('affiliates', $this->Paginator->paginate());
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
        if (!$this->Affiliate->exists($id)) {
            throw new NotFoundException(__('Invalid affiliate'));
        }
        $options = array('conditions' => array('Affiliate.' . $this->Affiliate->primaryKey => $id));
        $this->set('affiliate', $this->Affiliate->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();
       
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::affiliation_employe, $user_id, ActionsEnum::add, "Affiliates", null, "Affiliate" , null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Affiliate->create();
            $this->request->data['Affiliate']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Affiliate->save($this->request->data)) {
                $this->Flash->success(__('The affiliate has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The affiliate could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::affiliation_employe, $user_id, ActionsEnum::edit, "Affiliates", $id, "Affiliate" , null);
        if (!$this->Affiliate->exists($id)) {
            throw new NotFoundException(__('Invalid affiliate'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Affiliate cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Affiliate']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Affiliate->save($this->request->data)) {
                $this->Flash->success(__('The affiliate has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The affiliate could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Affiliate.' . $this->Affiliate->primaryKey => $id));
            $this->request->data = $this->Affiliate->find('first', $options);
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
        $this->verifyUserPermission(SectionsEnum::affiliation_employe, $user_id, ActionsEnum::delete, "Affiliates", $id, "Affiliate" , null);
        $this->Affiliate->id = $id;
        if (!$this->Affiliate->exists()) {
            throw new NotFoundException(__('Invalid affiliate'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Affiliate->delete()) {
                $this->Flash->success(__('The affiliate has been deleted.'));
        } else {
                $this->Flash->error(__('The affiliate could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteaffiliates() {
        $this->setTimeActif();
        $this->autoRender = false;
        $user_id=$this->Auth->user('id');
       // if ($this->isSuperAdmin()) {
            $id = filter_input(INPUT_POST, "id");
        $this->verifyUserPermission(SectionsEnum::affiliation_employe, $user_id, ActionsEnum::delete, "Affiliates", $id, "Affiliate" , null);
            $this->Affiliate->id = $id;
            $this->verifyDependences($id);
            $this->request->allowMethod('post', 'delete');
            if($this->Affiliate->delete()){
                echo json_encode(array("response" => "true"));
            }else{
                echo json_encode(array("response" => "false"));
            }        /*}else{
            echo json_encode(array("response" => "false"));
        }*/
    }
    private function verifyDependences($id){
        $this->setTimeActif();
        $this->loadModel('Customer');
        $result = $this->Customer->getCustomerByForeignKey($id, 'affiliate_id');
        if (!empty($result)) {
            $this->Flash->error(__('The affiliate could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        } 
    }

}
