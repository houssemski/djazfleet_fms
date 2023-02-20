<?php

if($productWithLot == 1){ ?>
<div class="form-group small-input-button">
<div class="input select required">
    <label for="lot<?= $i ?>"><?= __('Lot') ?></label>
    <select name="data[BillProduct][<?= $i ?>][lot_id]" class="form-control select3" id="lot<?= $i ?>"  required="required">
        <option value=""></option>

<?php

foreach ($lots as $lot) {

echo '<option value="'.$lot['Lot']['id'].'">'.$lot['Lot']['label'].'</option>'."\n";

}
?>
    </select>
</div>
    </div>
    <!-- overlayed element -->
    <div class="right-popupactions ">

        <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('', true),
            'javascript:;',
            array("class" => "btn btn-danger btn-trans waves-effect waves-danger overlayLot", 'id' => 'a-lot'.$i, 'onclick' => 'javascript:addLot(this.id);', 'escape' => false, "title" => __("Add lot"))); ?>

    </div>
    <div id="dialogModalLot<?= $i ?>">
        <!-- the external content is loaded inside this tag -->
        <div id="contentWrapLot<?= $i ?>"></div>
    </div>
    <div style="clear:both"></div>
<?php }

?>

