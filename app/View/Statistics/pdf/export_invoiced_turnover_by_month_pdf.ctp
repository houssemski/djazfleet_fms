

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <style type="text/css">

        @page { margin: 20px 20px; }
        #header { position: fixed; left: 0; top: -20px; right: 0; height: 20px; /*border-bottom: 1px solid #000;*/}
        #header td.company{vertical-align: top; font-weight: bold; font-size: 14px;text-align: center;line-height: 24px}
        #header td.company span{display: block; font-size: 22px; padding-bottom: 10px;padding-top: 20px;}
        #footer {position: fixed; left: 0; bottom: -20px; right: 0; height: 20px;}
        .copyright{font-size:10px; text-align:center;}

        .date{padding-top: 0px; text-align:right;margin-right:25px;}
        .title{font-weight: bold; font-size: 18px;
            text-align: center;
            padding-top: 5px;
            width: 500px;
            margin: 0 auto 10px;
            height: 30px;
        }
        .title2{font-weight: bold;
            font-size: 14px;
            padding-top: 5px;
            margin-left: 60px ;
            height: 10px;

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
        .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
            border: 1px solid #000;
            font-size:11px;
        }
        .table-bordered th {
            font-weight:normal;
            padding:5px 13.4px 5px 13.4px;
            font-size:11px;
            height: 10px;
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
            height: 10px;
        }
        .customer tr td:first-child{
            width: 250px !important;
            padding-bottom: 2px;
        }
        table.bottom td{padding-top: 5px; font-size: 18px;}
        table.conditions td{
            border: 1px solid grey;
        }
        table.conditions td{
            vertical-align: top;
            padding: 5px 5px 5px 10px;
            line-height: 19px;
        }
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
        #informations{
            padding-top:5px;
            height: 100px;
        }
        #informations table{
            width:100%;
        }
        #informations table .company{
            width:70%;
            text-align: left;
            font-size: 16px;
        }
        #informations table .company .campany_name{
            display: block;
            font-size: 25px;
            text-align: left;
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
        .tab_ tbody{
            background:#eeeffd;
        }
        table td {
            page-break-inside:avoid !important;
        }
        table tr td {
            page-break-inside:avoid !important;
        }
    </style>
</head>
<body style="page-break-inside:avoid;">
<div id="header">

</div>
<div id="informations">
    <table>
        <tr>
            <td class="company">
                <span class="campany_name"><?= $company['Company']['name'] ?></span><br/>
                <span><?= 'Tél. : '.$company['Company']['mobile'] ?></span><br/>
                <span><?= 'Fax : '.$company['Company']['fax'] ?></span>
            </td>
            <td class="date">
                <?= date("d/m/Y") ?>
            </td>
        </tr>
    </table>
</div>
<hr class="separator_section"/>
<div class="box-body">
    <div class="title"><?php echo __('Chiffre d\'affaires facturé par mois') ?></div>
    <?php if(!empty($startDate) && !empty($endDate)) { ?>
        <div class="title"><?= __('Du '). $startDate .__(' Au ').$endDate?></div>
    <?php } ?>
    <br>
    <table class='bon table-bordered tab_' style="page-break-inside:avoid !important;">
        <thead >
        <tr>
            <?php
            if (Configure::read('utranx_trm') !='1'){
                ?>
                <th><?= __('Car') ?></th>
                <th><?= __('Customer') ?></th>
                <?php
            }
            ?>
            <th><?= __('Client') ?></th>
            <th><?= __('Price HT') ?></th>
            <th><?= __('Price TTC') ?></th>
        </tr>
        </thead>
        <tbody>

        <?php
        if (Configure::read('utranx_trm') !='1') {
            $colspanMonth = 5;
            $colspanTotal= 3;
        }else{
            $colspanMonth = 3;
            $colspanTotal= 1;
        }
        $previous=null;
        $sumPriceMonth=0;
        $sumPrice=0;
        $previousLabel = '';
        $sumHtPriceMonth=0;
        $sumHtPrice=0;
        $previousLabel = '';
        foreach ($results as $result) {

            $currentMonth= $result[0]['month'];
            for($i=1; $i<=12; $i++){
                switch ($i) {
                    case 1 :
                        $label = __("January");
                        break;
                    case 2 :
                        $label = __("February");
                        break;
                    case 3 :
                        $label = __("March");
                        break;
                    case 4 :
                        $label = __("April");
                        break;
                    case 5 :
                        $label = __("May");
                        break;
                    case 6 :
                        $label = __("June");
                        break;
                    case 7 :
                        $label = __("July");
                        break;
                    case 8 :
                        $label = __("August");
                        break;
                    case 9 :
                        $label = __("September");
                        break;
                    case 10 :
                        $label = __("October");
                        break;
                    case 11 :
                        $label = __("November");
                        break;
                    case 12 :
                        $label = __("December");
                        break;
                }
                if (  $result[0]['month'] == $i) {
                    if($currentMonth!=$previous) {
                        if($previous!=null){ ?>

                            <tr style='width: auto;'>
                                <td colspan='<?= $colspanTotal ?>' style='font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>".__('Total')." ".$previousLabel."</span>" ; ?></td>
                                <td style='font-weight:bold;color:#000; text-align:right'>
                                    <?= number_format($sumHtPriceMonth, 2, ",", "."). " " . $this->Session->read("currency") ?>
                                </td>
                                <td style='font-weight:bold;color:#000; text-align:right'>
                                    <?= number_format($sumPriceMonth, 2, ",", "."). " " . $this->Session->read("currency") ?>
                                </td>
                            </tr>
                            <?php
                            $sumPriceMonth=0;
                            $sumHtPriceMonth=0;
                        }
                        $previousLabel = $label;
                        echo "<tr style='width: auto;'>" .
                            "<td colspan='".$colspanMonth."' >"
                            . $label . "</td></tr>";
                        $previousLabel = $label;
                        echo "<tr>";
                        if (Configure::read('utranx_trm') !='1') {
                            echo "<td>" . $result['car']['immatr_def'] . ' ' . $result['carmodels']['name'] . "</td>";
                            echo "<td>" . $result['customers']['first_name'] . ' ' . $result['customers']['last_name'] . "</td>";
                        }
                        echo "<td>" . $result['suppliers']['name'] ."</td>";

                        echo "<td class='right'>" . number_format($result[0]['sum_ht_price'], 2, ",", ".") ."</td>";
                        echo "<td class='right'>" . number_format($result[0]['sum_ttc_price'], 2, ",", ".") ."</td></tr>";
                        $sumPriceMonth= $sumPriceMonth+$result[0]['sum_ttc_price'];
                        $sumPrice= $sumPrice+$result[0]['sum_ttc_price'];
                        $sumHtPriceMonth= $sumHtPriceMonth+$result[0]['sum_ht_price'];
                        $sumHtPrice= $sumHtPrice+$result[0]['sum_ht_price'];
                    }
                    else{

                        echo "<tr>";
                        if (Configure::read('utranx_trm') !='1') {
                            echo "<td>" . $result['car']['immatr_def'] . ' ' . $result['carmodels']['name'] . "</td>";
                            echo "<td>" . $result['customers']['first_name'] . ' ' . $result['customers']['last_name'] . "</td>";
                        }
                        echo "<td>" . $result['suppliers']['name'] ."</td>";

                        echo "<td class='right'>" . number_format($result[0]['sum_ht_price'], 2, ",", ".") ."</td>";
                        echo "<td class='right'>" . number_format($result[0]['sum_ttc_price'], 2, ",", ".") ."</td></tr>";
                        $sumPriceMonth= $sumPriceMonth+$result[0]['sum_ttc_price'];
                        $sumPrice= $sumPrice+$result[0]['sum_ttc_price'];
                        $sumHtPriceMonth= $sumHtPriceMonth+$result[0]['sum_ht_price'];
                        $sumHtPrice= $sumHtPrice+$result[0]['sum_ht_price'];

                    }
                    $previous=$currentMonth;
                }
            }







        } ?>
        <tr style='width: auto;'>
            <td colspan='<?= $colspanTotal ?>' style='font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>".__('Total')." ".$previousLabel."</span>" ; ?></td>
            <td style='font-weight:bold;color:#000; text-align:right'>
                <?= number_format($sumHtPriceMonth, 2, ",", "."). " " . $this->Session->read("currency") ?>
            </td>
            <td style='font-weight:bold;color:#000; text-align:right'>
                <?= number_format($sumPriceMonth, 2, ",", "."). " " . $this->Session->read("currency") ?>
            </td>
        </tr>
        <tr style='width: auto;'>
            <td colspan='<?= $colspanTotal ?>' style='font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>".__('Total')."</span>" ; ?></td>
            <td style='font-weight:bold;color:#000; text-align:right'>
                <?= number_format($sumHtPrice, 2, ",", "."). " " . $this->Session->read("currency") ?>
            </td>
            <td style='font-weight:bold;color:#000; text-align:right'>
                <?= number_format($sumPrice, 2, ",", "."). " " . $this->Session->read("currency") ?>
            </td>
        </tr>
        </tbody>
    </table>

    <div style="clear:both;"></div>
</div>

<div id="footer">
    <p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
</div>
</body>
</html>




