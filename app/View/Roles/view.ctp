<div class="marks view">
<h2><?php echo __('Mark'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($mark['Mark']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($mark['Mark']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($mark['Mark']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($mark['Mark']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Mark'), array('action' => 'edit', $mark['Mark']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Mark'), array('action' => 'delete', $mark['Mark']['id']), array(), __('Are you sure you want to delete # %s?', $mark['Mark']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Marks'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mark'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cars'), array('controller' => 'cars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Car'), array('controller' => 'cars', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Cars'); ?></h3>
	<?php if (!empty($mark['Car'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('Model'); ?></th>
		<th><?php echo __('Nbplace'); ?></th>
		<th><?php echo __('Immatr Prov'); ?></th>
		<th><?php echo __('Immatr Def'); ?></th>
		<th><?php echo __('Chassis'); ?></th>
		<th><?php echo __('Color'); ?></th>
		<th><?php echo __('Circulation Date'); ?></th>
		<th><?php echo __('Date Approval'); ?></th>
		<th><?php echo __('Radio Code'); ?></th>
		<th><?php echo __('Note'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Car Status Id'); ?></th>
		<th><?php echo __('Mark Id'); ?></th>
		<th><?php echo __('Car Type Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Car Category Id'); ?></th>
		<th><?php echo __('Fuel Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($mark['Car'] as $car): ?>
		<tr>
			<td><?php echo $car['id']; ?></td>
			<td><?php echo $car['code']; ?></td>
			<td><?php echo $car['model']; ?></td>
			<td><?php echo $car['nbplace']; ?></td>
			<td><?php echo $car['immatr_prov']; ?></td>
			<td><?php echo $car['immatr_def']; ?></td>
			<td><?php echo $car['chassis']; ?></td>
			<td><?php echo $car['color']; ?></td>
			<td><?php echo $car['circulation_date']; ?></td>
			<td><?php echo $car['date_approval']; ?></td>
			<td><?php echo $car['radio_code']; ?></td>
			<td><?php echo $car['note']; ?></td>
			<td><?php echo $car['created']; ?></td>
			<td><?php echo $car['modified']; ?></td>
			<td><?php echo $car['car_status_id']; ?></td>
			<td><?php echo $car['mark_id']; ?></td>
			<td><?php echo $car['car_type_id']; ?></td>
			<td><?php echo $car['user_id']; ?></td>
			<td><?php echo $car['car_category_id']; ?></td>
			<td><?php echo $car['fuel_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'cars', 'action' => 'view', $car['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'cars', 'action' => 'edit', $car['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'cars', 'action' => 'delete', $car['id']), array(), __('Are you sure you want to delete # %s?', $car['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Car'), array('controller' => 'cars', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
