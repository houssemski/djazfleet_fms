<td style ='width:99%; height: 100px;'>
    <?php
	$currentDate = date("Y-m-d H:i");
    echo "<div class='select-inline'>" . $this->Form->input('Consumption.'.$i.'.consumption_date', array(
            'label' => '',
            'type' => 'text',
            'class' => 'form-control datemask',
            'placeholder' => _('dd/mm/yyyy hh:mm'),
			'value'=>$this->Time->format($currentDate, '%d/%m/%Y %H:%M'),
            'before' => '<label class="dte">' . __('Date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
            'after' => '</div>',
            'id' => 'consumption_date'.$i,
        )) . "</div>";

    $options = array('0' => '');
    if ($paramConsumption['0'] == 1) {
        if ($options != null) {
            $options = array_replace($options, array('1' => __('Coupons')));
        } else {
            $options = array('1' => __('Coupons'));
        }
    }
    if ($paramConsumption['1'] == 1) {
        if ($options != null) {
            $options = array_replace($options, array('2' => __('Species')));
        } else {
            $options = array('2' => __('Species'));
        }
    }
    if ($paramConsumption['2'] == 1) {
        if ($options != null) {
            $options = array_replace($options, array('3' => __('Tank')));
        } else {
            $options = array('3' => __('Tank'));
        }
    }
    if ($paramConsumption['3'] == 1) {
        if ($options != null) {
            $options = array_replace($options, array('4' => __('Cards')));
        } else {
            $options = array('4' => __('Cards'));
        }
    }
    echo "<div class='select-inline' >" . $this->Form->input('Consumption.'.$i.'.type_consumption_used', array(
            'label'=>__('Consumption type'),
            'class' => 'form-filter select3',
            'options' => $options,
            'id' => 'type_consumption'.$i,
            'value'=>$defaultConsumptionMethod,
            'onchange'=>'javascript : addConsumptionMethod(this.id);'
        )) . "</div>"; ?>

    <div id='consumption-method<?php echo $i ?>'></div>
</td>
<td class="td_tab" id ='td-button<?php echo $i ;?>'>

    <button style="margin-top: 25px;" name="remove" id="remove_consumption<?php echo $i ;?>" onclick="removeConsumption(this.id);" class="btn btn-danger btn_remove">X</button>

</td>

