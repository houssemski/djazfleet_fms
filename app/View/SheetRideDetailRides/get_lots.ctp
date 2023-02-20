<?php

if ($sheetRideDetailRideId != null) {
    echo "<div>" . $this->Form->input('SheetRideDetailRides.edit_lot', array(
            'type' => 'hidden',
            'value' => '1',
            'id' => 'edit_lot',
            'multiple' => true,
            'class' => 'form-filter '
        )) . "</div>";
    echo "<div class='form-group input-file' style='width: 50%;'>" . $this->Form->input('SheetRideDetailRides.lots', array(
            'id' => 'lot' ,
            'options' => $lots,
            'selected'=>$lotIds,
            'class' => 'form-control select3',
            'multiple' => true,
            'empty'=>''
        )) . "</div>";
    echo "</div>";
} else {
    echo "<div class='form-group input-file' style='width: 50%;'>" . $this->Form->input('SheetRideDetailRides.lots', array(
            'id' => 'lot' ,
            'options' => $lots,
            'class' => 'form-control select3',
            'multiple' => true,
            'empty'=>''
        )) . "</div>";
    echo "</div>";
}

