
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
        @page { margin: 95px 0; }
        #header { position: fixed; left: 25px; top: -95px; right: 25px; height: auto; border-bottom: 3px solid #000;}
        #header table{width:100%;}
        #header td.logo{vertical-align: top;padding-left:25px;padding-top:15px;}
        .company{vertical-align: top; font-weight: bold; font-size: 16px;display: block; font-size: 22px; padding-top: 20px;}
        .copyright{font-size:10px; text-align:center;}
        .info_company{width:500px;font-size:12px;line-height:18px;}
        .info_fiscal{width:500px;font-size:12px;padding-top: 60px;line-height:18px;padding-right: 5px; float: right;}
        .adr{font-weight:normal; font-size:12px;}
        .date{padding-top: 5px; text-align:right;padding-right:25px;}
        .box-body{padding: 50px 25px 0;position:relative;}
        .bloc-center{width:100%;}
        .facture{font-size:18px;font-weight:bold;}
        .date{font-size:16px;font-weight:bold;text-align:right;}
        .modepayment,.droit{padding-top:30px;}
        .modepayment{font-size:12px; width:350px;}
        .main-table{border: 1px solid black;width:100%;border-collapse: collapse;margin:30px 0;}
        .main-table > thead > tr > th, .main-table > tbody > tr > th, .main-table > tfoot > tr > th, .main-table > thead > tr > td, .main-table > tbody > tr > td, .main-table > tfoot > tr > td {
            border: 1px solid #000;}
        .main-table th{border: 1px solid black;padding-left:5px;text-align:left;; font-size: 11px}
        .main-table td{text-align:left;padding:3px 5px; ; font-size: 11px}
        .total{width:250px;position:absolute;bottom:150px;float:right;right:25px;border:2px solid #000;border-radius: 10px}
        .total span{padding:10px 10px;line-height:10px;font-size:13px;}
        #footer { position: fixed; left: 0; bottom: -95px; right: 0; height: 50px;  }
        .total .left{
            width:40%;
            text-align:left;
            display:inline-block;
        }
        .total .right{
            width:40%;
            text-align:right;
            display:inline-block;
        }
        .ttc{border-top:1px solid #000;}
        .client{font-size:16px; font-weight:bold;margin-bottom:30px; display:block; padding-top:10px;}
        .info_client{font-size:11px;}
    </style>
</head>
<body class='body'>
<div id="header">
    <table>
        <tr>

            <td class='info_company'>
                <span class="company"><?= Configure::read("nameCompany") ?></span><br>
                <span class='adr'><?= $company['Company']['adress']?></span><br>
                <span><strong>Tél. :</strong><?= $company['Company']['phone']?></span><br>
                <span><strong>Fax :</strong><?= $company['Company']['fax']?></span><br>
                <span><strong>Mobile :</strong><?= $company['Company']['mobile']?></span><br>

            </td>
            <td class="info_fiscal">
                <span><strong>RC :</strong><?= $company['Company']['rc'] ?></span><br>
                <span><strong>AI :</strong><?= $company['Company']['ai']?></span><br>
                <span><strong>NIF :</strong><?= $company['Company']['nif']?></span><br>
                <span><strong>Compte :</strong><?= $company['Company']['cb']?></span>
            </td>

        </tr>
    </table>
</div>
<div class="box-body">
    <table class="bloc-center">
        <tr>
            <td>
                        <span class="facture"> <?php echo __('Contract'); ?><?= $contract['Contract']['reference'];?></span>
            </td>
            <td class="date">
                <span>Le : <?= date("d-m-Y") ?></span>
            </td>
        </tr>
        <tr>
            <td class="modepayment">
            </td>
            <td class="droit">
                <span><strong>Doit</strong> <?= $contract['Supplier']['code']?></span><br>
                <span class="client"><?= $contract['Supplier']['name']?></span><br>
                <span class='info_client'>IF :<?= $contract['Supplier']['if'].' '?> AI :<?= $contract['Supplier']['ai'].' '?> RC :<?= $contract['Supplier']['rc'].' '?></span>
            </td>
        </tr>
    </table>
    <table class="main-table">
        <thead>
        <tr>

            <th><?php echo  __('Detail ride'); ?></th>
            <th><?php echo  __('Price HT'); ?></th>
            <th><?php echo  __('Price return'); ?></th>
            <th><?php echo __('Start date'); ?></th>
            <th><?php echo  __('End date'); ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach($contractCarTypes as $contractCarType) {?>
            <tr>

                <td> <?= $contractCarType['DepartureDestination']['name'].'-'.$contractCarType['ArrivalDestination']['name'].'-'.$contractCarType['CarType']['name']; ?></td>
                <td> <?php echo $contractCarType['ContractCarType']['price_ht'];?></td>
                <td> <?php echo $contractCarType['ContractCarType']['price_return'];?></td>
                <td><?php echo h($this->Time->format($contractCarType['ContractCarType']['date_start'], '%d-%m-%Y')); ?>&nbsp;</td>
                <td><?php echo h($this->Time->format($contractCarType['ContractCarType']['date_end'], '%d-%m-%Y')); ?>&nbsp;</td>
            </tr>
        <?php } ?>

        </tbody>
    </table>

</div>
<div id="footer">

    <p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
</div>

</body>




</html>