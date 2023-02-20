
<h4 class="page-title"><?php echo __("Bill Fuel log N &deg;")." " .$fuellog['FuelLog']['num_bill']; ?></h4>
<div class="row">
	<!-- BASIC WIZARD -->
	<div class="col-lg-12">
	<div class="card-box">

        <dt id="dt-a"><?php echo __('Num bill'); ?></dt>
		<dd>
			<?php echo h($fuellog['FuelLog']['num_bill']); ?>
			&nbsp;
		</dd>
        </br>
        <?php if (isset($fuellog['FuelLog']['nb_fuellog']) && !empty($fuellog['FuelLog']['nb_fuellog'])) { ?>
        <dt id="dt-b"><?php echo __('Number fuellog'); ?></dt>
		<dd>
			<?php echo h($fuellog['FuelLog']['nb_fuellog']); ?>
			&nbsp;
		</dd>
            </br>
        <?php }?>
		<dt id="dt-c"><?php echo __('Num fuellog'); ?></dt>
		<dd>
			<?php echo h($fuellog['FuelLog']['num_fuellog']); ?>
			&nbsp;
		</dd>
		</br>
        <?php if (isset($fuellog['FuelLog']['price_coupon']) && !empty($fuellog['FuelLog']['price_coupon'])) { ?>
        <dt id="dt-d"><?php echo __('Coupon price'); ?></dt>
		<dd>
			<?php echo h($fuellog['FuelLog']['price_coupon']); ?>
			&nbsp;
		</dd>
            </br>
        <?php }?>
    
		<dt id="dt-e"><?php echo __('First number coupon'); ?></dt>
		<dd>
			<?php echo h($fuellog['FuelLog']['first_number_coupon']); ?>
			&nbsp;
		</dd>
        </br>
        <dt id="dt-f"><?php echo __('Last number coupon'); ?></dt>
		<dd>
			<?php echo h($fuellog['FuelLog']['last_number_coupon']); ?>
			&nbsp;
		</dd>
      
        <?php if (isset($fuellog['FuelLog']['date']) && !empty($fuellog['FuelLog']['date'])) { ?>
                        <br/>
                        <dt id="dt-g"><?php echo __('Purchase date'); ?></dt>
                        <dd>
                            <?php echo $this->Time->format($fuellog['FuelLog']['date'], '%d-%m-%Y'); ?>
                            &nbsp;
                        </dd>
                        <?php }?>
		</br>
		
	</div>
   
</div>
	</div>