<?php

App::uses('AppController', 'Controller');

/**
 * AcquisitionTypes Controller
 *
 * @property AcquisitionType $AcquisitionType
 * @property Car $Car
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class AcquisitionTypesController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Security');
    var $helpers = array('Xls');

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->setTimeActif();
        $this->Security->blackHoleCallback = 'blackhole';
        $user_id = $this->Auth->user('id');

        $result = $this->verifyUserPermission(SectionsEnum::type_acquisition_vehicule, $user_id, ActionsEnum::view,
            "AcquisitionTypes", null, "AcquisitionType", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        switch ($result) {
            case 1 :


                $conditions = null;

                break;
            case 2 :


                $conditions = array('AcquisitionType.user_id ' => $user_id);

                break;
            case 3 :


                $conditions = array('AcquisitionType.user_id !=' => $user_id);

                break;

            default:
                $conditions = null;


        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('AcquisitionType.code' => 'ASC'),
            'conditions' => $conditions,
            'paramType' => 'querystring'
        );


        $this->AcquisitionType->recursive = 0;
        $this->set('acquisitionTypes', $this->Paginator->paginate());
        $this->set(compact('limit'));
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
            'order' => array('AcquisitionType.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('acquisitionTypes', $this->Paginator->paginate('AcquisitionType', array(
                'OR' => array(
                    "LOWER(AcquisitionType.code) LIKE" => "%$keyword%",
                    "LOWER(AcquisitionType.name) LIKE" => "%$keyword%"
                )
            )));
        } else {
            $this->AcquisitionType->recursive = 0;
            $this->set('acquisitionTypes', $this->Paginator->paginate());
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
        if (!$this->AcquisitionType->exists($id)) {
            throw new NotFoundException(__('Invalid acquisition type'));
        }
        $options = array('conditions' => array('AcquisitionType.' . $this->AcquisitionType->primaryKey => $id));
        $this->set('acquisitionType', $this->AcquisitionType->find('first', $options));
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
        $this->verifyUserPermission(SectionsEnum::type_acquisition_vehicule, $user_id, ActionsEnum::add,
            "AcquisitionTypes", null, "AcquisitionType", null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->AcquisitionType->create();
            $this->request->data['AcquisitionType']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->AcquisitionType->save($this->request->data)) {
                $this->Flash->success(__('The acquisition type has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The acquisition type could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::type_acquisition_vehicule, $user_id, ActionsEnum::edit,
            "AcquisitionTypes", $id, "AcquisitionType", null);

        if (!$this->AcquisitionType->exists($id)) {
            throw new NotFoundException(__('Invalid acquisition type'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Acquisition type cancelled.'));
                $this->redirect(array('action' => 'index'));
            }


            $this->request->data['AcquisitionType']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($id != 1 && $id != 6 && $this->AcquisitionType->save($this->request->data)) {
                $this->Flash->success(__('The acquisition type has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                if ($id = 1) {
                    if ($this->request->data['AcquisitionType']['name'] == 'Achat') {

                        $this->AcquisitionType->save($this->request->data);
                        $this->Flash->success(__('The acquisition type has been saved.'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        $this->Flash->error(__('Changes were not saved. Event type cancelled.'));
                        $this->redirect(array('action' => 'index'));
                    }
                }

                if ($id = 6) {
                    if ($this->request->data['AcquisitionType']['name'] == 'Location') {

                        $this->AcquisitionType->save($this->request->data);
                        $this->Flash->success(__('The acquisition type has been saved.'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        $this->Flash->error(__('Changes were not saved. Event type cancelled.'));
                        $this->redirect(array('action' => 'index'));
                    }
                }

                $this->Flash->error(__('The acquisition type could not be saved. Please, try again.'));
            }


        } else {
            $options = array('conditions' => array('AcquisitionType.' . $this->AcquisitionType->primaryKey => $id));
            $this->request->data = $this->AcquisitionType->find('first', $options);


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
        $this->verifyUserPermission(SectionsEnum::type_acquisition_vehicule, $user_id, ActionsEnum::delete,
            "AcquisitionTypes", $id, "AcquisitionType", null);
        $this->AcquisitionType->id = $id;
        if (!$this->AcquisitionType->exists()) {
            throw new NotFoundException(__('Invalid acquisition type'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($id != 1 && $id != 2 && $id != 3 && $id != 4 && $this->AcquisitionType->delete()) {
            $this->Flash->success(__('The acquisition type has been deleted.'));
        } else {
            $this->Flash->error(__('The acquisition type could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteacquisitiontypes()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $user_id = $this->Auth->user('id');

        $id = filter_input(INPUT_POST, "id");
        $this->verifyUserPermission(SectionsEnum::type_acquisition_vehicule, $user_id, ActionsEnum::delete,
            "AcquisitionTypes", $id, "AcquisitionType", null);
        $this->AcquisitionType->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($id != 1 && $id != 2 && $id != 3 && $id != 4 && $this->AcquisitionType->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }        /*}else{
            echo json_encode(array("response" => "false"));
        }*/
    }

    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $result = $this->Car->getCarByForeignKey($id, 'acquisition_type_id');
        if (!empty($result)) {
            $this->Flash->error(__('The acquisition type could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }

}
