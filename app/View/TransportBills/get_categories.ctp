<div class="input select ">
    <label for="category"><?= __('Categorie') ?></label>
    <select name="data[TransportBill][transport_bill_category_id]" class="form-control select2" id="category" >
        <option value=""></option>

<?php 
foreach ($selectbox as $category) {
if($selectedid == $category['TransportBillCategory']['id']){
echo '<option value="'.$category['TransportBillCategory']['id'].'" selected>'.$category['TransportBillCategory']['name'].'</option>'."\n";
}else{
echo '<option value="'.$category['TransportBillCategory']['id'].'">'.$category['TransportBillCategory']['name'].'</option>'."\n";
}
}
?>
    </select>
</div>