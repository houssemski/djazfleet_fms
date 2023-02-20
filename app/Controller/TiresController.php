<?php
App::uses('AppController', 'Controller');

/**
 * Tires Controller
 *
 * @property Tire $Tire
 * @property Supplier $Supplier
 * @property TireMark $TireMark
 * @property Shifting $Shifting
 * @property Verification $Verification
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class TiresController extends AppController
{
    public $uses = array('Tire', 'TireMark');
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

        $result = $this->verifyUserPermission(SectionsEnum::pneu, $user_id, ActionsEnum::view,
            "Tires", null, "Tire", null);
        switch ($result) {
            case 1 :
                $conditions = null;

                break;
            case 2 :


                $conditions = array('Tire.user_id ' => $user_id);

                break;
            case 3 :


                $conditions = array('Tire.user_id !=' => $user_id);

                break;

            default:
                $conditions = null;


        }

        $this->paginate = array(
            'limit' => $limit,
            'conditions' => $conditions,
            'paramType' => 'querystring'
        );

        $tires = $this->paginate('Tire');
        $this->set(compact('tires', 'limit'));
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
            'order' => array('Tire.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('tires', $this->Paginator->paginate('Tire', array('OR' => array(
                "LOWER(Tire.code) LIKE" => "%$keyword%",
                "LOWER(Tire.model) LIKE" => "%$keyword%"))));
        } else {
            $this->Tire->recursive = 0;
            $this->set('tires', $this->Paginator->paginate());
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

        if (!$this->Tire->exists($id)) {
            throw new NotFoundException(__('Invalid tire'));
        }
        $options = array('conditions' => array('Tire.' . $this->Tire->primaryKey => $id));
        $this->set('tire', $this->Tire->find('first', $options));
    }


    public function add()
    {

        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::pneu, $user_id, ActionsEnum::add, "Tires", null, "Tire", null);

        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->Tire->create();
            $this->request->data['Tire']['user_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['Tire']['model_id'] = $this->Session->read('Auth.User.id');
            $this->createDateFromDate('Tire', 'purchase_date');
            $this->verifyAttachment('Tire', 'attachment', 'attachments/suppliers/', 'add', 0, 0, null);
            if ($this->Tire->save($this->request->data)) {
                $this->Flash->success(__('The tire has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The tire could not be saved. Please, try again.'));
            }
        }
        $tireMarks = $this->TireMark->getTireMarks();

        $suppliers = $this->Supplier->getSuppliersByParams(0, 1);

        $this->set(compact('tireMarks', 'suppliers'));
    }

    public function edit($id = null)
    {

        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::pneu, $user_id, ActionsEnum::edit, "Tires", $id, "Tire", null);
        if (!$this->Tire->exists($id)) {
            throw new NotFoundException(__('Invalid tire'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Tire cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Tire']['modified_id'] = $this->Session->read('Auth.User.id');
            $this->createDateFromDate('Tire', 'purchase_date');
            $this->verifyAttachment('Tire', 'attachment', 'attachments/suppliers/', 'edit', 0, 0, null);
            if ($this->Tire->save($this->request->data)) {
                $this->Flash->success(__('The tire has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The tire could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Tire.' . $this->Tire->primaryKey => $id));
            $this->request->data = $this->Tire->find('first', $options);

            $tireMarks = $this->TireMark->getTireMarks();
            $suppliers = $this->Supplier->getSuppliersByParams(0, 1);
            $this->set(compact('tireMarks', 'suppliers'));
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
        $this->verifyUserPermission(SectionsEnum::pneu, $user_id, ActionsEnum::delete, "Tires", $id, "Tire", null);
        $this->Tire->id = $id;
        if (!$this->Tire->exists()) {
            throw new NotFoundException(__('Invalid tire'));
        }

        $this->request->allowMethod('post', 'delete');
        $this->Tire->id = $id;
        $this->verifyDependences($id);
        if ($this->Tire->delete()) {
            $this->Flash->success(__('The tire has been deleted.'));
        } else {
            $this->Flash->error(__('The tire could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $this->loadModel('Shifting');
        $this->loadModel('Verification');
        $result = $this->Shifting->getShiftingByForeignKey($id, "tire_id");
        if (!empty($result)) {
            $this->Flash->error(__('The tire could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        $result = $this->Verification->getVerificationByForeignKey($id, "tire_id");
        if (!empty($result)) {
            $this->Flash->error(__('The tire could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }

    public function deletetires()
    {

        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $this->autoRender = false;
        $user_id = $this->Auth->user('id');

        $id = filter_input(INPUT_POST, "id");
        $this->verifyDependences($id);
        $this->verifyUserPermission(SectionsEnum::pneu, $user_id, ActionsEnum::delete, "Tires", $id, "Tire", null);
        $this->Tire->id = $id;
        $this->request->allowMethod('post', 'delete');
        if ($this->Tire->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }

    }

}
