<td>
<?php

echo "<div class='form-group'>" . $this->Form->input('MissionCost.' . $i . '.ride_category_id', array(
        'label' => __('Ride category'),

        'empty' => '',
        'id' => 'car_type',
        'class' => 'form-control select2',
    )) . "</div>";


echo "<div class='form-group'>" . $this->Form->input('MissionCost.' . $i . '.cost_truck_full', array(
        'label' => __('Mission costs truck full'),
        'placeholder' => __('Enter cost'),
        'class' => 'form-control',
        'id'=>'cost_truck_full'
    )) . "</div>";
echo "<div class='form-group'>" . $this->Form->input('MissionCost.' . $i . '.cost_truck_empty', array(
        'label' => __('Mission costs truck empty'),
        'placeholder' => __('Enter cost'),
        'class' => 'form-control',
        'id'=>'cost_truck_empty'
    )) . "</div>"; ?>

    </td>
<td class="td_tab"><button style="margin-left: 40px;" name="remove" id="<?php echo $i-1;?>" onclick="remove('<?php echo $i-1;?>');" class="btn btn-danger btn_remove">X</button></td>