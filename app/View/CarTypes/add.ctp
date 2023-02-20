<?php

?><h4 class="page-title"> <?= __('Add Car Type'); ?></h4>


<div class="box">
    <div class="edit form card-box p-b-0">

        <?php echo $this->Form->create('CarType',
            array('enctype' => 'multipart/form-data', 'onsubmit' => 'javascript:disable();')); ?>
        <div class="box-body">
            <?php
            echo "<div class='form-group'>" . $this->Form->input('code', array(
                    'label' => __('Code'),
                    'class' => 'form-control',
                    'error' => array(
                        'attributes' => array('escape' => false),
                        'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                            __("The code must be unique") . '</label></div>',
                        true
                    )
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('name', array(
                    'label' => __('Name'),
                    'class' => 'form-control',
                    'id' => 'name',
                )) . "</div>";

            echo "<div class='form-group'>" . $this->Form->input('CarTypeCarCategory.car_category_id', array(
                    'label' => __('Category'),
                    'class' => 'form-control select2',
                    'multiple' => true,
                    'empty' => '',
                    'id' => 'category',
                )) . "</div>";


            echo "<div class='form-group'>" . $this->Form->input('average_speed', array(
                    'label' => __('Average speed') . ' ' . _('(Km/h)'),
                    'class' => 'form-control',
                    'multiple' => true,
                    'placeholder' => __('Enter average speed'),
                    'id' => 'category',
                )) . "</div>";

            echo "<div class='form-group'>" . $this->Form->input('picture', array(
                    'label' => __('picture'),
                    'class' => 'form-control',
                    'type' => 'file',
                    'id' => 'pic',
                    'onchange' => 'javascript:verif_ext_attachment(1,this.id)',
                    'empty' => ''
                )) . "</div>";

            echo "<div class='form-group audiv1'>" . $this->Form->input('display_model_mission_order', array(
                    'label' => __('Display model in mission order'),
                    'id' => 'display_model_mission_order',
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
<?= $this->Html->script('jquery-2.1.1.min.js'); ?>
<?= $this->Html->script('jquery.form.min.js'); ?>

<script type="text/javascript">
    $(document).ready(function () {
    });

    function verif_ext_attachment(img, id) {

        pic1 = jQuery('#' + id).val();
        pic1 = pic1.split('.');
        if (img == 1) {

            let typeArr = ['jpg', 'jpeg', 'gif', 'png', 'pdf'];
            if (typeArr.indexOf(pic1[1]) === -1) {
                msg = '<?php echo __('Only gif, png, jpg and jpeg images are allowed!')?>';
                alert(msg);
                jQuery('#' + id).val('');
            }
        }
    }
    function delete_file(id) {


        $("#" + '' + id + '' + "-file").before(
            function () {

                if (!$(this).prev().hasClass('input-ghost')) {
                    var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");

                    element.attr("name", $(this).attr("name"));
                    element.change(function () {
                        element.next(element).find('input').val((element.val()).split('\\').pop());
                    });

                    $(this).find("#" + '' + id + '' + "-btn").click(function () {

                        element.val(null);
                        $(this).parents("#" + '' + id + '' + "-file").find('input').val('');
                    });
                    $(this).find('input').css("cursor", "pointer");
                    /* $(this).find('input').mousedown(function() {
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


