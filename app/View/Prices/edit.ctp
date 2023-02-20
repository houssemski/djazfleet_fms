<?php

$this->start('css');
echo $this->Html->css('bootstrap-datetimepicker.min');
echo $this->Html->css('select2/select2.min');
$this->end();
?>
    <style>
        .select label {

            display: block;
        }

        .form-group {
            max-width: 800px !important;
        }
    </style>
<?php

?><h4 class="page-title"> <?= __('Edit price'); ?></h4>
    <div class="box">
        <div class="edit form card-box p-b-0">
            <?php echo $this->Form->create('Price', array('onsubmit' => 'javascript:disable();')); ?>
            <div class="box-body">
                <div class="nav-tabs-custom pdg_btm">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('Price') ?></a></li>
                        <li><a href="#tab_2" data-toggle="tab"><?= __('Promotion') ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">

                            <?php
                            echo $this->Form->input('id');
                            echo "<div class='form-group'>" . $this->Form->input('wording', array(
                                    'label' => __('Code'),
                                    'placeholder' => __('Enter code'),
                                    'class' => 'form-control',
                                    'error' => array('attributes' => array('escape' => false),
                                        'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                                            __("The code must be unique") . '</label></div>', true)
                                )) . "</div>";


                            echo "<div class='form-group'>" . $this->Form->input('supplier_category_id', array(
                                    'label' => __('Customer Category'),
                                    'empty' => '',
                                    'id' => 'category',
                                    'class' => 'form-control select-search',
                                )) . "</div>";
                            echo "<div class='form-group'>" . $this->Form->input('supplier_id', array(
                                    'label' => __('Client'),
                                    'empty' => '',
                                    'id' => 'supplier',
                                    'class' => 'form-control select-search-client-initial-category',
                                )) . "</div>";

                            echo "<div class='form-group'>" . $this->Form->input('service_id', array(
                                    'label' => __('Service'),
                                    'empty' => '',
                                    'id' => 'service',
                                    'class' => 'form-control select-search',
                                )) . "</div>";
                            ?>


                            <p class="p-radio" style="display: inline-block;width: 190px; font-weight: bold;"><?php echo __('Type of pricing') ?></p>
                            <input id='pricing_ride'
                                   onclick='javascript:getRides(this.id);'
                                   class="input-radio" type="radio"
                                   name="data[Price][type_pricing]"
                                   value="1" <?php if($this->request->data['Price']['type_pricing']==1) {?>checked='checked' <?php } ?>>
                            <span class="label-radio"><?php echo __('Pricing by ride') ?></span>
                            <input id='source_distance'
                                   onclick='javascript:getTonnages(this.id);'
                                   class="input-radio" type="radio"
                                   name="data[Price][type_pricing]"
                                   value="2" <?php if($this->request->data['Price']['type_pricing']==2) {?>checked='checked' <?php } ?>>
                            <span class="label-radio"> <?php echo __('Pricing by distance') ?></span>
                            <input id='source_distance'
                                   onclick='javascript:getOtherProducts(this.id);'
                                   class="input-radio" type="radio"
                                   name="data[Price][type_pricing]"
                                   value="3" <?php if($this->request->data['Price']['type_pricing']==3) {?>checked='checked' <?php } ?>>
                            <span class="label-radio"> <?php echo __('Other product') ?></span><br/><br/>


                            <?php
                            echo " <div id='ride-div'>";
                            switch ($this->request->data['Price']['type_pricing']){
                                case 1:
                                    echo "<div class='form-group'>" . $this->Form->input('detail_ride_id', array(
                                            'label' => __('Ride'),
                                            'empty' => '',
                                            'class' => 'form-control select-search-detail-ride',
                                        )) . "</div>";
                                    break;
                                case 2 :
                                    echo "<div class='form-group' >" . $this->Form->input('km_from', array(
                                            'label' => __('Km from'),
                                            'placeholder' => __(''),
                                            'onchange' => 'javascript: getPrice();',
                                            'id' => 'km_from',
                                            'class' => 'form-control',
                                        )) . "</div>";

                                    echo "<div class='form-group' >" . $this->Form->input('km_to', array(
                                            'label' => __('Km to'),
                                            'placeholder' => __(''),
                                            'onchange' => 'javascript: getPrice();',
                                            'id' => 'km_to',
                                            'class' => 'form-control',
                                        )) . "</div>";
                                    echo " <div class='form-group'>" . $this->Form->input('tonnage_id', array(
                                            'label' => __('Tonnage'),
                                            'empty' => __('Select tonnage'),
                                            'id' => 'tonnage',
                                            'onchange' => 'javascript:getPrice();',
                                            'class' => 'form-control select-search',
                                        )) . "</div>";
                                    break ;
                                case 3 :
                                    echo "<div class='form-group' >" . $this->Form->input('ProductPrice.product_id', array(
                                            'label' => __('Product'),
                                            'empty' => __('Select product'),
                                            'id' => 'product',
                                            'value'=>$productPrice['ProductPrice']['product_id'],
                                            'class' => 'form-control select-search',
                                            'onchange' => 'javascript: getFactors();',
                                        )) . "</div>";

                                    echo "<div id='factor-div'>";

                                    if(!empty($productPriceFactors)){
                                        $j =1 ;
                                        foreach ($productPriceFactors as $productPriceFactor){

                                            echo "<div class='form-group' >" . $this->Form->input('ProductPriceFactor.' . $j . '.id', array(
                                                    'value' => $productPriceFactor['ProductPriceFactor']['id'],
                                                    'class' => 'form-control',
                                                    'type'=>'hidden'
                                                )) . "</div>";
                                            echo "<div class='form-group' >" . $this->Form->input('ProductPriceFactor.' . $j . '.factor_id', array(
                                                    'value' => $productPriceFactor['ProductPriceFactor']['factor_id'],
                                                    'class' => 'form-control',
                                                    'type'=>'hidden'
                                                )) . "</div>";
                                            echo "<div class='form-group' >" . $this->Form->input('ProductPriceFactor.' . $j. '.factor_value', array(
                                                    'label' => $productPriceFactor['Factor']['name'],
                                                    'value' => $productPriceFactor['ProductPriceFactor']['factor_value'],
                                                    'class' => 'form-control',
                                                    'type'=>'integer'
                                                )) . "</div>";
                                            $j ++;
                                        }
                                    }
                                    if(!empty($factors)){
                                        foreach ($factors as $factor){

                                            echo "<div class='form-group' >" . $this->Form->input('ProductPriceFactor.' . $j . '.factor_id', array(
                                                    'value' => $factor['Factor']['id'],
                                                    'class' => 'form-control',
                                                    'type'=>'hidden'
                                                )) . "</div>";
                                            echo "<div class='form-group' >" . $this->Form->input('ProductPriceFactor.' . $j. '.factor_value', array(
                                                    'label' => $factor['Factor']['name'],
                                                    'class' => 'form-control',
                                                    'type'=>'integer'
                                                )) . "</div>";
                                            $j ++;
                                        }
                                    }

                                    echo "</div>";
                                    break;
                            }


                            echo " </div>";
                            if($this->request->data['Price']['type_pricing']==3){
                                echo "<div id='price-div'>";

                                echo "<div class='form-group' >" . $this->Form->input('ProductPrice.id', array(

                                        'type' => 'hidden',
                                        'value'=>$productPrice['ProductPrice']['id'],
                                        'class' => 'form-control',
                                    )) . "</div>";

                                echo "<div class='form-group' >" . $this->Form->input('ProductPrice.price_ht', array(
                                        'label' => __('Price HT') ,
                                        'placeholder' => __('Entrer price HT'),
                                        'onchange' => 'javascript: calculatePriceReturn();',
                                        'id' => 'price_ht',
                                        'value'=>$productPrice['ProductPrice']['price_ht'],
                                        'class' => 'form-control',
                                    )) . "</div>";

                                echo "<div class='form-group'>" . $this->Form->input('ProductPrice.start_date', array(
                                        'label' => '',
                                        'placeholder' => 'dd/mm/yyyy',
                                        'type' => 'text',
                                        'class' => 'form-control datemask',
                                        'before' => '<label>' . __('Start date') . '</label><div class="input-group date" ><label for="PriceStartDate"></label><div class="input-group-addon">
                                        <i class="fa fa-calendar"></i></div>',
                                        'after' => '</div>',

                                        'value' => $this->Time->format($productPrice['ProductPrice']['start_date'], '%d-%m-%Y'),
                                        'id' => 'start_date'
                                    )) . "</div>";

                                echo "<div class='form-group'>" . $this->Form->input('ProductPrice.end_date', array(
                                        'label' => '',
                                        'placeholder' => 'dd/mm/yyyy',
                                        'type' => 'text',
                                        'class' => 'form-control datemask',
                                        'before' => '<label>' . __('End date') . '</label><div class="input-group date" ><label for="PriceEndDate"></label><div class="input-group-addon">
                                           <i class="fa fa-calendar"></i> </div>',
                                        'after' => '</div>',
                                        'value' => $this->Time->format($productPrice['ProductPrice']['end_date'], '%d-%m-%Y'),

                                        'id' => 'end_date'
                                    )) . "</div>";


                                echo "</div>";

                            }else {
                            if (!empty($priceRideCategories)) { ?>
                                <table style="width: 83%;" id='dynamic_field'>
                                    <?php
                                    $i = 0;
                                    echo "<div class='form-group'>" . $this->Form->input('nb_price', array(
                                            'label' => '',
                                            'id' => 'nb_price',
                                            'type' => 'hidden',
                                            'value' => $nbPriceRideCategories,
                                        )) . "</div>";
                                    foreach ($priceRideCategories as $priceRideCategory) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?php
                                                if ($useRideCategory == 2) {
                                                    echo "<div class='form-group'>" . $this->Form->input('PriceRideCategory.' . $i . '.ride_category_id', array(
                                                            'label' => __('Ride category'),
                                                            'empty' => '',
                                                            'id' => 'ride_category',
                                                            'onchange' => 'javascript:getPrice();',
                                                            'class' => 'form-control select-search',
                                                        )) . "</div>";

                                                }
                                                echo "<div class='form-group' >" . $this->Form->input('PriceRideCategory.' . $i . '.price_ht', array(
                                                        'label' => __('Price HT') . ' ' . __('Day'),
                                                        'placeholder' => __('Entrer price HT'),
                                                        'onchange' => 'javascript: calculatePriceReturn();',
                                                        'id' => 'price_ht',
                                                        'class' => 'form-control',
                                                    )) . "</div>";
                                                if ($paramPriceNight == 1) {
                                                    echo "<div class='form-group' >" . $this->Form->input('PriceRideCategory.' . $i . '.price_ht_night', array(
                                                            'label' => __('Price HT') . ' ' . __('Night'),
                                                            'placeholder' => __('Entrer price HT'),
                                                            'onchange' => 'javascript: calculatePriceReturn();',
                                                            'id' => 'price_ht_night',
                                                            'class' => 'form-control',
                                                        )) . "</div>";

                                                }
                                                echo "<div class='form-group'>" . $this->Form->input('PriceRideCategory.' . $i . '.pourcentage_price_return', array(
                                                        'label' => __('Pourcentage price return (%)'),
                                                        'placeholder' => __('Enter pourcentage price return'),
                                                        'onchange' => 'javascript: calculatePriceReturn();',
                                                        'id' => 'pourcentage',
                                                        'class' => 'form-control',
                                                    )) . "</div>";


                                                echo "<div class='form-group' >" . $this->Form->input('PriceRideCategory.' . $i . '.price_return', array(
                                                        'label' => __('Price return'),
                                                        'placeholder' => __('Enter price return'),
                                                        'onchange' => 'javascript: calculatePourcentage();',
                                                        'id' => 'price_return',
                                                        'class' => 'form-control',
                                                    )) . "</div>";

                                                echo "<div class='form-group' >" . $this->Form->input('PriceRideCategory.' . $i . '.theoretical_amount_charges', array(
                                                        'label' => __('Theoretical amount of charges'),
                                                        'placeholder' => __('Enter theoretical amount of charges'),
                                                        'id' => 'theoretical_amount_charges',
                                                        'class' => 'form-control',
                                                    )) . "</div>";

                                                echo "<div class='form-group'>" . $this->Form->input('PriceRideCategory.' . $i . '.start_date', array(
                                                        'label' => '',
                                                        'placeholder' => 'dd/mm/yyyy',
                                                        'type' => 'text',
                                                        'class' => 'form-control datemask',
                                                        'before' => '<label>' . __('Start date') . '</label><div class="input-group date" id="circulation_date"><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                                        'after' => '</div>',
                                                        'value' => $this->Time->format($this->request->data['PriceRideCategory'][$i]['start_date'], '%d-%m-%Y'),

                                                        'id' => 'start_date' . $i,
                                                    )) . "</div>";

                                                echo "<div class='form-group'>" . $this->Form->input('PriceRideCategory.' . $i . '.end_date', array(
                                                        'label' => '',
                                                        'placeholder' => 'dd/mm/yyyy',
                                                        'type' => 'text',
                                                        'class' => 'form-control datemask',
                                                        'before' => '<label>' . __('End date') . '</label><div class="input-group date" id="circulation_date"><label for="PriceEndDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                                        'after' => '</div>',
                                                        'id' => 'end_date' . $i,
                                                        'value' => $this->Time->format($this->request->data['PriceRideCategory'][$i]['end_date'], '%d-%m-%Y'),

                                                    )) . "</div>";


                                                ?>
                                            </td>
                                            <?php

                                            if ($useRideCategory == 2) {
                                                if ($i == 0) {
                                                    ?>
                                                    <td class="td_tab">
                                                        <button style="margin-left: 40px;" type='button' name='add'
                                                                onclick='addDivPrice()'
                                                                class='btn btn-success'><?= __('Add more') ?></button>
                                                    </td>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tr>
                                        <?php
                                        $i++;
                                    } ?>
                                </table>

                                <?php
                            } else {
                                $i = 0;
                                ?>
                                <table style="width: 83%;" id='dynamic_field'>
                                    <tr>
                                        <td>

                                            <?php
                                            if ($useRideCategory == 2) {

                                                echo "<div class='form-group'>" . $this->Form->input('PriceRideCategory.' . $i . '.ride_category_id', array(
                                                        'label' => __('Ride category'),
                                                        'empty' => '',

                                                        'id' => 'ride_category',
                                                        'onchange' => 'javascript:getPrice();',
                                                        'class' => 'form-control select-search',
                                                    )) . "</div>";
                                            }

                                            echo "<div id='price-div'>";
                                            echo "<div class='form-group' >" . $this->Form->input('PriceRideCategory.' . $i . '.price_ht', array(
                                                    'label' => __('Price HT'),
                                                    'placeholder' => __('Entrer price HT'),
                                                    'onchange' => 'javascript: calculatePriceReturn();',
                                                    'id' => 'price_ht',
                                                    'class' => 'form-control',
                                                )) . "</div>";

                                            echo "<div class='form-group' >" . $this->Form->input('PriceRideCategory.' . $i . '.price_ht_night', array(
                                                    'label' => __('Price HT') . ' ' . __('Night'),
                                                    'placeholder' => __('Entrer price HT'),
                                                    // 'onchange' => 'javascript: calculatePriceReturn();',
                                                    'id' => 'price_ht_night',
                                                    'class' => 'form-control',
                                                )) . "</div>";


                                            echo "<div class='form-group'>" . $this->Form->input('PriceRideCategory.' . $i . '.pourcentage_price_return', array(
                                                    'label' => __('Pourcentage price return (%)'),
                                                    'placeholder' => __('Enter pourcentage price return'),
                                                    'onchange' => 'javascript: calculatePriceReturn();',
                                                    'id' => 'pourcentage',
                                                    'class' => 'form-control',
                                                )) . "</div>";

                                            echo "<div class='form-group' >" . $this->Form->input('PriceRideCategory.' . $i . '.price_return', array(
                                                    'label' => __('Price return'),
                                                    'placeholder' => __('Enter price return'),
                                                    'onchange' => 'javascript: calculatePourcentage();',
                                                    'id' => 'price_return',
                                                    'class' => 'form-control',
                                                )) . "</div>";

                                            echo "<div class='form-group' >" . $this->Form->input('PriceRideCategory.' . $i . '.theoretical_amount_charges', array(
                                                    'label' => __('Theoretical amount of charges'),
                                                    'placeholder' => __('Enter theoretical amount of charges'),
                                                    'id' => 'theoretical_amount_charges',
                                                    'class' => 'form-control',
                                                )) . "</div>";
                                            echo "<div class='form-group'>" . $this->Form->input('PriceRideCategory.' . $i . '.start_date', array(
                                                    'label' => '',
                                                    'placeholder' => 'dd/mm/yyyy',
                                                    'type' => 'text',
                                                    'class' => 'form-control datemask',
                                                    'before' => '<label>' . __('Start date') . '</label><div class="input-group date" id="circulation_date"><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                                                    'after' => '</div>',
                                                    'id' => 'start_date' . $i,
                                                )) . "</div>";

                                            echo "<div class='form-group'>" . $this->Form->input('PriceRideCategory.' . $i . '.end_date', array(
                                                    'label' => '',
                                                    'placeholder' => 'dd/mm/yyyy',
                                                    'type' => 'text',
                                                    'class' => 'form-control datemask',
                                                    'before' => '<label>' . __('End date') . '</label><div class="input-group date" id="circulation_date"><label for="PriceEndDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                                    'after' => '</div>',
                                                    'id' => 'end_date' . $i,
                                                )) . "</div>";


                                            echo "</div >"; ?>

                                        </td>
                                        <td class="td_tab">
                                            <button style="margin-left: 40px;" type='button' name='add'
                                                    onclick='addDivPrice()'
                                                    class='btn btn-success'><?= __('Add more') ?></button>
                                        </td>
                                    </tr>
                                </table>
                            <?php }
                            } ?>



                        </div>

                        <div class="tab-pane" id="tab_2">
                            <?php
                            if (!empty($promotions)) {
                                ?>
                                <table style="width: 83%;" id='dynamic_field2'>
                                    <?php
                                    $j = 0;

                                    foreach ($promotions as $promotion) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?php
                                                echo "<div class='form-group'>" . $this->Form->input('Promotion.' . $j . '.id', array(
                                                        'type' => 'hidden',
                                                        'value' => $promotion['Promotion']['id'],
                                                    )) . "</div>";

                                                echo "<div class='form-group'>" . $this->Form->input('Promotion.' . $j . '.promotion_pourcentage', array(
                                                        'label' => __('Promotion %'),
                                                        'placeholder' => __('Enter value'),
                                                        'class' => 'form-control',
                                                        'type' => 'number',
                                                        'id' => 'promotion_pourcentage' . $j,
                                                        'onchange' => 'javascript :getPromotionVal(' . $j . '); ',
                                                        'value' => $promotion['Promotion']['promotion_pourcentage'],
                                                    )) . "</div>";

                                                echo "<div class='form-group'>" . $this->Form->input('Promotion.' . $j . '.promotion_val', array(
                                                        'label' => __('Promotion valeur'),
                                                        'placeholder' => __('Enter value'),
                                                        'class' => 'form-control',
                                                        'type' => 'number',
                                                        'step' => 'any',
                                                        'id' => 'promotion_val' . $j,
                                                        'onchange' => 'javascript :getPromotionVal(' . $j . '); ',
                                                        'value' => $promotion['Promotion']['promotion_val'],
                                                    )) . "</div>";

                                                echo "<div class='form-group'>" . $this->Form->input('Promotion.' . $j . '.promotion_return', array(
                                                        'label' => __('Promotion retour'),
                                                        'placeholder' => __('Enter value'),
                                                        'class' => 'form-control',
                                                        'type' => 'number',
                                                        'step' => 'any',
                                                        'id' => 'promotion_return' . $j,
                                                        'onchange' => 'javascript :getPromotionVal(' . $j . '); ',
                                                    )) . "</div>";


                                                echo "<div class='form-group'>" . $this->Form->input('Promotion.' . $j . '.start_date', array(
                                                        'label' => '',
                                                        'placeholder' => 'dd/mm/yyyy',
                                                        'type' => 'text',
                                                        'class' => 'form-control datemask',
                                                        'before' => '<label>' . __('Start date') . '</label><div class="input-group date" ><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                                        'after' => '</div>',
                                                        'value' => $this->Time->format($promotion['Promotion']['start_date'], '%d-%m-%Y'),
                                                        'id' => 'start_date_promotion' . $j,
                                                    )) . "</div>";

                                                echo "<div class='form-group'>" . $this->Form->input('Promotion.' . $j . '.end_date', array(
                                                        'label' => '',
                                                        'placeholder' => 'dd/mm/yyyy',
                                                        'type' => 'text',
                                                        'class' => 'form-control datemask',
                                                        'before' => '<label>' . __('End date') . '</label><div class="input-group date" ><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                                        'after' => '</div>',
                                                        'value' => $this->Time->format($promotion['Promotion']['end_date'], '%d-%m-%Y'),
                                                        'id' => 'end_date_promotion' . $j,
                                                    )) . "</div>";

                                                $j++; ?>
                                            </td>
                                            <?php


                                            if ($j == 1) {
                                                ?>
                                                <td class="td_tab">
                                                    <button style="margin-left: 40px;" type='button' name='add'
                                                            onclick='addPromotion()'
                                                            class='btn btn-success'><?= __('Add more') ?></button>
                                                </td>
                                            <?php
                                            }

                                            ?>
                                        </tr>
                                    <?php

                                    }
                                    echo "<div class='form-group'>" . $this->Form->input('nb_promotion', array(
                                            'label' => '',
                                            'id' => 'nb_promotion',
                                            'type' => 'hidden',
                                            'value' => $j - 1,
                                        )) . "</div>";


                                    ?>
                                </table>



                            <?php } else { ?>


                                <?php
                                $j = 0;
                                echo "<div class='form-group'>" . $this->Form->input('nb_promotion', array(
                                        'label' => '',
                                        'id' => 'nb_promotion',
                                        'type' => 'hidden',
                                        'value' => 0,
                                    )) . "</div>";

                                ?>
                                <table style="width: 83%;" id='dynamic_field2'>
                                    <tr>
                                        <td>
                                            <?php
                                            echo "<div class='form-group'>" . $this->Form->input('Promotion.' . $j . '.promotion_pourcentage', array(
                                                    'label' => __('Promotion %'),
                                                    'placeholder' => __('Enter value'),
                                                    'class' => 'form-control',
                                                    'type' => 'number',
                                                    'id' => 'promotion_pourcentage' . $j,
                                                    'onchange' => 'javascript :getPromotionVal(' . $j . '); ',
                                                )) . "</div>";

                                            echo "<div class='form-group'>" . $this->Form->input('Promotion.' . $j . '.promotion_val', array(
                                                    'label' => __('Promotion valeur'),
                                                    'placeholder' => __('Enter value'),
                                                    'class' => 'form-control',
                                                    'type' => 'number',
                                                    'id' => 'promotion_val' . $j,
                                                    'onchange' => 'javascript :getPromotionVal(' . $j . '); ',
                                                )) . "</div>";

                                            echo "<div class='form-group'>" . $this->Form->input('Promotion.' . $j . '.promotion_return', array(
                                                    'label' => __('Promotion retour'),
                                                    'placeholder' => __('Enter value'),
                                                    'class' => 'form-control',
                                                    'type' => 'number',
                                                    'id' => 'promotion_return' . $j,
                                                    'onchange' => 'javascript :getPromotionVal(' . $j . '); ',
                                                )) . "</div>";

                                            echo "<div class='form-group'>" . $this->Form->input('Promotion.' . $j . '.start_date', array(
                                                    'label' => '',
                                                    'placeholder' => 'dd/mm/yyyy',
                                                    'type' => 'text',
                                                    'class' => 'form-control datemask',
                                                    'before' => '<label>' . __('Start date') . '</label><div class="input-group date" ><label for="PromotionStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                                    'after' => '</div>',
                                                    'id' => 'start_date_promotion' . $j,
                                                )) . "</div>";

                                            echo "<div class='form-group'>" . $this->Form->input('Promotion.' . $j . '.end_date', array(
                                                    'label' => '',
                                                    'placeholder' => 'dd/mm/yyyy',
                                                    'type' => 'text',
                                                    'class' => 'form-control datemask',
                                                    'before' => '<label>' . __('End date') . '</label><div class="input-group date" ><label for="PromotionStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                                    'after' => '</div>',
                                                    'id' => 'end_date_promotion' . $j,
                                                )) . "</div>";
                                            ?>

                                        </td>

                                        <td class="td_tab">
                                            <button style="margin-left: 40px;" type='button' name='add'
                                                    onclick='addPromotion()'
                                                    class='btn btn-success'><?= __('Add more') ?></button>
                                        </td>

                                    </tr>
                                </table>







                            <?php
                            }

                            ?>


                        </div>


                    </div>

                </div>

            </div>

            <div class="box-footer">
                <?php echo $this->Form->submit(__('Submit'), array(
                    'name' => 'ok',
                    'class' => 'btn btn-primary btn-bordred  m-b-5',
                    'label' => __('Submit'),
                    'type' => 'submit',
                    'id' => 'boutonValider',
                    'div' => false
                )); ?>
                <?php echo $this->Form->submit(__('Cancel'), array(
                    'name' => 'cancel',
                    'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                    'label' => __('Cancel'),
                    'type' => 'submit',
                    'div' => false,
                    'formnovalidate' => true
                )); ?>
            </div>
        </div>

    </div>
<?php $this->start('script'); ?>
    <!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
<?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('plugins/datetimepicker/moment-with-locales.min.js'); ?>
<?= $this->Html->script('plugins/datetimepicker/bootstrap-datetimepicker.min.js'); ?>
<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>
    <script type="text/javascript">

        $(document).ready(function () {
            jQuery("#start_date0").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            jQuery("#end_date0").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            jQuery("#start_date_promotion1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            jQuery("#end_date_promotion1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            jQuery("#start_date_promotion0").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            jQuery("#end_date_promotion0").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            /*jQuery('#category').change(function () {
             if (jQuery(this).val()) {
             jQuery('#supplier-div').load('
             echo $this->Html->url('/prices/getSuppliersByCategory/')?>' + jQuery(this).val());
             }


             });*/


        });

        function getPromotionVal(id) {

            var promotionVal = jQuery('#promotion_val' + '' + id + '').val();
            var promotionPourcentage = jQuery('#promotion_pourcentage' + '' + id + '').val();
            var priceHt = jQuery('#price_ht').val();
            var priceReturn = jQuery('#price_return').val();

            if ((priceHt > 0) && (promotionPourcentage > 0)) {
                promotionVal = (parseFloat(priceHt) * parseFloat(promotionPourcentage)) / 100;
                jQuery('#promotion_val' + '' + id + '').val(promotionVal);
                if (priceReturn > 0) {
                    promotionReturn = (parseFloat(priceReturn) * parseFloat(promotionPourcentage)) / 100;
                    jQuery('#promotion_return' + '' + id + '').val(promotionReturn);
                }
                jQuery('#promotion_val' + '' + id + '').parent('.input.number').addClass('required');
                jQuery("#promotion_val" + '' + id + '').attr('required', true);
                jQuery('#promotion_pourcentage' + '' + id + '').parent('.input.number').addClass('required');
                jQuery("#promotion_pourcentage" + '' + id + '').attr('required', true);
                jQuery("#start_date_promotion" + '' + id + '').parent().parent().attr('class', 'input text required');
                jQuery("#start_date_promotion" + '' + id + '').attr('required', true);
                jQuery("#end_date_promotion" + '' + id + '').parent().parent().attr('class', 'input text required');
                jQuery("#end_date_promotion" + '' + id + '').attr('required', true);

            }
        }


        function addDivPrice() {

            item = jQuery('#nb_price').val();
            jQuery('#dynamic_field').append('<tr id="row' + item + '"><td ></td></tr>');

            jQuery("#row" + '' + item + '').load('<?php echo $this->Html->url('/prices/getDivPrice/')?>' + item, function () {

            });
            item++;
            jQuery('#nb_price').val(item);
        }

        /**
         * ajouter un nouveau div de promotion
         */
        function addPromotion() {

            var item = jQuery('#nb_promotion').val();
            item++;
            jQuery('#dynamic_field2').append('<tr id="row' + item + '"><td ></td></tr>');
            jQuery("#row" + '' + item + '').load('<?php echo $this->Html->url('/prices/addPromotion/')?>' + item, function () {
                jQuery("#start_date_promotion" + '' + item + '').inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                jQuery("#end_date_promotion" + '' + item + '').inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            });

            jQuery('#nb_promotion').val(item);
        }

        function remove(id) {


            $('#row' + id + '').remove();


        }
        ;

        function calculatePriceReturn() {
            if (jQuery('#price_ht').val() > 0 && jQuery('#pourcentage').val() > 0) {
                var pourcentageValue = (parseFloat(jQuery('#price_ht').val()) * parseFloat(jQuery('#pourcentage').val())) / 100;
                var priceReturn = pourcentageValue;
                priceReturn = priceReturn.toFixed(2);
                jQuery('#price_return').val(priceReturn);
            }

        }

        function calculatePourcentage() {

            if (jQuery('#price_ht').val() > 0 && jQuery('#price_return').val() > 0) {
                var pourcentageValue = parseFloat(jQuery('#price_ht').val()) - parseFloat(jQuery('#price_return').val());
                var pourcentage = ( parseFloat(pourcentageValue) * 100 ) / parseFloat(jQuery('#price_ht').val());
                pourcentage = pourcentage.toFixed(2);
                jQuery('#pourcentage').val(pourcentage);
            }

        }

        function getTonnages(){
            jQuery("#ride-div").load('<?php echo $this->Html->url('/prices/getTonnages/')?>' , function () {
                $(".select-search").select2({
                    sorter: function (data) {
                        /* Sort data using lowercase comparison */
                        return data.sort(function (a, b) {
                            a = a.text.toLowerCase();
                            b = b.text.toLowerCase();
                            if (a > b) {
                                return 1;
                            } else if (a < b) {
                                return -1;
                            }
                            return 0;
                        });
                    },
                    allowDuplicates: true

                });
            });
        }

        function getOtherProducts(){
            jQuery("#ride-div").load('<?php echo $this->Html->url('/prices/getOtherProducts/')?>' , function () {
                $(".select-search").select2({
                    sorter: function (data) {
                        /* Sort data using lowercase comparison */
                        return data.sort(function (a, b) {
                            a = a.text.toLowerCase();
                            b = b.text.toLowerCase();
                            if (a > b) {
                                return 1;
                            } else if (a < b) {
                                return -1;
                            }
                            return 0;
                        });
                    },
                    allowDuplicates: true

                });
            });
            jQuery("#price-div").load('<?php echo $this->Html->url('/prices/getUnitPriceDiv/')?>' , function () {

            });

        }

        function getFactors (){

            var productId = jQuery('#product').val();

            jQuery("#factor-div").load('<?php echo $this->Html->url('/prices/getFactors/')?>'+productId , function () {
                $(".select-search").select2({
                    sorter: function (data) {
                        /* Sort data using lowercase comparison */
                        return data.sort(function (a, b) {
                            a = a.text.toLowerCase();
                            b = b.text.toLowerCase();
                            if (a > b) {
                                return 1;
                            } else if (a < b) {
                                return -1;
                            }
                            return 0;
                        });
                    },
                    allowDuplicates: true

                });
            });
        }

        function getRides(){
            jQuery("#ride-div").load('<?php echo $this->Html->url('/prices/getRides/')?>' , function () {
                $('.select-search-detail-ride').select2({
                    ajax: {
                        url: "<?php echo $this->Html->url('/detailRides/getDetailRidesByKeyWord')?>",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: $.trim(params.term)
                            };
                        },
                        processResults: function (data, page) {
                            return {results: data};
                        },
                        cache: true
                    },
                    minimumInputLength: 3

                });
            });
        }


    </script>

<?php $this->end(); ?>