<div class="legalForms view">
<h2><?php echo __('Legal Form'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($legalForm['LegalForm']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($legalForm['LegalForm']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($legalForm['LegalForm']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($legalForm['LegalForm']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Legal Form'), array('action' => 'edit', $legalForm['LegalForm']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Legal Form'), array('action' => 'delete', $legalForm['LegalForm']['id']), array(), __('Are you sure you want to delete # %s?', $legalForm['LegalForm']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Legal Forms'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Legal Form'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Companies'), array('controller' => 'companies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Company'), array('controller' => 'companies', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Companies'); ?></h3>
	<?php if (!empty($legalForm['Company'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Address'); ?></th>
		<th><?php echo __('Phone'); ?></th>
		<th><?php echo __('Fax'); ?></th>
		<th><?php echo __('Mobile'); ?></th>
		<th><?php echo __('Rc'); ?></th>
		<th><?php echo __('Ai'); ?></th>
		<th><?php echo __('Nif'); ?></th>
		<th><?php echo __('Social Capital'); ?></th>
		<th><?php echo __('Cb'); ?></th>
		<th><?php echo __('Rib'); ?></th>
		<th><?php echo __('Legal Form Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($legalForm['Company'] as $company): ?>
		<tr>
			<td><?php echo $company['id']; ?></td>
			<td><?php echo $company['name']; ?></td>
			<td><?php echo $company['adress']; ?></td>
			<td><?php echo $company['phone']; ?></td>
			<td><?php echo $company['fax']; ?></td>
			<td><?php echo $company['mobile']; ?></td>
			<td><?php echo $company['rc']; ?></td>
			<td><?php echo $company['ai']; ?></td>
			<td><?php echo $company['nif']; ?></td>
			<td><?php echo $company['social_capital']; ?></td>
			<td><?php echo $company['cb']; ?></td>
			<td><?php echo $company['rib']; ?></td>
			<td><?php echo $company['legal_form_id']; ?></td>
			<td><?php echo $company['created']; ?></td>
			<td><?php echo $company['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'companies', 'action' => 'view', $company['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'companies', 'action' => 'edit', $company['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'companies', 'action' => 'delete', $company['id']), array(), __('Are you sure you want to delete # %s?', $company['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Company'), array('controller' => 'companies', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
