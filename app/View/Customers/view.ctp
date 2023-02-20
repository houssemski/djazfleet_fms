

<div class="box-body main">
    <?php
    if (isset($customer['Customer']['company']) && !empty($customer['Customer']['company'])) {
        ?><h4 class="page-title"> <?=$customer['Customer']['first_name'] . " " . $customer['Customer']['last_name'] . " ( " . $customer['Customer']['company'] . " )";?></h4>
    <?php } else {
        ?><h4 class="page-title"> <?=$customer['Customer']['first_name'] . " " . $customer['Customer']['last_name'];?></h4>
   <?php  }
    ?>
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
        <?= $this->Html->link(
            '<i class="fa fa-edit m-r-5 m-r-5"></i>' . __("Edit"),
            array('action' => 'Edit', $customer['Customer']['id']),
            array('escape' => false, 'class'=>"btn btn-primary btn-bordred waves-effect waves-light m-b-5")
        ); ?>
        <?= $this->Form->postLink(
            '<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __("Delete"),
            array('action' => 'Delete', $customer['Customer']['id']),
            array('escape' => false, 'class'=>"btn btn-inverse btn-bordred waves-effect waves-light m-b-5"),
            __('Are you sure you want to delete %s?', $customer['Customer']['first_name'])); ?>

        <?php 
             
            if ($customer['Customer']['alert']==1) {  ?>
           
          <?=  $this->Html->link(
            '<i class="fa  fa-bell m-r-5"></i>' . __("disable alert"),
            array('action' => 'disablepermisalert', $customer['Customer']['id']),
            array('escape' => false, 'class' => 'btn btn-block btn-social btn-linkedin') );?>
        <?php } ?>

        

        <div style="clear: both"></div>
    </div>
                        </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                        </div>
                        </div>
                        </div>
                        </div>
    <div class="left_side card-box p-b-0">
        <div class="nav-tabs-custom pdg_btm">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
            
                <li><a href="#tab_2" data-toggle="tab"><?= __('Administratif information') ?></a></li>
                <li><a href="#tab_3" data-toggle="tab"><?= __('Official documents') ?></a></li>
                <li><a href="#tab_4" data-toggle="tab"><?= __("Affectation") . "s" ?></a></li>
                <li><a href="#tab_5" data-toggle="tab"><?= __("Consumptions") ?></a></li>
                <li><a href="#tab_6" data-toggle="tab"><?= __('Incidents') ?></a></li>
                <li><a href="#tab_7" data-toggle="tab"><?= __('Contraventions') ?></a></li>
                <li><a href="#tab_8" data-toggle="tab"><?= __('Warnings') ?></a></li>
                <li><a href="#tab_9" data-toggle="tab"><?= __('Absences') ?></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                
                    <?php if (!empty($customer['Customer']['image'])){ ?>
                    <dl>
                <dd>
                        <?= $this->Html->image('customers/' . $customer['Customer']['image'],
                            array(
                                'class' => 'img-details',
                                'alt' => 'Image'
                            )); ?>
                   
                  </dd>
                   
                      <br/>
                           </dl>
                        <?php }  ?>
                     
                        <dt><?php echo  __('Category'); ?></dt>
                        <dd>
                            <?php echo $customer['CustomerCategory']['name']; ?>
                            &nbsp;
                        </dd>
                        <?php if (!empty($customer['Customer']['code'])) { ?>
                            <br/>
                            <dt><?php echo __('Code'); ?></dt>
                            <dd>
                                <?php echo h($customer['Customer']['code']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <br/>


                        <dt><?php echo __('First Name'); ?></dt>
                        <dd>
                            <?php echo h($customer['Customer']['first_name']); ?>
                            &nbsp;
                        </dd>
                       
                        <?php if (isset($customer['Customer']['last_name']) && !empty($customer['Customer']['last_name'])) { ?>

                         <br/>
                        <dt><?php echo __('Last Name'); ?></dt>
                        <dd>
                            <?php echo h($customer['Customer']['last_name']); ?>
                            &nbsp;
                        </dd>
                        <?php } ?>

                         <?php if (isset($customer['Service']['name']) && !empty($customer['Service']['name'])) { ?>
                        <br/>
                        <dt><?php echo __('Service'); ?></dt>
                        <dd>
                            <?php echo h($customer['Service']['name']); ?>
                            &nbsp;
                        </dd>
                        <?php } ?>

                        <?php if (isset($customer['CustomerGroup']['name']) && !empty($customer['CustomerGroup']['name'])) { ?>
                        <br/>
                        <dt><?php echo __('Group'); ?></dt>
                        <dd>
                            <?php echo h($customer['CustomerGroup']['name']); ?>
                            &nbsp;
                        </dd>
                        <?php } ?>
                        <?php if (!empty($customer['Customer']['company'])) { ?>
                            <br/>
                            <dt><?php echo __('Company'); ?></dt>
                            <dd>
                                <?php echo h($customer['Customer']['company']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>


                        <?php if (!empty($customer['Customer']['adress'])) { ?>
                        <br/>
                        <dt><?php echo __('Address'); ?></dt>
                        <dd>
                            <?php echo h($customer['Customer']['adress']);
                           ?>
                            &nbsp;
                        
                        </dd>
                        <?php } ?>
                        
                        <?php if (!empty($customer['Customer']['tel'])) { ?>
                            <br/>
                            <dt><?php echo __('Tel'); ?></dt>
                            <dd>
                                <?php echo h($customer['Customer']['tel']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (!empty($customer['Customer']['mobile'])) { ?>
                            <br/>
                            <dt><?php echo __('Mobile'); ?></dt>
                            <dd>
                                <?php echo h($customer['Customer']['mobile']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (!empty($customer['Customer']['email1'])) { ?>
                            <br/>
                            <dt><?php echo __('Email 1'); ?></dt>
                            <dd>
                                <?php echo h($customer['Customer']['email1']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (!empty($customer['Customer']['email2'])) { ?>
                            <br/>
                            <dt><?php echo __('Email 2'); ?></dt>
                            <dd>
                                <?php echo h($customer['Customer']['email2']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (!empty($customer['Customer']['email3'])) { ?>
                            <br/>
                            <dt><?php echo __('Email 3'); ?></dt>
                            <dd>
                                <?php echo h($customer['Customer']['email3']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (!empty($customer['Customer']['birthday'])) { ?>
                            <br/>
                            <dt><?php echo __('Birthday'); ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($customer['Customer']['birthday'], '%d-%m-%Y')); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (!empty($customer['Customer']['birthplace'])) { ?>
                            <br/>
                            <dt><?php echo __('Birthplace'); ?></dt>
                            <dd>
                                <?php echo h($customer['Customer']['birthplace']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (!empty($customer['Customer']['job'])) { ?>
                            <br/>
                            <dt><?php echo __('Job'); ?></dt>
                            <dd>
                                <?php echo h($customer['Customer']['job']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (!empty($customer['Customer']['nationality_id'])) { ?>
                            <br/>
                            <dt><?php echo __('Nationality'); ?></dt>
                            <dd>
                                <?php echo h($customer['Nationality']['name']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (!empty($customer['Customer']['monthly_payroll'])) { ?>
                            <br/>
                            <dt><?php echo __('Monthly payroll'); ?></dt>
                            <dd>
                                <?php echo h(number_format($customer['Customer']['monthly_payroll'], 2, ",", ".")); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                          <?php if (!empty($customer['Customer']['cost_center'])) { ?>
                            <br/>
                            <dt><?php echo __('Cost center'); ?></dt>
                            <dd>
                                <?php echo h(number_format($customer['Customer']['cost_center'], 2, ",", ".")); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                      
                        <?php if (!empty($customer['Customer']['note'])) { ?>
                            <br/>
                            <dt><?php echo __('Note'); ?></dt>
                            <dd>
                                <?php echo nl2br(h($customer['Customer']['note'])); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                    </dl>
                    <table class="table table-bordered details">
						    <thead>
                    <tr>
                      
                        <th></th>
                        <th><?php echo  __('Mensuel'); ?></th>
						<th><?php echo  __('Annuel'); ?></th>
                        <th><?php echo __('Global'); ?></th>
                        
                    </tr>
                    </thead>
                    <tbody >
                 
                        <tr>
                           
                            <td><?php  echo  __('Km');?>&nbsp;</td>
                            
                            <td><?php echo $sumKmMonth ;?>&nbsp;</td>
                            <td><?php  echo $sumKmYear ;?>&nbsp;</td>
                            <td><?php echo $sumKmConductor ?>&nbsp;</td>

                            
						
						</tr>
						<tr>
                           
                            <td><?php echo  __('Hour'); ?>&nbsp;</td>
                            
                            <td><?php echo $sumHourMonth ;?>&nbsp;</td>
                            <td><?php  echo $sumHourYear ;?>&nbsp;</td>
                            <td><?php echo $sumHourConductor ?>&nbsp;</td>

                            
						
						</tr>
                    
                    
                    
                    
					</tbody>
                
				
					</table>
					
				
				
                </div>

                <div class="tab-pane" id="tab_2">
                
                <?php if (!empty($customer['Customer']['entry_date'])) { ?>
                            
                            <dt><?php echo __('Entry date'); ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($customer['Customer']['entry_date'], '%d-%m-%Y')); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (!empty($customer['Customer']['declaration_date'])) { ?>
                            <br/>
                            <dt><?php echo __('Declaration date'); ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($customer['Customer']['declaration_date'], '%d-%m-%Y')); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>

                        <?php if (!empty($customer['Customer']['exit_date'])) { ?>
                            <br/>
                            <dt><?php echo __('Exit date'); ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($customer['Customer']['exit_date'], '%d-%m-%Y')); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>

                          <?php if (!empty($customer['Customer']['affiliate'])) { ?>
                            <br/>
                            <dt><?php echo __('Affiliate'); ?></dt>
                            <dd>
                                <?php echo h($customer['Customer']['affiliate']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>

                        <?php if (!empty($customer['Customer']['ccp'])) { ?>
                            <br/>
                            <dt><?php echo __('N&ordm; CCP'); ?></dt>
                            <dd>
                                <?php echo h($customer['Customer']['ccp']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>

                        <?php if (!empty($customer['Customer']['bank_account'])) { ?>
                            <br/>
                            <dt><?php echo __('N&ordm; bank account'); ?></dt>
                            <dd>
                                <?php echo h($customer['Customer']['bank_account']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>


                    



                </div>

                <div class="tab-pane" id="tab_3">

                  <?php if (!empty($customer['Customer']['identity_card_nu'])) { ?>
                            <br/>
                            <dt><?php echo __('Identity Card Nu'); ?></dt>
                            <dd>
                                <?php echo h($customer['Customer']['identity_card_nu']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (!empty($customer['Customer']['identity_card_by'])) { ?>
                            <br/>
                            <dt><?php echo __('Delivered by'); ?></dt>
                            <dd>
                                <?php echo h($customer['Customer']['identity_card_by']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (!empty($customer['Customer']['identity_card_date'])) { ?>
                            <br/>
                            <dt><?php echo __('Delivery date'); ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($customer['Customer']['identity_card_date'], '%d-%m-%Y')); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                          <?php if (!empty($customer['Customer']['identity_card_scan1'])) { ?>
                          <br/>
            <dt><?php echo __('Identity Card picture front'); ?></dt>
            <dd>
                 
  <?= $this->Html->Link($customer['Customer']['identity_card_scan1'],
                                    '/img/identitycards/' . $customer['Customer']['identity_card_scan1'],
                                    array('class' => 'attachments', 'target' => '_blank')
                                ); ?>
            </dd>
        <?php } ?>
       
           <?php if (!empty($customer['Customer']['identity_card_scan2'])) { ?>
           <br/>
            <dt><?php echo __('Identity Card picture back'); ?></dt>
            <dd>
                 
  <?= $this->Html->Link($customer['Customer']['identity_card_scan2'],
                                    '/img/identitycards/' . $customer['Customer']['identity_card_scan2'],
                                    array('class' => 'attachments', 'target' => '_blank')
                                ); ?>

</dd>
            <?php } ?>


                        <?php if (!empty($customer['Customer']['driver_license_nu'])) { ?>
                            <br/>
                            <dt><?php echo __('Driver License Nu'); ?></dt>
                            <dd>
                                <?php echo h($customer['Customer']['driver_license_nu']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (!empty($customer['Customer']['driver_license_category'])) { ?>
                            <br/>
                            <dt><?php echo __('Driver license category'); ?></dt>
                            <dd>
                            
                                <?php 
                                

                                $category=explode(',',$customer['Customer']['driver_license_category']);

                                $nb_category=count($category);
                                
                            
                                $i=0;
                                foreach($category as $category) {

                                switch ($category) {

                                case 1 :
                                        $category_name = __("Category A");
                                        break;
                                    case 2 :
                                        $category_name = __("Category B");
                                        break;
                                    case 3 :
                                        $category_name = __("Category C");
                                        break;
                                    case 4 :
                                        $category_name = __("Category D");
                                        break;
                                    case 5 :
                                        $category_name = __("Category E");
                                        break;
                                    case 6 :
                                        $category_name = __("Category F");
                                        break;
                                    default :
                                        $category_name ='';

                                        }
                                        if($i==0) {
                                        echo h($category_name.'');

                                }else{

                                if($category_name!=''){
                                        echo h(', '.$category_name);
                                        }
                                    }
                      

                    $i++;
                            }?>
                                    
                                
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (!empty($customer['Customer']['driver_license_by'])) { ?>
                            <br/>
                            <dt><?php echo __('Delivered by'); ?></dt>
                            <dd>
                                <?php echo h($customer['Customer']['driver_license_by']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (!empty($customer['Customer']['driver_license_date'])) { ?>
                            <br/>
                            <dt><?php echo __('Delivery date'); ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($customer['Customer']['driver_license_date'], '%d-%m-%Y')); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (!empty($customer['Customer']['driver_license_expires_date1'])) { ?>
                            <br/>
                            <dt><?php echo __('Expiration date') .' (Cat A)'; ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($customer['Customer']['driver_license_expires_date1'], '%d-%m-%Y')); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>

                        <?php if (!empty($customer['Customer']['driver_license_expires_date2'])) { ?>
                            <br/>
                            <dt><?php echo __('Expiration date') .' (Cat B)'; ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($customer['Customer']['driver_license_expires_date2'], '%d-%m-%Y')); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>

                        <?php if (!empty($customer['Customer']['driver_license_expires_date3'])) { ?>
                            <br/>
                            <dt><?php echo __('Expiration date') .' (Cat C)'; ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($customer['Customer']['driver_license_expires_date3'], '%d-%m-%Y')); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>

                        <?php if (!empty($customer['Customer']['driver_license_expires_date4'])) { ?>
                            <br/>
                            <dt><?php echo __('Expiration date') .' (Cat D)'; ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($customer['Customer']['driver_license_expires_date4'], '%d-%m-%Y')); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>

                        <?php if (!empty($customer['Customer']['driver_license_expires_date5'])) { ?>
                            <br/>
                            <dt><?php echo __('Expiration date') .' (Cat E)'; ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($customer['Customer']['driver_license_expires_date5'], '%d-%m-%Y')); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>

                        <?php if (!empty($customer['Customer']['driver_license_expires_date6'])) { ?>
                            <br/>
                            <dt><?php echo __('Expiration date') .' (Cat F)'; ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($customer['Customer']['driver_license_expires_date6'], '%d-%m-%Y')); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>

                         <?php if (!empty($customer['Customer']['driver_license_scan1'])) { ?>
            <br/>
            <dt><?php echo __('Driver License picture front'); ?></dt>
            <dd>
              

 <?= $this->Html->Link($customer['Customer']['driver_license_scan1'],
                                    '/img/driverlicenses/' . $customer['Customer']['driver_license_scan1'],
                                    array('class' => 'attachments', 'target' => '_blank')
                                ); ?>
            </dd>

        <?php } ?>

                <?php if (!empty($customer['Customer']['driver_license_scan2'])) { ?>
            <br/>
            <dt><?php echo __('Driver License picture back'); ?></dt>
            <dd>
              

 <?= $this->Html->Link($customer['Customer']['driver_license_scan2'],
                                    '/img/driverlicenses/' . $customer['Customer']['driver_license_scan2'],
                                    array('class' => 'attachments', 'target' => '_blank')
                                ); ?>
            </dd>

        <?php } ?>

<?php if (!empty($customer['Customer']['blood_group'])) { ?>
                            <br/>
                            <dt><?php echo __('Groupe sangain'); ?></dt>
                            <dd>
                                <?php echo h($customer['Customer']['blood_group']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>

                        <?php if (!empty($customer['Customer']['passport_nu'])) { ?>
                            <br/>
                            <dt><?php echo __('Passport Nu'); ?></dt>
                            <dd>
                                <?php echo h($customer['Customer']['passport_nu']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (!empty($customer['Customer']['passport_by'])) { ?>
                            <br/>
                            <dt><?php echo __('Delivered by'); ?></dt>
                            <dd>
                                <?php echo h($customer['Customer']['passport_by']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (!empty($customer['Customer']['passport_date'])) { ?>
                            <br/>
                            <dt><?php echo __('Delivery date'); ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($customer['Customer']['passport_date'], '%d-%m-%Y')); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>

                           <?php if (!empty($customer['Customer']['passport_scan'])) { ?>
            <br/>
            <dt><?php echo __('Passport picture'); ?></dt>
            <dd>
                

 <?= $this->Html->Link($customer['Customer']['passport_scan'],
                                    '/img/passports/' . $customer['Customer']['passport_scan'],
                                    array('class' => 'attachments', 'target' => '_blank')
                                ); ?>



            </dd>
        <?php } ?>






                </div>


                <div class="tab-pane" id="tab_4">
                    <table class="table table-bordered details">
                        <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('Carmodel.name', __('Car')); ?></th>
                            <th><?php echo $this->Paginator->sort('start', __('Start')); ?></th>
                            <th><?php echo $this->Paginator->sort('end', __('End')); ?></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($customerCars as $customerCar): ?>
                            <tr id="row<?= $customerCar['CustomerCar']['id'] ?>">
                                <td>
                                    <?php if ($param==1){
                                        echo $customerCar['Car']['code']." - ".$customerCar['Carmodel']['name'];
                                    } else if ($param==2) {
                                        echo $customerCar['Car']['immatr_def']." - ".$customerCar['Carmodel']['name'];
                                    } ?>
                                </td>
                                <td><?php echo h($this->Time->format($customerCar['CustomerCar']['start'], '%d-%m-%Y %H:%M')); ?>
                                    &nbsp;</td>
                                <td><?php echo h($this->Time->format($customerCar['CustomerCar']['end'], '%d-%m-%Y %H:%M')); ?>
                                    &nbsp;</td>

                                
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
                    if ($this->params['paging']['CustomerCar']['pageCount'] > 1) {
                        ?>
                        <p>
                            <?php
                            echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?>    </p>
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php
                                echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                echo $this->Paginator->numbers(array(
                                    'tag' => 'li',
                                    'first' => false,
                                    'last' => false,
                                    'separator' => '',
                                    'currentTag' => 'a'));
                                echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>

                <div class="tab-pane" id="tab_5">
                    <?php
                    $ConsumptionSum = 0;
                    $sumcost = 0;
                    if (!empty($consumptions)) {
                        ?>
                        <table class="table table-bordered details" cellspacing="0" width="80%">
                            <thead>
                            <tr>

                                <th><?php echo $this->Paginator->sort('type_consumption_used', __('Consumption type')); ?></th>
                                <th><?php echo $this->Paginator->sort('consumption_date', __('Consumption date')); ?></th>
                                <th><?php echo $this->Paginator->sort('nb_coupon', __('Nb coupon')); ?></th>
                                <th><?php echo $this->Paginator->sort('first_number_coupon', __('First number coupon')); ?></th>
                                <th><?php echo $this->Paginator->sort('last_number_coupon', __('Last number coupon')); ?></th>
                                <th><?php echo $this->Paginator->sort('', __('Serial numbers')); ?></th>
                                <th><?php echo $this->Paginator->sort('species', __('Species')); ?></th>
                                <th><?php echo $this->Paginator->sort('tank_id', __('Tank')); ?></th>
                                <th><?php echo $this->Paginator->sort('consumption_liter', __('Consumption liter')); ?></th>
                                <th><?php echo $this->Paginator->sort('fuel_card_id', __('Cards')); ?></th>
                                <th><?php echo $this->Paginator->sort('species_card', __('Species card')); ?></th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            foreach ($consumptions as $consumption) {
                                if ($consumption['SheetRide']['km_liter'] != null) {
                                    $ConsumptionSum = $ConsumptionSum + $consumption['SheetRide']['km_liter'];
                                }

                                if ($consumption['SheetRide']['cost'] != 0) {
                                    $sumcost = $sumcost + $consumption['SheetRide']['cost'];
                                }
                                ?>
                                <tr>
                                    <?php
                                    switch ($consumption['Consumption']['type_consumption_used']) {
                                        case ConsumptionTypesEnum::coupon :
                                            ?>
                                            <td> <?php echo __('Coupons'); ?></td>
                                            <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M')); ?> </td>
                                            <td><?php echo h($consumption['Consumption']['nb_coupon']); ?> </td>
                                            <td><?php echo h($consumption['Consumption']['first_number_coupon']); ?></td>
                                            <td><?php echo h($consumption['Consumption']['first_number_coupon']); ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <?php break;
                                        case ConsumptionTypesEnum::species:
                                            ?>
                                            <td> <?php echo __('Species'); ?></td>
                                            <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M')); ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo h($consumption['Consumption']['species']); ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <?php break;
                                        case ConsumptionTypesEnum::tank:
                                            ?>
                                            <td> <?php echo __('Tank'); ?></td>
                                            <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M')); ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo h($consumption['Tank']['name']); ?></td>
                                            <td><?php echo h($consumption['Consumption']['consumption_liter']); ?></td>
                                            <td></td>
                                            <td></td>
                                            <?php break;
                                        case ConsumptionTypesEnum::card:
                                            ?>
                                            <td> <?php echo __('Cards'); ?></td>
                                            <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M')); ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo h($consumption['FuelCard']['reference']); ?></td>
                                            <td><?php echo h($consumption['Consumption']['species_card']); ?></td>
                                            <?php break;
                                    }

                                    ?>


                                </tr>

                            <?php } ?>

                            </tbody>
                        </table>
                        <?php

                        if ($this->params['paging']['Consumption']['pageCount'] > 1) {
                            ?>
                            <p>
                                <?php
                                echo $this->Paginator->counter(array(
                                    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                                ));
                                ?>    </p>
                            <div class="box-footer clearfix">
                                <ul class="pagination pagination-sm no-margin pull-left">
                                    <?php
                                    echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                    echo $this->Paginator->numbers(array(
                                        'tag' => 'li',
                                        'first' => false,
                                        'last' => false,
                                        'separator' => '',
                                        'currentTag' => 'a'));
                                    echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                    ?>
                                </ul>
                            </div>
                        <?php } ?>
                    <?php } ?>



                    <br><br>
                    <ul class="list-group m-b-0 user-list">
                        <?php echo "<div class='total'><b>" . __('Transactions sum :  ') . '</b><span class="badge bg-red">' . number_format($sumcost, 2, ",", ".") . " " . $this->Session->read('currency') . "</span></div>"; ?>
                    </ul>
                    <ul class="list-group m-b-0 user-list">
                        <?php     echo "<div class='total'><b>" . __('Consumptions sum :  ') . '</b><span class="badge bg-red">' . number_format($ConsumptionSum, 2, ",", ".");
                        if ($ConsumptionSum > 0) echo " " . __('Liter') . "s</span></div>"; else echo " " . __('Liter') . "</span></div>"; ?>
                    </ul>

                </div>

				<div class="tab-pane" id="tab_6">
                       <table class="table table-bordered details">
                        <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('Car.code', __('Car')); ?></th>
                            <th><?php echo $this->Paginator->sort('date', __('Date')); ?></th>
                            <th><?php echo $this->Paginator->sort('next_date', __('Next date')); ?></th>
                            
                            
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sumCost=0;
                        foreach ($incidents as $incident): ?>
                            
                            <tr id="row<?= $incident['Event']['id'] ?>">
                               <td><?php
                                     if ($param==1){
                                        echo $incident['Car']['code']." - ".$incident['Carmodel']['name'];
                                    } else if ($param==2) {
                                        echo $incident['Car']['immatr_def']." - ".$incident['Carmodel']['name'];
                                    } ?>
                                        &nbsp;</td>
                                <td><?php echo h($this->Time->format($incident['Event']['date'], '%d-%m-%Y')); ?>
                                    &nbsp;</td>
                                <td><?php echo h($this->Time->format($incident['Event']['next_date'], '%d-%m-%Y')); ?>
                                    &nbsp;</td>
                                    
                               <?php if($incident['Event']['cost']!=0) {
                                        $sumCost=$sumcost+$incident['Event']['cost'];
                                            } ?> 
                            </tr>
                        <?php endforeach; ?>
                        
                        </tbody>
                    </table>
                    <?php
                    if ($this->params['paging']['Event']['pageCount'] > 1) {
                        ?>
                        <p>
                            <?php
                            echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?>    </p>
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php
                                echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                echo $this->Paginator->numbers(array(
                                    'tag' => 'li',
                                    'first' => false,
                                    'last' => false,
                                    'separator' => '',
                                    'currentTag' => 'a'));
                                echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                ?>
                            </ul>
                        </div>
                    <?php } 
                    echo "<div class='total'><b>" . __('Transactions sum :  ') . '</b><span class="badge bg-red">' .
                        number_format($sumcost,2,",",".") . " " . $this->Session->read("currency") .  "</span></div>";

                        ?>
				</div>
				
				<div class="tab-pane" id="tab_7">
                       <table class="table table-bordered details">
                        <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('Car.code', __('Car')); ?></th>
                            <th><?php echo $this->Paginator->sort('date', __('Date')); ?></th>
                            <th><?php echo $this->Paginator->sort('place', __('Place')); ?></th>
                            <th><?php echo $this->Paginator->sort('contravention_type_id', __('Contravention type')); ?></th>
                            <th><?php echo $this->Paginator->sort('driving_licence_withdrawal', __('Driving licence withdrawal')); ?></th>
                             <th><?php echo $this->Paginator->sort('cost', __('Cost')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sumcost=0;
                        foreach ($contraventions as $contravention): ?>
                            
                            <tr id="row<?= $contravention['Event']['id'] ?>">
                               <td><?php
                                   if ($param==1){
                                       echo $contravention['Car']['code']." - ".$contravention['Carmodel']['name'];
                                   } else if ($param==2) {
                                        echo $contravention['Car']['immatr_def']." - ".$contravention['Carmodel']['name'];
                                   } ?>
                                     &nbsp;</td>
                                <td><?php echo h($this->Time->format($contravention['Event']['date'], '%d-%m-%Y')); ?>
                                    &nbsp;</td>
                                <td><?php echo $contravention['Event']['place']?></td>
                                <td><?php

                                    switch ($contravention['Event']['contravention_type_id']){
                                        case 1:
                                            $contraventionType = 'Arrêt ou stationnement dangereux';
                                            break;

                                        case 2:
                                            $contraventionType = 'Conduite en sens opposé à la circulation';
                                            break;

                                        case 3:
                                            $contraventionType = 'Défaut au gabarit des véhicules, à l’installation des dispositifs d’éclairage et de signalisation des véhicules';
                                            break;

                                        case 4:
                                            $contraventionType = 'Défaut sur le véhicule';
                                            break;

                                        case 5:
                                            $contraventionType = 'Empiètement d’une ligne continue';
                                            break;

                                        case 6:
                                            $contraventionType = 'Franchissement d’une ligne continue';
                                            break;

                                        case 7:
                                            $contraventionType = 'Manœuvres interdites sur autoroutes et routes express';
                                            break;

                                        case 8:
                                            $contraventionType = 'Non port de la ceinture de sécurité';
                                            break;

                                        case 9:
                                            $contraventionType = 'Non respect de la charge maximale par essieu';
                                            break;

                                        case 10:
                                            $contraventionType = 'Non respect de la distance légale entre les véhicules';
                                            break;

                                        case 11:
                                            $contraventionType = 'Non respect de la priorité de passage des piétons au niveau des passages protégés';
                                            break;

                                        case 12:
                                            $contraventionType = 'Non respect des bonnes règles de conduite';
                                            break;

                                        case 13:
                                            $contraventionType = 'Non respect des dispositions relatives aux intersections de routes et à la priorité de passage';
                                            break;

                                        case 14:
                                            $contraventionType = 'Non respect des règles de limitations de vitesse';
                                            break;

                                        case 15:
                                            $contraventionType = 'Non respect des règles d’installation, de spécifications, de fonctionnement et de la maintenance du chrono tachygraphe';
                                            break;

                                        case 16:
                                            $contraventionType = 'Non respect des règles d’installation, de spécifications, de fonctionnement et de la maintenance du chrono tachygraphe';
                                            break;

                                        case 17:
                                            $contraventionType = 'Usage manuel du téléphone portable';
                                            break;
                                    }


                                    echo $contraventionType ; ?></td>
                                <td><?php
                                    switch ($contravention['Event']['driving_licence_withdrawal']){
                                        case 1:
                                            $drivingLicenceWithdrawal = __('Yes');
                                            break;

                                        case 2:
                                            $drivingLicenceWithdrawal = __('No');
                                            break;
                                    }

                                    echo $drivingLicenceWithdrawal ; ?></td>

                                <td><?php echo number_format($contravention['Event']['cost'],2,",",".")?></td>
                               <?php if($contravention['Event']['cost']!=0) {
                                        $sumcost=$sumcost+$contravention['Event']['cost'];
                                            } ?> 
                            </tr>
                        <?php endforeach; ?>
                        
                        </tbody>
                    </table>
                    <?php
                    if ($this->params['paging']['Event']['pageCount'] > 1) {
                        ?>
                        <p>
                            <?php
                            echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?>    </p>
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php
                                echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                echo $this->Paginator->numbers(array(
                                    'tag' => 'li',
                                    'first' => false,
                                    'last' => false,
                                    'separator' => '',
                                    'currentTag' => 'a'));
                                echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                ?>
                            </ul>
                        </div>
                    <?php } 
                    echo "<div class='total'><b>" . __('Transactions sum :  ') . '</b><span class="badge bg-red">' .
                        number_format($sumcost,2,",",".") . " " . $this->Session->read("currency") .  "</span></div>";

                        ?>
				</div>
            
				<div class="tab-pane" id="tab_8">
					<table class="table table-bordered details">
					
						<thead>
                    <tr>
                        
                        <th><?php echo $this->Paginator->sort('coce', __('Code')); ?></th>
                        
						<th><?php echo $this->Paginator->sort('warning_type_id', __('Warning type')); ?></th>
                        <th><?php echo $this->Paginator->sort('start_date', __('Start date')); ?></th>
                        <th><?php echo $this->Paginator->sort('end_date', __('End date')); ?></th>
                        
                    </tr>
                    </thead>
                    <tbody >
                    <?php foreach ($warnings as $warning): ?>
                        <tr id="row<?= $warning['Warning']['id'] ?>">
                           
                            <td><?php echo h($warning['Warning']['code']); ?>&nbsp;</td>
                            
							<td><?php echo h($warning['WarningType']['name']); ?>&nbsp;</td>
                            <td><?php echo h($this->Time->format($warning['Warning']['start_date'], '%d-%m-%Y')); ?>&nbsp;</td>
                            <td><?php echo h($this->Time->format($warning['Warning']['end_date'], '%d-%m-%Y')); ?>&nbsp;</td>

                            
						</tr>
                    <?php endforeach; ?>
                    </tbody>
                
				
					</table>
					<?php
					      if ($this->params['paging']['Warning']['pageCount'] > 1) {
                        ?>
                        <p>
                            <?php
                            echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?>    </p>
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php
                                echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                echo $this->Paginator->numbers(array(
                                    'tag' => 'li',
                                    'first' => false,
                                    'last' => false,
                                    'separator' => '',
                                    'currentTag' => 'a'));
                                echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                ?>
                            </ul>
                        </div>
                    <?php } ?>
				</div>
				
				
				<div class="tab-pane" id="tab_9">
					<table class="table table-bordered details">
						    <thead>
                    <tr>
                       
                        <th><?php echo $this->Paginator->sort('coce', __('Code')); ?></th>
                        
						<th><?php echo $this->Paginator->sort('absence_reason_id', __('Absence reason')); ?></th>
                        <th><?php echo $this->Paginator->sort('start_date', __('Start date')); ?></th>
                        <th><?php echo $this->Paginator->sort('end_date', __('End date')); ?></th>
                        
                    </tr>
                    </thead>
                    <tbody id="listeDiv">
                    <?php foreach ($absences as $absence): ?>
                        <tr id="row<?= $absence['Absence']['id'] ?>">
                           
                            <td><?php echo h($absence['Absence']['code']); ?>&nbsp;</td>
                            
							<td><?php echo h($absence['AbsenceReason']['name']); ?>&nbsp;</td>
                            <td><?php echo h($this->Time->format($absence['Absence']['start_date'], '%d-%m-%Y')); ?>&nbsp;</td>
                            <td><?php echo h($this->Time->format($absence['Absence']['end_date'], '%d-%m-%Y')); ?>&nbsp;</td>

                            
						
						</tr>
                    <?php endforeach; ?>
                    </tbody>
                
				
					</table>
					  <?php
                    if ($this->params['paging']['Absence']['pageCount'] > 1) {
                        ?>
                        <p>
                            <?php
                            echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?>    </p>
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php
                                echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                echo $this->Paginator->numbers(array(
                                    'tag' => 'li',
                                    'first' => false,
                                    'last' => false,
                                    'separator' => '',
                                    'currentTag' => 'a'));
                                echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                ?>
                            </ul>
                        </div>
                    <?php } ?>
				</div>
			
				
			
			
			
			</div>
        </div>
    </div>

    <?php if ($hasPermission) {?>
    <div class="right_side">
        <h6 class="subheader"><?php echo __('Created'); ?></h6>
        <p><?php echo h($this->Time->format($customer['Customer']['created'], '%d-%m-%Y %H:%M')); ?></p>
        <h6 class="subheader"><?php echo __('By'); ?></h6>
        <p><?php echo h($customer['User']['first_name'])." ".h($customer['User']['last_name']); ?></p>
        <?php if (!empty($customer['Customer']['modified_id'])){ ?>
            <h6 class="subheader"><?php echo __('Modified'); ?></h6>
            <p><?php echo h($this->Time->format($customer['Customer']['modified'], '%d-%m-%Y %H:%M')); ?></p>
            <h6 class="subheader"><?php echo __('By'); ?></h6>
            <p><?php echo h($customer['UserModifier']['first_name'])." ".h($customer['UserModifier']['last_name']); ?></p>
        <?php } ?>
    </div>
    <?php } ?>
    <br/><br/>
    <dl class="scan">
      
    
     
    </dl>
</div>
<div style='clear:both; padding-top: 10px;'></div> 
<?php /* if ($hasPermission && !empty($audits)) { ?>

 <div class="lbl2"><a class="btn  btn-act btn-info" href="#demo" data-toggle="collapse">
                        <i class="  fa fa-eye m-r-5" style="font-size: 1.3em !important;line-height: 30px !important;"></i>
						<i class="more-less glyphicon glyphicon-chevron-down"></i>
                         <?= __("  Voir audits"); ?>
                    </a> </div>
                               
                               
                                    
                                    <?php if (!empty($audits)){?>
					<div id="demo" class="collapse nav-tabs-custom col-md-4">				
									

 <table>
    <?php     foreach($audits as $audit) { ?>
        
    <tr >

        <td ><dt style='padding-right: 10px; margin-left: 10px; padding-bottom: 5px; padding-top: 10px;' ><?php echo __('Modified'); ?></dt></td>
        <td><dd style='padding-right: 10px; padding-bottom: 5px; padding-top: 10px;'><?php echo h($this->Time->format($audit['Audit']['created'], '%d-%m-%Y %H:%M')); ?></dd><td>
        <td ><dt style='padding-right: 10px; padding-bottom: 5px; padding-top: 10px;'><?php echo __('By'); ?></dt></td>
        <td><dd style='padding-right: 10px; padding-bottom: 5px; padding-top: 10px;'><?php echo h($audit['User']['first_name'])." ".h($audit['User']['last_name']); ?></dd><td>



</tr>
        <?php } ?>
        </table>
        </br>
		                <?php
if($this->params['paging']['Audit']['pageCount'] > 1){


?>
<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
<div class="box-footer clearfix">
    <ul class="pagination pagination-sm no-margin pull-left">
	<?php
		echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
		echo $this->Paginator->numbers(array(
                    'tag' => 'li',
                    'first' => false,
                    'last' => false,
                    'separator' => '',
                    'currentTag' => 'a'));
		echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
	?>
    </ul>
</div>
<?php } ?>
		</div>
        <?php } ?>


                              

<?php }

*/
?>




<script type="text/javascript">     $(document).ready(function() {

        google.maps.event.addDomListener(window, 'load', initialize(<?php echo $v1 ?>,<?php echo $v2 ?>, 12, "map"));
    });

    //fonction initialisant la carte    
    function initialize(lat, lng, zoom, carte) {
        geocoder = new google.maps.Geocoder();
        //par d�faut on prend les coordonn�es entr� dans notre champs latlng
       
        var latlng = new google.maps.LatLng(lat, lng)
        //on initialise notre carte
        var options = {
            center: new google.maps.LatLng(lat, lng),
            zoom: zoom,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById(carte), options);
        //on indique que notre champ addresspicker doit proposer les adresses existantes
        var input = document.getElementById('addresspicker');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);
        //mise en place du marqueur
        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
            map: map
        });
        //d�placable
        marker.setDraggable(true);
        marker.setPosition(latlng);
        //quand on relache notre marqueur on r�initialise la carte avec les nouvelle coordonn�es
        google.maps.event.addListener(marker, 'dragend', function(event) {
            traiteAdresse(marker, event.latLng, infowindow, map);
        });
   
        //quand on choisie une adresse propos�e on r�initialise la carte avec les nouvelles coordonn�es
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            infowindow.close();
            var place = autocomplete.getPlace();
            marker.setPosition(place.geometry.location);
            traiteAdresse(marker, place.geometry.location, infowindow, map);
        });
    }




</script>