<?php
/**
 * Created by PhpStorm.
 * User: Kahina
 * Date: 02-01-2020
 * Time: 11:54
 */

echo "<div class='form-group' >" . $this->Form->input('Event.mechanician_id', array(
        'label' => __("Mécanicien"),
        'class' => 'form-control select2',
        'empty' => '',
        'onchange'=>'javascript: checkIfMechanicIsAvailable()',
        'id' => 'mechanic',
        'options'=>$customers
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
        'before' => '<label>' . __('Workshop entry date') . '</label><div class="input-group datetime-workshop" ><label for="EventWorkshopEntryDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar " ></i>
                                            </div>',
        'after' => '</div>',
        'id' => 'workshop_entry_date',
        'onchange'=>'javascript : checkIfMechanicIsAvailable()',
    )) . "</div>";

echo "<div class='form-group' >" . $this->Form->input('Event.workshop_exit_date', array(
        'label' => false,
        'placeholder' => 'dd/mm/yyyy hh:mm',
        'type' => 'text',
        'class' => 'form-control datemask',
        'id' => 'workshop_exit_date',
        'before' => '<label>' . __('Workshop exit date') . '</label><div class="input-group datetime-workshop"><label for="EventWorkshopExitDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
        'after' => '</div>',
        'onchange'=>'javascript : checkIfMechanicIsAvailable()',
        'id' => 'workshop_exit_date',
    )) . "</div>";

