<div class="form-group">
        <span id="model">
            <div class="input">
                <label for="date"><?= __('Date') ?></label>
                <input name="data[EventType][date]" placeholder="<?= __('date') ?>" value=""
                       class="form-control" id="date1">
            </div>
</span>
</div>


<div class="form-group">
        <span id="model">
            <div class="input">
                <label for="date"><?= __('Next Date') ?></label>
                <input name="data[EventType][next_date]" placeholder="<?= __('Next date') ?>"
                       class="form-control">
            </div>
</span>
</div>

<div class="form-group">
        <span id="model">
            <div class="input">
                <label for="date"><?= __('Date3') ?></label>
                <input name="data[EventType][date3]" placeholder="<?= __('date3') ?>"
                       class="form-control">
            </div>
</span>
</div>
<?php $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<script type="text/javascript">

    $(document).ready(function() {
        jQuery('#date1').change(function () {
            var date= jQuery(this).val();

        });
    });


    </script>
<?php $this->end(); ?>





