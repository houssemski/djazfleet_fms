<div class="box-body">
<?php
?><h4 class="page-title"> <?=__('Ride').' '. $ride['DepartureDestination']['name'].'-'.$ride['ArrivalDestination']['name']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Wording'); ?></dt>
		<dd>
			<?php echo h($ride['Ride']['wording']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Departure city'); ?></dt>
		<dd>
			<?php echo h($ride['DepartureDestination']['name']); ?>
			&nbsp;
		</dd>
          <dt><?php echo __('Arrival city'); ?></dt>
		<dd>
			<?php echo h($ride['ArrivalDestination']['name']); ?>
			&nbsp;
		</dd>
               <dt><?php echo __('Distance'); ?></dt>
		<dd>
			<?php echo h($ride['Ride']['distance']); ?>
			&nbsp;
		</dd>
               <dt><?php echo __('Duration'); ?></dt>
		<dd>
			<?php echo h($ride['Ride']['duration']); ?>
			&nbsp;
		</dd>
         
           <dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($ride['Ride']['description']); ?>
			&nbsp;
		</dd>
        
		
	</dl>
</div>