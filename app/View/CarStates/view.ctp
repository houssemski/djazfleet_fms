<div class="box-body">
<?php
?><h4 class="page-title"> <?=$carState['CarState']['name']; ?></h4>
	<dl class="card-box">

                <dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($carState['CarState']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($carState['CarState']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($carState['CarState']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>