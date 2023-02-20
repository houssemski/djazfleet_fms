<?php

App::import('Model', 'Observation');
$this->Observation = new Observation();
?>

<style>
    .form-control-ajax {
    / / border-radius : 4 px;
    }
</style>
<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
    <tr>

        <th><?php echo __('Reference'); ?></th>
        <th><?php echo __('Transportation'); ?></th>
        <th><?php echo __('Car'); ?></th>
        <th><?php echo __("Customer"); ?></th>
        <th><?php echo __("Phone"); ?></th>
        <th><?php echo __('Avancement'); ?></th>
        <th><?php echo __('Position'); ?></th>
        <th><?php echo __('Status'); ?></th>
        <th><?php echo __('Customer observation'); ?></th>
        <th><?php echo __('Planification observation'); ?></th>

    </tr>
    </thead>
    <tbody>
    <?php
    $nbMissions = count($sheetRideDetailRides);
    $nbTrucksInstance = $nbTrucks - $nbMissions;

    foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
        ?>
        <tr>
            <td><?php echo $sheetRideDetailRide['SheetRideDetailRides']['reference'] ?></td>
            <td><?= $sheetRideDetailRide['CarType']['name']; ?></td>

            <td> <?php if ($param == 1) {
                    echo $sheetRideDetailRide['Car']['code'] . " - " . $sheetRideDetailRide['Carmodel']['name'];
                } else if ($param == 2) {
                    echo $sheetRideDetailRide['Car']['immatr_def'] . " - " . $sheetRideDetailRide['Carmodel']['name'];
                } ?>

            </td>
            <td>
                <?php
                echo $sheetRideDetailRide['Customer']['first_name'] . " " . $sheetRideDetailRide['Customer']['last_name']; ?>
                &nbsp;
            </td>
            <td><?= $sheetRideDetailRide['Customer']['mobile'] ?></td>
            <td><?php ?></td>
            <td><?php if($sheetRideDetailRide['SheetRideDetailRides']['status_id'] == StatusEnum::mission_ongoing) {?>
                    <?= $this->Html->link(
                        '<i class="fa fa-map-marker"></i>',
                        array('controller'=>'cars', 'action' => 'viewPosition', $sheetRideDetailRide['SheetRide']['car_id']),
                        array('escape' => false, 'target' => '_blank' ,'style'=>'display :block; text-align: center;')
                    ); ?>
                <?php } ?>
            </td>
            <td>
                <?php switch ($sheetRideDetailRide['SheetRideDetailRides']['status_id']) {
                    /*
                    1: mission planifi�e
                    2: mission en cours
                    3: mission clotur�e
                    4: mission pr�factur�e
                    5: mission approuv�e
                    6: mission non approuv�e
                    7: mission factur�e
                    */
                    case 1:
                        echo '<span class="label label-warning">';
                        echo __('Planned') . "</span>";
                        break;
                    case 2:
                        echo '<span class="label label-danger">';
                        echo __('In progress') . "</span>";
                        break;
                    case 3:
                        echo '<span class="label label-success">';
                        echo h(__('Closed')) . "</span>";
                        break;
                        break;
                    case 4:
                        echo '<span class="label label-primary">';
                        echo h(__('Preinvoiced')) . "</span>";
                        break;
                    case 5:
                        echo '<span class="label label-pink">';
                        echo h(__('Approved')) . "</span>";
                        break;
                    case 6:
                        echo '<span class="label label-purple">';
                        echo h(__('Not approved')) . "</span>";
                        break;
                    case 7:
                        echo '<span class="label btn-inverse">';
                        echo h(__('Invoiced')) . "</span>";
                        break;
                } ?>
            </td>
            <td><?php
                echo $sheetRideDetailRide['Observation']['customer_observation']
                ?></td>
            <td>
                <?php
                echo $sheetRideDetailRide['SheetRideDetailRides']['note']
                ?>


            </td>
        </tr>
    <?php
    }
    if ($nbTrucksInstance > 0) {

        foreach ($observations as $observation) {
            ?>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

                <td>
                    <?php
                    echo '<span class="label label-danger">';
                    echo __('No validated') . "</span>";

                    ?>
                </td>
                <td>
                    <div class="table-content editable">
                        <span>

                        </span>
                        <input
                            name="<?= $this->Observation->encrypt("observation|" . $observation['Observation']['id']); ?>"
                            placeholder="<?= __('Enter observation') ?>"
                            value="<?= $observation['Observation']['customer_observation'] ?>"
                            class="form-control table-input observation" type="text">
                    </div>

                </td>
                <td></td>
            </tr>
        <?php

        }


    }



    ?>


    </tbody>

</table>




