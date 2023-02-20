<?php

?><h4 class="page-title"> <?= __('Edit Product'); ?></h4>
<?php
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
$this->end();

?>


<div class="box">
    <div class="edit form card-box p-b-0">

        <?php echo $this->Form->create('Product', array('type' => 'file', 'onsubmit' => 'javascript:disable();')); ?>
        <div class="box-body">
            <div class="nav-tabs-custom pdg_btm">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
                    <li><a href="#tab_2" data-toggle="tab"><?= __('Prices') ?></a></li>
                    <li><a href="#tab_3" data-toggle="tab"><?= __('Advanced information') ?></a></li>
                    <li><a href="#tab_4" data-toggle="tab"><?= __('Attachments') ?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <?php
                        echo $this->Form->input('id');
                        if ($code != '0') {
                            echo "<div class='form-group' >" . $this->Form->input('code', array(
                                    'label' => __('Code'),
                                    'placeholder' => __('Enter code product '),
                                    'class' => 'form-control',
                                    'readonly' => true,
                                )) . "</div>";
                        } else {
                            echo "<div class='form-group '>" . $this->Form->input('code', array(
                                    'label' => __('Code'),
                                    'placeholder' => __('Enter code product '),
                                    'class' => 'form-control',
                                    'error' => array('attributes' => array('escape' => false),
                                        'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                                            __("The reference must be unique") . '</label></div>', true)
                                )) . "</div>";
                        }

                        echo "<div class='form-group'>" . $this->Form->input('reference', array(
                                'label' => __('Reference'),
                                'placeholder' => __('Enter reference product'),
                                'class' => 'form-control',
                            )) . "</div>";

                        echo "<div class='form-group input-button'id='families'>" . $this->Form->input('product_family_id', array(
                                'label' => __('Family'),
                                'empty' => '',
                                'class' => 'form-control select3',
                            )) . "</div>";?>
                        <!-- overlayed element -->
                        <div id="dialogModalFamily">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapFamily"></div>
                        </div>
                        <div class="popupactions">
                            <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                array("controller" => "products", "action" => "addFamily"),
                                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayFamily", 'escape' => false, "title" => __("Add Family"))); ?>
                        </div>
                        <div style="clear:both"></div>
                        <?php
                        echo "<div class='form-group input-button' >" . $this->Form->input('product_type_id', array(
                                'label' => __('Type'),
                                'empty' => '',
                                'class' => 'form-control select3',
                            )) . "</div>";
                        echo "<div class='form-group input-button' id='productCategory'>" . $this->Form->input('product_category_id', array(
                                'label' => __('Category'),
                                'empty' => '',
                                'class' => 'form-control select3',
                            )) . "</div>";?>
                        <!-- overlayed element -->
                        <div id="dialogModalCategory">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapCategory"></div>
                        </div>
                        <div class="popupactions">

                            <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                array("controller" => "products", "action" => "addCategory"),
                                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayCategory", 'escape' => false, "title" => __("Add category"))); ?>

                        </div>
                        <div style="clear:both"></div>
                        <?php
                        echo "<div class='form-group input-button' id='marks'>" . $this->Form->input('product_mark_id', array(
                            'label' => __('Mark'),
                            'empty' => '',
                            'class' => 'form-control select3',
                            )) . "</div>";?>
                        <!-- overlayed element -->
                        <div id="dialogModalMark">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapMark"></div>
                        </div>
                        <div class="popupactions">

                            <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                array("controller" => "products", "action" => "addMark"),
                                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayMark", 'escape' => false, "title" => __("Add mark"))); ?>

                        </div>
                        <div style="clear:both"></div>
                        <?php echo "<div class='form-group'>" . $this->Form->input('name', array(
                                'label' => __('Designation'),
                                'placeholder' => __('Enter name product'),
                                'class' => 'form-control',
                            )) . "</div>";

                        ?>
                        <div style="clear:both"></div>
                        <?php
                        echo "<div class='form-group input-button' '>" . $this->Form->input('supplier_id', array(
                                'label' => __('Fournisseur gamme original'),
                                'empty' => '',
                                'class' => 'form-control select3',
                            )) . "</div>";?>

                        <div style="clear:both"></div> <?php
                        echo "<div class='form-group input-button' >" . $this->Form->input('original_price', array(
                                'label' => __('Prix gamme original'),
                                'empty' => '',
                                'class' => 'form-control select3',
                            )) . "</div>";?>

                        <div style="clear:both"></div> <?php
                        echo "<div class='form-group input-button' >" . $this->Form->input('copy_supplier_id', array(
                                'label' => __('Fournisseur gamme copie'),
                                'empty' => '',
                                'options' => $suppliers,
                                'class' => 'form-control select3',
                            )) . "</div>";?>

                        <div style="clear:both"></div> <?php
                        echo "<div class='form-group input-button' >" . $this->Form->input('copy_price', array(
                                'label' => __('Prix gamme copie'),
                                'empty' => '',
                                'class' => 'form-control select3',
                            )) . "</div>";?>
                        <?php
                        if($productTypeId ==3){
                            echo "<div id='disposition-div'>" ;
                            echo "<div class='form-group'>" . $this->Form->input('Product.nb_hours', array(
                                    'label' => __('Nb hours'),
                                    'class' => 'form-control',
                                )) . "</div>";
                            echo "<br/>";
                            echo '<div class="lbl1" style="display: inline-block; width: 150px;">' . __("Car required");
                            echo "</div>";
                            $options = array('1' => __('Yes'), '2' => __('No'));
                            $attributes = array('legend' => false, 'value' => $this->request->data['Product']['car_required']);
                            echo $this->Form->radio('Product.car_required', $options, $attributes) . "</div>";
                            echo "<br/>";
                            echo "<br/>";
                            echo "</div>";
                        }else {
                            if($productTypeId ==2){
                                echo "<div id='disposition-div'>" ;

                                echo '<div class="lbl1" style="display: inline-block; width: 150px;">' . __("Car required");
                                echo "</div>";
                                $options = array('1' => __('Yes'), '2' => __('No'));
                                $attributes = array('legend' => false, 'value' => $this->request->data['Product']['car_required']);
                                echo $this->Form->radio('Product.car_required', $options, $attributes) . "</div>";
                                echo "<br/>";
                                echo "<br/>";
                                echo "</div>";

                            }else {
                                echo "<div id='disposition-div'></div>";
                            }

                        }


                        echo "<div class='form-group'>" . $this->Form->input('remark', array(
                                'label' => __('Remark'),
                                'placeholder' => __('Enter remark product'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('tva_id', array(
                                'label' => __('TVA'),
                                'class' => 'form-control select3',
                            )) . "</div>";

                        echo "<div class='form-group input-button' id='units'>" . $this->Form->input('product_unit_id', array(
                                'label' => __('Unit'),
                                'class' => 'form-control select3',
                                'empty'=>''
                            )) . "</div>"; ?>

                        <!-- overlayed element -->
                        <div id="dialogModalUnit">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapUnit"></div>
                        </div>
                        <div class="popupactions">

                            <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                array("controller" => "products", "action" => "addUnit"),
                                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayUnit", 'escape' => false, "title" => __("Add unit"))); ?>

                        </div>
                        <div style="clear:both"></div>

                        <?php

                        if($this->request->data['Product']['blocked']==true) {
                            echo "<div class='form-group'>" . $this->Form->input('changeable_price', array(
                                    'label' => __('Changeable price'),
                                    'disabled'=>true,
                                    'class' => 'form-control',
                                )) . "</div>";
                        } else {
                            echo "<div class='form-group'>" . $this->Form->input('changeable_price', array(
                                    'label' => __('Changeable price'),
                                    'class' => 'form-control',
                                )) . "</div>";
                        }
                        if($this->request->data['Product']['blocked']==true) {
                            echo "<div class='form-group'>" . $this->Form->input('blocked', array(
                                    'label' => __('Blocked'),
                                    'disabled'=>true,
                                    'class' => 'form-control',
                                )) . "</div>";
                        }else {
                            echo "<div class='form-group'>" . $this->Form->input('blocked', array(
                                    'label' => __('Blocked'),
                                    'class' => 'form-control',
                                )) . "</div>";
                        }



                        if($this->request->data['Product']['out_stock']==true){
                            echo "<div class='form-group'>" . $this->Form->input('out_stock', array(
                                    'label' => __('Out stock'),
                                    'disabled'=>true,
                                    'class' => 'form-control',
                                )) . "</div>";
                        }else {
                            echo "<div class='form-group'>" . $this->Form->input('out_stock', array(
                                    'label' => __('Out stock'),
                                    'class' => 'form-control',
                                )) . "</div>";
                        }

                        echo "<div class='form-group'>" . $this->Form->input('with_serial_number', array(
                                'label' => __('Product with serial number'),
                                'class' => 'form-control',
                            )) . "</div>";


                        if($usePurchaseBill ==1) {
                            echo "<div class='form-group'>" . $this->Form->input('with_lot', array(
                                    'label' => __('Product with lot'),
                                    'class' => 'form-control',
                                )) . "</div>";
                        }
                        ?>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        <?php
                        $i = 0;
                        foreach ($priceCategories as $priceCategory){
                            if(isset($productPrices[$i]['ProductPrice']['id'])){
                                echo "<div class='form-group'>" . $this->Form->input('ProductPrice.'.$i.'.id', array(
                                        'value'=>$productPrices[$i]['ProductPrice']['id'],
                                        'type'=>'hidden',
                                        'class' => 'form-control',
                                    )) . "</div>";
                            }
                            echo "<div class='form-group'>" . $this->Form->input('ProductPrice.'.$i.'.price_category_id', array(
                                    'value'=>$priceCategory['PriceCategory']['id'],
                                    'type'=>'hidden',
                                    'class' => 'form-control',
                                )) . "</div>";
                            if(isset($productPrices[$i]['ProductPrice']['price_ht'])){
                                echo "<div class='form-group'>" . $this->Form->input('ProductPrice.'.$i.'.price_ht', array(
                                        'label' => __('Price').' '.$priceCategory['PriceCategory']['name'],
                                        'value'=>$productPrices[$i]['ProductPrice']['price_ht'],
                                        'class' => 'form-control',
                                        'type'=>'number'
                                    )) . "</div>";
                            }else {
                                echo "<div class='form-group'>" . $this->Form->input('ProductPrice.'.$i.'.price_ht', array(
                                        'label' => __('Price').' '.$priceCategory['PriceCategory']['name'],
                                        'class' => 'form-control',
                                        'type'=>'number'
                                    )) . "</div>";
                             }
                        $i ++;
                        }
                        echo "<div class='form-group'>" . $this->Form->input('pmp', array(
                                'label' => __('PMP'),
                                'placeholder' => __('Enter last purchase price'),
                                'class' => 'form-control',
                            )) . "</div>";
                        ?>
                    </div>
                    <div class="tab-pane" id="tab_3">

                        <?php
                        echo "<div class='form-group'>" . $this->Form->input('quantity_min', array(
                                'label' => __('Quantity min'),
                                'placeholder' => __('Enter quantity minimum product'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('quantity_max', array(
                                'label' => __('Quantity max'),
                                'placeholder' => __('Enter quantity maximum product'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('weight', array(
                                'label' => __('Weight'),
                                'placeholder' => __('Enter weight product'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('volume', array(
                                'label' => __('Volume'),
                                'placeholder' => __('Enter volume product'),
                                'class' => 'form-control',
                            )) . "</div>";

                        echo "<div class='form-group'>" . $this->Form->input('emplacement', array(
                                'label' => __('Emplacement'),
                                'placeholder' => __('Enter emplacement product'),
                                'class' => 'form-control',
                            )) . "</div>";

                        echo "<div class='form-group'>" . $this->Form->input('last_purchase_price', array(
                                'label' => __('Last purchase price'),
                                'placeholder' => __('Enter last purchase price'),
                                'class' => 'form-control',
                            )) . "</div>";

                        echo $this->Tinymce->input('Product.description', array(
                                'label' => 'Description',
                                'placeholder' => __('Enter description'),
                                'class' => 'form-control'
                            ),array(
                                'language'=>'fr_FR'
                            ),
                            'full'
                        );
                        ?>
                    </div>
                    <div class="tab-pane" id="tab_4">
                        <div  id='image-file' >

                              <?php
                                    echo "<div style='Display:none;'>" . $this->Form->input('image', array(
                                                'label' => __('Picture'),
                                                'readonly' => true,
                                                'id'=>'image',
                        						'type'=>'file',
                        						'onchange'=>'javascript:verif_ext_attachment(1,this.id)',
                                                'class' => 'form-control',
                                            )) . '</div>';

                                      echo "<div class='form-group input-button4' >" . $this->Form->input('file', array(
                                                'label' => __('Picture'),
                                                'readonly' => true,
                                                'id'=>'file',
                        						'value'=>$this->request->data['Product']['image'],
                                                'class' => 'form-control',
                                            )) . '</div>';
                                            echo "<div class='button-file'>" .$this->Html->link('<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),
                                                                'javascript:',
                                            array('escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'upfile',
                                                )). '</div>'; ?>
                        			<span class='popupactions'>
                                         <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='image-btn' type="button" onclick="delete_file('image');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
                                    </span>
                                </div>

                        	<div style="clear:both;"></div>
                    </div>
                </div>
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
    <?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
    <?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
    <?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
    <?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
    <?= $this->Html->script('bootstrap-filestyle'); ?>
    <script type="text/javascript">

        $(document).ready(function () {
            jQuery("#dialogModalCategory").dialog({
                autoOpen: false,
                height: 320,
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
            jQuery(".overlayCategory").click(function (event) {
                event.preventDefault();
                jQuery('#contentWrapCategory').load(jQuery(this).attr("href"));
                jQuery('#dialogModalCategory').dialog('option', 'title', jQuery(this).attr("title"));
                jQuery('#dialogModalCategory').dialog('open');
            });

            jQuery("#dialogModalFamily").dialog({
                autoOpen: false,
                height: 320,
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
            jQuery(".overlayFamily").click(function (event) {

                event.preventDefault();
                jQuery('#contentWrapFamily').load(jQuery(this).attr("href"));
                jQuery('#dialogModalFamily').dialog('option', 'title', jQuery(this).attr("title"));
                jQuery('#dialogModalFamily').dialog('open');
            });


            jQuery("#dialogModalMark").dialog({
                autoOpen: false,
                height: 320,
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
            jQuery(".overlayMark").click(function (event) {
                event.preventDefault();
                jQuery('#contentWrapMark').load(jQuery(this).attr("href"));  //load content from href of link
                jQuery('#dialogModalMark').dialog('option', 'title', jQuery(this).attr("title"));  //make dialog title that of link
                jQuery('#dialogModalMark').dialog('open');  //open the dialog
            });


            jQuery("#dialogModalWarehouse").dialog({
                autoOpen: false,
                height: 320,
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
            jQuery(".overlayWarehouse").click(function (event) {
                event.preventDefault();
                jQuery('#contentWrapWarehouse').load(jQuery(this).attr("href"));
                jQuery('#dialogModalWarehouse').dialog('option', 'title', jQuery(this).attr("title"));
                jQuery('#dialogModalWarehouse').dialog('open');
            });

            $("#upfile").click(function () {
                $("#image").trigger('click');

            });

            $("#image").change(function () {

                $("#file").val($("#image").val());

            });

            jQuery('#product_type').change(function (event) {
                event.preventDefault();
                jQuery('#disposition-div').load('<?php echo $this->Html->url('/products/getFieldsByProductType/')?>' + jQuery('#product_type').val());
            });




        });

        function verif_ext_attachment (img,id)  {

            pic1=jQuery('#'+id).val();
            pic1=pic1.split('.');

            if (img==1){

                var typeArr= ['jpg', 'jpeg', 'gif','png', 'pdf'];
                //use of inArray
                if(!typeArr.inArray(pic1[1])) {
                    msg = '<?php echo __('Only gif, png, jpg and jpeg images are allowed!')?>';
                    alert(msg);
                    jQuery('#'+id).val('');
                }
            }
        }

        function delete_file(id) {

            $("#"+''+id+''+"-file").before(
                function() {
                    if ( ! $(this).prev().hasClass('input-ghost') ) {
                        var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                        element.attr("name",$(this).attr("name"));
                        element.change(function(){
                            element.next(element).find('input').val((element.val()).split('\\').pop());
                        });

                        $(this).find("#"+''+id+''+"-btn").click(function(){
                            element.val(null);
                            $(this).parents("#"+''+id+''+"-file").find('input').val('');
                        });
                        $(this).find('input').css("cursor","pointer");
                        $(this).find('input').mousedown(function() {
                            $(this).parents("#"+''+id+''+"-file").prev().click();
                            return false;
                        });
                        return element;
                    }
                }
            );
        }

    </script>
    <?php $this->end(); ?>

