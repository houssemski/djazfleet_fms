<?php

App::uses('AppController', 'Controller');

/**
 * EventTypes Controller
 *
 * @property Transit $Transit
 * @property Supplier $Supplier
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class TransitsController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Security');
    public $uses = array('Transit', 'Supplier');
    var $helpers = array('Xls', 'Tinymce');

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $userId = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::feuille_de_route, $userId, ActionsEnum::view, "Transits",
            null, "Transit", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        //Parametrer la pagination

        switch ($result) {
            case 1 :

                $conditions = array('Transit.id > ' => 0);
                break;
            case 2 :
                $conditions = array('Transit.id > ' => 0, 'Transit.user_id ' => $userId);
                break;
            case 3 :
                $conditions = array('Transit.id > ' => 0, 'Transit.user_id !=' => $userId);
                break;

            default:
                $conditions = array('Transit.id > ' => 0);;
        }
        $this->paginate = array(
            'limit' => $limit,
            'recursive'=>-1,
            'order' => array('Transit.reference' => 'ASC'),
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'fields'=>array(
                'Supplier.name',
                'Transit.id',
                'Transit.importer',
                'Transit.invoice_importer',
                'Transit.reference',
                'Transit.comp_maritime',
                'Transit.num_declaration',
                'Transit.date_declaration',
            ),
            'joins'=>array(
                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Supplier.id = Transit.supplier_id')
                ),


            )
        );

        $transits = $this->Paginator->paginate('Transit');
        $this->set('transits', $transits);
        $this->set(compact('limit'));
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

        if (isset($this->params['named']['keyword'])) {

            $keyword = $this->params['named']['keyword'];
            $conditions = array( 'OR' => array(
                "LOWER(Transit.id) LIKE" => "%$keyword%",
                "LOWER(Supplier.name) LIKE" => "%$keyword%",
                "LOWER(Transit.reference) LIKE" => "%$keyword%",
            ));
            $this->paginate = array(
                'limit' => $limit,
                'recursive'=>-1,
                'order' => array('Transit.reference' => 'ASC'),
                'conditions' => $conditions,
                'paramType' => 'querystring',
                'fields'=>array(
                    'Supplier.name',
                    'Transit.id',
                    'Transit.importer',
                    'Transit.invoice_importer',
                    'Transit.reference',
                    'Transit.comp_maritime',
                    'Transit.num_declaration',
                    'Transit.date_declaration',
                ),
                'joins'=>array(
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('Supplier.id = Transit.supplier_id')
                    ),


                )
            );

            $transits = $this->Paginator->paginate('Transit');
            $this->set('transits', $transits);


        } else {
            $this->paginate = array(
                'limit' => $limit,
                'recursive'=>-1,
                'order' => array('Transit.reference' => 'ASC'),

                'paramType' => 'querystring',
                'fields'=>array(
                    'Supplier.name',
                    'Transit.id',
                    'Transit.importer',
                    'Transit.invoice_importer',
                    'Transit.reference',
                    'Transit.comp_maritime',
                    'Transit.num_declaration',
                    'Transit.date_declaration',
                ),
                'joins'=>array(
                    array(
                        'table' => 'suppliers',
                        'type' => 'left',
                        'alias' => 'Supplier',
                        'conditions' => array('Supplier.id = Transit.supplier_id')
                    ),


                )
            );

            $transits = $this->Paginator->paginate('Transit');
            $this->set('transits', $transits);
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
        if (!$this->Transit->exists($id)) {
            throw new NotFoundException(__('Invalid absence.'));
        }
        $options = array('conditions' => array('Transit.' . $this->Transit->primaryKey => $id));
        $transit = $this->Transit->find('first', $options);
        $this->set('transit', $transit);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        $this->setTimeActif();
        $userId = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::feuille_de_route, $userId, ActionsEnum::add, "Transits", null,
            "Transit", null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }


        if ($this->request->is('post')) {
             $this->Transit->create();
            $this->request->data['Transit']['user_id'] = $this->Session->read('Auth.User.id');
            $this->createDateFromDate('Transit', 'date_declaration');
            if ($this->Transit->save($this->request->data)) {
                $this->Flash->success(__('The transit has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The transit could not be saved. Please, try again.'));
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
        $this->verifyUserPermission(SectionsEnum::feuille_de_route, $user_id, ActionsEnum::edit, "Transits", $id,
            "Transit", null);
        if (!$this->Transit->exists($id)) {
            throw new NotFoundException(__('Invalid transit.'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Transit cancelled.'));
                $this->redirect(array('action' => 'index'));
            }


            $this->request->data['Transit']['modified_id'] = $this->Session->read('Auth.User.id');
            $this->createDateFromDate('Transit', 'date_declaration');
            if ($this->Transit->save($this->request->data)) {
                $this->Flash->success(__('The transit has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The transit could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Transit.' . $this->Transit->primaryKey => $id));
            $this->request->data = $this->Transit->find('first', $options);

            $suppliers = $this->Supplier->getSuppliersById($this->request->data['Transit']['supplier_id'],'list');

            $this->set(compact('suppliers'));

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
        $this->verifyUserPermission(SectionsEnum::feuille_de_route, $user_id, ActionsEnum::delete, "Transits", $id,
            "Transit", null);
        $this->Transit->id = $id;
        if (!$this->Transit->exists()) {
            throw new NotFoundException(__('Invalid transit.'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Transit->delete()) {
            $this->Flash->success(__('The transit has been deleted.'));
        } else {
            $this->Flash->error(__('The transit could not be deleted. Please, try again.'));
        }

        $this->redirect(array('action' => 'index'));
    }


    public function deleteTransits()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::feuille_de_route, $user_id, ActionsEnum::delete, "Transits", $id,
            "Transit", null);
        $this->Transit->id = $id;
        $this->request->allowMethod('post', 'delete');
        if ($this->Transit->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }

    }


}
