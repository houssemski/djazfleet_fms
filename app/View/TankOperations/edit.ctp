<?php
?><h4 class="page-title"> <?= __('Edit fuel in tank'); ?></h4>
    <div class="box">
        <div class="edit form card-box p-b-0">
            <?php
            $this->request->data['TankOperation']['date_add'] = $this->Time->format($this->request->data['TankOperation']['date_add'], '%d-%m-%Y');


            echo $this->Form->create('TankOperation', array('onsubmit' => 'javascript:disable();')); ?>
            <div class="box-body">
                <?php
                echo $this->Form->input('id');
                echo "<div class='form-group'>" . $this->Form->input('tank_id', array(
                        'label' => __('Tank'),
                        'empty' => '',
                        'class' => 'form-control select2',
                        'onchange' => 'javascript: verifyCapacity();',
                        'id' => 'tank'
                    )) . "</div>";
                echo "<div class='form-group' id ='liter-div'>" . $this->Form->input('liter', array(
                        'label' => __('Liter'),
                        'placeholder' => __('Enter liter'),
                        'class' => 'form-control',
                        'onchange' => 'javascript: verifyCapacity();',
                        'id' => 'liter'
                    )) . "</div>";

                echo "<div class='form-group'>" . $this->Form->input('date_add', array(
                        'label' => '',
                        'placeholder' => 'dd/mm/yyyy',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'before' => '<label>' . __('Date') . '</label><div class="input-group date"><label for="CarCirculationDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                        'after' => '</div>',
                        'id' => 'date_add',
                    )) . "</div>";
                ?>
            </div>
            <div class="box-footer">
                <?php echo $this->Form->submit(__('Submit'), array(
                    'name' => 'ok',
                    'class' => 'btn btn-primary btn-bordred  m-b-5',
                    'label' => __('Submit'),
                    'type' => 'submit',
                    'id' => 'boutonValider',
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
    <script type="text/javascript">

        $(document).ready(function () {
            jQuery("#date_add").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        });

        function verifyCapacity() {
            if(jQuery('#liter').val()>0 && jQuery('#tank').val()>0) {
                jQuery('#liter-div').load('<?php echo $this->Html->url('/tankOperations/getMaxLiter/')?>' + jQuery('#liter').val() + '/' + jQuery('#tank').val(), function () {
                });
            }
            }
    </script>
<?php $this->end(); ?>