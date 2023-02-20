<?php

?><h4 class="page-title"> <?=__('Car per parc, supplier'); ?></h4>
<div class="box-body">

    <div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
    <div class="card-box p-b-20">
    <?php echo $this->Form->create('Statistic', array(
        'url'=> array(
            'action' => 'listcarparcsupplier'
        ),
        'novalidate' => true
    )); ?>
    <div class="filters" id='filters' style='display: block;'>
        <?php
        echo $this->Form->input('supplier_id', array(
                    'label' => __('Supplier'),
                    'class' => 'form-filter select2',
                    'id'=>'supplier ',
                    'empty' => ''
                    ));
        echo $this->Form->input('parc_id', array(
                    'label' =>('Parc'),
                    'class' => 'form-filter select2',
                    'id'=>'parc',
                    'empty' => ''
                    ));
        
        
        ?>
        <div style='clear:both; padding-top: 5px;'></div>
        <button style="float: right;" class="btn btn-success btn-trans waves-effect w-md waves-success" type="submit"><?= __('Search') ?></button>
        <div style='clear: both; padding-top: 10px;'></div>
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
                 <!--   <div class="btn-group">
                        <?= $this->Html->link('<i class="glyphicon glyphicon-export"></i>' . __('Export Pdf'),
                            /*array('action' => 'listcarparcsupplier_pdf', 'ext'=>'pdf'),*/
                            'javascript:exportDataPdf(); ',
                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id'=>'export')) ?>


                    </div>-->

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

    <table class="table table-striped table-bordered dt-responsive nowrap"  cellspacing="0" width="100%" id='table_parc_supplier'>

        
        <thead>

            <th><?= __('Cars') ?></th>
            <th><?= __('Parcs') ?></th>
            <th><?= __('Suppliers') ?></th>
            <th><?= __('Current price') ?></th>
        </thead>
        <tbody>
            
                <?php 
                $current_price=0;
                foreach ($results as $result){?>
                <tr>

                <td><?php if ($param==1){
                         echo $result['car']['code']." - ".$result['carmodels']['name']; 
                         } else if ($param==2) {
                         echo $result['car']['immatr_def']." - ".$result['carmodels']['name']; 
                            } ?></td>
                <td><?php echo  $result['parcs']['name']?></td>
                <td><?php echo  $result['suppliers']['name']?></td>
                <td><?php echo  $result['car']['current_price'] . " " . $this->Session->read("currency")?></td>
</tr>
                <?php    
                $current_price=$current_price+ $result['car']['current_price'];
                 }
                
                
                
                
                ?>
            
        </tbody>
    </table>
        <br/>
        <?php echo "<b style='float:left ; line-height:35px'>".__('Total amount : ')."</b>  &nbsp <b style='color:#10c469 ; line-height:35px'>" .number_format($current_price,2,",","."). " " . $this->Session->read("currency")."</b> "; ?>


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



        });

        function exportDataPdf() {
            var parc_supplier = new Array();
            parc_supplier[0] = jQuery('#parc').val();
            parc_supplier[1] = jQuery('#supplier').val();
            
            var url = '<?php echo $this->Html->url(array('action' => 'listcarparcsupplier_pdf', 'ext' => 'pdf'))?>';
            var form = jQuery('<form action="' + url + '" method="post" >' +
            '<input type="text" name="parcsupplier" value="' + parc_supplier + '" />' +
            '</form>');
            jQuery('body').append(form);
            form.submit();

       

    }

     function exportDataExcel() {

    $('#table_parc_supplier').tableExport({

        type: 'excel',
        charset: 'charset=utf8mb4_bin',
        espace: 'false',
        htmlContent:'false',
});
} 
</script>
<?php $this->end(); ?>