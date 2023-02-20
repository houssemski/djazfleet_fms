
<div class="box-body main">
    <?php

        ?><h4 class="page-title"> <?=__("Payment") . " " . $payment['Payment']['reference']; ?></h4>


    <div class="left_side card-box p-b-0">

        <div class="nav-tabs-custom pdg_btm">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>



            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                        <!-- BASIC WIZARD -->
                        <dt><?php echo __("Reference"); ?></dt>
                        <dd>
                            <?php

                                echo $payment['Payment']['reference'];

                            ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt><?php echo __("Payment date"); ?></dt>
                        <dd>
                            <?php

                            echo h($this->Time->format($payment['Payment']['receipt_date'], '%d-%m-%Y'));

                            ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt><?php echo __("Payment type"); ?></dt>
                        <dd>
                            <?php

                            switch($payment['Payment']['payment_type']) {
                                case 1:
                                    echo __('Species');
                                    break;
                                case 2:
                                    echo __('Transfer');
                                    break;
                                case 3:
                                    echo __('Bank check');
                                    break;
                            } ?>


                            &nbsp;
                        </dd>
                        <br/>
                        <dt><?php echo __("Amount"); ?></dt>
                        <dd>
                            <?php

                                echo number_format($payment['Payment']['amount'], 2, ",", ".");

                            ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt><?php echo __("Compte"); ?></dt>
                        <dd>
                            <?php

                            echo $payment['Compte']['num_compte'];

                            ?>
                            &nbsp;
                        </dd>
                        <br/>

                        <br/>
                        <div class="col-lg-12">
                            <div class="card-box p-b-0">
                                <table  class="table table-striped table-bordered dt-responsive nowrap"  cellspacing="0" width="80%">
                                    <thead>
                                    <tr>

                                        <th><?php echo $this->Paginator->sort('SheetRideDetailRides.reference', __('Reference')); ?></th>
                                        <th><?php echo $this->Paginator->sort('SheetRideDetailRides.detail_ride_id', __('Mission')); ?></th>
                                        <th><?php echo $this->Paginator->sort('SheetRide.customer_id', __('Conductor')); ?></th>
                                        <th><?php echo $this->Paginator->sort('SheetRideDetailRides.mission_cost', __('Mission cost')); ?></th>
                                        <th><?php echo $this->Paginator->sort('MissionCostPayment.payroll_amount', __('Payroll amount')); ?></th>


                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>

                                        <?php
                                        if(!empty($detailPayments)){
                                        foreach ($detailPayments as $detailPayment) {?>
                                    <tr>

                                        <td><?php echo $detailPayment['SheetRideDetailRides']['reference']?></td>
                                        <td><?php echo  $detailPayment['DepartureDestination']['name'].'-'.$detailPayment['ArrivalDestination']['name'].'-'.$detailPayment['CarType']['name'];?></td>
                                        &nbsp;</td>
                                        <td><?php echo  $detailPayment['Customer']['first_name'] . " " . $detailPayment['Customer']['last_name']?>
                                        </td>
                                        <td><?php echo number_format($detailPayment['SheetRideDetailRides']['mission_cost'], 2, ",", ".")?></td>
                                        <td><?php echo number_format($detailPayment['DetailPaymentMissionCost']['payroll_amount'], 2, ",", ".")?></td>


                                    </tr>
                                    <?php } }?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                </div>



            </div>

        </div>

    </div>

</div>
<div style='clear:both; padding-top: 10px;'></div>
