<?php
if($typeAlert == 'km'){
    echo "<div class='form-group'>".$this->Form->input('EventType.alert_km', array(
            'label' => __('Alert').' '.__('Km'),
            'class' => 'form-control',
        ))."</div>";
}else {
    echo "<div class='form-group'>".$this->Form->input('EventType.alert_date', array(
            'label' => __('Alert').' '.__('Date'),
            'class' => 'form-control',
        ))."</div>";
}
