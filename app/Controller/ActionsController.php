<?php

App::uses('AppController', 'Controller');


class ActionsController extends AppController
{

    public function index($id=null) {
        $this->set('rubrics', $this->Action->find('all'));
        //die($id);
        $this->set('id_user',$id);


    }
    public function add($id_rubric = null, $id_user = null)
    {


        if ($this->request->is('post')) {

            $this->Action->create();

            $this->request->data['Action']['rubric_id'] = $id_rubric;
            $this->request->data['Action']['user_id'] = $id_user;


            if ($this->Action->save($this->request->data)) {
                $this->Flash->success(__('Your permissions have been saved.'));
                return $this->redirect(array('controller' => 'users', 'action' => 'index'));
            }
            $this->Flash->error(__('Can not save permissions'));
        }
    }


    public function edit($id_rubric = null, $id_user = null,$id=null)
    {

        $actions = $this->Action->find('first', array('conditions' => array('Action.rubric_id' =>$id_rubric,'Action.user_id' =>$id_user)));

        //die($actions);
        if (!$actions) {
            throw new NotFoundException(__('Invalid action'));
        }

        $id=$actions->id;
        //die($id);
        /*$action = $this->Action->findById($id);
        if (!$action) {
            throw new NotFoundException(__('Invalid action'));
        }*/

        if ($this->request->is(array('post', 'put'))) {
            $this->Action->id = $id;
            $this->Action->rubric_id = $id_rubric;
            $this->Action->user_id = $id_user;

            if ($this->Action->save($this->request->data)) {
                $this->Flash->success(('Your permissions have been changed.'));
                return $this->redirect(array('controller' => 'users','action' => 'index'));
            }
            $this->Flash->success(__('Can not change permissions.'));
        }

        if (!$this->request->data) {
          //  $this->request->data = $action;
        }
    }
}