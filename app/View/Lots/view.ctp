<div class="box-body">
    <?php
    ?><h4 class="page-title"> <?=$lot['Lot']['name']; ?></h4>
    <dl class="card-box">
        <dt><?php echo __('Code'); ?></dt>
        <dd>
            <?php echo h($lot['Lot']['code']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Name'); ?></dt>
        <dd>
            <?php echo h($lot['Lot']['name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Price'); ?></dt>
        <dd>
            <?php echo h($lot['Lot']['last_purchase_price']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Quantity'); ?></dt>
        <dd>
            <?php echo h($lot['Lot']['quantity']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Quantity min'); ?></dt>
        <dd>
            <?php echo h($lot['Lot']['quantity_min']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Quantity max'); ?></dt>
        <dd>
            <?php echo h($lot['Lot']['quantity_max']); ?>
            &nbsp;
        </dd>
        
        <dt><?php echo __('Description'); ?></dt>
        <dd>
            <?php echo h($lot['Lot']['description']); ?>
            &nbsp;
        </dd>
       

    </dl>
</div>