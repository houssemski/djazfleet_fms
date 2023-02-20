<?php

    
       
?><h4 class="page-title"> <?=__('Fuel stock card'); ?></h4>




    <div class="box-body">
    <div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
    <div class="card-box p-b-20">
        <?php echo $this->Form->create('Statistic', array(
            'url'=> array(
                'action' => 'stockFuellog'
            ),
            'novalidate' => true
        )); ?>
        <div class="filters" id='filters' style='display: block;'>
           
               <div class="input select">
        <label for="bill"><?= __('Num bill') ?></label>
        <select name="data[Statistic][num_bill]" class="form-filter" id="bill">
            <option value=""><?= __('') ?></option>
            <?php
            foreach ($num_bills as $num_bill) {
                
                    echo '<option value="'.$num_bill['FuelLog']['num_bill'].'">'.$num_bill['FuelLog']['num_bill'].'</option>'."\n";
                

            }
            ?>
        </select>
    </div>

        <?php    echo "<div style='clear:both; padding-top: 10px;'></div>";
            echo $this->Form->input('date', array(
                'label' => '',
                'type' => 'text',
                'class' => 'form-control datemask',
                'before' => '<label class="dte">'.__('Start').'</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                'after' => '</div>',
                'id' => 'startdate',
            ));
            echo $this->Form->input('next_date', array(
                'label' => '',
                'type' => 'text',
                'class' => 'form-control datemask',
                'before' => '<label class="dte">'.__('End').'</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                'after' => '</div>',
                'id' => 'enddate',
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
            <!--    <div class="btn-group">
                     /*$this->Html->link('<i class="glyphicon glyphicon-export"></i>' . __('Export Pdf'),
                        
                        'javascript:exportDataPdf();',
                         array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id'=>'export'))*/


                </div> -->

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
        <table class="table table-striped table-bordered" id='table_fuellog'>
            <thead style="width: auto">
<tr>
<th colspan=5 class='center'><?= __('Stock input') ?></th>
<th colspan=3 class='center'><?= __('Stock output') ?></th>
</tr>
<tr>

<tr>
<th colspan=1 rowspan=2><?= __('Date') ?></th>
<th colspan=1 rowspan=2><?= __('Num bill') ?></th>
<th colspan=1 rowspan=2><?= __('Number fuellog') ?></th>
<th colspan=2 class='center'><?= __('Serial number') ?></th>
<th colspan=2 class='center'><?= __('Consumption') ?></th>
<th colspan=1 rowspan=2><?= __('Rest') ?></th>
</tr>
<tr>
            <th ><?= __('First number coupon') ?></th>
            <th><?= __('Last number coupon') ?></th>                
             <th><?= __('RELEASE DATE') ?></th>
            <th><?= __('Coupons number') ?></th>
           
 </tr>    
            </thead>
            <tbody>
            <?php

            if(!empty($results)) {
            $somme_nb_coupons=0;
            $rest=0;
            foreach($results as $result) {?>
            <tr>
            <td> <?php echo h($this->Time->format($result['fuel_logs']['date'], '%d-%m-%Y'))?>&nbsp;</td>
            
            <td><?php echo h($result['fuel_logs']['num_bill']); ?>&nbsp;</td>
            <td><?php echo h($result['fuel_logs']['nb_fuellog']); ?>&nbsp;</td>
            <td><?php echo h($result['fuel_logs']['first_number_coupon']); ?>&nbsp;</td>
            <td><?php echo h($result['fuel_logs']['last_number_coupon']); ?>&nbsp;</td>
            <td><?php echo h($this->Time->format($result['sheet_rides']['real_start_date'], '%d-%m-%Y')); ?>&nbsp;</td>
            <td><?php echo h($result['consumptions']['nb_coupon']); ?>&nbsp;</td>

            <?php  $somme_nb_coupons=$somme_nb_coupons+$result['consumptions']['nb_coupon'];
                    $rest= $total_coupons-$somme_nb_coupons;?>
            <td><?php echo h($rest); ?>&nbsp;</td>
            </tr>
              <?php  }?>


     
            </tbody>
        </table>
        <p style="font-weight:bold"> <?= __('Number of coupon consummed is :').' ' .$somme_nb_coupons.' '. __('coupons')?> </p>
        <p style="font-weight:bold"> <?= __('Number of coupon stayed is :').' ' .$rest.' '. __('coupons')?> </p>
        <?php  }
            ?>
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
            jQuery("#startdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            jQuery("#enddate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        });

         function exportDataPdf() {
            var car_consumption = new Array();
            car_consumption[0] = jQuery('#car').val();
            car_consumption[1] = jQuery('#startdate').val();
            car_consumption[2] = jQuery('#enddate').val();
            var url = '<?php echo $this->Html->url(array('action' => 'consumptionsdetails_pdf', 'ext' => 'pdf'))?>';
            var form = jQuery('<form action="' + url + '" method="post" >' +
            '<input type="text" name="carconsumption" value="' + car_consumption + '" />' +
            '</form>');
            jQuery('body').append(form);
            form.submit();

       

    }

        function exportDataExcel() {

    $('#table_fuellog').tableExport({

        type: 'excel',
        espace: 'false',
        htmlContent:'false'
});
}
    </script>
<?php $this->end(); ?>