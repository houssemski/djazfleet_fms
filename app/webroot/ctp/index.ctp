<?php
if (!isset($controllerName)) {
    $controllerName = "";
}
if (!isset($actionName)) {
    $actionName = "";
}
?>
<style>
    thead input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }

    #datatable-responsive_filter {
        display: none !important;
    }

    #datatable-responsive_info {
        display: none !important;
    }
</style>
<?php
$this->start('css');
echo $this->Html->css('datatables/jquery.dataTables.min');
echo $this->Html->css('datatables/buttons.bootstrap.min');
echo $this->Html->css('datatables/fixedHeader.bootstrap.min');
echo $this->Html->css('datatables/responsive.bootstrap.min');
echo $this->Html->css('datatables/scroller.bootstrap.min');
echo $this->Html->css('jquery-ui');
echo $this->Html->css('iCheck/flat/red');
echo $this->Html->css('iCheck/all');
$this->end();

$this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
<?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<!-- Datatables-->
<?= $this->Html->script('plugins/datatables/jquery.dataTables.min'); ?>
<?= $this->Html->script('plugins/datatables/dataTables.bootstrap'); ?>
<?= $this->Html->script('plugins/datatables/dataTables.buttons.min'); ?>
<?= $this->Html->script('plugins/datatables/buttons.bootstrap.min'); ?>


<?= $this->Html->script('plugins/datatables/Buttons-1.5.6/dataTables.buttons.min'); ?>
<?= $this->Html->script('plugins/datatables/Buttons-1.5.6/buttons.jqueryui.min'); ?>
<?= $this->Html->script('plugins/datatables/Buttons-1.5.6/buttons.bootstrap.min'); ?>
<?= $this->Html->script('plugins/datatables/Buttons-1.5.6/buttons.bootstrap4.min'); ?>
<?= $this->Html->script('plugins/datatables/Buttons-1.5.6/buttons.html5.min'); ?>
<?= $this->Html->script('plugins/datatables/Buttons-1.5.6/buttons.print'); ?>
<?= $this->Html->script('plugins/datatables/Buttons-1.5.6/buttons.flash.min'); ?>
<?= $this->Html->script('plugins/datatables/Buttons-1.5.6/buttons.colVis.min'); ?>




<?= $this->Html->script('plugins/datatables/jszip.min'); ?>
<?= $this->Html->script('plugins/datatables/pdfmake.min'); ?>
<?= $this->Html->script('plugins/datatables/vfs_fonts'); ?>
<?= $this->Html->script('plugins/datatables/buttons.html5.min'); ?>
<?= $this->Html->script('plugins/datatables/buttons.print.min'); ?>
<?= $this->Html->script('plugins/datatables/dataTables.fixedHeader.min'); ?>
<?= $this->Html->script('plugins/datatables/dataTables.keyTable.min'); ?>
<?= $this->Html->script('plugins/datatables/dataTables.responsive.min'); ?>
<?= $this->Html->script('plugins/datatables/responsive.bootstrap.min'); ?>
<?= $this->Html->script('plugins/datatables/dataTables.scroller.min'); ?>
<?= $this->Html->script('plugins/datatables/dataTables.select.min'); ?>
<?= $this->Html->script('plugins/iCheck/icheck.min'); ?>
<?= $this->Html->script('moment.min'); ?>
<?= $this->Html->script('datetime-moment'); ?>
<!-- Datatable init js -->
<?= $this->Html->script('datatables.init'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        var controller = $("#controller").val();

        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "date-uk-pre": function(a) {
                if (a == null || a == "") {
                    return 0;
                }
                var ukDatea = a.split('-');
                return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
            },

            "date-uk-asc": function(a, b) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },

            "date-uk-desc": function(a, b) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });

        if (controller !== 'events') {
            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                "date-uk-pre": function(a) {
                    if (a == null || a == "") {
                        return 0;
                    }
                    var ukDatea = a.split('/');
                    return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
                },


                "date-uk-asc": function(a, b) { 
                    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
                },

                "date-uk-desc": function(a, b) { 
                    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
                }
            });

        } else {
            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                "date-uk-pre": function(value) {
                    var date = value;
                    date = date.split('-'); 
                    let dateValue = 20300000;
                    if(date.length > 0){
                        dateValue = parseInt(date[2] + date[1] + date[0]);
                    }
                    return dateValue;
                },
                "date-uk-asc": function(a, b) {
                    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
                },
                "date-uk-desc": function(a, b) {
                    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
                }
            });
        }

        getPlaceHolderInputSearch();

        var orderArray = [];
        switch (controller) {
            case 'payments':
                orderArray = [
                    [1, "desc"]
                ];
                break;
            default:
                if (!("<?= $controllerName ?>" === 'TransportBills' && "<?= $actionName ?>" === 'addFromCustomerOrderDetail') &&
                    !("<?= $controllerName ?>" === 'Events' && "<?= $actionName ?>" === 'index')) {
                    orderArray = [
                        [0, "desc"]
                    ];
                }
                break;
        }

        if (controller == 'payments') {
            var table = $('#datatable-responsive').DataTable({
                'drawCallback': function(settings) {
                    $('input[type="checkbox"]').iCheck({
                        handle: 'checkbox',
                        checkboxClass: 'icheckbox_flat-red'
                    });
                },
                "bPaginate": false,
                "columnDefs": [{
                        "targets": 1,
                        "type": "date-uk"
                    },
                    {
                        "targets": 9,
                        "type": "date-uk"
                    },
                    {
                        "targets": 10,
                        "type": "date-uk"
                    },
                    {
                        "targets": 11,
                        "type": "date-uk"
                    }
                ],
                orderCellsTop: true,
                "order": orderArray,
                fixedHeader: true,
                "scrollY": "400px"
            });

        } else if (controller === 'events') {
            var table = $('#datatable-responsive').DataTable({
                'drawCallback': function(settings) {
                    $('input[type="checkbox"]').iCheck({
                        handle: 'checkbox',
                        checkboxClass: 'icheckbox_flat-red'
                    });
                },
                "bPaginate": false,
                "columnDefs": [{
                        "targets": 5,
                        "type": "date-uk-asc"
                    },
                    {
                        "targets": 6,
                        "type": "date-uk-asc"
                    },
                ],
                orderCellsTop: true,
                "order": orderArray,
                fixedHeader: true,
                "scrollY": "400px"
            });
        } else {
            var table = $('#datatable-responsive').DataTable({
                'drawCallback': function(settings) {
                    $('input[type="checkbox"]').iCheck({
                        handle: 'checkbox',
                        checkboxClass: 'icheckbox_flat-red'
                    });
                },
                "bPaginate": false,
                orderCellsTop: true,
                "order": orderArray,
                fixedHeader: true,
                "scrollY": "400px"
            });
        }
        //Enable iCheck plugin for checkboxes
        //iCheck for checkbox and radio inputs
        $('#datatable-responsive input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });
        $("#keyword").keypress(function(e) {
            if (e.which == 13) {
                $('#searchKeyword').submit();
            }
        });
        if ($.ui && $.ui.dialog && $.ui.dialog.prototype._allowInteraction) {
            var ui_dialog_interaction = $.ui.dialog.prototype._allowInteraction;
            $.ui.dialog.prototype._allowInteraction = function(e) {
                if ($(e.target).closest('.select2-dropdown').length) return true;
                return ui_dialog_interaction.apply(this, arguments);
            };
        }
        jQuery("#dialogModalPayments").dialog({
            autoOpen: false,
            height: 650,
            width: 500,
            position: 'absolute',
            top: 80,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true,
            _allowInteraction: function(event) {
                return !!$(event.target).is(".select2-input") || this._super(event);
            }
        });
        jQuery("#dialogModalAdvencedPayments").dialog({
            autoOpen: false,
            height: 500,
            width: 700,
            position: 'absolute',
            top: 80,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });



        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function() {

            var clicks = $(this).data('clicks');
            if (clicks) {
                //Uncheck all checkboxes
                $("#datatable-responsive input[type='checkbox']").iCheck("uncheck");
                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                jQuery("#delete").attr("disabled", "true");
                jQuery("#export").attr("disabled", "true");
                jQuery("#export_pdf").attr("disabled", "true");
                jQuery("#assign_customer_group").attr("disabled", "true");
                jQuery("#transform").attr("disabled", "true");
                jQuery("#devis").attr("disabled", "true");
                jQuery("#commande").attr("disabled", "true");
                jQuery("#purchase-request").attr("disabled", "true");
                jQuery("#delivery").attr("disabled", "true");
                jQuery("#prefacture").attr("disabled", "true");
                jQuery("#facture").attr("disabled", "true");
                jQuery("#merge").attr("disabled", "true");
                jQuery("#payment").attr("disabled", "true");
                jQuery("#validate").attr("disabled", "true");
                jQuery("#transfer").attr("disabled", "true");
                jQuery("#cancel").attr("disabled", "true");
                jQuery("#advanced_payment").attr("disabled", "true");
                jQuery("#event_car").attr("disabled", "true");
                jQuery("#add_prefacture").attr("disabled", "true");
                jQuery("#make_event").attr("disabled", "true");
                jQuery("#print_requests").attr("disabled", "true");

            } else {
                //Check all checkboxes
                $("#datatable-responsive input[type='checkbox']").iCheck("check");
                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
                jQuery("#delete").removeAttr("disabled");
                jQuery("#export").removeAttr("disabled");
                jQuery("#export_pdf").removeAttr("disabled");
                jQuery("#assign_customer_group").removeAttr("disabled");
                jQuery("#transform").removeAttr("disabled");
                jQuery("#devis").removeAttr("disabled");
                jQuery("#commande").removeAttr("disabled");
                jQuery("#purchase-request").removeAttr("disabled");
                jQuery("#delivery").removeAttr("disabled");
                jQuery("#prefacture").removeAttr("disabled");
                jQuery("#facture").removeAttr("disabled");
                jQuery("#merge").removeAttr("disabled");
                jQuery("#payment").removeAttr("disabled");
                jQuery("#validate").removeAttr("disabled");
                jQuery("#transfer").removeAttr("disabled");
                jQuery("#cancel").removeAttr("disabled");
                jQuery("#advanced_payment").removeAttr("disabled");
                jQuery("#event_car").removeAttr("disabled");
                jQuery("#add_prefacture").removeAttr("disabled");
                jQuery("#make_event").removeAttr("disabled");
                jQuery("#print_requests").removeAttr("disabled");
            }
            $(this).data("clicks", !clicks);
        });

        $('#datatable-responsive').on('ifChecked', 'input', function() {

            jQuery("#delete").removeAttr("disabled");
            jQuery("#export").removeAttr("disabled");
            jQuery("#export_pdf").removeAttr("disabled");
            jQuery("#assign_customer_group").removeAttr("disabled");
            jQuery("#transform").removeAttr("disabled");
            jQuery("#devis").removeAttr("disabled");
            jQuery("#commande").removeAttr("disabled");
            jQuery("#purchase-request").removeAttr("disabled");
            jQuery("#delivery").removeAttr("disabled");
            jQuery("#prefacture").removeAttr("disabled");
            jQuery("#facture").removeAttr("disabled");
            jQuery("#merge").removeAttr("disabled");
            jQuery("#payment").removeAttr("disabled");
            jQuery("#validate").removeAttr("disabled");
            jQuery("#transfer").removeAttr("disabled");
            jQuery("#cancel").removeAttr("disabled");
            jQuery("#advanced_payment").removeAttr("disabled");
            jQuery("#event_car").removeAttr("disabled");
            jQuery("#add_prefacture").removeAttr("disabled");
            jQuery("#make_event").removeAttr("disabled");
            jQuery("#print_requests").removeAttr("disabled");

        });

        $('#datatable-responsive').on('ifUnchecked', 'input', function() {

            var ischecked = false;
            jQuery(":checkbox.id").each(function() {
                if (jQuery(this).prop('checked'))
                    ischecked = true;
            });
            if (!ischecked) {
                jQuery("#delete").attr("disabled", "true");
                jQuery("#export").attr("disabled", "true");
                jQuery("#export_pdf").attr("disabled", "true");
                jQuery("#assign_customer_group").attr("disabled", "true");
                jQuery("#transform").attr("disabled", "true");
                jQuery("#devis").attr("disabled", "true");
                jQuery("#commande").attr("disabled", "true");
                jQuery("#purchase-request").attr("disabled", "true");
                jQuery("#delivery").attr("disabled", "true");
                jQuery("#prefacture").attr("disabled", "true");
                jQuery("#facture").attr("disabled", "true");
                jQuery("#merge").attr("disabled", "true");
                jQuery("#payment").attr("disabled", "true");
                jQuery("#validate").attr("disabled", "true");
                jQuery("#transfer").attr("disabled", "true");
                jQuery("#cancel").attr("disabled", "true");
                jQuery("#advanced_payment").attr("disabled", "true");
                jQuery("#event_car").attr("disabled", "true");
                jQuery("#add_prefacture").attr("disabled", "true");
                jQuery("#make_event").attr("disabled", "true");
                jQuery("#print_requests").attr("disabled", "true");
            }
        });

        jQuery("#startdate").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
        });
        jQuery("#enddate").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
        });
        jQuery("#startdatemodifie").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
        });
        jQuery("#enddatemodifie").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
        });


        jQuery('input.checkall').on('ifClicked', function(event) {

            var cases = jQuery(":checkbox.id");
            if (jQuery('#checkall').prop('checked')) {
                cases.iCheck('uncheck');
                jQuery("#delete").attr("disabled", "true");
                jQuery("#export").attr("disabled", "true");
                jQuery("#export_pdf").attr("disabled", "true");
                jQuery("#assign_customer_group").attr("disabled", "true");
                jQuery("#transform").attr("disabled", "true");
                jQuery("#devis").attr("disabled", "true");
                jQuery("#commande").attr("disabled", "true");
                jQuery("#purchase-request").attr("disabled", "true");
                jQuery("#delivery").attr("disabled", "true");
                jQuery("#prefacture").attr("disabled", "true");
                jQuery("#facture").attr("disabled", "true");
                jQuery("#merge").attr("disabled", "true");
                jQuery("#payment").attr("disabled", "true");
                jQuery("#advanced_payment").attr("disabled", "true");
                jQuery("#event_car").attr("disabled", "true");
                jQuery("#add_prefacture").attr("disabled", "true");
            } else {
                cases.iCheck('check');
                jQuery("#delete").removeAttr("disabled");
                jQuery("#export").removeAttr("disabled");
                jQuery("#export_pdf").removeAttr("disabled");
                jQuery("#assign_customer_group").removeAttr("disabled");
                jQuery("#transform").removeAttr("disabled");
                jQuery("#devis").removeAttr("disabled");
                jQuery("#commande").removeAttr("disabled");
                jQuery("#purchase-request").removeAttr("disabled");
                jQuery("#delivery").removeAttr("disabled");
                jQuery("#prefacture").removeAttr("disabled");
                jQuery("#facture").removeAttr("disabled");
                jQuery("#merge").removeAttr("disabled");
                jQuery("#payment").removeAttr("disabled");
                jQuery("#advanced_payment").removeAttr("disabled");
                jQuery("#event_car").removeAttr("disabled");
                jQuery("#add_prefacture").removeAttr("disabled");
            }

        });
        jQuery('input.id').on('ifUnchecked', function(event) {
            var ischecked = false;
            jQuery(":checkbox.id").each(function() {
                if (jQuery(this).prop('checked'))
                    ischecked = true;
            });

            if (!ischecked) {
                jQuery("#delete").attr("disabled", "true");
                jQuery("#export").attr("disabled", "true");
                jQuery("#export_pdf").attr("disabled", "true");
                jQuery("#assign_customer_group").attr("disabled", "true");
                jQuery("#transform").attr("disabled", "true");
                jQuery("#devis").attr("disabled", "true");
                jQuery("#commande").attr("disabled", "true");
                jQuery("#purchase-request").attr("disabled", "true");
                jQuery("#delivery").attr("disabled", "true");
                jQuery("#prefacture").attr("disabled", "true");
                jQuery("#facture").attr("disabled", "true");
                jQuery("#merge").attr("disabled", "true");
                jQuery("#payment").attr("disabled", "true");
                jQuery("#advanced_payment").attr("disabled", "true");
                jQuery("#event_car").attr("disabled", "true");
                jQuery("#add_prefacture").attr("disabled", "true");
            }
        });
        jQuery('input.id').on('ifChecked', function(event) {
            jQuery("#delete").removeAttr("disabled");
            jQuery("#export").removeAttr("disabled");
            jQuery("#export_pdf").removeAttr("disabled");
            jQuery("#assign_customer_group").removeAttr("disabled");
            jQuery("#transform").removeAttr("disabled");
            jQuery("#devis").removeAttr("disabled");
            jQuery("#commande").removeAttr("disabled");
            jQuery("#purchase-request").removeAttr("disabled");
            jQuery("#delivery").removeAttr("disabled");
            jQuery("#prefacture").removeAttr("disabled");
            jQuery("#facture").removeAttr("disabled");
            jQuery("#merge").removeAttr("disabled");
            jQuery("#payment").removeAttr("disabled");
            jQuery("#advanced_payment").removeAttr("disabled");
            jQuery("#event_car").removeAttr("disabled");
            jQuery("#add_prefacture").removeAttr("disabled");
        });

        jQuery('#mark_filter').change(function() {

            jQuery('#model').load('<?php echo $this->Html->url('/cars/getModelsFilters/') ?>' + $(this).val(), function() {
                $(".select2").select2({
                    sorter: function(data) {
                        /* Sort data using lowercase comparison */
                        return data.sort(function(a, b) {
                            a = a.text.toLowerCase();
                            b = b.text.toLowerCase();
                            if (a > b) {
                                return 1;
                            } else if (a < b) {
                                return -1;
                            }
                            return 0;
                        });
                    },
                    allowDuplicates: true

                });
            });
        });
        jQuery('#link_search_advanced').click(function() {
            if (jQuery('#filters').is(':visible')) {
                jQuery('#filters').slideUp("slow", function() {});
            } else {
                jQuery('#filters').slideDown("slow", function() {});
            }
        });

        $('#pdf').click(function() {

            $('#table').tableExport({

                type: 'pdf',
                espace: 'true',
                headings: true, // (Boolean), display table headings (th/td elements) in the <thead>
                footers: true,
                bootstrap: true,
                htmlContent: 'false',
                consoleLog: 'false'

            });

        });

        $('#png').click(function() {

            $('#table').tableExport({

                type: 'png',
                espace: 'false'

            });


        });

        $('#excel').click(function() {

            $('#table').tableExport({

                type: 'excel',
                espace: 'false',
                ignoreColumn: [0, 13],
                htmlContent: 'false'
            });

        });

        jQuery('#file').change(function() {

            var $form = jQuery('#CarImportForm');
            var formdata = (window.FormData) ? new FormData($form[0]) : null;
            var data = (formdata !== null) ? formdata : $form.serialize();


            jQuery.ajax({ //FormID - id of the form.
                type: "POST",
                url: "<?php echo $this->Html->url('/cars/import') ?>",
                contentType: false, // obligatoire pour de l'upload
                processData: false, // obligatoire pour de l'upload
                dataType: 'json', // selon le retour attendu

                data: data,
                success: function(json) {

                    //window.location = '<?php echo $this->Html->url('/cars') ?>' ;
                }

            });
        });
    });

    function scrollToAnchor(aid) {
        var aTag = jQuery("div[name='" + aid + "']");
        jQuery('html,body').animate({
            scrollTop: aTag.offset().top
        }, 'slow');
    }


    function imprime_bloc(titre, objet) {
        // Définition de la zone à imprimer
        var zone = document.getElementById(objet).innerHTML;

        // Ouverture du popup
        var fen = window.open("", "", "height=500, width=600,toolbar=0, menubar=0, scrollbars=1, resizable=1,status=0, location=0, left=10, top=10");

        // style du popup

        fen.document.body.style.color = '#000000';
        fen.document.body.style.backgroundColor = '#FFFFFF';
        //fen.document.body.style.padding = "10px";
        fen.document.body.style.textAlign = "center";
        //fen.document.getElementsByTagName("td").style.border = "thick solid #0000FF";
        // Ajout des données a imprimer
        fen.document.title = 'Liste';
        //fen.document.write(zone.innerHTML);
        fen.document.body.innerHTML += " " + zone + " ";
        var table = fen.document.body.getElementsByTagName('table');
        table[0].style.border = '1px solid #ddd';
        table[0].style.margin = '0 auto';
        var actions = fen.document.body.getElementsByClassName('actions');
        for (var i = 0; i < actions.length; i++) {

            actions[i].style.display = 'none';
        }

        var cas = fen.document.body.getElementsByClassName('case');
        for (var i = 0; i < cas.length; i++) {

            cas[i].style.display = 'none';
        }
        var th = fen.document.body.getElementsByTagName('th');
        for (var i = 0; i < th.length; i++) {

            th[i].style.border = '1px solid #ddd';
        }
        var td = fen.document.body.getElementsByTagName('td');
        if (td.length > 0) {
            for (var i = 0; i < td.length; i++) {

                td[i].style.border = '1px solid #ddd';
            }
        }


        //td.style.border = '1px solid #ddd';
        // Impression du popup
        fen.window.print();

        //Fermeture du popup
        fen.window.close();
        //return true;
    }


    function exportAllData(urlExport) {
        <?php
        $url = "";
        if (isset($this->params['named']['keyword']) && !empty($this->params['named']['keyword'])) {
            $url .= "/keyword:" . $this->params['named']['keyword'];
        }
        if (isset($this->params['named']['mark']) && !empty($this->params['named']['mark'])) {
            $url .= "/mark:" . $this->params['named']['mark'];
        }
        if (isset($this->params['named']['model']) && !empty($this->params['named']['model'])) {
            $url .= "/model:" . $this->params['named']['model'];
        }
        if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
            $url .= "/category:" . $this->params['named']['category'];
        }
        if (isset($this->params['named']['type']) && !empty($this->params['named']['type'])) {
            $url .= "/type:" . $this->params['named']['type'];
        }
        if (isset($this->params['named']['fuel']) && !empty($this->params['named']['fuel'])) {
            $url .= "/fuel:" . $this->params['named']['fuel'];
        }
        if (isset($this->params['named']['status']) && !empty($this->params['named']['status'])) {
            $url .= "/status:" . $this->params['named']['status'];
        }
        if (isset($this->params['named']['parc']) && !empty($this->params['named']['parc'])) {
            $url .= "/parc:" . $this->params['named']['parc'];
        }
        if (isset($this->params['named']['group']) && !empty($this->params['named']['group'])) {
            $url .= "/group:" . $this->params['named']['group'];
        }
        if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
            $url .= "/category:" . $this->params['named']['category'];
        }
        if (isset($this->params['named']['driver_license']) && !empty($this->params['named']['driver_license'])) {
            $url .= "/driver_license:" . $this->params['named']['driver_license'];
        }
        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $url .= "/user:" . $this->params['named']['user'];
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $url .= "/modified_id:" . $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $url .= "/created:" . $this->params['named']['created'];
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $url .= "/created1:" . $this->params['named']['created1'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $url .= "/modified:" . $this->params['named']['modified'];
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $url .= "/modified1:" . $this->params['named']['modified1'];
        }

        if (!empty($url)) { ?>
            window.location = '<?php echo $this->Html->url('/cars/export/') ?>' + 'all_search' + '<?php echo $url; ?>';
        <?php  } else { ?>
            window.location = '<?php echo $this->Html->url('/') ?>' + urlExport;
        <?php } ?>




    }

    function exportData(urlExport) {

        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function() {
            myCheckboxes.push(jQuery(this).val());

        });
        var type = jQuery('#type').val();
        var url = '<?php echo $this->Html->url('/') ?>' + urlExport;
        var form = jQuery('<form action="' + url + '" method="post">' +
            '<input type="text" name="chkids" value="' + myCheckboxes + '" />' +
            '<input type="text" name="type" value="' + type + '" />' +
            '</form>');
        jQuery('body').append(form);
        form.submit();

    }


    function exportAllDataPdf() {

        window.location = '<?php echo $this->Html->url(
                                array('action' => 'export_pdf/all', 'ext' => 'pdf')

                            ); ?>';


    }

    /* function exportDataPdf() {
         var myCheckboxes = new Array();
         jQuery('.id:checked').each(function () {
             myCheckboxes.push(jQuery(this).val());

         });
         var url = '<?php echo $this->Html->url(array('action' => 'export_pdf', 'ext' => 'pdf')) ?>';
         var form = jQuery('<form action="' + url + '" method="post">' +
             '<input type="text" name="chkids" value="' + myCheckboxes + '" />' +
             '</form>');
         jQuery('body').append(form);
         form.submit();

     }*/

    function submitDeleteForm(urlDelete) {
        var link = '<?php echo $this->Html->url('/') ?>' + urlDelete;
        jQuery('.id:checked').each(function() {
            var id = jQuery(this).val();

            jQuery.ajax({
                type: "POST",
                url: link,
                data: "id=" + jQuery(this).val(),
                dataType: "json",
                success: function(json) {
                    if (json.response === "true") {

                        jQuery('#row' + id).remove();
                    }
                }
            });
        });

    }

    function slctlimitChanged(urlLimit) {
        var limit = jQuery('#slctlimit').val();
        var order = jQuery('#selectOrder').val();
        <?php
        $url = "";

        if (isset($this->params['named']['mark']) && !empty($this->params['named']['mark'])) {
            $url .= "/mark:" . $this->params['named']['mark'];
        }
        if (isset($this->params['named']['model']) && !empty($this->params['named']['model'])) {
            $url .= "/model:" . $this->params['named']['model'];
        }
        if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
            $url .= "/category:" . $this->params['named']['category'];
        }
        if (isset($this->params['named']['type']) && !empty($this->params['named']['type'])) {
            $url .= "/type:" . $this->params['named']['type'];
        }
        if (isset($this->params['named']['fuel']) && !empty($this->params['named']['fuel'])) {
            $url .= "/fuel:" . $this->params['named']['fuel'];
        }
        if (isset($this->params['named']['status']) && !empty($this->params['named']['status'])) {
            $url .= "/status:" . $this->params['named']['status'];
        }
        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $url .= "/created:" . $this->params['named']['created'];
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $url .= "/created1:" . $this->params['named']['created1'];
        }

        if (isset($this->params['named']['conditions']) && !empty($this->params['named']['conditions'])) {
            $url .= "/conditions:" . base64_encode(serialize($conditions_index));
        }
        ?>
        window.location = '<?php echo $this->Html->url('/') ?>' + urlLimit + '/' + limit + '/' + order + '/' + 'DESC' + '<?php echo $url; ?>';
    }

    function selectOrderChanged(urlLimit, orderType) {

        var limit = jQuery('#slctlimit').val();
        var order = jQuery('#selectOrder').val();

        window.location = '<?php echo $this->Html->url('/') ?>' + urlLimit + '/' + limit + '/' + order + '/' + orderType;
    }

    function addPayment(paymentAssociationId, tableId, countColumns) {

        if (typeof tableId != 'undefined' || tableId != null) {
            // Do stuff
            var dataTable = jQuery('#' + tableId).DataTable();
            var myCheckboxes = new Array();
            var count = countColumns + 1;

            jQuery.each(dataTable.rows('.selected').data(), function(key, item) {
                myCheckboxes.push(item[count]);
            });
        } else {
            var myCheckboxes = new Array();
            jQuery('.id:checked').each(function() {
                myCheckboxes.push(jQuery(this).val());
            });
        }
        if (myCheckboxes.length > 0) {

            if (jQuery('#type').val()) {
                var type = jQuery('#type').val();
            } else {
                var type = 'frais';
            }
            jQuery('#dialogModalPayments').dialog('option', 'title', 'Paiement');
            jQuery('#dialogModalPayments').dialog('open');

            jQuery('#dialogModalPayments').load('<?php echo $this->Html->url('/payments/addPayment/') ?>' + myCheckboxes + '/' + paymentAssociationId + '/' + type, function() {
                $(".select-popup").select2({
                    sorter: function(data) {
                        /* Sort data using lowercase comparison */
                        return data.sort(function(a, b) {
                            a = a.text.toLowerCase();
                            b = b.text.toLowerCase();
                            if (a > b) {
                                return 1;
                            } else if (a < b) {
                                return -1;
                            }
                            return 0;
                        });
                    },
                    allowDuplicates: true
                });
            });
        }
    }


    function editPayment(id, paymentAssociationId) {
        if (jQuery('#type').val()) {
            var type = jQuery('#type').val();
        } else {
            var type = 'frais';
        }
        var controller = $("#controller").val();
        var url = $("#url").val();
        var page = $("#page").val();

        jQuery('#dialogModalPayments').dialog('option', 'title', 'Paiement');
        jQuery('#dialogModalPayments').dialog('open');
        jQuery('#dialogModalPayments').dialog('open');
        jQuery('#dialogModalPayments').load('<?php echo $this->Html->url('/payments/editPayment/') ?>' + id + '/' + paymentAssociationId + '/' + controller + '/' + type + '/' + url + '/' + page, function() {
            $(".select-popup").select2({
                sorter: function(data) {
                    /* Sort data using lowercase comparison */
                    return data.sort(function(a, b) {
                        a = a.text.toLowerCase();
                        b = b.text.toLowerCase();
                        if (a > b) {
                            return 1;
                        } else if (a < b) {
                            return -1;
                        }
                        return 0;
                    });
                },
                allowDuplicates: true
            });
        });

    }

    function duplicatePayment(id, paymentAssociationId) {

        jQuery('#dialogModalDuplicatePayments').dialog('option', 'title', 'Paiement');
        jQuery('#dialogModalDuplicatePayments').dialog('open');
        jQuery('#dialogModalDuplicatePayments').load('<?php echo $this->Html->url('/payments/duplicatePayment/') ?>' + id + '/' + paymentAssociationId);
    }

    function addCashing() {
        jQuery('#dialogModalPayments').dialog('option', 'title', 'Nouvel encaissement');
        jQuery('#dialogModalPayments').dialog('open');
        jQuery('#dialogModalPayments').load('<?php echo $this->Html->url('/payments/addCashing') ?>');
        jQuery('#dialogModalPayments').load('<?php echo $this->Html->url('/payments/addCashing') ?>', function() {
            $(".select-popup").select2({
                sorter: function(data) {
                    /* Sort data using lowercase comparison */
                    return data.sort(function(a, b) {
                        a = a.text.toLowerCase();
                        b = b.text.toLowerCase();
                        if (a > b) {
                            return 1;
                        } else if (a < b) {
                            return -1;
                        }
                        return 0;
                    });
                },
                allowDuplicates: true
            });
        });
    }

    function addDisbursement() {
        jQuery('#dialogModalPayments').dialog('option', 'title', 'Nouvel décaissement');
        jQuery('#dialogModalPayments').dialog('open');
        jQuery('#dialogModalPayments').load('<?php echo $this->Html->url('/payments/addDisbursement') ?>', function() {
            $(".select-popup").select2({
                sorter: function(data) {
                    /* Sort data using lowercase comparison */
                    return data.sort(function(a, b) {
                        a = a.text.toLowerCase();
                        b = b.text.toLowerCase();
                        if (a > b) {
                            return 1;
                        } else if (a < b) {
                            return -1;
                        }
                        return 0;
                    });
                },
                allowDuplicates: true
            });
        });

    }

    function moneyTransfer() {
        jQuery('#dialogModalPayments').dialog('option', 'title', '<?php echo __('Money transfer') ?>');
        jQuery('#dialogModalPayments').dialog('open');


        jQuery('#dialogModalPayments').load('<?php echo $this->Html->url('/payments/moneyTransfer') ?>', function() {
            $(".select-popup").select2({
                sorter: function(data) {
                    /* Sort data using lowercase comparison */
                    return data.sort(function(a, b) {
                        a = a.text.toLowerCase();
                        b = b.text.toLowerCase();
                        if (a > b) {
                            return 1;
                        } else if (a < b) {
                            return -1;
                        }
                        return 0;
                    });
                },
                allowDuplicates: true
            });
        });
    }

    function advancedPayment(paymentAssociationId, tableId, countColumns) {

        if (typeof tableId != 'undefined' || tableId != null) {
            // Do stuff
            var dataTable = jQuery('#' + tableId).DataTable();
            var myCheckboxes = new Array();
            var count = countColumns + 1;

            jQuery.each(dataTable.rows('.selected').data(), function(key, item) {
                myCheckboxes.push(item[count]);
            });
        } else {
            var myCheckboxes = new Array();
            jQuery('.id:checked').each(function() {
                myCheckboxes.push(jQuery(this).val());
            });
        }
        if (myCheckboxes.length > 0) {
            var type = jQuery('#type').val();

            jQuery('#dialogModalAdvencedPayments').dialog('option', 'title', 'Règlement avancé');
            jQuery('#dialogModalAdvencedPayments').dialog('open');
            jQuery('#dialogModalAdvencedPayments').load('<?php echo $this->Html->url('/payments/advancedPayment/') ?>' + myCheckboxes + '/' + type + '/' + paymentAssociationId);
        }

    }

    function associateAdvancedPaymentToTransportBill(transportBillId, paymentAssociationId) {
        var link = '<?php echo $this->Html->url('/payments/associateAdvancedPaymentToTransportBill/') ?>' + transportBillId + '/' + paymentAssociationId;
        var myCheckboxes = new Array();
        jQuery('.id2:checked').each(function() {
            myCheckboxes.push(jQuery(this).val());
        });

        jQuery.ajax({
            type: "POST",
            url: link,
            data: "ids=" + myCheckboxes,
            dataType: "json",
            success: function(json) {
                if (json.response === true) {
                    jQuery('#reglement').load('<?php echo $this->Html->url('/payments/getRegulations/') ?>' + transportBillId, function() {
                        jQuery('#total').load('<?php echo $this->Html->url('/transportBills/getTotalsById/') ?>' + transportBillId);
                    });

                } else {

                }
            }
        });

    }

    function dissociatePaymentsToTransportBill(transportBillId) {

        var link = '<?php echo $this->Html->url('/payments/dissociatePayments/') ?>';
        var myCheckboxes = new Array();
        jQuery('.id3:checked').each(function() {
            myCheckboxes.push(jQuery(this).val());
        });
        var model = 'TransportBill';
        jQuery.ajax({
            type: "GET",
            url: link,
            data: {
                ids: JSON.stringify(myCheckboxes),
                billIds: transportBillId,
                model: model
            },
            dataType: "json",
            success: function(json) {
                if (json.response === true) {
                    jQuery('#reglement').load('<?php echo $this->Html->url('/payments/getRegulations/') ?>' + transportBillId, function() {
                        jQuery('#total').load('<?php echo $this->Html->url('/transportBills/getTotalsById/') ?>' + transportBillId);
                    });
                }
            }
        });

    }

    function verifyIdCustomers(paymentAssociationId, operation, tableId, countColumns) {


        var link = '<?php echo $this->Html->url('/payments/verifyIdCustomers/') ?>' + paymentAssociationId;
        if (typeof tableId != 'undefined' || tableId != null) {
            // Do stuff
            var dataTable = jQuery('#' + tableId).DataTable();
            var myCheckboxes = new Array();
            var count = countColumns + 1;
            jQuery.each(dataTable.rows('.selected').data(), function(key, item) {
                myCheckboxes.push(item[count]);
            });
        } else {
            var myCheckboxes = new Array();
            jQuery('.id:checked').each(function() {
                myCheckboxes.push(jQuery(this).val());
            });
        }
        if (myCheckboxes.length > 0) {
            jQuery.ajax({
                type: "POST",
                url: link,
                data: "ids=" + myCheckboxes,
                dataType: "json",
                success: function(json) {
                    if (json.response === true) {
                        verifyAmountRemaining(paymentAssociationId, operation, tableId, countColumns);
                    } else {
                        switch (paymentAssociationId) {
                            case '3':
                                $("#msg").html('<div id="flashMessage" class="message"><div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?php echo __('Select a driver to pay mission costs'); ?></div></div>');
                                scrollToAnchor('container-fluid');
                                break;

                            case '4':
                                $("#msg").html('<div id="flashMessage" class="message"><div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?php echo __('Select a client to pay invoices'); ?></div></div>');
                                scrollToAnchor('container-fluid');
                                break;
                            case '5':
                                $("#msg").html('<div id="flashMessage" class="message"><div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?php echo __('Select a supplier to pay reservations'); ?></div></div>');
                                scrollToAnchor('container-fluid');
                                break;
                            case '9':
                                $("#msg").html('<div id="flashMessage" class="message"><div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?php echo __('Select a supplier to pay bills'); ?></div></div>');
                                scrollToAnchor('container-fluid');
                                break;
                            case '12':
                                $("#msg").html('<div id="flashMessage" class="message"><div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?php echo __('Select a client to sale credit notes'); ?></div></div>');
                                scrollToAnchor('container-fluid');
                                break;
                        }
                    }
                }
            });
        }
    }

    function verifyAmountRemaining(paymentAssociationId, operation, tableId, countColumns) {

        var link = '<?php echo $this->Html->url('/payments/verifyAmountRemaining/') ?>' + paymentAssociationId;

        if (typeof tableId != 'undefined' || tableId != null) {
            // Do stuff
            var dataTable = jQuery('#' + tableId).DataTable();
            var myCheckboxes = new Array();
            var count = countColumns + 1;

            jQuery.each(dataTable.rows('.selected').data(), function(key, item) {
                myCheckboxes.push(item[count]);
            });
        } else {
            var myCheckboxes = new Array();
            jQuery('.id:checked').each(function() {
                myCheckboxes.push(jQuery(this).val());
            });
        }
        if (myCheckboxes.length > 0) {
            jQuery.ajax({
                type: "POST",
                url: link,
                data: "ids=" + myCheckboxes,
                dataType: "json",
                success: function(json) {
                    if (json.response === true) {
                        if (operation == 'addPayment') {
                            addPayment(paymentAssociationId, tableId, countColumns);
                        } else {
                            advancedPayment(paymentAssociationId, tableId, countColumns);
                        }
                    } else {
                        switch (paymentAssociationId) {
                            case '3':
                                $("#msg").html('<div id="flashMessage" class="message"><div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?php echo __('All selected mission costs are already paid.'); ?></div></div>');
                                scrollToAnchor('container-fluid');
                                break;
                            case '4':
                                $("#msg").html('<div id="flashMessage" class="message"><div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?php echo __('All selected invoices are already paid.'); ?></div></div>');
                                scrollToAnchor('container-fluid');
                                break;
                            case '5':
                                $("#msg").html('<div id="flashMessage" class="message"><div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?php echo __('All selected reservations are already paid.'); ?></div></div>');
                                scrollToAnchor('container-fluid');
                                break;
                            case '9':
                                $("#msg").html('<div id="flashMessage" class="message"><div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?php echo __('All selected bills are already paid.'); ?></div></div>');
                                scrollToAnchor('container-fluid');
                                break;
                        }
                    }
                }
            });
        }
    }

    function transform(ch) {
        var ch2 = "";
        for (var i = 0; i < ch.length; i++) {
            if (($.isNumeric(ch[i])) || (ch[i] == "/") || (ch[i] == " ") || (ch[i] == ":")) {
                ch2 = ch2 + "" + ch[i];
            } else {
                break;
            }
        }
        return ch2;
    }

    function verifyDriverLicenseCategory() {

        var car_id = jQuery('#cars').val();
        var customer_id = jQuery('#customers').val();

        if (customer_id != '') {
            jQuery.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url('/customerCars/verifyDriverLicenseCategory/') ?>",

                data: {
                    car_id: car_id,
                    customer_id: customer_id
                },
                dataType: "json",
                success: function(json) {

                    if (json.response === "true") {
                        if (json.car_category_id === "1") {
                            if (json.car_type_id === '10' || json.car_type_id === '11' ||
                                json.car_type_id === '16' || json.car_type_id === '18') {
                                alert("Le véhicule porte une remorque et le conducteur n'a pas de permis catégorie E");
                            } else {
                                alert("Le véhicule est un camion et le conducteur n'a pas de permis catégorie C");
                            }

                        } else {
                            alert("Le véhicule est leger et le conducteur n'a pas de permis catégorie B");
                        }


                    }
                }
            });

        }
    }

    function getCountTableColumns() {
        $('#datatable-responsive thead tr').clone(true).appendTo('#datatable-responsive thead');
        var colCount = 0;
        $('#datatable-responsive thead tr th').each(function() {
            colCount++;
        });
        return colCount;
    }

    function getPlaceHolderInputSearch() {
        var controller = $("#controller").val();
        if (controller !== 'events') {
            var colCount = getCountTableColumns();
        }
        console.log('colCount');
        console.log(colCount);
        console.log(controller);
        var i = 1;
        $('#datatable-responsive thead tr:eq(1) th').each(function() {
            var title = $(this).text();
            var action = $("#action").val();
            if (i == 1) {
                $(this).html('');
            }
            if (i > 1 && i < colCount) {
                switch (controller) {
                    case 'CustomerCars':
                        if (i == 8 || i == 9 || i == 10) {
                            $(this).html('<input type="text" class="date_index search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                            jQuery(".date_index").inputmask("dd-mm-yyyy", {
                                "placeholder": "01-01-1000"
                            });
                        } else {
                            $(this).html('<input type="text" class="search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                        }
                        break;

                    case 'events':
                        /*if (i == 6 || i == 7) {
                            $(this).html('<input type="text" class="date_index search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                            jQuery(".date_index").inputmask("dd-mm-yyyy", {"placeholder": "01-01-1000"});
                        } else {
                            $(this).html('<input type="text" class="search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                        }*/
                        break;

                    case 'contracts':
                        if (i == 7 || i == 8) {
                            $(this).html('<input type="text" class="date_index search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                            jQuery(".date_index").inputmask("dd-mm-yyyy", {
                                "placeholder": "01-01-1000"
                            });
                        } else {
                            $(this).html('<input type="text" class="search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                        }
                        break;

                    case 'reservations':
                        if (i == 7 || i == 8) {
                            $(this).html('<input type="text" class="date_index search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                            jQuery(".date_index").inputmask("dd-mm-yyyy", {
                                "placeholder": "01-01-1000"
                            });
                        } else {
                            $(this).html('<input type="text" class="search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                        }
                        break;

                    case 'transportBills':

                        if (action == 'index' || action == 'search' || action == 'liste') {

                            if (i == 3) {

                                $(this).html('<input type="text" class="date_index search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                                jQuery(".date_index").inputmask("dd-mm-yyyy", {
                                    "placeholder": "01-01-1000"
                                });
                            } else {
                                $(this).html('<input type="text" class="search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                            }
                        } else {

                            if (action == 'addFromCustomerOrder' || action == 'listeAddFromCustomerOrder') {
                                if (i == 5) {
                                    $(this).html('<input type="text" class="date_index search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                                    jQuery(".date_index").inputmask("dd-mm-yyyy", {
                                        "placeholder": "01-01-1000"
                                    });
                                } else {
                                    $(this).html('<input type="text" class="search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                                }
                            } else {
                                if (i == 8 || i == 10 || i == 11) {
                                    $(this).html('<input type="text" class="date_index search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                                    jQuery(".date_index").inputmask("dd-mm-yyyy", {
                                        "placeholder": "01-01-1000"
                                    });
                                } else {
                                    $(this).html('<input type="text" class="search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                                }
                            }
                        }

                        break;

                    case 'payments':
                        if (i == 2 || i == 11 || i == 12 || i == 10) {
                            $(this).html('<input type="text" class="date_index search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                            jQuery(".date_index").inputmask("dd-mm-yyyy", {
                                "placeholder": "01-01-1000"
                            });
                        } else {
                            $(this).html('<input type="text" class="search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                        }
                        break;

                    case 'bills':
                        if (i == 3) {
                            $(this).html('<input type="text" class="date_index search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                            jQuery(".date_index").inputmask("dd-mm-yyyy", {
                                "placeholder": "01-01-1000"
                            });
                        } else {
                            $(this).html('<input type="text" class="search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                        }
                        break;

                    case 'transportBillDetailRides':
                        if (i == 3) {
                            $(this).html('<input type="text" class="date_index search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                            jQuery(".date_index").inputmask("dd-mm-yyyy", {
                                "placeholder": "01-01-1000"
                            });
                        } else {
                            $(this).html('<input type="text" class="search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                        }
                        break;

                    case 'sheetRides':
                        if (i == 5 || i == 6) {
                            $(this).html('<input type="text" class="date_index search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                            jQuery(".date_index").inputmask("dd-mm-yyyy", {
                                "placeholder": "01-01-1000"
                            });
                        } else {
                            $(this).html('<input type="text" class="search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                        }
                        break;

                    case 'sheetRideDetailRides':
                        if (i == 7 || i == 9) {
                            $(this).html('<input type="text" class="date_index search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                            jQuery(".date_index").inputmask("dd-mm-yyyy", {
                                "placeholder": "01-01-1000"
                            });
                        } else {
                            $(this).html('<input type="text" class="search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                        }
                        break;

                    default:
                        $(this).html('<input type="text" class="search_datatable" placeholder="' + title + '" id="' + i + '"/>');
                        break;
                }
            }
            i++;

            $('input', this).on('keyup change', function(e) {
                /*if ( that.search() !== this.value ) {
                    that.search( this.value ).draw();
                }*/

                if (e.which == 13) {
                    var controller = $("#controller").val();
                    var action = $("#action").val();
                    var value = this.value;
                    //value = value.replace(' ', 'espace');
                    var find = ' ';
                    var re = new RegExp(find, 'g');
                    value = value.replace(re, 'espace');
                    //value = value.replace('/', 'slash');
                    var find = '/';
                    var re = new RegExp(find, 'g');
                    value = value.replace(re, 'slash');
                    //value = value.replace('-', 'tiret');

                    var find = '-';
                    var re = new RegExp(find, 'g');
                    value = value.replace(re, 'tiret');
                    //value = value.replace('°', 'bouton_num');
                    var find = '°';
                    var re = new RegExp(find, 'g');
                    value = value.replace(re, 'bouton_num');
                    var urlListe = controller + '/' + action;


                    if ($("#typePiece").val()) {
                        var type = $("#typePiece").val();
                        if ($("#category").val()) {
                            var category = $("#category").val();
                        } else {
                            var category = '';
                        }

                        jQuery('#listeDiv').load('<?php echo $this->Html->url('/') ?>' + urlListe + '/' + type + '/' + this.id + '/' + value + '/' + category, function() {
                            var contenuDiv = jQuery('#pageCount').html();
                            jQuery('#pagination').html(contenuDiv);
                            $('#datatable-responsive input[type="checkbox"]').iCheck({
                                checkboxClass: 'icheckbox_flat-red',
                                radioClass: 'iradio_flat-red'
                            });

                        });
                    } else {

                        if ($("#current_action").val()) {
                            var currentAction = $("#current_action").val();
                            if (currentAction == 'getSheetsToEdit') {
                                var transportBillDetailRideId = $("#transportBillDetailRideId").val();
                                var observationId = $("#observationId").val();
                                jQuery('#listeDiv').load('<?php echo $this->Html->url('/') ?>' + urlListe + '/' + this.id + '/' + value + '/' + currentAction + '/' + transportBillDetailRideId + '/' + observationId, function() {
                                    var contenuDiv = jQuery('#pageCount').html();
                                    jQuery('#pagination').html(contenuDiv);
                                    $('#datatable-responsive input[type="checkbox"]').iCheck({
                                        checkboxClass: 'icheckbox_flat-red',
                                        radioClass: 'iradio_flat-red'
                                    });
                                });
                            } else {

                                jQuery('#listeDiv').load('<?php echo $this->Html->url('/') ?>' + urlListe + '/' + this.id + '/' + value + '/' + currentAction, function() {
                                    var contenuDiv = jQuery('#pageCount').html();
                                    jQuery('#pagination').html(contenuDiv);
                                    $('#datatable-responsive input[type="checkbox"]').iCheck({
                                        checkboxClass: 'icheckbox_flat-red',
                                        radioClass: 'iradio_flat-red'
                                    });

                                });
                            }

                        } else {

                            jQuery('#listeDiv').load('<?php echo $this->Html->url('/') ?>' + urlListe + '/' + this.id + '/' + value, function() {
                                var contenuDiv = jQuery('#pageCount').html();
                                jQuery('#pagination').html(contenuDiv);
                                $('#datatable-responsive input[type="checkbox"]').iCheck({
                                    checkboxClass: 'icheckbox_flat-red',
                                    radioClass: 'iradio_flat-red'
                                });

                            });
                        }
                    }

                    $(this).focus();

                }


            });
        });
    }
</script>

<?php $this->end(); ?>