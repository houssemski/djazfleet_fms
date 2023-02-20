<?php
?><h4 class="page-title"> <?=__('Monthly km per year and car'); ?></h4>
<div class="box-body">
    <div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
    <div class="card-box p-b-20">
    <?php echo $this->Form->create('Statistic', array(
        'url'=> array(
            'action' => 'kmbymonth'
        ),
        'novalidate' => true
    )); ?>
    <div class="filters" id='filters' style='display: block;'>
        <?php
        echo $this->Form->input('car_id', array(
                    'label' => __('Car'),
                    'class' => 'form-filter select2',
                    'empty' => ''
                    ));
        echo $this->Form->input('year', array(
                    'label' => '',
                    'type' => 'text',
                    'class' => 'form-control datemask',
                    'before' => '<label class="dte">'.__('Year').'</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'year',
                    ));
        ?>
        <div style='clear:both; padding-top: 5px;'></div>
        <button style="float: right;" class="btn btn-success btn-trans waves-effect w-md waves-success" type="submit"><?= __('Search') ?></button>
        <div style='clear:both; padding-top: 10px;'></div>
   </div>
        <?php echo $this->Form->end(); ?>
        </div>
        </div>
        </div>
    <div class="box box-primary">
        
        <div class="box-body">
            <div id="line-chart" style="height: 300px; padding: 0px; position: relative;">
                <canvas class="flot-base" width="673" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 673px; height: 300px;">
                </canvas>
                <div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);">
                    <div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;">
                    </div>
                    <div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;">
                    </div>

                </div>
                <canvas class="flot-overlay" width="673" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 673px; height: 300px;">
                </canvas>
            </div>
        </div><!-- /.box-body-->
    </div>
</div>
<?php $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>

<?= $this->Html->script('plugins/flot/jquery.flot.min'); ?>
<?= $this->Html->script('plugins/flot/jquery.flot.resize.min'); ?>
<?= $this->Html->script('plugins/flot/jquery.flot.pie.min'); ?>
<?= $this->Html->script('plugins/flot/jquery.flot.categories.min'); ?>

<!-- Page script -->
<script type="text/javascript">

    $(document).ready(function() {
        jQuery("#year").inputmask("y", {"placeholder": "yyyy"});
        <?php
        $nb = 0;
        foreach($results as $result){
            $nb++; ?>
        var data<?= $nb ?> = [];
        <?php for($i=1; $i<13; $i++){ ?>
        data<?= $nb ?>.push([<?= $i ?>, <?= $result[$i] ?>]);
        <?php } ?>
        var line_data<?= $nb ?> = {
            data: data<?= $nb ?>,
            color: "<?= $result['color'] ?>",
            label: "<?= str_replace('"','',$result['name']) ?>"
        };
        <?php }
         ?>
        var dataset = [
            <?php
            $nb = 1;
            foreach($results as $result){
                if($nb == 1) echo "line_data".$nb;
                else echo ", line_data".$nb;
                $nb++;
            } ?>
        ];
        jQuery.plot("#line-chart", dataset, {
            grid: {
                hoverable: true,
                borderColor: "#c9c9c9",
                borderWidth: 1,
                tickColor: "#f3f3f3"
            },
            series: {
                shadowSize: 0,
                lines: {
                    show: true
                },
                points: {
                    radius: 3,
                    show: true
                }
            },
            yaxis: {
                show: true,
            },
            xaxis: {
                show: true,
                tickDecimals:0
            }
        });
        //Initialize tooltip on hover
        jQuery("<div class='tooltip-inner' id='line-chart-tooltip'></div>").css({
            position: "absolute",
            display: "none",
            opacity: 0.8
        }).appendTo("body");
        jQuery("#line-chart").bind("plothover", function (event, pos, item) {
            if (item) {
                var x = item.datapoint[0],
                    y = item.datapoint[1];

                jQuery("#line-chart-tooltip").html(y + " km")
                    .css({top: item.pageY + 5, left: item.pageX + 5})
                    .fadeIn(200);
            } else {
                jQuery("#line-chart-tooltip").hide();
            }

        });
        /* END LINE CHART */


    });

</script>
<?php $this->end(); ?>