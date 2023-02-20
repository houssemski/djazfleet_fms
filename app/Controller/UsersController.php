<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property Car $Car
 * @property Customer $Customer
 * @property Mark $Mark
 * @property Carmodel $Carmodel
 * @property CarCategory $CarCategory
 * @property CarType $CarType
 * @property Profile $Profile
 * @property Currency $Currency
 * @property Parc $Parc
 * @property Service $Service
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class UsersController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'RequestHandler');

    public $uses = array(
        'User',
        'Customer',
        'Mark',
        'Carmodel',
        'CarCategory',
        'CarType',
        'Currency',
        'Fuel',
        'Profile',
        'CustomerCar',
        'Parc',
        'UserParc',
        'TransportBill',
        'SheetRide',
        'Service',
    );
    var $helpers = array('Xls');

    // Allow non authetificated user to access login and logout pages
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('login', 'logout', 'renewal','loginCafyb');
        $this->User->validate['email']['email']['message'] = __("Enter a valid email");
        $this->User->validate['role']['valid']['message'] = __("Enter a valid role");
    }
    public function loginCafyb($userId=null){
        if (Configure::read("cafyb") == '1') {
            $user = $this->Cafyb->getInformationUser($userId);
            $this->writeInformationUser($user);
            $this->Auth->allow() ;
            $this->redirect($this->Auth->redirectUrl());
        }
    }

    public function login($userId=null)
    {

        if ($this->request->is('post') ||(!empty($userId)) ) {
            if (Configure::read("cafyb") == '1') {
                $user = $this->Cafyb->getInformationUser($userId);
                $this->Cafyb->writeInformationUser($user);
                $this->Auth->login() ==true;
                $this->redirect($this->Auth->redirectUrl());
            }else {
            if($this->request->is('post')){
                $this->request->data['User']['username'] = strtolower($this->request->data['User']['username']);
                $this->Session->write('djazfleet', $this->request->data['User']['password']);
                $this->request->data['User']['password'] = strtolower($this->request->data['User']['password']);

            }

                if ($this->Auth->login()) {
                    $this->setTimeActif();
                    $this->getNameSheetRide();
                    $this->getTotalNbAlerts();
                    $conditions = array('Notification.enter_index'=>1, 'Notification.read_notif'=>0);
                    $this->Notification->UpdateStatusNotifications($conditions);

                    //var_dump($sectionIds); die();

                    $this->getNbNotificationsByUser();

                    $this->setDateConnexion();
                    //$this->downloadDb();

                    $parameter = $this->Parameter->find(
                        'all',
                        array(
                            'recursive' => -1,
                            'conditions' => array('code' => array(8, 9)),
                            'fields' => array('val'),
                            'order' => array('code' => 'ASC')
                        )
                    );

                    $language = $this->Language->find(
                        'first',
                        array(
                            'recursive' => -1,
                            'conditions' => array('id' => (int)$parameter[0]['Parameter']['val'])
                        )
                    );
                    $currency = $this->Currency->find(
                        'first',
                        array(
                            'recursive' => -1,
                            'conditions' => array('id' => (int)$parameter[1]['Parameter']['val'])
                        )
                    );
                    $this->Session->write('profileId', $this->Auth->user('profile_id'));
                    $this->Session->write('User.language', $language['Language']['abr']);
                    $this->Session->write('currency', $currency['Currency']['abr']);
                    $this->Session->write('currencyName', $currency['Currency']['name']);
                    $useRideCategory = $this->useRideCategory();

                    $this->Session->write('useRideCategory', $useRideCategory);
                    $nameSheetRide = $this->getNameSheetRide();

                    $this->Session->write('nameSheetRide', $nameSheetRide);
                    $hasSaleModule = $this->hasSaleModule();
                    $this->Session->write('hasSaleModule', $hasSaleModule);
                    $tresorerie = $this->hasModuleTresorerie();
                    $this->Session->write('tresorerie', $tresorerie);
                    $stock = $this->hasModuleStock();
                    $this->Session->write('stock', $stock);
                    $offShore = $this->hasModuleOffShore();
                    $this->Session->write('offShore', $offShore);

                    $settleMissions = $this->abilityToSettleMissions();
                    $this->Session->write('settleMissions', $settleMissions);

                    $this->hasPurchaseBill();
                    $this->addCarsSubcontracting();
                    if ($this->isCustomer()) {
                        $this->redirect(array('controller'=>'transportBills','action' => 'index',2));
                    }elseif($this->isAgent()) {
                        $this->redirect(array('controller'=>'sheetRides','action' => 'index'));
                    }else {
                        $this->redirect($this->Auth->redirectUrl());
                    }

                } else {
                    $this->Flash->error(__("Invalid username or password, retry."));
                }

            }

        }else{


            $this->render();
        }
    }


       public function loginSecret()
    {
    
    
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->setSessionAlerts();
                $this->setDateConnexion();
               // $this->downloadDb();
                $this->setTimeActif();

                $this->redirect($this->Auth->redirectUrl());
                


            } else {

                $this->Flash->error(__("Invalid username or password, retry."));
            }
        }
    }

    public function logout()
    {
        //$this->downloadDb();
        $this->closeAllItemOpened();
        $this->redirect($this->Auth->logout());
    }

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->setTimeActif();
        $this->verifySuperAdministrator('Users');
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('User.id' => 'DESC'),
            'conditions' => array('User.id !=' =>array(0,1)),
            'paramType' => 'querystring'
        );
        $this->User->recursive = 0;
        $this->set('users', $this->Paginator->paginate('User'));
        $profiles = $this->Profile->getUserProfiles();
        $this->set(compact('limit','profiles'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function search()
    {
        $this->setTimeActif();
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])||isset($this->request->data['Users']['profile_id'])) {
                $this->filterUrl();
            }
        if (isset($this->params['named']['keyword']) || isset($this->params['named']['profile'])
        ) {
            $conditionsGeneral = array('User.id !=' => 1);
            $conditions = $this->getConds();
            if ($conditions != null) {
                $conditions = array_merge($conditions, $conditionsGeneral);
            }else {
                $conditions = $conditionsGeneral;
            }
            $this->paginate = array(
                'limit' => $limit,
                'order' => array('User.id' => 'DESC'),
                'conditions' => $conditions,
                'paramType' => 'querystring'
            );
            $this->User->recursive = 0;
            $this->set('users', $this->Paginator->paginate('User'));
        }else {
            $this->User->recursive = 0;
            $this->set('users', $this->Paginator->paginate('User'));
        }


        $profiles = $this->Profile->getUserProfiles();
        $this->set(compact('limit','profiles'));

        $this->render();
    }

    private function filterUrl()
    {
        $filter_url['controller'] = $this->request->params['controller'];
        $filter_url['action'] = $this->request->params['action'];
        $filter_url['page'] = 1;
        $filter_url['keyword'] = $this->request->data['keyword'];


        if (isset($this->request->data['Users']['profile_id']) && !empty($this->request->data['Users']['profile_id'])) {
            $filter_url['profile'] = $this->request->data['Users']['profile_id'];
        }


        return $this->redirect($filter_url);
    }

    private function getConds()
    {
        if (!empty($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
                $conds = array(
                    'OR' => array(
                        "LOWER(User.first_name) LIKE" => "%$keyword%",
                        "LOWER(User.last_name) LIKE" => "%$keyword%",
                        "LOWER(User.username) LIKE" => "%$keyword%",
                        "LOWER(User.email) LIKE" => "%$keyword%"
                    )
                );

        } else {
            $conds = array();
        }

        if (isset($this->params['named']['profile']) && !empty($this->params['named']['profile'])) {
            $conds["User.profile_id = "] = $this->params['named']['profile'];
            $this->request->data['Users']['profile_id'] = $this->params['named']['profile'];
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
        $this->verifySuperAdministrator('Users');
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));


 $this->set('user', $this->User->find('first', $options));
    }
    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        $this->setTimeActif();
        $this->verifySuperAdministrator('Users');
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['User']['username'] = strtolower($this->request->data['User']['username']);
            $this->request->data['User']['password'] = strtolower($this->request->data['User']['password']);
            $this->verifyAttachment('User', 'picture', 'img/users/', 'add',1,null);
            $this->Session->write('Auth.User.picture', $this->request->data['User']['picture']);
            if ($this->request->data['User']['super_admin'] == 1) {
                $this->request->data['User']['role_id'] = 3;
            } else {
                $this->request->data['User']['role_id'] = null;
            }
            $this->request->data['User']['last_visit_date'] = date('Y-m-d H:i');
            if ($this->request->data['User']['email'] == "") {
                $this->request->data['User']['email'] = null;
            }
            $this->request->data['User']['secret_password'] = $this->request->data['User']['password'];
            $this->User->create();
            if ($this->User->save($this->request->data)) {

                if(!empty($this->request->data['UserParc']['parcs'])){
                    $userId = $this->User->getInsertID();
                    $this->UserParc->addUserParcs($this->request->data['UserParc']['parcs'], $userId);
                }
                $this->Flash->success(__('The user has been saved.'));
                $this->setUserLanguage ();
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index'));
            }
        }

        $parcs = $this->Parc->getParcs('list');
        $profiles = $this->Profile->getUserProfiles();
        $languages = $this->Language->find('list');
        $this->set(compact('roles', 'parcs', 'profiles', 'languages'));
    }
    public function addUser($email= null, $password =null)
    {
            $this->request->data['User']['first_name'] = strtolower($email);
            $this->request->data['User']['last_name'] = strtolower($email);
            $this->request->data['User']['username'] = strtolower($email);
            $this->request->data['User']['password'] = strtolower($password);
            $this->request->data['User']['profile_id'] = 1;

            $this->request->data['User']['email'] = $email;

            $this->User->create();
            if ($this->User->save($this->request->data)) {
                //debug($this->User->validationErrors);die();

                $this->Flash->success(__('The user has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index'));
            }


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
        $this->verifySuperAdministrator($id);
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. User cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            
        $this->request->data['User']['username'] = strtolower($this->request->data['User']['username']);
            $this->request->data['User']['password'] = strtolower($this->request->data['User']['password']);
            $this->verifyAttachment('User', 'picture', 'img/users/', 'edit',1,0,$id);
            if ($this->request->data['User']['password'] == '') {
                unset($this->request->data['User']['password']);
            } else {

            $this->request->data['User']['secret_password']=$this->request->data['User']['password'];

            }

            if ($this->request->data['User']['super_admin'] == 1) {
                $this->request->data['User']['role_id'] = 3;
            } else {
                $this->request->data['User']['role_id'] = null;
            }
            if ($this->request->data['User']['email'] == "") {
                $this->request->data['User']['email'] = null;
            }
            $this->request->data['User']['secret_password'] = $this->request->data['User']['password'];
            if ($this->User->save($this->request->data)) {
            $this->pictureAuthUser();
            $this->setUserLanguage ();
                $this->Flash->success(__('The user has been saved.'));
                if ($this->request->data['User']['id'] == $this->Session->read('Auth.User.id')) {
                    $this->Session->write('Auth.User.first_name', $this->request->data['User']['first_name']);
                    $this->Session->write('Auth.User.last_name', $this->request->data['User']['last_name']);
                    $this->Session->write('Auth.User.email', $this->request->data['User']['email']);
                    $this->Session->write('Auth.User.picture', $this->Session->read("User.picture"));
                   
                }
                $this->UserParc->deleteAll(array('UserParc.user_id'=>$id),false);
                if(!empty($this->request->data['UserParc']['parcs'])){

                    $this->UserParc->addUserParcs($this->request->data['UserParc']['parcs'], $id);
                }

                if ($this->isSuperAdmin()) {
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->redirect(array('controller' => 'pages', 'action' => 'display'));
                }
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
            $parcs = $this->Parc->getParcs('list');
            $profiles = $this->Profile->getUserProfiles();
            $languages = $this->Language->find('list');
            if (isset($this->request->data['User'])){
                if($this->request->data['User']['profile_id'] == ProfilesEnum::client ){
                    $supplierId = $this->request->data['User']['supplier_id'];
                    $suppliers = $this->Supplier->getSuppliersByParams(1, 1, null, array(2, 3),null, $supplierId);
                }
            }


            $selectedparcs = $this->UserParc->find('list', array(
                'fields' => array('parc_id'),
                'conditions' => array('UserParc.user_id' => $id)
            ));
            $services = $this->Service->getServices('list');
            $this->set(compact("roles", "parcs", "profiles", 'languages', 'selectedparcs', 'suppliers','services'));
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
        $this->verifySuperAdministrator('Users');
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($id!=4 ) {
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        $this->User->id = $id;
        
        
        if ($this->User->delete()) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        } else {
            $this->Flash->error(__('The user could not be deleted.'));

            }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteusers()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        if ($this->isSuperAdmin()) {
            $id = filter_input(INPUT_POST, "id");
            $this->verifyDependences($id);
            $this->User->id = $id;
            $this->request->allowMethod('post', 'delete');
            if ($this->User->delete()) {
                echo json_encode(array("response" => "true"));
            }else{
                echo json_encode(array("response" => "false"));
            }
        }else{
            echo json_encode(array("response" => "false"));
        }
    }
    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $cars = $this->Car->find('first', array("conditions" => array("Car.user_id =" => $id)));

        if (!empty($cars)) {
            $this->Flash->error(__('The user could not be deleted. '
                . 'Please remove dependencies with cars in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        $customers = $this->Customer->find('first', array("conditions" => array("Customer.user_id =" => $id)));
        if (!empty($customers)) {
            $this->Flash->error(__('The user could not be deleted. '
                . 'Please remove dependencies with customers in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        $events = $this->Event->find('first', array("conditions" => array("Event.user_id =" => $id)));
        if (!empty($events)) {
            $this->Flash->error(__('The user could not be deleted. '
                . 'Please remove dependencies with events in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        $reservations = $this->CustomerCar->find('first', array("conditions" => array("CustomerCar.user_id =" => $id)));
        if (!empty($reservations)) {
            $this->Flash->error(__('The user could not be deleted. '
                . 'Please remove dependencies with reservations in advance.'));
            $this->redirect(array('action' => 'index'));
        }

        $transportBills = $this->TransportBill->find('first', array("conditions" => array("TransportBill.user_id =" => $id)));
        if (!empty($transportBills)) {
            $this->Flash->error(__('The user could not be deleted. '
                . 'Please remove dependencies with reservations in advance.'));
            $this->redirect(array('action' => 'index'));
        }

        $sheetRides = $this->SheetRide->find('first', array("conditions" => array("SheetRide.user_id =" => $id)));
        if (!empty($sheetRides)) {
            $this->Flash->error(__('The user could not be deleted. '
                . 'Please remove dependencies with reservations in advance.'));
            $this->redirect(array('action' => 'index'));
        }
         $parcs = $this->UserParc->find('first', array("conditions" => array("UserParc.user_id =" => $id)));
        if (!empty($parcs)) {
            $this->UserParc->deleteAll(array('UserParc.user_id'=>$id),false);

        }
    }


    function export()
    {
        $this->setTimeActif();
        $users = $this->User->find('all', array(
            'order' => 'User.first_name asc',
            'recursive' => -1
        ));

        $this->set('models', $users);
    }


    public function getCustomers($profileId = null)
    {
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if($parentId!=Null){
            $profileId = $parentId;
        }
        if ($profileId == ProfilesEnum::client || $profileId == ProfilesEnum::agent_commercial) {

        }

        $services = $this->Service->getServices('list');
    $this->set(compact('profileId','services'));

    }


}
