


<div class="box-body">
<?php
?><h4 class="page-title"> <?=__('TVA ').$tva['Tva']['name']; ?></h4>
	<dl class="card-box">
		
		
                <dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($tva['Tva']['name']); ?>
			&nbsp;
		</dd>
       
                       
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($tva['Tva']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($tva['Tva']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>

