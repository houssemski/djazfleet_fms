    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
           cellspacing="0" width="100%">
        
        <tbody>
        <?php foreach ($departments as $department): ?>
            <tr id="row<?= $department['Department']['id'] ?>">
                <td>

                    <input id="idCheck"type="checkbox" class = 'id' value=<?php echo $department['Department']['id'] ?> >
                </td>

                <td><?php echo h($department['Department']['name']); ?>&nbsp;</td>
                <td><?php echo h($this->Time->format($department['Department']['created'], '%d-%m-%Y %H:%M')); ?>&nbsp;</td>
                <td><?php echo h($this->Time->format($department['Department']['modified'], '%d-%m-%Y %H:%M')); ?>&nbsp;</td>
                <td class="actions">
                    <?= $this->Html->link(
                        '<i class="fa fa-eye m-r-5"></i>',
                        array('action' => 'View', $department['Department']['id']),
                        array('escape' => false)
                    ); ?>
                    <?= $this->Html->link(
                        '<i class="fa fa-edit m-r-5"></i>',
                        array('action' => 'Edit', $department['Department']['id']),
                        array('escape' => false)
                    ); ?>
                    <?php echo $this->Form->postLink(
                        '<i class="fa fa-trash-o m-r-5"></i>',
                        array('action' => 'Delete', $department['Department']['id']),
                        array('escape' => false),
                        __('Are you sure you want to delete %s?', $department['Department']['name'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div id ='pageCount' class="hidden">
    <?php
if($this->params['paging']['Department']['pageCount'] > 1){
    ?>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?>	</p>
    <div class="box-footer clearfix">
        <ul class="pagination pagination-sm no-margin pull-left">
            <?php
            echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
            echo $this->Paginator->numbers(array(
                'tag' => 'li',
                'first' => false,
                'last' => false,
                'separator' => '',
                'currentTag' => 'a'));
            echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
            ?>
        </ul>
    </div>
<?php } ?>

        </div>