<table class="table table-bordered" id='dynamic_field'>
    <thead>
    <tr>
        <?php if ($reference == '0') { ?>
            <th><?= __('Reference') ?></th>
        <?php } ?>
        <th><?= __('Products') ?></th>
        <th><?= __('Rides') ?></th>
        <th><?= __('Final customer') ?></th>
        <th><?= __('Date / Time') ?></th>
        <?php if ($profileId != ProfilesEnum::client) { ?>
            <th><?= __('Designation') ?></th>
        <?php } ?>
        <?php if ($useRideCategory == 2) { ?>
            <th><?= __('Ride category') ?></th>
        <?php } ?>
        <th><?= __('Simple delivery / return') ?></th>
        <?php if ($profileId == ProfilesEnum::client && $type == TransportBillTypesEnum::order){ ?>
            <th><?= __('Quantity') ?></th>
            <th></th>
        <?php } else { ?>
        <?php if ($paramPriceNight == 1) { ?>
            <th><?= __('Price') ?></th>
        <?php } ?>
        <th><?= __('Unit price') ?></th>
        <th><?= __('Ristourne') . __('%') ?></th>
        <th><?= __('Quantity') ?></th>
        <th><?= __('Price HT') ?></th>
        <th><?= __('TVA') ?></th>
        <th><?= __('Price TTC') ?></th>
        <th><?= __('Observation') ?></th>
        <th><?= __('Status') ?></th>

            <?php } ?>
    </tr>
    </thead>
    <tbody id='rides-tbody'>
    <?php if (!empty($transportBillRides)) {
        $i = 1;
        foreach ($transportBillRides as $transportBillRide) {
            ?>
            <tr id='row<?php echo $i; ?>'>
                <?php if ($reference == '0') { ?>
                    <td>
                        <?php
                        echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.reference', array(
                                'label' => '',
                                'value' => $transportBillRide['TransportBillDetailRides']['reference'],
                                'class' => 'form-control',
                            )) . "</div>"; ?>
                    </td>
                <?php } ?>

                <?php if ($profileId == ProfilesEnum::client
                    && $type == TransportBillTypesEnum::order
                ) {
                    ?>
                    <td class="col-sm-3">
                        <?php
                        if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                            || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                        ) {
                            if($permissionEditInputLocked==0){
                                if ($usePurchaseBill == 1) {
                                    echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                            'label' => '',
                                            'class' => 'form-control select-search',
                                            'id' => 'product' . $i,
                                            'disabled' => true,
                                            'onchange' => 'javascript:getInformationProduct(this.id);',
                                            'value' => $usedProductIds[$i]['id'],
                                        )) . "</div>";

                                    echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                            'label' => '',
                                            'class' => 'form-control select-search',
                                            'id' => 'product' . $i,
                                            'type' => 'hidden',
                                            'onchange' => 'javascript:getInformationProduct(this.id);',
                                            'value' => $usedProductIds[$i]['id'],
                                        )) . "</div>";
                                } else {
                                    echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                            'label' => '',
                                            'class' => 'form-control select-search',
                                            'id' => 'product' . $i,
                                            'disabled' => true,
                                            'onchange' => 'javascript:getInformationProduct(this.id);',
                                            'value' => $transportBillRide['TransportBillDetailRides']['lot_id'],
                                        )) . "</div>";

                                    echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                            'label' => '',
                                            'class' => 'form-control select-search',
                                            'id' => 'product' . $i,
                                            'type' => 'hidden',
                                            'onchange' => 'javascript:getInformationProduct(this.id);',
                                            'value' => $transportBillRide['TransportBillDetailRides']['lot_id'],
                                        )) . "</div>";
                                }
                            }else {
                                if ($usePurchaseBill == 1) {
                                    echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                            'label' => '',
                                            'class' => 'form-control select-search',
                                            'id' => 'product' . $i,
                                            'onchange' => 'javascript:getInformationProduct(this.id);',
                                            'value' => $usedProductIds[$i]['id'],
                                        )) . "</div>";
                                } else {
                                    echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                            'label' => '',
                                            'class' => 'form-control select-search',
                                            'id' => 'product' . $i,

                                            'onchange' => 'javascript:getInformationProduct(this.id);',
                                            'value' => $transportBillRide['TransportBillDetailRides']['lot_id'],
                                        )) . "</div>";
                                }
                            }

                        } else {
                            if ($usePurchaseBill == 1) {
                                echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                        'label' => '',
                                        'class' => 'form-control select-search',
                                        'id' => 'product' . $i,
                                        'onchange' => 'javascript:getInformationProduct(this.id);',
                                        'value' => $usedProductIds[$i]['id'],
                                    )) . "</div>";
                            } else {
                                echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                        'label' => '',
                                        'class' => 'form-control select-search',
                                        'id' => 'product' . $i,

                                        'onchange' => 'javascript:getInformationProduct(this.id);',
                                        'value' => $transportBillRide['TransportBillDetailRides']['lot_id'],
                                    )) . "</div>";
                            }

                        }
                        echo "<div id='type-ride-div$i'>";
                        if ($typeRide == 3) {
                            if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                                || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                            ) {
                                if($permissionEditInputLocked==0){
                                    $options = array('1' => __('Existing ride'), '2' => __('Personalized ride'));
                                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                                            'id' => 'type_ride' . $i,
                                            'options' => $options,
                                            'label' => false,
                                            'disabled' => true,
                                            'class' => 'form-control select3',
                                            'value' => $transportBillRide['TransportBillDetailRides']['type_ride'],
                                            'onchange' => 'javascript:getInformationProduct(this.id);',
                                        )) . "</div>";
                                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                                            'id' => 'type_ride' . $i,
                                            'options' => $options,
                                            'label' => false,
                                            'class' => 'form-control select3',
                                            'value' => $transportBillRide['TransportBillDetailRides']['type_ride'],
                                            'onchange' => 'javascript:getInformationProduct(this.id);',
                                        )) . "</div>";
                                }else {
                                    $options = array('1' => __('Existing ride'), '2' => __('Personalized ride'));
                                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                                            'id' => 'type_ride' . $i,
                                            'options' => $options,
                                            'label' => false,
                                            'class' => 'form-control select3',
                                            'value' => $transportBillRide['TransportBillDetailRides']['type_ride'],
                                            'onchange' => 'javascript:getInformationProduct(this.id);',
                                        )) . "</div>";
                                }


                            } else {
                                $options = array('1' => __('Existing ride'), '2' => __('Personalized ride'));
                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                                        'id' => 'type_ride' . $i,
                                        'options' => $options,
                                        'label' => false,
                                        'class' => 'form-control select3',
                                        'value' => $transportBillRide['TransportBillDetailRides']['type_ride'],
                                        'onchange' => 'javascript:getInformationProduct(this.id);',
                                    )) . "</div>";
                            }

                        } else {
                            echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                                    'id' => 'type_ride' . $i,
                                    'type' => 'hidden',
                                    'value' => $transportBillRide['TransportBillDetailRides']['type_ride'],
                                )) . "</div>";
                        }

                        echo "</div>";

                        echo "<div id='type-pricing-div$i'>";
                        if ($typePricing == 3) {
                            $options = array('1' => __('Pricing by ride'), '2' => __('Pricing by distance'));
                            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_pricing', array(
                                    'id' => 'type_pricing' . $i,
                                    'options' => $options,
                                    'label' => false,
                                    'class' => 'form-control select2',
                                    'onchange' => 'javascript:getInformationPricing(this.id);',
                                    'value' => $transportBillRide['TransportBillDetailRides']['type_pricing'],
                                )) . "</div>";

                        } else {
                            echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_pricing', array(
                                    'id' => 'type_pricing' . $i,
                                    'type' => 'hidden',
                                    'value' => $transportBillRide['TransportBillDetailRides']['type_pricing'],
                                )) . "</div>";
                        }
                        echo "</div>";
                        ?>
                    </td>
                <?php } else { ?>

                    <td style="min-width: 200px;">
                        <?php

                        if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                            || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                        ) {
                            if($permissionEditInputLocked==0){
                                if ($usePurchaseBill == 1) {
                                    echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                            'label' => '',
                                            'class' => 'form-control select-search',
                                            'id' => 'product' . $i,
                                            'disabled' => true,
                                            'onchange' => 'javascript:getInformationProduct(this.id);',
                                            'value' => $usedProductIds[$i]['id'],
                                        )) . "</div>";

                                    echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                            'label' => '',
                                            'class' => 'form-control select-search',
                                            'id' => 'product' . $i,
                                            'type' => 'hidden',
                                            'onchange' => 'javascript:getInformationProduct(this.id);',
                                            'value' => $usedProductIds[$i]['id'],
                                        )) . "</div>";
                                } else {
                                    echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                            'label' => '',
                                            'class' => 'form-control select-search',
                                            'id' => 'product' . $i,
                                            'disabled' => true,
                                            'onchange' => 'javascript:getInformationProduct(this.id);',
                                            'value' => $transportBillRide['TransportBillDetailRides']['lot_id'],
                                        )) . "</div>";

                                    echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                            'label' => '',
                                            'class' => 'form-control select-search',
                                            'id' => 'product' . $i,
                                            'type' => 'hidden',
                                            'onchange' => 'javascript:getInformationProduct(this.id);',
                                            'value' => $transportBillRide['TransportBillDetailRides']['lot_id'],
                                        )) . "</div>";
                                }

                            }else {
                                if ($usePurchaseBill == 1) {
                                    echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                            'label' => '',
                                            'class' => 'form-control select-search',
                                            'id' => 'product' . $i,

                                            'onchange' => 'javascript:getInformationProduct(this.id);',
                                            'value' => $usedProductIds[$i]['id'],
                                        )) . "</div>";
                                } else {
                                    echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                            'label' => '',
                                            'class' => 'form-control select-search',
                                            'id' => 'product' . $i,

                                            'onchange' => 'javascript:getInformationProduct(this.id);',
                                            'value' => $transportBillRide['TransportBillDetailRides']['lot_id'],
                                        )) . "</div>";
                                }
                            }



                        } else {
                            if ($usePurchaseBill == 1) {
                                echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                        'label' => '',
                                        'class' => 'form-control select-search',
                                        'id' => 'product' . $i,

                                        'onchange' => 'javascript:getInformationProduct(this.id);',
                                        'value' => $usedProductIds[$i]['id'],
                                    )) . "</div>";
                            } else {
                                echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                        'label' => '',
                                        'class' => 'form-control select-search',
                                        'id' => 'product' . $i,

                                        'onchange' => 'javascript:getInformationProduct(this.id);',
                                        'value' => $transportBillRide['TransportBillDetailRides']['lot_id'],
                                    )) . "</div>";
                            }

                        }
                        echo "<div id='type-ride-div$i'>";
                        if ($transportBillRide['TransportBillDetailRides']['lot_id'] == 1) {
                            if ($typeRide == 3) {
                                $options = array('1' => __('Existing ride'), '2' => __('Personalized ride'));
                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                                        'id' => 'type_ride' . $i,
                                        'options' => $options,
                                        'label' => false,
                                        'class' => 'form-control select-search',
                                        'onchange' => 'javascript:getInformationProduct(this.id);',
                                        'value' => $transportBillRide['TransportBillDetailRides']['type_ride'],
                                    )) . "</div>";

                            } else {
                                echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                                        'id' => 'type_ride' . $i,
                                        'type' => 'hidden',
                                        'value' => $transportBillRide['TransportBillDetailRides']['type_ride'],
                                    )) . "</div>";
                            }
                        }
                        echo "</div >";
                        if ($transportBillRide['TransportBillDetailRides']['lot_id'] == 1) {
                            echo "<div id='type-pricing-div$i'>";
                            if ($typePricing == 3) {
                                $options = array('1' => __('Pricing by ride'), '2' => __('Pricing by distance'));
                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_pricing', array(
                                        'id' => 'type_pricing' . $i,
                                        'options' => $options,
                                        'label' => false,
                                        'class' => 'form-control select3',
                                        'onchange' => 'javascript:getInformationPricing(this.id);',
                                        'value' => $transportBillRide['TransportBillDetailRides']['type_pricing'],
                                    )) . "</div>";

                            } else {
                                echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_pricing', array(
                                        'id' => 'type_pricing' . $i,
                                        'type' => 'hidden',
                                        'value' => $transportBillRide['TransportBillDetailRides']['type_pricing'],
                                    )) . "</div>";
                            }
                            echo "</div>";
                        }
                        ?>

                    </td>

                <?php } ?>

                <?php if ($profileId == ProfilesEnum::client
                    && $type == TransportBillTypesEnum::order
                ) {
                    ?>
                    <td class="col-sm-3">
                        <?php
                        if ($reference != '0') {
                            echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.reference', array(
                                    'type' => 'hidden',
                                    'value' => $transportBillRide['TransportBillDetailRides']['reference'],
                                    'class' => 'form-control',
                                )) . "</div>";
                        }


                        echo "<div id='div-product$i'>";
                        switch($transportBillRide['ProductType']['id']){


                            case 1 :


                                if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                                    || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                                ) {

                                    if($permissionEditInputLocked==0){
                                        if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {

                                            echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                    'label' => '',
                                                    'empty' => '',
                                                    'id' => 'detail_ride' . $i,
                                                    'disabled' => true,
                                                    'value' => $transportBillRide['DetailRide']['id'],
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'class' => 'form-control',
                                                )) . "</div>";

                                            echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                    'label' => '',
                                                    'empty' => '',
                                                    'id' => 'detail_ride' . $i,
                                                    'type' => 'hidden',
                                                    'value' => $transportBillRide['DetailRide']['id'],
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'class' => 'form-control',
                                                )) . "</div>";

                                        } else {

                                            if ($transportBillRide['Departure']['id'] > 0) {
                                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                        'empty' => __('Departure city'),
                                                        'class' => 'form-control select-search-destination',
                                                        'label' => '',
                                                        'disabled' => true,
                                                        'options' => $departures,
                                                        'value' => $transportBillRide['Departure']['id'],
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'id' => 'departure_destination' . $i,
                                                    )) . "</div>";

                                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                        'empty' => __('Departure city'),
                                                        'class' => 'form-control',
                                                        'label' => '',
                                                        'type' => 'hidden',
                                                        'options' => $departures,
                                                        'value' => $transportBillRide['Departure']['id'],
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'id' => 'departure_destination' . $i,
                                                    )) . "</div>";

                                            } else {
                                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                        'empty' => __('Departure city'),
                                                        'class' => 'form-control select-search-destination',
                                                        'label' => '',
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'id' => 'departure_destination' . $i,
                                                    )) . "</div>";
                                            }

                                            if ($transportBillRide['Type']['id'] > 0) {
                                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                        'empty' => __('Type'),
                                                        'class' => 'form-control select-search',
                                                        'label' => '',
                                                        'disabled' => true,
                                                        'value' => $transportBillRide['Type']['id'],
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'id' => 'car_type' . $i,
                                                    )) . "</div>";

                                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                        'empty' => __('Type'),
                                                        'class' => 'form-control ',
                                                        'label' => '',
                                                        'type' => 'hidden',
                                                        'value' => $transportBillRide['Type']['id'],
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'id' => 'car_type' . $i,
                                                    )) . "</div>";
                                            } else {
                                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                        'empty' => __('Type'),
                                                        'class' => 'form-control select-search',
                                                        'label' => '',
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'id' => 'car_type' . $i,
                                                    )) . "</div>";
                                            }


                                        }

                                    }else {
                                        if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                            echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                    'label' => '',
                                                    'empty' => '',
                                                    'id' => 'detail_ride' . $i,
                                                    'value' => $transportBillRide['DetailRide']['id'],
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'class' => 'form-control select-search-detail-ride',
                                                )) . "</div>";
                                        } else {
                                            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                    'empty' => __('Departure city'),
                                                    'class' => 'form-control select-search-destination',
                                                    'label' => '',
                                                    'options' => $departures,
                                                    'value' => $transportBillRide['Departure']['id'],
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'id' => 'departure_destination' . $i,
                                                )) . "</div>";
                                            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                    'empty' => __('Type'),
                                                    'class' => 'form-control select-search',
                                                    'label' => '',
                                                    'value' => $transportBillRide['Type']['id'],
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'id' => 'car_type' . $i,
                                                )) . "</div>";
                                        }

                                    }


                                } else {


                                    if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                        echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                'label' => '',
                                                'empty' => '',
                                                'id' => 'detail_ride' . $i,
                                                'value' => $transportBillRide['DetailRide']['id'],
                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                'class' => 'form-control select-search-detail-ride',
                                            )) . "</div>";
                                    } else {
                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                'empty' => __('Departure city'),
                                                'class' => 'form-control select-search-destination',
                                                'label' => '',
                                                'options' => $departures,
                                                'value' => $transportBillRide['Departure']['id'],
                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                'id' => 'departure_destination' . $i,
                                            )) . "</div>";
                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                'empty' => __('Type'),
                                                'class' => 'form-control select-search',
                                                'label' => '',
                                                'value' => $transportBillRide['Type']['id'],
                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                'id' => 'car_type' . $i,
                                            )) . "</div>";
                                    }


                                }


                                break;
                            case 2 :

                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                        'empty' => __('Type'),
                                        'class' => 'form-control select-search',
                                        'label' => '',
                                        'value' => $transportBillRide['Type']['id'],
                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                        'id' => 'car_type' . $i,
                                    )) . "</div>";

                                echo $this->Form->input('TransportBillDetailRides.'.$i.'.car_required', array(
                                    'type'=>'hidden',
                                    'value'=>$transportBillRide['Product']['car_required'],
                                    'id'=>'car_required'.$i,
                                ));
                                if( $transportBillRide['Product']['car_required']==1){
                                    echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.car_id', array(
                                            'class' => 'form-control select-search-car',
                                            'required'=>true,
                                            'label'=>'',
                                            'options'=>$cars,
                                            'value' => $transportBillRide['TransportBillDetailRides']['car_id'],
                                            'id'=>'car'.$i,
                                            'empty' =>__('Car'),
                                        ))."</div>";
                                }




                                break;
                            case 3 :

                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.start_date', array(
                                        'label' => false,
                                        'placeholder' => 'dd/mm/yyyy hh:mm',
                                        'type' => 'text',

                                        'value' => $this->Time->format($transportBillRide['TransportBillDetailRides']['start_date'], '%d-%m-%Y %H:%M'),
                                        'class' => 'form-control datemask',
                                        'before' => '<label>' . __('Start date') . '</label><div class="input-group datetime">
																<label for="StartDate"></label><div class="input-group-addon">
																							<i class="fa fa-calendar"></i>
																						</div>',
                                        'after' => '</div>',
                                        'onchange' => 'javascript:calculateEndDate(this.id);',
                                        'id' => 'start_date'.$i,
                                        'required'=>true,
                                        'allowEmpty' => true,
                                    )) . "</div>";
                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                        'empty' => __('Type'),
                                        'class' => 'form-control select-search',
                                        'label' => '',
                                        'value' => $transportBillRide['Type']['id'],
                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                        'id' => 'car_type' . $i,
                                    )) . "</div>";

                                echo $this->Form->input('TransportBillDetailRides.'.$i.'.car_required', array(
                                    'type'=>'hidden',
                                    'value'=>$transportBillRide['Product']['car_required'],
                                    'id'=>'car_required'.$i,
                                ));
                                if( $transportBillRide['Product']['car_required']==1){
                                    echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.car_id', array(
                                            'class' => 'form-control select-search-car',
                                            'required'=>true,
                                            'label'=>'',
                                            'options'=>$cars,
                                            'value' => $transportBillRide['TransportBillDetailRides']['car_id'],
                                            'id'=>'car'.$i,
                                            'empty' =>__('Car'),
                                        ))."</div>";
                                }

                                echo $this->Form->input('TransportBillDetailRides.'.$i.'.nb_hours_required', array(
                                    'type'=>'hidden',
                                    'value'=>$transportBillRide['Product']['nb_hours_required'],
                                    'id'=>'nb_hours_required'.$i,
                                ));
                                if( $transportBillRide['Product']['nb_hours_required']==1){
                                    echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.nb_hours', array(
                                            'placeholder' =>__('Nb hours'),
                                            'class' => 'form-control',
                                            'label'=>'',
                                            'value'=>$transportBillRide['TransportBillDetailRides']['nb_hours'],
                                            'readonly'=>true,
                                            'id'=>'nb_hours'.$i,
                                        ))."</div>";
                                }else {
                                    echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.nb_hours', array(
                                            'placeholder' =>__('Nb hours'),
                                            'class' => 'form-control',
                                            'label'=>'',
                                            'value'=>$transportBillRide['TransportBillDetailRides']['nb_hours'],
                                            'id'=>'nb_hours'.$i,
                                            'onchange' => 'javascript:calculateEndDate(this.id);',
                                        ))."</div>";
                                }


                                break;




                            default :
                                if ($usePurchaseBill == 1) {

                                    if ($usedProductIds[$i]['with_lot'] == 1) { ?>


                                        <div class="form-group ">
                                            <div class="input select required">
                                                <label for="lot<?= $i ?>"></label>
                                                <select name="data[TransportBillDetailRides][<?= $i ?>][lot_id]"
                                                        class="form-control select3"
                                                        id="lot<?= $i ?>"
                                                        required="required">
                                                    <option value=""></option>

                                                    <?php

                                                    foreach ($lots as $qsKey => $qsData) {
                                                        if ($qsKey == $billProduct['BillProduct']['lot_id']) {
                                                            echo '<option value="' . $qsKey . '" selected>' . $qsData . '</option>' . "\n";
                                                        } else {
                                                            echo '<option value="' . $qsKey . '">' . $qsData . '</option>' . "\n";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php }
                                }
                                break;



                        }
                        if ($transportBillRide['TransportBillDetailRides']['lot_id'] == 1) {

                            if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                                || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                            ) {

                                if($permissionEditInputLocked==0){
                                    if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {

                                        echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                'label' => '',
                                                'empty' => '',
                                                'id' => 'detail_ride' . $i,
                                                'disabled' => true,
                                                'value' => $transportBillRide['DetailRide']['id'],
                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                'class' => 'form-control',
                                            )) . "</div>";

                                        echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                'label' => '',
                                                'empty' => '',
                                                'id' => 'detail_ride' . $i,
                                                'type' => 'hidden',
                                                'value' => $transportBillRide['DetailRide']['id'],
                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                'class' => 'form-control',
                                            )) . "</div>";

                                    } else {

                                        if ($transportBillRide['Departure']['id'] > 0) {
                                            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                    'empty' => __('Departure city'),
                                                    'class' => 'form-control select-search-destination',
                                                    'label' => '',
                                                    'disabled' => true,
                                                    'options' => $departures,
                                                    'value' => $transportBillRide['Departure']['id'],
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'id' => 'departure_destination' . $i,
                                                )) . "</div>";

                                            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                    'empty' => __('Departure city'),
                                                    'class' => 'form-control',
                                                    'label' => '',
                                                    'type' => 'hidden',
                                                    'options' => $departures,
                                                    'value' => $transportBillRide['Departure']['id'],
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'id' => 'departure_destination' . $i,
                                                )) . "</div>";

                                        } else {
                                            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                    'empty' => __('Departure city'),
                                                    'class' => 'form-control select-search-destination',
                                                    'label' => '',
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'id' => 'departure_destination' . $i,
                                                )) . "</div>";
                                        }

                                        if ($transportBillRide['Type']['id'] > 0) {
                                            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                    'empty' => __('Type'),
                                                    'class' => 'form-control select-search',
                                                    'label' => '',
                                                    'disabled' => true,
                                                    'value' => $transportBillRide['Type']['id'],
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'id' => 'car_type' . $i,
                                                )) . "</div>";

                                            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                    'empty' => __('Type'),
                                                    'class' => 'form-control ',
                                                    'label' => '',
                                                    'type' => 'hidden',
                                                    'value' => $transportBillRide['Type']['id'],
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'id' => 'car_type' . $i,
                                                )) . "</div>";
                                        } else {
                                            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                    'empty' => __('Type'),
                                                    'class' => 'form-control select-search',
                                                    'label' => '',
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'id' => 'car_type' . $i,
                                                )) . "</div>";
                                        }


                                    }

                                }else {
                                    if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                        echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                'label' => '',
                                                'empty' => '',
                                                'id' => 'detail_ride' . $i,
                                                'value' => $transportBillRide['DetailRide']['id'],
                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                'class' => 'form-control select-search-detail-ride',
                                            )) . "</div>";
                                    } else {
                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                'empty' => __('Departure city'),
                                                'class' => 'form-control select-search-destination',
                                                'label' => '',
                                                'options' => $departures,
                                                'value' => $transportBillRide['Departure']['id'],
                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                'id' => 'departure_destination' . $i,
                                            )) . "</div>";
                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                'empty' => __('Type'),
                                                'class' => 'form-control select-search',
                                                'label' => '',
                                                'value' => $transportBillRide['Type']['id'],
                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                'id' => 'car_type' . $i,
                                            )) . "</div>";
                                    }

                                }


                            } else {


                                if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                    echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                            'label' => '',
                                            'empty' => '',
                                            'id' => 'detail_ride' . $i,
                                            'value' => $transportBillRide['DetailRide']['id'],
                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                            'class' => 'form-control select-search-detail-ride',
                                        )) . "</div>";
                                } else {
                                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                            'empty' => __('Departure city'),
                                            'class' => 'form-control select-search-destination',
                                            'label' => '',
                                            'options' => $departures,
                                            'value' => $transportBillRide['Departure']['id'],
                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                            'id' => 'departure_destination' . $i,
                                        )) . "</div>";
                                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                            'empty' => __('Type'),
                                            'class' => 'form-control select-search',
                                            'label' => '',
                                            'value' => $transportBillRide['Type']['id'],
                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                            'id' => 'car_type' . $i,
                                        )) . "</div>";
                                }


                            }

                        } else {
                            if ($usePurchaseBill == 1) {

                                if ($usedProductIds[$i]['with_lot'] == 1) { ?>


                                    <div class="form-group ">
                                        <div class="input select required">
                                            <label for="lot<?= $i ?>"></label>
                                            <select name="data[TransportBillDetailRides][<?= $i ?>][lot_id]"
                                                    class="form-control select3"
                                                    id="lot<?= $i ?>"
                                                    required="required">
                                                <option value=""></option>

                                                <?php

                                                foreach ($lots as $qsKey => $qsData) {
                                                    if ($qsKey == $billProduct['BillProduct']['lot_id']) {
                                                        echo '<option value="' . $qsKey . '" selected>' . $qsData . '</option>' . "\n";
                                                    } else {
                                                        echo '<option value="' . $qsKey . '">' . $qsData . '</option>' . "\n";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php }
                            }
                        }



                        $j =0 ;
                        $nbFactor= 0;
                        $countTransportBillDetailRideFactors = count($transportBillDetailRideInputFactors);
                        if(!empty($transportBillDetailRideInputFactors )){
                            $transportBillDetailRideFactors = $transportBillDetailRideInputFactors;

                            for ( $j =1 ;$j<$countTransportBillDetailRideFactors; ){
                                if($transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['transport_bill_detail_ride_id']==
                                    $transportBillRide['TransportBillDetailRides']['id']){
                                    $nbFactor ++;
                                    echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $nbFactor . '.factor_id', array(
                                            'value' => $transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['factor_id'],
                                            'class' => 'form-control',
                                            'type'=>'hidden'
                                        )) . "</div>";
                                    echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $nbFactor. '.factor_value', array(
                                            'label' => $transportBillDetailRideFactors[$j]['Factor']['name'],
                                            'value' => $transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['factor_value'],
                                            'class' => 'form-control',
                                            'id'=>'factor'.$i.$nbFactor,
                                            'onchange' => 'javascript: calculatePriceRide(this.id);',
                                            'type'=>'integer'
                                        )) . "</div>";


                                }
                            }
                        }

                        $countTransportBillDetailRideFactors = count($transportBillDetailRideSelectFactors);
                        if(!empty($transportBillDetailRideSelectFactors )){
                            $transportBillDetailRideFactors = $transportBillDetailRideSelectFactors;

                            for ( $j =1 ;$j<$countTransportBillDetailRideFactors; ){
                                if($transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['transport_bill_detail_ride_id']==
                                    $transportBillRide['TransportBillDetailRides']['id']){
                                    $nbFactor ++;
                                    echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $nbFactor . '.factor_id', array(
                                            'value' => $transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['factor_id'],
                                            'class' => 'form-control',
                                            'type'=>'hidden'
                                        )) . "</div>";
                                    echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $nbFactor. '.factor_value', array(
                                            'label' => $transportBillDetailRideFactors[$j]['Factor']['name'],
                                            'value' => $transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['factor_value'],
                                            'class' => 'form-control select-search',
                                            'id'=>'factor'.$i.$nbFactor,
                                            'onchange' => 'javascript: calculatePriceRide(this.id);',
                                            'type'=>'select',
                                            'options'=>$transportBillDetailRideFactors[$j]['Factor']['options'],
                                        )) . "</div>";


                                }
                            }
                        }




                        echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_factor', array(
                                'type' => 'hidden',
                                'value' => $nbFactor,
                                'id' => 'nb_factor' . $i,
                            )) . "</div>";
                        echo "</div>";

                        ?>
                    </td>


                <?php } else { ?>
                    <td style="min-width: 200px;">
                        <?php
                        if ($reference != '0') {
                            echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.reference', array(
                                    'type' => 'hidden',
                                    'value' => $transportBillRide['TransportBillDetailRides']['reference'],
                                    'class' => 'form-control',
                                )) . "</div>";
                        }


                        echo "<div id='div-product$i'>";
                        switch($transportBillRide['ProductType']['id']){
                            case 1:
                                if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                                    || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                                ) {
                                    if($permissionEditInputLocked== 0){
                                        if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                            echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                    'label' => '',
                                                    'empty' => '',
                                                    'id' => 'detail_ride' . $i,
                                                    'disabled' => true,
                                                    'value' => $transportBillRide['DetailRide']['id'],
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'class' => 'form-control',
                                                )) . "</div>";

                                            echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                    'label' => '',
                                                    'empty' => '',
                                                    'id' => 'detail_ride' . $i,
                                                    'type' => 'hidden',
                                                    'value' => $transportBillRide['DetailRide']['id'],
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'class' => 'form-control',
                                                )) . "</div>";
                                        } else {
                                            if ($transportBillRide['Departure']['id'] > 0) {
                                                echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                        'empty' => __('Departure city'),
                                                        'class' => 'form-control select-search-destination',
                                                        'label' => '',
                                                        'disabled' => true,
                                                        'options' => $departures,
                                                        'value' => $transportBillRide['Departure']['id'],
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'id' => 'departure_destination' . $i,
                                                    )) . "</div>";

                                                echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                        'empty' => __('Departure city'),
                                                        'class' => 'form-control ',
                                                        'label' => '',
                                                        'type' => 'hidden',
                                                        'options' => $departures,
                                                        'value' => $transportBillRide['Departure']['id'],
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'id' => 'departure_destination' . $i,
                                                    )) . "</div>";
                                            } else {
                                                echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                        'empty' => __('Departure city'),
                                                        'class' => 'form-control select-search-destination',
                                                        'label' => '',
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'id' => 'departure_destination' . $i,
                                                    )) . "</div>";

                                            }
                                            if ($transportBillRide['Type']['id'] > 0) {
                                                echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                        'empty' => __('Type'),
                                                        'class' => 'form-control select-search',
                                                        'label' => '',
                                                        'disabled' => true,
                                                        'value' => $transportBillRide['Type']['id'],
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'id' => 'car_type' . $i,
                                                    )) . "</div>";

                                                echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                        'empty' => __('Type'),
                                                        'class' => 'form-control',
                                                        'label' => '',
                                                        'type' => 'hidden',
                                                        'value' => $transportBillRide['Type']['id'],
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'id' => 'car_type' . $i,
                                                    )) . "</div>";

                                            } else {
                                                echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                        'empty' => __('Type'),
                                                        'class' => 'form-control select-search',
                                                        'label' => '',
                                                        'value' => '',
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'id' => 'car_type' . $i,
                                                    )) . "</div>";
                                            }

                                        }

                                    }else {
                                        if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                            echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                    'label' => '',
                                                    'empty' => '',
                                                    'id' => 'detail_ride' . $i,
                                                    'value' => $transportBillRide['DetailRide']['id'],
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'class' => 'form-control select-search-detail-ride',
                                                )) . "</div>";
                                        } else {
                                            echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                    'empty' => __('Departure city'),
                                                    'class' => 'form-control select-search-destination',
                                                    'label' => '',
                                                    'options' => $departures,
                                                    'value' => $transportBillRide['Departure']['id'],
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'id' => 'departure_destination' . $i,
                                                )) . "</div>";
                                            echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                    'empty' => __('Type'),
                                                    'class' => 'form-control select-search',
                                                    'label' => '',
                                                    'value' => $transportBillRide['Type']['id'],
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'id' => 'car_type' . $i,
                                                )) . "</div>";
                                        }
                                    }


                                } else {
                                    if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                        echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                'label' => '',
                                                'empty' => '',
                                                'id' => 'detail_ride' . $i,
                                                'value' => $transportBillRide['DetailRide']['id'],
                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                'class' => 'form-control select-search-detail-ride',
                                            )) . "</div>";
                                    } else {
                                        echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                'empty' => __('Departure city'),
                                                'class' => 'form-control select-search-destination',
                                                'label' => '',
                                                'options' => $departures,
                                                'value' => $transportBillRide['Departure']['id'],
                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                'id' => 'departure_destination' . $i,
                                            )) . "</div>";
                                        echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                'empty' => __('Type'),
                                                'class' => 'form-control select-search',
                                                'label' => '',
                                                'value' => $transportBillRide['Type']['id'],
                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                'id' => 'car_type' . $i,
                                            )) . "</div>";
                                    }
                                }


                                break;
                            case 2:


                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                        'empty' => __('Type'),
                                        'class' => 'form-control select-search',
                                        'label' => '',
                                        'value' => $transportBillRide['Type']['id'],
                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                        'id' => 'car_type' . $i,
                                    )) . "</div>";

                                echo $this->Form->input('TransportBillDetailRides.'.$i.'.car_required', array(
                                    'type'=>'hidden',
                                    'value'=>$transportBillRide['Product']['car_required'],
                                    'id'=>'car_required'.$i,
                                ));

                                if( $transportBillRide['Product']['car_required']==1){

                                    echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.car_id', array(

                                            'class' => 'form-control select-search-car',
                                            'required'=>true,
                                            'label'=>'',
                                            'options'=>$cars,
                                            'value' => $transportBillRide['TransportBillDetailRides']['car_id'],
                                            'id'=>'car'.$i,
                                            'empty' =>__('Car'),
                                        ))."</div>";
                                }


                                break;
                            case 3:

                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.start_date', array(
                                        'label' => false,
                                        'placeholder' => 'dd/mm/yyyy hh:mm',
                                        'type' => 'text',

                                        'value' => $this->Time->format($transportBillRide['TransportBillDetailRides']['start_date'], '%d-%m-%Y %H:%M'),
                                        'class' => 'form-control datemask',
                                        'before' => '<label>' . __('Start date') . '</label><div class="input-group datetime">
																<label for="StartDate"></label><div class="input-group-addon">
																							<i class="fa fa-calendar"></i>
																						</div>',
                                        'after' => '</div>',
                                        'id' => 'start_date'.$i,
                                        'required'=>true,
                                        'allowEmpty' => true,
                                    )) . "</div>";
                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                        'empty' => __('Type'),
                                        'class' => 'form-control select-search',
                                        'label' => '',
                                        'value' => $transportBillRide['Type']['id'],
                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                        'id' => 'car_type' . $i,
                                    )) . "</div>";

                                echo $this->Form->input('TransportBillDetailRides.'.$i.'.car_required', array(
                                    'type'=>'hidden',
                                    'value'=>$transportBillRide['Product']['car_required'],
                                    'id'=>'car_required'.$i,
                                ));

                                if( $transportBillRide['Product']['car_required']==1){

                                    echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.car_id', array(

                                            'class' => 'form-control select-search-car',
                                            'required'=>true,
                                            'label'=>'',
                                            'options'=>$cars,
                                            'value' => $transportBillRide['TransportBillDetailRides']['car_id'],
                                            'id'=>'car'.$i,
                                            'empty' =>__('Car'),
                                        ))."</div>";
                                }

                                echo $this->Form->input('TransportBillDetailRides.'.$i.'.nb_hours_required', array(
                                    'type'=>'hidden',
                                    'value'=>$transportBillRide['Product']['nb_hours_required'],
                                    'id'=>'nb_hours_required'.$i,
                                ));

                                if($transportBillRide['Product']['nb_hours_required']==1){
                                    echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.nb_hours', array(
                                            'placeholder' =>__('Nb hours'),
                                            'class' => 'form-control',
                                            'label'=>'',
                                            'value'=>$transportBillRide['TransportBillDetailRides']['nb_hours'],
                                            'readonly'=>true,
                                            'id'=>'nb_hours'.$i,
                                        ))."</div>";
                                }else {
                                    echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.nb_hours', array(
                                            'placeholder' =>__('Nb hours'),
                                            'class' => 'form-control',
                                            'label'=>'',
                                            'value'=>$transportBillRide['TransportBillDetailRides']['nb_hours'],
                                            'id'=>'nb_hours'.$i,
                                            'onchange' => 'javascript:calculateEndDate(this.id);',
                                        ))."</div>";
                                }




                                break;


                            default :
                                if ($usePurchaseBill == 1) {

                                    if ($usedProductIds[$i]['with_lot'] == 1) { ?>


                                        <div class="form-group ">
                                            <div class="input select required">
                                                <label for="lot<?= $i ?>"></label>
                                                <select name="data[TransportBillDetailRides][<?= $i ?>][lot_id]"
                                                        class="form-control select3"
                                                        id="lot<?= $i ?>"
                                                        required="required">
                                                    <option value=""></option>

                                                    <?php

                                                    foreach ($lots as $qsKey => $qsData) {
                                                        if ($qsKey == $transportBillRide['TransportBillDetailRides']['lot_id']) {
                                                            echo '<option value="' . $qsKey . '" selected>' . $qsData . '</option>' . "\n";
                                                        } else {
                                                            echo '<option value="' . $qsKey . '">' . $qsData . '</option>' . "\n";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>


                                    <?php }
                                }
                                break;

                        }






                        $nbFactor =0 ;
                        $j =0 ;
                        $nb = 0;
                        $countTransportBillDetailRideFactors = count($transportBillDetailRideInputFactors);
                        if(!empty($transportBillDetailRideInputFactors)){
                            $transportBillDetailRideFactors = $transportBillDetailRideInputFactors;

                            for ( $j =$nb ;$j<$countTransportBillDetailRideFactors; $j++ ){
                                if($transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['transport_bill_detail_ride_id']==
                                    $transportBillRide['TransportBillDetailRides']['id']){
                                    $nbFactor++;
                                    echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $nbFactor . '.id', array(
                                            'value' => $transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['id'],
                                            'class' => 'form-control',
                                            'type'=>'hidden'
                                        )) . "</div>";
                                    echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $nbFactor . '.factor_id', array(
                                            'value' => $transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['factor_id'],
                                            'class' => 'form-control',
                                            'type'=>'hidden'
                                        )) . "</div>";
                                    echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $nbFactor. '.factor_value', array(
                                            'label' => $transportBillDetailRideFactors[$j]['Factor']['name'],
                                            'value' => $transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['factor_value'],
                                            'class' => 'form-control',
                                            'id'=>'factor'.$i.$nbFactor,
                                            'onchange' => 'javascript: calculatePriceRide(this.id);',
                                            'type'=>'integer'
                                        )) . "</div>";

                                    $nb++;

                                }
                            }
                        }
                        $nb = 0;
                        $countTransportBillDetailRideFactors = count($transportBillDetailRideSelectFactors);

                        if(!empty($transportBillDetailRideSelectFactors)){
                            $transportBillDetailRideFactors = $transportBillDetailRideSelectFactors;



                            for ( $j =$nb ;$j<$countTransportBillDetailRideFactors; $j++ ){
                                if($transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['transport_bill_detail_ride_id']==
                                    $transportBillRide['TransportBillDetailRides']['id']){
                                    $nbFactor++;
                                    echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $nbFactor . '.id', array(
                                            'value' => $transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['id'],
                                            'class' => 'form-control',
                                            'type'=>'hidden'
                                        )) . "</div>";
                                    echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $nbFactor . '.factor_id', array(
                                            'value' => $transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['factor_id'],
                                            'class' => 'form-control',
                                            'type'=>'hidden'
                                        )) . "</div>";
                                    echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $nbFactor. '.factor_value', array(
                                            'label' => $transportBillDetailRideFactors[$j]['Factor']['name'],
                                            'value' => $transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['factor_value'],
                                            'class' => 'form-control select-search',
                                            'id'=>'factor'.$i.$nbFactor,
                                            'onchange' => 'javascript: calculatePriceRide(this.id);',
                                            'type'=>'select',
                                            'options'=>$transportBillDetailRideFactors[$j]['Factor']['options'],
                                        )) . "</div>";

                                    $nb++;

                                }
                            }
                        }



                        echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_factor', array(
                                'type' => 'hidden',
                                'value' => $nbFactor,
                                'id' => 'nb_factor' . $i,
                            )) . "</div>";
                        echo "</div >";


                        ?>
                    </td>


                <?php } ?>

                <?php if ($profileId == ProfilesEnum::client
                    && $type == TransportBillTypesEnum::order
                ) {
                    ?>
                    <td class="col-sm-3">
                        <?php
                        switch($transportBillRide['ProductType']['id']){
                            case 1 :
                                if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                                    || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                                ) {
                                    if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                        echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                'label' => '',
                                                'empty' => '',
                                                'id' => 'client_final' . $i,
                                                'disabled' => true,
                                                'options' => $finalSuppliers,
                                                'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                'class' => 'form-control',
                                            )) . "</div>";

                                        echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                'label' => '',
                                                'empty' => '',
                                                'id' => 'client_final' . $i,
                                                'type' => 'hidden',
                                                'options' => $finalSuppliers,
                                                'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                'class' => 'form-control',
                                            )) . "</div>";
                                    } else {
                                        echo "<div id='div-arrival$i'>";
                                        if ($transportBillRide['TransportBillDetailRides']['lot_id'] == 1) {
                                            if ($transportBillRide['Arrival']['id'] > 0) {
                                                echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                        'empty' => __('Arrival city'),
                                                        'class' => 'form-control select-search-destination',
                                                        'label' => '',
                                                        'disabled' => true,
                                                        'options' => $arrivals,
                                                        'value' => $transportBillRide['Arrival']['id'],
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'id' => 'arrival_destination' . $i,
                                                    )) . "</div>";
                                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                        'empty' => __('Arrival city'),
                                                        'class' => 'form-control ',
                                                        'label' => '',
                                                        'type' => 'hidden',
                                                        'options' => $arrivals,
                                                        'value' => $transportBillRide['Arrival']['id'],
                                                        'id' => 'arrival_destination' . $i,
                                                    )) . "</div>";
                                            } else {
                                                if(Configure::read("gestion_programmation_sous_traitance") == '1'
                                                    && $type !=TransportBillTypesEnum::quote
                                                ){
                                                    echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                            'empty' => __('Arrival city'),
                                                            'class' => 'form-control select-search-destination',
                                                            'label' => '',
                                                            'required'=>true,
                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                            'id' => 'arrival_destination' . $i,
                                                        )) . "</div>";
                                                }else {
                                                    echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                            'empty' => __('Arrival city'),
                                                            'class' => 'form-control select-search-destination',
                                                            'label' => '',
                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                            'id' => 'arrival_destination' . $i,
                                                        )) . "</div>";
                                                }

                                            }
                                        }
                                        echo "</div>";

                                        if ($transportBillRide['TransportBillDetailRides']['supplier_final_id'] > 0) {
                                            echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                    'empty' => __('Final customer'),
                                                    'label' => '',
                                                    'id' => 'client_final' . $i,
                                                    'disabled' => true,
                                                    'options' => $finalSuppliers,
                                                    'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'class' => 'form-control',
                                                )) . "</div>";

                                            echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                    'empty' => __('Final customer'),
                                                    'label' => '',
                                                    'id' => 'client_final' . $i,
                                                    'type' => 'hidden',
                                                    'options' => $finalSuppliers,
                                                    'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'class' => 'form-control',
                                                )) . "</div>";
                                        } else {
                                            echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                    'empty' => __('Final customer'),
                                                    'label' => '',
                                                    'id' => 'client_final' . $i,
                                                    'class' => 'form-control select-search-client-final',
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'class' => 'form-control',
                                                )) . "</div>";
                                        }
                                    }

                                } else {
                                    if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                        echo "<div class='form-group' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                'label' => '',
                                                'empty' => __('Final customer'),
                                                'id' => 'client_final' . $i,
                                                'class' => 'form-control select-search-client-final',
                                                'options' => $finalSuppliers,
                                                'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                            )) . "</div>";
                                    } else {
                                        echo "<div id='div-arrival$i'>";
                                        if(Configure::read("gestion_programmation_sous_traitance") == '1'
                                            && $type !=TransportBillTypesEnum::quote
                                        ){
                                            echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                    'empty' => __('Arrival city'),
                                                    'class' => 'form-control select-search-destination',
                                                    'label' => '',
                                                    'required'=>true,
                                                    'options' => $arrivals,
                                                    'value' => $transportBillRide['Arrival']['id'],
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'id' => 'arrival_destination' . $i,
                                                )) . "</div>";
                                        }else {
                                            echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                    'empty' => __('Arrival city'),
                                                    'class' => 'form-control select-search-destination',
                                                    'label' => '',
                                                    'options' => $arrivals,
                                                    'value' => $transportBillRide['Arrival']['id'],
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'id' => 'arrival_destination' . $i,
                                                )) . "</div>";
                                        }


                                        echo "</div>";
                                        echo "<div class='form-group' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                'empty' => __('Final customer'),
                                                'label' => '',
                                                'id' => 'client_final' . $i,
                                                'class' => 'form-control select-search-client-final',
                                                'options' => $finalSuppliers,
                                                'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                            )) . "</div>";
                                    }
                                }
                                break;

                            case 2 :

                                echo "<div class='form-group' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                        'empty' => __('Final customer'),
                                        'label' => '',
                                        'id' => 'client_final' . $i,
                                        'class' => 'form-control select-search-client-final',
                                        'options' => $finalSuppliers,
                                        'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                    )) . "</div>";
                                break ;
                            case 3 :
                                echo "<div id='div-arrival$i'>";
                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.end_date', array(
                                        'label' => false,
                                        'placeholder' => 'dd/mm/yyyy hh:mm',
                                        'type' => 'text',
                                        'value' => $this->Time->format($transportBillRide['TransportBillDetailRides']['end_date'], '%d-%m-%Y %H:%M'),
                                        'class' => 'form-control datemask',
                                        'before' => '<label>' . __('End date') . '</label><div class="input-group datetime">
																<label for="EndDate"></label><div class="input-group-addon">
																							<i class="fa fa-calendar"></i>
																						</div>',
                                        'after' => '</div>',
                                        'id' => 'end_date'.$i,
                                        'required'=>true,
                                        'allowEmpty' => true,
                                    )) . "</div>";
                                echo "</div>";
                                echo "<div class='form-group' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                        'empty' => __('Final customer'),
                                        'label' => '',
                                        'id' => 'client_final' . $i,
                                        'class' => 'form-control select-search-client-final',
                                        'options' => $finalSuppliers,
                                        'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                    )) . "</div>";
                                break ;

                            default	:

                                echo "<div class='form-group' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                        'empty' => __('Final customer'),
                                        'label' => '',
                                        'id' => 'client_final' . $i,
                                        'class' => 'form-control select-search-client-final',
                                        'options' => $finalSuppliers,
                                        'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                    )) . "</div>";

                                break;

                        }



                        ?>
                    </td>
                <?php } else { ?>
                    <td style="min-width: 200px;">
                        <?php

                        switch($transportBillRide['ProductType']['id']){
                            case 1 :
                                if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                                    || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                                ) {

                                    if($permissionEditInputLocked==0){
                                        if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                            echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                    'label' => '',
                                                    'empty' => __('Final customer'),
                                                    'id' => 'client_final' . $i,
                                                    'disabled' => true,
                                                    'options' => $finalSuppliers,
                                                    'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'class' => 'form-control',
                                                )) . "</div>";

                                            echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                    'label' => '',
                                                    'empty' => __('Final customer'),
                                                    'id' => 'client_final' . $i,
                                                    'type' => 'hidden',
                                                    'options' => $finalSuppliers,
                                                    'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'class' => 'form-control',
                                                )) . "</div>";
                                        } else {
                                            echo "<div id='div-arrival$i'>";
                                            if ($transportBillRide['TransportBillDetailRides']['lot_id'] == 1) {

                                                if ($transportBillRide['Arrival']['id'] > 0) {
                                                    echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                            'empty' => __('Arrival city'),
                                                            'class' => 'form-control select-search-destination',
                                                            'label' => '',
                                                            'disabled' => true,
                                                            'options' => $arrivals,
                                                            'value' => $transportBillRide['Arrival']['id'],
                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                            'id' => 'arrival_destination' . $i,
                                                        )) . "</div>";


                                                    echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                            'empty' => __('Arrival city'),
                                                            'class' => 'form-control ',
                                                            'label' => '',
                                                            'type' => 'hidden',
                                                            'options' => $arrivals,
                                                            'value' => $transportBillRide['Arrival']['id'],
                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                            'id' => 'arrival_destination' . $i,
                                                        )) . "</div>";


                                                } else {
                                                    if(Configure::read("gestion_programmation_sous_traitance") == '1'
                                                        && $type !=TransportBillTypesEnum::quote
                                                    ){
                                                        echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                                'empty' => __('Arrival city'),
                                                                'class' => 'form-control select-search-destination',
                                                                'label' => '',
                                                                'required'=>true,
                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                'id' => 'arrival_destination' . $i,
                                                            )) . "</div>";
                                                    }else {
                                                        echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                                'empty' => __('Arrival city'),
                                                                'class' => 'form-control select-search-destination',
                                                                'label' => '',
                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                'id' => 'arrival_destination' . $i,
                                                            )) . "</div>";
                                                    }

                                                }
                                            }
                                            echo "</div>";


                                            if ($transportBillRide['TransportBillDetailRides']['supplier_final_id'] > 0) {
                                                echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                        'empty' => __('Final customer'),
                                                        'label' => '',
                                                        'id' => 'client_final' . $i,
                                                        'disabled' => true,
                                                        'options' => $finalSuppliers,
                                                        'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'class' => 'form-control',
                                                    )) . "</div>";

                                                echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                        'label' => '',
                                                        'empty' => __('Final customer'),
                                                        'id' => 'client_final' . $i,
                                                        'type' => 'hidden',
                                                        'options' => $finalSuppliers,
                                                        'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'class' => 'form-control',
                                                    )) . "</div>";
                                            } else {
                                                echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                        'empty' => __('Final customer'),
                                                        'label' => '',
                                                        'id' => 'client_final' . $i,
                                                        'class' => 'form-control select-search-client-final',
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                    )) . "</div>";

                                            }


                                        }

                                    }else {
                                        if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                            echo "<div class='form-group form-tab' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                    'label' => '',
                                                    'empty' => __('Final customer'),
                                                    'id' => 'client_final' . $i,
                                                    'class' => 'form-control select-search-client-final',
                                                    'options' => $finalSuppliers,
                                                    'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                )) . "</div>";
                                        } else {
                                            echo "<div id='div-arrival$i'>";
                                            if ($transportBillRide['TransportBillDetailRides']['lot_id'] == 1) {
                                                if(Configure::read("gestion_programmation_sous_traitance") == '1'
                                                    && $type !=TransportBillTypesEnum::quote
                                                ){
                                                    echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                            'empty' => __('Arrival city'),
                                                            'class' => 'form-control select-search-destination',
                                                            'label' => '',
                                                            'required'=>true,
                                                            'options' => $arrivals,
                                                            'value' => $transportBillRide['Arrival']['id'],
                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                            'id' => 'arrival_destination' . $i,
                                                        )) . "</div>";
                                                }else {
                                                    echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                            'empty' => __('Arrival city'),
                                                            'class' => 'form-control select-search-destination',
                                                            'label' => '',
                                                            'options' => $arrivals,
                                                            'value' => $transportBillRide['Arrival']['id'],
                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                            'id' => 'arrival_destination' . $i,
                                                        )) . "</div>";
                                                }


                                            }
                                            echo "</div>";
                                            echo "<div class='form-group form-tab' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                    'empty' => __('Final customer'),
                                                    'label' => '',
                                                    'id' => 'client_final' . $i,
                                                    'class' => 'form-control select-search-client-final',
                                                    'options' => $finalSuppliers,
                                                    'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                )) . "</div>";
                                        }
                                    }

                                } else {
                                    if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                        echo "<div class='form-group form-tab' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                'label' => '',
                                                'empty' => __('Final customer'),
                                                'id' => 'client_final' . $i,
                                                'class' => 'form-control select-search-client-final',
                                                'options' => $finalSuppliers,
                                                'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                            )) . "</div>";
                                    } else {


                                        echo "<div id='div-arrival$i'>";
                                        if ($transportBillRide['TransportBillDetailRides']['lot_id'] == 1) {
                                            if(Configure::read("gestion_programmation_sous_traitance") == '1'
                                                && $type !=TransportBillTypesEnum::quote
                                            ) {
                                                echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                        'empty' => __('Arrival city'),
                                                        'class' => 'form-control select-search-destination',
                                                        'label' => '',
                                                        'required'=>true,
                                                        'options' => $arrivals,
                                                        'value' => $transportBillRide['Arrival']['id'],
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'id' => 'arrival_destination' . $i,
                                                    )) . "</div>";

                                            }else {
                                                echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                        'empty' => __('Arrival city'),
                                                        'class' => 'form-control select-search-destination',
                                                        'label' => '',
                                                        'options' => $arrivals,
                                                        'value' => $transportBillRide['Arrival']['id'],
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'id' => 'arrival_destination' . $i,
                                                    )) . "</div>";
                                            }

                                        }
                                        echo "</div>";
                                        echo "<div class='form-group form-tab' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                'empty' => __('Final customer'),
                                                'label' => '',
                                                'id' => 'client_final' . $i,
                                                'class' => 'form-control select-search-client-final',
                                                'options' => $finalSuppliers,
                                                'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                            )) . "</div>";
                                    }
                                }


                                break;

                            case 2:

                                echo "<div class='form-group form-tab' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                        'empty' => __('Final customer'),
                                        'label' => '',
                                        'id' => 'client_final' . $i,
                                        'class' => 'form-control select-search-client-final',
                                        'options' => $finalSuppliers,
                                        'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                    )) . "</div>";
                                break ;
                            case 3:
                                echo "<div id='div-arrival$i'>";
                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.end_date', array(
                                        'label' => false,
                                        'placeholder' => 'dd/mm/yyyy hh:mm',
                                        'type' => 'text',
                                        'value' => $this->Time->format($transportBillRide['TransportBillDetailRides']['end_date'], '%d-%m-%Y %H:%M'),
                                        'class' => 'form-control datemask',
                                        'before' => '<label>' . __('End date') . '</label><div class="input-group datetime">
																<label for="EndDate"></label><div class="input-group-addon">
																							<i class="fa fa-calendar"></i>
																						</div>',
                                        'after' => '</div>',
                                        'id' => 'end_date'.$i,
                                        'required'=>true,
                                        'allowEmpty' => true,
                                    )) . "</div>";
                                echo "</div>";
                                echo "<div class='form-group form-tab' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                        'empty' => __('Final customer'),
                                        'label' => '',
                                        'id' => 'client_final' . $i,
                                        'class' => 'form-control select-search-client-final',
                                        'options' => $finalSuppliers,
                                        'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                    )) . "</div>";
                                break ;

                            default :
                                echo "<div class='form-group form-tab' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                        'empty' => __('Final customer'),
                                        'label' => '',
                                        'id' => 'client_final' . $i,
                                        'class' => 'form-control select-search-client-final',
                                        'options' => $finalSuppliers,
                                        'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                    )) . "</div>";
                                break;

                        }




                        ?>
                    </td>

                <?php } ?>


                <td style="min-width: 200px;">
                    <?php
                    if(Configure::read("gestion_programmation_sous_traitance") == '1'
                        && $type !=TransportBillTypesEnum::quote
                    ){
                        echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.programming_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'required'=>true,
                                'class' => 'form-control datemask',
                                'id' => 'programming_date'.$i,
                                'value' => $this->Time->format($transportBillRide['TransportBillDetailRides']['programming_date'], '%d/%m/%Y'),
                                'before' => '<div class="input-group date "><label for="programmingDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                                'after' => '</div>',
                            )) . "</div>";

                        echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.charging_time', array(
                                'label' => '',
                                'placeholder' => __('Charging hour'),
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'id' => 'charging_time'.$i,
                                'required'=>true,
                                'value' => $this->Time->format($transportBillRide['TransportBillDetailRides']['charging_time'], '%H:%M'),
                                'before' => '<div class="input-group "><label for="chargingTime"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                                'after' => '</div>',
                            )) . "</div>";

                        echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.unloading_date', array(
                                'label' => '',
                                'placeholder' => __('Unloading date'),
                                'type' => 'text',
                                'required'=>true,
                                'class' => 'form-control datemask',
                                'id' => 'unloading_date'.$i,
                                'value' => $this->Time->format($transportBillRide['TransportBillDetailRides']['unloading_date'], '%d/%m/%Y %H:%M'),
                                'before' => '<div class="input-group "><label for="unloadingDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                                'after' => '</div>',
                            )) . "</div>";
                    }else {
                        echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.programming_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'id' => 'programming_date'.$i,
                                'value' => $this->Time->format($transportBillRide['TransportBillDetailRides']['programming_date'], '%d/%m/%Y'),
                                'before' => '<div class="input-group date "><label for="programmingDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                                'after' => '</div>',
                            )) . "</div>";

                        echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.charging_time', array(
                                'label' => '',
                                'placeholder' => __('Charging hour'),
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'id' => 'charging_time'.$i,
                                'value' => $this->Time->format($transportBillRide['TransportBillDetailRides']['charging_time'], '%H:%M'),
                                'before' => '<div class="input-group "><label for="chargingTime"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                                'after' => '</div>',
                            )) . "</div>";

                        echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.unloading_date', array(
                                'label' => '',
                                'placeholder' => __('Unloading date'),
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'id' => 'unloading_date'.$i,
                                'value' => $this->Time->format($transportBillRide['TransportBillDetailRides']['unloading_date'], '%d/%m/%Y %H:%M'),
                                'before' => '<div class="input-group "><label for="unloadingDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                                'after' => '</div>',
                            )) . "</div>";


                    }




                    ?>


                </td>



                <?php if ($profileId != ProfilesEnum::client) { ?>
                    <td style="min-width: 200px;">
                        <?php
                        echo "<div id='div-designation$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.designation', array(
                                'label' => '',
                                'empty' => '',
                                'id' => 'designation' . $i,
                                'value' => $transportBillRide['TransportBillDetailRides']['designation'],
                                'class' => 'form-control',
                            )) . "</div>";
                        ?>
                    </td>
                <?php } ?>

                <?php if ($useRideCategory == 2) { ?>
                    <td>
                        <?php

                        if (isset($transportBillRide['TransportBillDetailRides']['ride_category_id'])
                            && !empty($transportBillRide['TransportBillDetailRides']['ride_category_id'])
                        ) {
                            $ride_category_id = $transportBillRide['TransportBillDetailRides']['ride_category_id'];

                            echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.ride_category_id', array(
                                    'label' => '',
                                    'empty' => '',
                                    'id' => 'ride_category' . $i,
                                    'value' => $ride_category_id,
                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                    'class' => 'form-control',
                                )) . "</div>";

                        } else {
                            echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.ride_category_id', array(
                                    'label' => '',
                                    'empty' => '',
                                    'id' => 'ride_category' . $i,

                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                    'class' => 'form-control',
                                )) . "</div>";

                        }
                        ?>

                    </td>
                <?php } ?>

                <td>
                    <?php
                    echo "<div id='delivery-return-div$i'>";
                    if ($transportBillRide['TransportBillDetailRides']['lot_id'] == 1) {
                        $options = array('1' => __('Simple delivery'), '2' => __('Simple return'), '3' => __('Delivery / Return'));
                        echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.delivery_with_return', array(
                                'label' => '',
                                'id' => 'delivery_with_return' . $i,
                                'onchange' => 'javascript:getPriceRide(this.id);',
                                'value' => $transportBillRide['TransportBillDetailRides']['delivery_with_return'],
                                'options' => $options,
                                'class' => 'form-control select-search',
                            )) . "</div>";
                    }
                    echo "</div>";

                    echo "<div id='tonnage-div$i'>";
                    if ($transportBillRide['TransportBillDetailRides']['lot_id'] == 1) {
                        if ($transportBillRide['TransportBillDetailRides']['type_pricing'] == 2) {
                            echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.tonnage_id', array(
                                    'label' => '',
                                    'empty' => __('Tonnage'),
                                    'id' => 'tonnage' . $i,
                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                    'value' => $transportBillRide['TransportBillDetailRides']['tonnage_id'],
                                    'class' => 'form-control select-search',
                                )) . "</div>";
                        }
                    }
                    echo "</div>";

                    ?>
                </td>

                <?php if ($profileId == ProfilesEnum::client
                    && $type == TransportBillTypesEnum::order
                ) {
                    ?>

                    <td style="min-width: 70px;">
                        <?php if ($paramPriceNight == 1) { ?>

                            <?php $options = array('1' => __('Day'), '2' => __('Night'));
                            echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_price', array(
                                    'label' => '',
                                    'type' => 'hidden',
                                    'id' => 'type_price' . $i,
                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                    'value' => $transportBillRide['TransportBillDetailRides']['type_price'],
                                    'options' => $options,
                                    'class' => 'form-control select-search',
                                )) . "</div>"; ?>

                        <?php } ?>

                        <?php


                        echo "<div id='div_unit_price$i'  >" . $this->Form->input('TransportBillDetailRides.' . $i . '.unit_price', array(
                                'label' => '',
                                'type' => 'hidden',
                                //'readonly' => true,
                                'id' => 'unit_price' . $i,
                                'value' => $transportBillRide['TransportBillDetailRides']['unit_price'],
                                'onchange' => 'javascript:calculatePriceRide(this.id);',
                                'class' => 'form-control',
                            )) . "</div>";


                        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_%', array(
                                'label' => '',
                                'type' => 'hidden',
                                //'readonly' => true,
                                'id' => 'ristourne' . $i,
                                'value' => $transportBillRide['TransportBillDetailRides']['ristourne_%'],
                                'onchange' => 'javascript:calculRistourneVal(this.id);',
                                'class' => 'form-control',
                            )) . "</div>";

                        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_val', array(
                                'label' => '',
                                //'readonly' => true,
                                'type' => 'hidden',
                                'id' => 'ristourne_val' . $i,
                                'value' => $transportBillRide['TransportBillDetailRides']['ristourne_val'],
                                'onchange' => 'javascript:calculRistourne(this.id);',
                                'class' => 'form-control',
                            )) . "</div>";


                        if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                            || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                        ) {
                            ?>

                            <?php
                            if($permissionEditInputLocked==0){
                                echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
                                        'placeholder' => __('Enter quantity'),
                                        'id' => 'nb_trucks' . $i,
                                        'label' => '',
                                        'value' => $transportBillRide['TransportBillDetailRides']['nb_trucks'],
                                        'readonly' => true,
                                        'onchange' => 'javascript:calculatePriceRide(this.id);',
                                        'class' => 'form-control',
                                    )) . "</div>";
                            }else {
                                if ($nbTrucksModifiable == 2) {
                                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
                                            'label' => '',
                                            'placeholder' => __('Enter quantity'),
                                            'onchange' => 'javascript: calculatePriceRide(this.id);',
                                            'readonly' => true,
                                            'id' => 'nb_trucks' . $i,
                                            'value' => $transportBillRide['TransportBillDetailRides']['nb_trucks'],
                                            'class' => 'form-control',
                                        )) . "</div>";
                                } else {
                                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
                                            'label' => '',
                                            'placeholder' => __('Enter quantity'),
                                            'onchange' => 'javascript: calculatePriceRide(this.id);',
                                            'id' => 'nb_trucks' . $i,
                                            'value' => $transportBillRide['TransportBillDetailRides']['nb_trucks'],
                                            'class' => 'form-control',
                                        )) . "</div>";
                                }
                            }


                            ?>


                        <?php } else { ?>

                            <?php

                            if ($nbTrucksModifiable == 2) {
                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
                                        'label' => '',
                                        'placeholder' => __('Enter quantity'),
                                        'onchange' => 'javascript: calculatePriceRide(this.id);',
                                        'readonly' => true,
                                        'id' => 'nb_trucks' . $i,
                                        'value' => $transportBillRide['TransportBillDetailRides']['nb_trucks'],
                                        'class' => 'form-control',
                                    )) . "</div>";
                            } else {
                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
                                        'label' => '',
                                        'placeholder' => __('Enter quantity'),
                                        'onchange' => 'javascript: calculatePriceRide(this.id);',
                                        'id' => 'nb_trucks' . $i,
                                        'value' => $transportBillRide['TransportBillDetailRides']['nb_trucks'],
                                        'class' => 'form-control',
                                    )) . "</div>";
                            }

                        }



                        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_ht', array(
                                'type' => 'hidden',
                                'readonly' => true,
                                'id' => 'price_ht' . $i,
                                'label' => '',
                                'value' => $transportBillRide['TransportBillDetailRides']['price_ht'],
                                'class' => 'form-control',
                            )) . "</div>";


                        echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.tva_id', array(
                                'label' => '',
                                'empty' => '',
                                'id' => 'tva' . $i,
                                'type' => 'hidden',
                                'value' => 1,
                                'options' => $tvas,
                                'value' => $transportBillRide['TransportBillDetailRides']['tva_id'],
                                'onchange' => 'javascript:getPriceRide(this.id);',
                                'class' => 'form-control',
                            )) . "</div>";


                        echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_ttc', array(
                                'readonly' => true,
                                'type' => 'hidden',
                                'label' => '',
                                'id' => 'price_ttc' . $i,
                                'value' => $transportBillRide['TransportBillDetailRides']['price_ttc'],
                                'class' => 'form-control',
                            )) . "</div>";

                        ?>
                    </td>
                    <td>

                        <?php

                        if (($transportBillRide['TransportBillDetailRides']['status_id'] != TransportBillDetailRideStatusesEnum::validated
                            && $transportBillRide['TransportBillDetailRides']['status_id'] = TransportBillDetailRideStatusesEnum:: partially_validated

                        )
                        ) {
                            ?>
                            <button name="remove" id="<?php echo $i ?>"
                                    onclick="removeRide('<?php echo $i ?>');"
                                    class="btn btn-danger btn_remove" style="margin-top: 10px;">
                                X
                            </button>
                        <?php } ?>

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

                <?php } else { ?>

                    <?php if ($paramPriceNight == 1) { ?>
                        <td>
                            <?php $options = array('1' => __('Day'), '2' => __('Night'));
                            echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_price', array(
                                    'label' => '',

                                    'id' => 'type_price' . $i,
                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                    'value' => $transportBillRide['TransportBillDetailRides']['type_price'],
                                    'options' => $options,
                                    'class' => 'form-control select-search',
                                )) . "</div>"; ?>
                        </td>
                    <?php } ?>
                    <td style="min-width: 130px;">
                        <?php

                        if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                            || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                        ) {

                            if($permissionEditInputLocked==0){
                                echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.unit_price', array(
                                        'label' => '',
                                        'readonly' => true,
                                        'id' => 'unit_price' . $i,
                                        'value' => $transportBillRide['TransportBillDetailRides']['unit_price'],
                                        'onchange' => 'javascript:calculatePriceRide(this.id);',
                                        'class' => 'form-control',
                                    )) . "</div>";
                            }else {
                                echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.unit_price', array(
                                        'label' => '',
                                        'id' => 'unit_price' . $i,
                                        'value' => $transportBillRide['TransportBillDetailRides']['unit_price'],
                                        'onchange' => 'javascript:calculatePriceRide(this.id);',
                                        'class' => 'form-control',
                                    )) . "</div>";
                            }


                        } else {
                            echo "<div id='div_unit_price$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.unit_price', array(
                                    'label' => '',
                                    //'readonly' => true,
                                    'id' => 'unit_price' . $i,
                                    'value' => $transportBillRide['TransportBillDetailRides']['unit_price'],
                                    'onchange' => 'javascript:calculatePriceRide(this.id);',
                                    'class' => 'form-control',
                                )) . "</div>";
                            $pricePmp = array('0' => 'PMP');
                            if (!empty($priceCategories)) {
                                $options = array_merge($pricePmp, $priceCategories);
                            } else {
                                $options = $priceCategories;
                            }

                            echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_category_id', array(
                                    'label' => '',
                                    'class' => 'form-control select3',
                                    'id' => 'price_category' . $i,
                                    'onchange' => 'javascript:getPriceProduct(this.id);',
                                    'options' => $options,
                                    'empty' => ''
                                )) . "</div>";
                        }
                        ?>
                    </td>
                    <td style="min-width: 100px;">
                        <?php

                        if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                            || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                        ) {

                            if($permissionEditInputLocked==0){
                                echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_%', array(
                                        'label' => '',
                                        'readonly' => true,
                                        'id' => 'ristourne' . $i,
                                        'value' => $transportBillRide['TransportBillDetailRides']['ristourne_%'],
                                        'onchange' => 'javascript:calculRistourneVal(this.id);',
                                        'class' => 'form-control',
                                    )) . "</div>";

                                echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_val', array(
                                        'label' => '',
                                        'readonly' => true,
                                        //'type' => 'hidden',
                                        'id' => 'ristourne_val' . $i,
                                        'value' => $transportBillRide['TransportBillDetailRides']['ristourne_val'],
                                        'onchange' => 'javascript:calculRistourne(this.id);',
                                        'class' => 'form-control',
                                    )) . "</div>";
                            }else {
                                echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_%', array(
                                        'label' => '',
                                        'id' => 'ristourne' . $i,
                                        'value' => $transportBillRide['TransportBillDetailRides']['ristourne_%'],
                                        'onchange' => 'javascript:calculRistourneVal(this.id);',
                                        'class' => 'form-control',
                                    )) . "</div>";

                                echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_val', array(
                                        'label' => '',
                                        'id' => 'ristourne_val' . $i,
                                        'value' => $transportBillRide['TransportBillDetailRides']['ristourne_val'],
                                        'onchange' => 'javascript:calculRistourne(this.id);',
                                        'class' => 'form-control',
                                    )) . "</div>";
                            }


                        } else {
                            echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_%', array(
                                    'label' => '',
                                    //'readonly' => true,
                                    'id' => 'ristourne' . $i,
                                    'value' => $transportBillRide['TransportBillDetailRides']['ristourne_%'],
                                    'onchange' => 'javascript:calculRistourneVal(this.id);',
                                    'class' => 'form-control',
                                )) . "</div>";

                            echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_val', array(
                                    'label' => '',
                                    //'readonly' => true,
                                    //'type' => 'hidden',
                                    'id' => 'ristourne_val' . $i,
                                    'value' => $transportBillRide['TransportBillDetailRides']['ristourne_val'],
                                    'onchange' => 'javascript:calculRistourne(this.id);',
                                    'class' => 'form-control',
                                )) . "</div>";
                        }

                        ?>
                    </td>
                    <?php


                    if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                        || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                    ) {
                        ?>
                        <td style="min-width: 130px;">
                            <?php
                            if($permissionEditInputLocked==0){
                                echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
                                        'placeholder' => __('Enter quantity'),
                                        'id' => 'nb_trucks' . $i,
                                        'label' => '',
                                        'value' => $transportBillRide['TransportBillDetailRides']['nb_trucks'],
                                        'readonly' => true,
                                        'onchange' => 'javascript:calculatePriceRide(this.id);',
                                        'class' => 'form-control',
                                    )) . "</div>";
                            }else {
                                if ($nbTrucksModifiable == 2) {
                                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
                                            'label' => '',
                                            'placeholder' => __('Enter quantity'),
                                            'onchange' => 'javascript: calculatePriceRide(this.id);',

                                            'readonly' => true,
                                            'id' => 'nb_trucks' . $i,
                                            'value' => $transportBillRide['TransportBillDetailRides']['nb_trucks'],
                                            'class' => 'form-control',
                                        )) . "</div>";
                                } else {
                                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
                                            'label' => '',
                                            'placeholder' => __('Enter quantity'),
                                            'onchange' => 'javascript: calculatePriceRide(this.id);',
                                            'id' => 'nb_trucks' . $i,
                                            'value' => $transportBillRide['TransportBillDetailRides']['nb_trucks'],
                                            'class' => 'form-control',
                                        )) . "</div>";
                                }
                            }


                            ?>
                        </td>

                    <?php } else { ?>
                        <td style="min-width: 130px;">
                            <?php
                            if ($nbTrucksModifiable == 2) {
                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
                                        'label' => '',
                                        'placeholder' => __('Enter quantity'),
                                        'onchange' => 'javascript: calculatePriceRide(this.id);',

                                        'readonly' => true,
                                        'id' => 'nb_trucks' . $i,
                                        'value' => $transportBillRide['TransportBillDetailRides']['nb_trucks'],
                                        'class' => 'form-control',
                                    )) . "</div>";
                            } else {
                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
                                        'label' => '',
                                        'placeholder' => __('Enter quantity'),
                                        'onchange' => 'javascript: calculatePriceRide(this.id);',
                                        'id' => 'nb_trucks' . $i,
                                        'value' => $transportBillRide['TransportBillDetailRides']['nb_trucks'],
                                        'class' => 'form-control',
                                    )) . "</div>";
                            }

                            ?>


                        </td>

                    <?php } ?>


                    <td style="min-width: 130px;">
                        <?php

                        if($permissionEditInputLocked==0){
                            echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_ht', array(

                                    'readonly' => true,
                                    'id' => 'price_ht' . $i,
                                    'label' => '',
                                    'value' => $transportBillRide['TransportBillDetailRides']['price_ht'],
                                    'class' => 'form-control',
                                )) . "</div>";
                        }else {
                            echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_ht', array(

                                    'id' => 'price_ht' . $i,
                                    'label' => '',
                                    'value' => $transportBillRide['TransportBillDetailRides']['price_ht'],
                                    'class' => 'form-control',
                                )) . "</div>";
                        }


                        ?>
                    </td>
                    <td style="min-width: 50px;">
                        <?php
                        if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                            || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                        ) {

                            if($permissionEditInputLocked==0){
                                echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.tva_id', array(
                                        'label' => '',
                                        'empty' => '',
                                        'id' => 'tva' . $i,
                                        'disabled' => true,
                                        'options' => $tvas,
                                        'value' => $transportBillRide['TransportBillDetailRides']['tva_id'],
                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                        'class' => 'form-control',
                                    )) . "</div>";

                                echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.tva_id', array(
                                        'label' => '',
                                        'empty' => '',
                                        'id' => 'tva' . $i,
                                        'type' => 'hidden',
                                        'options' => $tvas,
                                        'value' => $transportBillRide['TransportBillDetailRides']['tva_id'],
                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                        'class' => 'form-control',
                                    )) . "</div>";

                            }else {
                                echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.tva_id', array(
                                        'label' => '',
                                        'options' => $tvas,
                                        'id' => 'tva' . $i,
                                        'onchange' => 'javascript:calculatePriceRide(this.id);',
                                        'value' => $transportBillRide['TransportBillDetailRides']['tva_id'],
                                        'class' => 'form-control ',
                                    )) . "</div>";
                            }


                        } else {
                            echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.tva_id', array(
                                    'label' => '',
                                    'options' => $tvas,
                                    'id' => 'tva' . $i,
                                    'onchange' => 'javascript:calculatePriceRide(this.id);',
                                    'value' => $transportBillRide['TransportBillDetailRides']['tva_id'],
                                    'class' => 'form-control ',
                                )) . "</div>";
                        }
                        ?>
                    </td>
                    <td style="min-width: 130px;">
                        <?php

                        if($permissionEditInputLocked==0){
                            echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_ttc', array(
                                    'readonly' => true,
                                    'label' => '',
                                    'id' => 'price_ttc' . $i,
                                    'value' => $transportBillRide['TransportBillDetailRides']['price_ttc'],
                                    'class' => 'form-control',
                                )) . "</div>";
                        }else {
                            echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_ttc', array(

                                    'label' => '',
                                    'id' => 'price_ttc' . $i,
                                    'value' => $transportBillRide['TransportBillDetailRides']['price_ttc'],
                                    'class' => 'form-control',
                                )) . "</div>";
                        }



                        ?>
                    </td>

                    <td style="min-width: 150px;">
                        <?php
                        echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.observation_order',
                                array(
                                    'label' => '',
                                    'id' => 'observation'. $i,
                                    'value' => $transportBillRide['TransportBillDetailRides']['observation_order'],
                                    'class' => 'form-control',
                                )) . "</div>";
                        ?>
                    </td>
                    <td>
                        <?php
                        echo "<div id='status-div$i' >";
                        if($transportBillRide['ProductType']['relation_with_park']==1
                            ||$type !=TransportBillTypesEnum:: order){
                            echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.status_id',
                                    array(
                                        'id' => 'status'.$i,
                                        'type' => 'hidden',
                                        'value' => $transportBillRide['TransportBillDetailRides']['status_id'],
                                    )) . "</div>";
                            switch ($transportBillRide['TransportBillDetailRides']['status_id']) {

                                /*
                                1: commandes non validées
                                2: commandes partiellement validées
                                3: commandes validées
                                4: commandes préfacturées.
                                7: commandes facturées.
                                */
                                case StatusEnum::quotation:
                                    echo '<span class="label label-info position-status">';
                                    echo __('Quotation') . "</span>";
                                    break;
                                case StatusEnum::not_validated:
                                    echo '<span class="label label-danger position-status">';
                                    echo __('Not validated') . "</span>";
                                    break;
                                case StatusEnum::partially_validated:
                                    echo '<span class="label label-warning position-status">';
                                    echo __('Partially validated') . "</span>";
                                    break;
                                case StatusEnum::validated:
                                    echo '<span class="label label-success position-status">';
                                    echo __('Validated') . "</span>";
                                    break;
                                case StatusEnum::mission_pre_invoiced:
                                    echo '<span class="label label-primary position-status">';
                                    echo __('Preinvoiced') . "</span>";
                                    break;
                                case StatusEnum::mission_invoiced:
                                    echo '<span class="label btn-inverse position-status">';
                                    echo __('Invoiced') . "</span>";
                                    break;
                                case StatusEnum::not_transmitted:
                                    echo '<span class="label btn-primary position-status">';
                                    echo __('Not transmitted') . "</span>";
                                    break;

                                case StatusEnum::canceled:
                                    echo '<span class="label btn-inverse position-status">';
                                    echo __('Canceled') . "</span>";
                                    break;
                                case StatusEnum::credit_note:
                                    echo '<span class="label btn-inverse position-status">';
                                    echo __('Credit note') . "</span>";
                                    break;



                            }

                        }else {

                            $statuses = array('1'=>__('Not validated'),'3'=>__('Validated'));
                            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.status_id',
                                    array(
                                        'options'=>$statuses,
                                        'class' => 'form-control select-search',
                                        'id' => 'status'.$i,
                                        'value' => $transportBillRide['TransportBillDetailRides']['status_id'],
                                    )) . "</div>";

                        }


                        echo "</div>";

                        if (($transportBillRide['TransportBillDetailRides']['status_id'] != TransportBillDetailRideStatusesEnum::validated
                            && $transportBillRide['TransportBillDetailRides']['status_id'] = TransportBillDetailRideStatusesEnum:: partially_validated

                        )
                        ) {
                            ?>


                            <?php

                            echo "<div class='hidden' id ='description-div$i'>" . $this->Tinymce->input('TransportBillDetailRides.'.$i.'.description',
                                    array(
                                        //'id' => 'description'.$i,
                                        'value'=> $transportBillRide['TransportBillDetailRides']['description']
                                    )) . "</div>";
                            ?>&nbsp;
                            <div class="btn-group quick-actions">
                                <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#" class="btn editDescription"  id="editDescription<?php echo $i;?>" onclick="editDescription(this.id);" title="Edit description">
                                            <i class="fa fa-edit m-r-5"></i><?= __("Edit description") ?>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="btn" title="Delete" id="<?php echo $i ?>" onclick="removeRide('<?php echo $i ?>');"">
                                        <i class="fa fa-trash-o m-r-5"></i><?= __("Delete") ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        <?php } ?>

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


            </tr>


            <?php $i++;
        }
    } ?>

    </tbody>

</table>