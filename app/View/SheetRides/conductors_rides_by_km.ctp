<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<?php

?><h4 class="page-title"> <?=__('Conductors rides by km'); ?></h4>
    <div class="box-body">

<div id="chart_div"></div>
    </div>
<?php $this->start('script'); ?>


    <!-- Page script -->
    <script type="text/javascript">


        $(document).ready(function() {

            google.charts.load('current', {'packages':['timeline']});
            google.charts.setOnLoadCallback(drawChart);


        });

    function drawChart() {
var data = new google.visualization.DataTable();

data.addColumn('string', 'Month'); // Implicit domain label col.
data.addColumn('number', 'Sales'); // Implicit series 1 data col.
data.addColumn({type:'number', role:'interval'});  // interval role col.
data.addColumn({type:'number', role:'interval'});  // interval role col.
data.addColumn({type:'string', role:'annotation'}); // annotation role col.
data.addColumn({type:'string', role:'annotationText'}); // annotationText col.
data.addColumn({type:'boolean',role:'certainty'}); // certainty col.
data.addRows([
    ['April',1000,  900, 1100,  'A','Stolen data', true],
    ['May',  1170, 1000, 1200,  'B','Coffee spill', true],
    ['June',  660,  550,  800,  'C','Wumpus attack', true],
    ['July', 1030, null, null, null, null, false]
]);
 var options = {
        height: 450,
        timeline: {
          groupByRowLabel: true
        }
      };

      var chart = new google.visualization.Timeline(document.getElementById('chart_div'));

      chart.draw(data, options);
    }           
    </script>
<?php $this->end(); ?>