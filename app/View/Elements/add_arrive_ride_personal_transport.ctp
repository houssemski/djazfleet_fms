<td>arrivee<?php echo $i ?></td>
<td>
    <div class="filters" id='filters'>
        <?php

        echo "<div class='datedep'>".$this->Form->input('SheetRideDetailRides.'.$i.'.planned_end_date', array(
                'label' => '',
                'type' => 'text',

                'class' => 'form-control datemask',
                'placeholder'=>_('dd/mm/yyyy hh:mm'),
                'before' => '<label class="dte">' . __('Planned Arrival date ') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                'after' => '</div>',
                'id' => 'planned_end_date'.$i,
            ))."</div>";

        echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.tempRestant', array(
                'label' => '',
                'class' => 'form-control',
                'id' => 'tempRestant' . $i,
                'type'=>'hidden'
            )) . "</div>";

        echo "<div class='datedep'>".$this->Form->input('SheetRideDetailRides.'.$i.'.real_end_date', array(
                'label' => '',
                'type' => 'text',

                'class' => 'form-control datemask',
                'placeholder'=>_('dd/mm/yyyy hh:mm'),
                'before' => '<label class="dte">' . __('Real Arrival date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                'after' => '</div>',
                'id' => 'real_end_date'.$i,
                'onchange'=>'javascript: calculateDateArrivalParc(this.id);',
            ))."</div>";

        echo "<div class='select-inline'>".$this->Form->input('SheetRideDetailRides.'.$i.'.km_arrival_estimated', array(
                'label' => __('Arrival Km estimated'),
                'readonly'=>true,
                'id'=>'km_arrival_estimated'.$i,
                'class' => 'form-filter'
            ))."</div>";

        echo "<div class='select-inline'>".$this->Form->input('SheetRideDetailRides.'.$i.'.km_arrival', array(
                'label' => __('Arrival Km'),
                'onchange'=>'javascript: calculateKmArrivalParc(this.id), verifyKmEntred(this.id,"arrival");',
                'id'=>'km_arrival'.$i,
                'class' => 'form-filter'
            ))."</div>";
        echo "<div style='clear:both; padding-top: 10px;'></div>";?>






    </div>
</td>