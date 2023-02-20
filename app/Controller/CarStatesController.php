<?php

App::uses('AppController', 'Controller');

/**
 * CarStatuses Controller
 *
 * @property CarState $CarState
 * @property SheetRideCarState $SheetRideCarState
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class CarStatesController extends AppController
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
        $result = $this->verifyUserPermission(SectionsEnum::etat_vehicule, $user_id,
            ActionsEnum::view, "CarStates", null, "CarState" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        switch ($result) {
            case 1 :

                $conditions = null;

                break;
            case 2 :


                $conditions = array('CarState.user_id ' => $user_id);

                break;
            case 3 :
                $conditions = array('CarState.user_id !=' => $user_id);

                break;
            default:
                $conditions = null;

        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array( 'UPPER(CarState.name)' => 'ASC'),
            'conditions' => $conditions,
            'paramType' => 'querystring'
        );


        $this->CarState->recursive = -1;
        $this->set('carStates', $this->Paginator->paginate());
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

        if (!$this->CarState->exists($id)) {
            throw new NotFoundException(__('Invalid car state'));
        }
        $options = array('conditions' => array('CarStatus.' . $this->CarState->primaryKey => $id));
        $this->set('carState', $this->CarState->find('first', $options));
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
        $this->verifyUserPermission(SectionsEnum::etat_vehicule, $user_id,
            ActionsEnum::add, "CarStates", null, "CarState" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->CarState->create();
            $this->request->data['CarState']['user_id'] = $this->Session->read('Auth.User.id');


            if ($this->CarState->save($this->request->data)) {
                $this->Flash->success(__('The car state has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The car state could not be saved. Please, try again.'));
            }
        }
    }

    public function edit($id = null)
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::etat_vehicule, $user_id,
            ActionsEnum::edit, "CarStates", $id, "CarState" ,null);
        if (!$this->CarState->exists($id)) {
            throw new NotFoundException(__('Invalid car state'));
        }

        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Car state cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['CarState']['modified_id'] = $this->Session->read('Auth.User.id');
                $this->Flash->success(__('The car state has been saved.'));
                $this->redirect(array('action' => 'index'));

        } else {
            $options = array('conditions' => array('CarStatus.' . $this->CarState->primaryKey => $id));
            $this->request->data = $this->CarState->find('first', $options);

        }
    }

    public function delete($id = null)
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::etat_vehicule, $user_id,
            ActionsEnum::delete, "CarStates", $id, "CarState" ,null);
        $this->CarState->id = $id;
        if (!$this->CarState->exists()) {
            throw new NotFoundException(__('Invalid car state'));
        }

        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
            $this->Flash->success(__('The car state has been deleted.'));

        $this->redirect(array('action' => 'index'));
    }

    public function deleteStates()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::etat_vehicule, $user_id,
            ActionsEnum::delete, "CarStates", $id, "CarState" ,null);

            $this->CarState->id = $id;
            $this->verifyDependences($id);
            $this->request->allowMethod('post', 'delete');
            if ($this->CarState->delete()) {
                echo json_encode(array("response" => "true"));
            } else {
                echo json_encode(array("response" => "false"));
            }

    }

    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $this->loadModel('SheetRideCarState');
        $result = $this->SheetRideCarState->find('first',array(
            'conditions'=>array('SheetRideCarState.car_state_id'=>$id)
        ));
        if (!empty($result)) {
            $this->Flash->error(__('The state could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }


    public function getCarStates()
    {
        $sqlCarStates =" SELECT 
                        `CarState`.`id`, `CarState`.`name`                           
                                        FROM  `car_state` AS `CarState` 
                                      order by `CarState`.`id` ASC ";

        $conn = ConnectionManager::getDataSource('default');
        $carStates = $conn->fetchAll($sqlCarStates);
        $carStatesArray= array();
        $i=0;
        if(!empty($carStates))
        {
            foreach ($carStates  as $carState){
                $carStatesArray[$i]['id']=$carState['CarState']['id'];
                $carStatesArray[$i]['name']=$carState['CarState']['name'];
                $i++;
            }
            $carStatesArray = json_encode($carStatesArray);
            $this->response->type('json');
            $this->response->body($carStatesArray);
            return $this->response;
        }
        else {
            echo 0; die();
        }
    }



}
