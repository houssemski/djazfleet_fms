<style>
    .select label {
        display: block;
    }
	a.btn {
    margin-right: 0px;
	}
</style>
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

/** @var $type integer */
/** @var $reference string */
/** @var $usePurchaseBill int */
/** @var $priceCategories array */
/** @noinspection PhpIncludeInspection */

$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
echo $this->Html->css('bootstrap-datetimepicker.min');
echo $this->Html->css('select2/select2.min');
echo $this->Html->css('iCheck/flat/red');
echo $this->Html->css('iCheck/all');
$this->end();
echo "<div class='form-group'>" . $this->Form->input('type', array(
        'label' => '',
        'type' => 'hidden',
        'class' => 'form-control',
        'id' => 'type',
        'value' => $type
    )) . "</div>";
switch ($type) {
    case BillTypesEnum::supplier_order :

        ?><h4 class="page-title"> <?= __('Add supplier order'); ?></h4>

        <?php    break;
    case BillTypesEnum::receipt :

        ?><h4 class="page-title"> <?= __("Add receipt"); ?></h4>

        <?php    break;

    case BillTypesEnum::return_supplier :

        ?><h4 class="page-title"> <?= __("Add return supplier"); ?></h4>

        <?php    break;
    case BillTypesEnum::purchase_invoice :

        ?><h4 class="page-title"> <?= __("Add purchase invoice"); ?></h4>

        <?php    break;

    case BillTypesEnum::credit_note :

        ?><h4 class="page-title"> <?= __("Add credit note"); ?></h4>

        <?php    break;

    case BillTypesEnum::delivery_order :

        ?><h4 class="page-title"> <?= __("Add delivery order"); ?></h4>

        <?php    break;

    case BillTypesEnum::return_customer :

        ?><h4 class="page-title"> <?= __("Add return customer"); ?></h4>

        <?php    break;

    case BillTypesEnum::entry_order :

        ?><h4 class="page-title"> <?= __("Add entry order"); ?></h4>

        <?php    break;

    case BillTypesEnum::exit_order :

        ?><h4 class="page-title"> <?= __("Add exit order"); ?></h4>

        <?php    break;

    case BillTypesEnum::renvoi_order :

        ?><h4 class="page-title"> <?= __("Add renvoi order"); ?></h4>

        <?php    break;

    case BillTypesEnum::reintegration_order :

        ?><h4 class="page-title"> <?= __("Add reintegration order"); ?></h4>

        <?php    break; 
		
	case BillTypesEnum::quote :

        ?><h4 class="page-title"> <?= __("Add quotation"); ?></h4>

        <?php    break;	
		
	case BillTypesEnum::customer_order :

        ?><h4 class="page-title"> <?= __("Add customer order"); ?></h4>

        <?php    break;	
		
	case BillTypesEnum::sales_invoice :

        ?><h4 class="page-title"> <?= __("Add invoice"); ?></h4>

        <?php    break;
		
		
	case BillTypesEnum::sale_credit_note :

        ?><h4 class="page-title"> <?= __("Add sale credit note"); ?></h4>

        <?php    break;
}

?>
<div class="box">
    <div class="edit form card-box p-b-0">
        <?php echo $this->Form->create('Bill', array('onsubmit' => 'javascript:disable();')); ?>
        <div class="box-body" style="max-width: 100%;">

            <div class="nav-tabs-custom pdg_btm">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
                    <li><a href="#tab_2" data-toggle="tab"><?= __('Advanced information') ?></a></li>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <?php  if ($reference != '0') {
                            echo "<div class='form-group col-sm-4' >" . $this->Form->input('reference', array(
                                    'label' => __('Reference'),
                                    'class' => 'form-control',
                                    'value' => $reference,
                                    'readonly' => true,
                                    'placeholder' => __('Enter reference'),
                                )) . "</div>";
                        } else {
                            echo "<div class='form-group col-sm-4'>" . $this->Form->input('reference', array(
                                    'label' => __('Reference'),
                                    'class' => 'form-control',
                                    'placeholder' => __('Enter reference'),
                                    'error' => array('attributes' => array('escape' => false),
                                        'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                                            __("The reference must be unique") . '</label></div>', true)
                                )) . "</div>";
                        }
                        $current_date = date("Y-m-d");
                        echo "<div class='form-group col-sm-4 clear-none'>" . $this->Form->input('date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'value' => $this->Time->format($current_date, '%d/%m/%Y'),
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Date') . '</label><div class="input-group date ">
                                <label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'date',
                            )) . "</div>";
                        if ($type == BillTypesEnum::delivery_order ||
                            $type == BillTypesEnum::exit_order ||
                            $type == BillTypesEnum::return_customer ||
                            $type == BillTypesEnum::reintegration_order ||
                            $type == BillTypesEnum::quote ||
                            $type == BillTypesEnum::customer_order ||
                            $type == BillTypesEnum::sales_invoice  ||
                            $type == BillTypesEnum::sale_credit_note  
                        ) {
                            echo "<div class='form-group col-sm-4 form-none' id='client-div'>" . $this->Form->input('supplier_id', array(
                                    'label' => __('Client'),
                                    'empty' => '',
                                    'id' => 'client',
                                    'class' => 'form-control select-search',
                                )) . "</div>";
                            ?>

							<div class="btn-group quick-actions">
                                <div id="dialogModalClient">
                                    <!-- the external content is loaded inside this tag -->
                                    <div id="contentWrapClient"></div>
                                </div>
                                <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <?php echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add', true),
                                            array("controller" => "Suppliers", "action" => "addClient", 'client'),
                                            array(
                                                "class" => "btn overlayClient",
                                                'escape' => false,
                                                "title" => __("Add client")
                                            )); ?>
                                    </li>
                                    <li>
                                        <a href="#" class="btn overlayEditClient" title=" <?= __('Edit client') ?>">
                                            <i class="fa fa-edit m-r-5"></i><?= __("Edit") ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        
						
						
						<?php
                        } else {
                            echo "<div class='form-group col-sm-4 form-none' id='supplier-div'>" . $this->Form->input('supplier_id', array(
                                    'label' => __('Supplier'),
                                    'empty' => '',
                                    'id' => 'supplier',
                                    'class' => 'form-control select-search',
                                )) . "</div>";

                        ?>

							<div class="btn-group quick-actions">
                                <div id="dialogModalSupplier">
                                    <!-- the external content is loaded inside this tag -->
                                    <div id="contentWrapSupplier"></div>
                                </div>
                                <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <?php echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add', true),
                                            array("controller" => "Suppliers", "action" => "addSupplier", 'fournisseur'),
                                            array(
                                                "class" => "btn overlaySupplier",
                                                'escape' => false,
                                                "title" => __("Add Supplier")
                                            )); ?>
                                    </li>
                                    <li>
                                        <a href="#" class="btn overlayEditSupplier" title="<?= __('Edit Supplier') ?>">
                                            <i class="fa fa-edit m-r-5"></i><?= __("Edit") ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        
						
						

                  <?php }

                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo "<div class='form-group'>" . $this->Form->input('nb_product', array(
                                'label' => '',
                                'type' => 'hidden',
                                'value' => 1,
                                'id' => 'nb_product',
                                'empty' => ''
                            )) . "</div>";
                        ?>
<div id="dialogModalDescription">
    <!-- the external content is loaded inside this tag -->
    <div id="contentWrapDescription"></div>
</div>
                        <table class="table table-bordered prod row">
                            <thead>
                            <tr>
                                <th class='col-sm-3'><?= __('Product'); ?></th>
                                <th class='col-sm-2'><?= __('Qty'); ?></th>
                                <th class='col-sm-2'><?= __('Unit price'); ?></th>
                                <th class='col-sm-1'><?= 'Ristourne'; ?></th>
                                <th class='col-sm-2'><?= __('Price HT') ?></th>
                                <th style="min-width: 68px;"><?= __('TVA') ?></th>
                                <th class='col-sm-2'><?= __('Price TTC') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            </thead>
                            <tbody id='table_products'>

                            <tr id='row1'>

                                <td> <?php
                                    if ($type == BillTypesEnum::exit_order ||
                                        $type == BillTypesEnum::delivery_order ||
                                        $type == BillTypesEnum::return_supplier ||
                                        $type == BillTypesEnum::reintegration_order
                                    ) {
                                    if($usePurchaseBill ==1) {
                                        echo "<div class='form-group input-button' id='products1'>" . $this->Form->input('BillProduct.1.product_id', array(
                                                'label' => '',
                                                'class' => 'form-control select-search',
                                                'id' => 'product1',
                                                'onchange' => 'javascript: getLotsByProduct(this.id);setCurrentProductQty(this.id);',
                                                'empty' => '',
                                            )) . "</div>";
                                    }else {
                                        echo "<div class='form-group input-button' id='products1'>" . $this->Form->input('BillProduct.1.product_id', array(
                                                'label' => '',
                                                'class' => 'form-control select-search',
                                                'id' => 'product1',
                                                'onchange' => 'javascript: getLotsByProduct(this.id); getQuantityMaxByProduct(this.id);setCurrentProductQty(this.id);',
                                                'empty' => '',
                                            )) . "</div>";
                                    }

                                    } else {
                                        if($usePurchaseBill ==1){
                                            echo "<div class='form-group small-input-button' id='products1'>" . $this->Form->input('BillProduct.1.product_id', array(
                                                    'label' => '',
                                                    'class' => 'form-control select-search',
                                                    'onchange' => 'javascript:getLotsByProduct(this.id);setCurrentProductQty(this.id);',
                                                    'id' => 'product1',
                                                    'empty' => '',
                                                )) . "</div>";
                                        }else {
                                            echo "<div class='form-group small-input-button' id='products1'>" . $this->Form->input('BillProduct.1.product_id', array(
                                                    'label' => '',
                                                    'class' => 'form-control select-search',
                                                    'onchange' => 'javascript:getLotsByProduct(this.id); calculPrice(this.id);setCurrentProductQty(this.id);',
                                                    'id' => 'product1',
                                                    'empty' => '',
                                                )) . "</div>";
                                        }
                                    }
                                        ?>
                                        <!-- overlayed element -->
                                        <div class="right-popupactions ">
                                            <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('', true),
                                                'javascript:;',
                                                array("class" => "btn btn-danger btn-trans waves-effect waves-danger overlayProduct", 'id' => 'prod1', 'onclick' => 'javascript:addProduct(this.id);', 'escape' => false, "title" => __("Add Product"))); ?>
                                        </div>
                                        <div id="dialogModalProduct1">
                                            <!-- the external content is loaded inside this tag -->
                                            <div id="contentWrapProduct1"></div>
                                        </div>
                                        <div style="clear:both"></div>
                            <?php if($usePurchaseBill ==1) { ?>
									<div id='div-lot1' >
									</div>
                            <?php } ?>
							
							 <?php
                                    echo "<div id ='div-designation1'>" . $this->Form->input('BillProduct.1.designation',
                                            array(
                                                'label' => '',
                                                'empty' => '',
                                                'id' => 'designation1',
                                                'class' => 'form-control',
                                            )) . "</div>";
                                    ?>
                                </td  >
                               
                                <td><?php
                                    if ($type == BillTypesEnum::exit_order ||
                                        $type == BillTypesEnum::delivery_order ||
                                        $type == BillTypesEnum::return_supplier ||
                                        $type == BillTypesEnum::reintegration_order
                                    ) {
                                        echo "<div class='form-group' id='quantity_max1'>" . $this->Form->input('BillProduct.1.quantity', array(
                                                'label' => '',
                                                'class' => 'form-control',
                                                'id' => 'quantity-1',
                                                'onchange' => 'javascript: getQuantityMaxByProduct(this.id);',
                                                'placeholder' => __('Quantity'),
                                            )) . "</div>";
                                    } else {
                                        echo "<div class='form-group' id='quantity_max1'>" . $this->Form->input('BillProduct.1.quantity', array(
                                                'label' => '',
                                                'class' => 'form-control',
                                                'id' => 'quantity-1',
                                                'onchange' => 'javascript:calculPrice(this.id);',
                                                'placeholder' => __('Quantity'),
                                            )) . "</div>";
                                    }

                                    ?>
                                    <div id="div-current-qty1">
                                        <?= $this->Form->input('current-qty1', array(
                                            'id' => 'current-qty1',
                                            'value' => '0',
                                            'type' => 'hidden'
                                        )); ?>
                                    </div>

                                </td>
                                <td><?php
                                    echo "<div class='form-group' id='div_unit_price1'>" . $this->Form->input('BillProduct.1.unit_price', array(
                                            'label' => '',
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter price product'),
                                            'id' => 'price1',
                                            'onchange' => 'javascript:calculPrice(this.id);javascript:calculRistourneVal(this.id);',
                                            'empty' => ''
                                        )) . "</div>";
                                    if ($type == BillTypesEnum::delivery_order) {
                                        $pricePmp = array('0' => 'PMP');
                                        if (!empty($priceCategories)) {
                                            $options = array_merge($pricePmp, $priceCategories);
                                        } else {
                                            $options = $priceCategories;
                                        }

                                        echo "<div class='form-group' >" . $this->Form->input('BillProduct.1.price_category_id', array(
                                                'label' => '',
                                                'class' => 'form-control select3',
                                                'id' => 'price_category1',
                                                'onchange' => 'javascript:getPriceLot(this.id);',
                                                'options' => $options,
                                                'empty' => ''
                                            )) . "</div>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo "<div class='form-group'>" . $this->Form->input('BillProduct.1.ristourne_val', array(
                                            'type' => 'number',
                                            'label' => '',
                                            'placeholder' => '',
                                            'class' => 'form-control',
                                            'id' => 'ristourne_val1',
                                            'onchange' => 'javascript:calculRistournePourcentage(this.id);',
                                        )) . "</div>";
                                    echo "<div class='form-group'>" . $this->Form->input('BillProduct.1.ristourne_%', array(
                                            'label' => '',
                                            'placeholder' => '',
                                            'id' => 'ristourne1',
                                            'onchange' => 'javascript:calculRistourneVal(this.id);',
                                            'class' => 'form-control',
                                        )) . "</div>";  ?>


                                </td>

                                <td> <?php  echo "<div class='form-group' >" . $this->Form->input('BillProduct.1.price_ht', array(
                                            'label' => '',
                                            'class' => 'form-control',
                                            'id' => 'ht1',
                                            'readonly' => true,
                                            'empty' => ''
                                        )) . "</div>";
                                    ?>
                                </td>
                                <td> <?php
                                    echo "<div class='form-group' id='tva-div1'>" . $this->Form->input('BillProduct.1.tva_id', array(
                                            'label' => '',
                                            'class' => 'form-control',
                                            'id' => 'tva1',
                                            'onchange' => 'javascript:calculPrice(this.id);',
                                            'value' => 1
                                        )) . "</div>";?>
                                </td>
                                <td> <?php
                                    echo "<div class='form-group' >" . $this->Form->input('BillProduct.1.price_ttc', array(
                                            'label' => '',
                                            'class' => 'form-control',
                                            'id' => 'ttc1',
                                            'readonly' => true,
                                            'empty' => ''
                                        )) . "</div>";
										
										/*echo "<div class='hidden' id ='description-div1'>" . $this->Form->input('BillProduct.1.description',
                                                    array(
                                                        'id' => 'description1',
                                                    )) . "</div>";*/
                                    ?>
                                </td>
                                <td>
								<?= $this->Html->link(
										'<i  class="fa fa-edit" title="' . __('Edit description') . '"></i>',
										 'javascript:editDescription("editDescription1");',
										array('escape' => false, 'class' => 'btn btn-primary' , 
												'id' => 'editDescription1',  "title" => __("Edit description"))
										 ); ?>										
								</td>


                            </tr>

                            </tbody>
                        </table>

                        <div class="btn-group pull-right">
                            <div class="header_actions">
                                <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add Product'),
                                    'javascript:addProductBill();',
                                    array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'add_product')) ?>
                            </div>
                        </div>
                        <div style='clear:both; padding-bottom: 20px;'></div>

                        <?php
                        $options = array('1' => __('A terme'), '2' => __('Chèque'), '3' => __('Chèque-banque'), '4' => __('Virement'), '5' => __('Avoir'), '6' => __('Espèce'), '7' => __('Traite'), '8' => __('Fictif'));


                        echo "<div  class='  col-sm-4 p-b-10'>" . $this->Form->input('payment_method', array(
                            'label' => __('Payment method'),
                            'class' => 'form-control select-search',
                            'options' => $options,
                            'id' => 'payment_method',
                             'empty'=>'',
                            'onchange' => 'javascript : calculateStampValue();'
                            )) . "</div>";

                        echo "<div  class='p-b-10  col-sm-4'>" . $this->Form->input('stamp', array(
                            'label' => __('Stamp'),
                            'class' => 'form-control',
                            'id' => 'stamp',
                            'readonly' => true,
                            )) . "</div>";

                        ?>
                        <div style='clear:both;'></div>
                        <div>
                            <?php
                            echo "<div  class='m-t-20 col-sm-4 '>" . $this->Form->input('total_ht', array(
                                    'label' => __('Total HT'),
                                    'readonly' => true,
                                    'class' => 'form-control',
                                    'id' => 'total_ht',

                                )) . "</div>";


                            echo "<div  class='m-t-20  col-sm-4'>" . $this->Form->input('ristourne_val', array(
                                    'label' => __('Ristourne'),
                                    'class' => 'form-control',
                                    'id' => 'ristourne_val',
                                    'onchange'=>'javascript : calculateGlobalRistourne();'
                                )) . "</div>";

                            echo "<div  class='m-t-20  col-sm-4'>" . $this->Form->input('ristourne_percentage', array(
                                    'label' => __('Ristourne').' '.('%'),
                                    'class' => 'form-control',
                                    'id' => 'ristourne_percentage',
                                    'onchange'=>'javascript : calculateGlobalRistourneVal();'
                                )) . "</div>";
                            echo "<div  class='m-t-20 col-sm-4'>" . $this->Form->input('total_tva', array(
                                    'label' => __('Total TVA'),
                                    'readonly' => true,
                                    'class' => 'form-control',
                                    'id' => 'total_tva',

                                )) . "</div>";

                            echo "<div  class='m-t-20  col-sm-4'>" . $this->Form->input('total_ttc', array(
                                    'label' => __('Total TTC'),
                                    'readonly' => true,
                                    'class' => 'form-control',
                                    'id' => 'total_ttc',
                                )) . "</div>";
                            ?>

                            <div style='clear:both;'></div>
                            <div style='clear:both; padding-bottom: 20px;'></div>
                            <?php  echo "<div  class='form-group'>" . $this->Form->input('note', array(
                                    'label' => __('Note'),

                                    'class' => 'form-control',

                                )) . "</div>";?>

                        </div>

                    </div>

                    <div class="tab-pane " id="tab_2">

                        <?php

                        echo "<div class='form-group col-sm-4 clear-none' id='categories'>" . $this->Form->input('transport_bill_category_id', array(
                                'label' => __('Category'),
                                'empty' => '',
                                'id' => 'category',
                                'class' => 'form-control select-search',
                            )) . "</div>";
                        ?>
                        <!-- overlayed element -->
                        <div id="dialogModalCategory">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapCategory"></div>
                        </div>
                        <div class="popupactions">

                            <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                array("controller" => "transportBills", "action" => "addCategory"),
                                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayCategory", 'escape' => false, "title" => __("Add Category"))); ?>

                        </div>
                        <div style="clear:both"></div>

                    </div>
                </div>


            </div>

        
		
		</div>

        <div class="box-footer">
            <?php echo $this->Form->submit(__('Save'), array(
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
<?= $this->Html->script('maskedinput'); ?>

<?= $this->Html->script('plugins/datetimepicker/moment-with-locales.min.js'); ?>
<?= $this->Html->script('plugins/datetimepicker/bootstrap-datetimepicker.min.js'); ?>
<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>
<?= $this->Html->script('plugins/iCheck/icheck.min'); ?>
<?= $this->Html->script('tinymce/tinymce.min.js'); ?>
<script type="text/javascript">

    $(document).ready(function () {

        jQuery("#designation1" ).css('margin-top', 8);
        jQuery("#ristourne_val1" ).css('margin-top', 8);
        jQuery("#editDescription1" ).css('margin-top', 14);
        jQuery("#date").inputmask("date", {"placeholder": "dd/mm/yyyy"});
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
            var categoryDiv = jQuery('#dialogModalCategory');
            categoryDiv.dialog('option', 'title', jQuery(this).attr("title"));
            categoryDiv.dialog('open');
        });
		 
		jQuery("#dialogModalDescription").dialog({
            autoOpen: false,
            height: 600,
            width: 800,
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
        
		
        jQuery("#dialogModalSupplier").dialog({
            autoOpen: false,
            height: 610,
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
        jQuery(".overlaySupplier").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapSupplier').load(jQuery(this).attr("href"));
            var supplierDiv = jQuery('#dialogModalSupplier');
            supplierDiv.dialog('option', 'title', jQuery(this).attr("title"));
            supplierDiv.dialog('open');
        });
		
		jQuery(".overlayEditSupplier").click(function (event) {
            event.preventDefault();
            var supplierId = jQuery("#supplier").val();
            if (supplierId > 0) {

                var supplierDiv = jQuery('#dialogModalSupplier');
                supplierDiv.dialog('option', 'title', jQuery(this).attr("title"));
                supplierDiv.dialog('open');
                jQuery('#contentWrapSupplier').load("<?php echo $this->Html->url('/Suppliers/editSupplier/')?>" + supplierId + '/supplier');
            }
        });
    

        jQuery("#dialogModalClient").dialog({
            autoOpen: false,
            height: 610,
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
        jQuery(".overlayClient").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapClient').load(jQuery(this).attr("href"));
            var clientDiv = jQuery('#dialogModalClient');
            clientDiv.dialog('option', 'title', jQuery(this).attr("title"));
            clientDiv.dialog('open');
        });

        jQuery(".overlayEditClient").click(function (event) {
            event.preventDefault();
            var clientId = jQuery("#client").val();
			
            if (clientId > 0) {

                var clientDiv = jQuery('#dialogModalClient');
                clientDiv.dialog('option', 'title', jQuery(this).attr("title"));
                clientDiv.dialog('open');
                jQuery('#contentWrapClient').load("<?php echo $this->Html->url('/Suppliers/editClient/')?>" + clientId + '/client');
            }
        });
    
	});

    function getDesignationProduct(num) {
        var productId = jQuery("#product" + '' + num + '').val();
        jQuery("#div-designation" + '' + num + '').load('<?php echo $this->Html->url('/bills/getDesignationProduct/')?>' + num + '/' + productId , function () {
            jQuery("#designation" + '' + num + '').css('margin-top', 8);
        });
    }    

	function getTvaProduct(num) {
        var productId = jQuery("#product" + '' + num + '').val();
        jQuery("#tva-div" + '' + num + '').load('<?php echo $this->Html->url('/bills/getTvaProduct/')?>' + num + '/' + productId , function () {
        });
    }

    function addProductBill() {
        var old_nb_product = jQuery('#nb_product');
        var nb_product = parseFloat(old_nb_product.val()) + 1;
        var type = jQuery('#type').val();
        old_nb_product.val(nb_product);
        jQuery("#table_products").append("<tr id=row" + nb_product + "></tr>");
        jQuery("#row" + '' + nb_product + '').load("<?php echo $this->Html->url('/bills/addProductBill/')?>" + nb_product + '/' + type, function () {
            $('.select3').select2();
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
    }
    function getPriceLot(id) {
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(3, trId.length);

        var priceCategoryId = jQuery("#price_category" + '' + num + '').val();

        var lotId = jQuery("#product" + '' + num + '').val();

        if (lotId > 0 ) {

            jQuery("#div_unit_price" + '' + num + '').load('<?php echo $this->Html->url('/bills/getPriceLot/')?>' + lotId + '/' + num + '/' + priceCategoryId, function () {

                calculPrice(id);
            });
        }
    }
	
	function getLotsByProduct(id){
		var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(3, trId.length);
		var productId = jQuery("#product" + '' + num + '').val();
		
        getDesignationProduct(num);
        getTvaProduct(num);
		jQuery("#div-lot" + '' + num + '').load('<?php echo $this->Html->url('/bills/getLotsByProduct/')?>' + productId + '/' + num , function () {
                $('.select3').select2();
				calculPrice(id);
            });
	}
function setCurrentProductQty(id, rowNum=0){
    var num = 0;
    if(rowNum == 0){
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        num = trId.substring(3, trId.length);
    }else{
        num = rowNum;
    }
    var productId = jQuery("#product" + '' + num + '').val();

    jQuery("#div-current-qty" + num).load('<?php echo $this->Html->url('/bills/getCurrentProductQty/')?>' + productId + '/' + num, function () {
        var currentQty = jQuery("#current-qty" + num).val();
        var outStock = jQuery("#out_stock" + num).val();
        if(outStock == 0) {
            switch (jQuery("#type").val()) {
                case '3':
                case '6':
                case '9':
                case '10':
                    if(currentQty <= 0) {
                        alert('<?php echo __('The quantity of the product is 0') ?>');
                        jQuery("#quantity-" + num).val(0);
                    }else{
                        if(jQuery("#quantity-" + num).val() > 0){
                            getQuantityMaxByProduct(0, num);
                        }
                    }
                    break;

                default:
                    break;
            }
        }

    });
}

    function calculateStampValue() {
        var paymentMethod = jQuery("#payment_method").val();
        if (paymentMethod == 6) {
            var totalTtc = jQuery('#total_ttc').val();
            var stamp = parseFloat(totalTtc) / 100;
            if (parseFloat(stamp) >= 2500) {
                stamp = 2500;
            }
            totalTtc = parseFloat(totalTtc) + parseFloat(stamp);
            jQuery('#stamp').val(stamp);
            jQuery('#total_ttc').val(totalTtc);
        } else {
            var totalHt = jQuery('#total_ht').val();
            var totalTva = jQuery('#total_tva').val();
            var totalTtc = parseFloat(totalHt) + parseFloat(totalTva);
            jQuery('#stamp').val(0);
            jQuery('#total_ttc').val(totalTtc);
        }
    }

    function calculateGlobalRistourne(){
        if (jQuery("#ristourne_val" ).val() > 0) {

            var totalTtc = parseFloat(jQuery("#total_ht").val())+ parseFloat(jQuery("#total_tva").val());
            var ristourneVal = parseFloat(jQuery("#ristourne_val").val());
            if (ristourneVal > totalTtc) {
                ristourneVal = totalTtc;
                jQuery("#ristourne_val" ).val(ristourneVal);
            }
            var ristourne = ( ristourneVal / totalTtc) * 100;
            ristourne = ristourne.toFixed(2);
            jQuery("#ristourne_percentage").val(ristourne);
            totalTtc = totalTtc - parseFloat(ristourneVal);
            jQuery("#total_ttc" ).val(totalTtc);
        }
    }

    function calculateGlobalRistourneVal(){

        if (jQuery("#ristourne_percentage" ).val() > 0) {
            var totalTtc = parseFloat(jQuery("#total_ht").val())+ parseFloat(jQuery("#total_tva").val());
            var ristourne = parseFloat(jQuery("#ristourne_percentage").val());
            if (parseFloat(ristourne) > 100) {
                ristourne = 100;
                jQuery("#ristourne" ).val(ristourne);
            }
            var ristourneVal = parseFloat(parseFloat(ristourne) * totalTtc) / 100;
            ristourneVal = ristourneVal.toFixed(2);
            jQuery("#ristourne_val" ).val(ristourneVal);
            totalTtc = totalTtc - parseFloat(ristourneVal);
            jQuery("#total_ttc" ).val(totalTtc);
        }
    }

    function calculPrice(id, rowNum=0) {

        var num = 0;
        if(rowNum == 0){
            var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
            num = trId.substring(3, trId.length);
        }else{
            num = rowNum;
        }

        var tva = jQuery("#tva" + '' + num + '').val();
        switch (tva) {
            case '1':
                tva = 0.19;
                break;
            case '2':
                tva = 0.09;
                break;
            case '3':
                tva = 0.00;
                break;
            case '4':
                tva = 0.00;
                break;

        }
        var price = jQuery("#price" + '' + num + '' + "");
        var quantity = jQuery("#quantity-" + '' + num + '' + "");
        var ristourne_val = jQuery("#ristourne_val" + '' + num + '' + "");
        var total_ttc;
        var total_ht;
        if (price.val() >= 0) {
            if (quantity.val() >= 0) {
                if (ristourne_val.val() > 0) {
                    total_ht = quantity.val() * (parseFloat(price.val()) - parseFloat(ristourne_val.val()));
                    total_ttc = quantity.val() * (parseFloat(price.val()) - parseFloat(ristourne_val.val())) * (parseFloat(tva));
                }
                else {
                    total_ht = quantity.val() * price.val();
                    total_ttc = parseFloat(total_ht) + (parseFloat(total_ht) * parseFloat(tva));
                }
                total_ht = total_ht.toFixed(2);
                total_ttc = total_ttc.toFixed(2);

                jQuery("#ht" + '' + num + '' + "").val(total_ht);
                jQuery("#ttc" + '' + num + '' + "").val(total_ttc);
                calculateTotalPrice();
            }

        }

    }


    function calculRistournePourcentage(id) {
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(3, trId.length);
        var ristourne_val = jQuery("#ristourne_val" + '' + num + '' + "");
        if (ristourne_val.val() > 0) {
            var ristourne = ( ristourne_val.val() / jQuery("#price" + '' + num + '' + "").val()) * 100;
            ristourne = ristourne.toFixed(4);
            jQuery("#ristourne" + '' + num + '' + "").val(ristourne);
        }
        calculPrice(id);

    }

    function calculRistourneVal(id) {
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(3, trId.length);
        var ristourne = jQuery("#ristourne" + '' + num + '' + "");

        if ( ristourne.val() > 0) {
            var ristourne_val = ( ristourne.val() * jQuery("#price" + '' + num + '' + "").val()) / 100;

            jQuery("#ristourne_val" + '' + num + '' + "").val(ristourne_val);

        }
        calculPrice(id);
    }


    function getQuantityMaxByProduct(id, rowNum = 0) {
        var num = 0;
        if(rowNum == 0){
            var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
            num = trId.substring(3, trId.length);
        }else{
            num = rowNum;
        }
        var productId = jQuery("#product" + '' + num + '' + "").val();
        var quantity = jQuery("#quantity-" + '' + num + '' + "").val();

        if (quantity != '') {
            jQuery("#quantity_max" + '' + num + '').load("<?php echo $this->Html->url('/bills/getQuantityMaxByProduct/')?>" + num + '/' + productId + '/' + quantity + '/' + jQuery("#type").val(), function(){
                calculPrice(0, num);
            });
        }
    }

    function calculateTotalPrice() {
        var total_price_ht = 0.00;
        var total_price_ttc = 0.00;
        var total_price_tva = 0.00;
        var nb = jQuery("#nb_product").val();
        for (var i = 1; i <= nb; i++) {
            var ht = jQuery("#ht" + '' + i + '').val();
            var ttc = jQuery("#ttc" + '' + i + '' + "").val();
            if (ht) {
                if (ht != 0) {
                    total_price_ht = total_price_ht + parseFloat(ht);
                    total_price_ttc = total_price_ttc + parseFloat(ttc);
                    total_price_tva = total_price_ttc - total_price_ht;
                }
            }
        }
        total_price_ht = total_price_ht.toFixed(2);
        total_price_ttc = total_price_ttc.toFixed(2);
        total_price_tva = total_price_tva.toFixed(2);

        jQuery("#total_ht").val(total_price_ht);
        jQuery("#total_ttc").val(total_price_ttc);
        jQuery("#total_tva").val(total_price_tva);
    }

    function removeBillProduct(id) {
        $('#row' + id + '').remove();
        calculateTotalPrice();
    }

    function DeleteProduct(id) {

        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(3, trId.length);

        jQuery("#product" + '' + num + '' + "").css("display", "none");

        jQuery("#quantity-" + '' + num + '' + "").val(0);
        jQuery("#price" + '' + num + '' + "").val(0);
        jQuery("#ht" + '' + num + '' + "").val(0);
        jQuery("#ttc" + '' + num + '' + "").val(0);
        jQuery("#tva" + '' + num + '' + "").val(0);
        // jQuery("#total"+''+num+''+"").html("<span style='float: right;'>"0.00"</span>");

        var total_price_ht = 0.00;
        var total_price_ttc = 0.00;
        var total_price_tva = 0.00;
        var nb = jQuery("#nb_product").val();
        if (nb == 0) {
            total_price_ht = jQuery("#ht0").val();
            total_price_ttc = jQuery("#ttc0").val();
            total_price_tva = jQuery("#tva0").val();
        } else {
            for (var i = 0; i <= nb; i++) {
                total_price_ht = total_price_ht + parseFloat(jQuery("#ht" + '' + i + '' + "").val());
                total_price_ttc = total_price_ttc + parseFloat(jQuery("#ttc" + '' + i + '' + "").val());
                total_price_tva = total_price_tva + parseFloat(jQuery("#tva" + '' + i + '' + "").val());
            }
            total_price_ht = total_price_ht.toFixed(2);
            total_price_ttc = total_price_ttc.toFixed(2);
            total_price_tva = total_price_tva.toFixed(2);
        }


        jQuery("#price_ht").val(total_price_ht);
        jQuery("#price_ttc").val(total_price_ttc);
        jQuery("#price_tva").val(total_price_tva);
        jQuery("#total_ht").html("<span style='float: right;'>" + total_price_ht + "</span>");
        jQuery("#total_ttc").html("<span style='float: right;'>" + total_price_ttc + "</span>");
        jQuery("#total_tva").html("<span style='float: right;'>" + total_price_tva + "</span>");

    }


    function addProduct(id) {

        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(3, trId.length);
        var type = jQuery('#type').val();

    var dialogModalProduct = jQuery("#dialogModalProduct" + '' + num + '' + "");
        dialogModalProduct.dialog({
            autoOpen: false,
            height: 500,
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


        dialogModalProduct.dialog('option', 'title', 'Ajouter produit');
        dialogModalProduct.dialog('open');

        jQuery("#contentWrapProduct" + '' + num + '' + "").load("<?php echo $this->Html->url('/bills/addProduct/')?>" + num+'/'+type);


    }

    function addLot(id) {

        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(3, trId.length);
        var productId = jQuery("#product" + '' + num + '').val();
        var dialogModalLot = jQuery("#dialogModalLot" + '' + num + '' + "");
        dialogModalLot.dialog({
            autoOpen: false,
            height: 500,
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

        dialogModalLot.dialog('option', 'title', 'Ajouter lot');
        dialogModalLot.dialog('open');
        jQuery("#contentWrapLot" + '' + num + '' + "").load("<?php echo $this->Html->url('/bills/addLot/')?>" + productId+'/'+num);

    }
	
	   function editDescription(id) {
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(3, trId.length);
        var productId = jQuery("#product" + '' + num + '').val();

        if (productId > 1) {
            var descriptionDiv = jQuery('#dialogModalDescription');
            descriptionDiv.dialog('option', 'title', jQuery(this).attr("title"));
            descriptionDiv.dialog('open');
             jQuery('#contentWrapDescription').load("<?php echo $this->Html->url('/bills/editDescription/')?>" + productId +'/'+ num , function () {

                 tinyMCE.init(
                    {"theme":"silver","plugins":"print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern","theme_advanced_buttons1":"save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect","theme_advanced_buttons2":"cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor","theme_advanced_buttons3":"tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen","theme_advanced_buttons4":"insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak","theme_advanced_toolbar_location":"top","theme_advanced_toolbar_align":"left","theme_advanced_statusbar_location":"bottom","theme_advanced_resizing":true,"theme_advanced_resize_horizontal":false,"convert_fonts_to_spans":true,"file_browser_callback":"ckfinder_for_tiny_mce","language":"fr_FR","mode":"exact","elements":"BillProductDescription"}
                );

            });
		}
    }






</script>



<?php $this->end(); ?>