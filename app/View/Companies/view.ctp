<div class="companies view">
<h2><?php echo __('Company'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($company['Company']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($company['Company']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Adress'); ?></dt>
		<dd>
			<?php echo h($company['Company']['adress']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone'); ?></dt>
		<dd>
			<?php echo h($company['Company']['phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fax'); ?></dt>
		<dd>
			<?php echo h($company['Company']['fax']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mobile'); ?></dt>
		<dd>
			<?php echo h($company['Company']['mobile']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rc'); ?></dt>
		<dd>
			<?php echo h($company['Company']['rc']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ai'); ?></dt>
		<dd>
			<?php echo h($company['Company']['ai']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nif'); ?></dt>
		<dd>
			<?php echo h($company['Company']['nif']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Social Capital'); ?></dt>
		<dd>
			<?php echo h($company['Company']['social_capital']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cb'); ?></dt>
		<dd>
			<?php echo h($company['Company']['cb']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rib'); ?></dt>
		<dd>
			<?php echo h($company['Company']['rib']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Legal Form'); ?></dt>
		<dd>
			<?php echo $this->Html->link($company['LegalForm']['name'], array('controller' => 'legal_forms', 'action' => 'view', $company['LegalForm']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($company['Company']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($company['Company']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Company'), array('action' => 'edit', $company['Company']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Company'), array('action' => 'delete', $company['Company']['id']), array(), __('Are you sure you want to delete # %s?', $company['Company']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Companies'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Company'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Legal Forms'), array('controller' => 'legal_forms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Legal Form'), array('controller' => 'legal_forms', 'action' => 'add')); ?> </li>
	</ul>
</div>
