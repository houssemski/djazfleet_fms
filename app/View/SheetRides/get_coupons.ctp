
<?php

if ($param_coupon==1)  {?>
    <div  class="select-inline">
        <div class="input select "  >
            <label for="serial_number<?php echo $i ?>"><?=__('Serial numbers')?></label>
            <select name="data[Consumption][<?php echo $i?>][serial_numbers][]" class="form-filter selectCoupon"  id="serial_number<?php echo $i ?>"  multiple="multiple">
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

    <div class="input text required" id="req_code<?php echo $i ?>" >
        <label for="code<?php echo $i ?>"><?=__('Code ')?></label>
        <input name="data[Consumption][<?php echo $i ?>][barCode]" class="form-filter"  id="code<?php echo $i ?>"  onchange="addBarCode(this.id)" required="required" type='text'>


        </input>
    </div>

<?php
}
