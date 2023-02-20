<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
        @page { margin: 10px 0px; }
        #footer { position: fixed; left: 0px; bottom: -95px; right: 0px; height: 25px;  }
        .copyright{font-size:10px; text-align:center;}
        .box-body{padding: 0px; margin-right: 10px; width: 100%;}

        .title{font-weight: bold; font-size: 24px;
            text-align: center;
            padding-top: 10px;
            border-bottom: 1px solid #000;
            width: 500px;
            margin: 0 auto;
            margin-bottom: 30px;
            font-style: italic;
            padding-bottom:20px;
        }
        .titre_tab {
            padding-right: auto;
            padding-left:5px;

            width:100px;
            height:30px;
        }
        .td_tab {
            padding-right: auto;
            padding-left:5px;

            width:100px;
            height:30px;
        }
        .table-bordered {
            margin: 0 auto;
            border: 1px solid #DDD;
        }
        .table {
            font-size: 14px;
        }
        table {
            padding-top:20px;
            border-spacing: 0px;
            border-collapse: collapse;
        }
        .table-bordered > thead > tr > th,
        .table-bordered > tbody > tr > th,
        .table-bordered > tfoot > tr > th,
        .table-bordered > thead > tr > td,
        .table-bordered > tbody > tr > td,
        .table-bordered > tfoot > tr > td {
            border: 1px solid #DDD;
            padding: 10px;
        }

    </style>
</head>
<body>
<div id="header">
    <div class="title">Détail des ateliers </div>
</div>

<div class="box-body">
    <div style="clear: both"></div>


    <table class="table table-bordered cars">
        <thead>
        <tr>
            <th>Véhicule</th>
            <th>Mecanicien</th>
            <th>Atelier</th>
            <th class='dtm'>Date entrée atelier</th>
            <th class='dtm'>Date sortie atelier</th>
        </tr>

        </thead>




        <tbody>

        <?php
        if(!empty($results)){
            $allDiffDays = 0;
            $carId = $results[0]['car']['id'];
            $carName = $results[0]['car']['immatr_def'] .' - '. $results[0]['carmodels']['name'];
            foreach ($results as $result){
                if($carId == $result['car']['id']){
                    $firstDate  = new DateTime($result['event']['workshop_entry_date']);
                    $secondDate = new DateTime($result['event']['workshop_exit_date']);
                    $interval = $firstDate->diff($secondDate);
                    $diffDays = $interval->days ;
                    $allDiffDays = $allDiffDays + $diffDays;
                    ?>
                    <tr>
                        <td><?= $result['car']['immatr_def'] .' - '. $result['carmodels']['name']?></td>
                        <td><?= $result['customers']['first_name'] .' - '.$result['customers']['last_name'] ?></td>
                        <td><?= $result['workshops']['name']?></td>
                        <td><?= $this->Time->format($result['event']['workshop_entry_date'], '%d-%m-%Y')?></td>

                        <td><?= $this->Time->format($result['event']['workshop_exit_date'], '%d-%m-%Y')?></td>

                    </tr>

                <?php }else {
                    echo "<tr style='width: auto; height: 200px'>" .
                        "<td colspan='5' style=' font-weight:bold; text-align: center'>"
                        .$carName .' '.  __('total downtime') .' ' . $allDiffDays . ' '.__('Days')."</td></tr>";
                    $carId = $result['car']['id'];
                    $carName = $result['car']['immatr_def'] .' - '. $result['carmodels']['name'];
                    $allDiffDays = 0;

                    $firstDate  = new DateTime($result['event']['workshop_entry_date']);
                    $secondDate = new DateTime($result['event']['workshop_exit_date']);
                    $interval = $firstDate->diff($secondDate);
                    $diffDays = $interval->days ;
                    $allDiffDays = $allDiffDays + $diffDays;
                    ?>
                    <tr>
                        <td><?= $result['car']['immatr_def'] .' - '. $result['carmodels']['name']?></td>
                        <td><?= $result['customers']['first_name'] .' - '.$result['customers']['last_name'] ?></td>
                        <td><?= $result['workshops']['name']?></td>
                        <td><?= $this->Time->format($result['event']['workshop_entry_date'], '%d-%m-%Y')?></td>

                        <td><?= $this->Time->format($result['event']['workshop_exit_date'], '%d-%m-%Y')?></td>

                    </tr>


                <?php         }

            }
            echo "<tr style='width: auto; height: 200px'>" .
                "<td colspan='5' style='font-weight:bold; text-align: center'>"
                .$carName .' '.  __('total downtime') .' ' . $allDiffDays . ' '.__('Days')."</td></tr>";
        }


        ?>


        </tbody>

    </table>


</div>
<div id="footer">
    <p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
</div>
</body>
</html>