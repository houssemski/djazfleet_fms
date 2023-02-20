<?php 

if($remorques != null){ ?>
    <div class="input select ">
    <?php if($mode==0){?>
    <label for="remorques"><?= __("Remorque") ?></label>
    <?php } else {?>
    <label for="remorques"><?= __("") ?></label>
    <?php } ?>
       
        <select name="data[SheetRide][remorque_id]" class="form-filter select-search-remorque" id="remorques<?php echo $i;?>"  >
            <option value=""><?= __('Select remorque') ?></option>
            <?php
            foreach ($remorques as $qsKey => $qsData) {
                if($qsKey == $selected_id){
                    echo '<option value="'.$qsKey.'" selected>'.$qsData.'</option>'."\n";
                }else{
                    echo '<option value="'.$qsKey.'">'.$qsData.'</option>'."\n";
                }

            }
            ?>
        </select>
    </div>
<?php }else{ ?>
    <div class="input select ">
        <?php if($mode==0){?>
    <label for="remorques"><?= __("Remorque") ?></label>
    <?php } else {?>
    <label for="remorques"><?= __("") ?></label>
    <?php } ?>
        <select name="data[SheetRide][remorque_id]" class="form-filter select-search-remorque" id="remorques<?php echo $i;?>" ">
            <option value=""><?= __('Select remorque') ?></option>
        </select>
    </div>
<?php }
?>