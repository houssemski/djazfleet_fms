<?php
//include("ctp/index.ctp");
App::import('Model', 'Event');
$this->Event = new Event();

?><h4 class="page-title"> <?=__('Intervention requests'); ?></h4>
<div class="box-body">
    <div class="panel-group wrap" id="bs-collapse">



        <div class="panel">
            <div class="panel-heading" style="background-color: #435966; color: #fff;">
                <h4 class="panel-title">
                    <a class="collapsed" data-toggle="collapse" data-parent="#" href="#one">
                        <?php echo __('Search') ?>
                    </a>
                </h4>
            </div>
            <div id="one" class="panel-collapse collapse">
                <div class="panel-body">

                    <?php echo $this->Form->create('Events', array(
                        'url'=> array(
                            'action' => 'search'
                        ),
                        'novalidate' => true
                    )); ?>

                    <div class="filters" id='filters'>
                        <input  name = "conditions" type="hidden" value = "<?php echo base64_encode( serialize( $conditions ) ); ?>">
                        <input  name = "conditions_car" type="hidden" value = "<?php echo base64_encode( serialize( $conditions_car ) ); ?>">
                        <input  name = "conditions_customer" type="hidden" value = "<?php echo base64_encode( serialize( $conditions_customer ) ); ?>">
                        <?php
                        echo $this->Form->input('event_type_id', array(
                            'label' => __('Type'),
                            'class' => 'form-filter',
                            'empty' => ''
                        ));

                        echo $this->Form->input('interfering_id', array(
                            'label' => __('Interfering'),
                            'class' => 'form-filter',
                            'empty' => ''
                        ));

                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('car_id', array(
                            'label' => __('Car'),
                            'class' => 'form-filter',
                            'empty' => ''
                        ));
                        echo $this->Form->input('customer_id', array(
                            'label' => __("Conductor"),
                            'class' => 'form-filter',
                            'empty' => ''
                        ));

                        if ($hasParc) {

                            echo $this->Form->input('parc_id', array(
                                'label' => __('Parc'),
                                'class' => 'form-filter',
                                'id' => 'parc',

                                'empty' => ''
                            ));


                        } else {
                            if($nb_parcs>0){
                                echo $this->Form->input('parc_id', array(
                                    'label' => __('Parc'),
                                    'class' => 'form-filter',
                                    'id' => 'parc',
                                    'type'=>'select',
                                    'options'=>$parcs,
                                    'empty' => ''
                                ));
                            }


                        }


                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('date', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'startdate',
                        ));
                        echo $this->Form->input('next_date', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Next date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'enddate',
                        ));
                        echo $this->Form->input('date3', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Date 3') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'date3',
                        ));
                        echo "<div style='clear:both; padding-top: 15px;'></div>";
                        $options=array('1'=>__('Yes'),'2'=>__('No'));
                        echo $this->Form->input('pay_customer', array(
                            'label' => __('Pay by the driver'),
                            'type' =>'select',
                            'options'=>$options,
                            'class' => 'form-filter',
                            'empty' => ''
                        ));
                        echo $this->Form->input('refund', array(
                            'label' => __("Refund"),
                            'class' => 'form-filter',
                            'type' =>'select',
                            'options'=>$options,
                            'empty' => ''
                        ));

                        echo $this->Form->input('request', array(
                            'value'=>'1',
                            'type' => 'hidden',

                        ));
                        echo $this->Form->input('validated', array(

                            'type' => 'hidden',

                        ));
                        echo "<div style='clear:both; padding-top: 40px;'></div>";

                        echo '<div class="lbl"> <a href="#demo" data-toggle="collapse"><i class="fa fa-search"></i>'.__("  Administrative filter").'</a></div>';

                        ?>


                        <div id="demo" class="collapse">
                            <div style="clear:both; padding-top: 0px;padding-left: 20px;  border-bottom: 1px solid rgb(204, 204, 204);margin-bottom: 15px;"></div>

                            <?php
                            echo $this->Form->input('profile_id', array(
                                'label' => __('Profile'),
                                'class' => 'form-filter',
                                'empty' => ''
                            ));
                            echo "<div style='clear:both; padding-top: 10px;'></div>";
                            echo $this->Form->input('user_id', array(
                                'label' => __('Created by'),
                                'class' => 'form-filter',
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
                                'class' => 'form-filter',
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





                </div>

            </div>
        </div>
        <!-- end of panel -->


    </div>
    <!-- end of #bs-collapse  -->





    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
    <div class="row" style="clear:both">
        <div class="btn-group pull-left">
            <div class="header_actions">
                <div class="btn-group">
                    <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                        array('action' => 'Add_request'),
                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                    
                    
                </div>
                <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                    'javascript:submitDeleteForm("events/deleteevents/");',
                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                        'disabled' => 'true'),
                    __('Are you sure you want to delete selected events ?')); ?>
                <div class="btn-group">
                    <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Export'),
                        'javascript:exportData("events/export/");',
                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'export', 'disabled' => 'true')) ?>
                    <button type="button" id="export_allmark"
                            class="btn dropdown-toggle btn-inverse  btn-bordred" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <?= $this->Html->link(__('Export All'), 'javascript:exportAllData("export/all_request");') ?>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <div style='clear:both; padding-top: 10px;'></div>
    </div>
    </div>
    </div>
    </div>

                <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <?php echo $this->Form->create('Events', array(
                    'url'=> array(
                        'action' => 'search'
                    ),
                    'novalidate' => true,
                    'id'=>'searchKeyword'
                )); ?>
                <label style="float: right;">
                    <input  id='keyword' type="text" name="keyword" id="keyword" class="form-control" placeholder= <?= __("Search"); ?>>
                    <input  name = "conditions" type="hidden" value = "<?php echo base64_encode( serialize( $conditions ) ); ?>">
                    <input  name = "conditions_car" type="hidden" value = "<?php echo base64_encode( serialize( $conditions_car ) ); ?>">
                    <input  name = "conditions_customer" type="hidden" value = "<?php echo base64_encode( serialize( $conditions_customer ) ); ?>">
                    <?php
                    echo $this->Form->input('request', array(
                        'value'=>'1',
                        'type' => 'hidden',

                    ));
                    echo $this->Form->input('validated', array(

                        'type' => 'hidden',

                    ));
                    ?>

                </label>
                <?php echo $this->Form->end(); ?>
                <div class="bloc-limit btn-group pull-left">
                    <div>
                        <label>
                            <?php
                            if (isset($this->params['pass']['0'])) $limit = $this->params['pass']['0'];
                            ?>
                            <select name="slctlimit" id="slctlimit" onchange="slctlimitChanged('events/index_request');">
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
            <th><?php echo $this->Paginator->sort('EventType.name', __('Type')); ?></th>
            <th><?php echo $this->Paginator->sort('Carmodel.name', __('Car')); ?></th>
            <th><?php echo $this->Paginator->sort('Customer.first_name', __("Conductor")); ?></th>
            <th class="dtm"><?php echo $this->Paginator->sort('date', __('Date')); ?></th>
            <th class="dtm"><?php echo $this->Paginator->sort('next_date', __('Next date')); ?></th>
            <th><?php echo $this->Paginator->sort('km', __('Km')); ?></th>
            <th><?php echo $this->Paginator->sort('next_km', __('Next km')); ?></th>
            <th><?php echo $this->Paginator->sort('cost', __('Cost')); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($events as $event) {
            ?>
            <tr id="row<?= $event['Event']['id'] ?>">
                <td>

                    <input id="idCheck"type="checkbox" class = 'id' value=<?php echo $event['Event']['id'] ?> >
                </td>
                <td><?php echo $event['EventType']['name']; ?></td>
                <td><?php if ($param==1){
                         echo $event['Car']['code']." - ".$event['Carmodel']['name']; 
                         } else if ($param==2) {
                         echo $event['Car']['immatr_def']." - ".$event['Carmodel']['name']; 
                            } ?></td>
                <td>
                    <div class="table-content editable">
                        <span>
                            <?php
                          
                            echo $event['Customer']['first_name'] . " " . $event['Customer']['last_name'];  ?>
                        </span>
                        <select class="form-control table-input select" id="slct"
                                name="<?php echo $this->Event->encrypt("customer_id|".$event['Event']['id']); ?>">
                            <?php foreach($customers as $key => $value) { ?>
                                <option value="<?php echo $key; ?>"
                                    <?php if($key == $event['Customer']['id']) {
                                        echo 'selected="selected"'; } ?>>
                                    <?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                    </div>


                </td>
                <td>
                    <div class="table-content editable">
                        <span>
                            <?php
                            if ($event['Event']['date'] != NULL) {
                                echo h($this->Time->format($event['Event']['date'], '%d-%m-%Y'));
                            } ?>
                        </span>
                        <input name="<?= $this->Event->encrypt("date|".$event['Event']['id']); ?>"
                               placeholder="<?= __('Enter date') ?>"
                               value="<?= $this->Time->format($event['Event']['date'], '%d-%m-%Y') ?>"
                               class="form-control table-input date" type="text" id="date">
                    </div>
                </td>
                <td>
                    <div class="table-content editable">
                        <span>
                            <?php
                            if ($event['Event']['next_date'] != NULL) {
                                echo h($this->Time->format($event['Event']['next_date'], '%d-%m-%Y'));
                            } ?>
                        </span>
                        <input name="<?= $this->Event->encrypt("next_date|".$event['Event']['id']); ?>"
                               placeholder="<?= __('Enter next date') ?>"
                               value="<?= $this->Time->format($event['Event']['next_date'], '%d-%m-%Y') ?>"
                               class="form-control table-input date" type="text" id="nextdate">
                    </div>
                </td>
                <td class="right">
                    <div class="table-content editable">
                        <span>
                            <?php
                            if ($event['Event']['km'] != NULL) {
                                echo h(number_format($event['Event']['km'], 0, ",", "."));
                            } ?>
                        </span>
                        <input name="<?= $this->Event->encrypt("km|".$event['Event']['id']); ?>"
                               placeholder="<?= __('Enter km') ?>" value="<?= $event['Event']['km'] ?>"
                               class="form-control table-input number" type="number">
                    </div>
                </td>
                <td class="right">
                    <div class="table-content editable">
                        <span>
                            <?php
                            if ($event['Event']['next_km'] != NULL) {
                                echo h(number_format($event['Event']['next_km'], 0, ",", "."));
                            } ?>
                        </span>
                        <input name="<?= $this->Event->encrypt("next_km|".$event['Event']['id']); ?>"
                               placeholder="<?= __('Enter next km') ?>" value="<?= $event['Event']['next_km'] ?>"
                               class="form-control table-input number" type="number">
                    </div>
                </td>
                <td class="right">
                    <div class="table-content editable">
                        <span>
                            <?php echo h(number_format($event['Event']['cost'], 2, ",", ".")); ?>
                        </span>
                        <input name="<?= $this->Event->encrypt("cost|".$event['Event']['id']); ?>"
                               placeholder="<?= __('Enter cost') ?>" value="<?= $event['Event']['cost'] ?>"
                               class="form-control table-input cost" type="number">
                    </div>
                </td>
                <td class="actions">
                 <?php

                            if($event['Event']['validated'] == 1){
                                
                                   echo '<i class="fa  fa-check green" title="'.__('Request validated').'"></i>';

                                  
                            }else{
                                echo $this->Html->link(
                                    '<i class="fa  fa-times red" title="'.__('Validate request').'"></i>',
                                    array('action' => 'validate_request', $event['Event']['id']),
                                    array('escape' => false)
                                );
                            }

                        ?>





                    <?= $this->Html->link(
                        '<i class="  fa fa-eye m-r-5" title="'.__('View').'"></i>',
                        array('action' => 'View', $event['Event']['id']),
                        array('escape' => false)
                    ); ?>
                    <?= $this->Html->link(
                        '<i class=" fa fa-edit m-r-5" title="'.__('Edit').'"></i>',
                        array('action' => 'Edit_request', $event['Event']['id']),
                        array('escape' => false)
                    ); ?>

                    <?php if (isset($event['Event']['attachment']) && !empty($event['Event']['attachment']) ) {

                    echo $this->Html->link(
                        '<i class="fa fa-paperclip m-r-5" title="' . __('Attachments') . '"></i>',

                      
                        array('action' => 'View', $event['Event']['id']),
                        array('escape' => false)

                    );
                    } else {
                        
                        echo $this->Html->link(
                            '<i class=" fa fa-unlink m-r-5" title="' . __('Missing attachments') . '"></i>',

                            array('action' => 'Edit_request', $event['Event']['id']),
                            array('escape' => false)

                        );
                        } ?>


                    <?php
                        if($event['Event']['locked'] == 1){
                            echo $this->Html->link(
                                '<i class=" fa  fa-lock m-r-5" title="'.__('Unlock').'"></i>',
                                array('action' => 'unlock', $event['Event']['id']),
                                array('escape' => false)
                            );
                        }else{
                            echo $this->Html->link(
                                '<i class=" fa  fa-unlock  m-r-5" title="'.__('Lock').'"></i>',
                                array('action' => 'lock', $event['Event']['id']),
                                array('escape' => false)
                            );
                        }

                     ?>
                    <?php echo $this->Form->postLink(
                        '<i class=" fa fa-trash-o m-r-5" title="'.__('Delete').'"></i>',
                        array('action' => 'Delete', $event['Event']['id']),
                        array('escape' => false),
                        __('Are you sure you want to delete this event?')); ?>
                </td>
            </tr>
        <?php }
        ?>
        </tbody>
    </table>
                <?php
                if ($this->params['paging']['Event']['pageCount'] > 1) {
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



<?php $this->start('script'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('jquery.number.min.js'); ?>
<script type="text/javascript">

    $(document).ready(function() {
        jQuery("#date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#nextdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});


        jQuery("#startdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#date3").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    });








    </script>
<?php
    if ($this->Session->read('Auth.User.role_id') == 3) { ?>
<script type="text/javascript">


    $(document).ready(function() {

        // Show the text box on click
        $('body').delegate('.editable', 'click', function () {
            var ThisElement = $(this);
            ThisElement.find('span').hide();
            ThisElement.find('.table-input').show().focus();
        });

        // Pass and save the textbox values on blur function
        $('body').delegate('.table-input', 'blur', function () {
            var ThisElement = $(this);
            ThisElement.hide();
            if($(this).val() == "") {
                ThisElement.val('');
            }
            if (ThisElement.hasClass('number')) {
                if($(this).val() == "") ThisElement.prev('span').show().html($(this).val()).prop('title', $(this).val());
                else
                    ThisElement.prev('span').show().html($.number( $(this).val(), 0, ',', '.' )).prop('title', $(this).val());

            }else if(ThisElement.hasClass('cost')){
                if($(this).val() == "") ThisElement.prev('span').show().html($(this).val()).prop('title', $(this).val());
                else
                    ThisElement.prev('span').show().html($.number( $(this).val(), 2, ',', '.' )).prop('title', $(this).val());
            }else if(ThisElement.hasClass('date')){
                ThisElement.prev('span').show().html($(this).val()).prop('title', $(this).val());
            }else if(ThisElement.hasClass('select')){
                ThisElement.prev('span').show().html($(this).find("option:selected").text());
            }else{
                ThisElement.prev('span').show().html($(this).val()).prop('title', $(this).val());
            }

            var UrlToPass = 'id=update&value=' + ThisElement.val() + '&crypto=' + ThisElement.prop('name');

            jQuery.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url('/events/update/')?>",
                data: UrlToPass,
                dataType: "json",
                success: function (json) {

                }
            });
        });

        // Same as the above blur() when user hits the 'Enter' key
        $('body').delegate('.table-input', 'keypress', function (e) {
            if (e.keyCode == '13') {
                var ThisElement = $(this);
                ThisElement.hide();
                if($(this).val() == "") {
                    ThisElement.val('');
                }
                if (ThisElement.hasClass('number')) {
                    if($(this).val() == "") ThisElement.prev('span').show().html($(this).val()).prop('title', $(this).val());
                    else
                        ThisElement.prev('span').show().html($.number( $(this).val(), 0, ',', '.' )).prop('title', $(this).val());

                }else if(ThisElement.hasClass('cost')){
                    if($(this).val() == "") ThisElement.prev('span').show().html($(this).val()).prop('title', $(this).val());
                    else
                        ThisElement.prev('span').show().html($.number( $(this).val(), 2, ',', '.' )).prop('title', $(this).val());
                }else if(ThisElement.hasClass('date')){
                    ThisElement.prev('span').show().html($(this).val()).prop('title', $(this).val());
                }else if(ThisElement.hasClass('select')){
                    ThisElement.prev('span').show().html($(this).find("option:selected").text());
                }else{
                    ThisElement.prev('span').show().html($(this).val()).prop('title', $(this).val());
                }

                var UrlToPass = 'id=update&value=' + ThisElement.val() + '&crypto=' + ThisElement.prop('name');

                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo $this->Html->url('/events/update/')?>",
                    data: UrlToPass,
                    dataType: "json",
                    success: function (json) {

                    }
                });
            }
        });
        function toggleIcon(e) {
            $(e.target)
                .prev('.panel-heading')
                .find(".more-less")
                .toggleClass(' glyphicon-chevron-down  glyphicon-chevron-up');
        }
        $('.panel-group').on('hidden.bs.collapse', toggleIcon);
        $('.panel-group').on('shown.bs.collapse', toggleIcon);
    });

</script>
<?php } ?>
<?php $this->end(); ?>
