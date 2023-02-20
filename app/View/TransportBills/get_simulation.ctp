<table class="table table-bordered" id='dynamic_field'>
    <?php echo "<div class='form-group'>" . $this->Form->input('nb_ride', array(
            'value' => $nbTrucks,
            'type' => 'hidden',
            'id' => 'nb_ride',
        )) . "</div>";
    ?>
    <thead>
    <tr>
        <?php if ($reference == '0') { ?>
            <th><?= __('Reference') ?></th>
        <?php } ?>

        <?php if ($type == TransportBillTypesEnum::pre_invoice ||
            $type == TransportBillTypesEnum::invoice
        ) { ?>
            <th><?= __('Reference Mission') ?></th>
        <?php } ?>
        <th><?= __('Product') ?></th>
        <th><?= __('Rides') ?></th>
        <th><?= __('Final customer') ?></th>
        <?php if ($useRideCategory == TransportBillTypesEnum::order) { ?>
            <th><?= __('Ride category') ?></th>
        <?php } ?>
        <th><?= __('Simple delivery / return') ?></th>
        <?php if ($profileId == ProfilesEnum::client && $type == TransportBillTypesEnum::order) { ?>

            <th><?= __('Number of trucks') ?></th>
            <th><?= __('Observation') ?></th>

        <?php } else { ?>
            <?php if ($paramPriceNight == 1) { ?>
                <th><?= __('Price') ?></th>
            <?php } ?>
            <th><?= __('Unit price') ?></th>
            <th><?= __('Ristourne') . __('%') ?></th>
            <th><?= __('Number of trucks') ?></th>
            <th><?= __('Price HT') ?></th>
            <th><?= __('TVA') ?></th>
            <th><?= __('Price TTC') ?></th>
            <th><?= __('Observation') ?></th>
        <?php } ?>

    </tr>
    </thead>
    <tbody id='rides-tbody'>

    <?php
    for($i = 1; $i <= $nbTrucks; $i++) { ?>

        <tr id="row<?php echo $i; ?>">
            <?php if ($reference == '0') { ?>
                <td> <?php
                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.reference', array(
                            'label' => '',
                            'class' => 'form-control ',
                            'id' => 'reference'.$i,
                        )) . "</div>";

                    ?></td>
            <?php } ?>
            <?php if ($type == TransportBillTypesEnum::pre_invoice ||
                $type == TransportBillTypesEnum::invoice
            ) {
                ?>
                <td>
                    <?php

                    echo "<div>" . $this->Form->input('TransportBillDetailRides.'.$i.'.reference_mission', array(
                            'label' => '',
                            'id' => 'reference_mission'.$i,
                            'class' => 'form-control',
                        )) . "</div>";
                    ?>

                </td>
            <?php } ?>
            <td style="min-width: 200px;"><?php
                echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.product_id', array(
                        'label' => '',
                        'class' => 'form-control select-search',
                        'onchange' => 'javascript:getInformationProduct(this.id);',
                        'id' => 'product'.$i,
                        'value'=>1
                    )) . "</div>";
                echo "<div id='type-ride-div$i'>";
                if($typeRideUsed ==3){
                    $options = array('1'=>__('Existing ride'),'2'=>__('Personalized ride') );
                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.type_ride', array(
                            'id' => 'type_ride'.$i,
                            'options'=>$options,
                            'label'=>false,
                            'class'=>'form-control select-search',
                            'onchange' => 'javascript:getInformationProduct(this.id);',
                            'value' => $typeRide,
                        )) . "</div>";

                }else {
                    echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.type_ride', array(
                            'id' => 'type_ride'.$i,
                            'type' => 'hidden',
                            'value' => $typeRide,
                        )) . "</div>";
                }
                echo "</div >";

                echo "<div id='type-pricing-div$i'>";
                if($typePricing ==3){
                    $options = array('1'=>__('Pricing by ride'),'2'=>__('Pricing by distance') );
                    echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_pricing', array(
                            'id' => 'type_pricing'.$i,
                            'options'=>$options,
                            'label'=>false,
                            'class'=>'form-control select-search',
                            'onchange' => 'javascript:getInformationPricing(this.id);',
                            'value' => 1,
                        )) . "</div>";

                }else {
                    echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_pricing', array(
                            'id' => 'type_pricing'.$i,
                            'type' => 'hidden',
                            'value' => $typePricing,
                        )) . "</div>";
                }
                echo "</div>";
                ?>
            </td>
            <?php if ($profileId == ProfilesEnum::client
                && $type == TransportBillTypesEnum::order
            ) {

                if ($typeRide == 1) {
                    ?>
                    <td class="col-sm-3">

                        <?php
                        echo "<div id='div-product$i'>";
                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.detail_ride_id', array(
                                'label' => '',
                                'class' => 'form-control select-search-detail-ride',
                                'empty' => '',
                                'value'=>$detailRideId,
                                'options'=>$detailRides,
                                'onchange' => 'javascript:getPriceRide(this.id);',
                                'id' => 'detail_ride'.$i,
                            )) . "</div>";
                        echo "</div >";
                        ?></td>

                <?php } else { ?>

                    <td style="min-width: 200px;"><?php
                        echo "<div id='div-product$i'>";
                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.departure_destination_id', array(
                                'label' => '',
                                'empty' => __('Departure city'),
                                'class' => 'form-control select-search-destination',
                                'value'=>$departureId,
                                'options'=>$departures,
                                'onchange' => 'javascript:getPriceRide(this.id);',
                                'id' => 'departure_destination'.$i,
                            )) . "</div>";


                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.car_type_id', array(
                                'label' => '',
                                'empty' => __('Type'),
                                'class' => 'form-control select-search',
                                'value'=>$carTypeId,
                                'onchange' => 'javascript:getPriceRide(this.id);',
                                'id' => 'car_type'.$i,
                            )) . "</div>";
                        echo "</div >";
                        ?></td>


                <?php } ?>

            <?php
            } else {

                if ($typeRide == 1) {
                    ?>
                    <td style="min-width: 200px;"><?php
                        echo "<div id='div-product$i'>";
                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.detail_ride_id', array(
                                'label' => '',
                                'class' => 'form-control select-search-detail-ride',
                                'empty' => '',
                                'value'=>$detailRideId,
                                'options'=>$detailRides,
                                'onchange' => 'javascript:getPriceRide(this.id);',
                                'id' => 'detail_ride'.$i,
                            )) . "</div>";
                        echo "</div>";
                        ?></td>

                <?php } else { ?>

                    <td style="min-width: 200px;"><?php
                        echo "<div id='div-product$i'>";
                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.departure_destination_id', array(
                                'label' => '',
                                'empty' => __('Departure city'),
                                'class' => 'form-control select-search-destination',
                                'value'=>$departureId,
                                'options'=>$departures,
                                'onchange' => 'javascript:getPriceRide(this.id);',
                                'id' => 'departure_destination'.$i,
                            )) . "</div>";


                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.car_type_id', array(
                                'label' => '',
                                'empty' => __('Type'),
                                'class' => 'form-control select-search',
                                'value'=>$carTypeId,
                                'onchange' => 'javascript:getPriceRide(this.id);',
                                'id' => 'car_type'.$i,
                            )) . "</div>";
                        echo "</div>";
                        ?></td>


                <?php } ?>


            <?php } ?>
            <?php if ($profileId == ProfilesEnum::client
                && $type == TransportBillTypesEnum::order
            ) {
                if ($typeRide == 1) {
                    ?>
                    <td class="col-sm-3">
                        <?php
                        echo "<div class='form-group' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.supplier_final_id', array(
                                'label' => '',
                                'empty' => '',
                                'id' => 'client_final'.$i,
                                'value'=>$clientFinalId,
                                'options'=>$finalSuppliers,
                                'class' => 'form-control select-search-client-final',
                            )) . "</div>";
                        ?>
                    </td>
                <?php } else { ?>

                    <td class="col-sm-3">
                        <?php

                        echo "<div class='form-group' id='div-arrival$i'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.arrival_destination_id', array(
                                'label' => '',
                                'empty' => __('Arrival city'),
                                'class' => 'form-control select-search-destination',
                                'value'=>$arrivalId,
                                'options'=>$arrivals,
                                'onchange' => 'javascript:getPriceRide(this.id);',
                                'id' => 'arrival_destination'.$i,
                            )) . "</div>";
                        echo "<div class='form-group' id='supplier_final_div1'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.supplier_final_id', array(
                                'label' => '',
                                'empty' => __('Final customer'),
                                'id' => 'client_final'.$i,
                                'value'=>$clientFinalId,
                                'options'=>$finalSuppliers,
                                'class' => 'form-control select-search-client-final',
                            )) . "</div>";
                        ?>
                    </td>

                <?php } ?>

            <?php
            } else {

                if ($typeRide == 1) {
                    ?>
                    <td style="min-width: 200px;">
                        <?php
                        echo "<div class='form-group' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.supplier_final_id', array(
                                'label' => '',
                                'empty' => '',
                                'id' => 'client_final'.$i,
                                'value'=>$clientFinalId,
                                'options'=>$finalSuppliers,
                                'class' => 'form-control select-search-client-final',
                            )) . "</div>";
                        ?>
                    </td>

                <?php } else { ?>
                    <td style="min-width: 200px;">
                        <?php

                        echo "<div class='form-group' id='div-arrival$i'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.arrival_destination_id', array(
                                'label' => '',
                                'empty' => __('Arrival city'),
                                'class' => 'form-control select-search-destination',
                                'value'=>$arrivalId,
                                'options'=>$arrivals,
                                'onchange' => 'javascript:getPriceRide(this.id);',
                                'id' => 'arrival_destination'.$i,
                            )) . "</div>";
                        echo "<div class='form-group' id='supplier_final_div1'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.supplier_final_id', array(
                                'label' => '',
                                'empty' => __('Final customer'),
                                'id' => 'client_final'.$i,
                                'value'=>$clientFinalId,
                                'options'=>$finalSuppliers,
                                'class' => 'form-control select-search-client-final',
                            )) . "</div>";
                        ?>
                    </td>

                <?php } ?>


            <?php } ?>
            <?php if ($useRideCategory == 2) { ?>
                <td><?php
                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.ride_category_id', array(
                            'label' => '',
                            'class' => 'form-control select-search',
                            'empty' => '',
                            'onchange' => 'javascript:getPriceRide(this.id);',
                            'id' => 'ride_category'.$i,
                        )) . "</div>";

                    ?></td>
            <?php } ?>
            <td>
                <?php
                $options = array('1' => __('Simple delivery'), '2' => __('Simple return'), '3' => __('Delivery / Return'));
                echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.'.$i.'.delivery_with_return', array(
                        'label' => '',
                        'id' => 'delivery_with_return'.$i,
                        'onchange' => 'javascript:getPriceRide(this.id);',
                        'value' => 1,
                        'options' => $options,
                        'class' => 'form-control select-search',
                    )) . "</div>"; ?>
            </td>

            <?php if ($profileId == ProfilesEnum::client
                && $type == TransportBillTypesEnum::order
            ) {
                ?>

                <td  style="min-width: 130px;"><?php
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


                    echo "<div id='div_unit_price$i'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.unit_price', array(
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
                            'onchange' => 'javascript:calculRistourneVal(this.id);',
                            'class' => 'form-control',
                        )) . "</div>";

                    echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.ristourne_val', array(
                            'label' => '',
                            'type' => 'hidden',
                            'id' => 'ristourne_val'.$i,
                            'onchange' => 'javascript:calculRistourne(this.id);',
                            'class' => 'form-control',
                        )) . "</div>";


                    echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.price_ht', array(
                            'label' => '',
                            'type' => 'hidden',
                            'id' => 'price_ht'.$i,
                            'readonly' => true,
                            'class' => 'form-control',
                        )) . "</div>";


                    echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.'.$i.'.tva_id', array(
                            'label' => '',
                            'type' => 'hidden',
                            'options' => $tvas,
                            'value' => 1,
                            'id' => 'tva'.$i,
                            'onchange' => 'javascript:calculatePriceRide(this.id);',
                            'class' => 'form-control ',
                        )) . "</div>";


                    echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.'.$i.'.price_ttc', array(
                            'label' => '',
                            'readonly' => true,
                            'id' => 'price_ttc'.$i,
                            'type' => 'hidden',
                            'class' => 'form-control',
                        )) . "</div>";


                    echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.type', array(
                            'id' => 'type'.$i,
                            'type' => 'hidden',
                            'value' => $type,
                        )) . "</div>";

                    echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.type_ride', array(
                            'id' => 'type_ride' . $i,
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
                    echo "<div class='hidden'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.status_id', array(
                            'id' => 'status'.$i,
                            'type' => 'number',
                            'type' => 'hidden',
                            'value' => $statusId,
                        )) . "</div>";

                    ?></td>

                <td>
                    <?php
                    echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.'.$i.'.customer_observation', array(
                        'label' => '',
                        'id' => 'customer_observation'.$i,
                        'class' => 'form-control',
                        )) . "</div>";
                ?>
                    <button  name="remove" id="<?php echo $i ?>" onclick="removeRide('<?php echo $i ?>');" class="btn btn-danger btn_remove" style="margin-top: 10px;">X</button>
                </td>
            <?php } else { ?>
                <?php if ($paramPriceNight == 1) { ?>
                    <td>
                        <?php  $options = array('1' => __('Day'), '2' => __('Night'));
                        echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.'.$i.'.type_price', array(
                                'label' => '',

                                'id' => 'type_price'.$i,
                                'onchange' => 'javascript:getPriceRide(this.id);',
                                'value' => 1,
                                'options' => $options,
                                'class' => 'form-control select-search',
                            )) . "</div>"; ?>
                    </td>
                <?php } ?>
                <td style="min-width: 130px;">
                    <?php


                    echo "<div id='div_unit_price$i'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.unit_price', array(
                            'label' => '',
                            'id' => 'unit_price'.$i,
                            'onchange' => 'javascript:calculatePriceRide(this.id);',
                            'class' => 'form-control',
                        )) . "</div>"; ?>
                </td>
                <td style="min-width: 100px;">
                    <?php


                    echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.ristourne_%', array(
                            'label' => '',
                            'id' => 'ristourne'.$i,
                            'onchange' => 'javascript:calculRistourneVal(this.id);',
                            'class' => 'form-control',
                        )) . "</div>";

                    echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.ristourne_val', array(
                            'label' => '',
                            'id' => 'ristourne_val'.$i,
                            'onchange' => 'javascript:calculRistourne(this.id);',
                            'class' => 'form-control',
                        )) . "</div>";


                    ?>
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


                <td style="min-width: 130px;">
                    <?php
                    echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.price_ht', array(
                            'label' => '',
                            'id' => 'price_ht'.$i,
                            'readonly' => true,
                            'class' => 'form-control',
                        )) . "</div>"; ?>
                </td>
                <td style="min-width: 50px;">
                    <?php
                    echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.'.$i.'.tva_id', array(
                            'label' => '',
                            'options' => $tvas,
                            'id' => 'tva'.$i,
                            'onchange' => 'javascript:calculatePriceRide(this.id);',
                            'class' => 'form-control ',
                        )) . "</div>"; ?>
                </td>
                <td style="min-width: 130px;">
                    <?php


                    echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.'.$i.'.price_ttc', array(
                            'label' => '',
                            'readonly' => true,
                            'id' => 'price_ttc'.$i,
                            'class' => 'form-control',
                        )) . "</div>";


                    echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.type', array(
                            'id' => 'type'.$i,
                            'type' => 'hidden',
                            'value' => $type,
                        )) . "</div>";

                    echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.type_ride', array(
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
                    echo "<div class='hidden'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.status_id', array(
                            'id' => 'status'.$i,
                            'type' => 'number',
                            'value' => $statusId,
                        )) . "</div>";

                    ?>
                </td>
                <td>
                    <?php
                    echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.'.$i.'.customer_observation', array(
                            'label' => '',
                            'id' => 'customer_observation'.$i,
                            'class' => 'form-control',
                        )) . "</div>";

                   if($i>1) { ?>
                       <button  name="remove" id="<?php echo $i ?>" onclick="removeRide('<?php echo $i ?>');" class="btn btn-danger btn_remove" style="margin-top: 10px;">X</button>
                  <?php } ?>

                </td>
            <?php } ?>
        </tr>

    <?php } ?>

    </tbody>
</table>