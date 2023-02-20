<?php

if($type ==2){
    echo "<div class='form-group'>".$this->Form->input('Factor.name_id', array(
            'label' => __('Name'),
            'type'=>'select',
            'options'=>$models,
            'empty'=>__(''),
            'id'=>'nameId',
            'onchange'=>'javascript: getModelName()',
            'class' => 'form-control',
        ))."</div>";
    echo "<div class='form-group'>".$this->Form->input('Factor.name', array(
            'type' => 'hidden',
            'id' => 'name',
        ))."</div>";
}else {
    echo "<div class='form-group'>".$this->Form->input('Factor.name', array(
            'label' => __('Name'),
            'class' => 'form-control',
        ))."</div>";
    echo "<div class='form-group'>".$this->Form->input('Factor.name_id', array(
            'type' => 'hidden',
            'value' => 0,
        ))."</div>";


}