<div class="input select ">
    <label for="CustomerAffiliateId"><?= __('Affiliate') ?></label>
    <select name="data[Customer][affiliate_id]" class="form-control select2" id="CustomerAffiliateId" >
        <option value=""><?= __('Select affiliate') ?></option>

<?php 
foreach ($selectbox as $Affiliate) {
if($selectedid == $Affiliate['Affiliate']['id']){
echo '<option value="'.$Affiliate['Affiliate']['id'].'" selected>'.$Affiliate['Affiliate']['name'].'</option>'."\n";
}else{
echo '<option value="'.$Affiliate['Affiliate']['id'].'">'.$Affiliate['Affiliate']['name'].'</option>'."\n";
}
}
?>
    </select>
</div>