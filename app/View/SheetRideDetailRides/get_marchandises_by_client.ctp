
<table   id='dynamic_field' style='width: 100%;'>
    <tr id="row<?php echo $i?>" style="height: 70px;">
        <td id='marchandise-quantity<?php echo $i ?>'  style="width: 50%;">
            <?php
            if($fieldMarchandiseRequired ==1){
                echo "<div class='select-inline small-select' style='width: 37%;'>" . $this->Form->input('SheetRideDetailRides.SheetRideDetailRideMarchandise.'.$i.'.marchandise_id', array(
                        'label' => __(''),
                        'empty' => '',
                        'required'=>true,
                        'id' => 'marchandise'.$i,
                        'options' => $marchandises,
                        'onchange'=>'javascript : getWeightByMarchandise(this.id,'.$i.');',
                        'class' => 'form-filter select3'
                    )) . "</div>";

                echo "<div class='select-inline' style='width: 37%;'>" . $this->Form->input('SheetRideDetailRides.SheetRideDetailRideMarchandise.'.$i.'.quantity', array(
                        'label' => __(''),
                        'required'=>true,
                        'placeholder' => __('Enter quantity'),
                        'id' => 'quantity'.$i,
                        'onchange'=>'javascript : verifyQuantity(this.id,'.$i.');',
                        'class' => 'form-filter'
                    )) . "</div>";

            }else {
                echo "<div class='select-inline small-select' style='width: 37%;'>" . $this->Form->input('SheetRideDetailRides.SheetRideDetailRideMarchandise.'.$i.'.marchandise_id', array(
                        'label' => __(''),
                        'empty' => '',
                        'id' => 'marchandise'.$i,
                        'options' => $marchandises,
                        'onchange'=>'javascript : getWeightByMarchandise(this.id,'.$i.');',
                        'class' => 'form-filter select3'
                    )) . "</div>";

                echo "<div class='select-inline' style='width: 37%;'>" . $this->Form->input('SheetRideDetailRides.SheetRideDetailRideMarchandise.'.$i.'.quantity', array(
                        'label' => __(''),
                        'placeholder' => __('Enter quantity'),
                        'id' => 'quantity'.$i,
                        'onchange'=>'javascript : verifyQuantity(this.id,'.$i.');',
                        'class' => 'form-filter'
                    )) . "</div>";

            }


            ?>
            <div id='weight-div<?php echo $i?>'>
            </div>
        </td>
        <td class="td_tab">
            <button  style="margin-left: 0px;" type='button' name='add' id='add<?php echo $i?>' onclick="addOtherMarchandises(<?php echo $i?>)" class='btn btn-success add_marchandise'><?=__('Add more')?></button>
        </td>

    </tr>
</table>





