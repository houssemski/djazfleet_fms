<?php
if($result){

echo $this->Form->create('Customer' );
echo "<div class='form-group'>".$this->Form->input('code', array(
                    'label' => __('Code'),
                    'class' => 'form-control',
                    'error' => array('attributes' => array('escape' => false),
                                     'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>'. 
                                                     __("The code must be unique") . '</label></div>', true)
                    ))."</div>";
					
					echo "<div class='form-group ' >" . $this->Form->input('customer_category_id', array(
                    'label' => __('Category'),
                    'class' => 'form-control select2',
                    'empty' => ''
                )) . "</div>";
		echo "<div class='form-group'>".$this->Form->input('first_name', array(
                    'label' => __('First name'),
                    'class' => 'form-control',
                    ))."</div>";
					
		echo "<div class='form-group'>".$this->Form->input('last_name', array(
                    'label' => __('Last name'),
                    'class' => 'form-control',
                    ))."</div>";
echo $this->Js->submit(__('Save'), array(  //create 'ajax' save button
    'update' => '#contentWrapCustomer',  //id of DOM element to update with selector
    'class' => 'btn btn-primary',
    ));

 

if (false != $saved){ //will only be true if saved OK in controller from ajax save above
    $url = '/sheetRides/getCustomers/'.$customerId;
	
    echo "<script>
        jQuery('#dialogModalCustomer').dialog('close');  //close containing dialog         
       jQuery('#customers-div').load('".$this->Html->url($url)."', function(){
                  $('.select-search-customer').select2({
                        ajax: {
                            url: '". $this->Html->url('/customers/getCustomersByKeyWord')."',
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                return {
                                    q: $.trim(params.term),
                                    controller: jQuery('#controller').val(),
                                    action: jQuery('#current_action').val(),
                                    customerId: customerId
                                };
                            },
                            processResults: function (data, page) {
                                return {results: data};
                            },
                            cache: true
                        },
                        minimumInputLength: 2
                    });

                });
    </script>";
    }
echo $this->Form->end();
echo $this->Js->writeBuffer(); //assuming this view is rendered without the default layout, make sure you write out the JS buffer at the bottom of the page
die();
}else {
    ?>
    <div id="flashMessage" class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo __("You don't have permission to add.") ?>
    </div>
    <?php  die();
}