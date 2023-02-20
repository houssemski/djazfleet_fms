<?php

if(!empty($detail_ride_retour)){
	
	 echo "<div class='form-group' >" . $this->Form->input('departure', array(
                    'label' => __('Departure'),
                    'placeholder' => __('Enter departure'),
					'value'=>$departure_destination_name,
                    'class' => 'form-control',
					'type'=>'hidden',
                    'id'=>"origin_distance_retour",
                    'empty' => ''
                )) . "</div>";


        echo "<div class='form-group' >" . $this->Form->input('arrival', array(
                    'label' => __('Arrival'),
                    'placeholder' => __('Enter arrival'),
					'value'=>$wilayaName,
                    'class' => 'form-control',
                    'id'=>"destination_distance_retour",
					'type'=>'hidden',
                    'empty' => ''
                )) . "</div>";	

				
				 echo "<div >".$this->Form->input('distance', array(
                'label' => __('Distance'),
                'readonly'=>true,
				 'type'=>'hidden',
                'value'=>$detail_ride_retour['Ride']['distance'],
                'id'=>'distance_retour',
                'class' => 'form-filter'
                ))."</div>";

}else {
    if(!empty($departureDestinationLatlng)){
        $latlongdef = $departureDestinationLatlng;

        $latlongdef = substr($latlongdef,1);

        $latlongdef = substr ($latlongdef,0,strlen($latlongdef)-1);
        echo "<div class='form-group' >" . $this->Form->input('departure', array(
                'label' => __('Departure'),
                'placeholder' => __('Enter departure'),
                'value'=>$latlongdef,
                'class' => 'form-control',
                'type'=>'hidden',
                'id'=>"origin_distance_retour",
                'empty' => ''
            )) . "</div>";
    }else {
        echo "<div class='form-group' >" . $this->Form->input('departure', array(
                'label' => __('Departure'),
                'placeholder' => __('Enter departure'),
                'value'=>$departure_destination_name,
                'class' => 'form-control',
                'type'=>'hidden',
                'id'=>"origin_distance_retour",
                'empty' => ''
            )) . "</div>";
    }


				
if(!empty($wilayaLatlng))	{
    $latlongdef = $wilayaLatlng;
    $latlongdef = substr($latlongdef,1);
    $latlongdef = substr ($latlongdef,0,strlen($latlongdef)-1);
    echo "<div class='form-group' >" . $this->Form->input('arrival', array(
            'label' => __('Arrival'),
            'placeholder' => __('Enter arrival'),
            'value'=>$latlongdef,
            'class' => 'form-control',
            'id'=>"destination_distance_retour",
            'type'=>'hidden',
            'empty' => ''
        )) . "</div>";
}	else {

    echo "<div class='form-group' >" . $this->Form->input('arrival', array(
            'label' => __('Arrival'),
            'placeholder' => __('Enter arrival'),
            'value'=>$wilayaName,
            'class' => 'form-control',
            'id'=>"destination_distance_retour",
            'type'=>'hidden',
            'empty' => ''
        )) . "</div>";
}


				
				 echo "<div >".$this->Form->input('distance', array(
                'label' => __('Distance'),
                'readonly'=>true,
				 'type'=>'hidden',
                'id'=>'distance_retour',
                'class' => 'form-filter'
                ))."</div>"; ?>

	


<?php }?>



