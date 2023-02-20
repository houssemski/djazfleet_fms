<?php
App::uses('AppController', 'Controller');
class FuelCardAffectationsController extends AppController {

    public $components = array('Paginator', 'Session','Security');
    var $helpers = array('Xls');
    public $uses = array('FuelCardAffectation', 'FuelCard', 'FuelCardCar');

    public function index() {
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::affectation_carte_carburant, $user_id, ActionsEnum::view,
            "FuelCardAffectations", null, "FuelCardAffectation" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        switch($result) {
            case 1 :
                $conditions = 'FuelCardAffectation.id != 0';
                break;
            case 2 :
                $conditions=array('FuelCardAffectation.user_id '=>$user_id, 'FuelCardAffectation.id !=' => 0);

                break;
            case 3 :
                $conditions=array('FuelCardAffectation.user_id !='=>$user_id, 'FuelCardAffectation.id !=' => 0);
                break;
            default:
                $conditions = 'FuelCardAffectation.id != 0';
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('FuelCardAffectation.id' => 'DESC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring',
            'fields'=>array('FuelCardAffectation.id','FuelCardAffectation.reference','Car.code','Car.immatr_def','Carmodel.name','FuelCard.reference',
                'FuelCardAffectation.start_date', 'FuelCardAffectation.end_date', 'FuelCard.reference'),
            'recursive'=>-1,
            'joins'=>array(
                array(
                    'table' => 'fuel_card_affectations',
                    'type' => 'left',
                    'alias' => 'FuelCardAffectation',
                    'conditions' => array('FuelCardAffectation.id = FuelCardCar.fuel_card_affectation_id')
                ),
                array(
                    'table' => 'fuel_cards',
                    'type' => 'left',
                    'alias' => 'FuelCard',
                    'conditions' => array('FuelCardAffectation.fuel_card_id = FuelCard.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('FuelCardCar.car_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
            )

        );
        $this->set('fuelCardAffectations', $this->Paginator->paginate('FuelCardCar'));
        //Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set(compact('limit','param'));

    }
    public function search() {
        $this->setTimeActif();
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'],
                $this->request->params['action'], $this->request->data['keyword']);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('FuelCardAffectation.id' => 'DESC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));

            $this->paginate = array(
                'limit' => $limit,
                'order' => array('FuelCardAffectation.id' => 'DESC'),
                "LOWER(FuelCardAffectation.reference) LIKE" => "%$keyword%",
                'paramType' => 'querystring',
                'fields'=>array('FuelCardAffectation.id','FuelCardAffectation.reference','Car.code','Car.immatr_def','Carmodel.name','FuelCard.reference',
                    'FuelCardAffectation.start_date', 'FuelCardAffectation.end_date', 'FuelCard.reference'),
                'recursive'=>-1,
                'joins'=>array(
                    array(
                        'table' => 'fuel_card_affectations',
                        'type' => 'left',
                        'alias' => 'FuelCardAffectation',
                        'conditions' => array('FuelCardAffectation.id = FuelCardCar.fuel_card_affectation_id')
                    ),
                    array(
                        'table' => 'fuel_cards',
                        'type' => 'left',
                        'alias' => 'FuelCard',
                        'conditions' => array('FuelCardAffectation.fuel_card_id = FuelCard.id')
                    ),
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('FuelCardCar.car_id = Car.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),
                )

            );


            $this->set('fuelCardAffectations', $this->Paginator->paginate('FuelCardCar'));
        } else {
            $this->paginate = array(
                'limit' => $limit,
                'order' => array('FuelCardAffectation.id' => 'DESC'),

                'paramType' => 'querystring',
                'fields'=>array('FuelCardAffectation.id','FuelCardAffectation.reference','Car.code','Car.immatr_def','Carmodel.name','FuelCard.reference',
                    'FuelCardAffectation.start_date', 'FuelCardAffectation.end_date', 'FuelCard.reference'),
                'recursive'=>-1,
                'joins'=>array(
                    array(
                        'table' => 'fuel_card_affectations',
                        'type' => 'left',
                        'alias' => 'FuelCardAffectation',
                        'conditions' => array('FuelCardAffectation.id = FuelCardCar.fuel_card_affectation_id')
                    ),
                    array(
                        'table' => 'fuel_cards',
                        'type' => 'left',
                        'alias' => 'FuelCard',
                        'conditions' => array('FuelCardAffectation.fuel_card_id = FuelCard.id')
                    ),
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('FuelCardCar.car_id = Car.id')
                    ),
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),
                )

            );


            $this->set('fuelCardAffectations', $this->Paginator->paginate('FuelCardCar'));
        }
        $this->set(compact('limit'));
        $this->render();
    }
    public function View($id= null) {
        $this->setTimeActif();
        $fuelCardAffectation=$this->FuelCardAffectation->find('first',
            array(
                'conditions'=>array('FuelCardAffectation.id'=>$id),
                'fields'=>array('FuelCardAffectation.id','FuelCardAffectation.reference','FuelCard.reference',
                    'FuelCardAffectation.start_date', 'FuelCardAffectation.end_date', 'FuelCard.reference'),
                'recursive'=>-1,
                'joins'=>array(

                    array(
                        'table' => 'fuel_cards',
                        'type' => 'left',
                        'alias' => 'FuelCard',
                        'conditions' => array('FuelCardAffectation.fuel_card_id = FuelCard.id')
                    )
                )
            ));
        $carsSelected = $this ->FuelCardAffectation->FuelCardCar->find('all', array(
            'recursive'=>-1,
            'fields'=>array('Car.code','Car.immatr_def','Carmodel.name'),
            'conditions'=>array('FuelCardCar.fuel_card_affectation_id'=>$id),
            'joins'=>array(

                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('FuelCardCar.car_id = Car.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
            )
                ));

//Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set(compact( 'fuelCardAffectation','param','carsSelected'));
    }
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::affectation_carte_carburant, $user_id, ActionsEnum::add,
            "FuelCardAffectations", null, "FuelCardAffectation" ,null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->FuelCardAffectation->create();
            $this->request->data['FuelCardAffectation']['user_id'] = $this->Session->read('Auth.User.id');
            $this->createDateFromDate('FuelCardAffectation', 'start_date');
            $this->createDateFromDate('FuelCardAffectation', 'end_date');
            if($this->FuelCardAffectation->save($this->request->data)){
                $fuelCardAffectationId = $this->FuelCardAffectation->getInsertID();
                foreach($this->request->data['FuelCardCar']['car_id'] as $carId){
                    $this->FuelCardCar->create();
                    $data = array();
                    $data['FuelCardCar']['car_id'] =$carId  ;

                    $data['FuelCardCar']['fuel_card_affectation_id'] = $fuelCardAffectationId ;
                    $this->FuelCardCar->save($data);
                }
                $this->Flash->success(__('The affectation has been saved.'));
                $this->redirect(array('action' => 'index'));
            }else {
                $this->Flash->error(__('The affectation could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index'));
            }




        }
        $fuelCards = $this->FuelCardAffectation->FuelCard->find('list',array('order'=>'FuelCard.reference'));
//Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->FuelCardAffectation->FuelCardCar->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', IFNULL(Carmodel.name,'Sans model'))"
            );
        } elseif ($param == 2) {

            $this->FuelCardAffectation->FuelCardCar->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $conditions = array();
        $conditions = $this->getCarConditionsUserParcs($conditions);
        $cars = $this->FuelCardAffectation->FuelCardCar->Car->find('list', array('fields' => 'cnames', 'recursive' => -1, 'order' => 'Carmodel.name asc',
            'conditions' => $conditions,
            'joins' => array(
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
            )

        ));
        $this->set(compact('fuelCards','cars'));
    }

    public function edit($id = null) {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::affectation_carte_carburant, $user_id, ActionsEnum::edit,
            "FuelCardAffectations", $id, "FuelCardAffectation" ,null);
        if (!$this->FuelCardAffectation->exists($id)) {
            throw new NotFoundException(__('Invalid fuel'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Fuel cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->FuelCardCar->deleteAll(array('FuelCardCar.fuel_card_affectation_id' => $id), false);
            $this->request->data['FuelCardAffectation']['modified_id'] = $this->Session->read('Auth.User.id');
            $this->createDateFromDate('FuelCardAffectation', 'start_date');
            $this->createDateFromDate('FuelCardAffectation', 'end_date');
            if ($this->FuelCardAffectation->save($this->request->data)) {

                foreach ($this->request->data['FuelCardCar']['car_id'] as $carId) {
                    $this->FuelCardCar->create();
                    $data = array();
                    $data['FuelCardCar']['car_id'] = $carId;
                    $data['FuelCardCar']['fuel_card_affectation_id'] = $id;
                    $this->FuelCardCar->save($data);
                }
                $this->Flash->success(__('The affectation has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The affectation could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index'));
            }


        }  else {
            $options = array('conditions' => array('FuelCardAffectation.' . $this->FuelCardAffectation->primaryKey => $id));
            $this->request->data = $this->FuelCardAffectation->find('first', $options);
            $carsSelected = $this ->FuelCardAffectation->FuelCardCar->find('list', array('recursive'=>-1,
                'fields'=>array('FuelCardCar.car_id'),
                'conditions'=>array('FuelCardCar.fuel_card_affectation_id'=>$id)));


            $this->set('carsSelected',$carsSelected);
            $fuelCards = $this->FuelCardAffectation->FuelCard->find('list',array('order'=>'FuelCard.reference'));
//Get the structure of the car name from parameters
            $param = $this->Parameter->getCodesParameterVal('name_car');
            if ($param == 1) {
                $this->FuelCardAffectation->FuelCardCar->Car->virtualFields = array(
                    'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
                );
            } elseif ($param == 2) {

                $this->FuelCardAffectation->FuelCardCar->Car->virtualFields = array(
                    'cnames' => "CONCAT(IFNULL(Car.immatr_def,Car.immatr_prov), ' - ',Carmodel.name )"
                );
            }
            $conditions = array();
            $conditions = $this->getCarConditionsUserParcs($conditions);
            $cars = $this->FuelCardAffectation->FuelCardCar->Car->find('list', array('fields' => 'cnames', 'recursive' => -1, 'order' => 'Carmodel.name asc',
                'conditions' => $conditions,
                'joins' => array(
                    array(
                        'table' => 'carmodels',
                        'type' => 'left',
                        'alias' => 'Carmodel',
                        'conditions' => array('Car.carmodel_id = Carmodel.id')
                    ),
                )

            ));
            $this->set(compact('fuelCards','cars'));
        }
    }

    public function delete($id = null) {

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::affectation_carte_carburant, $user_id, ActionsEnum::delete,
            "FuelCardAffectations", $id, "FuelCardAffectation" ,null);
        $this->FuelCardAffectation->id = $id;
        if (!$this->FuelCardAffectation->exists()) {
            throw new NotFoundException(__('Invalid fuel card'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->FuelCardAffectation->delete()) {
            $this->Flash->success(__('The affectation has been deleted.'));
        } else {
            $this->Flash->error(__('The affectation could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }
    public function deleteFuelCardAffectations() {
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $this->FuelCardAffectation->id = $id;
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::affectation_carte_carburant, $user_id, ActionsEnum::delete,
            "FuelCardAffectations", $id, "FuelCardAffectation" ,null);
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->FuelCardAffectation->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }

    }

    private function verifyDependences($id){
        $this->FuelCardCar->deleteAll(array('FuelCardCar.fuel_card_affectation_id' => $id), false);


    }

}