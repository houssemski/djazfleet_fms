<div class="models view">
<h2><?php echo __('Model'); ?></h2>
	<dl>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($model['Carmodel']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mark'); ?></dt>
		<dd>
			<?php echo h($model['Mark']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($model['Carmodel']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($model['Carmodel']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
