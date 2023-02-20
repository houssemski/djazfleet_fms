<div class="side-bar right-bar">
    <a onclick="closeRightBar()" class="right-bar-toggle">
        <i class="zmdi zmdi-close-circle-o"></i>
    </a>
    <h4 class=""><?php echo __('Notifications') ?></h4>

    <div class="notification-list nicescroll">
        <ul class="list-group list-no-border user-list" id='notifications'>

            <?php
            $cpt = 0;
            $countNotification = count($notifications);
            if($countNotification<10){
                $max = $countNotification;
            }else {
                $max = 10;
            }
            if (!empty($notifications)) {
                for ($cpt = 0 ; $cpt <$max;  $cpt++) {
                    $notification = $notifications[$cpt];
                    if(!empty($notification["TransportBill"]['id'])){
                        switch ($notification["TransportBill"]['type']) {
                            case TransportBillTypesEnum::quote_request :
                                $type = __('Request quotation');
                                break;
                            case TransportBillTypesEnum::quote :
                                $type = __('Quotation');
                                break;
                            case TransportBillTypesEnum::order :
                                $type = __("Customer orders");
                                break;
                            case TransportBillTypesEnum::sheet_ride :
                                $type = __("Sheet ride");
                                break;
                            case TransportBillTypesEnum::pre_invoice :
                                $type = __("Preinvoices");
                                break;
                            case TransportBillTypesEnum::invoice :
                                $type = __("Invoices");
                                break;
                        }
                    }elseif(!empty($notification["Bill"]['type'])) {
                        switch ($notification["Bill"]['type']) {
                            case BillTypesEnum:: supplier_order:
                                $type = __('Supplier order');
                                break;
                            case BillTypesEnum:: receipt:
                                $type = __('Receipt');
                                break;
                            case BillTypesEnum:: return_supplier:
                                $type = __('Return supplier');
                                break;
                            case BillTypesEnum:: purchase_invoice:
                                $type = __('Purchase invoice');
                                break;
                            case BillTypesEnum:: credit_note:
                                $type = __('Credit note');
                                break;
                            case BillTypesEnum:: credit_note:
                                $type = __('Credit note');
                                break;
                            case BillTypesEnum:: delivery_order:
                                $type = __('Delivery order');
                                break;
                            case BillTypesEnum:: return_customer:
                                $type = __('Return customer');
                                break;
                            case BillTypesEnum:: entry_order:
                                $type = __('Entry order');
                                break;
                            case BillTypesEnum:: exit_order:
                                $type = __('Exit order');
                                break;
                            case BillTypesEnum:: renvoi_order:
                                $type = __('Renvoi order');
                                break;
                            case BillTypesEnum:: reintegration_order:
                                $type = __('Reintegration order');
                                break;
                            case BillTypesEnum:: quote:
                                $type = __('Quotation');
                                break;
                            case BillTypesEnum:: customer_order:
                                $type = __('Customer order');
                                break;
                            case BillTypesEnum:: sales_invoice:
                                $type = __('Invoice');
                                break;

                            case BillTypesEnum:: sale_credit_note:
                                $type = __('Sale credit note');
                                break;

                            case BillTypesEnum:: product_request:
                                $type = __('Product request');
                                break;
                            case BillTypesEnum::purchase_request :
                                $type = __('Purchase request');
                                break;


                        }
                    }elseif(!empty($notification["Event"]['id'])) {
                        $type =  __("Intervention request");
                    }else {
                        $type =  __("Complaint");
                    }

                    switch ($notification["Notification"]['action_id']) {
                        case ActionsEnum::add:
                            if(!empty($notification["Bill"]['type'])
                                || $notification["TransportBill"]['type']==TransportBillTypesEnum::quote){
                                $action = __('Nouveau');
                            }else {
                                $action = __('New');
                            }
                            break;
                        case ActionsEnum::edit :
                            $action = __('Modification');
                            break;
                        case ActionsEnum::cancel :
                            $action = __("Cancellation");
                            break;
                        case ActionsEnum::validate :
                            $action = __("Validation");
                            break;
                        case ActionsEnum::transmit :
                            $action = __("Transmission");
                            break;
                        case ActionsEnum::transform :
                            $action = __("Transformation");
                            break;
                        case ActionsEnum::transfer :
                            $action = __("Transfer");
                            break;

                        case ActionsEnum::made_event :
                            $action = __("Transfer");
                            break;
                    }
                    if ($cpt <= 10) {

                        ?>
                        <li class="list-group-item"><!-- Task item -->

                        <?php
                        if(!empty($notification["TransportBill"]['id'])){
                            echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>"
                                . $action . ' ' . $type . "</span>
                            <span class='desc'>" . $notification["Supplier"]['name'] . ' '
                                . $notification["TransportBill"]['reference'] . "</span><span class='time'></span></div>"
                                ,
                                array(
                                    'controller' => 'transportBills',
                                    'action' => 'View',
                                    $notification["TransportBill"]['type'],
                                    $notification["TransportBill"]['id']
                                ),
                                array('escape' => false, 'class' => "user-list-item")
                            );
                        }
                        elseif(!empty( $notification["Bill"]['id'])) {

                            if($notification["Bill"]['type'] == BillTypesEnum::exit_order && !empty($notification["Event"]['id'])){
                                echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>"
                                    . $action . ' ' . $type . "</span>
                            <span class='desc'>" . $notification['EventType']['name'] . " - " . $notification['Car']['immatr_def'] . " - " . $notification['Carmodel']['name']. " - " . $notification['Parc']['name']
                                    . $notification["Bill"]['reference'] . "</span><span class='time'></span></div>"
                                    ,
                                    array(
                                        'controller' => 'Bills',
                                        'action' => 'View',
                                        $notification["Bill"]['type'],
                                        $notification["Bill"]['id']
                                    ),
                                    array('escape' => false, 'class' => "user-list-item")
                                );

                            }else {
                                echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>"
                                    . $action . ' ' . $type . "</span>
                            <span class='desc'>" . $notification["Supplier"]['name'] . ' '
                                    . $notification["Bill"]['reference'] . "</span><span class='time'></span></div>"
                                    ,
                                    array(
                                        'controller' => 'Bills',
                                        'action' => 'View',
                                        $notification["Bill"]['type'],
                                        $notification["Bill"]['id']
                                    ),
                                    array('escape' => false, 'class' => "user-list-item")
                                );
                            }

                        }elseif(!empty($notification["Event"]['id'])){
                            echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>"
                                . $action . ' ' . $type . "</span>
                            <span class='desc'>". $notification["EventType"]['name'].' ' . $notification["Car"]['immatr_def'] . ' '. $notification["Carmodel"]['name']. ' '.$this->Time->format($notification['Event']['date'], '%d/%m/%Y')
                                . "</span><span class='time'></span></div>"
                                ,
                                array(
                                    'controller' => 'Events',
                                    'action' => 'View',
                                    $notification["Event"]['id']
                                ),
                                array('escape' => false, 'class' => "user-list-item")
                            );
                        }

                        $cpt++;
                    }
                }
                ?>

                </li><!-- end task item -->
                <?php
            }
            ?>
            <li class="list-group-item">
                <?= $this->Html->Link(__('View all notifications'), array(
                    'controller' => 'notifications',
                    'action' => 'index'
                )); ?>


            </li>

        </ul>

    </div>


</div>

