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
$this->request->data['Transit']['date_declaration'] = $this->Time->format($this->request->data['Transit']['date_declaration'], '%d-%m-%Y');

?><h4 class="page-title"> <?= __('Edit') . ' ' . __('transit'); ?></h4>
    <div class="box">
        <div class="edit form card-box p-b-0">
            <?php echo $this->Form->create('Transit', array('onsubmit' => 'javascript:disable();')); ?>
            <div class="box-body">
                <?php
                echo $this->Form->input('id');
                  echo "<div class='form-group'>" . $this->Form->input('reference', array(
                        'label' => __('Reference'),
                        'class' => 'form-control',
                        'error' => array('attributes' => array('escape' => false),
                            'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                                __("The reference must be unique") . '</label></div>', true)
                    )) . "</div>";
                echo "<div class='form-group'>" . $this->Form->input('supplier_id', array(
                        'label' => __('Client'),
                        'class' => 'form-control select-search-client-initial',
                        'empty' => '',
                        'id' => 'supplier'
                    )) . "</div>";

                echo "<div class='form-group'>" . $this->Form->input('importer', array(
                        'label' => __('Importateur'),
                        'class' => 'form-control ',
                        'empty' => '',
                        'id' => ''
                    )) . "</div>";

                echo "<div class='form-group'>" . $this->Form->input('invoice_importer', array(
                        'label' => __('Facture import'),
                        'class' => 'form-control ',
                        'empty' => '',
                        'id' => ''
                    )) . "</div>";


                    ?>

                       <br/>
            <input
                   class="input-radio" type="radio"
                   name="data[Transit][bl_lta_lr]"
                   value=1 <?php if($this->request->data['Transit']['bl_lta_lr']==1)  { ?> checked='checked' <?php } ?>>
            <span class="label-radio"><?php echo __('BL') ?></span>
            <input
                   class="input-radio" type="radio"
                   name="data[Transit][bl_lta_lr]"
                   value=2 <?php if($this->request->data['Transit']['bl_lta_lr']==2)  { ?> checked='checked' <?php } ?>>
            <span class="label-radio"> <?php echo __('LTA') ?></span>
            <input
                   class="input-radio" type="radio"
                   name="data[Transit][bl_lta_lr]"
                   value=3 <?php if($this->request->data['Transit']['bl_lta_lr']==3)  { ?> checked='checked' <?php } ?>>
            <span class="label-radio"> <?php echo __('LR') ?></span><br/><br/>

                <?php

                echo "<div class='form-group'>" . $this->Form->input('nb_package', array(
                        'label' => __('Nombre de colis'),
                        'class' => 'form-control ',
                        'empty' => '',
                        'id' => ''
                    )) . "</div>";

                echo "<div class='form-group'>" . $this->Form->input('weight', array(
                        'label' => __('Poids'),
                        'class' => 'form-control ',
                        'empty' => '',
                        'id' => ''
                    )) . "</div>";

                echo "<div class='form-group'>" . $this->Form->input('comp_maritime', array(
                        'label' => __('Comp maritime'),
                        'class' => 'form-control ',
                        'empty' => '',
                        'id' => ''
                    )) . "</div>";

                echo "<div class='form-group'>" . $this->Form->input('num_tc', array(
                        'label' => __('N° TC'),
                        'class' => 'form-control ',
                        'empty' => '',
                        'id' => ''
                    )) . "</div>";

                echo "<div class='form-group'>" . $this->Form->input('nb_tc', array(
                        'label' => __('Nombre TC'),
                        'class' => 'form-control ',
                        'empty' => '',
                        'id' => ''
                    )) . "</div>";

                echo "<div class='form-group'>" . $this->Form->input('quai', array(
                        'label' => __('Quai'),
                        'class' => 'form-control ',
                        'empty' => '',
                        'id' => ''
                    )) . "</div>"; ?>


            <br/>
            <input
                   class="input-radio" type="radio"
                   name="data[Transit][imp_exp]"
                   value=1 <?php if($this->request->data['Transit']['imp_exp']==1)  { ?> checked='checked' <?php } ?>>
            <span class="label-radio"><?php echo __('Imp') ?></span>
            <input
                   class="input-radio" type="radio"
                   name="data[Transit][imp_exp]"
                   value=2 <?php if($this->request->data['Transit']['imp_exp']==2)  { ?> checked='checked' <?php } ?>>
            <span class="label-radio"> <?php echo __('Exp') ?></span>
            <br/><br/>

            <br/>
            <input
                   class="input-radio" type="radio"
                   name="data[Transit][regime_temp_regime_per]"
                   value=1 <?php if($this->request->data['Transit']['regime_temp_regime_per']==1){ ?> checked='checked' <?php } ?>>
            <span class="label-radio"><?php echo __('Regime temp') ?></span>
            <input
                   class="input-radio" type="radio"
                   name="data[Transit][regime_temp_regime_per]"
                   value=2 <?php if($this->request->data['Transit']['regime_temp_regime_per']==2){ ?> checked='checked' <?php } ?>>
            <span class="label-radio"> <?php echo __('Regime per') ?></span>
            <br/><br/>

                <?php

                echo "<div class='form-group'>" . $this->Form->input('regime', array(
                        'label' => __('Regime'),
                        'class' => 'form-control ',
                        'empty' => '',
                        'id' => ''
                    )) . "</div>";

                echo "<div class='form-group'>" . $this->Form->input('num_declaration', array(
                        'label' => __('N° declaration'),
                        'class' => 'form-control ',
                        'empty' => '',
                        'id' => ''
                    )) . "</div>";
              echo "<div class='form-group'>" . $this->Form->input('date_declaration', array(
                        'label' => '',
                        'placeholder' => 'dd/mm/yyyy',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'before' => '<label>' . __('Date declaration') . '</label><div class="input-group date ">
                                                <label for="Date"></label><div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>',
                        'after' => '</div>',
                        'id' => 'date_declaration',
                    )) . "</div>";


                echo "<div class='form-group'>" . $this->Form->input('rep', array(
                        'label' => __('Rep'),
                        'class' => 'form-control ',
                        'empty' => '',
                        'id' => ''
                    )) . "</div>";

                echo "<div class='form-group'>" . $this->Form->input('declarant', array(
                        'label' => __('Declarant'),
                        'class' => 'form-control ',
                        'empty' => '',
                        'id' => ''
                    )) . "</div>"; ?>


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
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
    <script type="text/javascript">

        $(document).ready(function () {







            jQuery("#date_declaration").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        });




    </script>
<?php $this->end(); ?>