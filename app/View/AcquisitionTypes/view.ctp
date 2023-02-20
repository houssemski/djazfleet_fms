<div class="box-body">
<?php
?><h4 class="page-title"> <?= $acquisitionType['AcquisitionType']['name']; ?></h4>
	<div class="card-box p-b-0">
	<dl>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($acquisitionType['AcquisitionType']['code']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($acquisitionType['AcquisitionType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($acquisitionType['AcquisitionType']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($acquisitionType['AcquisitionType']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
		</div>
</div>