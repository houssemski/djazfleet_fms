<h4 class="page-title"> <?= __('Groups'); ?></h4>
<div class="box-body">
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
                            <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                array('action' => 'Add'),
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                            <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                'javascript:submitDeleteForm("groups/deletegroups/");',
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                    'disabled' => 'true'),
                                __('Are you sure you want to delete selected group ?')); ?>


                        </div>
                    </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->Form->input('controller', [
        'id' => 'controller',
        'value' => $this->request->params['controller'],
        'type' => 'hidden'
    ]); ?>

    <?= $this->Form->input('action', [
        'id' => 'action',
        'value' => 'liste',
        'type' => 'hidden'
    ]); ?>

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                       cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th style="width: 10px">
                            <button type="button" id='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i
                                    class="fa fa-square-o"></i></button>
                        </th>
                        <th><?php echo $this->Paginator->sort('code', __('Code')); ?></th>
                        <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
                        <th><?php echo $this->Paginator->sort('created', __('Created')); ?></th>
                        <th><?php echo $this->Paginator->sort('modified', __('Modified')); ?></th>
                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                    </thead>
                    <tbody id="listeDiv">
                    <?php foreach ($customerGroups as $group): ?>
                        <tr id="row<?= $group['CustomerGroup']['id'] ?>">
                            <td>

                                <input id="idCheck" type="checkbox" class='id'
                                       value=<?php echo $group['CustomerGroup']['id'] ?>>
                            </td>
                            <td><?php echo h($group['CustomerGroup']['code']); ?>&nbsp;</td>
                            <td><?php echo h($group['CustomerGroup']['name']); ?>&nbsp;</td>
                            <td><?php echo h($this->Time->format($group['CustomerGroup']['created'], '%d-%m-%Y %H:%M')); ?>
                                &nbsp;</td>
                            <td><?php echo h($this->Time->format($group['CustomerGroup']['modified'], '%d-%m-%Y %H:%M')); ?>
                                &nbsp;</td>
                            <td class="actions">
                                <?= $this->Html->link(
                                    '<i class="fa fa-eye m-r-5"></i>',
                                    array('action' => 'View', $group['CustomerGroup']['id']),
                                    array('escape' => false)
                                ); ?>
                                <?= $this->Html->link(
                                    '<i class="fa fa-edit m-r-5"></i>',
                                    array('action' => 'Edit', $group['CustomerGroup']['id']),
                                    array('escape' => false)
                                ); ?>
                                <?php echo $this->Form->postLink(
                                    '<i class="fa fa-trash-o m-r-5"></i>',
                                    array('action' => 'Delete', $group['CustomerGroup']['id']),
                                    array('escape' => false),
                                    __('Are you sure you want to delete %s?', $group['CustomerGroup']['name'])); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="pagination" class="pull-right">
                    <?php if ($this->params['paging']['CustomerGroup']['pageCount'] > 1) { ?>
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

            </div>
        </div>
    </div>
</div>



<?php $this->start('script'); ?>

<script type="text/javascript">     $(document).ready(function () {
    });


</script>
<?php $this->end(); ?>
