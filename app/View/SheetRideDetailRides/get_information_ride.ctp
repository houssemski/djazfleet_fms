<?php
if(isset($observations)){
    echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.observation_id', array(
            'label' => __('Observation'),
            'options' => $observations,
            'class' => 'form-filter'
        )) . "</div>";
}
if(isset($transportBillDetailRideId)){
    echo "<div >" . $this->Form->input('SheetRideDetailRides.transport_bill_detail_ride', array(
            'type' => 'hidden',
            'id' => 'transport_bill_detail_ride',
            'value' => $transportBillDetailRideId,
            'class' => 'form-control',
        )) . "</div>";
}
if ($rideId != 0) {

    if(isset($ride)){

        if ($ride['DepartureDestination']['latlng']) {
            $latlongdef = $ride['DepartureDestination']['latlng'];
            $latlongdef = substr($latlongdef, 1);
            $latlongdef = substr($latlongdef, 0, strlen($latlongdef) - 1);
            echo "<div class=' hidden' >" . $this->Form->input('arrival', array(
                    'label' => __('Arrival'),
                    'value' => $latlongdef,
                    'class' => 'form-control',
                    'id' => "destinationName",
                    'type' => 'hidden',
                    'empty' => ''
                )) . "</div>";
        } else {
            echo "<div class=' hidden' >" . $this->Form->input('arrival', array(
                    'label' => __('Arrival'),
                    'value' => $ride['DepartureDestination']['name'],
                    'class' => 'form-control',
                    'id' => "destinationName",
                    'type' => 'hidden',
                    'empty' => ''
                )) . "</div>";
        }

    } else {
        echo "<div class=' hidden' >" . $this->Form->input('arrival', array(
                'label' => __('Arrival'),
                'class' => 'form-control',
                'id' => "destinationName",
                'type' => 'hidden',
                'empty' => ''
            )) . "</div>";
    }

    if (isset($ride)) {
        $duration = $ride['DetailRide']['real_duration_day'] . ' ' . __('Day') . ' ' . $ride['DetailRide']['real_duration_hour'] . ' ' . __('Hour') . ' ' . $ride['DetailRide']['real_duration_minute'] . ' ' . __('min');
        echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.duration', array(
                'label' => __('Duration'),
                'disabled' => true,
                'value' => $duration,

                'class' => 'form-filter'
            )) . "</div>";
        echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_day', array(
                'label' => __('Duration'),
                'readonly' => true,
                'id' => 'duration_day',
                'value' => $ride['DetailRide']['duration_day'],
                'placeholder' => __('Day'),
                'type' => 'hidden',
                'class' => 'form-filter'
            )) . "</div>";
        echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_hour', array(
                'label' => '',
                'readonly' => true,
                'id' => 'duration_hour',
                'value' => $ride['DetailRide']['duration_hour'],
                'placeholder' => __('Hour'),
                'type' => 'hidden',
                'class' => 'form-filter'
            )) . "</div>";
        echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_minute', array(
                'label' => '',
                'value' => $ride['DetailRide']['duration_minute'],
                'readonly' => true,
                'id' => 'duration_minute',
                'placeholder' => __('Min'),
                'type' => 'hidden',
                'class' => 'form-filter'
            )) . "</div>";

    } else {


        echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.duration', array(
                'label' => __('Duration'),
                'disabled' => true,
                'class' => 'form-filter'
            )) . "</div>";
        echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_day', array(
                'label' => __('Duration'),
                'readonly' => true,
                'id' => 'duration_day' ,
                'type' => 'hidden',
                'placeholder' => __('Day'),
                'class' => 'form-filter'
            )) . "</div>";
        echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_hour', array(
                'label' => '',
                'readonly' => true,
                'id' => 'duration_hour',
                'type' => 'hidden',
                'placeholder' => __('Hour'),
                'class' => 'form-filter'
            )) . "</div>";
        echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_minute', array(
                'label' => '',
                'type' => 'hidden',
                'readonly' => true,
                'id' => 'duration_minute',
                'placeholder' => __('Min'),
                'class' => 'form-filter'
            )) . "</div>";

    }
    if (isset($distance_ride)) {

        echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.distance', array(
                'label' => __('Distance'),
                'readonly' => true,
                'value' => $distance_ride['Ride']['distance'],
                'id' => 'distance',
                'class' => 'form-filter'
            )) . "</div>";
    } else {
        echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.distance', array(
                'label' => __('Distance'),
                'readonly' => true,
                'id' => 'distance' ,
                'class' => 'form-filter'
            )) . "</div>";

    }

} else {
    if(!empty($ride)||!empty($distance_ride)){


        if(isset($ride)){

            if ($ride['DepartureDestination']['latlng']) {
                $latlongdef = $ride['DepartureDestination']['latlng'];
                $latlongdef = substr($latlongdef, 1);
                $latlongdef = substr($latlongdef, 0, strlen($latlongdef) - 1);
                echo "<div class=' hidden' >" . $this->Form->input('arrival', array(
                        'label' => __('Arrival'),
                        'value' => $latlongdef,
                        'class' => 'form-control',
                        'id' => "destinationName",
                        'type' => 'hidden',
                        'empty' => ''
                    )) . "</div>";
            } else {
                echo "<div class=' hidden' >" . $this->Form->input('arrival', array(
                        'label' => __('Arrival'),
                        'value' => $ride['DepartureDestination']['name'],
                        'class' => 'form-control',
                        'id' => "destinationName",
                        'type' => 'hidden',
                        'empty' => ''
                    )) . "</div>";
            }

        } else {
            echo "<div class=' hidden' >" . $this->Form->input('arrival', array(
                    'label' => __('Arrival'),
                    'class' => 'form-control',
                    'id' => "destinationName",
                    'type' => 'hidden',
                    'empty' => ''
                )) . "</div>";
        }

        if (isset($ride)) {
            $duration = $ride['DetailRide']['real_duration_day'] . ' ' . __('Day') . ' ' . $ride['DetailRide']['real_duration_hour'] . ' ' . __('Hour') . ' ' . $ride['DetailRide']['real_duration_minute'] . ' ' . __('min');
            echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.duration', array(
                    'label' => __('Duration'),
                    'disabled' => true,
                    'value' => $duration,

                    'class' => 'form-filter'
                )) . "</div>";
            echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_day', array(
                    'label' => __('Duration'),
                    'readonly' => true,
                    'id' => 'duration_day' ,
                    'value' => $ride['DetailRide']['duration_day'],
                    'placeholder' => __('Day'),
                    'type' => 'hidden',
                    'class' => 'form-filter'
                )) . "</div>";
            echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_hour', array(
                    'label' => '',
                    'readonly' => true,
                    'id' => 'duration_hour' ,
                    'value' => $ride['DetailRide']['duration_hour'],
                    'placeholder' => __('Hour'),
                    'type' => 'hidden',
                    'class' => 'form-filter'
                )) . "</div>";
            echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_minute', array(
                    'label' => '',
                    'value' => $ride['DetailRide']['duration_minute'],
                    'readonly' => true,
                    'id' => 'duration_minute' ,
                    'placeholder' => __('Min'),
                    'type' => 'hidden',
                    'class' => 'form-filter'
                )) . "</div>";

        } else {


            echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.duration', array(
                    'label' => __('Duration'),
                    'disabled' => true,
                    'class' => 'form-filter'
                )) . "</div>";
            echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_day', array(
                    'label' => __('Duration'),
                    'readonly' => true,
                    'id' => 'duration_day',
                    'type' => 'hidden',
                    'placeholder' => __('Day'),
                    'class' => 'form-filter'
                )) . "</div>";
            echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_hour', array(
                    'label' => '',
                    'readonly' => true,
                    'id' => 'duration_hour' ,
                    'type' => 'hidden',
                    'placeholder' => __('Hour'),
                    'class' => 'form-filter'
                )) . "</div>";
            echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_minute', array(
                    'label' => '',
                    'type' => 'hidden',
                    'readonly' => true,
                    'id' => 'duration_minute' ,
                    'placeholder' => __('Min'),
                    'class' => 'form-filter'
                )) . "</div>";

        }
        if (isset($distance_ride)) {

            echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.distance', array(
                    'label' => __('Distance'),
                    'readonly' => true,
                    'value' => $distance_ride['Ride']['distance'],
                    'id' => 'distance' ,
                    'class' => 'form-filter'
                )) . "</div>";
        } else {
            echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.distance', array(
                    'label' => __('Distance'),
                    'readonly' => true,
                    'id' => 'distance' ,
                    'class' => 'form-filter'
                )) . "</div>";

        }
    }else {
        if (!empty($departureDestination)) {


            if ($departureDestination['Destination']['latlng']) {
                $latlongdef = $departureDestination['Destination']['latlng'];

                $latlongdef = substr($latlongdef, 1);

                $latlongdef = substr($latlongdef, 0, strlen($latlongdef) - 1);

                echo "<div class=' hidden' >" . $this->Form->input('destination', array(
                        'label' => __('Arrival'),
                        'value' => $latlongdef,
                        'class' => 'form-control',
                        'id' => "destinationName".$i,
                        'type' => 'hidden',
                        'empty' => ''
                    )) . "</div>";
            } else {
                echo "<div class=' hidden' >" . $this->Form->input('destination', array(
                        'label' => __('Arrival'),
                        'value' => $departureDestination['Destination']['name'],
                        'class' => 'form-control',
                        'id' => "destinationName".$i,
                        'type' => 'hidden',
                        'empty' => ''
                    )) . "</div>";

            }

        }
        if (!empty($arrivalDestination)) {


            if ($arrivalDestination['Destination']['latlng']) {
                $latlongdef = $arrivalDestination['Destination']['latlng'];

                $latlongdef = substr($latlongdef, 1);

                $latlongdef = substr($latlongdef, 0, strlen($latlongdef) - 1);

                echo "<div class=' hidden' >" . $this->Form->input('arrival', array(
                        'label' => __('Arrival'),
                        'value' => $latlongdef,
                        'class' => 'form-control',
                        'id' => "arrivalName".$i,
                        'type' => 'hidden',
                        'empty' => ''
                    )) . "</div>";
            } else {
                echo "<div class=' hidden' >" . $this->Form->input('arrival', array(
                        'label' => __('Arrival'),
                        'value' => $arrivalDestination['Destination']['name'],
                        'class' => 'form-control',
                        'id' => "arrivalName".$i,
                        'type' => 'hidden',
                        'empty' => ''
                    )) . "</div>";

            }

        }
        echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.duration', array(
                'label' => __('Duration'),
                'disabled' => true,
                'id'=>'duration',
                'class' => 'form-filter'
            )) . "</div>";
        echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_day', array(
                'label' => __('Duration'),
                'readonly' => true,
                'id' => 'duration_day',
                'placeholder' => __('Day'),
                'type' => 'hidden',
                'class' => 'form-filter'
            )) . "</div>";
        echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_hour', array(
                'label' => '',
                'readonly' => true,
                'id' => 'duration_hour',
                'placeholder' => __('Hour'),
                'type' => 'hidden',
                'class' => 'form-filter'
            )) . "</div>";
        echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_minute', array(
                'label' => '',
                'readonly' => true,
                'id' => 'duration_minute' ,
                'placeholder' => __('Min'),
                'type' => 'hidden',
                'class' => 'form-filter'
            )) . "</div>";

        echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.distance', array(
                'label' => __('Distance'),
                'readonly' => true,
                'id' => 'distance' ,
                'class' => 'form-filter'
            )) . "</div>";


    }


}
if (isset($missionCosts))
    echo "<div style='clear:both; padding-top: 10px;'></div>";



?>