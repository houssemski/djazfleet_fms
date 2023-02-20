<?php ?>
<style>
    a {
        color: #333 !important;
    }
    </style>
<h4 class="page-title"> <?= __('Notifications'); ?></h4>
<div class="box-body">


    <?= $this->Form->input('controller', array(
        'id' => 'controller',
        'value' => $this->request->params['controller'],
        'type' => 'hidden'
    )); ?>

    <?= $this->Form->input('action', array(
        'id' => 'action',
        'value' => 'liste',
        'type' => 'hidden'
    )); ?>

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <?php

                if (!empty($notifications)) {
                foreach ($notifications as $notification) {

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


                ?>
                <li class="list-group-item"><!-- Task item -->

                    <?php
                        if(!empty($notification["TransportBill"]['id'])){
                            echo $this->Html->link("<div ></div> <div ><span class='name'>"
                                . $action . ' ' . $type . "</span>
                            <span class='desc'>" . $notification["Supplier"]['name'] . ' '
                                . $notification["TransportBill"]['reference'] . "</span><span ></span></div>"
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
                                echo $this->Html->link("<div ></div> <div class='user-desc'><span class='name'>"
                                    . $action . ' ' . $type . "</span>
                            <span class='desc'>" . $notification['EventType']['name'] . " - " . $notification['Car']['immatr_def'] . " - " . $notification['Carmodel']['name']. " - " . $notification['Parc']['name']
                                    . $notification["Bill"]['reference'] . "</span><span ></span></div>"
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
                                echo $this->Html->link("<div ></div> <div class='user-desc'><span class='name'>"
                                    . $action . ' ' . $type . "</span>
                            <span class='desc'>" . $notification["Supplier"]['name'] . ' '
                                    . $notification["Bill"]['reference'] . "</span><span ></span></div>"
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
                            echo $this->Html->link("<div ></div> <div class='user-desc'><span class='name'>"
                                . $action . ' ' . $type . "</span>
                            <span class='desc'>". $notification["EventType"]['name'].' ' . $notification["Car"]['immatr_def'] . ' '. $notification["Carmodel"]['name']. ' '. ' '.$this->Time->format($notification['Event']['date'], '%d/%m/%Y')
                                 . "</span><span ></span></div>"
                                ,
                                array(
                                    'controller' => 'Events',
                                    'action' => 'View',
                                    $notification["Event"]['id']
                                ),
                                array('escape' => false, 'class' => "user-list-item")
                            );
                        }



                }
                ?>

                </li><!-- end task item -->
                <?php
                } ?>

                  </div>
        </div>
    </div>
</div>


<?php $this->start('script'); ?>

<script type="text/javascript">     $(document).ready(function () {
    });


</script>
<?php $this->end(); ?>
