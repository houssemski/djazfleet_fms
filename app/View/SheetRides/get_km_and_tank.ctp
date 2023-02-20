<?php


echo "<div class='select-inline' >" .$this->Form->input('SheetRide.km_departure', array(
                    'label' => __('Departure Km'),
                    'placeholder' => __('Enter departure Km'),
					'onchange'=>'javascript: calculKmDepartureEstimatedFirstRide(this) ,calculateForecast(this);',
                    'class' => 'form-filter',
                    'id' => 'km_dep',
                    'value'=>$km,
                )) . "</div>";


if($tankStateMethod==2) {
    echo "<div class='select-inline' >" . $this->Form->input('SheetRide.tank_departure', array(
            'label' => __('Departure tank'),
            'placeholder' => __('Enter departure tank in liters'),


            'value' => $reservoir,
            'class' => 'form-filter',
            'id' => 'departure_tank',
            'empty' => '',
            'onchange' => 'javascript:estimateCost() ;'
        )) . "</div>";

}else {

    echo "<div class='select-inline' >" . $this->Form->input('SheetRide.tank_departure', array(
            'label' => __('Departure tank'),
            'placeholder' => __('Enter departure tank in liters'),
            'type'=>'hidden',

            'value' => $reservoir,
            'class' => 'form-filter',
            'id' => 'departure_tank',
            'empty' => '',
            'onchange' => 'javascript:estimateCost() ;'
        )) . "</div>";
}
?>