<?php
if($result) {

echo $this->Form->create('Product');
echo "<div class='form-group'>" . $this->Form->input('code', array(
        'label' => __('Code'),
        'class' => 'form-control',
        'error' => array('attributes' => array('escape' => false),
            'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                __("The code must be unique") . '</label></div>', true)
    )) . "</div>";
echo "<div class='form-group'>" . $this->Form->input('name', array(
        'label' => __('Name'),
        'placeholder' => __('Enter name product '),
        'class' => 'form-control',
    )) . "</div>";
    echo "<div class='form-group' id='families'>" . $this->Form->input('product_family_id', array(
            'label' => __('Family'),
            'empty' => '',
            'class' => 'form-control select3',
        )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('tva_id', array(
        'label' => __('rate TVA'),
        'class' => 'form-control select2',
    )) . "</div>";

    echo "<div class='form-group'>" . $this->Form->input('out_stock', array(
            'label' => __('Out stock'),
            'class' => 'form-control',
        )) . "</div>";

echo $this->Js->submit(__('Save'), array(  //create 'ajax' save button
    'update' => '#contentWrapProduct',  //id of DOM element to update with selector
    'class' => 'btn btn-primary',

));


if (false != $saved) { //will only be true if saved OK in controller from ajax save above


    $url = '/lots/getProducts/' . $productId ;

    echo "<script>
        jQuery('#dialogModalProduct').dialog('close');  //close containing dialog

	   jQuery('#products').load('" . $this->Html->url($url) . "', function() {

			       $('.select-search').select2({
                sorter: function (data) {
                    /* Sort data using lowercase comparison */
                    return data.sort(function (a, b) {
                        a = a.text.toLowerCase();
                        b = b.text.toLowerCase();
                        if (a > b) {
                            return 1;
                        } else if (a < b) {
                            return -1;
                        }
                        return 0;
                    });
                },
                allowDuplicates: true

            });
			});


    </script>";
}
echo $this->Form->end();

echo $this->Js->writeBuffer(); //assuming this view is rendered without the default layout, make sure you write out the JS buffer at the bottom of the page

?>
<?php $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
<?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<script type="text/javascript">     $(document).ready(function () {
    });
</script>

<?php $this->end(); ?>
<?php die();

}else {
    ?>
    <div id="flashMessage" class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo __("You don't have permission to add.") ?>
    </div>
    <?php  die();

}
