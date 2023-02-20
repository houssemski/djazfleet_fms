<?php
$j =1 ;
foreach ($factors as $factor){

    echo "<div class='form-group' >" . $this->Form->input('ProductPriceFactor.' . $j . '.factor_id', array(
            'value' => $factor['Factor']['id'],
            'class' => 'form-control',
            'type'=>'hidden'
        )) . "</div>";
    echo "<div class='form-group' >" . $this->Form->input('ProductPriceFactor.' . $j. '.factor_value', array(
            'label' => $factor['Factor']['name'],
            'class' => 'form-control',
            'type'=>'integer'
        )) . "</div>";
    $j ++;
}

foreach ($selectFactors as $factor){

    echo "<div class='form-group' >" . $this->Form->input('ProductPriceFactor.' . $j . '.factor_id', array(
            'value' => $factor['Factor']['id'],
            'class' => 'form-control',
            'type'=>'hidden'
        )) . "</div>";
    echo "<div class='form-group' >" . $this->Form->input('ProductPriceFactor.' . $j. '.factor_value', array(
            'label' => $factor['Factor']['name'],
            'class' => 'form-control select-search',
            'empty' =>'',
            'options' =>$factor['Factor']['options'],
            'type'=>'select'
        )) . "</div>";
    $j ++;
}