
<?php

if ($param_coupon==1)  {?>
    <div  class="col-sm-3">
        <div class="input select "  >
            <label for="serial_number"><?=__('Serial numbers')?></label>
            <select name="data[Consumption][serial_numbers][]" class="form-control selectCoupon"  id="serial_number"  multiple="multiple">
                <option value=""><?=__('Select coupons')?></option>

                <?php
                foreach ($selectbox as $qsKey => $qsData) {
                    echo '<option value="'.$qsKey.'">'.$qsData.'</option>'."\n";
                }
                ?>

            </select>
        </div>
    </div>
<?php } else {
    ?>
    <div class="input text required" id="req_code" >
        <label for="code"><?=__('Code ')?></label>
        <input name="data[Consumption][<?php echo $i ?>][barCode]" class="form-filter"  id="code"  onchange="addBarCode(this.id)" required="required" type='text'>


        </input>
    </div>

<?php
}
