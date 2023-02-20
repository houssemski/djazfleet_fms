<?php

?><h4 class="page-title"> <?= __('Intervention details'); ?></h4>
    <div class="box-body">
        <div class="row">
            <!-- BASIC WIZARD -->
            <div class="col-lg-12">
                <div class="card-box p-b-20">
                    <?php echo $this->Form->create('Statistic', array(
                        'url' => array(
                            'action' => 'carByWorkshops'
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
                        echo $this->Form->input('mechanician_id', array(
                            'label' => __('Mechanician'),
                            'class' => 'form-filter select2',
                            'id' => 'mechanic',
                            'empty' => ''
                        ));
                        echo $this->Form->input('workshop_id', array(
                            'label' => __('Workshop'),
                            'class' => 'form-filter select2',
                            'id' => 'workshop',
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
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'export')) ?>


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
                        <th><?php echo  __('Car'); ?></th>
                        <th><?php echo  __("Mecanicien"); ?></th>
                        <th><?php echo  __("Workshop"); ?></th>
                        <th class="dtm"><?php echo __('Workshop entry date'); ?></th>
                        <th class="dtm"><?php echo  __('Workshop exit date'); ?></th>


                        </thead>
                        <tbody>
                        <?php
                        if(!empty($results)){
                            $allDiffDays = 0;
                            $carId = $results[0]['car']['id'];
                            $carName = $results[0]['car']['immatr_def'] .' - '. $results[0]['carmodels']['name'];
                            foreach ($results as $result){
                                if($carId == $result['car']['id']){
                                    $firstDate  = new DateTime($result['event']['workshop_entry_date']);
                                    $secondDate = new DateTime($result['event']['workshop_exit_date']);
                                    $interval = $firstDate->diff($secondDate);
                                    $diffDays = $interval->days ;
                                    $allDiffDays = $allDiffDays + $diffDays;
                                ?>
                                <tr>
                               <td><?= $result['car']['immatr_def'] .' - '. $result['carmodels']['name']?></td>
                                <td><?= $result['customers']['first_name'] .' - '.$result['customers']['last_name'] ?></td>
                                <td><?= $result['workshops']['name']?></td>
                                    <td><?= $this->Time->format($result['event']['workshop_entry_date'], '%d-%m-%Y')?></td>

                                    <td><?= $this->Time->format($result['event']['workshop_exit_date'], '%d-%m-%Y')?></td>

                                </tr>

                           <?php }else {
                                    echo "<tr style='width: auto;'>" .
                                        "<td colspan='5' style='border: 1px solid rgba(16, 196, 105, 0.1) !important; background-color: rgba(16, 196, 105, 0.15) !important; color: #10c469 !important;font-weight:bold; text-align: center'>"
                                      .$carName .' '.  __('total downtime') .' ' . $allDiffDays . ' '.__('Days')."</td></tr>";
                                    $carId = $result['car']['id'];
                                    $carName = $result['car']['immatr_def'] .' - '. $result['carmodels']['name'];
                                    $allDiffDays = 0;

                        $firstDate  = new DateTime($result['event']['workshop_entry_date']);
                        $secondDate = new DateTime($result['event']['workshop_exit_date']);
                        $interval = $firstDate->diff($secondDate);
                        $diffDays = $interval->days ;
                        $allDiffDays = $allDiffDays + $diffDays;
                        ?>
                        <tr>
                            <td><?= $result['car']['immatr_def'] .' - '. $result['carmodels']['name']?></td>
                            <td><?= $result['customers']['first_name'] .' - '.$result['customers']['last_name'] ?></td>
                            <td><?= $result['workshops']['name']?></td>
                            <td><?= $this->Time->format($result['event']['workshop_entry_date'], '%d-%m-%Y')?></td>

                            <td><?= $this->Time->format($result['event']['workshop_exit_date'], '%d-%m-%Y')?></td>

                        </tr>


                       <?php         }

                            }
                            echo "<tr style='width: auto;'>" .
                                "<td colspan='5' style='border: 1px solid rgba(16, 196, 105, 0.1) !important; background-color: rgba(16, 196, 105, 0.15) !important; color: #10c469 !important;font-weight:bold; text-align: center'>"
                                .$carName .' '.  __('total downtime') .' ' . $allDiffDays . ' '.__('Days')."</td></tr>";
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
            var car_workshop = new Array();
            car_workshop[0] = jQuery('#car').val();
            car_workshop[1] = jQuery('#mechanic').val();
            car_workshop[2] = jQuery('#workshop').val();
            car_workshop[3] = jQuery('#startdate').val();
            car_workshop[4] = jQuery('#enddate').val();
            var url = '<?php echo $this->Html->url(array('action' => 'carByWorkshopsPdf', 'ext' => 'pdf'))?>';
            var form = jQuery('<form action="' + url + '" method="post" >' +
                '<input type="text" name="car_workshop" value="' + car_workshop + '" />' +
                '</form>');
            jQuery('body').append(form);
            form.submit();


        }

        function exportDataExcel() {
            var car_workshop = new Array();
            car_workshop[0] = jQuery('#car').val();
            car_workshop[1] = jQuery('#mechanic').val();
            car_workshop[2] = jQuery('#workshop').val();
            car_workshop[3] = jQuery('#startdate').val();
            car_workshop[4] = jQuery('#enddate').val();
            var url = '<?php echo $this->Html->url(array('action' => 'exportCarByWorkshops'))?>';
            var form = jQuery('<form action="' + url + '" method="post" >' +
                '<input type="hidden" name="car_workshop" value="' + car_workshop + '" />' +
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