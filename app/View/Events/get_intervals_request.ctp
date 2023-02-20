<?php

?>
<div class="form-group">
        <span id="model">
            <div class="input text">
                 <label><?= __('date') ?></label>


                <div class="input-group date">
                    <label for="date"></label>

                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <label for="date"></label>
                    <?php if($editKmDate==1) {?>
                        <input name="data[Event][date]" placeholder="dd/mm/yyyy"
                               value ="<?php echo date("d/m/Y"); ?>"
                               class="form-control datemask"  type="text" id='date'>
                    <?php }else { ?>
                        <input name="data[Event][date]" placeholder="dd/mm/yyyy"
                               readonly ="readonly"  value ="<?php echo date("d/m/Y"); ?>"
                               class="form-control datemask"  type="text" id='date'>
                    <?php } ?>
                </div>
            </div>
        </span>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        jQuery("#date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

    });


</script>

<div class="form-group">
        <span id="model">
            <div class="input number">
                <label for="EventKm"><?= __('Km') ?></label>
                <?php if($editKmDate==1) {?>
                    <input name="data[Event][km]" placeholder="<?= __('Enter km') ?>"
                           value="<?php echo intval($km); ?>"
                           class="form-control" type="number" id="EventKm">
                <?php }else { ?>
                    <input name="data[Event][km]" placeholder="<?= __('Enter km') ?>"
                           readonly="readonly" value="<?php echo intval($km); ?>"
                           class="form-control" type="number" id="EventKm">
                <?php } ?>
            </div>
        </span>
</div>
<div class="form-group">
        <span id="model">
            <div class="input number">
                <label for="EventKm"><?= __('Next km') ?></label>
                <input name="data[Event][next_km]" placeholder="<?= __('Enter next km') ?>"
                       class="form-control" type="number" id="EventNextKm">
            </div>
        </span>
</div>


<?php






?>
<?php $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<script type="text/javascript">     $(document).ready(function() {      });



</script>
<?php $this->end(); ?>
