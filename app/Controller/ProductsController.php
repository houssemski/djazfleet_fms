<?php
/**
 * Created by PhpStorm.
 * User: kahina
 * Date: 02/12/2015
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
 * @property Factor $Factor
 * @property Tva $Tva
 * @property Lot $Lot
 * @property ProductFamily $ProductFamily
 * @property ProductCategory $ProductCategory
 * @property ProductType $ProductType
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
class ProductsController extends AppController
{
    public $components = array('Paginator', 'Session', 'RequestHandler', 'Security');
    var $helpers = array('Xls', 'Tinymce');
    public $uses = array('Product', 'ProductCategory','ProductType', 'ProductMark','ProductFamily', 'ProductUnit',
        'Warehouse', 'Profile', 'Tva','PriceCategory','ProductPrice', 'Lot','BillProduct');

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
        $products = $this->Cafyb->getProducts();
        $this->Security->blackHoleCallback = 'blackhole';
        if (Configure::read("cafyb") == '1') {
            if($this->Session->read('Permission.compte.index')==0) {
                $this->Flash->error(__("You don't have permission to consult."));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
                    }else {
                $this->Auth->allow();
                $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

                $products = $this->Cafyb->getAllProducts();
                $users = $this->Cafyb->getUsers();
                $profiles = $this->Cafyb->getUserProfiles();
                $depots = $this->Cafyb->getDepots();
                $productCategories = $this->Cafyb->getProductCategories();
                $productMarks = $this->Cafyb->getProductMarks();
                $productFamilies = $this->Cafyb->getProductFamilies();
                $this->set(compact('profiles', 'limit', 'users', 'depots','productCategories',
                    'productMarks','productFamilies', 'products'));
            }
        }else {
                $user_id = $this->Auth->user('id');
                $result = $this->verifyUserPermission(SectionsEnum::produit, $user_id, ActionsEnum::view,
                    "Products", null, "Product", null);
                $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
                switch ($result) {
                    case 1 :
                        $conditions = null;
                        break;
                    case 2 :
                        $conditions = array('Product.user_id ' => $user_id);
                        break;
                    case 3 :
                        $conditions = array('Product.user_id !=' => $user_id);
                        break;

                    default:
                        $conditions = null;
                }
                $this->paginate = array(
                    'limit' => $limit,
                    'conditions' => $conditions,
                    'order' => array('Product.id' => 'DESC'),
                    'paramType' => 'querystring'
                );
                $this->Product->recursive = 0;
                $this->set('products', $this->Paginator->paginate());
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



    }

    public function products_warehouse()
    {
        $stock = $this->hasModuleStock();
        if($stock==0){
            return $this->redirect('/');
        }

        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Product.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        $this->Product->recursive = 0;
        $this->set('products', $this->Paginator->paginate());
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
        if (isset($this->request->data['keyword']) || isset($this->request->data['Products']['user_id'])
            || isset($this->request->data['Products']['product_family_id']) || isset($this->request->data['Products']['modified_id'])
            || isset($this->request->data['Products']['product_category_id']) || isset($this->request->data['Products']['product_mark_id'])
            || isset($this->request->data['Products']['created']) || isset($this->request->data['Products']['created1'])
            || isset($this->request->data['Products']['modified']) || isset($this->request->data['Products']['modified1'])
            || isset($this->request->data['Products']['warehouse_id'])
        ) {

            $this->filterUrl();
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Product.code' => 'ASC'),
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
                'order' => array('Product.id' => 'DESC'),
                'paramType' => 'querystring'
            );
            $this->Product->recursive = 0;
            $this->set('products', $this->Paginator->paginate());
        } else {
            $this->Product->recursive = 0;
            $this->set('products', $this->Paginator->paginate('Product'));
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


        if (isset($this->request->data['Products']['quantity_id']) && !empty($this->request->data['Products']['quantity_id'])) {
            $filter_url['quantity'] = $this->request->data['Products']['quantity_id'];
            echo($filter_url['quantity']);

        }
        if (isset($this->request->data['Products']['sarehouse_id']) && !empty($this->request->data['Products']['warehouse_id'])) {
            $filter_url['warehouse'] = $this->request->data['Products']['warehouse_id'];

        }

        if (isset($this->request->data['Products']['product_family_id']) && !empty($this->request->data['Products']['product_family_id'])) {
            $filter_url['family'] = $this->request->data['Products']['product_family_id'];

        }

        if (isset($this->request->data['Products']['product_category_id']) && !empty($this->request->data['Products']['product_category_id'])) {
            $filter_url['category'] = $this->request->data['Products']['product_category_id'];

        }
        if (isset($this->request->data['Products']['product_mark_id']) && !empty($this->request->data['Products']['product_mark_id'])) {
            $filter_url['mark'] = $this->request->data['Products']['product_mark_id'];

        }
        if (isset($this->request->data['Products']['user_id']) && !empty($this->request->data['Products']['user_id'])) {
            $filter_url['user'] = $this->request->data['Products']['user_id'];
        }
        if (isset($this->request->data['Products']['created']) && !empty($this->request->data['Products']['created'])) {
            $filter_url['created'] = str_replace("/", "-", $this->request->data['Products']['created']);
        }
        if (isset($this->request->data['Products']['created1']) && !empty($this->request->data['Products']['created1'])) {
            $filter_url['created1'] = str_replace("/", "-", $this->request->data['Products']['created1']);
        }
        if (isset($this->request->data['Products']['modified_id']) && !empty($this->request->data['Products']['modified_id'])) {
            $filter_url['modified_id'] = $this->request->data['Products']['modified_id'];
        }
        if (isset($this->request->data['Products']['modified']) && !empty($this->request->data['Products']['modified'])) {
            $filter_url['modified'] = str_replace("/", "-", $this->request->data['Products']['modified']);
        }
        if (isset($this->request->data['Products']['modified1']) && !empty($this->request->data['Products']['modified1'])) {
            $filter_url['modified1'] = str_replace("/", "-", $this->request->data['Products']['modified1']);
        }
        return $this->redirect($filter_url);
    }

    private function getConds()
    {
        if (!empty($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $conds = array(
                'OR' => array(
                    "LOWER(Product.code) LIKE" => "%$keyword%",
                    "LOWER(Product.name) LIKE" => "%$keyword%"
                )
            );
        } else {
            $conds = array();
        }


        if (isset($this->params['named']['warehouse']) && !empty($this->params['named']['warehouse'])) {
            $conds["Warehouse.id = "] = $this->params['named']['warehouse'];
            $this->request->data['Products']['warehouse_id'] = $this->params['named']['warehouse'];
        }

        if (isset($this->params['named']['family']) && !empty($this->params['named']['family'])) {
            $conds["Product.product_family_id = "] = $this->params['named']['family'];
            $this->request->data['Products']['product_family_id'] = $this->params['named']['family'];
        }

        if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
            $conds["Product.product_category_id = "] = $this->params['named']['category'];
            $this->request->data['Products']['product_category_id'] = $this->params['named']['category'];
        }

        if (isset($this->params['named']['mark']) && !empty($this->params['named']['mark'])) {
            $conds["Product.product_mark_id = "] = $this->params['named']['mark'];
            $this->request->data['Products']['product_mark_id'] = $this->params['named']['mark'];
        }

        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $conds["User.id = "] = $this->params['named']['user'];
            $this->request->data['Products']['user_id'] = $this->params['named']['user'];
        }
        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $creat = str_replace("-", "/", $this->params['named']['created']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Product.created >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Products']['created'] = $creat;
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $creat = str_replace("-", "/", $this->params['named']['created1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Product.created <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Products']['created1'] = $creat;
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $conds["Product.modified_id = "] = $this->params['named']['modified_id'];
            $this->request->data['Products']['modified_id'] = $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Product.modified >= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Products']['modified'] = $creat;
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $creat = str_replace("-", "/", $this->params['named']['modified1']);
            $startdtm = DateTime::createFromFormat('d/m/Y', $creat);
            $conds["Product.modified <= "] = $startdtm->format('Y-m-d 00:00:00');
            $this->request->data['Products']['modified1'] = $creat;
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

        if (Configure::read("cafyb") == '1') {
            $product = $this->Cafyb->getProductById($id);
            $this->set(compact('product'));
        }else {
            if (!$this->Product->exists($id)) {
                throw new NotFoundException(__('Invalid product'));
            }
            $options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id ),'recursive'=>0);
            $product = $this->Product->find('first', $options);
            $this->set('product', $product);
        }



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
        if (Configure::read("cafyb") == '1') {
            if($this->Session->read('Permission.product.add')==0){
                $this->Flash->error(__("You don't have permission to add."));
                return $this->redirect(array('controller' => 'products', 'action' => 'index'));

            }else {
                $this->Auth->allow();
                if ($this->request->is('post')) {
                    $product = $this->request->data['Product'];
                    $this->Cafyb->addProduct($product);

                }
                $productCategories = $this->Cafyb->getProductCategories();
                $productTypes = $this->Cafyb->getProductTypes();
                $productMarks = $this->Cafyb->getProductMarks();
                $productFamilies = $this->Cafyb->getProductFamilies();
                $productUnits = $this->Cafyb->getProductUnits();
                $priceCategories = $this->Cafyb->getPriceCategories('all');
                $tvas = $this->Cafyb->getTvas();
                $depots = $this->Cafyb->getDepots();
                $this->set(compact('productMarks', 'productCategories','productTypes',
                    'tvas', 'depots', 'productFamilies','priceCategories','productUnits'));

            }
        }else {
            $user_id = $this->Auth->user('id');
            $this->verifyUserPermission(SectionsEnum::produit, $user_id, ActionsEnum::add, "Products",
                null, "Product", null);
            $this->Product->validate = $this->Product->validate_add_product;
            $code = $this->getNextProductCode();
            $this->set('code', $code);
            if ($this->request->is('post')) {
                if (isset($this->request->data['cancel'])) {
                    $this->Flash->error(__('Adding was cancelled.'));
                    $this->redirect(array('action' => 'index'));
                }
                $this->verifyAttachment('Product', 'image', 'img/products/', 'add', 1, 0, null);

                $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
                /*if($usePurchaseBill ==1){
                    $lotId = $this->Lot->getLastId();
                    $this->request->data['Product']['id'] = $lotId + 1;
                }*/
                $this->request->data['Product']['code'] = trim($this->request->data['Product']['code']) ;
                $this->request->data['Product']['name'] = trim($this->request->data['Product']['name']) ;
                $this->Product->create();
                if ($this->Product->save($this->request->data)) {
                    $this->Parameter->setNextProductCodeNumber();
                    $productId = $this->Product->getInsertID();
                    $this->Lot->InsertLot($productId);
                    $productPrices = $this->request->data['ProductPrice'];
                    if(!empty($productPrices)){
                        foreach($productPrices as $productPrice){
                            $this->ProductPrice->addProductPrice($productPrice, $productId);
                        }
                    }
                    $this->Flash->success(__('The product has been saved.'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->error(__('The product could not be saved. Please, try again.'));
                    $this->redirect(array('action' => 'index'));
                }
            }
            $productCategories = $this->ProductCategory->getProductCategories();
            $productTypes = $this->ProductType->getProductTypes();
            $productMarks = $this->ProductMark->getProductMarks();
            $productFamilies = $this->ProductFamily->getProductFamilies();
            $productUnits = $this->ProductUnit->getProductUnits();
            $priceCategories = $this->PriceCategory->getPriceCategories('all');
            $tvas = $this->Tva->getTvas();
            $warehouses = $this->Warehouse->getWarehouses();
            $suppliers = $this->Supplier->getSuppliersByParams(0, 1);

            $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
            $this->set(compact('productMarks', 'productCategories','productTypes',
                'tvas', 'warehouses', 'productFamilies','priceCategories','productUnits',
                'usePurchaseBill','suppliers'));
        }


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
        if (Configure::read("cafyb") == '1') {
            if($this->Session->read('Permission.product.edit')==0){
                $this->Flash->error(__("You don't have permission to edit."));
                return $this->redirect(array('controller' => 'products', 'action' => 'index'));

            }else {
                $this->Auth->allow();
                if ($this->request->is(array('post', 'put'))) {
                    $product = $this->request->data['Product'];
                    $this->Cafyb->editProducr($product);

                }else {
                    $product = $this->Cafyb->getProductById($id);
                    $productCategories = $this->Cafyb->getProductCategories();
                    $productTypes = $this->Cafyb->getProductTypes();
                    $productMarks = $this->Cafyb->getProductMarks();
                    $productFamilies = $this->Cafyb->getProductFamilies();
                    $productUnits = $this->Cafyb->getProductUnits();
                    $priceCategories = $this->Cafyb->getPriceCategories('all');
                    $tvas = $this->Cafyb->getTvas();
                    $depots = $this->Cafyb->getDepots();
                    $this->set(compact('product','productMarks', 'productCategories','productTypes',
                        'tvas', 'depots', 'productFamilies','priceCategories','productUnits'));

                }

            }
        }else
        {
            $user_id = $this->Auth->user('id');
            $this->verifyUserPermission(SectionsEnum::produit, $user_id, ActionsEnum::edit, "Products",
                $id, "Product", null);
            $this->Product->validate = $this->Product->validate_add_product;
            if (!$this->Product->exists($id)) {
                throw new NotFoundException(__('Invalid product'));
            }
            $code = $this->getNextProductCode();
            $this->set('code', $code);
            if ($this->request->is(array('post', 'put'))) {
                if (isset($this->request->data['cancel'])) {
                    $this->Flash->error(__('Changes were not saved. Product cancelled.'));
                    $this->redirect(array('action' => 'index'));
                }
                if ($this->request->data['Product']['file'] == '') {
                    $this->deleteAttachment('Product', 'image', 'img/products/', $id);
                    $this->verifyAttachment('Product', 'image', 'img/products/', 'add', 1, 0, $id);
                } else {
                    $this->verifyAttachment('Product', 'image', 'img/products/', 'edit', 1, 0, $id);
                }
                $this->request->data['Product']['code'] = trim($this->request->data['Product']['code']) ;
                $this->request->data['Product']['name'] = trim($this->request->data['Product']['name']) ;
                if ($id != 1 && $this->Product->save($this->request->data)) {
                    $lot = $this->Lot->getLotById($id);
                    if(!empty($lot)){
                        $this->Lot->updateLot($id);
                    }else {
                        $this->Lot->insertLot($id);
                    }

                    $productPrices = $this->request->data['ProductPrice'];
                    if(!empty($productPrices)){
                        foreach($productPrices as $productPrice){
                            if(!empty($productPrice['id'])){
                                $this->ProductPrice->updateProductPrice($productPrice, $id);
                            }else {
                                $this->ProductPrice->addProductPrice($productPrice, $id);
                            }
                        }
                    }
                    $this->Flash->success(__('The product has been saved.'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    // debug($this->validationErrors);
                    $this->Flash->error(__('The product could not be saved. Please, try again.'));
                }
            } else {
                $options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id ),'recursive'=>-1);
                $this->request->data = $this->Product->find('first', $options);
                $productTypeId = $this->request->data['Product']['product_type_id'];
                $productPrices = $this->ProductPrice->getProductPricesByProductId($id);
                $this->set(compact('productPrices','productTypeId'));
            }
            $productCategories = $this->ProductCategory->getProductCategories();
            $productTypes = $this->ProductType->getProductTypes();
            $productMarks = $this->ProductMark->getProductMarks();
            $productFamilies = $this->ProductFamily->getProductFamilies();
            $productUnits = $this->ProductUnit->getProductUnits();
            $priceCategories = $this->PriceCategory->getPriceCategories('all');
            $tvas = $this->Tva->getTvas();
            $warehouses = $this->Warehouse->getWarehouses();
            $suppliers = $this->Supplier->getSuppliersByParams(0, 1);

            $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
            $this->set(compact('productMarks', 'productCategories',
                'productTypes', 'tvas', 'warehouses',
                'productFamilies','priceCategories' ,'productUnits','usePurchaseBill','suppliers'));
        }


        return $this->render();
    }

    /**
     * @param null $id
     * @param null $redirect
     * @return \Cake\Network\Response|null
     */
    public function delete($id = null, $redirect=null)
    {
        $stock = $this->hasModuleStock();
        if($stock==0){
            return $this->redirect('/');
        }
        if (Configure::read("cafyb") == '1') {
            if($this->Session->read('Permission.product.delete')==0){
                $this->Flash->error(__("You don't have permission to delete."));
                return $this->redirect(array('controller' => 'products', 'action' => 'index'));

            }else {
                $this->Auth->allow();
                $this->Cafyb->deleteProduct($id);


            }
        }else {
            $this->Product->id = $id;
            $this->verifyDependences($id);
            if (!$this->Product->exists()) {
                throw new NotFoundException(__('Invalid Product'));
            }
            $user_id = $this->Auth->user('id');
            $this->verifyUserPermission(SectionsEnum::produit, $user_id, ActionsEnum::delete,
                "Products", $id, "Product", null);
            $this->request->allowMethod('post', 'delete');
            $this->Lot->deleteAll(array('Lot.product_id' => $id), false);
            if ( $id != 1 && $this->Product->delete()  ) {
                $this->Flash->success(__('The product has been deleted.'));
            } else {
                $this->Flash->error(__('The product could not be deleted. Please, try again.'));
            }
            if(!$redirect) {
                return $this->redirect(array('action' => 'index'));
            }
        }


    }

    /**
     * @return void
     */
    public function deleteproducts()
    {
        $stock = $this->hasModuleStock();
        if($stock==0){
            $this->redirect('/');
        }

        if (Configure::read("cafyb") == '1') {
            if($this->Session->read('Permission.product.delete')==0){
                $this->Flash->error(__("You don't have permission to delete."));
                return $this->redirect(array('controller' => 'products', 'action' => 'index'));

            }else {
                $this->Auth->allow();
                $id = filter_input(INPUT_POST, "id");
                $this->Cafyb->deleteProduct($id);


            }
        }else
        {
            $user_id = $this->Auth->user('id');
            $this->autoRender = false;
            $id = filter_input(INPUT_POST, "id");
            $this->verifyUserPermission(SectionsEnum::produit, $user_id, ActionsEnum::delete,
                "Products", $id, "Product", null);
            $this->Product->id = $id;
            $this->verifyDependences($id);
            $this->request->allowMethod('post', 'delete');
            $this->Lot->deleteAll(array('Lot.product_id' => $id), false);
            if ($id != 1 && $this->Product->delete()) {
                echo json_encode(array("response" => "true"));
            } else {
                echo json_encode(array("response" => "false"));
            }
        }


    }

    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $this->loadModel('BillProduct');
        $lots = $this->Lot->getLotsByConditions(array('Lot.product_id' => $id), "all");

        foreach ($lots as $lot){
            $result = $this->BillProduct->getBillProductsByLotId($lot['Lot']['id']);
            if (!empty($result)) {
                $this->Flash->error(__('The product could not be deleted. Please remove dependencies in advance.'));
                $this->redirect(array('action' => 'index'));
            }
            $result = $this->TransportBillDetailRides->getTransportBillDetailRidesByLotId($lot['Lot']['id']);
            if (!empty($result)) {
                $this->Flash->error(__('The product could not be deleted. Please remove dependencies in advance.'));
                $this->redirect(array('action' => 'index'));
            }
        }

    }

    function addCategory()
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::categorie_produit, $user_id, ActionsEnum::add, "ProductCategories", null, "ProductCategory", null,1);
        $this->set('result',$result);
        $this->setTimeActif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->ProductCategory->create();
            if ($this->ProductCategory->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $categoryId = $this->ProductCategory->getLastInsertId();
                $this->set('categoryId', $categoryId);
            }
        }

    }

    function getCategories()
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        $types = $this->ProductCategory->find('all', array('recursive' => -1));
        $this->set('selectbox', $types);
        $this->set('selectedid', $this->params['pass']['0']);
    }

    function addMark()
    {
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::marque_produit, $userId, ActionsEnum::add, "ProductMarks", null, "ProductMark", null,1);
        $this->set('result',$result);
        $this->setTimeActif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->ProductMark->create();
            if ($this->ProductMark->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $mark_id = $this->ProductMark->getLastInsertId();
                $this->set('mark_id', $mark_id);
            }
        }
    }

    function getMarks()
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        $marks = $this->ProductMark->getProductMarks('all');
        $this->set('selectbox', $marks);
        $this->set('selectedid', $this->params['pass']['0']);
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

    function addFamily()
    {
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::famille_produit, $user_id, ActionsEnum::add, "ProductMarks", null, "ProductMark", null,1);
        $this->set('result',$result);
        $this->setTimeActif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->ProductFamily->create();
            if ($this->ProductFamily->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $family_id = $this->ProductFamily->getLastInsertId();
                $this->set('family_id', $family_id);
            }
        }
    }

    function getFamilies()
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        $marks = $this->ProductFamily->getProductFamilies('all');
        $this->set('selectbox', $marks);
        $this->set('selectedid', $this->params['pass']['0']);
    }

    function addWarehouse()
    {
        $this->setTimeActif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->Warehouse->create();
            if ($this->Warehouse->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $warehouseId = $this->Warehouse->getLastInsertId();
                $this->set('warehouseId', $warehouseId);
            }
        }
    }

    function getWarehouses()
    {
        $this->setTimeActif();
        $this->layout = 'ajax';
        $warehouses = $this->Warehouse->find('all', array('recursive' => -1));
        $this->set('selectbox', $warehouses);
        $this->set('selectedid', $this->params['pass']['0']);
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

    public function editDescription($productId = null, $i = null , $description = null)
    {
        $this->set('saved', false);

        if (!empty($this->request->data['TransportBillDetailRides']['description'])
        ) {

            $this->set('newDescription', $this->request->data['TransportBillDetailRides']['description']);
            $this->set('i', $i);
            $this->set('saved', true);
        }
        $product = $this->Product->getProductById($productId);
        $this->set(compact('product', 'i', 'description'));
    }

    public function mergeProducts($ids = null){
        $this->Product->validate = $this->Product->validateMerge;
        $productIds = explode(",", $ids);
        if (!empty($this->request->data)) {
            $selectedProductId= $this->request->data['Product']['product_id'];
            $product = $this->Product->getProductById($selectedProductId);
            $productWithLot = $product['Product']['with_lot'];
            $usePurchaseBill = $this->Parameter->getCodesParameterVal('use_purchase_bill');
            $notSelectedProductIds = array();
            foreach ($productIds as $productId){
                if($productId != $selectedProductId){
                    $notSelectedProductIds[] = $productId;
                }
            }

            $billProducts = $this->BillProduct->getDetailedBillProductsByConditions(array('Lot.product_id'=>$notSelectedProductIds));
            if(!empty($billProducts)){

                foreach ($billProducts as $billProduct){
                    if ($usePurchaseBill == 1) {
                        if ($productWithLot == 1) {
                            $lotId = $product['lot_id'];
                        } else {
                            $lotId = $product['product_id'];
                        }
                    } else {
                        $lotId = $product['product_id'];
                    }
                    $this->BillProduct->id = $billProduct['BillProduct']['id'];
                    $this->BillProduct->saveField('lot_id', $lotId);
                }
            }


            $transportBillDetailRides = $this->TransportBillDetailRides->geDetailedTBDRByConditions(array('Lot.product_id'=>$notSelectedProductIds));
            if(!empty($transportBillDetailRides)){

                foreach ($transportBillDetailRides as $transportBillDetailRide){
                    if ($usePurchaseBill == 1) {
                        if ($productWithLot == 1) {
                            $lotId = $product['lot_id'];
                        } else {
                            $lotId = $product['product_id'];
                        }
                    } else {
                        $lotId = $product['product_id'];
                    }
                    $this->TransportBillDetailRides->id = $transportBillDetailRide['TransportBillDetailRides']['id'];
                    $this->TransportBillDetailRides->saveField('lot_id', $lotId);
                }
            }

            foreach ($notSelectedProductIds as $notSelectedProductId){
                $this->delete($notSelectedProductId, 1);
            }

            $this->Flash->success(__('The merger was successfully completed.'));
            $this->redirect(array('action' => 'index'));

        }
        $products = $this->Product->getProductsByConditions(array('Product.id'=>$productIds));
        $this->set(compact('products'));

    }

    public function liste( $id = null, $keyword = null)
    {

        $keyword = str_replace('espace', ' ', $keyword);
        $keyword = str_replace('slash', '/', $keyword);
        $keyword = str_replace('tiret', '-', $keyword);
        $keyword = str_replace('bouton_num', '°', $keyword);
        $keyword = strtolower($keyword);
        $this->layout = 'ajax';
        $limit = $this->getLimit();
        switch ($id) {
            case 2 :
                $conditions = array("LOWER(Product.code) LIKE" => "%$keyword%");

                break;
            case 3 :
                $conditions = array("LOWER(Product.name) LIKE" => "%$keyword%");
                break;
            case 4 :
                $conditions = array("LOWER(ProductFamily.name) LIKE" => "%$keyword%");
                break;

            case 5 :
                $conditions = array("LOWER(Tva.name) LIKE" => "%$keyword%");

                break;

            case 6 :
                $conditions = array("LOWER(Product.quantity) LIKE" => "%$keyword%");
                break;
            case 7 :
                $conditions = array("LOWER(Product.quantity_min) LIKE" => "%$keyword%");
                break;

            case 8 :
                $conditions = array("LOWER(Product.quantity_max) LIKE" => "%$keyword%");
                break;

            case 9 :
                $conditions = array("LOWER(Product.pmp) LIKE" => "%$keyword%");
                break;

            default:
                $conditions = array("LOWER(Product.code) LIKE" => "%$keyword%");
        }
        $this->paginate = array(
            'limit' => $limit,
            'conditions' => $conditions,
            'order' => array('Product.id' => 'DESC'),
            'paramType' => 'querystring'
        );
        $this->Product->recursive = 0;
        $this->set('products', $this->Paginator->paginate());
    }

    public function ProductCard($id){
        $product = $this->Product->getProductById($id);
        $billProducts = $this->BillProduct->getDetailedBillsByConditions(array('Lot.product_id ' => $id),'all', 'Bill.date ASC');
        $this->set(compact('product','billProducts'));
    }

    public function getFieldsByProductType($productTypeId = null){

        switch ($productTypeId){
            case 2 :
                $this->Product->validate = $this->Product->validate_product_location;
                break;
            case 3 :
                $this->Product->validate = $this->Product->validate_product_mobilisation;
                break;
        }

        $this->set(compact('productTypeId'));
    }

}