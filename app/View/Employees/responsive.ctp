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

<script>
$(document).ready(function() {
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
			url : "<?= $this->Url->build(['controller' => 'employees', 'action' => 'ajax_employees_responsive']) ?>",
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
