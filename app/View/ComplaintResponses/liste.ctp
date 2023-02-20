<?php foreach ($complaintResponses as $complaintResponse):

    ?>
    <tr id="row<?= $complaintResponse['ComplaintResponse']['id'] ?>">
        <td>

            <input id="idCheck" type="checkbox" class='id'
                   value=<?php echo $complaintResponse['ComplaintResponse']['id'] ?>>
        </td>
        <td><?php echo h($complaintResponse['ComplaintResponse']['reference']); ?>&nbsp;</td>
        <td><?php echo h($this->Time->format($complaintResponse['ComplaintResponse']['response_date'], '%d-%m-%Y')); ?></td>

        <td><?php echo $complaintResponse['Complaint']['reference'] ;?> </td>

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
                            array('action' => 'View', $complaintResponse['ComplaintResponse']['id']),
                            array('escape' => false, 'class' => 'btn btn-success')
                        ); ?>
                    </li>

                    <li>
                        <?= $this->Html->link(
                            '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                            array('action' => 'Edit', $complaintResponse['ComplaintResponse']['id']),
                            array('escape' => false, 'class' => 'btn btn-primary')
                        ); ?>
                    </li>


                    <li>
                        <?php
                        echo $this->Form->postLink(
                            '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                            array('action' => 'delete', $complaintResponse['ComplaintResponse']['id']),
                            array('escape' => false, 'class' => 'btn btn-danger'),
                            __('Are you sure you want to delete %s?', $complaintResponse['ComplaintResponse']['reference'])); ?>
                    </li>
                </ul>
            </div>

        </td>
    </tr>
<?php endforeach; ?>

