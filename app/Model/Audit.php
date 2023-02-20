<?php

/**

 * @author kahina
 */
class Audit extends AppModel
{

  

      public $belongsTo = array(

        'Rubric' => array(
            'className' => 'Rubric',
            'foreignKey' => 'rubric_id'
        ),
         'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
        

        
    );



    
}