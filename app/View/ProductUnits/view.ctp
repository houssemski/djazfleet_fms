<?php
/** @var array $productUnit */
?>
<div class="box-body">

	<h4 class="page-title"> <?=$productUnit['ProductUnit']['name']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($productUnit['ProductUnit']['name']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($productUnit['ProductUnit']['code']); ?>
			&nbsp;
		</dd>
                
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($productUnit['ProductUnit']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($productUnit['ProductUnit']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>