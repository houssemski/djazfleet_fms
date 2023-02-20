

    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <style type="text/css">

            @page { margin: 90px 0; }
            #header { position: fixed; left: 0; top: -80px; right: 0; height: 90px; /*border-bottom: 1px solid #000;*/}
            #header td.company span{display: block; font-size: 22px; padding-bottom: 10px;padding-top: 20px;}
            #footer { position: fixed; left: 0; bottom: -95px; right: 0; height: 200px;  }
            .copyright{font-size:10px; text-align:center;}

            .title{font-weight: bold;
                font-size: 22px;
                text-align: center;
                padding-top: 5px;
                width: 500px;
                margin: 0 auto 10px;

            }


            .customer table {
                border-collapse: collapse;
                width: 100%;
                font-size: 14px;
                padding-top: 5px;
                margin-left: 40px;
                margin-right: 40px;
            }
            .table-bordered {
                width:90%;
                margin: 0px auto;
                border-collapse: collapse;
                position:relative;
            }

            .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th,
            .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
                border: 1px solid #000;
                font-size:11px;
            }

            .table-bordered th {
                font-weight:normal;
                padding:5px 13.4px 5px 13.4px;

                font-size:11px;
            }
            .tab_cons th{
                padding:5px 31px 5px 31px;

            }
            .tab_total th{
                padding:5px 19.4px 5px 19.4px;

            }
            .bon{margin-bottom:10px; margin-top: 80px}
            .table-bordered td {
                text-align:center;
                font-size:13px;
            }
            .customer tr td:first-child{
                width: 250px !important;

                padding-bottom: 2px;

            }
            table.bottom td{padding-top: 5px; font-size: 18px;}
            table.footer td.first{width: 50%; text-align: left}
            table.footer td.second{width: 50%; text-align: left;}
            table.conditions td{
                border: 1px solid grey;
            }
            table.conditions td{
                vertical-align: top;
                padding: 5px 5px 5px 10px;
                line-height: 19px;
            }
            table.conditions_bottom td.first{width: 420px}
            table.conditions_bottom td{padding-top: 5px}
            .note span{display: block;text-decoration: underline;padding-bottom: 5px;}

            .total span{padding:10px 10px;line-height:10px;font-size:13px;}
            #footer { position: fixed; left: 0; bottom: -95px; right: 0; height: 50px;  }

            .box-body{padding: 0; margin: 0; width: 100%; position: relative !important;}

            #header table, #informations table{
                padding:0px 50px;
            }
            .separator_section{
                border-top:2px solid :#000;
                margin:10px auto 10px;
                width:80%;

            }

            .tab_{
                margin-bottom:40px;
                margin-top:20px;
            }
            .tab_ thead{
                padding:5px;
                background:#c0c0c0;
            }
            .tab_ tbody td{
                padding:5px;
            }

        </style>
    </head>
    <body style="page-break-inside:avoid;">
    <div id="header">
        <div class="title"><?php echo __('State of consumption') ?></div>
        <?php if(!empty($startDate) && !empty($endDate)) { ?>
            <div class="title"><?= __('Du '). $startDate .__(' Au ').$endDate?></div>
        <?php } ?>
    </div>

    <hr class="separator_section"/>
    <div class="box-body">
        <?php $totalCost = 0;?>
        <?php if(!empty($car)) { ?>
            <div class="title"><?php echo __('Immatriculation').__(': ').$car['Car']['immatr_def'] ?></div>
            <table class='bon table-bordered tab_' >
                <thead >
                <tr>
                    <?php switch ($typeConsumption) {
                        case ConsumptionTypesEnum::coupon : ?>
                            <th><strong><?php echo __('N'); ?></strong></th>
                            <th><strong><?php echo __('Date'); ?></strong></th>
                            <th><strong><?php echo __('Nb coupons'); ?></strong></th>
                            <th><strong><?php echo __('First number coupon'); ?></strong></th>
                            <th><strong><?php echo __('Last number coupon'); ?></strong></th>
                            <th><strong><?php echo __('Serial numbers'); ?></strong></th>
                            <th><strong><?php echo __('Cost'); ?></strong></th>
                            <th><strong><?php echo __('Destination'); ?></strong></th>
                            <th><strong><?php echo __('Customer'); ?></strong></th>
                            <?php
                            break;
                        case ConsumptionTypesEnum::species: ?>
                            <th><strong><?php echo __('N'); ?></strong></th>
                            <th><strong><?php echo __('Date'); ?></strong></th>
                            <th><strong><?php echo __('Compte'); ?></strong></th>
                            <th><strong><?php echo __('Species'); ?></strong></th>
                            <th><strong><?php echo __('Destination'); ?></strong></th>
                            <th><strong><?php echo __('Customer'); ?></strong></th>

                            <?php
                            break;
                        case ConsumptionTypesEnum::tank : ?>
                            <th><strong><?php echo __('N'); ?></strong></th>
                            <th><strong><?php echo __('Date'); ?></strong></th>
                            <th><strong><?php echo __('Tank'); ?></strong></th>
                            <th><strong><?php echo __('Consumption liter'); ?></strong></th>
                            <th><strong><?php echo __('Destination'); ?></strong></th>
                            <th><strong><?php echo __('Customer'); ?></strong></th>

                            <?php
                            break;
                        case ConsumptionTypesEnum::card : ?>
                            <th><strong><?php echo __('N'); ?></strong></th>
                            <th><strong><?php echo __('Date'); ?></strong></th>
                            <th><strong><?php echo __('Cards'); ?></strong></th>
                            <th><strong><?php echo __('Species card'); ?></strong></th>
                            <th><strong><?php echo __('Destination'); ?></strong></th>
                            <th><strong><?php echo __('Customer'); ?></strong></th>

                            <?php
                            break;
                        default: ?>
                            <th><strong><?php echo __('N'); ?></strong></th>
                            <th><strong><?php echo __('Date'); ?></strong></th>
                            <th><strong><?php echo __('Nb coupons'); ?></strong></th>
                            <th><strong><?php echo __('Serial numbers'); ?></strong></th>
                            <th><strong><?php echo __('Compte'); ?></strong></th>
                            <th><strong><?php echo __('Species'); ?></strong></th>
                            <th><strong><?php echo __('Tank'); ?></strong></th>
                            <th><strong><?php echo __('Consumption liter'); ?></strong></th>
                            <th><strong><?php echo __('Cards'); ?></strong></th>
                            <th><strong><?php echo __('Species card'); ?></strong></th>
                            <th><strong><?php echo __('Cost'); ?></strong></th>
                            <th><strong><?php echo __('Destination'); ?></strong></th>
                            <th><strong><?php echo __('Customer'); ?></strong></th>

                            <?php
                            break;

                    } ?>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                $coupons = array();
                foreach ($consumptions as $consumption) {
                    $i++;
                    if ($i < count($consumptions)) {
                        if ($consumptions[$i]['Consumption']['id'] == $consumption['Consumption']['id']) {
                            $coupons[] = $consumption['Coupon']['serial_number'];
                        } else {
                            $coupons[] = $consumption['Coupon']['serial_number'];
                            ?>
                            <tr >
                                <td> <?php echo $i ?></td>
                                <?php
                                switch($consumption['Consumption']['type_consumption_used']){
                                    case ConsumptionTypesEnum::coupon : ?>
                                        <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y'));?> </td>
                                        <td><?php echo h($consumption['Consumption']['nb_coupon']);?> </td>
                                        <?php if(!empty($typeConsumption)) { ?>
                                            <td><?php echo h($consumption['Consumption']['first_number_coupon']);?></td>
                                            <td><?php echo h($consumption['Consumption']['last_number_coupon']);?></td>

                                            <td>
                                                <?php
                                                $nbCoupons = count($coupons);
                                                $j = 1;
                                                foreach ($coupons as $coupon) {
                                                    if ($j == $nbCoupons) {
                                                        echo $coupon;
                                                    } else {
                                                        echo $coupon . ' , ';
                                                    }
                                                    $j++;
                                                } ?>
                                            </td>

                                        <?php } ?>
                                        <?php if(empty($typeConsumption)) { ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php break;
                                    case ConsumptionTypesEnum::species: ?>
                                        <?php if(empty($typeConsumption)) { ?>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y'));?></td>
                                        <td><?php echo h($consumption['Compte']['num_compte']);?></td>
                                        <td><?php echo h($consumption['Consumption']['species']);?></td>
                                        <?php if(empty($typeConsumption)) { ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php break;
                                    case ConsumptionTypesEnum::tank: ?>
                                        <?php if(empty($typeConsumption)) { ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y'));?></td>
                                        <td><?php echo h($consumption['Tank']['name']);?></td>
                                        <td><?php echo h($consumption['Consumption']['consumption_liter']);?></td>
                                        <?php if(empty($typeConsumption)) { ?>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php break;
                                    case ConsumptionTypesEnum::card: ?>
                                        <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M'));?></td>
                                        <?php if(empty($typeConsumption)) { ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <td><?php echo h($consumption['FuelCard']['reference']);?></td>
                                        <td><?php echo number_format($consumption['Consumption']['species_card'], 2, ",", ".");?></td>

                                        <?php break;
                                } ?>
                                <td><?php
                                    $totalCost = $totalCost + $consumption['Consumption']['cost'];
                                    echo number_format($consumption['Consumption']['cost'], 2, ",", ".");?></td>

                                <td><?php echo h($consumption['Destination']['name']);?></td>
                                <td><?php echo h($consumption['Customer']['first_name'].' '.$consumption['Customer']['last_name']);?></td>
                                <td><?php echo h($consumption['Car']['immatr_def']);?></td>


                            </tr>

                            <?php  $consumptionId = $consumption['Consumption']['id'];
                            $coupons = array();
                        }
                    } else {
                        $coupons[] = $consumption['Coupon']['serial_number'];
                        ?>


                        <tr >
                            <td> <?php echo $i; ?></td>
                            <?php
                            switch($consumption['Consumption']['type_consumption_used']){
                                case ConsumptionTypesEnum::coupon : ?>
                                    <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y'));?> </td>
                                    <td><?php echo h($consumption['Consumption']['nb_coupon']);?> </td>
                                    <?php if(!empty($typeConsumption)) { ?>
                                        <td><?php echo h($consumption['Consumption']['first_number_coupon']);?></td>
                                        <td><?php echo h($consumption['Consumption']['last_number_coupon']);?></td>

                                        <td>
                                            <?php
                                            $nbCoupons = count($coupons);
                                            $j = 1;
                                            foreach ($coupons as $coupon) {
                                                if ($j == $nbCoupons) {
                                                    echo $coupon;
                                                } else {
                                                    echo $coupon . ' , ';
                                                }
                                                $j++;
                                            } ?>
                                        </td>

                                    <?php } ?>

                                    <?php if(empty($typeConsumption)) { ?>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    <?php } ?>
                                    <?php break;
                                case ConsumptionTypesEnum::species: ?>
                                    <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y'));?></td>
                                    <?php if(empty($typeConsumption)) { ?>
                                        <td></td>
                                        <td></td>
                                    <?php } ?>
                                    <td><?php echo h($consumption['Compte']['num_compte']);?></td>
                                    <td><?php echo h($consumption['Consumption']['species']);?></td>
                                    <?php if(empty($typeConsumption)) { ?>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    <?php } ?>
                                    <?php break;
                                case ConsumptionTypesEnum::tank: ?>
                                    <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y'));?></td>
                                    <?php if(empty($typeConsumption)) { ?>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    <?php } ?>
                                    <td><?php echo h($consumption['Tank']['name']);?></td>
                                    <td><?php echo h($consumption['Consumption']['consumption_liter']);?></td>
                                    <?php if(empty($typeConsumption)) { ?>
                                        <td></td>
                                        <td></td>
                                    <?php } ?>
                                    <?php break;
                                case ConsumptionTypesEnum::card: ?>
                                    <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y'));?></td>
                                    <?php if(empty($typeConsumption)) { ?>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    <?php } ?>
                                    <td><?php echo h($consumption['FuelCard']['reference']);?></td>
                                    <td><?php echo number_format($consumption['Consumption']['species_card'], 2, ",", ".");?></td>
                                    <?php break;
                            } ?>
                            <td><?php
                                $totalCost = $totalCost + $consumption['Consumption']['cost'];
                                echo number_format($consumption['Consumption']['cost'], 2, ",", ".");?></td>

                            <td><?php echo h($consumption['Destination']['name']);?></td>
                            <td><?php echo h($consumption['Customer']['first_name'].' '.$consumption['Customer']['last_name']);?></td>
                            <td><?php echo h($consumption['Car']['immatr_def']);?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>


        <?php }else { ?>
            <table class='bon table-bordered tab_' >
                <thead >
                <tr>
                    <?php switch ($typeConsumption) {
                        case ConsumptionTypesEnum::coupon : ?>
                            <th><strong><?php echo __('N'); ?></strong></th>
                            <th><strong><?php echo __('Date'); ?></strong></th>
                            <th><strong><?php echo __('Nb coupons'); ?></strong></th>
                            <th><strong><?php echo __('First number coupon'); ?></strong></th>
                            <th><strong><?php echo __('Last number coupon'); ?></strong></th>
                            <th><strong><?php echo __('Serial numbers'); ?></strong></th>
                            <th><strong><?php echo __('Cost'); ?></strong></th>
                            <th><strong><?php echo __('Destination'); ?></strong></th>
                            <th><strong><?php echo __('Customer'); ?></strong></th>
                            <th><strong><?php echo __('Car'); ?></strong></th>
                            <?php
                            break;
                        case ConsumptionTypesEnum::species: ?>
                            <th><strong><?php echo __('N'); ?></strong></th>
                            <th><strong><?php echo __('Date'); ?></strong></th>
                            <th><strong><?php echo __('Compte'); ?></strong></th>
                            <th><strong><?php echo __('Species'); ?></strong></th>
                            <th><strong><?php echo __('Cost'); ?></strong></th>
                            <th><strong><?php echo __('Destination'); ?></strong></th>
                            <th><strong><?php echo __('Customer'); ?></strong></th>
                            <th><strong><?php echo __('Car'); ?></strong></th>

                            <?php
                            break;
                        case ConsumptionTypesEnum::tank : ?>
                            <th><strong><?php echo __('N'); ?></strong></th>
                            <th><strong><?php echo __('Date'); ?></strong></th>
                            <th><strong><?php echo __('Tank'); ?></strong></th>
                            <th><strong><?php echo __('Consumption liter'); ?></strong></th>
                            <th><strong><?php echo __('Cost'); ?></strong></th>
                            <th><strong><?php echo __('Destination'); ?></strong></th>
                            <th><strong><?php echo __('Customer'); ?></strong></th>
                            <th><strong><?php echo __('Car'); ?></strong></th>

                            <?php
                            break;
                        case ConsumptionTypesEnum::card : ?>
                            <th><strong><?php echo __('N'); ?></strong></th>
                            <th><strong><?php echo __('Date'); ?></strong></th>
                            <th><strong><?php echo __('Cards'); ?></strong></th>
                            <th><strong><?php echo __('Species card'); ?></strong></th>
                            <th><strong><?php echo __('Cost'); ?></strong></th>
                            <th><strong><?php echo __('Destination'); ?></strong></th>
                            <th><strong><?php echo __('Customer'); ?></strong></th>
                            <th><strong><?php echo __('Car'); ?></strong></th>

                            <?php
                            break;
                        default: ?>
                            <th><strong><?php echo __('N'); ?></strong></th>
                            <th><strong><?php echo __('Date'); ?></strong></th>
                            <th><strong><?php echo __('Nb coupons'); ?></strong></th>
                            <th><strong><?php echo __('Compte'); ?></strong></th>
                            <th><strong><?php echo __('Species'); ?></strong></th>
                            <th><strong><?php echo __('Tank'); ?></strong></th>
                            <th><strong><?php echo __('Consumption liter'); ?></strong></th>
                            <th><strong><?php echo __('Cards'); ?></strong></th>
                            <th><strong><?php echo __('Species card'); ?></strong></th>
                            <th><strong><?php echo __('Cost'); ?></strong></th>
                            <th><strong><?php echo __('Destination'); ?></strong></th>
                            <th><strong><?php echo __('Customer'); ?></strong></th>
                            <th><strong><?php echo __('Car'); ?></strong></th>

                            <?php
                            break;

                    } ?>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                $coupons = array();
                foreach ($consumptions as $consumption) {
                    $i++;
                    if ($i < count($consumptions)) {
                        if ($consumptions[$i]['Consumption']['id'] == $consumption['Consumption']['id']) {
                            $coupons[] = $consumption['Coupon']['serial_number'];
                        } else {
                            $coupons[] = $consumption['Coupon']['serial_number'];
                            ?>
                            <tr >
                                <td> <?php echo $i ?></td>
                                <?php
                                switch($consumption['Consumption']['type_consumption_used']){
                                    case ConsumptionTypesEnum::coupon : ?>
                                        <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y'));?> </td>
                                        <td><?php echo h($consumption['Consumption']['nb_coupon']);?> </td>
                                        <?php if(!empty($typeConsumption)) { ?>
                                            <td><?php echo h($consumption['Consumption']['first_number_coupon']);?></td>
                                            <td><?php echo h($consumption['Consumption']['last_number_coupon']);?></td>
                                            <td>
                                                <?php
                                                $nbCoupons = count($coupons);
                                                $j = 1;
                                                foreach ($coupons as $coupon) {
                                                    if ($j == $nbCoupons) {
                                                        echo $coupon;
                                                    } else {
                                                        echo $coupon . ' , ';
                                                    }
                                                    $j++;
                                                } ?>
                                            </td>

                                        <?php } ?>
                                        <?php if(empty($typeConsumption)) { ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php break;
                                    case ConsumptionTypesEnum::species: ?>
                                        <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y'));?></td>
                                        <?php if(empty($typeConsumption)) { ?>
                                            <td></td>
                                        <?php } ?>
                                        <td><?php echo h($consumption['Compte']['num_compte']);?></td>
                                        <td><?php echo h($consumption['Consumption']['species']);?></td>
                                        <?php if(empty($typeConsumption)) { ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php break;
                                    case ConsumptionTypesEnum::tank: ?>

                                        <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y'));?></td>
                                        <?php if(empty($typeConsumption)) { ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <td><?php echo h($consumption['Tank']['name']);?></td>
                                        <td><?php echo h($consumption['Consumption']['consumption_liter']);?></td>
                                        <?php if(empty($typeConsumption)) { ?>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php break;
                                    case ConsumptionTypesEnum::card: ?>
                                        <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y'));?></td>
                                        <?php if(empty($typeConsumption)) { ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <td><?php echo h($consumption['FuelCard']['reference']);?></td>
                                        <td><?php echo number_format($consumption['Consumption']['species_card'], 2, ",", ".");?></td>

                                        <?php break;
                                } ?>
                                <td><?php
                                    $totalCost = $totalCost + $consumption['Consumption']['cost'];
                                    echo number_format($consumption['Consumption']['cost'], 2, ",", ".");?></td>
                                <td><?php echo h($consumption['Destination']['name']);?></td>
                                <td><?php echo h($consumption['Customer']['first_name'].' '.$consumption['Customer']['last_name']);?></td>
                                <td><?php echo h($consumption['Car']['immatr_def']);?></td>

                            </tr>

                            <?php  $consumptionId = $consumption['Consumption']['id'];
                            $coupons = array();
                        }
                    } else {
                        $coupons[] = $consumption['Coupon']['serial_number']; ?>
                        <tr >
                            <td> <?php echo $i; ?></td>
                            <?php
                            switch($consumption['Consumption']['type_consumption_used']){
                                case ConsumptionTypesEnum::coupon : ?>
                                    <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y'));?> </td>
                                    <td><?php echo h($consumption['Consumption']['nb_coupon']);?> </td>
                                    <?php if(!empty($typeConsumption)) { ?>
                                        <td><?php echo h($consumption['Consumption']['first_number_coupon']);?></td>
                                        <td><?php echo h($consumption['Consumption']['last_number_coupon']);?></td>
                                        <td>
                                            <?php
                                            $nbCoupons = count($coupons);
                                            $j = 1;
                                            foreach ($coupons as $coupon) {
                                                if ($j == $nbCoupons) {
                                                    echo $coupon;
                                                } else {
                                                    echo $coupon . ' , ';
                                                }
                                                $j++;
                                            } ?>
                                        </td>

                                    <?php } ?>
                                    <?php if(empty($typeConsumption)) { ?>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    <?php } ?>
                                    <?php break;
                                case ConsumptionTypesEnum::species: ?>
                                    <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y'));?></td>
                                    <?php if(empty($typeConsumption)) { ?>
                                        <td></td>
                                    <?php } ?>
                                    <td><?php echo h($consumption['Compte']['num_compte']);?></td>
                                    <td><?php echo h($consumption['Consumption']['species']);?></td>
                                    <?php if(empty($typeConsumption)) { ?>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    <?php } ?>
                                    <?php break;
                                case ConsumptionTypesEnum::tank: ?>
                                    <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y'));?></td>
                                    <?php if(empty($typeConsumption)) { ?>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    <?php } ?>
                                    <td><?php echo h($consumption['Tank']['name']);?></td>
                                    <td><?php echo h($consumption['Consumption']['consumption_liter']);?></td>
                                    <?php if(empty($typeConsumption)) { ?>
                                        <td></td>
                                        <td></td>
                                    <?php } ?>
                                    <?php break;
                                case ConsumptionTypesEnum::card: ?>
                                    <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y'));?></td>
                                    <?php if(empty($typeConsumption)) { ?>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    <?php } ?>
                                    <td><?php echo h($consumption['FuelCard']['reference']);?></td>
                                    <td><?php echo number_format($consumption['Consumption']['species_card'], 2, ",", ".");?></td>
                                    <?php break;
                            } ?>
                            <td><?php
                                $totalCost = $totalCost + $consumption['Consumption']['cost'];
                                echo number_format($consumption['Consumption']['cost'], 2, ",", ".");?></td>
                            <td><?php echo h($consumption['Destination']['name']);?></td>
                            <td><?php echo h($consumption['Customer']['first_name'].' '.$consumption['Customer']['last_name']);?></td>
                            <td><?php echo h($consumption['Car']['immatr_def']);?></td>

                        </tr>
                        <?php
                    }
                }
                ?>

                </tbody>
            </table>


        <?php   } ?>
        <table class='bon table-bordered tab_'>
            <tr>
                <td>
                    <?php echo __('Total cost : '); echo number_format($totalCost, 2, ",", ".") ?>
                </td>
            </tr>
        </table>


        <div style="clear:both;"></div>
    </div>

    <div id="footer">
        <p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
    </div>
    </body>
    </html>




