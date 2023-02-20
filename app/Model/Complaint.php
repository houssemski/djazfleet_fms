<?php

App::uses('AppModel', 'Model');

/**
 * Complaint Model
 *
 * @property Complaint $Complaint
 */
class Complaint extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'reference';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'reference' => array(
            'unique' => array(
                'rule' => 'isUnique',
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),



        'sheet_ride_detail_ride_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

        'complaint_cause_id' => array(
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

    /**
     * hasMany associations
     *
     * @var array
     */


    public $belongsTo = array(
        'SheetRideDetailRides' => array(
            'className' => 'SheetRideDetailRides',
            'foreignKey' => 'sheet_ride_detail_ride_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ComplaintCause' => array(
            'className' => 'ComplaintCause',
            'foreignKey' => 'complaint_cause_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Observation' => array(
            'className' => 'Observation',
            'foreignKey' => 'observation_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'modified_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

    );

    /**
     * Get complaint
     *
     * @param string $typeSelect
     * @param string $conditions
     *
     * @return array $cancelCauses
     */
    public function getComplaintCauses($typeSelect = null, $conditions = null) {
        if(empty($typeSelect)){
            $typeSelect = 'list';
        }

        $complaintCauses = $this->find(
            $typeSelect,
            array(
                'order' => array('ComplaintCause.code ASC, ComplaintCause.name ASC'),
                'conditions'=>$conditions,
                'recursive' => -1
            )
        );
        return $complaintCauses;
    }

    public function getCountComplaintOrders($transportBillId = null,$sheetRideId=null){
        if(!empty($transportBillId)){
            $complaintObservations = $this->find('all', array(
                'recursive' => -1, // should be used with joins
                'conditions' => array('TransportBillDetailRides.Transport_bill_id' => $transportBillId),
                'fields' => array(
                    'COUNT(Complaint.id) AS complaint_count_order',
                ),
                'group'=>'TransportBillDetailRides.id',
                'joins' => array(
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
                    )  ,
                )
            ));
        }else {
            $complaintObservations = $this->find('all', array(
                'recursive' => -1, // should be used with joins
                'conditions' => array('SheetRideDetailRides.sheet_ride_id' => $sheetRideId),
                'fields' => array(
                    'COUNT(Complaint.id) AS complaint_count_order',
                ),
                'group'=>'SheetRideDetailRides.id',
                'joins' => array(
                    array(
                        'table' => 'observations',
                        'type' => 'left',
                        'alias' => 'Observation',
                        'conditions' => array('Observation.id = Complaint.observation_id')
                    ),
                    array(
                        'table' => 'sheet_ride_detail_rides',
                        'type' => 'left',
                        'alias' => 'SheetRideDetailRides',
                        'conditions' => array('SheetRideDetailRides.observation_id = Observation.id')
                    )  ,
                )
            ));
        }

        if(!empty($complaintObservations)){
            $countComplaintObservations = $complaintObservations[0][0]['complaint_count_order'];
        }else {
            $countComplaintObservations =0;
        }
        return $countComplaintObservations;
    }

    public function getCountComplaintMissions($transportBillId = null,$sheetRideId=null){
        if(!empty($transportBillId)){
            $complaintMissions = $this->find('all', array(
                'recursive' => -1, // should be used with joins
                'conditions' => array('TransportBillDetailRides.Transport_bill_id' => $transportBillId),
                'fields' => array(
                    'COUNT(Complaint.id) AS complaint_count_mission',
                ),
                'group'=>'TransportBillDetailRides.id',
                'joins' => array(
                    array(
                        'table' => 'sheet_ride_detail_rides',
                        'type' => 'left',
                        'alias' => 'SheetRideDetailRides',
                        'conditions' => array('SheetRideDetailRides.id = Complaint.sheet_ride_detail_ride_id')
                    ),
                    array(
                        'table' => 'transport_bill_detail_rides',
                        'type' => 'left',
                        'alias' => 'TransportBillDetailRides',
                        'conditions' => array('TransportBillDetailRides.id = SheetRideDetailRides.transport_bill_detail_ride_id')
                    )  ,

                )
            ));
        }else {
            $complaintMissions = $this->find('all', array(
                'recursive' => -1, // should be used with joins
                'conditions' => array('SheetRideDetailRides.sheet_ride_id' => $sheetRideId),
                'fields' => array(
                    'COUNT(Complaint.id) AS complaint_count_mission',
                ),
                'group'=>'SheetRideDetailRides.id',
                'joins' => array(
                    array(
                        'table' => 'sheet_ride_detail_rides',
                        'type' => 'left',
                        'alias' => 'SheetRideDetailRides',
                        'conditions' => array('SheetRideDetailRides.id = Complaint.sheet_ride_detail_ride_id')
                    )
                )
            ));
        }


        if(!empty($complaintMissions)){
            $countComplaintMissions = $complaintMissions[0][0]['complaint_count_mission'];
        }else {
            $countComplaintMissions =0;
        }

        return $countComplaintMissions;
    }

    public function getNbComplaintsByMission($sheetRideDetailRideId){
        $complaintMissions = $this->find('all', array(
            'recursive' => -1, // should be used with joins
            'conditions' => array('SheetRideDetailRides.id' => $sheetRideDetailRideId),
            'fields' => array(
                'COUNT(Complaint.id) AS complaint_count_mission',
            ),
            'joins' => array(
                array(
                    'table' => 'sheet_ride_detail_rides',
                    'type' => 'left',
                    'alias' => 'SheetRideDetailRides',
                    'conditions' => array('SheetRideDetailRides.id = Complaint.sheet_ride_detail_ride_id')
                )
            )
        ));
        if(!empty($complaintMissions)){
            $countComplaintMissions = $complaintMissions[0][0]['complaint_count_mission'];
        }else {
            $countComplaintMissions =0;
        }
        return $countComplaintMissions;
    }


    public function getNbComplaintsBySheetRide($sheetRideId){
        $complaintMissions = $this->find('all', array(
            'recursive' => -1, // should be used with joins
            'conditions' => array('SheetRideDetailRides.sheet_ride_id' => $sheetRideId),
            'fields' => array(
                'COUNT(Complaint.id) AS complaint_count_mission',
            ),
            'joins' => array(
                array(
                    'table' => 'sheet_ride_detail_rides',
                    'type' => 'left',
                    'alias' => 'SheetRideDetailRides',
                    'conditions' => array('SheetRideDetailRides.id = Complaint.sheet_ride_detail_ride_id')
                )
            )
        ));
        if(!empty($complaintMissions)){
            $countComplaintMissions = $complaintMissions[0][0]['complaint_count_mission'];
        }else {
            $countComplaintMissions =0;
        }
        return $countComplaintMissions;
    }

    public function getNbComplaintsByObservation($observationId){
        $complaintObservations = $this->find('all', array(
            'recursive' => -1, // should be used with joins
            'conditions' => array('Observation.id' => $observationId),
            'fields' => array(
                'COUNT(Complaint.id) AS complaint_count_order',
            ),
            'joins' => array(
                array(
                    'table' => 'observations',
                    'type' => 'left',
                    'alias' => 'Observation',
                    'conditions' => array('Observation.id = Complaint.observation_id')
                ),
            )
        ));
        if(!empty($complaintObservations)){
            $countComplaintObservations = $complaintObservations[0][0]['complaint_count_order'];
        }else {
            $countComplaintObservations =0;
        }
        return $countComplaintObservations;
    }

    public function getNbComplaintsByOrder($transportBillId){
        $complaintObservations = $this->find('all', array(
            'recursive' => -1, // should be used with joins
            'conditions' => array('TransportBillDetailRides.Transport_bill_id' => $transportBillId),
            'fields' => array(
                'COUNT(Complaint.id) AS complaint_count_order',
            ),
            'joins' => array(
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
                )  ,
            )
        ));
        if(!empty($complaintObservations)){
            $countComplaintOrders = $complaintObservations[0][0]['complaint_count_order'];
        }else {
            $countComplaintOrders =0;
        }
        return $countComplaintOrders;
    }

}
