<?php
?><h4 class="page-title"> <?=__('Monthly consumption per car'); ?></h4>
    <div class="box-body">
        <?php echo $this->Form->create('Statistic', array(
            'url'=> array(
                'action' => 'carMission'
            ),
            'novalidate' => true
        )); ?>
        <div class="filters" id='filters' style='display: block;'>
           
            <?php
             $options=array('1'=>__('Yes'),'2'=>__('No'));
            echo $this->Form->input('mission', array(
                'label' => __('Car mission'),
                'options'=>$options,
                'class' => 'form-filter',
                'empty' => ''
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
                        <?= $this->Html->link('<i class="glyphicon glyphicon-export"></i>' . __('Export Pdf'),
                        'javascript:exportDataPdf();',
                         array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id'=>'export')) ?>
                   </div>
              </div>
           </div>
       </div>

        <table class="table table-striped table-bordered">
            <thead style="width: auto">
           
            <th><?php echo $this->Paginator->sort('code', __('Code')); ?></th>
            <th><?php echo $this->Paginator->sort('Carmodel.name', __('Model')); ?></th>
            
            
          

          
           
            </thead>
            <tbody>
            <?php
         
            

            foreach ($cars as $key => $value) {
                $in_mission=0;
                if ($results) {
                    foreach ($results as $result) {

                        if ($result['Car']['id'] == $key) {
                       
                            date_default_timezone_set("Africa/Algiers");
                            $current_date=date("Y-m-d H:i");
                        if (($result['Consumption']['date_arrival']==null) || ($result['Consumption']['date_arrival']>$current_date) ) {
                        $in_mission=1;
                        
                        }
                         
                            }
                           
                        }
                    }
                   


                    echo "<tr><td >" . $key . "</td>";
                            echo "<td >" . $in_mission . "</td></tr>";
                            
                            
                }
            
            ?>
            </tbody>
        </table>
    </div>
<?php $this->start('script'); ?>
    <!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>

    <!-- Page script -->
    <script type="text/javascript">


        $(document).ready(function() {

            jQuery("#startdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            jQuery("#enddate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            jQuery("#min_month").inputmask("m", {"placeholder": "mm"});
            jQuery("#max_month").inputmask("m", {"placeholder": "mm"});
        });

             function exportDataPdf() {
            var consumption_month = new Array();
            consumption_month[0] = jQuery('#car').val();
            consumption_month[1] = jQuery('#year').val();
            consumption_month[2] = jQuery('#min_month').val();
            consumption_month[3] = jQuery('#max_month').val();
            
            var url = '<?php echo $this->Html->url(array('action' => 'consumptionbymonth_pdf', 'ext' => 'pdf'))?>';
            var form = jQuery('<form action="' + url + '" method="post" >' +
            '<input type="text" name="consumptionmonth" value="' + consumption_month + '" />' +
            '</form>');
            jQuery('body').append(form);
            form.submit();

       

    }
    </script>
<?php $this->end(); ?>