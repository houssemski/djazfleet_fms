<div class="legalForms index">
	<h2><?php echo __('Legal Forms'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody id="listeDiv">
	<?php foreach ($legalForms as $legalForm): ?>
	<tr>
		<td><?php echo h($legalForm['LegalForm']['id']); ?>&nbsp;</td>
		<td><?php echo h($legalForm['LegalForm']['name']); ?>&nbsp;</td>
		<td><?php echo h($legalForm['LegalForm']['created']); ?>&nbsp;</td>
		<td><?php echo h($legalForm['LegalForm']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $legalForm['LegalForm']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $legalForm['LegalForm']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $legalForm['LegalForm']['id']), array(), __('Are you sure you want to delete # %s?', $legalForm['LegalForm']['id'])); ?>
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

<?= $this->Form->input('controller', [
        'id'=>'controller',
        'value'=>   $this->request->params['controller'],
        'type'=>'hidden'
    ]); ?>

    <?= $this->Form->input('action', [
        'id'=>'action',
        'value'=>   'liste',
        'type'=>'hidden'
    ]); ?>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Legal Form'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Companies'), array('controller' => 'companies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Company'), array('controller' => 'companies', 'action' => 'add')); ?> </li>
	</ul>
</div>
