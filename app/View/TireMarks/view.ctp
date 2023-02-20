<div class="box-body">
<?php
?><h4 class="page-title"> <?=$tiremark['TireMark']['name']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($tiremark['TireMark']['code']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($tiremark['TireMark']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($tiremark['TireMark']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($tiremark['TireMark']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>