
<div class="box-body main">
    <?php
   
        ?><h4 class="page-title"> <?=__('Moving').' '.$moving['Moving']['reference'] ;?></h4>
    

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
        <?= $this->Html->link(
            '<i class="fa fa-edit m-r-5 m-r-5"></i>' . __("Edit"),
            array('action' => 'Edit', $moving['Moving']['id']),
            array('escape' => false, 'class'=>"btn btn-primary btn-bordred waves-effect waves-light m-b-5")
        ); ?>
        <?= $this->Form->postLink(
            '<i class="fa fa-trash-o m-r-5"></i>' . __("Delete"),
            array('action' => 'Delete', $moving['Moving']['id']),
            array('escape' => false, 'class'=>"btn btn-inverse btn-bordred waves-effect waves-light m-b-5"),
            __('Are you sure you want to delete %s?', $moving['Moving']['id'])); ?>

    

       

        <div style="clear: both"></div>
    </div>
                        </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                        </div>
                        </div>
                        </div>
                        </div>
    <div class="left_side card-box p-b-0">
        
                
                
                    
                          <?php if (!empty($moving['Moving']['reference'])) { ?>
                            <br/>
                            <dt><?php echo __('Reference'); ?></dt>
                            <dd>
                                <?php echo h($moving['Moving']['reference']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>

                           <?php if (!empty($moving['Car']['code'])){?> 
                        </br>
                        <dt><?php echo  __('Car'); ?></dt>
                       
                             <dd><?php echo $moving['Car']['code'] . " - " . $moving['Carmodel']['name']; ?></dd>
                        
						
                        <?php  } ?>

                         <?php if (!empty($moving['Extinguisher']['extinguisher_number'])) { ?>
                            <br/>
                            <dt><?php echo __('Extinguisher'); ?></dt>
                            <dd>
                                <?php echo h($moving['Extinguisher']['extinguisher_number']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>

						
                       


                        
                            <?php if (!empty($moving['Moving']['date_start'])){?> 
                        </br>
                        <dt><?php echo  __('Date start'); ?></dt>
                       
                            <dd><?php echo $this->Time->format($moving['Moving']['date_start'], '%d-%m-%Y'); ?>&nbsp;</dd>
                        
						
                        <?php  } ?>
                         <?php if (!empty($moving['Moving']['date_end'])){?> 
                        </br>
                        <dt><?php echo  __('Date end'); ?></dt>
                       
                            <dd><?php echo $this->Time->format($moving['Moving']['date_end'], '%d-%m-%Y'); ?>&nbsp;</dd>
                        
						
                        <?php  } ?>
                        
                         
                       
						



                      
                    </dl>
                    
                

        

    


          
				
				
			
    </div>


  
</div>

