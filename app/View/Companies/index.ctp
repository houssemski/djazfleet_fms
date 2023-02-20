<div class="companies index">
	<h2><?php echo __('Companies'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('adress'); ?></th>
			<th><?php echo $this->Paginator->sort('phone'); ?></th>
			<th><?php echo $this->Paginator->sort('fax'); ?></th>
			<th><?php echo $this->Paginator->sort('mobile'); ?></th>
			<th><?php echo $this->Paginator->sort('rc'); ?></th>
			<th><?php echo $this->Paginator->sort('ai'); ?></th>
			<th><?php echo $this->Paginator->sort('nif'); ?></th>
			<th><?php echo $this->Paginator->sort('social_capital'); ?></th>
			<th><?php echo $this->Paginator->sort('cb'); ?></th>
			<th><?php echo $this->Paginator->sort('rib'); ?></th>
			<th><?php echo $this->Paginator->sort('legal_form_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($companies as $company): ?>
	<tr>
		<td><?php echo h($company['Company']['id']); ?>&nbsp;</td>
		<td><?php echo h($company['Company']['name']); ?>&nbsp;</td>
		<td><?php echo h($company['Company']['adress']); ?>&nbsp;</td>
		<td><?php echo h($company['Company']['phone']); ?>&nbsp;</td>
		<td><?php echo h($company['Company']['fax']); ?>&nbsp;</td>
		<td><?php echo h($company['Company']['mobile']); ?>&nbsp;</td>
		<td><?php echo h($company['Company']['rc']); ?>&nbsp;</td>
		<td><?php echo h($company['Company']['ai']); ?>&nbsp;</td>
		<td><?php echo h($company['Company']['nif']); ?>&nbsp;</td>
		<td><?php echo h($company['Company']['social_capital']); ?>&nbsp;</td>
		<td><?php echo h($company['Company']['cb']); ?>&nbsp;</td>
		<td><?php echo h($company['Company']['rib']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($company['LegalForm']['name'], array('controller' => 'legal_forms', 'action' => 'view', $company['LegalForm']['id'])); ?>
		</td>
		<td><?php echo h($company['Company']['created']); ?>&nbsp;</td>
		<td><?php echo h($company['Company']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $company['Company']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $company['Company']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $company['Company']['id']), array(), __('Are you sure you want to delete # %s?', $company['Company']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Company'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Legal Forms'), array('controller' => 'legal_forms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Legal Form'), array('controller' => 'legal_forms', 'action' => 'add')); ?> </li>
	</ul>
</div>
