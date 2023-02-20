<?php

App::uses('AppController', 'Controller');

/**
 * Employees Controller
 *
 * @property Bill $Bill
 * @property Company $Company
 * @property Supplier $Supplier
 * @property SheetRide $SheetRide
 * @property TransportBillCategory $TransportBillCategory
 * @property BillProduct $BillProduct
 * @property Product $Product
 * @property ProductPrice $ProductPrice
 * @property PriceCategory $PriceCategory
 * @property Lot $Lot
 * @property Payment $Payment
 * @property DetailPayment $DetailPayment
 * @property ProductFamily $ProductFamily
 * @property Transformation $Transformation
 * @property Tva $Tva
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class EmployeesController extends AppController
{

    public function index()
    {
        $this->viewBuilder()->layout('datatables');

        $employees = $this->paginate($this->Employees);

        $this->set(compact('employees'));
        $this->set('_serialize', array('employees'));
    }

    /**
     * staticData Method
     */
    public function staticData()
    {
        $this->viewBuilder()->layout('datatables');
    }


    public function employees()
    {
        $this->viewBuilder()->layout('datatables');
        $query = array();
        $query['count']  = "SELECT count( Employees.id) AS count  FROM `employees` Employees LEFT JOIN departments Departments ON Employees.`department_id` = Departments.id LEFT JOIN designations Designations ON Employees.`designation_id` = Designations.id  WHERE 1=1 ";

        $query['detail'] = "SELECT Employees.id, Employees.`first_name`, Employees.`last_name`, Employees.`email`, Employees.uuid, Employees.`created`, Departments.dept_name, Designations.name FROM `employees` Employees LEFT JOIN departments Departments ON Employees.`department_id` = Departments.id LEFT JOIN designations Designations ON Employees.`designation_id` = Designations.id   WHERE  1=1 ";
        $this->request->session()->write('query', $query);
    }


    public function ajaxManageEmployees(){

        $this->autoRender = false;
        $requestData= $this->request->data;
        extract($this->request->session()->read('query'));


        $columns = array(
            0 => 'Employees.id',
            1 => 'Employees.first_name',
            2 => 'Employees.last_name',
            3 => 'Employees.email',
            4 => 'Designations.name',
            5 => 'Departments.dept_name',
            6 => 'Employees.created',
            7 => 'Employees.uuid',
        );


        $conn = ConnectionManager::get('default');
        $results = $conn->execute($count)->fetchAll('assoc');
        $totalData = isset($results[0]['count']) ? $results[0]['count'] : 0;

        $totalFiltered = $totalData;

        $sidx = $columns[$requestData['order'][0]['column']];
        $sord = $requestData['order'][0]['dir'];
        $start = $requestData['start'];
        $length = $requestData['length'];

        $SQL = $detail." ORDER BY $sidx $sord LIMIT $start , $length ";
        $results = $conn->execute( $SQL )->fetchAll('assoc');

        $i = 0;
        $data = array();
        foreach ( $results as $row){
            $nestedData= array();
            $nestedData[] = $row["id"];
            $nestedData[] = $row["first_name"];
            $nestedData[] = $row["last_name"];
            $nestedData[] = $row['email'];
            $nestedData[] = $row['name'];
            $nestedData[] = $row['dept_name'];
            $nestedData[] = $row['created'];
            $data[] = $nestedData;
            $i++;
        }
        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),
            "recordsTotal"    => intval( $totalData ),
            "recordsFiltered" => intval( $totalFiltered ),
            "data"            => $data
        );
        echo json_encode($json_data);exit;
    }


    public function search()
    {
        $this->viewBuilder()->layout('datatables');
        $query = array();
        $query['count']  = "SELECT count( Employees.id) AS count  FROM `employees` Employees LEFT JOIN departments Departments ON Employees.`department_id` = Departments.id LEFT JOIN designations Designations ON Employees.`designation_id` = Designations.id  WHERE 1=1 ";

        $query['detail'] = "SELECT Employees.id, Employees.`first_name`, Employees.`last_name`, Employees.`email`, Employees.uuid, Employees.`created`, Departments.dept_name, Designations.name FROM `employees` Employees LEFT JOIN departments Departments ON Employees.`department_id` = Departments.id LEFT JOIN designations Designations ON Employees.`designation_id` = Designations.id   WHERE  1=1 ";
        $this->request->session()->write('query', $query);
    }

    public function ajaxManageEmployeesSearch(){
        $this->autoRender = false;
        $requestData= $this->request->data;
        extract($this->request->session()->read('query'));

        $cond = "";
        if( isset($requestData['search']['value']) && !empty( $requestData['search']['value'] ) ){
            $search = $requestData['search']['value'];
            $cond.=" AND ( Employees.id LIKE '".$search."%' OR  Employees.first_name LIKE '".$search."%'
             OR Employees.last_name LIKE '".$search."%' OR Employees.email LIKE '".$search."%'
             OR Designations.name LIKE '".$search."%' OR Departments.dept_name LIKE '".$search."%'
            )";
        }


        $columns = array(
            0 => 'Employees.id',
            1 => 'Employees.first_name',
            2 => 'Employees.last_name',
            3 => 'Employees.email',
            4 => 'Designations.name',
            5 => 'Departments.dept_name',
            6 => 'Employees.created',
            7 => 'Employees.uuid',
        );

        $count = $count.$cond;
        $detail = $detail.$cond;

        $conn = ConnectionManager::get('default');
        $results = $conn->execute($count)->fetchAll('assoc');
        $totalData = isset($results[0]['count']) ? $results[0]['count'] : 0;

        $totalFiltered = $totalData;

        $sidx = $columns[$requestData['order'][0]['column']];
        $sord = $requestData['order'][0]['dir'];
        $start = $requestData['start'];
        $length = $requestData['length'];

        $SQL = $detail." ORDER BY $sidx $sord LIMIT $start , $length ";
        $results = $conn->execute( $SQL )->fetchAll('assoc');

        $i = 0;
        $data = array();
        foreach ( $results as $row){
            $nestedData= array();
            $nestedData[] = $row["id"];
            $nestedData[] = $row["first_name"];
            $nestedData[] = $row["last_name"];
            $nestedData[] = $row['email'];
            $nestedData[] = $row['name'];
            $nestedData[] = $row['dept_name'];
            $nestedData[] = $row['created'];
            $data[] = $nestedData;
            $i++;
        }
        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),
            "recordsTotal"    => intval( $totalData ),
            "recordsFiltered" => intval( $totalFiltered ),
            "data"            => $data
        );
        echo json_encode($json_data);exit;
    }


    public function customSearch()
    {
        //$this->viewBuilder()->layout('datatables');
        $query = array();
        $query['count']  = "SELECT count( Employees.id) AS count  FROM `employees` Employees LEFT JOIN departments Departments ON Employees.`department_id` = Departments.id LEFT JOIN designations Designations ON Employees.`designation_id` = Designations.id  WHERE 1=1 ";

        $query['detail'] = "SELECT Employees.id, Employees.`first_name`, Employees.`last_name`, Employees.`email`, Employees.uuid, Employees.`created`, Departments.dept_name, Designations.name FROM `employees` Employees LEFT JOIN departments Departments ON Employees.`department_id` = Departments.id LEFT JOIN designations Designations ON Employees.`designation_id` = Designations.id   WHERE  1=1 ";
        $this->Session->write('query', $query);
    }

    public function ajaxEmployeesCustomSearch(){
        $this->autoRender = false;
        $requestData= $this->request->data;
        extract($this->request->session()->read('query'));
        $cond = ' ';


        // getting records as per search parameters
        if( !empty($requestData['columns'][0]['search']['value']) ){   //emp_no
            $cond.=" AND Employees.id LIKE '".$requestData['columns'][0]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][1]['search']['value']) ){  //first_name
            $cond.=" AND UPPER(Employees.first_name) LIKE '".strtoupper($requestData['columns'][1]['search']['value'])."%' ";
        }

        if( !empty($requestData['columns'][2]['search']['value']) ){  //last_name
            $cond.=" AND UPPER(Employees.last_name) LIKE '".strtoupper($requestData['columns'][2]['search']['value'])."%' ";
        }

        if( !empty($requestData['columns'][3]['search']['value']) ){  //email
            $cond.=" AND UPPER(Employees.email) LIKE '".strtoupper($requestData['columns'][3]['search']['value'])."%' ";
        }

        if( !empty($requestData['columns'][4]['search']['value']) ){  //Designations Name
            $cond.=" AND UPPER(Designations.name) LIKE '".strtoupper($requestData['columns'][4]['search']['value'])."%' ";
        }

        if( !empty($requestData['columns'][5]['search']['value']) ){  //Departments name
            $cond.=" AND UPPER(Departments.dept_name) LIKE '".strtoupper($requestData['columns'][5]['search']['value'])."%' ";
        }




        $columns = array(
            0 => 'Employees.id',
            1 => 'Employees.first_name',
            2 => 'Employees.last_name',
            3 => 'Employees.email',
            4 => 'Designations.name',
            5 => 'Departments.dept_name',
            6 => 'Employees.created',
            7 => 'Employees.uuid',
        );

        $count = $count.$cond;
        $detail = $detail.$cond;

        $conn = ConnectionManager::get('default');
        $results = $conn->execute($count)->fetchAll('assoc');
        $totalData = isset($results[0]['count']) ? $results[0]['count'] : 0;

        $totalFiltered = $totalData;

        $sidx = $columns[$requestData['order'][0]['column']];
        $sord = $requestData['order'][0]['dir'];
        $start = $requestData['start'];
        $length = $requestData['length'];

        $SQL = $detail." ORDER BY $sidx $sord LIMIT $start , $length ";
        $results = $conn->execute( $SQL )->fetchAll('assoc');

        $i = 0;
        $data = array();
        foreach ( $results as $row){
            $nestedData= array();
            $nestedData[] = $row["id"];
            $nestedData[] = $row["first_name"];
            $nestedData[] = $row["last_name"];
            $nestedData[] = $row['email'];
            $nestedData[] = $row['name'];
            $nestedData[] = $row['dept_name'];
            $nestedData[] = $row['created'];
            $data[] = $nestedData;
            $i++;
        }
        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),
            "recordsTotal"    => intval( $totalData ),
            "recordsFiltered" => intval( $totalFiltered ),
            "data"            => $data
        );
        echo json_encode($json_data);exit;
    }


    public function responsive()
    {
        $this->viewBuilder()->layout('datatables');
        $query = array();
        $query['count']  = "SELECT count( Employees.id) AS count  FROM `employees` Employees LEFT JOIN departments Departments ON Employees.`department_id` = Departments.id LEFT JOIN designations Designations ON Employees.`designation_id` = Designations.id  WHERE 1=1 ";

        $query['detail'] = "SELECT Employees.id, Employees.`first_name`, Employees.`last_name`, Employees.`email`, Employees.uuid, Employees.`created`, Departments.dept_name, Designations.name FROM `employees` Employees LEFT JOIN departments Departments ON Employees.`department_id` = Departments.id LEFT JOIN designations Designations ON Employees.`designation_id` = Designations.id   WHERE  1=1 ";
        $this->request->session()->write('query', $query);
    }

    public function ajaxEmployeesResponsive(){
        $this->autoRender = false;
        $requestData= $this->request->data;
        extract($this->request->session()->read('query'));
        $cond = ' ';


        // getting records as per search parameters
        if( !empty($requestData['columns'][0]['search']['value']) ){   //emp_no
            $cond.=" AND Employees.id LIKE '".$requestData['columns'][0]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][1]['search']['value']) ){  //first_name
            $cond.=" AND UPPER(Employees.first_name) LIKE '".strtoupper($requestData['columns'][1]['search']['value'])."%' ";
        }

        if( !empty($requestData['columns'][2]['search']['value']) ){  //last_name
            $cond.=" AND UPPER(Employees.last_name) LIKE '".strtoupper($requestData['columns'][2]['search']['value'])."%' ";
        }

        if( !empty($requestData['columns'][3]['search']['value']) ){  //email
            $cond.=" AND UPPER(Employees.email) LIKE '".strtoupper($requestData['columns'][3]['search']['value'])."%' ";
        }

        if( !empty($requestData['columns'][4]['search']['value']) ){  //Designations Name
            $cond.=" AND UPPER(Designations.name) LIKE '".strtoupper($requestData['columns'][4]['search']['value'])."%' ";
        }

        if( !empty($requestData['columns'][5]['search']['value']) ){  //Departments name
            $cond.=" AND UPPER(Departments.dept_name) LIKE '".strtoupper($requestData['columns'][5]['search']['value'])."%' ";
        }




        $columns = array(
            0 => 'Employees.id',
            1 => 'Employees.first_name',
            2 => 'Employees.last_name',
            3 => 'Employees.email',
            4 => 'Designations.name',
            5 => 'Departments.dept_name',
            6 => 'Employees.created',
            7 => 'Employees.uuid',
        );

        $count = $count.$cond;
        $detail = $detail.$cond;

        $conn = ConnectionManager::get('default');
        $results = $conn->execute($count)->fetchAll('assoc');
        $totalData = isset($results[0]['count']) ? $results[0]['count'] : 0;

        $totalFiltered = $totalData;

        $sidx = $columns[$requestData['order'][0]['column']];
        $sord = $requestData['order'][0]['dir'];
        $start = $requestData['start'];
        $length = $requestData['length'];

        $SQL = $detail." ORDER BY $sidx $sord LIMIT $start , $length ";
        $results = $conn->execute( $SQL )->fetchAll('assoc');

        $i = 0;
        $data = array();
        foreach ( $results as $row){
            $nestedData= [];
            $nestedData[] = $row["id"];
            $nestedData[] = $row["first_name"];
            $nestedData[] = $row["last_name"];
            $nestedData[] = $row['email'];
            $nestedData[] = $row['name'];
            $nestedData[] = $row['dept_name'];
            $nestedData[] = $row['created'];
            $data[] = $nestedData;
            $i++;
        }
        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),
            "recordsTotal"    => intval( $totalData ),
            "recordsFiltered" => intval( $totalFiltered ),
            "data"            => $data
        );
        echo json_encode($json_data);exit;
    }

    public function responsiveImmediate()
    {
        $this->viewBuilder()->layout('datatables');
        $query = array();
        $query['count']  = "SELECT count( Employees.id) AS count  FROM `employees` Employees LEFT JOIN departments Departments ON Employees.`department_id` = Departments.id LEFT JOIN designations Designations ON Employees.`designation_id` = Designations.id  WHERE 1=1 ";

        $query['detail'] = "SELECT Employees.id, Employees.`first_name`, Employees.`last_name`, Employees.`email`, Employees.uuid, Employees.`created`, Departments.dept_name, Designations.name FROM `employees` Employees LEFT JOIN departments Departments ON Employees.`department_id` = Departments.id LEFT JOIN designations Designations ON Employees.`designation_id` = Designations.id   WHERE  1=1 ";
        $this->request->session()->write('query', $query);
    }

    public function responsiveModal()
    {
        $this->viewBuilder()->layout('datatables');
        $query = array();
        $query['count']  = "SELECT count( Employees.id) AS count  FROM `employees` Employees LEFT JOIN departments Departments ON Employees.`department_id` = Departments.id LEFT JOIN designations Designations ON Employees.`designation_id` = Designations.id  WHERE 1=1 ";

        $query['detail'] = "SELECT Employees.id, Employees.`first_name`, Employees.`last_name`, Employees.`email`, Employees.uuid, Employees.`created`, Departments.dept_name, Designations.name FROM `employees` Employees LEFT JOIN departments Departments ON Employees.`department_id` = Departments.id LEFT JOIN designations Designations ON Employees.`designation_id` = Designations.id   WHERE  1=1 ";
        $this->request->session()->write('query', $query);
    }

    public function actionRow(){
        $this->viewBuilder()->layout('datatables');
        $query = array();
        $query['count']  = "SELECT count( Employees.id) AS count  FROM `employees` Employees LEFT JOIN departments Departments ON Employees.`department_id` = Departments.id LEFT JOIN designations Designations ON Employees.`designation_id` = Designations.id  WHERE 1=1 ";

        $query['detail'] = "SELECT Employees.id, Employees.`first_name`, Employees.`last_name`, Employees.`email`, Employees.uuid, Employees.`created`, Departments.dept_name, Designations.name FROM `employees` Employees LEFT JOIN departments Departments ON Employees.`department_id` = Departments.id LEFT JOIN designations Designations ON Employees.`designation_id` = Designations.id   WHERE  1=1 ";
        $this->request->session()->write('query', $query);
    }

    public function ajaxEmployeesAction(){
        $this->autoRender = false;
        $requestData= $this->request->data;
        extract($this->request->session()->read('query'));
        $cond = ' ';


        // getting records as per search parameters
        if( !empty($requestData['columns'][0]['search']['value']) ){   //emp_no
            $cond.=" AND Employees.id LIKE '".$requestData['columns'][0]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][1]['search']['value']) ){  //first_name
            $cond.=" AND UPPER(Employees.first_name) LIKE '".strtoupper($requestData['columns'][1]['search']['value'])."%' ";
        }

        if( !empty($requestData['columns'][2]['search']['value']) ){  //last_name
            $cond.=" AND UPPER(Employees.last_name) LIKE '".strtoupper($requestData['columns'][2]['search']['value'])."%' ";
        }

        if( !empty($requestData['columns'][3]['search']['value']) ){  //email
            $cond.=" AND UPPER(Employees.email) LIKE '".strtoupper($requestData['columns'][3]['search']['value'])."%' ";
        }

        if( !empty($requestData['columns'][4]['search']['value']) ){  //Designations Name
            $cond.=" AND UPPER(Designations.name) LIKE '".strtoupper($requestData['columns'][4]['search']['value'])."%' ";
        }

        if( !empty($requestData['columns'][5]['search']['value']) ){  //Departments name
            $cond.=" AND UPPER(Departments.dept_name) LIKE '".strtoupper($requestData['columns'][5]['search']['value'])."%' ";
        }




        $columns = array(
            0 => 'Employees.id',
            1 => 'Employees.first_name',
            2 => 'Employees.last_name',
            3 => 'Employees.email',
            4 => 'Designations.name',
            5 => 'Departments.dept_name',
            6 => 'Employees.created',
            7 => 'Employees.uuid',
        );

        $count = $count.$cond;
        $detail = $detail.$cond;

        $conn = ConnectionManager::get('default');
        $results = $conn->execute($count)->fetchAll('assoc');
        $totalData = isset($results[0]['count']) ? $results[0]['count'] : 0;

        $totalFiltered = $totalData;

        $sidx = $columns[$requestData['order'][0]['column']];
        $sord = $requestData['order'][0]['dir'];
        $start = $requestData['start'];
        $length = $requestData['length'];

        $SQL = $detail." ORDER BY $sidx $sord LIMIT $start , $length ";
        $results = $conn->execute( $SQL )->fetchAll('assoc');

        $i = 0;
        $data = array();
        foreach ( $results as $row){
            $nestedData= array();

            $link = "<div class='btn-group action '>
                <button type='button' class='btn btn-danger'> <i class='fa fa-cog' aria-hidden='true'></i> Options</button>
                <button type='button' class='btn btn-danger dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    <span class='caret'></span>
                    <span class='sr-only'>Toggle Dropdown</span>
                </button>
                <ul class='dropdown-menu'>
                    <li><a title='Edit' href='#'> <i class='fa fa-edit'></i> Edit</a></li>
                    <li class='divider'></li>
                    <li><a title='Edit' href='#'> <i class='fa fa-sticky-note'></i> New Invoice </a></li>
                    <li><a title='Edit' href='#'> <i class='fa fa-edit'></i> New Quote </a></li>
                    <li><a title='Edit' href='#'> <i class='fa fa-money'></i> Enter Payment </a></li>
                    <li class='divider'></li>
                    <li><a class='smart_delete' href='#'> <i class='fa fa-trash-o'></i> Delete</a></li>

                </ul>
            </div>";

            $nestedData[] = $row["id"];
            $nestedData[] = $row["first_name"];
            $nestedData[] = $row["last_name"];
            $nestedData[] = $row['email'];
            $nestedData[] = $row['name'];
            $nestedData[] = $row['dept_name'];
            $nestedData[] = $row['created'];
            $nestedData[] = $link;
            $data[] = $nestedData;
            $i++;
        }
        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),
            "recordsTotal"    => intval( $totalData ),
            "recordsFiltered" => intval( $totalFiltered ),
            "data"            => $data
        );
        echo json_encode($json_data);exit;
    }


    public function fixedHeader()
    {
        $this->viewBuilder()->layout('datatables');
        $query = array();
        $query['count']  = "SELECT count( Employees.id) AS count  FROM `employees` Employees LEFT JOIN departments Departments ON Employees.`department_id` = Departments.id LEFT JOIN designations Designations ON Employees.`designation_id` = Designations.id  WHERE 1=1";

        $query['detail'] = "SELECT Employees.id, Employees.`first_name`, Employees.`last_name`, Employees.`email`, Employees.uuid, Employees.`created`, Departments.dept_name, Designations.name FROM `employees` Employees LEFT JOIN departments Departments ON Employees.`department_id` = Departments.id LEFT JOIN designations Designations ON Employees.`designation_id` = Designations.id   WHERE  1=1 ";
        $this->request->session()->write('query', $query);
    }

    /**
     * scroller method
     */
    public function scroller()
    {
        $this->viewBuilder()->layout('datatables');
        $query = array();
        $query['count']  = "SELECT count( Employees.id) AS count  FROM `employees` Employees LEFT JOIN departments Departments ON Employees.`department_id` = Departments.id LEFT JOIN designations Designations ON Employees.`designation_id` = Designations.id  WHERE 1=1";

        $query['detail'] = "SELECT Employees.id, Employees.`first_name`, Employees.`last_name`, Employees.`email`, Employees.uuid, Employees.`created`, Departments.dept_name, Designations.name FROM `employees` Employees LEFT JOIN departments Departments ON Employees.`department_id` = Departments.id LEFT JOIN designations Designations ON Employees.`designation_id` = Designations.id   WHERE  1=1 ";
        $this->request->session()->write('query', $query);
    }

    public function faker()
    {
        $this->autoRender = false;
        /*$generator = Faker\Factory::create();
        $populator = new Faker\ORM\Propel\Populator($generator);
        $populator->addEntity('Employee', 5);
        $insertedPKs = $populator->execute();
        echo "<pre>"; print_r($insertedPKs); echo "</pre>";exit;*/

        $faker = Faker\Factory::create();
        $entityPopulator = new Faker\ORM\CakePHP\EntityPopulator('Employees');
        $populator = new Faker\ORM\CakePHP\Populator($faker);
        $populator->addEntity($entityPopulator, 20);
        $populator->execute(array('validate' => false));

    }








}