<?php

App::uses('AppController', 'Controller');

/**
 * Models Controller
 *
 * @property Carmodel $Carmodel
 * @property Mark $Mark
 * @property Fuel $Fuel
 * @property Car $Car
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class CarmodelsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator','Security');
    public $uses = array('Carmodel', 'Mark', 'Fuel');
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
        $result = $this->verifyUserPermission(SectionsEnum::modele_vehicule, $user_id, ActionsEnum::view, "Carmodels", null, "Carmodel" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        switch($result) {
            case 1 :

                $conditions=null;
                break;
            case 2 :

                    $conditions=array('Carmodel.user_id '=>$user_id);

                break;
            case 3 :


                    $conditions=array('Carmodel.user_id !='=>$user_id);

                break;
            default:
                $conditions=null;


        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Carmodel.code' => 'ASC', 'Mark.name' => 'ASC', 'Carmodel.name' => 'ASC'),
            'Carmodel.name' => 'ASC',
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );
       /* $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        //Parametrer la pagination
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Carmodel.code' => 'ASC', 'Mark.name' => 'ASC', 'Carmodel.name' => 'ASC'),
            'paramType' => 'querystring'
        );*/
        $carmodels = $this->paginate('Carmodel');
        $this->set(compact('carmodels', 'limit'));
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
            'order' => array('Carmodel.code' => 'ASC', 'Mark.name' => 'ASC', 'Carmodel.name' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('carmodels', $this->Paginator->paginate('Carmodel', array('OR' => array(
                            "LOWER(Carmodel.name) LIKE" => "%$keyword%",
                            "LOWER(Mark.name) LIKE" => "%$keyword%"))));
        } else {
            $this->Carmodel->recursive = 0;
            $this->set('carmodels', $this->Paginator->paginate());
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
        if (!$this->Carmodel->exists($id)) {
            throw new NotFoundException(__('Invalid model'));
        }
        $options = array('conditions' => array('Carmodel.' . $this->Carmodel->primaryKey => $id));
        $this->set('model', $this->Carmodel->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::modele_vehicule, $user_id, ActionsEnum::add, "Carmodels", null, "Carmodel" ,null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->Carmodel->create();
            $this->request->data['Carmodel']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Carmodel->save($this->request->data)) {
                $this->Flash->success(__('The model has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The model could not be saved. Please, try again.'));
            }
        }
        $marks = $this->Mark->getCarMarksByIdsNegation(array('Mark.id' != 0));

		$fuels=$this->Fuel->getFuels('all');

        $this->set(compact('marks','fuels'));
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
        $this->verifyUserPermission(SectionsEnum::modele_vehicule, $user_id, ActionsEnum::edit, "Carmodels", $id, "Carmodel" ,null);
        if (!$this->Carmodel->exists($id)) {
            throw new NotFoundException(__('Invalid model'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Model cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Carmodel']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Carmodel->save($this->request->data)) {
                $this->Flash->success(__('The model has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->success(__('The model could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Carmodel.' . $this->Carmodel->primaryKey => $id));
            $this->request->data = $this->Carmodel->find('first', $options);

            $marks = $this->Mark->getCarMarksByIdsNegation(array('Mark.id' != 0));

		$fuels=$this->Fuel->getFuels('all');
            $this->set(compact('marks','fuels'));
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
        $this->verifyUserPermission(SectionsEnum::modele_vehicule, $user_id, ActionsEnum::delete, "Carmodels", $id, "Carmodel" ,null);
        $this->Carmodel->id = $id;
        if (!$this->Carmodel->exists()) {
            throw new NotFoundException(__('Invalid model'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Carmodel->delete()) {
            $this->Flash->success(__('The model has been deleted.'));
        } else {
            $this->Flash->error(__('The model could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }
    public function deletecarmodels() {
        $this->setTimeActif();
        $this->autoRender = false;
            $id = filter_input(INPUT_POST, "id");
            $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::modele_vehicule, $user_id, ActionsEnum::delete, "Carmodels", $id, "Carmodel" ,null);
            $this->Carmodel->id = $id;
            $this->verifyDependences($id);
            $this->request->allowMethod('post', 'delete');
            if($this->Carmodel->delete()){
                echo json_encode(array("response" => "true"));
            }else{
                echo json_encode(array("response" => "false"));
            }
    }
    private function verifyDependences($id){
        $this->setTimeActif();
        $result = $this->Car->getCarByForeignKey($id, 'carmodel_id');
        if (!empty($result)) {
            $this->Flash->error(__('The car model could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }
    function export() {
        $this->setTimeActif();
        if(isset($this->params['pass']['0']) && $this->params['pass']['0'] == "all"){
            $models = $this->Carmodel->find('all', array(
            'order' => array('Mark.name asc', 'Carmodel.name asc'),
            'recursive' => 1
            ));
        }else{
            $ids = filter_input(INPUT_POST, "chkids");
            $array_ids = explode(",", $ids);
            $models = $this->Carmodel->find('all', array(
            'conditions' => array(
                "Carmodel.id" => $array_ids
            ),
            'order' => array('Mark.name asc', 'Carmodel.name asc'),
            'recursive' => 1
            ));
        }
        $this->set('models', $models);
    }

}
