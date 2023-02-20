<?php

App::uses('AppModel', 'Model');

/**
 * Affiliate Model
 *
 *
 */
class Alert extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */


    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'alert_type_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'object_id' => array(
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



    /**
     * Insert alert
     * @param array $alerts
     * @param int $alertTypeId
     * @param string $model
     *
     *
     */
    public function insertAlerts($alerts = null,$alertTypeId = null, $model= null )
    {
        if ($model == 'Event'){
            $data = array();
            if($model != null){
                $data['Alert']['object_id'] = $alerts[$model]['id'];
            }
            if(!empty($alertTypeId)){
                $data['Alert']['alert_type_id'] = $alertTypeId;
            }else {
                if($model=='Event'){
                    $data['Alert']['alert_type_id'] = $alerts['EventEventType']['event_type_id'];
                }
            }
            if ($model == 'Event'){
                $data = $this->setEventAlertTypeId($data);
            }
            $data['Alert']['model'] = $model;
            $this->create();
            $this->save($data);
        }else{
            foreach ($alerts as $alert){
                $data = array();
                if($model != null){
                    $data['Alert']['object_id'] = $alert[$model]['id'];
                }
                if ($model == 'Event'){
                    $data = $this->setEventAlertTypeId($data);
                }else{
                    if(!empty($alertTypeId)){
                        $data['Alert']['alert_type_id'] = $alertTypeId;
                    }
                }

                $data['Alert']['model'] = $model;
                $this->create();
                $this->save($data);

            }
        }
    }

    public function setEventAlertTypeId($data){
        /**
         * @var EventType $EventType
         */
        $EventType = ClassRegistry::init('EventType');
        $evenType = $EventType->find('first', array(
            'conditions' => array(
                'EventType.id' => $data['Alert']['alert_type_id']
            )
        ));
        switch ($evenType['EventType']['id']){
            case 1 : // Vidange
                $data['Alert']['alert_type_id'] = 4;
                break;
            case 2 : // assurance
                $data['Alert']['alert_type_id'] = 1;
                break;
            case 3 : // Controle technique
                $data['Alert']['alert_type_id'] = 2;
                break;
            case 5 : // Vignette
                $data['Alert']['alert_type_id'] = 3;
                break;
            default :
                if ($evenType['EventType']['with_date']){
                    $data['Alert']['alert_type_id'] = 6;
                }elseif ($evenType['EventType']['with_date']){
                    $data['Alert']['alert_type_id'] = 7;
                }
                break;
        }
        return $data;
    }

    /**
     * @param null $sectionId
     * @param null $userParcsIds
     * @return mixed
     */

    public function getNbAlertsByUserPermissions($sectionId = null , $userParcsIds = null){
        $query = " SELECT COUNT(*) as nbAlerts FROM alerts  LEFT JOIN alert_types on alerts.alert_type_id = alert_types.id
                 ";
        if(!empty($userParcsIds)){
            $countUserParcs = count($userParcsIds);
            if ($countUserParcs == 1){
                $userParcsIds = implode(',' ,$userParcsIds);
                $userParcsIds = ' = '.$userParcsIds ;
            }else{
                $userParcsIds = implode(',' ,$userParcsIds);
                $userParcsIds = ' IN ('.$userParcsIds . ')';
            }
        }
        if ($sectionId != null) {
            if ($sectionId == SectionsEnum::alertes_administratives_juridiques ||
                $sectionId == SectionsEnum::alertes_maintenances){
                if (!empty($userParcsIds)){
                    $query .= " LEFT JOIN event Events ON alerts.object_id = Events.id
                     LEFT JOIN car Cars ON Cars.id = Events.car_id" ;
                }
            }
            $query .= "  where alert_types.section_id = " . (int)$sectionId;
            if ($sectionId == SectionsEnum::alertes_administratives_juridiques ||
                $sectionId == SectionsEnum::alertes_maintenances){
                if (!empty($userParcsIds)){
                    $query .= " &&  Cars.parc_id  {$userParcsIds} " ;
                }
            }
        }
        return $this->query($query);
    }

    public function getNbAlerts(){
        $query = " SELECT COUNT(*) as nbAlerts FROM alerts  LEFT JOIN alert_types on alerts.alert_type_id = alert_types.id ";

        return $this->query($query);
    }

    public function getAlertsWithCategories($categoryIds= null, $userParcsIds = null){
        $conditions = array('EventTypeCategoryEventType.event_type_category_id'=>$categoryIds);
        if (!empty($userParcsIds)){
            $conditions = array(
                'EventTypeCategoryEventType.event_type_category_id'=>$categoryIds,
                'Car.parc_id' => $userParcsIds
                );
        }
        $alerts = $this->find('all', array(
            'conditions' => $conditions,
            'recursive' => -1,
            'fields' => array(
                'Car.code',
                'Car.immatr_def',
                'Event.next_date',
                'EventEventType.event_type_id',
                'Carmodel.name',
                'Car.id',
                'EventType.name',
                'Event.send_mail',
                'Event.id',
            ),
            'joins' => array(

                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Event',
                    'conditions' => array('Alert.object_id = Event.id')
                ),
                array(
                    'table' => 'event_event_types',
                    'type' => 'left',
                    'alias' => 'EventEventType',
                    'conditions' => array('EventEventType.event_id = Event.id')
                ),
                array(
                    'table' => 'event_types',
                    'type' => 'left',
                    'alias' => 'EventType',
                    'conditions' => array('EventEventType.event_type_id = EventType.id')
                ),

                array(
                    'table' => 'event_type_category_event_type',
                    'type' => 'left',
                    'alias' => 'EventTypeCategoryEventType',
                    'conditions' => array('EventTypeCategoryEventType.event_type_id = EventType.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Event.car_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),

            )));
        return $alerts;
    }

    public function getAssuranceAlerts($paramCode){
        $assuranceAlerts = $this->find('all', array(
            'conditions' => array('Alert.alert_type_id'=>$paramCode),
            'recursive' => -1,
            'fields' => array(
                'Car.code',
                'Car.immatr_def',
                'Event.next_date',
                'EventEventType.event_type_id',
                'Carmodel.name',
                'Car.id',
                'EventType.name',
                'Event.send_mail',
                'Event.id',
            ),
            'joins' => array(

                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Event',
                    'conditions' => array('Alert.object_id = Event.id')
                ),
                array(
                    'table' => 'event_event_types',
                    'type' => 'left',
                    'alias' => 'EventEventType',
                    'conditions' => array('EventEventType.event_id = Event.id')
                ),
                array(
                    'table' => 'event_types',
                    'type' => 'left',
                    'alias' => 'EventType',
                    'conditions' => array('EventEventType.event_type_id = EventType.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Event.car_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),

            )));
        return $assuranceAlerts;
    }

    public function getControlAlerts($paramCode){
        $controlAlerts = $this->find('all', array(
            'conditions' => array('Alert.alert_type_id'=>$paramCode),
            'recursive' => -1,
            'fields' => array(
                'Car.code',
                'Car.immatr_def',
                'Event.next_date',
                'EventEventType.event_type_id',
                'Carmodel.name',
                'Car.id',
                'EventType.name',
                'Event.send_mail',
                'Event.id',
            ),
            'joins' => array(
                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Event',
                    'conditions' => array('Alert.object_id = Event.id')
                ),
                array(
                    'table' => 'event_event_types',
                    'type' => 'left',
                    'alias' => 'EventEventType',
                    'conditions' => array('EventEventType.event_id = Event.id')
                ),
                array(
                    'table' => 'event_types',
                    'type' => 'left',
                    'alias' => 'EventType',
                    'conditions' => array('EventEventType.event_type_id = EventType.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Event.car_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),

            )

        ));
        return $controlAlerts;
    }

    public function getVidangeAlerts($paramCode){
        $vidangeAlerts = $this->find('all', array(
            'conditions' => array('Alert.alert_type_id'=>$paramCode),
            'recursive' => -1,
            'fields' => array(
                'Car.code',
                'Car.immatr_def',
                'Event.next_km',
                'EventEventType.event_type_id',
                'Carmodel.name',
                'Car.id',
                'EventType.name',
                'Event.id',
            ),
            'joins' => array(
                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Event',
                    'conditions' => array('Alert.object_id = Event.id')
                ),
                array(
                    'table' => 'event_event_types',
                    'type' => 'left',
                    'alias' => 'EventEventType',
                    'conditions' => array('EventEventType.event_id = Event.id')
                ),
                array(
                    'table' => 'event_types',
                    'type' => 'left',
                    'alias' => 'EventType',
                    'conditions' => array('EventEventType.event_type_id = EventType.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Event.car_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),

            )

        ));
        return $vidangeAlerts;
    }

    public function getKmAlerts($paramCode){
        $kmAlerts = $this->find('all', array(
            'conditions' => array('Alert.alert_type_id'=>$paramCode),
            'recursive' => -1,
            'fields' => array(
                'Car.code',
                'Car.immatr_def',
                'Event.next_km',
                'EventEventType.event_type_id',
                'Carmodel.name',
                'Car.id',
                'EventType.name',
                'Event.id',
            ),
            'joins' => array(
                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Event',
                    'conditions' => array('Alert.object_id = Event.id')
                ),
                array(
                    'table' => 'event_event_types',
                    'type' => 'left',
                    'alias' => 'EventEventType',
                    'conditions' => array('EventEventType.event_id = Event.id')
                ),
                array(
                    'table' => 'event_types',
                    'type' => 'left',
                    'alias' => 'EventType',
                    'conditions' => array('EventEventType.event_type_id = EventType.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Event.car_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),

            )

        ));
        return $kmAlerts;
    }

    public function getVignetteAlerts($paramCode){
        $vignetteAlerts = $this->find('all', array(
            'conditions' => array('Alert.alert_type_id'=>$paramCode),
            'recursive' => -1,
            'fields' => array(
                'Car.code',
                'Car.immatr_def',
                'Event.next_date',
                'EventEventType.event_type_id',
                'Carmodel.name',
                'Car.id',
                'EventType.name',
                'Event.send_mail',
                'Event.id',
            ),
            'joins' => array(

                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Event',
                    'conditions' => array('Alert.object_id = Event.id')
                ),
                array(
                    'table' => 'event_event_types',
                    'type' => 'left',
                    'alias' => 'EventEventType',
                    'conditions' => array('EventEventType.event_id = Event.id')
                ),
                array(
                    'table' => 'event_types',
                    'type' => 'left',
                    'alias' => 'EventType',
                    'conditions' => array('EventEventType.event_type_id = EventType.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Event.car_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),

            )));
        return $vignetteAlerts;
    }

    public function getDateAlerts($paramCode){
        $dateAlerts = $this->find('all', array(
            'conditions' => array('Alert.alert_type_id'=>$paramCode),
            'recursive' => -1,
            'fields' => array(
                'Car.code',
                'Car.immatr_def',
                'Event.next_date',
                'EventEventType.event_type_id',
                'Carmodel.name',
                'Car.id',
                'EventType.name',
                'Event.send_mail',
                'Event.id',
            ),
            'joins' => array(

                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Event',
                    'conditions' => array('Alert.object_id = Event.id')
                ),
                array(
                    'table' => 'event_event_types',
                    'type' => 'left',
                    'alias' => 'EventEventType',
                    'conditions' => array('EventEventType.event_id = Event.id')
                ),
                array(
                    'table' => 'event_types',
                    'type' => 'left',
                    'alias' => 'EventType',
                    'conditions' => array('EventEventType.event_type_id = EventType.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Event.car_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),

            )));
        return $dateAlerts;
    }

    public function getVidangeHourAlerts($paramCode){
        $vidangeHourAlerts = $this->find('all', array(
            'conditions' => array('Alert.alert_type_id'=>$paramCode),
            'recursive' => -1,
            'fields' => array(
                'Event.id',
                'Event.km',
                'Event.next_km',
                'EventEventType.event_type_id',
                'Car.code',
                'Car.immatr_def',
                'Car.carmodel_id',
                'Car.hours',
                'Carmodel.name',
                'EventType.name'
            ),
            'joins' => array(
                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Event',
                    'conditions' => array('Alert.object_id = Event.id')
                ),
                array(
                    'table' => 'event_event_types',
                    'type' => 'left',
                    'alias' => 'EventEventType',
                    'conditions' => array('EventEventType.event_id = Event.id')
                ),
                array(
                    'table' => 'event_types',
                    'type' => 'left',
                    'alias' => 'EventType',
                    'conditions' => array('EventEventType.event_type_id = EventType.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Event.car_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),

            )

        ));
        return $vidangeHourAlerts;
    }

    public function getKmContractAlerts($paramCode){
        $kmContractAlerts=$this->find('all',array(
                'conditions' => array('Alert.alert_type_id'=>$paramCode),
                'recursive' => -1,
                'fields' => array(
                    'Car.id',
                    'Car.code',
                    'Car.immatr_def',
                    'Mark.name',
                    'Carmodel.name',
                    'Leasing.reception_date',
                    'Leasing.end_date',
                    'Leasing.acquisition_type_id',
                    'Leasing.send_mail',
                    'Leasing.km_year', 'Car.km',
                ),
                'joins'=>array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('Alert.object_id = Car.id')
                    ),
                    array(
                        'table' => 'marks',
                        'type' => 'left',
                        'alias' => 'Mark',
                        'conditions' => array('Car.mark_id = Mark.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),
                    array(
                        'table' => 'leasings',
                        'type' => 'left',
                        'alias' => 'Leasing',
                        'conditions' => array('Car.id = Leasing.car_id')
                    ),
                )
            )
            );
        return $kmContractAlerts;
    }

    public function getDateContractAlerts($paramCode){
        $dateContractAlerts=$this->find('all',array(
                'conditions' => array('Alert.alert_type_id'=>$paramCode),
                'recursive' => -1,
                'fields' => array(
                    'Car.code',
                    'Car.immatr_def',
                    'Leasing.end_date',
                    'Leasing.alert_date',
                    'Carmodel.name',
                    'Car.id',
                    'Leasing.send_mail_date',

                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('Alert.object_id = Car.id')
                    ),
                    array(
                        'table' => 'leasings',
                        'type' => 'left',
                        'alias' => 'Leasing',
                        'conditions' => array('Leasing.car_id = Car.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),

                )
            )
            );
        return $dateContractAlerts;
    }

    public function getDriverLicenseAlerts($paramCode , $userParcsIds = null){
        $conditions = array('Alert.alert_type_id'=>$paramCode);
        if (!empty($userParcsIds)){
            $conditions = array(
                'Alert.alert_type_id'=>$paramCode,
                'Customer.parc_id' => $userParcsIds
            );
        }
        $driverLicenseAlerts = $this->find('all', array(
            'conditions' => $conditions,
            'recursive' => -1,
            'fields' => array(
                'Customer.id',
                'Customer.code',
                'Customer.first_name',
                'Customer.last_name',
                'Customer.driver_license_category',
                'Customer.driver_license_expires_date1',
                'Customer.driver_license_expires_date2',
                'Customer.driver_license_expires_date3',
                'Customer.driver_license_expires_date4',
                'Customer.driver_license_expires_date5',
                'Customer.driver_license_expires_date6',
                'Customer.exit_date',),
            'joins'=>array(
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Alert.object_id = Customer.id')
                ),

            )
        ));

        return $driverLicenseAlerts;
    }

    public function getNbKmConsumptionAlerts($paramCode){
        $consumptionAlerts = $this->find('all',array(
            'conditions' => array('Alert.alert_type_id'=>$paramCode),
            'recursive' => -1,
            'fields'=>array(
                'Car.id',
                'Car.km',
                'Carmodel.name',
                'Car.code',
                'Car.immatr_def',
            ),
            'joins'=>array(
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Alert.object_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
            )
        ));

        return $consumptionAlerts;
    }

    public function getCouponConsumptionAlerts($paramCode){
        $couponConsumptionAlerts = $this->find('all',array(
            'conditions' => array('Alert.alert_type_id'=>$paramCode),
            'recursive' => -1,
            'fields'=>array(
                'Car.id',
                'Carmodel.name',
                'Car.code',
                'Car.immatr_def',
                'Car.send_mail',
                'Car.coupon_consumption'

            ),
            'joins'=>array(
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Alert.object_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
            )
        ));

        return $couponConsumptionAlerts;
    }

    public function getMinCouponAlerts($paramCode){
        $minCouponAlerts = $this->find('all',array(
            'conditions' => array('Alert.alert_type_id'=>$paramCode),
            'recursive' => -1,
        ))  ;

        return $minCouponAlerts;

    }

    public function getAmortissementAlerts($paramCode){
        $amortissementAlerts = $this->find('all',array(
            'conditions' => array('Alert.alert_type_id'=>$paramCode),
            'recursive' => -1,
            'fields'=>array(
                'Car.id',
                'Car.code',
                'Car.immatr_def',
                'Car.carmodel_id',
                'Car.km',
                'Carmodel.name',
                'Car.amortization_km'

            ),
            'joins'=>array(
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Alert.object_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
            )
        ));

        return $amortissementAlerts;
    }

    public function getDeadlineAlerts($paramCode){
        $deadlineAlerts = $this->find('all',array(
            'conditions' => array('Alert.alert_type_id'=>$paramCode),
            'recursive' => -1,
            'fields'=>array(
                'TransportBill.id',
                'TransportBill.reference',
                'TransportBill.type',

            ),
            'joins'=>array(
                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('Alert.object_id = TransportBill.id')
                )
            )
        ));

        return $deadlineAlerts;
    }

    public function getProductMinAlerts($paramCode){
        $productMinAlerts = $this->find('all',array(
            'conditions' => array('Alert.alert_type_id'=>$paramCode),
            'recursive' => -1,
            'fields'=>array(
                'Product.id',
                'Product.code',
                'Product.name',
                'Product.quantity',
            ),
            'joins'=>array(
                array(
                    'table' => 'products',
                    'type' => 'left',
                    'alias' => 'Product',
                    'conditions' => array('Alert.object_id = Product.id')
                )
            )
        ));

        return $productMinAlerts;
    }

    public function getProductMaxAlerts($paramCode){
        $productMaxAlerts = $this->find('all',array(
            'conditions' => array('Alert.alert_type_id'=>$paramCode),
            'recursive' => -1,
            'fields'=>array(
                'Product.id',
                'Product.code',
                'Product.name',
                'Product.quantity',

            ),
            'joins'=>array(
                array(
                    'table' => 'products',
                    'type' => 'left',
                    'alias' => 'Product',
                    'conditions' => array('Alert.object_id = Product.id')
                )
            )
        ));

        return $productMaxAlerts;
    }

    public function getExpirationDateSerialNumberAlerts($paramCode){
        $productMaxAlerts = $this->find('all',array(
            'conditions' => array('Alert.alert_type_id'=>$paramCode),
            'recursive' => -1,
            'fields'=>array(
                'SerialNumber.id',
                'SerialNumber.serial_number',
                'SerialNumber.expiration_date',
                'Product.name',

            ),
            'joins'=>array(
                array(
                    'table' => 'serial_numbers',
                    'type' => 'left',
                    'alias' => 'SerialNumber',
                    'conditions' => array('Alert.object_id = SerialNumber.id')
                ) ,
                array(
                    'table' => 'products',
                    'type' => 'left',
                    'alias' => 'Product',
                    'conditions' => array('Product.id = SerialNumber.product_id')
                )
            )
        ));

        return $productMaxAlerts;
    }

}
