<div class="box-body main">
    <?php

    switch ($type) {
        case BillTypesEnum::supplier_order :

            ?><h4 class="page-title"> <?= __('Add supplier order'). " " . $bill['Bill']['reference']; ?></h4>


            <?php    break;
        case BillTypesEnum::receipt :

            ?><h4 class="page-title"> <?= __("Receipt"). " " . $bill['Bill']['reference']; ?></h4>

            <?php    break;

        case BillTypesEnum::return_supplier :

            ?><h4 class="page-title"> <?= __("Return supplier"). " " . $bill['Bill']['reference']; ?></h4>

            <?php    break;
        case BillTypesEnum::purchase_invoice :

            ?><h4 class="page-title"> <?= __("Purchase invoice"). " " . $bill['Bill']['reference']; ?></h4>

            <?php    break;

        case BillTypesEnum::credit_note :

            ?><h4 class="page-title"> <?= __("Credit note"). " " . $bill['Bill']['reference']; ?></h4>

            <?php    break;

        case BillTypesEnum::delivery_order :

            ?><h4 class="page-title"> <?= __("Delivery order"). " " . $bill['Bill']['reference']; ?></h4>

            <?php    break;

        case BillTypesEnum::return_customer :

            ?><h4 class="page-title"> <?= __("Return customer"). " " . $bill['Bill']['reference']; ?></h4>

            <?php    break;

        case BillTypesEnum::entry_order :

            ?><h4 class="page-title"> <?= __("Entry order"). " " . $bill['Bill']['reference']; ?></h4>

            <?php    break;

        case BillTypesEnum::exit_order :

            ?><h4 class="page-title"> <?= __("Exit order"). " " . $bill['Bill']['reference']; ?></h4>

            <?php    break;

        case BillTypesEnum::renvoi_order :

            ?><h4 class="page-title"> <?= __("Renvoi order"). " " . $bill['Bill']['reference']; ?></h4>

            <?php    break;

        case BillTypesEnum::reintegration_order :

            ?><h4 class="page-title"> <?= __("Reintegration order"). " " . $bill['Bill']['reference']; ?></h4>

            <?php    break;

        case BillTypesEnum::product_request :

            ?><h4 class="page-title"> <?= __("Product request"). " " . $bill['Bill']['reference']; ?></h4>

            <?php    break;

        case BillTypesEnum::purchase_request :

            ?><h4 class="page-title"> <?= __("Purchase request"). " " . $bill['Bill']['reference']; ?></h4>

            <?php    break;
    }


    ?>

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
        <?= $this->Html->link(
            '<i class="fa fa-edit m-r-5 m-r-5"></i>' . __("Edit"),
            array('action' => 'Edit',$bill['Bill']['type'], $bill['Bill']['id']),
            array('escape' => false, 'class'=>"btn btn-primary btn-bordred waves-effect waves-light m-b-5")
        );
        
        ?>
        <?= $this->Form->postLink(
            '<i class=" fa fa-trash-o m-r-5"></i>' . __("Delete"),
            array('action' => 'Delete',$bill['Bill']['type'], $bill['Bill']['id']),
            array('escape' => false, 'class'=>"btn btn-inverse btn-bordred waves-effect waves-light m-b-5"),
            __('Are you sure you want to delete this bill?')); ?>

        <div style="clear: both"></div>
    </div>
                        </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                        </div>
                        </div>
                        </div>
                        </div>
    <div  class="left_side card-box p-b-0">
        <div class="nav-tabs-custom pdg_btm">
        <dl >
            <?php
            if(!empty($bill['Bill']['reference'])){
                echo "<dt>". __('Reference')."</dt><dd>".$bill['Bill']['reference'] . "&nbsp;</dd><br/>";
            }
           
              ?>
     <?php if (isset($bill['Bill']['date']) && !empty($bill['Bill']['date'])) { ?>
                            
                            <dt><?php echo __('Date'); ?></dt>
                            <dd>
                                <?php echo h(($this->Time->format($bill['Bill']['date'], '%d-%m-%Y'))); ?>
                                &nbsp;
                            </dd>
                            <br/>
                        <?php } ?>

<table class="table table-striped table-bordered dt-responsive nowrap"                            cellspacing="0" width="100%">

        <thead>
        <tr>
            

            <th><?php echo __('Product'); ?></th>
            <th><?php echo __('Quantity'); ?></th>
            <th><?php echo __('Price HT'); ?></th>
            <th><?php echo __('Price TTC'); ?></th>
        
            
         
        </tr>
        </thead>

        <tbody>

        <?php if(!empty($billProducts)){ ?>

        <?php foreach ($billProducts as $billProduct) { ?>
        <tr>
        <td><?php echo h($billProduct['Product']['name']); ?>&nbsp;</td>
        <td><?php echo h($billProduct['BillProduct']['quantity']); ?>&nbsp;</td>
        
        <td><?php echo h(number_format($billProduct['BillProduct']['price_ht'], 2, ",", "."))."  ".$this->Session->read("currency"); ?></td>
        <td><?php echo h(number_format($billProduct['BillProduct']['price_ttc'], 2, ",", "."))."  ".$this->Session->read("currency"); ?></td>
        

        </tr>
         <?php   } 

         }
            ?>


        </tbody>
</table>


            <dt><?php echo __('Total HT'); ?></dt>
		<dd>
			<?php echo h(number_format($bill['Bill']['total_ht'], 2, ",", "."))."  ".$this->Session->read("currency"); ?>
			&nbsp;
		</dd>

            <br/>
             <dt><?php echo __('Total TTC'); ?></dt>
		<dd>
			<?php echo h(number_format($bill['Bill']['total_ttc'], 2, ",", "."))."  ".$this->Session->read("currency"); ?>
			&nbsp;
		</dd>

            <br/>
             <dt><?php echo __('Total TVA'); ?></dt>
		<dd>
			<?php echo h(number_format($bill['Bill']['total_tva'], 2, ",", "."))."  ".$this->Session->read("currency"); ?>
			&nbsp;
		</dd>

            <br/>

            <dt><?php echo __('Creator'); ?></dt>
            <dd>
                <?php echo h($bill['User']['first_name'] . ' ' . $bill['User']['last_name']); ?>
                &nbsp;
            </dd>
            <br/>
            <dt class="width_100"><?php echo __('Created'); ?></dt>
            <dd>
                <?php echo  h($this->Time->format($bill['Bill']['created'], '%d-%m-%Y'));?>
                &nbsp;
            </dd>
            <br/>
            <dt><?php echo __('Modifier'); ?></dt>
            <dd>
                <?php echo h($bill['Modifier']['first_name'] . ' ' . $bill['Modifier']['last_name']); ?>
                &nbsp;
            </dd>
            <br/>
            <dt class="width_100"><?php echo __('Modified'); ?></dt>
            <dd>
                <?php echo  h($this->Time->format($bill['Bill']['modified'], '%d-%m-%Y'));?>
                &nbsp;
            </dd>
            <br/>



           
           
           
        </dl>
    </div>
    </div>

</div>