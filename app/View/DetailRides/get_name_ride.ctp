<?php
if (!empty($ride['DepartureDestination']['latlng'])){
    $latlongdef = $ride['DepartureDestination']['latlng'];
    $latlongdef = substr($latlongdef,1);
    $latlongdef = substr ($latlongdef,0,strlen($latlongdef)-1);
    echo "<div class='form-group' >" . $this->Form->input('departure', array(
            'label' => __('Departure'),
            'placeholder' => __('Enter departure'),
            'class' => 'form-control',
            'value'=>$latlongdef,
            'type'=>'hidden',
            'id'=>"origin",
            'empty' => ''
        )) . "</div>";
}else {
    echo "<div class='form-group' >" . $this->Form->input('departure', array(
            'label' => __('Departure'),
            'placeholder' => __('Enter departure'),
            'class' => 'form-control',
            'value'=>$ride['DepartureDestination']['name'],
            'type'=>'hidden',
            'id'=>"origin",
            'empty' => ''
        )) . "</div>";
}

if(!empty($ride['ArrivalDestination']['latlng'])){

    $latlongdef = $ride['ArrivalDestination']['latlng'];

    $latlongdef = substr($latlongdef,1);

    $latlongdef = substr ($latlongdef,0,strlen($latlongdef)-1);
    echo "<div class='form-group' >" . $this->Form->input('arrival', array(
            'label' => __('Arrival'),
            'placeholder' => __('Enter arrival'),
            'class' => 'form-control',
            'value'=>$latlongdef,
            'id'=>"destination",
            'type'=>'hidden',
            'empty' => ''
        )) . "</div>";
}else {
    echo "<div class='form-group' >" . $this->Form->input('arrival', array(
            'label' => __('Arrival'),
            'placeholder' => __('Enter arrival'),
            'class' => 'form-control',
            'value'=>$ride['ArrivalDestination']['name'],
            'id'=>"destination",
            'type'=>'hidden',
            'empty' => ''
        )) . "</div>";
}

?>