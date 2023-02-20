
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <!-- Latest compiled and minified CSS -->



    <?php


    require_once(APP . 'Vendor' . DS . 'tcpdf' . DS . 'tcpdf.php');
    require_once(APP . 'Vendor' . DS . 'tcpdf' . DS . 'tcpdf_barcodes_1d.php');
    require_once(APP . 'Vendor' . DS . 'tcpdf' . DS . 'examples'.DS.'tcpdf_include.php');



    ?>
</head>
<body >


<?php



class MYPDF extends TCPDF {
    //Page header
    public function Header() {



    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
      /*   $this->SetY(-15);
         // Set font
         $this->SetFont('helvetica', 'I', 8);
         // Page number
         $this->writeHTML("<hr>", true, false, false, false, '');


         $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
*/
    }
}
header("Content-type: application/pdf");
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setCreator(PDF_CREATOR);
//$pdf->setAuthor($userth->last_name." ".$userth->first_name);
$pdf->setTitle(__('Sheet Ride'));
$pdf->AddPage('P');
$pdf->setAutoPageBreak(TRUE,PDF_MARGIN_BOTTOM);


/*********** Header & Footer ***********/

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH,"Test Title", PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

/*********** Mise en Page ***********/
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set default font subsetting mode
$pdf->setFontSubsetting(true);
/************* Heaaaader ***********/
$pdf->SetFont('aealarabiya', 'B', 12);
// Title





// set cell padding
$pdf->setCellPaddings(0,0, 0, 0);

// set cell margins
$pdf->setCellMargins(0,0, 0, 0);
$paramstrc = $pdf->serializeTCPDFtagParameters(array($sheetRide['SheetRide']['reference'], 'C39', 60, '', 50, 20, 0.4, array('position'=>'S', 'border'=>false, 'padding'=>4, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>4), 'N'));
$logo= $company['Company']['logo'];
$companyName = Configure::read("nameCompany");
$reference= $sheetRide['SheetRide']['reference'];
$date=date("d/m/Y");

$html = <<<EOF
<html>
 <style type="text/css">


			.company{ font-weight: bold;  font-size: 22px; padding-bottom : 20px}




        </style>
<span class="company">{Configure::read("nameCompany")}</span><br>
</html>
EOF;
$pdf->writeHTMLCell('280', '0', '10', '0', $html,false,false,false,false,'L');

/**********************************/

$htmlContent=ob_get_clean();

$pdf->writeHTML($htmlContent,true,0,true,0);

$html = <<<EOF

<html>


        <style type="text/css">


			.info_company{font-size:11px;padding-top: 60px;line-height:18px; }
			.info_fiscal{font-size:10px;padding-top: 60px;line-height:18px;padding-right: 5px; float: right;}
			.company{ font-weight: bold;  font-size: 22px; padding-bottom : 20px}




        </style>



            <table>
                <tr>


					<td class="info_company">

							<span class='company'>{$company['Company']['adress']}</span><br>
							<span><strong>Tél. :</strong>{$company['Company']['phone']}</span><br>
							<span><strong>Fax :</strong>{$company['Company']['fax']}</span><br>
							<span><strong>Mobile :</strong>{$company['Company']['mobile']}</span>
                    </td>

                    <td class="info_fiscal">
							<span style='font-weight:bold;'><strong >RC :</strong>{$company['Company']['rc']  }</span><br>
							<span><strong>AI :</strong>{$company['Company']['ai'] }</span><br>

							<span><strong>NIF :</strong>{$company['Company']['nif'] }</span><br>
							<span><strong>Compte :</strong>{$company['Company']['cb'] }</span>
                    </td>


                </tr>
            </table>

</html>





EOF;


$pdf->writeHTMLCell('190', '0', '10', '10', $html,false,false,false,false,'L');

/**********************************/

$htmlContent=ob_get_clean();

$pdf->writeHTML($htmlContent,true,0,true,0);

$html = <<<EOF
<html>
<div style='border-bottom: 3px solid #000;'> </div>
</html>
EOF;


$pdf->writeHTMLCell('190', '0', '10', '10', $html,false,false,false,false,'L');

/**********************************/

$htmlContent=ob_get_clean();

$pdf->writeHTML($htmlContent,true,0,true,0);


/*$htmltrc = '<table><tr>
<td><tcpdf  method="write1DBarcode" params="'.$paramstrc.'" /></td>


</tr></table>';

$pdf->writeHTMLCell(0, 0, '80', '5', $htmltrc,false,false,false,false,'L');

/**********************************/

$htmlContent=ob_get_clean();

$pdf->writeHTML($htmlContent,true,0,true,0);


$html = <<<EOF




EOF;

$pdf->setCellMargins(50,50, 50, 50);
$pdf->writeHTMLCell(0, 0, '80', '5', $html,false,false,false,false,'L');

/**********************************/

$htmlContent=ob_get_clean();

$pdf->writeHTML($htmlContent,true,0,true,0);








$pdf->Output('ffff','I');

?>
</body>
</html>