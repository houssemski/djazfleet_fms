<?php
echo "<div class='form-group'>".$this->Form->input('BillProduct.'.$i.'.weight', array(
'label' => __('Weight'),
'value'=>$weight,
'type'=>'hidden',
'class' => 'form-control',
))."</div>";
echo "<div class='form-group'>".$this->Form->input('BillProduct.'.$i.'.quantity', array(
'label' => __('Quantity'),
'value'=>$quantity,
'type'=>'number',
'placeholder' =>__('Enter quantity'),
'class' => 'form-control',
))."</div>";
					