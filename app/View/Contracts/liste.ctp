                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                       cellspacing="0" width="100%">
                    
                    <tbody>
                    <?php foreach ($contracts as $contract): ?>
                        <tr id="row<?= $contract['ContractCarType']['id'] ?>">
                            <td>

                                <input id="idCheck"type="checkbox" class = 'id' value=<?php echo $contract['Contract']['id'] ?> >
                            </td>
                            <td><?php echo h($contract['Contract']['reference']); ?>&nbsp;</td>
                            <td><?php echo h($contract['Supplier']['name']); ?>&nbsp;</td>
                            <td><?php echo h($contract['DepartureDestination']['name'].'-'. $contract['ArrivalDestination']['name'].'-'.$contract['CarType']['name']); ?>&nbsp;</td>
                            <td><?php echo h(number_format($contract['ContractCarType']['price_ht'], 2, ",", ".")); ?>&nbsp;</td>
                            <td><?php echo h(number_format($contract['ContractCarType']['price_return'], 2, ",", ".")); ?>&nbsp;</td>
                            <td><?php echo h($this->Time->format($contract['ContractCarType']['date_start'], '%d-%m-%Y')); ?>&nbsp;</td>
                            <td><?php echo h($this->Time->format($contract['ContractCarType']['date_end'], '%d-%m-%Y')); ?>&nbsp;</td>
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
                                                array('action' => 'View',$contract['Contract']['id']),
                                                array('escape' => false, 'class'=>'btn btn-success')
                                            ); ?>
                                        </li>

                                        <li>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                array('action' => 'Edit', $contract['Contract']['id']),
                                                array('escape' => false , 'class'=>'btn btn-primary')
                                            ); ?>
                                        </li>

                                        <li>
                                            <?= $this->Html->link(
                                                '<i class=" fa fa-print title="' . __('Print') . '"></i>',
                                                array('action' => 'printContract', 'ext' => 'pdf', $contract['Contract']['id']),
                                                array('target' => '_blank','escape' => false , 'class'=>'btn btn-warning')
                                            ); ?>
                                        </li>


                                        <li>
                                            <?php
                                            echo $this->Form->postLink(
                                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                                array('action' => 'delete', $contract['Contract']['id']),
                                                array('escape' => false , 'class'=>'btn btn-danger'),
                                                __('Are you sure you want to delete %s?',$contract['Contract']['reference'])); ?>
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
if($this->params['paging']['ContractCarType']['pageCount'] > 1){
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