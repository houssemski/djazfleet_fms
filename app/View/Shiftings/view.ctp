
<div class="box-body main">
    <?php
   
        ?><h4 class="page-title"> <?=$shifting['Shifting']['reference'] ;?></h4>
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
        <?= $this->Html->link(
            '<i class="fa fa-edit m-r-5 m-r-5"></i>' . __("Edit"),
            array('action' => 'Edit', $shifting['Shifting']['id']),
            array('escape' => false, 'class'=>"btn btn-primary btn-bordred waves-effect waves-light m-b-5")
        ); ?>
        <?= $this->Form->postLink(
            '<i class=" fa fa-trash-o m-r-5 m-r-5"></i>' . __("Delete"),
            array('action' => 'Delete', $shifting['Shifting']['id']),
            array('escape' => false, 'class'=>"btn btn-inverse btn-bordred waves-effect waves-light m-b-5"),
            __('Are you sure you want to delete %s?', $shifting['Shifting']['id'])); ?>

    

       

        <div style="clear: both"></div>
    </div>
                        </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                        </div>
                        </div>
                        </div>
                        </div>

    <div class="left_side card-box p-b-0">
        
                
                
                    
                          <?php if (!empty($shifting['Shifting']['reference'])) { ?>
                            <br/>
                            <dt><?php echo __('reference'); ?></dt>
                            <dd>
                                <?php echo h($shifting['Shifting']['reference']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>

                         <?php if (!empty($shifting['Tire']['model'])) { ?>
                            <br/>
                            <dt><?php echo __('Tire'); ?></dt>
                            <dd>
                                <?php echo h($shifting['Tire']['model']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>

						
                        <?php if (!empty($shifting['Position']['name'])){?> 
                        </br>
                        <dt><?php echo  __('Position'); ?></dt>
                        <dd>
                            <?php echo $shifting['Position']['name']; ?>
                            &nbsp;
                        </dd>
						
                        <?php  } ?>

                            <?php if (!empty($shifting['Location']['name'])){?> 
                        </br>
                        <dt><?php echo  __('Location'); ?></dt>
                        <dd>
                            <?php echo $shifting['Location']['name']; ?>
                            &nbsp;
                        </dd>
						
                        <?php  } ?>

                        
                            <?php if (!empty($shifting['Shifting']['shifting_date'])){?> 
                        </br>
                        <dt><?php echo  __('Shifting date'); ?></dt>
                       
                            <dd><?php echo $this->Time->format($shifting['Shifting']['shifting_date'], '%d-%m-%Y'); ?>&nbsp;</dd>
                        
						
                        <?php  } ?>
                        
                            <?php if (!empty($shifting['Car']['code'])){?> 
                        </br>
                        <dt><?php echo  __('Car'); ?></dt>
                       
                             <dd><?php echo $shifting['Car']['code'] . " - " . $shifting['Carmodel']['name']; ?></dd>
                        
						
                        <?php  } ?>
                       
						


                       
                        <?php if (isset($shifting['Shifting']['note']) && !empty($shifting['Shifting']['note'])) { ?>

                         <br/>
                        <dt><?php echo __('Note'); ?></dt>
                        <dd>
                            <?php echo h($shifting['Shifting']['note']); ?>
                            &nbsp;
                        </dd>
                        <?php } ?>


                      
                    </dl>
                    
                

        

    


          
				
				
			
    </div>


  
</div>

