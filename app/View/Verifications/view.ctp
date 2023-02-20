
<div class="box-body main">
    <?php
   
        ?><h4 class="page-title"> <?=$verification['Verification']['reference'] ;?></h4>

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
        <?= $this->Html->link(
            '<i class="fa fa-edit m-r-5 m-r-5"></i>' . __("Edit"),
            array('action' => 'Edit', $verification['Verification']['id']),
            array('escape' => false, 'class'=>"btn btn-primary btn-bordred waves-effect waves-light m-b-5")
        ); ?>
        <?= $this->Form->postLink(
            '<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __("Delete"),
            array('action' => 'Delete', $verification['Verification']['id']),
            array('escape' => false, 'class'=>"btn btn-inverse btn-bordred waves-effect waves-light m-b-5"),
            __('Are you sure you want to delete %s?', $verification['Verification']['id'])); ?>

    

       

        <div style="clear: both"></div>
    </div>
                        </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                        </div>
                        </div>
                        </div>
                        </div>
    <div class="left_side card-box p-b-10 pdg_btm">
        
                
                
                    
                          <?php if (!empty($verification['Verification']['reference'])) { ?>
                            <br/>
                            <dt><?php echo __('reference'); ?></dt>
                            <dd>
                                <?php echo h($verification['Verification']['reference']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>

                         <?php if (!empty($verification['Tire']['model'])) { ?>
                            <br/>
                            <dt><?php echo __('Tire'); ?></dt>
                            <dd>
                                <?php echo h($verification['Tire']['model']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                          <br/>
                            <dt><?php echo __('Tread'); ?></dt>
                            <dd>
                                <?php echo h($verification['Verification']['bande']); ?>
                                &nbsp;
                            </dd>
                             <br/>
                            <dt><?php echo __('Wear'); ?></dt>
                            <dd>
                                <?php echo h($verification['Verification']['wear']); ?>
                                &nbsp;
                            </dd>

                            <?php if (!empty($verification['Verification']['km'])) { ?>
                            <br/>
                            <dt><?php echo __('Km'); ?></dt>
                            <dd>
                                <?php echo h($verification['Verification']['km']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        
                            <?php if (!empty($verification['Verification']['date_verif'])){?> 
                        </br>
                        <dt><?php echo  __('Verification date'); ?></dt>
                       
                            <dd><?php echo $this->Time->format($verification['Verification']['date_verif'], '%d-%m-%Y'); ?>&nbsp;</dd>
                        
						
                        <?php  } ?>
                        
               
                     


                      
                    </dl>
                    
                

        

    


          
				
				
			
    </div>


  
</div>

