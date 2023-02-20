<div class="parameters view">
<h2><?php echo __('Parameter'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($parameter['Parameter']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($parameter['Parameter']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Val'); ?></dt>
		<dd>
			<?php echo h($parameter['Parameter']['val']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($parameter['Parameter']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($parameter['Parameter']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Parameter'), array('action' => 'edit', $parameter['Parameter']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Parameter'), array('action' => 'delete', $parameter['Parameter']['id']), array(), __('Are you sure you want to delete # %s?', $parameter['Parameter']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Parameters'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parameter'), array('action' => 'add')); ?> </li>
	</ul>
</div>
