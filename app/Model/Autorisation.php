<?php

/**

 * @author kahina
 */
class Autorisation extends AppModel
{

  

      public $belongsTo = array(

        'CustomerCar' => array(
            'className' => 'CustomerCar',
            'foreignKey' => 'customer_car_id'
        ),
         'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
        

        
    );



    
}