<?php

App::uses('AppController', 'Controller');

/**
 * CustomerCategories Controller
 *
 * @property Complaint $Complaint
 * @property ComplaintCause $ComplaintCause
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class ComplaintsController extends AppController {
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
        $result = $this->verifyUserPermission(SectionsEnum::reclamation, $userId, ActionsEnum::view, "Complaints", null, "Complaint" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                $conditions=array('Complaint.userId '=>$userId);
                break;
            case 3 :
                $conditions=array('Complaint.userId !='=>$userId);
                break;

            default:
                $conditions=null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Complaint.reference' => 'ASC', 'Complaint.taken_over_date' => 'ASC'),
            'conditions'=>$conditions,
            'recursive'=>-1,
            'fields'=>array(
                'Complaint.reference',
                'Complaint.taken_over_date',
                'SheetRideDetailRides.reference',
                'TransportBillDetailRides.reference',
                'ComplaintCause.name',
                'Complaint.status_id',
                'Complaint.type',
                'Complaint.id'
            ),
            'joins'=>array(
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
            ),
            'paramType' => 'querystring'
        );
        //Parametrer la pagination

        $complaints = $this->Paginator->paginate();

        $this->set('complaints', $complaints);
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
                'order' => array('Complaint.reference' => 'ASC', 'Complaint.taken_over_date' => 'ASC'),
                'conditions'=>$conditions,
                'recursive'=>-1,
                'fields'=>array(
                    'Complaint.reference',
                    'Complaint.taken_over_date',
                    'SheetRideDetailRides.reference',
                    'ComplaintCause.name',
                    'Complaint.status_id',
                    'Complaint.type',
                    'Complaint.origin',
                    'Complaint.id',
                    'Complaint.solutionable',
                ),
                'joins'=>array(
                    array(
                        'table' => 'sheet_ride_detail_rides',
                        'type' => 'left',
                        'alias' => 'SheetRideDetailRides',
                        'conditions' => array('SheetRideDetailRides.id = Complaint.sheet_ride_detail_ride_id')
                    ),

                    array(
                        'table' => 'complaint_causes',
                        'type' => 'left',
                        'alias' => 'ComplaintCause',
                        'conditions' => array('ComplaintCause.id = Complaint.complaint_cause_id')
                    ),
                ),
                'paramType' => 'querystring'
            );



            //Parametrer la pagination

            $complaints = $this->Paginator->paginate();

            $this->set('complaints', $complaints);

        } else {
            $this->paginate = array(
                'limit' => $limit,
                'order' => array('Complaint.reference' => 'ASC', 'Complaint.taken_over_date' => 'ASC'),

                'recursive'=>-1,
                'fields'=>array(
                    'Complaint.reference',
                    'Complaint.taken_over_date',
                    'SheetRideDetailRides.reference',
                    'ComplaintCause.name',
                    'Complaint.status_id',
                    'Complaint.type',
                    'Complaint.origin',
                    'Complaint.id',
                    'Complaint.solutionable',
                ),
                'joins'=>array(
                    array(
                        'table' => 'sheet_ride_detail_rides',
                        'type' => 'left',
                        'alias' => 'SheetRideDetailRides',
                        'conditions' => array('SheetRideDetailRides.id = Complaint.sheet_ride_detail_ride_id')
                    ),

                    array(
                        'table' => 'complaint_causes',
                        'type' => 'left',
                        'alias' => 'ComplaintCause',
                        'conditions' => array('ComplaintCause.id = Complaint.complaint_cause_id')
                    ),
                ),
                'paramType' => 'querystring'
            );



            //Parametrer la pagination

            $complaints = $this->Paginator->paginate();

            $this->set('complaints', $complaints);
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

        if (!$this->Complaint->exists($id)) {
            throw new NotFoundException(__('Invalid complaint.'));
        }
        $options = array('conditions' => array('Complaint.' . $this->Complaint->primaryKey => $id));
        $this->set('complaint', $this->Complaint->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::reclamation, $user_id,
            ActionsEnum::add, "Complaints", null, "Cancel" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Complaint->create();
            $this->createDateFromDate('Complaint', 'taken_over_date');
            $this->request->data['Complaint']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Complaint->save($this->request->data)) {
                $this->Complaint->updateNbComplaintsByMissions($this->request->data['Complaint']['sheet_ride_detail_ride_id']);
                $this->Flash->success(__('The complaint has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The complaint could not be saved. Please, try again.'));
            }
        }
        $this->loadModel('ComplaintCause');
        $complaintCauses = $this->ComplaintCause->find('list');
        $this->set(compact('complaintCauses'));
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
        $this->verifyUserPermission(SectionsEnum::reclamation, $user_id, ActionsEnum::edit, "Complaints", $id, "Cancel" ,null);
        if (!$this->Complaint->exists($id)) {
            throw new NotFoundException(__('Invalid complaint'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Complaint cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->createDateFromDate('Complaint', 'taken_over_date');
            $this->request->data['Complaint']['modified_id'] = $this->Session->read('Auth.User.id');
            if ($this->Complaint->save($this->request->data)) {

                $this->Flash->success(__('The complaint has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The complaint could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Complaint.' . $this->Complaint->primaryKey => $id));
            $this->request->data = $this->Complaint->find('first', $options);

        }
        $this->loadModel('ComplaintCause');
        $complaintCauses = $this->ComplaintCause->find('list');
        $this->loadModel('SheetRideDetailRides');
        $sheetRideDetailRides = $this->SheetRideDetailRides->find('list',
            array(
                'recursive'=>-1,
                'fields'=>array('SheetRideDetailRides.id','SheetRideDetailRides.reference'),
                'conditions'=>array('SheetRideDetailRides.id'=>$this->request->data['Complaint']['sheet_ride_detail_ride_id'])
            ));

        $this->set(compact('complaintCauses','sheetRideDetailRides'));
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
        $this->verifyUserPermission(SectionsEnum::reclamation, $user_id, ActionsEnum::delete, "ComplaintCauses", $id, "ComplaintCause" ,null);
        $this->Complaint->id = $id;
        if (!$this->Complaint->exists()) {
            throw new NotFoundException(__('Invalid complaint'));
        }
        //$this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Complaint->delete()) {

            $this->Flash->success(__('The complaint has been deleted.'));
        } else {

            $this->Flash->error(__('The complaint could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteComplaints() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::reclamation, $user_id, ActionsEnum::delete, "Complaints", $id, "Complaint" ,null);
        $this->Complaint->id = $id;
        //$this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->Complaint->delete()){
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

    public function getComplaintsByCustomer($customerId = null){
        $conditions = '';
        if(isset($customerId) && $customerId!=null ){
            $conditions = " `Complaint`.`customer_id` = ".$customerId;
        }


        $sqlComplaints =" SELECT 
                        `Complaint`.`taken_over_date`, `Complaint`.`type`,`Complaint`.`origin`,
                        `ComplaintCause`.`name`, `SheetRideDetailRides`.`reference`
                                                                   
                                        FROM  `complaints` AS `Complaint` 
                                        left JOIN `sheet_ride_detail_rides` AS `SheetRideDetailRides` ON (`SheetRideDetailRides`.`id` = `Complaint`.`sheet_ride_detail_ride_id`) 
                                        left JOIN `complaint_causes` AS `ComplaintCause` ON (`Complaint`.`complaint_cause_id` = `ComplaintCause`.`id`) 
                                    WHERE ".$conditions."
                                      order by `Customer`.`id` ASC ";

        $conn = ConnectionManager::getDataSource('default');
        $complaints = $conn->fetchAll($sqlComplaints);
        $complaintsArray= array();
        $i=0;
        if(!empty($complaints))
        {
            foreach ($complaints  as $complaint){
                $complaintsArray[$i]['taken_over_date']=$complaint['Complaint']['taken_over_date'];
                switch ($complaint['Complaint']['type']){
                    case 1:
                        $complaintsArray[$i]['type'] = __('Appel');
                        break;
                    case 2:
                        $complaintsArray[$i]['type']= __('Email');
                        break;
                    case 3:
                        $complaintsArray[$i]['type'] =__('Sms');
                        break;
                    case 4:
                        $complaintsArray[$i]['type'] =__('Direct ou oral');
                        break;
                    case 5:
                        $complaintsArray[$i]['type'] =__('Courier');
                        break;
                    case 6:
                        $complaintsArray[$i]['type'] =__('Autres');
                        break;
                }
                switch ($complaint['Complaint']['origin']){
                    case 1:
                        $complaintsArray[$i]['origin'] = __('Interne');
                        break;
                    case 2:
                        $complaintsArray[$i]['origin'] = __('Externe');
                        break;

                }
                $complaintsArray[$i]['complaint_cause']=$complaint['ComplaintCause']['name'];
                $complaintsArray[$i]['SheetRideDetailRides']=$complaint['SheetRideDetailRides']['reference'];
                $i++;
            }
            $complaintsArray = json_encode($complaintsArray);
            $this->response->type('json');
            $this->response->body($complaintsArray);
            return $this->response;
        }
        else {
            echo 0; die();
        }
    }

    public function addComplaintByCustomer(){

    }

    public function viewComplaints($sheetRideDetailRideId = null, $observationId = null) {
        $userId=$this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::reclamation, $userId, ActionsEnum::view, "Complaints", null, "Complaint" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :
                $conditions=array(
                    'OR' => array( 'SheetRideDetailRides.id'=>$sheetRideDetailRideId,
                        'Observation.id' => $observationId)
                   );
                break;
            case 2 :
                $conditions=array( 'OR' => array( 'SheetRideDetailRides.id'=>$sheetRideDetailRideId,
                    'Observation.id' => $observationId),
                    'Complaint.userId '=>$userId);
                break;
            case 3 :
                $conditions=array( 'OR' => array( 'SheetRideDetailRides.id'=>$sheetRideDetailRideId,
                    'Observation.id' => $observationId),
                    'Complaint.userId !='=>$userId);
                break;

            default:
                $conditions=null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Complaint.reference' => 'ASC', 'Complaint.taken_over_date' => 'ASC'),
            'conditions'=>$conditions,
            'recursive'=>-1,
            'fields'=>array(
                'Complaint.reference',
                'Complaint.taken_over_date',
                'SheetRideDetailRides.reference',
                'TransportBillDetailRides.reference',
                'User.first_name',
                'User.last_name',
                'ComplaintCause.name',
                'Complaint.type',
                'Complaint.id',
            ),
            'joins'=>array(
                array(
                    'table' => 'sheet_ride_detail_rides',
                    'type' => 'left',
                    'alias' => 'SheetRideDetailRides',
                    'conditions' => array('SheetRideDetailRides.id = Complaint.sheet_ride_detail_ride_id')
                ),

                array(
                    'table' => 'complaint_causes',
                    'type' => 'left',
                    'alias' => 'ComplaintCause',
                    'conditions' => array('ComplaintCause.id = Complaint.complaint_cause_id')
                ),
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'User',
                    'conditions' => array('User.id = Complaint.user_id')
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
                    'conditions' => array('Observation.transport_bill_detail_ride_id = TransportBillDetailRides.id')
                ),
            ),
            'paramType' => 'querystring'
        );
        //Parametrer la pagination

        $complaints = $this->Paginator->paginate('Complaint');


        $this->set('complaints', $complaints);
        $this->set(compact('limit'));


    }


    public function viewMissionComplaints($sheetRideDetailRideId = null) {
        $userId=$this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::reclamation, $userId, ActionsEnum::view, "Complaints", null, "Complaint" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :
                $conditions=array('SheetRideDetailRides.id'=>$sheetRideDetailRideId);
                break;
            case 2 :
                $conditions=array('SheetRideDetailRides.id'=>$sheetRideDetailRideId,'Complaint.userId '=>$userId);
                break;
            case 3 :
                $conditions=array('SheetRideDetailRides.id'=>$sheetRideDetailRideId,'Complaint.userId !='=>$userId);
                break;

            default:
                $conditions=null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Complaint.reference' => 'ASC', 'Complaint.taken_over_date' => 'ASC'),
            'conditions'=>$conditions,
            'recursive'=>-1,
            'fields'=>array(
                'Complaint.reference',
                'Complaint.taken_over_date',
                'SheetRideDetailRides.reference',
                'User.first_name',
                'User.last_name',
                'ComplaintCause.name',
                'Complaint.type',
                'Complaint.id',
            ),
            'joins'=>array(
                array(
                    'table' => 'sheet_ride_detail_rides',
                    'type' => 'left',
                    'alias' => 'SheetRideDetailRides',
                    'conditions' => array('SheetRideDetailRides.id = Complaint.sheet_ride_detail_ride_id')
                ),

                array(
                    'table' => 'complaint_causes',
                    'type' => 'left',
                    'alias' => 'ComplaintCause',
                    'conditions' => array('ComplaintCause.id = Complaint.complaint_cause_id')
                ),
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'User',
                    'conditions' => array('User.id = Complaint.user_id')
                ),
            ),
            'paramType' => 'querystring'
        );
        //Parametrer la pagination

        $complaints = $this->Paginator->paginate('Complaint');

        $this->set('complaints', $complaints);
        $roleId = $this->Auth->user('role_id');
        $profileId = $this->Auth->user('profile_id');
        $permissionResponse = $this->AccessPermission->getPermissionWithParams(SectionsEnum::reponse_reclamation,
            ActionsEnum::add, $profileId, $roleId);
        $this->set(compact('limit','permissionResponse'));
    }

    public function viewOrderComplaints($observationId = null) {
        $userId=$this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::reclamation, $userId, ActionsEnum::view, "Complaints", null, "Complaint" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :
                $conditions=array('Observation.id'=>$observationId);
                break;
            case 2 :
                $conditions=array('Observation.id'=>$observationId,'Complaint.userId '=>$userId);
                break;
            case 3 :
                $conditions=array('Observation.id'=>$observationId,'Complaint.userId !='=>$userId);
                break;

            default:
                $conditions=null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Complaint.reference' => 'ASC', 'Complaint.taken_over_date' => 'ASC'),
            'conditions'=>$conditions,
            'recursive'=>-1,
            'fields'=>array(
                'Complaint.reference',
                'Complaint.taken_over_date',
                'Observation.id',
                'TransportBillDetailRides.reference',
                'User.first_name',
                'User.last_name',
                'ComplaintCause.name',
                'Complaint.type',
                'Complaint.id',
            ),
            'joins'=>array(
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
                    'conditions' => array('Observation.transport_bill_detail_ride_id = TransportBillDetailRides.id')
                ),

                array(
                    'table' => 'complaint_causes',
                    'type' => 'left',
                    'alias' => 'ComplaintCause',
                    'conditions' => array('ComplaintCause.id = Complaint.complaint_cause_id')
                ),
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'User',
                    'conditions' => array('User.id = Complaint.user_id')
                ),
            ),
            'paramType' => 'querystring'
        );
        //Parametrer la pagination

        $complaints = $this->Paginator->paginate('Complaint');

        $this->set('complaints', $complaints);
        $roleId = $this->Auth->user('role_id');
        $profileId = $this->Auth->user('profile_id');
        $permissionResponse = $this->AccessPermission->getPermissionWithParams(SectionsEnum::reponse_reclamation,
            ActionsEnum::add, $profileId, $roleId);
        $this->set(compact('limit','permissionResponse'));
    }

}
