<?php

/**
 * @property PaginatorComponent $paginate
 */

App::uses('AppController', 'Controller');

class StructuresController extends AppController{

    public $components = array('Paginator', 'Session', 'Security');
    public function index() {
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::categorie_vehicule, $user_id, ActionsEnum::view, "CarCategories", null, "CarCategory" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Structures.code' => 'ASC'),
            'Structures.name' => 'ASC',
            'paramType' => 'querystring'
        );

        $this->Structures->recursive = 0;
        $this->set('structures', $this->Paginator->paginate());
        $this->set(compact('limit'));
    }

    public function view($id = null) {
        $this->setTimeActif();

        if (!$this->Structures->exists($id)) {
            throw new NotFoundException(__('Invalid customer service'));
        }
        $options = array('conditions' => array('Structures.' . $this->Structures->primaryKey => $id));
        $this->set('structure', $this->Structures->find('first', $options));
    }

    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::service, $user_id, ActionsEnum::add,
            "Services", null, "Service" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error( __('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Structures->create();
            if ($this->Structures->save($this->request->data)) {

                $this->Flash->success(__('The service has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The service could not be saved. Please, try again.'));
            }
        }
    }

    public function edit($id = null) {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::service, $user_id, ActionsEnum::edit,
            "Services", $id, "Service" ,null);
        if (!$this->Structures->exists($id)) {
            throw new NotFoundException(__('Invalid service'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {

                $this->Flash->error(__('Changes were not saved. Service cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            if ($this->Structures->save($this->request->data)) {

                $this->Flash->success(__('The structure has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Flash->error(__('The structure could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Structures.' . $this->Structures->primaryKey => $id));
            $this->request->data = $this->Structures->find('first', $options);
        }
    }

    public function delete($id = null) {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::service, $user_id, ActionsEnum::delete,
            "Services", $id, "Service" ,null);
        $this->Structures->id = $id;
        if (!$this->Structures->exists()) {
            throw new NotFoundException(__('Invalid Structure'));
        }

        $this->request->allowMethod('post', 'delete');
        if ($this->Structures->delete()) {

            $this->Flash->success(__('The structure has been deleted.'));
        } else {

            $this->Flash->error(__('The structure could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }
}