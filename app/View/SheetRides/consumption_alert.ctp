<?php

?><h4 class="page-title"> <?=__('Consumption'); ?></h4>
<div class="box-body">

   

    
 <?php echo $this->Form->create('SheetRides', array('action' => 'search', 'novalidate' => true)); ?>
    <div class="filters" id='filters' style='display: block;'>
        <?php
        echo $this->Form->input('car_id', array(
            'label' => __('Car'),
            'class' => 'form-filter select2',
            'empty' => ''
        ));
        echo $this->Form->input('customer_id', array(
            'label' => __("Conductor"),
            'class' => 'form-filter select2',
            'empty' => ''
        ));
        echo "<div style='clear:both; padding-top: 10px;'></div>";
        echo $this->Form->input('date_departure', array(
            'label' => '',
            'type' => 'text',
            'class' => 'form-control datemask',
            'before' => '<label class="dte">' . __('Departure date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
            'after' => '</div>',
            'id' => 'startdate',
        ));
        echo $this->Form->input('date_arrival', array(
            'label' => '',
            'type' => 'text',
            'class' => 'form-control datemask',
            'before' => '<label class="dte">' . __('Arrival date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
            'after' => '</div>',
            'id' => 'enddate',
        ));

        if ($hasParc) {
            echo "<div style='clear:both; padding-top: 10px;'></div>";
            echo $this->Form->input('parc_id', array(
                        'label' => __('Parc'),
                        'class' => 'form-filter select2',
                        'id' => 'parc',
                        'empty' => ''
                    ));

        }
          echo "<div style='clear:both; padding-top: 40px;'></div>";

        echo '<div class="lbl"> <a href="#demo" data-toggle="collapse">'.__("  Administration").'</a></div>';

        ?>
          

<div id="demo" class="collapse">
 <div style="clear:both; padding-top: 0px;padding-left: 20px;  border-bottom: 1px solid rgb(204, 204, 204);margin-bottom: 15px;"></div>

        <?php

        echo $this->Form->input('user_id', array(
            'label' => __('Created by'),
            'class' => 'form-filter select2',
            'empty' => ''
        ));


        echo $this->Form->input('created', array(
            'label' => '',
            'type' => 'text',
            'class' => 'form-control datemask',
            'before' => '<label class="dte">' . __('From date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
            'after' => '</div>',
            'id' => 'startdatecreat',
        ));
        echo $this->Form->input('created1', array(
            'label' => '',
            'type' => 'text',
            'class' => 'form-control datemask',
            'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
            'after' => '</div>',
            'id' => 'enddatecreat',
        ));
        echo "<div style='clear:both; padding-top: 10px;'></div>";
        echo $this->Form->input('modified_id', array(
            'options' => $users,
            'label' => __('Modified by'),
            'class' => 'form-filter select2',
            'empty' => ''
        ));

        echo $this->Form->input('modified', array(
            'label' => '',
            'type' => 'text',
            'class' => 'form-control datemask',
            'before' => '<label class="dte">' . __('From date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
            'after' => '</div>',
            'id' => 'startdatemodifie',
        ));
        echo $this->Form->input('modified1', array(
            'label' => '',
            'type' => 'text',
            'class' => 'form-control datemask',
            'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
            'after' => '</div>',
            'id' => 'enddatemodifie',
        ));
        ?>
        <div style='clear:both; padding-top: 10px;'></div>
        </div>
        <button class="btn btn-default" type="submit"><?= __('Search') ?></button>
        <div style='clear:both; padding-top: 10px;'></div>
    </div>
    <?php echo $this->Form->end(); ?>

    <div class="row" style="clear:both">




<?php   if($consumptions != null){ ?>
        <div class="row">
            <!-- BASIC WIZARD -->
            <div class="col-lg-12">
                <div class="card-box p-b-0">
    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
           cellspacing="0" width="100%">
	<thead>
 
	<tr>
            
            <th><?php echo  __('Car'); ?></th>
            <th><?php echo  __('Month'); ?></th>
			<th><?php echo  __('Km travled'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
			
	</tr>
	</thead>
	<tbody>
	

<?php foreach ($consumptions as $consumption): ?>
	<tr id="row<?= $consumption['SheetRide']['car_id'] ?>">
         
        <td><?php echo  $consumption['Car']['code']." - ".$consumption['Carmodel']['name']; ?>&nbsp;</td>
          
                      <?php          switch ($consumption[0]['Month']) {
                                    case 1 :
                                        $label = __("January");
                                        break;
                                    case 2 :
                                        $label = __("February");
                                        break;
                                    case 3 :
                                        $label = __("March");
                                        break;
                                    case 4 :
                                        $label = __("April");
                                        break;
                                    case 5 :
                                        $label = __("May");
                                        break;
                                    case 6 :
                                        $label = __("June");
                                        break;
                                    case 7 :
                                        $label = __("July");
                                        break;
                                    case 8 :
                                        $label = __("August");
                                        break;
                                    case 9 :
                                        $label = __("September");
                                        break;
                                    case 10 :
                                        $label = __("October");
                                        break;
                                    case 11 :
                                        $label = __("November");
                                        break;
                                    case 12 :
                                        $label = __("December");
                                        break;
                                } ?>
        <td><?php $label; ?>&nbsp;</td>
        <td><?php echo $consumption[0]['diffKm']; ?>&nbsp;</td>
		

            </tr>
<?php endforeach; ?>

        </tbody>
    </table>
                    </div>
                    </div>
                    </div>
<?php }?>

<?php   if($consumptioncoupons != null){ ?>
        <div class="row">
            <!-- BASIC WIZARD -->
            <div class="col-lg-12">
                <div class="card-box p-b-0">
    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
           cellspacing="0" width="100%">
	<thead>
 
	<tr>
            
            <th><?php echo  __('Car'); ?></th>
            <th><?php echo  __('Month'); ?></th>
            <th><?php echo  __('Monthly consumption of coupons'); ?></th>
			<th><?php echo  __('NB coupons consummed'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
			
	</tr>
	</thead>
	<tbody>
	

<?php foreach ($consumptioncoupons as $consumption): ?>
	<tr id="row<?= $consumption['SheetRide']['car_id'] ?>">
         
        <td><?php echo  $consumption['Car']['code']." - ".$consumption['Carmodel']['name']; ?>&nbsp;</td>
         <?php          switch ($consumption[0]['Month']) {
                                    case 1 :
                                        $label = __("January");
                                        break;
                                    case 2 :
                                        $label = __("February");
                                        break;
                                    case 3 :
                                        $label = __("March");
                                        break;
                                    case 4 :
                                        $label = __("April");
                                        break;
                                    case 5 :
                                        $label = __("May");
                                        break;
                                    case 6 :
                                        $label = __("June");
                                        break;
                                    case 7 :
                                        $label = __("July");
                                        break;
                                    case 8 :
                                        $label = __("August");
                                        break;
                                    case 9 :
                                        $label = __("September");
                                        break;
                                    case 10 :
                                        $label = __("October");
                                        break;
                                    case 11 :
                                        $label = __("November");
                                        break;
                                    case 12 :
                                        $label = __("December");
                                        break;
                                } ?>
        <td><?php echo $label; ?>&nbsp;</td>
        <td><?php echo $consumption['Car']['coupon_consumption']; ?>&nbsp;</td>
        <td><?php echo $consumption[0]['nb_coupons']; ?>&nbsp;</td>
		

            </tr>
<?php endforeach; ?>

        </tbody>
    </table>
                    </div>
                    </div>
                    </div>
<?php }?>
</div>




