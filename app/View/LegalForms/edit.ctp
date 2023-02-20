<div class="legalForms form">
<?php echo $this->Form->create('LegalForm'); ?>
	<fieldset>
		<legend><?php echo __('Edit Legal Form'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('LegalForm.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('LegalForm.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Legal Forms'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Companies'), array('controller' => 'companies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Company'), array('controller' => 'companies', 'action' => 'add')); ?> </li>
	</ul>
</div>
