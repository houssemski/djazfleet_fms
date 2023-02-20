<?php
echo "<div  class='select-inline' id='client-initial-div'>" . $this->Form->input('SheetRideDetailRides.supplier_id', array(
        'label' => __('Initial customer'),
        'empty' => __('Select initial customer'),
        'id' => 'client',
        'class' => 'form-filter select-search-client-initial',
        'onchange'=>'javascript:getMarchandisesByClient(), getAttachmentsByClient(), getFinalSupplierByInitialSupplier();'
    )) . "</div>";