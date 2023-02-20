<?php
App::uses('AppController', 'Controller');

/**
 * Suppliers Controller
 *
 * @property Supplier $Supplier
 * @property SupplierCategory $SupplierCategory
 * @property Tva $Tva
 * @property Company $Company
 * @property Service $Service
 * @property Profile $Profile
 * @property User $User
 * @property CodeLog $CodeLog
 * @property Payment $Payment
 * @property LegalForm $LegalForm
 * @property FinalSupplierInitialSupplier $FinalSupplierInitialSupplier
 * @property SupplierAddress $SupplierAddress
 * @property SupplierAttachmentType $SupplierAttachmentType
 * @property AttachmentType $AttachmentType
 * @property SupplierContact $SupplierContact
 * @property TransportBillDetailRides $TransportBillDetailRides
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class SuppliersController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'RequestHandler');
    public $uses = array(
        'Supplier',
        'Company',
        'LegalForm',
        'Service',
        'SupplierCategory',
        'TransportBillDetailRides',
        'AttachmentType',
        'SupplierAttachmentType',
        'SupplierContact',
        'SupplierAddress',
        'Payment',
        'CodeLog',
        'Bill',
        'FinalSupplierInitialSupplier'
    );
    var $helpers = array('Xls');

    /**
     * index method
     *
     * @param int|null $params
     * @param int|null $orderType
     *
     * @return array
     */
    public function getOrder($params = null, $orderType = null)
    {
       if($orderType == null){
           $orderType = 'DESC';
       }
        if (isset($params) && is_numeric($params)) {
            switch ($params) {
                case 1 :
                    $order = array('Supplier.code' => $orderType);
                    break;
                case 2 :
                    $order = array('Supplier.id' => $orderType);
                    break;
                case 3 :
                    $order = array('Supplier.name' => $orderType);
                    break;

                    break;
                default :
                    $order = array('Supplier.id' => $orderType);
            }
            return $order;
        } else {
            $order = array('Supplier.id' => $orderType);
            return $order;
        }
    }

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->setTimeActif();
        $userId = $this->Auth->user('id');
        $limit = isset($this->params['pass']['1']) ? $this->getLimit($this->params['pass']['1']) : $this->getLimit();
        $order = isset($this->params['pass']['2']) ? $this->getOrder($this->params['pass']['2'], $this->params['pass']['3']) : $this->getOrder();
        $type = $this->params['pass']['0'];
        if ($type == 0) {
            $stock = $this->hasModuleStock();
            if ($stock == 0) {
                $this->redirect('/');
            }
            $result = $this->verifyUserPermission(SectionsEnum::fournisseur, $userId, ActionsEnum::view,
                "Suppliers", null, "Supplier", $type);
        } else {
            $hasSaleModule = $this->hasSaleModule();
            $planning = $this->hasModulePlanification();
            $hasStandardSaleModule = $this->hasStandardSaleModule();
            if ($hasSaleModule == 0 && $hasStandardSaleModule == 0 && $planning == 0) {
                $this->redirect('/');
            }
            $result = $this->verifyUserPermission(SectionsEnum::client, $userId, ActionsEnum::view,
                "Suppliers", null, "Supplier", $type);
        }
        $profileId = $this->Auth->user('profile_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        $this->set(compact('profileId'));
        if ($profileId == ProfilesEnum::client) {
            $supplierId = $this->Auth->user('supplier_id');

            $this->set(compact('supplierId'));
            switch ($result) {
                case 1 :
                    $conditions = array(
                        'Supplier.type ' => $type,
                        'Supplier.active' => 1,
                        'FinalSupplierInitialSupplier.initial_supplier_id' => $supplierId
                    );
                    break;
                case 2 :
                    $conditions = array(
                        'Supplier.type ' => $type,
                        'Supplier.active' => 1,
                        'OR' => array(
                            'Supplier.user_id ' => $userId,
                            'FinalSupplierInitialSupplier.initial_supplier_id' => $supplierId
                        )

                    );
                    break;
                case 3 :
                    $conditions = array(
                        'Supplier.type ' => $type,
                        'Supplier.active' => 1,
                        'OR' => array(
                            'Supplier.user_id !=' => $userId,
                            'FinalSupplierInitialSupplier.initial_supplier_id' => $supplierId
                        )

                    );

                    break;
                default:
                    $conditions = array(
                        'Supplier.type ' => $type,
                        'Supplier.active' => 1,
                        'FinalSupplierInitialSupplier.initial_supplier_id' => $supplierId
                    );

            }
            $this->paginate = array(
                'recursive' => -1,
                'limit' => $limit,
                'order' => $order,
                'conditions' => $conditions,
                'paramType' => 'querystring',
                'fields' => array(
                    'Supplier.id',
                    'Supplier.code',
                    'Supplier.name',
                    'Supplier.adress',
                    'Supplier.tel',
                    'Supplier.balance',
                    'Supplier.active',
                    'Supplier.type',
                    'SupplierCategory.name',

                ),
                'joins' => array(
                    array(
                        'table' => 'final_supplier_initial_suppliers',
                        'type' => 'left',
                        'alias' => 'FinalSupplierInitialSupplier',
                        'conditions' => array('FinalSupplierInitialSupplier.final_supplier_id = Supplier.id')
                    ),
                    array(
                        'table' => 'supplier_categories',
                        'type' => 'left',
                        'alias' => 'SupplierCategory',
                        'conditions' => array('SupplierCategory.id = Supplier.supplier_category_id')
                    ),
                ),
            );

            $this->set('suppliers', $this->Paginator->paginate());


        } else {
            switch ($result) {
                case 1 :
                    $conditions = array(
                        'Supplier.type ' => $type,
                        'Supplier.active' => 1,
                        'Supplier.final_customer' => array(2, 3)
                    );
                    break;
                case 2 :
                    $conditions = array(
                        'Supplier.user_id ' => $userId,
                        'Supplier.type ' => $type,
                        'Supplier.active' => 1,
                        'Supplier.final_customer' => array(2, 3)
                    );
                    break;
                case 3 :
                    $conditions = array(
                        'Supplier.user_id !=' => $userId,
                        'Supplier.type ' => $type,
                        'Supplier.active' => 1,
                        'Supplier.final_customer' => array(2, 3)
                    );

                    break;
                default:
                    $conditions = array(
                        'Supplier.type ' => $type,
                        'Supplier.active' => 1,
                        'Supplier.final_customer' => array(2, 3)
                    );

            }
            $this->paginate = array(
                'limit' => $limit,
                'order' => $order,
                'conditions' => $conditions,
                'paramType' => 'querystring'
            );
            $this->Supplier->recursive = 0;
            $this->set('suppliers', $this->Paginator->paginate());
        }


        $separatorAmount = $this->getSeparatorAmount();
        $users = $this->User->getUsers();
        $isSuperAdmin = $this->isSuperAdmin();
        $supplierCategories = $this->SupplierCategory->getSupplierCategoriesByType($type);
        $this->set(compact('limit', 'type', 'order', 'separatorAmount', 'users', 'isSuperAdmin', 'supplierCategories'));
    }

    /**
     * indexOffShore method
     *
     * @return void
     */
    public function indexOffShore()
    {
        $offShore = $this->hasModuleOffShore();
        if ($offShore == 0) {
            $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::sous_traitant, $user_id, ActionsEnum::view,
            "Suppliers", null, "Supplier", 0,null,'indexOffShore');
        $limit = isset($this->params['pass']['1']) ? $this->getLimit($this->params['pass']['1']) : $this->getLimit();
        $order = isset($this->params['pass']['2']) ? $this->getOrder($this->params['pass']['2'],$this->params['pass']['3']) : $this->getOrder();
        $type = $this->params['pass']['0'];
        switch ($result) {
            case 1 :
                $conditions = array('Supplier.type ' => $type, 'Supplier.active' => 1);
                break;
            case 2 :
                $conditions = array('Supplier.user_id ' => $user_id, 'Supplier.type ' => $type, 'Supplier.active' => 1);
                break;
            case 3 :
                $conditions = array(
                    'Supplier.user_id !=' => $user_id,
                    'Supplier.type ' => $type,
                    'Supplier.active' => 1
                );

                break;
            default:
                $conditions = array('Supplier.type ' => $type, 'Supplier.active' => 1);
        }
        $conditionOffShore = array('Supplier.supplier_category_id' => SupplierCategoriesEnum::SUBCONTRACTOR);
        if ($conditions != null) {
            $conditions = array_merge($conditions, $conditionOffShore);

        } else {
            $conditions = $conditionOffShore;
        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => $order,
            'conditions' => $conditions,
            'paramType' => 'querystring'
        );


        $this->Supplier->recursive = 0;
        $this->set('suppliers', $this->Paginator->paginate());
        $separatorAmount = $this->getSeparatorAmount();
        $users = $this->User->getUsers();
        $isSuperAdmin = $this->isSuperAdmin();
        $this->set(compact('limit', 'type', 'order', 'separatorAmount', 'users', 'isSuperAdmin'));

    }

    /**
     * search method
     *
     * @return void
     */
    public function search()
    {
        $this->setTimeActif();

        if (
            isset($this->request->data['Suppliers']['type']) || isset($this->request->data['Suppliers']['active'])
            || isset($this->request->data['Suppliers']['supplier_category_id']) || isset($this->request->data['Suppliers']['supplier_id'])
            || isset($this->request->data['keyword']) || isset($this->request->data['Suppliers']['user_id']) ||
            isset($this->request->data['Suppliers']['modified_id']) || isset($this->request->data['Suppliers']['profile_id'])
            || isset($this->request->data['Suppliers']['created']) || isset($this->request->data['Suppliers']['created1'])
            || isset($this->request->data['Suppliers']['modified']) || isset($this->request->data['Suppliers']['modified1'])
        ) {
            $type = $this->request->data['Suppliers']['type'];
            $this->filterUrl();
        }

        $limit = isset($this->params['pass']['1']) ? $this->getLimit($this->params['pass']['1']) : $this->getLimit();
        $order = isset($this->params['pass']['2']) ? $this->getOrder($this->params['pass']['2'],$this->params['pass']['3']) : $this->getOrder();
        if (isset($this->params['named']['keyword']) || isset($this->params['named']['user'])
            || isset($this->params['named']['active']) || isset($this->params['named']['category'])
            || isset($this->params['named']['supplier'])
            || isset($this->params['named']['created']) || isset($this->params['named']['created1'])
            || isset($this->params['named']['profile']) || isset($this->params['named']['supplier'])
            || isset($this->params['named']['modified_id']) || isset($this->params['named']['type'])
            || isset($this->params['named']['modified']) || isset($this->params['named']['modified1'])
        ) {
            $type = $this->params['named']['type'];
            $this->set('type', $type);
            if(isset($this->params['named']['category'])){
                $supplierCategory = $this->params['named']['category'];
            }else {
                $supplierCategory = Null;
            }

            $this->set('supplierCategory', $supplierCategory);
            $user_id = $this->Auth->user('id');
            if ($type == 0) {
                $stock = $this->hasModuleStock();
                if ($stock == 0) {
                    $this->redirect('/');
                }
                $result = $this->verifyUserPermission(SectionsEnum::fournisseur, $user_id, ActionsEnum::view,
                    "Suppliers", null, "Supplier", $type);
            } else {
                $hasSaleModule = $this->hasSaleModule();
                $hasStandardSaleModule = $this->hasStandardSaleModule();
                $planning = $this->hasModulePlanification();
                if ($hasSaleModule == 0 && $hasStandardSaleModule == 0 && $planning == 0) {
                    $this->redirect('/');
                }
                $result = $this->verifyUserPermission(SectionsEnum::client, $user_id, ActionsEnum::view,
                    "Suppliers", null, "Supplier", $type);
            }
            $userId = $this->Auth->user('id');
            $profileId = $this->Auth->user('profile_id');
            $parentId = $this->Profile->getParentProfileByProfileId($profileId);
            if ($parentId != Null) {
                $profileId = $parentId;
            }
            $this->set('profileId', $profileId);
            if ($profileId == ProfilesEnum::client) {
                $supplierId = $this->Auth->user('supplier_id');

                $this->set(compact('supplierId'));
                switch ($result) {
                    case 1 :
                        $generalConditions = array(
                            'Supplier.type ' => $type,
                            'FinalSupplierInitialSupplier.initial_supplier_id' => $supplierId
                        );
                        break;
                    case 2 :
                        $generalConditions = array(
                            'Supplier.type ' => $type,
                            array(
                                'OR' => array(
                                    'Supplier.user_id ' => $userId,
                                    'FinalSupplierInitialSupplier.initial_supplier_id' => $supplierId
                                )
                            )

                        );
                        break;
                    case 3 :
                        $generalConditions = array(
                            'Supplier.type ' => $type,
                            array(
                                'OR' => array(
                                    'Supplier.user_id !=' => $userId,
                                    'FinalSupplierInitialSupplier.initial_supplier_id' => $supplierId
                                )
                            )
                        );

                        break;
                    default:
                        $generalConditions = array(
                            'Supplier.type ' => $type,
                            'FinalSupplierInitialSupplier.initial_supplier_id' => $supplierId
                        );

                }


            } else {
                switch ($result) {
                    case 1 :
                        $generalConditions = array(
                            'Supplier.type ' => $type,
                            //'Supplier.final_customer' => array(2, 3)
                        );
                        break;
                    case 2 :
                        $generalConditions = array(
                            'Supplier.user_id ' => $userId,
                            'Supplier.type ' => $type,
                            //'Supplier.final_customer' => array(2, 3)
                        );
                        break;
                    case 3 :
                        $generalConditions = array(
                            'Supplier.user_id !=' => $userId,
                            'Supplier.type ' => $type,
                            //'Supplier.final_customer' => array(2, 3)
                        );

                        break;
                    default:
                        $generalConditions = array(
                            'Supplier.type ' => $type,
                            //'Supplier.final_customer' => array(2, 3)
                        );
                }
            }
            $conditions = $this->getConds();

            if (isset($this->params['named']['active'])) {
                $conditionActive = array('Supplier.active' => $this->params['named']['active']);
            } else {
                $conditionActive = array('Supplier.active' => 1);
            }

            if (!empty($conditions)) {
                $conditions = array_merge($conditions, $generalConditions);

            } else {
                $conditions = $generalConditions;
            }


            if ($conditions != null) {
                $conditions = array_merge($conditions, $conditionActive);
            } else {
                $conditions = $conditionActive;
            }


            $this->paginate = array(
                'limit' => $limit,
                'order' => $order,
                'conditions' => $conditions,
                'paramType' => 'querystring',
                'recursive' => -1,
                'fields' => array(
                    'Supplier.id',
                    'Supplier.code',
                    'Supplier.name',
                    'Supplier.adress',
                    'Supplier.tel',
                    'Supplier.balance',
                    'Supplier.active',
                    'Supplier.type',
                    'Supplier.active',
                    'SupplierCategory.name',

                ),
                'joins' =>
                    array(
                        array(
                            'table' => 'final_supplier_initial_suppliers',
                            'type' => 'left',
                            'alias' => 'FinalSupplierInitialSupplier',
                            'conditions' => array('FinalSupplierInitialSupplier.final_supplier_id = Supplier.id')
                        ),
                        array(
                            'table' => 'supplier_categories',
                            'type' => 'left',
                            'alias' => 'SupplierCategory',
                            'conditions' => array('SupplierCategory.id = Supplier.supplier_category_id')
                        ),
                    )

            );
            $suppliers = $this->Paginator->paginate('Supplier');

            $this->set('suppliers', $suppliers);
        } else {
            $this->Supplier->recursive = 1;
            $this->set('suppliers', $this->Paginator->paginate());
        }
        $separatorAmount = $this->getSeparatorAmount();
        $isSuperAdmin = $this->isSuperAdmin();
        $supplierCategories = $this->SupplierCategory->getSupplierCategoriesByType($type);
        $this->set(compact('limit', 'type', 'separatorAmount', 'isSuperAdmin', 'order', 'supplierCategories'));
        $this->render();
    }

    private function filterUrl()
    {
        $filter_url['controller'] = $this->request->params['controller'];
        $filter_url['action'] = $this->request->params['action'];
        $filter_url['page'] = 1;
        $filter_url['keyword'] = $this->request->data['keyword'];

        if (isset($this->request->data['Suppliers']['type'])) {

            $filter_url['type'] = $this->request->data['Suppliers']['type'];

        }

        if (isset($this->request->data['Suppliers']['active']) && !empty($this->request->data['Suppliers']['active'])) {
            $filter_url['active'] = $this->request->data['Suppliers']['active'];
        }

        if (isset($this->request->data['Suppliers']['supplier_category_id']) && !empty($this->request->data['Suppliers']['supplier_category_id'])) {
            $filter_url['category'] = $this->request->data['Suppliers']['supplier_category_id'];
        }

        if (isset($this->request->data['Suppliers']['supplier_id']) && !empty($this->request->data['Suppliers']['supplier_id'])) {
            $filter_url['supplier'] = $this->request->data['Suppliers']['supplier_id'];
        }

        if (isset($this->request->data['Suppliers']['user_id']) && !empty($this->request->data['Suppliers']['user_id'])) {
            $filter_url['user'] = $this->request->data['Suppliers']['user_id'];
        }

        if (isset($this->request->data['Suppliers']['profile_id']) && !empty($this->request->data['Suppliers']['profile_id'])) {
            $filter_url['profile'] = $this->request->data['Suppliers']['profile_id'];
        }

        if (isset($this->request->data['Suppliers']['created']) && !empty($this->request->data['Suppliers']['created'])) {
            $filter_url['created'] = str_replace("/", "-", $this->request->data['Suppliers']['created']);
        }
        if (isset($this->request->data['Suppliers']['created1']) && !empty($this->request->data['Suppliers']['created1'])) {
            $filter_url['created1'] = str_replace("/", "-", $this->request->data['Suppliers']['created1']);
        }
        if (isset($this->request->data['Suppliers']['modified_id']) && !empty($this->request->data['Suppliers']['modified_id'])) {
            $filter_url['modified_id'] = $this->request->data['SheetRides']['modified_id'];
        }
        if (isset($this->request->data['Suppliers']['modified']) && !empty($this->request->data['Suppliers']['modified'])) {
            $filter_url['modified'] = str_replace("/", "-", $this->request->data['SheetRides']['modified']);
        }
        if (isset($this->request->data['Suppliers']['modified1']) && !empty($this->request->data['Suppliers']['modified1'])) {
            $filter_url['modified1'] = str_replace("/", "-", $this->request->data['SheetRides']['modified1']);
        }


        return $this->redirect($filter_url);
    }

    private function getConds()
    {
        if (!empty($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $conds = array(
                'OR' => array(
                    "LOWER(Supplier.code) LIKE" => "%$keyword%",
                    "LOWER(Supplier.social_reason) LIKE" => "%$keyword%",
                    "LOWER(Supplier.name) LIKE" => "%$keyword%"
                )
            );

        } else {
            $conds = array();
        }


        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $conds["Supplier.user_id = "] = $this->params['named']['user'];
            $this->request->data['Suppliers']['user_id'] = $this->params['named']['user'];
        }
        if (isset($this->params['named']['type']) && !empty($this->params['named']['type'])) {
            $conds["Supplier.type = "] = $this->params['named']['type'];
            $this->request->data['Suppliers']['type'] = $this->params['named']['type'];
        }

        if (isset($this->params['named']['active']) && !empty($this->params['named']['active'])) {
            $conds["Supplier.active = "] = $this->params['named']['active'];
            $this->request->data['Suppliers']['active'] = $this->params['named']['active'];
        }

        $profileId = $this->Auth->user('profile_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        if ($profileId == ProfilesEnum::client) {
            if (isset($this->params['named']['supplier']) && !empty($this->params['named']['supplier'])) {
                $conds["Supplier.id = "] = $this->params['named']['supplier'];
                $this->request->data['Suppliers']['supplier_id'] = $this->params['named']['supplier'];
            }
        } else {
            if (isset($this->params['named']['supplier']) && !empty($this->params['named']['supplier'])) {
                $conds["FinalSupplierInitialSupplier.initial_supplier_id = "] = $this->params['named']['supplier'];
                $this->request->data['Suppliers']['supplier_id'] = $this->params['named']['supplier'];
            }
        }


        if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
            $conds["Supplier.supplier_category_id = "] = $this->params['named']['category'];
            $this->request->data['Suppliers']['supplier_category_id'] = $this->params['named']['category'];
        }

        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $creat = str_replace("-", "/", $this->params['named']['created']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Supplier.created >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Suppliers']['created'] = $creat;
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $creat = str_replace("-", "/", $this->params['named']['created1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Supplier.created <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Suppliers']['created1'] = $creat;
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $conds["Supplier.modified_id = "] = $this->params['named']['modified_id'];
            $this->request->data['Suppliers']['modified_id'] = $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Supplier.modified >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Suppliers']['modified'] = $creat;
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Supplier.modified <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Suppliers']['modified1'] = $creat;
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
        $this->setTimeActif();


        if (!$this->Supplier->exists($id)) {
            throw new NotFoundException(__('Invalid supplier'));
        }
        $options = array('conditions' => array('Supplier.' . $this->Supplier->primaryKey => $id));
        $supplier = $this->Supplier->find('first', $options);
        $this->set('supplier', $supplier);
        switch ($supplier['Supplier']['final_customer']) {
            case 1:
                $this->paginate = array(
                    'recursive' => -1,
                    'fields' =>
                        array(
                            'InitialSupplier.code',
                            'InitialSupplier.name'
                        ),
                    'order' => 'name ASC',
                    'conditions' =>
                        array(
                            'FinalSupplier.type' => 1,
                            'FinalSupplier.active' => 1,
                            'FinalSupplier.final_customer' => array(1),
                            'FinalSupplierInitialSupplier.final_supplier_id' => $id
                        ),
                    'joins' =>
                        array(
                            array(
                                'table' => 'suppliers',
                                'type' => 'left',
                                'alias' => 'FinalSupplier',
                                'conditions' => array('FinalSupplierInitialSupplier.final_supplier_id = FinalSupplier.id')
                            ),
                            array(
                                'table' => 'suppliers',
                                'type' => 'left',
                                'alias' => 'InitialSupplier',
                                'conditions' => array('FinalSupplierInitialSupplier.initial_supplier_id = InitialSupplier.id')
                            ),
                        )
                );
                $initialSuppliers = $this->Paginator->paginate('FinalSupplierInitialSupplier');

                break;

            case 2:

                $this->paginate = array(
                    'recursive' => -1,
                    'fields' =>
                        array(
                            'FinalSupplier.code',
                            'FinalSupplier.name',
                        ),
                    'order' => 'name ASC',
                    'conditions' =>
                        array(
                            'InitialSupplier.type' => 1,
                            'InitialSupplier.active' => 1,
                            'InitialSupplier.final_customer' => array(2),
                            'FinalSupplierInitialSupplier.initial_supplier_id' => $id
                        ),
                    'joins' =>
                        array(
                            array(
                                'table' => 'suppliers',
                                'type' => 'left',
                                'alias' => 'FinalSupplier',
                                'conditions' => array('FinalSupplierInitialSupplier.final_supplier_id = FinalSupplier.id')
                            ),
                            array(
                                'table' => 'suppliers',
                                'type' => 'left',
                                'alias' => 'InitialSupplier',
                                'conditions' => array('FinalSupplierInitialSupplier.initial_supplier_id = InitialSupplier.id')
                            ),
                        )
                );
                $finalSuppliers = $this->Paginator->paginate('FinalSupplierInitialSupplier');

                break;

            case 3:

                $this->paginate = array(
                    'recursive' => -1,
                    'fields' =>
                        array(
                            'InitialSupplier.code',
                            'InitialSupplier.name',
                        ),
                    'order' => 'name ASC',
                    'conditions' =>
                        array(
                            'FinalSupplier.type' => 1,
                            'FinalSupplier.active' => 1,
                            'FinalSupplier.final_customer' => array(3),
                            'FinalSupplierInitialSupplier.final_supplier_id' => $id
                        ),
                    'joins' =>
                        array(
                            array(
                                'table' => 'suppliers',
                                'type' => 'left',
                                'alias' => 'FinalSupplier',
                                'conditions' => array('FinalSupplierInitialSupplier.final_supplier_id = FinalSupplier.id')
                            ),
                            array(
                                'table' => 'suppliers',
                                'type' => 'left',
                                'alias' => 'InitialSupplier',
                                'conditions' => array('FinalSupplierInitialSupplier.initial_supplier_id = InitialSupplier.id')
                            ),
                        )
                );
                $initialSuppliers = $this->Paginator->paginate('FinalSupplierInitialSupplier');


                $this->paginate = array(
                    'recursive' => -1,
                    'fields' =>
                        array(
                            'FinalSupplier.code',
                            'FinalSupplier.name'
                        ),
                    'order' => 'name ASC',
                    'conditions' =>
                        array(
                            'InitialSupplier.type' => 1,
                            'InitialSupplier.active' => 1,
                            'InitialSupplier.final_customer' => array(3),
                            'FinalSupplierInitialSupplier.initial_supplier_id' => $id
                        ),
                    'joins' =>
                        array(
                            array(
                                'table' => 'suppliers',
                                'type' => 'left',
                                'alias' => 'FinalSupplier',
                                'conditions' => array('FinalSupplierInitialSupplier.final_supplier_id = FinalSupplier.id')
                            ),
                            array(
                                'table' => 'suppliers',
                                'type' => 'left',
                                'alias' => 'InitialSupplier',
                                'conditions' => array('FinalSupplierInitialSupplier.initial_supplier_id = InitialSupplier.id')
                            ),
                        )
                );
                $finalSuppliers = $this->Paginator->paginate('FinalSupplierInitialSupplier');


                break;
        }


        $attachmentTypes = $this->AttachmentType->getAttachmentTypeBySectionId(SectionsEnum::mission, "all");
        $supplierAttachmentTypes = $this->SupplierAttachmentType->find('all',
            array(
                'conditions' => array('SupplierAttachmentType.supplier_id' => $id),
                'order' => 'SupplierAttachmentType.attachment_type_id ASC'
            ));
        $supplierAddresses = $this->SupplierAddress->getAddressBySupplier($id);
        $supplierContacts = $this->SupplierContact->getContactsBySupplier($id);

        $this->set(compact('finalSuppliers', 'attachmentTypes',
            'supplierAttachmentTypes', 'supplierAddresses', 'supplierContacts', 'initialSuppliers'));
    }

    /**
     * add method
     *
     * @param int|null $type
     *
     * @param null|int $supplierId
     * @throws Exception
     */
    public function add($type = null, $supplierId = null)
    {
        if ($type == 1) {
            $hasSaleModule = $this->hasSaleModule();
            $hasStandardSaleModule = $this->hasStandardSaleModule();
            $planning = $this->hasModulePlanification();
            if ($hasSaleModule == 0 && $hasStandardSaleModule == 0 && $planning == 0) {
                $this->redirect('/');
            }
        } else {
            $stock = $this->hasModuleStock();
            if ($stock == 0) {
                $this->redirect('/');
            }
        }
        $this->setTimeActif();
        $userId = $this->Auth->user('id');
        if ($type == 0) {
            //$code = $this->getNextCodeWithPrefix('Supplier', 'supplier');
            $code = $this->getNextCodeByFieldName( 'supplier');

            $this->verifyUserPermission(SectionsEnum::fournisseur, $userId, ActionsEnum::add, "Suppliers", null,
                "Supplier", $type);
        } else {
            $profileId = $this->Auth->user('profile_id');
            $parentId = $this->Profile->getParentProfileByProfileId($profileId);
            if ($parentId != Null) {
                $profileId = $parentId;
            }
            if ($profileId == ProfilesEnum::client) {
                //$code = $this->getNextCodeWithPrefix('Supplier', 'client_final');
                $code = $this->getNextCodeByFieldName( 'client_final');
            } else {
                //$code = $this->getNextCodeWithPrefix('Supplier', 'client_initial');
                $code = $this->getNextCodeByFieldName( 'client_initial');
            }
            $this->verifyUserPermission(SectionsEnum::client, $userId, ActionsEnum::add, "Suppliers", null,
                "Supplier", $type);
        }
        $this->set('code', $code);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $type = $this->request->data['Supplier']['type'];
            $this->redirect(array('action' => 'index', $type));
        }
        if ($this->request->is('post')) {
            $this->Supplier->create();
            $this->request->data['Supplier']['user_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['Supplier']['code'] = trim($this->request->data['Supplier']['code']) ;
            $this->request->data['Supplier']['name'] = trim($this->request->data['Supplier']['name']) ;
            $type = $this->request->data['Supplier']['type'];
            if ($this->Supplier->save($this->request->data)) {
                if($type == SupplierTypesEnum:: suppliers){
                    $nextNumber = $this->Parameter->setNextCodeNumber('supplier');
                } else {
                    if($this->request->data['Supplier']['final_customer']==1){
                        $nextNumber =  $this->Parameter->setNextCodeNumber('client_final');
                    }else {
                        $nextNumber =  $this->Parameter->setNextCodeNumber('client_initial');
                    }
                }
                $supplierId = $this->Supplier->getInsertID();
                $data['CodeLog']['supplier_id'] = $supplierId;
                $data['CodeLog']['date'] =  date('Y-m-d');
                $data['CodeLog']['old_code'] =  $code;
                $data['CodeLog']['new_code'] =  $nextNumber;
                $data['CodeLog']['user_id'] = $this->Session->read('Auth.User.id');
                $this->CodeLog->insertCodeLog($data);
                if ($type == SupplierTypesEnum::customer) {

                    /* cette fonction pour ajouter les clients initial du client final ajouté */
                    if (!empty($this->request->data['FinalSupplierInitialSupplier'])) {
                        $finalSupplierInitialSuppliers = $this->request->data['FinalSupplierInitialSupplier'];

                        $this->addFinalSupplierInitialSuppliers($finalSupplierInitialSuppliers, $supplierId);
                    }


                    if (!empty($this->request->data['SupplierAddress'])) {
                        $supplierAddresses = $this->request->data['SupplierAddress'];
                        $this->addSupplierAddresses($supplierAddresses, $supplierId);
                    }

                    if (!empty($this->request->data['SupplierAttachmentType'])) {
                        $this->addSupplierAttachmentTypes($this->request->data['SupplierAttachmentType'], $supplierId);
                    }
                }
                if (!empty($this->request->data['SupplierContact'])) {
                    $supplierId = $this->Supplier->getInsertID();
                    $supplierContacts = $this->request->data['SupplierContact'];
                    $this->addSupplierContacts($supplierContacts, $supplierId);
                }

                if ($type == SupplierTypesEnum::suppliers) {
                    $this->Flash->success(__('The supplier has been saved.'));
                } else {
                    $this->Flash->success(__('The client has been saved.'));
                }

                $this->redirect(array('action' => 'index', $type));
            } else {
                if ($type == SupplierTypesEnum::suppliers) {
                    $this->Flash->error(__('The supplier could not be saved. Please, try again.'));
                } else {
                    $this->Flash->error(__('The client could not be saved. Please, try again.'));

                }

            }
        }

        $profileId = $this->Auth->user('profile_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        $this->set('profileId', $profileId);

        if ($profileId == ProfilesEnum::client) {
            $supplierId = $this->Auth->user('supplier_id');
            $initialSuppliers = $this->Supplier->find('list', array(
                'order' => 'Supplier.name asc',
                'conditions' => array(
                    'Supplier.final_customer' => array(2, 3),
                    'Supplier.type' => 1,
                    'Supplier.id' => $supplierId,

                )
            ));

            $this->set(compact('supplierId', 'initialSuppliers'));
        }
        $supplierCategories = $this->SupplierCategory->getSupplierCategoriesByType($type);
        if ($type == SupplierTypesEnum::customer) {
            $attachmentTypes = $this->AttachmentType->getAttachmentTypeBySectionId(SectionsEnum::mission, "all");
        } else {
            $attachmentTypes = null;
        }
        if (isset($supplierId)) {
            $supplier = $this->Supplier->getSuppliersById($supplierId, 'list');
        }
        $legalForms = $this->LegalForm->find('list');
        $services = $this->Service->getServices('list');
        $this->set(compact('supplierCategories', 'attachmentTypes',
            'supplier', 'supplierId', 'legalForms','services'));

    }

    public function addFinalSupplierInitialSuppliers($finalSupplierInitialSuppliers, $supplierId)
    {
        $initialSuppliers = $finalSupplierInitialSuppliers['initial_supplier_id'];
        $profileId = $this->Auth->user('profile_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        if ($profileId == ProfilesEnum::client) {
            $this->FinalSupplierInitialSupplier->create();
            $supplier = array();
            $supplier['FinalSupplierInitialSupplier']['initial_supplier_id'] = $initialSuppliers;
            $supplier['FinalSupplierInitialSupplier']['final_supplier_id'] = $supplierId;
            $supplier['FinalSupplierInitialSupplier']['user_id'] = $this->Session->read('Auth.User.id');
            $this->FinalSupplierInitialSupplier->save($supplier);
        } else {
            foreach ($initialSuppliers as $initialSupplier) {

                $this->FinalSupplierInitialSupplier->create();
                $supplier = array();
                $supplier['FinalSupplierInitialSupplier']['initial_supplier_id'] = $initialSupplier;
                $supplier['FinalSupplierInitialSupplier']['final_supplier_id'] = $supplierId;
                $supplier['FinalSupplierInitialSupplier']['user_id'] = $this->Session->read('Auth.User.id');
                $this->FinalSupplierInitialSupplier->save($supplier);

            }
        }

    }

    public function getInitialCustomer($initialCustomer = null)
    {
        $this->layout = 'ajax';
        $this->set('initialCustomer', $initialCustomer);
        if ($initialCustomer == 1 || $initialCustomer == 3) {
            $initialSuppliers = $this->Supplier->find('list', array(
                'order' => 'Supplier.name asc',
                'conditions' => array('Supplier.final_customer' => array(2, 3), 'Supplier.type' => 1)
            ));

            $this->set('initialSuppliers', $initialSuppliers);
        }

    }

    public function addSupplierContacts($supplierContacts, $supplierId)
    {
        $this->SupplierContact->deleteAll(array('SupplierContact.supplier_id' => $supplierId), false);
        foreach ($supplierContacts as $supplierContact) {
            if (!empty($supplierContact['contact'])) {
                $this->SupplierContact->create();
                $contact = array();
                $contact['SupplierContact']['contact'] = $supplierContact['contact'];
                $contact['SupplierContact']['function'] = $supplierContact['function'];
                $contact['SupplierContact']['email1'] = trim($supplierContact['email1']);
                $contact['SupplierContact']['email2'] = trim($supplierContact['email2']);
                $contact['SupplierContact']['email3'] = trim($supplierContact['email3']);
                $contact['SupplierContact']['tel'] = $supplierContact['tel'];
                $contact['SupplierContact']['supplier_id'] = $supplierId;
                $this->SupplierContact->save($contact);
            }
        }
    }

    public function addSupplierAddresses($supplierAddresses, $supplierId)
    {
        $this->SupplierAddress->deleteAll(array('SupplierAddress.supplier_id' => $supplierId), false);
        foreach ($supplierAddresses as $supplierAddress) {
            if (!empty($supplierAddress['code']) && !empty($supplierAddress['address'])) {
                $this->SupplierAddress->create();
                $address = array();
                $address['SupplierAddress']['code'] = $supplierAddress['code'];
                $address['SupplierAddress']['address'] = $supplierAddress['address'];
                $address['SupplierAddress']['latitude'] = $supplierAddress['latitude'];
                $address['SupplierAddress']['longitude'] = $supplierAddress['longitude'];
                $address['SupplierAddress']['latlng'] = $supplierAddress['latlng'];
                $address['SupplierAddress']['supplier_id'] = $supplierId;
                $this->SupplierAddress->save($address);
            }
        }
    }

    /**
     * addOffShore method
     *
     * @return void
     */
    public function addOffShore()
    {
        $offShore = $this->hasModuleOffShore();
        if ($offShore == 0) {
            $this->redirect('/');
        }

        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $code = $this->getNextCodeByFieldName( 'supplier');
        $this->set('code', $code);
        $this->verifyUserPermission(SectionsEnum::sous_traitant, $user_id, ActionsEnum::add, "Suppliers",
            null, "Supplier", 0,null,'indexOffShore');
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'indexOffShore', 0));
        }
        if ($this->request->is('post')) {

            if (($this->request->data['Supplier']['latitude'] == '') && ($this->request->data['Supplier']['longitude'] == '')) {
                $this->request->data['Supplier']['adress'] = '';
            }
            $this->Supplier->create();
            $this->request->data['Supplier']['user_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['Supplier']['supplier_category_id'] = SupplierCategoriesEnum::SUBCONTRACTOR;
            if ($this->Supplier->save($this->request->data)) {

                $nextNumber = $this->Parameter->setNextCodeNumber('supplier');
                $supplierId = $this->Supplier->getInsertID();
                $data['CodeLog']['supplier_id'] = $supplierId;
                $data['CodeLog']['date'] =  date('Y-m-d');
                $data['CodeLog']['old_code'] =  $code;
                $data['CodeLog']['new_code'] =  $nextNumber;
                $data['CodeLog']['user_id'] = $this->Session->read('Auth.User.id');
                $this->CodeLog->insertCodeLog($data);

                $this->Flash->success(__('The supplier has been saved.'));
                $this->redirect(array('action' => 'indexOffShore', 0));
            } else {
                $this->Flash->success(__('The supplier could not be saved. Please, try again.'));
            }
        }

    }

    /**
     * @param null $id
     * @param null $type
     * @throws Exception
     */
    public function edit($id = null, $type = null)
    {
        if ($type == 1) {
            $hasSaleModule = $this->hasSaleModule();
            $hasStandardSaleModule = $this->hasStandardSaleModule();
            $planning = $this->hasModulePlanification();
            if ($hasSaleModule == 0 && $hasStandardSaleModule == 0 && $planning == 0) {
                $this->redirect('/');
            }
        } else {
            $stock = $this->hasModuleStock();
            if ($stock == 0) {
                $this->redirect('/');
            }
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');

        if ($type == 0) {
            $code = $this->getNextCodeByFieldName( 'supplier');

            $this->set('code', $code);
            $this->verifyUserPermission(SectionsEnum::fournisseur, $user_id, ActionsEnum::edit, "Suppliers",
                $id, "Supplier", $type);
        } else {
            $profileId = $this->Auth->user('profile_id');
            $parentId = $this->Profile->getParentProfileByProfileId($profileId);
            if ($parentId != Null) {
                $profileId = $parentId;
            }
            if ($profileId == ProfilesEnum::client) {
                $code = $this->getNextCodeByFieldName( 'client_final');
            } else {
                $code = $this->getNextCodeByFieldName( 'client_initial');
            }
            $this->set('code', $code);
            $this->verifyUserPermission(SectionsEnum::client, $user_id, ActionsEnum::edit,
                "Suppliers", $id, "Supplier", $type);
        }
        if (!$this->Supplier->exists($id)) {
            throw new NotFoundException(__('Invalid supplier'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Supplier cancelled.'));
                $type = $this->request->data['Supplier']['type'];
                $this->redirect(array('action' => 'index', $type));
            }
            $this->request->data['Supplier']['code'] = trim($this->request->data['Supplier']['code']) ;
            $this->request->data['Supplier']['name'] = trim($this->request->data['Supplier']['name']) ;
            $this->request->data['Supplier']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            $type = $this->request->data['Supplier']['type'];
            if ($this->Supplier->save($this->request->data)) {
                if ($type == SupplierTypesEnum::customer) {
                    $this->FinalSupplierInitialSupplier->deleteAll(array('FinalSupplierInitialSupplier.final_supplier_id' => $id),
                        false);
                    /* cette fonction pour ajouter les clients initial du client final ajouté */
                    if (!empty($this->request->data['FinalSupplierInitialSupplier'])) {
                        $finalSupplierInitialSuppliers = $this->request->data['FinalSupplierInitialSupplier'];
                        $this->addFinalSupplierInitialSuppliers($finalSupplierInitialSuppliers, $id);
                    }
                    if (!empty($this->request->data['SupplierAddress'])) {
                        $supplierAddresses = $this->request->data['SupplierAddress'];
                        $this->addSupplierAddresses($supplierAddresses, $id);
                    }

                    if (!empty($this->request->data['SupplierAttachmentType'])) {
                        $this->addSupplierAttachmentTypes($this->request->data['SupplierAttachmentType'], $id);
                    }

                }

                if (!empty($this->request->data['SupplierContact'])) {
                    $supplierContacts = $this->request->data['SupplierContact'];
                    $this->addSupplierContacts($supplierContacts, $id);
                }
                if ($type == SupplierTypesEnum::suppliers) {
                    $this->Flash->success(__('The supplier has been saved.'));
                } else {

                    $this->Flash->success(__('The client has been saved.'));
                }

                $this->redirect(array('action' => 'index', $type));
            } else {
                if ($type == SupplierTypesEnum::suppliers) {
                    $this->Flash->error(__('The supplier could not be saved. Please, try again.'));
                } else {
                    $this->Flash->error(__('The client could not be saved. Please, try again.'));

                }
            }
        } else {
            $options = array('conditions' => array('Supplier.' . $this->Supplier->primaryKey => $id));
            $this->request->data = $this->Supplier->find('first', $options);

            $profileId = $this->Auth->user('profile_id');
            $parentId = $this->Profile->getParentProfileByProfileId($profileId);
            if ($parentId != Null) {
                $profileId = $parentId;
            }
            $this->set('profileId', $profileId);

            if ($profileId == ProfilesEnum::client) {
                $supplierId = $this->Auth->user('supplier_id');
                $initialSuppliers = $this->Supplier->find('list', array(
                    'order' => 'Supplier.name asc',
                    'conditions' => array(
                        'Supplier.final_customer' => array(2, 3),
                        'Supplier.type' => 1,
                        'Supplier.id' => $supplierId,
                    )
                ));

                $this->set(compact('supplierId', 'initialSuppliers'));
            }
            $type = $this->request->data['Supplier']['type'];

            if ($type == SupplierTypesEnum::customer) {
                if ($this->request->data['Supplier']['final_customer'] == 1 || $this->request->data['Supplier']['final_customer'] == 3) {
                    $initialSuppliers = $this->Supplier->find('list', array(
                        'order' => 'Supplier.name asc',
                        'conditions' => array('Supplier.final_customer' => 2, 'Supplier.type' => 1)
                    ));
                    $finalSupplierInitialSuppliers = $this->FinalSupplierInitialSupplier->find('list', array(
                        'fields' => array('FinalSupplierInitialSupplier.initial_supplier_id'),
                        'conditions' => array('FinalSupplierInitialSupplier.final_supplier_id' => $id)
                    ));
                    $this->set(compact('initialSuppliers', 'finalSupplierInitialSuppliers'));
                }

                $supplierCategories = $this->SupplierCategory->getSupplierCategoriesByType($type);
                $attachmentTypes = $this->AttachmentType->getAttachmentTypeBySectionId(SectionsEnum::mission, "all");
                $supplierAttachmentTypes = $this->SupplierAttachmentType->getSupplierAttachmentTypesBySupplierId($id);
                $supplierAddresses = $this->SupplierAddress->getAddressBySupplier($id);
            }

            $supplierContacts = $this->SupplierContact->getContactsBySupplier($id);
            $legalForms = $this->LegalForm->find('list');
            $parentId = $this->request->data['Supplier']['parent_id'];

            $supplier = $this->Supplier->getSuppliersById($parentId, 'list');
            $services = $this->Service->getServices('list');
            $this->set(compact('supplierCategories', 'attachmentTypes',
                'supplierAttachmentTypes', 'supplierAddresses',
                'supplierContacts', 'legalForms','supplier','services'));
        }
    }

    /**
     * editOffShore method
     *
     * @param null|int $id
     * @throws Exception
     */
    public function editOffShore($id = null)
    {
        $offShore = $this->hasModuleOffShore();
        if ($offShore == 0) {
            $this->redirect('/');
        }

        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $code = $this->getNextCodeByFieldName( 'supplier');
        $this->set('code', $code);
        $this->verifyUserPermission(SectionsEnum::sous_traitant, $user_id, ActionsEnum::edit,
            "Suppliers", $id, "Supplier", 0,'indexOffShore');
        if (!$this->Supplier->exists($id)) {
            throw new NotFoundException(__('Invalid supplier'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Supplier cancelled.'));

                $this->redirect(array('action' => 'indexOffShore', 0));
            }

            if (($this->request->data['Supplier']['latitude'] == '') && ($this->request->data['Supplier']['longitude'] == '')) {
                $this->request->data['Supplier']['adress'] = '';
            }
            $this->request->data['Supplier']['last_modifier_id'] = $this->Session->read('Auth.User.id');

            if ($this->Supplier->save($this->request->data)) {
                $this->Flash->success(__('The supplier has been saved.'));
                $this->redirect(array('action' => 'indexOffShore', 0));
            } else {
                $this->Flash->error(__('The supplier could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Supplier.' . $this->Supplier->primaryKey => $id));
            $this->request->data = $this->Supplier->find('first', $options);
            $type = $this->request->data['Supplier']['type'];
            $supplierCategories = $this->SupplierCategory->getSupplierCategoriesByType($type);

            $this->set(compact('supplierCategories'));
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @param string $type
     * @param string $redirect
     * @return void
     */
    public function delete($id = null,$type=null, $redirect=null)
    {
        $this->setTimeActif();

        if ($type == 1) {
            $hasSaleModule = $this->hasSaleModule();
            $hasStandardSaleModule = $this->hasStandardSaleModule();
            $planning = $this->hasModulePlanification();
            if ($hasSaleModule == 0 && $hasStandardSaleModule == 0 && $planning == 0) {
                $this->redirect('/');
            }
        } else {
            $stock = $this->hasModuleStock();
            if ($stock == 0) {
                $this->redirect('/');
            }
        }

        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::fournisseur, $user_id, ActionsEnum::delete,
            "Suppliers", $id, "Supplier", $type);
        $this->Supplier->id = $id;
        if (!$this->Supplier->exists()) {
            throw new NotFoundException(__('Invalid Supplier'));
        }
        $this->verifyDependences($id, $type);
        $this->request->allowMethod('post', 'delete');
        if ($this->Supplier->delete()) {
            if ($type == SupplierTypesEnum::customer) {
                $this->Flash->success(__('The client has been deleted.'));
            } else {
                $this->Flash->success(__('The supplier has been deleted.'));
            }
        } else {
            if ($type == SupplierTypesEnum::customer) {
                $this->Flash->error(__('The client could not be deleted. Please, try again.'));
            } else {
                $this->Flash->error(__('The supplier could not be deleted. Please, try again.'));
            }
        }
        if(!$redirect){
            $this->redirect(array('action' => 'index', $type));
        }

    }

    public function deletesuppliers()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');
        $supplier = $this->Supplier->find('first',
            array(
                'recursive' => -1,
                'conditions' => array(
                    'Supplier.id' => $id
                ),
                'fields' => array(
                    'Supplier.type'
                )
            )
        );
        $type = $supplier['Supplier']['type'];
        $this->verifyUserPermission(SectionsEnum::fournisseur, $user_id, ActionsEnum::delete,
            "Suppliers", $id, "Supplier", $type);

        $this->Supplier->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Supplier->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }


    }

    private function verifyDependences($id, $type = null)
    {
        $this->setTimeActif();
        $result = $this->Bill->getBillByForeignKey($id, "supplier_id");
        if (!empty($result)) {
            $this->Flash->error(__('The client could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index', $type));
        }
        $this->loadModel('TransportBill');
        $this->loadModel('SheetRideDetailRides');
        $result = $this->Supplier->Car->find('first', array("conditions" => array("Supplier.id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The supplier could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index', $type));
        }
        $result = $this->SheetRideDetailRides->getTransportBillByForeignKey($id, "supplier_id");
        if (!empty($result)) {
            $this->Flash->error(__('The client could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index', $type));
        }

        $result = $this->SheetRideDetailRides->getTransportBillByForeignKey($id, "supplier_final_id");
        if (!empty($result)) {
            $this->Flash->error(__('The client could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index', $type));
        }

        $result = $this->TransportBill->getTransportBillByForeignKey($id, "supplier_id");
        if (!empty($result)) {
            $this->Flash->error(__('The client could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index', $type));
        }

        $result = $this->TransportBill->getTransportBillByForeignKey($id, "supplier_final_id");
        if (!empty($result)) {
            $this->Flash->error(__('The client could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index', $type));
        }


        $result = $this->User->getUserByForeignKey($id, "supplier_id");
        if (!empty($result)) {
            $this->Flash->error(__('The client could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index', $type));
        }
        $results = $this->FinalSupplierInitialSupplier->find('first',
            array(
                "conditions" => array(
                    "FinalSupplierInitialSupplier.initial_supplier_id =" => $id
                )
            )
        );
        if (!empty($results)) {
            $this->FinalSupplierInitialSupplier->deleteAll(array('FinalSupplierInitialSupplier.initial_supplier_id' => $id),
                false);
        }

        $results = $this->FinalSupplierInitialSupplier->find('first',
            array(
                "conditions" => array(
                    "FinalSupplierInitialSupplier.final_supplier_id =" => $id
                )
            )
        );
        if (!empty($results)) {
            $this->FinalSupplierInitialSupplier->deleteAll(array('FinalSupplierInitialSupplier.final_supplier_id' => $id),
                false);
        }

        $results = $this->SupplierAttachmentType->find('first',
            array(
                "conditions" => array(
                    "SupplierAttachmentType.supplier_id =" => $id
                )
            )
        );
        if (!empty($results)) {
            $this->SupplierAttachmentType->deleteAll(array('SupplierAttachmentType.supplier_id' => $id),
                false);
        }

        $results = $this->SupplierAddress->find('first',
            array(
                "conditions" => array(
                    "SupplierAddress.supplier_id =" => $id
                )
            )
        );
        if (!empty($results)) {
            $this->SupplierAddress->deleteAll(array('SupplierAddress.supplier_id' => $id),
                false);
        }

        $results = $this->SupplierContact->find('first',
            array(
                "conditions" => array(
                    "SupplierContact.supplier_id =" => $id
                )
            )
        );
        if (!empty($results)) {
            $this->SupplierContact->deleteAll(array('SupplierContact.supplier_id' => $id),
                false);
        }
    }

    function export()
    {
        $this->setTimeActif();
        $suppliers = $this->Supplier->find('all', array(
            'order' => 'Supplier.name asc',
            'recursive' => -1
        ));
        $this->set('models', $suppliers);
    }

    function inactif($id, $type)
    {
        $this->settimeactif();

        $this->Supplier->id = $id;
        $this->Supplier->saveField('active', 2);
        if ($type == 1) {
            $this->Flash->success(__('The client became inactive.'));
        } else {
            $this->Flash->success(__('The supplier became inactive.'));
        }

        $this->redirect(array('action' => 'index', $type));
    }

    function actif($id, $type)
    {
        $this->settimeactif();


        $this->Supplier->id = $id;
        $this->Supplier->saveField('active', 1);
        if ($type == 1) {
            $this->Flash->success(__('The client became active.'));
        } else {
            $this->Flash->success(__('The supplier became active.'));
        }

        $this->redirect(array('action' => 'index', $type));
    }

    public function import()
    {
        if (!empty($this->request->data['Supplier']['file_csv']['tmp_name'])) {

            if (is_uploaded_file($this->request->data['Supplier']['file_csv']['tmp_name'])) {
                $fichier = $this->request->data['Supplier']['file_csv']['name'];
                $ext = substr(strtolower(strrchr($fichier, '.')), 1);
                if ($ext == 'csv') {
                    if ($fichier) {
                        $fp = fopen($this->request->data['Supplier']['file_csv']['tmp_name'], "r");

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
                        $liste[5] = (isset($liste[5])) ? $liste[5] : null;
                        $liste[6] = (isset($liste[6])) ? $liste[6] : null;
                        $liste[7] = (isset($liste[7])) ? $liste[7] : null;
                        $liste[8] = (isset($liste[8])) ? $liste[8] : null;
                        $liste[9] = (isset($liste[9])) ? $liste[9] : null;
                        $liste[10] = (isset($liste[10])) ? $liste[10] : null;
                        $liste[11] = (isset($liste[11])) ? $liste[11] : null;
                        $liste[12] = (isset($liste[12])) ? $liste[12] : null;
                        $liste[13] = (isset($liste[13])) ? $liste[13] : null;
                        $liste[14] = (isset($liste[14])) ? $liste[14] : null;
                        $liste[15] = (isset($liste[15])) ? $liste[15] : null;
                        $liste[16] = (isset($liste[16])) ? $liste[16] : null;
                        $liste[17] = (isset($liste[17])) ? $liste[17] : null;
                        $liste[18] = (isset($liste[18])) ? $liste[18] : null;
                        $liste[19] = (isset($liste[19])) ? $liste[19] : null;
                        $liste[20] = (isset($liste[20])) ? $liste[20] : null;
                        $liste[21] = (isset($liste[21])) ? $liste[21] : null;
                        $liste[22] = (isset($liste[22])) ? $liste[12] : null;


                        $code = 'ci'. $liste[0];
                        $name = $liste[1];
                        $social_reason = $liste[2];
                        $category = $liste[3];
                        $codeAddress = $liste[4];
                        $adress = $liste[5];
                        $latlng = $liste[6];
                        $rc = $liste[7];
                        $if = $liste[8];
                        $ai = $liste[9];
                        $nis = $liste[10];
                        $cb = $liste[11];
                        $supplierAttachmentType22 = $liste[12];
                        $supplierAttachmentType23 = $liste[13];
                        $supplierAttachmentType24 = $liste[14];
                        $supplierAttachmentType25 = $liste[15];
                        $supplierAttachmentType26 = $liste[16];
                        $supplierAttachmentType27 = $liste[17];
                        $supplierAttachmentType28 = $liste[18];
                        $supplierTel = $liste[19];
                        $supplierEmail = $liste[20];
                        $supplierNote = $liste[21];
                        $supplierContact = $liste[22];
                        $category = $this->getSupplierCategoryId($category);

                        if ($cpt > 0) {
                            $this->Supplier->create();
                            if (!empty($code)) {
                                $this->request->data['Supplier']['code'] = $code;
                            }
                            $this->request->data['Supplier']['name'] = $name;
                            $this->request->data['Supplier']['social_reason'] = $social_reason;
                            $this->request->data['Supplier']['code_address'] = $codeAddress;
                            $this->request->data['Supplier']['adress'] = $adress;
                            $this->request->data['Supplier']['latlng'] = $latlng;
                            $this->request->data['Supplier']['supplier_category_id'] = $category;
                            $this->request->data['Supplier']['type'] = 1;
                            $this->request->data['Supplier']['rc'] = $rc;
                            $this->request->data['Supplier']['if'] = $if;
                            $this->request->data['Supplier']['ai'] = $ai;
                            $this->request->data['Supplier']['nis'] = $nis;
                            $this->request->data['Supplier']['cb'] = $cb;
                            $this->request->data['Supplier']['user_id'] = $this->Session->read('Auth.User.id');
                            $this->request->data['Supplier']['note'] = $supplierNote;

                            $this->Supplier->save($this->request->data);
                            $supplierId = $this->Supplier->getInsertID();


                            if ($supplierAttachmentType22 == 1) {
                                $this->SupplierAttachmentType->create();
                                $attachment = array();
                                $attachment['SupplierAttachmentType']['supplier_id'] = $supplierId;
                                $attachment['SupplierAttachmentType']['attachment_type_id'] = 22;
                                $attachment['SupplierAttachmentType']['user_id'] = $this->Session->read('Auth.User.id');
                                $this->SupplierAttachmentType->save($attachment);
                            }
                            if ($supplierAttachmentType23 == 1) {
                                $this->SupplierAttachmentType->create();
                                $attachment = array();
                                $attachment['SupplierAttachmentType']['supplier_id'] = $supplierId;
                                $attachment['SupplierAttachmentType']['attachment_type_id'] = 23;
                                $attachment['SupplierAttachmentType']['user_id'] = $this->Session->read('Auth.User.id');
                                $this->SupplierAttachmentType->save($attachment);
                            }
                            if ($supplierAttachmentType24 == 1) {
                                $this->SupplierAttachmentType->create();
                                $attachment = array();
                                $attachment['SupplierAttachmentType']['supplier_id'] = $supplierId;
                                $attachment['SupplierAttachmentType']['attachment_type_id'] = 24;
                                $attachment['SupplierAttachmentType']['user_id'] = $this->Session->read('Auth.User.id');
                                $this->SupplierAttachmentType->save($attachment);
                            }
                            if ($supplierAttachmentType25 == 1) {
                                $this->SupplierAttachmentType->create();
                                $attachment = array();
                                $attachment['SupplierAttachmentType']['supplier_id'] = $supplierId;
                                $attachment['SupplierAttachmentType']['attachment_type_id'] = 25;
                                $attachment['SupplierAttachmentType']['user_id'] = $this->Session->read('Auth.User.id');
                                $this->SupplierAttachmentType->save($attachment);
                            }
                            if ($supplierAttachmentType26 == 1) {
                                $this->SupplierAttachmentType->create();
                                $attachment = array();
                                $attachment['SupplierAttachmentType']['supplier_id'] = $supplierId;
                                $attachment['SupplierAttachmentType']['attachment_type_id'] = 26;
                                $attachment['SupplierAttachmentType']['user_id'] = $this->Session->read('Auth.User.id');
                                $this->SupplierAttachmentType->save($attachment);
                            }
                            if ($supplierAttachmentType27 == 1) {
                                $this->SupplierAttachmentType->create();
                                $attachment = array();
                                $attachment['SupplierAttachmentType']['supplier_id'] = $supplierId;
                                $attachment['SupplierAttachmentType']['attachment_type_id'] = 27;
                                $attachment['SupplierAttachmentType']['user_id'] = $this->Session->read('Auth.User.id');
                                $this->SupplierAttachmentType->save($attachment);
                            }

                            if ($supplierAttachmentType28 == 1) {
                                $this->SupplierAttachmentType->create();
                                $attachment = array();
                                $attachment['SupplierAttachmentType']['supplier_id'] = $supplierId;
                                $attachment['SupplierAttachmentType']['attachment_type_id'] = 28;
                                $attachment['SupplierAttachmentType']['user_id'] = $this->Session->read('Auth.User.id');
                                $this->SupplierAttachmentType->save($attachment);
                            }
                            if (!empty($supplierEmail) || !empty($supplierTel) || !empty($supplierContact)){
                                $this->SupplierContact->create();
                                $data['SupplierContact']['contact'] = $supplierContact;
                                $data['SupplierContact']['tel'] = $supplierTel;
                                $data['SupplierContact']['email1'] = $supplierEmail;
                                $data['SupplierContact']['supplier_id'] = $supplierId;
                                $this->SupplierContact->save($data);
                            }
                        }
                        $cpt++;
                    }

                    fclose($fp);
                    echo json_encode(array("response" => "true"));
                    $this->Flash->success(__('The file has been successfully imported'));

                    $this->redirect(array('action' => 'index', 1));
                } else {
                    $this->Flash->error(__('The file must be in csv format'));
                    $this->redirect(array('action' => 'index', 1));

                }

            }

        }

    }

    public function importAddresses()
    {
        if (!empty($this->request->data['Supplier']['file_address_csv']['tmp_name'])) {

            if (is_uploaded_file($this->request->data['Supplier']['file_address_csv']['tmp_name'])) {
                $fichier = $this->request->data['Supplier']['file_address_csv']['name'];
                $ext = substr(strtolower(strrchr($fichier, '.')), 1);
                if ($ext == 'csv') {
                    if ($fichier) {
                        $fp = fopen($this->request->data['Supplier']['file_address_csv']['tmp_name'], "r");

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
                        filter_input(INPUT_POST, 'file_address_csv');
                        $liste[0] = (isset($liste[0])) ? $liste[0] : null;
                        $liste[1] = (isset($liste[1])) ? $liste[1] : null;
                        $liste[2] = (isset($liste[2])) ? $liste[2] : null;
                        $liste[3] = (isset($liste[3])) ? $liste[3] : null;
                        $liste[4] = (isset($liste[4])) ? $liste[4] : null;
                        $liste[5] = (isset($liste[5])) ? $liste[5] : null;

                        $nameClient = $liste[0];
                        $codeAddress = $liste[1];
                        $address = $liste[2];
                        $latitude = $liste[3];
                        $longitude = $liste[4];
                        $latlng = $liste[5];

                        $supplierId = $this->getSupplierId($nameClient);

                        if ($cpt > 0) {

                            if (!empty($codeAddress)) {
                                $this->SupplierAddress->create();
                                $this->request->data['SupplierAddress']['code'] = $codeAddress;
                                $this->request->data['SupplierAddress']['supplier_id'] = $supplierId;
                                $this->request->data['SupplierAddress']['latitude'] = $latitude;
                                $this->request->data['SupplierAddress']['longitude'] = $longitude;
                                $this->request->data['SupplierAddress']['address'] = $address;
                                $this->request->data['SupplierAddress']['latlng'] = $latlng;

                                $this->SupplierAddress->save($this->request->data);
                            }
                        }
                        $cpt++;
                    }

                    fclose($fp);
                    echo json_encode(array("response" => "true"));
                    $this->Flash->success(__('The file has been successfully imported'));

                    $this->redirect(array('action' => 'index', 1));
                } else {
                    $this->Flash->success(__('The file must be in csv format'));
                    $this->redirect(array('action' => 'index', 1));

                }

            }

        }

    }

    public function importContacts()
    {
        if (!empty($this->request->data['Supplier']['file_contact_csv']['tmp_name'])) {

            if (is_uploaded_file($this->request->data['Supplier']['file_contact_csv']['tmp_name'])) {
                $fichier = $this->request->data['Supplier']['file_contact_csv']['name'];
                $ext = substr(strtolower(strrchr($fichier, '.')), 1);
                if ($ext == 'csv') {
                    if ($fichier) {
                        $fp = fopen($this->request->data['Supplier']['file_contact_csv']['tmp_name'], "r");

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
                        filter_input(INPUT_POST, 'file_contact_csv');
                        $liste[0] = (isset($liste[0])) ? $liste[0] : null;
                        $liste[1] = (isset($liste[1])) ? $liste[1] : null;
                        $liste[2] = (isset($liste[2])) ? $liste[2] : null;
                        $liste[3] = (isset($liste[3])) ? $liste[3] : null;
                        $liste[4] = (isset($liste[4])) ? $liste[4] : null;
                        $liste[5] = (isset($liste[5])) ? $liste[5] : null;

                        $codeClient = $liste[0];
                        $contact = $liste[1];
                        $email = $liste[2];
                        $tel = $liste[3];
                        $function = $liste[4];

                        $supplierId = $this->getSupplierId($codeClient);

                        if ($cpt > 0) {
                            if (!empty($contact)) {
                                $this->SupplierContact->create();
                                $this->request->data['SupplierContact']['supplier_id'] = $supplierId;
                                $this->request->data['SupplierContact']['contact'] = $contact;
                                $this->request->data['SupplierContact']['email1'] = $email;
                                $this->request->data['SupplierContact']['tel'] = $tel;
                                $this->request->data['SupplierContact']['function'] = $function;
                                $this->SupplierContact->save($this->request->data);
                            }
                        }
                        $cpt++;
                    }

                    fclose($fp);
                    echo json_encode(array("response" => "true"));
                    $this->Flash->success(__('The file has been successfully imported'));

                    $this->redirect(array('action' => 'index', 1));
                } else {
                    $this->Flash->error(__('The file must be in csv format'));
                    $this->redirect(array('action' => 'index', 1));

                }
            }

        }
    }

    public function getSupplierId($clientCodeImport)
    {
        $clientCodeImport = trim($clientCodeImport);
        $clientCodeImport = strtolower($clientCodeImport);
        $supplierId = 0;
        $suppliers = $this->Supplier->find('all', array('recursive' => -1));
        foreach ($suppliers as $supplier) {
            $supplierCode = strtolower($supplier['Supplier']['code']);
            $supplierCode = trim($supplierCode);
            if ($clientCodeImport == $supplierCode) {
                $supplierId = $supplier['Supplier']['id'];
            }
        }
        return $supplierId;
    }

    public function getSupplierCategoryId($categoryNameImport)
    {
        $categoryNameImport = trim($categoryNameImport);
        $categoryNameImport = strtolower($categoryNameImport);

        $categoryId = 0;
        $supplierCategories = $this->SupplierCategory->getSupplierCategoriesByType(SupplierCategoriesEnum::CUSTOMER_TYPE, 'all');
        foreach ($supplierCategories as $supplierCategory) {
            $categoryName = strtolower($supplierCategory['SupplierCategory']['name']);
            $categoryName = trim($categoryName);
            if ($categoryNameImport == $categoryName) {
                $categoryId = $supplierCategory['SupplierCategory']['id'];
            }
        }
        return $categoryId;
    }

    public function addOtherContact($i = null)
    {
        $this->layout = 'ajax';
        $this->set('i', $i);
    }

    public function addOtherAddress($i = null)
    {
        $this->layout = 'ajax';
        $this->set('i', $i);
    }

    function supplierCard($id)
    {
        $this->loadModel('Tva');
        $supplier = $this->Supplier->find('first', array(
            'recursive' => -1, // should be used with joins
            'conditions' => array('Supplier.id' => $id)
        ));
        if (Configure::read("gestion_commercial") == '1') {
            $conditions = array();
            $conditions['SheetRideDetailRides.invoiced_ride '] = 1;
            $conditions['SheetRideDetailRides.supplier_id '] = $id;
            $conditions['SheetRideDetailRides.status_id '] = array(1, 2, 3, 4, 5, 6, 7);
            $sheetRideDetailRides = $this->SheetRideDetailRides->find('all', array(
                'paramType' => 'querystring',
                'recursive' => -1, // should be used with joins
                'order' => array(' SheetRideDetailRides.real_start_date ' => 'asc', 'SheetRideDetailRides.id' => 'asc'),
                'conditions' => $conditions,
                'fields' => array(
                    'SheetRideDetailRides.id',
                    'SheetRideDetailRides.reference',
                    'SheetRideDetailRides.supplier_id',
                    'SheetRideDetailRides.detail_ride_id',
                    'SheetRideDetailRides.real_start_date',
                    'SheetRideDetailRides.real_end_date',
                    'SheetRideDetailRides.status_id',
                    'DepartureDestination.name',
                    'ArrivalDestination.name',
                    'Supplier.name',
                    'CarType.name'
                ),
                'joins' => array(


                    array(
                        'table' => 'detail_rides',
                        'type' => 'left',
                        'alias' => 'DetailRide',
                        'conditions' => array('SheetRideDetailRides.detail_ride_id = DetailRide.id')
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
                                'SheetRideDetailRides.return_mission',
                                'SheetRideDetailRides.detail_ride_id',
                                'SheetRideDetailRides.real_start_date',
                                'SheetRideDetailRides.real_end_date',
                                'SheetRideDetailRides.status_id',
                                'SheetRideDetailRides.ride_category_id',
                                'DepartureDestination.name',
                                'ArrivalDestination.name',
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
                                'SheetRideDetailRides.real_start_date',
                                'SheetRideDetailRides.real_end_date',
                                'SheetRideDetailRides.status_id',
                                'DepartureDestination.name',
                                'ArrivalDestination.name',
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
                                'SheetRideDetailRides.real_start_date',
                                'SheetRideDetailRides.real_end_date',
                                'SheetRideDetailRides.status_id',
                                'DepartureDestination.name',
                                'ArrivalDestination.name',
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
                $detail_ride_id = $sheetRideDetailRide['SheetRideDetailRides']['detail_ride_id'];
                $supplier_id = $id;
                $ride_category_id = $sheetRideDetailRide['SheetRideDetailRides']['ride_category_id'];
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
                $sheetRideDetailRide['SheetRideDetailRides']['delivery_with_return'] = $sheetRideDetailRide['SheetRideDetailRides']['return_mission'];
                $sheetRideDetailRide['SheetRideDetailRides']['ristourne_%'] = $sheetRideDetailRide['TransportBillDetailRides']['ristourne_%'];
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
            $preinvoices = $this->TransportBill->find('all',
                array(
                    'recursive' => -1,
                    'order' => array('TransportBill.date' => 'asc', 'TransportBill.id' => 'asc'),
                    'conditions' => array('TransportBill.supplier_id' => $id, 'TransportBill.type' => 4),
                    'fields' => array(
                        'TransportBill.date',
                        'TransportBill.reference',
                        'TransportBill.total_ttc',
                        'TransportBill.amount_remaining'
                    ),

                ));
            $invoices = $this->TransportBill->find('all',
                array(
                    'recursive' => -1,
                    'order' => array('TransportBill.date' => 'asc', 'TransportBill.id' => 'asc'),
                    'conditions' => array('TransportBill.supplier_id' => $id, 'TransportBill.type' => 7),
                    'fields' => array(
                        'TransportBill.date',
                        'TransportBill.reference',
                        'TransportBill.total_ttc',
                        'TransportBill.amount_remaining'
                    ),

                ));
            $this->set(compact('results', 'preinvoices', 'invoices', 'supplier'));
        }else {
            if($supplier['Supplier']['type']==SupplierTypesEnum::customer) {
                $quotes = $this->Bill->getBillsByConditions(array('Bill.supplier_id' => $id, 'Bill.type' => BillTypesEnum::quote),'all', 'Bill.date ASC');

                $orders = $this->Bill->getBillsByConditions(array('Bill.supplier_id' => $id, 'Bill.type' => BillTypesEnum::customer_order),'all', 'Bill.date ASC');
                $deliveryOrders = $this->Bill->getBillsByConditions(array('Bill.supplier_id' => $id, 'Bill.type' => BillTypesEnum::delivery_order),'all', 'Bill.date ASC');
                $invoices = $this->Bill->getBillsByConditions(array('Bill.supplier_id' => $id, 'Bill.type' => BillTypesEnum::sales_invoice),'all', 'Bill.date ASC');
                $this->set(compact('quotes', 'orders', 'deliveryOrders','invoices', 'supplier'));

            }else {
                $orders = $this->Bill->getBillsByConditions(array('Bill.supplier_id' => $id, 'Bill.type' => BillTypesEnum::supplier_order),'all', 'Bill.date ASC');
                $receipts = $this->Bill->getBillsByConditions(array('Bill.supplier_id' => $id, 'Bill.type' => BillTypesEnum::receipt),'all', 'Bill.date ASC');
                $this->set(compact('orders', 'receipts', 'invoices', 'supplier'));

            }


        }
    }


    public function liste($type = null, $id = null, $keyword = null, $category = null )
    {

        $this->set('category',$category);
        $keyword = str_replace('espace', ' ', $keyword);
        $keyword = str_replace('slash', '/', $keyword);
        $keyword = strtolower($keyword);
        $this->layout = 'ajax';
        $limit = $this->getLimit();
        $order = $this->getOrder();
        $userId = $this->Auth->user('id');
        if ($type == 0) {
            $result = $this->verifyUserPermission(SectionsEnum::fournisseur, $userId, ActionsEnum::view,
                "Suppliers", null, "Supplier", $type);
        } else {
            $result = $this->verifyUserPermission(SectionsEnum::client, $userId, ActionsEnum::view,
                "Suppliers", null, "Supplier", $type);
        }
        $profileId = $this->Auth->user('profile_id');
        $parentId = $this->Profile->getParentProfileByProfileId($profileId);
        if ($parentId != Null) {
            $profileId = $parentId;
        }
        $this->set(compact('profileId'));

        switch ($id) {
            case 2 :
                if($category!=''){
                    $listConditions = array(
                        "LOWER(Supplier.code) LIKE" => "%$keyword%",
                        "Supplier.supplier_category_id" => $category,
                    );
                }else {
                    $listConditions = array(
                        "LOWER(Supplier.code) LIKE" => "%$keyword%"
                    );
                }

                break;
            case 3 :
                if($category!=''){
                    $listConditions = array(
                        "LOWER(Supplier.name) LIKE" => "%$keyword%",
                        "Supplier.supplier_category_id" => $category
                    );
                }else {
                    $listConditions = array(
                        "LOWER(Supplier.name) LIKE" => "%$keyword%"
                    );
                }

                break;
            case 4 :
                if($category!=''){
                    $listConditions = array(
                        "LOWER(Supplier.adress) LIKE" => "%$keyword%",
                        "Supplier.supplier_category_id" => $category
                    );
                }else {
                    $listConditions = array(
                        "LOWER(Supplier.adress) LIKE" => "%$keyword%"
                    );
                }

                break;

            case 5 :
                if($category!=''){
                    $listConditions = array(
                        "LOWER(Supplier.tel) LIKE" => "%$keyword%",
                        "Supplier.supplier_category_id" => $category
                    );
                }else {
                    $listConditions = array(
                        "LOWER(Supplier.tel) LIKE" => "%$keyword%"
                    );
                }

                break;

            case 6 :
                if($category!=''){
                    $listConditions = array(
                        "LOWER(SupplierCategory.name) LIKE" => "%$keyword%",
                        "Supplier.supplier_category_id" => $category
                    );
                }else {
                    $listConditions = array(
                        "LOWER(SupplierCategory.name) LIKE" => "%$keyword%"
                    );
                }

                break;

            case 7 :
                if($category!=''){
                    $listConditions = array(
                        "LOWER(Supplier.balance) LIKE" => "%$keyword%",
                        "Supplier.supplier_category_id" => $category
                    );
                }else {
                    $listConditions = array(
                        "LOWER(Supplier.balance) LIKE" => "%$keyword%"
                    );
                }

                break;

            default:
                if($category!=''){
                    $listConditions = array(
                        "LOWER(Supplier.name) LIKE" => "%$keyword%",
                        "Supplier.supplier_category_id" => $category
                    );
                }else {
                    $listConditions = array(
                        "LOWER(Supplier.name) LIKE" => "%$keyword%"
                    );
                }

        }

        if ($profileId == ProfilesEnum::client) {
            $supplierId = $this->Auth->user('supplier_id');

            $this->set(compact('supplierId'));
            switch ($result) {
                case 1 :
                    $conditions = array(
                        'Supplier.type ' => $type,
                        'Supplier.active' => 1,
                        'FinalSupplierInitialSupplier.initial_supplier_id' => $supplierId
                    );
                    break;
                case 2 :
                    $conditions = array(
                        'Supplier.type ' => $type,
                        'Supplier.active' => 1,
                        'OR' => array(
                            'Supplier.user_id ' => $userId,
                            'FinalSupplierInitialSupplier.initial_supplier_id' => $supplierId
                        )

                    );
                    break;
                case 3 :
                    $conditions = array(
                        'Supplier.type ' => $type,
                        'Supplier.active' => 1,
                        'OR' => array(
                            'Supplier.user_id !=' => $userId,
                            'FinalSupplierInitialSupplier.initial_supplier_id' => $supplierId
                        )

                    );

                    break;
                default:
                    $conditions = array(
                        'Supplier.type ' => $type,
                        'Supplier.active' => 1,
                        'FinalSupplierInitialSupplier.initial_supplier_id' => $supplierId
                    );

            }

            if ($listConditions != null) {
                $conditions = array_merge($conditions, $listConditions);

            }

            $this->paginate = array(
                'recursive' => -1,
                'limit' => $limit,
                'order' => $order,
                'conditions' => $conditions,
                'paramType' => 'querystring',
                'fields' => array(
                    'Supplier.id',
                    'Supplier.code',
                    'Supplier.name',
                    'Supplier.adress',
                    'Supplier.tel',
                    'Supplier.balance',
                    'Supplier.active',
                    'Supplier.type',
                    'SupplierCategory.name',

                ),
                'joins' => array(
                    array(
                        'table' => 'final_supplier_initial_suppliers',
                        'type' => 'left',
                        'alias' => 'FinalSupplierInitialSupplier',
                        'conditions' => array('FinalSupplierInitialSupplier.final_supplier_id = Supplier.id')
                    ),
                    array(
                        'table' => 'supplier_categories',
                        'type' => 'left',
                        'alias' => 'SupplierCategory',
                        'conditions' => array('SupplierCategory.id = Supplier.supplier_category_id')
                    ),
                ),
            );

            $this->set('suppliers', $this->Paginator->paginate());


        } else {
            switch ($result) {
                case 1 :
                    $conditions = array(
                        'Supplier.type ' => $type,
                        'Supplier.active' => 1,
                        'Supplier.final_customer' => array(2, 3)
                    );
                    break;
                case 2 :
                    $conditions = array(
                        'Supplier.user_id ' => $userId,
                        'Supplier.type ' => $type,
                        'Supplier.active' => 1,
                        'Supplier.final_customer' => array(2, 3)
                    );
                    break;
                case 3 :
                    $conditions = array(
                        'Supplier.user_id !=' => $userId,
                        'Supplier.type ' => $type,
                        'Supplier.active' => 1,
                        'Supplier.final_customer' => array(2, 3)
                    );

                    break;
                default:
                    $conditions = array(
                        'Supplier.type ' => $type,
                        'Supplier.active' => 1,
                        'Supplier.final_customer' => array(2, 3)
                    );

            }

            if ($listConditions != null) {
                $conditions = array_merge($conditions, $listConditions);

            }
            $this->paginate = array(
                'limit' => $limit,
                'order' => $order,
                'conditions' => $conditions,
                'paramType' => 'querystring'
            );
            $this->Supplier->recursive = 0;

            $this->set('suppliers', $this->Paginator->paginate());
        }


        $separatorAmount = $this->getSeparatorAmount();

        $this->set(compact('separatorAmount'));


    }


    public function viewFinalSuppliers($id = null)
    {
        $this->layout = 'ajax';
        $suppliers = $this->Supplier->find('all',
            array(
                'recursive' => -1,
                'order' => 'Supplier.name ASC',
                'conditions' =>
                    array(
                        'Supplier.type' => 1,
                        'Supplier.active' => 1,
                        'Supplier.final_customer' => array(1, 3),
                        'FinalSupplierInitialSupplier.initial_supplier_id' => $id
                    ),
                'fields' => array(
                    'Supplier.id',
                    'Supplier.code',
                    'Supplier.name',
                    'Supplier.adress',
                    'Supplier.tel',
                    'Supplier.balance',
                    'Supplier.type',
                    'Supplier.active',
                    'SupplierCategory.name',

                ),
                'joins' =>
                    array(
                        array(
                            'table' => 'final_supplier_initial_suppliers',
                            'type' => 'left',
                            'alias' => 'FinalSupplierInitialSupplier',
                            'conditions' => array('FinalSupplierInitialSupplier.final_supplier_id = Supplier.id')
                        ),
                        array(
                            'table' => 'supplier_categories',
                            'type' => 'left',
                            'alias' => 'SupplierCategory',
                            'conditions' => array('SupplierCategory.id = Supplier.supplier_category_id')
                        ),


                    )

            ));
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('suppliers', 'separatorAmount'));

    }

    /**
     * recherche client initial par mot cle
     */
    public function getInitialSuppliersByKeyWord()
    {
        $this->autoRender = false;

        // get the search term from URL
        $term = $this->request->query['q'];
        if (isset($_GET['categoryId'])) {
            $categoryId = $_GET['categoryId'];
        }

        if (isset($categoryId)) {
            $conds = array(
                " CONVERT(Supplier.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term%",
                "Supplier.supplier_category_id" => $categoryId,
            );
        } else {
            $conds = array(
                " CONVERT(Supplier.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term%",
            );
        }

        $suppliers = $this->Supplier->getSuppliersByParams(1, 1, null, array(2, 3), 'all', null, $conds);

        $data = array();
        $i = 0;
        $data[$i]['id'] = "";
        $data[$i]['text'] = "";
        $i++;
        foreach ($suppliers as $supplier) {
            $data[$i]['id'] = $supplier['Supplier']['id'];
            $data[$i]['text'] = $supplier['Supplier']['name'];
            $i++;
        }

        echo json_encode($data);
    }

    /**
     * recherche client initial par mot cle
     */
    public function getClientsByKeyWord()
    {
        $this->autoRender = false;

        // get the search term from URL
        $term = $this->request->query['q'];
        if (isset($_GET['categoryId'])) {
            $categoryId = $_GET['categoryId'];
        }

        if (isset($categoryId)) {
            $conds = array(
                " CONVERT(Supplier.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term%",
                "Supplier.supplier_category_id" => $categoryId,
            );
        } else {
            $conds = array(
                " CONVERT(Supplier.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term%",
            );
        }

        $suppliers = $this->Supplier->getSuppliersByParams(1, 1, null, array(1, 2, 3), 'all', null, $conds);

        $data = array();
        $i = 0;
        $data[$i]['id'] = "";
        $data[$i]['text'] = "";
        $i++;
        foreach ($suppliers as $supplier) {
            $data[$i]['id'] = $supplier['Supplier']['id'];
            $data[$i]['text'] = $supplier['Supplier']['name'];
            $i++;
        }

        echo json_encode($data);
    }

    /**
     * recherche fournisseur initial par mot cle
     */
    public function getSuppliersByKeyWord()
    {
        $this->autoRender = false;

        // get the search term from URL
        $term = $this->request->query['q'];

        $conds = array(
            " CONVERT(Supplier.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term%",
        );


        $suppliers = $this->Supplier->getSuppliersByParams(0, 1, null, null, 'all', null, $conds);

        $data = array();
        $i = 0;
        $data[$i]['id'] = "";
        $data[$i]['text'] = "";
        $i++;
        foreach ($suppliers as $supplier) {
            $data[$i]['id'] = $supplier['Supplier']['id'];
            $data[$i]['text'] = $supplier['Supplier']['name'];
            $i++;
        }

        echo json_encode($data);
    }

   /**
     * recherche fournisseur initial par mot cle
     */
    public function getSubcontractorsByKeyWord()
    {
        $this->autoRender = false;

        // get the search term from URL
        $term = $this->request->query['q'];

        $conds = array(
            " CONVERT(Supplier.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term%",
        );


        $suppliers = $this->Supplier->getSuppliersByParams(0, 1, 1, null, 'all', null, $conds);

        $data = array();
        $i = 0;
        $data[$i]['id'] = "";
        $data[$i]['text'] = "";
        $i++;
        foreach ($suppliers as $supplier) {
            $data[$i]['id'] = $supplier['Supplier']['id'];
            $data[$i]['text'] = $supplier['Supplier']['name'];
            $i++;
        }

        echo json_encode($data);
    }

    /**
     * recherche client final par mot cle
     */
    public function getFinalSuppliersByKeyWord()
    {

        $this->autoRender = false;

        // get the search term from URL
        $term = $this->request->query['q'];
        $initialSupplierId = $_GET['supplierId'];

        $conds = array(
            " CONVERT(Supplier.name USING utf8)  COLLATE utf8_general_ci  LIKE" => "%$term%",
        );


        $suppliers = $this->Supplier->getFinalSuppliersByInitialSupplier($initialSupplierId, null, $conds, 'all');

        $data = array();
        $i = 0;
        $data[$i]['id'] = "";
        $data[$i]['text'] = "";
        $i++;
        foreach ($suppliers as $supplier) {
            $data[$i]['id'] = $supplier['Supplier']['id'];
            $data[$i]['text'] = $supplier['Supplier']['name'];
            $i++;
        }

        echo json_encode($data);
    }

    public function addSupplierAttachmentTypes($supplierAttachmentTypes, $supplierId)
    {
        $this->SupplierAttachmentType->deleteAll(array('SupplierAttachmentType.supplier_id' => $supplierId), false);
        $attachmentTypes = $this->AttachmentType->getAttachmentTypeBySectionId(SectionsEnum::mission, "all");
        foreach ($attachmentTypes as $attachmentType) {
            if (($supplierAttachmentTypes[$attachmentType['AttachmentType']['id']] == 1)) {
                $this->SupplierAttachmentType->create();
                $attachment = array();
                $attachment['SupplierAttachmentType']['supplier_id'] = $supplierId;
                $attachment['SupplierAttachmentType']['attachment_type_id'] = $attachmentType['AttachmentType']['id'];
                $attachment['SupplierAttachmentType']['user_id'] = $this->Session->read('Auth.User.id');
                $this->SupplierAttachmentType->save($attachment);
            }
        }

    }

    public function getCodeCustomer($type = null,   $supplierId = null)
    {
        $this->layout = 'ajax';
        if($supplierId != null){
            $supplier = $this->Supplier->find('first', array(
                'conditions' => array('Supplier.id' => $supplierId),
                'fields' => array('Supplier.final_customer', 'Supplier.code'),
                'recursive' => -1));
            $finalCustomer = $supplier['Supplier']['final_customer'];

            if ($type != $finalCustomer) {
                if ($type == 1) {
                    $code = $this->getNextCodeByFieldName( 'client_final');
                } else {
                    $code = $this->getNextCodeByFieldName( 'client_initial');
                }
                $this->set('code', $code);
            } else {
                $code = $supplier['Supplier']['code'];
                $this->set('code', $code);
            }
        } else {
            if ($type == 1) {
                $code = $this->getNextCodeByFieldName( 'client_final');
            } else {
                $code = $this->getNextCodeByFieldName( 'client_initial');
            }
            $this->set('code', $code);
        }

    }

    public function printSimplifiedJournal()
    {
        $this->loadModel('Company');
        $this->setTimeActif();
        ini_set('memory_limit', '512M');
        $array = filter_input(INPUT_POST, "printSimplifiedJournal");

        $arrayConditions = explode(",", $array);

        $suppliersSupplierCategoryId = $arrayConditions[0];
        $suppliersActive = $arrayConditions[1];
        $type = $arrayConditions[2];

        $conditions = array();
        $conditions["Supplier.type = "] = $type;
        if (!empty($suppliersSupplierCategoryId)) {
            $conditions["Supplier.supplier_category_id"] = $suppliersSupplierCategoryId;
        }
        if (!empty($suppliersActive)) {
            $conditions["Supplier.active ="] = $suppliersActive;
        }

        $ids = filter_input(INPUT_POST, "chkids");

        if (!empty($ids)) {

            $array_ids = explode(",", $ids);
            if (!empty($array_ids)) {
                $conditions["Supplier.id"] = $array_ids;
            }
        }

        $suppliers = $this->Supplier->find('all', array(

            'recursive' => -1,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'fields' => array(

                'Supplier.code',
                'Supplier.name',
                'Supplier.adress',
                'Category.name',
                'Supplier.balance',

            ),
            'joins' => array(

                array(
                    'table' => 'supplier_categories',
                    'type' => 'left',
                    'alias' => 'Category',
                    'conditions' => array('Supplier.supplier_category_id = Category.id')
                ),
            )
        ));

        $company = $this->Company->find('first');
        $this->set(compact('suppliers', 'company', 'category'));

    }

    /**
     * Quick add supplier
     */
    function addSupplier()
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::fournisseur, $user_id, ActionsEnum::add, "Suppliers", null,
            "Supplier", null, 1);
        $supplierCategories = $this->SupplierCategory->getSupplierCategoriesByType(0);
        $code = $this->getNextCodeByFieldName( 'supplier');
        $this->set(compact('result', 'supplierCategories', 'code'));
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->Supplier->create();
            if ($this->Supplier->save($this->request->data)) {
                $nextNumber = $this->Parameter->setNextCodeNumber('supplier');
                $supplierId = $this->Supplier->getInsertID();
                $data['CodeLog']['supplier_id'] = $supplierId;
                $data['CodeLog']['date'] =  date('Y-m-d');
                $data['CodeLog']['old_code'] =  $code;
                $data['CodeLog']['new_code'] =  $nextNumber;
                $data['CodeLog']['user_id'] = $this->Session->read('Auth.User.id');
                $this->CodeLog->insertCodeLog($data);
                $this->set('saved', true); //only set true if data saves OK
                $supplierId = $this->Supplier->getLastInsertId();
                $this->set('supplierId', $supplierId);
            }
        }
    }


    /**
     * @param null $id
     * @param null $idSelect
     * @throws Exception
     */
    function editSupplier($id = null, $idSelect = null)
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::fournisseur, $user_id, ActionsEnum::edit, "Suppliers", null,
            "Supplier", null, 1);
        $supplierCategories = $this->SupplierCategory->getSupplierCategoriesByType(0);
        $code = $this->getNextCodeByFieldName( 'supplier');
        $this->set(compact('result', 'supplierCategories', 'code', 'idSelect'));
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened

        if (!empty($this->request->data)) {
            if ($this->Supplier->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $supplierId = $this->request->data['Supplier']['id'];
                $this->set('supplierId', $supplierId);
                $this->set('idSelect', $idSelect);
            }
        }else{
            $options = array('conditions' => array('Supplier.' . $this->Supplier->primaryKey => $id));
            $this->request->data = $this->Supplier->find('first', $options);
            $this->request->data['Supplier']['idSelect'] = $idSelect;
        }
    }

    
	
	
	
	
	
	
	function getSuppliers()
    {
        $this->settimeactif();
        $this->layout = 'ajax';
        $suppliers = $this->Supplier->getSuppliersByParams(0, 1, null, null, "all");

		$this->set('selectbox', $suppliers);
        $this->set('selectedid', $this->params['pass']['0']);
        if(isset($this->params['pass']['1'])){
            $this->set('idSelect', $this->params['pass']['1']);
        }

    }

    /**
     * @param null $idSelect
     * @throws Exception
     */
    function addClient($idSelect = null)
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::client, $user_id, ActionsEnum::add, "Suppliers", null,
            "Supplier", null, 1);
        $supplierCategories = $this->SupplierCategory->getSupplierCategoriesByType(1);
        $code = $this->getNextCodeByFieldName( 'client_initial');
        $this->set(compact('result', 'supplierCategories', 'code', 'idSelect'));
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->Supplier->create();
            if ($this->Supplier->save($this->request->data)) {
                $nextNumber =  $this->Parameter->setNextCodeNumber('client_initial');
                $supplierId = $this->Supplier->getInsertID();
                $data['CodeLog']['supplier_id'] = $supplierId;
                $data['CodeLog']['date'] =  date('Y-m-d');
                $data['CodeLog']['old_code'] =  $code;
                $data['CodeLog']['new_code'] =  $nextNumber;
                $data['CodeLog']['user_id'] = $this->Session->read('Auth.User.id');
                $this->CodeLog->insertCodeLog($data);

                $this->set('saved', true); //only set true if data saves OK
                $supplierId = $this->Supplier->getLastInsertId();
                $this->set('supplierId', $supplierId);
            }
        }
    }

    /**
     * @param null $id
     * @param null $idSelect
     * @throws Exception
     */
    function editClient($id = null, $idSelect = null)
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::client, $user_id, ActionsEnum::edit, "Suppliers", null,
            "Supplier", null, 1);
        $supplierCategories = $this->SupplierCategory->getSupplierCategoriesByType(1);
        $code = $this->getNextCodeByFieldName( 'client_initial');
        $this->set(compact('result', 'supplierCategories', 'code', 'idSelect'));
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened

        if (!empty($this->request->data)) {
            if ($this->Supplier->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $supplierId = $this->request->data['Supplier']['id'];
                $this->set('supplierId', $supplierId);
                $this->set('idSelect', $idSelect);
            }
        }else{
            $options = array('conditions' => array('Supplier.' . $this->Supplier->primaryKey => $id));
            $this->request->data = $this->Supplier->find('first', $options);
            $this->request->data['Supplier']['idSelect'] = $idSelect;
        }
    }

    
	
	
	function getClients()
    {
        $this->settimeactif();
        $this->layout = 'ajax';
        $suppliers = $this->Supplier->getSuppliersByParams(1, 1, null, null, "all");

        $this->set('selectbox', $suppliers);
        $this->set('selectedid', $this->params['pass']['0']);
        if(isset($this->params['pass']['1'])){
            $this->set('idSelect', $this->params['pass']['1']);
        }

    }


    public function mergeSuppliers($ids = null , $type= null){
        $this->Supplier->validate = $this->Product->validateMerge;
        $supplierIds = explode(",", $ids);
        if (!empty($this->request->data)) {
            $selectedSupplierId= $this->request->data['Supplier']['supplier_id'];
            $notSelectedSupplierIds = array();
            foreach ($supplierIds as $supplierId){
                if($supplierId != $selectedSupplierId){
                    $notSelectedSupplierIds[] = $supplierId;
                }
            }
            $bills = $this->Bill->getBillsByConditions(array('Bill.supplier_id'=>$notSelectedSupplierIds),'all');
            if(!empty($bills)){
                foreach ($bills as $bill){
                    $this->Bill->id = $bill['Bill']['id'];
                    $this->Bill->saveField('supplier_id', $selectedSupplierId);
                }
            }

            $payments = $this->Payment->getPaymentsByConditions(array('Payment.supplier_id'=>$notSelectedSupplierIds));
            if(!empty($payments)){
                foreach ($payments as $payment){
                    $this->Payment->id = $payment['Payment']['id'];
                    $this->Payment->saveField('supplier_id', $selectedSupplierId);
                }
            }



            if($type == 1){
                $transportBills = $this->TransportBill->getTransportBillsByConditions(array('TransportBill.supplier_id'=>$notSelectedSupplierIds),'all');
                if(!empty($transportBills)){
                    foreach ($transportBills as $transportBill){
                        $this->TransportBill->id = $transportBill['TransportBill']['id'];
                        $this->TransportBill->saveField('supplier_id', $selectedSupplierId);
                    }
                }
                $transportBills = $this->TransportBill->getTransportBillsByConditions(array('TransportBill.supplier_final_id'=>$notSelectedSupplierIds),'all');
                if(!empty($transportBills)){
                    foreach ($transportBills as $transportBill){
                        $this->TransportBill->id = $transportBill['TransportBill']['id'];
                        $this->TransportBill->saveField('supplier_id', $selectedSupplierId);
                    }
                }
                $sheetRideDetailRides = $this->SheetRideDetailRides->getSheetRideDetailRidesByConditions(array('SheetRideDetailRides.supplier_id'=>$notSelectedSupplierIds));
                if(!empty($sheetRideDetailRides)){
                    foreach ($sheetRideDetailRides as $sheetRideDetailRide){
                        $this->SheetRideDetailRides->id = $sheetRideDetailRide['SheetRideDetailRides']['id'];
                        $this->SheetRideDetailRides->saveField('supplier_id', $selectedSupplierId);
                    }
                }
                $sheetRideDetailRides = $this->SheetRideDetailRides->getSheetRideDetailRidesByConditions(array('SheetRideDetailRides.supplier_final_id'=>$notSelectedSupplierIds));
                if(!empty($sheetRideDetailRides)){
                    foreach ($sheetRideDetailRides as $sheetRideDetailRide){
                        $this->SheetRideDetailRides->id = $sheetRideDetailRide['SheetRideDetailRides']['id'];
                        $this->SheetRideDetailRides->saveField('supplier_id', $selectedSupplierId);
                    }
                }
                $users = $this->User->find('all',array('conditions'=>array('User.supplier_id'=>$notSelectedSupplierIds),'recursive'=>-1));
                if(!empty($users)){
                    foreach ($users as $user){
                        $this->User->id = $user['User']['id'];
                        $this->User->saveField('supplier_id', $selectedSupplierId);
                    }
                }
                $initialSuppliers = $this->FinalSupplierInitialSupplier->find('all',
                    array(
                        "conditions" => array(
                            "FinalSupplierInitialSupplier.initial_supplier_id " => $notSelectedSupplierIds
                        ),
                        'recursive'=>-1
                    ));
                if(!empty($initialSuppliers)){
                    foreach ($initialSuppliers as $initialSupplier){
                        $this->FinalSupplierInitialSupplier->id = $initialSupplier['FinalSupplierInitialSupplier']['id'];
                        $this->FinalSupplierInitialSupplier->saveField('initial_supplier_id', $selectedSupplierId);
                    }
                }

                $finalSuppliers = $this->FinalSupplierInitialSupplier->find('all',
                    array(
                        "conditions" => array(
                            "FinalSupplierInitialSupplier.final_supplier_id " => $notSelectedSupplierIds
                        ), 'recursive'=>-1
                    ));
                if(!empty($finalSuppliers)){
                    foreach ($finalSuppliers as $finalSupplier){
                        $this->FinalSupplierInitialSupplier->id = $finalSupplier['FinalSupplierInitialSupplier']['id'];
                        $this->FinalSupplierInitialSupplier->saveField('final_supplier_id', $selectedSupplierId);
                    }
                }


                $supplierAttachmentTypes = $this->SupplierAttachmentType->find('all',
                    array(
                        "conditions" => array(
                            "SupplierAttachmentType.supplier_id " => $notSelectedSupplierIds
                        )
                    )
                );

                if(!empty($supplierAttachmentTypes)){
                    foreach ($supplierAttachmentTypes as $supplierAttachmentType){
                        $this->SupplierAttachmentType->id = $supplierAttachmentType['SupplierAttachmentType']['id'];
                        $this->SupplierAttachmentType->saveField('supplier_id', $selectedSupplierId);
                    }
                }


                $supplierAddresses = $this->SupplierAddress->find('all',
                    array(
                        "conditions" => array(
                            "SupplierAddress.supplier_id " => $notSelectedSupplierIds
                        )
                    )
                );
                if(!empty($supplierAddresses)){
                    foreach ($supplierAddresses as $supplierAddress){
                        $this->SupplierAddress->id = $supplierAddress['SupplierAddress']['id'];
                        $this->SupplierAddress->saveField('supplier_id', $selectedSupplierId);
                    }
                }

                $supplierContacts = $this->SupplierContact->find('all',
                    array(
                        "conditions" => array(
                            "SupplierContact.supplier_id " => $notSelectedSupplierIds
                        )
                    )
                );
                if(!empty($supplierContacts)){
                    foreach ($supplierContacts as $supplierContact){
                        $this->SupplierContact->id = $supplierContact['SupplierContact']['id'];
                        $this->SupplierContact->saveField('supplier_id', $selectedSupplierId);
                    }
                }

            }else {
                $param = $this->Parameter->getCodesParameterVal('name_car');
                $cars = $this->Car->getCarsByFieldsAndConds(   $param , null,
                    array('Car.supplier_id'=>$notSelectedSupplierIds), 'all');
                if(!empty($cars)){
                    foreach ($cars as $car){
                        $this->Car->id = $car['Car']['id'];
                        $this->Car->saveField('supplier_id', $selectedSupplierId);
                    }
                }

            }

            foreach ($notSelectedSupplierIds as $notSelectedSupplierId){
                $this->delete($notSelectedSupplierId, null,1);
            }
            $this->Flash->success(__('The merger was successfully completed.'));
            $this->redirect(array('action' => 'index', $type));

        }

        $suppliers = $this->Supplier->getSuppliersByParams( $type, 1, null, null, 'list', null, array('Supplier.id'=>$supplierIds), null);
        $this->set(compact('suppliers','type'));

    }

    function getSupplierCategoryBySupplierId(){
        $this->autoRender = false;
        $supplierId = filter_input(INPUT_POST, "supplierId");
        $isVariousSupplier = $this->Supplier->isVariousSupplier($supplierId);
            if($isVariousSupplier==true){
                echo json_encode(array("response" => "true"));
            }else {
                echo json_encode(array("response" => "false"));
            }

    }




}
