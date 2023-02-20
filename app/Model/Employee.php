<?php

/**

 * @author kahina
 */
class Employee extends AppModel
{

    public $displayField = 'id';

    public $belongsTo = array(

        'Department' => array(
            'className' => 'Department',
            'foreignKey' => 'department_id'
        ),

    );








}