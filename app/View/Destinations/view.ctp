<div class="box-body">
<?php
?><h4 class="page-title"> <?=$destination['Destination']['name']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($destination['Destination']['code']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($destination['Destination']['name']); ?>
			&nbsp;
		</dd>


		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($destination['Destination']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($destination['Destination']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>