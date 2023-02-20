<h4 class="page-title"> <?=__('Affectation').' '.$fuelCardAffectation['FuelCardAffectation']['reference'] ;?></h4>

<div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
        <div class="card-box ">
            <dl class="card-box">
                <dt><?php echo __('Reference'); ?></dt>
                <dd>
                    <?php echo h($fuelCardAffectation['FuelCardAffectation']['reference']); ?>
                    &nbsp;
                </dd>
                <dt><?php echo __('Fuel card'); ?></dt>
                <dd>
                    <?php echo h($fuelCardAffectation['FuelCard']['reference']); ?>
                    &nbsp;
                </dd>
                <dt><?php echo __('Cars'); ?></dt>
                <dd>
                    <?php
                    echo '<br>';
                    foreach ($carsSelected as  $carSelected){
                        if ($param == 1) {
                           echo  $carSelected['Car']['code'] . " - " . $carSelected['Carmodel']['name'];
                        } else if ($param == 2) {
                           echo  $carSelected['Car']['immatr_def'] . " - " . $carSelected['Carmodel']['name'];
                        }
                        echo '<br>';
                    }
                     ?>

                </dd>
                <dt><?php echo __('Start date'); ?></dt>
                <dd>
                    <?php echo h($this->Time->format($fuelCardAffectation['FuelCardAffectation']['start_date'], '%d-%m-%Y')); ?>
                    &nbsp;
                </dd>
                <dt><?php echo __('End date'); ?></dt>
                <dd>
                    <?php echo h($this->Time->format($fuelCardAffectation['FuelCardAffectation']['end_date'], '%d-%m-%Y')); ?>
                    &nbsp;
                </dd>
            </dl>


        </div>
    </div>
</div>


