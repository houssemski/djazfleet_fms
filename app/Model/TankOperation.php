<?php
App::uses('AppModel', 'Model');

class TankOperation extends AppModel
{


    public $validate = array(


        'liter' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => '',
            ),
        ),


        'date_add' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),

        ),


        'tank_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            ),

        ),


    );


    public $belongsTo = array(

        'Tank' => array(
            'className' => 'Tank',
            'foreignKey' => 'tank_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),


    );

    /** get tank operation with id
     * @param null $tankOperationId
     * @return array|null
     */
    public function getTankOperationById($tankOperationId = null){
        $tankOperation = $this->find('first',array(
            'recursive'=>-1,
            'conditions'=>array('TankOperation.id'=>$tankOperationId),
            'fields'=>array('TankOperation.id','TankOperation.liter','TankOperation.tank_id')
        ));
        return $tankOperation;
    }
    /**
     * Get tank operation by foreign key
     *
     * @param int $id
     * @param string $modelField
     *
     * @return array $consumption
     */
    public function getTankOperationByForeignKey($id, $modelField)
    {
        $tankOperation = $this->find(
            'first',
            array(
                'conditions' => array($modelField => $id),
                'fields' => array('id'),
                'recursive' => -1
            ));
        return $tankOperation;
    }


}