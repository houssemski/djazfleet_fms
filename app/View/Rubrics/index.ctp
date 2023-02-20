<h4 class="page-title"> <?=__('Rubrics'); ?></h4>
<div class="box-body">
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
    <div class="row" style="clear:both">
        <div class="btn-group pull-left">
            <div class="header_actions">
    <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>'.__('Add'),
            array('action' => 'Add'),
            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
    <?= $this->Html->link('<i class="fa fa-trash-o m-r-5"></i>'.__('Delete'),
                                'javascript:submitDeleteForm("rubrics/deleteRubrics/");',
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                    'disabled' => 'true'), 
                                __('Are you sure you want to delete selected rebric?')); ?>


            </div>
        </div>
        <div style='clear:both; padding-top: 10px;'></div>
    </div>
    </div>
    </div>
    </div>

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
	<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"                            cellspacing="0" width="100%">
	<thead>
	<tr>
            <th style="width: 10px"> 
                    <button type="button" id ='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
                </th>
                
			<th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
           
			<th><?php echo $this->Paginator->sort('created', __('Created')); ?></th>
			<th><?php echo $this->Paginator->sort('modified', __('Modified')); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($rubrics as $rubric): ?>
	<tr id="row<?= $rubric['Rubric']['id'] ?>">
            <td>

                <input id="idCheck"type="checkbox" class = 'id' value=<?php echo $rubric['Rubric']['id'] ?> >
                </td>
                
		<td><?php echo h($rubric['Rubric']['name']); ?>&nbsp;</td>
        
		<td><?php echo h($this->Time->format($rubric['Rubric']['created'], '%d-%m-%Y %H:%M')); ?>&nbsp;</td>
		<td><?php echo h($this->Time->format($rubric['Rubric']['modified'], '%d-%m-%Y %H:%M')); ?>&nbsp;</td>
		<td class="actions">
                    <?= $this->Html->link(
                                    '<i class="  fa fa-eye m-r-5"></i>',
                                    array('action' => 'View',$rubric['Rubric']['id']),
                                    array('escape' => false)
                                    ); ?>
			<?= $this->Html->link(
                                    '<i class="  fa fa-edit m-r-5"></i>',
                                    array('action' => 'Edit', $rubric['Rubric']['id']),
                                    array('escape' => false)
                                    ); ?>
                    <?php echo $this->Form->postLink(
                                '<i class=" fa fa-trash-o m-r-5"></i>',
                                array('action' => 'Delete', $rubric['Rubric']['id']),
                                array('escape' => false), 
                                __('Are you sure you want to delete %s?', $rubric['Rubric']['name'])); ?>
                </td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
		
</div>
</div>
</div>
</div>

<?php
if($this->params['paging']['Rubric']['pageCount'] > 1){
?>
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

<?php $this->start('script'); ?>

<script type="text/javascript">     $(document).ready(function() {      });



</script>
<?php $this->end(); ?>
