<?php if ($param_coupon==1)  {?>
    <div class="input select">
        <label for="returned_serial_number"><?=__('Returned serial numbers')?></label>
        <select name="data[SheetRide][returned_serial_numbers][]" class="form-filter selectReturnedCoupon" id="returned_serial_number" multiple="multiple">
            <option value=""><?= __('Select returned coupons') ?></option>

            <?php
            foreach ($selectbox as $qsKey => $qsData) {
                echo '<option value="'.$qsKey.'">'.$qsData.'</option>'."\n";
            }
            ?>
        </select>
    </div>
<?php } else { ?>

    <div class="input text required" id="req_code_returned" >
        <label for="code_returned"><?=__('Code returned')?></label>
        <input name="data[SheetRide][barCodeReturned]" class="form-control"  id="code_returned"  onchange="addBarCodeReturned(this.id)" required="required" type='text'>


        </input>
    </div>
<?php }
