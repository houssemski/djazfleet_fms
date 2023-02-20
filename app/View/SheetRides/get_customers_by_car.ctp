<?php if($customers != null){ ?>
    <div class="input select required">

    <label for="customers"><?= __("Customer") ?></label>

        
        <select name="data[SheetRide][customer_id]" class="form-filter select-search-customer" id="customers" required="required"  onchange="verifyDriverLicenseExpirationDate(), verifyMissionCustomer();">
            <option value=""><?= __('Select ') . " " . __("Customer") ?></option>
            <?php
            foreach ($customers as $qsKey => $qsData) {
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
    <div class="input select required">

    <label for="customers"><?= __("Customer") ?></label>

        <select name="data[SheetRide][customer_id]" class="form-filter select-search-customer" id="customers"  required="required" >
            <option value=""><?= __('Select ') . " " . __("Customer") ?></option>
        </select>
    </div>
<?php }
?>