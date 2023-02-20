<?php
App::uses('AppController', 'Controller');


/**
 * Extinguishers Controller
 *
 * @property Extinguisher $Extinguisher
 * @property Location $Location
 * @property Supplier $Supplier
 * @property Moving $Moving
 * @property Recharge $Recharge
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class ExtinguishersController extends AppController
{
    public $uses = array('Extinguisher', 'Location');
    public $components = array('Paginator', 'Security');
    var $helpers = array('Xls');

    public function index()
    {

        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }

        $this->setTimeActif();

        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::extincteur, $user_id, ActionsEnum::view, "Extinguishers", null, "Extinguisher", null);
        switch ($result) {
            case 1 :
                $conditions = null;

                break;
            case 2 :
                $conditions = array('Extinguisher.user_id ' => $user_id);

                break;
            case 3 :

                $conditions = array('Extinguisher.user_id !=' => $user_id);

                break;

            default:
                $conditions = null;


        }

        $this->paginate = array(
            'limit' => $limit,
            'conditions' => $conditions,
            'paramType' => 'querystring'
        );

        $extinguishers = $this->paginate('Extinguisher');
        $this->set(compact('extinguishers', 'limit'));
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
            'order' => array('Extinguisher.extinguisher_number' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->Extinguisher->recursive = 2;
            $this->set('extinguishers', $this->Paginator->paginate('Extinguisher', array('OR' => array(
                "LOWER(Extinguisher.extinguisher_number) LIKE" => "%$keyword%",
                "LOWER(Supplier.name) LIKE" => "%$keyword%"))));
        } else {
            $this->Extinguisher->recursive = 2;
            $this->set('extinguishers', $this->Paginator->paginate());
        }
        $this->set(compact('limit'));
        $this->render();
    }


    public function view($id = null)
    {

        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();

        if (!$this->Extinguisher->exists($id)) {
            throw new NotFoundException(__('Invalid Extinguisher'));
        }
        $options = array('conditions' => array('Extinguisher.' . $this->Extinguisher->primaryKey => $id));
        $this->set('extinguisher', $this->Extinguisher->find('first', $options));
    }


    public function add()
    {
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();

        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::extincteur, $user_id, ActionsEnum::add, "Extinguishers", null, "Extinguisher", null);

        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->Extinguisher->create();
            $this->request->data['Extinguisher']['user_id'] = $this->Session->read('Auth.User.id');

            $this->createDateFromDate('Extinguisher', 'validity_day_date');

            if ($this->Extinguisher->save($this->request->data)) {
                $this->Flash->success(__('The Extinguisher has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The Extinguisher could not be saved. Please, try again.'));
            }
        }
        $locations = $this->Location->getLocations();

        $suppliers = $this->Supplier->getSuppliersByParams(0, 1);

        $this->set(compact('locations', 'suppliers'));
    }

    public function edit($id = null)
    {
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::extincteur, $user_id, ActionsEnum::edit, "Extinguishers", $id, "Extinguisher", null);
        if (!$this->Extinguisher->exists($id)) {
            throw new NotFoundException(__('Invalid Extinguisher'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Model cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Extinguisher']['modified_id'] = $this->Session->read('Auth.User.id');
            $this->createDateFromDate('Extinguisher', 'validity_day_date');

            if ($this->Extinguisher->save($this->request->data)) {
                $this->Flash->success(__('The Extinguisher has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The Extinguisher could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Extinguisher.' . $this->Extinguisher->primaryKey => $id));
            $this->request->data = $this->Extinguisher->find('first', $options);
            //$this->is_opened("Carmodel",'Carmodels','model',$id);


            $locations = $this->Location->getLocations();
            $suppliers = $this->Supplier->getSuppliersByParams(0, 1);
            $this->set(compact('locations', 'suppliers'));
        }
    }

    public function delete($id = null)
    {

        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::extincteur, $user_id, ActionsEnum::delete, "Extinguishers", $id, "Extinguisher", null);
        $this->Extinguisher->id = $id;
        if (!$this->Extinguisher->exists()) {
            throw new NotFoundException(__('Invalid Extinguisher'));
        }

        $this->request->allowMethod('post', 'delete');
        $this->Extinguisher->id = $id;
        $this->verifyDependences($id);
        if ($this->Extinguisher->delete()) {
            $this->Flash->success(__('The Extinguisher has been deleted.'));
        } else {
            $this->Flash->error(__('The Extinguisher could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    private function verifyDependences($id)
    {
        $this->loadModel('Moving');
        $this->loadModel('Recharge');
        $this->setTimeActif();
        $result = $this->Moving->getMovingByForeignKey($id, "extinguisher_id");
        if (!empty($result)) {
            $this->Flash->error(__('The extinguisher could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        $result = $this->Recharge->getRechargeByForeignKey($id, "extinguisher_id");
        if (!empty($result)) {
            $this->Flash->error(__('The extinguisher could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }

    public function deleteextinguishers()
    {
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::extincteur, $user_id, ActionsEnum::delete, "Extinguishers", $user_id, "Extinguisher", null);
        $this->autoRender = false;

        $id = filter_input(INPUT_POST, "id");

        $this->Extinguisher->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Extinguisher->delete()) {
            echo json_encode(array("response" => "true"));

        } else {
            echo json_encode(array("response" => "false"));
        }
    }


}
