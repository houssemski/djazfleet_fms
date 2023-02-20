<?php

App::uses('AppModel', 'Model');

/**
 * Car Model
 *
 * @property CarStatus $CarStatus
 * @property Mark $Mark
 * @property CarType $CarType
 * @property User $User
 * @property CarCategory $CarCategory
 * @property Fuel $Fuel
 * @property Customer $Customer
 * @property Carmodel $Carmodel
 * @property CustomerCar $CustomerCar
 * @property Event $Event
 */
class Car extends AppModel
{

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'car';
//public $virtualFields = array('cnames' => 'CONCAT(Carmodel.name, " ", Car.code)');
    /**
     * Validation rules
     *
     * @var array
     */

    public $validate = array(
        /* 'code' => array(
              'notEmpty' => array(
                  'rule' => array('notEmpty'),
                  //'message' => 'Your custom message here',
                 // 'allowEmpty' => true,
                 // 'required' => true,
                  //'last' => false, // Stop validation after this rule
                  //'on' => 'create', // Limit validation to 'create' or 'update' operations
              ),


                'code' => array(
              'unique' => array(
                  'rule' => 'isUnique',
                  'allowEmpty' => true,
                  'required' => false,
                  'last' => true, // Stop validation after this rule
              ),
          ),
          ),*/
        'code' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
            ),
        ),
        'carmodel_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            ),
        ),
        'car_status_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            ),
        ),
        'mark_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            ),
        ),
        'car_type_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            ),
        ),
        'user_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            ),
        ),
        'car_category_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            ),
        ),
        'fuel_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            ),
        ),
        'immatr_def' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
            ),
        )
    );
    public $validateRemorque = array(
        /* 'code' => array(
              'notEmpty' => array(
                  'rule' => array('notEmpty'),
                  //'message' => 'Your custom message here',
                 // 'allowEmpty' => true,
                 // 'required' => true,
                  //'last' => false, // Stop validation after this rule
                  //'on' => 'create', // Limit validation to 'create' or 'update' operations
              ),


                'code' => array(
              'unique' => array(
                  'rule' => 'isUnique',
                  'allowEmpty' => true,
                  'required' => false,
                  'last' => true, // Stop validation after this rule
              ),
          ),
          ),*/
        'code' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
            ),
        ),
        'carmodel_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            ),
        ),
        'car_status_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            ),
        ),
        'mark_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            ),
        ),
        'car_type_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            ),
        ),
        'user_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            ),
        ),
        'car_category_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
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
        'CarStatus' => array(
            'className' => 'CarStatus',
            'foreignKey' => 'car_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Mark' => array(
            'className' => 'Mark',
            'foreignKey' => 'mark_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Carmodel' => array(
            'className' => 'Carmodel',
            'foreignKey' => 'carmodel_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'AcquisitionType' => array(
            'className' => 'AcquisitionType',
            'foreignKey' => 'acquisition_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'CarType' => array(
            'className' => 'CarType',
            'foreignKey' => 'car_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
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
        'CarCategory' => array(
            'className' => 'CarCategory',
            'foreignKey' => 'car_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'CarGroup' => array(
            'className' => 'CarGroup',
            'foreignKey' => 'car_group_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Fuel' => array(
            'className' => 'Fuel',
            'foreignKey' => 'fuel_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Supplier' => array(
            'className' => 'Supplier',
            'foreignKey' => 'supplier_id',
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
        'Department' => array(
            'className' => 'Department',
            'foreignKey' => 'department_id',
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
            'foreignKey' => 'car_id',
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
        'Event' => array(
            'className' => 'Event',
            'foreignKey' => 'car_id',
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
        'SheetRide' => array(
            'className' => 'SheetRide',
            'foreignKey' => 'car_id',
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
        'Customer' => array(
            'className' => 'Customer',
            'joinTable' => 'customer_car',
            'foreignKey' => 'car_id',
            'associationForeignKey' => 'customer_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        )
    );

    public function getTotals($conditions)
    {

        $cond = '';

        $i = 0;
        $j = 0;
        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $notEmpty = !empty($cond);
                if ($key == 'Car.parc_id' ){
                    if ($notEmpty){
                        $cond .= ' && ( ';
                    }else{
                        $cond .= '(';
                    }
                    foreach ( $value as $parcId){
                        if ($j == 0 && ( $j <= count($value) -1)){
                            $cond .= "Car.parc_id = {$parcId} ";
                        }elseif ($j <=  count($value) -1 ){
                            $cond .= " or Car.parc_id = {$parcId} ";
                        }
                        $j++;
                    }
                    $cond .= ')';
                }else{
                    if ($notEmpty){
                        $cond .= " && $key = $value ";
                    }else{
                        $cond .= " $key = $value ";
                    }
                }

                $i++;
            };
        }
        $query = "SELECT count(*) as total, car_status_id, CarStatus.name "
            . "FROM car AS Car "
            . "LEFT JOIN car_statuses AS CarStatus ON Car.car_status_id = CarStatus.id ";
        if ($cond != '') {
            $query .= "Where" . $cond;
        };
        $query .= "Group By car_status_id";


        return $this->query($query);

        /* $total=$this->find('count',
                                 array('recursive' => -1,
                                       'conditions'=>$conditions,
                                       'fields' =>array('Car.car_status_id','CarStatus.name','Car.parc_id'),
                                        'joins' => array(
                                                 array(
                                                     'table' => 'car_statuses',
                                                     'type' => 'left',
                                                     'alias' => 'CarStatus',
                                                     'conditions' => array('Car.car_status_id = CarStatus.id')
                                                      )),
                                         'order'=>'Car.car_status_id',
                                         'group'=>'car_status'
                                       )
                                 );*/


    }

    public function getSearchTotals($conditions)
    {

        $cond = '';

        $i = 0;
        $j = 0;
        $k = 0;
        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $notEmpty = !empty($cond);
                if ($key == 'Car.parc_id' ){
                    if ($notEmpty){
                        $cond .= ' && ( ';
                    }else{
                        $cond .= ' (';
                    }
                    foreach ( $value as $parcId){
                        if ($k == 0 && ( $k <= count($value) -1)){
                            $cond .= "Car.parc_id = {$parcId} ";
                        }elseif ($j <=  count($value) -1 ){
                            $cond .= " or Car.parc_id = {$parcId} ";
                        }
                        $k++;
                    }
                    $cond .= ')';
                }elseif ($key == 'Car.created >= ' || $key == 'Car.created <= ' || $key == 'Car.modified >= '
                || $key == 'Car.modified <= ') {
                    if ($notEmpty){
                        $cond .= " && {$key} '{$value}' ";
                    }else{
                        $cond .= " {$key} '{$value}' ";
                    }
                } elseif ($key == 'OR'){
                    if ($notEmpty){
                        $cond .= ' && ( ';
                    }else{
                        $cond .= ' (';
                    }
                    foreach ( $value as $key2 => $value2){
                        if ($j == 0 && ( $j <= count($value) -1)){
                            $cond .= "({$key2}  '{$value2}') ";
                        }elseif ($j <=  count($value) -1 ){
                            $cond .= " or ({$key2}  '{$value2}') ";
                        }
                        $j++;
                    }
                    $cond .= ')';
                } else{
                    if (!empty($key) && !empty($value)){
                        if ($notEmpty){
                            $cond .= " && $key  $value ";
                        }else{
                            $cond .= " $key  $value ";
                        }
                    }
                }

                $i++;
            };
        }
        $query = "SELECT count(*) as total, car_status_id, CarStatus.name "
            . "FROM car AS Car "
            . "LEFT JOIN car_statuses AS CarStatus ON Car.car_status_id = CarStatus.id "
            . "LEFT JOIN carmodels AS Carmodel ON Car.carmodel_id = Carmodel.id "
            . "LEFT JOIN marks AS Mark ON Car.mark_id = Mark.id "
            . "LEFT JOIN car_categories AS CarCategory ON Car.car_category_id = CarCategory.id "
            . "LEFT JOIN car_types AS CarType ON Car.car_type_id = CarType.id "
            . "LEFT JOIN fuels AS Fuel ON Car.fuel_id = Fuel.id "
            . "LEFT JOIN users AS User ON Car.user_id = User.id ";
        if ($cond != '') {
            $query .= " Where" . $cond;
        };
        $query .= "Group By car_status_id";

        return $this->query($query);

        /* $total=$this->find('count',
                                 array('recursive' => -1,
                                       'conditions'=>$conditions,
                                       'fields' =>array('Car.car_status_id','CarStatus.name','Car.parc_id'),
                                        'joins' => array(
                                                 array(
                                                     'table' => 'car_statuses',
                                                     'type' => 'left',
                                                     'alias' => 'CarStatus',
                                                     'conditions' => array('Car.car_status_id = CarStatus.id')
                                                      )),
                                         'order'=>'Car.car_status_id',
                                         'group'=>'car_status'
                                       )
                                 );*/


    }

    public function getKmContractAlerts($limiteKmContract)
    {


        $query = "select Car.id, Car.code, Mark.name, Carmodel.name,  Leasing.reception_date,  Leasing.end_date, Leasing.acquisition_type_id, Leasing.send_mail, "
            . " Leasing.km_year, Car.km, ((Leasing.km_year* (FLOOR(TIMESTAMPDIFF(DAY , Leasing.reception_date, Leasing.end_date)/30)/12))-(Car.km -Leasing.reception_km)) as km_rest "
            . "FROM car as Car "

            . "LEFT JOIN carmodels as Carmodel ON Car.carmodel_id = Carmodel.id "

            . "LEFT JOIN marks as Mark ON Car.mark_id = Mark.id "
            . "LEFT JOIN leasings as Leasing ON Leasing.car_id = Car.id "

            . "WHERE (Leasing.acquisition_type_id = 2 or Leasing.acquisition_type_id = 3) &&  Leasing.reception_date<=CURDATE() && Leasing.end_date>=CURDATE()"
            . " having km_rest <= " . $limiteKmContract;


        return $this->query($query);


    }


    public function getDateContractAlerts ($limitedDate){
        $dateContracts = $this->find('all', array(
                'conditions' => array(
                    'Leasing.end_date <= ' => $limitedDate,
                    'Leasing.alert_date != ' => 2
                ),
                'recursive' => -1,
                'fields' => array(
                    'Car.code',
                    'Leasing.end_date',
                    'Leasing.alert_date',
                    'Carmodel.name',
                    'Car.id',
                    'Leasing.send_mail_date',

                ),
                'joins' => array(
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
        return $dateContracts;
    }


    public function getAmortissementAlerts($limitedKm, $carId)
    {

        $query = "select Car.id, Car.code, Car.carmodel_id, Car.km, Carmodel.name, Car.amortization_km "
            . "FROM car AS Car "

            . "LEFT JOIN carmodels AS Carmodel ON (Car.carmodel_id = Carmodel.id) "

            . "WHERE Car.amortization_km <= " . (int)$limitedKm . " + Car.km AND Car.alert_amortization != 2 ";

        if ($carId != null) {
            $query .= " Car.id = " . (int)$carId;
        }

        return $this->query($query);

    }

    /**
     * Get not null car's codes
     *
     * @return array|null $carCodes
     */
    public function getNotNullCodes()
    {
        $carCodes = $this->find(
            'all',
            array(
                'conditions' => array('code !=' => null),
                'recursive' => -1,
                'fields' => array('code')
            )
        );
        return $carCodes;
    }

    public function getAllOpenedCars()
    {
        $cars = $this->find('all', array(
            'recursive' => -1,
            'conditions' => array('is_open' => 1),
            'fields' => array('id')
        ));
        return $cars;
    }

    /**
     * Get cars by conditions
     *
     * @param int $structureOfCarName
     * @param array $condition
     *
     * @return array $cars
     */
    public function getCarsByCondition($structureOfCarName, $condition)
    {
        if ($structureOfCarName == 1) {
            $this->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($structureOfCarName == 2) {

            $this->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }

        $cars = $this->find('list', array(
            'fields' => 'cnames',
            'recursive' => -1,
            'order' => 'Carmodel.name asc',
            'conditions' => $condition,
            'joins' => array(
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                )
            )
        ));

        return $cars;
    }

    /**
     * Get cars by fields and conditions
     *
     * @param int|null $structureOfCarName
     * @param array|null $fields
     * @param array|null $conds
     * @param string|null $typeSelect
     *
     * @return array $cars
     */
    public function getCarsByFieldsAndConds(
        $structureOfCarName = null,
        $fields = null,
        $conds = null,
        $typeSelect = null
    ) {
        if ($structureOfCarName == 1) {
            $this->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' / ', IFNULL(Carmodel.name,'Sans model'))"
            );
        } elseif ($structureOfCarName == 2) {

            $this->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' / ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($fields)) {
            $fields = "cnames";
        }

        $cars = $this->find(
            $typeSelect,
            array(
                'fields' => $fields,
                'recursive' => -1,
                'joins' => array(
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    )
                ),
                'conditions' => $conds,
                'order' => array(
                    'Car.code' => 'ASC',
                    'Carmodel.name' => 'ASC'
                )

            ));
        return $cars;
    }

    /**
     * Get car by id
     *
     * @param int $carId
     * @param array|null $fields
     *
     * @return array $car
     */
    public function getCarById($carId, $fields = null)
    {
        $car = $this->find(
            'first',
            array(
                'fields' => $fields,
                'conditions' => array('Car.id' => $carId),
                'recursive'=>-1
            ));
        return $car;
    }

    /**
     * Get car by car type
     *
     * @param int $carTypeId
     *
     * @return array $cars
     */
    public function getCarByCarType($carTypeId)
    {
        $cars = $this->find(
            'all',
            array(
                'conditions' => array('Car.car_type_id' => $carTypeId),
                'fields' => array('Car.average_speed'),
                'recursive' => -1
            ));
        return $cars;
    }

    /**
     * Get car by foreign key
     *
     * @param int $id
     * @param string $modelField
     *
     * @return array $car
     */
    public function getCarByForeignKey($id, $modelField)
    {
        $car = $this->find(
            'first',
            array(
                'conditions' => array($modelField => $id),
                'fields' => array('Car.id'),
                'recursive' => -1
            ));
        return $car;
    }

    /**
     * Get average speed by car type
     *
     * @param int $carTypeId
     *
     * @return int|null $averageSpeed
     */
    public function getAverageSpeedByCarType($carTypeId)
    {
        $cars = $this->getCarByCarType($carTypeId);
        $sumAverageSpeed = 0;
        $nbCars = 0;
        if (!empty($cars)) {
            foreach ($cars as $car) {
                if (!empty($car['Car']['average_speed'])) {
                    $sumAverageSpeed = $sumAverageSpeed + $car['Car']['average_speed'];
                    $nbCars++;
                }
            }
        }

        if ($nbCars > 0) {
            $averageSpeed = $sumAverageSpeed / $nbCars;
        } else {
            $averageSpeed = null;
        }

        return $averageSpeed;
    }

    public function getFuelIdOfCar($carId = null){
        $car = $this->find('first', array(
                'conditions'=>array('Car.id'=>$carId),
                'recursive'=>-1,
                'fields'=>array('Car.fuel_id')));
        $fuelId = isset($car['Car']) && isset($car['Car']['fuel_id']) ? $car['Car']['fuel_id'] : null;
         return $fuelId;
    }

}
