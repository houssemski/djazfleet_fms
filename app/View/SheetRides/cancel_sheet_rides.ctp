<?php
/**
 * @var array $cancelCauses
 * @var string $ids
 */

echo $this->Form->create('SheetRides', array(
    'url' => array(
        'action' => 'cancelSheetRides'
    ),
));

echo "<div class='form-group'>" . $this->Form->input('cancel_cause_id', array(
        'label' => __('Cancel cause'),
        'empty' => __('Select cancel cause'),
        'type' =>'select',
        'options' =>$cancelCauses,
        'id'=>'cancel-cause',
        'class' => 'form-control select-popup',
    )) . "</div>";
echo $this->Form->input('sheet_rides_ids',array(
    'type' => 'hidden',
    'value' => $ids
));
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo $this->Form->submit(__('Save'), array(
    'name' => 'ok',
    'class' => 'btn btn-primary',
    'label' => __('Save'),
    'type' => 'submit',
    'id'=>'boutonValider',
    'div' => false
));

echo $this->Form->end();