<?php
App::uses('AppModel', 'Model');
/**
 * FuelLog Model
 *
 * 
 */
class FuelLog extends AppModel {


    public $displayField = 'num_fuellog';

    public $validate = array(

     'num_bill' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
          
        ),
       
          'date' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
           'first_number_coupon' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

           'last_number_coupon' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
     
            'num_fuellog' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

    );

        public $hasMany = array(
       
        'Coupon' => array(
            'className' => 'Coupon',
            'foreignKey' => 'fuel_log_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

     public function getDistinctNum() {

        
        
         $query = "SELECT DISTINCT `FuelLog`.`num_bill` FROM `fuel_logs` AS `FuelLog` " ;
              

        return $this->query($query);
    }

    public function getFuelLogs(){

    $query= "SELECT FuelLog.id, SUM(used) as coupon_used, COUNT(used) as total_coupon, num_bill, nb_fuellog,   
      num_fuellog, date, FuelLog.price_coupon, first_number_coupon, last_number_coupon , price, price_remaining
       FROM `coupons` as Coupon  LEFT JOIN fuel_logs  as FuelLog ON FuelLog.id = Coupon.fuel_log_id group by FuelLog.id ";
    $fuellogs= $this->query($query);
   
    
    return $fuellogs;

}


}