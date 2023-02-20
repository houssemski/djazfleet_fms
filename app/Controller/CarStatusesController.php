<?php

App::uses('AppController', 'Controller');

/**
 * CarStatuses Controller
 *
 * @property CarStatus $CarStatus
 * @property Car $Car
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class CarStatusesController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    // Integrer les deux composants paginator et session
    public $components = array('Paginator', 'Session', 'Security');
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
        $result = $this->verifyUserPermission(SectionsEnum::statut_vehicule, $user_id, ActionsEnum::view, "CarStatuses", null, "CarStatus" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        switch ($result) {
            case 1 :

                $conditions = null;

                break;
            case 2 :


                $conditions = array('CarStatus.user_id ' => $user_id);

                break;
            case 3 :
                $conditions = array('CarStatus.user_id !=' => $user_id);

                break;
            default:
                $conditions = null;

        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('UPPER(CarStatus.code)' => 'ASC', 'UPPER(CarStatus.name)' => 'ASC'),
            'conditions' => $conditions,
            'paramType' => 'querystring'
        );


        $this->CarStatus->recursive = -1;
        $this->set('carStatuses', $this->Paginator->paginate());
        $this->set(compact( 'limit'));
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
            'order' => array('UPPER(CarStatus.code)' => 'ASC', 'UPPER(CarStatus.name)' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('carStatus', $this->Paginator->paginate('CarStatus', array('OR' => array(
                "LOWER(CarStatus.code) LIKE" => "%$keyword%",
                "LOWER(CarStatus.name) LIKE" => "%$keyword%"))));
        } else {
            $this->CarStatus->recursive = 0;
            $this->set('carStatus', $this->Paginator->paginate());
        }
        $this->set(compact('limit'));
        $this->render();
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null)
    {
        $this->setTimeActif();

        if (!$this->CarStatus->exists($id)) {
            throw new NotFoundException(__('Invalid car status'));
        }
        $options = array('conditions' => array('CarStatus.' . $this->CarStatus->primaryKey => $id));
        $this->set('carStatus', $this->CarStatus->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */


    public function add()
    {
        $this->setTimeActif();

        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::statut_vehicule, $user_id, ActionsEnum::add, "CarStatuses", null, "CarStatus" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->CarStatus->create();
            $this->request->data['CarStatus']['user_id'] = $this->Session->read('Auth.User.id');


            if ($this->CarStatus->save($this->request->data)) {
                $this->Flash->success(__('The car status has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The car status could not be saved. Please, try again.'));
            }
        }
    }

    public function edit($id = null)
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::statut_vehicule, $user_id, ActionsEnum::edit, "CarStatuses", $id, "CarStatus" ,null);
        if (!$this->CarStatus->exists($id)) {
            throw new NotFoundException(__('Invalid car status'));
        }
        if($id == 1 || $id == 6|| $id == 8 || $id == 27){
            $this->Flash->success(__('This status can not be modified.'));
            $this->redirect(array('controller' => 'CarStatuses','action' => 'index'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Car status cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['CarStatus']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($id != 1 && $id != 6 && $id != 27 && $id != 28 && $this->CarStatus->save($this->request->data)) {
                $this->Flash->success(__('The car status has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                if ($id == 1 || $id == 6 || $id == 27 || $id == 28) {

                    if ($id == 1) {
                        if ($this->request->data['CarStatus']['code'] == 'Dispo') {

                            $this->CarStatus->save($this->request->data);
                            $this->Flash->success(__('The car status has been saved.'));
                            $this->redirect(array('action' => 'index'));
                        } else {
                            $this->Flash->error(__('The car status could not be saved. Please, try again.'));
                        }
                    }elseif ($id == 6) {
                        if ($this->request->data['CarStatus']['code'] == 'RSV') {
                            $this->CarStatus->save($this->request->data);
                            $this->Flash->success(__('The car status has been saved.'));
                            $this->redirect(array('action' => 'index'));
                        }else {
                            $this->Flash->error(__('The car status could not be saved. Please, try again.'));
                        }
                    }elseif ($id == 27) {
                        if ($this->request->data['CarStatus']['code'] == 'archive') {
                            $this->CarStatus->save($this->request->data);
                            $this->Flash->success(__('The car status has been saved.'));
                            $this->redirect(array('action' => 'index'));
                        }else {
                            $this->Flash->error(__('The car status could not be saved. Please, try again.'));
                        }
                    }elseif ($id == 28) {
                        if ($this->request->data['CarStatus']['code'] == 'reforme') {
                            $this->CarStatus->save($this->request->data);
                            $this->Flash->success(__('The car status has been saved.'));
                            $this->redirect(array('action' => 'index'));
                        }else {
                            $this->Flash->error(__('The car status could not be saved. Please, try again.'));
                        }
                    }


                }

            }
        } else {
            $options = array('conditions' => array('CarStatus.' . $this->CarStatus->primaryKey => $id));
            $this->request->data = $this->CarStatus->find('first', $options);

        }
    }

    public function delete($id = null)
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::statut_vehicule, $user_id, ActionsEnum::delete, "CarStatuses", $id, "CarStatus" ,null);
        $this->CarStatus->id = $id;
        if (!$this->CarStatus->exists()) {
            throw new NotFoundException(__('Invalid car status'));
        }
        if($id == 1 || $id == 6|| $id == 8 || $id == 27){
            $this->Flash->success(__('This status can not be deleted.'));
            $this->redirect(array('controller' => 'CarStatuses','action' => 'index'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($id != 1 && $id != 6 && $id != 27 && $id != 28 && $this->CarStatus->delete()) {
            $this->Flash->success(__('The car status has been deleted.'));
        } else {
            $this->Flash->error(__('The car status could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deletestatuses()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::statut_vehicule, $user_id, ActionsEnum::delete, "CarStatuses", $id, "CarStatus" ,null);
        if ($id != 1 && $id != 6 && $id != 27 && $id != 28) {
            $this->CarStatus->id = $id;
            $this->verifyDependences($id);
            $this->request->allowMethod('post', 'delete');
            if ($this->CarStatus->delete()) {
                echo json_encode(array("response" => "true"));
            } else {
                echo json_encode(array("response" => "false"));
            }
        } else {
            echo json_encode(array("response" => "false"));
        }
    }

    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $result = $this->Car->getCarByForeignKey($id, "car_status_id");
        if (!empty($result)) {
            $this->Flash->error(__('The status could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }

}
