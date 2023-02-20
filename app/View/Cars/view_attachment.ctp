<?php if (isset($car['Car']['yellow_card']) && !empty($car['Car']['yellow_card'])) { ?>
<br/>
<dt><?php echo __('Yellow Card'); ?></dt>
<dd>
    <?= $this->Html->Link($car['Car']['yellow_card'],
        '/attachments/yellowcards/' . $car['Car']['yellow_card'],
        array('class' => 'attachments', 'target' => '_blank')
    ); ?>
    &nbsp;
</dd>
<?php } ?>