<?php
include("ctp/datetime.ctp");

?><h4 class="page-title"> <?=__('Add affectation'); ?></h4>
    <div class="box">
        <div class="edit form card-box p-b-0">
            <?php echo $this->Form->create('FuelCardAffectation', array('onsubmit'=> 'javascript:disable();')); ?>
            <div class="box-body">
                <?php
                echo "<div class='form-group'>".$this->Form->input('reference', array(
                        'label' => __('Reference'),
                        'class' => 'form-control',
                        'placeholder' =>__('Enter reference'),
                    ))."</div>";
                echo "<div class='form-group'>".$this->Form->input('fuel_card_id', array(
                        'label' => __('Fuel card'),
                        'empty' =>'',
                        'class' => 'form-control select2',
                    ))."</div>";

                echo "<div class='form-group'>".$this->Form->input('FuelCardCar.car_id', array(
                        'label' => __('Car'),
                        'empty' =>'',
                        'class' => 'form-control select2',
                        'multiple' =>true,
                    ))."</div>";

                echo "<div class='form-group'>" . $this->Form->input('start_date', array(
                        'label' => false,
                        'placeholder' => 'dd/mm/yyyy',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'before' => '<label>' . __('Start date ') . '</label><div class="input-group datetime"><label for="StartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                        'after' => '</div>',
                        'id' => 'start_date',
                        'allowEmpty' => true,

                    )) . "</div>";

                echo "<div class='form-group'>" . $this->Form->input('end_date', array(
                        'label' => false,
                        'placeholder' => 'dd/mm/yyyy',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'before' => '<label>' . __('End date') . '</label><div class="input-group datetime"><label for="EndDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                        'after' => '</div>',
                        'id' => 'end_date',
                        'allowEmpty' => true,
                    )) . "</div>";






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

            jQuery("#start_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            jQuery("#end_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        });

    </script>
<?php $this->end(); ?>