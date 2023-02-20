
<?php  
if($request==0){
if (!empty($EventTypeCategories)){
$i=0; ?>

 <div id="dialogModalInterfering">
                <!-- the external content is loaded inside this tag -->
      <div id="contentWrapInterfering"></div>
 </div>
<?php foreach ($EventTypeCategories as $EventTypeCategory) {
echo  $this->Form->input('EventCategoryInterfering.' . $i . '.event_type_category', array(
                    'type' => 'hidden',
                    'value'=>$EventTypeCategory['EventTypeCategory']['id'],
                    'class' => 'form-control',
                )) ;
 ?>
<table   id='dynamic_field<?php echo $i?>' style="width: 85%; !important">
<tr>
<td>
 <div class='form-group interferingGroup' id='interfering<?php echo $i?>0' >

<div class="input select "> 
    <?php if  ($EventTypeCategory['EventTypeCategory']['name']=='Autre') {
    if($typeEvent==2) { ?> <label for="type"><?= __('Agency'); ?> </label> <?php } else { ?> <label for="type"><?= __('Interfering'); ?> </label> <?php }
 
    } else { ?>
    <label for="type"><?= __('Interfering').' '.$EventTypeCategory['EventTypeCategory']['name'] ?></label> <?php } ?>
    
    <select   name="data[EventCategoryInterfering][<?php echo $i?>][interfering_id0]" class="form-control select2" id="EventCategoryInterferingId" > <?php
        if($typeEvent==2) { ?> <option value=""><?=__('Select agency') ?></option> <?php } else { ?> <option value=""><?=__('Select interfering') ?></option> <?php }
        foreach ($selectbox as $interfering) {
            echo '<option value="' . $interfering['Interfering']['id'] . '">' . $interfering['Interfering']['name'] . '</option>' . "\n";
        }
        ?>
    </select>
</div>
</div>
</td>
    <td>
        <div class="popupactions">

                    <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                        array("controller" => "events", "action" => "addInterfering",$i,0,$typeEvent),
                        array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayInterfering", 'id'=>$i, 'escape' => false, "title" => __("Add Interfering"))); ?>

        </div>
        <div style="clear:both"></div>

    </td>
<?php if($eventTypes['EventType']['many_interferings']==1) {?>
<td class="td_tab">
			<button style="margin-left: 0px;" type='button' name='add' id='add<?php echo $i?>' onclick="addOtherInterfering(<?php echo $i?>)" class='btn btn-success'><?=__('Add more')?></button>
</td>
<?php } ?>
</tr>
</table>






<?php 



echo "<div class='form-group'>" . $this->Form->input('EventCategoryInterfering.' . $i . '.cost', array(
                   // 'type' => 'hidden',
                    'id'=>'cost'.$i ,
                    'value'=>'0',
                    'placeholder' => __('Enter cost'),
                    'onchange' => 'javascript:calculate_cost();',
                    'class' => 'form-control cost_interfering'
                )) . "</div>";
echo "<div class='form-group'>" . $this->Form->input('EventCategoryInterfering.' . $i . '.nb_interfering', array(
                    'type' => 'hidden',
                    'id'=>'nb_interfering'.$i ,

                    
                    
                    'class' => 'form-control cost_interfering'
                )) . "</div>";
$i++;
}
}
} else {


 ?><div class='form-group interferingGroup' id='0'> 

<div class="input select "> 
    
    <label for="type"><?= __('Interfering') ?></label>
    
    <select   name="data[EventCategoryInterfering][0][interfering_id0]" class="form-control select2" id="EventCategoryInterferingId" > <?php
          ?> <option value=""><?=__('Select interfering') ?></option> <?php 



        
     
        foreach ($selectbox as $interfering) {
            echo '<option value="' . $interfering['Interfering']['id'] . '">' . $interfering['Interfering']['name'] . '</option>' . "\n";
        }
        ?>
    </select>
</div>
</div>

            <div class="popupactions">

                        <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                            array("controller" => "events", "action" => "addInterfering",0,$typeEvent),
                            array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayInterfering", 'id'=>0, 'escape' => false, "title" => __("Add Interfering"))); ?>

            </div>
            <div style="clear:both"></div>

<?php 



echo "<div class='form-group'>" . $this->Form->input('EventCategoryInterfering.0.cost', array(
                   // 'type' => 'hidden',
                    'id'=>'cost0' ,
                    'value'=>'0',
                    'placeholder' => __('Enter cost'),
                    'onchange' => 'javascript:calculate_cost();',
                    'class' => 'form-control cost_interfering'
                )) . "</div>";


} ?>