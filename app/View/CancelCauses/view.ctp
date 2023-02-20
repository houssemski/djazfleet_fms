<div class="box-body">
<?php
?><h4 class="page-title"> <?=$cancelCause['CancelCause']['name']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($cancelCause['CancelCause']['name']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($cancelCause['CancelCause']['code']); ?>
			&nbsp;
		</dd>

		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($cancelCause['CancelCause']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($cancelCause['CancelCause']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>