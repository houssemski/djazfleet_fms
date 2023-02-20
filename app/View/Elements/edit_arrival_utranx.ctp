
<div class="filters" id='filters' style="min-height: 100px;">

    <?php
    if (!empty($retourParc)) {
        if (!empty($retourParc['detailRide'])) {
            echo "<div >" . $this->Form->input('departure', array(
                    'label' => __('Departure'),
                    'class' => 'form-control',
                    'type' => 'hidden',
                    'id' => "origin_distance_retour",
                    'empty' => ''
                )) . "</div>";

            echo "<div >" . $this->Form->input('arrival', array(
                    'label' => __('Arrival'),
                    'class' => 'form-control',
                    'id' => "destination_distance_retour",
                    'type' => 'hidden',
                    'empty' => ''
                )) . "</div>";
            echo "<div id='duration-retour-parc'>";
            echo "<div >" . $this->Form->input('duration_day', array(
                    'label' => __('Duration'),
                    'readonly' => true,
                    'id' => 'duration_day_retour',
                    'value' => $retourParc['detailRide']['DetailRide']['real_duration_day'],
                    'type' => 'hidden',
                    'class' => 'form-filter'
                )) . "</div>";
            echo "<div >" . $this->Form->input('duration_hour', array(
                    'label' => '',
                    'readonly' => true,
                    'id' => 'duration_hour_retour',
                    'value' => $retourParc['detailRide']['DetailRide']['real_duration_hour'],
                    'type' => 'hidden',
                    'class' => 'form-filter'
                )) . "</div>";
            echo "<div >" . $this->Form->input('duration_minute', array(
                    'label' => '',
                    'value' => $retourParc['detailRide']['DetailRide']['real_duration_minute'],
                    'readonly' => true,
                    'id' => 'duration_minute_retour',
                    'type' => 'hidden',
                    'class' => 'form-filter'
                )) . "</div>";

            echo "</div>";
            echo "<div id='distance-retour-parc'>";
            echo "<div >" . $this->Form->input('distance', array(
                    'label' => __('Distance'),
                    'readonly' => true,
                    'type' => 'hidden',
                    'value' => $retourParc['detailRide']['Ride']['distance'],
                    'id' => 'distance_retour',
                    'class' => 'form-filter'
                )) . "</div>";
            echo "</div>";

        } else {

            if (!empty($retourParc["wilayaLatlng"])) {
                $latlongdef = $retourParc["wilayaLatlng"];
                $latlongdef = substr($latlongdef, 1);
                $latlongdef = substr($latlongdef, 0, strlen($latlongdef) - 1);
                echo "<div >" . $this->Form->input('departure', array(
                        'label' => __('Departure'),
                        'value' => $latlongdef,
                        'class' => 'form-control',
                        'type' => 'hidden',
                        'id' => "origin_distance_retour",
                        'empty' => ''
                    )) . "</div>";
            } else {
                echo "<div >" . $this->Form->input('departure', array(
                        'label' => __('Departure'),
                        'value' => $retourParc["wilayaName"],
                        'class' => 'form-control',
                        'type' => 'hidden',
                        'id' => "origin_distance_retour",
                        'empty' => ''
                    )) . "</div>";
            }

            if (!empty($retourParc["departureDestinationLatlng"])) {
                $latlongdef = $retourParc["departureDestinationLatlng"];
                $latlongdef = substr($latlongdef, 1);
                $latlongdef = substr($latlongdef, 0, strlen($latlongdef) - 1);
                echo "<div  >" . $this->Form->input('arrival', array(
                        'label' => __('Arrival'),
                        'value' => $latlongdef,
                        'class' => 'form-control',
                        'id' => "destination_distance_retour",
                        'type' => 'hidden',
                        'empty' => ''
                    )) . "</div>";
            } else {
                echo "<div >" . $this->Form->input('arrival', array(
                        'label' => __('Arrival'),
                        'value' => $retourParc["departureDestinationName"],
                        'class' => 'form-control',
                        'id' => "destination_distance_retour",
                        'type' => 'hidden',
                        'empty' => ''
                    )) . "</div>";

            }
            echo "<div id='duration-retour-parc'>";

            echo "<div >" . $this->Form->input('duration_day', array(
                    'label' => __('Duration'),
                    'readonly' => true,
                    'id' => 'duration_day_retour',
                    'type' => 'hidden',

                    'class' => 'form-filter'
                )) . "</div>";
            echo "<div >" . $this->Form->input('duration_hour', array(
                    'label' => '',
                    'readonly' => true,
                    'id' => 'duration_hour_retour',
                    'type' => 'hidden',

                    'class' => 'form-filter'
                )) . "</div>";
            echo "<div >" . $this->Form->input('duration_minute', array(
                    'label' => '',
                    'type' => 'hidden',
                    'readonly' => true,
                    'id' => 'duration_minute_retour',
                    'class' => 'form-filter'
                )) . "</div>";

            echo "</div>";
            echo "<div id='distance-retour-parc'>";
            echo "<div >" . $this->Form->input('distance', array(
                    'label' => __('Distance'),
                    'readonly' => true,
                    'type' => 'hidden',
                    'id' => 'distance_retour',
                    'class' => 'form-filter'
                )) . "</div>";
            echo "</div>";

        }

    } else {

        if (!empty($wilaya["wilayaLatlng"])) {
            $latlongdef = $wilaya["wilayaLatlng"];
            $latlongdef = substr($latlongdef, 1);
            $latlongdef = substr($latlongdef, 0, strlen($latlongdef) - 1);
            echo "<div >" . $this->Form->input('departure', array(
                    'label' => __('Departure'),
                    'value' => $latlongdef,
                    'class' => 'form-control',
                    'type' => 'hidden',
                    'id' => "origin_distance_retour",
                    'empty' => ''
                )) . "</div>";

        } else {
            if(isset($wilaya)){
                echo "<div >" . $this->Form->input('departure', array(
                        'label' => __('Departure'),
                        'value' => $wilaya['wilayaName'],
                        'class' => 'form-control',
                        'type' => 'hidden',
                        'id' => "origin_distance_retour",
                        'empty' => ''
                    )) . "</div>";
            }else {
                echo "<div >" . $this->Form->input('departure', array(
                        'label' => __('Departure'),
                        'class' => 'form-control',
                        'type' => 'hidden',
                        'id' => "origin_distance_retour",
                        'empty' => ''
                    )) . "</div>";
            }

        }
        echo "<div id='duration-retour-parc'>";
        echo "<div >" . $this->Form->input('duration_day', array(
                'label' => __('Duration'),
                'readonly' => true,
                'id' => 'duration_day_retour',
                'type' => 'hidden',

                'class' => 'form-filter'
            )) . "</div>";
        echo "<div >" . $this->Form->input('duration_hour', array(
                'label' => '',
                'readonly' => true,
                'id' => 'duration_hour_retour',
                'type' => 'hidden',

                'class' => 'form-filter'
            )) . "</div>";
        echo "<div >" . $this->Form->input('duration_minute', array(
                'label' => '',
                'type' => 'hidden',
                'readonly' => true,
                'id' => 'duration_minute_retour',
                'class' => 'form-filter'
            )) . "</div>";
        echo "</div>";
        echo "<div id='distance-retour-parc'>";
        echo "<div >" . $this->Form->input('distance', array(
                'label' => __('Distance'),
                'readonly' => true,
                'type' => 'hidden',
                'id' => 'distance_retour',
                'class' => 'form-filter'
            )) . "</div>";
        echo "</div>";


    }
    if($isAgent) {
        echo "<div   class='hidden' >" . $this->Form->input('end_date', array(
                'label' => '',
                'type' => 'text',

                'class' => 'form-control datemask',
                'placeholder' => _('dd/mm/yyyy hh:mm'),
                'before' => '<label class="dte">' . __('Planned Arrival date ') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                             <i class="fa fa-calendar"></i>
                                            </div>',
                'after' => '</div>',
                'id' => 'end_date1',
            )) . "</div>";
    }else {
        if($this->request->params['action'] =='duplicate'){
            $date = date("Y-m-d", strtotime('+1 day'));
            $date = date($date . ' 02:00');

            echo "<div  class='datedep'>" . $this->Form->input('end_date', array(
                    'label' => '',
                    'type' => 'text',
                    'value' => $this->Time->format($date, '%d/%m/%Y %H:%M'),
                    'class' => 'form-control datemask',
                    'placeholder' => _('dd/mm/yyyy hh:mm'),
                    'before' => '<label class="dte">' . __('Planned Arrival date ') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'end_date1',
                )) . "</div>";
        }else {
            echo "<div  class='datedep'>" . $this->Form->input('end_date', array(
                    'label' => '',
                    'type' => 'text',

                    'class' => 'form-control datemask',
                    'placeholder' => _('dd/mm/yyyy hh:mm'),
                    'before' => '<label class="dte">' . __('Planned Arrival date ') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'end_date1',
                )) . "</div>";
        }

    }

    if($this->request->params['action'] =='duplicate'){
        echo "<div class='datedep'>" . $this->Form->input('real_end_date', array(
                'label' => '',
                'type' => 'text',
                'value' => $this->Time->format($date, '%d/%m/%Y %H:%M'),
                'class' => 'form-control datemask',
                'placeholder' => _('dd/mm/yyyy hh:mm'),
                'before' => '<label class="dte">' . __('Real Arrival date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                'after' => '</div>',
                'id' => 'end_date2',
            )) . "</div>";
    }else {
        echo "<div class='datedep'>" . $this->Form->input('real_end_date', array(
                'label' => '',
                'type' => 'text',

                'class' => 'form-control datemask',
                'placeholder' => _('dd/mm/yyyy hh:mm'),
                'before' => '<label class="dte">' . __('Real Arrival date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                'after' => '</div>',
                'id' => 'end_date2',
            )) . "</div>";
    }

    if($isAgent) {
        echo "<div  class='hidden'>" . $this->Form->input('km_arrival_estimated', array(
                'label' => __('Arrival Km estimated'),
                'placeholder' => __('Enter arrival Km'),
                'class' => 'form-filter',
                'readonly' => true,
                'id' => 'km_arr_estimated',
            )) . "</div>";
    }else {
        echo "<div  class='select-inline'>" . $this->Form->input('km_arrival_estimated', array(
                'label' => __('Arrival Km estimated'),
                'placeholder' => __('Enter arrival Km'),
                'class' => 'form-filter',
                'readonly' => true,
                'id' => 'km_arr_estimated',
            )) . "</div>";
    }
    echo "<div class='select-inline'>" . $this->Form->input('km_arrival', array(
            'label' => __('Arrival Km'),
            'placeholder' => __('Enter arrival Km'),
            'onchange' => 'javascript: calculateForecast(this), verifyKmEntred(this.id,"arrival");',
            'class' => 'form-filter',
            'id' => 'km_arr',
        )) . "</div>";
    echo "<div >" . $this->Form->input('arrivalTankStateMethod', array(
            'value' => $arrivalTankStateMethod,
            'class' => 'form-filter',
            'id' => 'arrivalTankStateMethod',
            'type' => 'hidden',

        )) . "</div>";

    switch ($arrivalTankStateMethod) {
        case 1 :
            echo "<div >" . $this->Form->input('tank_arrival', array(
                    'label' => __('Arrival tank'),
                    'type' => 'hidden',
                    'class' => 'form-filter',
                    'empty' => __('Select arrival tank'),
                    'onchange' => 'javascript:calculateForecast(this);'
                )) . "</div>";
            break;
        case 2 :
            echo "<div class='select-inline'>" . $this->Form->input('tank_arrival', array(
                    'label' => __('Arrival tank'),
                    'class' => 'form-filter',
                    'empty' => __('Select arrival tank'),
                    'onchange' => 'javascript:calculateForecast(this);'
                )) . "</div>";
            break;
        case 3 :

            echo "<div >" . $this->Form->input('tank_arrival', array(
                    'label' => __('Arrival tank'),
                    'type' => 'hidden',
                    'class' => 'form-filter',
                    'empty' => __('Select arrival tank'),
                    'onchange' => 'javascript:calculateForecast(this);'
                )) . "</div>";
            break;
    } ?>

</div>

