<?php
  if($type == BillTypesEnum::product_request ||
                                          $type == BillTypesEnum::purchase_request) {
      echo "<div >" . $this->Form->input('BillProduct.' . $i . '.tva_id',
              array(
                  'label' => '',
                  'type'=>'hidden',
                  'value' => $product['Product']['tva_id'],
                  'id' => 'tva' . $i,
                  'options' => $tvas,
                  'onchange' => 'javascript:calculPrice(this.id);',
                  'class' => 'form-control',
              )) . "</div>";
  }else {
      echo "<div >" . $this->Form->input('BillProduct.' . $i . '.tva_id',
              array(
                  'label' => '',
                  'value' => $product['Product']['tva_id'],
                  'id' => 'tva' . $i,
                  'options' => $tvas,
                  'onchange' => 'javascript:calculPrice(this.id);',
                  'class' => 'form-control',
              )) . "</div>";
  }