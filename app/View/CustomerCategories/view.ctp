<div class="box-body">
<?php
?><h4 class="page-title"> <?=$customerCategory['CustomerCategory']['name']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($customerCategory['CustomerCategory']['name']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($customerCategory['CustomerCategory']['code']); ?>
			&nbsp;
		</dd>
                <?php
                if(isset($customerCategory['CustomerCategory']['discount_rate'])){
                ?>
                <dt><?php echo __('Discount rate'); ?></dt>
		<dd>
			<?php echo h($customerCategory['CustomerCategory']['discount_rate']); ?>
			&nbsp;
		</dd>
                <?php } ?>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($customerCategory['CustomerCategory']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($customerCategory['CustomerCategory']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>