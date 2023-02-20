<tbody >
<?php foreach ($carStates as $state): ?>
    <tr id="row<?= $state['CarState']['id'] ?>">
        <td>

            <input id="idCheck" type="checkbox" class='id'
                   value=<?php echo $state['CarState']['id'] ?>>
        </td
        <td><?php echo h($state['CarState']['name']); ?>&nbsp;</td>
        <td><?php echo h($this->Time->format($state['CarState']['created'], '%d-%m-%Y %H:%M')); ?>
            &nbsp;</td>
        <td><?php echo h($this->Time->format($state['CarState']['modified'], '%d-%m-%Y %H:%M')); ?>
            &nbsp;</td>
        <td class="actions">
            <div class="btn-group ">
                <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                    <i class="fa fa-list fa-inverse"></i>
                </a>
                <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                    <span class="caret"></span>
                </button>

                <ul class="dropdown-menu" style="min-width: 70px;">

                    <li>
                        <?= $this->Html->link(
                            '<i   class="fa fa-eye" title="' . __('View') . '"></i>',
                            array('action' => 'View', $state['CarState']['id']),
                            array('escape' => false, 'class' => 'btn btn-success')
                        ); ?>
                    </li>

                    <li>
                        <?= $this->Html->link(
                            '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                            array('action' => 'Edit', $state['CarState']['id']),
                            array('escape' => false, 'class' => 'btn btn-primary')
                        ); ?>
                    </li>


                    <li>
                        <?php
                        echo $this->Form->postLink(
                            '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                            array('action' => 'delete', $state['CarState']['id']),
                            array('escape' => false, 'class' => 'btn btn-danger'),
                            __('Are you sure you want to delete %s?', $state['CarState']['name'])); ?>
                    </li>


                </ul>
            </div>

        </td>
    </tr>
<?php endforeach; ?>
</tbody>