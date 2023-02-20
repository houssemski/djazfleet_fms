<div class="box-body">
<?php
?><h4 class="page-title"> <?= $productFamily['ProductFamily']['name']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($productFamily['ProductFamily']['name']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($productFamily['ProductFamily']['code']); ?>
			&nbsp;
		</dd>
                
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($productFamily['ProductFamily']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($productFamily['ProductFamily']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>