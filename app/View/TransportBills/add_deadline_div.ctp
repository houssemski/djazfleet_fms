<td style='width:90%; height: 100px;'>
    <?php
    $currentDate = date("Y-m-d");
    echo "<div class='select-inline' style='width: 350px;'>" . $this->Form->input('Deadline.'.$i.'.deadline_date', array(
            'label' => '',
            'type' => 'text',
            'value' => $this->Time->format($currentDate, '%d/%m/%Y'),
            'class' => 'form-control datemask',
            'before' => '<label class="dte">' . __('Date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
            'after' => '</div>',
            'id' => 'deadline_date'.$i,
        )) . "</div>";

    echo "<div style='clear:both; padding-top: 10px;'></div>";
    echo "<div class='select-inline' >" . $this->Form->input('Deadline.'.$i.'.ristourne_percentage', array(
            'label' => __('Percentage'),
            'class' => 'form-filter ',
            'id' => 'ristourne_percentage'.$i,
            'onchange'=>'javascript : calculateValueDeadline(this.id);'
        )) . "</div>";


    echo "<div class='select-inline' >" . $this->Form->input('Deadline.'.$i.'.value', array(
            'label' => __('Value'),
            'class' => 'form-filter ',
            'id' => 'value'.$i,
            'onchange'=>'javascript : calculatePercentageDeadline(this.id);'
        )) . "</div>";

    ?>
</td>
<td class="td_tab" id='td-button1'>
    <button style="margin-top: 40px; margin-left: 10px;" name="remove"
            id="remove_deadline<?php echo $i?>"
            onclick="removeDeadline(this.id);"
            class="btn btn-danger btn_remove">X
    </button>

</td>