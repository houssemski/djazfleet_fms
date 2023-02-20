<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"                            cellspacing="0" width="100%">
	
	<tbody>
	<?php  foreach ($reservations as $reservation): ?>
	<tr id="row<?= $reservation['Reservation']['id'] ?>">
            <td>
                 <?php if($reservation['Reservation']['amount_remaining']>0) {?>
                <input id="idCheck"type="checkbox" class = 'id' value=<?php echo $reservation['Reservation']['id'] ?> >
                <?php } ?>
                </td>
                <td><?php echo h($reservation['SheetRideDetailRides']['reference']); ?></td>
                <td><?php if ($param==1){
                        echo $reservation['Car']['code']." - ".$reservation['Carmodel']['name'];
                    } else if ($param==2) {
                        echo $reservation['Car']['immatr_def']." - ".$reservation['Carmodel']['name'];
                    } ?></td>
                <td><?php echo h($reservation['Supplier']['name']); ?>&nbsp;</td>


        <td class="right">
            <?php if ($reservation['Reservation']['cost']==0) {?>
                <div class="table-content editable">
                        <span>
                            <?php //echo h(number_format($reservation['Reservation']['cost'], 2, ",", $separatorAmount)); ?>
                        </span>
                    <input name="<?= $this->Reservation->encrypt("cost|".$reservation['Reservation']['id']); ?>"
                           placeholder="<?= __('Enter cost') ?>" value="<?= $reservation['Reservation']['cost'] ?>"
                           class="form-control table-input cost" type="number">
                </div>
            <?php }else {
                echo h(number_format($reservation['Reservation']['cost'], 2, ",", $separatorAmount));
            } ?>

        </td>
        <td><?php echo  h(number_format($reservation['Reservation']['amount_remaining'], 2, ",", $separatorAmount))?></td>


		<td><?php if (!empty($reservation['SheetRideDetailRides']['real_start_date'])){
                echo h($this->Time->format($reservation['SheetRideDetailRides']['real_start_date'], '%d-%m-%Y %H:%M'));
            }else {
                echo h($this->Time->format($reservation['SheetRideDetailRides']['planned_start_date'], '%d-%m-%Y %H:%M'));
            } ?>&nbsp;</td>
        <td><?php if (!empty($reservation['SheetRideDetailRides']['real_end_date'])){
                echo h($this->Time->format($reservation['SheetRideDetailRides']['real_end_date'], '%d-%m-%Y %H:%M'));
            }else {
                echo h($this->Time->format($reservation['SheetRideDetailRides']['planned_end_date'], '%d-%m-%Y %H:%M'));
            } ?>&nbsp;</td>
        <td><?php switch ($reservation['Reservation']['status']) {
                case 1:
                    echo '<span class="label label-danger">';
                    echo __('Not paid') . "</span>";
                    break;
                case 2:
                    echo '<span class="label label-success">';
                    echo __('Paid') . "</span>";
                    break;

            } ?>&nbsp;</td>




	</tr>
<?php endforeach; ?>
	</tbody>
	</table>

<div id='pageCount' class="hidden">
<?php
if($this->params['paging']['Reservation']['pageCount'] > 1){
?>
<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
<div class="box-footer clearfix">
    <ul class="pagination pagination-sm no-margin pull-left">
	<?php
		echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
		echo $this->Paginator->numbers(array(
                    'tag' => 'li', 
                    'first' => false, 
                    'last' => false, 
                    'separator' => '',
                    'currentTag' => 'a'));
		echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
	?>
    </ul>
</div>
<?php } ?>

    </div>
                