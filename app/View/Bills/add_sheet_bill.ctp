<?php

?><h4 class="page-title"> <?=__('Add invoice'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('Bill' , array('onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">
        <h2  > Fiche Trajet N	&deg;: <?=  $sheetRide['SheetRide']['num_sheet'] ?></h2><br/><br/>
        
            <div>
        <div class="col-sm-6 ">
        <div class="bill">
        <h3><?= __('Ride') ?> </h3>
        <p><?= __('Wording') ?>  :  <?=  $sheetRide['Ride']['wording'] ?></p>
        <p><?= __('Ride') ?>  :  <?=  $sheetRide['Ride']['departure_place'] .'-'.$sheetRide['Ride']['arrival_place'] ?></p>
        
        <p><?= __('Distance') ?>  :  <?=  $sheetRide['Ride']['distance'] ?></p>
        </div>
        </div>
        <div class="col-sm-6 ">
        <div class="bill">
        
        <h3><?= __('Client') ?> </h3>
        <p><?= __('Name') ?>  :  <?=  $sheetRide['Supplier']['name'] ?></p>
        <p><?= __('Adress') ?>  :  <?=  $sheetRide['Supplier']['adress'] ?></p>
        <p><?= __('Tel.') ?>  :  <?=  $sheetRide['Supplier']['tel'] ?></p>
        
        </div>
        </div>
        <div style="clear:both;"></div>
            </div>
            
              <div style="margin-top: 45px;">
        <div class="col-sm-6 ">
        <div class="bill">
        <h3><?= __('Car') ?> </h3>
        <p><?= __('Immatricule') ?>  :  <?=  $sheetRide['Car']['immatr_def'] ?></p>
        <p><?= __('Mark') ?>  :  <?=  $sheetRide['Car']['Mark']['name']  ?></p>
        
        
        </div>
        </div>
        <div class="col-sm-6 ">
        <div class="bill">
        
        <h3><?= __('Customer') ?> </h3>
        <p><?= __('Name') ?>  :  <?=  $sheetRide['Customer']['last_name'] .' '. $sheetRide['Customer']['first_name']?></p>
        
        <p><?= __('Tel.') ?>  :  <?=  $sheetRide['Customer']['tel'] ?></p>
        
        </div>
        </div>
        <div style="clear:both;"></div>
            </div>
        <br/>
        <div >
        <h3><?= __('Goods') ?> </h3>
        <table class="table table-bordered1">
            <thead>
	            <tr>
            
             
             <th><?php echo __('Name'); ?></th>
			<th><?php echo  __('Type'); ?></th>
			<th><?php echo  __('Unit'); ?></th>
			<th><?php echo  __('Quantity'); ?></th>
	</tr>
	</thead>
	<tbody>
    <tr>
    <?php  foreach($goods as $good) { ;?>
    <td><?=  $good['Good']['name'] ?></td>
     
    <?php if ($good['Good']['type']==1) {?>
    <td><?=  'Bois' ?></td>

    <?php }?>
      <?php if ($good['Good']['type']==2) {?>
    <td><?=  'Voyage' ?></td>

    <?php }?>
      <?php if ($good['Good']['type']==3) {?>
    <td><?=  'Conteneur' ?></td>

    <?php }?>

    
     <?php if ($good['Good']['unit']==1) {?>
    <td><?=  'M3' ?></td>

    <?php }?>
    <?php if ($good['Good']['unit']==2) {?>
    <td><?=  'Forfait' ?></td>

    <?php }?>
    <?php if ($good['Good']['unit']==3) {?>
    <td><?=  'Tonne' ?></td>

    <?php }?>
   
    <td><?=  $good['GoodsSheetRide']['quantity'] ?></td>
    
    </tr>
    <?php } ?>
    </tbody>
        </table>
        </div>
        <br/>
            <?php

            echo "<div class='form-group'>".$this->Form->input('reference', array(
                    'label' => __('Number sheet'),
                    'class' => 'form-control',
                    'placeholder' =>__('Enter reference'),
                    ))."</div>";

            echo "<div class='form-group'>".$this->Form->input('ride_id', array(
                    
                    'value' =>$sheetRide['Ride']['id'],
                    'class' => 'form-control select2',
                   
                    'type'=>'hidden',
                    ))."</div>";

            echo "<div class='form-group'>".$this->Form->input('supplier_id', array(
                    
                    'value' =>$sheetRide['Supplier']['id'],
                    'class' => 'form-control select2',
                    
                    //'type'=>'hidden',
                    ))."</div>";
            
               echo "<div class='form-group'>" . $this->Form->input('date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Date') . '</label><div class="input-group date"><label for="PriceEndDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'date',
                            )) . "</div>";     


                  $options=array('1'=>__('Payed'),'2'=>__('Not payed'));
                  echo "<div class='form-group'>" . $this->Form->input('status', array(
                                'label' => __('Status'),
                                'class' => 'form-control',
                                'options'=>$options,
                                'empty' => ''
                            )) . "</div>";  
               

            $options=array('1'=>__('Species'),'2'=>__('Transfer'),'3'=>__('Bank check'));
                  echo "<div class='form-group'>" . $this->Form->input('payment_type', array(
                                'label' => __('Payment type'),
                                'class' => 'form-control',
                                'options'=>$options,
                                'empty' => ''
                            )) . "</div>";

             echo "<div class='form-group'>".$this->Form->input('total_ht', array(
                    'label' => __('Total HT'),
                    'class' => 'form-control',
                    'value' =>$sheetRide['SheetRide']['total_ht'],
                    'placeholder' =>__(''),
                    ))."</div>";

             echo "<div class='form-group'>".$this->Form->input('total_ttc', array(
                    'label' => __('Total TTC'),
                    'class' => 'form-control',
                    'value' =>$sheetRide['SheetRide']['total_ttc'],
                    'placeholder' =>__(''),
                    ))."</div>";

		    
              
                    
                  
                   
                  

            
                     
	?>
             </div>
<div class="box-footer">
         <?php echo $this->Form->submit(__('Submit'), array(
                    'name' => 'ok',
                    'class' => 'btn btn-primary btn-bordred  m-b-5',
                    'label' => __('Submit'),
                    'type' => 'submit',
                    'id'=>'boutonValider',
                    'div' => false
                    )); ?>
        <?php echo $this->Form->submit(__('Cancel'), array(
                    'name' => 'cancel',
                    'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                    'label' => __('Cancel'),
                    'type' => 'submit',
                    'div' => false,
                    'formnovalidate' => true
                    )); ?>
        </div>
    </div>

</div>
<?php $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('maskedinput'); ?>
<script type="text/javascript">     $(document).ready(function() {      });

    $( document ).ready(function() {
        jQuery("#date").inputmask("date", {"placeholder": "dd/mm/yyyy"});
    });

 

</script>

<?php $this->end(); ?>
