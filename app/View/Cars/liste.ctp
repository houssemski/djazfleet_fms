

<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
       cellspacing="0" width="100%">
    <tbody>
    <?php foreach ($cars as $car): ?>
        <tr id="row<?= $car['Car']['id'] ?>">

            <td>
                <input id="idCheck" type="checkbox" class = 'id' value=<?php echo $car['Car']['id'] ?> >
            </td>

            <td><?php echo h($car['Car']['code']); ?>&nbsp;</td>

            <td><?php
                if (!empty($car['Mark']['logo'])) {
                    echo $this->Html->image('/mark/' . h($car['Mark']['logo']),
                        array(
                            'class' => 'mark_logo',
                            'alt' => 'Logo'
                        ));
                }
                if (isset($car['Car']['picture1']) && !empty($car['Car']['picture1'])) {
                    ?>
                    <a style="color: #ed1e24;" href="<?php echo $this->Html->url(array('action' => 'view', $car['Car']['id'])); ?>"
                       class="infobulle"> <?php echo "  " . h($car['Carmodel']['name']); ?>
                        <span><img
                                src="attachments/picturescar/<?php echo h($car['Car']['picture1']); ?>"/></span>
                    </a>
                <?php
                } else {
                    echo "  " . h($car['Carmodel']['name']);
                    ?>
                <?php } ?>
            </td>

            <td class="right alert-km"><?php if ($car['Car']['km'] > 0) echo h(number_format($car['Car']['km'], 2, ",", ".")); else echo h(number_format($car['Car']['km_initial'], 2, ",", ".")); ?></td>

            <td>
                <?php   if (!empty($car['CarType']['id'])) {
                    echo $this->Html->image('/img/pictureCarType/' .$car['CarType']['id'].'.png' ,
                        array(
                            'class' => 'car_type',
                            'alt' => 'carType'
                        ));
                } ?>
            </td>
            <td><?php echo h($car['Fuel']['name']); ?>&nbsp;</td>
            <td><?php echo h($car['Car']['immatr_def']); ?>&nbsp;</td>
            <td><?php echo h($car['Car']['chassis']); ?>&nbsp;</td>
            <td><?php echo h($car['Car']['color2']); ?>&nbsp;</td>
            <?php if ($balance_car == 2) { ?>
                <td><?php echo h(number_format($car['Car']['balance'], 2, ",", ".")); ?>&nbsp;</td>
            <?php } ?>
            <td>
                <?php

                echo '<span class="label" style=background-color:' . $car['CarStatus']['color'];
                '';
                echo ";>" . h($car['CarStatus']['name']) . "</span>";
                ?>&nbsp;
            </td>

            <td style='text-align: center;'>
                <?php


										switch ($car['Car']['in_mission']) {

                                            case 0:
                                                echo __('Au parc');
                                                break;

                                            case 1:
                                                echo __('En mission');
                                                break;

                                            case 2:
                                                echo __('Retour au parc');
                                                break;

                                        }


                                    ?>

                
            </td>

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
                                array('action' => 'View', $car['Car']['id']),
                                array('escape' => false, 'class'=>'btn btn-success')
                            ); ?>
                        </li>
                        <li>
                            <?php if ($client_i2b == 1) {  ?>
                                <?= $this->Html->link(
                                    '<i class="fa fa-map-marker "></i>',
                                    array('action' => 'viewPosition', $car['Car']['id']),
                                    array('escape' => false, 'class'=>'btn btn-inverse' )
                                ); ?>
                            <?php } ?>
                        </li>
                        <li>
                            <?= $this->Html->link(
                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                array('action' => 'Edit', $car['Car']['id'],$car['CarCategory']['id'] ),
                                array('escape' => false , 'class'=>'btn btn-primary')
                            ); ?>
                        </li>
                        <li>
                            <?php if ((isset($car['Car']['yellow_card']) && !empty($car['Car']['yellow_card'])) && (isset($car['Car']['grey_card']) && !empty($car['Car']['grey_card']))
                                && ((isset($car['Car']['picture1']) && !empty($car['Car']['picture1'])) || (isset($car['Car']['picture2']) && !empty($car['Car']['picture2'])) ||
                                    (isset($car['Car']['picture3']) && !empty($car['Car']['picture3'])) || (isset($car['Car']['picture4']) && !empty($car['Car']['picture4'])))
                            ) {
                                echo $this->Html->link(
                                    '<i class="fa fa-paperclip " title="' . __('Attachments') . '"></i>',

                                    /*'/attachments/yellowcards/' . $car['Car']['yellow_card'],
                                    array('class' => 'attachments', 'target' => '_blank','escape' => false)*/
                                    array('action' => 'View', $car['Car']['id']),
                                    array('escape' => false , 'class'=>'btn btn-warning')
                                );
                            } else {
                                if (empty($car['Car']['yellow_card']) && empty($car['Car']['grey_card']) && empty($car['Car']['picture1']) &&
                                    empty($car['Car']['picture2']) && empty($car['Car']['picture3']) && empty($car['Car']['picture4'])
                                ) {
                                    echo $this->Html->link(
                                        '<i class="fa fa-unlink " title="' . __('Missing attachments') . '"></i>',

                                        array('action' => 'Edit', $car['Car']['id'],$car['CarCategory']['id']),
                                        array('escape' => false , 'class'=>'btn btn-warning')

                                    );
                                } elseif (empty($car['Car']['grey_card'])) {
                                    echo $this->Html->link(
                                        '<i class="fa fa-unlink " title="' . __('Missing attachments grey card') . '"></i>',

                                        array('action' => 'Edit', $car['Car']['id'],$car['CarCategory']['id']),
                                        array('escape' => false , 'class'=>'btn btn-warning')

                                    );
                                } elseif (empty($car['Car']['yellow_card']) && empty($car['Car']['grey_card'])) {
                                    echo $this->Html->link(
                                        '<i class="fa fa-unlink " title="' . __('Missing attachments yellow card and grey card') . '"></i>',

                                        array('action' => 'Edit', $car['Car']['id'],$car['CarCategory']['id']),
                                        array('escape' => false , 'class'=>'btn btn-warning')

                                    );
                                } elseif (empty($car['Car']['picture1']) || empty($car['Car']['picture2']) || empty($car['Car']['picture3']) || empty($car['Car']['picture4'])) {
                                    echo $this->Html->link(
                                        '<i class="fa fa-unlink " title="' . __('Missing attachments pictures') . '"></i>',
                                        array('action' => 'Edit', $car['Car']['id'],$car['CarCategory']['id']),
                                        array('escape' => false , 'class'=>'btn btn-warning')
                                    );
                                }
                            } ?>
                        </li>
                        <li>
                            <?php
                            if ($car['Car']['locked'] == 1) {
                                echo $this->Html->link(
                                    '<i class="fa  fa-lock " title="' . __('Unlock') . '"></i>',
                                    array('action' => 'unlock', $car['Car']['id']),
                                    array('escape' => false , 'class'=>'btn btn-purple')
                                );
                            } else {
                                echo $this->Html->link(
                                    '<i class="fa  fa-unlock " title="' . __('Lock') . '"></i>',
                                    array('action' => 'lock', $car['Car']['id']),
                                    array('escape' => false , 'class'=>'btn btn-purple')
                                );
                            }?>
                        </li>
                        <li>
                            <?php
                            echo $this->Form->postLink(
                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                array('action' => 'delete', $car['Car']['id']),
                                array('escape' => false , 'class'=>'btn btn-danger'),
                                __('Are you sure you want to delete %s?', $car['Carmodel']['name'])); ?>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div id ='pageCount' class="hidden">
<?php
if ($this->params['paging']['Car']['pageCount'] > 1) {
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