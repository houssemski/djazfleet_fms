<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
       width="100%">

    <tbody>
    <?php /** @var array $users */
    foreach ($users as $user): ?>
        <tr id="row<?= $user['User']['id'] ?>">
            <td>

                <input id="idCheck" type="checkbox" class='id' value=<?php echo $user['User']['id'] ?>>
            </td>
            <?php if ($user['User']['role_id'] == 3) { ?>
                <td><i class="fa fa-user-circle-o" style="color:red; padding-right: 10px;"
                       aria-hidden="true"></i><?php echo h($user['User']['first_name']); ?>&nbsp;
                </td>
            <?php } else { ?>
                <td><i style="padding-right: 10px;"
                       aria-hidden="true"></i><?php echo h($user['User']['first_name']); ?>&nbsp;
                </td>

            <?php } ?>
            <td><?php echo h($user['User']['last_name']); ?>&nbsp;</td>
            <td><?php echo h($user['User']['email']); ?>&nbsp;</td>
            <td><?php echo h($user['User']['username']); ?>&nbsp;
                <?php

                $datetime1 = $user['User']['time_actif'];
                $datetime2 = date('Y-m-d H:i');
                $datetime1 = new DateTime ($datetime1);
                $datetime2 = new DateTime ($datetime2);
                $interval = date_diff($datetime1, $datetime2);
                $total = $interval->y * 526600 + $interval->m * 43800 + $interval->d * 1440 + $interval->h * 60 + $interval->i;
                if ($total < 5) {
                    echo '<span class="circle label-success">';

                }

                ?>
            </td>

            <td><?php echo h($user['Profile']['name']); ?>&nbsp;</td>
            <td><?php echo h($user['Parc']['name']); ?>&nbsp;</td>

            <td><?php echo h($this->Time->format($user['User']['last_visit_date'], '%d-%m-%Y %H:%M')); ?>&nbsp;</td>
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
                                array('action' => 'View', $user['User']['id']),
                                array('escape' => false, 'class' => 'btn btn-success')
                            ); ?>
                        </li>

                        <li>
                            <?= $this->Html->link(
                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                array('action' => 'Edit', $user['User']['id']),
                                array('escape' => false, 'class' => 'btn btn-primary')
                            ); ?>
                        </li>

                        <li>
                            <?php
                            echo $this->Form->postLink(
                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                array('action' => 'Delete', $user['User']['id']),
                                array('escape' => false, 'class' => 'btn btn-danger'),
                                __('Are you sure you want to delete %s?', $user['User']['first_name'] . " " . $user['User']['last_name'])); ?>
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
    if ($this->params['paging']['User']['pageCount'] > 1) {
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