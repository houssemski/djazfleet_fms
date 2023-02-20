<?php
/** @var string $tableId */
/** @var array $columns */
/** @var int $defaultLimit */
/** @var string $tableName */
?>
<script>
    jQuery(document).ready(function () {

        // Initialize Datatables
        $.fn.dataTable.ext.classes.sPageButton = 'paginate_button page-item'; // Change Pagination Button Class

        jQuery.fn.dataTable.ext.errMode = 'alert';
        var columnToExport = [<?php

            for ($i = 0; $i < count($columns); $i++) {
                echo $i;
                if ($i != count($columns) - 1) {
                    echo ",";
                }
            }
            ?>];
        var dataTable = jQuery('#<?= $tableId ?>').DataTable({
            fixedHeader: false,

            responsive: true,
            orderCellsTop: true,
            "createdRow": function (row, data, dataIndex) {
                var className = data[<?= count($columns) + 1 ?>];

                $(row).attr('id', className);
                <?php switch($tableName) {
                    case 'SheetRide' :
                        ?>
                        $(row).find("td:not(.actions)").attr('onclick', 'viewDetail('+className+')');
                $(row).find("td").eq(2).css('background-color', '#90EE90');
                $(row).find("td").eq(1).css('background-color', '#FFA500');
                <?php     break;
                    case 'TransportBill' :
                        if($type!=0){?>
                            $(row).find("td:not(.actions)").attr('onclick', 'viewDetail('+className+',<?= $type ?>)');

                            $(row).find("td").eq(2).css('background-color', '#87CEFA');
                            $(row).find("td").eq(4).css('background-color', '#F08080');
                            $(row).find("td").eq(6).css('background-color', '#F08080');



                <?php }else { ?>
                $(row).find("td").eq(2).css('background-color', '#87CEFA');
                $(row).find("td").eq(4).css('background-color', '#87CEFA');
                $(row).find("td").eq(6).css('background-color', '#F08080');
                $(row).find("td").eq(8).css('background-color', '#F08080');
                <?php     } ?>

                   <?php     break;
                    case 'TransportBillDetailRides' : ?>
                        $(row).find("td:not(.actions)").attr('onclick', 'viewTransportBillDetailRideObservations('+className+')');
                    <?php    break;
                    case 'SheetRideDetailRides' : ?>

                $(row).find("td").eq(2).css('background-color', '#87CEFA');
                $(row).find("td").eq(3).css('background-color', '#FFA500');
                $(row).find("td").eq(4).css('background-color', '#90EE90');
                $(row).find("td").eq(5).css('background-color', '#F08080');

                <?php    break;
                 } ?>
            },
            "autoWidth": false,
            "columnDefs": [
                <?php
                $i = 0;
                foreach ($columns as $column){
                if($column['4'] == "datetime" || $column['4'] == "date") { ?>
                {
                    "width": "150px",
                    "targets": <?= $i ?>,
                    "render": $.fn.dataTable.moment('DD/MM/YYYY'),
                    "type": "datetime",
                    "format": "DD/MM/YYYY",
                    "orderData": [ <?= $i ?>, 0 ]
                },
                <?php } else {
                if(isset($column['3'])){ ?>
                {
                    "width": "<?= $column[3] ?>",
                    "targets": <?= $i ?>,
                    "orderData": [ <?= $i ?>, 0 ]
                },


                <?php    }
                }
                $i++;
                }
                ?>
            <?php if($action != 'addFromSheetRide' && $action != 'addFromCustomerOrder'&& $action != 'addFromPreinvoice'&& $action != 'viewDetail') { ?>
                {"width": "100px", "targets": <?= $i ?>, "class": "actions"}
                <?php } ?>
            ],
            "sPageButtonActive": "page-link current",
            "bAutoWidth": false,
            "processing": true,
            "serverSide": true,
            "scrollX": false,
            "scrollY": 400,
            "stateSave": true,
            "paging": true,

            "pageLength": <?= intval($defaultLimit) ?>,

            "ajax": {

                <?php if(($tableName =='TransportBill' && $action =='index') ||
                ( $action =='addFromSheetRide') ){
                     ?>
                    url: "<?= $this->Html->url("/$controller/ajaxModelResponsive/$type") ?>",
                <?php }else {
                    if($tableName =='SheetRide' && $action =='getSheetsToEdit'){ ?>

                url: "<?= $this->Html->url("/$controller/ajaxModelResponsive/$type/$transportBillDetailRideId/$observationId") ?>",
                   <?php }else {
                    ?>
                    url: "<?= $this->Html->url("/$controller/ajaxModelResponsive") ?>",
                <?php } }?>

                type: "post",
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText + ' ' + textStatus.toString() + ' ' + errorThrown.toString());
                    jQuery(".<?= $tableId ?>-error").html("");
                    jQuery("#<?= $tableId ?>").append('<tbody class="employees-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    jQuery("#<?= $tableId ?>_processing").css("display", "none");
                }

            },
            "drawCallback": function (settings) {
                $('.dataTables_paginate > .pagination > li > a').addClass('page-link');
                jQuery(".date-index").inputmask("date", {"placeholder": "dd-mm-yyyy"});
                <?php if($tableName =='TransportBill' && $action =='index'){ ?>
                var total_ht = settings.json.totals['total_ht'];
                var total_ttc = settings.json.totals['total_ttc'];
                var total_tva = settings.json.totals['total_tva'];

                jQuery("#total_ht").html(total_ht);
                jQuery("#total_ttc").html(total_ttc);
                jQuery("#total_tva").html(total_tva);
                <?php  }?>

            },

            dom: 'Bfrtip',
            select: true,
            lengthMenu: [
                [ 10, 50, 100, 200, -1 ],
                [ '10 rows', '50 rows', '100 rows','200 rows', 'Show all' ]
            ],
            buttons: [
                'pageLength',

                <?php if($action == 'viewDetail') { ?>
                {
                    text: '<?= __('Select all') ?>',
                    action: function () {
                        $( '.approve' ).prop('checked', true);
                        $("#approve-mission-grid tbody tr" ).toggleClass('selected');
                        $('#select_with_pagination').val(0);
                    }
                },
                {
                    text: '<?= __('Select none') ?>',
                    action: function () {
                        $( '.approve' ).prop('checked', false);
                        $("#approve-mission-grid  tbody tr" ).toggleClass('selected');
                        $('#select_with_pagination').val(0);

                    }
                },

                <?php } else { ?>
                {
                    text: '<?= __('Select all') ?>',
                    action: function () {
                        $( '.checkbox' ).prop('checked', true);
                        $("tbody tr" ).toggleClass('selected');
                        $('#select_with_pagination').val(0);

                    }
                },
                {
                    text: '<?= __('Select none') ?>',
                    action: function () {
                        $( '.checkbox' ).prop('checked', false);
                        $("tbody tr" ).toggleClass('selected');
                        $('#select_with_pagination').val(0);

                    }
                },
                <?php } ?>

                <?php if($action == 'addFromSheetRide' ||
                         $action == 'viewDetail' ||
                         $action == 'addFromPreinvoice'
                            ) { ?>
                    {
                        text: '<?= __('Select all with pagination') ?>',
                        action: function () {
                            $( '.checkbox' ).prop('checked', true);
                            $("tbody tr" ).toggleClass('selected');
                            $('#select_with_pagination').val(1);

                        }
                    }
                <?php     } ?>

          ]
      });
        var oTable = $('#<?= $tableId ?>').dataTable();
        $('select#engines').change( function() { oTable.fnFilter( $(this).val() ); } );

        jQuery(dataTable.table().container()).removeClass('form-inline');
      /*jQuery('# $tableId ?>').on('length.dt', function (e, settings, len) {
          jQuery.ajax({
              type: 'GET',
              url: " $this->Html->url("/transportBills/updateAuthenticatedUserDefaultLength") ?>",
              data: "length=" + len,

          }).done(function (data) {
              // alert(data);
              //dataTable.columns.adjust().draw();
          });
      });*/
      //Hide Global Search Box
      jQuery('.search-txt').on('keyup change', function (e) {
          if(e.keyCode == 13 ) {
              var nbColumn = ($("table").find("tr:first th").length-1)/2;
              for(var j = 0; j<=nbColumn; j++){
                  var i = $('[data-column='+j+']').attr('data-column');
                  var v = jQuery.trim($('[data-column='+j+']').val());
                  if(v!=''){
                  dataTable.columns(i).search(v).draw();
                  }
              }
         } else {
              if ( jQuery(this).val() == "") {
                  var i = jQuery(this).attr('data-column');
                  var v = jQuery.trim(jQuery(this).val());
                  dataTable.columns(i).search(v).draw();
              }
          }
      });

      jQuery('#<?= $tableId ?> tbody').on('click', '.checkbox', function (event) {
          /*event.stopPropagation();
          var trId = $(this).parents('tr:first').attr('id');
          $("#" + '' + trId + '').toggleClass('selected');
          if($("#" + '' + trId + '').attr('class') =='odd selected'){
              $("#" + '' + trId + '').removeClass('btn-info  btn-trans');
              $("#" + '' + trId + '').css({"backgroundColor": "#edd1d1"});

          }else {
              $("#" + '' + trId + '').css({"backgroundColor": ""});
          }*/

      });

      jQuery('#delete').click(function (event) {
          var res = confirm('<?= __('Are you sure you want to delete selected items ?') ?>');
          var error = false;
          if (res) {
//alert( dataTable.rows('.selected').data().length +' row(s) selected' );

              jQuery.each(dataTable.rows('.selected').data(), function (key, item) {
                  var id =  item[<?= count($columns) + 1 ?>];
                    jQuery.ajax({
                        type: 'Post',
                        url:"<?= $this->Html->url("/$controller/$deleteFonction") ?>",
                        data: "id=" + item[<?= count($columns) + 1 ?>],
                        dataType: "json",
                        success: function (json) {
                            console.log(json);
                            if (json.response === "true") {

                                jQuery('#' + id).remove();
                            }else {
                                document.location.reload(true);
                            }
                        }

                    })
                });
                if (error) {
                    alertErrorMessage('<?=  __('Selected items has been deleted.') ?>', function () {
                        dataTable.columns.adjust().draw();
                    });
                } else {
                    dataTable.columns.adjust().draw();
                }
            }


        });



        jQuery('#cancel-customer-order').click(function (event) {
            var myCheckboxes = new Array();
            jQuery.each(dataTable.rows('.selected').data(), function (key, item) {
                myCheckboxes.push(item[<?= count($columns) + 1 ?>]);
            });
            jQuery('#dialogModalCancelCauses').dialog('option', 'title', "<?php echo __("Cancel causes") ?>");
            jQuery('#dialogModalCancelCauses').dialog('open');
            jQuery('#dialogModalCancelCauses').load('<?php echo $this->Html->url('/sheetRides/cancelCustomerOrders/')?>' + myCheckboxes+'/'+'SheetRide');


        });



    });



    function addSelectedCheckbox(el) {

        var trId = el.parents('tr:first').attr('id');
        $("#" + '' + trId + '').toggleClass('selected');
        if($("#" + '' + trId + '').attr('class') =='odd selected'){
            $("#" + '' + trId + '').removeClass('btn-info  btn-trans');
            $("#" + '' + trId + '').css({"backgroundColor": "#edd1d1"});

        }else {
            $("#" + '' + trId + '').css({"backgroundColor": ""});
        }
        event.stopPropagation();
    }
    function ConfirmDelete(name) {
        confirm("Are you sure you want to delete " + name + " ?");

    }
</script>