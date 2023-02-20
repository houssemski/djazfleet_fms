<?php
/**
 * Application level Controller
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 */

App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('CakeResponse', 'Network');
App::uses('ImageComponent', 'Controller/Component');
if (class_exists('Enum') != true) {
    include("Enum.php");
}


if (class_exists('ParametersEnum') != true) {
    include("ParametersEnum.php");
}

include("ActionsEnum.php");
include("StatusEnum.php");
include("SectionsEnum.php");
include("SupplierTypesEnum.php");
include("BillTypesEnum.php");
include("TransportBillTypesEnum.php");
include("ConsumptionTypesEnum.php");
include("ProfilesEnum.php");
include("CarStatusesEnum.php");
include("TransportBillDetailRideStatusesEnum.php");
include("SupplierCategoriesEnum.php");


/**
 * Application Controller
 *
 * @property Car $Car
 * @property Cafyb $Cafyb
 * @property Event $Event
 * @property User $User
 * @property Parameter $Parameter
 * @property SerialNumber $SerialNumber
 * @property Option $Option
 * @property Language $Language
 * @property CustomerCar $CustomerCar
 * @property Product $Product
 * @property Bill $Bill
 * @property Supplier $Supplier
 * @property Coupon $Coupon
 * @property Audit $Audit
 * @property UserParc $UserParc
 * @property Leasing $Leasing
 * @property SheetRide $SheetRide
 * @property TransportBill $TransportBill
 * @property Complaint $Complaint
 * @property TransportBillDetailRides $TransportBillDetailRides
 * @property Report $Report
 * @property Alert $Alert
 * @property Notification $Notification
 * @property Profile $Profile
 * @property SheetRideDetailRides $SheetRideDetailRides
 * @property TransportBillDetailRideFactor $TransportBillDetailRideFactor
 * @property AccessPermission $AccessPermission
 * @property Section $Section
 * @property AuthComponent $Auth
 * @property AclComponent $Acl
 * @property CookieComponent $Cookie
 * @property EmailComponent $Email
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 * @property EventTypeProduct $EventTypeProduct
 * @property Structures $Structures
 * @property Workshop $Workshop
 * @property Reservation $Reservation
 * @property Attachment $Attachment
 * @property AttachmentType $AttachmentType
 * @property SheetRideDetailRideMarchandise $SheetRideDetailRideMarchandise
 * @property bool $IsAdministrator
 * @property Parc $Parc
 */
class AppController extends Controller
{
    public $uses = array(
        'User',
        'Cafyb',
        'Complaint',
        'Event',
        'Parameter',
        'Option',
        'App',
        'Language',
        'Supplier',
        'Car',
        'Product',
        'Reservation',
        'Attachment',
        'Bill',
        'Coupon',
        'Audit',
        'UserParc',
        'Leasing',
        'SheetRide',
        'TransportBill',
        'Report',
        'Alert',
        'AttachmentType',
        'Notification',
        'SheetRideDetailRides',
        'AccessPermission',
        'Section',
        'TransportBillDetailRides',
        'TransportBillDetailedRides',
        'TransportBillDetailRideFactor',
        'SheetRideDetailRideMarchandise',
        'Profile',
        'EventTypeProduct',
        'Structures',
        'SerialNumber',
        'Workshop',
        'CarState',
        'Marchandise',
        'Parc',
    );
    public $components = array(
        'Session',
        'Security',
        'Flash',
        'Auth' => array(
            'LoginRedirect' => Array('controller' => 'pages', 'action' => 'display', 'home'),
            'LogoutRedirect' => Array('controller' => 'pages', 'action' => 'display', 'home')
        )//,'DebugKit.Toolbar'
    );


    function beforeFilter()
    {

        $this->Security->unlockedActions = array('edit', 'delete', 'add', 'view');

        $this->Auth->authError = __("Username or password invalid");

        if (Configure::read("cafyb") == '1') {
                if (in_array($this->params['controller'], array('pages')) &&
                    in_array($this->params['action'], array('home','display','homeCafyb'))
                ) {
                    $this->Auth->allow();
                }

        }
        if (Configure::read("transport_personnel") == '1') {
                if (in_array($this->params['controller'], array('pages')) &&
                    in_array($this->params['action'], array('personalTransportDashboard'))
                ) {
                    $this->Auth->allow();
                }
        }

        if (in_array($this->params['controller'], array('sheetRideDetailRides','customers',
                'users','rides','destinations'))&&
            in_array($this->params['action'], array('getSheetRideDetailRidesByStatusId',
                'getAuthorizedCustomers','getAttachments','saveAttachment','loginCafyb',
                'addUser','personalTransportDashboard','getDestinationsByKeyWord',
                'breakpointByArrivalId','getNameDestination','getSheetRidesByClosestMarkerIdAndArrivalId',
                'getBreakpointByBetweenClosestMarkerIdAndArrivalId'))
        ) {
            // For RESTful web service requests, we check the name of our contoller
            $this->Auth->allow();
            // this line should always be there to ensure that all rest calls are secure
            /* $this->Security->requireSecure(); */
            $this->Security->unlockedActions = array('edit', 'delete', 'add', 'view');

        } else {
            // setup out Auth
            //$this->Auth->allow();
        }
        $this->getNameSheetRide();
        $this->moduleDisplayed();
        $this->isMultiWarehouses();
        $this->Security->blackHoleCallback = 'blackhole';
        $this->IsAdministrator = $this->isSuperAdmin();
    }


    /**
     * @param null $type
     * @param null $transportBillDetailRideId
     * @param null $observationId
     */
    public function ajaxModelResponsive($type = null ,$transportBillDetailRideId = null, $observationId = null )
    {
        $this->autoRender = false;
        $requestData = $this->request->data;
        extract($this->Session->read('query'));
        $typeDoc = $type;
        /** @var array $columns */
        /** @var string $tableName */
        /** @var string $controller */
        /** @var string $itemName */
        /** @var string $conditions */
        /** @var string $order */
        /** @var string $group */
        /** @var string $action */
        /** @var int $type*/
        /** @var int $transportBillDetailRideId */
        /** @var int $observationId */

        if(($tableName =='TransportBill' && $action =='index') ||
            ($tableName =='transport_bills' && $action =='index') ||
            ($tableName =='transportBills' && $action =='index') ||
            ($tableName =='transportBill' && $action =='index')
        ){
            $generalConditions = $this->getTransportBillGeneralConditions($type);

        } else {
            $generalConditions =' ';
        }
        $cond = $generalConditions.$conditions;
        // getting records as per search parameters
        if ((isset($requestData['search']['value']) && !empty($requestData['search']['value'])) ||
            (isset($requestData['search']['value']) && ($requestData['search']['value'] == 0))
        ) {
            $search = trim(strtolower($requestData['search']['value']));
            $i = 0;
            foreach ($columns as $column) {
                $columnName = $column[0];
                if ($i == 0 && (count($columns) == 1)) {
                    // first element and we have 1 column
                    $cond .= " AND ( LOWER(" . $columnName . ") LIKE '%" . $search . "%')";
                } elseif ($i == 0 && (count($columns) > 1)) {
                    // first element and we have multiple columns
                    $cond .= " AND ( LOWER(" . $columnName . ") LIKE '%" . $search . "%' OR ";
                } elseif ($i == (count($columns) - 1)) {
                    // last element
                    $cond .= "LOWER( " . $columnName . " ) LIKE '%" . $search . "%')";
                } else {
                    if ($column[5] == "CONCAT") {
                        if(isset($column[9]) && isset($column[8])){
                            $cond .= " LOWER( " . $column[6] . " ) LIKE '%" . $search . "%' OR  LOWER( " . $column[7] . " ) LIKE '%" . $search . "%' OR LOWER( " . $column[8] . " ) LIKE '%" . $search . "%' OR LOWER( " . $column[9] . " ) LIKE '%" . $search . "%' OR ";
                        } else {
                            $cond .= " LOWER( " . $column[6] . " ) LIKE '%" . $search . "%' OR  LOWER( " . $column[7] . " ) LIKE '%" . $search . "%' OR  ";
                        }

                    } else {
                        $cond .= " LOWER( " . $columnName . " ) LIKE '%" . $search . "%' OR  ";
                    }
                }
                $i++;
            }
        }
        $j = 0;
        // getting records as per search parameters
        foreach ($columns as $column) {
            if (
                (isset($requestData['columns'][$j]['search']['value']) && !empty($requestData['columns'][$j]['search']['value'])) ||
                (isset($requestData['columns'][$j]['search']['value']) && ($requestData['columns'][$j]['search']['value'] == '0'))
            ) {
                $search = trim(strtolower($requestData['columns'][$j]['search']['value']));
                if ($columns[$j][5] == "CONCAT") {
                    if(isset($column[9])|| isset($column[8])){
                        $cond .= " AND ( LOWER(" . $columns[$j][6] . ") LIKE '%" .
                            $search . "%' " .
                            " OR LOWER(" . $columns[$j][7] . ") LIKE '%" . $search . "%' "
                            ." OR LOWER(" . $columns[$j][8] . ") LIKE '%" .$search . "%' "
                            ." OR LOWER(" . $columns[$j][9] . ") LIKE '%" .$search . "%' ) "
                        ;
                    } else {
                        $cond .= " AND ( LOWER(" . $columns[$j][6] . ") LIKE '%" .
                            $search . "%' " .
                            " OR LOWER(" . $columns[$j][7] . ") LIKE '%" .
                            $search . "%' ) ";
                    }
                } else {
                    if ($columns[$j][4] == "date" || $columns[$j][4] == "datetime") {
                        $search = DateTime::createFromFormat('d/m/Y', $search);
                        $search = $search->format('Y-m-d');
                        $cond .= " AND " . $columns[$j][0] . " LIKE '%" .
                            $search . "%' ";
                    } else {
                        $cond .= " AND LOWER(" . $columns[$j][0] . ") LIKE '%" .
                            $search . "%' ";
                    }
                }
            }
            $j++;
        }
        /** @var string $count */
        $count = $count . $cond;
        /** @var string $detail */
        $detail = $detail . $cond;
        $conn = ConnectionManager::getDataSource('default');
        $countResults = $conn->fetchAll($count);
        $totalData = isset($countResults[0][0]['count']) ? $countResults[0][0]['count'] : 0;
        $totalFiltered = $totalData;
        $sidx = $requestData['order'][0]['column'];
        $orderValue = $columns[$sidx][0];
        $sord = $requestData['order'][0]['dir'];
        $start = $requestData['start'];
        $length = $requestData['length'];
        if(!empty($sidx) && !empty($sord)){
            if(isset($group) ){
                if($length !=-1){
                    $SQL = $detail . " GROUP BY $group ORDER BY $orderValue  $sord LIMIT $start , $length ";
                }else {
                    $SQL = $detail . " GROUP BY $group ORDER BY $orderValue  $sord ";
                }
            }else {
                if($length != -1){
                    $SQL = $detail . " ORDER BY   $orderValue  $sord LIMIT $start , $length ";
                }else {
                    $SQL = $detail . " ORDER BY   $orderValue  $sord  ";
                }
            }
        }else {
            if(isset($group) ){
                if($length != -1){
                    $SQL = $detail . " GROUP BY $group ORDER BY $order LIMIT $start , $length ";
                }else {
                    $SQL = $detail . " GROUP BY $group ORDER BY $order  ";
                }
            }else {
                if($length != -1 ){
                    $SQL = $detail . " ORDER BY   $order LIMIT $start , $length ";
                }else {
                    $SQL = $detail . " ORDER BY   $order  ";
                }
            }
        }
        $results = $conn->fetchAll($SQL);
        if ($controller == 'sheetRideDetailRides' && ($action == 'addFromSheetRide' ||
            $action == 'addFromMissionsInvoiced' || $action == 'index')){
            $results = $this->setOrderTypeAndMissionTypeValues($results);
            $results = $this->setMissionsDates($results);
        }

        $i = 0;
        $data = array();
        $link = '';
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $sheetRideWithMission = $this->Parameter->getCodesParameterVal('sheet_ride_with_mission');

        foreach ($results as $row) {
            $nestedData = array();
            $c = 0;
            $id = $row[$tableName]['id'];
            foreach ($columns as $column) {
                switch ($tableName) {
                    case 'SheetRide':
                        switch ($action) {
                            case 'index' ;
                            case 'sheetRidesWithConsumption' ;
                                $carId = $row['SheetRide']['car_id'];
                                $carSubcontracting = $row['SheetRide']['car_subcontracting'];
                                if ($c == 1) {
                                    if ($carSubcontracting == 2) {
                                        if($param == 1){
                                            $nestedData[] = '<span>' . $row[$column[1]][$column[2]] . '</span>';
                                        }else {
                                            $nestedData[] = '<span>' . $row['Car']['immatr_def'] .' '.$row['Carmodel']['name'] . '</span>';
                                        }
                                    } else {
                                        $nestedData[] = '<span>' . $row[$tableName]['car_name'] . '</span>';
                                    }
                                } else {
                                    if($c== 2){
                                        if ($carSubcontracting == 2) {
                                            $nestedData[] = '<span>' . $row[$column[1]][$column[2]] . '</span>';
                                        } else {
                                            $nestedData[] = '<span>' . $row[$tableName]['customer_name'] . '</span>';
                                        }
                                    } else {
                                        if ($c == 7 &&  ($sheetRideWithMission == 1 || $sheetRideWithMission == 3)) {
                                            switch ($row[$column[1]][$column[2]]) {
                                                case 1:
                                                    $nestedData[] = '<span  class="label label-warning">' . __('Planned') . '</span>';
                                                    break;
                                                case 2:
                                                     $nestedData[] = '<span  class="label label-danger">' . __('In progress') . '</span>';
                                                    break;
                                                case 3:
                                                    $nestedData[] = '<span  class="label label-primary">' . __('Return to park') . '</span>';
                                                    break;
                                                case 4:
                                                    $nestedData[] = '<span  class="label label-success">' . __('Closed') . '</span>';
                                                    break;
                                                case 9:
                                                    $nestedData[] = '<span  class="label label-inverse">' . __('Canceled') . '</span>' . " ( " . $row['CancelCause']['name'] . " )";
                                                    break;
                                                 default:
                                                    $nestedData[] = '<span></span>' ;
                                                    break;
                                            }
                                        } else {
                                            if ($c == 0) {
                                                $nestedData[] = ' <input type="checkbox" class="checkbox" style="display: inline-block;" onclick="addSelectedCheckbox($(this));"><span style="padding-left: 30px;" >' . $row[$column[1]][$column[2]] . '</span>';
                                            } else {
                                                if($c == 8 || $c == 9){
                                                    if($c == 9){
                                                       /* $countComplaintOrders = $this->Complaint->getCountComplaintOrders(null,$row[$column[1]][$column[2]]);
                                                        $countComplaintOrders = 0 ;*/
                                                           $countComplaintOrders = $row['SheetRide']['nb_complaints_by_orders'];
                                                        if($countComplaintOrders>0){
                                                            $nestedData[] =   '<span class="btn btn-warning">'.$countComplaintOrders.'</span>';
                                                        }else {
                                                            $nestedData[] =   '<span class="btn btn-success">'.$countComplaintOrders.'</span>';
                                                        }
                                                    }
                                                    if($c == 8){
                                                       /* $countComplaintMissions =  $this->Complaint->getCountComplaintMissions(null, $row[$column[1]][$column[2]]);

                                                        $countComplaintMissions = 0;*/
                                                            $countComplaintMissions = $row['SheetRide']['nb_complaints_by_missions'];
                                                        if($countComplaintMissions>0){
                                                            $nestedData[] =   '<span class="btn btn-warning">'.$countComplaintMissions.'</span>';
                                                        }else {
                                                            $nestedData[] =   '<span class="btn btn-success">'.$countComplaintMissions.'</span>';
                                                        }
                                                    }
                                                }else {
                                                    $rowDate = $row[$column[1]][$column[2]];
                                                    if ($column[4] == "datetime" && !empty($rowDate)) {
                                                        $rowDate = DateTime::createFromFormat('Y-m-d H:i:s', $rowDate);
                                                        $dateTimeValue = $rowDate->format('d/m/Y H:i');
                                                        $nestedData[] = '<span>' . $dateTimeValue . '</span>';
                                                    } else {
                                                        $nestedData[] = '<span>' . $row[$column[1]][$column[2]] . '</span>';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                break;
                            case 'getSheetsToEdit' :
                                $carId = $row['SheetRide']['car_id'];
                                $carSubcontracting = $row['SheetRide']['car_subcontracting'];
                                if ($c == 1) {
                                    if ($carSubcontracting == 2) {
                                        $param = $this->Parameter->getCodesParameterVal('name_car');
                                        if($param == 1){
                                            $nestedData[] = '<span>' . $row[$column[1]][$column[2]] . '</span>';
                                        }else {
                                            $nestedData[] = '<span>' . $row['Car']['immatr_def'] .' '.$row['Carmodel']['name'] . '</span>';
                                        }
                                    } else {
                                        $nestedData[] = '<span>' . $row[$tableName]['car_name'] . '</span>';
                                    }
                                } else {

                                    if($c== 2){
                                        if ($carSubcontracting == 2) {

                                            $nestedData[] = '<span>' . $row[$column[1]][$column[2]] . '</span>';
                                        } else {
                                            $nestedData[] = '<span>' . $row[$tableName]['customer_name'] . '</span>';
                                        }
                                    }else {
                                        if ($c == 6) {
                                            switch ($row[$column[1]][$column[2]]) {
                                                case 1:
                                                    $nestedData[] = '<span  class="label label-warning">' . __('Planned') . '</span>';

                                                    break;
                                                case 2:
                                                    $nestedData[] = '<span  class="label label-danger">' . __('In progress') . '</span>';
                                                    break;
                                                case 3:
                                                    $nestedData[] = '<span  class="label label-primary">' . __('Return to park') . '</span>';

                                                    break;
                                                case 4:
                                                    $nestedData[] = '<span  class="label label-success">' . __('Closed') . '</span>';
                                                    break;

                                                case 9:
                                                    $nestedData[] = '<span  class="label label-inverse">' . __('Canceled') . '</span>' . " ( " . $row['CancelCause']['name'] . " )";

                                                    break;
                                                default:
                                                    $nestedData[] = '<span></span>' ;

                                                    break;
                                            }
                                        } else {
                                            if ($c == 0) {
                                                $nestedData[] = ' <input type="checkbox" class="checkbox" style="display: inline-block;" onclick="addSelectedCheckbox($(this));"><span style="padding-left: 30px;"  >' . $row[$column[1]][$column[2]] . '</span>';
                                            } else {
                                                $rowDate = $row[$column[1]][$column[2]];
                                                if ($column[4] == "datetime" && !empty($rowDate)) {
                                                    $rowDate = DateTime::createFromFormat('Y-m-d H:i:s', $rowDate);
                                                    $dateTimeValue = $rowDate->format('d/m/Y H:i');
                                                    $nestedData[] = '<span>' . $dateTimeValue . '</span>';
                                                } else {
                                                    $nestedData[] = '<span >' . $row[$column[1]][$column[2]] . '</span>';
                                                }
                                            }
                                        }
                                    }
                                }
                                break;
                        }
                        break;
                    case 'SheetRideDetailRides':
                        switch ($action) {
                            case 'index' :
                                $carId = $row['SheetRide']['car_id'];
                                $carSubcontracting = $row['SheetRide']['car_subcontracting'];
                                if ($c == 2) {
                                    if ($row['SheetRideDetailRides']['type_ride'] == 1) {
                                        $nestedData[] = $row['DepartureDestination']['name'] . ' - ' . $row['ArrivalDestination']['name'];
                                    } else {
                                        $nestedData[] = $row['Departure']['name'] . ' - ' . $row['Arrival']['name'];
                                    }
                                } else {

                                    if ($c == 3) {

                                        if ($carSubcontracting == 2) {
                                            $param = $this->Parameter->getCodesParameterVal('name_car');
                                            if($param == 1){
                                                $nestedData[] = '<span>' . $row[$column[1]][$column[2]] . '</span>';
                                            }else {
                                                $nestedData[] = '<span>' . $row['Car']['immatr_def'] .' '.$row['Carmodel']['name'] . '</span>';
                                            }
                                        } else {
                                            $nestedData[] = $row['SheetRide']['car_name'];
                                        }
                                    } else {
                                        if($c == 4){
                                            if ($carSubcontracting == 2) {
                                                $nestedData[] = '<span>' . $row[$column[1]][$column[2]] . '</span>';
                                            } else {
                                                $nestedData[] = '<span>' . $row['SheetRide']['customer_name'] . '</span>';
                                            }
                                        }else {

                                            if ($c == 15) {

                                                switch ($row[$column[1]][$column[2]]) {
                                                    case 1:
                                                        $nestedData[] = '<span class="label label-warning">' . __('Planned') . '</span>';

                                                        break;
                                                    case 2:
                                                        $nestedData[] = '<span class="label label-danger">' . __('In progress') . '</span>';
                                                        break;
                                                    case 3:
                                                        $nestedData[] = '<span class="label label-success">' . __('Closed') . '</span>';

                                                        break;
                                                    case 4:
                                                        $nestedData[] = '<span class="label label-primary">' . __('Preinvoiced') . '</span>';
                                                        break;

                                                    case 5:
                                                        $nestedData[] = '<span class="label label-pink">' . __('Approved') . '</span>';

                                                        break;

                                                    case 6:
                                                        $nestedData[] = '<span class="label bg-olive">' . __('Not approved') . '</span>';

                                                        break;
                                                    case 7:
                                                        $nestedData[] = '<span class="label label-inverse">' . __('Invoiced') . '</span>';

                                                        break;

                                                    case 9:
                                                        $nestedData[] = '<span  class="label label-warning">' . __('Canceled') . "</span>" . " ( " . $row['CancelCause']['name'] . " )";
                                                        break;

                                                    case 10:
                                                        $nestedData[] = '<span  class="label label-danger">' . __('Sale credit notes') . "</span>" ;
                                                        break;


                                                    default:
                                                        $nestedData[] = '<span></span>' ;

                                                        break;
                                                }
                                            } else {
                                                if ($c == 0) {
                                                    $nestedData[] = ' <input type="checkbox" class="checkbox" style="display: inline-block;" onclick="addSelectedCheckbox($(this));"><span style="padding-left: 30px;"  >' . $row[$column[1]][$column[2]] . '</span>';
                                                } else {
                                                    $rowDate = $row[$column[1]][$column[2]];
                                                    if ($column[4] == "datetime" && !empty($rowDate)) {
                                                        $rowDate = DateTime::createFromFormat('Y-m-d H:i:s', $rowDate);
                                                        $dateTimeValue = $rowDate->format('d/m/Y H:i');
                                                        $nestedData[] = $dateTimeValue . "";
                                                    } else {
                                                        $nestedData[] = $row[$column[1]][$column[2]];
                                                    }
                                                }
                                            }
                                        }

                                    }
                                }

                                break;
                            case 'addFromSheetRide' :
                                $carId = $row['SheetRide']['car_id'];
                                $carSubcontracting = $row['SheetRide']['car_subcontracting'];
                                if ($c == 1) {
                                    if ($carSubcontracting == 2) {
                                        $param = $this->Parameter->getCodesParameterVal('name_car');
                                        if($param == 1){
                                            $nestedData[] = '<span>' . $row[$column[1]][$column[2]] . '</span>';
                                        }else {
                                            $nestedData[] = '<span>' . $row['Car']['immatr_def'] .' '.$row['Carmodel']['name'] . '</span>';
                                        }
                                    } else {
                                        $nestedData[] = $row['SheetRide']['car_name'];
                                    }
                                } else {
                                    if ($c == 3) {
                                        if ($row['SheetRideDetailRides']['type_ride'] == 1) {
                                            $nestedData[] = $row['DepartureDestination']['name'] . ' - ' . $row['ArrivalDestination']['name'];
                                        } else {
                                            $nestedData[] = $row['Departure']['name'] . ' - ' . $row['Arrival']['name'];
                                        }
                                    } else {
                                        if ($c == 14) {
                                            switch ($row[$column[1]][$column[2]]) {
                                                case 1:
                                                    $nestedData[] = '<span class="label label-warning">' . __('Planned') . '</span>';

                                                    break;
                                                case 2:
                                                    $nestedData[] = '<span class="label label-danger">' . __('In progress') . '</span>';
                                                    break;
                                                case 3:
                                                    $nestedData[] = '<span class="label label-success">' . __('Closed') . '</span>';

                                                    break;
                                                case 4:
                                                    $nestedData[] = '<span class="label label-primary">' . __('Preinvoiced') . '</span>';
                                                    break;

                                                case 5:
                                                    $nestedData[] = '<span class="label label-pink">' . __('Approved') . '</span>';

                                                    break;

                                                case 6:
                                                    $nestedData[] = '<span class="label bg-olive">' . __('Not approved') . '</span>';

                                                    break;

                                                case 7:
                                                    $nestedData[] = '<span class="label label-inverse ">' . __('Invoiced') . '</span>';

                                                    break;

                                                default:
                                                    $nestedData[] = '<span></span>' ;

                                                    break;
                                            }
                                        } else {
                                            if ($c == 0) {
                                                $nestedData[] = ' <input type="checkbox" class="checkbox" style="display: inline-block;" onclick="addSelectedCheckbox($(this));"><span style="padding-left: 30px;"  >' . $row[$column[1]][$column[2]] . '</span>';
                                            } else {
                                                $rowDate = $row[$column[1]][$column[2]];
                                                if ($column[4] == "datetime" && !empty($rowDate)) {
                                                    $rowDate = DateTime::createFromFormat('Y-m-d H:i:s', $rowDate);
                                                    $dateTimeValue = $rowDate->format('d/m/Y H:i');
                                                    $nestedData[] = $dateTimeValue . "";
                                                } else {
                                                    $nestedData[] = $row[$column[1]][$column[2]];
                                                }
                                            }
                                        }
                                    }
                                }

                                break;
                            case 'closedMissions' :
                                $carId = $row['SheetRide']['car_id'];
                                $carSubcontracting = $row['SheetRide']['car_subcontracting'];
                                if ($c == 1) {
                                    if ($carSubcontracting == 2) {
                                        $param = $this->Parameter->getCodesParameterVal('name_car');
                                        if($param == 1){
                                            $nestedData[] = '<span>' . $row[$column[1]][$column[2]] . '</span>';
                                        }else {
                                            $nestedData[] = '<span>' . $row['Car']['immatr_def'] .' '.$row['Carmodel']['name'] . '</span>';
                                        }
                                    } else {
                                        $nestedData[] = $row['SheetRide']['car_name'];
                                    }
                                } else {
                                    if ($c == 3) {
                                        if ($row['SheetRideDetailRides']['type_ride'] == 1) {
                                            $nestedData[] = $row['DepartureDestination']['name'] . ' - ' . $row['ArrivalDestination']['name'];
                                        } else {
                                            $nestedData[] = $row['Departure']['name'] . ' - ' . $row['Arrival']['name'];
                                        }
                                    } else {
                                            if ($c == 0) {
                                                $nestedData[] = ' <input type="checkbox" class="checkbox" style="display: inline-block;" onclick="addSelectedCheckbox($(this));"><span style="padding-left: 30px;"  >' . $row[$column[1]][$column[2]] . '</span>';
                                            } else {
                                                $rowDate = $row[$column[1]][$column[2]];
                                                if ($column[4] == "datetime" && !empty($rowDate)) {
                                                    $rowDate = DateTime::createFromFormat('Y-m-d H:i:s', $rowDate);
                                                    $dateTimeValue = $rowDate->format('d/m/Y H:i');
                                                    $nestedData[] = $dateTimeValue . "";
                                                } else {
                                                    $nestedData[] = $row[$column[1]][$column[2]];
                                                }
                                            }
                                    }
                                }

                                break;
                            case 'addFromPreinvoice':
                            case 'addFromMissionsInvoiced' :
                                if ($c == 1) {
                                    if ($row['SheetRideDetailRides']['type_ride'] == 1) {
                                        $nestedData[] = $row['DepartureDestination']['name'] . ' - ' . $row['ArrivalDestination']['name'];
                                    } else {
                                        $nestedData[] = $row['Departure']['name'] . ' - ' . $row['Arrival']['name'];
                                    }
                                } else {
                                    if ($c == 13) {
                                        switch ($row[$column[1]][$column[2]]) {
                                            case 1:
                                                $nestedData[] = '<span class="label label-warning">' . __('Planned') . '</span>';

                                                break;
                                            case 2:
                                                $nestedData[] = '<span class="label label-danger">' . __('In progress') . '</span>';
                                                break;
                                            case 3:
                                                $nestedData[] = '<span class="label label-success">' . __('Closed') . '</span>';

                                                break;
                                            case 4:
                                                $nestedData[] = '<span class="label label-primary">' . __('Preinvoiced') . '</span>';
                                                break;

                                            case 5:
                                                $nestedData[] = '<span class="label label-pink">' . __('Approved') . '</span>';

                                                break;

                                            case 6:
                                                $nestedData[] = '<span class="label bg-olive">' . __('Not approved') . '</span>';

                                                break;

                                            case 7:
                                                $nestedData[] = '<span class="label label-inverse">' . __('Invoiced') . '</span>';

                                                break;

                                            default:
                                                $nestedData[] = '<span></span>' ;

                                                break;
                                        }
                                    } else {

                                        if ($c == 0) {
                                            $nestedData[] = ' <input type="checkbox" class="checkbox" style="display: inline-block;" onclick="addSelectedCheckbox($(this));"><span style="padding-left: 30px;"  >' . $row[$column[1]][$column[2]] . '</span>';
                                        } else {

                                            $rowDate = $row[$column[1]][$column[2]];
                                            if ($column[4] == "datetime" && !empty($rowDate)) {
                                                $rowDate = DateTime::createFromFormat('Y-m-d H:i:s', $rowDate);
                                                $dateTimeValue = $rowDate->format('d/m/Y H:i');
                                                $nestedData[] = $dateTimeValue . "";
                                            } else {
                                                $nestedData[] = $row[$column[1]][$column[2]];
                                            }
                                        }
                                    }
                                }
                                break;
                        }
                        break;


                    case 'TransportBill' :
                        $profileId = $this->Auth->user('profile_id');
                        $roleId = $this->Auth->user('role_id');
                        if ($c == 7 || ($profileId == ProfilesEnum::client && $c == 2)
                            || ($type == TransportBillTypesEnum::quote_request && $c == 9)) {
                            switch ($type) {
                                case TransportBillTypesEnum::quote_request:
                                    switch ($row[$column[1]][$column[2]]) {
                                        case 1:
                                            $nestedData[] = '<span  class="label label-danger">' . __('Not transformed') . "</span>";
                                            break;
                                        case 2:
                                            $nestedData[] = '<span  class="label label-success">' . __('Transformed') . "</span>";
                                            break;
                                        default:
                                            $nestedData[] = '<span></span>' ;

                                            break;
                                    }
                                    break;
                                case TransportBillTypesEnum::quote :
                                    switch ($row[$column[1]][$column[2]]) {
                                        case 1:
                                            $nestedData[] = '<span  class="label label-danger">' . __('Not transformed') . "</span>";
                                            break;
                                        case 2:
                                            $nestedData[] = '<span  class="label label-success">' . __('Transformed') . "</span>";
                                            break;
                                        default:
                                            $nestedData[] = '<span></span>' ;

                                            break;
                                    }
                                    break;
                                case TransportBillTypesEnum::order :
                                    switch ($row[$column[1]][$column[2]]) {
                                        case 1:
                                            $nestedData[] = '<span  class="label label-danger">' . __('Not validated') . "</span>";
                                            break;
                                        case 2:
                                            $nestedData[] = '<span  class="label label-warning">' . __('Partially validated') . "</span>";
                                            break;
                                        case 3:
                                            $nestedData[] = '<span class="label label-success">' . __('Validated') . "</span>";
                                            break;
                                        case 8:
                                            $nestedData[] = '<span  class="label label-primary">' . __('Not transmitted') . "</span>";
                                            break;

                                        case 9:
                                            $nestedData[] = '<span  class="label label-inverse">' . __('Canceled') . "</span>" . " ( " . $row['CancelCause']['name'] . " )";
                                            break;
                                        default:
                                            $nestedData[] = '<span></span>' ;

                                            break;
                                    }

                                    break;
                                case TransportBillTypesEnum::pre_invoice :
                                    switch ($row['TransportBill']['status_payment']) {
                                        case 1:
                                            $nestedData[] = '<span class="label label-danger">' . __('Not paid') . "</span>";
                                            break;
                                        case 2:
                                            $nestedData[] = '<span  class="label label-success">' . __('Paid') . "</span>";
                                            break;

                                        case 3:
                                            $nestedData[] = '<span  class="label label-warning">' . __('Partially paid') . "</span>";
                                            break;
                                        default:
                                            $nestedData[] = '<span></span>' ;

                                            break;
                                    }
                                    break;
                                case TransportBillTypesEnum::invoice :
                                case TransportBillTypesEnum::credit_note :
                                    switch ($row['TransportBill']['status_payment']) {
                                        case 1:
                                            $nestedData[] = '<span  class="label label-danger">' . __('Not paid') . "</span>";
                                            break;
                                        case 2:
                                            $nestedData[] = '<span  class="label label-success">' . __('Paid') . "</span>";
                                            break;

                                        case 3:
                                            $nestedData[] = '<span  class="label label-warning">' . __('Partially paid') . "</span>";
                                            break;

                                        default:
                                            $nestedData[] = '<span></span>' ;

                                            break;

                                    }
                                    break;
                            }
                        } else {
                            if ($c == 0) {
                                $nestedData[] = ' <input type="checkbox" class="checkbox" style="display: inline-block;" onclick="addSelectedCheckbox($(this));"><span style="padding-left: 30px;"  >' . $row[$column[1]][$column[2]] . '</span>';
                            } else {
                                if($type == TransportBillTypesEnum::quote_request && $c == 5){
                                    $nestedData[] = '<span>' . $row['DepartureDestination']['name'] . ' - ' . $row['ArrivalDestination']['name'] . '</span>';

                                }else {
                                    if($type == TransportBillTypesEnum::order && ($c == 8 || $c==9)){
                                        if($c == 8){
                                           // $countComplaintOrders = $this->Complaint->getCountComplaintOrders($row[$column[1]][$column[2]]);
                                            $countComplaintOrders = $row['TransportBill']['nb_complaints_by_orders'];


                                            if($countComplaintOrders>0){
                                                $nestedData[] =   '<span class="btn btn-warning">'.$countComplaintOrders.'</span>';
                                            }else {
                                                $nestedData[] =   '<span class="btn btn-success">'.$countComplaintOrders.'</span>';
                                            }
                                        }
                                        if($c == 9){
                                           // $countComplaintMissions =  $this->Complaint->getCountComplaintMissions($row[$column[1]][$column[2]]);
                                            $countComplaintMissions = $row['TransportBill']['nb_complaints_by_missions'];


                                            if($countComplaintMissions>0){
                                                $nestedData[] =   '<span class="btn btn-warning">'.$countComplaintMissions.'</span>';
                                            }else {
                                                $nestedData[] =   '<span class="btn btn-success">'.$countComplaintMissions.'</span>';
                                            }
                                        }
                                    }else {
                                        $rowDate = $row[$column[1]][$column[2]];
                                        if ($column[4] == "date" && !empty($rowDate)) {
                                            $rowDate = DateTime::createFromFormat('Y-m-d H:i:s', $rowDate);
                                            $dateTimeValue = $rowDate->format('d/m/Y');
                                            $nestedData[] = '<span>' . $dateTimeValue . '</span>';
                                        } else {
                                            $nestedData[] = '<span>' . $row[$column[1]][$column[2]] . '</span>';
                                        }
                                    }

                                }

                            }
                        }
                        break;
                    case 'TransportBillDetailRides' :
                        switch ($action) {
                            case 'addFromCustomerOrder':
                                $actionOnclick = 'onclick=viewTransportBillDetailRideObservations(' . $id . ')';
                                $useRideCategory = $this->Session->read('useRideCategory');
                                $transportBillDetailRideInputFactors = $this->TransportBillDetailRideFactor->find('all',
                                    array('conditions'=>array(
                                        'TransportBillDetailRideFactor.transport_bill_detail_ride_id'=>$id,
                                        'Factor.factor_type = 1'
                                    ),
                                        'recursive'=>-1,
                                        'fields'=>array(
                                            'TransportBillDetailRideFactor.factor_value',
                                            'Factor.name',
                                        ),
                                        'joins'=>array(
                                            array(
                                                'table' => 'factors',
                                                'type' => 'left',
                                                'alias' => 'Factor',
                                                'conditions' => array('TransportBillDetailRideFactor.factor_id = Factor.id')
                                            ),
                                        )
                                    )
                                );
                                $transportBillDetailRideSelectFactors = $this->TransportBillDetailRideFactor->find('all',
                                    array('conditions'=>array(
                                        'TransportBillDetailRideFactor.transport_bill_detail_ride_id'=>$id,
                                        'Factor.factor_type = 2'
                                    ),
                                        'recursive'=>-1,
                                        'fields'=>array(
                                            'TransportBillDetailRideFactor.factor_value',
                                            'Factor.name',
                                        ),
                                        'joins'=>array(
                                            array(
                                                'table' => 'factors',
                                                'type' => 'left',
                                                'alias' => 'Factor',
                                                'conditions' => array('TransportBillDetailRideFactor.factor_id = Factor.id')
                                            ),
                                        )

                                    )
                                );
                                if(!empty($transportBillDetailRideSelectFactors)){

                                    $i=0;
                                    foreach ($transportBillDetailRideSelectFactors as $factor){
                                        $this->loadModel($factor['Factor']['name']);
                                        $model = $factor['Factor']['name'];
                                        $option= $this->$model->find('first',
                                            array('conditions'=>array('id'=>$factor['TransportBillDetailRideFactor']['factor_value']),
                                                'recursive'=>-1,
                                                'fields'=>array('name')
                                            ));
                                        $transportBillDetailRideSelectFactors[$i]['Factor']['options'] = $option[$model]['name'];
                                        $i  ++;
                                    }

                                }
                                if ($c == 1) {
                                    if ($row['TransportBillDetailRides']['type_ride'] == 2) {

                                        $productName = '<span>' . $row['Product']['name'] ;
                                        $productInputFactors ='';
                                        $productSelectFactors ='';
                                        if(!empty($transportBillDetailRideInputFactors)){
                                            foreach ($transportBillDetailRideInputFactors as $transportBillDetailRideFactor){
                                                $productInputFactors =  $transportBillDetailRideFactor['Factor']['name'] . ' : ' .$transportBillDetailRideFactor['TransportBillDetailRideFactor']['factor_value']. ' - ';
                                            }
                                           }
                                        if(!empty($transportBillDetailRideSelectFactors)){
                                            foreach ($transportBillDetailRideSelectFactors as $transportBillDetailRideFactor){
                                                $productSelectFactors =  $transportBillDetailRideFactor['Factor']['name'] . ' : ' .$transportBillDetailRideFactor['Factor']['options']. ' - ';
                                            }
                                        }
                                        $totalName = $productName ;
                                        if(!empty($productInputFactors)){
                                            $totalName = $totalName.' - '.$productInputFactors ;
                                        }
                                        if(!empty($productSelectFactors)){
                                            $totalName = $totalName.' - '.$productSelectFactors ;
                                        }
                                        if(!empty($row['Departure']['name'])){
                                            $totalName = $totalName.' - '.$row['Departure']['name'] ;
                                        }
                                        if(!empty($row['Arrival']['name'])){
                                            $totalName = $totalName.' - '.$row['Arrival']['name'] ;
                                        }
                                        if($row['ProductType']['id']==3){
                                            if(!empty($row['TransportBillDetailRides']['start_date'])){

                                                $totalName = $totalName.' - '.date_format(date_create($row['TransportBillDetailRides']['start_date']),"d/m/Y H:i:s");
                                            }
                                            if(!empty($row['TransportBillDetailRides']['nb_hours'])){
                                                $totalName = $totalName.' - '.$row['TransportBillDetailRides']['nb_hours'].' H ';
                                            }

                                        }

                                        $nestedData[] = $totalName . '</span>';

                                    } else {


                                        $productName = '<span>' . $row['Product']['name']  ;
                                        $productInputFactors ='';
                                        $productSelectFactors ='';
                                        if(!empty($transportBillDetailRideInputFactors)){
                                            foreach ($transportBillDetailRideInputFactors as $transportBillDetailRideFactor){
                                                $productInputFactors =  $transportBillDetailRideFactor['Factor']['name'] . ' : ' .$transportBillDetailRideFactor['TransportBillDetailRideFactor']['factor_value']. ' - ';
                                            }
                                        }
                                        if(!empty($transportBillDetailRideSelectFactors)){
                                            foreach ($transportBillDetailRideSelectFactors as $transportBillDetailRideFactor){
                                                $productSelectFactors =  $transportBillDetailRideFactor['Factor']['name'] . ' : ' .$transportBillDetailRideFactor['Factor']['options']. ' - ';
                                            }
                                        }
                                        $totalName = $productName ;
                                        if(!empty($productInputFactors)){
                                            $totalName = $totalName.' - '.$productInputFactors ;
                                        }
                                        if(!empty($productSelectFactors)){
                                            $totalName = $totalName.' - '.$productSelectFactors ;
                                        }
                                        if(!empty($row['DepartureDestination']['name'])){
                                            $totalName = $totalName.' - '.$row['Departure']['name'] ;
                                        }
                                        if(!empty($row['ArrivalDestination']['name'])){
                                            $totalName = $totalName.' - '.$row['Arrival']['name'] ;
                                        }

                                        $nestedData[] = $totalName . '</span>';



                                    }
                                } else {
                                    if ($c == 2) {
                                        if ($row['TransportBillDetailRides']['type_ride'] == 2) {
                                            $totalType = '<span>' . $row['Type']['name'];
                                            if(!empty($row['TransportBillDetailRides']['car_id'])){
                                                $totalType = $totalType .' - '.$row['Car']['immatr_def'].' - '.$row['Carmodel']['name'];
                                            }
                                            $nestedData[] = $totalType . '</span>';
                                        } else {
                                            $nestedData[] = '<span>' . $row['CarType']['name'] . '</span>';
                                        }
                                    } else {
                                        if ($useRideCategory == '2') {
                                            if ($c == 11) {
                                                switch ($row[$column[1]][$column[2]]) {
                                                    case 1:
                                                        $nestedData[] = '<span  class="label label-danger">' . __('Not validated') . "</span>";
                                                        break;
                                                    case 2:
                                                        $nestedData[] = '<span  class="label label-warning">' . __('Partially validated') . "</span>";
                                                        break;
                                                    case 3:
                                                        $nestedData[] = '<span  class="label label-success">' . __('Validated') . "</span>";
                                                        break;

                                                    default:
                                                        $nestedData[] = '<span></span>' ;

                                                        break;
                                                }
                                            } else {
                                                $nestedData[] = '<span>' . $row[$column[1]][$column[2]] . '</span>';
                                            }
                                        } else {
                                            if ($c == 10) {
                                                switch ($row[$column[1]][$column[2]]) {
                                                    case 1:
                                                        $nestedData[] = '<span  class="label label-danger">' . __('Not validated') . "</span>";
                                                        break;
                                                    case 2:
                                                        $nestedData[] = '<span  class="label label-warning">' . __('Partially validated') . "</span>";
                                                        break;
                                                    case 3:
                                                        $nestedData[] = '<span  class="label label-success">' . __('Validated') . "</span>";
                                                        break;

                                                    default:
                                                        $nestedData[] = '<span></span>' ;

                                                        break;
                                                }

                                            } else {
                                                $rowDate = $row[$column[1]][$column[2]];
                                                if ($column[4] == "date" && !empty($rowDate)) {

                                                    $rowDate = DateTime::createFromFormat('Y-m-d H:i:s', $rowDate);
                                                    $dateTimeValue = $rowDate->format('d/m/Y');
                                                    $nestedData[] = '<span>' . $dateTimeValue . '</span>';
                                                } else {
                                                    $nestedData[] = '<span>' . $row[$column[1]][$column[2]] . '</span>';
                                                }
                                            }

                                        }
                                    }
                                }

                                break;

                            case 'viewDetail':

                                if ($c == 1) {
                                    if ($row['TransportBillDetailRides']['lot_id'] == 1) {
                                        if ($row['TransportBillDetailRides']['type_ride'] == 2) {
                                            $nestedData[] = '<span >' . $row['Departure']['name'] . ' - ' . $row['Arrival']['name'] . ' - ' . $row['Type']['name'] . '</span>';
                                        } else {
                                            $nestedData[] = '<span >' . $row['DepartureDestination']['name'] . ' - ' . $row['ArrivalDestination']['name'] . ' - ' . $row['CarType']['name'] . '</span>';
                                        }
                                    } else {
                                        $nestedData[] = '<span>' . $row['Product']['name'] . '</span>';
                                    }

                                } else {
                                    $carSubcontracting = $row['SheetRide']['car_subcontracting'];
                                    if ($c == 8) {

                                        if ($carSubcontracting == 2) {
                                            $param = $this->Parameter->getCodesParameterVal('name_car');
                                            if($param == 1){
                                                $nestedData[] = '<span>' . $row[$column[1]][$column[2]] . '</span>';
                                            }else {
                                                $nestedData[] = '<span>' . $row['Car']['immatr_def'] .' '.$row['Carmodel']['name'] . '</span>';
                                            }
                                        } else {
                                            $nestedData[] = '<span>' . $row['SheetRide']['car_name'] . '</span>';
                                        }
                                    } else {
                                        if ($c == 9) {
                                            if ($carSubcontracting == 2) {
                                                $nestedData[] = '<span>' . $row[$column[1]][$column[2]] . '</span>';
                                            } else {
                                                $nestedData[] = '<span>' . $row['SheetRide']['customer_name'] . '</span>';
                                            }
                                        } else {

                                            if ($c == 13 && $type == TransportBillTypesEnum::pre_invoice) {
                                                if (($row['TransportBillDetailRides']['approved'] == '4')
                                                    || ($row['TransportBillDetailRides']['approved'] == '0')) {
                                                    $nestedData[] = '<input type="hidden" name="data[TransportBillDetailRides][' . $i . '][id]" id="missionId' . $i . '" value="' . $id . '"><input type="checkbox" class="approve" name="data[TransportBillDetailRides][' . $i . '][approved]" value="' . $id . '">';

                                                } else {
                                                    $nestedData[] = '<input type="hidden" name="data[TransportBillDetailRides][' . $i . '][id]" id="missionId' . $i . '" value="' . $id . '"><input checked type="checkbox" class="approve" name="data[TransportBillDetailRides][' . $i . '][approved]" value="' . $id . '">';

                                                }


                                            } else {
                                                $rowDate = $row[$column[1]][$column[2]];
                                                if ($column[4] == "date" && !empty($rowDate)) {

                                                    $rowDate = DateTime::createFromFormat('Y-m-d H:i:s', $rowDate);
                                                    $dateTimeValue = $rowDate->format('d/m/Y');
                                                    $nestedData[] = '<span>' . $dateTimeValue . '</span>';
                                                } else {
                                                    $nestedData[] = '<span>' . $row[$column[1]][$column[2]] . '</span>';
                                                }
                                            }
                                        }
                                    }
                                }

                                break;
                        }

                        break;
                }

                // $alertName = $row[$tableName][$itemName[0]];
                $deleteLink = "";
                switch ($tableName) {

                    case 'TransportBill':
                        $profileId = $this->Auth->user('profile_id');
                        $roleId = $this->Auth->user('role_id');
                        $reportingChoosed = $this->Session->read('reportingChoosed');
                        $printLink ='';
                        switch ($type) {
                            case TransportBillTypesEnum::quote_request:
                                if (($profileId == ProfilesEnum::client)) {
                                    $link = "<div class='btn-group'>
                                        <a data-toggle='dropdown' class='btn btn-info' style='height: 31px;'>
                                            <i class='fa fa-list fa-inverse'></i>
                                        </a>
                                        <button href='#' data-toggle='dropdown' class='btn btn-info dropdown-toggle share' aria-expanded='true'>
                                            <span class='caret'></span>
                                        </button>
                                        <ul class='dropdown-menu' style='min-width: 70px;'>
                                            <li class='view-link' title='" . __('View') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'view', $type,
                                            $id)) . "'  class='btn btn-success'><i class='fa fa-eye'></i></a>                                            
												</li>
                                            <li class='edit-link' title='" . __('Edit') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'edit', $type,
                                            $id)) . "' class='btn btn-primary'><i class='fa fa-edit'></i></a></li>
                                        </ul>
                                    </div>";

                                } else {
                                    $link = "<div class='btn-group'>
                                        <a data-toggle='dropdown' class='btn btn-info' style='height: 31px;'>
                                            <i class='fa fa-list fa-inverse'></i>
                                        </a>
                                        <button href='#' data-toggle='dropdown' class='btn btn-info dropdown-toggle share' aria-expanded='true'>
                                            <span class='caret'></span>
                                        </button>
                                        <ul class='dropdown-menu' style='min-width: 70px;'>
                                            <li class='view-link' title='" . __('View') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'view', $type,
                                            $id)) . "'  class='btn btn-success'><i class='fa fa-eye'></i></a>                                            
												</li>
                                            <li class='edit-link' title='" . __('Edit') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'editRequestQuotation',
                                            $id)) . "' class='btn btn-primary'><i class='fa fa-edit'></i></a></li>
                                        </ul>
                                    </div>";
                                }
                                break;
                            case TransportBillTypesEnum::quote:
                                if (($profileId == ProfilesEnum::client)) {
                                    $link = "<div class='btn-group'>
                                        <a data-toggle='dropdown' class='btn btn-info' style='height: 31px;'>
                                            <i class='fa fa-list fa-inverse'></i>
                                        </a>
                                        <button href='#' data-toggle='dropdown' class='btn btn-info dropdown-toggle share' aria-expanded='true'>
                                            <span class='caret'></span>
                                        </button>
                                        <ul class='dropdown-menu' style='min-width: 70px;'>
                                            <li class='view-link' title='" . __('View') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'view', $type,
                                            $id)) . "'  class='btn btn-success'><i class='fa fa-eye'></i></a>                                            
												</li>
                                            <li class='edit-link' title='" . __('Edit') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'edit', $type,
                                            $id)) . "' class='btn btn-primary'><i class='fa fa-edit'></i></a></li>
                                        </ul>
                                    </div>";

                                } else {
                                    if ($row['TransportBill']['locked'] == 1) {
                                        $lockLink = "<li class='unlock-link' title='" . __('Unlock') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'unlock', $type,
                                                $id)) . "' class='btn btn-purple'><i class='fa fa-lock'></i></a></li>";
                                    } else {
                                        $lockLink = "<li class='lock-link' title='" . __('Lock') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'lock', $type,
                                                $id)) . "' class='btn btn-purple'><i class='fa fa-unlock'></i></a></li>";
                                    }
                                    $printQuote = $this->AccessPermission->getPermissionWithParams(SectionsEnum::devis,
                                        ActionsEnum::printing, $profileId, $roleId);

                                    if ($printQuote == 1) {

                                    switch ($reportingChoosed) {
                                        case 1:
                                            $printLink = " <li class='edit-link' title='" . __('Print') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'print_facture', 'ext' => 'pdf',
                                                    $id, $type)) . "' class='btn btn-warning'><i class='fa fa-print'></i></a></li>";
                                            break;
                                        case 2 :

                                            break;
                                        case 3 :
                                            $informationJasperReport = $this->Session->read('informationJasperReport');
                                            $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                            $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                            $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];
                                            $link = $reportsPathJasper . '/transport_bills.pdf?j_username=' . $usernameJasper . '&j_password=' . $passwordJasper . '&id=' . $id;
                                            $printLink = " <li class='edit-link' title='" . __('Print') . "'>
                                                <a href='" . $link . "' class='btn btn-warning'><i class='fa fa-print'></i></a></li>";
                                            break;
                                    }
                                }

                                    if (!empty($row['Supplier']['email'])) {
                                        $msg = 'Bonjour, ';
                                        if (!empty($row['Supplier']['contact'])) {
                                            $msg = $msg . $row['Supplier']['contact'];
                                        }
                                        $msg .= "%0D%0A";
                                        $msg .= 'Ci-joint votre devis numero ' . $row['TransportBill']['reference'];

                                        $mail = $row['Supplier']['email'];

                                        $emailLink = "<li class='parameter-mail-link' title='" . __('Parameter mail') . "'>
                                                <a class='btn btn-pink'
                                                               href='mailto:'. $mail ' &body='echo $msg; ?'
                                                               onclick='piece_pdf();'>
                                                                <i class='fa  fa-envelope-o m-r-5'> </i>
                                                            </a><li>";
                                    } else {
                                        $msg = 'Bonjour, ';
                                        if (!empty($row['Supplier']['contact'])) {
                                            $msg = $msg . $row['Supplier']['contact'];
                                        }
                                        $msg .= "%0D%0A";
                                        $msg .= 'Ci-joint votre devis numero ' . $row['TransportBill']['reference'];
                                        $emailLink = "<li class='parameter-mail-link' title='" . __('Parameter mail') . "'>
                                               <a class='btn btn-pink '
                                                               href='mailto: &body= .  $msg; '
                                                               onclick='piece_pdf();'>
                                                                <i class='fa  fa-envelope-o m-r-5'
                                                                   title='Parametre mail'> </i>
                                                            </a><li>";
                                    }

                                    $link = "<div class='btn-group'>
                                        <a data-toggle='dropdown' class='btn btn-info' style='height: 31px;'>
                                            <i class='fa fa-list fa-inverse'></i>
                                        </a>
                                        <button href='#' data-toggle='dropdown' class='btn btn-info dropdown-toggle share' aria-expanded='true'>
                                            <span class='caret'></span>
                                        </button>
                                        <ul class='dropdown-menu' style='min-width: 70px;'>
                                            <li class='view-link' title='" . __('View') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'view', $type,
                                            $id)) . "'  class='btn btn-success'><i class='fa fa-eye'></i></a>                                            
												</li>
                                            <li class='edit-link' title='" . __('Edit') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'edit', $type,
                                            $id)) . "' class='btn btn-primary'><i class='fa fa-edit'></i></a></li>
                                            <li class='edit-link' title='" . __('Dissociate') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'dissociate', $type,
                                            $id)) . "' class='btn btn-inverse'><i class='fa fa-unlink'></i></a></li>  
                                            <li class='duplicate-link' title='" . __('Duplicate') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'duplicate_relance', 3, $type,
                                            $id)) . "' class='btn btn-info'><i class='fa fa-copy m-r-5'></i></a></li> 
                                                <li class='revive-link' title='" . __('Revive') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'sendMail', $type,
                                            $id, 1)) . "' class='btn btn-info'><i class='fa fa-refresh m-r-5'></i></a></li> 
                                                <li class='mail-link' title='" . __('Send email') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'sendMail', $type,
                                            $id, 0)) . "' class='btn btn-purple'><i class='fa fa-envelope m-r-5'></i></a></li>  
                                               
                                                " . $emailLink . $printLink . $lockLink . "
                                        </ul>
                                    </div>";
                                }
                                break;

                            case TransportBillTypesEnum::order:
                                if (($profileId == ProfilesEnum::client)) {
                                    $link = "<div class='btn-group'>
                                        <a data-toggle='dropdown' class='btn btn-info' style='height: 31px;'>
                                            <i class='fa fa-list fa-inverse'></i>
                                        </a>
                                        <button href='#' data-toggle='dropdown' class='btn btn-info dropdown-toggle share' aria-expanded='true'>
                                            <span class='caret'></span>
                                        </button>
                                        <ul class='dropdown-menu' style='min-width: 70px;'>
                                            <li class='view-link' title='" . __('View') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'view', $type,
                                            $id)) . "'  class='btn btn-success'><i class='fa fa-eye'></i></a>                                            
												</li>
                                            <li class='edit-link' title='" . __('Edit') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'edit', $type,
                                            $id)) . "' class='btn btn-primary'><i class='fa fa-edit'></i></a></li>
                                              <li class='mail-link' title='" . __('Send email') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'sendMail', $type,
                                            $id, 0)) . "' class='btn btn-purple'><i class='fa fa-envelope m-r-5'></i></a></li>
                                        </ul>
                                    </div>";

                                } else {
                                    if ($row['TransportBill']['locked'] == 1) {
                                        $lockLink = "<li class='unlock-link' title='" . __('Unlock') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'unlock', $type,
                                                $id)) . "' class='btn btn-purple'><i class='fa fa-lock'></i></a></li>";
                                    } else {
                                        $lockLink = "<li class='lock-link' title='" . __('Lock') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'lock', $type,
                                                $id)) . "' class='btn btn-purple'><i class='fa fa-unlock'></i></a></li>";
                                    }

                                    $printOrder = $this->AccessPermission->getPermissionWithParams(SectionsEnum::commande_client,
                                        ActionsEnum::printing, $profileId, $roleId);

                                    if($printOrder == 1) {
                                        $printLink ='';
                                        switch ($reportingChoosed) {
                                            case 1:
                                                $printLink = " <li class='edit-link' title='" . __('Print') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'print_facture', 'ext' => 'pdf',
                                                        $id, $type)) . "' class='btn btn-warning' target='_blank'><i class='fa fa-print'></i></a></li>";
                                                break;
                                            case 2 :

                                                break;
                                            case 3 :
                                                $informationJasperReport = $this->Session->read('informationJasperReport');
                                                $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                                $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                                $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];
                                                $link = $reportsPathJasper . '/transport_bills.pdf?j_username=' . $usernameJasper . '&j_password=' . $passwordJasper . '&id=' . $id;
                                                $printLink = " <li class='edit-link' title='" . __('Print') . "'>
                                                <a href='" . $link . "' class='btn btn-warning'><i class='fa fa-print'></i></a></li>";
                                                break;
                                        }
                                    }
                                    $link = "<div class='btn-group'>
                                        <a data-toggle='dropdown' class='btn btn-info' style='height: 31px;'>
                                            <i class='fa fa-list fa-inverse'></i>
                                        </a>
                                        <button href='#' data-toggle='dropdown' class='btn btn-info dropdown-toggle share' aria-expanded='true'>
                                            <span class='caret'></span>
                                        </button>
                                        <ul class='dropdown-menu' style='min-width: 70px;'>
                                            <li class='view-link' title='" . __('View') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'view', $type,
                                            $id)) . "'  class='btn btn-success'><i class='fa fa-eye'></i></a>                                            
												</li>
                                            <li class='edit-link' title='" . __('Edit') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'edit', $type,
                                            $id)) . "' class='btn btn-primary'><i class='fa fa-edit'></i></a></li>
                                              <li class='mail-link' title='" . __('Send email') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'sendMail', $type,
                                            $id, 0)) . "' class='btn btn-purple'><i class='fa fa-envelope m-r-5'></i></a></li>
                                                  <li class='edit-link' title='" . __('Dissociate') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'dissociate', $type,
                                            $id)) . "' class='btn btn-inverse'><i class='fa fa-unlink'></i></a></li>    
                                                " . $printLink . $lockLink . "
                                        </ul>
                                    </div>";
                                }
                                break;
                            case TransportBillTypesEnum::pre_invoice:
                                if (($profileId == ProfilesEnum::client)) {
                                    $link = "<div class='btn-group'>
                                        <a data-toggle='dropdown' class='btn btn-info' style='height: 31px;'>
                                            <i class='fa fa-list fa-inverse'></i>
                                        </a>
                                        <button href='#' data-toggle='dropdown' class='btn btn-info dropdown-toggle share' aria-expanded='true'>
                                            <span class='caret'></span>
                                        </button>
                                        <ul class='dropdown-menu' style='min-width: 70px;'>
                                            <li class='view-link' title='" . __('View') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'view', $type,
                                            $id)) . "'  class='btn btn-success'><i class='fa fa-eye'></i></a>                                            
												</li>
                                            <li class='edit-link' title='" . __('Edit') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'edit', $type,
                                            $id)) . "' class='btn btn-primary'><i class='fa fa-edit'></i></a></li>
                                             </ul>
                                    </div>";

                                } else {
                                    if ($row['TransportBill']['locked'] == 1) {
                                        $lockLink = "<li class='unlock-link' title='" . __('Unlock') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'unlock', $type,
                                                $id)) . "' class='btn btn-purple'><i class='fa fa-lock'></i></a></li>";
                                    } else {
                                        $lockLink = "<li class='lock-link' title='" . __('Lock') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'lock', $type,
                                                $id)) . "' class='btn btn-purple'><i class='fa fa-unlock'></i></a></li>";
                                    }

                                    $printPreinvoice = $this->AccessPermission->getPermissionWithParams(SectionsEnum::prefacture,
                                        ActionsEnum::printing, $profileId, $roleId);

                                    if ($printPreinvoice == 1) {


                                    switch ($reportingChoosed) {
                                        case 1:
                                            $printLink = " <li class='edit-link' title='" . __('Print') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'print_facture', 'ext' => 'pdf',
                                                    $id, $type)) . "' class='btn btn-warning' target='_blank'><i class='fa fa-print'></i></a></li>";
                                            break;
                                        case 2 :

                                            break;
                                        case 3 :
                                            $informationJasperReport = $this->Session->read('informationJasperReport');
                                            $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                            $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                            $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];
                                            $link = $reportsPathJasper . '/transport_bills.pdf?j_username=' . $usernameJasper . '&j_password=' . $passwordJasper . '&id=' . $id;

                                            $printLink = " <li class='edit-link' title='" . __('Print') . "'>
                                                <a href='" . $link . "' class='btn btn-warning'><i class='fa fa-print'></i></a></li>";
                                            break;
                                    }

                                }

                                    $link = "<div class='btn-group'>
                                        <a data-toggle='dropdown' class='btn btn-info' style='height: 31px;'>
                                            <i class='fa fa-list fa-inverse'></i>
                                        </a>
                                        <button href='#' data-toggle='dropdown' class='btn btn-info dropdown-toggle share' aria-expanded='true'>
                                            <span class='caret'></span>
                                        </button>
                                        <ul class='dropdown-menu' style='min-width: 70px;'>
                                            <li class='view-link' title='" . __('View') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'view', $type,
                                            $id)) . "'  class='btn btn-success'><i class='fa fa-eye'></i></a>                                            
												</li>
                                            <li class='edit-link' title='" . __('Edit') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'edit', $type,
                                            $id)) . "' class='btn btn-primary'><i class='fa fa-edit'></i></a></li>
                                              <li class='mail-link' title='" . __('Send email') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'sendMail', $type,
                                            $id, 0)) . "' class='btn btn-purple'><i class='fa fa-envelope m-r-5'></i></a></li>
                                            <li class='edit-link' title='" . __('Dissociate') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'dissociate', $type,
                                            $id)) . "' class='btn btn-inverse'><i class='fa fa-unlink'></i></a></li>    
                                                " . $printLink . $lockLink . "
                                        </ul>
                                    </div>";

                                }
                                break;

                            case TransportBillTypesEnum::invoice:
                            case TransportBillTypesEnum::credit_note:
                                if (($profileId == ProfilesEnum::client)) {
                                    $link = "<div class='btn-group'>
                                        <a data-toggle='dropdown' class='btn btn-info' style='height: 31px;'>
                                            <i class='fa fa-list fa-inverse'></i>
                                        </a>
                                        <button href='#' data-toggle='dropdown' class='btn btn-info dropdown-toggle share' aria-expanded='true'>
                                            <span class='caret'></span>
                                        </button>
                                        <ul class='dropdown-menu' style='min-width: 70px;'>
                                            <li class='view-link' title='" . __('View') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'view', $type,
                                            $id)) . "'  class='btn btn-success'><i class='fa fa-eye'></i></a>                                            
												</li>
                                            <li class='edit-link' title='" . __('Edit') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'edit', $type,
                                            $id)) . "' class='btn btn-primary'><i class='fa fa-edit'></i></a></li>
                                              </ul>
                                    </div>";

                                } else {
                                    if ($row['TransportBill']['locked'] == 1) {
                                        $lockLink = "<li class='unlock-link' title='" . __('Unlock') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'unlock', $type,
                                                $id)) . "' class='btn btn-purple'><i class='fa fa-lock'></i></a></li>";
                                    } else {
                                        $lockLink = "<li class='lock-link' title='" . __('Lock') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'lock', $type,
                                                $id)) . "' class='btn btn-purple'><i class='fa fa-unlock'></i></a></li>";
                                    }
                                    if($type ==TransportBillTypesEnum::invoice) {
                                        $printInvoice = $this->AccessPermission->getPermissionWithParams(SectionsEnum::facture,
                                            ActionsEnum::printing, $profileId, $roleId);

                                        if($printInvoice==1){
                                            switch ($reportingChoosed) {
                                                case 1:
                                                    $printLink = " <li class='edit-link' title='" . __('Print invoice') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'print_facture','ext' => 'pdf',
                                                            $id ,$type)) . "' class='btn btn-warning' target='_blank'><i class='fa fa-print'></i></a></li>
                                                            <li class='edit-link' title='" . __('Print invoice with payment') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'printInvoiceWithPayment','ext' => 'pdf',
                                                            $id ,$type)) . "' class='btn btn-warning' target='_blank'><i class='fa fa-print'></i></a></li>";
                                                    break;
                                                case 2 :

                                                    break;
                                                case 3 :
                                                    $informationJasperReport = $this->Session->read('informationJasperReport');
                                                    $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                                    $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                                    $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];
                                                    $link = $reportsPathJasper . '/transport_bills.pdf?j_username=' . $usernameJasper . '&j_password=' . $passwordJasper . '&id=' . $id;

                                                    $printLink = " <li class='edit-link' title='" . __('Print') . "'>
                                                <a href='" . $link . "' class='btn btn-warning'><i class='fa fa-print'></i></a></li>";
                                                    break;
                                            }
                                        }
                                    }else {
                                        $printCreditNote = $this->AccessPermission->getPermissionWithParams(SectionsEnum::avoir_vente,
                                            ActionsEnum::printing, $profileId, $roleId);

                                        if($printCreditNote==1){
                                            switch ($reportingChoosed) {
                                                case 1:
                                                    $printLink = " <li class='edit-link' title='" . __('Print') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'print_facture','ext' => 'pdf',
                                                            $id ,$type)) . "' class='btn btn-warning' target='_blank'><i class='fa fa-print'></i></a></li>";
                                                    break;
                                                case 2 :

                                                    break;
                                                case 3 :
                                                    $informationJasperReport = $this->Session->read('informationJasperReport');
                                                    $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                                    $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                                    $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];
                                                    $link = $reportsPathJasper . '/transport_bills.pdf?j_username=' . $usernameJasper . '&j_password=' . $passwordJasper . '&id=' . $id;

                                                    $printLink = " <li class='edit-link' title='" . __('Print') . "'>
                                                <a href='" . $link . "' class='btn btn-warning'><i class='fa fa-print'></i></a></li>";
                                                    break;
                                            }
                                        }
                                    }



                                    $link = "<div class='btn-group'>
                                        <a data-toggle='dropdown' class='btn btn-info' style='height: 31px;'>
                                            <i class='fa fa-list fa-inverse'></i>
                                        </a>
                                        <button href='#' data-toggle='dropdown' class='btn btn-info dropdown-toggle share' aria-expanded='true'>
                                            <span class='caret'></span>
                                        </button>
                                        <ul class='dropdown-menu' style='min-width: 70px;'>
                                            <li class='view-link' title='" . __('View') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'view', $type,
                                            $id)) . "'  class='btn btn-success'><i class='fa fa-eye'></i></a>                                            
												</li>
                                            <li class='edit-link' title='" . __('Edit') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'edit', $type,
                                            $id)) . "' class='btn btn-primary'><i class='fa fa-edit'></i></a></li>" . $printLink . $lockLink . "
                                          <li class='mail-link' title='" . __('Send email') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'sendMail', $type,
                                            $id, 0)) . "' class='btn btn-purple'><i class='fa fa-envelope m-r-5'></i></a></li>
                                        </ul>
                                    </div>";

                                }
                                break;
                        }
                        break;
                    case 'SheetRide'  :

                        switch ($action) {
                            case 'index' ;
                            case 'sheetRidesWithConsumption' ;
                                $isAgent = $this->Session->read('isAgent');
                                $reportingChoosed = $this->Session->read('reportingChoosed');
                                $printLink ='';
                                $profileId = $this->Auth->user('profile_id');
                                $roleId = $this->Auth->user('role_id');
                                $printSheet = $this->AccessPermission->getPermissionWithParams(SectionsEnum::feuille_de_route,
                                ActionsEnum::printing, $profileId, $roleId);

                            if ($isAgent) {
                                    switch ($reportingChoosed) {
                                        case 1:
                                            $sheetRideWithMission = $this->Parameter->getCodesParameterVal('sheet_ride_with_mission');
                                            if($sheetRideWithMission == 1){
                                                $printLink = " <li class='edit-link' title='" . __('Print') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'view_pdf','ext' => 'pdf',
                                                        $id)) . "' class='btn btn-warning' target='_blank'><i class='fa fa-print'></i></a></li>";

                                            }else {
                                                $printLink = " <li class='edit-link' title='" . __('Print') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'view_mission','ext' => 'pdf',
                                                        $id, false)) . "' class='btn btn-warning' target='_blank'><i class='fa fa-print'></i></a></li>";

                                            }
                                              break;
                                        case 2 :
                                            $printLink = " <li class='edit-link' title='" . __('Print') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'pdfReports',
                                                    $id)) . "' class='btn btn-warning'><i class='fa fa-print'></i></a></li>";
                                            break;
                                        case 3 :
                                            $informationJasperReport = $this->Session->read('informationJasperReport');
                                            $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                            $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                            $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];

                                            if($row['SheetRide']['car_subcontracting']==1){
                                                $link = $reportsPathJasper . '/subcontracting_sheet_rides.pdf?j_username=' . $usernameJasper . '&j_password=' . $passwordJasper . '&id=' . $id;

                                            }else {
                                                $link = $reportsPathJasper . '/sheet_rides.pdf?j_username=' . $usernameJasper . '&j_password=' . $passwordJasper . '&id=' . $id;

                                            }

                                            $printLink = " <li class='edit-link' title='" . __('Print') . "'>
                                                <a href='" . $link . "' class='btn btn-warning'><i class='fa fa-print'></i></a></li>";
                                            break;
                                    }

                                    $link = "<div class='btn-group  '>
                                        <a data-toggle='dropdown' class='btn btn-info' style='height: 31px;'>
                                            <i class='fa fa-list fa-inverse'></i>
                                        </a>
                                        <button href='#' data-toggle='dropdown' class='btn btn-info dropdown-toggle share' aria-expanded='true'>
                                            <span class='caret'></span>
                                        </button>

                                        <ul class='dropdown-menu' style='min-width: 70px;'>

                                            <li class='edit-link' title='" . __('Edit') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'editAgent',
                                            $id)) . "' class='btn btn-primary'><i class='fa fa-edit'></i></a></li>" . $printLink . "
                                       
                                        </ul>
                                    </div>";
                                } else {
                                $deleteLink = '<li class="edit-link" title="' . __('Delete') . '">
                                            <form action="' . Router::url(array('controller' => $controller, 'action' => 'delete', $id)) . '" 
                                            name="post_5d10c0e5b78b6514407960" id="post_5d10c0e5b78b6514407960" 
                                            style="display:none;" method="post">
                                            <input type="hidden" name="_method" value="POST">
                                            <input type="hidden" name="data[_Token][key]" value="b1a31c1b1c20596c3032cacae510551df607253f" id="Token819305157">
                                            <div style="display:none;">
                                            <input type="hidden" name="data[_Token][fields]" value="2f47f07fb4e3330e413ede91856d223f4365daa2%3A" id="TokenFields845490155">
                                            <input type="hidden" name="data[_Token][unlocked]" value="ok" id="TokenUnlocked2022569405">
                                            </div>
                                            </form>
                                            <a href="#" class="btn btn-danger" onclick="if (confirm(&quot;\u00cates-vous s\u00fbr de vouloir supprimer ?&quot;)) { document.post_5d10c0e5b78b6514407960.submit(); } event.returnValue = false; return false;">
                                            <i class="fa fa-trash-o"></i></a></li>';
                                $printLink ='';
                                if ($printSheet == 1) {

                                switch ($reportingChoosed) {
                                    case 1:
                                        $sheetRideWithMission = $this->Parameter->getCodesParameterVal('sheet_ride_with_mission');
                                        if($sheetRideWithMission == 1){
                                            $printLink = " <li class='edit-link' title='" . __('Print') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'view_pdf', 'ext' => 'pdf',
                                                    $id)) . "' class='btn btn-warning' target='_blank'><i class='fa fa-print'></i></a></li>";

                                        }else {
                                            $printLink = " <li class='edit-link' title='" . __('Print') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'view_mission', 'ext' => 'pdf',
                                                    $id, false)) . "' class='btn btn-warning' target='_blank'><i class='fa fa-print'></i></a></li>";

                                        }
                                         break;
                                    case 2 :
                                        $printLink = " <li class='edit-link' title='" . __('Print') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'pdfReports',
                                                $id)) . "' class='btn btn-warning'><i class='fa fa-print'></i></a></li>";
                                        break;
                                    case 3 :
                                        $informationJasperReport = $this->Session->read('informationJasperReport');
                                        $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                        $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                        $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];
                                        if ($row['SheetRide']['car_subcontracting'] == 1) {
                                            $link = $reportsPathJasper . '/subcontracting_sheet_rides.pdf?j_username=' . $usernameJasper . '&j_password=' . $passwordJasper . '&id=' . $id;

                                        } else {
                                            $link = $reportsPathJasper . '/sheet_rides.pdf?j_username=' . $usernameJasper . '&j_password=' . $passwordJasper . '&id=' . $id;

                                        }
                                        $printLink = " <li class='edit-link' title='" . __('Print') . "'>
                                                <a href='" . $link . "' class='btn btn-warning'><i class='fa fa-print'></i></a></li>";
                                        break;
                                }
                            }
                                    $link = "<div class='btn-group  '>
                                        <a data-toggle='dropdown' class='btn btn-info' style='height: 31px;'>
                                            <i class='fa fa-list fa-inverse'></i>
                                        </a>
                                        <button href='#' data-toggle='dropdown' class='btn btn-info dropdown-toggle share' aria-expanded='true'>
                                            <span class='caret'></span>
                                        </button>

                                        <ul class='dropdown-menu' style='min-width: 70px;'>

                                            <li class='view-link' title='" . __('View') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'view',
                                            $id)) . "'  class='btn btn-success'><i class='fa fa-eye'></i></a>                                            
												</li> 
												
												<li class='localisation-link' title='" . __('Localisation') . "'>
                                                <a href='" . Router::url(array('controller' => 'cars', 'action' => 'ViewPosition',
                                            $carId)) . "'  class='btn btn-inverse'><i class='fa fa-map-marker'></i></a>                                            
												</li>
												<li class='duplicate-link' title='" . __('Duplicate') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'duplicate',
                                            $id)) . "'  class='btn btn-info'><i class='fa fa-unlink'></i></a>                                            
												</li>	
												<li class='add-link' title='" . __('Add mission') . "'>
                                                <a href='" . Router::url(array('controller' => 'SheetRideDetailRides', 'action' => 'add',
                                            $id)) . "'  class='btn btn-success'><i class='fa fa-plus'></i></a>                                            
												</li>
                                         
                                            <li class='edit-link' title='" . __('Edit') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'edit',
                                            $id)) . "' class='btn btn-primary'><i class='fa fa-edit'></i></a></li>
                                            <li>" . $printLink . "</li>
                                        </ul>
                                    </div>";
                                }

                                break;
                            case 'getSheetsToEdit'    :
                                $link = "<a href='" . Router::url(array('controller' => $controller, 'action' => 'edit',
                                        $id, $transportBillDetailRideId, $observationId)) . "' class='btn btn-primary'><i class='fa fa-edit'></i></a>";
                                break;
                        }

                        break;
                    case 'SheetRideDetailRides':
                        switch ($action) {
                            case 'index':

                                $link = "<div class='btn-group  '>
                                        <a data-toggle='dropdown' class='btn btn-info' style='height: 31px;'>
                                            <i class='fa fa-list fa-inverse'></i>
                                        </a>
                                        <button href='#' data-toggle='dropdown' class='btn btn-info dropdown-toggle share' aria-expanded='true'>
                                            <span class='caret'></span>
                                        </button>

                                        <ul class='dropdown-menu' style='min-width: 70px;'>

                                            <li class='localisation-link' title='" . __('Localisation') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'ViewPosition',
                                        $id)) . "'  class='btn btn-inverse'><i class='fa fa-map-marker'></i></a>                                            
												</li> 
												
												<li class='view-link' title='" . __('Print') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'view_mission',
                                        $id, 'ext' => 'pdf')) . "'  class='btn btn-warning'><i class='fa fa-print'></i></a>                                            
												</li>
                                         
                                            <li class='edit-link' title='" . __('Synchronize') . "'>
                                                <a href='" . Router::url(array('controller' => $controller, 'action' => 'synchronisationMission',
                                        $id)) . "' class='btn btn-primary'><i class='fa fa-refresh'></i></a></li>
                                           
                                        </ul>
                                    </div>";

                                break;
                        }
                        break;
                    Default :
                }
                $c++;
            }
            $nestedData[] = $link;
            $nestedData[] = $id;
            $data[] = $nestedData;
            $i++;
        }
        if($tableName =='TransportBill' && $action =='index') {
            $totals = $this->TransportBill->getTotals($cond);
        }else {
            $totals =0;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']),
            'requestData' => $requestData['columns'],
            "conditions" => $generalConditions,
            "type" => $type,
            "search" => $search,
            'test'=>$orderValue,
            'query' => $SQL,
            'totals' => $totals,
            'columns' => $columns,
            "action" => $action,
            "recordsTotal" => intval($totalData),
            "pageLength" => intval($length),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "autoWidth" => boolval(false),
        );
        echo json_encode($json_data);
        exit;
    }

    public function setMissionsDates($results)
    {
        if (!empty($results)){
            if (isset($results[0]['TransportBillDetailedRides'])){
                $index = 'TransportBillDetailedRides';
            }else{
                $index = 'TransportBillDetailRides';
            }
                foreach ($results as $key => $value){
                    $programingDate = $value[$index]['programming_date'];
                    $chargingTime = $value[$index]['charging_time'];
                    $unloadingDate = $value[$index]['unloading_date'];
                    $programingDate = DateTime::createFromFormat('Y-m-d',
                        $programingDate);
                    $chargingTime = DateTime::createFromFormat('H:i:s',
                        $chargingTime);
                    $unloadingDate = DateTime::createFromFormat('Y-m-d H:i:s',
                        $unloadingDate);
                    if($programingDate instanceof DateTime){
                        $programingDate = $programingDate->format('d/m/Y');
                    }else{
                        $programingDate = '';
                    }
                    if($chargingTime instanceof DateTime){
                        $chargingTime = $chargingTime->format('H:i');
                    }else{
                        $chargingTime = '';
                    }
                    if($unloadingDate instanceof DateTime){
                        $unloadingDate = $unloadingDate->format('d/m/Y H:i');
                    }else{
                        $unloadingDate = '';
                    }
                    $results[$key][$index]['programming_date'] =
                        $programingDate.' '.$chargingTime.'<br>'.$unloadingDate;
                }
        }
        return $results;
    }

    public function setOrderTypeAndMissionTypeValues($results)
    {
        foreach ($results as $key => $value){
            switch ($value['TransportBillDetailedRides']['delivery_with_return']) {
                case 1:
                    $results[$key]['TransportBillDetailedRides']['delivery_with_return'] = __('Simple delivery');
                    break;
                case 2:
                    $results[$key]['TransportBillDetailedRides']['delivery_with_return'] = __('Simple return');
                    break;
                case 3:
                    $results[$key]['TransportBillDetailedRides']['delivery_with_return'] = __('Delivery / Return');
                    break;
                default;
            }
            switch ($value['TransportBill']['order_type']) {
                case 1:
                    $results[$key]['TransportBill']['order_type'] = __('Order with invoice');
                    break;
                case 2:
                    $results[$key]['TransportBill']['order_type'] = __('Order payment cash');
                    break;
                default;
            }
        }
        return $results;
    }


    public function getProfileUser()
    {
        $profileId = $this->Auth->user('profile_id');

        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        $this->Session->write("profileId", $profileId);
    }

    /*
     * Set language variable session
     * @param null
     *
     * @return null
     */
    public function setUserLanguage()
    {
        $language_user = $this->User->find('first', array(
                'recursive' => -1,
                'fields' => array('User.language_id'),
                'conditions' => array('User.id' => $this->Auth->user('id'))
            )
        );
        if ($language_user['User']['language_id'] != null) {
            $language = $this->Language->find('first', array(
                'recursive' => -1,
                'conditions' => array('id' => (int)$language_user['User']['language_id'])
            ));

            $this->Session->write('Config.language', $language['Language']['abr']);

        }
    }

    public function blackhole($type)
    {
        // gestions des erreurs.
    }

    public function verifySuperAdministrator($userId = null)
    {
        $authenticatedUserId = $this->Auth->user('id');
        if (!empty($userId) && $authenticatedUserId == $userId ){
            return true;
        }else{
            if ($this->Auth->user('role_id') != 3) {
                $this->Flash->error(__("You don't have permission to do this action."));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
            }
        }
    }

    public function isSuperAdmin()
    {
        if ($this->Auth->user('role_id') == 3) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get next code (auto incremented) depending on model
     * @param string $model model's name
     * @param string $name rubric's name
     *
     * @return int next code
     */
    public function getNextCode($model, $name)
    {
        // get rubric's codeAuto and length of code


        $codeParameter = $this->Parameter->getCodeTypeAndSize($name);

        // if rubric's code is auto
        if (!empty ($codeParameter)) {
            // Get length of code
            $size = $codeParameter['Parameter']['sizes_' . $name];
            // get rubric's last code
            $lastCode = '';
            switch ($name) {
                case 'car' :
                    $allCodes = $this->Car->getNotNullCodes();
                    if (!empty($allCodes)) {
                        foreach ($allCodes as $allCode) {

                            $allIntCodes[] = (int)$allCode[$model]['code'];
                        }

                        $lastCode = max($allIntCodes);
                    }
                    break;
                case 'conductor' :
                    $allCodes = $this->$model->find('all', array(
                        'order' => array($model . '.code' => ' DESC', $model . '.id' => 'DESC'),
                        'conditions' => array($model . '.code !=' => null, 'CustomerCategory.type ' => 0),
                        'recursive' => -1,
                        'fields' => array('code'),
                        'joins' => array(

                            array(
                                'table' => 'customer_categories',
                                'type' => 'left',
                                'alias' => 'CustomerCategory',
                                'conditions' => array('Customer.customer_category_id = CustomerCategory.id')
                            )
                        )
                    ));
                    if (!empty($allCodes)) {
                        foreach ($allCodes as $allCode) {

                            $allIntCodes[] = (int)$allCode[$model]['code'];
                        }

                        $lastCode = max($allIntCodes);
                    }
                    break;


            }

            if (!empty ($lastCode)) {


                if ($lastCode == null) {
                    $lastCode = 0;
                }
                $nextCode = (int)$lastCode + 1;
                $sizeCode = strlen((string)$nextCode);
                // Returned next code must have the same length that length defined in parameters
                if ($size > $sizeCode) {
                    $size = $size - $sizeCode;
                    for ($i = 1; $i <= $size; $i++) {
                        $nextCode = '0' . $nextCode;

                    }
                }

                return $nextCode;
            } else {
                $nextCode = 1;
                $sizeCode = strlen((string)$nextCode);
                if ($size > $sizeCode) {
                    $size = $size - $sizeCode;
                    for ($i = 1; $i <= $size; $i++) {
                        $nextCode = '0' . $nextCode;

                    }
                }
                return $nextCode;
            }

        } else {
            return 0;
        }


    }

    /**
     * Get next reference (auto incremented) depending on model
     * @param $model
     * @param $type
     * @return int|string $nextReference
     */
    public function getNextTransportReference($type = null)
    {
        $nextReference = null;
        $referenceParameterFields = $this->getReferenceParameterFields($type);
        if(count($referenceParameterFields)>1){
        $nextReference = $this->generateNextReference ($referenceParameterFields);
        while ($this->existReference($nextReference, $type)) {
            $this->Parameter->setNextTransportReferenceNumber($type);
            $referenceParameterFields = $this->getReferenceParameterFields($type);
            $nextReference = $this->generateNextReference ($referenceParameterFields);
        }
        }
       return $nextReference;
    }

    public function getReferenceParameterFields($type = null){
        $dbBillTypeFieldName = '';
        switch ($type) {
            case TransportBillTypesEnum::quote_request :

                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_dd_auto');

                $dbBillTypeFieldName = 'demande_devis';
                break;

            case TransportBillTypesEnum::quote :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_fp_auto');
                $dbBillTypeFieldName = 'devis';
                break;

            case TransportBillTypesEnum::order :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_bc_auto');

                $dbBillTypeFieldName = 'commande';
                break;

            case TransportBillTypesEnum::sheet_ride :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_fr_auto');
                $dbBillTypeFieldName = 'feuille_route';
                break;

            case TransportBillTypesEnum::pre_invoice :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_pf_auto');
                $dbBillTypeFieldName = 'prefacture';
                break;

            case TransportBillTypesEnum::invoice :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_fa_auto');
                $dbBillTypeFieldName = 'facture';
                break;

            case TransportBillTypesEnum::credit_note :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_av_auto');
                $dbBillTypeFieldName = 'avoir_vente';
                break;

            case TransportBillTypesEnum::dispatch_slip :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_ds_auto');

                $dbBillTypeFieldName = 'bordereau_envoi';
                break;
            default :
                break;
        }
        $referenceParameterFields['dbBillTypeFieldName'] = $dbBillTypeFieldName;


        return $referenceParameterFields;
    }

    public function generateNextReference($referenceParameterFields){
        $date = Date('Y');
        if (!empty ($referenceParameterFields)) {
            $dbBillTypeFieldName = $referenceParameterFields['dbBillTypeFieldName'];
            $prefix = $referenceParameterFields['Parameter'][$dbBillTypeFieldName];
            $size = (int)$referenceParameterFields['Parameter']['reference_sizes'];
            $abbreviationLocation = $referenceParameterFields['Parameter']['abbreviation_location'];
            $nextNumber = $referenceParameterFields['Parameter']['next_reference_' . $dbBillTypeFieldName];

            $sizeNumber = strlen((int)$nextNumber);
            if ($size > $sizeNumber) {
                $size = $size - $sizeNumber;
                $nextReference = $nextNumber;
                for ($i = 1; $i <= $size; $i++) {
                    $nextReference = '0' . $nextReference;
                }

            } else {
                $nextReference = $nextNumber;
            }
            if ($referenceParameterFields['Parameter']['date_suffixe'] == 2) {
                $nextReference = $prefix . $nextReference . '/' . $date;
            } else {
                if ($abbreviationLocation == 2) {
                    $nextReference = $date . '/' . $prefix . $nextReference;
                } else {
                    $nextReference = $prefix . $date . '/' . $nextReference;
                }
            }
            return $nextReference;

        } else {
            return 0;
        }
    }
    public function existReference($nextReference, $type){
        switch ($type) {
            case TransportBillTypesEnum::quote_request ;
            case TransportBillTypesEnum::quote ;
            case TransportBillTypesEnum::order ;
            case TransportBillTypesEnum::pre_invoice ;
            case TransportBillTypesEnum::invoice ;
            case TransportBillTypesEnum::credit_note ;
                $transportBill =$this->TransportBill->find('first',

                    array('conditions'=>array('TransportBill.reference'=>$nextReference),'recursive'=>-1));

            if (!empty($transportBill)) {
                return true;
            } else {
                return false;
            }
                break;

            case TransportBillTypesEnum::sheet_ride :
                $sheetRide =$this->SheetRide->find('first',
                    array('conditions'=>array('SheetRide.reference'=>$nextReference),'recursive'=>-1));
                if (!empty($sheetRide)) {
                    return true;
                } else {
                    return false;
                }

                break;


            default :
                break;
        }

    }

    /**
     * Get next reference (auto incremented) depending on model
     * @param $model
     * @param $type
     * @return int|string $nextReference
     */
    public function getNextBillReference($type)
    {
        $date = Date('Y');
        switch ($type) {
            case BillTypesEnum::supplier_order :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_so_auto');
                $dbBillTypeFieldName = 'supplier_order';

                break;

            case BillTypesEnum::receipt :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_re_auto');
                $dbBillTypeFieldName = 'receipt';
                break;

            case BillTypesEnum::return_supplier :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_rs_auto');
                $dbBillTypeFieldName = 'return_supplier';
                break;

            case BillTypesEnum::purchase_invoice :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_pi_auto');
                $dbBillTypeFieldName = 'purchase_invoice';
                break;

            case BillTypesEnum::credit_note :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_cn_auto');
                $dbBillTypeFieldName = 'credit_note';
                break;

            case BillTypesEnum::delivery_order :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_do_auto');
                $dbBillTypeFieldName = 'delivery_order';
                break;

            case BillTypesEnum::return_customer :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_rc_auto');
                $dbBillTypeFieldName = 'return_customer';
                break;

            case BillTypesEnum::entry_order :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_eo_auto');
                $dbBillTypeFieldName = 'entry_order';
                break;

            case BillTypesEnum::exit_order :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_xo_auto');
                $dbBillTypeFieldName = 'exit_order';
                break;

            case BillTypesEnum::renvoi_order :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_ro_auto');
                $dbBillTypeFieldName = 'renvoi_order';
                break;

            case BillTypesEnum::reintegration_order :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_ri_auto');
                $dbBillTypeFieldName = 'reintegration_order';
                break;

            case BillTypesEnum::transfer_receipt :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_tr_auto');
                $dbBillTypeFieldName = 'transfer_receipt';
                break;

            case BillTypesEnum::quote :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_fp_auto');

                $dbBillTypeFieldName = 'devis';
                break;

            case BillTypesEnum::customer_order :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_bc_auto');
                $dbBillTypeFieldName = 'commande';
                break;

            case BillTypesEnum::sales_invoice :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_fa_auto');
                $dbBillTypeFieldName = 'facture';
                break;

            case BillTypesEnum::sale_credit_note :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_av_auto');
                $dbBillTypeFieldName = 'avoir_vente';
                break;

             case BillTypesEnum::product_request :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_pr_auto');
                $dbBillTypeFieldName = 'product_request';
                break;

             case BillTypesEnum::purchase_request :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_ar_auto');
                $dbBillTypeFieldName = 'purchase_request';
                break;
        }


        if (!empty ($referenceParameterFields)) {
            $prefix = $referenceParameterFields['Parameter'][$dbBillTypeFieldName];
            $size = (int)$referenceParameterFields['Parameter']['reference_bill_sizes'];
            $abbreviationLocation = $referenceParameterFields['Parameter']['abbreviation_bill_location'];
            $nextNumber = $referenceParameterFields['Parameter']['next_reference_' . $dbBillTypeFieldName];
            $sizeNumber = strlen((int)$nextNumber);
            if ($size > $sizeNumber) {
                $size = $size - $sizeNumber;
                $nextReference = $nextNumber;
                for ($i = 1; $i <= $size; $i++) {
                    $nextReference = '0' . $nextReference;
                }
            } else {
                $nextReference = $nextNumber;
            }

            if ($referenceParameterFields['Parameter']['date_suffixe'] == 2) {
                $nextReference = $prefix . $nextReference . '/' . $date;
            } else {
                if ($abbreviationLocation == 2) {
                    $nextReference = $date . '/' . $prefix . $nextReference;
                } else {
                    $nextReference = $prefix . $date . '/' . $nextReference;
                }
            }
            return $nextReference;

        } else {
            return 0;
        }
    }

    /**
     * Get next reference (auto incremented) depending on model
     * @param $model
     * @param $type
     * @return int|string $nextReference
     */
    public function getNextEventReference($type)
    {
        $date = Date('Y');
        $dbBillTypeFieldName ='';
        switch ($type) {
            case 'event' :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_auto_event');
                $dbBillTypeFieldName = 'event';
                break;

            case 'intervention_request' :
                $referenceParameterFields = $this->Parameter->getTransportBillReferenceInfos('reference_auto_intervention_request');
                $dbBillTypeFieldName = 'intervention_request';
                break;


              }


        if (!empty ($referenceParameterFields)) {
            $prefix = $referenceParameterFields['Parameter'][$dbBillTypeFieldName];
            $size = (int)$referenceParameterFields['Parameter']['reference_sizes_event'];
            $abbreviationLocation = $referenceParameterFields['Parameter']['abbreviation_location_event'];
            $nextNumber = $referenceParameterFields['Parameter']['next_reference_' . $dbBillTypeFieldName];
            $sizeNumber = strlen((int)$nextNumber);
            if ($size > $sizeNumber) {
                $size = $size - $sizeNumber;
                $nextReference = $nextNumber;
                for ($i = 1; $i <= $size; $i++) {
                    $nextReference = '0' . $nextReference;
                }
            } else {
                $nextReference = $nextNumber;
            }

            if ($referenceParameterFields['Parameter']['date_suffix_event'] == 2) {
                $nextReference = $prefix . $nextReference . '/' . $date;
            } else {
                if ($abbreviationLocation == 2) {
                    $nextReference = $date . '/' . $prefix . $nextReference;
                } else {
                    $nextReference = $prefix . $date . '/' . $nextReference;
                }
            }
            return $nextReference;

        } else {
            return 0;
        }
    }



    /**
     * Get next reference (auto incremented) depending on model
     * @param $model
     * @param $type
     * @return int|string $nextReference
     * created : 19/03/2019
     */
    public function getNextProductCode()
    {
        $referenceParameterFields = $this->Parameter->getProductCodeInfos('reference_product_auto');
        $dbBillTypeFieldName = 'product';
        if (!empty ($referenceParameterFields)) {
            $size = (int)$referenceParameterFields['Parameter']['reference_product_sizes'];
            $nextNumber = $referenceParameterFields['Parameter']['next_reference_' . $dbBillTypeFieldName];
            $sizeNumber = strlen((int)$nextNumber);
            if ($size > $sizeNumber) {
                $size = $size - $sizeNumber;
                $nextReference = $nextNumber;
                for ($i = 1; $i <= $size; $i++) {
                    $nextReference = '0' . $nextReference;
                }
            } else {
                $nextReference = $nextNumber;
            }
            return $nextReference;

        } else {
            return 0;
        }
    }

    /**
     * @param $dbFieldName
     * @return int|string
     * created : 24/03/2019
     */

    public function getNextCodeByFieldName($dbFieldName)
    {
        $codeParameterFields = $this->Parameter->getCodeInfos('reference_auto_' . $dbFieldName);
        if (!empty ($codeParameterFields)) {
            $size = (int)$codeParameterFields['Parameter']['reference_sizes_' . $dbFieldName];
            $prefix = $codeParameterFields['Parameter']['reference_' . $dbFieldName];
            $nextNumber = $codeParameterFields['Parameter']['next_reference_' . $dbFieldName];
            $sizeNumber = strlen((int)$nextNumber);
            $nextCode = '';
            if ($size > $sizeNumber) {
                $size = $size - $sizeNumber;
                $nextCode = $nextNumber;
                for ($i = 1; $i <= $size; $i++) {
                    $nextCode = '0' . $nextCode;
                }
            } else {
                $nextCode = $nextNumber;
            }
            $nextCode = $prefix . $nextCode;
            return $nextCode;
        } else {
            return 0;
        }
    }


    /**
     * Send next reference (auto incremented) depending on model
     * @param string $model model's name
     * @param string $name rubric's name
     *
     * @return int next reference
     */
    public function getNextReference($model, $name)
    {
        $date = Date('Y');
        // know if rubric's reference is auto
        $referenceParameterFields = $this->Parameter->getReferenceInfos($name);

        switch ($name) {
            case 'affectation' :
                $lastReference = $this->$model->find('first', array(
                    'order' => array($model . '.reference' => ' DESC'),
                    'conditions' => array($model . '.reference !=' => null),
                    'recursive' => -1,
                    'fields' => array('reference')
                ));
                break;
            case 'event' :
                $lastReference = $this->$model->find('first', array(
                    'order' => array($model . '.code' => ' DESC'),
                    'conditions' => array($model . '.code !=' => null),
                    'recursive' => -1
                ,
                    'fields' => array('code')
                ));
                break;
        }
        if (!empty ($referenceParameterFields)) {
            // get reference's size
            $size = $referenceParameterFields['Parameter']['reference_sizes_' . $name];
            // get reference's prefix
            $prefix = $referenceParameterFields['Parameter']['reference_' . $name];


            if (!empty ($lastReference)) {
                if ($name == 'event') {
                    $lastReferenceValue = $lastReference[$model]['code'];
                } else {
                    $lastReferenceValue = $lastReference[$model]['reference'];
                }
                // Get reference without date
                if ($referenceParameterFields['Parameter']['date_suffixe_' . $name] == 2) {
                    // if suffix (2)
                    $dateReference = substr($lastReferenceValue, strlen($lastReferenceValue) - 4,
                        strlen($lastReferenceValue));
                    $lastReferenceValue = substr($lastReferenceValue, 0, strlen($lastReferenceValue) - 5);
                } else {
                    if ($referenceParameterFields['Parameter']['date_suffixe_' . $name] == 1) {
                        // if prefix (1)

                        $dateReference = substr($lastReferenceValue, 0, 4);

                        $lastReferenceValue = substr($lastReferenceValue, 5, strlen($lastReferenceValue));
                    }
                }
                // Get reference without prefix
                if (!empty($referenceParameterFields['Parameter']['reference_' . $name])) {
                    $lastReferenceValue = substr($lastReferenceValue, 1, strlen($lastReferenceValue));
                }
                if (($lastReferenceValue == null) || ($dateReference != $date)) {
                    $lastReferenceValue = 0;
                }
                $nextReference = (int)$lastReferenceValue + 1;
                $sizeReference = strlen((string)$nextReference);
                if ($size > $sizeReference) {
                    $size = $size - $sizeReference;
                    for ($i = 1; $i <= $size; $i++) {
                        $nextReference = '0' . $nextReference;
                    }
                    if ($referenceParameterFields['Parameter']['date_suffixe_' . $name] == 2) {
                        $nextReference = $prefix . $nextReference . '/' . $date;
                    } else {
                        if ($referenceParameterFields['Parameter']['date_suffixe_' . $name] == 1) {
                            $nextReference = $date . '/' . $prefix . $nextReference;
                        }
                    }
                }

                return $nextReference;
            } else {
                $nextReference = 1;
                $sizeReference = 1;
                if ($size > $sizeReference) {
                    $size = $size - $sizeReference;
                    for ($i = 1; $i <= $size; $i++) {
                        $nextReference = '0' . $nextReference;

                    }
                }
                if ($referenceParameterFields['Parameter']['date_suffixe_' . $name] == 2) {
                    $nextReference = $prefix . $nextReference . '/' . $date;
                } else {

                    $nextReference = $date . '/' . $prefix . $nextReference;
                }

                return $nextReference;
            }

        } else {
            return 0;
        }


    }

    public function getNextCodeWithPrefix($model, $name)
    {

        // know if rubric's reference is auto
        $prefix = 1;
        $referenceParameterFields = $this->Parameter->getReferenceInfos($name, $prefix);

        switch ($name) {
            case 'client_initial' :
                $lastReference = $this->$model->find('first', array(
                    'order' => array($model . '.code' => ' DESC'),
                    'conditions' => array($model . '.code !=' => null, 'type' => 1, $model . '.id !=' => array(1, 2),
                        'active' => 1,
                        'Supplier.final_customer' => array(2, 3)),
                    'recursive' => -1,
                    'fields' => array('code')
                ));
                break;
            case 'client_final' :
                $lastReference = $this->$model->find('first', array(
                    'order' => array($model . '.code' => ' DESC'),
                    'conditions' => array($model . '.code !=' => null, 'type' => 1, $model . '.id !=' => array(1, 2),
                        'active' => 1,
                        'Supplier.final_customer' => array(1, 3)),
                    'recursive' => -1,
                    'fields' => array('code')
                ));
                break;


            case 'supplier' :
                $lastReference = $this->$model->find('first', array(
                    'order' => array($model . '.code' => ' DESC'),
                    'conditions' => array($model . '.code !=' => null, 'type' => 0, $model . '.id !=' => array(1, 2),
                        'active' => 1),
                    'recursive' => -1,
                    'fields' => array('code')
                ));
                break;
        }

        //var_dump($lastReference); die();

        if (!empty ($referenceParameterFields)) {
            // get reference's size
            $size = $referenceParameterFields['Parameter']['reference_sizes_' . $name];
            // get reference's prefix
            $prefix = $referenceParameterFields['Parameter']['reference_' . $name];


            if (!empty ($lastReference)) {

                $lastReferenceValue = $lastReference[$model]['code'];
                // Get reference without prefix
                if (!empty($referenceParameterFields['Parameter']['reference_' . $name])) {

                    if ($name == 'supplier') {
                        $lastReferenceValue = substr($lastReferenceValue, 1, strlen($lastReferenceValue));
                    } else {
                        $lastReferenceValue = substr($lastReferenceValue, 2, strlen($lastReferenceValue));

                    }
                }
                if (($lastReferenceValue == null)) {
                    $lastReferenceValue = 0;
                }
                $nextReference = (int)$lastReferenceValue + 1;
                $sizeReference = strlen((string)$nextReference);

                if ($size > $sizeReference) {
                    $size = $size - $sizeReference;
                    for ($i = 1; $i <= $size; $i++) {
                        $nextReference = '0' . $nextReference;

                    }
                    $nextReference = $prefix . $nextReference;


                }

                return $nextReference;
            } else {
                $nextReference = 1;
                $sizeReference = 1;
                if ($size > $sizeReference) {
                    $size = $size - $sizeReference;
                    for ($i = 1; $i <= $size; $i++) {
                        $nextReference = '0' . $nextReference;

                    }
                }
                $nextReference = $prefix . $nextReference;


                return $nextReference;
            }

        } else {
            return 0;
        }


    }

    /**
     * verify if user can view audit
     * @param  int $action_id , int $user_id
     *
     * @return boolean true: user can show, false: user can't show
     */

    public function verifyAudit($section_id)
    {
        if ($this->Auth->user('role_id') != 3) {

            $profile_id = $this->Auth->user('profile_id');

            $audit_right = $this->AccessPermission->find('all', array(
                'conditions' => array(
                    'profile_id' => $profile_id,
                    'section_id' => $section_id,
                    'action_id' => ActionsEnum::audit
                )
            ));
            if (empty ($audit_right)) {
                return false;
            } else {
                return true;
            }

        } else {
            return true;
        }
    }

    /**
     * set last date of connexion of user
     * @param  void
     *
     * @return void
     */
    public function setDateConnexion()
    {
        $user = $this->User->find('all',
            array('conditions' => array('User.id' => $this->Session->read('Auth.User.id')), 'recursive' => -1));

        if (!empty($user)) {

            $this->User->id = $this->Session->read('Auth.User.id');
            $this->User->saveField('last_visit_date', date('Y-m-d H:i'));

        }
    }

    /**
     * Verify if the user in a customer
     * @param  void
     *
     * @return boolean $isCustomer
     */
    public function isCustomer()
    {
        $isCustomer = false;
        if (Configure::read("cafyb") == '0') {
            $user = $this->User->find('first', array('conditions' => array('User.id' => $this->Session->read('Auth.User.id')), 'recursive' => -1));
            if (!empty($user)) {
                $profileId = $user['User']['profile_id'];
                if ($profileId == ProfilesEnum::client) {
                    $isCustomer = true;
                } else {
                    $parentId = $this->Profile->getParentProfileByProfileId($user['User']['profile_id']);
                    $profileId = $parentId;
                    if ($profileId != Null) {
                        if ($profileId == ProfilesEnum::client) {
                            $isCustomer = true;
                        }
                    }
                }
            }
            $this->Session->write("profileId", $profileId);
        }else {
            $profileId = Configure::read("User.profile_id");
            if ($profileId == ProfilesEnum::client) {
                $isCustomer = true;
            }
        }


        return $isCustomer;
    }


    public function hasPurchaseBill()
    {
        $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
        $this->Session->write("usePurchaseBill", $usePurchaseBill);
        return $usePurchaseBill;

    }

    public function addCarsSubcontracting()
    {
        $carSubcontracting = $this->Parameter->getCodesParameterVal('car_subcontracting');
        $this->Session->write("carSubcontracting", $carSubcontracting);
        return $carSubcontracting;

    }

    /**
     * Get customer id
     * @param  void
     *
     * @return int|null could be int customer id, could be null if the user doesn't exist
     */

    public function getCustomerIdByUser()
    {
        $user = $this->User->find('first',
            array('conditions' => array('User.id' => $this->Session->read('Auth.User.id')), 'recursive' => -1));

        if (!empty($user)) {
            $customerId = $user['User']['customer_id'];
            return $customerId;
        } else {
            return null;
        }
    }

    /**
     * @param null $model
     * @param null $controller
     * @param null $msg
     * @param null $id
     * @param null $type
     * Verify if model is already open by another user
     */
    public function isOpenedByOtherUser($model = null, $controller = null, $msg = null, $id = null, $type = null)
    {
        $isOpened = $this->$model->find('first',
            array('conditions' => array($model . '.id' => $id), 'recursive' => -1));
        $open = $isOpened[$model]['is_open'];
        $dateOpen = $isOpened[$model]['date_open'];
        $lastOpener = $isOpened[$model]['last_opener'];
        $user_id = $this->Auth->user('id');
        $currentDate = date('Y-m-d H:i');
        $lastOpenerUser = $this->User->find('first',
            array(
                'recursive' => -1,
                'conditions' => array(
                    'User.id' => $lastOpener,
                ),
                'fields' => array(
                    'User.first_name',
                    'User.last_name'
                )
            )
        );
        $option = $this->Option->find('first', array('conditions' => array('name' => 'temps_minimal_ouverture')));
        $minimumOpeningTime = floatval($option['Option']['val']);
        $dateOpen = new DateTime ($dateOpen);
        $currentDate = new DateTime ($currentDate);
        $interval = date_diff($dateOpen, $currentDate);
        $total = $interval->y * 526600 + $interval->m * 43800 + $interval->d * 1440 + $interval->h * 60 + $interval->i;


        if (($open == 0) || ($open == 1 && $total > $minimumOpeningTime) || ($lastOpener == $user_id)) {

            $this->$model->id = $id;
            $this->$model->saveField('is_open', 1);
            $this->$model->saveField('date_open', date('Y-m-d H:i'));
            $this->$model->saveField('last_opener', $this->Auth->user('id'));
        } elseif ($open == 1 && $total <= $minimumOpeningTime && $lastOpener != $user_id) {
            $this->Flash->error(__('You can not edit. ') . __($msg) . __(' is already open by user : ') . $lastOpenerUser['User']['first_name'] . ' ' . $lastOpenerUser['User']['last_name']);
            $this->redirect(array('controller' => $controller, 'action' => 'index', $type));
        }


    }

    /**
     * cette fonction permet de mettre
     */

    public function closeAllItemOpened()
    {
        $openedCars = $this->Car->getAllOpenedCars();
        $openedCustomers = $this->Customer->getAllOpenedCustomers();
        $openedCustomerCars = $this->CustomerCar->getAllOpenedCustomerCars();
        $openedEvents = $this->Event->getAllOpenedEvents();
        $openedTransportBills = $this->TransportBill->getAllOpenedTransportBills();
        $openedTransportBillDetailRides = $this->TransportBillDetailRides->getAllOpenedTransportBillDetailRides();
        $openedSheetRides = $this->SheetRide->getAllOpenedSheetRides();

        if (!empty($openedCars)) {
            foreach ($openedCars as $openedCar) {
                $id = $openedCar['Car']['id'];
                $this->closeItemOpened('Car', $id);
            }
        }
        if (!empty($openedCustomers)) {
            foreach ($openedCustomers as $openedCustomer) {
                $id = $openedCustomer['Customer']['id'];
                $this->closeItemOpened('Customer', $id);
            }
        }
        if (!empty($openedCustomerCars)) {
            foreach ($openedCustomerCars as $openedCustomerCar) {
                $id = $openedCustomerCar['CustomerCar']['id'];
                $this->closeItemOpened('CustomerCar', $id);
            }
        }
        if (!empty($openedEvents)) {
            foreach ($openedEvents as $openedEvent) {
                $id = $openedEvent['Event']['id'];
                $this->closeItemOpened('Event', $id);
            }
        }
        if (!empty($openedTransportBills)) {
            foreach ($openedTransportBills as $openedTransportBill) {
                $id = $openedTransportBill['TransportBill']['id'];
                $this->closeItemOpened('TransportBill', $id);
            }
        }
        if (!empty($openedTransportBillDetailRides)) {
            foreach ($openedTransportBillDetailRides as $openedTransportBillDetailRide) {
                $id = $openedTransportBillDetailRide['TransportBillDetailRides']['id'];
                $this->closeItemOpened('TransportBillDetailRides', $id);
            }
        }
        if (!empty($openedSheetRides)) {
            foreach ($openedSheetRides as $openedSheetRide) {
                $id = $openedSheetRide['SheetRide']['id'];
                $this->closeItemOpened('SheetRide', $id);
            }
        }
    }

    /**
     * @param $model
     * @param $id
     * une fois on valide ou on annule l'enregistrement d'un item on met la valeur is_open = 0
     */
    public function closeItemOpened($model, $id)
    {
        $this->$model->id = $id;
        $this->$model->saveField('is_open', 0);
    }

    /**
     * @param $rubricId
     * @param $id
     * @param $userId
     * @param $actionId
     * @throws Exception
     */
    public function saveUserAction($rubricId = null, $id = null, $userId = null, $actionId = null)
    {
        $this->Audit->create();
        $data = array();
        $data['Audit']['rubric_id'] = $rubricId;
        $data['Audit']['article_id'] = $id;
        $data['Audit']['user_id'] = $userId;
        $data['Audit']['action_id'] = $actionId;
        $this->Audit->save($data);
    }

    /** calcul le nb total des alertes
     * @return mixed
     */
    public function getTotalNbAlerts()
    {
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        $permissionsAlertCommerciales = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_commerciales, ActionsEnum::view, $profileId, $roleId);
        $permissionsAlertAdministratives = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_administratives_juridiques, ActionsEnum::view, $profileId, $roleId);
        $permissionsAlertMaintenances = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_maintenances, ActionsEnum::view, $profileId, $roleId);
        $permissionsAlertConsommations = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_consommations, ActionsEnum::view, $profileId, $roleId);
        $permissionsAlertParcs = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_parcs, ActionsEnum::view, $profileId, $roleId);
        $permissionsAlertStock = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_stock, ActionsEnum::view, $profileId, $roleId);

        $nbAlertsCommercial = 0;
        $nbAlertsAdministrative = 0;
        $nbAlertsMaintenance = 0;
        $nbAlertsConsommation = 0;
        $nbAlertsParc = 0;
        $nbAlertsStock = 0;
        $authenticatedUserId = $this->Auth->user('id');
        if (!$this->IsAdministrator){
            $userParcsIds = $this->getParcsUserIdsArray($authenticatedUserId);
        }else{
            $userParcsIds = array();
        }
        if ($permissionsAlertCommerciales) {
            $alertsCommercial = $this->Alert->getNbAlertsByUserPermissions(SectionsEnum::alertes_commerciales);
            $nbAlertsCommercial = $alertsCommercial[0][0]['nbAlerts'];
        }
        if ($permissionsAlertAdministratives) {
            $alertsAdministrative = $this->Alert->getNbAlertsByUserPermissions(SectionsEnum::alertes_administratives_juridiques, $userParcsIds);
            $nbAlertsAdministrative = $alertsAdministrative[0][0]['nbAlerts'];

        }
        if ($permissionsAlertMaintenances) {
            $alertsMaintenance = $this->Alert->getNbAlertsByUserPermissions(SectionsEnum::alertes_maintenances , $userParcsIds);
            $nbAlertsMaintenance = $alertsMaintenance[0][0]['nbAlerts'];
        }
        if ($permissionsAlertConsommations) {
            $alertsConsommation = $this->Alert->getNbAlertsByUserPermissions(SectionsEnum::alertes_consommations);
            $nbAlertsConsommation = $alertsConsommation[0][0]['nbAlerts'];
        }
        if ($permissionsAlertParcs) {
            $alertsParc = $this->Alert->getNbAlertsByUserPermissions(SectionsEnum::alertes_parcs);
            $nbAlertsParc = $alertsParc[0][0]['nbAlerts'];
        }

        if ($permissionsAlertStock) {
            $alertsStock = $this->Alert->getNbAlertsByUserPermissions(SectionsEnum::alertes_stock);
            $nbAlertsStock = $alertsStock[0][0]['nbAlerts'];
        }

        $nbAlerts = $nbAlertsCommercial + $nbAlertsAdministrative + $nbAlertsMaintenance + $nbAlertsConsommation + $nbAlertsParc + $nbAlertsStock;
        $this->sendMailAlertsByParams($permissionsAlertCommerciales, $permissionsAlertAdministratives, $permissionsAlertMaintenances,
            $permissionsAlertConsommations, $permissionsAlertParcs, $permissionsAlertStock);
        $this->Session->write("nbAlerts", $nbAlerts);
        return $nbAlerts;

    }

    public function sendMailAlertsByParams($permissionsAlertCommerciales = null, $permissionsAlertAdministratives = null, $permissionsAlertMaintenances = null,
                                           $permissionsAlertConsommations = null, $permissionsAlertParcs = null, $permissionsAlertStock = null)
    {

        $assuranceAlerts = array();
        $controlAlerts = array();
        $vidangeAlerts = array();
        $kmAlerts = array();
        $vignetteAlerts = array();
        $dateAlerts = array();
        $vidangeHourAlerts = array();
        $kmContractAlerts = array();
        $dateContractAlerts = array();
        $driverLicenseAlerts = array();
        $consumptionAlerts = array();
        $couponAlerts = array();
        $amortissementAlerts = array();
        $productMinAlerts = array();
        $productMaxAlerts = array();
        $minCouponAlerts = array();
        $deadlineAlerts = array();
        if ($permissionsAlertCommerciales) {
            $deadlineAlerts = $this->Alert->getDeadlineAlerts(ParametersEnum::echeance);
        }
        if ($permissionsAlertAdministratives) {
            $assuranceAlerts = $this->Alert->getAssuranceAlerts(ParametersEnum::assurance);
            $controlAlerts = $this->Alert->getControlAlerts(ParametersEnum::controle_technique);
            $vignetteAlerts = $this->Alert->getVignetteAlerts(ParametersEnum::vignette);
            $driverLicenseAlerts = $this->Alert->getDriverLicenseAlerts(ParametersEnum::expiration_permis);
        }
        if ($permissionsAlertMaintenances) {
            $vidangeAlerts = $this->Alert->getVidangeAlerts(ParametersEnum::vidange);
            $kmAlerts = $this->Alert->getKmAlerts(ParametersEnum::avec_km);
            $dateAlerts = $this->Alert->getDateAlerts(ParametersEnum::avec_date);
            $vidangeHourAlerts = $this->Alert->getVidangeHourAlerts(ParametersEnum::vidange_engins);
        }
        if ($permissionsAlertConsommations) {
            $consumptionAlerts = $this->Alert->getNbKmConsumptionAlerts(ParametersEnum::limite_mensuelle_consommation);
            $couponAlerts = $this->Alert->getCouponConsumptionAlerts(ParametersEnum::coupon_consumption);
            $minCouponAlerts = $this->Alert->getMinCouponAlerts(ParametersEnum::nb_minimum_bons);
        }
        if ($permissionsAlertParcs) {
            $kmContractAlerts = $this->Alert->getKmContractAlerts(ParametersEnum::km_restant_contrat);
            $dateContractAlerts = $this->Alert->getDateContractAlerts(ParametersEnum::contrat_vehicule);
            $amortissementAlerts = $this->Alert->getAmortissementAlerts(ParametersEnum::amortissement);
        }

        if ($permissionsAlertStock) {
            $productMinAlerts = $this->Alert->getProductMinAlerts(ParametersEnum::product_min);
            $productMaxAlerts = $this->Alert->getProductMaxAlerts(ParametersEnum::product_max);
        }

        $msgAssurances = '';
        $msgControles = '';
        $msgVignettes = '';
        $msgDates = '';
        $msgVidanges = '';
        $msgKms = '';
        $msgVidangesHeure = '';
        $msgDriverLicenses = '';
        $msgConsumptions = '';
        $msgCoupons = '';
        $msgMinCoupon = '';
        $msgKmContracts = '';
        $msgDateContracts = '';
        $msgAmortissements = '';
        $msgProductMins = '';
        $msgProductMaxs = '';
        $msgDeadlines = '';
        if (!empty($assuranceAlerts)) {
            $msgAssurances = __("You have assurance alerts for the following cars ");
            $cars = '';
            foreach ($assuranceAlerts as $assuranceAlert) {
                $cars = $cars . "<li style='list-style:disc'>  " . $assuranceAlert["Car"]['code'] . ' ' . $assuranceAlert["Carmodel"]['name'] . "</li>";
            }
            $msgAssurances = $msgAssurances . $cars;
        }
        if (!empty($controlAlerts)) {
            $msgControles = __("You have controle alerts for the following cars ");
            $cars = '';
            foreach ($controlAlerts as $controlAlert) {

                $cars = $cars . "<li style='list-style:disc'>  " . $controlAlert["Car"]['code'] . ' ' . $controlAlert["Carmodel"]['name'] . "</li>";
            }
            $msgControles = $msgControles . $cars;
        }
        if (!empty($vignetteAlerts)) {
            $msgVignettes = __("You have vignette alerts for the following cars ");
            $cars = '';
            foreach ($vignetteAlerts as $vignetteAlert) {
                $cars = $cars . "<li style='list-style:disc'>  " . $vignetteAlert["Car"]['code'] . ' ' . $vignetteAlert["Carmodel"]['name'] . "</li>";
            }
            $msgVignettes = $msgVignettes . $cars;
        }
        if (!empty($dateAlerts)) {
            $msgDates = __("You have date alerts for the following cars ");
            $cars = '';
            foreach ($dateAlerts as $dateAlert) {
                $cars = $cars . "<li style='list-style:disc'>  " . $dateAlert["Car"]['code'] . ' ' . $dateAlert["Carmodel"]['name'] . "</li>";
            }
            $msgDates = $msgDates . $cars;
        }
        if (!empty($vidangeAlerts)) {
            $msgVidanges = __("You have vidange alerts for the following cars ");
            $cars = '';
            foreach ($vidangeAlerts as $vidangeAlert) {
                $cars = $cars . "<li style='list-style:disc'>  " . $vidangeAlert["Car"]['code'] . ' ' . $vidangeAlert["Carmodel"]['name'] . "</li>";
            }
            $msgVidanges = $msgVidanges . $cars;
        }
        if (!empty($vidangeHourAlerts)) {
            $msgVidangesHeure = __("You have vidange alerts for the following cars ");
            $cars = '';
            foreach ($vidangeHourAlerts as $vidangeHourAlert) {
                $cars = $cars . "<li style='list-style:disc'>  " . $vidangeHourAlert["Car"]['code'] . ' ' . $vidangeHourAlert["Carmodel"]['name'] . "</li>";
            }
            $msgVidangesHeure = $msgVidangesHeure . $cars;
        }
        if (!empty($kmAlerts)) {
            $msgKms = __("You have km alerts for the following cars ");
            $cars = '';
            foreach ($kmAlerts as $kmAlert) {
                $cars = $cars . "<li style='list-style:disc'>  " . $kmAlert["Car"]['code'] . ' ' . $kmAlert["Carmodel"]['name'] . "</li>";
            }
            $msgKms = $msgKms . $cars;
        }

        if (!empty($driverLicenseAlerts)) {
            $msgDriverLicenses = __("You have driver license alerts for the following customers ");
            $customers = '';
            foreach ($driverLicenseAlerts as $driverLicenseAlert) {
                $customers = $customers . "<li style='list-style:disc'>  " . $driverLicenseAlert["Customer"]['first_name'] . ' ' . $driverLicenseAlert["Customer"]['last_name'] . "</li>";
            }
            $msgDriverLicenses = $msgDriverLicenses . $customers;
        }

        if (!empty($consumptionAlerts)) {
            $msgConsumptions = __("You have consumption alerts for the following cars ");
            $cars = '';
            foreach ($consumptionAlerts as $consumptionAlert) {
                $cars = $cars . "<li style='list-style:disc'>  " . $consumptionAlert["Car"]['code'] . ' ' . $consumptionAlert["Carmodel"]['name'] . "</li>";
            }
            $msgConsumptions = $msgConsumptions . $cars;
        }
        if (!empty($couponAlerts)) {
            $msgCoupons = __("You have consumption alerts for the following cars ");
            $cars = '';
            foreach ($couponAlerts as $couponAlert) {
                $cars = $cars . "<li style='list-style:disc'>  " . $couponAlerts["Car"]['code'] . ' ' . $couponAlert["Carmodel"]['name'] . "</li>";
            }
            $msgCoupons = $msgCoupons . $cars;
        }

        if (!empty($minCouponAlerts)) {
            $minCouponAlert = $this->Parameter->getParamValByCode(ParametersEnum::nb_minimum_bons, array('val'));
            $limitedCoupon = $minCouponAlert['Parameter']['val'];
            $msgMinCoupon = __("Number of coupons is less than ") . $limitedCoupon;
        }

        if (!empty($kmContractAlerts)) {
            $msgKmContracts = __("You have km contract alerts for the following cars ");
            $cars = '';
            foreach ($kmContractAlerts as $kmContractAlert) {
                $cars = $cars . "<li style='list-style:disc'>  " . $kmContractAlert["Car"]['code'] . ' ' . $kmContractAlert["Carmodel"]['name'] . "</li>";
            }
            $msgKmContracts = $msgKmContracts . $cars;
        }
        if (!empty($dateContractAlerts)) {
            $msgDateContracts = __("You have date contract alerts for the following cars ");
            $cars = '';
            foreach ($dateContractAlerts as $dateContractAlert) {
                $cars = $cars . "<li style='list-style:disc'>  " . $dateContractAlert["Car"]['code'] . ' ' . $dateContractAlert["Carmodel"]['name'] . "</li>";
            }
            $msgDateContracts = $msgDateContracts . $cars;
        }

        if (!empty($amortissementAlerts)) {
            $msgAmortissements = __("You have amortissement alerts for the following cars ");
            $cars = '';
            foreach ($amortissementAlerts as $amortissementAlert) {
                $cars = $cars . "<li style='list-style:disc'>  " . $amortissementAlert["Car"]['code'] . ' ' . $amortissementAlert["Carmodel"]['name'] . "</li>";
            }
            $msgAmortissements = $msgAmortissements . $cars;
        }

        if (!empty($productMinAlerts)) {
            $msgProductMins = __("You have minimuum product alerts for the following products ");
            $products = '';
            foreach ($productMinAlerts as $productMinAlert) {
                $products = $products . "<li style='list-style:disc'>  " . $productMinAlert["Product"]['code'] . ' ' . $productMinAlert["Product"]['name'] . "</li>";
            }
            $msgProductMins = $msgProductMins . $products;
        }
        if (!empty($productMaxAlerts)) {
            $msgProductMaxs = __("You have maximum product alerts for the following products ");
            $products = '';
            foreach ($productMaxAlerts as $productMaxAlert) {
                $products = $products . "<li style='list-style:disc'>  " . $productMaxAlert["Product"]['code'] . ' ' . $productMaxAlert["Product"]['name'] . "</li>";
            }
            $msgProductMaxs = $msgProductMaxs . $products;
        }
        if (!empty($deadlineAlerts)) {
            $msgDeadlines = __("You have deadline alerts for the following invoices ");
            $transportBills = '';
            foreach ($deadlineAlerts as $deadlineAlert) {
                $transportBills = $transportBills . "<li style='list-style:disc'>  " . $deadlineAlert["TransportBill"]['reference'] . "</li>";
            }
            $msgDeadlines = $msgDeadlines . $transportBills;
        }
        $msgEnd = __("Click ")
            . "<a href='" . Router::url(array('controller' => 'alerts', 'action' => 'getAllAlerts'), true) . "'>"
            . " " . __("here") . "</a> " . __("to view it.");
        $msgCommerciale = "<br/>" . $msgDeadlines . "<br/>";
        $msgAdministrative = "<br/>" . $msgAssurances . "<br/>" . $msgControles . "<br/>" . $msgVignettes . "<br/>" . $msgDriverLicenses . "<br/>";
        $msgMaintenance = "<br/>" . $msgDates . "<br/>" . $msgVidanges . "<br/>" . $msgVidangesHeure . "<br/>" . $msgKms . "<br/>";
        $msgConsommation = "<br/>" . $msgConsumptions . "<br/>" . $msgCoupons . "<br/>" . $msgMinCoupon . "<br/>";
        $msgParc = "<br/>" . $msgKmContracts . "<br/>" . $msgDateContracts . "<br/>" . $msgAmortissements . "<br/>";
        $msgStock = "<br/>" . $msgProductMins . "<br/>" . $msgProductMaxs . "<br/>";
        $msg = '';
        if ((!empty($msgCommerciale)) || (!empty($msgAdministrative)) || (!empty($msgMaintenance)) || (!empty($msgMaintenance))
            || (!empty($msgConsommation)) || (!empty($msgParc)) || (!empty($msgStock))
        ) {
            $users = $this->getUsersReceiveAlert();
            foreach ($users as $user) {
                $profileId = $user['User']['profile_id'];
                $roleId = $user['User']['role_id'];
                $permissionsAlertCommerciales = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_commerciales, ActionsEnum::view, $profileId, $roleId);
                $permissionsAlertAdministratives = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_administratives_juridiques, ActionsEnum::view, $profileId, $roleId);
                $permissionsAlertMaintenances = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_maintenances, ActionsEnum::view, $profileId, $roleId);
                $permissionsAlertConsommations = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_consommations, ActionsEnum::view, $profileId, $roleId);
                $permissionsAlertParcs = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_parcs, ActionsEnum::view, $profileId, $roleId);
                $permissionsAlertStock = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_stock, ActionsEnum::view, $profileId, $roleId);
                if ($permissionsAlertCommerciales) {
                    $msg = $msg . ' ' . $msgCommerciale;
                }
                if ($permissionsAlertAdministratives) {
                    $msg = $msg . ' ' . $msgAdministrative;
                }
                if ($permissionsAlertMaintenances) {
                    $msg = $msg . ' ' . $msgMaintenance;
                }
                if ($permissionsAlertConsommations) {
                    $msg = $msg . ' ' . $msgConsommation;
                }
                if ($permissionsAlertParcs) {
                    $msg = $msg . ' ' . $msgParc;
                }
                if ($permissionsAlertStock) {
                    $msg = $msg . ' ' . $msgStock;
                }
                if ($msg) {
                    $msg = $msg . ' ' . $msgEnd;
                    $Email = new CakeEmail('phpmail');
                    //$Email->addTo($user['User']['email']);
                    $Email->template('welcome', 'fancy')
                        ->emailFormat('html')
                        ->to("alert@utranx.com")
                        ->from('alert@utranx.com')
                        ->subject('UtranX Alerte');
                    try {
                        $Email->send($msg);

                    } catch (Exception $ex) {


                    }
                }

            }


        }


    }

    /**
     * get Users who must Receive Alert
     * @param void
     * @return array $users
     */

    public function getUsersReceiveAlert()
    {
        $users = $this->User->find('all', array(
            'recursive' => -1,
            'conditions' => array('receive_alert' => 1, 'User.email !=' => null)
        ));

        return $users;
    }

    public function getAssuranceAlerts()
    {
        $assuranceAlert = $this->Parameter->getParamValByCode(ParametersEnum::assurance, array('val'));
        $limitedDate = date('Y-m-d H:i:s', strtotime('+' . $assuranceAlert['Parameter']['val'] . ' days'));
        $assuranceAlerts = $this->Event->getAssuranceAlerts($limitedDate);
        return $assuranceAlerts;
    }

    public function getNbNotificationsByUser()
    {
        $roleId = $this->Auth->user('role_id');

        $supplierId = Null;
        if($roleId!=3){
            $profileId = $this->Auth->user('profile_id');
            $parentId = $this->Profile->getParentProfileByProfileId($profileId);
            if ($parentId != Null) {
                $profileId = $parentId;
            }

            if ($profileId == ProfilesEnum::client) {
                $supplierId = $this->Auth->user('supplier_id');
            }
            $userRights = $this->AccessPermission->getPermissionBySubModule(45,$profileId);
            $sectionIds = array();
            if(!empty($userRights)){
                foreach ($userRights as $userRight){
                    $sectionIds[]= $userRight['Section']['id'];
                }
            }
        }else {
            $sectionIds = $this->Section->getSectionsBySubModule(45);
        }

        $nbNotifications = $this->Notification->getNbNotificationsByUser($sectionIds, $supplierId);

        $this->Session->write("nbNotifications", $nbNotifications[0][0]['nbNotifications']);
        return $nbNotifications[0][0]['nbNotifications'];
    }

    public function getNbComplaintNotificationsByUser()
    {
        $sectionId = 162;
        $nbNotifications = $this->Notification->getNbComplaintNotificationsByUser($sectionId);
        $this->Session->write("nbComplaintNotifications", $nbNotifications[0][0]['nbNotifications']);
        return $nbNotifications[0][0]['nbNotifications'];
    }
    public function getNbAlerts()
    {
        $nbAlerts = $this->Alert->getNbAlerts();
        $this->Session->write("nbAlerts", $nbAlerts[0][0]['nbAlerts']);
        return $nbAlerts[0][0]['nbAlerts'];
    }

    /**
     * Set Alerts in session
     * @param void
     *
     * @return void
     */
    public function setSessionAlerts($carId = null, $eventTypeId = null, $eventId = null)
    {

        if ($eventTypeId != null) {
            $eventType = $this->EventType->find('first',array('recursive'=>-1, 'conditions'=>array('EventType.id'=>$eventTypeId)));

            if($eventType['EventType']['alert_km'] || $eventType['EventType']['alert_date']){
                if($eventType['EventType']['alert_km'] !=Null ){
                    $kmEvents = $this->setKmAlerts($carId , $eventType['EventType']['alert_km'] , $eventTypeId,$eventId);
                } else {
                    if($eventType['EventType']['alert_date'] !=Null){
                        $dateEvents = $this->setDateAlerts($carId , $eventType['EventType']['alert_date'], $eventTypeId ,$eventId);

                    } else {
                        if($eventType['EventType']['alert_km'] !=Null && $eventType['EventType']['alert_date'] !=Null){
                            $kmEvents = $this->setKmAlerts($carId, $eventType['EventType']['alert_km'], $eventTypeId ,$eventId);
                            $dateEvents = $this->setDateAlerts($carId, $eventType['EventType']['alert_date'], $eventTypeId,$eventId);
                        }
                    }
                }
            }
        } else {
            $dateEvents = $this->setDateAlerts($carId);
            $kmEvents = $this->setKmAlerts($carId);
        }


        $Email = new CakeEmail();

        $msgKms = '';
        $msgDates = '';
        $msgVidangesHeure = '';
        $msgAssurances = '';
        $msgControles = '';
        $msgVignettes = '';
        $msgVidanges = '';
        /* if (!empty($assuranceEvents)){
            $assurancesAlerts = $this->Alert->getAssuranceAlerts(ParametersEnum::assurance);
            $msgAssurances = __("You have assurance alerts for the following cars ");
            $cars = '';
            foreach ($assurancesAlerts as $assurancesAlert) {
                $cars = $cars . "<li style='list-style:disc'>  " . $assurancesAlert["Car"]['code'] . ' ' . $assurancesAlert["Carmodel"]['name'] . "</li>";
            }
            $msgAssurances = $msgAssurances . $cars;
        }
        if (!empty($controleEvents)) {
            $controlesAlerts = $this->Alert->getControlAlerts(ParametersEnum::controle_technique);
            $msgControles = __("You have controle alerts for the following cars ");
            $cars = '';
            foreach ($controlesAlerts as $controlesAlert) {

                $cars = $cars . "<li style='list-style:disc'>  " . $controlesAlert["Car"]['code'] . ' ' . $controlesAlert["Carmodel"]['name'] . "</li>";
            }
            $msgControles = $msgControles . $cars;
        }
        if (!empty($vignetteEvents)) {
            $vignettesAlerts = $this->Alert->getVignetteAlerts(ParametersEnum::vignette);
            $msgVignettes = __("You have vignette alerts for the following cars ");
            $cars = '';
            foreach ($vignettesAlerts as $vignettesAlert) {
                $cars = $cars . "<li style='list-style:disc'>  " . $vignettesAlert["Car"]['code'] . ' ' . $vignettesAlert["Carmodel"]['name'] . "</li>";
            }
            $msgVignettes = $msgVignettes . $cars;
        }
        if (!empty($vidangeEvents)) {
            $vidangesAlerts = $this->Alert->getVidangeAlerts(ParametersEnum::vidange);
            $msgVidanges = __("You have vidange alerts for the following cars ");
            $cars = '';
            foreach ($vidangesAlerts as $vidangesAlert) {
                $cars = $cars . "<li style='list-style:disc'>  " . $vidangesAlert["Car"]['code'] . ' ' . $vidangesAlert["Carmodel"]['name'] . "</li>";
            }
            $msgVidanges = $msgVidanges . $cars;
        }
        if (!empty($vidangeHourEvents)) {
            $vidangesHourAlerts = $this->Alert->getVidangeHourAlerts(ParametersEnum::vidange_engins);
            $msgVidangesHeure = __("You have vidange alerts for the following cars ");
            $cars = '';
            foreach ($vidangesHourAlerts as $vidangesHourAlert) {
                $cars = $cars . "<li style='list-style:disc'>  " . $vidangesHourAlert["Car"]['code'] . ' ' . $vidangesHourAlert["Carmodel"]['name'] . "</li>";
            }
            $msgVidangesHeure = $msgVidangesHeure . $cars;
        }*/

        if (!empty($dateEvents) && ($eventTypeId!=null)) {
            $datesAlerts = $this->Alert->getDateAlerts($eventTypeId);
            $msgDates = __("You have ") .$eventType['EventType']['name'] .__(" alerts for the following cars : ");
            $cars = '';
            foreach ($datesAlerts as $datesAlert) {
                $cars = $cars . "<li style='list-style:disc'>  " . $datesAlert["Car"]['code'] . " " . $datesAlert["Carmodel"]['name'] . "</li>";
            }
            $msgDates = $msgDates . $cars;

        }
        if (!empty($kmEvents)) {
            $kmsAlerts = $this->Alert->getKmAlerts($eventTypeId);
            $msgKms = __("You have ") .$eventType['EventType']['name'] .__(" alerts for the following cars : ");
            $cars = '';
            foreach ($kmsAlerts as $kmsAlert) {
                $cars = $cars . "<li style='list-style:disc'>  " . $kmsAlert["Car"]['code'] . ' ' . $kmsAlert["Carmodel"]['name'] . "</li>";
            }
            $msgKms = $msgKms . $cars;
        }
        $msg = __("Click ")
            . "<a href='" . Router::url(array('controller' => 'events', 'action' => 'alerts'), true) . "'>"
            . " " . __("here") . "</a> " . __("to view it.");

        $msg = "<br/>" .  $msgDates . "<br/>" . $msgKms . "<br/>" . $msg;

        if ( (!empty($msgDates)) || (!empty($msgKms))
        ) {
            $users = $this->getUsersReceiveAlert();

            foreach ($users as $user) {
                $Email->addTo($user['User']['email']);
            }
            $Email->template('welcome', 'fancy')
                ->emailFormat('html')
                ->config('smtp')
                ->from('alert@utranx.com')
                ->subject('UtranX Alerte');
            try {
                $Email->send($msg);
            } catch (Exception $ex) {

            }

        }
    }

    public function setVidangeAlerts($carId = null)
    {
        $vidangeAlert = $this->Parameter->getParamValByCode(ParametersEnum::vidange, array('val'));
        $limitedKm = $vidangeAlert['Parameter']['val'];
        $vidangeEvents = $this->Event->getKmAlert($limitedKm, $carId, 1);
        if (!empty($vidangeEvents)) {
            $this->Alert->insertAlerts($vidangeEvents, ParametersEnum::vidange, 'Event');
        }
        return $vidangeEvents;
    }

    public function setAssuranceAlerts($carId = null)
    {
        $assuranceAlert = $this->Parameter->getParamValByCode(ParametersEnum::assurance, array('val'));
        $limitedDate = date('Y-m-d H:i:s', strtotime('+' . $assuranceAlert['Parameter']['val'] . ' days'));
        $assuranceEvents = $this->Event->getAssuranceAlerts($limitedDate, $carId);
        if (!empty($assuranceEvents)) {
            $this->Alert->insertAlerts($assuranceEvents, ParametersEnum::assurance, 'Event');
        }
        return $assuranceEvents;
    }

    public function setControlAlerts($carId = null)
    {
        $controlAlert = $this->Parameter->getParamValByCode(
            ParametersEnum::controle_technique, array('val')
        );
        $limitedDate = date('Y-m-d H:i:s', strtotime('+' . $controlAlert['Parameter']['val'] . ' days'));
        $controlEvents = $this->Event->getControlAlerts($limitedDate, $carId);
        if (!empty($controlEvents)) {
            $this->Alert->insertAlerts($controlEvents, ParametersEnum::controle_technique, 'Event');
        }
        return $controlEvents;
    }

    /* set km contract alert
     * @param void
     * @return void
	*/

    public function setKmAlerts($carId = null, $nbKm= null , $eventTypeId = null , $eventId = null)
    {
        if(empty($nbKm)){
            $kmAlert = $this->Parameter->getParamValByCode(ParametersEnum::avec_km, array('val'));
            $nbKm = $kmAlert['Parameter']['val'];
        }
        $kmEvents = $this->Event->getKmAlert($nbKm, $carId, null , $eventId);
        if (!empty($kmEvents)) {
            $this->Alert->insertAlerts($kmEvents, $eventTypeId, 'Event');
        }
        return $kmEvents;
    }

    /* set date contract alert
     * @param void
     * @return void
    */

    public function setVignetteAlerts($carId = null)
    {
        $vignetteAlert = $this->Parameter->getParamValByCode(ParametersEnum::vignette, array('val'));
        $limitedDate = date('Y-m-d H:i:s', strtotime('+' . $vignetteAlert['Parameter']['val'] . ' days'));
        $vignetteEvents = $this->Event->getVignetteAlerts($limitedDate, $carId);
        if (!empty($controlEvents)) {
            $this->Alert->insertAlerts($vignetteEvents, ParametersEnum::vignette, 'Event');
        }
        return $vignetteEvents;
    }

    /* set  drivers license alert
     * @param void
     * return void
	*/

    public function setDateAlerts($carId = null, $nbDays = null, $eventTypeId = null, $eventId = null)
    {
        if(empty($nbDays)){
            $dateAlert = $this->Parameter->getParamValByCode(ParametersEnum::avec_date, array('val'));
            $nbDays = $dateAlert['Parameter']['val'];

        }
        $limitedDate = date('Y-m-d H:i:s', strtotime('+' . $nbDays . ' days'));

        $dateEvents = $this->Event->getDateAlerts($limitedDate, $carId, $eventId);
        if (!empty($dateEvents)) {
            $this->Alert->insertAlerts($dateEvents, $eventTypeId, 'Event');
        }
        return $dateEvents;

    }

    public function setExpirationDateAlerts($nbDays = null)
    {
        if(empty($nbDays)){
            $dateAlert = $this->Parameter->getParamValByCode(ParametersEnum::avec_date, array('val'));
            $nbDays = $dateAlert['Parameter']['val'];
        }
        $limitedDate = date('Y-m-d H:i:s', strtotime('+' . $nbDays . ' days'));
        $expirationDates = $this->SerialNumber->getExpirationDateAlerts($limitedDate);
        if (!empty($expirationDates)) {
            $this->Alert->insertAlerts($expirationDates, 32, 'SerialNumber');
        }
        return $expirationDates;
    }

    public function setVidangeHoursAlerts($carId = null)
    {

        $vidangeHourAlert = $this->Parameter->getParamValByCode(ParametersEnum::vidange_engins, array('val'));
        $limitedHour = $vidangeHourAlert['Parameter']['val'];

        $vidangeHourEvents = $this->Event->getHourAlert($limitedHour, $carId);
        if (!empty($vidangeHourEvents)) {
            $this->Alert->insertAlerts($vidangeHourEvents, ParametersEnum::vidange_engins, 'Event');
        }
        return $vidangeHourEvents;

    }

    public function setDeadlineAlerts($transportBillId = null)
    {
        $deadlineAlert = $this->Parameter->getParamValByCode(ParametersEnum::echeance, array('val'));

        $limitedDate = date('Y-m-d H:i:s', strtotime('+' . $deadlineAlert['Parameter']['val'] . ' days'));
        $deadlineAlerts = $this->Deadline->getDeadlineAlerts($limitedDate, $transportBillId);

        if (!empty($deadlineAlerts)) {
            $this->Alert->insertAlerts($deadlineAlerts, ParametersEnum::echeance, 'TransportBill');
        }
        return $deadlineAlerts;
    }


    /* set quantity product alert
 * @param void
 * @return void
	*/

    public function setKmContractAlerts()
    {
        $kmContractAlert = $this->Parameter->getParamValByCode(ParametersEnum::km_restant_contrat, array('val'));
        $limitedKmContract = $kmContractAlert['Parameter']['val'];;

        $kmContracts = $this->Car->getKmContractAlerts($limitedKmContract);
        if (!empty($kmContracts)) {
            $this->Alert->insertAlerts($kmContracts, ParametersEnum::km_restant_contrat, 'Car');
            $Email = new CakeEmail('phpmail');
            $msg = __("You have new alerts, click ")
                . "<a href='" . Router::url(array('controller' => 'cars', 'action' => 'kmcontratalert'), true) . "'>"
                . " " . __("here") . "</a> " . __("to view it.");
            $users = $this->getUsersReceiveAlert();

            foreach ($users as $user) {
                $Email->addTo($user['User']['email']);
            }
            $Email->template('welcome', 'fancy')
                ->emailFormat('html')
                ->from('alert@utranx.com')
                ->subject('UtranX Alerte');
            try {
                $Email->send($msg);
            } catch (Exception $ex) {

            }
        }


    }


    public function setDateContractAlerts()
    {
        $contractAlertDate = $this->Parameter->getParamValByCode(ParametersEnum::contrat_vehicule, array('val'));
        $limitedDate = date('Y-m-d H:i:s', strtotime('+' . $contractAlertDate['Parameter']['val'] . ' days'));

        $dateContracts = $this->Car->getDateContractAlerts($limitedDate);
        if (!empty($dateContracts)) {
            $this->Alert->insertAlerts($dateContracts, ParametersEnum::contrat_vehicule, 'Car');
            $Email = new CakeEmail('phpmail');
            $msg = __("You have new alerts, click ")
                . "<a href='" . Router::url(array('controller' => 'cars', 'action' => 'datecontratalert'), true) . "'>"
                . " " . __("here") . "</a> " . __("to view it.");
            $users = $this->getUsersReceiveAlert();

            foreach ($users as $user) {
                $Email->addTo($user['User']['email']);
            }
            $Email->template('welcome', 'fancy')
                ->emailFormat('html')
                ->from('alert@utranx.com')
                ->subject('UtranX Alerte');
            try {
                $Email->send($msg);
            } catch (Exception $ex) {

            }
        }
    }

    /* set assurance alert
     * @param void
     * return void
     */

    public function setSessionDriversLicenseAlerts($customerId = null)
    {
        $driverLicenseExpParam = $this->Parameter->getParamValByCode(ParametersEnum::expiration_permis, array('val'));
        $driverLicenseLimitValue = date(
            'Y-m-d H:i:s',
            strtotime('+' . $driverLicenseExpParam['Parameter']['val'] . ' days')
        );

        $driverLicenseAlerts = $this->Customer->getCustomerWithDriverLicenseExpireDate($driverLicenseLimitValue, $customerId);
        if (!empty($driverLicenseAlerts)) {
            $this->Alert->insertAlerts($driverLicenseAlerts, ParametersEnum::expiration_permis, 'Customer');
            $Email = new CakeEmail('phpmail');
            $msg = __("You have new alerts, click ")
                . "<a href='" . Router::url(array('controller' => 'customers', 'action' => 'permisalert'), true) . "'>"
                . " " . __("here") . "</a> " . __("to view it.");
            $users = $this->getUsersReceiveAlert();

            foreach ($users as $user) {
                $Email->addTo($user['User']['email']);
            }
            $Email->template('welcome', 'fancy')
                ->emailFormat('html')
                ->from('alert@utranx.com')
                ->subject('UtranX Alerte');
            try {
                $Email->send($msg);
            } catch (Exception $ex) {

            }
        }


    }

    /* set km contract alert
    * @param void
    * return void
    */

    public function setSessionAmortissementAlerts($carId = null)
    {
        $amortizationExpParam = $this->Parameter->getParamValByCode(ParametersEnum::amortissement, array('val'));
        $amortissementAlerts = $this->Car->getAmortissementAlerts($amortizationExpParam['Parameter']['val'], $carId);

        if (!empty($amortissementAlerts)) {
            $this->Alert->insertAlerts($amortissementAlerts, ParametersEnum::amortissement, 'Car');
            $Email = new CakeEmail('phpmail');
            $msg = __("You have new alerts, click ")
                . "<a href='" . Router::url(array('controller' => 'cars', 'action' => 'amortissementAlert'),
                    true) . "'>"
                . " " . __("here") . "</a> " . __("to view it.");
            $users = $this->getUsersReceiveAlert();

            foreach ($users as $user) {
                $Email->addTo($user['User']['email']);
            }
            $Email->template('welcome', 'fancy')
                ->emailFormat('html')
                ->from('alert@utranx.com')
                ->subject('UtranX Alerte');
            try {
                $Email->send($msg);
            } catch (Exception $ex) {

            }
        }


    }


    /* set driver license alert
    * @param void
    * return void
    */

    public function getKmConsumptionAlerts($carId = null)
    {
        $consumptionAlert = $this->Parameter->getParamValByCode(
            ParametersEnum::limite_mensuelle_consommation, array('val')
        );
        $limitedConsumption = $consumptionAlert['Parameter']['val'];
        // get all car with limit consumption km alert.
        $consumptionAlerts = $this->SheetRide->getConsumptionAlerts($limitedConsumption, $carId);
        if (!empty($consumptionAlerts)) {
            $this->Alert->insertAlerts($consumptionAlerts, ParametersEnum::limite_mensuelle_consommation, 'SheetRide');
            $Email = new CakeEmail('phpmail');
            $msg = __("You have new alerts, click ")
                . "<a href='" . Router::url(array('controller' => 'sheetRides', 'action' => 'consumptionAlert'),
                    true) . "'>"
                . " " . __("here") . "</a> " . __("to view it.");
            $users = $this->getUsersReceiveAlert();

            foreach ($users as $user) {
                $Email->addTo($user['User']['email']);
            }
            $Email->template('welcome', 'fancy')
                ->emailFormat('html')
                ->from('alert@utranx.com')
                ->subject('UtranX Alerte');
            try {
                $Email->send($msg);
            } catch (Exception $ex) {
            }
        }
    }

    /* get number of consumption's alerts
    * @param void
    * @return int
    */

    public function showCarsWithCouponConsumptionAlerts($carId = null)
    {
        $activatedAlertCars = $this->SheetRide->getCarsWithCouponConsumptionAlerts($carId);
        if (!empty($activatedAlertCars)) {
            $this->Alert->insertAlerts($activatedAlertCars, ParametersEnum::coupon_consumption, 'Car');
            $Email = new CakeEmail('phpmail');
            $msg = __("You have new alerts, click ")
                . "<a href='" . Router::url(array('controller' => 'sheetRides', 'action' => 'consumptionAlert'),
                    true) . "'>"
                . " " . __("here") . "</a> " . __("to view it.");
            $users = $this->getUsersReceiveAlert();

            foreach ($users as $user) {
                $Email->addTo($user['User']['email']);
            }
            $Email->template('welcome', 'fancy')
                ->emailFormat('html')
                ->from('alert@utranx.com')
                ->subject('UtranX Alerte');
            try {
                $Email->send($msg);
            } catch (Exception $ex) {
            }
        }
    }

    /* get Cars With Coupon Consumption Alert activated
 * @param int|null $carId
 * @return int
 */

    public function verifyStockCouponAlerts()
    {
        $minCouponAlert = $this->Parameter->getParamValByCode(
            ParametersEnum::nb_minimum_bons, array('val')
        );
        $limitedCoupon = $minCouponAlert['Parameter']['val'];

        if ($limitedCoupon) {
            $stockCoupons = $this->Coupon->getMinCouponAlert($limitedCoupon);
            if (!empty($stockCoupons)) {
                $this->Alert->insertAlerts($stockCoupons, ParametersEnum::nb_minimum_bons);
                $Email = new CakeEmail('phpmail');
                $msg = __("Number of coupons is less than ") . $limitedCoupon;
                $users = $this->getUsersReceiveAlert();

                foreach ($users as $user) {
                    $Email->addTo($user['User']['email']);
                }


                $Email->template('welcome', 'fancy')
                    ->emailFormat('html')
                    ->from('alert@utranx.com')
                    ->subject('UtranX Alerte stock bons');
                try {
                    $Email->send($msg);
                } catch (Exception $ex) {
                }
            }
        }

    }


    /* get alert when quantity coupon < limited coupon
    * @param void
    * @return boolean
    */

    public function setProductQuantitySessionAlerts()
    {
        $this->resetAlertProduct();
        $this->getProductQuantityMinAlerts();
        $this->getProductQuantityMaxAlerts();
    }

    /* set technical control alert
* @param void
* return void
*/

    public function resetAlertProduct()
    {
        $products = $this->Product->find('all');
        if (!empty($products)) {
            foreach ($products as $product) {
                $this->Product->id = $product['Product']['id'];
                $this->Product->saveField('alert', 0);
            }
        }
    }

    /* set vignette alert
* @param void
* return void
*/

    public function getProductQuantityMinAlerts()
    {
        $productMins = $this->Product->getProductMin();
        if (!empty($productMins)) {
            $this->Alert->insertAlerts($productMins, ParametersEnum::product_min, 'Product');
        }
    }

    /* set  alert with date
* @param void
* return void
*/

    public function getProductQuantityMaxAlerts()
    {
        $productMaxs = $this->Product->getProductMax();

        if (!empty($productMaxs)) {
            $this->Alert->insertAlerts($productMaxs, ParametersEnum::product_max, 'Product');
        }
    }

    /* set vidange alert
* @param void
* return void
*/

    public function setDriverLicenseAlerts($customerId = null)
    {
        $driverLicenseExpParam = $this->Parameter->getParamValByCode(ParametersEnum::expiration_permis, array('val'));
        $driverLicenseLimitValue = date(
            'Y-m-d H:i:s',
            strtotime('+' . $driverLicenseExpParam['Parameter']['val'] . ' days')
        );

        $driverLicenseAlerts = $this->Customer->getCustomerWithDriverLicenseExpireDate($driverLicenseLimitValue, $customerId);
        if (!empty($driverLicenseAlerts)) {
            $this->Alert->insertAlerts($driverLicenseAlerts, ParametersEnum::expiration_permis, 'Customer');
        }

    }

    public function verifyAttachment(
        $modelName,
        $inputName,
        $path,
        $task,
        $image,
        $picture_car,
        $id = null,
        $isImage = null
    )
    {   
        $path = dirname(__DIR__) . DS . "webroot" . DS . $path; 
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        if (!empty($this->request->data[$modelName][$inputName]['tmp_name'])) {
            $currentDatetime = date("d/m/Y H:i");
            $this->request->data[$modelName]['current_date'] = $currentDatetime;
            $this->createDatetimeFromDatetime($modelName, 'current_date');
            $currentDatetime = $this->request->data[$modelName]['current_date'];
            $ext = substr(strtolower(strrchr($this->request->data[$modelName][$inputName]['name'], '.')), 1);

            $name = substr($this->request->data[$modelName][$inputName]['name'], 0, strlen($this->request->data[$modelName][$inputName]['name']) - strlen($ext) - 1);

            $this->request->data[$modelName][$inputName]['name'] = $name . '-' . $currentDatetime . '.' . $ext;
            if ($isImage != null) {
                $MyImageCom = new ImageComponent();
                $MyImageCom->prepare($this->request->data[$modelName][$inputName]['tmp_name']);
                $MyImageCom->resize(Configure::read('logoWidth'),
                    Configure::read('logoHeight'));//width,height,Red,Green,Blue
                $MyImageCom->save($path . $this->request->data[$modelName][$inputName]['name']);
                $this->request->data[$modelName][$inputName] = $this->request->data[$modelName][$inputName]['name'];
            } else {
                if (is_uploaded_file($this->request->data[$modelName][$inputName]['tmp_name'])) {
                    if ($image) {
                        $filename = $this->request->data[$modelName][$inputName]['tmp_name'];
                        $ext = substr(strtolower(strrchr($this->request->data[$modelName][$inputName]['name'], '.')),
                            1);
                        $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
                        if (in_array($ext, $arr_ext)) {
                            if ($picture_car) {
                                copy($filename, $path . 'size-' . $this->request->data[$modelName][$inputName]['name']);
                                $filename2 = $path . 'size-' . $this->request->data[$modelName][$inputName]['name'];
                                list($width, $height) = getimagesize($filename2);
                                $percent = 1;
                                if ($width >= 300 && $width <= 800) {
                                    $percent = 1;
                                }
                                if ($width >= 800 && $width < 1000) {
                                    $percent = 0.8;
                                }
                                if ($width >= 1000 && $width < 2000) {
                                    $percent = 0.4;
                                }
                                if ($width >= 2000 && $width < 3000) {
                                    $percent = 0.3;
                                }
                                if ($width >= 3000 && $width < 4000) {
                                    $percent = 0.25;
                                }
                                if ($width >= 4000 && $width < 5000) {
                                    $percent = 0.15;
                                }
                                if ($width >= 5000 && $width < 6000) {
                                    $percent = 0.12;
                                }
                                if ($width >= 6000 && $width < 7000) {
                                    $percent = 0.11;
                                }
                                if ($width >= 7000 && $width < 8000) {
                                    $percent = 0.1;
                                }
                                if ($width >= 8000 && $width < 9000) {
                                    $percent = 0.085;
                                }
                                if ($width >= 9000 && $width < 10000) {
                                    $percent = 0.08;
                                }
                                $new_width = $width * $percent;
                                $new_height = $height * $percent;
                                // Redimensionnement
                                ini_set("gd.jpeg_ignore_warning", 1);
                                $image_p = imagecreatetruecolor($new_width, $new_height);
                                switch ($ext) {
                                    case 'png':
                                        $image_new = @imagecreatefrompng($filename2);
                                        break;
                                    case 'jpg' or 'jpeg':

                                        $image_new = @imagecreatefromjpeg($filename2);

                                        break;
                                    case 'gif':
                                        $image_new = @imagecreatefromgif($filename2);
                                        break;
                                }
                                ini_set('gd.jpeg_ignore_warning', 1);
                                if ($image_new) {
                                    // code to resize an image
                                    imagecopyresampled($image_p, $image_new, 0, 0, 0, 0, $new_width, $new_height,
                                        $width, $height);
                                    switch ($ext) {
                                        case 'png':
                                            imagepng($image_p, $filename2);

                                            break;
                                        case 'jpg' or 'jpeg':
                                            imagejpeg($image_p, $filename2);
                                            break;
                                        case 'gif':
                                            imagegif($image_p, $filename2);
                                            break;
                                    }
                                } else {
                                    return false;
                                }
                                // $percent = 0.5;
                                // Calcul des nouvelles dimensions
                                list($width, $height) = getimagesize($filename);
                                if ($width <= 300) {
                                    $percent = 1;
                                }
                                if ($width > 300 && $width <= 500) {
                                    $percent = 0.6;
                                }
                                if ($width > 500 && $width <= 600) {
                                    $percent = 0.5;
                                }
                                if ($width > 600 && $width <= 700) {
                                    $percent = 0.45;
                                }
                                if ($width > 700 && $width <= 800) {
                                    $percent = 0.4;
                                }
                                if ($width > 800 && $width <= 900) {
                                    $percent = 0.37;
                                }
                                if ($width > 900 && $width <= 1000) {
                                    $percent = 0.35;
                                }
                                if ($width > 1000 && $width <= 2000) {
                                    $percent = 0.2;
                                }
                                if ($width > 2000 && $width <= 3000) {
                                    $percent = 0.11;
                                }
                                if ($width > 3000 && $width <= 4000) {
                                    $percent = 0.09;
                                }
                                if ($width > 4000 && $width <= 5000) {
                                    $percent = 0.08;
                                }
                                if ($width > 5000 && $width <= 6000) {
                                    $percent = 0.07;
                                }
                                if ($width > 6000 && $width <= 7000) {
                                    $percent = 0.057;
                                }
                                if ($width > 7000 && $width <= 8000) {
                                    $percent = 0.05;
                                }
                                if ($width > 8000 && $width <= 9000) {
                                    $percent = 0.04;
                                }
                                if ($width > 9000 && $width <= 10000) {
                                    $percent = 0.035;
                                }
                                $new_width = $width * $percent;
                                $new_height = $height * $percent;
                                // Redimensionnement
                                ini_set("gd.jpeg_ignore_warning", 1);
                                $image_p = imagecreatetruecolor($new_width, $new_height);
                                switch ($ext) {
                                    case 'png':
                                        $image_new = @imagecreatefrompng($filename);
                                        break;
                                    case 'jpg' or 'jpeg':
                                        $image_new = @imagecreatefromjpeg($filename);
                                        break;
                                    case 'gif':
                                        $image_new = @imagecreatefromgif($filename);
                                        break;
                                }
                                if ($image_new) {
                                    // code to resize an image
                                    imagecopyresampled($image_p, $image_new, 0, 0, 0, 0, $new_width, $new_height,
                                        $width, $height);
                                    switch ($ext) {
                                        case 'png':
                                            imagepng($image_p, $filename);
                                            break;
                                        case 'jpg' or 'jpeg':
                                            imagejpeg($image_p, $filename);
                                            break;
                                        case 'gif':
                                            imagegif($image_p, $filename);
                                            break;
                                    }
                                } else {
                                    return false;
                                }
                                move_uploaded_file(
                                    $filename,
                                    $path . $this->request->data[$modelName][$inputName]['name']
                                );
                                $this->request->data[$modelName][$inputName] = $this->request->data[$modelName][$inputName]['name'];
                            } else {
                                $filename = $this->request->data[$modelName][$inputName]['tmp_name'];
                                list($width, $height) = getimagesize($filename);
                                $percent = 1;
                                if ($width >= 800 && $width < 1000) {
                                    $percent = 0.8;
                                }
                                if ($width >= 1000 && $width < 2000) {
                                    $percent = 0.4;
                                }
                                if ($width >= 2000 && $width < 3000) {
                                    $percent = 0.3;
                                }
                                if ($width >= 3000 && $width < 4000) {
                                    $percent = 0.25;
                                }
                                if ($width >= 4000 && $width < 5000) {
                                    $percent = 0.15;
                                }
                                if ($width >= 5000 && $width < 6000) {
                                    $percent = 0.12;
                                }
                                if ($width >= 6000 && $width < 7000) {
                                    $percent = 0.11;
                                }
                                if ($width >= 7000 && $width < 8000) {
                                    $percent = 0.1;
                                }
                                if ($width >= 8000 && $width < 9000) {
                                    $percent = 0.085;
                                }
                                if ($width >= 9000 && $width < 10000) {
                                    $percent = 0.08;
                                }
                                $new_width = $width * $percent;
                                $new_height = $height * $percent;


                                // Redimensionnement
                                ini_set("gd.jpeg_ignore_warning", 1);
                                $image_p = imagecreatetruecolor($new_width, $new_height);
                                switch ($ext) {
                                    case 'png':
                                        $image_new = @imagecreatefrompng($filename);

                                        break;
                                    case 'jpg' or 'jpeg':
                                        $image_new = @imagecreatefromjpeg($filename);
                                        break;
                                    case 'gif':
                                        $image_new = @imagecreatefromgif($filename);
                                        break;

                                }

                                if ($image_new) {
                                    // code to resize an image
                                    imagecopyresampled($image_p, $image_new, 0, 0, 0, 0, $new_width, $new_height,
                                        $width, $height);
                                    switch ($ext) {
                                        case 'png':
                                            imagepng($image_p, $filename);
                                            break;
                                        case 'jpg' or 'jpeg':
                                            imagejpeg($image_p, $filename);
                                            break;
                                        case 'gif':
                                            imagegif($image_p, $filename);
                                            break;

                                    }

                                } else {
                                    return false;
                                }
                                move_uploaded_file(
                                    $filename,
                                    $path . $this->request->data[$modelName][$inputName]['name']
                                );

                                $this->request->data[$modelName][$inputName] = $this->request->data[$modelName][$inputName]['name'];
                            }
                        } else {
                            $this->request->data[$modelName][$inputName] = null;
                            $this->Flash->error(__("Only gif, png, jpg and jpeg images are allowed!"));
                            if ($task == "add") {
                                $this->redirect(array('action' => 'add'));
                            } else {
                                $this->redirect(array('action' => 'edit', $id));
                            }
                        }
                    } else { 
                        move_uploaded_file(
                            $this->request->data[$modelName][$inputName]['tmp_name'],
                            $path . $this->request->data[$modelName][$inputName]['name']
                        );
                        $this->request->data[$modelName][$inputName] = $this->request->data[$modelName][$inputName]['name'];
                    }
                }
            }

        } else {
            if ($task == "add") {
                $this->request->data[$modelName][$inputName] = "";
            } else {

                unset($this->request->data[$modelName][$inputName]);
            }
        }
    }

    /* set  alert with km
* @param void
* return void
*/

    public function verifyAttachmentByType(
        $modelName,
        $inputName,
        $path,
        $task,
        $image,
        $picture_car,
        $id = null,
        $isImage = null
    )
    {
        
        $path = dirname(__DIR__) . DS . "webroot" . DS . $path;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if (!empty($this->request->data[$modelName][$inputName]['tmp_name'])) {
            $currentDatetime = date("d/m/Y H:i");
            $this->request->data[$modelName]['current_date'] = $currentDatetime;
            $this->createDatetimeFromDatetime($modelName, 'current_date');
            $currentDatetime = $this->request->data[$modelName]['current_date'];
            $ext = substr(strtolower(strrchr($this->request->data[$modelName][$inputName]['name'], '.')), 1);

            $name = substr($this->request->data[$modelName][$inputName]['name'], 0, strlen($this->request->data[$modelName][$inputName]['name']) - strlen($ext) - 1);

            $this->request->data[$modelName][$inputName]['name'] = $name . '-' . $currentDatetime . '.' . $ext;


            if ($isImage != null) {
                $MyImageCom = new ImageComponent();
                $MyImageCom->prepare($this->request->data[$modelName][$inputName]['tmp_name']);
                $MyImageCom->resize(Configure::read('logoWidth'),
                    Configure::read('logoHeight'));//width,height,Red,Green,Blue

                $MyImageCom->save($path . $this->request->data[$modelName][$inputName]['name']);
                //$this->request->data[$modelName][$inputName] = $this->request->data[$modelName][$inputName]['name'];
                $this->request->data[$modelName]['name'] = $this->request->data[$modelName][$inputName]['name'];

            } else {

                if (is_uploaded_file($this->request->data[$modelName][$inputName]['tmp_name'])) {

                    if ($image) {

                        $filename = $this->request->data[$modelName][$inputName]['tmp_name'];
                        $ext = substr(strtolower(strrchr($this->request->data[$modelName][$inputName]['name'], '.')), 1);
                        $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
                        if (in_array($ext, $arr_ext)) {

                            if ($picture_car) {

                                copy($filename, $path . 'size-' . $this->request->data[$modelName][$inputName]['name']);
                                //copy($filename, $path . $this->request->data[$modelName][$inputName]['name']);

                                $filename2 = $path . 'size-' . $this->request->data[$modelName][$inputName]['name'];
                                list($width, $height) = getimagesize($filename2);
                                $percent = 1;
                                if ($width >= 300 && $width <= 800) {
                                    $percent = 1;
                                }
                                if ($width >= 800 && $width < 1000) {
                                    $percent = 0.8;
                                }
                                if ($width >= 1000 && $width < 2000) {
                                    $percent = 0.4;
                                }
                                if ($width >= 2000 && $width < 3000) {
                                    $percent = 0.3;
                                }
                                if ($width >= 3000 && $width < 4000) {
                                    $percent = 0.25;
                                }
                                if ($width >= 4000 && $width < 5000) {
                                    $percent = 0.15;
                                }
                                if ($width >= 5000 && $width < 6000) {
                                    $percent = 0.12;
                                }
                                if ($width >= 6000 && $width < 7000) {
                                    $percent = 0.11;
                                }
                                if ($width >= 7000 && $width < 8000) {
                                    $percent = 0.1;
                                }
                                if ($width >= 8000 && $width < 9000) {
                                    $percent = 0.085;
                                }
                                if ($width >= 9000 && $width < 10000) {
                                    $percent = 0.08;
                                }
                                $new_width = $width * $percent;
                                $new_height = $height * $percent;


                                // Redimensionnement
                                ini_set("gd.jpeg_ignore_warning", 1);
                                $image_p = imagecreatetruecolor($new_width, $new_height);


                                switch ($ext) {
                                    case 'png':


                                        $image_new = @imagecreatefrompng($filename2);


                                        break;
                                    case 'jpg' or 'jpeg':

                                        $image_new = @imagecreatefromjpeg($filename2);

                                        break;
                                    case 'gif':
                                        $image_new = @imagecreatefromgif($filename2);
                                        break;


                                }

                                ini_set('gd.jpeg_ignore_warning', 1);
                                if ($image_new) {
                                    // code to resize an image
                                    imagecopyresampled($image_p, $image_new, 0, 0, 0, 0, $new_width, $new_height,
                                        $width, $height);

                                    switch ($ext) {

                                        case 'png':
                                            imagepng($image_p, $filename2);

                                            break;
                                        case 'jpg' or 'jpeg':
                                            imagejpeg($image_p, $filename2);
                                            break;
                                        case 'gif':
                                            imagegif($image_p, $filename2);
                                            break;

                                    }

                                } else {
                                    return false;
                                }

                                // $percent = 0.5;
                                // Calcul des nouvelles dimensions
                                list($width, $height) = getimagesize($filename);


                                if ($width <= 300) {
                                    $percent = 1;
                                }
                                if ($width > 300 && $width <= 500) {
                                    $percent = 0.6;
                                }
                                if ($width > 500 && $width <= 600) {
                                    $percent = 0.5;
                                }
                                if ($width > 600 && $width <= 700) {
                                    $percent = 0.45;
                                }
                                if ($width > 700 && $width <= 800) {
                                    $percent = 0.4;
                                }
                                if ($width > 800 && $width <= 900) {
                                    $percent = 0.37;
                                }
                                if ($width > 900 && $width <= 1000) {
                                    $percent = 0.35;
                                }
                                if ($width > 1000 && $width <= 2000) {
                                    $percent = 0.2;
                                }
                                if ($width > 2000 && $width <= 3000) {
                                    $percent = 0.11;
                                }
                                if ($width > 3000 && $width <= 4000) {
                                    $percent = 0.09;
                                }
                                if ($width > 4000 && $width <= 5000) {
                                    $percent = 0.08;
                                }
                                if ($width > 5000 && $width <= 6000) {
                                    $percent = 0.07;
                                }
                                if ($width > 6000 && $width <= 7000) {
                                    $percent = 0.057;
                                }
                                if ($width > 7000 && $width <= 8000) {
                                    $percent = 0.05;
                                }
                                if ($width > 8000 && $width <= 9000) {
                                    $percent = 0.04;
                                }
                                if ($width > 9000 && $width <= 10000) {
                                    $percent = 0.035;
                                }
                                $new_width = $width * $percent;
                                $new_height = $height * $percent;


                                // Redimensionnement
                                ini_set("gd.jpeg_ignore_warning", 1);
                                $image_p = imagecreatetruecolor($new_width, $new_height);
                                switch ($ext) {
                                    case 'png':
                                        $image_new = @imagecreatefrompng($filename);

                                        break;
                                    case 'jpg' or 'jpeg':
                                        $image_new = @imagecreatefromjpeg($filename);
                                        break;
                                    case 'gif':
                                        $image_new = @imagecreatefromgif($filename);
                                        break;
                                }
                                if ($image_new) {
                                    // code to resize an image
                                    imagecopyresampled($image_p, $image_new, 0, 0, 0, 0, $new_width, $new_height,
                                        $width, $height);
                                    switch ($ext) {
                                        case 'png':
                                            imagepng($image_p, $filename);
                                            break;
                                        case 'jpg' or 'jpeg':
                                            imagejpeg($image_p, $filename);
                                            break;
                                        case 'gif':
                                            imagegif($image_p, $filename);
                                            break;
                                    }
                                } else {
                                    return false;
                                }


                                move_uploaded_file(
                                    $filename,
                                    $path . $this->request->data[$modelName][$inputName]['name']
                                );

                                $this->request->data[$modelName][$inputName] = $this->request->data[$modelName][$inputName]['name'];

                            } else {

                                $filename = $this->request->data[$modelName][$inputName]['tmp_name'];

                                list($width, $height) = getimagesize($filename);

                                $percent = 1;

                                if ($width >= 800 && $width < 1000) {
                                    $percent = 0.8;
                                }
                                if ($width >= 1000 && $width < 2000) {
                                    $percent = 0.4;
                                }
                                if ($width >= 2000 && $width < 3000) {
                                    $percent = 0.3;
                                }
                                if ($width >= 3000 && $width < 4000) {
                                    $percent = 0.25;
                                }
                                if ($width >= 4000 && $width < 5000) {
                                    $percent = 0.15;
                                }
                                if ($width >= 5000 && $width < 6000) {
                                    $percent = 0.12;
                                }
                                if ($width >= 6000 && $width < 7000) {
                                    $percent = 0.11;
                                }
                                if ($width >= 7000 && $width < 8000) {
                                    $percent = 0.1;
                                }
                                if ($width >= 8000 && $width < 9000) {
                                    $percent = 0.085;
                                }
                                if ($width >= 9000 && $width < 10000) {
                                    $percent = 0.08;
                                }
                                $new_width = $width * $percent;
                                $new_height = $height * $percent;


                                // Redimensionnement
                                ini_set("gd.jpeg_ignore_warning", 1);
                                $image_p = imagecreatetruecolor($new_width, $new_height);
                                switch ($ext) {
                                    case 'png':
                                        $image_new = @imagecreatefrompng($filename);

                                        break;
                                    case 'jpg' or 'jpeg':
                                        $image_new = @imagecreatefromjpeg($filename);
                                        break;
                                    case 'gif':
                                        $image_new = @imagecreatefromgif($filename);
                                        break;

                                }

                                if ($image_new) {
                                    // code to resize an image
                                    imagecopyresampled($image_p, $image_new, 0, 0, 0, 0, $new_width, $new_height,
                                        $width, $height);
                                    switch ($ext) {
                                        case 'png':
                                            imagepng($image_p, $filename);
                                            break;
                                        case 'jpg' or 'jpeg':
                                            imagejpeg($image_p, $filename);
                                            break;
                                        case 'gif':
                                            imagegif($image_p, $filename);
                                            break;

                                    }

                                } else {
                                    return false;
                                }


                                move_uploaded_file(
                                    $filename,
                                    $path . $this->request->data[$modelName][$inputName]['name']
                                );

                                $this->request->data[$modelName]['name'] = $this->request->data[$modelName][$inputName]['name'];


                            }


                        } else {
                            $this->request->data[$modelName][$inputName] = null;
                            $this->Flash->error(__("Only gif, png, jpg and jpeg images are allowed!"));

                            if ($task == "add") {
                                $this->redirect(array('action' => 'add'));
                            } else {
                                $this->redirect(array('action' => 'edit', $id));
                            }

                        }


                    } else {

                        move_uploaded_file(
                            $this->request->data[$modelName][$inputName]['tmp_name'],
                            $path . $this->request->data[$modelName][$inputName]['name']
                        );
                        $this->request->data[$modelName]['name'] = $this->request->data[$modelName][$inputName]['name'];


                    }


                }
            }
        } else {
            if ($task == "add") {
                $this->request->data[$modelName]['name'] = "";
            } else {

                unset($this->request->data[$modelName]['name']);
            }
        }
    }


    /* create driver license alert  in dashboard
* @param void
* return void
*/

    public function deleteAttachment($modelName, $inputName, $path, $id = null)
    {
        $path = dirname(__DIR__) . DS . "webroot" . DS . $path;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $model = $this->$modelName->find('first', array('conditions' => array($modelName . '.id' => $id)));

        $attach = $model[$modelName][$inputName];

        if (!empty($attach)) {


            if ($dossier = opendir($path)) {
                while (false !== ($fichier = readdir($dossier))) {
                    if ($fichier == $attach) {
                        unlink($path . $attach . '');
                    } // On ferme le if (qui permet de ne pas afficher index.php, etc.)
                }

                closedir($dossier);
            } else {
                echo 'Le dossier n\' a pas pu être ouvert';
            }


        }

    }

    /* create alert with date  in dashboard
* @param void
* return void
*/



    /* create date contract alert  in dashboard
* @param void
* return void
*/

    public function createDatetimeFromDate($modelName, $inputName)
    {
        if (isset($this->request->data[$modelName][$inputName]) && !empty($this->request->data[$modelName][$inputName])) {
            $this->request->data[$modelName][$inputName] = DateTime::createFromFormat('d/m/Y',
                $this->request->data[$modelName][$inputName]);
            if ($this->request->data[$modelName][$inputName] instanceof DateTime) {
                $this->request->data[$modelName][$inputName] = $this->request->data[$modelName][$inputName]->format('Y-m-d-H-i-s');
            } else {
                $this->request->data[$modelName][$inputName] = null;
            }
        } else {
            $this->request->data[$modelName][$inputName] = null;
        }
    }

    /* create km contract alert  in dashboard
* @param void
* return void
*/

    public function createDateFromDate($modelName, $inputName)
    {
        if (isset($this->request->data[$modelName][$inputName]) && !empty($this->request->data[$modelName][$inputName])) {
            $this->request->data[$modelName][$inputName] = DateTime::createFromFormat('d/m/Y',
                $this->request->data[$modelName][$inputName]);
            if ($this->request->data[$modelName][$inputName] instanceof DateTime) {
                $this->request->data[$modelName][$inputName] = $this->request->data[$modelName][$inputName]->format('Y-m-d');
            } else {
                $this->request->data[$modelName][$inputName] = null;
            }
        } else {
            $this->request->data[$modelName][$inputName] = null;
        }
    }


    /* create  alert with km in dashboard
* @param void
* return void
*/

    public function createDateFromDateFormat2($modelName, $inputName)
    {
        if (isset($this->request->data[$modelName][$inputName]) && !empty($this->request->data[$modelName][$inputName])) {
            $this->request->data[$modelName][$inputName] = DateTime::createFromFormat('d-m-Y',
                $this->request->data[$modelName][$inputName]);
            if ($this->request->data[$modelName][$inputName] instanceof DateTime) {
                $this->request->data[$modelName][$inputName] = $this->request->data[$modelName][$inputName]->format('Y-m-d');
            } else {
                $this->request->data[$modelName][$inputName] = null;
            }
        } else {
            $this->request->data[$modelName][$inputName] = null;
        }
    }

    public function createDatetimeFromDatetimeFormat2($modelName, $inputName)
    {
        if (isset($this->request->data[$modelName][$inputName]) && !empty($this->request->data[$modelName][$inputName])) {
            $this->request->data[$modelName][$inputName] = DateTime::createFromFormat('d-m-Y H:i',
                $this->request->data[$modelName][$inputName]);

            if ($this->request->data[$modelName][$inputName] instanceof DateTime) {
                $this->request->data[$modelName][$inputName] = $this->getFormatDatetime($this->request->data[$modelName][$inputName]);
            } else {
                $this->request->data[$modelName][$inputName] = null;
            }
        } else {
            $this->request->data[$modelName][$inputName] = null;
        }
    }

    public function getFormatDatetime($datetime)
    {
        if ($datetime instanceof DateTime) {
            return $datetime->format('Y-m-d-H-i-s');
        } else {
            return null;
        }
    }

    /* create consumption alert  in dashboard
    * @param void
    * return void
    */

    public function createDatetimeFromDateFormat2($modelName, $inputName)
    {
        if (isset($this->request->data[$modelName][$inputName]) && !empty($this->request->data[$modelName][$inputName])) {
            $this->request->data[$modelName][$inputName] = DateTime::createFromFormat('d-m-Y',
                $this->request->data[$modelName][$inputName]);

            if ($this->request->data[$modelName][$inputName] instanceof DateTime) {
                $this->request->data[$modelName][$inputName] = $this->getFormatDatetime($this->request->data[$modelName][$inputName]);
            } else {
                $this->request->data[$modelName][$inputName] = null;
            }
        } else {
            $this->request->data[$modelName][$inputName] = null;
        }
    }

    /* create nb coupon used in consomption alert  in dashboard
* @param void
* return void
*/

    public function setFilterUrl($controller, $action, $keyword)
    {
        $filter_url['controller'] = $controller;
        $filter_url['action'] = $action;
        $filter_url['page'] = 1;
        $filter_url['keyword'] = $keyword;
        return $this->redirect($filter_url);
    }

    /* create coupon alert  in dashboard
* @param void
* return void
*/

    public function getLimit($params = null)
    {
        if (Configure::read("cafyb") == '1') {
            $limit = $this->Session->read('User.limit');
            if (!empty($limit)){
                return $limit;
            }else return 20;
            return $this->Session->read('User.id');

        }else {
            if (isset($params) && is_numeric($params)) {
                $user = $this->User->find('all', array(
                    'recursive' => -1,
                    'conditions' => array('id' => $this->Session->read('Auth.User.id'))
                ));
                $user[0]['User']['limit'] = $params;
                if ($params > 20) {
                    unset($user[0]['User']['password']);
                    $this->User->save($user[0]);
                }
                return $params;
            } else {
                $user = $this->User->find('all', array(
                    'recursive' => -1,
                    'conditions' => array('id' => $this->Session->read('Auth.User.id'))
                ));
                if (!empty($user[0]['User']['limit'])) {
                    return $user[0]['User']['limit'];
                } else {
                    return 20;
                }
            }
        }




    }


    /* verify extension of attachment and upload it
* @param $modelName, $inputName, $path, $task, $image, $picture_car, $id , $isImage
* return void

*/

    /**
     * Set product qte (min or max) alert
     * @param int $product_id
     * @param tinyint $quantityMinOrMax 0: product qte min, 1:  product qte max
     */
    public function updateAlertProduct($product_id, $quantityMinOrMax = null)
    {
        $product = $this->Product->find('all', array(
            'recursive' => -1,
            'conditions' => array('id' => (int)$product_id)
        ));
        if (!empty($product)) {
            if ($quantityMinOrMax == 0) {
                $this->Product->id = $product_id;
                //0 : no alert, 1: alert min actived, 2: alert max actived
                $this->Product->saveField('alert', 1);
            }

            if ($quantityMinOrMax == 1) {
                $this->Product->id = $product_id;
                //0 : no alert, 1: alert min activated, 2: alert max activated
                $this->Product->saveField('alert', 2);
            }

        }

    }

    /**
     * get version of application local or web
     * @param void
     * @return array $users
     */
    public function getVersionOfApp()
    {
        $option = $this->Option->find('first', array('conditions' => array('name' => 'version')));
        $version = $option['Option']['val'];

        return $version;
    }

    /* delete attachment in folder
* @param $modelName, $inputName, $path, $id
* return void
*/

    /**
     * verify if customer is also customer I2B
     * @param void
     * @return array $users
     */
    public function isCustomerI2B()
    {
        $option = $this->Option->find('first', array('conditions' => array('name' => 'use_i2b')));
        $version = $option['Option']['val'];
        return $version;
    }

    /**
     * verify if customer is also customer I2B
     * @param void
     * @return array $users
     */
    public function hasModuleTresorerie()
    {
        $tresorerie = Configure::read("tresorerie");;
        return $tresorerie;
    }


    /* change format of date 'd/m/Y' to 'Y-m-d-H-i-s' format
    * @param $modelName, $inputName
    * return void
    */

    public function hasSaleModule()
    {
        $hasSaleModule = Configure::read("gestion_commercial");

        return $hasSaleModule;
    }

    public function hasStandardSaleModule()
    {
        $hasStandardSaleModule = Configure::read("gestion_commercial_standard");

        return $hasStandardSaleModule;
    }


    /* change format of date 'd/m/Y' to 'Y-m-d' format
* @param $modelName, $inputName
* return void
*/

    public function hasModuleStock()
    {
        $stock = Configure::read("stock");
        return $stock;
    }

    public function hasModuleOffShore()
    {
        $offShore = Configure::read("sous_traitance");
        return $offShore;
    }

    public function hasModulePlanification()
    {
        $planification = Configure::read("planification");
        return $planification;
    }

    /**
     * Set the last car used in consumption and event by user
     * @param $car_id
     * @return void
     */
    public function setCarPersistence($car_id)
    {
        if (!empty($car_id)) {
            $user = $this->User->find('all', array(
                'recursive' => -1,
                'conditions' => array('id' => $this->Session->read('Auth.User.id'))
            ));
            $user[0]['User']['car_id'] = $car_id;
            unset($user[0]['User']['password']);
            $this->User->save($user[0]);
        }
    }

    /* change format of date 'd/m/Y H:i' to 'Y-m-d-H-i' format
* @param $modelName, $inputName
* return void
*/

    /**
     * get the last car used in consumption and event by user
     * @param void
     * @return car_id
     */
    public function getCarPersistence()
    {
        $user = $this->User->find('all', array(
            'recursive' => -1,
            'conditions' => array('id' => $this->Session->read('Auth.User.id'))
        ));
        return $user[0]['User']['car_id'];
    }

    /* change format of date 'd-m-Y H:i' to 'Y-m-d-H-i' format
* @param $modelName, $inputName
* return void
*/

    function encrypt($data)
    {
        return base64_encode(base64_encode(base64_encode(strrev($data))));
    }

    function decrypt($data)
    {
        return strrev(base64_decode(base64_decode(base64_decode($data))));
    }

    /**
     * change date format 'd/m/Y' to format 'Y-m-d-H-i-s'
     * @param date $value
     * @return date $result
     */
    public function getDatetimeFromDate($value)
    {
        if (!empty($value)) {
            $result = DateTime::createFromFormat('d/m/Y', $value);
            if ($result instanceof DateTime) {
                $result = $result->format('Y-m-d-H-i-s');
            } else {
                $result = null;
            }
        } else {
            $result = null;
        }
        return $result;
    }

    /**
     *
     * @param int $value : 1 : lock, 2 unlock
     * @return bool $result
     */
    function setLocked($model, $id, $value)
    {

        $item = $this->$model->find('first', array(
            'recursive' => -1,
            'conditions' => array('id' => $id)
        ));
        if (!empty($item)) {
            $this->$model->id = $id;
            $this->$model->saveField('locked', $value);
            return true;
        } else {
            return false;
        }
    }

    function amortization($id_car)
    {
        $car = $this->Car->find('all', array(
            'recursive' => -1,
            'conditions' => array('id' => $id_car)
        ));
        $val = 0;
        if (!empty($car)) {
            $nb_year = $car[0]['Car']['nb_year_amortization'];
            $purchase_date = $car[0]['Car']['purchase_date'];
            $amount = $car[0]['Car']['amortization_amount'];
        }
        $date1 = $purchase_date;
        $current_date = date("Y-m-d");
        for ($i = 1; $i <= $nb_year; $i++) {
            $date2 = date("Y-m-d", strtotime('+' . $i . 'year', strtotime($date1)));
            $pourcentage = (100 / $nb_year) * $i;

            if (($date1 <= $current_date) && ($current_date <= $date2)) {
                $amortization = ($amount * $pourcentage) / 100;
                $val = $pourcentage . '% ' . ' ( ' . number_format($amortization, 2, ",",
                        ".") . $this->Session->read("currency") . ' )';

            }
            $date1 = $date2;
        }
        return $val;
    }

    function updateCarsStatues()
    {
        $cars = $this->Car->find('all', array(
            'recursive' => -1,
            'fields' => array('id', 'car_status_id'),
            'conditions' => array('OR' => array('Car.car_category_id !=' => 3,
                'Car.car_category_id' => null))
        ));

        $currentDate = date("Y-m-d H:i");

        foreach ($cars as $car) {


            $CarsReserved = $this->CustomerCar->find('all', array(
                'conditions' => array(
                    'CustomerCar.car_id' => $car['Car']['id'],
                    'CustomerCar.validated' => 1,
                    'start <=' => $currentDate,
                    'end >=' => $currentDate,
                    'end_real IS NULL',
                    'Car.car_status_id' => 1,

                ),
                'recursive' => -1,
                'fields' => array(
                    'CustomerCar.car_id',
                    'CustomerCar.validated',
                    'CustomerCar.start',
                    'CustomerCar.end',
                    'CustomerCar.end_real',
                    'Car.car_status_id',

                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.car_id = Car.id')
                    ),
                )
            ));

            if (!empty($CarsReserved)) {

                $this->Car->id = $car['Car']['id'];
                $this->Car->saveField('car_status_id', 6);
            }


            $CarReserved = $this->CustomerCar->find('all', array(
                'conditions' => array(
                    'CustomerCar.car_id' => $car['Car']['id'],
                    'CustomerCar.validated' => 1,
                    'start <=' => $currentDate,
                    'end IS NULL',
                    'Car.car_status_id' => 1
                ),
                'recursive' => -1,
                'fields' => array(
                    'CustomerCar.car_id',
                    'CustomerCar.validated',
                    'CustomerCar.start',
                    'CustomerCar.end',
                    'CustomerCar.end_real',
                    'Car.car_status_id',

                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.car_id = Car.id')
                    ),
                )

            ));


            if (!empty($CarReserved)) {

                $this->Car->id = $car['Car']['id'];
                $this->Car->saveField('car_status_id', 6);
            }
            $CarsReserved = $this->CustomerCar->find('all', array(
                'conditions' => array(
                    'CustomerCar.car_id' => $car['Car']['id'],
                    'CustomerCar.validated' => 1,
                    'start is null',
                    'Car.car_status_id' => 1
                ),
                'recursive' => -1,
                'fields' => array(
                    'CustomerCar.car_id',
                    'CustomerCar.validated',
                    'CustomerCar.start',
                    'CustomerCar.end',
                    'CustomerCar.end_real',
                    'Car.car_status_id',

                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.car_id = Car.id')
                    ),
                )

            ));


            if (!empty($CarsReserved)) {


                $this->Car->id = $car['Car']['id'];
                $this->Car->saveField('car_status_id', 6);
            }
            $CarsAvailable = $this->CustomerCar->find('all', array(
                'conditions' => array(
                    'CustomerCar.car_id' => $car['Car']['id'],
                    'CustomerCar.validated' => 1,
                    'end_real <' => $currentDate,
                    'Car.car_status_id' => 6
                ),
                'recursive' => -1,
                'fields' => array(
                    'CustomerCar.car_id',
                    'CustomerCar.validated',
                    'CustomerCar.start',
                    'CustomerCar.end',
                    'CustomerCar.end_real',
                    'Car.car_status_id',

                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.car_id = Car.id')
                    ),
                )


            ));
            $CarReserved = $this->CustomerCar->find('all', array(
                'conditions' => array(
                    'CustomerCar.car_id' => $car['Car']['id'],
                    'CustomerCar.validated' => 1,
                    'end_real is NULL',
                    'Car.car_status_id' => 6
                ),
                'recursive' => -1,
                'fields' => array(
                    'CustomerCar.car_id',
                    'CustomerCar.validated',
                    'CustomerCar.start',
                    'CustomerCar.end',
                    'CustomerCar.end_real',
                    'Car.car_status_id',

                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.car_id = Car.id')
                    ),
                )

            ));
            $CarReserved1 = $this->CustomerCar->find('all', array(
                'conditions' => array(
                    'CustomerCar.car_id' => $car['Car']['id'],
                    'CustomerCar.validated' => 1,
                    'start <=' => $currentDate,
                    'end_real IS NULL',
                    'Car.car_status_id' => 6
                ),
                'recursive' => -1,
                'fields' => array(
                    'CustomerCar.car_id',
                    'CustomerCar.validated',
                    'CustomerCar.start',
                    'CustomerCar.end',
                    'CustomerCar.end_real',
                    'Car.car_status_id',

                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.car_id = Car.id')
                    ),
                )
            ));
            $CarReserved2 = $this->CustomerCar->find('all', array(
                'conditions' => array(
                    'CustomerCar.car_id' => $car['Car']['id'],
                    'CustomerCar.validated' => 1,
                    'start >=' => $currentDate,
                    'end_real IS NULL',
                    'Car.car_status_id' => 6
                ),
                'recursive' => -1,
                'fields' => array(
                    'CustomerCar.car_id',
                    'CustomerCar.validated',
                    'CustomerCar.start',
                    'CustomerCar.end',
                    'CustomerCar.end_real',
                    'Car.car_status_id',

                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.car_id = Car.id')
                    ),
                )
            ));

            if ((!empty($CarsAvailable) && empty($CarReserved1) && empty($CarReserved)) || !empty($CarReserved2)) {


                $this->Car->id = $car['Car']['id'];
                $this->Car->saveField('car_status_id', 1);
            }

        }

    }

    function updateRemorquesStatues()
    {
        $this->setTimeActif();
        $cars = $this->Car->find('all', array(
            'recursive' => -1,
            'fields' => array('id', 'car_status_id'),
            'conditions' => array('Car.car_category_id ' => 3)
        ));

        date_default_timezone_set("Africa/Algiers");
        $current_date = date("Y-m-d H:i");

        foreach ($cars as $car) {
            // $car ['Car']['id']
            //$this->CustomerCar->recursive=2;
            $CarsReserved = $this->CustomerCar->find('all', array(
                'conditions' => array(
                    'CustomerCar.remorque_id' => $car['Car']['id'],
                    'CustomerCar.validated' => 1,
                    'start <=' => $current_date,
                    'end >=' => $current_date,
                    'end_real IS NULL',
                    'Car.car_status_id' => 1,

                ),
                'recursive' => -1,
                'fields' => array(
                    'CustomerCar.remorque_id',
                    'CustomerCar.validated',
                    'CustomerCar.start',
                    'CustomerCar.end',
                    'CustomerCar.end_real',
                    'Car.car_status_id',

                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.remorque_id = Car.id')
                    ),
                )
            ));

            if (!empty($CarsReserved)) {

                $this->Car->id = $car['Car']['id'];
                $this->Car->saveField('car_status_id', 6);
            }


            $CarReserved = $this->CustomerCar->find('all', array(
                'conditions' => array(
                    'CustomerCar.remorque_id' => $car['Car']['id'],
                    'CustomerCar.validated' => 1,
                    'start <=' => $current_date,
                    'end IS NULL',
                    'Car.car_status_id' => 1
                ),
                'recursive' => -1,
                'fields' => array(
                    'CustomerCar.remorque_id',
                    'CustomerCar.validated',
                    'CustomerCar.start',
                    'CustomerCar.end',
                    'CustomerCar.end_real',
                    'Car.car_status_id',

                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.remorque_id = Car.id')
                    ),
                )

            ));


            if (!empty($CarReserved)) {

                $this->Car->id = $car['Car']['id'];
                $this->Car->saveField('car_status_id', 6);
            }
            $CarsReserved = $this->CustomerCar->find('all', array(
                'conditions' => array(
                    'CustomerCar.remorque_id' => $car['Car']['id'],
                    'CustomerCar.validated' => 1,
                    'start is null',
                    'Car.car_status_id' => 1
                ),
                'recursive' => -1,
                'fields' => array(
                    'CustomerCar.remorque_id',
                    'CustomerCar.validated',
                    'CustomerCar.start',
                    'CustomerCar.end',
                    'CustomerCar.end_real',
                    'Car.car_status_id',

                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.remorque_id = Car.id')
                    ),
                )

            ));


            if (!empty($CarsReserved)) {


                $this->Car->id = $car['Car']['id'];
                $this->Car->saveField('car_status_id', 6);
            }
            $CarsAvailable = $this->CustomerCar->find('all', array(
                'conditions' => array(
                    'CustomerCar.remorque_id' => $car['Car']['id'],
                    'CustomerCar.validated' => 1,
                    'end_real <' => $current_date,
                    'Car.car_status_id' => 6
                ),
                'recursive' => -1,
                'fields' => array(
                    'CustomerCar.remorque_id',
                    'CustomerCar.validated',
                    'CustomerCar.start',
                    'CustomerCar.end',
                    'CustomerCar.end_real',
                    'Car.car_status_id',

                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.remorque_id = Car.id')
                    ),
                )


            ));
            $CarReserved = $this->CustomerCar->find('all', array(
                'conditions' => array(
                    'CustomerCar.remorque_id' => $car['Car']['id'],
                    'CustomerCar.validated' => 1,
                    'end_real is NULL',
                    'Car.car_status_id' => 6
                ),
                'recursive' => -1,
                'fields' => array(
                    'CustomerCar.remorque_id',
                    'CustomerCar.validated',
                    'CustomerCar.start',
                    'CustomerCar.end',
                    'CustomerCar.end_real',
                    'Car.car_status_id',

                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.remorque_id = Car.id')
                    ),
                )

            ));
            $CarReserved1 = $this->CustomerCar->find('all', array(
                'conditions' => array(
                    'CustomerCar.remorque_id' => $car['Car']['id'],
                    'CustomerCar.validated' => 1,
                    'start <=' => $current_date,
                    'end_real IS NULL',
                    'Car.car_status_id' => 6
                ),
                'recursive' => -1,
                'fields' => array(
                    'CustomerCar.remorque_id',
                    'CustomerCar.validated',
                    'CustomerCar.start',
                    'CustomerCar.end',
                    'CustomerCar.end_real',
                    'Car.car_status_id',

                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.remorque_id = Car.id')
                    ),
                )
            ));
            $CarReserved2 = $this->CustomerCar->find('all', array(
                'conditions' => array(
                    'CustomerCar.remorque_id' => $car['Car']['id'],
                    'CustomerCar.validated' => 1,
                    'start >=' => $current_date,
                    'end_real IS NULL',
                    'Car.car_status_id' => 6
                ),
                'recursive' => -1,
                'fields' => array(
                    'CustomerCar.remorque_id',
                    'CustomerCar.validated',
                    'CustomerCar.start',
                    'CustomerCar.end',
                    'CustomerCar.end_real',
                    'Car.car_status_id',

                ),
                'joins' => array(
                    array(
                        'table' => 'car',
                        'type' => 'left',
                        'alias' => 'Car',
                        'conditions' => array('CustomerCar.remorque_id = Car.id')
                    ),
                )
            ));

            if ((!empty($CarsAvailable) && empty($CarReserved1) && empty($CarReserved)) || !empty($CarReserved2)) {


                $this->Car->id = $car['Car']['id'];
                $this->Car->saveField('car_status_id', 1);
            }

        }

    }

    /**
     * Saves the last time the user was active
     *
     * @param void
     *
     * @return void
     */
    public function setTimeActif()
    {
        $user = $this->User->find(
            'all',
            array(
                'fields' => array('id'),
                'conditions' => array('User.id' => $this->Session->read('Auth.User.id')),
                'recursive' => -1
            )
        );
        if (!empty($user)) {
            $this->User->id = $this->Session->read('Auth.User.id');
            $this->User->saveField('time_actif', date('Y-m-d H:i'));
        }
    }

    /**
     * Update car's in mission value
     * @param void
     *
     * @return void
     */
    function updateCarsMission()
    {
        // get all reserved cars
        $cars = $this->Car->find(
            'all',
            array(
                'recursive' => -1,
                'fields' => array('id'),
                'conditions' => array('car_status_id' => array(1, 6))
            )
        );
        foreach ($cars as $car) {

            $this->Car->id = $car['Car']['id'];

            $sheetRidesMission = $this->SheetRide->find(
                'all',
                array(
                    'fields' => array('SheetRide.status_id'),
                    'recursive' => -1,
                    'conditions' => array('SheetRide.car_id' => $car['Car']['id'], 'SheetRide.status_id' => array(2, 3))
                )
            );

            if (!empty($sheetRidesMission)) {

                if ($sheetRidesMission[0]['SheetRide']['status_id'] == 2) {
                    // en mission
                    $this->Car->saveField('in_mission', 1);
                } else {
                    // retour au parc
                    $this->Car->saveField('in_mission', 2);
                }
            } else {
                // au parc
                $this->Car->saveField('in_mission', 0);
            }
        }


    }

    function updateCustomersMission()
    {
        $this->setTimeActif();
        // get all reserved cars
        $customers = $this->Customer->find('all', array('recursive' => -1, 'fields' => array('id', 'in_mission')));
        foreach ($customers as $customer) {

            $sheetRidesMission = $this->SheetRide->find('all', array(
                'fields' => array('SheetRide.status_id'),
                'recursive' => -1,
                'conditions' => array(
                    'SheetRide.customer_id' => $customer['Customer']['id'],
                    'SheetRide.status_id' => array(2, 3)
                )
            ));

            if (!empty($sheetRidesMission)) {

                $this->Customer->id = $customer['Customer']['id'];
                $this->Customer->saveField('in_mission', 1);
            }

            $sheetRidesPlanified = $this->SheetRide->find('all', array(
                'fields' => array('SheetRide.status_id'),
                'recursive' => -1,
                'conditions' => array(
                    'SheetRide.customer_id' => $customer['Customer']['id'],
                    'SheetRide.status_id' => 1
                )
            ));


            if (!empty($sheetRidesPlanified)) {

                $this->Customer->id = $customer['Customer']['id'];
                $this->Customer->saveField('in_mission', 2);
            }

            if (empty($sheetRidesPlanified) && empty($sheetRidesMission)) {
                $this->Customer->id = $customer['Customer']['id'];
                $this->Customer->saveField('in_mission', 0);
            }
        }


    }

    public function ProductDepot()
    {
        $parameter = $this->Parameter->getParamValByCode(ParametersEnum::depots, array('depot'));

        if (!empty($parameter)) {
            $depot = $parameter['Parameter']['depot'];
            $this->Session->write("Parameter.depot", $depot);


        }
    }

    public function pictureAuthUser()
    {
        $user_id = $this->Session->read('Auth.User.id');

        $user = $this->User->find('first', array('conditions' => array('User.id' => $user_id), 'recursive' => -1));


        $picture = $user['User']['picture'];


        $this->Session->write("User.picture", $picture);

    }

    public function calcul_pmp($productId = null)
    {
        $this->loadModel('BillProduct');
        $billProducts = $this->BillProduct->find('all', array(
            'conditions' => array('BillProduct.lot_id' => $productId, 'Bill.type' => 2),
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'bills',
                    'type' => 'left',
                    'alias' => 'Bill',
                    'conditions' => array('Bill.id = BillProduct.bill_id')
                ),
            )
        ));
        if (!empty($billProducts)) {
            $quantity = 0;
            $price_quantity = 0;
            foreach ($billProducts as $billProduct) {
                $quantity = $quantity + $billProduct['BillProduct']['quantity'];
                $price_quantity = $price_quantity + $billProduct['BillProduct']['price_ht'];

            }

            $pmp = $price_quantity / $quantity;
            $pmp = round($pmp, 2);

        }
        return $pmp;


    }

    public function downloadDb()
    {


        $fields = get_class_vars('DATABASE_CONFIG');
        $host = $fields['default']['host'];
        $port = $fields['default']['port'];
        $user = $fields['default']['login'];
        $pass = $fields['default']['password'];
        $name = $fields['default']['database'];
        $tables = '*';
        $connection = mysqli_connect($host . ':' . $port, $user, $pass);
        if (!$connection) {
            die("Database connection failed: " . mysqli_connect_error());
        }
        $db_select = mysqli_select_db($connection, $name);
        if (!$db_select) {
            die("Database selection failed: " . mysqli_error($connection));
        }

        $tables = array();
        $result = mysqli_query($connection, 'SHOW TABLES');
        while ($row = mysqli_fetch_row($result)) {

            $tables[] = $row[0];
        }

        $return = '';
        //cycle through
        foreach ($tables as $table) {
            $result = mysqli_query($connection, 'SELECT * FROM ' . $table);
            $num_fields = mysqli_num_fields($result);

            $return .= 'DROP TABLE ' . $table . ';';
            $row2 = mysqli_fetch_row(mysqli_query($connection, 'SHOW CREATE TABLE ' . $table));
            $return .= "\n\n" . $row2[1] . ";\n\n";
            for ($i = 0; $i < $num_fields; $i++) {
                while ($row = mysqli_fetch_row($result)) {
                    $return .= 'INSERT INTO ' . $table . ' VALUES(';
                    for ($j = 0; $j < $num_fields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = preg_replace("/\n/", "\\n", $row[$j]);
                        if (isset($row[$j])) {
                            $return .= '"' . $row[$j] . '"';
                        } else {
                            $return .= '""';
                        }
                        if ($j < ($num_fields - 1)) {
                            $return .= ',';
                        }
                    }
                    $return .= ");\n";
                }
            }
            $return .= "\n\n\n";
        }
        $fl = date("l") . '.sql';
        $dossier = 'SAVE_BDD/' . $name;
        if (is_dir($dossier)) {

        } else {
            mkdir($dossier);
        }
        $handle = fopen('SAVE_BDD/' . $name . '/' . $fl, 'w+');
        fwrite($handle, $return);
        fclose($handle);
        $this->set('fl', $fl);
        $this->set('name', $name);

    }

    public function getPassword()
    {

        $user = $this->User->find('first',
            array('conditions' => array('User.id' => $this->Session->read('Auth.User.id')), 'recursive' => -1));
        if (!empty($user)) {
            $password = $user['User']['secret_password'];

            return $password;
        }
    }

    public function consumptionManagement()
    {

        $param = $this->Parameter->getParamValByCode(
            ParametersEnum::codes,
            array('consumption_coupon', 'consumption_spacies', 'consumption_tank', 'consumption_card')
        );
        $param_array = array();
        $param_array[0] = $param['Parameter']['consumption_coupon'];
        $param_array[1] = $param['Parameter']['consumption_spacies'];
        $param_array[2] = $param['Parameter']['consumption_tank'];
        $param_array[3] = $param['Parameter']['consumption_card'];
        return $param_array;


    }

    public function getAffectationMode()
    {
        $param = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('affectation_mode'));
        $affectation_mode = $param['Parameter']['affectation_mode'];

        return $affectation_mode;
    }

    /**
     * Know if we use car balance
     * @return boolean $balance_car
     */
    public function isBalanceCarUsed()
    {
        $param = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('balance_car'));
        $balance_car = $param['Parameter']['balance_car'];

        return $balance_car;
    }

    public function priority()
    {
        $param_priority = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('priority'));
        $priority = explode(',', $param_priority['Parameter']['priority']);

        return $priority;
    }

    /**
     * Get necessary params of sheet ride
     * @return array $param_sheet_ride Array containing the necessary params of sheet ride
     *    $params = [
     *      'param_marchandise'     => (smallint) has marchandises ?. 1 or 0.
     *      'param_price' => (smallint) may be paid in prefacture ?. 1 or 0.
     *    ]
     */
    public function param_sheet_ride()
    {

        $param = $this->Parameter->getParamValByCode(
            ParametersEnum::codes,
            array('nb_ride', 'param_marchandise', 'param_price')
        );
        $param_sheet_ride = array();
        $param_sheet_ride[0] = $param['Parameter']['nb_ride'];
        $param_sheet_ride[1] = $param['Parameter']['param_marchandise'];
        $param_sheet_ride[2] = $param['Parameter']['param_price'];

        return $param_sheet_ride;
    }

    /**
     * Known if we can pay a pre invoice
     * @return tinyint $settleMissions 0 or 1
     */
    public function abilityToSettleMissions()
    {
        $param = $this->Parameter->getParamValByCode(
            ParametersEnum::codes,
            array('param_price')
        );
        $settleMissions = $param['Parameter']['param_price'];
        return $settleMissions;
    }

    public function reports($id = null)
    {

        $report = $this->Report->find('first', array('conditions' => array('id' => $id), 'fields' => array('val')));
        return $report['Report']['val'];

    }

    /**
     * Verify if number of cars is < max cars authorized
     * @param int $nb_cars
     * @return void
     */

    public function verifyMaxCars($nb_cars)
    {


        $max_cars = Configure::read("nbCars");

        if ($nb_cars >= $max_cars) {
            $this->Flash->error(__("You don't have permission to add more than ") .
                " " . $max_cars . " " . __('cars'));
            $this->redirect(array('controller' => "cars", 'action' => 'index'));
        }
    }


    public function getSeparatorAmount()
    {


        $param = $this->Parameter->getParamValByCode(
            ParametersEnum::codes,
            array('separator_amount')
        );

        $paramSeparatorAmount = $param['Parameter']['separator_amount'];
        $separatorAmount = '.';

        if (!empty($paramSeparatorAmount)) {
            switch ($paramSeparatorAmount) {

                case 1 :
                    $separatorAmount = ' ';
                    break;
                case 2 :
                    $separatorAmount = ',';
                    break;
                case 3 :
                    $separatorAmount = '.';
                    break;
                default :
                    $separatorAmount = '.';
            }
        }

        return $separatorAmount;
    }

    public function getMethodToSelectCoupons()
    {
        $param = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('select_coupon'));
        $selectCoupon = $param['Parameter']['select_coupon'];
        return $selectCoupon;
    }

    // Function for encryption

    /**
     * Verify if we have single or multiple choices in consumption
     * @return tinyint 1 or 0
     */
    public function isPriorityUsed()
    {
        $param = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('use_priority'));
        $usePriority = $param['Parameter']['use_priority'];
        return $usePriority;
    }

    // Function for decryption

    public function isDisplayMissionCost()
    {
        $parameter = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('display_mission_cost'));
        $displayMissionCost = $parameter['Parameter']['display_mission_cost'];
        return $displayMissionCost;
    }

    public function getManagementParameterMissionCost()
    {
        $parameter = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('param_mission_cost'));
        $managementParameterMissionCost = $parameter['Parameter']['param_mission_cost'];
        return $managementParameterMissionCost;
    }

    public function getParamMissionCostByDay()
    {
        $param = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('mission_cost_day'));
        $paramMissionCost = array();
        $paramMissionCost['mission_cost_day'] = $param['Parameter']['mission_cost_day'];
        return $paramMissionCost;
    }

    /** Update sheet ride or sheet ride detail rides (missions) statuses
     * @param null $start_date
     * @param null $end_date
     * @param null $sheetOrDetailSheet
     * @return int
     */
    public function updateStatusSheet($start_date = null, $end_date = null, $sheetOrDetailSheet = null)
    {
        date_default_timezone_set("Africa/Algiers");
        $current_date = date("d/m/Y H:i");

        $this->request->data['SheetRide']['current_date'] = $current_date;
        $this->createDatetimeFromDatetime('SheetRide', 'current_date');

        $current_date = $this->request->data['SheetRide']['current_date'];
        if (!empty($end_date)) {

            if ($end_date <= $current_date) {
                /* on a besoin de  $sheetOrDetailSheet pour faire la différence entre feuille de route ou mission
                si 1 : feuille de route
                 0 : mission
                */
                if ($sheetOrDetailSheet == 1) {
                    $status = 4;
                } else {
                    $status = 3;
                }
            } else {
                if (!empty($start_date)) {
                    if ($start_date <= $current_date) {
                        $status = 2;
                    } else {
                        $status = 1;
                    }
                } else {
                    $status = 1;
                }
            }
        } else {
            if (!empty($start_date)) {
                if ($start_date <= $current_date) {
                    $status = 2;
                } else {
                    $status = 1;
                }
            } else {
                $status = 1;
            }

        }

        return $status;
    }

    public function createDatetimeFromDatetime($modelName, $inputName)
    {
        if (isset($this->request->data[$modelName][$inputName]) && !empty($this->request->data[$modelName][$inputName])) {
            $this->request->data[$modelName][$inputName] = DateTime::createFromFormat('d/m/Y H:i',
                $this->request->data[$modelName][$inputName]);

            if ($this->request->data[$modelName][$inputName] instanceof DateTime) {
                $this->request->data[$modelName][$inputName] = $this->getFormatDatetime($this->request->data[$modelName][$inputName]);
            } else {
                $this->request->data[$modelName][$inputName] = null;
            }
        } else {
            $this->request->data[$modelName][$inputName] = null;
        }
    }

    public function createDateFromDatetime($modelName, $inputName)
    {
        if (isset($this->request->data[$modelName][$inputName]) && !empty($this->request->data[$modelName][$inputName])) {
            $this->request->data[$modelName][$inputName] = DateTime::createFromFormat('d/m/Y H:i',
                $this->request->data[$modelName][$inputName]);

            if ($this->request->data[$modelName][$inputName] instanceof DateTime) {
                $this->request->data[$modelName][$inputName] = $this->request->data[$modelName][$inputName]->format('Y-m-d');
            } else {
                $this->request->data[$modelName][$inputName] = null;
            }
        } else {
            $this->request->data[$modelName][$inputName] = null;
        }
    }

    /**
     * function get reporting choosed
     * 1: pdf
     * 2: crystal reports
     */
    public function reportingChoosed()
    {
        $param = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('choice_reporting'));
        $reportingChoosed = $param['Parameter']['choice_reporting'];
        return $reportingChoosed;

    }

    public function useRideCategory()
    {
        $param = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('use_ride_category'));
        $useRideCategory = $param['Parameter']['use_ride_category'];

        return $useRideCategory;
    }
    public function isMultiWarehouses()
    {
        $param = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('is_multi_warehouses'));
        $isMultiWarehouses = $param['Parameter']['is_multi_warehouses'];
        $this->Session->write('multiWarehouses', $isMultiWarehouses);

        return $isMultiWarehouses;
    }

    public function getTimeParametersToCalculateArrivalDate()
    {
        $timeParameters = array();
        $param = $this->Parameter->getParamValByCode(
            ParametersEnum::codes,
            array(
                'loading_time',
                'unloading_time',
                'maximum_driving_time',
                'break_time',
                'additional_time_allowed'
            )
        );
        $timeParameters['loading_time'] = $param['Parameter']['loading_time'];
        $timeParameters['unloading_time'] = $param['Parameter']['unloading_time'];
        $timeParameters['maximum_driving_time'] = $param['Parameter']['maximum_driving_time'];
        $timeParameters['break_time'] = $param['Parameter']['break_time'];
        $timeParameters['additional_time_allowed'] = $param['Parameter']['additional_time_allowed'];

        return $timeParameters;

    }

    public function getNameSheetRide()
    {
        $param = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('sheet_ride_name'));
        $nameSheetRide = $param['Parameter']['sheet_ride_name'];

        $this->Session->write("nameSheetRide", $nameSheetRide);
        return $nameSheetRide;
    }
    public function isDestinationRequired()
    {
        $param = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('destination_required'));
        $destinationRequired = $param['Parameter']['destination_required'];
        return $destinationRequired;
    }

    function getPriceRide($rideId = null, $clientId = null, $rideCategoryId = null)
    {
        $this->loadModel('Price');
        $price = $this->Price->find(
            'first',
            array(
                'conditions' => array(
                    'Price.detail_ride_id' => $rideId,
                    'Price.supplier_id' => $clientId,
                    'PriceRideCategory.ride_category_id' => $rideCategoryId
                ),
                'joins' => array(

                    array(
                        'table' => 'price_ride_categories',
                        'type' => 'left',
                        'alias' => 'PriceRideCategory',
                        'conditions' => array('PriceRideCategory.price_id = Price.id')
                    ),
                ),
                'recursive' => -1,
                'fields' => array(
                    'PriceRideCategory.price_ht',
                    'PriceRideCategory.id',
                    'PriceRideCategory.price_return'
                )
            ));
        if (!empty($price)) {
            $price[0] = $price['PriceRideCategory']['price_ht'];
            $price[1] = $price['PriceRideCategory']['id'];
            $price[2] = $price['PriceRideCategory']['price_return'];
            //return $price;

            $this->set('price', $price);
        } else {
            $supplier = $this->Supplier->getSuppliersById($clientId);
            if (!empty($supplier)) {
                $categoryId = $supplier['Supplier']['supplier_category_id'];

                $price = $this->Price->find('first',
                    array(
                        'conditions' => array(
                            'Price.detail_ride_id' => $rideId,
                            'Price.supplier_category_id' => $categoryId,
                            'PriceRideCategory.ride_category_id' => $rideCategoryId
                        ),
                        'recursive' => -1,
                        'joins' => array(

                            array(
                                'table' => 'price_ride_categories',
                                'type' => 'left',
                                'alias' => 'PriceRideCategory',
                                'conditions' => array('PriceRideCategory.price_id = Price.id')
                            ),
                        ),
                        'recursive' => -1,
                        'fields' => array(
                            'PriceRideCategory.price_ht',
                            'PriceRideCategory.id',
                            'PriceRideCategory.price_return'
                        )
                    ));

                if (!empty($price)) {
                    $price[0] = $price['PriceRideCategory']['price_ht'];
                    $price[1] = $price['PriceRideCategory']['id'];
                    $price[2] = $price['PriceRideCategory']['price_return'];

                    $this->set('price', $price);
                } else {

                    $price = $this->Price->find('first',
                        array(
                            'conditions' => array(
                                'Price.detail_ride_id' => $rideId,
                                'Price.supplier_category_id' => null,
                                'Price.supplier_id' => null,
                                'PriceRideCategory.ride_category_id' => $rideCategoryId
                            ),
                            'recursive' => -1,
                            'joins' => array(

                                array(
                                    'table' => 'price_ride_categories',
                                    'type' => 'left',
                                    'alias' => 'PriceRideCategory',
                                    'conditions' => array('PriceRideCategory.price_id = Price.id')
                                ),
                            ),
                            'recursive' => -1,
                            'fields' => array(
                                'PriceRideCategory.price_ht',
                                'PriceRideCategory.id',
                                'PriceRideCategory.price_return'
                            )
                        ));
                    if (!empty($price)) {
                        $price[0] = $price['PriceRideCategory']['price_ht'];
                        $price[1] = $price['PriceRideCategory']['id'];
                        $price[2] = $price['PriceRideCategory']['price_return'];

                        $this->set('price', $price);
                    }
                }
            }
        }

        return $price;
    }

    public function getConditionsSheetRide()
    {
        $isAgent = $this->isAgent();
        $userId = $this->Auth->user('id');
        $parcIds = $this->getParcsUserIdsArray($userId);
        if (!$isAgent) {

            $user_id = $this->Auth->user('id');
            $result = $this->verifyUserPermission(SectionsEnum::feuille_de_route, $user_id, ActionsEnum::view,
                "SheetRides", null, "SheetRide", null);
            if (!$this->verifyUserParcPermission(SectionsEnum::feuille_de_route)) {
                switch ($result) {
                    case 1 :
                        $conditions = null;
                        $conditions = array('Car.parc_id' => $parcIds);
                        $conditionsCar = array('Car.parc_id' => $parcIds, 'Car.car_status_id !=' => 27);
                        $conditionsCustomer = array('Customer.parc_id' => $parcIds);
                        break;
                    case 2 :
                        $conditions = array('SheetRide.user_id' => $userId, 'Car.parc_id' => $parcIds);
                        $conditionsCar = array(
                            'Car.user_id' => $userId,
                            'Car.parc_id' => $parcIds,
                            'Car.car_status_id !=' => 27
                        );
                        $conditionsCustomer = array('Customer.user_id' => $userId, 'Customer.parc_id' => $parcIds);

                        break;
                    case 3 :

                        $conditions = array('SheetRide.user_id !=' => $userId, 'Car.parc_id' => $parcIds);
                        $conditionsCar = array(
                            'Car.user_id !=' => $userId,
                            'Car.parc_id' => $parcIds,
                            'Car.car_status_id !=' => 27
                        );
                        $conditionsCustomer = array('Customer.user_id !=' => $userId, 'Customer.parc_id' => $parcIds);

                        break;

                    default:
                        $conditions = null;
                        $conditions = array('Car.parc_id' => $parcIds);
                        $conditionsCar = array('Car.parc_id' => $parcIds, 'Car.car_status_id !=' => 27);
                        $conditionsCustomer = array('Customer.parc_id' => $parcIds);


                }
            } else {
                switch ($result) {
                    case 1 :
                        $conditions = null;
                        $conditionsCar = array('Car.car_status_id !=' => 27);
                        $conditionsCustomer = null;

                        break;
                    case 2 :
                        $conditions = array('SheetRide.user_id ' => $userId);
                        $conditionsCar = array('Car.user_id' => $userId, 'Car.car_status_id !=' => 27);
                        $conditionsCustomer = array('Customer.user_id' => $userId);

                        break;
                    case 3 :
                        $conditions = array('SheetRide.user_id !=' => $userId);
                        $conditionsCar = array('Car.user_id !=' => $userId, 'Car.car_status_id !=' => 27);
                        $conditionsCustomer = array('Customer.user_id !=' => $userId);

                        break;

                    default:
                        $conditions = null;
                        $conditionsCar = array('Car.car_status_id !=' => 27);
                        $conditionsCustomer = null;
                }
            }
        } else {
            $conditions = null;
            $conditionsCar = null;
            $conditionsCustomer = null;
        }

        $cond = array();
        $cond[0] = $conditions;
        $cond[1] = $conditionsCar;
        $cond[2] = $conditionsCustomer;
        return $cond;


    }

    public function getConditionsForIndexSheetRide()
    {
        $isAgent = $this->isAgent();
        $userId = $this->Auth->user('id');
        $parcIds = $this->getParcsUser($userId);
        if (!$isAgent) {

            $result = $this->verifyUserPermission(SectionsEnum::feuille_de_route, $userId, ActionsEnum::view,
                "SheetRides", null, "SheetRide", null);
            if (!$this->verifyUserParcPermission(SectionsEnum::feuille_de_route)) {
                switch ($result) {
                    case 1 :
                        if(!empty($parcIds)){
                            $conditions = "Car.parc_id in $parcIds ";
                            $conditionsCar = "Car.parc_id in $parcIds && Car.car_status_id != 27";
                            $conditionsCustomer = "Customer.parc_id in $parcIds";
                        }else {
                            $conditions = NULL;
                            $conditionsCar = " Car.car_status_id != 27";
                            $conditionsCustomer = NULL;
                        }

                        break;
                    case 2 :
                        if(!empty($parcIds)){
                            $conditions = "SheetRide.user_id = $userId && Car.parc_id in $parcIds";
                            $conditionsCar = "
                            Car.user_id = $userId &&
                            Car.parc_id in $parcIds &&
                            Car.car_status_id !=  27 ";
                            $conditionsCustomer = "Customer.user_id = $userId && Customer.parc_id in $parcIds";
                        }else {
                            $conditions = "SheetRide.user_id = $userId ";
                            $conditionsCar = "
                            Car.user_id = $userId &&
                            Car.car_status_id !=  27 ";
                            $conditionsCustomer = "Customer.user_id = $userId ";
                        }


                        break;
                    case 3 :
                        if(!empty($parcIds)){
                            $conditions = "SheetRide.user_id != $userId && Car.parc_id in $parcIds";
                            $conditionsCar = "
                            Car.user_id != $userId &&
                            Car.parc_id in $parcIds &&
                            'Car.car_status_id != 27 ";
                            $conditionsCustomer = "Customer.user_id != $userId && Customer.parc_id in $parcIds";
                        }else {
                            $conditions = "SheetRide.user_id != $userId ";
                            $conditionsCar = "
                            Car.user_id != $userId &&
                            'Car.car_status_id != 27 ";
                            $conditionsCustomer = "Customer.user_id != $userId ";
                        }


                        break;

                    default:
                        if(!empty($parcIds)){
                            $conditions = null;
                            $conditions = "Car.parc_id in $parcIds";
                            $conditionsCar = "Car.parc_id in $parcIds && Car.car_status_id !=27";
                            $conditionsCustomer = "Customer.parc_id in $parcIds";
                        }else {
                            $conditions = null;
                            $conditionsCar = " Car.car_status_id !=27";
                            $conditionsCustomer = null ;
                        }



                }
            } else {
                switch ($result) {
                    case 1 :
                        $conditions = null;
                        $conditionsCar = "Car.car_status_id != 27";
                        $conditionsCustomer = null;

                        break;
                    case 2 :
                        $conditions = "SheetRide.user_id  = $userId";
                        $conditionsCar = "Car.user_id = $userId && Car.car_status_id != 27";
                        $conditionsCustomer = "Customer.user_id = $userId";

                        break;
                    case 3 :
                        $conditions = "SheetRide.user_id != $userId";
                        $conditionsCar = "Car.user_id != $userId && Car.car_status_id != 27";
                        $conditionsCustomer = "Customer.user_id != $userId";

                        break;

                    default:
                        $conditions = null;
                        $conditionsCar = "Car.car_status_id != 27";
                        $conditionsCustomer = null;
                }
            }
        } else {
            $conditions = null;
            $conditionsCar = null;
            $conditionsCustomer = null;
        }

        $cond = array();
        $cond[0] = $conditions;
        $cond[1] = $conditionsCar;
        $cond[2] = $conditionsCustomer;
        return $cond;


    }

    public function isAgent()
    {
        $user = $this->User->find('first', array(
            'conditions' => array('User.id' => $this->Auth->user('id')),
            'fields' => array('profile_id'),
            'recursive' => -1
        ));
        if (!empty($user)) {
            $profileId = $user['User']['profile_id'];
            if (!empty($profileId)) {
                if ($profileId == 10) {
                    return true;
                } else {
                    return false;
                }

            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    /**
     * get all ids parcs of user
     * @param  int $userId
     *
     * @return array $parcsId : ids of parcs
     */
    public function getParcsUser($userId)
    {
        $parcs = $this->UserParc->find('all', array(
            'recursive' => -1,
            'conditions' => array('UserParc.user_id' => $userId),
            'fields' => array('UserParc.parc_id')
        ));
        if (!empty($parcs)) {
            $parcsId = '(';
            $i = 1;
            foreach ($parcs as $parc) {
                if($i!=1){
                    $parcsId = $parcsId .',';
                }
                $parcsId =  $parcsId.''.$parc['UserParc']['parc_id'];
                $i  ++;
            }
            $parcsId = $parcsId .')';
        } else {
            $parcsId = '';
        }
        //var_dump($parcsId); die();
        return $parcsId;
    }

    /*
     * verify if consumption  coupon/ consumption tank / consumption spacies
     */

    /**
     * @param $sectionId
     * @param $userId
     * @param $actionId
     * @param $controller
     * @param $id
     * @param $model
     * @param null $type
     * @param null $redirect
     * @param  $actionRedirect
     *  verify users's permissions
     *
     * @return int|redirect could be int : 1(view all) 2(just own items) 3(none), could be a redirect to forbidden page
     */
    public function verifyUserPermission($sectionId, $userId, $actionId, $controller,
                                         $id, $model, $type = null, $redirect = null, $actionRedirect = 'index')
    {

        $result = true;
        if ($this->Auth->user('role_id') != 3) {
            $profileId = $this->Auth->user('profile_id');

            $userRights = $this->AccessPermission->find('all',
                array(
                    'conditions' =>
                        array(
                            'profile_id' => $profileId,
                            'section_id' => $sectionId,
                            'action_id' => $actionId
                        )
                )
            );


            if ($actionId == ActionsEnum::view) {
                if (empty ($userRights)) {
                    if (($controller == 'Statistics')) {
                        $result = false;
                        return $result;
                    } else {
                        if (empty($redirect)) {
                            $this->Flash->error(__("You don't have permission to consult."));
                            return $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
                        } else {
                            $result = 0;
                            return $result;
                        }

                    }
                } else {
                    if (($controller == 'Statistics')) {
                        $result = true;
                        return $result;
                    } else {
                        $userOtherRights = $this->AccessPermission->find('all',
                            array(
                                'conditions' =>
                                    array(
                                        'profile_id' => $profileId,
                                        'section_id' => $sectionId,
                                        'action_id' => ActionsEnum::view_other
                                    )
                            ));

                        if (empty ($userOtherRights)) {
                            // Can view just own items
                            return 2;
                        } else {
                            // can view all items
                            return 1;
                        }
                    }


                }

            } else {

                if ($actionId == ActionsEnum::edit || $actionId == ActionsEnum::delete || $actionId == ActionsEnum::lock) {

                    if (empty ($userRights)) {
                        if (empty($redirect)) {
                            $this->Flash->error(__("You don't have permission to do this action."));

                            return $this->redirect(array('controller' => $controller, 'action' => $actionRedirect, $type));
                        }else {
                            $result = false;
                            return $result;
                        }
                    } else {
                        // Knowing if the current element is owned by the current user
                        $currentElement = $this->$model->find('all',
                            array('conditions' => array($model . '.user_id' => $userId, $model . '.id ' => $id)));


                        if (empty($currentElement)) {
                            // The current element is not owned by the current user
                            $actionOtherId = $actionId + 1;
                            $userOtherRights = $this->AccessPermission->find('all', array(
                                'conditions' =>
                                    array(
                                        'profile_id' => $profileId,
                                        'section_id' => $sectionId,
                                        'action_id' => $actionOtherId
                                    )
                            ));
                            if (empty ($userOtherRights)) {
                                if (empty($redirect)) {
                                    $this->Flash->error(__("You don't have permission to do this action."));
                                    return $this->redirect(array('controller' => $controller, 'action' => $actionRedirect, $type));
                                }else {
                                    $result = false;
                                    return $result;
                                }
                                }
                        }

                    }

                } else {
                    if ($actionId == ActionsEnum::add) {
                        if (empty ($userRights)) {

                            if (empty($redirect)) {
                                $this->Flash->error(__("You don't have permission to add."));
                                return $this->redirect(array('controller' => $controller, 'action' => $actionRedirect, $type));
                            } else {
                                $result = false;
                                return $result;
                            }

                        } else {
                            return $result;
                        }

                    } else {
                        if (empty ($userRights)) {
                            $this->Flash->error(__("You don't have permission to do this action."));
                            return $this->redirect(array('controller' => $controller, 'action' => $actionRedirect, $type));
                        }
                    }
                }
            }
        } else return $result;

    }

    /**
     * verify if user can view the element of other parcs
     * @param $rubric_id , $user_id
     *
     * @return true: user can show, false: user can't show
     */

    public function verifyUserParcPermission($section_id)
    {
        if ($this->Auth->user('role_id') != 3) {

            $profile_id = $this->Auth->user('profile_id');
            // get right's row to verify if checkbox was checked
            $parc_right = $this->AccessPermission->find('all',
                array(
                    'conditions' => array(
                        'profile_id' => $profile_id,
                        'section_id' => $section_id,
                        'action_id' => ActionsEnum::view_other_parc
                    )
                ));
            if (empty ($parc_right)) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }


    /**
     * update Sent Driver License Alert Mail
     * @param $customer_id
     *
     * @return null
     */
    public function updateSentDriverLicenseAlert($customer_id)
    {
        $customer = $this->Customer->find('all', array(
            'recursive' => -1,
            'conditions' => array('id' => (int)$customer_id)
        ));
        if (!empty($customer)) {
            $customer[0]['Customer']['send_mail'] = 1;
            $this->Customer->save($customer[0]);
        }
    }

    public function updateDriverLicenseAlert($customer_id)
    {

        $customer = $this->Customer->find('all', array(
            'recursive' => -1,
            'conditions' => array('id' => (int)$customer_id)
        ));
        if (!empty($customer)) {
            $this->Customer->id = $customer_id;
            $this->Customer->saveField('alert', 1);

        }

    }

   /**
     * @param null $type
     * @return array
     */
    public function getTransportBillGeneralConditions($type = null)
    {

        $userId = $this->Auth->user('id');
        $profileId = $this->Auth->user('profile_id');
        $this->set('profileId', $profileId);
        $type = (int)$type;

        if ($type == TransportBillTypesEnum::quote_request) {
            $result = $this->verifyUserPermission(
                SectionsEnum::demande_de_devis, $userId, ActionsEnum::view, "TransportBills", null, "TransportBill",
                $type
            );
        } elseif ($type == TransportBillTypesEnum::quote) {
            $result = $this->verifyUserPermission(
                SectionsEnum::devis, $userId, ActionsEnum::view, "TransportBills", null, "TransportBill", $type
            );
        } elseif ($type == TransportBillTypesEnum::order) {
            $result = $this->verifyUserPermission(
                SectionsEnum::commande_client, $userId, ActionsEnum::view, "TransportBills", null, "TransportBill",
                $type
            );
        } elseif ($type == TransportBillTypesEnum::pre_invoice) {
            $result = $this->verifyUserPermission(
                SectionsEnum::prefacture, $userId, ActionsEnum::view, "TransportBills", null, "TransportBill", $type
            );
        } elseif ($type == TransportBillTypesEnum::invoice) {
            $result = $this->verifyUserPermission(
                SectionsEnum::facture, $userId, ActionsEnum::view, "TransportBills", null, "TransportBill", $type
            );
        } else {
            $result = $this->verifyUserPermission(
                SectionsEnum::demande_de_devis, $userId, ActionsEnum::view, "TransportBills", null, "TransportBill",
                $type
            );
        }
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        if ($profileId == ProfilesEnum::client) {
            $supplierId = $this->Auth->user('supplier_id');
            $serviceId = $this->Auth->user('service_id');
            if ($serviceId != NULL) {
                switch ($type) {
                    case TransportBillTypesEnum::quote_request:
                        switch ($result) {
                            case 1 :
                                $conditions = "TransportBill.type = '$type' && TransportBill.supplier_id  = $supplierId && User.service_id = $serviceId";;

                                break;
                            case 2 :
                                $conditions = " TransportBill.supplier_id  = $supplierId &&  TransportBill.user_id  => $userId && User.service_id  = $serviceId && TransportBill.type = '$type' ";
                                break;

                            case 3 :
                                $conditions = " TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id !=  $userId &&
                                    User.service_id  = $serviceId &&
                                    TransportBill.type = '$type' ";


                                break;

                            default:
                                $conditions = "  TransportBill.type = '$type' &&
                                    User.service_id  = $serviceId &&
                                    TransportBill.supplier_id  = $supplierId ";


                        }
                        break;
                    case TransportBillTypesEnum::quote:

                        switch ($result) {
                            case 1 :
                                $conditions = "TransportBill.type = '$type' &&
                                    User.service_id  = $serviceId &&
                                    TransportBill.supplier_id  = $supplierId ";
                                break;
                            case 2 :
                                $conditions = " TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id  = $userId &&
                                    User.service_id  = $serviceId &&
                                    TransportBill.type = '$type' ";


                                break;

                            case 3 :
                                $conditions = " TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id !=  $userId &&
                                    User.service_id  = $serviceId &&
                                    TransportBill.type = '$type' ";


                                break;

                            default:
                                $conditions = " TransportBill.type = '$type' &&
                                    User.service_id  = $serviceId &&
                                    TransportBill.supplier_id  = $supplierId ";


                        }
                        break;
                    case TransportBillTypesEnum::order:

                        switch ($result) {
                            case 1 :
                                $conditions = "  TransportBill.type = '$type' &&
                                    TransportBill.supplier_id  = $supplierId &&
                                    User.service_id  = $serviceId ";
                                break;
                            case 2 :
                                $conditions = "TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id  = $userId &&
                                    User.service_id  = $serviceId &&
                                    TransportBill.type = '$type' ";
                                break;

                            case 3 :
                                $conditions = " TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id !=  $userId &&
                                    TransportBill.type = '$type' ";


                                break;

                            default:
                                $conditions = "TransportBill.type = '$type' &&
                                    User.service_id  = $serviceId &&
                                    TransportBill.supplier_id  = $supplierId ";
                        }
                        break;
                    case TransportBillTypesEnum::pre_invoice:
                        switch ($result) {
                            case 1 :
                                $conditions = " TransportBill.type = '$type' &&
                                    TransportBill.supplier_id  = $supplierId &&
                                    User.service_id  = $serviceId ";

                                break;
                            case 2 :
                                $conditions = "TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id  = $userId &&
                                    User.service_id  = $serviceId &&
                                    TransportBill.type = '$type' ";
                                break;

                            case 3 :
                                $conditions = "TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id !=  $userId &&
                                    User.service_id  => $serviceId &&
                                    TransportBill.type => '$type' ";
                                break;

                            default:
                                $conditions = "TransportBill.type = '$type' &&
                                    User.service_id  = $serviceId &&
                                    TransportBill.supplier_id  = $supplierId ";

                        }
                        break;
                    case TransportBillTypesEnum::invoice:
                        switch ($result) {
                            case 1 :
                                $conditions = " TransportBill.type = '$type' &&
                                    User.service_id  = $serviceId &&
                                    TransportBill.supplier_id  = $supplierId ";

                                break;
                            case 2 :
                                $conditions = " TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id  = $userId &&
                                    TransportBill.type = '$type' ";

                                break;

                            case 3 :
                                $conditions = " TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id != $userId &&
                                    User.service_id  = $serviceId &&
                                    TransportBill.type = '$type' ";
                                break;

                            default:
                                $conditions = " TransportBill.type = '$type' &&
                                    User.service_id  = $serviceId &&
                                    TransportBill.supplier_id  = $supplierId ";
                        }
                        break;
                    Default :
                        switch ($result) {
                            case 1 :
                                $conditions = " 
                                    TransportBill.type = '$type' &&
                                    User.service_id  = $serviceId &&
                                    TransportBill.supplier_id = $supplierId ";
                                break;
                            case 2 :
                                $conditions = "  TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id  = $userId &&
                                    User.service_id  = $serviceId &&
                                    TransportBill.type = '$type' ";
                                break;

                            case 3 :
                                $conditions = "TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id != $userId &&
                                    User.service_id  = $serviceId &&
                                    TransportBill.type = '$type' ";

                                break;

                            default:
                                $conditions = "  TransportBill.type = $type &&
                                    User.service_id  = $serviceId &&
                                    TransportBill.supplier_id  = $supplierId ";
                        }

                }
            } else {
                switch ($type) {
                    case TransportBillTypesEnum::quote_request:
                        switch ($result) {
                            case 1 :
                                $conditions = "    TransportBill.type = '$type' &&
                                    TransportBill.supplier_id  = $supplierId ";

                                break;
                            case 2 :
                                $conditions = "  TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id  = $userId &&
                                    TransportBill.type = '$type' ";

                                break;

                            case 3 :
                                $conditions = "TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id != $userId &&
                                    TransportBill.type = '$type' ";
                                break;

                            default:
                                $conditions = " TransportBill.type = '$type' &&
                                    TransportBill.supplier_id  = $supplierId ";
                        }
                        break;
                    case TransportBillTypesEnum::quote:

                        switch ($result) {
                            case 1 :
                                $conditions = "TransportBill.type = '$type' &&
                                    TransportBill.supplier_id  = $supplierId ";
                                break;
                            case 2 :
                                $conditions = "TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id  = $userId &&
                                    TransportBill.type = '$type' ";
                                break;

                            case 3 :
                                $conditions = "TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id != $userId &&
                                    TransportBill.type = '$type' ";
                                break;

                            default:
                                $conditions = "TransportBill.type = '$type' &&
                                    TransportBill.supplier_id  = $supplierId ";
                        }
                        break;
                    case TransportBillTypesEnum::order:

                        switch ($result) {
                            case 1 :
                                $conditions = "TransportBill.type = '$type' &&
                                    TransportBill.supplier_id  = $supplierId ";
                                break;
                            case 2 :
                                $conditions = "TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id  = $userId &&
                                    TransportBill.type = '$type' ";
                                break;

                            case 3 :
                                $conditions = "TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id != $userId &&
                                    TransportBill.type = '$type' ";
                                break;

                            default:
                                $conditions = "  TransportBill.type = '$type' &&
                                    TransportBill.supplier_id  = $supplierId ";
                        }
                        break;
                    case TransportBillTypesEnum::pre_invoice:
                        switch ($result) {
                            case 1 :
                                $conditions = "TransportBill.type = '$type' &&
                                    TransportBill.supplier_id  = $supplierId ";
                                break;
                            case 2 :
                                $conditions = "TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id  = $userId &&
                                    TransportBill.type = '$type' ";
                                break;

                            case 3 :
                                $conditions = " TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id != $userId &&
                                    TransportBill.type = '$type' ";
                                break;

                            default:
                                $conditions = "TransportBill.type = '$type' &&
                                    TransportBill.supplier_id  = $supplierId ";
                        }
                        break;
                    case TransportBillTypesEnum::invoice:
                        switch ($result) {
                            case 1 :
                                $conditions = " TransportBill.type = '$type' &&
                                    TransportBill.supplier_id  = $supplierId";
                                break;
                            case 2 :
                                $conditions = " TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id  = $userId &&
                                    TransportBill.type = '$type' ";
                                break;

                            case 3 :
                                $conditions = "  TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id != $userId &&
                                    TransportBill.type = '$type' ";
                                break;

                            default:
                                $conditions = " TransportBill.type = '$type',
                                    TransportBill.supplier_id  = $supplierId ";
                        }
                        break;
                    Default :
                        switch ($result) {
                            case 1 :
                                $conditions = "   TransportBill.type = '$type' &&
                                    TransportBill.supplier_id  = $supplierId ";
                                break;
                            case 2 :
                                $conditions = " TransportBill.supplier_id  = $supplierId &&
                                    TransportBill.user_id  = $userId &&
                                    TransportBill.type = '$type' ";
                                break;

                            case 3 :
                                $conditions = "
                                    TransportBill.supplier_id  =$supplierId &&
                                    TransportBill.user_id !=  $userId &&
                                    TransportBill.type = '$type' ";

                                break;

                            default:
                                $conditions = "
                                    TransportBill.type = '$type',
                                    TransportBill.supplier_id  = $supplierId ";

                        }
                }
            }

        } else {
            switch ($result) {
                case 1 :
                    $conditions = "TransportBill.type = $type ";
                    break;
                case 2 :
                    $conditions = "TransportBill.user_id  = $userId && TransportBill.type = $type ";
                    break;
                case 3 :
                    $conditions = "TransportBill.user_id != $userId && TransportBill.type => $type ";
                    break;
                default:
                    $conditions = "TransportBill.type = $type ";
            }
        }

        return $conditions;
    }


    private function createDateAlertSession($result, $alert, $sessionName, $isDate = null)
    {
        if (!empty($result)) {

            $dateFrom = new DateTime($result['Event']['next_date']);
            $dateNow = new DateTime(date('Y-m-d H:i:s'));
            if ($dateFrom < $dateNow) {
                $percent = 100;
            } else {
                $interval = $dateFrom->diff($dateNow);
                //get days numbers
                $nbDays = (int)$interval->format('%a');
                $percent = number_format(100 - (($nbDays * 100) / (int)$alert['Parameter']['val']), 2, ".", "");
            }
            $alertArray = array();
            $alertArray[$sessionName][] = $result['Event']['id'];
            if ($isDate) {
                $alertArray[$sessionName][] = $result['EventType']['name'];
            } else {
                $alertArray[$sessionName][] = $result['Carmodel']['name'] . " " . $result['Car']['code'];
            }

            $alertArray[$sessionName][] = $percent;

            if (!isset($_SESSION["Alerts"][$sessionName])) {
                $_SESSION["Alerts"][$sessionName] = array();
            }
            array_push($_SESSION["Alerts"][$sessionName], $alertArray);

            if ((int)$result['Event']['send_mail'] == 0) {
                $this->Session->write("sendmail", 1);
                $this->updateSendMailEvent($result['Event']['id']);

            }
            $this->updateAlertEvent($result['Event']['id']);
        }
    }

    public function updateSendMailEvent($event_id)
    {
        $event = $this->Event->find('all', array(
            'recursive' => -1,
            'conditions' => array('id' => (int)$event_id)
        ));
        if (!empty($event)) {

            $event[0]['Event']['send_mail'] = 1;
            $this->Event->save($event[0]);
        }
    }

    /*
     * get sepatator to be used in amount
     */

    public function updateAlertEvent($event_id)
    {
        $event = $this->Event->find('all', array(
            'recursive' => -1,
            'conditions' => array('id' => (int)$event_id)
        ));
        if (!empty($event)) {
            $this->Event->id = $event_id;
            // 1: alert activated
            $this->Event->saveField('alert', 1);

        }

    }

    /*
     * get method to be used when select coupons 1: one by one 2: From number to other
     */

    private function createDateContractAlertSession($result, $alert, $sessionName, $i)
    {
        if (!empty($result)) {

            $dateFrom = new DateTime($result['Leasing']['end_date']);
            $dateNow = new DateTime(date('Y-m-d H:i:s'));
            if ($dateFrom < $dateNow) {
                $percent = 100;
            } else {
                $interval = $dateFrom->diff($dateNow);
                //get days numbers
                $nbDays = (int)$interval->format('%a');
                $percent = number_format(100 - (($nbDays * 100) / (int)$alert['Parameter']['val']), 2, ".", "");
            }
            $alertArray = array();
            $alertArray[$sessionName][] = $result['Car']['id'];

            $alertArray[$sessionName][] = 'Date contrat' . " " . $result['Carmodel']['name'] . " " . $result['Car']['code'];


            $alertArray[$sessionName][] = $percent;

            if ($i == 0) {
                $_SESSION["Alerts"][$sessionName] = array();
            }
            array_push($_SESSION["Alerts"][$sessionName], $alertArray);

            if ((int)$result['Leasing']['send_mail_date'] == 0) {
                $this->Session->write("sendmail", 1);
                $this->updateSentDateContractAlert($result['Car']['id']);

            }
            $this->updateAlertDateContract($result['Car']['id']);
        }
    }

    /**
     * update Sent Date Contract Alert Mail
     * @param $car_id
     *
     * @return void
     */
    public function updateSentDateContractAlert($car_id)
    {


        $car = $this->Leasing->find('first', array(
            'recursive' => -1,
            'conditions' => array('car_id' => (int)$car_id)
        ));
        if (!empty($car)) {
            $this->Leasing->id = $car['Leasing']['id'];
            $this->Leasing->saveField('send_mail_date', 1);

        }
    }

    public function updateAlertDateContract($car_id)
    {
        $car = $this->Leasing->find('first', array(
            'recursive' => -1,
            'conditions' => array('car_id' => (int)$car_id)
        ));
        if (!empty($car)) {
            $this->Leasing->id = $car['Leasing']['id'];
            $this->Leasing->saveField('alert_date', 1);

        }

    }

    /*
     * verify if display Mission cost in sheet Ride
     * 1: No , 2: Yes
     */

    private function createKmContractAlertSession($result, $alert, $sessionName, $i)
    {


        if (!empty($result)) {

            if ($result[0]['km_rest'] < $result['Car']['km']) {

                $percent = 100;
            } else {
                $interval = $result[0]['km_rest'] - $result['Car']['km'];
                $percent = number_format(100 - (($interval * 100) / (int)$alert['Parameter']['val']), 2, ".", "");
            }
            $alertArray = array();

            $alertArray[$sessionName][] = $result['Car']['id'];
            $alertArray[$sessionName][] = 'Km contrat' . " " . $result['Carmodel']['name'] . " " . $result['Car']['code'];
            $alertArray[$sessionName][] = $percent;


            if ($i == 0) {
                $_SESSION["Alerts"][$sessionName] = array();
            }
            array_push($_SESSION["Alerts"][$sessionName], $alertArray);

            if ($result['Leasing']['send_mail'] == 0) {
                $this->Session->write("sendmail", 1);

                $this->updateSentKmContractAlert($result['Car']['id']);
            }

            $this->updateAlertKmContract($result['Car']['id']);
        }
    }

    /*
     * Define the management  of missions cost
     * 1 : With day , 2 : With mission , 3 : With distance
     */

    /**
     * update Sent Km Contract Alert Mail
     * @param $car_id
     *
     * @return void
     */
    public function updateSentKmContractAlert($car_id)
    {


        $car = $this->Leasing->find('first', array(
            'recursive' => -1,
            'conditions' => array('car_id' => (int)$car_id)
        ));
        if (!empty($car)) {
            $this->Leasing->id = $car['Leasing']['id'];
            $this->Leasing->saveField('send_mail', 1);

        }
    }

    public function updateAlertKmContract($car_id)
    {
        $car = $this->Leasing->find('first', array(
            'recursive' => -1,
            'conditions' => array('car_id' => (int)$car_id)
        ));
        if (!empty($car)) {
            $this->Leasing->id = $car['Leasing']['id'];
            $this->Leasing->saveField('alert', 1);

        }

    }

    private function createKmAlertSession($result, $alert, $sessionName, $isKm = null)
    {


        if (!empty($result)) {
            if ($result['Event']['next_km'] < $result['Car']['km']) {
                $percent = 100;
            } else {
                $interval = $result['Event']['next_km'] - $result['Car']['km'];
                $percent = number_format(100 - (($interval * 100) / (int)$alert['Parameter']['val']), 2, ".", "");
            }
            $alertArray = array();
            $alertArray[$sessionName][] = $result['Event']['id'];
            if ($isKm) {
                $alertArray[$sessionName][] = $result['EventType']['name'];
            } else {
                $alertArray[$sessionName][] = $result['EventType']['name'] . " " . $result['Carmodel']['name'] . " " . $result['Car']['code'];
            }

            $alertArray[$sessionName][] = $percent;
            if (!isset($_SESSION["Alerts"][$sessionName])) {
                $_SESSION["Alerts"][$sessionName] = array();
            }
            array_push($_SESSION["Alerts"][$sessionName], $alertArray);
            if ($result['Event']['send_mail'] == 0) {
                $this->Session->write("sendmail", 1);
                $this->updateSendMailEvent($result['Event']['id']);

            }
            $this->updateAlertEvent($result['Event']['id']);
        }
    }

    private function createAmortissementAlertSession($result, $alert, $sessionName)
    {


        if (!empty($result)) {
            if ($result['Car']['amortization_km'] < $result['Car']['km']) {
                $percent = 100;
            } else {
                $interval = $result['Car']['amortization_km'] - $result['Car']['km'];
                $percent = number_format(100 - (($interval * 100) / (int)$alert), 2, ".", "");
            }
            $alertArray = array();
            $alertArray[$sessionName][] = $result['Car']['id'];

            $alertArray[$sessionName][] = $result['Carmodel']['name'] . " " . $result['Car']['code'];


            $alertArray[$sessionName][] = $percent;
            if (!isset($_SESSION["Alerts"][$sessionName])) {
                $_SESSION["Alerts"][$sessionName] = array();
            }
            array_push($_SESSION["Alerts"][$sessionName], $alertArray);

            $this->updateAlertCar($result['Car']['id']);
        }
    }

    public function updateAlertCar($carId)
    {
        $car = $this->Car->find('first', array(
            'recursive' => -1,
            'conditions' => array('id' => (int)$carId)
        ));
        if (!empty($car)) {
            $this->Car->id = $carId;
            // 1: alert activated
            $this->Car->saveField('alert_amortization', 1);

        }

    }

    private function createHourAlertSession($result, $alert, $sessionName, $isKm = null)
    {


        if (!empty($result)) {
            if ($result['Event']['next_km'] < $result['Car']['hours']) {
                $percent = 100;
            } else {
                $interval = $result['Event']['next_km'] - $result['Car']['hours'];
                $percent = number_format(100 - (($interval * 100) / (int)$alert['Parameter']['val']), 2, ".", "");
            }
            $alertArray = array();
            $alertArray[$sessionName][] = $result['Event']['id'];
            if ($isKm) {
                $alertArray[$sessionName][] = $result['EventType']['name'];
            } else {
                $alertArray[$sessionName][] = $result['EventType']['name'] . " " . $result['Carmodel']['name'] . " " . $result['Car']['code'];
            }

            $alertArray[$sessionName][] = $percent;
            if (!isset($_SESSION["Alerts"][$sessionName])) {
                $_SESSION["Alerts"][$sessionName] = array();
            }
            array_push($_SESSION["Alerts"][$sessionName], $alertArray);
            if ($result['Event']['send_mail'] == 0) {
                $this->Session->write("sendmail", 1);
                $this->updateSendMailEvent($result['Event']['id']);

            }
            $this->updateAlertEvent($result['Event']['id']);
        }
    }

    private function createConsumptionAlertSession($result, $alert, $sessionName)
    {


        if (!empty($result)) {

            if ($result[0]['diffKm'] < $result['Car']['km']) {

                $percent = 100;
            } else {
                $interval = $result[0]['diffKm'] - $result['Car']['km'];
                $percent = number_format(100 - (($interval * 100) / (int)$alert['Parameter']['val']), 2, ".", "");
            }
            $alertArray = array();
            $alertArray[$sessionName][] = $result['SheetRide']['car_id'];


            $alertArray[$sessionName][] = $result['Carmodel']['name'] . " " . $result['Car']['code'];

            $alertArray[$sessionName][] = $percent;
            if (!isset($_SESSION["Alerts"][$sessionName])) {
                $_SESSION["Alerts"][$sessionName] = array();
            }
            array_push($_SESSION["Alerts"][$sessionName], $alertArray);
            if ($result['Car']['send_mail'] == 0) {
                $this->Session->write("sendmail", 1);
                $this->updateSentCarConsumptionAlert($result['SheetRide']['car_id']);

            }
            $this->updateAlertConsumption($result['SheetRide']['car_id']);
        }
    }

    /**
     * update Sent Car Consumption Alert Mail
     * @param $car_id
     *
     * @return void
     */
    public function updateSentCarConsumptionAlert($car_id)
    {
        $car = $this->Car->find('all', array(
            'recursive' => -1,
            'conditions' => array('id' => (int)$car_id)
        ));
        if (!empty($car)) {
            $car[0]['Car']['send_mail'] = 1;
            $this->Car->save($car[0]);
        }
    }

    public function updateAlertConsumption($car_id)
    {
        $car = $this->Car->find('all', array(
            'recursive' => -1,
            'conditions' => array('id' => (int)$car_id)
        ));
        if (!empty($car)) {
            $this->Car->id = $car_id;
            $this->Car->saveField('alert', 1);

        }

    }


    function cUrlGetData($url, $post_fields = null, $headers = null)
    {
        $ch = curl_init();
        $timeout = 3000;
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($post_fields && !empty($post_fields)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        }
        if ($headers && !empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $data = utf8_encode($data);
        $data = json_decode($data, JSON_UNESCAPED_UNICODE);
        return $data;
    }


    function moduleDisplayed(){
        $profileId = $this->Auth->user('profile_id');
        $roleId = $this->Auth->user('role_id');
        $permissionComplaint = $this->AccessPermission->getPermissionWithParams(SectionsEnum::reclamation,
            ActionsEnum::view, $profileId, $roleId);
        $permissionWorkshop = $this->AccessPermission->getPermissionWithParams(SectionsEnum::atelier,
            ActionsEnum::view, $profileId, $roleId);
        $permissionTank = $this->AccessPermission->getPermissionWithParams(SectionsEnum::citerne,
            ActionsEnum::view, $profileId, $roleId);

        $permissionOrderNotValidated = $this->AccessPermission->getPermissionWithParams(SectionsEnum::commande_non_validee,
            ActionsEnum::view, $profileId, $roleId);

        $this->Session->write("permissionComplaint", $permissionComplaint);
        $this->Session->write("permissionWorkshop", $permissionWorkshop);
        $this->Session->write("permissionTank", $permissionTank);
        $this->Session->write("permissionOrderNotValidated", $permissionOrderNotValidated);

    }
    function diff_time($t1 , $t2){
        //Heures au format (hh:mm:ss) la plus grande puis le plus petite

        $tab=explode(":", $t1);
        $tab2=explode(":", $t2);

        $h=$tab[0];
        $m=$tab[1];
        $s=$tab[2];
        $h2=$tab2[0];
        $m2=$tab2[1];
        $s2=$tab2[2];

        if ($h2>$h) {
            $h=$h+24;
        }
        if ($m2>$m) {
            $m=$m+60;
            $h2++;
        }
        if ($s2>$s) {
            $s=$s+60;
            $m2++;
        }

        $ht=$h-$h2;
        $mt=$m-$m2;
        $st=$s-$s2;
        if (strlen($ht)==1) {
            $ht="0".$ht;
        }
        if (strlen($mt)==1) {
            $mt="0".$mt;
        }
        if (strlen($st)==1) {
            $st="0".$st;
        }
        return $ht.":".$mt.":".$st;

    }


    /** cette fonction pour ajouter un status id d'une car id pour une date donnée
     * @param $carId
     * @param $carStatusId
     * @param $startDate
     * @param $endDate
     * @param $eventId
     */
    public function addCarCarStatus($carId, $carStatusId, $startDate, $endDate=null, $eventId = null)
    {

        $this->loadModel('CarCarStatus');
        if(!empty($eventId)){
            $carCarStatus = $this->CarCarStatus->find('first',
                array(
                    'conditions'=>array('CarCarStatus.event_id'=>$eventId),
                    'recursive'=>-1
                ));
            if(!empty($carCarStatus)){
                $carCarStatusId = $carCarStatus['CarCarStatus']['id'];
            }
        }
        $data = array();
        if(isset($carCarStatusId)&& !empty($carCarStatusId)){
            $this->CarCarStatus->id = $carCarStatusId;
        }else {
            $this->CarCarStatus->create();
        }
        $data['CarCarStatus']['car_id'] = $carId;
        $data['CarCarStatus']['car_status_id'] = $carStatusId;
        $data['CarCarStatus']['start_date'] = $startDate;
        $data['CarCarStatus']['end_date'] = $endDate;
        $data['CarCarStatus']['event_id'] = $eventId;
        $this->CarCarStatus->save($data);
    }



    function update_Ride_sheetRide(
        $sheetRideDetailRide = null,
        $reference = null,
        $sheetRideId = null,
        $sheetRideDetailRideId = null,
        $previousCarOffshore = null,
        $carOffshore = null,
        $carId = null,
        $previousSubcontractorId = null,
        $subcontractorId = null

    )
    {
        // Get reference mission automatic parameter reference_mi_auto
        $referenceMission = $this->Parameter->getCodesParameterVal('reference_mi_auto');
        if ($referenceMission == '1') {
            $data['SheetRideDetailRides']['reference'] = $sheetRideDetailRide['reference'];
        } else {
            if ($reference != null) {
                //$referenceSheetRideDetailRide = $this->getReferenceSheetRideDetailRide($sheetRideId, $reference);
                $referenceSheetRide = $this->SheetRide->getReferenceSheetRide($sheetRideId);
                $data['SheetRideDetailRides']['reference'] = $referenceSheetRide.'/'.$sheetRideDetailRide['order_mission'];
                //var_dump($data['SheetRideDetailRides']['reference']); die();
            }
        }

        $sheetRideDetailRideExisted = $this->SheetRideDetailRides->find('first',
            array('conditions' => array('SheetRideDetailRides.id' => $sheetRideDetailRideId)));
        $precedentSupplierId = $sheetRideDetailRideExisted['SheetRideDetailRides']['supplier_id'];
        $precedentTransportBillDetailRideId = $sheetRideDetailRideExisted['SheetRideDetailRides']['transport_bill_detail_ride_id'];


        $data['SheetRideDetailRides']['order_mission'] = $sheetRideDetailRide['order_mission'];
        $this->request->data['SheetRideDetailRides']['planned_start_date'] = $sheetRideDetailRide['planned_start_date'];
        $this->createDatetimeFromDatetime('SheetRideDetailRides', 'planned_start_date');
        $sheetRideDetailRide['planned_start_date'] = $this->request->data['SheetRideDetailRides']['planned_start_date'];

        $this->request->data['SheetRideDetailRides']['real_start_date'] = $sheetRideDetailRide['real_start_date'];
        $this->createDatetimeFromDatetime('SheetRideDetailRides', 'real_start_date');
        $sheetRideDetailRide['real_start_date'] = $this->request->data['SheetRideDetailRides']['real_start_date'];

        $this->request->data['SheetRideDetailRides']['planned_end_date'] = $sheetRideDetailRide['planned_end_date'];
        $this->createDatetimeFromDatetime('SheetRideDetailRides', 'planned_end_date');
        $sheetRideDetailRide['planned_end_date'] = $this->request->data['SheetRideDetailRides']['planned_end_date'];

        $this->request->data['SheetRideDetailRides']['real_end_date'] = $sheetRideDetailRide['real_end_date'];
        $this->createDatetimeFromDatetime('SheetRideDetailRides', 'real_end_date');
        $sheetRideDetailRide['real_end_date'] = $this->request->data['SheetRideDetailRides']['real_end_date'];
        if (isset($sheetRideDetailRide['Attachment'])) {
            $attachments = $sheetRideDetailRide['Attachment'];
        } else {
            $attachments = array();
        }

        if (isset($sheetRideDetailRide['lots'])) {
            $lots = $sheetRideDetailRide['lots'];
        } else {
            $lots = array();
        }

        if (isset($sheetRideDetailRide['SheetRideDetailRideMarchandise'])) {
            $sheetRideDetailRideMarchandises = $sheetRideDetailRide['SheetRideDetailRideMarchandise'];
        } else {
            $sheetRideDetailRideMarchandises = array();
        }
        // Get reference mission automatic parameter reference_mi_auto
        $referenceMission = $this->Parameter->getCodesParameterVal('reference_mi_auto');
        if ($referenceMission == '1') {
            $data['SheetRideDetailRides']['reference'] = $sheetRideDetailRide['reference'];
        }
        if (isset($sheetRideDetailRide['source'])) {
            $data['SheetRideDetailRides']['source'] = $sheetRideDetailRide['source'];
        }
        $data['SheetRideDetailRides']['id'] = $sheetRideDetailRideId;
        if(isset($sheetRideDetailRide['from_customer_order'])){
            $data['SheetRideDetailRides']['from_customer_order'] = $sheetRideDetailRide['from_customer_order'];
        }
        if(isset($sheetRideDetailRide['type_ride'])){
            $data['SheetRideDetailRides']['type_ride'] = $sheetRideDetailRide['type_ride'];
        }
        if(isset( $sheetRideDetailRide['invoiced_ride'])){
            $data['SheetRideDetailRides']['invoiced_ride'] = $sheetRideDetailRide['invoiced_ride'];
        }
        if(isset($sheetRideDetailRide['truck_full'])){
            $data['SheetRideDetailRides']['truck_full'] = $sheetRideDetailRide['truck_full'];
        }
        if (isset($sheetRideDetailRide['return_mission'])) {
            $data['SheetRideDetailRides']['return_mission'] = $sheetRideDetailRide['return_mission'];
        } else {
            $data['SheetRideDetailRides']['return_mission'] = 2;
        }
        if (isset($sheetRideDetailRide['type_price'])) {
            $data['SheetRideDetailRides']['type_price'] = $sheetRideDetailRide['type_price'];
        } else {
            $data['SheetRideDetailRides']['type_price'] = 1;
        }

        if (isset($sheetRideDetailRide['type_pricing'])) {
            $data['SheetRideDetailRides']['type_pricing'] = $sheetRideDetailRide['type_pricing'];
        } else {
            $data['SheetRideDetailRides']['type_pricing'] = 1;
        }

        if (isset($sheetRideDetailRide['price_recovered'])) {
            $data['SheetRideDetailRides']['price_recovered'] = $sheetRideDetailRide['price_recovered'];
        } else {
            $data['SheetRideDetailRides']['price_recovered'] = 2;
        }

        if (isset($sheetRideDetailRide['tonnage_id'])) {
            $data['SheetRideDetailRides']['tonnage_id'] = $sheetRideDetailRide['tonnage_id'];
        } else {
            $data['SheetRideDetailRides']['tonnage_id'] = NULL;
        }
        if (isset($sheetRideDetailRide['remaining_time'])) {
            $data['SheetRideDetailRides']['remaining_time'] = $sheetRideDetailRide['remaining_time'];
        } else {
            $data['SheetRideDetailRides']['remaining_time'] = 0;
        }
        if (isset($sheetRideDetailRide['note'])) {
            $data['SheetRideDetailRides']['note'] = $sheetRideDetailRide['note'];
        }
        if (isset($sheetRideDetailRide['ride_category_id'])) {
            $data['SheetRideDetailRides']['ride_category_id'] = $sheetRideDetailRide['ride_category_id'];
        }
        $sheetRideDetailRide['real_end_date'] = $this->request->data['SheetRideDetailRides']['real_end_date'];
        if (isset($sheetRideDetailRide['observation_id'])) {
            $data['SheetRideDetailRides']['observation_id'] = $sheetRideDetailRide['observation_id'];
        } else {
            $data['SheetRideDetailRides']['observation_id'] = null;
        }
        if (isset($sheetRideDetailRide['transport_bill_detail_ride'])) {
            $data['SheetRideDetailRides']['transport_bill_detail_ride_id'] = $sheetRideDetailRide['transport_bill_detail_ride'];
        } else {
            if ($sheetRideDetailRide['from_customer_order'] == '1') {
                $data['SheetRideDetailRides']['transport_bill_detail_ride_id'] = $sheetRideDetailRide['detail_ride_id'];
            }
        }
        $data['SheetRideDetailRides']['sheet_ride_id'] = $sheetRideId;
        if ($sheetRideDetailRide['from_customer_order'] == '1'
            && $sheetRideDetailRide['type_ride'] == '1') {
            if ($sheetRideDetailRide['status_id'] <= StatusEnum::mission_closed) {
                $detail_ride = $this->TransportBillDetailRides->find('first', array(
                    'conditions' => array('TransportBillDetailRides.id' => $sheetRideDetailRide['detail_ride_id']),
                    'fields' => array('TransportBillDetailRides.detail_ride_id')
                ));
                $sheetRideDetailRide['detail_ride_id'] = $detail_ride['TransportBillDetailRides']['detail_ride_id'];
                $sheetRideDetailRide['departure_destination_id'] = NULL;
                $sheetRideDetailRide['arrival_destination_id'] = NULL;
            }
        } elseif ($sheetRideDetailRide['from_customer_order'] == '1'
            && $sheetRideDetailRide['type_ride'] == '2') {

            if ($sheetRideDetailRide['status_id'] <= StatusEnum::mission_closed) {
                $detail_ride = $this->TransportBillDetailRides->find('first', array(
                    'conditions' => array('TransportBillDetailRides.id' => $sheetRideDetailRide['detail_ride_id']),
                    'fields' => array('TransportBillDetailRides.departure_destination_id',
                        'TransportBillDetailRides.arrival_destination_id',
                        'TransportBillDetailRides.lot_id'
                    )
                ));
                if($detail_ride['TransportBillDetailRides']['lot_id']==1) {
                    $sheetRideDetailRide['departure_destination_id'] = $detail_ride['TransportBillDetailRides']['departure_destination_id'];
                    if (empty($sheetRideDetailRide['arrival_destination_id'])) {
                        $sheetRideDetailRide['arrival_destination_id'] = $detail_ride['TransportBillDetailRides']['arrival_destination_id'];
                    }
                }
                $sheetRideDetailRide['detail_ride_id'] = NULL;
            }
        }
        if (isset($sheetRideDetailRide['detail_ride_id'])) {
            $data['SheetRideDetailRides']['detail_ride_id'] = $sheetRideDetailRide['detail_ride_id'];
        } else {
            $data['SheetRideDetailRides']['detail_ride_id'] = NULL;
        }
        if (isset($sheetRideDetailRide['departure_destination_id'])) {
            $data['SheetRideDetailRides']['departure_destination_id'] = $sheetRideDetailRide['departure_destination_id'];
        } else {
            $data['SheetRideDetailRides']['departure_destination_id'] = NULL;
        }
        if (isset($sheetRideDetailRide['arrival_destination_id'])) {
            $data['SheetRideDetailRides']['arrival_destination_id'] = $sheetRideDetailRide['arrival_destination_id'];
        } else {
            $data['SheetRideDetailRides']['arrival_destination_id'] = NULL;
        }
        if (isset($sheetRideDetailRide['price'])) {
            $data['SheetRideDetailRides']['price'] = $sheetRideDetailRide['price'];
        } else {
            $data['SheetRideDetailRides']['price'] = 0;
        }

        if ($sheetRideDetailRide['status_id'] <= StatusEnum::mission_closed) {
            if (isset($sheetRideDetailRide['supplier_id'])) {
                $data['SheetRideDetailRides']['supplier_id'] = $sheetRideDetailRide['supplier_id'];
            } else {
                $data['SheetRideDetailRides']['supplier_id'] = Null;
            }
            if (isset($sheetRideDetailRide['supplier_final_id'])) {
                $data['SheetRideDetailRides']['supplier_final_id'] = $sheetRideDetailRide['supplier_final_id'];
                $clientId = $data['SheetRideDetailRides']['supplier_final_id'];
            } else {
                $data['SheetRideDetailRides']['supplier_final_id'] = NULL;
                $clientId = Null;
            }
        }else {
            if (isset($sheetRideDetailRide['supplier_final_id'])) {
                $clientId = $sheetRideDetailRide['supplier_final_id'];
            } else {
                $clientId = Null;
            }
        }

        $data['SheetRideDetailRides']['planned_start_date'] = $sheetRideDetailRide['planned_start_date'];
        $data['SheetRideDetailRides']['real_start_date'] = $sheetRideDetailRide['real_start_date'];
        $data['SheetRideDetailRides']['planned_end_date'] = $sheetRideDetailRide['planned_end_date'];
        $data['SheetRideDetailRides']['real_end_date'] = $sheetRideDetailRide['real_end_date'];
        $data['SheetRideDetailRides']['km_departure'] = $sheetRideDetailRide['km_departure'];
        $data['SheetRideDetailRides']['km_arrival_estimated'] = $sheetRideDetailRide['km_arrival_estimated'];
        $data['SheetRideDetailRides']['km_arrival'] = $sheetRideDetailRide['km_arrival'];
        if(isset($sheetRideDetailRide['mission_cost'])){
            $data['SheetRideDetailRides']['mission_cost'] = $sheetRideDetailRide['mission_cost'];
            $data['SheetRideDetailRides']['amount_remaining'] = $sheetRideDetailRide['mission_cost'];
        }else {
            $data['SheetRideDetailRides']['mission_cost'] = 0;
            $data['SheetRideDetailRides']['amount_remaining'] = 0;
        }
        if(isset($sheetRideDetailRide['toll'])){
            $data['SheetRideDetailRides']['toll'] = $sheetRideDetailRide['toll'];
        }else {
            $data['SheetRideDetailRides']['toll'] ='';
        }
        $start_date = $data['SheetRideDetailRides']['real_start_date'];
        $end_date = $data['SheetRideDetailRides']['real_end_date'];
        if ($sheetRideDetailRide['status_id'] <= StatusEnum::mission_closed) {
            $data['SheetRideDetailRides']['status_id'] = $this->updateStatusSheet($start_date, $end_date, 0);
        }
        if (isset($data['SheetRideDetailRides']['detail_ride_id'])) {
            $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validate;
        } else {
            if(Configure::read("transport_personnel") == '1'){
                $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validateWithoutCommercial;
            }else {
                $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validatePersonalizedRide;
            }
        }
        $data['SheetRideDetailRides']['modified_id'] = $this->Session->read('Auth.User.id');
        $save = false ;
        if ($this->SheetRideDetailRides->save($data)) {
            $this->saveUserAction(SectionsEnum::mission, $sheetRideDetailRideId, $this->Session->read('Auth.User.id'), ActionsEnum::edit);
            //debug($this->SheetRideDetailRides->validationErrors);die();
            if (isset($sheetRideDetailRide['reservation_cost'])) {
                $reservationCost = $sheetRideDetailRide['reservation_cost'];
            }else {
                $reservationCost = 0;
            }
            if (isset($sheetRideDetailRide['price_recovered'])) {
                $priceRecovered = $sheetRideDetailRide['price_recovered'];
            }else {
                $priceRecovered = 0;
            }
            if ((($previousCarOffshore == 2) && ($carOffshore == 2))||
                ($previousSubcontractorId!=null && $subcontractorId !=null)
            ) {
                $this->Reservation->editReservation($carId, $sheetRideDetailRideId, $reservationCost,
                    $subcontractorId, null,$priceRecovered );
            } elseif ((($previousCarOffshore == 1) && ($carOffshore == 2)) ||
                ($subcontractorId!=null)
            ) {
                $this->Reservation->addReservation($carId, $sheetRideDetailRideId, $reservationCost,
                    $subcontractorId, null,$priceRecovered);
            } elseif ((($previousCarOffshore == 2) && ($carOffshore == 1))||
                ($subcontractorId==null)
            ) {
                $this->Reservation->deleteReservation($sheetRideDetailRideId);
            }
            if (!empty($attachments)) {
                $supplierId = $sheetRideDetailRide['supplier_id'];
                $this->updateAttachments($attachments, $sheetRideDetailRideId, $supplierId, $precedentSupplierId);
            }
            if (isset($sheetRideDetailRide['edit_lot']) && $sheetRideDetailRide['edit_lot'] == 1) {
                if (!empty($lots)) {
                    $existedBill = $this->Bill->getBillsByConditions(array('Bill.sheet_ride_detail_ride_id' => $sheetRideDetailRideId), 'first');
                    if (!empty($existedBill)) {
                        $billId = $existedBill['Bill']['id'];
                        $this->Bill->updateExitBill($lots, $sheetRideDetailRideId, $clientId, $billId);
                    } else {
                        $typeBill = BillTypesEnum::exit_order;
                        $referenceBill = $this->Parameter->getNextBillReferenceSaved($typeBill);
                        $userId = $this->Session->read('Auth.User.id');
                        $this->Bill->addExitBill($lots, $sheetRideDetailRideId, $clientId,$referenceBill,$userId);
                    }
                } else {
                    $existedBill = $this->Bill->getBillsByConditions(array('Bill.sheet_ride_detail_ride_id' => $sheetRideDetailRideId), 'first');
                    if (!empty($existedBill)) {
                        $billId = $existedBill['Bill']['id'];
                        $this->Bill->deleteExitBill($billId);
                    }
                }
            }

            if (!empty($sheetRideDetailRideMarchandises)) {
                $this->SheetRideDetailRideMarchandise->saveMarchandises($sheetRideDetailRideMarchandises, $sheetRideDetailRideId);
            }
            if (!empty($sheetRideDetailRide['transport_bill_detail_ride'])) {
                if ($precedentTransportBillDetailRideId == $sheetRideDetailRide['transport_bill_detail_ride']) {
                    $this->TransportBillDetailRides->updateStatusTransportBillDetailRide($sheetRideDetailRide['transport_bill_detail_ride']);
                } else {
                    $this->TransportBillDetailRides->updateStatusTransportBillDetailRide($precedentTransportBillDetailRideId);
                    $this->TransportBillDetailRides->updateStatusTransportBillDetailRide($sheetRideDetailRide['transport_bill_detail_ride']);
                }

            }
            /*
                    * modified : 20/03/2019
                    * */

            $synchronizationFrBc = $this->Parameter->getCodesParameterVal('synchronization_fr_bc');

            if ($synchronizationFrBc == 1) {
                $transportBillDetailRide = $this->TransportBillDetailRides->getTransportBillDetailRideBySheetRideDetailRideId($sheetRideDetailRideId);
                if (!empty($transportBillDetailRide)) {
                    $sheetRideDetailRide = $this->SheetRideDetailRides->getSheetRideDetailRideById($sheetRideDetailRideId);
                    if ($transportBillDetailRide['TransportBillDetailRides']['nb_trucks'] == 1) {
                        $this->TransportBillDetailRides->updateTransportBillDetailRideInformations($sheetRideDetailRide, $transportBillDetailRide);
                    }

                }
            }
            $save = true;
        }
        return $save ;
    }



    function add_Ride_sheetRide(
        $sheetRideDetailRide = null,
        $reference = null,
        $sheetRideId = null,
        $carId = null,
        $carOffshore = null,
        $subcontractorId = null
    )
    {

        if (isset($sheetRideDetailRide['Attachment'])) {
            $attachments = $sheetRideDetailRide['Attachment'];
        } else {
            $attachments = array();
        }
        if (isset($sheetRideDetailRide['lots'])) {
            $lots = $sheetRideDetailRide['lots'];
        } else {
            $lots = array();
        }
        if (isset($sheetRideDetailRide['SheetRideDetailRideMarchandise'])) {
            $sheetRideDetailRideMarchandises = $sheetRideDetailRide['SheetRideDetailRideMarchandise'];
        } else {
            $sheetRideDetailRideMarchandises = array();
        }
        // Get reference mission automatic parameter reference_mi_auto
        $referenceMission = $this->Parameter->getCodesParameterVal('reference_mi_auto');
        if ($referenceMission == '1') {
            $data['SheetRideDetailRides']['reference'] = $sheetRideDetailRide['reference'];
        } else {
            if ($reference != null) {
                //$referenceSheetRideDetailRide = $this->getReferenceSheetRideDetailRide($sheetRideId, $reference);
                $referenceSheetRide = $this->SheetRide->getReferenceSheetRide($sheetRideId);
                $data['SheetRideDetailRides']['reference'] = $referenceSheetRide.'/'.$sheetRideDetailRide['order_mission'];
            }
        }
        if (isset($sheetRideDetailRide['ride_category_id'])) {
            $data['SheetRideDetailRides']['ride_category_id'] = $sheetRideDetailRide['ride_category_id'];
        }
        $data['SheetRideDetailRides']['order_mission'] = $sheetRideDetailRide['order_mission'];
        $this->request->data['SheetRideDetailRides']['planned_start_date'] = $sheetRideDetailRide['planned_start_date'];
        $this->createDatetimeFromDatetime('SheetRideDetailRides', 'planned_start_date');
        $sheetRideDetailRide['planned_start_date'] = $this->request->data['SheetRideDetailRides']['planned_start_date'];

        $this->request->data['SheetRideDetailRides']['real_start_date'] = $sheetRideDetailRide['real_start_date'];
        $this->createDatetimeFromDatetime('SheetRideDetailRides', 'real_start_date');
        $sheetRideDetailRide['real_start_date'] = $this->request->data['SheetRideDetailRides']['real_start_date'];

        $this->request->data['SheetRideDetailRides']['planned_end_date'] = $sheetRideDetailRide['planned_end_date'];
        $this->createDatetimeFromDatetime('SheetRideDetailRides', 'planned_end_date');
        $sheetRideDetailRide['planned_end_date'] = $this->request->data['SheetRideDetailRides']['planned_end_date'];

        $this->request->data['SheetRideDetailRides']['real_end_date'] = $sheetRideDetailRide['real_end_date'];
        $this->createDatetimeFromDatetime('SheetRideDetailRides', 'real_end_date');
        $sheetRideDetailRide['real_end_date'] = $this->request->data['SheetRideDetailRides']['real_end_date'];

        if (isset($sheetRideDetailRide['observation_id'])) {
            $data['SheetRideDetailRides']['observation_id'] = $sheetRideDetailRide['observation_id'];
        } else {
            $data['SheetRideDetailRides']['observation_id'] = null;
        }
        if (isset($sheetRideDetailRide['transport_bill_detail_ride'])) {
            $data['SheetRideDetailRides']['transport_bill_detail_ride_id'] = $sheetRideDetailRide['transport_bill_detail_ride'];
        } else {
            if (isset($sheetRideDetailRide['from_customer_order']) && $sheetRideDetailRide['from_customer_order'] == '1') {
                $data['SheetRideDetailRides']['transport_bill_detail_ride_id'] = $sheetRideDetailRide['detail_ride_id'];
            }
        }
        if (isset($sheetRideDetailRide['from_customer_order']) && $sheetRideDetailRide['from_customer_order'] == '1' && $sheetRideDetailRide['type_ride'] == '1') {
            $detail_ride = $this->TransportBillDetailRides->find('first', array(
                'conditions' => array('TransportBillDetailRides.id' => $sheetRideDetailRide['detail_ride_id']),
                'fields' => array('TransportBillDetailRides.detail_ride_id')
            ));
            $sheetRideDetailRide['detail_ride_id'] = $detail_ride['TransportBillDetailRides']['detail_ride_id'];
            $sheetRideDetailRide['departure_destination_id'] = NULL;
            $sheetRideDetailRide['arrival_destination_id'] = NULL;

        } elseif ($sheetRideDetailRide['from_customer_order'] == '1' && $sheetRideDetailRide['type_ride'] == '2') {
            $detail_ride = $this->TransportBillDetailRides->find('first', array(
                'conditions' => array('TransportBillDetailRides.id' => $sheetRideDetailRide['detail_ride_id']),
                'fields' => array('TransportBillDetailRides.departure_destination_id',
                    'TransportBillDetailRides.arrival_destination_id','TransportBillDetailRides.lot_id'),

            ));
            if($detail_ride['TransportBillDetailRides']['lot_id']==1){
                $sheetRideDetailRide['departure_destination_id'] = $detail_ride['TransportBillDetailRides']['departure_destination_id'];
                if(empty($sheetRideDetailRide['arrival_destination_id'])) {
                    $sheetRideDetailRide['arrival_destination_id'] = $detail_ride['TransportBillDetailRides']['arrival_destination_id'];
                }
                $sheetRideDetailRide['detail_ride_id'] = NULL;
            }


        }
        if (isset($sheetRideDetailRide['source'])) {
            $data['SheetRideDetailRides']['source'] = $sheetRideDetailRide['source'];
        }
        if (isset($sheetRideDetailRide['from_customer_order'])) {
            $data['SheetRideDetailRides']['from_customer_order'] = $sheetRideDetailRide['from_customer_order'];
        }else {
            $data['SheetRideDetailRides']['from_customer_order'] = 1;
        }
        if (isset($sheetRideDetailRide['from_customer_order'])) {
            $data['SheetRideDetailRides']['type_ride'] = $sheetRideDetailRide['type_ride'];
        }else {
            $data['SheetRideDetailRides']['type_ride'] = 1;
        }
        if (isset($sheetRideDetailRide['from_customer_order'])) {
            $data['SheetRideDetailRides']['invoiced_ride'] = $sheetRideDetailRide['invoiced_ride'];
        }else {
            $data['SheetRideDetailRides']['invoiced_ride'] = 1;
        }
        if(isset($data['SheetRideDetailRides']['truck_full'])){
            $data['SheetRideDetailRides']['truck_full'] = $sheetRideDetailRide['truck_full'];
        }else {
            $data['SheetRideDetailRides']['truck_full'] = 1;
        }

        if (isset($sheetRideDetailRide['return_mission'])) {
            $data['SheetRideDetailRides']['return_mission'] = $sheetRideDetailRide['return_mission'];
        } else {
            $data['SheetRideDetailRides']['return_mission'] = 2;
        }
        if (isset($sheetRideDetailRide['type_price'])) {
            $data['SheetRideDetailRides']['type_price'] = $sheetRideDetailRide['type_price'];
        } else {
            $data['SheetRideDetailRides']['type_price'] = 1;
        }
        if (isset($sheetRideDetailRide['type_pricing'])) {
            $data['SheetRideDetailRides']['type_pricing'] = $sheetRideDetailRide['type_pricing'];
        } else {
            $data['SheetRideDetailRides']['type_pricing'] = 1;
        }
        if (isset($sheetRideDetailRide['price_recovered'])) {
            $data['SheetRideDetailRides']['price_recovered'] = $sheetRideDetailRide['price_recovered'];
        } else {
            $data['SheetRideDetailRides']['price_recovered'] = 2;
        }
        if (isset($sheetRideDetailRide['tonnage_id'])) {
            $data['SheetRideDetailRides']['tonnage_id'] = $sheetRideDetailRide['tonnage_id'];
        } else {
            $data['SheetRideDetailRides']['tonnage_id'] = NULL;
        }
        if (isset($sheetRideDetailRide['remaining_time'])) {
            $data['SheetRideDetailRides']['remaining_time'] = $sheetRideDetailRide['remaining_time'];
        } else {
            $data['SheetRideDetailRides']['remaining_time'] = 0;
        }
        if (isset($sheetRideDetailRide['note'])) {
            $data['SheetRideDetailRides']['note'] = $sheetRideDetailRide['note'];
        }
        $data['SheetRideDetailRides']['sheet_ride_id'] = $sheetRideId;
        if (isset($sheetRideDetailRide['detail_ride_id'])) {
            $data['SheetRideDetailRides']['detail_ride_id'] = $sheetRideDetailRide['detail_ride_id'];
        }
        if (isset($sheetRideDetailRide['departure_destination_id'])) {
            $data['SheetRideDetailRides']['departure_destination_id'] = $sheetRideDetailRide['departure_destination_id'];
        }
        if (isset($sheetRideDetailRide['arrival_destination_id'])) {
            $data['SheetRideDetailRides']['arrival_destination_id'] = $sheetRideDetailRide['arrival_destination_id'];
        }
        if (isset($sheetRideDetailRide['price'])) {
            $data['SheetRideDetailRides']['price'] = $sheetRideDetailRide['price'];
        }
        if (isset($sheetRideDetailRide['ride_category_id'])) {
            $data['SheetRideDetailRides']['ride_category_id'] = $sheetRideDetailRide['ride_category_id'];
        }
        if (isset($sheetRideDetailRide['supplier_id'])) {
            $data['SheetRideDetailRides']['supplier_id'] = $sheetRideDetailRide['supplier_id'];
        }
        if (isset($sheetRideDetailRide['supplier_final_id'])) {
            $data['SheetRideDetailRides']['supplier_final_id'] = $sheetRideDetailRide['supplier_final_id'];
            $clientId = $sheetRideDetailRide['supplier_final_id'];
        } else {
            $clientId = NUll;
        }
        $data['SheetRideDetailRides']['planned_start_date'] = $sheetRideDetailRide['planned_start_date'];
        $data['SheetRideDetailRides']['real_start_date'] = $sheetRideDetailRide['real_start_date'];
        $data['SheetRideDetailRides']['planned_end_date'] = $sheetRideDetailRide['planned_end_date'];
        $data['SheetRideDetailRides']['real_end_date'] = $sheetRideDetailRide['real_end_date'];
        $data['SheetRideDetailRides']['km_departure'] = $sheetRideDetailRide['km_departure'];
        $data['SheetRideDetailRides']['km_arrival_estimated'] = $sheetRideDetailRide['km_arrival_estimated'];
        $data['SheetRideDetailRides']['km_arrival'] = $sheetRideDetailRide['km_arrival'];

        if(isset($sheetRideDetailRide['mission_cost'])){
            $data['SheetRideDetailRides']['mission_cost'] = $sheetRideDetailRide['mission_cost'];
            $data['SheetRideDetailRides']['amount_remaining'] = $sheetRideDetailRide['mission_cost'];
        }else {
            $data['SheetRideDetailRides']['mission_cost'] = 0;
            $data['SheetRideDetailRides']['amount_remaining'] = 0;
        }
        if(isset($sheetRideDetailRide['toll'])){
            $data['SheetRideDetailRides']['toll'] = $sheetRideDetailRide['toll'];
        }else {
            $data['SheetRideDetailRides']['toll'] = '';
        }
        $start_date = $data['SheetRideDetailRides']['real_start_date'];
        $end_date = $data['SheetRideDetailRides']['real_end_date'];
        $data['SheetRideDetailRides']['status_id'] = $this->updateStatusSheet($start_date, $end_date, 0);
        if (isset($sheetRideDetailRide['attachment1'])) {
            $data['SheetRideDetailRides']['attachment1'] = $sheetRideDetailRide['attachment1'];
        }
        if (isset($sheetRideDetailRide['attachment2'])) {
            $data['SheetRideDetailRides']['attachment2'] = $sheetRideDetailRide['attachment2'];
        }
        if (isset($sheetRideDetailRide['attachment3'])) {
            $data['SheetRideDetailRides']['attachment3'] = $sheetRideDetailRide['attachment3'];
        }
        if (isset($sheetRideDetailRide['attachment4'])) {
            $data['SheetRideDetailRides']['attachment4'] = $sheetRideDetailRide['attachment4'];
        }
        if (isset($sheetRideDetailRide['attachment5'])) {
            $data['SheetRideDetailRides']['attachment5'] = $sheetRideDetailRide['attachment5'];
        }
        $start_date = $data['SheetRideDetailRides']['real_start_date'];
        $end_date = $data['SheetRideDetailRides']['real_end_date'];
        $data['SheetRideDetailRides']['status_id'] = $this->updateStatusSheet($start_date, $end_date, 0);
        if (isset($data['SheetRideDetailRides']['detail_ride_id'])) {
            $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validate;
        } else {
            if(Configure::read("transport_personnel") == '1'){
                $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validateWithoutCommercial;
            }else {
                $this->SheetRideDetailRides->validate = $this->SheetRideDetailRides->validatePersonalizedRide;
            }
        }
        $data['SheetRideDetailRides']['user_id'] = $this->Session->read('Auth.User.id');
        $this->SheetRideDetailRides->create();
        if ($this->SheetRideDetailRides->save($data)) {
            $save = true;
            $sheetRideDetailRideId = $this->SheetRideDetailRides->getInsertID();
            if (isset($sheetRideDetailRide['reservation_cost'])) {
                $reservationCost = $sheetRideDetailRide['reservation_cost'];
            }else {
                $reservationCost =0;
            }
            if ($carOffshore == 2) {

                $this->Reservation->addReservation($carId, $sheetRideDetailRideId, $reservationCost);
            }
            if($subcontractorId!=null){
                $this->Reservation->addReservation(null, $sheetRideDetailRideId, $reservationCost, $subcontractorId);
            }
            if (!empty($attachments)) {
                $supplierId = $sheetRideDetailRide['supplier_id'];
                $this->saveAttachments($attachments, $sheetRideDetailRideId, $supplierId);
            }
            if (!empty($lots)) {
                $typeBill = BillTypesEnum::exit_order;
                $referenceBill = $this->Parameter->getNextBillReferenceSaved($typeBill);
                $userId = $this->Session->read('Auth.User.id');
                $this->Bill->addExitBill($lots, $sheetRideDetailRideId, $clientId,$referenceBill,$userId);
            }
            if (!empty($sheetRideDetailRideMarchandises)) {
                $this->SheetRideDetailRideMarchandise->saveMarchandises($sheetRideDetailRideMarchandises, $sheetRideDetailRideId);
            }
            if (!empty($sheetRideDetailRide['transport_bill_detail_ride'])) {
                $this->TransportBillDetailRides->updateStatusTransportBillDetailRide($sheetRideDetailRide['transport_bill_detail_ride']);
            }
            /*
                   * modified : 20/03/2019
                   * */

            $synchronizationFrBc = $this->Parameter->getCodesParameterVal('synchronization_fr_bc');

            if ($synchronizationFrBc == 1) {
                $transportBillDetailRide = $this->TransportBillDetailRides->getTransportBillDetailRideBySheetRideDetailRideId($sheetRideDetailRideId);
                if (!empty($transportBillDetailRide)) {
                    $sheetRideDetailRide = $this->SheetRideDetailRides->getSheetRideDetailRideById($sheetRideDetailRideId);
                    if ($transportBillDetailRide['TransportBillDetailRides']['nb_trucks'] == 1) {
                        $this->TransportBillDetailRides->updateTransportBillDetailRideInformations($sheetRideDetailRide, $transportBillDetailRide);
                    }

                }
            }
        }

    }


    public function updateAttachments(
        $attachments = null,
        $sheetRideDetailRideId = null,
        $supplierId = null,
        $precedentSupplierId = null
    )
    {
        //on va verifier si c le mm client
        if ($supplierId == $precedentSupplierId) {
            // recuperer les types attachments de ce client
            $attachmentTypes = $this->AttachmentType->getAttachmentTypeByParameter($supplierId);
            foreach ($attachmentTypes as $attachmentType) {
                // recuperer l'attachment existant pour le type courant
                $attachmentExisted = $this->Attachment->find('first',
                    array(
                        'conditions' => array(
                            'Attachment.article_id' => $sheetRideDetailRideId,
                            'Attachment.attachment_type_id' => $attachmentType['AttachmentType']['id']
                        )
                    ));
                if (!empty($attachmentExisted)) {
                    $attachmentId = $attachmentExisted['Attachment']['id'];
                    // si l'attachment a été vider
                    if ($attachments['file' . $attachmentType['AttachmentType']['id']] == '') {
                        // supprimer l'attachment dans le dossier
                        $this->Attachment->deleteAttachmentByType('attachments/missions/' . $attachmentType['AttachmentType']['id'] . '/',
                            $attachmentId);
                        // supprimer l'attachment dans la bdd
                        $this->Attachment->deleteAll(array('Attachment.id' => $attachmentId), false);
                    } else {

                        if (isset($attachments[$attachmentType['AttachmentType']['id']])) {
                            // si l'attachment a été modifié
                            if (!empty ($attachments[$attachmentType['AttachmentType']['id']]['tmp_name'])) {
                                // supprimer l'attachment precedent
                                $this->Attachment->deleteAttachmentByType('attachments/missions/' . $attachmentType['AttachmentType']['id'] . '/',
                                    $attachmentId);
                                // enregister le nouvel attachment
                                $this->request->data['Attachment'][$attachmentType['AttachmentType']['id']] = $attachments[$attachmentType['AttachmentType']['id']];

                                $this->verifyAttachmentByType('Attachment', $attachmentType['AttachmentType']['id'],
                                    'attachments/missions/' . $attachmentType['AttachmentType']['id'] . '/', 'add', 0, 0,
                                    null);

                                $attachment = array();
                                $attachment['Attachment']['id'] = $attachmentId;
                                $attachment['Attachment']['attachment_number'] = $attachments[$attachmentType['AttachmentType']['id']]['attachment_number'];
                                $attachment['Attachment']['name'] = $this->request->data['Attachment']['name'];
                                $attachment['Attachment']['article_id'] = $sheetRideDetailRideId;
                                $attachment['Attachment']['attachment_type_id'] = $attachmentType['AttachmentType']['id'];
                                $attachment['Attachment']['last_modifier_id'] = $this->Session->read('Auth.User.id');
                                $this->Attachment->save($attachment);
                            }
                            // si l'attachment n'a pas été modifié rien à faire
                        }
                    }
                } else {
                    if (isset($attachments[$attachmentType['AttachmentType']['id']])) {
                        // si l'attachment a été modifié
                        if (!empty ($attachments[$attachmentType['AttachmentType']['id']]['tmp_name'])) {
                            // enregister le nouvel attachment
                            $this->request->data['Attachment'][$attachmentType['AttachmentType']['id']] = $attachments[$attachmentType['AttachmentType']['id']];

                            $this->verifyAttachmentByType('Attachment', $attachmentType['AttachmentType']['id'],
                                'attachments/missions/' . $attachmentType['AttachmentType']['id'] . '/', 'add', 0, 0,
                                null);
                            $attachment = array();
                            $this->Attachment->create();
                            $attachment['Attachment']['attachment_number'] = $attachments[$attachmentType['AttachmentType']['id']]['attachment_number'];
                            $attachment['Attachment']['name'] = $this->request->data['Attachment']['name'];
                            $attachment['Attachment']['article_id'] = $sheetRideDetailRideId;
                            $attachment['Attachment']['attachment_type_id'] = $attachmentType['AttachmentType']['id'];
                            $attachment['Attachment']['last_modifier_id'] = $this->Session->read('Auth.User.id');
                            $this->Attachment->save($attachment);
                        }
                        // si l'attachment n'a pas été modifié rien à faire
                    }
                }
            }
        } else {
            // afficher le type d'attachment du l'ancien client
            $attachmentTypes = $this->AttachmentType->getAttachmentTypeByParameter($precedentSupplierId);

            foreach ($attachmentTypes as $attachmentType) {
                // recuperer l'attachment existant pour le type courant
                $attachmentExisted = $this->Attachment->find('first',
                    array(
                        'conditions' => array(
                            'Attachment.article_id' => $sheetRideDetailRideId,
                            'Attachment.attachment_type_id' => $attachmentType['AttachmentType']['id']
                        )
                    ));
                if (!empty($attachmentExisted)) {
                    $attachmentId = $attachmentExisted['Attachment']['id'];
                    // supprimer l'attachment dans le dossier
                    $this->Attachment->deleteAttachmentByType('attachments/missions/' . $attachmentType['AttachmentType']['id'] . '/',
                        $attachmentId);
                    // supprimer l'attachment dans la bdd
                    $this->Attachment->deleteAll(array('Attachment.id' => $attachmentId), false);
                }

            }

            $this->saveAttachments($attachments, $sheetRideDetailRideId, $supplierId);

        }
    }

    public function saveAttachments($attachments = null, $sheetRideDetailRideId = null, $supplierId = null)
    {
        $attachmentTypes = $this->AttachmentType->getAttachmentTypeByParameter($supplierId);
        foreach ($attachmentTypes as $attachmentType) {
            if (isset($attachments[$attachmentType['AttachmentType']['id']])) {
                if (!empty ($attachments[$attachmentType['AttachmentType']['id']]['tmp_name'])) {

                    $this->request->data['Attachment'][$attachmentType['AttachmentType']['id']] = $attachments[$attachmentType['AttachmentType']['id']];
                    $this->verifyAttachmentByType('Attachment', $attachmentType['AttachmentType']['id'],
                        'attachments/missions/' . $attachmentType['AttachmentType']['id'] . '/', 'add', 0, 0, null);


                    $this->Attachment->create();
                    $attachment = array();
                    $attachment['Attachment']['attachment_number'] = $attachments[$attachmentType['AttachmentType']['id']]['attachment_number'];
                    $attachment['Attachment']['name'] = $this->request->data['Attachment']['name'];
                    $attachment['Attachment']['article_id'] = $sheetRideDetailRideId;
                    $attachment['Attachment']['attachment_type_id'] = $attachmentType['AttachmentType']['id'];
                    $attachment['Attachment']['user_id'] = $this->Session->read('Auth.User.id');
                    $this->Attachment->save($attachment);

                }
            }
        }
    }

    public function calculateDiscountValue($discountPercentage = null, $totalHt = null){
        if($discountPercentage>100){
            $discountPercentage =100;
        }
        $discountValue = $discountPercentage * $totalHt / 100;
        return $discountValue;
    }
    public function calculateDiscountTva($discountPercentage = null , $totalTva = null){
        if($discountPercentage>100){
            $discountPercentage =100;
        }
        $discountTva = $discountPercentage * $totalTva / 100;
        return $discountTva;
    }
    public function calculateStampValue($paymentMethod, $totalTtc){
        if ($paymentMethod == 6) {
            $stamp = $totalTtc / 100;
            if ($stamp >= 2500) {
                $stamp = 2500;
            }
            return $stamp;
        }

    }

    public function getParcsUserIdsArray($userId)
    {
        $parcs = $this->UserParc->find('all', array(
            'recursive' => -1,
            'conditions' => array('UserParc.user_id' => $userId),
            'fields' => array('UserParc.parc_id')
        ));
        $parcsIds = array();
        if (!empty($parcs)) {
            foreach ($parcs as $parc) {
                array_push($parcsIds,$parc['UserParc']['parc_id'] );
            }
        }
        //var_dump($parcsId); die();
        return $parcsIds;
    }

    public function getCarConditionsUserParcs($conditionsCar)
    {
        $userId = intval($this->Auth->user('id'));
        $parcIds = $this->getParcsUserIdsArray($userId);
        if (!$this->IsAdministrator){
            if (!empty($parcIds)) {
                $conditionsCar = array_merge($conditionsCar, array('Car.parc_id' => $parcIds));
            }
        }
        return $conditionsCar;
    }

    public function getUserParcs()
    {
        $userId = intval($this->Auth->user('id'));
        $parcIds = $this->getParcsUserIdsArray($userId);
        if ($this->IsAdministrator) {
            $parcs = $this->Parc->getParcs('list');
        } else {
            if (!empty($parcIds)) {
                $parcs = $this->Parc->getParcByIds($parcIds);
            } else {
                $parcs = $this->Parc->getParcs('list');
            }
        }
        return $parcs;
    }


}
