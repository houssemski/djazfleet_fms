

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
        <div class="title"><?php echo __('Debt by customer') ?></div>
        <?php if(!empty($startDate) && !empty($endDate)) { ?>
            <div class="title"><?= __('Du '). $startDate .__(' Au ').$endDate?></div>
        <?php } ?>
        <?php
        $height = 200;
        $countTransportBills = 0;
        if(!empty($transportBills)){
            $supplierId = $transportBills[0]['Supplier']['id'];
            $supplier = $transportBills[0]['Supplier']['code'].' : '.$transportBills[0]['Supplier']['name'];
            $countTransportBills = count($transportBills);
            ?>

            <?php
            if($height>=430 ) {?>
        <div style="page-break-before:always !important;">
        </div>
                <?php
                $height = 200;
            } ?>
            <div class="title2"><?= $supplier?></div>
        <?php
            $height = $height +15;
        } ?>
        <table class='bon table-bordered tab_' style="page-break-inside:avoid !important;">
            <thead >
            <tr>
                <th ><strong><?php echo __('Reference'); ?></strong></th>
                <th ><strong><?php echo __('Date'); ?></strong></th>
                <th><strong><?php echo  __('Total amount'); ?></strong></th>
                <th><strong><?php echo  __('Payroll amount'); ?></strong></th>
                <th ><strong><?php echo  __('Amount remaining') ?></strong></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $totalAmount = 0;
            $totalAmountRemaining = 0;
            $totalPayrollAmount = 0;
            for ($i =0 ;$i<$countTransportBills ; $i++ ){ ?>
            <?php
            if($supplierId == $transportBills[$i]['Supplier']['id']){
            $totalAmount = $totalAmount + $transportBills[$i]['TransportBill']['total_ttc'] ;
            $totalAmountRemaining = $totalAmountRemaining + $transportBills[$i]['TransportBill']['amount_remaining'];
            ?>
            <tr>
                <td><?php echo h($transportBills[$i]['TransportBill']['reference']); ?>&nbsp;</td>
                <td><?php echo h($this->Time->format($transportBills[$i]['TransportBill']['date'], '%d-%m-%Y')); ?>&nbsp;</td>
                <td><?php echo number_format($transportBills[$i]['TransportBill']['total_ttc'], 2, ",", $separatorAmount) ?>&nbsp;</td>
                <td><?php
                    $payrollAmount = $transportBills[$i]['TransportBill']['total_ttc'] - $transportBills[$i]['TransportBill']['amount_remaining'];
                    $totalPayrollAmount = $totalPayrollAmount + $payrollAmount;
                    echo number_format($payrollAmount, 2, ",", $separatorAmount) ?>&nbsp;</td>
                <td><?php echo number_format($transportBills[$i]['TransportBill']['amount_remaining'], 2, ",", $separatorAmount) ?>&nbsp;</td>
            </tr>


   <?php
                $height = $height +15;
            } else { ?>
        <tr>
            <td colspan=2><?php echo __('Total pour : ').' '.$supplier ?></td>
            <td><?php echo number_format($totalAmount, 2, ",", $separatorAmount) ?>&nbsp;</td>
            <td><?php echo number_format($totalPayrollAmount, 2, ",", $separatorAmount) ?>&nbsp;</td>
            <td><?php echo number_format($totalAmountRemaining, 2, ",", $separatorAmount) ?>&nbsp;</td>

        </tr>
        </tbody>
        </table>

        <?php
        $height = $height +15;
        $totalAmount = 0;
        $totalAmountRemaining = 0;
        $totalPayrollAmount = 0;
        if($i < $countTransportBills){
        $supplierId = $transportBills[$i]['Supplier']['id'];
        $supplier = $transportBills[$i]['Supplier']['code'].' : '.$transportBills[$i]['Supplier']['name'];
        ?>
        <?php
        if($height>=430 ) {?>
        <div style="page-break-before:always !important;">
        </div>
        <?php
            $height = 200;
        } ?>
        <div class="title2"><?=  $supplier?></div>
        <?php  $height = $height +15; ?>

        <table class='bon table-bordered tab_' style="page-break-inside:avoid !important;">
            <thead >
            <tr>
                <th ><strong><?php echo __('Reference'); ?></strong></th>
                <th ><strong><?php echo __('Date'); ?></strong></th>
                <th><strong><?php echo  __('Total amount'); ?></strong></th>
                <th><strong><?php echo  __('Payroll amount'); ?></strong></th>
                <th ><strong><?php echo  __('Amount remaining') ?></strong></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $height = $height +15;
            $totalAmount = $totalAmount +$transportBills[$i]['TransportBill']['total_ttc'] ;
            $totalAmountRemaining = $totalAmountRemaining + $transportBills[$i]['TransportBill']['amount_remaining'];
            ?>
            <tr>
                <td><?php echo h($transportBills[$i]['TransportBill']['reference']); ?>&nbsp;</td>
                <td><?php echo h($this->Time->format($transportBills[$i]['TransportBill']['date'], '%d-%m-%Y')); ?>&nbsp;</td>
                <td><?php echo number_format($transportBills[$i]['TransportBill']['total_ttc'], 2, ",", $separatorAmount) ?>&nbsp;</td>
                <td><?php
                    $payrollAmount = $transportBills[$i]['TransportBill']['total_ttc'] - $transportBills[$i]['TransportBill']['amount_remaining'];
                    $totalPayrollAmount = $totalPayrollAmount + $payrollAmount;
                    echo number_format($payrollAmount, 2, ",", $separatorAmount) ?>&nbsp;</td>
                <td><?php echo number_format($transportBills[$i]['TransportBill']['amount_remaining'], 2, ",", $separatorAmount) ?>&nbsp;</td>
            </tr>
            <?php
            $height = $height +15;
        }
            }
            }?>
            <?php if($i==$countTransportBills){ ?>
            <tr>
                <td colspan=2><?php echo __('Total pour : ').' '.$supplier?></td>
                <td><?php echo number_format($totalAmount, 2, ",", $separatorAmount) ?>&nbsp;</td>
                <td><?php echo number_format($totalPayrollAmount, 2, ",", $separatorAmount) ?>&nbsp;</td>
                <td><?php echo number_format($totalAmountRemaining, 2, ",", $separatorAmount) ?>&nbsp;</td>

            </tr>
            </tbody>
        </table>

    <?php
    $height = $height +15;
            } ?>
        <div style="clear:both;"></div>
    </div>

    <div id="footer">
        <p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
    </div>
    </body>
    </html>




