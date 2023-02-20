<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"                            cellspacing="0" width="100%">
	
	<tbody>
    <?php  $total=0;
           $used=0;
           $stayed=0;
             ?>
	<?php foreach ($fuellogs as $fuellog): ?>
	<tr id="row<?= $fuellog['FuelLog']['id'] ?>">
            <td>

                <input id="idCheck"type="checkbox" class = 'id' value=<?php echo $fuellog['FuelLog']['id'] ?> >
                </td>
                <td><?php echo h($fuellog['FuelLog']['num_bill']); ?>&nbsp;</td>
                <td><?php echo h($fuellog['FuelLog']['nb_fuellog']); ?>&nbsp;</td>
                <td><?php echo h($fuellog['FuelLog']['num_fuellog']); ?>&nbsp;</td>
                <td><?php echo $this->Time->format($fuellog['FuelLog']['date'], '%d-%m-%Y');; ?>&nbsp;</td>
                <td><?php echo h($fuellog['FuelLog']['price_coupon']); ?>&nbsp;</td>
		        <td><?php echo h($fuellog['FuelLog']['first_number_coupon']); ?>&nbsp;</td>
                <td><?php echo h($fuellog['FuelLog']['last_number_coupon']); ?>&nbsp;</td>
                <td><?php $total=$total+$fuellog[0]['total_coupon']; echo h($fuellog[0]['total_coupon']); ?>&nbsp;</td>
                <td><?php $used=$used+ $fuellog[0]['coupon_used'];      echo h($fuellog[0]['coupon_used']); ?>&nbsp;</td>
                <td><?php $stayed_coupon=$fuellog[0]['total_coupon']-$fuellog[0]['coupon_used']; $stayed=$stayed+$stayed_coupon; echo h($stayed_coupon); ?>&nbsp;</td>
		<td class="actions">

            <div  class="btn-group ">
                <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                    <i class="fa fa-list fa-inverse"></i>
                </a>
                <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                    <span class="caret"></span>
                </button>

                <ul class="dropdown-menu" style="min-width: 70px;">

                    <li>
                        <?= $this->Html->link(
                            '<i   class="fa fa-eye" title="' . __('View') . '"></i>',
                            array('action' => 'View', $fuellog['FuelLog']['id']),
                            array('escape' => false, 'class'=>'btn btn-success')
                        ); ?>
                    </li>

                    <li>
                        <?= $this->Html->link(
                            '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                            array('action' => 'Edit',  $fuellog['FuelLog']['id']),
                            array('escape' => false , 'class'=>'btn btn-primary')
                        ); ?>
                    </li>

                    <li>
                        <?php
                        echo $this->Form->postLink(
                            '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                            array('action' => 'delete',  $fuellog['FuelLog']['id']),
                            array('escape' => false , 'class'=>'btn btn-danger'),
                            __('Are you sure you want to delete %s?',$fuellog['FuelLog']['num_bill'])); ?>
                    </li>
                </ul>
            </div>


                </td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>