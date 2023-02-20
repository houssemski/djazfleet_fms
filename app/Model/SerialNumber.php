<?php

App::uses('AppModel', 'Model');

/**
 * SerialNumber Model
**/
class SerialNumber extends AppModel
{
    public $validate = array(

        'serial_number' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            ),
        ),
    );

    public $belongsTo = array(
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'product_id'
        )
    );


    /**
     * @param string|null $typeSelect
     *
     * @return array
     */
    public function getSerialNumbers($typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        $serialNumbers = $this->find($typeSelect,
            array(
                'recursive'=>-1,
                'order'=>array('code' => 'ASC', 'name' => 'ASC')));
        return $serialNumbers;
    }

    /**
     * @param $serialNumbers
     * @param $productId
     * @param int $isUsed
     * @param null $userId
     */
    public function saveSerialNumbers($serialNumbers, $productId, $isUsed, $userId = null)
    {
        $serialNumberIds = array();
        foreach ($serialNumbers as $serialNumber) {

            // empty : edit document serial number case
            if (
                isset($serialNumber['id']) &&
                !empty($serialNumber['id']) &&
                $this->exists(array('id' => $serialNumber['id']))
            ) {
                $serialNumberEntityToBeSaved['SerialNumber']['id'] = $serialNumber['id'];
            } else {
                $serialNumberEntityToBeSaved = $this->create();
            }
                $serialNumberEntityToBeSaved['SerialNumber']['serial_number']= $serialNumber['serial_number'];
                if (isset($serialNumber['label'])) {
                    $serialNumberEntityToBeSaved['SerialNumber']['label'] = $serialNumber['label'];
                }
                if (isset($serialNumber['expiration_date'])) {
                    $serialNumber['expiration_date'] = $this->createDateFromDate($serialNumber['expiration_date']);
                    $serialNumberEntityToBeSaved['SerialNumber']['expiration_date'] =  $serialNumber['expiration_date'] ;
                }
                $serialNumberEntityToBeSaved['SerialNumber']['product_id']=  $productId;
                $serialNumberEntityToBeSaved['SerialNumber']['is_used']= $isUsed;
                if (!empty($userId)) {
                    $serialNumberEntityToBeSaved['SerialNumber']['user_id']= $userId;
                }
                $this->save($serialNumberEntityToBeSaved);
                if( isset($serialNumber['id']) &&
                    !empty($serialNumber['id']) ){
                    $serialNumberIds[] = $serialNumber['id'];
                }else {
                    $serialNumberIds[] = $this->getInsertID();
                }


        }
        return $serialNumberIds;
    }

    /**
     * @param null $serialNumber
     * @param null $productId
     * @return array|\Cake\Datasource\EntityInterface|null
     */
    public function getSerialNumberBySerialNumber($serialNumber = null, $productId = null)
    {

            $serialNumber = $this->find('first', array(
                'recursive'=>-1,
                'conditions'=>array('SerialNumber.serial_number' => $serialNumber,
                    'SerialNumber.product_id' => $productId)));

        return $serialNumber;
    }

    public function getSerialNumberByLabel($label = null, $productId = null)
    {
        $serialNumber = $this->find('first',
            array('conditions'=>array('SerialNumber.label' => $label,
                'SerialNumber.product_id' => $productId)));
        return $serialNumber;
    }

    /**
     * @param string $serialNumber
     * @param int $productId
     * @param string $label
     * @return int|null
     */
    public function addSerialNumber($serialNumber, $productId, $label)
    {

        $serialNumberEntityToBeSaved = $this->create();
        $serialNumberEntityToBeSaved['SerialNumber']['serial_number'] = $serialNumber;
        $serialNumberEntityToBeSaved['SerialNumber']['label'] = $label;

            $serialNumber['expiration_date'] = $this->createDateFromDate($serialNumber['expiration_date']);
            $serialNumberEntityToBeSaved['SerialNumber']['expiration_date'] =  $serialNumber['expiration_date'] ;

        $serialNumberEntityToBeSaved['SerialNumber']['product_id']= $productId;
        $result = $this->save($serialNumberEntityToBeSaved);

        if ($result) {
            $serialNumberId = $this->getInsertID();
            return $serialNumberId;
        } else {
            return null;
        }
    }

    /**
     * @param $serialNumber
     * @param $productId
     * @param $serialNumberId
     * @param $label
     * @return int
     */
    public function updateSerialNumber($serialNumber, $productId, $serialNumberId, $label)
    {

        $serialNumberEntityToBeSaved = $this->getSerialNumberBySerialNumberId($serialNumberId);
        $serialNumberEntityToBeSaved['SerialNumber']['serial_number']= $serialNumber;
        $serialNumberEntityToBeSaved['SerialNumber']['product_id']= $productId;
        if (isset($label) && !empty($label)) {
            $serialNumberEntityToBeSaved['SerialNumber']['label'] = $label;
        }
        $result = $this->save($serialNumberEntityToBeSaved);
        if ($result) {
            $serialNumberId = $serialNumberId;
        }
        return $serialNumberId;
    }

    public function deleteSerialNumber($serialNumberId){
        $this->id = $serialNumberId ;
        $this->delete() ;
    }

    /**
     * @param $serialNumberIds
     * @param $isUsed
     * @throws Exception
     */
    public function updateIsUsedValue($serialNumberIds, $isUsed)
    {
        foreach ($serialNumberIds as $serialNumberId) {
            $serialNumberEntityToBeSaved = $this->get($serialNumberId);
            $serialNumberEntityToBeSaved['SerialNumber']['is_used'] =  $isUsed;
            $this->save($serialNumberEntityToBeSaved);
        }
    }

    public function getSerialNumbersByProduct($productId)
    {
        $serialNumbers = $this->find('all',array('conditions'=>array('product_id' => $productId)));

        return $serialNumbers;
    }

    /**
     * @param null $billProductId
     * @return array|null
     */
    public function getSerialNumbersByBillProductId($billProductId = null)
    {
        $serialNumbers = $this->find('all',array(
            'fields'=>array('SerialNumber.id', 'SerialNumber.serial_number', 'SerialNumber.label', 'SerialNumber.is_used'),
            'order'=>array('SerialNumber.id' => 'ASC', 'SerialNumber.serial_number' => 'ASC'),
             'conditions'=>array('BillProductSerialNumber.bill_product_id' => $billProductId),
             'joins' => array(
                 array(
                     'table' => 'bill_product_serial_numbers',
                     'alias' => 'BillProductSerialNumber',
                     'type' => 'LEFT',
                     'conditions' => 'BillProductSerialNumber.serial_number_id = SerialNumber.id'
                 )
            )
        ));
        return $serialNumbers;
    }

    public function getSerialNumber($serialNumber = null)
    {
        $serialNumber = $this->find('first',array(
            'conditions'=>array(
                'SerialNumber.serial_number' => $serialNumber
        )));
        return $serialNumber;
    }
    public function getSerialNumberBySerialNumberId($serialNumberId = null)
    {
        $serialNumber = $this->find('first',array(
            'conditions'=>array(
                'SerialNumber.id' => $serialNumberId
        )));
        return $serialNumber;
    }

    public function createDateFromDate($date)
    {
        if (isset($date) && !empty($date)) {
            $date = DateTime::createFromFormat('d/m/Y', $date);
            if ($date instanceof DateTime) {
                $date = $date->format('Y-m-d');
            } else {
                $date = null;
            }
        } else {
            $date = null;
        }
        return $date ;
    }

    public function getExpirationDateAlerts($limitedDate){

        $conditions = array();
        $conditions['SerialNumber.expiration_date <= '] = $limitedDate;
        $expirationDates = $this->find('all', array(
            'conditions' => $conditions,
            'recursive' => -1,
            'fields' => array(
                'SerialNumber.id',
                'SerialNumber.serial_number',
                'Product.name',
            ),
            'joins' => array(
                array(
                    'table' => 'products',
                    'type' => 'left',
                    'alias' => 'Product',
                    'conditions' => array('SerialNumber.product_id = Product.id')
                ),
            )
        ));
        return $expirationDates;
    }

}
