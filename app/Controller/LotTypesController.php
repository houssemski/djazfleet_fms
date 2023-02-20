<?php

App::uses('AppController', 'Controller');

/**
 * LotType Controller
 *
 * @property LotType $LotType
 * @property Lot $Lot
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class LotTypesController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    var $helpers = array('Xls');

    /**
     * @param null $params
     * @param null $orderType
     * @return array
     */

    public function getOrder($params = null , $orderType = null)
    {

        if($orderType == null){
            $orderType = 'DESC';
        }
        if (isset($params) && is_numeric($params)) {
            switch ($params) {
                case 1 :
                    $order = array('LotType.code' => $orderType);
                    break;
                case 2 :
                    $order = array('LotType.name' => $orderType);
                    break;
                case 3 :
                    $order = array('LotType.id' => $orderType);
                    break;

                default :
                    $order = array('LotType.id' => $orderType);
            }
            return $order;
        } else {
            $order = array('LotType.id' => $orderType);

            return $order;
        }
    }

    public function index()
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::lot_type, $user_id, ActionsEnum::view,
            "LotTypes", null, "LotType", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();
        switch ($result) {
            case 1 :

                $conditions = null;
                break;
            case 2 :

                $conditions = array('LotType.user_id ' => $user_id);
                break;
            case 3 :

                $conditions = array('LotType.user_id !=' => $user_id);

                break;

            default:
                $conditions = null;


        }

        $this->paginate = array(
            'recursive' => 0,
            'limit' => $limit,
            'order' => $order,
            'conditions' => $conditions,
            'paramType' => 'querystring'
        );


        $this->set('lotTypes', $this->Paginator->paginate());
        $this->set(compact('limit', 'order'));
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
            'recursive' => 0,
            'limit' => $limit,
            'order' => array('LotType.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('lotTypes', $this->Paginator->paginate('LotType', array(
                'OR' => array(
                    "LOWER(LotType.code) LIKE" => "%$keyword%",
                    "LOWER(LotType.name) LIKE" => "%$keyword%"
                )
            )));
        } else {
            $this->set('lotTypes', $this->Paginator->paginate());
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

        if (!$this->LotType->exists($id)) {
            throw new NotFoundException(__('Invalid lot type'));
        }
        $options = array('conditions' => array('LotType.' . $this->LotType->primaryKey => $id));
        $this->set('lotType', $this->LotType->find('first', $options));
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
        $this->verifyUserPermission(SectionsEnum::lot_type, $user_id, ActionsEnum::add,
            "LotTypes", null, "LotType", null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->success(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->LotType->create();
            $this->request->data['LotType']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->LotType->save($this->request->data)) {

                $this->Flash->success(__('The lot type has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->success(__('The lot type could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::lot_type, $user_id, ActionsEnum::edit,
            "LotTypes", $id, "LotType", null);
        if (!$this->LotType->exists($id)) {
            throw new NotFoundException(__('Invalid lot type'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Lot type cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['LotType']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->LotType->save($this->request->data)) {

                $this->Flash->success(__('The lot type has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The lot type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('LotType.' . $this->LotType->primaryKey => $id));
            $this->request->data = $this->LotType->find('first', $options);
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
        $this->verifyUserPermission(SectionsEnum::lot_type, $user_id, ActionsEnum::delete,
            "LotTypes", $id, "LotType", null);
        $this->LotType->id = $id;
        if (!$this->LotType->exists()) {
            throw new NotFoundException(__('Invalid lot type'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->LotType->delete()) {

            $this->Flash->success(__('The lot type has been deleted.'));
        } else {

            $this->Flash->error(__('The lot type could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteLotTypes()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');

        $this->verifyUserPermission(SectionsEnum::lot_type, $user_id, ActionsEnum::delete,
            "LotTypes", $id, "LotType", null);
        $this->LotType->id = $id;
        // $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->LotType->delete()) {
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
        $this->loadModel('Lot');

        $result = $this->Lot->getLotByForeignKey($id, "lot_type_id");
        if (!empty($result)) {
            $this->Flash->error(__('The lot type could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }

    function export()
    {
        $this->setTimeActif();
        $LotTypes = $this->LotType->find('all', array(
            'order' => 'LotType.name asc',
            'recursive' => 2
        ));
        $this->set('models', $LotTypes);
    }

}