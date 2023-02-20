<td>arrivee<?php echo $i ?></td>
<td>
    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: #435966;;">
                <h4 class="panel-title">
                    <a class="collapsed" data-toggle="collapse" href="#collapseArrive<?php echo $i;?>"
                       style="font-weight: 700;"><?php echo __('Arrivée') ?> </a>

                </h4>
            </div>
            <div id="collapseArrive<?php echo $i;?>" class="panel-collapse collapse">
                <div class="panel-body">
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

        <div class="scroll-block100">
            <?php
            echo "<div class='lbl2'> <a href='#piece$i' data-toggle='collapse' id='pieceClient$i' onclick='getAttachmentsByClient(this.id)'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Attachments") . "</a></div>";
            echo  "<div id='piece$i' class='collapse'>";

            echo "<div id = 'piece-div$i'>";
            echo "</div>" ?>
        </div>




    </div>

                </div>
            </div>
        </div>


    </div>
</td>