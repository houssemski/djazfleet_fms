<?php
?><h4 class="page-title"> <?=__('Monthly bills'); ?></h4>
    <div class="box-body">
    <div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
    <div class="card-box p-b-20">
        <?php echo $this->Form->create('Statistic', array(
            'url'=> array(
                'action' => 'reservationByMonth'
            ),
            'novalidate' => true
        )); ?>
        <div class="filters" id='filters' style='display: block;'>
            <?php
           
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
            $options= array('01'=>__("January"),'02'=>__("February"),'03'=>__("March"),'04'=>__("April"),'05'=>__("May"),'06'=>__("June"),'07'=>__("July"),'08'=>__("August"),'09'=>__("September"),'10'=>__("October"),'11'=>__("November"),'12'=>__("December"));
            echo $this->Form->input('month', array(
                'label' => __('Month'),
                'type' =>'select',
                'options'=>$options,
                'class' => 'form-filter ',
				'empty' =>'',
                'id' => 'month'
            ));
            ?>
            <div style='clear:both; padding-top: 10px;'></div>
            <?php
            
            echo $this->Form->input('customer_id', array(
                'label' => __("Conductor"),
                'class' => 'form-filter  select2',
				'empty' =>'',
                'id' => 'customer'
            ));
              echo $this->Form->input('customer_group_id', array(
                'label' => __('Group'),
                'class' => 'form-filter select2',
				'empty' =>'',
                'id' => 'group'
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
                         array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id'=>'export')) ?>
                   </div>
              </div>
           </div>
            <div class="btn-group pull-left">
                <div class="header_actions">
                    <div class="btn-group">
                        <?= $this->Html->link('<i class="glyphicon glyphicon-export"></i>' . __('Export Pdf'),
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
        <table class="table table-striped table-bordered " id='table_reservation'>
            <thead style="width: auto">
            <th><?= __('Reference') ?></th>
            <th><?= __("Conductor") ?></th>
            <th><?= __('Car') ?></th>
            <th><?= __('Immatriculation') ?></th>
            <th><?= __('Date start') ?></th>
            <th><?= __('Date end') ?></th>
            <th><?= __('Number days') ?></th>
            <th><?= __('PU/JR') ?></th>
            <th><?= __('Amount') ?></th>
            </thead>
            <tbody>
            <?php
            foreach ($results as $result ) {?>
            <tr>
                <td> <?php echo h($result['customer_car']['reference'])?>&nbsp;</td>
                    <td><?php echo h($result['customers']['first_name'].' '.$result['customers']['last_name']); ?>&nbsp;</td>
                    <td><?php echo h($result['marks']['name'].' '.$result['carmodels']['name']); ?>&nbsp;</td>
                    <td><?php echo h($result['car']['immatr_def']); ?>&nbsp;</td>
                    <td> <?php echo h($this->Time->format($result['customer_car']['start'], '%d-%m-%Y'))?>&nbsp;</td>
                    <td> <?php echo h($this->Time->format($result['customer_car']['end'], '%d-%m-%Y'))?>&nbsp;</td>
                    <td><?php echo h($result[0]['diff_date']); ?>&nbsp;</td>
                    <td><?php echo h($result['customer_car']['cost_day']); ?>&nbsp;</td>
                    <td><?php echo h($result['customer_car']['cost']); ?>&nbsp;</td>
            </tr>


         <?php   }

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
        });

        
        

         function exportDataPdf() {
            var reservation_month = new Array();
           
            reservation_month[0] = jQuery('#year').val();
            reservation_month[1] = jQuery('#month').val();
            reservation_month[2] = jQuery('#customer').val();
            reservation_month[3] = jQuery('#group').val();
            
            
            var url = '<?php echo $this->Html->url(array('action' => 'reservationbymonth_pdf', 'ext' => 'pdf','target'=>'_blank'))?>';
            var form = jQuery('<form action="' + url + '" method="post" >' +
            '<input type="text" name="reservationmonth" value="' + reservation_month + '" />' +
            '</form>');
            jQuery('body').append(form);
            form.submit();

       

    }
          function exportData() {
            var reservation_month = new Array();
           
            reservation_month[0] = jQuery('#year').val();
            reservation_month[1] = jQuery('#month').val();
            
            
            var url = '<?php echo $this->Html->url(array('action' => 'exportReservationByMonth'))?>';
            var form = jQuery('<form action="' + url + '" method="post" >' +
            '<input type="text" name="reservationmonth" value="' + reservation_month + '" />' +
            '</form>');
            jQuery('body').append(form);
            form.submit();

       

    }

      function exportDataExcel() {

    $('#table_reservation').tableExport({

        type: 'excel',
        espace: 'false',
        htmlContent:'false'
});
}
    </script>
<?php $this->end(); ?>