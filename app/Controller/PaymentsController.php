<?php
include("Enum.php");
include("PaymentAssociationsEnum.php");
/**
 * Payments Controller
 *
 * @property Compte $Compte
 * @property Mark $Mark
 * @property Carmodel $Carmodel
 * @property CarType $CarType
 * @property Fuel $Fuel
 * @property Interfering $Interfering
 * @property Company $Company
 * @property Consumption $Consumption
 * @property PaymentCategory $PaymentCategory
 * @property CustomerCar $CustomerCar
 * @property DetailPayment $DetailPayment
 * @property Customer $Customer
 * @property Reservation $Reservation
 * @property Supplier $Supplier
 * @property Profile $Profile
 * @property FuelLog $FuelLog
 * @property Payment $Payment
 * @property CarGroup $CarGroup
 * @property AcquisitionType $AcquisitionType
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class PaymentsController extends AppController
{

    public $components = array('Paginator', 'Session', 'RequestHandler', 'Security');
    public $uses = array(
        'Compte',
        'Mark',
        'Carmodel',
        'CarType',
        'Fuel',
        'Parc',
        'Company',
        'AcquisitionType',
        'Payment',
        'Customer',
        'CarGroup',
        'DetailPayment',
        'Reservation',
        'Interfering',
        'Profile',
        'PaymentCategory',
        'CustomerCar',
        'Consumption',
        'FuelLog',
        'Compte',
    );
    public function getOrder($params = null)
    {
        if (isset($params) && is_numeric($params)) {
            switch ($params) {
                case 1 :
                    $order = array('Payment.wording' => 'DESC');
                    break;
                case 2 :
                    $order = array('Payment.id' => 'DESC');
                    break;
                case 3 :
                    $order = array('Payment.receipt_date' => 'DESC');
                    break;
                default :
                    $order = array('Payment.receipt_date' => 'DESC');
            }
            return $order;
        } else {
            $order = array('Payment.receipt_date' => 'DESC');
            return $order;
        }
    }

    public function index()
    {
        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        $this->settimeactif();
        if (Configure::read("cafyb") == '1') {
            if($this->Session->read('Permission.payment.index')==0){
                $this->Flash->error(__("You don't have permission to consult."));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));

            }else {
                $this->Auth->allow();
                $payments = $this->Cafyb->getPayments();
                $users = $this->Cafyb->getUsers();
                $profiles = $this->Cafyb->getUserProfiles();
                $comptes = $this->Cafyb->getComptes();
                $suppliers = $this->Cafyb->getSuppliers();
                $clients = $this->Cafyb->getCustomers();
                $sumCredits = $this->Cafyb->getSumCredit();
                $sumDebits = $this->Cafyb->getSumDebit();

                $separatorAmount = $this->getSeparatorAmount();
                $this->set(compact(  'payments',
                    'separatorAmount', 'users', 'profiles', 'comptes',
                    'sumCredits', 'sumDebits', 'suppliers', 'clients'));


            }
        }else {
            $userId = $this->Auth->user('id');
            $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
            $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1']) : $this->getOrder();
            $result = $this->verifyUserPermission(SectionsEnum::journal_tresorerie, $userId, ActionsEnum::view, "Payments"
                , null, "Payment", null);
            switch ($result) {
                case 1 :
                    $conditions = null;
                    break;
                case 2 :
                    $conditions = array('Payment.user_id ' => $userId);
                    break;
                case 3 :
                    $conditions = array('Payment.user_id !=' => $userId);
                    break;
                default:
                    $conditions = null;
            }
            $this->paginate = array(
                'limit' => $limit,
                'order' => 'Payment.id desc',
                'recursive' => -1,
                'conditions' => $conditions,
                'paramType' => 'querystring',
                'fields' => array(
                    'Payment.id',
                    'Payment.wording',
                    'Payment.operation_date',
                    'Payment.receipt_date',
                    'Payment.value_date',
                    'Payment.deadline_date',
                    'Payment.transact_type_id',
                    'Payment.amount',
                    'Payment.payment_type',
                    'Payment.payment_etat',
                    'Payment.payment_category_id',
                    'PaymentCategory.name',
                    'Compte.num_compte',
                    'Payment.wording',
                    'Customer.first_name',
                    'Customer.last_name',
                    'Supplier.name',
                    'Interfering.name',
                    'PaymentAssociation.name',
                    'PaymentAssociation.id'
                ),
                'joins' => array(
                    array(
                        'table' => 'comptes',
                        'type' => 'left',
                        'alias' => 'Compte',
                        'conditions' => array('Compte.id = Payment.compte_id')
                    ),
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('Customer.id = Payment.customer_id')
                    ),
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('Car.id = Payment.car_id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('Supplier.id = Payment.supplier_id')
                    ),
                    array(
                        'table' => 'event',
                        'type' => 'left',
                        'alias' => 'Event',
                        'conditions' => array('Event.id = Payment.event_id')
                    ),
                    array(
                        'table' => 'interferings',
                        'type' => 'left',
                        'alias' => 'Interfering',
                        'conditions' => array('Interfering.id = Payment.interfering_id')
                    ),
                    array(
                        'table' => 'payment_associations',
                        'type' => 'left',
                        'alias' => 'PaymentAssociation',
                        'conditions' => array('PaymentAssociation.id = Payment.payment_association_id')
                    ),
                    array(
                        'table' => 'payment_categories',
                        'type' => 'left',
                        'alias' => 'PaymentCategory',
                        'conditions' => array('PaymentCategory.id = Payment.payment_category_id')
                    ),
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('User.id = Payment.user_id')
                    ),
                    array(
                        'table' => 'profiles',
                        'type' => 'left',
                        'alias' => 'Profile',
                        'conditions' => array('Profile.id = User.profile_id')
                    ),
                )
            );
            $payments = $this->Paginator->paginate('Payment');
            $separatorAmount = $this->getSeparatorAmount();
            $users = $this->User->find('list', array('conditions' => 'User.id != 1'));
            $profiles = $this->Profile->getUserProfiles();
            $comptes = $this->Payment->Compte->find('list');
            $fields = "names";
            $customers = $this->Customer->getCustomersByFieldsAndConds($fields);
            $interferings = $this->Interfering->getInterferingList();
            $suppliers = $this->Supplier->getSuppliersByParams(0, 1);
            $clients = $this->Supplier->getSuppliersByParams(1, 1);
            $sumCredits = $this->getSumCredit($conditions);
            $sumDebits = $this->getSumDebit($conditions);
            $isSuperAdmin = $this->isSuperAdmin();
            $totalArray = $this->Payment->getPaymentTotals($conditions);
            $paymentCategories = $this->PaymentCategory->getPaymentCategories('list');
            $this->set(compact('order','limit', 'type', 'payments',
                'separatorAmount', 'users', 'profiles', 'comptes', 'customers',
                'sumCredits', 'sumDebits', 'interferings', 'suppliers', 'clients',
                'isSuperAdmin','totalArray','paymentCategories'));


        }
           }

    public function indexMissionCostPayments()
    {
        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        $this->settimeactif();
        $user_id = $this->Auth->user('id');
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $result = $this->verifyUserPermission(SectionsEnum::journal_tresorerie, $user_id, ActionsEnum::view,
            "Payments", null, "Payment", null);
        switch ($result) {
            case 1 :


                $conditions = null;

                break;
            case 2 :

                $conditions = array('Payment.user_id ' => $user_id);

                break;
            case 3 :

                $conditions = array('Payment.user_id !=' => $user_id);

                break;
            default:
                $conditions = null;

        }
        $condition1 = array('Payment.payment_association_id ' => 3);
        if ($conditions != null) {

            $conditions = array_merge($conditions, $condition1);
        } else {
            $conditions = $condition1;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Payment.id' => 'DESC'),
            'recursive' => -1,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'fields' => array(
                'Payment.id',
                'Payment.wording',
                'Payment.operation_date',
                'Payment.receipt_date',
                'Payment.value_date',
                'Payment.amount',
                'Payment.payment_type',
                'Compte.num_compte',
                'Payment.wording',
                'Customer.first_name',
                'Customer.last_name'
            ),
            'joins' => array(
                array(
                    'table' => 'comptes',
                    'type' => 'left',
                    'alias' => 'Compte',
                    'conditions' => array('Compte.id = Payment.compte_id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Customer.id = Payment.customer_id')
                ),
            )
        );
        $payments = $this->Paginator->paginate('Payment');
        $separatorAmount = $this->getSeparatorAmount();
        $users = $this->User->find('list', array('conditions' => 'User.id != 1'));
        $profiles = $this->Profile->getUserProfiles();
        $comptes = $this->Payment->Compte->find('list');
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);

        //$sumPayments = $this->getSumPayments($conditions);
        $sumCredits = $this->getSumCredit($conditions);
        $sumDebits = $this->getSumDebit($conditions);
        $isSuperAdmin = $this->isSuperAdmin();
        $this->set(compact('limit', 'type', 'payments', 'separatorAmount', 'users', 'profiles', 'comptes', 'customers',
            'sumCredits', 'sumDebits', 'isSuperAdmin'));
    }

    public function search()
    {
        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        $this->settimeactif();
        if (isset($this->request->data['keyword']) || isset($this->request->data['Payments']['compte_id'])
            || isset($this->request->data['Payments']['customer_id']) || isset($this->request->data['Payments']['payment_type'])
            || isset($this->request->data['Payments']['transact_type_id'])|| isset($this->request->data['Payments']['payment_etat'])
            || isset($this->request->data['Payments']['payment_category_id'])
            || isset($this->request->data['Payments']['client_id']) || isset($this->request->data['Payments']['interfering_id'])
            || isset($this->request->data['Payments']['amount']) || isset($this->request->data['Payments']['supplier_id'])
            || isset($this->request->data['Payments']['user_id']) || isset($this->request->data['Payments']['modified_id'])
            || isset($this->request->data['Payments']['created']) || isset($this->request->data['Payments']['created1'])
            || isset($this->request->data['Payments']['modified']) || isset($this->request->data['Payments']['modified1'])
            || isset($this->request->data['Payments']['date1']) || isset($this->request->data['Payments']['date2'])
            || isset($this->request->data['Payments']['profile_id'])
        ) {
            $this->filterUrl();
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1']) : $this->getOrder();

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Payment.id' => 'DESC'),
            'paramType' => 'querystring'
        );


        if (isset($this->params['named']['keyword']) || isset($this->params['named']['compte'])
            || isset($this->params['named']['customer']) || isset($this->params['named']['payment_type'])
            || isset($this->params['named']['transact_type'])|| isset($this->params['named']['payment_etat'])
            || isset($this->params['named']['category'])
            || isset($this->params['named']['supplier']) || isset($this->params['named']['client'])
            || isset($this->params['named']['amount']) || isset($this->params['named']['interfering'])
            || isset($this->params['named']['user']) || isset($this->params['named']['modified_id'])
            || isset($this->params['named']['created']) || isset($this->params['named']['created1'])
            || isset($this->params['named']['modified']) || isset($this->params['named']['modified1'])
            || isset($this->params['named']['profile'])
            || isset($this->params['named']['date1']) || isset($this->params['named']['date2'])
        ) {

            $conditions = $this->getConds();

            /*  $condition1 = array('Payment.payment_association_id ' => 3);
              if ($conditions != null) {
                  $conditions = array_merge($conditions, $condition1);

              } else $conditions = $condition1;
            */

            $this->paginate = array(
                'limit' => $limit,
                'order' => $order,
                'recursive' => -1,
                'conditions' => $conditions,
                'paramType' => 'querystring',
                'fields' => array(
                    'Payment.id',
                    'Payment.wording',
                    'Payment.operation_date',
                    'Payment.receipt_date',
                    'Payment.value_date',
                    'Payment.deadline_date',
                    'Payment.transact_type_id',
                    'Payment.amount',
                    'Payment.payment_type',
                    'Payment.payment_etat',
                    'Payment.payment_category_id',
                    'PaymentCategory.name',
                    'Compte.num_compte',
                    'Payment.wording',
                    'Customer.first_name',
                    'Customer.last_name',
                    'Supplier.name',
                    'Interfering.name',
                    'PaymentAssociation.name',
                    'PaymentAssociation.id'
                ),
                'joins' => array(
                    array(
                        'table' => 'comptes',
                        'type' => 'left',
                        'alias' => 'Compte',
                        'conditions' => array('Compte.id = Payment.compte_id')
                    ),
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('Customer.id = Payment.customer_id')
                    ),
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('Car.id = Payment.car_id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('Supplier.id = Payment.supplier_id')
                    ),
                    array(
                        'table' => 'event',
                        'type' => 'left',
                        'alias' => 'Event',
                        'conditions' => array('Event.id = Payment.event_id')
                    ),
                    array(
                        'table' => 'interferings',
                        'type' => 'left',
                        'alias' => 'Interfering',
                        'conditions' => array('Interfering.id = Payment.interfering_id')
                    ),
                    array(
                        'table' => 'payment_associations',
                        'type' => 'left',
                        'alias' => 'PaymentAssociation',
                        'conditions' => array('PaymentAssociation.id = Payment.payment_association_id')
                    ),
                    array(
                        'table' => 'payment_categories',
                        'type' => 'left',
                        'alias' => 'PaymentCategory',
                        'conditions' => array('PaymentCategory.id = Payment.payment_category_id')
                    ),
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('User.id = Payment.user_id')
                    ),
                    array(
                        'table' => 'profiles',
                        'type' => 'left',
                        'alias' => 'Profile',
                        'conditions' => array('Profile.id = User.profile_id')
                    ),
                )
            );
            $payments = $this->Paginator->paginate('Payment');
            $totalArray = $this->Payment->getPaymentTotals($conditions);
            $this->set(compact('totalArray'));
            $this->set('payments', $payments);

        } else {

            // $conditions = array('Payment.payment_association_id ' => 3);

            $this->paginate = array(
                'limit' => $limit,
                'order' => $order,
                'recursive' => -1,
                //'conditions' => $conditions,
                'paramType' => 'querystring',
                'fields' => array(
                    'Payment.id',
                    'Payment.wording',
                    'Payment.operation_date',
                    'Payment.receipt_date',
                    'Payment.value_date',
                    'Payment.amount',
                    'Payment.payment_type',
                    'Payment.payment_etat',
                    'Payment.payment_category_id',
                    'PaymentCategory.name',
                    'Compte.num_compte',
                    'Payment.wording',
                    'Customer.first_name',
                    'Customer.last_name',
                    'Supplier.name',
                    'Interfering.name',
                    'PaymentAssociation.name',
                    'PaymentAssociation.id'
                ),
                'joins' => array(
                    array(
                        'table' => 'comptes',
                        'type' => 'left',
                        'alias' => 'Compte',
                        'conditions' => array('Compte.id = Payment.compte_id')
                    ),
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('Customer.id = Payment.customer_id')
                    ),
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('Car.id = Payment.car_id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('Supplier.id = Payment.supplier_id')
                    ),
                    array(
                        'table' => 'event',
                        'type' => 'left',
                        'alias' => 'Event',
                        'conditions' => array('Event.id = Payment.event_id')
                    ),
                    array(
                        'table' => 'interferings',
                        'type' => 'left',
                        'alias' => 'Interfering',
                        'conditions' => array('Interfering.id = Payment.interfering_id')
                    ),
                    array(
                        'table' => 'payment_associations',
                        'type' => 'left',
                        'alias' => 'PaymentAssociation',
                        'conditions' => array('PaymentAssociation.id = Payment.payment_association_id')
                    ),

                    array(
                        'table' => 'payment_categories',
                        'type' => 'left',
                        'alias' => 'PaymentCategory',
                        'conditions' => array('PaymentCategory.id = Payment.payment_category_id')
                    ),
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('User.id = Payment.user_id')
                    ),
                    array(
                        'table' => 'profiles',
                        'type' => 'left',
                        'alias' => 'Profile',
                        'conditions' => array('Profile.id = User.profile_id')
                    ),
                )
            );
            $payments = $this->Paginator->paginate('Payment');

            $this->set('payments', $payments);
            $totalArray = $this->Payment->getPaymentTotals();
            $this->set('totalArray',$totalArray);
        }

        $separatorAmount = $this->getSeparatorAmount();
        $users = $this->User->find('list', array('conditions' => 'User.id != 1'));
        $profiles = $this->Profile->getUserProfiles();
        $comptes = $this->Payment->Compte->find('list');

        $interferings = $this->Interfering->getInterferingList();
        $suppliers = $this->Supplier->getSuppliersByParams(0, 1);
        $clients = $this->Supplier->getSuppliersByParams(1, 1);
        $isSuperAdmin = $this->isSuperAdmin();
        $paymentCategories = $this->PaymentCategory->getPaymentCategories('list');
        $this->set(compact('order','limit', 'type', 'payments', 'separatorAmount', 'users', 'profiles', 'comptes', 'customers',
            'sumCredits', 'sumDebits', 'interferings', 'suppliers', 'clients', 'isSuperAdmin','paymentCategories'));

        $this->render();
    }

    private function filterUrl()
    {
        $filter_url['controller'] = $this->request->params['controller'];
        $filter_url['action'] = $this->request->params['action'];
        $filter_url['page'] = 1;
        $filter_url['keyword'] = $this->request->data['keyword'];
        $filter_url['keyword'] = str_replace('/', '-', $filter_url['keyword']);
        if (isset($this->request->data['Payments']['customer_id']) && !empty($this->request->data['Payments']['customer_id'])) {
            $filter_url['customer'] = $this->request->data['Payments']['customer_id'];
        }
        if (isset($this->request->data['Payments']['supplier_id']) && !empty($this->request->data['Payments']['supplier_id'])) {
            $filter_url['supplier'] = $this->request->data['Payments']['supplier_id'];
        }
        if (isset($this->request->data['Payments']['client_id']) && !empty($this->request->data['Payments']['client_id'])) {
            $filter_url['client'] = $this->request->data['Payments']['client_id'];
        }
        if (isset($this->request->data['Payments']['interfering_id']) && !empty($this->request->data['Payments']['interfering_id'])) {
            $filter_url['interfering'] = $this->request->data['Payments']['interfering_id'];
        }
        if (isset($this->request->data['Payments']['compte_id']) && !empty($this->request->data['Payments']['compte_id'])) {
            $filter_url['compte'] = $this->request->data['Payments']['compte_id'];
        }
        if (isset($this->request->data['Payments']['payment_type']) && !empty($this->request->data['Payments']['payment_type'])) {
            $filter_url['payment_type'] = $this->request->data['Payments']['payment_type'];
        }
        if (isset($this->request->data['Payments']['payment_etat']) && !empty($this->request->data['Payments']['payment_etat'])) {
            $filter_url['payment_etat'] = $this->request->data['Payments']['payment_etat'];
        }
        if (isset($this->request->data['Payments']['payment_category_id']) && !empty($this->request->data['Payments']['payment_category_id'])) {
            $filter_url['category'] = $this->request->data['Payments']['payment_category_id'];
        }
        if (isset($this->request->data['Payments']['transact_type_id']) && !empty($this->request->data['Payments']['transact_type_id'])) {
            $filter_url['transact_type'] = $this->request->data['Payments']['transact_type_id'];
        }
        if (isset($this->request->data['Payments']['amount']) && !empty($this->request->data['Payments']['amount'])) {
            $filter_url['amount'] = $this->request->data['Payments']['amount'];
        }
        if (isset($this->request->data['Payments']['user_id']) && !empty($this->request->data['Payments']['user_id'])) {
            $filter_url['user'] = $this->request->data['Payments']['user_id'];
        }
        if (isset($this->request->data['Payments']['profile_id']) && !empty($this->request->data['Payments']['profile_id'])) {
            $filter_url['profile'] = $this->request->data['Payments']['profile_id'];
        }
        if (isset($this->request->data['Payments']['created']) && !empty($this->request->data['Payments']['created'])) {
            $filter_url['created'] = str_replace("/", "-", $this->request->data['Payments']['created']);
        }
        if (isset($this->request->data['Payments']['created1']) && !empty($this->request->data['Payments']['created1'])) {
            $filter_url['created1'] = str_replace("/", "-", $this->request->data['Payments']['created1']);
        }
        if (isset($this->request->data['Payments']['modified_id']) && !empty($this->request->data['Payments']['modified_id'])) {
            $filter_url['modified_id'] = $this->request->data['Payments']['modified_id'];
        }
        if (isset($this->request->data['Payments']['modified']) && !empty($this->request->data['Payments']['modified'])) {
            $filter_url['modified'] = str_replace("/", "-", $this->request->data['Payments']['modified']);
        }
        if (isset($this->request->data['Payments']['modified1']) && !empty($this->request->data['Payments']['modified1'])) {
            $filter_url['modified1'] = str_replace("/", "-", $this->request->data['Payments']['modified1']);
        }
        if (isset($this->request->data['Payments']['date1']) && !empty($this->request->data['Payments']['date1'])) {
            $filter_url['date1'] = str_replace("/", "-", $this->request->data['Payments']['date1']);
        }
        if (isset($this->request->data['Payments']['date2']) && !empty($this->request->data['Payments']['date2'])) {
            $filter_url['date2'] = str_replace("/", "-", $this->request->data['Payments']['date2']);
        }

        return $this->redirect($filter_url);
    }

    private function getConds()
    {
        if (!empty($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $keyword = str_replace('-', '/', $keyword);
            $conds = array(
                'OR' => array(
                    "LOWER(Payment.wording) LIKE" => "%$keyword%",
                    "LOWER(Payment.number_payment) LIKE" => "%$keyword%",
                    "LOWER(Payment.amount) LIKE" => "%$keyword%",
                    "LOWER(Customer.first_name) LIKE" => "%$keyword%",
                    "LOWER(Supplier.name) LIKE" => "%$keyword%",
                    "LOWER(Interfering.name) LIKE" => "%$keyword%",
                    "LOWER(Customer.last_name) LIKE" => "%$keyword%",
                    "LOWER(Compte.num_compte) LIKE" => "%$keyword%"
                )
            );
        } else {
            $conds = array();
        }
        if (isset($this->params['named']['compte']) && !empty($this->params['named']['compte'])) {
            $conds["Compte.id = "] = $this->params['named']['compte'];
            $this->request->data['Payments']['compte_id'] = $this->params['named']['compte'];
        }
        if (isset($this->params['named']['customer']) && !empty($this->params['named']['customer'])) {
            $conds["Customer.id = "] = $this->params['named']['customer'];
            $this->request->data['Payments']['customer_id'] = $this->params['named']['customer'];
        }
        if (isset($this->params['named']['supplier']) && !empty($this->params['named']['supplier'])) {
            $conds["Supplier.id = "] = $this->params['named']['supplier'];
            $this->request->data['Payments']['supplier_id'] = $this->params['named']['supplier'];
        }
        if (isset($this->params['named']['client']) && !empty($this->params['named']['client'])) {
            $conds["Supplier.id = "] = $this->params['named']['client'];
            $this->request->data['Payments']['client_id'] = $this->params['named']['client'];
        }
        if (isset($this->params['named']['interfering']) && !empty($this->params['named']['interfering'])) {
            $conds["Interfering.id = "] = $this->params['named']['interfering'];
            $this->request->data['Payments']['interfering_id'] = $this->params['named']['interfering'];
        }
        if (isset($this->params['named']['payment_type']) && !empty($this->params['named']['payment_type'])) {
            $conds["Payment.payment_type = "] = $this->params['named']['payment_type'];
            $this->request->data['Payments']['payment_type'] = $this->params['named']['payment_type'];
        }
        if (isset($this->params['named']['payment_etat']) && !empty($this->params['named']['payment_etat'])) {
            $conds["Payment.payment_etat = "] = $this->params['named']['payment_etat'];
            $this->request->data['Payments']['payment_etat'] = $this->params['named']['payment_etat'];
        }

        if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
            if($this->params['named']['category'] == 1) {
                $paymentCategories = $this->PaymentCategory->getPaymentCategories('all');
                $categories = array('NULL');
                foreach ($paymentCategories as $paymentCategory) {
                    $categories[] = $paymentCategory['PaymentCategory']['id'];
                }
                $conds["Payment.payment_category_id is NULL || Payment.payment_category_id = "] =$categories;
            }else {
                if($this->params['named']['category'] == 2){
                    $conds["Payment.payment_category_id   "] = NULL;
                } else {
                    $conds["Payment.payment_category_id = "] = $this->params['named']['category'];
                }
            }

            $this->request->data['Payments']['payment_category_id'] = $this->params['named']['category'];
        }
        if (isset($this->params['named']['transact_type']) && !empty($this->params['named']['transact_type'])) {
            $conds["Payment.transact_type_id = "] = $this->params['named']['transact_type'];
            $conds["Payment.transact_type_id = "] = $this->params['named']['transact_type'];
            $this->request->data['Payments']['transact_type_id'] = $this->params['named']['transact_type'];
        }
        if (isset($this->params['named']['amount']) && !empty($this->params['named']['amount'])) {
            $conds["Payment.amount >= "] = $this->params['named']['amount'];
            $this->request->data['Payments']['amount'] = $this->params['named']['amount'];
        }

        if (isset($this->params['named']['date1']) && !empty($this->params['named']['date1'])) {
            $creat = str_replace("-", "/", $this->params['named']['date1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Payment.receipt_date >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Payments']['date1'] = $creat;
        }
        if (isset($this->params['named']['date2']) && !empty($this->params['named']['date2'])) {
            $creat = str_replace("-", "/", $this->params['named']['date2']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Payment.receipt_date <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Payments']['date2'] = $creat;
        }

        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $conds["Payment.user_id = "] = $this->params['named']['user'];
            $this->request->data['Payments']['user_id'] = $this->params['named']['user'];
        }

        if (isset($this->params['named']['profile']) && !empty($this->params['named']['profile'])) {
            $conds["User.profile_id = "] = $this->params['named']['profile'];
            $this->request->data['Payments']['profile_id'] = $this->params['named']['profile'];
        }
        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $creat = str_replace("-", "/", $this->params['named']['created']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Payment.created >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Payments']['created'] = $creat;
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $creat = str_replace("-", "/", $this->params['named']['created1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Payment.created <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Payments']['created1'] = $creat;
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $conds["Payment.modified_id = "] = $this->params['named']['modified_id'];
            $this->request->data['Payments']['modified_id'] = $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Payment.modified >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Payments']['modified'] = $creat;
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Payment.modified <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Payments']['modified1'] = $creat;
        }


        return $conds;

    }


    public function searchMissionCosts()
    {
        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }

        $this->setTimeActif();
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::frais_missions, $user_id, ActionsEnum::view, "Payments"
            , null, "Payment", null);
        switch ($result) {
            case 1 :
                $conditions = null;
                break;
            case 2 :
                $conditions = array('SheetRide.user_id ' => $user_id);

                break;
            case 3 :

                $conditions = array('SheetRide.user_id !=' => $user_id);

                break;
            default:
                $conditions = null;
        }

        if (
            isset($this->request->data['Payments']['customer_id']) ||
            isset($this->request->data['Payments']['car_id']) ||
            isset($this->request->data['Payments']['ride_id']) ||
            isset($this->request->data['Payments']['car_type_id']) ||
            isset($this->request->data['Payments']['supplier_id']) ||
            isset($this->request->data['Payments']['paid_id']) ||
            isset($this->request->data['Payments']['date_from']) ||
            isset($this->request->data['Payments']['date_to'])
        ) {
            $customer = $this->request->data['Payments']['customer_id'];
            $car = $this->request->data['Payments']['car_id'];
            $ride = $this->request->data['Payments']['ride_id'];
            $car_type = $this->request->data['Payments']['car_type_id'];
            $supplier = $this->request->data['Payments']['supplier_id'];
            $paid = $this->request->data['Payments']['paid_id'];

            $date_from = str_replace("/", "-", $this->request->data['Payments']['date_from']);
            $date_to = str_replace("/", "-", $this->request->data['Payments']['date_to']);
            $start = str_replace("-", "/", $date_from);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $end = str_replace("-", "/", $date_to);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);

            if (!empty($customer)) {
                $conditions["SheetRide.customer_id"] = $customer;
            }
            if (!empty($car)) {
                $conditions["SheetRide.car_id"] = $car;
            }
            if (!empty($ride)) {
                $conditions["SheetRideDetailRides.detail_ride_id"] = $ride;
            }
            if (!empty($car_type)) {
                $conditions["SheetRide.car_type_id"] = $car_type;
            }
            if (!empty($supplier)) {
                $conditions["SheetRideDetailRides.supplier_id"] = $supplier;
            }
            if (!empty($paid)) {
                if ($paid == 1) {
                    $conditions["SheetRideDetailRides.amount_remaining"] = 0;
                } else {
                    $conditions["SheetRideDetailRides.amount_remaining > "] = 0;
                }

            }
            if (!empty($date_from)) {
                $conditions["SheetRideDetailRides.real_start_date  >="] = $startdtm->format('Y-m-d 00:00:00');
            }
            if (!empty($date_to)) {
                $conditions["SheetRideDetailRides.real_end_date  <="] = $enddtm->format('Y-m-d 00:00:00');
            }
        }

        // $conditions['SheetRideDetailRides.amount_remaining > '] = 0;

        $this->paginate = array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'limit' => $limit,
            'order' => array('SheetRideDetailRides.real_start_date' => 'DESC'),
            'conditions' => $conditions,
            'fields' => array(
                'SheetRideDetailRides.reference',
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.detail_ride_id',
                'SheetRideDetailRides.planned_start_date',
                'SheetRideDetailRides.real_start_date',
                'SheetRideDetailRides.km_departure',
                'SheetRideDetailRides.planned_end_date',
                'SheetRideDetailRides.real_end_date',
                'SheetRideDetailRides.km_arrival',
                'SheetRideDetailRides.supplier_id',
                'SheetRideDetailRides.supplier_final_id',
                'SheetRideDetailRides.status_id',
                'SheetRideDetailRides.mission_cost',
                'SheetRideDetailRides.type_ride',
                'SheetRide.car_id',
                'SheetRide.customer_id',
                'CarType.name',
                'Supplier.name',
                'SupplierFinal.name',
                'Departure.name',
                'Arrival.name',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Car.code',
                'Customer.first_name',
                'Customer.last_name',
                'Car.immatr_def',
                'Carmodel.name',
                'SheetRideDetailRides.amount_remaining',


            ),
            'joins' => array(
                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('SheetRide.id = SheetRideDetailRides.sheet_ride_id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('SheetRide.car_id = Car.id')
                ),
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('SheetRide.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'rides',
                    'type' => 'left',
                    'alias' => 'Ride',
                    'conditions' => array('DetailRide.ride_id = Ride.id')
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
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Departure',
                    'conditions' => array('Departure.id = SheetRideDetailRides.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'Arrival',
                    'conditions' => array('Arrival.id = SheetRideDetailRides.arrival_destination_id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('SheetRide.customer_id = Customer.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('SheetRideDetailRides.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'SupplierFinal',
                    'conditions' => array('SheetRideDetailRides.supplier_final_id = SupplierFinal.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),


            )
        );


        $sheetRideDetailRides = $this->Paginator->paginate('SheetRideDetailRides');

        //var_dump($sheetRideDetailRides); die();
        $this->set('sheetRideDetailRides', $sheetRideDetailRides);
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        $permissionPayment = $this->AccessPermission->getPermissionWithParams(SectionsEnum::paiement,
            ActionsEnum::view, $profileId, $roleId);
        $this->set('permissionPayment', $permissionPayment);

        $sumMissionCost = $this->getSumMissionCost($conditions);
        $sumAmountRemaining = $this->getSumAmountRemaining($conditions);
//Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set(compact('limit', 'param', 'sumMissionCost', 'sumAmountRemaining'));
        $users = $this->SheetRide->User->find('list', array('conditions' => 'User.id != 1'));
        $profiles = $this->Profile->getUserProfiles();


        $carTypes = $this->CarType->getCarTypes();
        //Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');

        if ($param == 1) {
            $this->SheetRide->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name )"
            );

        } elseif ($param == 2) {

            $this->SheetRide->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(Car.immatr_def,Car.immatr_prov), ' - ', Carmodel.name)"
            );
        }
        $cars = $this->SheetRideDetailRides->SheetRide->Car->find('list', array(
            'fields' => 'cnames',
            'recursive' => -1,
            'order' => 'Car.code ASC',
            'joins' => array(
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
                    'table' => 'customer_car',
                    'type' => 'left',
                    'alias' => 'CustomerCar',
                    'conditions' => array('Car.id = CustomerCar.car_id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('CustomerCar.customer_id = Customer.id')
                )
            )
        ));

        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);

        $separatorAmount = $this->getSeparatorAmount();
        $client_i2b = $this->isCustomerI2B();
        $this->set(compact('profiles', 'users', 'cars', 'customers',
            'carTypes', 'separatorAmount', 'client_i2b'));
    }
    /** modified : 26/03/2019*/
    /**
     * @param $id
     * @param $paymentAssociationId
     * @param null $controller
     * @param null $type
     * @param null $url
     * @param null $page
     * @return \Cake\Network\Response|null
     * @throws Exception
     */


    public function editPayment($id, $paymentAssociationId, $controller = null, $type =null, $url = null, $page=null)
    {
        if(!empty($url)){
            $url = unserialize(base64_decode($url));
            $url =  explode($controller, $url);
            $url = '/'.$controller.$url[1].'?page='.$page;
        } else {
            $url =  array('controller' => 'payments', 'action' => 'index');
        }

        if (Configure::read("cafyb") == '1') {
            if($this->Session->read('Permission.compte.edit')==0){
                $this->Flash->error(__("You don't have permission to edit."));
                return $this->redirect(array('controller' => 'comptes', 'action' => 'index'));

            }else {
                $this->Auth->allow();
                $this->layout = 'popup';
                if (!empty($this->request->data)) {
                    $payment = $this->request->data['Payment'];
                    $this->Cafyb->editPayment($payment);

                }else {
                    $payment = $this->Cafyb->getPaymentById($id);
                    $comptes = $this->Cafyb->getComptes();
                    $suppliers = $this->Cafyb->getTiers();
                    $this->set(compact('comptes','payment','suppliers'));
                }

            }
        }else {
            $this->set('saved',false);
            $this->set(compact('paymentAssociationId','type'));
            $tresorerie = $this->hasModuleTresorerie();
            if($tresorerie==0){
                return $this->redirect('/');
            }
            $userId = $this->Auth->user('id');
            $this->verifyUserPermission(SectionsEnum::journal_tresorerie, $userId, ActionsEnum::edit, "Payments",
                $id, "Payment", null);
            $this->layout = 'popup';
            if (!empty($this->request->data)) {
                switch ($paymentAssociationId) {
                    case PaymentAssociationsEnum::car:
                        break;
                    case PaymentAssociationsEnum::event:
                        break;
                    case PaymentAssociationsEnum::mission_order:
                        $balanceConductor = $this->DetailPayment->getBalance($id);
                        $payment = $this->Payment->getPaymentWithCustomerById($id);
                        $precedentCompteId = $payment['Payment']['compte_id'];
                        $precedentAmount = $payment['Payment']['amount'];
                        $compteId = $this->request->data['Payment']['compte_id'];
                        $amount = $this->request->data['Payment']['amount'];
                        $customerId = $payment['Customer']['id'];
                        $this->createDateFromDate('Payment', 'operation_date');
                        $this->createDateFromDate('Payment', 'receipt_date');
                        $this->createDateFromDate('Payment', 'value_date');
                        $this->request->data['Payment']['payment_association_id'] = $paymentAssociationId;
                        $this->request->data['Payment']['customer_id'] = $customerId;
                        if ($this->Payment->save($this->request->data)) {
                            if($precedentAmount != $amount){
                                $this->DetailPayment->deleteAll(array('DetailPayment.payment_id' => $id), false);
                                $this->updateAssociationPayment($id);
                                $sheetRideDetailRideIds = $this->getSheetRideDetailRideIds($id);
                                $this->updateAmountRemainingMissions($sheetRideDetailRideIds);
                                $this->Compte->updateCompteDebit($compteId, $amount, $precedentCompteId, $precedentAmount);
                                $this->Customer->updateBalanceConductor($customerId, $amount, $balanceConductor);
                            }
                            $this->Flash->success(__('The payment has been saved.'));
                            $this->redirect($url);
                        }
                        break;



                    case PaymentAssociationsEnum::invoice:
                        $payment = $this->Payment->getPaymentWithSupplierById($id);
                        $precedentCompteId = $payment['Payment']['compte_id'];
                        $precedentAmount = $payment['Payment']['amount'];
                        $compteId = $this->request->data['Payment']['compte_id'];
                        $amount = $this->request->data['Payment']['amount'];
                        $clientId = $payment['Supplier']['id'];
                        $this->createDateFromDate('Payment', 'operation_date');
                        $this->createDateFromDate('Payment', 'receipt_date');
                        $this->createDateFromDate('Payment', 'value_date');
                        if ($type == 4) {
                            $this->request->data['Payment']['payment_association_id'] = PaymentAssociationsEnum::preinvoice;
                        } else {
                            $this->request->data['Payment']['payment_association_id'] = $paymentAssociationId;
                        }
                        $this->request->data['Payment']['supplier_id'] = $clientId;

                        if ($this->Payment->save($this->request->data)) {
                            $invoiceIds = $this->getInvoiceIds($id);
                            if($precedentAmount != $amount){
                                $this->DetailPayment->deleteAll(array('DetailPayment.payment_id' => $id), false);
                                $this->updateAssociationPayment($id);
                                $this->updateAmountRemainingInvoices($invoiceIds);
                                $this->Compte->updateCompteCredit($compteId, $amount, $precedentCompteId, $precedentAmount);
                                $balanceClient = $this->DetailPayment->getBalance($id);
                                $this->Supplier->updateBalanceClient($clientId, $amount, $balanceClient);
                            }
                            /* si on est dans le controller payment on fait un submit et on rafrichit la page
                            */
                            if ($controller == 'payments') {
                                $this->Flash->success(__('The payment has been saved.'));
                                $this->redirect($url);
                            } else {
                                /*
                                si on est dans le controller transportBill on enregiste
                                et on rafrichit par load de javascript
                                */

                                //$this->set('saved', true); //only set true if data saves OK
                                /*dans ce cas $invoiceIds comporte une seul valeur */




                                //$this->set('transportBillId', $transportBillId);
                            }
                        }
                        break;
                    case PaymentAssociationsEnum::offshore:
                        $payment = $this->Payment->getPaymentWithSupplierById($id);
                        $precedentCompteId = $payment['Payment']['compte_id'];
                        $precedentAmount = $payment['Payment']['amount'];
                        $compteId = $this->request->data['Payment']['compte_id'];
                        $amount = $this->request->data['Payment']['amount'];
                        $supplierId = $payment['Supplier']['id'];
                        $this->createDateFromDate('Payment', 'operation_date');
                        $this->createDateFromDate('Payment', 'receipt_date');
                        $this->createDateFromDate('Payment', 'value_date');
                        $this->request->data['Payment']['payment_association_id'] = $paymentAssociationId;
                        $this->request->data['Payment']['supplier_id'] = $supplierId;
                        if ($this->Payment->save($this->request->data)) {
                            if($precedentAmount != $amount) {
                                $balanceSupplier = $this->DetailPayment->getBalance($id);
                                $reservationIds = $this->getReservationIds($id);
                                $this->DetailPayment->deleteAll(array('DetailPayment.payment_id' => $id), false);
                                $this->updateAssociationPayment($id);
                                $this->updateAmountRemainingReservations($reservationIds);
                                $this->Compte->updateCompteDebit($compteId, $amount, $precedentCompteId, $precedentAmount);
                                $this->Customer->updateBalanceConductor($supplierId, $amount, $balanceSupplier);
                            }
                            $this->Flash->success(__('The payment has been saved.'));
                            $this->redirect($url);
                        }
                        break;

                    case PaymentAssociationsEnum::preinvoice:
                        $payment = $this->Payment->getPaymentWithSupplierById($id);
                        $precedentCompteId = $payment['Payment']['compte_id'];
                        $precedentAmount = $payment['Payment']['amount'];
                        $compteId = $this->request->data['Payment']['compte_id'];
                        $amount = $this->request->data['Payment']['amount'];
                        $clientId = $payment['Supplier']['id'];
                        $this->createDateFromDate('Payment', 'operation_date');
                        $this->createDateFromDate('Payment', 'receipt_date');
                        $this->createDateFromDate('Payment', 'value_date');
                        $this->request->data['Payment']['payment_association_id'] = 6;
                        //$this->request->data['Payment']['transact_type_id'] == 1;
                        $this->request->data['Payment']['supplier_id'] = $clientId;
                        if ($this->Payment->save($this->request->data)) {
                            $invoiceIds = $this->getInvoiceIds($id);
                            if($precedentAmount != $amount){
                                $this->DetailPayment->deleteAll(array('DetailPayment.payment_id' => $id), false);
                                $this->updateAssociationPayment($id);
                                $this->updateAmountRemainingInvoices($invoiceIds);
                                $this->Compte->updateCompteCredit($compteId, $amount, $precedentCompteId, $precedentAmount);
                                $balanceClient = $this->DetailPayment->getBalance($id);
                                $this->Supplier->updateBalanceClient($clientId, $amount, $balanceClient);
                            }
                            $this->Flash->success(__('The payment has been saved.'));
                            $this->redirect($url);
                        }
                        break;
                    case PaymentAssociationsEnum::cashing:
                        $payment = $this->Payment->getPaymentWithSupplierById($id);
                        $precedentCompteId = $payment['Payment']['compte_id'];
                        $precedentAmount = $payment['Payment']['amount'];
                        $compteId = $this->request->data['Payment']['compte_id'];
                        $amount = $this->request->data['Payment']['amount'];
                        $this->createDateFromDate('Payment', 'operation_date');
                        $this->createDateFromDate('Payment', 'receipt_date');
                        $this->createDateFromDate('Payment', 'value_date');
                        $this->request->data['Payment']['payment_association_id'] = 7;
                        //$this->request->data['Payment']['transact_type_id'] == 1;
                        if ($this->Payment->save($this->request->data)) {
                            $this->DetailPayment->deleteAll(array('DetailPayment.payment_id' => $id), false);
                            $this->Compte->updateCompteCredit($compteId, $amount, $precedentCompteId, $precedentAmount);
                            $this->Flash->success(__('The payment has been saved.'));
                            $this->redirect($url);
                        }
                        break;
                    case PaymentAssociationsEnum::disbursement:
                        $payment = $this->Payment->getPaymentWithSupplierById($id);
                        $precedentCompteId = $payment['Payment']['compte_id'];
                        $precedentAmount = $payment['Payment']['amount'];
                        $compteId = $this->request->data['Payment']['compte_id'];
                        $amount = $this->request->data['Payment']['amount'];
                        $this->createDateFromDate('Payment', 'operation_date');
                        $this->createDateFromDate('Payment', 'receipt_date');
                        $this->createDateFromDate('Payment', 'value_date');
                        $this->request->data['Payment']['payment_association_id'] = 7;
                        //$this->request->data['Payment']['transact_type_id'] == 2;
                        if ($this->Payment->save($this->request->data)) {
                            $this->Compte->updateCompteDebit($compteId, $amount, $precedentCompteId, $precedentAmount);
                            $this->Flash->success(__('The payment has been saved.'));
                            $this->redirect($url);
                        }
                        break;
                    case PaymentAssociationsEnum::bill:
                        $payment = $this->Payment->getPaymentWithSupplierById($id);
                        $precedentCompteId = $payment['Payment']['compte_id'];
                        $precedentAmount = $payment['Payment']['amount'];
                        $compteId = $this->request->data['Payment']['compte_id'];
                        $amount = $this->request->data['Payment']['amount'];
                        $clientId = $payment['Supplier']['id'];
                        $this->createDateFromDate('Payment', 'operation_date');
                        $this->createDateFromDate('Payment', 'receipt_date');
                        $this->createDateFromDate('Payment', 'value_date');
                        $this->request->data['Payment']['payment_association_id'] = $paymentAssociationId;
                        $this->request->data['Payment']['supplier_id'] = $clientId;
                        if ($this->Payment->save($this->request->data)) {
                            $billIds = $this->getBillIds($id);
                            $typeBill = $this->Bill->getTypeBill($billIds[0]);
                            if($precedentAmount != $amount){
                                $this->DetailPayment->deleteAll(array('DetailPayment.payment_id' => $id), false);
                                $this->updateAssociationPayment($id);
                                switch ($typeBill){
                                    case BillTypesEnum::receipt :
                                    case BillTypesEnum::return_customer :
                                    case BillTypesEnum::entry_order :
                                    case BillTypesEnum::reintegration_order :
                                    case BillTypesEnum::sale_credit_note :
                                    case BillTypesEnum::purchase_invoice :
                                        $this->updateAmountRemainingBills($billIds);
                                        $this->Compte->updateCompteDebit($compteId, $amount, $precedentCompteId, $precedentAmount);
                                        $balanceSupplier = $this->DetailPayment->getBalance($id);
                                        $this->Supplier->updateBalanceSupplier($clientId, $amount, $balanceSupplier);
                                        break;
                                    case BillTypesEnum::delivery_order :
                                    case BillTypesEnum::return_supplier :
                                    case BillTypesEnum::exit_order :
                                    case BillTypesEnum::renvoi_order :
                                    case BillTypesEnum::sales_invoice :
                                        $this->updateAmountRemainingBills($billIds);
                                        $this->Compte->updateCompteCredit($compteId, $amount, $precedentCompteId, $precedentAmount);
                                        $balanceClient = $this->DetailPayment->getBalance($id);
                                        $this->Supplier->updateBalanceClient($clientId, $amount, $balanceClient);
                                        break;
                                }
                            }
                            /* si on est dans le controller payment on fait un submit et on rafrichit la page
                            */
                            if ($controller == 'payments') {
                                $this->Flash->success(__('The payment has been saved.'));
                                $this->redirect($url);
                            }
                        }
                        break;

                    case PaymentAssociationsEnum::consumption_species:
                        $balanceConductor = $this->DetailPayment->getBalance($id);
                        $payment = $this->Payment->getPaymentWithCustomerById($id);
                        $precedentCompteId = $payment['Payment']['compte_id'];
                        $precedentAmount = $payment['Payment']['amount'];
                        $compteId = $this->request->data['Payment']['compte_id'];
                        $amount = $this->request->data['Payment']['amount'];
                        $customerId = $payment['Customer']['id'];
                        $this->createDateFromDate('Payment', 'operation_date');
                        $this->createDateFromDate('Payment', 'receipt_date');
                        $this->createDateFromDate('Payment', 'value_date');
                        $this->request->data['Payment']['payment_association_id'] = $paymentAssociationId;
                        $this->request->data['Payment']['customer_id'] = $customerId;
                        if ($this->Payment->save($this->request->data)) {
                            if($precedentAmount != $amount){
                                $this->DetailPayment->deleteAll(array('DetailPayment.payment_id' => $id), false);
                                $this->updateAssociationPayment($id);
                                $this->Compte->updateCompteDebit($compteId, $amount, $precedentCompteId, $precedentAmount);
                                $this->Customer->updateBalanceConductor($customerId, $amount, $balanceConductor);
                            }
                            $this->Flash->success(__('The payment has been saved.'));
                            $this->redirect($url);
                        }
                        break;

                    case PaymentAssociationsEnum::fuel_log:
                        $payment = $this->Payment->getPaymentById($id);
                        $precedentCompteId = $payment['Payment']['compte_id'];
                        $precedentAmount = $payment['Payment']['amount'];
                        $compteId = $this->request->data['Payment']['compte_id'];
                        $amount = $this->request->data['Payment']['amount'];

                        $this->createDateFromDate('Payment', 'operation_date');
                        $this->createDateFromDate('Payment', 'receipt_date');
                        $this->createDateFromDate('Payment', 'value_date');
                        $this->request->data['Payment']['payment_association_id'] = $paymentAssociationId;
                        if ($this->Payment->save($this->request->data)) {
                            if($precedentAmount != $amount){
                                $this->DetailPayment->deleteAll(array('DetailPayment.payment_id' => $id), false);
                                $this->updateAssociationPayment($id);
                                $fuelLogIds = $this->getFuelLogIds($id);
                                $this->updateAmountRemainingFuelLogs($fuelLogIds);
                                $this->Compte->updateCompteDebit($compteId, $amount, $precedentCompteId, $precedentAmount);

                            }
                            $this->Flash->success(__('The payment has been saved.'));
                            $this->redirect($url);
                        }
                        break;




                }
            }

            $this->request->data = $this->Payment->find('first', array(
                'conditions' => array('Payment.id' => $id),
                'recursive' => -1,
                'fields' => array(
                    'Payment.id',
                    'Payment.wording',
                    'Payment.operation_date',
                    'Payment.receipt_date',
                    'Payment.value_date',
                    'Payment.payment_type',
                    'Payment.transact_type_id',
                    'Payment.amount',
                    'Payment.payment_etat',
                    'Compte.num_compte',
                    'Payment.compte_id',
                    'Payment.supplier_id'
                ),
                'joins' => array(
                    array(
                        'table' => 'comptes',
                        'type' => 'left',
                        'alias' => 'Compte',
                        'conditions' => array('Payment.compte_id = Compte.id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('Payment.supplier_id = Supplier.id')
                    )
                )
            ));
            $suppliers = $this->Supplier->getActiveSuppliers();

            $comptes = $this->Payment->Compte->find('list', array('order' => 'num_compte'));


            $paymentCategories = $this->PaymentCategory->getPaymentCategories('list');
            $this->set(compact('comptes', 'paymentAssociationId', 'suppliers',
                'controller','paymentCategories'));
        }



    }


    public function editPaymentFromTransportBill($id, $paymentAssociationId){
        $this->autoRender = false;
        $this->request->data['Payment']['receipt_date'] = filter_input(INPUT_POST, "receipt_date");
        $this->request->data['Payment']['operation_date'] = filter_input(INPUT_POST, "operation_date");
        $this->request->data['Payment']['value_date'] = filter_input(INPUT_POST, "value_date");
        $this->request->data['Payment']['payment_type'] = filter_input(INPUT_POST, "payment_type");
        $this->request->data['Payment']['number_payment'] = filter_input(INPUT_POST, "number_payment");
        $this->request->data['Payment']['amount'] = filter_input(INPUT_POST, "amount");
        $this->request->data['Payment']['compte_id'] = filter_input(INPUT_POST, "compte_id");
        $this->request->data['Payment']['note'] = filter_input(INPUT_POST, "note");

        switch ($paymentAssociationId) {
            case PaymentAssociationsEnum::invoice:
                $payment = $this->Payment->getPaymentWithSupplierById($id);
                $precedentCompteId = $payment['Payment']['compte_id'];
                $precedentAmount = $payment['Payment']['amount'];
                $compteId = $this->request->data['Payment']['compte_id'];
                $amount = $this->request->data['Payment']['amount'];
                $clientId = $payment['Supplier']['id'];
                $this->createDateFromDate('Payment', 'operation_date');
                $this->createDateFromDate('Payment', 'receipt_date');
                $this->createDateFromDate('Payment', 'value_date');

                $this->request->data['Payment']['payment_association_id'] = $paymentAssociationId;
                $this->request->data['Payment']['supplier_id'] = $clientId;
                $this->request->data['Payment']['id'] = $id;

                if ($this->Payment->save($this->request->data)) {
                    $invoiceIds = $this->getInvoiceIds($id);
                    if($precedentAmount != $amount){
                        $this->DetailPayment->deleteAll(array('DetailPayment.payment_id' => $id), false);
                        $this->updateAssociationPayment($id);
                        $this->updateAmountRemainingInvoices($invoiceIds);
                        $this->Compte->updateCompteCredit($compteId, $amount, $precedentCompteId, $precedentAmount);
                        $balanceClient = $this->DetailPayment->getBalance($id);
                        $this->Supplier->updateBalanceClient($clientId, $amount, $balanceClient);
                    }

                    $transportBillId = $invoiceIds[0];

                    echo json_encode(array("response" => true, 'transportBillId' => $transportBillId));
                }else {
                    echo json_encode(array("response" => false));
                }
                break;



            case PaymentAssociationsEnum::preinvoice:
                $payment = $this->Payment->getPaymentWithSupplierById($id);
                $precedentCompteId = $payment['Payment']['compte_id'];
                $precedentAmount = $payment['Payment']['amount'];
                $compteId = $this->request->data['Payment']['compte_id'];
                $amount = $this->request->data['Payment']['amount'];
                $clientId = $payment['Supplier']['id'];
                $this->createDateFromDate('Payment', 'operation_date');
                $this->createDateFromDate('Payment', 'receipt_date');
                $this->createDateFromDate('Payment', 'value_date');
                $this->request->data['Payment']['payment_association_id'] = $paymentAssociationId;
                $this->request->data['Payment']['transact_type_id'] == 1;
                $this->request->data['Payment']['supplier_id'] = $clientId;
                if ($this->Payment->save($this->request->data)) {
                    $invoiceIds = $this->getInvoiceIds($id);
                    if($precedentAmount != $amount){
                        $this->DetailPayment->deleteAll(array('DetailPayment.payment_id' => $id), false);
                        $this->updateAssociationPayment($id);
                        $this->updateAmountRemainingInvoices($invoiceIds);
                        $this->Compte->updateCompteCredit($compteId, $amount, $precedentCompteId, $precedentAmount);
                        $balanceClient = $this->DetailPayment->getBalance($id);
                        $this->Supplier->updateBalanceClient($clientId, $amount, $balanceClient);
                    }

                    $transportBillId = $invoiceIds[0];

                    echo json_encode(array("response" => true, 'transportBillId' => $transportBillId));
                }else {
                    echo json_encode(array("response" => false));
                }
                break;
        }

    }

    /** cette fonction permet de retourné tous les reglement
     * associé à la piece avec le id transportBillId , et le surplus des paiement
     * action with view
     **/
    /**
     * @param null $transportBillId
     * @return \Cake\Network\Response|null
     */
    public function getRegulations($transportBillId = null)
    {
        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        $this->layout = 'ajax';
        $transportBill = $this->TransportBill->getTransportBillById($transportBillId);
        $supplierId = $transportBill['TransportBill']['supplier_id'];
        $advancedPayments = $this->Payment->getAdvancedPaymentsBySupplierId($supplierId);
        $remainingPayments = $this->Payment->getPaymentsWithOverAmountBySupplierId($supplierId);
        $paymentParts = $this->Payment->getPaymentPartsByTransportBillIds($transportBillId);
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('advancedPayments', 'remainingPayments', 'separatorAmount', 'paymentParts',
            'transportBillId'));
    }





    /**
     * @param null $conditions return sum  mission cost of mission
     * @return mixed
     */
    public function getSumMissionCost($conditions = null)
    {
        $sheetRideDetailRides = $this->SheetRideDetailRides->find('all',
            array(
                'recursive' => -1, // should be used with joins
                'conditions' => $conditions,
                'fields' => array(

                    'sum(SheetRideDetailRides.mission_cost) AS total',

                ),
                'joins' => array(

                    array(
                        'table' => 'sheet_rides',
                        'type' => 'left',
                        'alias' => 'SheetRide',
                        'conditions' => array('SheetRide.id = SheetRideDetailRides.sheet_ride_id')
                    ),
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('SheetRide.car_id = Car.id')
                    ),
                    array(
                        'table' => 'detail_rides',
                        'type' => 'left',
                        'alias' => 'DetailRide',
                        'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'CarType',
                        'conditions' => array('DetailRide.car_type_id = CarType.id')
                    ),
                    array(
                        'table' => 'rides',
                        'type' => 'left',
                        'alias' => 'Ride',
                        'conditions' => array('DetailRide.ride_id = Ride.id')
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
                    ),
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('SheetRide.customer_id = Customer.id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('SheetRideDetailRides.supplier_id = Supplier.id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'SupplierFinal',
                        'conditions' => array('SheetRideDetailRides.supplier_final_id = SupplierFinal.id')
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
                        'conditions' => array('SheetRide.user_id = User.id')
                    ),


                )

            )
        );

        $sumMissionCost = $sheetRideDetailRides[0][0]['total'];
        return $sumMissionCost;

    }

    /**
     * @param null $conditions
     * @return mixed return le reste à payé des missions
     */
    public function getSumAmountRemaining($conditions = null)
    {
        $sheetRideDetailRides = $this->SheetRideDetailRides->find('all',
            array(
                'recursive' => -1, // should be used with joins
                'conditions' => $conditions,
                'fields' => array(
                    'sum(SheetRideDetailRides.amount_remaining) AS total',
                ),
                'joins' => array(

                    array(
                        'table' => 'sheet_rides',
                        'type' => 'left',
                        'alias' => 'SheetRide',
                        'conditions' => array('SheetRide.id = SheetRideDetailRides.sheet_ride_id')
                    ),
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('SheetRide.car_id = Car.id')
                    ),
                    array(
                        'table' => 'detail_rides',
                        'type' => 'left',
                        'alias' => 'DetailRide',
                        'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'CarType',
                        'conditions' => array('DetailRide.car_type_id = CarType.id')
                    ),
                    array(
                        'table' => 'rides',
                        'type' => 'left',
                        'alias' => 'Ride',
                        'conditions' => array('DetailRide.ride_id = Ride.id')
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
                    ),
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('SheetRide.customer_id = Customer.id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('SheetRideDetailRides.supplier_id = Supplier.id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'SupplierFinal',
                        'conditions' => array('SheetRideDetailRides.supplier_final_id = SupplierFinal.id')
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
                        'conditions' => array('SheetRide.user_id = User.id')
                    ),

                )

            )
        );

        $sumAmountRemaining = $sheetRideDetailRides[0][0]['total'];
        return $sumAmountRemaining;

    }


    public function verifyAmountRemaining($paymentAssociationId = null)
    {
        $this->autoRender = false;

        $ids = filter_input(INPUT_POST, "ids");

        $array_ids = explode(",", $ids);

        switch ($paymentAssociationId) {
            case PaymentAssociationsEnum::car :

                break;
            case  PaymentAssociationsEnum::event:

                break;
            case PaymentAssociationsEnum::mission_order :
                $missions = $this->SheetRideDetailRides->find('all', array(
                    'conditions' => array(
                        'SheetRideDetailRides.id' => $array_ids,
                        'SheetRideDetailRides.amount_remaining >' => 0
                    ),
                    'recursive' => -1,
                    'fields' => array(
                        'SheetRide.customer_id',
                        'SheetRideDetailRides.amount_remaining',
                        'SheetRideDetailRides.id'
                    ),
                    'order' => array('SheetRideDetailRides.real_start_date' => 'ASC'),
                    'joins' => array(
                        array(
                            'table' => 'sheet_rides',
                            'type' => 'left',
                            'alias' => 'SheetRide',
                            'conditions' => array('SheetRide.id = SheetRideDetailRides.sheet_ride_id')
                        )
                    )
                ));

                if (!empty($missions)) {
                    echo json_encode(array("response" => true));

                } else {
                    echo json_encode(array("response" => false));

                }
                break;
            case PaymentAssociationsEnum::invoice :
                $invoices = $this->TransportBill->find('all', array(
                    'conditions' => array('TransportBill.id' => $array_ids, 'TransportBill.amount_remaining >' => 0),
                    'recursive' => -1,
                    'fields' => array(
                        'TransportBill.total_ttc',
                        'TransportBill.supplier_id',
                        'TransportBill.id',
                        'TransportBill.amount_remaining'
                    )
                ));
                if (!empty($invoices)) {
                    echo json_encode(array("response" => true));

                } else {
                    echo json_encode(array("response" => false));

                }

                break;

             case PaymentAssociationsEnum::credit_note :
                $creditNotes = $this->TransportBill->find('all', array(
                    'conditions' => array('TransportBill.id' => $array_ids, 'TransportBill.amount_remaining >' => 0),
                    'recursive' => -1,
                    'fields' => array(
                        'TransportBill.total_ttc',
                        'TransportBill.supplier_id',
                        'TransportBill.id',
                        'TransportBill.amount_remaining'
                    )
                ));
                if (!empty($creditNotes)) {
                    echo json_encode(array("response" => true));

                } else {
                    echo json_encode(array("response" => false));

                }

                break;


            case PaymentAssociationsEnum::offshore :
                $reservations = $this->Reservation->find('all', array(
                    'conditions' => array('Reservation.id' => $array_ids, 'Reservation.amount_remaining >' => 0),
                    'recursive' => -1,
                    'fields' => array(
                        'Reservation.cost',
                        'Reservation.id',
                        'Reservation.amount_remaining',
                        'Car.supplier_id'
                    ),
                    'joins' => array(
                        array(
                            'table' => 'car',
                            'type' => 'left',
                            'alias' => 'Car',
                            'conditions' => array('Car.id = Reservation.car_id')
                        )
                    )
                ));


                if (!empty($reservations)) {
                    echo json_encode(array("response" => true));

                } else {
                    echo json_encode(array("response" => false));

                }
                break;

            case PaymentAssociationsEnum::bill :
                $bills = $this->Bill->find('all', array(
                    'conditions' => array('Bill.id' => $array_ids, 'Bill.amount_remaining >' => 0),
                    'recursive' => -1,
                    'fields' => array(
                        'Bill.total_ttc',
                        'Bill.supplier_id',
                        'Bill.id',
                        'Bill.amount_remaining'
                    )
                ));
                if (!empty($bills)) {
                    echo json_encode(array("response" => true));

                } else {
                    echo json_encode(array("response" => false));

                }
                break;
            default:

        }

    }

    /** le processus de paiement de plusieurs frais de mission
     * @param null $ids
     * @param null $paymentAssociationId
     * @param null $type
     * @return \Cake\Network\Response|null
     * @throws Exception
     */
    public function addPayment($ids = null, $paymentAssociationId = null, $type = null)
    {
        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::journal_tresorerie, $user_id, ActionsEnum::add, "Payments",
            null, "Payment", null);

        $array_ids = explode(",", $ids);
        switch ($paymentAssociationId) {
            case PaymentAssociationsEnum::car :
                break;
            case  PaymentAssociationsEnum::event:
                break;
            case PaymentAssociationsEnum::mission_order :
                $missions = $this->SheetRideDetailRides->find('all', array(
                    'conditions' => array('SheetRideDetailRides.id' => $array_ids),
                    'recursive' => -1,
                    'fields' => array(
                        'SheetRide.customer_id',
                        'SheetRideDetailRides.amount_remaining',
                        'SheetRideDetailRides.id'
                    ),
                    'order' => array('SheetRideDetailRides.real_start_date' => 'ASC'),
                    'joins' => array(
                        array(
                            'table' => 'sheet_rides',
                            'type' => 'left',
                            'alias' => 'SheetRide',
                            'conditions' => array('SheetRide.id = SheetRideDetailRides.sheet_ride_id')
                        )
                    )
                ));
                $amount = 0;
                foreach ($missions as $mission) {
                    $amount = $mission['SheetRideDetailRides']['amount_remaining'];
                }
                $this->set('amount', $amount);
                $customerId = $missions[0]['SheetRide']['customer_id'];
                $customer = $this->Customer->find('first', array(
                    'conditions' => array('Customer.id' => $customerId),
                    'recursive' => -1,
                    'fields' => array('Customer.balance')
                ));
                if (!empty($customer)) {
                    $balance = $customer['Customer']['balance'];
                } else {
                    $balance = 0;
                }
                break;
            case PaymentAssociationsEnum::invoice :
                $invoices = $this->TransportBill->find('all', array(
                    'conditions' => array('TransportBill.id' => $array_ids, 'TransportBill.amount_remaining >' => 0),
                    'recursive' => -1,
                    'fields' => array(
                        'TransportBill.total_ttc',
                        'TransportBill.supplier_id',
                        'TransportBill.id',
                        'TransportBill.amount_remaining'
                    )
                ));
                $creditNotes = $this->TransportBill->find('all', array(
                    'conditions' => array('TransportBill.invoice_id' => $array_ids, 'TransportBill.amount_remaining >' => 0),
                    'recursive' => -1,
                    'fields' => array(
                        'TransportBill.total_ttc',
                        'TransportBill.supplier_id',
                        'TransportBill.id',
                        'TransportBill.amount_remaining'
                    )
                ));
                $amount = 0;
                if (!empty($invoices)) {
                    foreach ($invoices as $invoice) {
                        $amount = $amount + $invoice['TransportBill']['amount_remaining'];
                    }
                    if (!empty($creditNotes)){
                        foreach ($creditNotes as $creditNote){
                            $amount = $amount - $creditNote['TransportBill']['amount_remaining'];
                        }
                    }
                    $this->set('amount', $amount);

                    $supplierId = $invoices[0]['TransportBill']['supplier_id'];
                    $supplier = $this->Supplier->getSuppliersById($supplierId);
                    if (!empty($supplier)) {
                        $balance = $supplier['Supplier']['balance'];
                    } else {
                        $balance = 0;
                    }

                } else {

                    $this->Flash->error(__('All selected invoices are already paid.'));
                    return $this->redirect(array('controller' => 'transportBills', 'action' => 'index', $type));

                }

                break;

            case PaymentAssociationsEnum::credit_note :
                $creditNotes = $this->TransportBill->find('all', array(
                    'conditions' => array('TransportBill.id' => $array_ids, 'TransportBill.amount_remaining >' => 0),
                    'recursive' => -1,
                    'fields' => array(
                        'TransportBill.total_ttc',
                        'TransportBill.supplier_id',
                        'TransportBill.id',
                        'TransportBill.amount_remaining'
                    )
                ));

                $amount = 0;
                if (!empty($creditNotes)) {
                    foreach ($creditNotes as $creditNote) {
                        $amount = $amount + $creditNote['TransportBill']['amount_remaining'];
                    }
                    $this->set('amount', $amount);

                    $supplierId = $creditNotes[0]['TransportBill']['supplier_id'];
                    $supplier = $this->Supplier->getSuppliersById($supplierId);
                    if (!empty($supplier)) {
                        $balance = $supplier['Supplier']['balance'];
                    } else {
                        $balance = 0;
                    }

                } else {

                    $this->Flash->error(__('All selected invoices are already paid.'));
                    return $this->redirect(array('controller' => 'transportBills', 'action' => 'index', $type));

                }

                break;

            case PaymentAssociationsEnum::offshore :
                $reservations = $this->Reservation->find('all', array(
                    'order' => array('Reservation.id' => 'ASC'),
                    'recursive' => -1,
                    'conditions' => array('Reservation.id' => $array_ids),
                    'fields' => array('Reservation.supplier_id',
                        'Reservation.amount_remaining',
                        'Reservation.advanced_amount',
                        'Reservation.id'),
                    'joins' => array(
                        array(
                            'table' => 'car',
                            'type' => 'left',
                            'alias' => 'Car',
                            'conditions' => array('Car.id = Reservation.car_id')
                        )
                    )
                ));
                $amount = 0;
                $totalAmountRemaining = 0;
                $totalAdvancedAmount = 0;
                if (!empty($reservations)) {
                    foreach ($reservations as $reservation) {
                        $totalAmountRemaining = $totalAmountRemaining + $reservation['Reservation']['amount_remaining'];
                        $totalAdvancedAmount = $totalAdvancedAmount + $reservation['Reservation']['advanced_amount'];
                        $amount = $totalAmountRemaining - $totalAdvancedAmount;
                    }
                    $this->set('amount', $amount);

                    $supplierId = $reservations[0]['Reservation']['supplier_id'];
                    $supplier = $this->Supplier->getSuppliersById($supplierId);
                   /* if (!empty($supplier)) {
                        $balance = $supplier['Supplier']['balance'];
                    } else {
                        $balance = 0;
                    }*/
                } else {

                    $this->Flash->error(__('All selected reservations are already paid.'));
                    return $this->redirect(array('controller' => 'reservations', 'action' => 'index'));
                }
                break;
            case PaymentAssociationsEnum::bill :
                $this->verifyTypeBills($type, $array_ids);

                $bills = $this->Bill->find('all', array(
                    'conditions' => array('Bill.id' => $array_ids, 'Bill.amount_remaining >' => 0),
                    'recursive' => -1,
                    'fields' => array(
                        'Bill.total_ttc',
                        'Bill.supplier_id',
                        'Bill.type',
                        'Bill.id',
                        'Bill.amount_remaining'
                    )
                ));

                $amount = 0;
                if (!empty($bills)) {
                    foreach ($bills as $bill) {
                        $amount = $amount + $bill['Bill']['amount_remaining'];
                        $this->set('amount', $amount);
                        $supplierId = $bills[0]['Bill']['supplier_id'];
                        $typeBill = $bill['Bill']['type'];
                        $supplier = $this->Supplier->getSuppliersById($supplierId);
                        if (!empty($supplier)) {
                            $balance = $supplier['Supplier']['balance'];
                        } else {
                            $balance = 0;
                        }
                    }
                } else {
                    $this->Flash->error(__('All selected bills are already paid.'));
                    return $this->redirect(array('controller' => 'bills', 'action' => 'index', $type));
                }


                break;
            case PaymentAssociationsEnum::consumption_species :
                $consumptions = $this->Consumption->find('all', array(
                    'conditions' => array('Consumption.id' => $array_ids),
                    'recursive' => -1,
                    'fields' => array(
                        'SheetRide.customer_id',
                        'Consumption.species',
                        'Consumption.id'
                    ),
                    'order' => array('Consumption.consumption_date' => 'ASC'),
                    'joins' => array(
                        array(
                            'table' => 'sheet_rides',
                            'type' => 'left',
                            'alias' => 'SheetRide',
                            'conditions' => array('SheetRide.id = Consumption.sheet_ride_id')
                        )
                    )
                ));
                $amount = 0;
                foreach ($consumptions as $consumption) {
                    $amount = $consumption['Consumption']['species'];
                }
                $this->set('amount', $amount);
                $customerId = $consumptions[0]['SheetRide']['customer_id'];
                $customer = $this->Customer->find('first', array(
                    'conditions' => array('Customer.id' => $customerId),
                    'recursive' => -1,
                    'fields' => array('Customer.balance')
                ));
                if (!empty($customer)) {
                    $balance = $customer['Customer']['balance'];
                } else {
                    $balance = 0;
                }
                break;
            case PaymentAssociationsEnum::fuel_log :
                $fuelLogs = $this->FuelLog->find('all', array(
                    'conditions' => array('FuelLog.id' => $array_ids),
                    'recursive' => -1,
                    'fields' => array(
                        'FuelLog.price',
                        'FuelLog.price_remaining',
                        'FuelLog.id'
                    ),
                    'order' => array('FuelLog.date' => 'ASC'),

                ));
                $amount = 0;
                foreach ($fuelLogs as $fuelLog) {
                    $amount = $fuelLog['FuelLog']['price_remaining'];
                }
                $this->set('amount', $amount);

                break;
            default:

        }


        $this->layout = 'popup';

        if (!empty($this->request->data)) {
            /*
             * transact_type_id = 1 credit
             * transact_type_id = 2 debit
             */
            switch ($paymentAssociationId) {
                case PaymentAssociationsEnum::car :
                    break;
                case  PaymentAssociationsEnum::event:
                    break;
                case  PaymentAssociationsEnum::mission_order:
                    $this->Payment->create();
                    $payrollAmount = $this->request->data['Payment']['amount'];
                    $payrollAmount = $payrollAmount + $balance;
                    $this->createDateFromDate('Payment', 'operation_date');
                    $this->createDateFromDate('Payment', 'receipt_date');
                    $this->createDateFromDate('Payment', 'value_date');
                    $this->createDateFromDate('Payment', 'deadline_date');
                    $this->request->data['Payment']['payment_association_id'] = $paymentAssociationId;
                    $this->request->data['Payment']['customer_id'] = $customerId;
                    $this->request->data['Payment']['transact_type_id'] = 2;

                    if ($this->Payment->save($this->request->data)) {
                        $paymentId = $this->Payment->getInsertID();
                        $save = true;
                        foreach ($missions as $mission) {
                            $this->DetailPayment->create();
                            $missionCost = $mission['SheetRideDetailRides']['amount_remaining'];
                            $sheetRideDetailRidesId = $mission['SheetRideDetailRides']['id'];
                            $data['DetailPayment']['payment_id'] = $paymentId;
                            $data['DetailPayment']['sheet_ride_detail_ride_id'] = $sheetRideDetailRidesId;
                            if ($payrollAmount > $missionCost) {
                                $data['DetailPayment']['payroll_amount'] = $missionCost;
                                $amountRemaining = 0;
                                $payrollAmount = $payrollAmount - $missionCost;
                                $balance = $payrollAmount;

                            } else {

                                $data['DetailPayment']['payroll_amount'] = $payrollAmount;
                                $amountRemaining = $missionCost - $payrollAmount;
                                $payrollAmount = 0;
                                $balance = 0;
                            }

                            if ($this->DetailPayment->save($data)) {
                                $save = true;
                                $this->SheetRideDetailRides->id = $sheetRideDetailRidesId;
                                $this->SheetRideDetailRides->saveField('amount_remaining', $amountRemaining);
                            } else {
                                $save = false;
                            }
                            if ($save == false) {
                                $this->Flash->error(__('The payment could not be saved. Please, try again.'));
                                $this->redirect(array('action' => 'searchMissionCosts'));
                            }
                        }
                        if ($balance > 0) {

                            $this->Customer->id = $customerId;
                            $this->Customer->saveField('balance', $balance);
                        }
                        if ($save == true) {
                            $compteId = $this->request->data['Payment']['compte_id'];
                            $amount = $this->request->data['Payment']['amount'];
                            $this->Compte->updateCompteDebit($compteId, $amount);
                            $this->createAssociationPaymentSheetRides($paymentId);
                            $this->Flash->success(__('The payment has been saved.'));
                            $this->redirect(array('action' => 'searchMissionCosts'));
                        }
                    }

                    break;
                   break;


                case  PaymentAssociationsEnum::invoice:

                    $this->Payment->create();
                    $payrollAmount = $this->request->data['Payment']['amount'];

                    $this->createDateFromDate('Payment', 'operation_date');
                    $this->createDateFromDate('Payment', 'receipt_date');
                    $this->createDateFromDate('Payment', 'value_date');
                    if ($type == 4) {
                        $this->request->data['Payment']['payment_association_id'] = 6;
                    } else {
                        $this->request->data['Payment']['payment_association_id'] = $paymentAssociationId;
                    }
                    $this->request->data['Payment']['supplier_id'] = $supplierId;
                    $this->request->data['Payment']['transact_type_id'] = 1;
                    if ($this->Payment->save($this->request->data)) {
                        $paymentId = $this->Payment->getInsertID();
                        $save = true;
                        $balance = 0;
                        foreach ($invoices as $invoice) {
                            $this->DetailPayment->create();
                            $amountRemainingInvoice = $invoice['TransportBill']['amount_remaining'];
                            $invoiceId = $invoice['TransportBill']['id'];
                            $data['DetailPayment']['payment_id'] = $paymentId;
                            $data['DetailPayment']['transport_bill_id'] = $invoiceId;
                            if ($payrollAmount >= $amountRemainingInvoice) {
                                $data['DetailPayment']['payroll_amount'] = $amountRemainingInvoice;
                                $amountRemaining = 0;
                                $payrollAmount = $payrollAmount - $amountRemainingInvoice;
                                $balance = $payrollAmount;
                            } else {
                                $data['DetailPayment']['payroll_amount'] = $payrollAmount;
                                $amountRemaining = $amountRemainingInvoice - $payrollAmount;
                                $payrollAmount = 0;
                                $balance = 0;
                            }
                            if ($this->DetailPayment->save($data)) {
                                $save = true;
                                $this->TransportBill->id = $invoiceId;
                                $this->TransportBill->saveField('amount_remaining', $amountRemaining);
                                $this->updateStatusArticle($invoiceId, $paymentAssociationId);
                            } else {
                                $save = false;
                            }
                            if ($save == false) {
                                $this->Flash->error(__('The payment could not be saved. Please, try again.'));
                                return $this->redirect(array(
                                    'controller' => 'transportBills',
                                    'action' => 'index',
                                    $type
                                ));
                            }
                        }
                        if ($balance > 0) {
                            $this->Supplier->id = $supplierId;
                            $this->Supplier->saveField('balance', $balance);
                        }
                        if ($save == true) {
                            $compteId = $this->request->data['Payment']['compte_id'];
                            $amount = $this->request->data['Payment']['amount'];
                            $this->Compte->updateCompteCredit($compteId, $amount);
                            $this->createAssociationPaymentInvoices($paymentId);
                            $this->Flash->success(__('The payment has been saved.'));
                            return $this->redirect(array('controller' => 'transportBills', 'action' => 'index', $type));
                        }
                    }
                    break;

                case  PaymentAssociationsEnum::credit_note:

                    $this->Payment->create();
                    $payrollAmount = $this->request->data['Payment']['amount'];

                    $this->createDateFromDate('Payment', 'operation_date');
                    $this->createDateFromDate('Payment', 'receipt_date');
                    $this->createDateFromDate('Payment', 'value_date');

                     $this->request->data['Payment']['payment_association_id'] = $paymentAssociationId;

                    $this->request->data['Payment']['supplier_id'] = $supplierId;
                    $this->request->data['Payment']['transact_type_id'] = 2;
                    if ($this->Payment->save($this->request->data)) {
                        $paymentId = $this->Payment->getInsertID();
                        $save = true;
                        $balance = 0;
                        foreach ($creditNotes as $creditNote) {
                            $this->DetailPayment->create();
                            $amountRemainingCreditNote = $creditNote['TransportBill']['amount_remaining'];
                            $creditNoteId = $creditNote['TransportBill']['id'];
                            $data['DetailPayment']['payment_id'] = $paymentId;
                            $data['DetailPayment']['transport_bill_id'] = $creditNoteId;
                            if ($payrollAmount >= $amountRemainingCreditNote) {
                                $data['DetailPayment']['payroll_amount'] = $amountRemainingCreditNote;
                                $amountRemaining = 0;
                                $payrollAmount = $payrollAmount - $amountRemainingCreditNote;
                                $balance = $payrollAmount;
                            } else {
                                $data['DetailPayment']['payroll_amount'] = $payrollAmount;
                                $amountRemaining = $amountRemainingCreditNote - $payrollAmount;

                                $payrollAmount = 0;
                                $balance = 0;
                            }
                            if ($this->DetailPayment->save($data)) {
                                $save = true;
                                $this->TransportBill->id = $creditNoteId;
                                $this->TransportBill->saveField('amount_remaining', $amountRemaining);
                                $this->updateStatusArticle($creditNoteId, $paymentAssociationId);
                            } else {
                                $save = false;
                            }
                            if ($save == false) {
                                $this->Flash->error(__('The payment could not be saved. Please, try again.'));
                                return $this->redirect(array(
                                    'controller' => 'transportBills',
                                    'action' => 'index',
                                    $type
                                ));
                            }
                        }
                        if ($balance > 0) {
                            $this->Supplier->id = $supplierId;
                            $this->Supplier->saveField('balance', $balance);
                        }
                        if ($save == true) {
                            $compteId = $this->request->data['Payment']['compte_id'];
                            $amount = $this->request->data['Payment']['amount'];
                            $this->Compte->updateCompteDebit($compteId, $amount);
                            $this->createAssociationPaymentInvoices($paymentId);
                            $this->Flash->success(__('The payment has been saved.'));
                            return $this->redirect(array('controller' => 'transportBills', 'action' => 'index', $type));
                        }

                    }
                    break;


                    case PaymentAssociationsEnum::offshore:
                    $this->Payment->create();
                    $payrollAmount = $this->request->data['Payment']['amount'];
                    $payrollAmount = $payrollAmount +$totalAdvancedAmount;

                    /*if ($balance > 0) {
                        $payrollAmount = $payrollAmount + $balance;
                    }*/

                    $this->createDateFromDate('Payment', 'operation_date');
                    $this->createDateFromDate('Payment', 'receipt_date');
                    $this->createDateFromDate('Payment', 'value_date');
                    $this->request->data['Payment']['payment_association_id'] = $paymentAssociationId;
                    $this->request->data['Payment']['supplier_id'] = $supplierId;
                    $this->request->data['Payment']['transact_type_id'] = 2;
                    if ($this->Payment->save($this->request->data)) {
                        $paymentId = $this->Payment->getInsertID();
                        $save = true;
                        //$balance = 0;
                        $reservations = $this->Reservation->find('all', array(
                            'order' => array('Reservation.id' => 'ASC'),
                            'recursive' => -1,
                            'conditions' => array('Reservation.id' => $array_ids),
                            'fields' => array('Reservation.supplier_id',
                                'Reservation.amount_remaining',
                                'Reservation.advanced_amount',
                                'Reservation.id'),
                            'joins' => array(
                                array(
                                    'table' => 'car',
                                    'type' => 'left',
                                    'alias' => 'Car',
                                    'conditions' => array('Car.id = Reservation.car_id')
                                )
                            )
                        ));

                        foreach ($reservations as $reservation) {
                            $this->DetailPayment->create();
                            $amountRemainingReservation = floatval($reservation['Reservation']['amount_remaining']);
                            $reservationId = $reservation['Reservation']['id'];

                            $data['DetailPayment']['payment_id'] = $paymentId;
                            $data['DetailPayment']['reservation_id'] = $reservationId;


                            if ($payrollAmount >= $amountRemainingReservation) {
                                $data['DetailPayment']['payroll_amount'] = $amountRemainingReservation;
                                $amountRemaining = 0;
                                $payrollAmount = $payrollAmount - $amountRemainingReservation;
                                // $balance = $payrollAmount;

                            } else {
                                $data['DetailPayment']['payroll_amount'] = $payrollAmount;
                                $amountRemaining = $amountRemainingReservation - $payrollAmount;
                                $payrollAmount = 0;
                               // $balance = -$amountRemaining;
                            }
                            if ($this->DetailPayment->save($data)) {
                                $save = true;
                                $this->Reservation->id = $reservationId;
                                $this->Reservation->saveField('amount_remaining', $amountRemaining);
                                $this->Reservation->saveField('advanced_amount', 0);
                                $this->updateStatusArticle($reservationId, $paymentAssociationId);
                            } else {
                                $save = false;
                            }
                            if ($save == false) {
                                $this->Flash->error(__('The payment could not be saved. Please, try again.'));
                                return $this->redirect(array('controller' => 'reservations', 'action' => 'index'));
                            }
                        }

                        /*if(!empty($supplierId)){
                            $this->Supplier->id = $supplierId;
                            $this->Supplier->saveField('balance', $balance);
                        }*/

                        if ($save == true) {
                            $compteId = $this->request->data['Payment']['compte_id'];
                            $amount = $this->request->data['Payment']['amount'];
                            $this->Compte->updateCompteDebit($compteId, $amount);
                            $this->createAssociationPaymentReservations($paymentId);
                            $this->Flash->success(__('The payment has been saved.'));
                            return $this->redirect(array('controller' => 'reservations', 'action' => 'index'));

                        }
                    }
                    break;
                case PaymentAssociationsEnum::bill :
                    $this->Payment->create();
                    $payrollAmount = $this->request->data['Payment']['amount'];
                    $this->createDateFromDate('Payment', 'operation_date');
                    $this->createDateFromDate('Payment', 'receipt_date');
                    $this->createDateFromDate('Payment', 'value_date');
                    $this->request->data['Payment']['payment_association_id'] = 9;
                    $this->request->data['Payment']['supplier_id'] = $supplierId;


                    switch ($typeBill){
                        case BillTypesEnum::receipt :
                        case BillTypesEnum::return_customer :
                        case BillTypesEnum::entry_order :
                        case BillTypesEnum::reintegration_order :
                        case BillTypesEnum::sale_credit_note :
                        case BillTypesEnum::purchase_invoice :
                            $this->request->data['Payment']['transact_type_id'] = 2;
                            break;
                        case BillTypesEnum::delivery_order :
                        case BillTypesEnum::return_supplier :
                        case BillTypesEnum::exit_order :
                        case BillTypesEnum::renvoi_order :
                        case BillTypesEnum::credit_note :
                        case BillTypesEnum::sales_invoice :
                            $this->request->data['Payment']['transact_type_id'] = 1;
                            break;
                    }

                    if ($this->Payment->save($this->request->data)) {
                        $paymentId = $this->Payment->getInsertID();
                        $save = true;
                        $balance = 0;
                        foreach ($bills as $bill) {
                            $this->DetailPayment->create();
                            $amountRemainingBill = $bill['Bill']['amount_remaining'];
                            $billId = $bill['Bill']['id'];
                            $data['DetailPayment']['payment_id'] = $paymentId;
                            $data['DetailPayment']['bill_id'] = $billId;
                            if ($payrollAmount >= $amountRemainingBill) {
                                $data['DetailPayment']['payroll_amount'] = $amountRemainingBill;
                                $amountRemaining = 0;
                                $payrollAmount = $payrollAmount - $amountRemainingBill;
                                $balance = $payrollAmount;
                            } else {
                                $data['DetailPayment']['payroll_amount'] = $payrollAmount;
                                $amountRemaining = $amountRemainingBill - $payrollAmount;
                                $payrollAmount = 0;
                                $balance = 0;
                            }
                            if ($this->DetailPayment->save($data)) {
                                $save = true;
                                $this->Bill->id = $billId;
                                $this->Bill->saveField('amount_remaining', $amountRemaining);
                                $this->updateStatusArticle($billId, $paymentAssociationId);
                            } else {
                                $save = false;
                            }
                            if ($save == false) {
                                $this->Flash->error(__('The payment could not be saved. Please, try again.'));
                                return $this->redirect(array(
                                    'controller' => 'bills',
                                    'action' => 'index',
                                    $type
                                ));
                            }
                        }

                        if ($balance > 0) {
                            $this->Supplier->id = $supplierId;
                            $this->Supplier->saveField('balance', $balance);
                        }
                        if ($save == true) {
                            $compteId = $this->request->data['Payment']['compte_id'];
                            $amount = $this->request->data['Payment']['amount'];
                            switch ($this->request->data['Payment']['type']){
                                case BillTypesEnum::receipt :
                                case BillTypesEnum::return_customer :
                                case BillTypesEnum::entry_order :
                                case BillTypesEnum::reintegration_order :
                                case BillTypesEnum::sale_credit_note :
                                case BillTypesEnum::purchase_invoice :
                                    $this->Compte->updateCompteDebit($compteId, $amount);
                                    $this->Payment->createAssociationPaymentBills($paymentId);
                                    break;
                                case BillTypesEnum::delivery_order :
                                case BillTypesEnum::return_supplier :
                                case BillTypesEnum::exit_order :
                                case BillTypesEnum::renvoi_order :
                                case BillTypesEnum::credit_note :
                                case BillTypesEnum::sales_invoice :
                                    $this->Compte->updateCompteCredit($compteId, $amount);
                                    $this->Payment->createAssociationPaymentBills($paymentId);
                                    break;
                            }
                            $this->Flash->success(__('The payment has been saved.'));
                            return $this->redirect(array('controller' => 'bills', 'action' => 'index', $type));
                        }
                    }



                    break;

                case  PaymentAssociationsEnum::consumption_species:
                    $this->Payment->create();
                    $payrollAmount = $this->request->data['Payment']['amount'];
                    $payrollAmount = $payrollAmount + $balance;
                    $this->createDateFromDate('Payment', 'operation_date');
                    $this->createDateFromDate('Payment', 'receipt_date');
                    $this->createDateFromDate('Payment', 'value_date');
                    $this->createDateFromDate('Payment', 'deadline_date');
                    $this->request->data['Payment']['payment_association_id'] = $paymentAssociationId;
                    $this->request->data['Payment']['customer_id'] = $customerId;
                    $this->request->data['Payment']['transact_type_id'] = 2;

                    if ($this->Payment->save($this->request->data)) {
                        $paymentId = $this->Payment->getInsertID();
                        $save = true;
                        foreach ($consumptions as $consumption) {
                            $this->DetailPayment->create();
                            $consumptionSpecie = $consumption['Consumption']['species'];
                            $consumptionId = $consumption['Consumption']['id'];
                            $data['DetailPayment']['payment_id'] = $paymentId;
                            $data['DetailPayment']['consumption_id'] = $consumptionId;
                            if ($payrollAmount > $consumptionSpecie) {
                                $data['DetailPayment']['payroll_amount'] = $consumptionSpecie;
                                $payrollAmount = $payrollAmount - $consumptionSpecie;
                                $balance = $payrollAmount;

                            } else {

                                $data['DetailPayment']['payroll_amount'] = $payrollAmount;
                                $payrollAmount = 0;
                                $balance = 0;
                            }

                            if ($this->DetailPayment->save($data)) {
                                $save = true;
                            } else {
                                $save = false;
                            }
                            if ($save == false) {
                                $this->Flash->error(__('The payment could not be saved. Please, try again.'));
                                $this->redirect(array('action' => 'searchMissionCosts'));
                            }
                        }
                        if ($balance > 0) {

                            $this->Customer->id = $customerId;
                            $this->Customer->saveField('balance', $balance);
                        }
                        if ($save == true) {
                            $compteId = $this->request->data['Payment']['compte_id'];
                            $amount = $this->request->data['Payment']['amount'];
                            $this->Compte->updateCompteDebit($compteId, $amount);
                            $this->createAssociationPaymentSheetRides($paymentId);
                            $this->Flash->success(__('The payment has been saved.'));
                            $this->redirect(array('action' => 'searchMissionCosts'));
                        }
                    }

                    break;

                case  PaymentAssociationsEnum::fuel_log:
                    $this->Payment->create();
                    $payrollAmount = $this->request->data['Payment']['amount'];
                    $payrollAmount = $payrollAmount;
                    $this->createDateFromDate('Payment', 'operation_date');
                    $this->createDateFromDate('Payment', 'receipt_date');
                    $this->createDateFromDate('Payment', 'value_date');
                    $this->createDateFromDate('Payment', 'deadline_date');
                    $this->request->data['Payment']['payment_association_id'] = $paymentAssociationId;

                    $this->request->data['Payment']['transact_type_id'] = 2;

                    if ($this->Payment->save($this->request->data)) {
                        $paymentId = $this->Payment->getInsertID();
                        $save = true;
                        foreach ($fuelLogs as $fuelLog) {
                            $this->DetailPayment->create();
                            $priceFuelLog = $fuelLog['FuelLog']['price_remaining'];
                            $fuelLogId = $fuelLog['FuelLog']['id'];
                            $data['DetailPayment']['payment_id'] = $paymentId;
                            $data['DetailPayment']['fuel_log_id'] = $fuelLogId;
                            if ($payrollAmount > $priceFuelLog) {
                                $data['DetailPayment']['payroll_amount'] = $priceFuelLog;
                                $priceRemaining = 0;
                                $payrollAmount = $payrollAmount - $priceFuelLog;
                                $balance = $payrollAmount;

                            } else {

                                $data['DetailPayment']['payroll_amount'] = $payrollAmount;

                                $priceRemaining = $priceFuelLog - $payrollAmount;
                                $payrollAmount = 0;
                                $balance = 0;
                            }

                            if ($this->DetailPayment->save($data)) {
                                $save = true;
                                $this->FuelLog->id = $fuelLogId;
                                $this->FuelLog->saveField('price_remaining', $priceRemaining);
                            } else {
                                $save = false;
                            }
                            if ($save == false) {
                                $this->Flash->error(__('The payment could not be saved. Please, try again.'));
                                $this->redirect(array('controller'=>'fuelLogs','action' => 'index'));
                            }
                        }

                        if ($save == true) {
                            $compteId = $this->request->data['Payment']['compte_id'];
                            $amount = $this->request->data['Payment']['amount'];
                            $this->Compte->updateCompteDebit($compteId, $amount);
                            $this->createAssociationPaymentFuelLgs($paymentId);
                            $this->Flash->success(__('The payment has been saved.'));
                            $this->redirect(array('controller'=>'fuelLogs','action' => 'index'));
                        }
                    }
                    break;
            }

        }


        if (Configure::read("cafyb") == '1') {
            $comptes = $this->Cafyb->getComptes();
        }else {
            $comptes = $this->Payment->Compte->find('list', array('order' => 'num_compte'));
        }
        $paymentCategories = $this->PaymentCategory->getPaymentCategories('list');
        $this->set(compact('comptes','paymentCategories'));

    }


    /** verify if missions selected has same customer
     * @param null $paymentAssociationId
     * @return \Cake\Network\Response|null
     */
    public function verifyIdCustomers($paymentAssociationId = null)
    {
        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        $this->autoRender = false;
        $ids = filter_input(INPUT_POST, "ids");
        $array_ids = explode(",", $ids);
        switch ($paymentAssociationId) {
            case PaymentAssociationsEnum::car :
                break;
            case  PaymentAssociationsEnum::event:
                break;
            case PaymentAssociationsEnum::mission_order :
                $sheetRides = $this->SheetRideDetailRides->find('all', array(
                    'conditions' => array('SheetRideDetailRides.id' => $array_ids),
                    'recursive' => -1,
                    'fields' => array('SheetRide.customer_id'),
                    'joins' => array(
                        array(
                            'table' => 'sheet_rides',
                            'type' => 'left',
                            'alias' => 'SheetRide',
                            'conditions' => array('SheetRide.id = SheetRideDetailRides.sheet_ride_id')
                        )
                    )
                ));
                $response = true;
                $i = 0;
                $size = count($sheetRides);
                $customerId = $sheetRides[0]['SheetRide']['customer_id'];
                while ($response == true && $i < $size - 1) {
                    if ($customerId == $sheetRides[$i + 1]['SheetRide']['customer_id']) {
                        $response = true;
                    } else {
                        $response = false;
                    }
                    $i++;
                }
                echo json_encode(array("response" => $response));
                break;
            case PaymentAssociationsEnum::invoice :
                $transportBills = $this->TransportBill->find('all', array(
                    'order' => array('TransportBill.id' => 'DESC'),
                    'recursive' => -1,
                    'conditions' => array('type' => array(4, 7), 'TransportBill.id' => $array_ids),
                    'fields' => array('TransportBill.supplier_id')
                ));
                $response = true;
                $i = 0;
                $size = count($transportBills);
                $supplierId = $transportBills[0]['TransportBill']['supplier_id'];
                while ($response == true && $i < $size - 1) {
                    if ($supplierId == $transportBills[$i + 1]['TransportBill']['supplier_id']) {
                        $response = true;
                    } else {
                        $response = false;
                    }
                    $i++;
                }
                echo json_encode(array("response" => $response));
                break;
            case PaymentAssociationsEnum::credit_note :
                $transportBills = $this->TransportBill->find('all', array(
                    'order' => array('TransportBill.id' => 'DESC'),
                    'recursive' => -1,
                    'conditions' => array('type' => array(10), 'TransportBill.id' => $array_ids),
                    'fields' => array('TransportBill.supplier_id')
                ));
                $response = true;
                $i = 0;
                $size = count($transportBills);
                $supplierId = $transportBills[0]['TransportBill']['supplier_id'];
                while ($response == true && $i < $size - 1) {
                    if ($supplierId == $transportBills[$i + 1]['TransportBill']['supplier_id']) {
                        $response = true;
                    } else {
                        $response = false;
                    }
                    $i++;
                }
                echo json_encode(array("response" => $response));
                break;


                case PaymentAssociationsEnum::offshore:
                $reservations = $this->Reservation->find('all', array(

                    'order' => array('Reservation.id' => 'DESC'),
                    'recursive' => -1,
                    'conditions' => array('Reservation.id' => $array_ids),
                    'fields' => array('Suppliers.id'),
                    'joins' => array(
                        array(
                            'table' => 'suppliers',
                            'type' => 'left',
                            'alias' => 'Suppliers',
                            'conditions' => array('Suppliers.id = Reservation.supplier_id')
                        )
                    )
                ));
                $response = true;
                $i = 0;
                $size = count($reservations);
                $supplierId = $reservations[0]['Suppliers']['id'];
                while ($response == true && $i < $size - 1) {
                    if ($supplierId == $reservations[$i + 1]['Suppliers']['id']) {
                        $response = true;
                    } else {
                        $response = false;
                    }
                    $i++;
                }
                echo json_encode(array("response" => $response));
                break;
            case PaymentAssociationsEnum::bill :

                $bills = $this->Bill->find('all', array(
                    'order' => array('Bill.id' => 'DESC'),
                    'recursive' => -1,
                    'conditions' => array( 'Bill.id' => $array_ids),
                    'fields' => array('Bill.supplier_id')
                ));
                $response = true;
                $i = 0;
                $size = count($bills);
                $supplierId = $bills[0]['Bill']['supplier_id'];
                while ($response == true && $i < $size - 1) {
                    if ($supplierId == $bills[$i + 1]['Bill']['supplier_id']) {
                        $response = true;
                    } else {
                        $response = false;
                    }
                    $i++;
                }
                echo json_encode(array("response" => $response));
                break;

            default:

        }


    }

    public function viewPayment($id = null)
    {

        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        if (Configure::read("cafyb") == '1') {
            $payment = $this->Cafyb->getPaymentById($id);
            $this->set(compact('payment'));
        }else {
            $payment = $this->Payment->find('first', array(
                'conditions' => array('Payment.id' => $id),
                'recursive' => -1,
                'fields' => array(
                    'Payment.id',
                    'Payment.operation_date',
                    'Payment.receipt_date',
                    'Payment.value_date',
                    'Payment.amount',
                    'Payment.payment_type',
                    'Compte.num_compte',
                    'Payment.wording',
                    'Customer.first_name',
                    'Customer.last_name',
                    'Supplier.name',
                    'Interfering.name',
                    'PaymentAssociation.name'
                ),
                'joins' => array(
                    array(
                        'table' => 'comptes',
                        'type' => 'left',
                        'alias' => 'Compte',
                        'conditions' => array('Compte.id = Payment.compte_id')
                    ),
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('Customer.id = Payment.customer_id')
                    ),
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('Car.id = Payment.car_id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('Supplier.id = Payment.supplier_id')
                    ),
                    array(
                        'table' => 'event',
                        'type' => 'left',
                        'alias' => 'Event',
                        'conditions' => array('Event.id = Payment.event_id')
                    ),
                    array(
                        'table' => 'interferings',
                        'type' => 'left',
                        'alias' => 'Interfering',
                        'conditions' => array('Interfering.id = Payment.interfering_id')
                    ),
                    array(
                        'table' => 'payment_associations',
                        'type' => 'left',
                        'alias' => 'PaymentAssociation',
                        'conditions' => array('PaymentAssociation.id = Payment.payment_association_id')
                    ),
                )
            ));

            $this->set('payment', $payment);
            $detailPayments = array();
            switch ($payment['PaymentAssociation']['id']) {
                case PaymentAssociationsEnum::mission_order :
                    $detailPayments = $this->DetailPayment->find('all',
                        array(
                            'conditions' => array('DetailPayment.payment_id' => $id),
                            'recursive' => -1,
                            'fields' => array(
                                'DetailPayment.payroll_amount',
                                'SheetRideDetailRides.mission_cost',
                                'SheetRideDetailRides.reference',
                                'SheetRideDetailRides.amount_remaining',
                            ),
                            'joins' => array(

                                array(
                                    'table' => 'payments',
                                    'type' => 'left',
                                    'alias' => 'Payment',
                                    'conditions' => array('DetailPayment.payment_id = Payment.id')
                                ),
                                array(
                                    'table' => 'sheet_ride_detail_rides',
                                    'type' => 'left',
                                    'alias' => 'SheetRideDetailRides',
                                    'conditions' => array('DetailPayment.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
                                ),
                            )
                        ));
                    break;
                case PaymentAssociationsEnum::invoice :
                    $detailPayments = $this->DetailPayment->find('all',
                        array(
                            'conditions' => array('DetailPayment.payment_id' => $id),
                            'recursive' => -1,
                            'fields' => array(
                                'DetailPayment.payroll_amount',
                                'TransportBill.total_ttc',
                                'TransportBill.reference',
                                'TransportBill.amount_remaining',
                            ),
                            'joins' => array(

                                array(
                                    'table' => 'payments',
                                    'type' => 'left',
                                    'alias' => 'Payment',
                                    'conditions' => array('DetailPayment.payment_id = Payment.id')
                                ),
                                array(
                                    'table' => 'transport_bills',
                                    'type' => 'left',
                                    'alias' => 'TransportBill',
                                    'conditions' => array('TransportBill.id = DetailPayment.transport_bill_id')
                                ),
                            )
                        ));
                    break;
                case PaymentAssociationsEnum::offshore :
                    $detailPayments = $this->DetailPayment->find('all',
                        array(
                            'conditions' => array('DetailPayment.payment_id' => $id),
                            'recursive' => -1,
                            'fields' => array(
                                'DetailPayment.payroll_amount',
                                'SheetRideDetailRides.reference',
                                'Reservation.cost',
                                'Reservation.amount_remaining',
                            ),
                            'joins' => array(

                                array(
                                    'table' => 'payments',
                                    'type' => 'left',
                                    'alias' => 'Payment',
                                    'conditions' => array('DetailPayment.payment_id = Payment.id')
                                ),
                                array(
                                    'table' => 'reservations',
                                    'type' => 'left',
                                    'alias' => 'Reservation',
                                    'conditions' => array('Reservation.id = DetailPayment.reservation_id')
                                ),
                                array(
                                    'table' => 'sheet_ride_detail_rides',
                                    'type' => 'left',
                                    'alias' => 'SheetRideDetailRides',
                                    'conditions' => array('Reservation.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
                                ),


                            )
                        ));
                    break;
                case PaymentAssociationsEnum::preinvoice :
                    $detailPayments = $this->DetailPayment->find('all',
                        array(
                            'conditions' => array('DetailPayment.payment_id' => $id),
                            'recursive' => -1,
                            'fields' => array(
                                'DetailPayment.payroll_amount',
                                'TransportBill.total_ttc',
                                'TransportBill.reference',
                                'TransportBill.amount_remaining',
                            ),
                            'joins' => array(

                                array(
                                    'table' => 'payments',
                                    'type' => 'left',
                                    'alias' => 'Payment',
                                    'conditions' => array('DetailPayment.payment_id = Payment.id')
                                ),
                                array(
                                    'table' => 'transport_bills',
                                    'type' => 'left',
                                    'alias' => 'TransportBill',
                                    'conditions' => array('TransportBill.id = DetailPayment.transport_bill_id')
                                ),
                            )
                        ));
                    break;
                case PaymentAssociationsEnum::cashing :
                    break;
                case PaymentAssociationsEnum::disbursement :
                    break;

                case PaymentAssociationsEnum::bill :
                    $detailPayments = $this->DetailPayment->find('all',
                        array(
                            'conditions' => array('DetailPayment.payment_id' => $id),
                            'recursive' => -1,
                            'fields' => array(
                                'DetailPayment.payroll_amount',
                                'Bill.total_ttc',
                                'Bill.reference',
                                'Bill.amount_remaining',
                            ),
                            'joins' => array(

                                array(
                                    'table' => 'payments',
                                    'type' => 'left',
                                    'alias' => 'Payment',
                                    'conditions' => array('DetailPayment.payment_id = Payment.id')
                                ),
                                array(
                                    'table' => 'bills',
                                    'type' => 'left',
                                    'alias' => 'Bill',
                                    'conditions' => array('Bill.id = DetailPayment.bill_id')
                                ),
                            )
                        ));
                    break;

            }
            $this->set('detailPayments', $detailPayments);
        }

    }

    /**
     * @param null $id
     * voir detail des missions payé dans un seul payement
     */
    public function viewPaymentMissionCosts($id = null)
    {
        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        $payment = $this->Payment->find('first', array(
            'conditions' => array('Payment.id' => $id),
            'recursive' => -1,
            'fields' => array(
                'Payment.reference',
                'Payment.operation_date',
                'Payment.receipt_date',
                'Payment.value_date',
                'Payment.payment_type',
                'Payment.amount',
                'Compte.num_compte'
            ),
            'joins' => array(
                array(
                    'table' => 'comptes',
                    'type' => 'left',
                    'alias' => 'Compte',
                    'conditions' => array('Payment.compte_id = Compte.id')
                )
            )
        ));

        $this->set('payment', $payment);

        $detailPayments = $this->DetailPayment->find('all',
            array(
                'conditions' => array('DetailPayment.payment_id' => $id),
                'recursive' => -1,
                'fields' => array(
                    'DetailPayment.payroll_amount',
                    'SheetRideDetailRides.mission_cost',
                    'SheetRideDetailRides.reference',
                    'SheetRideDetailRides.amount_remaining',
                    'Payment.reference',
                    'Payment.operation_date',
                    'Payment.receipt_date',
                    'Payment.value_date',
                    'Payment.payment_type',
                    'Payment.amount',
                    'Customer.first_name',
                    'Customer.last_name',
                    'CarType.name',
                    'DepartureDestination.name',
                    'ArrivalDestination.name'
                ),
                'joins' => array(

                    array(
                        'table' => 'payments',
                        'type' => 'left',
                        'alias' => 'Payment',
                        'conditions' => array('DetailPayment.payment_id = Payment.id')
                    ),
                    array(
                        'table' => 'sheet_ride_detail_rides',
                        'type' => 'left',
                        'alias' => 'SheetRideDetailRides',
                        'conditions' => array('DetailPayment.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
                    ),
                    array(
                        'table' => 'sheet_rides',
                        'type' => 'left',
                        'alias' => 'SheetRide',
                        'conditions' => array('SheetRide.id = SheetRideDetailRides.sheet_ride_id')
                    ),
                    array(
                        'table' => 'customers',
                        'type' => 'left',
                        'alias' => 'Customer',
                        'conditions' => array('Customer.id = SheetRide.customer_id')
                    ),
                    array(
                        'table' => 'detail_rides',
                        'type' => 'left',
                        'alias' => 'DetailRide',
                        'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'CarType',
                        'conditions' => array('DetailRide.car_type_id = CarType.id')
                    ),
                    array(
                        'table' => 'rides',
                        'type' => 'left',
                        'alias' => 'Ride',
                        'conditions' => array('DetailRide.ride_id = Ride.id')
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
                    ),

                )
            ));

        $this->set('detailPayments', $detailPayments);


    }

    /**
     * @param null $id
     *  voir detail paiement dune frais de mission
     */
    public function viewDetailPaymentsMissionCost($id = null)
    {

        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        $detailPayments = $this->DetailPayment->find('all',
            array(
                'conditions' => array('DetailPayment.sheet_ride_detail_ride_id' => $id),
                'recursive' => -1,
                'fields' => array(
                    'DetailPayment.payroll_amount',
                    'SheetRideDetailRides.mission_cost',
                    'SheetRideDetailRides.reference',
                    'SheetRideDetailRides.amount_remaining',
                    'Payment.reference',
                    'Payment.operation_date',
                    'Payment.receipt_date',
                    'Payment.value_date',
                    'Payment.payment_type',
                    'Payment.amount'
                ),
                'joins' => array(
                    array(
                        'table' => 'sheet_ride_detail_rides',
                        'type' => 'left',
                        'alias' => 'SheetRideDetailRides',
                        'conditions' => array('DetailPayment.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
                    ),
                    array(
                        'table' => 'payments',
                        'type' => 'left',
                        'alias' => 'Payment',
                        'conditions' => array('DetailPayment.payment_id = Payment.id')
                    )

                )
            ));
        $this->set('detailPayments', $detailPayments);


    }

    /**
     * @param $paymentId
     * create libellé d'un paiement
     */
    public function createAssociationPaymentSheetRides($paymentId)
    {

        $detailPayments = $this->DetailPayment->find('all', array(
            'conditions' => array('DetailPayment.payment_id' => $paymentId),
            'fields' => array('SheetRideDetailRides.reference'),
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'sheet_ride_detail_rides',
                    'type' => 'left',
                    'alias' => 'SheetRideDetailRides',
                    'conditions' => array('DetailPayment.sheet_ride_detail_ride_id = SheetRideDetailRides.id')
                )

            )
        ));
        $wording = '';
        foreach ($detailPayments as $detailPayment) {

            if ($wording == '') {
                $wording = $detailPayment['SheetRideDetailRides']['reference'];
            } else {
                $wording = $wording . ',' . $detailPayment['SheetRideDetailRides']['reference'];
            }
        }
        $this->Payment->id = $paymentId;
        $this->Payment->saveField('wording', $wording);
    }


     /**
     * @param $paymentId
     * create libellé d'un paiement
     */
    public function createAssociationPaymentFuelLogs($paymentId)
    {
        $detailPayments = $this->DetailPayment->find('all', array(
            'conditions' => array('DetailPayment.payment_id' => $paymentId),
            'fields' => array('FuelLog.num_bill'),
            'recursive' => -1,
        ));
        $wording = '';
        foreach ($detailPayments as $detailPayment) {
            if ($wording == '') {
                $wording = $detailPayment['FuelLog']['num_bill'];
            } else {
                $wording = $wording . ',' . $detailPayment['FuelLog']['num_bill'];
            }
        }
        $this->Payment->id = $paymentId;
        $this->Payment->saveField('wording', $wording);
    }




    public function createAssociationPaymentInvoices($paymentId)
    {

        $detailPayments = $this->DetailPayment->find('all', array(
            'conditions' => array('DetailPayment.payment_id' => $paymentId),
            'fields' => array('TransportBill.reference'),
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'transport_bills',
                    'type' => 'left',
                    'alias' => 'TransportBill',
                    'conditions' => array('DetailPayment.transport_bill_id = TransportBill.id')
                )

            )
        ));
        $wording = '';
        foreach ($detailPayments as $detailPayment) {

            if ($wording == '') {
                $wording = $detailPayment['TransportBill']['reference'];
            } else {
                $wording = $wording . ',' . $detailPayment['TransportBill']['reference'];
            }
        }
        $this->Payment->id = $paymentId;
        $this->Payment->saveField('wording', $wording);
    }



    public function createAssociationPaymentReservations($paymentId)
    {

        $detailPayments = $this->DetailPayment->find('all', array(
            'conditions' => array('DetailPayment.payment_id' => $paymentId),
            'fields' => array('SheetRideDetailRide.reference'),
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'reservations',
                    'type' => 'left',
                    'alias' => 'Reservation',
                    'conditions' => array('DetailPayment.reservation_id = Reservation.id')
                ),
                array(
                    'table' => 'sheet_ride_detail_rides',
                    'type' => 'left',
                    'alias' => 'SheetRideDetailRide',
                    'conditions' => array('SheetRideDetailRide.id = Reservation.sheet_ride_detail_ride_id')
                ),
                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('SheetRide.id = SheetRideDetailRide.sheet_ride_id')
                )

            )
        ));
        $wording = '';
        foreach ($detailPayments as $detailPayment) {

            if ($wording == '') {
                $wording = $detailPayment['SheetRideDetailRide']['reference'];
            } else {
                $wording = $wording . ', ' . $detailPayment['SheetRideDetailRide']['reference'];
            }
        }
        $this->Payment->id = $paymentId;
        $this->Payment->saveField('wording', $wording);
    }

    /**
     * @param $paymentId
     * update libellé of payment when we edit payment
     */
    public function updateAssociationPayment($paymentId)
    {
        $this->Payment->id = $paymentId;
        $wording = '';
        $this->Payment->saveField('wording', $wording);
    }

    /**
     * @param null $sheetRideDetailRideIds
     * update amount remaining of missions ();
     */
    public function updateAmountRemainingMissions($sheetRideDetailRideIds = null)
    {
        foreach ($sheetRideDetailRideIds as $sheetRideDetailRideId) {
            $sheetRideDetailRide = $this->SheetRideDetailRides->find('first',
                array(
                    'conditions' => array('SheetRideDetailRides.id' => $sheetRideDetailRideId),
                    'recursive' => -1,
                    'fields' => array('SheetRideDetailRides.mission_cost')
                ));
            $totalPayrollAmount = $this->getTotalPayrollAmountMission($sheetRideDetailRideId);
            $amountRemaining = $sheetRideDetailRide['SheetRideDetailRides']['mission_cost'] - $totalPayrollAmount;
            $this->SheetRideDetailRides->id = $sheetRideDetailRideId;
            $this->SheetRideDetailRides->saveField('amount_remaining', $amountRemaining);
        }
    }

    /**
     * @param null $fuelLogIds
     * update amount remaining of fuelLog ();
     */
    public function updateAmountRemainingFuelLogs($fuelLogIds = null)
    {
        foreach ($fuelLogIds as $fuelLogId) {
            $fuelLog = $this->FuelLog->find('first',
                array(
                    'conditions' => array('FuelLog.id' => $fuelLogId),
                    'recursive' => -1,
                    'fields' => array('FuelLog.price')
                ));
            $totalPayrollAmount = $this->getTotalPayrollAmountFuelLog($fuelLogId);
            $priceRemaining = $fuelLog['FuelLog']['price'] - $totalPayrollAmount;
            $this->FuelLog->id = $fuelLogId;
            $this->FuelLog->saveField('price_remaining', $priceRemaining);
        }
    }

    /**
     * @param null $invoiceIds
     * mettre à jour le montant qui reste à payer pour un ensemble de factures $invoiceIds
     */
    public function updateAmountRemainingInvoices($invoiceIds = null)
    {
        foreach ($invoiceIds as $invoiceId) {
            $invoice = $this->TransportBill->find('first',
                array(
                    'conditions' => array('TransportBill.id' => $invoiceId),
                    'recursive' => -1,
                    'fields' => array('TransportBill.total_ttc')
                ));
            $totalPayrollAmount = $this->getTotalPayrollAmountInvoice($invoiceId);
            if ($totalPayrollAmount > 0) {
                $amountRemaining = $invoice['TransportBill']['total_ttc'] - $totalPayrollAmount;
            } else {
                $amountRemaining = $invoice['TransportBill']['total_ttc'];
            }
            if ($amountRemaining == 0) {
                $status = 2;
            } else {
                if ($amountRemaining == $invoice['TransportBill']['total_ttc']) {
                    $status = 1;
                } else {
                    $status = 3;
                }
            }
            $this->TransportBill->id = $invoiceId;
            $this->TransportBill->saveField('amount_remaining', $amountRemaining);
            $this->TransportBill->id = $invoiceId;
            $this->TransportBill->saveField('status_payment', $status);
        }
    }

    /** created : 09/04/2019
     * @param null $billIds
     * @param null $model
     * mettre à jour le montant qui reste à payer pour un ensemble de bon $bonIds
     */
    public function updateAmountRemainingBills($billIds = null, $model=null)
    {

        $billIds = explode(",", $billIds);

        foreach ($billIds as $billId) {
            $bill = $this->$model->find('first',
                array(
                    'conditions' => array('id' => $billId),
                    'recursive' => -1,
                    'fields' => array('total_ttc')
                ));
            $totalPayrollAmount = $this->DetailPayment->getTotalPayrollAmountBill($billId);
            if ($totalPayrollAmount > 0) {
                $amountRemaining = $bill[$model]['total_ttc'] - $totalPayrollAmount;
            } else {
                $amountRemaining = $bill[$model]['total_ttc'];
            }
            if ($amountRemaining == 0) {
                $status = 2;
            } else {
                if ($amountRemaining == $bill[$model]['total_ttc']) {
                    $status = 1;
                } else {
                    $status = 3;
                }
            }
            $this->$model->id = $billId;
            $this->$model->saveField('amount_remaining', $amountRemaining);
            $this->$model->id = $billId;
            $this->$model->saveField('status_payment', $status);

        }
    }

    public function updateAmountRemainingReservations($reservationIds = null, $paymentAssociationId = null)
    {

        foreach ($reservationIds as $reservationId) {
            $reservation = $this->Reservation->find('first',
                array(
                    'conditions' => array('Reservation.id' => $reservationId),
                    'recursive' => -1,
                    'fields' => array('Reservation.cost')
                ));
            $totalPayrollAmount = $this->getTotalPayrollAmountReservation($reservationId);


            $amountRemaining = $reservation['Reservation']['cost'] - $totalPayrollAmount;

            $this->Reservation->id = $reservationId;
            $this->Reservation->saveField('amount_remaining', $amountRemaining);
       
            $this->updateStatusArticle($reservationId, $paymentAssociationId);
        }
    }


    /**
     * @param $sheetRideDetailRideId
     * get amount payroll for mission $sheetRideDetailRideId
     * @return mixed
     */
    public function getTotalPayrollAmountMission($sheetRideDetailRideId)
    {
        $detailPayments = $this->DetailPayment->find('all', array(
            'conditions' => array('DetailPayment.sheet_ride_detail_ride_id' => $sheetRideDetailRideId),
            'recursive' => -1,
            'fields' => array('sum(DetailPayment.payroll_amount)   AS total_payroll_amount'),
        ));
        $totalPayrollAmount = $detailPayments[0][0]['total_payroll_amount'];

        return $totalPayrollAmount;

    }

    /**
     * @param $fuelLogId
     * get amount payroll for fuelLog $fuelLogId
     * @return mixed
     */
    public function getTotalPayrollAmountFuelLog($fuelLogId)
    {
        $detailPayments = $this->DetailPayment->find('all', array(
            'conditions' => array('DetailPayment.fuel_log_id' => $fuelLogId),
            'recursive' => -1,
            'fields' => array('sum(DetailPayment.payroll_amount)   AS total_payroll_amount'),
        ));
        $totalPayrollAmount = $detailPayments[0][0]['total_payroll_amount'];

        return $totalPayrollAmount;

    }

    /**
     * @param $invoiceId
     * get amount payroll for invoice $invoiceId
     * @return mixed
     */
    public function getTotalPayrollAmountInvoice($invoiceId)
    {
        $detailPayments = $this->DetailPayment->find('all', array(
            'conditions' => array('DetailPayment.transport_bill_id' => $invoiceId),
            'recursive' => -1,
            'fields' => array('sum(DetailPayment.payroll_amount)   AS total_payroll_amount'),
        ));
        $totalPayrollAmount = $detailPayments[0][0]['total_payroll_amount'];

        return $totalPayrollAmount;

    }



    public function getTotalPayrollAmountReservation($reservationId)
    {
        $detailPayments = $this->DetailPayment->find('all', array(
            'conditions' => array('DetailPayment.reservation_id' => $reservationId),
            'recursive' => -1,
            'fields' => array('sum(DetailPayment.payroll_amount)   AS total_payroll_amount'),
        ));
        $totalPayrollAmount = $detailPayments[0][0]['total_payroll_amount'];

        return $totalPayrollAmount;

    }





    /**
     * @param $paymentId
     * @return array
     * return les ids des missions qui corresponde à un paiment $paymentId
     */
    public function getSheetRideDetailRideIds($paymentId)
    {

        $sheetRideDetailRideIds = array();

        $detailPayments = $this->DetailPayment->find('all', array(
            'conditions' => array('DetailPayment.payment_id' => $paymentId),
            'fields' => array('DetailPayment.sheet_ride_detail_ride_id'),
            'recursive' => -1,
        ));
        foreach ($detailPayments as $detailPayment) {
            $sheetRideDetailRideIds[] = $detailPayment['DetailPayment']['sheet_ride_detail_ride_id'];
        }
        return $sheetRideDetailRideIds;
    }


    public function getFuelLogIds($paymentId)
    {

        $fuelLogIds = array();

        $detailPayments = $this->DetailPayment->find('all', array(
            'conditions' => array('DetailPayment.payment_id' => $paymentId),
            'fields' => array('DetailPayment.fuel_log_id'),
            'recursive' => -1,
        ));
        foreach ($detailPayments as $detailPayment) {
            $fuelLogIds[] = $detailPayment['DetailPayment']['fuel_log_id'];
        }
        return $fuelLogIds;
    }




    public function getConsumptionIds($paymentId)
    {

        $consumptionIds = array();

        $detailPayments = $this->DetailPayment->find('all', array(
            'conditions' => array('DetailPayment.payment_id' => $paymentId),
            'fields' => array('DetailPayment.consumption_id'),
            'recursive' => -1,
        ));
        foreach ($detailPayments as $detailPayment) {
            $consumptionIds[] = $detailPayment['DetailPayment']['consumption_id'];
        }
        return $consumptionIds;
    }

    /**
     * @param $paymentId
     * @return array
     * return les ids des factures qui corresponde à un paiment $paymentId
     */
    public function getInvoiceIds($paymentId)
    {

        $invoiceIds = array();

        $detailPayments = $this->DetailPayment->find('all', array(
            'conditions' => array('DetailPayment.payment_id' => $paymentId),
            'fields' => array('DetailPayment.transport_bill_id'),
            'recursive' => -1,
        ));
        foreach ($detailPayments as $detailPayment) {
            $invoiceIds[] = $detailPayment['DetailPayment']['transport_bill_id'];
        }

        return $invoiceIds;

    }

    /**
     * @param $paymentId
     * @return array
     * return les ids des bons qui corresponde à un paiment $paymentId
     */
    public function getBillIds($paymentId)
    {

        $billIds = array();

        $detailPayments = $this->DetailPayment->find('all', array(
            'conditions' => array('DetailPayment.payment_id' => $paymentId),
            'fields' => array('DetailPayment.bill_id'),
            'recursive' => -1,
        ));
        foreach ($detailPayments as $detailPayment) {
            $billIds[] = $detailPayment['DetailPayment']['bill_id'];
        }

        return $billIds;

    }

    public function getReservationIds($paymentId)
    {
        $reservationIds = array();
        $detailPayments = $this->DetailPayment->find('all', array(
            'conditions' => array('DetailPayment.payment_id' => $paymentId),
            'fields' => array('DetailPayment.reservation_id'),
            'recursive' => -1,
        ));
        foreach ($detailPayments as $detailPayment) {
            $reservationIds[] = $detailPayment['DetailPayment']['reservation_id'];
        }


        return $reservationIds;
    }

    public function delete($id = null, $paymentAssociationId = null, $autoRender = true)
    {

        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        $userId = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::journal_tresorerie, $userId, ActionsEnum::delete, "Payments",
            null, "Payment", null);
        $lastBalance = $this->DetailPayment->getBalance($id);
        $this->Payment->id = $id;
        if (!$this->Payment->exists()) {
            throw new NotFoundException(__('Invalid payment'));
        }

        switch ($paymentAssociationId) {
            case PaymentAssociationsEnum::car:
                $payment = $this->Payment->find('first', array(
                    'conditions' => array('Payment.id' => $id),
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
                $precedentCompteId = $payment['Payment']['compte_id'];
                $precedentAmount = $payment['Payment']['amount'];
                $compteId = $payment['Payment']['compte_id'];
                $this->request->allowMethod('post', 'delete');
                if ($this->Payment->delete()) {
                    $this->Compte->updateCompteDebit($compteId, 0, $precedentCompteId, $precedentAmount);
                    if ($autoRender == true) {
                        $this->Flash->success(__('The payment has been deleted.'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        return true;
                    }
                } else {
                    if ($autoRender == true) {
                        $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        return false;
                    }
                }
                break;
            case PaymentAssociationsEnum::event:
                break;
            case PaymentAssociationsEnum::mission_order:
                $payment = $this->Payment->find('first', array(
                    'conditions' => array('Payment.id' => $id),
                    'recursive' => -1,
                    'fields' => array('Payment.id', 'Payment.amount', 'Payment.compte_id', 'Customer.id'),
                    'joins' => array(
                        array(
                            'table' => 'customers',
                            'type' => 'left',
                            'alias' => 'Customer',
                            'conditions' => array('Customer.id = Payment.customer_id')
                        ),
                    )
                ));
                $precedentCompteId = $payment['Payment']['compte_id'];
                $precedentAmount = $payment['Payment']['amount'];
                $sheetRideDetailRideIds = $this->getSheetRideDetailRideIds($id);
                $compteId = $payment['Payment']['compte_id'];
                $customerId = $payment['Customer']['id'];
                $this->request->allowMethod('post', 'delete');
                $this->DetailPayment->deleteAll(array('DetailPayment.payment_id' => $id), false);
                if ($this->Payment->delete()) {

                    $this->Compte->updateCompteDebit($compteId, 0, $precedentCompteId, $precedentAmount);
                    $this->Customer->updateBalanceConductor($customerId, 0, $lastBalance);
                    $this->updateAmountRemainingMissions($sheetRideDetailRideIds);
                    if ($autoRender == true) {
                        $this->Flash->success(__('The payment has been deleted.'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        return true;
                    }
                } else {
                    if ($autoRender == true) {
                        $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        return false;
                    }
                }

                break;


                case PaymentAssociationsEnum::invoice:
                $payment = $this->Payment->find('first', array(
                    'conditions' => array('Payment.id' => $id),
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
                $precedentCompteId = $payment['Payment']['compte_id'];
                $precedentAmount = $payment['Payment']['amount'];
                $invoiceIds = $this->getInvoiceIds($id);
                $compteId = $payment['Payment']['compte_id'];
                $supplierId = $payment['Supplier']['id'];
                $this->request->allowMethod('post', 'delete');
                $this->DetailPayment->deleteAll(array('DetailPayment.payment_id' => $id), false);
                if ($this->Payment->delete()) {

                    $this->Compte->updateCompteCredit($compteId, 0, $precedentCompteId, $precedentAmount);
                    $this->Supplier->updateBalanceClient($supplierId, 0, $lastBalance);
                    $this->updateAmountRemainingInvoices($invoiceIds, $paymentAssociationId);
                    if ($autoRender == true) {
                        $this->Flash->success(__('The payment has been deleted.'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        return true;
                    }
                } else {
                    if ($autoRender == true) {
                        $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        return false;
                    }
                }
                break;


            case PaymentAssociationsEnum::offshore:
                $payment = $this->Payment->find('first', array(
                    'conditions' => array('Payment.id' => $id),
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
                $precedentCompteId = $payment['Payment']['compte_id'];
                $precedentAmount = $payment['Payment']['amount'];
                $reservationIds = $this->getReservationIds($id);
                $compteId = $payment['Payment']['compte_id'];
                $supplierId = $payment['Supplier']['id'];

                $this->request->allowMethod('post', 'delete');
                if ($this->Payment->delete()) {
                    $this->DetailPayment->deleteAll(array('DetailPayment.payment_id' => $id), false);
                    $this->Compte->updateCompteDebit($compteId, 0, $precedentCompteId, $precedentAmount);

                    $this->Supplier->updateBalanceSupplier($supplierId, $precedentAmount, 0);

                    $this->updateAmountRemainingReservations($reservationIds, $paymentAssociationId);
                    if ($autoRender == true) {
                        $this->Flash->success(__('The payment has been deleted.'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        return true;
                    }
                } else {
                    if ($autoRender == true) {
                        $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        return false;
                    }
                }
                break;
            case PaymentAssociationsEnum::preinvoice:
                $payment = $this->Payment->find('first', array(
                    'conditions' => array('Payment.id' => $id),
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
                $precedentCompteId = $payment['Payment']['compte_id'];
                $precedentAmount = $payment['Payment']['amount'];
                $compteId = $payment['Payment']['compte_id'];

                $this->request->allowMethod('post', 'delete');
                if ($this->Payment->delete()) {
                    $this->Compte->updateCompteCredit($compteId, 0, $precedentCompteId, $precedentAmount);
                    if ($autoRender == true) {
                        $this->Flash->success(__('The payment has been deleted.'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        return true;
                    }
                } else {
                    if ($autoRender == true) {
                        $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        return false;
                    }
                }
                break;
            case PaymentAssociationsEnum::cashing:
                $payment = $this->Payment->find('first', array(
                    'conditions' => array('Payment.id' => $id),
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
                $precedentCompteId = $payment['Payment']['compte_id'];
                $precedentAmount = $payment['Payment']['amount'];
                $compteId = $payment['Payment']['compte_id'];

                $this->request->allowMethod('post', 'delete');
                if ($this->Payment->delete()) {
                    $this->Compte->updateCompteCredit($compteId, 0, $precedentCompteId, $precedentAmount);
                    if ($autoRender == true) {
                        $this->Flash->success(__('The payment has been deleted.'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        return true;
                    }
                } else {
                    if ($autoRender == true) {
                        $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        return false;
                    }
                }
                break;
            case PaymentAssociationsEnum::disbursement:
                $payment = $this->Payment->find('first', array(
                    'conditions' => array('Payment.id' => $id),
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
                $precedentCompteId = $payment['Payment']['compte_id'];
                $precedentAmount = $payment['Payment']['amount'];
                $compteId = $payment['Payment']['compte_id'];
                $this->request->allowMethod('post', 'delete');
                if ($this->Payment->delete()) {
                    $this->Compte->updateCompteDebit($compteId, 0, $precedentCompteId, $precedentAmount);
                    if ($autoRender == true) {
                        $this->Flash->success(__('The payment has been deleted.'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        return true;
                    }
                } else {
                    if ($autoRender == true) {
                        $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        return false;
                    }
                }
                break;

            case PaymentAssociationsEnum::bill:
                $payment = $this->Payment->find('first', array(
                    'conditions' => array('Payment.id' => $id),
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
                $precedentCompteId = $payment['Payment']['compte_id'];
                $precedentAmount = $payment['Payment']['amount'];
                $billIds = $this->getBillIds($id);
                $typeBill = $this->Bill->getTypeBill($billIds[0]);
                $compteId = $payment['Payment']['compte_id'];
                $supplierId = $payment['Supplier']['id'];
                $this->request->allowMethod('post', 'delete');
                $this->DetailPayment->deleteAll(array('DetailPayment.payment_id' => $id), false);
                if ($this->Payment->delete()) {

                    switch ($typeBill){
                        case BillTypesEnum::receipt :
                        case BillTypesEnum::return_customer :
                        case BillTypesEnum::entry_order :
                        case BillTypesEnum::reintegration_order :
                        case BillTypesEnum::sale_credit_note :
                        case BillTypesEnum::purchase_invoice :
                            $this->Compte->updateCompteDebit($compteId, $precedentAmount);
                            $this->Supplier->updateBalanceSupplier($supplierId, 0, $lastBalance);
                            break;
                        case BillTypesEnum::delivery_order :
                        case BillTypesEnum::return_supplier :
                        case BillTypesEnum::exit_order :
                        case BillTypesEnum::renvoi_order :
                        case BillTypesEnum::credit_note :
                        case BillTypesEnum::sales_invoice :
                            $this->Compte->updateCompteCredit($compteId, $precedentAmount);
                            $this->Supplier->updateBalanceClient($supplierId, 0, $lastBalance);
                            break;
                    }


                    $this->updateAmountRemainingBills($billIds, $paymentAssociationId);
                    if ($autoRender == true) {
                        $this->Flash->success(__('The payment has been deleted.'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        return true;
                    }
                } else {
                    if ($autoRender == true) {
                        $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        return false;
                    }
                }
                break;

            case PaymentAssociationsEnum::consumption_species:
                $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
                $this->redirect(array('action' => 'index'));
            break;

            case PaymentAssociationsEnum::fuel_log:
                $payment = $this->Payment->find('first', array(
                    'conditions' => array('Payment.id' => $id),
                    'recursive' => -1,
                    'fields' => array('Payment.id', 'Payment.amount', 'Payment.compte_id'),

                    ));
                $precedentCompteId = $payment['Payment']['compte_id'];
                $precedentAmount = $payment['Payment']['amount'];
                $fuelLogIds = $this->getFuelLogIds($id);
                $compteId = $payment['Payment']['compte_id'];
                $this->request->allowMethod('post', 'delete');
                $this->DetailPayment->deleteAll(array('DetailPayment.payment_id' => $id), false);
                if ($this->Payment->delete()) {

                    $this->Compte->updateCompteDebit($compteId, 0, $precedentCompteId, $precedentAmount);

                    $this->updateAmountRemainingFuelLogs($fuelLogIds);
                    if ($autoRender == true) {
                        $this->Flash->success(__('The payment has been deleted.'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        return true;
                    }
                } else {
                    if ($autoRender == true) {
                        $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        return false;
                    }
                }

                break;



        }
    }

    public function deletePayments()
    {
        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        if (Configure::read("cafyb") == '1') {
            if($this->Session->read('Permission.payment.delete')==0){
                $this->Flash->error(__("You don't have permission to delete."));
                return $this->redirect(array('controller' => 'payments', 'action' => 'index'));

            }else {
                $this->Auth->allow();
                $id = filter_input(INPUT_POST, "id");
                $this->Cafyb->deletePayment($id);


            }
        }else {
            $this->autoRender = false;
            $id = filter_input(INPUT_POST, "id");

            $payment = $this->Payment->find('first', array(
                'recursive' => -1,
                'conditions' => array('Payment.id' => $id),
                'fields' => array('Payment.payment_association_id')
            ));



            $paymentAssociationId = $payment['Payment']['payment_association_id'];
            if ($this->delete($id, $paymentAssociationId, false)) {
                echo json_encode(array("response" => "true"));
            } else {
                echo json_encode(array("response" => "false"));
            }
        }


    }

    public function getSumCredit($conditions = null)
    {
        $conditionTransactType = array('Payment.transact_type_id' => 1);
        if ($conditions != null) {
            $conditions = array_merge($conditions, $conditionTransactType);
        } else {
            $conditions = $conditionTransactType;
        }
        $payments = $this->Payment->find('all', array(
            'recursive' => -1,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'fields' => array(
                'sum(Payment.amount)   AS total_amount'
            ),
            'joins' => array(
                array(
                    'table' => 'comptes',
                    'type' => 'left',
                    'alias' => 'Compte',
                    'conditions' => array('Compte.id = Payment.compte_id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Customer.id = Payment.customer_id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Car.id = Payment.car_id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Supplier.id = Payment.supplier_id')
                ),
                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Event',
                    'conditions' => array('Event.id = Payment.event_id')
                ),
                array(
                    'table' => 'interferings',
                    'type' => 'left',
                    'alias' => 'Interfering',
                    'conditions' => array('Interfering.id = Payment.interfering_id')
                ),
                array(
                    'table' => 'payment_associations',
                    'type' => 'left',
                    'alias' => 'PaymentAssociation',
                    'conditions' => array('PaymentAssociation.id = Payment.payment_association_id')
                ),
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'User',
                    'conditions' => array('User.id = Payment.user_id')
                ),
                array(
                    'table' => 'profiles',
                    'type' => 'left',
                    'alias' => 'Profile',
                    'conditions' => array('Profile.id = User.profile_id')
                ),
            )

        ));
        $sumCredits = $payments[0][0]['total_amount'];
        return $sumCredits;
    }

    public function getSumDebit($conditions = null)
    {

        $conditionTransactType = array('Payment.transact_type_id' => 2);
        if ($conditions != null) {
            $conditions = array_merge($conditions, $conditionTransactType);
        } else {
            $conditions = $conditionTransactType;
        }

        $payments = $this->Payment->find('all', array(
            'recursive' => -1,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'fields' => array(
                'sum(Payment.amount)   AS total_amount'
            ),
            'joins' => array(
                array(
                    'table' => 'comptes',
                    'type' => 'left',
                    'alias' => 'Compte',
                    'conditions' => array('Compte.id = Payment.compte_id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Customer.id = Payment.customer_id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Car.id = Payment.car_id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Supplier.id = Payment.supplier_id')
                ),
                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Event',
                    'conditions' => array('Event.id = Payment.event_id')
                ),
                array(
                    'table' => 'interferings',
                    'type' => 'left',
                    'alias' => 'Interfering',
                    'conditions' => array('Interfering.id = Payment.interfering_id')
                ),
                array(
                    'table' => 'payment_associations',
                    'type' => 'left',
                    'alias' => 'PaymentAssociation',
                    'conditions' => array('PaymentAssociation.id = Payment.payment_association_id')
                ),
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'User',
                    'conditions' => array('User.id = Payment.user_id')
                ),
                array(
                    'table' => 'profiles',
                    'type' => 'left',
                    'alias' => 'Profile',
                    'conditions' => array('Profile.id = User.profile_id')
                ),
            )

        ));
        $sumDebits = $payments[0][0]['total_amount'];
        return $sumDebits;
    }

    public function getSumPayments($conditions)
    {
        $payments = $this->Payment->find('all', array(

            'recursive' => -1,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'fields' => array(
                'sum(Payment.amount)   AS total_amount'
            ),
            'joins' => array(
                array(
                    'table' => 'comptes',
                    'type' => 'left',
                    'alias' => 'Compte',
                    'conditions' => array('Compte.id = Payment.compte_id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Customer.id = Payment.customer_id')
                ),
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'User',
                    'conditions' => array('User.id = Payment.user_id')
                ),
                array(
                    'table' => 'profiles',
                    'type' => 'left',
                    'alias' => 'Profile',
                    'conditions' => array('Profile.id = User.profile_id')
                ),

            )

        ));
        $sumPayments = $payments[0][0]['total_amount'];
        return $sumPayments;

    }

    public function updateStatusArticle($articleId = null, $paymentAssociationId = null)
    {
        switch ($paymentAssociationId) {
            case PaymentAssociationsEnum::car:
                break;
            case PaymentAssociationsEnum::event:
                break;
            case PaymentAssociationsEnum::mission_order:
                break;
            case PaymentAssociationsEnum::credit_note:
                $invoice = $this->TransportBill->find('first', array(
                    'conditions' => array('TransportBill.id' => $articleId),
                    'fields' => array('TransportBill.id', 'TransportBill.total_ttc', 'TransportBill.amount_remaining')
                ));
                if (!empty($invoice)) {
                    if ($invoice['TransportBill']['amount_remaining'] > 0) {
                        if ($invoice['TransportBill']['amount_remaining'] == $invoice['TransportBill']['total_ttc']) {
                            $payed = 1;
                        } else {
                            $payed = 3;
                        }
                    } else {
                        $payed = 2;
                    }
                    $this->TransportBill->id = $invoice['TransportBill']['id'];
                    $this->TransportBill->saveField('status_payment', $payed);
                }
                break;
            case PaymentAssociationsEnum::invoice:
                $invoice = $this->TransportBill->find('first', array(
                    'conditions' => array('TransportBill.id' => $articleId),
                    'fields' => array('TransportBill.id', 'TransportBill.total_ttc', 'TransportBill.amount_remaining')
                ));
                $creditNote = $this->TransportBill->find('first', array(
                    'conditions' => array('TransportBill.invoice_id' => $articleId),
                    'fields' => array('TransportBill.id', 'TransportBill.total_ttc', 'TransportBill.amount_remaining')
                ));
                $invoiceAmountRemaining = $invoice['TransportBill']['amount_remaining'];
                if(!empty($creditNote)){
                    if(isset($creditNote['TransportBill']['amount_remaining'])){
                        $invoiceAmountRemaining = $invoiceAmountRemaining - $creditNote['TransportBill']['amount_remaining'];
                    }
                }
                if (!empty($invoice)) {
                    if ($invoiceAmountRemaining > 0) {
                        if ($invoiceAmountRemaining == $invoice['TransportBill']['total_ttc']) {
                            $payed = 1;
                        } else {
                            $payed = 3;
                        }
                    } else {
                        $payed = 2;
                    }
                    $this->TransportBill->id = $invoice['TransportBill']['id'];
                    $this->TransportBill->saveField('status_payment', $payed);
                }
                break;
            case PaymentAssociationsEnum::offshore:
                $reservation = $this->Reservation->find('first', array(
                    'conditions' => array('Reservation.id' => $articleId),
                    'fields' => array('Reservation.id', 'Reservation.amount_remaining', 'Reservation.cost')
                ));
                if (!empty($reservation)) {
                    if ($reservation['Reservation']['amount_remaining'] > 0) {
                        if ($reservation['Reservation']['cost'] == $reservation['Reservation']['amount_remaining']) {
                            $payed = 1;
                        } else {
                            $payed = 3;
                        }

                    } else {
                        $payed = 2;
                    }
                    $this->Reservation->id = $reservation['Reservation']['id'];
                    $this->Reservation->saveField('status', $payed);
                }
                break;
            case PaymentAssociationsEnum::preinvoice:
                $invoice = $this->TransportBill->find('first', array(
                    'conditions' => array('TransportBill.id' => $articleId),
                    'fields' => array('TransportBill.id', 'TransportBill.total_ttc', 'TransportBill.amount_remaining')
                ));
                if (!empty($invoice)) {
                    if ($invoice['TransportBill']['amount_remaining'] > 0) {
                        if ($invoice['TransportBill']['amount_remaining'] == $invoice['TransportBill']['total_ttc']) {
                            $payed = 1;
                        } else {
                            $payed = 3;
                        }
                    } else {
                        $payed = 2;
                    }
                    $this->TransportBill->id = $invoice['TransportBill']['id'];
                    $this->TransportBill->saveField('status_payment', $payed);
                }
                break;
            case PaymentAssociationsEnum::bill :
                $bill = $this->Bill->find('first', array(
                    'conditions' => array('Bill.id' => $articleId),
                    'fields' => array('Bill.id', 'Bill.total_ttc', 'Bill.amount_remaining')
                ));
                if (!empty($bill)) {
                    if ($bill['Bill']['amount_remaining'] > 0) {
                        if ($bill['Bill']['amount_remaining'] == $bill['Bill']['total_ttc']) {
                            $payed = 1;
                        } else {
                            $payed = 3;
                        }
                    } else {
                        $payed = 2;
                    }
                    $this->Bill->id = $bill['Bill']['id'];
                    $this->Bill->saveField('status_payment', $payed);
                }
                break;
        }
    }

    public function addCashing()
    {

        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        if (Configure::read("cafyb") == '1') {
            if($this->Session->read('Permission.payment.encaissement')==0){
                $this->Flash->error(__("You don't have permission to add."));
                return $this->redirect(array('controller' => 'payments', 'action' => 'index'));

            }else {
                $this->Auth->allow();

                if ($this->request->is('post')) {
                    $payment = $this->request->data['Payment'];
                    $this->Cafyb->savePayment($payment);

                }



                $comptes = $this->Cafyb->getComptes();
                $suppliers = $this->Cafyb->getTiers();
                $paymentCategories = $this->Cafyb->getPaymentCategories();

                $this->set(compact('comptes', 'suppliers','paymentCategories'));

            }
        } else {
            $userId = $this->Auth->user('id');
            $this->verifyUserPermission(SectionsEnum::encaissement, $userId, ActionsEnum::add, "Payments", null, "Payment", null);

            if ($this->request->is('post')) {
                $this->Payment->create();
                $this->createDateFromDate('Payment', 'operation_date');
                $this->createDateFromDate('Payment', 'receipt_date');
                $this->createDateFromDate('Payment', 'value_date');
                $this->request->data['Payment']['transact_type_id'] == 1;
                $this->request->data['Payment']['payment_association_id'] == 7;

                if ($this->Payment->save($this->request->data)) {
                    $compteId = $this->request->data['Payment']['compte_id'];
                    $amount = $this->request->data['Payment']['amount'];

                    $this->Compte->updateCompteCredit($compteId, $amount);
                    $this->Flash->success(__('The cashing has been saved.'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->success(__('The cashing could not be saved. Please, try again.'));
                    $this->redirect(array('action' => 'index'));
                }
            }



            $comptes = $this->Payment->Compte->find('list', array('order' => 'num_compte'));
            $suppliers = $this->Supplier->getActiveSuppliers();
            $paymentCategories = $this->PaymentCategory->getPaymentCategories('list');

            $this->set(compact('comptes', 'suppliers','paymentCategories'));
        }


    }

    public function addDisbursement()
    {
        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        if (Configure::read("cafyb") == '1') {
            if($this->Session->read('Permission.payment.decaissement')==0){
                $this->Flash->error(__("You don't have permission to add."));
                return $this->redirect(array('controller' => 'payments', 'action' => 'index'));

            }else {
                $this->Auth->allow();

                if ($this->request->is('post')) {
                    $payment = $this->request->data['Payment'];
                    $this->Cafyb->savePayment($payment);

                }
                $comptes = $this->Cafyb->getComptes();
                $suppliers = $this->Cafyb->getTiers();
                $paymentCategories = $this->Cafyb->getPaymentCategories();

                $this->set(compact('comptes', 'suppliers','paymentCategories'));

            }
        }else {
            $userId = $this->Auth->user('id');
            $this->verifyUserPermission(SectionsEnum::decaissement, $userId, ActionsEnum::add, "Payments", null, "Payment", null);
            if ($this->request->is('post')) {
                $this->Payment->create();
                $this->createDateFromDate('Payment', 'operation_date');
                $this->createDateFromDate('Payment', 'receipt_date');
                $this->createDateFromDate('Payment', 'value_date');
                $this->request->data['Payment']['transact_type_id'] = 2;
                $this->request->data['Payment']['payment_association_id'] == 8;
                if ($this->Payment->save($this->request->data)) {
                    $compteId = $this->request->data['Payment']['compte_id'];
                    $amount = $this->request->data['Payment']['amount'];

                    $this->Compte->updateCompteDebit($compteId, $amount);
                    $this->Flash->success(__('The disbursement has been saved.'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->error(__('The disbursement could not be saved. Please, try again.'));
                    $this->redirect(array('action' => 'index'));
                }
            }
            $comptes = $this->Payment->Compte->find('list', array('order' => 'num_compte'));
            $suppliers = $this->Supplier->getActiveSuppliers();
            $paymentCategories = $this->PaymentCategory->getPaymentCategories('list');
            $this->set(compact('comptes', 'suppliers','paymentCategories'));
        }


    }

    public function advancedPayment($ids = null, $type = null, $paymentAssociationId = null)
    {
        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        $this->set('paymentAssociationId',$paymentAssociationId);
        $this->set('billIds',$ids);
        if($paymentAssociationId == 9){
            $model = 'Bill';
            $this->set('model',$model);
            $billIds = explode(",", $ids);
            $this->verifyTypeBills($type, $billIds);
            $bills = $this->Bill->find('all', array(
                'recursive' => -1,
                'conditions' => array('Bill.id' => $billIds),
                'fields' => array(
                    'Bill.id',
                    'Bill.supplier_id',
                    'sum(Bill.amount_remaining) as total_amount_remaining',
                    'sum(Bill.total_ttc) as total_amount',
                )));
            $supplierId = $bills[0]['Bill']['supplier_id'];
            $totalAmountRemaining = $bills[0][0]['total_amount_remaining'];
            $totalAmount = $bills[0][0]['total_amount'];

            if (!empty($this->request->data)) {
                $paymentIds = explode(",", $this->request->data['Payment']['ids']);
                $j = 0;
                $nbBills = count($billIds);
                $save = true;
                foreach ($paymentIds as $paymentId) {
                    $payment = $this->Payment->find('first', array(
                        'recursive' => -1,
                        'conditions' => array(
                            'Payment.supplier_id' => $supplierId,
                            'Payment.id' => $paymentId,
                            'DetailPayment.payment_id IS NULL'
                        ),
                        'fields' => array(
                            'Payment.id',
                            'Payment.operation_date',
                            'Payment.receipt_date',
                            'Payment.value_date',
                            'Payment.amount',
                            'Payment.wording',
                            'Payment.payment_type'
                        ),
                        'joins' => array(
                            array(
                                'table' => 'detail_payments',
                                'type' => 'left',
                                'alias' => 'DetailPayment',
                                'conditions' => array('DetailPayment.payment_id = Payment.id')
                            )
                        )
                    ));
                    if (!empty($payment)) {
                        $payrollAmount = $payment['Payment']['amount'];
                    } else {
                        $payment = $this->Payment->find('first', array(
                            'recursive' => -1,
                            'conditions' => array('Payment.supplier_id' => $supplierId, 'Payment.id' => $paymentId),
                            'fields' => array(
                                'Payment.id',
                                'Payment.operation_date',
                                'Payment.receipt_date',
                                'Payment.value_date',
                                'Payment.amount',
                                'Payment.wording',
                                'Payment.payment_type',
                                'SUM(DetailPayment.payroll_amount) as sum_payroll_amount'
                            ),
                            'group' => array(
                                'Payment.id HAVING (sum_payroll_amount < Payment.amount)'
                            ),
                            'joins' => array(
                                array(
                                    'table' => 'detail_payments',
                                    'type' => 'left',
                                    'alias' => 'DetailPayment',
                                    'conditions' => array('DetailPayment.payment_id = Payment.id')
                                )
                            )
                        ));
                        if (!empty($payment)) {
                            $payrollAmount = $payment['Payment']['amount'] - $payment[0]['sum_payroll_amount'];
                        }
                    }


                    while ($payrollAmount > 0 && $j < $nbBills) {

                        $billId = $billIds[$j];
                        $bill = $this->Bill->find('first', array(
                            'recursive' => -1,
                            'fields' => array('Bill.id', 'Bill.amount_remaining'),
                            'conditions' => array('Bill.id' => $billId)
                        ));
                        $this->DetailPayment->create();
                        $amountRemainingInvoice = $bill['Bill']['amount_remaining'];
                        $invoiceId = $bill['Bill']['id'];
                        $data['DetailPayment']['payment_id'] = $paymentId;
                        $data['DetailPayment']['bill_id'] = $invoiceId;
                        if ($payrollAmount >= $amountRemainingInvoice) {
                            $data['DetailPayment']['payroll_amount'] = $amountRemainingInvoice;
                            $amountRemaining = 0;
                            $payrollAmount = $payrollAmount - $amountRemainingInvoice;
                        } else {
                            $data['DetailPayment']['payroll_amount'] = $payrollAmount;
                            $amountRemaining = $amountRemainingInvoice - $payrollAmount;
                            $payrollAmount = 0;
                        }
                        if ($this->DetailPayment->save($data)) {
                            $save = true;
                            $this->Bill->id = $invoiceId;
                            $this->Bill->saveField('amount_remaining', $amountRemaining);
                            $this->updateStatusArticle($invoiceId, 4);
                        } else {
                            $save = false;
                        }
                        if ($save == false) {
                            $this->Flash->error(__('The payment could not be saved. Please, try again.'));
                            return $this->redirect(array('controller' => 'bills', 'action' => 'index', $type));
                        }
                        if ($amountRemaining == 0) {
                            $j++;
                        }

                    }
                    $paymentAssociationId = PaymentAssociationsEnum::bill;

                    $this->Payment->id = $paymentId;
                    $this->Payment->saveField('payment_association_id', $paymentAssociationId);
                    $this->createAssociationPaymentInvoices($paymentId);
                }
                if ($save == true) {
                    $this->Flash->success(__('The payment has been saved.'));
                    return $this->redirect(array('controller' => 'bills', 'action' => 'index', $type));

                }


            }



        }else {
            $model = 'TransportBill';
            $this->set('model',$model);
            $transportBillIds = explode(",", $ids);
            $transportBill = $this->TransportBill->find('all', array(
                'recursive' => -1,
                'conditions' => array('TransportBill.id' => $transportBillIds),
                'fields' => array(
                    'TransportBill.id',
                    'TransportBill.supplier_id',
                    'sum(TransportBill.amount_remaining) as total_amount_remaining',
                    'sum(TransportBill.total_ttc) as total_amount',
                ),
            ));
            $supplierId = $transportBill[0]['TransportBill']['supplier_id'];
            $totalAmountRemaining = $transportBill[0][0]['total_amount_remaining'];
            $totalAmount = $transportBill[0][0]['total_amount'];
            if (!empty($this->request->data)) {
                $paymentIds = explode(",", $this->request->data['Payment']['ids']);
                $j = 0;
                $nbTransportBills = count($transportBillIds);
                $save = true;
                foreach ($paymentIds as $paymentId) {
                    $payment = $this->Payment->find('first', array(
                        'recursive' => -1,
                        'conditions' => array(
                            'Payment.supplier_id' => $supplierId,
                            'Payment.id' => $paymentId,
                            'DetailPayment.payment_id IS NULL'
                        ),
                        'fields' => array(
                            'Payment.id',
                            'Payment.operation_date',
                            'Payment.receipt_date',
                            'Payment.value_date',
                            'Payment.amount',
                            'Payment.wording',
                            'Payment.payment_type'
                        ),
                        'joins' => array(
                            array(
                                'table' => 'detail_payments',
                                'type' => 'left',
                                'alias' => 'DetailPayment',
                                'conditions' => array('DetailPayment.payment_id = Payment.id')
                            )
                        )
                    ));
                    if (!empty($payment)) {
                        $payrollAmount = $payment['Payment']['amount'];
                    } else {
                        $payment = $this->Payment->find('first', array(
                            'recursive' => -1,
                            'conditions' => array('Payment.supplier_id' => $supplierId, 'Payment.id' => $paymentId),
                            'fields' => array(
                                'Payment.id',
                                'Payment.operation_date',
                                'Payment.receipt_date',
                                'Payment.value_date',
                                'Payment.amount',
                                'Payment.wording',
                                'Payment.payment_type',
                                'SUM(DetailPayment.payroll_amount) as sum_payroll_amount'
                            ),
                            'group' => array(
                                'Payment.id HAVING (sum_payroll_amount < Payment.amount)'
                            ),
                            'joins' => array(
                                array(
                                    'table' => 'detail_payments',
                                    'type' => 'left',
                                    'alias' => 'DetailPayment',
                                    'conditions' => array('DetailPayment.payment_id = Payment.id')
                                )
                            )
                        ));
                        if (!empty($payment)) {
                            $payrollAmount = $payment['Payment']['amount'] - $payment[0]['sum_payroll_amount'];
                        }
                    }


                    while ($payrollAmount > 0 && $j < $nbTransportBills) {

                        $transportBillId = $transportBillIds[$j];
                        $transportBill = $this->TransportBill->find('first', array(
                            'recursive' => -1,
                            'fields' => array('TransportBill.id', 'TransportBill.amount_remaining'),
                            'conditions' => array('TransportBill.id' => $transportBillId)
                        ));
                        $this->DetailPayment->create();
                        $amountRemainingInvoice = $transportBill['TransportBill']['amount_remaining'];
                        $invoiceId = $transportBill['TransportBill']['id'];
                        $data['DetailPayment']['payment_id'] = $paymentId;
                        $data['DetailPayment']['transport_bill_id'] = $invoiceId;
                        if ($payrollAmount >= $amountRemainingInvoice) {
                            $data['DetailPayment']['payroll_amount'] = $amountRemainingInvoice;
                            $amountRemaining = 0;
                            $payrollAmount = $payrollAmount - $amountRemainingInvoice;
                        } else {
                            $data['DetailPayment']['payroll_amount'] = $payrollAmount;
                            $amountRemaining = $amountRemainingInvoice - $payrollAmount;
                            $payrollAmount = 0;
                        }
                        if ($this->DetailPayment->save($data)) {
                            $save = true;
                            $this->TransportBill->id = $invoiceId;
                            $this->TransportBill->saveField('amount_remaining', $amountRemaining);
                            $this->updateStatusArticle($invoiceId, 4);
                        } else {
                            $save = false;
                        }
                        if ($save == false) {
                            $this->Flash->error(__('The payment could not be saved. Please, try again.'));
                            return $this->redirect(array('controller' => 'transportBills', 'action' => 'index', $type));
                        }
                        if ($amountRemaining == 0) {
                            $j++;
                        }

                    }
                    if ($type == 4) {
                        $paymentAssociationId = PaymentAssociationsEnum::preinvoice;
                    } else {
                        $paymentAssociationId = PaymentAssociationsEnum::invoice;
                    }
                    $this->Payment->id = $paymentId;
                    $this->Payment->saveField('payment_association_id', $paymentAssociationId);
                    $this->createAssociationPaymentInvoices($paymentId);
                }
                if ($save == true) {
                    $this->Flash->success(__('The payment has been saved.'));
                    return $this->redirect(array('controller' => 'transportBills', 'action' => 'index', $type));

                }


            }


        }

        $advancedPayments = $this->Payment->getAdvancedPaymentsBySupplierId($supplierId);
        $remainingPayments = $this->Payment->getPaymentsWithOverAmountBySupplierId($supplierId);

        if($paymentAssociationId == 9){
            $paymentParts = $this->Payment->getPaymentPartsByBillIds($billIds);

        }else {

            $paymentParts = $this->Payment->getPaymentPartsByTransportBillIds($transportBillIds);

        }


        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('advancedPayments', 'remainingPayments', 'separatorAmount', 'paymentParts',
            'totalAmountRemaining', 'totalAmount'));

    }

    //Reports functions
    public function printSimplifiedJournal()
    {
        $hasModuleTresorery = $this->hasModuleTresorerie();
        if ($hasModuleTresorery == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        $array = filter_input(INPUT_POST, "printSimplifiedJournal");
        $arrayConditions = explode(",", $array);
        $supplierId = $arrayConditions[0];
        $startDate = $arrayConditions[1];
        $endDate = $arrayConditions[2];
        $clientId = $arrayConditions[3];
        $interferingId = $arrayConditions[4];
        $customerId = $arrayConditions[5];
        $compteId = $arrayConditions[6];
        $paymentType = $arrayConditions[7];
        $amount	= $arrayConditions[8];
        //$type = filter_input(INPUT_POST, "typePiece");
        if (!empty($clientId)) {
            $conditions["Client.id"] = $clientId;
        }
        if (!empty($supplierId)) {
            $conditions["Supplier.id"] = $supplierId;
        }
        if (!empty($startDate)) {
            $date_from = str_replace("/", "-", $startDate);
            $start = str_replace("-", "/", $date_from);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $conditions["Payment.operation_date >="] = $startdtm->format('Y-m-d H:i:s');
        }
        if (!empty($endDate)) {
            $date_to = str_replace("/", "-", $endDate);
            $end = str_replace("-", "/", $date_to);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $conditions["Payment.operation_date <="] = $enddtm->format('Y-m-d H:i:s');
        }
        //CLIENT
        if (!empty($interferingId)) {
            $conditions["Payment.interfering_id"] = $interferingId;
        }
        if (!empty($customerId)) {
            $conditions["Payment.customer_id"] = $customerId;
        }
        if (!empty($compteId)) {
            $conditions["Payment.compte_id"] = $compteId;
        }
        if (!empty($paymentType)) {
            $conditions["Payment.payment_type"] = $paymentType;
        }
        if (!empty($amount)) {
            $conditions["Payment.amount"] = $amount;
        }

        $ids = filter_input(INPUT_POST, "chkids");
        if (!empty($ids)) {
            $array_ids = explode(",", $ids);
            if (!empty($array_ids)) {
                $conditions["Payment.id"] = $array_ids;
            }
        }

        $payments = $this->Payment->getPaymentsByConditions($conditions);

        $company = $this->Company->find('first');
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('payments', 'company', 'separatorAmount'));

    }

    public function printDetailedJournal()
    {
        $hasModuleTresorery = $this->hasModuleTresorerie();
        if ($hasModuleTresorery == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        $array = filter_input(INPUT_POST, "printDetailedJournal");
        $arrayConditions = explode(",", $array);
        $supplierId = $arrayConditions[0];
        $startDate = $arrayConditions[1];
        $endDate = $arrayConditions[2];
        $clientId	= $arrayConditions[3];
        $interferingId = $arrayConditions[4];
        $customerId = $arrayConditions[5];
        $compte = $arrayConditions[6];
        $paymentType = $arrayConditions[7];
        $amount	= $arrayConditions[8];
        $conditions = array();
        if (!empty($supplierId)) {
            $conditions["Supplier.id"] = $supplierId;
        }
        if (!empty($startDate)) {
            $date_from = str_replace("/", "-", $startDate);
            $start = str_replace("-", "/", $date_from);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $conditions["Payment.date >="] = $startdtm->format('Y-m-d H:i:s');
        }
        if (!empty($endDate)) {
            $date_to = str_replace("/", "-", $endDate);
            $end = str_replace("-", "/", $date_to);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $conditions["Payment.date <="] = $enddtm->format('Y-m-d H:i:s');
        }
        $ids = filter_input(INPUT_POST, "chkids");
        if (!empty($ids)) {
            $array_ids = explode(",", $ids);
            if (!empty($array_ids)) {
                $conditions["Payment.id"] = $array_ids;
            }
        }

        $payments = $this->Payment->getPaymentsByConditions($conditions);

        $company = $this->Company->find('first');
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('payments', 'company', 'separatorAmount'));

    }
    // End reports functions

    /** associate amount of advanced payment to transport bill
     * @param null $transportBillId
     * @param null $paymentAssociationId
     * @throws Exception
     */

    public function associateAdvancedPaymentToTransportBill($transportBillId = null, $paymentAssociationId = null)
    {
        $this->autoRender = false;
        $ids = filter_input(INPUT_POST, "ids");
        $paymentIds = explode(",", $ids);

        $transportBill = $this->TransportBill->getTransportBillById($transportBillId);
        $supplierId = $transportBill['TransportBill']['supplier_id'];
        $j = 0;
        $nbTransportBills = 1;
        $save = true;
        foreach ($paymentIds as $paymentId) {
            $payment = $this->Payment->find('first', array(
                'recursive' => -1,
                'conditions' => array(
                    'Payment.supplier_id' => $supplierId,
                    'Payment.id' => $paymentId,
                    'DetailPayment.payment_id IS NULL'
                ),
                'fields' => array(
                    'Payment.id',
                    'Payment.operation_date',
                    'Payment.receipt_date',
                    'Payment.value_date',
                    'Payment.amount',
                    'Payment.wording',
                    'Payment.payment_type'
                ),
                'joins' => array(
                    array(
                        'table' => 'detail_payments',
                        'type' => 'left',
                        'alias' => 'DetailPayment',
                        'conditions' => array('DetailPayment.payment_id = Payment.id')
                    )
                )
            ));

            if (!empty($payment)) {
                $payrollAmount = $payment['Payment']['amount'];
            } else {
                $payment = $this->Payment->find('first', array(
                    'recursive' => -1,
                    'conditions' => array('Payment.supplier_id' => $supplierId, 'Payment.id' => $paymentId),
                    'fields' => array(
                        'Payment.id',
                        'Payment.operation_date',
                        'Payment.receipt_date',
                        'Payment.value_date',
                        'Payment.amount',
                        'Payment.wording',
                        'Payment.payment_type',
                        'SUM(DetailPayment.payroll_amount) as sum_payroll_amount'
                    ),
                    'group' => array(
                        'Payment.id HAVING (sum_payroll_amount < Payment.amount)'
                    ),
                    'joins' => array(
                        array(
                            'table' => 'detail_payments',
                            'type' => 'left',
                            'alias' => 'DetailPayment',
                            'conditions' => array('DetailPayment.payment_id = Payment.id')
                        )
                    )
                ));
                if (!empty($payment)) {
                    $payrollAmount = $payment['Payment']['amount'] - $payment[0]['sum_payroll_amount'];
                }
            }


            while ($payrollAmount > 0 && $j < $nbTransportBills) {
                $this->DetailPayment->create();
                $amountRemainingInvoice = $transportBill['TransportBill']['amount_remaining'];
                $invoiceId = $transportBill['TransportBill']['id'];
                $data['DetailPayment']['payment_id'] = $paymentId;
                $data['DetailPayment']['transport_bill_id'] = $invoiceId;
                if ($payrollAmount >= $amountRemainingInvoice) {
                    $data['DetailPayment']['payroll_amount'] = $amountRemainingInvoice;
                    $amountRemaining = 0;
                    $payrollAmount = $payrollAmount - $amountRemainingInvoice;
                } else {
                    $data['DetailPayment']['payroll_amount'] = $payrollAmount;
                    $amountRemaining = $amountRemainingInvoice - $payrollAmount;
                    $payrollAmount = 0;
                }
                if ($this->DetailPayment->save($data)) {
                    $save = true;
                    $this->TransportBill->id = $invoiceId;
                    $this->TransportBill->saveField('amount_remaining', $amountRemaining);
                    $this->updateStatusArticle($invoiceId, 4);
                } else {
                    $save = false;
                }
                if ($save == false) {
                    echo json_encode(array("response" => $save));
                }
                if ($amountRemaining == 0) {
                    $j++;
                }
            }
            if ($paymentAssociationId == 4) {
                $paymentAssociationId = PaymentAssociationsEnum::invoice;
            } else {
                $paymentAssociationId = PaymentAssociationsEnum::preinvoice;
            }
            $this->Payment->id = $paymentId;
            $this->Payment->saveField('payment_association_id', $paymentAssociationId);
            $this->createAssociationPaymentInvoices($paymentId);
        }
        if ($save == true) {
            echo json_encode(array("response" => $save, 'transportBillId' => $transportBillId));

        }

    }


    public function printRecuPayment($id = null)
    {
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        $payment = $this->Payment->find('first', array(
            'recursive' => -1,
            'conditions' => array('Payment.id' => $id),
            'fields' => array(
                'Payment.id',
                'Payment.wording',
                'Payment.operation_date',
                'Payment.receipt_date',
                'Payment.value_date',
                'Payment.amount',
                'Payment.payment_type',
                'Compte.num_compte',
                'Payment.wording',
                'Supplier.name',
                'PaymentAssociation.name'
            ),
            'joins' => array(
                array(
                    'table' => 'comptes',
                    'type' => 'left',
                    'alias' => 'Compte',
                    'conditions' => array('Compte.id = Payment.compte_id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Supplier.id = Payment.supplier_id')
                ),
                array(
                    'table' => 'payment_associations',
                    'type' => 'left',
                    'alias' => 'PaymentAssociation',
                    'conditions' => array('PaymentAssociation.id = Payment.payment_association_id')
                ),
            )
        ));
        $company = $this->Company->find('first');
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('payment', 'company', 'separatorAmount'));
    }


    public function liste($id = null, $keyword = null)
    {
        $keyword = str_replace('espace', ' ', $keyword);
        $keyword = str_replace('slash', '/', $keyword);
        $keyword = strtolower($keyword);
        $this->layout = 'ajax';
        $limit = $this->getLimit();
        $order =  $this->getOrder();
        switch ($id) {
            case 2 :
                if(!empty($keyword)){
                    $keyword = str_replace("/", "-", $keyword);
                    $start = str_replace("-", "/", $keyword);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $conditions = array("Payment.receipt_date >=" => $startdtm->format('Y-m-d'));
                }else {
                    $conditions = array();
                }

                break;
            case 3 :
                $conditions = array("LOWER(Compte.num_compte) LIKE" => "%$keyword%");
                break;
            case 4 :
                $conditions = array("LOWER(Payment.wording) LIKE" => "%$keyword%");
                break;

            case 5 :
                $conditions = array(
                    'OR' => array(
                        "LOWER(Customer.first_name) LIKE" => "%$keyword%",
                        "LOWER(Customer.last_name) LIKE" => "%$keyword%",
                        "LOWER(Supplier.name) LIKE" => "%$keyword%",
                        "LOWER(Interfering.name) LIKE" => "%$keyword%",
                    )
                );

                break;

            case 6 :
                $conditions = array("LOWER(Payment.payment_type) LIKE" => "%$keyword%");
                break;

            case 7 :
                $conditions = array("LOWER(Payment.payment_etat) LIKE" => "%$keyword%");
                break;

            case 8 :
                $conditions = array("LOWER(PaymentCategory.name) LIKE" => "%$keyword%");
                break;

            case 9 :
                $conditions = array("LOWER(Payment.amount) LIKE" => "%$keyword%");
                break;

            case 10 :
                if(!empty($keyword)){
                    $keyword = str_replace("/", "-", $keyword);
                    $start = str_replace("-", "/", $keyword);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $conditions = array("Payment.operation_date >=" => $startdtm->format('Y-m-d'));
                }else {
                    $conditions = array();
                }

                break;

            case 11 :
                if(!empty($keyword)){
                    $keyword = str_replace("/", "-", $keyword);
                    $start = str_replace("-", "/", $keyword);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $conditions = array("Payment.value_date >=" => $startdtm->format('Y-m-d'));
                }else {
                    $conditions = array();
                }

                break;

            case 12 :
                if(!empty($keyword)){
                    $keyword = str_replace("/", "-", $keyword);
                    $start = str_replace("-", "/", $keyword);
                    $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                    $conditions = array("Payment.deadline_date >=" => $startdtm->format('Y-m-d'));
                }else {
                    $conditions = array();
                }
                break;
            default:
                $conditions = array("LOWER(Payment.wording) LIKE" => "%$keyword%");
        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => $order,
            'recursive' => -1,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'fields' => array(
                'Payment.id',
                'Payment.wording',
                'Payment.operation_date',
                'Payment.receipt_date',
                'Payment.value_date',
                'Payment.deadline_date',
                'Payment.transact_type_id',
                'Payment.amount',
                'Payment.payment_type',
                'Payment.payment_etat',
                'Payment.payment_category_id',
                'PaymentCategory.name',
                'Compte.num_compte',
                'Payment.wording',
                'Customer.first_name',
                'Customer.last_name',
                'Supplier.name',
                'Interfering.name',
                'PaymentAssociation.name',
                'PaymentAssociation.id'
            ),
            'joins' => array(
                array(
                    'table' => 'comptes',
                    'type' => 'left',
                    'alias' => 'Compte',
                    'conditions' => array('Compte.id = Payment.compte_id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Customer.id = Payment.customer_id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Car.id = Payment.car_id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Supplier.id = Payment.supplier_id')
                ),
                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Event',
                    'conditions' => array('Event.id = Payment.event_id')
                ),
                array(
                    'table' => 'interferings',
                    'type' => 'left',
                    'alias' => 'Interfering',
                    'conditions' => array('Interfering.id = Payment.interfering_id')
                ),
                array(
                    'table' => 'payment_associations',
                    'type' => 'left',
                    'alias' => 'PaymentAssociation',
                    'conditions' => array('PaymentAssociation.id = Payment.payment_association_id')
                ),
                array(
                    'table' => 'payment_categories',
                    'type' => 'left',
                    'alias' => 'PaymentCategory',
                    'conditions' => array('PaymentCategory.id = Payment.payment_category_id')
                ),
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'User',
                    'conditions' => array('User.id = Payment.user_id')
                ),
                array(
                    'table' => 'profiles',
                    'type' => 'left',
                    'alias' => 'Profile',
                    'conditions' => array('Profile.id = User.profile_id')
                ),
            )
        );
        $payments = $this->Paginator->paginate('Payment');

        $separatorAmount = $this->getSeparatorAmount();

        $this->set(compact('separatorAmount', 'payments'));


    }

    /** created : 29/04/2019
    recherche rapide
     **/

    public function duplicatePayment($id = null , $paymentAssociationId= null){
        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        $this->layout = 'popup';
        $payement = $this->Payment->getPaymentById($id);
        $compteId = $payement['Payment']['compte_id'];
        $amount = $payement['Payment']['amount'];
        if (!empty($this->request->data)) {
            $nbDuplications = $this->request->data['Payment']['number_duplication'];
            for($i = 1; $i <= $nbDuplications ; $i ++ ) {
                $this->Payment->create();
                $this->Payment->save($payement);
                switch ($paymentAssociationId) {
                    case PaymentAssociationsEnum::cashing:
                        $this->Compte->updateCompteCredit($compteId, $amount);
                        break;
                    case PaymentAssociationsEnum::disbursement:
                        $this->Compte->updateCompteDebit($compteId, $amount);
                        break;
                }
            }
            $this->redirect(array('action' => 'index'));

        }
    }

    public function moneyTransfer(){

        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        if (Configure::read("cafyb") == '1') {
            if($this->Session->read('Permission.payment.virement')==0){
                $this->Flash->error(__("You don't have permission to add."));
                return $this->redirect(array('controller' => 'payments', 'action' => 'index'));

            }else {
                $this->Auth->allow();

                if ($this->request->is('post')) {
                    $payment = $this->request->data['Payment'];
                    $this->Cafyb->saveMoneyTransfer($payment);

                }
                $comptes = $this->Cafyb->getComptes();
                $suppliers = $this->Cafyb->getTiers();
                $paymentCategories = $this->Cafyb->getPaymentCategories();

                $this->set(compact('comptes', 'suppliers','paymentCategories'));

            }
        }else {
            $userId = $this->Auth->user('id');
            $result = $this->verifyUserPermission(SectionsEnum::virement, $userId, ActionsEnum::add, "Payments", null, "Payment", null,1);

            if ($this->request->is('post')) {
                $this->Payment->create();
                $this->createDateFromDate('Payment', 'receipt_date');
                $this->createDateFromDate('Payment', 'value_date');
                $this->request->data['Payment']['transact_type_id'] = 2;
                $this->request->data['Payment']['payment_association_id'] = 8;
                $this->request->data['Payment']['compte_id'] = $this->request->data['Payment']['origin_compte_id'];
                $compteTypeId = $this->Compte->getCompteType($this->request->data['Payment']['origin_compte_id']);

                if($compteTypeId == 2){
                    $this->request->data['Payment']['payment_type'] =  1;
                }
                if ($this->Payment->save($this->request->data)) {
                    $this->request->data['Payment']['transact_type_id'] = 1;
                    $this->request->data['Payment']['payment_association_id'] = 7;
                    $this->request->data['Payment']['compte_id'] = $this->request->data['Payment']['destination_compte_id'];
                    $compteTypeId = $this->Compte->getCompteType($this->request->data['Payment']['destination_compte_id']);
                    if($compteTypeId == 2){
                        $this->request->data['Payment']['payment_type'] =  1;
                    }
                    $this->Payment->create();
                    if ($this->Payment->save($this->request->data)) {
                        $originCompteId = $this->request->data['Payment']['origin_compte_id'];
                        $destinationCompteId = $this->request->data['Payment']['destination_compte_id'];
                        $amount = $this->request->data['Payment']['amount'];

                        $this->Compte->updateCompteDebit($originCompteId, $amount);
                        $this->Compte->updateCompteCredit($destinationCompteId, $amount);
                        $this->Flash->success(__('The transfer has been saved.'));
                        $this->redirect(array('action' => 'index'));
                    }else {
                        $this->Flash->success(__('The transfer could not be saved. Please, try again.'));
                        $this->redirect(array('action' => 'index'));
                    }
                } else {
                    $this->Flash->success(__('The transfer could not be saved. Please, try again.'));
                    $this->redirect(array('action' => 'index'));
                }
            }

            $comptes = $this->Payment->Compte->find('list', array('order' => 'num_compte'));
            $suppliers = $this->Supplier->getActiveSuppliers();
            $paymentCategories = $this->PaymentCategory->getPaymentCategories('list');
            $this->set(compact('comptes', 'suppliers','paymentCategories','result'));
        }

    }


    public function verifyTypeBills($type = null, $ids = null){

        switch ($type) {
            case BillTypesEnum::commercial_bills_list :
                $typeRedirect = BillTypesEnum::commercial_bills_list;
                $receipts =    $this->Bill->find('all', array(
                    'conditions' => array('Bill.id' => $ids,
                        'Bill.type'=>BillTypesEnum::receipt,
                        'Bill.amount_remaining >' => 0),
                    'recursive' => -1,
                    'fields' => array(
                        'Bill.total_ttc',
                        'Bill.supplier_id',
                        'Bill.id',
                        'Bill.amount_remaining'
                    )));

                if(!empty($receipts)) {

                    $type = BillTypesEnum::receipt ;

                    $deliveryOrders =    $this->Bill->find('all', array(
                        'conditions' => array('Bill.id' => $ids,
                            'Bill.type'=>BillTypesEnum::delivery_order,
                            'Bill.amount_remaining >' => 0),
                        'recursive' => -1,
                        'fields' => array(
                            'Bill.total_ttc',
                            'Bill.supplier_id',
                            'Bill.id',
                            'Bill.amount_remaining'
                        )));
                    if(!empty($deliveryOrders)){
                        $this->Flash->error(__(''));
                        return $this->redirect(array('controller' => 'bills', 'action' => 'index', BillTypesEnum::commercial_bills_list));
                    } else {
                        $returnSuppliers =    $this->Bill->find('all', array(
                            'conditions' => array('Bill.id' => $ids,
                                'Bill.type'=>BillTypesEnum::return_supplier,
                                'Bill.amount_remaining >' => 0),
                            'recursive' => -1,
                            'fields' => array(
                                'Bill.total_ttc',
                                'Bill.supplier_id',
                                'Bill.id',
                                'Bill.amount_remaining'
                            )));
                        if(!empty($returnSuppliers)){
                            $this->Flash->error(__(''));
                            return $this->redirect(array('controller' => 'bills', 'action' => 'index', BillTypesEnum::commercial_bills_list));
                        }else {
                            $returnCustomers =    $this->Bill->find('all', array(
                                'conditions' => array('Bill.id' => $ids,
                                    'Bill.type'=>BillTypesEnum::return_customer,
                                    'Bill.amount_remaining >' => 0),
                                'recursive' => -1,
                                'fields' => array(
                                    'Bill.total_ttc',
                                    'Bill.supplier_id',
                                    'Bill.id',
                                    'Bill.amount_remaining'
                                )));
                            if(!empty($returnCustomers)){
                                $this->Flash->error(__(''));
                                return $this->redirect(array('controller' => 'bills', 'action' => 'index', BillTypesEnum::commercial_bills_list));
                            }
                        }
                    }
                } else {
                    $deliveryOrders =    $this->Bill->find('all', array(
                        'conditions' => array('Bill.id' => $ids,
                            'Bill.type'=>BillTypesEnum::delivery_order,
                            'Bill.amount_remaining >' => 0),
                        'recursive' => -1,
                        'fields' => array(
                            'Bill.total_ttc',
                            'Bill.supplier_id',
                            'Bill.id',
                            'Bill.amount_remaining'
                        )));
                    if(!empty($deliveryOrders)){
                        $type = BillTypesEnum::delivery_order ;
                        $returnSuppliers =    $this->Bill->find('all', array(
                            'conditions' => array('Bill.id' => $ids,
                                'Bill.type'=>BillTypesEnum::return_supplier,
                                'Bill.amount_remaining >' => 0),
                            'recursive' => -1,
                            'fields' => array(
                                'Bill.total_ttc',
                                'Bill.supplier_id',
                                'Bill.id',
                                'Bill.amount_remaining'
                            )));
                        if(!empty($returnSuppliers)){
                            $this->Flash->error(__(''));
                            return $this->redirect(array('controller' => 'bills', 'action' => 'index', BillTypesEnum::commercial_bills_list));
                        }else {
                            $returnCustomers =    $this->Bill->find('all', array(
                                'conditions' => array('Bill.id' => $ids,
                                    'Bill.type'=>BillTypesEnum::return_customer,
                                    'Bill.amount_remaining >' => 0),
                                'recursive' => -1,
                                'fields' => array(
                                    'Bill.total_ttc',
                                    'Bill.supplier_id',
                                    'Bill.id',
                                    'Bill.amount_remaining'
                                )));
                            if(!empty($returnCustomers)){
                                $this->Flash->error(__(''));
                                return $this->redirect(array('controller' => 'bills', 'action' => 'index', BillTypesEnum::commercial_bills_list));
                            }
                        }
                    }else {
                        $returnSuppliers =    $this->Bill->find('all', array(
                            'conditions' => array('Bill.id' => $ids,
                                'Bill.type'=>BillTypesEnum::return_supplier,
                                'Bill.amount_remaining >' => 0),
                            'recursive' => -1,
                            'fields' => array(
                                'Bill.total_ttc',
                                'Bill.supplier_id',
                                'Bill.id',
                                'Bill.amount_remaining'
                            )));
                        if(!empty($returnSuppliers)){
                            $type = BillTypesEnum::return_supplier ;
                            $returnCustomers =    $this->Bill->find('all', array(
                                'conditions' => array('Bill.id' => $ids,
                                    'Bill.type'=>BillTypesEnum::return_customer,
                                    'Bill.amount_remaining >' => 0),
                                'recursive' => -1,
                                'fields' => array(
                                    'Bill.total_ttc',
                                    'Bill.supplier_id',
                                    'Bill.id',
                                    'Bill.amount_remaining'
                                )));
                            if(!empty($returnCustomers)){
                                $this->Flash->error(__(''));
                                return $this->redirect(array('controller' => 'bills', 'action' => 'index', BillTypesEnum::commercial_bills_list));
                            }
                        }else {
                            $returnCustomers =    $this->Bill->find('all', array(
                                'conditions' => array('Bill.id' => $ids,
                                    'Bill.type'=>BillTypesEnum::return_customer,
                                    'Bill.amount_remaining >' => 0),
                                'recursive' => -1,
                                'fields' => array(
                                    'Bill.total_ttc',
                                    'Bill.supplier_id',
                                    'Bill.id',
                                    'Bill.amount_remaining'
                                )));
                            if(!empty($returnCustomers)){
                                $type = BillTypesEnum::return_customer ;
                            }
                        }
                    }
                }
                $this->set('type',$type);
                break;

            case BillTypesEnum::special_bills_list :

                $typeRedirect = BillTypesEnum::special_bills_list;
                $entryOrders =    $this->Bill->find('all', array(
                    'conditions' => array('Bill.id' => $ids,
                        'Bill.type'=>BillTypesEnum::entry_order,
                        'Bill.amount_remaining >' => 0),
                    'recursive' => -1,
                    'fields' => array(
                        'Bill.total_ttc',
                        'Bill.supplier_id',
                        'Bill.id',
                        'Bill.amount_remaining'
                    )));

                if(!empty($entryOrders)) {

                    $type = BillTypesEnum::entry_order ;

                    $exitOrders =    $this->Bill->find('all', array(
                        'conditions' => array('Bill.id' => $ids,
                            'Bill.type'=>BillTypesEnum::exit_order,
                            'Bill.amount_remaining >' => 0),
                        'recursive' => -1,
                        'fields' => array(
                            'Bill.total_ttc',
                            'Bill.supplier_id',
                            'Bill.id',
                            'Bill.amount_remaining'
                        )));
                    if(!empty($exitOrders)){
                        $this->Flash->error(__(''));
                        return $this->redirect(array('controller' => 'bills', 'action' => 'index', BillTypesEnum::special_bills_list));
                    } else {
                        $renvoiOrders =    $this->Bill->find('all', array(
                            'conditions' => array('Bill.id' => $ids,
                                'Bill.type'=>BillTypesEnum::renvoi_order,
                                'Bill.amount_remaining >' => 0),
                            'recursive' => -1,
                            'fields' => array(
                                'Bill.total_ttc',
                                'Bill.supplier_id',
                                'Bill.id',
                                'Bill.amount_remaining'
                            )));
                        if(!empty($renvoiOrders)){
                            $this->Flash->error(__(''));
                            return $this->redirect(array('controller' => 'bills', 'action' => 'index', BillTypesEnum::special_bills_list));
                        }else {
                            $reintegrationOrders =    $this->Bill->find('all', array(
                                'conditions' => array('Bill.id' => $ids,
                                    'Bill.type'=>BillTypesEnum::reintegration_order,
                                    'Bill.amount_remaining >' => 0),
                                'recursive' => -1,
                                'fields' => array(
                                    'Bill.total_ttc',
                                    'Bill.supplier_id',
                                    'Bill.id',
                                    'Bill.amount_remaining'
                                )));
                            if(!empty($reintegrationOrders)){
                                $this->Flash->error(__(''));
                                return $this->redirect(array('controller' => 'bills', 'action' => 'index', BillTypesEnum::special_bills_list));
                            }
                        }
                    }
                } else {
                    $exitOrders =    $this->Bill->find('all', array(
                        'conditions' => array('Bill.id' => $ids,
                            'Bill.type'=>BillTypesEnum::exit_order,
                            'Bill.amount_remaining >' => 0),
                        'recursive' => -1,
                        'fields' => array(
                            'Bill.total_ttc',
                            'Bill.supplier_id',
                            'Bill.id',
                            'Bill.amount_remaining'
                        )));
                    if(!empty($exitOrders)){
                        $type = BillTypesEnum::exit_order ;
                        $renvoiOrders =    $this->Bill->find('all', array(
                            'conditions' => array('Bill.id' => $ids,
                                'Bill.type'=>BillTypesEnum::renvoi_order,
                                'Bill.amount_remaining >' => 0),
                            'recursive' => -1,
                            'fields' => array(
                                'Bill.total_ttc',
                                'Bill.supplier_id',
                                'Bill.id',
                                'Bill.amount_remaining'
                            )));
                        if(!empty($renvoiOrders)){
                            $this->Flash->error(__(''));
                            return $this->redirect(array('controller' => 'bills', 'action' => 'index', BillTypesEnum::special_bills_list));
                        }else {
                            $reintegrationOrders =    $this->Bill->find('all', array(
                                'conditions' => array('Bill.id' => $ids,
                                    'Bill.type'=>BillTypesEnum::reintegration_order,
                                    'Bill.amount_remaining >' => 0),
                                'recursive' => -1,
                                'fields' => array(
                                    'Bill.total_ttc',
                                    'Bill.supplier_id',
                                    'Bill.id',
                                    'Bill.amount_remaining'
                                )));
                            if(!empty($reintegrationOrders)){
                                $this->Flash->error(__(''));
                                return $this->redirect(array('controller' => 'bills', 'action' => 'index', BillTypesEnum::special_bills_list));
                            }
                        }
                    }else {
                        $renvoiOrders =    $this->Bill->find('all', array(
                            'conditions' => array('Bill.id' => $ids,
                                'Bill.type'=>BillTypesEnum::renvoi_order,
                                'Bill.amount_remaining >' => 0),
                            'recursive' => -1,
                            'fields' => array(
                                'Bill.total_ttc',
                                'Bill.supplier_id',
                                'Bill.id',
                                'Bill.amount_remaining'
                            )));
                        if(!empty($renvoiOrders)){
                            $type = BillTypesEnum::renvoi_order ;
                            $reintegrationOrders =    $this->Bill->find('all', array(
                                'conditions' => array('Bill.id' => $ids,
                                    'Bill.type'=>BillTypesEnum::reintegration_order,
                                    'Bill.amount_remaining >' => 0),
                                'recursive' => -1,
                                'fields' => array(
                                    'Bill.total_ttc',
                                    'Bill.supplier_id',
                                    'Bill.id',
                                    'Bill.amount_remaining'
                                )));
                            if(!empty($reintegrationOrders)){
                                $this->Flash->error(__(''));
                                return $this->redirect(array('controller' => 'bills', 'action' => 'index', BillTypesEnum::special_bills_list));

                            }
                        }else {
                            $reintegrationOrders =    $this->Bill->find('all', array(
                                'conditions' => array('Bill.id' => $ids,
                                    'Bill.type'=>BillTypesEnum::reintegration_order,
                                    'Bill.amount_remaining >' => 0),
                                'recursive' => -1,
                                'fields' => array(
                                    'Bill.total_ttc',
                                    'Bill.supplier_id',
                                    'Bill.id',
                                    'Bill.amount_remaining'
                                )));
                            if(!empty($reintegrationOrders)){
                                $type = BillTypesEnum::reintegration_order ;
                            }
                        }
                    }
                }
                $this->set('type',$type);




                break;

            case BillTypesEnum::purchase_invoices_list :
                $typeRedirect = BillTypesEnum::purchase_invoices_list;
                $purchaseInvoices =    $this->Bill->find('all', array(
                    'conditions' => array('Bill.id' => $ids,
                        'Bill.type'=>BillTypesEnum::purchase_invoice,
                        'Bill.amount_remaining >' => 0),
                    'recursive' => -1,
                    'fields' => array(
                        'Bill.total_ttc',
                        'Bill.supplier_id',
                        'Bill.id',
                        'Bill.amount_remaining'
                    )));

                if(!empty($purchaseInvoices)) {

                    $type = BillTypesEnum::purchase_invoice ;

                    $creditNotes =    $this->Bill->find('all', array(
                        'conditions' => array('Bill.id' => $ids,
                            'Bill.type'=>BillTypesEnum::credit_note,
                            'Bill.amount_remaining >' => 0),
                        'recursive' => -1,
                        'fields' => array(
                            'Bill.total_ttc',
                            'Bill.supplier_id',
                            'Bill.id',
                            'Bill.amount_remaining'
                        )));
                    if(!empty($creditNotes)){
                        $this->Flash->error(__(''));
                        return $this->redirect(array('controller' => 'bills', 'action' => 'index', BillTypesEnum::purchase_invoices_list));

                    }

                }else {
                    $creditNotes =    $this->Bill->find('all', array(
                        'conditions' => array('Bill.id' => $ids,
                            'Bill.type'=>BillTypesEnum::credit_note,
                            'Bill.amount_remaining >' => 0),
                        'recursive' => -1,
                        'fields' => array(
                            'Bill.total_ttc',
                            'Bill.supplier_id',
                            'Bill.id',
                            'Bill.amount_remaining'
                        )));
                    if(!empty($creditNotes)){
                        $type = BillTypesEnum::credit_note ;
                    }
                }
                $this->set('type',$type);

                break;


            case BillTypesEnum::sale_invoices_list :
                $typeRedirect = BillTypesEnum::sale_invoices_list;
                $saleInvoices =    $this->Bill->find('all', array(
                    'conditions' => array('Bill.id' => $ids,
                        'Bill.type'=>BillTypesEnum::sales_invoice,
                        'Bill.amount_remaining >' => 0),
                    'recursive' => -1,
                    'fields' => array(
                        'Bill.total_ttc',
                        'Bill.supplier_id',
                        'Bill.id',
                        'Bill.amount_remaining'
                    )));

                if(!empty($saleInvoices)) {

                    $type = BillTypesEnum::sales_invoice ;

                    $saleCreditNotes =    $this->Bill->find('all', array(
                        'conditions' => array('Bill.id' => $ids,
                            'Bill.type'=>BillTypesEnum::sale_credit_note,
                            'Bill.amount_remaining >' => 0),
                        'recursive' => -1,
                        'fields' => array(
                            'Bill.total_ttc',
                            'Bill.supplier_id',
                            'Bill.id',
                            'Bill.amount_remaining'
                        )));
                    if(!empty($saleCreditNotes)){
                        $this->Flash->error(__(''));
                        return $this->redirect(array('controller' => 'bills', 'action' => 'index', BillTypesEnum::sale_invoices_list));

                    }

                }else {
                    $saleCreditNotes =    $this->Bill->find('all', array(
                        'conditions' => array('Bill.id' => $ids,
                            'Bill.type'=>BillTypesEnum::sale_credit_note,
                            'Bill.amount_remaining >' => 0),
                        'recursive' => -1,
                        'fields' => array(
                            'Bill.total_ttc',
                            'Bill.supplier_id',
                            'Bill.id',
                            'Bill.amount_remaining'
                        )));
                    if(!empty($saleCreditNotes)){
                        $type = BillTypesEnum::sale_credit_note ;
                    }
                }
                $this->set('type',$type);

                break;

            case BillTypesEnum::sales_invoice :
                $typeRedirect = BillTypesEnum::sales_invoice;
                $this->set('type',$type);
                break ;
        }

    }


    // update cell
    function updateWording()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $value = filter_input(INPUT_POST, "value");
        $crypto = $this->decrypt(filter_input(INPUT_POST, "crypto"));
        $explode = explode('|', $crypto);
        $id = $explode[1];
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::journal_tresorerie, $userId, ActionsEnum::edit, "Payments",
            $id, "Payment", null,1);

        if($result){
            $this->Payment->id = $id;
            if ($this->Payment->saveField('wording', $value)){
                echo json_encode(array("response" => true));
            }else {
                echo json_encode(array("response" => false));
            }
        }else {
            echo json_encode(array("response" => false));
        }



    }

    // update cell
    function updateAmount()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $value = filter_input(INPUT_POST, "value");
        $crypto = $this->decrypt(filter_input(INPUT_POST, "crypto"));
        $explode = explode('|', $crypto);
        $id = $explode[1];
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::journal_tresorerie, $userId, ActionsEnum::edit, "Payments",
            $id, "Payment", null,1);
        if($result){
            $this->Payment->id = $id;
            if ($this->Payment->saveField('amount', $value)){
                echo json_encode(array("response" => true));
            }else {
                echo json_encode(array("response" => false));
            }
        }else {
            echo json_encode(array("response" => false));
        }



    }

    // update cell
    function updateReceiptDate()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $value = filter_input(INPUT_POST, "value");
        $crypto = $this->decrypt(filter_input(INPUT_POST, "crypto"));
        $explode = explode('|', $crypto);
        $id = $explode[1];
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::journal_tresorerie, $userId, ActionsEnum::edit, "Payments",
            $id, "Payment", null,1);
        if($result){
            $this->request->data['Payment']['receipt_date']= $value;
            $this->createDateFromDate('Payment', 'receipt_date');
            $this->Payment->id = $id;
            if ( $this->Payment->saveField('receipt_date', $this->request->data['Payment']['receipt_date'])){
                echo json_encode(array("response" => true));
            } else {
                echo json_encode(array("response" => false));
            }
        }else {
            echo json_encode(array("response" => false));
        }


    }

    function updateOperationDate()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $value = filter_input(INPUT_POST, "value");
        $crypto = $this->decrypt(filter_input(INPUT_POST, "crypto"));
        $explode = explode('|', $crypto);
        $id = $explode[1];
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::journal_tresorerie, $userId, ActionsEnum::edit, "Payments",
            $id, "Payment", null,1);
        if($result){
            $this->request->data['Payment']['operation_date']= $value;
            $this->createDateFromDate('Payment', 'operation_date');
            $this->Payment->id = $id;
            if ( $this->Payment->saveField('operation_date', $this->request->data['Payment']['operation_date'])){
                echo json_encode(array("response" => true));
            } else {
                echo json_encode(array("response" => false));
            }
        }else {
            echo json_encode(array("response" => false));
        }

    }

    function updateValueDate()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $value = filter_input(INPUT_POST, "value");
        $crypto = $this->decrypt(filter_input(INPUT_POST, "crypto"));
        $explode = explode('|', $crypto);
        $id = $explode[1];
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::journal_tresorerie, $userId, ActionsEnum::edit, "Payments",
            $id, "Payment", null,1);
        if($result){
            $this->request->data['Payment']['value_date']= $value;
            $this->createDateFromDate('Payment', 'value_date');
            $this->Payment->id = $id;
            if ( $this->Payment->saveField('value_date', $this->request->data['Payment']['value_date'])){
                echo json_encode(array("response" => true));
            } else {
                echo json_encode(array("response" => false));
            }
        }else {
            echo json_encode(array("response" => false));
        }

    }

    function updateDeadlineDate()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $value = filter_input(INPUT_POST, "value");
        $crypto = $this->decrypt(filter_input(INPUT_POST, "crypto"));
        $explode = explode('|', $crypto);
        $id = $explode[1];
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::journal_tresorerie, $userId, ActionsEnum::edit, "Payments",
            $id, "Payment", null,1);
        if($result){
            $this->request->data['Payment']['deadline_date']= $value;
            $this->createDateFromDate('Payment', 'deadline_date');
            $this->Payment->id = $id;
            if ( $this->Payment->saveField('deadline_date', $this->request->data['Payment']['deadline_date'])){
                echo json_encode(array("response" => true));
            } else {
                echo json_encode(array("response" => false));
            }
        }else {
            echo json_encode(array("response" => false));
        }

    }

    public function editPaymentEtat($ids = null){

        $this->Payment->validate = $this->Payment->validatePaymentEtat;
        $arrayIds = explode(",", $ids);
        if (!empty($this->request->data)) {

            $payments = $this->Payment->find('all', array(
                'conditions' => array('Payment.id' => $arrayIds),
                'fields' => array('Payment.id'),
                'recursive' => -1
            ));
            if (!empty($payments)) {
                foreach ($payments as $payment) {
                    $this->Payment->id = $payment['Payment']['id'];
                    $this->Payment->saveField('payment_etat', $this->request->data['Payment']['payment_etat']);
                }
            }



            $this->Flash->success(__('The etat has been saved.'));
            $this->redirect(array('action' => 'index'));
        }

    }

    public function editPaymentCategory($ids = null){

        $this->Payment->validate = $this->Payment->validatePaymentCategory;
        $arrayIds = explode(",", $ids);
        if (!empty($this->request->data)) {
            $payments = $this->Payment->find('all', array(
                'conditions' => array('Payment.id' => $arrayIds),
                'fields' => array('Payment.id'),
                'recursive' => -1
            ));
            if (!empty($payments)) {
                foreach ($payments as $payment) {
                    $this->Payment->id = $payment['Payment']['id'];
                    $this->Payment->saveField('payment_category_id', $this->request->data['Payment']['payment_category_id']);
                }
            }
            $this->Flash->success(__('The category has been saved.'));
            $this->redirect(array('action' => 'index'));
        }
        $paymentCategories = $this->PaymentCategory->getPaymentCategories('list');
        $this->set(compact('paymentCategories'));

    }

    public function dissociatePayments()
    {
        $this->autoRender = false;
        $paymentIds = json_decode($_GET['ids']);
        $billIds = json_decode($_GET['billIds']);
        $model = $_GET['model'];
        foreach ($paymentIds as $paymentId){
            $this->DetailPayment->deleteAll(array('DetailPayment.payment_id' => $paymentId), false);
            $this->updateAssociationPayment($paymentId);
        }

        $this->updateAmountRemainingBills($billIds,$model);
        echo json_encode(array("response" => true,'billIds'=>$billIds));
    }
    public function getRegulationsByBillIds($billIds = null, $model =null)
    {

       $this->set('model',$model);
        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        $this->layout = 'ajax';
        $count = count($billIds);
        if($count>1){
            $bill = $this->$model->getBillById($billIds[0]);
        }else {
            $bill = $this->$model->getBillById($billIds);
        }
        $supplierId = $bill[$model]['supplier_id'];
        $advancedPayments = $this->Payment->getAdvancedPaymentsBySupplierId($supplierId);
        $remainingPayments = $this->Payment->getPaymentsWithOverAmountBySupplierId($supplierId);
        $paymentParts = $this->Payment->getPaymentPartsByTransportBillIds($billIds);
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('advancedPayments', 'remainingPayments', 'separatorAmount', 'paymentParts',
            'billIds'));
    }


    public function getTotalsByIds($billIds = null, $model=null)
    {
        $this->layout = 'ajax';
        $bills = $this->$model->getBillByIds($billIds);
        $totalAmount = 0;
        $totalAmountRemaining = 0;
        foreach ($bills as $bill){
            $totalAmount = $bill[$model]['total_ttc'];
            $totalAmountRemaining = $bill[$model]['amount_remaining'];
        }
        $this->set(compact('totalAmount','totalAmountRemaining'));
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact( 'separatorAmount'));
    }


    public function printPaymentOrder($id){
        $payment = $this->Payment->find('all',array(
            'conditions' => array('Payment.id' => $id),
            'fields' => array(
                'Payment.id',
                'Payment.wording',
                'Payment.operation_date',
                'Payment.receipt_date',
                'Payment.value_date',
                'Payment.deadline_date',
                'Payment.transact_type_id',
                'Payment.amount',
                'Payment.payment_type',
                'Payment.payment_etat',
                'Payment.payment_category_id',
                'Payment.number_payment',
                'PaymentCategory.name',
                'Comptes.num_compte',
                'Payment.wording',
                'Customer.first_name',
                'Customer.last_name',
                'Suppliers.name',
                'Suppliers.cb',
                'Suppliers.adress',
                'Interfering.name',
                'PaymentAssociation.name',
                'PaymentAssociation.id'
            ),
            'joins' => array(
                array(
                    'table' => 'comptes',
                    'type' => 'left',
                    'alias' => 'Comptes',
                    'conditions' => array('Comptes.id = Payment.compte_id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Customer.id = Payment.customer_id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Suppliers',
                    'conditions' => array('Suppliers.id = Payment.supplier_id')
                ),
            
                array(
                    'table' => 'payment_associations',
                    'type' => 'left',
                    'alias' => 'PaymentAssociation',
                    'conditions' => array('PaymentAssociation.id = Payment.payment_association_id')
                ),
                array(
                    'table' => 'payment_categories',
                    'type' => 'left',
                    'alias' => 'PaymentCategory',
                    'conditions' => array('PaymentCategory.id = Payment.payment_category_id')
                ),
                array(
                    'table' => 'users',
                    'type' => 'left',
                    'alias' => 'Users',
                    'conditions' => array('Users.id = Payment.user_id')
                ),
                array(
                    'table' => 'profiles',
                    'type' => 'left',
                    'alias' => 'Profile',
                    'conditions' => array('Profile.id = User.profile_id')
                ),
            ))
        );
        $this->set(compact('payment'));
    }




}