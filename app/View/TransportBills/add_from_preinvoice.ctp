
<h4 class="page-title"> <?=__("Add invoice");?></h4>
<?php
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
$this->end();
echo $this->Form->input('type', array(
    'label' => __('Type'),
    'class' => 'form-filter',
    'id' => 'type_doc',
    'type' => 'hidden',
    'value' => 7,
    'empty' => ''
));
echo $this->Form->input('select_with_pagination', array(
    'class' => 'form-filter',
    'id' => 'select_with_pagination',
    'type' => 'hidden',
    'value' => 0,
    'empty' => ''
));
?>
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

                    <div class="filters" id='filters'>

                        <?php   echo $this->Form->create('transportBills', array(
                            'url'=> array(
                                'action' => 'addFromPreinvoice'
                            ),
                            'novalidate' => true,
                            'onsubmit'=> 'javascript:disable();'
                        ));

                        echo $this->Form->input('type', array(
                            'label' => __('type'),
                            'type'=>'hidden',
                            'id'=>'type',
                            'value'=>7,
                            'class' => 'form-filter',
                            'empty' => ''
                        ));
                        echo $this->Form->input('detail_ride_id', array(
                            'label' => __('Ride'),
                            'class' => 'form-filter select-search-detail-ride',
                            'empty' => ''
                        ));

                        echo $this->Form->input('supplier_id', array(
                            'label' => __('Client'),
                            'class' => 'form-filter select-search-client-initial',
                            'id' => 'supplier',
                            'empty' => ''
                        ));

                        echo "<div style='clear:both; padding-top: 10px;'></div>";



                        echo $this->Form->input('date_from', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">'.__('Date from').'</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'date_from',
                        ));

                        echo $this->Form->input('date_to', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">'.__('Date from').'</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'date_to',
                        ));


                        echo "<div style='clear:both; padding-top: 10px;'></div>";


                        ?>



                        <button class="btn btn-default" type="submit"><?= __('Search') ?></button>
                        <div style='clear:both; padding-top: 10px;'></div>
                    </div>






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
   
    <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>'.__('Add'),
                                'javascript:addPreinvoice();', 
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'add_prefacture',
                                    )
                                ); ?>


            </div>
        </div>
        <div style='clear:both; padding-top: 10px;'></div>
        <div id="dialogModalClient">
            <!-- the external content is loaded inside this tag -->

        </div>

    </div>
    </div>
    </div>
    </div>
    <?php
    $query = $this->Session->read('query');
    extract($query);
    $tableId = strtolower($tableName) . '-grid';
    /** @var array $columns */
    /** @var string $tableName */
    ?>
    <!--    Content section    -->
    <?= $this->element('index-body-content', array(
        "tableId" => $tableId,
        "tableName" => $tableName,
        "columns" => $columns,
    ));
    ?>
    <!--    End content section    -->


    <!--    DataTables Script    -->
    <?= $this->element('data-tables-script', array(
        "tableId" => $tableId,
        "tableName" => $tableName,
        "columns" => $columns,
        "defaultLimit" => $defaultLimit,
    ));
    ?>
    <!--    End dataTables Script    -->



<?php $this->start('script'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
<?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
<script type="text/javascript">

    $(document).ready(function() {
        jQuery("#date_to").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#date_from").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        jQuery('input.checkall').on('ifClicked', function (event) {
            var cases = jQuery(":checkbox.id");
            if (jQuery('#checkall').prop('checked')) {
                cases.iCheck('uncheck');
                jQuery("#add_prefacture").attr("disabled", "true");
            } else
            {
                cases.iCheck('check');
                jQuery("#add_prefacture").removeAttr("disabled");
            }

        });

        jQuery('input.id').on('ifUnchecked', function (event) {
            var ischecked = false;
            jQuery(":checkbox.id").each(function () {
                if (jQuery(this).prop('checked'))
                    ischecked = true;
            });
            if (!ischecked) {
                jQuery("#add_prefacture").attr("disabled", "true");
            }
        });

        jQuery('input.id').on('ifChecked', function (event) {
            jQuery("#add_prefacture").removeAttr("disabled");
        });


        jQuery("#dialogModalClient").dialog({
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



   /*  function addPreinvoice()
     {
       
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
            
        });
		type= jQuery('#type').val();
        var url = ' echo $this->Html->url('/transportBills/addPreinvoice/')?>'+ type;
        var form = jQuery('<form action="' + url + '" method="post">' +
        '<input type="text" name="chkids" value="' + myCheckboxes + '" />' +
        '</form>');
        jQuery('body').append(form);
        form.submit();

    }*/


    function addPreinvoice() {
        var type_doc=jQuery('#type_doc').val();
        var selectWithPagination = $('#select_with_pagination').val();
        if($('#select_with_pagination').val()==1){

            jQuery('#dialogModalClient').dialog('option', 'title', 'Choisir le client');
            jQuery('#dialogModalClient').dialog('open');
            jQuery('#dialogModalClient').load('<?php echo $this->Html->url('/transportBills/addPreinvoice/')?>' + type_doc+ '/'+selectWithPagination);

        }else {
            var dataTable = jQuery('#<?= $tableId ?>').DataTable();
            var myCheckboxes = new Array();
            jQuery.each(dataTable.rows('.selected').data(), function (key, item) {
                myCheckboxes.push(item[<?= count($columns) + 1 ?>]);
            });
            if(myCheckboxes.length>0){
                jQuery('#dialogModalClient').dialog('option', 'title', 'Choisir le client');
                jQuery('#dialogModalClient').dialog('open');
                jQuery('#dialogModalClient').load('<?php echo $this->Html->url('/transportBills/addPreinvoice/')?>' + type_doc+ '/'+selectWithPagination+ '/'+myCheckboxes);

            }
        }

    }
	


  
   




 </script>
<?php $this->end(); ?>
</div>
     
            
