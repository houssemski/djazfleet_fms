<?php
?><h4 class="page-title"> <?=__('Monthly consumption per car'); ?></h4>
    <div class="box-body">
    <div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
    <div class="card-box p-b-20">
        <?php echo $this->Form->create('Statistic', array(
            'url'=> array(
                'action' => 'listKmByMonth'
            ),
            'novalidate' => true
        )); ?>
        <div class="filters" id='filters' style='display: block;'>
            <?php
            echo $this->Form->input('car_id', array(
                'label' => __('Car'),
                'class' => 'form-filter select2',
                'id' =>'car',
                'empty' => ''
            ));
            echo $this->Form->input('year', array(
                'label' => '',
                'type' => 'text',
                'class' => 'form-control datemask',
                'before' => '<label class="dte">' . __('Year') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                'after' => '</div>',
                'id' => 'year',
            ));
            ?>
            <div style='clear:both; padding-top: 10px;'></div>
            <?php
            echo $this->Form->input('min_month', array(
                'label' => '',
                'type' => 'text',
                'class' => 'form-control datemask',
                'before' => '<label class="dte">' . __('From') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                'after' => '</div>',
                'id' => 'min_month',
            ));
            echo $this->Form->input('max_month', array(
                'label' => '',
                'type' => 'text',
                'class' => 'form-control datemask',
                'before' => '<label class="dte">' . __('To') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                'after' => '</div>',
                'id' => 'max_month',
            ));
            ?>
            <div style='clear:both; padding-top: 5px;'></div>
            <button style="float: right;" class="btn btn-success btn-trans waves-effect w-md waves-success" type="submit"><?= __('Search') ?></button>
            <div style='clear:both; padding-top: 10px;'></div>
        </div>
        <?php echo $this->Form->end(); ?>

          <div class="row" style="clear: both">
            <div class="btn-group pull-left">
                <div class="header_actions">
                    <div class="btn-group">
                    <?= $this->Html->link('<i class="glyphicon glyphicon-export"></i>' . __('Export Excel'),
                       
                        'javascript:exportDataExcel();',
                         array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id'=>'export_excel')) ?>


                </div>
                    <div class="btn-group">
                        <?= $this->Html->link('<i class="glyphicon glyphicon-export"></i>' . __('Export Pdf'),
                        'javascript:exportDataPdf();',
                         array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id'=>'export')) ?>
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
        <table class="table table-striped table-bordered mini-table" id='table_km_month'>
            <thead style="width: auto">
            <th><?= __('Month') ?></th>
            <th><?= __('Km') ?></th>
            </thead>
            <tbody>
            <?php
            foreach ($cars as $key => $value) {
                if ($results) {
                    foreach ($results as $result) {
                        if ($result['id'] == $key) {
                            $isKmNull = true;
                            for ($i = 1; $i <= 12; $i++) {
                                if($result[$i] > 0) $isKmNull = false;
                            }
                            if(!$isKmNull){
                                echo "<tr style='width: auto;'>" .
                                    "<td colspan='10' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
background-color: rgba(16, 196, 105, 0.15) !important;
color: #10c469 !important;font-weight:bold;'>"
                                    . $value . "</td></tr>";
                                for ($i = 1; $i <= 12; $i++) {
                                    switch ($i) {
                                        case 1 :
                                            $label = __("January");
                                            break;
                                        case 2 :
                                            $label = __("February");
                                            break;
                                        case 3 :
                                            $label = __("March");
                                            break;
                                        case 4 :
                                            $label = __("April");
                                            break;
                                        case 5 :
                                            $label = __("May");
                                            break;
                                        case 6 :
                                            $label = __("June");
                                            break;
                                        case 7 :
                                            $label = __("July");
                                            break;
                                        case 8 :
                                            $label = __("August");
                                            break;
                                        case 9 :
                                            $label = __("September");
                                            break;
                                        case 10 :
                                            $label = __("October");
                                            break;
                                        case 11 :
                                            $label = __("November");
                                            break;
                                        case 12 :
                                            $label = __("December");
                                            break;
                                    }
                                    if($result[$i] > 0){
                                        echo "<tr><td>" . $label . "</td>";
                                        echo "<td class='right'>" . number_format($result[$i], 0, ",", ".") .
                                            "</td></tr>";
                                    }

                                }
                            }

                        }
                    }
                }
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

        $(document).ready(function() {
            jQuery("#year").inputmask("y", {"placeholder": "yyyy"});
            jQuery("#min_month").inputmask("m", {"placeholder": "mm"});
            jQuery("#max_month").inputmask("m", {"placeholder": "mm"});


        });


         function exportDataPdf() {
            var km_month = new Array();
            km_month[0] = jQuery('#car').val();
            km_month[1] = jQuery('#year').val();
            km_month[2] = jQuery('#min_month').val();
            km_month[3] = jQuery('#max_month').val();
            
            var url = '<?php echo $this->Html->url(array('action' => 'listkmbymonth_pdf', 'ext' => 'pdf'))?>';
            var form = jQuery('<form action="' + url + '" method="post" >' +
            '<input type="text" name="kmmonth" value="' + km_month + '" />' +
            '</form>');
            jQuery('body').append(form);
            form.submit();

       

    }

     function exportDataExcel() {

    $('#table_km_month').tableExport({

        type: 'excel',
        espace: 'false',
        htmlContent:'false'
});
}
    </script>
<?php $this->end(); ?>