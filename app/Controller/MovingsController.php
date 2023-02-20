<?php
App::uses('AppController', 'Controller');
/**
 * Movings Controller
 *
 * @property Moving $Moving
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class MovingsController extends AppController {

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
        $result = $this->verifyUserPermission(SectionsEnum::deplacement_extincteur, $user_id, ActionsEnum::view,
            "Movings", null, "Moving" ,null);

         switch($result) {
            case 1 :
                $conditions=null;

                break;
            case 2 :
                    $conditions=array('Moving.user_id '=>$user_id);

                break;
            case 3 :

                    $conditions=array('Moving.user_id !='=>$user_id);

                break;

            default:
                $conditions=null;


        }
        $this->paginate = array(
            'limit' => $limit,
            'conditions'=>$conditions,
            'order' => array('Moving.reference' => 'ASC'),
            'recursive'=>-1,
            'paramType' => 'querystring',
            'fields' => array(
                'reference',
                'Moving.id',
                'date_start',
                'date_end',
                'Extinguisher.extinguisher_number',
              
                'Car.code',
                
                'Carmodel.name',
                
                
            ),
            'joins' => array(
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Moving.car_id = Car.id')
                ),
              
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
               
                 array(
                    'table' => 'extinguishers',
                    'type' => 'left',
                    'alias' => 'Extinguisher',
                    'conditions' => array('Moving.extinguisher_id = Extinguisher.id')
                )


                 
            )
        );


       
        $this->set('movings', $this->Paginator->paginate());
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
            'order' => array('Moving.reference' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));


            $this->paginate = array(
                'limit' => $limit,
                'conditions'=>array('OR' => array(
                "LOWER(Moving.reference) LIKE" => "%$keyword%",
                "LOWER(Extinguisher.extinguisher_number) LIKE" => "%$keyword%")),
                'order' => array('Moving.reference' => 'ASC'),
                'recursive'=>-1,
                'paramType' => 'querystring',
                'fields' => array(
                    'reference',
                    'Moving.id',
                    'date_start',
                    'date_end',
                    'Extinguisher.extinguisher_number',

                    'Car.code',

                    'Carmodel.name',


                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('Moving.car_id = Car.id')
                    ),

                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),

                    array(
                        'table' => 'extinguishers',
                        'type' => 'left',
                        'alias' => 'Extinguisher',
                        'conditions' => array('Moving.extinguisher_id = Extinguisher.id')
                    )



                )
            );

            $this->set('movings', $this->Paginator->paginate('Moving' ));
        } else {
            $this->Moving->recursive = 0;
            $this->set('movings', $this->Paginator->paginate());
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
        if (!$this->Moving->exists($id)) {
            throw new NotFoundException(__('Invalid moving'));
        }
        $options = array('conditions' => array('Moving.' . $this->Moving->primaryKey => $id), 
           'recursive'=>-1,
            'paramType' => 'querystring',
            'fields' => array(
                'reference',
                'Moving.id',
                'date_start',
                'date_end',
                'Extinguisher.extinguisher_number',
              
                'Car.code',
                
                'Carmodel.name',
                
                
            ),
            'joins' => array(
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Moving.car_id = Car.id')
                ),
              
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
               
                 array(
                    'table' => 'extinguishers',
                    'type' => 'left',
                    'alias' => 'Extinguisher',
                    'conditions' => array('Moving.extinguisher_id = Extinguisher.id')
                )


                 
            )
        );

        $this->set('moving', $this->Moving->find('first', $options));
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
        $this->verifyUserPermission(SectionsEnum::deplacement_extincteur, $user_id, ActionsEnum::add, "Movings",
            null, "Moving" ,null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->Moving->create();
            $this->request->data['Moving']['user_id'] = $this->Session->read('Auth.User.id');
            $this->createDateFromDate('Moving', 'date_start');
            $this->createDateFromDate('Moving', 'date_end');
            if ($this->Moving->save($this->request->data)) {
                $this->Flash->success(__('The moving has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The moving could not be saved. Please, try again.'));
            }
        }
        //Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if($param==1) {
        $this->Car->virtualFields = array(
            'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
        );
        } elseif ($param==2) {
            
           $this->Car->virtualFields = array(
            'cnames' => "CONCAT(IFNULL(Car.immatr_def,Car.immatr_prov), ' - ',Carmodel.name )"
        );
        }


        $cars = $this->Moving->Car->find('list', array(
            'fields' => 'cnames',
            'recursive' => 1,
            'order' => array('Car.code asc','Carmodel.name asc'),
            
            ));
		
		 
        $extinguishers=$this->Moving->Extinguisher->find('list', array('order' => 'extinguisher_number ASC'));
        $this->set(compact('cars','extinguishers')); 

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
        $this->verifyUserPermission(SectionsEnum::deplacement_extincteur, $user_id, ActionsEnum::edit,
            "Movings", $id, "Moving" ,null);
        if (!$this->Moving->exists($id)) {
            throw new NotFoundException(__('Invalid Moving'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Moving cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Moving']['modified_id'] = $this->Session->read('Auth.User.id');
             $this->createDateFromDate('Moving', 'date_start');
            $this->createDateFromDate('Moving', 'date_end');
            if ($this->Moving->save($this->request->data)) {
                $this->Flash->success(__('The moving has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The moving could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Moving.' . $this->Moving->primaryKey => $id));
            $this->request->data = $this->Moving->find('first', $options);
            //Get the structure of the car name from parameters
            $param = $this->Parameter->getCodesParameterVal('name_car');
            if($param==1) {
                $this->Car->virtualFields = array(
                    'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
                );
            } elseif ($param==2) {

                $this->Car->virtualFields = array(
                    'cnames' => "CONCAT(IFNULL(Car.immatr_def,Car.immatr_prov), ' - ',Carmodel.name )"
                );
            }



            $cars = $this->Moving->Car->find('list', array(
                'fields' => 'cnames',
                'recursive' => 1,
                'order' => array('Car.code asc','Carmodel.name asc'),

            ));
		
        $extinguishers=$this->Moving->Extinguisher->find('list', array('order' => 'extinguisher_number ASC'));
        $this->set(compact('cars','extinguishers')); 
          
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
        $this->verifyUserPermission(SectionsEnum::deplacement_extincteur, $user_id, ActionsEnum::delete,
            "Movings", $id, "Moving" ,null);
        $this->Moving->id = $id;
        if (!$this->Moving->exists()) {
            throw new NotFoundException(__('Invalid Moving'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Moving->delete()) {
            $this->Flash->success(__('The moving has been deleted.'));
        } else {
            $this->Flash->error(__('The moving could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }
    public function deleteMovings() {
        $stock = $this->hasModuleStock();
        if($stock==0){
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');

        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");

        $this->verifyUserPermission(SectionsEnum::deplacement_extincteur, $user_id, ActionsEnum::delete, "Movings",
            $id, "Moving" ,null);

        $this->Moving->id = $id;
       
        $this->request->allowMethod('post', 'delete');
        if($this->Moving->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }

    }


   
}
