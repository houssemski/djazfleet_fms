<?php
App::uses('AppController', 'Controller');
/**
 * Parcs Controller
 *
 * @property Parc $Parc
 * @property Car $Car
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 * @property SaveParcsComponent $SaveParcs
 */
class ParcsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Security', 'SaveParcs');

    public $uses = array(
        'Parc',
        'UserParc',
    );


/**
 * index method
 *
 * @return void
 */
    public function index() {
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $result=$this->verifyUserPermission(SectionsEnum::parc_vehicule, $user_id, ActionsEnum::view, "Parcs", null,
            "Parc" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                    $conditions=array('Parc.user_id '=>$user_id);
                break;
            case 3 :
                    $conditions=array('Parc.user_id !='=>$user_id);
                break;

            default:
                $conditions=null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Parc.code' => 'ASC', 'Parc.name' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );


        $this->Parc->recursive = 0;
        $this->set('parcs', $this->Paginator->paginate());
        $this->set(compact('limit'));
    }

    public function search() {
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'],
                $this->request->params['action'], $this->request->data['keyword']);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Parc.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('parcs', $this->Paginator->paginate('Parc', array('OR' => array(
                "LOWER(Parc.code) LIKE" => "%$keyword%",
                "LOWER(Parc.name) LIKE" => "%$keyword%"))));
        } else {
            $this->Parc->recursive = 0;
            $this->set('parcs', $this->Paginator->paginate());
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
        if (!$this->Parc->exists($id)) {
            throw new NotFoundException(__('Invalid Parc'));
        }
        $options = array('conditions' => array('Parc.' . $this->Parc->primaryKey => $id));
        $this->set('parc', $this->Parc->find('first', $options));
    }

/**
 * add method
 *
 * @return void
 */
    public function add() {    
        
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::parc_vehicule, $user_id, ActionsEnum::add, "Parcs", null,
            "Parc" ,null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->Parc->create();
            $this->request->data['Parc']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Parc->save($this->request->data)) {
                $this->SaveParcs->saveParcUserAssociation($this->Parc->getLastInsertId(), $user_id);
                $this->Flash->success(__('The Parc has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->success(__('The Parc could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::parc_vehicule, $user_id, ActionsEnum::edit, "Parcs", $id,
            "Parc" ,null);
        if (!$this->Parc->exists($id)) {
            throw new NotFoundException(__('Invalid Parc'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Parc cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Parc']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Parc->save($this->request->data)) {
                $this->Flash->success(__('The Parc has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The Parc could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Parc.' . $this->Parc->primaryKey => $id));
            $this->request->data = $this->Parc->find('first', $options);
            //$this->is_opened("Parc",'Parcs','parc',$id);
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
        $this->verifyUserPermission(SectionsEnum::parc_vehicule, $user_id, ActionsEnum::delete, "Parcs", $id,
            "Parc" ,null);
        $this->Parc->id = $id;
        if (!$this->Parc->exists()) {
            throw new NotFoundException(__('Invalid Parc'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Parc->delete()) {
            $this->Flash->success(__('The Parc has been deleted.'));
        } else {
            $this->Flash->success(__('The Parc could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }
    public function deleteParcs() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::parc_vehicule, $user_id, ActionsEnum::delete, "Parcs", $id,
            "Parc" ,null);
       // if () {

            $this->Parc->id = $id;
            $this->verifyDependences($id);
            $this->request->allowMethod('post', 'delete');
            if($this->Parc->delete()){
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
        $result = $this->Car->getCarByForeignKey($id, "parc_id");
        if (!empty($result)) {
            $this->Flash->error(__('The parc could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
       
    }

}
