<?php
/** @var array $factor */
?>
<div class="box-body">

	<h4 class="page-title"> <?=$factor['Factor']['name']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($factor['Factor']['name']); ?>
			&nbsp;
		</dd>

                
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($factor['Factor']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($factor['Factor']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>