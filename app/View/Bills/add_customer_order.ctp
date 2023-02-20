<?php

$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
$this->end();?>
 <?=__('Add customer order'); ?>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('Bill' , array('onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body" >
            <?php
                    echo "<div class='form-group'>".$this->Form->input('reference', array(
                    'label' => __('Reference'),
                    'class' => 'form-control',
                    
                    'placeholder' =>__('Enter reference'),
                    ))."</div>";

                
               $current_date=date("Y-m-d");     
             echo "<div class='form-group'>" . $this->Form->input('date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'value'=>$this->Time->format($current_date, '%d/%m/%Y'),
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Date') . '</label><div class="input-group date"><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'date',
                            )) . "</div>";
		            echo "<div class='form-group'>".$this->Form->input('supplier_id', array(
                    'label' => __('Customer'),
                    'empty' =>'',
                    'id'=>'client',
                    'class' => 'form-control select2',
                    ))."</div>";
					echo "<div class='form-group'>" . $this->Form->input('nb_product', array(
                    'label' =>'',
                    'type' => 'hidden',
                    'value' =>0,
                    'id' =>'nb_product',
                    'empty' => ''
                )) . "</div>";
					
            ?>
			
				<table   id='dynamic_field' style="width: 100%;" >
		
		<tr>
			<td>
				<?php
					$i=0;
					
					echo "<div class='form-group'>".$this->Form->input('BillProduct.'.$i.'.product_id', array(
                    'label' => __('Product'),
                    'empty' =>'',
					'onchange'=>'javascript:getQuantityProduct(this.id);',
					'id'=>'product0',
                    'class' => 'form-control select2',
                    ))."</div>";
					
                    echo "<div class='form-group' id='quantity$i'>".$this->Form->input('BillProduct.'.$i.'.quantity', array(
                    'label' => __('Quantity'),
                    
                    'type'=>'number',
                    'placeholder' =>__('Enter quantity'),
                    'class' => 'form-control '
                    ))."</div>";
					
				
				?>
			</td>
			
			<td class="td_tab">
			<button style="position: relative; left: -120px;" type='button' name='add' id='add' onclick="addOtherProduct(<?php echo $i?>)"class='btn btn-success'><?=__('Add more')?></button>
			</td>
		</tr>
		</table>
						
                        <div style='clear:both;'></div>

                 <?php  echo "<div  class='form-group'>" . $this->Form->input('note', array(
                    'label' => __('Note'),
                    'class' => 'form-control',
                )) . "</div>";
                ?>
	

				</div>
             
                
			
					

                   

                   
       
             </div>
			 
<div style="clear:both;"></div>
<div class="box-footer">
         <?php echo $this->Form->submit(__('Save'), array(
                    'name' => 'ok',
                    'class' => 'btn btn-primary btn-bordred  m-b-5 ',
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

 
function getQuantityProduct(id){
var num = id.substring(id.length-1,id.length) ;
var product_id=jQuery("#product"+''+num+''+"").val();
jQuery("#quantity"+''+num+''+"").load("<?php echo $this->Html->url('/bills/addQuantityProduct/')?>"+ num+'/'+product_id);
}

function addOtherProduct(id){
	i= jQuery("#nb_product").val();
  	i++;
			
		$('#dynamic_field').append('<tr id="row'+i+'"><td ></td></tr>');
		
			
		jQuery("#nb_product").val(i);	
		
		
		
		jQuery("#row"+''+i+'').load('<?php echo $this->Html->url('/bills/addOtherProduct/')?>' +
		+i);
  }
  
function remove(id) {

				$('#row'+id+'').remove();
					i--;		
			};








</script>

<?php $this->end(); ?>