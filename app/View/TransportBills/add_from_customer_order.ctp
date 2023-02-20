
<h4 class="page-title"> <?= __("Add sheet ride (travel)"); ?></h4>
<?php
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
$this->end();
?>
<?= $this->Form->input('controller', array(
    'id' => 'controller',
    'value' => $this->request->params['controller'],
    'type' => 'hidden'
)); ?>
<?= $this->Form->input('action', array(
    'id' => 'action',
    'value' => 'listeAddFromCustomerOrder',
    'type' => 'hidden'
)); ?>
<?php if (isset($_GET['page'])) { ?>
    <?= $this->Form->input('page', array(
        'id' => 'page',
        'value' =>  $_GET['page'],
        'type' => 'hidden'
    )); ?>
<?php
$page = $_GET['page'];
} else { ?>
    <?= $this->Form->input('page', array(
        'id' => 'page',
        'type' => 'hidden'
    )); ?>
<?php
$page = 1;
}
$uriParts = explode('?', $_SERVER['REQUEST_URI'], 2);
$url = base64_encode(serialize($uriParts[0]));
$controller = $this->request->params['controller'];
?>
<?= $this->Form->input('url', array(
    'id' => 'url',
    'value' => base64_encode(serialize($uriParts[0])),
    'type' => 'hidden'
)); ?>

<div id ='listeDiv'>
    <?php
    $query = $this->Session->read('query');
    extract($query);
    $tableId = strtolower($tableName) . '-grid';
    /** @var array $columns */
    /** @var string $tableName */
    ?>
    <!--    Content section    -->
    <?= $this->element('index-body-content', array(
        "tableId" => $tableId,
        "tableName" => $tableName,
        "columns" => $columns,
    ));
    ?>
    <!--    End content section    -->


    <!--    DataTables Script    -->
<?= $this->element('data-tables-script', array(
    "tableId" => $tableId,
    "tableName" => $tableName,
    "columns" => $columns,
    "defaultLimit" => $defaultLimit,
));
?>
<!--    End dataTables Script    -->
</div>



<br/>
<br/>

<div id='commandes' name="commandes">

</div>
<br/>
<br/>

    <?php $this->start('script'); ?>
    <?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
    <?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
    <?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
    <?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
    <script type="text/javascript">

        $(document).ready(function () {
            /* setInterval(function () {
                jQuery('#listeDiv').load(' echo $this->Html->url('/transportBills/loadAddFromCustomerOrder')?>', function () {
                });
            }, 50000); */
            jQuery("#date_to").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            jQuery("#date_from").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});


            jQuery('input.checkall').on('ifClicked', function (event) {
                var cases = jQuery(":checkbox.id");
                if (jQuery('#checkall').prop('checked')) {
                    cases.iCheck('uncheck');
                    jQuery("#add_sheet_ride").attr("disabled", "true");
                } else {
                    cases.iCheck('check');
                    jQuery("#add_sheet_ride").removeAttr("disabled");
                }

            });

            jQuery('input.id').on('ifUnchecked', function (event) {
                var ischecked = false;
                jQuery(":checkbox.id").each(function () {
                    if (jQuery(this).prop('checked'))
                        ischecked = true;
                });
                if (!ischecked) {
                    jQuery("#add_sheet_ride").attr("disabled", "true");
                }
            });

            jQuery('input.id').on('ifChecked', function (event) {
                jQuery("#add_sheet_ride").removeAttr("disabled");
            });
        });


        function addSheetRideFromTransportBillDetailRides() {

            var myCheckboxes = new Array();
            jQuery('.id:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });
            var url = '<?php echo $this->Html->url('/transportBills/addSheetRideFromTransportBillDetailRides/')?>';
            var form = jQuery('<form action="' + url + '" method="post">' +
            '<input type="text" name="chkids" value="' + myCheckboxes + '" />' +
            '</form>');
            jQuery('body').append(form);
            form.submit();

        }


        function viewTransportBillDetailRideObservations(id ) {

            $("html").css("cursor", "pointer");
            scrollToAnchor('commandes');
            jQuery('tr').removeClass('btn-info  btn-trans');
            jQuery('#row' + id).addClass('btn-info  btn-trans');
            jQuery('#commandes').load('<?php echo $this->Html->url('/transportBills/viewTransportBillDetailRideObservations/')?>' + id , function () {

            });
        }


    </script>
    <?php $this->end(); ?>
