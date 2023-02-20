<style> 
.form-date div.input {
	width : 300px;
}
.form-date .input-group{
	width : 85% !important; 
}
.total {
padding-bottom: 3px;
}
</style>
<h4 class="page-title"> <?= __('Search'); ?></h4>
<?php

$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
$this->end();

?>
<div id="msg" name="msg"></div>
<div class="box-body">

    <div class="panel-group wrap" id="bs-collapse">

        <div class="panel loop-panel">
            <a class="collapsed fltr" data-toggle="collapse" data-parent="#" href="#one">
                <i class="zmdi zmdi-search-in-page"></i>
            </a>
            <a class="collapsed grp_actions_icon fltr" data-toggle="collapse" data-parent="#" href="#grp_actions">
                <i class="fa fa-toggle-down"></i>
            </a>
            <div id="one" class="panel-collapse collapse">
                <div class="panel-body">

                    <?php echo $this->Form->create('Bills', array(
                        'url' => array(
                            'action' => 'search'
                        ),
                        'novalidate' => true
                    )); ?>

                    <div class="filters" id='filters'>

                        <?php

                        if (
                            $type == BillTypesEnum::commercial_bills_list ||
                            $type == BillTypesEnum::commercial_bills_list ||
                            $type == BillTypesEnum::special_bills_list
                        ) {
                            echo $this->Form->input('supplier_id', array(
                                'label' => __('Supplier'),
                                'class' => 'form-filter select2',
                                'id' => 'supplier',
                                'empty' => ''
                            ));
                        }
                        if ($type == BillTypesEnum::delivery_order ||
                            $type == BillTypesEnum::exit_order ||
                            $type == BillTypesEnum::return_customer ||
                            $type == BillTypesEnum::reintegration_order ||
                            $type == BillTypesEnum::quote ||
                            $type == BillTypesEnum::customer_order ||
                            $type == BillTypesEnum::sales_invoice  ||
                            $type == BillTypesEnum::sale_credit_note ||
                            $type == BillTypesEnum::sale_invoices_list ||
                            $type == BillTypesEnum::commercial_bills_list ||
                            $type == BillTypesEnum::special_bills_list
                        ) {
                            echo $this->Form->input('client_id', array(
                                'label' => __('Client'),
                                'class' => 'form-filter select2',
                                'id' => 'client',
                                'empty' => ''
                            ));
                        }
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('product_id', array(
                            'label' => __('Product'),
                            'class' => 'form-filter select2',
                            'id' => 'client',
                            'empty' => ''
                        ));

                        $options = array('1'=>'Non réglé','2'=>'Partiellement réglé','3'=>'Réglé');
                        echo $this->Form->input('reglement_id', array(
                            'label' => __('Règlement'),
                            'class' => 'form-filter select2',
                            'options'=>$options,
                            'id' => 'reglement',
                            'empty' => ''
                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";


                        echo $this->Form->input('transport_bill_category_id', array(
                            'label' => __('Category'),
                            'class' => 'form-filter select2',
                            'id' => 'category',
                            'empty' => ''
                        ));
						
							switch($type){
			case BillTypesEnum::commercial_bills_list :
                $options = array(BillTypesEnum::receipt =>__('Receipts'), 
								BillTypesEnum::delivery_order =>__('Delivery orders'),
								BillTypesEnum::return_supplier =>__('Return supplier'), 
								BillTypesEnum::return_customer=>__('Return customer'),
								BillTypesEnum::commercial_bills_list=>__('Commercial stock journal'),
								);
				echo $this->Form->input('type', array(
                            'value' => $type,
							'options'=>$options,
							'class' => 'form-filter select2',
                            'id' => 'type',
                            'empty' => ''
                        ));
                break;
            case BillTypesEnum::special_bills_list :
                $options = array(	BillTypesEnum::entry_order =>__('Entry order'), 
									BillTypesEnum::exit_order =>__('Exit order'),
									BillTypesEnum::renvoi_order =>__('Renvoi order'), 
									BillTypesEnum::reintegration_order=>__('Reintegration order') ,
									BillTypesEnum::special_bills_list=>__('Special stock journal') ,
				);
				
				echo $this->Form->input('type', array(
                            'value' => $type,
							'options'=>$options,
							'class' => 'form-filter select2',
                            'id' => 'type',
                            'empty' => ''
                        ));
                break;
            case BillTypesEnum::purchase_invoices_list :
                $options = array(	BillTypesEnum::purchase_invoice =>__('Purchase invoice'), 
									BillTypesEnum::credit_note=>__('Credit note'),
									BillTypesEnum::purchase_invoices_list=>__('Newspaper purchases'),
									);
				
				echo $this->Form->input('type', array(
                            'value' => $type,
							'options'=>$options,
							'class' => 'form-filter select2',
                            'id' => 'type',
                            'empty' => ''
                        ));
                break;    
				
			case BillTypesEnum::sale_invoices_list :
                $options = array(	BillTypesEnum::sales_invoice =>__('Invoices'), 
									BillTypesEnum::sale_credit_note =>__('Sale credit note'),
									BillTypesEnum::sale_invoices_list =>__('Newspaper sales'),
									);
				
				echo $this->Form->input('type', array(
                            'value' => $type,
							'options'=>$options,
							'class' => 'form-filter select2',
                            'id' => 'type',
                            'empty' => ''
                        ));
                break;
				
				default :
				echo $this->Form->input('type', array(
                            'value' => $type,
							'type'=>'hidden',
                            'id' => 'type',
                            'empty' => ''
                        ));
		}

                       

					   echo "<div style='clear:both; padding-top: 10px;'></div>"; ?>

                      <div class="btn-group btn-period">
                            <a data-toggle="dropdown" class="btn btn-inverse" style="height: 35px; margin-top: 8px">
                                <i class="fa "
                                   style="padding-top: 4px;font-weight: bold; font-family: 'Roboto', sans-serif;"><?php echo __('Period') ?></i>
                            </a>
                            <button href="#" data-toggle="dropdown" class="btn btn-inverse dropdown-toggle share"
                                    style="height: 35px; margin-top: 8px">
                                <span class="caret"></span>
                            </button>

                            <ul class="dropdown-menu" style="min-width: 70px; margin-top: 45px;margin-left: 50px;">

                                <li>
                                    <?= $this->Html->link(__('Today'), 'javascript:definePeriod("today");',
                                        array('escape' => false, 'id' => 'today')) ?>
                                </li>

                                <li>
                                    <?= $this->Html->link(__('This week'), 'javascript:definePeriod("week");',
                                        array('escape' => false, 'id' => 'week')) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link(__('This month'), 'javascript:definePeriod("month");',
                                        array('escape' => false, 'id' => 'month')) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link(__('This quarter'), 'javascript:definePeriod("quarter");',
                                        array('escape' => false, 'id' => 'quarter')) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link(__('This semester'), 'javascript:definePeriod("semester");',
                                        array('escape' => false, 'id' => 'semester')) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link(__('This year'), 'javascript:definePeriod("year");',
                                        array('escape' => false, 'id' => 'year')) ?>
                                </li>
                            </ul>
                        </div>

					<?php echo "<div class='form-date'>" .$this->Form->input('date1', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask ',
                            'before' => '<div class="input-group date from_date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'date1',
                        )). "</div>";
                        echo $this->Form->input('date2', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'date2',
                        ));
                        if ($isSuperAdmin) {
                            echo "<div style='clear:both; padding-top: 40px;'></div>";

                            echo '<div class="lbl"> <a href="#demo" data-toggle="collapse"><i class="fa fa-search"></i>' . __("  Administrative filter") . '</a></div>';

                            ?>
                            <div id="demo" class="collapse">
                                <div
                                    style="clear:both; padding-top: 0px;padding-left: 20px;  border-bottom: 1px solid rgb(204, 204, 204);margin-bottom: 15px;"></div>
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
                                    'id' => 'startdatecreat',
                                ));
                                echo $this->Form->input('created1', array(
                                    'label' => '',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'enddatecreat',
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
                            </div>
                            <div style='clear:both; padding-top: 10px;'></div>
                        <?php } ?>
                        <button class="btn btn-default" type="submit"><?= __('Search') ?></button>
                        <div style='clear:both; padding-top: 10px;'></div>
                    </div>



                    <?php echo $this->Form->end(); ?>


                </div>

            </div>
        </div>
        <!-- end of panel -->


    </div>
    <!-- end of #bs-collapse  -->

    <div class="row collapse" id="grp_actions">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
									<div id="dialogModalAdvencedPayments">
                                    <!-- the external content is loaded inside this tag -->

									</div>

                            <?php
                            switch ($type) {
                                case BillTypesEnum::supplier_order :
                                    echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                        array('action' => 'Add', $type),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));
                                       if( $permissionTransformationSupplierOrder == 1){ ?>
                                    <div class="btn-group">
                                        <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transform to'),
                                            'javascript:',
                                            array('escape' => false,
                                                'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',
                                                'id' => 'transform',
                                                'disabled' => 'true')) ?>
                                        <button type="button" id="export_allmark"
                                                class="btn dropdown-toggle btn-inverse  btn-bordred"
                                                data-toggle="dropdown">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li>

                                                <?= $this->Html->link(__('Receipt'), 'javascript:transformBills(2);',
                                                    array('escape' => false, 'id' => 'facture', 'class' => 'btn btn-act ', 'disabled' => 'true')) ?>
                                                <?php
                                                echo $this->Form->input('type', array(
                                                    'label' => '',
                                                    'type' => 'text',
                                                    'value' => $type,
                                                    'type' => 'hidden'
                                                ));
                                                ?>
                                            </li>
                                        </ul>
                                    </div>
                                <?php }
                                    break;
                                case BillTypesEnum::receipt :
                                    echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                        array('action' => 'Add', $type),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));
                                    if ($hasTreasuryModule == 1) {
                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Regulation'),
                                            'javascript:verifyIdCustomers("9","addPayment");',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'payment'));
                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Advanced payment'),
                                            'javascript:verifyIdCustomers("9","advancedPayment");',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'advanced_payment'));
                                    } ?>

                                    <div class="btn-group">
                                            <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transform to'),
                                                'javascript:',
                                                array('escape' => false,
                                                    'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',
                                                    'id' => 'transform',
                                                    'disabled' => 'true')) ?>
                                        <button type="button" id="export_allmark"
                                            class="btn dropdown-toggle btn-inverse  btn-bordred"
                                            data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <?= $this->Html->link(__('Purchase invoice'), 'javascript:transformBills(4);',
                                        array('escape' => false, 'id' => 'commande', 'class' => 'btn btn-act ', 'disabled' => 'true')) ?>
                                    <?php
                                    echo $this->Form->input('type', array(
                                        'label' => '',
                                        'type' => 'text',
                                        'value' => $type,
                                        'type' => 'hidden'

                                    ));
                                    ?>
                                </li>
                            </ul>

                        </div>
                        <?php
                        break;
                                case BillTypesEnum::return_supplier :

                                    echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                        array('action' => 'Add', $type),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));

                                    if ($hasTreasuryModule == 1) {

                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Regulation'),
                                            'javascript:verifyIdCustomers("9","addPayment");',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'payment'));
                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Advanced payment'),
                                            'javascript:verifyIdCustomers("9","advancedPayment");',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'advanced_payment'));

                                    }
                                    break;
                                case BillTypesEnum::purchase_invoice :

                                    echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                        array('action' => 'Add', $type),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));

                                    if ($hasTreasuryModule == 1) {

                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Regulation'),
                                            'javascript:verifyIdCustomers("9","addPayment");',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'payment'));
                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Advanced payment'),
                                            'javascript:verifyIdCustomers("9","advancedPayment");',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'advanced_payment'));

                                    }
                                    break;
                                case BillTypesEnum::credit_note :

                                    echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                        array('action' => 'Add', $type),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));
                                    if ($hasTreasuryModule == 1) {

                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Regulation'),
                                            'javascript:verifyIdCustomers("9","addPayment");',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'payment'));
                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Advanced payment'),
                                            'javascript:verifyIdCustomers("9","advancedPayment");',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'advanced_payment'));

                                    }
                                    break;
                                case BillTypesEnum::delivery_order :

                                    echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                        array('action' => 'Add', $type),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));

                                    if ($hasTreasuryModule == 1) {

                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Regulation'),
                                            'javascript:verifyIdCustomers("9","addPayment");',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'payment'));
                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Advanced payment'),
                                            'javascript:verifyIdCustomers("9","advancedPayment");',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'advanced_payment'));

                                    } ?>
                                      <div class="btn-group">
                                            <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transform to'),
                                                'javascript:',
                                                array('escape' => false,
                                                    'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',
                                                    'id' => 'transform',
                                                    'disabled' => 'true')) ?>
                            <button type="button" id="export_allmark"
                                    class="btn dropdown-toggle btn-inverse  btn-bordred"
                                    data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <?= $this->Html->link(__('Invoice'), 'javascript:transformBills(17);',
                                        array('escape' => false, 'id' => 'commande', 'class' => 'btn btn-act ', 'disabled' => 'true')) ?>
                                    <?php
                                    echo $this->Form->input('type', array(
                                        'label' => '',
                                        'type' => 'text',
                                        'value' => $type,
                                        'type' => 'hidden'

                                    ));
                                    ?>
                                </li>
                            </ul>

                        </div>


                    <?php
                        break;
                                case BillTypesEnum::return_customer :

                                    echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                        array('action' => 'Add', $type),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));

                                    if ($hasTreasuryModule == 1) {

                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Regulation'),
                                            'javascript:verifyIdCustomers("9","addPayment");',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'payment'));
                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Advanced payment'),
                                            'javascript:verifyIdCustomers("9","advancedPayment");',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'advanced_payment'));

                                    }
                                    break;
                                case BillTypesEnum::entry_order :

                                    echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                        array('action' => 'Add', $type),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));
                                    break;
                                case BillTypesEnum::exit_order :

                                    echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                        array('action' => 'Add', $type),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));
                                    break;
                                case BillTypesEnum::renvoi_order :

                                    echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                        array('action' => 'Add', $type),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));
                                    break;
                                case BillTypesEnum::reintegration_order :

                                    echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                        array('action' => 'Add', $type),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));
                                    break;
                                case BillTypesEnum::commercial_bills_list :
                                    ?>
                                    <div class="btn-group">
                                        <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'), 'javascript:;',

                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                                        <button type="button" id="export_allmark"
                                                class="btn dropdown-toggle btn-inverse btn-bordred"
                                                data-toggle="dropdown">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">

                                            <li>
                                                <?= $this->Html->link(__('Add receipt'), array('action' => 'add', 2), array('escape' => false)) ?>
                                            </li>

                                            <li>
                                                <?= $this->Html->link(__('Add return supplier'), array('action' => 'add', 3), array('escape' => false)) ?>
                                            </li>
                                            <li>
                                                <?= $this->Html->link(__('Add delivery order'), array('action' => 'add', 6), array('escape' => false)) ?>
                                            </li>
                                            <li>
                                                <?= $this->Html->link(__('Add return customer'), array('action' => 'add', 7), array('escape' => false)) ?>
                                            </li>

                                        </ul>

                                   <?php     if ($hasTreasuryModule == 1) {

                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Regulation'),
                                        'javascript:verifyIdCustomers("9","addPayment");',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'payment'));
                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Advanced payment'),
                                        'javascript:verifyIdCustomers("9","advancedPayment");',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'advanced_payment'));

                                        } ?>
                                    </div>


                                    <?php       break;

                                case BillTypesEnum::special_bills_list :
                                    ?>
                                    <div class="btn-group">
                                        <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'), 'javascript:;',

                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                                        <button type="button" id="export_allmark"
                                                class="btn dropdown-toggle btn-inverse btn-bordred"
                                                data-toggle="dropdown">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">


                                            <li>
                                                <?= $this->Html->link(__('Add entry order'), array('action' => 'add', 8), array('escape' => false)) ?>
                                            </li>

                                            <li>
                                                <?= $this->Html->link(__('Add exit order'), array('action' => 'add', 9), array('escape' => false)) ?>
                                            </li>
                                            <li>
                                                <?= $this->Html->link(__('Add renvoi order'), array('action' => 'add', 10), array('escape' => false)) ?>
                                            </li>
                                            <li>
                                                <?= $this->Html->link(__('Add reintegration order'), array('action' => 'add', 11), array('escape' => false)) ?>
                                            </li>
                                        </ul>

                                    </div>
                                    <?php  break;



                                  case BillTypesEnum::purchase_invoices_list :
                                    ?>
                                    <div class="btn-group">
                                        <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'), 'javascript:;',

                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                                        <button type="button" id="export_allmark"
                                                class="btn dropdown-toggle btn-inverse btn-bordred"
                                                data-toggle="dropdown">
                                            <span class="caret"></span>
											
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">

                                            <li>
                                                <?= $this->Html->link(__('Add purchase invoice'), array('action' => 'add', 4), array('escape' => false)) ?>
                                            </li>

                                            <li>
                                                <?= $this->Html->link(__('Add credit note'), array('action' => 'add', 5), array('escape' => false)) ?>
                                            </li>

                                        </ul>

                                    </div>
                                    <?php  break;
									
									
									
                                  case BillTypesEnum::sale_invoices_list :
                                    ?>
                                    <div class="btn-group">
                                        <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'), 'javascript:;',

                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                                        <button type="button" id="export_allmark"
                                                class="btn dropdown-toggle btn-inverse btn-bordred"
                                                data-toggle="dropdown">
                                            <span class="caret"></span>
											
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">

                                            <li>
                                                <?= $this->Html->link(__('Add invoice'), array('action' => 'add', 17), array('escape' => false)) ?>
                                            </li>

                                            <li>
                                                <?= $this->Html->link(__('Add sale credit note'), array('action' => 'add', 18), array('escape' => false)) ?>
                                            </li>

                                        </ul>

                                    </div>
                                    <?php  
										 if ($hasTreasuryModule == 1) {

                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Regulation'),
                                            'javascript:verifyIdCustomers("9","addPayment");',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'payment'));
                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Advanced payment'),
                                            'javascript:verifyIdCustomers("9","advancedPayment");',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'advanced_payment'));

                                    }
									
									
									break;
									
									
									
									
									case BillTypesEnum::quote :

                                    echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                        array('action' => 'Add', $type),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));
                                    ?>
									 <div class="btn-group">
                                            <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transform to'),
                                                'javascript:',
                                                array('escape' => false,
                                                    'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',
                                                    'id' => 'transform',
                                                    'disabled' => 'true')) ?>
                                            <button type="button" id="export_allmark"
                                                    class="btn dropdown-toggle btn-inverse  btn-bordred"
                                                    data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <?= $this->Html->link(__('Customer order'), 'javascript:transformBills(16);',
                                                        array('escape' => false, 'id' => 'commande', 'class' => 'btn btn-act ', 'disabled' => 'true')) ?>
													<?= $this->Html->link(__('Invoice'), 'javascript:transformBills(17);',
                                                        array('escape' => false, 'id' => 'facture', 'class' => 'btn btn-act ', 'disabled' => 'true')) ?>

                                                    <?php
                                                    echo $this->Form->input('type', array(
                                                        'label' => '',
                                                        'type' => 'text',
                                                        'value' => $type,
                                                        'type' => 'hidden'

                                                    ));
                                                    ?>
                                                </li>
                                            </ul>

                                        </div>
                                        
										
									<?php
									
									break;
									
									case BillTypesEnum::customer_order :

                                    echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                        array('action' => 'Add', $type),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));
                                    break;
									
									case BillTypesEnum::sales_invoice :

                                    echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                        array('action' => 'Add', $type),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));
                                        if ($hasTreasuryModule == 1) {

                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Regulation'),
                                            'javascript:verifyIdCustomers("9","addPayment");',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'payment'));
                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Advanced payment'),
                                            'javascript:verifyIdCustomers("9","advancedPayment");',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'advanced_payment'));

                                    }
									
									break;

                                default :
                                    ?>
                                    <div class="btn-group">
                                        <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'), 'javascript:;',

                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                                        <button type="button" id="export_allmark"
                                                class="btn dropdown-toggle btn-inverse btn-bordred"
                                                data-toggle="dropdown">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">

                                            <li>
                                                <?= $this->Html->link(__('Add receipt'), array('action' => 'add', 2), array('escape' => false)) ?>
                                            </li>

                                            <li>
                                                <?= $this->Html->link(__('Add delivery order'), array('action' => 'add', 6), array('escape' => false)) ?>
                                            </li>

                                        </ul>

                                    </div>


                                    <?php    break;
                            }

                            if($type == BillTypesEnum::purchase_request && $permissionValidation == 1){
                                echo $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Validate'),
                                    'javascript:validateBills();',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'validate'));
                            }
                            echo $this->Html->link('<i class=" fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                'javascript:submitDeleteForm("bills/deletebills/");',
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                    'disabled' => 'true'),
                                __('Are you sure you want to delete selected bills ?'));
                            ?>
                            <div class="btn-group">
                                <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Export'),
                                    'javascript:exportData("bills/export/");',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect w-md waves-light m-b-5', 'id' => 'export', 'disabled' => 'true')) ?>
                                <button type="button" id="export_allmark"
                                        class="btn dropdown-toggle btn-inverse  btn-bordred" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <?= $this->Html->link(__('Export All'), 'javascript:exportAllDataBills("bills/export/all/'.$type.'");') ?>
                                    </li>
                                </ul>

                            </div>
                            <div class="btn-group">
                                <?= $this->Html->link('<i class="fa fa-print m-r-5"></i>' . __('Print'),
                                    'javascript:;',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                                <button type="button" id="export_allmark"
                                        class="btn dropdown-toggle btn-inverse  btn-bordred" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <?= $this->Html->link(__('Simplified journal'), 'javascript:printSimplifiedJournal();') ?>
                                    </li>
									<li>
                                            <?= $this->Html->link(__('Detailed journal'), 'javascript:printDetailedJournal();') ?>
                                    </li>
                                    <li>
                                        <?= $this->Html->link(__('Simplified journal by supplier'), 'javascript:printSimplifiedJournalBySupplier();') ?>
                                    </li>
									<li>
                                            <?= $this->Html->link(__('Simplified journal with detail bill'), 'javascript:printSimplifiedJournalWithDetailBill();') ?>
                                        </li>
                                </ul>
                            </div>

                        </div>
                    
					<div id="dialogModalConditionTransformation">
                                    <!-- the external content is loaded inside this tag -->

                    </div>
					
					</div>
                    <div style='clear:both; padding-top: 10px;'></div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->Form->input('controller', array(
        'id' => 'controller',
        'value' => $this->request->params['controller'],
        'type' => 'hidden'
    )); ?>

    <?= $this->Form->input('action', array(
        'id' => 'action',
        'value' => 'liste',
        'type' => 'hidden'
    )); ?>

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div id="impression">
                    <?php echo $this->Form->create('Bills', array(
                        'url' => array(
                            'action' => 'search'
                        ),
                        'novalidate' => true,
                        'id' => 'searchKeyword'
                    ));


                    echo $this->Form->input('type', array(
                        'type' => 'hidden',
                        'value' => $type,
                        'id' => 'type',
                        'empty' => ''
                    ));
                    ?>
                    <label style="float: right;">
                        <input id='keyword' type="text" name="keyword" class="form-control"
                               placeholder= <?= __("Search"); ?>>
                    </label>
                    <?php echo $this->Form->end(); ?>
					
					<div class="dataTables_length m-r-15" id="datatable-editable_length" style="display: inline-block;">
                        <label>&nbsp; <?= __('Order : ') ?>
                            <?php
                            if (isset($this->params['pass']['2'])) $order = $this->params['pass']['2'];
                            ?>
                            <select aria-controls="datatable-editable" class="form-control input-sm" name="selectOrder"
                                    id="selectOrder"
                                    onchange="selectOrderChangedSearch('bills/index/<?php echo $type ?>','DESC');">
                                 <option value=""></option>
								<option
                                    value="1" <?php if ($order == 1) echo 'selected="selected"' ?>> <?= __('Reference') ?></option>
                                <option
                                    value="2" <?php if ($order == 2) echo 'selected="selected"' ?>><?= __('Id') ?></option>
                                <option
                                    value="3" <?php if ($order == 3) echo 'selected="selected"' ?>><?= __('Date') ?></option>

                            </select>
                        </label>
                        <span id="asc_desc" >
                        <i class="fa fa-sort-asc" id="asc" onclick="selectOrderChangedSearch('bills/index/<?php echo $type ?>', 'ASC');"></i>
                        <i class="fa fa-sort-desc" id="desc" onclick="selectOrderChangedSearch('bills/index/<?php echo $type ?>','DESC');"></i>
                        </span>
                    </div>
					<div class="dataTables_length" id="datatable-editable_length" style="display: inline-block;">
                        <label>
                            <?php
                            if (isset($this->params['pass']['1'])) $limit = $this->params['pass']['1'];
                            ?>
                            <select aria-controls="datatable-editable" class="form-control input-sm" name="slctlimit"
                                    id="slctlimit"
                                    onchange="slctlimitChangedSearch('bills/index/<?php echo $type ?>');">
                                <option value="20" <?php if ($limit == 20) echo 'selected="selected"' ?>>20</option>
                                <option value="25" <?php if ($limit == 25) echo 'selected="selected"' ?>>25</option>
                                <option value="50" <?php if ($limit == 50) echo 'selected="selected"' ?>>50</option>
                                <option value="100" <?php if ($limit == 100) echo 'selected="selected"' ?>>100</option>
                                <option value="500" <?php if ($limit == 500) echo 'selected="selected"' ?>>500</option>
                            </select>&nbsp; <?= __('records per page') ?>
                        </label>
                    </div>



                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                           cellspacing="0" width="100%">

                        <thead>
                        <tr>
                            <th style="width: 10px">
                                <button type="button" id='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i
                                            class="fa fa-square-o"></i></button>
                            </th>

                            <th><?php echo $this->Paginator->sort('reference', __('Reference')); ?></th>
                            <th><?php echo $this->Paginator->sort('date', __('Date')); ?></th>
                            <th><?php echo $this->Paginator->sort('type', __('Type')); ?></th>

                            <?php if($type == BillTypesEnum::purchase_request ||
                                $type == BillTypesEnum::product_request
                            ){ ?>
                                <th><?php echo $this->Paginator->sort('customer_id',__('Demandeur')); ?></th>
                                <th><?php echo $this->Paginator->sort(__('Third')); ?></th>
                            <?php }else { ?>
                                <th><?php echo $this->Paginator->sort(__('Third')); ?></th>
                                <th><?php echo $this->Paginator->sort('total_ht', __('Total HT')); ?></th>
                                <th><?php echo $this->Paginator->sort('ristourne_val', __('Ristourne')); ?></th>
                                <th><?php echo $this->Paginator->sort('total_tva', __('Total TVA')); ?></th>
                                <th><?php echo $this->Paginator->sort('total_ttc', __('Total TTC')); ?></th>
                                <th><?php echo $this->Paginator->sort('amount_remaining', __('Amount remaining')); ?></th>


                            <?php } ?>
                            <?php
                            if(
                                $type == BillTypesEnum::purchase_request){ ?>
                                <th><?php echo $this->Paginator->sort('status', __('Status')); ?></th>

                            <?php   } ?>
                            <th class="actions"><?php echo __('Actions'); ?></th>
                        </tr>
                        </thead>


                        <tbody id="listeDiv">
                        <?php
                        if( $type == BillTypesEnum::purchase_request||
                            $type == BillTypesEnum::product_request){

                            $i = 0;
                            foreach ($bills as $bill) {
                                $i++;
                                if ($i < count($bills)) {
                                    if ($bills[$i]['Bill']['id'] == $bill['Bill']['id']) {
                                        $services[] = $bill['Service']['name'];
                                    } else {
                                        $services[] = $bill['Service']['name'];
                                        ?>
                                        <tr id="row<?= $bill['Bill']['id'] ?>">
                                            <td>
                                                <input id="idCheck" type="checkbox" class='id'
                                                       value=<?php echo $bill['Bill']['id'] ?>>
                                            </td>
                                            <td><?php echo $bill['Bill']['reference'] ?> </td>
                                            <td><?php echo h($this->Time->format($bill['Bill']['date'], '%d-%m-%Y')); ?>&nbsp;</td>
                                            <td><?php

                                                switch ($bill['Bill']['type']) {

                                                    case BillTypesEnum::product_request :

                                                        echo __("Product request");
                                                        break;
                                                    case BillTypesEnum::purchase_request :

                                                        echo __("Purchase request");
                                                        break;
                                                    default :
                                                        echo __("Journal");

                                                        break;
                                                }

                                                ?>&nbsp;</td>
                                            <td><?php echo $bill['Customer']['first_name'].' - '. $bill['Customer']['last_name']?> </td>

                                            <td>
                                                <?php
                                                $nbService = count($services);
                                                $j = 1;
                                                foreach ($services as $service) {
                                                    if ($j == $nbService) {
                                                        echo $service;
                                                    } else {
                                                        echo $service . ' / ';
                                                    }
                                                    $j++;
                                                } ?>
                                            </td>


                                            <?php if($type == BillTypesEnum::purchase_request){
                                                switch ($bill['Bill']['status']) {
                                                    case 1: ?>
                                                        <td><span  class="label label-danger"> <?php echo __('Not validated') ?></span></td>;
                                                        <?php     break;
                                                    case 2:?>
                                                        <td><span  class="label label-success"> <?php echo __('Transformed')  ?></span></td>;
                                                        <?php   break;

                                                    case 3:?>
                                                        <td><span  class="label label-success"> <?php echo __('Validated')  ?></span></td>;
                                                        <?php   break;
                                                    default: ?>
                                                        <td><span  > </span></td>;
                                                        <?php
                                                        break;
                                                }

                                                ?>

                                            <?php    } ?>
                                            <td class="actions">
                                                <div class="btn-group ">
                                                    <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                                                        <i class="fa fa-list fa-inverse"></i>
                                                    </a>
                                                    <button href="#" data-toggle="dropdown"
                                                            class="btn btn-info dropdown-toggle share">
                                                        <span class="caret"></span>
                                                    </button>

                                                    <ul class="dropdown-menu" style="min-width: 70px;">

                                                        <li>
                                                            <?= $this->Html->link(
                                                                '<i   class="fa fa-eye" title="' . __('View') . '"></i>',
                                                                array('action' => 'View', $bill['Bill']['type'], $bill['Bill']['id']),
                                                                array('escape' => false, 'class' => 'btn btn-success')
                                                            ); ?>
                                                        </li>


                                                        <li>
                                                            <?php  echo $this->Html->link(
                                                                '<i class="fa fa-edit m-r-5 "></i>',
                                                                array('action' => 'Edit', $bill['Bill']['type'], $bill['Bill']['id']),
                                                                array('escape' => false, 'class' => 'btn btn-primary')); ?>
                                                        </li>
                                                        <li class='edit-link' title="<?= __('Print simplified bill') ?>">
                                                            <?= $this->Html->link(
                                                                '<i class=" fa fa-print"></i>',
                                                                array('action' => 'view_bill', 'ext' => 'pdf', $bill['Bill']['id']),
                                                                array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                                            ); ?>
                                                        </li>

                                                        <li class='edit-link' title="<?= __('Print detailed bill') ?>">
                                                            <?= $this->Html->link(
                                                                '<i class=" fa fa-print"></i>',
                                                                array('action' => 'printDetailedBill', 'ext' => 'pdf', $bill['Bill']['id']),
                                                                array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                                            ); ?>
                                                        </li>
                                                        <li class='edit-link' title="<?= __('Print bill with regulation details') ?>">
                                                            <?= $this->Html->link(
                                                                '<i class=" fa fa-print"></i>',
                                                                array('action' => 'printBillWithRegulationDetails', 'ext' => 'pdf', $bill['Bill']['id']),
                                                                array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                                            ); ?>
                                                        </li>

                                                        <li>
                                                            <?php
                                                            echo $this->Form->postLink(
                                                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                                                array('action' => 'delete', $type, $bill['Bill']['id']),
                                                                array('escape' => false, 'class' => 'btn btn-danger'),
                                                                __('Are you sure you want to delete %s?', $bill['Bill']['reference'])); ?>
                                                        </li>
                                                    </ul>
                                                </div>


                                            </td>


                                        </tr>

                                        <?php  $billId = $bill['Bill']['id'];
                                        $services = array();
                                    }


                                } else {

                                    $services[] = $bill['Service']['name'];


                                    ?>


                                    <tr id="row<?= $bill['Bill']['id'] ?>">
                                        <td class='case'>

                                            <input id="idCheck" type="checkbox" class='id'
                                                   value=<?php echo $bill['Bill']['id'] ?>>
                                        </td>
                                        <td><?php echo $bill['Bill']['reference'] ?> </td>
                                        <td><?php echo h($this->Time->format($bill['Bill']['date'], '%d-%m-%Y')); ?>&nbsp;</td>
                                        <td><?php

                                            switch ($bill['Bill']['type']) {

                                                case BillTypesEnum::product_request :

                                                    echo __("Product request");
                                                    break;
                                                case BillTypesEnum::purchase_request :

                                                    echo __("Purchase request");
                                                    break;
                                                default :
                                                    echo __("Journal");

                                                    break;
                                            }

                                            ?>&nbsp;</td>
                                        <td><?php echo $bill['Customer']['first_name'].' - '. $bill['Customer']['last_name']?> </td>
                                        <td><?php
                                            $nbService = count($services);

                                            $j = 1;
                                            foreach ($services as $service) {
                                                if ($j == $nbService) {
                                                    echo $service;
                                                } else {
                                                    echo $service . ' / ';
                                                }
                                                $j++;
                                            } ?>

                                        </td>

                                        <?php if($type == BillTypesEnum::purchase_request){
                                            switch ($bill['Bill']['status']) {
                                                case 1: ?>
                                                    <td><span  class="label label-danger"> <?php echo __('Not validated') ?></span></td>;
                                                    <?php     break;
                                                case 2:?>
                                                    <td><span  class="label label-success"> <?php echo __('Transformed')  ?></span></td>;
                                                    <?php   break;

                                                case 3:?>
                                                    <td><span  class="label label-success"> <?php echo __('Validated')  ?></span></td>;
                                                    <?php   break;
                                                default: ?>
                                                    <td><span  > </span></td>;
                                                    <?php
                                                    break;
                                            }

                                            ?>

                                        <?php    } ?>

                                        <td class="actions">
                                            <div class="btn-group ">
                                                <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                                                    <i class="fa fa-list fa-inverse"></i>
                                                </a>
                                                <button href="#" data-toggle="dropdown"
                                                        class="btn btn-info dropdown-toggle share">
                                                    <span class="caret"></span>
                                                </button>

                                                <ul class="dropdown-menu" style="min-width: 70px;">

                                                    <li>
                                                        <?= $this->Html->link(
                                                            '<i   class="fa fa-eye" title="' . __('View') . '"></i>',
                                                            array('action' => 'View', $bill['Bill']['type'], $bill['Bill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-success')
                                                        ); ?>
                                                    </li>


                                                    <li>
                                                        <?php  echo $this->Html->link(
                                                            '<i class="fa fa-edit m-r-5 "></i>',
                                                            array('action' => 'Edit', $bill['Bill']['type'], $bill['Bill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-primary')); ?>
                                                    </li>
                                                    <li class='edit-link' title="<?= __('Print simplified bill') ?>">
                                                        <?= $this->Html->link(
                                                            '<i class=" fa fa-print"></i>',
                                                            array('action' => 'view_bill', 'ext' => 'pdf', $bill['Bill']['id']),
                                                            array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                                        ); ?>
                                                    </li>

                                                    <li class='edit-link' title="<?= __('Print detailed bill') ?>">
                                                        <?= $this->Html->link(
                                                            '<i class=" fa fa-print"></i>',
                                                            array('action' => 'printDetailedBill', 'ext' => 'pdf', $bill['Bill']['id']),
                                                            array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                                        ); ?>
                                                    </li>
                                                    <li class='edit-link' title="<?= __('Print bill with regulation details') ?>">
                                                        <?= $this->Html->link(
                                                            '<i class=" fa fa-print"></i>',
                                                            array('action' => 'printBillWithRegulationDetails', 'ext' => 'pdf', $bill['Bill']['id']),
                                                            array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                                        ); ?>
                                                    </li>

                                                    <li>
                                                        <?php
                                                        echo $this->Form->postLink(
                                                            '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                                            array('action' => 'delete', $type, $bill['Bill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-danger'),
                                                            __('Are you sure you want to delete %s?', $bill['Bill']['reference'])); ?>
                                                    </li>
                                                </ul>
                                            </div>


                                        </td>



                                    </tr>





                                    <?php
                                }
                            }






                        }else {
                            foreach ($bills as $bill): ?>
                                <tr id="row<?= $bill['Bill']['id'] ?>">
                                    <td>

                                        <input id="idCheck" type="checkbox" class='id'
                                               value=<?php echo $bill['Bill']['id'] ?>>
                                    </td>

                                    <td><?php echo h($bill['Bill']['reference']); ?>&nbsp;</td>
                                    <td><?php echo h($this->Time->format($bill['Bill']['date'], '%d-%m-%Y')); ?>&nbsp;</td>
                                    <td><?php

                                        switch ($bill['Bill']['type']) {
                                            case BillTypesEnum::supplier_order :

                                                echo __('Supplier orders');
                                                break;
                                            case BillTypesEnum::receipt :

                                                echo __("Receipts");

                                                break;

                                            case BillTypesEnum::return_supplier :

                                                echo __("Return supplier");
                                                break;
                                            case BillTypesEnum::purchase_invoice :

                                                echo __("Purchase invoice");
                                                break;

                                            case BillTypesEnum::credit_note :

                                                echo __("Credit note");
                                                break;

                                            case BillTypesEnum::delivery_order :

                                                echo __("Delivery orders");
                                                break;

                                            case BillTypesEnum::return_customer :

                                                echo __("Return customer");

                                                break;

                                            case BillTypesEnum::entry_order :

                                                echo __("Entry order");

                                                break;

                                            case BillTypesEnum::exit_order :

                                                echo __("Exit order");

                                                break;

                                            case BillTypesEnum::renvoi_order :

                                                echo __("Renvoi order");

                                                break;

                                            case BillTypesEnum::reintegration_order :

                                                echo __("Reintegration order");
                                                break;

                                            case BillTypesEnum::quote :

                                                echo __("Quotation");
                                                break;

                                            case BillTypesEnum::customer_order :

                                                echo __("Customer order");
                                                break;

                                            case BillTypesEnum::sales_invoice :

                                                echo __("Invoice");
                                                break;

                                            case BillTypesEnum::sale_credit_note :

                                                echo __("Sale credit note");
                                                break;
                                            case BillTypesEnum::product_request :

                                                echo __("Product request");
                                                break;
                                            case BillTypesEnum::purchase_request :

                                                echo __("Purchase request");
                                                break;
                                            default :
                                                echo __("Journal");

                                                break;
                                        }

                                        ?>&nbsp;</td>
                                    <?php
                                    if (!empty($bill['Bill']['supplier_id'])) { ?>
                                        <td><?php echo h($bill['Supplier']['name']); ?>&nbsp;</td>
                                    <?php } else { ?>

                                        <td> <?php if ($carNameStructure == 1) {
                                                echo $bill['EventType']['name'] . " - " . $bill['Car']['code'] . " - " . $bill['Carmodel']['name'];
                                            } else if ($carNameStructure == 2) {
                                                echo $bill['EventType']['name'] . " - " . $bill['Car']['immatr_def'] . " - " . $bill['Carmodel']['name'];
                                            } ?>
                                        </td>
                                    <?php }
                                    ?>


                                    <td><?php echo number_format($bill['Bill']['total_ht']+$bill['Bill']['ristourne_val'], 2, ",", $separatorAmount) ; ?>
                                        &nbsp;</td>
                                    <td><?php echo number_format($bill['Bill']['ristourne_val'], 2, ",", $separatorAmount) ; ?>
                                        &nbsp;</td>
                                    <td><?php echo number_format($bill['Bill']['total_tva'], 2, ",", $separatorAmount) ; ?>
                                        &nbsp;</td>
                                    <td><?php echo number_format($bill['Bill']['total_ttc'], 2, ",", $separatorAmount) ; ?>
                                        &nbsp;</td>

                                    <td><?php echo number_format($bill['Bill']['amount_remaining'], 2, ",", $separatorAmount) ; ?>
                                        &nbsp;</td>


                                    <td class="actions">
                                        <div class="btn-group ">
                                            <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                                                <i class="fa fa-list fa-inverse"></i>
                                            </a>
                                            <button href="#" data-toggle="dropdown"
                                                    class="btn btn-info dropdown-toggle share">
                                                <span class="caret"></span>
                                            </button>

                                            <ul class="dropdown-menu" style="min-width: 70px;">

                                                <li>
                                                    <?= $this->Html->link(
                                                        '<i   class="fa fa-eye" title="' . __('View') . '"></i>',
                                                        array('action' => 'View', $bill['Bill']['type'], $bill['Bill']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-success')
                                                    ); ?>
                                                </li>


                                                <li>
                                                    <?php  echo $this->Html->link(
                                                        '<i class="fa fa-edit m-r-5 "></i>',
                                                        array('action' => 'Edit', $bill['Bill']['type'], $bill['Bill']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-primary')); ?>
                                                </li>
                                                <li class='edit-link' title="<?= __('Print simplified bill') ?>">
                                                    <?= $this->Html->link(
                                                        '<i class=" fa fa-print"></i>',
                                                        array('action' => 'view_bill', 'ext' => 'pdf', $bill['Bill']['id']),
                                                        array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                                    ); ?>
                                                </li>

                                                <li class='edit-link' title="<?= __('Print detailed bill') ?>">
                                                    <?= $this->Html->link(
                                                        '<i class=" fa fa-print"></i>',
                                                        array('action' => 'printDetailedBill', 'ext' => 'pdf', $bill['Bill']['id']),
                                                        array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                                    ); ?>
                                                </li>
                                                <li class='edit-link' title="<?= __('Print bill with regulation details') ?>">
                                                    <?= $this->Html->link(
                                                        '<i class=" fa fa-print"></i>',
                                                        array('action' => 'printBillWithRegulationDetails', 'ext' => 'pdf', $bill['Bill']['id']),
                                                        array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                                    ); ?>
                                                </li>

                                                <li>
                                                    <?php
                                                    echo $this->Form->postLink(
                                                        '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                                        array('action' => 'delete', $type, $bill['Bill']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-danger'),
                                                        __('Are you sure you want to delete %s?', $bill['Bill']['reference'])); ?>
                                                </li>
                                            </ul>
                                        </div>


                                    </td>
                                </tr>
                            <?php endforeach;
                        } ?>


                        </tbody>


                    </table>

                    <?php if( $type == BillTypesEnum::purchase_request||
                        $type == BillTypesEnum::product_request){ ?>
                        <div id="pagination" class="pull-right">
                            <?php if ($this->params['paging']['BillService']['pageCount'] > 1) {
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
                    <?php }else { ?>
                        <div id="pagination" class="pull-right">
                            <?php if ($this->params['paging']['Bill']['pageCount'] > 1) {
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
                    <?php } ?>




                </div>
            </div>
        </div>

    </div>
<div class="card-box">
    <ul class="list-group m-b-15 user-list">
            <div class="nav-tabs-custom pdg_btm">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('Amount discount and tax') ?></a></li>
                    <li><a href="#tab_2" data-toggle="tab"><?= __('Payment and balance') ?></a></li>

                </ul>
               
                 <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                 <?php    
						echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('Total HT : ') . '</b><span >' .
						number_format($totalArray['totalHt'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div></br> ";
						echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('Total TTC : ') . '</b><span >' .
						number_format($totalArray['totalTtc'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div> </br>";
						echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('Total remise : ') . '</b><span >' .
						number_format($totalArray['totalRistourne'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div></br> ";
						echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('Timbre : ') . '</b><span >' .
						number_format($totalArray['stamp'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div></br> ";
						echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('TVA : ') . '</b><span >' .
						number_format($totalArray['totalTva'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div> </br>";
        
				?>

                    </div>

                    <div class="tab-pane " id="tab_2">
					<?php
						echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('Net HT : ') . '</b><span >' .
						number_format($totalArray['totalHt'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div> </br>";
						echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('Net TTC : ') . '</b><span >' .
						number_format($totalArray['totalTtc'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div> </br>";
						echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('Payé : ') . '</b><span >' .
						number_format($totalArray['totalRest'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div> </br>";
						echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('Reste à payer : ') . '</b><span >' .
						number_format($totalArray['amountRemaining'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div> </br>";
						echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'></b><span > </span> </span></div> </br>";
						
					?>
                    </div>
                </div>



            </div>
    </ul>
</div>





    <?php $this->start('script'); ?>

    <script type="text/javascript">
        $(document).ready(function () {
			
			jQuery("#date1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
			jQuery("#date2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
              jQuery("#dialogModalConditionTransformation").dialog({
					autoOpen: false,
					height: 450,
					width: 450,
					show: {
						effect: "blind",
						duration: 400
					},
					hide: {
						effect: "blind",
						duration: 500
					},
					modal: true
			});
		
		
		
		});

        function printSimplifiedJournal() {
            var conditions = new Array();
            conditions[0] = jQuery('#supplier').val();
            conditions[1] = jQuery('#date1').val();
            conditions[2] = jQuery('#date2').val();
            /*conditions[3] = jQuery('#client').val();
             conditions[4] = jQuery('#interfering').val();
             conditions[5] = jQuery('#customer').val();
             conditions[6] = jQuery('#compte').val();
             conditions[7] = jQuery('#payment_type').val();
             conditions[8] = jQuery('#amount').val();*/
            var myCheckboxes = new Array();
            jQuery('.id:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });
			var type = jQuery("#type").val();
            var url = '<?php echo $this->Html->url(array('action' => 'printSimplifiedJournal', 'ext' => 'pdf'), array('target' => '_blank' ))?>';
            var form = jQuery('<form action="' + url + '" method="post" target="_Blank" >' +
            '<input type="hidden" name="printSimplifiedJournal" value="' + conditions + '" />' +
            '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
			'<input type="hidden" name="typePiece" value="' + type + '" />' +
            '</form>');
            jQuery('body').append(form);
            form.submit();
        }
		
		function printDetailedJournal() {
        var conditions = new Array();
        conditions[0] = jQuery('#supplier').val();
        conditions[1] = jQuery('#date1').val();
        conditions[2] = jQuery('#date2').val();
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
        var type = jQuery("#type").val();
        var url = '<?php echo $this->Html->url(array('action' => 'printDetailedJournal', 'ext' => 'pdf'), array('target' => '_blank'))?>';
        var form = jQuery('<form action="' + url + '" method="post"  target="_Blank" >' +
            '<input type="hidden" name="printDetailedJournal" value="' + conditions + '" />' +
            '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
            '<input type="hidden" name="typePiece" value="' + type + '" />' +
            '</form>');
        jQuery('body').append(form);
        form.submit();
    }
        
	function printSimplifiedJournalBySupplier() {
            var conditions = new Array();
            conditions[0] = jQuery('#supplier').val();
            conditions[1] = jQuery('#date1').val();
            conditions[2] = jQuery('#date2').val();
            var myCheckboxes = new Array();
            jQuery('.id:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });
			var type = jQuery("#type").val();
            var url = '<?php echo $this->Html->url(array('action' => 'printSimplifiedJournalBySupplier', 'ext' => 'pdf'), array('target' => '_blank' ))?>';
            var form = jQuery('<form action="' + url + '" method="post" target="_Blank" >' +
            '<input type="hidden" name="printSimplifiedJournalBySupplier" value="' + conditions + '" />' +
            '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
			'<input type="hidden" name="typePiece" value="' + type + '" />' +
            '</form>');
            jQuery('body').append(form);
            form.submit();
        }
	
	   function printSimplifiedJournalWithDetailBill() {
        var conditions = new Array();
        conditions[0] = jQuery('#supplier').val();
        conditions[1] = jQuery('#date1').val();
        conditions[2] = jQuery('#date2').val();
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
        var type = jQuery("#type").val();
        var url = '<?php echo $this->Html->url(array('action' => 'printSimplifiedJournalWithDetailBill', 'ext' => 'pdf'), array('target' => '_blank'))?>';
        var form = jQuery('<form action="' + url + '" method="post"  target="_Blank" >' +
            '<input type="hidden" name="printSimplifiedJournalWithDetailBill" value="' + conditions + '" />' +
            '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
            '<input type="hidden" name="typePiece" value="' + type + '" />' +
            '</form>');
        jQuery('body').append(form);
        form.submit();
    }
		
        function view_bill() {
            var conditions = new Array();
            conditions[0] = jQuery('#supplier').val();
            conditions[1] = jQuery('#date1').val();
            conditions[2] = jQuery('#date2').val();
            var myCheckboxes = new Array();
            jQuery('.id:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });
            var type = jQuery("#type").val();
            var url = '<?php echo $this->Html->url(array('action' => 'view_bill', 'ext' => 'pdf'),
         array('target' => '_blank' ))?>';
            var form = jQuery('<form action="' + url + '" method="post" target="_Blank" >' +
            '<input type="hidden" name="view_bill" value="' + conditions + '" />' +
            '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
            '<input type="hidden" name="type" value="' + type + '" />' +
            '</form>');
            jQuery('body').append(form);
            form.submit();
        }
		
		function transformBills(typeTransformation) {
				var typeDodument = jQuery('#type').val();
				var myCheckboxes = new Array();
				jQuery('.id:checked').each(function () {
					myCheckboxes.push(jQuery(this).val());
				});
				jQuery('#dialogModalConditionTransformation').dialog('option', 'title', 'Option de la transformation');
				jQuery('#dialogModalConditionTransformation').dialog('open');
				jQuery('#dialogModalConditionTransformation').load('<?php echo $this->Html->url('/Bills/transformBills/')?>' + myCheckboxes + '/' + typeTransformation + '/' + typeDodument);

    }
	
	function definePeriod(id) {
        switch (id) {
            case 'today':
                var now = new Date();
                var currentDate = getDay(now);

                jQuery("#date1").val(currentDate);
                jQuery("#date2").val(currentDate);
                break;
            case 'week':

                getWeek();

                break;
            case 'month':
                getMonth();
                break;
            case 'quarter':
                getQuarter();
                break;
            case 'semester':
                getSemester();
                break;
            case 'year':
                getYear();
                break;


        }
    }

    function getDay(now) {
        var day = now.getDate();
        day = parseInt(day);
        if (day >= 0 && day < 10) {
            day = '0' + day;
        }

        var month = now.getMonth();
        var year = now.getFullYear();
        switch (month) {
            case 0:
                var valMonth = '01';
                break;
            case 1:
                var valMonth = '02';
                break;
            case 2:
                var valMonth = '03';
                break;
            case 3:
                var valMonth = '04';
                break;
            case 4:
                var valMonth = '05';
                break;
            case 5:
                var valMonth = '06';
                break;
            case 6:
                var valMonth = '07';
                break;
            case 7:
                var valMonth = '08';
                break;
            case 8:
                var valMonth = '09';
                break;
            case 9:
                var valMonth = '10';
                break;
            case 10:
                var valMonth = '11';
                break;
            case 11:
                var valMonth = '12';
                break;
        }
        var currentDate = day + "/" + valMonth + "/" + year;
        return currentDate;
    }

    function getWeek() {
        var d1 = new Date();
        numOfdaysPastSinceLastSaturday = eval(d1.getDay());
        d1.setDate(d1.getDate() - numOfdaysPastSinceLastSaturday);
        var rangeIsFrom = getDay(d1);
        jQuery("#date1").val(rangeIsFrom);
        d1.setDate(d1.getDate() + 6);
        var rangeIsTo = getDay(d1);
        jQuery("#date2").val(rangeIsTo);

    }

    function getMonth() {
        var now = new Date();
        var month = now.getMonth();
        switch (month) {
            case 0:
                var startDay = '01';
                var endDay = '31';
                break;
            case 1:
                var startDay = '01';
                var year = now.getFullYear();
                var endDay = new Date(year, 1, 1).getMonth() == new Date(year, 1, 29).getMonth() ? 29 : 28;
                break;
            case 2:
                var startDay = '01';
                var endDay = '31';
                break;
            case 3:
                var startDay = '01';
                var endDay = '30';
                break;
            case 4:
                var startDay = '01';
                var endDay = '31';
                break;
            case 5:
                var startDay = '01';
                var endDay = '30';
                break;
            case 6:
                var startDay = '01';
                var endDay = '31';
                break;
            case 7:
                var startDay = '01';
                var endDay = '31';
                break;
            case 8:
                var startDay = '01';
                var endDay = '30';
                break;
            case 9:
                var startDay = '01';
                var endDay = '31';
                break;
            case 10:
                var startDay = '01';
                var endDay = '30';
                break;
            case 11:
                var startDay = '01';
                var endDay = '31';
                break;
        }
        var startMonth = new Date();
        startMonth.setDate(startDay);
        var startDate = getDay(startMonth);
        jQuery("#date1").val(startDate);
        var endMonth = new Date();
        endMonth.setDate(endDay);
        var endDate = getDay(endMonth);
        jQuery("#date2").val(endDate);
    }

    function getQuarter() {
        var now = new Date();
        var month = now.getMonth();
        switch (month) {
            case 0:
                var startDay = '01';
                var startMonth = 0;
                var endDay = '31';
                var endMonth = 2;
                break;
            case 1:
                var startDay = '01';
                var startMonth = 0;
                var endDay = '31';
                var endMonth = 2;
                break;
            case 2:
                var startDay = '01';
                var startMonth = 0;
                var endDay = '31';
                var endMonth = 2;
                break;
            case 3:
                var startDay = '01';
                var startMonth = 3;
                var endDay = '30';
                var endMonth = 5;
                break;
            case 4:
                var startDay = '01';
                var startMonth = 3;
                var endDay = '30';
                var endMonth = 5;
                break;
            case 5:
                var startDay = '01';
                var startMonth = 3;
                var endDay = '30';
                var endMonth = 5;
                break;
            case 6:
                var startDay = '01';
                var startMonth = 6;
                var endDay = '30';
                var endMonth = 8;
                break;
            case 7:
                var startDay = '01';
                var startMonth = 6;
                var endDay = '30';
                var endMonth = 8;
                break;
            case 8:
                var startDay = '01';
                var startMonth = 6;
                var endDay = '30';
                var endMonth = 8;
                break;
            case 9:
                var startDay = '01';
                var startMonth = 9;
                var endDay = '31';
                var endMonth = 11;
                break;
            case 10:
                var startDay = '01';
                var startMonth = 9;
                var endDay = '31';
                var endMonth = 11;
                break;
            case 11:
                var startDay = '01';
                var startMonth = 9;
                var endDay = '31';
                var endMonth = 11;
                break;
        }
        var startQuarter = new Date();
        startQuarter.setMonth(startMonth);
        startQuarter.setDate(startDay);
        var startDate = getDay(startQuarter);
        jQuery("#date1").val(startDate);
        var endQuarter = new Date();
        endQuarter.setMonth(endMonth);
        endQuarter.setDate(endDay);
        var endDate = getDay(endQuarter);
        jQuery("#date2").val(endDate);
    }

    function getSemester() {
        var now = new Date();
        var month = now.getMonth();
        switch (month) {
            case 0:
                var startDay = '01';
                var startMonth = 0;
                var endDay = '30';
                var endMonth = 5;
                break;
            case 1:
                var startDay = '01';
                var startMonth = 0;
                var endDay = '30';
                var endMonth = 5;
                break;
            case 2:
                var startDay = '01';
                var startMonth = 0;
                var endDay = '30';
                var endMonth = 5;
                break;
            case 3:
                var startDay = '01';
                var startMonth = 0;
                var endDay = '30';
                var endMonth = 5;
                break;
            case 4:
                var startDay = '01';
                var startMonth = 0;
                var endDay = '30';
                var endMonth = 5;
                break;
            case 5:
                var startDay = '01';
                var startMonth = 0;
                var endDay = '30';
                var endMonth = 5;
                break;
            case 6:
                var startDay = '01';
                var startMonth = 6;
                var endDay = '31';
                var endMonth = 11;
                break;
            case 7:
                var startDay = '01';
                var startMonth = 6;
                var endDay = '31';
                var endMonth = 11;
                break;
            case 8:
                var startDay = '01';
                var startMonth = 6;
                var endDay = '31';
                var endMonth = 11;
                break;
            case 9:
                var startDay = '01';
                var startMonth = 6;
                var endDay = '31';
                var endMonth = 11;
                break;
            case 10:
                var startDay = '01';
                var startMonth = 6;
                var endDay = '31';
                var endMonth = 11;
                break;
            case 11:
                var startDay = '01';
                var startMonth = 6;
                var endDay = '31';
                var endMonth = 11;
                break;
        }
        var startSemester = new Date();
        startSemester.setMonth(startMonth);
        startSemester.setDate(startDay);
        var startDate = getDay(startSemester);
        jQuery("#date1").val(startDate);
        var endSemester = new Date();
        endSemester.setMonth(endMonth);
        endSemester.setDate(endDay);
        var endDate = getDay(endSemester);
        jQuery("#date2").val(endDate);
    }

    function getYear() {

        var startDay = '01';
        var startMonth = 0;
        var endDay = '31';
        var endMonth = 11;
        var startYear = new Date();
        startYear.setMonth(startMonth);
        startYear.setDate(startDay);
        var startDate = getDay(startYear);
        jQuery("#date1").val(startDate);
        var endYear = new Date();
        endYear.setMonth(endMonth);
        endYear.setDate(endDay);
        var endDate = getDay(endYear);
        jQuery("#date2").val(endDate);

    }

        function exportAllDataBills() {

            <?php
            $url = "";
            if (isset($this->params['named']['keyword']) && !empty($this->params['named']['keyword'])) {
                $url .= "/keyword:" . $this->params['named']['keyword'];
            }
            if (isset($this->params['named']['ride']) && !empty($this->params['named']['ride'])) {
                $url .= "/ride:" . $this->params['named']['ride'];
            }
            if (isset($this->params['named']['reglement']) && !empty($this->params['named']['reglement'])) {
                $url .= "/reglement:" . $this->params['named']['reglement'];
            }
            if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
                $url .= "/category:" . $this->params['named']['category'];
            }

            if (isset($this->params['named']['type']) && !empty($this->params['named']['type'])) {
                $url .= "/type:" . $this->params['named']['type'];
            }
            if (isset($this->params['named']['supplier']) && !empty($this->params['named']['supplier'])) {
                $url .= "/supplier:" . $this->params['named']['supplier'];
            }
            if (isset($this->params['named']['client']) && !empty($this->params['named']['client'])) {
                $url .= "/client:" . $this->params['named']['client'];
            }
            if (isset($this->params['named']['product']) && !empty($this->params['named']['product'])) {
                $url .= "/product:" . $this->params['named']['product'];
            }
            if (isset($this->params['named']['date1']) && !empty($this->params['named']['date1'])) {
                $url .= "/date1:" . $this->params['named']['date1'];
            }
            if (isset($this->params['named']['date2']) && !empty($this->params['named']['date2'])) {
                $url .= "/date2:" . $this->params['named']['date2'];
            }
            if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
                $url .= "/user:" . $this->params['named']['user'];
            }
            if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
                $url .= "/modified_id:" . $this->params['named']['modified_id'];
            }
            if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
                $url .= "/created:" . $this->params['named']['created'];
            }
            if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
                $url .= "/created1:" . $this->params['named']['created1'];
            }
            if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
                $url .= "/modified:" . $this->params['named']['modified'];
            }
            if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
                $url .= "/modified1:" . $this->params['named']['modified1'];
            }
            ?>
            window.location = '<?php echo $this->Html->url('/bills/export/')?>' + 'all_search' + '<?php echo $url;?>';

        }


        function slctlimitChangedSearch() {
            <?php
            $url = "";

            if (isset($this->params['named']['keyword']) && !empty($this->params['named']['keyword'])) {
                $url .= "/keyword:" . $this->params['named']['keyword'];
            }
            if (isset($this->params['named']['ride']) && !empty($this->params['named']['ride'])) {
                $url .= "/ride:" . $this->params['named']['ride'];
            }
            if (isset($this->params['named']['reglement']) && !empty($this->params['named']['reglement'])) {
                $url .= "/reglement:" . $this->params['named']['reglement'];
            }
            if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
                $url .= "/category:" . $this->params['named']['category'];
            }

            if (isset($this->params['named']['type']) && !empty($this->params['named']['type'])) {
                $url .= "/type:" . $this->params['named']['type'];
            }
            if (isset($this->params['named']['supplier']) && !empty($this->params['named']['supplier'])) {
                $url .= "/supplier:" . $this->params['named']['supplier'];
            }
            if (isset($this->params['named']['client']) && !empty($this->params['named']['client'])) {
                $url .= "/client:" . $this->params['named']['client'];
            }
            if (isset($this->params['named']['product']) && !empty($this->params['named']['product'])) {
                $url .= "/product:" . $this->params['named']['product'];
            }
            if (isset($this->params['named']['date1']) && !empty($this->params['named']['date1'])) {
                $url .= "/date1:" . $this->params['named']['date1'];
            }
            if (isset($this->params['named']['date2']) && !empty($this->params['named']['date2'])) {
                $url .= "/date2:" . $this->params['named']['date2'];
            }
            if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
                $url .= "/user:" . $this->params['named']['user'];
            }
            if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
                $url .= "/modified_id:" . $this->params['named']['modified_id'];
            }
            if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
                $url .= "/created:" . $this->params['named']['created'];
            }
            if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
                $url .= "/created1:" . $this->params['named']['created1'];
            }
            if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
                $url .= "/modified:" . $this->params['named']['modified'];
            }
            if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
                $url .= "/modified1:" . $this->params['named']['modified1'];
            }
            ?>
            window.location = '<?php echo $this->Html->url('/bills/search/')?>' + jQuery('#slctlimit').val() + '<?php echo $url;?>';
        }



        function selectOrderChangedSearch(url= null, orderType= null) {
            <?php
            $url = "";

            if (isset($this->params['named']['keyword']) && !empty($this->params['named']['keyword'])) {
                $url .= "/keyword:" . $this->params['named']['keyword'];
            }
            if (isset($this->params['named']['ride']) && !empty($this->params['named']['ride'])) {
                $url .= "/ride:" . $this->params['named']['ride'];
            }
            if (isset($this->params['named']['reglement']) && !empty($this->params['named']['reglement'])) {
                $url .= "/reglement:" . $this->params['named']['reglement'];
            }
            if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
                $url .= "/category:" . $this->params['named']['category'];
            }

            if (isset($this->params['named']['type']) && !empty($this->params['named']['type'])) {
                $url .= "/type:" . $this->params['named']['type'];
            }
            if (isset($this->params['named']['supplier']) && !empty($this->params['named']['supplier'])) {
                $url .= "/supplier:" . $this->params['named']['supplier'];
            }
            if (isset($this->params['named']['client']) && !empty($this->params['named']['client'])) {
                $url .= "/client:" . $this->params['named']['client'];
            }
            if (isset($this->params['named']['product']) && !empty($this->params['named']['product'])) {
                $url .= "/product:" . $this->params['named']['product'];
            }
            if (isset($this->params['named']['date1']) && !empty($this->params['named']['date1'])) {
                $url .= "/date1:" . $this->params['named']['date1'];
            }
            if (isset($this->params['named']['date2']) && !empty($this->params['named']['date2'])) {
                $url .= "/date2:" . $this->params['named']['date2'];
            }
            if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
                $url .= "/user:" . $this->params['named']['user'];
            }
            if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
                $url .= "/modified_id:" . $this->params['named']['modified_id'];
            }
            if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
                $url .= "/created:" . $this->params['named']['created'];
            }
            if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
                $url .= "/created1:" . $this->params['named']['created1'];
            }
            if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
                $url .= "/modified:" . $this->params['named']['modified'];
            }
            if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
                $url .= "/modified1:" . $this->params['named']['modified1'];
            }
            ?>
            var limit = jQuery('#slctlimit').val();
            var order = jQuery('#selectOrder').val();
            window.location = '<?php echo $this->Html->url('/bills/search/')?>' +limit+'/'+ order +'/'+ orderType +'<?php echo $url;?>';
        }

    
	

    </script>
    <?php $this->end(); ?>
