<?php

App::uses('AppController', 'Controller');

/**
 * AcquisitionTypes Controller
 *
 * @property AcquisitionType $Affiliates
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class TankOperationsController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Security');
    var $helpers = array('Xls');
    public $uses = array('TankOperation', 'Tank', 'Fuel', 'Consumption', 'TankOperation');

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
        $result = $this->verifyUserPermission(SectionsEnum::citerne, $user_id, ActionsEnum::view, "TankOperations", null,
            "TankOperation", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        switch ($result) {
            case 1 :


                $conditions = null;

                break;
            case 2 :


                $conditions = array('TankOperation.user_id ' => $user_id);

                break;
            case 3 :


                $conditions = array('TankOperation.user_id !=' => $user_id);

                break;

            default:
                $conditions = null;


        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('TankOperation.id' => 'ASC'),
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'recursive' => -1,
            'fields' => array(
                'TankOperation.id',
                'tank_id',
                'liter',
                'date_add',
                'Tank.code',
                'Tank.name'

            ),
            'joins' => array(


                array(
                    'table' => 'tanks',
                    'type' => 'left',
                    'alias' => 'Tank',
                    'conditions' => array('TankOperation.tank_id = Tank.id')
                ),


            )
        );


        $this->set('tankOperations', $this->Paginator->paginate());


        $this->set(compact('limit', 'param'));
    }

    /**
     * index method
     *
     * @return void
     */


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
        if (!$this->TankOperation->exists($id)) {
            throw new NotFoundException(__('Invalid tank '));
        }
        $options = array('conditions' => array('TankOperation.' . $this->TankOperation->primaryKey => $id),
            'paramType' => 'querystring',
            'recursive' => -1,
            'fields' => array(
                'TankOperation.id',
                'tank_id',
                'liter',
                'date_add',
                'Tank.code',
                'Tank.name'

            ),
            'joins' => array(


                array(
                    'table' => 'tanks',
                    'type' => 'left',
                    'alias' => 'Tank',
                    'conditions' => array('TankOperation.tank_id = Tank.id')
                ),


            )
        );
        $this->set('tankOperation', $this->TankOperation->find('first', $options));
        //Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set(compact('param'));
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
        $this->verifyUserPermission(SectionsEnum::citerne, $user_id, ActionsEnum::add,
            "TankOperations", null, "TankOperation", null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->TankOperation->create();
            $this->createDatetimeFromDate('TankOperation', 'date_add');
            $this->request->data['TankOperation']['user_id'] = $this->Session->read('Auth.User.id');


            if ($this->TankOperation->save($this->request->data)) {
                $this->Tank->increaseLiterTank($this->request->data['TankOperation']['tank_id'],$this->request->data['TankOperation']['liter']);

                $this->Flash->success(__('The tank has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The tank could not be saved. Please, try again.'));
            }


        }


        $tanks = $this->Tank->getTanks('list');
        $this->set(compact('tanks'));
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
        $this->verifyUserPermission(SectionsEnum::citerne, $user_id, ActionsEnum::edit,
            "TankOperations", $id, "TankOperation", null);
        if (!$this->TankOperation->exists($id)) {
            throw new NotFoundException(__('Invalid tank'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Tank cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $tankOperation = $this->TankOperation->getTankOperationById($id);
            $this->Tank->increaseLiterTank($tankOperation['TankOperation']['tank_id'],$tankOperation['TankOperation']['liter']);
            $this->request->data['TankOperation']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->TankOperation->save($this->request->data)) {
                $this->Tank->increaseLiterTank($this->request->data['TankOperation']['tank_id'],$this->request->data['TankOperation']['liter']);
                $this->Flash->success(__('The tank has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The tank could not be saved. Please, try again.'));
            }

        } else {
            $options = array('conditions' => array('TankOperation.' . $this->TankOperation->primaryKey => $id));
            $this->request->data = $this->TankOperation->find('first', $options);
            $tanks = $this->Tank->getTanks('list');
            $this->set(compact('tanks'));
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
        $this->verifyUserPermission(SectionsEnum::citerne, $user_id, ActionsEnum::delete,
            "TankOperations", $id, "TankOperation", null);
        $this->TankOperation->id = $id;
        if (!$this->TankOperation->exists()) {
            throw new NotFoundException(__('Invalid tank'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->TankOperation->delete()) {
            $this->Flash->success(__('The tank has been deleted.'));
        } else {
            $this->Flash->error(__('The tank could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    private function verifyDependences($id)
    {
        $this->setTimeActif();


    }

    public function deleteTankOperations()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $user_id = $this->Auth->user('id');
        $id = filter_input(INPUT_POST, "id");
        $this->verifyUserPermission(SectionsEnum::citerne, $user_id, ActionsEnum::delete,
            "TankOperations", $id, "TankOperation", null);
        $this->TankOperation->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->TankOperation->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }
    }

    function export()
    {
        $this->setTimeActif();
        $tankOperations = $this->TankOperation->find('all', array(
            'order' => 'TankOperation.id asc',
            'recursive' => 2
        ));
        $this->set('models', $tankOperations);
    }

    /** get max liter quon peut ajouter à la citerne
     * @param null $liter
     * @param null $tankId
     */
    function getMaxLiter($liter = null, $tankId = null)
    {
        $this->layout = 'ajax';
        $tank = $this->Tank->getTankById($tankId);
        $capacity = $tank['Tank']['capacity'];
        $literExisted = $tank['Tank']['liter'];
        $maxLiter = $capacity - $literExisted;
        if ($maxLiter < $liter) {
            $liter = $maxLiter;
        }
        $this->set(compact('capacity', 'liter'));
    }

}
