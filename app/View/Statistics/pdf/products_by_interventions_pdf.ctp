<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
        @page { margin: 10px 0px; }
        #footer { position: fixed; left: 0px; bottom: -95px; right: 0px; height: 25px;  }
        .copyright{font-size:10px; text-align:center;}
        .box-body{padding: 0px; margin-right: 10px;margin-left: 10px; width: 100%;}
        .title{
            font-weight: bold; font-size: 24px;
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
        .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
            border: 1px solid #DDD;
        }
    </style>
</head>
<body>
<div id="header">
    <div class="title">Détail des interventions </div>
</div>

<div class="box-body">
    <div style="clear: both"></div>


    <table class="table table-bordered cars">
        <thead>
        <tr>
            <th> Reference</th>
            <th>Type</th>
            <th>Date</th>
            <th>Véhicule</th>
            <th>Demandeur</th>
            <th>Structure</th>
            <th>Fournisseur</th>
            <th>Produit</th>
            <th>Prix unitaire</th>
            <th> Quantité</th>
            <th> Prix </th>
        </tr>

        </thead>




        <tbody>

        <?php
        if(!empty($results)){
            foreach ($results as $result){ ?>
                <tr>
                    <td><?= $result['event']['code'];?></td>
                    <td><?= $result['event_types']['name']?></td>
                    <td><?= $this->Time->format($result['event']['intervention_date'], '%d-%m-%Y')?></td>
                    <td><?= $result['car']['immatr_def'] .' - '. $result['carmodels']['name']?></td>
                    <td><?= $result['customers']['first_name'] .' - '.$result['customers']['last_name'] ?></td>
                    <td><?= $result['structures']['name']?></td>
                    <td><?= $result['suppliers']['name']?></td>
                    <td><?= $result['products']['name']?></td>
                    <td><?= number_format($result['event_products']['price']/2, 0, ",", ".")?></td>
                    <td><?= $result['event_products']['quantity'] ?></td>
                    <td><?= number_format($result['event_products']['price'], 0, ",", ".")?></td>
                </tr>

            <?php }
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