<?php

echo $this->Form->create('Complaint' , array('onsubmit'=> 'javascript:disable();'));

echo "<div class='form-group'>".$this->Form->input('reference', array(
        'label' => __('Reference'),
        'class' => 'form-control',
        'error' => array('attributes' => array('escape' => false),
            'unique' => '<div class="form-group has-error">
        <label class="control-label" for="inputError">
            <i class="fa fa-times-circle-o"></i>'.
                __("The reference must be unique") . '</label></div>', true)
    ))."</div>";

echo "<div class='form-group '>" . $this->Form->input('taken_over_date', array(
        'label' => '',
        'placeholder' => 'dd/mm/yyyy hh:mm',
        'type' => 'text',
        'class' => 'form-control datemask',
        'before' => '<label>' . __('Taken over date') .
            '</label><div class="input-group date"><label for="ComplaintComplaintDate"></label>
        <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>',
        'after' => '</div>',
        'id' => 'taken_over_date',
    )) . "</div>";

$types = array( '1'=>__('Appel'),
    '2'=>__('Email'),
    '3'=>__('Sms'),
    '4'=>__('Direct ou oral'),
    '5'=>__('Courier'),
    '6'=>__('Autres'),
);
echo "<div class='form-group'>".$this->Form->input('type', array(
        'label' => __('Type'),
        'empty'=>'',
        'options'=> $types,
        'class' => 'form-control select2',
    ))."</div>";


echo "<div class='form-group'>".$this->Form->input('complaint_cause_id', array(
        'label' => __('Complaint cause'),
        'class' => 'form-control select2',
        'empty'=>'',
    ))."</div>";


echo "<div class='form-group'>".$this->Form->input('observation', array(
        'label' => __('Observation'),
        'class' => 'form-control',
    ))."</div>";

echo $this->Form->submit(__('Save'), array(
    'name' => 'ok',
    'class' => 'btn btn-primary',
    'label' => __('Save'),
    'type' => 'submit',
    'id'=>'boutonValider',
    'div' => false
));



echo $this->Form->end();
echo $this->Js->writeBuffer(); //assuming this view is rendered without the default layout, make sure you write out the JS buffer at the bottom of the page
?>
