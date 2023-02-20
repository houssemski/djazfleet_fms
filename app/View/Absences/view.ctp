<div class="box-body">
<?php
?><h4 class="page-title"> <?=$absence['Absence']['code']; ?></h4>
	<dl>
                <dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($absence['Absence']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Employee'); ?></dt>
		<dd>
			<?php echo h($absence['Customer']['first_name'].'-'.$absence['Customer']['last_name']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Absence reson'); ?></dt>
                 
		<dd>
            <?php
               echo h($absence['AbsenceReason']['name']);  ?>
			&nbsp;
		</dd>

		<dt><?php echo __('Start date'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($absence['Absence']['start_date'], '%d-%m-%Y')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('End date'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($absence['Absence']['end_date'], '%d-%m-%Y')); ?>
			&nbsp;
		</dd>
        <dt><?php echo __('Note'); ?></dt>
        <dd>
            <?php
            echo h($absence['Absence']['note']);  ?>
            &nbsp;
        </dd>
	</dl>
</div>