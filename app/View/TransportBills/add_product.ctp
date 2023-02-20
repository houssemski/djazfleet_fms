<?php if ($reference == '0') { ?>
    <td> <?php
        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.reference', array(
                'label' => '',
                'class' => 'form-control ',
                'id' => 'reference' . $i,
            )) . "</div>";
        ?>
    </td>
<?php } ?>

<?php if ($profileId == ProfilesEnum::client
    && $type == TransportBillTypesEnum::order
) {
    ?>
    <td class="col-sm-3">
        <?php  echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                'label' => '',
                'class' => 'form-control select-search',
                'id' => 'product' . $i,
                'onchange' => 'javascript:getInformationProduct(this.id);',
                'value'=>1,
            )) . "</div>";
        echo "<div id='type-ride-div$i'>";

        if($typeRide ==3){
            $options = array('1'=>__('Existing ride'),'2'=>__('Personalized ride') );
            echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                    'id' => 'type_ride'.$i,
                    'options'=>$options,
                    'label'=>false,
                    'class'=>'form-control select-search',
                    'onchange' => 'javascript:getInformationProduct(this.id);',
                    'value' => $typeRideUsedFirst,
                )) . "</div>";

        } else {
            echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                    'id' => 'type_ride'.$i,
                    'type' => 'hidden',
                    'value' => $typeRideUsedFirst,
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
<?php } else { ?>
    <td class="col-sm-1">
        <?php  echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                'label' => '',
                'class' => 'form-control select-search',
                'id' => 'product' . $i,
                'onchange' => 'javascript:getInformationProduct(this.id);',
                'value'=>1,
            )) . "</div>";
        echo "<div id='type-ride-div$i'>";
        if($typeRide ==3){
            $options = array('1'=>__('Existing ride'),'2'=>__('Personalized ride') );
            echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                    'id' => 'type_ride'.$i,
                    'options'=>$options,
                    'label'=>false,
                    'class'=>'form-control select-search',
                    'onchange' => 'javascript:getInformationProduct(this.id);',
                    'value' => $typeRideUsedFirst,
                )) . "</div>";

        } else {
            echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                    'id' => 'type_ride'.$i,
                    'type' => 'hidden',
                    'value' => $typeRideUsedFirst,
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

<?php } ?>
<?php
if ($profileId == ProfilesEnum::client
    && $type == TransportBillTypesEnum::order
) {

    if ($typeRideUsedFirst == 1) {
        ?>
        <td class="col-sm-3">
            <?php
            echo "<div id='div-product$i'>";
            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                    'label' => '',
                    'class' => 'form-control select-search-detail-ride',
                    'empty' => '',
                    'onchange' => 'javascript:getPriceRide(this.id);',
                    'id' => 'detail_ride'.$i,
                )) . "</div>";
            echo "</div>";
            ?>
        </td>

    <?php } else { ?>

        <td class="col-sm-3"><?php
            echo "<div id='div-product$i'>";
            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                    'label' => '',
                    'empty' => __('Departure city'),
                    'class' => 'form-control select-search-destination',
                    'onchange' => 'javascript:getPriceRide(this.id);',
                    'id' => 'departure_destination'.$i,
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                    'empty' => __('Type'),
                    'class' => 'form-control select-search',
                    'label' => '',
                    'onchange' => 'javascript:getPriceRide(this.id);',
                    'id' => 'car_type'.$i,
                )) . "</div>";
            echo "</div>";
            ?>
        </td>
    <?php } ?>

<?php
} else {

    if ($typeRideUsedFirst == 1) {
        ?>
        <td class="col-sm-1">
            <?php
            echo "<div id='div-product$i'>";
            echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                    'label' => '',
                    'class' => 'form-control select-search-detail-ride',
                    'empty' => '',
                    'onchange' => 'javascript:getPriceRide(this.id);',
                    'id' => 'detail_ride'.$i,
                )) . "</div>";
            echo "</div>";
            ?></td>

    <?php } else { ?>

        <td class="col-sm-1">
            <?php
            echo "<div id='div-product$i'>";
            echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                    'label' => '',
                    'empty' => __('Departure city'),
                    'class' => 'form-control select-search-destination',

                    'onchange' => 'javascript:getPriceRide(this.id);',
                    'id' => 'departure_destination'.$i,
                )) . "</div>";


            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                    'empty' => __('Type'),
                    'class' => 'form-control select-search',
                    'label' => '',
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
    if ($typeRideUsedFirst == 1) {
        ?>
        <td class="col-sm-3">
            <?php
            echo "<div class='form-group' id='supplier_final_div1'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                    'label' => '',
                    'empty' => __('Final customer'),
                    'id' => 'client_final'.$i,
                    'class' => 'form-control select-search-client-final',
                )) . "</div>";
            ?>
        </td>
    <?php } else { ?>

        <td class="col-sm-3">
            <?php
             if(Configure::read("gestion_programmation_sous_traitance") == '1'){
                 echo "<div class='form-group' id='div-arrival$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                         'empty' => __('Arrival city'),
                         'class' => 'form-control select-search-destination',
                         'label' => '',
                         'required'=>true,
                         'onchange' => 'javascript:getPriceRide(this.id);',
                         'id' => 'arrival_destination'.$i,
                     )) . "</div>";
             }else{
                 echo "<div class='form-group' id='div-arrival$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                         'empty' => __('Arrival city'),
                         'class' => 'form-control select-search-destination',
                         'label' => '',
                         'onchange' => 'javascript:getPriceRide(this.id);',
                         'id' => 'arrival_destination'.$i,
                     )) . "</div>";
             }



            echo "<div class='form-group' id='supplier_final_div1'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                    'empty' => __('Final customer'),
                    'label' => '',
                    'id' => 'client_final'.$i,
                    'class' => 'form-control select-search-client-final',
                )) . "</div>";
            ?>
        </td>

    <?php } ?>


<?php
} else {

    if ($typeRideUsedFirst == 1) {
        ?>
        <td class="col-sm-1">
            <?php
            echo "<div class='form-group form-tab' id='supplier_final_div1'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                    'empty' => __('Final customer'),
                    'label' => '',
                    'id' => 'client_final'.$i,
                    'class' => 'form-control select-search-client-final',
                )) . "</div>";
            ?>
        </td>

    <?php } else { ?>
        <td class="col-sm-1">
            <?php

            echo "<div class='form-group form-tab' id='div-arrival$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                    'empty' => __('Arrival city'),
                    'class' => 'form-control select-search-destination',
                    'label' => '',
                    'onchange' => 'javascript:getPriceRide(this.id);',
                    'id' => 'arrival_destination'.$i,
                )) . "</div>";
            echo "<div class='form-group' id='supplier_final_div1'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                    'empty' => __('Final customer'),
                    'label' => '',
                    'id' => 'client_final'.$i,
                    'class' => 'form-control select-search-client-final',
                )) . "</div>";
            ?>
        </td>

    <?php } ?>

<?php } ?>

<td style="min-width: 200px;">
    <?php

    if(Configure::read("gestion_programmation_sous_traitance") == '1'){
        if ($type == TransportBillTypesEnum::quote){
            echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.programming_date', array(
                    'label' => '',
                    'placeholder' => 'dd/mm/yyyy',
                    'type' => 'text',
                    'class' => 'form-control datemask',
                    'id' => 'programming_date'.$i,
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
                    'before' => '<div class="input-group "><label for="unloadingDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                    'after' => '</div>',
                )) . "</div>";
        }else{
            echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.programming_date', array(
                    'label' => '',
                    'required'=>true,
                    'placeholder' => 'dd/mm/yyyy',
                    'type' => 'text',
                    'class' => 'form-control datemask',
                    'id' => 'programming_date'.$i,
                    'before' => '<div class="input-group date "><label for="programmingDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                    'after' => '</div>',
                )) . "</div>";

            echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.charging_time', array(
                    'label' => '',
                    'placeholder' => __('Charging hour'),
                    'type' => 'text',
                    'required'=>'required',
                    'class' => 'form-control datemask',
                    'id' => 'charging_time'.$i,
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
                    'before' => '<div class="input-group "><label for="unloadingDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                    'after' => '</div>',
                )) . "</div>";
        }
    }else {

        echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.programming_date', array(
                'label' => '',
                'placeholder' => 'dd/mm/yyyy',
                'type' => 'text',
                'class' => 'form-control datemask',
                'id' => 'programming_date'.$i,
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
                'before' => '<div class="input-group "><label for="unloadingDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                'after' => '</div>',
            )) . "</div>";

    }


    ?>


</td>


<td>
        <?php
        echo "<div id ='div-designation$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.designation', array(
                'label' => '',
                'empty' => '',
                'id' => 'designation' . $i,
                'class' => 'form-control',
            )) . "</div>";
        ?>
    </td>

<td>
    <?php
    echo "<div id='delivery-return-div$i'>";
    $options = array('1' => __('Simple delivery'), '2' => __('Simple return'), '3' => __('Delivery / Return'));
    echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.delivery_with_return', array(
            'label' => '',
            'id' => 'delivery_with_return'.$i,
            'onchange' => 'javascript:getPriceRide(this.id);',
            'value' => 1,
            'options' => $options,
            'class' => 'form-control select-search',
        )) . "</div>";
    echo "</div>";
    echo "<div id='tonnage-div$i'>";
    if($typePricing == 2){
        echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.tonnage_id', array(
                'label' => '',
                'empty'=>__('Tonnage'),
                'id' => 'tonnage'.$i,
                'onchange' => 'javascript:getPriceRide(this.id);',
                'class' => 'form-control select-search',
            )) . "</div>";
    }
    echo "</div>";
    ?>
</td>

<?php if ($profileId == ProfilesEnum::client
    && $type == TransportBillTypesEnum::order
) {
    ?>
    <?php if ($paramPriceNight == 1) { ?>
        <td>

        </td>
    <?php } ?>
    <td style='min-width: 70px;'>
        <?php

        if ($nbTrucksModifiable == 2) {
            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks',
                    array(
                        'label' => '',
                        'placeholder' => __('Enter quantity'),
                        'onchange' => 'javascript: calculatePriceRide(this.id);',
                        'id' => 'nb_trucks' . $i,
                        'readonly' => true,
                        'value' => $defaultNbTrucks,
                        'class' => 'form-control',
                    )) . "</div>";
        } else {
            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks',
                    array(
                        'label' => '',
                        'placeholder' => __('Enter quantity'),
                        'onchange' => 'javascript: calculatePriceRide(this.id);',
                        'id' => 'nb_trucks'. $i,
                        'class' => 'form-control',
                    )) . "</div>";
        }



        echo "<div class='form-group' id='div_unit_price$i'  >" . $this->Form->input('TransportBillDetailRides.' . $i . '.unit_price', array(
                'label' => '',
                'class' => 'form-control',
                'id' => 'unit_price' . $i,
                'type' => 'hidden',
                'value' => 0,
                'onchange' => 'javascript:calculatePriceRide(this.id);',
                'empty' => ''
            )) . "</div>";
        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_%', array(
                'label' => '',
                'placeholder' => __('Ristourne (%)'),
                'id' => 'ristourne' . $i,
                'onchange' => 'javascript:calculRistourneVal(this.id);',
                'class' => 'form-control',
                'type' => 'hidden',
            )) . "</div>";
        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_val', array(
                'type' => 'number',
                'label' => '',
                'placeholder' => __('Ristourne'),
                'class' => 'form-control',
                'id' => 'ristourne_val' . $i,
                'type' => 'hidden',
                'onchange' => 'javascript:calculRistourne(this.id);',
            )) . "</div>";


        echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_ht', array(
                'label' => '',
                'class' => 'form-control',
                'id' => 'price_ht' . $i,
                'readonly' => true,
                'type' => 'hidden',
                'empty' => ''
            )) . "</div>";

        echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.tva_id', array(
                'label' => '',
                'class' => 'form-control',
                'id' => 'tva' . $i,
                'type' => 'hidden',
                'onchange' => 'javascript:calculatePriceRide(this.id);',
                'value' => 1
            )) . "</div>";


        echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_ttc', array(
                'label' => '',
                'class' => 'form-control',
                'id' => 'price_ttc' . $i,
                'readonly' => true,
                'type' => 'hidden',
                'empty' => ''
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

        ?>
    </td>


    <td>
        <?php
        echo "<div id='status-div$i' >";
        echo "<div class='hidden'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.status_id', array(
            'id' => 'status' . $i,
            'type' => 'number',
            'value' => $statusId,
            )) . "</div>";
         switch ($statusId) {
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

           case 8:
                echo '<span class="label btn-inverse position-status">';
                echo __('Credit note') . "</span>";
                break;

        }

        echo "</div>";
        ?>&nbsp;
        <br>
        <button name="remove" id="<?php echo $i ?>" onclick="removeRide('<?php echo $i ?>');"
                class="btn btn-danger btn_remove" style="margin-top: 10px; ">X
        </button>

    </td>

<?php } else { ?>

    <?php if ($paramPriceNight == 1) { ?>
        <td>

        </td>
    <?php } ?>
    <td style='min-width: 70px;'>
        <?php
        echo "<div class='form-group' id='div_unit_price$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.unit_price', array(
                'label' => '',
                'class' => 'form-control ',
                'id' => 'unit_price' . $i,
                 'onchange' => 'javascript:calculatePriceRide(this.id);',
                'empty' => ''
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
        ?>
        <span id='quantity_max<?php echo $i ?>'>
                                    </span>
                                     <span id='msg<?php echo $i ?>'>
                                    </span>


    </td>
    <td>
        <?php

        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_%', array(
                'label' => '',
                'placeholder' => __('Ristourne (%)'),
                'id' => 'ristourne' . $i,
                'onchange' => 'javascript:calculRistourneVal(this.id);',
                'class' => 'form-control',
            )) . "</div>";
        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_val', array(
                'type' => 'number',
                'label' => '',
                'placeholder' => __('Ristourne'),
                'class' => 'form-control',
                'id' => 'ristourne_val' . $i,
                'onchange' => 'javascript:calculRistourne(this.id);',
            )) . "</div>";
        ?>


    </td>

    <td style='min-width: 40px;'>
        <?php

        if ($nbTrucksModifiable == 2) {
            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks',
                    array(
                        'label' => '',
                        'placeholder' => __('Enter quantity'),
                        'onchange' => 'javascript: calculatePriceRide(this.id);',
                        'id' => 'nb_trucks' . $i,
                        'readonly' => true,
                        'value' => $defaultNbTrucks,
                        'class' => 'form-control',
                    )) . "</div>";
        } else {
            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks',
                    array(
                        'label' => '',
                        'placeholder' => __('Enter quantity'),
                        'onchange' => 'javascript: calculatePriceRide(this.id);',
                        'id' => 'nb_trucks'. $i,
                        'class' => 'form-control',
                    )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.marchandise_unit_id',
                    array(
                        'label' => '',
                        'empty' => true,
                        'placeholder' => __('Enter unit'),
                        'id' => 'nb_trucks_units_'. $i,
                        'options' => $marchandiseUnits,
                        'class' => 'form-control',
                    )) . "</div>";
        }
        ?>
    </td>

    <td style='min-width: 70px;'> <?php  echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_ht', array(
                'label' => '',
                'class' => 'form-control',
                'id' => 'price_ht' . $i,
                'readonly' => true,
                'empty' => ''
            )) . "</div>";
        ?>
    </td>
    <td style='min-width: 40px;'> <?php
        echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.tva_id', array(
                'label' => '',
                'class' => 'form-control',
                'id' => 'tva' . $i,
                'onchange' => 'javascript:calculatePriceRide(this.id);',
                'value' => 1
            )) . "</div>";?>
    </td>
    <td style='min-width: 70px;'> <?php
        echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_ttc', array(
                'label' => '',
                'class' => 'form-control',
                'id' => 'price_ttc' . $i,
                'readonly' => true,
                'empty' => ''
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

            case TransportBillTypesEnum::credit_note :
                $statusId = 10;
                break;
        }

        ?>


    </td>

    <td style="min-width: 150px;">
        <?php
        echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.observation',
                array(
                    'label' => '',
                    'id' => 'observation'. $i,
                    'class' => 'form-control',
                )) . "</div>";
        ?>
    </td>
    <td>

        <?php
        echo "<div id='status-div$i' >";
        echo "<div class='hidden'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.status_id', array(
                'id' => 'status' . $i,
                'type' => 'number',
                'value' => $statusId,
            )) . "</div>";
        switch ($statusId) {

            /*
            1: commandes en cours
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
        echo "</div>";
        ?>&nbsp;
        <br>

<?php

        echo "<div class='hidden' id ='description-div$i'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.description',
            array(
            'id' => 'description'.$i,
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


