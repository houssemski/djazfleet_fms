<h4 class="page-title"> <?=__('Search'); ?></h4>


<div class="box-body">
    <div class="panel-group wrap" id="bs-collapse">
        <div class="panel loop-panel">
            <a class="collapsed fltr" data-toggle="collapse" data-parent="#" href="#one">
                <i class="zmdi zmdi-search-in-page"></i>
            </a>
            <a class="collapsed grp_actions_icon fltr" data-toggle="collapse" data-parent="#" href="#grp_actions">
                <i class="fa fa-toggle-down"></i>
            </a>

            <div id="one" class="panel-collapse collapse">
                <div class="panel-body">

                    <?php echo $this->Form->create('Destinations', array(
                        'url' => array(
                            'action' => 'search'
                        ),
                        'novalidate' => true
                    )); ?>

                    <div class="filters" id='filters'>
                        <?php
                        echo $this->Form->input('date', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Modified') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'startdate',
                        ));
                        echo $this->Form->input('next_date', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('To') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'enddate',
                        ));
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
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions actn">
                            <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                array('action' => 'Add'),
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                            <div class="btn-group ">
                                <button type="button"
                                        class='btn btn-inverse btn-bordred waves-effect w-md waves-light m-b-5'
                                        data-toggle="dropdown">
                                    <i class="glyphicon glyphicon-download-alt m-r-5"></i>
                                    <?= __('Import'); ?>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu imp" role="menu">
                                    <li>
                                        <div class="timeline-body">
                                            <?php echo $this->Html->link(__('Download file model'), '/attachments/import_xls/villes.csv', array('class' => 'titre')); ?>
                                            <br/>

                                            <form id='DestinationImportForm' action='destinations/import' method='post'
                                                  enctype='multipart/form-data' novalidate='novalidate'>
                                                <?php echo "<div class='form-group'>" . $this->Form->input('Destination.file_csv', array(
                                                        'label' => __('File .csv'),
                                                        'class' => '',
                                                        'type' => 'file',
                                                        //'id' =>'file_cars',
                                                        'placeholder' => __('Choose file .csv'),
                                                        'empty' => ''
                                                    )) . "</div>"; ?>
                                                <div class='timeline-footer'>
                                                    <?php echo $this->Form->submit(__('Import'), array(
                                                        'name' => 'ok',
                                                        'class' => 'btn btn-inverse btn-xs',
                                                        'label' => __('Import'),
                                                        'type' => 'submit',
                                                        'div' => false
                                                    )) ?>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                'javascript:submitDeleteForm("destinations/deleteDestinations/");',
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                    'disabled' => 'true'),
                                __('Are you sure you want to delete selected destination ?')); ?>


                        </div>
                    </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                </div>
            </div>
        </div>
    </div>
    
    <?= $this->Form->input('controller', array(
        'id'=>'controller',
        'value'=>   $this->request->params['controller'],
        'type'=>'hidden'
    )); ?>

    <?= $this->Form->input('action', array(
        'id'=>'action',
        'value'=>   'liste',
        'type'=>'hidden'
    )); ?>
    
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-10">
                <?php echo $this->Form->create('Destinations', array(
                    'url'=> array(
                        'action' => 'search'
                    ),
                    'novalidate' => true,
                    'id'=>'searchKeyword'
                )); ?>
                <label style="float: right;">
                    <input id='keyword' type="text" name="keyword" id="keyword" class="form-control"
                           placeholder= <?= __("Search"); ?>>

                </label>
                <?php echo $this->Form->end(); ?>

                <div class="col-sm-6">
                    <div class="dataTables_length m-r-15" id="datatable-editable_length" style="display: inline-block;">
                        <label>&nbsp; <?= __('Order : ') ?>
                            <?php
                            if (isset($this->params['pass']['1'])) $order = $this->params['pass']['1'];
                            ?>
                            <select aria-controls="datatable-editable" class="form-control input-sm" name="selectOrder"
                                    id="selectOrder" onchange="selectOrderChanged('destinations/index','DESC');">
                                <option
                                    value="1" <?php if ($order == 1) echo 'selected="selected"' ?>> <?= __('Code') ?></option>
                                <option
                                    value="2" <?php if ($order == 2) echo 'selected="selected"' ?>><?= __('Nom') ?></option>
                                <option
                                    value="3" <?php if ($order == 3) echo 'selected="selected"' ?>><?= __('Daira') ?></option>
                                <option
                                    value="4" <?php if ($order == 4) echo 'selected="selected"' ?>><?= __('Wilaya') ?></option>

                            </select>
                        </label>
                        <span id="asc_desc" >
                        <i class="fa fa-sort-asc" id="asc" onclick="selectOrderChanged('destinations/index', 'ASC');"></i>
                        <i class="fa fa-sort-desc" id="desc" onclick="selectOrderChanged('destinations/index','DESC');"></i>
                        </span>
                    </div>
                    <div class="dataTables_length" id="datatable-editable_length" style="display: inline-block;">
                        <label>
                            <?php
                            if (isset($this->params['pass']['0'])) $limit = $this->params['pass']['0'];
                            ?>
                            <select aria-controls="datatable-editable" class="form-control input-sm" name="slctlimit"
                                    id="slctlimit" onchange="slctlimitChanged('destinations/index');">
                                <option value="20" <?php if ($limit == 20) echo 'selected="selected"' ?>>20</option>
                                <option value="25" <?php if ($limit == 25) echo 'selected="selected"' ?>>25</option>
                                <option value="50" <?php if ($limit == 50) echo 'selected="selected"' ?>>50</option>
                                <option value="100" <?php if ($limit == 100) echo 'selected="selected"' ?>>100</option>
                                <option value="500" <?php if ($limit == 500) echo 'selected="selected"' ?>>500</option>
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
                        <th><?php echo $this->Paginator->sort('code', __('Code')); ?></th>
                        <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
                        <th><?php echo $this->Paginator->sort('Daira.name', __('Daira')); ?></th>
                        <th><?php echo $this->Paginator->sort('Wilaya.name', __('Wilaya')); ?></th>
                        <th><?php echo $this->Paginator->sort('created', __('Created')); ?></th>
                        <th><?php echo $this->Paginator->sort('modified', __("Modified")); ?></th>
                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                    </thead>

                    <tbody id="listeDiv">
                    <?php foreach ($destinations as $destination): ?>
                        <tr id="row<?= $destination['Destination']['id'] ?>">
                            <td>

                                <input id="idCheck" type="checkbox" class='id'
                                       value=<?php echo $destination['Destination']['id'] ?>>
                            </td>
                            <td><?php echo h($destination['Destination']['code']); ?>&nbsp;</td>
                            <td><?php echo h($destination['Destination']['name']); ?>&nbsp;</td>
                            <td><?php echo h($destination['Daira']['name']); ?>&nbsp;</td>
                            <td><?php echo h($destination['Wilaya']['name']); ?>&nbsp;</td>
                            <td><?php echo h($this->Time->format($destination['Destination']['created'], '%d-%m-%Y %H:%M')); ?>
                                &nbsp;</td>
                            <td><?php echo h($this->Time->format($destination['Destination']['modified'], '%d-%m-%Y %H:%M')); ?>
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
                            array('action' => 'View', $destination['Destination']['id']),
                            array('escape' => false, 'class'=>'btn btn-success')
                        ); ?>
                    </li>

                    <li>
                        <?= $this->Html->link(
                            '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                            array('action' => 'Edit', $destination['Destination']['id']),
                            array('escape' => false , 'class'=>'btn btn-primary')
                        ); ?>
                    </li>


                    <li>
                        <?php
                        echo $this->Form->postLink(
                            '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                            array('action' => 'delete', $destination['Destination']['id']),
                            array('escape' => false , 'class'=>'btn btn-danger'),
                            __('Are you sure you want to delete %s?',$destination['Destination']['name'])); ?>
                    </li>
                </ul>
            </div>
                </td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
                <div id="pagination" class="pull-right">
                    <?php if($this->params['paging']['Destination']['pageCount'] > 1){ ?>
                        <p>
                            <?php
                            echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?>	</p>
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php
                                echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
                                echo $this->Paginator->numbers(array(
                                    'tag' => 'li',
                                    'first' => false,
                                    'last' => false,
                                    'separator' => '',
                                    'currentTag' => 'a'));
                                echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
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
