
<?php
if($this->params['pass']['0']==0){
    ?><h4 class="page-title"> <?=__('Add supplier category');?></h4>

<?php }else {
    ?><h4 class="page-title"> <?=__('Add client category');?></h4>

<?php } ?>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('SupplierCategory', array('onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">
            <div class="nav-tabs-custom pdg_btm">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>

                    <li><a href="#tab_2" data-toggle="tab"><?= __('Attachments') ?></a></li>


                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <?php
                        echo "<div class='form-group'>".$this->Form->input('code', array(
                                'label' => __('Code'),
                                'class' => 'form-control',
                                'error' => array('attributes' => array('escape' => false),
                                    'unique' => '<div class="form-group has-error">
																	<label class="control-label" for="inputError">
																	<i class="fa fa-times-circle-o"></i>'.
                                        __("The code must be unique") . '</label></div>', true)
                            ))."</div>";

                        echo "<div class='form-group'>".$this->Form->input('type', array(
                                'label' => __('type'),
                                'type'=>'hidden',
                                'value'=>$this->params['pass']['0'],
                                'class' => 'form-control',
                            ))."</div>";
                        echo "<div class='form-group'>".$this->Form->input('name', array(
                                'label' => __('Name'),
                                'class' => 'form-control',
                            ))."</div>";
                        ?>

                    </div>


                    <div class="tab-pane " id="tab_2">
                        <?php
                        foreach ($attachmentTypes as $attachmentType) {

                            echo "<div class='form-group'>" . $this->Form->input('SupplierCategoryAttachmentType.' . $attachmentType['AttachmentType']['id'], array(
                                    'label' => $attachmentType['AttachmentType']['name'],
                                    'class' => 'form-control ',
                                    'type' => 'checkbox',
                                    'empty' => ''
                                )) . "</div>";
                        }



                        ?>
                    </div>



                </div>


            </div>


        </div>



        <div class="box-footer">
            <?php echo $this->Form->submit(__('Submit'), array(
                'name' => 'ok',
                'class' => 'btn btn-primary btn-bordred  m-b-5',
                'label' => __('Submit'),
                'type' => 'submit',
                'id'=>'boutonValider',
                'div' => false
            )); ?>
            <?php echo $this->Form->submit(__('Cancel'), array(
                'name' => 'cancel',
                'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                'label' => __('Cancel'),
                'type' => 'submit',
                'div' => false,
                'formnovalidate' => true
            )); ?>
        </div>
    </div>

</div>
