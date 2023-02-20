<?php

App::uses('AppController', 'Controller');

/**
 * ComplaintResponses Controller
 *
 * @property ComplaintResponse $ComplaintResponse
 * @property Complaint $Complaint
 * @property ComplaintCause $ComplaintCause
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class ComplaintResponsesController extends AppController {
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session','Security');
    var $helpers = array('Xls');
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $userId=$this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::reponse_reclamation, $userId, ActionsEnum::view,
            "ComplaintResponses", null, "ComplaintResponse" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                $conditions=array('ComplaintResponse.userId '=>$userId);
                break;
            case 3 :
                $conditions=array('ComplaintResponse.userId !='=>$userId);
                break;

            default:
                $conditions=null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('ComplaintResponse.reference' => 'ASC', 'ComplaintResponse.response_date' => 'ASC'),
            'conditions'=>$conditions,
            'recursive'=>-1,
            'fields'=>array(
                'ComplaintResponse.reference',
                'ComplaintResponse.id',
                'ComplaintResponse.response_date',
                'SheetRideDetailRides.reference',
                'TransportBillDetailRides.reference',
                'ComplaintResponse.reference',
                'Complaint.reference',
                'ComplaintCause.name',
                'Treatment.name',
            ),
            'joins'=>array(
                array(
                    'table' => 'complaints',
                    'type' => 'left',
                    'alias' => 'Complaint',
                    'conditions' => array('Complaint.id = ComplaintResponse.complaint_id')
                ),
                array(
                    'table' => 'sheet_ride_detail_rides',
                    'type' => 'left',
                    'alias' => 'SheetRideDetailRides',
                    'conditions' => array('SheetRideDetailRides.id = Complaint.sheet_ride_detail_ride_id')
                ),
                array(
                    'table' => 'observations',
                    'type' => 'left',
                    'alias' => 'Observation',
                    'conditions' => array('Observation.id = Complaint.observation_id')
                ),
                array(
                    'table' => 'transport_bill_detail_rides',
                    'type' => 'left',
                    'alias' => 'TransportBillDetailRides',
                    'conditions' => array('TransportBillDetailRides.id = Observation.transport_bill_detail_ride_id')
                ),

                array(
                    'table' => 'complaint_causes',
                    'type' => 'left',
                    'alias' => 'ComplaintCause',
                    'conditions' => array('ComplaintCause.id = Complaint.complaint_cause_id')
                ),
                array(
                    'table' => 'treatments',
                    'type' => 'left',
                    'alias' => 'Treatment',
                    'conditions' => array('Treatment.id = ComplaintResponse.treatment_id')
                ),

            ),
            'paramType' => 'querystring'
        );


        //Parametrer la pagination

        $complaintResponses = $this->Paginator->paginate();

        $this->set('complaintResponses', $complaintResponses);
        $this->set(compact('limit'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function search() {
        $this->setTimeActif();
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'],
                $this->request->params['action'], $this->request->data['keyword']);
        }

        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $conditions = array(
                'OR' => array(
                    "LOWER(Complaint.reference) LIKE" => "%$keyword%",
                    "LOWER(SheetRideDetailRides.reference) LIKE" => "%$keyword%"));
            $this->paginate = array(
                'limit' => $limit,
                'order' => array('ComplaintResponse.reference' => 'ASC', 'ComplaintResponse.response_date' => 'ASC'),
                'conditions'=>$conditions,
                'recursive'=>-1,
                'fields'=>array(
                    'ComplaintResponse.reference',
                    'ComplaintResponse.response_date',
                    'SheetRideDetailRides.reference',
                    'TransportBillDetailRides.reference',
                    'ComplaintResponse.reference',
                    'ComplaintCause.name',
                    'Treatment.name'
                ),
                'joins'=>array(
                    array(
                        'table' => 'complaints',
                        'type' => 'left',
                        'alias' => 'Complaint',
                        'conditions' => array('Complaint.id = ComplaintResponse.complaint_id')
                    ),
                    array(
                        'table' => 'sheet_ride_detail_rides',
                        'type' => 'left',
                        'alias' => 'SheetRideDetailRides',
                        'conditions' => array('SheetRideDetailRides.id = Complaint.sheet_ride_detail_ride_id')
                    ),
                    array(
                        'table' => 'observations',
                        'type' => 'left',
                        'alias' => 'Observation',
                        'conditions' => array('Observation.id = Complaint.observation_id')
                    ),
                    array(
                        'table' => 'transport_bill_detail_rides',
                        'type' => 'left',
                        'alias' => 'TransportBillDetailRides',
                        'conditions' => array('TransportBillDetailRides.id = Observation.transport_bill_detail_ride_id')
                    ),

                    array(
                        'table' => 'complaint_causes',
                        'type' => 'left',
                        'alias' => 'ComplaintCause',
                        'conditions' => array('ComplaintCause.id = Complaint.complaint_cause_id')
                    ),
                    array(
                        'table' => 'treatments',
                        'type' => 'left',
                        'alias' => 'Treatment',
                        'conditions' => array('Treatment.id = ComplaintResponse.treatment_id')
                    ),

                ),
                'paramType' => 'querystring'
            );



            //Parametrer la pagination

            $complaintResponses = $this->Paginator->paginate();

            $this->set('complaintResponses', $complaintResponses);

        } else {
            $this->paginate = array(
                'limit' => $limit,
                'order' => array('ComplaintResponse.reference' => 'ASC', 'ComplaintResponse.response_date' => 'ASC'),
                'recursive'=>-1,
                'fields'=>array(
                    'ComplaintResponse.reference',
                    'ComplaintResponse.response_date',
                    'SheetRideDetailRides.reference',
                    'TransportBillDetailRides.reference',
                    'ComplaintResponse.reference',
                    'ComplaintCause.name',
                    'Treatment.name'
                ),
                'joins'=>array(
                    array(
                        'table' => 'complaints',
                        'type' => 'left',
                        'alias' => 'Complaint',
                        'conditions' => array('Complaint.id = ComplaintResponse.complaint_id')
                    ),
                    array(
                        'table' => 'sheet_ride_detail_rides',
                        'type' => 'left',
                        'alias' => 'SheetRideDetailRides',
                        'conditions' => array('SheetRideDetailRides.id = Complaint.sheet_ride_detail_ride_id')
                    ),
                    array(
                        'table' => 'observations',
                        'type' => 'left',
                        'alias' => 'Observation',
                        'conditions' => array('Observation.id = Complaint.observation_id')
                    ),
                    array(
                        'table' => 'transport_bill_detail_rides',
                        'type' => 'left',
                        'alias' => 'TransportBillDetailRides',
                        'conditions' => array('TransportBillDetailRides.id = Observation.transport_bill_detail_ride_id')
                    ),

                    array(
                        'table' => 'complaint_causes',
                        'type' => 'left',
                        'alias' => 'ComplaintCause',
                        'conditions' => array('ComplaintCause.id = Complaint.complaint_cause_id')
                    ),
                    array(
                        'table' => 'treatments',
                        'type' => 'left',
                        'alias' => 'Treatment',
                        'conditions' => array('Treatment.id = ComplaintResponse.treatment_id')
                    ),

                ),
                'paramType' => 'querystring'
            );



            //Parametrer la pagination

            $complaintResponses = $this->Paginator->paginate();

            $this->set('complaintResponses', $complaintResponses);
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
    public function view($id = null) {
        $this->setTimeActif();

        if (!$this->ComplaintResponse->exists($id)) {
            throw new NotFoundException(__('Invalid response.'));
        }
        $options = array('conditions' => array('ComplaintResponse.' . $this->ComplaintResponse->primaryKey => $id));
        $this->set('complaintResponse', $this->ComplaintResponse->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::reponse_reclamation, $user_id,
            ActionsEnum::add, "ComplaintResponses", null, "ComplaintResponse" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->ComplaintResponse->create();
            $this->createDateFromDate('ComplaintResponse', 'response_date');
            $this->request->data['ComplaintResponse']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->ComplaintResponse->save($this->request->data)) {

                $this->Flash->success(__('The response has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The response could not be saved. Please, try again.'));
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
    public function edit($id = null) {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::reclamation, $user_id, ActionsEnum::edit,
            "ComplaintResponses", $id, "ComplaintResponse" ,null);
        if (!$this->ComplaintResponse->exists($id)) {
            throw new NotFoundException(__('Invalid response'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Response cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->createDateFromDate('ComplaintResponse', 'response_date');
            $this->request->data['ComplaintResponse']['modified_id'] = $this->Session->read('Auth.User.id');
            if ($this->ComplaintResponse->save($this->request->data)) {

                $this->Flash->success(__('The response has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The response could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ComplaintResponse.' . $this->ComplaintResponse->primaryKey => $id));
            $this->request->data = $this->ComplaintResponse->find('first', $options);
            $this->loadModel('Treatment');
            $treatments = $this->Treatment->find('list');
            $this->set(compact('treatments'));

        }

    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::reclamation, $user_id, ActionsEnum::delete,
            "ComplaintResponses", $id, "ComplaintResponse" ,null);
        $this->ComplaintResponse->id = $id;
        if (!$this->ComplaintResponse->exists()) {
            throw new NotFoundException(__('Invalid response'));
        }
        //$this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->ComplaintResponse->delete()) {

            $this->Flash->success(__('The response has been deleted.'));
        } else {

            $this->Flash->error(__('The response could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteResponses() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::reclamation, $user_id, ActionsEnum::delete,
            "ComplaintResponses", $id, "ComplaintResponse" ,null);
        $this->ComplaintResponse->id = $id;
        //$this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->ComplaintResponse->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }
        /*}else{
            echo json_encode(array("response" => "false"));
        }*/
    }
    private function verifyDependences($id){
        $this->setTimeActif();
        $this->loadModel('Complaint');
        $result = $this->Complaint->getCustomerByForeignKey($id, 'complaint_cause_id');
        if (!empty($result)) {
            $this->Flash->error(__('The complaint cause could not be deleted. '
                . 'Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }


    function addResponse($complaintId = null)
    {
        $this->layout = 'ajax';


        if (!empty($this->request->data)) {


                    $this->request->data['ComplaintResponse']['complaint_id'] = $complaintId;

                    $this->ComplaintResponse->create();
                    $this->createDateFromDate('ComplaintResponse', 'response_date');
                    $this->request->data['ComplaintResponse']['user_id'] = $this->Session->read('Auth.User.id');
                    $this->ComplaintResponse->save($this->request->data);
                    $userId = $this->Auth->user('id');
                    $actionId = ActionsEnum::add;
                    $complaintResponseId = $this->ComplaintResponse->getInsertID();


                    $receivers = $this->User->getCommercialsReceiverPlannerNotifications();
                    if (!empty($receivers)) {
                        $this->Notification->addNotification($complaintResponseId, $userId, $receivers, $actionId,'Mission');

                    }
                    $this->getNbNotificationsByUser();






            $this->Flash->success(__('The response has been saved.'));

            $this->redirect(array('action' => 'index'));
        }

        $this->loadModel('Treatment');
        $treatments = $this->Treatment->find('list');
        $this->set(compact('treatments'));
        $this->set('complaintId', $complaintId);
    }




}
