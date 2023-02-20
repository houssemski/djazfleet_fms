<?php

 ?>


    <div class="panel-group" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">

                    <a data-toggle="collapse" href="#collapse1" style="font-size: 20px;color: #3c8dbc;font-weight: bold;"><i class="fa fa-long-arrow-right "></i><?php echo __('Parts') ?></a>
                </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse">
                <div class="panel-body">

                    <?php echo "<div class='form-group'>" . $this->Form->input('Bill.nb_product', array(
                            'label' =>'',
                            'type' => 'hidden',
                            'value' =>0,
                            'id' =>'nb_product',
                            'empty' => ''
                        )) . "</div>";

                    ?>


                    <div id ='product'>

                        <table class="table table-bordered prod ">
                            <thead>
                            <tr>
                                <th class='th-prod2  mb' ></th>
                                <th class=" col-sm-3 mb"><?php echo __('Product'); ?></th>
                                <th class=" col-sm-3 mb"><?php echo __('Quantity'); ?></th>
                                <th class=" col-sm-3 mb"><?php echo __('Price'); ?></th>
                                <th class=" col-sm-3 mb"><?php echo __('Supplier'); ?></th>

                            </tr>
                            </thead>
                            <tbody id='table_products'>

                            <?php if (empty($eventProducts)){ ?>

                            <tr id='product0'>

                                <td >
                                    <!--<a id='delete_product0' onclick='DeleteProduct(this.id)'><i class="fa fa-trash-o m-r-5 dlt"></i></a>-->
                                    <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 dlt2"></i>',
                                        'javascript:DeleteProduct(this.id);',
                                        array('escape' => false,'id' => 'delete_product0', 'onclick' => 'javascript:DeleteProduct(this.id);'));  ?>
                                </td>
                                <td > <?php  echo "<div class='form-group' id='products0'>" . $this->Form->input('EventTypeProduct.0.product_id', array(
                                            'label' => "",
                                            'class' => 'form-control',
                                            'id' =>'product_name0',
                                            'type'=>'select',
                                            'option'=>$products,
                                            'rel' => 0,
                                            'onchange' => 'javascript:quantityMax(this.id);',
                                            'empty'=>__('Select product'),
                                        )) . "</div>"; ?>

                                </td>
                                <td ><?php  echo "<div class='form-group'>" . $this->Form->input('EventTypeProduct.0.quantity', array(
                                            'label' =>"",
                                            'class' => 'form-control',
                                            'id' =>'prod-quantity0',
                                            'onchange' => 'javascript:calculPrice(this.id);',
                                            'placeholder'=>__('Enter quantity'),
                                            'empty' => ''
                                        )) . "</div>"; ?>
                                    <span id='quantity_max0'>
                </span>
                                    <span id='msg0'>
                </span>
                                </td>

                                <td ><div style="height: 20px;"></div><?php  echo "<div class='form-group'>" . $this->Form->input('EventTypeProduct.0.price', array(
                                            'label' =>"",
                                            'class' => 'form-control',
                                            'id' =>'prod-price0',
                                            'placeholder'=>__('Enter price'),
                                            'empty' => ''
                                        )) . "</div>"; ?>

                                    <?php
                                    $options = array('1' => __('Original'), '2' => __('Copie'));

                                    $attributes = array('legend' => false,'onclick' =>'javascript:setProductPrice(jQuery(this));'
                                    ,'data' => 0);
                                    echo $this->Form->radio('original_copy', $options, $attributes) . "</div><br/>";
                                    ?>
                                </td>

                                <td > <?php  echo "<div class='form-group' id='products0'>" . $this->Form->input('EventTypeProduct.0.supplier_id', array(
                                            'label' => "",
                                            'class' => 'form-control',
                                            'id' =>'supplier0',
                                            'type'=>'select',
                                            'options'=>$suppliers,
                                            'readonly' => true,
                                            'onchange' => 'javascript:quantityMax(this.id);',
                                            'empty'=>__('Select supplier'),
                                        )) . "</div>"; ?>

                                </td>

                                <?php }else{ ?>
                                    <?php
                                    $i = 0;
                                    foreach ($eventProducts as $eventProduct){?>
                            <tr id='product<?=$i?>'>

                                <td >
                                    <input title="" name="data[EventTypeProduct][<?= $i ?>][id]" type="hidden" value="<?=$eventProduct['EventTypeProduct']['id']?>" >
                                    <!--<a id='delete_product0' onclick='DeleteProduct(this.id)'><i class="fa fa-trash-o m-r-5 dlt"></i></a>-->
                                    <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 dlt2"></i>',
                                        'javascript:DeleteProduct(this.id);',
                                        array('escape' => false,'id' => 'delete_product'.$i, 'onclick' => 'javascript:DeleteProduct(this.id);'));  ?>
                                </td>
                                <td > <?php  echo "<div class='form-group' id='products".$i."'>" . $this->Form->input('EventTypeProduct.'.$i.'.product_id', array(
                                            'label' => "",
                                            'class' => 'form-control',
                                            'id' =>'product_name'.$i,
                                            'type'=>'select',
                                            'option'=>$products,
                                            'selected' => $eventProduct['EventTypeProduct']['product_id'],
                                            'rel' => $i,
                                            'onchange' => 'javascript:quantityMax(this.id);',
                                            'empty'=>__('Select product'),
                                        )) . "</div>"; ?>

                                </td>
                                <td ><?php  echo "<div class='form-group'>" . $this->Form->input('EventTypeProduct.'.$i.'.quantity', array(
                                            'label' =>"",
                                            'class' => 'form-control',
                                            'id' =>'prod-quantity'.$i,
                                            'value' => $eventProduct['EventTypeProduct']['quantity'],
                                            'onchange' => 'javascript:calculPrice(this.id);',
                                            'placeholder'=>__('Enter quantity'),
                                            'empty' => ''
                                        )) . "</div>"; ?>
                                    <span id='quantity_max0'>
                </span>
                                    <span id='msg0'>
                </span>
                                </td>

                                <td ><div style="height: 20px;"></div><?php  echo "<div class='form-group'>" . $this->Form->input('EventTypeProduct.'.$i.'.price', array(
                                            'label' =>"",
                                            'class' => 'form-control',
                                            'id' =>'prod-price'.$i,
                                            'value' => $eventProduct['EventTypeProduct']['price'],
                                            'placeholder'=>__('Enter price'),
                                            'empty' => ''
                                        )) . "</div>"; ?>

                                    <?php
                                    $options = array('1' => __('Original'), '2' => __('Copie'));

                                    $attributes = array('legend' => false,'onclick' =>'javascript:setProductPrice(jQuery(this));'
                                    ,'data' => $i);
                                    echo $this->Form->radio('original_copy', $options, $attributes) . "</div><br/>";
                                    ?>
                                </td>

                                <td > <?php  echo "<div class='form-group' id='products".$i."'>" . $this->Form->input('EventTypeProduct.'.$i.'.supplier_id', array(
                                            'label' => "",
                                            'class' => 'form-control',
                                            'id' =>'supplier'.$i,
                                            'selected' => $eventProduct['EventTypeProduct']['supplier_id'],
                                            'type'=>'select',
                                            'options'=>$suppliers,
                                            'readonly' => true,
                                            'onchange' => 'javascript:quantityMax(this.id);',
                                            'empty'=>__('Select supplier'),
                                        )) . "</div>"; ?>

                                </td>
                                    <?php
                                    $i++;
                                    }
                                    ?>
                                <?php } ?>
                                <td style='display:none;'> <?php  echo "<div class='form-group group g1' >" . $this->Form->input('BillProduct.0.price_ht', array(
                                            'label' => "price ht",
                                            'class' => 'form-control form-prod',
                                            'id' =>'ht0',
                                            'type'=>'hidden',
                                            'empty' => ''
                                        )) . "</div>";
                                    echo "<div class='form-group group g1' >" . $this->Form->input('BillProduct.0.price_ttc', array(
                                            'label' => "price ttc",
                                            'class' => 'form-control form-prod',
                                            'id' =>'ttc0',
                                            'type'=>'hidden',
                                            'empty' => ''
                                        )) . "</div>";
                                    echo "<div class='form-group group g1' >" . $this->Form->input('BillProduct.0.price_tva', array(
                                            'label' => "price tva",
                                            'class' => 'form-control form-prod',
                                            'id' =>'tva0',
                                            'type'=>'hidden',
                                            'empty' => ''
                                        )) . "</div>";?>

                                    <div id ='total0'><span style="float: right;">0.00</span></div>

                                </td>

                            </tr>
                            </tbody>
                        </table>


                    </div>
                    <br/>
                    <div class="btn-group pull-left">
                        <div class="header_actions">
                            <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>'.__('Add Product'),
                                'javascript:addProductBill();',
                                array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' =>'add_product')) ?>

                        </div>
                    </div>

                    </br></br></br>

                    <table class="table table-bordered price " style='display:none;'>
                        <tbody>
                        <tr>
                            <td class="total-price"><span style="float: right; font-weight: bold;"><?php echo __('Total HT'); ?></span></td>
                            <td ><div id ='total_ht'><span style="float: right;">0.00</span></div></td>
                        </tr>
                        <tr>
                            <td class="total-price"><span style="float: right; font-weight: bold;"><?php echo __('Total TVA'); ?></span></td>
                            <td ><div id ='total_tva'><span style="float: right;">0.00</span></div></td>
                        </tr>
                        <tr>
                            <td class="total-price"><span style="float: right; font-weight: bold;"><?php echo __('Total TTC'); ?></span></td>
                            <td ><div id ='total_ttc'><span style="float: right;">0.00</span></div></td>
                        </tr>
                        </tbody>

                    </table>


                    <?php    echo "<div class='form-group'>" . $this->Form->input('Bill.total_ht', array(
                            'label' => __('Total HT'),
                            'id' =>'price_ht',
                            'type' =>'hidden',
                            'class' => 'form-control',
                        )) . "</div>";
                    echo "<div class='form-group'>" . $this->Form->input('Bill.total_ttc', array(
                            'label' => __('Total TTC'),
                            'id' =>'price_ttc',
                            'type' =>'hidden',
                            'class' => 'form-control',
                        )) . "</div>";
                    echo "<div class='form-group'>" . $this->Form->input('Bill.total_tva', array(
                            'label' => __('Total TVA'),
                            'id' =>'price_tva',
                            'type' =>'hidden',
                            'class' => 'form-control',
                        )) . "</div>";?>






                </div>

            </div>
        </div>
    </div>

<?php  ?>
