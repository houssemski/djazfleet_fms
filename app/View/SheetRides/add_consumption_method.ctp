<?php
if(isset($typeConsumption)){
switch ($typeConsumption) {
    case ConsumptionTypesEnum::coupon :
        ?>
        <div id='coupon_div<?php echo $i ?>'>

            <?php if ($selectingCouponsMethod == 1) { ?>
                <div id='consump_coupon<?php echo $i ?>' class="select-inline consumption">
                    <?php    echo "<div class='select-inline'>" . $this->Form->input('Consumption.' . $i . '.nb_coupon', array(
                            'label' => __('Nb coupons'),
                            'type' => 'number',
                            'class' => 'form-filter',
                            'id' => 'coupons' . $i,
                            'onchange' => 'javascript:couponsToSelect(this.id) ;'

                        )) . "</div>"; ?>

                    <span id='con_coupon<?php echo $i ?>'> </span>
                </div>
                <?php
                echo "<div  id='coupon-div$i'></div>";
            } else {
                ?>
                <div id='consump_coupon<?php echo $i ?>' class="select-inline consumption">
                    <?php    echo "<div class='select-inline'>" . $this->Form->input('Consumption.' . $i . '.nb_coupon', array(
                            'label' => __('Nb coupons'),
                            'type' => 'number',
                            'class' => 'form-filter',
                            'id' => 'coupons' . $i,
                            'onchange' => 'javascript:couponsSelectedFromFirstNumber(this.id);'

                        )) . "</div>"; ?>

                    <span id='con_coupon<?php echo $i ?>'> </span>
                </div>
                <?php
                echo "<div id='number_coupon_div$i' style='padding-left: 35px;' class='consumption'>";
                echo "<div class='select-inline'>" . $this->Form->input('Consumption.' . $i . '.first_number_coupon', array(
                        'label' => __('From'),
                        'class' => 'form-filter',
                        'id' => 'first_number_coupon' . $i,
                        'onchange' => 'javascript:couponsSelectedFromFirstNumber(this.id);'
                    )) . "</div>";

                echo "<div class='select-inline consumption'>" . $this->Form->input('Consumption.' . $i . '.last_number_coupon', array(
                        'label' => __('To'),
                        'readonly' => true,
                        'class' => 'form-filter',
                        'id' => 'last_number_coupon' . $i,
                    )) . "</div>";
                echo "</div>";


            }?>

        </div>
        <?php
        break;

    case ConsumptionTypesEnum::species :
        ?>
        <div id='consump_compte<?php echo $i ?>'>
            <div id='consump_compte_div<?php echo $i ?>' class='select-inline consumption'>
                <?php



        echo "<div class='select-inline'>" . $this->Form->input('Consumption.' . $i . '.species', array(
                'label' => __('Species'),
                'class' => 'form-filter',
                'onchange'=>'javascript: verifySpecieComptes(this.id);',
                'id' => 'species'.$i,
            )) . "</div>";


        ?>

        </div>

            <?php

        if (Configure::read("gestion_commercial") == '1'  &&
            Configure::read("tresorerie") == '1') {

            echo "<div   class='select-inline consumption' id='reference_compte_div$i '>" . $this->Form->input('Consumption.' . $i . '.compte_id', array(
                    'label' => __('Compte'),
                    'type' => 'select',
                    'options' => $comptes,
                    'class' => 'form-filter select3',
                    'empty' => '',
                    'id' => 'compte' . $i,
                )) . "</div>";
        }
        ?>

        </div>

        <?php
        break;

    case ConsumptionTypesEnum::tank :

        ?>
        <div id='consump_tank<?php echo $i ?>'>
            <div id='consump_tank_div<?php echo $i ?>' class='select-inline consumption'>
                <?php
                echo "<div class='select-inline' >" . $this->Form->input('Consumption.' . $i . '.consumption_liter', array(

                        'label' => __('Consumption liter'),
                        'class' => 'form-filter',
                        'id' => 'consumption_liter'.$i,
                        'onchange' => 'javascript:verifyLiterTanks(this.id);'
                    )) . "</div>"; ?>
            </div>

            <?php   echo "<div   class='select-inline consumption' id='code_tank_div$i '>" . $this->Form->input('Consumption.' . $i . '.tank_id', array(
                    'label' => __('Tanks'),
                    'type' => 'select',
                    'options' => $tanks,
                    'class' => 'form-filter select3',
                    'empty' => '',
                    'id' => 'tank'.$i,
                )) . "</div>"; ?>

        </div>

        <?php

        break;

    case ConsumptionTypesEnum::card :
        ?>
        <div id='consump_card<?php echo $i ?>'>
            <div id='consump_card_div<?php echo $i ?>' class='select-inline consumption'>
                <?php
                if($cardAmountVerification== 1){
                    echo "<div class='select-inline' >" . $this->Form->input('Consumption.' . $i . '.species_card', array(
                            'label' => __('Species card'),
                            'class' => 'form-filter',
                            'id' => 'species_card'.$i,
                            'onchange' => 'javascript:calculateCost();'
                        )) . "</div>";

                }else {
                    echo "<div class='select-inline' >" . $this->Form->input('Consumption.' . $i . '.species_card', array(

                            'label' => __('Species card'),
                            'class' => 'form-filter',
                            'id' => 'species_card'.$i,
                            'onchange' => 'javascript:verifyAmountCards(this.id);'
                        )) . "</div>";

                }
              ?>
            </div>

            <?php
            if($automaticCardAssignment == 1){
                echo "<div   class='select-inline consumption' id='reference_card_div$i'>" . $this->Form->input('Consumption.' . $i . '.fuel_card_id', array(
                        'label' => __('Cards'),
                        'type' => 'select',
                        'options' => $cards,
                        'class' => 'form-filter select3',
                        'id' => 'card'.$i,
                    )) . "</div>";
            }else {
                echo "<div   class='select-inline consumption' id='reference_card_div$i'>" . $this->Form->input('Consumption.' . $i . '.fuel_card_id', array(
                        'label' => __('Cards'),
                        'type' => 'select',
                        'options' => $cards,
                        'class' => 'form-filter select3',
                        'empty' => '',
                        'id' => 'card'.$i,
                    )) . "</div>";
            }

            ?>

        </div>
        <?php
        break;
    default : ?>
        <div></div>
        <?php    break;



}

    echo "<div  >" . $this->Form->input('Consumption.' . $i . '.cost', array(
            'class' => 'form-filter ',
            //'type' => 'hidden',
            'id' => 'cost'.$i,
        )) . "</div>";
?>

<div class='view-link select-inline' style='margin-top: 16px;' title='<?= __("Estimate cost") ?>'>
    <?= $this->Html->link(
        '<i   class="zmdi zmdi-chart"></i>',
        'javascript:estimateCost('.$i.');',
        array('escape' => false, 'class' => 'btn btn-default' , 'id'=> 'estimate_cost'.$i, 'style'=>'width: 40px;')
    ); ?>
</div>
<?php }


