
<div class="box-body">
	<?php
	?><h4 class="page-title"> <?=__('Rubric ').$rubric['Rubric']['name']; ?></h4>
	<dl class="card-box">


		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($rubric['Rubric']['name']); ?>
			&nbsp;
		</dd>


		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($rubric['Rubric']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($rubric['Rubric']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>
