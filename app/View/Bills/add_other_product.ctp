<td>
<?php
echo "<div class='form-group'>".$this->Form->input('BillProduct.'.$i.'.product_id', array(
                    'label' => __('Product'),
                    'empty' =>'',
					'onchange'=>'javascript:getQuantityProduct(this.id);',
					'id'=>'product'.$i,
                    'class' => 'form-control select2',
                    ))."</div>";
					
                    echo "<div class='form-group' id='quantity$i'>".$this->Form->input('BillProduct.'.$i.'.quantity', array(
                    'label' => __('Quantity'),
                    'id'=>'quantity-'.$i,
                    'type'=>'number',
                    'placeholder' =>__('Enter quantity'),
                    'class' => 'form-control '
                    ))."</div>";?>
</td>
<td>
<button style="position: relative; left: -120px;" name="remove" id="<?php echo $i; ?>" onclick="remove(<?php echo $i; ?>);"class="btn btn-danger btn_remove">X</button></td>