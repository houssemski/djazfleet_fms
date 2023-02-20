<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"                            cellspacing="0" width="100%">
	<thead>
	<tr>
          
               
			
			
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			
	</tr>
	</thead>
	<tbody>
    
	<?php foreach ($audits as $audit): ?>
	<tr id="row<?= $audit['Audit']['id'] ?>">
           
         
		<td><?php echo h($this->Time->format($audit['Audit']['created'], '%d-%m-%Y %H:%M')); ?>&nbsp;</td>
		<td><?php echo h($this->Time->format($audit['Audit']['modified'], '%d-%m-%Y %H:%M')); ?>&nbsp;</td>
	
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>

</div>

<?php
if($this->params['paging']['Audit']['pageCount'] > 1){
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

