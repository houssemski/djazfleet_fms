<?php
App::uses('AppController', 'Controller');

/**
 * SerialNumbers Controller
 *
 * @property SerialNumber $SerialNumber
 * @property BillProductSerialNumber $BillProductSerialNumber
 *
 */
class SerialNumbersController extends AppController
{

    public $uses = array('SerialNumber','BillProductSerialNumber');
    public function checkIfSerialNumberExistAjax(){
        $serialNumber = filter_input(INPUT_GET, "serialNumber");
        $productId = filter_input(INPUT_GET, "productId");
        $serialNumber = $this->SerialNumber->getSerialNumberBySerialNumber($serialNumber,$productId);

        if($serialNumber != null)
        {
            $serialNumberId=$serialNumber['SerialNumber']['id'];
            $isUsed = $serialNumber['SerialNumber']['is_used'];
            $label = $serialNumber['SerialNumber']['label'];
            $json_data=array('serialNumberId'=>$serialNumberId, "isUsed"=>$isUsed,"label"=>$label, "response"=>"true");
        }
        else
        {
            $response= "false";
            $json_data=array("response"=>$response);
        }
        echo json_encode($json_data);

        exit;
    }

    public function checkIfLabelSerialNumberExistAjax(){
        $label = filter_input(INPUT_GET, "label");
        $productId = filter_input(INPUT_GET, "productId");

        $serialNumber = $this->SerialNumber->getSerialNumberByLabel($label,$productId);

        if($serialNumber != null)
        {
            $serialNumberId=$serialNumber['SerialNumber']['id'];
            $isUsed = $serialNumber['SerialNumber']['is_used'];
            $serial = $serialNumber['SerialNumber']['serial_number'];
            $json_data=array('serialNumberId'=>$serialNumberId, "isUsed"=>$isUsed,"serial"=>$serial, "response"=>"true");
        }
        else
        {
            $response= "false";
            $json_data=array("response"=>$response);
        }
        echo json_encode($json_data);

        exit;
    }



    public function addSerialNumberAjax(){
        $serialNumber = filter_input(INPUT_GET, "serialNumber");
        $productId = filter_input(INPUT_GET, "productId");
        $label = filter_input(INPUT_GET, "label");

        $serialNumberId = $this->SerialNumber->addSerialNumber($serialNumber,$productId,$label);


        if($serialNumberId != null)
        {
            $id=$serialNumberId;

            $json_data=array('id'=>$id, "response"=>"true");
        }
        else
        {
            $json_data=array("id"=>null,"response"=>"false");
        }
        echo json_encode($json_data);

        exit;
    }
    public function updateSerialNumberAjax(){
        $serialNumber = filter_input(INPUT_GET, "serialNumber");
        $serialNumberId = filter_input(INPUT_GET, "serialNumberId");
        $productId = filter_input(INPUT_GET, "productId");
        $label = filter_input(INPUT_GET, "label");

        $serialNumberId = $this->SerialNumber->updateSerialNumber($serialNumber,$productId, $serialNumberId,$label);


        if($serialNumberId != null)
        {
            $id=$serialNumberId;

            $json_data=array('id'=>$id, "response"=>"true");
        }
        else
        {
            $json_data=array("id"=>null,"response"=>"false");
        }
        echo json_encode($json_data);

        exit;
    }

    public function deleteSerialNumberAjax(){
        $serialNumberId = filter_input(INPUT_GET, "serialNumberId");
        $serialNumber = $this->SerialNumber->getSerialNumberBySerialNumberId($serialNumberId);

            if ($this->SerialNumber->delete($serialNumberId)) {
                $this->loadModel('BillProductSerialNumber');
                $this->BillProductSerialNumber->deleteAll(array('serial_number_id' => $serialNumber['SerialNumber']['id']));
                $json_data=array( "response"=>"true");
            }else {
                $json_data=array( "response"=>"false");
            }

        echo json_encode($json_data);

        exit;
    }

    public function checkSerialNumberGuaranteeAjax(){
        $serialNumberId = filter_input(INPUT_GET, "serialNumberId");
        $documentDate = filter_input(INPUT_GET, "billDate");
        $serialNumber = $this->SerialNumber->find('first', array(
            'conditions'=>array('SerialNumber.id' => $serialNumberId),
            'fields'=>array('Product.with_guarantee','Product.month_duration'),
            'joins'=>array(
                array(
                    array(
                        'table' => 'products',
                        'type' => 'left',
                        'alias' => 'Product',
                        'conditions' => array('Product.id = SerialNumber.product_id')
                    ),
                )
            )
        ));
        $monthDuration = $serialNumber['Product']['month_duration'] ;
        $currentDate = date('Y-m-d');
        //$documentDate = date('2018-07-11');
        $datetime1 = new \DateTime($documentDate);
        $datetime2 = new \DateTime($currentDate);
        $interval = $datetime1->diff($datetime2);
        $nbMonth = ( 12 * $interval->format('%y')) + $interval->format('%m');
        if($monthDuration>$nbMonth){
            $json_data=array("response"=>"true");
        }else {
            $json_data=array("response"=>"false");
        }
        echo json_encode($json_data);
        exit;

    }
    public function serialNumbersAlertsCron(){
        $this->Alert->deleteAll(array('Alert.alert_type_id '=>32), false);

        $this->setExpirationDateAlerts();

    }



}
