<?php
App::uses('AppController', 'Controller');

/**
 * Recharges Controller
 *
 * @property Recharge $Recharge
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class RechargesController extends AppController
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
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();

        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::recharge_extincteur, $user_id, ActionsEnum::view,
            "Recharges", null, "Recharge", null);

        switch ($result) {
            case 1 :
                $conditions = null;

                break;
            case 2 :
                $conditions = array('Recharge.user_id ' => $user_id);

                break;
            case 3 :

                $conditions = array('Recharge.user_id !=' => $user_id);

                break;

            default:
                $conditions = null;


        }
        $this->paginate = array(
            'limit' => $limit,
            'conditions' => $conditions,
            'recursive' => -1,
            'paramType' => 'querystring',
            'fields' => array(
                'code',
                'Recharge.id',
                'recharge_date',

                'Extinguisher.extinguisher_number',
            ),
            'joins' => array(
                array(
                    'table' => 'extinguishers',
                    'type' => 'left',
                    'alias' => 'Extinguisher',
                    'conditions' => array('Recharge.extinguisher_id = Extinguisher.id')
                )
            )
        );

        $Recharges = $this->Paginator->paginate();

        $this->set('recharges', $Recharges);
        $this->set(compact('limit'));
    }

    public function search()
    {
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'],
                $this->request->params['action'], $this->request->data['keyword']);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Recharge.reference' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('recharges', $this->Paginator->paginate('Recharge', array('OR' => array(
                "LOWER(recharge.code) LIKE" => "%$keyword%",
                "LOWER(Extinguisher.extinguisher_number) LIKE" => "%$keyword%"

            ))));
        } else {
            $this->Recharge->recursive = 0;
            $this->set('recharges', $this->Paginator->paginate());
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
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        if (!$this->Recharge->exists($id)) {
            throw new NotFoundException(__('Invalid recharge'));
        }
        $options = array('conditions' => array('Recharge.' . $this->Recharge->primaryKey => $id),
            'recursive' => -1,
            'paramType' => 'querystring',
            'fields' => array(
                'code',
                'Recharge.id',
                'recharge_date',

                'Extinguisher.extinguisher_number',


            ),
            'joins' => array(


                array(
                    'table' => 'extinguishers',
                    'type' => 'left',
                    'alias' => 'Extinguisher',
                    'conditions' => array('Recharge.extinguisher_id = Extinguisher.id')
                ),


            )
        );
        $this->set('recharge', $this->Recharge->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();

        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::recharge_extincteur, $user_id, ActionsEnum::add,
            "Recharges", null, "Recharge", null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->Recharge->create();
            $this->request->data['Recharge']['user_id'] = $this->Session->read('Auth.User.id');
            $this->createDateFromDate('Recharge', 'recharge_date');
            if ($this->Recharge->save($this->request->data)) {
                $this->Flash->success(__('The recharge has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The recharge could not be saved. Please, try again.'));
            }
        }

        $extinguishers = $this->Recharge->Extinguisher->find('list', array('order' => 'extinguisher_number ASC'));
        $this->set(compact('extinguishers'));

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
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();

        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::recharge_extincteur, $user_id, ActionsEnum::edit,
            "Recharges", $id, "Recharge", null);
        if (!$this->Recharge->exists($id)) {
            throw new NotFoundException(__('Invalid Recharge'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Recharge cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Recharge']['modified_id'] = $this->Session->read('Auth.User.id');
            $this->createDateFromDate('Recharge', 'date_verif');
            if ($this->Recharge->save($this->request->data)) {
                $this->Flash->success(__('The recharge has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The recharge could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Recharge.' . $this->Recharge->primaryKey => $id));
            $this->request->data = $this->Recharge->find('first', $options);


            $extinguishers = $this->Recharge->Extinguisher->find('list', array('order' => 'extinguisher_number ASC'));
            $this->set(compact('extinguishers'));

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
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();

        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::recharge_extincteur, $user_id, ActionsEnum::delete,
            "Recharges", $id, "Recharge", null);
        $this->Recharge->id = $id;
        if (!$this->Recharge->exists()) {
            throw new NotFoundException(__('Invalid Recharge'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Recharge->delete()) {
            $this->Flash->success(__('The recharge has been deleted.'));
        } else {
            $this->Flash->error(__('The recharge could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteRecharges()
    {
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');

        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $this->verifyUserPermission(SectionsEnum::recharge_extincteur, $user_id, ActionsEnum::delete,
            "Recharges", $id, "Recharge", null);


        $this->Recharge->id = $id;

        $this->request->allowMethod('post', 'delete');
        if ($this->Recharge->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }
        /*}else{
        echo json_encode(array("response" => "false"));
        }*/
    }


}
