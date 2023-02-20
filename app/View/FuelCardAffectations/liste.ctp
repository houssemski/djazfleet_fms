<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
       width="100%">

    <tbody>
    <?php
    $cars = array();
    $i = 0;
    foreach ($fuelCardAffectations as $fuelCardAffectation) {
        $i++;

        if ($i < count($fuelCardAffectations)) {
            if ($fuelCardAffectations[$i]['FuelCardAffectation']['id'] == $fuelCardAffectation['FuelCardAffectation']['id']) {
                if ($param == 1) {
                    $cars[] = $fuelCardAffectation['Car']['code'] . " - " . $fuelCardAffectation['Carmodel']['name'];
                } else if ($param == 2) {
                    $cars[] = $fuelCardAffectation['Car']['immatr_def'] . " - " . $fuelCardAffectation['Carmodel']['name'];
                }

            } else {
                if ($param == 1) {
                    $cars[] = $fuelCardAffectation['Car']['code'] . " - " . $fuelCardAffectation['Carmodel']['name'];
                } else if ($param == 2) {
                    $cars[] = $fuelCardAffectation['Car']['immatr_def'] . " - " . $fuelCardAffectation['Carmodel']['name'];
                }

                ?>

                <tr id="row<?= $fuelCardAffectation['FuelCardAffectation']['id'] ?>">
                    <td>
                        <input id="idCheck" type="checkbox" class='id'
                               value=<?php echo $fuelCardAffectation['FuelCardAffectation']['id'] ?>>
                    </td>
                    <td><?php echo $fuelCardAffectation['FuelCardAffectation']['reference'] ?> </td>
                    <td>
                        <?php echo $fuelCardAffectation['FuelCard']['reference'] ?>
                    </td>
                    <td>
                        <?php
                        $nbCar = count($cars);

                        $j = 1;
                        foreach ($cars as $car) {
                            if ($j == $nbCar) {
                                echo $car;
                            } else {
                                echo $car . ' / ';
                            }
                            $j++;
                        } ?>
                    </td>
                    <td> <?php echo h($this->Time->format($fuelCardAffectation['FuelCardAffectation']['start_date'], '%d-%m-%Y')) ?></td>
                    <td> <?php echo h($this->Time->format($fuelCardAffectation['FuelCardAffectation']['end_date'], '%d-%m-%Y')) ?></td>
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
                                        array('action' => 'View', $fuelCardAffectation['FuelCardAffectation']['id']),
                                        array('escape' => false, 'class' => 'btn btn-success')
                                    ); ?>
                                </li>

                                <li>
                                    <?= $this->Html->link(
                                        '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                        array('action' => 'Edit', $fuelCardAffectation['FuelCardAffectation']['id']),
                                        array('escape' => false, 'class' => 'btn btn-primary')
                                    ); ?>
                                </li>


                                <li>
                                    <?php
                                    echo $this->Form->postLink(
                                        '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                        array('action' => 'delete', $fuelCardAffectation['FuelCardAffectation']['id']),
                                        array('escape' => false, 'class' => 'btn btn-danger'),
                                        __('Are you sure you want to delete %s?', $fuelCardAffectation['FuelCardAffectation']['reference'])); ?>
                                </li>
                            </ul>
                        </div>


                    </td>


                </tr>

                <?php  $fuelCardAffectationId = $fuelCardAffectation['FuelCardAffectation']['id'];
                $cars = array();
            }


        } else {
            if ($param == 1) {
                $cars[] = $fuelCardAffectation['Car']['code'] . " - " . $fuelCardAffectation['Carmodel']['name'];
            } else if ($param == 2) {
                $cars[] = $fuelCardAffectation['Car']['immatr_def'] . " - " . $fuelCardAffectation['Carmodel']['name'];
            }

            ?>


            <tr id="row<?= $fuelCardAffectation['FuelCardAffectation']['id'] ?>">
                <td class='case'>

                    <input id="idCheck" type="checkbox" class='id'
                           value=<?php echo $fuelCardAffectation['FuelCardAffectation']['id'] ?>>
                </td>
                <td><?php echo $fuelCardAffectation['FuelCardAffectation']['reference'] ?> </td>
                <td> <?php echo $fuelCardAffectation['FuelCard']['reference'] ?> </td>
                <td><?php
                    $nbCar = count($cars);

                    $j = 1;
                    foreach ($cars as $car) {
                        if ($j == $nbCar) {
                            echo $car;
                        } else {
                            echo $car . ' / ';
                        }
                        $j++;
                    } ?>

                </td>
                <td> <?php echo h($this->Time->format($fuelCardAffectation['FuelCardAffectation']['start_date'], '%d-%m-%Y')) ?></td>
                <td> <?php echo h($this->Time->format($fuelCardAffectation['FuelCardAffectation']['end_date'], '%d-%m-%Y')) ?></td>
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
                                    array('action' => 'View', $fuelCardAffectation['FuelCardAffectation']['id']),
                                    array('escape' => false, 'class' => 'btn btn-success')
                                ); ?>
                            </li>

                            <li>
                                <?= $this->Html->link(
                                    '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                    array('action' => 'Edit', $fuelCardAffectation['FuelCardAffectation']['id']),
                                    array('escape' => false, 'class' => 'btn btn-primary')
                                ); ?>
                            </li>


                            <li>
                                <?php
                                echo $this->Form->postLink(
                                    '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                    array('action' => 'delete', $fuelCardAffectation['FuelCardAffectation']['id']),
                                    array('escape' => false, 'class' => 'btn btn-danger'),
                                    __('Are you sure you want to delete %s?', $fuelCardAffectation['FuelCardAffectation']['reference'])); ?>
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
    if ($this->params['paging']['FuelCardCar']['pageCount'] > 1) {
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