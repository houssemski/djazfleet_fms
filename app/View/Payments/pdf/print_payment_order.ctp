<?php
/**
 * @var array $payment
 */
App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'autoload.inc.php'));
App::import('Vendor', 'ar-php-master', array('file' => 'ar-php-master' . DS . 'src' . DS . 'Arabic.php'));

use Dompdf\Dompdf;
use ArPHP\I18N\Arabic;

ob_start();

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <style type="text/css">

        @page {
            margin: 20px 20px 20px 20px;
            font-family: 'DejaVu Sans'
        }

        #bank-logo {
            text-align: center;
        }

        .title-ar {
            margin-bottom: 0px
        }

        .title-fr {
            margin-top: 0px
        }

        #title {
            text-align: center;
            color: #91AF4D;
        }

        .text-align-right {
            text-align: right;
        }
        .text-align-left {
            text-align: left;
        }

        .text-align-center {
            text-align: center;
        }

        #date {
            vertical-align: text-top;
        }

        .payment-info {
            border: solid 1px #5f7135;
            border-collapse: collapse;
        }

        .th-fr {
            background-color: #91AF4D;
            text-align: left;
            font-size: 12px;
            font-weight: none;
        }

        .th-ar {
            background-color: #91AF4D;
            text-align: right;
            font-size: 12px;
            font-weight: none;
        }

        .table-body {
            font-size: 12px;
            font-weight: none;
        }

        .blank {
            color: white;
        }

        .payment-number-td {
            border-left: solid 1px #5f7135;
            border-bottom: solid 1px #5f7135;
        }

        .payment-number-td-bottom{
            border-bottom: solid 1px #5f7135;
        }

        .last-payment-number-td {
            border-left: solid 1px #5f7135;
            border-right: solid 1px #5f7135;
            border-bottom: solid 1px #5f7135;
        }

        .last-payment-number-td2{
            border-right: solid 1px #5f7135;
            border-bottom: solid 1px #5f7135;
        }

        .numbers-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            text-align: center;
        }

        .margin-bottom-0{
            margin-bottom: 0px;
        }
        .margin-top-0{
            margin-top: 0px;
        }
        .square{
            border: solid 1px #5f7135;
           font-size: 20px;
        }
        .container-t{
            padding: 0px 0px 0px 0px;
        }

    </style>
</head>
<body style="page-break-inside:avoid;">
<div id="bank-logo">
    <img src='<?= WWW_ROOT ?>img\banks-logos\logo-agb.png'>
    <br>
</div>
<div>
    <table width="100%">
        <tr>
            <td width="30%"><p> Agence : ........ </p></td>
            <td width="60%">
                <div id="title">
                    <h1 class="title-ar"> أمر بالتحويل </h1>
                    <h1 class="title-fr"> ORDRE DE VIREMENT </h1>
                </div>
            </td>
            <td class="text-align-right" width="20%">....... : الوكالة</td>
        </tr>
        <tr>
            <td width="20%"></td>
            <td width="50%"></td>
            <td id="date" class="text-align-right" width="30%">DATE : <?= date('d/m/y'); ?> : التاريخ</td>
        </tr>
    </table>
</div>
<br>
<div>
    <table class="payment-info" width="100%">
        <thead>
        <th class="th-fr"> Donneur d'ordre</th>
        <th class="th-ar">الأمر بالتحويل</th>
        </thead>
        <tbody class="table-body">
        <tr>
            <td colspan="2">Nom et Prénom / Raison sociale :
                ...............................................................................................................................
                : الاسم و اللقب
            </td>
        </tr>
        <tr>
            <td class="blank" colspan="2">BLANK</td>
        </tr>
        <tr>
            <td colspan="2">Adresse :
                ..............................................................................................................................................................................
                : العنوان
            </td>
        </tr>
        <tr>
            <td colspan="2">
                ..........................................................................................................................................................................................................
            </td>
        </tr>
        <tr>
            <td class="blank" colspan="2">BLANK</td>
        </tr>
        </tbody>
    </table>
</div>
<br>
<div>
    <table width="100%" class="payment-info table-body">
        <tr>
            <td width="30%">Par le débit de mon compte</td>
            <td class="text-align-center"></td>
            <td class="text-align-right">بالخصم من حسابي</td>
        </tr>
        <tr>
            <td width="15%">Numéro:</td>
            <td width="70%" class="text-align-center">
                <table class="numbers-table">
                    <tr>
                        <td class="payment-number-td"><?= $payment[0]['Payment']['number_payment'][0] ?></td>
                        <td class="payment-number-td"><?= $payment[0]['Payment']['number_payment'][1] ?></td>
                        <td class="payment-number-td"><?= $payment[0]['Payment']['number_payment'][2] ?></td>
                        <td class="payment-number-td"><?= $payment[0]['Payment']['number_payment'][3] ?></td>
                        <td class="payment-number-td"><?= $payment[0]['Payment']['number_payment'][4] ?></td>
                        <td class="payment-number-td"><?= $payment[0]['Payment']['number_payment'][5] ?></td>
                        <td class="payment-number-td"><?= $payment[0]['Payment']['number_payment'][6] ?></td>
                        <td class="payment-number-td"><?= $payment[0]['Payment']['number_payment'][7] ?></td>
                        <td class="payment-number-td"><?= $payment[0]['Payment']['number_payment'][8] ?></td>
                        <td class="last-payment-number-td"><?= $payment[0]['Payment']['number_payment'][9] ?></td>
                        <td class="blank">B</td>
                        <td class="payment-number-td"><?= $payment[0]['Payment']['number_payment'][10] ?></td>
                        <td class="last-payment-number-td"><?= $payment[0]['Payment']['number_payment'][11] ?></td>
                    </tr>
                </table>
            </td>
            <td width="15%" class="text-align-right">رقم:</td>
        </tr>
    </table>
    <br>
    <?php
    $f = new NumberFormatter("fr", NumberFormatter::SPELLOUT);
    $temporaryTtc = explode('.', number_format($payment[0]['Payment']['amount'], 2, '.', ' '));
    if (isset($temporaryTtc[1]) && $temporaryTtc[1] > 0) {
        $ttcToLetters =
            $f->format(str_replace(' ', '', $temporaryTtc[0])) . ' ' . 'Dinars ' . ' ' .
            __('and') . ' ' . ucwords($f->format(str_replace(' ', '', $temporaryTtc[1]))) .
            ' ' . __('cents');
    } else {
        $ttcToLetters = $f->format(str_replace(' ', '', $temporaryTtc[0])) . ' ' . 'Dinars ';
    }
    ?>
    <div>
        <table width="100%" class="payment-info table-body">
            <tr>
                <td width="30%">Veuillez virer la somme de</td>
                <td class="text-align-center"></td>
                <td class="text-align-right">يرجى تحويل مبلغ</td>
            </tr>
            <tr>
                <td width="30%">Monnaie:  <strong><?= $payment[0]['Payment']['amount'] ?> DA</strong> </td>
                <td class="text-align-center">Montant  <strong><?= $payment[0]['Payment']['amount'] ?></strong></td>
                <td class="text-align-right">بالأرقام:</td>
            <tr>
                <td width="30%">En lettres:</td>
                <td class="text-align-center"> <strong><?= $ttcToLetters ?></strong> </td>
                <td class="text-align-right">بالحروف:</td>
            </tr>
            <tr>
                <td colspan="3" class="blank">blank:</td>
            </tr>
        </table>
    </div>
    <div>
        <table width="100%" class="table-body">
            <tr>
                <td width="17%">
                    <p class="margin-bottom-0">وضع تحت تصرف</p>
                    <p class="margin-top-0">Mise à disposition</p>
                </td>
                <td class="text-align-left">
                     <span class="square blank">
                        Be
                    </span>
                </td>
                <td class="text-align-right">
                    <span class="square blank">
                        Be
                    </span>
                </td>
                <td width="10%" class="text-align-right">
                    <p class="margin-bottom-0">تحويل</p>
                    <p class="margin-top-0">Virement</p>
                </td>
            </tr>
        </table>
    </div>
    <div>
        <table class="payment-info" width="100%">
            <thead>
            <tr>
                <th class="th-fr"> En faveur de</th>
                <th  class="th-fr"></th>
                <th class="th-ar">لفائدة</th>
            </tr>

            </thead>
            <tbody class="table-body">
            <tr>
                <td width="27%">Nom et Prénom / Raison sociale :</td>
                <td class="text-align-center"> <strong><?= $payment[0]['Suppliers']['name'] ?></strong> </td>
                <td width="15%" class="text-align-right">
                    : الاسم و اللقب
                </td>
            </tr>
            <tr>
                <td>Adresse :</td>
                <td class="text-align-center"> <strong><?= $payment[0]['Suppliers']['adress'] ?></strong> </td>
                <td class="text-align-right">
                    : العنوان
                </td>
            </tr>
            <tr>
                <td>Banque :</td>
                <td></td>
                <td class="text-align-right">
                    : بنك
                </td>
            </tr>
            <tr>
                <td>Agence :</td>
                <td></td>
                <td class="text-align-right">
                    : وكالة
                </td>
            </tr>
            <tr>
                <td>RIB :</td>
                <td>
                    <table class="numbers-table">
                        <tr>
                            <td class="payment-number-td"><?= $payment[0]['Suppliers']['cb'][0] ?></td>
                            <td class="payment-number-td-bottom"><?= $payment[0]['Suppliers']['cb'][1] ?></td>
                            <td class="payment-number-td-bottom"><?= $payment[0]['Suppliers']['cb'][2] ?></td>
                            <td class="payment-number-td-bottom"><?= $payment[0]['Suppliers']['cb'][3] ?></td>
                            <td class="payment-number-td-bottom"><?= $payment[0]['Suppliers']['cb'][4] ?></td>
                            <td class="payment-number-td-bottom"><?= $payment[0]['Suppliers']['cb'][5] ?></td>
                            <td class="payment-number-td"><?= $payment[0]['Suppliers']['cb'][6] ?></td>
                            <td class="payment-number-td-bottom"><?= $payment[0]['Suppliers']['cb'][7] ?></td>
                            <td class="payment-number-td-bottom"><?= $payment[0]['Suppliers']['cb'][8] ?></td>
                            <td class="payment-number-td-bottom"><?= $payment[0]['Suppliers']['cb'][9] ?></td>
                            <td class="payment-number-td"><?= $payment[0]['Suppliers']['cb'][10] ?></td>
                            <td class="payment-number-td-bottom"><?= $payment[0]['Suppliers']['cb'][11] ?></td>
                            <td class="payment-number-td-bottom"><?= $payment[0]['Suppliers']['cb'][12] ?></td>
                            <td class="payment-number-td-bottom"><?= $payment[0]['Suppliers']['cb'][13] ?></td>
                            <td class="payment-number-td-bottom"><?= $payment[0]['Suppliers']['cb'][14] ?></td>
                            <td class="payment-number-td-bottom"><?= $payment[0]['Suppliers']['cb'][15] ?></td>
                            <td class="payment-number-td"><?= $payment[0]['Suppliers']['cb'][16] ?></td>
                            <td class="last-payment-number-td2"><?= $payment[0]['Suppliers']['cb'][17] ?></td>
                            <td class="blank">B</td>
                            <td class="payment-number-td"><?= $payment[0]['Suppliers']['cb'][18] ?></td>
                            <td class="last-payment-number-td"><?= $payment[0]['Suppliers']['cb'][19] ?></td>
                        </tr>
                    </table>
                </td>
                <td class="text-align-right">
                    : حساب رقم
                </td>
            </tr>
            <tr>
                <td colspan="3" class="blank">
                    blank
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <br>
    <div>
        <table class="container-t" width="100%">
            <td width="50%">
                    <table class="payment-info" width="100%">
                        <thead>
                        <tr>
                            <th class="th-fr"> Visa de l'éxécuteur</th>
                            <th  class="th-fr"></th>
                            <th class="th-ar">تأشيرة المنفذ</th>
                        </tr>

                        </thead>
                        <tbody class="table-body">
                        <tr>
                            <td colspan="3" class="blank">
                                blank
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="blank">
                                blank
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="blank">
                                blank
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="blank">
                                blank
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="blank">
                                blank
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="blank">
                                blank
                            </td>
                        </tr>

                        </tbody>
                    </table>
            </td>
            <td width="50%">
                <table class="payment-info" width="100%">
                    <thead>
                    <tr>
                        <th class="th-fr"> Signature du donneur d'ordre</th>
                        <th  class="th-fr"></th>
                        <th class="th-ar">امضاءالأمر</th>
                    </tr>

                    </thead>
                    <tbody class="table-body">
                    <tr>
                        <td colspan="3" class="blank">
                            blank
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="blank">
                            blank
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="blank">
                            blank
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="blank">
                            blank
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="blank">
                            blank
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="blank">
                            blank
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>

        </table>
    </div>
</div>

<div>

</div>

</body>
</html>




