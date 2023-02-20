<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
       width="100%">

    <tbody >
    <?php foreach ($products as $product):

        ?>

        <tr id="row<?= $product['Product']['id'] ?>">
            <td>

                <input id="idCheck" type="checkbox" class='id'
                       value=<?php echo $product['Product']['id'] ?>>
            </td>

            <td><?php echo h($product['Product']['code']); ?>&nbsp;</td>
            <td><?php echo h($product['Product']['name']); ?>&nbsp;</td>
            <td><?php echo h($product['ProductFamily']['name']); ?>&nbsp;</td>
            <td><?php echo h($product['Tva']['name']); ?>&nbsp;</td>
            <td><?php echo h($product['Product']['quantity']); ?>&nbsp;</td>
            <td><?php echo h($product['Product']['quantity_min']); ?>&nbsp;</td>
            <td><?php echo h($product['Product']['quantity_max']); ?>&nbsp;</td>
            <td><?php echo h($product['Product']['pmp']); ?>&nbsp;</td>

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
                                array('action' => 'View', $product['Product']['id']),
                                array('escape' => false, 'class' => 'btn btn-success')
                            ); ?>
                        </li>

                        <li>
                            <?= $this->Html->link(
                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                array('action' => 'Edit', $product['Product']['id']),
                                array('escape' => false, 'class' => 'btn btn-primary')
                            ); ?>
                        </li>
                        <li class='edit-link' title="<?= __('Product card') ?>">
                            <?php  echo $this->Html->link(
                                '<i class=" fa fa-print m-r-5"></i>',
                                array('action' => 'productCard', $product['Product']['id']),
                                array('escape' => false, 'class' => 'btn btn-inverse')); ?>
                        </li>

                        <li>
                            <?php
                            echo $this->Form->postLink(
                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                array('action' => 'delete', $product['Product']['id']),
                                array('escape' => false, 'class' => 'btn btn-danger'),
                                __('Are you sure you want to delete %s?', $product['Product']['name'])); ?>
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
    if ($this->params['paging']['Product']['pageCount'] > 1) {
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