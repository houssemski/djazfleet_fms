<?php
App::uses('AppController', 'Controller');
/**
 * Shiftings Controller
 *
 * @property Shifting $Shifting
 * @property Location $Location
 * @property Car $Car
 * @property Tire $Tire
 * @property Position $Position
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class ShiftingsController extends AppController {

    public $uses = array('Shifting', 'Location', 'Tire', 'Position');
    /**
     * Components
     *
     * @var array
     */
	public $components = array('Paginator', 'Session','Security');
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $stock = $this->hasModuleStock();
        if($stock==0){
            return $this->redirect('/');
        }
         $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $user_id=$this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::deplacement_pneu, $user_id, ActionsEnum::view,
            "Shiftings", null, "Shifting" ,null);
        switch($result) {
            case 1 :
                $conditions=null;

                break;
            case 2 :
                    $conditions=array('Shifting.user_id '=>$user_id);

                break;
            case 3 :

                    $conditions=array('Shifting.user_id !='=>$user_id);

                break;

            default:
                $conditions=null;


        }
        $this->paginate = array(
            'limit' => $limit,
            'conditions'=>$conditions,
            'order' => array('Shifting.code' => 'ASC', 'Shifting.name' => 'ASC'),
            'recursive'=>-1,
            'paramType' => 'querystring',
            'fields' => array(
                'reference',
                'Shifting.id',
                'shifting_date',
                'Position.name',
                'Location.name',
                'Tire.model',
                'Car.code',
                
                'Carmodel.name',
                
                
            ),
            'joins' => array(
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Shifting.car_id = Car.id')
                ),
              
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'positions',
                    'type' => 'left',
                    'alias' => 'Position',
                    'conditions' => array('Shifting.position_id = Position.id')
                ),
                 array(
                    'table' => 'tires',
                    'type' => 'left',
                    'alias' => 'Tire',
                    'conditions' => array('Shifting.tire_id = Tire.id')
                ),
                 array(
                    'table' => 'locations',
                    'type' => 'left',
                    'alias' => 'Location',
                    'conditions' => array('Shifting.location_id = Location.id')
                ),


                 
            )
        );


       
        $this->set('shiftings', $this->Paginator->paginate());
        $this->set(compact('limit'));
    }

    public function search() {
        $stock = $this->hasModuleStock();
        if($stock==0){
            return $this->redirect('/');
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'],
                $this->request->params['action'], $this->request->data['keyword']);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Shifting.reference' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('shiftings', $this->Paginator->paginate('Shifting', array('OR' => array(
                "LOWER(Shifting.reference) LIKE" => "%$keyword%",
                "LOWER(Tire.model) LIKE" => "%$keyword%"))));
        } else {
            $this->Shifting->recursive = 0;
            $this->set('shiftings', $this->Paginator->paginate());
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
    public function view($id = null) {
        $stock = $this->hasModuleStock();
        if($stock==0){
            return $this->redirect('/');
        }
        $this->setTimeActif();
        if (!$this->Shifting->exists($id)) {
            throw new NotFoundException(__('Invalid shifting'));
        }
        $options = array('conditions' => array('Shifting.' . $this->Shifting->primaryKey => $id), 
            'recursive'=>-1 ,     
           'paramType' => 'querystring',
            'fields' => array(
                'reference',
                'Shifting.id',
                'shifting_date',
                'Position.name',
                'Location.name',
                'note',
                'Car.code',
                'Tire.model',
                'Carmodel.name',
                
                
            ),
            'joins' => array(
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Shifting.car_id = Car.id')
                ),
              
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
                array(
                    'table' => 'tires',
                    'type' => 'left',
                    'alias' => 'Tire',
                    'conditions' => array('Shifting.tire_id = Tire.id')
                ),
                array(
                    'table' => 'positions',
                    'type' => 'left',
                    'alias' => 'Position',
                    'conditions' => array('Shifting.position_id = Position.id')
                ),
                 array(
                    'table' => 'locations',
                    'type' => 'left',
                    'alias' => 'Location',
                    'conditions' => array('Shifting.location_id = Location.id')
                )));
        $this->set('shifting', $this->Shifting->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $stock = $this->hasModuleStock();
        if($stock==0){
            return $this->redirect('/');
        }
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::deplacement_pneu, $user_id, ActionsEnum::add,
            "Shiftings", null, "Shifting" ,null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->Shifting->create();
            $this->request->data['Shifting']['user_id'] = $this->Session->read('Auth.User.id');
            $this->createDateFromDate('Shifting', 'shifting_date');
            if ($this->Shifting->save($this->request->data)) {
                $this->Flash->success(__('The shifting has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->success(__('The shifting could not be saved. Please, try again.'));
            }
        }
        //Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $cars = $this->Car->getCarsByFieldsAndConds($param);
		
		$locations=$this->Location->getLocations();
		$positions=$this->Position->getPositions();
        $tires=$this->Tire->getTires();
        $this->set(compact('cars','locations','positions','tires')); 

    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $stock = $this->hasModuleStock();
        if($stock==0){
            return $this->redirect('/');
        }
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::deplacement_pneu, $user_id, ActionsEnum::edit,
            "Shiftings", $id, "Shifting" ,null);
        if (!$this->Shifting->exists($id)) {
            throw new NotFoundException(__('Invalid shifting'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Shifting cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Shifting']['modified_id'] = $this->Session->read('Auth.User.id');
             $this->createDateFromDate('Shifting', 'shifting_date');
            if ($this->Shifting->save($this->request->data)) {
                $this->Flash->success(__('The shifting has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The shifting could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Shifting.' . $this->Shifting->primaryKey => $id));
            $this->request->data = $this->Shifting->find('first', $options);
            //Get the structure of the car name from parameters
            $param = $this->Parameter->getCodesParameterVal('name_car');

        $cars = $this->Car->getCarsByFieldsAndConds($param);
		
		$locations=$this->Location->getLocations();
		$positions=$this->Position->getPositions();
        $tires=$this->Tire->getTires();
        $this->set(compact('cars','locations','positions','tires')); 
          
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
        $stock = $this->hasModuleStock();
        if($stock==0){
            return $this->redirect('/');
        }
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::deplacement_pneu, $user_id, ActionsEnum::delete,
            "Shiftings", $id, "Shifting" ,null);
        $this->Shifting->id = $id;
        if (!$this->Shifting->exists()) {
            throw new NotFoundException(__('Invalid shifting'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Shifting->delete()) {
            $this->Flash->success(__('The shifting has been deleted.'));
        } else {
            $this->Flash->error(__('The shifting could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }
    public function deleteshiftings() {
        $stock = $this->hasModuleStock();
        if($stock==0){
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');

        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $this->verifyUserPermission(SectionsEnum::deplacement_pneu, $user_id, ActionsEnum::delete,
            "Shiftings", $id, "Shifting" ,null);

        $this->Shifting->id = $id;
       
        $this->request->allowMethod('post', 'delete');
        if($this->Shifting->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }
        /*}else{
        echo json_encode(array("response" => "false"));
        }*/
    }


   
}
