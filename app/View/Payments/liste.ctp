<?php
App::import('Model', 'Payment');
$this->Payment = new Payment();
?>

<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
       width="100%">
    <tbody >
    <?php
    foreach ($payments as $payment): ?>
        <tr id="row<?= $payment['Payment']['id'] ?>"
            <?php if($payment['Payment']['transact_type_id']== 1) {?> style="background-color: rgba(95, 190, 170, 0.16); !important;"
            <?php } else { ?>
                style="background-color: rgba(240, 80, 80, 0.16); !important;"
            <?php } ?> >
            <td style="width: 40px">
                <input id="idCheck" type="checkbox" class='id'
                       tabindex="-1" value=<?php echo $payment['Payment']['id'] ?>>
                <?php if($payment['Payment']['transact_type_id']== 1) { ?>
                    <i style="position: relative;left: 15px;top: 2px; font-size: 12px; color:#0eac5c " class="fa fa-plus-square" aria-hidden="true"></i>
                <?php } else { ?>
                    <i style="position: relative;left: 15px;top: 2px; font-size: 12px; color: #ff4242 " class="fa fa-minus-square" aria-hidden="true"></i>
                <?php } ?>
            </td>
            <td>
                <div class="table-content editable">
                    <input
                            name="<?= $this->Payment->encrypt("payment|" . $payment['Payment']['id']); ?>"
                            value="<?= $this->Time->format($payment['Payment']['receipt_date'], '%d/%m/%Y') ?>"
                            class="form-control table-input3 receipt_date" type="text"
                            placeholder='' readonly="readonly" >
                    <span style="color: #fff0; display: none;"><?php echo $this->Time->format($payment['Payment']['receipt_date'], '%d/%m/%Y') ?></span>

                </div>

            </td>
            <td><?php echo h($payment['Compte']['num_compte']); ?>
                &nbsp;

            </td>
            <td>

                <div class="table-content editable">

                    <input
                            name="<?= $this->Payment->encrypt("payment|" . $payment['Payment']['id']); ?>"
                            value="<?= $payment['Payment']['wording'] ?>"
                            class="form-control table-input1 wording" type="text" readonly="readonly" >
                    <span style="color: #fff0; display: none;"> <?php echo $payment['Payment']['wording']; ?></span>
                </div>

            </td>
            <td><?php switch ($payment['PaymentAssociation']['id']) {
                    case 1:
                        $name = $payment['Supplier']['name'];
                        echo __("$name");
                        break;
                    case 2:
                        $name = $payment['Interfering']['name'];
                        echo __("$name");
                        break;
                    case 3:
                        $name = $payment['Customer']['first_name'] . ' ' . $payment['Customer']['last_name'];
                        echo __("$name");
                        break;
                    case 4:
                        $name = $payment['Supplier']['name'];
                        echo __("$name");
                        break;
                    case 5:
                        $name = $payment['Supplier']['name'];
                        echo __("$name");
                        break;
                    case 6:
                        $name = $payment['Supplier']['name'];
                        echo __("$name");
                        break;
                    default :
                        $name = $payment['Supplier']['name'];
                        echo __("$name");
                }
                ?>&nbsp;

            </td>
            <td><?php switch ($payment['Payment']['payment_type']) {

                    case 1:
                        echo __('Espèce');
                        break;
                    case 2:
                        echo __('Virement');
                        break;
                    case 3:
                        echo __('Chèque de banque');
                        break;

                    case 4:
                        echo __('Chèque');
                        break;

                    case 5:
                        echo __('Traite');
                        break;

                    case 6:
                        echo __('Fictif');
                        break;

                } ?>&nbsp;

            </td>
            <td><?php switch ($payment['Payment']['payment_etat']) {

                    case 1:
                        echo __('Non défini');
                        break;
                    case 2:
                        echo __('Chez nous');
                        break;
                    case 3:
                        echo __('En circulation');
                        break;

                    case 4:
                        echo __('Payé');
                        break;

                    case 5:
                        echo __('Impayé');
                        break;

                    case 6:
                        echo __('Annulé');
                        break;

                } ?>&nbsp;

            </td>
            <td>
                <?php echo  $payment['PaymentCategory']['name'] ?>

            </td>
            <td>
                <div class="table-content editable">
                    <input
                            name="<?= $this->Payment->encrypt("payment|" . $payment['Payment']['id']); ?>"
                            value="<?= $payment['Payment']['amount'] ?>" id="input3<?= $payment['Payment']['id'] ?>"
                            class="form-control table-input2 amount" type="number" step ="0.01"
                            readonly="readonly">
                    <span style="color: #fff0; display: none;"> <?php echo $payment['Payment']['amount']; ?></span>
                </div>

            </td>

            <td>
                <div class="table-content editable">
                    <input
                            name="<?= $this->Payment->encrypt("payment|" . $payment['Payment']['id']); ?>"
                            value="<?= $this->Time->format($payment['Payment']['operation_date'], '%d/%m/%Y') ?>"
                            class="form-control table-input4 operation_date" type="text"  placeholder=''
                            readonly="readonly">
                    <span style="color: #fff0; display: none;"> <?php echo $this->Time->format($payment['Payment']['operation_date'], '%d/%m/%Y'); ?></span>

                </div>
            </td>
            <td>
                <div class="table-content editable">
                    <input
                            name="<?= $this->Payment->encrypt("payment|" . $payment['Payment']['id']); ?>"
                            value="<?= $this->Time->format($payment['Payment']['value_date'], '%d/%m/%Y') ?>"
                            class="form-control table-input5 value_date" type="text"  placeholder=''
                            readonly="readonly" >
                    <span style="color: #fff0; display: none;"> <?php echo $this->Time->format($payment['Payment']['value_date'], '%d/%m/%Y'); ?></span>

                </div>

            </td>
            <td>
                <div class="table-content editable">
                    <input
                            name="<?= $this->Payment->encrypt("payment|" . $payment['Payment']['id']); ?>"
                            value="<?= $this->Time->format($payment['Payment']['deadline_date'], '%d/%m/%Y') ?>"
                            class="form-control table-input6 deadline_date" type="text"  placeholder=''
                            readonly="readonly" >
                    <span style="color: #fff0; display: none;"> <?php echo $this->Time->format($payment['Payment']['deadline_date'], '%d/%m/%Y'); ?></span>

                </div>

            </td>






            <td class="actions">
                <div class="btn-group ">
                    <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                        <i class="fa fa-list fa-inverse"></i>
                    </a>
                    <button tabindex="-1" href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                        <span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu" style="min-width: 70px;">

                        <li>
                            <?= $this->Html->link(
                                '<i   class="fa fa-eye" title="' . __('View') . '"></i>',
                                array('action' => 'viewPayment', $payment['Payment']['id']),
                                array('escape' => false, 'class' => 'btn btn-success')
                            ); ?>
                        </li>

                        <li>
                            <?= $this->Html->link(
                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                'javascript:editPayment(' . $payment['Payment']['id'] . ',' . $payment['PaymentAssociation']['id'] . ');',
                                array('escape' => false, 'class' => 'btn btn-primary')
                            ); ?>
                        </li>

                        <?php if($payment['PaymentAssociation']['id']== PaymentAssociationsEnum::cashing ||
                            $payment['PaymentAssociation']['id']== PaymentAssociationsEnum::disbursement
                        ) { ?>
                            <li>
                                <?= $this->Html->link(
                                    '<i class="fa fa-copy " title="' . __('Duplicate') . '"></i>',
                                    'javascript:duplicatePayment(' . $payment['Payment']['id'] . ',' . $payment['PaymentAssociation']['id'] . ');',
                                    array('escape' => false, 'class' => 'btn btn-warning')
                                ); ?>
                            </li>
                        <?php	} ?>

                        <li>
                            <?= $this->Html->link(
                                '<i class="fa fa-print " title="' . __('Print') . '"></i>',
                                array('action' => 'printRecuPayment', 'ext' => 'pdf', $payment['Payment']['id']),
                                array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-inverse')
                            ); ?>
                        </li>

                        <li>
                            <?php
                            echo $this->Form->postLink(
                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                array('action' => 'delete', $payment['Payment']['id'], $payment['PaymentAssociation']['id']),
                                array('escape' => false, 'class' => 'btn btn-danger'),
                                __('Are you sure you want to delete %s?', $payment['Payment']['wording'])); ?>
                        </li>
                    </ul>
                </div>


            </td>


        </tr>
    <?php endforeach; ?>
    </tbody>


</table>

<div id='pageCount' class="hidden">
    <?php
    if ($this->params['paging']['Payment']['pageCount'] > 1) {
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