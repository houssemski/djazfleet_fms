
<?php
?><h4 class="page-title"> <?=$detailRide['DepartureDestination']['name'] .'-'.$detailRide['ArrivalDestination']['name'].'-'.$detailRide['CarType']['name']; ?></h4>







<div class="box-body main">

	<div class="left_side card-box ">
		<div class="nav-tabs-custom pdg_btm">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>


			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1">
					<?php if (!empty($detailRide['DetailRide']['wording'])) { ?>

						<dt><?php  echo __('Wording'); ?></dt>
						<dd>
							<?php echo h($detailRide['DetailRide']['wording']); ?>
							&nbsp;
						</dd>
						<br/>
					<?php } ?>
					<dt><?php echo __('Ride'); ?></dt>
					<dd>
						<?php echo $detailRide['DepartureDestination']['name'] .'-'.$detailRide['ArrivalDestination']['name']; ?>
						&nbsp;
					</dd>
					<br/>
					<?php if (!empty($detailRide['CarType']['name'])) { ?>

						<dt><?php echo __('Car type'); ?></dt>
						<dd>
							<?php echo h($detailRide['CarType']['name']); ?>
							&nbsp;
						</dd>
						<br/>
					<?php } ?>
					<?php if (!empty($detailRide['DetailRide']['premium'])) { ?>

						<dt><?php  echo __('Premium'); ?></dt>
						<dd>
							<?php echo h($detailRide['DetailRide']['premium']); ?>
							&nbsp;
						</dd>
						<br/>
					<?php } ?>

					<?php if(!empty($missionCosts)){

						foreach ($missionCosts as $missionCost) {
						?>

							<dt><?php  echo __('Ride category'); ?></dt>
							<dd>
								<?php echo h($missionCost["RideCategory"]['name']); ?>
								&nbsp;
							</dd>
							<br>

							<dt><?php  echo __('Mission costs truck full'); ?></dt>
							<dd>
								<?php echo h($missionCost['MissionCost']['cost_truck_full']); ?>
								&nbsp;
							</dd>
							<br>
							<dt><?php  echo __('Mission costs truck empty'); ?></dt>
							<dd>
								<?php echo h($missionCost['MissionCost']['cost_truck_empty']); ?>
								&nbsp;
							</dd>
							<br>

					<?php }

					} ?>

					<?php if (!empty($detailRide['DetailRide']['description'])) { ?>

						<dt><?php echo __('Description');; ?></dt>
						<dd>
							<?php echo h($detailRide['DetailRide']['description']); ?>
							&nbsp;
						</dd>
						<br/>
					<?php } ?>




				</div>

			</div>
		</div>
	</div>
</div>

