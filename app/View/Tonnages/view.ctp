<div class="box-body">
    <?php
    ?><h4 class="page-title"> <?=$tonnage['Tonnage']['code'].' '.$tonnage['Tonnage']['name']; ?></h4>
    <dl class="card-box">
        <dt><?php echo __('Code'); ?></dt>
        <dd>
            <?php echo h($tonnage['Tonnage']['code']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Name'); ?></dt>
        <dd>
            <?php echo h($tonnage['Tonnage']['name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Created'); ?></dt>
        <dd>
            <?php echo h($this->Time->format($tonnage['Tonnage']['created'], '%d-%m-%Y %H:%M')); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Modified'); ?></dt>
        <dd>
            <?php echo h($this->Time->format($tonnage['Tonnage']['modified'], '%d-%m-%Y %H:%M')); ?>
            &nbsp;
        </dd>
    </dl>
</div>