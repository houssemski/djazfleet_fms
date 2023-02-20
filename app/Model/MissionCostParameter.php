<?php

App::uses('AppModel', 'Model');


class MissionCostParameter extends AppModel
{

    /**
     * Use table
     *
     * @var mixed False or table name
     */

    /**
     * Validation rules
     *
     * @var array
     */

    public $validate = array();

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */

    public $belongsTo = array(

        'CarType' => array(
            'className' => 'CarType',
            'foreignKey' => 'car_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),


    );

    public function getMissionCostParameters($paramMissionCost = null, $carTypeId = null){
        if(!empty($carTypeId)){
            $conditions = array('MissionCostParameter.param_mission_cost'=>$paramMissionCost,
                                'MissionCostParameter.car_type_id'=>$carTypeId
            );
        }else {
            $conditions = array('MissionCostParameter.param_mission_cost'=>$paramMissionCost);
        }

        $missionCostParameters = $this->find('all',
            array(
                'recursive'=>-1,
                'conditions'=>$conditions
        ));
        return $missionCostParameters;
    }

    /**
     * @param null $missionCostParameters
     * @param null $paramMissionCost
     * @throws Exception
     */

    public function addMissionCostParameter($missionCostParameters = null, $paramMissionCost = null)
    {

        foreach ($missionCostParameters as $missionCostParameter) {
            if (!empty($missionCostParameter['car_type_id'])) {
                $data['MissionCostParameter']['param_mission_cost'] = $paramMissionCost;
                $data['MissionCostParameter']['car_type_id'] = $missionCostParameter['car_type_id'];
                if (isset($missionCostParameter['mission_cost_day'])) {
                    $data['MissionCostParameter']['mission_cost_day'] = $missionCostParameter['mission_cost_day'];
                }
                if (isset($missionCostParameter['mission_cost_truck_full'])) {
                    $data['MissionCostParameter']['mission_cost_truck_full'] = $missionCostParameter['mission_cost_truck_full'];
                }
                if (isset($missionCostParameter['mission_cost_truck_empty'])) {
                    $data['MissionCostParameter']['mission_cost_truck_empty'] = $missionCostParameter['mission_cost_truck_empty'];
                }
                $missionCostParameter = $this->getMissionCostParameters($paramMissionCost, $missionCostParameter['car_type_id']);
                if(!empty($missionCostParameter)){
                    $this->id = $missionCostParameter[0]['MissionCostParameter']['id'];
                    $this->save($data);
                }else {
                    $this->create();
                    $this->save($data);
                }


            }
        }
    }


}
