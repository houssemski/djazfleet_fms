   <table  class="table table-striped table-bordered dt-responsive nowrap"                            >
                                <thead>
	                             <tr>
			<th><?php echo  __('Promotion %'); ?></th>
            <th><?php echo __('Promotion valeur'); ?></th>
			 <th><?php echo  __('Start date'); ?></th>
			 <th><?php echo  __('End date'); ?></th>
            
	</tr>
	</thead>
	<tbody>
    <tr>
    <?php if(!empty($promotions)) {
	
	?>
	
    <?php  foreach($promotions as $promotion) { ;?>
    <td><?php echo h($promotion['Promotion']['promotion_pourcentage']); ?>&nbsp;</td>
    <td><?= number_format($promotion['Promotion']['promotion_val'], 2, ",", ".") .' '. $this->Session->read("currency");?></td>
    <td><?php echo h($this->Time->format($promotion['Promotion']['start_date'], '%d-%m-%Y')); ?>&nbsp;</td>

    <td><?php echo h($this->Time->format($promotion['Promotion']['end_date'], '%d-%m-%Y')); ?>&nbsp;</td>
       
	</tr>
    <?php 
		
	} } ?>
    </tbody>
</table>


