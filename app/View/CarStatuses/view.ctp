<div class="box-body">
<?php
?><h4 class="page-title"> <?=$carStatus['CarStatus']['name']; ?></h4>
	<dl class="card-box">
            <dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($carStatus['CarStatus']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($carStatus['CarStatus']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($carStatus['CarStatus']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($carStatus['CarStatus']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>