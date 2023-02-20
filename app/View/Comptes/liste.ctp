<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
       cellspacing="0" width="100%">
    <thead>
    <tr>
        <th style="width: 10px">
            <button type="button" id='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i
                    class="fa fa-square-o"></i></button>
        </th>
        <th><?php echo $this->Paginator->sort('Num compte'); ?></th>
        <th><?php echo $this->Paginator->sort('Amount'); ?></th>

        <th><?php echo $this->Paginator->sort('created'); ?></th>
        <th><?php echo $this->Paginator->sort('modified'); ?></th>
        <th class="actions"><?php echo __('Actions'); ?></th>
    </tr>
    </thead>
    <tbody id="listeDiv">
    <?php foreach ($comptes as $compte): ?>
        <tr id="row<?= $compte['Compte']['id'] ?>">
            <td>

                <input id="idCheck" type="checkbox" class='id'
                       value=<?php echo $compte['Compte']['id'] ?>>
            </td>
            <td><?php echo h($compte['Compte']['num_compte']); ?>&nbsp;</td>

            <td><?php echo number_format($compte['Compte']['amount'], 2, ",", $separatorAmount) ?>
                &nbsp;</td>
            <td><?php echo h($this->Time->format($compte['Compte']['created'], '%d-%m-%Y %H:%M')); ?>
                &nbsp;
            </td>
            <td><?php echo h($this->Time->format($compte['Compte']['modified'], '%d-%m-%Y %H:%M')); ?>
                &nbsp;
            </td>
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
                                array('action' => 'View', $compte['Compte']['id']),
                                array('escape' => false, 'class' => 'btn btn-success')
                            ); ?>
                        </li>

                        <li>
                            <?= $this->Html->link(
                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                array('action' => 'Edit', $compte['Compte']['id']),
                                array('escape' => false, 'class' => 'btn btn-primary')
                            ); ?>
                        </li>


                        <li>
                            <?php
                            echo $this->Form->postLink(
                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                array('action' => 'delete', $compte['Compte']['id']),
                                array('escape' => false, 'class' => 'btn btn-danger'),
                                __('Are you sure you want to delete %s?', $compte['Compte']['num_compte'])); ?>
                        </li>


                    </ul>
                </div>

            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div id ='pageCount' class="hidden">
<?php if ($this->params['paging']['Compte']['pageCount'] > 1) { ?>
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