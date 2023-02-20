<?php
App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'autoload.inc.php'));
use Dompdf\Dompdf;
ob_start();
?>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <style type="text/css">

            <?php if (Configure::read('utranx_ade') != '1'){ ?>
            @page { margin: 95px 0; }
            #header { position: fixed; left: 0; top: -95px; right: 0; height: 110px; /*border-bottom: 1px solid #000;*/}
            <?php }else{ ?>
            @page { margin: 0px 0; }
            #header {left: 0; top: 0px; right: 0; height: 150px; /*border-bottom: 1px solid #000;*/}
            <?php } ?>
            #header td.logo{width: 300px; vertical-align: top;}
            #header td.company{vertical-align: top; font-weight: bold; font-size: 14px;text-align: center;line-height: 24px}
            #header td.company span{display: block; font-size: 22px; padding-bottom: 10px;padding-top: 20px;}
            #footer { position: fixed; left: 0; bottom: -95px; right: 0; height: 200px;  }
            .copyright{font-size:10px; text-align:center;}

            .date{padding-top: 0px; text-align:right;margin-right:25px;}
            .title{font-weight: bold; font-size: 18px;
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

            .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
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
            .total{
                width:40%;
                position:relative;
                left:55%;
                right:5%;
                border:2px solid #000;
                border-radius: 10px;
                margin-top: 60px;
            }
            .total .left{
                width:40%;
                text-align:left;
                display:inline-block;
            }
            .total .left-ct{
                width:50%;
                text-align:left;
                display:inline-block;
            }
            .total .right-ct{
                width:50%;
                text-align:left;
                display:inline-block;
            }
            .total .all-ct{
                width:50%;
                text-align:left;
                display:inline-block;
            }
            .total .right{
                width:40%;
                text-align:right;
                display:inline-block;
            }
            .box-body{padding: 0; margin: 0; width: 100%; position: relative !important;}
            .box-body2{
                position: relative !important;
            }
            .total{
                background: #fcecc7;
            }
            #header table, #informations table{
                padding:0px 50px;
            }
            .separator_section{
                border-top:2px solid :#000;
                margin:10px auto 10px;
                width:80%;

            }
            #informations{
                padding-top:10px;
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
        </style>
    </head>
    <body style="page-break-inside:avoid;">
    <?php if (Configure::read('utranx_ade') != '1'){ ?>
    <div id="header">
        <table>
            <tr>
                <td class="logo">
                    <img src="<?= WWW_ROOT ?>/logo/<?= $company['Company']['logo'] ?>" width="100px" height="100px">
                </td>
            </tr>
        </table>
    </div>
    <div id="informations">
        <table>
            <tr>
                <td class="company">
                    <span class="campany_name"><?= Configure::read("nameCompany") ?></span><br/>
                    <span><?= 'Tél. : '.$company['Company']['phone'] ?></span><br/>
                    <span><?= 'Fax : '.$company['Company']['fax'] ?></span>
                </td>
                <td class="date">
                    <?= date("d/m/Y") ?>
                </td>
            </tr>
        </table>
    </div>
        <hr class="separator_section"/>
    <?php }else{ ?>
        <div id="header" >
        <?php echo $this->element('pdf/ade-header'); ?>
        </div>
    <?php } ?>

    <div class="box-body">
        <div class="title"><?php echo __('Journal detaillé') ?></div>
        <table class='bon table-bordered tab_' >
            <thead >
            <tr>
                <th ><strong><?php echo __('Réf.'); ?></strong></th>
                <th ><strong><?php echo __('Date'); ?></strong></th>
                <th ><strong><?php echo  __('Code'); ?></strong></th>
                <th ><strong><?php echo  __('Supplier'); ?></strong></th>
                <th><strong><?php echo  __('Total HT'); ?></strong></th>
                <th><strong><?php echo  __('TVA'); ?></strong></th>
                <th><strong><?php echo  __('Total TTC'); ?></strong></th>
                <th><strong><?php echo  __('Reglement'); ?></strong></th>
                <th ><strong><?php echo  __('Amount remaining') ?></strong></th>
                <th ><strong><?php echo  __('Tranche') ?></strong></th>
                <th ><strong><?php echo  __('Date') ?></strong></th>
                <th ><strong><?php echo  __('Mode') ?></strong></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $totalTtc = 0;
            $totalTva = 0;
            $totalHt = 0;
            $reglement = 0;
            $totalReglement = 0;
            $totalAmountRemaining = 0;
            $billId =0 ;
            $i = 1;
            foreach ($bills as $bill){
                $totalTtc = $totalTtc +$bill['Bill']['total_ttc'] ;
                $totalTva = $totalTva +$bill['Bill']['total_tva'] ;
                $totalHt = $totalHt +$bill['Bill']['total_ht'] ;

                $totalAmountRemaining = $totalAmountRemaining + $bill['Bill']['amount_remaining'];
                ?>
                <?php if ($billId == $bill['Bill']['id'] && $i == 1) {
                    $i ++ ;
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?php
                            $reglement = $bill['Bill']['total_ttc'] -$bill['Bill']['amount_remaining'];
                            echo number_format($reglement, 2, ",", $separatorAmount) ?>&nbsp;</td>
                        <td><?php echo number_format($bill['Bill']['amount_remaining'], 2, ",", $separatorAmount) ;
                            $reglement = 0;
                            ?>&nbsp;</td>
                        <td><?php echo number_format($bill['DetailPayment']['payroll_amount'], 2, ",", $separatorAmount) ?>&nbsp;</td>
                        <td><?php echo h($this->Time->format($bill['Payment']['receipt_date'], '%d-%m-%Y')); ?>&nbsp;</td>
                        <td><?php   switch($bill['Payment']['payment_type']){
                               case 1:
                                        echo __('Espèce');
                                        break;
                                    case 2:
                                        echo __('Virement');
                                        break;
                                    case 3:
                                        echo __('Chèque de banque');
                                        break;
									
									case 4:
                                        echo __('Chèque');
                                        break;
										
									case 5:
                                        echo __('Traite');
                                        break;
										
									case 6:
                                        echo __('Fictif');
                                        break;

                            } ?>&nbsp;</td>
                    </tr>


               <?php  } else {

                    $billId = $bill['Bill']['id'];
                    $i =1;
                    ?>
                    <tr>
                        <td><?php echo h($bill['Bill']['reference']); ?>&nbsp;</td>
                        <td><?php echo h($this->Time->format($bill['Bill']['date'], '%d-%m-%Y')); ?>&nbsp;</td>
                        <td><?php echo h($bill['Supplier']['code']); ?>&nbsp;</td>
                        <td><?php echo h($bill['Supplier']['name']); ?>&nbsp;</td>
                        <td><?php echo number_format($bill['Bill']['total_ht'], 2, ",", $separatorAmount) ?>&nbsp;</td>
                        <td><?php echo number_format($bill['Bill']['total_tva'], 2, ",", $separatorAmount) ?>&nbsp;</td>
                        <td><?php echo number_format($bill['Bill']['total_ttc'], 2, ",", $separatorAmount) ?>&nbsp;</td>
                        <td><?php
                            $reglement = $bill['Bill']['total_ttc'] -$bill['Bill']['amount_remaining'];
                            echo number_format($reglement, 2, ",", $separatorAmount) ?>&nbsp;</td>
                        <td><?php echo number_format($bill['Bill']['amount_remaining'], 2, ",", $separatorAmount) ;
                            $reglement = 0;
                            ?>&nbsp;</td>
                        <td><?php echo number_format($bill['DetailPayment']['payroll_amount'], 2, ",", $separatorAmount) ?>&nbsp;</td>
                        <td><?php echo h($this->Time->format($bill['Payment']['receipt_date'], '%d-%m-%Y')); ?>&nbsp;</td>
                        <td><?php   switch($bill['Payment']['payment_type']){
                                case 1:
                                        echo __('Espèce');
                                        break;
                                    case 2:
                                        echo __('Virement');
                                        break;
                                    case 3:
                                        echo __('Chèque de banque');
                                        break;
									
									case 4:
                                        echo __('Chèque');
                                        break;
										
									case 5:
                                        echo __('Traite');
                                        break;
										
									case 6:
                                        echo __('Fictif');
                                        break;

                            } ?>&nbsp;</td>
                    </tr>

               <?php } ?>

            <?php }
            $totalReglement = $totalTtc - $totalAmountRemaining;
            ?>
            </tbody>

        </table>
        <div style="clear:both;"></div>
    </div>
    <div class="box-body2">
        <div class="total">
            <div class="left-ct">
                <span class="left"><strong><?php echo  __('Total TTC: '); ?></strong></span> <span class="right"> <?= number_format($totalTtc, 2, ",", $separatorAmount).' '. $this->Session->read("currency");?></span><br>
                <span class="left"><strong><?php echo  __('Total HT: '); ?></strong></span> <span class="right"> <?= number_format($totalHt, 2, ",", $separatorAmount).' '. $this->Session->read("currency");?></span><br>
                <span class="left"><strong><?php echo  __('Total TVA: '); ?></strong></span> <span class="right"> <?= number_format($totalTva, 2, ",", $separatorAmount).' '. $this->Session->read("currency");?></span><br>
            </div>
            <div class="right-ct">
                <span class="left"><strong><?php echo  __('Règlement: '); ?></strong></span> <span class="right"> <?= number_format($totalReglement, 2, ",", $separatorAmount).' '. $this->Session->read("currency");?></span><br>
                <span class="left"><strong><?php echo  __('Left to pay: '); ?></strong></span> <span class="right"> <?= number_format($totalAmountRemaining, 2, ",", $separatorAmount).' '. $this->Session->read("currency");?></span><br>
            </div>
        </div>
    </div>
    <div id="footer">

<?php if(Configure::read("gestion_commercial") == '1') { ?>
        <p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
<?php 	} else { ?>
	<p class='copyright'>Logiciel : CAFYB | www.cafyb.com</p>
<?php }	?>
    </div>
    </body>
    </html>
<?php
$html = ob_get_clean();

$this->dompdf = new Dompdf(array('chroot' => WWW_ROOT));
$papersize = "A4";
$orientation = 'landscape';
$this->dompdf->load_html($html);
$this->dompdf->set_paper($papersize, $orientation);
$this->dompdf->render('browser');

$output = $this->dompdf->output();
$name = 'Journal.pdf';
file_put_contents('./document_transport/' . $name, $output);
$urlf = './document_transport/' . $name;
if(file_exists($urlf))
{

    header('Content-Type: application/pdf');

    header('Content-disposition: inline; filename='. $name);
    header('Pragma: no-cache');
    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    header('Expires: 0');
    readfile($urlf);
    exit();

}



