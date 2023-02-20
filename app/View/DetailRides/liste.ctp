<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
       width="100%">

    <tbody>
    <?php foreach ($detailRides as $detailRide): ?>
        <tr id="row<?= $detailRide['DetailRide']['id'] ?>">
            <td>

                <input id="idCheck" type="checkbox" class='id' value=<?php echo $detailRide['DetailRide']['id'] ?>>
            </td>
            <td><?php echo h($detailRide['DetailRide']['wording']); ?>&nbsp;</td>
            <td><?php echo h($detailRide['DepartureDestination']['name'] . ' - ' . $detailRide['ArrivalDestination']['name']); ?>
                &nbsp;</td>
            <td><?php echo h($detailRide['CarType']['name']); ?>&nbsp;</td>
            <td><?php echo h($detailRide['DetailRide']['duration_day']) . ' ' . __('Day') . ' ' . h($detailRide['DetailRide']['duration_hour']) . ' ' . __('Hour') . ' ' . h($detailRide['DetailRide']['duration_minute']) . ' ' . __('min'); ?>
                &nbsp;</td>
            <td><?php echo h($detailRide['DetailRide']['real_duration_day']) . ' ' . __('Day') . ' ' . h($detailRide['DetailRide']['real_duration_hour']) . ' ' . __('Hour') . ' ' . h($detailRide['DetailRide']['real_duration_minute']) . ' ' . __('min'); ?>
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
                                array('action' => 'View', $detailRide['DetailRide']['id']),
                                array('escape' => false, 'class' => 'btn btn-success')
                            ); ?>
                        </li>

                        <li>
                            <?= $this->Html->link(
                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                array('action' => 'Edit', $detailRide['DetailRide']['id']),
                                array('escape' => false, 'class' => 'btn btn-primary')
                            ); ?>
                        </li>


                        <li>
                            <?php
                            echo $this->Form->postLink(
                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                array('action' => 'delete', $detailRide['DetailRide']['id']),
                                array('escape' => false, 'class' => 'btn btn-danger'),
                                __('Are you sure you want to delete %s?', $detailRide['DetailRide']['wording'])); ?>
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
    if ($this->params['paging']['DetailRide']['pageCount'] > 1) {
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