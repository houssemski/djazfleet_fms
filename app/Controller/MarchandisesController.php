<?php


App::uses('AppController', 'Controller');

/**
 * Marchandise Controller
 *
 * @property Marchandise $Marchandise
 * @property Supplier $Supplier
 * @property SheetRideDetailRideMarchandise $SheetRideDetailRideMarchandise
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class MarchandisesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session','Security');
   //  public $uses = array('SheetRide','Marchandise');
var $helpers = array('Xls');

    /**
     * @param null $params
     * @param null $orderType
     * @return array
     */

    public function getOrder ($params = null , $orderType = null){

        if($orderType == null){
            $orderType = 'DESC';
        }
        if (isset($params) && is_numeric($params)) {
            switch($params){
                case 1 :
                    $order = array('Marchandise.wording' => $orderType);
                    break;
                case 2 :
                    $order = array('Marchandise.name' => $orderType);
                    break;
                case 3 :
                    $order = array('Marchandise.id' => $orderType);
                    break;


                default : $order = array('Marchandise.id' => $orderType);
            }
            return $order;
        } else {
            $order = array('Marchandise.id' => $orderType);

            return $order;
        }
    }
    public function index() {
   
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::marchandise, $user_id, ActionsEnum::view, "Marchandises",
            null, "Marchandise" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();

        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                    $conditions=array('Marchandise.user_id '=>$user_id);
                break;
            case 3 :
                    $conditions=array('Marchandise.user_id !='=>$user_id);
                break;

            default:
                $conditions=null;
        }
        $this->paginate = array(
            'recursive'=>0,
            'limit' => $limit,
            'order' => $order,
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );
        $this->set('marchandises', $this->Paginator->paginate('Marchandise'));
        $this->set(compact('limit','order'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function search() {
        $this->setTimeActif();
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'], 
                    $this->request->params['action'], $this->request->data['keyword']);
        }

        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $marchandises= $this->Paginator->paginate('Marchandise',

                array('OR' => array(
                    "LOWER(Marchandise.wording) LIKE" => "%$keyword%",
                    "LOWER(Marchandise.name) LIKE" => "%$keyword%"

                ))

            );

            $this->set('marchandises', $marchandises);

        } else {
            $this->Marchandise->recursive = 0;
            $this->set('marchandises', $this->Paginator->paginate());
        }
        $this->set(compact('limit','order'));
        $this->render();
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->setTimeActif();
        if (!$this->Marchandise->exists($id)) {
            throw new NotFoundException(__('Invalid Marchandise'));
        }
        $options = array('conditions' => array('Marchandise.' . $this->Marchandise->primaryKey => $id));
        $this->set('marchandise', $this->Marchandise->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
   
        $this->setTimeActif();

        //$this->verifyAuditor("CarTypes");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::marchandise, $user_id, ActionsEnum::add, "Marchandises",
            null, "Marchandise" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                 $this->layout = 'ajax';
                $this->redirect(array('action' => 'index'));
            }
           
            $this->Marchandise->create();
            $this->request->data['Marchandise']['user_id'] = $this->Session->read('Auth.User.id');


 if ($this->Marchandise->save($this->request->data)) {

                $this->Flash->success(__('The marchandise has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The marchandise could not be saved. Please, try again.'));
            }

        }
		$marchandiseTypes = $this->Marchandise->MarchandiseType->find('list', array('order' => 'name ASC'));
			
		$marchandiseUnits = $this->Marchandise->MarchandiseUnit->find('list', array('order' => 'name ASC'));
        $suppliers =  $this->Supplier->getSuppliersByParams(1,1);
        $this->set(compact( 'marchandiseTypes', 'marchandiseUnits','suppliers'));
        
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::marchandise, $user_id, ActionsEnum::edit, "Marchandises",
            $id, "Marchandise" ,null);
        if (!$this->Marchandise->exists($id)) {
            throw new NotFoundException(__('Invalid Marchandise'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Marchandise cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Marchandise']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Marchandise->save($this->request->data)) {
                $this->Flash->success(__('The Marchandise has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The Marchandise could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Marchandise.' . $this->Marchandise->primaryKey => $id));
            $this->request->data = $this->Marchandise->find('first', $options);
           $marchandiseTypes = $this->Marchandise->MarchandiseType->find('list', array('order' => 'name ASC'));
			$marchandiseUnits = $this->Marchandise->MarchandiseUnit->find('list', array('order' => 'name ASC'));
            $suppliers =  $this->Supplier->getSuppliersByParams(1,1);
        $this->set(compact( 'marchandiseTypes', 'marchandiseUnits','suppliers'));
        }
       
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::marchandise, $user_id, ActionsEnum::delete, "Marchandises",
            $id, "Marchandise" ,null);
        $this->Marchandise->id = $id;
        if (!$this->Marchandise->exists()) {
            throw new NotFoundException(__('Invalid Marchandise'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Marchandise->delete()) {
                $this->Flash->success(__('The Marchandise has been deleted.'));
        } else {
                $this->Flash->error(__('The Marchandise could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteMarchandises() {
        $this->setTimeActif();
        $this->autoRender = false;
        $user_id=$this->Auth->user('id');
            $id = filter_input(INPUT_POST, "id");
            $this->verifyUserPermission(SectionsEnum::marchandise, $user_id, ActionsEnum::delete, "Marchandises",
                $id, "Marchandise" ,null);
            $this->Marchandise->id = $id;
            $this->verifyDependences($id);
            $this->request->allowMethod('post', 'delete');
            if($this->Marchandise->delete()){
                echo json_encode(array("response" => "true"));
            }else{
                echo json_encode(array("response" => "false"));
            }        /*}else{
            echo json_encode(array("response" => "false"));
        }*/
    }
    private function verifyDependences($id){
        $this->setTimeActif();
        /* pour verifier les dependances avec les missions */
		$this->loadModel('SheetRideDetailRideMarchandise');
        $result = $this->SheetRideDetailRideMarchandise->find('first',
            array("conditions" => array("SheetRideDetailRideMarchandise.marchandise_id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The Marchandise could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        } 
    }
    function export() {
        $this->setTimeActif();
            $Marchandises = $this->Marchandise->find('all', array(
                'order' => 'Marchandise.name asc',
                'recursive' => 2
            ));
        $this->set('models', $Marchandises);
    }
	
	
			   public function liste( $id=null, $keyword=null)
    {
        $keyword= str_replace('espace', ' ', $keyword);
        $keyword= str_replace('slash', '/', $keyword);
		$keyword= strtolower($keyword);
        $this->layout = 'ajax';
        $limit = $this->getLimit();
            switch ($id) {
                case 2 :
                    $conditions = array("LOWER(Marchandise.wording) LIKE" => "%$keyword%");
                    break;
                case 3 :
                    $conditions = array("LOWER(Marchandise.name) LIKE" => "%$keyword%");
                    break;
                case 4 :
                    $conditions = array("LOWER(MarchandiseType.name) LIKE" => "%$keyword%");
                    break;

                case 5 :
                    $conditions = array("LOWER(MarchandiseUnit.name) LIKE" => "%$keyword%");
                    break;
					
				case 6 :
                    $conditions = array("LOWER(supplier.name) LIKE" => "%$keyword%");
                    break;
					
				case 7 :
                    $conditions = array("LOWER(Marchandise.quantity_stock) LIKE" => "%$keyword%");
                    break;
					
				case 8 :
                    $conditions = array("LOWER(Marchandise.quantity_min) LIKE" => "%$keyword%");
                    break;
					
				case 9 :
                    $conditions = array("LOWER(Marchandise.quantity_max) LIKE" => "%$keyword%");
                    break;
					
				case 10 :
                    $conditions = array("LOWER(Marchandise.weight) LIKE" => "%$keyword%");
                    break;
					
				case 11 :
                    $conditions = array("LOWER(Marchandise.weight_palette) LIKE" => "%$keyword%");
                    break;
               
               
                default:
                    $conditions = array("LOWER(Marchandise.wording) LIKE" => "%$keyword%");
            }

		$this->paginate = array(
            'recursive'=>0,
            'conditions'=>$conditions,
            'limit'=>$limit,
            'paramType' => 'querystring'
        );
        $this->set('marchandises', $this->Paginator->paginate('Marchandise'));



    }







}
