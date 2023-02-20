<div class="box-body">
<?php
?><h4 class="page-title"> <?=$compte['Compte']['num_compte']; ?></h4>
	<dl class="card-box">

		<dt><?php echo __('Num compte'); ?></dt>
		<dd>
			<?php echo h($compte['Compte']['num_compte']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Amount'); ?></dt>
		<dd>
			<?php echo number_format($compte['Compte']['amount'], 2, ",", $separatorAmount); ?>
			&nbsp;
		</dd>

		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($compte['Compte']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($compte['Compte']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>

