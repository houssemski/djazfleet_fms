<div class="box-body">
<?php
?>
    <br>
    <br>
	<dl class="card-box">
        <dt><?php echo __('Reference'); ?></dt>
        <dd>
            <?php echo h($slip['Slip']['reference']); ?>
            &nbsp;
        </dd>
		<dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($slip['Slip']['date_slip'], '%d-%m-%Y')); ?>
			&nbsp;
		</dd>
        <br>
        <h4><?= __('Missions') ?></h4>
        <table class="table table-striped table-bordered dt-responsive nowrap">
            <thead>
            <tr>
                <th><strong><?php echo __('Date'); ?></strong></th>
                <th><strong><?php echo __('Client'); ?></strong></th>
                <th><strong><?php echo __('Destination'); ?></strong></th>
                <th><strong><?php echo __('N° BL'); ?></strong></th>
                <th><strong><?php echo __('N° Facture'); ?></strong></th>
                <th><strong><?php echo __('Obs'); ?></strong></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($missions as $mission){ ?>
                <tr>
                    <td><?php echo h($this->Time->format($mission['SheetRideDetailRides']['real_start_date'], '%d-%m-%Y')); ?>&nbsp;</td>
                    <td><?php echo h($mission['SheetRideDetailRides']['final_customer']); ?>&nbsp;</td>
                    <td><?php
                        if($mission['SheetRideDetailRides']['type_ride']==2){
                            echo h($mission['Departure']['name'].' - '.$mission['Arrival']['name']);
                        }else {
                            echo h($mission['DepartureDestination']['name'].' - '.$mission['ArrivalDestination']['name']);
                        }
                        ?>&nbsp;</td>
                    <td><?php echo h($mission['SheetRideDetailRides']['number_delivery_note']); ?>&nbsp;</td>
                    <td><?php echo h($mission['SheetRideDetailRides']['number_invoice']); ?>&nbsp;</td>
                    <td><?php echo h($mission['SheetRideDetailRides']['note']); ?>&nbsp;</td>



                </tr>
            <?php }
            ?>

            </tbody>
        </table>
	</dl>
</div>