<?php

App::uses('AppController', 'Controller');

/**
 * Daira Controller
 *
 * @property Daira $Daira
 * @property Wilaya $Wilaya
 * @property Destination $Destination
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class ProductWarehousesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    var $helpers = array('Xls');
    public $uses = array('ProductWarehouse', 'Product','Warehouse');
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();


        //Parametrer la pagination
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('ProductWarehouse.warehouse_id' => 'ASC'),
            'paramType' => 'querystring',
            'fields'=>array(
                'Product.name','Warehouse.name', 'ProductWarehouse.id', 'ProductWarehouse.quantity'
            ),
            'recursive'=>-1,
            'joins' => array(
                array(
                    'table' => 'products',
                    'type' => 'left',
                    'alias' => 'Product',
                    'conditions' => array('Product.id = ProductWarehouse.product_id')
                ),
                array(
                    'table' => 'warehouses',
                    'type' => 'left',
                    'alias' => 'Warehouse',
                    'conditions' => array('Warehouse.id = ProductWarehouse.warehouse_id')
                ),
            )
        );
        $this->set('productWarehouses', $this->Paginator->paginate());
        $this->set(compact('limit'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function search() {
        $this->setTimeActif();
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'],
                $this->request->params['action'], $this->request->data['keyword']);
        }

        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));


            $conditions = array('OR' => array(
                "LOWER(Product.name) LIKE" => "%$keyword%",
                "LOWER(Warehouse.name) LIKE" => "%$keyword%"));
            $this->paginate = array(
                'limit' => $limit,
                'conditions'=>$conditions,
                'order' => array('ProductWarehouse.warehouse_id' => 'ASC'),
                'paramType' => 'querystring',
                'fields'=>array(
                    'Product.name','Warehouse.name', 'ProductWarehouse.id', 'ProductWarehouse.quantity'
                ),
                'recursive'=>-1,
                'joins' => array(
                    array(
                        'table' => 'products',
                        'type' => 'left',
                        'alias' => 'Product',
                        'conditions' => array('Product.id = ProductWarehouse.product_id')
                    ),
                    array(
                        'table' => 'warehouses',
                        'type' => 'left',
                        'alias' => 'Warehouse',
                        'conditions' => array('Warehouse.id = ProductWarehouse.warehouse_id')
                    ),
                )
            );
            $this->set('productWarehouses', $this->Paginator->paginate());
        } else {
            $this->paginate = array(
                'limit' => $limit,
                'order' => array('ProductWarehouse.warehouse_id' => 'ASC'),
                'paramType' => 'querystring',
                'fields'=>array(
                    'Product.name','Warehouse.name', 'ProductWarehouse.id', 'ProductWarehouse.quantity'
                ),
                'recursive'=>-1,
                'joins' => array(
                    array(
                        'table' => 'products',
                        'type' => 'left',
                        'alias' => 'Product',
                        'conditions' => array('Product.id = ProductWarehouse.product_id')
                    ),
                    array(
                        'table' => 'warehouses',
                        'type' => 'left',
                        'alias' => 'Warehouse',
                        'conditions' => array('Warehouse.id = ProductWarehouse.warehouse_id')
                    ),
                )
            );
            $this->set('productWarehouses', $this->Paginator->paginate());
        }
        $this->set(compact('limit'));
        $this->render();
    }





}
