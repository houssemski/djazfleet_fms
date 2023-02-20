<?php

App::uses('AppController', 'Controller');

/**
 * ProductUnit Controller
 *
 * @property Factor $Factor
 * @property ProductPriceFactor $ProductPriceFactor
 * @property Lot $Lot
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class FactorsController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    var $helpers = array('Xls');

    /**
     * @param null $params
     * @param null $orderType
     * @return array
     */

    public function getOrder($params = null , $orderType = null)
    {
        if($orderType == null){
            $orderType = 'DESC';
        }
        if (isset($params) && is_numeric($params)) {
            switch ($params) {
                case 1 :
                    $order = array('Factor.code' => $orderType);
                    break;
                case 2 :
                    $order = array('Factor.name' => $orderType);
                    break;
                case 3 :
                    $order = array('Factor.id' => $orderType);
                    break;

                default :
                    $order = array('Factor.id' => $orderType);
            }
            return $order;
        } else {
            $order = array('Factor.id' => $orderType);

            return $order;
        }
    }

    public function index()
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::product_unit, $user_id, ActionsEnum::view,
            "Factors", null, "Factor", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();
        switch ($result) {
            case 1 :

                $conditions = null;
                break;
            case 2 :

                $conditions = array('Factor.user_id ' => $user_id);
                break;
            case 3 :

                $conditions = array('Factor.user_id !=' => $user_id);

                break;

            default:
                $conditions = null;

        }

        $this->paginate = array(
            'recursive' => 0,
            'limit' => $limit,
            'order' => $order,
            'conditions' => $conditions,
            'paramType' => 'querystring'
        );

        $this->set('factors', $this->Paginator->paginate());
        $this->set(compact('limit', 'order'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function search()
    {
        $this->setTimeActif();
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'],
                $this->request->params['action'], $this->request->data['keyword']);
        }
        $this->paginate = array(
            'recursive' => 0,
            'limit' => $limit,
            'order' => array('Factor.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('productUnits', $this->Paginator->paginate('ProductUnit', array(
                'OR' => array(
                    "LOWER(Factor.name) LIKE" => "%$keyword%"
                )
            )));
        } else {
            $this->set('factors', $this->Paginator->paginate());
        }
        $this->set(compact('limit'));
        $this->render();
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

        if (!$this->Factor->exists($id)) {
            throw new NotFoundException(__('Invalid factor'));
        }
        $options = array('conditions' => array('Factor.' . $this->Factor->primaryKey => $id));
        $this->set('Factor', $this->Factor->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::product_unit, $user_id, ActionsEnum::add,
            "Factors", null, "Factor", null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->success(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Factor->create();
            if($this->request->data['Factor']['factor_type']==2){

            }
            $this->request->data['Factor']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Factor->save($this->request->data)) {

                $this->Flash->success(__('The factor has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->success(__('The factor could not be saved. Please, try again.'));
            }
        }
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
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::product_unit, $user_id, ActionsEnum::edit,
            "Factors", $id, "Factor", null);
        if (!$this->Factor->exists($id)) {
            throw new NotFoundException(__('Invalid factor'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Factor cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Factor']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Factor->save($this->request->data)) {

                $this->Flash->success(__('The factor has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The factor could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Factor.' . $this->Factor->primaryKey => $id));
            $this->request->data = $this->Factor->find('first', $options);
        }
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
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::product_unit, $user_id, ActionsEnum::delete,
            "Factors", $id, "Factor", null);
        $this->Factor->id = $id;
        if (!$this->Factor->exists()) {
            throw new NotFoundException(__('Invalid factor'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Factor->delete()) {

            $this->Flash->success(__('The factor has been deleted.'));
        } else {

            $this->Flash->error(__('The factor could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteFactors()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');

        $this->verifyUserPermission(SectionsEnum::product_unit, $user_id, ActionsEnum::delete,
            "Factors", $id, "Factor", null);
        $this->Factor->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Factor->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }
        /*}else{
            echo json_encode(array("response" => "false"));
        }*/
    }

    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $this->loadModel('ProductPriceFactor');
        $result = $this->ProductPriceFactor->getProductPriceFactorByForeignKey($id, "factor_id");
        if (!empty($result)) {
            $this->Flash->error(__('The factor could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }

    }

    function export()
    {
        $this->setTimeActif();
        $factors = $this->Factor->find('all', array(
            'order' => 'Factor.name asc',
            'recursive' => 2
        ));
        $this->set('models', $factors);
    }

    function getFactorType($type){
        $this->layout = 'ajax';
        if($type == 2){
            $models = App::objects('Model');
            $this->set('models',$models);
        }
        $this->set('type',$type);
    }

}