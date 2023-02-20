<td>arrivee<?php echo $i ?></td>
<td>
    <div class="filters" id='filters'>
        <?php
        if (Configure::read("gestion_commercial") == '1') {
            echo "<div class='select-inline' id='client-final-div$i'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_final_id', array(
                    'label' => __('Final customer'),
                    'empty' => __('Select client'),
                    'id' => 'client_final',
                    //'options'=>$suppliers,
                    'class' => 'form-filter select-search-client-final-i'
                )) . "</div>";
        }
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
        </br>
        </br>
        <div class="scroll-block100">
            <?php echo "<div class='lbl2'> <a id='marchandiseClient$i' href='#march$i' data-toggle='collapse'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Marchandises") . "</a></div>";
            echo  "<div id='march$i' class='collapse'>";
            $nbMarchandise =1;
            echo "<div class='select-inline'>" . $this->Form->input('nb_marchandise', array(
                    'label' => __(''),
                    'type' => 'hidden',
                    'class' => 'form-filter',
                    'id' => 'nb_marchandise'.$i,
                    'value'=>$nbMarchandise
                )) . "</div>";
            echo "<div id='marchandise-div$i' class='marchandise-input'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.marchandise_id', array(
                    'label' => __(''),
                    'empty' => __('Select marchandise'),
                    'id' => 'marchandise'.$i,
                    //'options' => $marchandises,
                    'multiple'=>true,
                    'class' => 'form-filter select2'
                )) . "</div>";
            echo "</div>";
            echo "</div>";
            ?>

        </div>
        </br>
        </br>
        <?php if($usePurchaseBill == 1){ ?>
            <div class="scroll-block100" style="margin-top: 5px;">
                <?php echo "<div class='lbl2'> <a href='#lot$i' id ='lotClient$i' onclick='getLots(this.id)'  data-toggle='collapse'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Products") . "</a></div>";

                echo "<div id='lot$i' class='collapse'>";
                echo "<div id = 'lot-div$i'>";
                echo "</div>";

                ?>
            </div>
        <?php } ?>
    </div>
</td>