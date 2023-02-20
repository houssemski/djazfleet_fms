    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"                            cellspacing="0" width="100%">


        <tbody>
	<?php

    if($category == SupplierCategoriesEnum::SUBCONTRACTOR){
        foreach ($suppliers as $supplier): ?>
            <tr id="row<?= $supplier['Supplier']['id'] ?>">
                <td>

                    <input id="idCheck" type="checkbox" class='id'
                           value=<?php echo $supplier['Supplier']['id'] ?>>
                </td>
                <td><?php echo h($supplier['Supplier']['code']); ?>&nbsp;</td>
                <td><?php echo h($supplier['Supplier']['name']); ?>&nbsp;</td>
                <td><?php echo h($supplier['Supplier']['adress']); ?>&nbsp;</td>
                <td><?php echo h($supplier['Supplier']['tel']); ?>&nbsp;</td>

                <td><?php echo h(number_format($supplier['Supplier']['balance'], 2, ",", $separatorAmount)); ?>
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
                                <?php echo $this->Html->link(
                                    '<i   class="fa fa-eye" title="' . __('View') . '"></i>',
                                    array('action' => 'View', $supplier['Supplier']['id']),
                                    array('escape' => false, 'class' => 'btn btn-success')
                                ); ?>
                            </li>

                            <li>
                                <?= $this->Html->link(
                                    '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                    array('action' => 'editOffShore', $supplier['Supplier']['id']),
                                    array('escape' => false, 'class' => 'btn btn-primary')
                                ); ?>
                            </li>
                            <li>
                                <?php    echo $this->Html->link(
                                    '<i class=" fa  fa-check" title="' . __('Deactivate') . '"></i>',
                                    array('action' => 'inactif', $supplier['Supplier']['id'], $this->params['pass']['0']),
                                    array('escape' => false, 'class' => 'btn btn-warding')
                                ); ?>
                            </li>
                            <li>
                                <?php  echo $this->Html->link(
                                    '<i class=" fa fa-print m-r-5"title="' . __('Supplier card') . '"></i>',
                                    array('action' => 'supplierCard', $supplier['Supplier']['id'], $this->params['pass']['0']),
                                    array('escape' => false, 'class' => 'btn btn-inverse')); ?>
                            </li>
                            <li>
                                <?php
                                echo $this->Form->postLink(
                                    '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                    array('action' => 'Delete', $supplier['Supplier']['id'], $this->params['pass']['0']),
                                    array('escape' => false, 'class' => 'btn btn-danger'),
                                    __('Are you sure you want to delete %s?', $supplier['Supplier']['name'])); ?>
                            </li>
                        </ul>
                    </div>


                </td>
            </tr>
        <?php endforeach;

    }else {
    foreach ($suppliers as $supplier): ?>
        <tr id="row<?= $supplier['Supplier']['id'] ?>">
            <td <?php if ($supplier['Supplier']['type']==1){?>
                onclick='viewFinalSuppliers(<?php echo $supplier['Supplier']['id'] ?>)'
            <?php } ?>
            >
                <input id="idCheck"type="checkbox" class = 'id' value=<?php echo $supplier['Supplier']['id'] ?> >
            </td>
            <td
                <?php if ($supplier['Supplier']['type']==1){?>
                    onclick='viewFinalSuppliers(<?php echo $supplier['Supplier']['id'] ?>)'
                <?php } ?>
            ><?php echo h($supplier['Supplier']['code']); ?>&nbsp;</td>
            <td
                <?php if ($supplier['Supplier']['type']==1){?>
                    onclick='viewFinalSuppliers(<?php echo $supplier['Supplier']['id'] ?>)'
                <?php } ?>
            ><?php echo h($supplier['Supplier']['name']); ?>&nbsp;</td>
            <td
                <?php if ($supplier['Supplier']['type']==1){?>
                    onclick='viewFinalSuppliers(<?php echo $supplier['Supplier']['id'] ?>)'
                <?php } ?>
            ><?php echo h($supplier['Supplier']['adress']); ?>&nbsp;</td>

            <td
                <?php if ($supplier['Supplier']['type']==1){?>
                    onclick='viewFinalSuppliers(<?php echo $supplier['Supplier']['id'] ?>)'
                <?php } ?>
            ><?php echo h($supplier['SupplierCategory']['name']); ?>&nbsp;</td>
            <td
                <?php if ($supplier['Supplier']['type']==1){?>
                    onclick='viewFinalSuppliers(<?php echo $supplier['Supplier']['id'] ?>)'
                <?php } ?>

            ><?php echo h(number_format($supplier['Supplier']['balance'], 2, ",", $separatorAmount));?>&nbsp;</td>
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
                            <?php echo $this->Html->link(
                                '<i   class="fa fa-eye" title="' . __('View') . '"></i>',
                                array('action' => 'View',$supplier['Supplier']['id']),
                                array('escape' => false, 'class'=>'btn btn-success')
                            ); ?>
                        </li>

                        <li>
                            <?= $this->Html->link(
                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                array('action' => 'Edit',$supplier['Supplier']['id'], $this->params['pass']['0']),
                                array('escape' => false , 'class'=>'btn btn-primary')
                            ); ?>
                        </li>
                        <li>
                            <?php    echo $this->Html->link(
                                '<i class=" fa  fa-check" title="' . __('Deactivate') . '"></i>',
                                array('action' => 'inactif', $supplier['Supplier']['id'], $this->params['pass']['0']),
                                array('escape' => false , 'class'=>'btn btn-warding')
                            ); ?>
                        </li>
                        <li>
                            <?php  echo $this->Html->link(
                                '<i class=" fa fa-print m-r-5"title="' . __('Supplier card') . '"></i>',
                                array('action' => 'supplierCard', $supplier['Supplier']['id'], $this->params['pass']['0']),
                                array('escape' => false, 'class'=>'btn btn-inverse')); ?>
                        </li>
                        <li>
                            <?php
                            echo $this->Form->postLink(
                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                array('action' => 'Delete', $supplier['Supplier']['id'],$this->params['pass']['0']),
                                array('escape' => false , 'class'=>'btn btn-danger'),
                                __('Are you sure you want to delete %s?',$supplier['Supplier']['name'])); ?>
                        </li>
                    </ul>
                </div>



            </td>
        </tr>
    <?php endforeach;
    } ?>





        </tbody>
</table>
<div id ='pageCount' class="hidden">

    <?php
    if($this->params['paging']['Supplier']['pageCount'] > 1){
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

                
