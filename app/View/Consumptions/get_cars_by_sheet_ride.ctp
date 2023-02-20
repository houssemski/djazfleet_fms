<?php if($cars != null){ ?>
    <div class="input select required">

        <label for="cars"><?= __("Car") ?></label>


        <select name="data[Consumption][car_id]" class="form-control select-search" id="cars"   >
            <option value=""><?= __('Select ') . " " . __("Car") ?></option>
            <?php
            foreach ($cars as $qsKey => $qsData) {
                if($qsKey == $selectedId){
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

        <label for="cars"><?= __("Car") ?></label>

        <select name="data[Consumption][car_id]" class="form-control select-search-car" id="cars"   >
            <option value=""><?= __('Select ') . " " . __("Car") ?></option>
        </select>
    </div>
<?php }
?>