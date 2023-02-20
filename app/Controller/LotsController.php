<?php
/**
 * Created by PhpStorm.
 * User: kahina
 * Date: 31/01/2019
 * Time: 14:26
 */
App::uses('AppController', 'Controller');

/**
 * Cars Controller
 *
 * @property Product $Product
 * @property ProductMark $ProductMark
 * @property ProductUnit $ProductUnit
 * @property Warehouse $Warehouse
 * @property Tva $Tva
 * @property Lot $Lot
 * @property LotType $LotType
 * @property ProductFamily $ProductFamily
 * @property ProductCategory $ProductCategory
 * @property BillProduct $BillProduct
 * @property User $User
 * @property ProductPrice $ProductPrice
 * @property PriceCategory $PriceCategory
 * @property Profile $Profile
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class LotsController extends AppController
{
    public $components = array('Paginator', 'Session', 'RequestHandler', 'Security');
    var $helpers = array('Xls');
    public $uses = array('Lot','Product', 'ProductCategory', 'ProductMark','ProductFamily', 'ProductUnit',
        'Warehouse', 'Profile', 'Tva','PriceCategory','ProductPrice', 'Lot', 'LotType');

    /**
     * Action index
     *
     * @return void
     */
    public function index()
    {
        $stock = $this->hasModuleStock();
        if($stock==0){
            $this->redirect('/');
        }
        $this->Security->blackHoleCallback = 'blackhole';
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::produit, $user_id, ActionsEnum::view,
            "Lots", null, "Lot", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        switch ($result) {
            case 1 :
                $conditions = null;
                break;
            case 2 :
                $conditions = array('Lot.user_id ' => $user_id);
                break;
            case 3 :
                $conditions = array('Lot.user_id !=' => $user_id);
                break;

            default:
                $conditions = null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'conditions' => $conditions,
            'order' => array('Lot.id' => 'DESC'),
            'paramType' => 'querystring'
        );
        $this->Lot->recursive = 0;
        $this->set('lots', $this->Paginator->paginate());
        $users = $this->User->getUsers();
        $profiles = $this->Profile->getUserProfiles();
        $warehouses = $this->Warehouse->getWarehouses();
        $productCategories = $this->ProductCategory->getProductCategories();
        $productMarks = $this->ProductMark->getProductMarks();
        $productFamilies = $this->ProductFamily->getProductFamilies();
        $isSuperAdmin = $this->isSuperAdmin();
        $this->set(compact('profiles', 'limit', 'users', 'warehouses','productCategories',
            'productMarks','productFamilies','isSuperAdmin'));

    }

    public function Lots_depot()
    {
        $stock = $this->hasModuleStock();
        if($stock==0){
            return $this->redirect('/');
        }

        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Lot.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        $this->Lot->recursive = 0;
        $this->set('lots', $this->Paginator->paginate());
        $this->set(compact('limit'));

        return $this->render();
    }
    /**
     * Search action
     */
    public function search()
    {
        $stock = $this->hasModuleStock();
        if($stock==0){
            return $this->redirect('/');
        }
        $this->setTimeActif();
        if (isset($this->request->data['keyword']) || isset($this->request->data['Lots']['user_id'])
            || isset($this->request->data['Lots']['product_family_id']) || isset($this->request->data['Lots']['modified_id'])
            || isset($this->request->data['Lots']['product_category_id']) || isset($this->request->data['Lots']['product_mark_id'])
            || isset($this->request->data['Lots']['created']) || isset($this->request->data['Lots']['created1'])
            || isset($this->request->data['Lots']['modified']) || isset($this->request->data['Lots']['modified1'])
            || isset($this->request->data['Lots']['warehouse_id'])
        ) {

            $this->filterUrl();
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Lot.code' => 'ASC'),
            'paramType' => 'querystring'
        );

        if (isset($this->params['named']['keyword']) || isset($this->params['named']['user'])
            || isset($this->params['named']['family']) || isset($this->params['named']['category']) || isset($this->params['named']['mark'])
            || isset($this->params['named']['created']) || isset($this->params['named']['created1'])
            || isset($this->params['named']['warehouse']) || isset($this->params['named']['modified_id'])
            || isset($this->params['named']['modified']) || isset($this->params['named']['modified1'])
        ) {
            $conditions = $this->getConds();
            $this->paginate = array(
                'limit' => $limit,
                'conditions' => $conditions,
                'order' => array('Lot.id' => 'DESC'),
                'paramType' => 'querystring'
            );
            $this->Lot->recursive = 0;
            $this->set('lots', $this->Paginator->paginate());
        } else {
            $this->Lot->recursive = 0;
            $this->set('lots', $this->Paginator->paginate('Lot'));
        }

        $users = $this->User->getUsers();
        $profiles = $this->Profile->getUserProfiles();
        $warehouses = $this->Warehouse->getWarehouses();
        $productCategories = $this->ProductCategory->getProductCategories();
        $productMarks = $this->ProductMark->getProductMarks();
        $productFamilies = $this->ProductFamily->getProductFamilies();
        $isSuperAdmin = $this->isSuperAdmin();
        $this->set(compact('users', 'limit', 'warehouses', 'profiles','productCategories','productMarks','productFamilies','isSuperAdmin'));

        return $this->render();
    }

    private function filterUrl()
    {
        $filter_url['controller'] = $this->request->params['controller'];
        $filter_url['action'] = $this->request->params['action'];
        $filter_url['page'] = 1;
        $filter_url['keyword'] = $this->request->data['keyword'];


        if (isset($this->request->data['Lots']['quantity_id']) && !empty($this->request->data['Lots']['quantity_id'])) {
            $filter_url['quantity'] = $this->request->data['Lots']['quantity_id'];
            echo($filter_url['quantity']);

        }
        if (isset($this->request->data['Lots']['warehouse_id']) && !empty($this->request->data['Lots']['warehouse_id'])) {
            $filter_url['warehouse'] = $this->request->data['Lots']['warehouse_id'];

        }

        if (isset($this->request->data['Lots']['product_family_id']) && !empty($this->request->data['Lots']['product_family_id'])) {
            $filter_url['family'] = $this->request->data['Lots']['product_family_id'];

        }

        if (isset($this->request->data['Lots']['product_category_id']) && !empty($this->request->data['Lots']['product_category_id'])) {
            $filter_url['category'] = $this->request->data['Lots']['product_category_id'];

        }
        if (isset($this->request->data['Lots']['product_mark_id']) && !empty($this->request->data['Lots']['product_mark_id'])) {
            $filter_url['mark'] = $this->request->data['Lots']['product_mark_id'];

        }
        if (isset($this->request->data['Lots']['user_id']) && !empty($this->request->data['Lots']['user_id'])) {
            $filter_url['user'] = $this->request->data['Lots']['user_id'];
        }
        if (isset($this->request->data['Lots']['created']) && !empty($this->request->data['Lots']['created'])) {
            $filter_url['created'] = str_replace("/", "-", $this->request->data['Lots']['created']);
        }
        if (isset($this->request->data['Lots']['created1']) && !empty($this->request->data['Lots']['created1'])) {
            $filter_url['created1'] = str_replace("/", "-", $this->request->data['Lots']['created1']);
        }
        if (isset($this->request->data['Lots']['modified_id']) && !empty($this->request->data['Lots']['modified_id'])) {
            $filter_url['modified_id'] = $this->request->data['Lots']['modified_id'];
        }
        if (isset($this->request->data['Lots']['modified']) && !empty($this->request->data['Lots']['modified'])) {
            $filter_url['modified'] = str_replace("/", "-", $this->request->data['Lots']['modified']);
        }
        if (isset($this->request->data['Lots']['modified1']) && !empty($this->request->data['Lots']['modified1'])) {
            $filter_url['modified1'] = str_replace("/", "-", $this->request->data['Lots']['modified1']);
        }
        return $this->redirect($filter_url);
    }

    private function getConds()
    {
        if (!empty($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $conds = array(
                'OR' => array(
                    "LOWER(Lot.code) LIKE" => "%$keyword%",
                    "LOWER(Lot.name) LIKE" => "%$keyword%"
                )
            );
        } else {
            $conds = array();
        }


        if (isset($this->params['named']['warehouse']) && !empty($this->params['named']['warehouse'])) {
            $conds["Warehouse.id = "] = $this->params['named']['warehouse'];
            $this->request->data['Lots']['warehouse_id'] = $this->params['named']['warehouse'];
        }

        if (isset($this->params['named']['family']) && !empty($this->params['named']['family'])) {
            $conds["Lot.product_family_id = "] = $this->params['named']['family'];
            $this->request->data['Lots']['product_family_id'] = $this->params['named']['family'];
        }

        if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
            $conds["Lot.product_category_id = "] = $this->params['named']['category'];
            $this->request->data['Lots']['product_category_id'] = $this->params['named']['category'];
        }

        if (isset($this->params['named']['mark']) && !empty($this->params['named']['mark'])) {
            $conds["Lot.product_mark_id = "] = $this->params['named']['mark'];
            $this->request->data['Lots']['product_mark_id'] = $this->params['named']['mark'];
        }

        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $conds["User.id = "] = $this->params['named']['user'];
            $this->request->data['Lots']['user_id'] = $this->params['named']['user'];
        }
        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $creat = str_replace("-", "/", $this->params['named']['created']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Lot.created >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Lots']['created'] = $creat;
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $creat = str_replace("-", "/", $this->params['named']['created1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Lot.created <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Lots']['created1'] = $creat;
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $conds["Lot.modified_id = "] = $this->params['named']['modified_id'];
            $this->request->data['Lots']['modified_id'] = $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Lot.modified >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Lots']['modified'] = $creat;
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Lot.modified <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Lots']['modified1'] = $creat;
        }

        return $conds;

    }

    /**
     * View action
     *
     * @param int|null $id
     * @return null
     */
    public function view($id = null)
    {
        $stock = $this->hasModuleStock();
        if($stock==0){
            return $this->redirect('/');
        }

        if (!$this->Lot->exists($id)) {
            throw new NotFoundException(__('Invalid lot'));
        }
        $options = array('conditions' => array('Lot.' . $this->Lot->primaryKey => $id));
        $this->set('lot', $this->Lot->find('first', $options));

        return $this->render();
    }
    /**
     * Add action
     */
    public function add()
    {
        $stock = $this->hasModuleStock();
        if($stock==0){
            return $this->redirect('/');
        }
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::produit, $user_id, ActionsEnum::add, "Lots",
            null, "Lot", null);
        $this->createDateFromDate('Lot', 'production_date');
        $this->createDateFromDate('Lot', 'expiration_date');
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Lot->create();
            if ($this->Lot->save($this->request->data)) {
                $this->Flash->success(__('The lot has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The lot could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index'));
            }
        }
        $lotTypes = $this->LotType->getLotTypes();
        $productUnits = $this->ProductUnit->getProductUnits();
		
		$conditions = array('Product.with_lot'=>1,'Product.blocked'=>0 );
        $products = $this->Product->getProductsByConditions($conditions,'list');
        $tvas = $this->Tva->getTvas();
        $this->set(compact(  'tvas', 'lotTypes', 'productUnits' , 'products'));

        return $this->render();
    }
    /**
     * Edit action
     *
     * @param int|null $id
     * @return null
     */
    public function edit($id = null)
    {
        $stock = $this->hasModuleStock();
        if($stock==0){
            return $this->redirect('/');
        }
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::produit, $user_id, ActionsEnum::edit, "Lots",
            $id, "Lot", null);
        $this->createDateFromDate('Lot', 'production_date');
        $this->createDateFromDate('Lot', 'expiration_date');
        if (!$this->Lot->exists($id)) {
            throw new NotFoundException(__('Invalid lot'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Lot cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            if ($this->Lot->save($this->request->data)) {

                $this->Flash->success(__('The lot has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The lot could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Lot.' . $this->Lot->primaryKey => $id));
            $this->request->data = $this->Lot->find('first', $options);

        }

        $lotTypes = $this->LotType->getLotTypes();
        $productUnits = $this->ProductUnit->getProductUnits();
        $conditions = array('Product.with_lot'=>1,'Product.blocked'=>0 );
        $products = $this->Product->getProductsByConditions($conditions,'list');
        $tvas = $this->Tva->getTvas();
        $this->set(compact(  'tvas', 'lotTypes', 'productUnits' , 'products'));

        return $this->render();
    }

    /**
     * delete action
     *
     * @param int|null $id
     * @return null
     */
    public function delete($id = null)
    {
        $stock = $this->hasModuleStock();
        if($stock==0){
            return $this->redirect('/');
        }
        $this->Lot->id = $id;
        $this->verifyDependences($id);
        if (!$this->Lot->exists()) {
            throw new NotFoundException(__('Invalid lot'));
        }
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::produit, $user_id, ActionsEnum::delete,
            "Lots", $id, "Lot", null);
        $this->request->allowMethod('post', 'delete');
        if ($this->Lot->delete()) {
            $this->Flash->success(__('The lot has been deleted.'));
        } else {
            $this->Flash->error(__('The lot could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));

    }

    /**
     * @return void
     */
    public function deleteLots()
    {
        $stock = $this->hasModuleStock();
        if($stock==0){
            $this->redirect('/');
        }

        $user_id = $this->Auth->user('id');
        $this->autoRender = false;

        $id = filter_input(INPUT_POST, "id");
        $this->verifyUserPermission(SectionsEnum::produit, $user_id, ActionsEnum::delete,
            "Lots", $id, "Lot", null);

        $this->Lot->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Lot->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }

    }

    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $this->loadModel('BillProduct');
        $result = $this->BillProduct->getBillProductsByLotId($id);
        if (!empty($result)) {
            $this->Flash->error(__('The lot could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
    }

    function addType()
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::categorie_produit, $user_id, ActionsEnum::add, "LotTypes", null, "LotType", null,1);
        $this->set('result',$result);
        $this->setTimeActif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->LotType->create();
            if ($this->LotType->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $typeId = $this->LotType->getLastInsertId();
                $this->set('typeId', $typeId);
            }
        }

    }

    function getTypes()
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        $types = $this->LotType->getLotTypes('all');
        $this->set('selectBox', $types);
        $this->set('selectedId', $this->params['pass']['0']);
    }



    function addUnit()
    {
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::marque_produit, $userId, ActionsEnum::add, "ProductUnits", null, "ProductUnit", null,1);
        $this->set('result',$result);
        $this->setTimeActif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->ProductUnit->create();
            if ($this->ProductUnit->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $unitId = $this->ProductUnit->getLastInsertId();
                $this->set('unitId', $unitId);
            }
        }
    }

    function getUnits()
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        $units = $this->ProductUnit->getProductUnits('all');
        $this->set('selectBox', $units);
        $this->set('selectedId', $this->params['pass']['0']);
    }

    function addProduct()
    {
        $this->loadModel('ProductFamily');

        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::produit, $userId, ActionsEnum::add, "Products",
            null, "Product", null, 1);

        $this->set('result', $result);
        $this->Product->validate = $this->Product->validate_add_product;
        $this->setTimeActif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened

        if (!empty($this->request->data)) {
            $this->Product->create();
            $this->request->data['Product']['with_lot'] = 1;
            if ($this->Product->save($this->request->data)) {

                $this->set('saved', true); //only set true if data saves OK
                $productId = $this->Product->getLastInsertId();
                $this->set('productId', $productId);
            }
        }
        $tvas = $this->Tva->getTvas(null, 'list', null);
        $productFamilies = $this->ProductFamily->getProductFamilies();
        $this->set(compact('tvas', 'productFamilies' ));

    }

    function getProducts()
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        $products = $this->Product->getProducts();
        $this->set('selectBox', $products);
        $this->set('selectedId', $this->params['pass']['0']);
    }


    public function export()
    {
        if (isset($this->params['pass']['0']) && $this->params['pass']['0'] == "all") {
            $products = $this->Product->find('all', array(
                'recursive' => 0,
                'order' => array('Product.code' => 'ASC'),
            ));
        } else {
            $ids = filter_input(INPUT_POST, "chkids");
            $array_ids = explode(",", $ids);
            $products = $this->Product->find('all', array(
                'recursive' => 0,
                'order' => array('Product.code' => 'ASC'),
                'conditions' => array(
                    "Product.id" => $array_ids,
                ),
            ));

        }

        $this->set('models', $products);
    }
}