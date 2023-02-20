<button style="float: right;" name="remove"
        id="removeContact<?php echo $i;?>"
        onclick="removeContact(this.id);"
        class="btn btn-danger btn_remove">X
</button>

<?php
echo "<div class='form-group'>".$this->Form->input('SupplierContact.'.$i.'.contact', array(
        'label' => __('Contact person'),
        'class' => 'form-control',
    ))."</div>";

echo "<div class='form-group'>".$this->Form->input('SupplierContact.'.$i.'.function', array(
        'label' => __('Function'),
        'class' => 'form-control',
    ))."</div>";
echo "<div class='form-group'>".$this->Form->input('SupplierContact.'.$i.'.email1', array(
        'label' => __('Email 1'),
        'class' => 'form-control',
    ))."</div>";

echo "<div class='form-group'>".$this->Form->input('SupplierContact.'.$i.'.email2', array(
        'label' => __('Email 2'),
        'class' => 'form-control',
    ))."</div>";

echo "<div class='form-group'>".$this->Form->input('SupplierContact.'.$i.'.email3', array(
        'label' => __('Email 3'),
        'class' => 'form-control',
    ))."</div>";

echo "<div class='form-group'>".$this->Form->input('SupplierContact.'.$i.'.tel', array(
        'label' => __('Phone'),
        'class' => 'form-control',
    ))."</div>";
?>