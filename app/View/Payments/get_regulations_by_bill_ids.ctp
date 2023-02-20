<p><?php echo __('Non-associated financial transactions')?></p>
<table id="datatable-responsive2" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th style="width: 10px">
            <button type="button" id ='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
        </th>
        <th><?php echo  __('Date'); ?></th>
        <th><?php echo  __('Amount'); ?></th>
        <th><?php echo  __('Payment type'); ?></th>
        <th><?php echo  __('Rest'); ?></th>
        <th><?php echo  __('Wording'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    echo "<div class='form-group'>" . $this->Form->input('ids', array(
            'type'=>'hidden',
            'id'=>'ids',
            'class' => 'form-control',
        )) . "</div>";

    echo "<div class='form-group'>" . $this->Form->input('billIds', array(
            'type'=>'hidden',
            'id'=>'billIds',
            'value'=>$billIds,
            'class' => 'form-control',
        )) . "</div>";

    echo "<div class='form-group'>" . $this->Form->input('model', array(
            'type'=>'hidden',
            'id'=>'model',
            'value'=>$model,
            'class' => 'form-control',
        )) . "</div>";

    foreach ($advancedPayments as $advancedPayment){
        ?>
        <tr>
            <td>
                <input id="idCheck"type="checkbox" class = 'id2' value=<?php echo $advancedPayment['Payment']['id'] ?> >
            </td>
            <td><?php echo h($this->Time->format($advancedPayment['Payment']['receipt_date'], '%d-%m-%Y')); ?></td>
            <td><?php echo number_format($advancedPayment['Payment']['amount'], 2, ",", $separatorAmount);?></td>
            <td><?php  switch($advancedPayment['Payment']['payment_type']){
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

                } ?></td>
            <td>   <?php echo number_format($advancedPayment['Payment']['amount'], 2, ",", $separatorAmount);?></td>
            <td><?php echo h($advancedPayment['Payment']['wording']); ?></td>

        </tr>
    <?php }
    foreach ($remainingPayments as $remainingPayment){
        ?>
        <tr>
            <td>
                <input id="idCheck"type="checkbox" class = 'id2' value=<?php echo $remainingPayment['Payment']['id'] ?> >
            </td>
            <td><?php echo h($this->Time->format($remainingPayment['Payment']['receipt_date'], '%d-%m-%Y')); ?></td>
            <td><?php echo number_format($remainingPayment['Payment']['amount'], 2, ",", $separatorAmount);?></td>
            <td><?php  switch($remainingPayment['Payment']['payment_type']){
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

                } ?></td>
            <td> <?php $amountRemaining  = $remainingPayment['Payment']['amount'] - $remainingPayment[0]['sum_payroll_amount'];
                echo number_format($amountRemaining, 2, ",", $separatorAmount);?>
            </td>
            <td><?php echo h($remainingPayment['Payment']['wording']); ?></td>

        </tr>
    <?php } ?>

    </tbody>
</table>
<br><br>
<p><?php echo __('Financial transactions associated with the current bill')?></p>
<table id="datatable-responsive3" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th style="width: 10px">
            <button type="button" id ='checkbox' class="btn btn-default btn-sm checkbox-toggle3"><i class="fa fa-square-o"></i></button>
        </th>
        <th><?php echo  __('Date'); ?></th>
        <th><?php echo  __('Amount'); ?></th>
        <th><?php echo  __('Tranche'); ?></th>
        <th><?php echo  __('Payment type'); ?></th>
        <th><?php echo  __('Wording'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($paymentParts as $paymentPart){
        ?>
        <tr>
            <td>
                <input id="idCheck"type="checkbox" class = 'id3' value=<?php echo $paymentPart['Payment']['id'] ?> >
            </td>
            <td><?php echo h($this->Time->format($paymentPart['Payment']['receipt_date'], '%d-%m-%Y')); ?></td>
            <td><?php echo number_format($paymentPart['Payment']['amount'], 2, ",", $separatorAmount);?></td>
            <td><?php echo number_format($paymentPart['DetailPayment']['payroll_amount'], 2, ",", $separatorAmount);?></td>
            <td><?php  switch($paymentPart['Payment']['payment_type']){
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

                } ?></td>
            <td><?php echo h($paymentPart['Payment']['wording']); ?></td>

        </tr>
    <?php } ?>

    </tbody>
</table>

