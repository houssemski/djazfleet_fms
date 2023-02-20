<?php

?><h4 class="page-title"> <?= __('Edit Description'); ?></h4>
<?php
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
$this->end();
?>
<div class="box">
    <div class="edit form card-box p-b-0">
        <?php echo $this->Form->create('TransportBillDetailRides', array('type' => 'file', 'onsubmit' => 'javascript:disable();')); ?>
        <div class="box-body">
            <div class="nav-tabs-custom pdg_btm">
                <?php

                echo $this->Form->input('TransportBillDetailRides.num', array(
                    'type' => 'hidden',
                    'value'=> $i,
                    'id'=>'num',

                ));

                echo $this->Form->input('TransportBillDetailRides.product_id', array(
                    'type' => 'hidden',
                    'value'=> $productId,
                    'id'=>'product',

                ));


                if(!empty($description)) {
                    echo $this->Tinymce->input('TransportBillDetailRides.description', array(
                        'label' => 'Description',
                        'value'=> $description,
                        'placeholder' => __('Enter description'),
                        'class' => 'form-control description'
                    ),array(
                        'language'=>'fr_FR'
                    ),
                        'full'
                    );
                } else {
                    echo $this->Tinymce->input('TransportBillDetailRides.description', array(
                        'label' => 'Description',
                        'value'=>$product['Product']['description'],
                        'placeholder' => __('Enter description'),
                        'class' => 'form-control description'
                    ),array(
                        'language'=>'fr_FR'
                    ),
                        'full'
                    );
                }
                ?>
            </div>


            <div class="box-footer">
                <?php
                echo $this->Form->submit(__('Save'), array(
                    'name' => 'ok',
                    'class' => 'btn btn-primary btn-bordred  m-b-5',
                    'label' => __('Submit'),
                    'type' => 'button',
                    'onclick'=>'javascript : submitAjax();',
                    'id' => 'boutonValider',
                    'div' => false
                ));
                if (false != $saved) { //will only be true if saved OK in controller from ajax save above
                    $url = '/transportBills/getDescription/' . base64_encode(serialize($newDescription)) . '/' . $i;
                    echo "<script>
                    jQuery('#description-div" . $i . "').load('" . $this->Html->url($url) . "');
                    jQuery('#dialogModalDescription').dialog('close');  //close containing dialog
                  
                </script>";
                }


                echo $this->Form->end();
                echo $this->Js->writeBuffer(); //assuming this view is rendered without the default layout, make sure you write out the JS buffer at the bottom of the page
                ?>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $(document).ready(function() {

            $("#TransportBillDetailRidesEditDescriptionForm").submit(function(e) {

                e.preventDefault(); // avoid to execute the actual submit of the form.

                var form = $(this);
                var link= '<?php echo $this->Html->url('/transportBills/saveDescription/')?>' ;

                var description =   tinyMCE.get('TransportBillDetailRidesDescription').getContent();


                $.ajax({
                    type: "POST",
                    url: link,
                    dataType: "json",
                    data: "description=" + description, // serializes the form's elements.
                    success: function (json) {
                        if (json.response === true) {

                            jQuery('#dialogModalDescription').dialog('close');
                        }else {

                        }
                    }
                });


            });
        });
        function submitAjax(){

            var link= '<?php echo $this->Html->url('/transportBills/saveDescription/')?>' ;
            var description =    tinyMCE.get('TransportBillDetailRidesDescription').getContent();
            var productId = jQuery('#product').val();
            var i = jQuery('#num').val();

            jQuery.ajax({
                type: "POST",
                url: link,
                data: {description: JSON.stringify(description), productId: productId},
                dataType: "json",
                success: function (json) {
                    var desc = json.data;
                    if (json.response === true) {

                        jQuery('#dialogModalDescription').dialog('close');
                       jQuery("#description" + '' + i + '').val(desc);
                        jQuery("#description-div" + '' + i + '').load("<?php echo $this->Html->url('/transportBills/getDescription/')?>" + json.product + '/' + i, function () {

                        });
                    }else {

                    }
                }
            });
        }

        </script>


