<?php if($customers != null){ ?>
    <div class="input select required">

        <label for="customers"><?= __("Customer") ?></label>


        <select name="data[Consumption][customer_id]" class="form-control select-search" id="customers"   >
            <option value=""><?= __('Select ') . " " . __("Customer") ?></option>
            <?php
            foreach ($customers as $qsKey => $qsData) {
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

        <label for="customers"><?= __("Customer") ?></label>

        <select name="data[Consumption][customer_id]" class="form-control select-search-customer" id="customers"   >
            <option value=""><?= __('Select ') . " " . __("Customer") ?></option>
        </select>
    </div>
<?php }
?>