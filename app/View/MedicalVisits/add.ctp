<?= $this->Form->input('controller', [
    'id' => 'controller',
    'value' => $this->request->params['controller'],
    'type' => 'hidden'
]); ?>
<?= $this->Form->input('current_action', [
    'id' => 'current_action',
    'value' => $this->request->params['action'],
    'type' => 'hidden'
]); ?>

<?php

?><h4 class="page-title"> <?= __('Add') . ' ' . __('medical visit'); ?></h4>
    <div class="box">
        <div class="edit form card-box p-b-0">
            <?php echo $this->Form->create('MedicalVisit', array('onsubmit' => 'javascript:disable();')); ?>
            <div class="box-body">
                <?php

                echo "<div class='form-group'>" . $this->Form->input('visit_number', array(
                        'label' => __('Code'),
                        'class' => 'form-control',
                        'error' => array('attributes' => array('escape' => false),
                            'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                                __("The code must be unique") . '</label></div>', true)
                    )) . "</div>";
                echo "<div class='form-group'>" . $this->Form->input('customer_id', array(
                        'label' => __('Employee'),
                        'class' => 'form-control select-search-customer',
                        'empty' => '',
                        'id' => 'type'
                    )) . "</div>";
                $current_date = date("Y-m-d");
                echo "<div class='form-group'>" . $this->Form->input('date', array(
                        'label' => '',
                        'placeholder' => 'dd/mm/yyyy',
                        'type' => 'text',
                        'value' => $this->Time->format($current_date, '%d/%m/%Y'),
                        'class' => 'form-control datemask',
                        'before' => '<label>' . __('Date') . '</label><div class="input-group date ">
                                                <label for="Date"></label><div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>',
                        'after' => '</div>',
                        'id' => 'date',
                    )) . "</div>";
                echo "<div id='interval2'>";
                echo '<div class="lbl4">' . __("Type");
                echo "</div>";
                $options = array('1' => __('Internal'), '2' => __('External'));

                $attributes = array('legend' => false, 'value' => '1');
                echo $this->Form->radio('internal_external', $options, $attributes) . "</div><br/>";


                echo "<div class='form-group'>" . $this->Form->input('consulting_doctor', array(
                        'label' => __('Consulting doctor'),
                        'class' => 'form-control',
                    )) . "</div>";

                echo "<div class='form-group'>" . $this->Form->input('observation', array(
                        'label' => __('Observation'),
                        'class' => 'form-control',
                    )) . "</div>"; ?>
                <div id='attachment-file'>
                    <?php echo "<div class='form-group input-button'>" . $this->Form->input('attachment', array(
                            'label' => __('Attachment'),
                            'class' => 'form-control filestyle',
                            'type' => 'file',
                            'id' => 'att',
                        )) . "</div>";
                    $input = 'attachment';
                    ?>
                    <span class="popupactions"><button
                            class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "
                            id='image-btn' type="button"
                            onclick="delete_file('<?php echo $input ?>');"><i
                                class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
                            </span>
                </div>
                <div style="clear: both"></div>


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
            jQuery("#date").inputmask("date", {"placeholder": "dd/mm/yyyy"});

        });

        function delete_file(id) {


            $("#" + '' + id + '' + "-file").before(
                function () {
                    if (!$(this).prev().hasClass('input-ghost')) {
                        var element = $("<input type='file' class='input-ghost' style='display: none; visibility:hidden; height:0'>");
                        element.attr("name", $(this).attr("name"));
                        element.change(function () {
                            element.next(element).find('input').val((element.val()).split('\\').pop());
                        });

                        $(this).find("#" + '' + id + '' + "-btn").click(function () {
                            element.val(null);
                            $(this).parents("#" + '' + id + '' + "-file").find('input').val('');
                        });
                        $(this).find('input').css("cursor", "pointer");
                        /*$(this).find('input').mousedown(function() {
                         $(this).parents("#"+''+id+''+"-file").prev().click();
                         return false;
                         });*/
                        return element;
                    }
                }
            );
        }

    </script>
<?php $this->end(); ?>