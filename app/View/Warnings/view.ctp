<div class="box-body">
<?php
?><h4 class="page-title"> <?=$warning['Warning']['code']; ?></h4>
	<dl>
                <dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($warning['Warning']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Employee'); ?></dt>
		<dd>
			<?php echo h($warning['Customer']['first_name'].'-'.$warning['Customer']['last_name']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Warning type'); ?></dt>
                 
		<dd>
            <?php
               echo h($warning['WarningType']['name']);  ?>
			&nbsp;
		</dd>

		<dt><?php echo __('Start date'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($warning['Warning']['start_date'], '%d-%m-%Y')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('End date'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($warning['Warning']['end_date'], '%d-%m-%Y')); ?>
			&nbsp;
		</dd>
        <dt><?php echo __('Note'); ?></dt>
        <dd>
            <?php
            echo h($warning['Warning']['note']);  ?>
            &nbsp;
        </dd>
	</dl>
</div>