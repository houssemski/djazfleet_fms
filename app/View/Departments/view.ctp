<div class="box-body">
    <?php
    ?><h4 class="page-title"> <?=$department['Department']['name']; ?></h4>
    <dl class="card-box">
        <dt><?php echo __('Name'); ?></dt>
        <dd>
            <?php echo h($department['Department']['name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Created'); ?></dt>
        <dd>
            <?php echo h($this->Time->format($department['Department']['created'], '%d-%m-%Y %H:%M')); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Modified'); ?></dt>
        <dd>
            <?php echo h($this->Time->format($department['Department']['modified'], '%d-%m-%Y %H:%M')); ?>
            &nbsp;
        </dd>
    </dl>
</div>