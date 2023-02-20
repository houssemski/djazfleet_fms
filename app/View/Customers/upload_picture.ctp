


<?php

$file_name = str_replace('||||',' ',$file_name);

if ($Dir=='attachment_rc'){
 
              echo "<div class='col-sm-3 yellowcarddiv' id='attachment_rc'>" . $this->Form->input('Customer.attachment_rc_dir', array(
                        'label' => __('Attachment RC'),
                        'readonly' => true,
                        'value'=>$file_name,
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';

          }

if ($Dir=='attachment_if'){
 
              echo "<div class='col-sm-3 yellowcarddiv' id='attachment_if'>" . $this->Form->input('Customer.attachment_if_dir', array(
                        'label' => __('Attachment IF'),
                        'readonly' => true,
                        'value'=>$file_name,
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';

          }

if ($Dir=='attachment_ai'){
 
              echo "<div class='col-sm-3 yellowcarddiv' id='attachment_ai'>" . $this->Form->input('Customer.attachment_ai_dir', array(
                        'label' => __('Attachment AI'),
                        'readonly' => true,
                        'value'=>$file_name,
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';

          }




         


           
?>