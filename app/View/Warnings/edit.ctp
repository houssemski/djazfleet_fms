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
$this->request->data['Warning']['start_date'] = $this->Time->format($this->request->data['Warning']['start_date'], '%d-%m-%Y');
$this->request->data['Warning']['end_date'] = $this->Time->format($this->request->data['Warning']['end_date'], '%d-%m-%Y');

?><h4 class="page-title"> <?= __('Edit') . ' ' . __('warning'); ?></h4>
    <div class="box">
        <div class="edit form card-box p-b-0">
            <?php echo $this->Form->create('Warning', array('onsubmit' => 'javascript:disable();')); ?>
            <div class="box-body">
                <?php
                echo $this->Form->input('id');
                echo "<div class='form-group'>" . $this->Form->input('code', array(
                        'label' => __('Code'),
                        'class' => 'form-control',
                        'error' => array('attributes' => array('escape' => false),
                            'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                                __("The code must be unique") . '</label></div>', true)
                    )) . "</div>";
                echo "<div class='form-group'>" . $this->Form->input('customer_id', array(
                        'label' => __('Customer'),
                        'class' => 'form-control select-search-customer',
                        'empty' => '',
                        'id' => 'customer'
                    )) . "</div>";
                echo "<div class='form-group input-button' id='type-div'>" . $this->Form->input('warning_type_id', array(
                        'label' => __('Warning type'),
                        'class' => 'form-control select3',
                        'empty' => '',
                        'id' => 'type'
                    )) . "</div>"; ?>

                <div class="btn-group quick-actions">
                    <div id="dialogModalType">
                        <!-- the external content is loaded inside this tag -->
                        <div id="contentWrapType"></div>
                    </div>
                    <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <?php echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add', true),
                                array("controller" => "warningTypes", "action" => "addType"),
                                array(
                                    "class" => "btn overlayType",
                                    'escape' => false,
                                    "title" => __("Add type")
                                )); ?>
                        </li>
                        <li>
                            <a href="#" class="btn overlayEditType" title=<?php echo __("Edit type") ?>>
                                <i class="fa fa-edit m-r-5"></i><?= __("Edit") ?>
                            </a>
                        </li>
                    </ul>
                </div>



            <?php    echo "<div class='form-group'>" . $this->Form->input('start_date', array(
                        'label' => '',
                        'placeholder' => 'dd/mm/yyyy',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'before' => '<label>' . __('Start date') . '</label><div class="input-group date ">
                                                <label for="Date"></label><div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>',
                        'after' => '</div>',
                        'id' => 'start_date',
                    )) . "</div>";

                echo "<div class='form-group'>" . $this->Form->input('end_date', array(
                        'label' => '',
                        'placeholder' => 'dd/mm/yyyy',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'before' => '<label>' . __('End date') . '</label><div class="input-group date ">
                                                <label for="Date"></label><div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>',
                        'after' => '</div>',
                        'id' => 'end_date',
                    )) . "</div>";

                echo "<div class='form-group'>" . $this->Form->input('note', array(
                        'label' => __('Note'),
                        'class' => 'form-control',
                    )) . "</div>"; ?>
                <div id='attachment-file'>
                    <?php
                    echo "<div style='Display:none;'>" . $this->Form->input('attachment', array(
                            'label' => __('Attachment'),
                            'readonly' => true,
                            'id' => 'att',
                            'type' => 'file',
                            'class' => 'form-control',
                        )) . '</div>';

                    echo "<div class='form-group input-button4' >" . $this->Form->input('file', array(
                            'label' => __('Attachment'),
                            'readonly' => true,
                            'id' => 'file',
                            'value' => $this->request->data['Warning']['attachment'],
                            'class' => 'form-control',
                        )) . '</div>';
                    echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),
                            'javascript:',
                            array('escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'upfile',
                            )) . '</div>'; ?>
                    <span class='popupactions'>
                                         <button
                                             class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "
                                             id='image-btn' type="button" onclick="delete_file('image');"><i
                                                 class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
                                    </span>
                </div>

                <div style="clear:both;"></div>


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

            jQuery("#dialogModalType").dialog({
                autoOpen: false,
                height: 300,
                width: 400,
                show: {
                    effect: "blind",
                    duration: 400
                },
                hide: {
                    effect: "blind",
                    duration: 500
                },
                modal: true
            });

            jQuery(".overlayType").click(function (event) {
                event.preventDefault();
                jQuery('#contentWrapType').load(jQuery(this).attr("href"));
                var typeDiv = jQuery('#dialogModalType');
                typeDiv.dialog('option', 'title', jQuery(this).attr("title"));
                typeDiv.dialog('open');
            });

            jQuery(".overlayEditType").click(function (event) {

                event.preventDefault();
                var typeId = jQuery("#type").val();

                if (typeId > 0) {
                    var typeDiv = jQuery('#dialogModalType');
                    typeDiv.dialog('option', 'title', jQuery(this).attr("title"));
                    typeDiv.dialog('open');
                    jQuery('#contentWrapType').load("<?php echo $this->Html->url('/warningTypes/editType/')?>" + typeId  );
                }
            });

            jQuery("#start_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            jQuery("#end_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
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