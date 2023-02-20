<?php
App::uses('HttpSocket', 'Network/Http');
App::uses('SimpleXLSX', 'Lib');
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel/Classes/PHPExcel.php'));
App::import('Vendor', 'IOFactory', array('file' => 'PHPExcel/Classes/PHPExcel/IOFactory.php'));
//App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel/Classes/PHPExcel.php'));

/**
 * Cars Controller
 *
 * @property Car $Car
 * @property Event $Event
 * @property CarStatus $CarStatus
 * @property Mark $Mark
 * @property CarType $CarType
 * @property User $User
 * @property CarCarStatus $CarCarStatus
 * @property Compte $Compte
 * @property Parc $Parc
 * @property Profile $Profile
 * @property CarTypeCarCategory $CarTypeCarCategory
 * @property UserParc $UserParc
 * @property CarCategory $CarCategory
 * @property Fuel $Fuel
 * @property Company $Company
 * @property Leasing $Leasing
 * @property Department $Department
 * @property Customer $Customer
 * @property SheetRide $SheetRide
 * @property Carmodel $Carmodel
 * @property CustomerCar $CustomerCar
 * @property Supplier $Supplier
 * @property Payment $Payment
 * @property CarGroup $CarGroup
 * @property AcquisitionType $AcquisitionType
 * @property Monthlykm $Monthlykm
 * @property Consumption $Consumption
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class CarsController extends AppController
{
    public $components = array('Paginator', 'Session', 'RequestHandler', 'Security', 'SaveParcs');
    public $uses = array(
        'Car',
        'Mark',
        'Carmodel',
        'CarCategory',
        'CarType',
        'Fuel',
        'CustomerCar',
        'Parc',
        'Company',
        'Department',
        'AcquisitionType',
        'Payment',
        'Monthlykm',
        'Customer',
        'CarGroup',
        'CarStatus',
        'Profile',
        'SheetRide',
        'Compte',
        'Consumption',
        'UserParc'
    );

    /**
     * index method
     *
     * @return void
     */

    public function index()
    {
        $this->settimeactif();

        if (Configure::read("cafyb") == '1') {
            $userId = 1;
        } else {
            $userId = $this->Auth->user('id');
        }
        $result = $this->verifyUserPermission(
            SectionsEnum::vehicule,
            $userId,
            ActionsEnum::view,
            "Cars",
            null,
            "Car",
            null
        );

        if ($this->IsAdministrator) {
            $parcIds = array();
        } else {
            $parcIds = $this->getParcsUserIdsArray($userId);
        }

        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        // if false (has not permission to view car's parc)
        if ($this->verifyUserParcPermission(SectionsEnum::vehicule)) {
            switch ($result) {
                case 1: 
                    if (!empty($parcIds)) {
                        $conditions = array('Car.parc_id' => $parcIds);
                    } else {
                        $conditions = array();
                    }
                    break;
                case 2: 
                    $conditions = array('Car.user_id' => $userId);
                    break;
                case 3: 
                    $conditions = array('Car.user_id !=' => $userId);
                    break;
                default: 
                    $conditions = array('Car.user_id' => $userId);
            }
            if (!empty($parcIds)) {
                $conditions = array_merge($conditions, array('Car.parc_id' => $parcIds));
            }
        } else {
            switch ($result) {
                case 1:
                    $conditions = null;
                    break;
                case 2:
                    $conditions = array('Car.user_id' => $userId);
                    break;
                case 3:
                    $conditions = array('Car.user_id !=' => $userId);
                    break;
                default:
                    $conditions = null;
            }
        }

        $conditions_total = $conditions;

        $condition1 = array('Car.car_status_id !=' => 27);
        if ($conditions != null) {
            $conditions = array_merge($conditions, $condition1);
        } else {
            $conditions = $condition1;
        }


        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Car.id' => 'DESC'),
            'conditions' => $conditions,
            'group' => array('Car.id'),
            'paramType' => 'querystring',
            'fields' => array(
                'Carmodel.name',
                'Car.id',
                'Car.code',
                'CarCategory.name',
                'CarType.name',
                'Car.km',
                'Car.km_initial',
                'CarCategory.id',
                'CarType.id',
                'CarType.name',
                'CarType.picture',
                'Fuel.name',
                'Car.nbplace',
                'Car.nbdoor',
                'Car.immatr_def',
                'Car.chassis',
                'Car.color2',
                'CarStatus.id',
                'CarStatus.name',
                'CarStatus.color',
                'Car.in_mission',
                'Car.locked',
                'Mark.logo',
                'Car.picture1',
                'Car.picture2',
                'Car.picture3',
                'Car.picture4',
                'Car.balance',
                'Car.yellow_card',
                'Car.grey_card',
                'Car.start_date',
                'Car.end_date',
            ),
            'recursive' => -1,
            //'group' => -1,
            'joins' => array(

                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'car_categories',
                    'type' => 'left',
                    'alias' => 'CarCategory',
                    'conditions' => array('Car.car_category_id = CarCategory.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('Car.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'fuels',
                    'type' => 'left',
                    'alias' => 'Fuel',
                    'conditions' => array('Car.fuel_id = Fuel.id')
                ),
                array(
                    'table' => 'car_statuses',
                    'type' => 'left',
                    'alias' => 'CarStatus',
                    'conditions' => array('Car.car_status_id = CarStatus.id')
                ),

                array(
                    'table' => 'marks',
                    'type' => 'left',
                    'alias' => 'Mark',
                    'conditions' => array('Car.mark_id = Mark.id')
                ),


            )
        );
        $cars = $this->Paginator->paginate('Car');
        $this->set('cars', $cars);
        $carStatuses = $this->CarStatus->getCarStatus();
        $marks = $this->Mark->getCarMarks();
        $carTypes = $this->CarType->getCarTypes();
        $users = $this->Car->User->find('list', array('conditions' => 'User.id != 1'));
        if ($this->IsAdministrator) {
            $parcs = $this->Parc->getParcs('list');
        } else {
            $parcIds = $this->getParcsUserIdsArray($userId);
            if (!empty($parcIds)) {
                $parcs = $this->Parc->getParcByIds($parcIds);
            } else {
                $parcs = $this->Parc->getParcs('list');
            }
        }
        $nb_parcs = count($parcIds);

        $carCategories = $this->CarCategory->getCarCategories();
        $fuels = $this->Fuel->getFuels('list');

        $totals = $this->Car->getTotals($conditions_total);
        $hasParc = $this->verifyUserParcPermission(SectionsEnum::vehicule);

        $client_i2b = $this->isCustomerI2B();
        // Verify if Car's code is automatic
        $code_auto = $this->Parameter->getCodesParameterVal('auto_car');
        $balance_car = $this->isBalanceCarUsed();
        $isSuperAdmin = $this->isSuperAdmin();
        $profiles = $this->Profile->getUserProfiles();
        $this->set(compact(
            'profiles',
            'carStatuses',
            'marks',
            'carTypes',
            'users',
            'carCategories',
            'fuels',
            'parcs',
            'profiles',
            'limit',
            'totals',
            'hasParc',
            'nb_parcs',
            'conditions',
            'client_i2b',
            'code_auto',
            'balance_car',
            'isSuperAdmin'
        ));
    }


    public function search()
    {
        $this->settimeactif();
        if (
            isset($this->request->data['keyword']) || isset($this->request->data['Cars']['mark_id'])
            || isset($this->request->data['Cars']['carmodel_id']) || isset($this->request->data['Cars']['car_category_id'])
            || isset($this->request->data['Cars']['car_type_id']) || isset($this->request->data['Cars']['fuel_id'])
            || isset($this->request->data['Cars']['car_status_id']) || isset($this->request->data['Cars']['user_id']) || isset($this->request->data['Cars']['modified_id'])
            || isset($this->request->data['Cars']['created']) || isset($this->request->data['Cars']['created1'])
            || isset($this->request->data['Cars']['modified']) || isset($this->request->data['Cars']['modified1'])
            || isset($this->request->data['Cars']['parc_id']) || isset($this->request->data['Cars']['mission']) || isset($this->params['data']['conditions'])
            || isset($this->request->data['Cars']['profile_id']) || isset($this->request->data['Cars']['car_parc'])
        ) {


            $this->filterUrl();
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Car.id' => 'DESC'),
            'paramType' => 'querystring'
        );


        if (
            isset($this->params['named']['keyword']) || isset($this->params['named']['mark'])
            || isset($this->params['named']['model']) || isset($this->params['named']['category'])
            || isset($this->params['named']['type']) || isset($this->params['named']['fuel'])
            || isset($this->params['named']['status']) || isset($this->params['named']['user']) || isset($this->params['named']['modified_id'])
            || isset($this->params['named']['created']) || isset($this->params['named']['created1'])
            || isset($this->params['named']['modified']) || isset($this->params['named']['modified1'])
            || isset($this->params['named']['parc']) || isset($this->params['named']['mission']) || isset($this->params['named']['conditions'])
            || isset($this->params['named']['profile']) || isset($this->params['named']['car_parc'])
        ) {

            $conditions = $this->getConds();

            $conditions_index = unserialize(base64_decode($this->params['named']['conditions']));

            if ($conditions_index != null) {
                $conditions = array_merge($conditions, $conditions_index);
            }
            $this->paginate = array(
                'limit' => $limit,
                'order' => array('Car.id' => 'DESC'),
                'conditions' => $conditions,
                'group' => array('Car.id'),
                'paramType' => 'querystring',
                'fields' => array(
                    'Carmodel.name',
                    'Car.id',
                    'Car.code',
                    'CarCategory.name',
                    'CarType.name',
                    'Car.km',
                    'Car.km_initial',
                    'CarCategory.id',
                    'CarType.id',
                    'Fuel.name',
                    'Car.nbplace',
                    'Car.nbdoor',
                    'Car.immatr_def',
                    'Car.chassis',
                    'Car.color2',
                    'CarStatus.id',
                    'CarStatus.name',
                    'CarStatus.color',
                    'Car.in_mission',
                    'Car.locked',
                    'Mark.logo',
                    'Car.picture1',
                    'Car.picture2',
                    'Car.picture3',
                    'Car.picture4',
                    'Car.balance',
                    'Car.yellow_card',
                    'Car.grey_card',
                    'Car.start_date',
                    'Car.end_date',
                ),
                'recursive' => -1,
                //'group' => -1,
                'joins' => array(

                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),
                    array(
                        'table' => 'car_categories',
                        'type' => 'left',
                        'alias' => 'CarCategory',
                        'conditions' => array('Car.car_category_id = CarCategory.id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'CarType',
                        'conditions' => array('Car.car_type_id = CarType.id')
                    ),
                    array(
                        'table' => 'fuels',
                        'type' => 'left',
                        'alias' => 'Fuel',
                        'conditions' => array('Car.fuel_id = Fuel.id')
                    ),
                    array(
                        'table' => 'car_statuses',
                        'type' => 'left',
                        'alias' => 'CarStatus',
                        'conditions' => array('Car.car_status_id = CarStatus.id')
                    ),

                    array(
                        'table' => 'marks',
                        'type' => 'left',
                        'alias' => 'Mark',
                        'conditions' => array('Car.mark_id = Mark.id')
                    ),
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('Car.user_id = User.id')
                    ),


                )
            );
            $cars = $this->Paginator->paginate('Car');
            $totals = $this->Car->getSearchTotals($conditions);
            $this->set(compact('totals'));

            $this->set('cars', $cars);


        } else {

            $this->paginate = array(
                'limit' => $limit,
                'order' => array('Car.id' => 'DESC'),
                'paramType' => 'querystring'
            );
            $this->Car->recursive = 1;
            $totals = $this->Car->getSearchTotals(array());
            $this->set(compact('totals'));
            $this->set('cars', $this->Paginator->paginate('Car'));
        }
        if (!isset($conditions)){
            $conditions = array();
        }
        $this->set(compact('conditions'));

        $carStatuses = $this->CarStatus->getCarStatus();
        $marks = $this->Mark->getCarMarks();
        $carTypes = $this->CarType->getCarTypes();
        $users = $this->Car->User->find('list', array('conditions' => array('User.id !=' => 1)));
        $profiles = $this->Profile->getUserProfiles();
        $carCategories = $this->CarCategory->getCarCategories();
        $fuels = $this->Fuel->getFuels('list');
        $userId = intval($this->Auth->user('id'));
        $parcIds = $this->getParcsUserIdsArray($userId);
        if ($this->IsAdministrator) {
            $parcs = $this->Parc->getParcs('list');
        } else {
            $parcIds = $this->getParcsUserIdsArray($userId);
            if (!empty($parcIds)) {
                $parcs = $this->Parc->getParcByIds($parcIds);
            } else {
                $parcs = $this->Parc->getParcs('list');
            }
        }
        $nb_parcs = count($parcIds);
        $hasParc = $this->verifyUserParcPermission(SectionsEnum::vehicule);
        // Verify if Car's code is automatic
        $code_auto = $this->Parameter->getCodesParameterVal('auto_car');
        $balance_car = $this->isBalanceCarUsed();
        $client_i2b = $this->isCustomerI2B();
        $isSuperAdmin = $this->isSuperAdmin();
        if (isset($this->params['named']['mark']) && !empty($this->params['named']['mark'])) {
            $carmodels = $this->Carmodel->getCarModelsByMark($this->params['named']['mark']);
            $this->set(compact(
                'limit',
                'carStatuses',
                'marks',
                'carTypes',
                'users',
                'carCategories',
                'fuels',
                'carmodels',
                'parcs',
                'nb_parcs',
                'conditions_index',
                'hasParc',
                'code_auto',
                'balance_car',
                'client_i2b',
                'isSuperAdmin'
            ));
        } else {
            $this->set(compact(
                'profiles',
                'limit',
                'carStatuses',
                'marks',
                'carTypes',
                'users',
                'carCategories',
                'fuels',
                'parcs',
                'nb_parcs',
                'conditions_index',
                'hasParc',
                'code_auto',
                'balance_car',
                'client_i2b',
                'isSuperAdmin'
            ));
        }

        $this->render();
    }

    private function filterUrl()
    {
        $filter_url['controller'] = $this->request->params['controller'];
        $filter_url['action'] = $this->request->params['action'];
        $filter_url['page'] = 1;
        $filter_url['keyword'] = $this->request->data['keyword'];
        $filter_url['conditions'] = $this->params['data']['conditions'];
        if (isset($this->request->data['Cars']['mark_id']) && !empty($this->request->data['Cars']['mark_id'])) {
            $filter_url['mark'] = $this->request->data['Cars']['mark_id'];
        }
        if (isset($this->request->data['Cars']['carmodel_id']) && !empty($this->request->data['Cars']['carmodel_id'])) {
            $filter_url['model'] = $this->request->data['Cars']['carmodel_id'];
        }
        if (isset($this->request->data['Cars']['car_category_id']) && !empty($this->request->data['Cars']['car_category_id'])) {
            $filter_url['category'] = $this->request->data['Cars']['car_category_id'];
        }
        if (isset($this->request->data['Cars']['car_type_id']) && !empty($this->request->data['Cars']['car_type_id'])) {
            $filter_url['type'] = $this->request->data['Cars']['car_type_id'];
        }
        if (isset($this->request->data['Cars']['fuel_id']) && !empty($this->request->data['Cars']['fuel_id'])) {
            $filter_url['fuel'] = $this->request->data['Cars']['fuel_id'];
        }
        if (isset($this->request->data['Cars']['car_status_id']) && !empty($this->request->data['Cars']['car_status_id'])) {
            $filter_url['status'] = $this->request->data['Cars']['car_status_id'];
        }
        if (isset($this->request->data['Cars']['user_id']) && !empty($this->request->data['Cars']['user_id'])) {
            $filter_url['user'] = $this->request->data['Cars']['user_id'];
        }
        if (isset($this->request->data['Cars']['profile_id']) && !empty($this->request->data['Cars']['profile_id'])) {
            $filter_url['profile'] = $this->request->data['Cars']['profile_id'];
        }
        if (isset($this->request->data['Cars']['created']) && !empty($this->request->data['Cars']['created'])) {
            $filter_url['created'] = str_replace("/", "-", $this->request->data['Cars']['created']);
        }
        if (isset($this->request->data['Cars']['created1']) && !empty($this->request->data['Cars']['created1'])) {
            $filter_url['created1'] = str_replace("/", "-", $this->request->data['Cars']['created1']);
        }
        if (isset($this->request->data['Cars']['modified_id']) && !empty($this->request->data['Cars']['modified_id'])) {
            $filter_url['modified_id'] = $this->request->data['Cars']['modified_id'];
        }
        if (isset($this->request->data['Cars']['modified']) && !empty($this->request->data['Cars']['modified'])) {
            $filter_url['modified'] = str_replace("/", "-", $this->request->data['Cars']['modified']);
        }
        if (isset($this->request->data['Cars']['modified1']) && !empty($this->request->data['Cars']['modified1'])) {
            $filter_url['modified1'] = str_replace("/", "-", $this->request->data['Cars']['modified1']);
        }
        if (isset($this->request->data['Cars']['parc_id']) && !empty($this->request->data['Cars']['parc_id'])) {
            $filter_url['parc'] = $this->request->data['Cars']['parc_id'];
        }
        if (isset($this->request->data['Cars']['mission']) && !empty($this->request->data['Cars']['mission'])) {
            $filter_url['mission'] = $this->request->data['Cars']['mission'];
        }
        if (isset($this->request->data['Cars']['car_parc']) && !empty($this->request->data['Cars']['car_parc'])) {
            $filter_url['car_parc'] = $this->request->data['Cars']['car_parc'];
        }
        return $this->redirect($filter_url);
    }

    private function getConds()
    {
        if (!empty($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $conds = array(
                'OR' => array(
                    "LOWER(Car.code) LIKE" => "%$keyword%",
                    "LOWER(Car.immatr_def) LIKE" => "%$keyword%",
                    "LOWER(Car.immatr_prov) LIKE" => "%$keyword%",
                    "LOWER(Car.chassis) LIKE" => "%$keyword%",
                    "LOWER(Carmodel.name) LIKE" => "%$keyword%",
                    "LOWER(Mark.name) LIKE" => "%$keyword%"
                )
            );
        } else {
            $conds = array();
        }
        if (isset($this->params['named']['mark']) && !empty($this->params['named']['mark'])) {
            $conds["Mark.id = "] = $this->params['named']['mark'];
            $this->request->data['Cars']['mark_id'] = $this->params['named']['mark'];
        }
        if (isset($this->params['named']['model']) && !empty($this->params['named']['model'])) {
            $conds["Carmodel.id = "] = $this->params['named']['model'];
            $this->request->data['Cars']['carmodel_id'] = $this->params['named']['model'];
        }
        if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
            $conds["CarCategory.id = "] = $this->params['named']['category'];
            $this->request->data['Cars']['car_category_id'] = $this->params['named']['category'];
        }
        if (isset($this->params['named']['type']) && !empty($this->params['named']['type'])) {
            $conds["CarType.id = "] = $this->params['named']['type'];
            $this->request->data['Cars']['car_type_id'] = $this->params['named']['type'];
        }
        if (isset($this->params['named']['fuel']) && !empty($this->params['named']['fuel'])) {
            $conds["Fuel.id = "] = $this->params['named']['fuel'];
            $this->request->data['Cars']['fuel_id'] = $this->params['named']['fuel'];
        }
        if (isset($this->params['named']['status']) && !empty($this->params['named']['status'])) {
            $conds["CarStatus.id = "] = $this->params['named']['status'];
            $this->request->data['Cars']['car_status_id'] = $this->params['named']['status'];
        }
        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $conds["User.id = "] = $this->params['named']['user'];
            $this->request->data['Cars']['user_id'] = $this->params['named']['user'];
        }

        if (isset($this->params['named']['profile']) && !empty($this->params['named']['profile'])) {
            $conds["User.profile_id = "] = $this->params['named']['profile'];
            $this->request->data['Cars']['profile_id'] = $this->params['named']['profile'];
        }
        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $creat = str_replace("-", "/", $this->params['named']['created']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Car.created >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Cars']['created'] = $creat;
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $creat = str_replace("-", "/", $this->params['named']['created1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Car.created <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Cars']['created1'] = $creat;
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $conds["Car.modified_id = "] = $this->params['named']['modified_id'];
            $this->request->data['Cars']['modified_id'] = $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Car.modified >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Cars']['modified'] = $creat;
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Car.modified <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Cars']['modified1'] = $creat;
        }
        if (isset($this->params['named']['parc']) && !empty($this->params['named']['parc'])) {
            $conds["Car.parc_id = "] = $this->params['named']['parc'];
            $this->request->data['Cars']['parc_id'] = $this->params['named']['parc'];
        }
        if (isset($this->params['named']['mission']) && !empty($this->params['named']['mission'])) {

            switch ($this->params['named']['mission']) {
                case 1:
                    $conds["Car.in_mission = "] = 0;

                    $this->request->data['Cars']['mission'] = 1;
                    break;
                case 2:
                    $conds["Car.in_mission = "] = 1;

                    $this->request->data['Cars']['mission'] = 2;
                    break;
                case 3:
                    $conds["Car.in_mission = "] = 2;

                    $this->request->data['Cars']['mission'] = 3;
                    break;
            }
        }

        if (isset($this->params['named']['car_parc']) && !empty($this->params['named']['car_parc'])) {


            $conds["Car.car_parc = "] = $this->params['named']['car_parc'];
            $this->request->data['Cars']['car_parc'] = $this->params['named']['car_parc'];
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

        $this->settimeactif();
        if (!$this->Car->exists($id)) {
            throw new NotFoundException(__('Invalid car'));
        }
        $options = array('conditions' => array('Car.' . $this->Car->primaryKey => $id));
        $this->set('car', $this->Car->find('first', $options));
        $this->CustomerCar->recursive = 2;
        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => 10,
            'order' => array('CustomerCar.id' => 'DESC'),
            'fields' => array(
                'CustomerCar.id',
                'start',
                'end',
                'Customer.first_name',
                'Customer.last_name',
                'Customer.company'
            ),
            'joins' => array(
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('CustomerCar.customer_id = Customer.id')
                )
            ),
            'conditions' => array('CustomerCar.car_id' => $id)
        );

        $this->set('customerCars', $this->paginate('CustomerCar'));
        // temporairement, le temps de travailler ur les consommations
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
            'conditions' => array('SheetRide.car_id' => $id)
        );

        $this->set('consumptions', $this->paginate('Consumption'));


        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => 10,
            'order' => array('Event.id' => 'DESC'),
            'fields' => array(
                'Event.id',
                'date',
                'next_date',
                'cost',
                'assurance_number',

            ),
            'joins' => array(
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
            'conditions' => array('Event.car_id' => $id, 'EventEventType.event_type_id' => 2)
        );

        $this->set('assurances', $this->paginate('Event'));

        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => 10,
            'order' => array('Event.id' => 'DESC'),
            'fields' => array(
                'Event.id',
                'date',
                'next_date',
                'cost',
            ),
            'joins' => array(
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
            'conditions' => array('Event.car_id' => $id, 'EventEventType.event_type_id' => 3)
        );

        $this->set('technicalControls', $this->paginate('Event'));

        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => 10,
            'order' => array('Event.id' => 'DESC'),
            'fields' => array(
                'Event.id',
                'date',
                'km',
                'next_km',
                'cost'
            ),
            'joins' => array(
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
            'conditions' => array('Event.car_id' => $id, 'EventEventType.event_type_id' => 1)
        );

        $this->set('vidanges', $this->paginate('Event'));

        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => 10,
            'order' => array('Event.id' => 'DESC'),
            'fields' => array(
                'Event.id',
                'date',
                'next_date',
                'cost'

            ),
            'joins' => array(
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
            'conditions' => array('Event.car_id' => $id, 'EventEventType.event_type_id' => 5)
        );

        $this->set('vignettes', $this->paginate('Event'));
        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => 10,
            'order' => array('Event.id' => 'DESC'),
            'fields' => array(
                'Event.id',
                'date',
                'next_date',
                'cost'

            ),
            'joins' => array(
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
            'conditions' => array('Event.car_id' => $id, 'EventEventType.event_type_id' => array(11, 12, 13))
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
                'Customer.last_name',
                'Customer.first_name',
                'cost'
            ),
            'joins' => array(

                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Event.customer_id = Customer.id')
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
            'conditions' => array('Event.car_id' => $id, 'EventEventType.event_type_id' => array(12))
        );

        $this->set('contraventions', $this->paginate('Event'));

        $this->Event->recursive = 2;
        $currentDate = date("Y-m-d");
        $eventAssurance = $this->Event->find('first', array(
            'recursive' => -1,
            'fields' => array(
                'Event.id',
                'date',
                'next_date',
                'cost'

            ),
            'joins' => array(
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
            'conditions' => array(
                'Event.car_id' => $id,
                'Event.date <= ' => $currentDate,
                'Event.next_date >= ' => $currentDate,
                'EventEventType.event_type_id' => 2
            )
        ));
        $this->set('eventAssurance', $eventAssurance);
        $amortization = $this->amortization($id);

        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => 1,
            'order' => array('CustomerCar.id' => 'DESC'),
            'fields' => array(
                'CustomerCar.id',
                'start',
                'end',
                'Customer.first_name',
                'Customer.last_name',
                'Customer.company'
            ),
            'joins' => array(
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('CustomerCar.customer_id = Customer.id')
                )
            ),
            'conditions' => array('CustomerCar.car_id' => $id)
        );


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
            'conditions' => array('article_id' => $id, 'rubric_id' => 1),
            'paramType' => 'querystring',

        );

        $audits = $this->Paginator->paginate('Audit', "Audit.user_id != 1");

        $this->set('audits', $audits);

        if ($this->Session->read('cafyb') == 1) {
            $payments = $this->Cafyb->getPaymentsByCarId($id);
            $this->set('payments', $payments);
        } else {
            if (
                Configure::read("gestion_commercial") == '1'  &&
                Configure::read("tresorerie") == '1'
            ) {
                $payments = $this->Payment->find(
                    'all',
                    array(
                        'conditions' => array('Payment.car_id' => $id), 'recursive' => -1,
                        'fields' => array(
                            'Compte.num_compte',
                            'Payment.wording',
                            'Payment.receipt_date',
                            'Payment.payment_type',
                            'Payment.amount'
                        ),
                        'joins' => array(
                            array(
                                'table' => 'comptes',
                                'type' => 'left',
                                'alias' => 'Compte',
                                'conditions' => array('Payment.compte_id = Compte.id')
                            )
                        ),
                    )
                );
                $this->set('payments', $payments);
            }
        }



        $leasings = $this->Leasing->find(
            'all',
            array('conditions' => array('Leasing.car_id' => $id), 'recursive' => 1)
        );

        $this->set('leasings', $leasings);


        $monthlyKms = $this->Monthlykm->find('all', array(
            'conditions' => array('Monthlykm.car_id' => $id),
            'recursive' => 1,
            'order' => 'Monthlykm.year DESC'
        ));

        $this->set('monthlyKms', $monthlyKms);
        $yearContract = $this->Parameter->find(
            'first',
            array(
                'recursive' => -1,
                'fields' => array('val'),
                'conditions' => array('code' => array(19)),
                'order' => array('code' => 'ASC')
            )
        );
        $this->set('yearContract', $yearContract);


        $totalCostEvent = $this->Event->find('all', array(
            'recursive' => -1,
            'conditions' => array('Event.car_id' => $id),
            'fields' => array('id', 'sum(cost) as sum_cost')
        ));

        // afficher l'historique des status d'un car
        $this->loadModel('CarCarStatus');
        $carCarStatuses = $this->CarCarStatus->getCarCarStatusesByCarId($id);

        // $total_cost_consumption = $this->Consumption->find('all', array('recursive' => -1, 'conditions' => array('Consumption.car_id' => $id), 'fields' => array('id', 'sum(cost) as sum_cost')));
        // temporaire, le temps de corriger la consommation
        $totalCostConsumption = 0;
        $totalCost = $totalCostEvent[0][0]['sum_cost'] + $totalCostConsumption[0][0]['sum_cost'];

        $balanceCar = $this->isBalanceCarUsed();
        $hasPermission = $this->verifyaudit(SectionsEnum::vehicule);
        $this->set(compact('amortization', 'hasPermission', 'totalCost', 'balanceCar', 'carCarStatuses'));
    }

    /**
     * disable consumption alert
     *
     * @param int|null $id car id
     *
     * @return void
     */


    public function disableconsumptionalert($id = null)
    {
        if (!$this->Car->exists($id)) {
            throw new NotFoundException(__('Invalid car'));
        }
        $car = $this->Car->find('all', array(
            'conditions' => array(
                "Car.id" => $id
            )
        ));


        if (!empty($car)) {
            $this->Car->id = $id;
            $this->Car->saveField('alert', 2);
        }

        $this->Flash->success(__('The alert has been disabled.'));
        $this->redirect(array('action' => 'view', $id));
    }

    /**
     * @param int|null $carParc
     * @param int|null $carCategoryId
     * @return void
     */
    public function add($carParc = null, $carCategoryId = null)
    {

        if (Configure::read("cafyb") == '1') {
            $userId = 1;
        } else {
            $userId = $this->Auth->user('id');
        }
        if ($carParc == 2) {
            $offShore = $this->hasModuleOffShore();
            if ($offShore == 0) {
                $this->redirect('/');
            }
        }

        $this->verifyUserPermission(SectionsEnum::vehicule, $userId, ActionsEnum::add, "Cars", null, "Car", null);
        $this->settimeactif();

        $this->Payment->validate = $this->Payment->validate_car;
        if ($carCategoryId == 3) {
            $this->Car->validate = $this->Car->validateRemorque;
        }
        $nb_cars = count($this->Car->find(
            'list',
            array('recursive' => -1, 'conditions' => array('Car.car_category_id !=' => 3))
        ));
        $this->verifyMaxCars($nb_cars);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        $versionOfApp = $this->getVersionOfApp();
        if ($this->request->is('post')) {
            $this->verifyAttachment('Car', 'yellow_card', 'attachments/yellowcards/', 'add', 0, 0, null);
            $this->verifyAttachment('Car', 'grey_card', 'attachments/greycards/', 'add', 0, 0, null);
            $i = 1;
            foreach ($this->request->data['Car']['picture'] as $picture) {
                $this->request->data['Car']['picture' . $i] = $picture;
                $this->verifyAttachment('Car', 'picture' . $i, 'attachments/picturescar/', 'add', 1, 1, null);
                $i++;
            }
            $i = 1;
            foreach ($this->request->data['Car']['attachment'] as $attachment) {
                $this->request->data['Car']['attachment' . $i] = $attachment;
                $this->verifyAttachment('Car', 'attachment' . $i, 'attachments/cars/', 'add', 0, 0, null);
                $i++;
            }
            $this->verifyAttachment('Car', 'purchasing_attachment', 'attachments/suppliers/', 'edit', 0, 0, null);
            $this->Car->create();
            if ($versionOfApp == 'web') {
                if ($this->request->data['Car']['grey_card'] == '') {
                    $this->request->data['Car']['grey_card'] = $this->request->data['Car']['grey_card_dir'];
                }

                if ($this->request->data['Car']['yellow_card'] == '') {
                    $this->request->data['Car']['yellow_card'] = $this->request->data['Car']['yellow_card_dir'];
                }
            }

            if (Configure::read("cafyb") == '1') {
                $this->request->data['Car']['user_id'] = $this->Session->read('User.id');
            } else {
                $this->request->data['Car']['user_id'] = $this->Session->read('Auth.User.id');
            }

            $this->createDatetimeFromDate('Car', 'circulation_date');
            $this->createDatetimeFromDate('Car', 'date_approval');
            $this->createDatetimeFromDate('Car', 'purchase_date');
            $this->createDatetimeFromDate('Car', 'reception_date');
            $this->createDatetimeFromDate('Car', 'credit_date');
            $this->createDateFromDate('Car', 'date_planned_end');
            $this->createDateFromDate('Car', 'date_real_end');
            $this->request->data['Car']['car_status_id'] = 1;
            $this->request->data['Car']['km'] = $this->request->data['Car']['km_initial'];
            $this->request->data['Car']['immatr_def'] = trim($this->request->data['Car']['immatr_def']);
            if ($this->Car->save($this->request->data)) {
                if ($carParc != 2) {

                    $carId = $this->Car->getInsertID();
                    $carStatusId = 1;
                    $startDate = $currentDate = date("Y-m-d");
                    $this->addCarCarStatus($carId, $carStatusId, $startDate);

                    if (Configure::read("cafyb") == '1') {
                        $payments = $this->request->data['Payment'];
                        foreach ($payments as $payment) {
                            $this->Cafyb->addPayment($payment);
                        }
                    } else {
                        if (
                            Configure::read("gestion_commercial") == '1'  &&
                            Configure::read("tresorerie") == '1'
                        ) {
                            $supplier_id = $this->request->data['Car']['supplier_id'];
                            $nb_payment = $this->request->data['Car']['nb_payment'];
                            if ($nb_payment == 0) {
                                if (
                                    !empty($this->request->data['Payment'][0]['receipt_date']) && !empty($this->request->data['Payment'][0]['amount'])
                                    && !empty($this->request->data['Payment'][0]['payment_type']) && !empty($this->request->data['Payment'][0]['compte_id'])
                                    && !empty($supplier_id)
                                ) {
                                    $this->Payment->create();
                                    $this->request->data['Payment']['receipt_date'] = $this->request->data['Payment'][0]['receipt_date'];

                                    $this->createDateFromDate('Payment', 'receipt_date');

                                    $data['Payment']['car_id'] = $carId;
                                    $data['Payment']['supplier_id'] = $supplier_id;
                                    $data['Payment']['wording'] = $this->request->data['Payment'][0]['reference'];
                                    $data['Payment']['compte_id'] = $this->request->data['Payment'][0]['compte_id'];
                                    $data['Payment']['receipt_date'] = $this->request->data['Payment']['receipt_date'];
                                    $data['Payment']['amount'] = $this->request->data['Payment'][0]['amount'];
                                    $data['Payment']['payment_type'] = $this->request->data['Payment'][0]['payment_type'];
                                    $data['Payment']['note'] = $this->request->data['Payment'][0]['note'];
                                    $data['Payment']['user_id'] = $this->Session->read('Auth.User.id');
                                    $data['Payment']['transact_type_id'] = 2;
                                    $data['Payment']['payment_association_id'] = 1;
                                    $this->Payment->save($data);
                                    $compteId = $this->request->data['Payment'][0]['compte_id'];
                                    $amount = $this->request->data['Payment'][0]['amount'];
                                    $this->Compte->updateCompteDebit($compteId, $amount);
                                }
                            } else {
                                for ($i = 0; $i <= $nb_payment; $i++) {
                                    if ($this->request->data['Payment'][$i]) {

                                        if (
                                            !empty($this->request->data['Payment'][$i]['receipt_date']) && !empty($this->request->data['Payment'][$i]['amount'])
                                            && !empty($this->request->data['Payment'][$i]['payment_type']) && !empty($this->request->data['Payment'][$i]['compte_id'])
                                            && !empty($supplier_id)
                                        ) {
                                            $this->Payment->create();
                                            $this->request->data['Payment']['receipt_date'] = $this->request->data['Payment'][$i]['receipt_date'];
                                            $this->createDateFromDate('Payment', 'receipt_date');
                                            $data['Payment']['car_id'] = $carId;
                                            $data['Payment']['supplier_id'] = $supplier_id;
                                            $data['Payment']['wording'] = $this->request->data['Payment'][$i]['reference'];
                                            $data['Payment']['compte_id'] = $this->request->data['Payment'][$i]['compte_id'];
                                            $data['Payment']['receipt_date'] = $this->request->data['Payment']['receipt_date'];
                                            $data['Payment']['amount'] = $this->request->data['Payment'][$i]['amount'];
                                            $data['Payment']['payment_type'] = $this->request->data['Payment'][$i]['payment_type'];
                                            $data['Payment']['note'] = $this->request->data['Payment'][$i]['note'];
                                            $data['Payment']['user_id'] = $this->Session->read('Auth.User.id');
                                            $data['Payment']['transact_type_id'] = 2;
                                            $data['Payment']['payment_association_id'] = 1;
                                            $this->Payment->save($data);
                                            $compteId = $this->request->data['Payment'][$i]['compte_id'];
                                            $amount = $this->request->data['Payment'][$i]['amount'];
                                            $this->Compte->updateCompteDebit($compteId, $amount);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $year = date('Y');
                    $this->add_monthly_km($year, $this->request->data['Monthlykm'], $carId);
                    $result = 1;
                    if (isset($this->request->data['Car']['nb_leasing']) && isset($this->request->data['Leasing'])) {
                        $nb_leasing = $this->request->data['Car']['nb_leasing'];
                        $result = $this->add_leasing($nb_leasing, $this->request->data['Leasing'], $carId);
                    }
                    if ($result == 1 || $result == 3) {
                        $this->Flash->success(__('The car has been saved.'));
                    } else {
                        $this->Flash->success(__('The car has been saved but the leasing are not.'));
                    }
                } else {
                    $this->Flash->success(__('The car has been saved.'));
                }

                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The car could not be saved. Please, try again.'));
            }
        }
        $carStatuses = $this->CarStatus->getCarStatus();
        $marks = $this->Mark->getCarMarksByIdsNegation(array('Mark.id' != 0));
        $users = $this->Car->User->find('list', array('conditions' => 'User.id != 1'));
        $this->set('carCategoryId', $carCategoryId);
        if ($carCategoryId == 3) {
            $carCategories = $this->CarCategory->getCarCategoryById(3);
            $carTypes = $this->CarType->getCarTypeByConditions(array('CarTypeCarCategory.car_category_id' => 3));
            $this->set('carTypes', $carTypes);
        } else {
            $carCategories = $this->CarCategory->getCarCategoriesByIdsNegation(array(0, 3));
        }
        $fuels = $this->Fuel->getFuels('list');
        $carGroups = $this->CarGroup->getCarGroups();
        $userId = intval($this->Auth->user('id'));
        if ($this->IsAdministrator) {
            $parcs = $this->Parc->getParcs('list');
        } else {
            $parcIds = $this->getParcsUserIdsArray($userId);
            if (!empty($parcIds)) {
                $parcs = $this->Parc->getParcByIds($parcIds);
            } else {
                $parcs = $this->Parc->getParcs('list');
            }
        }
        $departments = $this->Department->getDepartments();

        if ($carParc == 2) {
            // get Subcontractors
            $suppliers = $this->Supplier->getSuppliersByParams(0, 1, array(1));
        } else {
            // get suppliers (not customers)
            $suppliers = $this->Supplier->getSuppliersByParams(0, 1);
        }

        $acquisitionTypes = $this->AcquisitionType->getAcquisitionTypesByIds(array(1, 4));
        $acquisitionTypesLeasing = $this->AcquisitionType->getAcquisitionTypesByIds(array(2, 3));
        $autocode = $this->getNextCode("Car", 'car');
        if (Configure::read("cafyb") == '1') {
            $comptes = $this->Cafyb->getAccounts();
            $paymentMethods = $this->Cafyb->getPaymentMethods();
        } else {
            $comptes = $this->Payment->Compte->find('list');
        }
        $this->set(compact(
            'carParc',
            'carGroups',
            'carStatuses',
            'marks',
            'users',
            'carCategories',
            'fuels',
            'parcs',
            'suppliers',
            'departments',
            'autocode',
            'acquisitionTypes',
            'versionOfApp',
            'acquisitionTypesLeasing',
            'comptes',
            'paymentMethods'
        ));
    }


    public function add_monthly_km($year = null, $kms = null, $car_id = null)
    {
        if (!empty($kms)) {

            $km_year = $this->Monthlykm->find('first', array(
                'conditions' => array('Monthlykm.car_id' => $car_id, 'Monthlykm.year' => $year),
                'recursive' => -1
            ));

            if (!empty($km_year)) {
                for ($i = 1; $i <= 12; $i++) {
                    $data['Monthlykm']['km_' . $i] = $kms['km_' . $i];
                }
                $data['Monthlykm']['id'] = $km_year['Monthlykm']['id'];
                $this->Monthlykm->save($data);
            } else {


                for ($i = 1; $i <= 12; $i++) {
                    $data['Monthlykm']['km_' . $i] = $kms['km_' . $i];
                }
                $data['Monthlykm']['car_id'] = $car_id;
                $data['Monthlykm']['year'] = $year;

                $this->Monthlykm->save($data);
            }
        }
    }

    /**
     * Add Leasing
     *
     * @throws NotFoundException
     * @param int|null $nb_leasing
     * @param array|null $leasing
     * @param int|null $car_id
     * @return int $result
     */

    public function add_leasing($nb_leasing = null, $leasing = null, $car_id = null)
    {
        $result = 1;
        if (intval($nb_leasing) == 0) {

            $result = 3;
            if (
                !empty($leasing[0]['reception_date']) && !empty($leasing[0]['km_year'])
                && !empty($leasing[0]['reception_km'])
                && !empty($leasing[0]['cost_km']) && !empty($leasing[0]['amont_month'])
            ) {

                $this->Leasing->create();
                $this->request->data['Leasing']['reception_date'] = $leasing[0]['reception_date'];
                $this->createDateFromDate('Leasing', 'reception_date');
                $this->request->data['Leasing']['end_date'] = $leasing[0]['end_date'];
                $this->createDateFromDate('Leasing', 'end_date');
                $this->request->data['Leasing']['end_real_date'] = $leasing[0]['end_real_date'];
                $this->createDateFromDate('Leasing', 'end_real_date');

                $data['Leasing']['car_id'] = $car_id;

                $data['Leasing']['supplier_id'] = $leasing[0]['supplier_id'];
                if (!empty($leasing[0]['acquisition_type_id'])) {
                    $data['Leasing']['acquisition_type_id'] = $leasing[0]['acquisition_type_id'];
                } else {
                    $data['Leasing']['acquisition_type_id'] = 3;
                }

                $data['Leasing']['reception_date'] = $this->request->data['Leasing']['reception_date'];
                $data['Leasing']['end_date'] = $this->request->data['Leasing']['end_date'];
                $data['Leasing']['end_real_date'] = $this->request->data['Leasing']['end_real_date'];
                $data['Leasing']['num_contract'] = $leasing[0]['num_contract'];
                $data['Leasing']['reception_km'] = $leasing[0]['reception_km'];
                $data['Leasing']['cost_km'] = $leasing[0]['cost_km'];
                $data['Leasing']['amont_month'] = $leasing[0]['amont_month'];
                $data['Leasing']['km_year'] = $leasing[0]['km_year'];
                $this->request->data['Leasing']['attachment'] = $leasing[0]['attachment'];
                $this->verifyAttachment('Leasing', 'attachment', 'attachments/leasings/', 'add', 1, 0, null);
                $data['Leasing']['attachment'] = $this->request->data['Leasing']['attachment'];
                if (Configure::read("cafyb") == '1') {
                    $data['Leasing']['user_id'] = $this->Session->read('User.id');
                } else {
                    $data['Leasing']['user_id'] = $this->Session->read('Auth.User.id');
                }


                if ($this->Leasing->save($data)) {
                    $car = $this->Car->find('first', array(
                        'recursive' => -1,
                        'conditions' => array('id' => (int)$car_id)
                    ));
                    if (empty($car['Car']['km'])) {
                        $this->Car->id = $car_id;
                        $this->Car->saveField('km', $leasing[0]['reception_km']);
                    }
                    $result = 1;
                } else {
                    $result = 2;
                }
            }
        } else {
            for ($j = 0; $j <= $nb_leasing; $j++) {
                if (!empty($leasing[$j])) {

                    if (
                        !empty($leasing[$j]['reception_date']) &&
                        !empty($leasing[$j]['km_year']) && !empty($leasing[$j]['reception_km'])
                        && !empty($leasing[$j]['cost_km']) && !empty($leasing[$j]['amont_month'])
                    ) {
                        $this->Leasing->create();
                        $this->request->data['Leasing']['reception_date'] = $leasing[$j]['reception_date'];
                        $this->createDateFromDate('Leasing', 'reception_date');

                        $this->request->data['Leasing']['end_date'] = $leasing[0]['end_date'];
                        $this->createDateFromDate('Leasing', 'end_date');
                        $this->request->data['Leasing']['end_real_date'] = $leasing[$j]['end_real_date'];
                        $this->createDateFromDate('Leasing', 'end_real_date');

                        $data['Leasing']['car_id'] = $car_id;
                        $data['Leasing']['supplier_id'] = $leasing[$j]['supplier_id'];
                        if (!empty($leasing[$j]['acquisition_type_id'])) {
                            $data['Leasing']['acquisition_type_id'] = $leasing[$j]['acquisition_type_id'];
                        } else {
                            $data['Leasing']['acquisition_type_id'] = 3;
                        }
                        $data['Leasing']['reception_date'] = $this->request->data['Leasing']['reception_date'];
                        $data['Leasing']['end_date'] = $this->request->data['Leasing']['end_date'];
                        $data['Leasing']['end_real_date'] = $this->request->data['Leasing']['end_real_date'];
                        $data['Leasing']['num_contract'] = $leasing[$j]['num_contract'];
                        $data['Leasing']['reception_km'] = $leasing[$j]['reception_km'];
                        $data['Leasing']['cost_km'] = $leasing[$j]['cost_km'];
                        $data['Leasing']['amont_month'] = $leasing[$j]['amont_month'];
                        $data['Leasing']['km_year'] = $leasing[$j]['km_year'];
                        $this->request->data['Leasing']['attachment'] = $leasing[$j]['attachment'];
                        $this->verifyAttachment('Leasing', 'attachment', 'attachments/leasings/', 'add', 1, 0, null);
                        $data['Leasing']['attachment'] = $this->request->data['Leasing']['attachment'];
                        if (Configure::read("cafyb") == '1') {
                            $data['Leasing']['user_id'] = $this->Session->read('User.id');
                        } else {
                            $data['Leasing']['user_id'] = $this->Session->read('Auth.User.id');
                        }
                        if ($this->Leasing->save($data)) {
                            $car = $this->Car->find(
                                'first',
                                array('conditions' => array('Car.' . $this->Car->primaryKey => $car_id))
                            );
                            $this->set('car', $car);
                            if (empty($car['Car']['km'])) {
                                $this->Car->id = $car_id;
                                $this->Car->saveField('km', $leasing[$j]['reception_km']);
                            }
                            if ($result != 2) {
                                $result = 1;
                            }
                        } else {
                            $result = 2;
                        }
                    }
                }
            }
        }
        return $result;
    }

    public function edit($id = null, $carCategoryId = null)
    {
        if (Configure::read("cafyb") == '1') {
            $userId = 1;
        } else {
            $userId = $this->Auth->user('id');
        }
        $this->verifyUserPermission(SectionsEnum::vehicule, $userId, ActionsEnum::edit, "Cars", $id, "Car", null);


        $this->settimeactif();
        $this->Payment->validate = $this->Payment->validate_car;

        if ($carCategoryId == 3) {
            $this->Car->validate = $this->Car->validateRemorque;
        }

        if (!$this->Car->exists($id)) {
            throw new NotFoundException(__('Invalid car'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->closeItemOpened('Car', $id);
                $this->Flash->error(__('Changes were not saved. Car cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $carParc = $this->request->data['Car']['car_parc'];
            if ($this->request->data['Car']['file_yellow'] == '') {
                $this->deleteAttachment('Car', 'yellow_card', 'attachments/yellowcards/', $id);
                $this->verifyAttachment('Car', 'yellow_card', 'attachments/yellowcards/', 'add', 0, 0, $id);
            } else {
                $this->verifyAttachment('Car', 'yellow_card', 'attachments/yellowcards/', 'edit', 0, 0, $id);
            }
            if ($this->request->data['Car']['file_grey'] == '') {
                $this->deleteAttachment('Car', 'grey_card', 'attachments/greycards/', $id);
                $this->verifyAttachment('Car', 'grey_card', 'attachments/greycards/', 'add', 0, 0, $id);
            } else {
                $this->verifyAttachment('Car', 'grey_card', 'attachments/greycards/', 'edit', 0, 0, $id);
            }


            if ($this->request->data['Car']['file1'] == '') {
                $this->deleteAttachment('Car', 'picture1', 'attachments/picturescar/', $id);
                $this->verifyAttachment('Car', 'picture1', 'attachments/picturescar/', 'add', 1, 1, $id);
            } else {
                $this->verifyAttachment('Car', 'picture1', 'attachments/picturescar/', 'edit', 1, 1, $id);
            }

            if ($this->request->data['Car']['file2'] == '') {
                $this->deleteAttachment('Car', 'picture2', 'attachments/picturescar/', $id);
                $this->verifyAttachment('Car', 'picture2', 'attachments/picturescar/', 'add', 1, 1, $id);
            } else {
                $this->verifyAttachment('Car', 'picture2', 'attachments/picturescar/', 'edit', 1, 1, $id);
            }


            if ($this->request->data['Car']['file3'] == '') {
                $this->deleteAttachment('Car', 'picture3', 'attachments/picturescar/', $id);
                $this->verifyAttachment('Car', 'picture3', 'attachments/picturescar/', 'add', 1, 1, $id);
            } else {
                $this->verifyAttachment('Car', 'picture3', 'attachments/picturescar/', 'edit', 1, 1, $id);
            }
            if ($this->request->data['Car']['file4'] == '') {
                $this->deleteAttachment('Car', 'picture4', 'attachments/picturescar/', $id);
                $this->verifyAttachment('Car', 'picture4', 'attachments/picturescar/', 'add', 1, 1, $id);
            } else {
                $this->verifyAttachment('Car', 'picture4', 'attachments/picturescar/', 'edit', 1, 1, $id);
            }

            $i = $this->request->data['Car']['nb_picture'] + 1;
            foreach ($this->request->data['Car']['picture'] as $picture) {
                $this->request->data['Car']['picture' . $i] = $picture;

                $this->verifyAttachment('Car', 'picture' . $i, 'attachments/picturescar/', 'add', 1, 1, null);
                $i++;
            }

            if ($this->request->data['Car']['att1'] == '') {
                $this->deleteAttachment('Car', 'attachment1', 'attachments/cars/', $id);
                $this->verifyAttachment('Car', 'attachment1', 'attachments/cars/', 'add', 0, 0, $id);
            } else {
                $this->verifyAttachment('Car', 'attachment1', 'attachments/cars/', 'edit', 0, 0, $id);
            }

            if ($this->request->data['Car']['att2'] == '') {
                $this->deleteAttachment('Car', 'attachment2', 'attachments/cars/', $id);
                $this->verifyAttachment('Car', 'attachment2', 'attachments/cars/', 'add', 0, 0, $id);
            } else {
                $this->verifyAttachment('Car', 'attachment2', 'attachments/cars/', 'edit', 0, 0, $id);
            }

            if ($this->request->data['Car']['att3'] == '') {
                $this->deleteAttachment('Car', 'attachment3', 'attachments/cars/', $id);
                $this->verifyAttachment('Car', 'attachment3', 'attachments/cars/', 'add', 0, 0, $id);
            } else {
                $this->verifyAttachment('Car', 'attachment3', 'attachments/cars/', 'edit', 0, 0, $id);
            }

            if ($this->request->data['Car']['att4'] == '') {
                $this->deleteAttachment('Car', 'attachment4', 'attachments/cars/', $id);
                $this->verifyAttachment('Car', 'attachment4', 'attachments/cars/', 'add', 0, 0, $id);
            } else {
                $this->verifyAttachment('Car', 'attachment4', 'attachments/cars/', 'edit', 0, 0, $id);
            }

            if ($this->request->data['Car']['att5'] == '') {
                $this->deleteAttachment('Car', 'attachment5', 'attachments/cars/', $id);
                $this->verifyAttachment('Car', 'attachment5', 'attachments/cars/', 'add', 0, 0, $id);
            } else {
                $this->verifyAttachment('Car', 'attachment5', 'attachments/cars/', 'edit', 0, 0, $id);
            }

            $i = $this->request->data['Car']['nb_attachment'] + 1;;
            foreach ($this->request->data['Car']['attachment'] as $attachment) {
                $this->request->data['Car']['attachment' . $i] = $attachment;

                $this->verifyAttachment('Car', 'attachment' . $i, 'attachments/cars/', 'add', 0, 0, null);
                $i++;
            }

            if ($carParc != 2) {

                if ($this->request->data['Car']['purchasing'] == '') {
                    $this->deleteAttachment('Car', 'purchasing_attachment', 'attachments/suppliers/', $id);
                }
                $this->verifyAttachment('Car', 'purchasing_attachment', 'attachments/suppliers/', 'edit', 0, 0, $id);

                $this->createDatetimeFromDate('Car', 'date_approval');
                $this->createDatetimeFromDate('Car', 'purchase_date');
                $this->createDatetimeFromDate('Car', 'reception_date');
                $this->createDatetimeFromDate('Car', 'credit_date');
            }
            $this->createDatetimeFromDate('Car', 'circulation_date');
            $versionOfApp = $this->getVersionOfApp();
            if ($versionOfApp == 'web') {
                if ($this->request->data['Car']['yellow_card_dir'] != '') {

                    $this->request->data['Car']['yellow_card'] = $this->request->data['Car']['yellow_card_dir'];
                }

                if ($this->request->data['Car']['grey_card_dir'] != '') {

                    $this->request->data['Car']['grey_card'] = $this->request->data['Car']['grey_card_dir'];
                }
            }

            $this->closeItemOpened('Car', $id);
            if (Configure::read("cafyb") == '1') {
                $this->request->data['Car']['modified_id'] = $this->Session->read('User.id');
            } else {
                $this->request->data['Car']['modified_id'] = $this->Session->read('Auth.User.id');
            }
            $carStatusId = $this->request->data['Car']['car_status_id'];
            $this->createDatetimeFromDate('Car', 'status_date');
            $endDate = $this->request->data['Car']['status_date'];
            $startDate = $this->request->data['Car']['status_date'];
            if ($this->Car->save($this->request->data)) {
                if (!empty($endDate)) {
                    $this->updateCarCarStatus($id, $endDate);
                    $this->addCarCarStatus($id, $carStatusId, $startDate);
                }
                if ($carParc != 2) {
                    if (Configure::read("cafyb") == '1') {
                        $payments = $this->request->data['Payment'];
                        $this->Cafyb->savePayments($payments);
                    } else {
                        if (
                            Configure::read("gestion_commercial") == '1'  &&
                            Configure::read("tresorerie") == '1'
                        ) {
                            $payments = $this->Payment->find('all', array(
                                'conditions' => array('Payment.car_id' => $id),
                                'recursive' => -1,
                                'fields' => array('Payment.id', 'Payment.amount', 'Payment.compte_id', 'Supplier.id'),
                                'joins' => array(
                                    array(
                                        'table' => 'suppliers',
                                        'type' => 'left',
                                        'alias' => 'Supplier',
                                        'conditions' => array('Supplier.id = Payment.supplier_id')
                                    ),
                                )

                            ));
                            if (!empty($payments)) {
                                foreach ($payments as $payment) {

                                    $precedentCompteId = $payment['Payment']['compte_id'];
                                    $precedentAmount = $payment['Payment']['amount'];
                                    $compteId = $payment['Payment']['compte_id'];

                                    if ($this->Payment->deleteAll(array('Payment.id' => $payment['Payment']['id']), false)) {
                                        $this->Compte->updateCompteDebit($compteId, 0, $precedentCompteId, $precedentAmount);
                                    }
                                }
                            }
                            $supplier_id = $this->request->data['Car']['supplier_id'];
                            $nb_payment = $this->request->data['Car']['nb_payment'];

                            if ($nb_payment == 0) {

                                if (
                                    !empty($this->request->data['Payment'][0]['amount']) && !empty($this->request->data['Payment'][0]['receipt_date'])
                                    && !empty($this->request->data['Payment'][0]['payment_type']) && !empty($this->request->data['Payment'][0]['compte_id'])
                                    && !empty($supplier_id)
                                ) {

                                    $this->Payment->create();
                                    $this->request->data['Payment']['receipt_date'] = $this->request->data['Payment'][0]['receipt_date'];
                                    $this->createDateFromDate('Payment', 'receipt_date');
                                    $data['Payment']['car_id'] = $id;
                                    $data['Payment']['supplier_id'] = $supplier_id;
                                    $data['Payment']['wording'] = $this->request->data['Payment'][0]['reference'];
                                    $data['Payment']['compte_id'] = $this->request->data['Payment'][0]['compte_id'];
                                    $data['Payment']['modified_id'] = $this->Session->read('Auth.User.id');
                                    $data['Payment']['transact_type_id'] = 2;
                                    $data['Payment']['receipt_date'] = $this->request->data['Payment']['receipt_date'];
                                    $data['Payment']['amount'] = $this->request->data['Payment'][0]['amount'];
                                    $data['Payment']['payment_type'] = $this->request->data['Payment'][0]['payment_type'];
                                    $data['Payment']['note'] = $this->request->data['Payment'][0]['note'];
                                    $data['Payment']['payment_association_id'] = 1;
                                    $this->Payment->save($data);

                                    $compteId = $this->request->data['Payment'][0]['compte_id'];
                                    $amount = $this->request->data['Payment'][0]['amount'];

                                    $this->Compte->updateCompteDebit($compteId, $amount);
                                }
                            } else {
                                for ($i = 0; $i < $nb_payment; $i++) {
                                    if ($this->request->data['Payment'][$i]) {
                                        if (
                                            !empty($this->request->data['Payment'][$i]['amount']) && !empty($this->request->data['Payment'][$i]['receipt_date']) &&
                                            !empty($this->request->data['Payment'][$i]['payment_type']) && !empty($this->request->data['Payment'][$i]['compte_id'])
                                            && !empty($supplier_id)
                                        ) {
                                            $this->Payment->create();
                                            $this->request->data['Payment']['receipt_date'] = $this->request->data['Payment'][$i]['receipt_date'];
                                            $this->createDateFromDate('Payment', 'receipt_date');
                                            $data['Payment']['car_id'] = $id;
                                            $data['Payment']['supplier_id'] = $supplier_id;
                                            $data['Payment']['wording'] = $this->request->data['Payment'][$i]['reference'];
                                            $data['Payment']['compte_id'] = $this->request->data['Payment'][$i]['compte_id'];
                                            $data['Payment']['user_id'] = $this->Session->read('Auth.User.id');
                                            $data['Payment']['receipt_date'] = $this->request->data['Payment']['receipt_date'];
                                            $data['Payment']['amount'] = $this->request->data['Payment'][$i]['amount'];
                                            $data['Payment']['payment_type'] = $this->request->data['Payment'][$i]['payment_type'];
                                            $data['Payment']['note'] = $this->request->data['Payment'][$i]['note'];
                                            $data['Payment']['payment_association_id'] = 1;
                                            $this->Payment->save($data);
                                            $compteId = $this->request->data['Payment'][$i]['compte_id'];
                                            $amount = $this->request->data['Payment'][$i]['amount'];

                                            $this->Compte->updateCompteDebit($compteId, $amount);
                                        }
                                    }
                                }
                            }
                        }
                    }


                    $leasings = $this->Leasing->find(
                        'all',
                        array('conditions' => array('Leasing.car_id' => $id), 'recursive' => -1)
                    );

                    if (!empty($leasings)) {

                        $this->Leasing->deleteAll(array('Leasing.car_id' => $id), false);
                    }
                    $nb_leasing = $this->request->data['Car']['nb_leasing'];
                    $result = $this->add_leasing($nb_leasing, $this->request->data['Leasing'], $id);
                } else {
                    $result = 1;
                }
                $year = date('Y');

                $this->add_monthly_km($year, $this->request->data['Monthlykm'], $id);


                if ($result == 1 || $result == 3) {
                    $this->Flash->success(__('The car has been saved.'));
                } else {
                    $this->Flash->success(__('The car has been saved but the leasing are not.'));
                }
                if (Configure::read("cafyb") == '0') {
                    $this->saveUserAction(SectionsEnum::vehicule, $id, $this->Session->read('Auth.User.id'), ActionsEnum::edit);
                }

                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The car could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Car.' . $this->Car->primaryKey => $id));
            $this->request->data = $this->Car->find('first', $options);
            if ($this->Session->read('cafyb') == 1) {
                $payments = $this->Cafyb->getPaymentsByCarId($id);
                $nb_payment = count($payments);
                $this->set(compact('nb_payment', 'payments'));
            } else {
                if (
                    Configure::read("gestion_commercial") == '1'  &&
                    Configure::read("tresorerie") == '1'
                ) {
                    $nb_payment = $this->Payment->find('count', array(
                        'conditions' => array('Payment.car_id' => $id)
                    ));
                    $payments = $this->Payment->find('all', array(
                        'recursive' => -1,
                        'conditions' => array('Payment.car_id' => $id)
                    ));
                    $this->set(compact('nb_payment', 'payments'));
                }
            }


            $nb_leasing = $this->Leasing->find('count', array(
                'conditions' => array('Leasing.car_id' => $id)
            ));
            $leasings = $this->Leasing->find('all', array(
                'recursive' => -1,
                'conditions' => array('Leasing.car_id' => $id)
            ));


            $this->set(compact('nb_leasing', 'leasings'));

            $year = date('Y');
            $monthlykms = $this->Monthlykm->find('first', array(
                'recursive' => -1,
                'conditions' => array('Monthlykm.car_id' => $id, 'Monthlykm.year' => $year)
            ));

            $this->set(compact('monthlykms'));

            if ($this->request->data['Car']['locked'] == 1) {
                $this->Flash->error(__('You must first unlock the car.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->isOpenedByOtherUser("Car", "Cars", "car", $id);
        }
        $carStatuses = $this->CarStatus->getCarStatus();
        $marks = $this->Mark->getCarMarksByIdsNegation(array('Mark.id' != 0));
        $carmodels = $this->Carmodel->getCarModelsByMark($this->request->data['Car']['mark_id']);
        $conditions = array('CarTypeCarCategory.car_category_id' => $carCategoryId);
        $carTypes = $this->CarType->getCarTypeByConditions($conditions);
        $users = $this->Car->User->find('list', array('conditions' => 'User.id != 1'));
        $this->set('carCategoryId', $carCategoryId);
        if ($carCategoryId == 3) {
            $carCategories = $this->CarCategory->getCarCategoryById(3);
        } else {
            $carCategories = $this->CarCategory->getCarCategoriesByIdsNegation(array(0, 3));
        }

        $carGroups = $this->CarGroup->getCarGroups();
        $this->set('carCategoryId', $carCategoryId);
        $fuels = $this->Fuel->getFuels('list');
        $userId = intval($this->Auth->user('id'));
        if ($this->IsAdministrator) {
            $parcs = $this->Parc->getParcs('list');
        } else {
            $parcIds = $this->getParcsUserIdsArray($userId);
            if (!empty($parcIds)) {
                $parcs = $this->Parc->getParcByIds($parcIds);
            } else {
                $parcs = $this->Parc->getParcs('list');
            }
        }
        $departments = $this->Department->getDepartments();
        $carParc = $this->request->data['Car']['car_parc'];
        if ($carParc == 2) {
            $suppliers = $this->Supplier->getSuppliersByParams(0, 1, array(1));
        } else {
            $suppliers = $this->Supplier->getSuppliersByParams(0, 1);
        }
        $acquisitionTypes = $this->AcquisitionType->getAcquisitionTypesByIds(array(1, 4));
        $acquisitionTypesLeasing = $this->AcquisitionType->getAcquisitionTypesByIds(array(2, 3));
        $versionOfApp = $this->getVersionOfApp();
        $autocode = $this->getNextCode("Car", 'car');
        if (Configure::read("cafyb") == '1') {
            $comptes = $this->Cafyb->getAccounts();
            $paymentMethods = $this->Cafyb->getPaymentMethods();
        } else {
            $comptes = $this->Payment->Compte->find('list');
        }
        $this->set(compact(
            'carStatuses',
            'marks',
            'carmodels',
            'carTypes',
            'users',
            'carGroups',
            'carCategories',
            'fuels',
            'parcs',
            'suppliers',
            'departments',
            'autocode',
            'acquisitionTypes',
            'versionOfApp',
            'acquisitionTypesLeasing',
            'comptes',
            'paymentMethods'
        ));
    }

    /** mettre a jour date fin d'un status d'un car deja existant
     * @param $carId
     * @param $endDate
     */
    public function updateCarCarStatus($carId, $endDate)
    {
        $this->loadModel('CarCarStatus');
        $data = array();
        $carCarStatus = $this->CarCarStatus->getLastCarCarStatusByCarId($carId);
        $data['CarCarStatus']['id'] = $carCarStatus['CarCarStatus']['id'];
        $data['CarCarStatus']['end_date'] = $endDate;
        $this->CarCarStatus->save($data);
    }

    public function saveCopy($id = null)
    {
        $this->settimeactif();

        $user_id = $this->Auth->user('id');

        $this->verifyUserPermission(SectionsEnum::vehicule, $user_id, ActionsEnum::add, "Cars", null, "Car", null);


        if ($this->request->is(array('post', 'put'))) {

            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Car cancelled.'));
                $this->redirect(array('action' => 'index'));
            }

            if ($this->request->data['Car']['file_yellow'] == '') {
                $this->deleteAttachment('Car', 'yellow_card', 'attachments/yellowcards/', $id);
                $this->verifyAttachment('Car', 'yellow_card', 'attachments/yellowcards/', 'add', 1, 0, $id);
            } else {
                $this->verifyAttachment('Car', 'yellow_card', 'attachments/yellowcards/', 'edit', 1, 0, $id);
            }
            if ($this->request->data['Car']['file_grey'] == '') {
                $this->deleteAttachment('Car', 'grey_card', 'attachments/greycards/', $id);
                $this->verifyAttachment('Car', 'grey_card', 'attachments/greycards/', 'add', 1, 0, $id);
            } else {
                $this->verifyAttachment('Car', 'grey_card', 'attachments/greycards/', 'edit', 1, 0, $id);
            }


            if ($this->request->data['Car']['file1'] == '') {
                $this->deleteAttachment('Car', 'picture1', 'attachments/picturescar/', $id);
                $this->verifyAttachment('Car', 'picture1', 'attachments/picturescar/', 'add', 1, 1, $id);
            } else {
                $this->verifyAttachment('Car', 'picture1', 'attachments/picturescar/', 'edit', 1, 1, $id);
            }

            if ($this->request->data['Car']['file2'] == '') {
                $this->deleteAttachment('Car', 'picture2', 'attachments/picturescar/', $id);
                $this->verifyAttachment('Car', 'picture2', 'attachments/picturescar/', 'add', 1, 1, $id);
            } else {
                $this->verifyAttachment('Car', 'picture2', 'attachments/picturescar/', 'edit', 1, 1, $id);
            }


            if ($this->request->data['Car']['file3'] == '') {
                $this->deleteAttachment('Car', 'picture3', 'attachments/picturescar/', $id);
                $this->verifyAttachment('Car', 'picture3', 'attachments/picturescar/', 'add', 1, 1, $id);
            } else {
                $this->verifyAttachment('Car', 'picture3', 'attachments/picturescar/', 'edit', 1, 1, $id);
            }
            if ($this->request->data['Car']['file4'] == '') {
                $this->deleteAttachment('Car', 'picture4', 'attachments/picturescar/', $id);
                $this->verifyAttachment('Car', 'picture4', 'attachments/picturescar/', 'edit', 1, 1, $id);
            } else {
                $this->verifyAttachment('Car', 'picture4', 'attachments/picturescar/', 'edit', 1, 1, $id);
            }
            if ($this->request->data['Car']['purchasing'] == '') {
                $this->deleteAttachment('Car', 'purchasing_attachment', 'attachments/suppliers/', $id);
            }
            $this->verifyAttachment('Car', 'purchasing_attachment', 'attachments/suppliers/', 'add', 1, 0, $id);
            $this->createDatetimeFromDate('Car', 'circulation_date');
            $this->createDatetimeFromDate('Car', 'date_approval');
            $this->createDatetimeFromDate('Car', 'purchase_date');
            $this->createDatetimeFromDate('Car', 'reception_date');
            $this->createDatetimeFromDate('Car', 'credit_date');

            if ($this->request->data['Car']['yellow_card_dir'] != '') {

                $this->request->data['Car']['yellow_card'] = $this->request->data['Car']['yellow_card_dir'];
            }

            if ($this->request->data['Car']['grey_card_dir'] != '') {

                $this->request->data['Car']['grey_card'] = $this->request->data['Car']['grey_card_dir'];
            }

            $this->request->data['Car']['is_open'] = 0;
            $this->request->data['Car']['car_status_id'] = 1;
            if (Configure::read("cafyb") == '1') {
                $this->request->data['Car']['user_id'] = $this->Session->read('User.id');
            } else {
                $this->request->data['Car']['user_id'] = $this->Session->read('Auth.User.id');
            }
            $code = $this->getNextCode('Car', 'car');

            if ($code != 0) {
                $this->request->data['Car']['code'] = $code;
            }
            $this->Car->create();
            if ($this->Car->save($this->request->data)) {

                $this->Flash->success(__('The car has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The car could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Car.' . $this->Car->primaryKey => $id));
            $this->request->data = $this->Car->find('first', $options);
            if ($this->request->data['Car']['locked'] == 1) {
                $this->Flash->error(__('You must first unlock the car.'));
                $this->redirect(array('action' => 'index'));
            }
        }
        $carStatuses = $this->CarStatus->getCarStatus();
        $marks = $this->Mark->getCarMarksByIdsNegation(array('Mark.id' != 0));
        $carmodels = $this->Carmodel->getCarModelsByMark($this->request->data['Car']['mark_id']);
        $carTypes = $this->CarType->getCarTypes();
        $users = $this->Car->User->find('list', array('conditions' => 'User.id != 1'));
        $carCategories = $this->CarCategory->getCarCategories();
        $fuels = $this->Fuel->getFuels('list');
        if ($this->IsAdministrator) {
            $parcs = $this->Parc->getParcs('list');
        } else {
            $parcIds = $this->getParcsUserIdsArray($user_id);
            if (!empty($parcIds)) {
                $parcs = $this->Parc->getParcByIds($parcIds);
            } else {
                $parcs = $this->Parc->getParcs('list');
            }
        }
        $departments = $this->Department->getDepartments();
        $suppliers = $this->Supplier->getSuppliersByParams(0, 1);

        $acquisitionTypes = $this->AcquisitionType->getAcquisitionTypes('list');
        $autocode = $this->getNextCode("Car", 'car');
        $this->set(compact(
            'carStatuses',
            'marks',
            'carmodels',
            'carTypes',
            'users',
            'carCategories',
            'fuels',
            'parcs',
            'suppliers',
            'departments',
            'autocode',
            'acquisitionTypes'
        ));
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
        if (Configure::read("cafyb") == '1') {
            if ($this->Session->read('Permission.car.delete') == 0) {
                $this->Flash->error(__("You don't have permission to delete."));
                return $this->redirect(array('controller' => 'cars', 'action' => 'index'));
            } else {
                $this->Auth->allow();
            }
        } else {
            $userId = $this->Auth->user('id');
            $this->verifyUserPermission(SectionsEnum::vehicule, $userId, ActionsEnum::delete, "Cars", $id, "Car", null);
        }

        $this->settimeactif();
        $this->Car->id = $id;
        if (!$this->Car->exists()) {
            throw new NotFoundException(__('Invalid car'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        $current = $this->Car->find("first", array("conditions" => array("Car.id" => $id)));
        if ($current['Car']['locked']) {
            $this->Flash->error(__('You must first unlock the car.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Car->delete()) {
            if (Configure::read("cafyb") == '0') {
                $this->saveUserAction(SectionsEnum::vehicule, $id, $this->Session->read('Auth.User.id'), ActionsEnum::delete);
            }
            $this->Flash->success(__('The car has been deleted.'));
        } else {
            $this->Flash->error(__('The car could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    private function verifyDependences($id)
    {
        $this->settimeactif();
        $events = $this->Event->find('first', array("conditions" => array("Event.car_id =" => $id)));
        if (!empty($events)) {
            $this->Flash->error(__('The car could not be deleted. '
                . 'Please remove dependencies with events in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        $reservations = $this->CustomerCar->find('first', array("conditions" => array("CustomerCar.car_id =" => $id)));
        if (!empty($reservations)) {
            $this->Flash->error(__('The car could not be deleted. '
                . 'Please remove dependencies with reservations in advance.'));
            $this->redirect(array('action' => 'index'));
        }

        $results = $this->SheetRide->getSheetRidesByCar($id);
        if (!empty($results)) {
            $this->Flash->error(__('The car could not be deleted. '
                . 'Please remove dependencies with reservations in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Session->read('cafyb') == 1) {
            $this->Cafyb->deletePaymentsByCarId($id);
        } else {
            $payments = $this->Payment->find('all', array(
                'conditions' => array('Payment.car_id' => $id),
                'recursive' => -1,
                'fields' => array('Payment.id', 'Payment.amount', 'Payment.compte_id', 'Supplier.id'),
                'joins' => array(
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('Supplier.id = Payment.supplier_id')
                    ),
                )

            ));
            if (!empty($payments)) {
                foreach ($payments as $payment) {

                    $precedentCompteId = $payment['Payment']['compte_id'];
                    $precedentAmount = $payment['Payment']['amount'];
                    $compteId = $payment['Payment']['compte_id'];

                    if ($this->Payment->deleteAll(array('Payment.id' => $payment['Payment']['id']), false)) {
                        $this->Compte->updateCompteDebit($compteId, 0, $precedentCompteId, $precedentAmount);
                    }
                }
            }
        }

        $leasings = $this->Leasing->find('all', array("conditions" => array("Leasing.car_id =" => $id)));
        if (!empty($leasings)) {
            $this->Leasing->deleteAll(array('Leasing.car_id' => $id), false);
        }
        $monthlyKms = $this->Monthlykm->find(
            'all',
            array(
                'conditions' => array(
                    'Monthlykm.car_id' => $id
                ),
                'recursive' => 1
            )
        );
        if (!empty($monthlyKms)) {
            $this->Monthlykm->deleteAll(array('Monthlykm.car_id' => $id), false);
        }
        $this->loadModel('CarCarStatus');
        $carCarStatuses = $this->CarCarStatus->find(
            'all',
            array(
                'conditions' => array(
                    'CarCarStatus.car_id' => $id
                ),
                'recursive' => 1
            )
        );
        if (!empty($carCarStatuses)) {
            $this->CarCarStatus->deleteAll(array('CarCarStatus.car_id' => $id), false);
        }
    }

    public function deletecars()
    {
        $this->settimeactif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');

        $this->verifyUserPermission(SectionsEnum::vehicule, $user_id, ActionsEnum::delete, "Cars", $id, "Car", null);
        $this->Car->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        $current = $this->Car->find("first", array("conditions" => array("Car.id" => $id)));
        if (!$current['Car']['locked']) {
            if ($this->Car->delete()) {
                echo json_encode(array("response" => "true"));
            } else {
                echo json_encode(array("response" => "false"));
            }
        } else {
            echo json_encode(array("response" => "false"));
        }
    }

    function getModels($markID = null)
    {
        $this->layout = 'ajax';
        if (isset($this->params['pass']['0']) || $markID != null) {
            if ($markID == null) {
                $markID = $this->params['pass']['0'];
            }  
            $this->layout = 'ajax';
            $this->set('selectbox', $this->Carmodel->getCarModelsByMark($markID));
            if (isset($this->params['pass']['1'])) {
                $this->set('selectedid', $this->params['pass']['1']);
            }
        } else {
            $this->set('selectbox', null);
        }
    }

    function getModelsFilters($markID = null)
    {
        if (!isset($markID) || empty($markID)) {
            $markID = 0;
        }
        $this->layout = 'ajax';
        $this->set('selectbox', $this->Carmodel->getCarModelsByMark($markID));
    }

    function addMark()
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(
            SectionsEnum::marque_pneu,
            $user_id,
            ActionsEnum::add,
            "Marks",
            null,
            "Mark",
            null,
            1
        );
        $this->set('result', $result);
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->Mark->create();
            if ($this->Mark->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $mark_id = $this->Mark->getLastInsertId();
                $this->set('mark_id', $mark_id);
            }
        }
    }

    function getMarks()
    {
        $this->settimeactif();
        $this->layout = 'ajax';
        $marks = $this->Mark->find('all', array('recursive' => -1));
        $this->set('selectbox', $marks);
        $this->set('selectedid', $this->params['pass']['0']);
    }

    function addModel()
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::modele_vehicule, $user_id, ActionsEnum::add, "Carmodels", null, "Carmodel", null, 1);
        $this->set('result', $result);
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->request->data['Carmodel']['mark_id'] = $this->params['pass']['0'];
            $this->Carmodel->create();
            if ($this->Carmodel->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $model_id = $this->Carmodel->getLastInsertId();
                $this->set('model_id', $model_id);
                $this->set('mark_id', $this->request->data['Carmodel']['mark_id']);
            }
        }
    }

    function addCategory()
    {

        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::categorie_vehicule, $user_id, ActionsEnum::add, "CarCategories", null, "CarCategory", null, 1);
        $this->set('result', $result);
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->CarCategory->create();
            if ($this->CarCategory->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $category_id = $this->CarCategory->getLastInsertId();
                $this->set('category_id', $category_id);
            }
        }
    }

    function getCategories()
    {
        $this->settimeactif();
        $this->layout = 'ajax';
        $categories = $this->CarCategory->find('all', array('recursive' => -1));
        $this->set('selectbox', $categories);
        $this->set('selectedid', $this->params['pass']['0']);
    }

    function addType()
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(
            SectionsEnum::type_vehicule,
            $user_id,
            ActionsEnum::add,
            "CarTypes",
            null,
            "CarType",
            null,
            1
        );
        $this->set('result', $result);
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->CarType->create();
            if ($this->CarType->save($this->request->data)) {
                $type_id = $this->CarType->getLastInsertId();
                $this->loadModel('CarTypeCarCategory');
                $this->CarTypeCarCategory->create();
                $data = array();
                $data['CarTypeCarCategory']['car_type_id'] = $type_id;
                $data['CarTypeCarCategory']['car_category_id'] = $this->params['pass']['0'];
                $this->CarTypeCarCategory->save($data);
                $this->set('saved', true); //only set true if data saves OK
                $this->set('type_id', $type_id);
                $this->set('category_id', $this->params['pass']['0']);
            }
        }
    }

    function getTypes($categoryId = null)
    {
        if (isset($this->params['pass']['0']) || $categoryId != null) {
            if ($categoryId == null) {
                $categoryId = $this->params['pass']['0'];
            }
            $this->settimeactif();
            $this->layout = 'ajax';
            $conditions = array('CarTypeCarCategory.car_category_id' => $categoryId);
            $types = $this->CarType->getCarTypeByConditions($conditions);
            $this->set('selectbox', $types);
            $this->set('selectedid', $this->params['pass']['1']);
        } else {
        }
    }

    function addFuel()
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::carburant, $user_id, ActionsEnum::add, "Fuels", null, "Fuel", null, 1);
        $this->set('result', $result);
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->Fuel->create();
            if ($this->Fuel->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $fuel_id = $this->Fuel->getLastInsertId();
                $this->set('fuel_id', $fuel_id);
            }
        }
    }

    function getFuels()
    {
        $this->settimeactif();
        $this->layout = 'ajax';
        $fuels = $this->Fuel->getFuels('all');
        $this->set('selectbox', $fuels);
        $this->set('selectedid', $this->params['pass']['0']);
    }

    function addGroup()
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::groupe_vehicule, $user_id, ActionsEnum::add, "CarGroups", null, "CarGroup", null, 1);
        $this->set('result', $result);
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->CarGroup->create();
            if ($this->CarGroup->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $car_group_id = $this->CarGroup->getLastInsertId();
                $this->set('car_group_id', $car_group_id);
            }
        }
    }

    function getGroups()
    {
        $this->settimeactif();
        $this->layout = 'ajax';
        $car_groups = $this->CarGroup->find('all', array('recursive' => -1));
        $this->set('selectbox', $car_groups);
        $this->set('selectedid', $this->params['pass']['0']);
    }

    function addParc()
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(
            SectionsEnum::parc_vehicule,
            $user_id,
            ActionsEnum::add,
            "Parcs",
            null,
            "Parc",
            null,
            1
        );
        $this->set('result', $result);
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->Parc->create();
            if ($this->Parc->save($this->request->data)) {
                $this->SaveParcs->saveParcUserAssociation($this->Parc->getLastInsertId(), $user_id);
                $this->set('saved', true); //only set true if data saves OK
                $parc_id = $this->Parc->getLastInsertId();
                $this->set('parc_id', $parc_id);
            }
        }
    }

    function getParcs()
    {
        $userId = $this->Auth->user('id');
        if ($this->IsAdministrator) {
            $parcs = $this->Parc->getParcs('all');
        } else {
            $parcIds = $this->getParcsUserIdsArray($userId);
            if (!empty($parcIds)) {
                $parcs = $this->Parc->getParcByIds($parcIds, 'all');
            } else {
                $parcs = $this->Parc->getParcs('all');
            }
        }
        $this->settimeactif();
        $this->layout = 'ajax';
        $this->set('selectbox', $parcs);
        $this->set('selectedid', $this->params['pass']['0']);
    }

    function addDepartment()
    {
        $this->settimeactif();
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
        $this->settimeactif();
        $this->layout = 'ajax';
        $departments = $this->Department->getDepartments('all');

        $this->set('selectbox', $departments);
        $this->set('selectedid', $this->params['pass']['0']);
    }

    function addSupplier()
    {

        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(
            SectionsEnum::fournisseur,
            $user_id,
            ActionsEnum::add,
            "Suppliers",
            null,
            "Supplier",
            0
        );
        $this->set('result', $result);
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false);
        if (isset($this->params['pass']['0'])) {
            $i = $this->params['pass']['0'];
            $this->set('i', $i);
        }
        $code = $this->getNextCodeWithPrefix('Supplier', 'supplier');
        $this->set('code', $code);
        if (!empty($this->request->data)) {
            $this->Supplier->create();
            if ($this->Supplier->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $supplier_id = $this->Supplier->getLastInsertId();
                $this->set('supplier_id', $supplier_id);
            }
        }
    }

    function getSuppliers()
    {

        $this->settimeactif();
        $this->layout = 'ajax';
        $suppliers = $this->Supplier->getSuppliersByParams(0, 1);

        $this->set('selectbox', $suppliers);
        $this->set('selectedid', $this->params['pass']['0']);
    }

    function addAcquisitionType()
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(
            SectionsEnum::type_acquisition_vehicule,
            $user_id,
            ActionsEnum::add,
            "AcquisitionTypes",
            null,
            "AcquisitionType",
            null,
            1
        );
        $this->set('result', $result);
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false);
        if (!empty($this->request->data)) {
            $this->AcquisitionType->create();
            if ($this->AcquisitionType->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $acquisition_id = $this->AcquisitionType->getLastInsertId();
                $this->set('acquisition_id', $acquisition_id);
            }
        }
    }

    function getAcquisitionTypes()
    {
        $this->settimeactif();
        $this->layout = 'ajax';
        $acquisitions = $this->AcquisitionType->getAcquisitionTypes('all');
        $this->set('selectbox', $acquisitions);
        $this->set('selectedid', $this->params['pass']['0']);
    }

    function export()
    {
        $this->settimeactif();

        if (
            isset($this->params['pass']['0']) && $this->params['pass']['0'] == "all_search" && (isset($this->params['named']['keyword']) || isset($this->params['named']['mark'])
                || isset($this->params['named']['model']) || isset($this->params['named']['category'])
                || isset($this->params['named']['type']) || isset($this->params['named']['fuel'])
                || isset($this->params['named']['status']) || isset($this->params['named']['user']) || isset($this->params['named']['modified_id'])
                || isset($this->params['named']['created']) || isset($this->params['named']['created1'])
                || isset($this->params['named']['modified']) || isset($this->params['named']['modified1'])
                || isset($this->params['named']['parc']))
        ) {
            $conditions = $this->getConds();
            $cars = $this->Car->find('all', array(
                'conditions' => $conditions,
                'Group' => 'Car.id',
                'fields' => array(
                    'Car.id',
                    'Car.code',
                    'Carmodel.name',
                    'CarCategory.name',
                    'Fuel.name',
                    'Car.nbplace',
                    'Car.nbdoor',
                    'Car.immatr_def',
                    'Car.chassis',
                    'Car.color2',
                    'Car.circulation_date',
                    'CarStatus.name',
                    'Car.km'

                ),
                'order' => 'Car.id asc',
                'recursive' => -1,
                'joins' => array(
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Carmodel.id = Car.carmodel_id')
                    ),
                    array(
                        'table' => 'car_statuses',
                        'type' => 'left',
                        'alias' => 'CarStatus',
                        'conditions' => array('CarStatus.id = Car.car_status_id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'CarType',
                        'conditions' => array('CarType.id = Car.car_type_id')
                    ),
                    array(
                        'table' => 'parcs',
                        'type' => 'left',
                        'alias' => 'Parc',
                        'conditions' => array('Parc.id = Car.parc_id')
                    ),
                    array(
                        'table' => 'car_categories',
                        'type' => 'left',
                        'alias' => 'CarCategory',
                        'conditions' => array('CarCategory.id = Car.car_category_id')
                    ),
                    array(
                        'table' => 'fuels',
                        'type' => 'left',
                        'alias' => 'Fuel',
                        'conditions' => array('Fuel.id = Car.fuel_id')
                    ),
                    array(
                        'table' => 'marks',
                        'type' => 'left',
                        'alias' => 'Mark',
                        'conditions' => array('Car.mark_id = Mark.id')
                    ),
                )
            ));
        } else {

            if (isset($this->params['pass']['0']) && $this->params['pass']['0'] == "all") {
                $cars = $this->Car->find('all', array(
                    'order' => 'Car.id asc',
                    'recursive' => -1,
                    'Group' => 'Car.id',
                    'fields' => array(
                        'Car.id',
                        'Car.code',
                        'Carmodel.name',
                        'Mark.name',
                        'CarType.name',
                        'CarCategory.name',
                        'Fuel.name',
                        'Car.nbplace',
                        'Car.nbdoor',
                        'Car.immatr_def',
                        'Car.chassis',
                        'Car.color2',
                        'Car.circulation_date',
                        'CarStatus.name',
                        'Car.km',
                    ),
                    'joins' => array(
                        array(
                            'table' => 'carmodels',
                            'type' => 'left',
                            'alias' => 'Carmodel',
                            'conditions' => array('Carmodel.id = Car.carmodel_id')
                        ),
                        array(
                            'table' => 'marks',
                            'type' => 'left',
                            'alias' => 'Mark',
                            'conditions' => array('Mark.id = Car.mark_id')
                        ),
                        array(
                            'table' => 'car_types',
                            'type' => 'left',
                            'alias' => 'CarType',
                            'conditions' => array('CarType.id = Car.car_type_id')
                        ),
                        array(
                            'table' => 'car_statuses',
                            'type' => 'left',
                            'alias' => 'CarStatus',
                            'conditions' => array('CarStatus.id = Car.car_status_id')
                        ),
                        array(
                            'table' => 'parcs',
                            'type' => 'left',
                            'alias' => 'Parc',
                            'conditions' => array('Parc.id = Car.parc_id')
                        ),
                        array(
                            'table' => 'car_categories',
                            'type' => 'left',
                            'alias' => 'CarCategory',
                            'conditions' => array('CarCategory.id = Car.car_category_id')
                        ),
                        array(
                            'table' => 'fuels',
                            'type' => 'left',
                            'alias' => 'Fuel',
                            'conditions' => array('Fuel.id = Car.fuel_id')
                        )

                    )
                ));
            } else {
                $ids = filter_input(INPUT_POST, "chkids");
                $array_ids = explode(",", $ids);
                $cars = $this->Car->find('all', array(
                    'conditions' => array(
                        "Car.id" => $array_ids,
                    ),
                    'Group' => 'Car.id',
                    'fields' => array(
                        'Car.id',
                        'Car.code',
                        'Carmodel.name',
                        'Mark.name',
                        'CarType.name',
                        'CarCategory.name',
                        'Fuel.name',
                        'Car.nbplace',
                        'Car.nbdoor',
                        'Car.immatr_def',
                        'Car.chassis',
                        'Car.color2',
                        'Car.circulation_date',
                        'CarStatus.name',
                        'Car.km',
                    ),
                    'order' => 'Car.id asc',
                    'recursive' => -1,
                    'joins' => array(
                        array(
                            'table' => 'carmodels',
                            'type' => 'left',
                            'alias' => 'Carmodel',
                            'conditions' => array('Carmodel.id = Car.carmodel_id')
                        ),
                        array(
                            'table' => 'marks',
                            'type' => 'left',
                            'alias' => 'Mark',
                            'conditions' => array('Mark.id = Car.mark_id')
                        ),
                        array(
                            'table' => 'car_types',
                            'type' => 'left',
                            'alias' => 'CarType',
                            'conditions' => array('CarType.id = Car.car_type_id')
                        ),
                        array(
                            'table' => 'car_statuses',
                            'type' => 'left',
                            'alias' => 'CarStatus',
                            'conditions' => array('CarStatus.id = Car.car_status_id')
                        ),
                        array(
                            'table' => 'parcs',
                            'type' => 'left',
                            'alias' => 'Parc',
                            'conditions' => array('Parc.id = Car.parc_id')
                        ),
                        array(
                            'table' => 'car_categories',
                            'type' => 'left',
                            'alias' => 'CarCategory',
                            'conditions' => array('CarCategory.id = Car.car_category_id')
                        ),
                        array(
                            'table' => 'fuels',
                            'type' => 'left',
                            'alias' => 'Fuel',
                            'conditions' => array('Fuel.id = Car.fuel_id')
                        )

                    )
                ));
            }
        }

        $this->set('models', $cars);
    }

    function lock()
    {
        $this->settimeactif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(
            SectionsEnum::vehicule,
            $user_id,
            ActionsEnum::lock,
            "Cars",
            $this->params['pass']['0'],
            "Car",
            null
        );

        $result = $this->setLocked('Car', $this->params['pass']['0'], 1);
        if ($result) {
            $this->Flash->success(__('The car has been locked.'));
        } else {
            $this->Flash->error(__('The car could not be locked.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    function unlock()
    {
        $this->settimeactif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(
            SectionsEnum::vehicule,
            $user_id,
            ActionsEnum::lock,
            "Cars",
            $this->params['pass']['0'],
            "Car",
            null
        );
        $result = $this->setLocked('Car', $this->params['pass']['0'], 0);
        if ($result) {
            $this->Flash->success(__('The car has been unlocked.'));
        } else {
            $this->Flash->error(__('The car could not be unlocked.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function view_attachment($id)
    {
        $this->settimeactif();
        ini_set('memory_limit', '512M');
        if (!$this->Car->exists($id)) {
            throw new NotFoundException(__('Invalid consumption'));
        }
        $options = array('conditions' => array('Car.' . $this->Car->primaryKey => $id));
        $this->Car->recursive = 2;
        $this->set('car', $this->Car->find('first', $options));
        // $company = $this->Company->find('first');
        // $this->set('company', $company);
    }

    public function export_pdf()
    {
        if (isset($this->params['pass']['0']) && $this->params['pass']['0'] == "all") {
            $this->paginate = array(

                'order' => array('Car.code' => 'ASC'),
                'paramType' => 'querystring'
            );
        } else {
            $ids = filter_input(INPUT_POST, "chkids");
            $array_ids = explode(",", $ids);
            $this->paginate = array(

                'order' => array('Car.code' => 'ASC'),
                'conditions' => array(
                    "Car.id" => $array_ids
                ),
                'paramType' => 'querystring'
            );
        }

        $this->Car->recursive = 1;
        $this->set('cars', $this->Paginator->paginate('Car'));
    }

    public function import()
    {
        $userId = $this->Auth->user('id');
        if (!empty($this->request->data['Car']['file_csv']['tmp_name'])) {

            if (is_uploaded_file($this->request->data['Car']['file_csv']['tmp_name'])) {
                $fichier = $this->request->data['Car']['file_csv']['name'];
                $ext = substr(strtolower(strrchr($fichier, '.')), 1);
                if ($ext == 'csv') {
                    if ($fichier) {
                        $fp = fopen($this->request->data['Car']['file_csv']['tmp_name'], "r");
                    } else {

                        echo ('fichier introuvable');
                        exit();
                    }
                    $cpt = 0;
                    while (!feof($fp)) {

                        $ligne = fgets($fp, 4096);
                        if ($cpt == 0){
                            $cpt++;
                            continue;
                        }


                        if (count(explode(";", $ligne)) > 1) {

                            $liste = explode(";", $ligne);
                        } else {

                            $liste = explode(",", $ligne);
                        }
                        if (empty($liste[6])){
                            break;
                        }
                        filter_input(INPUT_POST, 'file_csv');


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
                        $liste[32] = (isset($liste[32])) ? $liste[32] : null;

                        $code = $liste[0];
                        $mark = $liste[1];
                        $model = $liste[2];
                        $category = $liste[3];
                        $type = $liste[4];
                        $fuel = $liste[5];
                        $immatr_def = $liste[6];
                        $immatr_prov = $liste[7];
                        $acquisition = $liste[8];
                        $supplier = $liste[9];
                        $nb_place = $liste[10];
                        $nb_porte = $liste[11];
                        $chassis = $liste[12];
                        $couleur = $liste[13];
                        $km = $liste[14];
                        $parc = $liste[15];
                        $circulation_date = $liste[16];
                        $date_approval = $liste[17];
                        $codeRadio = $liste[18];
                        $purchase_date = $liste[19];
                        $purchasing_price = $liste[20];
                        $nb_year_amortization = $liste[21];
                        $amortization_amount = $liste[22];
                        $max_speed = $liste[23];
                        $average_speed = $liste[24];
                        $reservoir = $liste[25];
                        $min_consumption = $liste[26];
                        $max_consumption = $liste[27];
                        $power_car = $liste[28];
                        $empty_weight = $liste[29];
                        $charge_utile = $liste[30];
                        $poids_total_charge = $liste[31];
                        $nb_palette = $liste[32];
                        $fuelId = $this->Id_Fuel($fuel, $userId);
                        $mark = $this->Id_Mark($mark);
                        $model = $this->ID_Model($model);
                        $acquisition = $this->ID_Acquisition($acquisition);
                        $supplier = $this->ID_Supplier($supplier);
                        $categoryId = $this->ID_Category($category, $userId);
                
                        $type = $this->ID_Type($type);
                        $parc = $this->ID_Parc($parc);
                        if (!empty($circulation_date)) {
                            $circulation_date = $this->getDate($circulation_date);
                        }

                        if (!empty($date_approval)) {
                            $date_approval = $this->getDate($date_approval);
                        }

                        if (!empty($purchase_date)) {
                            $purchase_date = $this->getDate($purchase_date);
                        }

                        if ($cpt > 0) {
                            $this->Car->create();
                            if (!empty($code)) {
                                $this->request->data['Car']['code'] = $code;
                            }
                            $this->request->data['Car']['mark_id'] = $mark;
                            $this->request->data['Car']['fuel_id'] = $fuelId;
                            $this->request->data['Car']['carmodel_id'] = $model;
                            $this->request->data['Car']['parc_id'] = $parc;
                            $this->request->data['Car']['car_type_id'] = $type;
                            $this->request->data['Car']['car_category_id'] = $categoryId;
                            $this->request->data['Car']['immatr_def'] = $immatr_def;
                            $this->request->data['Car']['immatr_prov'] = $immatr_prov;
                            $this->request->data['Car']['acquisition_type_id'] = $acquisition;
                            $this->request->data['Car']['supplier_id'] = $supplier;
                            $this->request->data['Car']['color2'] = $couleur;
                            $this->request->data['Car']['nbplace'] = $nb_place;
                            $this->request->data['Car']['nbdoor'] = $nb_porte;
                            $this->request->data['Car']['chassis'] = $chassis;
                            $this->request->data['Car']['km'] = $km;
                            $this->request->data['Car']['radio_code'] = $codeRadio;
                            $this->request->data['Car']['purchasing_price'] = $purchasing_price;
                            $this->request->data['Car']['nb_year_amortization'] = $nb_year_amortization;
                            $this->request->data['Car']['amortization_amount'] = $amortization_amount;
                            $this->request->data['Car']['max_speed'] = $max_speed;
                            $this->request->data['Car']['average_speed'] = $average_speed;
                            $this->request->data['Car']['reservoir'] = $reservoir;
                            $this->request->data['Car']['min_consumption'] = $min_consumption;
                            $this->request->data['Car']['max_consumption'] = $max_consumption;
                            $this->request->data['Car']['power_car'] = $power_car;
                            $this->request->data['Car']['empty_weight'] = $empty_weight;
                            $this->request->data['Car']['charge_utile'] = $charge_utile;
                            $this->request->data['Car']['charge_utile'] = $charge_utile;
                            $this->request->data['Car']['poids_total_charge'] = $poids_total_charge;
                            $this->request->data['Car']['nb_palette'] = $nb_palette;
                            $this->request->data['Car']['circulation_date'] = $circulation_date;
                            $this->request->data['Car']['date_approval'] = $date_approval;
                            $this->request->data['Car']['purchase_date'] = $purchase_date;

                            if (Configure::read("cafyb") == '1') {
                                $this->request->data['Car']['user_id'] = $this->Session->read('User.id');
                            } else {
                                $this->request->data['Car']['user_id'] = $this->Session->read('Auth.User.id');
                            }
                            
                            $this->Car->save($this->request->data);
                            
                        }

                        $cpt++;
                    }

                    fclose($fp);
                    echo json_encode(array("response" => "true"));
                    $this->Flash->success(__('The file has been successfully imported'));

                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->error(__('The file must be in csv format'));
                    $this->redirect(array('action' => 'index'));
                }
            }
        }
    }

    public function ID_Fuel($fuel_name_import, $userId)
    {
        $fuel_name_import = trim($fuel_name_import);
        $fuel_name_import = strtolower($fuel_name_import);
        return $this->Fuel->getOrCreateCarFuelIdByName($fuel_name_import, $userId);
    }

    public function ID_Mark($mark_name_import)
    {
        $mark_name_import = trim($mark_name_import);
        $mark_name_import = strtolower($mark_name_import);
        $mark_id = null;
        $marks = $this->Mark->find('all', array('recursive' => -1));
        foreach ($marks as $Mark) {
            $mark_name = strtolower($Mark['Mark']['name']);

            if ($mark_name_import == $mark_name) {
                $mark_id = $Mark['Mark']['id'];
            }
        }
        return $mark_id;
    }

    public function ID_Model($model_name_import)
    {
        $model_name_import = trim($model_name_import);
        $model_name_import = strtolower($model_name_import);
        $model_id = null;
        $models = $this->Carmodel->find('all', array('recursive' => -1));
        foreach ($models as $Model) {
            $model_name = strtolower($Model['Carmodel']['name']);

            if ($model_name_import == $model_name) {
                $model_id = $Model['Carmodel']['id'];
            }
        }
        return $model_id;
    }

    public function ID_Acquisition($acquisition_name_import)
    {
        $acquisition_name_import = trim($acquisition_name_import);
        $acquisition_name_import = strtolower($acquisition_name_import);
        $acquisition_id = null;
        $acquisitions = $this->AcquisitionType->getAcquisitionTypes('all');
        foreach ($acquisitions as $Acquisition) {
            $acquisition_name = strtolower($Acquisition['AcquisitionType']['name']);

            if ($acquisition_name_import == $acquisition_name) {
                $acquisition_id = $Acquisition['AcquisitionType']['id'];
            }
        }
        return $acquisition_id;
    }

    public function ID_Supplier($supplier_name_import)
    {
        $supplier_name_import = trim($supplier_name_import);
        $supplier_name_import = strtolower($supplier_name_import);
        $supplier_id = null;
        $suppliers = $this->Supplier->find('all', array('recursive' => -1));
        foreach ($suppliers as $Supplier) {
            $supplier_name = strtolower($Supplier['Supplier']['name']);

            if ($supplier_name_import == $supplier_name) {
                $supplier_id = $Supplier['Supplier']['id'];
            }
        }
        return $supplier_id;
    }

    public function ID_Category($category_name_import, $userId)
    {
        $category_name_import = trim($category_name_import);
        $category_name_import = strtolower($category_name_import);
        $carCategoryId = $this->CarCategory->getOrCreateCarCategoryIdByName($category_name_import, $userId);
        return $carCategoryId;
    }

    public function ID_Type($type_name_import)
    {
        $type_name_import = trim($type_name_import);
        $type_name_import = strtolower($type_name_import);
        $car_type_id = null;
        $carTypes = $this->CarType->getCarTypes(null, 'all');
        foreach ($carTypes as $carType) {
            $type_name = strtolower($carType['CarType']['name']);
            if ($type_name_import == $type_name) {
                $car_type_id = $carType['CarType']['id'];
            }
        }
        return $car_type_id;
    }

    public function ID_Parc($parcNameImport)
    {
        $parcNameImport = trim($parcNameImport);
        $parcNameImport = strtolower($parcNameImport);

        $parcId = null;
        $parcs = $this->Parc->getParcs('all');
        foreach ($parcs as $Parc) {
            $parc_name = strtolower($Parc['Parc']['name']);
            if ($parcNameImport == $parc_name) {
                $parcId = $Parc['Parc']['id'];
            }
        }
        return $parcId;
    }

    public function getDate($date)
    {
        $dateResult = '';
        $date = trim($date);
        $date = strtolower($date);

        $this->request->data['Car']['date'] = $date;
        $this->createDatetimeFromDate('Car', 'date');

        if (empty($this->request->data['Car']['date'])) {
            $this->request->data['Car']['date'] = $date;
            $this->createDatetimeFromDateFormat2('Car', 'date');
            if (!empty($this->request->data['Car']['date'])) {
                $dateResult = $this->request->data['Car']['date'];
            }
        } else {
            $dateResult = $this->request->data['Car']['date'];
        }
        return $dateResult;
    }

    public function openDir($dir = null, $id_dialog = null, $id_input = null)
    {


        //$this->verifAttachment('Car', 'file', 'attachments/yellowcards/', 'add',1,0,null);

        if (!empty($this->request->data['Car']['file']['tmp_name'])) {
        }

        $array_fichier = array();
        $i = 0;

        if ($dossier = opendir('./attachments/' . $dir)) {
            while (false !== ($fichier = readdir($dossier))) {
                if ($fichier != '.' && $fichier != '..' && $fichier != 'index.php') {
                    $array_fichier[$i] = $fichier;
                    $i++;
                } // On ferme le if (qui permet de ne pas afficher index.php, etc.)

            }

            closedir($dossier);
        } else {
            echo 'Le dossier n\' a pas pu �tre ouvert';
        }


        $this->set('array_fichier', $array_fichier);
        $this->set('dir', $dir);
        $this->set('id_dialog', $id_dialog);
        $this->set('id_input', $id_input);
    }

    function uploadPicture()
    {


        $this->set('file_name', $this->params['pass']['0']);
        $this->set('Dir', $this->params['pass']['1']);
    }

    public function addPayment()
    {

        if (Configure::read("cafyb") == '1') {
            $comptes = $this->Cafyb->getAccounts();
            $paymentMethods = $this->Cafyb->getPaymentMethods();
        } else {
            $comptes = $this->Payment->Compte->find('list');
        }

        $nb_payment = $this->params['pass']['0'];
        $this->set(compact('nb_payment', 'comptes', 'paymentMethods'));
    }

    public function addLeasing()
    {
        $acquisitionTypesLeasing = $this->AcquisitionType->getAcquisitionTypesByIds(array(2, 3));
        $suppliers = $this->Supplier->getSuppliersByParams(0, 1);
        $this->set('suppliers', $suppliers);
        $this->set('nb_leasing', $this->params['pass']['0']);
        $this->set('acquisitionTypesLeasing', $acquisitionTypesLeasing);
    }

    public function upload()
    {
        $this->settimeactif();
        $this->autoRender = false;
        $folder = $this->request->data['Car']['folder'];
        $this->verifyAttachment('Car', 'file', 'attachments/' . $folder . '/', 'add', 0, 0, null);

        echo json_encode(array("response" => "true", "folder" => $folder));
    }

    /**
     * Set current km of all cars from geolocalisation
     * @return void
     */

    // km_cars bejaialogistique
    /* public function km_cars()
     {
         $cars = $this->Car->find('all', array('fields' => array('Car.code', 'Car.id'), 'recursive' => -1));

         foreach ($cars as $car) {

             $headers =["Content-Type:application/json",
                 "Autentication:CF26765E8BC7D73FDB16D50A9A5805CB454DD2E789611C6C0C5FA7E93AF87B441F46A5E4204F1C18AB7D44A5D8232450D7DFC6AD08EC05C34B8CA76B992CF273AC124E66A5AB80F7C80E2F7F82D44AE3D82321A7567282B20816F39ECFAFFA2CE8AA06BEC70C60BFD88104153C1FDAA0373AC4AFE19AE6946B0F043F9F172662E93C843FA78B45DECBB75BC5B87416A8E3EEEDB1E5F55C95F6A8FAB82B3802EB4375F1836985293E06D83FCE160EAB68A1CB9E9D7E7D047D0709B857D49856C63557F5D1B64BCC5DC7C63AC9267B0D953DCA0297AAF4E0156FE7ADB063B1007D"];

             $url = 'http://api.fleetcenter.dz/api/LiveTracking?code='.$car['Car']['code'];
             $chaine = $this->cUrlGetData($url, null, $headers);
             if (!empty($chaine)) {


                 $code = $chaine[0]['Code'];
                 $last_date = $chaine[0]["Date"];
                 $last_date = str_replace("T", " ", $last_date);
                 $km = $chaine[0]['Odometer'];
                 $speed = $chaine[0]['Speed'];
                 $latitude = $chaine[0]['Position']['Latitude'];
                 $longitude = $chaine[0]['Position']['Longitude'];
                 $place = $chaine[0]['Place'];
                 $last_fuel_level = $chaine[0]['LastFuelLevel'];
                 $weight = $chaine[0]['Weight'];
                 if (trim($km) != "" && trim($code) != "") {
                     $this->Car->id = $car['Car']['id'];
                     $this->Car->saveField('speed', $speed);
                     $this->Car->saveField('km', $km);
                     $this->Car->saveField('latitude', $latitude);
                     $this->Car->saveField('longitude', $longitude);
                     $this->Car->saveField('place', $place);
                     $this->Car->saveField('last_fuel_level', $last_fuel_level);
                     $this->Car->saveField('weight', $weight);
                     $this->Car->saveField('last_date_synchronization', $last_date);

                 }

             }
         }

         $this->Flash->success(__('Synchronization has been performed successfully'));

         $this->redirect(array('action' => 'index'));

     } */


    function getTypesByCategory($category_id = null)
    {

        $this->settimeactif();
        $this->layout = 'ajax';
        $this->set('category_id', $category_id);
        if ($category_id != null) {
            $conditions = array('CarTypeCarCategory.car_category_id' => $category_id);
            $types = $this->CarType->getCarTypeByConditions($conditions);
            $this->layout = 'ajax';
            $this->set(
                'selectbox',
                $types
            );
        } else {
            $this->set('selectbox', null);
        }
    }

    function resetBalance($car_id = null)
    {
        $this->settimeactif();
        $this->Car->id = $car_id;
        $this->Car->saveField('balance', 0);
        $this->Flash->success(__('The balance car has been reset.'));
        $this->redirect(array('action' => 'view', $car_id));
    }

    public function viewPosition($id = null)
    {
        $car = $this->Car->find("first", array(
            "conditions" => array('Car.id' => $id),
            'recursive' => -1,
            'fields' => array(
                'Car.id',
                'Car.code',
                'Car.km',
                'CarModel.name',
                'Car.immatr_def',
                'Car.km',
                'Car.speed',
                'Car.latitude',
                'Car.longitude',
                'Car.place',
                'Car.last_fuel_level',
                'Car.weight',
                'Car.last_date_synchronization'
            ),
            'joins' => array(

                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'CarModel',
                    'conditions' => array('Car.carmodel_id = CarModel.id')
                )

            )

        ));

        $this->set('car', $car);
    }

    public function liste($id = null, $keyword = null)
    {
        $keyword = str_replace('espace', ' ', $keyword);
        $keyword = str_replace('slash', '/', $keyword);
        $keyword = strtolower($keyword);
        $this->layout = 'ajax';
        $limit = $this->getLimit();
        switch ($id) {
            case 2:
                $conditions = array("LOWER(Car.code) LIKE" => "%$keyword%");
                break;
            case 3:
                $conditions = array("LOWER(Carmodel.name) LIKE" => "%$keyword%");
                break;
            case 4:
                $conditions = array("LOWER(Car.km) LIKE" => "%$keyword%");
                break;

            case 5:
                $conditions = array("LOWER(CarType.name) LIKE" => "%$keyword%");
                break;
            case 6:
                $conditions = array("LOWER(Fuel.name) LIKE" => "%$keyword%");
                break;
            case 7:
                $conditions = array("LOWER(Car.immatr_def) LIKE" => "%$keyword%");
                break;
            case 8:
                $conditions = array("LOWER(Car.chassis) LIKE" => "%$keyword%");
                break;
            case 9:
                $conditions = array("LOWER(Car.color2) LIKE" => "%$keyword%");
                break;
            case 10:
                $conditions = array("LOWER(CarStatus.name) LIKE" => "%$keyword%");
                break;
            case 11:
                $conditions = array("LOWER(Car.in_mission) LIKE" => "%$keyword%");
                break;

            default:
                $conditions = array("LOWER(Car.code) LIKE" => "%$keyword%");
        }


        $this->paginate = array(

            'order' => array('Car.id' => 'DESC'),
            'conditions' => $conditions,
            'limit' => $limit,
            'paramType' => 'querystring',
            'fields' => array(
                'Carmodel.name',
                'Car.id',
                'Car.code',
                'CarCategory.name',
                'CarType.name',
                'Car.km',
                'Car.km_initial',
                'CarCategory.id',
                'CarType.id',
                'Fuel.name',
                'Car.nbplace',
                'Car.nbdoor',
                'Car.immatr_def',
                'Car.chassis',
                'Car.color2',
                'CarStatus.name',
                'CarStatus.color',
                'Car.in_mission',
                'Car.locked',
                'Mark.logo',
                'Car.picture1',
                'Car.picture2',
                'Car.picture3',
                'Car.picture4',
                'Car.balance',
                'Car.yellow_card',
                'Car.grey_card'
            ),
            'recursive' => -1,
            'joins' => array(

                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'car_categories',
                    'type' => 'left',
                    'alias' => 'CarCategory',
                    'conditions' => array('Car.car_category_id = CarCategory.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('Car.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'fuels',
                    'type' => 'left',
                    'alias' => 'Fuel',
                    'conditions' => array('Car.fuel_id = Fuel.id')
                ),
                array(
                    'table' => 'car_statuses',
                    'type' => 'left',
                    'alias' => 'CarStatus',
                    'conditions' => array('Car.car_status_id = CarStatus.id')
                ),
                array(
                    'table' => 'marks',
                    'type' => 'left',
                    'alias' => 'Mark',
                    'conditions' => array('Car.mark_id = Mark.id')
                ),


            )
        );

        $cars = $this->Paginator->paginate('Car');

        $this->set('cars', $cars);
        $balance_car = $this->isBalanceCarUsed();
        $client_i2b = $this->isCustomerI2B();
        $this->set(compact('balance_car', 'client_i2b'));
    }

    /**
     *  get cars by key word
     */


    /**
     * Set current km of all cars from geolocalisation
     * @return void
     */
    // km_cars garmin
/*
    public function km_cars()
    {
        $cars = $this->Car->find('all', array('fields' => array('Car.code', 'Car.id'), 'recursive' => -1));

        $headers = array("Content-Type:application/json");
        $url = 'https://djazfleet.com/api/login';
        $email = $this->Auth->user('email');
        $data = array('email' => 'redouanimmo@gmail.com', 'password' => '1234');
        // utilisez 'http' même si vous envoyez la requête sur https:// ...
        $content = json_encode($data);
        $result = $this->cUrlGetData($url, $content, $headers);

        if (!empty($result)) {
            if ($result['status'] == 1) {
                $user_api_hash = $result['user_api_hash'];
                $url = 'https://djazfleet.com/api/get_devices?lang=en&user_api_hash=' . $user_api_hash;
                $devices = $this->cUrlGetData($url, null, $headers);

                $items = $devices[0]['items'];
            }
        }

        foreach ($cars as $car) {
            $carCode = $car['Car']['code'];
            if (isset($items) && !empty($items)) {
                foreach ($items as $item) {
                    $imei = $item["device_data"]['imei'];
                    if ($imei == $carCode) {
                        $km = null;
                        $initialKm = null;
                        $sensors = $item["device_data"]["sensors"];
                        if (!empty($sensors)) {
                            foreach ($sensors as $sensor) {
                                $type = $sensor['type'];
                                $name = $sensor['name'];
                                $name = str_replace(' ', '', $name);
                                if ($type == "odometer" && $name == "KilométrageActuel") {
                                    $km = $sensor['value'];
                                    $km = str_replace("km", "", $km);
                                }
                                if ($type == "odometer" && $name == "KilométrageInitial") {
                                    $initialKm = $sensor['value'];
                                    $initialKm = str_replace("km", "", $initialKm);
                                }
                            }
                        }
                        $code = $item["device_data"]['imei'];
                        $speed = $item["device_data"]["traccar"]['speed'];
                        $latitude = $item["device_data"]["traccar"]['lastValidLatitude'];
                        $longitude = $item["device_data"]["traccar"]['lastValidLongitude'];
                        if (trim($code) != "") {
                            $this->Car->id = $car['Car']['id'];
                            $this->Car->saveField('speed', $speed);

                            $km = $km + $initialKm;
                            $this->Car->saveField('km', $km);
                            $this->Car->saveField('km_initial', $initialKm);
                            $this->Car->saveField('latitude', $latitude);
                            $this->Car->saveField('longitude', $longitude);
                        }
                    }
                }
            }
        }
        // die();
        $this->Flash->success(__('Synchronization has been performed successfully'));

        $this->redirect(array('action' => 'index'));
    }*/



    /**
     * Set current km of all cars from geolocalisation
     * @return void
     */
    // km_cars algeofleet

    
    public function km_cars()
    {
        $client_i2b = $this->isCustomerI2B();
        if ($client_i2b == '1') {
            $link = "https://www.activegps.net/rest/intellix/flotteInfos/tr405053ans925786inv920/";
            $headers = array("Content-Type:application/json");
            $chaines = $this->cUrlGetData($link, null, $headers);
            foreach ($chaines as $chaine) {
                $code = utf8_decode($chaine['deviceId']);
                //$car_id=ID_Cars_Code($chaine['codevehicule']);
                $car = $this->Car->find('first', array('recursive' => -1, 'fields' => array('km_initial', 'id'), 'conditions' => array('Car.code' => $chaine['deviceId'])));

                if (!empty($car)) {
                    $km = (float)$car['Car']['km_initial'] + (float)$chaine['odometer'];
                    $lat = $chaine['lat'];
                    $lng = $chaine['lng'];
                    $this->Car->id = $car['Car']['id'];
                    $this->Car->saveField('km', $km);
                    $this->Car->saveField('latitude', $lat);
                    $this->Car->saveField('longitude', $lng);
                }
            }

            $this->Flash->success(__('Synchronization has been performed successfully'));
            $this->redirect(array('action' => 'index'));
        }
    }


    public function getRemorquesByKeyWord()
    {
        $this->autoRender = false;
        // get the search term from URL
        $term = $this->request->query['q'];
        // recuperer le controller
        $controller = $_GET['controller'];
        // recuper l'action
        $action = $_GET['action'];
        $remorqueId = $_GET['remorqueId'];

        switch ($controller) {
                // recuperer les conditions de feuille de route par action
            case 'SheetRides';
            case 'sheetRides';
            case 'sheet_rides';
                switch ($action) {

                    case 'add';
                    case 'Add';
                        $conditions = $this->getConditionsSheetRide();
                        $conditionsCar = $conditions[1];
                        $condition1 = array('Car.car_category_id ' => 3);
                        if ($conditionsCar != null) {
                            $conditionsCar = array_merge($conditionsCar, $condition1);
                        } else {
                            $conditionsCar = $condition1;
                        }
                        break;

                    case 'edit';
                    case 'Edit';
                        $conditions = $this->getConditionsSheetRide();
                        $conditionsCar = $conditions[1];
                        $condition1 = array(
                            'Car.car_category_id ' => 3,
                            'Car.id' => $remorqueId

                        );
                        if ($conditionsCar != null) {
                            $conditionsCar = array_merge($conditionsCar, $condition1);
                        } else {
                            $conditionsCar = $condition1;
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


        $param = $this->Parameter->getCodesParameterVal('name_car');

        if ($param == 1) {
            if (count($term) > 1) {
                $conds = array(
                    "CONVERT(Car.code USING utf8)  COLLATE utf8_general_ci  LIKE " => "%$term[0]%",
                    "CONVERT(Carmodel.name USING utf8)  COLLATE utf8_general_ci LIKE " => "%$term[1]%"

                );
            } else {
                $conds = array(
                    'OR' => array(
                        " CONVERT(Car.code USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term[0]%",
                        " CONVERT(Carmodel.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term[0]%",

                    )
                );
            }
        } else {
            if (count($term) > 1) {
                $conds = array(
                    "CONVERT(Car.immatr_def USING utf8)  COLLATE utf8_general_ci  LIKE " => "%$term[0]%",
                    "CONVERT(Carmodel.name USING utf8)  COLLATE utf8_general_ci LIKE " => "%$term[1]%"

                );
            } else {
                $conds = array(
                    'OR' => array(
                        " CONVERT(Car.immatr_def USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term[0]%",
                        " CONVERT(Carmodel.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term[0]%",

                    )
                );
            }
        }


        if ($conditionsCar != null) {
            $conds = array_merge($conditionsCar, $conds);
        }

        $fields = array('Car.id', 'Car.code', 'Car.immatr_def', 'Carmodel.name');
        $cars = $this->Car->getCarsByFieldsAndConds($param, $fields, $conds, 'all');
        $data = array();
        $i = 0;
        $data[$i]['id'] = "";
        $data[$i]['text'] = "";
        $i++;
        foreach ($cars as $car) {
            $data[$i]['id'] = $car['Car']['id'];
            if ($param == 1) {
                $data[$i]['text'] = $car['Car']['code'] . ' - ' . $car['Carmodel']['name'];
            } else {
                $data[$i]['text'] = $car['Car']['immatr_def'] . ' - ' . $car['Carmodel']['name'];
            }

            $i++;
        }

        echo json_encode($data);
    }

    public function getCarsByKeyWord()
    {
        $this->autoRender = false;

        // get the search term from URL
        $term = $this->request->query['q'];
        // recuperer le controller
        $controller = $_GET['controller'];
        // recuper l'action
        $action = $_GET['action'];
        $carId = $_GET['carId'];
        $carTypeId = $_GET['carTypeId'];
        $carCustomerOutPark = $this->Parameter->getCodesParameterVal('car_customer_out_park');
        switch ($controller) {
                // recuperer les conditions de feuille de route par action
            case 'sheetRides';
            case 'SheetRides';
            case  'sheet_rides';
            case 'sheetRideDetailRides';
            case  'consumptions';
            case  'transportBills';
                switch ($action) {
                    case 'index':
                        $conditions = $this->getConditionsSheetRide();

                        $conditionsCar = $conditions[1];
                        break;
                    case 'search':
                        $conditions = $this->getConditionsSheetRide();

                        $conditionsCar = $conditions[1];
                        break;
                    case 'add';
                    case 'Add';
                        $conditions = $this->getConditionsSheetRide();
                        $conditionsCar = $conditions[1];
                        if (!empty($carTypeId)) {
                            if ($carCustomerOutPark == 1) {
                                $condition1 = array(
                                    'Car.car_category_id !=' => 3,
                                    'Car.car_type_id ' => $carTypeId,
                                );
                            } else {
                                $condition1 = array(
                                    'Car.car_category_id !=' => 3,
                                    'Car.car_type_id ' => $carTypeId,
                                    'Car.in_mission' => array(0)
                                );
                            }
                        } else {
                            if ($carCustomerOutPark == 1) {
                                $condition1 = array(
                                    'Car.car_category_id !=' => 3,
                                );
                            } else {
                                $condition1 = array(
                                    'Car.car_category_id !=' => 3,
                                    'Car.in_mission' => array(0)
                                );
                            }
                        }

                        if ($conditionsCar != null) {
                            $conditionsCar = array_merge($conditionsCar, $condition1);
                        } else {
                            $conditionsCar = $condition1;
                        }
                        break;

                    case 'edit';
                    case 'Edit';
                        $conditions = $this->getConditionsSheetRide();
                        $conditionsCar = $conditions[1];
                        if (!empty($carTypeId)) {
                            if ($carCustomerOutPark == 1) {
                                $condition1 = array(
                                    'Car.car_category_id !=' => 3,
                                    'Car.car_type_id ' => $carTypeId,
                                    'OR' => array(
                                        'Car.id' => $carId
                                    )
                                );
                            } else {
                                $condition1 = array(
                                    'Car.car_category_id !=' => 3,
                                    'Car.car_type_id ' => $carTypeId,
                                    'OR' => array(
                                        'Car.in_mission' => array(0),
                                        'Car.id' => $carId
                                    )
                                );
                            }
                        } else {
                            if ($carCustomerOutPark == 1) {
                                $condition1 = array(
                                    'Car.car_category_id !=' => 3,
                                    'OR' => array(
                                        'Car.id' => $carId
                                    )
                                );
                            } else {
                                $condition1 = array(
                                    'Car.car_category_id !=' => 3,
                                    'OR' => array(
                                        'Car.in_mission' => array(0),
                                        'Car.id' => $carId
                                    )
                                );
                            }
                        }

                        if ($conditionsCar != null) {
                            $conditionsCar = array_merge($conditionsCar, $condition1);
                        } else {
                            $conditionsCar = $condition1;
                        }

                        break;

                    default:
                        $conditionsCar = null;
                        break;
                }
                break;
        }
        $term = explode('/', $term);
        $term[0] = trim(strtolower(($term[0])));
        if (isset($term[1])) {
            $term[1] = trim(strtolower(($term[1])));
        }


        $param = $this->Parameter->getCodesParameterVal('name_car');

        if ($param == 1) {
            if (count($term) > 1) {
                $conds = array(
                    "CONVERT(Car.code USING utf8)  COLLATE utf8_general_ci  LIKE " => "%$term[0]%",
                    "CONVERT(Carmodel.name USING utf8)  COLLATE utf8_general_ci LIKE " => "%$term[1]%"

                );
            } else {
                $conds = array(
                    'OR' => array(
                        " CONVERT(Car.code USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term[0]%",
                        " CONVERT(Carmodel.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term[0]%",

                    )
                );
            }
        } else {
            if (count($term) > 1) {
                $conds = array(
                    "CONVERT(Car.immatr_def USING utf8)  COLLATE utf8_general_ci  LIKE " => "%$term[0]%",
                    "CONVERT(Carmodel.name USING utf8)  COLLATE utf8_general_ci LIKE " => "%$term[1]%"

                );
            } else {
                $conds = array(
                    'OR' => array(
                        " CONVERT(Car.immatr_def USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term[0]%",
                        " CONVERT(Carmodel.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term[0]% ",

                    )
                );
            }
        }


        /*if ($conditionsCar != null) {
            $conds = array_merge($conditionsCar, $conds);

        }*/


        $fields = array('Car.id', 'Car.code', 'Car.immatr_def', 'Carmodel.name');
        $cars = $this->Car->getCarsByFieldsAndConds($param, $fields, $conds, 'all');
        $data = array();
        $i = 0;
        $data[$i]['id'] = "";
        $data[$i]['text'] = "";
        $i++;
        foreach ($cars as $car) {
            $data[$i]['id'] = $car['Car']['id'];
            if ($param == 1) {
                $data[$i]['text'] = $car['Car']['code'] . ' / ' . $car['Carmodel']['name'];
            } else {
                $data[$i]['text'] = $car['Car']['immatr_def'] . ' / ' . $car['Carmodel']['name'];
            }

            $i++;
        }

        echo json_encode($data);
    }

    public function printSimplifiedJournal()
    {
        $this->setTimeActif();
        ini_set('memory_limit', '2024M');
        $array = filter_input(INPUT_POST, "printSimplifiedJournal");

        $arrayConditions = explode(",", $array);

        $markFilter = $arrayConditions[0];
        $carsCarmodelId = $arrayConditions[1];
        $categoryId = $arrayConditions[2];
        $carsType = $arrayConditions[3];
        $carsFuel = $arrayConditions[4];
        $carsStatus = $arrayConditions[5];
        $carsMission = $arrayConditions[6];
        $carsCarParc = $arrayConditions[7];
        $carsParc = $arrayConditions[8];

        $conditions = array();

        if (!empty($markFilter)) {
            $conditions["Car.mark_id"] = $markFilter;
        }
        if (!empty($carsCarmodelId)) {
            $conditions["Car.carmodel_id"] = $carsCarmodelId;
        }
        if (!empty($categoryId)) {
            $conditions["Car.car_category_id"] = $categoryId;
        }
        if (!empty($carsType)) {
            $conditions["Car.car_type_id"] = $carsType;
        }
        if (!empty($carsFuel)) {
            $conditions["Car.fuel_id"] = $carsFuel;
        }
        if (!empty($carsStatus)) {
            $conditions["Car.car_status_id"] = $carsStatus;
        }
        if (!empty($carsMission)) {
            $conditions["Car.in_mission"] = $carsMission;
        }
        if (!empty($carsCarParc)) {
            $conditions["Car.car_parc"] = $carsCarParc;
        }
        if (!empty($carsParc)) {
            $conditions["Car.parc_id"] = $carsParc;
        }
        $ids = filter_input(INPUT_POST, "chkids");

        if (!empty($ids)) {

            $array_ids = explode(",", $ids);
            if (!empty($array_ids)) {
                $conditions["Car.id"] = $array_ids;
            }
        }
        $carsCount = $this->Car->find('count', array(

            'recursive' => -1,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'joins' => array(

                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Model',
                    'conditions' => array('Car.carmodel_id = Model.id')
                ),
                array(
                    'table' => 'car_categories',
                    'type' => 'left',
                    'alias' => 'Category',
                    'conditions' => array('Car.car_category_id = Category.id')
                ),
                array(
                    'table' => 'fuels',
                    'type' => 'left',
                    'alias' => 'Fuel',
                    'conditions' => array('Car.fuel_id = Fuel.id')
                ),
            )
        ));
        if ($carsCount > 1000){
            $this->Flash->error(__('Select a parc please.'));
            $this->redirect(array('action' => 'index'));
        }
        $cars = $this->Car->find('all', array(

            'recursive' => -1,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'fields' => array(

                'Car.id',
                'Model.name',
                'Car.km',
                'Car.km_initial',
                'Category.name',
                'Fuel.name',
                'Car.immatr_def',
                'Car.in_mission',
                'Marks.name'
            ),
            'joins' => array(

                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Model',
                    'conditions' => array('Car.carmodel_id = Model.id')
                ),
                array(
                    'table' => 'car_categories',
                    'type' => 'left',
                    'alias' => 'Category',
                    'conditions' => array('Car.car_category_id = Category.id')
                ),
                array(
                    'table' => 'fuels',
                    'type' => 'left',
                    'alias' => 'Fuel',
                    'conditions' => array('Car.fuel_id = Fuel.id')
                ),
                array(
                    'table' => 'marks',
                    'type' => 'left',
                    'alias' => 'Marks',
                    'conditions' => array('Car.mark_id = Marks.id')
                ),
            )
        ));
        $company = $this->Company->find('first');
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('cars', 'company', 'separatorAmount'));
    }


    function addCar()
    {
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(
            SectionsEnum::vehicule,
            $userId,
            ActionsEnum::add,
            "Cars",
            null,
            "Car",
            null,
            1
        );
        $this->set('result', $result);
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->Car->create();
            if ($this->Car->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $carId = $this->Car->getLastInsertId();
                $this->set('carId', $carId);
            }
        }
        $marks = $this->Mark->getCarMarksByIdsNegation(array('Mark.id' != 0));

        $carCategories = $this->CarCategory->getCarCategoriesByIdsNegation(array(0, 3));

        $fuels = $this->Fuel->getFuels('list');


        $autocode = $this->getNextCode("Car", 'car');
        $this->set(compact('marks', 'carCategories', 'fuels', 'autocode'));
    }

    function getCars()
    {
        $this->layout = 'ajax';
        $conditions = array('Car.id' => $this->params['pass']['0']);
        $structureOfCarName = $this->Parameter->getCodesParameterVal('name_car');
        $cars = $this->Car->getCarsByCondition($structureOfCarName, $conditions);
        $this->set('cars', $cars);
        $this->set('selectedId', $this->params['pass']['0']);
    }


    function addRemorque()
    {
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(
            SectionsEnum::vehicule,
            $userId,
            ActionsEnum::add,
            "Cars",
            null,
            "Car",
            null,
            1
        );
        $this->set('result', $result);
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->Car->create();
            if ($this->Car->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $carId = $this->Car->getLastInsertId();
                $this->set('carId', $carId);
            }
        }
        $marks = $this->Mark->getCarMarksByIdsNegation(array('Mark.id' != 0));
        $carCategories = $this->CarCategory->getCarCategoryById(3);
        $carTypes = $this->CarType->getCarTypeByConditions(array('CarTypeCarCategory.car_category_id' => 3));
        $fuels = $this->Fuel->getFuels('list');


        $autocode = $this->getNextCode("Car", 'car');
        $this->set(compact('marks', 'carCategories', 'fuels', 'autocode', 'carTypes'));
    }

    function getRemorques()
    {
        $this->settimeactif();
        $this->layout = 'ajax';
        $conditions = array('Car.id' => $this->params['pass']['0']);
        $structureOfCarName = $this->Parameter->getCodesParameterVal('name_car');
        $cars = $this->Car->getCarsByCondition($structureOfCarName, $conditions);
        $this->set('cars', $cars);
        $this->set('selectedId', $this->params['pass']['0']);
    }

    public function verifyCode()
    {
        $this->autoRender = false;
        // $description = filter_input(INPUT_POST, "description");
        $code = json_decode($_POST['code']);
        // $code ='864895033917673';
        $headers = array("Content-Type:application/json");
        $url = 'https://djazfleet.com/api/login';
        $email = $this->Auth->user('email');
        $data = array('email' => $email, 'password' => '1234');
        // utilisez 'http' même si vous envoyez la requête sur https:// ...

        $content = json_encode($data);
        $result = $this->cUrlGetData($url, $content, $headers);
        $immatrDef = null;
        $initialKm = null;
        $km = null;
        if (!empty($result)) {
            if ($result['status'] == 1) {
                $user_api_hash = $result['user_api_hash'];
                $url = 'https://djazfleet.com/api/get_history?lang=en&user_api_hash=' . $user_api_hash . '&device_id=660&from_date=2020-11
                -09&from_time=00:00&to_date=2020-11-10&to_time=00:00';
                $devices = $this->cUrlGetData($url, null, $headers);


                $items = $devices[0]['items'];
                foreach ($items as $item) {
                    $imei = $item["device_data"]['imei'];
                    if ($imei == $code) {
                        $km = null;
                        $immatrDef = $item["device_data"]["plate_number"];
                        $sensors = $item["device_data"]["sensors"];
                        if (!empty($sensors)) {
                            foreach ($sensors as $sensor) {
                                $type = $sensor['type'];
                                if ($type == "odometer") {
                                    $km = $sensor['value'];
                                    $km = str_replace("km", "", $km);
                                }
                                $tagName = $sensor['tag_name'];
                                if ($tagName == "totaldistance") {
                                    $initialKm = $sensor['value'];
                                    $initialKm = str_replace("km", "", $initialKm);
                                }
                            }
                        }
                    }
                }
            }

            $response = true;


            echo json_encode(array("response" => $response, 'immatrDef' => $immatrDef, 'initialKm' => $initialKm, 'km' => $km));
        }
    }

    public function importCarsPcApi()
    {
        $headers = array("Content-Type:application/json");
        $url = 'https://djazfleet-dz.com/api/login';
        $email = $this->Auth->user('email');
        $data = array('email' => 'houssem.test@garminalgerie.com', 'password' => '1234');
        // utilisez 'http' même si vous envoyez la requête sur https:// ...
        $content = json_encode($data);
        $result = $this->cUrlGetData($url, $content, $headers);
        $groupName = '';
        $devices = array();

        if (!empty($result)) {
            if ($result['status'] == 1) {
                $user_api_hash = $result['user_api_hash'];
                $url = 'https://djazfleet-dz.com/api/get_devices?lang=en&user_api_hash=' . $user_api_hash;
                $devices = $this->cUrlGetData($url, null, $headers);
            }
        }
        foreach ($devices as $device) {
            if ($device['title'] == 'Dégroupés') {
                foreach ($device['items'] as $item) {
                    $car = $this->Car->find('first', array(
                        'conditions' => array('Car.imei' => $item['device_data']['imei'])
                    ));
                    if (empty($car)) {
                        $autoCode = $this->getNextCode("Car", 'car');
                        $sensors = $item["device_data"]["sensors"];
                        $km = 0;
                        $initialKm = 0;
                        if (!empty($sensors)) {
                            foreach ($sensors as $sensor) {
                                $type = $sensor['type'];
                                $name = $sensor['name'];
                                $name = str_replace(' ', '', $name);
                                if ($type == "odometer" && $name == "KilométrageActuel") {
                                    $km = $sensor['value'];
                                    $km = str_replace("km", "", $km);
                                }
                                if ($type == "numerical" && $name == "KilométrageInitial") {
                                    $initialKm = $sensor['value'];
                                    $initialKm = str_replace("km", "", $initialKm);
                                }
                            }
                        }
                        $km = $km + $initialKm;
                        $car = array('Car' => array(
                            'code' => $autoCode, 'mark_id' => '1', 'carmodel_id' => '1',
                            'car_category_id' => '1', 'car_type_id' => '1', 'fuel_id' => '1',
                            'immatr_def' => $item['device_data']['plate_number'],
                            'speed' => $item['speed'], 'longitude' => $item['lng'], 'latitude' => $item['lat'],
                            'km' => $km, 'km_initial' => $initialKm, 'imei' => $item['device_data']['imei'],
                            'tracker_id' => $item['id']
                        ));
                        $this->Car->create();
                        $result = $this->Car->save($car);
                    }
                }
            }
        }

        if ($result) {
            $this->Flash->success(__('Importation has been performed successfully'));
        } else {
            $this->Flash->error(__('Importation has not been performed'));
        }


        $this->redirect(array('action' => 'index'));
    }

    public function generateReport()
    {
        $headers = array("Content-Type:application/json");
        $url = 'https://djazfleet.com/api/login';
        $email = $this->Auth->user('email');
        $data = array('email' => 'parcmaster@parcmaster.com', 'password' => '$12934567890$');
        // utilisez 'http' même si vous envoyez la requête sur https:// ...
        $content = json_encode($data);
        $result = $this->cUrlGetData($url, $content, $headers);

        if (!empty($result)) {
            if ($result['status'] == 1) {
                $user_api_hash = $result['user_api_hash'];
                $url = 'https://djazfleet.com/api/generate_report?lang=en&user_api_hash=' . $user_api_hash;
                //$data = array('password' => '_123456789_');
                $data = array('title' => 'Informations générales', 'type' => 1, 'format' => 'html', 'devices' =>
                array(670), 'date_from' => '2020-11-20', 'date_to' => '2020-12-1');
                $data = json_encode($data);
                $devices = $this->cUrlGetData($url, $data, $headers);
            }
        }

        $url = $devices['url'];
        $url = $devices['url'];
        $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        $document = new DOMDocument();
        $document->loadHTML($result);
        $allTableRows = $document->getElementsByTagName("tr");
    }

    public function synchronisationKmCron()
    {

        $link = "https://www.activegps.net/rest/intellix/flotteInfos/tr405053ans925786inv920/";
        $headers = array("Content-Type:application/json");
        $chaines = $this->cUrlGetData($link, null, $headers);
        foreach ($chaines as $chaine) {
            $code = utf8_decode($chaine['deviceId']);
            //$car_id=ID_Cars_Code($chaine['codevehicule']);
            $car = $this->Car->find('first', array('recursive' => -1, 'fields' => array('km_initial', 'id'), 'conditions' => array('Car.code' => $code)));

            if (!empty($car)) {
                $km = (float)$car['Car']['km_initial'] + (float)$chaine['odometer'];
                $lat = $chaine['lat'];
                $lng = $chaine['lng'];
                $this->Car->id = $car['Car']['id'];
                $this->Car->saveField('km', $km);
                $this->Car->saveField('latitude', $lat);
                $this->Car->saveField('longitude', $lng);
            }
        }
    }


}
