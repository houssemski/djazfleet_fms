<?php
include("ctp/script.ctp");
echo $this->Form->create('Supplier' , array('onsubmit'=> 'javascript:disable();'));
?>
<br>
<br>
<br>
<?php
if($type ==1){
    echo "<div  class='form-group'>".$this->Form->input('supplier_id', array(
            'label' => __('Client'),
            'empty' =>'',
            'options'=>$suppliers,
            'class' => 'form-control',
            'style'=> 'color: #222;font-size: 14px;'
        ))."</div>";
}else {
    echo "<div  class='form-group'>".$this->Form->input('supplier_id', array(
            'label' => __('Supplier'),
            'empty' =>'',
            'options'=>$suppliers,
            'class' => 'form-control',
            'style'=> 'color: #222;font-size: 14px;'
        ))."</div>";
}
 ?>

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
