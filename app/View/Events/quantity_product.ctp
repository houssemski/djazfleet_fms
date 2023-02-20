<?php
if (Configure::read("cafyb") == '1') {
    echo  $this->Form->input('Product.'.$num.'.max', array(
        'label' => __('Quantity'),
        'class' => 'form-control form-prod',
        'value' =>$product[0]['quantity'],
        'type' =>'hidden',
        'id' =>'max'.$num,
        'empty' => ''
    )) ;
    echo  $this->Form->input('Product.'.$num.'.name', array(
        'class' => 'form-control form-prod',
        'value' =>$product[0]['name'],
        'type' =>'hidden',
        'id' =>'name'.$num,
        'empty' => ''
    )) ;
//echo "<div id='tva$num'>". $product['Tva']['tva_val']. "</div>";

    echo  $this->Form->input('tva', array(
        'label' => __('tva'),
        'class' => 'form-control form-prod',
        'value' =>$product[0]['Taxes']['tax_value'],
        'type' =>'hidden',
        'id' =>'tva_prod'.$num,
        'empty' => ''
    )) ;
    echo  $this->Form->input('price', array(
        'label' => __('Price'),
        'class' => 'form-control form-prod',
        'value' =>$product[0]['pmp'],
        'type' =>'hidden',
        'id' =>'price'.$num,
        'empty' => ''
    )) ;
}else {
    echo  $this->Form->input('Product..'.$num.'.max', array(
        'label' => __('Quantity'),
        'class' => 'form-control form-prod',
        'value' =>$product['Product']['quantity'],
        'type' =>'hidden',
        'id' =>'max'.$num,
        'empty' => ''
    )) ;
//echo "<div id='tva$num'>". $product['Tva']['tva_val']. "</div>";

    echo  $this->Form->input('tva', array(
        'label' => __('tva'),
        'class' => 'form-control form-prod',
        'value' =>$product['Tva']['tva_val'],
        'type' =>'hidden',
        'id' =>'tva_prod'.$num,
        'empty' => ''
    )) ;
    echo  $this->Form->input('price', array(
        'label' => __('Price'),
        'class' => 'form-control form-prod',
        'value' =>$product['Product']['pmp'],
        'type' =>'hidden',
        'id' =>'price'.$num,
        'empty' => ''
    )) ;
}

                 

?>