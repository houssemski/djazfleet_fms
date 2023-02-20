<?php
echo $this->Tinymce->input('BillProduct.'.$i.'.description', array(
    'label' => 'Description',
    'value' => $description,
    'placeholder' => __('Enter description'),
    'class' => 'form-control'
),array(
    'language'=>'fr_FR'
),
    'full'
); ?>