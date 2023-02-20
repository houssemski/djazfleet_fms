
    <div class="box">

            <?php echo $this->Form->create('ComplaintResponse' , array('onsubmit'=> 'javascript:disable();')); ?>
            <div class="box-body">
                <?php
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
                echo "<div class='form-group '>" . $this->Form->input('response_date', array(
                        'label' => '',
                        'placeholder' => 'dd/mm/yyyy',
                        'type' => 'text',
                        'value' => $this->Time->format($date, '%d/%m/%Y'),
                        'class' => 'form-control datemask',
                        'before' => '<label>' . __('Date') .
                            '</label><div class="input-group date"><label for="ResponseDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                        'after' => '</div>',
                        'id' => 'response_date',
                    )) . "</div>";

                echo "<div class='form-group'>".$this->Form->input('treatment_id', array(
                        'label' => __('Treatment'),
                        'class' => 'form-control select2',
                        'empty'=>'',
                    ))."</div>";





                echo "<div class='form-group'>".$this->Form->input('observation', array(
                        'label' => __('Observation'),
                        'class' => 'form-control',
                    ))."</div>";

                echo "<div class='form-group'>".$this->Form->input('complaint_id', array(
                        'type' => 'hidden',
                        'value'=>$complaintId,
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
            jQuery("#complaint_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        });


    </script>

<?php $this->end(); ?>