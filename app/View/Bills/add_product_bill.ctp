<td>
    <?php
    /** @var $i integer */
    /** @var $priceCategories array */
    if ($type == BillTypesEnum::exit_order ||
        $type == BillTypesEnum::delivery_order ||
        $type == BillTypesEnum::return_customer ||
        $type == BillTypesEnum::reintegration_order
    ) {
        if ($usePurchaseBill == 1) {

            echo "<div class='form-group input-button' id='products$i'>" . $this->Form->input('BillProduct.' . $i . '.product_id', array(
                    'label' => '',
                    'class' => 'form-control select-search',
                    'id' => 'product' . $i,
                    'onchange' => 'javascript: getInformationProduct(this.id); getLotsByProduct(this.id);setCurrentProductQty(this.id);',
                    'empty' => '',
                )) . "</div>";
        } else {

            echo "<div class='form-group input-button' id='products$i'>" . $this->Form->input('BillProduct.' . $i . '.product_id', array(
                    'label' => '',
                    'class' => 'form-control select-search',
                    'id' => 'product' . $i,
                    'onchange' => 'javascript:getInformationProduct(this.id); getLotsByProduct(this.id); getQuantityMaxByProduct(this.id);setCurrentProductQty(this.id);',
                    'empty' => '',
                )) . "</div>";
        }
    } else {
        if ($usePurchaseBill == 1) {
            echo "<div class='form-group small-input-button' id='products$i'>" . $this->Form->input('BillProduct.' . $i . '.product_id', array(
                    'label' => '',
                    'class' => 'form-control select-search',
                    'onchange' => 'javascript:getInformationProduct(this.id); getLotsByProduct(this.id);setCurrentProductQty(this.id);',
                    'id' => 'product' . $i,
                    'empty' => '',
                )) . "</div>";
        } else {
            echo "<div class='form-group small-input-button' id='products$i'>" . $this->Form->input('BillProduct.' . $i . '.product_id', array(
                    'label' => '',
                    'class' => 'form-control select-search',
                    'onchange' => 'javascript:getInformationProduct(this.id); getLotsByProduct(this.id); calculPrice(this.id);setCurrentProductQty(this.id);',
                    'id' => 'product' . $i,
                    'empty' => '',
                )) . "</div>";
        }

    }
    ?>
    <!-- overlayed element -->

    <div class="btn-group quick-actions" style="margin-top: 16px !important;">

        <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li>
                <?php echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add', true),
                    'javascript:;',
                    array(
                        "class" => "btn overlayProduct",
                        'escape' => false,
                        'id' =>'prod'.$i,
                        'onclick' =>'javascript:addProduct(this.id);',
                        "title" => __("Add Product")
                    )); ?>
            </li>
            <li>
                <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Edit', true),
                    'javascript:;',
                    array(
                        "class" => "btn overlayEditProduct",
                        'escape' => false,
                        'id' =>'editProd'.$i,
                        'onclick' =>'javascript:editProduct(this.id);',
                        "title" => __("Edit Product")
                    )); ?>
            </li>

        </ul>
        <div id="dialogModalProduct<?php echo $i;?>">
            <!-- the external content is loaded inside this tag -->
            <div id="contentWrapProduct<?php echo $i;?>"></div>
        </div>
    </div>


    <div style="clear:both"></div>
    <div id="serial-number-wrapper-<?php echo $i; ?>"></div>
    <div id="serial-number-inputs-<?php echo $i; ?>"></div>
    <?php if ($usePurchaseBill == 1) { ?>
        <div id='div-lot<?php echo $i; ?>'>
        </div>
    <?php } 
    echo "<div id ='div-designation$i'>" . $this->Form->input('BillProduct.'.$i.'.designation',
            array(
                'label' => '',
                'empty' => '',
                'id' => 'designation'.$i,
                'class' => 'form-control',
            )) . "</div>";
    ?>
</td>
<?php  if($type == BillTypesEnum::product_request ||
$type == BillTypesEnum::purchase_request) {?>
    <td><?php

            echo "<div class='form-group' id='quantity_max$i'>" . $this->Form->input('BillProduct.' . $i . '.quantity', array(
                    'label' => '',
                    'class' => 'form-control',
                    'id' => 'quantity-' . $i,
                    'onchange' => 'javascript:calculPrice(this.id);',
                    'placeholder' => __('Quantity'),
                )) . "</div>";



        echo "<div id='div-current-qty$i'>" .
            $this->Form->input('current-qty'.$i, array(
                'id' => 'current-qty'.$i,
                'value' => '0',
                'type' => 'hidden'
            )) .
            "</div>";

        echo "<div class='form-group' id='div_unit_price$i'>" . $this->Form->input('BillProduct.' . $i . '.unit_price', array(
                'label' => '',
                'value' => '0',
                'type' => 'hidden',
                'class' => 'form-control',
                'placeholder' => __('Enter price product'),
                'id' => 'price' . $i,
                'onchange' => 'javascript:calculPrice(this.id);',
                'empty' => ''
            )) . "</div>";

        echo "<div class='form-group'>" . $this->Form->input('BillProduct.' . $i . '.ristourne_val', array(
                'type' => 'number',
                'label' => '',
                'value' => '0',
                'type' => 'hidden',
                'placeholder' => __('Ristourne'),
                'style'=>'margin-top :8px',
                'class' => 'form-control',
                'id' => 'ristourne_val' . $i,
                'onchange' => 'javascript:calculRistournePourcentage(this.id);',
            )) . "</div>";
        echo "<div class='form-group'>" . $this->Form->input('BillProduct.' . $i . '.ristourne_%', array(
                'label' => '',
                'value' => '0',
                'type' => 'hidden',
                'placeholder' => __('Ristourne').' '.('%'),
                'id' => 'ristourne' . $i,
                'onchange' => 'javascript:calculRistourneVal(this.id);',
                'class' => 'form-control',
            )) . "</div>";  echo "<div class='form-group' >" . $this->Form->input('BillProduct.' . $i . '.price_ht', array(
                'label' => '',
                'value' => '0',
                'type' => 'hidden',
                'class' => 'form-control',
                'id' => 'ht' . $i,
                'readonly' => true,
                'empty' => ''
            )) . "</div>";

        echo "<div class='form-group' id='tva-div$i'>" . $this->Form->input('BillProduct.' . $i . '.tva_id', array(
                'label' => '',
                'value' => '0',
                'type' => 'hidden',
                'class' => 'form-control',
                'id' => 'tva' . $i,
                'onchange' => 'javascript:calculPrice(this.id);',
                'value' => 1
            )) . "</div>";
        echo "<div class='form-group' >" . $this->Form->input('BillProduct.' . $i . '.price_ttc', array(
                'label' => '',
                'value' => '0',
                'type' => 'hidden',
                'class' => 'form-control',
                'id' => 'ttc' . $i,
                'readonly' => true,
                'empty' => ''
            )) . "</div>";


        ?>
    </td>


<?php } else {?>
  <td><?php
    if ($type == BillTypesEnum::exit_order ||
        $type == BillTypesEnum::delivery_order ||
        $type == BillTypesEnum::return_customer ||
        $type == BillTypesEnum::reintegration_order
    ) {
        echo "<div class='form-group' id='quantity_max$i'>" . $this->Form->input('BillProduct.' . $i . '.quantity', array(
                'label' => '',
                'class' => 'form-control',
                'id' => 'quantity-' . $i,
                'onchange' => 'javascript: getQuantityMaxByProduct(this.id);',
                'placeholder' => __('Quantity'),
            )) . "</div>";
    } else {
        echo "<div class='form-group' id='quantity_max$i'>" . $this->Form->input('BillProduct.' . $i . '.quantity', array(
                'label' => '',
                'class' => 'form-control',
                'id' => 'quantity-' . $i,
                'onchange' => 'javascript:calculPrice(this.id);',
                'placeholder' => __('Quantity'),
            )) . "</div>";
    }


    echo "<div id='div-current-qty$i'>" .
        $this->Form->input('current-qty'.$i, array(
            'id' => 'current-qty'.$i,
            'value' => '0',
            'type' => 'hidden'
        )) .
    "</div>";
    ?>
</td>
<td><?php
    echo "<div class='form-group' id='div_unit_price$i'>" . $this->Form->input('BillProduct.' . $i . '.unit_price', array(
            'label' => '',
            'class' => 'form-control',
            'placeholder' => __('Enter price product'),
            'id' => 'price' . $i,
            'onchange' => 'javascript:calculPrice(this.id);',
            'empty' => ''
        )) . "</div>";

    if ($type == BillTypesEnum::delivery_order) {
        $pricePmp = array('0' => 'PMP');
        if (!empty($priceCategories)) {
            $options = array_merge($pricePmp, $priceCategories);
        } else {
            $options = $priceCategories;
        }

        echo "<div class='form-group' >" . $this->Form->input('BillProduct.' . $i . '.price_category_id', array(
                'label' => '',
                'class' => 'form-control select3',
                'id' => 'price_category' . $i,
                'onchange' => 'javascript:getPriceLot(this.id);',
                'options' => $options,
                'empty' => ''
            )) . "</div>";
    }
    ?>
</td>
<td>
    <?php
    echo "<div class='form-group'>" . $this->Form->input('BillProduct.' . $i . '.ristourne_val', array(
            'type' => 'number',
            'label' => '',
            'placeholder' => __('Ristourne'),
            'style'=>'margin-top :8px',
            'class' => 'form-control',
            'id' => 'ristourne_val' . $i,
            'onchange' => 'javascript:calculRistournePourcentage(this.id);',
        )) . "</div>";
    echo "<div class='form-group'>" . $this->Form->input('BillProduct.' . $i . '.ristourne_%', array(
            'label' => '',
            'placeholder' => __('Ristourne').' '.('%'),
            'id' => 'ristourne' . $i,
            'onchange' => 'javascript:calculRistourneVal(this.id);',
            'class' => 'form-control',
        )) . "</div>";  ?>


</td>

<td> <?php  echo "<div class='form-group' >" . $this->Form->input('BillProduct.' . $i . '.price_ht', array(
            'label' => '',
            'class' => 'form-control',
            'id' => 'ht' . $i,
            'readonly' => true,
            'empty' => ''
        )) . "</div>";
    ?>
</td>
<td> <?php
    echo "<div class='form-group' id='tva-div$i'>" . $this->Form->input('BillProduct.' . $i . '.tva_id', array(
            'label' => '',
            'class' => 'form-control',
            'id' => 'tva' . $i,
            'onchange' => 'javascript:calculPrice(this.id);',
            'value' => 1
        )) . "</div>";?>
</td>
<td> <?php
    echo "<div class='form-group' >" . $this->Form->input('BillProduct.' . $i . '.price_ttc', array(
            'label' => '',
            'class' => 'form-control',
            'id' => 'ttc' . $i,
            'readonly' => true,
            'empty' => ''
        )) . "</div>";


    ?>
	</td>
<td>


    <a class="btn btn-primary" data-toggle="collapse" href="#tr_description<?php echo $i; ?>" role="button" onclick="getDescriptionProduct(<?php echo $i;?>)"
       aria-expanded="false" aria-controls="tr_description<?php echo $i; ?>" title="<?php echo __('Edit description') ?>">
        <i class="fa fa-edit" title="<?php echo __('Edit description') ?>"></i>
    </a>


 <?= $this->Html->link('<i class=" fa fa-trash-o" title="' . __('Delete') . '"></i>',
                                'javascript:removeBillProduct(' .$i.');',
                                array('escape' => false, 'class' => 'btn btn-danger', 'id' => $i,
                                   ))?>

</td>
<td>
</td>
<?php }?>



