

<?php
echo "<div class='form-group'>" . $this->Form->input('Event.last_event_date', array(
        'label' => '',
        'placeholder' => 'dd/mm/yyyy',
        'type' => 'text',
        'class' => 'form-control datemask',
        'before' => '<label>' . __('Date de dérniére révision') . '</label><div id="last_revision_date" class="input-group"><label for="birthday"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
        'after' => '</div>',
        'id' => '',
    )) . "</div>";
?>


<div class="form-group">
        <span id="date_interval_next_revision">
            <div class="input">
                <label for="date"><?= __('Intervale') ?></label>
                <input name="data[Event][date_interval]" placeholder="<?= __('Journées') ?>"
                       class="form-control">
            </div>
</span>
</div>

<div class="form-group">
        <span id="alert-before-date">
            <div class="input">
                <label for="date"><?= __('Alerte avant (journées)') ?></label>
                <input name="data[Event][alert_before_days]" placeholder="<?= __('Journées') ?>"
                       class="form-control">
            </div>
</span>
</div>

