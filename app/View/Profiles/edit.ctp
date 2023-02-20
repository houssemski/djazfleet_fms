<style>
    .checkbox label::before {
        background-color: transparent;
        border: none;
    }
</style>
<?php
/**
 * @var int $moduleId
 * @var int $subModuleId
 */
$this->start('css');

echo $this->Html->css('iCheck/flat/red');
echo $this->Html->css('iCheck/all');
$this->end();
?>
<h4 class="page-title"> <?= __('Edit Profile'); ?></h4>
<div class="box-body card-box p-b-10">
    <?php
    echo $this->Form->create('Profile', array('onsubmit' => 'javascript:disable();'));
    echo $this->Form->input('Profile.id');
    echo "<div class='form-group'>" . $this->Form->input('Profile.name', array(
            'label' => __('Name'),
            'class' => 'form-control',
        )) . "</div>";
		
	echo "<div class='form-group'>" . $this->Form->input('Profile.parent_id', array(
            'label' => __('Parent'),
			'empty'=>'',
            'options'=>$profiles,
            'class' => 'form-control select2',
        )) . "</div>";

    echo "<div class=' col-sm-6' >" . $this->Form->input('module_id', array(
            'label' => __('Module'),
            'class' => 'form-control select2',
            'id' => 'module',
            'required' => true,
            'empty' => '',
            'value' => isset($moduleId) ? $moduleId : ''
        )) . "</div>";

    echo "<div class=' col-sm-6' id ='sub_module_div'>" . $this->Form->input('sub_module_id', array(
            'label' => __('Sub module'),
            'class' => 'form-control select2',
            'id' => 'sub_module',
            'required' => true,
            'empty' => ''
        )) . "</div>";

    echo "<div >" . $this->Form->input('submodules', array(
            'label' => __('Sub module'),
            'type' => 'hidden',
            'id' => 'sub_modules',
            'empty' => ''
        )) . "</div>";

    echo "</br>";
    echo "</br>";

    ?>

    <div id='section_action_div'>
    </div>

    <br>
    <br>
    <br>

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
    <?php
    echo $this->Form->end();
    ?>

</div>
<?php $this->start('script'); ?>
<?= $this->Html->script('plugins/iCheck/icheck.min'); ?>
<script language="javascript">
    $(document).ready(function () {
        jQuery('#module').parent().addClass('required');
        jQuery('#sub_module').parent().addClass('required');
        jQuery('#section').parent().addClass('required');
        var subModules = new Array();
        jQuery('#module').change(function () {

            jQuery('#sub_module_div').load('<?php echo $this->Html->url('/profiles/getSubModulesByModule/')?>' + jQuery(this).val(), function () {
                jQuery('.select2').select2();
                jQuery('#sub_module').parent().addClass('required');
                jQuery('#sub_module').change(function () {
                    var moduleId = jQuery('#module').val();
                    var id = moduleId + jQuery(this).val();
                    var subModuleId = jQuery('#sub_module').val();

                    subModules.push(subModuleId);
                    jQuery('#sub_modules').val(subModules);
                    jQuery('.div-table').css('visibility', 'hidden');
                    jQuery('.div-table').css('height', 0);
                    jQuery('#section_action_div').append('<div class ="div-table" id = "div' + id + '"></div>');
                    jQuery("#div" + '' + id + '').css('visibility', 'visible');
                    jQuery("#div" + '' + id + '').css('height', 'auto');
                    var profileId = jQuery('#ProfileId').val();
                    jQuery("#div" + '' + id + '').load('<?php echo $this->Html->url('/profiles/getSectionActionsBySubModule/')?>' + moduleId + '/' + jQuery(this).val() + '/' + profileId, function () {
                        jQuery('.select2').select2();
                        $('input[type="checkbox"]').iCheck({
                            checkboxClass: 'icheckbox_flat-red',
                            radioClass: 'iradio_flat-red'
                        });

                        $("#checkbox1" + '' + subModuleId + '').click(function () {

                            var clicks = $(this).data('clicks');

                            if (clicks) {
                                //Uncheck all checkboxes
                                $(".id1" + '' + subModuleId + '').iCheck("uncheck");
                                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                            } else {
                                //Check all checkboxes
                                $(".id1" + '' + subModuleId + '').iCheck("check");
                                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');

                            }
                            $(this).data("clicks", !clicks);
                        });

                        $("#checkbox2" + '' + subModuleId + '').click(function () {
                            var clicks = $(this).data('clicks');
                            if (clicks) {
                                //Uncheck all checkboxes
                                $(".id2" + '' + subModuleId + '').iCheck("uncheck");
                                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                            } else {
                                //Check all checkboxes
                                $(".id2" + '' + subModuleId + '').iCheck("check");
                                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');

                            }
                            $(this).data("clicks", !clicks);
                        });

                        $("#checkbox3" + '' + subModuleId + '').click(function () {
                            var clicks = $(this).data('clicks');
                            if (clicks) {
                                //Uncheck all checkboxes
                                $(".id3" + '' + subModuleId + '').iCheck("uncheck");
                                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                            } else {
                                //Check all checkboxes
                                $(".id3" + '' + subModuleId + '').iCheck("check");
                                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');

                            }
                            $(this).data("clicks", !clicks);
                        });

                        $("#checkbox4" + '' + subModuleId + '').click(function () {
                            var clicks = $(this).data('clicks');
                            if (clicks) {
                                //Uncheck all checkboxes
                                $(".id4" + '' + subModuleId + '').iCheck("uncheck");
                                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                            } else {
                                //Check all checkboxes
                                $(".id4" + '' + subModuleId + '').iCheck("check");
                                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');

                            }
                            $(this).data("clicks", !clicks);
                        });

                        $("#checkbox5" + '' + subModuleId + '').click(function () {
                            var clicks = $(this).data('clicks');
                            if (clicks) {
                                //Uncheck all checkboxes
                                $(".id5" + '' + subModuleId + '').iCheck("uncheck");
                                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                            } else {
                                //Check all checkboxes
                                $(".id5" + '' + subModuleId + '').iCheck("check");
                                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');

                            }
                            $(this).data("clicks", !clicks);
                        });

                        $("#checkbox6" + '' + subModuleId + '').click(function () {
                            var clicks = $(this).data('clicks');
                            if (clicks) {
                                //Uncheck all checkboxes
                                $(".id6" + '' + subModuleId + '').iCheck("uncheck");
                                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                            } else {
                                //Check all checkboxes
                                $(".id6" + '' + subModuleId + '').iCheck("check");
                                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');

                            }
                            $(this).data("clicks", !clicks);
                        });

                        $("#checkbox7" + '' + subModuleId + '').click(function () {
                            var clicks = $(this).data('clicks');
                            if (clicks) {
                                //Uncheck all checkboxes
                                $(".id7" + '' + subModuleId + '').iCheck("uncheck");
                                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                            } else {
                                //Check all checkboxes
                                $(".id7" + '' + subModuleId + '').iCheck("check");
                                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');

                            }
                            $(this).data("clicks", !clicks);
                        });

                        $("#checkbox8" + '' + subModuleId + '').click(function () {
                            var clicks = $(this).data('clicks');
                            if (clicks) {
                                //Uncheck all checkboxes
                                $(".id8" + '' + subModuleId + '').iCheck("uncheck");
                                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                            } else {
                                //Check all checkboxes
                                $(".id8" + '' + subModuleId + '').iCheck("check");
                                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');

                            }
                            $(this).data("clicks", !clicks);
                        });

                        $("#checkbox9" + '' + subModuleId + '').click(function () {
                            var clicks = $(this).data('clicks');
                            if (clicks) {
                                //Uncheck all checkboxes
                                $(".id9" + '' + subModuleId + '').iCheck("uncheck");
                                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                            } else {
                                //Check all checkboxes
                                $(".id9" + '' + subModuleId + '').iCheck("check");
                                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');

                            }
                            $(this).data("clicks", !clicks);
                        });

                        $("#checkbox10" + '' + subModuleId + '').click(function () {
                            var clicks = $(this).data('clicks');
                            if (clicks) {
                                //Uncheck all checkboxes
                                $(".id10" + '' + subModuleId + '').iCheck("uncheck");
                                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                            } else {
                                //Check all checkboxes
                                $(".id10" + '' + subModuleId + '').iCheck("check");
                                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');

                            }
                            $(this).data("clicks", !clicks);
                        });

                        $("#checkbox11" + '' + subModuleId + '').click(function () {
                            var clicks = $(this).data('clicks');
                            if (clicks) {
                                //Uncheck all checkboxes
                                $(".id11" + '' + subModuleId + '').iCheck("uncheck");
                                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                            } else {
                                //Check all checkboxes
                                $(".id11" + '' + subModuleId + '').iCheck("check");
                                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');

                            }
                            $(this).data("clicks", !clicks);
                        });

                        $("#checkbox12" + '' + subModuleId + '').click(function () {
                            var clicks = $(this).data('clicks');
                            if (clicks) {
                                //Uncheck all checkboxes
                                $(".id12" + '' + subModuleId + '').iCheck("uncheck");
                                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                            } else {
                                //Check all checkboxes
                                $(".id12" + '' + subModuleId + '').iCheck("check");
                                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');

                            }
                            $(this).data("clicks", !clicks);
                        });

                        $("#checkbox13" + '' + subModuleId + '').click(function () {
                            var clicks = $(this).data('clicks');
                            if (clicks) {
                                //Uncheck all checkboxes
                                $(".id13" + '' + subModuleId + '').iCheck("uncheck");
                                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                            } else {
                                //Check all checkboxes
                                $(".id13" + '' + subModuleId + '').iCheck("check");
                                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');

                            }
                            $(this).data("clicks", !clicks);
                        });

                        $("#checkbox14" + '' + subModuleId + '').click(function () {
                            var clicks = $(this).data('clicks');
                            if (clicks) {
                                //Uncheck all checkboxes
                                $(".id14" + '' + subModuleId + '').iCheck("uncheck");
                                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                            } else {
                                //Check all checkboxes
                                $(".id14" + '' + subModuleId + '').iCheck("check");
                                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');

                            }
                            $(this).data("clicks", !clicks);
                        });

                        $("#checkbox15" + '' + subModuleId + '').click(function () {
                            var clicks = $(this).data('clicks');
                            if (clicks) {
                                //Uncheck all checkboxes
                                $(".id15" + '' + subModuleId + '').iCheck("uncheck");
                                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                            } else {
                                //Check all checkboxes
                                $(".id15" + '' + subModuleId + '').iCheck("check");
                                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');

                            }
                            $(this).data("clicks", !clicks);
                        });


                    });
                });
            });
        });


        jQuery('#sub_module').change(function () {
            var action = 'edit';
            jQuery('#section_action_div').load('<?php echo $this->Html->url('/profiles/getSectionActionsBySubModule/')?>' + jQuery(this).val() + '/' + action, function () {
                jQuery('.select2').select2();
            });
        });


        jQuery('input.checkall').on('ifUnchecked', function (event) {
            var ischecked = false;
            jQuery(":checkbox.checkall").each(function () {
                if (jQuery(this).prop('checked'))
                    ischecked = true;
            });

        });
        $(' input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'


        });

        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function () {

            var clicks = $(this).data('clicks');
            if (clicks) {
                //Uncheck all checkboxes
                $(" input[type='checkbox']").iCheck("uncheck");
                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');


            } else {
                //Check all checkboxes
                $(" input[type='checkbox']").iCheck("check");
                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');

            }
            $(this).data("clicks", !clicks);
        });

        jQuery('input.checkall').on('ifClicked', function (event) {

            for (i = 1; i <= 11; i++) {

                var cases = jQuery("#Right1ActionId" + i);

                //var cases = jQuery("#Right1ActionId1");

                if (jQuery('#checkall').prop('checked')) {
                    cases.iCheck('uncheck');
                    jQuery("#").attr("disabled", "true");
                } else {
                    cases.iCheck('check');
                    jQuery("#").removeAttr("disabled");
                }
            }

        });


        jQuery('input.checkall2').on('ifClicked', function (event) {

            for (i = 1; i <= 11; i++) {

                var cases = jQuery("#Right2ActionId" + i);

                //var cases = jQuery("#Right1ActionId1");

                if (jQuery('#checkall2').prop('checked')) {
                    cases.iCheck('uncheck');
                    jQuery("#").attr("disabled", "true");
                } else {
                    cases.iCheck('check');
                    jQuery("#").removeAttr("disabled");
                }
            }

        });

        jQuery('input.checkall3').on('ifClicked', function (event) {

            for (i = 1; i <= 11; i++) {

                var cases = jQuery("#Right3ActionId" + i);

                //var cases = jQuery("#Right1ActionId1");

                if (jQuery('#checkall3').prop('checked')) {
                    cases.iCheck('uncheck');
                    jQuery("#").attr("disabled", "true");
                } else {
                    cases.iCheck('check');
                    jQuery("#").removeAttr("disabled");
                }
            }

        });

        jQuery('input.checkall4').on('ifClicked', function (event) {

            for (i = 1; i <= 11; i++) {

                var cases = jQuery("#Right4ActionId" + i);

                //var cases = jQuery("#Right1ActionId1");

                if (jQuery('#checkall4').prop('checked')) {
                    cases.iCheck('uncheck');
                    jQuery("#").attr("disabled", "true");
                } else {
                    cases.iCheck('check');
                    jQuery("#").removeAttr("disabled");
                }
            }

        });

        jQuery('input.checkall5').on('ifClicked', function (event) {

            for (i = 1; i <= 11; i++) {

                var cases = jQuery("#Right5ActionId" + i);

                //var cases = jQuery("#Right1ActionId1");

                if (jQuery('#checkall5').prop('checked')) {
                    cases.iCheck('uncheck');
                    jQuery("#").attr("disabled", "true");
                } else {
                    cases.iCheck('check');
                    jQuery("#").removeAttr("disabled");
                }
            }

        });
        jQuery('input.checkall6').on('ifClicked', function (event) {

            for (i = 1; i <= 11; i++) {

                var cases = jQuery("#Right6ActionId" + i);

                //var cases = jQuery("#Right1ActionId1");

                if (jQuery('#checkall6').prop('checked')) {
                    cases.iCheck('uncheck');
                    jQuery("#").attr("disabled", "true");
                } else {
                    cases.iCheck('check');
                    jQuery("#").removeAttr("disabled");
                }
            }

        });


        jQuery('input.checkall7').on('ifClicked', function (event) {

            for (i = 1; i <= 11; i++) {

                var cases = jQuery("#Right7ActionId" + i);

                //var cases = jQuery("#Right1ActionId1");

                if (jQuery('#checkall7').prop('checked')) {
                    cases.iCheck('uncheck');
                    jQuery("#").attr("disabled", "true");
                } else {
                    cases.iCheck('check');
                    jQuery("#").removeAttr("disabled");
                }
            }

        });

        jQuery('input.checkall8').on('ifClicked', function (event) {

            for (i = 1; i <= 11; i++) {

                var cases = jQuery("#Right8ActionId" + i);

                //var cases = jQuery("#Right1ActionId1");

                if (jQuery('#checkall8').prop('checked')) {
                    cases.iCheck('uncheck');
                    jQuery("#").attr("disabled", "true");
                } else {
                    cases.iCheck('check');
                    jQuery("#").removeAttr("disabled");
                }
            }

        });
        jQuery('input.checkall9').on('ifClicked', function (event) {

            for (i = 1; i <= 11; i++) {

                var cases = jQuery("#Right9ActionId" + i);

                //var cases = jQuery("#Right1ActionId1");

                if (jQuery('#checkall9').prop('checked')) {
                    cases.iCheck('uncheck');
                    jQuery("#").attr("disabled", "true");
                } else {
                    cases.iCheck('check');
                    jQuery("#").removeAttr("disabled");
                }
            }

        });

        jQuery('input.checkall10').on('ifClicked', function (event) {

            for (i = 1; i <= 11; i++) {

                var cases = jQuery("#Right10ActionId" + i);

                //var cases = jQuery("#Right1ActionId1");

                if (jQuery('#checkall10').prop('checked')) {
                    cases.iCheck('uncheck');
                    jQuery("#").attr("disabled", "true");
                } else {
                    cases.iCheck('check');
                    jQuery("#").removeAttr("disabled");
                }
            }

        });

        jQuery('input.checkall11').on('ifClicked', function (event) {

            for (i = 1; i <= 11; i++) {

                var cases = jQuery("#Right11ActionId" + i);

                //var cases = jQuery("#Right1ActionId1");

                if (jQuery('#checkall11').prop('checked')) {
                    cases.iCheck('uncheck');
                    jQuery("#").attr("disabled", "true");
                } else {
                    cases.iCheck('check');
                    jQuery("#").removeAttr("disabled");
                }
            }

        });


        jQuery('input.checkall12').on('ifClicked', function (event) {

            for (i = 1; i <= 11; i++) {

                var cases = jQuery("#Right12ActionId" + i);

                //var cases = jQuery("#Right1ActionId1");

                if (jQuery('#checkall12').prop('checked')) {
                    cases.iCheck('uncheck');
                    jQuery("#").attr("disabled", "true");
                } else {
                    cases.iCheck('check');
                    jQuery("#").removeAttr("disabled");
                }
            }

        });

        <?php if (isset($moduleId)){ ?>
            jQuery("#module").trigger('change');
        <?php } ?>

    });


</script>
<?php $this->end(); ?>
