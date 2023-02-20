<h4 class="page-title"> <?=__('Fuel logs'); ?></h4>
<div class="box-body">
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
    <div class="row" style="clear:both">
        <div class="btn-group pull-left">
            <div class="header_actions">
    <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>'.__('Add'),
            array('action' => 'add'),
            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                <?php
                if ($hasTreasuryModule == 1) {
                echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Regulation'),
                'javascript:addPayment("11");',
                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'payment'));

                } ?>
    <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>'.__('Delete'),
                                'javascript:submitDeleteForm("/fuellogs/deletefuellogs/");',
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                    'disabled' => 'true'), 
                                __('Are you sure you want to delete selected fuel logs ?')); ?>

            </div>
        </div>
        <div style='clear:both; padding-top: 10px;'></div>
    </div>
   </div>
   </div>
   </div>
    
    <?= $this->Form->input('controller', array(
        'id'=>'controller',
        'value'=>   $this->request->params['controller'],
        'type'=>'hidden'
    )); ?>

    <?= $this->Form->input('action', array(
        'id'=>'action',
        'value'=>   'liste',
        'type'=>'hidden'
    )); ?>

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="bloc-limit btn-group pull-left">
                    <div>
                        <label>
                            <?php
                            if (isset($this->params['pass']['0'])) $limit = $this->params['pass']['0'];
                            ?>
                            <select name="slctlimit" id="slctlimit" onchange="slctlimitChanged('fuelLogs/index');">
                                <option value="20" <?php if ($limit == 20) echo 'selected="selected"' ?>>20</option>
                                <option value="25" <?php if ($limit == 25) echo 'selected="selected"' ?>>25</option>
                                <option value="50" <?php if ($limit == 50) echo 'selected="selected"' ?>>50</option>
                                <option value="100" <?php if ($limit == 100) echo 'selected="selected"' ?>>100</option>
                            </select>&nbsp; <?= __('records per page') ?>

                        </label>
                    </div>


                </div>
	<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"                            cellspacing="0" width="100%">
	<thead>
	<tr>
            <th style="width: 10px"> 
                    <button type="button" id ='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
                </th>
                <th><?php echo  __('Num bill'); ?></th>
                <th><?php echo  __('Num fuellog'); ?></th>
                <th><?php echo  __('Date'); ?></th>
               
			<th><?php echo  __('First number coupon'); ?></th>
			<th><?php echo  __('Last number coupon'); ?></th>
			<th><?php echo  __('Nb total coupon'); ?></th>
            <th><?php echo  __('Nb used coupon'); ?></th>
            <th><?php echo  __('Nb stayed coupon'); ?></th>
            <th><?php echo  __('Price'); ?></th>
            <th><?php echo  __('Price remaining'); ?></th>

			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody id="listeDiv">
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
                <td><?php echo h($fuellog['FuelLog']['num_fuellog']); ?>&nbsp;</td>
                <td><?php echo $this->Time->format($fuellog['FuelLog']['date'], '%d-%m-%Y');; ?>&nbsp;</td>
		        <td><?php echo h($fuellog['FuelLog']['first_number_coupon']); ?>&nbsp;</td>
                <td><?php echo h($fuellog['FuelLog']['last_number_coupon']); ?>&nbsp;</td>
                <td><?php $total=$total+$fuellog[0]['total_coupon']; echo h($fuellog[0]['total_coupon']); ?>&nbsp;</td>
                <td><?php $used=$used+ $fuellog[0]['coupon_used'];      echo h($fuellog[0]['coupon_used']); ?>&nbsp;</td>
                <td><?php $stayed_coupon=$fuellog[0]['total_coupon']-$fuellog[0]['coupon_used']; $stayed=$stayed+$stayed_coupon; echo h($stayed_coupon); ?>&nbsp;</td>
        <td><?php echo number_format($fuellog['FuelLog']['price'], 2, ",", $separatorAmount) ; ?>
            &nbsp;</td>
        <td><?php echo number_format($fuellog['FuelLog']['price_remaining'], 2, ",", $separatorAmount) ; ?>
            &nbsp;</td>

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

                <div id="pagination" class="pull-right">
                    <?php
                    if ($this->params['paging']['FuelLog']['pageCount'] > 1) {
                        ?>
                        <p>
                            <?php
                            echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?>    </p>
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php
                                echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                echo $this->Paginator->numbers(array(
                                    'tag' => 'li',
                                    'first' => false,
                                    'last' => false,
                                    'separator' => '',
                                    'currentTag' => 'a'));
                                echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>

            </div>
		</div>
		</div>
</div>
<div class="card-box">

    <h4 class="header-title m-t-0 m-b-30"><i class="zmdi zmdi-notifications-none m-r-5"></i> <?php echo __('Totals') ?></h4>

    <ul class="list-group m-b-0 user-list">
        <?php
        echo "<li class='list-group-item'>
            <a href='#' class='user-list-item'>
                <div class='avatar text-center'>
                    <i class='zmdi zmdi-circle text-success'></i>
                </div>
                <div class='user-desc'>
                    <span class='name'><strong>" .__('Nb total coupon') . "</strong> : $total " . __('Coupons') . "</span>
                </div>
            </a>
        </li>";

        echo "<li class='list-group-item'>
            <a href='#' class='user-list-item'>
                <div class='avatar text-center'>
                    <i class='zmdi zmdi-circle text-success'></i>
                </div>
                <div class='user-desc'>
                    <span class='name'><strong>" .__('Nb used coupon') . "</strong> : $used " . __('Coupons') . "</span>
                </div>
            </a>
        </li>";

        echo "<li class='list-group-item'>
            <a href='#' class='user-list-item'>
                <div class='avatar text-center'>
                    <i class='zmdi zmdi-circle text-success'></i>
                </div>
                <div class='user-desc'>
                    <span class='name'><strong>" .__('Nb stayed coupon') . "</strong> : $stayed " . __('Coupons') . "</span>
                </div>
            </a>
        </li>";
         ?>
 
           
        
    </ul>

</div>

<?php $this->start('script'); ?>

<script type="text/javascript">     $(document).ready(function() {      });





	
	

</script>
<?php $this->end(); ?>
