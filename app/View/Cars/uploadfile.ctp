<?php



echo $this->Form->create('Car', array(
    'url'=> array(
        'action' =>'uploadfile'
    ),
    'enctype' => 'multipart/form-data'
));
        echo "<div >" . $this->Form->input('file', array(
                                'label' => '',
                             
                                'type' => 'file',
                                'empty' => ''
                            )) . "</div>";
echo '</br>';
//echo $this->Html->link(__('Add event'), 'javascript:UploadFile();' , array('escape' => false )); 

echo $this->Form->submit(__('Submit'), array(
                'name' => 'ok',
                'class' => 'btn btn-primary',
                'label' => __('Submit'),
                'type' => 'submit',
                'div' => false
            )); 
?>