<?php
/**
 * Created by PhpStorm.
 * User: kahina
 * Date: 30-12-2019
 * Time: 14:36
 */


App::uses('AppController', 'Controller');
class CurrenciesController extends AppController {


    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    var $helpers = array('Xls');


    public function getOrder ($params = null , $orderType = null){

        if($orderType == null){
            $orderType = 'DESC';
        }
        if (isset($params) && is_numeric($params)) {
            switch($params){
                case 1 :
                    $order = array('Currency.abr' => $orderType);
                    break;
                case 2 :
                    $order = array('Currency.name' => $orderType);
                    break;
                case 3 :
                    $order = array('Currency.id' => $orderType);
                    break;


                default : $order = array('Currency.id' => $orderType);
            }
            return $order;
        } else {
            $order = array('Currency.id' => $orderType);

            return $order;
        }
    }
    public function index() {
        $this->setTimeActif();
        $this->verifySuperAdministrator();
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $order = isset($this->params['pass']['1']) ? $this->getOrder($this->params['pass']['1'],$this->params['pass']['2']) : $this->getOrder();



        $this->paginate = array(
            'limit' => $limit,
            'order' => $order,
            'paramType' => 'querystring'
        );



        //Parametrer la pagination

        $this->Currency->recursive = 0;
        $this->set('currencies', $this->Paginator->paginate());
        $this->set(compact('limit','order'));
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
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Currency.abr' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('currencies', $this->Paginator->paginate('Currency', array('OR' => array(
                "LOWER(Currency.abr) LIKE" => "%$keyword%",
                "LOWER(Currency.name) LIKE" => "%$keyword%"))));
        } else {
            $this->Currency->recursive = 0;
            $this->set('currencies', $this->Paginator->paginate());
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
    public function view($id = null) {
        $this->setTimeActif();

        if (!$this->Currency->exists($id)) {
            throw new NotFoundException(__('Invalid currency.'));
        }
        $options = array('conditions' => array('Currency.' . $this->Currency->primaryKey => $id));
        $this->set('currency', $this->Currency->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();
        //$this->verifyAuditor("CustomerCategories");
        $this->verifySuperAdministrator();
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Currency->create();
            if ($this->Currency->save($this->request->data)) {

                $this->Flash->success(__('The currency has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The currency could not be saved. Please, try again.'));
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
    public function edit($id = null) {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $this->verifySuperAdministrator();
        if (!$this->Currency->exists($id)) {
            throw new NotFoundException(__('Invalid currency.'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Currency cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            if ($this->Currency->save($this->request->data)) {

                $this->Flash->success(__('The currency has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The currency could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Currency.' . $this->Currency->primaryKey => $id));
            $this->request->data = $this->Currency->find('first', $options);
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $this->verifySuperAdministrator();
        $this->Currency->id = $id;
        if (!$this->Currency->exists()) {
            throw new NotFoundException(__('Invalid currency.'));
        }

        $this->request->allowMethod('post', 'delete');
        if ($this->Currency->delete()) {

            $this->Flash->success(__('The currency has been deleted.'));
        } else {

            $this->Flash->error(__('The currency could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteCurrencies() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $this->verifySuperAdministrator();
        $this->Currency->id = $id;
        $this->request->allowMethod('post', 'delete');
        if($this->Currency->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }

    }









}