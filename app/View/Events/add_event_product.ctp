<td  >
    <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 dlt2"></i>',
        'javascript:DeleteProduct();',
        array('escape' => false,'id' => 'delete_product'.$num_product , 'onclick' => 'javascript:DeleteProduct(this.id);' )); ?>
</td>
<td > <?php  echo "<div class='form-group ' id='products$num_product' >" . $this->Form->input('Product.'.$num_product .'.product_id', array(
            'label' => '',
            'class' => 'form-control ',
            'id' =>'product_name'.$num_product,
            'onchange' => 'javascript:quantityMax(this.id);',
            'empty' => ''
        )) . "</div>"; ?>
    <!-- overlayed element -->

</td>
<td ><?php  echo "<div class='form-group '>" . $this->Form->input('Product.'.$num_product .'.quantity', array(
            'label' => '',
            'class' => 'form-control ',
            'onchange' => 'javascript:calculPrice(this.id);',
            'id' =>'quantity'.$num_product,
            'placeholder'=>__('Enter quantity'),
            'empty' => ''
        )) . "</div>"; ?>
    <span id='quantity_max<?php echo $num_product ?>'></span>
    <span id='msg<?php echo $num_product ?>'></span>
</td>

<td ><?php  echo "<div class='form-group'>" . $this->Form->input('Product.'.$num_product.'.price', array(
            'label' =>"",
            'class' => 'form-control',
            'id' =>'price'.$num_product,
            'onchange' => 'javascript:calculPrice(this.id);',
            'placeholder'=>__('Enter quantity'),
            'empty' => ''
        )) . "</div>"; ?>
</td>

<td > <?php  echo "<div class='form-group' id='products0'>" . $this->Form->input('Product.'.$num_product.'.supplier_id', array(
            'label' => "",
            'class' => 'form-control',
            'id' =>'supplier'.$num_product,
            'type'=>'select',
            'option'=>$suppliers,
            'onchange' => 'javascript:quantityMax(this.id);',
            'empty'=>__('Select supplier'),
        )) . "</div>"; ?>

</td>

<td style='display:none;'> <?php  echo "<div class='form-group ' >" . $this->Form->input('BillProduct.'.$num_product .'.price_ht', array(
            'label' => "price ht",
            'class' => 'form-control ',
            'id' =>'ht'.$num_product ,
            'type'=>'hidden',
            'empty' => ''
        )) . "</div>";


    echo "<div class='form-group ' >" . $this->Form->input('BillProduct.'.$num_product.'.price_ttc', array(
            'label' => "price ttc",
            'class' => 'form-control ',
            'id' =>'ttc'.$num_product,
            'type'=>'hidden',
            'empty' => ''
        )) . "</div>";
    echo "<div class='form-group ' >" . $this->Form->input('BillProduct.'.$num_product.'.price_tva', array(
            'label' => "price tva",
            'class' => 'form-control ',
            'id' =>'tva'.$num_product,
            'type'=>'hidden',
            'empty' => ''
        )) . "</div>";
    //  echo "<div id='total".$num_product."'><span  style='float: right;'>0.00<span></div>"
    ?>

    <div id ="total<?php echo $num_product ?>"><span  style='float: right;'>0.00<span></div>

</td>

<!--</tr>
	</tbody>
	</table> -->
</br></br>