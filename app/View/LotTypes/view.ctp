<?php
/** @var array $lotType */
?>
<div class="box-body">

	<h4 class="page-title"> <?=$lotType['LotType']['name']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($lotType['LotType']['name']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($lotType['LotType']['code']); ?>
			&nbsp;
		</dd>
                
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($lotType['LotType']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($lotType['LotType']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>