<?php

?><h4 class="page-title"> <?=__('Sheet ride');

?>
<style> 

section.content {
overflow-x: scroll;
}
#table_rides{
width:200%;
max-width: 200%;
}
</style>

<div id='message'></div>
<?php if(empty($sheetRideDetailRides)) {?>
<table  class="table table-bordered " id='table_rides'>
						<thead>
							<tr>
								
								<th><?=__('Ride')?></th>
                                <th><?=__('Transportation')?></th>
								
                                <th class='required'><label><?=__('Car')?></label></th>
                                <th><?=__('Remorque')?></th>
                                <th class='required'><label><?=__("Customer")?></label></th>
                                
                                <th><?=__('Customer help')?></th>
                                
                                <th><?=__('Planned Departure date')?></th>
								<th><?=__('Real Departure date')?></th>
								<th><?=__('Departure Km')?></th>
                                
								<th><?=__('Planned Arrival date ')?></th>
								<th><?=__('Real Arrival date')?></th>
								<th><?=__('Arrival Km estimated')?></th>
                                <th><?=__('Arrival Km')?></th>
								<th class="actions"><?=__('Actions')?></th>
								
							</tr>
						</thead>
						<tbody id='rides-tbody'>
							<?php  
                            
                            
                            $nb_trucks=$TransportBillDetailRide['TransportBillDetailRides']['nb_trucks'];
							
					echo "<div >".$this->Form->input('id', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$TransportBillDetailRide['TransportBillDetailRides']['id'],
                    'id'=>'id'
                    ))."</div>";

                    echo "<div >".$this->Form->input('nb_trucks', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$nb_trucks,
                    'id'=>'nb_trucks'
                    ))."</div>";
                     
                            for($i=1; $i<=$nb_trucks; $i++){


?>
                            <tr>
                  
			<td>
            <?php echo "<div style='padding-top: 25px;'>". $TransportBillDetailRide['DepartureDestination']['name'].'-'.$TransportBillDetailRide['ArrivalDestination']['name']."</div>";
			
			  echo "<div >".$this->Form->input('num_truck', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$i,
                    'id'=> 'num_truck'.$i,
                    
                    ))."</div>";
			
			 echo "<div >".$this->Form->input('SheetRideDetailRides.'.$i.'.id', array(
                    'label' => '',
                    //'type' => 'hidden',
                    
                    'id'=> 'sheet_ride_detail_ride_id'.$i,
                    
                    ))."</div>";
			echo "<div >".$this->Form->input('SheetRide.'.$i.'.id', array(
                    'label' => '',
                    //'type' => 'hidden',
                    
                    'id'=> 'sheet_ride_id'.$i,
                    
                    ))."</div>";
					
			
             echo "<div >".$this->Form->input('SheetRideDetailRides.'.$i.'.detail_ride_id', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$TransportBillDetailRide['TransportBillDetailRides']['detail_ride_id'],
                    'id'=> 'detail_ride_id'.$i,
                   
                    ))."</div>";
             echo "<div >".$this->Form->input('SheetRideDetailRides.'.$i.'.supplier_id', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$TransportBillDetailRide['Supplier']['id'],
                    'id'=> 'supplier_id'.$i,
                    
                    ))."</div>";
             echo "<div >".$this->Form->input('SheetRideDetailRides.'.$i.'.supplier_final_id', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$TransportBillDetailRide['SupplierFinal']['id'],
                    'id'=> 'supplier_final_id'.$i,
                    
                    ))."</div>";
					
			

            ?>



            </td>
			<td>

               <?php  
			  
			    echo "<div style='padding-top: 25px;'>". $TransportBillDetailRide['CarType']['name']."</div>";
               
            
					echo "<div >".$this->Form->input('SheetRide.'.$i.'.car_type_id', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$TransportBillDetailRide['CarType']['id'],
                    'id'=> 'car_type'.$i,
                    
                    ))."</div>";

             echo "<div class='form-group'>".$this->Form->input('duration_day', array(
                 'label' => '',
                'value'=>$TransportBillDetailRide['DetailRide']['duration_day'],
                'readonly'=>true,
                'type'=>'hidden',
				'id'=>'duration_day'.$i,
                'class' => 'form-control',
                ))."</div>"; 

                       echo "<div class='form-group'>".$this->Form->input('duration_hour', array(
                'label' => '',
                'readonly'=>true,
                'type'=>'hidden',
                'value'=>$TransportBillDetailRide['DetailRide']['duration_hour'],
				'id'=>'duration_hour'.$i,
                'class' => 'form-control',
                ))."</div>";


                       echo "<div class='form-group '>".$this->Form->input('duration_minute', array(
                'label' => '',
                'readonly'=>true,
                'type'=>'hidden',
                'value'=>$TransportBillDetailRide['DetailRide']['duration_minute'],
				'id'=>'duration_minute'.$i,
                'class' => 'form-control '
                ))."</div>"; 

                      echo "<div class='form-group '>".$this->Form->input('distance', array(
                 'label' => '',
                'readonly'=>true,
                'type'=>'hidden',
                'value'=>$TransportBillDetailRide['Ride']['distance'],
				'id'=>'distance'.$i,
                'class' => 'form-control',
                ))."</div>";   




            ?>


            </td>
			

             <td>
             <?php  echo "<div class='form-group '>" . $this->Form->input('SheetRide.'.$i.'.car_id', array(
                    'label' => '',
                    'class' => 'form-control select2',
                    'empty' => '',
					'onchange'=>'javascript:carChanged(this.id), verifyStatusCar(this.id);',
                    'id' => 'cars'.$i,
                        )) . "</div>"; ?>

            </td>
            <td>
           <?php echo "<div class='form-group' id='remorques-div$i'>" . $this->Form->input('SheetRide.'.$i.'.remorque_id', array(
                    'label' => '',
                    'options'=>$remorques,
                    'class' => 'form-control',
                    'empty' => '',
                    'id' => 'remorques'.$i,
                )) . "</div>"; ?>

            </td>
			<td>
            <?php echo "<div class='form-group' id='customers-div$i'>" . $this->Form->input('SheetRide.'.$i.'.customer_id', array(
                    'label' =>"",
                    'class' => 'form-control',
                    'empty' => '',
                    'id' => 'customers'.$i,
                )) . "</div>"; ?>


            </td>
			<td>

             <?php echo "<div class='form-group'>".$this->Form->input('SheetRide.'.$i.'.customer_help', array(
                    'label' =>' ',
                    'type'=>'select',
                    'options'=>$customers,
                    'empty'=>'',
                     'id' => 'customer_help'.$i,
                    'class' => 'form-control',
                    ))."</div>"; ?>

            </td>
      
			<td>
            <?php 
			$date=date("Y-m-d", strtotime('+1 day'));
               $date=date($date.' 02:00');
             echo "<div class='form-group '>" . $this->Form->input('SheetRideDetailRides.'.$i.'.planned_start_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                'type' => 'text',
								'value'=>$this->Time->format($date, '%d/%m/%Y %H%M'),
                                 'class' => 'form-control datemask',
                                'before' => '<label>' . '' . '</label><div class="input-group date"><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                               
								'onchange'=>'javascript:calculPlannedArrivalDate(this.id);',
                                'id' => 'planned_start_date'.$i,
                            )) . "</div>";

            ?>
            </td>
			<td>
               <?php 
             echo "<div class='form-group '>" . $this->Form->input('SheetRideDetailRides.'.$i.'.real_start_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                'type' => 'text',
                                  'class' => 'form-control datemask',
                                'before' => '<label>' . '' . '</label><div class="input-group date"><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                              
								'onchange'=>'javascript:calculPlannedArrivalDate(this.id), verifyStatusCar(this.id);',
                                'id' => 'real_start_date'.$i,
                            )) . "</div>";

            ?>


            </td>
			<td>

            <?php 
              echo "<div >".$this->Form->input('SheetRideDetailRides.'.$i.'.km_departure', array(
                    'label' => '',
                    'class' => 'form-control',
                    'onchange'=>'javascript:calculKmArrivalEstimated(this.id);',
                    'id'=>'km_departure'.$i,
                    'placeholder'=>__('Enter km departure')
                    ))."</div>";
            ?>

            </td>

            <td>
            <?php 
             echo "<div class='form-group '>" . $this->Form->input('SheetRideDetailRides.'.$i.'.planned_end_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                'type' => 'text',
                                  'class' => 'form-control datemask',
                                'before' => '<label>' . '' . '</label><div class="input-group date"><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                               
								
                                'id' => 'planned_end_date'.$i,
                            )) . "</div>";

            ?>
            </td>
			<td>
               <?php 
             echo "<div class='form-group '>" . $this->Form->input('SheetRideDetailRides.'.$i.'.real_end_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                'type' => 'text',
                                  'class' => 'form-control datemask',
                                'before' => '<label>' . '' . '</label><div class="input-group date"><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                              
								
                                'id' => 'real_end_date'.$i,
                            )) . "</div>";

            ?>


            </td>
            <td>
            <?php	echo "<div class='form-group '>".$this->Form->input('SheetRideDetailRides.'.$i.'.km_arrival_estimated', array(
                'label' => '',
                'readonly'=>true,
                'placeholder'=>__('Km arrival estimated'),
                'id'=>'km_arrival_estimated'.$i,
                'class' => 'form-control',
                ))."</div>"; ?>

            </td>
            <td>
				
			<?php		echo "<div class='form-group '>".$this->Form->input('SheetRideDetailRides.'.$i.'.km_arrival', array(
                'label' => '',
                'placeholder'=>__('Enter km arrival'),
                'id'=>'km_arrival'.$i,
                'class' => 'form-control',
                ))."</div>"; ?>

            </td>
			<td class="actions">
            <?php echo "<div style='padding-top: 25px;' id='save_edit$i'>";
              echo $this->Html->link(
                        '<i class="fa fa-save" title="' . __('Save') . '"></i>',
                        'javascript:;',
                        array('escape' => false, 'id' =>''.$i, 'onclick'=>'javascript:save(this.id);'));
                  echo "</div>";
                 ?>
            </td>
                              </tr>


                         <?php   } ?>
						</tbody>
						
					</table>
<?php }else {?>


<table  class="table table-bordered " id='table_rides'>
						<thead>
							<tr>
								
								<th><?=__('Ride')?></th>
                                <th><?=__('Transportation')?></th>
								
                                <th class='required'><label><?=__('Car')?></label></th>
                                <th><?=__('Remorque')?></th>
                                <th class='required'><label><?=__("Customer")?></label></th>
                                
                                <th><?=__('Customer help')?></th>
                                
                                <th><?=__('Planned Departure date')?></th>
								<th><?=__('Real Departure date')?></th>
								<th><?=__('Departure Km')?></th>
                                
								<th><?=__('Planned Arrival date ')?></th>
								<th><?=__('Real Arrival date')?></th>
								<th><?=__('Arrival Km estimated')?></th>
                                <th><?=__('Arrival Km')?></th>
								<th class="actions"><?=__('Actions')?></th>
								
							</tr>
						</thead>
						<tbody id='rides-tbody'>
							<?php  
                            
                            
                            $nb_trucks=$TransportBillDetailRide['TransportBillDetailRides']['nb_trucks'];
							
					echo "<div >".$this->Form->input('id', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$TransportBillDetailRide['TransportBillDetailRides']['id'],
                    'id'=>'id'
                    ))."</div>";

                    echo "<div >".$this->Form->input('nb_trucks', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$nb_trucks,
                    'id'=>'nb_trucks'
                    ))."</div>";
                     $nb_trucks_validated=0;
                            foreach($sheetRideDetailRides as $sheetRideDetailRide){


?>
                            <tr>
                  
			<td>
            <?php echo "<div style='padding-top: 25px;'>". $sheetRideDetailRide['DepartureDestination']['name'].'-'.$sheetRideDetailRide['ArrivalDestination']['name']."</div>";
			$nb_trucks_validated++;
			  echo "<div >".$this->Form->input('num_truck', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$nb_trucks_validated,
                    'id'=> 'num_truck'.$nb_trucks_validated,
                    
                    ))."</div>";
			
			 echo "<div >".$this->Form->input('SheetRideDetailRides.'.$nb_trucks_validated.'.id', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$sheetRideDetailRide['SheetRideDetailRides']['id'],
                    'id'=> 'sheet_ride_detail_ride_id'.$nb_trucks_validated,
                    
                    ))."</div>";
			echo "<div >".$this->Form->input('SheetRide.'.$nb_trucks_validated.'.id', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$sheetRideDetailRide['SheetRide']['id'],
                    'id'=> 'sheet_ride_id'.$nb_trucks_validated,
                    
                    ))."</div>";
					
					 
             echo "<div >".$this->Form->input('SheetRideDetailRides.'.$nb_trucks_validated.'.detail_ride_id', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'],
                    'id'=> 'detail_ride_id'.$nb_trucks_validated,
                    
                    ))."</div>";
             echo "<div >".$this->Form->input('SheetRideDetailRides.'.$nb_trucks_validated.'.supplier_id', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$sheetRideDetailRide['Supplier']['id'],
                    'id'=> 'supplier_id'.$nb_trucks_validated,
                    
                    ))."</div>";
             echo "<div >".$this->Form->input('SheetRideDetailRides.'.$nb_trucks_validated.'.supplier_final_id', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$sheetRideDetailRide['SupplierFinal']['id'],
                    'id'=> 'supplier_final_id'.$nb_trucks_validated,
                    
                    ))."</div>";

            ?>



            </td>
			<td>

               <?php  
			   echo "<div style='padding-top: 25px;'>". $sheetRideDetailRide['CarType']['name']."</div>";
			 
             echo "<div >".$this->Form->input('SheetRide.'.$nb_trucks_validated.'.car_type_id', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$TransportBillDetailRide['CarType']['id'],
                    'id'=> 'car_type'.$nb_trucks_validated,
                    ))."</div>";


             echo "<div class='form-group'>".$this->Form->input('duration_day', array(
                 'label' => '',
                'value'=>$sheetRideDetailRide['DetailRide']['duration_day'],
                'readonly'=>true,
                'type'=>'hidden',
				'id'=>'duration_day'.$nb_trucks_validated,
                'class' => 'form-control',
                ))."</div>"; 

                       echo "<div class='form-group'>".$this->Form->input('duration_hour', array(
                'label' => '',
                'readonly'=>true,
                'type'=>'hidden',
                'value'=>$sheetRideDetailRide['DetailRide']['duration_hour'],
				'id'=>'duration_hour'.$nb_trucks_validated,
                'class' => 'form-control',
                ))."</div>";


                       echo "<div class='form-group '>".$this->Form->input('duration_minute', array(
                'label' => '',
                'readonly'=>true,
                'type'=>'hidden',
                'value'=>$sheetRideDetailRide['DetailRide']['duration_minute'],
				'id'=>'duration_minute'.$nb_trucks_validated,
                'class' => 'form-control '
                ))."</div>"; 

                      echo "<div class='form-group '>".$this->Form->input('distance', array(
                 'label' => '',
                'readonly'=>true,
                'type'=>'hidden',
                'value'=>$sheetRideDetailRide['Ride']['distance'],
				'id'=>'distance'.$nb_trucks_validated,
                'class' => 'form-control',
                ))."</div>";   




            ?>


            </td>
			

             <td>
             <?php  echo "<div class='form-group '>" . $this->Form->input('SheetRide.'.$nb_trucks_validated.'.car_id', array(
                    'label' => '',
                    'class' => 'form-control',
                    'empty' =>'',
					'value'=>$sheetRideDetailRide['SheetRide']['car_id'],
					'onchange'=>'javascript:carChanged(this.id)',
                    'id' => 'cars'.$nb_trucks_validated,
                        )) . "</div>"; ?>

            </td>
            <td>
           <?php echo "<div class='form-group' id='remorques-div$nb_trucks_validated'>" . $this->Form->input('SheetRide.'.$nb_trucks_validated.'.remorque_id', array(
                    'label' => '',
                    'options'=>$remorques,
                    'class' => 'form-control',
					'value'=>$sheetRideDetailRide['SheetRide']['remorque_id'],
                    'empty' => '',
                    'id' => 'remorques'.$nb_trucks_validated,
                )) . "</div>"; ?>

            </td>
			<td>
            <?php echo "<div class='form-group' id='customers-div$nb_trucks_validated'>" . $this->Form->input('SheetRide.'.$nb_trucks_validated.'.customer_id', array(
                    'label' =>"",
                    'class' => 'form-control',
                    'empty' => '',
                    'id' => 'customers'.$nb_trucks_validated,
					'value'=>$sheetRideDetailRide['SheetRide']['customer_id']
                )) . "</div>"; ?>


            </td>
			<td>

             <?php echo "<div class='form-group'>".$this->Form->input('SheetRide.'.$nb_trucks_validated.'.customer_help', array(
                    'label' =>' ',
                    'type'=>'select',
                    'options'=>$customers,
                    'empty'=>'',
                     'id' => 'customer_help'.$nb_trucks_validated,
					 'value'=>$sheetRideDetailRide['SheetRide']['customer_help'],
                    'class' => 'form-control',
                    ))."</div>"; ?>

            </td>
      
			<td>
            <?php 
             echo "<div class='form-group '>" . $this->Form->input('SheetRideDetailRides.'.$nb_trucks_validated.'.planned_start_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                'type' => 'text',
                                 'class' => 'form-control datemask',
                                'before' => '<label>' . '' . '</label><div class="input-group date"><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                               
								'onchange'=>'javascript:calculPlannedArrivalDate(this.id);',
								'value'=>$sheetRideDetailRide['SheetRideDetailRides']['planned_start_date'],
                                'id' => 'planned_start_date'.$nb_trucks_validated,
                            )) . "</div>";

            ?>
            </td>
			<td>
               <?php 
             echo "<div class='form-group '>" . $this->Form->input('SheetRideDetailRides.'.$nb_trucks_validated.'.real_start_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                'type' => 'text',
                                  'class' => 'form-control datemask',
                                'before' => '<label>' . '' . '</label><div class="input-group date"><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
								'value'=>$sheetRideDetailRide['SheetRideDetailRides']['real_start_date'],
								'onchange'=>'javascript:calculPlannedArrivalDate(this.id);',
                                'id' => 'real_start_date'.$nb_trucks_validated,
                            )) . "</div>";

            ?>


            </td>
			<td>

            <?php 
              echo "<div >".$this->Form->input('SheetRideDetailRides.'.$nb_trucks_validated.'.km_departure', array(
                    'label' => '',
                    'class' => 'form-control',
                    'onchange'=>'javascript:calculKmArrivalEstimated(this.id);',
					'value'=>$sheetRideDetailRide['SheetRideDetailRides']['km_departure'],
                    'id'=>'km_departure'.$nb_trucks_validated,
                    'placeholder'=>__('Enter km departure')
                    ))."</div>";
            ?>

            </td>

            <td>
            <?php 
             echo "<div class='form-group '>" . $this->Form->input('SheetRideDetailRides.'.$nb_trucks_validated.'.planned_end_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                'type' => 'text',
                                  'class' => 'form-control datemask',
                                'before' => '<label>' . '' . '</label><div class="input-group date"><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                               'value'=>$sheetRideDetailRide['SheetRideDetailRides']['planned_end_date'],
								
                                'id' => 'planned_end_date'.$nb_trucks_validated,
                            )) . "</div>";

            ?>
            </td>
			<td>
               <?php 
             echo "<div class='form-group '>" . $this->Form->input('SheetRideDetailRides.'.$nb_trucks_validated.'.real_end_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                'type' => 'text',
                                  'class' => 'form-control datemask',
                                'before' => '<label>' . '' . '</label><div class="input-group date"><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                              
								'value'=>$sheetRideDetailRide['SheetRideDetailRides']['real_end_date'],
                                'id' => 'real_end_date'.$nb_trucks_validated,
                            )) . "</div>";

            ?>


            </td>
            <td>
            <?php	echo "<div class='form-group '>".$this->Form->input('SheetRideDetailRides.'.$nb_trucks_validated.'.km_arrival_estimated', array(
                'label' => '',
                'readonly'=>true,
                'placeholder'=>__('Km arrival estimated'),
                'id'=>'km_arrival_estimated'.$nb_trucks_validated,
				'value'=>$sheetRideDetailRide['SheetRideDetailRides']['km_arrival_estimated'],
                'class' => 'form-control',
                ))."</div>"; ?>

            </td>
            <td>
				
			<?php		echo "<div class='form-group '>".$this->Form->input('SheetRideDetailRides.'.$nb_trucks_validated.'.km_arrival', array(
                'label' => '',
                'placeholder'=>__('Enter km arrival'),
				'value'=>$sheetRideDetailRide['SheetRideDetailRides']['km_arrival'],
                'id'=>'km_arrival'.$nb_trucks_validated,
                'class' => 'form-control',
                ))."</div>"; ?>

            </td>
			<td class="actions">
            <?php echo "<div style='padding-top: 25px;'>";
              echo $this->Html->link(
                        '<i class="  fa fa-edit m-r-5" title="' . __('Edit') . '"></i>',
                        'javascript:;',
                        array('escape' => false, 'id' =>''.$nb_trucks_validated, 'onclick'=>'javascript:edit(this.id);'));
                  echo "</div>";
                 ?>
            </td>
                              </tr>


                         <?php   } ?>
						 
						        <?php         for($i=$nb_trucks_validated+1; $i<=$nb_trucks; $i++){


?>
                            <tr>
                  
			<td>
            <?php echo "<div style='padding-top: 25px;'>". $TransportBillDetailRide['DepartureDestination']['name'].'-'.$TransportBillDetailRide['ArrivalDestination']['name']."</div>";
			
			  echo "<div >".$this->Form->input('num_truck', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$i,
                    'id'=> 'num_truck'.$i,
                    
                    ))."</div>";
			
			 echo "<div >".$this->Form->input('SheetRideDetailRides.'.$i.'.id', array(
                    'label' => '',
                    //'type' => 'hidden',
                    
                    'id'=> 'sheet_ride_detail_ride_id'.$i,
                    
                    ))."</div>";
			echo "<div >".$this->Form->input('SheetRide.'.$i.'.id', array(
                    'label' => '',
                    //'type' => 'hidden',
                    
                    'id'=> 'sheet_ride_id'.$i,
                    
                    ))."</div>";
             echo "<div >".$this->Form->input('SheetRideDetailRides.'.$i.'.detail_ride_id', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$TransportBillDetailRide['TransportBillDetailRides']['detail_ride_id'],
                    'id'=> 'detail_ride_id'.$i,
                    
                    ))."</div>";
             echo "<div >".$this->Form->input('SheetRideDetailRides.'.$i.'.supplier_id', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$TransportBillDetailRide['Supplier']['id'],
                    'id'=> 'supplier_id'.$i,
                    
                    ))."</div>";
             echo "<div >".$this->Form->input('SheetRideDetailRides.'.$i.'.supplier_final_id', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$TransportBillDetailRide['SupplierFinal']['id'],
                    'id'=> 'supplier_final_id'.$i,
                    
                    ))."</div>";

            ?>



            </td>
			<td>

               <?php  echo "<div style='padding-top: 25px;'>". $TransportBillDetailRide['CarType']['name']."</div>";
            
				echo "<div >".$this->Form->input('SheetRide.'.$i.'.car_type_id', array(
                    'label' => '',
                    'type' => 'hidden',
                    'value'=>$TransportBillDetailRide['CarType']['id'],
                    'id'=> 'car_type'.$i,
                    ))."</div>";

             echo "<div class='form-group'>".$this->Form->input('duration_day', array(
                 'label' => '',
                'value'=>$TransportBillDetailRide['DetailRide']['duration_day'],
                'readonly'=>true,
                'type'=>'hidden',
				'id'=>'duration_day'.$i,
                'class' => 'form-control',
                ))."</div>"; 

                       echo "<div class='form-group'>".$this->Form->input('duration_hour', array(
                'label' => '',
                'readonly'=>true,
                'type'=>'hidden',
                'value'=>$TransportBillDetailRide['DetailRide']['duration_hour'],
				'id'=>'duration_hour'.$i,
                'class' => 'form-control',
                ))."</div>";


                       echo "<div class='form-group '>".$this->Form->input('duration_minute', array(
                'label' => '',
                'readonly'=>true,
                'type'=>'hidden',
                'value'=>$TransportBillDetailRide['DetailRide']['duration_minute'],
				'id'=>'duration_minute'.$i,
                'class' => 'form-control '
                ))."</div>"; 

                      echo "<div class='form-group '>".$this->Form->input('distance', array(
                 'label' => '',
                'readonly'=>true,
                'type'=>'hidden',
                'value'=>$TransportBillDetailRide['Ride']['distance'],
				'id'=>'distance'.$i,
                'class' => 'form-control',
                ))."</div>";   




            ?>


            </td>
			

             <td>
             <?php  echo "<div class='form-group '>" . $this->Form->input('SheetRide.'.$i.'.car_id', array(
                    'label' => '',
                    'class' => 'form-control',
                    'empty' => '',
					'onchange'=>'javascript:carChanged(this.id)',
                    'id' => 'cars'.$i,
                        )) . "</div>"; ?>

            </td>
            <td>
           <?php echo "<div class='form-group' id='remorques-div$i'>" . $this->Form->input('SheetRide.'.$i.'.remorque_id', array(
                    'label' => '',
                    'options'=>$remorques,
                    'class' => 'form-control',
                    'empty' => '',
                    'id' => 'remorques'.$i,
                )) . "</div>"; ?>

            </td>
			<td>
            <?php echo "<div class='form-group' id='customers-div$i'>" . $this->Form->input('SheetRide.'.$i.'.customer_id', array(
                    'label' =>"",
                    'class' => 'form-control',
                    'empty' => '',
                    'id' => 'customers'.$i,
                )) . "</div>"; ?>


            </td>
			<td>

             <?php echo "<div class='form-group'>".$this->Form->input('SheetRide.'.$i.'.customer_help', array(
                    'label' =>' ',
                    'type'=>'select',
                    'options'=>$customers,
                    'empty'=>'',
                     'id' => 'customer_help'.$i,
                    'class' => 'form-control',
                    ))."</div>"; ?>

            </td>
      
			<td>
            <?php 
             echo "<div class='form-group '>" . $this->Form->input('SheetRideDetailRides.'.$i.'.planned_start_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                'type' => 'text',
                                 'class' => 'form-control datemask',
                                'before' => '<label>' . '' . '</label><div class="input-group date"><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                               
								'onchange'=>'javascript:calculPlannedArrivalDate(this.id);',
                                'id' => 'planned_start_date'.$i,
                            )) . "</div>";

            ?>
            </td>
			<td>
               <?php 
             echo "<div class='form-group '>" . $this->Form->input('SheetRideDetailRides.'.$i.'.real_start_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                'type' => 'text',
                                  'class' => 'form-control datemask',
                                'before' => '<label>' . '' . '</label><div class="input-group date"><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                              
								'onchange'=>'javascript:calculPlannedArrivalDate(this.id);',
                                'id' => 'real_start_date'.$i,
                            )) . "</div>";

            ?>


            </td>
			<td>

            <?php 
              echo "<div >".$this->Form->input('SheetRideDetailRides.'.$i.'.km_departure', array(
                    'label' => '',
                    'class' => 'form-control',
                    'onchange'=>'javascript:calculKmArrivalEstimated(this.id);',
                    'id'=>'km_departure'.$i,
                    'placeholder'=>__('Enter km departure')
                    ))."</div>";
            ?>

            </td>

            <td>
            <?php 
             echo "<div class='form-group '>" . $this->Form->input('SheetRideDetailRides.'.$i.'.planned_end_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                'type' => 'text',
                                  'class' => 'form-control datemask',
                                'before' => '<label>' . '' . '</label><div class="input-group date"><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                               
								
                                'id' => 'planned_end_date'.$i,
                            )) . "</div>";

            ?>
            </td>
			<td>
               <?php 
             echo "<div class='form-group '>" . $this->Form->input('SheetRideDetailRides.'.$i.'.real_end_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                'type' => 'text',
                                  'class' => 'form-control datemask',
                                'before' => '<label>' . '' . '</label><div class="input-group date"><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                              
								
                                'id' => 'real_end_date'.$i,
                            )) . "</div>";

            ?>


            </td>
            <td>
            <?php	echo "<div class='form-group '>".$this->Form->input('SheetRideDetailRides.'.$i.'.km_arrival_estimated', array(
                'label' => '',
                'readonly'=>true,
                'placeholder'=>__('Km arrival estimated'),
                'id'=>'km_arrival_estimated'.$i,
                'class' => 'form-control',
                ))."</div>"; ?>

            </td>
            <td>
				
			<?php		echo "<div class='form-group '>".$this->Form->input('SheetRideDetailRides.'.$i.'.km_arrival', array(
                'label' => '',
                'placeholder'=>__('Enter km arrival'),
                'id'=>'km_arrival'.$i,
                'class' => 'form-control',
                ))."</div>"; ?>

            </td>
			<td class="actions">
            <?php echo "<div style='padding-top: 25px;' id='save_edit$i'>";
              echo $this->Html->link(
                        '<i class="fa fa-save" title="' . __('Save') . '"></i>',
                        'javascript:;',
                        array('escape' => false, 'id' =>''.$i, 'onclick'=>'javascript:save(this.id);'));
                  echo "</div>";
                 ?>
            </td>
                              </tr>


                         <?php   } ?>
						</tbody>
						
					</table>

<?php } ?>
<?php $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>

<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('jquery-2.1.1.min.js'); ?>
<?= $this->Html->script('jquery.form.min.js'); ?>

<script type="text/javascript">     $(document).ready(function() {      });
nb_trucks=jQuery('#nb_trucks').val();
for(i=1; i<=nb_trucks; i++){
	
jQuery("#planned_start_date"+''+i+'').inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
jQuery("#planned_end_date"+''+i+'').inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
jQuery("#real_start_date"+''+i+'').inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
jQuery("#real_end_date"+''+i+'').inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});

if(jQuery('#cars'+''+i+'').val() > 0){
        jQuery('#customers-div'+''+i+'').load('<?php echo $this->Html->url('/sheetRides/getCustomersByCar/')?>' + jQuery('#cars'+''+i+'').val()+'/'+i+'/'+1);
        jQuery('#remorques-div'+''+i+'').load('<?php echo $this->Html->url('/sheetRides/getRemorquesByCar/')?>' + jQuery('#cars'+''+i+'').val()+'/'+i+'/'+1);
    }
	
if(jQuery('#detail_ride_id'+''+i+'').val() > 0){
	var id='detail_ride_id'+i;
	
	calculPlannedArrivalDate (id);

}	

   
}

function carChanged(id){
		var i = id.substring(id.length-1,id.length) ;
        jQuery('#customers-div'+''+i+'').load('<?php echo $this->Html->url('/sheetRides/getCustomersByCar/')?>' + jQuery('#cars'+''+i+'').val()+'/'+i+'/'+1);
		jQuery('#remorques-div'+''+i+'').load('<?php echo $this->Html->url('/sheetRides/getRemorquesByCar/')?>' + jQuery('#cars'+''+i+'').val()+'/'+i+'/'+1);
    
	
}

function verifyStatusCar(id) {
	var i = id.substring(id.length-1,id.length) ;
	
	
	
	
	
	if ((jQuery("#cars"+''+i+'').val())>0 &&  (jQuery("#real_start_date"+''+i+'').val().length>0) ){
		
		
		 jQuery.ajax({
				type:"POST",
                url:"<?php echo $this->Html->url('/sheetRides/verifyStatusCar/')?>",
				data: {
                
				car_id:jQuery("#cars"+''+i+'').val(), 
				
				real_start_date:jQuery("#real_start_date"+''+i+'').val()
				
				},
				dataType: "json",
                success:function(json){
					
             if (json.response === "true") {
				alert('Le vehicule est sorti et n\'est pas revenu');
				 
                 
				}else {
					
					alert('Le vehicule est disponible');

				}
         }
			});
		
	}
	
}


function save(id){

    if (jQuery("#cars"+''+id+'').val() == "" || jQuery("#cars"+''+id+'').val() == null) {

                jQuery("#cars"+''+id+'').focus();

               alert("<?= __('Please select car') ?>");

        }else {
			
			if (jQuery("#customers"+''+id+'').val() == "" || jQuery("#customers"+''+id+'').val() == null) {

                jQuery("#customers"+''+id+'').focus();

               alert("<?= __('Please select customer') ?>");

        }else {
			
			  jQuery.ajax({
				type:"POST",
                url:"<?php echo $this->Html->url('/sheetRides/saveSheetRide/')?>",
				data: {
                transport_bill_detail_ride_id:jQuery('#id').val(),
				car_id:jQuery("#cars"+''+id+'').val(), 
				remorque_id:jQuery("#remorques"+''+id+'').val(),
				customer_id:jQuery("#customers"+''+id+'').val(),
				customer_help:jQuery("#customer_help"+''+id+'').val(),
				planned_start_date:jQuery("#planned_start_date"+''+id+'').val(),
				planned_end_date:jQuery("#planned_end_date"+''+id+'').val(),
				real_start_date:jQuery("#real_start_date"+''+id+'').val(),
				real_end_date:jQuery("#real_end_date"+''+id+'').val(),
				km_departure:jQuery("#km_departure"+''+id+'').val(),
				km_arrival_estimated:jQuery("#km_arrival_estimated"+''+id+'').val(),
				km_arrival:jQuery("#km_arrival"+''+id+'').val(),
				detail_ride_id:jQuery("#detail_ride_id"+''+id+'').val(),
				car_type_id:jQuery("#car_type"+''+id+'').val(),
				supplier_id:jQuery("#supplier_id"+''+id+'').val(),
				supplier_final_id:jQuery("#supplier_final_id"+''+id+'').val()
				},
				dataType: "json",
                success:function(json){
					
             if (json.response === "true") {
				
				 jQuery("#sheet_ride_id"+''+id+'').val(json.sheet_ride_id);
				 jQuery("#sheet_ride_detail_ride_id"+''+id+'').val(json.sheet_ride_detail_ride_id);
				 jQuery('#save_edit'+''+id+'').html('<a href="javascript:;" id= "'+''+id+'"onclick="javascript:edit(this.id);"> <i class="  fa fa-edit m-r-5" title=<?=__("Edit")?>></i></a>');
                 jQuery('#message').html('<div id="flashMessage" class="message"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><?=__("The sheet ride has been saved.")?></div></div>');
                 
				}else {
					
					jQuery('#message').html("<div id='flashMessage' class='message'><div class='alert alert-danger alert-dismissable'><i class='fa fa-times'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'></button><?=__('The sheet ride could not be saved.')?></div></div>");
					
					
					
				}
         }
			});
			
			
		}
			
			
			
		}
   
              
}


function edit(id){

    if (jQuery("#cars"+''+id+'').val() == "" || jQuery("#cars"+''+id+'').val() == null) {

                jQuery("#cars"+''+id+'').focus();

               alert("<?= __('Please select car') ?>");

        }else {
			
			if (jQuery("#customers"+''+id+'').val() == "" || jQuery("#customers"+''+id+'').val() == null) {

                jQuery("#customers"+''+id+'').focus();

               alert("<?= __('Please select customer') ?>");

        }else {
			
			  jQuery.ajax({
				type:"POST",
                url:"<?php echo $this->Html->url('/sheetRides/editSheetRide/')?>",
				data: {
				sheet_ride_id:jQuery("#sheet_ride_id"+''+id+'').val(),
				sheet_ride_detail_ride_id:jQuery("#sheet_ride_detail_ride_id"+''+id+'').val(),
                transport_bill_detail_ride_id:jQuery('#id').val(),
				car_id:jQuery("#cars"+''+id+'').val(), 
				remorque_id:jQuery("#remorques"+''+id+'').val(),
				customer_id:jQuery("#customers"+''+id+'').val(),
				customer_help:jQuery("#customer_help"+''+id+'').val(),
				planned_start_date:jQuery("#planned_start_date"+''+id+'').val(),
				planned_end_date:jQuery("#planned_end_date"+''+id+'').val(),
				real_start_date:jQuery("#real_start_date"+''+id+'').val(),
				real_end_date:jQuery("#real_end_date"+''+id+'').val(),
				km_departure:jQuery("#km_departure"+''+id+'').val(),
				km_arrival_estimated:jQuery("#km_arrival_estimated"+''+id+'').val(),
				km_arrival:jQuery("#km_arrival"+''+id+'').val(),
				detail_ride_id:jQuery("#detail_ride_id"+''+id+'').val(),
				car_type_id:jQuery("#car_type"+''+id+'').val(),
				supplier_id:jQuery("#supplier_id"+''+id+'').val(),
				supplier_final_id:jQuery("#supplier_final_id"+''+id+'').val()
				},
				dataType: "json",
                success:function(json){
             if (json.response === "true") {
                 jQuery('#message').html('<div id="flashMessage" class="message"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><?=__("The sheet ride has been saved.")?></div></div>');
                 
				}else {
					
					jQuery('#message').html("<div id='flashMessage' class='message'><div class='alert alert-danger alert-dismissable'><i class='fa fa-times'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'></button><?=__('The sheet ride could not be saved.')?></div></div>");
					
					
					
				}
         }
			});
			
			
		}
			
			
			
		}
   
              
}


   function calculPlannedArrivalDate (id){
	 var num = id.substring(id.length-1,id.length) ;
	 
	   
	   
	   if(jQuery('#real_start_date'+''+num+'').val()){
		   
		    var s_arr = jQuery('#real_start_date'+''+num+'').val().split(/\/|\s|:/);
	   }else {
		 
    var s_arr = jQuery('#planned_start_date'+''+num+'').val().split(/\/|\s|:/);
	   }
 myDate = new Date(s_arr[1]+","+ s_arr[0]+","+ s_arr[2]+","+ s_arr[3]+":"+s_arr[4]+":00");
 

	
 nb_day=parseInt(jQuery("#duration_day"+''+num+'').val());
 
 nb_hour=parseInt(jQuery("#duration_hour"+''+num+'').val());
 nb_min= parseInt(jQuery("#duration_minute"+''+num+'').val());
   
var dayOfMonth = myDate.getDate();

myDate.setDate(dayOfMonth + nb_day);

var dayOfMonth = myDate.getHours();

myDate.setHours(dayOfMonth + nb_hour);

var dayOfMonth = myDate.getMinutes();

myDate.setMinutes(dayOfMonth + nb_min);

var dayOfMonth = myDate.getMonth();

myDate.setMonth(dayOfMonth + 1);

day = myDate.getDate();
month= myDate.getMonth();
year=myDate.getFullYear();
hour=myDate.getHours();
hour=parseInt(hour);
if(hour<10){
hour='0'+hour;	
	
}
min=myDate.getMinutes();
if(min=='0'){
	
	min=min+'0';
}

end_date= day+"/"+ month+"/"+ year+" "+ hour+":"+min;

jQuery('#planned_end_date'+''+num+'').val(end_date);

   
        }
		
function calculKmArrivalEstimated(id){
	var num = id.substring(id.length-1,id.length) ;
	km_departure=jQuery('#km_departure'+''+num+'').val();
	distance=jQuery('#distance'+''+num+'').val();
	km_estimated=parseFloat(km_departure)+parseFloat(distance);
	jQuery('#km_arrival_estimated'+''+num+'').val(km_estimated);
	
}


</script>

<?php $this->end(); ?>
