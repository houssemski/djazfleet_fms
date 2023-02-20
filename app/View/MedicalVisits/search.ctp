<h4 class="page-title"> <?= __('Search'); ?></h4>


<div class="box-body">

    <div class="row" style="clear:both">
        <div class="btn-group pull-left">
            <div class="header_actions">
                <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                    array('action' => 'Add'),
                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                    'javascript:submitDeleteForm("medicalVisits/deletemedicalvisits/");',
                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                        'disabled' => 'true'),
                    __('Are you sure you want to delete selected event types ?')); ?>


            </div>
        </div>

    </div>
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <?php echo $this->Form->create('MedicalVisits', array(
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
                        <th><?php echo $this->Paginator->sort('date', __('Date')); ?></th>
                        <th><?php echo $this->Paginator->sort('internal_external', __('Type')); ?></th>
                        <th><?php echo $this->Paginator->sort('consulting_doctor', __('Consulting doctor')); ?></th>
                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                    </thead>
                    <tbody id="listeDiv">
                    <?php foreach ($medicalVisits as $medicalVisit): ?>
                        <tr id="row<?= $medicalVisit['MedicalVisit']['id'] ?>">
                            <td>

                                <input id="idCheck" type="checkbox" class='id'
                                       value=<?php echo $medicalVisit['MedicalVisit']['id'] ?>>
                            </td>
                            <td><?php echo h($medicalVisit['MedicalVisit']['visit_number']); ?>&nbsp;</td>
                            <td><?php echo h($medicalVisit['Customer']['first_name'].'-'.$medicalVisit['Customer']['last_name']); ?>&nbsp;</td>
                             <td><?php echo h($this->Time->format($medicalVisit['MedicalVisit']['date'], '%d-%m-%Y')); ?>&nbsp;</td>
                            <td><?php  if($medicalVisit['MedicalVisit']['internal_external']== 1) {
                                    echo  __('internal');
                                } else {
                                    echo  __('external');
                                }?></td>
                            <td><?php echo h($medicalVisit['MedicalVisit']['consulting_doctor']) ?>&nbsp;</td>
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
                                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                array('action' => 'Edit', $medicalVisit['MedicalVisit']['id']),
                                                array('escape' => false, 'class' => 'btn btn-primary')
                                            ); ?>
                                        </li>


                                        <li>
                                            <?php
                                            echo $this->Form->postLink(
                                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                                array('action' => 'delete', $medicalVisit['MedicalVisit']['id']),
                                                array('escape' => false, 'class' => 'btn btn-danger'),
                                                __('Are you sure you want to delete %s?', $medicalVisit['MedicalVisit']['visit_number'])); ?>
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
