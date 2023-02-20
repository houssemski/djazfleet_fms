<?php
if(!empty($code)){
echo "<div class='form-group' >".$this->Form->input('Ride.wording', array(
    'label' => __('Code'),
    'class' => 'form-control',
        'value'=>$code,
    'placeholder' =>__('Enter code'),
    ))."</div>";
}else {
    echo "<div class='form-group' >".$this->Form->input('Ride.wording', array(
            'label' => __('Code'),
            'class' => 'form-control',
            'value'=>'',
            'placeholder' =>__('Enter code'),
        ))."</div>";
}