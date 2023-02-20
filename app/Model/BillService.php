<?php

App::uses('AppModel', 'Model');

/**
 * BillService Model
 *
 */
class BillService extends AppModel
{
    /**
     * Use table
     *
     * @var mixed False or table name
     */

    public $validate = array(
        'service_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),
        ),
        'bill_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),
        ),
    );

    public $belongsTo = array(
        'Service' => array(
            'className' => 'Service',
            'foreignKey' => 'service_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Bill' => array(
            'className' => 'Bill',
            'foreignKey' => 'bill_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * @param null $serviceId
     * @param null $billId
     * @return bool
     * @throws Exception
     */
    public function addBillService($serviceId = null, $billId = null)
    {
        $save = false;
        $this->create();
        $data['BillService']['bill_id'] = $billId;
        $data['BillService']['service_id'] = $serviceId;

        if($this->save($data)){
            $save = true;
        }
        return $save;
    }

    /**
     * @param null $billService
     * @param null $billId
     * @throws Exception
     */
    public function updateBillService($billService = null, $billId = null)
    {
        $data = array();
        $data['BillService']['id'] = $billService['id'];
        $data['BillService']['bill_id'] = $billId;
        $data['BillService']['service_id'] = $billService['service_id'];
        $this->save($data);
    }

    public function getBillServicesByBillId($billId)
    {
        $billServices = $this->find(
            'all',
            array(
                'order'=>array('BillService.service_id ASC'),
                'conditions' => array('BillService.bill_id' => $billId),
                'fields' => array(
                    'BillService.service_id',
                    'Service.name',
                ),
                'recursive' => -1,
                'joins' => array(
                    array(
                        'table' => 'services',
                        'type' => 'left',
                        'alias' => 'Service',
                        'conditions' => array('BillService.service_id = Service.id')
                    )
                ),

            )
        );
        return $billServices;
    }


    function deleteBillServices( $billId = null){

        $this->deleteAll(array('BillService.bill_id' => $billId), false);


    }



}