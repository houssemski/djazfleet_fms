<div class="box-body">
<?php
?><h4 class="page-title"> <?=$carOption['CarOption']['name']; ?></h4>
	<dl class="card-box">
            <dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($carOption['CarOption']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($carOption['CarOption']['name']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Price'); ?></dt>
		<dd>
			<?php echo h($carOption['CarOption']['price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($carOption['CarOption']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($carOption['CarOption']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>