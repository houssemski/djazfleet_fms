<style>
    .select2-container{
        z-index: 10000;
    }
</style>
<?php
$this->start('css');
echo $this->Html->css('select2/select2.min');
$this->end();


if($result){

    echo $this->Form->create('Car' );
    if ($autocode == 0) {
        echo "<div class='form-group'>" . $this->Form->input('code', array(
                'placeholder' => __('Enter code'),
                'label' => __('Code'),
                'class' => 'form-control',
                'error' => array('attributes' => array('escape' => false),
                    'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                        __("The code must be unique") . '</label></div>', true)
            )) . "</div>";
    } else {
        echo "<div class='form-group'>" . $this->Form->input('code', array(
                'placeholder' => __('Enter code'),
                'label' => __('Code'),
                'class' => 'form-control',
                'readonly' => true,
                'value' => $autocode,
                'error' => array('attributes' => array('escape' => false),
                    'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                        __("The code must be unique") . '</label></div>', true)
            )) . "</div>";


    }

    echo "<div class='form-group ' id='marks'>" . $this->Form->input('mark_id', array(
            'label' => __('Mark'),
            'class' => 'form-control select-popup',
            'id' => 'mark',
            'empty' => ''
        )) . "</div>";


   echo "<div class='form-group ' id='model'>" . $this->Form->input('carmodel_id', array(
                                'label' => __('Model'),
                                'class' => 'form-control select-popup',
                            )) . "</div>";


    echo "<div class='form-group ' id='carcategories'>" . $this->Form->input('car_category_id', array(
            'label' => __('Car category'),
            'class' => 'form-control select-popup',
            'id' => 'category',
            'empty' => ''
        )) . "</div>";
    echo "<div class='form-group ' id='cartypes'>" . $this->Form->input('car_type_id', array(
            'label' => __('Car type'),
            'class' => 'form-control select-popup',
            'id'=>'car_type',
            'empty' => ''
        )) . "</div>";

    echo "<div class='form-group ' id='fuels'>" . $this->Form->input('fuel_id', array(
            'label' => __('Fuel'),
            'class' => 'form-control select-popup',
            'empty' => ''
        )) . "</div>";

    echo "<div class='form-group'>" . $this->Form->input('immatr_def', array(
            'label' => __('Final registration'),
            'placeholder' => __('Enter final registration'),
            'class' => 'form-control',
        )) . "</div>";


    echo $this->Js->submit(__('Save'), array(  //create 'ajax' save button
        'update' => '#contentWrapCar',  //id of DOM element to update with selector
        'class' => 'btn btn-primary',
    ));



    if (false != $saved){ //will only be true if saved OK in controller from ajax save above
        $url = '/cars/getCars/'.$carId;

        echo "<script>
        jQuery('#dialogModalCar').dialog('close');  //close containing dialog         
       jQuery('#cars-div').load('".$this->Html->url($url)."', function(){
                  $('.select-search-car').select2({
                        ajax: {
                            url: '". $this->Html->url('/cars/getCarsByKeyWord')."',
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                return {
                                    q: $.trim(params.term),
                                    controller: jQuery('#controller').val(),
                                    action: jQuery('#current_action').val(),
                                    carId: carId
                                };
                            },
                            processResults: function (data, page) {
                                return {results: data};
                            },
                            cache: true
                        },
                        minimumInputLength: 2
                    });

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
        <?php echo __("You don't have permission to add.") ?>
    </div>
    <?php
}

?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>
<?= $this->Html->script('maskedinput'); ?>
<script type="text/javascript">
    $(document).ready(function() {

        $(".select-popup").select2({

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
        //$('.select2-container').css('z-index','10000');


        jQuery('#mark').change(function () {

            jQuery('#model').load('<?php echo $this->Html->url('/cars/getModels/')?>' + jQuery(this).val(), function(){
                $(".select-model").select2({

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
        });


        jQuery('#category').change(function () {


            jQuery('#cartypes').load('<?php echo $this->Html->url('/cars/getTypesByCategory/')?>' + jQuery(this).val(), function(){
                jQuery('.select-type').select2();
            });
        });







    });





</script>
<?php die(); ?>