<?php

App::uses('AppController', 'Controller');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Statistics Controller
 *
 * @property Statistic $Statistic
 * @property Fuel $Fuel
 * @property Customer $Customer
 * @property EventType $EventType
 * @property Tva $Tva
 * @property EventTypeCategory $EventTypeCategory
 * @property Parc $Parc
 * @property CustomerGroup $CustomerGroup
 * @property Supplier $Supplier
 * @property Carmodel $Carmodel
 * @property FuelLog $FuelLog
 * @property Company $Company
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class StatisticsController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'RequestHandler');
    public $uses = array(
        'Statistic',
        'Customer',
        'EventType',
        'EventTypeCategory',
        'Parc',
        'Carmodel',
        'FuelLog',
        'Company',
        'CustomerGroup',
        'Price',
        'TransportRideDetailRides',
        'PriceRideCategory',
        'Payment',
        'Fuel'
    );

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $userId = $this->Auth->user('id');
        $resultGestionCommerciale = $this->verifyUserPermission(SectionsEnum::statistique_gestion_commerciale, $userId, ActionsEnum::view,"Statistics", null, "Statistic", null,1);
        $resultGestionConsommaton = $this->verifyUserPermission(SectionsEnum::statistique_gestion_des_consommations, $userId, ActionsEnum::view,"Statistics", null, "Statistic", null,1);
        $resultGestionCar= $this->verifyUserPermission(SectionsEnum::statistique_gestion_des_vehicules, $userId, ActionsEnum::view,"Statistics", null, "Statistic", null,1);

        $this->set(compact('resultGestionCommerciale','resultGestionConsommaton','resultGestionCar'));
        $this->setTimeActif();

    }


    public function indexCommercial()
    {
        $this->setTimeActif();

    }

    public function kmbymonth()
    {
        $this->setTimeActif();
        if (isset($this->request->data['Statistic']['car_id']) && !empty($this->request->data['Statistic']['car_id'])) {
            $car_id = $this->request->data['Statistic']['car_id'];
        } else {
            $car_id = null;
        }
        if (isset($this->request->data['Statistic']['year']) && $this->request->data['Statistic']['year'] > 1000 && $this->request->data['Statistic']['year'] < 2100) {
            $year = $this->request->data['Statistic']['year'];
        } else {
            $year = null;
            $this->request->data['Statistic']['year'] = date("Y");
        }
        $results = $this->Statistic->getKmByMonth($car_id, $year);
        //Get the structure of the car name from parameters
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list',
            array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc, Car.code asc'));
        $this->set(compact('results', 'cars', 'param'));
    }

    public function listKmByMonth()
    {
        $this->setTimeActif();
        if (isset($this->request->data['Statistic']['car_id']) && !empty($this->request->data['Statistic']['car_id'])) {
            $car_id = $this->request->data['Statistic']['car_id'];
        } else {
            $car_id = null;
        }
        if (isset($this->request->data['Statistic']['year']) && $this->request->data['Statistic']['year'] > 1000 && $this->request->data['Statistic']['year'] < 2100) {
            $year = $this->request->data['Statistic']['year'];
        } else {
            $year = null;
            $this->request->data['Statistic']['year'] = date("Y");
        }
        if (isset($this->request->data['Statistic']['min_month']) && $this->request->data['Statistic']['min_month'] > 0 && $this->request->data['Statistic']['min_month'] < 13) {
            $min_month = $this->request->data['Statistic']['min_month'];
        } else {
            $min_month = null;
        }
        if (isset($this->request->data['Statistic']['max_month']) && $this->request->data['Statistic']['max_month'] > 0 && $this->request->data['Statistic']['max_month'] < 13) {
            $max_month = $this->request->data['Statistic']['max_month'];
        } else {
            $max_month = null;
        }
        $results = $this->Statistic->getListKmByMonth($car_id, $year, $min_month, $max_month);
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list',
            array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc, Car.code asc'));
        $this->set(compact('results', 'cars', 'param'));
    }

    public function listkmbymonth_pdf()
    {
        $this->setTimeActif();
        $kmmonth = filter_input(INPUT_POST, "kmmonth");

        $kmmonth = explode(",", $kmmonth);

        $car_id = $kmmonth[0];
        $year = $kmmonth[1];
        $min_month = $kmmonth[2];
        $max_month = $kmmonth[3];
        $results = $this->Statistic->getListKmByMonth($car_id, $year, $min_month, $max_month);
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list',
            array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc, Car.code asc'));
        $this->set(compact('results', 'cars', 'param'));
    }

    public function consumptionByMonth()
    {
        $this->setTimeActif();
        if (isset($this->request->data['Statistic']['car_id']) && !empty($this->request->data['Statistic']['car_id'])) {
            $car_id = $this->request->data['Statistic']['car_id'];
        } else {
            $car_id = null;
        }
        if (isset($this->request->data['Statistic']['year']) && $this->request->data['Statistic']['year'] > 1000 && $this->request->data['Statistic']['year'] < 2100) {
            $year = $this->request->data['Statistic']['year'];
        } else {
            $year = null;
            $this->request->data['Statistic']['year'] = date("Y");
        }
        if (isset($this->request->data['Statistic']['min_month']) && $this->request->data['Statistic']['min_month'] > 0 && $this->request->data['Statistic']['min_month'] < 13) {
            $min_month = $this->request->data['Statistic']['min_month'];
        } else {
            $min_month = null;
        }
        if (isset($this->request->data['Statistic']['max_month']) && $this->request->data['Statistic']['max_month'] > 0 && $this->request->data['Statistic']['max_month'] < 13) {
            $max_month = $this->request->data['Statistic']['max_month'];
        } else {
            $max_month = null;
        }
        $results = $this->Statistic->getConsumptionByMonth($car_id, $year, $min_month, $max_month);
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Car.id asc'));
        $parameter = $this->Parameter->find('first', array(
            'recursive' => -1,
            'conditions' => array('code' => 10)
        ));
        $coupon_price = $parameter['Parameter']['val'];
        $this->set(compact('results', 'cars', 'coupon_price', 'param'));
    }

    public function consumptionByMonthsExcel()
    {
        $this->setTimeActif();
        if (isset($this->request->data['car_id']) && !empty($this->request->data['car_id'])) {
            $car_id = $this->request->data['car_id'];
        } else {
            $car_id = null;
        }
        if (isset($this->request->data['year']) && $this->request->data['year'] > 1000 && $this->request->data['year'] < 2100) {
            $year = $this->request->data['year'];
        } else {
            $year = null;
            $this->request->data['year'] = date("Y");
        }
        if (isset($this->request->data['min_month']) && $this->request->data['min_month'] > 0 && $this->request->data['min_month'] < 13) {
            $min_month = $this->request->data['min_month'];
        } else {
            $min_month = null;
        }
        if (isset($this->request->data['max_month']) && $this->request->data['max_month'] > 0 && $this->request->data['max_month'] < 13) {
            $max_month = $this->request->data['max_month'];
        } else {
            $max_month = null;
        }
        $results = $this->Statistic->getConsumptionByMonth($car_id, $year, $min_month, $max_month);
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Car.id asc'));
        $parameter = $this->Parameter->find('first', array(
            'recursive' => -1,
            'conditions' => array('code' => 10)
        ));
        $coupon_price = $parameter['Parameter']['val'];
        $this->set(compact('results', 'cars', 'coupon_price', 'param'));
    }

    public function consumptionbymonth_pdf()
    {
        $consumptionmonth = filter_input(INPUT_POST, "consumptionmonth");

        $consumptionmonth = explode(",", $consumptionmonth);

        $car_id = $consumptionmonth[0];
        $year = $consumptionmonth[1];
        $min_month = $consumptionmonth[2];
        $max_month = $consumptionmonth[3];

        $results = $this->Statistic->getConsumptionByMonth($car_id, $year, $min_month, $max_month);
        $this->Car->virtualFields = array(
            'cnames' => "CONCAT(Carmodel.name, ' ', Car.code)"
        );
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Car.id asc'));
        $parameter = $this->Parameter->find('first', array(
            'recursive' => -1,
            'conditions' => array('code' => 10)
        ));
        $coupon_price = $parameter['Parameter']['val'];
        $this->set(compact('results', 'cars', 'coupon_price', 'param'));
    }

    public function consumptionByWeek()
    {
        $this->setTimeActif();
        if (isset($this->request->data['Statistic']['car_id']) && !empty($this->request->data['Statistic']['car_id'])) {
            $car_id = $this->request->data['Statistic']['car_id'];
        } else {
            $car_id = null;
        }
        if (isset($this->request->data['Statistic']['year']) && $this->request->data['Statistic']['year'] > 1000 && $this->request->data['Statistic']['year'] < 2100) {
            $year = $this->request->data['Statistic']['year'];
        } else {
            $year = null;
            $this->request->data['Statistic']['year'] = date("Y");
        }
        if (isset($this->request->data['Statistic']['month']) && $this->request->data['Statistic']['month'] > 0 && $this->request->data['Statistic']['month'] < 13) {
            $month = $this->request->data['Statistic']['month'];
        } else {
            $month = null;
        }
        if (isset($this->request->data['Statistic']['week'])) {
            $week = $this->request->data['Statistic']['week'];
        } else {
            $week = null;
        }
        $results = $this->Statistic->getConsumptionByWeek($car_id, $year, $month, $week);
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Car.id asc'));
        $parameter = $this->Parameter->find('first', array(
            'recursive' => -1,
            'conditions' => array('code' => 10)
        ));
        $coupon_price = $parameter['Parameter']['val'];
        $this->set(compact('results', 'cars', 'coupon_price', 'param'));
    }

    public function consumptionsDetails()
    { 
        $this->setTimeActif();
        if (isset($this->request->data['Statistic']['car_id']) && !empty($this->request->data['Statistic']['car_id'])) {
            $car_id = $this->request->data['Statistic']['car_id'];
        } else {
            $car_id = null;
        }
        if (isset($this->request->data['Statistic']['date']) && $this->isDate($this->request->data['Statistic']['date'])) {
            $start = str_replace("-", "/", $this->request->data['Statistic']['date']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $start_date = $startdtm->format('Y-m-d 00:00:00');
        } else {
            $start_date = null;
        }
        if (isset($this->request->data['Statistic']['next_date']) && $this->isDate($this->request->data['Statistic']['next_date'])) {
            $end = str_replace("-", "/", $this->request->data['Statistic']['next_date']);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $end_date = $enddtm->format('Y-m-d 00:00:00');
        } else {
            $end_date = null;
        }
        $results = $this->Statistic->getConsumptionsDetails($car_id, $start_date, $end_date);
        
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));
        $parameter = $this->Parameter->find('first', array(
            'recursive' => -1,
            'conditions' => array('code' => array(10)),
            'order' => array('code' => 'ASC')
        ));
        $coupon_price = (int)$parameter['Parameter']['val'];
        $this->set(compact('results', 'cars', 'param', 'coupon_price'));
    }

    public function consumptionsdetails_pdf()
    {

        $carconsumption = filter_input(INPUT_POST, "carconsumption");

        $carconsumption = explode(",", $carconsumption);


        $car_id = $carconsumption[0];

        $start_date = $carconsumption[1];
        $end_date = $carconsumption[2];

        $results = $this->Statistic->getConsumptionsDetails($car_id, $start_date, $end_date);
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));
        $this->set(compact('results', 'cars', 'param'));
    }


    public function export_consumptionsdetails()
    {

        $carconsumption = filter_input(INPUT_POST, "carconsumption");

        $carconsumption = explode(",", $carconsumption);


        $car_id = $carconsumption[0];

        $start_date = $carconsumption[1];
        $end_date = $carconsumption[2];

        $results = $this->Statistic->getConsumptionsDetails($car_id, $start_date, $end_date);
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));
        $parameter = $this->Parameter->find('first', array(
            'recursive' => -1,
            'conditions' => array('code' => array(10)),
            'order' => array('code' => 'ASC')
        ));
        $coupon_price = (int)$parameter['Parameter']['val'];
        $this->set(compact('results', 'cars', 'param', 'coupon_price'));
    }


    public function export_synthese()
    {

        $carconsumption = filter_input(INPUT_POST, "carconsumption");

        $carconsumption = explode(",", $carconsumption);


        $car_id = $carconsumption[0];

        $start_date = $carconsumption[1];
        $end_date = $carconsumption[2];

        $results = $this->Statistic->getConsumptionsDetails($car_id, $start_date, $end_date);
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));
        $parameter = $this->Parameter->find('first', array(
            'recursive' => -1,
            'conditions' => array('code' => array(10)),
            'order' => array('code' => 'ASC')
        ));
        $coupon_price = (int)$parameter['Parameter']['val'];
        $this->set(compact('results', 'cars', 'param', 'coupon_price'));
    }

    public function costbycar()
    {
        $this->setTimeActif();
        if (isset($this->request->data['Statistic']['car_id']) && !empty($this->request->data['Statistic']['car_id'])) {
            $car_id = $this->request->data['Statistic']['car_id'];
        } else {
            $car_id = null;
        }
        if (isset($this->request->data['Statistic']['customer_id']) && !empty($this->request->data['Statistic']['customer_id'])) {
            $customer_id = $this->request->data['Statistic']['customer_id'];
        } else {
            $customer_id = null;
        }
        if (isset($this->request->data['Statistic']['date']) && $this->isDate($this->request->data['Statistic']['date'])) {
            $start = str_replace("-", "/", $this->request->data['Statistic']['date']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $start_date = $startdtm->format('Y-m-d 00:00:00');
        } else {
            $start_date = null;
        }
        if (isset($this->request->data['Statistic']['parc_id']) && !empty($this->request->data['Statistic']['parc_id'])) {
            $parcId = $this->request->data['Statistic']['parc_id'];
        } else {
            $parcId = null;
        }

        if (isset($this->request->data['Statistic']['next_date']) && $this->isDate($this->request->data['Statistic']['next_date'])) {
            $end = str_replace("-", "/", $this->request->data['Statistic']['next_date']);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            if ($this->isDate($enddtm)) {
                $end_date = $enddtm->format('Y-m-d 00:00:00');
            } else {
                $end_date = null;
            }

        } else {
            $end_date = null;
        }
        $results = $this->Statistic->getCostByCar($car_id, $customer_id, $start_date, $end_date,$parcId);
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);
        $userId = $this->Auth->user('id');
        if ($this->IsAdministrator) {
            $parcs = $this->Parc->getParcs('list');
        } else {
            $parcIds = $this->getParcsUserIdsArray($userId);
            if (!empty($parcIds)) {
                $parcs = $this->Parc->getParcByIds($parcIds);
            } else {
                $parcs = $this->Parc->getParcs('list');
            }
        }
        $this->set(compact('results', 'cars', 'customers', 'param','parcs'));
    }

    public function costByCarPdf(){
        $this->setTimeActif();

        $costByCar = filter_input(INPUT_POST, "costByCar");

        $costByCar = explode(",", $costByCar);

        $car_id = $costByCar[0];
        $customer_id = $costByCar[1];
        $start_date = $costByCar[2];
        $end_date = $costByCar[3];
        $parcId = $costByCar[4];
        $results = $this->Statistic->getCostByCar($car_id, $customer_id, $start_date, $end_date,$parcId);
        $this->set(compact('results'));
    }

    public function salesturnover()
    {
        $this->setTimeActif();
        if (isset($this->request->data['Statistic']['year']) && $this->request->data['Statistic']['year'] > 1000 && $this->request->data['Statistic']['year'] < 2100) {
            $year = $this->request->data['Statistic']['year'];
        } else {
            $year = null;
        }
        if (isset($this->request->data['Statistic']['customer_id']) && !empty($this->request->data['Statistic']['customer_id'])) {
            $customer_id = $this->request->data['Statistic']['customer_id'];
        } else {
            $customer_id = null;
        }
        $results = $this->Statistic->getSalesTurnover($customer_id, $year);
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);
        $lines = $this->Statistic->getDistinctCustomerFromReservation($customer_id);
        $columns = $this->Statistic->getDistinctYearFromReservation($year);
        $this->set(compact('results', 'customers', 'lines', 'columns', 'param'));
    }

    public function customerflot()
    {
        $this->setTimeActif();
        if (isset($this->request->data['Statistic']['date']) && $this->isDate($this->request->data['Statistic']['date'])) {
            $start = str_replace("-", "/", $this->request->data['Statistic']['date']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $start_date = $startdtm->format('Y-m-d 00:00:00');
        } else {
            $start_date = null;
        }
        if (isset($this->request->data['Statistic']['next_date']) && $this->isDate($this->request->data['Statistic']['next_date'])) {
            $end = str_replace("-", "/", $this->request->data['Statistic']['next_date']);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            if ($this->isDate($enddtm)) {
                $end_date = $enddtm->format('Y-m-d 00:00:00');
            } else {
                $end_date = null;
            }

        } else {
            $end_date = null;
        }
        if (isset($this->request->data['Statistic']['customer_id']) && !empty($this->request->data['Statistic']['customer_id'])) {
            $customer_id = $this->request->data['Statistic']['customer_id'];
        } else {
            $customer_id = null;
        }
        if (isset($this->request->data['Statistic']['car_id']) && !empty($this->request->data['Statistic']['car_id'])) {
            $car_id = $this->request->data['Statistic']['car_id'];
        } else {
            $car_id = null;
        }
        if (isset($this->request->data['Statistic']['parc_id']) && !empty($this->request->data['Statistic']['parc_id'])) {
            $parcId = $this->request->data['Statistic']['parc_id'];
        } else {
            $parcId = null;
        }
        $results = $this->Statistic->getCustomerFlot($car_id, $customer_id, $start_date, $end_date,$parcId);
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);
        if ($this->IsAdministrator) {
            $parcs = $this->Parc->getParcs('list');
        } else {
            $parcIds = $this->getParcsUserIdsArray($userId);
            if (!empty($parcIds)) {
                $parcs = $this->Parc->getParcByIds($parcIds);
            } else {
                $parcs = $this->Parc->getParcs('list');
            }
        }
        $this->set(compact('results', 'cars', 'customers', 'param','parcs'));
    }

    public function customerflot_pdf()
    {
        $this->setTimeActif();
        $customerflot = filter_input(INPUT_POST, "customerflot");

        $customerflot = explode(",", $customerflot);


        $car_id = $customerflot[0];
        $customer_id = $customerflot[1];
        $start_date = $customerflot[2];
        $end_date = $customerflot[3];
        $parcId = $customerflot[4];

        $results = $this->Statistic->getCustomerFlot($car_id, $customer_id, $start_date, $end_date,$parcId);

        $this->set(compact('results','param'));
    }

    public function maintenance()
    {
        $this->setTimeActif();
        if (isset($this->request->data['Statistic']['car_id']) && !empty($this->request->data['Statistic']['car_id'])) {
            $car_id = $this->request->data['Statistic']['car_id'];
        } else {
            $car_id = null;
        }
        if (isset($this->request->data['Statistic']['event_type_category_id']) &&
            !empty($this->request->data['Statistic']['event_type_category_id'])
        ) {
            $event_type_category_id = $this->request->data['Statistic']['event_type_category_id'];
        } else {
            $event_type_category_id = null;
        }
        if (isset($this->request->data['Statistic']['parc_id']) &&
            !empty($this->request->data['Statistic']['parc_id'])
        ) {
            $parcId = $this->request->data['Statistic']['parc_id'];
        } else {
            $parcId = null;
        }
        if (isset($this->request->data['Statistic']['date']) && $this->isDate($this->request->data['Statistic']['date'])) {
            $start = str_replace("-", "/", $this->request->data['Statistic']['date']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $start_date = $startdtm->format('Y-m-d 00:00:00');
        } else {
            $start_date = null;
        }
        if (isset($this->request->data['Statistic']['next_date'])
            && $this->isDate($this->request->data['Statistic']['next_date'])) {
            $end = str_replace("-", "/", $this->request->data['Statistic']['next_date']);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            if ($this->isDate($enddtm)) {
                $end_date = $enddtm->format('Y-m-d 00:00:00');
            } else {
                $end_date = null;
            }
        } else {
            $end_date = null;
        }
        $eventTypeCategories = $this->EventTypeCategory->find('list', array('order' => 'code asc'));
        $eventTypeCategoriesCostQuery = $this->getEventCategoriesCostQuery($eventTypeCategories);
        $results = $this->Statistic->getMaintenanceProportion($car_id, $event_type_category_id,
            $start_date, $end_date, $parcId, $eventTypeCategoriesCostQuery);;
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $carsConditions = array();
        if (!empty($parcId)){
            $carsConditions = array('car.parc_id' => $parcId);
        }
        $cars = $this->Car->find('list', array(
            'fields' => 'cnames',
            'recursive' => 1,
            'conditions' => $carsConditions,
            'order' => 'Carmodel.name asc'));
        $userId = $this->Auth->user('id');
        if ($this->IsAdministrator) {
            $parcs = $this->Parc->getParcs('list');
        } else {
            $parcIds = $this->getParcsUserIdsArray($userId);
            if (!empty($parcIds)) {
                $parcs = $this->Parc->getParcByIds($parcIds);
            } else {
                $parcs = $this->Parc->getParcs('list');
            }
        }
        $this->set(compact('results', 'cars', 'eventTypeCategories', 'param','parcs'));
    }

    public function getEventCategoriesCostQuery($eventTypeCategories)
    {
        $query = "";
        foreach ($eventTypeCategories as $key => $eventTypeCategory) {
            $query .= "COALESCE(SUM(case when EventTypes.event_type_category_id = {$key} then (Events.cost) else 0 end),0) as {$eventTypeCategory},";
        }
        return $query;
    }


    public function maintenance_pdf()
    {
        $this->setTimeActif();

        $maintenance = filter_input(INPUT_POST, "maintenance");

        $maintenance = explode(",", $maintenance);

        $car_id = $maintenance[0];
        $event_type_category_id = $maintenance[1];
        $start_date = $maintenance[2];
        $end_date = $maintenance[3];
        $parc = $maintenance[4];

        $eventTypeCategories = $this->EventTypeCategory->find('list', array('order' => 'code asc'));

        $eventTypeCategoriesCostQuery = $this->getEventCategoriesCostQuery($eventTypeCategories);
        $results = $this->Statistic->getMaintenanceProportion($car_id, $event_type_category_id,
            $start_date, $end_date,$parc, $eventTypeCategoriesCostQuery);

        $this->set(compact('results', 'eventTypeCategories', 'param'));
    }

    private function isDate($date)
    {
        $this->setTimeActif();
        return !empty($date) && is_string($date) ? DateTime::createFromFormat('m/d/Y', $date) : null;
    }

    public function globalcostbycar()
    {
        $this->setTimeActif();
        if (isset($this->request->data['Statistic']['car_id']) && !empty($this->request->data['Statistic']['car_id'])) {
            $car_id = $this->request->data['Statistic']['car_id'];

        } else {
            $car_id = null;
        }
        if (isset($this->request->data['Statistic']['parc_id']) && !empty($this->request->data['Statistic']['parc_id'])) {
            $parcId = $this->request->data['Statistic']['parc_id'];
        } else {
            $parcId = null;
        }
        if (isset($this->request->data['Statistic']['date']) && $this->isDate($this->request->data['Statistic']['date'])) {
            $start = str_replace("-", "/", $this->request->data['Statistic']['date']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $start_date = $startdtm->format('Y-m-d 00:00:00');
        } else {
            $start_date = null;
        }
        if (isset($this->request->data['Statistic']['next_date']) && $this->isDate($this->request->data['Statistic']['next_date'])) {
            $end = str_replace("-", "/", $this->request->data['Statistic']['next_date']);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            if ($this->isDate($enddtm)) {
                $end_date = $enddtm->format('Y-m-d 00:00:00');
            } else {
                $end_date = null;
            }

        } else {
            $end_date = null;
        }
        $results = $this->Statistic->getGlobalCostByCar($car_id, $start_date, $end_date,$parcId);


        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $carConditions = array();
        if (!empty($parcId)){
            $carConditions = array('car.parc_id' => $parcId);
        }
        $cars = $this->Car->find('list', array(
            'fields' => 'cnames',
            'conditions' => $carConditions,
            'recursive' => 1,
            'order' => 'Carmodel.name asc'
        ));
        $car_selected = $this->Car->find('list', array(
                'fields' => 'cnames',
                'recursive' => 1,
                'conditions' => array('Car.id' => $car_id),
                'order' => 'Carmodel.name asc'
            ));
        if ($car_id != null) {
            $car_selected = $this->Car->find('list', array(
                    'fields' => 'cnames',
                    'recursive' => 1,
                    'conditions' => array('Car.id' => $car_id),
                    'order' => 'Carmodel.name asc'
                ));
        }
        $userId = $this->Auth->user('id');
        if ($this->IsAdministrator) {
            $parcs = $this->Parc->getParcs('list');
        } else {
            $parcIds = $this->getParcsUserIdsArray($userId);
            if (!empty($parcIds)) {
                $parcs = $this->Parc->getParcByIds($parcIds);
            } else {
                $parcs = $this->Parc->getParcs('list');
            }
        }
        $this->set(compact('results', 'cars', 'car_selected', 'param','parcs'));
    }

    public function globalcostbycar_pdf()
    {
        $this->setTimeActif();
        $carcost = filter_input(INPUT_POST, "carcost");

        $carcost = explode(",", $carcost);


        $car_id = $carcost[0];

        $start_date = $carcost[1];
        $end_date = $carcost[2];
        $parcId = $carcost[3];


        $results = array();
        $spendings = $this->Statistic->getGlobalCostByCar($car_id, $start_date, $end_date,$parcId);
        //$sales = $this->Statistic->getSalesByCar($car_id, $start_date, $end_date, $parcId);
        foreach ($spendings as $spending) {
            $results[] = array($spending['event']['car_id'], $spending[0]['sumcost']);
            /*$found = false;
            foreach ($spendings as $sale) {
                if ($spending['event']['car_id'] == $sale['customer_car']['car_id']) {
                    $diff = $sale[0]['sumcost'] - $spending[0]['sumcost'];
                    $results[] = array($spending['event']['car_id'], $diff);
                    $found = true;
                }
            }
            /*if (!$found) {
                $results[] = array($spending['event']['car_id'], -$spending[0]['sumcost']);
            }*/
        }
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $carConditions = array();
        if (!empty($parcId)){
            $carConditions = array('car.parc_id' => $parcId);
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames',
            'conditions' => $carConditions ,
            'recursive' => 1,
            'order' => 'Carmodel.name asc'));

        $car_selected = $this->Car->find('list', array(
                'fields' => 'cnames',
                'recursive' => 1,
                'conditions' => array('Car.id' => $car_id) ,
                'order' => 'Carmodel.name asc'
            ));
        if ($car_id != null) {
            $car_selected = $this->Car->find('list', array(
                    'fields' => 'cnames',
                    'recursive' => 1,
                    'conditions' => array('Car.id' => $car_id),
                    'order' => 'Carmodel.name asc'
                ));
        };
        if (count($results) > 200){
            $this->Flash->error(__('Select a parc please.'));
            $this->redirect(array('action' => 'globalcostbycar'));
        }
        $this->set(compact('results', 'cars', 'car_selected', 'param'));
    }


    public function listcarparcsupplier()
    {

        $this->setTimeActif();
        $userId = $this->Auth->user('id');
        if ($this->IsAdministrator) {
            $parcIds = array();
        } else {
            $parcIds = $this->getParcsUserIdsArray($userId);
        }
        if (isset($this->request->data['Statistic']['parc_id']) && !empty($this->request->data['Statistic']['parc_id'])) {
            $parcIds = array($this->request->data['Statistic']['parc_id']);
        }
        if (isset($this->request->data['Statistic']['supplier_id']) && !empty($this->request->data['Statistic']['supplier_id'])) {
            $supplier_id = $this->request->data['Statistic']['supplier_id'];
        } else {
            $supplier_id = null;
        }
        $results = $this->Statistic->getListCarParcSupplier($parcIds, $supplier_id);

        $param = $this->Parameter->getCodesParameterVal('name_car');
        $userId = $this->Auth->user('id');
        if ($this->IsAdministrator) {
            $parcs = $this->Parc->getParcs('list');
        } else {
            $parcIds = $this->getParcsUserIdsArray($userId);
            if (!empty($parcIds)) {
                $parcs = $this->Parc->getParcByIds($parcIds);
            } else {
                $parcs = $this->Parc->getParcs('list');
            }
        }
        $suppliers = $this->Supplier->getSuppliersByParams(0, 1);
        $this->set(compact('parcs', 'suppliers', 'results', 'param'));

    }

    public function listcarparcsupplier_pdf()
    {

        $this->setTimeActif();
        $parcsupplier = filter_input(INPUT_POST, "parcsupplier");

        $parcsupplier = explode(",", $parcsupplier);


        $parc_id = $parcsupplier[0];

        $supplier_id = $parcsupplier[1];


        $cars = $this->Statistic->getListCarParcSupplier($parc_id, $supplier_id);

        $parcs = $this->Parc->getParcs('list');
        $suppliers = $this->Supplier->getSuppliersByParams();
        $this->set(compact('parcs', 'suppliers', 'cars', 'param'));

    }

    public function carsreservation()
    {
        $this->setTimeActif();
        $results = $this->Statistic->getCarsReservations();
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set(compact('results', 'param'));
    }

    public function carsReservationExcel()
    {
        $this->setTimeActif();
        $results = $this->Statistic->getCarsReservations();
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set(compact('results', 'param'));
    }

    public function carsreservation_pdf()
    {
        $this->setTimeActif();
        $results = $this->Statistic->getCarsReservations();
        $param = $this->Parameter->getCodesParameterVal('name_car');
        $this->set(compact('results','param'));

    }

    public function carinsurance_pdf()
    {
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        $caryear = filter_input(INPUT_POST, "caryear");
        $caryear = explode(",", $caryear);
        $car_id = $caryear[0];
        $year = $caryear[1];
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));
        $results = $this->Statistic->getCarInsurance($car_id, $year);
        $this->set(compact('results', 'cars', 'param'));

    }

    public function carinsurance()
    {
        $this->setTimeActif();
        if (isset($this->request->data['Statistic']['car_id']) && !empty($this->request->data['Statistic']['car_id'])) {
            $car_id = $this->request->data['Statistic']['car_id'];
        } else {
            $car_id = null;
        }
        if (isset($this->request->data['Statistic']['year']) && $this->request->data['Statistic']['year'] > 1000 && $this->request->data['Statistic']['year'] < 2100) {
            $year = $this->request->data['Statistic']['year'];
        } else {
            $year = null;
            $this->request->data['Statistic']['year'] = date("Y");
        }
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));
        $results = $this->Statistic->getCarInsurance($car_id, $year);
        $this->set(compact('results', 'cars', 'param'));

    }

    public function nembercarsparc()
    {
        $this->setTimeActif();
        if (isset($this->request->data['Statistic']['parc_id']) && !empty($this->request->data['Statistic']['parc_id'])) {
            $parc_id = $this->request->data['Statistic']['parc_id'];
        } else {
            $parc_id = null;
        }
        if (isset($this->request->data['Statistic']['year']) && $this->request->data['Statistic']['year'] > 1000 && $this->request->data['Statistic']['year'] < 2100) {
            $year = $this->request->data['Statistic']['year'];
        } else {
            $year = null;
            $this->request->data['Statistic']['year'] = date("Y");
        }
        if (isset($this->request->data['Statistic']['min_month']) && $this->request->data['Statistic']['min_month'] > 0 && $this->request->data['Statistic']['min_month'] < 13) {
            $min_month = $this->request->data['Statistic']['min_month'];
        } else {
            $min_month = null;
        }
        if (isset($this->request->data['Statistic']['max_month']) && $this->request->data['Statistic']['max_month'] > 0 && $this->request->data['Statistic']['max_month'] < 13) {
            $max_month = $this->request->data['Statistic']['max_month'];
        } else {
            $max_month = null;
        }
        $parcs = $this->Parc->getParcs('list');

        $results = $this->Statistic->getConsumptionParcByMonth($parc_id, $year, $min_month, $max_month);
        $this->set(compact('results', 'parcs'));
    }

    public function nembercarsparc_pdf()
    {
        $this->setTimeActif();
        $consumptionparc = filter_input(INPUT_POST, "consumptionparc");

        $consumptionparc = explode(",", $consumptionparc);

        $parc_id = $consumptionparc[0];
        $year = $consumptionparc[1];
        $min_month = $consumptionparc[2];
        $max_month = $consumptionparc[3];
        $parcs = $this->Parc->getParcs('list');

        $results = $this->Statistic->getConsumptionParcByMonth($parc_id, $year, $min_month, $max_month);
        $this->set(compact('results', 'parcs'));
    }

    public function consumptionfuelparc()
    {
        $this->setTimeActif();
        if (isset($this->request->data['Statistic']['parc_id']) && !empty($this->request->data['Statistic']['parc_id'])) {
            $parc_id = $this->request->data['Statistic']['parc_id'];
        } else {
            $parc_id = null;
        }
        if (isset($this->request->data['Statistic']['fuel_id']) && !empty($this->request->data['Statistic']['fuel_id'])) {
            $fuel_id = $this->request->data['Statistic']['fuel_id'];
        } else {
            $fuel_id = null;
        }
        if (isset($this->request->data['Statistic']['date']) && $this->isDate($this->request->data['Statistic']['date'])) {
            $start = str_replace("-", "/", $this->request->data['Statistic']['date']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $start_date = $startdtm->format('Y-m-d 00:00:00');
        } else {
            $start_date = null;
        }
        if (isset($this->request->data['Statistic']['next_date']) && $this->isDate($this->request->data['Statistic']['next_date'])) {
            $end = str_replace("-", "/", $this->request->data['Statistic']['next_date']);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $end_date = $enddtm->format('Y-m-d 00:00:00');
        } else {
            $end_date = null;
        }

        $parcs = $this->Parc->getParcs('list');
        $fuels = $this->Fuel->getFuels('list');
        $results = $this->Statistic->getConsumptionParcByFuel($parc_id, $fuel_id, $start_date, $end_date);
        $this->set(compact('fuels', 'parcs', 'results'));
    }

    public function consumptionfuelparc_pdf()
    {
        $this->setTimeActif();
        $parcfuel = filter_input(INPUT_POST, "parcfuel");

        $parcfuel = explode(",", $parcfuel);

        $parc_id = $parcfuel[0];
        $fuel_id = $parcfuel[1];
        $start_date = $parcfuel[2];
        $end_date = $parcfuel[3];

        $parcs = $this->Parc->getParcs('list');
        $fuels = $this->Fuel->getFuels('list');
        $results = $this->Statistic->getConsumptionParcByFuel($parc_id, $fuel_id, $start_date, $end_date);
        $this->set(compact('fuels', 'parcs', 'results'));
    }

    public function stockFuellog()
    {
        $this->setTimeActif();
        if (isset($this->request->data['Statistic']['num_bill']) && !empty($this->request->data['Statistic']['num_bill'])) {
            $num_bill = $this->request->data['Statistic']['num_bill'];
        } else {
            $num_bill = null;
        }
        if (isset($this->request->data['Statistic']['date']) && $this->isDate($this->request->data['Statistic']['date'])) {
            $start = str_replace("-", "/", $this->request->data['Statistic']['date']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $start_date = $startdtm->format('Y-m-d 00:00:00');
        } else {
            $start_date = null;
        }
        if (isset($this->request->data['Statistic']['next_date']) && $this->isDate($this->request->data['Statistic']['next_date'])) {
            $end = str_replace("-", "/", $this->request->data['Statistic']['next_date']);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $end_date = $enddtm->format('Y-m-d 00:00:00');
        } else {
            $end_date = null;
        }
        $results = $this->Statistic->getStockFuellog($num_bill, $start_date, $end_date);
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $num_bills = $this->FuelLog->getDistinctNum();

        $total_coupons = $this->Coupon->find('count');


        $this->set(compact('results', 'num_bills', 'total_coupons', 'param'));
    }

    public function reservationByMonth()
    {

        $this->setTimeActif();

        if (isset($this->request->data['Statistic']['year']) && $this->request->data['Statistic']['year'] > 1000 && $this->request->data['Statistic']['year'] < 2100) {
            $year = $this->request->data['Statistic']['year'];
        } else {
            $year = null;
            $this->request->data['Statistic']['year'] = date("Y");
        }
        if (isset($this->request->data['Statistic']['month']) && $this->request->data['Statistic']['month'] > 0 && $this->request->data['Statistic']['month'] < 13) {
            $month = $this->request->data['Statistic']['month'];
        } else {
            $month = null;
        }
        if (isset($this->request->data['Statistic']['customer_id']) && !empty($this->request->data['Statistic']['customer_id'])) {
            $customer_id = $this->request->data['Statistic']['customer_id'];
        } else {
            $customer_id = null;
        }

        if (isset($this->request->data['Statistic']['customer_group_id']) && !empty($this->request->data['Statistic']['customer_group_id'])) {
            $customer_group_id = $this->request->data['Statistic']['customer_group_id'];
        } else {
            $customer_group_id = null;
        }

        $results = $this->Statistic->getReservationByMonth($year, $month,$customer_id,$customer_group_id);
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);
        $customerGroups = $this->CustomerGroup->getCustomerGroups();
        $this->set(compact('results','customers','customerGroups'));
    }

    public function reservationbymonth_pdf()
    {
        $this->setTimeActif();
        $reservationmonth = filter_input(INPUT_POST, "reservationmonth");

        $reservationmonth = explode(",", $reservationmonth);


        $year = $reservationmonth[0];
        $month = $reservationmonth[1];
        $customer = $reservationmonth[2];
        $customerGroup = $reservationmonth[3];
        $results = $this->Statistic->getReservationByMonth($year, $month, $customer, $customerGroup);
        $company = $this->Company->find('first');
        $customerGroup_name = $this->CustomerGroup->find('first',
            array('conditions' => array('id' => $customerGroup), 'recursive' => -1, 'fields' => 'name'));
        $customer_name = $this->Customer->find('first', array(
                'conditions' => array('id' => $customer),
                'recursive' => -1,
                'fields' => array('first_name', 'last_name')
            ));
        $this->set(compact('results', 'company', 'customerGroup_name', 'customer_name'));
    }

    public function exportReservationByMonth()
    {

        $this->setTimeActif();
        if (!isset($this->request->data['Statistic']['year']) || $this->request->data['Statistic']['year'] <= 1000 || $this->request->data['Statistic']['year'] >= 2100) {
            $year = null;
            $this->request->data['Statistic']['year'] = date("Y");
        }
        $reservationmonth = filter_input(INPUT_POST, "reservationmonth");
        $reservationmonth = explode(",", $reservationmonth);


        $year = $reservationmonth[0];
        $month = $reservationmonth[1];
        $results = $this->Statistic->getReservationByMonth($year, $month);
        $company = $this->Company->find('first');
        $cars = $this->Car->find('all', array(
            'order' => 'Car.code asc'
        ));
        $this->set('models', $cars);
        $this->set(compact('results', 'company'));
    }

    public function CarMission()
    {
        if (isset($this->request->data['Statistic']['mission']) && !empty($this->request->data['Statistic']['mission'])) {
            $mission = $this->request->data['Statistic']['mission'];
        } else {
            $mission = null;
        }


        $results = $this->Statistic->getCarMission();
        $cars = $this->Car->find('list', array(
                'fields' => array('Car.code', 'Car.car_status_id', 'Car.id'),
                'recursive' => -1,
                'order' => 'Car.id',
                'conditions' => array('Car.car_status_id' => 6)
            ));
        $this->set(compact('results', 'cars', 'mission'));
    }


    public function listcosteventbymonth()
    {
        $this->setTimeActif();
        if (isset($this->request->data['Statistic']['event_type_id']) && !empty($this->request->data['Statistic']['event_type_id'])) {
            $type_id = $this->request->data['Statistic']['event_type_id'];
        } else {
            $type_id = null;
        }

        if (isset($this->request->data['Statistic']['car_id']) && !empty($this->request->data['Statistic']['car_id'])) {
            $car_id = $this->request->data['Statistic']['car_id'];
        } else {
            $car_id = null;
        }

        if (isset($this->request->data['Statistic']['year']) && $this->request->data['Statistic']['year'] > 1000 && $this->request->data['Statistic']['year'] < 2100) {
            $year = $this->request->data['Statistic']['year'];

        } else {
            $year = null;

            $this->request->data['Statistic']['year'] = date("Y");
        }
        if (isset($this->request->data['Statistic']['min_month']) && $this->request->data['Statistic']['min_month'] > 0 && $this->request->data['Statistic']['min_month'] < 13) {
            $min_month = $this->request->data['Statistic']['min_month'];
        } else {
            $min_month = null;
        }
        if (isset($this->request->data['Statistic']['max_month']) && $this->request->data['Statistic']['max_month'] > 0 && $this->request->data['Statistic']['max_month'] < 13) {
            $max_month = $this->request->data['Statistic']['max_month'];
        } else {
            $max_month = null;
        }

        $results = $this->Statistic->getListCostEventByMonth($type_id, $car_id, $year, $min_month, $max_month);

        $eventTypes = $this->EventType->getEventTypes();


        $type = $this->EventType->getEventTypeById($type_id);

        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));
        $userId = $this->Auth->user('id');
        if ($this->IsAdministrator) {
            $parcs = $this->Parc->getParcs('list');
        } else {
            $parcIds = $this->getParcsUserIdsArray($userId);
            if (!empty($parcIds)) {
                $parcs = $this->Parc->getParcByIds($parcIds);
            } else {
                $parcs = $this->Parc->getParcs('list');
            }
        }
        $this->set(compact('results', 'eventTypes', 'type', 'cars','parcs'));
    }

    public function listcosteventbymonth_pdf()
    {
        $this->setTimeActif();
        $costmonth = filter_input(INPUT_POST, "costmonth");
        $costmonth = explode(",", $costmonth);
        $type_id = $costmonth[0];
        $year = $costmonth[1];
        $min_month = $costmonth[2];
        $max_month = $costmonth[3];

        $results = $this->Statistic->getListCostEventByMonth($type_id, null, $year, $min_month, $max_month);
        if (count($results) > 1000){
            $this->Flash->error(__('Select a parc please.'));
            $this->redirect(array('action' => 'listcosteventbymonth'));
        }

        $eventTypes = $this->EventType->getEventTypes();

        $type = $this->EventType->getEventTypeById($type_id);
        $this->set(compact('results', 'eventTypes', 'type'));
    }

    public function flotteAld()
    {
        $this->setTimeActif();

        if (isset($this->request->data['Statistic']['date'])) {

            $this->createDateFromDate('Statistic', 'date');
            $date = $this->request->data['Statistic']['date'];


        } else {
            $date = null;
        }

        if (isset($this->request->data['Statistic']['car_id']) && !empty($this->request->data['Statistic']['car_id'])) {
            $car_id = $this->request->data['Statistic']['car_id'];
        } else {
            $car_id = null;
        }


        $results = $this->Statistic->getFlotteAld($car_id, $date);

        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));


        $this->set(compact('results', 'param', 'cars', 'date'));
    }

    public function exportFlotteAld()
    {

        $this->setTimeActif();


        $flotteald = filter_input(INPUT_POST, "flotteald");

        $flotteald = explode(",", $flotteald);


        $date = $flotteald[0];
        $car_id = $flotteald[1];

        $results = $this->Statistic->getFlotteAld($car_id, $date);

        $cars = $this->Car->find('all', array(
            'order' => 'Car.code asc'
        ));
        $this->set('cars', $cars);
        $this->set(compact('results'));
    }

    public function invoicedTurnoverByMonth()
    {
        $this->setTimeActif();

        if (isset($this->request->data['Statistic']['customer_id']) && !empty($this->request->data['Statistic']['customer_id'])) {
            $customer_id = $this->request->data['Statistic']['customer_id'];
        } else {
            $customer_id = null;
        }
        if (isset($this->request->data['Statistic']['supplier_id']) && !empty($this->request->data['Statistic']['supplier_id'])) {
            $supplier_id = $this->request->data['Statistic']['supplier_id'];
        } else {
            $supplier_id = null;
        }

        if (isset($this->request->data['Statistic']['car_id']) && !empty($this->request->data['Statistic']['car_id'])) {
            $car_id = $this->request->data['Statistic']['car_id'];
        } else {
            $car_id = null;
        }

        if (isset($this->request->data['Statistic']['date']) && $this->isDate($this->request->data['Statistic']['date'])) {
            $start = str_replace("-", "/", $this->request->data['Statistic']['date']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $start_date = $startdtm->format('Y-m-d 00:00');
        } else {
            $start_date = null;
        }
        if (isset($this->request->data['Statistic']['next_date']) && $this->isDate($this->request->data['Statistic']['next_date'])) {
            $end = str_replace("-", "/", $this->request->data['Statistic']['next_date']);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $end_date = $enddtm->format('Y-m-d 00:00');
        } else {
            $end_date = null;
        }

        $results = $this->Statistic->getInvoicedTurnoverByMonth($customer_id, $car_id, $supplier_id,$start_date,
            $end_date);


        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));
         $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);
        $this->set(compact('results','suppliers','customers','cars'));

    }

    public function exportInvoicedTurnoverByMonthPdf()
    {
        $this->setTimeActif();

        if (isset($this->request->data['Statistic']['customer_id']) && !empty($this->request->data['Statistic']['customer_id'])
        && $this->request->data['Statistic']['customer_id'] != 'undefined') {
            $customer_id = $this->request->data['Statistic']['customer_id'];
        } else {
            $customer_id = null;
        }
        if (isset($this->request->data['Statistic']['supplier_id']) && !empty($this->request->data['Statistic']['supplier_id'])) {
            $supplier_id = $this->request->data['Statistic']['supplier_id'];
        } else {
            $supplier_id = null;
        }

        if (isset($this->request->data['Statistic']['car_id']) && !empty($this->request->data['Statistic']['car_id'])
        && $this->request->data['Statistic']['car_id'] != 'undefined') {
            $car_id = $this->request->data['Statistic']['car_id'];
        } else {
            $car_id = null;
        }

        if (isset($this->request->data['Statistic']['date']) && $this->isDate($this->request->data['Statistic']['date'])) {
            $start = str_replace("-", "/", $this->request->data['Statistic']['date']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $start_date = $startdtm->format('Y-m-d 00:00');
        } else {
            $start_date = null;
        }
        if (isset($this->request->data['Statistic']['next_date']) && $this->isDate($this->request->data['Statistic']['next_date'])) {
            $end = str_replace("-", "/", $this->request->data['Statistic']['next_date']);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $end_date = $enddtm->format('Y-m-d 00:00');
        } else {
            $end_date = null;
        }


        $results = $this->Statistic->getInvoicedTurnoverByMonth($customer_id, $car_id, $supplier_id,$start_date,
            $end_date);
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));
        $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
        $fields = "names";
        $company = $this->Company->find('first');
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);
        $this->set(compact('results','suppliers','customers','cars','company'));
    }


    public function preinvoicedTurnoverByMonth()
    {
        $this->setTimeActif();

        if (isset($this->request->data['Statistic']['customer_id']) && !empty($this->request->data['Statistic']['customer_id'])) {
            $customer_id = $this->request->data['Statistic']['customer_id'];
        } else {
            $customer_id = null;
        }
        if (isset($this->request->data['Statistic']['supplier_id']) && !empty($this->request->data['Statistic']['supplier_id'])) {
            $supplier_id = $this->request->data['Statistic']['supplier_id'];
        } else {
            $supplier_id = null;
        }

        if (isset($this->request->data['Statistic']['car_id']) && !empty($this->request->data['Statistic']['car_id'])) {
            $car_id = $this->request->data['Statistic']['car_id'];
        } else {
            $car_id = null;
        }

        if (isset($this->request->data['Statistic']['date']) && $this->isDate($this->request->data['Statistic']['date'])) {
            $start = str_replace("-", "/", $this->request->data['Statistic']['date']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $start_date = $startdtm->format('Y-m-d 00:00');
        } else {
            $start_date = null;
        }
        if (isset($this->request->data['Statistic']['next_date']) && $this->isDate($this->request->data['Statistic']['next_date'])) {
            $end = str_replace("-", "/", $this->request->data['Statistic']['next_date']);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $end_date = $enddtm->format('Y-m-d 00:00');
        } else {
            $end_date = null;
        }
        $results = $this->Statistic->getPreinvoicedTurnoverByMonth($customer_id, $car_id, $supplier_id,
            $start_date, $end_date);


        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));
        $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);
        $this->set(compact('results','suppliers','customers','cars'));

    }

    public function exportPreinvoicedTurnoverByMonthPdf()
    {
        $this->setTimeActif();

        if (isset($this->request->data['Statistic']['customer_id']) && !empty($this->request->data['Statistic']['customer_id']) &&
                $this->request->data['Statistic']['customer_id'] != 'undefined') {
            $customer_id = $this->request->data['Statistic']['customer_id'];
        } else {
            $customer_id = null;
        }
        if (isset($this->request->data['Statistic']['supplier_id']) && !empty($this->request->data['Statistic']['supplier_id'])) {
            $supplier_id = $this->request->data['Statistic']['supplier_id'];
        } else {
            $supplier_id = null;
        }

        if (isset($this->request->data['Statistic']['car_id']) && !empty($this->request->data['Statistic']['car_id'])
        && $this->request->data['Statistic']['car_id'] != 'undefined') {
            $car_id = $this->request->data['Statistic']['car_id'];
        } else {
            $car_id = null;
        }

        if (isset($this->request->data['Statistic']['date']) && $this->isDate($this->request->data['Statistic']['date'])) {
            $start = str_replace("-", "/", $this->request->data['Statistic']['date']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $start_date = $startdtm->format('Y-m-d 00:00');
        } else {
            $start_date = null;
        }
        if (isset($this->request->data['Statistic']['next_date']) && $this->isDate($this->request->data['Statistic']['next_date'])) {
            $end = str_replace("-", "/", $this->request->data['Statistic']['next_date']);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $end_date = $enddtm->format('Y-m-d 00:00');
        } else {
            $end_date = null;
        }
        $results = $this->Statistic->getPreinvoicedTurnoverByMonth($customer_id, $car_id, $supplier_id,
            $start_date, $end_date);


        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));
        $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
        $fields = "names";
        $company = $this->Company->find('first');
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);
        $this->set(compact('results','suppliers','customers','cars','param','company'));
    }

    public function realizedTurnoverByMonth()
    {
        $this->setTimeActif();

        if (isset($this->request->data['Statistic']['customer_id']) && !empty($this->request->data['Statistic']['customer_id'])) {
            $customer_id = $this->request->data['Statistic']['customer_id'];
        } else {
            $customer_id = null;
        }
        if (isset($this->request->data['Statistic']['supplier_id']) && !empty($this->request->data['Statistic']['supplier_id'])) {
            $supplier_id = $this->request->data['Statistic']['supplier_id'];
        } else {
            $supplier_id = null;
        }

        if (isset($this->request->data['Statistic']['car_id']) && !empty($this->request->data['Statistic']['car_id'])) {
            $car_id = $this->request->data['Statistic']['car_id'];
        } else {
            $car_id = null;
        }

        if (isset($this->request->data['Statistic']['date']) && $this->isDate($this->request->data['Statistic']['date'])) {
            $start = str_replace("-", "/", $this->request->data['Statistic']['date']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $start_date = $startdtm->format('Y-m-d 00:00');
        } else {
            $start_date = null;
        }
        if (isset($this->request->data['Statistic']['next_date']) && $this->isDate($this->request->data['Statistic']['next_date'])) {
            $end = str_replace("-", "/", $this->request->data['Statistic']['next_date']);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $end_date = $enddtm->format('Y-m-d 00:00');
        } else {
            $end_date = null;
        }

        $results = $this->getRealizedTurnoverByMonth($customer_id, $car_id, $supplier_id, $start_date,
            $end_date);


        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));
         $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);
        $this->set(compact('results','suppliers','customers','cars'));

    }


    public function  getRealizedTurnoverByMonth(
        $customer_id = null,
        $car_id = null,
        $supplier_id = null,
        $starDate = null,
        $endDate = null
    ) {
        $this->loadModel('Tva');
        $conditions = array();
        if (!empty($supplier_id)) {
            $conditions["SheetRideDetailRides.supplier_id"] = $supplier_id;

        }
        if (!empty($car_id)) {
            $conditions["SheetRide.car_id"] = $car_id;

        }

        if (!empty($customer_id)) {
            $conditions["SheetRide.customer_id"] = $customer_id;

        }


        if (!empty($starDate)) {

            $conditions["SheetRideDetailRides.real_start_date >="] = $starDate;
        }

        if (!empty($endDate)) {
            $conditions["SheetRideDetailRides.real_start_date <="] = $endDate;
        }
        $conditions['SheetRideDetailRides.invoiced_ride '] = 1;
        $conditions['SheetRideDetailRides.status_id '] = array(1, 2, 3, 4, 5, 6, 7);
        $sheetRideDetailRides = $this->SheetRideDetailRides->find('all', array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'order' => array(' SheetRideDetailRides.real_start_date ' => 'asc', 'SheetRideDetailRides.id' => 'asc'),
            'conditions' => $conditions,
            'fields' => array(
                'SheetRideDetailRides.id',
                'SheetRide.reference',
                'SheetRide.id',
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.reference',
                'SheetRideDetailRides.supplier_id',
                'SheetRideDetailRides.detail_ride_id',
                'SheetRideDetailRides.planned_start_date',
                'SheetRideDetailRides.real_start_date',
                'SheetRideDetailRides.planned_end_date',
                'SheetRideDetailRides.real_end_date',
                'SheetRideDetailRides.status_id',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Supplier.name',
                'CarType.name'
            ),
            'joins' => array(

                array(
                    'table' => 'sheet_rides',
                    'type' => 'left',
                    'alias' => 'SheetRide',
                    'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                ),
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('SheetRide.car_id = Car.id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('SheetRide.customer_id = Customer.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('DetailRide.car_type_id = CarType.id')
                ),
                array(
                    'table' => 'rides',
                    'type' => 'left',
                    'alias' => 'Ride',
                    'conditions' => array('DetailRide.ride_id = Ride.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('SheetRideDetailRides.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'DepartureDestination',
                    'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                ),
                array(
                    'table' => 'destinations',
                    'type' => 'left',
                    'alias' => 'ArrivalDestination',
                    'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                ),


            )
        ));

        $array_ids = array();
        $missions = array();

        foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
            array_push($array_ids, $sheetRideDetailRide['SheetRideDetailRides']['id']);
            switch (true) {
                case ($sheetRideDetailRide['SheetRideDetailRides']['status_id'] == 1 ||
                    $sheetRideDetailRide['SheetRideDetailRides']['status_id'] == 2 ||
                    $sheetRideDetailRide['SheetRideDetailRides']['status_id'] == 3):
                    $rides = $this->SheetRideDetailRides->find('first', array(
                        'order' => array(
                            'MONTH( SheetRideDetailRides.real_start_date )' => 'asc',
                            'SheetRideDetailRides.id' => 'asc'
                        ),
                        'recursive' => -1,
                        'conditions' => array('SheetRideDetailRides.id' => $sheetRideDetailRide['SheetRideDetailRides']['id']),
                        'fields' => array(
                            'SheetRideDetailRides.id',
                            'SheetRideDetailRides.supplier_id',
                            'SheetRideDetailRides.return_mission',
                            'SheetRideDetailRides.detail_ride_id',
                            'SheetRideDetailRides.id',
                            'SheetRideDetailRides.real_start_date',
                            'SheetRideDetailRides.real_end_date',
                            'SheetRideDetailRides.status_id',
                            'DepartureDestination.name',
                            'ArrivalDestination.name',
                            'Car.id',
                            'Car.code',
                            'Car.immatr_def',
                            'Customer.id',
                            'Customer.first_name',
                            'Customer.last_name',
                            'Carmodel.name',
                            'SheetRideDetailRides.ride_category_id',
                            'TransportBillDetailRides.id',
                            'TransportBillDetailRides.unit_price',
                            'TransportBillDetailRides.tva_id',
                            'TransportBillDetailRides.ristourne_%',
                            'TransportBillDetailRides.ristourne_val',
                            'Supplier.id',
                            'Supplier.name',
                            'CarType.name',
                            'RideCategory.name'
                        ),
                        'joins' => array(

                            array(
                                'table' => 'transport_bill_detail_rides',
                                'type' => 'left',
                                'alias' => 'TransportBillDetailRides',
                                'conditions' => array('SheetRideDetailRides.transport_bill_detail_ride_id = TransportBillDetailRides.id')
                            ),
                            array(
                                'table' => 'sheet_rides',
                                'type' => 'left',
                                'alias' => 'SheetRide',
                                'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                            ),
                            array(
                                'table' => 'car',
                                'type' => 'left',
                                'alias' => 'Car',
                                'conditions' => array('SheetRide.car_id = Car.id')
                            ),
                            array(
                                'table' => 'carmodels',
                                'type' => 'left',
                                'alias' => 'Carmodel',
                                'conditions' => array('Car.carmodel_id = Carmodel.id')
                            ),
                            array(
                                'table' => 'customers',
                                'type' => 'left',
                                'alias' => 'Customer',
                                'conditions' => array('SheetRide.customer_id = Customer.id')
                            ),
                            array(
                                'table' => 'detail_rides',
                                'type' => 'left',
                                'alias' => 'DetailRide',
                                'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
                            ),
                            array(
                                'table' => 'ride_categories',
                                'type' => 'left',
                                'alias' => 'RideCategory',
                                'conditions' => array('SheetRideDetailRides.ride_category_id = RideCategory.id')
                            ),
                            array(
                                'table' => 'rides',
                                'type' => 'left',
                                'alias' => 'Ride',
                                'conditions' => array('DetailRide.ride_id = Ride.id')
                            ),
                            array(
                                'table' => 'car_types',
                                'type' => 'left',
                                'alias' => 'CarType',
                                'conditions' => array('DetailRide.car_type_id = CarType.id')
                            ),
                            array(
                                'table' => 'suppliers',
                                'type' => 'left',
                                'alias' => 'Supplier',
                                'conditions' => array('SheetRideDetailRides.supplier_id = Supplier.id')
                            ),
                            array(
                                'table' => 'destinations',
                                'type' => 'left',
                                'alias' => 'DepartureDestination',
                                'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                            ),
                            array(
                                'table' => 'destinations',
                                'type' => 'left',
                                'alias' => 'ArrivalDestination',
                                'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                            ),

                        )
                    ));

                    array_push($missions, $rides);


                    break;

                case (
                    $sheetRideDetailRide['SheetRideDetailRides']['status_id'] == 7):


                    $rides = $this->SheetRideDetailRides->find('first', array(
                        'order' => array(
                            'MONTH( SheetRideDetailRides.real_start_date )' => 'asc',
                            'SheetRideDetailRides.id' => 'asc'
                        ),
                        'recursive' => -1,
                        'conditions' => array(
                            'SheetRideDetailRides.id' => $sheetRideDetailRide['SheetRideDetailRides']['id'],
                            'TransportBill.type' => 7
                        ),
                        'fields' => array(
                            'SheetRideDetailRides.id',
                            'SheetRideDetailRides.supplier_id',
                            'SheetRideDetailRides.return_mission',
                            'SheetRideDetailRides.detail_ride_id',
                            'SheetRideDetailRides.id',
                            'SheetRideDetailRides.real_start_date',
                            'SheetRideDetailRides.real_end_date',
                            'SheetRideDetailRides.status_id',
                            'DepartureDestination.name',
                            'ArrivalDestination.name',
                            'Car.id',
                            'Car.code',
                            'Car.immatr_def',
                            'Customer.id',
                            'Customer.first_name',
                            'Customer.last_name',
                            'Carmodel.name',
                            'SheetRideDetailRides.ride_category_id',
                            'TransportBillDetailRides.id',
                            'TransportBillDetailRides.unit_price',
                            'TransportBillDetailRides.tva_id',
                            'TransportBillDetailRides.ristourne_%',
                            'TransportBillDetailRides.ristourne_val',
                            'Supplier.id',
                            'Supplier.name',
                            'CarType.name',
                            'RideCategory.name'
                        ),
                        'joins' => array(

                            array(
                                'table' => 'transport_bill_detail_rides',
                                'type' => 'left',
                                'alias' => 'TransportBillDetailRides',
                                'conditions' => array('SheetRideDetailRides.id = TransportBillDetailRides.sheet_ride_detail_ride_id')
                            ),
                            array(
                                'table' => 'transport_bills',
                                'type' => 'left',
                                'alias' => 'TransportBill',
                                'conditions' => array('TransportBill.id = TransportBillDetailRides.transport_bill_id')
                            ),
                            array(
                                'table' => 'sheet_rides',
                                'type' => 'left',
                                'alias' => 'SheetRide',
                                'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                            ),
                            array(
                                'table' => 'car',
                                'type' => 'left',
                                'alias' => 'Car',
                                'conditions' => array('SheetRide.car_id = Car.id')
                            ),
                            array(
                                'table' => 'carmodels',
                                'type' => 'left',
                                'alias' => 'Carmodel',
                                'conditions' => array('Car.carmodel_id = Carmodel.id')
                            ),
                            array(
                                'table' => 'customers',
                                'type' => 'left',
                                'alias' => 'Customer',
                                'conditions' => array('SheetRide.customer_id = Customer.id')
                            ),
                            array(
                                'table' => 'detail_rides',
                                'type' => 'left',
                                'alias' => 'DetailRide',
                                'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
                            ),
                            array(
                                'table' => 'ride_categories',
                                'type' => 'left',
                                'alias' => 'RideCategory',
                                'conditions' => array('SheetRideDetailRides.ride_category_id = RideCategory.id')
                            ),
                            array(
                                'table' => 'rides',
                                'type' => 'left',
                                'alias' => 'Ride',
                                'conditions' => array('DetailRide.ride_id = Ride.id')
                            ),
                            array(
                                'table' => 'car_types',
                                'type' => 'left',
                                'alias' => 'CarType',
                                'conditions' => array('DetailRide.car_type_id = CarType.id')
                            ),
                            array(
                                'table' => 'suppliers',
                                'type' => 'left',
                                'alias' => 'Supplier',
                                'conditions' => array('SheetRideDetailRides.supplier_id = Supplier.id')
                            ),
                            array(
                                'table' => 'destinations',
                                'type' => 'left',
                                'alias' => 'DepartureDestination',
                                'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                            ),
                            array(
                                'table' => 'destinations',
                                'type' => 'left',
                                'alias' => 'ArrivalDestination',
                                'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                            ),

                        )
                    ));

                    array_push($missions, $rides);
                    break;

                case ($sheetRideDetailRide['SheetRideDetailRides']['status_id'] == 4 ||
                    $sheetRideDetailRide['SheetRideDetailRides']['status_id'] == 5 ||
                    $sheetRideDetailRide['SheetRideDetailRides']['status_id'] == 6):

                    $rides = $this->SheetRideDetailRides->find('first', array(
                        'order' => array(
                            'MONTH( SheetRideDetailRides.real_start_date )' => 'asc',
                            'SheetRideDetailRides.id' => 'asc'
                        ),
                        'recursive' => -1,
                        'conditions' => array(
                            'SheetRideDetailRides.id' => $sheetRideDetailRide['SheetRideDetailRides']['id'],
                            'TransportBill.type' => 4
                        ),
                        'fields' => array(
                            'SheetRideDetailRides.id',
                            'SheetRideDetailRides.supplier_id',
                            'SheetRideDetailRides.return_mission',
                            'SheetRideDetailRides.detail_ride_id',
                            'SheetRideDetailRides.id',
                            'SheetRideDetailRides.real_start_date',
                            'SheetRideDetailRides.real_end_date',
                            'SheetRideDetailRides.status_id',
                            'DepartureDestination.name',
                            'ArrivalDestination.name',
                            'Car.id',
                            'Car.code',
                            'Car.immatr_def',
                            'Customer.id',
                            'Customer.first_name',
                            'Customer.last_name',
                            'Carmodel.name',
                            'SheetRideDetailRides.ride_category_id',
                            'TransportBillDetailRides.id',
                            'TransportBillDetailRides.unit_price',
                            'TransportBillDetailRides.tva_id',
                            'TransportBillDetailRides.ristourne_%',
                            'TransportBillDetailRides.ristourne_val',
                            'TransportBill.type',
                            'Supplier.id',
                            'Supplier.name',
                            'CarType.name',
                            'RideCategory.name'
                        ),
                        'joins' => array(

                            array(
                                'table' => 'transport_bill_detail_rides',
                                'type' => 'left',
                                'alias' => 'TransportBillDetailRides',
                                'conditions' => array('SheetRideDetailRides.id = TransportBillDetailRides.sheet_ride_detail_ride_id')
                            ),
                            array(
                                'table' => 'transport_bills',
                                'type' => 'left',
                                'alias' => 'TransportBill',
                                'conditions' => array('TransportBill.id = TransportBillDetailRides.transport_bill_id')
                            ),
                            array(
                                'table' => 'sheet_rides',
                                'type' => 'left',
                                'alias' => 'SheetRide',
                                'conditions' => array('SheetRideDetailRides.sheet_ride_id = SheetRide.id')
                            ),
                            array(
                                'table' => 'car',
                                'type' => 'left',
                                'alias' => 'Car',
                                'conditions' => array('SheetRide.car_id = Car.id')
                            ),
                            array(
                                'table' => 'carmodels',
                                'type' => 'left',
                                'alias' => 'Carmodel',
                                'conditions' => array('Car.carmodel_id = Carmodel.id')
                            ),
                            array(
                                'table' => 'customers',
                                'type' => 'left',
                                'alias' => 'Customer',
                                'conditions' => array('SheetRide.customer_id = Customer.id')
                            ),
                            array(
                                'table' => 'detail_rides',
                                'type' => 'left',
                                'alias' => 'DetailRide',
                                'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
                            ),
                            array(
                                'table' => 'ride_categories',
                                'type' => 'left',
                                'alias' => 'RideCategory',
                                'conditions' => array('SheetRideDetailRides.ride_category_id = RideCategory.id')
                            ),
                            array(
                                'table' => 'rides',
                                'type' => 'left',
                                'alias' => 'Ride',
                                'conditions' => array('DetailRide.ride_id = Ride.id')
                            ),
                            array(
                                'table' => 'car_types',
                                'type' => 'left',
                                'alias' => 'CarType',
                                'conditions' => array('DetailRide.car_type_id = CarType.id')
                            ),
                            array(
                                'table' => 'suppliers',
                                'type' => 'left',
                                'alias' => 'Supplier',
                                'conditions' => array('SheetRideDetailRides.supplier_id = Supplier.id')
                            ),
                            array(
                                'table' => 'destinations',
                                'type' => 'left',
                                'alias' => 'DepartureDestination',
                                'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                            ),
                            array(
                                'table' => 'destinations',
                                'type' => 'left',
                                'alias' => 'ArrivalDestination',
                                'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                            ),

                        )
                    ));
                    array_push($missions, $rides);
                    break;

            }

        }
        $results = array();
        $sheetRideDetailRides = $missions; 
        foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
			if(!empty($sheetRideDetailRide['SheetRideDetailRides']['id'])){
			if(!empty($sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'])){
				$detail_ride_id = $sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'];
			}else{
				$detail_ride_id = 0;
			}
            if(!empty($sheetRideDetailRide['SheetRideDetailRides']['supplier_id'])){
				$supplier_id = $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'];
			}else{
				$supplier_id = 0;
			}
            if(!empty($sheetRideDetailRide['SheetRideDetailRides']['supplier_id'])){
				$ride_category_id = $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'];
			}else{
				$ride_category_id = 0;
			}
            
            if (!empty($sheetRideDetailRide['TransportBillDetailRides']['unit_price'])) {
                $sheetRideDetailRide['SheetRideDetailRides']['unit_price'] = $sheetRideDetailRide['TransportBillDetailRides']['unit_price'];
            } else {
                $price = $this->getPriceRide($detail_ride_id, $supplier_id, $ride_category_id);
                if (!empty($price)) {
                    if ($sheetRideDetailRide['SheetRideDetailRides']['return_mission'] == 1) {
                        $sheetRideDetailRide['SheetRideDetailRides']['unit_price'] = $price[0] + $price[2];

                    } else {
                        $sheetRideDetailRide['SheetRideDetailRides']['unit_price'] = $price[0];
                    }

                } else {
                    $sheetRideDetailRide['SheetRideDetailRides']['unit_price'] = 0;
                }
            }
			if(!empty($sheetRideDetailRide['SheetRideDetailRides']['return_mission'])){
				$sheetRideDetailRide['SheetRideDetailRides']['delivery_with_return'] = $sheetRideDetailRide['SheetRideDetailRides']['return_mission'];
			}else{
				$sheetRideDetailRide['SheetRideDetailRides']['delivery_with_return'] = 1;
			}
            if(!empty($sheetRideDetailRide['SheetRideDetailRides']['return_mission'])){
				$sheetRideDetailRide['SheetRideDetailRides']['ristourne_%'] = $sheetRideDetailRide['TransportBillDetailRides']['ristourne_%'];
			}else{
				$sheetRideDetailRide['SheetRideDetailRides']['ristourne_%'] = 0;
			}
            
            if (!empty($sheetRideDetailRide['TransportBillDetailRides']['ristourne_%'])) {
                $sheetRideDetailRide['SheetRideDetailRides']['ristourne_val'] = ($sheetRideDetailRide['TransportBillDetailRides']['unit_price'] * $sheetRideDetailRide['TransportBillDetailRides']['ristourne_%']) / 100;
                $sheetRideDetailRide['SheetRideDetailRides']['price_ht'] = $sheetRideDetailRide['TransportBillDetailRides']['unit_price'] - $sheetRideDetailRide['TransportBillDetailRides']['ristourne_val'];

            } else {
                $sheetRideDetailRide['SheetRideDetailRides']['ristourne_val'] = null;
                $sheetRideDetailRide['SheetRideDetailRides']['price_ht'] = $sheetRideDetailRide['SheetRideDetailRides']['unit_price'];
            }
            if (!empty($sheetRideDetailRide['TransportBillDetailRides']['tva_id'])) {
                $sheetRideDetailRide['SheetRideDetailRides']['tva_id'] = $sheetRideDetailRide['TransportBillDetailRides']['tva_id'];
                $sheetRideDetailRide['SheetRideDetailRides']['price_ttc'] = $sheetRideDetailRide['SheetRideDetailRides']['price_ht'] +
                    ($sheetRideDetailRide['SheetRideDetailRides']['price_ht'] * $this->Tva->getTvaValueById($sheetRideDetailRide['TransportBillDetailRides']['tva_id']));
            } else {
                $sheetRideDetailRide['SheetRideDetailRides']['tva_id'] = 1;
                $sheetRideDetailRide['SheetRideDetailRides']['price_ttc'] = $sheetRideDetailRide['SheetRideDetailRides']['price_ht'] + ($sheetRideDetailRide['SheetRideDetailRides']['price_ht'] * 0.19);
            }
			
			

            array_push($results, $sheetRideDetailRide);
		}
        }

        return $results;

    }
    public function debtByCustomer(){
        $this->setTimeActif();
        $conditions["TransportBill.type IN "] = array(

            TransportBillTypesEnum::invoice,
            TransportBillTypesEnum::credit_note);

        if (isset($this->request->data['Statistic']['supplier_id']) && !empty($this->request->data['Statistic']['supplier_id'])) {
            $supplierId = $this->request->data['Statistic']['supplier_id'];
            $conditions["Supplier.id"] = $supplierId;

        } else {
            $supplierId = null;
        }
        if (isset($this->request->data['Statistic']['date']) && $this->isDate($this->request->data['Statistic']['date'])) {
            $start = str_replace("-", "/", $this->request->data['Statistic']['date']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $startDate = $startdtm->format('Y-m-d 00:00:00');
            $conditions["TransportBill.date >="] =$startDate;
        } else {
            $startDate = null;
        }
        if (isset($this->request->data['Statistic']['next_date']) && $this->isDate($this->request->data['Statistic']['next_date'])) {
            $end = str_replace("-", "/", $this->request->data['Statistic']['next_date']);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $endDate = $enddtm->format('Y-m-d 00:00:00');
            $conditions["TransportBill.date <="] =$endDate;
        } else {
            $endDate = null;
        }
        $this->TransportBill->virtualFields = array(
            'amount_payed' => 'SUM(IFNULL(Payments.amount,0))'
        );
        $transportBills = $this->TransportBill->find('all', array(
            'recursive' => -1,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'group' => 'TransportBill.id',
            'fields' => array(
                'TransportBill.reference',
                'TransportBill.id',
                'TransportBill.type',
                'TransportBill.date',
                'TransportBill.total_ttc',
                'TransportBill.total_ht',
                'TransportBill.total_tva',
                'TransportBill.amount_remaining',
                'TransportBill.stamp',
                'Supplier.id',
                'Supplier.name',
                'Supplier.code',
                'amount_payed',
            ),
            'order'=>array('Supplier.id DESC','TransportBill.type ASC'),
            'joins' => array(

                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('TransportBill.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'detail_payments',
                    'type' => 'left',
                    'alias' => 'DetailPayments',
                    'conditions' => array(
                        'OR' => array(
                            'DetailPayments.transport_bill_id = TransportBill.id',
                            'DetailPayments.transport_bill_id IS NULL'
                        )
                    )
                ),
                array(
                    'table' => 'payments',
                    'type' => 'left',
                    'alias' => 'Payments',
                    'conditions' => array(
                        'OR' => array(
                            'Payments.id = DetailPayments.payment_id',
                            'Payments.id IS NULL'
                        )
                    )
                ),
            )
        ));
        $company = $this->Company->find('first');
        $separatorAmount = $this->getSeparatorAmount();
        $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
        $this->set(compact('transportBills', 'company', 'separatorAmount','suppliers'));
    }

    public function debtByCustomerPdf(){

        $conditions["TransportBill.type IN "] = array(

            TransportBillTypesEnum::invoice,
            TransportBillTypesEnum::credit_note);


        $debtCustomer = filter_input(INPUT_POST, "debtCustomer");

        $debtCustomer = explode(",", $debtCustomer);


        $supplierId = $debtCustomer[0];

        $startDate = $debtCustomer[1];
        $endDate = $debtCustomer[2];


        if (isset($startDate) && $this->isDate($startDate)) {
            $start = str_replace("-", "/", $startDate);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $startDate = $startdtm->format('Y-m-d 00:00:00');
            $conditions["TransportBill.date >="] =$startDate;
        } else {
            $startDate = null;
        }
        if (isset($endDate) && $this->isDate($endDate)) {
            $end = str_replace("-", "/", $endDate);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $endDate = $enddtm->format('Y-m-d 00:00:00');
            $conditions["TransportBill.date <="] =$endDate;
        } else {
            $endDate = null;
        }

        if (isset($supplierId) && !empty($supplierId)) {
            $conditions["Supplier.id"] = $supplierId;

        } else {
            $supplierId = null;
        }

        $transportBills = $this->TransportBill->find('all', array(
            'recursive' => -1,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'fields' => array(
                'TransportBill.reference',
                'TransportBill.id',
                'TransportBill.type',
                'TransportBill.date',
                'TransportBill.total_ttc',
                'TransportBill.total_ht',
                'TransportBill.total_tva',
                'TransportBill.amount_remaining',
                'TransportBill.stamp',
                'Supplier.id',
                'Supplier.name',
                'Supplier.code',
            ),
            'order'=>array('Supplier.id DESC','TransportBill.type ASC'),
            'joins' => array(

                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('TransportBill.supplier_id = Supplier.id')
                ),
            )
        ));
        $company = $this->Company->find('first');
        $separatorAmount = $this->getSeparatorAmount();
        $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
        $this->set(compact('transportBills', 'company', 'separatorAmount','suppliers'));
    }

    public function creanceBySupplier()
    {
        $this->setTimeActif();

        if (isset($this->request->data['Statistic']['supplier_id']) && !empty($this->request->data['Statistic']['supplier_id'])) {
            $supplierId = $this->request->data['Statistic']['supplier_id'];
        } else {
            $supplierId = null;
        }
        $results = $this->getRealizedTurnoverBySupplier($supplierId);

        $prices = array();
        $i = 0;
        $previousSupplier = null;
        $sumPriceSupplier = 0;
        $sumPrice = 0;

        foreach ($results as $result) {

            if (isset($result['SheetRideDetailRides']['supplier_id'])) {
                $currentSupplier = $result['SheetRideDetailRides']['supplier_id'];
            } else {
                $currentSupplier = 0;
            }

            if ($currentSupplier != $previousSupplier) {
                if ($previousSupplier != null) {
                    $prices[$i]['price'] = $sumPriceSupplier;

                    $sumPriceSupplier = 0;
                }


                $i = $result['Supplier']['id'];
                $prices[$i]['supplier_id'] = $result['Supplier']['id'];
                $prices[$i]['supplier_name'] = $result['Supplier']['name'];
                $sumPriceSupplier = $sumPriceSupplier + $result['SheetRideDetailRides']['price_ttc'];
                $sumPrice = $sumPrice + $result['SheetRideDetailRides']['price_ttc'];
            } else {
                $sumPriceSupplier = $sumPriceSupplier + $result['SheetRideDetailRides']['price_ttc'];
                $sumPrice = $sumPrice + $result['SheetRideDetailRides']['price_ttc'];

            }
            $previousSupplier = $currentSupplier;
        }

        $prices[$i]['price'] = $sumPriceSupplier;


        if ($supplierId != null) {
            $payments = $this->Payment->find('all', array(
                'order' => 'supplier_id',
                'recursive' => -1,
                'group' => array('Payment.supplier_id'),
                'fields' => array('Payment.supplier_id', 'SUM(Payment.amount) as sum_amount'),
                'conditions' => array("Payment.supplier_id" => $supplierId, 'Payment.transact_type_id' => 1)
            ));
        } else {
            $payments = $this->Payment->find('all', array(
                'order' => 'supplier_id',
                'recursive' => -1,
                'group' => array('Payment.supplier_id'),
                'fields' => array('Payment.supplier_id', 'SUM(Payment.amount) as sum_amount'),
                'conditions' => array('Payment.transact_type_id' => 1)
            ));
        }

        $reglements = array();
        foreach ($payments as $payment) {
            $j = $payment['Payment']['supplier_id'];
            $reglements[$j]['amount'] = $payment[0]['sum_amount'];
        }

        $suppliers = $this->Supplier->getSuppliersByParams(1, 1);
        $arraySuppliers = $this->Supplier->getSuppliersByParams(1, 1, null, null, 'all');
        $this->set(compact('results', 'suppliers', 'payments', 'prices', 'reglements', 'arraySuppliers', 'supplierId'));
    }
    public function getRealizedTurnoverBySupplier($supplierId = null)
    {
        $conditions = array();
        $this->loadModel('Tva');
        if (!empty($supplierId)) {
            $conditions["SheetRideDetailRides.supplier_id"] = $supplierId;

        }

        $conditions['SheetRideDetailRides.invoiced_ride '] = 1;
        $conditions['SheetRideDetailRides.status_id '] = array(1, 2, 3, 4, 5, 6, 7);
        $sheetRideDetailRides = $this->SheetRideDetailRides->find('all', array(
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins
            'order' => array(
                'SheetRideDetailRides.supplier_id' => 'asc',
                'SheetRideDetailRides.real_start_date ' => 'asc',
                'SheetRideDetailRides.id' => 'asc'
            ),
            'conditions' => $conditions,
            'fields' => array(
                'SheetRideDetailRides.id',
                'SheetRideDetailRides.reference',
                'SheetRideDetailRides.supplier_id',
                'SheetRideDetailRides.detail_ride_id',
                'SheetRideDetailRides.status_id',
                'Supplier.name',
            ),
            'joins' => array(
                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
                ),
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('SheetRideDetailRides.supplier_id = Supplier.id')
                )
            )
        ));

        $array_ids = array();
        $missions = array();

        foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
            array_push($array_ids, $sheetRideDetailRide['SheetRideDetailRides']['id']);
            switch (true) {
                case ($sheetRideDetailRide['SheetRideDetailRides']['status_id'] == 1 ||
                    $sheetRideDetailRide['SheetRideDetailRides']['status_id'] == 2 ||
                    $sheetRideDetailRide['SheetRideDetailRides']['status_id'] == 3):
                    $rides = $this->SheetRideDetailRides->find('first', array(
                        'order' => array(
                            'SheetRideDetailRides.supplier_id' => 'asc',
                            'MONTH( SheetRideDetailRides.real_start_date )' => 'asc',
                            'SheetRideDetailRides.id' => 'asc'
                        ),
                        'recursive' => -1,
                        'conditions' => array('SheetRideDetailRides.id' => $sheetRideDetailRide['SheetRideDetailRides']['id']),
                        'fields' => array(
                            'SheetRideDetailRides.id',
                            'SheetRideDetailRides.supplier_id',
                            'SheetRideDetailRides.return_mission',
                            'SheetRideDetailRides.detail_ride_id',
                            'SheetRideDetailRides.id',
                            'SheetRideDetailRides.status_id',
                            'SheetRideDetailRides.ride_category_id',
                            'TransportBillDetailRides.id',
                            'TransportBillDetailRides.unit_price',
                            'TransportBillDetailRides.tva_id',
                            'TransportBillDetailRides.ristourne_%',
                            'TransportBillDetailRides.ristourne_val',
                            'Supplier.id',
                            'Supplier.name',
                        ),
                        'joins' => array(

                            array(
                                'table' => 'transport_bill_detail_rides',
                                'type' => 'left',
                                'alias' => 'TransportBillDetailRides',
                                'conditions' => array('SheetRideDetailRides.transport_bill_detail_ride_id = TransportBillDetailRides.id')
                            ),
                            array(
                                'table' => 'detail_rides',
                                'type' => 'left',
                                'alias' => 'DetailRide',
                                'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
                            ),
                            array(
                                'table' => 'suppliers',
                                'type' => 'left',
                                'alias' => 'Supplier',
                                'conditions' => array('SheetRideDetailRides.supplier_id = Supplier.id')
                            ),
                        )
                    ));
					if(!empty($rides)){
						array_push($missions, $rides);
					}
                    
                    break;

                case (
                    $sheetRideDetailRide['SheetRideDetailRides']['status_id'] == 7):


                    $rides = $this->SheetRideDetailRides->find('first', array(
                        'order' => array(
                            'SheetRideDetailRides.supplier_id' => 'asc',
                            'MONTH( SheetRideDetailRides.real_start_date )' => 'asc',
                            'SheetRideDetailRides.id' => 'asc'
                        ),
                        'recursive' => -1,
                        'conditions' => array(
                            'SheetRideDetailRides.id' => $sheetRideDetailRide['SheetRideDetailRides']['id'],
                            'TransportBill.type' => 7
                        ),
                        'fields' => array(
                            'SheetRideDetailRides.id',
                            'SheetRideDetailRides.supplier_id',
                            'SheetRideDetailRides.return_mission',
                            'SheetRideDetailRides.detail_ride_id',
                            'SheetRideDetailRides.status_id',
                            'SheetRideDetailRides.ride_category_id',
                            'TransportBillDetailRides.id',
                            'TransportBillDetailRides.unit_price',
                            'TransportBillDetailRides.tva_id',
                            'TransportBillDetailRides.ristourne_%',
                            'TransportBillDetailRides.ristourne_val',
                            'Supplier.id',
                            'Supplier.name',
                        ),
                        'joins' => array(

                            array(
                                'table' => 'transport_bill_detail_rides',
                                'type' => 'left',
                                'alias' => 'TransportBillDetailRides',
                                'conditions' => array('SheetRideDetailRides.id = TransportBillDetailRides.sheet_ride_detail_ride_id')
                            ),
                            array(
                                'table' => 'transport_bills',
                                'type' => 'left',
                                'alias' => 'TransportBill',
                                'conditions' => array('TransportBill.id = TransportBillDetailRides.transport_bill_id')
                            ),
                            array(
                                'table' => 'suppliers',
                                'type' => 'left',
                                'alias' => 'Supplier',
                                'conditions' => array('SheetRideDetailRides.supplier_id = Supplier.id')
                            ),

                        )
                    ));

                    if(!empty($rides)){
						array_push($missions, $rides);
					}
                    break;

                case ($sheetRideDetailRide['SheetRideDetailRides']['status_id'] == 4 ||
                    $sheetRideDetailRide['SheetRideDetailRides']['status_id'] == 5 ||
                    $sheetRideDetailRide['SheetRideDetailRides']['status_id'] == 6):
                    $rides = $this->SheetRideDetailRides->find('first', array(
                        'order' => array(
                            'SheetRideDetailRides.supplier_id' => 'asc',
                            'MONTH( SheetRideDetailRides.real_start_date )' => 'asc',
                            'SheetRideDetailRides.id' => 'asc'
                        ),
                        'recursive' => -1,
                        'conditions' => array(
                            'SheetRideDetailRides.id' => $sheetRideDetailRide['SheetRideDetailRides']['id'],
                            'TransportBill.type' => 4
                        ),
                        'fields' => array(
                            'SheetRideDetailRides.id',
                            'SheetRideDetailRides.supplier_id',
                            'SheetRideDetailRides.return_mission',
                            'SheetRideDetailRides.detail_ride_id',
                            'SheetRideDetailRides.status_id',
                            'SheetRideDetailRides.ride_category_id',
                            'TransportBillDetailRides.id',
                            'TransportBillDetailRides.unit_price',
                            'TransportBillDetailRides.tva_id',
                            'TransportBillDetailRides.ristourne_%',
                            'TransportBillDetailRides.ristourne_val',
                            'TransportBill.type',
                            'Supplier.id',
                            'Supplier.name',
                        ),
                        'joins' => array(

                            array(
                                'table' => 'transport_bill_detail_rides',
                                'type' => 'left',
                                'alias' => 'TransportBillDetailRides',
                                'conditions' => array('SheetRideDetailRides.id = TransportBillDetailRides.sheet_ride_detail_ride_id')
                            ),
                            array(
                                'table' => 'transport_bills',
                                'type' => 'left',
                                'alias' => 'TransportBill',
                                'conditions' => array('TransportBill.id = TransportBillDetailRides.transport_bill_id')
                            ),
                            array(
                                'table' => 'suppliers',
                                'type' => 'left',
                                'alias' => 'Supplier',
                                'conditions' => array('SheetRideDetailRides.supplier_id = Supplier.id')
                            ),
                        )
                    ));
                    if(!empty($rides)){
						array_push($missions, $rides);
					}
                    break;
            }
        }
        $results = array();
        $sheetRideDetailRides = $missions;
        if (!empty($sheetRideDetailRides)) {
            foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
                if (isset($sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'])) {
                    $detail_ride_id = $sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'];
                } else {
                    $detail_ride_id = 0;
                }
                if (isset($sheetRideDetailRide['SheetRideDetailRides']['supplier_id'])) {
                    $supplier_id = $sheetRideDetailRide['SheetRideDetailRides']['supplier_id'];
                } else {
                    $supplier_id = 0;
                }

                if (isset($sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'])) {
                    $ride_category_id = $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'];
                } else {
                    $ride_category_id = 0;
                }

                if (!empty($sheetRideDetailRide['TransportBillDetailRides']['unit_price'])) {
                    $sheetRideDetailRide['SheetRideDetailRides']['unit_price'] = $sheetRideDetailRide['TransportBillDetailRides']['unit_price'];
                } else {
                    $price = $this->getPriceRide($detail_ride_id, $supplier_id, $ride_category_id);
                    if (!empty($price)) {
                        if ($sheetRideDetailRide['SheetRideDetailRides']['return_mission'] == 1) {
                            $sheetRideDetailRide['SheetRideDetailRides']['unit_price'] = $price[0] + $price[2];

                        } else {
                            $sheetRideDetailRide['SheetRideDetailRides']['unit_price'] = $price[0];
                        }

                    } else {
                        $sheetRideDetailRide['SheetRideDetailRides']['unit_price'] = 0;
                    }
                }
                if (!isset($sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'])) {
                    $sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'] = 0;
                }
                if (!isset($sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'])) {
                    $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'] = 0;
                }
                if (isset($sheetRideDetailRide['SheetRideDetailRides']['return_mission'])) {
                    $sheetRideDetailRide['SheetRideDetailRides']['delivery_with_return'] = $sheetRideDetailRide['SheetRideDetailRides']['return_mission'];
                } else {
                    $sheetRideDetailRide['SheetRideDetailRides']['delivery_with_return'] = 0;
                }
                if (isset($sheetRideDetailRide['TransportBillDetailRides']['ristourne_%'])) {
                    $sheetRideDetailRide['SheetRideDetailRides']['ristourne_%'] = $sheetRideDetailRide['TransportBillDetailRides']['ristourne_%'];
                } else {
                    $sheetRideDetailRide['SheetRideDetailRides']['ristourne_%'] = 0;
                }

                if (!empty($sheetRideDetailRide['TransportBillDetailRides']['ristourne_%'])) {
                    $sheetRideDetailRide['SheetRideDetailRides']['ristourne_val'] = ($sheetRideDetailRide['TransportBillDetailRides']['unit_price'] * $sheetRideDetailRide['TransportBillDetailRides']['ristourne_%']) / 100;
                    $sheetRideDetailRide['SheetRideDetailRides']['price_ht'] = $sheetRideDetailRide['TransportBillDetailRides']['unit_price'] - $sheetRideDetailRide['TransportBillDetailRides']['ristourne_val'];

                } else {
                    $sheetRideDetailRide['SheetRideDetailRides']['ristourne_val'] = null;
                    $sheetRideDetailRide['SheetRideDetailRides']['price_ht'] = $sheetRideDetailRide['SheetRideDetailRides']['unit_price'];
                }
                if (!empty($sheetRideDetailRide['TransportBillDetailRides']['tva_id'])) {
                    $sheetRideDetailRide['SheetRideDetailRides']['tva_id'] = $sheetRideDetailRide['TransportBillDetailRides']['tva_id'];
                    $sheetRideDetailRide['SheetRideDetailRides']['price_ttc'] = $sheetRideDetailRide['SheetRideDetailRides']['price_ht'] +
                        ($sheetRideDetailRide['SheetRideDetailRides']['price_ht'] * $this->Tva->getTvaValueById($sheetRideDetailRide['TransportBillDetailRides']['tva_id']));
                } else {
                    $sheetRideDetailRide['SheetRideDetailRides']['tva_id'] = 1;
                    $sheetRideDetailRide['SheetRideDetailRides']['price_ttc'] = $sheetRideDetailRide['SheetRideDetailRides']['price_ht'] + ($sheetRideDetailRide['SheetRideDetailRides']['price_ht'] * 0.19);
                }
                array_push($results, $sheetRideDetailRide);

            }
        }
        return $results;
    }
    public function reservationsBySupplier() {
        if (isset($this->request->data['Statistic']['supplier_id']) && !empty($this->request->data['Statistic']['supplier_id'])) {
            $supplierId = $this->request->data['Statistic']['supplier_id'];
        } else {
            $supplierId = null;
        }

        if (isset($this->request->data['Statistic']['car_id']) && !empty($this->request->data['Statistic']['car_id'])) {
            $carId = $this->request->data['Statistic']['car_id'];
        } else {
            $carId = null;
        }

        if (isset($this->request->data['Statistic']['year']) && $this->request->data['Statistic']['year'] > 1000 && $this->request->data['Statistic']['year'] < 2100) {
            $year = $this->request->data['Statistic']['year'];

        } else {
            $year = null;

            $this->request->data['Statistic']['year'] = date("Y");
        }
        if (isset($this->request->data['Statistic']['min_month']) && $this->request->data['Statistic']['min_month'] > 0 && $this->request->data['Statistic']['min_month'] < 13) {
            $minMonth = $this->request->data['Statistic']['min_month'];
        } else {
            $minMonth = null;
        }
        if (isset($this->request->data['Statistic']['max_month']) && $this->request->data['Statistic']['max_month'] > 0 && $this->request->data['Statistic']['max_month'] < 13) {
            $maxMonth = $this->request->data['Statistic']['max_month'];
        } else {
            $maxMonth = null;
        }
        $results = $this->Statistic->getReservationsBySupplier($supplierId, $carId, $year, $minMonth, $maxMonth );
        $suppliers = $this->Supplier->getSuppliersByParams(0, 1, array(1));
        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name )"
            );

        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames',
            'recursive' => -1,
            'order' => 'Car.code ASC',
            'conditions'=>array('Car.car_parc'=>2),
            'joins' => array(
                array(
                    'table' => 'marks',
                    'type' => 'left',
                    'alias' => 'Mark',
                    'conditions' => array('Car.mark_id = Mark.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                ),
            )));
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('results','suppliers','cars','param','separatorAmount'));

    }

    public function productsByInterventions(){

        $this->setTimeActif();
        if (isset($this->request->data['Statistic']['car_id']) && !empty($this->request->data['Statistic']['car_id'])) {
            $carId = $this->request->data['Statistic']['car_id'];
        } else {
            $carId = null;
        }
        if (isset($this->request->data['Statistic']['customer_id']) && !empty($this->request->data['Statistic']['customer_id'])) {
            $customerId = $this->request->data['Statistic']['customer_id'];
        } else {
            $customerId = null;
        }
        if (isset($this->request->data['Statistic']['event_type_id']) && !empty($this->request->data['Statistic']['event_type_id'])) {
            $eventTypeId = $this->request->data['Statistic']['event_type_id'];
        } else {
            $eventTypeId = null;
        }
        if (isset($this->request->data['Statistic']['supplier_id']) && !empty($this->request->data['Statistic']['supplier_id'])) {
            $supplierId = $this->request->data['Statistic']['supplier_id'];
        } else {
            $supplierId = null;
        }
        if (isset($this->request->data['Statistic']['structure_id']) && !empty($this->request->data['Statistic']['structure_id'])) {
            $structureId = $this->request->data['Statistic']['structure_id'];
        } else {
            $structureId = null;
        }
        if (isset($this->request->data['Statistic']['product_id']) && !empty($this->request->data['Statistic']['product_id'])) {
            $productId = $this->request->data['Statistic']['product_id'];
        } else {
            $productId = null;
        }
        if (isset($this->request->data['Statistic']['date']) && $this->isDate($this->request->data['Statistic']['date'])) {
            $start = str_replace("-", "/", $this->request->data['Statistic']['date']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $startDate = $startdtm->format('Y-m-d 00:00:00');
        } else {
            $startDate = null;
        }

        if (isset($this->request->data['Statistic']['parc_id']) && !empty($this->request->data['Statistic']['parc_id'])) {
            $parcId = $this->request->data['Statistic']['parc_id'];
        } else {
            $parcId = null;
        }
        if (isset($this->request->data['Statistic']['next_date']) && $this->isDate($this->request->data['Statistic']['next_date'])) {
            $end = str_replace("-", "/", $this->request->data['Statistic']['next_date']);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $endDate = $enddtm->format('Y-m-d 00:00:00');
        } else {
            $endDate = null;
        }
        $results = $this->Statistic->getProductsByInterventions($carId, $customerId, $eventTypeId,
            $supplierId, $structureId, $productId, $startDate, $endDate,$parcId);

        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);
        $eventTypes = $this->EventType->getEventTypes();
        $suppliers = $this->Supplier->getSuppliersByParams(0, 1);
        $structures = $this->Structures->find('list');
        $products = $this->Product->getProducts();
        if ($this->IsAdministrator) {
            $parcs = $this->Parc->getParcs('list');
        } else {
            $parcIds = $this->getParcsUserIdsArray($userId);
            if (!empty($parcIds)) {
                $parcs = $this->Parc->getParcByIds($parcIds);
            } else {
                $parcs = $this->Parc->getParcs('list');
            }
        }
        $this->set(compact('results', 'cars', 'param',
            'customers','eventTypes','suppliers','structures','products','parcs'));

    }
    public function exportProductsByInterventions(){

        $productIntervention = filter_input(INPUT_POST, "product_intervention");

        $productIntervention = explode(",", $productIntervention);


        $carId = $productIntervention[0];
        $customerId = $productIntervention[1];
        $eventTypeId = $productIntervention[2];
        $supplierId = $productIntervention[3];
        $productId = $productIntervention[4];
        $structureId = $productIntervention[5];

        $startDate = $productIntervention[6];
        $endDate = $productIntervention[7];
        $parcId = $productIntervention[8];


        if (isset($startDate) && $this->isDate($startDate)) {
            $start = str_replace("-", "/", $startDate);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $startDate = $startdtm->format('Y-m-d 00:00:00');
        } else {
            $startDate = null;
        }
        if (isset($endDate) && $this->isDate($endDate)) {
            $end = str_replace("-", "/", $endDate);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $endDate = $enddtm->format('Y-m-d 00:00:00');
        } else {
            $endDate = null;
        }
        $results = $this->Statistic->getProductsByInterventions($carId, $customerId, $eventTypeId,
            $supplierId, $structureId, $productId, $startDate, $endDate,$parcId);

        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);
        $eventTypes = $this->EventType->getEventTypes();
        $suppliers = $this->Supplier->getSuppliersByParams(0, 1);
        $structures = $this->Structures->find('list');
        $products = $this->Product->getProducts();
        $this->set(compact('results', 'cars', 'param',
            'customers','eventTypes','suppliers','structures','products'));

    }
    public function productsByInterventionsPdf(){

        $productIntervention = filter_input(INPUT_POST, "product_intervention");

        $productIntervention = explode(",", $productIntervention);


        $carId = $productIntervention[0];
        $customerId = $productIntervention[1];
        $eventTypeId = $productIntervention[2];
        $supplierId = $productIntervention[3];
        $productId = $productIntervention[4];
        $structureId = $productIntervention[5];

        $startDate = $productIntervention[6];
        $endDate = $productIntervention[7];
        $parcId = $productIntervention[8];


        if (isset($startDate) && $this->isDate($startDate)) {
            $start = str_replace("-", "/", $startDate);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $startDate = $startdtm->format('Y-m-d 00:00:00');
        } else {
            $startDate = null;
        }
        if (isset($endDate) && $this->isDate($endDate)) {
            $end = str_replace("-", "/", $endDate);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $endDate = $enddtm->format('Y-m-d 00:00:00');
        } else {
            $endDate = null;
        }
        $results = $this->Statistic->getProductsByInterventions($carId, $customerId, $eventTypeId,
            $supplierId, $structureId, $productId, $startDate, $endDate,$parcId);

        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }

        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));
        $fields = "names";
        $customers = $this->Customer->getCustomersByFieldsAndConds($fields);
        $eventTypes = $this->EventType->getEventTypes();
        $suppliers = $this->Supplier->getSuppliersByParams(0, 1);
        $structures = $this->Structures->find('list');
        $products = $this->Product->getProducts();
        if (count($results) > 1000){
            $this->Flash->error(__('Select a parc please.'));
            $this->redirect(array('action' => 'productsByInterventions'));
        }
        $this->set(compact('results', 'cars', 'param',
            'customers','eventTypes','suppliers','structures','products'));

    }



    public function carByWorkshops(){

        $this->setTimeActif();
        if (isset($this->request->data['Statistic']['car_id']) && !empty($this->request->data['Statistic']['car_id'])) {
            $carId = $this->request->data['Statistic']['car_id'];
        } else {
            $carId = null;
        }
        if (isset($this->request->data['Statistic']['mechanician_id']) && !empty($this->request->data['Statistic']['mechanician_id'])) {
            $mechanicId = $this->request->data['Statistic']['mechanician_id'];
        } else {
            $mechanicId = null;
        }


        if (isset($this->request->data['Statistic']['workshop_id']) && !empty($this->request->data['Statistic']['workshop_id'])) {
            $workshopId = $this->request->data['Statistic']['workshop_id'];
        } else {
            $workshopId = null;
        }

        if (isset($this->request->data['Statistic']['date']) && $this->isDate($this->request->data['Statistic']['date'])) {
            $start = str_replace("-", "/", $this->request->data['Statistic']['date']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $startDate = $startdtm->format('Y-m-d 00:00:00');
        } else {
            $startDate = null;
        }
        if (isset($this->request->data['Statistic']['next_date']) && $this->isDate($this->request->data['Statistic']['next_date'])) {
            $end = str_replace("-", "/", $this->request->data['Statistic']['next_date']);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $endDate = $enddtm->format('Y-m-d 00:00:00');
        } else {
            $endDate = null;
        }
        $results = $this->Statistic->getCarByWorkshops($carId, $mechanicId, $workshopId, $startDate, $endDate);

        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));
        $fields = "names";
        $conditionMechanic = array('CustomerCategory.mechanician'=>1);
        $mechanicians = $this->Customer->getCustomersByFieldsAndConds($fields,$conditionMechanic);
        $workshops = $this->Workshop->find('list');
        $this->set(compact('results', 'cars', 'param',
            'mechanicians','workshops'));

    }
    public function exportCarByWorkshops(){

        $carWorkshop = filter_input(INPUT_POST, "car_workshop");

        $carWorkshop = explode(",", $carWorkshop);


        $carId = $carWorkshop[0];
        $mechanicId = $carWorkshop[1];
        $workshopId = $carWorkshop[2];
        $startDate = $carWorkshop[3];
        $endDate = $carWorkshop[4];



        if (isset($startDate) && $this->isDate($startDate)) {
            $start = str_replace("-", "/", $startDate);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $startDate = $startdtm->format('Y-m-d 00:00:00');
        } else {
            $startDate = null;
        }
        if (isset($endDate) && $this->isDate($endDate)) {
            $end = str_replace("-", "/", $endDate);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $endDate = $enddtm->format('Y-m-d 00:00:00');
        } else {
            $endDate = null;
        }
        $results = $this->Statistic->getCarByWorkshops($carId, $mechanicId, $workshopId, $startDate, $endDate);

        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));
        $fields = "names";
        $conditionMechanic = array('CustomerCategory.mechanician'=>1);
        $mechanicians = $this->Customer->getCustomersByFieldsAndConds($fields,$conditionMechanic);
        $workshops = $this->Workshop->find('list');
        $this->set(compact('results', 'cars', 'param',
            'mechanicians','workshops'));

    }
    public function carByWorkshopsPdf(){

        $carWorkshop = filter_input(INPUT_POST, "car_workshop");

        $carWorkshop = explode(",", $carWorkshop);


        $carId = $carWorkshop[0];
        $mechanicId = $carWorkshop[1];
        $workshopId = $carWorkshop[2];
        $startDate = $carWorkshop[3];
        $endDate = $carWorkshop[4];



        if (isset($startDate) && $this->isDate($startDate)) {
            $start = str_replace("-", "/", $startDate);
            $startdtm = DateTime::createFromFormat('d/m/Y', $start);
            $startDate = $startdtm->format('Y-m-d 00:00:00');
        } else {
            $startDate = null;
        }
        if (isset($endDate) && $this->isDate($endDate)) {
            $end = str_replace("-", "/", $endDate);
            $enddtm = DateTime::createFromFormat('d/m/Y', $end);
            $endDate = $enddtm->format('Y-m-d 00:00:00');
        } else {
            $endDate = null;
        }
        $results = $this->Statistic->getCarByWorkshops($carId, $mechanicId, $workshopId, $startDate, $endDate);

        $param = $this->Parameter->getCodesParameterVal('name_car');
        if ($param == 1) {
            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(Car.code, ' - ', Carmodel.name)"
            );
        } elseif ($param == 2) {

            $this->Car->virtualFields = array(
                'cnames' => "CONCAT(IFNULL(IFNULL(Car.immatr_def,Car.immatr_prov),'immatr'), ' - ',IFNULL(Carmodel.name,'Sans model') )"
            );
        }
        $cars = $this->Car->find('list', array('fields' => 'cnames', 'recursive' => 1, 'order' => 'Carmodel.name asc'));
        $fields = "names";
        $conditionMechanic = array('CustomerCategory.mechanician'=>1);
        $mechanicians = $this->Customer->getCustomersByFieldsAndConds($fields,$conditionMechanic);
        $workshops = $this->Workshop->find('list');
        $this->set(compact('results', 'cars', 'param',
            'mechanicians','workshops'));

    }
}
