<div class="box-body">
    <?php
    ?><h4 class="page-title"> <?=$structure['Structures']['name']; ?></h4>
    <dl class="card-box">
        <dt><?php echo __('Code'); ?></dt>
        <dd>
            <?php echo h($structure['Structures']['code']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Name'); ?></dt>
        <dd>
            <?php echo h($structure['Structures']['name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Created'); ?></dt>
        <dd>
            <?php echo h($this->Time->format($structure['Structures']['created'], '%d-%m-%Y %H:%M')); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Modified'); ?></dt>
        <dd>
            <?php echo h($this->Time->format($structure['Structures']['modified'], '%d-%m-%Y %H:%M')); ?>
            &nbsp;
        </dd>
    </dl>
</div>