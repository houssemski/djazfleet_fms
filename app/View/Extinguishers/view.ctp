
<div class="box-body main">
    <?php
     
        ?><h4 class="page-title"> <?=__('Extinguisher').' '.$extinguisher['Extinguisher']['extinguisher_number'] ;?></h4>
    

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
        <?= $this->Html->link(
            '<i class="fa fa-edit m-r-5 m-r-5"></i>' . __("Edit"),
            array('action' => 'Edit', $extinguisher['Extinguisher']['id']),
            array('escape' => false, 'class'=>"btn btn-primary btn-bordred waves-effect waves-light m-b-5")
        ); ?>
        <?= $this->Form->postLink(
            '<i class="fa fa-trash-o m-r-5"></i>' . __("Delete"),
            array('action' => 'Delete', $extinguisher['Extinguisher']['id']),
            array('escape' => false, 'class'=>"btn btn-inverse btn-bordred waves-effect waves-light m-b-5"),
            __('Are you sure you want to delete %s?', $extinguisher['Extinguisher']['extinguisher_number'])); ?>

    

       

        <div style="clear: both"></div>
    </div>
                        </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                        </div>
                        </div>
                        </div>
                        </div>
    <div class="left_side card-box p-b-0">
        
            
           
                
                
                    
                       

                        <dt id="dt-h"><?php echo  __('Extinguisher number'); ?></dt>
                        <dd>
                            <?php echo $extinguisher['Extinguisher']['extinguisher_number']; ?>
                            &nbsp;
                        </dd>
						</br>
						
						<dt id="dt-i"><?php echo  __('Validity day date'); ?></dt>
                        <dd><?php echo $this->Time->format($extinguisher['Extinguisher']['validity_day_date'], '%d-%m-%Y'); ?>&nbsp;</dd>
                         &nbsp;
						</br>
						
						 <dt id="dt-j"><?php echo  __('Volume'); ?></dt>
                        <dd>
                            <?php echo $extinguisher['Extinguisher']['volume']; ?>
                            &nbsp;
                        </dd>
						</br>
						 <dt id="dt-k"><?php echo  __('Amount'); ?></dt>
                        <dd>
                            <?php echo $extinguisher['Extinguisher']['price']; ?>
                            &nbsp;
                        </dd>
						


                       
                        <?php if (isset($extinguisher['Extinguisher']['supplier_id']) && !empty($extinguisher['Extinguisher']['supplier_id'])) { ?>

                         <br/>
                        <dt id="dt-l"><?php echo __('Supplier'); ?></dt>
                        <dd>
                            <?php echo h($extinguisher['Supplier']['name']); ?>
                            &nbsp;
                        </dd>
                        <?php } ?>
						
						
                        <?php if (isset($extinguisher['Extinguisher']['location_id']) && !empty($extinguisher['Extinguisher']['location_id'])) { ?>

                         <br/>
                        <dt><?php echo __('Location'); ?></dt>
                        <dd>
                            <?php echo h($extinguisher['Location']['name']); ?>
                            &nbsp;
                        </dd>
                        <?php } ?>


                      
                    </dl>
      
    </div>


  
</div>

