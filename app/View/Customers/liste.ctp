<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
       cellspacing="0" width="100%">

    <tbody >
    <?php foreach ($customers as $customer): ?>
        <tr class="alert <?= ($customer['Customer']['alert'] == 1) ? "alert-danger" : "" ?>"
            id="row<?= $customer['Customer']['id'] ?>">
            <td>

                <input id="idCheck" type="checkbox" class='id'
                       value=<?php echo $customer['Customer']['id'] ?>>
            </td>
            <td><?php echo h($customer['Customer']['code']); ?>&nbsp;</td>
            <td><?php echo h($customer['CustomerCategory']['name']); ?>&nbsp;</td>
            <td><?php echo h($customer['Customer']['first_name']); ?>&nbsp;</td>
            <td><?php echo h($customer['Customer']['last_name']); ?>&nbsp;</td>
            <td><?php echo h($customer['Customer']['company']); ?>&nbsp;</td>
            <td><?php echo h($customer['CustomerGroup']['name']); ?>&nbsp;</td>
            <td><?php echo h($customer['Customer']['tel']); ?>&nbsp;</td>
            <td><?php echo h($customer['Customer']['mobile']); ?>&nbsp;</td>
            <td><?php echo h($customer['Customer']['email1']); ?>&nbsp;</td>
            <td class="actions">
                <div class="btn-group ">
                    <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                        <i class="fa fa-list fa-inverse"></i>
                    </a>
                    <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                        <span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu" style="min-width: 70px;">

                        <li class='view-link' title='<?= __('View') ?>'>
                            <?= $this->Html->link(
                                '<i   class="fa fa-eye"></i>',
                                array('action' => 'View', $customer['Customer']['id']),
                                array('escape' => false, 'class' => 'btn btn-success')
                            ); ?>
                        </li>

                        <li class='edit-link' title='<?= __('Edit') ?>'>
                            <?= $this->Html->link(
                                '<i class="fa fa-edit"></i>',
                                array('action' => 'Edit', $customer['Customer']['id']),
                                array('escape' => false, 'class' => 'btn btn-primary')
                            ); ?>
                        </li>

                        <?php if (isset($customer['Customer']['identity_card_scan']) && !empty($customer['Customer']['identity_card_scan']) &&
                            isset($customer['Customer']['driver_license_scan']) && !empty($customer['Customer']['driver_license_scan']) &&
                            isset($customer['Customer']['passport_scan']) && !empty($customer['Customer']['passport_scan']) &&
                            isset($customer['Customer']['image']) && !empty($customer['Customer']['image'])
                        ) {
                            echo '<li class = "attachments-link" title="' . __('Attachments') . '">';
                            echo $this->Html->link(
                                '<i class="fa fa-paperclip"></i>',
                                array('action' => 'View', $customer['Customer']['id']),
                                array('escape' => false, 'class' => 'btn btn-warning')

                            );
                        } else {
                            if (empty($customer['Customer']['identity_card_scan']) && empty($customer['Customer']['driver_license_scan'])
                                && empty($customer['Customer']['passport_scan']) && empty($customer['Customer']['image'])
                            ) {
                                echo '<li class = "missing-attachments-link" title="' . __('Missing attachments') . '">';
                                echo $this->Html->link(
                                    '<i class="fa fa-unlink"></i>',
                                    array('action' => 'Edit', $customer['Customer']['id']),
                                    array('escape' => false, 'class' => 'btn btn-warning')

                                );
                            } elseif (empty($customer['Customer']['identity_card_scan'])) {
                                echo $this->Html->link(
                                    '<i class="fa fa-unlink" title="' . __('Missing attachments identity card ') . '"></i>',

                                    array('action' => 'Edit', $customer['Customer']['id']),
                                    array('escape' => false, 'class' => 'btn btn-warning')

                                );
                            } elseif (empty($customer['Customer']['driver_license_scan'])) {
                                echo $this->Html->link(
                                    '<i class="fa fa-unlink " title="' . __('Missing attachments driver license') . '"></i>',

                                    array('action' => 'Edit', $customer['Customer']['id']),
                                    array('escape' => false, 'class' => 'btn btn-warning')

                                );
                            } elseif (empty($customer['Customer']['passport_scan'])) {
                                echo $this->Html->link(
                                    '<i class="fa fa-unlink " title="' . __('Missing attachments passport') . '"></i>',

                                    array('action' => 'Edit', $customer['Customer']['id']),
                                    array('escape' => false, 'class' => 'btn btn-warning')

                                );
                            } elseif (empty($customer['Customer']['image'])) {
                                echo $this->Html->link(
                                    '<i class="fa fa-unlink " title="' . __('Missing attachments image') . '"></i>',

                                    array('action' => 'Edit', $customer['Customer']['id']),
                                    array('escape' => false, 'class' => 'btn btn-warning')

                                );
                            }


                        } ?>

                        </li>
                        <li>
                            <?php
                            if ($customer['Customer']['locked'] == 1) {
                                echo $this->Html->link(
                                    '<i class="fa  fa-lock " title="' . __('Unlock') . '"></i>',
                                    array('action' => 'unlock', $customer['Customer']['id']),
                                    array('escape' => false, 'class' => 'btn btn-purple')
                                );
                            } else {
                                echo $this->Html->link(
                                    '<i class="fa  fa-unlock " title="' . __('Lock') . '"></i>',
                                    array('action' => 'lock', $customer['Customer']['id']),
                                    array('escape' => false, 'class' => 'btn btn-purple')
                                );
                            }?>
                        </li>
                        <li>
                            <?php
                            echo $this->Form->postLink(
                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                array('action' => 'delete', $customer['Customer']['id']),
                                array('escape' => false, 'class' => 'btn btn-danger'),
                                __('Are you sure you want to delete %s?', $customer['Customer']['first_name'] . " " . $customer['Customer']['last_name'])); ?>
                        </li>


                    </ul>
                </div>


            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>

<div id ='pageCount' class="hidden">
<?php if ($this->params['paging']['Customer']['pageCount'] > 1) {
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