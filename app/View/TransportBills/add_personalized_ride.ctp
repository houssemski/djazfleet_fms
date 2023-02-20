<?php if($reference=='0')  { ?>
    <td> <?php
        echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.reference', array(
                'label' => '',
                'class' => 'form-control ',
                'id'=>'reference'.$i,
            ))."</div>";

        ?></td>

<?php } ?>

<?php if($type==TransportBillTypesEnum::pre_invoice || $type==TransportBillTypesEnum::invoice){?>
    <td>
        <?php

        echo "<div>" . $this->Form->input('TransportBillDetailRides.'.$i.'.reference_mission', array(
                'label' => '',
                'id'=>'reference_mission'.$i,
                'class' => 'form-control',
            )) . "</div>";
        ?>

    </td>
<?php } ?>
<?php if($profileId == ProfilesEnum::client
    && $type == TransportBillTypesEnum::order){ ?>
    <td class="col-sm-3"><?php
        echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.departure_destination_id', array(
                'label' =>__('Departure city'),
                'class' => 'form-control select-search-destination',
                'empty'=>'',
                'onchange' => 'javascript:getPriceRide(this.id);',
                'id'=>'departure_destination'.$i,
            ))."</div>";



        echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.car_type_id', array(
                'label' =>__('Type'),
                'class' => 'form-control select-search',
                'empty'=>'',
                'onchange' => 'javascript:getPriceRide(this.id);',
                'id'=>'car_type'.$i,
            ))."</div>";

        ?></td>

<?php } else {?>
    <td class="col-sm-2"><?php
        echo "<div class='form-group form-tab'>".$this->Form->input('TransportBillDetailRides.'.$i.'.departure_destination_id', array(
                'label' =>__('Departure city'),
                'class' => 'form-control select-search-destination',
                'empty'=>'',
                'onchange' => 'javascript:getPriceRide(this.id);',
                'id'=>'departure_destination'.$i,
            ))."</div>";



        echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.car_type_id', array(
                'label' =>__('Type'),
                'class' => 'form-control select-search',
                'empty'=>'',
                'onchange' => 'javascript:getPriceRide(this.id);',
                'id'=>'car_type'.$i,
            ))."</div>";

        ?></td>
<?php } ?>
<?php if ($type == TransportBillTypesEnum::pre_invoice ||
    $type == TransportBillTypesEnum::invoice
) { ?>
    <td>
        <?php
        echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.designation', array(
                'label' => '',
                'empty' => '',
                'id' => 'designation' . $i,
                'class' => 'form-control',
            )) . "</div>";
        ?>
    </td>
<?php } ?>
<?php if($profileId == ProfilesEnum::client
    && $type == TransportBillTypesEnum::order){ ?>
    <td class="col-sm-3">
        <?php

        echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.arrival_destination_id', array(
                'label' =>__('Arrival city'),
                'class' => 'form-control select-search-destination',
                'empty'=>'',
                'onchange' => 'javascript:getPriceRide(this.id);',
                'id'=>'arrival_destination'.$i,
            ))."</div>";
        echo "<div class='form-group' id='supplier_final_div$i'>".$this->Form->input('TransportBillDetailRides.'.$i.'.supplier_final_id', array(
                'label' =>__('Final customer'),
                'empty' =>'',
                'id'=>'client_final'.$i,
                'class' => 'form-control select-search-client-final',
            ))."</div>";
        ?>
    </td>

<?php } else {?>
    <td class="col-sm-2">
        <?php
        echo "<div class='form-group form-tab'>".$this->Form->input('TransportBillDetailRides.'.$i.'.arrival_destination_id', array(
                'label' =>__('Arrival city'),
                'class' => 'form-control select-search-destination',
                'empty'=>'',
                'onchange' => 'javascript:getPriceRide(this.id);',
                'id'=>'arrival_destination'.$i,
            ))."</div>";
        echo "<div class='form-group form-tab' id='supplier_final_div$i'>".$this->Form->input('TransportBillDetailRides.'.$i.'.supplier_final_id', array(
                'label' =>__('Final customer'),
                'empty' =>'',
                'id'=>'client_final'.$i,
                'class' => 'form-control select-search-client-final',
            ))."</div>";


        ?>
    </td>
<?php } ?>

<?php if($useRideCategory == 2) {?>
    <td><?php
        echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.ride_category_id', array(
                'label' =>'',
                'class' => 'form-control select-search',
                'empty'=>'',
                'onchange' => 'javascript:getPriceRide(this.id);',
                'id'=>'ride_category'.$i,
            ))."</div>";

        ?></td>
<?php } ?>
<td>
    <?php
    $options = array('1' => __('Simple delivery'), '2' => __('Simple return'), '3' => __('Delivery / Return'));
    echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.'.$i.'.delivery_with_return', array(
            'label' => '',
            'id' => 'delivery_with_return'.$i,
            'onchange' => 'javascript:getPriceRide(this.id);',
            'value' => 2,
            'options'=> $options,
            'class' => 'form-control select-search',
        )) . "</div>"; ?>
</td>
<?php if($profileId == ProfilesEnum::client
    && $type == TransportBillTypesEnum::order){ ?>

    <?php  if($paramPriceNight == 1) { ?>
        <td>
            <?php  $options=array('1'=>__('Day'),'2'=>__('Night'));
            echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.'.$i.'.type_price', array(
                    'label' => '',
                    'id' => 'type_price'.$i,
                    'onchange' => 'javascript:getPriceRide(this.id);',
                    'value' => 1,
                    'options'=> $options,
                    'class' => 'form-control select-search',
                )) . "</div>"; ?>
        </td>
    <?php } ?>

    <td>
        <?php

        if($nbTrucksModifiable==2){
            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.nb_trucks', array(
                    'label' => '',
                    'placeholder' => __('Enter quantity'),
                    'onchange' => 'javascript: calculatePriceRide(this.id);',
                    'id' => 'nb_trucks'.$i,
                    'readonly'=>true,
                    'value'=>$defaultNbTrucks,
                    'class' => 'form-control',
                )) . "</div>";
        }else {
            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.nb_trucks', array(
                    'label' => '',
                    'placeholder' => __('Enter quantity'),
                    'onchange' => 'javascript: calculatePriceRide(this.id);',
                    'id' => 'nb_trucks'.$i,
                    'class' => 'form-control',
                )) . "</div>";
        }


        echo "<div id='div_unit_price$i' style='width: 150px;'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.unit_price', array(
                'label' => '',
                'id' => 'unit_price'.$i,
                'type' => 'hidden',
                'onchange' => 'javascript:calculatePriceRide(this.id);',
                'class' => 'form-control',
            )) . "</div>";


        echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.ristourne_%', array(
                'label' => '',
                'id' => 'ristourne'.$i,
                'type' => 'hidden',
                'onchange' => 'javascript:calculatePriceRide(this.id);',
                'class' => 'form-control',
            )) . "</div>";


        echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.ristourne_val', array(
                'label' => '',
                'type'=>'hidden',
                'id' => 'ristourne_val'.$i,
                'onchange' => 'javascript:calculRistourne(this.id);',
                'class' => 'form-control',
            )) . "</div>";


        echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.price_ht', array(
                'label' => '',
                'id' => 'price_ht'.$i,
                'readonly'=>true,
                'type' => 'hidden',
                'class' => 'form-control',
            )) . "</div>";



        echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.'.$i.'.tva_id', array(
                'label' => '',
                'options' => $tvas,
                'id' => 'tva'.$i,
                'value' => 1,
                'type' => 'hidden',
                'onchange' => 'javascript:calculatePriceRide(this.id);',
                'class' => 'form-control ',
            )) . "</div>";


        echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.'.$i.'.price_ttc', array(
                'label' => '',
                'readonly' => true,
                'type' => 'hidden',
                'id' => 'price_ttc'.$i,
                'class' => 'form-control',
            )) . "</div>";

        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.type', array(
                'id' => 'type'.$i,
                'type' => 'hidden',
                'value' => $type,
            )) . "</div>";

        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                'id' => 'type_ride'.$i,
                'type' => 'hidden',
                'value' => $typeRide,
            )) . "</div>";


        switch ($type) {
            case TransportBillTypesEnum::quote :
                $statusId = 0;
                break;
            case TransportBillTypesEnum::order :
                $statusId = 1;
                break;

            case TransportBillTypesEnum::pre_invoice :
                $statusId = 4;
                break;

            case TransportBillTypesEnum::invoice :
                $statusId = 7;
                break;
        }
        echo "<div class='hidden'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.status_id', array(
                'id' => 'status'.$i,
                'type' => 'number',
                'value' => $statusId,
            )) . "</div>";

        ?>

    </td>

    <td style="width: 20px;">
        <button  name="remove" id="<?php echo $i ?>" onclick="removeRide('<?php echo $i ?>');" class="btn btn-danger btn_remove" style="margin-top: 10px;">X</button>
    </td>
<?php } else {?>
    <?php  if($paramPriceNight == 1) { ?>
        <td>
            <?php  $options=array('1'=>__('Day'),'2'=>__('Night'));
            echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.'.$i.'.type_price', array(
                    'label' => '',

                    'id' => 'type_price'.$i,
                    'onchange' => 'javascript:getPriceRide(this.id);',
                    'value' => 1,
                    'options'=> $options,
                    'class' => 'form-control select-search',
                )) . "</div>"; ?>
        </td>
    <?php } ?>

    <td>
        <?php


        echo "<div id='div_unit_price$i' style='width: 150px;'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.unit_price', array(
                'label' => '',
                'id' => 'unit_price'.$i,
                'onchange' => 'javascript:calculatePriceRide(this.id);',
                'class' => 'form-control',
            )) . "</div>"; ?>
    </td>
    <td>
        <?php


        echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.ristourne_%', array(
                'label' => '',
                'id' => 'ristourne'.$i,
                'onchange' => 'javascript:calculatePriceRide(this.id);',
                'class' => 'form-control',
            )) . "</div>";


        echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.ristourne_val', array(
                'label' => '',
                //'type'=>'hidden',
                'id' => 'ristourne_val'.$i,
                'onchange' => 'javascript:calculRistourne(this.id);',
                'class' => 'form-control',
            )) . "</div>"; ?>
    </td>


    <td><?php
        if($nbTrucksModifiable==2){
            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.nb_trucks', array(
                    'label' => '',
                    'placeholder' => __('Enter quantity'),
                    'onchange' => 'javascript: calculatePriceRide(this.id);',
                    'id' => 'nb_trucks'.$i,
                    'readonly'=>true,
                    'value'=>$defaultNbTrucks,
                    'class' => 'form-control',
                )) . "</div>";
        }else {
            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.nb_trucks', array(
                    'label' => '',
                    'placeholder' => __('Enter quantity'),
                    'onchange' => 'javascript: calculatePriceRide(this.id);',
                    'id' => 'nb_trucks'.$i,
                    'class' => 'form-control',
                )) . "</div>";
        }

        ?></td>


    <td>
        <?php



        echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.price_ht', array(
                'label' => '',
                'id' => 'price_ht'.$i,
                'readonly'=>true,
                'class' => 'form-control',
            )) . "</div>"; ?>
    </td>
    <td>
        <?php


        echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.'.$i.'.tva_id', array(
                'label' => '',
                'options' => $tvas,
                'id' => 'tva'.$i,
                'onchange' => 'javascript:calculatePriceRide(this.id);',
                'class' => 'form-control ',
            )) . "</div>"; ?>
    </td>
    <td>
        <?php


        echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.'.$i.'.price_ttc', array(
                'label' => '',
                'readonly' => true,
                'id' => 'price_ttc'.$i,
                'class' => 'form-control',
            )) . "</div>";

        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.type', array(
                'id' => 'type'.$i,
                'type' => 'hidden',
                'value' => $type,
            )) . "</div>";

        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                'id' => 'type_ride'.$i,
                'type' => 'hidden',
                'value' => $typeRide,
            )) . "</div>";

        switch ($type) {
            case TransportBillTypesEnum::quote :
                $statusId = 0;
                break;
            case TransportBillTypesEnum::order :
                $statusId = 1;
                break;

            case TransportBillTypesEnum::pre_invoice :
                $statusId = 4;
                break;

            case TransportBillTypesEnum::invoice :
                $statusId = 7;
                break;
        }
        echo "<div class='hidden'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.status_id', array(
                'id' => 'status'.$i,
                'type' => 'number',
                'value' => $statusId,
            )) . "</div>";

        ?>

    </td>
    <td>
        <?php switch ($statusId) {

            /*
            1: commandes en cours
            2: commandes partiellement validées
            3: commandes validées
            4: commandes préfacturées.
            7: commandes facturées.
            */
            case 0:
                echo '<span class="label label-info position-status">';
                echo __('Quotation') . "</span>";
                break;
            case 1:
                echo '<span class="label label-danger position-status">';
                echo __('Not validated') . "</span>";
                break;
            case 2:
                echo '<span class="label label-warning position-status">';
                echo __('Partially validated') . "</span>";
                break;
            case 3:
                echo '<span class="label label-success position-status">';
                echo __('Validated') . "</span>";
                break;
            case 4:
                echo '<span class="label label-primary position-status">';
                echo __('Preinvoiced') . "</span>";
                break;
            case 7:
                echo '<span class="label btn-inverse position-status">';
                echo __('Invoiced') . "</span>";
                break;

        } ?>&nbsp;
        <br>
        <button  name="remove" id="<?php echo $i ?>" onclick="removeRide('<?php echo $i ?>');" class="btn btn-danger btn_remove" style="margin-top: 10px;">X</button>
    </td>
    <?php if ($type == TransportBillTypesEnum::pre_invoice) { ?>
        <td>
            <?php
            echo "<div class='appro'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.approved', array(
                    'type' => 'checkbox',
                    'label' => false,
                    'class' => 'id approve'
                )) . "</div>";
            ?>

        </td>

    <?php } ?>




<?php } ?>





