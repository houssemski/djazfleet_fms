<?php

App::uses('AppController', 'Controller');

/**
 * CarOptions Controller
 *
 * @property CarOption $CarOption
 * @property CarOptionsCustomerCar $CarOptionsCustomerCar
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class CarOptionsController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Security');
    public $uses = array('CarOption', 'CarOptionsCustomerCar');
    var $helpers = array('Xls');

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {

        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();

        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::option_affectation, $user_id, ActionsEnum::view,
            "CarOptions", null, "CarOption", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        switch ($result) {
            case 1 :

                $conditions = null;

                break;
            case 2 :

                $conditions = array('CarOption.user_id ' => $user_id);

                break;
            case 3 :

                $conditions = array('CarOption.user_id !=' => $user_id);

                break;
            default:
                $conditions = null;


        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('CarOption.code' => 'ASC'),
            'CarOption.name' => 'ASC',
            'conditions' => $conditions,
            'paramType' => 'querystring'
        );

        $this->CarOption->recursive = -1;
        $carOptions = $this->paginate('CarOption');
        $this->set(compact('carOptions', 'limit'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function search()
    {
        $this->setTimeActif();
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'],
                $this->request->params['action'], $this->request->data['keyword']);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('CarOption.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('carOptions', $this->Paginator->paginate('CarOption', array(
                'OR' => array(
                    "LOWER(CarOption.code) LIKE" => "%$keyword%",
                    "LOWER(CarOption.name) LIKE" => "%$keyword%"
                )
            )));
        } else {
            $this->CarOption->recursive = 0;
            $this->set('carOptions', $this->Paginator->paginate('CarOption'));
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
    public function view($id = null)
    {
        $this->setTimeActif();

        if (!$this->CarOption->exists($id)) {
            throw new NotFoundException(__('Invalid car option'));
        }
        $options = array('conditions' => array('CarOption.' . $this->CarOption->primaryKey => $id));
        $this->set('carOption', $this->CarOption->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        $this->setTimeActif();

        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::option_affectation, $user_id, ActionsEnum::add, "CarOptions", null,
            "CarOption", null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->CarOption->create();
            $this->request->data['CarOption']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->CarOption->save($this->request->data)) {
                $this->Flash->success(__('The car option has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The car option could not be saved. Please, try again.'));
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
    public function edit($id = null)
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::option_affectation, $user_id, ActionsEnum::edit, "CarOptions", $id,
            "CarOption", null);
        if (!$this->CarOption->exists($id)) {
            throw new NotFoundException(__('Invalid car option'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['CarOption']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->CarOption->save($this->request->data)) {
                $this->Flash->success(__('The car option has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The car option could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CarOption.' . $this->CarOption->primaryKey => $id));
            $this->request->data = $this->CarOption->find('first', $options);

        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null)
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::option_affectation, $user_id, ActionsEnum::delete, "CarOptions", $id,
            "CarOption", null);
        $this->CarOption->id = $id;
        if (!$this->CarOption->exists()) {
            throw new NotFoundException(__('Invalid car option'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->CarOption->delete()) {
            $this->Flash->success(__('The car option has been deleted.'));
        } else {
            $this->Flash->error(__('he car option could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteoptions()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::option_affectation, $user_id, ActionsEnum::delete, "CarOptions", $id,
            "CarOption", null);
        $this->verifyDependences($id);
        $this->CarOption->id = $id;
        $this->request->allowMethod('post', 'delete');
        if ($this->CarOption->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }

        /*}else{
             echo json_encode(array("response" => "false"));
         }*/
    }

    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $result = $this->CarOptionsCustomerCar->getItemByForeignKey($id, 'car_option_id');
        if (!empty($result)) {
            $this->Flash->error(__('The option could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }

}
