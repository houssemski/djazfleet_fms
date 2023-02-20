

<?php if (!empty($missionCostParameters)) { ?>
    <div id="mission_cost_div">
        <?php
        $i = 1;
        foreach ($missionCostParameters as $missionCostParameter) {
            ?>
            <div id='mission_cost_div<?php echo $i ?>'>
                <?php
                echo "<div class='form-group col-sm-6' style='padding: 0px;'>" . $this->Form->input('MissionCostParameter.' . $i . '.car_type_id', array(
                        'label' => __('Car type'),
                        'class' => 'form-size ',
                        'options' => $carTypes,
                        'id' => 'car_type' . $i,
                        'value' => $missionCostParameter['MissionCostParameter']['car_type_id'],
                        'onchange' => 'javascript : getMissionCostParameters(this.id)',
                        'empty' => ''
                    )) . "</div>"; ?>
                <div id='mission_cost<?php echo $i ?>'>
                    <?php
                    switch ($paramMissionCost) {
                        case 1 :
                            echo "<div class='form-group'>" . $this->Form->input('MissionCostParameter.' . $i . '.mission_cost_day', array(
                                    'label' => __('Mission cost per day'),
                                    'class' => 'form-size',
                                    'value' => $missionCostParameter['MissionCostParameter']['mission_cost_day'],
                                    'empty' => ''
                                )) . "</div>";
                            break;
                        case 2:
                            break;
                        case 3 :
                            echo "<div class='form-group'>" . $this->Form->input('MissionCostParameter.' . $i . '.mission_cost_truck_full', array(
                                    'label' => __('Coefficient mission cost truck full'),
                                    'class' => 'form-size',
                                    'value' => $missionCostParameter['MissionCostParameter']['mission_cost_truck_full'],
                                    'empty' => ''
                                )) . "</div>";
                            echo "<div class='form-group'>" . $this->Form->input('MissionCostParameter.' . $i . '.mission_cost_truck_empty', array(
                                    'label' => __('Coefficient mission cost truck empty'),
                                    'value' => $missionCostParameter['MissionCostParameter']['mission_cost_truck_empty'],
                                    'class' => 'form-size'
                                )) . "</div>";
                            break;
                    }
                    ?>

                </div>
            </div>

            <?php
            $i++;
        }?>
    </div>

<?php } else {
    switch ($paramMissionCost) {
        case 1 :
            ?>
            <div id="mission_cost_div">
                <?php
                echo "<div class='form-group col-sm-6' style='padding: 0px;'>" . $this->Form->input('MissionCostParameter.1.car_type_id', array(
                        'label' => __('Car type'),
                        'class' => 'form-size ',
                        'options' => $carTypes,
                        'id' => 'car_type1',
                        'onchange' => 'javascript : getMissionCostParameters(this.id)',
                        'empty' => ''
                    )) . "</div>";
                ?>
                <div id='div-button'>
                    <button style="margin-top: 5px; width: 40px" type='button'
                            name='add'
                            id='1'
                            onclick='addMissionCostParameterDiv(this.id)'
                            class='btn btn-success'>+
                    </button>

                </div>
                <div id='mission_cost1'>
                    <?php
                    echo "<div class='form-group'>" . $this->Form->input('MissionCostParameter.1.mission_cost_day', array(
                            'label' => __('Mission cost per day'),
                            'class' => 'form-size',
                            'empty' => ''
                        )) . "</div>";
                    ?>
                </div>
            </div>
            <?php   break;
        case 2 :
            break;
        case 3 :
            ?>
            <div id="mission_cost_div">
                <?php
                echo "<div class='form-group col-sm-6' style='padding: 0px;'>" . $this->Form->input('MissionCostParameter.1.car_type_id', array(
                        'label' => __('Car type'),
                        'class' => 'form-size ',
                        'options' => $carTypes,
                        'id' => 'car_type1',
                        'onchange' => 'javascript : getMissionCostParameters(this.id)',
                        'empty' => ''
                    )) . "</div>";
                ?>
                <div id='div-button'>
                    <button style="margin-top: 5px; width: 40px" type='button'
                            name='add'
                            id='1'
                            onclick='addMissionCostParameterDiv(this.id)'
                            class='btn btn-success'>+
                    </button>

                </div>
                <div id='mission_cost1'>
                    <?php
                    echo "<div class='form-group'>" . $this->Form->input('MissionCostParameter.1.mission_cost_truck_full', array(
                            'label' => __('Coefficient mission cost truck full'),
                            'class' => 'form-size',
                            'empty' => ''
                        )) . "</div>";
                    echo "<div class='form-group'>" . $this->Form->input('MissionCostParameter.1.mission_cost_truck_empty', array(
                            'label' => __('Coefficient mission cost truck empty'),
                            'class' => 'form-size'
                        )) . "</div>";
                    ?>
                </div>
            </div>

            <?php
            break;
    }

}
?>


