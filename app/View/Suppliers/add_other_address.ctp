<button style="float: right;" name="remove"
        id="removeAddress<?php echo $i ?>"
        onclick="removeAddress(this.id);"
        class="btn btn-danger btn_remove">X
</button>
<?php
echo "<div class='form-group'>".$this->Form->input('SupplierAddress.'.$i.'.code', array(
        'label' => __('Code'),
        'class' => 'form-control',
        'id'=>''
    ))."</div>";
echo "<div class='form-group'>".$this->Form->input('SupplierAddress.'.$i.'.address', array(
        'label' => __('Address'),
        'class' => 'form-control',
    ))."</div>";

echo "<div class='form-group'>".$this->Form->input('SupplierAddress.'.$i.'.address_map', array(
        'label' => __('Address'),
        'class' => 'form-control',
        'id'=>'addresspicker'.$i
    ))."</div>";

echo "<div class='form-group'>".$this->Form->input('SupplierAddress.'.$i.'.latitude', array(
        'class' => 'form-control',
        'type'=>'hidden',
        'id'=>'latitude'.$i
    ))."</div>";

echo "<div class='form-group'>".$this->Form->input('SupplierAddress.'.$i.'.longitude', array(
        'type'=>'hidden',
        'class' => 'form-control',
        'id'=>'longitude'.$i
    ))."</div>";


?>
<div id="map<?php echo $i?>" style="float:right;height:500px;width:100%;margin-bottom:10px;"></div>
<?php
echo "<div class='form-group'>".$this->Form->input('SupplierAddress.'.$i.'.latlng', array(
        'type'=>'hidden',
        'class' => 'form-control',
        'id'=>'latlng'.$i
    ))."</div>";
?>