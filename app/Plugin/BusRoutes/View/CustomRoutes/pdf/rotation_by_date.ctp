<?php
/**
 * @var array $checkPointsArray
 */
?>


<style>
    .center{
        margin: auto;
    }

    .title-container{
        width: 100%;
        text-align: center;
    }

    #table{
        width: 100%;
        font-weight: normal;
        border-collapse: collapse;
        border: 1px solid black;
    }

    .td{
        border: 1px solid black;
        text-align: center;
    }

    .th{
        border: 1px solid black;
        background-color: #B8B8B8;
    }
</style>


<div class="title-container" >
    <h1 >Rotations par date</h1>
</div>


<?php foreach ($checkPointsArray as $rotation){ ?>
    <table id="table">
        <thead>
        <tr class="tr">
            <th class="th">Arrét</th>
            <th class="th">Temp d'arrivé prévu</th>
            <th class="th">Temp d'arrivé réel</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rotation as $item){ ?>
            <tr>
                <td class="td"> <?= $item['stop_name'] ?> </td>
                <td class="td"> <?= isset($item['expected_arrival_time']) ? $item['expected_arrival_time'] : '' ?> </td>
                <td class="td"> <?= $item['arrival_time'] ?> </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <br>

<?php } ?>
