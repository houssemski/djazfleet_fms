<?php

?><h4 class="page-title"> <?=__('Statistics'); ?></h4>
 <!-- Main content -->
                <section class="content">

                    <div class="card-box p-b-10">

                    <div class="row">

                       <?php if($resultGestionCar) {?>
                        <div class="col-md-6">
                            <!-- AREA CHART -->
                            <div class="boxstat box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"><?=__('Cars management')?></h3>
                                </div>
                                <div class="box-body">

                                    <ul class="list-group m-b-0 user-list">
                                        <li class="list-group-item">

                                            <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-primary"></i></div><div class="user-desc"><span class="name">'
                                                . __('List of cars per parc and supplier').'</span></div>', array('action' => 'listcarparcsupplier'),

                                                array('escape' => false, 'class' => 'user-list-item')); ?>
                                        </li>

                                        <li class="list-group-item">

                                            <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-success"></i></div><div class="user-desc"><span class="name">'
                                                . __('Cars reservations').'</span></div>', array('action' => 'carsreservation'),
                                                array('escape' => false, 'class' => 'user-list-item')); ?>
                                        </li>



                                        <li class="list-group-item">
                                            <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-pink"></i></div><div class="user-desc"><span class="name">'
                                                . __('Assurance per car and per car').'</span></div>', array('action' => 'carinsurance'),
                                                array('escape' => false, 'class' => 'user-list-item')); ?>

                                        </li>

                                        <li class="list-group-item">
                                            <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-muted"></i></div><div class="user-desc"><span class="name">'
                                                . __('Monthly km per year and car').'</span></div>', array('action' => 'listKmByMonth'),
                                                array('escape' => false, 'class' => 'user-list-item')); ?>


                                        </li>

                                        <li class="list-group-item">
                                            <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-danger"></i></div><div class="user-desc"><span class="name">'
                                                . __('Monthly km per year and car (chart)').'</span></div>', array('action' => 'kmbymonth'),
                                                array('escape' => false, 'class' => 'user-list-item')); ?>


                                        </li>

                                        <li class="list-group-item">

                                            <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-primary"></i></div><div class="user-desc"><span class="name">'
                                                . __('Monthly cost per event').'</span></div>', array('action' => 'listcosteventbymonth'),
                                                array('escape' => false, 'class' => 'user-list-item')); ?>

                                        </li>

                                        <li class="list-group-item">

                                            <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-success"></i></div><div class="user-desc"><span class="name">'
                                                . __('The proportion of maintenance per vehicle').'</span></div>', array('action' => 'maintenance'),
                                                array('escape' => false, 'class' => 'user-list-item')); ?>

                                        </li>

                                        <li class="list-group-item">
                                            <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-pink"></i></div><div class="user-desc"><span class="name">'
                                                . __('Cost per car, customer and date').'</span></div>', array('action' => 'costbycar'),
                                                array('escape' => false, 'class' => 'user-list-item')); ?>

                                        </li>

                                        <li class="list-group-item">
                                            <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-muted"></i></div><div class="user-desc"><span class="name">'
                                                . __('Global cost per car and date').'</span></div>', array('action' => 'globalcostbycar'),
                                                array('escape' => false, 'class' => 'user-list-item')); ?>


                                        </li>

                                        <li class="list-group-item">
                                            <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-danger"></i></div><div class="user-desc"><span class="name">'
                                                . __('Conductor flot').'</span></div>', array('action' => 'customerflot'),
                                                array('escape' => false, 'class' => 'user-list-item')); ?>


                                        </li>
                                      <!--  <li class="list-group-item">

                                            <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-primary"></i></div><div class="user-desc"><span class="name">'
                                                . __('Bill by month').'</span></div>', array('action' => 'reservationByMonth'),

                                                array('escape' => false, 'class' => 'user-list-item')); ?>
                                        </li> -->

                                       <!-- <li class="list-group-item">

                                            <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-success"></i></div><div class="user-desc"><span class="name">'
                                                . __('Flotte Ald').'</span></div>', array('action' => 'flotteAld'),
                                                array('escape' => false, 'class' => 'user-list-item')); ?>
                                        </li> -->


                                    </ul>

</div>
                            </div><!-- /.box -->

                           

                        </div><!-- /.col (LEFT) -->
                       <?php } ?>


                        <?php if($resultGestionConsommaton==1) {?>

                        <div class="col-md-6">
                            <!-- LINE CHART -->
                            <div class="boxstat box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"><?=__('Consumptions management')?></h3>
                                </div>
                                <div class="box-body">
                                    <ul class="list-group m-b-0 user-list">
                                        <li class="list-group-item">

                                            <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-primary"></i></div><div class="user-desc"><span class="name">'
                                                . __('Monthly consumption per car').'</span></div>', array('action' => 'consumptionByMonth'),

                                                array('escape' => false, 'class' => 'user-list-item')); ?>
                                        </li>
                                        <li class="list-group-item">

                                            <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-success"></i></div><div class="user-desc"><span class="name">'
                                                . __('Weekly consumption per car').'</span></div>', array('action' => 'consumptionByWeek'),

                                                array('escape' => false, 'class' => 'user-list-item')); ?>
                                        </li>
                                        <li class="list-group-item">

                                            <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-pink"></i></div><div class="user-desc"><span class="name">'
                                                . __('Monthly consumption per parc ').'</span></div>', array('action' => 'nembercarsparc'),

                                                array('escape' => false, 'class' => 'user-list-item')); ?>
                                        </li>
                                        <?php
                                            //todo recreate the statistic in other way that doesn't contain so much loops tha causes the server to crash
                                        ?>
                                        <li class="list-group-item">

                                            <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-muted"></i></div><div class="user-desc"><span class="name">'
                                                . __('Consumptions details').'</span></div>', array('action' => 'consumptionsDetails'),

                                                array('escape' => false, 'class' => 'user-list-item')); ?>
                                        </li>
                                        <li class="list-group-item">

                                            <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-danger"></i></div><div class="user-desc"><span class="name">'
                                                . __('Consumption fuels per parc and date').'</span></div>', array('action' => 'consumptionfuelparc'),

                                                array('escape' => false, 'class' => 'user-list-item')); ?>
                                        </li>
                                        <li class="list-group-item">

                                            <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-primary"></i></div><div class="user-desc"><span class="name">'
                                                . __('Fuel stock card').'</span></div>', array('action' => 'stockFuellog'),

                                                array('escape' => false, 'class' => 'user-list-item')); ?>
                                        </li>
                                    </ul>

                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                             

                           

                        </div><!-- /.col (RIGHT) -->

                        <?php } ?>

                        <?php if($resultGestionCar==1) {?>

                        <div class="col-md-6">
                            <!-- LINE CHART -->
                            <div class="boxstat box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"><?=__('Intervention management')?></h3>
                                </div>
                                <div class="box-body">
                                    <ul class="list-group m-b-0 user-list">




                                        <li class="list-group-item">

                                            <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-primary"></i></div><div class="user-desc"><span class="name">'
                                                . __('Intervention details').'</span></div>', array('action' => 'productsByInterventions'),

                                                array('escape' => false, 'class' => 'user-list-item')); ?>
                                        </li>
                                        <li class="list-group-item">

                                            <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-primary"></i></div><div class="user-desc"><span class="name">'
                                                . __('Workshops details').'</span></div>', array('action' => 'carByWorkshops'),

                                                array('escape' => false, 'class' => 'user-list-item')); ?>
                                        </li>
                                    </ul>


                                </div><!-- /.box-body -->
                            </div><!-- /.box -->




                        </div><!-- /.col (RIGHT) -->

                        <?php } ?>


                        <?php
                         if(Configure::read("gestion_commercial") == '1') {
                             if ($resultGestionCommerciale == 1) { ?>
                                 <div class="col-md-6">
                                     <!-- AREA CHART -->
                                     <div class="boxstat box-primary">
                                         <div class="box-header">
                                             <h3 class="box-title"><?= __('Business management') ?></h3>
                                         </div>
                                         <div class="box-body">
                                             <ul class="list-group m-b-0 user-list">

                                                 <li class="list-group-item">

                                                     <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-success"></i></div><div class="user-desc"><span class="name">'
                                                         . __('Realized turnover per month') . '</span></div>', array('action' => 'realizedTurnoverByMonth'),

                                                         array('escape' => false, 'class' => 'user-list-item')); ?>
                                                 </li>
                                                 <li class="list-group-item">

                                                     <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-success"></i></div><div class="user-desc"><span class="name">'
                                                         . __('Preinvoiced turnover per month') . '</span></div>', array('action' => 'preinvoicedTurnoverByMonth'),

                                                         array('escape' => false, 'class' => 'user-list-item')); ?>
                                                 </li>
                                                 <li class="list-group-item">

                                                     <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-pink"></i></div><div class="user-desc"><span class="name">'
                                                         . __('Invoiced turnover per month') . '</span></div>', array('action' => 'invoicedTurnoverByMonth'),

                                                         array('escape' => false, 'class' => 'user-list-item')); ?>
                                                 </li>
                                                 <li class="list-group-item">

                                                     <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-pink"></i></div><div class="user-desc"><span class="name">'
                                                         . __('Reservations by supplier') . '</span></div>', array('action' => 'reservationsBySupplier'),
                                                         array('escape' => false, 'class' => 'user-list-item')); ?>
                                                 </li>
                                                 <li class="list-group-item">

                                                     <?= $this->Html->link(' <div class="avatar text-center"><i class="zmdi zmdi-circle text-pink"></i></div><div class="user-desc"><span class="name">'
                                                         . __('Creance by supplier') . '</span></div>', array('action' => 'debtByCustomer'),
                                                         array('escape' => false, 'class' => 'user-list-item')); ?>
                                                 </li>

                                             </ul>

                                         </div>
                                     </div><!-- /.box -->


                                 </div><!-- /.col (LEFT) -->
                             <?php }
                         }
                        ?>

                    </div><!-- /.row -->
                    </div>
                </section><!-- /.content -->

