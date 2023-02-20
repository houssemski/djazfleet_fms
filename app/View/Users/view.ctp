<div class="box-body">
<?php
?><h4 class="page-title"> <?=$user['User']['first_name']." ".$user['User']['last_name']; ?></h4>
	<div class="row">
		<!-- BASIC WIZARD -->
		<div class="col-lg-12">
			<div class="card-box p-b-0">
				<div class="row" style="clear:both">
					<div class="btn-group pull-left">
						<div class="header_actions">
        <?= $this->Html->link(
                '<i class="fa fa-edit m-r-5 m-r-5"></i>'.__("Edit"),
                array('action' => 'Edit', $user['User']['id']),
                array('escape' => false, 'class'=>"btn btn-primary btn-bordred waves-effect waves-light m-b-5")
            ); ?>
        <?= $this->Form->postLink(
                '<i class="fa fa-trash-o m-r-5 m-r-5"></i>'.__("Delete"),
                array('action' => 'Delete', $user['User']['id']),
                array('escape' => false, 'class'=>"btn btn-inverse btn-bordred waves-effect waves-light m-b-5"),
                __('Are you sure you want to delete %s?', $user['User']['first_name']." ".$user['User']['last_name'])); ?>
    </a>
        
        <div style="clear: both"></div>
    </div>
   </div>
					<div style='clear:both; padding-top: 10px;'></div>
   </div>
   </div>
   </div>
   </div>
	<dl>
		<dt><?php echo __('First Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['first_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['last_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($user['User']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($user['User']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($user['User']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>
