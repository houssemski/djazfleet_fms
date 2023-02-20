<?php
echo '<br/>';
echo '<br/>';
echo '<br/>';
echo $this->Form->create('Customer' , array('onsubmit'=> 'javascript:disable();'));
                    echo "<div class='form-group' >" .  $this->Form->input('customer_group_id',  array(
                    'label' => __('Group'),
                    'class' => 'form-control',
                  //  'option' => $customerGroups,
                    'empty' =>'',
                      'type'=>'select'
                        )) . "</div>";

               echo "<br/>";

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
<?php die(); ?>