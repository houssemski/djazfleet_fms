<?php

App::uses('AppModel', 'Model');

/**
 * Nationality Model
 *
 * @property Nationality $Nationality
 */
class Notification extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(


        'section_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'action_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    public $belongsTo = array(


        'TransportBill' => array(
            'className' => 'TransportBill',
            'foreignKey' => 'transport_bill_id'
        ),
        'Bill' => array(
            'className' => 'Bill',
            'foreignKey' => 'bill_id'
        ),
        'Bill' => array(
            'className' => 'Bill',
            'foreignKey' => 'bill_id'
        ),
        'Complaint' => array(
            'className' => 'Complaint',
            'foreignKey' => 'complaint_id'
        ),



    );

    /**
     * @param null $transportBillId
     * @param null $userId
     * @param null $sectionId
     * @param null $actionId
     * @param null $type
     * @throws Exception
     */
    public function addNotification($transportBillId = null,$userId = null, $actionId = null, $sectionId = null, $type=null)
    {


            if($type=='Bill'){
                $data['Notification']['bill_id'] = $transportBillId;
            }elseif($type=='Mission') {
                $data['Notification']['complaint_id'] = $transportBillId;
            }elseif($type=='Observation') {
                $data['Notification']['observation_id'] = $transportBillId;
            }elseif($type=='Event') {
                $data['Notification']['event_id'] = $transportBillId;
            }else {
                $data['Notification']['transport_bill_id'] = $transportBillId;
            }

            $data['Notification']['action_id'] = $actionId;
            $data['Notification']['section_id'] = $sectionId;
            $data['Notification']['user_id'] = $userId;
            $this->create();
            $this->save($data);

    }

    /**
     * @param null $transportBillId
     * @param null $actionId
     * @param null $sectionId
     * @throws Exception
     */

    public function updateNotification(
        $transportBillId = null,
        $actionId = null,
        $sectionId = null
    ) {

            $data['Notification']['transport_bill_id'] = $transportBillId;
            $data['Notification']['action_id'] = $actionId;
            $data['Notification']['section_id'] = $sectionId;
            $conditions = array(
                'Notification.transport_bill_id' => $transportBillId
            );
            $notification = $this->getNotificationByConditions($conditions);
            if (empty($notification)) {
                $this->create();
                $this->save($data);
            } else {
                $this->id = $notification[0]['Notification']['id'];
                $this->save($data);
            }

    }

    public function getNotificationByConditions($conditions = null)
    {
        $notifications = $this->find('all', array(
            'conditions' => $conditions,
            'recursive' => -1,
            'fields' => array('Notification.id', 'TransportBill.id'),
            'joins' => array(

                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('Notification.transport_bill_id = TransportBill.id')
                )
            )

        ));
        return $notifications;
    }

    /**
     * @param $sectionIds
     * @param $supplierId
     * @return mixed
     */
    public function  getNbNotificationsByUser($sectionIds = null, $supplierId= null)
    {


        $query = " SELECT COUNT(*) as nbNotifications FROM notifications as Notification ";
        if(!empty($supplierId)){
            $query .= "  left JOIN transport_bills  AS TransportBill ON (TransportBill.id = Notification.transport_bill_id) 
                      left JOIN bills  AS Bill ON (Bill.id = Notification.bill_id) 
                      WHERE read_notif = 0  && complaint_id IS NULL  && (TransportBill.supplier_id = ". $supplierId . " OR Bill.supplier_id = ".$supplierId." ) ";
        }else {
            $query .= "WHERE read_notif = 0  && complaint_id IS NULL ";
        }

        if (!empty($sectionIds)) {
            $ids ='(';
            $countSections = count($sectionIds);
            $i =1;
            foreach ($sectionIds as $sectionId){
                if($i==$countSections){
                    $ids = $ids.$sectionId;
                }else {
                    $ids = $ids.$sectionId.',';
                }
                $i++;
            }
            $ids = $ids.')';

            $query .= " && Notification.section_id IN " . $ids;
        }

        //var_dump($query); die();
        return $this->query($query);
    }

    /**
     * @param null $sectionIds
     * @param null $supplierId
     * @return array|null
     */
    public function getNotificationsByUser($sectionIds = null, $supplierId=null)
    {
        if(!empty($sectionIds)){
            if(!empty($supplierId)){
                $conditions = array(
                    'Notification.section_id ' => $sectionIds,
                    'Notification.read_notif' => 0,
                    'Notification.complaint_id IS NULL ',
                    'OR' => array(
                        "TransportBill.supplier_id" => $supplierId,
                        "Bill.supplier_id" =>$supplierId
                    )
                );
            }else {
                    $conditions = array(
                        'Notification.section_id ' => $sectionIds,
                        'Notification.read_notif' => 0,
                        'Notification.complaint_id IS NULL ',
                    );
            }

        }else {
            if(!empty($supplierId)){
                $conditions = array(
                    'Notification.read_notif' => 0,
                    'Notification.complaint_id IS NULL ',
                    'OR' => array(
                        "TransportBill.supplier_id" => $supplierId,
                        "Bill.supplier_id" =>$supplierId
                    )
                );
            }else {
                $conditions = array(
                    'Notification.read_notif' => 0,
                    'Notification.complaint_id IS NULL ',
                );
            }

        }
        $notifications = $this->find('all', array(
            'conditions' => $conditions,
            'recursive' => -1,
            'order'=>array('Notification.id DESC'),
            'fields' => array(
                'Notification.id',
                'TransportBill.id',
                'TransportBill.reference',
                'TransportBill.type',
                'Bill.id',
                'Bill.reference',
                'Bill.type',
                'Notification.action_id',
                'Notification.section_id',
                'Section.name',
                'Supplier.name',
                'Car.immatr_def',
                'Carmodel.name',
                'EventType.name',
                'Parc.name',
                'Event.id',
                'Event.date',
            ),
            'joins' => array(
                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('Notification.transport_bill_id = TransportBill.id')
                ),
                array(
                    'table' => 'bills',
                    'type' => 'left',
                    'alias' => 'Bill',
                    'conditions' => array('Notification.bill_id = Bill.id')
                ),
                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Event',
                    'conditions' => array('Event.id = Notification.event_id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Car.id = Event.car_id')
                ),
                array(
                    'table' => 'parcs',
                    'type' => 'left',
                    'alias' => 'Parc',
                    'conditions' => array('Parc.id = Car.parc_id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'event_event_types',
                    'type' => 'left',
                    'alias' => 'EventEventType',
                    'conditions' => array('EventEventType.event_id = Event.id')
                ),
                array(
                    'table' => 'event_types',
                    'type' => 'left',
                    'alias' => 'EventType',
                    'conditions' => array('EventEventType.event_type_id = EventType.id')
                ),



                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('TransportBill.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'sections',
                    'type' => 'left',
                    'alias' => 'Section',
                    'conditions' => array('Notification.section_id = Section.id')
                ),


            )
        ));
        return $notifications;
    }    /**
     * @param $sectionId
     * @param $supplierId
     * @return mixed
     */

    public function  getNbComplaintNotificationsByUser($sectionId = 162, $supplierId=null)
    {
        $query = " SELECT COUNT(*) as nbNotifications FROM notifications  ";

        if(!empty($supplierId)){
            $query .= "     left JOIN complaints  AS Complaint ON (Complaint.id = Notification.complaint_id
                        left JOIN sheet_ride_detail_rides  AS SheetRideDetailRides ON (Complaint.sheet_ride_detail_ride_id = SheetRideDetailRides.id) 
                      left JOIN bills  AS Bill ON (Bill.id = Notification.bill_id) 
                      left JOIN observations  AS Observation ON (ComplaintObservation.observation_id = Observation.id) 
                      left JOIN complaints  AS ComplaintObservation ON (ComplaintObservation.id = Notification.complaint_id) 
                      left JOIN transport_bill_detail_rides  AS TransportBillDetailRides ON (Observation.transport_bill_detail_ride_id = TransportBillDetailRides.id) 
                      left JOIN transport_bills  AS TransportBill ON (TransportBill.id = TransportBillDetailRides.transport_bill_id) 
                        
                      WHERE read_notif = 0 && complaint_id IS NOT NULL  && (SheetRideDetailRides.supplier_id = ". $supplierId . " OR TransportBill.supplier_id = ".$supplierId." ) ";
        }else {
            $query .= "WHERE read_notif = 0 && complaint_id IS NOT NULL ";
        }


            $query .= " && notifications.section_id IN " . $sectionId;

        return $this->query($query);
    }

    /**
     * @param  $sectionId
     * @param  $supplierId
     * @return array|null
     */
    public function getComplaintNotificationsByUser($sectionId = 162, $supplierId=null)
    {
            if(!empty($supplierId)){
                $conditions = array(
                    'Notification.section_id  ' => $sectionId,
                    'Notification.read_notif' => 0,
                    'Notification.complaint_id is not null',
                    'OR' => array(
                        "TransportBill.supplier_id " => $supplierId,
                        "SheetRideDetailRides.supplier_id " =>$supplierId
                    )
                );
            } else {
                $conditions = array(
                    'Notification.section_id  ' => $sectionId,
                    'Notification.read_notif' => 0,
                    'Notification.complaint_id is not null'
                );
            }

        $notifications = $this->find('all', array(
            'conditions' => $conditions,
            'recursive' => -1,
            'fields' => array(
                'Notification.id',
                'Notification.action_id',
                'Section.name',
                'Complaint.id',
                'Complaint.reference',
                'SheetRideDetailRides.reference',
                'TransportBillDetailRides.reference',
                'SheetRideDetailRides.id'
            ),
            'joins' => array(

                array(
                    'table' => 'complaints',
                    'type' => 'left',
                    'alias' => 'Complaint',
                    'conditions' => array('Complaint.id = Notification.complaint_id')
                ),
                array(
                    'table' => 'sheet_ride_detail_rides',
                    'type' => 'left',
                    'alias' => 'SheetRideDetailRides',
                    'conditions' => array('Complaint.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
                ),
                array(
                    'table' => 'complaints',
                    'type' => 'left',
                    'alias' => 'ComplaintObservation',
                    'conditions' => array('ComplaintObservation.id = Notification.complaint_id')
                ),
                array(
                    'table' => 'observations',
                    'type' => 'left',
                    'alias' => 'Observation',
                    'conditions' => array('ComplaintObservation.observation_id = Observation.id')
                ),
                array(
                    'table' => 'transport_bill_detail_rides',
                    'type' => 'left',
                    'alias' => 'TransportBillDetailRides',
                    'conditions' => array('Observation.transport_bill_detail_ride_id = TransportBillDetailRides.id')
                ),
                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('TransportBill.id = TransportBillDetailRides.transport_bill_id')
                ),
                array(
                    'table' => 'sections',
                    'type' => 'left',
                    'alias' => 'Section',
                    'conditions' => array('Notification.section_id = Section.id')
                ),
            )
        ));
        return $notifications;
    }

    /** mettre a jour le statut notification si notification vu
     * @param null $conditions
     */
    public function UpdateStatusNotifications($conditions = null)
    {

        $notifications = $this->getNotificationByConditions($conditions);
        foreach ($notifications as $notification) {
            $this->id = $notification['Notification']['id'];
            $this->saveField('read_notif', 1);
        }
    }

    /** voir si lutilisateur à entrer dans index
     * @param $type
     * @param $sectionIds
     */
    public function updateInterIndexNotifications($type = null, $sectionIds = null)
    {
       if(!empty($sectionIds)){
           $conditions = array('TransportBill.type' => $type, 'Notification.section_id ' => $sectionIds, 'Notification.read_notif'=>0 , 'Notification.enter_index'=>0 );

       }else {
           $conditions = array('TransportBill.type' => $type, 'Notification.read_notif'=>0 , 'Notification.enter_index'=>0 );

       }
         $notifications = $this->getNotificationByConditions($conditions);

        foreach ($notifications as $notification) {
            $this->id = $notification['Notification']['id'];
            $this->saveField('enter_index', 1);
        }
    }
}
