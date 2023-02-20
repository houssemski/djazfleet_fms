<?php
/**
 * @var int $rotationNumber
 * @var int $busRouteId
 */
?>
<div class="tab-pane" id="tab-rotation-<?= $rotationNumber ?>">
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
                        'id' => 'rotations-to-generate-'.$rotationNumber,
                        'empty' => ''
                    )) . "</div>";
                ?>
                <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Generate'),
                    'javascript:;',
                    array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5 pull-right generate',
                        'data-rotation-nb' => $rotationNumber,
                        'data-bus-route-id' => $busRouteId
                    )) ?>

                <div id="rotation-<?= $rotationNumber ?>">

                </div>


            </div>
        </div>
    </div>
</div>