<?php
/**
 * Created by PhpStorm.
 * User: Kahina
 * Date: 30-12-2019
 * Time: 15:54
 */


App::uses('AppController', 'Controller');
class NationalitiesController extends AppController {


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
                    $order = array('Nationality.abr' => $orderType);
                    break;
                case 2 :
                    $order = array('Nationality.name' => $orderType);
                    break;
                case 3 :
                    $order = array('Nationality.id' => $orderType);
                    break;


                default : $order = array('Nationality.id' => $orderType);
            }
            return $order;
        } else {
            $order = array('Nationality.id' => $orderType);

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

        $this->Nationality->recursive = 0;
        $this->set('nationalities', $this->Paginator->paginate());
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
            'order' => array('Nationality.abr' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('nationalities', $this->Paginator->paginate('Nationality', array('OR' => array(
                "LOWER(Nationality.abr) LIKE" => "%$keyword%",
                "LOWER(Nationality.name) LIKE" => "%$keyword%"))));
        } else {
            $this->Nationality->recursive = 0;
            $this->set('nationalities', $this->Paginator->paginate());
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

        if (!$this->Nationality->exists($id)) {
            throw new NotFoundException(__('Invalid country.'));
        }
        $options = array('conditions' => array('Nationality.' . $this->Nationality->primaryKey => $id));
        $this->set('nationality', $this->Nationality->find('first', $options));
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
            $this->Nationality->create();
            if ($this->Nationality->save($this->request->data)) {

                $this->Flash->success(__('The country has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The country could not be saved. Please, try again.'));
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
        $this->verifySuperAdministrator();
        if (!$this->Nationality->exists($id)) {
            throw new NotFoundException(__('Invalid country.'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Country cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            if ($this->Nationality->save($this->request->data)) {

                $this->Flash->success(__('The country has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The country could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Nationality.' . $this->Nationality->primaryKey => $id));
            $this->request->data = $this->Nationality->find('first', $options);
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
        $this->verifySuperAdministrator();
        $this->Nationality->id = $id;
        if (!$this->Nationality->exists()) {
            throw new NotFoundException(__('Invalid country.'));
        }

        $this->request->allowMethod('post', 'delete');
        if ($this->Nationality->delete()) {

            $this->Flash->success(__('The country has been deleted.'));
        } else {

            $this->Flash->error(__('The country could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteNationalities() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $this->verifySuperAdministrator();
        $this->Nationality->id = $id;
        $this->request->allowMethod('post', 'delete');
        if($this->Nationality->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }

    }









}