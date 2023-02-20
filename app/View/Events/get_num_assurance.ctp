<?php

if (!empty ($event_assurance)){


  echo "<div class='form-group'>" . $this->Form->input('Event.assurance_number', array(
                    'label' => __('Assurance number'),
                    'class' => 'form-control',
                    'value' => $event_assurance['Event']['assurance_number'],
                    'id' => 'num_assurance',
                    'readonly' => true,
                )) . "</div>";

      

    echo "<div class='form-group'>" . $this->Form->input('Interfering.name', array(
                    'label' => __('Insured in'),
                    'class' => 'form-control',
                    'value' => $event_assurance['Interfering']['name'],
                    'required' => false,
                    'readonly' => true,
                )) . "</div>";

                    $options=array('1'=>__('Public liability'),'2'=>__('Collision damage'),'3'=>__('All risks'));
            echo "<div class='form-group'>" . $this->Form->input('Event.assurance_type', array(
                    'label' => __('Assurance type'),
                   'value'=>$event_assurance['Event']['assurance_type'],
                    'type'=>'select',
                    'options'=>$options,
                    'class' => 'form-control',
                    'disabled'=>true,
                    'empty'=>__('Select assurance type'),
                    
                )) . "</div>";

                }else {


    echo "<div class='form-group'>" . $this->Form->input('Event.assurance_number', array(
            'label' => __('Assurance number'),
            'class' => 'form-control',

            'id' => 'num_assurance',
            'readonly' => true,
        )) . "</div>";



    echo "<div class='form-group'>" . $this->Form->input('Interfering.name', array(
            'label' => __('Insured in'),
            'class' => 'form-control',

            'required' => false,
            'readonly' => true,
        )) . "</div>";



    $options=array('1'=>__('Public liability'),'2'=>__('Collision damage'),'3'=>__('All risks'));
    echo "<div class='form-group'>" . $this->Form->input('Event.assurance_type', array(
            'label' => __('Assurance type'),

            'type'=>'select',
            'options'=>$options,
            'class' => 'form-control',
            'disabled'=>true,
            'empty'=>__('Select assurance type'),

        )) . "</div>";





}

                 echo "<div class='form-group'>" . $this->Form->input('Event.folder_number', array(
                    'label' => __('Folder number'),
                    'class' => 'form-control',
                    
                    'id' => 'num_folder',
                   
                )) . "</div>";

?>