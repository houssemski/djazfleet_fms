<?php
if($withPenalty ==1){ ?>
<table  id='table_penalty'>
    <tr id='penalty1'>
       <td style="width: 100%;">

                                            <?php



echo "<div  class='  col-sm-4'>" . $this->Form->input('TransportBillPenalty.1.penalty_value', array(
    'label' => __('Value'),
    'class' => 'form-control ',
    'id' => 'penalty_value1',
    'empty'=>'',
    )) . "</div>";

echo "<div  class='col-sm-4' style='margin-left:32px;'>" . $this->Form->input('TransportBillPenalty.1.penalty_amount', array(
    'label' => __('Amount'),
    'class' => 'form-control',
    'id' => 'penalty_amount1',
    'onchange' => 'javascript : calculTotalPrice();'
    )) . "</div>";

    echo "<div >" . $this->Form->input('TransportBill.nb_penalty', array(
            'class' => 'form-control',
            'id' => 'nb_penalty',
            'value' => 1,
            'type' => 'hidden',
        )) . "</div>";


 ?>

                                        </td>
       <td class="td_tab">
            <button  type='button' name='add'
                     onclick='addRowPenalty()'
                     class='btn btn-success'><?= __('Add more') ?>
            </button>
       </td>

     </tr>
</table>
<div style='clear:both; padding-bottom: 20px;'></div>
    <?php
} ?>