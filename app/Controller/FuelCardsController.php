<?php

App::uses('AppController', 'Controller');
/**
 * FuelLogs Controller
 *
 * @property FuelLog $FuelLog
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */

class FuelCardsController extends AppController{

    public $components = array('Paginator', 'Session','Security');
    var $helpers = array('Xls');
    public $uses = array('FuelCard','FuelCardMouvement');

    public function index() {
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::carte_carburant, $user_id, ActionsEnum::view,
            "FuelCards", null, "FuelCard" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        switch($result) {
            case 1 :
                $conditions = 'FuelCard.id != 0';
                break;
            case 2 :
                $conditions=array('FuelCard.user_id '=>$user_id, 'FuelCard.id !=' => 0);

                break;
            case 3 :
                $conditions=array('FuelCard.user_id !='=>$user_id, 'FuelCard.id !=' => 0);
                break;
            default:
                $conditions = 'FuelCard.id != 0';
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('FuelCard.code' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );

        $this->FuelCard->recursive = 0;
        $this->set('fuelCards', $this->Paginator->paginate());

        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('limit','separatorAmount'));

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
            'order' => array('FuelCard.id' => 'DESC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('fuelCards', $this->Paginator->paginate('FuelCard', array(
                "LOWER(FuelCard.reference) LIKE" => "%$keyword%")));
        } else {
            $this->FuelCard->recursive = 0;
            $this->set('fuelCards', $this->Paginator->paginate());
        }
        $this->set(compact('limit'));
        $this->render();
    }
    public function View($id= null) {
        $this->setTimeActif();
        $fuelCard=$this->FuelCard->find('first', array('conditions'=>array('FuelCard.id'=>$id)));
        $this->loadModel('FuelCardMouvement');
        $fuelCardMouvements=$this->FuelCardMouvement->find('all', array('conditions'=>array('FuelCardMouvement.fuel_card_id'=>$id),
            'fields'=>array('FuelCardMouvement.id','FuelCardMouvement.amount','FuelCardMouvement.transact_type_id','FuelCardMouvement.date_mouvement',
            'Car.code','Car.immatr_def','Carmodel.name'
            ),
            'recursive'=>-1,
            'joins' => array(

                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('FuelCardMouvement.sheet_ride_id = SheetRide.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('SheetRide.car_id = Car.id')
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
        $this->set(compact('fuelCardMouvements', 'fuelCard','param'));
    }
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::carte_carburant, $user_id, ActionsEnum::add,
            "FuelCards", null, "FuelCard" ,null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->FuelCard->create();
            $this->request->data['FuelCard']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->FuelCard->save($this->request->data)) {
                $this->Flash->success(__('The fuel card has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The fuel card could not be saved. Please, try again.'));
            }
        }
    }

    public function edit($id = null) {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::carte_carburant, $user_id, ActionsEnum::edit,
            "FuelCards", $id, "FuelCard" ,null);
        if (!$this->FuelCard->exists($id)) {
            throw new NotFoundException(__('Invalid fuel'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Fuel cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['FuelCard']['modified_id'] = $this->Session->read('Auth.User.id');
            if ($this->FuelCard->save($this->request->data)) {
                $this->Flash->success(__('The fuel card has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The fuel card could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('FuelCard.' . $this->FuelCard->primaryKey => $id));
            $this->request->data = $this->FuelCard->find('first', $options);
            //$this->is_opened("Fuel",'Fuels','fuel',$id);
        }
    }

    public function delete($id = null) {

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::carte_carburant, $user_id, ActionsEnum::delete,
            "FuelCards", $id, "FuelCard" ,null);
        $this->FuelCard->id = $id;
        if (!$this->FuelCard->exists()) {
            throw new NotFoundException(__('Invalid fuel card'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->FuelCard->delete()) {
            $this->Flash->success(__('The fuel card has been deleted.'));
        } else {
            $this->Flash->error(__('The fuel card could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }
    public function deletefuelcards() {
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");

        $this->FuelCard->id = $id;
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::carte_carburant, $user_id, ActionsEnum::delete,
            "FuelCards", $id, "FuelCard" ,null);
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->FuelCard->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }

    }

    private function verifyDependences($id){
        $this->setTimeActif();
        $this->loadModel('Consumption');
        $result = $this->Consumption->find('all', array("conditions" => array("Consumption.fuel_card_id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The fuel card could not be deleted. Coupons of this fuel log are already used.'));
            $this->redirect(array('action' => 'index'));
        }


    }
    function export() {
        $this->setTimeActif();
        $fuelCards = $this->FuelCard->find('all', array(
            'order' => 'FuelCard.reference asc',
            'recursive' => -1
        ));
        $this->set('models', $fuelCards);
    }

    public function  credit($id=null) {



        if (!empty($this->request->data)) {

           // $this->layout = 'popup';

            if (!empty($this->request->data)) {
                $this->loadModel('FuelCardMouvement');
                $this->FuelCardMouvement->create();
                date_default_timezone_set("Africa/Algiers");
                $currentDate = date("Y-m-d");
                $this->request->data['FuelCardMouvement']['transact_type_id']=1;
                $this->request->data['FuelCardMouvement']['fuel_card_id']=$id;
                $this->request->data['FuelCardMouvement']['date_mouvement']=$currentDate;
                $this->request->data['FuelCardMouvement']['user_id'] = $this->Session->read('Auth.User.id');
                if ($this->FuelCardMouvement->save($this->request->data)) {
                    $fuelCard= $this->FuelCard->find('first',array('conditions'=>array('FuelCard.id'=>$id)));
                    $amount = $fuelCard['FuelCard']['amount'] + $this->request->data['FuelCardMouvement'] ['amount'];
                    $this->FuelCard->id = $id;
                    $this->FuelCard->saveField('amount', $amount);
                    $this->redirect(array('action' => 'index'));

                }
            }


        }


    }

}