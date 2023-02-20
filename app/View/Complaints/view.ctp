<div class="box-body">
<?php
?><h4 class="page-title"> <?=$complaint['Complaint']['reference']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($complaint['Complaint']['complaint_date'], '%d-%m-%Y')); ?>
			&nbsp;
		</dd>
        <dt><?php echo __('Mission'); ?></dt>
        <dd>
            <?php   echo $complaint['SheetRideDetailRides']['reference'] ;
            ?>
            &nbsp;
        </dd>


        <dt><?php echo __('Complaint cause'); ?></dt>
		<dd>
			<?php   echo $complaint['ComplaintCause']['name'] ;
            ?>
			&nbsp;
		</dd>


        <dt><?php echo __('Observation'); ?></dt>
        <dd>
            <?php   echo $complaint['Complaint']['observation'] ;
            ?>
            &nbsp;
        </dd>


	</dl>
</div>