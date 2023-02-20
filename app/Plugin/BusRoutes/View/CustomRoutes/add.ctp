<?php
/**
 * @var array $busRouteStops
 * @var array $customers
 */
?>
<style>
    .select-inline .input {
        width: 300px !important;
    }
</style>
<div class="box">
    <h4 class="page-title"> <?= __('Add sheet ride (travel)'); ?></h4>
    <div class="edit form card-box p-b-0">


        <div class="box-body" >
            <?php
            echo $this->Form->create('BusRoutes.BusRoute', array('enctype' => 'multipart/form-data'));
            ?>
            <input type="hidden" value="2" id="next-stop-nb" />
            <table class="table table-bordered " id='table-stops'>

                <tr>
                    <td rowspan="100" ><?php echo __('Travel'); ?></td>
                    <td colspan="2"><?php echo __('Car'); ?> </td>
                    <td colspan="2" width="80%">
                        <div class="tab-pane">
                            <?php
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
                <tr>
                    <td colspan="2"> <?php echo __('Stop'); ?>  </td>
                    <td colspan="2">
                        <div class="tab-pane">
                            <?php
                            echo "<div  id='stop-div'  class='select-inline'>" . $this->Form->input('BusStop.1.bus_route_stop_id', array(
                                    'label' => __("Bus stop"),
                                    'class' => 'form-filter select2',
                                    'empty' => '',
                                    'id'=> 'stop-select-1',
                                    'data-stop-order' => 1,
                                    'options'=> $busRouteStops,
                                )) . "</div>";
                            echo $this->Form->input('BusStop.1.geo_fence_id', array(
                                'label' => false,
                                'type'=> 'hidden',
                                'id'=> 'geo-fence-id-1'
                            ));
                            echo $this->Form->input('BusStop.1.stop_order', array(
                                'label' => false,
                                'type'=> 'hidden',
                                'value' => 1
                            ));
                            ?>
                        </div>
                    </td>
                </tr>
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

</div>
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
echo $this->element('BusRoutes.Script/add-stops-script');
