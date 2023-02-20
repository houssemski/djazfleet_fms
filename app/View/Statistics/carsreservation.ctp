<?php
?><h4 class="page-title"> <?= __('Cars reservations'); ?></h4>
    <div class="box-body">


    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-20">

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
                                    array('action' => 'carsreservation_pdf', 'ext' => 'pdf'),

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

                <table class="table table-striped stats1 table-bordered " id='table_reservation'>


                    <thead>

                    <th><?= __('Car') ?></th>
                    <th><?= __("Conductor") . __(' /Group') ?></th>

                    </thead>
                    <tbody>

                    <?php


                    foreach ($results as $result) {
                        ?>
                        <tr>

                            <td><?php if ($param == 1) {
                                    echo $result['car']['code'] . " - " . $result['carmodels']['name'];
                                } else if ($param == 2) {
                                    echo $result['car']['immatr_def'] . " - " . $result['carmodels']['name'];
                                } ?></td>

                            <?php if (isset($result['customers']['first_name']) && !empty($result['customers']['first_name'])) { ?>

                                <td><?php echo $result['customers']['first_name'] ?><?php echo $result['customers']['last_name'] ?></td>
                            <?php } else { ?>
                                <td><?php echo $result['customer_groups']['name'] ?></td>
                            <?php } ?>
                        </tr>
                    <?php }


                    ?>

                    </tbody>
                </table>
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
    <script type="text/javascript">     $(document).ready(function () {
        });


        function exportDataPdf() {

            var url = '<?php echo $this->Html->url(array('action' => 'carsreservations_pdf', 'ext' => 'pdf'))?>';

        }

        function exportDataExcel() {

            var url = '<?php echo $this->Html->url('/statistics/carsReservationExcel/')?>';
            var form = jQuery('<form action="' + url + '" method="post">' +
                '</form>');
            jQuery('body').append(form);
            form.submit();

        }

        function excelExport(url) {
            jQuery.ajax({
                type: 'POST',
                url: url,
                error: function() {
                    alert("Une erreur est survenue lors de l'exportation");
                }
            }).done(function(data) {
                let json = JSON.parse(data);
                if (json[0] === 'error') {
                    alert("Une erreur est survenue lors de l'exportation");
                } else {
                    window.open("<?php echo $this->Html->url('/', true); ?>" + json[1]);
                }
            });
        }
    </script>
<?php $this->end(); ?>