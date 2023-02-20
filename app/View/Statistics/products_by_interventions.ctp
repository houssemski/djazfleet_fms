<?php

?><h4 class="page-title"> <?= __('Intervention details'); ?></h4>
    <div class="box-body">
        <div class="row">
            <!-- BASIC WIZARD -->
            <div class="col-lg-12">
                <div class="card-box p-b-20">
                    <?php echo $this->Form->create('Statistic', array(
                        'url' => array(
                            'action' => 'productsByInterventions'
                        ),
                        'novalidate' => true
                    )); ?>
                    <div class="filters" id='filters' style='display: block;'>
                        <?php
                        echo $this->Form->input('car_id', array(
                            'label' => __('Car'),
                            'class' => 'form-filter select2',
                            'id' => 'car',
                            'empty' => ''
                        ));
                        echo $this->Form->input('customer_id', array(
                            'label' => __('Applicant'),
                            'class' => 'form-filter select2',
                            'id' => 'customer',
                            'empty' => ''
                        ));
                        echo $this->Form->input('event_type_id', array(
                            'label' => __('Repair type'),
                            'class' => 'form-filter select2',
                            'id' => 'event_type',
                            'empty' => ''
                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('supplier_id', array(
                            'label' => __('Supplier'),
                            'class' => 'form-filter select2',
                            'id' => 'supplier',
                            'empty' => ''
                        ));
                        echo $this->Form->input('product_id', array(
                            'label' => __('Product'),
                            'class' => 'form-filter select2',
                            'id' => 'product',
                            'empty' => ''
                        ));
                        echo $this->Form->input('structure_id', array(
                            'label' => __('Structure'),
                            'class' => 'form-filter select2',
                            'id' => 'structure',
                            'empty' => ''
                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('date', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Start') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'startdate',
                        ));
                        echo $this->Form->input('next_date', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('End') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'enddate',
                        ));
                        echo $this->Form->input('parc_id', array(
                            'label' => __('Parc'),
                            'class' => 'form-filter',
                            'id' => 'parc',
                            'type' => 'select',
                            'options' => $parcs,
                            'empty' => ''
                        ));
                        ?>
                        <div style='clear:both; padding-top: 5px;'></div>
                        <button style="float: right;" class="btn btn-success btn-trans waves-effect w-md waves-success"
                                type="submit"><?= __('Search') ?></button>
                        <div style='clear:both; padding-top: 10px;'></div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                    <div class="row" style="clear: both">
                        <div class="btn-group pull-left">
                            <div class="header_actions">
                                <div class="btn-group">
                                    <?= $this->Html->link('<i class="glyphicon glyphicon-export"></i>' . __('Export Excel'),

                                        'javascript:exportDataExcel();',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'export_excel')) ?>


                                </div>
                                <div class="btn-group">
                                    <?= $this->Html->link('<i class="glyphicon glyphicon-export"></i>' . __('Export Pdf'),
                                        /* array('action' => 'listcarparcsupplier_pdf', 'ext'=>'pdf'),*/
                                        'javascript:exportDataPdf();',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>


                                </div>




                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- BASIC WIZARD -->
            <div class="col-lg-12">
                <div class="card-box p-b-20">
                    <table class="table table-striped table-bordered" style="table-layout: fixed;"
                           id='table'>
                        <thead style="width: auto">
                        <th><?= __('Reference') ?></th>
                        <th><?= __('Repair type') ?></th>
                        <th><?= __('Repair date') ?></th>
                        <th><?= __('Car') ?></th>
                        <th><?= __('Applicant') ?></th>
                        <th><?= __('Structure') ?></th>
                        <th><?= __('Supplier') ?></th>
                        <th><?= __('Product') ?></th>
                        <th><?= __('unit price') ?></th>
                        <th><?= __('quantity') ?></th>
                        <th><?= __('Price') ?></th>
                        </thead>
                        <tbody>
                        <?php
                        if(!empty($results)){
                            foreach ($results as $result){ ?>
                                <tr>
                                <td><?= $result['event']['code'];?></td>
                                <td><?= $result['event_types']['name']?></td>
                                <td><?= $this->Time->format($result['event']['intervention_date'], '%d-%m-%Y')?></td>
                                <td><?= $result['car']['immatr_def'] .' - '. $result['carmodels']['name']?></td>
                                <td><?= $result['customers']['first_name'] .' - '.$result['customers']['last_name'] ?></td>
                                <td><?= $result['structures']['name']?></td>
                                <td><?= $result['suppliers']['name']?></td>
                                <td><?= $result['products']['name']?></td>
                                <td><?= number_format($result['event_products']['price']/2, 0, ",", ".")?></td>
                                <td><?= $result['event_products']['quantity'] ?></td>
                                <td><?= number_format($result['event_products']['price'], 0, ",", ".")?></td>
                                </tr>

                           <?php }
                        }

                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
<?php $this->start('script'); ?>
    <!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('tableExport/tableExport'); ?>
<?= $this->Html->script('tableExport/jquery.base64'); ?>
<?= $this->Html->script('tableExport/html2canvas'); ?>
<?= $this->Html->script('tableExport/jspdf/jspdf'); ?>
<?= $this->Html->script('tableExport/jspdf/libs/sprintf'); ?>
<?= $this->Html->script('tableExport/jspdf/libs/base64'); ?>
    <!-- Page script -->
    <script type="text/javascript">

        $(document).ready(function () {
            jQuery("#startdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            jQuery("#enddate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});


        });

        function exportDataPdf() {

            var product_intervention = new Array();
            product_intervention[0] = jQuery('#car').val();
            product_intervention[1] = jQuery('#customer').val();
            product_intervention[2] = jQuery('#event_type').val();
            product_intervention[3] = jQuery('#supplier').val();
            product_intervention[4] = jQuery('#product').val();
            product_intervention[5] = jQuery('#structure').val();
            product_intervention[6] = jQuery('#startdate').val();
            product_intervention[7] = jQuery('#enddate').val();
            product_intervention[8] = jQuery('#parc').val();
            var url = '<?php echo $this->Html->url(array('action' => 'productsByInterventionsPdf', 'ext' => 'pdf'))?>';
            var form = jQuery('<form action="' + url + '" method="post" >' +
                '<input type="text" name="product_intervention" value="' + product_intervention + '" />' +
                '</form>');
            jQuery('body').append(form);
            form.submit();


        }

        function exportDataExcel() {
            var product_intervention = new Array();
            product_intervention[0] = jQuery('#car').val();
            product_intervention[1] = jQuery('#customer').val();
            product_intervention[2] = jQuery('#event_type').val();
            product_intervention[3] = jQuery('#supplier').val();
            product_intervention[4] = jQuery('#product').val();
            product_intervention[5] = jQuery('#structure').val();
            product_intervention[6] = jQuery('#startdate').val();
            product_intervention[7] = jQuery('#enddate').val();
            product_intervention[8] = jQuery('#parc').val();
            var url = '<?php echo $this->Html->url(array('action' => 'exportProductsByInterventions'))?>';
            var form = jQuery('<form action="' + url + '" method="post" >' +
                '<input type="hidden" name="product_intervention" value="' + product_intervention + '" />' +
                '</form>');
            jQuery('body').append(form);
            form.submit();
        }

        function exportSynExcel() {
            var car_consumption = new Array();
            car_consumption[0] = jQuery('#car').val();
            car_consumption[1] = jQuery('#startdate').val();
            car_consumption[2] = jQuery('#enddate').val();
            var url = '<?php echo $this->Html->url(array('action' => 'export_synthese'))?>';
            var form = jQuery('<form action="' + url + '" method="post" >' +
                '<input type="text" name="carconsumption" value="' + car_consumption + '" />' +
                '</form>');
            jQuery('body').append(form);
            form.submit();
        }
    </script>
<?php $this->end(); ?>