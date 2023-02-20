<?php

/**
 * Tva Controller
 *
 * @property Tva $Tva
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class TvasController extends AppController
{

    public $components = array('Paginator', 'Session');

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::tva_produit, $user_id, ActionsEnum::view,
            "Tva", null, "Tva", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch ($result) {
            case 1 :
                $conditions = null;
                break;
            case 2 :
                $conditions = array('Tva.user_id ' => $user_id);
                break;
            case 3 :
                $conditions = array('Tva.user_id !=' => $user_id);
                break;

            default:
                $conditions = null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Tva.code' => 'ASC', 'Tva.name' => 'ASC'),
            'conditions' => $conditions,
            'paramType' => 'querystring'
        );


        $this->Tva->recursive = 0;
        $this->set('tvas', $this->Paginator->paginate());
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
            'order' => array('Tva.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('tvas', $this->Paginator->paginate('Tva', array(
                'OR' => array(
                    "LOWER(Tva.code) LIKE" => "%$keyword%",
                    "LOWER(Tva.name) LIKE" => "%$keyword%"
                )
            )));
        } else {
            $this->Tva->recursive = 0;
            $this->set('tvas', $this->Paginator->paginate());
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
        if (!$this->Tva->exists($id)) {
            throw new NotFoundException(__('Invalid Tva'));
        }
        $options = array('conditions' => array('Tva.' . $this->Tva->primaryKey => $id));
        $this->set('tva', $this->Tva->find('first', $options));
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
        $this->verifyUserPermission(SectionsEnum::tva_produit, $user_id, ActionsEnum::add,
            "Tva", null, "Tva", null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->Tva->create();
            $this->request->data['Tva']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Tva->save($this->request->data)) {
                $this->Flash->success(__('The Tva has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The Tva could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::tva_produit, $user_id, ActionsEnum::edit,
            "Tva", $id, "Tva", null);
        if (!$this->Tva->exists($id)) {
            throw new NotFoundException(__('Invalid Tva'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Tva cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Tva']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Tva->save($this->request->data)) {
                $this->Flash->success(__('The Tva has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The Tva could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Tva.' . $this->Tva->primaryKey => $id));
            $this->request->data = $this->Tva->find('first', $options);
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
        $this->verifyUserPermission(SectionsEnum::tva_produit, $user_id, ActionsEnum::delete,
            "Tva", $id, "Tva", null);
        $this->Tva->id = $id;
        if (!$this->Tva->exists()) {
            throw new NotFoundException(__('Invalid Tva'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Tva->delete()) {
            $this->Flash->success(__('The Tva has been deleted.'));
        } else {
            $this->Flash->error(__('The Tva could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteTvas()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::tva_produit, $user_id, ActionsEnum::delete,
            "Tva", $id, "Tva", null);
        $this->Tva->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Tva->delete()) {
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
        $this->loadModel('Product');
        $result = $this->Product->getProductByForeignKey($id, "tva_id");
        if (!empty($result)) {
            $this->Flash->error(__('The Tva could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }

    }


}