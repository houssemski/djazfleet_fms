<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
       cellspacing="0" width="100%">
    <thead>
    <tr>
        <th style="width: 10px">
            <button type="button" id='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i
                    class="fa fa-square-o"></i></button>
        </th>

        <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
        <th><?php echo $this->Paginator->sort('Department.name', __('Department')); ?></th>
        <th><?php echo $this->Paginator->sort('created', __('Created')); ?></th>
        <th><?php echo $this->Paginator->sort('modified', __('Modified')); ?></th>
        <th class="actions"><?php echo __('Actions'); ?></th>
    </tr>
    </thead>
    <tbody id="listeDiv">
    <?php foreach ($services as $service): ?>
        <tr id="row<?= $service['Service']['id'] ?>">
            <td>

                <input id="idCheck" type="checkbox" class='id' value=<?php echo $service['Service']['id'] ?>>
            </td>

            <td><?php echo h($service['Service']['name']); ?>&nbsp;</td>
            <td><?php echo h($service['Department']['name']); ?>&nbsp;</td>
            <td><?php echo h($this->Time->format($service['Service']['created'], '%d-%m-%Y %H:%M')); ?>&nbsp;</td>
            <td><?php echo h($this->Time->format($service['Service']['modified'], '%d-%m-%Y %H:%M')); ?>&nbsp;</td>
            <td class="actions">
                <?= $this->Html->link(
                    '<i class="fa fa-eye m-r-5"></i>',
                    array('action' => 'View', $service['Service']['id']),
                    array('escape' => false)
                ); ?>
                <?= $this->Html->link(
                    '<i class="fa fa-edit m-r-5"></i>',
                    array('action' => 'Edit', $service['Service']['id']),
                    array('escape' => false)
                ); ?>
                <?php echo $this->Form->postLink(
                    '<i class="fa fa-trash-o m-r-5"></i>',
                    array('action' => 'Delete', $service['Service']['id']),
                    array('escape' => false),
                    __('Are you sure you want to delete %s?', $service['Service']['name'])); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<div id='pageCount' class="hidden">
    <?php
    if ($this->params['paging']['Service']['pageCount'] > 1) {
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