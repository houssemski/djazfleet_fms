<?php
echo "<div class='select-inline' style='width: 24%;'>" . $this->Form->input('SheetRideDetailRides.'.$num.'.SheetRideDetailRideMarchandise.'.$i.'.weight_palette', array(
        'label' => __(''),
        'placeholder' => __('Enter weight truck'),
        'id' => 'weight_palette'.$num.$i,
        'value'=>$marchandise['Marchandise']['weight_palette'],
        'type'=>'hidden',
        'class' => 'form-filter'
    )) . "</div>";

echo "<div class='select-inline' style='width: 24%;'>" . $this->Form->input('SheetRideDetailRides.'.$num.'.SheetRideDetailRideMarchandise.'.$i.'.weight', array(
        'label' => __(''),
        'placeholder' => __('Enter weight truck'),
        'id' => 'weight'.$num.$i,
        'value'=>$marchandise['Marchandise']['weight'],
        'type'=>'hidden',
        'class' => 'form-filter'
    )) . "</div>";