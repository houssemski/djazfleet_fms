<?php
echo "<div  class='select-inline' id='client-initial-div$i'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_id', array(
    'label' => __('Initial customer'),
    'empty' => __('Select initial customer'),
    'id' => 'client' . $i,
    'class' => 'form-filter select-search-client-initial',
    'onchange'=>'javascript:getMarchandisesByClient(this.id), getAttachmentsByClient(this.id), getFinalSupplierByInitialSupplier(this.id);'
    )) . "</div>";