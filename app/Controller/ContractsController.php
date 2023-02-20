<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'HTML2PDF');
App::uses('CakeTime', 'Utility');


/**
 * Contracts Controller
 *
 * @property CarType $CarType
 * @property Contract $Contract
 * @property Supplier $Supplier
 * @property DetailRide $DetailRide
 * @property Company $Company
 * @property ContractCarType $ContractCarType
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class ContractsController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Security', 'RequestHandler');
    var $helpers = array('Xls');
    public $uses = array('Contract', 'CarType', 'Company', 'ContractCarType', 'DetailRide');

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $offShore = $this->hasModuleOffShore();
        if($offShore==0){
            return $this->redirect('/');
        }

        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();

        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::contrat_affretement, $user_id, ActionsEnum::view,
            "Contracts", null, "Contract", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        switch ($result) {
            case 1 :
                $conditions = null;
                break;
            case 2 :
                $conditions = array('Contract.user_id ' => $user_id);

                break;
            case 3 :
                $conditions = array('Contract.user_id !=' => $user_id);

                break;

            default:
                $conditions = null;
        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Contract.reference' => 'ASC'),
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'fields' => array(
                'Contract.id',
                'ContractCarType.id',
                'Contract.reference',
                'Contract.supplier_id',
                'Supplier.name',
                'ContractCarType.price_ht',
                'ContractCarType.price_return',
                'ContractCarType.date_start',
                'ContractCarType.date_end',
                'CarType.name',
                'DepartureDestination.name',
                'ArrivalDestination.name',
            ),
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'contracts',
                    'type' => 'left',
                    'alias' => 'Contract',
                    'conditions' => array('ContractCarType.contract_id = Contract.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Contract.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('ContractCarType.detail_ride_id = DetailRide.id')
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
        );
        $contracts = $this->Paginator->paginate('ContractCarType');

        $this->set('contracts', $contracts);

        $this->set(compact('limit'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function search()
    {
        $offShore = $this->hasModuleOffShore();
        if($offShore==0){
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'],
                $this->request->params['action'], $this->request->data['keyword']);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Contract.reference' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));


            $conditions = array('OR' => array(
                "LOWER(Contract.reference) LIKE" => "%$keyword%",
                "LOWER(Supplier.name) LIKE" => "%$keyword%"
            ));
            $this->paginate = array(
                'limit' => $limit,
                'order' => array('Contract.reference' => 'ASC'),
                'conditions' => $conditions,
                'paramType' => 'querystring',
                'fields' => array(
                    'Contract.id',
                    'ContractCarType.id',
                    'Contract.reference',
                    'Contract.supplier_id',
                    'Supplier.name',
                    'ContractCarType.price_ht',
                    'ContractCarType.price_return',
                    'ContractCarType.date_start',
                    'ContractCarType.date_end',
                    'CarType.name',
                    'DepartureDestination.name',
                    'ArrivalDestination.name',
                ),
                'recursive' => -1,
                'joins' => array(
                    array(
                        'table' => 'contracts',
                        'type' => 'left',
                        'alias' => 'Contract',
                        'conditions' => array('ContractCarType.contract_id = Contract.id')
                    ),
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('Contract.supplier_id = Supplier.id')
                    ),
                    array(
                        'table' => 'detail_rides',
                        'type' => 'left',
                        'alias' => 'DetailRide',
                        'conditions' => array('ContractCarType.detail_ride_id = DetailRide.id')
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
            );
            $contracts = $this->Paginator->paginate('ContractCarType');

            $this->set('contracts', $contracts);
        } else {
            $this->Contract->recursive = 1;
            $this->set('contracts', $this->Paginator->paginate());
        }
        $this->set(compact('limit'));
        $this->render();
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
        $offShore = $this->hasModuleOffShore();
        if($offShore==0){
            return $this->redirect('/');
        }

        $this->setTimeActif();
        if (!$this->Contract->exists($id)) {
            throw new NotFoundException(__('Invalid contract'));
        }
        $contract = $this->Contract->find('first',
            array('conditions' => array('Contract.' . $this->Contract->primaryKey => $id)));
        $contractCarTypes = $this->ContractCarType->getContractDetailsByContractId($id, 'all');
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('contract', 'contractCarTypes', 'separatorAmount'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        $offShore = $this->hasModuleOffShore();
        if($offShore==0){
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::contrat_affretement, $user_id, ActionsEnum::add, "Contracts", null,
            "Contract", null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->layout = 'ajax';
                $this->redirect(array('action' => 'index'));
            }

            $this->Contract->create();
            $this->request->data['Contract']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Contract->save($this->request->data)) {
                $contractId = $this->Contract->getInsertID();
                $contractCarTypes = $this->request->data['ContractCarType'];
                foreach ($contractCarTypes as $contractCarType) {
                    $this->request->data['ContractCarType']['date_start'] = $contractCarType['date_start'];
                    $this->request->data['ContractCarType']['date_end'] = $contractCarType['date_end'];
                    $this->createDateFromDate('ContractCarType', 'date_start');
                    $this->createDateFromDate('ContractCarType', 'date_end');
                    $contractCarType['date_start'] = $this->request->data['ContractCarType']['date_start'];
                    $contractCarType['date_end'] = $this->request->data['ContractCarType']['date_end'];
                    $this->ContractCarType->addContractCarType($contractCarType,$contractId );

                }
                $this->Flash->success(__('The contract has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The contract could not be saved. Please, try again.'));
            }
        }
        $suppliers = $this->Supplier->getSuppliersByCategoryId(1);


        $this->set(compact('suppliers'));
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
        $offShore = $this->hasModuleOffShore();
        if($offShore==0){
            return $this->redirect('/');
        }

        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::contrat_affretement, $user_id, ActionsEnum::edit, "Contracts", $id,
            "Contract", null);
        if (!$this->Contract->exists($id)) {
            throw new NotFoundException(__('Invalid contract'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Contract cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Contract']['last_modifier_id'] = $this->Session->read('Auth.User.id');

            if ($this->Contract->save($this->request->data)) {
                $contractCarTypes = $this->request->data['ContractCarType'];
                if(isset($this->request->data['Contract']['deleted_id']) && !empty($this->request->data['Contract']['deleted_id'])){
                    $contractDeletedId = $this->request->data['Contract']['deleted_id'];
                    $contractIds = explode(",", $contractDeletedId);

                    foreach ($contractIds as $contractId) {
                        $this->ContractCarType->deleteContractCarType($contractId);
                    }
                }
                foreach ($contractCarTypes as $contractCarType) {
                    $this->request->data['ContractCarType']['date_start'] = $contractCarType['date_start'];
                    $this->request->data['ContractCarType']['date_end'] = $contractCarType['date_end'];
                    $this->createDateFromDate('ContractCarType', 'date_start');
                    $this->createDateFromDate('ContractCarType', 'date_end');
                    $contractCarType['date_start'] = $this->request->data['ContractCarType']['date_start'];
                    $contractCarType['date_end'] = $this->request->data['ContractCarType']['date_end'];
                    if(!empty($contractCarType['id'])){
                        $this->ContractCarType->updateContractCarType($contractCarType, $id);
                    }else {
                        $this->ContractCarType->addContractCarType($contractCarType, $id);
                    }

                }
                $this->Flash->success(__('The contract has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The contract could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Contract.' . $this->CarType->primaryKey => $id));
            $this->request->data = $this->Contract->find('first', $options);

            $contractCarTypes = $this->ContractCarType->find('all',
                array('conditions' => array('ContractCarType.contract_id' => $id)));
            $nbContracts = $this->ContractCarType->find('count',
                array('conditions' => array('ContractCarType.contract_id' => $id)));
				
				$detailRideIdes = array();
            foreach ($contractCarTypes as $contractCarType){
                $detailRideIdes[] = $contractCarType['DetailRide']['id'];
            }
            
            $this->DetailRide->virtualFields = array('cnames' => "CONCAT(DepartureDestination.name, ' - ', ArrivalDestination.name,' - ', CarType.name)");

            $detailRides = $this->TransportBill->DetailRide->find('list', array(
                'order' => 'DetailRide.wording ASC',
                'recursive' => -1,
                'fields' => 'cnames',
                'conditions'=>array('DetailRide.id'=>$detailRideIdes),
                'joins' => array(
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
            ));

            $this->set(compact('contractCarTypes', 'nbContracts','detailRides'));
        }

        $suppliers = $this->Supplier->getSuppliersByCategoryId(1);

       

        $this->set(compact('suppliers'));;
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

        $offShore = $this->hasModuleOffShore();
        if($offShore==0){
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::contrat_affretement, $user_id, ActionsEnum::delete, "Contracts", $id,
            "Contract", null);
        $this->Contract->id = $id;
        if (!$this->Contract->exists()) {
            throw new NotFoundException(__('Invalid contract'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Contract->delete()) {
            $this->Flash->success(__('The contract has been deleted.'));
        } else {
            $this->Flash->error(__('The contract could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteContracts()
    {
        $offShore = $this->hasModuleOffShore();
        if($offShore==0){
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $this->autoRender = false;
        $user_id = $this->Auth->user('id');

        $id = filter_input(INPUT_POST, "id");
        $this->verifyUserPermission(SectionsEnum::contrat_affretement, $user_id, ActionsEnum::delete, "Contracts", $id,
            "Contract", null);
        $this->CarType->id = $id;
        $this->request->allowMethod('post', 'delete');
        if ($this->CarType->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }
    }

    function printContract($id)
    {

        $this->setTimeActif();

        ini_set('memory_limit', '512M');
        if (!$this->Contract->exists($id)) {
            throw new NotFoundException(__('Invalid contract'));
        }
        $contract = $this->Contract->find('first',
            array(
                'conditions' => array('Contract.id' => $id)

            ));
        $contractCarTypes = $this->ContractCarType->getContractDetailsByContractId($id, 'all');
        $company = $this->Company->find('first');
        $this->set(compact('company', 'contract', 'contractCarTypes'));
    }

    function getCarType($i)
    {

      $detailRides = $this->DetailRide->getDetailRides();
        $this->set(compact('i', 'detailRides'));
    }


    public function liste($id = null, $keyword = null)
    {
        $keyword = str_replace('espace', ' ', $keyword);
        $keyword = str_replace('slash', '/', $keyword);
        $keyword = strtolower($keyword);
        $this->layout = 'ajax';
        $limit = $this->getLimit();
        switch ($id) {
            case 2 :
                $conditions = array("LOWER(Contract.reference) LIKE" => "%$keyword%");
                break;
            case 3 :
                $conditions = array("LOWER(Supplier.name) LIKE" => "%$keyword%");
                break;
            case 4 :
                $conditions = array(
                    'OR' => array(
                        "LOWER(CarType.name) LIKE" => "%$keyword%",
                        "LOWER(DepartureDestination.name) LIKE" => "%$keyword%",
                        "LOWER(ArrivalDestination.name) LIKE" => "%$keyword%",
                    )
                );
                break;

            case 5 :
                $conditions = array("LOWER(ContractCarType.price_ht) LIKE" => "%$keyword%");
                break;
            case 6 :
                $conditions = array("LOWER(ContractCarType.price_return) LIKE" => "%$keyword%");
                break;
            case 7 :
                $keyword = str_replace("/", "-", $keyword);
                $start = str_replace("-", "/", $keyword);
                $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                $conditions = array("ContractCarType.date_start >=" => $startdtm->format('Y-m-d 00:00:00'));
                break;

            case 8 :
                $keyword = str_replace("/", "-", $keyword);
                $start = str_replace("-", "/", $keyword);
                $startdtm = DateTime::createFromFormat('d/m/Y', $start);
                $conditions = array("ContractCarType.date_end >=" => $startdtm->format('Y-m-d 00:00:00'));
                break;


            default:
                $conditions = array("LOWER(Ride.wording) LIKE" => "%$keyword%");
        }


        $this->paginate = array(

            'order' => array('Contract.reference' => 'ASC'),
            'conditions' => $conditions,
            'limit'=>$limit,
            'paramType' => 'querystring',
            'fields' => array(
                'Contract.id',
                'ContractCarType.id',
                'Contract.reference',
                'Contract.supplier_id',
                'Supplier.name',
                'ContractCarType.price_ht',
                'ContractCarType.price_return',
                'ContractCarType.date_start',
                'ContractCarType.date_end',
                'CarType.name',
                'DepartureDestination.name',
                'ArrivalDestination.name',
            ),
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'contracts',
                    'type' => 'left',
                    'alias' => 'Contract',
                    'conditions' => array('ContractCarType.contract_id = Contract.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Contract.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('ContractCarType.detail_ride_id = DetailRide.id')
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
        );
        $contracts = $this->Paginator->paginate('ContractCarType');

        $this->set('contracts', $contracts);


    }


}
