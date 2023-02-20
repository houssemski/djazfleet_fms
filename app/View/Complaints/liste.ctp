<?php foreach ($complaints as $complaint):

    ?>
    <tr id="row<?= $complaint['Complaint']['id'] ?>">
        <td>

            <input id="idCheck" type="checkbox" class='id'
                   value=<?php echo $complaint['Complaint']['id'] ?>>
        </td>
        <td><?php echo h($complaint['Complaint']['reference']); ?>&nbsp;</td>
        <td><?php echo h($this->Time->format($complaint['Complaint']['taken_over_date'], '%d-%m-%Y')); ?></td>
        <td><?php
            switch ($complaint['Complaint']['type']){
                case 1:
                    echo __('Appel');
                    break;
                case 2:
                    echo __('Email');
                    break;
                case 3:
                    echo __('Sms');
                    break;
                case 4:
                    echo __('Direct ou oral');
                    break;
                case 5:
                    echo __('Courier');
                    break;
                case 6:
                    echo __('Autres');
                    break;
            } ?>&nbsp;</td>
        <td><?php echo $complaint['SheetRideDetailRides']['reference'] ;?> </td>

        <td><?php
            switch ($complaint['Complaint']['origin']){
                case 1:
                    echo __('Interne');
                    break;
                case 2:
                    echo __('Externe');
                    break;

            } ?>&nbsp;</td>
        <td><?php echo $complaint['ComplaintCause']['name'] ;?> </td>
        <td><?php
            switch ($complaint['Complaint']['solutionable']){
                case 1:
                    echo __('Yes');
                    break;
                case 2:
                    echo __('No');
                    break;

            } ?>&nbsp;</td>
        <td><?php
            switch ($complaint['Complaint']['status_id']){
                case 1:
                    echo __('Non reglé');
                    break;
                case 2:
                    echo __('Pris en charge');
                    break;
                case 3:
                    echo __('Reglé');
                    break;

            } ?>&nbsp;</td>
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
                            array('action' => 'View', $complaint['Complaint']['id']),
                            array('escape' => false, 'class' => 'btn btn-success')
                        ); ?>
                    </li>

                    <li>
                        <?= $this->Html->link(
                            '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                            array('action' => 'Edit', $complaint['Complaint']['id']),
                            array('escape' => false, 'class' => 'btn btn-primary')
                        ); ?>
                    </li>


                    <li>
                        <?php
                        echo $this->Form->postLink(
                            '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                            array('action' => 'delete', $complaint['Complaint']['id']),
                            array('escape' => false, 'class' => 'btn btn-danger'),
                            __('Are you sure you want to delete %s?', $complaint['Complaint']['reference'])); ?>
                    </li>
                </ul>
            </div>

        </td>
    </tr>
<?php endforeach; ?>

