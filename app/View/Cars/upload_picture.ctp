


<?php
$file_name = str_replace('||||',' ',$file_name);
if ($Dir=='yellowcard'){
 
              echo "<div class='col-sm-3 yellowcarddiv' id='yellowcard'>" . $this->Form->input('Car.yellow_card_dir', array(
                        'label' => __('Yellow Card'),
                        'readonly' => true,
                        'value'=>$file_name,
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';

          }

          if ($Dir=='greycard'){
 
              echo "<div class='col-sm-3 yellowcarddiv' id='greycard'>" . $this->Form->input('Car.grey_card_dir', array(
                        'label' => __('Grey Card'),
                        'readonly' => true,
                        'value'=>$file_name,
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';

          }


           
?>