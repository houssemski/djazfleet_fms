<?php
App::uses('AppModel', 'Model');

/**
 * Mark Model
 *
 * @property Observation $Observation
 */
class Observation extends AppModel
{
    /**
     * Validation rules
     *
     * @var array
     */

    public $displayField = 'customer_observation';
    public $validate = array(

        'transport_bill_detail_ride_id' => array(
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


    public $belongsTo = array(


        'TransportBillDetailRides' => array(
            'className' => 'TransportBillDetailRides',
            'foreignKey' => 'transport_bill_detail_ride_id'
        ),


    );

    /**
     * @param null $transportBillDetailRideId
     * @param null $nbTrucks
     * @param null $customerObservation
     * @throws Exception
     */
    public function addObservations($transportBillDetailRideId = null, $nbTrucks = null, $customerObservation = null)
    {
      //  var_dump($nbTrucks); die();
        $data['Observation']['transport_bill_detail_ride_id'] = $transportBillDetailRideId;
        if (!empty($customerObservation)) {
            $data['Observation']['customer_observation'] = $customerObservation;
        }
        for ($i = 1; $i <= $nbTrucks; $i++) {
            $this->create();
            $this->save($data);
        }
    }

    public function getObservationsByTransportBillDetailRideId($transportBillDetailRideId = null, $typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = 'all';
        }

        $observations = $this->find($typeSelect, array(
            'conditions' => array('Observation.transport_bill_detail_ride_id' => $transportBillDetailRideId),
            'fields' => array('Observation.id', 'Observation.customer_observation')));
        return $observations;
    }

    public function getObservationsByConditions($conditions = null, $typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = 'all';
        }
        if ($typeSelect == 'list') {
            $fields = array('Observation.id', 'Observation.customer_observation');
        } else {
            $fields = array('Observation.id',
                            'Observation.customer_observation',
                            'Observation.cancel_cause_id',
                            'CancelCause.name',
                            'TransportBillDetailRides.id',
                            'TransportBillDetailRides.reference',
                            'TransportBillDetailRides.type_ride',
                            'TransportBillDetailRides.departure_destination_id',
                            'TransportBillDetailRides.arrival_destination_id',
                            'TransportBillDetailRides.car_type_id',
                            'TransportBillDetailRides.status_id',
                            'CarType.name',
                            'Type.name',
                            'Type.id',
                            'DepartureDestination.name',
                            'Departure.id',
                            'Departure.name',
                            'ArrivalDestination.name',
                            'Arrival.id',
                            'Arrival.name',
                            'SupplierFinal.name',
                            'COUNT(Complaint.id) AS complaint_count_order',
                                );
        }
        $observations = $this->find($typeSelect, array(
            'conditions' => $conditions,
            'recursive' => -1,
            'fields'=>$fields,
            'group'=>'Observation.id',
            'joins' => array(
                array(
                    'table' => 'transport_bill_detail_rides',
                    'type' => 'left',
                    'alias' => 'TransportBillDetailRides',
                    'conditions' => array('TransportBillDetailRides.id = Observation.transport_bill_detail_ride_id')
                ),
                array(
                    'table' => 'cancel_causes',
                    'type' => 'left',
                    'alias' => 'CancelCause',
                    'conditions' => array('CancelCause.id = Observation.cancel_cause_id')
                ),
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('TransportBillDetailRides.detail_ride_id = DetailRide.id')
                ),

                array(
                    'table' => 'rides',
                    'type' => 'left',
                    'alias' => 'Ride',
                    'conditions' => array('DetailRide.ride_id = Ride.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('DetailRide.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'DepartureDestination',
                    'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'ArrivalDestination',
                    'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Departure',
                    'conditions' => array('Departure.id = TransportBillDetailRides.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Arrival',
                    'conditions' => array('Arrival.id = TransportBillDetailRides.arrival_destination_id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'Type',
                    'conditions' => array('TransportBillDetailRides.car_type_id = Type.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'SupplierFinal',
                    'conditions' => array('TransportBillDetailRides.supplier_final_id = SupplierFinal.id')
                ),
                array(
                    'table' => 'complaints',
                    'type' => 'left',
                    'alias' => 'Complaint',
                    'conditions' => array('Observation.id = Complaint.observation_id')
                )  ,
            )
        ));
        return $observations;
    }


    // Function for encryption
    function encrypt($data)
    {
        return base64_encode(base64_encode(base64_encode(strrev($data))));
    }

// Function for decryption
    function decrypt($data)
    {
        return strrev(base64_decode(base64_decode(base64_decode($data))));
    }

    public function updateNbComplaints($observationId = null, $nbComplaints = null)
    {

        $this->id = $observationId;
        $this->saveField('nb_complaints', $nbComplaints);
    }


}