<?php
App::uses('AppModel', 'Model');

/**
 * Mark Model
 *
 * @property Observation $Observation
 */
class Deadline extends AppModel
{
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
    );


    public $belongsTo = array(


        'TransportBill' => array(
            'className' => 'TransportBill',
            'foreignKey' => 'transport_bill_id'
        ),


    );

    /**
     * @param null $deadline
     * @param null $transportBillId
     * @throws Exception
     */
    public function addDeadline($deadline = null, $transportBillId = null)
    {
        if (!empty($deadline['deadline_date']) && ($transportBillId)) {
            $data['Deadline']['transport_bill_id'] = $transportBillId;
            $data['Deadline']['deadline_date'] = $deadline['deadline_date'];
            $data['Deadline']['percentage'] = $deadline['percentage'];
            $data['Deadline']['value'] = $deadline['value'];
            $this->create();
            $this->save($data);
        }

    }

    /**
     * @param null $deadline
     * @param null $transportBillId
     * @throws Exception
     */
    public function updateDeadline($deadline = null, $transportBillId = null)
    {
        if (!empty($deadline['deadline_date']) && ($transportBillId)) {
            $data['Deadline']['id'] = $deadline['id'];
            $data['Deadline']['transport_bill_id'] = $transportBillId;
            $data['Deadline']['deadline_date'] = $deadline['deadline_date'];
            $data['Deadline']['percentage'] = $deadline['percentage'];
            $data['Deadline']['value'] = $deadline['value'];
            $this->save($data);
        }
    }

    /**
     * @param null $deadlineIds
     */
    public function deleteDeadlines($deadlineIds= null){
       foreach ($deadlineIds as $deadlineId) {
           $this->id = $deadlineId;
           $this->delete();
       }
    }
    /**
     * @param null $transportBillId
     * @param null $typeSelect
     * @return array|null
     */
    public function getDeadlinesByTransportBillId($transportBillId = null, $typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = 'all';
        }

        $deadlines = $this->find($typeSelect, array(
            'conditions' => array('Deadline.transport_bill_id' => $transportBillId),
            'fields' => array('Deadline.id', 'Deadline.deadline_date', 'Deadline.percentage', 'Deadline.value')));
        return $deadlines;
    }


    public function getDeadlineAlerts($limitedDate=null, $transportBillId = null){

        $conditions = array();
        if (!empty($transportBillId)) {
            $conditions["Deadline.transport_bill_id"] = $transportBillId;
        }
        $conditions['Deadline.deadline_date <= '] = $limitedDate;

        $deadlineAlerts = $this->find('all', array(
                'conditions' => $conditions,
                'recursive' => -1,
                'fields' => array(
                    'Deadline.id',
                    'Deadline.deadline_date',
                    'TransportBill.id',
                    'TransportBill.reference',

                ),
                'joins' => array(

                    array(
                        'table' => 'transport_bills',
                        'type' => 'left',
                        'alias' => 'TransportBill',
                        'conditions' => array('Deadline.transport_bill_id = TransportBill.id')
                    )

                )
            )

        );



        return $deadlineAlerts;

    }




}