<?php

App::uses('AppModel', 'Model');

/**
 * Customer Model
 *
 * @property Customer $Customer
 * @property CustomerCategory $CustomerCategory
 * @property CustomerCar $CustomerCar
 */
class Customer extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */
    public $virtualFields = array(
        'cnames' => 'CONCAT(Customer.first_name, " ", Customer.last_name)',
        'names' => 'CONCAT(Customer.first_name, " ", Customer.last_name)'
    );

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'code' => array(
            'unique' => array(
                'rule' => 'isUnique',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
            ),
        ),
        'first_name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        /* 'adress' => array(
             'notEmpty' => array(
               //  'rule' => array('notEmpty'),
             //'message' => 'Your custom message here',
             'allowEmpty' => true,
             //'required' => false,
             //'last' => false, // Stop validation after this rule
             //'on' => 'create', // Limit validation to 'create' or 'update' operations
             ),
         ),*/
        /*'mobile' => array(
            'notEmpty' => array(
               // 'rule' => array('notEmpty'),
            //'message' => 'Your custom message here',
            'allowEmpty' => true,
           // 'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),*/
        'birthday' => array(
            'date' => array(
                'rule' => array('date'),
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                //  'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'user_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'customer_category_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
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
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'UserModifier' => array(
            'className' => 'User',
            'foreignKey' => 'modified_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'CustomerCategory' => array(
            'className' => 'CustomerCategory',
            'foreignKey' => 'customer_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'CustomerGroup' => array(
            'className' => 'CustomerGroup',
            'foreignKey' => 'customer_group_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Service' => array(
            'className' => 'Service',
            'foreignKey' => 'service_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Nationality' => array(
            'className' => 'Nationality',
            'foreignKey' => 'nationality_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Zone' => array(
            'className' => 'Zone',
            'foreignKey' => 'zone_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Parc' => array(
            'className' => 'Parc',
            'foreignKey' => 'parc_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Affiliate' => array(
            'className' => 'Affiliate',
            'foreignKey' => 'affiliate_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );
    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'CustomerCar' => array(
            'className' => 'CustomerCar',
            'foreignKey' => 'customer_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),

    );
    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Car' => array(
            'className' => 'Car',
            'joinTable' => 'customer_car',
            'foreignKey' => 'customer_id',
            'associationForeignKey' => 'car_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        )
    );

    /** get all customers who have a driver's license that is going to be expired
     * @param null $driverLicenseLimitValue
     * @param null $customerId
     * @return array|null
     */
	public function getCustomerWithDriverLicenseExpireDate (
	$driverLicenseLimitValue= null, $customerId=null){


        $currentDate = date('Y-m-d H:i');
	  $conditions =  array(
          'Customer.alert != ' => 2,
          'AND' => array(
					'OR'=>array(

					'Customer.driver_license_expires_date1 <='=>$driverLicenseLimitValue,
					'Customer.driver_license_expires_date2 <='=>$driverLicenseLimitValue,
					'Customer.driver_license_expires_date3 <='=>$driverLicenseLimitValue,
					'Customer.driver_license_expires_date4 <='=>$driverLicenseLimitValue,
					'Customer.driver_license_expires_date5 <='=>$driverLicenseLimitValue,
					'Customer.driver_license_expires_date6 <='=>$driverLicenseLimitValue,
					),
          ),
          array(
              'OR' => array(
                  array('Customer.exit_date IS NULL'),
                  array('Customer.exit_date >=' => $currentDate))
              )
          );
        if(!empty($customerId)){
            $conditions['Customer.id'] = $customerId;
        }


            $cutomers = $this->find('all', array(
			'recursive'=>-1,
                'conditions' => $conditions,

                'fields' => array(	'Customer.id',
									'Customer.code',
									'Customer.first_name',
									'Customer.last_name',
									'Customer.driver_license_expires_date1',
									'Customer.driver_license_expires_date2',
									'Customer.driver_license_expires_date3',
									'Customer.driver_license_expires_date4',
									'Customer.driver_license_expires_date5',
									'Customer.driver_license_expires_date6',
									'Customer.exit_date',
									'Customer.mobile',
									'Customer.locked',
									'Customer.send_mail'),
            ));





		return $cutomers;
	}

    /** get all customer with conditions
     * @param null $customerConditions
     * @param null $typeSelect
     * @return array|null
     */

	public function getCustomersByParams($customerConditions = null, $typeSelect=null){
		  $fields = "names";
		   date_default_timezone_set("Africa/Algiers");
        $currentDate = date("Y-m-d");
		  $conditions = array(
		  'OR' => array('Customer.exit_date >=' => $currentDate, 'Customer.exit_date is NULL'),
		  );
		  
		   if ($customerConditions != null) {
            $conditions = array_merge($conditions, $customerConditions);

        }
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if($typeSelect =='all'){
            $fields = array('Customer.first_name','Customer.last_name');
        }
        $customers = $this->find($typeSelect, array(
            'fields' => $fields,
            'conditions' => $conditions,
            'order' => array(
                'TRIM(Customer.first_name)' => 'ASC',
                'Customer.last_name' => 'ASC',
                'Customer.company' => 'ASC'
            )

        ));
		return $customers ;
	}

	public function getTotals($conditions=null) {

        $cond='';

    $i=0;
    $j=0;
    if(!empty($conditions)){
    foreach ($conditions  as $key => $value){
    if($i==count($conditions)-1){
    if($key=='Customer.parc_id'){
        foreach($value as $val){

                            if ($j == count($value) - 1) {
                                $cond = ' ' . $cond . $key . '=' . $val . ' ';
                            } else {
                                $cond = ' ' . $cond . $key . '=' . $val . ' or ';
                            }
                            $j++;
                        }

                    } else {
                        $cond = ' ' . $cond . $key . '=' . $value . ' ';
                    }

                } else {
                    if ($key == 'Customer.parc_id') {
                        foreach ($value as $val) {
                            if ($j == count($value) - 1) {
                                $cond = ' ' . $cond . $key . '=' . $val . ' ';
                            } else {
                                $cond = ' ' . $cond . $key . '=' . $val . ' or ';
                            }
                            $j++;
                        }

                    } else {
                        $cond = ' ' . $cond . $key . '=' . $value . ' and ';
                    }


                }
                $i++;
            };

        }

        $query = "SELECT count(*) as total, customer_category_id, CustomerCategory.name "
            . "FROM customers AS Customer "
            . "LEFT JOIN customer_categories AS CustomerCategory ON Customer.customer_category_id = CustomerCategory.id ";
        if ($cond != '') {
            $query .= "Where" . $cond;
        };
        $query .= "Group By customer_category_id";
        return $this->query($query);
    }

    /** get all customer with is_open = 1
     * @return array|null
     */
    public function getAllOpenedCustomers(){
        $customers = $this->find('all', array(
            'recursive' => -1,
            'conditions' => array('is_open' => 1),
            'fields' => array('id')
        ));
        return $customers;
    }

    /**
     * Get customers by fields and conditions
     *
     * @param array|null $fields
     * @param array|null $conditions
     * @param string|null $typeSelect
     *
     * @return array $customers
     */
    public function getCustomersByFieldsAndConds($fields = null, $conditions = null, $typeSelect = null)
    {
        date_default_timezone_set("Africa/Algiers");
        $currentDate = date("Y-m-d");
        $dateCondition = array(
            'OR' => array('Customer.exit_date >=' => $currentDate,
                'Customer.exit_date is NULL',
                'Customer.exit_date' => '0000-00-00'),
        );
        $conditions =  array(
            'AND' => array(
                $dateCondition
            ),
            array(
                $conditions
            )
        );
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }

        $customers = $this->find(
            $typeSelect,
            array(
                'fields' => $fields,
                'conditions' => $conditions,
                'recursive' => -1,
                'order' => array(
                    'Customer.code' => 'ASC',
                    'TRIM(Customer.first_name)' => 'ASC',
                    'Customer.last_name' => 'ASC',
                    'Customer.company' => 'ASC'
                ),
                'joins'=>array(
                    array(
                        'table' => 'customer_categories',
                        'type' => 'left',
                        'alias' => 'CustomerCategory',
                        'conditions' => array('Customer.customer_category_id = CustomerCategory.id')
                    )

                )

            ));
        return $customers;
    }  /**
     * Get Convoyeurs by fields and conditions
     *
     * @param array|null $fields
     * @param array|null $conds
     * @param string|null $typeSelect
     *
     * @return array $customers
     */
    public function getConvoyeursByFieldsAndConds($fields = null, $conds = null, $typeSelect = null)
    {


        date_default_timezone_set("Africa/Algiers");
        $currentDate = date("Y-m-d");
        $conditions = array(
            'OR' => array('Customer.exit_date >=' => $currentDate, 'Customer.exit_date is NULL'),
            'CustomerCategory.convoyeur'=>1
        );

        if ($conds != null) {
            $conditions = array_merge($conditions, $conds);
        }
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }

        $customers = $this->find(
            $typeSelect,
            array(
                'fields' => $fields,
                'conditions' => $conditions,
                'recursive' => -1,
                'order' => array(
                    'Customer.code' => 'ASC',
                    'TRIM(Customer.first_name)' => 'ASC',
                    'Customer.last_name' => 'ASC',
                    'Customer.company' => 'ASC'
                ),
                'joins'=>array(
                    array(
                        'table' => 'customer_categories',
                        'type' => 'left',
                        'alias' => 'CustomerCategory',
                        'conditions' => array('Customer.customer_category_id = CustomerCategory.id')
                    )

                )

            ));
        return $customers;
    }

    /**
     * Get customer by foreign key
     *
     * @param int $id
     * @param string $modelField
     *
     * @return array $customer
     */
    public function getCustomerByForeignKey($id, $modelField)
    {
        $customer = $this->find(
            'first',
            array(
                'conditions'=>array($modelField => $id),
                'fields' => array('Customer.id'),
                'recursive'=>-1
            ));
        return $customer;
    }

    public function setLastDateMission($customerId, $endDate, $realEndDate, $startDate, $realStartDate){

        $lastDateMission = null;
        if(!empty($realEndDate)){
            $lastDateMission = $realEndDate;
        }else {
            if(!empty($endDate)){
                $lastDateMission = $endDate;
            }else {
               if(!empty($realStartDate)) {
                   $lastDateMission = $realStartDate;
               }else {
                   if(!empty($startDate)){
                       $lastDateMission = $startDate;
                   }
               }
            }
        }
        if(!empty($lastDateMission)){
            $this->id = $customerId;
            $this->saveField('last_mission_date', $lastDateMission);
        }

    }

    /**
     * @param null $customerId
     * @param null $amount
     * @param null $balanceConductor
     *
     */
    public function updateBalanceConductor($customerId = null, $amount = null, $balanceConductor = null)
    {
        $customer = $this->find('first', array(
            'conditions' => array('Customer.id' => $customerId),
            'recursive' => -1,
            'fields' => array('Customer.id', 'Customer.balance')
        ));
        $existBalance = $customer['Customer']['balance'];
        $newBalance = $existBalance - $balanceConductor + $amount;
        $this->id = $customerId;
        $this->saveField('balance', $newBalance);


    }
    public function getThirdPartyIdByCustomerId($customerId = null){
        $customer = $this->find('first', array(
            'conditions' => array('Customer.id' => $customerId),
            'recursive' => -1,
            'fields' => array('Customer.id', 'Customer.third_party_id')
        ));
        $thirdPartyId = $customer['Customer']['third_party_id'];
        return $thirdPartyId;
    }

}
