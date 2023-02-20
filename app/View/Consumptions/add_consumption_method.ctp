<?php
if(isset($typeConsumption)){
    switch ($typeConsumption) {
        case ConsumptionTypesEnum::coupon :
            ?>
            <div id='coupon_div'>

                <?php if ($selectingCouponsMethod == 1) { ?>
                    <div id='consump_coupon' class="col-sm-2 consumption">
                        <?php    echo "<div class='col-sm-3'>" . $this->Form->input('Consumption.nb_coupon', array(
                                'label' => __('Nb coupons'),
                                'type' => 'number',
                                'class' => 'form-control ',
                                'id' => 'coupons',
                                'onchange' => 'javascript:couponsToSelect() ;'

                            )) . "</div>"; ?>

                        <span id='con_coupon'> </span>
                    </div>
                    <?php
                    echo "<div  id='coupon-div'></div>";
                } else {
                    ?>
                    <div id='consump_coupon' class="col-sm-2 consumption">
                        <?php    echo "<div class='col-sm-3'>" . $this->Form->input('Consumption.nb_coupon', array(
                                'label' => __('Nb coupons'),
                                'type' => 'number',
                                'class' => 'form-control',
                                'id' => 'coupons',
                                'onchange' => 'javascript:couponsSelectedFromFirstNumber();'

                            )) . "</div>"; ?>

                        <span id='con_coupon'> </span>
                    </div>
                    <?php
                    echo "<div id='number_coupon_div' style='padding-left: 35px;' class='consumption'>";
                    echo "<div class='col-sm-2'>" . $this->Form->input('Consumption.first_number_coupon', array(
                            'label' => __('From'),
                            'class' => 'form-control',
                            'id' => 'first_number_coupon',
                            'onchange' => 'javascript:couponsSelectedFromFirstNumber(this.id);'
                        )) . "</div>";

                    echo "<div class='col-sm-2 consumption'>" . $this->Form->input('Consumption.last_number_coupon', array(
                            'label' => __('To'),
                            'readonly' => true,
                            'class' => 'form-control',
                            'id' => 'last_number_coupon',
                        )) . "</div>";
                    echo "</div>";


                }?>

            </div>
            <?php
            break;

        case ConsumptionTypesEnum::species :
            ?>
            <div id='consump_compte'>
                <div id='consump_compte_div' class='col-sm-2 consumption'>
                    <?php



                    echo "<div class='col-sm-3'>" . $this->Form->input('Consumption.species', array(
                            'label' => __('Species'),
                            'class' => 'form-control',
                            'onchange'=>'javascript: verifySpecieComptes(this.id);',
                            'id' => 'species',
                        )) . "</div>";


                    ?>

                </div>

                <?php
            if (Configure::read("gestion_commercial") == '1'  &&
                Configure::read("tresorerie") == '1') {
                echo "<div   class='col-sm-3 consumption' id='reference_compte_div'>" . $this->Form->input('Consumption.compte_id', array(
                        'label' => __('Compte'),
                        'type' => 'select',
                        'options' => $comptes,
                        'class' => 'form-control select3',
                        'empty' => '',
                        'id' => 'compte',
                    )) . "</div>";
            }
                ?>

            </div>

            <?php
            break;

        case ConsumptionTypesEnum::tank :

            ?>
            <div id='consump_tank'>
                <div id='consump_tank_div' class='col-sm-2 consumption'>
                    <?php
                    echo "<div class='col-sm-3' >" . $this->Form->input('Consumption.consumption_liter', array(

                            'label' => __('Consumption liter'),
                            'class' => 'form-control',
                            'id' => 'consumption_liter',
                            'onchange' => 'javascript:verifyLiterTanks(this.id);'
                        )) . "</div>"; ?>
                </div>

                <?php   echo "<div   class='col-sm-3 consumption' id='code_tank_div'>" . $this->Form->input('Consumption.tank_id', array(
                        'label' => __('Tanks'),
                        'type' => 'select',
                        'options' => $tanks,
                        'class' => 'form-control select3',
                        'empty' => '',
                        'id' => 'tank',
                    )) . "</div>"; ?>

            </div>

            <?php

            break;

        case ConsumptionTypesEnum::card :
            ?>
            <div id='consump_card'>
                <div id='consump_card_div' class='col-sm-2 consumption'>
                    <?php
            if($cardAmountVerification== 1){
                echo "<div class='col-sm-3' >" . $this->Form->input('Consumption.species_card', array(
                        'label' => __('Species card'),
                        'class' => 'form-control',
                        'onchange' => 'javascript:calculateCost(this.id);',
                        'id' => 'species_card'
                    )) . "</div>";
            }else {
                echo "<div class='col-sm-3' >" . $this->Form->input('Consumption.species_card', array(

                        'label' => __('Species card'),
                        'class' => 'form-control',
                        'id' => 'species_card',
                        'onchange' => 'javascript:verifyAmountCards(this.id);'
                    )) . "</div>";
            }
                   ?>
                </div>

                <?php   echo "<div   class='col-sm-3 consumption' id='reference_card_div'>" . $this->Form->input('Consumption.fuel_card_id', array(
                        'label' => __('Cards'),
                        'type' => 'select',
                        'options' => $cards,
                        'class' => 'form-control select3',
                        'empty' => '',
                        'id' => 'card',
                    )) . "</div>"; ?>

            </div>
            <?php
            break;
        default : ?>
            <div></div>
            <?php    break;



    }


    ?>
<!--
    <div class='view-link select-inline' style='margin-top: 16px;' title='<?= __("Estimate cost") ?>'>
        <?= $this->Html->link(
            '<i   class="zmdi zmdi-chart"></i>',
            'javascript:estimateCost('.$i.');',
            array('escape' => false, 'class' => 'btn btn-default' , 'id'=> 'estimate_cost'.$i, 'style'=>'width: 40px;')
        ); ?>
    </div>
    -->
<?php }


