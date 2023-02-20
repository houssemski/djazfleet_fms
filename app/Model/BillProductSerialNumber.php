<?php
App::uses('AppModel', 'Model');

class BillProductSerialNumber extends AppModel
{


    /**
     * @param string|null $typeSelect
     *
     * @return array
     */
    public function getBillProductSerialNumbers($typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        $billProductSerialNumbers = $this->find($typeSelect,
            array(
                'order'=>array('code' => 'ASC', 'name' => 'ASC')

        ));

        return $billProductSerialNumbers;
    }

    public function saveBillProductSerialNumber($billProductSerialNumber)
    {
        $newBillProductSerialNumberEntity = $this->create();
        $newBillProductSerialNumberEntity['BillProductSerialNumber']['id'] = $billProductSerialNumber->id;
        $newBillProductSerialNumberEntity['BillProductSerialNumber']['serial_number_id'] = $billProductSerialNumber->serial_number_id;
        $newBillProductSerialNumberEntity['BillProductSerialNumber']['bill_product_id'] =  $billProductSerialNumber->document_product_id;
        $this->save($newBillProductSerialNumberEntity);
    }

    /**
     * @param null $serialNumberIds
     * @param null $billProductId
     */

    public function addBillProductSerialNumbers($serialNumberIds = null, $billProductId = null)
    {
        foreach ($serialNumberIds as $serialNumberId) {
            $newBillProductSerialNumberEntity = $this->create();
            $newBillProductSerialNumberEntity['BillProductSerialNumber']['serial_number_id'] =  $serialNumberId;
            $newBillProductSerialNumberEntity['BillProductSerialNumber']['bill_product_id'] =  $billProductId;
            $this->save($newBillProductSerialNumberEntity);
        }
    }

    /**
     * @param null $serialNumberIds
     * @param null $billProductId
     */

    public function editBillProductSerialNumbers($serialNumberIds = null, $billProductId = null)
    {
        foreach ($serialNumberIds as $serialNumberId) {
            $billProductSerialNumber = $this->find('first',array(
                'recursive'=>-1,
                'conditions'=>array(
                    'BillProductSerialNumber.bill_product_id' => $billProductId,
                    'BillProductSerialNumber.serial_number_id' => $serialNumberId,
                )
                )
                );
            if (empty($billProductSerialNumber)) {
                $newBillProductSerialNumberEntity = $this->create();
                $newBillProductSerialNumberEntity['BillProductSerialNumber']['serial_number_id'] = $serialNumberId;
                $newBillProductSerialNumberEntity['BillProductSerialNumber']['bill_product_id']= $billProductId;
                $this->save($newBillProductSerialNumberEntity);
            }
        }
    }

    /**
     * @param null $serialNumberIds
     * @param null $billProductId
     */
    public function deleteBillProductSerialNumbers($serialNumberIds = null, $billProductId = null)
    {
        $this->deleteAll(array('serial_number_id IN' => $serialNumberIds, 'bill_product_id' => $billProductId));
    }

    /**
     * @param null $billProductId
     */
    public function getSerialNumbersByBillProductId($billProductId = null)
    {
        $serialNumbers = $this->find('all', array(
            'fields'=>array(
                'SerialNumber.id', 'SerialNumber.serial_number',
                'SerialNumber.label',
                'SerialNumber.expiration_date',
                'SerialNumber.is_used'
            ),
            'joins'=>array(
                array(
                    'table' => 'serial_numbers',
                    'alias' => 'SerialNumber',
                    'type' => 'LEFT',
                    'conditions' => 'BillProductSerialNumber.serial_number_id = SerialNumber.id',
                )
            ),
            'conditions'=>array('BillProductSerialNumber.bill_product_id' => $billProductId)

        ));

        return $serialNumbers;
    }

    public function getBillProductSerialNumbersByBillProductId($billProductId = null)
    {
        $serialNumbers = $this->find('all',array(
            'conditions'=>array('BillProductSerialNumber.bill_product_id' => $billProductId)

        ));
        return $serialNumbers;
    }
}
