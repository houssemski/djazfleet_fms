<div class="box-body">
<?php
?><h4 class="page-title"> <?=$interfering['Interfering']['name']; ?></h4>
	<dl class="card-box">
                <dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($interfering['Interfering']['code']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($interfering['InterferingType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($interfering['Interfering']['name']); ?>
			&nbsp;
		</dd>
                <?php
                if(isset($interfering['Interfering']['adress']) && !empty($interfering['Interfering']['adress'])){
                ?>
                <dt><?php echo __('Adress'); ?></dt>
		<dd>
			<?php echo h($interfering['Interfering']['adress']); ?>
			&nbsp;
		</dd>
                <?php } ?>
                <?php
                if(isset($interfering['Interfering']['tel']) && !empty($interfering['Interfering']['tel'])){
                ?>
                <dt><?php echo __('Phone'); ?></dt>
		<dd>
			<?php echo h($interfering['Interfering']['tel']); ?>
			&nbsp;
		</dd>
                <?php } ?>
                <?php
                if(isset($interfering['Interfering']['note']) && !empty($interfering['Interfering']['note'])){
                ?>
                <dt><?php echo __('Note'); ?></dt>
		<dd>
			<?php echo nl2br(h($interfering['Interfering']['note'])); ?>
			&nbsp;
		</dd>
                <?php } ?>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($interfering['Interfering']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($interfering['Interfering']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>