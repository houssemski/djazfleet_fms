<style>
    .select2-container{
        z-index: 10000;
    }
</style>

<?php

$this->start('css');
echo $this->Html->css('select2/select2.min');

$this->end();

/** @var $supplierCategories array */
/** @var $code string */
/** @var $result array */
/** @var $saved bool */
/** @var $supplierId int */
/** @var $idSelect string */
if($result){
    /** @noinspection PhpIncludeInspection */

    echo $this->Form->create('Supplier' );
    echo $this->Form->input('id');
    echo $this->Form->input('idSelect', array('type' => 'hidden', 'value' => $idSelect));
    if ($code != '0') {
        echo "<div id ='code_div' class='form-group'>" . $this->Form->input('code', array(
                'label' => __('Code'),
                'class' => 'form-control',
                'readonly' => true,
                'placeholder' => __('Enter code'),
            )) . "</div>";
    } else {
        echo "<div class='form-group'>" . $this->Form->input('code', array(
                'label' => __('Code'),
                'placeholder' => __('Enter code'),
                'class' => 'form-control',
                'id' => 'ref',
                'error' => array('attributes' => array('escape' => false),
                    'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                        __("The code must be unique") . '</label></div>', true)
            )) . "</div>";
    }
    echo "<div class='form-group'>" . $this->Form->input('type', array(
            'label' => __('type'),
            'type' => 'hidden',
            'value' => 1,
            'class' => 'form-control',
        )) . "</div>";
    echo "<div class='form-group'>" . $this->Form->input('is_special', array(
            'label' => __('is_special'),
            'type' => 'hidden',
            'value' => 1,
            'class' => 'form-control',
        )) . "</div>";
    echo "<div class='form-group'>".$this->Form->input('name', array(
            'label' => __('Name'),
            'class' => 'form-control',
        ))."</div>";
    echo "<div class='form-group'>" . $this->Form->input('supplier_category_id', array(
            'label' => __('Category'),
            'class' => 'form-control select3',
            'empty'=>''
        )) . "</div>";
    echo "<div class='form-group'>" . $this->Form->input('adress', array(
            'label' => __('Address'),
            'class' => 'form-control',
            'id' => "addresspicker0"
        )) . "</div>";
    echo "<div class='form-group'>" . $this->Form->input('rc', array(
            'label' => __('RC'),
            'class' => 'form-control',
        )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('if', array(
                                'label' => __('IF'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('ai', array(
                                'label' => __('AI'),
                                'class' => 'form-control',
                            )) . "</div>";
    echo $this->Js->submit(__('Save'), array(  //create 'ajax' save button
        'update' => '#contentWrapClient',  //id of DOM element to update with selector
        'class' => 'btn btn-primary',
    ));
    if (false != $saved){ //will only be true if saved OK in controller from ajax save above
        $url = '/suppliers/getClients/'.$supplierId.'/'.$idSelect;
        echo "<script>
        jQuery('#dialogModalClient').dialog('close');  //close containing dialog
       jQuery('#client-div').load('".$this->Html->url($url)."', function(){
                jQuery('.select-search').select2();
                });
       
    </script>";
    }
    echo $this->Form->end();
    echo $this->Js->writeBuffer(); //assuming this view is rendered without the default layout, make sure you write out the JS buffer at the bottom of the page

}else {
    ?>
    <div id="flashMessage" class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo __("You don't have permission to edit.") ?>
    </div>
    <?php
} ?>


<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>
<?= $this->Html->script('maskedinput'); ?>
    <script type="text/javascript">

        $(document).ready(function() {

            $('.select3').select2({
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

    </script>
<?php die(); ?>