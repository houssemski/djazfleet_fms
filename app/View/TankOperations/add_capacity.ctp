<?php

echo $this->Form->create('Parameter');

		echo "<div class='form-group'>".$this->Form->input('liter_tank_'.$i, array(
                    'label' => __('Liter tank'),
                    'placeholder'=>__('Enter liter tank'),
                    'class' => 'form-control',
                    ))."</div>";
echo $this->Js->submit(__('Save'), array(  //create 'ajax' save button
    'update' => '#contentWrapCapacity',  //id of DOM element to update with selector
    'class' => 'btn btn-primary',

    
    ));

 

if (false != $saved){ //will only be true if saved OK in controller from ajax save above
    $url = '/tanks/getCapacity/'.$capacity;

    echo "<script>
       jQuery('#dialogModalCapacity').dialog('close');  //close containing dialog     
       jQuery('#capacity".$i."').load('".$this->Html->url($url)."');
       jQuery('#".$i."').css('display','none');

    </script>";
    }
echo $this->Form->end();
echo $this->Js->writeBuffer(); //assuming this view is rendered without the default layout, make sure you write out the JS buffer at the bottom of the page
 die();