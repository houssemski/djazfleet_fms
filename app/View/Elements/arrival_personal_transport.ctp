
<div class="filters" id='filters' style="min-height: 100px;">
    <div id='distance-retour-parc'>

    </div>
    <div id='duration-retour-parc'>

    </div>
    <?php
    echo "<div class='datedep'>" . $this->Form->input('end_date', array(
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

    echo "<div class='datedep'>" . $this->Form->input('real_end_date', array(
            'label' => '',
            'type' => 'text',
            // 'onchange'=>'javascript: verifyStatusCar(this.id);',
            'class' => 'form-control datemask',
            'placeholder' => _('dd/mm/yyyy hh:mm'),
            'before' => '<label class="dte">' . __('Real Arrival date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
            'after' => '</div>',
            'id' => 'end_date2',
        )) . "</div>";

    echo "<div class='select-inline'>" . $this->Form->input('km_arrival_estimated', array(
            'label' => __('Arrival Km estimated'),

            'class' => 'form-filter',
            'readonly' => true,
            'id' => 'km_arr_estimated',

        )) . "</div>";


    echo "<div class='select-inline'>" . $this->Form->input('km_arrival', array(
            'label' => __('Arrival Km'),
            'class' => 'form-filter',
            'id' => 'km_arr',
            'onchange' => 'javascript: calculateForecast(this), verifyKmEntred(this.id, "arrival");',
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

            echo "<div>" . $this->Form->input('tank_arrival', array(
                    'label' => __('Arrival tank'),
                    'type' => 'hidden',
                    'class' => 'form-filter',
                    'empty' => __('Select arrival tank'),
                    'onchange' => 'javascript:calculateForecast(this);'
                )) . "</div>";
            break;
    }
    ?>
</div>

