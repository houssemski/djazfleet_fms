<?php

App::uses('AppController', 'Controller');

/**
 * EventTypes Controller
 *
 * @property Warning $Warning
 * @property Customer $Customer
 * @property WarningType $WarningType
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class WarningsController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Security');
    public $uses = array('Warning', 'Customer','WarningType');
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
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::avertissement, $userId, ActionsEnum::view, "Warnings",
            null, "Warning", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        //Parametrer la pagination

        switch ($result) {
            case 1 :

                $conditions = array('Warning.id > ' => 0);
                break;
            case 2 :
                $conditions = array('Warning.id > ' => 0, 'Warning.user_id ' => $userId);
                break;
            case 3 :
                $conditions = array('Warning.id > ' => 0, 'Warning.user_id !=' => $userId);
                break;

            default:
                $conditions = array('Warning.id > ' => 0);;
        }
        $this->paginate = array(
            'limit' => $limit,
            'recursive'=>-1,
            'order' => array('Warning.code' => 'ASC'),
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'fields'=>array(
                'Customer.first_name',
                'Customer.last_name',
                'Warning.id',
                'WarningType.name',
                'Warning.start_date',
                'Warning.end_date',
                'Warning.code',
            ),
            'joins'=>array(
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Customer.id = Warning.customer_id')
                ),

                array(
                    'table' => 'warning_types',
                    'type' => 'left',
                    'alias' => 'WarningType',
                    'conditions' => array('WarningType.id = Warning.warning_type_id')
                ),
            )
        );

        $warnings = $this->Paginator->paginate('Warning');
        $this->set('warnings', $warnings);
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

        if (isset($this->params['named']['keyword'])) {

            $keyword = $this->params['named']['keyword'];
            $this->paginate = array(
                'limit' => $limit,
                'recursive'=>-1,
                'order' => array('Warning.visit_number' => 'ASC'),
                'paramType' => 'querystring',
                'conditions'=>array( 'OR' => array(
                    "LOWER(Warning.visit_number) LIKE" => "%$keyword%",
                    "LOWER(Customer.first_name) LIKE" => "%$keyword%",
                    "LOWER(Customer.last_name) LIKE" => "%$keyword%",
                )),
                'fields'=>array(
                    'Customer.first_name',
                    'Customer.last_name',
                    'Warning.id',
                    'WarningType.name',
                    'Warning.start_date',
                    'Warning.end_date',
                ),
                'joins'=>array(
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('Customer.id = Warning.customer_id')
                    ),
                    array(
                        'table' => 'warning_types',
                        'type' => 'left',
                        'alias' => 'WarningType',
                        'conditions' => array('WarningType.id = Warning.warning_type_id')
                    ),
                )
            );

            $warnings = $this->Paginator->paginate('Warning');
            $this->set('warnings', $warnings);


        } else {
            $this->paginate = array(
                'limit' => $limit,
                'recursive'=>-1,
                'order' => array('Warning.code' => 'ASC'),
                'paramType' => 'querystring',
                'fields'=>array(
                    'Customer.first_name',
                    'Customer.last_name',
                    'Warning.id',
                    'WarningType.name',
                    'Warning.start_date',
                    'Warning.end_date',
                ),
                'joins'=>array(
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('Customer.id = Warning.customer_id')
                    ),
                    array(
                        'table' => 'warning_types',
                        'type' => 'left',
                        'alias' => 'WarningType',
                        'conditions' => array('WarningType.id = Warning.warning_type_id')
                    ),
                )
            );

            $warnings = $this->Paginator->paginate('Warning');
            $this->set('warnings', $warnings);
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
        if (!$this->Warning->exists($id)) {
            throw new NotFoundException(__('Invalid warning'));
        }
        $options = array('conditions' => array('Warning.' . $this->Warning->primaryKey => $id));
        $warning = $this->Warning->find('first', $options);
        $this->set('warning', $warning);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        $this->setTimeActif();
        $userId = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::avertissement, $userId, ActionsEnum::add, "Warnings", null,
            "Warning", null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }


        if ($this->request->is('post')) {
            $this->verifyAttachment('Product', 'attachment', 'attachments/avertissements/', 'add', 1, 0, null);
            $this->Warning->create();
            $this->request->data['Warning']['user_id'] = $this->Session->read('Auth.User.id');
            $this->createDateFromDate('Warning', 'start_date');
            $this->createDateFromDate('Warning', 'end_date');
            if ($this->Warning->save($this->request->data)) {
                $this->Flash->success(__('The warning has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The warning could not be saved. Please, try again.'));
            }
        }
        $warningTypes = $this->WarningType->getWarningTypes('list');
        $this->set(compact('warningTypes'));
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
        $this->verifyUserPermission(SectionsEnum::avertissement, $user_id, ActionsEnum::edit, "Warnings", $id,
            "Warning", null);
        if (!$this->Warning->exists($id)) {
            throw new NotFoundException(__('Invalid warning'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Warning cancelled.'));
                $this->redirect(array('action' => 'index'));
            }

            if ($this->request->data['Warning']['file'] == '') {
                $this->deleteAttachment('Warning', 'attachment', 'attachments/avertissements/', $id);
                $this->verifyAttachment('Warning', 'attachment', 'attachments/avertissements/', 'add', 1, 0, $id);
            } else {
                $this->verifyAttachment('Warning', 'attachment', 'attachments/avertissements/', 'edit', 1, 0, $id);
            }
            $this->request->data['Warning']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            $this->createDateFromDate('Warning', 'start_date');
            $this->createDateFromDate('Warning', 'end_date');
            if ($this->Warning->save($this->request->data)) {
                $this->Flash->success(__('The warning has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The warning could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Warning.' . $this->Warning->primaryKey => $id));
            $this->request->data = $this->Warning->find('first', $options);
            $fields = "names";
            $conditionsCustomer = array('Customer.id' => $this->request->data['Warning']['customer_id']);
            $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditionsCustomer);
            $warningTypes = $this->WarningType->getWarningTypes('list');
            $this->set(compact('warningTypes','customers'));

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
        $this->verifyUserPermission(SectionsEnum::avertissement, $user_id, ActionsEnum::delete, "Warnings", $id,
            "Warning", null);
        $this->Warning->id = $id;
        if (!$this->Warning->exists()) {
            throw new NotFoundException(__('Invalid warning'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Warning->delete()) {
            $this->Flash->success(__('The warning has been deleted.'));
        } else {
            $this->Flash->error(__('The warning could not be deleted. Please, try again.'));
        }

        $this->redirect(array('action' => 'index'));
    }


    public function deleteWarnings()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::avertissement, $user_id, ActionsEnum::delete, "Warnings", $id,
            "Warning", null);
        $this->Warning->id = $id;
        $this->request->allowMethod('post', 'delete');
        if ($this->Warning->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }

    }


}
