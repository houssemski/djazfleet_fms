<?php

echo $this->Form->create('TransportBill' , array('onsubmit'=> 'javascript:disable();'));
?>
<br>
<br>
<br>
<?php echo "<div  class='form-group'>".$this->Form->input('cancel_cause_id', array(
        'label' => __('Cancel causes'),
        'empty' =>'',
        'type'=>'select',
        'options'=>$cancelCauses,
        'class' => 'form-control',
        'style'=> 'color: #222;font-size: 14px;'
    ))."</div>"; ?>

<br>
<br>
<br>
<?php echo $this->Form->submit(__('Save'), array(
    'name' => 'ok',
    'class' => 'btn btn-primary',
    'label' => __('Save'),
    'type' => 'submit',
    'id'=>'boutonValider',
    'div' => false
));



echo $this->Form->end();
echo $this->Js->writeBuffer(); //assuming this view is rendered without the default layout, make sure you write out the JS buffer at the bottom of the page
?>
