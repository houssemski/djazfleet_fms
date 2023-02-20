<?php
/**
 * @var int $stopNumber
 * @var array $busRouteStops
 */
?>
<td colspan="2"> <?php echo __('Stop'); ?>  </td>
<td>
<div class="tab-pane">
    <?php
    echo "<div  id='stop-div'  class='select-inline'>" . $this->Form->input('BusStop.'.$stopNumber.'.bus_route_stop_id', array(
            'label' => __("Bus stop"),
            'class' => 'form-filter',
            'empty' => '',
            'options'=> $busRouteStops,
            'data-stop-order' => $stopNumber,
            'id' => 'stop-select-'.$stopNumber
        )) . "</div>";
    echo $this->Form->input('BusStop.'.$stopNumber.'.geo_fence_id', array(
        'label' => false,
        'type'=> 'hidden',
        'id'=> 'geo-fence-id-'.$stopNumber,
        'value' => $stopNumber
    ));
    echo $this->Form->input('BusStop.'.$stopNumber.'.stop_order', array(
        'label' => false,
        'type'=> 'hidden',
        'value' => $stopNumber
    ));
    ?>
</div>
</td>
<td>
    <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 dlt2"></i>',
        'javascript:;',
        array('escape' => false, 'data-stop-number' => $stopNumber , 'onclick' => 'javascript:deleteStop(jQuery(this));'));  ?>
</td>