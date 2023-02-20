<div class="box-body">
<?php
?><h4 class="page-title"> <?php echo __('Contract') .' '?><?=$contract['Contract']['reference']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Reference'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['reference']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Supplier'); ?></dt>
		<dd>
			<?php echo h($contract['Supplier']['name']); ?>
			&nbsp;
		</dd>
		<?php foreach ($contractCarTypes as $contractCarType) {?>
		<dt><?php echo __('Car Type'); ?></dt>
		<dd>
			<?php echo h($contractCarType['CarType']['name']); ?>
			&nbsp;
		</dd>
			<dt><?php echo __('Payment type'); ?></dt>
		<dd>
			<?php if($contractCarType['ContractCarType']['km_day'] ==1) echo __('Km') ; else echo __('Day'); ?>
			&nbsp;
		</dd>
			<dt><?php echo __('Cost'); ?></dt>
		<dd>
			<?php echo h(number_format($contractCarType['ContractCarType']['cost'], 2, ",", $separatorAmount)); ?>
			&nbsp;
		</dd>
		<?php } ?>
		<dt><?php echo __('Start date'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($contract['Contract']['date_start'], '%d-%m-%Y')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('End date'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($contract['Contract']['date_end'], '%d-%m-%Y')); ?>
			&nbsp;
		</dd>
	</dl>
</div>