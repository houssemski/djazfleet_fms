<?php

if ($typeBill == BillTypesEnum::exit_order ||
    $typeBill == BillTypesEnum::delivery_order ||
    $typeBill == BillTypesEnum::return_supplier ||
    $typeBill == BillTypesEnum::reintegration_order
) {
    if($product['Product']['out_stock'] == 1) {
        echo  $this->Form->input('BillProduct.'.$num.'.quantity', array(
            'label' => '',
            'class' => 'form-control',
            'value' =>$quantity,
            'id' =>'quantity-'.$num,
            'onchange' => 'javascript: getQuantityMaxByProduct(this.id);',
            'placeholder' => __('Quantity')
        )) ;
    } else {
        if($quantity> $product['Product']['quantity'] ){
            echo  $this->Form->input('BillProduct.'.$num.'.quantity', array(
                'label' => '',
                'class' => 'form-control ',
                'value' =>$product['Product']['quantity'],
                'id' =>'quantity-'.$num,
                'onchange' => 'javascript: getQuantityMaxByProduct(this.id);',
                'placeholder' => __('Quantity')
            )) ; ?>
            <div id ='msg<?php echo $num?>'>
                <p style ='color :#a52727 '><?php echo __('Insufficient quantity in the stock') ; ?><p>
            </div>
        <?php }else {
            echo  $this->Form->input('BillProduct.'.$num.'.quantity', array(
                'label' => '',
                'class' => 'form-control',
                'value' =>$quantity,
                'id' =>'quantity-'.$num,
                'onchange' => 'javascript: getQuantityMaxByProduct(this.id);',
                'placeholder' => __('Quantity')
            )) ;
        }
    }

} else {
    if($quantity> $product['Product']['quantity'] ){
        echo  $this->Form->input('BillProduct.'.$num.'.quantity', array(
            'label' => '',
            'class' => 'form-control ',
            'value' =>$product['Product']['quantity'],
            'id' =>'quantity-'.$num,
            'onchange' => 'javascript:calculPrice(this.id);',
            'placeholder' => __('Quantity')
        )) ; ?>
        <div id ='msg<?php echo $num?>'>
            <p style ='color :#a52727 '><?php echo __('Insufficient quantity in the stock') ; ?><p>
        </div>
    <?php }else {
        echo  $this->Form->input('BillProduct.'.$num.'.quantity', array(
            'label' => '',
            'class' => 'form-control',
            'value' =>$quantity,
            'id' =>'quantity-'.$num,
            'onchange' => 'javascript:calculPrice(this.id);',
            'placeholder' => __('Quantity')
        )) ;
    }


}