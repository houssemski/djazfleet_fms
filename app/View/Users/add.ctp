

<?php
?><h4 class="page-title"> <?=__('Add User'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0">

        <?php echo $this->Form->create('User', array('type' => 'file', 'onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">
            <?php
            echo "<div class='form-group'>" . $this->Form->input('first_name', array(
                    'label' => __('First name'),
                    'placeholder' => __('Enter first name'),
                    'class' => 'form-control',
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('last_name', array(
                    'placeholder' => __('Enter last name'),
                    'label' => __('Last name'),
                    'class' => 'form-control',
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('email', array(
                    'placeholder' => __('Enter email'),
                    'label' => __('Email'),
                    'class' => 'form-control',
                    'error' => array('attributes' => array('escape' => false),
                        'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                            __("The email must be unique") . '</label></div>', true)
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('username', array(
                    'label' => __('Username'),
                    'placeholder' => __('Enter username'),
                    'class' => 'form-control',
                    'error' => array('attributes' => array('escape' => false),
                        'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                            __("The username must be unique") . '</label></div>', true)
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('password', array(
                    'label' => __('Password'),
                    'placeholder' => __('Enter password'),
                    'class' => 'form-control',
                )) . "</div>";
            
             echo "<div class='form-group'>" . $this->Form->input('language_id', array(
                            'label' => __('Language'),
                            'class' => 'form-control',
                            'empty' => ''
                        )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('profile_id', array(
                    'label' => __('Profile'),
                    'class' => 'form-control select2',
					'id'=>'profile',
                    'empty' => ''
                )) . "</div>"; ?>
            <div  id='client'>




            </div>
			<?php

            echo "<div class='form-group'>" . $this->Form->input('UserParc.parcs', array(
                    'label' => __('Parc'),
                    'class' => 'form-control',
                    'multiple' => true,
                    'empty' => ''
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('picture', array(
                    'label' => __('Picture'),
                    'class' => 'form-control filestyle',
                    'type' => 'file',
                    'empty' => ''
                )) . "</div>";
                 echo    "<div class='form-group'>" .$this->Form->input('super_admin', array(
                            'label' => __('Super admin'),
                            'type'=>'checkbox',
                            'checked'=>false
                            )). "</div>";

                 echo "<div class='form-group chk'>".$this->Form->input('receive_alert', array(
                    'label' => __('Receive alert'),
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
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('jquery-2.1.1.min.js'); ?>
<?= $this->Html->script('jquery.form.min.js'); ?>
<script type="text/javascript">

    $(document).ready(function() {

        jQuery('#profile').change(function () {
            jQuery('#client').load('<?php echo $this->Html->url('/users/getCustomers/')?>'+ jQuery(this).val(), function() {
                $('.select-search-client-initial').select2({
                    ajax: {
                        url: "<?php echo $this->Html->url('/suppliers/getInitialSuppliersByKeyWord')?>",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: $.trim(params.term)
                            };
                        },
                        processResults: function (data, page) {
                            return {results: data};
                        },
                        cache: true
                    },
                    minimumInputLength: 2

                });
                $('.select3').select2();
            });
        });


    });


</script>
<?php $this->end(); ?>

