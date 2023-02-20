<?php
if($id == 'car_subcontracting1') {

    echo "<div  class='select-inline'>" . $this->Form->input('SheetRide.supplier_id', array(
            'label' => __('Supplier'),
            'class' => 'form-filter select-search-subcontractor',
            'empty' => '',
            'id' => 'supplier',
        )) . "</div>";

    echo "<div  class='select-inline'>" . $this->Form->input('SheetRide.car_name', array(
            'label' => __('Car'),
            'class' => 'form-filter ',
        )) . "</div>";

    echo "<div  class='select-inline'>" . $this->Form->input('SheetRide.remorque_name', array(
            'label' => __('Remorque'),
            'class' => 'form-filter ',
        )) . "</div>";

    echo "<div  class='select-inline'>" . $this->Form->input('SheetRide.customer_name', array(
            'label' => __('Customer'),
            'class' => 'form-filter ',
        )) . "</div>";

} else {
echo "<div id='cars-div' class='select-inline'>" . $this->Form->input('SheetRide.car_id', array(
        'label' => __('Car'),
        'class' => 'form-filter select-search-car',
        'empty' => '',
        'onchange' => 'javascript: carChanged(this.id) ;',
        'id' => 'cars',
    )) . "</div>";


echo "<div  id='remorques-div' class='select-inline'>" . $this->Form->input('SheetRide.remorque_id', array(
        'label' => __('Remorque'),
        'class' => 'form-filter select-search-remorque',
        'empty' => '',
        'id' => 'remorques',
    )) . "</div>";
echo "<div  id='customers-div'  class='select-inline'>" . $this->Form->input('SheetRide.customer_id', array(
        'label' => __("Customer"),
        'class' => 'form-filter select-search-customer',
        'empty' => '',
        'id' => 'customers',
        'onchange' => 'javascript : verifyDriverLicenseExpirationDate(), verifyMissionCustomer();'
    )) . "</div>"; ?>

<!-- overlayed element -->
<div id="dialogModalCustomer">
    <!-- the external content is loaded inside this tag -->
    <div id="contentWrapCustomer"></div>
</div>
<div class="popupactions">
    <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
        array("controller" => "sheetRides", "action" => "addCustomer"),
        array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayCustomer", 'escape' => false, "title" => __("Add Customer"))); ?>
</div>
<div style="clear:both"></div>

<?php    echo "<div style='clear:both; padding-top: 10px;'></div>";
echo '<div class="lbl"> <a href="#demo" data-toggle="collapse"><i class="fa fa-arrow-right"></i>' . __("Customer help") . '</a></div>';
?>
<div id="demo" class="collapse">
    <?php
    echo "<div   class='select-inline'>" . $this->Form->input('SheetRideConveyor.1.conveyor_id', array(
            'label' => __('Conveyor'),
            'empty' => '',
            'class' => 'form-filter select-search-conveyor'
        )) . "</div>";
    ?>
    <div id="conveyor-div">

    </div>
    <div id='add_conveyor' class='view-link select-inline' style='margin-top: 16px;'
         title='<?= __("add") ?>'>
        <?= $this->Html->link(
            '<i   class="fa fa-plus"></i>',
            'javascript:addConveyor(1);',
            array('escape' => false, 'class' => 'btn btn-default', 'style' => 'width: 40px;')
        ); ?>
    </div>
</div>

<?php
}