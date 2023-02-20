<style>
    .bootstrap-datetimepicker-widget {
        margin-top:7px;
        margin-left: -30px;
        margin-bottom:0px;
        position:absolute;
        z-index:1000;
    }
    </style>
<?php
$this->start('css');

echo $this->Html->css('bootstrap-datetimepicker.min');
echo $this->Html->css('select2/select2.min');
$this->end();
 $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('maskedinput'); ?>

<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>
<script type="text/javascript">


    jQuery(function () {

            jQuery(".datetime").datetimepicker({

                format:'DD/MM/YYYY HH:mm',
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                }

            });

        $('.datetime').click(function(){
            var popup =$(this).offset();
            var popupTop = popup.left;
            $('.bootstrap-datetimepicker-widget').css({
                'bottom' : 10,
                'left' : 10,
                'height' : 300,
                'top' :38,
                'z-index': 99999,
                'background-color' : '#fff',
                'font-size':11
            });
        });










    });

	</script>

<?php $this->end(); ?>