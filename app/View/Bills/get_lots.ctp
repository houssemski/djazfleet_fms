
<div class="form-group small-input-button">
<div class="input select required">
    <label for="lot<?php echo $i; ?>"></label>
    <select name="data[BillProduct][<?php echo $i; ?>][lot_id]" class="form-control select-search"
            id="lot<?php echo $i; ?>"  required="required">

<?php
foreach ($selectBox as $qsKey => $qsData) {
    if($qsKey == $selectedId){
        echo '<option value="'.$qsKey.'" selected>'.$qsData.'</option>'."\n";
    }else{
        echo '<option value="'.$qsKey.'">'.$qsData.'</option>'."\n";
    }
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


