<?php 

echo "<div >" . $this->Form->input('section_id', array(
                                'label' => __('Section'),
                                'class' => 'form-control select2',
                                'id' => 'section',
                                'empty' => __('Select section')
                            )) . "</div>"; 
?>