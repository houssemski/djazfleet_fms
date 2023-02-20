<?php


if (!empty($detailRide)) {
echo "<div class='form-group' >" . $this->Form->input('departure', array(
    'label' => __('Departure'),
    'placeholder' => __('Enter departure'),
    'class' => 'form-control',
    'type' => 'hidden',
    'id' => "departure".$i,
    'empty' => ''
    )) . "</div>";


echo "<div class='form-group' >" . $this->Form->input('arrival', array(
    'label' => __('Arrival'),
    'placeholder' => __('Enter arrival'),
    'class' => 'form-control',
    'id' => "arrival".$i,
    'type' => 'hidden',
    'empty' => ''
    )) . "</div>";


echo "<div >" . $this->Form->input('duration_day', array(
    'label' => __('Duration'),
    'readonly' => true,
    'value' => $detailRide['DetailRide']['real_duration_day'],
    'placeholder' => __('Day'),
    'id' => 'duration_day_between'.$i,
    'type' => 'hidden',
    'class' => 'form-filter'
    )) . "</div>";
echo "<div >" . $this->Form->input('duration_hour', array(
    'label' => '',
    'readonly' => true,
    'value' => $detailRide['DetailRide']['real_duration_hour'],
    'placeholder' => __('Hour'),
     'id' => 'duration_hour_between'.$i,
    'type' => 'hidden',
    'class' => 'form-filter'
    )) . "</div>";
echo "<div >" . $this->Form->input('duration_minute', array(
    'label' => '',
    'value' => $detailRide['DetailRide']['real_duration_minute'],
    'readonly' => true,
    'placeholder' => __('Min'),
    'id' => 'duration_minute_between'.$i,
    'type' => 'hidden',
    'class' => 'form-filter'
    )) . "</div>";

echo "<div >" . $this->Form->input('distance', array(
    'label' => __('Distance'),
    'readonly' => true,
   'type' => 'hidden',
    'value' => $detailRide['Ride']['distance'],
    'id' => 'distance_between'.$i,
    'class' => 'form-filter'
    )) . "</div>";

} else {
    if(!empty($departureDestinationLatlng)){
        $latlongdef = $departureDestinationLatlng;
        $latlongdef = substr($latlongdef,1);
        $latlongdef = substr ($latlongdef,0,strlen($latlongdef)-1);
        echo "<div class='form-group'>" . $this->Form->input('departure', array(
                'label' => __('Departure'),
                'placeholder' => __('Enter departure'),
                'value' => $latlongdef,
                'class' => 'form-control',
                'type' => 'hidden',
                'id' => "departure".$i,
                'empty' => ''
            )) . "</div>";

    }else {
        echo "<div class='form-group'>" . $this->Form->input('departure', array(
                'label' => __('Departure'),
                'placeholder' => __('Enter departure'),
                'value' => $departureDestinationName,
                'class' => 'form-control',
                'type' => 'hidden',
                'id' => "departure".$i,
                'empty' => ''
            )) . "</div>";
    }


if(!empty($arrivalDestinationLatlng)){
    $latlongdef = $arrivalDestinationLatlng;
    $latlongdef = substr($latlongdef,1);
    $latlongdef = substr ($latlongdef,0,strlen($latlongdef)-1);
    echo "<div class='form-group' >" . $this->Form->input('arrival', array(
            'label' => __('Arrival'),
            'placeholder' => __('Enter arrival'),
            'value' => $latlongdef,
            'class' => 'form-control',
            'id' => "arrival".$i,
            'type' => 'hidden',
            'empty' => ''
        )) . "</div>";
}else{
    echo "<div class='form-group' >" . $this->Form->input('arrival', array(
            'label' => __('Arrival'),
            'placeholder' => __('Enter arrival'),
            'value' => $arrivalDestinationName,
            'class' => 'form-control',
            'id' => "arrival".$i,
            'type' => 'hidden',
            'empty' => ''
        )) . "</div>";
}



echo "<div >" . $this->Form->input('duration_day', array(
    'label' => __('Duration'),
    'readonly' => true,
    'type' => 'hidden',
    'placeholder' => __('Day'),
    'id' => 'duration_day_between'.$i,
    'class' => 'form-filter'
    )) . "</div>";
echo "<div >" . $this->Form->input('duration_hour', array(
    'label' => '',
    'readonly' => true,
    'type' => 'hidden',
    'placeholder' => __('Hour'),
    'id' => 'duration_hour_between'.$i,
    'class' => 'form-filter'
    )) . "</div>";
echo "<div >" . $this->Form->input('duration_minute', array(
    'label' => '',
    'type' => 'hidden',
    'readonly' => true,
    'placeholder' => __('Min'),
     'id' => 'duration_minute_between'.$i,
    'class' => 'form-filter'
    )) . "</div>";

echo "<div >" . $this->Form->input('distance', array(
    'label' => __('Distance'),
    'readonly' => true,
    'type' => 'hidden',
    'id' => 'distance_between'.$i,
    'class' => 'form-filter'
    )) . "</div>";


}

