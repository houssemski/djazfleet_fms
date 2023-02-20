<?php

?>
<?php
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
$this->end();
?>
<div class="box">
    <div class="edit form card-box p-b-0">
        <?php echo $this->Form->create('BillProduct', array('type' => 'file', 'onsubmit' => 'javascript:disable();')); ?>
        <div class="box-body">
            <div class="nav-tabs-custom pdg_btm">
                <?php

                echo $this->Form->input('BillProduct.num', array(
                    'type' => 'hidden',
                    'value'=> $i,
                    'id'=>'num',

                ));

                echo $this->Form->input('BillProduct.product_id', array(
                    'type' => 'hidden',
                    'value'=> $productId,
                    'id'=>'product',
                ));
             if(!empty($description)){
                 echo $this->Tinymce->input('BillProduct.description', array(
                     'label' => 'Description',
                     'value'=>$description,
                     'placeholder' => __('Enter description'),
                     'class' => 'form-control description'
                 ),array(
                     'language'=>'fr_FR'
                 ),
                     'full'
                 );
             }else {
                 echo $this->Tinymce->input('BillProduct.description', array(
                     'label' => 'Description',
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



                echo $this->Form->end();
                echo $this->Js->writeBuffer(); //assuming this view is rendered without the default layout, make sure you write out the JS buffer at the bottom of the page
                ?>
            </div>
        </div>
    </div>
    <script type="text/javascript">

tinyMCE.init({selector:'textarea#BillProductDescription'});
$(document).on('focusin', function(e) {
    if ($(e.target).closest(".mce-window").length) {
        e.stopImmediatePropagation();
    }
});
        $(document).ready(function() {
            $(document).on('focusin', function(e) {

                if ($(e.target).closest(".mce-window").length || $(e.target).closest(".moxman-window").length) {
                    e.stopImmediatePropagation();
                }
            });
            $.widget("ui.dialog", $.ui.dialog, {
                _allowInteraction: function(event) {
                    return !!$(event.target).closest(".mce-container").length || this._super( event );
                }
            });
            $(document).on('focusin', (e) => {
                if ($(e.target).closest('.mce-window').length) {
                $('.ModalHeader').attr('tabindex', '');
            }
            });
            tinyMCE.init({selector:'textarea#BillProductDescription'});
            $("#BillProductEditDescriptionForm").submit(function(e) {

                e.preventDefault(); // avoid to execute the actual submit of the form.

                var form = $(this);
                var link= '<?php echo $this->Html->url('/bills/saveDescription/')?>' ;

                var description =   tinyMCE.get('BillProductDescription').getContent();


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
            var link= '<?php echo $this->Html->url('/bills/saveDescription/')?>' ;
            var description =    tinyMCE.get('BillProductDescription').getContent();
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
                        jQuery("#description-div" + '' + i + '').load("<?php echo $this->Html->url('/bills/getDescription/')?>" + json.product + '/' + i, function () {
                            jQuery("#editDescription" + '' + i + ''). attr("href", "#");
                            jQuery("#editDescription" + '' + i + ''). attr("disable", "disable");
                        });
                    }else {

                    }
                }
            });
        }

        </script>