<?php

echo $this->Form->create('Interfering' );
echo "<div class='form-group'>".$this->Form->input('code', array(
                    'label' => __('Code'),
                    'class' => 'form-control',
                    'error' => array('attributes' => array('escape' => false),
                                     'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>'. 
                                                     __("The code must be unique") . '</label></div>', true)
                    ))."</div>";
                echo "<div class='form-group'>".$this->Form->input('interfering_type_id', array(
                    'label' => __('Interfering type'),
                    'class' => 'form-control select2',
                    'empty' => ''
                    ))."</div>";
                echo "<div class='form-group'>".$this->Form->input('name', array(
                    'label' => __('Name'),
                    'class' => 'form-control',
                    ))."</div>";
                echo "<div class='form-group'>".$this->Form->input('adress', array(
                    'label' => __('Address'),
                    'class' => 'form-control',
                    ))."</div>";
                echo "<div class='form-group'>".$this->Form->input('tel', array(
                    'label' => __('Phone'),
                    'class' => 'form-control',
                    ))."</div>";
                echo "<div class='form-group'>".$this->Form->input('note', array(
                    'label' => __('Note'),
                    'class' => 'form-control',
                    ))."</div>";
                 
echo $this->Js->submit(__('Save'), array(  //create 'ajax' save button
    'update' => '#contentWrapInterfering',  //id of DOM element to update with selector
    'class' => 'btn btn-primary',

    
    ));
if (false != $saved){ //will only be true if saved OK in controller from ajax save above
    $url = '/events/getInterferings/'.$interfering_id;
    echo "<script>
 
       jQuery('#dialogModalInterfering').dialog('close');  //close containing dialog 
        
       jQuery('#interfering".$idInterval.$itemNumber."').load('".$this->Html->url($url.'/'.$itemNumber.'/'.$idInterval.'/'.$typeEventId)."');
    </script>";
    }
echo $this->Form->end();
echo $this->Js->writeBuffer(); //assuming this view is rendered without the default layout, make sure you write out the JS buffer at the bottom of the page
 die();