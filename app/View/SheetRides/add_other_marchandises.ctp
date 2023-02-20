
<td id='marchandise-quantity<?php echo $i ?>' style="width: 50%;">
    <?php
    if($fieldMarchandiseRequired){
        echo "<div class='select-inline small-select' style='width: 37%;'>" . $this->Form->input('SheetRideDetailRides.'.$num.'.SheetRideDetailRideMarchandise.'.$i.'.marchandise_id', array(
                'label' => __(''),
                'empty' => '',
                'id' => 'marchandise'.$num.$i,
                'options' => $marchandises,
                'required'=>true,
                'onchange'=>'javascript : getWeightByMarchandise(this.id'.$num.','.$i.');',
                'class' => 'form-filter select3'
            )) . "</div>";

        echo "<div class='select-inline' style='width: 37%;'>" . $this->Form->input('SheetRideDetailRides.'.$num.'.SheetRideDetailRideMarchandise.'.$i.'.quantity', array(
                'label' => __(''),
                'placeholder' => __('Enter quantity'),
                'id' => 'quantity'.$num.$i,
                'required'=>true,
                'onchange'=>'javascript : verifyQuantity(this.id,'.$num.','.$i.');',
                'class' => 'form-filter'
            )) . "</div>";
    }else {
        echo "<div class='select-inline small-select' style='width: 37%;'>" . $this->Form->input('SheetRideDetailRides.'.$num.'.SheetRideDetailRideMarchandise.'.$i.'.marchandise_id', array(
                'label' => __(''),
                'empty' => '',
                'id' => 'marchandise'.$num.$i,
                'options' => $marchandises,
                'onchange'=>'javascript : getWeightByMarchandise(this.id'.$num.','.$i.');',
                'class' => 'form-filter select3'
            )) . "</div>";

        echo "<div class='select-inline' style='width: 37%;'>" . $this->Form->input('SheetRideDetailRides.'.$num.'.SheetRideDetailRideMarchandise.'.$i.'.quantity', array(
                'label' => __(''),
                'placeholder' => __('Enter quantity'),
                'id' => 'quantity'.$num.$i,
                'onchange'=>'javascript : verifyQuantity(this.id,'.$num.','.$i.');',
                'class' => 'form-filter'
            )) . "</div>";
    }

    ?>
    <div id='weight-div<?php echo $num?><?php echo $i?>'>
    </div>
</td>