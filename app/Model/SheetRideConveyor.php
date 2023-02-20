<?php



App::uses('AppModel', 'Model');

/**
 * SheetRideDetailRides Model
 *
 */
class SheetRideConveyor extends AppModel
{

    /**
     * Use table
     *
     * @var mixed False or table name
     */

    public $validate = array(


        /* 'detail_ride_id' => array(
         'notBlank' => array(
         'rule' => array('notBlank'),
         //'message' => 'Your custom message here',
         //'allowEmpty' => false,
         //'required' => false,
         //'last' => false, // Stop validation after this rule
         //'on' => 'create', // Limit validation to 'create' or 'update' operations
     ),
 ),*/

        'sheet_ride_id' => array(
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


    public $belongsTo = array(

        'SheetRide' => array(
            'className' => 'SheetRide',
            'foreignKey' => 'sheet_ride_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),


        'Customer' => array(
            'className' => 'Customer',
            'foreignKey' => 'conveyor_id'
        ),
    );

    /**
     * @param null $sheetRideConveyors
     * @param null $sheetRideId
     */

    public function addSheetRideConveyors($sheetRideConveyors= null, $sheetRideId = null)
    {
        foreach($sheetRideConveyors as $sheetRideConveyor){
            if(!empty($sheetRideConveyor['conveyor_id'])){
                $data['SheetRideConveyor']['sheet_ride_id']=$sheetRideId;
                $data['SheetRideConveyor']['conveyor_id']=$sheetRideConveyor['conveyor_id'];
                $this->create();
                $this->save($data);
            }
        }
    }

    public function addSheetRideConveyor($sheetRideConveyor= null, $sheetRideId = null)
    {
            if(!empty($sheetRideConveyor['conveyor_id'])){
                $data['SheetRideConveyor']['sheet_ride_id']=$sheetRideId;
                $data['SheetRideConveyor']['conveyor_id']=$sheetRideConveyor['conveyor_id'];
                $this->create();
                $this->save($data);
            }

    }

    public function updateSheetRideConveyor($sheetRideConveyor= null, $sheetRideId = null)
    {
            if(!empty($sheetRideConveyor['conveyor_id'])){
                $data['SheetRideConveyor']['id']=$sheetRideConveyor['id'];
                $data['SheetRideConveyor']['sheet_ride_id']=$sheetRideId;
                $data['SheetRideConveyor']['conveyor_id']=$sheetRideConveyor['conveyor_id'];
                $this->save($data);
            }else {
                $this->id= $sheetRideConveyor['id'];
                $this->delete();
            }

    }



    public function getConveyorsBySheetRideId($sheetRideId = null){
         $sheetRideConveyors = $this->find('all',array('recursive'=>-1,
            'conditions'=>array('SheetRideConveyor.sheet_ride_id'=>$sheetRideId),
            'fields'=>array('SheetRideConveyor.id','SheetRideConveyor.conveyor_id')
        ));

        return $sheetRideConveyors;

    }


}
