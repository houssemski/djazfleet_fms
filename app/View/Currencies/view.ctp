<div class="box-body">
<?php
?><h4 class="page-title"> <?=$currency['Currency']['name']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($currency['Currency']['name']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Abr'); ?></dt>
		<dd>
			<?php echo h($currency['Currency']['abr']); ?>
			&nbsp;
		</dd>
                

	</dl>
</div>