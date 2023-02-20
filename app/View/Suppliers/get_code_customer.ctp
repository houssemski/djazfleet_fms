 <?php
 
 echo "<div  class='form-group'>" . $this->Form->input('Supplier.code', array(
                                    'label' => __('Code'),
                                    'class' => 'form-control',
                                    'value' => $code,
                                    'readonly' => true,
                                    'placeholder' => __('Enter code'),
                                )) . "</div>";