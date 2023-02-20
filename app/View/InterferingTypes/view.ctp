<div class="box-body">
<?php
?><h4 class="page-title"> <?=$interferingType['InterferingType']['name']; ?></h4>
	<dl class="card-box">
                <dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($interferingType['InterferingType']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($interferingType['InterferingType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($interferingType['InterferingType']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($interferingType['InterferingType']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>