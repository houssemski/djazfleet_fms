<?php
App::uses('AppController', 'Controller');

/**
 * Prices Controller
 *
 * @property Price $Price
 * @property DetailRide $DetailRide
 * @property Supplier $Supplier
 * @property CarType $CarType
 * @property Profile $Profile
 * @property SupplierCategory $SupplierCategory
 * @property ProductTypeFactor $ProductTypeFactor
 * @property PriceRideCategory $PriceRideCategory
 * @property Promotion $Promotion
 * @property Tonnage $Tonnage
 * @property Service $Service
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class PricesController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    var $helpers = array('Xls');
    public $uses = array('Price', 'DetailRide', 'CarType', 'Profile','Promotion',
        'SupplierCategory','Tonnage','Service','ProductTypeFactor','ProductPrice','ProductPriceFactor');

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $hasSalesModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSalesModule == 0 && $hasStandardSaleModule == 0) {
            return $this->redirect('/');
        }

        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::tarif_trajet, $user_id, ActionsEnum::view,
            "Prices", null, "Price", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        switch ($result) {
            case 1 :
                $conditions = null;
                break;
            case 2 :
                $conditions = array('Price.user_id' => $user_id);
                break;
            case 3 :
                $conditions = array('Price.user_id !=' => $user_id);
                break;
            default:
                $conditions = null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'conditions' => $conditions,
            'order' => array('Price.id' => 'DESC'),
            'paramType' => 'querystring',
            'recursive' => -1,
            'fields' => array(
                'CarType.name',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Price.id',
                'Price.type_pricing',
                'Price.km_from',
                'Price.km_to',
                'Tonnage.name',
                'Price.wording',
                'SupplierCategory.name',
                'Supplier.name',
                'RideCategory.name',
                'PriceRideCategory.price_ht',
                'PriceRideCategory.price_return',
                'PriceRideCategory.theoretical_amount_charges',
                'PriceRideCategory.price_ht_night',
                'PriceRideCategory.start_date',
                'PriceRideCategory.end_date',
                'ProductPrice.start_date',
                'ProductPrice.end_date',
                'ProductPrice.price_ht',
                'Product.name',

            ),
            'joins' => array(

                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('Price.detail_ride_id = DetailRide.id')
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
                    'conditions' => array('Price.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'supplier_categories',
                    'type' => 'left',
                    'alias' => 'SupplierCategory',
                    'conditions' => array('Price.supplier_category_id = SupplierCategory.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('DetailRide.car_type_id = CarType.id')
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
                array(
                    'table' => 'price_ride_categories',
                    'type' => 'left',
                    'alias' => 'PriceRideCategory',
                    'conditions' => array('Price.id = PriceRideCategory.price_id')
                ),
                array(
                    'table' => 'ride_categories',
                    'type' => 'left',
                    'alias' => 'RideCategory',
                    'conditions' => array('RideCategory.id = PriceRideCategory.ride_category_id')
                ),
                array(
                    'table' => 'tonnages',
                    'type' => 'left',
                    'alias' => 'Tonnage',
                    'conditions' => array('Tonnage.id = Price.tonnage_id')
                ),
                array(
                    'table' => 'product_prices',
                    'type' => 'left',
                    'alias' => 'ProductPrice',
                    'conditions' => array('ProductPrice.price_id = Price.id')
                ),
                array(
                    'table' => 'products',
                    'type' => 'left',
                    'alias' => 'Product',
                    'conditions' => array('ProductPrice.product_id = Product.id')
                )

            )
        );
        $prices = $this->Paginator->paginate('Price');

        $this->set('prices', $prices);
        $separatorAmount = $this->getSeparatorAmount();
        $users = $this->User->find('list', array('conditions' => 'User.id != 1'));
        $profiles = $this->Profile->getUserProfiles();
        $destinations = $this->DetailRide->Ride->DepartureDestination->find('list');
        $carTypes = $this->CarType->getCarTypes();
        $rideCategories = $this->TransportBill->RideCategory->find('list', array(
            'order' => 'RideCategory.name ASC',
            'recursive' => -1,
            'conditions'=>array('RideCategory.id !='=>0),
            'fields' => 'name'
        ));


        $supplierCategories = $this->SupplierCategory->getSupplierCategoriesByType(SupplierCategoriesEnum::CUSTOMER_TYPE);
        $useRideCategory = $this->useRideCategory();
        $isSuperAdmin = $this->isSuperAdmin();
        $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
        $this->set(compact('profiles', 'limit', 'separatorAmount', 'users', 'destinations', 'carTypes',
            'rideCategories',  'supplierCategories', 'useRideCategory', 'isSuperAdmin','paramPriceNight'));
    }

    public function search()
    {
        $hasSalesModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSalesModule == 0 && $hasStandardSaleModule == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        if (isset($this->request->data['keyword']) || isset($this->request->data['Prices']['user_id']) ||
            isset($this->request->data['Prices']['modified_id']) || isset($this->request->data['Prices']['profile_id'])
            || isset($this->request->data['Prices']['created']) || isset($this->request->data['Prices']['created1'])
            || isset($this->request->data['Prices']['modified']) || isset($this->request->data['Prices']['modified1'])
            || isset($this->request->data['Prices']['arrival_destination_id'])
            || isset($this->request->data['Prices']['departure_destination_id'])
            || isset($this->request->data['Prices']['car_type_id']) || isset($this->request->data['Prices']['ride_category_id'])
            || isset($this->request->data['Prices']['supplier_id']) || isset($this->request->data['Prices']['supplier_category_id'])
            || isset($this->request->data['Prices']['price_min']) || isset($this->request->data['Prices']['price_max'])

        ) {
            $this->filterUrl();
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        if (isset($this->params['named']['keyword']) || isset($this->params['named']['user']) || isset($this->params['named']['profile'])
            || isset($this->params['named']['created']) || isset($this->params['named']['created1'])
            || isset($this->params['named']['car_type']) || isset($this->params['named']['modified_id'])
            || isset($this->params['named']['departure_destination']) || isset($this->params['named']['arrival_destination'])
            || isset($this->params['named']['modified']) || isset($this->params['named']['modified1'])
            || isset($this->params['named']['ride_category']) || isset($this->params['named']['supplier'])
            || isset($this->params['named']['supplier_category']) || isset($this->params['named']['price_min']) || isset($this->params['named']['price_max'])
        ) {
            $conditions = $this->getConds();
            $this->paginate = array(
                'paramType' => 'querystring',
                'recursive' => -1, // should be used with joins
                'limit' => $limit,
                'conditions' => $conditions,
                'order' => array('Price.id' => 'DESC'),
                'fields' => array(
                    'CarType.name',
                    'DepartureDestination.name',
                    'ArrivalDestination.name',
                    'Price.id',
                    'Price.wording',
                    'SupplierCategory.name',
                    'Supplier.name',
                    'RideCategory.name',
                    'PriceRideCategory.price_ht',
                    'PriceRideCategory.price_return',
                    'PriceRideCategory.theoretical_amount_charges',
                    'PriceRideCategory.price_ht_night',
                    'PriceRideCategory.start_date',
                    'PriceRideCategory.end_date',

                ),
                'joins' => array(

                    array(
                        'table' => 'detail_rides',
                        'type' => 'left',
                        'alias' => 'DetailRide',
                        'conditions' => array('Price.detail_ride_id = DetailRide.id')
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
                        'conditions' => array('Price.supplier_id = Supplier.id')
                    ),
                    array(
                        'table' => 'supplier_categories',
                        'type' => 'left',
                        'alias' => 'SupplierCategory',
                        'conditions' => array('Price.supplier_category_id = SupplierCategory.id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'CarType',
                        'conditions' => array('DetailRide.car_type_id = CarType.id')
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
                    array(
                        'table' => 'price_ride_categories',
                        'type' => 'left',
                        'alias' => 'PriceRideCategory',
                        'conditions' => array('Price.id = PriceRideCategory.price_id')
                    ),
                    array(
                        'table' => 'ride_categories',
                        'type' => 'left',
                        'alias' => 'RideCategory',
                        'conditions' => array('RideCategory.id = PriceRideCategory.ride_category_id')
                    ),
                    array(
                        'table' => 'users',
                        'type' => 'left',
                        'alias' => 'User',
                        'conditions' => array('User.id = Price.user_id')
                    )

                )
            );

            $prices = $this->Paginator->paginate('Price');

            $this->set('prices', $prices);

        } else {
            $this->Price->recursive = 0;
            $this->set('prices', $this->Paginator->paginate());
        }
        $users = $this->User->find('list', array('conditions' => 'User.id != 1'));
        $profiles = $this->Profile->getUserProfiles();
        $destinations = $this->DetailRide->Ride->DepartureDestination->find('list');
        $carTypes = $this->CarType->getCarTypes();
        $rideCategories = $this->TransportBill->RideCategory->find('list', array(
            'order' => 'RideCategory.name ASC',
            'recursive' => -1,
            'conditions'=>array('RideCategory.id !='=>0),
            'fields' => 'name'
        ));


        $supplierCategories = $this->SupplierCategory->getSupplierCategoriesByType(SupplierCategoriesEnum::CUSTOMER_TYPE);
        $separatorAmount = $this->getSeparatorAmount();
        $useRideCategory = $this->useRideCategory();
        $isSuperAdmin = $this->isSuperAdmin();
        $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
        $this->set(compact('profiles', 'limit', 'users', 'destinations', 'carTypes', 'separatorAmount',
            'rideCategories', 'supplierCategories', 'useRideCategory', 'isSuperAdmin','paramPriceNight'));
        $this->render();
    }


    private function filterUrl()
    {


        $filter_url['controller'] = $this->request->params['controller'];
        $filter_url['action'] = $this->request->params['action'];
        $filter_url['page'] = 1;
        $filter_url['keyword'] = $this->request->data['keyword'];
        //$filter_url['keyword'] = str_replace('/', '-', $filter_url['keyword']);

        if (isset($this->request->data['Prices']['departure_destination_id']) && !empty($this->request->data['Prices']['departure_destination_id'])) {
            $filter_url['departure_destination'] = $this->request->data['Prices']['departure_destination_id'];
        }
        if (isset($this->request->data['Prices']['arrival_destination_id']) && !empty($this->request->data['Prices']['arrival_destination_id'])) {
            $filter_url['arrival_destination'] = $this->request->data['Prices']['arrival_destination_id'];
        }

        if (isset($this->request->data['Prices']['car_type_id']) && !empty($this->request->data['Prices']['car_type_id'])) {
            $filter_url['car_type'] = $this->request->data['Prices']['car_type_id'];
        }

        if (isset($this->request->data['Prices']['ride_category_id']) && !empty($this->request->data['Prices']['ride_category_id'])) {
            $filter_url['ride_category'] = $this->request->data['Prices']['ride_category_id'];
        }

        if (isset($this->request->data['Prices']['ride_category_id']) && !empty($this->request->data['Prices']['ride_category_id'])) {
            $filter_url['ride_category'] = $this->request->data['Prices']['ride_category_id'];
        }

        if (isset($this->request->data['Prices']['supplier_category_id']) && !empty($this->request->data['Prices']['supplier_category_id'])) {
            $filter_url['supplier_category'] = $this->request->data['Prices']['supplier_category_id'];
        }

        if (isset($this->request->data['Prices']['supplier_id']) && !empty($this->request->data['Prices']['supplier_id'])) {
            $filter_url['supplier'] = $this->request->data['Prices']['supplier_id'];
        }

        if (isset($this->request->data['Prices']['price_min']) && !empty($this->request->data['Prices']['price_min'])) {
            $filter_url['price_min'] = $this->request->data['Prices']['price_min'];
        }

        if (isset($this->request->data['Prices']['price_max']) && !empty($this->request->data['Prices']['price_max'])) {
            $filter_url['price_max'] = $this->request->data['Prices']['price_max'];
        }

        if (isset($this->request->data['Prices']['user_id']) && !empty($this->request->data['Prices']['user_id'])) {
            $filter_url['user'] = $this->request->data['Prices']['user_id'];
        }

        if (isset($this->request->data['Prices']['profile_id']) && !empty($this->request->data['Prices']['profile_id'])) {
            $filter_url['profile'] = $this->request->data['Prices']['profile_id'];
        }

        if (isset($this->request->data['Prices']['created']) && !empty($this->request->data['Prices']['created'])) {
            $filter_url['created'] = str_replace("/", "-", $this->request->data['Prices']['created']);
        }
        if (isset($this->request->data['Prices']['created1']) && !empty($this->request->data['Prices']['created1'])) {
            $filter_url['created1'] = str_replace("/", "-", $this->request->data['Prices']['created1']);
        }
        if (isset($this->request->data['Prices']['modified_id']) && !empty($this->request->data['Prices']['modified_id'])) {
            $filter_url['modified_id'] = $this->request->data['Prices']['modified_id'];
        }
        if (isset($this->request->data['Prices']['modified']) && !empty($this->request->data['Prices']['modified'])) {
            $filter_url['modified'] = str_replace("/", "-", $this->request->data['Prices']['modified']);
        }


        return $this->redirect($filter_url);
    }

    private function getConds()
    {
        if (!empty($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));


            $conds = array(
                'OR' => array(
                    " CONVERT(Ride.wording USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$keyword%",
                    " CONVERT(DepartureDestination.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$keyword% ",
                    "CONVERT(ArrivalDestination.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$keyword%",

                )
            );
        } else {
            $conds = array();
        }


        if (isset($this->params['named']['departure_destination']) && !empty($this->params['named']['departure_destination'])) {

            $conds["Ride.departure_destination_id = "] = $this->params['named']['departure_destination'];
            $this->request->data['Prices']['departure_destination_id'] = $this->params['named']['departure_destination'];

        }

        if (isset($this->params['named']['arrival_destination']) && !empty($this->params['named']['arrival_destination'])) {

            $conds["Ride.arrival_destination_id = "] = $this->params['named']['arrival_destination'];
            $this->request->data['Prices']['arrival_destination_id'] = $this->params['named']['arrival_destination'];

        }

        if (isset($this->params['named']['car_type']) && !empty($this->params['named']['car_type'])) {

            $conds["DetailRide.car_type_id = "] = $this->params['named']['car_type'];
            $this->request->data['Prices']['car_type_id'] = $this->params['named']['car_type'];

        }

        if (isset($this->params['named']['ride_category']) && !empty($this->params['named']['ride_category'])) {

            $conds["PriceRideCategory.ride_category_id = "] = $this->params['named']['ride_category'];
            $this->request->data['Prices']['ride_category_id'] = $this->params['named']['ride_category'];

        }

        if (isset($this->params['named']['supplier']) && !empty($this->params['named']['supplier'])) {

            $conds["Price.supplier_id = "] = $this->params['named']['supplier'];
            $this->request->data['Prices']['supplier_id'] = $this->params['named']['supplier'];

        }

        if (isset($this->params['named']['supplier_category']) && !empty($this->params['named']['supplier_category'])) {

            $conds["Price.supplier_category_id = "] = $this->params['named']['supplier_category'];
            $this->request->data['Prices']['supplier_category_id'] = $this->params['named']['supplier_category'];

        }

        if (isset($this->params['named']['price_min']) && !empty($this->params['named']['price_min'])) {

            $conds["PriceRideCategory.price_ht >= "] = $this->params['named']['price_min'];
            $this->request->data['Prices']['price_min'] = $this->params['named']['price_min'];

        }

        if (isset($this->params['named']['price_max']) && !empty($this->params['named']['price_max'])) {

            $conds["PriceRideCategory.price_ht <= "] = $this->params['named']['price_max'];
            $this->request->data['Prices']['price_max'] = $this->params['named']['price_max'];

        }


        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $conds["DetailRide.user_id = "] = $this->params['named']['user'];
            $this->request->data['DetailRides']['user_id'] = $this->params['named']['user'];
        }

        if (isset($this->params['named']['profile']) && !empty($this->params['named']['profile'])) {
            $conds["User.profile_id = "] = $this->params['named']['profile'];
            $this->request->data['DetailRides']['profile_id'] = $this->params['named']['profile'];
        }


        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $creat = str_replace("-", "/", $this->params['named']['created']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["DetailRide.created >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['DetailRides']['created'] = $creat;
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $creat = str_replace("-", "/", $this->params['named']['created1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["DetailRide.created <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['DetailRides']['created1'] = $creat;
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $conds["DetailRide.modified_id = "] = $this->params['named']['modified_id'];
            $this->request->data['DetailRides']['modified_id'] = $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["DetailRide.modified >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['DetailRides']['modified'] = $creat;
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["DetailRide.modified <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['DetailRides']['modified1'] = $creat;
        }


        return $conds;
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null)
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();

        if (!$this->Price->exists($id)) {
            throw new NotFoundException(__('Invalid price'));
        }
        $this->Price->recursive = 2;
        $options = array(
            'conditions' => array('Price.' . $this->Price->primaryKey => $id),
            'recursive' => -1,
            'fields' => array(
                'CarType.name',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Price.id',
                'Price.wording',
                'SupplierCategory.name',
                'Supplier.name',
                'PriceRideCategory.price_ht',
                'PriceRideCategory.price_return',
                'PriceRideCategory.theoretical_amount_charges',
                'PriceRideCategory.price_ht_night',

            ),
            'joins' => array(

                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('Price.detail_ride_id = DetailRide.id')
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
                    'conditions' => array('Price.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'supplier_categories',
                    'type' => 'left',
                    'alias' => 'SupplierCategory',
                    'conditions' => array('Price.supplier_category_id = SupplierCategory.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('DetailRide.car_type_id = CarType.id')
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
                array(
                    'table' => 'price_ride_categories',
                    'type' => 'left',
                    'alias' => 'PriceRideCategory',
                    'conditions' => array('Price.id = PriceRideCategory.price_id')
                ),
                array(
                    'table' => 'ride_categories',
                    'type' => 'left',
                    'alias' => 'RideCategory',
                    'conditions' => array('RideCategory.id = PriceRideCategory.ride_category_id')
                )

            )

        );
        $price = $this->Price->find('first', $options);
        $separatorAmount = $this->getSeparatorAmount();
        $priceRideCategories = $this->Price->PriceRideCategory->find('all',
            array('conditions' => array('PriceRideCategory.price_id' => $id)));
        $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
        $this->set(compact('price', 'separatorAmount', 'priceRideCategories','paramPriceNight'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::tarif_trajet, $user_id, ActionsEnum::add, "Prices",
            null, "Price", null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->createDateFromDate('Price', 'start_date');
            $this->createDateFromDate('Price', 'end_date');
            $this->request->data['Price']['user_id'] = $this->Session->read('Auth.User.id');
            $rideId = $this->request->data['Price']['detail_ride_id'];
            $categoryId = $this->request->data['Price']['supplier_category_id'];
            if (isset($this->request->data['Price']['supplier_id'])) {
                $clientId = $this->request->data['Price']['supplier_id'];
            } else {
                $clientId = null;
            }
            $this->request->data['Price']['type_pricing']= (int)$this->request->data['Price']['type_pricing'];
            if($this->request->data['Price']['type_pricing']== 2){
                $this->Price->validate = $this->Price->validatePricingTonnage;
            }
            if($this->request->data['Price']['type_pricing']== 3){

                $this->Price->create();
                $this->Price->save($this->request->data['Price']);
                $priceId = $this->Price->getInsertID();


                $data = array();
                $this->createDateFromDate('ProductPrice', 'start_date');
                $this->createDateFromDate('ProductPrice', 'end_date');
                $data['ProductPrice']['start_date'] = $this->request->data['ProductPrice']['start_date'];
                $data['ProductPrice']['end_date'] = $this->request->data['ProductPrice']['end_date'];

                $data['ProductPrice']['product_id'] = $this->request->data['ProductPrice']['product_id'];
                $data['ProductPrice']['price_id'] = $priceId;
                $data['ProductPrice']['price_ht'] = $this->request->data['ProductPrice']['price_ht'];
                $data['ProductPrice']['supplier_id'] = $this->request->data['Price']['supplier_id'];
                $data['ProductPrice']['supplier_category_id'] = $this->request->data['Price']['supplier_category_id'];
                $data['ProductPrice']['service_id'] = $this->request->data['Price']['service_id'];

                $this->ProductPrice->create();
                $this->ProductPrice->save($data);
                if(isset( $this->request->data['ProductPriceFactor'])){
                    $productPriceFactors = $this->request->data['ProductPriceFactor'];
                }
                if(isset($productPriceFactors) && !empty($productPriceFactors)){
                    $productPriceId = $this->ProductPrice->getInsertID();
                    foreach ($productPriceFactors as $productPriceFactor){
                        $data2 = array();
                        $data2['ProductPriceFactor']['product_price_id'] = $productPriceId;
                        $data2['ProductPriceFactor']['factor_id'] = $productPriceFactor['factor_id'];
                        $data2['ProductPriceFactor']['factor_value'] = $productPriceFactor['factor_value'];
                        $this->ProductPriceFactor->create();
                        $this->ProductPriceFactor->save($data2);
                    }
                }

                $this->Flash->success(__('The price has been saved.'));
                $this->redirect(array('action' => 'index'));


            }else {
                $priceId = $this->getPrice(0, $rideId, $categoryId, $clientId);
                if ($priceId != null) {
                    $this->request->data['Price']['id'] = $priceId;
                } else {
                    $this->Price->create();
                }
                if ($this->Price->save($this->request->data)) {
                    if ($priceId == null) {
                        $priceId = $this->Price->getInsertID();
                    }

                    $this->savePriceRideCategory($this->request->data['PriceRideCategory'], $priceId);

                    if (!empty($this->request->data['Promotion'])
                    ) {
                        $this->savePromotions($this->request->data['Promotion'], $priceId);
                    }
                    $this->Flash->success(__('The price has been saved.'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->error(__('The price could not be saved. Please, try again.'));
                }
            }

        }

        $supplierCategories = $this->SupplierCategory->getSupplierCategoriesByType(SupplierCategoriesEnum::CUSTOMER_TYPE);
        $rideCategories = $this->TransportBill->RideCategory->find('list', array(
            'order' => 'RideCategory.name ASC',
            'recursive' => -1,
            'conditions'=>array('RideCategory.id !='=>0),
            'fields' => 'name'
        ));
        $useRideCategory = $this->useRideCategory();
        $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
        $services = $this->Service->getServices('list');
        $this->set(compact( 'supplierCategories', 'rideCategories', 'useRideCategory','paramPriceNight' ,'services'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null)
    {

        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::tarif_trajet, $user_id, ActionsEnum::edit, "Prices",
            $id, "Price", null);
        if (!$this->Price->exists($id)) {
            throw new NotFoundException(__('Invalid price'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Price cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->createDateFromDate('Price', 'start_date');
            $this->createDateFromDate('Price', 'end_date');
            $this->request->data['Price']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if($this->request->data['Price']['type_pricing']== 2){
                $this->Price->validate = $this->Price->validatePricingTonnage;
            }
            if($this->request->data['Price']['type_pricing']== 3){

                $this->Price->save($this->request->data['Price']);

                $data = array();
                $this->createDateFromDate('ProductPrice', 'start_date');
                $this->createDateFromDate('ProductPrice', 'end_date');
                $data['ProductPrice']['start_date'] = $this->request->data['ProductPrice']['start_date'];
                $data['ProductPrice']['end_date'] = $this->request->data['ProductPrice']['end_date'];

                $data['ProductPrice']['product_id'] = $this->request->data['ProductPrice']['product_id'];
                $data['ProductPrice']['price_id'] = $id;

                $data['ProductPrice']['price_ht'] = $this->request->data['ProductPrice']['price_ht'];
                if(isset($this->request->data['ProductPrice']['id'])){
                    $data['ProductPrice']['id'] = $this->request->data['ProductPrice']['id'];
                    $productPriceId =  $this->request->data['ProductPrice']['id'];
                }else {
                    $this->ProductPrice->create();
                    $productPriceId = $this->ProductPrice->getInsertID();
                }

                $this->ProductPrice->save($data);
                if(isset( $this->request->data['ProductPriceFactor'])){
                    $productPriceFactors = $this->request->data['ProductPriceFactor'];
                }
                if(isset($productPriceFactors) && !empty($productPriceFactors)){

                    foreach ($productPriceFactors as $productPriceFactor){
                        $data2 = array();
                        $data2['ProductPriceFactor']['product_price_id'] = $productPriceId;
                        $data2['ProductPriceFactor']['factor_id'] = $productPriceFactor['factor_id'];
                        $data2['ProductPriceFactor']['factor_value'] = $productPriceFactor['factor_value'];
                        if(isset($productPriceFactor['id'])){
                            $data2['ProductPriceFactor']['id'] = $productPriceFactor['id'];
                        }else {
                            $this->ProductPriceFactor->deleteAll(array('ProductPriceFactor.product_price_id' => $productPriceId, 'ProductPriceFactor.factor_id' => $productPriceFactor['factor_id']), false);

                            $this->ProductPriceFactor->create();
                        }

                        $this->ProductPriceFactor->save($data2);
                    }
                }else {
                    $this->ProductPriceFactor->deleteAll(array('ProductPriceFactor.product_price_id' => $productPriceId), false);

                }

                $this->Flash->success(__('The price has been saved.'));
                $this->redirect(array('action' => 'index'));


            }else {
                if ($this->Price->save($this->request->data)) {

                    $this->savePriceRideCategory($this->request->data['PriceRideCategory'], $id);
                    if (!empty($this->request->data['Promotion'])) {
                        $this->savePromotions($this->request->data['Promotion'], $id);
                    }
                    $this->Flash->success(__('The price has been saved.'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->error(__('The price could not be saved. Please, try again.'));
                }
            }

        } else {
            $options = array('conditions' => array('Price.' . $this->Price->primaryKey => $id));
            $this->request->data = $this->Price->find('first', $options);
            switch ($this->request->data['Price']['type_pricing']){
                case 1 :
                    $this->Price->DetailRide->virtualFields = array('cnames' => "CONCAT(DepartureDestination.name, ' - ', ArrivalDestination.name, ' - ',CarType.name)");
                    $detailRides = $this->Price->DetailRide->find('list', array(
                        'order' => 'DetailRide.wording ASC',
                        'conditions'=>array('DetailRide.id'=>$this->request->data['Price']['detail_ride_id']),
                        'recursive' => -1,
                        'fields' => 'cnames',
                        'joins' => array(
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
                            )
                        )
                    ));
                    $this->set(compact('detailRides'));
                    break;
                case 2 :
                    $tonnages = $this->Tonnage->getTonnages();
                    $this->set(compact('tonnages'));
                    break;
                case 3 :
                    $products = $this->Product->getProducts();
                    $this->set(compact('products'));
                    break;
            }

			$suppliers = $this->Supplier->getSuppliersByParams(1, 1, null, array(2, 3),null, $this->request->data['Price']['supplier_id']);
            $this->set(compact('suppliers'));
        }
        $supplierCategories = $this->SupplierCategory->getSupplierCategoriesByType(SupplierCategoriesEnum::CUSTOMER_TYPE);
        if($this->request->data['Price']['type_pricing'] !=3){
            $priceRideCategories = $this->Price->PriceRideCategory->find('all',
                array('conditions' => array('PriceRideCategory.price_id' => $id)));
            $nbPriceRideCategories = $this->Price->PriceRideCategory->find('count',
                array('conditions' => array('detail_ride_id' => $id)));
        }else {

            $productPrice = $this->ProductPrice->find('first',array(
                'recursive'=>-1,
                'conditions'=>array('ProductPrice.price_id'=>$id),
                'fields'=>array('ProductPrice.id','ProductPrice.price_ht','ProductPrice.product_id',
                    'ProductPrice.start_date','ProductPrice.end_date')
            ));
            $productId = $productPrice['ProductPrice']['product_id'];
            $productPriceFactors = $this->ProductPriceFactor->find('all',array(
                'conditions'=>array('ProductPrice.price_id'=>$id),
                'recursive'=>-1,
                'order'=>array('ProductPriceFactor.factor_id'),
                'fields'=>array('ProductPriceFactor.id','ProductPriceFactor.factor_id',
                    'ProductPriceFactor.factor_value',
                    'Factor.name'),
                'joins'=>array(
                    array(
                        'table' => 'product_prices',
                        'type' => 'left',
                        'alias' => 'ProductPrice',
                        'conditions' => array('ProductPrice.id = ProductPriceFactor.product_price_id')
                    ),
                    array(
                        'table' => 'factors',
                        'type' => 'left',
                        'alias' => 'Factor',
                        'conditions' => array('Factor.id = ProductPriceFactor.factor_id')
                    ),
                )
            ));

            if(!empty($productPriceFactors)){
                $factorIds = array();
                foreach ($productPriceFactors as $productPriceFactor){
                    $factorIds[]  =$productPriceFactor['ProductPriceFactor']['factor_id'];
                }
            }
            $product = $this->Product->getProductById($productId);
            $productTypeId = $product['Product']['product_type_id'];
            $factors = $this->ProductTypeFactor->find(
                'all',
                array(
                    'recursive'=>-1,
                    'order'=>array('Factor.id'),
                    'fields'=> array('Factor.id','Factor.name'),
                    'conditions' =>array('ProductTypeFactor.product_type_id'=>$productTypeId,
                        'Factor.id !='=>$factorIds) ,
                    'joins' => array(

                        array(
                            'table' => 'factors',
                            'type' => 'left',
                            'alias' => 'Factor',
                            'conditions' => array('ProductTypeFactor.factor_id = Factor.id')
                        ),

                    ))
            );
            $this->set(compact('productPrice','productPriceFactors','factors'));

        }

        $promotions = $this->Promotion->getPromotionsByPriceId($id);
        $useRideCategory = $this->useRideCategory();
        $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
        $services = $this->Service->getServices('list');
        $this->set(compact( 'suppliers', 'supplierCategories', 'priceRideCategories',
            'nbPriceRideCategories', 'useRideCategory', 'promotions','paramPriceNight','services'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null)
    {
        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::tarif_trajet, $user_id, ActionsEnum::delete,
            "Prices", $id, "Price", null);
        $this->Price->id = $id;
        if (!$this->Price->exists()) {
            throw new NotFoundException(__('Invalid Price'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Price->delete()) {
            $this->Flash->success(__('The price has been deleted.'));
        } else {
            $this->Flash->success(__('The price could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteprices()
    {

        $hasSaleModule = $this->hasSaleModule();
        $hasStandardSaleModule = $this->hasStandardSaleModule();
        if ($hasSaleModule == 0 && $hasStandardSaleModule == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::tarif_trajet, $user_id, ActionsEnum::delete,
            "Prices", $id, "Price", null);
        $this->Price->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Price->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }

        /* }else{
             echo json_encode(array("response" => "false"));
         }*/
    }

    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $this->loadModel('PriceRideCategory');
        $priceRideCategories = $this->PriceRideCategory->find('all',
            array("conditions" => array("PriceRideCategory.price_id" => $id)));
        if (!empty($priceRideCategories)) {
            $this->PriceRideCategory->deleteAll(array('PriceRideCategory.price_id' => $id), false);
        }
        $this->loadModel('Promotion');
        $promotions = $this->Promotion->find('all',
            array("conditions" => array("Promotion.price_id" => $id)));
        if (!empty($promotions)) {
            $this->Promotion->deleteAll(array('Promotion.price_id' => $id), false);
        }
    }

    function export()
    {
        $this->setTimeActif();
        $prices = $this->Price->find('all', array(
            'order' => 'Price.name asc',
            'recursive' => -1
        ));
        $this->set('models', $prices);
    }

    function getSuppliersByCategory($category_id = null)
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        $suppliers = $this->Supplier->getSuppliersByParams(1, 1, array($category_id));
        $this->set('suppliers', $suppliers);
    }

    function getPrice($item = 0, $rideId = null, $categoryId = null, $clientId = null)
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        $this->set('item', $item);
        if ($rideId != null && $clientId != null) {
            $price = $this->Price->getPriceByParams($rideId, $clientId, $categoryId);

        } elseif ($rideId != null && $clientId == null && $categoryId != null) {

            $price = $this->Price->getPriceByParams($rideId, $clientId, $categoryId);
        } elseif ($rideId != null && $clientId == null && $categoryId == null) {
            $price = $this->Price->getPriceByParams($rideId, $clientId, $categoryId);
        }

        if (!empty($price)) {

            $priceHt = $price['PriceRideCategory']['price_ht'];
            $priceHtNight = $price['PriceRideCategory']['price_ht_night'];
            $priceId = $price['Price']['id'];
            $priceReturn = $price['PriceRideCategory']['price_return'];
            $theoreticalAmountCharges = $price['PriceRideCategory']['theoretical_amount_charges'];
            $pourcentage = $price['PriceRideCategory']['pourcentage_price_return'];
            $startDate = $price['PriceRideCategory']['start_date'];
            $endDate = $price['PriceRideCategory']['end_date'];
            $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
            $this->set(compact('priceHt', 'priceHtNight', 'priceReturn',
                'pourcentage', 'startDate', 'endDate','paramPriceNight','theoreticalAmountCharges'));

            return $priceId;
        } else {
            return null;
        }
    }

    /*
     * get an other div to add price
     */
    public function getDivPrice($item = null)
    {
        $this->layout = 'ajax';
        $rideCategories = $this->TransportBill->RideCategory->find('list', array(
            'order' => 'RideCategory.name ASC',
            'recursive' => -1,
            'conditions'=>array('RideCategory.id !='=>0),
            'fields' => 'name'
        ));
        $this->set('rideCategories', $rideCategories);
        $item++;
        $paramPriceNight = $this->Parameter->getCodesParameterVal('param_price_night');
        $this->set(compact('item', 'paramPriceNight'));
    }


    private function savePriceRideCategory($prices = null, $priceId = null)
    {
        $this->loadModel('PriceRideCategory');
        $this->PriceRideCategory->deleteAll(array('PriceRideCategory.price_id' => $priceId));

        foreach ($prices as $price) {


            $this->PriceRideCategory->create();
            $data['PriceRideCategory']['price_id'] = $priceId;
            if (isset($price['ride_category_id'] )&& ($price['ride_category_id'] > 0)) {
                $data['PriceRideCategory']['ride_category_id'] = $price['ride_category_id'];
            } else {
                $data['PriceRideCategory']['ride_category_id'] = 0;
            }
            $this->request->data['PriceRideCategory']['start_date'] = $price['start_date'];
            $this->createDateFromDate('PriceRideCategory', 'start_date');
            $data['PriceRideCategory']['start_date'] = $this->request->data['PriceRideCategory']['start_date'];
            $this->request->data['PriceRideCategory']['end_date'] = $price['end_date'];
            $this->createDateFromDate('PriceRideCategory', 'end_date');
            $data['PriceRideCategory']['end_date'] = $this->request->data['PriceRideCategory']['end_date'];

            $data['PriceRideCategory']['price_ht'] = $price['price_ht'];
            $data['PriceRideCategory']['price_ht_night'] = $price['price_ht_night'];
            $data['PriceRideCategory']['price_return'] = $price['price_return'];
            $data['PriceRideCategory']['pourcentage_price_return'] = $price['pourcentage_price_return'];
            $data['PriceRideCategory']['theoretical_amount_charges'] = $price['theoretical_amount_charges'];
            $this->PriceRideCategory->save($data);
        }

    }


    private function savePromotions($promotions = null, $priceId = null)
    {
        $this->loadModel('Promotion');

        foreach ($promotions as $promotion) {
            if (!empty($promotion['promotion_pourcentage']) &&
                !empty($promotion['promotion_val']) &&
                !empty($promotion['start_date']) &&
                !empty($promotion['end_date'])
            ) {

                if (!empty($promotion['id'])) {
                    $data['Promotion']['id'] = $promotion['id'];
                } else {
                    $this->Promotion->create();
                }

                $data['Promotion']['price_id'] = $priceId;
                $this->request->data['Promotion']['start_date'] = $promotion['start_date'];
                $this->createDateFromDate('Promotion', 'start_date');
                $data['Promotion']['start_date'] = $this->request->data['Promotion']['start_date'];
                $this->request->data['Promotion']['end_date'] = $promotion['end_date'];
                $this->createDateFromDate('Promotion', 'end_date');
                $data['Promotion']['end_date'] = $this->request->data['Promotion']['end_date'];
                $data['Promotion']['promotion_val'] = $promotion['promotion_val'];
                $data['Promotion']['promotion_return'] = $promotion['promotion_return'];
                $data['Promotion']['promotion_pourcentage'] = $promotion['promotion_pourcentage'];
                $this->Promotion->save($data);
            }
        }
    }


    public function import()
    {
        if (!empty($this->request->data['Price']['file_csv']['tmp_name'])) {

            if (is_uploaded_file($this->request->data['Price']['file_csv']['tmp_name'])) {
                $fichier = $this->request->data['Price']['file_csv']['name'];
                $ext = substr(strtolower(strrchr($fichier, '.')), 1);
                if ($ext == 'csv') {
                    if ($fichier) {
                        $fp = fopen($this->request->data['Price']['file_csv']['tmp_name'], "r");
                    } else {
                        echo('fichier introuvable');
                        exit();
                    }
                    $cpt = 0;
                    while (!feof($fp)) {
                        $ligne = fgets($fp, 4096);
                        if (count(explode(";", $ligne)) > 1) {
                            $liste = explode(";", $ligne);
                        } else {
                            $liste = explode(",", $ligne);
                        }
                        filter_input(INPUT_POST, 'file_csv');
                        $liste[0] = (isset($liste[0])) ? $liste[0] : null;
                        $liste[1] = (isset($liste[1])) ? $liste[1] : null;
                        $liste[2] = (isset($liste[2])) ? $liste[2] : null;
                        $liste[3] = (isset($liste[3])) ? $liste[3] : null;
                        $liste[4] = (isset($liste[4])) ? $liste[4] : null;
                        $code = $liste[0];
                        $detailRide = $liste[1];
                        $client = $liste[2];
                        $price_ht = $liste[3];
                        $pourcentage_price_return = $liste[4];
                        $price_return = ($price_ht * $pourcentage_price_return) / 100;
                        $client = $this->getClientId($client);
                        $detailRide = $this->getDetailRideId($detailRide);
                        if ($cpt > 0) {
                            if ($detailRide > 0 && $client > 0) {
                                $this->Price->create();
                                if (!empty($code)) {
                                    $this->request->data['Price']['wording'] = $code;
                                }
                                $this->request->data['Price']['detail_ride_id'] = $detailRide;
                                $this->request->data['Price']['supplier_id'] = $client;
                                $this->request->data['Price']['user_id'] = $this->Session->read('Auth.User.id');
                                $prices[0]['price_ht'] = $price_ht;
                                $prices[0]['price_ht_night'] = 0;
                                $prices[0]['ride_category_id'] = 0;
                                $prices[0]['price_return'] = $price_return;
                                $prices[0]['pourcentage_price_return'] = $pourcentage_price_return;
                                if ($this->Price->save($this->request->data)) {
                                    $priceId = $this->Price->getInsertID();
                                    $this->savePriceRideCategory($prices, $priceId);
                                }
                            }
                        }
                        $cpt++;
                    }
                    fclose($fp);
                    echo json_encode(array("response" => "true"));
                    $this->Flash->success(__('The file has been successfully imported'));

                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->error(__('The file must be in csv format'));
                    $this->redirect(array('action' => 'index'));

                }

            }

        }

    }

    public function getClientId($clientNameImport)
    {
        $clientNameImport = trim($clientNameImport);
        $clientNameImport = strtolower($clientNameImport);
        $supplierId = 0;
        $suppliers = $this->Supplier->find('all', array('recursive' => -1));
        foreach ($suppliers as $supplier) {
            $supplierName = strtolower($supplier['Supplier']['name']);
            $supplierName = trim($supplierName);
            if ($clientNameImport == $supplierName) {
                $supplierId = $supplier['Supplier']['id'];
            }
        }
        return $supplierId;
    }

    public function getDetailRideId($detailRideNameImport)
    {
        $detailRideNameImport = trim($detailRideNameImport);
        $detailRideNameImport = strtolower($detailRideNameImport);

        $detailRideId = 0;
        $detailRides = $this->DetailRide->find('all', array('recursive' => -1));
        foreach ($detailRides as $detailRide) {
            $detailRideName = strtolower($detailRide['DetailRide']['wording']);
            $detailRideName = trim($detailRideName);
            if ($detailRideNameImport == $detailRideName) {
                $detailRideId = $detailRide['DetailRide']['id'];
            }
        }
        return $detailRideId;
    }


    public function liste($id = null, $keyword = null)
    {
        $keyword = str_replace('espace', ' ', $keyword);
        $keyword = str_replace('slash', '/', $keyword);
        $keyword = strtolower($keyword);
        $this->layout = 'ajax';
        $limit = $this->getLimit();
        $useRideCategory = $this->useRideCategory();
        if ($useRideCategory == 2) {

            switch ($id) {
                case 2 :
                    $conditions = array("LOWER(Price.wording) LIKE" => "%$keyword%");
                    break;
                case 3 :
                    $conditions = array(
                        'OR' => array(
                            "LOWER(DepartureDestination.name) LIKE" => "%$keyword%",
                            "LOWER(ArrivalDestination.name) LIKE" => "%$keyword%",
                        )
                    );
                    break;
                case 4 :
                    $conditions = array("LOWER(CarType.name) LIKE" => "%$keyword%",);
                    break;

                case 5 :
                    $conditions = array("LOWER(SupplierCategory.name) LIKE" => "%$keyword%");
                    break;

                case 6 :
                    $conditions = array("LOWER(Supplier.name) LIKE" => "%$keyword%");
                    break;

                case 7 :
                    $conditions = array("LOWER(RideCategory.name) LIKE" => "%$keyword%");
                    break;

                case 8 :
                    $conditions = array("LOWER(PriceRideCategory.price_ht ) LIKE" => "%$keyword%");
                    break;

                case 9 :
                    $conditions = array("LOWER(PriceRideCategory.price_ht_night) LIKE" => "%$keyword%");
                    break;

                case 10 :
                    $conditions = array("LOWER(PriceRideCategory.price_return) LIKE" => "%$keyword%");
                    break;


                default:
                    $conditions = array("LOWER(Price.wording) LIKE" => "%$keyword%");
            }

        } else {

            switch ($id) {
                case 2 :
                    $conditions = array("LOWER(Price.wording) LIKE" => "%$keyword%");
                    break;
                case 3 :
                    $conditions = array(
                        'OR' => array(
                            "LOWER(DepartureDestination.name) LIKE" => "%$keyword%",
                            "LOWER(ArrivalDestination.name) LIKE" => "%$keyword%",
                        )
                    );
                    break;
                case 4 :
                    $conditions = array("LOWER(CarType.name) LIKE" => "%$keyword%",);
                    break;

                case 5 :
                    $conditions = array("LOWER(SupplierCategory.name) LIKE" => "%$keyword%");
                    break;

                case 6 :
                    $conditions = array("LOWER(Supplier.name) LIKE" => "%$keyword%");
                    break;

                case 7 :
                    $conditions = array("LOWER(PriceRideCategory.price_ht ) LIKE" => "%$keyword%");
                    break;

                case 8 :
                    $conditions = array("LOWER(PriceRideCategory.price_ht_night) LIKE" => "%$keyword%");
                    break;

                case 9 :
                    $conditions = array("LOWER(PriceRideCategory.price_return) LIKE" => "%$keyword%");
                    break;


                default:
                    $conditions = array("LOWER(Price.wording) LIKE" => "%$keyword%");
            }


        }

        $this->paginate = array(

            'conditions' => $conditions,
            'limit'=>$limit,
            'order' => array('Price.id' => 'DESC'),
            'paramType' => 'querystring',
            'recursive' => -1,
            'fields' => array(
                'CarType.name',
                'DepartureDestination.name',
                'ArrivalDestination.name',
                'Price.id',
                'Price.wording',
                'SupplierCategory.name',
                'Supplier.name',
                'RideCategory.name',
                'PriceRideCategory.price_ht',
                'PriceRideCategory.price_return',
                'PriceRideCategory.theoretical_amount_charges',
                'PriceRideCategory.price_ht_night',
                'PriceRideCategory.start_date',
                'PriceRideCategory.end_date',

            ),
            'joins' => array(

                array(
                    'table' => 'detail_rides',
                    'type' => 'left',
                    'alias' => 'DetailRide',
                    'conditions' => array('Price.detail_ride_id = DetailRide.id')
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
                    'conditions' => array('Price.supplier_id = Supplier.id')
                ),
                array(
                    'table' => 'supplier_categories',
                    'type' => 'left',
                    'alias' => 'SupplierCategory',
                    'conditions' => array('Price.supplier_category_id = SupplierCategory.id')
                ),
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('DetailRide.car_type_id = CarType.id')
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
                array(
                    'table' => 'price_ride_categories',
                    'type' => 'left',
                    'alias' => 'PriceRideCategory',
                    'conditions' => array('Price.id = PriceRideCategory.price_id')
                ),
                array(
                    'table' => 'ride_categories',
                    'type' => 'left',
                    'alias' => 'RideCategory',
                    'conditions' => array('RideCategory.id = PriceRideCategory.ride_category_id')
                )

            )
        );
        $prices = $this->Paginator->paginate('Price');

        $this->set('prices', $prices);
        $separatorAmount = $this->getSeparatorAmount();

        $this->set(compact( 'separatorAmount', 'useRideCategory'));


    }

    /** voir la promotion du prix $id
     * @param null $id
     */
    public function viewPromotions($id = null)
    {
        $this->layout = 'ajax';
        $promotions = $this->Promotion->getPromotionsByPriceId($id);

        $this->set('promotions', $promotions);
    }

    /** add le div d'une promotion (function with view)
     * @param null $item
     */
    public function addPromotion ($item = null ){
        $this->layout = 'ajax';
        $this->set('j',$item);
    }

    public function getRides(){
        $this->layout = 'ajax';
        $this->Price->validate = $this->Price->validate;
    }

    public function getTonnages(){
        $this->layout = 'ajax';
        $this->Price->validate = $this->Price->validatePricingTonnage;
        $tonnages = $this->Tonnage->getTonnages();
        $this->set(compact('tonnages'));
    }

    public function getOtherProducts(){
        $this->layout = 'ajax';
        //$this->ProductPrice->validate = $this->ProductPrice->validate;
        $products = $this->Product->getProducts();
        $this->set(compact('products'));
    }

    public function getFactors($productId = null){
        $this->layout = 'ajax';
        $product = $this->Product->getProductById($productId);
        $productTypeId = $product['Product']['product_type_id'];
        $this->set('productTypeId', $productTypeId);
        $factors = $this->ProductTypeFactor->getInputFactorsByProductTypeId($productTypeId);
        $selectFactors = $this->ProductTypeFactor->getSelectFactorsByProductTypeId($productTypeId);
        if(!empty($selectFactors)){
            $i=0;
            foreach ($selectFactors as $factor){
                $this->loadModel($factor['Factor']['name']);
                $model = $factor['Factor']['name'];
                $selectFactors[$i]['Factor']['options'] = $this->$model->find('list');
                $i  ++;
            }
        }
        $this->set(compact('factors','selectFactors'));
    }

    public function getUnitPriceDiv(){
        $this->layout = 'ajax';

    }





}
