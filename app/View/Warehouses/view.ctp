


<div class="box-body">
<?php
?><h4 class="page-title"> <?=$warehouse['Warehouse']['name']; ?></h4>
	<dl>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($warehouse['Warehouse']['code']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($warehouse['Warehouse']['name']); ?>
			&nbsp;
		</dd>
       <?php if (!empty($warehouse['Warehouse']['adress'])) { ?>
                        <br/>
                        <dt><?php echo __('Address'); ?></dt>
                        <dd>
                            <?php echo h($warehouse['Warehouse']['adress']);
                                 } ?>
                       
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($warehouse['Warehouse']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($warehouse['Warehouse']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>

