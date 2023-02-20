<div class="box-body">
<?php
?><h4 class="page-title"> <?=$position['Position']['name']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($position['Position']['code']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($position['Position']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($position['Position']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($position['Position']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>