<?php
/**
 * @var array $customers
 * @var array $cars
 * @var array $busStops
 * @var array $busRouteStops
 * @var array $busRoute
 * @var array $busRouteRotationsSchedule
 */

$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
echo $this->Html->css('bootstrap-datetimepicker.min.css');
$this->end();
?>
    <style>
        .select-inline .input {
            width: 300px !important;
        }
        .margin-left{
            margin-left: 20px;
        }
    </style>
<?php
echo $this->Form->create('BusRoutes.BusRoute', array('enctype' => 'multipart/form-data'));
?>
    <div class="box" id="rotations-container">
        <h4 class="page-title"> <?= __('Add sheet ride (travel)'); ?></h4>
        <div class="edit form card-box p-b-0">


            <div class="box-body" >

                <input type="hidden" value="<?= $busStops[(count($busStops)-1)]['BusStop']['stop_order']+1 ?>" id="next-stop-nb" />
                <table class="table table-bordered " id='table-stops'>

                    <tr>
                        <td rowspan="100" ><?php echo __('Travel'); ?></td>
                        <td colspan="2"><?php echo __('Car'); ?> </td>
                        <td colspan="2" width="80%">
                            <div class="tab-pane">
                                <?php
                                echo $this->Form->input('id', array(
                                    'label' => false,
                                    'type'=> 'hidden',
                                ));
                                echo "<div  id='title-div'  class='select-inline'>" . $this->Form->input('route_title', array(
                                        'label' => __("Route title"),
                                        'class' => 'form-filter',
                                        'id' => 'title'
                                    )) . "</div>";
                                echo "<div id='cars-div' class='select-inline'>" . $this->Form->input('car_id', array(
                                        'label' => __('Car'),
                                        'class' => 'form-filter select2',
                                        'empty' => '',
                                        'options'=> $cars,
                                        'id' => 'cars',
                                    )) . "</div>";
                                ?>
                                <?php
                                echo "<div  id='customers-div'  class='select-inline'>" . $this->Form->input('customer_id', array(
                                        'label' => __("Customer"),
                                        'class' => 'form-filter select2',
                                        'empty' => '',
                                        'options'=> $customers,
                                    )) . "</div>";
                                ?>
                            </div>
                            <br>
                            <div class="tab-pane">
                                <?php
                                $options = array('1' => __('Circuit'), '2' => __('Aller/Retour'));

                                $attributes = array('legend' => false,'onclick' =>'javascript:;');
                                echo $this->Form->radio('route_type', $options, $attributes) . "</div><br/>";

                                ?>
                            </div>
                        </td>
                    </tr>
                    <?php
                    $i = 1;
                    foreach ($busStops as $busStop) {   ?>
                        <tr id="stop-<?= $i ?>">
                            <td colspan="2"> <?php echo __('Stop'); ?>  </td>
                            <td>
                                <div class="tab-pane">
                                    <?php
                                    echo "<div  id='stop-div'  class='select-inline'>" . $this->Form->input('BusStop.'.$i.'.bus_route_stop_id', array(
                                            'label' => __("Bus stop"),
                                            'class' => 'form-filter select2',
                                            'empty' => '',
                                            'id' => 'stop-select-'.$i,
                                            'value' => $busStop['BusStop']['bus_route_stop_id'],
                                            'options'=> $busRouteStops,
                                        )) . "</div>";

                                    echo $this->Form->input('BusStop.'.$i.'.stop_order', array(
                                        'label' => false,
                                        'type'=> 'hidden',
                                        'value' => $busStop['BusStop']['stop_order'],
                                    ));
                                    echo $this->Form->input('BusStop.'.$i.'.id', array(
                                        'label' => false,
                                        'type'=> 'hidden',
                                        'value' => $busStop['BusStop']['id'],
                                    ));
                                    echo $this->Form->input('BusStop.'.$i.'.geo_fence_id', array(
                                        'label' => false,
                                        'type'=> 'hidden',
                                        'id'=> 'geo-fence-id-'.$i,
                                        'value' => $busStop['BusStop']['geo_fence_id'],
                                    ));
                                    ?>
                                </div>
                            </td>
                            <td>
                                <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 dlt2"></i>',
                                    'javascript:;',
                                    array(
                                        'escape' => false,
                                        'data-stop-id' => $busStop['BusStop']['id'] ,
                                        'data-stop-geo-fence-id' => $busStop['BusStop']['geo_fence_id'] ,
                                        'data-stop-number' => $i ,
                                        'onclick' => 'javascript:deleteStopInEdit(jQuery(this));'
                                    ));  ?>
                            </td>
                        </tr>
                    <?php $i++; } ?>

                </table>
                <br>
                <div style='clear:both;'></div>
                <div class="btn-group pull-right">
                    <div class="header_actions" style='margin-top:10px;'>
                        <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add stop'),
                            'javascript:;',
                            array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'add-stop')) ?>

                    </div>
                </div>
            </div>


        </div>

        <br>
        <br>
        <br>

        <?php
        if (!empty($busRouteRotationsSchedule)){
            echo $this->Form->input('rotations_number', array(
                'label' => false,
                'type' => 'hidden',
                'id' => 'nb-rotations',
                'value' => count($busRouteRotationsSchedule),
            ));
            $rotationNumber = 1;
            foreach ($busRouteRotationsSchedule as $rotation){
                ?>
                <div class="tab-pane"  id="tab-rotation-<?= $rotationNumber ?>">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $rotationNumber ?>"
                                   class='a_accordion'><?= __('Rotation ').$rotationNumber ?></a>
                            </h4>
                        </div>
                        <div id="collapse<?= $rotationNumber ?>" class="panel-collapse collapse">
                            <div class="panel-body">
                                <?php
                                echo "<div class='form-group'>" . $this->Form->input('rotationsNumber', array(
                                        'label' => __('Rotations number'),
                                        'placeholder' => __('Enter rotation number'),
                                        'class' => 'form-control',
                                        'id' => 'rotations-to-generate-1',
                                        'empty' => '',
                                        'value' => count($rotation['BusRotation']['BusRotationSchedule'])
                                    )) . "</div>";
                                ?>
                                <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Generate'),
                                    'javascript:;',
                                    array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5 pull-right generate',
                                        'data-rotation-nb' => $rotationNumber,
                                        'data-bus-route-id' => $rotation['BusRotation']['id']
                                    )) ?>



                                <div id="rotation-<?= $rotationNumber ?>">
                                    <?php
                                    echo $this->Form->input('BusRouteRotation.' . $rotationNumber . '.id', array(
                                        'label' => false,
                                        'type' => 'hidden',
                                        'value' => $rotation['BusRotation']['id'],
                                    ));
                                    echo $this->Form->input('BusRouteRotation.' . $rotationNumber . '.bus_route_id', array(
                                        'label' => false,
                                        'type' => 'hidden',
                                        'value' => $rotation['BusRotation']['bus_route_id'],
                                    ));
                                    echo $this->Form->input('BusRouteRotation.' . $rotationNumber . '.rotation_number', array(
                                        'label' => false,
                                        'type' => 'hidden',
                                        'value' => $rotationNumber,
                                    ));
                                    ?>









                                    <?php
                                    for ($i = 0; $i < count($rotation['BusRotation']['BusRotationSchedule']); $i++) { ?>
                                        <table class="table table-bordered cars">
                                            <tbody>
                                            <thead>
                                            <tr>
                                                <th width="45%"  colspan="2"><?php echo __('Depart'); ?></th>
                                                <?php if ($busRoute['BusRoute']['route_type'] == '2') { ?>
                                                <th width="45%" colspan="2"><?php echo __('Return'); ?></th>
                                                <?php } ?>
                                                <th width="10%" > <?= __('Actions') ?> </th>

                                            </tr>
                                            </thead>
                                            <?php
                                            echo $this->Form->input('BusRouteRotation.' . $rotationNumber .'.'.$i. '.id', array(
                                                'label' => false,
                                                'type' => 'hidden',
                                                'value' => $rotation['BusRotation']['BusRotationSchedule'][$i]['id'],
                                            ));
                                            echo $this->Form->input('BusRouteRotation.' . $rotationNumber .'.'.$i. '.schedule_number', array(
                                                'label' => false,
                                                'type' => 'hidden',
                                                'value' => ($i + 1),
                                            ));
                                            ?>

                                            <?php
                                            for ($j = 0; $j < count($rotation['BusRotation']['BusRotationSchedule'][$i]['DepartureSchedule']); $j++) { ?>
                                                <tr id="row-<?= $rotationNumber ?>-<?= $i ?>-<?= $j ?>">
                                                    <td>
                                                        <?php
                                                        echo $this->Form->input('BusRouteRotation.' . $rotationNumber .'.'.$i. '.0.' . $j . '.id', array(
                                                            'label' => false,
                                                            'type' => 'hidden',
                                                            'value' => $rotation['BusRotation']['BusRotationSchedule'][$i]['DepartureSchedule'][$j]['BusRouteRotation']['id'],
                                                        ));
                                                        echo $this->Form->input('BusRouteRotation.' . $rotationNumber .'.'.$i. '.0.' . $j . '.bus_route_id', array(
                                                            'label' => false,
                                                            'type' => 'hidden',
                                                            'value' => $rotation['BusRotation']['BusRotationSchedule'][$i]['DepartureSchedule'][$j]['BusRouteRotation']['bus_route_id'],
                                                        ));
                                                        echo $this->Form->input('BusRouteRotation.' . $rotationNumber .'.'.$i. '.0.' . $j . '.bus_route_stop_id', array(
                                                            'label' => false,
                                                            'type' => 'hidden',
                                                            'value' => $rotation['BusRotation']['BusRotationSchedule'][$i]['DepartureSchedule'][$j]['BusRouteRotation']['bus_route_stop_id'],
                                                        ));
                                                        echo $this->Form->input('BusRouteRotation.' . $rotationNumber .'.'.$i. '.0.' . $j . '.stop_order', array(
                                                            'label' => false,
                                                            'type' => 'hidden',
                                                            'value' => $rotation['BusRotation']['BusRotationSchedule'][$i]['DepartureSchedule'][$j]['BusRouteRotation']['stop_order'],
                                                        ));
                                                        echo $this->Form->input('BusRouteRotation.' . $rotationNumber . '.'.$i.'.0.' . $j . '.direction', array(
                                                            'label' => false,
                                                            'type' => 'hidden',
                                                            'value' => $rotation['BusRotation']['BusRotationSchedule'][$i]['DepartureSchedule'][$j]['BusRouteRotation']['direction'],
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
                                                        echo $rotation['BusRotation']['BusRotationSchedule'][$i]['DepartureSchedule'][$j]['BusRouteStop']['name']
                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        echo $this->Form->input('BusRouteRotation.' . $rotationNumber .'.'.$i. '.0.' . $j . '.time', array(
                                                            'label' => false,
                                                            'class' => 'form-control time',
                                                            'type' => 'text',
                                                            'placeholder' => __('Arrival time'),
                                                            'value' => $rotation['BusRotation']['BusRotationSchedule'][$i]['DepartureSchedule'][$j]['BusRouteRotation']['time']
                                                        ));
                                                        ?>
                                                    </td>
                                                    <?php if ($busRoute['BusRoute']['route_type'] == '2') { ?>
                                                    <td>
                                                        <?php
                                                        echo $this->Form->input('BusRouteRotation.' . $rotationNumber .'.'.$i. '.1.' . $j . '.id', array(
                                                            'label' => false,
                                                            'type' => 'hidden',
                                                            'value' => $rotation['BusRotation']['BusRotationSchedule'][$i]['ArrivalSchedule'][$j]['BusRouteRotation']['id'],
                                                        ));
                                                        echo $this->Form->input('BusRouteRotation.' . $rotationNumber .'.'.$i. '.1.' . $j . '.bus_route_id', array(
                                                            'label' => false,
                                                            'type' => 'hidden',
                                                            'value' => $rotation['BusRotation']['BusRotationSchedule'][$i]['ArrivalSchedule'][$j]['BusRouteRotation']['bus_route_id'],
                                                        ));
                                                        echo $this->Form->input('BusRouteRotation.' . $rotationNumber . '.'.$i.'.1.' . $j . '.bus_route_stop_id', array(
                                                            'label' => false,
                                                            'type' => 'hidden',
                                                            'value' => $rotation['BusRotation']['BusRotationSchedule'][$i]['ArrivalSchedule'][$j]['BusRouteRotation']['bus_route_stop_id'],
                                                        ));
                                                        echo $this->Form->input('BusRouteRotation.' . $rotationNumber . '.'.$i.'.1.' . $j . '.stop_order', array(
                                                            'label' => false,
                                                            'type' => 'hidden',
                                                            'value' => $rotation['BusRotation']['BusRotationSchedule'][$i]['ArrivalSchedule'][$j]['BusRouteRotation']['stop_order'],
                                                        ));
                                                        echo $this->Form->input('BusRouteRotation.' . $rotationNumber .'.'.$i. '.1.' . $j . '.direction', array(
                                                            'label' => false,
                                                            'type' => 'hidden',
                                                            'value' => $rotation['BusRotation']['BusRotationSchedule'][$i]['ArrivalSchedule'][$j]['BusRouteRotation']['direction'],
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
                                                        echo $rotation['BusRotation']['BusRotationSchedule'][$i]['ArrivalSchedule'][$j]['BusRouteStop']['name']
                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        echo $this->Form->input('BusRouteRotation.' . $rotationNumber .'.'.$i. '.1.' . $j . '.time', array(
                                                            'label' => false,
                                                            'class' => 'form-control time',
                                                            'type' => 'text',
                                                            'placeholder' => __('Arrival time'),
                                                            'value' => $rotation['BusRotation']['BusRotationSchedule'][$i]['ArrivalSchedule'][$j]['BusRouteRotation']['time']
                                                        ));
                                                        ?>
                                                    </td>
                                                    <?php } ?>
                                                    <td>
                                                        <?php
                                                        $display = 'none';
                                                        if ($j == (count($rotation['BusRotation']['BusRotationSchedule'][$i]['DepartureSchedule'])-1) ){
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
                                                                'data-departure-rotation-id' => $rotation['BusRotation']['BusRotationSchedule'][$i]['DepartureSchedule'][$j]['BusRouteRotation']['id'] ,
                                                                'data-arrival-rotation-id' => ($busRoute['BusRoute']['route_type'] == '2') ? $rotation['BusRotation']['BusRotationSchedule'][$i]['ArrivalSchedule'][$j]['BusRouteRotation']['id'] :'' ,
                                                                'onclick' => 'javascript:deleteRotationInEdit(jQuery(this));',
                                                                'style' => 'display : '.$display.';'
                                                            )
                                                        );  ?>
                                                    </td>
                                                </tr>

                                                <?php  } ?>
                                            </tbody>
                                        </table>
                                    <?php } ?>






                                    <label class="margin-left" for="sunday-<?= $rotationNumber ?>" ><?= __('Sunday') ?></label>
                                    <input id="sunday-<?= $rotationNumber ?>" type="checkbox"  <?= in_array(7,$rotation['BusRotation']['WeekDays']) ? 'checked' : '' ?>  name="BusRouteRotation[<?=$rotationNumber?>][WeekDays][7]">
                                    <label class="margin-left" for="monday-<?= $rotationNumber ?>" ><?= __('Monday') ?></label>
                                    <input id="monday-<?= $rotationNumber ?>" type="checkbox" <?= in_array(1,$rotation['BusRotation']['WeekDays']) ? 'checked' : '' ?>  name="BusRouteRotation[<?=$rotationNumber?>][WeekDays][1]">
                                    <label class="margin-left" for="tuesday-<?= $rotationNumber ?>" ><?= __('Tuesday') ?></label>
                                    <input id="tuesday-<?= $rotationNumber ?>" type="checkbox" <?= in_array(2,$rotation['BusRotation']['WeekDays']) ? 'checked' : '' ?> name="BusRouteRotation[<?=$rotationNumber?>][WeekDays][2]">
                                    <label class="margin-left" for="wednesday-<?= $rotationNumber ?>" ><?= __('Wednesday') ?></label>
                                    <input id="wednesday-<?= $rotationNumber ?>" type="checkbox" <?= in_array(3,$rotation['BusRotation']['WeekDays']) ? 'checked' : '' ?> name="BusRouteRotation[<?=$rotationNumber?>][WeekDays][3]">
                                    <label class="margin-left" for="thursday-<?= $rotationNumber ?>" ><?= __('Thursday') ?></label>
                                    <input id="thursday-<?= $rotationNumber ?>" type="checkbox" <?= in_array(4,$rotation['BusRotation']['WeekDays']) ? 'checked' : '' ?> name="BusRouteRotation[<?=$rotationNumber?>][WeekDays][4]">
                                    <label class="margin-left" for="friday-<?= $rotationNumber ?>" ><?= __('Friday') ?></label>
                                    <input id="friday-<?= $rotationNumber ?>" type="checkbox" <?= in_array(5,$rotation['BusRotation']['WeekDays']) ? 'checked' : '' ?> name="BusRouteRotation[<?=$rotationNumber?>][WeekDays][5]">
                                    <label class="margin-left" for="saturday-<?= $rotationNumber ?>" ><?= __('Saturday') ?></label>
                                    <input id="saturday-<?= $rotationNumber ?>" type="checkbox" <?= in_array(6,$rotation['BusRotation']['WeekDays']) ? 'checked' : '' ?> name="BusRouteRotation[<?=$rotationNumber?>][WeekDays][6]">








                                    <?= $this->Html->link('<i class="fa fa-trash-o m-r-5"></i>' . __('Delete').' '. __('rotation'),
                                        'javascript:;',
                                        array('escape' => false, 'class' => 'btn btn-danger btn-trans waves-effect waves-primary w-md m-b-5 pull-right',
                                            'data-rotation-nb' => $rotationNumber,
                                            'data-rotation-id' => $rotation['BusRotation']['id'],
                                            'onclick' => 'deleteRotationInEdit(jQuery(this))'
                                        )) ?>










                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $rotationNumber++;
            }



        }else{





        echo $this->Form->input('rotations_number', array(
            'label' => false,
            'type' => 'hidden',
            'id' => 'nb-rotations',
            'value' => 1,
        ));
        ?>

            <div class="tab-pane" id="tab-rotation-1" >
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"
                               class='a_accordion'><?= __('Rotation 1') ?></a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse">
                        <div class="panel-body">
                            <?php
                            echo "<div class='form-group'>" . $this->Form->input('rotationsNumber', array(
                                    'label' => __('Rotations number'),
                                    'placeholder' => __('Enter rotation number'),
                                    'class' => 'form-control',
                                    'id' => 'rotations-to-generate-1',
                                    'empty' => ''
                                )) . "</div>";
                            ?>
                            <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Generate'),
                                'javascript:;',
                                array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5 pull-right generate',
                                    'data-rotation-nb' => 1,
                                    'data-bus-route-id' => $busRoute['BusRoute']['id']
                                    )) ?>

                            <div id="rotation-1">

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>


    </div>
<?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add rotation'),
    'javascript:;',
    array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5 pull-right',
        'id' => 'add-rotation',
        'data-bus-route-id' => $busRoute['BusRoute']['id']
    )) ?>
<div class="box-footer">
    <?php echo $this->Form->submit(__('Submit'), array(
        'name' => 'ok',
        'class' => 'btn btn-primary btn-bordred  m-b-5',
        'label' => __('Submit'),
        'type' => 'submit',
        'id'=>'boutonValider',
        'div' => false
    )); ?>
    <?php echo $this->Form->submit(__('Cancel'), array(
        'name' => 'cancel',
        'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
        'label' => __('Cancel'),
        'type' => 'submit',
        'div' => false,
        'formnovalidate' => true
    )); ?>
</div>

<?php
echo $this->element('BusRoutes.Script/add-stops-script');?>

