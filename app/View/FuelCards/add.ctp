<?php

?><h4 class="page-title"> <?=__('Add fuel card'); ?></h4>
    <div class="box">
        <div class="edit form card-box p-b-0">
            <?php echo $this->Form->create('FuelCard', array('onsubmit'=> 'javascript:disable();')); ?>
            <div class="box-body">
                <?php
                echo "<div class='form-group'>".$this->Form->input('reference', array(
                        'label' => __('Reference'),
                        'class' => 'form-control',

                    ))."</div>";

                echo "<div class='form-group'>".$this->Form->input('amount', array(
                        'label' => __('Amount'),
                        'class' => 'form-control',
                    ))."</div>";
                ?>
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
<?php $this->start('script'); ?>
    <!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
<?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
    <script type="text/javascript">     $(document).ready(function() {

            jQuery("#date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        });

    </script>
<?php $this->end(); ?>