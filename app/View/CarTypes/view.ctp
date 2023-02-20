<div class="box-body">
<?php
?><h4 class="page-title"> <?=$carType['CarType']['name']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($carType['CarType']['code']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($carType['CarType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($carType['CarType']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($carType['CarType']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>