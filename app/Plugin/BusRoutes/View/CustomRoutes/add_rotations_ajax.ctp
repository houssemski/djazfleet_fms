<?php
/**
 * @var array $busStops
 * @var int $rotationNumber
 * @var int $rotationsToGenerate
 * @var int $busRouteId
 * @var int $busRouteType
 */

?>

<style>
    .margin-left{
        margin-left: 20px;
    }
</style>

<?php
echo $this->Form->input('BusRouteRotation.' . $rotationNumber . '.bus_route_id', array(
    'label' => false,
    'type' => 'hidden',
    'value' => $busRouteId,
));
echo $this->Form->input('BusRouteRotation.' . $rotationNumber . '.rotation_number', array(
    'label' => false,
    'type' => 'hidden',
    'value' => $rotationNumber,
));
?>
<?php for ($i = 0; $i < $rotationsToGenerate; $i++) { ?>
    <table class="table table-bordered cars">
        <tbody>
        <thead>
        <tr>
            <th width="45%" colspan="2"><?php echo __('Depart'); ?></th>
            <?php if ($busRouteType == '2'){ ?>
            <th width="45%" colspan="2"><?php echo __('Return'); ?></th>
            <?php } ?>
            <th width="10%" ></th>

        </tr>
        </thead>
        <?php
        echo $this->Form->input('BusRouteRotation.' . $rotationNumber .'.'.$i. '.schedule_number', array(
            'label' => false,
            'type' => 'hidden',
            'value' => ($i + 1),
        ));
        ?>
        <?php $j=0; ?>
        <?php foreach ($busStops as $stop) { ?>
            <tr id="row-<?= $rotationNumber ?>-<?= $i ?>-<?= $j ?>">
                <td>
                    <?php
                    echo $this->Form->input('BusRouteRotation.' . $rotationNumber .'.'.$i. '.0.' . $j . '.bus_route_id', array(
                        'label' => false,
                        'type' => 'hidden',
                        'value' => $busRouteId,
                    ));
                    echo $this->Form->input('BusRouteRotation.' . $rotationNumber .'.'.$i. '.0.' . $j . '.bus_route_stop_id', array(
                        'label' => false,
                        'type' => 'hidden',
                        'value' => $stop['BusRouteStop']['id'],
                    ));
                    echo $this->Form->input('BusRouteRotation.' . $rotationNumber .'.'.$i. '.0.' . $j . '.stop_order', array(
                        'label' => false,
                        'type' => 'hidden',
                        'value' => $stop['BusStop']['stop_order'],
                    ));
                    echo $this->Form->input('BusRouteRotation.' . $rotationNumber . '.'.$i.'.0.' . $j . '.direction', array(
                        'label' => false,
                        'type' => 'hidden',
                        'value' => 0,
                    ));
                    echo $this->Form->input('BusRouteRotation.' . $rotationNumber . '.'.$i.'.0.' . $j . '.rotation_number', array(
                        'label' => false,
                        'type' => 'hidden',
                        'value' => $rotationNumber,
                    ));
                    echo $this->Form->input('BusRouteRotation.' . $rotationNumber . '.'.$i.'.0.' . $j . '.rotation_schedule_number', array(
                        'label' => false,
                        'type' => 'hidden',
                        'value' => ($i + 1),
                    ));
                    echo $stop['BusRouteStop']['name']
                    ?>
                </td>

                <td>
                    <?php
                    echo $this->Form->input('BusRouteRotation.' . $rotationNumber .'.'.$i. '.0.' . $j . '.time', array(
                        'label' => false,
                        'class' => 'form-control time',
                        'type' => 'text',
                        'placeholder' => __('Arrival time'),
                    ));
                    ?>
                </td>
                <?php if ($busRouteType == '2'){ ?>
                <td>
                    <?php
                    echo $this->Form->input('BusRouteRotation.' . $rotationNumber .'.'.$i. '.1.' . $j . '.bus_route_id', array(
                        'label' => false,
                        'type' => 'hidden',
                        'value' => $busRouteId,
                    ));
                    echo $this->Form->input('BusRouteRotation.' . $rotationNumber . '.'.$i.'.1.' . $j . '.bus_route_stop_id', array(
                        'label' => false,
                        'type' => 'hidden',
                        'value' => $stop['BusRouteStop']['id'],
                    ));
                    echo $this->Form->input('BusRouteRotation.' . $rotationNumber . '.'.$i.'.1.' . $j . '.stop_order', array(
                        'label' => false,
                        'type' => 'hidden',
                        'value' => $stop['BusStop']['stop_order'],
                    ));
                    echo $this->Form->input('BusRouteRotation.' . $rotationNumber .'.'.$i. '.1.' . $j . '.direction', array(
                        'label' => false,
                        'type' => 'hidden',
                        'value' => 1,
                    ));
                    echo $this->Form->input('BusRouteRotation.' . $rotationNumber . '.'.$i.'.1.' . $j . '.rotation_number', array(
                        'label' => false,
                        'type' => 'hidden',
                        'value' => $rotationNumber,
                    ));
                    echo $this->Form->input('BusRouteRotation.' . $rotationNumber . '.'.$i.'.1.' . $j . '.rotation_schedule_number', array(
                        'label' => false,
                        'type' => 'hidden',
                        'value' => ($i + 1),
                    ));
                    echo $stop['BusRouteStop']['name']
                    ?>
                </td>

                <td>
                    <?php
                    echo $this->Form->input('BusRouteRotation.' . $rotationNumber .'.'.$i. '.1.' . $j . '.time', array(
                        'label' => false,
                        'class' => 'form-control time',
                        'type' => 'text',
                        'placeholder' => __('Arrival time'),
                    ));
                    ?>
                </td>
                <?php } ?>
                <td>
                    <?php
                    $display = 'none';
                    if ($j == (count($busStops)-1) ){
                        $display = 'block';
                    }
                    ?>
                    <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 dlt2"></i>',
                        'javascript:;',
                        array(
                            'escape' => false,
                            'id' => 'delete-rotation-'.$rotationNumber.'-'.$i.'-'.$j ,
                            'data-i-ctr' => $i ,
                            'data-j-ctr' => $j ,
                            'data-rotation-ctr' => $rotationNumber ,
                            'onclick' => 'javascript:deleteRotation(jQuery(this));',
                            'style' => 'display : '.$display.';'
                        )
                    );  ?>
                </td>
            </tr>

        <?php $j++; } ?>
        </tbody>
    </table>
<?php } ?>


<label class="margin-left" for="sunday-<?= $rotationNumber ?>" ><?= __('Sunday') ?></label>
<input id="sunday-<?= $rotationNumber ?>" type="checkbox" name="BusRouteRotation[<?=$rotationNumber?>][WeekDays][7]">
<label class="margin-left" for="monday-<?= $rotationNumber ?>" ><?= __('Monday') ?></label>
<input id="monday-<?= $rotationNumber ?>" type="checkbox" name="BusRouteRotation[<?=$rotationNumber?>][WeekDays][1]">
<label class="margin-left" for="tuesday-<?= $rotationNumber ?>" ><?= __('Tuesday') ?></label>
<input id="tuesday-<?= $rotationNumber ?>" type="checkbox" name="BusRouteRotation[<?=$rotationNumber?>][WeekDays][2]">
<label class="margin-left" for="wednesday-<?= $rotationNumber ?>" ><?= __('Wednesday') ?></label>
<input id="wednesday-<?= $rotationNumber ?>" type="checkbox" name="BusRouteRotation[<?=$rotationNumber?>][WeekDays][3]">
<label class="margin-left" for="thursday-<?= $rotationNumber ?>" ><?= __('Thursday') ?></label>
<input id="thursday-<?= $rotationNumber ?>" type="checkbox" name="BusRouteRotation[<?=$rotationNumber?>][WeekDays][4]">
<label class="margin-left" for="friday-<?= $rotationNumber ?>" ><?= __('Friday') ?></label>
<input id="friday-<?= $rotationNumber ?>" type="checkbox" name="BusRouteRotation[<?=$rotationNumber?>][WeekDays][5]">
<label class="margin-left" for="saturday-<?= $rotationNumber ?>" ><?= __('Saturday') ?></label>
<input id="saturday-<?= $rotationNumber ?>" type="checkbox" name="BusRouteRotation[<?=$rotationNumber?>][WeekDays][6]">


<?= $this->Html->link('<i class="fa fa-trash-o m-r-5"></i>' . __('Delete') .' '.__('rotation'),
    'javascript:;',
    array('escape' => false, 'class' => 'btn btn-danger btn-trans waves-effect waves-primary w-md m-b-5 pull-right',
        'data-rotation-nb' => $rotationNumber,
        'onclick' => 'deleteRotation(jQuery(this))'
    )) ?>






