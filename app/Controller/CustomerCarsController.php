<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('CakeTime', 'Utility');
App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'autoload.inc.php'));
use Dompdf\Dompdf;

/**
 * CustomerCars Controller
 *
 * @property CustomerCar $CustomerCar
 * @property CustomerGroup $CustomerGroup
 * @property CarType $CarType
 * @property Customer $Customer
 * @property Zone $Zone
 * @property Parc $Parc
 * @property Autorisation $Autorisation
 * @property Affectationpv $Affectationpv
 * @property User $User
 * @property Profile $Profile
 * @property Dompdf $dompdf
 * @property Company $Company
 * @property CarOption $CarOption
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class CustomerCarsController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'RequestHandler', 'Security');
    public $uses = array(
        'CustomerCar',
        'CustomerGroup',
        'Company',
        'Customer',
        'CarOption',
        'Profile',
        'Zone',
        'Affectationpv',
        'Autorisation',
        'CarType',
        'Parc'
    );

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

        if ($this->IsAdministrator) {
            $parcIds = array();
        } else {
            $parcIds = $this->getParcsUserIdsArray($userId);
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        $cond = $this->getConditions();
        $conditions = $cond[0];
        $conditions_car = $cond[1];
        $conditions_customer = $cond[2];

        if (!$this->IsAdministrator){
            array_push($conditions,array('Car.parc_id' => $parcIds));
        }

        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => $limit,
            'order' => array('CustomerCar.id' => 'DESC'),
            'conditions' => $conditions,
            'fields' => array(
                'CustomerCar.id',
                'start',
                'end',
                'end_real',
                'CustomerCar.disabled',
                'CustomerCar.locked',
                'CustomerCar.validated',
                'CustomerCar.user_id',
                'Customer.first_name',
                'Customer.last_name',
                'Customer.company',
                'Customer.mobile',
                'Car.code',
                'Car.parc_id',
                'Car.immatr_prov',
                'Car.immatr_def',
                'Car.parc_id',
                'Carmodel.name',
                'Zone.name',
                'CustomerGroup.name'

            ),
            'joins' => array(
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('CustomerCar.car_id = Car.id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('CustomerCar.customer_id = Customer.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'zones',
                    'type' => 'left',
                    'alias' => 'Zone',
                    'conditions' => array('CustomerCar.zone_id = Zone.id')
                ),
                array(
                    'table' => 'customer_groups',
                    'type' => 'left',
                    'alias' => 'CustomerGroup',
                    'conditions' => array('CustomerCar.customer_group_id = CustomerGroup.id')
                )

            )
        );

        $customercars = $this->Paginator->paginate('CustomerCar');

        $this->set('customercars', $customercars);

        // Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', IFNULL(Carmodel.name,'Sans model'))"
            );
        } elseif ($param == 2) {

            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $conditions_car = $this->getCarConditionsUserParcs($conditions_car);
        $cars = $this->CustomerCar->Car->find('list', array(
            'fields' => 'cnames',
            'recursive' => -1,
            'order' => 'Carmodel.name asc',
            'conditions' => $conditions_car,
            'joins' => array(
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
            )

        ));
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions_customer);

        $users = $this->User->getUsers();
        $profiles = $this->Profile->getUserProfiles();
        $zones = $this->Zone->getZones();
        if ($this->IsAdministrator){
            $parcs = $this->Parc->getParcs('list');
        }else{
            if (!empty($parcIds)) {
                $parcs = $this->Parc->getParcByIds($parcIds);
            } else {
                $parcs = $this->Parc->getParcs('list');
            }
        }
        $nb_parcs = count($parcIds);
        $customerGroups = $this->CustomerGroup->getCustomerGroups();
        $hasParc = $this->verifyUserParcPermission(SectionsEnum::affectation);
        $report_pdf = $this->reports(2);
        $isSuperAdmin = $this->isSuperAdmin();
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        $printPv = $this->AccessPermission->getPermissionWithParams(SectionsEnum::pv_affectation,
            ActionsEnum::printing, $profileId, $roleId);
        $printDecharge = $this->AccessPermission->getPermissionWithParams(SectionsEnum::decharge_affectation,
            ActionsEnum::printing, $profileId, $roleId);
        $printAffectation = $this->AccessPermission->getPermissionWithParams(SectionsEnum::affectation,
            ActionsEnum::printing, $profileId, $roleId);

        $this->set(compact('profiles', 'cars', 'customers', 'users', 'zones', 'limit', 'hasParc', 'parcs',
            'nb_parcs', 'param', 'customerGroups', 'conditions', 'conditions_car', 'conditions_customer',
            'report_pdf', 'isSuperAdmin','printPv','printDecharge','printAffectation'));
    }

    public function getConditions()
    {
        $userId = intval($this->Auth->user('id'));
        // get user's parc to verify parc rights
        $parc_id = $this->getParcsUserIdsArray($userId);
        // Verify these rights
        $result = $this->verifyUserPermission(SectionsEnum::affectation, $userId, ActionsEnum::view, "CustomerCars",
            null, "CustomerCar", null);
        if (!$this->verifyUserParcPermission(SectionsEnum::affectation)) {
            switch ($result) {
                case '1' :
                    $conditions = array('Car.parc_id' => $parc_id, 'CustomerCar.validated' => 1);
                    $conditions_car = array('Car.parc_id' => $parc_id, 'Car.car_status_id !=' => 27);
                    $conditions_customer = array('Customer.parc_id' => $parc_id);
                    break;

                case '2' :
                    $conditions = array(
                        'CustomerCar.user_id' => $userId,
                        'Car.parc_id' => $parc_id,
                        'CustomerCar.validated' => 1
                    );
                    $conditions_car = array(
                        'Car.user_id' => $userId,
                        'Car.parc_id' => $parc_id,
                        'Car.car_status_id !=' => 27
                    );
                    $conditions_customer = array('Customer.user_id' => $userId, 'Customer.parc_id' => $parc_id);
                    break;

                case '3' :
                    $conditions = array(
                        'CustomerCar.user_id !=' => $userId,
                        'Car.parc_id' => $parc_id,
                        'CustomerCar.validated' => 1
                    );
                    $conditions_car = array(
                        'Car.user_id !=' => $userId,
                        'Car.parc_id' => $parc_id,
                        'Car.car_status_id !=' => 27
                    );
                    $conditions_customer = array('Customer.user_id !=' => $userId, 'Customer.parc_id' => $parc_id);
                    break;

                default:
                    $conditions = array('Car.parc_id' => $parc_id, 'CustomerCar.validated' => 1);
                    $conditions_car = array('Car.parc_id' => $parc_id, 'Car.car_status_id !=' => 27);
                    $conditions_customer = array('Customer.parc_id' => $parc_id);
            }

        } else {
            switch ($result) {
                case 1 :
                    $conditions = array('CustomerCar.validated' => 1);
                    $conditions_car = array('Car.car_status_id !=' => 27);
                    $conditions_customer = null;
                    break;
                case 2 :
                    $conditions = array('CustomerCar.user_id' => $userId, 'CustomerCar.validated' => 1);
                    $conditions_car = array('Car.user_id' => $userId, 'Car.car_status_id !=' => 27);
                    $conditions_customer = array('Customer.user_id' => $userId);
                    break;
                case 3 :
                    $conditions = array('CustomerCar.user_id !=' => $userId, 'CustomerCar.validated' => 1);
                    $conditions_car = array('Car.user_id !=' => $userId, 'Car.car_status_id !=' => 27);
                    $conditions_customer = array('Customer.user_id !=' => $userId);
                    break;
                default:
                    $conditions = array('CustomerCar.validated' => 1);
                    $conditions_car = array('Car.car_status_id !=' => 27);
                    $conditions_customer = null;
            }


        }

        $cond = array();
        $cond[0] = $conditions;
        $cond[1] = $conditions_car;
        $cond[2] = $conditions_customer;
        return $cond;


    }

    public function index_temporary()
    {

        $this->setTimeActif();

        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $cond = $this->getConditionsTemporary();
        $conditions = $cond[0];
        $conditions_car = $cond[1];
        $conditions_customer = $cond[2];


        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => $limit,
            'order' => array('CustomerCar.id' => 'DESC'),
            'conditions' => $conditions,
            'fields' => array(
                'CustomerCar.id',
                'start',
                'end',
                'end_real',
                'disabled',
                'locked',
                'validated',
                'user_id',
                'Customer.first_name',
                'Customer.last_name',
                'Customer.company',
                'Customer.mobile',
                'Car.code',
                'Car.parc_id',
                'Car.immatr_prov',
                'Car.immatr_def',
                'Carmodel.name',
                'Zone.name',
                'CustomerGroup.name'
            ),
            'joins' => array(
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('CustomerCar.car_id = Car.id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('CustomerCar.customer_id = Customer.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'zones',
                    'type' => 'left',
                    'alias' => 'Zone',
                    'conditions' => array('CustomerCar.zone_id = Zone.id')
                ),
                array(
                    'table' => 'customer_groups',
                    'type' => 'left',
                    'alias' => 'CustomerGroup',
                    'conditions' => array('CustomerCar.customer_group_id = CustomerGroup.id')
                )
            )
        );
        $customercars = $this->Paginator->paginate('CustomerCar');
        $this->set('customercars', $customercars);

        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(Car.immatr_def,Car.immatr_prov), ' - ',Carmodel.name )"
            );
        }


        $cars = $this->CustomerCar->Car->find('list', array(
            'fields' => 'cnames',
            'recursive' => -1,
            'order' => 'Carmodel.name asc',
            'conditions' => $conditions_car,
            'joins' => array(

                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                )
            )
        ));
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions_customer);
        $users = $this->User->getUsers();
        $profiles = $this->Profile->getUserProfiles();
        $customerGroups = $this->CustomerGroup->getCustomerGroups();
        $zones = $this->Zone->getZones();
        $userId = intval($this->Auth->user('id'));
        $hasParc = $this->verifyUserParcPermission(SectionsEnum::affectation);

        $parcIds = $this->getParcsUserIdsArray($userId);
        if (!empty($parcIds)) {
            $parcs = $this->Parc->getParcByIds($parcIds);
        } else {
            $parcs = $this->Parc->getParcs('list');
        }
        $nb_parcs = count($parcIds);
        $isSuperAdmin = $this->isSuperAdmin();
        $profileId = intval($this->Auth->user('profile_id'));
        $roleId = intval($this->Auth->user('role_id'));
        $printAffectation = $this->AccessPermission->getPermissionWithParams(SectionsEnum::affectation,
            ActionsEnum::printing, $profileId, $roleId);
        $this->set(compact('profiles', 'cars', 'customers', 'users', 'zones',
            'limit', 'hasParc', 'parcs',
            'param', 'customerGroups', 'conditions', 'conditions_car', 'conditions_customer',
            'nb_parcs', 'isSuperAdmin','printAffectation'));
    }

    public function getConditionsTemporary()
    {

        $user_id = intval($this->Auth->user('id'));
        $parc_id = $this->getParcsUserIdsArray($user_id);

        $result = $this->verifyUserPermission(SectionsEnum::affectation_provisoire, $user_id, ActionsEnum::view,
            "CustomerCars", null, "CustomerCar", null);

        if (!$this->verifyUserParcPermission(SectionsEnum::affectation)) {
            switch ($result) {
                case 1 :
                    $conditions = array('Car.parc_id' => $parc_id, 'CustomerCar.temporary' => 1);
                    $conditions_car = array('Car.parc_id' => $parc_id, 'Car.car_status_id !=' => 27);
                    $conditions_customer = array('Customer.parc_id' => $parc_id);
                    break;
                case 2 :
                    $conditions = array(
                        'CustomerCar.user_id' => $user_id,
                        'Car.parc_id' => $parc_id,
                        'CustomerCar.temporary' => 1
                    );
                    $conditions_car = array(
                        'Car.user_id' => $user_id,
                        'Car.parc_id' => $parc_id,
                        'Car.car_status_id !=' => 27
                    );
                    $conditions_customer = array('Customer.user_id' => $user_id, 'Customer.parc_id' => $parc_id);
                    break;
                case 3 :
                    $conditions = array(
                        'CustomerCar.user_id !=' => $user_id,
                        'Car.parc_id' => $parc_id,
                        'CustomerCar.temporary' => 1
                    );
                    $conditions_car = array(
                        'Car.user_id' => $user_id,
                        'Car.parc_id' => $parc_id,
                        'Car.car_status_id !=' => 27
                    );
                    $conditions_customer = array('Customer.user_id' => $user_id, 'Customer.parc_id' => $parc_id);
                    break;
                default:
                    $conditions = array('Car.parc_id' => $parc_id, 'CustomerCar.temporary' => 1);
                    $conditions_car = array('Car.parc_id' => $parc_id, 'Car.car_status_id !=' => 27);
                    $conditions_customer = array('Customer.parc_id' => $parc_id);
            }


        } else {
            switch ($result) {
                case 1 :
                    $conditions = array('CustomerCar.temporary' => 1);
                    $conditions_car = array('Car.car_status_id !=' => 27);
                    $conditions_customer = null;
                    break;
                case 2 :
                    $conditions = array('CustomerCar.user_id' => $user_id, 'CustomerCar.temporary' => 1);
                    $conditions_car = array(
                        'Car.user_id' => $user_id,
                        'Car.parc_id' => $parc_id,
                        'Car.car_status_id !=' => 27
                    );
                    $conditions_customer = array('Customer.user_id' => $user_id, 'Customer.parc_id' => $parc_id);
                    break;
                case 3 :
                    $conditions = array('CustomerCar.user_id !=' => $user_id, 'CustomerCar.temporary' => 1);
                    $conditions_car = array(
                        'Car.user_id' => $user_id,
                        'Car.parc_id' => $parc_id,
                        'Car.car_status_id !=' => 27
                    );
                    $conditions_customer = array('Customer.user_id' => $user_id, 'Customer.parc_id' => $parc_id);
                    break;
                default:
                    $conditions = array('CustomerCar.temporary' => 1);
                    $conditions_car = array('Car.car_status_id !=' => 27);
                    $conditions_customer = null;
            }


        }

        $cond = array();
        $cond[0] = $conditions;
        $cond[1] = $conditions_car;
        $cond[2] = $conditions_customer;
        return $cond;


    }

    public function index_request()
    {

        $this->setTimeActif();

        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        $userId = intval($this->Auth->user('id'));
        $parcIds = $this->getParcsUserIdsArray($userId);
        $cond = $this->getConditionsRequest();
        $conditions = $cond[0];
        $conditions_car = $cond[1];
        $conditions_customer = $cond[2];


        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => $limit,
            'order' => array('CustomerCar.id' => 'DESC'),
            'conditions' => $conditions,
            'fields' => array(
                'CustomerCar.id',
                'start',
                'end',
                'disabled',
                'locked',
                'validated',
                'request',
                'user_id',
                'Customer.first_name',
                'Customer.last_name',
                'Customer.company',
                'Customer.mobile',
                'Car.code',
                'Car.parc_id',
                'Car.immatr_prov',
                'Car.immatr_def',
                'Carmodel.name',
                'Zone.name',
                'CustomerGroup.name',
                'CarType.name',
                'created',
                'modified'
            ),
            'joins' => array(
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('CustomerCar.car_id = Car.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('CustomerCar.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('CustomerCar.customer_id = Customer.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'zones',
                    'type' => 'left',
                    'alias' => 'Zone',
                    'conditions' => array('CustomerCar.zone_id = Zone.id')
                ),
                array(
                    'table' => 'customer_groups',
                    'type' => 'left',
                    'alias' => 'CustomerGroup',
                    'conditions' => array('CustomerCar.customer_group_id = CustomerGroup.id')
                )
            )
        );
        $this->set('customercars', $this->Paginator->paginate('CustomerCar'));


        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(Car.immatr_def,Car.immatr_prov), ' - ',Carmodel.name )"
            );
        }


        $cars = $this->CustomerCar->Car->find('list', array(
            'fields' => 'cnames',
            'recursive' => -1,
            'order' => 'Carmodel.name asc',
            'conditions' => $conditions_car,
            'joins' => array(
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                )
            )
        ));
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions_customer);
        $users = $this->User->getUsers();
        $profiles = $this->Profile->getUserProfiles();
        if (!empty($parcIds)) {
            $parcs = $this->Parc->getParcByIds($parcIds);
        } else {
            $parcs = $this->Parc->getParcs('list');
        }
        $nb_parcs = count($parcIds);
        $customerGroups = $this->CustomerGroup->getCustomerGroups();
        $zones = $this->Zone->getZones();
        $hasParc = $this->verifyUserParcPermission(SectionsEnum::demande_affectation);

        $isCustomer = $this->isCustomer();

        $this->set('isCustomer', $isCustomer);
        $isSuperAdmin = $this->isSuperAdmin();
        $this->set(compact('profiles', 'cars', 'customers', 'users', 'zones', 'limit', 'hasParc', 'parcs',
            'nb_parcs', 'param', 'customerGroups', 'conditions', 'conditions_car', 'conditions_customer', 'isSuperAdmin'));


    }

    public function getConditionsRequest()
    {

        $userId = intval($this->Auth->user('id'));
        $parc_id = $this->getParcsUserIdsArray($userId);
        $result = $this->verifyUserPermission(SectionsEnum::demande_affectation, $userId, ActionsEnum::view,
            "CustomerCars", null, "CustomerCar", null);

        if (!$this->verifyUserParcPermission(SectionsEnum::demande_affectation)) {
            switch ($result) {
                case 1 :
                    $conditions = array('Car.parc_id' => $parc_id, 'CustomerCar.request' => 1);
                    $conditions_car = array('Car.parc_id' => $parc_id, 'Car.car_status_id !=' => 27);
                    $conditions_customer = array('Customer.parc_id' => $parc_id);

                    break;
                case 2 :
                    $conditions = array(
                        'CustomerCar.user_id' => $userId,
                        'Car.parc_id' => $parc_id,
                        'CustomerCar.request' => 1
                    );
                    $conditions_car = array(
                        'Car.user_id' => $userId,
                        'Car.parc_id' => $parc_id,
                        'Car.car_status_id !=' => 27
                    );
                    $conditions_customer = array('Customer.user_id' => $userId, 'Customer.parc_id' => $parc_id);
                    break;
                case 3 :
                    $conditions = array(
                        'CustomerCar.user_id !=' => $userId,
                        'Car.parc_id' => $parc_id,
                        'CustomerCar.request' => 1
                    );
                    $conditions_car = array(
                        'Car.user_id' => $userId,
                        'Car.parc_id' => $parc_id,
                        'Car.car_status_id !=' => 27
                    );
                    $conditions_customer = array('Customer.user_id' => $userId, 'Customer.parc_id' => $parc_id);
                    break;
                default:
                    $conditions = array('Car.parc_id' => $parc_id, 'CustomerCar.request' => 1);
                    $conditions_car = array('Car.parc_id' => $parc_id, 'Car.car_status_id !=' => 27);
                    $conditions_customer = array('Customer.parc_id' => $parc_id);
            }


        } else {
            switch ($result) {
                case 1 :
                    $conditions = array('CustomerCar.request' => 1);
                    $conditions_car = array('Car.car_status_id !=' => 27);
                    $conditions_customer = null;
                    break;
                case 2 :
                    $conditions = array('CustomerCar.user_id' => $userId, 'CustomerCar.request' => 1);
                    $conditions_car = array(
                        'Car.user_id' => $userId,
                        'Car.parc_id' => $parc_id,
                        'Car.car_status_id !=' => 27
                    );
                    $conditions_customer = array('Customer.user_id' => $userId, 'Customer.parc_id' => $parc_id);
                    break;
                case 3 :
                    $conditions = array('CustomerCar.user_id !=' => $userId, 'CustomerCar.request' => 1);
                    $conditions_car = array(
                        'Car.user_id' => $userId,
                        'Car.parc_id' => $parc_id,
                        'Car.car_status_id !=' => 27
                    );
                    $conditions_customer = array('Customer.user_id' => $userId, 'Customer.parc_id' => $parc_id);
                    break;
                default:
                    $conditions = array('CustomerCar.request' => 1);
                    $conditions_car = array('Car.car_status_id !=' => 27);
                    $conditions_customer = null;
            }


        }

        $cond = array();
        $cond[0] = $conditions;
        $cond[1] = $conditions_car;
        $cond[2] = $conditions_customer;
        return $cond;


    }

    public function search()
    {
        // Set user time actif
        $this->setTimeActif();

        if (isset($this->request->data['keyword']) || isset($this->request->data['CustomerCars']['car_id'])
            || isset($this->request->data['CustomerCars']['customer_id']) || isset($this->request->data['CustomerCars']['user_id'])
            || isset($this->request->data['CustomerCars']['start1']) || isset($this->request->data['CustomerCars']['end_planned1'])
            || isset($this->request->data['CustomerCars']['start2']) || isset($this->request->data['CustomerCars']['end_planned2'])
            || isset($this->request->data['CustomerCars']['end_real1']) || isset($this->request->data['CustomerCars']['end_real2'])
            || isset($this->request->data['CustomerCars']['created']) || isset($this->request->data['CustomerCars']['created1'])
            || isset($this->request->data['CustomerCars']['modified_id']) || isset($this->request->data['CustomerCars']['paid'])
            || isset($this->request->data['CustomerCars']['modified']) || isset($this->request->data['CustomerCars']['modified1'])
            || isset($this->request->data['CustomerCars']['zone_id']) || isset($this->request->data['CustomerCars']['parc_id'])
            || isset($this->request->data['CustomerCars']['temporary']) || isset($this->request->data['CustomerCars']['profile_id'])
            || isset($this->request->data['CustomerCars']['validated']) || isset($this->request->data['CustomerCars']['request'])
            || isset($this->request->data['CustomerCars']['customer_group_id']) || isset($this->request->data['CustomerCars']['state'])
            || isset($this->params['data']['conditions']) || isset($this->params['data']['conditions_car']) || isset($this->params['data']['conditions_customer'])
        ) {
            $this->filterUrl();
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->params['named']['keyword']) || isset($this->params['named']['car'])
            || isset($this->params['named']['customer']) || isset($this->params['named']['user'])
            || isset($this->params['named']['start1']) || isset($this->params['named']['end1'])
            || isset($this->params['named']['start2']) || isset($this->params['named']['end2'])
            || isset($this->params['named']['end_real1']) || isset($this->params['named']['end_real2'])
            || isset($this->params['named']['zone']) || isset($this->params['named']['parc'])
            || isset($this->params['named']['created']) || isset($this->params['named']['created1'])
            || isset($this->params['named']['modified_id']) || isset($this->params['named']['paid'])
            || isset($this->params['named']['modified']) || isset($this->params['named']['modified1'])
            || isset($this->params['named']['validated']) || isset($this->params['named']['request'])
            || isset($this->params['named']['customerGroup']) || isset($this->params['named']['state'])
            || isset($this->params['named']['conditions']) || isset($this->params['named']['conditions_car'])
            || isset($this->params['named']['temporary']) || isset($this->params['named']['profile'])
            || isset($this->params['named']['conditions_customer'])
        ) {

            // verify if it is a request (1) or a list (0)

            $request = isset($this->params['named']['request']) ? $this->params['named']['request'] : null;
            $this->set('request', $request);

            $temporary = isset($this->params['named']['temporary']) ? $this->params['named']['temporary'] : null ;
            $this->set('temporary', $temporary);

            $conditions = $this->getConds();
            $conditions_index = unserialize(base64_decode($this->params['named']['conditions']));

            if (!empty($conditions_index)) {
                $conditions = array_merge($conditions, $conditions_index);
            } else {
                $conditions_index = null;
            }


            $this->paginate = array(
                'paramType' => 'querystring',
                'recursive' => -1, // should be used with joins
                'limit' => $limit,
                'conditions' => $conditions,
                'order' => array('CustomerCar.id' => 'DESC'),
                'fields' => array(
                    'CustomerCar.reference',
                    'CustomerCar.id',
                    'CustomerCar.car_id',
                    'CustomerCar.user_id',
                    'start',
                    'end',
                    'end_real',
                    'disabled',
                    'locked',
                    'validated',
                    'request',
                    'Customer.first_name',
                    'Customer.last_name',
                    'Customer.company',
                    'Customer.mobile',
                    'Car.code',
                    'Car.immatr_prov',
                    'Car.immatr_def',
                    'Carmodel.name',
                    'Zone.name',
                    'CustomerGroup.name',
                    'CustomerCar.created',
                    'CustomerCar.modified',
                    'created',
                    'modified'
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
                    ),
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('CustomerCar.customer_id = Customer.id')
                    ),
                    array(
                        'table' => 'zones',
                        'type' => 'left',
                        'alias' => 'Zone',
                        'conditions' => array('CustomerCar.zone_id = Zone.id')
                    ),
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('CustomerCar.user_id = User.id')
                    ),
                    array(
                        'table' => 'customer_groups',
                        'type' => 'left',
                        'alias' => 'CustomerGroup',
                        'conditions' => array('CustomerCar.customer_group_id = CustomerGroup.id')
                    )

                ),

            );
            $this->set('customercars', $this->paginate('CustomerCar'));
        } else {
            $this->paginate = array(
                'paramType' => 'querystring',
                'recursive' => -1, // should be used with joins
                'limit' => $limit,
                'order' => array('CustomerCar.id' => 'DESC'),
                'fields' => array(
                    'CustomerCar.reference',
                    'CustomerCar.id',
                    'CustomerCar.car_id',
                    'start',
                    'end',
                    'end_real',
                    'disabled',
                    'locked',
                    'validated',
                    'request',
                    'Customer.first_name',
                    'Customer.last_name',
                    'Customer.company',
                    'Customer.mobile',
                    'Car.code',
                    'Car.immatr_prov',
                    'Car.immatr_def',
                    'Carmodel.name',
                    'Zone.name',
                    'CustomerGroup.name',
                    'CustomerCar.created',
                    'CustomerCar.modified',
                    'created',
                    'modified'
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
                    ),
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('CustomerCar.customer_id = Customer.id')
                    ),
                    array(
                        'table' => 'zones',
                        'type' => 'left',
                        'alias' => 'Zone',
                        'conditions' => array('CustomerCar.zone_id = Zone.id')
                    ),
                    array(
                        'table' => 'customer_groups',
                        'type' => 'left',
                        'alias' => 'CustomerGroup',
                        'conditions' => array('CustomerCar.customer_group_id = CustomerGroup.id')
                    ),
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('CustomerCar.user_id = User.id')
                    ),
                ),
            );
            $this->set('customercars', $this->paginate('CustomerCar'));

        }
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', IFNULL(Carmodel.name,'Sans model'))"
            );
        } elseif ($param == 2) {

            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' / ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        if (!empty($this->params['named']['conditions_car'])) {
            $conditions_car = unserialize(base64_decode($this->params['named']['conditions_car']));
        } else {
            $conditions_car = null;
        }
        $conditions_car = $this->getCarConditionsUserParcs($conditions_car);

        $cars = $this->CustomerCar->Car->find('list', array(
            'fields' => 'cnames',
            'recursive' => 1,
            'order' => 'Carmodel.name asc',
            'conditions' => $conditions_car
        ));


        if (!empty($this->params['named']['conditions_customer'])) {
            $conditions_customer = unserialize(base64_decode($this->params['named']['conditions_customer']));
        } else {
            $conditions_customer = null;
        }
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions_customer);
        $users = $this->User->getUsers();
        $profiles = $this->Profile->getUserProfiles();
        $zones = $this->Zone->getZones();
        $userId = intval($this->Auth->user('id'));
        $parcIds = $this->getParcsUserIdsArray($userId);
        if ($this->IsAdministrator){
            $parcs = $this->Parc->getParcs('list');
        }else{
            if (!empty($parcIds)) {
                $parcs = $this->Parc->getParcByIds($parcIds);
            } else {
                $parcs = $this->Parc->getParcs('list');
            }
        }

        $nb_parcs = count($parcIds);
        $customerGroups = $this->CustomerGroup->getCustomerGroups();
        $hasParc = $this->verifyUserParcPermission(SectionsEnum::affectation);
        $isSuperAdmin = $this->isSuperAdmin();
        $this->set(compact('profiles', 'cars', 'customers', 'users', 'zones', 'limit', 'parcs', 'hasParc',
            'nb_parcs', 'isSuperAdmin',
            'param', 'customerGroups', 'conditions_index', 'conditions_car', 'conditions_customer'));
        $this->render();
    }

    private function filterUrl()
    {
        $filter_url['controller'] = $this->request->params['controller'];
        $filter_url['action'] = $this->request->params['action'];
        $filter_url['page'] = 1;
        $filter_url['keyword'] = $this->request->data['keyword'];
        $filter_url['conditions'] = $this->params['data']['conditions'];
        $filter_url['conditions_car'] = $this->params['data']['conditions_car'];
        $filter_url['conditions_customer'] = $this->params['data']['conditions_customer'];
        if (isset($this->request->data['CustomerCars']['car_id']) && !empty($this->request->data['CustomerCars']['car_id'])) {
            $filter_url['car'] = $this->request->data['CustomerCars']['car_id'];
        }
        if (isset($this->request->data['CustomerCars']['customer_id']) && !empty($this->request->data['CustomerCars']['customer_id'])) {
            $filter_url['customer'] = $this->request->data['CustomerCars']['customer_id'];
        }
        if (isset($this->request->data['CustomerCars']['user_id']) && !empty($this->request->data['CustomerCars']['user_id'])) {
            $filter_url['user'] = $this->request->data['CustomerCars']['user_id'];
        }
        if (isset($this->request->data['CustomerCars']['zone_id']) && !empty($this->request->data['CustomerCars']['zone_id'])) {
            $filter_url['zone'] = $this->request->data['CustomerCars']['zone_id'];
        }
        if (isset($this->request->data['CustomerCars']['parc_id']) && !empty($this->request->data['CustomerCars']['parc_id'])) {
            $filter_url['parc'] = $this->request->data['CustomerCars']['parc_id'];
        }
        if (isset($this->request->data['CustomerCars']['customer_group_id']) && !empty($this->request->data['CustomerCars']['customer_group_id'])) {
            $filter_url['customerGroup'] = $this->request->data['CustomerCars']['customer_group_id'];
        }
        if (isset($this->request->data['CustomerCars']['state']) && !empty($this->request->data['CustomerCars']['state'])) {
            $filter_url['state'] = $this->request->data['CustomerCars']['state'];
        }
        if (isset($this->request->data['CustomerCars']['paid']) && !empty($this->request->data['CustomerCars']['paid'])) {
            $filter_url['paid'] = $this->request->data['CustomerCars']['paid'];
        }
        if (isset($this->request->data['CustomerCars']['start1']) && !empty($this->request->data['CustomerCars']['start1'])) {
            $filter_url['start1'] = str_replace("/", "-", $this->request->data['CustomerCars']['start1']);
        }
        if (isset($this->request->data['CustomerCars']['start2']) && !empty($this->request->data['CustomerCars']['start2'])) {
            $filter_url['start2'] = str_replace("/", "-", $this->request->data['CustomerCars']['start2']);
        }
        if (isset($this->request->data['CustomerCars']['end_planned1']) && !empty($this->request->data['CustomerCars']['end_planned1'])) {
            $filter_url['end1'] = str_replace("/", "-", $this->request->data['CustomerCars']['end_planned1']);
        }
        if (isset($this->request->data['CustomerCars']['end_planned2']) && !empty($this->request->data['CustomerCars']['end_planned2'])) {
            $filter_url['end2'] = str_replace("/", "-", $this->request->data['CustomerCars']['end_planned2']);
        }
        if (isset($this->request->data['CustomerCars']['end_real1']) && !empty($this->request->data['CustomerCars']['end_real1'])) {
            $filter_url['end1'] = str_replace("/", "-", $this->request->data['CustomerCars']['end_real1']);
        }
        if (isset($this->request->data['CustomerCars']['end_real2']) && !empty($this->request->data['CustomerCars']['end_real2'])) {
            $filter_url['end2'] = str_replace("/", "-", $this->request->data['CustomerCars']['end_real2']);
        }
        if (isset($this->request->data['CustomerCars']['created']) && !empty($this->request->data['CustomerCars']['created'])) {
            $filter_url['created'] = str_replace("/", "-", $this->request->data['CustomerCars']['created']);
        }
        if (isset($this->request->data['CustomerCars']['created1']) && !empty($this->request->data['CustomerCars']['created1'])) {
            $filter_url['created1'] = str_replace("/", "-", $this->request->data['CustomerCars']['created1']);
        }
        if (isset($this->request->data['CustomerCars']['modified_id']) && !empty($this->request->data['CustomerCars']['modified_id'])) {
            $filter_url['modified_id'] = $this->request->data['CustomerCars']['modified_id'];
        }
        if (isset($this->request->data['CustomerCars']['modified']) && !empty($this->request->data['CustomerCars']['modified'])) {
            $filter_url['modified'] = str_replace("/", "-", $this->request->data['CustomerCars']['modified']);
        }
        if (isset($this->request->data['CustomerCars']['modified1']) && !empty($this->request->data['CustomerCars']['modified1'])) {
            $filter_url['modified1'] = str_replace("/", "-", $this->request->data['CustomerCars']['modified1']);
        }
        if (isset($this->request->data['CustomerCars']['validated']) && !empty($this->request->data['CustomerCars']['validated'])) {
            $filter_url['validated'] = $this->request->data['CustomerCars']['validated'];
        }
        if (isset($this->request->data['CustomerCars']['request'])) {
            $filter_url['request'] = $this->request->data['CustomerCars']['request'];
        }
        if (isset($this->request->data['CustomerCars']['temporary'])) {
            $filter_url['temporary'] = $this->request->data['CustomerCars']['temporary'];
        }
        if (isset($this->request->data['CustomerCars']['profile_id']) && !empty($this->request->data['CustomerCars']['profile_id'])) {
            $filter_url['profile'] = $this->request->data['CustomerCars']['profile_id'];
        }
        return $this->redirect($filter_url);
    }

    private function getConds()
    {
        if (!empty($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $conds = array(
                'OR' => array(
                    "LOWER(Customer.first_name) LIKE" => "%$keyword%",
                    "LOWER(Customer.last_name) LIKE" => "%$keyword%",
                    "LOWER(Car.code) LIKE" => "%$keyword%",
                    "LOWER(Car.immatr_def) LIKE" => "%$keyword%",
                    "LOWER(Carmodel.name) LIKE" => "%$keyword%",
                )
            );
        } else {
            $conds = array();
        }
        if (isset($this->params['named']['car']) && !empty($this->params['named']['car'])) {
            $conds["CustomerCar.car_id = "] = $this->params['named']['car'];
            $this->request->data['CustomerCars']['car_id'] = $this->params['named']['car'];
        }
        if (isset($this->params['named']['customer']) && !empty($this->params['named']['customer'])) {
            $conds["CustomerCar.customer_id = "] = $this->params['named']['customer'];
            $this->request->data['CustomerCars']['customer_id'] = $this->params['named']['customer'];
        }
        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $conds["CustomerCar.user_id = "] = $this->params['named']['user'];
            $this->request->data['CustomerCars']['user_id'] = $this->params['named']['user'];
        }
        if (isset($this->params['named']['profile']) && !empty($this->params['named']['profile'])) {
            $conds["User.profile_id = "] = $this->params['named']['profile'];
            $this->request->data['CustomerCars']['profile_id'] = $this->params['named']['profile'];
        }
        if (isset($this->params['named']['zone']) && !empty($this->params['named']['zone'])) {
            $conds["CustomerCar.zone_id = "] = $this->params['named']['zone'];
            $this->request->data['CustomerCars']['zone_id'] = $this->params['named']['zone'];
        }
        if (isset($this->params['named']['parc']) && !empty($this->params['named']['parc'])) {
            $conds["Car.parc_id = "] = $this->params['named']['parc'];
            $this->request->data['CustomerCars']['parc_id'] = $this->params['named']['parc'];
        }
        if (isset($this->params['named']['customerGroup']) && !empty($this->params['named']['customerGroup'])) {
            $conds["CustomerCar.customer_group_id = "] = $this->params['named']['customerGroup'];
            $this->request->data['CustomerCars']['customer_group_id'] = $this->params['named']['customerGroup'];
        }
        if (isset($this->params['named']['paid']) && !empty($this->params['named']['paid'])) {
            if ($this->params['named']['paid'] == 2) {
                $conds["CustomerCar.paid = "] = 0;
                $this->request->data['CustomerCars']['paid'] = 2;
            }
            if ($this->params['named']['paid'] == 1) {
                $conds["CustomerCar.paid = "] = 1;
                $this->request->data['CustomerCars']['paid'] = 1;
            }
        }
        if (isset($this->params['named']['state']) && !empty($this->params['named']['state'])) {
            $current_date = date("Y-m-d H:i");
            if ($this->params['named']['state'] == 2) {
                $conds["CustomerCar.end_real < "] = $current_date;
                $this->request->data['CustomerCars']['state'] = 2;
            }
            if ($this->params['named']['state'] == 1) {
                $conds["CustomerCar.end_real = "] = null;
                $this->request->data['CustomerCars']['state'] = 1;
            }
        }
        if (isset($this->params['named']['start1']) && !empty($this->params['named']['start1'])) {
            $start = str_replace("-", "/", $this->params['named']['start1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $conds["CustomerCar.start >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['CustomerCars']['start1'] = $start;
        }
        if (isset($this->params['named']['start2']) && !empty($this->params['named']['start2'])) {
            $start = str_replace("-", "/", $this->params['named']['start2']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $conds["CustomerCar.start <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['CustomerCars']['start2'] = $start;
        }
        if (isset($this->params['named']['end1']) && !empty($this->params['named']['end1'])) {
            $end = str_replace("-", "/", $this->params['named']['end1']);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $conds["CustomerCar.end >= "] = $enddtm->format('Y-m-d 00:00:00');
            $this->request->data['CustomerCars']['end_planned1'] = $end;
        }
        if (isset($this->params['named']['end2']) && !empty($this->params['named']['end2'])) {
            $end = str_replace("-", "/", $this->params['named']['end2']);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $conds["CustomerCar.end <= "] = $enddtm->format('Y-m-d 00:00:00');
            $this->request->data['CustomerCars']['end_planned2'] = $end;
        }
        if (isset($this->params['named']['end_real1']) && !empty($this->params['named']['end_real1'])) {
            $end = str_replace("-", "/", $this->params['named']['end_real1']);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $conds["CustomerCar.end_real >= "] = $enddtm->format('Y-m-d 00:00:00');
            $this->request->data['CustomerCars']['end_real1'] = $end;
        }
        if (isset($this->params['named']['end_real2']) && !empty($this->params['named']['end_real2'])) {
            $end = str_replace("-", "/", $this->params['named']['end_real2']);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $conds["CustomerCar.end_real <= "] = $enddtm->format('Y-m-d 00:00:00');
            $this->request->data['CustomerCars']['end_real2'] = $end;
        }
        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $creat = str_replace("-", "/", $this->params['named']['created']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["CustomerCar.created >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['CustomerCars']['created'] = $creat;
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $creat = str_replace("-", "/", $this->params['named']['created1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["CustomerCar.created <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['CustomerCars']['created1'] = $creat;
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $conds["CustomerCar.modified_id = "] = $this->params['named']['modified_id'];
            $this->request->data['CustomerCars']['modified_id'] = $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["CustomerCar.modified >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['CustomerCars']['modified'] = $creat;
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["CustomerCar.modified <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['CustomerCars']['modified1'] = $creat;
        }
        if (isset($this->params['named']['validated']) && !empty($this->params['named']['validated'])) {
            $conds["CustomerCar.validated = "] = $this->params['named']['validated'];
            $this->request->data['CustomerCars']['validated'] = $this->params['named']['validated'];
        }
        if (isset($this->params['named']['request']) && !empty($this->params['named']['request'])) {
            $conds["CustomerCar.request = "] = $this->params['named']['request'];
            $this->request->data['CustomerCars']['request'] = $this->params['named']['request'];
        }

        if (isset($this->params['named']['temporary']) && !empty($this->params['named']['temporary'])) {
            $conds["CustomerCar.temporary = "] = $this->params['named']['temporary'];
            $this->request->data['CustomerCars']['temporary'] = $this->params['named']['temporary'];
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
        if (!$this->CustomerCar->exists($id)) {
            throw new NotFoundException(__('Invalid affectation'));
        }
        $options = array('conditions' => array('CustomerCar.' . $this->CustomerCar->primaryKey => $id));
        $this->CustomerCar->recursive = 2;
        $customerCar = $this->CustomerCar->find('first',
            array(
                'conditions' => array('CustomerCar.' . $this->CustomerCar->primaryKey => $id),
                'recursive' =>-1,
                'fields'=>array(
                        'CustomerCar.request','CustomerCar.id','CustomerCar.remorque_id',
                    'CustomerCar.reference',
                    'CustomerCar.customer_group_id',
                        'CustomerCar.temporary','Car.code','Remorque.code',
                        'Carmodel.name','Remorquemodel.name','Customer.first_name',
                    'Customer.last_name',
                        'CustomerCar.zone_id','Zone.name','CustomerCar.accompanist',
                        'CustomerCar.date_payment','CustomerCar.caution','CustomerCar.obs',
                      'CustomerCar.departure_location',
                      'CustomerCar.start',   'CustomerCar.km', 'CustomerCar.initiale_state',
                      'CustomerCar.return_location',   'CustomerCar.end', 'CustomerCar.end_real',
                      'CustomerCar.next_km',   'CustomerCar.finale_state', 'CustomerCar.end_real',
                    'CustomerCar.pictureinit1',
                    'CustomerCar.pictureinit2',
                    'CustomerCar.pictureinit3',
                    'CustomerCar.pictureinit4',
                    'CustomerCar.picturefinal1',
                    'CustomerCar.picturefinal2',
                    'CustomerCar.picturefinal3',
                    'CustomerCar.picturefinal4',
                    'CustomerCar.created', 'User.first_name', 'User.last_name' ,
                    'CustomerCar.modified', 'Modifier.first_name' , 'Modifier.last_name',
                    'CarType.name'
                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.car_id = Car.id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'CarType',
                        'conditions' => array('Car.car_type_id = CarType.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),

                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Remorque',
                        'conditions' => array('CustomerCar.remorque_id = Remorque.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Remorquemodel',
                        'conditions' => array('Remorque.carmodel_id = Remorquemodel.id')
                    ),
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('CustomerCar.customer_id = Customer.id')
                    ),

                    array(
                        'table' => 'zones',
                        'type' => 'left',
                        'alias' => 'Zone',
                        'conditions' => array('CustomerCar.zone_id = Zone.id')
                    ),
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('CustomerCar.user_id = User.id')
                    ),

                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'Modifier',
                        'conditions' => array('CustomerCar.modified_id = Modifier.id')
                    ),


                )
                ));
        $customersGroup = $this->Customer->find('all' ,array(
                'fields' => array(
                        'Customer.first_name',
                    'Customer.last_name'
                ),
            'recursive' =>0,
                'conditions' => array(
                    'Customer.customer_group_id' => $customerCar['CustomerCar']['customer_group_id']
                )
        ));
        $current = $this->CustomerCar->find("first", array("conditions" => array("CustomerCar.id" => $id)));

        if ($current ['CustomerCar']['request'] == 1) {
            $haspermission = $this->verifyAudit(SectionsEnum::demande_affectation);
        } elseif($current ['CustomerCar']['temporary'] == 1) {
            $haspermission = $this->verifyAudit(SectionsEnum::affectation_provisoire);
        }else{
            $haspermission = $this->verifyAudit(SectionsEnum::affectation);

            $this->paginate = array(
                'recursive' => -1,
                'limit' => 5,
                'fields' => array(
                    'Autorisation.id',
                    'Autorisation.authorization_from',
                    'Autorisation.authorization_to',
                    'User.last_name',
                    'User.first_name',
                ),
                'joins' => array(
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('Autorisation.user_id = User.id')
                    )
                ),
                'conditions' => array('customer_car_id' => $id),
                'paramType' => 'querystring',

            );

            $autorisations = $this->Paginator->paginate('Autorisation');

            $affectationpv0s = $this->Affectationpv->getAffectationPv($id, 0);

            $affectationpv1s = $this->Affectationpv->getAffectationPv($id, 1);

            $this->set(compact('autorisations', 'affectationpv0s', 'affectationpv1s'));
        }

        $this->set(compact('customerCar', 'haspermission','customersGroup'));
    }

    public function add()
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::affectation, $user_id, ActionsEnum::add, "CustomerCars", null,
            "CustomerCar", null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }

        $version_of_app = $this->getVersionOfApp();
        $current_date = date("d/m/Y H:i");
        $affectation_mode = $this->getAffectationMode();
        $this->set('affectation_mode', $affectation_mode);
        if ($this->request->is('post')) {
            $this->CustomerCar->create();
            $this->createDatetimeFromDatetime('CustomerCar', 'start');
            $this->createDatetimeFromDatetime('CustomerCar', 'end');
            $this->createDatetimeFromDatetime('CustomerCar', 'end_real');
            $this->createDatetimeFromDatetime('CustomerCar', 'date_payment');
            $this->createDatetimeFromDate('CustomerCar', 'driver_license_date');

            $this->verifyAttachment('CustomerCar', 'pictureinit1', 'attachments/picturesaffectation/initialetat/',
                'add', 1, 1, null);
            $this->verifyAttachment('CustomerCar', 'pictureinit2', 'attachments/picturesaffectation/initialetat/',
                'add', 1, 1, null);
            $this->verifyAttachment('CustomerCar', 'pictureinit3', 'attachments/picturesaffectation/initialetat/',
                'add', 1, 1, null);
            $this->verifyAttachment('CustomerCar', 'pictureinit4', 'attachments/picturesaffectation/initialetat/',
                'add', 1, 1, null);
            $this->verifyAttachment('CustomerCar', 'picturefinal1', 'attachments/picturesaffectation/finaletat/', 'add',
                1, 1, null);
            $this->verifyAttachment('CustomerCar', 'picturefinal2', 'attachments/picturesaffectation/finaletat/', 'add',
                1, 1, null);
            $this->verifyAttachment('CustomerCar', 'picturefinal3', 'attachments/picturesaffectation/finaletat/', 'add',
                1, 1, null);
            $this->verifyAttachment('CustomerCar', 'picturefinal4', 'attachments/picturesaffectation/finaletat/', 'add',
                1, 1, null);

            if ($version_of_app == 'web') {

                if ($this->request->data['CustomerCar']['pictureinit1'] == '') {
                    $this->request->data['CustomerCar']['pictureinit1'] = $this->request->data['CustomerCar']['pictureinit1_dir'];
                }
                if ($this->request->data['CustomerCar']['pictureinit2'] == '') {
                    $this->request->data['CustomerCar']['pictureinit2'] = $this->request->data['CustomerCar']['pictureinit2_dir'];
                }
                if ($this->request->data['CustomerCar']['pictureinit3'] == '') {
                    $this->request->data['CustomerCar']['pictureinit3'] = $this->request->data['CustomerCar']['pictureinit3_dir'];
                }
                if ($this->request->data['CustomerCar']['pictureinit4'] == '') {
                    $this->request->data['CustomerCar']['pictureinit4'] = $this->request->data['CustomerCar']['pictureinit4_dir'];
                }
                if ($this->request->data['CustomerCar']['picturefinal1'] == '') {
                    $this->request->data['CustomerCar']['picturefinal1'] = $this->request->data['CustomerCar']['picturefinal1_dir'];
                }
                if ($this->request->data['CustomerCar']['picturefinal2'] == '') {
                    $this->request->data['CustomerCar']['picturefinal2'] = $this->request->data['CustomerCar']['picturefinal2_dir'];
                }
                if ($this->request->data['CustomerCar']['picturefinal3'] == '') {
                    $this->request->data['CustomerCar']['picturefinal3'] = $this->request->data['CustomerCar']['picturefinal3_dir'];
                }
                if ($this->request->data['CustomerCar']['picturefinal4'] == '') {
                    $this->request->data['CustomerCar']['picturefinal4'] = $this->request->data['CustomerCar']['picturefinal4_dir'];
                }

            }
            $this->request->data['CustomerCar']['user_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['CustomerCar']['request'] = 0;
            $this->request->data['CustomerCar']['validated'] = 1;
            $available = $this->verify_availability($this->request->data['CustomerCar']['car_id'],
                $this->request->data['CustomerCar']['start'], null);
            if ($available && $this->CustomerCar->save($this->request->data)) {

                $date_from = $this->request->data['Autorisation']['authorization_from'];
                $this->createDatetimeFromDatetime('Autorisation', 'authorization_from');
                $authorization_from = $this->request->data['Autorisation']['authorization_from'];
                $date_to = $this->request->data['Autorisation']['authorization_to'];
                $this->createDatetimeFromDatetime('Autorisation', 'authorization_to');
                $authorization_to = $this->request->data['Autorisation']['authorization_to'];


                $this->request->data['Autorisation']['current_date'] = $current_date;
                $this->createDatetimeFromDatetime('Autorisation', 'current_date');

                $current_date = $this->request->data['Autorisation']['current_date'];

                $customer_car_id = $this->CustomerCar->getInsertID();

                if ($this->request->data['CustomerCar']['authorized'] == 1 && $authorization_from < $current_date && $current_date < $authorization_to) {
                    $this->saveAutorisation($customer_car_id, $authorization_from, $authorization_to);
                    $this->CarAuthorized($this->request->data['CustomerCar']['car_id'],
                        $this->request->data['CustomerCar']['customer_id'], $date_from, $date_to);

                }
                $this->add_affectation_pv($this->request->data['Affectationpv'], $customer_car_id);

                $this->updateCarStatus($this->request->data['CustomerCar']['car_id'], 0);
                $this->updateCarStatus($this->request->data['CustomerCar']['remorque_id'], 1);

                $this->Flash->success(__('The affectation has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                if ($available) {
                    $this->Flash->error(__('The affectation could not be saved. Please, try again.'));
                } else {
                    $this->Flash->error(__('The affectation could not be saved because the car is already reserved in this date.'));
                }
            }
        }

        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', IFNULL(Carmodel.name,'Sans model'))"
            );
        } elseif ($param == 2) {

            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }

        $cond = $this->getConditions();
        $conditions_car = $cond[1];
        $conditions_customer = $cond[2];
        $parcIds = $this->getParcsUserIdsArray($user_id);
        $condition1 = array(
            'OR' => array(
                'Car.car_category_id !=' => 3,
                'Car.car_category_id' => null
            ),
            'Car.car_status_id' => 1
        );
        if (!empty($parcIds)){
            $condition1 = array(
                'OR' => array(
                    'Car.car_category_id !=' => 3,
                    'Car.car_category_id' => null
                ),
                'Car.car_status_id' => 1,
                'Car.parc_id' => $parcIds
            );
        }
        if ($conditions_car != null) {
            $conditions_car = array_merge($conditions_car, $condition1);
        } else {
            $conditions_car = $condition1;
        }
        if($this->IsAdministrator){
            $conditions_car = array(
                'Car.car_status_id' =>  1,
            );
        }else{
            $conditions_car = array(
                'Car.car_status_id' =>  1,
                'Car.parc_id' => $parcIds
            );
        }

        $cars = $this->CustomerCar->Car->find('list', array(
            'fields' => 'cnames',
            'recursive' => 1,
            'order' => array('Car.code asc', 'Carmodel.name asc'),
            'conditions' => $conditions_car
        ));


        $conditions_car = $cond[1];
        $conditions_remorque = array('Car.car_category_id' => 3, 'Car.car_status_id' => 1);
        if ($conditions_car != null) {
            $conditions_car = array_merge($conditions_car, $conditions_remorque);

        } else {
            $conditions_car = $conditions_remorque;
        }
        $remorques = $this->CustomerCar->Car->find('list', array(
            'fields' => 'cnames',
            'recursive' => 1,
            'order' => array('Car.code asc', 'Carmodel.name asc'),
            'conditions' => $conditions_car,
        ));


        $fields = "names";
        $conditions_customer = array('Customer.parc_id' => $parcIds);
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions_customer);

        $options = $this->CarOption->getCarOptions();
        $zones = $this->Zone->getZones();
        $customerGroups = $this->CustomerGroup->getCustomerGroups();

        $affectation_mode = $this->getAffectationMode();
        $this->set('affectation_mode', $affectation_mode);
        $reference = $this->getNextReference('CustomerCar', 'affectation');
        $controllerName = 'CustomerCars';
        $actionName = 'add';
        $this->set(compact('cars', 'customers', 'options', 'zones', 'customerGroups', 'version_of_app', 'remorques',
            'reference','controllerName','actionName'));
    }

    function verify_availability($car_id = null, $date_start = null, $customer_car = null)
    {
        $this->setTimeActif();
        $this->CustomerCar->recursive = 1;
        $customerCars1 = $this->CustomerCar->find('all', array(
            'conditions' => array(
                'CustomerCar.car_id' => $car_id,
                'CustomerCar.validated' => 1,
                'end >=' => $date_start,
                'end_real IS NULL',
                'CustomerCar.id !=' => $customer_car
            )
        ));

        $customerCars2 = $this->CustomerCar->find('all', array(
            'conditions' => array(
                'CustomerCar.car_id' => $car_id,
                'CustomerCar.validated' => 1,
                'end_real >=' => $date_start,
                'end_real IS NOT NULL',
                'CustomerCar.id !=' => $customer_car
            )
        ));

        $CarReserved1 = $this->CustomerCar->find('all', array(
            'conditions' => array(
                'CustomerCar.car_id' => $car_id,
                'CustomerCar.validated' => 1,
                array(
                    'OR' => array(
                        'start <=' => $date_start,
                        'start IS NULL'
                    )
                ),
                'end_real IS NULL',
                'CustomerCar.id !=' => $customer_car
            )
        ));


        if (empty($CarReserved1) && empty($customerCars1) && empty($customerCars2)) {

            return true;
        } else {

            return false;
        }
    }

    public function saveAutorisation(
        $customer_car_id = null,
        $authorization_from = null,
        $authorization_to = null,
        $autorisation_id = null
    )
    {
        if (!empty($autorisation_id)) {
            $data['Autorisation']['id'] = $autorisation_id;
            $data['Autorisation']['customer_car_id'] = $customer_car_id;
            $data['Autorisation']['authorization_from'] = $authorization_from;
            $data['Autorisation']['authorization_to'] = $authorization_to;
            $data['Autorisation']['user_id'] = $this->Session->read('Auth.User.id');
            $this->Autorisation->save($data);

        } else {
            $this->Autorisation->create();
            $data['Autorisation']['customer_car_id'] = $customer_car_id;
            $data['Autorisation']['authorization_from'] = $authorization_from;
            $data['Autorisation']['authorization_to'] = $authorization_to;
            $data['Autorisation']['user_id'] = $this->Session->read('Auth.User.id');
            $this->Autorisation->save($data);
        }

    }

    public function CarAuthorized(
        $car_id = null,
        $customer_id = null,
        $authorization_from = null,
        $authorization_to = null
    )
    {

        $car = $this->Car->find('first', array(
            'conditions' => array('Car.id' => $car_id),
            'recursive' => -1,
            'fields' => array('Car.immatr_def', 'Carmodel.name'),
            'joins' => array(
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                )
            )
        ));
        if (!empty($customer_id)) {
            $customer = $this->CustomerCar->Customer->find('first',
                array('conditions' => array('Customer.id' => $customer_id)));
        } else {
            $customer = array();
        }
        $user = $this->User->getUserById($this->Session->read('Auth.User.id'));
        $Email = new CakeEmail('smtp');

        $users = $this->getUsersReceiveAlert();
        if (!empty($customer_id)) {
            $msg = __("The user") . ' ' . $user['User']['first_name'] . ' ' . $user['User']['last_name'] .
                ' ' . __("has authorized a conductor") . ' ' . $customer['Customer']['first_name'] . ' ' .
                $customer['Customer']['last_name'] . ' ' . __("to take car") . ' ' . $car['Car']['immatr_def'] .
                '-' . $car['Carmodel']['name'] . ' ' . __('du') . ' ' . $authorization_from . ' ' . __('au') .
                ' ' . $authorization_to;
        } else {
            $msg = __("The user") . ' ' . $user['User']['first_name'] . ' ' . $user['User']['last_name'] . ' ' .
                __("has authorized a conductor") . ' ' . __("to take car") . ' ' . $car['Car']['immatr_def'] . '-' .
                $car['Carmodel']['name'] . ' ' . __('du') . ' ' . $authorization_from . ' ' . __('au') . ' ' .
                $authorization_to;
        }


        foreach ($users as $user) {
            $Email->addTo($user['User']['email']);
        }
        $Email->template('welcome', 'fancy')
            ->emailFormat('html')
            ->from('k.ouabou@intellixweb.com')
            ->subject('Autorisation');
        try {
            $Email->send($msg);
        } catch (Exception $ex) {

        }
    }

    public function add_affectation_pv($affectations = null, $customer_car_id = null)
    {
        $userId = intval($this->Auth->user('id'));

        if (!empty ($affectations)) {

            if (!empty ($affectations[0])) {


                $affectationpv0s = $this->Affectationpv->find('first', array(
                    'recursive' => -1,
                    'conditions' => array(
                        'Affectationpv.customer_car_id' => $customer_car_id,
                        'Affectationpv.reception' => 0
                    )
                ));

                if (empty($affectationpv0s)) {
                    $this->Affectationpv->create();
                } else {
                    $data['Affectationpv']['id'] = $affectationpv0s['Affectationpv']['id'];
                }
                $data['Affectationpv']['customer_car_id'] = $customer_car_id;
                $data['Affectationpv']['reception'] = 0;

                if (Configure::read('logistia') != '1'){
                    if (!empty($affectations[0]['grey_card'])) {
                        $data['Affectationpv']['grey_card'] = $affectations[0]['grey_card'];
                    } else {
                        $data['Affectationpv']['grey_card'] = 0;
                    }
                    if (!empty($affectations[0]['assurance'])) {
                        $data['Affectationpv']['assurance'] = $affectations[0]['assurance'];
                    } else {
                        $data['Affectationpv']['assurance'] = 0;
                    }
                    if (!empty($affectations[0]['controle_technique'])) {
                        $data['Affectationpv']['controle_technique'] = $affectations[0]['controle_technique'];
                    } else {
                        $data['Affectationpv']['controle_technique'] = 0;
                    }
                    if (!empty($affectations[0]['carnet_entretien'])) {
                        $data['Affectationpv']['carnet_entretien'] = $affectations[0]['carnet_entretien'];
                    } else {
                        $data['Affectationpv']['carnet_entretien'] = 0;
                    }
                    if (!empty($affectations[0]['carnet_bord'])) {
                        $data['Affectationpv']['carnet_bord'] = $affectations[0]['carnet_bord'];
                    } else {
                        $data['Affectationpv']['carnet_bord'] = 0;
                    }
                    if (!empty($affectations[0]['vignette'])) {
                        $data['Affectationpv']['vignette'] = $affectations[0]['vignette'];
                    } else {
                        $data['Affectationpv']['vignette'] = 0;
                    }
                    if (!empty($affectations[0]['vignette_ct'])) {
                        $data['Affectationpv']['vignette_ct'] = $affectations[0]['vignette_ct'];
                    } else {
                        $data['Affectationpv']['vignette_ct'] = 0;
                    }
                    if (!empty($affectations[0]['procuration'])) {
                        $data['Affectationpv']['procuration'] = $affectations[0]['procuration'];
                    } else {
                        $data['Affectationpv']['procuration'] = 0;
                    }
                    if (!empty($affectations[0]['roue_secours'])) {
                        $data['Affectationpv']['roue_secours'] = $affectations[0]['roue_secours'];
                    } else {
                        $data['Affectationpv']['roue_secours'] = 0;
                    }
                    if (!empty($affectations[0]['cric'])) {
                        $data['Affectationpv']['cric'] = $affectations[0]['cric'];
                    } else {
                        $data['Affectationpv']['cric'] = 0;
                    }
                    if (!empty($affectations[0]['tapis'])) {
                        $data['Affectationpv']['tapis'] = $affectations[0]['tapis'];
                    } else {
                        $data['Affectationpv']['tapis'] = 0;
                    }
                    if (!empty($affectations[0]['manivelle'])) {
                        $data['Affectationpv']['manivelle'] = $affectations[0]['manivelle'];
                    } else {
                        $data['Affectationpv']['manivelle'] = 0;
                    }
                    if (!empty($affectations[0]['boite_pharmacie'])) {
                        $data['Affectationpv']['boite_pharmacie'] = $affectations[0]['boite_pharmacie'];
                    } else {
                        $data['Affectationpv']['boite_pharmacie'] = 0;
                    }
                    if (!empty($affectations[0]['triangle'])) {
                        $data['Affectationpv']['triangle'] = $affectations[0]['triangle'];
                    } else {
                        $data['Affectationpv']['triangle'] = 0;
                    }
                    if (!empty($affectations[0]['gilet'])) {
                        $data['Affectationpv']['gilet'] = $affectations[0]['gilet'];
                    } else {
                        $data['Affectationpv']['gilet'] = 0;
                    }
                    if (!empty($affectations[0]['double_cle'])) {
                        $data['Affectationpv']['double_cle'] = $affectations[0]['double_cle'];
                    } else {
                        $data['Affectationpv']['double_cle'] = 0;
                    }
                    if (!empty($affectations[0]['sieges'])) {
                        $data['Affectationpv']['sieges'] = $affectations[0]['sieges'];
                    } else {
                        $data['Affectationpv']['sieges'] = 0;
                    }
                    if (!empty($affectations[0]['dashboard'])) {
                        $data['Affectationpv']['dashboard'] = $affectations[0]['dashboard'];
                    } else {
                        $data['Affectationpv']['dashboard'] = 0;
                    }
                    if (!empty($affectations[0]['moquette'])) {
                        $data['Affectationpv']['moquette'] = $affectations[0]['moquette'];
                    } else {
                        $data['Affectationpv']['moquette'] = 0;
                    }
                    if (!empty($affectations[0]['tapis_interieur'])) {
                        $data['Affectationpv']['tapis_interieur'] = $affectations[0]['tapis_interieur'];
                    } else {
                        $data['Affectationpv']['tapis_interieur'] = 0;
                    }
                }else{
                    if (!empty($affectations[0]['grey_card'])) {
                        $data['Affectationpv']['grey_card'] = $affectations[0]['grey_card'];
                    } else {
                        $data['Affectationpv']['grey_card'] = 0;
                    }
                    if (!empty($affectations[0]['oil_level'])) {
                        $data['Affectationpv']['oil_level'] = $affectations[0]['oil_level'];
                    } else {
                        $data['Affectationpv']['oil_level'] = 0;
                    }
                    if (!empty($affectations[0]['engin_noise'])) {
                        $data['Affectationpv']['engin_noise'] = $affectations[0]['engin_noise'];
                    } else {
                        $data['Affectationpv']['engin_noise'] = 0;
                    }
                    if (!empty($affectations[0]['breaks'])) {
                        $data['Affectationpv']['breaks'] = $affectations[0]['breaks'];
                    } else {
                        $data['Affectationpv']['breaks'] = 0;
                    }
                    if (!empty($affectations[0]['pedals'])) {
                        $data['Affectationpv']['pedals'] = $affectations[0]['pedals'];
                    } else {
                        $data['Affectationpv']['pedals'] = 0;
                    }
                    if (!empty($affectations[0]['wing_mirrors'])) {
                        $data['Affectationpv']['wing_mirrors'] = $affectations[0]['wing_mirrors'];
                    } else {
                        $data['Affectationpv']['wing_mirrors'] = 0;
                    }
                    if (!empty($affectations[0]['odometer'])) {
                        $data['Affectationpv']['odometer'] = $affectations[0]['odometer'];
                    } else {
                        $data['Affectationpv']['odometer'] = 0;
                    }
                    if (!empty($affectations[0]['doors_state'])) {
                        $data['Affectationpv']['doors_state'] = $affectations[0]['doors_state'];
                    } else {
                        $data['Affectationpv']['doors_state'] = 0;
                    }
                    if (!empty($affectations[0]['doors_operation'])) {
                        $data['Affectationpv']['doors_operation'] = $affectations[0]['doors_operation'];
                    } else {
                        $data['Affectationpv']['doors_operation'] = 0;
                    }
                    if (!empty($affectations[0]['seats'])) {
                        $data['Affectationpv']['seats'] = $affectations[0]['seats'];
                    } else {
                        $data['Affectationpv']['seats'] = 0;
                    }
                    if (!empty($affectations[0]['front_lights'])) {
                        $data['Affectationpv']['front_lights'] = $affectations[0]['front_lights'];
                    } else {
                        $data['Affectationpv']['front_lights'] = 0;
                    }
                    if (!empty($affectations[0]['wipper'])) {
                        $data['Affectationpv']['wipper'] = $affectations[0]['wipper'];
                    } else {
                        $data['Affectationpv']['wipper'] = 0;
                    }
                    if (!empty($affectations[0]['front_tires'])) {
                        $data['Affectationpv']['front_tires'] = $affectations[0]['front_tires'];
                    } else {
                        $data['Affectationpv']['front_tires'] = 0;
                    }
                    if (!empty($affectations[0]['spare_wheel'])) {
                        $data['Affectationpv']['spare_wheel'] = $affectations[0]['spare_wheel'];
                    } else {
                        $data['Affectationpv']['spare_wheel'] = 0;
                    }
                    if (!empty($affectations[0]['external_cleanliness'])) {
                        $data['Affectationpv']['external_cleanliness'] = $affectations[0]['external_cleanliness'];
                    } else {
                        $data['Affectationpv']['external_cleanliness'] = 0;
                    }
                    if (!empty($affectations[0]['internal_cleanliness'])) {
                        $data['Affectationpv']['internal_cleanliness'] = $affectations[0]['internal_cleanliness'];
                    } else {
                        $data['Affectationpv']['internal_cleanliness'] = 0;
                    }
                }


                $data['Affectationpv']['obs_customer'] = $affectations['obs_customer'];
                $data['Affectationpv']['obs_chef'] = $affectations['obs_chef'];
                $data['Affectationpv']['obs_hse'] = $affectations['obs_hse'];
                $data['Affectationpv']['user_id'] = $userId;
                $data['Affectationpv']['last_modifier_id'] = $userId;
                $this->Affectationpv->save($data);


            }

            if (!empty ($affectations[1])) {
                $affectationpv1s = $this->Affectationpv->find('first', array(
                    'recursive' => -1,
                    'conditions' => array(
                        'Affectationpv.customer_car_id' => $customer_car_id,
                        'Affectationpv.reception' => 1
                    )
                ));

                if (empty($affectationpv1s)) {
                    $this->Affectationpv->create();
                } else {
                    $data['Affectationpv']['id'] = $affectationpv1s['Affectationpv']['id'];
                }

                $data['Affectationpv']['customer_car_id'] = $customer_car_id;
                $data['Affectationpv']['reception'] = 1;
                if (Configure::read('logistia') != '1'){
                    if (!empty($affectations[1]['grey_card'])) {
                        $data['Affectationpv']['grey_card'] = $affectations[1]['grey_card'];
                    } else {
                        $data['Affectationpv']['grey_card'] = 0;
                    }
                    if (!empty($affectations[1]['assurance'])) {
                        $data['Affectationpv']['assurance'] = $affectations[1]['assurance'];
                    } else {
                        $data['Affectationpv']['assurance'] = 0;
                    }
                    if (!empty($affectations[1]['controle_technique'])) {
                        $data['Affectationpv']['controle_technique'] = $affectations[1]['controle_technique'];
                    } else {
                        $data['Affectationpv']['controle_technique'] = 0;
                    }
                    if (!empty($affectations[1]['carnet_entretien'])) {
                        $data['Affectationpv']['carnet_entretien'] = $affectations[1]['carnet_entretien'];
                    } else {
                        $data['Affectationpv']['carnet_entretien'] = 0;
                    }
                    if (!empty($affectations[1]['carnet_bord'])) {
                        $data['Affectationpv']['carnet_bord'] = $affectations[1]['carnet_bord'];
                    } else {
                        $data['Affectationpv']['carnet_bord'] = 0;
                    }
                    if (!empty($affectations[1]['vignette'])) {
                        $data['Affectationpv']['vignette'] = $affectations[1]['vignette'];
                    } else {
                        $data['Affectationpv']['vignette'] = 0;
                    }
                    if (!empty($affectations[1]['vignette_ct'])) {
                        $data['Affectationpv']['vignette_ct'] = $affectations[1]['vignette_ct'];
                    } else {
                        $data['Affectationpv']['vignette_ct'] = 0;
                    }
                    if (!empty($affectations[1]['procuration'])) {
                        $data['Affectationpv']['procuration'] = $affectations[1]['procuration'];
                    } else {
                        $data['Affectationpv']['procuration'] = 0;
                    }
                    if (!empty($affectations[1]['roue_secours'])) {
                        $data['Affectationpv']['roue_secours'] = $affectations[1]['roue_secours'];
                    } else {
                        $data['Affectationpv']['roue_secours'] = 0;
                    }
                    if (!empty($affectations[1]['cric'])) {
                        $data['Affectationpv']['cric'] = $affectations[1]['cric'];
                    } else {
                        $data['Affectationpv']['cric'] = 0;
                    }
                    if (!empty($affectations[1]['tapis'])) {
                        $data['Affectationpv']['tapis'] = $affectations[1]['tapis'];
                    } else {
                        $data['Affectationpv']['tapis'] = 0;
                    }
                    if (!empty($affectations[1]['manivelle'])) {
                        $data['Affectationpv']['manivelle'] = $affectations[1]['manivelle'];
                    } else {
                        $data['Affectationpv']['manivelle'] = 0;
                    }
                    if (!empty($affectations[1]['boite_pharmacie'])) {
                        $data['Affectationpv']['boite_pharmacie'] = $affectations[1]['boite_pharmacie'];
                    } else {
                        $data['Affectationpv']['boite_pharmacie'] = 0;
                    }
                    if (!empty($affectations[1]['triangle'])) {
                        $data['Affectationpv']['triangle'] = $affectations[1]['triangle'];
                    } else {
                        $data['Affectationpv']['triangle'] = 0;
                    }
                    if (!empty($affectations[1]['gilet'])) {
                        $data['Affectationpv']['gilet'] = $affectations[1]['gilet'];
                    } else {
                        $data['Affectationpv']['gilet'] = 0;
                    }
                    if (!empty($affectations[1]['double_cle'])) {
                        $data['Affectationpv']['double_cle'] = $affectations[1]['double_cle'];
                    } else {
                        $data['Affectationpv']['double_cle'] = 0;
                    }
                    if (!empty($affectations[1]['sieges'])) {
                        $data['Affectationpv']['sieges'] = $affectations[1]['sieges'];
                    } else {
                        $data['Affectationpv']['sieges'] = 0;
                    }
                    if (!empty($affectations[1]['dashboard'])) {
                        $data['Affectationpv']['dashboard'] = $affectations[1]['dashboard'];
                    } else {
                        $data['Affectationpv']['dashboard'] = 0;
                    }
                    if (!empty($affectations[1]['moquette'])) {
                        $data['Affectationpv']['moquette'] = $affectations[1]['moquette'];
                    } else {
                        $data['Affectationpv']['moquette'] = 0;
                    }
                    if (!empty($affectations[1]['tapis_interieur'])) {
                        $data['Affectationpv']['tapis_interieur'] = $affectations[1]['tapis_interieur'];
                    } else {
                        $data['Affectationpv']['tapis_interieur'] = 0;
                    }
                }else{
                    if (!empty($affectations[1]['grey_card'])) {
                        $data['Affectationpv']['grey_card'] = $affectations[1]['grey_card'];
                    } else {
                        $data['Affectationpv']['grey_card'] = 0;
                    }
                    if (!empty($affectations[1]['oil_level'])) {
                        $data['Affectationpv']['oil_level'] = $affectations[1]['oil_level'];
                    } else {
                        $data['Affectationpv']['oil_level'] = 0;
                    }
                    if (!empty($affectations[1]['engin_noise'])) {
                        $data['Affectationpv']['engin_noise'] = $affectations[1]['engin_noise'];
                    } else {
                        $data['Affectationpv']['engin_noise'] = 0;
                    }
                    if (!empty($affectations[1]['breaks'])) {
                        $data['Affectationpv']['breaks'] = $affectations[1]['breaks'];
                    } else {
                        $data['Affectationpv']['breaks'] = 0;
                    }
                    if (!empty($affectations[1]['pedals'])) {
                        $data['Affectationpv']['pedals'] = $affectations[1]['pedals'];
                    } else {
                        $data['Affectationpv']['pedals'] = 0;
                    }
                    if (!empty($affectations[1]['wing_mirrors'])) {
                        $data['Affectationpv']['wing_mirrors'] = $affectations[1]['wing_mirrors'];
                    } else {
                        $data['Affectationpv']['wing_mirrors'] = 0;
                    }
                    if (!empty($affectations[1]['odometer'])) {
                        $data['Affectationpv']['odometer'] = $affectations[1]['odometer'];
                    } else {
                        $data['Affectationpv']['odometer'] = 0;
                    }
                    if (!empty($affectations[1]['doors_state'])) {
                        $data['Affectationpv']['doors_state'] = $affectations[1]['doors_state'];
                    } else {
                        $data['Affectationpv']['doors_state'] = 0;
                    }
                    if (!empty($affectations[1]['doors_operation'])) {
                        $data['Affectationpv']['doors_operation'] = $affectations[1]['doors_operation'];
                    } else {
                        $data['Affectationpv']['doors_operation'] = 0;
                    }
                    if (!empty($affectations[1]['seats'])) {
                        $data['Affectationpv']['seats'] = $affectations[1]['seats'];
                    } else {
                        $data['Affectationpv']['seats'] = 0;
                    }
                    if (!empty($affectations[1]['front_lights'])) {
                        $data['Affectationpv']['front_lights'] = $affectations[1]['front_lights'];
                    } else {
                        $data['Affectationpv']['front_lights'] = 0;
                    }
                    if (!empty($affectations[1]['wipper'])) {
                        $data['Affectationpv']['wipper'] = $affectations[1]['wipper'];
                    } else {
                        $data['Affectationpv']['wipper'] = 0;
                    }
                    if (!empty($affectations[1]['front_tires'])) {
                        $data['Affectationpv']['front_tires'] = $affectations[1]['front_tires'];
                    } else {
                        $data['Affectationpv']['front_tires'] = 0;
                    }
                    if (!empty($affectations[1]['spare_wheel'])) {
                        $data['Affectationpv']['spare_wheel'] = $affectations[1]['spare_wheel'];
                    } else {
                        $data['Affectationpv']['spare_wheel'] = 0;
                    }
                    if (!empty($affectations[1]['external_cleanliness'])) {
                        $data['Affectationpv']['external_cleanliness'] = $affectations[1]['external_cleanliness'];
                    } else {
                        $data['Affectationpv']['external_cleanliness'] = 0;
                    }
                    if (!empty($affectations[1]['internal_cleanliness'])) {
                        $data['Affectationpv']['internal_cleanliness'] = $affectations[1]['internal_cleanliness'];
                    } else {
                        $data['Affectationpv']['internal_cleanliness'] = 0;
                    }
                    if (!empty($affectations[1]['accessories'])) {
                        $data['Affectationpv']['accessories'] = $affectations[1]['accessories'];
                    } else {
                        $data['Affectationpv']['accessories'] = 0;
                    }
                }

                $data['Affectationpv']['obs_customer'] = $affectations['obs_customer'];
                $data['Affectationpv']['obs_chef'] = $affectations['obs_chef'];
                $data['Affectationpv']['user_id'] = $userId;
                $data['Affectationpv']['last_modifier_id'] = $userId;
                $this->Affectationpv->save($data);

            }

            if (!empty ($affectations[2])) {
                $affectationpv2s = $this->Affectationpv->find('first', array(
                    'recursive' => -1,
                    'conditions' => array(
                        'Affectationpv.customer_car_id' => $customer_car_id,
                    )
                ));

                if (empty($affectationpv1s)) {
                    $this->Affectationpv->create();
                } else {
                    $data['Affectationpv']['id'] = $affectationpv2s['Affectationpv']['id'];
                }

                $data['Affectationpv']['customer_car_id'] = $customer_car_id;
                $data['Affectationpv']['passation'] = 1;
                if (Configure::read('logistia') == '1'){
                    if (!empty($affectations[2]['transfering_customer_id'])) {
                        $data['Affectationpv']['transfering_customer_id'] = $affectations[2]['transfering_customer_id'];
                    } else {
                        $data['Affectationpv']['transfering_customer_id'] = 0;
                    }
                    if (!empty($affectations[2]['receiving_customer_id'])) {
                        $data['Affectationpv']['receiving_customer_id'] = $affectations[2]['receiving_customer_id'];
                    } else {
                        $data['Affectationpv']['receiving_customer_id'] = 0;
                    }
                    if (!empty($affectations[2]['mechanic_state'])) {
                        $data['Affectationpv']['mechanic_state'] = $affectations[2]['mechanic_state'];
                    } else {
                        $data['Affectationpv']['mechanic_state'] = 0;
                    }
                    if (!empty($affectations[2]['obs_mechanic_state'])) {
                        $data['Affectationpv']['obs_mechanic_state'] = $affectations[2]['obs_mechanic_state'];
                    } else {
                        $data['Affectationpv']['obs_mechanic_state'] = '';
                    }
                    if (!empty($affectations[2]['electric_state'])) {
                        $data['Affectationpv']['electric_state'] = $affectations[2]['electric_state'];
                    } else {
                        $data['Affectationpv']['electric_state'] = 0;
                    }
                    if (!empty($affectations[2]['obs_electric_state'])) {
                        $data['Affectationpv']['obs_electric_state'] = $affectations[2]['obs_electric_state'];
                    } else {
                        $data['Affectationpv']['obs_electric_state'] = '';
                    }
                    if (!empty($affectations[2]['grey_card_2'])) {
                        $data['Affectationpv']['grey_card_2'] = $affectations[2]['grey_card_2'];
                    } else {
                        $data['Affectationpv']['grey_card_2'] = 0;
                    }
                    if (!empty($affectations[2]['inssurance'])) {
                        $data['Affectationpv']['inssurance'] = $affectations[2]['inssurance'];
                    } else {
                        $data['Affectationpv']['inssurance'] = 0;
                    }
                    if (!empty($affectations[2]['interview_notebook'])) {
                        $data['Affectationpv']['interview_notebook'] = $affectations[2]['interview_notebook'];
                    } else {
                        $data['Affectationpv']['interview_notebook'] = 0;
                    }
                    if (!empty($affectations[2]['dashboard_notebook'])) {
                        $data['Affectationpv']['dashboard_notebook'] = $affectations[2]['dashboard_notebook'];
                    } else {
                        $data['Affectationpv']['dashboard_notebook'] = 0;
                    }
                    if (!empty($affectations[2]['thumbnail'])) {
                        $data['Affectationpv']['thumbnail'] = $affectations[2]['thumbnail'];
                    } else {
                        $data['Affectationpv']['thumbnail'] = 0;
                    }
                    if (!empty($affectations[2]['post_auto'])) {
                        $data['Affectationpv']['post_auto'] = $affectations[2]['post_auto'];
                    } else {
                        $data['Affectationpv']['post_auto'] = 0;
                    }
                    if (!empty($affectations[2]['slaps'])) {
                        $data['Affectationpv']['slaps'] = $affectations[2]['slaps'];
                    } else {
                        $data['Affectationpv']['slaps'] = 0;
                    }
                    if (!empty($affectations[2]['jack'])) {
                        $data['Affectationpv']['jack'] = $affectations[2]['jack'];
                    } else {
                        $data['Affectationpv']['jack'] = 0;
                    }
                    if (!empty($affectations[2]['wheel_wrench'])) {
                        $data['Affectationpv']['wheel_wrench'] = $affectations[2]['wheel_wrench'];
                    } else {
                        $data['Affectationpv']['wheel_wrench'] = 0;
                    }
                    if (!empty($affectations[2]['hubcaps'])) {
                        $data['Affectationpv']['hubcaps'] = $affectations[2]['hubcaps'];
                    } else {
                        $data['Affectationpv']['hubcaps'] = 0;
                    }
                    if (!empty($affectations[2]['fire_extinguisher'])) {
                        $data['Affectationpv']['fire_extinguisher'] = $affectations[2]['fire_extinguisher'];
                    } else {
                        $data['Affectationpv']['fire_extinguisher'] = 0;
                    }
                    if (!empty($affectations[2]['triangle2'])) {
                        $data['Affectationpv']['triangle2'] = $affectations[2]['triangle2'];
                    } else {
                        $data['Affectationpv']['triangle2'] = 0;
                    }
                    if (!empty($affectations[2]['vest'])) {
                        $data['Affectationpv']['vest'] = $affectations[2]['vest'];
                    } else {
                        $data['Affectationpv']['vest'] = 0;
                    }
                    if (!empty($affectations[2]['fuel_type'])) {
                        $data['Affectationpv']['fuel_type'] = $affectations[2]['fuel_type'];
                    } else {
                        $data['Affectationpv']['fuel_type'] = '';
                    }
                    if (!empty($affectations[2]['notebook_number'])) {
                        $data['Affectationpv']['notebook_number'] = $affectations[2]['notebook_number'];
                    } else {
                        $data['Affectationpv']['notebook_number'] = 0;
                    }
                    if (!empty($affectations[2]['notebook_to'])) {
                        $data['Affectationpv']['notebook_to'] = $affectations[2]['notebook_to'];
                    } else {
                        $data['Affectationpv']['notebook_to'] = 0;
                    }
                    if (!empty($affectations[2]['strain'])) {
                        $data['Affectationpv']['strain'] = $affectations[2]['strain'];
                    } else {
                        $data['Affectationpv']['strain'] = 0;
                    }
                    if (!empty($affectations[2]['card_number'])) {
                        $data['Affectationpv']['card_number'] = $affectations[2]['card_number'];
                    } else {
                        $data['Affectationpv']['card_number'] = '';
                    }
                    if (!empty($affectations[2]['card_amount'])) {
                        $data['Affectationpv']['card_amount'] = $affectations[2]['card_amount'];
                    } else {
                        $data['Affectationpv']['card_amount'] = '';
                    }
                    if (!empty($affectations[2]['convention_notebook'])) {
                        $data['Affectationpv']['convention_notebook'] = $affectations[2]['convention_notebook'];
                    } else {
                        $data['Affectationpv']['convention_notebook'] = '';
                    }
                    if (!empty($affectations[2]['convention_strain'])) {
                        $data['Affectationpv']['convention_strain'] = $affectations[2]['convention_strain'];
                    } else {
                        $data['Affectationpv']['convention_strain'] = '';
                    }
                    if (!empty($affectations[2]['convention_notebook_to'])) {
                        $data['Affectationpv']['convention_notebook_to'] = $affectations[2]['convention_notebook_to'];
                    } else {
                        $data['Affectationpv']['convention_notebook_to'] = '';
                    }
                    if (!empty($affectations[2]['other_consignes'])) {
                        $data['Affectationpv']['other_consignes'] = $affectations[2]['other_consignes'];
                    } else {
                        $data['Affectationpv']['other_consignes'] = '';
                    }
                }

                $data['Affectationpv']['user_id'] = $userId;
                $data['Affectationpv']['last_modifier_id'] = $userId;
                $this->Affectationpv->save($data);

            }


        }


    }

    /**
     * @param $car_id (car or trailer)
     * @param $isTrailer
     */
    function updateCarStatus($car_id, $isTrailer)
    {
        $this->setTimeActif();
        $current_date = date("Y-m-d H:i");

        $this->CustomerCar->recursive = 2;
        if ($isTrailer == 0) {
            $CarReservedDate = $this->CustomerCar->find('all', array(
                'conditions' => array(
                    'CustomerCar.car_id' => $car_id,
                    'CustomerCar.validated' => 1,
                    'start <=' => $current_date,
                    'end >=' => $current_date,
                    'Car.car_status_id' => 1
                )
            ));
        } else {

            $CarReservedDate = $this->CustomerCar->find('all', array(
                'recursive' => -1,
                'conditions' => array(
                    'CustomerCar.remorque_id' => $car_id,
                    'CustomerCar.validated' => 1,
                    'start <=' => $current_date,
                    'end >=' => $current_date,
                    'Car.car_status_id' => 1
                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.remorque_id = Car.id')
                    )
                )
            ));

        }

        if (!empty($CarReservedDate)) {
            $this->Car->id = $car_id;
            $this->Car->saveField('car_status_id', 6);
        }
        if ($isTrailer == 0) {
            $CarReservedDate = $this->CustomerCar->find('all', array(
                'conditions' => array(
                    'CustomerCar.car_id' => $car_id,
                    'CustomerCar.validated' => 1,
                    'start <=' => $current_date,
                    'end_real' => null,
                    'Car.car_status_id' => 1
                )
            ));


        } else {
            $CarReservedDate = $this->CustomerCar->find('all', array(
                'recursive' => -1,
                'conditions' => array(
                    'CustomerCar.remorque_id' => $car_id,
                    'CustomerCar.validated' => 1,
                    'start <=' => $current_date,
                    'end_real' => null,
                    'Car.car_status_id' => 1
                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.remorque_id = Car.id')
                    )
                )

            ));

        }

        if (!empty($CarReservedDate)) {
            $this->Car->id = $car_id;
            $this->Car->saveField('car_status_id', 6);
        }

        if ($isTrailer == 0) {

            $CarsReserved = $this->CustomerCar->find('all', array(

                'conditions' => array(
                    'CustomerCar.car_id' => $car_id,
                    'CustomerCar.validated' => 1,
                    'start ' => null,
                    'Car.car_status_id' => 1
                ),

            ));

        } else {

            $CarsReserved = $this->CustomerCar->find('all', array(
                'recursive' => -1,
                'conditions' => array(
                    'CustomerCar.remorque_id' => $car_id,
                    'CustomerCar.validated' => 1,
                    'start ' => null,
                    'Car.car_status_id' => 1
                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.remorque_id = Car.id')
                    )
                )
            ));

        }
        if (!empty($CarsReserved)) {
            $this->Car->id = $car_id;
            $this->Car->saveField('car_status_id', 6);
        }

        if ($isTrailer == 0) {
            $CarsAvailable = $this->CustomerCar->find('all', array(
                'conditions' => array(
                    'CustomerCar.car_id' => $car_id,
                    'CustomerCar.validated' => 1,
                    'end_real <' => $current_date,
                    'Car.car_status_id' => 6
                )
            ));
            $CarReserved = $this->CustomerCar->find('all', array(
                'conditions' => array(
                    'CustomerCar.car_id' => $car_id,
                    'CustomerCar.validated' => 1,
                    'end_real is NULL',
                    'Car.car_status_id' => 6
                )
            ));
            $CarReserved1 = $this->CustomerCar->find('all', array(
                'conditions' => array(
                    'CustomerCar.car_id' => $car_id,
                    'CustomerCar.validated' => 1,
                    'start <=' => $current_date,
                    'end_real IS NULL',
                    'Car.car_status_id' => 6
                )
            ));
            $CarReserved2 = $this->CustomerCar->find('all', array(
                'conditions' => array(
                    'CustomerCar.car_id' => $car_id,
                    'CustomerCar.validated' => 1,
                    'start >=' => $current_date,
                    'end_real IS NULL',
                    'Car.car_status_id' => 6
                )
            ));

        } else {

            $CarsAvailable = $this->CustomerCar->find('all', array(
                'recursive' => -1,
                'conditions' => array(
                    'CustomerCar.remorque_id' => $car_id,
                    'CustomerCar.validated' => 1,
                    'end_real <' => $current_date,
                    'Car.car_status_id' => 6
                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.remorque_id = Car.id')
                    )
                )
            ));
            $CarReserved = $this->CustomerCar->find('all', array(
                'recursive' => -1,
                'conditions' => array(
                    'CustomerCar.remorque_id' => $car_id,
                    'CustomerCar.validated' => 1,
                    'end_real is NULL',
                    'Car.car_status_id' => 6
                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.remorque_id = Car.id')
                    )
                )

            ));
            $CarReserved1 = $this->CustomerCar->find('all', array(
                'recursive' => -1,
                'conditions' => array(
                    'CustomerCar.remorque_id' => $car_id,
                    'CustomerCar.validated' => 1,
                    'start <=' => $current_date,
                    'end_real IS NULL',
                    'Car.car_status_id' => 6
                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.remorque_id = Car.id')
                    )
                )
            ));
            $CarReserved2 = $this->CustomerCar->find('all', array(

                'recursive' => -1,
                'conditions' => array(
                    'CustomerCar.remorque_id' => $car_id,
                    'CustomerCar.validated' => 1,
                    'start >=' => $current_date,
                    'end_real IS NULL',
                    'Car.car_status_id' => 6
                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.remorque_id = Car.id')
                    )
                )
            ));


        }

        if ((!empty($CarsAvailable) && empty($CarReserved1) && empty($CarReserved)) || !empty($CarReserved2)) {
            $this->Car->id = $car_id;
            $this->Car->saveField('car_status_id', 1);
        }


    }

    public function add_request()
    {
        $profil_client = $this->isCustomer();
        $profil_id = $profil_client[0];
        $this->CustomerCar->validate = $this->CustomerCar->validate_add_request_client;
        $this->setTimeActif();

        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::demande_affectation, $user_id, ActionsEnum::add, "CustomerCars", null,
            "CustomerCar", null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index_request'));
        }
        if ($this->request->is('post')) {
            $this->CustomerCar->create();

            if ($profil_id == 3) {
                $customer_id = $profil_client[1];
                $selectedCustomer = $this->CustomerCar->Customer->find('first', array(
                    'recursive' => -1,
                    'fields' => 'Customer.id',
                    'conditions' => array('Customer.id' => $customer_id)
                ));
                if (!empty($selectedCustomer)) {
                    $selectedCustomer_id = $selectedCustomer['Customer']['id'];
                    $this->request->data['CustomerCar']['customer_id'] = $selectedCustomer_id;
                }
            }
            $this->createDatetimeFromDate('CustomerCar', 'start');
            $this->createDatetimeFromDate('CustomerCar', 'end');
            $this->createDatetimeFromDate('CustomerCar', 'date_payment');
            $this->request->data['CustomerCar']['user_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['CustomerCar']['request'] = 1;
            $this->request->data['CustomerCar']['validated'] = 0;

            if ($this->CustomerCar->save($this->request->data)) {

                $this->Flash->success(__('The request affectation has been saved.'));

                $this->redirect(array('action' => 'index_request'));

            } else {
                $this->Flash->error(__('The request affectation could not be saved. Please, try again.'));
            }
        }
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.immatr_def, ' - ', Carmodel.name)"
            );

        }


        /* $profil_client = $this->isCustomer();
         $profil_id = $profil_client[0];

         $this->set('profil_id', $profil_id);*/


        $cond = $this->getConditionsRequest();

        $conditions_car = $cond[1];
        $conditions_customer = $cond[2];

        $cars = $this->CustomerCar->Car->find('list', array(
            'fields' => 'cnames',
            'recursive' => 1,
            'order' => array('Car.code asc', 'Carmodel.name asc'),
            'conditions' => $conditions_car
        ));


        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions_customer);

        $options = $this->CarOption->getCarOptions();
        $zones = $this->Zone->getZones();
        $customerGroups = $this->CustomerGroup->getCustomerGroups();
        $carTypes = $this->CarType->getCarTypes();
        $this->set(compact('cars', 'customers', 'options', 'zones', 'customerGroups', 'carTypes'));
    }

    /**
     * add temporary method
     *
     * @return void
     */
    public function add_temporary()
    {

        $this->CustomerCar->validate = $this->CustomerCar->validate;
        $this->setTimeActif();

        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::affectation_provisoire, $user_id, ActionsEnum::add, "CustomerCars",
            null, "CustomerCar", null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index_temporary'));
        }
        if ($this->request->is('post')) {


            $this->CustomerCar->create();
            $this->createDatetimeFromDatetime('CustomerCar', 'start');
            $this->createDatetimeFromDatetime('CustomerCar', 'end');
            $this->request->data['CustomerCar']['user_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['CustomerCar']['request'] = 0;
            $this->request->data['CustomerCar']['validated'] = 0;
            $this->request->data['CustomerCar']['temporary'] = 1;
            if ($this->CustomerCar->save($this->request->data)) {

                $this->Flash->success(__('The temporery affectation has been saved.'));
                $this->redirect(array('controller' => 'CustomerCars', 'action' => 'index_temporary'));
            } else {
                $this->Flash->error(__('The temporery affectation could not be saved. Please, try again.'));
            }
        }
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.immatr_def, ' - ', Carmodel.name)"
            );
        }
        $cond = $this->getConditionsTemporary();

        if (!empty($cond[1])) {
            $conditions_car = array_merge($cond[1], array('Car.in_mission' => 0));
        } else {
            $conditions_car = array('Car.in_mission' => 0);
        }
        $conditions_customer = $cond[2];
        $cars = $this->CustomerCar->Car->find('list', array(
            'conditions' => $conditions_car,
            'fields' => 'cnames',
            'recursive' => 1,
            'order' => array('Car.code asc', 'Carmodel.name asc')
        ));


        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions_customer);

        $options = $this->CarOption->getCarOptions();
        $zones = $this->Zone->getZones();
        $customerGroups = $this->CustomerGroup->getCustomerGroups();
        $reference = $this->getNextReference('CustomerCar', 'affectation');
        $this->set(compact('cars', 'customers', 'options', 'zones', 'customerGroups', 'reference'));

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
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::affectation, $user_id, ActionsEnum::edit, "CustomerCars", $id,
            "CustomerCar", null);
        if (!$this->CustomerCar->exists($id)) {
            throw new NotFoundException(__('Invalid affectation'));
        }
        $current_date = date("d/m/Y H:i");
        $customercar = $this->CustomerCar->find('first',
            array('conditions' => array('CustomerCar.' . $this->CustomerCar->primaryKey => $id)));
        $car_id = $customercar['CustomerCar']['car_id'];
        $date_start = $customercar['CustomerCar']['start'];
        $date_end = $customercar['CustomerCar']['end'];
        $version_of_app = $this->getVersionOfApp();
        if ($this->request->is(array('post', 'put'))) { 
            if (isset($this->request->data['cancel'])) {

                $this->closeItemOpened('CustomerCar', $id);
                $this->Flash->error(__('Changes were not saved. Reservation cancelled.'));
                $this->redirect(array('action' => 'index'));
            }

            $start = $this->request->data['CustomerCar']['start'];
            $end = $this->request->data['CustomerCar']['end'];

            if (isset($start) && !empty($start)) {
                $start = DateTime::createFromFormat('d/m/Y H:i', $start);

                if ($start instanceof DateTime) {
                    $start = $start->format('Y-m-d H:i:s');

                } else {
                    $start = null;
                }
            } else {
                $start = null;
            }

            if (isset($end) && !empty($end)) {
                $end = DateTime::createFromFormat('d/m/Y H:i', $end);

                if ($end instanceof DateTime) {
                    $end = $end->format('Y-m-d H:i:s');

                } else {
                    $end = null;
                }
            } else {
                $end = null;
            }

            $this->createDatetimeFromDatetime('CustomerCar', 'start');
            $this->createDatetimeFromDatetime('CustomerCar', 'end');
            $this->createDatetimeFromDatetime('CustomerCar', 'end_real');
            $this->createDatetimeFromDatetime('CustomerCar', 'date_payment');
            $this->createDatetimeFromDate('CustomerCar', 'driver_license_date');
            if ($this->request->data['CustomerCar']['file1'] == '') {
                $this->deleteAttachment('CustomerCar', 'pictureinit1', 'attachments/picturesaffectation/initialetat/',
                    $id);
                $this->verifyAttachment('CustomerCar', 'pictureinit1', 'attachments/picturesaffectation/initialetat/',
                    'add', 1, 1, $id);
            } else {
                $this->verifyAttachment('CustomerCar', 'pictureinit1', 'attachments/picturesaffectation/initialetat/',
                    'edit', 1, 1, $id);
            }
            if ($this->request->data['CustomerCar']['file2'] == '') {
                $this->deleteAttachment('CustomerCar', 'pictureinit2', 'attachments/picturesaffectation/initialetat/',
                    $id);
                $this->verifyAttachment('CustomerCar', 'pictureinit2', 'attachments/picturesaffectation/initialetat/',
                    'add', 1, 1, $id);
            } else {
                $this->verifyAttachment('CustomerCar', 'pictureinit2', 'attachments/picturesaffectation/initialetat/',
                    'edit', 1, 1, $id);
            }
            if ($this->request->data['CustomerCar']['file3'] == '') {
                $this->deleteAttachment('CustomerCar', 'pictureinit3', 'attachments/picturesaffectation/initialetat/',
                    $id);
                $this->verifyAttachment('CustomerCar', 'pictureinit3', 'attachments/picturesaffectation/initialetat/',
                    'add', 1, 1, $id);
            } else {
                $this->verifyAttachment('CustomerCar', 'pictureinit3', 'attachments/picturesaffectation/initialetat/',
                    'edit', 1, 1, $id);
            }
            if ($this->request->data['CustomerCar']['file4'] == '') {
                $this->deleteAttachment('CustomerCar', 'pictureinit4', 'attachments/picturesaffectation/initialetat/',
                    $id);
                $this->verifyAttachment('CustomerCar', 'pictureinit4', 'attachments/picturesaffectation/initialetat/',
                    'add', 1, 1, $id);
            } else {
                $this->verifyAttachment('CustomerCar', 'pictureinit4', 'attachments/picturesaffectation/initialetat/',
                    'edit', 1, 1, $id);
            }

            if ($this->request->data['CustomerCar']['filefinal1'] == '') {
                $this->deleteAttachment('CustomerCar', 'picturefinal1', 'attachments/picturesaffectation/finaletat/',
                    $id);
                $this->verifyAttachment('CustomerCar', 'picturefinal1', 'attachments/picturesaffectation/finaletat/',
                    'add', 1, 1, $id);
            } else {
                $this->verifyAttachment('CustomerCar', 'picturefinal1', 'attachments/picturesaffectation/finaletat/',
                    'edit', 1, 1, $id);
            }

            if ($this->request->data['CustomerCar']['filefinal2'] == '') {
                $this->deleteAttachment('CustomerCar', 'picturefinal2', 'attachments/picturesaffectation/finaletat/',
                    $id);
                $this->verifyAttachment('CustomerCar', 'picturefinal2', 'attachments/picturesaffectation/finaletat/',
                    'add', 1, 1, $id);
            } else {
                $this->verifyAttachment('CustomerCar', 'picturefinal2', 'attachments/picturesaffectation/finaletat/',
                    'edit', 1, 1, $id);
            }
            if ($this->request->data['CustomerCar']['filefinal3'] == '') {
                $this->deleteAttachment('CustomerCar', 'picturefinal3', 'attachments/picturesaffectation/finaletat/',
                    $id);
                $this->verifyAttachment('CustomerCar', 'picturefinal3', 'attachments/picturesaffectation/finaletat/',
                    'add', 1, 1, $id);
            } else {
                $this->verifyAttachment('CustomerCar', 'picturefinal3', 'attachments/picturesaffectation/finaletat/',
                    'edit', 1, 1, $id);

            }
            if ($this->request->data['CustomerCar']['filefinal4'] == '') {
                $this->deleteAttachment('CustomerCar', 'picturefinal4', 'attachments/picturesaffectation/finaletat/',
                    $id);
                $this->verifyAttachment('CustomerCar', 'picturefinal4', 'attachments/picturesaffectation/finaletat/',
                    'add', 1, 1, $id);
            } else {
                $this->verifyAttachment('CustomerCar', 'picturefinal4', 'attachments/picturesaffectation/finaletat/',
                    'edit', 1, 1, $id);
            }


            if ($version_of_app == 'web') {
                if ($this->request->data['CustomerCar']['pictureinit1_dir'] != '') {
                    $this->request->data['CustomerCar']['pictureinit1'] = $this->request->data['CustomerCar']['pictureinit1_dir'];
                }
                if ($this->request->data['CustomerCar']['pictureinit2_dir'] != '') {
                    $this->request->data['CustomerCar']['pictureinit2'] = $this->request->data['CustomerCar']['pictureinit2_dir'];
                }
                if ($this->request->data['CustomerCar']['pictureinit3_dir'] = '') {
                    $this->request->data['CustomerCar']['pictureinit3'] = $this->request->data['CustomerCar']['pictureinit3_dir'];
                }
                if ($this->request->data['CustomerCar']['pictureinit4_dir'] = '') {
                    $this->request->data['CustomerCar']['pictureinit4'] = $this->request->data['CustomerCar']['pictureinit4_dir'];
                }
                if ($this->request->data['CustomerCar']['picturefinal1_dir'] = '') {
                    $this->request->data['CustomerCar']['picturefinal1'] = $this->request->data['CustomerCar']['picturefinal1_dir'];
                }
                if ($this->request->data['CustomerCar']['picturefinal2_dir'] = '') {
                    $this->request->data['CustomerCar']['picturefinal2'] = $this->request->data['CustomerCar']['picturefinal2_dir'];
                }
                if ($this->request->data['CustomerCar']['picturefinal3_dir'] = '') {
                    $this->request->data['CustomerCar']['picturefinal3'] = $this->request->data['CustomerCar']['picturefinal3_dir'];
                }
                if ($this->request->data['CustomerCar']['picturefinal4_dir'] = '') {
                    $this->request->data['CustomerCar']['picturefinal4'] = $this->request->data['CustomerCar']['picturefinal4_dir'];
                }
            }

            $this->request->data['CustomerCar']['modified_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['CustomerCar']['request'] = 0;
            $this->request->data['CustomerCar']['validated'] = 1;
            $this->closeItemOpened('CustomerCar', $id);

            if ($car_id == $this->request->data['CustomerCar']['car_id'] && $date_start == $start && $date_end != $end) {
                $available = true;
            } else {
                if ($car_id != $this->request->data['CustomerCar']['car_id'] || $date_start != $start || $date_end != $end) {
                    $available = $this->verify_availability($this->request->data['CustomerCar']['car_id'],
                        $this->request->data['CustomerCar']['start'], $id);


                } else {
                    $available = true;
                }
            }


            if ($available && $this->CustomerCar->save($this->request->data)) {
                $date_from = $this->request->data['Autorisation']['authorization_from'];
                $this->createDatetimeFromDatetime('Autorisation', 'authorization_from');
                $authorization_from = $this->request->data['Autorisation']['authorization_from'];
                $date_to = $this->request->data['Autorisation']['authorization_to'];
                $this->createDatetimeFromDatetime('Autorisation', 'authorization_to');
                $authorization_to = $this->request->data['Autorisation']['authorization_to'];


                $this->request->data['Autorisation']['current_date'] = $current_date;
                $this->createDatetimeFromDatetime('Autorisation', 'current_date');

                $current_date = $this->request->data['Autorisation']['current_date'];

                if ($this->request->data['CustomerCar']['authorized'] == '1' && $authorization_from < $current_date && $current_date < $authorization_to) {
                    $autorisation_id = null;
                    if (isset($this->request->data['Autorisation']['id'])) {
                        $autorisation_id = $this->request->data['Autorisation']['id'];
                        $this->saveAutorisation($id, $authorization_from, $authorization_to, $autorisation_id);

                    } else {
                        $this->saveAutorisation($id, $authorization_from, $authorization_to);
                    }
                    $this->CarAuthorized($this->request->data['CustomerCar']['car_id'],
                        $this->request->data['CustomerCar']['customer_id'], $date_from, $date_to);


                } else {
                    if (isset($this->request->data['Autorisation']['id'])) {
                        $autorisation_id = $this->request->data['Autorisation']['id'];
                        $this->Autorisation->id = $autorisation_id;
                        $this->Autorisation->delete();
                    }
                }
                $this->add_affectation_pv($this->request->data['Affectationpv'], $id);
                $this->saveUserAction(SectionsEnum::affectation, $id, $this->Session->read('Auth.User.id') , ActionsEnum::edit);
                $this->updateCarStatus($this->request->data['CustomerCar']['car_id'], 0);
                $this->updateCarStatus($this->request->data['CustomerCar']['remorque_id'], 1);
                $this->Flash->success(__('The affectation has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                if ($available) {
                    $this->Flash->error(__('The affectation could not be saved. Please, try again.'));
                } else {
                    $this->Flash->error(__('The affectation could not be saved because the car is already reserved in this date.'));
                }

            }
        } else {
            $options = array('conditions' => array('CustomerCar.' . $this->CustomerCar->primaryKey => $id));
            $this->request->data = $this->CustomerCar->find('first', $options);
            $affectationpv0s = $this->Affectationpv->find('first', array(
                'recursive' => -1,
                'conditions' => array('Affectationpv.customer_car_id' => $id, 'Affectationpv.reception' => 0)
            ));
            if (!empty($affectationpv0s)) {
                if(Configure::read('logistia') != '1'){
                    $this->request->data['Affectationpv'][0]['grey_card'] = $affectationpv0s['Affectationpv']['grey_card'];
                    $this->request->data['Affectationpv'][0]['assurance'] = $affectationpv0s['Affectationpv']['assurance'];
                    $this->request->data['Affectationpv'][0]['controle_technique'] = $affectationpv0s['Affectationpv']['controle_technique'];
                    $this->request->data['Affectationpv'][0]['carnet_entretien'] = $affectationpv0s['Affectationpv']['carnet_entretien'];
                    $this->request->data['Affectationpv'][0]['carnet_bord'] = $affectationpv0s['Affectationpv']['carnet_bord'];
                    $this->request->data['Affectationpv'][0]['vignette'] = $affectationpv0s['Affectationpv']['vignette'];
                    $this->request->data['Affectationpv'][0]['vignette_ct'] = $affectationpv0s['Affectationpv']['vignette_ct'];
                    $this->request->data['Affectationpv'][0]['procuration'] = $affectationpv0s['Affectationpv']['procuration'];
                    $this->request->data['Affectationpv'][0]['roue_secours'] = $affectationpv0s['Affectationpv']['roue_secours'];
                    $this->request->data['Affectationpv'][0]['cric'] = $affectationpv0s['Affectationpv']['cric'];
                    $this->request->data['Affectationpv'][0]['tapis'] = $affectationpv0s['Affectationpv']['tapis'];
                    $this->request->data['Affectationpv'][0]['manivelle'] = $affectationpv0s['Affectationpv']['manivelle'];
                    $this->request->data['Affectationpv'][0]['boite_pharmacie'] = $affectationpv0s['Affectationpv']['boite_pharmacie'];
                    $this->request->data['Affectationpv'][0]['triangle'] = $affectationpv0s['Affectationpv']['triangle'];
                    $this->request->data['Affectationpv'][0]['gilet'] = $affectationpv0s['Affectationpv']['gilet'];
                    $this->request->data['Affectationpv'][0]['double_cle'] = $affectationpv0s['Affectationpv']['double_cle'];
                    $this->request->data['Affectationpv'][0]['sieges'] = $affectationpv0s['Affectationpv']['sieges'];
                    $this->request->data['Affectationpv'][0]['dashboard'] = $affectationpv0s['Affectationpv']['dashboard'];
                    $this->request->data['Affectationpv'][0]['moquette'] = $affectationpv0s['Affectationpv']['moquette'];
                    $this->request->data['Affectationpv'][0]['tapis_interieur'] = $affectationpv0s['Affectationpv']['tapis_interieur'];
                }else{
                    $this->request->data['Affectationpv'][0]['grey_card'] = $affectationpv0s['Affectationpv']['grey_card'];
                    $this->request->data['Affectationpv'][0]['oil_level'] = $affectationpv0s['Affectationpv']['oil_level'];
                    $this->request->data['Affectationpv'][0]['engin_noise'] = $affectationpv0s['Affectationpv']['engin_noise'];
                    $this->request->data['Affectationpv'][0]['breaks'] = $affectationpv0s['Affectationpv']['breaks'];
                    $this->request->data['Affectationpv'][0]['pedals'] = $affectationpv0s['Affectationpv']['pedals'];
                    $this->request->data['Affectationpv'][0]['wing_mirrors'] = $affectationpv0s['Affectationpv']['wing_mirrors'];
                    $this->request->data['Affectationpv'][0]['odometer'] = $affectationpv0s['Affectationpv']['odometer'];
                    $this->request->data['Affectationpv'][0]['doors_state'] = $affectationpv0s['Affectationpv']['doors_state'];
                    $this->request->data['Affectationpv'][0]['doors_operation'] = $affectationpv0s['Affectationpv']['doors_operation'];
                    $this->request->data['Affectationpv'][0]['seats'] = $affectationpv0s['Affectationpv']['seats'];
                    $this->request->data['Affectationpv'][0]['front_lights'] = $affectationpv0s['Affectationpv']['front_lights'];
                    $this->request->data['Affectationpv'][0]['wipper'] = $affectationpv0s['Affectationpv']['wipper'];
                    $this->request->data['Affectationpv'][0]['front_tires'] = $affectationpv0s['Affectationpv']['front_tires'];
                    $this->request->data['Affectationpv'][0]['spare_wheel'] = $affectationpv0s['Affectationpv']['spare_wheel'];
                    $this->request->data['Affectationpv'][0]['accessories'] = $affectationpv0s['Affectationpv']['accessories'];
                }

            }

            $affectationpv1s = $this->Affectationpv->find('first', array(
                'recursive' => -1,
                'conditions' => array('Affectationpv.customer_car_id' => $id, 'Affectationpv.reception' => 1)
            ));

            if (!empty($affectationpv1s)) {
                if (Configure::read('logistia') != '1'){
                    $this->request->data['Affectationpv'][1]['grey_card'] = $affectationpv1s['Affectationpv']['grey_card'];
                    $this->request->data['Affectationpv'][1]['assurance'] = $affectationpv1s['Affectationpv']['assurance'];
                    $this->request->data['Affectationpv'][1]['controle_technique'] = $affectationpv1s['Affectationpv']['controle_technique'];
                    $this->request->data['Affectationpv'][1]['carnet_entretien'] = $affectationpv1s['Affectationpv']['carnet_entretien'];
                    $this->request->data['Affectationpv'][1]['carnet_bord'] = $affectationpv1s['Affectationpv']['carnet_bord'];
                    $this->request->data['Affectationpv'][1]['vignette'] = $affectationpv1s['Affectationpv']['vignette'];
                    $this->request->data['Affectationpv'][1]['vignette_ct'] = $affectationpv1s['Affectationpv']['vignette_ct'];
                    $this->request->data['Affectationpv'][1]['procuration'] = $affectationpv1s['Affectationpv']['procuration'];
                    $this->request->data['Affectationpv'][1]['roue_secours'] = $affectationpv1s['Affectationpv']['roue_secours'];
                    $this->request->data['Affectationpv'][1]['cric'] = $affectationpv1s['Affectationpv']['cric'];
                    $this->request->data['Affectationpv'][1]['tapis'] = $affectationpv1s['Affectationpv']['tapis'];
                    $this->request->data['Affectationpv'][1]['manivelle'] = $affectationpv1s['Affectationpv']['manivelle'];
                    $this->request->data['Affectationpv'][1]['boite_pharmacie'] = $affectationpv1s['Affectationpv']['boite_pharmacie'];
                    $this->request->data['Affectationpv'][1]['triangle'] = $affectationpv1s['Affectationpv']['triangle'];
                    $this->request->data['Affectationpv'][1]['gilet'] = $affectationpv1s['Affectationpv']['gilet'];
                    $this->request->data['Affectationpv'][1]['double_cle'] = $affectationpv1s['Affectationpv']['double_cle'];
                    $this->request->data['Affectationpv'][1]['sieges'] = $affectationpv1s['Affectationpv']['sieges'];
                    $this->request->data['Affectationpv'][1]['dashboard'] = $affectationpv1s['Affectationpv']['dashboard'];
                    $this->request->data['Affectationpv'][1]['moquette'] = $affectationpv1s['Affectationpv']['moquette'];
                    $this->request->data['Affectationpv'][1]['tapis_interieur'] = $affectationpv1s['Affectationpv']['tapis_interieur'];
                }else{
                    $this->request->data['Affectationpv'][1]['grey_card'] = $affectationpv1s['Affectationpv']['grey_card'];
                    $this->request->data['Affectationpv'][1]['oil_level'] = $affectationpv1s['Affectationpv']['oil_level'];
                    $this->request->data['Affectationpv'][1]['engin_noise'] = $affectationpv1s['Affectationpv']['engin_noise'];
                    $this->request->data['Affectationpv'][1]['breaks'] = $affectationpv1s['Affectationpv']['breaks'];
                    $this->request->data['Affectationpv'][1]['pedals'] = $affectationpv1s['Affectationpv']['pedals'];
                    $this->request->data['Affectationpv'][1]['wing_mirrors'] = $affectationpv1s['Affectationpv']['wing_mirrors'];
                    $this->request->data['Affectationpv'][1]['odometer'] = $affectationpv1s['Affectationpv']['odometer'];
                    $this->request->data['Affectationpv'][1]['doors_state'] = $affectationpv1s['Affectationpv']['doors_state'];
                    $this->request->data['Affectationpv'][1]['doors_operation'] = $affectationpv1s['Affectationpv']['doors_operation'];
                    $this->request->data['Affectationpv'][1]['seats'] = $affectationpv1s['Affectationpv']['seats'];
                    $this->request->data['Affectationpv'][1]['front_lights'] = $affectationpv1s['Affectationpv']['front_lights'];
                    $this->request->data['Affectationpv'][1]['wipper'] = $affectationpv1s['Affectationpv']['wipper'];
                    $this->request->data['Affectationpv'][1]['front_tires'] = $affectationpv1s['Affectationpv']['front_tires'];
                    $this->request->data['Affectationpv'][1]['spare_wheel'] = $affectationpv1s['Affectationpv']['spare_wheel'];
                    $this->request->data['Affectationpv'][1]['accessories'] = $affectationpv1s['Affectationpv']['accessories'];
                }

                $affectationpv2s = $this->Affectationpv->find('first', array(
                    'recursive' => -1,
                    'conditions' => array('Affectationpv.customer_car_id' => $id, 'Affectationpv.passation' => 1)
                ));
                if (!empty($affectationpv2s)){
                    if (Configure::read('logistia') == '1') {
                        $this->request->data['Affectationpv'][2]['transfering_customer_id'] = $affectationpv2s['Affectationpv']['transfering_customer_id'];
                        $this->request->data['Affectationpv'][2]['receiving_customer_id'] = $affectationpv2s['Affectationpv']['receiving_customer_id'];
                        $this->request->data['Affectationpv'][2]['mechanic_state'] = $affectationpv2s['Affectationpv']['mechanic_state'];
                        $this->request->data['Affectationpv'][2]['obs_mechanic_state'] = $affectationpv2s['Affectationpv']['obs_mechanic_state'];
                        $this->request->data['Affectationpv'][2]['electric_state'] = $affectationpv2s['Affectationpv']['electric_state'];
                        $this->request->data['Affectationpv'][2]['obs_electric_state'] = $affectationpv2s['Affectationpv']['obs_electric_state'];
                        $this->request->data['Affectationpv'][2]['grey_card_2'] = $affectationpv2s['Affectationpv']['grey_card_2'];
                        $this->request->data['Affectationpv'][2]['inssurance'] = $affectationpv2s['Affectationpv']['inssurance'];
                        $this->request->data['Affectationpv'][2]['interview_notebook'] = $affectationpv2s['Affectationpv']['interview_notebook'];
                        $this->request->data['Affectationpv'][2]['dashboard_notebook'] = $affectationpv2s['Affectationpv']['dashboard_notebook'];
                        $this->request->data['Affectationpv'][2]['thumbnail'] = $affectationpv2s['Affectationpv']['thumbnail'];
                        $this->request->data['Affectationpv'][2]['post_auto'] = $affectationpv2s['Affectationpv']['post_auto'];
                        $this->request->data['Affectationpv'][2]['slaps'] = $affectationpv2s['Affectationpv']['slaps'];
                        $this->request->data['Affectationpv'][2]['jack'] = $affectationpv2s['Affectationpv']['jack'];
                        $this->request->data['Affectationpv'][2]['wheel_wrench'] = $affectationpv2s['Affectationpv']['wheel_wrench'];
                        $this->request->data['Affectationpv'][2]['hubcaps'] = $affectationpv2s['Affectationpv']['hubcaps'];
                        $this->request->data['Affectationpv'][2]['fire_extinguisher'] = $affectationpv2s['Affectationpv']['fire_extinguisher'];
                        $this->request->data['Affectationpv'][2]['triangle2'] = $affectationpv2s['Affectationpv']['triangle2'];
                        $this->request->data['Affectationpv'][2]['vest'] = $affectationpv2s['Affectationpv']['vest'];
                        $this->request->data['Affectationpv'][2]['notebook_number'] = $affectationpv2s['Affectationpv']['notebook_number'];
                        $this->request->data['Affectationpv'][2]['strain'] = $affectationpv2s['Affectationpv']['strain'];
                        $this->request->data['Affectationpv'][2]['notebook_to'] = $affectationpv2s['Affectationpv']['notebook_to'];
                        $this->request->data['Affectationpv'][2]['other_consignes'] = $affectationpv2s['Affectationpv']['other_consignes'];
                        $this->request->data['Affectationpv'][2]['fuel_type'] = $affectationpv2s['Affectationpv']['fuel_type'];
                        $this->request->data['Affectationpv'][2]['card_number'] = $affectationpv2s['Affectationpv']['card_number'];
                        $this->request->data['Affectationpv'][2]['card_amount'] = $affectationpv2s['Affectationpv']['card_amount'];
                        $this->request->data['Affectationpv'][2]['convention_notebook'] = $affectationpv2s['Affectationpv']['convention_notebook'];
                        $this->request->data['Affectationpv'][2]['convention_strain'] = $affectationpv2s['Affectationpv']['convention_strain'];
                        $this->request->data['Affectationpv'][2]['convention_notebook_to'] = $affectationpv2s['Affectationpv']['convention_notebook_to'];
                    }
                }

                $this->request->data['Affectationpv']['obs_customer'] = $affectationpv1s['Affectationpv']['obs_customer'];
                $this->request->data['Affectationpv']['obs_chef'] = $affectationpv1s['Affectationpv']['obs_chef'];
                if (isset($this->request->data['Affectationpv']['obs_hse'])){
                    $this->request->data['Affectationpv']['obs_hse'] = $affectationpv1s['Affectationpv']['obs_hse'];
                }
            }
            $this->set(compact('affectationpv0s', 'affectationpv1s'));


            $autorisation = $this->Autorisation->find('first', array(
                'conditions' => array(
                    'authorization_from <' => $current_date,
                    'authorization_to >' => $current_date,
                    'customer_car_id' => $id
                )
            ));
            $this->set('autorisation', $autorisation);
            if ($this->request->data['CustomerCar']['locked'] == 1) {
                $this->Flash->error(__('You must first unlock the affectation.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->isOpenedByOtherUser("CustomerCar", 'CustomerCars', 'affectation', $id);
        }
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', IFNULL(Carmodel.name,'Sans model'))"
            );
        } elseif ($param == 2) {

            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );

        }

        $cond = $this->getConditions();
        $conditions_car = $cond[1];

        $conditions_customer = $cond[2];


        if ($this->request->data['CustomerCar']['request'] == 1) {
            $condition1 = array('Car.id' => $this->request->data['CustomerCar']['car_id']);
            $userId = intval($this->Auth->user('id'));
            $parcIds = $this->getParcsUserIdsArray($userId);
            if (!empty($parcIds)){
                $condition1 = array(
                        'Car.id' => $this->request->data['CustomerCar']['car_id'],
                    'Car.parc_id' => $parcIds
                    );
            }


            if ($conditions_car != null) {
                $conditions_car = array_merge($conditions_car, $condition1);
            }
            $conditions_car = array(
                'OR' => array(
                    'Car.car_status_id' =>  1,
                    'Car.id' => $this->request->data['CustomerCar']['car_id']
                ),
                'Car.parc_id' => $parcIds
            );
            if($this->IsAdministrator){
                $conditions_car = array(
                    'Car.car_status_id' =>  1,
                );
            }else{
                $conditions_car = array(
                    'Car.car_status_id' =>  1,
                    'Car.parc_id' => $parcIds
                );
            }
            $cars = $this->CustomerCar->Car->find('list', array(
                'fields' => 'cnames',
                'recursive' => 1,
                'order' => 'Carmodel.name asc',
                'conditions' => $conditions_car
            ));
        } else {

            $condition1 = array(
                'OR' => array(
                    'Car.car_category_id !=' => 3,
                    'Car.car_category_id' => null,
                    'Car.id' => $this->request->data['CustomerCar']['car_id']
                )
            );
            $userId = intval($this->Auth->user('id'));
            $parcIds = $this->getParcsUserIdsArray($userId);
            if (!empty($parcIds)){
                $condition1 = array(
                    'OR' => array(
                        'Car.car_category_id !=' => 3,
                        'Car.car_category_id' => null,
                        'Car.id' => $this->request->data['CustomerCar']['car_id']
                    ),
                    'Car.parc_id' => $parcIds
                );
            }


            if ($conditions_car != null) {
                $conditions_car = array_merge($conditions_car, $condition1);

            } else {
                $conditions_car = $condition1;
            }

            if($this->IsAdministrator){
                $conditions_car = array(
                    'Car.car_status_id' =>  1,
                );
            }else{
                $conditions_car = array(
                    'Car.car_status_id' =>  1,
                    'Car.parc_id' => $parcIds
                );
            }
            $cars = $this->CustomerCar->Car->find('list', array(
                'fields' => 'cnames',
                'recursive' => 1,
                'order' => array('Car.code asc', 'Carmodel.name asc'),
                'conditions' => $conditions_car
            ));

        }

        $conditions_car = $cond[1];
        $conditions_remorque = array(
            'OR' => array(
                'Car.car_status_id' => 1,
                'Car.id' => $this->request->data['CustomerCar']['remorque_id']
            ),
            'Car.car_category_id ' => 3
        );
        if ($conditions_car != null) {
            $conditions_car = array_merge($conditions_car, $conditions_remorque);

        } else {
            $conditions_car = $conditions_remorque;
        }


        $remorques = $this->CustomerCar->Car->find('list', array(
            'fields' => 'cnames',
            'recursive' => -1,
            'order' => array('Car.code asc', 'Carmodel.name asc'),
            'conditions' => $conditions_car,
            'joins' => array(
                array(
                    'table' => 'customer_car',
                    'type' => 'left',
                    'alias' => 'CustomerCar',
                    'conditions' => array('CustomerCar.remorque_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                )
            )
        ));


        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions_customer);


        $options = $this->CarOption->getCarOptions();
        $zones = $this->Zone->getZones();
        $customerGroups = $this->CustomerGroup->getCustomerGroups();

        $affectation_mode = $this->getAffectationMode();
        $this->set('affectation_mode', $affectation_mode);
        $reference = $this->getNextReference('CustomerCar', 'affectation');

        $this->set(compact('cars', 'customers', 'options', 'customerGroups', 'zones', 'version_of_app', 'remorques',
            'reference'));
    }

    public function edit_request($id = null)
    {

        $this->CustomerCar->validate = $this->CustomerCar->validate_add_request_client;

        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::demande_affectation, $user_id, ActionsEnum::edit, "CustomerCars", $id,
            "CustomerCar", null);
        if (!$this->CustomerCar->exists($id)) {
            throw new NotFoundException(__('Invalid affectation'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Request reservation cancelled.'));
                $this->redirect(array('action' => 'index_request'));
            }

            $this->createDatetimeFromDate('CustomerCar', 'start');
            $this->createDatetimeFromDate('CustomerCar', 'end');
            $this->createDatetimeFromDate('CustomerCar', 'date_payment');


            $this->request->data['CustomerCar']['is_open'] = 0;
            $this->request->data['CustomerCar']['modified_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['CustomerCar']['request'] = 1;
            $this->request->data['CustomerCar']['validated'] = 0;
            $this->request->data['CustomerCar']['is_open'] = 0;
            if ($this->CustomerCar->save($this->request->data)) {
                $this->saveUserAction(4, $id, $this->Session->read('Auth.User.id') , ActionsEnum::edit);
                $this->Flash->success(__('The request affectation has been saved.'));


                $this->redirect(array('action' => 'index_request'));
            } else {
                $this->Flash->error(__('The request affectation could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CustomerCar.' . $this->CustomerCar->primaryKey => $id));
            $this->request->data = $this->CustomerCar->find('first', $options);
            if ($this->request->data['CustomerCar']['locked'] == 1) {
                $this->Flash->error(__('You must first unlock the request reservation.'));
                $this->redirect(array('action' => 'index_request'));
            }
            $this->isOpenedByOtherUser("CustomerCar", 'CustomerCars', 'reservation', $id);


        }
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.immatr_def, ' - ', Carmodel.name)"
            );

        }

        $this->CustomerCar->Customer->virtualFields = array(
            'cnames' => "CONCAT(Customer.first_name, ' - ', Customer.last_name)"
        );


        $isCustomer = $this->isCustomer();

        $this->set('isCustomer', $isCustomer);

        $carTypes = $this->CarType->getCarTypes();
        $this->set('carTypes', $carTypes);

        $cars = $this->CustomerCar->Car->find('list', array(
            'fields' => 'cnames',
            'recursive' => 1,
            'order' => array('Car.code asc', 'Carmodel.name asc'),
        ));

        $fields = "cnames";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);

        $customer_id = $this->getCustomerIdByUser();
        $selectedCustomer = $this->CustomerCar->Customer->find('first',
            array('recursive' => -1, 'fields' => 'Customer.id', 'conditions' => array('Customer.id' => $customer_id)));
        if (!empty($selectedCustomer)) {
            $selectedCustomer_id = $selectedCustomer['Customer']['id'];
            $isCustomer = $this->isCustomer();
            $this->set('isCustomer', $isCustomer);
            $this->set('selectedCustomer_id', $selectedCustomer_id);
        }


        $options = $this->CarOption->getCarOptions();
        $zones = $this->Zone->getZones();
        $customerGroups = $this->CustomerGroup->getCustomerGroups();

        $this->set(compact('cars', 'customers', 'options', 'customerGroups', 'zones'));
    }

    public function edit_temporary($id = null)
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::affectation_provisoire, $user_id, ActionsEnum::edit, "CustomerCars",
            $id, "CustomerCar", null);
        if (!$this->CustomerCar->exists($id)) {
            throw new NotFoundException(__('Invalid affectation'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Temporary affectation cancelled.'));
                $this->redirect(array('action' => 'index_temporary'));
            }

            $this->createDatetimeFromDatetime('CustomerCar', 'start');
            $this->createDatetimeFromDatetime('CustomerCar', 'end');

            $this->request->data['CustomerCar']['is_open'] = 0;
            $this->request->data['CustomerCar']['modified_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['CustomerCar']['request'] = 0;
            $this->request->data['CustomerCar']['validated'] = 0;
            $this->request->data['CustomerCar']['temporary'] = 1;
            $this->request->data['CustomerCar']['is_open'] = 0;
            if ($this->CustomerCar->save($this->request->data)) {
                $this->saveUserAction(4, $id, $this->Session->read('Auth.User.id') , ActionsEnum::edit);
                $this->Flash->success(__('The temporary affectation has been saved.'));
                $this->redirect(array('action' => 'index_temporary'));
            } else {
                $this->Flash->error(__('The temporary affectation could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CustomerCar.' . $this->CustomerCar->primaryKey => $id));
            $this->request->data = $this->CustomerCar->find('first', $options);
            if ($this->request->data['CustomerCar']['locked'] == 1) {
                $this->Flash->error(__('You must first unlock the request reservation.'));
                $this->redirect(array('action' => 'index_request'));
            }
            $this->isOpenedByOtherUser("CustomerCar", 'CustomerCars', 'reservation', $id);

        }
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {
            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.immatr_def, ' - ', Carmodel.name)"
            );
        }
        $cond = $this->getConditionsTemporary();

        if (!empty($cond[1])) {
            $conditions_car = array_merge($cond[1], array(
                'OR' => array(
                    array('Car.in_mission' => 0),
                    array('Car.id' => $id),
                )
            ));
        } else {
            $conditions_car = array(
                'OR' => array(
                    array('Car.car_status_id' => 6, 'Car.in_mission' => 0),
                    array('Car.id' => $id),
                )
            );
        }
        $conditions_customer = $cond[2];
        $cars = $this->CustomerCar->Car->find('list', array(
            'conditions' => $conditions_car,
            'fields' => 'cnames',
            'recursive' => 1,
            'order' => array('Car.code asc', 'Carmodel.name asc')
        ));
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditions_customer);
        $options = $this->CarOption->getCarOptions();
        $zones = $this->Zone->getZones();
        $customerGroups = $this->CustomerGroup->getCustomerGroups();
        $this->set(compact('cars', 'customers', 'options', 'customerGroups', 'zones'));
    }

    /**
     * verify if car id is selected
     * if yes validate request
     * if no choose car id
     *
     */
    public function verifyCarId()
    {
        $this->autoRender = false;

        $id = filter_input(INPUT_POST, "id");
        if ($this->Auth->user('role_id') != 3) {
            $this->Flash->error(__("You don't have permission to do this action."));
            $this->redirect(array('action' => 'index_request'));
        } else {
            $this->CustomerCar->recursive = 2;
            $customerCar = $this->CustomerCar->find('first',
                array('conditions' => array('CustomerCar.' . $this->CustomerCar->primaryKey => $id)));
            $carId = $customerCar['CustomerCar']['car_id'];
            $carTypeId = $customerCar['CustomerCar']['car_type_id'];
            $start = $customerCar['CustomerCar']['start'];
            if (!empty($carId)) {
                //$this->validateRequest($id ,$carId );

                echo json_encode(array("response" => true, "customerCarId" => $id, 'carId' => $carId));
            } else {
                echo json_encode(array(
                    "response" => false,
                    "carType" => $carTypeId,
                    "customerCarId" => $id,
                    "start" => $start
                ));
            }
        }
    }

    public function selectCarId($carTypeId = null, $id = null)
    {

        $this->layout = 'popup';

        if (!empty($this->request->data)) {
            $carId = $this->request->data['CustomerCar']['car_id'];

            $this->validateRequest($id, $carId);
        }
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->CustomerCar->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(Car.immatr_def,Car.immatr_prov), ' - ',Carmodel.name )"
            );
        }

        $cars = $this->CustomerCar->Car->find('list', array(
            'fields' => 'cnames',
            'recursive' => -1,
            'order' => 'Carmodel.name asc',
            'conditions' => array('Car.car_type_id' => $carTypeId),
            'joins' => array(

                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                )
            )
        ));

        if (empty($cars)) {
            $carWithType = 0;
            $cars = $this->CustomerCar->Car->find('list', array(
                'fields' => 'cnames',
                'recursive' => -1,
                'order' => 'Carmodel.name asc',
                'joins' => array(

                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    )
                )
            ));
        } else {
            $carWithType = 1;
        }
        $this->set(compact('cars', 'carWithType'));


    }

    function validateRequest($id = null, $carId = null)
    {
        $customerCar = $this->CustomerCar->find('first',
            array('conditions' => array('CustomerCar.' . $this->CustomerCar->primaryKey => $id)));

        $start = $customerCar['CustomerCar']['start'];
        $customerCars = $this->CustomerCar->find('all', array(
            'conditions' => array(
                'CustomerCar.car_id' => $carId,
                'CustomerCar.validated' => 1,
                'end >=' => $start
            )
        ));

        if (empty($customerCars)) {
            $this->CustomerCar->id = $id;
            $this->CustomerCar->saveField('validated', 1);
            $this->CustomerCar->saveField('car_id', $carId);
            $this->Flash->success(__('The request has been validated.'));
            $this->updateCarStatus($carId, 0);
            $this->redirect(array('action' => 'index_request'));

        } else {
            $this->Flash->error(__('The request could not be validated because the car is reserved in this date.'));
            $this->redirect(array('action' => 'index_request'));
        }


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
        $current = $this->CustomerCar->find("first", array("conditions" => array("CustomerCar.id" => $id)));
        if ($current ['CustomerCar']['request'] == 1) {
            $this->verifyUserPermission(SectionsEnum::demande_affectation, $user_id, ActionsEnum::delete,
                "CustomerCars", $id, "CustomerCar", null);
        } else {
            $this->verifyUserPermission(SectionsEnum::affectation, $user_id, ActionsEnum::delete, "CustomerCars", $id,
                "CustomerCar", null);
        }
        $this->CustomerCar->id = $id;
        if (!$this->CustomerCar->exists()) {
            throw new NotFoundException(__('Invalid affectation'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');


        if ($current['CustomerCar']['locked']) {
            $this->Flash->error(__('You must first unlock the affectation.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->CustomerCar->delete()) {
            $this->saveUserAction(SectionsEnum::affectation, $id, $this->Session->read('Auth.User.id') , ActionsEnum::delete);
            $this->Flash->success(__('The affectation has been deleted.'));
            $this->updateCarStatusAvailable($current['CustomerCar']['car_id']);
            $this->updateCarStatusAvailable($current['CustomerCar']['remorque_id']);
        } else {
            $this->Flash->error(__('The affectation could not be saved. Please, try again.'));
        }

        if ($current ['CustomerCar']['request'] == 1) {
            $this->redirect(array('action' => 'index_request'));
        } elseif($current ['CustomerCar']['temporary'] == 1){
            $this->redirect(array('action' => 'index_temporary'));
        }else{
            $this->redirect(array('action' => 'index'));
        }
    }

    private function verifyDependences($id)
    {
        $affectationPvs = $this->Affectationpv->find('all',
            array(
                'recursive' => -1,
                'conditions' => array(
                    'Affectationpv.customer_car_id' => $id
                )
            )
        );
        if (!empty($affectationPvs)) {
            $this->Affectationpv->deleteAll(array('Affectationpv.customer_car_id' => $id), false);
        }

        $autorisations = $this->Autorisation->find('all',
            array(
                'recursive' => -1,
                'conditions' => array(
                    'Autorisation.customer_car_id' => $id
                )
            )
        );
        if (!empty($autorisations)) {
            $this->Autorisation->deleteAll(array('Autorisation.customer_car_id' => $id), false);
        }
    }

    function updateCarStatusAvailable($car_id)
    {
        $this->setTimeActif();
        $car = $this->Car->find('all', array(
            'recursive' => -1,
            'conditions' => array('id' => $car_id, 'Car.car_status_id' => 6)
        ));

        if (!empty($car)) {

            $this->Car->id = $car_id;
            $this->Car->saveField('car_status_id', 1);
        }

    }

    public function deletecustomercars()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::affectation, $user_id, ActionsEnum::delete, "CustomerCars", $id,
            "CustomerCar", null);

        $this->request->allowMethod('post', 'delete');
        $current = $this->CustomerCar->find("first", array("conditions" => array("CustomerCar.id" => $id)));
        if (!$current['CustomerCar']['locked']) {
            $this->CustomerCar->id = $id;
            $this->verifyDependences($id);
            if ($this->CustomerCar->delete()) {
                $this->saveUserAction(SectionsEnum::affectation, $id, $this->Session->read('Auth.User.id') , ActionsEnum::delete);
                echo json_encode(array("response" => "true"));
                $this->updateCarStatusAvailable($current['CustomerCar']['car_id']);

                $this->updateCarStatusAvailable($current['CustomerCar']['remorque_id']);

            } else {
                echo json_encode(array("response" => "false"));
            }
        } else {
            echo json_encode(array("response" => "false"));
        }


    }

    public function view_pdf($id)
    {
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        if (!$this->CustomerCar->exists($id)) {
            throw new NotFoundException(__('Invalid affectation'));
        }
        $options = array('conditions' => array('CustomerCar.' . $this->CustomerCar->primaryKey => $id));
        $this->CustomerCar->recursive = 2;
        $this->set('customerCar', $this->CustomerCar->find('first', $options));
        $company = $this->Company->find('first');
        $this->set('company', $company);
    }

    public function contrat_pdf($id)
    {
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        if (!$this->CustomerCar->exists($id)) {
            throw new NotFoundException(__('Invalid reservation'));
        }
        $options = array('conditions' => array('CustomerCar.' . $this->CustomerCar->primaryKey => $id));
        $this->CustomerCar->recursive = 2;
        $this->set('customerCar', $this->CustomerCar->find('first', $options));
        $company = $this->Company->find('first');
        $this->set('company', $company);
    }

    public function view_mission($id)
    {
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        if (!$this->CustomerCar->exists($id)) {
            throw new NotFoundException(__('Invalid affectation'));
        }
        $options = array('conditions' => array('CustomerCar.' . $this->CustomerCar->primaryKey => $id));
        $this->CustomerCar->recursive = 2;
        $this->set('customerCar', $this->CustomerCar->find('first', $options));
        $company = $this->Company->find('first');
        $this->set('company', $company);
        // get method of header pdf
        $entete_pdf = $this->Parameter->getCodesParameterVal('entete_pdf');
        // get signature of mission order
        $signature_mission_order = $this->Parameter->getCodesParameterVal('signature_mission_order');

        $this->set('signature_mission_order', $signature_mission_order);
        $this->set('entete_pdf', $entete_pdf);
    }

    public function view_mission_01($id)
    {
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        if (!$this->CustomerCar->exists($id)) {
            throw new NotFoundException(__('Invalid affectation'));
        }
        $options = array('conditions' => array('CustomerCar.' . $this->CustomerCar->primaryKey => $id));
        $this->CustomerCar->recursive = 2;
        $this->set('customerCar', $this->CustomerCar->find('first', $options));
        $company = $this->Company->find('first');
        $this->set('company', $company);
        // get method of header pdf
        $entete_pdf = $this->Parameter->getCodesParameterVal('entete_pdf');
        // get signature of mission order
        $signature_mission_order = $this->Parameter->getCodesParameterVal('signature_mission_order');

        $this->set('signature_mission_order', $signature_mission_order);
        $this->set('entete_pdf', $entete_pdf);
    }

    public function view_mission_02($id)
    {
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        if (!$this->CustomerCar->exists($id)) {
            throw new NotFoundException(__('Invalid affectation'));
        }
        $options = array('conditions' => array('CustomerCar.' . $this->CustomerCar->primaryKey => $id));
        $this->CustomerCar->recursive = 2;
        $customerCar = $this->CustomerCar->find('first', $options);
        $remorque = $this->CustomerCar->Car->find('first',
            array('recursive' => 1, 'conditions' => array('Car.id' => $customerCar['CustomerCar']['remorque_id'])));

        //$customer_help=$this->CustomerCar->Customer->find('first',array('recursive'=>1,'conditions'=>array('Customer.id'=>$customerCar['CustomerCar']['customer_help'])));
        $this->set('remorque', $remorque);
        // $this->set('customer_help',$customer_help);
        $this->set('customerCar', $customerCar);
        $company = $this->Company->find('first');
        $this->set('company', $company);
        // get method of header pdf
        $entete_pdf = $this->Parameter->getCodesParameterVal('entete_pdf');
        // get signature of mission order
        $signature_mission_order = $this->Parameter->getCodesParameterVal('signature_mission_order');

        $this->set('signature_mission_order', $signature_mission_order);
        $this->set('entete_pdf', $entete_pdf);
    }

    public function export_pdf($id)
    {
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        if (!$this->CustomerCar->exists()) {
            throw new NotFoundException(__('Invalid affectation'));
        }
        $options = array('conditions' => array('CustomerCar.' . $this->CustomerCar->primaryKey => $id));
        $this->CustomerCar->recursive = 2;
        $this->set('customerCar', $this->CustomerCar->find('first', $options));
        $company = $this->Company->find('first');
        $this->set('company', $company);
    }

    function export()
    {   
        $this->setTimeActif();
        if (isset($this->params['named']['keyword']) || isset($this->params['named']['car'])
            || isset($this->params['named']['customer']) || isset($this->params['named']['user'])
            || isset($this->params['named']['start1']) || isset($this->params['named']['end1'])
            || isset($this->params['named']['start2']) || isset($this->params['named']['end2'])
            || isset($this->params['named']['end_real1']) || isset($this->params['named']['end_real2'])
            || isset($this->params['named']['zone']) || isset($this->params['named']['parc'])
            || isset($this->params['named']['created']) || isset($this->params['named']['created1'])
            || isset($this->params['named']['modified_id']) || isset($this->params['named']['paid'])
            || isset($this->params['named']['modified']) || isset($this->params['named']['modified1'])
            || isset($this->params['named']['validated']) || isset($this->params['named']['request'])
            || isset($this->params['named']['customerGroup']) || isset($this->params['named']['state'])
        ) {
            $conditions = $this->getConds();
            
            $reservations = $this->CustomerCar->find('all', array(
                'conditions' => $conditions,
                'paramType' => 'querystring',
                'order' => 'CustomerCar.id desc',
                'recursive' => -1,
                'fields' => array(
                    'CustomerCar.id',
                    'start',
                    'end',
                    'Customer.first_name',
                    'Customer.last_name',
                    'Customer.company',
                    'Car.code',
                    'Car.immatr_prov',
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
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('CustomerCar.customer_id = Customer.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('CustomerCar.user_id = User.id')
                    ),


                )
            ));


        } else {


            if (isset($this->params['pass']['0']) && $this->params['pass']['0'] == "all") {

                $reservations = $this->CustomerCar->find('all', array(
                    'paramType' => 'querystring',
                    'recursive' => -1, // should be used with joins
                    'order' => array('CustomerCar.id' => 'DESC'),
                    'fields' => array(
                        'CustomerCar.id',
                        'start',
                        'end',
                        'Customer.first_name',
                        'Customer.last_name',
                        'Customer.company',
                        'Car.code',
                        'Car.immatr_prov',
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
                            'table' => 'customers',
                            'type' => 'left',
                            'alias' => 'Customer',
                            'conditions' => array('CustomerCar.customer_id = Customer.id')
                        ),
                        array(
                            'table' => 'carmodels',
                            'type' => 'left',
                            'alias' => 'Carmodel',
                            'conditions' => array('Car.carmodel_id = Carmodel.id')
                        ),


                    )
                ));


            } else { 
                $ids = filter_input(INPUT_POST, "chkids");
                $array_ids = explode(",", $ids);
                $reservations = $this->CustomerCar->find('all', array(
                    'conditions' => array(
                        "CustomerCar.id" => $array_ids
                    ),
                    'paramType' => 'querystring',
                    'order' => 'CustomerCar.id desc',
                    'recursive' => -1,
                    'fields' => array(
                        'CustomerCar.id',
                        'start',
                        'end',
                        'Customer.first_name',
                        'Customer.last_name',
                        'Customer.company',
                        'Car.code',
                        'Car.immatr_prov',
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
                            'table' => 'customers',
                            'type' => 'left',
                            'alias' => 'Customer',
                            'conditions' => array('CustomerCar.customer_id = Customer.id')
                        ),
                        array(
                            'table' => 'carmodels',
                            'type' => 'left',
                            'alias' => 'Carmodel',
                            'conditions' => array('Car.carmodel_id = Carmodel.id')
                        ),


                    )
                ));
            }

        }
        $this->set('models', $reservations);

        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set('param', $param);
    }

    /**
     * @return null
     */
    function lock()
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->CustomerCar->id = $this->params['pass']['0'];
        $current = $this->CustomerCar->find("first",
            array("conditions" => array("CustomerCar.id" => $this->params['pass']['0'])));

        if ($current ['CustomerCar']['request'] == 1) {
            $this->verifyUserPermission(SectionsEnum::demande_affectation, $user_id, ActionsEnum::lock, "CustomerCars",
                $this->params['pass']['0'], "CustomerCar", null);
        } else {
            $this->verifyUserPermission(SectionsEnum::affectation, $user_id, ActionsEnum::lock, "CustomerCars",
                $this->params['pass']['0'], "CustomerCar", null);
        }
        $result = $this->setLocked('CustomerCar', $this->params['pass']['0'], 1);
        if ($result) {
            $this->Flash->success(__('The affectation has been locked.'));
        } else {
            $this->Flash->error(__('The reservation could not be locked.'));
        }

        if ($current ['CustomerCar']['request'] == 1) {
            $this->redirect(array('action' => 'index_request'));
        } else {
            if ($current ['CustomerCar']['temporary'] == 1) {
                return $this->redirect(array('controller' => 'CustomerCars', 'action' => 'index_temporary'));
            } else {
                $this->redirect(array('action' => 'index'));
            }
        }
        return null;
    }

    /**
     * @return null
     */
    function unlock()
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->CustomerCar->id = $this->params['pass']['0'];
        $current = $this->CustomerCar->find("first",
            array("conditions" => array("CustomerCar.id" => $this->params['pass']['0'])));
        if ($current ['CustomerCar']['request'] == 1) {
            $this->verifyUserPermission(SectionsEnum::demande_affectation, $user_id, ActionsEnum::lock, "CustomerCars",
                $this->params['pass']['0'], "CustomerCar", null);
        } else {
            $this->verifyUserPermission(SectionsEnum::affectation, $user_id, ActionsEnum::lock, "CustomerCars",
                $this->params['pass']['0'], "CustomerCar", null);
        }
        $result = $this->setLocked('CustomerCar', $this->params['pass']['0'], 0);
        if ($result) {
            $this->Flash->success(__('The reservation has been unlocked.'));
        } else {
            $this->Flash->success(__('The reservation has been unlocked.'));
        }

        if ($current ['CustomerCar']['request'] == 1) {
            $this->redirect(array('action' => 'index_request'));
        } else {

            if ($current ['CustomerCar']['temporary'] == 1) {

                return $this->redirect(array('controller' => 'CustomerCars', 'action' => 'index_temporary'));
            } else {
                $this->redirect(array('action' => 'index'));
            }
        }
        return null;
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

    public function openDir($dir = null, $id_dialog = null, $id_input = null)
    {


        $this->layout = 'ajax';


        //$this->verifAttachment('Car', 'file', 'attachments/yellowcards/', 'add',1,0,null);


        $array_fichier = array();
        $i = 0;

        if ($dossier = opendir('./attachments/picturesaffectation/' . $dir)) {
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


        $this->layout = 'ajax';


        $this->set('file_name', $this->params['pass']['0']);
        $this->set('Dir', $this->params['pass']['1']);

    }

    public function Send_mail($id = null)
    {

        $customer = $this->CustomerCar->find('first',
            array(
                'conditions' => array('CustomerCar.id' => $id),
                'recursive' => -1,
                'fields' => array('Customer.id', 'Customer.first_name', 'Customer.last_name', 'Customer.email1'),
                'joins' => array(
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('CustomerCar.customer_id = Customer.id')
                    ),
                )
            ));


        $options = array('conditions' => array('CustomerCar.' . $this->CustomerCar->primaryKey => $id));
        $this->CustomerCar->recursive = 2;
        $customerCar = $this->CustomerCar->find('first', $options);

        $company = $this->Company->find('first');

        App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'dompdf_config.inc.php'));
        ob_start();
        ?>

        <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
            <style type="text/css">
                @page {
                    margin: 95px 0;
                }

                #header {
                    position: fixed;
                    left: 0;
                    top: -95px;
                    right: 0;
                    height: 110px;
                    border-bottom: 1px solid #000;
                }

                #header td.logo {
                    width: 300px;
                    vertical-align: top;
                }

                #header td.company {
                    vertical-align: top;
                    font-weight: bold;
                    font-size: 16px;
                    text-align: center;
                }

                #header td.company span {
                    display: block;
                    font-size: 22px;
                    padding-bottom: 10px;
                    padding-top: 20px;
                }

                #footer {
                    position: fixed;
                    left: 0;
                    bottom: -95px;
                    right: 0;
                    height: 125px;
                }

                .copyright {
                    font-size: 10px;
                    text-align: center;
                }

                .box-body {
                    padding: 0;
                    margin: 0;
                    width: 100%;
                }

                .ref {
                    padding-top: 25px
                }

                .date {
                    padding-top: 5px;
                }

                .title {
                    font-weight: bold;
                    font-size: 24px;
                    text-align: center;
                    padding-top: 40px;
                    border-bottom: 1px solid #000;
                    width: 230px;
                    margin: 0 auto 30px;
                    font-style: italic;
                }

                .customer table {
                    border-collapse: collapse;
                    width: 100%;
                    font-size: 18px;
                }

                .customer tr td:first-child {
                    width: 250px !important;
                    font-weight: bold;
                    padding-bottom: 10px;

                }

                table.bottom {
                    margin-top: 40px;
                    width: 100%;
                    margin-bottom: 40px;
                    font-style: italic;
                }

                div.resp {
                    font-size: 18px;
                    border-bottom: 1px solid #000;
                    width: 280px;
                    margin-left: 530px;
                    font-style: italic;
                    font-weight: bold;
                }

                table.bottom td {
                    padding-top: 5px;
                    font-size: 18px;
                }

                table.footer {
                    width: 100%;
                    font-size: 12px;
                    margin-top: 20px;
                    padding-top: 10px;
                    border-top: 1px solid #690008;
                }

                table.footer td.first {
                    width: 50%;
                    text-align: left
                }

                table.footer td.second {
                    width: 50%;
                    text-align: left;
                }

                table.conditions td {
                    border: 1px solid grey;
                }

                table.conditions td {
                    vertical-align: top;
                    padding: 5px 5px 5px 10px;
                    line-height: 19px;
                }

                table.conditions_bottom td.first {
                    width: 420px
                }

                table.conditions_bottom td {
                    padding-top: 5px
                }

                .note span {
                    display: block;
                    text-decoration: underline;
                    padding-bottom: 5px;
                }
            </style>
        </head>
        <body>
        <div id="header">
            <table>
                <tr>
                    <td class="logo">
                        <img src="<?= WWW_ROOT ?>/logo/<?= $company['Company']['logo'] ?>" width="100px" height="100px">
                    </td>
                    <td class="company">
                        <span><?= $company['Company']['name'] ?></span>
                        <?php if (!empty($company['Company']['social_capital'])) { ?>
                            <?= $company['LegalForm']['name'] ?>
                            au Capital de <?= number_format($company['Company']['social_capital'], 2, ",", ".") ?>
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="box-body">
            <div class="ref">REF N� : <?= $customerCar['CustomerCar']['reference'] ?></div>
            <div class="date">DATE : <?= date("d-m-Y") ?></div>
            <div style="clear: both"></div>
            <div class="title">ORDRE DE MISSION</div>
            <div class="customer">
                <table>
                    <tr>
                        <td>&nbsp;Nom :</td>
                        <td>&nbsp;<?= $customerCar['Customer']['first_name'] ?> </td>
                    </tr>
                    <tr>
                        <td>&nbsp;Pr�nom :</td>
                        <td>&nbsp;<?= $customerCar['Customer']['last_name'] ?> </td>
                    </tr>
                    <tr>
                        <td> &nbsp;Fonction :</td>
                        <td> &nbsp;<?= $customerCar['Customer']['job'] ?></td>
                    </tr>
                    <tr>
                        <td> &nbsp;N� permis de conduire :</td>
                        <td> &nbsp;<?= $customerCar['Customer']['driver_license_nu'] ?></td>
                    </tr>
                    <tr>
                        <td> &nbsp;D�livr� le :</td>
                        <td>
                            &nbsp;<?= date('j M Y',
                                strtotime($customerCar['CustomerCar']['driver_license_date'])) ?></td>
                    </tr>
                    <tr>
                        <td> &nbsp;Par :</td>
                        <td> &nbsp;<?= $customerCar['Customer']['driver_license_by'] ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Objet de la mission :</td>
                        <td>&nbsp;<b><?= $customerCar['CustomerCar']['obs'] ?></b></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Lieu de d�part :</td>
                        <td>&nbsp;<?= $customerCar['CustomerCar']['departure_location'] ?> </td>
                    </tr>
                    <tr>
                        <td>&nbsp;Lieu de retour :</td>
                        <td>&nbsp;<?= $customerCar['CustomerCar']['return_location'] ?> </td>
                    </tr>
                    <tr>
                        <td>&nbsp;Date et heure de d�part :</td>
                        <td>&nbsp;<?= date('j M Y', strtotime($customerCar['CustomerCar']['start'])) ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Date et heure de retour :</td>
                        <td>&nbsp;<?= date('j M Y', strtotime($customerCar['CustomerCar']['end'])) ?> </td>
                    </tr>
                    <tr>
                        <td>&nbsp;V�hicule :</td>
                        <td>&nbsp;<?= $customerCar['Car']['Carmodel']['name'] . " " .
                            $customerCar['Car']['code'] ?> </td>
                    </tr>
                    <tr>
                        <td>&nbsp;Immatricule :</td>
                        <td>&nbsp;<?php if (!empty($customerCar['Car']['immatr_def'])) {
                                echo $customerCar['Car']['immatr_def'];
                            } else {
                                echo $customerCar['Car']['immatr_prov'];
                            }
                            ?></td>
                    </tr>
                </table>
            </div>
            <table class="bottom">
                <tr>
                    <td colspan="2">
                        Le pr�sent ordre de mission leur est d�livr� pour leur faciliter la tache aupr�s des autorit�s
                        comp�tentes.
                    </td>
                </tr>
            </table>
            <div class="resp">Le responsable logistique</div>
        </div>
        <div id="footer">
            <table class="footer">
                <tr>
                    <td class="first">
                        <?= $company['LegalForm']['name'] ?>
                        <?php if (!empty($company['Company']['social_capital'])) { ?>
                            au Capital de <?=
                            number_format($company['Company']['social_capital'], 2, ",",
                                ".") . " " . $this->Session->read('currency')
                            ?>
                        <?php } else { ?>
                            <?= $company['Company']['name'] ?>
                        <?php } ?>
                        - RC : <?= $company['Company']['rc'] ?>
                    </td>
                    <td class="second">
                        <?= $company['Company']['adress'] ?>
                    </td>
                </tr>
                <tr>
                    <td class="first">
                        N�AI : <?= $company['Company']['ai'] ?> - N�IF : <?= $company['Company']['nif'] ?>
                    </td>
                    <td class="second">
                        T�l�phone : <?= $company['Company']['phone'] ?>
                    </td>
                </tr>
                <tr>
                    <td class="first">
                        CB : <?= $company['Company']['cb'] ?> RIB : <?= $company['Company']['rib'] ?>
                    </td>
                    <td class="second">
                        Mobile : <?= $company['Company']['mobile'] ?>
                    </td>
                </tr>
            </table>
            <p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
        </div>
        </body>
        </html>


        <?php
        $html = ob_get_clean();

        $this->dompdf = new Dompdf(array('chroot' => WWW_ROOT));
        $papersize = "A4";
        $orientation = 'portrait';
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper($papersize, $orientation);
        $this->dompdf->render();

        $output = $this->dompdf->output();
        $name = 'Ordre_Mission' . '_' . $customerCar['Customer']['first_name'] . '_' . $customerCar['Customer']['last_name'] . '_' . date('Y_m_d') . '.pdf';
        file_put_contents('./mission_order/' . $name, $output);


        if (!empty($customer['Customer']['email1'])) {

            $Email = new CakeEmail('smtp');


            $Email->addTo($customer['Customer']['email1']);
            $msg = __("Please find attached copy of your mission order");
            $Email->template('welcome', 'fancy')
                ->emailFormat('html')
                ->from('k.ouabou@intellixweb.com')
                ->to($customer['Customer']['email1'])
                ->subject('Ordre de Mission UtranX')
                ->attachments(array('./mission_order/' . $name));

            if ($Email->send($msg)) {
                $this->Flash->success(__('Your Email has been sent.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('Your Email has not been sent. Try again.'));
                $this->redirect(array('action' => 'index'));
            }

        } else {

            $this->Flash->error(__('The email ') . lcfirst(__("Customer")) . __(' is empty.'));
            $this->redirect(array('action' => 'index'));
        }


    }

    public function verifyDriverLicenseCategory()
    {
        $this->setTimeActif();
        $this->autoRender = false;

        $car_id = filter_input(INPUT_POST, "car_id");

        $customer_id = filter_input(INPUT_POST, "customer_id");

        $car = $this->CustomerCar->Car->find("first", array(

            "conditions" => array("Car.id" => $car_id),
            'recursive' => -1,
            'fields' => array('Car.id', 'Car.code', 'Car.car_category_id', 'Car.car_type_id')
        ));
        if ($car['Car']['car_category_id'] == 1) {
            if ($car['Car']['car_type_id'] == 10 || $car['Car']['car_type_id'] == 11
                || $car['Car']['car_type_id'] == 16 || $car['Car']['car_type_id'] == 19
            ) {
                $driverLicenseCategory = $this->CustomerCar->Customer->find("first", array(

                    "conditions" => array(
                        "Customer.id" => $customer_id,
                        "LOWER(Customer.driver_license_category) LIKE" => "%5%"
                    ),
                    'recursive' => -1,
                    'fields' => array('Customer.id', 'Customer.driver_license_category')
                ));
                if (empty($driverLicenseCategory)) {
                    echo json_encode(array("response" => "true", 'car_category_id' => '1', 'car_type_id' => $car['Car']['car_type_id']));
                } else {
                    echo json_encode(array("response" => "false"));
                }
            } else {
                $driverLicenseCategory = $this->CustomerCar->Customer->find("first", array(

                    "conditions" => array(
                        "Customer.id" => $customer_id,
                        "LOWER(Customer.driver_license_category) LIKE" => "%3%"
                    ),
                    'recursive' => -1,
                    'fields' => array('Customer.id', 'Customer.driver_license_category')
                ));
                if (empty($driverLicenseCategory)) {
                    echo json_encode(array("response" => "true", 'car_category_id' => '1', 'car_type_id' => $car['Car']['car_type_id']));
                } else {
                    echo json_encode(array("response" => "false"));
                }
            }


        } elseif ($car['Car']['car_category_id'] == 2) {
            $driverLicenseCategory = $this->CustomerCar->Customer->find("first", array(

                "conditions" => array(
                    "Customer.id" => $customer_id,
                    "LOWER(Customer.driver_license_category) LIKE" => "%2%"
                ),
                'recursive' => -1,
                'fields' => array('Customer.id', 'Customer.driver_license_category')
            ));
            if (empty($driverLicenseCategory)) {
                echo json_encode(array("response" => "true", 'car_category_id' => '2'));
            } else {
                echo json_encode(array("response" => "false"));
            }
        } else {
            echo json_encode(array("response" => "false"));
        }

    }

    public function affectation_pv($id = null, $reception)
    {
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        if (!$this->CustomerCar->exists($id)) {
            throw new NotFoundException(__('Invalid affectation'));
        }

        $options = array('conditions' => array('CustomerCar.' . $this->CustomerCar->primaryKey => $id));
        $this->CustomerCar->recursive = 2;
        $customerCar = $this->CustomerCar->find('first', $options);
        $affectationpvs = $this->Affectationpv->find('first', array(
            'recursive' => -1,
            'conditions' => array('Affectationpv.customer_car_id' => $id, 'Affectationpv.reception' => $reception)
        ));

        $this->set('affectationpvs', $affectationpvs);
        $this->set('customerCar', $customerCar);

        $company = $this->Company->find('first');
        $this->set('company', $company);

        $observation1 = $this->Parameter->getCodesParameterVal('observation1');
        $observation2 = $this->Parameter->getCodesParameterVal('observation2');
        $this->set(compact('observation1', 'observation2'));

    }

    public function dechargePdf($id = null)
    {
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        if (!$this->CustomerCar->exists($id)) {
            throw new NotFoundException(__('Invalid affectation'));
        }

        $options = array('conditions' => array('CustomerCar.' . $this->CustomerCar->primaryKey => $id));
        $this->CustomerCar->recursive = 2;
        $customerCar = $this->CustomerCar->find('first', $options);


        $this->set('customerCar', $customerCar);

        $company = $this->Company->find('first');
        $this->set('company', $company);

    }

    public function getCarsByType($type_id = null)
    {


        $this->setTimeActif();
        $this->layout = 'ajax';
        if ($type_id != null) {


            $param = $this->Parameter->getCodesParameterVal('name_car');
            if ($param == 1) {
                $this->CustomerCar->Car->virtualFields = array(
                    'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
                );
            } elseif ($param == 2) {

                $this->CustomerCar->Car->virtualFields = array(
                    'cnames' => "CONCAT(IFNULL(Car.immatr_def,Car.immatr_prov), ' - ',Carmodel.name )"
                );
            }
            $this->set('selectbox', $this->CustomerCar->Car->find('list', array(
                'conditions' => array('Car.car_type_id' => $type_id),
                'fields' => 'cnames',
                'recursive' => 1,
                'order' => array('Car.code asc', 'Carmodel.name asc'),
            )));

        } else {
            $this->set('selectbox', null);
        }

    }

    public function import()
    {
        if (!empty($this->request->data['CustomerCar']['file_csv']['tmp_name'])) {

            if (is_uploaded_file($this->request->data['CustomerCar']['file_csv']['tmp_name'])) {
                $fichier = $this->request->data['CustomerCar']['file_csv']['name'];
                $ext = substr(strtolower(strrchr($fichier, '.')), 1);
                if ($ext == 'csv') {
                    if ($fichier) {
                        $fp = fopen($this->request->data['CustomerCar']['file_csv']['tmp_name'], "r");

                    } else {

                        echo('fichier introuvable');
                        exit();
                    }
                    $cpt = 0;
                    while (!feof($fp)) {

                        $ligne = fgets($fp, 4096);
                        if (count(explode(";", $ligne)) > 1) {

                            $liste = explode(";", $ligne);
                        } else {

                            $liste = explode(",", $ligne);
                        }
                        filter_input(INPUT_POST, 'file_csv');
                        $liste[0] = (isset($liste[0])) ? $liste[0] : null;
                        $liste[1] = (isset($liste[1])) ? $liste[1] : null;
                        $liste[2] = (isset($liste[2])) ? $liste[2] : null;
                        $car = $liste[0];
                        $conductor = $liste[1];
                        $remorque = $liste[2];
                        $carId = $this->getCarId($car);
                        $customerId = $this->getCustomerId($conductor);
                        $remorqueId = $this->getRemorqueId($remorque);


                        if ($cpt > 0) {
                            $this->CustomerCar->create();
                            $this->request->data['CustomerCar']['reference'] = $this->getNextReference('CustomerCar',
                                'affectation');


                            $this->request->data['CustomerCar']['car_id'] = $carId;
                            $this->request->data['CustomerCar']['customer_id'] = $customerId;
                            $this->request->data['CustomerCar']['remorque_id'] = $remorqueId;
                            $this->request->data['CustomerCar']['user_id'] = $this->Session->read('Auth.User.id');
                            $this->request->data['CustomerCar']['validated'] = 1;

                            if (!empty($this->request->data['CustomerCar']['customer_id'])
                            && !empty($this->request->data['CustomerCar']['car_id'])){
                                $this->CustomerCar->save($this->request->data);
                            }

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

// get Car  id from immatricule
    public function getCarId($carImport)
    {
        $carImport = trim($carImport);
        $carImport = strtolower($carImport);
        $carId = 0;
        $cars = $this->Car->find('all', array('recursive' => -1, 'conditions' => array('Car.car_type_id !=' => 3)));

        foreach ($cars as $car) {
            $carCode = strtolower($car['Car']['code']);
            if ($carImport == $carCode) {
                $carId = $car['Car']['id'];
            }
        }
        return $carId;

    }

    // get  conductor id from first name and last name
    public function getCustomerId($conductorImport)
    {
        $conductorImport = trim($conductorImport);
        $conductorImport = strtolower($conductorImport);

        $customerId = 0;
        $customers = $this->CustomerCar->Customer->find('all', array('recursive' => -1));

        foreach ($customers as $customer) {
            $customerCode = strtolower($customer['Customer']['code']);
            if ($conductorImport == $customerCode) {
                $customerId = $customer['Customer']['id'];
            }
        }

        return $customerId;

    }


    // get  conductor id from first name and last name
    public function getRemorqueId($remorqueImport)
    {
        $remorqueImport = trim($remorqueImport);
        $remorqueImport = strtolower($remorqueImport);

        $remorqueId = 0;
        $remorques = $this->Car->find('all', array('recursive' => -1, 'conditions' => array('Car.car_category_id' => 3)));

        foreach ($remorques as $remorque) {
            $remorqueCode = strtolower($remorque['Car']['code']);
            if ($remorqueImport == $remorqueCode) {
                $remorqueId = $remorque['Car']['id'];
            }
        }

        return $remorqueId;

    }

// creer un format de date qui peut etre enregister dans la bdd
    public function getDate($date)
    {
        $dateResult = '';
        $date = trim($date);
        $date = strtolower($date);
        $this->request->data['CustomerCar']['date'] = $date;
        $this->createDatetimeFromDate('CustomerCar', 'CustomerCar');
        if (empty($this->request->data['CustomerCar']['date'])) {
            $this->createDatetimeFromDatetimeFormat2('CustomerCar', 'CustomerCar');
            if (!empty($this->request->data['CustomerCar']['date'])) {
                $dateResult = $this->request->data['CustomerCar']['date'];
            }
        } else {
            $dateResult = $this->request->data['CustomerCar']['date'];
        }
        return $dateResult;
    }

    public function getConductorsOrGroups($id = null, $customerCarId = null)
    {

        $this->set('id', $id);
        if ($id == 1) {
            $cond = $this->getConditions();
            $conditionsCustomer = $cond[2];
            $fields = "names";
            $customers = $this->Customer->getCustomersByFieldsAndConds($fields, $conditionsCustomer);
            $customerId = null;
            if ($customerCarId != null) {
                $customerCar = $this->CustomerCar->find("first", array(
                    'fields' => array('customer_id'),
                    'recursive' => -1,
                    'conditions' => array('CustomerCar.id' => $customerCarId)
                ));
                $customerId = $customerCar['CustomerCar']['customer_id'];
            }

            $this->set('customers', $customers);
            $this->set('customerId', $customerId);
        } else {
            if ($id == 2) {
                $customerGroups = $this->CustomerGroup->getCustomerGroups();
                $groupId = null;
                if ($customerCarId != null) {
                    $customerCar = $this->CustomerCar->find("first", array(
                        'fields' => array('customer_group_id'),
                        'recursive' => -1,
                        'conditions' => array('id' => $customerCarId)
                    ));
                    $groupId = $customerCar['CustomerCar']['customer_group_id'];
                }

                $this->set('customerGroups', $customerGroups);
                $this->set('groupId', $groupId);

            }
        }
    }

    public function liste($id = null, $keyword = null)
    {

        $keyword = str_replace('espace', ' ', $keyword);
        $keyword = str_replace('slash', '/', $keyword);
        $keyword = str_replace('tiret', '-', $keyword);

        $this->layout = 'ajax';
        $limit = $this->getLimit();
        switch ($id) {
            case 2 :
                $conditions = array(
                    'OR' => array(
                        "LOWER(Car.code) LIKE" => "%$keyword%",
                        "LOWER(Car.immatr_def) LIKE" => "%$keyword%",
                        "LOWER(Carmodel.name) LIKE" => "%$keyword%",
                    )
                );
                break;
            case 3 :
                $conditions = array("LOWER(Car.immatr_prov) LIKE" => "%$keyword%");
                break;
            case 4 :
                $conditions = array("LOWER(Car.immatr_def) LIKE" => "%$keyword%");
                break;
            case 5 :
                $conditions = array(
                    'OR' => array(
                        "LOWER(Customer.first_name) LIKE" => "%$keyword%",
                        "LOWER(Customer.last_name) LIKE" => "%$keyword%",
                    )
                );
                break;
            case 6 :
                $conditions = array("LOWER(Group.name) LIKE" => "%$keyword%");
                break;
            case 7 :
                $conditions = array("LOWER(Customer.mobile) LIKE" => "%$keyword%");
                break;
            case 8 :
                if(!empty($keyword)){
                    $keyword = str_replace("/", "-", $keyword);
                    $start = str_replace("-", "/", $keyword);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $conditions = array("CustomerCar.start >=" => $startdtm->format('Y-m-d 00:00:00'));
                }else {
                    $conditions = array();
                }
                break;
            case 9 :
                if(!empty($keyword)){
                    $keyword = str_replace("/", "-", $keyword);
                    $start = str_replace("-", "/", $keyword);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $conditions = array("CustomerCar.end >=" => $startdtm->format('Y-m-d 00:00:00'));
                }else {
                    $conditions = array();
                }

                break;
            case 10 :
                if(!empty($keyword)){
                    $keyword = str_replace("/", "-", $keyword);
                    $start = str_replace("-", "/", $keyword);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $conditions = array("CustomerCar.end_real >=" => $startdtm->format('Y-m-d 00:00:00'));
                }else {
                    $conditions = array();
                }

                break;

            default:
                $conditions = array("LOWER(Customer.code) LIKE" => "%$keyword%");
        }

        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'order' => array('CustomerCar.id' => 'DESC'),
            'conditions' => $conditions,
            'limit' => $limit,
            'fields' => array(
                'CustomerCar.id',
                'start',
                'end',
                'end_real',
                'CustomerCar.disabled',
                'CustomerCar.locked',
                'CustomerCar.validated',
                'CustomerCar.user_id',
                'Customer.first_name',
                'Customer.last_name',
                'Customer.company',
                'Customer.mobile',
                'Car.code',
                'Car.parc_id',
                'Car.immatr_prov',
                'Car.immatr_def',
                'Car.parc_id',
                'Carmodel.name',
                'Zone.name',
                'CustomerGroup.name'

            ),
            'joins' => array(
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('CustomerCar.car_id = Car.id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('CustomerCar.customer_id = Customer.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'zones',
                    'type' => 'left',
                    'alias' => 'Zone',
                    'conditions' => array('CustomerCar.zone_id = Zone.id')
                ),
                array(
                    'table' => 'customer_groups',
                    'type' => 'left',
                    'alias' => 'CustomerGroup',
                    'conditions' => array('CustomerCar.customer_group_id = CustomerGroup.id')
                )

            )
        );

        $customerCars = $this->Paginator->paginate('CustomerCar');

        $this->set('customercars', $customerCars);

        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set('param', $param);


    }

    public function regulateReference()
    {
        $customerCars = $this->CustomerCar->find('all', array(
            'recursive' => -1,
            'order' => 'id ASC',
            'conditions' => array('id >' => 1),
            'fields' => array('id', 'reference')
        ));
        foreach ($customerCars as $customerCar) {
            $reference = $this->getNextReference('CustomerCar', 'affectation');

            $this->CustomerCar->id = $customerCar['CustomerCar']['id'];
            $this->CustomerCar->saveField('reference', $reference);

        }

    }

    public function checkList($id = null){
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        if (!$this->CustomerCar->exists($id)) {
            throw new NotFoundException(__('Invalid affectation'));
        }

        $options = array('conditions' => array('CustomerCar.' . $this->CustomerCar->primaryKey => $id));
        $this->CustomerCar->recursive = 2;
        $customerCar = $this->CustomerCar->find('first', $options);
        $affectationpvsR = $this->Affectationpv->find('first', array(
            'recursive' => -1,
            'conditions' => array('Affectationpv.customer_car_id' => $id, 'Affectationpv.reception' => 1)
        ));
        $user = $this->Auth->user();

        $affectationpvsRes = $this->Affectationpv->find('first', array(
            'recursive' => -1,
            'conditions' => array('Affectationpv.customer_car_id' => $id, 'Affectationpv.reception' => 0)
        ));

        $this->set('affectationpvsR', $affectationpvsR);
        $this->set('affectationpvsRes', $affectationpvsRes);
        $this->set('customerCar', $customerCar);
        $this->set('user', $user);

        $company = $this->Company->find('first');
        $this->set('company', $company);

        $observation1 = $this->Parameter->getCodesParameterVal('observation1');
        $observation2 = $this->Parameter->getCodesParameterVal('observation2');
        $this->set(compact('observation1', 'observation2'));
    }

    public function print_passation($id = null){
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        if (!$this->CustomerCar->exists($id)) {
            throw new NotFoundException(__('Invalid affectation'));
        }

        $options = array('conditions' => array('CustomerCar.' . $this->CustomerCar->primaryKey => $id));
        $this->CustomerCar->recursive = 2;
        $customerCar = $this->CustomerCar->find('first', $options);
        $affectationpvs = $this->Affectationpv->find('first', array(
            'recursive' => -1,
            'conditions' => array('Affectationpv.customer_car_id' => $id, 'Affectationpv.passation' => 1)
        ));


        $receivingElement = $this->Customer->find('all', array('conditions' => array('Customer.id' => $affectationpvs['Affectationpv']['receiving_customer_id'])));
        $transferingElement = $this->Customer->find('all', array('conditions' => array('Customer.id' => $affectationpvs['Affectationpv']['transfering_customer_id'])));
        $this->set('receivingElement', $receivingElement);
        $this->set('transferingElement', $transferingElement);
        $this->set('affectationpvs', $affectationpvs);
        $this->set('customerCar', $customerCar);

        $company = $this->Company->find('first');
        $this->set('company', $company);

        $observation1 = $this->Parameter->getCodesParameterVal('observation1');
        $observation2 = $this->Parameter->getCodesParameterVal('observation2');
        $this->set(compact('observation1', 'observation2'));
    }


}
