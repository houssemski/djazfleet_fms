
<div class="panel-body">
			<?php
			 "<div class='form-group'>" . $this->Form->input('num_leasing', array(
								'label' =>'',
								'type' => 'hidden',
								'value' =>$nb_leasing,
								'id' =>'num_leasing',
								'empty' => ''
							)) . "</div>";

echo "<div class='form-group' >" . $this->Form->input('Leasing.'.$nb_leasing.'.acquisition_type_id', array(
                                'label' => __('Acquisition type'),
                                'id' =>"acquisition_leasing",
								'options'=>$acquisitionTypesLeasing,
                                'class' => 'form-control select2',
                                'empty' => ''
                            )) . "</div>"; 							
		    echo "<div class='form-group supplier_location input-button' id='suppliers$nb_leasing'>" . $this->Form->input('Leasing.'.$nb_leasing.'.supplier_id', array(
                                'label' => __('Supplier'),
                                'class' => 'form-control select2',
                                'empty' => ''
                            )) . "</div>"; ?>
							
					<div id="dialogModalSupplier0">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapSupplier0"></div>
                        </div>
                        <div class="popupactions">

                                    <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                        array("controller" => "cars", "action" => "addSupplier",$nb_leasing),
                                        array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlaySupplier",
                                            'escape' => false, "title" => __("Add Supplier"))); ?>

                        </div>
                        <div style="clear:both"></div>
                        <?php

                        
                        
                        echo "<div class='form-group'>" . $this->Form->input('Leasing.'.$nb_leasing.'.num_contract', array(
                                'label' => __('Number contract'),
                                'placeholder' => __('Enter number contract'),
                                'id'=>'num',
                                'class' => 'form-control',
                            )) . "</div>";
                       echo "<div class='form-group'>" . $this->Form->input('Leasing.'.$nb_leasing.'.reception_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Reception date') .
                                    '</label><div class="input-group date"><label for="CarReceptionDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                'after' => '</div>',
                                'onchange'=>'javascript:champsRequired();',
                                'id' => 'reception_date'.$nb_leasing,
                            )) . "</div>";
						echo "<div class='form-group'>" . $this->Form->input('Leasing.'.$nb_leasing.'.end_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Planned end date') .
                                    '</label><div class="input-group date"><label for="CarDateEnd"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                'after' => '</div>',
                                'id' => 'end_date'.$nb_leasing,
                            )) . "</div>";
						echo "<div class='form-group'>" . $this->Form->input('Leasing.'.$nb_leasing.'.end_real_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Real end date') .
                                    '</label><div class="input-group date"><label for="CarEndRealDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                'after' => '</div>',
                                'id' => 'end_real_date'.$nb_leasing,
                               // 'onchange'=>'javascript: showBtLeasing();',
                            )) . "</div>";
        
                         
                             echo "<div class='form-group'>" . $this->Form->input('Leasing.'.$nb_leasing.'.reception_km', array(
                                'label' => __('Counter / Km'),
                                'placeholder' => __('Enter counter / Km'),
                                'class' => 'form-control',
								'id' =>'reception_km'.$nb_leasing,
                            )) . "</div>";
                          
							
							
							echo "<div class='form-group'>" . $this->Form->input('Leasing.'.$nb_leasing.'.cost_km', array(
                                'label' => __('Additional cost. At Km HT'),
                                'placeholder' => __('Enter additional cost. At Km HT'),
                                'class' => 'form-control',
								'id' =>'cost_km'.$nb_leasing,
                            )) . "</div>";
				
                            echo "<div class='form-group'>" . $this->Form->input('Leasing.'.$nb_leasing.'.amont_month', array(
                                'label' => __('Monthly payment'),
                                'placeholder' => __('Enter monthly payment'),
								'id'=>'amont_month'.$nb_leasing,
                                'class' => 'form-control',
                            )) . "</div>";
                           
						    
                         echo "<div class='form-group'>" . $this->Form->input('Leasing.'.$nb_leasing.'.additional_franchise_km', array(
                                'label' => __('Additional franchise km'),
                                'placeholder' => __('Entrer additional franchise km'),
								'id'=>'km_year0',
                                'class' => 'form-control',
                            )) . "</div>";
                        
                          echo "<div class='form-group'>" . $this->Form->input('Leasing.'.$nb_leasing.'.km_year', array(
                                'label' => __('Km annual'),
                                'placeholder' => __('Enter km annual'),
								'id'=>'km_year'.$nb_leasing,
                                'class' => 'form-control',
                            )) . "</div>";
							
                        echo "<div class='form-group'>" . $this->Form->input('Leasing.'.$nb_leasing.'.attachment', array(
                                'label' => __('Attachment'),
                                'class' => 'form-control filestyle',
                                'type' => 'file',
                                'empty' => ''
                            )) . "</div>";   
	  
	  ?>

	  </div>

      <?php $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
<?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<script type="text/javascript">     $(document).ready(function() {      });
    $( document ).ready(function(){
        var num_leasing=parseFloat(jQuery('#num_leasing').val());
        jQuery("#reception_date"+''+num_leasing+'').inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#end_date"+''+num_leasing+'').inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#end_real_date"+''+num_leasing+'').inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    });

    </script>

<?php $this->end(); ?>