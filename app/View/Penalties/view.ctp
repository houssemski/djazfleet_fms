<div class="box-body">
<?php
?><h4 class="page-title"> <?=$penalty['Penalty']['name']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($penalty['Penalty']['name']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($penalty['Penalty']['code']); ?>
			&nbsp;
		</dd>

		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($penalty['Penalty']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($penalty['Penalty']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>