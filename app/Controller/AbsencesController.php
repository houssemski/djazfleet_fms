<?php

App::uses('AppController', 'Controller');

/**
 * EventTypes Controller
 *
 * @property Absence $Absence
 * @property Customer $Customer
 * @property AbsenceReason $AbsenceReason
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class AbsencesController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Security');
    public $uses = array('Absence', 'Customer','AbsenceReason');
    var $helpers = array('Xls', 'Tinymce');

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
        $result = $this->verifyUserPermission(SectionsEnum::absence, $userId, ActionsEnum::view, "Absences",
            null, "Absence", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        //Parametrer la pagination

        switch ($result) {
            case 1 :

                $conditions = array('Absence.id > ' => 0);
                break;
            case 2 :
                $conditions = array('Absence.id > ' => 0, 'Absence.user_id ' => $userId);
                break;
            case 3 :
                $conditions = array('Absence.id > ' => 0, 'Absence.user_id !=' => $userId);
                break;

            default:
                $conditions = array('Absence.id > ' => 0);;
        }
        $this->paginate = array(
            'limit' => $limit,
            'recursive'=>-1,
            'order' => array('Absence.code' => 'ASC'),
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'fields'=>array(
                'Customer.first_name',
                'Customer.last_name',
                'Absence.id',
                'AbsenceReason.name',
                'Absence.start_date',
                'Absence.end_date',
                'Absence.code',
            ),
            'joins'=>array(
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Customer.id = Absence.customer_id')
                ),

                array(
                    'table' => 'absence_reasons',
                    'type' => 'left',
                    'alias' => 'AbsenceReason',
                    'conditions' => array('AbsenceReason.id = Absence.absence_reason_id')
                ),
            )
        );

        $absences = $this->Paginator->paginate('Absence');
        $this->set('absences', $absences);
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
                'order' => array('Absence.id' => 'ASC'),
                'paramType' => 'querystring',
                'conditions'=>array( 'OR' => array(
                    "LOWER(Absence.id) LIKE" => "%$keyword%",
                    "LOWER(Customer.first_name) LIKE" => "%$keyword%",
                    "LOWER(Customer.last_name) LIKE" => "%$keyword%",
                )),
                'fields'=>array(
                    'Customer.first_name',
                    'Customer.last_name',
                    'Absence.id',
                    'AbsenceReason.name',
                    'Absence.start_date',
                    'Absence.end_date',
                ),
                'joins'=>array(
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('Customer.id = Absence.customer_id')
                    ),
                    array(
                        'table' => 'absence_reasons',
                        'type' => 'left',
                        'alias' => 'AbsenceReason',
                        'conditions' => array('AbsenceReason.id = Absence.absence_reason_id')
                    ),
                )
            );

            $absences = $this->Paginator->paginate('Absence');
            $this->set('absences', $absences);


        } else {
            $this->paginate = array(
                'limit' => $limit,
                'recursive'=>-1,
                'order' => array('Absence.code' => 'ASC'),
                'paramType' => 'querystring',
                'fields'=>array(
                    'Customer.first_name',
                    'Customer.last_name',
                    'Absence.id',
                    'AbsenceReason.name',
                    'Absence.start_date',
                    'Absence.end_date',
                ),
                'joins'=>array(
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('Customer.id = Absence.customer_id')
                    ),
                    array(
                        'table' => 'absence_reasons',
                        'type' => 'left',
                        'alias' => 'AbsenceReason',
                        'conditions' => array('AbsenceReason.id = Absence.absence_reason_id')
                    ),
                )
            );

            $absences = $this->Paginator->paginate('Absence');
            $this->set('absences', $absences);
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
        if (!$this->Absence->exists($id)) {
            throw new NotFoundException(__('Invalid absence.'));
        }
        $options = array('conditions' => array('Absence.' . $this->Absence->primaryKey => $id));
        $absence = $this->Absence->find('first', $options);
        $this->set('absence', $absence);
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
        $this->verifyUserPermission(SectionsEnum::absence, $userId, ActionsEnum::add, "Absences", null,
            "Absence", null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }


        if ($this->request->is('post')) {
            $this->verifyAttachment('Product', 'attachment', 'attachments/absences/', 'add', 1, 0, null);
            $this->Absence->create();
            $this->request->data['Absence']['user_id'] = $this->Session->read('Auth.User.id');
            $this->createDateFromDate('Absence', 'start_date');
            $this->createDateFromDate('Absence', 'end_date');
            if ($this->Absence->save($this->request->data)) {
                $this->Flash->success(__('The absence has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The absence could not be saved. Please, try again.'));
            }
        }
        $absenceReasons = $this->AbsenceReason->getAbsenceReasons('list');
        $this->set(compact('absenceReasons'));
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
        $this->verifyUserPermission(SectionsEnum::absence, $user_id, ActionsEnum::edit, "Absences", $id,
            "Absence", null);
        if (!$this->Absence->exists($id)) {
            throw new NotFoundException(__('Invalid absence.'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Absence cancelled.'));
                $this->redirect(array('action' => 'index'));
            }

            if ($this->request->data['Absence']['file'] == '') {
                $this->deleteAttachment('Absence', 'attachment', 'attachments/absences/', $id);
                $this->verifyAttachment('Absence', 'attachment', 'attachments/absences/', 'add', 1, 0, $id);
            } else {
                $this->verifyAttachment('Absence', 'attachment', 'attachments/absences/', 'edit', 1, 0, $id);
            }
            $this->request->data['Absence']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            $this->createDateFromDate('Absence', 'start_date');
            $this->createDateFromDate('Absence', 'end_date');
            if ($this->Absence->save($this->request->data)) {
                $this->Flash->success(__('The absence has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The absence could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Absence.' . $this->Absence->primaryKey => $id));
            $this->request->data = $this->Absence->find('first', $options);
            $fields = "names";
            $conditionsCustomer = array('Customer.id' => $this->request->data['Absence']['customer_id']);
            $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditionsCustomer);
            $absenceReasons = $this->AbsenceReason->getAbsenceReasons('list');
            $this->set(compact('absenceReasons','customers'));

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
        $this->verifyUserPermission(SectionsEnum::absence, $user_id, ActionsEnum::delete, "Absences", $id,
            "Absence", null);
        $this->Absence->id = $id;
        if (!$this->Absence->exists()) {
            throw new NotFoundException(__('Invalid absence.'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Absence->delete()) {
            $this->Flash->success(__('The absence has been deleted.'));
        } else {
            $this->Flash->error(__('The absence could not be deleted. Please, try again.'));
        }

        $this->redirect(array('action' => 'index'));
    }


    public function deleteAbsences()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::absence, $user_id, ActionsEnum::delete, "Absences", $id,
            "Absence", null);
        $this->Absence->id = $id;
        $this->request->allowMethod('post', 'delete');
        if ($this->Absence->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }

    }


}
