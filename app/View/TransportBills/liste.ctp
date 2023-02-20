<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
       width="100%">

    <tbody >
    <?php foreach ($transportBills as $transportBill): ?>
        <tr id="row<?= $transportBill['TransportBill']['id'] ?>">
            <td
                onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                <?php echo $transportBill['TransportBill']['type'] ?> )'
                >

                <input id="idCheck" type="checkbox" class='id'
                       value=<?php echo $transportBill['TransportBill']['id'] ?>>


            </td>

            <td
                onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                <?php echo $transportBill['TransportBill']['type'] ?> )'
                ><?php echo h($transportBill['TransportBill']['reference']); ?>&nbsp;</td>
            <td
                onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                <?php echo $transportBill['TransportBill']['type'] ?> )'

                ><?php echo h($this->Time->format($transportBill['TransportBill']['date'], '%d-%m-%Y')); ?>
                &nbsp;</td>
            <?php if ($profileId != ProfilesEnum::client) { ?>
                <td
                    onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                    <?php echo $transportBill['TransportBill']['type'] ?> )'

                    ><?php echo h($transportBill['Supplier']['name']); ?>&nbsp;</td>
            <?php } ?>

            <?php if ($profileId != ProfilesEnum::client) { ?>
                <td
                    onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                    <?php echo $transportBill['TransportBill']['type'] ?> )'

                    ><?php echo h($transportBill['Service']['name']); ?>&nbsp;</td>
            <?php } ?>
            <?php if (($type == TransportBillTypesEnum::quote_request)
            ) {
                ?>
                <td
                    onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                    <?php echo $transportBill['TransportBill']['type'] ?> )'
                    ><?php echo h($transportBill['SupplierFinal']['name']); ?>&nbsp;</td>
                <td
                    onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                    <?php echo $transportBill['TransportBill']['type'] ?> )'
                    ><?php echo h($transportBill['DepartureDestination']['name'] . '-' . $transportBill['ArrivalDestination']['name']); ?>
                    &nbsp;</td>
                <td
                    onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                    <?php echo $transportBill['TransportBill']['type'] ?> )'
                    ><?php echo h($transportBill['CarType']['name']); ?>&nbsp;</td>
                <td
                    onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                    <?php echo $transportBill['TransportBill']['type'] ?> )'
                    ><?php echo h($transportBill['transportBillDetailRides']['nb_trucks']); ?>
                    &nbsp;</td>
            <?php } else {

                if (($profileId != ProfilesEnum::client)) {

                    ?>
                    <td
                        onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                        <?php echo $transportBill['TransportBill']['type'] ?> )'
                        ><?php echo number_format($transportBill['TransportBill']['total_ht'], 2, ",", $separatorAmount) ; ?>
                        &nbsp;</td>
                    <td
                        onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                        <?php echo $transportBill['TransportBill']['type'] ?> )'
                        ><?php echo number_format($transportBill['TransportBill']['total_tva'], 2, ",", $separatorAmount) ; ?>
                        &nbsp;</td>
                    <td
                        onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                        <?php echo $transportBill['TransportBill']['type'] ?> )'
                        ><?php echo number_format($transportBill['TransportBill']['total_ttc'], 2, ",", $separatorAmount) ; ?>
                        &nbsp;</td>
                <?php } } ?>
            <?php

            if (($type == TransportBillTypesEnum::invoice) || ($type == TransportBillTypesEnum::quote_request) ||
                ($type == TransportBillTypesEnum::quote) || ($type == TransportBillTypesEnum::order) ||
                ($type == TransportBillTypesEnum::pre_invoice && $settleMissions == 1)
            ) {

                if (($type == TransportBillTypesEnum::invoice) ||
                    ($type == TransportBillTypesEnum::pre_invoice && $settleMissions == 1)
                ) {

                    ?>
                    <td
                        onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                        <?php echo $transportBill['TransportBill']['type'] ?> )'
                        >
                        <?php echo number_format(
                                $transportBill['TransportBill']['amount_remaining'], 2, ",", $separatorAmount
                            ) ; ?>&nbsp;</td>
                    <td  <?php if ($type == TransportBillTypesEnum::order && $profileId == ProfilesEnum::client) { ?>
                        onclick='viewDetailCustomerOrder(<?php echo $transportBill['TransportBill']['id'] ?>,
                        <?php echo $transportBill['TransportBill']['nb_trucks'] ?> )'
                    <?php } else { ?>
                        onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                        <?php echo $transportBill['TransportBill']['type'] ?> )'
                    <?php } ?>><?php switch ($transportBill['TransportBill']['status_payment']) {
                            case 1:
                                echo '<span class="label label-danger">';
                                echo __('Not paid') . "</span>";
                                break;
                            case 2:
                                echo '<span class="label label-success">';
                                echo __('Paid') . "</span>";
                                break;

                            case 3:
                                echo '<span class="label label-warning">';
                                echo __('Partially paid') . "</span>";
                                break;

                        } ?>&nbsp;</td>
                <?php
                } elseif ($type == TransportBillTypesEnum::quote_request || $type == TransportBillTypesEnum::quote) {
                    ?>

                    <td><?php switch ($transportBill['TransportBill']['status']) {
                            case 1:
                                echo '<span class="label label-danger">';
                                echo __('Not transformed') . "</span>";
                                break;
                            case 2:
                                echo '<span class="label label-success">';
                                echo __('Transformed') . "</span>";
                                break;

                        } ?>&nbsp;</td>

                <?php } else { ?>

                    <td
                        onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                        <?php echo $transportBill['TransportBill']['type'] ?> )'
                        >

                        <?php switch ($transportBill['TransportBill']['status']) {
                            /*
                            1: commandes non validée
                            2: commandes partiellement validees
                            3: commandes validees
                            */
                            case 1:
                                echo '<span class="label label-danger">';
                                echo __('Not validated') . "</span>";
                                break;
                            case 2:
                                echo '<span class="label label-warning">';
                                echo __('Partially validated') . "</span>";
                                break;
                            case 3:
                                echo '<span class="label label-success">';
                                echo __('Validated') . "</span>";
                                break;

                            case 8:
                                echo '<span class="label label-primary">';
                                echo __('Not transmitted') . "</span>";
                                break;

                            case 9:
                                echo '<span class="label label-inverse">';
                                echo __('Canceled') . "</span>";
                                break;

                        } ?>&nbsp;
                    </td>
                <?php
                }
            }
            ?>

            <?php if (($profileId != ProfilesEnum::client)) { ?>
                <td class="actions transport-bil-actions">
                    <div class="btn-group ">
                        <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                            <i class="fa fa-list fa-inverse"></i>
                        </a>
                        <button href="#" data-toggle="dropdown"
                                class="btn btn-info dropdown-toggle share">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" style="min-width: 70px;">
                            <?php switch ($type) {
                                case TransportBillTypesEnum::quote_request :
                                    ?>
                                    <li class='view-link' title='<?= __('View') ?>'>
                                        <?php
                                        echo $this->Html->link(
                                            '<i class="  fa fa-eye m-r-5"></i>',
                                            array('action' => 'View', $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-success')
                                        );
                                        ?>
                                    </li>
                                    <li class='edit-link' title='<?= __('Edit') ?>'>
                                        <?php  echo $this->Html->link(
                                            '<i class="fa fa-edit m-r-5"></i>',
                                            array('action' => 'editRequestQuotation', $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-primary')
                                        ); ?>
                                    </li>
                                    <li class='edit-link' title='<?= __('Dissociate') ?>'>
                                        <?php  echo $this->Html->link(
                                            '<i class="fa  fa-unlink m-r-5"></i>',

                                            array('action' => 'dissociate', $type,$transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-warning')
                                        ); ?>
                                    </li>
                                    <li class='delete-link' title='<?= __('Delete') ?>'>
                                        <?php   echo $this->Form->postLink(
                                            '<i class="fa fa-trash-o m-r-5"></i>',
                                            array('action' => 'Delete', $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-danger'),
                                            __('Are you sure you want to delete %s?', $transportBill['TransportBill']['reference'])); ?>
                                    </li>

                                    <?php    break;
                                case TransportBillTypesEnum::quote :
                                    ?>
                                    <li class='view-link' title='<?= __('View') ?>'>
                                        <?php  echo $this->Html->link(
                                            '<i class="fa fa-eye m-r-5"></i>',
                                            array('action' => 'View', $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-success')
                                        ); ?>
                                    </li>
                                    <?php if (($transportBill['TransportBill']['status'] != TransportBillDetailRideStatusesEnum:: validated)
                                ) {
                                    ?>
                                    <li class='edit-link' title='<?= __('Edit') ?>'>
                                        <?php  echo $this->Html->link(
                                            '<i class="fa fa-edit m-r-5"></i>',
                                            array('action' => 'Edit', $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-primary')
                                        ); ?>
                                    </li>
                                <?php } ?>
                                    <li class='edit-link' title='<?= __('Dissociate') ?>'>
                                        <?php  echo $this->Html->link(
                                            '<i class="fa  fa-unlink m-r-5"></i>',

                                            array('action' => 'dissociate', $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-warning')
                                        ); ?>
                                    </li>
                                    <li class='delete-link' title='<?= __('Delete') ?>'>
                                        <?php  echo $this->Form->postLink(
                                            '<i class="fa fa-trash-o m-r-5"></i>',
                                            array('action' => 'Delete', $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-danger'),
                                            __('Are you sure you want to delete %s?', $transportBill['TransportBill']['reference']));
                                        ?>
                                    </li>
                                    <li class='duplicate-link' title=<?= __('Duplicate') ?>>
                                        <?php echo $this->Html->link(
                                            '<i class="fa fa-copy m-r-5"></i>',
                                            array('action' => 'duplicate_relance', 3, $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-warning')
                                        ); ?>
                                    </li>
                                    <li class='revive-link' title=<?= __('Revive') ?>>
                                        <?php echo $this->Html->link(
                                            '<i class="fa fa-refresh m-r-5"></i>',
                                            array('action' => 'Send_mail', $type, $transportBill['TransportBill']['id'], 1),
                                            array('escape' => false, 'class' => 'btn btn-info')
                                        ); ?>
                                    </li>

                                    <li class='mail-link' title="<?= __('Send email') ?>">
                                        <?php echo $this->Html->link(
                                            '<i class="fa fa-envelope m-r-5"></i>',
                                            array('action' => 'Send_mail', $type, $transportBill['TransportBill']['id'], 0),
                                            array('escape' => false, 'class' => 'btn btn-purple'));
                                        ?>
                                    </li>
                                    <li class='parameter-mail-link' title="<?= __('Parameter mail') ?>">
                                        <?php
                                        $msg = 'Bonjour, ';
                                        if (!empty($transportBill['Supplier']['contact'])) {
                                            $msg = $msg . $transportBill['Supplier']['contact'];
                                        }
                                        $msg .= "%0D%0A";
                                        $msg .= 'Ci-joint votre devis numero ' . $transportBill['TransportBill']['reference'];

                                        if (!empty($transportBill['Supplier']['email'])) {
                                            $mail = $transportBill['Supplier']['email']; ?>
                                            <a class="btn btn-pink"
                                               href="mailto:<?php echo $mail ?> &body=<?php echo $msg; ?>"
                                               onclick='piece_pdf();'>
                                                <i class="fa  fa-envelope-o m-r-5"> </i>
                                            </a>
                                        <?php } else { ?>

                                            <a class="btn btn-pink "
                                               href="mailto: &body= <?php echo $msg; ?>"
                                               onclick='piece_pdf();'>
                                                <i class="fa  fa-envelope-o m-r-5"
                                                   title="Parametre mail"> </i>
                                            </a>
                                        <?php } ?>
                                    </li>

                                    <li class='edit-link' title="<?= __('Print simplified bill') ?>">
                                        <?php switch ($reportingChoosed) {
                                            case 1: ?>
                                                <?= $this->Html->link(
                                                    '<i class="fa fa-print"></i>',
                                                    array('action' => 'print_facture', 'ext' => 'pdf', $transportBill['TransportBill']['id'],$type),
                                                    array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-inverse')
                                                ); ?>

                                                <?php
                                                break;

                                            case 2: ?>

                                                <?php
                                                break;
                                            case 3:
                                                $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                                $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                                $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];

                                                $link = $reportsPathJasper.'/transport_bills.pdf?j_username='.$usernameJasper.'&j_password='.$passwordJasper.'&id='.$transportBill['TransportBill']['id'];

                                                ?>
                                                <a href="<?php echo $link ?>" target="_blank" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                                <?php    break;
                                                ?>
                                            <?php  }?>
                                    </li>
                                    <li class='edit-link' title="<?= __('Print detailed bill') ?>">
                                        <?php switch ($reportingChoosed) {
                                            case 1: ?>
                                                <?= $this->Html->link(
                                                    '<i class="fa fa-print"></i>',
                                                    array('action' => 'print_detailed_facture', 'ext' => 'pdf', $transportBill['TransportBill']['id'],$type),
                                                    array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-inverse')
                                                ); ?>

                                                <?php
                                                break;

                                            case 2: ?>

                                                <?php
                                                break;
                                            case 3:
                                                $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                                $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                                $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];

                                                $link = $reportsPathJasper.'/transport_bills.pdf?j_username='.$usernameJasper.'&j_password='.$passwordJasper.'&id='.$transportBill['TransportBill']['id'];

                                                ?>
                                                <a href="<?php echo $link ?>" target="_blank" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                                <?php    break;
                                                ?>
                                            <?php  }?>
                                    </li>


                                    <?php
                                    break;
                                case TransportBillTypesEnum::order :
                                    ?>
                                    <li class='view-link' title='<?= __('View') ?>'>
                                        <?php
                                        echo $this->Html->link(
                                            '<i class="  fa fa-eye m-r-5"></i>',
                                            array('action' => 'View', $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-success')); ?>
                                    </li>

                                    <li class='edit-link' title='<?= __('Edit') ?>'>
                                        <?php
                                        echo $this->Html->link(
                                            '<i class="  fa fa-edit m-r-5"></i>',
                                            array('action' => 'Edit', $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-primary')); ?>
                                    </li>
                                    <li class='edit-link' title='<?= __('Dissociate') ?>'>
                                        <?php  echo $this->Html->link(
                                            '<i class="fa  fa-unlink m-r-5"></i>',

                                            array('action' => 'dissociate', $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-warning')
                                        ); ?>
                                    </li>
                                    <li class='edit-link' title="<?= __('Print simplified bill') ?>">
                                        <?php switch ($reportingChoosed) {
                                            case 1: ?>
                                                <?= $this->Html->link(
                                                    '<i class="fa fa-print"></i>',
                                                    array('action' => 'print_facture', 'ext' => 'pdf', $transportBill['TransportBill']['id'],$type),
                                                    array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-inverse')
                                                ); ?>

                                                <?php
                                                break;

                                            case 2: ?>

                                                <?php
                                                break;
                                            case 3:
                                                $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                                $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                                $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];

                                                $link = $reportsPathJasper.'/transport_bills.pdf?j_username='.$usernameJasper.'&j_password='.$passwordJasper.'&id='.$transportBill['TransportBill']['id'];

                                                ?>
                                                <a href="<?php echo $link ?>" target="_blank" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                                <?php    break;
                                                ?>
                                            <?php  }?>
                                    </li>
                                    <li class='edit-link' title="<?= __('Print detailed bill') ?>">
                                        <?php switch ($reportingChoosed) {
                                            case 1: ?>
                                                <?= $this->Html->link(
                                                    '<i class="fa fa-print"></i>',
                                                    array('action' => 'print_detailed_facture', 'ext' => 'pdf', $transportBill['TransportBill']['id'],$type),
                                                    array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-inverse')
                                                ); ?>

                                                <?php
                                                break;

                                            case 2: ?>

                                                <?php
                                                break;
                                            case 3:
                                                $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                                $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                                $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];

                                                $link = $reportsPathJasper.'/transport_bills.pdf?j_username='.$usernameJasper.'&j_password='.$passwordJasper.'&id='.$transportBill['TransportBill']['id'];

                                                ?>
                                                <a href="<?php echo $link ?>" target="_blank" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                                <?php    break;
                                                ?>
                                            <?php  }?>
                                    </li>

                                    <li class='delete-link' title='<?= __('Delete') ?>'>
                                        <?php echo $this->Form->postLink(
                                            '<i class=" fa fa-trash-o m-r-5"></i>',
                                            array('action' => 'Delete', $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-danger'),
                                            __('Are you sure you want to delete %s?', $transportBill['TransportBill']['reference'])); ?>
                                    </li>
                                    <?php
                                    break;
                                case TransportBillTypesEnum::pre_invoice :
                                    ?>
                                    <li class='view-link' title='<?= __('View') ?>'>
                                        <?php
                                        echo $this->Html->link(
                                            '<i class="  fa fa-eye m-r-5"></i>',
                                            array('action' => 'view', $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-success')); ?>
                                    </li>

                                    <li class='edit-link' title='<?= __('Edit') ?>'>
                                        <?php
                                        echo $this->Html->link(
                                            '<i class="  fa fa-edit m-r-5"></i>',
                                            array('action' => 'edit', $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-primary')); ?>
                                    </li>
                                    <li class='edit-link' title='<?= __('Dissociate') ?>'>
                                        <?php  echo $this->Html->link(
                                            '<i class="fa  fa-unlink m-r-5"></i>',

                                            array('action' => 'dissociate', $type,$transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-warning')
                                        ); ?>
                                    </li>
                                    <li class='edit-link' title="<?= __('Print simplified bill') ?>">
                                        <?php switch ($reportingChoosed) {
                                            case 1: ?>
                                                <?= $this->Html->link(
                                                    '<i class="fa fa-print"></i>',
                                                    array('action' => 'print_facture', 'ext' => 'pdf', $transportBill['TransportBill']['id'],$type),
                                                    array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-inverse')
                                                ); ?>

                                                <?php
                                                break;

                                            case 2: ?>

                                                <?php
                                                break;
                                            case 3:
                                                $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                                $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                                $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];

                                                $link = $reportsPathJasper.'/transport_bills.pdf?j_username='.$usernameJasper.'&j_password='.$passwordJasper.'&id='.$transportBill['TransportBill']['id'];

                                                ?>
                                                <a href="<?php echo $link ?>" target="_blank" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                                <?php    break;
                                                ?>
                                            <?php  }?>
                                    </li>
                                    <li class='edit-link' title="<?= __('Print detailed bill') ?>">
                                        <?php switch ($reportingChoosed) {
                                            case 1: ?>
                                                <?= $this->Html->link(
                                                    '<i class="fa fa-print"></i>',
                                                    array('action' => 'print_detailed_facture', 'ext' => 'pdf', $transportBill['TransportBill']['id'],$type),
                                                    array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-inverse')
                                                ); ?>

                                                <?php
                                                break;

                                            case 2: ?>

                                                <?php
                                                break;
                                            case 3:
                                                $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                                $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                                $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];

                                                $link = $reportsPathJasper.'/transport_bills.pdf?j_username='.$usernameJasper.'&j_password='.$passwordJasper.'&id='.$transportBill['TransportBill']['id'];

                                                ?>
                                                <a href="<?php echo $link ?>" target="_blank" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                                <?php    break;
                                                ?>
                                            <?php  }?>
                                    </li>

                                    <li class='delete-link' title='<?= __('Delete') ?>'>
                                        <?php
                                        echo $this->Form->postLink(
                                            '<i class="fa fa-trash-o m-r-5"></i>',
                                            array('action' => 'Delete', $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-danger'),
                                            __('Are you sure you want to delete %s?', $transportBill['TransportBill']['reference'])); ?>
                                    </li>
                                    <?php
                                    break;
                                case TransportBillTypesEnum::invoice :
                                    ?>
                                    <li class='view-link' title='<?= __('View') ?>'>
                                        <?php
                                        echo $this->Html->link(
                                            '<i class="  fa fa-eye m-r-5"></i>',
                                            array('action' => 'view', $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-success')); ?>
                                    </li>
                                    <li class='edit-link' title='<?= __('Edit') ?>'>
                                        <?php
                                        echo $this->Html->link(
                                            '<i class="  fa fa-edit m-r-5"></i>',
                                            array('action' => 'edit', $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-primary')); ?>
                                    </li>

                                    <li class='edit-link' title="<?= __('Print simplified bill') ?>">
                                        <?php switch ($reportingChoosed) {
                                            case 1: ?>
                                                <?= $this->Html->link(
                                                    '<i class="fa fa-print"></i>',
                                                    array('action' => 'print_facture', 'ext' => 'pdf', $transportBill['TransportBill']['id'],$type),
                                                    array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-inverse')
                                                ); ?>

                                                <?php
                                                break;

                                            case 2: ?>

                                                <?php
                                                break;
                                            case 3:
                                                $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                                $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                                $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];

                                                $link = $reportsPathJasper.'/transport_bills.pdf?j_username='.$usernameJasper.'&j_password='.$passwordJasper.'&id='.$transportBill['TransportBill']['id'];

                                                ?>
                                                <a href="<?php echo $link ?>" target="_blank" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                                <?php    break;
                                                ?>
                                            <?php  }?>
                                    </li>
                                    <li class='edit-link' title="<?= __('Print detailed bill') ?>">
                                        <?php switch ($reportingChoosed) {
                                            case 1: ?>
                                                <?= $this->Html->link(
                                                    '<i class="fa fa-print"></i>',
                                                    array('action' => 'print_detailed_facture', 'ext' => 'pdf', $transportBill['TransportBill']['id'],$type),
                                                    array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-inverse')
                                                ); ?>

                                                <?php
                                                break;

                                            case 2: ?>

                                                <?php
                                                break;
                                            case 3:
                                                $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                                $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                                $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];

                                                $link = $reportsPathJasper.'/transport_bills.pdf?j_username='.$usernameJasper.'&j_password='.$passwordJasper.'&id='.$transportBill['TransportBill']['id'];

                                                ?>
                                                <a href="<?php echo $link ?>" target="_blank" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                                <?php    break;
                                                ?>
                                            <?php  }?>
                                    </li>

                                    <li class='delete-link' title='<?= __('Delete') ?>'>
                                        <?php
                                        echo $this->Form->postLink(
                                            '<i class="fa fa-trash-o m-r-5"></i>',
                                            array('action' => 'Delete', $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-danger'),
                                            __('Are you sure you want to delete %s?', $transportBill['TransportBill']['reference'])); ?>
                                    </li>
                                    <?php break;

                                    ?>

                                <?php
                            } ?>
                        </ul>
                    </div>
                </td>
            <?php
            } else {
                switch ($type) {
                    case TransportBillTypesEnum::quote_request:
                        ?>
                        <td class="actions transport-bil-actions">
                            <div class="btn-group ">
                                <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                                    <i class="fa fa-list fa-inverse"></i>
                                </a>
                                <button href="#" data-toggle="dropdown"
                                        class="btn btn-info dropdown-toggle share">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" style="min-width: 70px;">


                                    <li class='view-link' title='<?= __('View') ?>'>
                                        <?php
                                        echo $this->Html->link(
                                            '<i class="  fa fa-eye m-r-5"></i>',
                                            array('action' => 'View', $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-success')
                                        );
                                        ?>
                                    </li>

                                    <li class='edit-link' title='<?= __('Edit') ?>'>
                                        <?php  echo $this->Html->link(
                                            '<i class="fa fa-edit m-r-5"></i>',

                                            array('action' => 'editRequestQuotation', $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-primary')
                                        ); ?>
                                    </li>

                                    <li class='delete-link' title='<?= __('Delete') ?>'>
                                        <?php   echo $this->Form->postLink(
                                            '<i class="fa fa-trash-o m-r-5"></i>',
                                            array('action' => 'Delete', $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-danger'),
                                            __('Are you sure you want to delete %s?', $transportBill['TransportBill']['reference'])); ?>
                                    </li>


                                </ul>
                            </div>
                        </td>
                        <?php
                        break;
                    case TransportBillTypesEnum:: quote :
                        break;
                    case TransportBillTypesEnum::order:
                        ?>
                        <td class="actions transport-bil-actions">
                            <div class="btn-group ">
                                <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                                    <i class="fa fa-list fa-inverse"></i>
                                </a>
                                <button href="#" data-toggle="dropdown"
                                        class="btn btn-info dropdown-toggle share">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" style="min-width: 70px;">


                                    <li class='view-link' title='<?= __('View') ?>'>
                                        <?php
                                        echo $this->Html->link(
                                            '<i class="  fa fa-eye m-r-5"></i>',
                                            array('action' => 'View', $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-success')
                                        );
                                        ?>
                                    </li>
                                    <?php if ($transportBill['TransportBill']['status'] == TransportBillDetailRideStatusesEnum:: not_validated ||
                                        $transportBill['TransportBill']['status'] == TransportBillDetailRideStatusesEnum:: not_transmitted
                                    ) {
                                        ?>
                                        <li class='edit-link' title='<?= __('Edit') ?>'>
                                            <?php  echo $this->Html->link(
                                                '<i class="fa fa-edit m-r-5"></i>',

                                                array('action' => 'edit', $transportBill['TransportBill']['type'], $transportBill['TransportBill']['id']),
                                                array('escape' => false, 'class' => 'btn btn-primary')
                                            ); ?>
                                        </li>
                                    <?php } ?>

                                    <li class='delete-link' title='<?= __('Delete') ?>'>
                                        <?php   echo $this->Form->postLink(
                                            '<i class="fa fa-trash-o m-r-5"></i>',
                                            array('action' => 'Delete', $type, $transportBill['TransportBill']['id']),
                                            array('escape' => false, 'class' => 'btn btn-danger'),
                                            __('Are you sure you want to delete %s?', $transportBill['TransportBill']['reference'])); ?>
                                    </li>


                                </ul>
                            </div>
                        </td>
                        <?php        break;
                    case TransportBillTypesEnum::pre_invoice:
                        break;
                    case TransportBillTypesEnum::invoice :
                        break;
                }

                ?>

            <?php } ?>


        </tr>
    <?php endforeach; ?>
    </tbody>


</table>

<div id ='pageCount' class="hidden">
    <?php
    if ($this->params['paging']['TransportBill']['pageCount'] > 1) {
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