<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB33Wa5iG-fztbIhYh60y9YGaZoKuCOPho&libraries=places">
</script>

<?php
include("ctp/datetime.ctp");
$this->request->data['Event']['date_refund'] = $this->Time->format($this->request->data['Event']['date_refund'], '%d-%m-%Y ');
$this->request->data['Event']['workshop_entry_date'] = $this->Time->format($this->request->data['Event']['workshop_entry_date'], '%d-%m-%Y %H:%M');
$this->request->data['Event']['workshop_exit_date'] = $this->Time->format($this->request->data['Event']['workshop_exit_date'], '%d-%m-%Y %H:%M');
?><h4 class="page-title"> <?=__('Edit an event');?></h4>

<div class="box p-b-5">
    <div class="edit form card-box ">

        <?php echo $this->Form->create('Event', array('enctype' => 'multipart/form-data', 'onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body-event">
            <div class="nav-tabs-custom pdg_btm">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
                   <?php  if (Configure::read("gestion_commercial") == '1'  &&
                    Configure::read("tresorerie") == '1') { ?>
                    <li><a href="#tab_2" data-toggle="tab"><?= __('Payment ') ?></a></li>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <?php
                        echo $this->Form->input('id');
                        echo "<div class='form-group'>" . $this->Form->input('code', array(
                                'label' => __('Reference'),
                                'class' => 'form-control',
                                'readonly' => true,
                                'placeholder' => __('Enter reference'),
                            )) . "</div>";
			if (Configure::read('logistia') == '1'){
			   echo "<div class='form-group input-button' id='eventtype'>" . $this->Form->input('event_types', array(
                                'label' => __('Event type'),
                                'class' => 'form-control',
                                'selected' => $eventTypesSelected,
                                'empty' => ''
                            )) . "</div>";
			}else {
			  echo "<div class='form-group input-button' id='eventtype'>" . $this->Form->input('event_types', array(
                                'label' => __('Event type'),
                                'class' => 'form-control',
                                'id' => 'type',
                                'selected' => $eventTypesSelected,
                                'empty' => ''
                            )) . "</div>";
			}
                       ?>
                        <!-- overlayed element -->
                        <div id="dialogModal">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrap"></div>
                        </div>
                        <div class="popupactions">

                                    <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                        array("controller" => "events", "action" => "addEventType",'addEvent'),
                                        array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlay", 'escape' => false, "title" => "Add Type")); ?>

                        </div>
                        <div style="clear:both"></div>
                        <?php
                        echo "<div class='form-group'><span id='model'>" . $this->Form->input('car_id', array(
                                'label' => __('Car'),
                                'class' => 'form-control select2',
                                'empty' => '',
                                'id' => 'cars',
                            )) . "</span></div>";
			if (Configure::read('logistia') == '1'){
			echo "<div id='customers-div'>";
                        echo "<div class='form-group' >" . $this->Form->input('customer_id', array(
                                'label' => __("Applicant"),
                                'class' => 'form-control select2',
                                'empty' => ''
                            )) . "</div>";
                        echo "</div>";

                        echo "<div class='form-group' >" . $this->Form->input('structure_id', array(
                                'label' => __("Structure"),
                                'class' => 'form-control select2',
                                'empty' => '',
                                'id' => 'structure',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('boss_id', array(
                                'label' => __("Service"),
                                'class' => 'form-control select2',
                                'options' => $customers,
                                'empty' => '',
                                'id' => 'customers',
                            )) . "</div>";
			
			} else {
				echo "<div id='customers-div'>";
	                        echo "<div class='form-group' >" . $this->Form->input('customer_id', array(
	                                'label' => __("Conductor"),
	                                'class' => 'form-control select2',
	                                'empty' => ''
	                            )) . "</div>";
	                        echo "</div>";
			}	    
			    
			    
                       

                        echo "<div id='interval_type' style='padding-top: 20px;'>";
                        echo '<div class="lbl_type required"><label>' . __("Type");
                        echo "</label></div>";
                        $options = array('1' => __('Internal'), '2' => __('External'));

                        $attributes = array('legend' => false, 'value' => $this->request->data['Event']['internal_external']);
                        echo $this->Form->radio('internal_external', $options, $attributes) . "</div><br/>";

                        if ($this->request->data['EventEventType']['event_type_id'] == 11) {
                            echo "<div id='assurance-div'>";
                            if (!empty($this->request->data['Event']['assurance_number'])) {
                                echo " <div class='form-group'>" . $this->Form->input('assurance_number', array(
                                        'label' => __('Assurance number'),
                                        'class' => 'form-control',
                                        'id' => 'num_assurance',
                                        'readonly' => true,
                                    )) . "</div>";

                            }

                            if (!empty($this->request->data['Event']['assurance_type'])) {
                                $options = array('1' => __('Public liability'), '2' => __('Collision damage'), '3' => __('All risks'));
                                echo "<div class='form-group'>" . $this->Form->input('assurance_type', array(
                                        'label' => __('Assurance type'),

                                        'type' => 'select',
                                        'options' => $options,
                                        'class' => 'form-control',

                                        'empty' => ''

                                    )) . "</div>";

                            }
                            echo "</div>";


                        } else {
                            echo "<div id='assurance-div'></div>";
                        }
                        echo "<div id='interfering'>";



                        if($this->request->data['Event']['internal_external']==2){
                            $i = 0;
                            if (!empty($eventCategoryInterferings)) {

                                foreach ($eventCategoryInterferings as $eventCategoryInterfering) {
                                    if($this->request->data['EventType']['many_interferings']==1){

                                        if ($eventCategoryInterfering['EventTypeCategory']['name'] == 'Autre') {
                                            if ($this->request->data['EventEventType']['event_type_id'] == 2) {
                                                $lbl_interfering = __('Agency');
                                                $select_interfering = __('Select agency');
                                            } else {
                                                $lbl_interfering = __('Interfering');
                                                $select_interfering = __('Select interfering');

                                            }

                                            $name = '';

                                        } else {

                                            $lbl_interfering = __('Interfering');
                                            $select_interfering = __('Select interfering');
                                            $name = $eventCategoryInterfering['EventTypeCategory']['name'];
                                        }
                                        echo "<div class='form-group'>" . $this->Form->input('EventCategoryInterfering.' . $i . '.event_type_category', array(
                                                'type' => 'hidden',
                                                'value' => $eventCategoryInterfering['EventTypeCategory']['id'],
                                                'class' => 'form-control',
                                            )) . "</div>";

                                        echo "<div class='form-group interferingGroup input-button' id='interfering" . $i . "0'>" . $this->Form->input('EventCategoryInterfering.' . $i . '.interfering_id0', array(
                                                'type' => 'select',
                                                'label' => $lbl_interfering . ' ' . $name,

                                                'selected' => $eventCategoryInterfering['EventCategoryInterfering']['interfering_id0'],
                                                'value' => $select_interfering,
                                                'options' => $interferings,
                                                'class' => 'form-control',
                                            )) . "</div>"; ?>


                                        <div class="popupactions">

                                            <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                                array("controller" => "events", "action" => "addInterfering", $i,0, $this->request->data['EventEventType']['event_type_id']),
                                                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayInterfering", 'escape' => false, "title" => __("Add Interfering"))); ?>

                                        </div>
                                        <div style="clear:both;"></div>

                                        <?php echo "<div class='form-group interferingGroup input-button' id='interfering" . $i . "1'>" . $this->Form->input('EventCategoryInterfering.' . $i . '.interfering_id1', array(
                                                // 'type' => 'hidden',
                                                'label' => $lbl_interfering . ' ' . $name,
                                                'selected' => $eventCategoryInterfering['EventCategoryInterfering']['interfering_id1'],
                                                'value' => $select_interfering,
                                                'options' => $interferings,
                                                'class' => 'form-control',
                                            )) . "</div>"; ?>

                                        <div class="popupactions">

                                            <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                                array("controller" => "events", "action" => "addInterfering", $i, 1,$this->request->data['EventEventType']['event_type_id']),
                                                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayInterfering", 'escape' => false, "title" => __("Add Interfering"))); ?>

                                        </div>

                                        <div style="clear:both;"></div>
                                        <?php echo "<div class='form-group interferingGroup input-button' id='interfering" . $i . "2'>" . $this->Form->input('EventCategoryInterfering.' . $i . '.interfering_id2', array(
                                                // 'type' => 'hidden',
                                                'label' => $lbl_interfering . ' ' . $name,
                                                'selected' => $eventCategoryInterfering['EventCategoryInterfering']['interfering_id2'],
                                                'value' => $select_interfering,
                                                'options' => $interferings,
                                                'class' => 'form-control',
                                            )) . "</div>";


                                        ?>
                                        <div class="popupactions">

                                            <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                                array("controller" => "events", "action" => "addInterfering", $i,2, $this->request->data['EventEventType']['event_type_id']),
                                                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayInterfering", 'escape' => false, "title" => __("Add Interfering"))); ?>

                                        </div>
                                    <?php    }else {
                                        if ($eventCategoryInterfering['EventTypeCategory']['name'] == 'Autre') {
                                            if ($this->request->data['EventEventType']['event_type_id'] == 2) {
                                                $lbl_interfering = __('Agency');
                                                $select_interfering = __('Select agency');
                                            } else {
                                                $lbl_interfering = __('Interfering');
                                                $select_interfering = __('Select interfering');

                                            }

                                            $name = '';

                                        } else {

                                            $lbl_interfering = __('Interfering');
                                            $select_interfering = __('Select interfering');
                                            $name = $eventCategoryInterfering['EventTypeCategory']['name'];
                                        }



                                        echo "<div class='form-group'>" . $this->Form->input('EventCategoryInterfering.' . $i . '.event_type_category', array(
                                                'type' => 'hidden',
                                                'value' => $eventCategoryInterfering['EventTypeCategory']['id'],
                                                'class' => 'form-control',
                                            )) . "</div>";

                                        echo "<div class='form-group interferingGroup input-button' id='interfering" . $i . "0'>" . $this->Form->input('EventCategoryInterfering.' . $i . '.interfering_id0', array(
                                                'type' => 'select',
                                                'label' => $lbl_interfering . ' ' . $name,

                                                'selected' => $eventCategoryInterfering['EventCategoryInterfering']['interfering_id0'],
                                                'value' => $select_interfering,
                                                'options' => $interferings,
                                                'class' => 'form-control',
                                            )) . "</div>"; ?>


                                        <div class="popupactions">

                                            <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                                array("controller" => "events", "action" => "addInterfering", $i,0, $this->request->data['EventEventType']['event_type_id']),
                                                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayInterfering", 'escape' => false, "title" => __("Add Interfering"))); ?>

                                        </div>
                                        <div style="clear:both;"></div>
                                    <?php   } ?>
                                    <div style="clear:both;"></div>
                                    <?php echo "<div class='form-group'>" . $this->Form->input('EventCategoryInterfering.' . $i . '.cost', array(
                                            // 'type' => 'hidden',
                                            'id' => 'cost' . $i,
                                            'placeholder' => __('Enter cost'),
                                            'value' => $eventCategoryInterfering['EventCategoryInterfering']['cost'],
                                            'onchange' => 'javascript:calculate_cost();',
                                            'class' => 'form-control cost_interfering'
                                        )) . "</div>";

                                    //  }

                                    $i++;
                                }
                            } else {
                                if (!empty($EventTypeCategories)) {

                                    $i = 1;
                                    foreach ($EventTypeCategories as $EventTypeCategory) {
                                        echo $this->Form->input('EventCategoryInterfering.' . $i . '.event_type_category', array(
                                            'type' => 'hidden',
                                            'value' => $EventTypeCategory['EventTypeCategory']['id'],
                                            'class' => 'form-control',
                                        ));


                                        echo "<div class='form-group' id='interferings'>" . $this->Form->input('EventCategoryInterfering.' . $i . '.interfering_id', array(
                                                // 'type' => 'hidden',
                                                'label' => __('Interfering') . ' ' . $EventTypeCategory['EventTypeCategory']['name'],
                                                'empty' => '',
                                                'class' => 'form-control select2',
                                            )) . "</div>";
                                        echo "<div class='form-group'>" . $this->Form->input('EventCategoryInterfering.' . $i . '.cost', array(
                                                // 'type' => 'hidden',
                                                'id' => 'cost' . $i,
                                                'value' => '0',
                                                'placeholder' => __('Enter cost'),
                                                'onchange' => 'javascript:calculate_cost();',
                                                'class' => 'form-control cost_interfering'
                                            )) . "</div>";
                                        $i++;
                                    }
                                }


                            }

                        }else {
                            echo "<div class='form-group' >" . $this->Form->input('mechanician_id', array(
                                    'label' => __("Mécanicien"),
                                    'class' => 'form-control select2',
                                    'empty' => '',
                                    'id' => 'mechanician',
                                    'options'=>$mechanicians
                                )) . "</div>";

                            echo "<div class='form-group' >" . $this->Form->input('Event.workshop_id', array(
                                    'label' => __("Workshop"),
                                    'class' => 'form-control select2',
                                    'empty' => '',
                                    'id' => 'workshop',
                                    'options'=>$workshops
                                )) . "</div>";

			 echo "<div class='form-group' >" . $this->Form->input('Event.workshop_entry_date', array(
                                    'label' => false,
                                    'placeholder' => 'dd/mm/yyyy hh:mm',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label>' . __('Workshop entry date') . '</label><div class="input-group datetime-workshop"><label for="EventWorkshopEntryDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'onchange'=>'javascript : checkIfMechanicIsAvailable()',
                                    'id' => 'workshop_entry_date',
                                )) . "</div>";

                            echo "<div class='form-group' >" . $this->Form->input('Event.workshop_exit_date', array(
                                    'label' => false,
                                    'placeholder' => 'dd/mm/yyyy hh:mm',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label>' . __('Workshop exit date') . '</label><div class="input-group datetime-workshop"><label for="EventWorkshopExitDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'workshop_exit_date',
                                    'onchange'=>'javascript : checkIfMechanicIsAvailable()',
                                )) . "</div>";
                        }
			echo "</div>";
                        ?>
                        <!-- overlayed element -->
                        <div id="dialogModalInterfering">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapInterfering"></div>
                        </div>
                        <?php
			 if (Configure::read('logistia') == '1'){
                        $this->request->data['Event']['reception_date'] =
                            $this->Time->format($this->request->data['Event']['reception_date'], '%d-%m-%Y');
                        $this->request->data['Event']['intervention_date'] =
                            $this->Time->format($this->request->data['Event']['intervention_date'], '%d-%m-%Y');

                        echo "<div class='form-group'>" . $this->Form->input('reception_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Reception date') . '</label><div class="input-group date"><label for="birthday"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'birthday',
                            )) . "</div>";

                        echo "<div class='form-group'>" . $this->Form->input('intervention_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Intervention date') . '</label><div class="input-group date"><label for="birthday"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'birthday',
                            )) . "</div>";
			 } else {
			 
                        if ($this->request->data['EventType']['with_km'] == 1 && $this->request->data['EventType']['with_date'] == 1) {
                            $this->request->data['Event']['date'] = $this->Time->format($this->request->data['Event']['date'], '%d-%m-%Y');
                            $this->request->data['Event']['next_date'] = $this->Time->format($this->request->data['Event']['next_date'], '%d-%m-%Y');
                            $this->request->data['Event']['date3'] = $this->Time->format($this->request->data['Event']['date3'], '%d-%m-%Y');
                            echo "<div id='interval'><div class='form-group'>" . $this->Form->input('date', array(
                                    'label' => '',
                                    'placeholder' => 'dd/mm/yyyy',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label>' . __('Date') . '</label><div class="input-group date"><label for="Date"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'date',
                                )) . "</div>";
                            echo "<div class='form-group'>" . $this->Form->input('next_date', array(
                                    'label' => '',
                                    'placeholder' => 'dd/mm/yyyy',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label>' . __('Next date') . '</label><div class="input-group date"><label for="NextDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'nextdate'
                                )) . "</div>";
                            echo "<div class='form-group'>" . $this->Form->input('date3', array(
                                    'label' => '',
                                    'placeholder' => 'dd/mm/yyyy',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label>' . __('Date 3') . '</label><div class="input-group date"><label for="Date3"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'date3'
                                )) . "</div></div>";
                            echo "<div id='intervale'><div class='form-group'>" . $this->Form->input('km', array(
                                    'label' => __('Km'),
                                    'placeholder' => __('Enter Km'),
                                    'id' => 'EventKm',
                                    'class' => 'form-control',
                                )) . "</div>";
                            echo "<div class='form-group'>" . $this->Form->input('next_km', array(
                                    'label' => __('Next km'),
                                    'placeholder' => __('Enter next km'),
                                    'id' => 'EventNextKm',
                                    'class' => 'form-control',
                                )) . "</div></div>";

                        } elseif ($this->request->data['EventType']['with_date'] == 1) {
                            $this->request->data['Event']['date'] = $this->Time->format($this->request->data['Event']['date'], '%d-%m-%Y');
                            $this->request->data['Event']['next_date'] = $this->Time->format($this->request->data['Event']['next_date'], '%d-%m-%Y');
                            $this->request->data['Event']['date3'] = $this->Time->format($this->request->data['Event']['date3'], '%d-%m-%Y');
                            echo "<div id='interval'><div class='form-group'>" . $this->Form->input('date', array(
                                    'label' => '',
                                    'placeholder' => 'dd/mm/yyyy',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label>' . __('Date') . '</label><div class="input-group date"><label for="Date"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'date',
                                )) . "</div>";
                            echo "<div class='form-group'>" . $this->Form->input('next_date', array(
                                    'label' => '',
                                    'placeholder' => 'dd/mm/yyyy',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label>' . __('Next date') . '</label><div class="input-group date"><label for="NextDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'nextdate'
                                )) . "</div>";
                            echo "<div class='form-group'>" . $this->Form->input('date3', array(
                                    'label' => '',
                                    'placeholder' => 'dd/mm/yyyy',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label>' . __('Date 3') . '</label><div class="input-group date"><label for="Date3"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'date3'
                                )) . "</div>";

                            if ($this->request->data['EventType']['code'] == "002") {
                                echo "<div class='form-group'>" . $this->Form->input('assurance_number', array(
                                        'label' => __('Assurance number'),
                                        'placeholder' => __('Enter assurance number'),
                                        'class' => 'form-control',
                                    )) . "</div>";

                                $options = array('1' => __('Public liability'), '2' => __('Collision damage'), '3' => __('All risks'));
                                echo "<div class='form-group'>" . $this->Form->input('assurance_type', array(
                                        'label' => __('Assurance type'),

                                        'type' => 'select',
                                        'options' => $options,
                                        'class' => 'form-control',

                                        'empty' => ''

                                    )) . "</div>";
                            }

                            echo "</div>";
                        } elseif ($this->request->data['EventType']['with_km'] == 1) {
                            $this->request->data['Event']['date'] = $this->Time->format($this->request->data['Event']['date'], '%d-%m-%Y');

                            echo "<div id='interval'><div class='form-group'>" . $this->Form->input('date', array(
                                    'label' => '',
                                    'placeholder' => 'dd/mm/yyyy',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label>' . __('Date event') . '</label><div class="input-group date"><label for="Date"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'date',
                                )) . "</div>";


                            echo "<div class='form-group'>" . $this->Form->input('km', array(
                                    'label' => __('Km'),
                                    'placeholder' => __('Enter Km'),
                                    'id' => 'EventKm',
                                    'class' => 'form-control',
                                )) . "</div>";
                            echo "<div class='form-group'>" . $this->Form->input('next_km', array(
                                    'label' => __('Next km'),
                                    'placeholder' => __('Enter next km'),
                                    'id' => 'EventNextKm',
                                    'class' => 'form-control',
                                )) . "</div></div>";
                        } else {
                            echo "<br/><div id='interval'></div>";
                        }

                        if ($this->request->data['EventEventType']['event_type_id'] == 11) {
                        echo "<div id='refund_amount_div'><div class='form-group'>" . $this->Form->input('refund_amount', array(
                                'label' => __('Refund amount'),
                                'placeholder' => __('Enter refund amount'),
                                'class' => 'form-control',
                                'id' => 'refund_amount'
                                )) . "</div>";

                            $options = array('1' => __('Low'), '2' => __('Medium'), '3' => __('Serious'), '4' => __('Very serious'));
                            echo "<div class='form-group'>" . $this->Form->input('severity_incident', array(
                                'label' => __('Severity incident'),
                                'type' => 'select',
                                'options' => $options,
                                'empty' => '',
                                'id' => 'severity',
                                'class' => 'form-control',
                                )) . "</div>";


                            $options = array('1' => __('Car accident'), '2' => __('Ice break'), '3' => __('Natural disaster'), '4' => __('Fire'), '5' => __('Parking'), '6' => __('Vandalism'), '7' => __('Robbery'), '8' => __('Other'));
                            echo "<div class='form-group'>" . $this->Form->input('sinistre_type', array(
                                'label' => __('Type of sinister'),
                                'type' => 'select',
                                'options' => $options,
                                'empty' => '',
                                'id' => 'severity',
                                'class' => 'form-control',
                                )) . "</div>"; ?>
                            <div style="clear:both"></div><br/>

                            <?php   echo "<div id='interval4'>";

                     echo "<div class='form-group audiv1'>" . $this->Form->input('dommages_corporels', array(
                             'label' => __('Dommages corporels'),
                             'id' => 'dommages_corporels',
                         )) . "</div>";

                     echo "</div></div>"; ;
                            }
			 
			 
			 }

 ?>

                        <div id='maps'>
                        </div>
                        <?php echo "<div id='interval2'>";
                        echo '<div class="lbl1" style="display: inline-block; width: 150px;">' . __("Pay by the driver");
                        echo "</div>";
                        $options = array('1' => __('Yes'), '0' => __('No'));
                        $attributes = array('legend' => false, 'value' => $this->request->data['Event']['pay_customer']);
                        echo $this->Form->radio('pay_customer', $options, $attributes) . "</div>"; ?>

                        <div style="clear:both"></div>
                        <?php echo "<div id='interval3'>";
                        echo '<div class="lbl1" style="display: inline-block; width: 150px; margin-top: 20px">' . __("Refund");
                        echo "</div>";
                        $options = array('1' => __('Yes'), '0' => __('No'));
                        $attributes = array('legend' => false, 'value' => $this->request->data['Event']['refund']);
                        echo $this->Form->radio('refund', $options, $attributes);
                        echo '</br>';
                        echo '</br>';
                        echo '</div>';
						echo "<div id='interval_date_refund'>";
                        echo "<div class='form-group'>" . $this->Form->input('date_refund', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',

                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Refund date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'date_refund',
                            )) . "</div>";
                        echo "</div>";


                        ?>

                        <div style="clear:both"></div>
                        <br/>
                        <?php 
			 if (Configure::read('logistia') == '1'){
			 
			 echo "<div class='form-group'>" . $this->Form->input('diagnostic', array(
                                'label' => __('Diagnostic'),
                                'placeholder' => __('Entrer diagnostic'),
                                'class' => 'form-control',
                            )) . "</div>";
			    
			      echo "<div class='form-group'>" . $this->Form->input('event_time', array(
                                'label' => __('Durré de la réparation'),
                                'placeholder' => __('Entrer durré'),
                                'class' => 'form-control',
                            )) . "</div>";   
			 
			 
			 }else {
			 
			 	echo "<div class='form-group'>" . $this->Form->input('cost', array(
                                'label' => __('Global cost'),
                                'placeholder' => __('Enter cost'),
                                'id' => 'cost',
				'class' => 'form-control',
                            )) . "</div>";
			 
			 }
			
			

                        echo "<div class='form-group'>" . $this->Form->input('obs', array(
                                'label' => __('Observation'),
                                'placeholder' => __('Enter observation'),
                                'class' => 'form-control',
                            )) . "</div>";
			    
			     if (Configure::read('logistia') == '0'){
                        echo '<div class="lbl3">' . __("Attachments") . '</div>';
                            $i = 0;
                            if (!empty($this->request->data['Event']['attachment1'])) {
                                if ($version_of_app == 'web') {
                                    $Dir_attachment1 = 'events';
                                    $id_dialog = 'dialogModalAttachment1Dir';
                                    $id_input = 'attachment1';

                                    ?>
                                    <div id="dialogModalAttachment1Dir">
                                        <!-- the external content is loaded inside this tag -->
                                        <div id="contentWrapAttachment1Dir"></div>
                                    </div>

                                    <?php
                                    echo "<div class='input-button4' id='attachment1'>" . $this->Form->input('attachment1_dir', array(
                                            'label' => __('Attachment 1'),
                                            'readonly' => true,
                                            'class' => 'form-control',
                                        )) . '</div>';

                                    echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),
                                            array("controller" => "events", "action" => "openDir", $Dir_attachment1, $id_dialog, $id_input),
                                            array("class" => "btn btn-default btn-trans waves-effect waves-primary w-md m-b-5 h-bn overlayAttachment1Dir", 'escape' => false, "title" => __(""))) . '</div><div style="clear:both;"></div>';
                                }
                                ?>
                                <!-- COMPONENT START -->
                                    <div  id='attachment1-file'>
                                        <?php
                                        echo "<div style='Display:none;'>" . $this->Form->input('attachment1', array(
                                                'label' => __('Attachment 1'),
                                                'readonly' => true,
                                                'id' => 'attach1',
                                                'type' => 'file',
                                                'class' => 'form-control',
                                            )) . '</div>';

                                        echo "<div class='input-button4' >" . $this->Form->input('file1', array(
                                                'label' => __('Attachment 1'),
                                                'readonly' => true,
                                                'id' => 'file1',
                                                'value' => $this->request->data['Event']['attachment1'],
                                                'class' => 'form-control',
                                            )) . '</div>';
                                        $input = 'attachment1';
                                        echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),

                                                'javascript:;',
                                                array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'upfile1',
                                                )) . '</div>'; ?>
                                        <span class="popupactions">
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg " id='attachment1-btn' type="button"
                         onclick="delete_file('<?php echo $input ?>');"><i
                             class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
            </span>
                                    </div>

                                <div style="clear:both;"></div>
                                <?php $i = 1;
                            } else {
                                echo "<div >" . $this->Form->input('file1', array(
                                        'type' => 'hidden',
                                        'id' => 'file1',
                                        'value' => '',
                                        'class' => 'form-control',
                                    )) . '</div>';
                            } ?>
                            <!-- COMPONENT END -->
                            <?php
                            if (!empty($this->request->data['Event']['attachment2'])) {

                                if ($version_of_app == 'web') {
                                    $Dir_attachment2 = 'events';
                                    $id_dialog = 'dialogModalAttachment2Dir';
                                    $id_input = 'attachment2';
                                    ?>
                                    <div id="dialogModalAttachment2Dir">
                                        <!-- the external content is loaded inside this tag -->
                                        <div id="contentWrapAttachment2Dir"></div>
                                    </div>
                                    <?php
                                    echo "<div class='input-button4' id='attachment2'>" . $this->Form->input('attachment2_dir', array(
                                            'label' => __('Attachment 2'),
                                            'readonly' => true,
                                            'class' => 'form-control',
                                        )) . '</div>';

                                    echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                            array("controller" => "events", "action" => "openDir", $Dir_attachment2, $id_dialog, $id_input),
                                            array("class" => "btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5 overlayAttachment2Dir", 'escape' => false, "title" => __(""))) . '</div><div style="clear:both;"></div>';
                                }
                                ?>
                                <!-- COMPONENT START -->

                                    <div  id='attachment2-file'>

                                        <?php
                                        echo "<div style='Display:none;'>" . $this->Form->input('attachment2', array(
                                                'label' => __('Attachment 2'),
                                                'readonly' => true,
                                                'id' => 'attach2',
                                                'type' => 'file',

                                                'class' => 'form-control',


                                            )) . '</div>';

                                        echo "<div class='input-button4' >" . $this->Form->input('file2', array(
                                                'label' => __('Attachment 2'),
                                                'readonly' => true,
                                                'id' => 'file2',
                                                'value' => $this->request->data['Event']['attachment2'],
                                                'class' => 'form-control',


                                            )) . '</div>';
                                        $input = 'attachment2';
                                        echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),

                                                'javascript:;',
                                                array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'upfile2',
                                                )) . '</div>'; ?>
                                        <span class="popupactions">
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg " id='attachment2-btn' type="button"
                         onclick="delete_file('<?php echo $input ?>');"><i
                             class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
            </span>
                                    </div>

                                <div style="clear:both;"></div>

                                <!-- COMPONENT END -->
                                <?php $i = 2;
                            } else {

                                echo "<div >" . $this->Form->input('file2', array(
                                        'type' => 'hidden',
                                        'id' => 'file2',
                                        'value' => '',
                                        'class' => 'form-control',
                                    )) . '</div>';


                            } ?>

                            <?php
                            if (!empty($this->request->data['Event']['attachment3'])) {
                                if ($version_of_app == 'web') {
                                    $Dir_attachment3 = 'events';
                                    $id_dialog = 'dialogModalAttachment3Dir';
                                    $id_input = 'attachment3';

                                    ?>
                                    <div id="dialogModalAttachment3Dir">
                                        <!-- the external content is loaded inside this tag -->
                                        <div id="contentWrapAttachment3Dir"></div>
                                    </div>

                                    <?php


                                    echo "<div class='input-button4' id='attachment3'>" . $this->Form->input('attachment3_dir', array(
                                            'label' => __('Attachment 3'),
                                            'readonly' => true,

                                            'class' => 'form-control',


                                        )) . '</div>';

                                    echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                            array("controller" => "events", "action" => "openDir", $Dir_attachment3, $id_dialog, $id_input),
                                            array("class" => "btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5 overlayAttachment3Dir", 'escape' => false, "title" => __(""))) . '</div><div style="clear:both;"></div>';
                                }
                                ?>
                                <!-- COMPONENT START -->

                                    <div  id='attachment3-file'>
                                        <?php
                                        echo "<div style='Display:none;'>" . $this->Form->input('attachment3', array(
                                                'label' => __('Attachment 3'),
                                                'readonly' => true,
                                                'id' => 'attach3',
                                                'type' => 'file',
                                                'class' => 'form-control',
                                            )) . '</div>';

                                        echo "<div class='input-button4' >" . $this->Form->input('file3', array(
                                                'label' => __('Attachment 3'),
                                                'readonly' => true,
                                                'id' => 'file3',
                                                'value' => $this->request->data['Event']['attachment3'],
                                                'class' => 'form-control',
                                            )) . '</div>';
                                        $input = 'attachment3';
                                        echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                                'javascript:;',
                                                array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'upfile3',
                                                )) . '</div>'; ?>
                                        <span class="popupactions">
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg " id='attachment3-btn' type="button"
                         onclick="delete_file('<?php echo $input ?>');"><i
                             class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
            </span>
                                    </div>

                                <div style="clear:both;"></div>
                                <?php $i = 3;
                            } else {

                                echo "<div >" . $this->Form->input('file3', array(
                                        'type' => 'hidden',
                                        'id' => 'file3',
                                        'value' => '',
                                        'class' => 'form-control',
                                    )) . '</div>';


                            } ?>
                            <!-- COMPONENT END -->


                            <?php
                            if (!empty($this->request->data['Event']['attachment4'])) {
                                if ($version_of_app == 'web') {

                                    $Dir_attachment4 = 'events';
                                    $id_dialog = 'dialogModalAttachment4Dir';
                                    $id_input = 'attachment4';

                                    ?>
                                    <div id="dialogModalAttachment4Dir">
                                        <!-- the external content is loaded inside this tag -->
                                        <div id="contentWrapAttachment4Dir"></div>
                                    </div>
                                    <?php
                                    echo "<div class='input-button4' id='attachment4'>" . $this->Form->input('attachment4_dir', array(
                                            'label' => __('Attachment 4'),
                                            'readonly' => true,

                                            'class' => 'form-control',


                                        )) . '</div>';

                                    echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                            array("controller" => "events", "action" => "openDir", $Dir_attachment4, $id_dialog, $id_input),
                                            array("class" => "btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5 overlayAttachment4Dir", 'escape' => false, "title" => __(""))) . '</div><div style="clear:both;"></div>';
                                }
                                ?>


                                <!-- COMPONENT START -->

                                    <div  id='attachment4-file'>

                                        <?php
                                        echo "<div style='Display:none;'>" . $this->Form->input('attachment4', array(
                                                'label' => __('Attachment 4'),
                                                'readonly' => true,
                                                'id' => 'attach4',
                                                'type' => 'file',

                                                'class' => 'form-control',


                                            )) . '</div>';

                                        echo "<div class='input-button4' >" . $this->Form->input('file4', array(
                                                'label' => __('Attachment 4'),
                                                'readonly' => true,
                                                'id' => 'file4',
                                                'value' => $this->request->data['Event']['attachment4'],
                                                'class' => 'form-control',


                                            )) . '</div>';
                                        $input = 'attachment4';
                                        echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),

                                                'javascript:;',
                                                array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'upfile4',
                                                )) . '</div>'; ?>
                                        <span class="popupactions-c">
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg " id='attachment4-btn' type="button"
                         onclick="delete_file('<?php echo $input ?>');"><i
                             class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
            </span>
                                    </div>

                                <div style="clear:both;"></div>
                                <?php $i = 4;
                            } else {

                                echo "<div >" . $this->Form->input('file4', array(
                                        'type' => 'hidden',
                                        'id' => 'file4',
                                        'value' => '',
                                        'class' => 'form-control',
                                    )) . '</div>';


                            } ?>
                            <!-- COMPONENT END -->

                            <?php
                            if (!empty($this->request->data['Event']['attachment5'])) {
                                if ($version_of_app == 'web') {

                                    $Dir_attachment5 = 'events';
                                    $id_dialog = 'dialogModalAttachment5Dir';
                                    $id_input = 'attachment5';

                                    ?>
                                    <div id="dialogModalAttachment5Dir">
                                        <!-- the external content is loaded inside this tag -->
                                        <div id="contentWrapAttachment5Dir"></div>
                                    </div>

                                    <?php


                                    echo "<div class='input-button4' id='attachment5'>" . $this->Form->input('attachment5_dir', array(
                                            'label' => __('Attachment 5'),
                                            'readonly' => true,

                                            'class' => 'form-control',


                                        )) . '</div>';

                                    echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                            array("controller" => "events", "action" => "openDir", $Dir_attachment5, $id_dialog, $id_input),
                                            array("class" => "btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5 overlayAttachment5Dir", 'escape' => false, "title" => __(""))) . '</div><div style="clear:both;"></div>';
                                }
                                ?>


                                <!-- COMPONENT START -->

                                    <div  id='attachment5-file'>

                                        <?php
                                        echo "<div style='Display:none;'>" . $this->Form->input('attachment5', array(
                                                'label' => __('Attachment 5'),
                                                'readonly' => true,
                                                'id' => 'attach5',
                                                'type' => 'file',

                                                'class' => 'form-control',


                                            )) . '</div>';

                                        echo "<div class='input-button4' >" . $this->Form->input('file5', array(
                                                'label' => __('Attachment 5'),
                                                'readonly' => true,
                                                'id' => 'file5',
                                                'value' => $this->request->data['Event']['attachment5'],
                                                'class' => 'form-control',


                                            )) . '</div>';
                                        $input = 'attachment5';
                                        echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),

                                                'javascript:;',
                                                array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'upfile5',
                                                )) . '</div>'; ?>
                                        <span class="popupactions">
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg " id='attachment5-btn' type="button"
                         onclick="delete_file('<?php echo $input ?>');"><i
                             class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
            </span>
                                    </div>

                                <div style="clear:both;"></div>
                                <?php $i = 5;
                            } else {

                                echo "<div >" . $this->Form->input('file5', array(
                                        'type' => 'hidden',
                                        'id' => 'file5',
                                        'value' => '',
                                        'class' => 'form-control',
                                    )) . '</div>';


                            } ?>
                            <!-- COMPONENT END -->
                            <?php if ($i < 5) {

                            echo "<div >" . $this->Form->input('nb_attachment', array(
                                    'id' => 'nb_attachment',
                                    'type' => 'hidden',
                                    'value' => $i,
                                    'class' => 'form-control',
                                )) . '</div>';

                            ?>
                            <table   id='dynamic_field' class="table-input">
                                <tr>
                                    <td  class="td-input">
                                        <?php

                                        if($version_of_app=='web') {
                                        $Dir_attachment1='events';
                                        $id_dialog= 'dialogModalAttachment1Dir';
                                        $id_input= 'attachment1';

                                        ?>
                                        <div id="dialogModalAttachment1Dir">
                                            <!-- the external content is loaded inside this tag -->
                                            <div id="contentWrapAttachment1Dir"></div>
                                        </div>
                                        <div id="dialogModalAttachment2Dir">
                                            <!-- the external content is loaded inside this tag -->
                                            <div id="contentWrapAttachment2Dir"></div>
                                        </div>
                                        <div id="dialogModalAttachment3Dir">
                                            <!-- the external content is loaded inside this tag -->
                                            <div id="contentWrapAttachment3Dir"></div>
                                        </div>
                                        <div id="dialogModalAttachment4Dir">
                                            <!-- the external content is loaded inside this tag -->
                                            <div id="contentWrapAttachment4Dir"></div>
                                        </div>
                                        <div id="dialogModalAttachment5Dir">
                                            <!-- the external content is loaded inside this tag -->
                                            <div id="contentWrapAttachment5Dir"></div>
                                        </div>


                                        <div class="input-button4" id="attachment1">
                                            <div class="input text">
                                                <label for="attachment1_dir"></label>
                                                <input id="attachment1_dir" class="form-control" name="data[Event][attachment_dir][]" readonly="readonly" type="text" style="margin-top: 5px;"/>
                                            </div>
                                        </div>

                                        <div class="button-file">
                                            <a class="btn btn-default btn-trans waves-effect waves-primary w-md m-b-5 h-bn overlayAttachment1Dir" href="../events/openDir/events/dialogModalAttachment1Dir/attachment1">
                                                <i class="fa fa-folder-open m-r-5"></i>
                                                <?php echo __('Select'); ?>
                                            </a>
                                        </div>
                        <div style="clear:both;"></div>

                    <?php
                    }
                    ?>




					<div   id="attachment1-file" >
                        <div class="input-button">
							<div class="input file">
								<label for ="att1"></label>
									<input id="att1" class="form-control " name="data[Event][attachment][]"  type="file"/>
							</div>
                        </div>

						<span class="popupactions-c">
							<button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 h-bn btn-marg "  id='attachment1-btn' type="button" onclick="delete_file('attachment1');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
						</span>
				  </div>

			</td>
			<td class="td_tab">
			<button style="margin-left: 40px;" type='button' name='add' id='add' class='btn btn-success'><?=__('Add more')?></button>
			</td>
		</tr>
		</table>


                    <?php }

                 }
		    
		     if (Configure::read('logistia') == '1'){
		           echo "<div id='interval_type' style='padding-top: 20px;'>";
                        echo '<div class="lbl_type"><label>' . __("Alerte");
                        echo "</label></div>";
                        echo "<div class='form-group'>".$this->Form->input('alert_activate', array(
                                'label' => __('Alert activate'),
                                'class' => 'form-control'
                            ))."</div>";
                        echo "<div class='form-group'>".$this->Form->input('renew_after_expiration', array(
                                'label' => __('Renouvler aprés expiration'),
                                'class' => 'form-control'
                            ))."</div>";

                        echo "<div id='interval_type' style='padding-top: 20px;'>";
                        echo '<div class="lbl_type"><label>' . __("Alerte par");
                        echo "</label></div>";
                        $options=array('1'=>__('km'),'0'=>__('date'));
                        $attributes=array('legend'=>false ,'id' => 'alert-type');
                        echo  $this->Form->radio('alert_type',$options,$attributes);

                        echo "<div id='alert-type-iputs'>";
                        echo '<br>';
                        if($this->request->data['Event']['alert_type'] == '0'){
                            $this->request->data['Event']['last_event_date'] = $this->Time->format($this->request->data['Event']['last_event_date'], '%d-%m-%Y');
                            echo "<div class='form-group'>" . $this->Form->input('Event.last_event_date', array(
                                    'label' => '',
                                    'placeholder' => 'dd/mm/yyyy',
                                    'type' => 'text',
                                    'class' => 'form-control datemask date',
                                    'before' => '<label>' . __('Date de dérniére révision') . '</label><div id="last_revision_date" class="input-group"><label for="birthday"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => '',
                                )) . "</div>";
                            echo "<div class='form-group'>".$this->Form->input('date_interval', array(
                                    'label' => __('Interval'),
                                    'class' => 'form-control'
                                ))."</div>";
                            echo "<div class='form-group'>".$this->Form->input('alert_before_days', array(
                                    'label' => __('Alerte avant (journnées'),
                                    'class' => 'form-control'
                                ))."</div>";
                        }elseif($this->request->data['Event']['alert_type'] == '1'){
                            echo "<div class='form-group'>".$this->Form->input('last_event_km', array(
                                    'label' => __('Kilométrage révision'),
                                    'class' => 'form-control',
                                ))."</div>";
                            echo "<div class='form-group'>".$this->Form->input('km_interval', array(
                                    'label' => __('Interval'),
                                    'class' => 'form-control'
                                ))."</div>";
                            echo "<div class='form-group'>".$this->Form->input('alert_before_km', array(
                                    'label' => __('Alerte avant (journnées'),
                                    'class' => 'form-control'
                                ))."</div>";
                        }
                        echo "</div>";
		     
		     }
		    
		    ?>
		    
		    

                        <div style='clear:both; padding-top: 10px;'></div>

                    <!-- COMPONENT END -->
                    <div class="row">
                        <div id="panel-prod" class="col-md-12">
                            <?php
                             if (Configure::read('logistia') == '0'){
                            if ($this->request->data['EventTypeCategoryEventType']['event_type_category_id'] != '8') { ?>
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" href="#collapse1"
                                                   style="font-size: 20px;color: #3c8dbc;font-weight: bold;"><?php echo __('Parts') ?></a>
                                            </h4>
                                        </div>
                                        <div id="collapse1" class="panel-collapse collapse">
                                            <div class="panel-body">


                                                <?php


                                                if (!empty($billProducts)) {
                                                    echo "<div class='form-group'>" . $this->Form->input('Bill.nb_product', array(
                                                            'label' => '',
                                                            'type' => 'hidden',
                                                            'value' => $nb_products - 1,
                                                            'id' => 'nb_product',
                                                            'empty' => ''
                                                        )) . "</div>";

                                                    ?>
                                                    <div id='product'>

                                                        <table class="table table-bordered prod ">
                                                            <thead>
                                                            <tr>
                                                                <th class='th-prod2 mb'></th>
                                                                <th class=" col-sm-6 mb"><?php echo __('Product'); ?></th>
                                                                <th class=" col-sm-6 mb"><?php echo __('Quantity'); ?></th>
                                                                <th style='display:none;'><?php echo __('Total'); ?></th>
                                                            </tr>
                                                            </thead>


                                                            <tbody id='table_products'>

                                                            <?php
                                                            $i = 0;
                                                            foreach ($billProducts as $billProduct): ?>
                                                            <tr id='product<?php echo $i ?>'>

                                                                <td>
                                                                    <!--<a id='delete_product0' onclick='DeleteProduct(this.id)'><i class="fa fa-trash-o m-r-5 dlt"></i></a>-->
                                                                    <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 dlt2"></i>',
                                                                        'javascript:DeleteProduct(this.id);',
                                                                        array('escape' => false, 'id' => 'delete_product' . $i, 'onclick' => 'javascript:DeleteProduct(this.id);',)); ?>
                                                                </td>
                                                                <td> <?php echo "<div class='form-group' >" . $this->Form->input('Product.' . $i . '.product', array(
                                                                            'label' => '',
                                                                            'class' => 'form-control',
                                                                            'value' => $billProduct['BillProduct']['product_id'],
                                                                            'type' => 'select',
                                                                            'option' => $products,
                                                                            'id' => 'product_name' . $i,
                                                                            'onchange' => 'javascript:quantityMax(this.id);',
                                                                            'empty' => '',
                                                                        )) . "</div>"; ?>
                                                                </td>
                                                                <td><?php echo "<div class='form-group'>" . $this->Form->input('Product.' . $i . '.quantity', array(
                                                                            'label' => '',
                                                                            'class' => 'form-control',
                                                                            'value' => $billProduct['BillProduct']['quantity'],
                                                                            'id' => 'quantity' . $i,
                                                                            'onchange' => 'javascript:calculPrice(this.id);',
                                                                            'placeholder' => __('Enter quantity'),
                                                                            'empty' => ''
                                                                        )) . "</div>";


                                                                    ?>
                                                                    <span id='quantity_max<?php echo $i ?>'>
                <span id='msg<?php echo $i ?>'>
                <?php echo $this->Form->input('tva', array(
                    'label' => __('tva'),
                    'class' => 'form-control',
                    'value' => $billProduct['Product']['Tva']['tva_val'],
                    'type' => 'hidden',
                    'id' => 'tva_prod' . $i,
                    'empty' => ''
                ));
                echo $this->Form->input('price', array(
                    'label' => __('price'),
                    'class' => 'form-control',
                    'value' => $billProduct['Product']['pmp'],
                    'type' => 'hidden',
                    'id' => 'price_prod' . $i,
                    'empty' => ''
                ));
                ?>
                </span>
                                                                </td>


                                                                <td style='display:none;'> <?php echo "<div class='form-group' >" . $this->Form->input('BillProduct.' . $i . '.price_ht', array(
                                                                            'label' => "price ht",
                                                                            'class' => 'form-control ',
                                                                                'value' => $billProduct['BillProduct']['price_ht'],
                                                                            'id' => 'ht' . $i,
                                                                            'type' => 'hidden',
                                                                            'empty' => ''
                                                                        )) . "</div>";
                                                                    echo "<div class='form-group' >" . $this->Form->input('BillProduct.' . $i . '.price_ttc', array(
                                                                            'label' => "price ttc",
                                                                            'class' => 'form-control',
                                                                            'value' => $billProduct['BillProduct']['price_ttc'],
                                                                            'id' => 'ttc' . $i,
                                                                            'type' => 'hidden',
                                                                            'empty' => ''
                                                                        )) . "</div>";
                                                                    echo "<div class='form-group' >" . $this->Form->input('BillProduct.' . $i . '.price_tva', array(
                                                                            'label' => "price tva",
                                                                            'class' => 'form-control',
                                                                            'value' => $billProduct['BillProduct']['price_tva'],
                                                                            'id' => 'tva' . $i,
                                                                            'type' => 'hidden',
                                                                            'empty' => ''
                                                                        )) . "</div>"; ?>


                                                                    <div id="total<?php echo $i ?>"><span
                                                                                style="float: right;"><?php echo $billProduct['BillProduct']['price_ttc']; ?></span>
                                                                    </div>

                                                                </td>


                                                                <?php
                                                                $i++;
                                                                endforeach; ?>
                                                            </tbody>


                                                        </table>


                                                    </div>
                                                    <br/>
                                                    <div class="btn-group pull-left">
                                                        <div class="header_actions">
                                                            <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add Product'),
                                                                'javascript:addProductBill();',
                                                                array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'add_product')) ?>

                                                        </div>
                                                    </div>

                                                    </br></br></br>

                                                    <table class="table table-bordered price " style='display:none;'>
                                                        <tbody>
                                                        <tr>
                                                            <td class="total-price"><span
                                                                        style="float: right; font-weight: bold;"><?php echo __('Total HT'); ?></span>
                                                            </td>
                                                            <td>
                                                                <div id='total_ht'><span
                                                                            style="float: right;"><?php echo $bill['Bill']['total_ht']; ?></span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="total-price"><span
                                                                        style="float: right; font-weight: bold;"><?php echo __('Total TVA'); ?></span>
                                                            </td>
                                                            <td>
                                                                <div id='total_tva'><span
                                                                            style="float: right;"><?php echo $bill['Bill']['total_tva']; ?></span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="total-price"><span
                                                                        style="float: right; font-weight: bold;"><?php echo __('Total TTC'); ?></span>
                                                            </td>
                                                            <td>
                                                                <div id='total_ttc'><span
                                                                            style="float: right;"><?php echo $bill['Bill']['total_ttc']; ?></span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </tbody>

                                                    </table>


                                                    <?php echo "<div class='form-group'>" . $this->Form->input('Bill.total_ht', array(
                                                            'label' => __('Total HT'),
                                                            'id' => 'price_ht',
                                                            'type' => 'hidden',
                                                            'class' => 'form-control',
                                                        )) . "</div>";
                                                    echo "<div class='form-group'>" . $this->Form->input('Bill.total_ttc', array(
                                                            'label' => __('Total TTC'),
                                                            'id' => 'price_ttc',
                                                            'type' => 'hidden',
                                                            'class' => 'form-control',
                                                        )) . "</div>";
                                                    echo "<div class='form-group'>" . $this->Form->input('Bill.total_tva', array(
                                                            'label' => __('Total TVA'),
                                                            'id' => 'price_tva',
                                                            'type' => 'hidden',
                                                            'class' => 'form-control',
                                                        )) . "</div>";


                                                } else {


                                                    echo "<div class='form-group'>" . $this->Form->input('Bill.nb_product', array(
                                                            'label' => '',
                                                            'type' => 'hidden',
                                                            'value' => 0,
                                                            'id' => 'nb_product',
                                                            'empty' => ''
                                                        )) . "</div>";

                                                    ?>
                                                    <div id='product'>

                                                        <table class="table table-bordered prod ">
                                                            <thead>
                                                            <tr>
                                                                <th class='th-prod2  mb'></th>
                                                                <th class=" col-sm-6 mb"><?php echo __('Product'); ?></th>
                                                                <th class=" col-sm-6 mb"><?php echo __('Qty'); ?></th>
                                                                <th style='display:none;'><?php echo __('Total'); ?></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id='table_products'>

                                                            <tr id='product0'>

                                                                <td>
                                                                    <!--<a id='delete_product0' onclick='DeleteProduct(this.id)'><i class="fa fa-trash-o m-r-5 dlt"></i></a>-->
                                                                    <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 dlt2"></i>',
                                                                        'javascript:DeleteProduct(this.id);',
                                                                        array('escape' => false, 'id' => 'delete_product0', 'onclick' => 'javascript:DeleteProduct(this.id);')); ?>
                                                                </td>
                                                                <td> <?php echo "<div class='form-group' id='products0'>" . $this->Form->input('Product.0.product', array(
                                                                            'label' => __('Name'),
                                                                            'class' => 'form-control',
                                                                            'id' => 'product_name0',
                                                                            'type' => 'select',
                                                                            'option' => $products,
                                                                            'onchange' => 'javascript:quantityMax(this.id);',
                                                                            'empty' => ''
                                                                        )) . "</div>"; ?>

                                                                </td>
                                                                <td><?php echo "<div class='form-group'>" . $this->Form->input('Product.0.quantity', array(
                                                                            'label' => __('Quantity'),
                                                                            'class' => 'form-control',
                                                                            'id' => 'quantity0',
                                                                            'onchange' => 'javascript:calculPrice(this.id);',
                                                                            'empty' => ''
                                                                        )) . "</div>"; ?>
                                                                    <span id='quantity_max0'>
                </span>
                                                                    <span id='msg0'>
                </span>
                                                                </td>


                                                                <td style='display:none;'> <?php echo "<div class='form-group group g1' >" . $this->Form->input('BillProduct.0.price_ht', array(
                                                                            'label' => "price ht",
                                                                            'class' => 'form-control form-prod',
                                                                            'id' => 'ht0',
                                                                            'type' => 'hidden',
                                                                            'empty' => ''
                                                                        )) . "</div>";
                                                                    echo "<div class='form-group group g1' >" . $this->Form->input('BillProduct.0.price_ttc', array(
                                                                            'label' => "price ttc",
                                                                            'class' => 'form-control form-prod',
                                                                            'id' => 'ttc0',
                                                                            'type' => 'hidden',
                                                                            'empty' => ''
                                                                        )) . "</div>";
                                                                    echo "<div class='form-group group g1' >" . $this->Form->input('BillProduct.0.price_tva', array(
                                                                            'label' => "price tva",
                                                                            'class' => 'form-control form-prod',
                                                                            'id' => 'tva0',
                                                                            'type' => 'hidden',
                                                                            'empty' => ''
                                                                        )) . "</div>"; ?>

                                                                    <div id='total0'><span
                                                                                style="float: right;">0.00</span></div>

                                                                </td>

                                                            </tr>
                                                            </tbody>
                                                        </table>


                                                    </div>
                                                    <br/>
                                                    <div class="btn-group pull-left">
                                                        <div class="header_actions">
                                                            <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add Product'),
                                                                'javascript:addProductBill();',
                                                                array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'add_product')) ?>

                                                        </div>
                                                    </div>

                                                    </br></br></br>

                                                    <table class="table table-bordered price " style='display:none;'>
                                                        <tbody>
                                                        <tr>
                                                            <td class="total-price"><span
                                                                        style="float: right; font-weight: bold;"><?php echo __('Total HT'); ?></span>
                                                            </td>
                                                            <td>
                                                                <div id='total_ht'><span
                                                                            style="float: right;">0.00</span></div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="total-price"><span
                                                                        style="float: right; font-weight: bold;"><?php echo __('Total TVA'); ?></span>
                                                            </td>
                                                            <td>
                                                                <div id='total_tva'><span
                                                                            style="float: right;">0.00</span></div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="total-price"><span
                                                                        style="float: right; font-weight: bold;"><?php echo __('Total TTC'); ?></span>
                                                            </td>
                                                            <td>
                                                                <div id='total_ttc'><span
                                                                            style="float: right;">0.00</span></div>
                                                            </td>
                                                        </tr>
                                                        </tbody>

                                                    </table>


                                                    <?php echo "<div class='form-group'>" . $this->Form->input('Bill.total_ht', array(
                                                            'label' => __('Total HT'),
                                                            'id' => 'price_ht',
                                                            'type' => 'hidden',
                                                            'class' => 'form-control',
                                                        )) . "</div>";
                                                    echo "<div class='form-group'>" . $this->Form->input('Bill.total_ttc', array(
                                                            'label' => __('Total TTC'),
                                                            'id' => 'price_ttc',
                                                            'type' => 'hidden',
                                                            'class' => 'form-control',
                                                        )) . "</div>";
                                                    echo "<div class='form-group'>" . $this->Form->input('Bill.total_tva', array(
                                                            'label' => __('Total TVA'),
                                                            'id' => 'price_tva',
                                                            'type' => 'hidden',
                                                            'class' => 'form-control',
                                                        )) . "</div>";

                                                }

                                                ?>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            <?php } 
			    }
			    
			    ?>

                        </div>
                    </div>


                </div>


                <div class="tab-pane" id="tab_2">


                    <div class="panel-group" id="accordion">

                        <?php echo "<div class='form-group'>" . $this->Form->input('nb_payment', array(
                                'label' => '',
                                'type' => 'hidden',
                                'value' => $nb_payment,
                                'id' => 'nb_payment',
                                'empty' => ''
                            )) . "</div>";

                        if (!empty($payments)) { ?>
                        <div class="panel panel-default" id='payment'>
                            <?php $i = 0;


                            foreach ($payments as $payment) { ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion"
                                               href="#payment<?php echo $i ?>"><?php echo __('Payment ') ?><?php echo $i + 1; ?></a>
                                        </h4>
                                    </div>
                                    <div id="payment<?php echo $i ?>" class='panel-collapse collapse in'>
                                        <div class="panel-body">
                                            <?php

                                            echo "<div class='form-group'>" . $this->Form->input('Payment.' . $i . '.reference', array(
                                                    'label' => __('Reference'),
                                                    'placeholder' => __('Enter reference'),
                                                    'value' => $payment['Payment']['reference'],
                                                    'class' => 'form-control',
                                                )) . "</div>";

                                            $payment['Payment']['receipt_date'] = $this->Time->format($payment['Payment']['receipt_date'], '%d-%m-%Y');
                                            echo "<div class='form-group'>" . $this->Form->input('Payment.' . $i . '.receipt_date', array(
                                                    'label' => '',
                                                    'placeholder' => 'dd/mm/yyyy',
                                                    'type' => 'text',
                                                    'value' => $payment['Payment']['receipt_date'],
                                                    'class' => 'form-control datemask',
                                                    'before' => '<label>' . __('Payment date') . '</label><div class="input-group date"><label for="CarPaymentDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                                    'after' => '</div>',
                                                    'id' => 'receipt_date' . $i,
                                                )) . "</div>";
                                            echo "<div class='form-group'>" . $this->Form->input('Payment.'.$i.'.compte_id', array(
                                                    'label' => __('Compte'),
                                                    'empty' => '',
                                                    'class' => 'form-control',
                                                )) . "</div>";
                                            if (Configure::read("cafyb") == '1') {
                                                $options = $paymentMethods ;
                                            }else {
                                                $options = array('1' => __('Species'), '2' => __('Transfer'), '3' => __('Bank check'));
                                            }
                                            echo "<div class='form-group'>" . $this->Form->input('Payment.' . $i . '.payment_type', array(
                                                    'label' => __('Payment type'),
                                                    'empty' => '',
                                                    'value' => $payment['Payment']['payment_type'],
                                                    'type' => 'select',
                                                    'options' => $options,
                                                    'class' => 'form-control',
                                                )) . "</div>";

                                            echo "<div class='form-group'>" . $this->Form->input('Payment.' . $i . '.interfering_id', array(
                                                    'label' => __('Interfering'),
                                                    'empty' => '',
                                                    'value' => $payment['Payment']['interfering_id'],
                                                    'class' => 'form-control select2',
                                                )) . "</div>";
                                            echo "<div class='form-group'>" . $this->Form->input('Payment.' . $i . '.amount', array(
                                                    'label' => __('Amount'),
                                                    'placeholder' => __('Enter amount'),
                                                    'type' => 'number',
                                                    'value' => $payment['Payment']['amount'],
                                                    'class' => 'form-control',
                                                )) . "</div>";


                                            echo "<div class='form-group'>" . $this->Form->input('Payment.' . $i . '.note', array(
                                                    'label' => __('Note'),
                                                    'rows' => '6',
                                                    'cols' => '30',
                                                    'value' => $payment['Payment']['note'],
                                                    'placeholder' => __('Enter note'),
                                                    'class' => 'form-control',
                                                )) . "</div>";

                                            ?>

                                        </div>
                                    </div>
                                </div>
                                <?php $i++;
                            }


                            } else { ?>

                                <div class="panel-group" id="accordion">

                                    <?php echo "<div class='form-group'>" . $this->Form->input('nb_payment', array(
                                            'label' => '',
                                            'type' => 'hidden',
                                            'value' => 0,
                                            'id' => 'nb_payment',
                                            'empty' => ''
                                        )) . "</div>"; ?>


                                    <div class="panel panel-default" id='payment'>
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion"
                                                   href="#payment0"><?php echo __('Payment ') ?>1</a>
                                            </h4>
                                        </div>
                                        <div id="payment0" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <?php

                                                echo "<div class='form-group'>" . $this->Form->input('Payment.0.reference', array(
                                                        'label' => __('Reference'),
                                                        'placeholder' => __('Enter reference'),
                                                        'class' => 'form-control',
                                                    )) . "</div>";
                                                $current_date = date("Y-m-d");
                                                echo "<div class='form-group'>" . $this->Form->input('Payment.0.receipt_date', array(
                                                        'label' => '',
                                                        'placeholder' => 'dd/mm/yyyy',
                                                        'type' => 'text',
                                                        'value' => $this->Time->format($current_date, '%d-%m-%Y'),
                                                        'class' => 'form-control datemask',
                                                        'before' => '<label>' . __('Payment date') . '</label><div class="input-group date"><label for="CarPaymentDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                                        'after' => '</div>',
                                                        'id' => 'receipt_date0',
                                                    )) . "</div>";

                                                echo "<div class='form-group'>" . $this->Form->input('Payment.0.compte_id', array(
                                                        'label' => __('Compte'),
                                                        'empty' => '',
                                                        'class' => 'form-control',
                                                    )) . "</div>";

                                                $options = array('1' => __('Species'), '2' => __('Transfer'), '3' => __('Bank check'));
                                                echo "<div class='form-group'>" . $this->Form->input('Payment.0.payment_type', array(
                                                        'label' => __('Payment type'),
                                                        'empty' => __('Select payment type'),
                                                        'type' => 'select',
                                                        'options' => $options,
                                                        'class' => 'form-control',
                                                    )) . "</div>";

                                                echo "<div class='form-group'>" . $this->Form->input('Payment.0.interfering_id', array(
                                                        'label' => __('Interfering'),
                                                        'empty' => '',

                                                        'class' => 'form-control select2',
                                                    )) . "</div>";
                                                echo "<div class='form-group'>" . $this->Form->input('Payment.0.amount', array(
                                                        'label' => __('Amount'),
                                                        'placeholder' => __('Enter amount'),
                                                        'type' => 'number',
                                                        'class' => 'form-control',
                                                    )) . "</div>";


                                                echo "<div class='form-group'>" . $this->Form->input('Payment.0.note', array(
                                                        'label' => __('Note'),
                                                        'rows' => '6',
                                                        'cols' => '30',
                                                        'placeholder' => __('Enter note'),
                                                        'class' => 'form-control',
                                                    )) . "</div>";

                                                ?>

                                            </div>
                                        </div>
                                    </div>


                                </div>

                            <?php } ?>
                        </div>


                        <div class="btn-group pull-left">
                            <div class="header_actions">
                                <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add Payment'),
                                    'javascript:addPayment();',
                                    array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'add_payment')) ?>

                            </div>
                        </div>
                        <br/></br><br/>

                    </div>


                </div>


            </div>
            <?php

            if ($version_of_app == 'web') { ?>
                <div class='progress-div' id="progress-div">
                    <div class='progress-bar1' id="progress-bar">
                        <div id="progress-status1">0 %</div>
                    </div>
                </div>
            <?php } ?>

            <div class="box-footer">
                <?php

                if ($version_of_app == 'web') {
                    echo $this->Form->submit(__('Submit'), array(
                        'name' => 'ok',
                        'class' => 'btn btn-primary btn-bordred  m-b-5',
                        'label' => __('Submit'),
                        //'type' => 'submit',
                        'onclick' => 'javascript:submitForm();',
                        'div' => false
                    ));
                } else {
                    echo $this->Form->submit(__('Submit'), array(
                        'name' => 'ok',
                        'class' => 'btn btn-primary btn-bordred  m-b-5',
                        'label' => __('Submit'),
                        'id' => 'ok',
                        'type' => 'submit',
                        'id'=>'boutonValider',
                        'div' => false
                    ));
                }


                ?>
                <?php echo $this->Form->submit(__('Cancel'), array(
                    'name' => 'cancel',
                    'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                    'label' => __('Cancel'),
                    'type' => 'submit',
                    'div' => false,
                    'formnovalidate' => true
                )); ?>
            </div>
        </div>


    </div>



</div>
</div>
<?php $this->start('script'); ?>

<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('jquery-2.1.1.min.js'); ?>
<?= $this->Html->script('jquery.form.min.js'); ?>
<script type="text/javascript">


    $(document).ready(function() {
        jQuery("#date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#receipt_date0").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        jQuery(".datetime-workshop").datetimepicker({
            format:'DD/MM/YYYY HH:mm',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            }
        });

        $('.datetime-workshop').click(function(){
            var popup =$(this).offset();
            var popupTop = popup.left;
            $('.bootstrap-datetimepicker-widget').css({
                'bottom' : 10,
                'left' : 10,
                'height' : 300,
                'top' :38,
                'z-index': 99999,
                'background-color' : '#fff',
                'font-size':11
            });
            checkIfMechanicIsAvailable();
        });
        for (i = 0; i <= jQuery("#nb_payment").val(); i++) {

            jQuery("#receipt_date" + '' + i + '').inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        }

        Array.prototype.inArray = function (value) {
            // Returns true if the passed value is found in the
            // array. Returns false if it is not.
            var i;
            for (i = 0; i < this.length; i++) {
                if (this[i] == value) {
                    return true;
                }
            }
            return false;
        };
        var typeArr = [1, 6, 7, 8, 15, 19, 24];
        //use of inArray
        if (typeArr.inArray(jQuery('#type').val())) {
            jQuery("#interval2").css("display", "block");
            jQuery("#interval3").css("display", "block");
            jQuery("#interval_date_refund").css("display", "block");
        }
        else {
            if (jQuery('#type').val() == 12 || jQuery('#type').val() == 11) {
                var id = jQuery("#EventId").val();


                jQuery('#maps').load('<?php echo $this->Html->url('/events/getLocalisation/')?>' + id, function () {
                    var latlng = jQuery('#latlng').val();

                    if (latlng = '') {

                        var geolocationAPI = navigator.geolocation;
                        navigator.geolocation.getCurrentPosition(successfunction, errorfunction);

                        function errorfunction(error) {
                            console.log(error);
                        }

                        function successfunction(position) {
                            myLatitude = position.coords.latitude;
                            myLongitude = position.coords.longitude;

                            google.maps.event.addDomListener(window, 'load', initialize(myLatitude, myLongitude, 15, "map"));
                        }
                    } else {
                        var latlng = jQuery('#latlng').val();
                        latlng = latlng.substring(1);

                        latlng = latlng.substring(0, latlng.length - 1);

                        latlng = latlng.split(",");

                        google.maps.event.addDomListener(window, 'load', initialize(latlng[0], latlng[1], 15, "map"));


                    }
                    function traiteAdresse(marker, latLng, infowindow, map) {
                        //recadre et zomme sur les coordonnées latLng

                        map.setCenter(latLng);
                        map.setZoom(14);
                        //on stocke nos nouvelles coordonée dans le champs correspondant
                        document.getElementById('latlng').value = latLng;
                        //on va rechercher les information sur l'adresse correspondant à ces coordonnées
                        geocoder.geocode({
                            'latLng': latLng
                        }, function (results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                if (results[1]) {
                                    infowindow.setContent(results[0].formatted_address);
                                    //on stocke l'adresse complète

                                    document.getElementById("addresspicker").value = results[0].formatted_address;

                                    var nb_el = results[0].address_components.length;
                                    //et ses différentes composantes séparément

                                    infowindow.open(map, marker);
                                } else {
                                    alert("No results found");

                                }
                            } else {
                                alert("Geocoder failed due to: " + status);
                            }
                        });
                    }

                    //fonction initialisant la carte
                    function initialize(lat, lng, zoom, carte) {

                        geocoder = new google.maps.Geocoder();
                        //par défaut on prend les coordonnées entré dans notre champs latlng

                        var latlng = new google.maps.LatLng(lat, lng)

                        //on initialise notre carte
                        var options = {
                            center: new google.maps.LatLng(lat, lng),
                            zoom: zoom,
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        };
                        var map = new google.maps.Map(document.getElementById(carte), options);
                        //on indique que notre champ addresspicker doit proposer les adresses existantes
                        var input = document.getElementById('addresspicker');

                        var autocomplete = new google.maps.places.Autocomplete(input);
                        autocomplete.bindTo('bounds', map);
                        //mise en place du marqueur
                        var infowindow = new google.maps.InfoWindow();
                        var marker = new google.maps.Marker({
                            map: map
                        });
                        //déplacable
                        marker.setDraggable(true);
                        marker.setPosition(latlng);


                        document.getElementById('latlng').value = latlng;
                        geocoder.geocode({
                            'latLng': latlng
                        }, function (results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                if (results[1]) {
                                    infowindow.setContent(results[0].formatted_address);
                                    //on stocke l'adresse complète

                                    document.getElementById("addresspicker").value = results[0].formatted_address;

                                    var nb_el = results[0].address_components.length;
                                    //et ses différentes composantes séparément

                                    infowindow.open(map, marker);
                                } else {
                                    alert("No results found");

                                }
                            } else {
                                alert("Geocoder failed due to: " + status);
                            }
                        });

                        //quand on relache notre marqueur on réinitialise la carte avec les nouvelle coordonnées
                        google.maps.event.addListener(marker, 'dragend', function (event) {

                            traiteAdresse(marker, event.latLng, infowindow, map);
                        });

                        //quand on choisie une adresse proposée on réinitialise la carte avec les nouvelles coordonnées
                        google.maps.event.addListener(autocomplete, 'place_changed', function () {

                            infowindow.close();
                            var place = autocomplete.getPlace();
                            marker.setPosition(place.geometry.location);
                            traiteAdresse(marker, place.geometry.location, infowindow, map);
                        });
                    }

                    if (jQuery('#type').val() == 11) {
                        jQuery("#reason-payed").css("display", "none");

                    }
                });


            }
            else {
                jQuery('#reason').val('');
                jQuery('#addresspicker').val('');
                jQuery('#latlng').val('');
                jQuery("#maps").css("display", "none");
            }
            jQuery("#interval2").css("display", "none");
            jQuery("#interval3").css("display", "none");
            jQuery("#interval_date_refund").css("display", "none");

        }


        jQuery('#type').change(function () {
            if ($(this).val()) {
                jQuery('#interval').load('<?php echo $this->Html->url('/events/getIntervals/')?>' + jQuery(this).val()+'/'+jQuery('#cars').val(), function () {
                    jQuery(".date").datetimepicker({

                        format:'DD/MM/YYYY',
                        icons: {
                            time: "fa fa-clock-o",
                            date: "fa fa-calendar",
                            up: "fa fa-arrow-up",
                            down: "fa fa-arrow-down"
                        }


                    });
                    $('.date').click(function(){
                        var popup =$(this).offset();
                        var popupTop = popup.left;
                        $('.bootstrap-datetimepicker-widget').css({
                            'bottom' : 10,
                            'left' : 10,
                            'height' : 250
                        });
                    });
                    if (jQuery('#vidange_hour').val() == 1) {
                        jQuery("label[for='EventKm']").text("<?php echo __('Hours consumed') ?>");
                        jQuery("#EventKm").attr("placeholder", "<?php echo __('Enter hours consumed') ?>");

                        jQuery("label[for='EventNextKm']").text("<?php echo __('Next oil change') ?>");
                        jQuery("#EventNextKm").attr("placeholder", "<?php echo __('Enter next oil change') ?>");

                    } else {
                        jQuery("label[for='EventKm']").text("<?php echo __('Km') ?>");
                        jQuery("#EventKm").attr("placeholder", "<?php echo __('Enter km') ?>");

                        jQuery("label[for='EventNextKm']").text("<?php echo __('Next km') ?>");
                        jQuery("#EventNextKm").attr("placeholder", "<?php echo __('Enter next km') ?>");

                    }

                });

                //jQuery('#interfering').load('<?php echo $this->Html->url('/events/getInterferingsByType/')?>' + jQuery(this).val()+'/'+0);
                jQuery('#interfering').load('<?php echo $this->Html->url('/events/getInterferingsByType/')?>' + jQuery(this).val() + '/' + 0, function () {
                    jQuery("#dialogModalInterfering").dialog({
                        autoOpen: false,
                        height: 590,
                        width: 400,
                        show: {
                            effect: "blind",
                            duration: 400
                        },
                        hide: {
                            effect: "blind",
                            duration: 500
                        },
                        modal: true
                    });
                    jQuery(".overlayInterfering").click(function (event) {
                        event.preventDefault();
                        jQuery('#contentWrapInterfering').load(jQuery(this).attr("href"));  //load content from href of link
                        jQuery('#dialogModalInterfering').dialog('option', 'title', jQuery(this).attr("title"));  //make dialog title that of link
                        jQuery('#dialogModalInterfering').dialog('open');  //open the dialog
                    });


                    jQuery('#EventCategoryInterfering1').change(function () {

                        jQuery('#Payment0InterferingId').val(jQuery('#EventCategoryInterfering1').val());
                    });
                });
                jQuery('#panel-prod').load('<?php echo $this->Html->url('/events/getCategoryEvent/')?>' + jQuery(this).val());
                var typeArr = [1, 6, 7, 8, 15, 19, 24];
//use of inArray
                if (typeArr.inArray(jQuery('#type').val())) {
                    jQuery("#interval2").css("display", "block");
                    jQuery("#interval3").css("display", "block");
                    jQuery("#interval_date_refund").css("display", "block");
                }
                else {
                    jQuery("#interval2").css("display", "none");
                    jQuery("#interval3").css("display", "none");
                    jQuery("#interval_date_refund").css("display", "none");
                }
                if (jQuery('#type').val() == 11) {
                    jQuery('#assurance-div').css("display", "block");
                    jQuery('#assurance-div').load('<?php echo $this->Html->url('/events/getNumAssurance/')?>' + jQuery('#cars').val());
                    jQuery("#refund_amount_div").css("display", "block");
                } else {

                    if (jQuery('#type').val() == 12) {

                        jQuery('#maps').load('<?php echo $this->Html->url('/events/getLocalisation')?>');

                        var geolocationAPI = navigator.geolocation;
                        navigator.geolocation.getCurrentPosition(successfunction, errorfunction);

                        function errorfunction(error) {
                            console.log(error);
                        }

                        function successfunction(position) {
                            myLatitude = position.coords.latitude;
                            myLongitude = position.coords.longitude;

                            google.maps.event.addDomListener(window, 'load', initialize(myLatitude, myLongitude, 15, "map"));
                        }

                        jQuery('#maps').css("display", "block");
                    }
                    else {
                        jQuery('#reason').val('');
                        jQuery('#addresspicker').val('');
                        jQuery('#latlng').val('');
                        jQuery("#maps").css("display", "none");
                    }

                    jQuery('#num_assurance').val('');
                    jQuery('#refund_amount').val('');
                    jQuery('#assurance-div').css("display", "none");
                    jQuery("#refund_amount_div").css("display", "none");

                }
            }

        });

        if (jQuery('#type-category').val() != 8) jQuery("#panel-prod").css("display", "block");
        else jQuery("#panel-prod").css("display", "none");


        jQuery('#EventPayCustomer1').change(function () {

            jQuery("#interval3").css("display", "block");

        });


        jQuery('#EventPayCustomer0').change(function () {

            jQuery("#interval3").css("display", "none");


        });
		
		
		jQuery('#EventRefund1').change(function () {

            jQuery("#interval_date_refund").css( "display", "block" );
        });
        jQuery('#EventRefund0').change(function ()  {

            jQuery("#interval_date_refund").css( "display", "none" );
        });


        jQuery('#cars').change(function () {
            jQuery('#customers-div').load('<?php echo $this->Html->url('/events/getCustomersByCar/')?>' + jQuery('#cars').val(), function () {
                jQuery('.select2').select2();
                if (jQuery('#vidange_hour').val() == 1) {
                    jQuery("label[for='EventKm']").text("<?php echo __('Hours consumed') ?>");
                    jQuery("#EventKm").attr("placeholder", "<?php echo __('Enter hours consumed') ?>");

                    jQuery("label[for='EventNextKm']").text("<?php echo __('Next oil change') ?>");
                    jQuery("#EventNextKm").attr("placeholder", "<?php echo __('Enter next oil change') ?>");

                } else {
                    jQuery("label[for='EventKm']").text("<?php echo __('Km') ?>");
                    jQuery("#EventKm").attr("placeholder", "<?php echo __('Enter km') ?>");

                    jQuery("label[for='EventNextKm']").text("<?php echo __('Next km') ?>");
                    jQuery("#EventNextKm").attr("placeholder", "<?php echo __('Enter next km') ?>");

                }


            });

            getKmCar();

            if (jQuery('#type').val() == 11) {
                jQuery('#assurance-div').css("display", "block");
                jQuery('#assurance-div').load('<?php echo $this->Html->url('/events/getNumAssurance/')?>' + jQuery('#cars').val());

            } else {

                jQuery('#num_assurance').val('');

                jQuery('#assurance-div').css("display", "none");


            }
        });
        <?php if($this->request->data['EventType']['with_date'] == 1){ ?>
        jQuery("#date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#nextdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#date3").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        <?php } ?>

        jQuery("#dialogModal").dialog({
            autoOpen: false,
            height: 470,
            width: 400,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery(".overlay").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrap').load(jQuery(this).attr("href"));  //load content from href of link
            jQuery('#dialogModal').dialog('option', 'title', jQuery(this).attr("title"));  //make dialog title that of link
            jQuery('#dialogModal').dialog('open');  //open the dialog
        });

        jQuery("#dialogModalInterfering").dialog({
            autoOpen: false,
            height: 590,
            width: 400,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery(".overlayInterfering").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapInterfering').load(jQuery(this).attr("href"));  //load content from href of link
            jQuery('#dialogModalInterfering').dialog('option', 'title', jQuery(this).attr("title"));  //make dialog title that of link
            jQuery('#dialogModalInterfering').dialog('open');  //open the dialog
        });

        var products_id = new Array();
        jQuery("#delete_product0").css("display", "none");



        $("#upfile1").click(function () {
            $("#attach1").trigger('click');

        });

        $("#attach1").change(function () {

            $("#file1").val($("#attach1").val());

        });

        $("#upfile2").click(function () {
            $("#attach2").trigger('click');

        });

        $("#attach2").change(function () {

            $("#file2").val($("#attach2").val());

        });

        $("#upfile3").click(function () {
            $("#attach3").trigger('click');

        });

        $("#attach3").change(function () {

            $("#file3").val($("#attach3").val());

        });

        $("#upfile4").click(function () {
            $("#attach4").trigger('click');

        });

        $("#attach4").change(function () {

            $("#file4").val($("#attach4").val());

        });

        $("#upfile5").click(function () {
            $("#attach5").trigger('click');

        });

        $("#attach5").change(function () {

            $("#file5").val($("#attach5").val());

        });

        jQuery("#dialogModalAttachment1Dir").dialog({
            autoOpen: false,
            height: 500,
            width: 700,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery(".overlayAttachment1Dir").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapAttachment1Dir').load(jQuery(this).attr("href"));
            //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalAttachment1Dir').dialog('open');
        });


        jQuery("#dialogModalAttachment2Dir").dialog({
            autoOpen: false,
            height: 500,
            width: 700,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery(".overlayAttachment2Dir").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapAttachment2Dir').load(jQuery(this).attr("href"));
            //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalAttachment2Dir').dialog('open');
        });

        jQuery("#dialogModalAttachment3Dir").dialog({
            autoOpen: false,
            height: 500,
            width: 700,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery(".overlayAttachment3Dir").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapAttachment3Dir').load(jQuery(this).attr("href"));
            //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalAttachment3Dir').dialog('open');
        });

        jQuery("#dialogModalAttachment4Dir").dialog({
            autoOpen: false,
            height: 500,
            width: 700,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery(".overlayAttachment4Dir").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapAttachment4Dir').load(jQuery(this).attr("href"));
            //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalAttachment4Dir').dialog('open');
        });


        jQuery("#dialogModalAttachment5Dir").dialog({
            autoOpen: false,
            height: 500,
            width: 700,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery(".overlayAttachment5Dir").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapAttachment5Dir').load(jQuery(this).attr("href"));
            //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalAttachment5Dir').dialog('open');
        });

        jQuery('#alert-type0').on('click',function () {
            jQuery('#alert-type-iputs').load('<?php echo $this->Html->url('/events/getDateInputs/')?>',function () {
                jQuery("#last_revision_date").datetimepicker({

                    format: 'DD/MM/YYYY',
                    icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    }


                });
            });
        });

        jQuery('#alert-type1').on('click',function () {
            jQuery('#alert-type-iputs').load('<?php echo $this->Html->url('/events/getKmInputs/')?>');
        });

        var i = $('#nb_attachment').val() + 1;
        $('#add').click(function () {

            if (i < 6) {
                $('#dynamic_field').append('<tr id="row' + i + '"><td><?php  if($version_of_app == 'web') { ?><div class="input-button4" id="attachment' + i + '"><div class="input text"><label for="attachment' + i + '_dir"></label><input id="attachment' + i + '_dir" class="form-control" name="data[Event][attachment_dir][]" readonly="readonly" type="text"/ style="margin-top: 5px;"></div></div><div class="button-file"><a class="btn btn-default btn-trans waves-effect waves-primary w-md m-b-5 h-bn overlayAttachment' + i + 'Dir" onclick="open_popup(\'events\',\'dialogModalAttachment' + i + 'Dir\',\'attachment' + i + '\');"><i class="fa fa-folder-open m-r-5"></i><?php echo __('Select'); ?></a></div><div style="clear:both;"></div><?php } ?><div id="attachment'+i+'-file" ><div class="input-button"><div class="input file"><label for ="att'+i+'"></label><input id="att'+i+'" class="form-control filestyle" name="data[Event][attachment][]"  type="file"/></div></div><span class="popupactions"><button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg"  id="attachment'+i+'-btn" type="button" onclick="delete_file(\'attachment'+i+'\');"><i class="fa fa-repeat m-r-5"></i><?php echo __('Empty')?></button></span></div></td><td ><button style="margin-left: 40px;" name="remove" id="'+i+'" onclick="remove(\''+i+'\');"class="btn btn-danger btn_remove">X</button> </td></tr>');

                if (i==5) {$('#add').attr('disabled',true);}
            }
            i++;
        });
    });


    function addProductBill() {
        var nb_product = parseFloat(jQuery('#nb_product').val()) + 1;
        jQuery('#nb_product').val(nb_product);
        jQuery("#table_products").append("<tr id=product" + nb_product + "></tr>");
        jQuery("#total0").append("<div ></div>");
        var product = nb_product - 1;
        //products_id=jQuery("#Bill"+''+product+''+"Product").val();
        products_id.push(jQuery("#product_name" + '' + product + '' + "").val());
        jQuery("#product" + '' + nb_product + '').load("<?php echo $this->Html->url('/events/addProductBill/')?>" + nb_product + '|' + products_id);
        jQuery("#delete_product0").css("display", "block");
    }


    function calculPrice(id) {
        var num = id.substring(id.length - 1, id.length);


        var quantity = jQuery("#quantity" + '' + num + '').val();
        quantity= parseInt(quantity);
        var max= jQuery("#max"+''+num+'').val();

        max= parseInt(max);

        if (quantity > max) {

            jQuery("#quantity" + '' + num + '').val(max);
            msg = '<?php echo __('Not enough stock, maximum value is')?>';

            jQuery("#msg" + '' + num + '').html("<p style='color: #a94442;'>" + msg + ' ' + max + "</p>");
        }


        if (jQuery("#price" + '' + num + '' + "").val() > 0) {

            if (jQuery("#ristourne_val" + '' + num + '' + "").val() > 0) {
                var ristourne = ( jQuery("#ristourne_val" + '' + num + '' + "").val() / jQuery("#price" + '' + num + '' + "").val()) * 100;
                ristourne = ristourne.toFixed(2);
                jQuery("#ristourne" + '' + num + '' + "").val(ristourne);
            }
            if (jQuery("#ristourne" + '' + num + '' + "").val() > 0) {
                var ristourne_val = ( jQuery("#ristourne" + '' + num + '' + "").val() * jQuery("#price" + '' + num + '' + "").val()) / 100;

                jQuery("#ristourne_val" + '' + num + '' + "").val(ristourne_val);

            }
            if (jQuery("#quantity" + '' + num + '' + "").val() > 0) {

                if (jQuery("#ristourne_val" + '' + num + '' + "").val() > 0) {
                    total_ht = jQuery("#quantity" + '' + num + '' + "").val() * (parseFloat(jQuery("#price" + '' + num + '' + "").val()) - parseFloat(jQuery("#ristourne_val" + '' + num + '' + "").val()));
                    var total_ttc = jQuery("#quantity" + '' + num + '' + "").val() * (parseFloat(jQuery("#price" + '' + num + '' + "").val()) - parseFloat(jQuery("#ristourne_val" + '' + num + '' + "").val())) * (parseFloat(jQuery("#tva_prod" + '' + num + '' + "").val()) + 1);

                }
                else {
                    var total_ht = jQuery("#quantity" + '' + num + '' + "").val() * jQuery("#price" + '' + num + '' + "").val();
                    var total_ttc = jQuery("#quantity" + '' + num + '' + "").val() * jQuery("#price" + '' + num + '' + "").val() * (parseFloat(jQuery("#tva_prod" + '' + num + '' + "").val()) + 1);


                }
                var total_tva = total_ttc - total_ht;
                total_ht = total_ht.toFixed(2);
                total_ttc = total_ttc.toFixed(2);
                total_tva = total_tva.toFixed(2);

                jQuery("#ht" + '' + num + '' + "").val(total_ht);
                jQuery("#ttc" + '' + num + '' + "").val(total_ttc);
                jQuery("#tva" + '' + num + '' + "").val(total_tva);
                jQuery("#total" + '' + num + '' + "").html("<span style='float: right;'>" + total_ttc + "</span>");
            }
            var total_price_ht = 0.00;
            var total_price_ttc = 0.00;
            var total_price_tva = 0.00;
            var nb = jQuery("#nb_product").val();

            if (nb == 0) {
                total_price_ht = jQuery("#ht0").val();
                total_price_ttc = jQuery("#ttc0").val();
                total_price_tva = jQuery("#tva0").val();
            }
            else {

                for (var i = 0; i <= nb; i++) {

                    total_price_ht = total_price_ht + parseFloat(jQuery("#ht" + '' + i + '' + "").val());
                    total_price_ttc = total_price_ttc + parseFloat(jQuery("#ttc" + '' + i + '' + "").val());
                    total_price_tva = total_price_tva + parseFloat(jQuery("#tva" + '' + i + '' + "").val());

                }
                total_price_ht = total_price_ht.toFixed(2);
                total_price_ttc = total_price_ttc.toFixed(2);
                total_price_tva = total_price_tva.toFixed(2);
            }

            jQuery("#price_ht").val(total_price_ht);
            jQuery("#price_ttc").val(total_price_ttc);
            jQuery("#price_tva").val(total_price_tva);
            jQuery("#total_ht").html("<span style='float: right;'>" + total_price_ht + "</span>");
            jQuery("#total_ttc").html("<span style='float: right;'>" + total_price_ttc + "</span>");
            jQuery("#total_tva").html("<span style='float: right;'>" + total_price_tva + "</span>");

        }

    }


    function quantityMax(id) {
        var num = id.substring(id.length - 1, id.length);
        var product_id = jQuery("#product_name" + '' + num + '' + "").val();
        jQuery("#quantity_max" + '' + num + '').load("<?php echo $this->Html->url('/events/quantityProduct/')?>" + num + '|' + product_id);
        jQuery("#quantity" + '' + num + '').val('');
        jQuery("#price" + '' + num + '').val('');
        jQuery("#ristoune" + '' + num + '').val('');
        jQuery("#ristoune_val" + '' + num + '').val('');
        jQuery("#quantity" + '' + num + '').val('');
        jQuery("#total" + '' + num + '').html("<span style='float: right;'>0.00</span>");
    }

    function DeleteProduct(id) {

        var num = id.substring(id.length - 1, id.length);

        jQuery("#product" + '' + num + '' + "").css("display", "none");

        jQuery("#quantity" + '' + num + '' + "").val(0);
        jQuery("#price" + '' + num + '' + "").val(0);

        jQuery("#ht" + '' + num + '' + "").val(0);
        jQuery("#ttc" + '' + num + '' + "").val(0);
        jQuery("#tva" + '' + num + '' + "").val(0);
        // jQuery("#total"+''+num+''+"").html("<span style='float: right;'>"0.00"</span>");

        var total_price_ht = 0.00;
        var total_price_ttc = 0.00;
        var total_price_tva = 0.00;
        var nb = jQuery("#nb_product").val();
        if (nb == 0) {
            total_price_ht = jQuery("#ht0").val();
            total_price_ttc = jQuery("#ttc0").val();
            total_price_tva = jQuery("#tva0").val();
        }
        else {

            for (var i = 0; i <= nb; i++) {

                total_price_ht = total_price_ht + parseFloat(jQuery("#ht" + '' + i + '' + "").val());
                total_price_ttc = total_price_ttc + parseFloat(jQuery("#ttc" + '' + i + '' + "").val());
                total_price_tva = total_price_tva + parseFloat(jQuery("#tva" + '' + i + '' + "").val());
            }
            total_price_ht = total_price_ht.toFixed(2);
            total_price_ttc = total_price_ttc.toFixed(2);
            total_price_tva = total_price_tva.toFixed(2);
        }
        jQuery("#price_ht").val(total_price_ht);
        jQuery("#price_ttc").val(total_price_ttc);
        jQuery("#price_tva").val(total_price_tva);
        jQuery("#total_ht").html("<span style='float: right;'>" + total_price_ht + "</span>");
        jQuery("#total_ttc").html("<span style='float: right;'>" + total_price_ttc + "</span>");
        jQuery("#total_tva").html("<span style='float: right;'>" + total_price_tva + "</span>");

    }

    function delete_file(id) {


        $("#" + '' + id + '' + "-file").before(
            function () {
                if (!$(this).prev().hasClass('input-ghost')) {
                    var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                    element.attr("name", $(this).attr("name"));
                    element.change(function () {
                        element.next(element).find('input').val((element.val()).split('\\').pop());
                    });

                    $(this).find("#" + '' + id + '' + "-btn").click(function () {
                        element.val(null);
                        $(this).parents("#" + '' + id + '' + "-file").find('input').val('');
                    });
                    $(this).find('input').css("cursor", "pointer");
                    /*$(this).find('input').mousedown(function() {
                     $(this).parents("#"+''+id+''+"-file").prev().click();
                     return false;
                     });*/
                    return element;
                }
            }
        );
    }

    function calculate_cost() {

        var global_cost = 0;
        var tabVals = new Array();
        $('.cost_interfering').each(function () {
            if (parseFloat($(this).val()) > 0) global_cost = parseFloat(global_cost) + parseFloat($(this).val());


        });


        jQuery("#cost").val(global_cost);

    }

    function submitForm() {
        $('#EventEditForm').submit(function (e) {
            //if($('#attach1').val() || $('#attach2').val()|| $('#attach3').val()|| $('#attach4').val()|| $('#attach5').val()) {
            e.preventDefault();

            $(this).ajaxSubmit({
                beforeSubmit: function () {
                    $("#progress-bar").width('0%');
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    $("#progress-bar").width(percentComplete + '%');
                    $("#progress-bar").html('<div id="progress-status">' + percentComplete + ' %</div>');

                }
                ,
                success: function () {
                    window.location = '<?php echo $this->Html->url('/events')?>';
                },
                resetForm: true
            });
            return false;
            //}


        });
    };

    function getKmCar(){
        var link= '<?php echo $this->Html->url('/events/getKmCar/')?>' ;
        var carId = jQuery('#cars').val();

        jQuery.ajax({
            type: "POST",
            url: link,
            data: { carId: carId},
            dataType: "json",
            success: function (json) {

                if (json.response === true) {
                    var km = json.km;
                    jQuery('#EventKm').val(km);

                }
            }
        });
    }

    function addPayment() {

        var nb_payment = parseFloat(jQuery('#nb_payment').val()) + 1;
        var nb = nb_payment + 1;

        jQuery('#nb_payment').val(nb_payment);

        jQuery("#payment").append("<div class='panel panel-default'><div class='panel-heading'><h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordion' href='#payment" + nb_payment + "'><?php echo __('Payment ')?> " + nb + " </a></h4></div>");
        jQuery("#payment").append("<div id='payment" + nb_payment + "' class='panel-collapse collapse'></div>");


        jQuery("#payment" + '' + nb_payment + '').load('<?php echo $this->Html->url('/events/addPayment/')?>' + nb_payment, function () {
                jQuery("#receipt_date" + '' + nb_payment + '').inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            }
        );

    }


    function remove(id) {


        $('#row' + id + '').remove();
        i--;
        $('#add').css('display', 'block');

    };


    function open_popup(dir, id_dialog, id_input) {

        var i = id_input.substring(id_input.length - 1, id_input.length);

        jQuery('#contentWrapAttachment' + i + 'Dir').load('<?php echo $this->Html->url('/events/openDir/')?>' + dir + '/' + id_dialog + '/' + id_input);
        //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
        jQuery('#dialogModalAttachment' + i + 'Dir').dialog('open');
    }
    function addOtherInterfering(id_int) {
        i = jQuery("#nb_interfering" + id_int).val();
        i++;
        if (i < 4) {
            $('#dynamic_field' + id_int).append('<tr id="row' + i + '' + id_int + '"><td ></td></tr>');
            if (i == 3) $('#add' + id_int).css('display', 'none');
        }
        jQuery("#nb_interfering" + id_int).val(i);
        category_id = jQuery("#EventCategoryInterfering" + id_int + "EventTypeCategory").val();
        jQuery("#row" + '' + i + '' + '' + id_int + '').load('<?php echo $this->Html->url('/events/getInterferingsByCategory/')?>' + jQuery('#type').val() + '/' + i + '/' + id_int);
    }


    function checkIfMechanicIsAvailable(){

        var link= '<?php echo $this->Html->url('/events/checkIfMechanicIsAvailable/')?>' ;
        var mechanicId = jQuery('#mechanic').val();
        var workshopEntryDate = jQuery('#workshop_entry_date').val();
        var workshopExitDate = jQuery('#workshop_exit_date').val();
        var eventId = jQuery('#EventId').val();

        jQuery.ajax({
            type: "GET",
            url: link,
            data: {
                mechanicId: mechanicId,
                workshopEntryDate : workshopEntryDate,
                workshopExitDate : workshopExitDate,
                eventId : eventId,
            },
            dataType: "json",
            success: function (json) {
                if (json.response === false) {
                    alert('<?= __('The mechanic is not available during this period.') ?>');

                }
            }
        });
    }


</script>

<?php $this->end(); ?>
