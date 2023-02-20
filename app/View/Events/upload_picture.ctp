


<?php

$file_name = str_replace('||||',' ',$file_name);

if ($Dir=='attachment1'){
 
              echo "<div class='col-sm-3 yellowcarddiv' id='attachment1'>" . $this->Form->input('Event.attachment1_dir', array(
                        'label' => '',
                        'readonly' => true,
                        'value'=>$file_name,
                        'class' => 'form-control input_att',
                        
                        
                    )) . '</div>';

          }

if ($Dir=='attachment2'){
 
              echo "<div class='col-sm-3 yellowcarddiv' id='attachment2'>" . $this->Form->input('Event.attachment2_dir', array(
                        'label' => '',
                        'readonly' => true,
                        'value'=>$file_name,
                        'class' => 'form-control input_att',
                        
                        
                    )) . '</div>';

          }

if ($Dir=='attachment3'){
 
              echo "<div class='col-sm-3 yellowcarddiv' id='attachment3'>" . $this->Form->input('Event.attachment3_dir', array(
                        'label' => '',
                        'readonly' => true,
                        'value'=>$file_name,
                        'class' => 'form-control input_att',
                        
                        
                    )) . '</div>';

          }

if ($Dir=='attachment4'){
 
              echo "<div class='col-sm-3 yellowcarddiv' id='attachment4'>" . $this->Form->input('Event.attachment4_dir', array(
                        'label' => '',
                        'readonly' => true,
                        'value'=>$file_name,
                        'class' => 'form-control input_att',
                        
                        
                    )) . '</div>';

          }

if ($Dir=='attachment5'){
 
              echo "<div class='col-sm-3 yellowcarddiv' id='attachment5'>" . $this->Form->input('Event.attachment5_dir', array(
                        'label' => '',
                        'readonly' => true,
                        'value'=>$file_name,
                        'class' => 'form-control input_att',
                        
                        
                    )) . '</div>';

          }

         


           
?>