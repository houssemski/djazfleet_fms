
<div class="box-body main">
    <?php

    ?><h4 class="page-title"> <?=__("Payment") . " " . $payment['Payment']['wording']; ?></h4>


    <div class="left_side card-box p-b-0">

        <div class="nav-tabs-custom pdg_btm">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>



            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                        <!-- BASIC WIZARD -->
                        <dt><?php echo __("Wording"); ?></dt>
                        <dd>
                            <?php

                            echo $payment['Payment']['wording'];

                            ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt><?php echo __("Receipt date"); ?></dt>
                        <dd>
                            <?php

                            echo h($this->Time->format($payment['Payment']['receipt_date'], '%d-%m-%Y'));

                            ?>
                            &nbsp;
                        </dd>
                        <br/>
						<dt><?php echo __("Operation date"); ?></dt>
                        <dd>
                            <?php

                            echo h($this->Time->format($payment['Payment']['operation_date'], '%d-%m-%Y'));

                            ?>
                            &nbsp;
                        </dd>
                        <br/>
						<dt><?php echo __("Value date"); ?></dt>
                        <dd>
                            <?php
                            echo h($this->Time->format($payment['Payment']['value_date'], '%d-%m-%Y'));
                            ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt><?php echo __("Payment type"); ?></dt>
                        <dd>
                            <?php
							switch ($payment['Payment']['payment_type']) {						
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

                                } ?>

                        </dd>
                        <br/>
                        <dt><?php echo __('Tiers'); ?></dt>
                        <dd>
                            <?php
                            switch ($payment['PaymentAssociation']['id']) {
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
                            ?>
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
                       <?php  switch ($payment['PaymentAssociation']['id']){
                           case PaymentAssociationsEnum::mission_order :      ?>
                               <div class="col-lg-12">
                                   <div class="card-box p-b-0">
								   <?php
                                               if(!empty($detailPayments)){ ?> 
                                       <table  class="table table-striped table-bordered dt-responsive nowrap"  cellspacing="0" width="80%">
                                           <thead>
                                           <tr>
                                               <th><?php echo $this->Paginator->sort('SheetRideDetailRides.reference', __('Reference')); ?></th>
                                               <th><?php echo $this->Paginator->sort('SheetRideDetailRides.mission_cost', __('Mission cost')); ?></th>
                                               <th><?php echo $this->Paginator->sort('DetailPayment.payroll_amount', __('Payroll amount')); ?></th>

                                           </tr>
                                           </thead>
                                           <tbody>
                                           <tr>
                                               <?php
                                               foreach ($detailPayments as $detailPayment) {?>
                                           <tr>
                                               <td><?php echo $detailPayment['SheetRideDetailRides']['reference']?></td>
                                               <td><?php echo number_format($detailPayment['SheetRideDetailRides']['mission_cost'], 2, ",", ".")?></td>
                                               <td><?php echo number_format($detailPayment['DetailPayment']['payroll_amount'], 2, ",", ".")?></td>


                                           </tr>
                                           <?php } ?>
                                           </tbody>
                                       </table>
								<?php } ?>
                                   </div>
                               </div>

                           <?php
                               break;
                           case PaymentAssociationsEnum::invoice :  ?>
                               <div class="col-lg-12">
                                   <div class="card-box p-b-0">
								   
                                               <?php
                                        if(!empty($detailPayments)){ ?>
                                       <table  class="table table-striped table-bordered dt-responsive nowrap"  cellspacing="0" width="80%">
                                           <thead>
                                           <tr>

                                               <th><?php echo $this->Paginator->sort('TransportBill.reference', __('Reference')); ?></th>
                                               <th><?php echo $this->Paginator->sort('TransportBill.total_ttc', __('Total TTC')); ?></th>
                                               <th><?php echo $this->Paginator->sort('DetailPayment.payroll_amount', __('Payroll amount')); ?></th>


                                           </tr>
                                           </thead>
                                           <tbody>
                                           <tr>

                                               <?php
                                               foreach ($detailPayments as $detailPayment) {?>
                                           <tr>

                                               <td><?php echo $detailPayment['TransportBill']['reference']?></td>


                                               <td><?php echo number_format($detailPayment['TransportBill']['total_ttc'], 2, ",", ".")?></td>
                                               <td><?php echo number_format($detailPayment['DetailPayment']['payroll_amount'], 2, ",", ".")?></td>


                                           </tr>
                                           <?php } ?>
                                           </tbody>
                                       </table>
									<?php } ?>
                                   </div>
                               </div>
                            <?php
                                break;
                           case PaymentAssociationsEnum::offshore : ?>
                               <div class="col-lg-12">
                                   <div class="card-box p-b-0">
								   <?php
                                               if(!empty($detailPayments)){ ?>
                                       <table  class="table table-striped table-bordered dt-responsive nowrap"  cellspacing="0" width="80%">
                                           <thead>
                                           <tr>

                                               <th><?php echo $this->Paginator->sort('SheetRideDetailRides.reference', __('Reference')); ?></th>
                                               <th><?php echo $this->Paginator->sort('Reservation.cost', __('Cost')); ?></th>
                                               <th><?php echo $this->Paginator->sort('DetailPayment.payroll_amount', __('Payroll amount')); ?></th>


                                           </tr>
                                           </thead>
                                           <tbody>
                                           <tr>

                                               <?php
                                               foreach ($detailPayments as $detailPayment) {?>
                                           <tr>

                                               <td><?php echo $detailPayment['SheetRideDetailRides']['reference']?></td>


                                               <td><?php echo number_format($detailPayment['Reservation']['cost'], 2, ",", ".")?></td>
                                               <td><?php echo number_format($detailPayment['DetailPayment']['payroll_amount'], 2, ",", ".")?></td>


                                           </tr>
                                           <?php } ?>
                                           </tbody>
                                       </table>
									<?php } ?>
                                   </div>
                               </div>
                              <?php
                               break;
                           case PaymentAssociationsEnum::preinvoice :  ?>
                            <div class="col-lg-12">
                                   <div class="card-box p-b-0">
								   <?php
                            if(!empty($detailPayments)){ ?>
                                       <table  class="table table-striped table-bordered dt-responsive nowrap"  cellspacing="0" width="80%">
                                           <thead>
                                           <tr>

                        <th><?php echo $this->Paginator->sort('TransportBill.reference', __('Reference')); ?></th>
                        <th><?php echo $this->Paginator->sort('TransportBill.total_ttc', __('Total TTC')); ?></th>
                        <th><?php echo $this->Paginator->sort('DetailPayment.payroll_amount', __('Payroll amount')); ?></th>


                        </tr>
                        </thead>
                        <tbody>
                        <tr>

                            <?php
                            foreach ($detailPayments as $detailPayment) {?>
                        <tr>

                            <td><?php echo $detailPayment['TransportBill']['reference']?></td>


                            <td><?php echo number_format($detailPayment['TransportBill']['total_ttc'], 2, ",", ".")?></td>
                            <td><?php echo number_format($detailPayment['DetailPayment']['payroll_amount'], 2, ",", ".")?></td>


                        </tr>
                        <?php } ?>
                        </tbody>
                        </table>
					<?php } ?>
                    </div>
                </div>
                             <?php
                                break;
								
								  case PaymentAssociationsEnum::bill :  ?>
                               <div class="col-lg-12">
                                   <div class="card-box p-b-0">
								      <?php
                                               if(!empty($detailPayments)){ ?>
                                       <table  class="table table-striped table-bordered dt-responsive nowrap"  cellspacing="0" width="80%">
                                           <thead>
                                           <tr>

                                               <th><?php echo $this->Paginator->sort('Bill.reference', __('Reference')); ?></th>
                                               <th><?php echo $this->Paginator->sort('Bill.total_ttc', __('Total TTC')); ?></th>
                                               <th><?php echo $this->Paginator->sort('DetailPayment.payroll_amount', __('Payroll amount')); ?></th>


                                           </tr>
                                           </thead>
                                           <tbody>
                                           <tr>

                                               <?php
                                               foreach ($detailPayments as $detailPayment) {?>
                                           <tr>

                                               <td><?php echo $detailPayment['Bill']['reference']?></td>


                                               <td><?php echo number_format($detailPayment['Bill']['total_ttc'], 2, ",", ".")?></td>
                                               <td><?php echo number_format($detailPayment['DetailPayment']['payroll_amount'], 2, ",", ".")?></td>


                                           </tr>
                                           <?php } ?>
                                           </tbody>
                                       </table>
										<?php } ?>
                                   </div>
                               </div>
                            <?php
                                break;

                       }

                       ?>

                    </div>

                </div>



            </div>

        </div>

    </div>

</div>
<div style='clear:both; padding-top: 10px;'></div>
