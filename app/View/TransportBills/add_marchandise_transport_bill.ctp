

				<td>
				
                    <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 dlt"></i>',
                    'javascript:DeleteProduct(this.id);',
                    array('escape' => false,'id' => 'delete_product'.$i, 'onclick' => 'javascript:DeleteMarchandise(this.id);'));  ?>
                </td>
            <td> <?php  echo "<div class='form-group  products' >" . $this->Form->input('MarchandisesTransportBill.'.$i.'.marchandise_id', array(
                    'label' => '',
                    'class' => 'form-control',
					'id' =>'marchandise_name'.$i,
                    'onchange' => 'javascript:getInformationMarchandise(this.id);',
                    'empty'=>'',
                )) . "</div>"; ?>
               <div id='info_marchandise<?php echo $i ?>'></div>
            </td>
            <td><div id ='qty_min<?php echo $i?>'style="margin-top: 25px;"><span style="float: right;">0.00</span></div>
            </td>
		    <td><div id ='unit_price<?php echo $i ?>'style="margin-top: 25px;"><span style="float: right;">0.00</span></div>


            </td>
            
            <td>  
				
				 <?php  echo "<div  >" . $this->Form->input('MarchandisesTransportBill.'.$i.'.quantity', array(
                    'label' => '',
					'type'=>'number',
                    'class' => 'form-control',
					'id' =>'quantity'.$i,
                    'onchange' => 'javascript:calculPrice(this.id);',
                    
                )) . "</div>"; ?>

            
  
            </td>
			<td>
                <?php  echo "<div  >" . $this->Form->input('MarchandisesTransportBill.'.$i.'.price_ht', array(
                    'label' => '',
					'type'=>'hidden',
                    'class' => 'form-control',
					'id' =>'price_ht'.$i,
                    
                    
                )) . "</div>"; ?>


                <div id ='total_ht<?php echo $i ?>'style="margin-top: 25px;"><span style="float: right;">0.00</span></div></td>
			<td>
                	<?php  echo "<div style='width: 100px;'>" . $this->Form->input('MarchandisesTransportBill.'.$i.'.price_tva', array(
                    'label' => '',
					'type'=>'hidden',
                    'class' => 'form-control',
					'id' =>'price_tva'.$i,
                    
                    
                )) . "</div>";

                 echo "<div style='width: 100px;'>" . $this->Form->input('MarchandisesTransportBill.0.tva_id', array(
                    'label' => '',
					'type'=>'select',
                    'class' => 'form-control',
					'id' =>'tva'.$i,
                    'options'=>$tvas,
                    'onchange' => 'javascript:calculPrice(this.id);',
                    
                )) . "</div>";




 ?></td>
			<td>
                <?php  echo "<div  >" . $this->Form->input('MarchandisesTransportBill.'.$i.'.price_ttc', array(
                    'label' => '',
				     'type'=>'hidden',
                    'class' => 'form-control',
					'id' =>'price_ttc'.$i,
                    
                    
                )) . "</div>"; ?>

            <div id ='total_ttc<?php echo $i ?>'style="margin-top: 25px;"><span style="float: right;">0.00</span></div></td>
		