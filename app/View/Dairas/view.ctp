<div class="box-body">
<?php
?><h4 class="page-title"> <?=$daira['Daira']['name']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($daira['Daira']['code']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($daira['Daira']['name']); ?>
			&nbsp;
		</dd>

                 <dt><?php echo __('Wilaya'); ?></dt>
		<dd>
			<?php echo h($daira['Wilaya']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($daira['Daira']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($daira['Daira']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>