<div class="box-body">
<?php
?><h4 class="page-title"> <?=$eventType['EventType']['name']; ?></h4>
	<dl>
                <dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($eventType['EventType']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($eventType['EventType']['name']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Transaction'); ?></dt>
                 
		<dd>
			<?php if ($eventType['EventType']['transact_type_id']==1) echo __('Encasement'); 
             else  echo __('Disbursement');

?>
			&nbsp;
		</dd>
                <dt><?php echo __('With km'); ?></dt>
		<dd>
			<?php if($eventType['EventType']['with_km'] == 1) echo __('YES'); 
                          else echo __('NO'); 
                ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($eventType['EventType']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($eventType['EventType']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>