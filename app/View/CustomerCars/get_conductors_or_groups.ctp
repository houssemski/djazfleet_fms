<?php
if($id == 1){ ?>

<div class="form-group">
    <div class="input select required">
        <label for="customers"><?= __("Conductor") ?></label>
<select name="data[CustomerCar][customer_id]" class="form-control select2" id="customers" required="true" onchange ="verifyDriverLicenseCategory();">
    <option value=""><?= __('Select ') . " " . __("Conductor") ?></option>
    <?php
    foreach ($customers as $qsKey => $qsData) {
        if($qsKey == $customerId){
            echo '<option value="'.$qsKey.'" selected>'.$qsData.'</option>'."\n";
        }else{
            echo '<option value="'.$qsKey.'">'.$qsData.'</option>'."\n";
        }

    }
    ?>
</select>
</div>
</div>

<?php }else { ?>

    <div class="form-group">
    <div class="input select required">
    <label for="groups"><?= __("Group") ?></label>
    <select name="data[CustomerCar][customer_group_id]" class="form-control select2" id="groups" required="true">
    <option value=""><?= __('Select ') . " " . __("group") ?></option>
    <?php
    foreach ($customerGroups as $qsKey => $qsData) {
        if($qsKey == $groupId){
            echo '<option value="'.$qsKey.'" selected>'.$qsData.'</option>'."\n";
        }else{
            echo '<option value="'.$qsKey.'">'.$qsData.'</option>'."\n";
        }

    }
    ?>
<?php }