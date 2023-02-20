
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php

?><h4 class="page-title"> <?=__('Conductors rides by date'); ?></h4>
    <div class="box-body">
	        <?php echo $this->Form->create('SheetRides', array(
                'url'=> array(
                    'action' => 'conductorsRidesByDate'
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
                'label' => __('Conductor'),
                'class' => 'form-filter select2',
                'id' => 'conductor',
                'empty' => ''
            ));

            ?>
            <div style='clear:both; padding-top: 10px;'></div>
            <?php
    
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
            ?>
            <button class="btn btn-default" type="submit"><?= __('Search') ?></button>
            <div style='clear:both; padding-top: 10px;'></div>
        </div>
        <?php echo $this->Form->end(); ?>
 <div id="chart_div"></div>

    </div>
<?php $this->start('script'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
<?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
<script type="text/javascript">

    $(document).ready(function() {

        jQuery("#date_to").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#date_from").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        google.charts.load('current', {'packages':['timeline']});
        google.charts.setOnLoadCallback(drawChart);


    });



		
    function drawChart() {
      var data = new google.visualization.DataTable();
	  data.addColumn('string', 'Cars Conductors');
      
	  data.addColumn('string', 'Ride');
      data.addColumn('datetime', 'Season Start Date');
      data.addColumn('datetime', 'Season End Date');
	  
      data.addRows([
	
		        <?php
					foreach($rides as $ride){
						echo "['$ride[0]','$ride[1]',new Date('$ride[2]','$ride[3]','$ride[4]','$ride[5]','$ride[6]'),  new Date('$ride[7]','$ride[8]','$ride[9]','$ride[10]','$ride[11]')],";
					}
					?>

			

      ]);

      var options = {
        
        height: 450,
        timeline: {
          groupByRowLabel: true
        }      };

      var chart = new google.visualization.Timeline(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
            
    </script>
<?php $this->end(); ?>