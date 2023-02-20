<?php
App::uses('AppModel', 'Model');
/**
 * Mark Model
 *
 *
 */
class Reservation extends AppModel {


    public $validate = array(



        'sheet_ride_detail_ride_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

        'cost' => array(
            'decimal' => array(
                'rule' => array('decimal'),
                'allowEmpty' => true,
                'required' => false,
            ),
        ),



    );

    public $hasMany = array(

       /* 'DetailRide' => array(
            'className' => 'DetailRide',
            'foreignKey' => 'ride_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),*/
    );

    public $belongsTo = array(

        'SheetRideDetailRides' => array(
            'className' => 'SheetRideDetailRides',
            'foreignKey' => 'sheet_ride_detail_ride_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

        'Car' => array(
            'className' => 'Car',
            'foreignKey' => 'car_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

    );

    // Function for encryption
    function encrypt($data) {
        return base64_encode(base64_encode(base64_encode(strrev($data))));
    }

// Function for decryption
    function decrypt($data) {
        return strrev(base64_decode(base64_decode(base64_decode($data))));
    }

    public function addReservation($carId = null, $sheetRideDetailRideId = null,
                                   $reservationCost = null, $subcontractorId =null,
                                   $userId = null, $priceRecovered=null,
                                    $transportBillDetailedRideId = null)
    {

        $SheetRideDetailRidesModel = ClassRegistry::init('SheetRideDetailRides');
        if(!empty($priceRecovered)&& $priceRecovered ==1){
            $sheetRideDetailRide = $SheetRideDetailRidesModel->find('first', array(
                'conditions' => array('SheetRideDetailRides.id' => $sheetRideDetailRideId),
                'recursive' => -1,
                'fields' => array(
                    'SheetRideDetailRides.planned_start_date',
                    'SheetRideDetailRides.real_start_date',
                    'SheetRideDetailRides.planned_end_date',
                    'SheetRideDetailRides.real_end_date',
                    'SheetRideDetailRides.km_departure',
                    'SheetRideDetailRides.km_arrival',
                    'SheetRideDetailRides.km_arrival_estimated',
                    'SheetRideDetailRides.detail_ride_id',
                    'TransportBillDetailRides.unit_price'
                ),
                'joins'=>array(
                    array(
                        'table' => 'transport_bill_detail_rides',
                        'type' => 'left',
                        'alias' => 'TransportBillDetailRides',
                        'conditions' => array('TransportBillDetailRides.id = SheetRideDetailRides.transport_bill_detail_ride_id')
                    ),
                )
            ));
        }else {
            $sheetRideDetailRide = $SheetRideDetailRidesModel->find('first', array(
                'conditions' => array('SheetRideDetailRides.id' => $sheetRideDetailRideId),
                'recursive' => -1,
                'fields' => array(
                    'SheetRideDetailRides.planned_start_date',
                    'SheetRideDetailRides.real_start_date',
                    'SheetRideDetailRides.planned_end_date',
                    'SheetRideDetailRides.real_end_date',
                    'SheetRideDetailRides.km_departure',
                    'SheetRideDetailRides.km_arrival',
                    'SheetRideDetailRides.km_arrival_estimated',
                    'SheetRideDetailRides.detail_ride_id'
                ),

            ));
        }
        if (!empty($sheetRideDetailRide['SheetRideDetailRides']['real_start_date'])) {
            $startDate = $sheetRideDetailRide['SheetRideDetailRides']['real_start_date'];
        } else {
            $startDate = $sheetRideDetailRide['SheetRideDetailRides']['planned_start_date'];
        }
        if (!empty($sheetRideDetailRide['SheetRideDetailRides']['real_end_date'])) {
            $endDate = $sheetRideDetailRide['SheetRideDetailRides']['real_end_date'];
        } else {
            $endDate = $sheetRideDetailRide['SheetRideDetailRides']['planned_end_date'];
        }
        if($carId != null){
            $CarModel = ClassRegistry::init('Car');
            $car = $CarModel->find('first', array(
                'conditions' => array('Car.id' => $carId),
                'recursive' => -1,
                'fields' => array('Car.supplier_id', 'Car.car_type_id')
            ));
            $supplierId = $car['Car']['supplier_id'];
        }else {
            $supplierId = $subcontractorId;
        }
        if(!empty($reservationCost)){
           $cost =  $reservationCost;
        }else {
            $detailRideId = $sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'];
            $ContractModel = ClassRegistry::init('Contract');
            $contract = $ContractModel->ContractCarType->find('first', array(
                'recursive' => -1,
                'conditions' => array(
                    'Contract.supplier_id' => $supplierId,
                    'ContractCarType.detail_ride_id' => $detailRideId,
                    'ContractCarType.date_start <=' => $startDate,
                    'ContractCarType.date_end  >=' => $endDate
                ),
                'fields' => array('ContractCarType.price_ht'),
                'joins' => array(
                    array(
                        'table' => 'contracts',
                        'type' => 'left',
                        'alias' => 'Contract',
                        'conditions' => array('ContractCarType.contract_id = Contract.id')
                    )
                )
            ));
            if (!empty($contract)) {
                $cost = $contract['ContractCarType']['price_ht'];
            }else {
                $cost = 0;
            }
        }
        $this->create();
        $reservation = array();
        $reservation['Reservation']['car_id'] = $carId;
        $reservation['Reservation']['supplier_id'] = $supplierId;
        $reservation['Reservation']['sheet_ride_detail_ride_id'] = $sheetRideDetailRideId;
        $reservation['Reservation']['cost'] = $cost;
        if(!empty($priceRecovered)&& $priceRecovered ==1){
            $reservation['Reservation']['amount_remaining'] = 0;
            $reservation['Reservation']['status'] = 2;
            $advance = $this->getReservationAdvance($transportBillDetailedRideId);
            $reservation['Reservation']['advanced_amount'] = $advance - $cost;
        }else {
            $reservation['Reservation']['cost'] = $cost;
            $reservation['Reservation']['amount_remaining'] = $cost;
        }
        $reservation['Reservation']['user_id'] = $userId;
        if ($this->save($reservation)) {
            $SupplierModel = ClassRegistry::init('Supplier');
            $supplier = $SupplierModel->getSuppliersById($supplierId);
            $newBalance = $supplier['Supplier']['balance'] + (-$cost);
            $SupplierModel->id = $supplierId;
            $SupplierModel->saveField('balance', $newBalance);
        }
    }

    public function getReservationAdvance($transportBillDetailedRideId)
    {
        $DetailedRidesModel = ClassRegistry::init('TransportBillDetailedRides');
        $detailedRide = $DetailedRidesModel->find('first',array(
            'recursive' => -1,
            'conditions' => array(
                'TransportBillDetailedRides.id' => $transportBillDetailedRideId
            ),
            'paramType' => 'querystring',
            'fields' => array(
                'TransportBillDetailedRides.price_ttc',
                'TransportBillDetailedRides.nb_trucks',
                'TransportBill.payment_method',
            ),
            'joins' => array(
                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('TransportBill.id = TransportBillDetailedRides.transport_bill_id')
                )
            )
        ));
        if ($detailedRide['TransportBill']['payment_method'] == '6'){
            $advance =  $detailedRide['TransportBillDetailedRides']['price_ttc'] * 1.01;
        }else{
            $advance = $detailedRide['TransportBillDetailedRides']['price_ttc'];
        }
        return  $advance;
    }
    public function editReservation($carId = null, $sheetRideDetailRideId = null,
                                    $reservationCost = null, $subcontractorId = null,
                                    $userId=null, $priceRecovered=null)
    {
        $reservation = $this->find('first',
            array('conditions' => array('Reservation.sheet_ride_detail_ride_id' => $sheetRideDetailRideId)));
        if(!empty($reservation)){
            $reservationId = $reservation['Reservation']['id'];
            $precedentCost = $reservation['Reservation']['cost'];
        }

        if(!empty($priceRecovered)&& ($priceRecovered==1)){
            $SheetRideDetailRidesModel = ClassRegistry::init('SheetRideDetailRides');
            $sheetRideDetailRide = $SheetRideDetailRidesModel->find('first', array(
                'conditions' => array('SheetRideDetailRides.id' => $sheetRideDetailRideId),
                'recursive' => -1,
                'fields' => array(
                    'SheetRideDetailRides.planned_start_date',
                    'SheetRideDetailRides.real_start_date',
                    'SheetRideDetailRides.planned_end_date',
                    'SheetRideDetailRides.real_end_date',
                    'SheetRideDetailRides.km_departure',
                    'SheetRideDetailRides.km_arrival',
                    'SheetRideDetailRides.km_arrival_estimated',
                    'SheetRideDetailRides.detail_ride_id',
                    'TransportBillDetailRides.unit_price'
                ),
                'joins'=>array(
                    array(
                        'table' => 'transport_bill_detail_rides',
                        'type' => 'left',
                        'alias' => 'TransportBillDetailRides',
                        'conditions' => array('TransportBillDetailRides.id = SheetRideDetailRides.transport_bill_detail_ride_id')
                    ),
                )
            ));
        }else {
            $SheetRideDetailRidesModel = ClassRegistry::init('SheetRideDetailRides');
            $sheetRideDetailRide = $SheetRideDetailRidesModel->find('first', array(
                'conditions' => array('SheetRideDetailRides.id' => $sheetRideDetailRideId),
                'recursive' => -1,
                'fields' => array(
                    'SheetRideDetailRides.planned_start_date',
                    'SheetRideDetailRides.real_start_date',
                    'SheetRideDetailRides.planned_end_date',
                    'SheetRideDetailRides.real_end_date',
                    'SheetRideDetailRides.km_departure',
                    'SheetRideDetailRides.km_arrival',
                    'SheetRideDetailRides.km_arrival_estimated',
                    'SheetRideDetailRides.detail_ride_id'
                )
            ));
        }
        if (!empty($sheetRideDetailRide['SheetRideDetailRides']['real_start_date'])) {
            $startDate = $sheetRideDetailRide['SheetRideDetailRides']['real_start_date'];
        } else {
            $startDate = $sheetRideDetailRide['SheetRideDetailRides']['planned_start_date'];
        }
        if (!empty($sheetRideDetailRide['SheetRideDetailRides']['real_end_date'])) {
            $endDate = $sheetRideDetailRide['SheetRideDetailRides']['real_end_date'];
        } else {
            $endDate = $sheetRideDetailRide['SheetRideDetailRides']['planned_end_date'];
        }
        if($carId!=null){
            $CarModel = ClassRegistry::init('Car');
            $car = $CarModel->find('first', array(
                'conditions' => array('Car.id' => $carId),
                'recursive' => -1,
                'fields' => array('Car.supplier_id', 'Car.car_type_id')
            ));
            $supplierId = $car['Car']['supplier_id'];
        }else {
            $supplierId = $subcontractorId;
        }
        $detailRideId = $sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'];
        if(!empty($reservationCost)){
            $cost = $reservationCost;
        }else {

            $ContractModel = ClassRegistry::init('Contract');
            $contract = $ContractModel->ContractCarType->find('first', array(
                'recursive' => -1,
                'conditions' => array(
                    'Contract.supplier_id' => $supplierId,
                    'ContractCarType.detail_ride_id' => $detailRideId,
                    'ContractCarType.date_start <=' => $startDate,
                    'ContractCarType.date_end  >=' => $endDate
                ),
                'fields' => array('ContractCarType.price_ht'),
                'joins' => array(
                    array(
                        'table' => 'contracts',
                        'type' => 'left',
                        'alias' => 'Contract',
                        'conditions' => array('ContractCarType.contract_id = Contract.id')
                    )
                )
            ));
            if (!empty($contract)) {
                $cost = $contract['ContractCarType']['price_ht'];
            } else {
                $cost = 0;
            }
        }


        $reservation = array();
        $reservation['Reservation']['id'] = $reservationId;
        $reservation['Reservation']['car_id'] = $carId;
        $reservation['Reservation']['supplier_id'] = $subcontractorId;
        $reservation['Reservation']['sheet_ride_detail_ride_id'] = $sheetRideDetailRideId;
        $reservation['Reservation']['cost'] = $cost;
        if(!empty($priceRecovered)&& $priceRecovered ==1){
            $reservation['Reservation']['amount_remaining'] = 0;
            $reservation['Reservation']['status'] = 2;
            $reservation['Reservation']['advanced_amount'] = $sheetRideDetailRide['TransportBillDetailRides']['unit_price']-$cost;
        }else {
            $reservation['Reservation']['amount_remaining'] = $cost;
        }
        $reservation['Reservation']['last_modifier_id'] = $userId;;
        if ($this->save($reservation)) {
            $SupplierModel = ClassRegistry::init('Supplier');
            $supplier = $SupplierModel->getSuppliersById($supplierId);
            $newBalance = $supplier['Supplier']['balance'] + $precedentCost + (-$cost);
            $SupplierModel->id = $supplierId;
            $SupplierModel->saveField('balance', $newBalance);

        }
    }

    public function deleteReservation($sheetRideDetailRideId = null)
    {
        $this->deleteAll(array('Reservation.sheet_ride_detail_ride_id' => $sheetRideDetailRideId), false);
    }


    public function getReservationBySheetRideDetailRideId($sheetRideDetailRideId=null){
        $reservation = $this->find('first',array(
            'recursive'=>-1,
            'conditions'=>array('Reservation.sheet_ride_detail_ride_id'=>$sheetRideDetailRideId),
            'fields'=>array('Reservation.cost')
        ));
        return $reservation;
    }


}
