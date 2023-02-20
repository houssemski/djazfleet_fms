<?php
App::uses('AppController', 'Controller');

/**
 * Verifications Controller
 *
 * @property Verification $Verification
 * @property Tire $Tire
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class VerificationsController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Security');
    public $uses = array('Verification', 'Tire');

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();

        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::verification_pneu, $user_id, ActionsEnum::view,
            "Verifications", null, "Verification", null);
        switch ($result) {
            case 1 :
                $conditions = null;

                break;
            case 2 :
                $conditions = array('Verification.user_id ' => $user_id);

                break;
            case 3 :

                $conditions = array('Verification.user_id !=' => $user_id);

                break;

            default:
                $conditions = null;


        }
        $this->paginate = array(
            'limit' => $limit,
            'conditions' => $conditions,
            'recursive' => -1,
            'paramType' => 'querystring',
            'fields' => array(
                'reference',
                'Verification.id',
                'date_verif',
                'km',
                'wear',
                'bande',
                'Tire.model',
            ),
            'joins' => array(
                array(
                    'table' => 'tires',
                    'type' => 'left',
                    'alias' => 'Tire',
                    'conditions' => array('Verification.tire_id = Tire.id')
                )
            )
        );

        $verifications = $this->Paginator->paginate();

        $this->set('verifications', $verifications);
        $this->set(compact('limit'));
    }

    public function search()
    {
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'],
                $this->request->params['action'], $this->request->data['keyword']);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Verification.reference' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('verifications', $this->Paginator->paginate('Verification', array('OR' => array(
                "LOWER(Verification.reference) LIKE" => "%$keyword%",
                "LOWER(Tire.model) LIKE" => "%$keyword%"))));
        } else {
            $this->Verification->recursive = 0;
            $this->set('verifications', $this->Paginator->paginate());
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
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        if (!$this->Verification->exists($id)) {
            throw new NotFoundException(__('Invalid Verification'));
        }
        $options = array('conditions' => array('Verification.' . $this->Verification->primaryKey => $id),
            'recursive' => -1,
            'paramType' => 'querystring',
            'fields' => array(
                'reference',
                'Verification.id',
                'date_verif',
                'km',
                'wear',
                'bande',
                'Tire.model',


            ),
            'joins' => array(


                array(
                    'table' => 'tires',
                    'type' => 'left',
                    'alias' => 'Tire',
                    'conditions' => array('Verification.tire_id = Tire.id')
                ),


            )
        );
        $this->set('verification', $this->Verification->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::verification_pneu, $user_id, ActionsEnum::add,
            "Verifications", null, "Verification", null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->Verification->create();
            $this->request->data['Verification']['user_id'] = $this->Session->read('Auth.User.id');
            $this->createDateFromDate('Verification', 'date_verif');
            if ($this->Verification->save($this->request->data)) {
                $this->Flash->success(__('The verification has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The verification could not be saved. Please, try again.'));
            }
        }

        $tires = $this->Tire->getTires();
        $this->set(compact('tires'));

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
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::verification_pneu, $user_id, ActionsEnum::edit,
            "Verifications", $id, "Verification", null);
        if (!$this->Verification->exists($id)) {
            throw new NotFoundException(__('Invalid verification'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Verification cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Verification']['modified_id'] = $this->Session->read('Auth.User.id');
            $this->createDateFromDate('Verification', 'date_verif');
            if ($this->Verification->save($this->request->data)) {
                $this->Flash->success(__('The verification has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The verification could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Verification.' . $this->Verification->primaryKey => $id));
            $this->request->data = $this->Verification->find('first', $options);


            $tires = $this->Tire->getTires();
            $this->set(compact('tires'));

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
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::verification_pneu, $user_id, ActionsEnum::delete,
            "Verifications", $id, "Verification", null);
        $this->Verification->id = $id;
        if (!$this->Verification->exists()) {
            throw new NotFoundException(__('Invalid verification'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Verification->delete()) {
            $this->Flash->success(__('The verification has been deleted.'));
        } else {
            $this->Flash->error(__('The verification could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteverifications()
    {
        $stock = $this->hasModuleStock();
        if ($stock == 0) {
            return $this->redirect('/');
        }
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');

        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $this->verifyUserPermission(SectionsEnum::verification_pneu, $user_id, ActionsEnum::delete,
            "Verifications", $id, "Verification", null);

        $this->Verification->id = $id;

        $this->request->allowMethod('post', 'delete');
        if ($this->Verification->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }
        /*}else{
        echo json_encode(array("response" => "false"));
        }*/
    }


}
