<?php
App::uses('AppController', 'Controller');
/**
 * Parcs Controller
 *
 * @property Warehouse $Warehouse
 * @property Product $Product
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class WarehousesController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Security');

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
        $result = $this->verifyUserPermission(SectionsEnum::depot_produit, $user_id, ActionsEnum::view, "Warehouses", null,
            "Warehouse", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch ($result) {
            case 1 :
                $conditions = null;
                break;
            case 2 :
                $conditions = array('Warehouse.user_id ' => $user_id);
                break;
            case 3 :
                $conditions = array('Warehouses.user_id !=' => $user_id);
                break;

            default:
                $conditions = null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Warehouse.code' => 'ASC', 'Warehouse.name' => 'ASC'),
            'conditions' => $conditions,
            'paramType' => 'querystring'
        );


        $this->Warehouse->recursive = 0;
        $this->set('warehouses', $this->Paginator->paginate());
        $this->set(compact('limit'));
    }

    public function search()
    {
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'],
                $this->request->params['action'], $this->request->data['keyword']);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Warehouse.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('warehouses', $this->Paginator->paginate('Warehouse', array(
                'OR' => array(
                    "LOWER(Warehouse.code) LIKE" => "%$keyword%",
                    "LOWER(Warehouse.name) LIKE" => "%$keyword%"
                )
            )));
        } else {
            $this->Warehouse->recursive = 0;
            $this->set('warehouses', $this->Paginator->paginate());
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
        if (!$this->Warehouse->exists($id)) {
            throw new NotFoundException(__('Invalid Warehouse'));
        }
        $options = array('conditions' => array('Warehouse.' . $this->Warehouse->primaryKey => $id));
        $this->set('warehouses', $this->Warehouse->find('first', $options));
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
        $this->verifyUserPermission(SectionsEnum::depot_produit, $user_id, ActionsEnum::add,
            "Warehouses", null, "Warehouse",
            null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->Warehouse->create();
            $this->request->data['Warehouse']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Warehouse->save($this->request->data)) {
                $this->Flash->success(__('The warehouse has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The warehouse could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::depot_produit, $user_id,
            ActionsEnum::edit, "Warehouses", $id, "Warehouse",
            null);
        if (!$this->Warehouse->exists($id)) {
            throw new NotFoundException(__('Invalid warehouse'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Warehouse cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Warehouse']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Warehouse->save($this->request->data)) {
                $this->Flash->success(__('The warehouse has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The warehouse could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Warehouse.' . $this->Warehouse->primaryKey => $id));
            $this->request->data = $this->Warehouse->find('first', $options);
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
        $this->verifyUserPermission(SectionsEnum::depot_produit, $user_id,
            ActionsEnum::delete, "Warehouses", $id, "Warehouse",
            null);
        $this->Warehouse->id = $id;
        if (!$this->Warehouse->exists()) {
            throw new NotFoundException(__('Invalid warehouse'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Warehouse->delete()) {
            $this->Flash->success(__('The warehouse has been deleted.'));
        } else {
            $this->Flash->error(__('The warehouse could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteWarehouses()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::depot_produit, $user_id,
            ActionsEnum::delete, "Warehouses", $id, "Warehouse",
            null);
        $this->Warehouse->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Warehouse->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }

    }

    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $this->loadModel('Product');
        $result = $this->Product->getProductByForeignKey($id, "warehouse_id");
        if (!empty($result)) {
            $this->Flash->error(__('The warehouse could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }

    }

}

