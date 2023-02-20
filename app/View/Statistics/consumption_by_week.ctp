<?php
?><h4 class="page-title"> <?=__('Weekly consumption per car'); ?></h4>
    <div class="box-body">
    <div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
    <div class="card-box p-b-20">
        <?php echo $this->Form->create('Statistic', array(
            'url'=> array(
                'action' => 'consumptionByWeek'
            ),
            'novalidate' => true
        )); ?>
        <div class="filters" id='filters' style='display: block;'>
            <?php
            echo $this->Form->input('car_id', array(
                'label' => __('Car'),
                'class' => 'form-filter select2',
                'id' => 'car',
                'empty' => ''
            ));
            echo $this->Form->input('year', array(
                'label' => '',
                'type' => 'text',
                'class' => 'form-control datemask',
                'before' => '<label class="dte">' . __('Year') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                'after' => '</div>',
                'id' => 'year',
            ));
            ?>
            <div style='clear:both; padding-top: 10px;'></div>
            <?php
            echo $this->Form->input('month', array(
                'label' => '',
                'type' => 'text',
                'class' => 'form-control datemask',
                'before' => '<label class="dte">' . __('Month') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                'after' => '</div>',
                'id' => 'month',
            ));
			$options=array('1'=>__('1st week'),'2'=>__('2nd week'),'3'=>__('3rd week'),'4'=>__('4th week'));
            echo $this->Form->input('week', array(
                'label' => __('Week'),
				'type'=>'select',
				'options'=>$options,
                'class' => 'form-filter',
                'id' => 'week',
                'empty' => ''
            ));
            ?>
            <div style='clear:both; padding-top: 5px;'></div>
            <button style="float: right;" class="btn btn-success btn-trans waves-effect w-md waves-success" type="submit"><?= __('Search') ?></button>
            <div style='clear:both; padding-top: 10px;'></div>
        </div>
        <?php echo $this->Form->end(); ?>
        </div>
        </div>
        </div>

    <div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
    <div class="card-box p-b-20">
        <table class="table table-striped table-bordered" id='table_consumption'>
            <thead style="width: auto">
            <th><?= __('Month') ?></th>
			<th><?= __('Week') ?></th>
            <th><?= __('Coupons Nbr') ?></th>
            <th><?= __('Liter/Coupon') ?></th>
			<th><?= __('Total liter coupon') ?></th>
			<th><?= __('Coupon price') ?></th>
			<th><?= __('Total price coupon') ?></th>
			<th><?= __('Species') ?></th>
			<th><?= __('Consumption liter') ?></th>
            <th><?= __('Species card') ?></th>
			<th><?= __('Total consumption liter') ?></th>
            <th><?= __('Total') ?></th>
            <th><?= __('Departure km') ?></th>
            <th><?= __('Arrival km') ?></th>
            <th><?= __('Kms / Month') ?></th>
            <th><?= __('Cons / 100kms') ?></th>
            </thead>
            <tbody>
            <?php
            $array1=array(1,2,3,4,5,6,7,8);
			$array2=array(9,10,11,12,13,14,15,16);
			$array3=array(17,18,19,20,21,22,23,24);
			$array4=array(25,26,27,28,29,30,31);
			
			$all_total= 0;
			$all_coupon=0;
			$all_tank=0;
			$all_species=0;
			$all_species_card=0;
			$total_car=0;
			$total_car_1=0;
			$graphe=array();
            foreach ($cars as $key => $value) {
			
			
                if ($results) {
                    foreach ($results as $result) {
					
                        if ($result['car'] == $key) {
                            echo "<tr style='width: auto;'>" .
                                "<td colspan='16' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
background-color: rgba(16, 196, 105, 0.15) !important;
color: #10c469 !important;font-weight:bold;'>"
                                . $value . "</td></tr>";
                            for ($i = 1; $i <= 12; $i++) {
                                switch ($i) {
                                    case 1 :
										
                                        $label = __("January");
                                        break;
                                    case 2 :
									
										
                                        $label = __("February");
                                        break;
                                    case 3 :
										
                                        $label = __("March");
                                        break;
                                    case 4 :
										
                                        $label = __("April");
                                        break;
                                    case 5 :
									
										
                                        $label = __("May");
                                        break;
                                    case 6 :
										
                                        $label = __("June");
                                        break;
                                    case 7 :
										
                                        $label = __("July");
                                        break;
                                    case 8 :
                                        $label = __("August");
                                        break;
                                    case 9 :
                                        $label = __("September");
                                        break;
                                    case 10 :
                                        $label = __("October");
                                        break;
                                    case 11 :
                                        $label = __("November");
                                        break;
                                    case 12 :
                                        $label = __("December");
                                        break;
                                }
                                if (isset($result[$i]['month']) && $result[$i]['month'] == $i) {
									
									
											$litersByCoupon = $coupon_price / $result['price'];
									if(isset($result[$i]['week1']))	{
                                    $totalLitersCoupon1 = $result[$i]['coupons_number1'] * $litersByCoupon;
									if($result[$i]['species1']>0){
									$totalLitersSpecies1 = $result[$i]['species1'] / $result['price'];
									}else $totalLitersSpecies1=0;

                                     if($result[$i]['speciesCard1']>0){
									$totalLitersSpeciesCard1 = $result[$i]['speciesCard1'] / $result['price'];
									}else $totalLitersSpeciesCard1=0;
                                    $totalPriceCoupon1 = $coupon_price * $result[$i]['coupons_number1'];
									$totalPricetank1 = $result[$i]['liter_tank1']*$result['price'];
									$total1=$totalPriceCoupon1+ $totalPricetank1+ $result[$i]['species1']+ $result[$i]['speciesCard1'];
									$totalLiters1 = $totalLitersCoupon1 + $totalLitersSpecies1 + $result[$i]['liter_tank1'] +$totalLitersSpeciesCard1;
                                    $diffKm1 = $result[$i]['arrivalKm1'] - $result[$i]['departureKm1'];
                                    if($diffKm1 <= 0) {
                                        $diffKm1 = 0;
                                        $consumptionPer100km1 = 0;
                                    }else{
                                        $consumptionPer100km1 = ($totalLiters1 * 100) / $diffKm1;
                                    }
                                    echo "<tr><td>" . $label . "</td>";
									echo "<td>" . __('1st week') . "</td>";
                                    echo "<td class='right'>" . $result[$i]['coupons_number1'] . "</td>";
                                    echo "<td class='right'>" . number_format($litersByCoupon, 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($totalLitersCoupon1, 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($coupon_price, 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($totalPriceCoupon1, 2, ",", ".") . "</td>";
									echo "<td class='right'>" . number_format($result[$i]['species1'] , 2, ",", ".") . "</td>";
									echo "<td class='right'>" . number_format($result[$i]['liter_tank1'] , 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($result[$i]['speciesCard1'] , 2, ",", ".") . "</td>";
									echo "<td class='right'>" . number_format($totalPricetank1 , 2, ",", ".") . "</td>";
									echo "<td class='right'>" . number_format($total1 , 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($result[$i]['departureKm1'], 0, ",", ".") .
                                        "</td>";
                                    echo "<td class='right'>" . number_format($result[$i]['arrivalKm1'], 0, ",", ".") .
                                        "</td>";
                                    echo "<td class='right'>" . number_format($diffKm1, 0, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($consumptionPer100km1, 2, ",", ".") .
                                        "</td></tr>";
										
									$all_coupon= $all_coupon + $result[$i]['coupons_number1'];
									$all_tank = $all_tank + $result[$i]['liter_tank1'];
									$all_species = $all_species + $result[$i]['species1'];
									$all_species_card = $all_species + $result[$i]['speciesCard1'];
									$all_total=$all_total+$total1;
									$total_car=$total_car+$total1;
									
									}
									if(isset($result[$i]['week2']))	{
                                    $totalLitersCoupon2 = $result[$i]['coupons_number2'] * $litersByCoupon;
									if($result[$i]['species2']>0){
									$totalLitersSpecies2 = $result[$i]['species2'] / $result['price'];
									} else $totalLitersSpecies2=0;

                                    if($result[$i]['speciesCard2']>0){
									$totalLitersSpeciesCard2 = $result[$i]['speciesCard2'] / $result['price'];
									} else $totalLitersSpeciesCard2=0;
                                    $totalPriceCoupon2 = $coupon_price * $result[$i]['coupons_number2'];
									$totalPricetank2 = $result[$i]['liter_tank2']*$result['price'];
									$total2=$totalPriceCoupon2+ $totalPricetank2+ $result[$i]['species2']+ $result[$i]['speciesCard2'];
									$totalLiters2 = $totalLitersCoupon2 + $totalLitersSpecies2+ $totalLitersSpeciesCard2 + $result[$i]['liter_tank2'];
                                    $diffKm2 = $result[$i]['arrivalKm2'] - $result[$i]['departureKm2'];
                                    if($diffKm2 <= 0) {
                                        $diffKm2 = 0;
                                        $consumptionPer100km2 = 0;
                                    }else{
                                        $consumptionPer100km2 = ($totalLiters2 * 100) / $diffKm2;
                                    }
                                    echo "<tr><td>" . $label . "</td>";
									echo "<td>" .  __('2nd week') . "</td>";
                                    echo "<td class='right'>" . $result[$i]['coupons_number2'] . "</td>";
                                    echo "<td class='right'>" . number_format($litersByCoupon, 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($totalLitersCoupon2, 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($coupon_price, 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($totalPriceCoupon2, 2, ",", ".") . "</td>";
									echo "<td class='right'>" . number_format($result[$i]['species2'] , 2, ",", ".") . "</td>";
									echo "<td class='right'>" . number_format($result[$i]['liter_tank2'] , 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($result[$i]['speciesCard2'] , 2, ",", ".") . "</td>";
									echo "<td class='right'>" . number_format($totalPricetank2 , 2, ",", ".") . "</td>";
									echo "<td class='right'>" . number_format($total2 , 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($result[$i]['departureKm2'], 0, ",", ".") .
                                        "</td>";
                                    echo "<td class='right'>" . number_format($result[$i]['arrivalKm2'], 0, ",", ".") .
                                        "</td>";
                                    echo "<td class='right'>" . number_format($diffKm2, 0, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($consumptionPer100km2, 2, ",", ".") .
                                        "</td></tr>";
										
									$all_coupon= $all_coupon + $result[$i]['coupons_number2'];
									$all_tank = $all_tank + $result[$i]['liter_tank2'];
									$all_species = $all_species + $result[$i]['species2'];
									$all_species_card = $all_species + $result[$i]['speciesCard2'];
									$all_total=$all_total+$total2;
									$total_car=$total_car+$total2;
									}
									
									if(isset($result[$i]['week3']))	{
                                    $totalLitersCoupon3 = $result[$i]['coupons_number3'] * $litersByCoupon;
									if($result[$i]['species3']>0){
									$totalLitersSpecies3 = $result[$i]['species3'] / $result['price'];
									} else $totalLitersSpecies3=0;

                                    if($result[$i]['speciesCard3']>0){
									$totalLitersSpeciesCard3 = $result[$i]['speciesCard3'] / $result['price'];
									} else $totalLitersSpeciesCard3=0;
                                    $totalPriceCoupon3 = $coupon_price * $result[$i]['coupons_number3'];
									$totalPricetank3 = $result[$i]['liter_tank3']*$result['price'];
									$total3=$totalPriceCoupon3+ $totalPricetank3+ $result[$i]['species3']+ $result[$i]['speciesCard3'];
									$totalLiters3 = $totalLitersCoupon3 + $totalLitersSpecies3 + $totalLitersSpeciesCard3 + $result[$i]['liter_tank3'];
                                    $diffKm3 = $result[$i]['arrivalKm3'] - $result[$i]['departureKm3'];
                                    if($diffKm3 <= 0) {
                                        $diffKm3 = 0;
                                        $consumptionPer100km3 = 0;
                                    }else{
                                        $consumptionPer100km3 = ($totalLiters3 * 100) / $diffKm3;
                                    }
                                    echo "<tr><td>" . $label . "</td>";
									echo "<td>" .  __('3rd week') . "</td>";
                                    echo "<td class='right'>" . $result[$i]['coupons_number3'] . "</td>";
                                    echo "<td class='right'>" . number_format($litersByCoupon, 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($totalLitersCoupon3, 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($coupon_price, 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($totalPriceCoupon3, 2, ",", ".") . "</td>";
									echo "<td class='right'>" . number_format($result[$i]['species3'] , 2, ",", ".") . "</td>";
									echo "<td class='right'>" . number_format($result[$i]['liter_tank3'] , 2, ",", ".") . "</td>";
                                        echo "<td class='right'>" . number_format($result[$i]['speciesCard3'] , 2, ",", ".") . "</td>";
									echo "<td class='right'>" . number_format($totalPricetank3 , 2, ",", ".") . "</td>";
									echo "<td class='right'>" . number_format($total3 , 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($result[$i]['departureKm3'], 0, ",", ".") .
                                        "</td>";
                                    echo "<td class='right'>" . number_format($result[$i]['arrivalKm3'], 0, ",", ".") .
                                        "</td>";
                                    echo "<td class='right'>" . number_format($diffKm3, 0, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($consumptionPer100km3, 2, ",", ".") .
                                        "</td></tr>";
									
									$all_coupon= $all_coupon + $result[$i]['coupons_number3'];
									$all_tank = $all_tank + $result[$i]['liter_tank3'];
									$all_species = $all_species + $result[$i]['species3'];
									$all_species_card = $all_species + $result[$i]['speciesCard3'];
									$all_total=$all_total+$total3;
									$total_car=$total_car+$total3;
									}
									
									if(isset($result[$i]['week4']))	{
									$totalLitersCoupon4 = $result[$i]['coupons_number4'] * $litersByCoupon;
									if($result[$i]['species4']>0){
									$totalLitersSpecies4 = $result[$i]['species4'] / $result['price'];
									} $totalLitersSpecies4 =0;

                                    if($result[$i]['speciesCard4']>0){
									$totalLitersSpeciesCard4 = $result[$i]['speciesCard4'] / $result['price'];
									} $totalLitersSpeciesCard4 =0;
                                    $totalPriceCoupon4 = $coupon_price * $result[$i]['coupons_number4'];
									$totalPricetank4 = $result[$i]['liter_tank4']*$result['price'];
									$total4=$totalPriceCoupon4+ $totalPricetank4+ $result[$i]['species4']+ $result[$i]['speciesCard4'];
									$totalLiters4 = $totalLitersCoupon4 + $totalLitersSpecies4+ $totalLitersSpeciesCard4 + $result[$i]['liter_tank4'];
                                    $diffKm4 = $result[$i]['arrivalKm4'] - $result[$i]['departureKm4'];
                                    if($diffKm4 <= 0) {
                                        $diffKm4 = 0;
                                        $consumptionPer100km4 = 0;
                                    }else{
                                        $consumptionPer100km4 = ($totalLiters4 * 100) / $diffKm4;
                                    }
                                    echo "<tr><td>" . $label . "</td>";
									echo "<td>" .  __('4th week') . "</td>";
                                    echo "<td class='right'>" . $result[$i]['coupons_number4'] . "</td>";
                                    echo "<td class='right'>" . number_format($litersByCoupon, 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($totalLitersCoupon4, 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($coupon_price, 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($totalPriceCoupon4, 2, ",", ".") . "</td>";
									echo "<td class='right'>" . number_format($result[$i]['species4'] , 2, ",", ".") . "</td>";
									echo "<td class='right'>" . number_format($result[$i]['liter_tank4'] , 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($result[$i]['speciesCard4'] , 2, ",", ".") . "</td>";
									echo "<td class='right'>" . number_format($totalPricetank4 , 2, ",", ".") . "</td>";
									echo "<td class='right'>" . number_format($total4 , 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($result[$i]['departureKm4'], 0, ",", ".") .
                                        "</td>";
                                    echo "<td class='right'>" . number_format($result[$i]['arrivalKm4'], 0, ",", ".") .
                                        "</td>";
                                    echo "<td class='right'>" . number_format($diffKm4, 0, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($consumptionPer100km4, 2, ",", ".") .
                                        "</td></tr>";
										
									$all_coupon= $all_coupon + $result[$i]['coupons_number4'];
									$all_tank = $all_tank + $result[$i]['liter_tank4'];
									$all_species = $all_species + $result[$i]['species4'];
									$all_species_card = $all_species + $result[$i]['speciesCard4'];
									$all_total=$all_total+$total4;
									$total_car=$total_car+$total4;
									}
									
									
									
									}
                                   
                                   
                                }
								
								
						  ?>
						  
						  <tr style='width: auto;'> <td colspan='16' style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>".__('Total')."</span>" .$total_car. " " . $this->Session->read("currency"); ?></td></tr>
							
                        <?php  
						$graphe[$total_car]=$value;
						
						$total_car=0;
								
								
								
                            }
                        }
                    }
                }
            
            ?>
            </tbody>
        </table>
		<br/><br/>
		<?php echo "<b style='float:left ; line-height:35px'>".__('Total consumed coupons :  ')."</b> &nbsp <b style='color:#10c469; ; line-height:35px'>"  .number_format($all_coupon,2,",","."). " " .__('Coupons')."</b> "; ?>
		<br/>
		<?php echo "<b style='float:left ; line-height:35px'>".__('Total species : ')."</b>  &nbsp <b style='color:#10c469; line-height:35px'>" .number_format($all_species,2,",","."). " " . $this->Session->read("currency")."</b> "; ?>
		<br/>
		<?php echo "<b style='float:left ; line-height:35px'>".__('Total liters :  ')."</b>  &nbsp <b style='color:#10c469 ; line-height:35px'>" .number_format($all_tank,2,",","."). " " .__('Liter')."</b> "; ?>
		<br/>
		<?php echo "<b style='float:left ; line-height:35px'>".__('Consumptions sum :  ')."</b>  &nbsp <b style='color:#10c469 ; line-height:35px'>" .number_format($all_total,2,",","."). " " . $this->Session->read("currency")."</b> "; ?>
		
		</div>
		</div>
		</div>
		<div class="box box-primary">
                                <div class="box-header">
                                    <i class="fa fa-bar-chart-o"></i>
                                    <h3 class="box-title"><?php __('Histogram') ?></h3>
                                </div>
                                <div class="box-body">
                                    <div id="bar-chart" style="height: 300px;"></div>
                                </div><!-- /.box-body-->
                            </div><!-- /.box -->
    </div>
<?php $this->start('script'); ?>
    <!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
 <?= $this->Html->script('tableExport/tableExport'); ?>
    <?= $this->Html->script('tableExport/jquery.base64'); ?>

    <?= $this->Html->script('tableExport/html2canvas'); ?>
    <?= $this->Html->script('tableExport/jspdf/jspdf'); ?>
    <?= $this->Html->script('tableExport/jspdf/libs/sprintf'); ?>
    <?= $this->Html->script('tableExport/jspdf/libs/base64'); ?>
	
	<!-- FLOT CHARTS -->
         <?= $this->Html->script('plugins/flot/jquery.flot.min'); ?>
        <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
        <?= $this->Html->script('plugins/flot/jquery.flot.resize.min'); ?>
        <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
        <?= $this->Html->script('plugins/flot/jquery.flot.pie.min'); ?>
        <!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
        <?= $this->Html->script('plugins/flot/jquery.flot.categories.min'); ?>
    <!-- Page script -->
    <script type="text/javascript">

        $(document).ready(function() {
            jQuery("#startdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            jQuery("#enddate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            jQuery("#month").inputmask("m", {"placeholder": "mm"});



        });

        
             function exportDataPdf() {
            var consumption_month = new Array();
            consumption_month[0] = jQuery('#car').val();
            consumption_month[1] = jQuery('#year').val();
            consumption_month[2] = jQuery('#min_month').val();
            consumption_month[3] = jQuery('#max_month').val();
            
            var url = '<?php echo $this->Html->url(array('action' => 'consumptionbymonth_pdf', 'ext' => 'pdf'))?>';
            var form = jQuery('<form action="' + url + '" method="post" >' +
            '<input type="text" name="consumptionmonth" value="' + consumption_month + '" />' +
            '</form>');
            jQuery('body').append(form);
            form.submit();

       

    }

       function exportDataExcel() {

    $('#table_consumption').tableExport({

        type: 'excel',
        espace: 'false',
        htmlContent:'false'
});

}

 /*
                 * BAR CHART
                 * ---------
                 */

                var bar_data = {
                    data: [
					<?php
					$a=count($graphe);
					$i=0;	
					foreach($graphe as $key => $value){
					$i++;
					if($i==$a){
					echo "['$value', $key]";	
					}else{
					echo "['$value', $key],";	
					}
					}
					?>
					],
                    color: "#3c8dbc"
                };
                $.plot("#bar-chart", [bar_data], {
                    grid: {
                        borderWidth: 1,
                        borderColor: "#f3f3f3",
                        tickColor: "#f3f3f3"
                    },
                    series: {
                        bars: {
                            show: true,
                            barWidth: 0.5,
                            align: "center"
                        }
                    },
                    xaxis: {
                        mode: "categories",
                        tickLength: 0
                    }
                });
                /* END BAR CHART */

            
    </script>
<?php $this->end(); ?>