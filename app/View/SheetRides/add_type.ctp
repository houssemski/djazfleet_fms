<?php
echo $this->Form->create('CarType');
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
    'update' => '#contentWrapType',  //id of DOM element to update with selector
    'class' => 'btn btn-primary',

    
    ));
if (false != $saved){ //will only be true if saved OK in controller from ajax save above
    $url = '/cars/getTypes/'.$type_id;
    echo "<script>
        jQuery('#dialogModalType').dialog('close');  //close containing dialog         
       jQuery('#cartypes').load('".$this->Html->url($url)."');
    </script>";
    }
echo $this->Form->end();
echo $this->Js->writeBuffer(); //assuming this view is rendered without the default layout, make sure you write out the JS buffer at the bottom of the page
 die();