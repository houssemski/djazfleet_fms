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
    <div class="clearfix"></div>
    <div class="col-sm-12">
        <h2 class="text-center">
           Back to Tutorial... <a class="url-color" href="//www.smarttutorials.net/cakephp-3-ajax-pagination-using-datatable-jquery-mysql-and-bootstrap-3/" target="_blank">CakePHP 3 Ajax Pagination Using Datatable, jQuery, MySQL and Bootstrap 3</a>
        </h2>
    </div>
</div>

<script>
$.extend( true, $.fn.dataTable.defaults, {
    searching: false
} );
$(document).ready(function() {
    var dataTable = $('#employees-grid').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax":{
			url : "<?= $this->Url->build(['controller' => 'employees', 'action' => 'ajax_manage_employees']) ?>",
         
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
