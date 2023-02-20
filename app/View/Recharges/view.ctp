
<div class="box-body main">
    <?php
   
        ?><h4 class="page-title"> <?=__('Recharge').' '.$recharge['Recharge']['code'] ;?></h4>

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
        <?= $this->Html->link(
            '<i class="fa fa-edit m-r-5 m-r-5"></i>' . __("Edit"),
            array('action' => 'Edit', $recharge['Recharge']['id']),
            array('escape' => false, 'class'=>"btn btn-primary btn-bordred waves-effect waves-light m-b-5")
        ); ?>
        <?= $this->Form->postLink(
            '<i class="fa fa-trash-o m-r-5"></i>' . __("Delete"),
            array('action' => 'Delete', $recharge['Recharge']['id']),
            array('escape' => false, 'class'=>"btn btn-inverse btn-bordred waves-effect waves-light m-b-5"),
            __('Are you sure you want to delete %s?', $recharge['Recharge']['id'])); ?>

    

       

        <div style="clear: both"></div>
    </div>
                        </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                        </div>
                        </div>
                        </div>
                        </div>
    <div class="left_side card-box p-b-0">
        
                
                
                    
                          <?php if (!empty($recharge['Recharge']['code'])) { ?>
                            <br/>
                            <dt><?php echo __('Code'); ?></dt>
                            <dd>
                                <?php echo h($recharge['Recharge']['code']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>

                         <?php if (!empty($recharge['Extinguisher']['extinguisher_number'])) { ?>
                            <br/>
                            <dt><?php echo __('Extinguisher'); ?></dt>
                            <dd>
                                <?php echo h($recharge['Extinguisher']['extinguisher_number']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                          
                          
                        
                        
                            <?php if (!empty($recharge['Recharge']['recharge_date'])){?> 
                        </br>
                        <dt><?php echo  __('Recharge date'); ?></dt>
                       
                            <dd><?php echo $this->Time->format($recharge['Recharge']['recharge_date'], '%d-%m-%Y'); ?>&nbsp;</dd>
                        
						
                        <?php  } ?>
                        
               
                     


                      
                    </dl>
                    
                

        

    


          
				
				
			
    </div>


  
</div>

