<div class="box-body">
<?php
?><h4 class="page-title"> <?=$absenceReason['AbsenceReason']['name']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($absenceReason['AbsenceReason']['name']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($absenceReason['AbsenceReason']['code']); ?>
			&nbsp;
		</dd>
                
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($absenceReason['AbsenceReason']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($absenceReason['AbsenceReason']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>