<?php
echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_type_id', array(
        'type' => 'hidden',
        'value' => $productTypeId,
        'id' => 'product_type' . $i,
    )) . "</div>";
switch ($productTypeId){
    case 1:
        if ($typeRide == 1) {

            echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                    'label' => '',
                    'class' => 'form-control select-search-detail-ride',
                    'empty' => '',
                    'onchange' => 'javascript:getPriceRide(this.id);',
                    'id' => 'detail_ride' . $i,
                )) . "</div>";

        }else {

            echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.departure_destination_id', array(
                    'empty' =>__('Departure city'),
                    'class' => 'form-control select-search-destination',
                    'label'=>'',
                    'onchange' => 'javascript:getPriceRide(this.id);',
                    'id'=>'departure_destination'.$i,
                ))."</div>";

            echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.car_type_id', array(
                    'empty' =>__('Type'),
                    'class' => 'form-control select-search',
                    'label'=>'',
                    'onchange' => 'javascript:getPriceRide(this.id);',
                    'id'=>'car_type'.$i,
                ))."</div>";

        }
        break;

    case 2 :



        echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.car_type_id', array(
                'empty' =>__('Type'),
                'class' => 'form-control select-search',
                'label'=>'',
                'onchange' => 'javascript:getPriceRide(this.id);',
                'id'=>'car_type'.$i,
            ))."</div>";
        echo $this->Form->input('TransportBillDetailRides.'.$i.'.car_required', array(
            'type'=>'hidden',
            'value'=>$carRequired,
            'id'=>'car_required'.$i,
        ));
        if($carRequired==1){
            echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.car_id', array(
                    'empty' =>__('Car'),
                    'class' => 'form-control select-search-car',
                    'required'=>true,
                    'label'=>'',
                    'id'=>'car'.$i,
                ))."</div>";
        }



        $j =0 ;
        if(!empty($factors)){

            foreach ($factors as $factor){
                $j ++;
                echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $j . '.factor_id', array(
                        'value' => $factor['Factor']['id'],
                        'class' => 'form-control',
                        'type'=>'hidden'
                    )) . "</div>";
                echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $j. '.factor_value', array(
                        'label' => $factor['Factor']['name'],
                        'class' => 'form-control',
                        'id'=>'factor'.$i.$j,
                        'onchange' => 'javascript: calculatePriceRide(this.id);',
                        'type'=>'integer'
                    )) . "</div>";

            }
        }





        break;
    case 3:
        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.start_date', array(
                'label' => false,
                'placeholder' => 'dd/mm/yyyy hh:mm',
                'type' => 'text',
                'class' => 'form-control datemask',
                'before' => '<label>' . __('Start date') . '</label><div class="input-group datetime">
                    <label for="StartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                'after' => '</div>',
                'onchange' => 'javascript:calculateEndDate(this.id);',
                'id' => 'start_date'.$i,
                'allowEmpty' => true,
            )) . "</div>";


        echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.car_type_id', array(
                'empty' =>__('Type'),
                'class' => 'form-control select-search',
                'label'=>'',
                'onchange' => 'javascript:getPriceRide(this.id);',
                'id'=>'car_type'.$i,
            ))."</div>";
        echo $this->Form->input('TransportBillDetailRides.'.$i.'.car_required', array(
                'type'=>'hidden',
                'value'=>$carRequired,
                'id'=>'car_required'.$i,
            ));
        if($carRequired==1){
            echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.car_id', array(
                    'empty' =>__('Car'),
                    'class' => 'form-control select-search-car',
                    'required'=>true,
                    'label'=>'',
                    'id'=>'car'.$i,
                ))."</div>";
        }
        echo $this->Form->input('TransportBillDetailRides.'.$i.'.nb_hours_required', array(
            'type'=>'hidden',
            'value'=>$nbHoursRequired,
            'id'=>'nb_hours_required'.$i,
        ));

        if($nbHoursRequired ==1){
            echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.nb_hours', array(
                    'placeholder' =>__('Nb hours'),
                    'class' => 'form-control',
                    'label'=>'',
                    'value'=>$nbHours,
                    'readonly'=>true,
                    'id'=>'nb_hours'.$i,
                ))."</div>";
        }else {
            echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.nb_hours', array(
                    'placeholder' =>__('Nb hours'),
                    'class' => 'form-control',
                    'label'=>'',
                    'id'=>'nb_hours'.$i,
                    'onchange' => 'javascript:calculateEndDate(this.id);',
                ))."</div>";
        }

        $j =0 ;
        if(!empty($factors)){

            foreach ($factors as $factor){
                $j ++;
                echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $j . '.factor_id', array(
                        'value' => $factor['Factor']['id'],
                        'class' => 'form-control',
                        'type'=>'hidden'
                    )) . "</div>";
                echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $j. '.factor_value', array(
                        'label' => $factor['Factor']['name'],
                        'class' => 'form-control',
                        'id'=>'factor'.$i.$j,
                        'onchange' => 'javascript: calculatePriceRide(this.id);',
                        'type'=>'integer'
                    )) . "</div>";

            }
        }

        break;
    default:
        $j =0 ;
        if(!empty($factors)){

            foreach ($factors as $factor){
                $j ++;
                echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $j . '.factor_id', array(
                        'value' => $factor['Factor']['id'],
                        'class' => 'form-control',
                        'type'=>'hidden'
                    )) . "</div>";
                echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $j. '.factor_value', array(
                        'label' => $factor['Factor']['name'],
                        'class' => 'form-control',
                        'id'=>'factor'.$i.$j,
                        'onchange' => 'javascript: calculatePriceRide(this.id);',
                        'type'=>'integer'
                    )) . "</div>";

            }
        }
        if(!empty($selectFactors)){

            foreach ($selectFactors as $factor){
                $j ++;
                echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $j . '.factor_id', array(
                        'value' => $factor['Factor']['id'],
                        'class' => 'form-control',
                        'type'=>'hidden'
                    )) . "</div>";
                echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $j. '.factor_value', array(
                        'label' => $factor['Factor']['name'],
                        'class' => 'form-control select3',
                        'type'=>'select',
                        'empty'=>'',
                        'options'=>$factor['Factor']['options'],
                        'id'=>'factor'.$i.$j,
                        'onchange' => 'javascript: calculatePriceRide(this.id);',
                    )) . "</div>";

            }
        }


        echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_factor', array(
                'type' => 'hidden',
                'value' => $j,
                'id' => 'nb_factor' . $i,
            )) . "</div>";
        if($productWithLot == 1){ ?>
            <div class="form-group">
                <div class="input select required">
                    <label for="lot<?= $i ?>"></label>
                    <select name="data[TransportBillDetailRides][<?= $i ?>][lot_id]" class="form-control select3" id="lot<?= $i ?>"  required="required">
                        <option value=""></option>

                        <?php

                        foreach ($lots as $lot) {

                            echo '<option value="'.$lot['Lot']['id'].'">'.$lot['Lot']['label'].'</option>'."\n";

                        }
                        ?>
                    </select>
                </div>
            </div>

        <?php }
        break;
}
if($productTypeId == 1) {

} else {


} ?>