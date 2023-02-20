<?php

if($category_id=='3'){
    if($selectbox != null){ ?>
        <div class="input select required">
            <label for="CarCarTypeId"><?= __('Car type') ?></label>
            <select name="data[Car][car_type_id]" class="form-control select2 select-type" id="CarCarTypeId" required="required" type ='hidden'>
                <option value=""><?= __('Select type') ?></option>

                <?php
                foreach ($selectbox as $qsKey => $qsData) {
                    if($qsKey == $selectedid){
                        echo '<option value="'.$qsKey.'" selected>'.$qsData.'</option>'."\n";
                    }else{
                        echo '<option value="'.$qsKey.'">'.$qsData.'</option>'."\n";
                    }

                }
                ?>
            </select>
        </div>
    <?php }else{ ?>
        <div class="input select required">
            <label for="CarCarTypeId"><?= __('Car type') ?></label>
            <select name="data[Car][car_type_id]" class="form-control select2 select-type" id="CarCarTypeId" required="required"  type ='hidden'>
                <option value=""></option>
            </select>
        </div>
    <?php }
    ?>
<?php } else {
if($selectbox != null){ ?>
    <div class="input select required">
        <label for="CarCarTypeId"><?= __('Car type') ?></label>
        <select name="data[Car][car_type_id]" class="form-control select2 select-type" id="CarCarTypeId" required="required">
            <option value=""><?= __('Select type') ?></option>

            <?php
            foreach ($selectbox as $qsKey => $qsData) {
                if($qsKey == $selectedid){
                    echo '<option value="'.$qsKey.'" selected>'.$qsData.'</option>'."\n";
                }else{
                    echo '<option value="'.$qsKey.'">'.$qsData.'</option>'."\n";
                }

            }
            ?>
        </select>
    </div>
<?php }else{ ?>
    <div class="input select required">
        <label for="CarCarTypeId"><?= __('Car type') ?></label>
        <select name="data[Car][car_type_id]" class="form-control select2 select-type" id="CarCarTypeId" required="required">
            <option value=""></option>
        </select>
    </div>
<?php }
}
?>




