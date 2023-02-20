<div class="side-bar right-bar">
    <a onclick="closeRightBar()" class="right-bar-toggle">
        <i class="zmdi zmdi-close-circle-o"></i>
    </a>
    <h4 class=""><?php echo __('Notifications') ?></h4>

    <div class="notification-list nicescroll">
        <ul class="list-group list-no-border user-list" id='notifications'>

            <?php

            $cpt = 0;
            if (!empty($notifications)) {


                foreach ($notifications as $notification) {

                        $type =  __("Complaint");




                    switch ($notification["Notification"]['action_id']) {
                        case ActionsEnum::add:
                                $action = __('New');

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
                    }
                    if ($cpt <= 10) {

                        ?>
                        <li class="list-group-item"><!-- Task item -->

                        <?php

                            if(!empty($notification["SheetRideDetailRides"]['id'])){
                                echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>"
                                    . $action . ' ' . $type . "</span>
                                <span class='desc'>" .__("Mission") . ' '
                                    . $notification["SheetRideDetailRides"]['reference'] . "</span><span class='time'></span></div>"
                                    ,
                                    array(
                                        'controller' => 'Complaints',
                                        'action' => 'view',
                                        $notification["Complaint"]['id']
                                    ),
                                    array('escape' => false, 'class' => "user-list-item")
                                );
                            }else {
                                echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>"
                                    . $action . ' ' . $type . "</span>
                                <span class='desc'>" .__("Order") . ' '
                                    . $notification["TransportBillDetailRides"]['reference'] . "</span><span class='time'></span></div>"
                                    ,
                                    array(
                                        'controller' => 'Complaints',
                                        'action' => 'view',
                                        $notification["Complaint"]['id']
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
                    'controller' => 'events',
                    'action' => 'alerts'
                )); ?>


            </li>

        </ul>

    </div>


</div>

