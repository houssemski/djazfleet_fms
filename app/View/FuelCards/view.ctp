<h4 class="page-title"> <?=__('Fuel card').' '.$fuelCard['FuelCard']['reference'] ;?></h4>

<div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
        <div class="card-box ">
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"                            cellspacing="0" width="100%">
                <thead>
                <tr>

                    <th><?php echo $this->Paginator->sort('amount', __('Amount')); ?></th>

                    <th><?php echo $this->Paginator->sort('date_mouvement', __('Date')); ?></th>
                    <th><?php echo $this->Paginator->sort('transact_type_id', __('Type')); ?></th>
                    <th><?php echo $this->Paginator->sort('car', __('Car')); ?></th>

                </tr>
                </thead>
                <tbody>
                <?php  foreach ($fuelCardMouvements as $fuelCardMouvement):

                    ?>
                    <tr id="row<?= $fuelCardMouvement['FuelCardMouvement']['id'] ?>">

                        <td><?php echo h($fuelCardMouvement['FuelCardMouvement']['amount']); ?>&nbsp;</td>




                        <td><?php echo h($this->Time->format($fuelCardMouvement['FuelCardMouvement']['date_mouvement'], '%d-%m-%Y ')); ?>&nbsp;</td>
                        <td><?php if($fuelCardMouvement['FuelCardMouvement']['transact_type_id']==1)echo __('Encaissement'); else echo __('Décaissement'); ?>&nbsp;</td>
                        <td> <?php if ($param==1){
                                echo $fuelCardMouvement['Car']['code']." - ".$fuelCardMouvement['Carmodel']['name'];
                            } else if ($param==2) {
                                echo $fuelCardMouvement['Car']['immatr_def']." - ".$fuelCardMouvement['Carmodel']['name'];
                            } ?>

                        </td>

                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>


