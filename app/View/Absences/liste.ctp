<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
       cellspacing="0" width="100%">
    <thead>
    <tr>
        <th style="width: 10px">
            <button type="button" id='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i
                    class="fa fa-square-o"></i></button>
        </th>
        <th><?php echo $this->Paginator->sort('visit_number', __('Visit number')); ?></th>
        <th><?php echo $this->Paginator->sort('customer_id', __('Customer')); ?></th>
        <th><?php echo $this->Paginator->sort('internal_external', __('Type')); ?></th>
        <th><?php echo $this->Paginator->sort('consulting_doctor', __('Consulting doctor')); ?></th>
        <th class="actions"><?php echo __('Actions'); ?></th>
    </tr>
    </thead>
    <tbody >
                    <?php foreach ($absences as $absence): ?>
                        <tr id="row<?= $absence['Absence']['id'] ?>">
                            <td>

                                <input id="idCheck" type="checkbox" class='id'
                                       value=<?php echo $absence['Absence']['id'] ?>>
                            </td>
                            <td><?php echo h($absence['Absence']['code']); ?>&nbsp;</td>
                            <td><?php echo h($absence['Customer']['first_name'].'-'.$absence['Customer']['last_name']); ?>&nbsp;</td>
                            <td><?php echo h($absence['AbsenceReason']['name']); ?>&nbsp;</td>
                            <td><?php echo h($this->Time->format($absence['Absence']['start_date'], '%d-%m-%Y')); ?>&nbsp;</td>
                            <td><?php echo h($this->Time->format($absence['Absence']['end_date'], '%d-%m-%Y')); ?>&nbsp;</td>

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
                                                '<i class="fa fa-eye " title="' . __('View') . '"></i>',
                                                array('action' => 'view', $absence['Absence']['id']),
                                                array('escape' => false, 'class' => 'btn btn-success')
                                            ); ?>
                                        </li>

                                        <li>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                array('action' => 'Edit', $absence['Absence']['id']),
                                                array('escape' => false, 'class' => 'btn btn-primary')
                                            ); ?>
                                        </li>


                                        <li>
                                            <?php
                                            echo $this->Form->postLink(
                                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                                array('action' => 'delete', $absence['Absence']['id']),
                                                array('escape' => false, 'class' => 'btn btn-danger'),
                                                __('Are you sure you want to delete %s?', $absence['Absence']['code'])); ?>
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
    if ($this->params['paging']['MedicalVisit']['pageCount'] > 1) {
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