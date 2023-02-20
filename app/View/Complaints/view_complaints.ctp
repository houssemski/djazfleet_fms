
<h4 class="page-title"> <?= __('Complaints'); ?></h4>
<div class="box-body">




    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <?php echo $this->Form->create('Complaints', array(
                    'url' => array(
                        'action' => 'search'
                    ),
                    'novalidate' => true,
                    'id' => 'searchKeyword')); ?>
                <label style="float: right;">
                    <input id='keyword' type="text" name="keyword" id="keyword" class="form-control"
                           placeholder= <?= __("Search"); ?>>
                </label>
                <?php echo $this->Form->end(); ?>
                <div class="bloc-limit btn-group pull-left">
                    <div>
                        <label>
                            <?php
                            if (isset($this->params['pass']['0'])) $limit = $this->params['pass']['0'];
                            ?>
                            <select name="slctlimit" id="slctlimit"
                                    onchange="slctlimitChanged('Complaints/index');">
                                <option value="20" <?php if ($limit == 20) echo 'selected="selected"' ?>>20</option>
                                <option value="25" <?php if ($limit == 25) echo 'selected="selected"' ?>>25</option>
                                <option value="50" <?php if ($limit == 50) echo 'selected="selected"' ?>>50</option>
                                <option value="100" <?php if ($limit == 100) echo 'selected="selected"' ?>>100</option>
                            </select>&nbsp; <?= __('records per page') ?>

                        </label>
                    </div>


                </div>
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                       cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th style="width: 10px">
                            <button type="button" id='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i
                                        class="fa fa-square-o"></i></button>
                        </th>
                        <th><?php echo $this->Paginator->sort('reference', __('Reference')); ?></th>
                        <th><?php echo $this->Paginator->sort('complaint_date', __('Date')); ?></th>
                        <th><?php echo $this->Paginator->sort('type', __('Type')); ?></th>
                        <th><?php echo $this->Paginator->sort('sheet_ride_detail_ride_id', __('Mission')); ?></th>
                        <th><?php echo $this->Paginator->sort('transport_bill_detail_ride_id', __('Order')); ?></th>
                        <th><?php echo $this->Paginator->sort('complaint_cause_id', __('Complaint cause')); ?></th>
                        <th><?php echo $this->Paginator->sort('user_id', __('User')); ?></th>
                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                    </thead>

                    <tbody id="listeDiv">
                    <?php foreach ($complaints as $complaint):

                        ?>
                        <tr id="row<?= $complaint['Complaint']['id'] ?>">
                            <td>

                                <input id="idCheck" type="checkbox" class='id'
                                       value=<?php echo $complaint['Complaint']['id'] ?>>
                            </td>
                            <td><?php echo h($complaint['Complaint']['reference']); ?>&nbsp;</td>
                            <td><?php echo h($this->Time->format($complaint['Complaint']['complaint_date'], '%d-%m-%Y')); ?></td>
                            <td><?php
                                switch ($complaint['Complaint']['type']){
                                    case 1:
                                        echo __('Appel');
                                        break;
                                    case 2:
                                        echo __('Email');
                                        break;
                                    case 3:
                                        echo __('Sms');
                                        break;
                                    case 4:
                                        echo __('Direct ou oral');
                                        break;
                                    case 5:
                                        echo __('Courier');
                                        break;
                                    case 6:
                                        echo __('Autres');
                                        break;
                                } ?>&nbsp;</td>
                            <td><?php echo $complaint['SheetRideDetailRides']['reference'] ;?> </td>
                            <td><?php echo $complaint['TransportBillDetailRides']['reference'] ;?> </td>


                            <td><?php echo $complaint['ComplaintCause']['name'] ;?> </td>
                            <td><?php echo $complaint['User']['first_name'].' - '.  $complaint['User']['last_name'];?> </td>


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
                                                array('controller'=>'complaints','action' => 'View', $complaint['Complaint']['id']),
                                                array('escape' => false, 'class' => 'btn btn-success')
                                            ); ?>
                                        </li>

                                        <li>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                array('controller'=>'complaints','action' => 'Edit', $complaint['Complaint']['id']),
                                                array('escape' => false, 'class' => 'btn btn-primary')
                                            ); ?>
                                        </li>


                                        <li>
                                            <?php
                                            echo $this->Form->postLink(
                                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                                array('controller'=>'complaints','action' => 'delete', $complaint['Complaint']['id']),
                                                array('escape' => false, 'class' => 'btn btn-danger'),
                                                __('Are you sure you want to delete %s?', $complaint['Complaint']['reference'])); ?>
                                        </li>
                                    </ul>
                                </div>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>

                </table>


                <div id="pagination" class="pull-right">
                    <?php if ($this->params['paging']['Complaint']['pageCount'] > 1) { ?>
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

<?= $this->Form->input('controller', array(
    'id' => 'controller',
    'value' => $this->request->params['controller'],
    'type' => 'hidden'
)); ?>

<?= $this->Form->input('action', array(
    'id' => 'action',
    'value' => 'liste',
    'type' => 'hidden'
)); ?>



<?php $this->start('script'); ?>

<script type="text/javascript">     $(document).ready(function () {
    });


</script>
<?php $this->end(); ?>
