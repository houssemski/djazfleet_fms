<div class="companies form">
<?php echo $this->Form->create('Company'); ?>
	<fieldset>
		<legend><?php echo __('Edit Company'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('adress');
		echo $this->Form->input('phone');
		echo $this->Form->input('fax');
		echo $this->Form->input('mobile');
		echo $this->Form->input('rc');
		echo $this->Form->input('ai');
		echo $this->Form->input('nif');
		echo $this->Form->input('social_capital');
		echo $this->Form->input('cb');
		echo $this->Form->input('rib');
		echo $this->Form->input('legal_form_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Company.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Company.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Companies'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Legal Forms'), array('controller' => 'legal_forms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Legal Form'), array('controller' => 'legal_forms', 'action' => 'add')); ?> </li>
	</ul>
</div>
