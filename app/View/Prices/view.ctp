





<?php
?><h4 class="page-title"> <?=$price['Price']['wording']; ?></h4>

<div class="box-body main">

	<div class="left_side card-box p-b-0">
		<div class="nav-tabs-custom pdg_btm">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>


			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1">
					<?php if (!empty($price['Price']['wording'])) { ?>

						<dt><?php  echo __('Wording'); ?></dt>
						<dd>
							<?php echo h($price['Price']['wording']); ?>
							&nbsp;
						</dd>
						<br/>
					<?php } ?>
					<dt><?php echo __('Ride'); ?></dt>
					<dd>
						<?php echo $price['DepartureDestination']['name'] .'-'.$price['ArrivalDestination']['name'].'-'. $price['CarType']['name']; ?>
						&nbsp;
					</dd>

						<br>


					<?php if(!empty($priceRideCategories)){

						foreach ($priceRideCategories as $priceRideCategory) {
							if(!empty($priceRideCategory["RideCategory"]['name'])){
							?>

							<dt><?php  echo __('Ride category'); ?></dt>
							<dd>
								<?php echo h($priceRideCategory["RideCategory"]['name']); ?>
								&nbsp;
							</dd>
							<br>
							<?php } ?>

							<dt><?php  echo __('Price HT'); ?></dt>
							<dd>
								<?php echo h($priceRideCategory['PriceRideCategory']['price_ht']); ?>
								&nbsp;
							</dd>
							<br>
							<dt><?php  echo __('Pourcentage price return (%)'); ?></dt>
							<dd>
								<?php echo h($priceRideCategory['PriceRideCategory']['pourcentage_price_return']); ?>
								&nbsp;
							</dd>
							<br>
							<dt><?php  echo __('Price return'); ?></dt>
							<dd>
								<?php echo h($priceRideCategory['PriceRideCategory']['price_return']); ?>
								&nbsp;
							</dd>
							<br>

						<?php }

					} ?>

					<?php if (!empty($price['Price']['start_date'])) { ?>

						<dt><?php echo __('Start date');; ?></dt>
						<dd>
							<?php echo h($this->Time->format($price['Price']['start_date'], '%d-%m-%Y'));; ?>
							&nbsp;
						</dd>
						<br/>
					<?php } ?>

					<?php if (!empty($price['Price']['end_date'])) { ?>

						<dt><?php echo __('End date');; ?></dt>
						<dd>
							<?php echo h($price['Price']['start_date']); ?>
							&nbsp;
						</dd>
						<br/>
					<?php } ?>




				</div>

			</div>
		</div>
	</div>
</div>

