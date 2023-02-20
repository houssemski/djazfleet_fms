<td>

<div class='form-group interferingGroup' id='interfering<?php echo $id_int?><?php echo $i?>'>

<div class="input select "> 
   <?php  $num= $i-1; ?>
     <label for="type"><?= __('Interfering').' '. $i ?></label> 
    <select   name="data[EventCategoryInterfering][<?php echo $id_int?>][interfering_id<?php echo $i?>]" class="form-control" id="EventCategoryInterferingId" > <?php
         ?> <option value=""><?=__('Select interfering') ?></option> <?php 



        
     
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
                    array("controller" => "events", "action" => "addInterfering", $id_int, $i, $type_id),
                    array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayInterfering", 'id'=>$i, 'escape' => false, "title" => __("Add Interfering"))); ?>

    </div>
    <div style="clear:both"></div>
</td>