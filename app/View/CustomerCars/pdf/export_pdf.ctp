<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style type="text/css">
            @page { margin: 95px 0px; }
            #header { position: fixed; left: 0px; top: -95px; right: 0px; height: 110px; border-bottom: 1px solid #000;}
            #header td.logo{width: 300px; vertical-align: top;}
            #header td.company{vertical-align: top; font-weight: bold; font-size: 16px;text-align: center;}
            #header td.company span{display: block; font-size: 22px; padding-bottom: 10px;padding-top: 20px;}
            #footer { position: fixed; left: 0px; bottom: -95px; right: 0px; height: 100px;  }
            .box-body{padding: 0px; margin: 0; width: 100%;}
            .ref{padding-top: 25px}
            .date{padding-top: 5px;}
            .title{font-weight: bold; font-size: 24px; 
                  text-align: center; 
                  padding-top: 40px;
                  border-bottom: 1px solid #000;
                  width: 230px;
                  margin: 0 auto;
                  margin-bottom: 30px;
                  font-style: italic;
            }
            .customer table {
                border-collapse: collapse;
                width: 100%;
                font-size: 18px;
            }
            .customer tr td:first-child{ 
                width: 250px !important; 
                font-weight: bold;
                padding-bottom: 10px;
                
            }
            table.bottom{margin-top: 40px; width: 100%; margin-bottom: 40px; font-style: italic;}
            div.resp{font-size: 18px; 
                 border-bottom: 1px solid #000;
                 width: 280px;
                 margin-left: 530px;
                 font-style: italic;
                 font-weight: bold;
            }
            table.bottom td{padding-top: 5px; font-size: 18px;}
            table.footer{width: 100%; font-size: 12px; margin-top: 20px;padding-top: 10px;border-top: 1px solid #690008;}
            table.footer td.first{width: 50%; text-align: left}
            table.footer td.second{width: 50%; text-align: left;}
            table.conditions td{
                border: 1px solid grey;
            }
            table.conditions td{
                vertical-align: top;
                padding-left: 10px;
                padding-right: 5px;
                padding-top: 5px;
                padding-bottom: 5px;
                line-height: 19px;
            }
            table.conditions_bottom td.first{width: 420px}
            table.conditions_bottom td{padding-top: 5px}
            .note span{display: block;text-decoration: underline;padding-bottom: 5px;}
        </style>
    </head>
    <body>
        <div id="header">
            <table>
                <tr>
                    <td class="logo">
                        <?php if(!empty($company['Company']['logo']) && file_exists( WWW_ROOT .'/logo/'. $company['Company']['logo'])) {?>
                            <img src="<?= WWW_ROOT ?>/logo/<?= $company['Company']['logo'] ?>" width="180px" height="120px">
                        <?php }else { ?>
                            <img  width="180px" height="120px">
                        <?php } ?>
                    </td>
                    <td class="company">
                         <span><?= Configure::read("nameCompany") ?></span>
                        <?php if(!empty($company['Company']['social_capital'])){ ?>
                       <?= $company['LegalForm']['name'] ?>
                au Capital de <?= number_format($company['Company']['social_capital'],2,",",".") ?>
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="box-body">
            <div class="ref">REF N� : <?= $customerCar['CustomerCar']['reference'] ?></div>
            <div class="date">DATE : <?= date("d-m-Y") ?></div>
            <div style="clear: both"></div>
            <div class="title">ORDRE DE MISSION</div>
            <div class="customer">
                <table>
                    <tr>
                        <td>&nbsp;Nom : </td>
                        <td>&nbsp;<?= $customerCar['Customer']['first_name']?> </td>
                    </tr>
                    <tr>
                        <td>&nbsp;Pr�nom :</td>
                        <td>&nbsp;<?= $customerCar['Customer']['last_name']?> </td>
                    </tr>
                    <tr>
                        <td> &nbsp;Fonction : </td>
                        <td> &nbsp;<?= $customerCar['Customer']['job']?></td>
                    </tr>
                    <tr>
                        <td> &nbsp;N� permis de conduire : </td>
                        <td> &nbsp;<?= $customerCar['Customer']['driver_license_nu']?></td>
                    </tr>
                    <tr>
                        <td> &nbsp;D�livr� le : </td>
                        <td> &nbsp;<?= $this->Time->format($customerCar['Customer']['driver_license_date'], '%d-%m-%Y')?></td>
                    </tr>
                    <tr>
                        <td> &nbsp;Par : </td>
                        <td> &nbsp;<?= $customerCar['Customer']['driver_license_by']?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Objet de la mission : </td>
                        <td>&nbsp;<b><?= $customerCar['CustomerCar']['obs']?></b> </td>
                    </tr>
                    <tr>
                        <td>&nbsp;Lieu de d�part : </td>
                        <td>&nbsp;<?= $customerCar['CustomerCar']['departure_location']?> </td>
                    </tr>
                    <tr>
                        <td>&nbsp;Lieu de retour : </td>
                        <td>&nbsp;<?= $customerCar['CustomerCar']['return_location']?> </td>
                    </tr>
                    <tr>
                        <td>&nbsp;Date et heure de d�part : </td>
                        <td>&nbsp;<?= $this->Time->format($customerCar['CustomerCar']['start'], '%d-%m-%Y %H:%M')?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Date et heure de retour : </td>
                        <td>&nbsp;<?= $this->Time->format($customerCar['CustomerCar']['end'], '%d-%m-%Y %H:%M')?> </td>
                    </tr>
                    <tr>
                        <td>&nbsp;V�hicule : </td>
                        <td>&nbsp;<?= $customerCar['Car']['Carmodel']['name'] . " ".
                                      $customerCar['Car']['code'] ?> </td>
                    </tr>
                    <tr>
                        <td>&nbsp;Immatricule : </td>
                        <td>&nbsp;<?php if(!empty($customerCar['Car']['immatr_def'])){
                                            echo $customerCar['Car']['immatr_def'];
                                        }else{
                                            echo $customerCar['Car']['immatr_prov'];
                                        }
                                  ?></td>
                    </tr>
                </table>
            </div>
            <table class="bottom">
                <tr>
                    <td colspan="2">
                        Le pr�sent ordre de mission leur est d�livr� pour leur faciliter la tache aupr�s des autorit�s comp�tentes.
                    </td>
                </tr>
            </table>
            <div class="resp">Le responsable logistique</div>
        </div>
        <div id="footer">
                <table class="footer">
                    <tr>
                        <td class="first">
                <?= $company['LegalForm']['name'] ?>
                            <?php if(!empty($company['Company']['social_capital'])){ ?>
                            au Capital de <?=
                                      number_format($company['Company']['social_capital'],2,",",".")." ".$this->Session->read('currency')
                                          ?>
                            <?php }else{?>
                                <?= Configure::read("nameCompany") ?>
                            <?php } ?>
                              - RC : <?= $company['Company']['rc'] ?>
                        </td>
                        <td class="second">
                <?= $company['Company']['adress'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="first">
                            AI : <?= $company['Company']['ai'] ?> - IF : <?= $company['Company']['nif'] ?>
                        </td>
                        <td class="second">
                            Tél. : <?= $company['Company']['phone'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="first">
                            CB : <?= $company['Company']['cb'] ?> RIB : <?= $company['Company']['rib'] ?>
                        </td>
                        <td class="second">
                            Mobile : <?= $company['Company']['mobile'] ?>
                        </td>
                    </tr>
                </table>
            </div>
    </body>
</html>