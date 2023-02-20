<?php

?><h4 class="page-title"> <?=__("Conductor")."s"; ?></h4>
<div class="box-body">
    <?php echo $this->Form->create('Customers', array(
        'url'=> array(
        'action' => 'search'
        ),
        'novalidate' => true
    )); ?>
    <div class="filters" id='filters' style='display: block;'>
        <?php
        echo $this->Form->input('customer_category_id', array(
            'label' => __('Category'),
            'class' => 'form-filter select2',
            'empty' => ''
        ));
        if ($hasParc) {
            
            echo $this->Form->input('parc_id', array(
                        'label' => __('Parc'),
                        'class' => 'form-filter select2',
                        'id' => 'parc',
                        'empty' => ''
                    ));

        }
         echo "<div style='clear:both; padding-top: 40px;'></div>";

        echo '<div class="lbl"> <a href="#demo" data-toggle="collapse">'.__("  Administration").'</a></div>';

        ?>
          

<div id="demo" class="collapse">
 <div style="clear:both; padding-top: 0px;padding-left: 20px;  border-bottom: 1px solid rgb(204, 204, 204);margin-bottom: 15px;"></div>


        <?php

        echo $this->Form->input('user_id', array(
            'label' => __('Created by'),
            'class' => 'form-filter select2',
            'empty' => ''
        ));


        echo $this->Form->input('created', array(
            'label' => '',
            'type' => 'text',
            'class' => 'form-control datemask',
            'before' => '<label class="dte">' . __('From date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
            'after' => '</div>',
            'id' => 'startdate',
        ));
        echo $this->Form->input('created1', array(
            'label' => '',
            'type' => 'text',
            'class' => 'form-control datemask',
            'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
            'after' => '</div>',
            'id' => 'enddate',
        ));

        echo "<div style='clear:both; padding-top: 10px;'></div>";
        echo $this->Form->input('modified_id', array(
            'options' => $users,
            'label' => __('Modified by'),
            'class' => 'form-filter select2',
            'empty' => ''
        ));

        echo $this->Form->input('modified', array(
            'label' => '',
            'type' => 'text',
            'class' => 'form-control datemask',
            'before' => '<label class="dte">' . __('From date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
            'after' => '</div>',
            'id' => 'startdatemodifie',
        ));
        echo $this->Form->input('modified1', array(
            'label' => '',
            'type' => 'text',
            'class' => 'form-control datemask',
            'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
            'after' => '</div>',
            'id' => 'enddatemodifie',
        ));






        ?>
        <div style='clear:both; padding-top: 10px;'></div>
        </div>
        <button class="btn btn-default" type="submit"><?= __('Search') ?></button>
        <div style='clear:both; padding-top: 10px;'></div>
    </div>
    <?php echo $this->Form->end(); ?>

    <div class="row" style="clear:both">






        <div class="row">
            <!-- BASIC WIZARD -->
            <div class="col-lg-12">
                <div class="card-box p-b-0">

        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
               cellspacing="0" width="100%">
	<thead>
	<tr>
            
            <th><?php echo  __('Code'); ?></th>
			<th><?php echo  __('First name'); ?></th>
			<th><?php echo __('Last name'); ?></th>
            <th><?php echo __('Driver license expiration date').' '.__('Category A'); ?></th>
            <th><?php echo __('Driver license expiration date').' '.__('Category B'); ?></th>
            <th><?php echo __('Driver license expiration date').' '.__('Category C'); ?></th>
            <th><?php echo __('Driver license expiration date').' '.__('Category D'); ?></th>
            <th><?php echo __('Driver license expiration date').' '.__('Category E'); ?></th>
            <th><?php echo __('Driver license expiration date').' '.__('Category F'); ?></th>

			
			<th class="mob"><?php echo  __('Mobile'); ?></th>
			
			<th><?php echo  __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($customers as $customer): ?>
	<tr id="row<?= $customer['Customer']['id'] ?>">
         
        <td><?php echo h($customer['Customer']['code']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['first_name']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['last_name']); ?>&nbsp;</td>
        
        <td><?php echo h($this->Time->format($customer['Customer']['driver_license_expires_date1'], '%d-%m-%Y'));?>&nbsp;</td>
        <td><?php echo h($this->Time->format($customer['Customer']['driver_license_expires_date2'], '%d-%m-%Y'));?>&nbsp;</td>
        <td><?php echo h($this->Time->format($customer['Customer']['driver_license_expires_date3'], '%d-%m-%Y'));?>&nbsp;</td>
        <td><?php echo h($this->Time->format($customer['Customer']['driver_license_expires_date4'], '%d-%m-%Y'));?>&nbsp;</td>
        <td><?php echo h($this->Time->format($customer['Customer']['driver_license_expires_date5'], '%d-%m-%Y'));?>&nbsp;</td>
        <td><?php echo h($this->Time->format($customer['Customer']['driver_license_expires_date6'], '%d-%m-%Y'));?>&nbsp;</td>
		
		<td><?php echo h($customer['Customer']['mobile']); ?>&nbsp;</td>
		<td class="actions">
            <?= $this->Html->link(
                '<i class="fa fa-eye m-r-5" title="'.__('View').'"></i>',
                array('action' => 'View', $customer['Customer']['id']),
                array('escape' => false)
            ); ?>
            <?= $this->Html->link(
                '<i class="fa fa-edit m-r-5" title="'.__('Edit').'"></i>',
                array('action' => 'Edit', $customer['Customer']['id']),
                array('escape' => false)
            ); ?>

            <?php

                if($customer['Customer']['locked'] == 1){
                    echo $this->Html->link(
                        '<i class="fa  fa-lock m-r-5" title="'.__('Unlock').'"></i>',
                        array('action' => 'unlock', $customer['Customer']['id']),
                        array('escape' => false)
                    );
                }else{
                    echo $this->Html->link(
                        '<i class="fa  fa-unlock  m-r-5" title="'.__('Lock').'"></i>',
                        array('action' => 'lock', $customer['Customer']['id']),
                        array('escape' => false)
                    );
                }

            ?>
            <?php echo $this->Form->postLink(
                '<i class="fa fa-trash-o m-r-5 m-r-5" title="'.__('Delete').'"></i>',
                array('action' => 'Delete', $customer['Customer']['id']),
                array('escape' => false),
                __('Are you sure you want to delete %s?', $customer['Customer']['first_name']." ".$customer['Customer']['last_name'])); ?>
        </td>

            </tr>
<?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>
</div>
</div>



