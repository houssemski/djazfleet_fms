<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"                            cellspacing="0" width="100%">
    <thead>
    <tr>
        <th style="width: 10px">
            <button type="button" id ='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
        </th>
        <th><?php echo $this->Paginator->sort('code', __('Code')); ?></th>
        <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
        <th><?php echo $this->Paginator->sort('Fuel.name', __('Fuel')); ?></th>
        <th><?php echo $this->Paginator->sort('capacity', __('Capacity')); ?></th>
        <th><?php echo $this->Paginator->sort('liter', __('Liter')); ?></th>
        <th><?php echo $this->Paginator->sort('localisation', __('Localisation')); ?></th>
        <th class="actions"><?php echo __('Actions'); ?></th>
    </tr>
    </thead>
    <tbody id="listeDiv">
    <?php foreach ($tanks as $tank): ?>
        <tr id="row<?= $tank['Tank']['id'] ?>">
            <td>

                <input id="idCheck"type="checkbox" class = 'id' value=<?php echo $tank['Tank']['id'] ?> >
            </td>
            <td><?php echo h($tank['Tank']['code']); ?>&nbsp;</td>
            <td><?php echo h($tank['Tank']['name']); ?>&nbsp;</td>
            <td><?php echo h($tank['Fuel']['name']); ?>&nbsp;</td>
            <td><?php echo h(number_format($tank['Tank']['capacity'], 2, ",", ".")); ?>&nbsp;</td>
            <td><?php echo h(number_format($tank['Tank']['liter'], 2, ",", ".")); ?>&nbsp;</td>
            <td><?php echo h($tank['Tank']['localisation']); ?>&nbsp;</td>
            <td class="actions">
                <div  class="btn-group ">
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
                                array('action' => 'View', $tank['Tank']['id']),
                                array('escape' => false, 'class'=>'btn btn-success')
                            ); ?>
                        </li>

                        <li>
                            <?= $this->Html->link(
                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                array('action' => 'Edit',  $tank['Tank']['id']),
                                array('escape' => false , 'class'=>'btn btn-primary')
                            ); ?>
                        </li>

                        <li>
                            <?php
                            echo $this->Form->postLink(
                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                array('action' => 'delete',  $tank['Tank']['id']),
                                array('escape' => false , 'class'=>'btn btn-danger'),
                                __('Are you sure you want to delete %s?',$tank['Tank']['name'])); ?>
                        </li>
                    </ul>
                </div>



            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php
if($this->params['paging']['Tank']['pageCount'] > 1){
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