<?php

App::uses('AppModel', 'Model');

/**
 * ContractCarType Model
 *
 * @property ContractCarType $ContractCarType
 */
class ContractCarType extends AppModel
{


    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(

        'contract_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'detail_ride_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => ''
            ),
        ),
        'price_ht' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => ''
            ),
        ),
        'date_start' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => ''
            ),
        ),
        'date_end' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => ''
            ),
        ),


    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(


        'DetailRide' => array(
            'className' => 'DetailRide',
            'foreignKey' => 'detail_ride_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Contract' => array(
            'className' => 'Contract',
            'foreignKey' => 'contract_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    /**
     * Get contract details by contract id
     *
     * @param int $contractId
     * @param string|null $typeSelect
     *
     * @return array $contractDetails
     */
    public function getContractDetailsByContractId($contractId, $typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = 'list';
        }
        $contractDetails = $this->find(
            $typeSelect,
            array(
                'conditions' => array('ContractCarType.contract_id' => $contractId),
                'recursive' => -1,
                'fields' => array(
                    'DepartureDestination.name',
                    'ArrivalDestination.name',
                    'CarType.name',
                    'ContractCarType.price_ht',
                    'ContractCarType.price_return',
                    'ContractCarType.date_start',
                    'ContractCarType.date_end'
                ),
                'joins' => array(
                    array(
                        'table' => 'detail_rides',
                        'type' => 'left',
                        'alias' => 'DetailRide',
                        'conditions' => array('DetailRide.id = ContractCarType.detail_ride_id')
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
                    )
                )

            )
        );
        return $contractDetails;
    }

    /**
     * @param null $contractCarType
     * @param null $contractId
     * @throws Exception
     */
    public function addContractCarType($contractCarType = null, $contractId = null)
    {
        $this->create();
        $contract = array();
        $contract['ContractCarType']['contract_id'] = $contractId;
        $contract['ContractCarType']['detail_ride_id'] = $contractCarType['detail_ride_id'];
        $contract['ContractCarType']['price_ht'] = $contractCarType['price_ht'];
        $contract['ContractCarType']['pourcentage_price_return'] = $contractCarType['pourcentage_price_return'];
        $contract['ContractCarType']['price_return'] = $contractCarType['price_return'];
        $contract['ContractCarType']['date_start'] = $contractCarType['date_start'];
        $contract['ContractCarType']['date_end'] = $contractCarType['date_end'];
        $this->save($contract);
    }

    /**
     * @param null $contractCarType
     * @param null $contractId
     * @throws Exception
     */
    public function updateContractCarType($contractCarType = null, $contractId = null)
    {
        $contract = array();
        $contract['ContractCarType']['id'] =  $contractCarType['id'];;
        $contract['ContractCarType']['contract_id'] = $contractId;
        $contract['ContractCarType']['detail_ride_id'] = $contractCarType['detail_ride_id'];
        $contract['ContractCarType']['price_ht'] = $contractCarType['price_ht'];
        $contract['ContractCarType']['pourcentage_price_return'] = $contractCarType['pourcentage_price_return'];
        $contract['ContractCarType']['price_return'] = $contractCarType['price_return'];
        $contract['ContractCarType']['date_start'] = $contractCarType['date_start'];
        $contract['ContractCarType']['date_end'] = $contractCarType['date_end'];
        $this->save($contract);
    }

    /**
     * @param null $contractId
     */
    public function deleteContractCarType($contractId = null){

        $this->id = $contractId;
        $this->delete();
    }

    public function  findContractCarTypeByParams($typeSelect = null, $conditions=null){
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }

        $contract = $this->find($typeSelect, array(
            'recursive' => -1,
            'conditions' => $conditions,
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
        return $contract;
    }



}
