


<div class="box-body">
	<?php
	?><h4 class="page-title"> <?=__('Type ').' '.$attachmentType['AttachmentType']['name']; ?></h4>
	<dl class="card-box">


		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($attachmentType['AttachmentType']['name']); ?>
			&nbsp;
		</dd>

		<dt><?php echo __('Section'); ?></dt>
		<dd>
			<?php echo h($attachmentType['Section']['name']); ?>
			&nbsp;
		</dd>


		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($attachmentType['AttachmentType']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($attachmentType['AttachmentType']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>




