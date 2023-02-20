<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
       width="100%">

    <tbody>
    <?php foreach ($zones as $zone): ?>
        <tr id="row<?= $zone['Zone']['id'] ?>">
            <td>

                <input id="idCheck" type="checkbox" class='id' value=<?php echo $zone['Zone']['id'] ?>>
            </td>
            <td><?php echo h($zone['Zone']['code']); ?>&nbsp;</td>
            <td><?php echo h($zone['Zone']['name']); ?>&nbsp;</td>
            <td><?php echo h($zone['Zone']['cost']); ?>&nbsp;</td>
            <td><?php
                if (!empty($zone['Zone']['rotation_number']) && !empty($zone['Zone']['rotation_number_type'])) {
                    if ($zone['Zone']['rotation_number_type'] == 1) $freq = __('per') . " " . __('day');
                    else $freq = __('per') . " " . __('week');
                    echo h($zone['Zone']['name']) . " " . $freq;
                }

                ?>&nbsp;</td>
            <td><?php echo h($this->Time->format($zone['Zone']['created'], '%d-%m-%Y %H:%M')); ?>&nbsp;</td>
            <td><?php echo h($this->Time->format($zone['Zone']['modified'], '%d-%m-%Y %H:%M')); ?>&nbsp;</td>
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
                                array('action' => 'View', $zone['Zone']['id']),
                                array('escape' => false, 'class' => 'btn btn-success')
                            ); ?>
                        </li>

                        <li>
                            <?= $this->Html->link(
                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                array('action' => 'Edit', $zone['Zone']['id']),
                                array('escape' => false, 'class' => 'btn btn-primary')
                            ); ?>
                        </li>

                        <li>
                            <?php
                            echo $this->Form->postLink(
                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                array('action' => 'Delete', $zone['Zone']['id']),
                                array('escape' => false, 'class' => 'btn btn-danger'),
                                __('Are you sure you want to delete %s?', $zone['Zone']['name'])); ?>
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
    if ($this->params['paging']['Zone']['pageCount'] > 1) {
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