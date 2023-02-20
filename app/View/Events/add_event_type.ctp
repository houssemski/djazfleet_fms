<?php
if($result){

echo $this->Form->create('EventType'  );
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
                    
                echo "<div class='form-group'>".$this->Form->input('event_type_category_id', array(
                    'label' => __('Category'),
                    'class' => 'form-control select2',
                   'empty' => ''
                    ))."</div>";
                echo "<div class='form-group'>".$this->Form->input('transact_type_id', array(
                    'label' => __('Transaction type'),
                    'class' => 'form-control',
                    'options' => array(1 => __('Encasement'), 2 => __('Disbursement')),
                    'empty' => ''
                    ))."</div>";
                echo '<div class="lbl">'.__("Type").'</div>';
                echo "<div class='form-group mdiv' style='margin-left: 20px;'>".$this->Form->input('with_km', array(
                    'label' => __('With km'),
                    'class' => 'mchkbx',
                    ))."</div>";
                echo "<div class='form-group mdiv'>".$this->Form->input('with_date', array(
                    'label' => __('With date'),
                    'class' => 'mchkbx',
                    ))."</div>";

                   
echo $this->Js->submit(__('Save'), array(  //create 'ajax' save button
    'update' => '#contentWrap',  //id of DOM element to update with selector
    'class' => 'btn btn-primary',

    
    ));
    if (false != $saved){ //will only be true if saved OK in controller from ajax save above

        $url = '/events/getEventTypes/'.$type_id.'/'.$typeAdd;
        $intervalUrl = '/events/getIntervals/'.$type_id;
        echo "<script>
       jQuery('#dialogModal').dialog('close');  //close containing dialog  
      
       jQuery('#eventtype').load('".$this->Html->url($url)."', function(){
                jQuery('.select2').select2();
                });
       jQuery('#interval').load('".$this->Html->url($intervalUrl)."');
    </script>";
    }
echo $this->Form->end();
echo $this->Js->writeBuffer(); //assuming this view is rendered without the default layout, make sure you write out the JS buffer at the bottom of the page
 die();
}else { ?>
    <div id="flashMessage" class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo __("You don't have permission to add.") ?>
    </div>
<?php  die();
}