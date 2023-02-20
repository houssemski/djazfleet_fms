<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
           cellspacing="0" width="100%">
        
        
                        <tbody >
                        <?php foreach ($bills as $bill): ?>
                            <tr id="row<?= $bill['Bill']['id'] ?>">
                                <td>

                                    <input id="idCheck" type="checkbox" class='id'
                                           value=<?php echo $bill['Bill']['id'] ?>>
                                </td>

                                <td><?php echo h($bill['Bill']['reference']); ?>&nbsp;</td>
                                <td><?php echo h($this->Time->format($bill['Bill']['date'], '%d-%m-%Y')); ?>&nbsp;</td>
                                <td><?php

                                    switch ($bill['Bill']['type']) {
                                        case BillTypesEnum::supplier_order :

                                            echo __('Supplier orders');
                                            break;
                                        case BillTypesEnum::receipt :

                                            echo __("Receipts");

                                            break;

                                        case BillTypesEnum::return_supplier :

                                            echo __("Return supplier");
                                            break;
                                        case BillTypesEnum::purchase_invoice :

                                            echo __("Purchase invoice");
                                            break;

                                        case BillTypesEnum::credit_note :

                                            echo __("Credit note");
                                            break;

                                        case BillTypesEnum::delivery_order :

                                            echo __("Delivery orders");
                                            break;

                                        case BillTypesEnum::return_customer :

                                            echo __("Return customer");

                                            break;

                                        case BillTypesEnum::entry_order :

                                            echo __("Entry order");

                                            break;

                                        case BillTypesEnum::exit_order :

                                            echo __("Exit order");

                                            break;

                                        case BillTypesEnum::renvoi_order :

                                            echo __("Renvoi order");

                                            break;

                                        case BillTypesEnum::reintegration_order :

                                            echo __("Reintegration order");
                                            break;
											
										case BillTypesEnum::quote :

                                            echo __("Quotation");
                                            break;
											
										case BillTypesEnum::customer_order :

                                            echo __("Customer order");
                                            break;
											
										case BillTypesEnum::sales_invoice :

                                            echo __("Invoice");
                                            break;
											
										case BillTypesEnum::sale_credit_note :

                                            echo __("Sale credit note");
                                            break;
                                        default :
                                            echo __("Journal");

                                            break;
                                    }





                                    ?>&nbsp;</td>
                                <?php if (!empty($bill['Bill']['supplier_id'])) { ?>
                                    <td><?php echo h($bill['Supplier']['name']); ?>&nbsp;</td>
                                <?php } else { ?>

                                    <td> <?php if ($carNameStructure == 1) {
                                            echo $bill['EventType']['name'] . " - " . $bill['Car']['code'] . " - " . $bill['Carmodel']['name'];
                                        } else if ($carNameStructure == 2) {
                                            echo $bill['EventType']['name'] . " - " . $bill['Car']['immatr_def'] . " - " . $bill['Carmodel']['name'];
                                        } ?>
                                    </td>
                                <?php } ?>
                                <td><?php echo number_format($bill['Bill']['total_ht']+$bill['Bill']['ristourne_val'], 2, ",", $separatorAmount) ; ?>
                                    &nbsp;</td>
                                <td><?php echo number_format($bill['Bill']['ristourne_val'], 2, ",", $separatorAmount) ; ?>
                                    &nbsp;</td>
                                <td><?php echo number_format($bill['Bill']['total_tva'], 2, ",", $separatorAmount) ; ?>
                                    &nbsp;</td>
                                <td><?php echo number_format($bill['Bill']['total_ttc'], 2, ",", $separatorAmount) ; ?>
                                    &nbsp;</td>

                                <td><?php echo number_format($bill['Bill']['amount_remaining'], 2, ",", $separatorAmount) ; ?>
                                    &nbsp;</td>


                                <td class="actions">
                                    <div class="btn-group ">
                                        <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                                            <i class="fa fa-list fa-inverse"></i>
                                        </a>
                                        <button href="#" data-toggle="dropdown"
                                                class="btn btn-info dropdown-toggle share">
                                            <span class="caret"></span>
                                        </button>

                                        <ul class="dropdown-menu" style="min-width: 70px;">

                                            <li>
                                                <?= $this->Html->link(
                                                    '<i   class="fa fa-eye" title="' . __('View') . '"></i>',
                                                    array('action' => 'View', $bill['Bill']['type'], $bill['Bill']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-success')
                                                ); ?>
                                            </li>


                                            <li>
                                                <?php  echo $this->Html->link(
                                                    '<i class="fa fa-edit m-r-5 "></i>',
                                                    array('action' => 'Edit', $bill['Bill']['type'], $bill['Bill']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-primary')); ?>
                                            </li>
                                            <li class='edit-link' title="<?= __('Print simplified bill') ?>">
                                                <?= $this->Html->link(
                                                    '<i class=" fa fa-print"></i>',
                                                    array('action' => 'view_bill', 'ext' => 'pdf', $bill['Bill']['id']),
                                                    array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                                ); ?>
                                            </li>  
											
											<li class='edit-link' title="<?= __('Print detailed bill') ?>">
                                                <?= $this->Html->link(
                                                    '<i class=" fa fa-print"></i>',
                                                    array('action' => 'printDetailedBill', 'ext' => 'pdf', $bill['Bill']['id']),
                                                    array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                                ); ?>
                                            </li>
                                            <li class='edit-link' title="<?= __('Print bill with regulation details') ?>">
                                                <?= $this->Html->link(
                                                    '<i class=" fa fa-print"></i>',
                                                    array('action' => 'printBillWithRegulationDetails', 'ext' => 'pdf', $bill['Bill']['id']),
                                                    array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                                ); ?>
                                            </li>

                                            <li>
                                                <?php
                                                echo $this->Form->postLink(
                                                    '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                                    array('action' => 'delete', $bill['Bill']['type'], $bill['Bill']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-danger'),
                                                    __('Are you sure you want to delete %s?', $bill['Bill']['reference'])); ?>
                                            </li>
                                        </ul>
                                    </div>


                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    
					
	
	
	</table>
<div id ='pageCount' class="hidden">
                    <?php
if($this->params['paging']['Bill']['pageCount'] > 1){
    ?>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?>	</p>
    <div class="box-footer clearfix">
        <ul class="pagination pagination-sm no-margin pull-left">
            <?php
            echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
            echo $this->Paginator->numbers(array(
                'tag' => 'li',
                'first' => false,
                'last' => false,
                'separator' => '',
                'currentTag' => 'a'));
            echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
            ?>
        </ul>
    </div>
<?php } ?>
    </div>