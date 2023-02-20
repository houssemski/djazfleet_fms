<?php

echo "<div class='form-group'>" . $this->Form->input('Event.external_repair_supplier', array(
        'label' => __('Lieu de dépanage'),
        'placeholder' => __('Enter lieu de dépanage'),
        'class' => 'form-control',
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('Event.cost', array(
        'label' => __('Cout globale'),
        'placeholder' => __('Enter cout global'),
        'class' => 'form-control',
    )) . "</div>";