<?php
/**
 * @var array $busRouteStop
 */
?>
<div class="box-body">
    <?php
    ?><h4 class="page-title"> <?=$busRouteStop['BusRouteStop']['name']; ?></h4>
    <dl class="card-box">
        <dt><?php echo __('Latitude'); ?></dt>
        <dd>
            <?php echo h($busRouteStop['BusRouteStop']['lat']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Longitude'); ?></dt>
        <dd>
            <?php echo h($busRouteStop['BusRouteStop']['lng']); ?>
            &nbsp;
        </dd>
    </dl>
</div>