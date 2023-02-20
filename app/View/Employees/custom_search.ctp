<style>
    #adBlockerPopup .modal-header{background: #e74c3c;color: #fff;}
    #adBlockerPopup .modal-header h4{color: #fff;}
    #adBlockerPopup .modal-footer{text-align: center;}
    #adBlockerPopup .modal-footer i{color:#fff;padding-right: 5px;}
    #adBlockerPopup .modal-footer .btn{border-radius:0px;width: 200px;height: 40px;font-size: 17px;}
</style>
<?php

$this->start('css'); ?>
    <?= $this->Html->css('cake_datatables/bootstrap.min'); ?>
    <?= $this->Html->css('cake_datatables/font-awesome.min'); ?>
    <?= $this->Html->css('cake_datatables/datatables-extensions/dataTables.bootstrap.min'); ?>
    <?= $this->Html->css('cake_datatables/datatables-extensions/responsive.bootstrap'); ?>
    <?= $this->Html->css('cake_datatables/datatables-extensions/fixedHeader.bootstrap.min'); ?>
    <?= $this->Html->css('cake_datatables/datatables-extensions/scroller.bootstrap.min'); ?>

<?php $this->end();
?>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive12">
            <table id="employees-grid"  class="table table-striped">
                <thead>
                    <tr>
                        <th>Employees No</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Designations</th>
                        <th>Department</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <td><input type="text" data-column="0"  class="form-control search-txt"></td>
                        <td><input type="text" data-column="1"  class="form-control search-txt"></td>
                        <td><input type="text" data-column="2"  class="form-control search-txt"></td>
                        <td><input type="text" data-column="3"  class="form-control search-txt"></td>
                        <td><input type="text" data-column="4"  class="form-control search-txt"></td>
                        <td><input type="text" data-column="5"  class="form-control search-txt"></td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<?php $this->start('script'); ?>

<?= $this->Html->script('cake_datatables/jquery-1.12.3'); ?>
<?= $this->Html->script('cake_datatables/bootstrap.min'); ?>
<?= $this->Html->script('cake_datatables/jquery.dataTables.min'); ?>
<?= $this->Html->script('cake_datatables/datatables-extensions/dataTables.bootstrap.min'); ?>
<?= $this->Html->script('cake_datatables/datatables-extensions/dataTables.responsive.min'); ?>
<?= $this->Html->script('cake_datatables/datatables-extensions/dataTables.fixedHeader'); ?>
<?= $this->Html->script('cake_datatables/datatables-extensions/dataTables.scroller.min'); ?>

<script type="text/javascript">
$(document).ready(function() {
    (function(){
        var adBlockFlag = document.createElement('div');
        adBlockFlag.innerHTML = '&nbsp;';
        adBlockFlag.className = 'adsbox';
        $('body').append(adBlockFlag);
        window.setTimeout(function() {
            if (adBlockFlag.offsetHeight === 0) {
                showAdBlockPopUp();
                $('body').addClass('adblock');
            }
            adBlockFlag.remove();
        }, 100);

        function showAdBlockPopUp(){
            var adBlockerPopup = $('#adBlockerPopup');
            adBlockerPopup.modal({
                backdrop: 'static',
                keyboard: false
            });
            adBlockerPopup.modal('show');
        }

        $(document).on('click', '#adBlockerPopupRefresh', function(){
            location.reload();
        });

    })();
    var dataTable = $('#employees-grid').DataTable( {
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.childRow,
                renderer: function ( api, rowIdx ) {
				    var data = api.cells( rowIdx, ':hidden' ).eq(0).map( function ( cell ) {
					    var header = $( api.column( cell.column ).header() );
				        return  '<p style="color:#00A">'+header.text()+' : '+api.cell( cell ).data()+'</p>';
				    } ).toArray().join('');

				    return data ?    $('<table/>').append( data ) :    false;
				}
            }
        },
        "processing": true,
        "serverSide": true,
        "ajax":{
			url : "<?= $this->Url->build(array('controller' => 'employees', 'action' => 'ajax_employees_custom_search')) ?>",
            type: "post",
            error: function(){
                $(".employees-grid-error").html("");
                $("#employees-grid").append('<tbody class="employees-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#employees-grid_processing").css("display","none");
            }
        }

    } );

    //Hide Global Search Box
    $("#employees-grid_filter").css("display","none");

    $('.search-txt').on( 'keyup change', function () {
        var i =$(this).attr('data-column');
        var v = $.trim( $(this).val() );
        dataTable.columns(i).search(v).draw();
    } );
} );
</script>

<?php $this->end(); ?>
