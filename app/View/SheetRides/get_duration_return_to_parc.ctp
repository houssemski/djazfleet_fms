<?php

if(!empty($detail_ride_retour)){
	
	 echo "<div class='form-group' >" . $this->Form->input('departure', array(
                    'label' => __('Departure'),
                    'placeholder' => __('Enter departure'),
					'value'=>$departure_destination_name,
                    'class' => 'form-control',
					'type'=>'hidden',
                    'id'=>"origin_duration_retour",
                    'empty' => ''
                )) . "</div>";


        echo "<div class='form-group' >" . $this->Form->input('arrival', array(
                    'label' => __('Arrival'),
                    'placeholder' => __('Enter arrival'),
					'value'=>$wilayaName,
                    'class' => 'form-control',
                    'id'=>"destination_duration_retour",
					'type'=>'hidden',
                    'empty' => ''
                )) . "</div>";	
			
                 echo "<div >".$this->Form->input('duration_day', array(
                'label' => __('Duration'),
                'readonly'=>true,
                'id'=>'duration_day_retour',
                'value'=>$detail_ride_retour['DetailRide']['duration_day'],
                'placeholder'=>__('Day'),
				'type'=>'hidden',
                'class' => 'form-filter'
                ))."</div>";
                echo "<div >".$this->Form->input('duration_hour', array(
                'label' =>'',
                'readonly'=>true,
                'id'=>'duration_hour_retour',
                'value'=>$detail_ride_retour['DetailRide']['duration_hour'],
                'placeholder'=>__('Hour'),
				'type'=>'hidden',
                'class' => 'form-filter'
                ))."</div>";   
                echo "<div >".$this->Form->input('duration_minute', array(
                'label' =>'',
                'value'=>$detail_ride_retour['DetailRide']['duration_minute'],
                'readonly'=>true,
                'id'=>'duration_minute_retour',
                'placeholder'=>__('Min'),
				'type'=>'hidden',
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
                'id'=>"origin_duration_retour",
                'empty' => ''
            )) . "</div>";
    }else {
        echo "<div class='form-group' >" . $this->Form->input('departure', array(
                'label' => __('Departure'),
                'placeholder' => __('Enter departure'),
                'value'=>$departure_destination_name,
                'class' => 'form-control',
                'type'=>'hidden',
                'id'=>"origin_duration_retour",
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
            'id'=>"destination_duration_retour",
            'type'=>'hidden',
            'empty' => ''
        )) . "</div>";
}	else {

    echo "<div class='form-group' >" . $this->Form->input('arrival', array(
            'label' => __('Arrival'),
            'placeholder' => __('Enter arrival'),
            'value'=>$wilayaName,
            'class' => 'form-control',
            'id'=>"destination_duration_retour",
            'type'=>'hidden',
            'empty' => ''
        )) . "</div>";
}



   echo "<div >".$this->Form->input('duration_day', array(
                'label' => __('Duration'),
                'readonly'=>true,
                'id'=>'duration_day_retour',
                'type'=>'hidden',
                'placeholder'=>__('Day'),
                'class' => 'form-filter'
                ))."</div>";
                echo "<div >".$this->Form->input('duration_hour', array(
                'label' =>'',
                'readonly'=>true,
                'id'=>'duration_hour_retour',
                'type'=>'hidden',
                'placeholder'=>__('Hour'),
                'class' => 'form-filter'
                ))."</div>";   
                echo "<div >".$this->Form->input('duration_minute', array(
                'label' =>'',
                'type'=>'hidden',
                'readonly'=>true,
                'id'=>'duration_minute_retour',
                'placeholder'=>__('Min'),
                'class' => 'form-filter'
                ))."</div>";
			 ?>

	


<?php }?>



