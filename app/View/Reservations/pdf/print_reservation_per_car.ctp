<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
        <?php if (Configure::read('utranx_ade') != '1'){ ?>
        @page { margin: 95px 0; }
        #header { position: fixed; left: 0; top: -95px; right: 0; height: 110px; /*border-bottom: 1px solid #000;*/}
        <?php }else{ ?>
        @page { margin: 0px 0; }
        #header {left: 0; top: -95px; right: 0; height: 150px; /*border-bottom: 1px solid #000;*/}
         <?php }   ?>
        #header td.logo{width: 300px; vertical-align: top;}
        #header td.company{vertical-align: top; font-weight: bold; font-size: 16px;text-align: center;}
        #header td.company span{display: block; font-size: 22px; padding-bottom: 10px;padding-top: 20px;}
        #footer { position: fixed; left: 0; bottom: -95px; right: 0; height: 200px;  }
        .copyright{font-size:10px; text-align:center;}
        .box-body{padding: 0; margin: 0; width: 100%;}
        .ref{padding-top: 0px; text-align:center;padding-bottom:10px;}
        .date{padding-top: 0px; text-align:right;margin-right:25px;}
        .title{font-weight: bold; font-size: 18px;
            text-align: center;
            padding-top: 5px;
            /* border-bottom: 1px solid #000;*/
            width: 500px;
            margin: 0 auto 10px;

        }
        .tab_{
            margin-bottom:10px;

        }
        .name{
            font-weight: bold;
        }
        .customer table {
        / border-collapse: collapse;
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

        }

        .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
            border: 1px solid #000;
        }

        .table-bordered th {
            font-weight:normal;
            padding:5px 13.4px 5px 13.4px;

            font-size:13px;
        }
        .tab_cons th{
            padding:5px 31px 5px 31px;

        }
        .tab_cons {
            margin-bottom:25px;
        }
        .tab_total th{
            padding:5px 19.4px 5px 19.4px;

        }
        .bon{margin-bottom:10px; margin-top: 80px}
        .table-bordered td {
            text-align:center;
            font-size:13px;
        }

        .nb{
            margin-left: 40px;
            margin-right: 40px;
            margin-bottom:15px;
        }
        .nm{
            margin-left: 120px;
            margin-right: 50px;
            margin-bottom:10px;
            font-weight: bold;
        }
        .marque{
            margin-left: 40px;
            margin-right: 40px;
            margin-bottom:5px;

        }
        .customer tr td:first-child{
            width: 250px !important;

            padding-bottom: 2px;

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
            padding: 5px 5px 5px 10px;
            line-height: 19px;
        }
        table.conditions_bottom td.first{width: 420px}
        table.conditions_bottom td{padding-top: 5px}
        .note span{display: block;text-decoration: underline;padding-bottom: 5px;}
        .sig{
            margin-top: 5px;
        }
        .par {
            margin-left: 400px;
        }
        .signa {
            margin-left: 400px;
            padding-bottom : 0px;
        }
        .important{
            width:700px;
            padding: 20px;
            margin: 0 auto;
            border: 1px solid #000;

        }
        .imp {
            font-weight: bold;
        }
        .titre {
            font-weight: bold;
        }

        .total{width:250px;position:relative;float:right; left:520px;border:2px solid #000;border-radius: 10px;}
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
    </style>
</head>
<body>
<div id="header">
    <?php if (Configure::read('utranx_ade') != '1'){ ?>
    <table>
        <tr>
            <td class="logo">
                <img src="<?= WWW_ROOT ?>/logo/<?= $company['Company']['logo'] ?>" width="100px" height="100px">
            </td>
            <td class="company">
                <span><?= Configure::read("nameCompany") ?></span>

            </td>
        </tr>
    </table>
    <?php }else{
        echo $this->element('pdf/ade-header');
    } ?>
</div>
<div class="box-body">

    <div class="date"> <?= date("d/m/Y") ?></div>
    <div style="clear: both"></div>
    <div class="title"><?php echo __('Reservation per car') ?></div>
    <table class='bon table-bordered tab_' >
        <thead >
        <tr>
            <th ><strong><?php echo __('Car'); ?></strong></th>
            <th ><strong><?php echo  __('Supplier'); ?></strong></th>
            <th ><strong><?php echo __('Cost'); ?></strong></th>
            <th ><strong><?php echo  __('Amount remaining') ?></strong></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $costCar = 0;
        $amountRemainingCar = 0;
        $carId = $reservations[0]['Reservation']['car_id'];
        $nbReservation = count ($reservations);
        $totalCost = 0;
        $totalAmountRemaining = 0;
        $i = 0;
        foreach($reservations as $reservation){
            $i++;


                $costCar = $costCar + $reservation['Reservation']['cost'];
                $amountRemainingCar = $amountRemainingCar + $reservation['Reservation']['amount_remaining'];
                $totalCost = $totalCost + $reservation['Reservation']['cost'];
                $totalAmountRemaining = $totalAmountRemaining +  $reservation['Reservation']['amount_remaining'];

            ?>
            <tr>
                <td> <?php if ($param==1){
                        echo $reservation['Car']['code']." - ".$reservation['Carmodel']['name'];
                    } else if ($param==2) {
                        echo $reservation['Car']['immatr_def']." - ".$reservation['Carmodel']['name'];
                    } ?></td>
                <td><?php echo $reservation['Supplier']['name'] ;?></td>
                <td><?php echo number_format($reservation['Reservation']['cost'], 2, ",", $separatorAmount) ?></td>
                <td><?php echo number_format($reservation['Reservation']['amount_remaining'], 2, ",", $separatorAmount) ?></td>

            </tr>
            <?php

            if($i<$nbReservation){
              if($carId != $reservations[$i]['Car']['id']) { ?>
                  <tr>
                      <td style ='padding: 10px 5px 10px 70%; text-align: left;'colspan="4" >
                          <span  style ='display: inline-block; width: 50%;'><strong><?php echo  __('Car cost: '); ?></strong></span>
                          <span class="right"> <?= number_format($costCar, 2, ",", $separatorAmount).' '. $this->Session->read("currency");?></span>
                          <br/>
                          <span  style ='display: inline-block; width: 50%;'> <strong><?php echo  __('Left to pay: '); ?></strong></span>
                          <span>  <?php echo number_format($amountRemainingCar, 2, ",", $separatorAmount) .' '. $this->Session->read("currency");?></span>
                      </td>
                  </tr>
                  <?php

                  $carId = $reservation['Car']['id'];
                  $costCar = 0;
                  $amountRemainingCar = 0;
                  ?>

              <?php    }

            }else { ?>
                <tr>
                    <td style ='padding: 10px 5px 10px 70%; text-align: left;'colspan="4" >
                        <span  style ='display: inline-block; width: 50%;'><strong><?php echo  __('Car cost: '); ?></strong></span>
                        <span class="right"> <?= number_format($costCar, 2, ",", $separatorAmount).' '. $this->Session->read("currency");?></span>
                        <br/>
                        <span  style ='display: inline-block; width: 50%;'> <strong><?php echo  __('Left to pay: '); ?></strong></span>
                        <span>  <?php echo number_format($amountRemainingCar, 2, ",", $separatorAmount) .' '. $this->Session->read("currency");?></span>
                    </td>
                </tr>
               <?php

                $carId = $reservation['Reservation']['car_id'];
                $costCar = 0;
                $amountRemainingCar = 0;
                ?>
          <?php  }


           } ?>
        </tbody>

    </table>
    <div class="total">
        <span class="left"><strong><?php echo  __('Total cost: '); ?></strong></span> <span class="right"> <?= number_format($totalCost, 2, ",", $separatorAmount).' '. $this->Session->read("currency");?></span><br>
        <span class="left"><strong><?php echo  __('Left to pay: '); ?></strong></span> <span class="right"> <?= number_format($totalAmountRemaining, 2, ",", $separatorAmount).' '. $this->Session->read("currency");?></span><br>

    </div>






</div>
<div id="footer">


    <p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
</div>
</body>
</html>