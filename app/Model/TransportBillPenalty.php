<?php

App::uses('AppModel', 'Model');

/**
 * CustomerCategory Model
 *
 * @property Customer $Customer
 */
class TransportBillPenalty extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'penalty_value';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(

        'transport_bill_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'penalty_value' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'penalty_amount' => array(
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
        'TransportBill' => array(
            'className' => 'TransportBill',
            'foreignKey' => 'transport_bill_id'
        ),
    );

    function addPenalties($transportBillId = null,$penalties= null){
        foreach ($penalties as $penalty){
            $data = array();
            $data['TransportBillPenalty']['transport_bill_id'] = $transportBillId;
            $data['TransportBillPenalty']['penalty_value'] = $penalty['penalty_value'];
            $data['TransportBillPenalty']['penalty_amount'] = $penalty['penalty_amount'];
            $this->create();
            $this->save($data);
        }

    }
    function addPenalty($transportBillId = null,$penalty= null){

            $data = array();
            $data['TransportBillPenalty']['transport_bill_id'] = $transportBillId;
            $data['TransportBillPenalty']['penalty_value'] = $penalty['penalty_value'];
            $data['TransportBillPenalty']['penalty_amount'] = $penalty['penalty_amount'];
            $this->create();
            $this->save($data);
    }
    function updatePenalty($transportBillId = null,$penalty= null){

            $data = array();
            $data['TransportBillPenalty']['transport_bill_id'] = $transportBillId;
            $data['TransportBillPenalty']['id'] = $penalty['id'];
            $data['TransportBillPenalty']['penalty_value'] = $penalty['penalty_value'];
            $data['TransportBillPenalty']['penalty_amount'] = $penalty['penalty_amount'];
            $this->save($data);
    }
    function getPenaltiesByTransportBillId($transportBillId=null){
        $penalties= $this->find('all',array(
            'conditions'=>array('TransportBillPenalty.transport_bill_id'=>$transportBillId),
            'recursive'=>-1));
        return $penalties;
    }

    function deletePenalties($deletedIds=null){
        foreach ($deletedIds as $deletedId){
            $this->id = $deletedId;
            $this->delete();
        }
    }
    function deletePenaltiesByTransportBillId($transportBillId=null){
        $this->deleteAll(array('TransportBillPenalty.transport_bill_id' => $transportBillId),
            false);
    }



}
