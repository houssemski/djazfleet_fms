<?php
if($result) {

echo $this->Form->create('CarGroup' );
echo "<div class='form-group'>".$this->Form->input('code', array(
                    'label' => __('Code'),
                    'class' => 'form-control',
                    'error' => array('attributes' => array('escape' => false),
                                     'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>'. 
                                                     __("The code must be unique") . '</label></div>', true)
                    ))."</div>";
		echo "<div class='form-group'>".$this->Form->input('name', array(
                    'label' => __('Name'),
                    'class' => 'form-control',
                    ))."</div>";
echo $this->Js->submit(__('Save'), array(  //create 'ajax' save button
    'update' => '#contentWrapGroup',  //id of DOM element to update with selector
    'class' => 'btn btn-primary',

    
    ));
if (false != $saved){ //will only be true if saved OK in controller from ajax save above
    $url = '/cars/getGroups/'.$car_group_id;
    echo "<script>
        jQuery('#dialogModalGroup').dialog('close');  //close containing dialog
       jQuery('#groups').load('".$this->Html->url($url)."', function(){
                jQuery('#groups .select2').select2();
                });
    </script>";
    }
echo $this->Form->end();
echo $this->Js->writeBuffer(); //assuming this view is rendered without the default layout, make sure you write out the JS buffer at the bottom of the page
 die();
} else {
    ?>
    <div id="flashMessage" class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo __("You don't have permission to add.") ?>
    </div>
    <?php  die();
}