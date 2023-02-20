<?php
if(isset($typeConsumption)){
    switch ($typeConsumption) {
        case ConsumptionTypesEnum::coupon :

            echo $this->Form->input('Consumptions.coupons_from', array(
                'label' => __('Num coupon from'),
                'options' => $coupons,
                'class' => 'form-filter select3',
                'id'=>'coupons_from',
                'empty' => ''
            ));

            echo $this->Form->input('Consumptions.coupons_to', array(
                'label' => __('to num'),
                'options' => $coupons,
                'class' => 'form-filter select3',
                'id'=>'coupons_to',
                'empty' => ''
            ));
            break;

        case ConsumptionTypesEnum::species :

            if (Configure::read("gestion_commercial") == '1'  &&
                Configure::read("tresorerie") == '1') {

                echo $this->Form->input('Consumptions.compte_id', array(
                    'label' => __('Compte'),
                    'type' => 'select',
                    'options' => $comptes,
                    'class' => 'form-filter select3',
                    'empty' => '',
                    'id' => 'compte',
                ));
            }

            break;

        case ConsumptionTypesEnum::tank :
        echo  $this->Form->input('Consumptions.tank_id', array(
                        'label' => __('Tanks'),
                        'type' => 'select',
                        'options' => $tanks,
                        'class' => 'form-filter select3',
                        'empty' => '',
                        'id' => 'tank',
                    )) ;


            break;

        case ConsumptionTypesEnum::card :
             echo  $this->Form->input('Consumptions.fuel_card_id', array(
                        'label' => __('Cards'),
                        'type' => 'select',
                        'options' => $cards,
                        'class' => 'form-filter select3',
                        'empty' => '',
                        'id' => 'card',
                    )) ;
            break;
        default :     break;



    }



 }


