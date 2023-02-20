<?= $this->Form->input('controller', array(
    'id' => 'controller',
    'value' => $this->request->params['controller'],
    'type' => 'hidden'
)); ?>
<?= $this->Form->input('current_action', array(
    'id' => 'current_action',
    'value' => $this->request->params['action'],
    'type' => 'hidden'
)); ?>

<?php
$this->request->data['Slip']['date_slip'] = $this->Time->format($this->request->data['Slip']['date_slip'], '%d-%m-%Y');
?><h4 class="page-title"> <?=__('Edit slip'); ?></h4>
    <div class="box">
        <div class="edit form card-box p-b-0">
            <?php echo $this->Form->create('date_slip' , array('onsubmit'=> 'javascript:disable();')); ?>
            <div class="box-body">
                <?php
                echo $this->Form->input('id');
                echo "<div class='form-group'>".$this->Form->input('reference', array(
                        'label' => __('Reference'),
                        'class' => 'form-control',
                        'error' => array('attributes' => array('escape' => false),
                            'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>'.
                                __("The reference must be unique") . '</label></div>', true)
                    ))."</div>";
                $date = date("Y-m-d");
                echo "<div class='form-group '>" . $this->Form->input('date_slip', array(
                        'label' => '',
                        'placeholder' => 'dd/mm/yyyy',
                        'type' => 'text',
                        'value' => $this->Time->format($date, '%d/%m/%Y'),
                        'class' => 'form-control datemask',
                        'before' => '<label>' . __('Date') .
                            '</label><div class="input-group date"><label for="SlipDateSlip"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                        'after' => '</div>',
                        'id' => 'date_slip',
                    )) . "</div>";

                echo "<div class='form-group'>".$this->Form->input('supplier_id', array(
                        'label' => __('Supplier'),
                        'class' => 'form-control select2',
                        'empty'=>'',
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
<?= $this->Html->script('jquery-2.1.1.min.js'); ?>
<?= $this->Html->script('jquery.form.min.js'); ?>

    <script type="text/javascript">
        $(document).ready(function () {
            jQuery("#date_slip").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        });


    </script>

<?php $this->end(); ?>