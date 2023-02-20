<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
       cellspacing="0" width="100%">

    <tbody id="listeDiv">
    <?php
    $event_types = array();
    $i = 0;

    foreach ($events as $event) {
        $i++;

        if ($i < count($events)) {
            if ($events[$i]['Event']['id'] == $event['Event']['id']) {
                $event_types[] = $event['EventType']['name'];
            } else {
                $event_types[] = $event['EventType']['name'];

                ?>

                <tr class="alert <?= ($event['Event']['alert'] == 1) ? "alert-danger" : "" ?>"
                    id="row<?= $event['Event']['id'] ?>">
                    <td class='case'>

                        <input id="idCheck" type="checkbox" class='id' value=<?php echo $event['Event']['id'] ?>>
                    </td>
                    <td>
                        <?php
                        $nbEvent = count($event_types);

                        $j = 1;
                        foreach ($event_types as $event_type) {
                            if ($j == $nbEvent) {
                                echo $event_type;
                            } else {
                                echo $event_type . ' - ';
                            }
                            $j++;
                        } ?>
                    </td>
                    <td> <?php if ($param == 1) {
                            echo $event['Car']['code'] . " - " . $event['Carmodel']['name'];
                        } else if ($param == 2) {
                            echo $event['Car']['immatr_def'] . " - " . $event['Carmodel']['name'];
                        } ?>
                    </td>
                    <td>


                        <?php

                        echo $event['Customer']['first_name'] . " " . $event['Customer']['last_name'];
                        ?>
                    </td>
                    <td>


                        <?php
                        if ($event['Event']['date'] != NULL) {
                            echo h($this->Time->format($event['Event']['date'], '%d-%m-%Y'));
                        } ?>


                    </td>
                    <td>

                        <?php
                        if ($event['Event']['next_date'] != NULL) {
                            echo h($this->Time->format($event['Event']['next_date'], '%d-%m-%Y'));
                        } ?>


                    </td>
                    <td class="right">

                        <?php
                        if ($event['Event']['km'] != NULL) {
                            echo h(number_format($event['Event']['km'], 0, ",", "."));
                        } ?>


                    </td>
                    <td class="right">

                        <?php
                        if ($event['Event']['next_km'] != NULL) {
                            echo h(number_format($event['Event']['next_km'], 0, ",", "."));
                        } ?>


                    </td>
                    <td class="right">

                        <?php echo h(number_format($event['Event']['cost'], 2, ",", ".")); ?>

                    </td>
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
                                        array('action' => 'View', $event['Event']['id']),
                                        array('escape' => false, 'class' => 'btn btn-success')
                                    ); ?>
                                </li>

                                <li>
                                    <?php  if ($event['Event']['multiple_event'] == 0) {

                                        echo $this->Html->link(
                                            '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                            array('action' => 'edit', $event['Event']['id']),
                                            array('escape' => false, 'class' => 'btn btn-primary')
                                        );

                                    } else {

                                        echo $this->Html->link(
                                            '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                            array('action' => 'EditMultipleEvents', $event['Event']['id']),
                                            array('escape' => false, 'class' => 'btn btn-primary')
                                        );

                                    } ?>

                                </li>
                                <li>
                                    <?php
                                    if ((isset($event['Event']['attachment1']) && !empty($event['Event']['attachment1'])) || (isset($event['Event']['attachment2']) && !empty($event['Event']['attachment2'])) ||
                                        (isset($event['Event']['attachment3']) && !empty($event['Event']['attachment3'])) || (isset($event['Event']['attachment4']) && !empty($event['Event']['attachment4']))
                                        || (isset($event['Event']['attachment5']) && !empty($event['Event']['attachment5']))
                                    ) {
                                        echo $this->Html->link(
                                            '<i class="fa fa-paperclip " title="' . __('Attachments') . '"></i>',
                                            array('action' => 'View', $event['Event']['id']),
                                            array('escape' => false, 'class' => 'btn btn-warning')

                                        );
                                    } else {
                                        if (empty($event['Event']['attachment1']) && empty($event['Event']['attachment2']) && empty($event['Event']['attachment3']) && empty($event['Event']['attachment4']) && empty($event['Event']['attachment5'])) {
                                            if ($event['Event']['multiple_event'] == 0) {
                                                echo $this->Html->link(
                                                    '<i class="fa fa-unlink " title="' . __('Missing attachments') . '"></i>',
                                                    array('action' => 'edit', $event['Event']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-warning')
                                                );
                                            } else {

                                                echo $this->Html->link(
                                                    '<i class="fa fa-unlink " title="' . __('Missing attachments') . '"></i>',
                                                    array('action' => 'EditMultipleEvents', $event['Event']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-warning')
                                                );
                                            }
                                        }
                                    } ?>

                                </li>
                                <li>
                                    <?php
                                    if ($event['Event']['locked'] == 1) {
                                        echo $this->Html->link(
                                            '<i class="fa  fa-lock " title="' . __('Unlock') . '"></i>',
                                            array('action' => 'unlock', $event['Event']['id']),
                                            array('escape' => false, 'class' => 'btn btn-purple')
                                        );
                                    } else {
                                        echo $this->Html->link(
                                            '<i class="fa  fa-unlock " title="' . __('Lock') . '"></i>',
                                            array('action' => 'lock', $event['Event']['id']),
                                            array('escape' => false, 'class' => 'btn btn-purple')
                                        );
                                    }?>
                                </li>
                                <li>
                                    <?php
                                    echo $this->Form->postLink(
                                        '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                        array('action' => 'delete', $event['Event']['id']),
                                        array('escape' => false, 'class' => 'btn btn-danger'),
                                        __('Are you sure you want to delete this event?')); ?>
                                </li>

                            </ul>
                        </div>


                    </td>
                </tr>

                <?php  $event_id = $event['Event']['id'];
                $event_types = array();
            }


        } else {
            $event_types[] = $event['EventType']['name'];

            ?>


            <tr class="alert <?= ($event['Event']['alert'] == 1) ? "alert-danger" : "" ?>"
                id="row<?= $event['Event']['id'] ?>">
                <td class='case'>

                    <input id="idCheck" type="checkbox" class='id' value=<?php echo $event['Event']['id'] ?>>
                </td>
                <td><?php
                    $nbEvent = count($event_types);

                    $j = 1;
                    foreach ($event_types as $event_type) {
                        if ($j == $nbEvent) {
                            echo $event_type;
                        } else {
                            echo $event_type . ' - ';
                        }
                        $j++;
                    } ?>

                </td>
                <td> <?php if ($param == 1) {
                        echo $event['Car']['code'] . " - " . $event['Carmodel']['name'];
                    } else if ($param == 2) {
                        echo $event['Car']['immatr_def'] . " - " . $event['Carmodel']['name'];
                    } ?>
                </td>
                <td>


                    <?php

                    echo $event['Customer']['first_name'] . " " . $event['Customer']['last_name'];
                    ?>
                </td>
                <td>


                    <?php
                    if ($event['Event']['date'] != NULL) {
                        echo h($this->Time->format($event['Event']['date'], '%d-%m-%Y'));
                    } ?>


                </td>
                <td>

                    <?php
                    if ($event['Event']['next_date'] != NULL) {
                        echo h($this->Time->format($event['Event']['next_date'], '%d-%m-%Y'));
                    } ?>


                </td>
                <td class="right">

                    <?php
                    if ($event['Event']['km'] != NULL) {
                        echo h(number_format($event['Event']['km'], 0, ",", "."));
                    } ?>


                </td>
                <td class="right">

                    <?php
                    if ($event['Event']['next_km'] != NULL) {
                        echo h(number_format($event['Event']['next_km'], 0, ",", "."));
                    } ?>


                </td>
                <td class="right">

                    <?php echo h(number_format($event['Event']['cost'], 2, ",", ".")); ?>

                </td>
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
                                    array('action' => 'View', $event['Event']['id']),
                                    array('escape' => false, 'class' => 'btn btn-success')
                                ); ?>
                            </li>

                            <li>
                                <?php  if ($event['Event']['multiple_event'] == 0) {

                                    echo $this->Html->link(
                                        '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                        array('action' => 'edit', $event['Event']['id']),
                                        array('escape' => false, 'class' => 'btn btn-primary')
                                    );

                                } else {

                                    echo $this->Html->link(
                                        '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                        array('action' => 'EditMultipleEvents', $event['Event']['id']),
                                        array('escape' => false, 'class' => 'btn btn-primary')
                                    );

                                } ?>

                            </li>
                            <li>
                                <?php
                                if ((isset($event['Event']['attachment1']) && !empty($event['Event']['attachment1'])) || (isset($event['Event']['attachment2']) && !empty($event['Event']['attachment2'])) ||
                                    (isset($event['Event']['attachment3']) && !empty($event['Event']['attachment3'])) || (isset($event['Event']['attachment4']) && !empty($event['Event']['attachment4']))
                                    || (isset($event['Event']['attachment5']) && !empty($event['Event']['attachment5']))
                                ) {
                                    echo $this->Html->link(
                                        '<i class="fa fa-paperclip " title="' . __('Attachments') . '"></i>',
                                        array('action' => 'View', $event['Event']['id']),
                                        array('escape' => false, 'class' => 'btn btn-warning')

                                    );
                                } else {
                                    if (empty($event['Event']['attachment1']) && empty($event['Event']['attachment2']) && empty($event['Event']['attachment3']) && empty($event['Event']['attachment4']) && empty($event['Event']['attachment5'])) {
                                        if ($event['Event']['multiple_event'] == 0) {
                                            echo $this->Html->link(
                                                '<i class="fa fa-unlink " title="' . __('Missing attachments') . '"></i>',
                                                array('action' => 'edit', $event['Event']['id']),
                                                array('escape' => false, 'class' => 'btn btn-warning')
                                            );
                                        } else {

                                            echo $this->Html->link(
                                                '<i class="fa fa-unlink " title="' . __('Missing attachments') . '"></i>',
                                                array('action' => 'EditMultipleEvents', $event['Event']['id']),
                                                array('escape' => false, 'class' => 'btn btn-warning')
                                            );
                                        }
                                    }
                                } ?>

                            </li>
                            <li>
                                <?php
                                if ($event['Event']['locked'] == 1) {
                                    echo $this->Html->link(
                                        '<i class="fa  fa-lock " title="' . __('Unlock') . '"></i>',
                                        array('action' => 'unlock', $event['Event']['id']),
                                        array('escape' => false, 'class' => 'btn btn-purple')
                                    );
                                } else {
                                    echo $this->Html->link(
                                        '<i class="fa  fa-unlock " title="' . __('Lock') . '"></i>',
                                        array('action' => 'lock', $event['Event']['id']),
                                        array('escape' => false, 'class' => 'btn btn-purple')
                                    );
                                }?>
                            </li>
                            <li>
                                <?php
                                echo $this->Form->postLink(
                                    '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                    array('action' => 'delete', $event['Event']['id']),
                                    array('escape' => false, 'class' => 'btn btn-danger'),
                                    __('Are you sure you want to delete this event?')); ?>
                            </li>

                        </ul>
                    </div>
                </td>
            </tr>






        <?php
        }
    }
    ?>
    </tbody>
</table>

<div id='pageCount' class="hidden">
    <?php

    $nb_row = $this->params['paging']['EventEventType']['pageCount'];
    if ($nb_row > 1) {
        ?>
        <p>
            <?php
            echo $this->Paginator->counter(array(
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