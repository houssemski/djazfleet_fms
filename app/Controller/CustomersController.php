<?php

App::uses('AppController', 'Controller');

/**
 * Customers Controller
 *
 * @property Customer $Customer
 * @property Parc $Parc
 * @property Profile $Profile
 * @property CustomerCategory $CustomerCategory
 * @property Zone $Zone
 * @property Affiliate $Affiliate
 * @property Nationality $Nationality
 * @property CustomerGroup $CustomerGroup
 * @property Department $Department
 * @property Service $Service
 * @property Consumption $Consumption
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class CustomersController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session','RequestHandler');
    public $uses = array(
        'Customer',
        'CustomerCategory',
        'Zone',
        'CustomerGroup',
        'Department',
        'Parc',
        'Service',
        'Profile',
        'Affiliate',
        'Nationality',
        'Consumption',
        'Company',
		'Warning',
		'Absence'
    );

    public function blackhole($type)
    {
    }

    public function getOrder($params = null, $orderType = null)
    {

        if($orderType == null){
            $orderType = 'DESC';
        }
        if (isset($params) && is_numeric($params)) {
            switch ($params) {
                case 1 :
                    $order = array('Customer.reference' => $orderType);
                    break;
                case 2 :
                    $order = array('Customer.id' => $orderType);
                    break;
                case 3 :
                    $order = array('Customer.last_mission_date' => $orderType);
                    break;
                default :
                    $order = array('Customer.reference' => $orderType);
            }

            return $order;
        } else {
            $order = array('Customer.reference' => $orderType);
            return $order;
        }

    }


    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $userId = intval($this->Auth->user('id'));
        $parcIds = $this->getParcsUserIdsArray($userId);
        $result = $this->verifyUserPermission(SectionsEnum::employe, $userId, ActionsEnum::view, "Customers", null,
            "Customer", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();
        if (!$this->verifyUserParcPermission(SectionsEnum::employe)) {
            switch ($result) {
                case 1 :
                    $conditions = array('Customer.parc_id' => $parcIds);
                    break;
                case 2 :
                    $conditions = array('Customer.user_id' => $userId, 'Customer.parc_id' => $parcIds);
                    break;
                case 3 :
                    $conditions = array('Customer.user_id !=' => $userId, 'Customer.parc_id' => $parcIds);
                    break;
                default:
                    $conditions = array('Customer.parc_id' => $parcIds);
            }


        } else {
            switch ($result) {
                case 1 :
                    $conditions = null;
                    break;
                case 2 :
                    $conditions = array('Customer.user_id' => $userId);
                    break;
                case 3 :
                    $conditions = array('Customer.user_id !=' => $userId);
                    break;
                default:
                    $conditions = null;
            }
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => 'Customer.id DESC',
            'conditions' => $conditions,
            'paramType' => 'querystring'
        );

        $this->Customer->recursive = 0;
        $this->set('customers', $this->Paginator->paginate('Customer'));
        $users = $this->User->getUsers();
        $profiles = $this->Profile->getUserProfiles();
        if (!empty($parcIds)) {
            $parcs = $this->Parc->getParcByIds($parcIds);
        } else {
            $parcs = $this->Parc->getParcs('list');
        }
        $nb_parcs = count($parcIds);
        $customerGroups = $this->CustomerGroup->getCustomerGroups();


        $customerCategories = $this->CustomerCategory->getCustomerCategories();

        $totals = $this->Customer->getTotals($conditions);
        $hasParc = $this->verifyUserParcPermission(SectionsEnum::employe);
        $isSuperAdmin = $this->isSuperAdmin();

        $this->set(compact('profiles', 'customerCategories', 'users', 'limit', 'totals', 'hasParc', 'parcs',
            'customerGroups', 'conditions', 'nb_parcs', 'isSuperAdmin','order'));
    }

    public function permisalert()
    {
        $driverLicenseExpParam = $this->Parameter->getParamValByCode(ParametersEnum::expiration_permis, array('val'));
        $driverLicenseLimitValue = date(
            'Y-m-d H:i:s',
            strtotime('+' . $driverLicenseExpParam['Parameter']['val'] . ' days')
        );
        $permiscustomers = $this->Customer->getCustomerWithDriverLicenseExpireDate($driverLicenseLimitValue);
        $hasParc = $this->verifyUserParcPermission(SectionsEnum::employe);
        $this->set('customers', $permiscustomers);
        $users = $this->User->getUsers();
        $parcs = $this->Parc->getParcs('list');
        $customerCategories = $this->CustomerCategory->getCustomerCategories();
        $this->set(compact('customerCategories', 'users', 'hasParc', 'parcs'));
    }

    public function disablepermisalert($id = null)
    {

        if (!$this->Customer->exists($id)) {
            throw new NotFoundException(__('Invalid customer'));
        }
        $customer = $this->Customer->find('all', array(
            'conditions' => array(
                "Customer.id" => $id
            )
        ));


        if (!empty($customer)) {
            $this->Customer->id = $id;
            $this->Customer->saveField('alert', 2);
            $this->setSessionDriversLicenseAlerts($id);
            $this->getTotalNbAlerts();
        }


        $this->Flash->success(__('The alert has been disabled.'));
        $this->redirect(array('action' => 'view', $id));
    }

    public function search()
    {
        $this->setTimeActif();
        if (isset($this->request->data['keyword']) || isset($this->request->data['Customers']['user_id'])
            || isset($this->request->data['Customers']['driver_license_category'])
            || isset($this->request->data['Customers']['customer_category_id']) || isset($this->request->data['Customers']['modified_id'])
            || isset($this->request->data['Customers']['created']) || isset($this->request->data['Customers']['created1'])
            || isset($this->request->data['Customers']['modified']) || isset($this->request->data['Customers']['modified1'])
            || isset($this->request->data['Customers']['profile_id'])
            || isset($this->request->data['Customers']['parc_id']) || isset($this->request->data['Customers']['customer_group_id'])
            || isset($this->request->data['conditions'])
        ) {
            $this->filterUrl();
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();

        if (isset($this->params['named']['keyword']) || isset($this->params['named']['user']) || isset($this->params['named']['driver_license'])
            || isset($this->params['named']['category']) || isset($this->params['named']['created']) || isset($this->params['named']['created1'])
            || isset($this->params['named']['parc']) || isset($this->params['named']['modified_id']) || isset($this->params['named']['customerGroup'])
            || isset($this->params['named']['modified']) || isset($this->params['named']['modified1']) || isset($this->params['named']['ids'])
            || isset($this->params['named']['conditions']) || isset($this->params['named']['profile'])
        ) {

            $conditions = $this->getConds();


            $conditions_index = unserialize(base64_decode($this->params['named']['conditions']));

            if ($conditions_index != null) {
                $conditions = array_merge($conditions, $conditions_index);
            }

            //$this->set('customers', $this->Paginator->paginate('Customer', array('conditions'=>$conditions)));

            $this->paginate = array(
                'limit' => $limit,
                'conditions' => $conditions,
                'order' => $order,
                'paramType' => 'querystring'
            );

            $this->Customer->recursive = 1;
            $customers = $this->Paginator->paginate('Customer');
            $this->set('customers', $customers);

        } else {
            $this->Customer->recursive = 0;
            $this->set('customers', $this->Paginator->paginate('Customer'));
        }
        $users = $this->User->getUsers();
        $profiles = $this->Profile->getUserProfiles();
        $userId = intval($this->Auth->user('id'));
        $parcIds = $this->getParcsUserIdsArray($userId);
        if (!empty($parcIds)) {
            $parcs = $this->Parc->getParcByIds($parcIds);
        } else {
            $parcs = $this->Parc->getParcs('list');
        }
        $nb_parcs = count($parcIds);
        $customerGroups = $this->CustomerGroup->getCustomerGroups();
        $customerCategories = $this->CustomerCategory->getCustomerCategories();
        $hasParc = $this->verifyUserParcPermission(SectionsEnum::employe);
        $isSuperAdmin = $this->isSuperAdmin();
        $this->set(compact('profiles', 'customerCategories', 'users', 'limit', 'hasParc', 'parcs', 'customerGroups',
            'conditions_index', 'nb_parcs', 'isSuperAdmin','order'));
        $this->render();
    }

    private function filterUrl()
    {
        $filter_url['controller'] = $this->request->params['controller'];
        $filter_url['action'] = $this->request->params['action'];
        $filter_url['page'] = 1;
        $filter_url['keyword'] = $this->request->data['keyword'];
        $filter_url['conditions'] = $this->request->data['conditions'];
        if (isset($this->request->data['Customers']['customer_category_id']) && !empty($this->request->data['Customers']['customer_category_id'])) {
            $filter_url['category'] = $this->request->data['Customers']['customer_category_id'];
        }
        if (isset($this->request->data['Customers']['driver_license_category']) && !empty($this->request->data['Customers']['driver_license_category'])) {
            $filter_url['driver_license'] = $this->request->data['Customers']['driver_license_category'];
        }
        if (isset($this->request->data['Customers']['parc_id']) && !empty($this->request->data['Customers']['parc_id'])) {
            $filter_url['parc'] = $this->request->data['Customers']['parc_id'];
        }
        if (isset($this->request->data['Customers']['customer_group_id']) && !empty($this->request->data['Customers']['customer_group_id'])) {
            $filter_url['customer_group'] = $this->request->data['Customers']['customer_group_id'];
        }
        if (isset($this->request->data['Customers']['profile_id']) && !empty($this->request->data['Customers']['profile_id'])) {
            $filter_url['profile'] = $this->request->data['Customers']['profile_id'];
        }
        if (isset($this->request->data['Customers']['user_id']) && !empty($this->request->data['Customers']['user_id'])) {
            $filter_url['user'] = $this->request->data['Customers']['user_id'];
        }
        if (isset($this->request->data['Customers']['created']) && !empty($this->request->data['Customers']['created'])) {
            $filter_url['created'] = str_replace("/", "-", $this->request->data['Customers']['created']);
        }
        if (isset($this->request->data['Customers']['created1']) && !empty($this->request->data['Customers']['created1'])) {
            $filter_url['created1'] = str_replace("/", "-", $this->request->data['Customers']['created1']);
        }
        if (isset($this->request->data['Customers']['modified_id']) && !empty($this->request->data['Customers']['modified_id'])) {
            $filter_url['modified_id'] = $this->request->data['Customers']['modified_id'];
        }
        if (isset($this->request->data['Customers']['modified']) && !empty($this->request->data['Customers']['modified'])) {
            $filter_url['modified'] = str_replace("/", "-", $this->request->data['Customers']['modified']);
        }
        if (isset($this->request->data['Customers']['modified1']) && !empty($this->request->data['Customers']['modified1'])) {
            $filter_url['modified1'] = str_replace("/", "-", $this->request->data['Customers']['modified1']);
        }

        return $this->redirect($filter_url);
    }

    private function getConds()
    {
        if (!empty($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));

            $keywords = explode(' ', $keyword);

            $conds = null;
            foreach ($keywords as $keyword) {
                $condKeywords = array(
                    'OR' => array(
                        "LOWER(Customer.code) LIKE" => "%$keyword%",
                        "LOWER(Customer.company) LIKE" => "%$keyword%",
                        "LOWER(Customer.first_name) LIKE" => "%$keyword%",
                        "LOWER(Customer.last_name) LIKE" => "%$keyword%"
                    )
                );

                $conds = array('OR' => array($conds, $condKeywords));
            }

        } else {
            $conds = array();
        }
        if (isset($this->params['named']['ids'])) {
            if ($this->params['named']['ids'] === 0) {
                $conds["Customer.id = "] = 0;
            } else {
                $conds["Customer.id "] = $this->params['named']['ids'];
            }
        }
        if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
            $conds["CustomerCategory.id = "] = $this->params['named']['category'];
            $this->request->data['Customers']['customer_category_id'] = $this->params['named']['category'];
        }
        if (isset($this->params['named']['driver_license']) && !empty($this->params['named']['driver_license'])) {
            $driver_license = $this->params['named']['driver_license'];
            $conds = array("LOWER(Customer.driver_license_category) LIKE" => "%$driver_license%");
            //$conds["Customer.driver_license_category = "] = $this->params['named']['driver_license'];
            $this->request->data['Customers']['driver_license_category'] = $this->params['named']['driver_license'];
        }
        if (isset($this->params['named']['parc']) && !empty($this->params['named']['parc'])) {
            $conds["Parc.id = "] = $this->params['named']['parc'];
            $this->request->data['Customers']['parc_id'] = $this->params['named']['parc'];
        }
        if (isset($this->params['named']['customerGroup']) && !empty($this->params['named']['customerGroup'])) {
            $conds["customer_group.id = "] = $this->params['named']['customerGroup'];
            $this->request->data['Customers']['customer_group_id'] = $this->params['named']['customerGroup'];
        }
        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $conds["User.id = "] = $this->params['named']['user'];
            $this->request->data['Customers']['user_id'] = $this->params['named']['user'];
        }
        if (isset($this->params['named']['profile']) && !empty($this->params['named']['profile'])) {
            $conds["User.profile_id = "] = $this->params['named']['profile'];
            $this->request->data['Customers']['profile_id'] = $this->params['named']['profile'];
        }
        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $creat = str_replace("-", "/", $this->params['named']['created']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Customer.created >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Customers']['created'] = $creat;
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $creat = str_replace("-", "/", $this->params['named']['created1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Customer.created <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Customers']['created1'] = $creat;
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $conds["Customer.modified_id = "] = $this->params['named']['modified_id'];
            $this->request->data['Customers']['modified_id'] = $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Customer.modified >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Customers']['modified'] = $creat;
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Customer.modified <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Customers']['modified1'] = $creat;
        }
        return $conds;
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null)
    {
        $this->setTimeActif();
        if (!$this->Customer->exists($id)) {
            throw new NotFoundException(__('Invalid customer'));
        }
        $options = array('conditions' => array('Customer.' . $this->Customer->primaryKey => $id));
        $this->set('customer', $this->Customer->find('first', $options));


        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => 10,
            'order' => array('CustomerCar.id' => 'DESC'),
            'fields' => array(
                'CustomerCar.id',
                'start',
                'end',
                'Car.code',
                'Car.immatr_def',
                'Carmodel.name'

            ),
            'joins' => array(
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('CustomerCar.car_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                )
            ),
            'conditions' => array('CustomerCar.customer_id' => $id)
        );

        $this->set('customerCars', $this->paginate('CustomerCar'));

        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => 10,
            'order' => array('SheetRide.id' => 'DESC'),

            'joins' => array(
                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('SheetRide.id = Consumption.sheet_ride_id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('SheetRide.customer_id = Customer.id')
                ),

            ),
            'conditions' => array('SheetRide.customer_id' => $id)
        );

        $this->set('consumptions', $this->paginate('Consumption'));
        //Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set('param', $param);

        $this->Audit->recursive = 2;
        $this->paginate = array(
            'recursive' => -1,
            'limit' => 5,
            'fields' => array(
                'User.id',
                'User.first_name',
                'User.last_name',
                'Audit.created'
            ),
            'joins' => array(
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'User',
                    'conditions' => array('Audit.user_id = User.id')
                )
            ),
            'conditions' => array('article_id' => $id, 'rubric_id' => 2),
            'paramType' => 'querystring',

        );


        $audits = $this->Paginator->paginate('Audit', "Audit.user_id != 1");

        $this->set('audits', $audits);


        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => 10,
            'order' => array('Event.id' => 'DESC'),
            'fields' => array(
                'Event.id',
                'date',
                'next_date',
                'Car.code',
                'Carmodel.name',
                'cost'
            ),
            'joins' => array(

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
                )

            ),
            'conditions' => array('Event.customer_id' => $id, 'EventEventType.event_type_id' => array(11, 13))
        );

        $this->set('incidents', $this->paginate('Event'));

        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => 10,
            'order' => array('Event.id' => 'DESC'),
            'fields' => array(
                'Event.id',
                'date',
                'place',
                'contravention_type_id',
                'driving_licence_withdrawal',
                'Car.code',
                'Carmodel.name',
                'cost'
            ),
            'joins' => array(

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
                )
            ),
            'conditions' => array('Event.customer_id' => $id, 'EventEventType.event_type_id' => array(12))
        );
        $contraventions = $this->paginate('Event');

        $this->set('contraventions', $contraventions);
		
		
		$this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => 10,
            'order' => array('Warning.id' => 'DESC'),
			'fields'=>array(
                'Customer.first_name',
                'Customer.last_name',
                'Warning.id',
                'WarningType.name',
                'Warning.start_date',
                'Warning.end_date',
                'Warning.code',
            ),
            'joins' => array(
                array(
                    'table' => 'warning_types',
                    'type' => 'left',
                    'alias' => 'WarningType',
                    'conditions' => array('WarningType.id = Warning.warning_type_id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Warning.customer_id = Customer.id')
                ),

            ),
            'conditions' => array('Warning.customer_id' => $id)
        );

        $this->set('warnings', $this->paginate('Warning'));	
		
		$this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => 10,
            'order' => array('Absence.id' => 'DESC'),
			'fields'=>array(
                'Customer.first_name',
                'Customer.last_name',
                'Absence.id',
                'AbsenceReason.name',
                'Absence.start_date',
                'Absence.end_date',
                'Absence.code',
            ),
            'joins' => array(
                array(
                    'table' => 'absence_reasons',
                    'type' => 'left',
                    'alias' => 'AbsenceReason',
                    'conditions' => array('AbsenceReason.id = Absence.absence_reason_id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Absence.customer_id = Customer.id')
                ),

            ),
            'conditions' => array('Absence.customer_id' => $id)
        );
        $this->set('absences', $this->paginate('Absence'));
		
		$currentYear=date("Y-m-d");
		
		$currentMonthSheetRides = $this->SheetRide->getSheetRidesOfCurrentMonth($id);
		$sumKmMonth = 0;
		$sumHourMonth = 0;
		foreach($currentMonthSheetRides as $currentMonthSheetRide){
			if(!empty($currentMonthSheetRide['sheet_rides']['km_departure'])&&
				!empty($currentMonthSheetRide['sheet_rides']['km_arrival'])
			) {
				$sumKmMonth = $sumKmMonth + ($currentMonthSheetRide['sheet_rides']['km_arrival']- $currentMonthSheetRide['sheet_rides']['km_departure']);
				}
				$datetime1 = new DateTime ($currentMonthSheetRide['sheet_rides']['real_start_date']);
                $datetime2 = new DateTime ($currentMonthSheetRide['sheet_rides']['real_end_date']);
                if(!empty($currentMonthSheetRide['sheet_rides']['real_start_date'])&&
				!empty($currentMonthSheetRide['sheet_rides']['real_end_date'])
			) {
				$interval = date_diff($datetime1, $datetime2);
                $total = $interval->y * 526600 + $interval->m * 43800 + $interval->d * 1440 + $interval->h * 60 + $interval->i;
                $sumHourMonth = $sumHourMonth + $total ;
			}	
		}
		$this->set(compact('sumKmMonth','sumHourMonth'));
		
		$currentYearSheetRides = $this->SheetRide->getSheetRidesOfCurrentYear($id);
		$sumKmYear = 0;
		$sumHourYear = 0;
		foreach($currentYearSheetRides as $currentYearSheetRide){
			if(!empty($currentYearSheetRide['sheet_rides']['km_departure'])&&
				!empty($currentYearSheetRide['sheet_rides']['km_arrival'])
			) {
				$sumKmYear = $sumKmYear + ($currentYearSheetRide['sheet_rides']['km_arrival']- $currentYearSheetRide['sheet_rides']['km_departure']);
				}
				$datetime1 = new DateTime ($currentYearSheetRide['sheet_rides']['real_start_date']);
                $datetime2 = new DateTime ($currentYearSheetRide['sheet_rides']['real_end_date']);
                if(!empty($currentYearSheetRide['sheet_rides']['real_start_date'])&&
				!empty($currentYearSheetRide['sheet_rides']['real_end_date'])
			) {
				$interval = date_diff($datetime1, $datetime2);
                $total = $interval->y * 526600 + $interval->m * 43800 + $interval->d * 1440 + $interval->h * 60 + $interval->i;
                $sumHourYear = $sumHourYear + $total ;
			}	
		}
		$this->set(compact('sumKmYear','sumHourYear'));
		
		$conductorSheetRides = $this->SheetRide->getSheetRidesOfConductor($id);
		$sumKmConductor = 0;
		$sumHourConductor = 0;
		foreach($conductorSheetRides as $conductorSheetRide){
			if(!empty($conductorSheetRide['sheet_rides']['km_departure'])&&
				!empty($conductorSheetRide['sheet_rides']['km_arrival'])
			) {
				$sumKmConductor = $sumKmConductor + ($conductorSheetRide['sheet_rides']['km_arrival']- $conductorSheetRide['sheet_rides']['km_departure']);
				}
				$datetime1 = new DateTime ($conductorSheetRide['sheet_rides']['real_start_date']);
                $datetime2 = new DateTime ($conductorSheetRide['sheet_rides']['real_end_date']);
                if(!empty($conductorSheetRide['sheet_rides']['real_start_date'])&&
				!empty($conductorSheetRide['sheet_rides']['real_end_date'])
			) {
				$interval = date_diff($datetime1, $datetime2);
                $total = $interval->y * 526600 + $interval->m * 43800 + $interval->d * 1440 + $interval->h * 60 + $interval->i;
                $sumHourConductor = $sumHourConductor + $total ;
			}	
		}
		$this->set(compact('sumKmConductor','sumHourConductor'));
		

        $hasPermission = $this->verifyAudit(SectionsEnum::client);
        $this->set(compact('hasPermission'));


    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        $this->setTimeActif();
        $userId = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::employe, $userId, ActionsEnum::add, "Customers", null, "Customer",
            null);

        $hidden_information = $this->Parameter->getFieldsToHide();
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {


            if (!$hidden_information['Parameter']['identity_card']) {
                $this->verifyAttachment('Customer', 'identity_card_scan1', 'img/identitycards/', 'add', 0, 0, null);
                $this->verifyAttachment('Customer', 'identity_card_scan2', 'img/identitycards/', 'add', 0, 0, null);
            }
            $this->verifyAttachment('Customer', 'driver_license_scan1', 'img/driverlicenses/', 'add', 0, 0, null);
            $this->verifyAttachment('Customer', 'driver_license_scan2', 'img/driverlicenses/', 'add', 0, 0, null);
            if (!$hidden_information['Parameter']['passport']) {
                $this->verifyAttachment('Customer', 'passport_scan', 'img/passports/', 'add', 0, 0, null);

            }
            $this->verifyAttachment('Customer', 'image', 'img/customers/', 'add', 1, 0, null);
            $this->verifyAttachment('Customer', 'chifa_card', 'img/chifaCards/', 'add', 1, 0, null);
            $this->Customer->create();


            $this->request->data['Customer']['user_id'] = $this->Session->read('Auth.User.id');


            $this->createDateFromDate('Customer', 'birthday');
            $this->createDateFromDate('Customer', 'identity_card_date');
            $this->createDateFromDate('Customer', 'driver_license_expires_date1');
            $this->createDateFromDate('Customer', 'driver_license_expires_date2');
            $this->createDateFromDate('Customer', 'driver_license_expires_date3');
            $this->createDateFromDate('Customer', 'driver_license_expires_date4');
            $this->createDateFromDate('Customer', 'driver_license_expires_date5');
            $this->createDateFromDate('Customer', 'driver_license_expires_date6');
            $this->createDateFromDate('Customer', 'driver_license_date');
            $this->createDateFromDate('Customer', 'passport_date');
            $this->createDateFromDate('Customer', 'entry_date');
            $this->createDateFromDate('Customer', 'declaration_date');
            $this->createDateFromDate('Customer', 'exit_date');
            $driver_license_category = '';
            if (!empty($this->request->data['Customer']['driver_license_category'])) {
                foreach ($this->request->data['Customer']['driver_license_category'] as $key => $value) {

                    $driver_license_category = $value . ',' . $driver_license_category;
                }

                $this->request->data['Customer']['driver_license_category'] = $driver_license_category;
            }

            if ($this->Customer->save($this->request->data)) {

                if (Configure::read("cafyb") == '1') {
                    $thirdPartyType= 0;
                    $name = $this->request->data['Customer']['first_name'].' '.$this->request->data['Customer']['last_name'];
                    $thirdPartyId = $this->Cafyb->addThirdParty($name,$thirdPartyType);
                    $this->Customer->id= $this->Customer->getInsertID();
                    $this->Customer->saveField('third_party_id', $thirdPartyId);
                }
                $this->Flash->success(__('The employee has been saved.'));
                $customerId = $this->Customer->getInsertID();
                $this->setSessionDriversLicenseAlerts($customerId);
                $this->getTotalNbAlerts();
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The employee could not be saved. Please, try again.'));
            }
        }
        $customerCategories = $this->CustomerCategory->getCustomerCategories();

        $departments = $this->Department->getDepartments();

        $nationalities = $this->Nationality->getNationalities();
        $zones = $this->Zone->getZones();
        $customerGroups = $this->CustomerGroup->getCustomerGroups();
        $userId = intval($this->Auth->user('id'));
        $parcIds = $this->getParcsUserIdsArray($userId);
        if (!empty($parcIds)) {
            $parcs = $this->Parc->getParcByIds($parcIds);
        } else {
            $parcs = $this->Parc->getParcs('list');
        }
        $affiliates = $this->Affiliate->getEmployeeAffiliates();
        $autocode = $this->getNextCode("Customer", 'conductor');


        $this->set(compact('customerCategories', 'nationalities', 'zones', 'departments', 'parcs', 'customerGroups',
            'autocode', 'affiliates', 'hidden_information'));
    }


    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null)
    {
        $this->setTimeActif();
        $userId = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::employe, $userId, ActionsEnum::edit, "Customers", $id, "Customer",
            null);

        $hidden_information = $this->Parameter->getFieldsToHide();
        if (!$this->Customer->exists($id)) {
            throw new NotFoundException(__('Invalid customer'));
        }
        $customer = $this->Customer->find('first',
            array('conditions' => array('Customer.' . $this->Customer->primaryKey => $id)));
        $driver_license_date = $customer['Customer']['driver_license_date'];
        $driver_license_expires_date1 = $customer['Customer']['driver_license_expires_date1'];
        $driver_license_expires_date2 = $customer['Customer']['driver_license_expires_date2'];
        $driver_license_expires_date3 = $customer['Customer']['driver_license_expires_date3'];
        $driver_license_expires_date4 = $customer['Customer']['driver_license_expires_date4'];
        $driver_license_expires_date5 = $customer['Customer']['driver_license_expires_date5'];
        $driver_license_expires_date6 = $customer['Customer']['driver_license_expires_date6'];
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->closeItemOpened('Customer', $id);
                $this->Flash->error(__('Changes were not saved.'));
                $this->redirect(array('action' => 'index'));
            }
            $driver_license_category = '';
            if (!empty($this->request->data['Customer']['driver_license_category'])) {
                foreach ($this->request->data['Customer']['driver_license_category'] as $key => $value) {

                    $driver_license_category = $value . ',' . $driver_license_category;
                }

                $this->request->data['Customer']['driver_license_category'] = $driver_license_category;
            }
            if (!$hidden_information['Parameter']['identity_card']) {
                if ($this->request->data['Customer']['identity1_file'] == '') {
                    $this->deleteAttachment('Customer', 'identity_card_scan1', 'img/identitycards/', $id);
                    $this->verifyAttachment('Customer', 'identity_card_scan1', 'img/identitycards/', 'add', 0, 0, $id);
                } else {
                    $this->verifyAttachment('Customer', 'identity_card_scan1', 'img/identitycards/', 'edit', 0, 0, $id);
                }
                if ($this->request->data['Customer']['identity2_file'] == '') {
                    $this->deleteAttachment('Customer', 'identity_card_scan2', 'img/identitycards/', $id);
                    $this->verifyAttachment('Customer', 'identity_card_scan2', 'img/identitycards/', 'add', 0, 0, $id);
                } else {
                    $this->verifyAttachment('Customer', 'identity_card_scan2', 'img/identitycards/', 'edit', 0, 0, $id);
                }

            }

            if ($this->request->data['Customer']['driver1_file'] == '') {
                $this->deleteAttachment('Customer', 'driver_license_scan1', 'img/driverlicenses/', $id);
                $this->verifyAttachment('Customer', 'driver_license_scan1', 'img/driverlicenses/', 'add', 0, 0, $id);
            } else {
                $this->verifyAttachment('Customer', 'driver_license_scan1', 'img/driverlicenses/', 'edit', 0, 0, $id);
            }

            if ($this->request->data['Customer']['driver2_file'] == '') {
                $this->deleteAttachment('Customer', 'driver_license_scan2', 'img/driverlicenses/', $id);
                $this->verifyAttachment('Customer', 'driver_license_scan2', 'img/driverlicenses/', 'add', 0, 0, $id);
            } else {
                $this->verifyAttachment('Customer', 'driver_license_scan2', 'img/driverlicenses/', 'edit', 0, 0, $id);
            }

            if (!$hidden_information['Parameter']['passport']) {
                if ($this->request->data['Customer']['passport_file'] == '') {
                    $this->deleteAttachment('Customer', 'passport_scan', 'img/passports/', $id);
                    $this->verifyAttachment('Customer', 'passport_scan', 'img/passports/', 'add', 0, 0, $id);
                } else {
                    $this->verifyAttachment('Customer', 'passport_scan', 'img/passports/', 'edit', 0, 0, $id);
                }

            }

                if (isset($this->request->data['Customer']['chifa_file']) && $this->request->data['Customer']['chifa_file'] == '') {
                    $this->deleteAttachment('Customer', 'chifa_card', 'img/chifaCards/', $id);
                    $this->verifyAttachment('Customer', 'chifa_card', 'img/chifaCards/', 'add', 0, 0, $id);
                } else {
                    $this->verifyAttachment('Customer', 'chifa_card', 'img/chifaCards/', 'edit', 0, 0, $id);
                }

            if ($this->request->data['Customer']['file'] == '') {
                $this->deleteAttachment('Customer', 'image', 'img/customers/', $id);
                $this->verifyAttachment('Customer', 'image', 'img/customers/', 'add', 1, 0, $id);
            } else {
                $this->verifyAttachment('Customer', 'image', 'img/customers/', 'edit', 1, 0, $id);
            }


            $this->createDateFromDate('Customer', 'birthday');
            $this->createDateFromDate('Customer', 'identity_card_date');
            $this->createDateFromDate('Customer', 'driver_license_date');
            $this->createDateFromDate('Customer', 'driver_license_expires_date1');
            $this->createDateFromDate('Customer', 'driver_license_expires_date2');
            $this->createDateFromDate('Customer', 'driver_license_expires_date3');
            $this->createDateFromDate('Customer', 'driver_license_expires_date4');
            $this->createDateFromDate('Customer', 'driver_license_expires_date5');
            $this->createDateFromDate('Customer', 'driver_license_expires_date6');
            $this->createDateFromDate('Customer', 'passport_date');
            $this->createDateFromDate('Customer', 'entry_date');
            $this->createDateFromDate('Customer', 'declaration_date');
            $this->createDateFromDate('Customer', 'exit_date');
            $this->closeItemOpened('Customer', $id);
            $this->request->data['Customer']['modified_id'] = $this->Session->read('Auth.User.id');
            if (($driver_license_date != $this->request->data['Customer']['driver_license_date']) ||
                ($driver_license_expires_date1 != $this->request->data['Customer']['driver_license_expires_date1']) ||
                ($driver_license_expires_date2 != $this->request->data['Customer']['driver_license_expires_date2']) ||
                ($driver_license_expires_date3 != $this->request->data['Customer']['driver_license_expires_date3']) ||
                ($driver_license_expires_date4 != $this->request->data['Customer']['driver_license_expires_date4']) ||
                ($driver_license_expires_date5 != $this->request->data['Customer']['driver_license_expires_date5']) ||
                ($driver_license_expires_date6 != $this->request->data['Customer']['driver_license_expires_date6'])
            ) {
                $this->request->data['Customer']['alert'] = 0;
                $this->request->data['Customer']['send_mail'] = 0;
            }
            if ($this->Customer->save($this->request->data)) {
                $this->saveUserAction(SectionsEnum::employe, $id, $this->Session->read('Auth.User.id'), ActionsEnum::edit);
                $this->Flash->success(__('The employee has been saved.'));
                $this->Alert->deleteAll(array('Alert.object_id' => $id), false);
                $this->setSessionDriversLicenseAlerts($id);
                $this->getTotalNbAlerts();
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The employee could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Customer.' . $this->Customer->primaryKey => $id));
            $this->request->data = $this->Customer->find('first', $options);
            $this->request->data['Customer']['driver_license_category'] = explode(",",
                $this->request->data['Customer']['driver_license_category']);

            if ($this->request->data['Customer']['locked'] == 1) {

                $this->Flash->error(__('You must first unlock the employee.'));

                $this->redirect(array('action' => 'index'));
            }
            $this->isOpenedByOtherUser("Customer", 'Customers', 'customer', $id);
        }

        $customerCategories = $this->CustomerCategory->getCustomerCategories();
        $departments = $this->Department->getDepartments();

        $nationalities = $this->Nationality->getNationalities();
        $zones = $this->Zone->getZones();
        $customerGroups = $this->CustomerGroup->getCustomerGroups();
        $userId = intval($this->Auth->user('id'));
        $parcIds = $this->getParcsUserIdsArray($userId);
        if (!empty($parcIds)) {
            $parcs = $this->Parc->getParcByIds($parcIds);
        } else {
            $parcs = $this->Parc->getParcs('list');
        }
        $affiliates = $this->Affiliate->getEmployeeAffiliates();
        $autocode = $this->getNextCode("Customer", 'conductor');
        $this->set(compact('customerCategories', 'nationalities', 'zones', 'departments',
            'parcs', 'customerGroups', 'autocode', 'affiliates', 'hidden_information', 'services'));
    }


    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null)
    {


        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::employe, $user_id, ActionsEnum::delete, "Customers", $id, "Customer",
            null);
        $this->Customer->id = $id;
        if (!$this->Customer->exists()) {
            throw new NotFoundException(__('Invalid customer'));
        }
        $this->verifyDependences($id);

        $this->request->allowMethod('post', 'delete');
        $current = $this->Customer->find("first", array("conditions" => array("Customer.id" => $id)));
        if ($current['Customer']['locked']) {

            $this->Flash->error(__('You must first unlock the employee.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Customer->delete()) {
            $this->saveUserAction(SectionsEnum::employe, $id, $this->Session->read('Auth.User.id'), ActionsEnum::delete);
            $this->setSessionDriversLicenseAlerts($id);
            $this->getTotalNbAlerts();
            $this->Flash->success(__('The employee has been deleted.'));
        } else {

            $this->Flash->error(__('The employee could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $this->loadModel('CustomerCar');
        $events = $this->Event->find('first', array("conditions" => array("Event.customer_id =" => $id)));
        if (!empty($events)) {

            $this->Flash->error(__('The employee could not be deleted. '
                . 'Please remove dependencies with events in advance .'));
            $this->redirect(array('action' => 'index'));
        }
        $reservations = $this->CustomerCar->find('first',
            array("conditions" => array("CustomerCar.customer_id =" => $id)));
        if (!empty($reservations)) {

            $this->Flash->error(__('The employee could not be deleted. '
                . 'Please remove dependencies with reservations in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        $results = $this->SheetRide->find('first', array("conditions" => array("SheetRide.customer_id =" => $id)));
        if (!empty($results)) {

            $this->Flash->error(__('The employee could not be deleted. '
                . 'Please remove dependencies with reservations in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        $this->loadModel('Alert');
        $alerts = $this->Alert->find('all', array(
            'conditions' => array('Alert.object_id' => $id),
            'recursive' => -1
        ));
        if (!empty($alerts)) {
            $this->Alert->deleteAll(array('Alert.object_id' => $id), false);
        }
    }

    public function deletecustomers()
    {

        $this->setTimeActif();
        $this->autoRender = false;
        // if ($this->isSuperAdmin()) {
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');

        $this->verifyUserPermission(SectionsEnum::employe, $user_id, ActionsEnum::delete, "Customers", $id, "Customer",
            null);
        $this->Customer->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        $current = $this->Customer->find("first", array("conditions" => array("Customer.id" => $id)));
        if (!$current['Customer']['locked']) {
            $this->Customer->id = $id;
            if ($this->Customer->delete()) {
                echo json_encode(array("response" => "true"));
            } else {
                echo json_encode(array("response" => "false"));
            }
        } else {
            echo json_encode(array("response" => "false"));
        }

        /* }else{
             echo json_encode(array("response" => "false"));
         }*/
    }

    function addcategory()
    {

        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::categorie_employee, $user_id, ActionsEnum::add, "CustomerCategories", null, "CustomerCategory", null, 1);
        $this->set('result', $result);
        $this->setTimeActif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->CustomerCategory->create();
            if ($this->CustomerCategory->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $category_id = $this->CustomerCategory->getLastInsertId();
                $this->set('category_id', $category_id);
            }
        }
    }

    function getCategories()
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        $categories = $this->CustomerCategory->getCustomerCategories('all');
        $this->set('selectbox', $categories);
        $this->set('selectedid', $this->params['pass']['0']);
    }

    function export()
    {
        $this->setTimeActif();

        if (isset($this->params['pass']['0']) && $this->params['pass']['0'] == "all_search" && (isset($this->params['named']['keyword']) || isset($this->params['named']['user']) || isset($this->params['named']['driver_license'])
                || isset($this->params['named']['category']) || isset($this->params['named']['created']) || isset($this->params['named']['created1'])
                || isset($this->params['named']['parc']) || isset($this->params['named']['modified_id']) || isset($this->params['named']['customerGroup'])
                || isset($this->params['named']['modified']) || isset($this->params['named']['modified1']))

        ) {

            $conditions = $this->getConds();
            $customers = $this->Customer->find('all', array(
                'conditions' => $conditions,
                'order' => 'Customer.code asc'
            ));


        } else {

            if (isset($this->params['pass']['0']) && $this->params['pass']['0'] == "all") {
                $customers = $this->Customer->find('all', array(
                    'order' => 'Customer.code asc'
                ));
            } else {
                $ids = filter_input(INPUT_POST, "chkids");
                $array_ids = explode(",", $ids);
                $customers = $this->Customer->find('all', array(
                    'conditions' => array(
                        "Customer.id" => $array_ids
                    ),
                    'order' => 'Customer.code asc'
                ));
            }

        }
        $this->set('models', $customers);
    }

    function lock()
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::employe, $user_id, ActionsEnum::lock, "Customers",
            $this->params['pass']['0'], "Customer", null);
        $result = $this->setLocked('Customer', $this->params['pass']['0'], 1);
        if ($result) {

            $this->Flash->success(__('The employee has been locked.'));
        } else {
            $this->Flash->error(__('The customer could not be locked.'));
        }

        $this->redirect(array('action' => 'index'));
    }

    function unlock()
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::employe, $user_id, ActionsEnum::lock, "Customers",
            $this->params['pass']['0'], "Customer", null);
        $result = $this->setLocked('Customer', $this->params['pass']['0'], 0);
        if ($result) {

            $this->Flash->success(__('The employee has been unlocked.'));
        } else {
            $this->Flash->error(__('The customer could not be unlocked.'));
        }

        $this->redirect(array('action' => 'index'));
    }

    function addZone()
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::zone_affectation, $user_id, ActionsEnum::add,
            "Zones", null, "Zone", null, 1);
        $this->set('result', $result);
        $this->setTimeActif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->Zone->create();
            if ($this->Zone->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $zone_id = $this->Zone->getLastInsertId();
                $this->set('zone_id', $zone_id);
            }
        }
    }

    function getZones()
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        $zones = $this->Zone->getZones('all');
        $this->set('selectbox', $zones);
        $this->set('selectedid', $this->params['pass']['0']);
    }

    function addCustomerGroup()
    {

        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::groupe_employe, $user_id, ActionsEnum::view, "CustomerGroups", null, "CustomerGroup", null, 1);
        $this->set('result', $result);
        $this->setTimeActif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->CustomerGroup->create();
            if ($this->CustomerGroup->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $customer_group_id = $this->CustomerGroup->getLastInsertId();
                $this->set('customer_group_id', $customer_group_id);
            }
        }
    }

    function getCustomerGroups()
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        $customerGroups = $this->CustomerGroup->find('all', array('recursive' => -1));
        $this->set('selectbox', $customerGroups);
        $this->set('selectedid', $this->params['pass']['0']);
    }


    function addParc()
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::parc_vehicule, $user_id, ActionsEnum::add, "Parcs", null,
            "Parc", null, 1);
        $this->set('result', $result);
        $this->setTimeActif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->Parc->create();
            if ($this->Parc->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $parc_id = $this->Parc->getLastInsertId();
                $this->set('parc_id', $parc_id);
            }
        }
    }

    function getParcs()
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        $parcs = $this->Parc->getParcs('all');
        $this->set('selectbox', $parcs);
        $this->set('selectedid', $this->params['pass']['0']);
    }


    function addAffiliate()
    {

        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::affiliation_employe, $user_id, ActionsEnum::add, "Affiliates", null, "Affiliate", null);
        $this->set('result', $result);
        $this->setTimeActif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->Affiliate->create();
            if ($this->Affiliate->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $affiliate_id = $this->Affiliate->getLastInsertId();
                $this->set('affiliate_id', $affiliate_id);
            }
        }
    }

    function getAffiliates()
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        $affiliates = $this->Affiliate->getAffiliates('all');
        $this->set('selectbox', $affiliates);
        $this->set('selectedid', $this->params['pass']['0']);
    }


    function addService()
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::service, $user_id, ActionsEnum::add,
            "Services", null, "Service", null);
        $this->set('result', $result);
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->request->data['Service']['department_id'] = $this->params['pass']['0'];
            $this->Service->create();
            if ($this->Service->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $service_id = $this->Service->getLastInsertId();
                $this->set('service_id', $service_id);
                $this->set('department_id', $this->params['pass']['0']);
            }
        }
    }

    function getServices($departmentId = null)
    {
        $this->layout = 'ajax';

        if (isset($this->params['pass']['0']) || $departmentId != null) {
            if ($departmentId == null) {
                $departmentId = $this->params['pass']['0'];
            }
            $this->layout = 'ajax';
            $services = $this->Service->find('all',
                array(
                    'conditions' => array(
                        'Service.department_id' => $departmentId
                    ),
                    'fields' => array('Service.id', 'Service.name'),
                    'recursive' => -1
                ));
            $this->set('selectbox', $services);
            if (isset($this->params['pass']['1'])) {
                $this->set('selectedid', $this->params['pass']['1']);
            }
        } else {
            $this->set('selectbox', null);
        }
    }


    function addDepartment()
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::departement, $user_id, ActionsEnum::add, "Departments", null, "Department", null, 1);
        $this->set('result', $result);
        $this->setTimeActif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->Department->create();

            if ($this->Department->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $department_id = $this->Department->getLastInsertId();

                $this->set('department_id', $department_id);
            }
        }
    }

    function getDepartments()
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        $departments = $this->Department->getDepartments('all');

        $this->set('selectbox', $departments);
        $this->set('selectedid', $this->params['pass']['0']);
    }

    function assign($ids = null)
    {
        $this->setTimeActif();
        $this->layout = 'popup';
        $array_ids = explode(",", $ids);

        if (!empty($this->request->data)) {
            $customers = $this->Customer->find('all', array(
                'conditions' => array(
                    "Customer.id" => $array_ids
                )

            ));
            $customer_group_id = $this->request->data['Customer']['customer_group_id'];

            $this->set('customer_group_id', $customer_group_id);
            if (!empty($customers)) {
                foreach ($customers as $customer) {

                    $this->Customer->id = $customer['Customer']['id'];
                    $this->Customer->saveField('customer_group_id', $customer_group_id);


                }
            }
            $this->redirect(array('action' => 'index'));
        }


        $customerGroups = $this->CustomerGroup->getCustomerGroups();
        $this->set(compact('customerGroups'));
    }


    public function import()
    {
        if (!empty($this->request->data['Customer']['file_csv']['tmp_name'])) {

            if (is_uploaded_file($this->request->data['Customer']['file_csv']['tmp_name'])) {
                $fichier = $this->request->data['Customer']['file_csv']['name'];
                $ext = substr(strtolower(strrchr($fichier, '.')), 1);
                if ($ext == 'csv') {
                    if ($fichier) {
                        $fp = fopen($this->request->data['Customer']['file_csv']['tmp_name'], "r");

                    } else {

                        echo('fichier introuvable');
                        exit();
                    }
                    $cpt = 0;
                    while (!feof($fp)) {

                        if ($cpt == 0){
                            $cpt++;
                            continue;
                        }

                        $ligne = fgets($fp, 4096);
                        if (count(explode(";", $ligne)) > 1) {
                            $liste = explode(";", $ligne);
                        } else {
                            $liste = explode(",", $ligne);
                        }
                        $liste[0] = (isset($liste[0])) ? $liste[0] : null;
                        $liste[1] = (isset($liste[1])) ? $liste[1] : null;
                        $liste[2] = (isset($liste[2])) ? $liste[2] : null;
                        $liste[3] = (isset($liste[3])) ? $liste[3] : null;
                        $liste[4] = (isset($liste[4])) ? $liste[4] : null;
                        $liste[5] = (isset($liste[5])) ? $liste[5] : null;
                        $liste[6] = (isset($liste[6])) ? $liste[6] : null;
                        $liste[7] = (isset($liste[7])) ? $liste[7] : null;
                        $liste[8] = (isset($liste[8])) ? $liste[8] : null;
                        $liste[9] = (isset($liste[9])) ? $liste[9] : null;
                        $liste[10] = (isset($liste[10])) ? $liste[10] : null;
                        $liste[11] = (isset($liste[11])) ? $liste[11] : null;
                        $liste[12] = (isset($liste[12])) ? $liste[12] : null;
                        $liste[13] = (isset($liste[13])) ? $liste[13] : null;
                        $liste[14] = (isset($liste[14])) ? $liste[14] : null;
                        $liste[15] = (isset($liste[15])) ? $liste[15] : null;
                        $liste[16] = (isset($liste[16])) ? $liste[16] : null;
                        $liste[17] = (isset($liste[17])) ? $liste[17] : null;
                        $liste[18] = (isset($liste[18])) ? $liste[18] : null;
                        $liste[19] = (isset($liste[19])) ? $liste[19] : null;
                        $liste[20] = (isset($liste[20])) ? $liste[20] : null;
                        $liste[21] = (isset($liste[21])) ? $liste[21] : null;
                        $liste[22] = (isset($liste[22])) ? $liste[22] : null;
                        $liste[23] = (isset($liste[23])) ? $liste[23] : null;
                        $liste[24] = (isset($liste[24])) ? $liste[24] : null;
                        $liste[25] = (isset($liste[25])) ? $liste[25] : null;
                        $liste[26] = (isset($liste[26])) ? $liste[26] : null;
                        $liste[27] = (isset($liste[27])) ? $liste[27] : null;
                        $liste[28] = (isset($liste[28])) ? $liste[28] : null;
                        $liste[29] = (isset($liste[29])) ? $liste[29] : null;
                        $liste[30] = (isset($liste[30])) ? $liste[30] : null;
                        $liste[31] = (isset($liste[31])) ? $liste[31] : null;


                        $code = $liste[0];
                        $last_name = $liste[1];
                        $first_name = $liste[2];
                        $category = $liste[3];
                        $service = $liste[5];
                        $birthday = $liste[6];
                        $birthplace = $liste[7];
                        $blood_group = $liste[8];
                        $address = $liste[9];
                        $tel = $liste[10];
                        $mobile = $liste[11];
                        $email1 = $liste[12];
                        $monthly_payroll = $liste[13];
                        $entry_date = $liste[14];
                        $declaration_date = $liste[15];
                        $exit_date = $liste[16];
                        $ccp = $liste[17];
                        $bank_account = $liste[18];
                        $identity_card_nu = $liste[19];
                        $identity_card_by = $liste[20];
                        $identity_card_date = $liste[21];
                        $driver_license_nu = $liste[22];
                        $driver_license_category = $liste[23];
                        $driver_license_by = $liste[24];
                        $driver_license_date = $liste[25];
                        $driver_license_expires_date1 = $liste[26];
                        $driver_license_expires_date2 = $liste[27];
                        $driver_license_expires_date3 = $liste[28];
                        $driver_license_expires_date4 = $liste[29];
                        $driver_license_expires_date5 = $liste[30];
                        $driver_license_expires_date6 = $liste[31];
                        $category = $this->getCategoryId($category);
                        $service = $this->getServiceId($service);
                        $driver_license_category = $this->getDriverLicenseCategory($driver_license_category);

                        if (!empty($birthday)) {
                            $birthday = $this->getDate($birthday);
                        }
                        if (!empty($entry_date)) {
                            $entry_date = $this->getDate($entry_date);
                        }

                        if (!empty($declaration_date)) {
                            $declaration_date = $this->getDate($declaration_date);
                        }

                        if (!empty($exit_date)) {
                            $exit_date = $this->getDate($exit_date);
                        }

                        if (!empty($identity_card_date)) {
                            $identity_card_date = $this->getDatetime($identity_card_date);
                        }

                        if (!empty($driver_license_date)) {
                            $driver_license_date = $this->getDatetime($driver_license_date);
                        }

                        if (!empty($driver_license_expires_date1)) {
                            $driver_license_expires_date1 = $this->getDatetime($driver_license_expires_date1);
                        }

                        if (!empty($driver_license_expires_date2)) {
                            $driver_license_expires_date2 = $this->getDatetime($driver_license_expires_date2);
                        }

                        if (!empty($driver_license_expires_date3)) {
                            $driver_license_expires_date3 = $this->getDatetime($driver_license_expires_date3);
                        }

                        if (!empty($driver_license_expires_date4)) {
                            $driver_license_expires_date4 = $this->getDatetime($driver_license_expires_date4);
                        }

                        if (!empty($driver_license_expires_date5)) {
                            $driver_license_expires_date5 = $this->getDatetime($driver_license_expires_date5);
                        }

                        if (!empty($driver_license_expires_date6)) {
                            $driver_license_expires_date6 = $this->getDatetime($driver_license_expires_date6);
                        }
                        if ($cpt > 0) {
                            $this->Customer->create();
                            if (!empty($code)) {
                                $this->request->data['Customer']['code'] = $code;
                            }
                            $this->request->data['Customer']['customer_category_id'] = $category;
                            $this->request->data['Customer']['company'] = '';
                            $this->request->data['Customer']['last_name'] = $last_name;
                            $this->request->data['Customer']['first_name'] = $first_name;
                            $this->request->data['Customer']['mobile'] = $mobile;
                            $this->request->data['Customer']['service_id'] = $service;
                            $this->request->data['Customer']['birthday'] = $birthday;
                            $this->request->data['Customer']['birthplace'] = $birthplace;
                            $this->request->data['Customer']['blood_group'] = $blood_group;
                            $this->request->data['Customer']['adress'] = $address;
                            $this->request->data['Customer']['tel'] = $tel;
                            $this->request->data['Customer']['mobile'] = $mobile;
                            $this->request->data['Customer']['email1'] = $email1;
                            $this->request->data['Customer']['monthly_payroll'] = $monthly_payroll;
                            $this->request->data['Customer']['entry_date'] = $entry_date;
                            $this->request->data['Customer']['declaration_date'] = $declaration_date;
                            $this->request->data['Customer']['exit_date'] = $exit_date;
                            $this->request->data['Customer']['ccp'] = $ccp;
                            $this->request->data['Customer']['bank_account'] = $bank_account;
                            $this->request->data['Customer']['identity_card_nu'] = $identity_card_nu;
                            $this->request->data['Customer']['identity_card_by'] = $identity_card_by;
                            $this->request->data['Customer']['identity_card_date'] = $identity_card_date;
                            $this->request->data['Customer']['driver_license_nu'] = $driver_license_nu;
                            $this->request->data['Customer']['driver_license_category'] = $driver_license_category;
                            $this->request->data['Customer']['driver_license_by'] = $driver_license_by;
                            $this->request->data['Customer']['driver_license_date'] = $driver_license_date;
                            $this->request->data['Customer']['driver_license_expires_date1'] = $driver_license_expires_date1;
                            $this->request->data['Customer']['driver_license_expires_date2'] = $driver_license_expires_date2;
                            $this->request->data['Customer']['driver_license_expires_date3'] = $driver_license_expires_date3;
                            $this->request->data['Customer']['driver_license_expires_date4'] = $driver_license_expires_date4;
                            $this->request->data['Customer']['driver_license_expires_date5'] = $driver_license_expires_date5;
                            $this->request->data['Customer']['driver_license_expires_date6'] = $driver_license_expires_date6;
                            $this->request->data['Customer']['user_id'] = $this->Session->read('Auth.User.id');


                            $this->Customer->save($this->request->data);
                        }
                        $cpt++;

                    }
                    fclose($fp);

                    $this->Flash->success(__('The file has been successfully imported'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->error(__('The file must be in csv format'));
                    $this->redirect(array('action' => 'index'));

                }


            }

        }

    }

    public function getCategoryId($categoryNameImport)
    {
        $categoryNameImport = trim($categoryNameImport);
        $categoryNameImport = strtolower($categoryNameImport);

        $categoryId = null;
        $customerCategories = $this->CustomerCategory->getCustomerCategories('all');
        foreach ($customerCategories as $customerCategory) {
            $categoryName = strtolower($customerCategory['CustomerCategory']['name']);
            $categoryName = trim($categoryName);

            if ($categoryNameImport == $categoryName) {
                $categoryId = $customerCategory['CustomerCategory']['id'];
            }
        }
        return $categoryId;
    }

    public function getServiceId($service_name_import)
    {
        $service_name_import = trim($service_name_import);
        $service_name_import = strtolower($service_name_import);

        $service_id = null;
        $services = $this->Service->find('all', array('recursive' => -1));
        foreach ($services as $service) {
            $service_name = strtolower($service['Service']['name']);
            $service_name = trim($service_name);

            if ($service_name_import == $service_name) {
                $service_id = $service['Service']['id'];
            }
        }
        return $service_id;
    }

    public function getDriverLicenseCategory($driver_license_category_import)
    {
        $driverLicenseCategories = explode(',', $driver_license_category_import);
        $categories = array(
            '1' => __("A"),
            '2' => __("B"),
            '3' => __("C"),
            '4' => __("D"),
            '5' => __("E"),
            '6' => __("F")
        );
        $driverLicenseCategoryKeys = '';

        foreach ($driverLicenseCategories as $driverLicenseCategory) {
            $key = array_search($driverLicenseCategory, $categories);
            if (!empty($key)) {
                $driverLicenseCategoryKeys = $key . ',' . $driverLicenseCategoryKeys;
            }
        }
        return $driverLicenseCategoryKeys;

    }

    public function getDate($date)
    {

        $dateResult = '';
        $date = trim($date);
        $date = strtolower($date);

        $this->request->data['Customer']['date'] = $date;
        $this->createDateFromDate('Customer', 'date');

        if (empty($this->request->data['Customer']['date'])) {
            $this->request->data['Customer']['date'] = $date;
            $this->createDateFromDateFormat2('Customer', 'date');

            if (!empty($this->request->data['Customer']['date'])) {
                $dateResult = $this->request->data['Customer']['date'];
            }
        } else {
            $dateResult = $this->request->data['Customer']['date'];
        }


        return $dateResult;

    }

    public function getDatetime($date)
    {

        $dateResult = '';
        $date = trim($date);
        $date = strtolower($date);

        $this->request->data['Customer']['date'] = $date;
        $this->createDatetimeFromDate('Customer', 'date');

        if (empty($this->request->data['Customer']['date'])) {
            $this->request->data['Customer']['date'] = $date;
            $this->createDatetimeFromDateFormat2('Customer', 'date');

            if (!empty($this->request->data['Customer']['date'])) {
                $dateResult = $this->request->data['Customer']['date'];
            }
        } else {
            $dateResult = $this->request->data['Customer']['date'];
        }


        return $dateResult;

    }

    public function getParcId($parcNameImport)
    {
        $parcNameImport = trim($parcNameImport);
        $parcNameImport = strtolower($parcNameImport);

        $parcId = null;
        $parcs = $this->Parc->getParcs('all');
        foreach ($parcs as $Parc) {
            $parcName = strtolower($Parc['Parc']['name']);
            if ($parcNameImport == $parcName) {
                $parcId = $Parc['Parc']['id'];
            }
        }
        return $parcId;

    }

    public function getDepartmentId($department_name_import)
    {
        $department_name_import = trim($department_name_import);
        $department_name_import = strtolower($department_name_import);

        $department_id = null;
        $departments = $this->Department->getDepartments('all');
        foreach ($departments as $department) {
            $department_name = strtolower($department['Department']['name']);
            $department_name = trim($department_name);

            if ($department_name_import == $department_name) {
                $department_id = $department['Department']['id'];
            }
        }
        return $department_id;
    }

    public function openDir($dir = null, $id_dialog = null, $id_input = null)
    {


        $this->layout = 'ajax';


        //$this->verifAttachment('Car', 'file', 'attachments/yellowcards/', 'add',1,0,null);


        $array_fichier = array();
        $i = 0;


        if ($dossier = opendir('./attachments/company/' . $dir)) {
            while (false !== ($fichier = readdir($dossier))) {
                if ($fichier != '.' && $fichier != '..' && $fichier != 'index.php') {
                    $array_fichier[$i] = $fichier;
                    $i++;

                } // On ferme le if (qui permet de ne pas afficher index.php, etc.)

            }

            closedir($dossier);
        } else {
            echo 'Le dossier n\' a pas pu etre ouvert';
        }


        $this->set('array_fichier', $array_fichier);
        $this->set('dir', $dir);
        $this->set('id_dialog', $id_dialog);
        $this->set('id_input', $id_input);
    }

    function uploadPicture()
    {


        $this->layout = 'ajax';


        $this->set('file_name', $this->params['pass']['0']);
        $this->set('Dir', $this->params['pass']['1']);

    }


    public function liste($id = null, $keyword = null)
    {
        $keyword = str_replace('espace', ' ', $keyword);
        $keyword = str_replace('slash', '/', $keyword);
        $this->layout = 'ajax';
        $limit = $this->getLimit();
        switch ($id) {
            case 2 :
                $conditions = array("LOWER(Customer.code) LIKE" => "%$keyword%");
                break;
            case 3 :
                $conditions = array("LOWER(Customer.first_name) LIKE" => "%$keyword%");
                break;
            case 4 :
                $conditions = array("LOWER(Customer.last_name) LIKE" => "%$keyword%");
                break;
            case 5 :
                $conditions = array("LOWER(Group.name) LIKE" => "%$keyword%");
                break;
            case 6 :
                $conditions = array("LOWER(Customer.mobile) LIKE" => "%$keyword%");
                break;
            case 7 :
                $conditions = array("LOWER(Customer.email1) LIKE" => "%$keyword%");
                break;
            case 8 :
                $conditions = array("LOWER(Customer.balance) LIKE" => "%$keyword%");
                break;

            default:
                $conditions = array("LOWER(Customer.code) LIKE" => "%$keyword%");
        }
        $this->paginate = array(

            'order' => array('Customer.id' => 'DESC'),
            'conditions' => $conditions,
            'limit' => $limit,
            'paramType' => 'querystring'
        );
        $this->Customer->recursive = 0;
        $this->set('customers', $this->Paginator->paginate('Customer'));
    }


    /**
     * fonction pour r�cup�rer les service d'un department Id
     * @param null $departmentId
     */
    public function getServicesByDepartment($departmentId = null)
    {
        $this->layout = 'ajax';
        $services = $this->Service->find('list',
            array(
                'conditions' => array(
                    'Service.department_id' => $departmentId
                )
            ));
        $this->set(compact('services'));
    }

    /**
     *
     */
    public function getCustomersByKeyWord()
    {
        $this->autoRender = false;
        // get the search term from URL
        $term = $this->request->query['q'];
        // recuperer le controller
        $controller = $_GET['controller'];
        // recuper l'action
        $action = $_GET['action'];
        $customerId = $_GET['customerId'];
        $currentDate = date("Y-m-d");

        $carCustomerOutPark = $this->Parameter->getCodesParameterVal('car_customer_out_park');
        switch ($controller) {
            // recuperer les conditions de feuille de route par action
            case 'sheetRides';
            case 'SheetRides';
            case 'sheet_rides';
            case 'sheetRideDetailRides';
            case 'consumptions';
                switch ($action) {
                    case 'index' :
                    case 'search' :
                    case 'getSheetsToEdit' :
                        $conditions = $this->getConditionsSheetRide();

                        $conditionsCustomer = $conditions[2];
                        break;

                    case 'add';
                    case 'Add';
                        $conditions = $this->getConditionsSheetRide();
                        $conditionsCustomer = $conditions[2];
                        if ($carCustomerOutPark == 1) {
                            $condition1 = array( 'OR' => array('Customer.exit_date >=' => $currentDate, 'Customer.exit_date is NULL','Customer.exit_date' => '0000-00-00'),
                            );
                        } else {
                            $condition1 = array(
                                'OR' => array('Customer.exit_date >=' => $currentDate, 'Customer.exit_date is NULL','Customer.exit_date' => '0000-00-00'),
                                'Customer.in_mission' => array(0)
                            );
                        }

                        if ($conditionsCustomer != null) {
                            $conditionsCustomer = array_merge($conditionsCustomer, $condition1);

                        } else {
                            $conditionsCustomer = $condition1;
                        }

                        break;

                    case 'edit';
                    case 'Edit';
                        $conditions = $this->getConditionsSheetRide();
                        $conditionsCustomer = $conditions[2];
                        if ($carCustomerOutPark == 1) {
                            $condition1 = array(
                                'OR' => array(
                                    'OR' => array('Customer.exit_date >=' => $currentDate, 'Customer.exit_date is NULL','Customer.exit_date' => '0000-00-00'),
                                    'Customer.id' => $customerId)
                            );
                        } else {
                            $condition1 = array(
                                'OR' => array(
                                    'OR' => array('Customer.exit_date >=' => $currentDate, 'Customer.exit_date is NULL','Customer.exit_date' => '0000-00-00'),
                                    'Customer.in_mission' => array(0),
                                    'Customer.id' => $customerId)
                            );
                        }


                        if ($conditionsCustomer != null) {
                            $conditionsCustomer = array_merge($conditionsCustomer, $condition1);
                        } else {
                            $conditionsCustomer = $condition1;
                        }

                        break;
                }
                break;
            case 'transportBills';
            case 'TransportBills';
            case 'transport_bills';

                switch ($action) {
                    case 'add';
                    case 'Add';
                    case 'addRequestQuotation';
                    case 'AddRequestQuotation';

                        $conditionsCustomer = $conditions = array(
                            'OR' => array('Customer.exit_date >=' => $currentDate, 'Customer.exit_date is NULL','Customer.exit_date' => '0000-00-00'),
                            'CustomerCategory.commercial' => 1
                        );
                        break;

                    case 'edit';
                    case 'Edit';
                    case 'editRequestQuotation';
                    case 'EditRequestQuotation';
                        $currentDate = date("Y-m-d");
                        $conditionsCustomer = $conditions = array(
                            'OR' => array('Customer.exit_date >=' => $currentDate, 'Customer.exit_date is NULL','Customer.exit_date' => '0000-00-00'),
                            'CustomerCategory.commercial' => 1,
                            'Customer.id' => $customerId

                        );

                        break;

                }
                break;
            case 'medicalVisits';
            case 'medical_visits';
            case 'MedicalVisits';
            case 'warnings';
            case 'Warnings';
			case 'absences';
            case 'Absences';
            case 'bills';
            case 'Bills';
            case 'complaints';
            case 'Complaints';
            switch ($action) {
                case 'add';
                case 'Add';
                    $conditionsCustomer = $conditions = array(
                        'OR' => array('Customer.exit_date >=' => $currentDate, 'Customer.exit_date is NULL','Customer.exit_date' => '0000-00-00'),
                    );
                    break;
                case 'edit';
                case 'Edit';
                    $currentDate = date("Y-m-d");
                    $conditionsCustomer = $conditions = array(
                        'OR' => array('Customer.exit_date >=' => $currentDate, 'Customer.exit_date is NULL','Customer.exit_date' => '0000-00-00'),
                        'Customer.id' => $customerId
                    );
                    break;
            }
            break;

        }
        $term = explode('-', $term);
        $term[0] = trim(strtolower(($term[0])));
        if (isset($term[1])) {
            $term[1] = trim(strtolower(($term[1])));
        }


        if (count($term) > 1) {
            $conds = array(
                "CONVERT(Customer.first_name USING utf8)  COLLATE utf8_general_ci  LIKE " => "%$term[0]%",
                "CONVERT(Customer.last_name USING utf8)  COLLATE utf8_general_ci LIKE " => "%$term[1]%"

            );
        } else {
            $conds = array(
                'OR' => array(
                    " CONVERT(Customer.first_name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term[0]%",
                    " CONVERT(Customer.last_name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term[0]%",

                )
            );
        }


        $conditions =  array(
            'AND' => array(
                $conds
            ),
            array(
                $conditionsCustomer
            )
        );


        $fields = array('Customer.id', 'Customer.first_name', 'Customer.last_name');
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions, 'all');
        $data = array();
        $i = 0;
        $data[$i]['id'] = "";
        $data[$i]['text'] = "";
        $i++;
        foreach ($customers as $customer) {
            $data[$i]['id'] = $customer['Customer']['id'];

            $data[$i]['text'] = $customer['Customer']['first_name'] . ' - ' . $customer['Customer']['last_name'];

            $i++;
        }

        echo json_encode($data);
    }

    /**
     *
     */
    public function getConveyorsByKeyWord()
    {
        $this->autoRender = false;

        // get the search term from URL
        $term = $this->request->query['q'];
        // recuperer le controller
        $controller = $_GET['controller'];
        // recuper l'action
        $action = $_GET['action'];


        switch ($controller) {
            // recuperer les conditions de feuille de route par action
            case 'sheetRides';
            case 'SheetRides';
            case 'sheet_rides';
                switch ($action) {
                    case 'index' :
                        $conditions = $this->getConditionsSheetRide();

                        $conditionsCustomer = $conditions[2];
                        break;
                    case 'search' :
                        $conditions = $this->getConditionsSheetRide();

                        $conditionsCustomer = $conditions[2];
                        break;
                    case 'add';
                    case 'Add';
                        $conditions = $this->getConditionsSheetRide();
                        $conditionsCustomer = $conditions[2];
                        $condition1 = null;
                        if ($conditionsCustomer != null) {
                            $conditionsCustomer = array_merge($conditionsCustomer, $condition1);

                        } else {
                            $conditionsCustomer = $condition1;
                        }

                        break;

                    case 'edit';
                    case 'Edit';
                        $conditions = $this->getConditionsSheetRide();
                        $conditionsCustomer = $conditions[2];
                        $condition1 = null;

                        if ($conditionsCustomer != null) {
                            $conditionsCustomer = array_merge($conditionsCustomer, $condition1);
                        } else {
                            $conditionsCustomer = $condition1;
                        }

                        break;

                }
                break;
        }
        $term = explode('-', $term);
        $term[0] = trim(strtolower(($term[0])));
        if (isset($term[1])) {
            $term[1] = trim(strtolower(($term[1])));
        }


        if (count($term) > 1) {
            $conds = array(
                "CONVERT(Customer.first_name USING utf8)  COLLATE utf8_general_ci  LIKE " => "%$term[0]%",
                "CONVERT(Customer.last_name USING utf8)  COLLATE utf8_general_ci LIKE " => "%$term[1]%"

            );
        } else {
            $conds = array(
                'OR' => array(
                    " CONVERT(Customer.first_name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term[0]%",
                    " CONVERT(Customer.last_name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term[0]%",

                )
            );
        }

        if ($conditionsCustomer != null) {
            $conds = array_merge($conditionsCustomer, $conds);

        }

        $fields = array('Customer.id', 'Customer.first_name', 'Customer.last_name');
        $customers = $this->Customer->getConvoyeursByFieldsAndConds($fields, $conds, 'all');
        $data = array();
        $i = 0;
        $data[$i]['id'] = "";
        $data[$i]['text'] = "";
        $i++;
        foreach ($customers as $customer) {
            $data[$i]['id'] = $customer['Customer']['id'];

            $data[$i]['text'] = $customer['Customer']['first_name'] . ' - ' . $customer['Customer']['last_name'];

            $i++;
        }

        echo json_encode($data);
    }


    public function printSimplifiedJournal()
    {


        $this->setTimeActif();
        ini_set('memory_limit', '1024M');
        $array = filter_input(INPUT_POST, "printSimplifiedJournal");

        $arrayConditions = explode(",", $array);

        $categoryId = $arrayConditions[0];
        $driverLicenseCategory = $arrayConditions[1];
        $groupId = $arrayConditions[2];
        $parcId = $arrayConditions[3];
        $conditions = array();

        if (!empty($categoryId)) {
            $conditions["Customer.customer_category_id"] = $categoryId;
        }
        if (!empty($driverLicenseCategory)) {
            $conditions["LOWER(Customer.driver_license_category) LIKE" ]= "%$driverLicenseCategory%";
        }
        if (!empty($groupId)) {
            $conditions["Customer.customer_group_id"] = $groupId;
        }
        if (!empty($parcId)) {
            $conditions["Customer.parc_id"] = $parcId;
        }


        $ids = filter_input(INPUT_POST, "chkids");

        if (!empty($ids)) {


            $array_ids = explode(",", $ids);
            if (!empty($array_ids)) {
                $conditions["Customer.id"] = $array_ids;
            }
        }


        $customers = $this->Customer->find('all',array(
            'recursive'=>-1,
            'order' => array('Customer.code' => 'ASC'),
            'fields'=>array('Customer.code',
                            'Customer.first_name',
                            'Customer.last_name',
                            'Customer.mobile',
                            'Customer.email1',
                            'CustomerGroup.name',
                            'CustomerCategory.name',
                            'Parc.name',
            ),
            'conditions' => $conditions,
            'joins'=>array(
                array(
                    'table' => 'customer_groups',
                    'type' => 'left',
                    'alias' => 'CustomerGroup',
                    'conditions' => array('CustomerGroup.id = Customer.customer_group_id')
                ),
                array(
                    'table' => 'parcs',
                    'type' => 'left',
                    'alias' => 'Parc',
                    'conditions' => array('Parc.id = Customer.parc_id')
                ),
                array(
                    'table' => 'customer_categories',
                    'type' => 'left',
                    'alias' => 'CustomerCategory',
                    'conditions' => array('CustomerCategory.id = Customer.customer_category_id')
                ),
            )
        )) ;


        $company = $this->Company->find('first');
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact( 'customers','company', 'separatorAmount'));

    }


    public function getAuthorizedCustomers($customerId=null, $tel=null)
    {
        $conditions =" (Customer.exit_date is null or  Customer.exit_date='0000-00-00' ) and (Customer.code is not null and Customer.code!='' ) ";
        if(isset($customerId) && $customerId!=null && $customerId!='null' && ($tel==null or $tel='null')){
            $conditions = $conditions."  and  `Customer`.`id` = ".$customerId;
        }
        else if(isset($tel) && $tel!=null &&  $tel!='null' && ($customerId==null or $customerId=='null')){
            $conditions = $conditions." and `Customer`.`mobile` = '".$tel."'";
        }
        else if(isset($tel) && $tel!=null && $customerId!=null && $customerId!='null' && $tel!='null'){
            $conditions = $conditions." and `Customer`.`mobile` = '".$tel."'  and `Customer`.`id` = ".$customerId;
        }

        $sqlCustomers =" SELECT 
                        `Customer`.`last_name`, `Customer`.`first_name`,`Customer`.`id`,
                        `Customer`.`mobile`, `Customer`.`authorized`
                                                                   
                                        FROM  `customers` AS `Customer` 
                                    WHERE ".$conditions."
                                      order by `Customer`.`id` ASC ";

        $conn = ConnectionManager::getDataSource('default');
        $customers = $conn->fetchAll($sqlCustomers);
        $customersArray= array();
        $i=0;
        if(!empty($customers))
        {
            foreach ($customers  as $customer){
                $customersArray[$i]['nom']=$customer['Customer']['last_name'];
                $customersArray[$i]['prenom']=$customer['Customer']['first_name'];
                $customersArray[$i]['id']=$customer['Customer']['id'];
                $customersArray[$i]['tel']=$customer['Customer']['mobile'];
                $customersArray[$i]['autorise']=$customer['Customer']['authorized'];
                $i++;
            }
            $customersArray = json_encode($customersArray);
            $this->response->type('json');
            $this->response->body($customersArray);
            return $this->response;
        }
        else {
            echo 0; die();
        }
    }



    public function updateUuid()
    {
        $id = $_POST['id'];
        $uuid = $_POST['uuid'];
        $this->Customer->id = $id;
        $this->Customer->saveField('uuid', $uuid);

    }


    public function loginapi()
    {
        $username = addslashes($_POST['username']);
        $password = addslashes($_POST['password']);
        $users =" SELECT id FROM `users` WHERE users.username='".$username."' and users.secret_password='".$password."' limit 0,1";
        $conn = ConnectionManager::getDataSource('default');
        $users = $conn->fetchAll($users);
        if(!empty($users) and count($users)>0)
        {
            foreach($users as $user) {
                echo  $user["users"]["id"];
                die();
            }
        }
        else {
            echo "0"; die();
        }
    }



}

