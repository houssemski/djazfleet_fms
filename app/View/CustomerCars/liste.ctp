<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
       cellspacing="0" width="100%">

    <tbody>
    <?php foreach ($customercars as $customercar): ?>
        <tr id="row<?= $customercar['CustomerCar']['id'] ?>">

            <td>
                <input id="idCheck"type="checkbox" class = 'id' value=<?php echo $customercar['CustomerCar']['id'] ?> >
            </td>
            <td>
                <?php if ($param==1){
                    echo $customercar['Car']['code']." - ".$customercar['Carmodel']['name'];
                } else if ($param==2) {
                    echo $customercar['Car']['immatr_def']." - ".$customercar['Carmodel']['name'];
                } ?>
            </td>
            <td>
                <?php echo $customercar['Car']['immatr_prov']; ?>&nbsp;
            </td>
            <td>
                <?php echo $customercar['Car']['immatr_def']; ?>&nbsp;
            </td>
            <td>
                <?php
                echo $customercar['Customer']['first_name'] . " " . $customercar['Customer']['last_name']; ?>
                &nbsp;
            </td>

            <td>
                <?php echo $customercar['CustomerGroup']['name']; ?>&nbsp;
            </td>
            <td>
                <?php echo $customercar['Customer']['mobile']; ?>&nbsp;
            </td>

            <td><?php echo h($this->Time->format($customercar['CustomerCar']['start'], '%d-%m-%Y %H:%M')); ?>&nbsp;</td>
            <td><?php echo h($this->Time->format($customercar['CustomerCar']['end'], '%d-%m-%Y %H:%M')); ?>&nbsp;</td>
            <td><?php echo h($this->Time->format($customercar['CustomerCar']['end_real'], '%d-%m-%Y %H:%M')); ?>
                &nbsp;</td>

            <td class="actions">
                <div  class="btn-group ">
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
                                array('action' => 'View', $customercar['CustomerCar']['id']),
                                array('escape' => false, 'class'=>'btn btn-success')
                            ); ?>
                        </li>

                        <li>
                            <?= $this->Html->link(
                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                array('action' => 'Edit', $customercar['CustomerCar']['id'] ),
                                array('escape' => false , 'class'=>'btn btn-primary')
                            ); ?>
                        </li>
                        <li>
                        <li>
                            <?php echo $this->Html->link('<i class="fa fa-Print " title="' . __('PV de reception') . '"></i>',
                                array('action' => 'affectation_pv', 'ext' => 'pdf', $customercar['CustomerCar']['id'],0),
                                array('target' => '_blank', 'escape' => false , 'class'=>'btn btn-warning' ));?>
                        </li>
                        <li>
                            <?php echo $this->Html->link( '<i class="fa fa-Print " title="' . __('PV de restitution') . '"></i>',
                                array('action' => 'affectation_pv', 'ext' => 'pdf', $customercar['CustomerCar']['id'],1),
                                array('target' => '_blank', 'escape' => false , 'class'=>'btn btn-warning'));?>
                        </li>
                        <li>
                            <?php echo $this->Html->link(  '<i class="fa fa-Print " title="' . __('Décharge') . '"></i>',
                                array('action' => 'dechargePdf', 'ext' => 'pdf', $customercar['CustomerCar']['id']),
                                array('target' => '_blank', 'escape' => false , 'class'=>'btn btn-warning'));?>
                        </li>
                        <li class='decharge-link' title='<?= __('Mission order') ?>'>
                            <?php echo $this->Html->link('<i class="fa fa-Print "></i>',
                                array('action' => 'view_mission', 'ext' => 'pdf', $customercar['CustomerCar']['id']),
                                array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning'));?>
                        </li>



                        <li>
                            <?php
                            if ($customercar['CustomerCar']['locked'] == 1) {
                                echo $this->Html->link(
                                    '<i class="fa  fa-lock " title="' . __('Unlock') . '"></i>',
                                    array('action' => 'unlock', $customercar['CustomerCar']['id']),
                                    array('escape' => false , 'class'=>'btn btn-purple')
                                );
                            } else {
                                echo $this->Html->link(
                                    '<i class="fa  fa-unlock " title="' . __('Lock') . '"></i>',
                                    array('action' => 'lock', $customercar['CustomerCar']['id']),
                                    array('escape' => false , 'class'=>'btn btn-purple')
                                );
                            }?>
                        </li>
                        <li>
                            <?php
                            echo $this->Html->link(
                                '<i class="fa fa-envelope" title="'.__('Send the mission order by email').'"></i>',
                                array('action' => 'Send_mail', $customercar['CustomerCar']['id']),
                                array('escape' => false ,  'class'=>'btn btn-inverse'));
                            ?>
                        </li>


                        <li>
                            <?php
                            echo $this->Form->postLink(
                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                array('action' => 'delete', $customercar['CustomerCar']['id']),
                                array('escape' => false , 'class'=>'btn btn-danger'),
                                __('Are you sure you want to delete this element ?')); ?>
                        </li>




                    </ul>
                </div>





                <div class="btn-group">

                    <button type="button" id="print_customer_car" style="background-color: #f9f9f9;color: #333; border:none; padding: 0;"
                            class=" dropdown-toggle " data-toggle="dropdown">
                        <i class="fa fa-print m-r-5"></i>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <?php echo $this->Html->link(__('PV de reception'),
                                array('action' => 'affectation_pv', 'ext' => 'pdf', $customercar['CustomerCar']['id'],0),
                                array('target' => '_blank', 'escape' => false));?>
                            <?php echo $this->Html->link(__('PV de restitution'),
                                array('action' => 'affectation_pv', 'ext' => 'pdf', $customercar['CustomerCar']['id'],1),
                                array('target' => '_blank', 'escape' => false));?>
                            <?php echo $this->Html->link(__('Décharge'),
                                array('action' => 'dechargePdf', 'ext' => 'pdf', $customercar['CustomerCar']['id']),
                                array('target' => '_blank', 'escape' => false));?>
                        </li>
                    </ul>
                </div>



            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div id ='pageCount' class="hidden">
<?php if ($this->params['paging']['CustomerCar']['pageCount'] > 1) {
    ?>
    <p>
        <?php echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?>    </p>
    <div class="box-footer clearfix">
        <ul class="pagination pagination-sm no-margin pull-left">
            <?php
            echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
            echo $this->Paginator->numbers(array(
                'tag' => 'li',
                'first' => false,
                'last' => false,
                'separator' => '',
                'currentTag' => 'a'));
            echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
            ?>
        </ul>
    </div>
<?php } ?>
    </div>