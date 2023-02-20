<div class="box-body">
<?php
?><h4 class="page-title"> <?=$supplierCategory['SupplierCategory']['name']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($supplierCategory['SupplierCategory']['name']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($supplierCategory['SupplierCategory']['code']); ?>
			&nbsp;
		</dd>
               
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($supplierCategory['SupplierCategory']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($supplierCategory['SupplierCategory']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>