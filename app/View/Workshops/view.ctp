<div class="box-body">
<?php
?><h4 class="page-title"> <?=$workshop['Workshop']['name']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($workshop['Workshop']['code']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($workshop['Workshop']['name']); ?>
			&nbsp;
		</dd>


		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($workshop['Workshop']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($workshop['Workshop']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>