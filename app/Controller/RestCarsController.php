<?php
class RestCarsController extends AppController {
    public $uses = array('Car');
    public $helpers = array('Html', 'Form');
    public $components = array('RequestHandler');
 
 
    public function index() {
        $cars = $this->Car->find('all',array('conditions' => array('Car.car_status_id'=>array(1,6)),'fields' => array('Mark.name','Carmodel.name','Car.car_status_id')));

		
        $this->set(array(
            'cars' => $cars,
            '_serialize' => array('cars')
        ));

         
    }
      public function indexall() {
       

         $cars_all = $this->Car->find('all',array('fields' => array('Mark.name','Carmodel.name')));

		
        $this->set(array(
            'cars_all' => $cars_all,
            '_serialize' => array('cars_all')
        ));
    }
 
    public function add() {
        $this->Car->create();
        if ($this->Car->save($this->request->data)) {
             $message = 'Created';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }
     
    public function view($id) {
        $car = $this->Car->findById($id);
        $this->set(array(
            'car' => $car,
            '_serialize' => array('car')
        ));
    }
 
     
    public function edit($id) {
        $this->Car->id = $id;
        if ($this->Car->save($this->request->data)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }
     
    public function delete($id) {
        if ($this->Car->delete($id)) {
            $message = 'Deleted';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }
}       
        
?>