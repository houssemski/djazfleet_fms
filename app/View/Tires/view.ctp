
<div class="box-body main">
    <?php
     
        ?><h4 class="page-title"> <?=$tire['Tire']['model'] ;?></h4>
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
        <?= $this->Html->link(
            '<i class="fa fa-edit m-r-5 m-r-5"></i>' . __("Edit"),
            array('action' => 'Edit', $tire['Tire']['id']),
            array('escape' => false, 'class'=>"btn btn-primary btn-bordred waves-effect waves-light m-b-5")
        ); ?>
        <?= $this->Form->postLink(
            '<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __("Delete"),
            array('action' => 'Delete', $tire['Tire']['id']),
            array('escape' => false, 'class'=>"btn btn-inverse btn-bordred waves-effect waves-light m-b-5"),
            __('Are you sure you want to delete %s?', $tire['Tire']['model'])); ?>

    

       

        <div style="clear: both"></div>
    </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
    <div class="left_side card-box p-b-0">
        <div class="nav-tabs-custom pdg_btm">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
                <li><a href="#tab_2" data-toggle="tab"><?= __('Purchase') ?></a></li>
                
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                
                    
                          <?php if (!empty($tire['Tire']['code'])) { ?>
                            <br/>
                            <dt><?php echo __('Code'); ?></dt>
                            <dd>
                                <?php echo h($tire['Tire']['code']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>

						</br>

                        <dt><?php echo  __('Model'); ?></dt>
                        <dd>
                            <?php echo $tire['Tire']['model']; ?>
                            &nbsp;
                        </dd>
						</br>
						 <dt><?php echo  __('Mark'); ?></dt>
                        <dd>
                            <?php echo $tire['TireMark']['name']; ?>
                            &nbsp;
                        </dd>
                   


                       
                        <?php if (isset($tire['Tire']['note']) && !empty($tire['Tire']['note'])) { ?>

                         <br/>
                        <dt><?php echo __('Note'); ?></dt>
                        <dd>
                            <?php echo h($tire['Tire']['note']); ?>
                            &nbsp;
                        </dd>
                        <?php } ?>


                      
                    </dl>
                    
                </div>

                <div class="tab-pane" id="tab_2">
                
                
                            
							<?php if (!empty($tire['Supplier']['name'])) { ?>
                            <br/>
                            <dt><?php echo __('Supplier'); ?></dt>
                            <dd>
                                <?php echo h($tire['Supplier']['name']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
							
					  <?php if (!empty($tire['Tire']['purchase_date'])) { ?>
							</br>
                            <dt><?php echo __('Purchase date'); ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($tire['Tire']['purchase_date'], '%d-%m-%Y')); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
            
                        <?php if (!empty($tire['Tire']['cost'])) { ?>
                            <br/>
                            <dt><?php echo __('Cost'); ?></dt>
                            <dd>
                                <?php echo h($tire['Tire']['cost']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
						
						
						      <?php if (!empty($tire['Tire']['attachment'])) { ?>
                          <br/>  
            <dt><?php echo __('Attachment'); ?></dt>
            <dd>
                 
				<?= $this->Html->Link($tire['Tire']['attachment'],
                                    'attachments/suppliers/' . $tire['Tire']['attachment'],
                                    array('class' => 'attachments', 'target' => '_blank')
                                ); ?>
            </dd>
        <?php } ?>

                </div>

    


          
				
				
				
            </div>
        </div>
    </div>


  
</div>

