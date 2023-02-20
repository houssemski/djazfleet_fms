<div class="box-body">
    <?php
    ?><h4 class="page-title"> <?=__('Consumption') ?></h4>
    <dl class="card-box">

        <dt width="20%"><?php echo __('Consumption date'); ?></dt>
        <dd>
            <?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M')); ?>
            &nbsp;
        </dd>
        <?php
        switch ($consumption['Consumption']['type_consumption_used']){
            case ConsumptionTypesEnum::card:
                ?>
                <dt><?php echo __('Card'); ?></dt>
                <dd>
                    <?php echo h($consumption['FuelCard']['reference']); ?>
                    &nbsp;
                </dd>
                <dt><?php echo __('Amount'); ?></dt>
                <dd>
                    <?php echo number_format($consumption['Consumption']['species_card'], 2, ",", ' '); ?>
                    &nbsp;
                </dd>
        <?php
                break;
            case ConsumptionTypesEnum::coupon:
                ?>
                <dt><?php echo __('Coupon'); ?></dt>
                <dd>
                    <?php echo $consumption['Consumption']['nb_coupon']; ?>
                    &nbsp;
                </dd>
        <?php
                break;
            case ConsumptionTypesEnum::tank:
                ?>
                <dt><?php echo __('Tank'); ?></dt>
                <dd>
                    <?php $consumption['Tank']['name']; ?>
                    &nbsp;
                </dd>
                <dt><?php echo __('Litres'); ?></dt>
                <dd>
                    <?php echo $consumption['Consumption']['nb_liter']; ?>
                    &nbsp;
                </dd>
        <?php
                break;
            case ConsumptionTypesEnum::species:
                ?>
                <dt><?php echo __('Species'); ?></dt>
                <dd>
                    <?php echo  $consumption['Consumption']['cost']; ?>
                    &nbsp;
                </dd>
        <?php
        }
        ?>
    </dl>
</div>