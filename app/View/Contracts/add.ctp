<style>
    .select2-selection__rendered{
        font-size: 11px;
    }
    #pourcentage1{
        margin-top: 8px;
    }
    #price_return1{
        margin-top: 8px;
    }
</style>
<?php

?><h4 class="page-title"> <?=__('Add Contract'); ?></h4>


<div class="box">
    <div class="edit form card-box p-b-0">

<?php echo $this->Form->create('Contract', array('enctype' => 'multipart/form-data', 'onsubmit'=> 'javascript:disable();')); ?>
	<div class="box-body">
	<?php
        echo "<div class='form-group'>".$this->Form->input('reference', array(
                    'label' => __('Reference'),
                    'class' => 'form-control',
                    'error' => array('attributes' => array('escape' => false),
                                     'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>'. 
                                                     __("The reference must be unique") . '</label></div>', true)
                    ))."</div>";
		echo "<div class='form-group'>".$this->Form->input('supplier_id', array(
                    'label' => __('Supplier'),
                    'class' => 'form-control select2',
                    'empty'=>'',
                    'id'=>'supplier',
                    ))."</div>"; ?>

        <table class="table table-bordered" id='dynamic_field'>
            <?php
            echo "<div class='form-group'>".$this->Form->input('nb_type', array(
                    'label' => __('Supplier'),
                    'value'=>1,
                    'type'=>'hidden',
                    'id'=>'nb_type',
                ))."</div>";
            ?>
            <thead>
            <tr>
                <th style="width: 30%;"><?=__('Rides')?></th>
                <th><?=__('Price HT')?></th>
                <th><?=__('Pourcentage price return (%)')?></th>
                <th><?=__('Price return')?></th>
                <th><?=__('Start date')?></th>
                <th><?=__('End date')?></th>
                <th></th>


            </tr>
            </thead>
            <tbody id='rides-tbody'>
            <tr id="row1">
                <td> <?php
                    echo "<div class='form-group'>".$this->Form->input('ContractCarType.1.detail_ride_id', array(
                            'label' => '',
                            'class' => 'form-control select-search-detail-ride',
                            'empty'=>'',
                            'id'=>'detail_ride1',
                        ))."</div>";

                    ?></td>

                <td><?php
                    echo "<div class='form-group'>".$this->Form->input('ContractCarType.1.price_ht', array(
                            'label' =>'',
                            'class' => 'form-control',
                            'placeholder'=>__('Enter price ht'),
                            'id'=>'price_ht1',
                        ))."</div>";

                    ?></td>


                <td><?php
                    echo "<div class='form-group'>" . $this->Form->input('ContractCarType.1.pourcentage_price_return', array(
                            'label' => '',
                            'placeholder' => __('Enter pourcentage price return'),
                            'onchange' => 'javascript: calculatePriceReturn(this.id);',
                            'id' => 'pourcentage1',
                            'class' => 'form-control',
                        )) . "</div>";

                    ?></td>

                <td><?php
                    echo "<div class='form-group'>".$this->Form->input('ContractCarType.1.price_return', array(
                            'label' => '',
                            'class' => 'form-control',
                            'placeholder'=>__('Enter price return'),
                            'onchange' => 'javascript: calculatePourcentage(this.id);',
                            'id'=>'price_return1',
                        ))."</div>";
                    ?></td>

                <td><?php
                    echo "<div class='form-group'>" . $this->Form->input('ContractCarType.1.date_start', array(
                            'label' => '',
                            'placeholder' => 'dd/mm/yyyy',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label></label><div class="input-group date"><label for="StartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'start_date1'
                        )) . "</div>";
                    ?></td>
                <td>
                    <?php
                    echo "<div class='form-group'>" . $this->Form->input('ContractCarType.1.date_end', array(
                            'label' => '',
                            'placeholder' => 'dd/mm/yyyy',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label></label><div class="input-group date"><label for="StartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'end_date1'
                        )) . "</div>";
                    ?>
                </td>
                <td>
                </td>

            </tr>

            </tbody>

        </table>

        <button style="float: right;" type='button' name='add' id='add' class='btn btn-success' onclick='addOtherType()'><?=__('Add more')?></button>
<br>
<br>
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
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        jQuery("#start_date1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#end_date1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    });
function addOtherType(){
    var i = jQuery("#nb_type").val();
    i++;
    $('#dynamic_field').append('<tr id="row'+i+'"><td ></td></tr>');
    jQuery("#nb_type").val(i);
    jQuery("#row"+''+i+'').load('<?php echo $this->Html->url('/contracts/getCarType/')?>'+ i, function() {
        jQuery("#start_date"+''+i+'').inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#end_date"+''+i+'').inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#pourcentage"+''+i+'').css('margin-top',8);
        jQuery("#price_return"+''+i+'').css('margin-top',8);

        $('.select-search-detail-ride').select2({
            ajax: {
                url: "<?php echo $this->Html->url('/detailRides/getDetailRidesByKeyWord')?>",
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
            minimumInputLength: 3

        });

        jQuery(".date").datetimepicker({

            format: 'DD/MM/YYYY',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            }


        });

        $('.date').click(function () {
            var popup = $(this).offset();
            var popupTop = popup.left;
            $('.bootstrap-datetimepicker-widget').css({
                'bottom': 10,
                'left': 10,
                'height': 250,
                'top': 38,
                'z-index': 99999,

                'background-color': '#fff',
                'font-size': 11


            });
        });
    });
}

    function calculatePriceReturn(id){
        var i = id.substring(id.length , id.length-1);
        if (jQuery('#price_ht'+''+i+'').val() > 0 && jQuery('#pourcentage'+''+i+'').val() > 0) {
            var pourcentageValue = (parseFloat(jQuery('#price_ht'+''+i+'').val()) * parseFloat(jQuery('#pourcentage'+''+i+'').val())) / 100;
            var priceReturn = pourcentageValue;
            priceReturn= priceReturn.toFixed(2);
            jQuery('#price_return'+''+i+'').val(priceReturn);
        }
    }

    function calculatePourcentage(id) {

        var i = id.substring(id.length, id.length-1);
        if (jQuery('#price_ht'+''+i+'').val() > 0 && jQuery('#price_return'+''+i+'').val() > 0) {
            var pourcentageValue=  parseFloat(jQuery('#price_ht'+''+i+'').val()) -parseFloat(jQuery('#price_return'+''+i+'').val());
            var pourcentage =( parseFloat( pourcentageValue) *100 )/parseFloat(jQuery('#price_ht'+''+i+'').val());
            pourcentage= pourcentage.toFixed(2);
            jQuery('#pourcentage'+''+i+'').val(pourcentage);
        }

    }

    function removeRide(id) {
        $('#row' + id + '').remove();
    }



</script>

<?php $this->end(); ?>


