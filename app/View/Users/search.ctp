<?php

?>
<h4 class="page-title"> <?= __('Search'); ?></h4>
<div class="box-body">

    <div class="panel-group wrap" id="bs-collapse">
        <div class="panel loop-panel">
            <a class="collapsed fltr" data-toggle="collapse" data-parent="#" href="#one">
                <i class="zmdi zmdi-search-in-page"></i>
            </a>

            <div id="one" class="panel-collapse collapse">
                <div class="panel-body">

                    <?php echo $this->Form->create('Users', array(
                        'url' => array(
                            'action' => 'search'
                        ),
                        'novalidate' => true)); ?>

                    <div class="filters" id='filters'>

                        <?php
                        echo $this->Form->input('profile_id', array(
                            'label' => __('Profile'),
                            'class' => 'form-filter select2',
                            'empty' => ''));

                        ?>
                        <button class="btn btn-default" type="submit"><?= __('Search') ?></button>
                        <div style='clear:both; padding-top: 10px;'></div>
                    </div>


                    <?php echo $this->Form->end(); ?>


                </div>

            </div>
        </div>
        <!-- end of panel -->


    </div>
    <!-- end of #bs-collapse  -->


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
                                'javascript:submitDeleteForm("users/deleteusers/");',
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                    'disabled' => 'true'),
                                __('Are you sure you want to delete selected users ?')); ?>


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
                <?php echo $this->Form->create('Users', array(
                    'url' => array(
                        'action' => 'search'
                    ),
                    'novalidate' => true,
                    'id' => 'searchKeyword'
                )); ?>
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
                            <select name="slctlimit" id="slctlimit" onchange="slctlimitChanged('users/index');">
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
                        <th><?php echo $this->Paginator->sort('first_name', __('First_name')); ?></th>
                        <th><?php echo $this->Paginator->sort('last_name', __('Last_name')); ?></th>
                        <th><?php echo $this->Paginator->sort('email', __('Email')); ?></th>
                        <th><?php echo $this->Paginator->sort('username', __('Username')); ?></th>

                        <th><?php echo $this->Paginator->sort('username', __('Profile')); ?></th>

                        <th><?php echo $this->Paginator->sort('username', __('Last visit date')); ?></th>
                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                    </thead>
                    <tbody id="listeDiv">
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


                            <td><?php echo h($this->Time->format($user['User']['last_visit_date'], '%d-%m-%Y %H:%M')); ?>
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
                <div id="pagination" class="pull-right">
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

            </div>
        </div>
    </div>
</div>

<?php $this->start('script'); ?>

<script type="text/javascript">     $(document).ready(function () {
    });


</script>
<?php $this->end(); ?>
