<div class="box-body">
<?php
?><h4 class="page-title"> <?=$complaintResponse['ComplaintResponse']['reference']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($complaintResponse['ComplaintResponse']['response_date'], '%d-%m-%Y')); ?>
			&nbsp;
		</dd>



        <dt><?php echo __('Complaint'); ?></dt>
		<dd>
			<?php   echo $complaintResponse['ComplaintResponse']['reference'] ;
            ?>
			&nbsp;
		</dd>

        <dt><?php echo __('Treatment'); ?></dt>
		<dd>
			<?php   echo $complaintResponse['Treatment']['name'] ;
            ?>
			&nbsp;
		</dd>


        <dt><?php echo __('Observation'); ?></dt>
        <dd>
            <?php   echo $complaintResponse['ComplaintResponse']['observation'] ;
            ?>
            &nbsp;
        </dd>


	</dl>
</div>