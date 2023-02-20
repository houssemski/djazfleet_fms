<?php
if (!empty($destination['DepartureDestination']['latlng'])){
    $latlongdef = $destination['DepartureDestination']['latlng'];

         $latlongdef = substr($latlongdef,1);

         $latlongdef = substr ($latlongdef,0,strlen($latlongdef)-1);


    echo "<div class='form-group' >" . $this->Form->input($idInput, array(
            'label' => $idInput,
            'type'=>'hidden',
            'placeholder' => __('Enter arrival'),
            'class' => 'form-control',
            'value'=>$latlongdef,
            'id'=>$idInput,
            'empty' => ''
        )) . "</div>";
}else{
    echo "<div class='form-group' >" . $this->Form->input($idInput, array(
            'label' => $idInput,
            'type'=>'hidden',
            'placeholder' => __('Enter arrival'),
            'class' => 'form-control',
            'value'=>$destination['DepartureDestination']['name'],
            'id'=>$idInput,
            'empty' => ''
        )) . "</div>";
}

?>