<td style="width: 100%;">
    <?php
        echo "<div  class='col-sm-4' style='margin-top: 20px;'>" . $this->Form->input('TransportBillPenalty.'.$item.'.penalty_value', array(
                'label' => __('Value'),
                'class' => 'form-control ',
                'id' => 'penalty_value'.$item,
                'empty'=>'',
            )) . "</div>";
        echo "<div  class='col-sm-4' style='margin-left:32px; margin-top: 20px;'>" . $this->Form->input('TransportBillPenalty.'.$item.'.penalty_amount', array(
                'label' => __('Amount'),
                'class' => 'form-control',
                'id' => 'penalty_amount'.$item,
                'onchange' => 'javascript : calculTotalPrice();'
            )) . "</div>";
    ?>
</td>
<td class="td_tab">
    <button style="margin-top: 25px;" name="remove"
            id="remove_penalty<?php echo $item ?>"
            onclick="removePenalty(this.id);"
            class="btn btn-danger btn_remove">X
    </button>
</td>