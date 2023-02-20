
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
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var dataTable = $('#employees-grid').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax":{
			url : "<?= $this->Url->build(['controller' => 'employees', 'action' => 'ajax_employees_custom_search']) ?>",
           
            type: "post",
            error: function(){
                $(".employees-grid-error").html("");
                $("#employees-grid").append('<tbody class="employees-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#employees-grid_processing").css("display","none");
            }
        }
    } );
} );
</script>
