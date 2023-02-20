<?php

App::uses('AppController', 'Controller');

/**
 * EventTypes Controller
 *
 * @property MedicalVisit $MedicalVisit
 * @property Customer $Customer
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class MedicalVisitsController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Security');
    public $uses = array('MedicalVisit', 'Customer');
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
        $result = $this->verifyUserPermission(SectionsEnum::visite_medicale, $userId, ActionsEnum::view, "MedicalVisits",
            null, "MedicalVisit", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        //Parametrer la pagination

        switch ($result) {
            case 1 :

                $conditions = array('MedicalVisit.id > ' => 0);
                break;
            case 2 :
                $conditions = array('MedicalVisit.id > ' => 0, 'MedicalVisit.user_id ' => $userId);
                break;
            case 3 :
                $conditions = array('MedicalVisit.id > ' => 0, 'MedicalVisit.user_id !=' => $userId);
                break;

            default:
                $conditions = array('MedicalVisit.id > ' => 0);;
        }
          $this->paginate = array(
            'limit' => $limit,
            'recursive'=>-1,
            'order' => array('MedicalVisit.visit_number' => 'ASC'),
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'fields'=>array(
                'Customer.first_name',
                'Customer.last_name',
                'MedicalVisit.id',
                'MedicalVisit.date',
                'MedicalVisit.visit_number',
                'MedicalVisit.internal_external',
                'MedicalVisit.consulting_doctor',
            ),
            'joins'=>array(
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Customer.id = MedicalVisit.customer_id')
                ),
            )
        );

        $medicalVisits = $this->Paginator->paginate('MedicalVisit');
        $this->set('medicalVisits', $medicalVisits);
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
                'order' => array('MedicalVisit.visit_number' => 'ASC'),
                'paramType' => 'querystring',
                'conditions'=>array( 'OR' => array(
                    "LOWER(MedicalVisit.visit_number) LIKE" => "%$keyword%",
                    "LOWER(Customer.first_name) LIKE" => "%$keyword%",
                    "LOWER(Customer.last_name) LIKE" => "%$keyword%",
                )),
                'fields'=>array(
                    'Customer.first_name',
                    'Customer.last_name',
                    'MedicalVisit.id',
                    'MedicalVisit.date',
                    'MedicalVisit.visit_number',
                    'MedicalVisit.internal_external',
                    'MedicalVisit.consulting_doctor',
                ),
                'joins'=>array(
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('Customer.id = MedicalVisit.customer_id')
                    ),
                )
            );

            $medicalVisits = $this->Paginator->paginate('MedicalVisit');
            $this->set('medicalVisits', $medicalVisits);


        } else {
            $this->paginate = array(
                'limit' => $limit,
                'recursive'=>-1,
                'order' => array('MedicalVisit.code' => 'ASC'),
                'paramType' => 'querystring',
                'fields'=>array(
                    'Customer.first_name',
                    'Customer.last_name',
                    'MedicalVisit.id',
                    'MedicalVisit.date',
                    'MedicalVisit.visit_number',
                    'MedicalVisit.internal_external',
                    'MedicalVisit.consulting_doctor',
                ),
                'joins'=>array(
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('Customer.id = MedicalVisit.customer_id')
                    ),
                )
            );

            $medicalVisits = $this->Paginator->paginate('MedicalVisit');
            $this->set('medicalVisits', $medicalVisits);
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
        if (!$this->MedicalVisit->exists($id)) {
            throw new NotFoundException(__('Invalid medical visit'));
        }
        $options = array('conditions' => array('MedicalVisit.' . $this->MedicalVisit->primaryKey => $id));
        $medicalVisit = $this->MedicalVisit->find('first', $options);
        $this->set('medicalVisit', $medicalVisit);
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
        $this->verifyUserPermission(SectionsEnum::visite_medicale, $userId, ActionsEnum::add, "MedicalVisits", null,
            "MedicalVisit", null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }


        if ($this->request->is('post')) {
            $this->verifyAttachment('Product', 'attachment', 'attachments/medical_visits/', 'add', 1, 0, null);
            $this->MedicalVisit->create();
            $this->request->data['MedicalVisit']['user_id'] = $this->Session->read('Auth.User.id');
            $this->createDatetimeFromDate('MedicalVisit', 'date');
            if ($this->MedicalVisit->save($this->request->data)) {
                $this->Flash->success(__('The event type has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The event type could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::visite_medicale, $user_id, ActionsEnum::edit, "MedicalVisits", $id,
            "MedicalVisit", null);
        if (!$this->MedicalVisit->exists($id)) {
            throw new NotFoundException(__('Invalid medical visit'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Event type cancelled.'));
                $this->redirect(array('action' => 'index'));
            }

            if ($this->request->data['MedicalVisit']['file'] == '') {
                $this->deleteAttachment('MedicalVisit', 'attachment', 'attachments/medical_visits/', $id);
                $this->verifyAttachment('MedicalVisit', 'attachment', 'attachments/medical_visits/', 'add', 1, 0, $id);
            } else {
                $this->verifyAttachment('MedicalVisit', 'attachment', 'attachments/medical_visits/', 'edit', 1, 0, $id);
            }
            $this->request->data['MedicalVisit']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            $this->createDatetimeFromDate('MedicalVisit', 'date');
            if ($this->MedicalVisit->save($this->request->data)) {
                $this->Flash->success(__('The event type has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The event type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('MedicalVisit.' . $this->MedicalVisit->primaryKey => $id));
            $this->request->data = $this->MedicalVisit->find('first', $options);
            $fields = "names";
            $conditionsCustomer = array('Customer.id' => $this->request->data['MedicalVisit']['customer_id']);
            $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditionsCustomer);
            $this->set('customers',$customers);
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
        $this->verifyUserPermission(SectionsEnum::visite_medicale, $user_id, ActionsEnum::delete, "MedicalVisits", $id,
            "MedicalVisit", null);
        $this->MedicalVisit->id = $id;
        if (!$this->MedicalVisit->exists()) {
            throw new NotFoundException(__('Invalid medical visit'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->MedicalVisit->delete()) {
            $this->Flash->success(__('The event type has been deleted.'));
        } else {
            $this->Flash->error(__('The event type could not be deleted. Please, try again.'));
        }

        $this->redirect(array('action' => 'index'));
    }


    public function deleteMedicalVisits()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::visite_medicale, $user_id, ActionsEnum::delete, "MedicalVisits", $id,
            "MedicalVisit", null);
        $this->MedicalVisit->id = $id;
        $this->request->allowMethod('post', 'delete');
        if ($this->MedicalVisit->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }

    }


}
