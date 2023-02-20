
<div class="box-body main">
    <?php
    if (!empty($detailPaymentMissionCosts)){
    ?><h4 class="page-title"> <?=__("Mission") . " " . $detailPaymentMissionCosts[0]['SheetRideDetailRides']['reference']; ?></h4>
    <?php }else {?>
        <h4 class="page-title"> <?=__("Mission") ?></h4>
    <?php } ?>

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
                            if(!empty($detailPaymentMissionCosts)) {
                            echo $detailPaymentMissionCosts[0]['SheetRideDetailRides']['reference'];
                            }
                            ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt><?php echo __("Mission cost"); ?></dt>
                        <dd>
                            <?php
                            if(!empty($detailPaymentMissionCosts)) {
                                echo number_format($detailPaymentMissionCosts[0]['SheetRideDetailRides']['mission_cost'], 2, ",", ".");
                            }
                            ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt><?php echo __("Amount remaining"); ?></dt>
                        <dd>
                            <?php
                            if(!empty($detailPaymentMissionCosts)) {
                                echo number_format($detailPaymentMissionCosts[0]['SheetRideDetailRides']['amount_remaining'], 2, ",", ".");
                            }
                            ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <div class="col-lg-12">
                            <div class="card-box p-b-0">
                                <table  class="table table-striped table-bordered dt-responsive nowrap"                            cellspacing="0" width="80%">
                                    <thead>
                                    <tr>

                                        <th><?php echo $this->Paginator->sort('MissionCostPayment.reference', __('Reference')); ?></th>
                                        <th><?php echo $this->Paginator->sort('MissionCostPayment.receipt_date', __('Payment date')); ?></th>
                                        <th><?php echo $this->Paginator->sort('MissionCostPayment.payment_type', __('Payment type')); ?></th>
                                        <th><?php echo $this->Paginator->sort('MissionCostPayment.payroll_amount', __('Payroll amount')); ?></th>


                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>

                                        <?php
                                        if(!empty($detailPaymentMissionCosts)){
                                        foreach ($detailPaymentMissionCosts as $detailPaymentMissionCost) {?>
                                    <tr>

                                        <td><?php echo $detailPaymentMissionCost['MissionCostPayment']['reference']?></td>
                                        <td><?php echo h($this->Time->format($detailPaymentMissionCost['MissionCostPayment']['receipt_date'], '%d-%m-%Y %H:%M')); ?>&nbsp;</td>
                                        <td><?php

                                                switch($detailPaymentMissionCost['MissionCostPayment']['payment_type']) {
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
                                            </td>
                                        <td><?php echo number_format($detailPaymentMissionCost['DetailPaymentMissionCost']['payroll_amount'], 2, ",", ".")?></td>



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
