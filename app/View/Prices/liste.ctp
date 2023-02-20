<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
       width="100%">

    <tbody>
    <?php foreach ($prices as $price): ?>
        <tr id="row<?= $price['Price']['id'] ?>"

            >
            <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'>

                <input id="idCheck" type="checkbox" class='id' value=<?php echo $price['Price']['id'] ?>>
            </td>
            <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo h($price['Price']['wording']); ?>
                &nbsp;</td>
            <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo h($price['DepartureDestination']['name'] . '-' . $price['ArrivalDestination']['name']); ?>
                &nbsp;</td>
            <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo($price['CarType']['name']); ?></td>
            <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo h($price['SupplierCategory']['name']); ?>
                &nbsp;</td>
            <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo h($price['Supplier']['name']); ?>
                &nbsp;</td>
            <?php if ($useRideCategory == 2) { ?>
                <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo h($price['RideCategory']['name']); ?>
                    &nbsp;</td>
            <?php } ?>
            <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo number_format($price['PriceRideCategory']['price_ht'], 2, ",", $separatorAmount) . ' ' . $this->Session->read("currency"); ?>
                &nbsp;</td>
            <?php if($paramPriceNight == 1){ ?>
            <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo number_format($price['PriceRideCategory']['price_ht_night'], 2, ",", $separatorAmount) . ' ' . $this->Session->read("currency"); ?>
                &nbsp;</td>
            <?php } ?>
            <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo number_format($price['PriceRideCategory']['price_return'], 2, ",", $separatorAmount) . ' ' . $this->Session->read("currency"); ?>
                &nbsp;</td>
            <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo h($this->Time->format($price['PriceRideCategory']['start_date'], '%d-%m-%Y')); ?>
                &nbsp;</td>
            <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo h($this->Time->format($price['PriceRideCategory']['end_date'], '%d-%m-%Y')); ?>
                &nbsp;</td>
            <td class="actions">
                <div class="btn-group ">
                    <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                        <i class="fa fa-list fa-inverse"></i>
                    </a>
                    <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                        <span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu" style="min-width: 70px;">

                        <li>
                            <?= $this->Html->link(
                                '<i   class="fa fa-eye" title="' . __('View') . '"></i>',
                                array('action' => 'View', $price['Price']['id']),
                                array('escape' => false, 'class' => 'btn btn-success')
                            ); ?>
                        </li>

                        <li>
                            <?= $this->Html->link(
                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                array('action' => 'Edit', $price['Price']['id']),
                                array('escape' => false, 'class' => 'btn btn-primary')
                            ); ?>
                        </li>

                        <li>
                            <?php
                            echo $this->Form->postLink(
                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                array('action' => 'delete', $price['Price']['id']),
                                array('escape' => false, 'class' => 'btn btn-danger'),
                                __('Are you sure you want to delete %s?', $price['Price']['wording'])); ?>
                        </li>
                    </ul>
                </div>

            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div id='pageCount' class="hidden">
    <?php
    if ($this->params['paging']['Price']['pageCount'] > 1) {
        ?>
        <p>
            <?php
            echo $this->Paginator->counter(array(
                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
            ));
            ?>    </p>
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin pull-left">
                <?php
                echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                echo $this->Paginator->numbers(array(
                    'tag' => 'li',
                    'first' => false,
                    'last' => false,
                    'separator' => '',
                    'currentTag' => 'a'));
                echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                ?>
            </ul>
        </div>
    <?php } ?>
</div>