<?php
include("ctp/script.ctp");
echo $this->Form->create('Payment' , array('onsubmit'=> 'javascript:disable();'));
?>
<br>
<br>
<br>
<?php

$options=array('1'=>'Non défini' , '2'=>'Chez nous', '3'=>'En circulation', '4'=>'Payé', '5'=>'Impayé', '6'=>'Annulé');
echo "<div  class='form-group'>".$this->Form->input('payment_etat', array(
        'label' => __('Payment etat'),
        'empty' =>'',
        'type'=>'select',
        'options'=>$options,
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
